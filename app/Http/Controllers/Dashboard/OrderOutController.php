<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrderOutController extends Controller
{
    public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
        $this->data['currentDashboardMenu'] = 'ordersout';
		$this->data['currentDashboardSubMenu'] = '';
		$this->data['statuses'] = Order::STATUSES;
	}

    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')
			->paginate(10);
        $this->data['orders'] = $orders;

        return $this->loadDashboard('orderout.index', $this->data);
    }

    public function received()
    {
        return $this->loadDashboard('orderout.received');
    }
}
