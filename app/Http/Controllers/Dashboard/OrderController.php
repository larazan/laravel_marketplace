<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductInventory;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
        $this->data['currentDashboardMenu'] = 'orders';
		$this->data['currentDashboardSubMenu'] = '';
		$this->data['statuses'] = Order::STATUSES;
	}
    
    public function index() {
        $orders = Order::orderBy('created_at', 'DESC')
			->paginate(10);

		$this->data['orders'] = $orders;

        return $this->loadDashboard('orders.index', $this->data);
    }

	public function index2(Request $request)
    {
        $orders = Order::orderBy('created_at', 'DESC');

		$q = $request->input('q');
		if ($q) {
			$orders = $orders->where('code', 'like', '%'. $q .'%')
				->orWhere('customer_first_name', 'like', '%'. $q .'%')
				->orWhere('customer_last_name', 'like', '%'. $q .'%');
		}


		if ($request->input('status') && in_array($request->input('status'), array_keys(Order::STATUSES))) {
			$orders = $orders->where('status', '=', $request->input('status'));
		}

		$startDate = $request->input('start');
		$endDate = $request->input('end');

		if ($startDate && !$endDate) {
			Session::flash('error', 'The end date is required if the start date is present');
			return redirect('admin/orders');
		}

		if (!$startDate && $endDate) {
			Session::flash('error', 'The start date is required if the end date is present');
			return redirect('admin/orders');
		}

		if ($startDate && $endDate) {
			if (strtotime($endDate) < strtotime($startDate)) {
				Session::flash('error', 'The end date should be greater or equal than start date');
				return redirect('admin/orders');
			}

			$order = $orders->whereRaw("DATE(order_date) >= ?", $startDate)
				->whereRaw("DATE(order_date) <= ? ", $endDate);
		}

		$this->data['orders'] = $orders->paginate(10);

		return $this->loadDashboard('orders.index', $this->data);
    }

	/**
	 * Display the specified orders.
	 * 
	 * @param int $id order ID
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function detail($id) {
        $order = Order::withTrashed()->findOrFail($id);

		$this->data['order'] = $order;

		$this->_setToOpened($id);

        return $this->loadDashboard('orders.detail', $this->data);
    }

	/**
	 * Display the trashed orders.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function trashed()
	{
		$orders = Order::forUser(Auth::user())
		->onlyTrashed()
		->orderBy('created_at', 'DESC')
		->paginate(10);

		// $this->data['orders'] = Order::onlyTrashed()->orderBy('created_at', 'DESC')->paginate(10);
		$this->data['orders'] = $orders;

		return $this->loadDashboard('orders.trashed', $this->data);
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

        return $this->loadDashboard('orders.detail', $this->data);
	}

    /**
	 * Display cancel order form
	 *
	 * @param int $id order ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function cancel($id)
	{
		$order = Order::where('id', $id)
			->whereIn('status', [Order::CREATED, Order::CONFIRMED])
			->firstOrFail();

		$this->data['order'] = $order;

		return $this->loadDashboard('orders.cancel', $this->data);
	}

	/**
	 * Doing the cancel process
	 *
	 * @param Request $request request params
	 * @param int     $id      order ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function doCancel(Request $request, $id)
	{
		$request->validate(
			[
				'cancellation_note' => 'required|max:255',
			]
		);

		$order = Order::findOrFail($id);
		
		$cancelOrder = DB::transaction(
			function () use ($order, $request) {
				$params = [
					'status' => Order::CANCELLED,
					'cancelled_by' => Auth::user()->id,
					'cancelled_at' => now(),
					'cancellation_note' => $request->input('cancellation_note'),
				];

				if ($cancelOrder = $order->update($params) && $order->orderItems->count() > 0) {
					foreach ($order->orderItems as $item) {
						ProductInventory::increaseStock($item->product_id, $item->qty);
					}
				}
				
				return $cancelOrder;
			}
		);

		Session::flash('success', 'The order has been cancelled');

		return redirect('user/orders');
	}

	/**
	 * Marking order as completed
	 *
	 * @param Request $request request params
	 * @param int     $id      order ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function doComplete(Request $request, $id)
	{
		$order = Order::findOrFail($id);
		
		if (!$order->isDelivered()) {
			Session::flash('error', 'Mark as complete the order can be done if the latest status is delivered');
			return redirect('user/orders');
		}

		$order->status = Order::COMPLETED;
		$order->approved_by = Auth::user()->id;
		$order->approved_at = now();
		
		if ($order->save()) {
			Session::flash('success', 'The order has been marked as completed!');
			return redirect('user/orders');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id order ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$order = Order::withTrashed()->findOrFail($id);

		if ($order->trashed()) {
			$canDestroy = DB::transaction(
				function () use ($order) {
					OrderItem::where('order_id', $order->id)->delete();
					$order->shipment->delete();
					$order->forceDelete();

					return true;
				}
			);

			if ($canDestroy) {
				Session::flash('success', 'The order has been removed permanently');
			} else {
				Session::flash('success', 'The order could not be removed permanently');
			}

			return redirect('user/orders/trashed');
		} else {
			$canDestroy = DB::transaction(
				function () use ($order) {
					if (!$order->isCancelled()) {
						foreach ($order->orderItems as $item) {
							ProductInventory::increaseStock($item->product_id, $item->qty);
						}
					};

					$order->delete();

					return true;
				}
			);
			
			if ($canDestroy) {
				Session::flash('success', 'The order has been removed');
			} else {
				Session::flash('success', 'The order could not be removed');
			}

			return redirect('user/orders');
		}
	}

	private function _setToOpened($update_id)
    {
        $order = Order::find($update_id);
        $order->opened_shopper = 1;
        $order->save();
    }
}
