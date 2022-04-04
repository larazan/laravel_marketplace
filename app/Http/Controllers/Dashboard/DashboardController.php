<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
        $this->data['currentDashboardMenu'] = 'dashboard';
		$this->data['currentDashboardSubMenu'] = '';
	}

    public function index() {
        return $this->loadDashboard('home', $this->data);
    }
}
