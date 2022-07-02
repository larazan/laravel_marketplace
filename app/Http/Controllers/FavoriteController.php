<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\Capital;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Mail\testEmail;
use Illuminate\Support\Facades\Mail;

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

    public function addProduct(Request $request)
    {
        $product = Product::where('id', $request->id)->firstOrFail();
		
        
		$favorite = Favorite::where('user_id', Auth::user()->id)
			->where('product_id', $request->id)
			->first();
		if ($favorite) {
            $responseCode = 422;
            $responseData['status'] = true;
            $responseData['message'] = 'Produk yang anda tambahkan sudah ada ke wishlistmu!';
		}else{
            DB::beginTransaction();
            $data = new Favorite();
            $data->user_id = Auth::user()->id;
            $data->product_id = $request->id;
            $data->save();
            $responseCode = 200;
            $responseData['status'] = true;
            $responseData['message'] = 'berhasil menambahkan produk kamu ke wishlist!';

            DB::commit();
        }

        $response = \General::helpResponse($responseCode, $responseData);
		return response()->json($response);

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

    public function kirim()
    {
        Mail::to("nurcahyono320@gmail.com")->send(new testEmail());

        return "email telah dikirim";
    }

    public function tes()
    {
        $tim = Carbon::now()->timestamp;
        $ord = 'NV/20220620/VI/XX/00001';
        $enc = md5($ord);
        $now = Carbon::now();

        $nomi = 1300000;
        $r = 0;
        $capitals = Capital::get();

        foreach ($capitals as $capital) {
            if (($nomi >= (int)$capital->mini) && ($nomi <= (int)$capital->maxi)) $r = (int)$capital->rank;
        }

        return $r;

        // return $now;
    }
}
