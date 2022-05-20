<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Shop extends Model
{
    use HasFactory;

    protected $fillable=['user_id', 'name','slug', 'description','original', 'medium', 'small'];
	public const UPLOAD_DIR = 'uploads/shops';

    public const ACTIVE = 1;
	public const INACTIVE = 2;

	public const EXTRA_LARGE = '1920x643';
	public const MEDIUM = '312x400';
	public const SMALL = '135x75';

	public const STATUSES = [
		self::ACTIVE => 'active',
		self::INACTIVE => 'inactive',
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

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
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
	 * Scope active product
	 *
	 * @param Eloquent $query query builder
	 *
	 * @return Eloquent
	 */
	public function scopeActive($query)
	{
		return $query->where('is_active', self::ACTIVE);
	}

    public function products()
    {
        return $this->hasMany(Product::class, 'shop_id');
    }

	public function loadShop($start, $length, $slug='', $count=false)
	{
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
		// DB::getQueryLog(); die();
		return $result;
	}
}
