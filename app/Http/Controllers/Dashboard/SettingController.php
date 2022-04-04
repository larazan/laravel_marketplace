<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
        $this->data['currentDashboardMenu'] = 'settings';
		$this->data['currentDashboardSubMenu'] = '';
	}
    
    public function index() {
        return $this->loadDashboard('settings.index', $this->data);
    }
}
