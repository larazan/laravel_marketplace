<?php
namespace App\Models;

use App\Models\Traits\HashUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    // protected $fillable = ['name', 'description', 'price', 'image_url'];
    protected $fillable = [
		'parent_id',
		'user_id',
		'shop_id',
		'sku',
		'type',
		'name',
		'slug',
		'price',
		'discount',
		'weight',
		'length',
		'width',
		'height',
		'short_description',
		'description',
		'status',
	];

	// protected $primaryKey = 'uuid';

    // protected $keyType = 'string';

    // public $incrementing = false;

	public const DRAFT = 0;
	public const ACTIVE = 1;
	public const INACTIVE = 2;

	public const STATUSES = [
		self::DRAFT => 'draft',
		self::ACTIVE => 'active',
		self::INACTIVE => 'inactive',
	];

	public const SIMPLE = 'simple';
	public const CONFIGURABLE = 'configurable';
	public const TYPES = [
		self::SIMPLE => 'Simple',
		self::CONFIGURABLE => 'Configurable',
	];

	/**
	 * Define relationship with the User
	 *
	 * @return void
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

	/**
	 * Define relationship with the ProductInventory
	 *
	 * @return void
	 */
	public function productInventory()
	{
		return $this->hasOne('App\Models\ProductInventory');
	}

	/**
	 * Define relationship with the Category
	 *
	 * @return void
	 */
	public function categories()
	{
		return $this->belongsToMany('App\Models\Category', 'product_categories');
	}

	public function brands()
	{
		return $this->belongsToMany('App\Models\Brand', 'product_brands');
	}

	/**
	 * Define relationship with the Variants
	 *
	 * @return void
	 */
	public function variants()
	{
		return $this->hasMany('App\Models\Product', 'parent_id')->orderBy('price', 'ASC');
	}

	/**
	 * Define relationship with the Parent
	 *
	 * @return void
	 */
	public function parent()
	{
		return $this->belongsTo('App\Models\Product', 'parent_id');
	}

	/**
	 * Define relationship with the ProductAttributeValue
	 *
	 * @return void
	 */
	public function productAttributeValues()
	{
		return $this->hasMany('App\Models\ProductAttributeValue', 'parent_product_id');
	}

	/**
	 * Define relationship with the ProductImage
	 *
	 * @return void
	 */
	public function productImages()
	{
		return $this->hasMany('App\Models\ProductImage')->orderBy('id', 'DESC');
	}

	public function productReview()
	{
		return $this->hasMany('App\Models\ProductReview');
	}

	/**
	 * Define relationship with the OrderItem
	 *
	 * @return void
	 */
	public function orderItems()
	{
		return $this->hasMany('App\Models\OrderItem');
	}

	/**
	 * Define relationship with the Shipment
	 *
	 * @return void
	 */
	public static function statuses()
	{
		return self::STATUSES;
	}

	/**
	 * Get status label
	 *
	 * @return string
	 */
	public function statusLabel()
	{
		$statuses = $this->statuses();

		return isset($this->status) ? $statuses[$this->status] : null;
	}

	/**
	 * Get product types
	 *
	 * @return array
	 */
	public static function types()
	{
		return self::TYPES;
	}

	/**
	 * Scope new arrival product
	 *
	 * @param Eloquent $query query builder
	 *
	 * @return Eloquent
	 */
	public function scopeNewArrival($query)
	{
		return $query->where('status', 1)
			->where('parent_id', null);
	}

	/**
	 * Scope all products
	 *
	 * @param Eloquent $query query builder
	 *
	 * @return Eloquent
	 */
	public function scopeAllProduct($query)
	{
		return $query->where('status', 1)
			->where('parent_id', null);
	}

	/**
	 * Scope active product
	 *
	 * @param Eloquent $query query builder
	 *
	 * @return Eloquent
	 */
	public function scopeActive($query)
	{
		return $query->where('status', 1)
			->where('parent_id', null);
	}

	/**
	 * Scope popular products
	 *
	 * @param Eloquent $query query builder
	 * @param int      $limit limit
	 *
	 * @return Eloquent
	 */
	public function scopePopular($query, $limit = 10)
	{
		$month = now()->format('m');

		return $query->selectRaw('products.*, COUNT(order_items.id) as total_sold')
			->join('order_items', 'order_items.product_id', '=', 'products.id')
			->join('orders', 'order_items.order_id', '=', 'orders.id')
			->whereRaw(
				'orders.status = :order_satus AND MONTH(orders.order_date) = :month',
				[
					'order_status' => Order::COMPLETED,
					'month' => $month
				]
			)
			->groupBy('products.id')
			->orderByRaw('total_sold DESC')
			->limit($limit);
	}

	/**
	 * Get price label
	 *
	 * @return string
	 */
	public function priceLabel()
	{
		return ($this->variants->count() > 0) ? $this->variants->first()->price : $this->price;
	}

	/**
	 * Is configurable product
	 *
	 * @return boolean
	 */
	public function configurable()
	{
		return $this->type == 'configurable';
	}

	/**
	 * Is simple product
	 *
	 * @return boolean
	 */
	public function simple()
	{
		return $this->type == 'simple';
	}

	public function loadProduct($start, $length, $searchProdukAndUkm='', $count=false, $sort=false, $field=false, $id_ukm=false, $id_kategori=false, $condition=false, $hargaMinimal=false, $hargaMaksimal=false, $shop=null, $searchProduk='', $id_user='', $id_kecamatan='',  $kategori_produk=null, $id_jenis=false, $product_type = 0)
	{
		// DB::getQueryLog();
		$result = DB::table(DB::raw('products p'))
		->select(DB::raw("p.id as id_produk, p.name as nama_produk, p.price, p.slug, p.sku, brands.name as nama_kategori, product_images.medium as gambar, shops.name as nama_toko"))
		->leftJoin('product_brands', 'product_brands.product_id', '=', 'p.id')
		->leftJoin('product_categories', 'product_categories.product_id', '=', 'p.id')
		->leftJoin('categories', 'categories.id', '=', 'product_categories.category_id')
		->leftJoin('brands', 'brands.id', '=', 'product_brands.brand_id')
		->leftJoin('shops', 'shops.user_id', '=', 'p.user_id')
		->leftJoin(DB::raw('(SELECT MAX(id) as max_id, product_id FROM product_images GROUP BY product_id  )
               img'), 
        function($join)
        {
           $join->on('p.id', '=', 'img.product_id');
        })
		->join('product_images', 'product_images.id', 'img.max_id')
		->where('p.status', '1');
		
		if(!empty($searchProdukAndUkm)){
            $result = $result->where(function($where) use($searchProdukAndUkm){
                $where->where('p.name', 'LIKE', "%".$searchProdukAndUkm."%")
                ->orWhere('shops.name', 'LIKE', "%".$searchProdukAndUkm."%");
            });
        }

		if($hargaMinimal == true){
            $result = $result->whereRaw("p.price >= ".$hargaMinimal);
        }

		if($hargaMaksimal == true){
            $result = $result->whereRaw("p.price <= ".$hargaMaksimal);
        }

		if($shop){
            $result = $result->whereRaw("p.shop_id = ".$shop);
        }

		if ($id_kategori){ 
			$result = $result->whereIn('product_categories.category_id', $id_kategori);
		}
		// ->where('products.status', 1);

		if($count == true){
            $result = $result->count();
        }else{
            $result  = $result->offset($start)->limit($length)->get();
        }
		// dd($result);
		// DB::getQueryLog(); die();
		return $result;
	}
}
