<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $this->initAdminMenu();
    }

    private function initAdminMenu() {
        $this->data['currentAdminMenu'] = 'dashboard';
        $this->data['currentAdminSubMenu'] = '';
    }

    protected function loadTheme($view, $data = [])
	{
		return view('frontend/'. $view, $data);
    }

    protected function loadDashboard($view, $data = [])
	{
		return view('backend/'. $view, $data);
    }
}
