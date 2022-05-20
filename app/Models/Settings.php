<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable=['title', 'meta_description', 'meta_keyword', 'short_des','description','photo','address','phone','email', 'twitter', 'facebook', 'instagram', 'logo', 'original', 'medium', 'small'];

    public const UPLOAD_DIR = 'uploads/setting';

    public const MEDIUM = '312x400';
	public const SMALL = '135x75';

    public const ID = 1;
}
