<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CkeditorFileUploadController extends Controller
{

    public function create()
    {
        return view('editor');
    }

    public function store(Request $request)
    {
        
        if ($request->hasFile('upload')) {
            $folder = 'uploads/pages';
            $image = $request->file('upload');

            $originName = $image->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            // $extension = $request->file('upload')->getClientOriginalExtension();
            // $newFileName = $fileName . '_' . time() . '.' . $extension;
            $name = $originName . '_' . time();
            $newFileName = $name . '.' . $image->getClientOriginalExtension();

            // upload proses
            $imageFilePath = $folder . '/original/' . $newFileName;
            // $request->file('upload')->move(public_path('pages'), $fileName);
            $image->storeAs($folder . '/original', $newFileName, 'public');

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            // $url = asset('/public/pages/' . $fileName);
            $url = asset('storage/' . $imageFilePath);
            $msg = 'Image upload successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
