<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use App\Helpers\General;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
		'user_id',
		'code',
		'status',
		'customer_id',
		'shop_id',
		'order_date',
		'payment_due',
		'payment_status',
		'base_total_price',
		'tax_amount',
		'tax_percent',
		'discount_amount',
		'discount_percent',
		'shipping_cost',
		'grand_total',
		'note',
		'customer_first_name',
		'customer_last_name',
		'customer_address1',
		'customer_address2',
		'customer_phone',
		'customer_email',
		'customer_city_id',
		'customer_province_id',
		'customer_postcode',
		'shipping_courier',
		'shipping_service_name',
		'approved_by',
		'approved_at',
		'cancelled_by',
		'cancelled_at',
		'cancellation_note',
		'opened',
		'opened_cus',
		'opened_shopper',
		'income_rank'
	];

	protected $appends = ['customer_full_name'];
	
	public const CREATED = 'created';
	public const CONFIRMED = 'confirmed';
	public const DELIVERED = 'delivered';
	public const COMPLETED = 'completed';
	public const CANCELLED = 'cancelled';

	public const ORDERCODE = 'INV';

	public const PAID = 'paid';
	public const UNPAID = 'unpaid';

	public const STATUSES = [
		self::CREATED => 'Created',
		self::CONFIRMED => 'Confirmed',
		self::DELIVERED => 'Delivered',
		self::COMPLETED => 'Completed',
		self::CANCELLED => 'Cancelled',
	];
	/**
	 * Define relationship with the Shipment
	 *
	 * @return void
	 */
	public function shipment()
	{
		return $this->hasOne('App\Models\Shipment');
	}

	/**
	 * Define relationship with the OrderItem
	 *
	 * @return void
	 */
	public function orderItems()
	{
		return $this->hasMany('App\Models\OrderItem');
	}

	/**
	 * Define relationship with the PaymentConfirmation
	 *
	 * @return void
	 */
	public function paymentConfirmation()
	{
		return $this->belongsTo('App\Models\PaymentConfirmation');
	}

	/**
	 * Define relationship with the User
	 *
	 * @return void
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Define scope forUser
	 *
	 * @param Eloquent $query query builder
	 * @param User     $user  limit
	 *
	 * @return void
	 */
	public function scopeForUser($query, $user)
	{
		return $query->where('user_id', $user->id);
	}

	/**
	 * Generate order code
	 *
	 * @return string
	 */
	public static function generateCode()
	{
		$dateCode = self::ORDERCODE . '/' . date('Ymd') . '/' .General::integerToRoman(date('m')). '/' .General::integerToRoman(date('d')). '/';

		$lastOrder = self::select([DB::raw('MAX(orders.code) AS last_code')])
			->where('code', 'like', $dateCode . '%')
			->first();

		$lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
		
		$orderCode = $dateCode . '00001';
		if ($lastOrderCode) {
			$lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
			$nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
			
			$orderCode = $dateCode . $nextOrderNumber;
		}

		if (self::_isOrderCodeExists($orderCode)) {
			return generateOrderCode();
		}

		return $orderCode;
	}

	/**
	 * Check if the generated order code is exists
	 *
	 * @param string $orderCode order code
	 *
	 * @return void
	 */
	private static function _isOrderCodeExists($orderCode)
	{
		return Order::where('code', '=', $orderCode)->exists();
	}

	/**
	 * Check order is paid or not
	 *
	 * @return boolean
	 */
	public function isPaid()
	{
		return $this->payment_status == self::PAID;
	}

	/**
	 * Check order is created
	 *
	 * @return boolean
	 */
	public function isCreated()
	{
		return $this->status == self::CREATED;
	}

	/**
	 * Check order is confirmed
	 *
	 * @return boolean
	 */
	public function isConfirmed()
	{
		return $this->status == self::CONFIRMED;
	}

	/**
	 * Check order is delivered
	 *
	 * @return boolean
	 */
	public function isDelivered()
	{
		return $this->status == self::DELIVERED;
	}

	/**
	 * Check order is completed
	 *
	 * @return boolean
	 */
	public function isCompleted()
	{
		return $this->status == self::COMPLETED;
	}

	/**
	 * Check order is cancelled
	 *
	 * @return boolean
	 */
	public function isCancelled()
	{
		return $this->status == self::CANCELLED;
	}

	/**
	 * Add full_name custom attribute to order object
	 *
	 * @return boolean
	 */
	public function getCustomerFullNameAttribute()
	{
		return "{$this->customer_first_name} {$this->customer_last_name}";
	}

	//! saveHelper func saving to database
	public static function saveHelper($dcentroid1, $dcentroid2, $dcentroid3, $dcentroid4, $dcentroid5, $mindistance, $clusterall){
		return DB::table('centroids')->insert([
	    	'distancecentroid1'		=> $dcentroid1,
	    	'distancecentroid2'		=> $dcentroid2,
	    	'distancecentroid3'		=> $dcentroid3,
	    	'distancecentroid4'		=> $dcentroid4,
	    	'distancecentroid5'		=> $dcentroid5,
	    	'mindistance'		=> $mindistance,
	    	'cluster'		=> $clusterall,	    			
    	]);
	}

	public static function deleteHelper(){
		return DB::select("TRUNCATE Table centroids");
	}

	//! groupby
	public static function groupClusterHelper(){
		//return DB::table('centroids')->groupBy('cluster',2);
		return DB::table('centroids')
					->select(DB::raw('cluster as cluster'), DB::raw('avg(mindistance) as average'))
					->groupBy(DB::raw('cluster') )
					->get();
		//return DB::select('select distancecentroid2,cluster from centroids group by cluster');	 
	}
	//! geouping count same value on cluster
	public static function groupingSameValueCluster(){				
		return DB::table('centroids')
					->select('cluster',DB::raw('mindistance as "mindistance"'),DB::raw('count(*) as count'))					
					->groupBy('cluster',DB::raw('mindistance'))					
					->get();
	}
}
