<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UsercompaniesLog
 * 
 * @property string $tenantid
 * @property string $userid
 * @property string $companyid
 * @property int $recordstatus
 * @property int $userrole
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class UsercompaniesLog extends Eloquent
{
	protected $table = 'usercompanies_log';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'recordstatus' => 'int',
		'userrole' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'tenantid',
		'userid',
		'companyid',
		'recordstatus',
		'userrole',
		'updated'
	];
}
