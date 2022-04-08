<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
<<<<<<< HEAD
        'first_name', 'last_name', 'email', 'phone', 'password', 'company', 'address1', 'address2', 'province_id', 'city_id', 'postcode',
=======
        'name',
        'email',
        'password',
        'phone',
>>>>>>> 5e4051f627d112163aa20e25ffb99e802286585a
    ];

    public const UPLOAD_DIR = 'uploads/user';
    public const EXTRA_LARGE = '1920x643';
	public const SMALL = '135x75';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
	{
		return $this->hasMany('App\Models\Product');
    }

    public function shop()
    {
        return $this->hasOne(Shop::class, 'user_id');
    }

    /**
	 * Define relationship with the Favorite
	 *
	 * @return void
	 */
	public function favorites()
	{
		return $this->hasMany('App\Models\Favorite');
	}
}
