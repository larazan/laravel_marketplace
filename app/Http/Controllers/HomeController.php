<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Slide;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['categories'] = Category::parentCategories()
			->orderBy('name', 'DESC')
			->get();
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

        return $this->loadTheme('home', $this->data);
    }
}
