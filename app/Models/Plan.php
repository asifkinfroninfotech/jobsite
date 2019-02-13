<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Plan
 * 
 * @property string $planid
 * @property string $plandname
 * @property string $plandescription
 * @property string $planhtml
 * @property int $days
 * @property float $price
 * @property string $plandstatus
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tenants_payment_histories
 *
 * @package App\Models
 */
class Plan extends Eloquent
{
	protected $primaryKey = 'planid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'days' => 'int',
		'price' => 'float'
	];

	protected $fillable = [
		'plandname',
		'plandescription',
		'planhtml',
		'days',
		'price',
		'plandstatus'
	];

	public function tenants_payment_histories()
	{
		return $this->hasMany(\App\Models\TenantsPaymentHistory::class, 'planid');
	}
}
