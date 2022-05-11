<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable=['code','type','value','status'];

    public const FIXED = 'fixed';
    public const PERCENT = 'percent';

    public const DRAFT = 'draft';
    public const ACTIVE = 'active';
	public const INACTIVE = 'inactive';

	public const STATUSES = [
        self::DRAFT => 'Draft',
		self::ACTIVE => 'Active',
		self::INACTIVE => 'Inactive',
	];

    public const TYPES = [
        self::FIXED => 'Fixed',
        self::PERCENT => 'Percent',
    ];

    /**
	 * Scope active product
	 *
	 * @param Eloquent $query query builder
	 *
	 * @return Eloquent
	 */
	public function scopeActive($query)
	{
		return $query->where('status', self::ACTIVE);
	}

    public static function findByCode($code){
        return self::where('code',$code)->first();
    }
    public function discount($total){
        if($this->type=="fixed"){
            return $this->value;
        }
        elseif($this->type=="percent"){
            return ($this->value /100)*$total;
        }
        else{
            return 0;
        }
    }
}
