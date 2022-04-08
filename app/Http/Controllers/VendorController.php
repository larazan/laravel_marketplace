<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Shop;

class VendorController extends Controller
{
    //
    /**
	 * Display a listing of the resource.
	 *
	 * @param Request $request request param
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index(Request $request)
    {
        $vendors = Shop::active()->orderBy('id', 'DESC');

		$vendors = $this->_searchProducts($vendors, $request);
        // build breadcrumb data array
		$breadcrumbs_data['current_page_title'] = '';
		$breadcrumbs_data['breadcrumbs_array'] = $this->_generate_breadcrumbs_array($vendors);
		$this->data['breadcrumbs_data'] = $breadcrumbs_data;

		$this->data['vendors'] = $vendors->paginate(9);
		return $this->loadTheme('vendors.index', $this->data);
    }

    private function _searchVendors($vendors, $request)
    {
        if ($q = $request->query('q')) {
			$q = str_replace('-', ' ', Str::slug($q));
			
			$vendors = $vendors->whereRaw('MATCH(name, slug, short_description, description) AGAINST (? IN NATURAL LANGUAGE MODE)', [$q]);

			$this->data['q'] = $q;
		}

        return $vendors;
    }

    public function show($slug)
    {
        $limit = 3;
		$vendors = Shop::active()->limit($limit)->get();
		$vendor = Shop::active()->where('slug', $slug)->first();

		if (!$vendor) {
			return redirect('vendors');
		}

        $this->data['vendor'] = $vendor;
		$this->data['vendors'] = $vendors;
		// build breadcrumb data array
		$breadcrumbs_data['current_page_title'] = $vendor->name;
		$breadcrumbs_data['breadcrumbs_array'] = $this->_generate_breadcrumbs_array($vendor->id);
		$this->data['breadcrumbs_data'] = $breadcrumbs_data;

		return $this->loadTheme('vendors.show', $this->data);
    }

    public function _generate_breadcrumbs_array($id) {
		$homepage_url = url('/');
		$breadcrumbs_array[$homepage_url] = 'Home';
		
		// get sub cat title
		$sub_cat_title = 'Vendors';
		// get sub cat url
		$sub_cat_url = url('vendors');
	
		$breadcrumbs_array[$sub_cat_url] = $sub_cat_title;
		return $breadcrumbs_array;
	}
}
