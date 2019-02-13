<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Laravel\Cashier\Billable;


/**
 * Class Tenant
 * 
 * @property string $tenantid
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $phone
 * @property string $mobile
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $postcode
 * @property \Carbon\Carbon $updated
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tenants_payment_histories
 * @property \Illuminate\Database\Eloquent\Collection $tenants_paymentdetails
 *
 * @package App\Models
 */
class Tenant extends Eloquent 
{
        use Billable;
        protected $primaryKey = 'tenantid';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		
		'firstname',
		'lastname',
		'email',
		'phone',
		'mobile',
		'address1',
		'address2',
		'city',
		'state',
		'country',
		'postcode',
		'updated',
                'stripe_id', 
                'card_brand', 
                'card_last_four', 
                'trial_ends_at'
	];

	public function tenants_payment_histories()
	{
		return $this->hasMany(\App\Models\TenantsPaymentHistory::class, 'tenantid', 'tenantid');
	}

	public function tenants_paymentdetails()
	{
		return $this->hasMany(\App\Models\TenantsPaymentdetail::class, 'tenantid', 'tenantid');
	}
}
