<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Shop extends Model
{
    use HasFactory;

    protected $fillable=[
		'user_id', 
		'name',
		'slug', 
		'description',
		'rekening', 
		'atasnama', 
		'bank', 
		'original', 
		'medium', 
		'small'
	];
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

	public const MANDIRI = 'Bank Mandiri';
	public const BRI = 'BRI';
	public const BNI = 'BNI';
	public const PANIN = 'Panin Bank';
	public const BCA = 'BCA';
	public const CIMB = 'CIMB Niaga';
	public const PERMATA = 'Bank Permata';
	public const OCBC = 'OCBC NISP';
	public const BTPN = 'BTPN';
	public const DBS = 'DBS';
	public const BUKOPIN = 'Bank Bukopin';
	public const MEGA = 'Bank Mega';
	public const MAYORA = 'Bank Mayora';
	public const UOB = 'Bank UOB';
	public const MAYAPADA = 'Bank Mayapada International';
	public const AGRO = 'BRI Agro';
	public const ARTHA = 'Bank Artha Graha';
	public const COMMONWEALTH = 'Commonwealth Bank';
	public const HSBC = 'HSBC Indonesia';
	public const ICBC = 'ICBC Indonesia';
	public const OKE = 'Bank Oke Indonesia';
	public const MNC = 'MNC Bank';
	public const STANDARD = 'Standard Chartered Bank Indonesia';
	public const BNP = 'BNPParibas';
	public const SINARMAS = 'Bank Sinarmas';
	public const MAYBANK = 'Maybank Indonesia';
	public const CITIBANK = 'Citibank Indonesia';
	public const MUAMALAT = 'Bank Muamalat';
	public const BJB = 'Bank BJB';
	
	public const BANKS = [
		self::MANDIRI => 'Bank Mandiri',
		self::BRI => 'BRI',
		self::BNI => 'BNI',
		self::PANIN => 'Panin Bank',
		self::BCA => 'BCA',
		self::CIMB => 'CIMB Niaga',
		self::PERMATA => 'Bank Permata',
		self::OCBC => 'OCBC NISP',
		self::BTPN => 'BTPN',
		self::DBS => 'DBS',
		self::BUKOPIN => 'Bank Bukopin',
		self::MEGA => 'Bank Mega',
		self::MAYORA => 'Bank Mayora',
		self::UOB => 'Bank UOB',
		self::MAYAPADA => 'Bank Mayapada International',
		self::AGRO => 'BRI Agro',
		self::ARTHA => 'Bank Artha Graha',
		self::COMMONWEALTH => 'Commonwealth Bank',
		self::HSBC => 'HSBC Indonesia',
		self::ICBC => 'ICBC Indonesia',
		self::OKE => 'Bank Oke Indonesia',
		self::MNC => 'MNC Bank',
		self::STANDARD => 'Standard Chartered Bank Indonesia',
		self::BNP => 'BNPParibas',
		self::SINARMAS => 'Bank Sinarmas',
		self::MAYBANK => 'Maybank Indonesia',
		self::CITIBANK => 'Citibank Indonesia',
		self::MUAMALAT => 'Bank Muamalat',
		self::BJB => 'Bank BJB',
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
	 * Define relationship with the 
	 *
	 * @return void
	 */
	public static function statuses()
	{
		return self::STATUSES;
	}

	public static function banks()
	{
		return self::BANKS;
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
