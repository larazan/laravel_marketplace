<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;

use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
        $this->data['currentDashboardMenu'] = 'orders';
		$this->data['currentDashboardSubMenu'] = '';
	}
    
    public function index() {
        $orders = Order::forUser(Auth::user())
			->orderBy('created_at', 'DESC')
			->paginate(10);

		$this->data['orders'] = $orders;

		// return $this->loadTheme('orders.index', $this->data);
        return $this->loadDashboard('orders.index', $this->data);
    }

    public function detail($id) {
        // $order = Order::withTrashed()->findOrFail($id);

		// $this->data['order'] = $order;

        return $this->loadDashboard('orders.detail', $this->data);
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

		// return $this->loadTheme('orders.show', $this->data);
        return $this->loadDashboard('orders.detail', $this->data);
	}

    
}
