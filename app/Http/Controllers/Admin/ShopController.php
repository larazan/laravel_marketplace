<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ShopRequest;

use App\Models\Shop;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    public function __construct() {
        // parent::__construct();

        $this->data['currentAdminMenu'] = 'marketplace';
        $this->data['currentAdminSubMenu'] = 'shop';
        $this->data['statuses'] = Shop::statuses();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['shops'] = Shop::orderBy('name', 'DESC')->paginate(10);

        return view('admin.shops.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['shop'] = null;

		return view('admin.shops.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopRequest $request)
    {
        $params = $request->except('_token');
        // var_dump($params); exit();
        $params['slug'] =  Str::slug($params['name']);
        $params['description'] = $params['editor1'];
        $params['user_id'] = $request->user()->id;

        if (Shop::create($params)) {
            // var_dump($params);
            Session::flash('success', 'Shop has been saved');
            // $request->session()->flash('success', 'Difficulty has been saved!');
        }
        return redirect('admin/shops');
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
        $shop = Shop::findOrFail($id);
        $shops = Shop::where('id', '!=', $id)->orderBy('name', 'DESC')->get();

        $this->data['shops'] = $shops->toArray();
        $this->data['shop'] = $shop;
        $this->data['editor1'] = $shop->description;
        return view('admin.shops.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopRequest $request, $id)
    {
        $params = $request->except('_token');
        $params['slug'] = Str::slug($params['name']);
        $params['description'] = $params['editor1'];
        $params['user_id'] = $request->user()->id;

        $shop = Shop::findOrFail($id);
        if ($shop->update($params)) {
            Session::flash('success', 'Shop has been updated.');
        }

        return redirect('admin/shops');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop  = Shop::findOrFail($id);

        if ($shop->delete()) {
            Session::flash('success', 'Shop has been deleted');
        }

        return redirect('admin/shops');
    }
}
