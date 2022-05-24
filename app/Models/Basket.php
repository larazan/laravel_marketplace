<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'session_id',
        'name',
        'prod_id',
        'price',
        'quantity',
        'shop_id',
        'customer_id',
        'ip_address',
        'attributes',
    ];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $casts = [
        'attributes' => 'array',
    ];
}
