<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Product;
use App\Models\Order;
use App\Models\Basket;
use App\Models\Shop;
use App\Models\ProductInventory;

use Illuminate\Support\Facades\Session; 
use App\Exceptions\OutOfStockException;

class CartController extends Controller
{
    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = \Cart::getContent();
		// dd($items);
		$this->data['items'] =  $items;

		return $this->loadTheme('carts.index', $this->data);
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
        // var_dump($params);exit;
		
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

		$itemQuantity =  $this->_getItemQuantity(md5($product->id)) + $params['qty'];
		$this->_checkProductInventory($product, $itemQuantity);
		
		$tim = Carbon::now()->timestamp;
		$ses = Session::getId();
		$userId = Auth::user()->id;
		$ip = request()->ip();

		$item = [
			'id' => md5($product->id . $userId . $ip),
			'name' => $product->name,
			'price' => $product->price,
			'quantity' => $params['qty'],
			'attributes' => $attributes,
			'associatedModel' => $product,
		];

		$item_cart = [
			'id' => md5($product->id . $userId . $ip),
			'session_id' => $ses,
			'name' => $product->name,
			'prod_id' => $product->id,
			'price' => $product->price,
			'quantity' => $params['qty'],
			'shop_id' => $product->shop->id,
			'customer_id' => $userId,
			'ip_address' => $ip,
			'attributes' => $attributes,
		];

		$productOwn = $this->_checkProductOwn($product->id);
		if ($productOwn == true) {
			Session::flash('error', 'Cannot buying own product');
			return redirect('/product/'. $slug);
		}

		\Cart::add($item);

		$productAlready = $this->_checkAlreadyIn($product->id);
		if ($productAlready == true) {
			// update basket
			$basket = Basket::find(md5($product->id));
			$basket->quantity = $params['qty'];
			$basket->attributes = $attributes;
			$basket->save();
			// Basket::updateOrCreate(['id' => md5($product->id)], ['quantity' => $params['qty']]);
		} else {
			Basket::create($item_cart);
		}

		Session::flash('success', 'Product '. $item['name'] .' has been added to cart');
		return redirect('/product/'. $slug);
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
	 * Get total quantity per item in the cart
	 *
	 * @param string $itemId item ID
	 *
	 * @return int
	 */
	private function _getItemQuantity($itemId)
	{
		$items = \Cart::getContent();
		$itemQuantity = 0;
		if ($items) {
			foreach ($items as $item) {
				if ($item->id == $itemId) {
					$itemQuantity = $item->quantity;
					break;
				}
			}
		}

		return $itemQuantity;
	}

	private function _checkAlreadyIn($product_id)
	{
		$userId = Auth::user()->id;
		$ip = request()->ip();
		$id = md5($product_id . $userId . $ip);
		$basket = Basket::findOrFail($id);
		if ($basket) {
			return true;
		}
	}

	private function _checkProductOwn($product_id) 
	{
		$product = Product::findOrFail($product_id);
		$shop_id = Shop::where('user_id', Auth::id())->first()->id;
		// $own = Product::active()->where('shop_id', $shop_id)->first();
		$own = $product->shop->id;

		if ($own == $shop_id) {
			return true;
		}
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
			throw new OutOfStockException('The product '. $product->sku .' is out of stock');
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

				Basket::updateOrCreate(['id' => $cartID], ['quantity' => $item['quantity']]);
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
	
        \Cart::remove($id);

		$basket = Basket::findOrFail($id);
		$basket->delete();

		return redirect('carts');
    }

	
}
