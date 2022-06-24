<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentConfirmation extends Model
{
    use HasFactory;

    protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];

	public const UPLOAD_DIR = 'uploads/payments';

    public const EXTRA_LARGE = '1920x643';
	public const MEDIUM = '312x400';
	public const SMALL = '135x75';

    /**
	 * Define relationship with the User
	 *
	 * @return void
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

    public function orders()
    {
        return $this->belongsTo(Order::class, 'payment_confirm_id');
    }
}
