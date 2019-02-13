<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TenantsPaymentHistory
 * 
 * @property string $tenantspaymenthistoryid
 * @property string $tenantid
 * @property string $planid
 * @property int $validity
 * @property float $price
 * @property \Carbon\Carbon $expirydate
 * @property int $paymentype
 * @property \Carbon\Carbon $paymentdate
 * @property float $paymentamount
 * @property string $paymentstatus
 * @property bool $activestatus
 * @property string $invoicenumber
 * 
 * @property \App\Models\Tenant $tenant
 * @property \App\Models\Plan $plan
 *
 * @package App\Models
 */
class TenantsPaymentHistory extends Eloquent
{
	protected $table = 'tenants_payment_history';
	protected $primaryKey = 'tenantspaymenthistoryid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'validity' => 'int',
		'price' => 'float',
		'paymentype' => 'int',
		'paymentamount' => 'float',
		'activestatus' => 'bool'
	];

	protected $dates = [
		'expirydate',
		'paymentdate'
	];

	protected $fillable = [
		'tenantid',
		'planid',
		'validity',
		'price',
		'expirydate',
		'paymentype',
		'paymentdate',
		'paymentamount',
		'paymentstatus',
		'activestatus',
		'invoicenumber'
	];

	public function tenant()
	{
		return $this->belongsTo(\App\Models\Tenant::class, 'tenantid', 'tenantid');
	}

	public function plan()
	{
		return $this->belongsTo(\App\Models\Plan::class, 'planid');
	}
}
