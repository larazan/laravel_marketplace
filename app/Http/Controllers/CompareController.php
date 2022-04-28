<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompareController extends Controller
{
    //
    public function compare() 
    {
        return $this->loadTheme('compare.index');
    }

    public function compareStore(Request $request)
    {
        // $product_id = $request->input('product_id');
        // $product = Product::getProductByCart($product_id);
        // $price = $product[0]['offer_price'];
        // $compare_array = [];
        // foreach (Cart::instance('compare') as $item) {
        //     $compare_array[] = $item->id;
        // }
    }
}
