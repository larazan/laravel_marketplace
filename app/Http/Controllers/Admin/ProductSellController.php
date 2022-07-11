<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SellRequest;

use App\Models\Product;
use App\Models\ProductSell;

use Illuminate\Support\Facades\Session;

class ProductSellController extends Controller
{
    public function __construct() {
        // parent::__construct();

        $this->data['currentAdminMenu'] = 'marketplace';
        $this->data['currentAdminSubMenu'] = 'sell';
        $this->data['statuses'] = ProductSell::STATUSES;
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['sells'] = ProductSell::orderBy('id', 'ASC')->paginate(10);

        return view('admin.sells.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::pluck('name', 'id');

        $this->data['sell'] = null;
        $this->data['products'] = $products;
		$this->data['productID'] = null;

		return view('admin.sells.form', $this->data);
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
        // dd($params);

		if (ProductSell::create($params)) {
			Session::flash('success', 'Product Sell has been created');
		} else {
			Session::flash('error', 'Product Sell could not be created');
		}

        // add log
        // \LogActivity::addToLog('add sell');

		return redirect('admin/sells');
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
        $sell = ProductSell::findOrFail($id);
        $products = Product::pluck('name', 'id');

		$this->data['sell'] = $sell;
        $this->data['products'] = $products;
		$this->data['productID'] = $sell->product_id;

		return view('admin.sells.form', $this->data);
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

		$sell = ProductSell::findOrFail($id);
		if ($sell->update($params)) {
			Session::flash('success', 'ProductSell has been updated.');
		}

		return redirect('admin/sells');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sell  = ProductSell::findOrFail($id);

		if ($sell->delete()) {
			Session::flash('success', 'Product sell has been deleted');
		}

		return redirect('admin/sells');
    }
}
