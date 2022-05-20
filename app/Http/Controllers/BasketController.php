<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;
use App\Models\ProductInventory;
use App\Models\Basket;

use Illuminate\Support\Facades\Session; 
use App\Exceptions\OutOfStockException;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->except('_token');
		
		$product = Product::findOrFail($params['product_id']);
		$slug = $product->slug;

        $attributes = [];
		if ($product->configurable()) {
			$product = Product::from('products as p')
				->whereRaw(
					"p.parent_id = :parent_product_id
				and (select pav.text_value 
						from product_attribute_values pav
						join attributes a on a.id = pav.attribute_id
						where a.code = :size_code
						and pav.product_id = p.id
						limit 1
					) = :size_value
				and (select pav.text_value 
						from product_attribute_values pav
						join attributes a on a.id = pav.attribute_id
						where a.code = :color_code
						and pav.product_id = p.id
						limit 1
					) = :color_value
					",
					[
						'parent_product_id' => $product->id,
						'size_code' => 'size',
						'size_value' => $params['size'],
						'color_code' => 'color',
						'color_value' => $params['color'],
					]
				)->firstOrFail();

			$attributes['size'] = $params['size'];
			$attributes['color'] = $params['color'];
		}

		$this->_checkProductInventory($product, $params['qty']);
		
		$item = [
			'id' => md5($product->id),
			'name' => $product->name,
			'price' => $product->price,
			'quantity' => $params['qty'],
			'attributes' => $attributes,
			'associatedModel' => $product,
		];

        if (Basket::create($item)) {
            Session::flash('success', 'Product '. $item['name'] .' has been added to cart');
        } else {
            Session::flash('error', 'Product '. $item['name'] .' couldnt been added to cart');
        }
        
		return redirect('/product/'. $slug);
    }

	/**
	 * Check product inventory
	 *
	 * @param Product $product      product object
	 * @param int     $itemQuantity qty
	 *
	 * @return int
	 */
	private function _checkProductInventory($product, $itemQuantity)
	{
		if ($product->productInventory->qty < $itemQuantity) {
			throw new \App\Exceptions\OutOfStockException('The product '. $product->sku .' is out of stock');
		}
	}

	/**
	 * Get cart item by card item id
	 *
	 * @param string $cartID cart ID
	 *
	 * @return array
	 */
	private function _getCartItem($cartID)
	{
		$items = \Cart::getContent();

		return $items[$cartID];
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->except('_token');

		if ($items = $params['items']) {
			foreach ($items as $cartID => $item) {
				$cartItem = $this->_getCartItem($cartID);
				$this->_checkProductInventory($cartItem->associatedModel, $item['quantity']);

				\Cart::update(
					$cartID,
					[
						'quantity' => [
							'relative' => false,
							'value' => $item['quantity'],
						],
					]
				);
			}

			Session::flash('success', 'The cart has been updated');
			return redirect('carts');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
