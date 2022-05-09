<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use App\Models\Settings;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function __construct() {
        // parent::__construct();

        $this->data['currentAdminMenu'] = 'setting';
        $this->data['currentAdminSubMenu'] = 'set';
    }

    public function index() {
        $id = 1;
        $setting = Settings::findOrFail($id);
        if ($setting) {
            $title = $setting->title;
            $address = $setting->address;
            $phone = $setting->phone;
            $email = $setting->email;
            $description = $setting->description;
            $short_des = $setting->short_des;
            $twitter = $setting->twitter;
            $facebook = $setting->facebook;
            $instagram = $setting->instagram;
        } else {
            $title = null;
            $address = null;
            $phone = null;
            $email = null;
            $description = null;
            $short_des = null;
            $twitter = null;
            $facebook = null;
            $instagram = null;
        }

        $this->data['title'] = $title;
        $this->data['address'] = $address;
        $this->data['phone'] = $phone;
        $this->data['email'] = $email;
        $this->data['description'] = $description;
        $this->data['twitter'] = $twitter;
        $this->data['facebook'] = $facebook;
        $this->data['instagram'] = $instagram;
        $this->data['setting'] = $setting;

        return view('admin.settings.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $setting = null;
        
        $this->data['setting'] = $setting;

		return view('admin.settings.form', $this->data);
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
       // var_dump($params); exit();
       $image = $request->file('image');
       
       if ($image) {
           $name = 'logo';
           $fileName = $name . '.' . $image->getClientOriginalExtension();

           $folder = Settings::UPLOAD_DIR;

           $filePath = $image->storeAs($folder . '/original', $fileName, 'public');
           $resizedImage = $this->_resizeImage($image, $fileName, $folder);

           $params['original'] = $filePath;
           $params['medium'] = $resizedImage['medium'];
           $params['small'] = $resizedImage['small'];

           unset($params['image']);
       } else {
           $params['original'] = '';
           $params['medium'] = '';
           $params['small'] = '';
       }

       if (Settings::create($params)) {
           Session::flash('success', 'Setting has been created.');
       } else {
           Session::flash('error', 'Setting could not be created');
       }

       return redirect('admin/setting');
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
       $id = 1;
       $setting = Settings::findOrFail($id);

        if ($setting) {
            $title = $setting->title;
            $address = $setting->address;
            $phone = $setting->phone;
            $email = $setting->email;
            $description = $setting->description;
            $short_des = $setting->short_des;
            $twitter = $setting->twitter;
            $facebook = $setting->facebook;
            $instagram = $setting->instagram;
        } else {
            $title = null;
            $address = null;
            $phone = null;
            $email = null;
            $description = null;
            $short_des = null;
            $twitter = null;
            $facebook = null;
            $instagram = null;
        }
        
       $this->data['setting'] = $setting;

       return view('admin.settings.form', $this->data);
   }

   private function _resizeImage($image, $fileName, $folder)
   {
       $resizedImage = [];

       $smallImageFilePath = $folder . '/small/' . $fileName;
       $size = explode('x', Settings::SMALL);
       list($width, $height) = $size;

       $smallImageFile = Image::make($image)->fit($width, $height)->stream();
       if (Storage::put('public/' . $smallImageFilePath, $smallImageFile)) {
           $resizedImage['small'] = $smallImageFilePath;
       }
       
       $mediumImageFilePath = $folder . '/medium/' . $fileName;
       $size = explode('x', Settings::MEDIUM);
       list($width, $height) = $size;

       $mediumImageFile = Image::make($image)->fit($width, $height)->stream();
       if (Storage::put('public/' . $mediumImageFilePath, $mediumImageFile)) {
           $resizedImage['medium'] = $mediumImageFilePath;
       }

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
       $settingImage = Settings::where(['id' => $id])->first();
       $path = 'storage/';
       
       if (file_exists($path.$settingImage->original)) {
           unlink($path.$settingImage->original);
       }
       
       if (file_exists($path.$settingImage->medium)) {
           unlink($path.$settingImage->medium);
       }

       if (file_exists($path.$settingImage->small)) {
           unlink($path.$settingImage->small);
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
   public function update(Request $request)
   {
       $id = 1;
       $params = $request->except('_token');

       // dd($params);

       $image = $request->file('image');
       
       if ($image) {

           // delete image
           $this->deleteImage($id);
           
           $name = Str::slug($params['name']) . '_' . time();
           $fileName = $name . '.' . $image->getClientOriginalExtension();

           $folder = Settings::UPLOAD_DIR;

           $filePath = $image->storeAs($folder . '/original', $fileName, 'public');
           $resizedImage = $this->_resizeImage($image, $fileName, $folder);

           $params['original'] = $filePath;
           $params['medium'] = $resizedImage['medium'];
           $params['small'] = $resizedImage['small'];

           unset($params['image']);
       } else {
           $params['original'] = '';
           $params['medium'] = '';
           $params['small'] = '';
       }

       $shop = Settings::findOrFail($id);
       if ($shop->update($params)) {
           Session::flash('success', 'Shop has been updated.');
       }

       return redirect('admin/setting');
   }
}
