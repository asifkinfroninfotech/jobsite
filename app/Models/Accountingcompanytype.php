<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Mar 2018 06:54:24 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Accountingcompanytype
 * 
 * @property string $accountingcompanytypeid
 * @property string $tenantid
 * @property string $companytype
 * @property bool $activestatus
 *
 * @package App\Models
 */
class Accountingcompanytype extends Eloquent
{
	protected $primaryKey = 'accountingcompanytypeid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'activestatus' => 'bool'
	];

	protected $fillable = [
		'tenantid',
		'companytype',
		'activestatus'
	];
}
