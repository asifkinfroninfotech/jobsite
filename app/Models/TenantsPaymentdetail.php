<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TenantsPaymentdetail
 * 
 * @property int $tenant_paymentdetailsid
 * @property string $tenantid
 * @property string $carttype
 * @property string $last4digits
 * @property string $expirydate
 * @property string $token
 * @property string $vpstxid
 * @property string $securitykey
 * @property string $paymentstatus
 * @property string $statusdescription
 * @property string $gatewaydata
 * @property string $invoicenumber
 * @property string $customerid
 * 
 * @property \App\Models\Tenant $tenant
 *
 * @package App\Models
 */
class TenantsPaymentdetail extends Eloquent
{
	protected $primaryKey = 'tenant_paymentdetailsid';
	public $timestamps = false;

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'tenantid',
		'carttype',
		'last4digits',
		'expirydate',
		'token',
		'vpstxid',
		'securitykey',
		'paymentstatus',
		'statusdescription',
		'gatewaydata',
		'invoicenumber',
		'customerid'
	];

	public function tenant()
	{
		return $this->belongsTo(\App\Models\Tenant::class, 'tenantid', 'tenantid');
	}
}
