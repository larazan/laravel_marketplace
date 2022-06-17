<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\General;
use Illuminate\Support\Facades\DB;

use App\Models\ProductReview;
use App\Models\Order;

class ProductReviewController extends Controller
{
    //
    public function store(Request $request)
    {
        $product_id = $request->product_id;
        // cek user sudah melakukan order produk ini
        $cek_order = $this->_checkOrder($product_id);
        // cek user sudah pernah mereview produk ini
        $cek_review = $this->_checkReview($product_id);

        if ($cek_order) {
            $responseCode = 304;
			$responseData['status'] = false;
			$responseData['message'] = 'Yaahh.. sayang sekali, anda belum membeli produk ini !';
        } elseif ($cek_review) {
            $responseCode = 304;
			$responseData['status'] = false;
			$responseData['message'] = 'Anda sudah pernah melakukan review produk ini !';
        } else {
            $data = new ProductReview();
            $data->product_id = $request->product_id;
            $data->user_id = Auth::user()->id;
            $data->rate = $request->rate;
            $data->review = $request->review;
            
            $data->save();
            $responseCode = 200;
            $responseData['status'] = true;
            $responseData['message'] = 'Yeaah.. Berhasil menambahkan produk ke keranjang !';

            DB::commit();
        }
        
        $response = General::helpResponse($responseCode, $responseData);
		return response()->json($response);
    }

    private function _checkOrder($product_id)
    {
        $user_id = Auth::user()->id;

        $order = Order::select(DB::raw("orders.id as id_order,
									orders.user_id, 
									orders.status,  
									order_items.product_id,
									order_items.order_id
									"))
                            ->where('orders.user_id', $user_id)
                            ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id' )
                            ->where('orders.status', 'completed')
                            ->get();
        
        if ($order) {
            return true;
        } else {
            return false;
        }
    }

    private function _checkReview($product_id)
    {
        $review = ProductReview::active()->where('user_id', Auth::user()->id)->where('product_id', $product_id)->first();

        if ($review) {
            return false;
        } else {
            return true;
        }
        
    }
}
