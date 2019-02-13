<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Mar 2018 06:54:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CompanyFinancialinfoPast
 * 
 * @property int $companyfinancialinfopastid
 * @property string $companyid
 * @property string $tenantid
 * @property string $historical_year
 * @property int $year_number
 * @property float $averageannualrevenue
 * @property float $annualoperatingcosts
 * @property float $averagenetincome
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\Company $company
 *
 * @package App\Models
 */
class CompanyFinancialinfoPast extends Eloquent
{
	protected $table = 'company_financialinfo_past';
	protected $primaryKey = 'companyfinancialinfopastid';
	public $timestamps = false;

	protected $casts = [
		'year_number' => 'int',
		'averageannualrevenue' => 'float',
		'annualoperatingcosts' => 'float',
		'averagenetincome' => 'float'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'companyid',
		'tenantid',
		'historical_year',
		'year_number',
		'averageannualrevenue',
		'annualoperatingcosts',
		'averagenetincome',
		'updated'
	];

	public function company()
	{
		return $this->belongsTo(\App\Models\Company::class, 'companyid');
	}
}
