<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\Shipment;
use App\Models\Order;

class ShipmentController extends Controller
{
    //
    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
        $this->data['currentDashboardMenu'] = 'shipment';
		$this->data['currentDashboardSubMenu'] = '';
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipments = Shipment::join('orders', 'shipments.order_id', '=', 'orders.id')
			->where('orders.shop_id', Auth::user()->id)
			->whereRaw('orders.deleted_at IS NULL')
			->orderBy('shipments.created_at', 'DESC')->paginate(10);
		$this->data['shipments'] = $shipments;

		return $this->loadDashboard('shipments.index', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipment = Shipment::findOrFail($id);
		$this->data['shipment'] = $shipment;
		$this->data['provinces'] = $this->getProvinces();
		$this->data['cities'] = isset($shipment->province_id) ? $this->getCities($shipment->province_id) : [];

		return $this->loadDashboard('shipments.edit', $this->data);
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
        $request->validate(
			[
				'track_number' => 'required|max:255',
			]
		);
		
		$shipment = Shipment::findOrFail($id);

		$order = DB::transaction(
			function () use ($shipment, $request) {
				$shipment->track_number = $request->input('track_number');
				$shipment->status = Shipment::SHIPPED;
				$shipment->shipped_at = now();
				$shipment->shipped_by = Auth::user()->id;
				
				if ($shipment->save()) {
					$shipment->order->status = Order::DELIVERED;
					$shipment->order->save();
				}

				return $shipment->order;
			}
		);

		if ($order) {
			$this->_sendEmailOrderShipped($shipment->order);
		}

		Session::flash('success', 'The shipment has been updated');
		return redirect('user/orders/'. $order->id);
    }

    /**
	 * Sending order shipped email
	 *
	 * @param Order $order order object
	 *
	 * @return void
	 */
	private function _sendEmailOrderShipped($order)
	{
		\App\Jobs\SendMailOrderShipped::dispatch($order);
	}
}
