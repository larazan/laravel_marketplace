<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'prod_id',
        'price',
        'quantity',
        'shop_id',
        'customer_id',
        'attributes',
    ];
}
