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

    public const ACTIVE = 'active';
	public const INACTIVE = 'inactive';

	public const EXTRA_LARGE = '1920x643';
	public const MEDIUM = '312x400';
	public const SMALL = '135x75';

	public const STATUSES = [
		self::ACTIVE => 'Active',
		self::INACTIVE => 'Inactive',
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

	public function loadShop($start, $length, $searchProdukAndUkm='', $count=false, $sort=false, $field=false, $id_ukm=false, $id_kategori=false, $condition=false, $hargaMinimal=false, $hargaMaksimal=false, $searchProduk='', $id_user='', $id_kecamatan='',  $kategori_produk=null, $id_jenis=false, $product_type = 0)
	{
		$result = DB::table(DB::raw('products p'))
		->select(DB::raw("p.id as id_produk, p.name as nama_produk, p.price, p.slug, brands.name as nama_kategori, img.medium as gambar"))
		->join('product_brands', 'product_brands.product_id', '=', 'p.id')
		->join('brands', 'brands.id', '=', 'product_brands.brand_id')
		->leftJoin(DB::raw('(SELECT MAX(id) as max_id, product_id, medium FROM product_images GROUP BY product_id, medium  )
               img'), 
        function($join)
        {
           $join->on('p.id', '=', 'img.product_id');
        });

		if($count == true){
            $result = $result->count();
        }else{
            $result  = $result->offset($start)->limit($length)->get();
        }
		// DB::getQueryLog(); die();
		return $result;
	}
}
