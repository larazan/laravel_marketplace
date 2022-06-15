<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Carbon;

class ReceivedController extends Controller
{
    //

    public function index()
    {
        $this->data['time'] = Carbon::now()->timestamp; 
        return view('backend.orderout.received', $this->data);
    }

    public function final()
    {
        return view('frontend.orders.final');
    }
}
