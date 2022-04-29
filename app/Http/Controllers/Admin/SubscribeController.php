<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Subscribe;

class SubscribeController extends Controller
{
    //
    public function __construct()
	{
		parent::__construct();

		$this->data['currentAdminMenu'] = 'general';
		$this->data['currentAdminSubMenu'] = 'subscribe';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['subscribes'] = Subscribe::orderBy('id', 'DESC')->paginate(10);

        return view('admin.subscribes.index', $this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscribe  = Subscribe::findOrFail($id);

	
		if ($subscribe->delete()) {
			Session::flash('success', 'Slide has been deleted');
		}

		return redirect('admin/subscribes');
    }
}
