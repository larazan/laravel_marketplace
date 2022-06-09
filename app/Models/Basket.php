<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Basket extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];

    // protected $fillable = [
    //     'id',
    //     'session_id',
    //     'product_id',
    //     'user_id',
    //     'qty',
    //     'is_checked',
    //     'attributes',
    // ];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $casts = [
        'attributes' => 'array',
    ];
}
