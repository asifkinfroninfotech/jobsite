<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Mar 2018 06:54:24 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Averageinvestmentsize
 * 
 * @property int $averageinvestmentsizeid
 * @property string $tenantid
 * @property string $investmentsize
 * @property bool $activestatus
 *
 * @package App\Models
 */
class Averageinvestmentsize extends Eloquent
{
	protected $primaryKey = 'averageinvestmentsizeid';
	public $timestamps = false;

	protected $casts = [
		'activestatus' => 'bool'
	];

	protected $fillable = [
		'tenantid',
		'investmentsize',
		'activestatus'
	];
}
