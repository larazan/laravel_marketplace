<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\ProductReview;

class ProductReviewController extends Controller
{
    public function __construct() {
        // parent::__construct();

        $this->data['currentAdminMenu'] = 'catalog';
        $this->data['currentAdminSubMenu'] = 'review';
        $this->data['statuses'] = ProductReview::STATUSES;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->data['reviews'] = ProductReview::orderBy('id', 'DESC')->paginate(10);

        return view('admin.reviews.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::pluck('name', 'id');

        $this->data['review'] = null;
        $this->data['products'] = $products;
        $this->data['productID'] = null;

		return view('admin.reviews.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->except('_token');
        $params['user_id'] = Auth::user()->id;

        $review = DB::transaction(
			function () use ($params) {
				$productId = $params['product_id'];
				$review = ProductReview::create($params);
				$review->product()->sync($productId);

				return $review;
			}
		);

		if ($review) {
			Session::flash('success', 'review has been saved');
		} else {
			Session::flash('error', 'review could not be saved');
		}

        // if (ProductReview::create($params)) {
        //     Session::flash('success', 'review has been saved');
        // }

        return redirect('admin/reviews');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = ProductReview::findOrFail($id);
        $products = Product::pluck('name', 'id');
        
        $this->data['products'] = $products;
        $this->data['productID'] = $review->product->pluck('id');;
		$this->data['productReview'] = $review;

		return view('admin.reviews.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->except('_token');
        $params['user_id'] = Auth::user()->id;

        $review = ProductReview::findOrFail($id);

        $saved = false;
        $saved = DB::transaction(
			function () use ($review, $params) {
				$productId = $params['product_id'];
				$review->update($params);
				$review->product()->sync($productId);

				return true;
			}
		);

		if ($saved) {
			Session::flash('success', 'review has been saved');
		} else {
			Session::flash('error', 'review could not be saved');
		}

        // $review = ProductReview::findOrFail($id);
        // if ($review->update($params)) {
        //     Session::flash('success', 'review has been updated.');
        // }

        return redirect('admin/reviews');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review  = ProductReview::findOrFail($id);

		if ($review->delete()) {
			Session::flash('success', 'review has been deleted');
		}

		return redirect('admin/reviews');
    }
}
