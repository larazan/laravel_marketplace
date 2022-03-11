<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Slide;

class HomeController extends Controller
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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
	{
        $limit = 10;
		// $products = Product::popular()->get();
        // $this->data['products'] = $products;
        $products = Product::active()->orderBy('id', 'DESC')->limit($limit)->get();
        $this->data['products'] = $products;

		$slides = Slide::active()->orderBy('position', 'DESC')->get();
        $this->data['slides'] = $slides;
        
        // $this->data['hoax'] = '';

		return $this->loadTheme('home', $this->data);
	}
}
