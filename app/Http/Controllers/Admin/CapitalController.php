<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\CapitalRequest;

use App\Models\Capital;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class CapitalController extends Controller
{
    public function __construct() {
        // parent::__construct();

        $this->data['currentAdminMenu'] = 'marketplace';
        $this->data['currentAdminSubMenu'] = 'capital';
        $this->data['statuses'] = Capital::STATUSES;
        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['capitals'] = Capital::orderBy('rank', 'ASC')->paginate(10);

        return view('admin.capitals.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['capital'] = null;
        $this->data['provinces'] = $this->getProvinces();
		$this->data['cities'] = [];

		return view('admin.capitals.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CapitalRequest $request)
    {
        $params = $request->except('_token');
        // dd($params);

		if (Capital::create($params)) {
			Session::flash('success', 'Capital has been created');
		} else {
			Session::flash('error', 'Capital could not be created');
		}

        // add log
        // \LogActivity::addToLog('add capital');

		return redirect('admin/capitals');
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
        $capital = Capital::findOrFail($id);

		$this->data['capital'] = $capital;
        $this->data['provinces'] = $this->getProvinces();
        $this->data['cities'] = isset($capital->province_id) ? $this->getCities($capital->province_id) : [];

		return view('admin.capitals.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CapitalRequest $request, $id)
    {
        $params = $request->except('_token');		

		$capital = Capital::findOrFail($id);
		if ($capital->update($params)) {
			Session::flash('success', 'Capital has been updated.');
		}

		return redirect('admin/capitals');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $capital  = Capital::findOrFail($id);

		if ($capital->delete()) {
			Session::flash('success', 'Capital has been deleted');
		}

		return redirect('admin/capitals');
    }
}
