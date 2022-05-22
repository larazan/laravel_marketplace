<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;
use App\Models\Baskets;
use App\Models\ProductInventory;

use Illuminate\Support\Facades\Session; 
use App\Exceptions\OutOfStockException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // $items = \Cart::getContent();
		// $items = Baskets::where('user_id', Auth::user()->id)->whereNull('deleted_at')->get();
		// dd($items);
        // var_dump($items); exit;
		$this->data['items'] =  '';

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
		
		$item = [
			'id' => md5($product->id),
			'name' => $product->name,
			'price' => $product->price,
			'quantity' => $params['qty'],
			'attributes' => $attributes,
			'associatedModel' => $product,
		];

		\Cart::add($item);

		Session::flash('success', 'Product '. $item['name'] .' has been added to cart');
		return redirect('/product/'. $slug);
    }

	public function addCart(Request $request)
	{
		$cek_basket = Baskets::where('product_id', $request->product_id)
								->where('user_id', Auth::user()->id )
								->whereNull('deleted_at')
								->first();

		$cek_toko   = Product::where('id', $request->product_id)->first();

		if ($cek_toko->user_id == Auth::user()->id) {
			$responseCode = 304;
			$responseData['status'] = false;
			$responseData['message'] = 'Yaahh.. sayang sekali, anda tidak bisa membeli produk dari toko anda !';
		} else {
			DB::beginTransaction();
			if ($cek_basket) {
				$cek_basket->qty = $cek_basket->qty + $request->qty;
				$cek_basket->save();
				$responseCode = 200;
				$responseData['status'] = true;
				$responseData['message'] = 'Yeaah.. berhasil menambahkan jumlah produk !';

				DB::commit();
			} else {
				$data = new Baskets;
				$data->product_id = $request->product_id;
				$data->user_id = Auth::user()->id;
				$data->qty = $request->qty;
				$data->is_checked = 1;

				$data->save();
				$responseCode = 200;
				$responseData['status'] = true;
				$responseData['message'] = 'Yeaah.. Berhasil menambahkan produk ke keranjang !';

				DB::commit();
			}
		}
		
		

		$response = \General::helpResponse($responseCode, $responseData);
		return response()->json($response);

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

		return redirect('carts');
    }

	public function addProduct($id, Request $request)
	{
		dd($id);
	}

	public function listProduk(Request $reqest)
	{
		$items = Baskets::select(DB::raw("baskets.product_id, 
										baskets.id as id_basket,
										baskets.user_id, 
										baskets.qty, 
										baskets.is_checked, 
										products.name,
										products.price,
										product_images.small as gambar, 
										shops.name as nama_toko
										"))
							->where('baskets.user_id', Auth::user()->id)
							->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
							->leftJoin('product_brands', 'product_brands.product_id', '=', 'products.id')
							->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
							->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
							->leftJoin('brands', 'brands.id', '=', 'product_brands.brand_id')
							->leftJoin('shops', 'shops.user_id', '=', 'products.user_id')
							->leftJoin(DB::raw('(SELECT MAX(id) as max_id, product_id FROM product_images GROUP BY product_id  )
								img'), 
							function($join)
							{
							$join->on('products.id', '=', 'img.product_id');
							})
							->join('product_images', 'product_images.id', 'img.max_id')
							->whereNull('baskets.deleted_at')
							->get();
		$responseData['produk'] = $items;
		$responseCode = 200;

		$response = \General::helpResponse($responseCode, $responseData);
		return response()->json($response, $responseCode);
	}

	public function deleteList(Request $request)
	{
		$baskets = Baskets::findOrFail($request->id);

		DB::beginTransaction();
		try {
			$baskets->delete();
			DB::commit();
			$responseCode = 200;
			$responseData['status'] = true;
			$responseData['message'] = 'Yeaah.. berhasil mengeluarkan produk dari keranjang !';
        } catch (Exception $e) {
            DB::rollBack();
            $responseCode = 304;
			$responseData['status'] = false;
			$responseData['message'] = 'Gagal mengeluarkan produk dari keranjang !';
        }

		$response = \General::helpResponse($responseCode, $responseData);
		return response()->json($response, $responseCode);
	}

	public function editQty(Request $request)
	{
		$baskets = Baskets::findOrFail($request->id);

		DB::beginTransaction();
		try {
			$baskets->qty = $request->qty;
			$baskets->save();
			DB::commit();
			$responseCode = 200;
			$responseData['status'] = true;
			$responseData['message'] = 'Yeaah.. berhasil mengupdate jumlah barang !';
        } catch (Exception $e) {
            DB::rollBack();
            $responseCode = 304;
			$responseData['status'] = false;
			$responseData['message'] = 'Gagal mengeluarkan mengupdate jumlah barang !';
        }

		$response = \General::helpResponse($responseCode, $responseData);
		return response()->json($response, $responseCode);
	}
}
