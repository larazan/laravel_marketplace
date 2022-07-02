<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Basket;
use App\Models\Capital;

class Keranjang
{
    public static function isEmpty()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $contents = Basket::where('user_id', $user_id)->first();
        } else {
            $session_id = Session::get('session_id');
            $contents = Basket::where('session_id', $session_id)->first();
        }

        if ($contents) {
            return false;
        } else {
            return true;
        }
    }

    public static function totalCartItems()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $totCartItems = Basket::where('user_id', $user_id)->sum('qty');
        } else {
            $session_id = Session::get('session_id');
            $totCartItems = Basket::where('session_id', $session_id)->sum('qty');
        }

        return $totCartItems;
        
    }

    public static function getItems()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $items = Basket::select(DB::raw("baskets.product_id, 
									baskets.id as id_basket,
									baskets.user_id, 
									baskets.qty, 
									baskets.attributes, 
									baskets.is_checked, 
									products.name,
									products.type,
									products.slug,
									products.price,
									products.sku,
									products.weight,
									product_images.small as gambar, 
									shops.name as nama_toko
									"))
						->where('baskets.user_id', $user_id)
						->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
						->leftJoin('product_brands', 'product_brands.product_id', '=', 'products.id')
						->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
						->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
						->leftJoin('brands', 'brands.id', '=', 'product_brands.brand_id')
						->leftJoin('shops', 'shops.user_id', '=', 'products.user_id')
						->leftJoin(DB::raw('(SELECT MAX(id) as max_id, product_id FROM product_images GROUP BY product_id  )
							img'), 
						function($join)
						{
						$join->on('products.id', '=', 'img.product_id');
						})
						->join('product_images', 'product_images.id', 'img.max_id')
						->whereNull('baskets.deleted_at')
						->where('baskets.is_checked', 1)
						->get();
        } else {
            $items = null;
        }

        return $items;
    }

    public static function subTotal()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $subtotal = 0;
            $items = Basket::select(DB::raw("baskets.product_id, 
									baskets.id as id_basket,
									baskets.user_id, 
									baskets.qty, 
									baskets.is_checked, 
									products.price
									"))
                            ->where('baskets.user_id', $user_id)
                            ->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
                            ->whereNull('baskets.deleted_at')
                            ->get();

            foreach ($items as $item) {
                $subtotal += ($item->qty * $item->price);
            }
    
            return $subtotal;
        
        } else {
            $session_id = Session::get('session_id');
            $subtotal = 0;
            $items = Basket::select(DB::raw("baskets.product_id, 
									baskets.id as id_basket,
									baskets.session_id, 
									baskets.qty, 
									baskets.is_checked, 
									products.price
									"))
                            ->where('baskets.session_id', $session_id)
                            ->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
                            ->whereNull('baskets.deleted_at')
                            ->get();

            foreach ($items as $item) {
                $subtotal += ($item->qty * $item->price);
            }
    
            return $subtotal;
        }

    }

    public static function subTotalChecked()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $subtotal = 0;
		    $items = Basket::select(DB::raw("baskets.product_id, 
									baskets.id as id_basket,
									baskets.user_id, 
									baskets.qty, 
									baskets.is_checked, 
									products.price
									"))
                            ->where('baskets.user_id', $user_id)
                            ->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
                            ->whereNull('baskets.deleted_at')
                            ->where('baskets.is_checked', 1)
                            ->get();

            foreach ($items as $item) {
                $subtotal += ($item->qty * $item->price);
            }
        } else {
            $subtotal = 0;
        }

        return $subtotal;
        
    }

    public static function getTotalChecked($service = null, $cost = 0, $tax = 0)
    {
        $total = 0;

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $subtotal = 0;
            
		    $items = Basket::select(DB::raw("baskets.product_id, 
									baskets.id as id_basket,
									baskets.user_id, 
									baskets.qty, 
									baskets.is_checked, 
									products.price
									"))
                            ->where('baskets.user_id', $user_id)
                            ->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
                            ->whereNull('baskets.deleted_at')
                            ->where('baskets.is_checked', 1)
                            ->get();

            foreach ($items as $item) {
                $subtotal += ($item->qty * $item->price);
            }
        } else {
            $subtotal = 0;
        }

        if ($cost > 0) {
            $subtotal += $cost;
        }

        if ($tax > 0) {
            $subtotal += $tax;
        }

        return $subtotal;
    }

    public static function condition()
    {

    }

    public static function pajak()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            
            $tax = 11;
		    $subtotal = 0;
		    $items = Basket::select(DB::raw("baskets.product_id, 
									baskets.id as id_basket,
									baskets.user_id, 
									baskets.qty, 
									baskets.is_checked, 
									products.price
									"))
                            ->where('baskets.user_id', $user_id)
                            ->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
                            ->whereNull('baskets.deleted_at')
                            ->where('baskets.is_checked', 1)
                            ->get();

            foreach ($items as $item) {
                $subtotal += ($item->qty * $item->price);
            }

            $totalTax = ($subtotal * $tax) / 100;
        } 

        return $totalTax;
    }

    public static function getOrigin()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $items = Basket::select(DB::raw("baskets.product_id, 
									baskets.id as id_basket,
									baskets.user_id, 
									baskets.is_checked, 
									shops.name as nama_toko,
                                    users.city_id
									"))
						->where('baskets.user_id', $user_id)
						->leftJoin('products', 'products.id', '=', 'baskets.product_id' )
						->leftJoin('shops', 'shops.user_id', '=', 'products.user_id')
						->leftJoin('users', 'users.id', '=', 'products.user_id')
						->whereNull('baskets.deleted_at')
						->where('baskets.is_checked', 1)
						->get();
                
            foreach ($items as $item) {
                $city_id = $item->city_id;
            }            
        } else {
            $city_id = null;
        }

        return $city_id;
    }

    public static function clear()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
           
		    $items = Basket::select(DB::raw("baskets.id,
									baskets.user_id, 
									baskets.is_checked,
                                    baskets.deleted_at 
									"))
                            ->where('baskets.user_id', $user_id)
                            ->whereNull('baskets.deleted_at')
                            ->where('baskets.is_checked', 1)
                            ->get();

            foreach ($items as $item) {
                //  deleting basket 
                Basket::find($item->id)->delete();
            }

            return true;
        } else {
            return false;
        }

    }

    public static function rank($nomi)
    {
        $capitals = Capital::get();

        foreach ($capitals as $capital) {
            if (($nomi >= (int)$capital->mini) && ($nomi <= (int)$capital->maxi)) $r = (int)$capital->rank;
        }

        return $r;
    }
}