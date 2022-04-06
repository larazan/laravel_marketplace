<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}
    
    //
    /**
	 * Get cities by province ID
	 *
	 * @param Request $request province id
	 *
	 * @return json
	 */
	public function cities(Request $request)
	{
		// print('bla');
		$cities = $this->getCities($request->query('province_id'));
		return response()->json(['cities' => $cities]);
	}
}
