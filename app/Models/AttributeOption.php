<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'name'];

    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute');
    }
}
