<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
        $this->data['currentDashboardMenu'] = 'transactions';
		$this->data['currentDashboardSubMenu'] = '';
	}
    
    public function index() {
        return $this->loadDashboard('transactions.index', $this->data);
    }

    public function detail($id) {
        // $order = Order::withTrashed()->findOrFail($id);

		// $this->data['order'] = $order;

        return $this->loadDashboard('transactions.detail', $this->data);
    }
}
