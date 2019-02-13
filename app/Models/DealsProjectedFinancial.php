<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DealsProjectedFinancial
 * 
 * @property int $dealsprojectedfinancialsid
 * @property string $dealid
 * @property string $tenantid
 * @property string $projected_year
 * @property int $year_number
 * @property float $totalrevenue
 * @property float $totalannualoperatingcost
 * @property float $ebitda
 * @property float $netcash
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\Deal $deal
 *
 * @package App\Models
 */
class DealsProjectedFinancial extends Eloquent
{
	protected $primaryKey = 'dealsprojectedfinancialsid';
	public $timestamps = false;

	protected $casts = [
		'year_number' => 'int',
		'totalrevenue' => 'float',
		'totalannualoperatingcost' => 'float',
		'ebitda' => 'float',
		'netcash' => 'float'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'dealid',
		'tenantid',
		'projected_year',
		'year_number',
		'totalrevenue',
		'totalannualoperatingcost',
		'ebitda',
		'netcash',
		'updated'
	];

	public function deal()
	{
		return $this->belongsTo(\App\Models\Deal::class, 'dealid');
	}
}
