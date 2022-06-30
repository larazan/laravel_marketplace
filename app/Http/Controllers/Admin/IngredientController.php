<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\IngredientRequest;

use App\Models\Ingredient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class IngredientController extends Controller
{
    public function __construct() {
        // parent::__construct();

        $this->data['currentAdminMenu'] = 'catalog';
        $this->data['currentAdminSubMenu'] = 'ingredient';
        $this->data['statuses'] = Ingredient::STATUSES;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['ingredients'] = Ingredient::orderBy('name', 'DESC')->paginate(10);

        return view('admin.ingredients.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['ingredient'] = null;

		return view('admin.ingredients.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngredientRequest $request)
    {
        $params = $request->except('_token');
        $params['slug'] = Str::slug($params['name']);

		if (Ingredient::create($params)) {
			Session::flash('success', 'Ingredient has been created');
		} else {
			Session::flash('error', 'Ingredient could not be created');
		}

        // add log
        \LogActivity::addToLog('add ingredient');

		return redirect('admin/ingredients');
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
        $ingredient = Ingredient::findOrFail($id);

		$this->data['ingredient'] = $ingredient;

		return view('admin.ingredients.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IngredientRequest $request, $id)
    {
        $params = $request->except('_token');		
        $params['slug'] = Str::slug($params['name']);
        
		$ingredient = Ingredient::findOrFail($id);
		if ($ingredient->update($params)) {
			Session::flash('success', 'Ingredient has been updated.');
		}

		return redirect('admin/ingredients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ingredient  = Ingredient::findOrFail($id);

		if ($ingredient->delete()) {
			Session::flash('success', 'Ingredient has been deleted');
		}

		return redirect('admin/ingredients');
    }
}
