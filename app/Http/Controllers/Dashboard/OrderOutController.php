<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PaymentConfirmRequest;

use App\Models\Order;
use App\Models\Shop;
use App\Models\PaymentConfirmation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class OrderOutController extends Controller
{
    public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
        $this->data['currentDashboardMenu'] = 'ordersout';
		$this->data['currentDashboardSubMenu'] = '';
		$this->data['statuses'] = Order::STATUSES;
		$this->data['banks'] = Shop::BANKS;
	}

    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')
			->paginate(10);
        $this->data['orders'] = $orders;

        return $this->loadDashboard('orderout.index', $this->data);
    }

    /**
	 * Display the specified orders.
	 * 
	 * @param int $id order ID
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function detail($id) {
        $order = Order::withTrashed()->findOrFail($id);

		$this->data['order'] = $order;

		$this->_setToOpened($id);

        return $this->loadDashboard('orderout.show', $this->data);
    }

    private function _setToOpened($update_id)
    {
        $order = Order::find($update_id);
        $order->opened_cus = 1;
        $order->save();
    }

    public function received()
    {
        return $this->loadDashboard('orderout.received');
    }

    /**
	 * Display cancel order form
	 *
	 * @param int $id order ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function confim_paid($id)
	{
		$order = Order::where('id', $id)
			->whereIn('status', [Order::CREATED, Order::CONFIRMED])
			->firstOrFail();

		$this->data['order'] = $order;

		return $this->loadDashboard('orderout.confirmation', $this->data);
	}

	/**
	 * Doing the cancel process
	 *
	 * @param Request $request request params
	 * @param int     $id      order ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function doConfirmPaid(PaymentConfirmRequest $request, $id)
	{
		$params = $request->except('_token');
        // var_dump($params); exit();
        $params['user_id'] = Auth::user()->id;
        $params['order_id'] = $id;
        $image = $request->file('image');

		$order = Order::findOrFail($id);
        $order->payment_status = Order::PAID;
        
        if ($image) {
            $name = $id . '_' . time();
            $fileName = $name . '.' . $image->getClientOriginalExtension();

            $folder = PaymentConfirmation::UPLOAD_DIR;

            $filePath = $image->storeAs($folder . '/original', $fileName, 'public');
            $resizedImage = $this->_resizeImage($image, $fileName, $folder);

			$params['original'] = $filePath;
            $params['medium'] = $resizedImage['medium'];

			unset($params['image']);
		} else {
            $params['original'] = '';
            $params['medium'] = '';
        }

        if (PaymentConfirmation::create($params)) {
            $order->save();
			Session::flash('success', 'Payment Confirmation has been created.');
		} else {
			Session::flash('error', 'Payment Confirmation could not be created');
		}

		Session::flash('success', 'The order has been cancelled');

		return redirect('user/orderout');
	}

    private function _resizeImage($image, $fileName, $folder)
	{
		$resizedImage = [];

		// $smallImageFilePath = $folder . '/small/' . $fileName;
		// $size = explode('x', PaymentConfirmation::SMALL);
		// list($width, $height) = $size;

		// $smallImageFile = Image::make($image)->fit($width, $height)->stream();
		// if (Storage::put('public/' . $smallImageFilePath, $smallImageFile)) {
		// 	$resizedImage['small'] = $smallImageFilePath;
		// }
		
		$mediumImageFilePath = $folder . '/medium/' . $fileName;
		$size = explode('x', PaymentConfirmation::MEDIUM);
		list($width, $height) = $size;

		$mediumImageFile = Image::make($image)->fit($width, $height)->stream();
		if (Storage::put('public/' . $mediumImageFilePath, $mediumImageFile)) {
			$resizedImage['medium'] = $mediumImageFilePath;
		}

		// $largeImageFilePath = $folder . '/large/' . $fileName;
		// $size = explode('x', PaymentConfirmation::LARGE);
		// list($width, $height) = $size;

		// $largeImageFile = Image::make($image)->fit($width, $height)->stream();
		// if (Storage::put('public/' . $largeImageFilePath, $largeImageFile)) {
		// 	$resizedImage['large'] = $largeImageFilePath;
		// }

		// $extraLargeImageFilePath  = $folder . '/xlarge/' . $fileName;
		// $size = explode('x', PaymentConfirmation::EXTRA_LARGE);
		// list($width, $height) = $size;

		// $extraLargeImageFile = Image::make($image)->fit($width, $height)->stream();
		// if (Storage::put('public/' . $extraLargeImageFilePath, $extraLargeImageFile)) {
		// 	$resizedImage['extra_large'] = $extraLargeImageFilePath;
		// }

		return $resizedImage;
	}

    public function deleteImage($id = null) {
        $shopImage = PaymentConfirmation::where(['id' => $id])->first();
		$path = 'storage/';

        if (Storage::exists($path.$shopImage->original)) {
            Storage::delete($path.$shopImage->original);
		}
		
		if (Storage::exists($path.$shopImage->medium)) {
            Storage::delete($path.$shopImage->medium);
        }    

        return true;
    }
}
