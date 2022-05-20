<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Shop;
use App\Models\Product;

class ShopController extends Controller
{
    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
    {
        $this->data['q'] = null;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @param Request $request request param
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		// $result = DB::table(DB::raw('shops s'))
		// ->select(DB::raw("s.id as id_shop, s.name as nama_shop, s.slug, s.small as gambar"))
		// ->join('products', 'products.shop_id', '=', 's.id')
		// ->get();

		// var_dump($result);
		// exit();

		$shops = Shop::active()->orderBy('id', 'DESC');

		$shops = $this->_searchShops($shops, $request);

		// build breadcrumb data array
		$breadcrumbs_data['current_page_title'] = '';
		$breadcrumbs_data['breadcrumbs_array'] = $this->_generate_breadcrumbs_array($shops);
		$this->data['breadcrumbs_data'] = $breadcrumbs_data;

		$this->data['shops'] = $shops->paginate(9);
		return $this->loadTheme('vendors.index', $this->data);
	}

    /**
	 * Search products
	 *
	 * @param array   $products array of products
	 * @param Request $request  request param
	 *
	 * @return \Illuminate\Http\Response
	 */
	private function _searchShops($shops, $request)
	{
		if ($q = $request->query('q')) {
			$q = str_replace('-', ' ', Str::slug($q));
			
			$shops = $shops->whereRaw('MATCH(name, slug, description) AGAINST (? IN NATURAL LANGUAGE MODE)', [$q]);

			$this->data['q'] = $q;
		}

		return $shops;
	}

    /**
	 * Display the specified resource.
	 *
	 * @param string $slug product slug
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($slug)
	{
		$limit = 3;
		$shops = Shop::active()->limit($limit)->get();
		$shop = Shop::active()->where('slug', $slug)->first();

		if (!$shop) {
			return redirect('vendors');
		}

		$this->data['shop'] = $shop;
		$this->data['shops'] = $shops;
		// build breadcrumb data array
		$breadcrumbs_data['current_page_title'] = $shop->name;
		$breadcrumbs_data['breadcrumbs_array'] = $this->_generate_breadcrumbs_array($shop->id);
		$this->data['breadcrumbs_data'] = $breadcrumbs_data;

		return $this->loadTheme('vendors.show', $this->data);
	}

	public function _generate_breadcrumbs_array($id) {
		// $homepage_url = url('/');
		// $breadcrumbs_array[$homepage_url] = 'Home';
		
		// get sub cat title
		$sub_cat_title = 'Vendors';
		// get sub cat url
		$sub_cat_url = url('vendors');
	
		$breadcrumbs_array[$sub_cat_url] = $sub_cat_title;
		return $breadcrumbs_array;
	}

	public function loadBarang(Request $request)
	{
		ini_set('max_execution_time', '0');
		ini_set('memory_limit', '100048M');
		
		$m_product = new Shop();
		$responseCode = 200;

		$page = preg_replace('/[^0-9]/u', '', $request->get('page'));
    	$perpage = preg_replace('/[^0-9]/u', '', $request->get('size'));
		// $perpage = 15;
		$keyword = strtoupper($request->get('keyword'));
		$pattern = '/[^a-zA-Z0-9 !@#$%^&*\/\.\,\(\)-_:;?\+=]/u';
        $search = preg_replace($pattern, '', $keyword);

		$sort = 0;
		$deductor = ($sort == 0)? 2 : 1;
		// $deductor = 1;
		$start = ($page - 1) * $perpage;

		if($page >= 0){
			$result = $m_product->loadShop($start, $perpage, null, false);

			$total = $m_product->loadShop($start, $perpage, null, true);
		}else{
			$result = [];
            $total = 0;
		}
		// dd('kesini');
		$responseData['barang'] = $result;

		$rowStart = ($deductor == 2)? ($start + $perpage + 1) : ($start + 1);
		$rowEnd = ($rowStart + count($result)) - 1;
		$rowTotal = (($total >= $perpage && $deductor == 2)? ($total + $perpage) : $total);
		$total_page = ceil($rowTotal / $perpage);

		$pagination = [
			'page' => $page,
			'total_page' => $total_page,
			'size' => $perpage,
			'row' => count($result),
			'start' => $start,
			'rowStart' => $rowStart,
			'rowEnd' => $rowEnd
		];

		$responseData['meta'] = [
			'search' => $search,
			'total' => $rowTotal,
			'pagination' => $pagination,
			'sort' => $sort,
			// 'field' => $field
		];


		$response = \General::helpResponse($responseCode, $responseData);
		return response()->json($response, $responseCode);
	}

	public function tes()
	{
		$slug = 'aprilmart';
		$count = false;
		$start = 0;
		$length = 9;
		$shop_id = Shop::active()->where('slug', $slug)->first()->id;
		$products = DB::table('products')->where('shop_id', $shop_id)->get();

		// dd($products);

		$result = DB::table(DB::raw('products p'))
		->select(DB::raw("p.id as id_produk, p.name as nama_produk, p.price, p.slug, p.sku, brands.name as nama_kategori, product_images.medium as gambar, shops.name as nama_toko"))
		->leftJoin('product_brands', 'product_brands.product_id', '=', 'p.id')
		->leftJoin('product_categories', 'product_categories.product_id', '=', 'p.id')
		->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
		->leftJoin('brands', 'brands.id', '=', 'product_brands.brand_id')
		->leftJoin('shops', 'shops.user_id', '=', 'p.user_id')
		// ->leftJoin('shops', 'shops.id', '=', 'p.shop_id')
		->leftJoin(DB::raw('(SELECT MAX(id) as max_id, product_id FROM product_images GROUP BY product_id  )
               img'), 
        function($join)
        {
           $join->on('p.id', '=', 'img.product_id');
        })
		->join('product_images', 'product_images.id', 'img.max_id')
		->where('p.status', '1');

		if (!empty($slug)) {
			$result = $result->where('shops.slug', $slug);
		}

		if($count == true){
            $result = $result->count();
        }else{
            $result  = $result->offset($start)->limit($length)->get();
        }

		dd($result);
	}
}
