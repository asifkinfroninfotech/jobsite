<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Companyvisitor
 * 
 * @property int $companyvisitorid
 * @property string $companyid
 * @property int $visitorcount
 * @property \Carbon\Carbon $visitdate
 * @property string $tenantid
 * 
 * @property \App\Models\Company $company
 *
 * @package App\Models
 */
class Companyvisitor extends Eloquent
{
	protected $primaryKey = 'companyvisitorid';
	public $timestamps = false;

	protected $casts = [
		'visitorcount' => 'int'
	];

	protected $dates = [
		'visitdate'
	];

	protected $fillable = [
		'companyid',
		'visitorcount',
		'visitdate',
		'tenantid'
	];

	public function company()
	{
		return $this->belongsTo(\App\Models\Company::class, 'companyid');
	}
}
