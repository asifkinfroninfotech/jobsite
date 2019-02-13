<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Mar 2018 06:54:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Companysector
 * 
 * @property string $companyid
 * @property string $tenantid
 * @property string $sectorid
 * @property \Carbon\Carbon $updated
 * @property string $companysectorid
 * 
 * @property \App\Models\Company $company
 *
 * @package App\Models
 */
class Companysector extends Eloquent
{
	protected $primaryKey = 'companysectorid';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'companyid',
		'tenantid',
		'sectorid',
		'updated'
	];

	public function company()
	{
		return $this->belongsTo(\App\Models\Company::class, 'companyid');
	}
}
