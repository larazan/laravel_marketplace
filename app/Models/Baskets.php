<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Baskets extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];

	/**
	 * Define relationship with the Product
	 *
	 * @return void
	 */
	// public function product()
	// {
	// 	return $this->belongsTo('App\Models\Product');
	// }
}
