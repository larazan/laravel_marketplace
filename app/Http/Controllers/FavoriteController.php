<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Favorite;
use App\Models\Product;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $favorites = Favorite::where('user_id', Auth::user()->id)
			->orderBy('created_at', 'desc')->paginate(10);
		
		$this->data['favorites'] = $favorites;

		return $this->loadTheme('favorites.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate(
			[
				'product_slug' => 'required',
			]
		);

		$product = Product::where('slug', $request->get('product_slug'))->firstOrFail();
		
		$favorite = Favorite::where('user_id', Auth::user()->id)
			->where('product_id', $product->id)
			->first();
		if ($favorite) {
			return response('You have added this product to your favorite before', 422);
		}

		Favorite::create(
			[
				'user_id' => Auth::user()->id,
				'product_id' => $product->id,
			]
		);

		return response('The product has been added to your favorite', 200);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $favorite = Favorite::findOrFail($id);
		$favorite->delete();

		Session::flash('success', 'Your favorite has been removed');
		
		return redirect('favorites');
    }
}
