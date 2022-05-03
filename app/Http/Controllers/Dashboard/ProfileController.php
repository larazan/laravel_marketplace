<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
        $this->data['currentDashboardMenu'] = 'profiles';
		$this->data['currentDashboardSubMenu'] = '';
	}

    public function index()
    {
        $id = Auth::id();
        $user = User::findOrFail($id);

        $this->data['user'] = $user;

        return $this->loadDashboard('profiles.index', $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        $id = Auth::id();
		
		$this->data['provinces'] = $this->getProvinces();
		$this->data['cities'] = isset(Auth::user()->province_id) ? $this->getCities(Auth::user()->province_id) : [];
		$this->data['user'] = $user;
        
        return $this->loadDashboard('profiles.form', $this->data);
    }

    private function _resizeImage($image, $fileName, $folder)
	{
		$resizedImage = [];

		$smallImageFilePath = $folder . '/small/' . $fileName;
		$size = explode('x', User::SMALL);
		list($width, $height) = $size;

		$smallImageFile = Image::make($image)->fit($width, $height)->stream();
		if (Storage::put('public/' . $smallImageFilePath, $smallImageFile)) {
			$resizedImage['small'] = $smallImageFilePath;
		}
		
		// $mediumImageFilePath = $folder . '/medium/' . $fileName;
		// $size = explode('x', User::MEDIUM);
		// list($width, $height) = $size;

		// $mediumImageFile = Image::make($image)->fit($width, $height)->stream();
		// if (Storage::put('public/' . $mediumImageFilePath, $mediumImageFile)) {
		// 	$resizedImage['medium'] = $mediumImageFilePath;
		// }

		// $largeImageFilePath = $folder . '/large/' . $fileName;
		// $size = explode('x', User::LARGE);
		// list($width, $height) = $size;

		// $largeImageFile = Image::make($image)->fit($width, $height)->stream();
		// if (Storage::put('public/' . $largeImageFilePath, $largeImageFile)) {
		// 	$resizedImage['large'] = $largeImageFilePath;
		// }

		// $extraLargeImageFilePath  = $folder . '/xlarge/' . $fileName;
		// $size = explode('x', User::EXTRA_LARGE);
		// list($width, $height) = $size;

		// $extraLargeImageFile = Image::make($image)->fit($width, $height)->stream();
		// if (Storage::put('public/' . $extraLargeImageFilePath, $extraLargeImageFile)) {
		// 	$resizedImage['extra_large'] = $extraLargeImageFilePath;
		// }

		return $resizedImage;
	}

    public function deleteImage($id = null) {
        $brandImage = User::where(['id' => $id])->first();
		$path = 'storage/';
		
        if (file_exists($path.$brandImage->original)) {
            unlink($path.$brandImage->original);
		}
		
		if (file_exists($path.$brandImage->extra_large)) {
            unlink($path.$brandImage->extra_large);
        }

        if (file_exists($path.$brandImage->small)) {
            unlink($path.$brandImage->small);
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
        $id = Auth::id();
        $params = $request->except('_token');

        $image = $request->file('image');
		
		if ($image) {

			// delete image
			$this->deleteImage($id);
			
            $name = Str::slug($params['name']) . '_' . time();
            $fileName = $name . '.' . $image->getClientOriginalExtension();

            $folder = User::UPLOAD_DIR;

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

		// Get the user
        $id = Auth::id();
        $user = User::findOrFail($id);
		if ($user->update($params)) {
			Session::flash('success', 'User has been updated.');
		}

		return redirect('user/profile');
    }

    public function reset() 
    {
        $user = Auth::user();
        $this->data['user'] = $user;
        return $this->loadDashboard('profiles.password', $this->data);
    }

    public function changePasswordPost(Request $request) {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            // Current password and new password same
            return redirect()->back()->with("error","New Password cannot be same as your current password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password successfully changed!");
    }
}
