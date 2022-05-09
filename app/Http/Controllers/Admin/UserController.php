<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $data = [];
    protected $uploadsFolder = 'uploads/';

    public function __construct()
    {
        parent::__construct();

        $this->data['currentAdminMenu'] = 'role-user';
        $this->data['currentAdminSubMenu'] = 'user';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['users'] = User::latest()->paginate(10);

        return view('admin.users.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->data['roles'] = Role::pluck('name', 'id');

        return view('admin.users.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'isAdmin' => 'required'
        ]);

        $request->merge(['password' => bcrypt($request->get('password'))]);

        DB::transaction(function() use ($request) {
            if (User::create()) {
                // $this->syncPermissions($request, $user);

                Session::flash('success', 'User has been created');
            } else {
                Session::flash('error', 'Unable to create user');
            }
        });

        return redirect('admin/users');
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
        $this->data['user'] = User::find($id);
        // $this->data['roles'] = Role::pluck('name', 'id');
        // $this->data['permissions'] = Permission::all('name', 'id');

        return view('admin.users.edit', $this->data);
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
        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'isAdmin' => 'required'
        ]);

        // Get the user
        $user = User::findOrFail($id);

        DB::transaction(function() use ($request, $user) {
            // Update user
            $user->fill($request->except('password'));

            // check for password change
            if($request->get('password')) {
                $user->password = bcrypt($request->get('password'));
            }

            // $this->syncPermissions($request, $user);

            $user->save();

            Session::flash('success', 'User has been saved');
        });

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin == true) {
            Session::flash('error', 'Unable to remove an Admin user');
            return redirect('admin/users');
        }
       
        if ($user->delete()) {
            Session::flash('success', 'User has been deleted');
        }
        return redirect('admin/users');
    }

    /**
	 * Get provinces
	 *
	 * @return array
	 */
	public function getProvinces()
	{
		$provinceFile = 'provinces.txt';
		$provinceFilePath = 'uploads/files/' . $provinceFile;

		$isExistProvinceJson = Storage::disk('local')->exists($provinceFilePath);

		if (!$isExistProvinceJson) {
			$response = $this->rajaOngkirRequest('province');
			Storage::disk('local')->put($provinceFilePath, serialize($response['rajaongkir']['results']));
		}

		$province = unserialize(Storage::get($provinceFilePath));

		$provinces = [];
		if (!empty($province)) {
			foreach ($province as $province) {
				$provinces[$province['province_id']] = strtoupper($province['province']);
			}
		}

		return $provinces;
    }
    

	/**
	 * Get cities by province ID
	 *
	 * @param int $provinceId province id
	 *
	 * @return array
	 */
	public function getCities($provinceId)
	{
		$cityFile = 'cities_at_'. $provinceId .'.txt';
		$cityFilePath = 'uploads/files/' .$cityFile;

		$isExistCitiesJson = Storage::disk('local')->exists($cityFilePath);

		if (!$isExistCitiesJson) {
			$response = $this->rajaOngkirRequest('city', ['province' => $provinceId]);
			Storage::disk('local')->put($cityFilePath, serialize($response['rajaongkir']['results']));
		}

		$cityList = unserialize(Storage::get($cityFilePath));
		
		$cities = [];
		if (!empty($cityList)) {
			foreach ($cityList as $city) {
				$cities[$city['city_id']] = strtoupper($city['type'].' '.$city['city_name']);
			}
		}

		return $cities;
	}
}
