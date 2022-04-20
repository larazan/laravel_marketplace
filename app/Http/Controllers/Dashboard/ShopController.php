<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ShopRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    //
    public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
        $this->data['currentDashboardMenu'] = 'vendors';
		$this->data['currentDashboardSubMenu'] = '';
	}
    
    public function index() {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id);

        if (Shop::where('user_id', $user_id)->first()) {
            $shop = Shop::where('user_id', $user_id)->first();
        } else {
            $shop = null;
        }
        
        $this->data['user'] = $user;
        $this->data['shop'] = $shop;

        return $this->loadDashboard('shops.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Auth::id();
        // $user = User::findOrFail($user_id);

        if (Shop::where('user_id', $user_id)->first()) {
            $id = Shop::where('user_id', $user_id);
            $shop = Shop::findOrFail($id);
        } else {
            $shop = null;
        }

        $this->data['shop'] = $shop;

		return $this->loadDashboard('shops.form', $this->data);
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
        $params['slug'] = Str::slug($params['name']);
        $params['user_id'] = Auth::user()->id;
        $params['is_active'] = true;
        $image = $request->file('image');
		
		if ($image) {
            $name = Str::slug($params['name']) . '_' . time();
            $fileName = $name . '.' . $image->getClientOriginalExtension();

            $folder = Shop::UPLOAD_DIR;

            $filePath = $image->storeAs($folder . '/original', $fileName, 'public');
            $resizedImage = $this->_resizeImage($image, $fileName, $folder);

			$params['original'] = $filePath;
            // $params['extra_large'] = $resizedImage['extra_large'];
            $params['small'] = $resizedImage['small'];

			unset($params['image']);
		} else {
            $params['original'] = '';
            // $params['extra_large'] = '';
            $params['small'] = '';
        }

		if (Shop::create($params)) {
			Session::flash('success', 'Shop has been created.');
		} else {
			Session::flash('error', 'Shop could not be created');
		}

		return redirect('user/shop');
     }

    public function show() {
        // return $this->loadDashboard('shops.form', $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user_id = Auth::id();
        $id = Shop::where('user_id', $user_id)->first()->id;
        $shop = Shop::findOrFail($id);

        $this->data['shop'] = $shop;

        return $this->loadDashboard('shops.form', $this->data);
    }

    private function _resizeImage($image, $fileName, $folder)
	{
		$resizedImage = [];

		$smallImageFilePath = $folder . '/small/' . $fileName;
		$size = explode('x', Shop::SMALL);
		list($width, $height) = $size;

		$smallImageFile = Image::make($image)->fit($width, $height)->stream();
		if (Storage::put('public/' . $smallImageFilePath, $smallImageFile)) {
			$resizedImage['small'] = $smallImageFilePath;
		}
		
		// $mediumImageFilePath = $folder . '/medium/' . $fileName;
		// $size = explode('x', Shop::MEDIUM);
		// list($width, $height) = $size;

		// $mediumImageFile = Image::make($image)->fit($width, $height)->stream();
		// if (Storage::put('public/' . $mediumImageFilePath, $mediumImageFile)) {
		// 	$resizedImage['medium'] = $mediumImageFilePath;
		// }

		// $largeImageFilePath = $folder . '/large/' . $fileName;
		// $size = explode('x', Shop::LARGE);
		// list($width, $height) = $size;

		// $largeImageFile = Image::make($image)->fit($width, $height)->stream();
		// if (Storage::put('public/' . $largeImageFilePath, $largeImageFile)) {
		// 	$resizedImage['large'] = $largeImageFilePath;
		// }

		// $extraLargeImageFilePath  = $folder . '/xlarge/' . $fileName;
		// $size = explode('x', Shop::EXTRA_LARGE);
		// list($width, $height) = $size;

		// $extraLargeImageFile = Image::make($image)->fit($width, $height)->stream();
		// if (Storage::put('public/' . $extraLargeImageFilePath, $extraLargeImageFile)) {
		// 	$resizedImage['extra_large'] = $extraLargeImageFilePath;
		// }

		return $resizedImage;
	}

    public function deleteImage($id = null) {
        $shopImage = Shop::where(['id' => $id])->first();
		$path = 'storage/';
		
        if (file_exists($path.$shopImage->original)) {
            unlink($path.$shopImage->original);
		}
		
		// if (file_exists($path.$shopImage->extra_large)) {
        //     unlink($path.$shopImage->extra_large);
        // }

        if (file_exists($path.$shopImage->small)) {
            unlink($path.$shopImage->small);
        }

        return true;
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

        $image = $request->file('image');
		
		if ($image) {

			// delete image
			$this->deleteImage($id);
			
            $name = Str::slug($params['name']) . '_' . time();
            $fileName = $name . '.' . $image->getClientOriginalExtension();

            $folder = Shop::UPLOAD_DIR;

            $filePath = $image->storeAs($folder . '/original', $fileName, 'public');
            $resizedImage = $this->_resizeImage($image, $fileName, $folder);

			$params['original'] = $filePath;
            // $params['extra_large'] = $resizedImage['extra_large'];
            $params['small'] = $resizedImage['small'];

			unset($params['image']);
		} else {
            $params['original'] = '';
            // $params['extra_large'] = '';
            $params['small'] = '';
        }

		$shop = Shop::findOrFail($id);
		if ($shop->update($params)) {
			Session::flash('success', 'Shop has been updated.');
		}

		return redirect('user/shop');
    }

}
