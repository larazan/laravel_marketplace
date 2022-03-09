<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\SlideRequest;

use App\Models\Slide;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as InterventionImage;

class SlideController extends Controller
{
	public function __construct()
	{

		$this->data['currentAdminMenu'] = 'general';
		$this->data['currentAdminSubMenu'] = 'slide';

		$this->data['statuses'] = Slide::STATUSES;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['slides'] = Slide::orderBy('position', 'DESC')->paginate(10);

		return view('admin.slides.index', $this->data);
    }

    public function moveUp($id)
	{
		$slide = Slide::findOrFail($id);

		if (!$slide->prevSlide()) {
			Session::flash('error', 'Invalid position');
			return redirect('admin/slides');
		}

		DB::transaction(
			function () use ($slide) {
				$currentPosition = $slide->position;
				$prevPosition = $slide->prevSlide()->position;

				$prevSlide = Slide::find($slide->prevSlide()->id);
				$prevSlide->position = $currentPosition;
				$prevSlide->save();

				$slide->position = $prevPosition;
				$slide->save();
			}
		);

		return redirect('admin/slides');
	}

    /**
	 * Move down the slide position
	 *
	 * @param int $id slide ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function moveDown($id)
	{
		$slide = Slide::findOrFail($id);

		if (!$slide->nextSlide()) {
			Session::flash('error', 'Invalid position');
			return redirect('admin/slides');
		}

		DB::transaction(
			function () use ($slide) {
				$currentPosition = $slide->position;
				$nextPosition = $slide->nextSlide()->position;

				$nextSlide = Slide::find($slide->nextSlide()->id);
				$nextSlide->position = $currentPosition;
				$nextSlide->save();

				$slide->position = $nextPosition;
				$slide->save();
			}
		);

		return redirect('admin/slides');
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['slide'] = null;

		return view('admin.slides.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideRequest $request)
    {
        $params = $request->except('_token');

		$image = $request->file('image');
		$name = Str::slug($params['title']) . '_' . time();
		$fileName = $name . '.' . $image->getClientOriginalExtension();

		$folder = Slide::UPLOAD_DIR;

		$filePath = $image->storeAs($folder . '/original', $fileName, 'public');

		$resizedImage = $this->_resizeImage($image, $fileName, $folder);

		$params['original'] = $filePath;
		$params['extra_large'] = $resizedImage['extra_large'];
		$params['small'] = $resizedImage['small'];
		$params['user_id'] = Auth::user()->id;

		unset($params['image']);

		$params['position'] = Slide::max('position') + 1;

		if (Slide::create($params)) {
			Session::flash('success', 'Slide has been created');
		} else {
			Session::flash('error', 'Slide could not be created');
		}

		return redirect('admin/slides');
    }

    /**
	 * Resize image
	 *
	 * @param file   $image    raw file
	 * @param string $fileName image file name
	 * @param string $folder   folder name
	 *
	 * @return Response
	 */
	private function _resizeImage($image, $fileName, $folder)
	{
		$resizedImage = [];

		$smallImageFilePath = $folder . '/small/' . $fileName;
		$size = explode('x', Slide::SMALL);
		list($width, $height) = $size;

		$smallImageFile = InterventionImage::make($image)->fit($width, $height)->stream();
		if (Storage::put('public/' . $smallImageFilePath, $smallImageFile)) {
			$resizedImage['small'] = $smallImageFilePath;
		}

		$extraLargeImageFilePath  = $folder . '/xlarge/' . $fileName;
		$size = explode('x', Slide::EXTRA_LARGE);
		list($width, $height) = $size;

		$extraLargeImageFile = InterventionImage::make($image)->fit($width, $height)->stream();
		if (Storage::put('public/' . $extraLargeImageFilePath, $extraLargeImageFile)) {
			$resizedImage['extra_large'] = $extraLargeImageFilePath;
		}

		return $resizedImage;
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
        $slide = Slide::findOrFail($id);

		$this->data['slide'] = $slide;

		return view('admin.slides.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SlideRequest $request, $id)
    {
        $params = $request->except('_token');

		$image = $request->file('image');
		
		if ($image) {

			// delete image
			$this->deleteImage($id);
			
			$name = Str::slug($params['title']) . '_' . time();
			$fileName = $name . '.' . $image->getClientOriginalExtension();

			$folder = Slide::UPLOAD_DIR;

			$filePath = $image->storeAs($folder . '/original', $fileName, 'public');

			$resizedImage = $this->_resizeImage($image, $fileName, $folder);

			$params['original'] = $filePath;
			$params['extra_large'] = $resizedImage['extra_large'];
			$params['small'] = $resizedImage['small'];
			$params['user_id'] = Auth::user()->id;

			unset($params['image']);
		}
		
		$slide = Slide::findOrFail($id);
		if ($slide->update($params)) {
			Session::flash('success', 'Slide has been updated.');
		}

		return redirect('admin/slides');
    }

    public function tes() {
		$id = 1;
		$slideImage = Slide::where(['id' => $id])->first();
		$path = 'storage/';
		$img = 'uploads/images/baju-muslim-lengan-panjang_1595374676.jpg';
        if (file_exists($path.$slideImage->original)) {
            echo $path.$slideImage->original;
		}

		if (file_exists($path.$img)) {
			// echo $path.$img;
			unlink($path.$img);
		}
	}

	public function deleteImage($id = null) {
        $slideImage = Slide::where(['id' => $id])->first();
		$path = 'storage/';
		
        if (file_exists($path.$slideImage->original)) {
            unlink($path.$slideImage->original);
		}
		
		if (file_exists($path.$slideImage->extra_large)) {
            unlink($path.$slideImage->extra_large);
        }

        if (file_exists($path.$slideImage->small)) {
            unlink($path.$slideImage->small);
        }

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slide  = Slide::findOrFail($id);

		// delete image
		$this->deleteImage($id);

		if ($slide->delete()) {
			Session::flash('success', 'Slide has been deleted');
		}

		return redirect('admin/slides');
    }
}
