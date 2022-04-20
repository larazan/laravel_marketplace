<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable=['user_id', 'name','slug', 'description','original','small'];
	public const UPLOAD_DIR = 'uploads/shops';

    public const ACTIVE = 'active';
	public const INACTIVE = 'inactive';

	public const EXTRA_LARGE = '1920x643';
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
}
