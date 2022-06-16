<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable=['user_id','product_id','rate','review','status'];

    public const ACTIVE = 'active';
	public const INACTIVE = 'inactive';

	public const STATUSES = [
		self::ACTIVE => 'Active',
		self::INACTIVE => 'Inactive',
	];
    
    /**
	 * Scope active review
	 *
	 * @param Eloquent $query query builder
	 *
	 * @return Eloquent
	 */
	public function scopeActive($query)
	{
		return $query->where('status', 'active');
	}

    public function user_info()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public static function getAllReview(){
        return ProductReview::with('user_info')->paginate(10);
    }
    public static function getAllUserReview(){
        return ProductReview::where('user_id',auth()->user()->id)->with('user_info')->paginate(10);
    }

    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
