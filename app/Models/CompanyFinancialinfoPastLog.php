<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Mar 2018 06:54:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CompanyFinancialinfoPastLog
 * 
 * @property int $companyfinancialinfologpastid
 * @property string $companyid
 * @property string $tenantid
 * @property string $historical_year
 * @property int $year_number
 * @property float $averageannualrevenue
 * @property float $annualoperatingcosts
 * @property float $averagenetincome
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class CompanyFinancialinfoPastLog extends Eloquent
{
	protected $table = 'company_financialinfo_past_log';
	protected $primaryKey = 'companyfinancialinfologpastid';
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
}
