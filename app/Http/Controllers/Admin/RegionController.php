<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegionRequest;

use App\Models\Region;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class RegionController extends Controller
{
    public function __construct() {
        // parent::__construct();

        $this->data['currentAdminMenu'] = 'marketplace';
        $this->data['currentAdminSubMenu'] = 'region';
        $this->data['statuses'] = Region::STATUSES;
        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['regions'] = Region::orderBy('name', 'DESC')->paginate(10);

        return view('admin.regions.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['region'] = null;
        $this->data['provinces'] = $this->getProvinces();
		$this->data['cities'] = [];

		return view('admin.regions.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegionRequest $request)
    {
        $params = $request->except('_token');
        $params['slug'] = Str::slug($params['name']);

		if (Region::create($params)) {
			Session::flash('success', 'Region has been created');
		} else {
			Session::flash('error', 'Region could not be created');
		}

        // add log
        \LogActivity::addToLog('add region');

		return redirect('admin/regions');
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
        $region = Region::findOrFail($id);

		$this->data['region'] = $region;
        $this->data['provinces'] = $this->getProvinces();
        $this->data['cities'] = isset($region->province_id) ? $this->getCities($region->province_id) : [];

		return view('admin.regions.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegionRequest $request, $id)
    {
        $params = $request->except('_token');		

		$region = Region::findOrFail($id);
		if ($region->update($params)) {
			Session::flash('success', 'Region has been updated.');
		}

		return redirect('admin/regions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $region  = Region::findOrFail($id);

		if ($region->delete()) {
			Session::flash('success', 'Region has been deleted');
		}

		return redirect('admin/regions');
    }
}
