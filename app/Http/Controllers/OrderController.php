<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Helpers\Keranjang;

use App\Models\Order;
use App\Models\Product;
use App\Models\Basket;
use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\ProductInventory;
use App\Models\Capital;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Jobs\SendMailOrderReceived;
use App\Models\Shop;

class OrderController extends Controller
{
    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->pajakPersen = 11;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		$items = Basket::select(DB::raw("baskets.product_id, 
									baskets.id as id_basket,
									baskets.user_id, 
									baskets.qty, 
									baskets.is_checked, 
									products.name,
									products.price,
									products.weight,
									product_images.small as gambar, 
									shops.name as nama_toko,
									users.city_id
									"))
						->where('baskets.user_id', Auth::user()->id)
						->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
						->leftJoin('product_brands', 'product_brands.product_id', '=', 'products.id')
						->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
						->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
						->leftJoin('brands', 'brands.id', '=', 'product_brands.brand_id')
						->leftJoin('shops', 'shops.user_id', '=', 'products.user_id')
						->leftJoin('users', 'users.id', '=', 'products.user_id')
						->leftJoin(DB::raw('(SELECT MAX(id) as max_id, product_id FROM product_images GROUP BY product_id  )
							img'), 
						function($join)
						{
						$join->on('products.id', '=', 'img.product_id');
						})
						->join('product_images', 'product_images.id', 'img.max_id')
						->whereNull('baskets.deleted_at')
						->where('baskets.is_checked', 1)
						->get();

		$this->_updateTax();				
		$this->data['orders'] = $items;
		// 

		$this->data['totalWeight'] = $this->_getTotalWeight() / 1000;
		$this->data['tax'] = $this->_getTax();

		$this->data['provinces'] = $this->getProvinces();
		$this->data['cities'] = isset(Auth::user()->province_id) ? $this->getCities(Auth::user()->province_id) : [];
		$this->data['user'] = Auth::user();

		return $this->loadTheme('orders.checkout', $this->data);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id order ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$order = Order::forUser(Auth::user())->findOrFail($id);
		$this->data['order'] = $order;

		return $this->loadTheme('orders.show', $this->data);
	}

	/**
	 * Show the checkout page
	 *
	 * @return void
	 */
	public function checkout()
	{
		$items = Basket::select(DB::raw("baskets.product_id, 
									baskets.id as id_basket,
									baskets.user_id, 
									baskets.qty, 
									baskets.is_checked, 
									products.name,
									products.price,
									products.weight,
									product_images.small as gambar, 
									shops.name as nama_toko,
									users.city_id
									"))
						->where('baskets.user_id', Auth::user()->id)
						->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
						->leftJoin('product_brands', 'product_brands.product_id', '=', 'products.id')
						->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
						->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
						->leftJoin('brands', 'brands.id', '=', 'product_brands.brand_id')
						->leftJoin('shops', 'shops.user_id', '=', 'products.user_id')
						->leftJoin('users', 'users.id', '=', 'products.user_id')
						->leftJoin(DB::raw('(SELECT MAX(id) as max_id, product_id FROM product_images GROUP BY product_id  )
							img'), 
						function($join)
						{
						$join->on('products.id', '=', 'img.product_id');
						})
						->join('product_images', 'product_images.id', 'img.max_id')
						->whereNull('baskets.deleted_at')
						->where('baskets.is_checked', 1)
						->get();

		$this->_updateTax();				
		$this->data['orders'] = $items;
		// 

		$this->data['totalWeight'] = $this->_getTotalWeight() / 1000;
		$this->data['tax'] = $this->_getTax();

		$this->data['provinces'] = $this->getProvinces();
		$this->data['cities'] = isset(Auth::user()->province_id) ? $this->getCities(Auth::user()->province_id) : [];
		$this->data['user'] = Auth::user();

		return $this->loadTheme('orders.checkout', $this->data);
	}
    
    //
    /**
	 * Get cities by province ID
	 *
	 * @param Request $request province id
	 *
	 * @return json
	 */
	public function cities(Request $request)
	{
		// print('bla');
		$cities = $this->getCities($request->query('province_id'));
		return response()->json(['cities' => $cities]);
	}

	/**
	 * Calculate shipping cost
	 *
	 * @param Request $request shipping cost params
	 *
	 * @return array
	 */
	public function shippingCost(Request $request)
	{
		$destination = $request->input('city_id');
		// $origin = $request->input('city_origin');
		
		return $this->_getShippingCost($destination, $this->_getTotalWeight());
	}

	/**
	 * Set shipping cost
	 *
	 * @param Request $request selected shipping cost
	 *
	 * @return string
	 */
	public function setShipping(Request $request)
	{
		// \Cart::removeConditionsByType('shipping');

		$shippingService = $request->get('shipping_service');
		$destination = $request->get('city_id');

		$shippingOptions = $this->_getShippingCost($destination, $this->_getTotalWeight());

		$selectedShipping = null;
		if ($shippingOptions['results']) {
			foreach ($shippingOptions['results'] as $shippingOption) {
				if (str_replace(' ', '', $shippingOption['service']) == $shippingService) {
					$selectedShipping = $shippingOption;
					break;
				}
			}
		}

		$status = null;
		$message = null;
		$data = [];
		if ($selectedShipping) {
			$status = 200;
			$message = 'Success set shipping cost';

			$this->_addShippingCostToCart($selectedShipping['service'], $selectedShipping['cost']);

			$tax = 11 / 100;
			$pajak = Keranjang::getTotalChecked() * $tax;
			$total_belanja = Keranjang::getTotalChecked() + $pajak;
			$total = $total_belanja + $request->ongkir;

			// $data['total'] = number_format(\Cart::getTotal());
			$data['total'] = number_format($total);
		} else {
			$status = 400;
			$message = 'Failed to set shipping cost';
		}

		$response = [
			'status' => $status,
			'message' => $message
		];

		if ($data) {
			$response['data'] = $data;
		}

		return $response;
	}

	/**
	 * Get selected shipping from user input
	 *
	 * @param int    $destination     destination city
	 * @param int    $totalWeight     total weight
	 * @param string $shippingService service name
	 *
	 * @return array
	 */
	private function _getSelectedShipping($destination, $totalWeight, $shippingService)
	{
		$shippingOptions = $this->_getShippingCost($destination, $totalWeight);

		$selectedShipping = null;
		if ($shippingOptions['results']) {
			foreach ($shippingOptions['results'] as $shippingOption) {
				if (str_replace(' ', '', $shippingOption['service']) == $shippingService) {
					$selectedShipping = $shippingOption;
					break;
				}
			}
		}

		return $selectedShipping;
	}

	/**
	 * Apply shipping cost to cart data
	 *
	 * @param string $serviceName Service name
	 * @param float  $cost        Shipping cost
	 *
	 * @return void
	 */
	private function _addShippingCostToCart($serviceName, $cost)
	{
		// $condition = new \Darryldecode\Cart\CartCondition(
		// 	[
		// 		'name' => $serviceName,
		// 		'type' => 'shipping',
		// 		'target' => 'total',
		// 		'value' => '+'. $cost,
		// 	]
		// );

		// \Cart::condition($condition);

		Keranjang::getTotalChecked($serviceName, $cost);
	}

	/**
	 * Get shipping cost option from api
	 *
	 * @param string $destination destination city
	 * @param int    $weight      total weight
	 *
	 * @return array
	 */
	private function _getShippingCost($destination, $weight)
	{
		$params = [
			'origin' => Keranjang::getOrigin(),
			'destination' => $destination,
			'weight' => $weight,
		];

		$results = [];
		foreach ($this->couriers as $code => $courier) {
			$params['courier'] = $code;
			
			$response = $this->rajaOngkirRequest('cost', $params, 'POST');
			
			if (!empty($response['rajaongkir']['results'])) {
				foreach ($response['rajaongkir']['results'] as $cost) {
					if (!empty($cost['costs'])) {
						foreach ($cost['costs'] as $costDetail) {
							$serviceName = strtoupper($cost['code']) .' - '. $costDetail['service'];
							$costAmount = $costDetail['cost'][0]['value'];
							$etd = $costDetail['cost'][0]['etd'];

							$result = [
								'service' => $serviceName,
								'cost' => $costAmount,
								'etd' => $etd,
								'courier' => $code,
							];

							$results[] = $result;
						}
					}
				}
			}
		}

		$response = [
			'origin' => $params['origin'],
			'destination' => $destination,
			'weight' => $weight,
			'results' => $results,
		];
		
		return $response;
	}

	/**
	 * Get total of order items
	 *
	 * @return int
	 */
	private function _getTotalWeight()
	{
		$totalWeight = 0;
		
		$items = Basket::select(DB::raw("baskets.product_id, 
									baskets.id as id_basket,
									baskets.user_id, 
									baskets.qty, 
									baskets.is_checked, 
									products.weight
									"))
						->where('baskets.user_id', Auth::user()->id)
						->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
						->whereNull('baskets.deleted_at')
						->where('baskets.is_checked', 1)
						->get();

		foreach ($items as $item) {
			$totalWeight += ($item->qty * $item->weight);
		}

		return $totalWeight;
	}

	private function _getTax()
	{
		$tax = $this->pajakPersen / 100;
		$subtotal = 0;
		$items = Basket::select(DB::raw("baskets.product_id, 
									baskets.id as id_basket,
									baskets.user_id, 
									baskets.qty, 
									baskets.is_checked, 
									products.price
									"))
						->where('baskets.user_id', Auth::user()->id)
						->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
						->whereNull('baskets.deleted_at')
						->where('baskets.is_checked', 1)
						->get();

		foreach ($items as $item) {
			$subtotal += ($item->qty * $item->price);
		}

		$totalTax = $subtotal * $tax;

		return $totalTax;
	}

	/**
	 * Update tax to the order
	 *
	 * @return void
	 */
	private function _updateTax()
	{
	// 	\Cart::removeConditionsByType('tax');

	// 	$condition = new \Darryldecode\Cart\CartCondition(
	// 		[
	// 			'name' => 'TAX 10%',
	// 			'type' => 'tax',
	// 			'target' => 'total',
	// 			'value' => '10%',
	// 		]
	// 	);

	// 	\Cart::condition($condition);
		$serviceName = null; 
		$cost = 0;

		Keranjang::getTotalChecked($serviceName, $cost, $this->_getTax());
	}

	/**
	 * Checkout process and saving order data
	 *
	 * @param OrderRequest $request order data
	 *
	 * @return void
	 */
	public function doCheckout(OrderRequest $request)
	{
		$params = $request->except('_token');

		$order = DB::transaction(
			function () use ($params) {
				$order = $this->_saveOrder($params);
				$this->_saveOrderItems($order);
				// $this->_generatePaymentToken($order);
				$this->_saveShipment($order, $params);
	
				return $order;
			}
		);

		if ($order) {
			// \Cart::clear();
			Keranjang::clear();
			// $this->_sendEmailOrderReceived($order);
			// $this->_sendEmailOrderRequest($order);

			Session::flash('success', 'Thank you. Your order has been received!');
			return redirect('orders/final/'. $order->id);
			// return redirect('orders/received/'. $order->id);
		}

		return redirect('orders');
	}

	/**
	 * Generate payment token
	 *
	 * @param Order $order order data
	 *
	 * @return void
	 */
	private function _generatePaymentToken($order)
	{
		$this->initPaymentGateway();

		$customerDetails = [
			'first_name' => $order->customer_first_name,
			'last_name' => $order->customer_last_name,
			'email' => $order->customer_email,
			'phone' => $order->customer_phone,
		];

		$params = [
			'enable_payments' => \App\Models\Payment::PAYMENT_CHANNELS,
			'transaction_details' => [
				'order_id' => $order->code,
				'gross_amount' => $order->grand_total,
			],
			'customer_details' => $customerDetails,
			'expiry' => [
				'start_time' => date('Y-m-d H:i:s T'),
				'unit' => \App\Models\Payment::EXPIRY_UNIT,
				'duration' => \App\Models\Payment::EXPIRY_DURATION,
			],
		];

		$snap = \Midtrans\Snap::createTransaction($params);
		
		if ($snap->token) {
			$order->payment_token = $snap->token;
			$order->payment_url = $snap->redirect_url;
			$order->save();
		}
	}

	/**
	 * Save order data
	 *
	 * @param array $params checkout params
	 *
	 * @return Order
	 */
	private function _saveOrder($params)
	{
		$destination = isset($params['ship_to']) ? $params['shipping_city_id'] : $params['city_id'];
		$selectedShipping = $this->_getSelectedShipping($destination, $this->_getTotalWeight(), $params['shipping_service']);
		
		// add params shop id
		// $items = \Cart::getContent();
		$items = Keranjang::getItems();
		foreach ($items as $item) {
			// $product_id = $item->associatedModel->id;
			$product_id = $item->product_id;
		}
		$product = Product::active()->where('id', $product_id)->first();
		$shop_id = $product->shop_id;
		// $shop_id = $params['shop_id'];

		$baseTotalPrice = Keranjang::subTotalChecked();   // \Cart::getSubTotal();
		$taxAmount = Keranjang::pajak(); // \Cart::getCondition('TAX 10%')->getCalculatedValue(\Cart::getSubTotal());
		$taxPercent = (float) $this->pajakPersen; // \Cart::getCondition('TAX 10%')->getValue();
		$shippingCost = $selectedShipping['cost'];
		$discountAmount = 0;
		$discountPercent = 0;
		$grandTotal = ($baseTotalPrice + $taxAmount + $shippingCost) - $discountAmount;

		$orderDate = date('Y-m-d H:i:s');
		$paymentDue = (new \DateTime($orderDate))->modify('+7 day')->format('Y-m-d H:i:s');

		$orderParams = [
			'user_id' => Auth::user()->id,
			'code' => Order::generateCode(),
			'status' => Order::CREATED,
			'customer_id' => Auth::user()->id,
			'shop_id' => $shop_id,
			'order_date' => $orderDate,
			'payment_due' => $paymentDue,
			'payment_status' => Order::UNPAID,
			'base_total_price' => $baseTotalPrice,
			'tax_amount' => $taxAmount,
			'tax_percent' => $taxPercent,
			'discount_amount' => $discountAmount,
			'discount_percent' => $discountPercent,
			'shipping_cost' => $shippingCost,
			'grand_total' => $grandTotal,
			'note' => $params['note'],
			'customer_first_name' => $params['first_name'],
			'customer_last_name' => $params['last_name'],
			// 'customer_company' => $params['company'],
			'customer_address1' => $params['address1'],
			// 'customer_address2' => $params['address2'],
			'income_rank' => $this->_rank($baseTotalPrice),
			'customer_phone' => $params['phone'],
			'customer_email' => $params['email'],
			'customer_city_id' => $params['city_id'],
			'customer_province_id' => $params['province_id'],
			'customer_postcode' => $params['postcode'],
			'shipping_courier' => $selectedShipping['courier'],
			'shipping_service_name' => $selectedShipping['service'],
		];

		return Order::create($orderParams);
	}

	/**
	 * Save order items
	 *
	 * @param Order $order order object
	 *
	 * @return void
	 */
	private function _saveOrderItems($order)
	{
		$cartItems = Keranjang::getItems(); // \Cart::getContent();

		if ($order && $cartItems) {
			foreach ($cartItems as $item) {
				$itemTaxAmount = 0;
				$itemTaxPercent = 0;
				$itemDiscountAmount = 0;
				$itemDiscountPercent = 0;
				$itemBaseTotal = $item->qty * $item->price;
				$itemSubTotal = $itemBaseTotal + $itemTaxAmount - $itemDiscountAmount;

				$product = isset($item->associatedModel->parent) ? $item->associatedModel->parent : $item->associatedModel;

				$orderItemParams = [
					'order_id' => $order->id,
					'product_id' => $item->product_id,
					'qty' => $item->qty,
					'base_price' => $item->price,
					'base_total' => $itemBaseTotal,
					'tax_amount' => $itemTaxAmount,
					'tax_percent' => $itemTaxPercent,
					'discount_amount' => $itemDiscountAmount,
					'discount_percent' => $itemDiscountPercent,
					'sub_total' => $itemSubTotal,
					'sku' => $item->sku,
					'type' => $item->type,
					'name' => $item->name,
					'weight' => $item->weight,
					'attributes' => json_encode($item->attributes),
				];

				$orderItem = OrderItem::create($orderItemParams);
				
				if ($orderItem) {
					ProductInventory::reduceStock($orderItem->product_id, $orderItem->qty);
				}
			}
		}
	}

	/**
	 * Save shipment data
	 *
	 * @param Order $order  order object
	 * @param array $params checkout params
	 *
	 * @return void
	 */
	private function _saveShipment($order, $params)
	{
		$shippingFirstName = isset($params['ship_to']) ? $params['shipping_first_name'] : $params['first_name'];
		$shippingLastName = isset($params['ship_to']) ? $params['shipping_last_name'] : $params['last_name'];
		// $shippingCompany = isset($params['ship_to']) ? $params['shipping_company'] :$params['company'];
		$shippingAddress1 = isset($params['ship_to']) ? $params['shipping_address1'] : $params['address1'];
		// $shippingAddress2 = isset($params['ship_to']) ? $params['shipping_address2'] : $params['address2'];
		$shippingPhone = isset($params['ship_to']) ? $params['shipping_phone'] : $params['phone'];
		$shippingEmail = isset($params['ship_to']) ? $params['shipping_email'] : $params['email'];
		$shippingCityId = isset($params['ship_to']) ? $params['shipping_city_id'] : $params['city_id'];
		$shippingProvinceId = isset($params['ship_to']) ? $params['shipping_province_id'] : $params['province_id'];
		$shippingPostcode = isset($params['ship_to']) ? $params['shipping_postcode'] : $params['postcode'];

		$shipmentParams = [
			'user_id' => Auth::user()->id,
			'order_id' => $order->id,
			'status' => Shipment::PENDING,
			'total_qty' => Keranjang::totalCartItems(), // \Cart::getTotalQuantity(),
			'total_weight' => $this->_getTotalWeight(),
			'first_name' => $shippingFirstName,
			'last_name' => $shippingLastName,
			'address1' => $shippingAddress1,
			// 'address2' => $shippingAddress2,
			'phone' => $shippingPhone,
			'email' => $shippingEmail,
			'city_id' => $shippingCityId,
			'province_id' => $shippingProvinceId,
			'postcode' => $shippingPostcode,
		];

		Shipment::create($shipmentParams);
	}

	/**
	 * Send email order detail to current user
	 *
	 * @param Order $order order object
	 *
	 * @return void
	 */
	private function _sendEmailOrderReceived($order)
	{
		\App\Jobs\SendMailOrderReceived::dispatch($order, Auth::user());

		// \App\Jobs\SendMailOrderReceived::dispatch($order, Auth::user())
		// ->delay(now()->addMinutes(1));
	}

	/**
	 * Send email order detail to shopper
	 *
	 * @param Order $order order object
	 *
	 * @return void
	 */
	private function _sendEmailOrderRequest($order)
	{
		

		$shop = Shop::findOrFail($order->shop_id);
		$user = $shop->user;
		$cs = env('CS_EMAIL');
		$user_id = $shop->user->id;
		$user_mail = $shop->user->email;
		\App\Jobs\SendMailOrderRequest::dispatch($order, $user, $cs);
	}

	/**
	 * Show the received page for success checkout
	 *
	 * @param int $orderId order id
	 *
	 * @return void
	 */
	public function final($orderId)
	{
		$this->data['order'] = Order::where('id', $orderId)
			->where('user_id', Auth::user()->id)
			->firstOrFail();

		return $this->loadTheme('orders/final', $this->data);
	}

	public function deleteItems()
	{
		Keranjang::clear();

		echo 'clear ok';
	}

	private function _rank($nomi)
    {
        $capitals = Capital::get();

        foreach ($capitals as $capital) {
            if (($nomi >= (int)$capital->mini) && ($nomi <= (int)$capital->maxi)) 
			{ 
				$r = (int)$capital->rank;
			}
        }

        return $r;
    }
}
