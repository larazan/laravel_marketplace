<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Order;
use App\Models\ProductImage;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function add($product_slug)
    {
        $product = Product::active()->where('slug', $product_slug)->first();

        if ($product) {
            $product_id = $product->id;
            $verified_purchase = Order::where('orders.user_id', Auth::id())
                ->join('order_items', 'orders.id', 'order_items.order_id')
                ->where('order_items.prod_id', $product_id)->get();
            return view('frontend.reviews.index');
        } else {
            return redirect()->back()->with('status', "the link you followed was broken");
        }
    }

    public function create(Request $request)
    {
        $product_id = $request->input('product_id');
        $product = Product::active()->where('id', $product_id)->first();
        if ($product) {
            $user_review = $request->input('user_review');
            $new_review = ProductReview::create([
                'user_id' => Auth::id(),
                'prod_id' => $product_id,
                'user_review' => $user_review
            ]);
        } else {
            # code...
        }
    }

    public function addReview(Request $request)
    {
        $product_slug = $request->input('product_slug');
        $user_review = $request->input('user_review');
        $product = Product::active()->where('slug', $product_slug)->first();
        $product_id = $product->id;

        $verified_purchase = Order::where('orders.user_id', Auth::id())
            ->join('order_items', 'orders.id', 'order_items.order_id')
            ->where('order_items.prod_id', $product_id)->get();

        if ($verified_purchase) {
            $review = ProductReview::where('user_id', Auth::user()->id)
                ->where('product_id', $product_id)
                ->first();
            if ($review) {
                $responseCode = 422;
                $responseData['status'] = true;
                $responseData['message'] = 'Anda sudah melakukan review pada produk ini!';
            } else {
                DB::beginTransaction();
                ProductReview::create([
                    'user_id' => Auth::id(),
                    'prod_id' => $product_id,
                    'user_review' => $user_review
                ]);
                $responseCode = 200;
                $responseData['status'] = true;
                $responseData['message'] = 'berhasil menambahkan review!';

                DB::commit();
            }
        } else {
            $responseCode = 500;
            $responseData['status'] = true;
            $responseData['message'] = 'Anda tidak dapat mereview produk ini!';
        }


        $response = \General::helpResponse($responseCode, $responseData);
        return response()->json($response);
    }
}
