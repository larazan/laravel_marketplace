<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use App\Models\LogActivity;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class LogActivityController extends Controller
{
    public function __construct() {
        // parent::__construct();

        $this->data['currentAdminMenu'] = 'general';
        $this->data['currentAdminSubMenu'] = 'logs';
    }

    public function index()
    {
        $this->data['logs'] = \LogActivity::logActivityLists();
        return view('admin.logs.index', $this->data);
    }
}
