<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;

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
        return $this->loadDashboard('orders.index', $this->data);
    }

    public function detail($id) {
        // $order = Order::withTrashed()->findOrFail($id);

		// $this->data['order'] = $order;

        return $this->loadDashboard('orders.detail', $this->data);
    }
}
