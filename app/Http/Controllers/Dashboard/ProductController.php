<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductImageRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Gate;

use App\Models\Product;
use App\Models\User;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductImage;
use App\Models\ProductInventory;
use App\Models\ProductAttributeValue;
use App\Models\AttributeOption;
use App\Models\Brand;
use App\Models\Ingredient;
use PhpParser\Node\Stmt\TryCatch;

class ProductController extends Controller
{
    public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
        $this->data['currentDashboardMenu'] = 'products';
		$this->data['currentDashboardSubMenu'] = '';

        $this->data['statuses'] = Product::statuses();
		$this->data['types'] = Product::types();
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$auth_id = Auth::user()->id;
        $this->data['products'] = Product::active()->where('user_id', $auth_id)->orderBy('name', 'DESC')->paginate(10);
		// var_dump($this->data); exit();
        return $this->loadDashboard('products.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		// try {
		// 	$shop = Shop::forUser(Auth::user());
		// 	Shop::where('user_id', Auth::user()->id)->first();
		// } catch (\App\Exceptions\NoShopException $exception) {
		// 	return response("no shop found");
		// 	return back()->withErrors($exception->getMessage());
		// }
		$shop = Shop::where('user_id', Auth::id())->first();
		// dd($shop);

		if (!$shop) {
			Session::flash('error', 'Buat Toko terlebih dulu <a href="'. url('/user/shop') .'">disini</a>');
			return redirect('user/products');
		}

		$this->data['currentForm'] = 'detail';

        $categories = Category::orderBy('name', 'DESC')->get();
		$brands = Brand::pluck('name', 'id');
		$ingredients = Ingredient::pluck('name', 'id');
		$configurableAttributes = $this->_getConfigurableAttributes();

		$this->data['shop_id'] = $shop->id;
		$this->data['categories'] = $categories->toArray();
		$this->data['brands'] = $brands;
		$this->data['ingredients'] = $ingredients;
		$this->data['product'] = null;
		$this->data['productID'] = 0;
		$this->data['brandID'] = null;
		$this->data['ingredientsID'] = null;
		$this->data['categoryIDs'] = [];
		$this->data['configurableAttributes'] = $configurableAttributes;

        return $this->loadDashboard('products.form', $this->data);
    }

    private function _getConfigurableAttributes()
	{
		return Attribute::where('is_configurable', true)->get();
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
		$user_id = Auth::user()->id;
		$shop_id = Shop::where('user_id', $user_id)->first()->id;
		$rand = Str::random(18);

        $params = $request->except('_token');
        // var_dump($params); exit;
		$params['slug'] = Str::slug($params['name']);
		$params['user_id'] = $user_id;
		$params['shop_id'] = $shop_id;
		$params['rand_id'] = $rand_id;

		$product = DB::transaction(
			function () use ($params) {
				$categoryIds = !empty($params['category_ids']) ? $params['category_ids'] : [];
				$brandId = $params['brand_id'];
				$ingredientId = $params['ingredient_id'];
				$product = Product::create($params);
				$product->categories()->sync($categoryIds);
				$product->brands()->sync($brandId);
				$product->ingredients()->sync($ingredientId);

				if ($params['type'] == 'configurable') {
					$this->_generateProductVariants($product, $params);
				}

				return $product;
			}
		);

		if ($product) {
			// 
			ProductInventory::updateOrCreate(['product_id' => $product->id], ['qty' => $params['qty']]);
			Session::flash('success', 'Product has been saved');
		} else {
			Session::flash('error', 'Product could not be saved');
		}

		return redirect('user/products/'. $product->id .'/edit/');
    }

	/**
	 * Generate product variants for the configurable product
	 *
	 * @param Product $product product object
	 * @param array   $params  params
	 *
	 * @return void
	 */
	private function _generateProductVariants($product, $params)
	{
		$configurableAttributes = $this->_getConfigurableAttributes();

		$variantAttributes = [];
		foreach ($configurableAttributes as $attribute) {
			$variantAttributes[$attribute->code] = $params[$attribute->code];
		}

		$variants = $this->_generateAttributeCombinations($variantAttributes);
		
        // test
        // echo '<pre>';
        // print_r($variants);
        // exit;

		if ($variants) {
			foreach ($variants as $variant) {
				$variantParams = [
					'parent_id' => $product->id,
					'user_id' => Auth::user()->id,
					'shop_id' => Shop::where('user_id', Auth::user()->id)->first()->id,
					'sku' => $product->sku . '-' .implode('-', array_values($variant)),
					'type' => 'simple',
					'name' => $product->name . $this->_convertVariantAsName($variant),
				];
                // print_r($variantParams);exit;
				$variantParams['slug'] = Str::slug($variantParams['name']);

				$newProductVariant = Product::create($variantParams);

				$categoryIds = !empty($params['category_ids']) ? $params['category_ids'] : [];
				$newProductVariant->categories()->sync($categoryIds);

				$this->_saveProductAttributeValues($newProductVariant, $variant, $product->id);
			}
		}
	}

	private function _generateAttributeCombinations($arrays)
	{
		$result = [[]];
		foreach ($arrays as $property => $property_values) {
			$tmp = [];
			foreach ($result as $result_item) {
				foreach ($property_values as $property_value) {
					$tmp[] = array_merge($result_item, array($property => $property_value));
				}
			}
			$result = $tmp;
		}
		return $result;
	}

	/**
	 * Save the product attribute values
	 *
	 * @param Product $product         product object
	 * @param array   $variant         variant
	 * @param int     $parentProductID parent product ID
	 *
	 * @return void
	 */
	private function _saveProductAttributeValues($product, $variant, $parentProductID)
	{
		foreach (array_values($variant) as $attributeOptionID) {
			$attributeOption = AttributeOption::find($attributeOptionID);
		   
			$attributeValueParams = [
				'parent_product_id' => $parentProductID,
				'product_id' => $product->id,
				'attribute_id' => $attributeOption->attribute_id,
				'text_value' => $attributeOption->name,
			];

			ProductAttributeValue::create($attributeValueParams);
		}
	}

	/**
	 * Convert variant attributes as variant name
	 *
	 * @param array $variant variant
	 *
	 * @return string
	 */
	private function _convertVariantAsName($variant)
	{
		$variantName = '';
		
		foreach (array_keys($variant) as $key => $code) {
			$attributeOptionID = $variant[$code];
			$attributeOption = AttributeOption::find($attributeOptionID);
			
			if ($attributeOption) {
				$variantName .= ' - ' . $attributeOption->name;
			}
		}

		return $variantName;
	}

	private function _isProduct($id)
	{
		// $auth_id = Auth::user()->id;
        $product = Product::forUser(Auth::user())->where('id', $id);

		if ($product) {
			return true;
		} else {
			return false;
		}
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
		$this->data['currentForm'] = 'detail';
		$product = Product::findOrFail($id);

        if (empty($id)) {
			return redirect('user/products/create');
		}

		if (! Gate::forUser(Auth::user())->allows('update-product', $product)) {
			return redirect('user/products');
		}
		

		$product->qty = isset($product->productInventory) ? $product->productInventory->qty : null;
        $categories = Category::orderBy('name', 'ASC')->get();
		$brands = Brand::pluck('name', 'id');
		$ingredients = Ingredient::pluck('name', 'id');
        
        $this->data['categories'] = $categories->toArray();
        $this->data['product'] = $product;
		$this->data['brands'] = $brands;
		$this->data['ingredients'] = $ingredients;
		$this->data['productID'] = $product->id;
        $this->data['categoryIDs'] = $product->categories->pluck('id')->toArray();
		$this->data['brandID'] = $product->brands->pluck('id');
		$this->data['ingredientID'] = $product->ingredients->pluck('id');

        return $this->loadDashboard('products.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $params = $request->except('_token');
		$params['slug'] = Str::slug($params['name']);

		$product = Product::findOrFail($id);

		$saved = false;
		$saved = DB::transaction(
			function () use ($product, $params) {
				$categoryIds = !empty($params['category_ids']) ? $params['category_ids'] : [];
				$brandId = $params['brand_id'];
				$ingredientId = $params['ingredient_id'];
				$product->update($params);
				$product->categories()->sync($categoryIds);
				$product->brands()->sync($brandId);
				$product->ingredients()->sync($ingredientId);

				if ($product->type == 'configurable') {
					$this->_updateProductVariants($params);
				} else {
					ProductInventory::updateOrCreate(['product_id' => $product->id], ['qty' => $params['qty']]);
				}

				return true;
			}
		);

		if ($saved) {
			Session::flash('success', 'Product has been saved');
		} else {
			Session::flash('error', 'Product could not be saved');
		}
		return redirect('user/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->delete()) {
            Session::flash('success', 'Product has been deleted');
        }
        return redirect('user/products');
    }

    public function images($id) {
		$this->data['currentForm'] = 'image';

        if (empty($id)) {
            return redirect('user/products/create');
        }

        $product = Product::findOrFail($id);

		if (! Gate::forUser(Auth::user())->allows('update-product-image', $product)) {
			return redirect('user/products');
		}

        $this->data['productID'] = $product->id;
        $this->data['productImages'] = $product->productImages;

        return $this->loadDashboard('products.images', $this->data);
    }

    public function addImage($id)
	{
		$this->data['currentForm'] = 'image';

		if (empty($id)) {
			return redirect('user/products');
		}

		$product = Product::findOrFail($id);

		if (! Gate::forUser(Auth::user())->allows('add-product-image', $product)) {
			return redirect('user/products');
		}

		$this->data['productID'] = $product->id;
		$this->data['product'] = $product;

		return $this->loadDashboard('products.image_form', $this->data);
	}

    public function uploadImage(ProductImageRequest $request, $id)
	{
		$product = Product::findOrFail($id);

		if ($request->has('image')) {
			$image = $request->file('image');
			$name = $product->slug . '_' . time();
			$fileName = $name . '.' . $image->getClientOriginalExtension();

			$folder = ProductImage::UPLOAD_DIR. '/images';

			$filePath = $image->storeAs($folder . '/original', $fileName, 'public');

			$resizedImage = $this->_resizeImage($image, $fileName, $folder);

			$params = array_merge(
				[
					'product_id' => $product->id,
					'path' => $filePath,
				],
				$resizedImage
			);

			if (ProductImage::create($params)) {
				Session::flash('success', 'Image has been uploaded');
			} else {
				Session::flash('error', 'Image could not be uploaded');
			}

			return redirect('user/products/' . $id . '/images');
		}
	}

    private function _resizeImage($image, $fileName, $folder)
	{
		$resizedImage = [];

		$smallImageFilePath = $folder . '/small/' . $fileName;
		$size = explode('x', ProductImage::SMALL);
		list($width, $height) = $size;

		$smallImageFile = Image::make($image)->fit($width, $height)->stream();
		if (Storage::put('public/' . $smallImageFilePath, $smallImageFile)) {
			$resizedImage['small'] = $smallImageFilePath;
		}
		
		$mediumImageFilePath = $folder . '/medium/' . $fileName;
		$size = explode('x', ProductImage::MEDIUM);
		list($width, $height) = $size;

		$mediumImageFile = Image::make($image)->fit($width, $height)->stream();
		if (Storage::put('public/' . $mediumImageFilePath, $mediumImageFile)) {
			$resizedImage['medium'] = $mediumImageFilePath;
		}

		$largeImageFilePath = $folder . '/large/' . $fileName;
		$size = explode('x', ProductImage::LARGE);
		list($width, $height) = $size;

		$largeImageFile = Image::make($image)->fit($width, $height)->stream();
		if (Storage::put('public/' . $largeImageFilePath, $largeImageFile)) {
			$resizedImage['large'] = $largeImageFilePath;
		}

		$extraLargeImageFilePath  = $folder . '/xlarge/' . $fileName;
		$size = explode('x', ProductImage::EXTRA_LARGE);
		list($width, $height) = $size;

		$extraLargeImageFile = Image::make($image)->fit($width, $height)->stream();
		if (Storage::put('public/' . $extraLargeImageFilePath, $extraLargeImageFile)) {
			$resizedImage['extra_large'] = $extraLargeImageFilePath;
		}

		return $resizedImage;
	}

    public function removeImage($id)
	{
		$image = ProductImage::findOrFail($id);

		// delete image
		$this->deleteImage($id);

		if ($image->delete()) {
			Session::flash('success', 'Image has been deleted');
		}

		return redirect('user/products/' . $image->product->id . '/images');
	}

	public function deleteImage($id = null) {
        $productImage = ProductImage::where(['id' => $id])->first();
		$path = 'storage/';
		
        if (file_exists($path.$productImage->path)) {
            unlink($path.$productImage->path);
		}
		
		if (file_exists($path.$productImage->extra_large)) {
            unlink($path.$productImage->extra_large);
        }

        if (file_exists($path.$productImage->large)) {
            unlink($path.$productImage->large);
		}
		
		if (file_exists($path.$productImage->medium)) {
            unlink($path.$productImage->medium);
        }

        if (file_exists($path.$productImage->small)) {
            unlink($path.$productImage->small);
        }

        return true;
    }


}
