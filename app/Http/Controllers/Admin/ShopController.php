<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ShopRequest;
use Illuminate\Support\Facades\DB;

use App\Models\Shop;
use App\Models\Capital;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    public function __construct() {
        // parent::__construct();

        $this->data['currentAdminMenu'] = 'marketplace';
        $this->data['currentAdminSubMenu'] = 'shop';
        $this->data['statuses'] = Shop::STATUSES;
        $this->data['banks'] = Shop::banks();
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
        $capitals = Capital::orderBy('rank', 'ASC')->get();

        $this->data['capitals'] = $capitals;
        $this->data['capitalID'] = null;

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

        $shop = DB::transaction(
			function () use ($params) {
				$capitalId = $params['capital_id'];
				$shop = Shop::create($params);
				$shop->capitals()->sync($capitalId);

				return $shop;
			}
		);

		if ($shop) {
			Session::flash('success', 'shop has been saved');
		} else {
			Session::flash('error', 'shop could not be saved');
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
        if (empty($id)) {
			return redirect('admin/shops/create');
		}
        
        $shop = Shop::findOrFail($id);
        
        $shops = Shop::where('id', '!=', $id)->orderBy('name', 'DESC')->get();
        $capitals = Capital::orderBy('rank', 'ASC')->get();
        // $capitals = Capital::pluck('mini', 'maxi', 'id');


        $this->data['shops'] = $shops->toArray();
        $this->data['shop'] = $shop;
        $this->data['capitals'] = $capitals;
        $this->data['editor1'] = $shop->description;
        $this->data['capitalID'] = $shop->capitals->pluck('id');

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

        $saved = false;
		$saved = DB::transaction(
			function () use ($shop, $params) {
				$capitalId = $params['capital_id'];
				$shop->update($params);
				$shop->capitals()->sync($capitalId);

				return true;
			}
		);

		if ($saved) {
			Session::flash('success', 'Shop has been saved');
		} else {
			Session::flash('error', 'Shop could not be saved');
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
