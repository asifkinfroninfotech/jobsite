<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DdModulesLog
 * 
 * @property int $ddmodulelogid
 * @property string $moduleid
 * @property string $userid
 * @property string $pipelinedealid
 * @property string $tenantid
 * @property string $modulename
 * @property string $modulestatus
 * @property int $displayorder
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class DdModulesLog extends Eloquent
{
	protected $table = 'dd_modules_log';
	protected $primaryKey = 'ddmodulelogid';
	public $timestamps = false;

	protected $casts = [
		'displayorder' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'moduleid',
		'userid',
		'pipelinedealid',
		'tenantid',
		'modulename',
		'modulestatus',
		'displayorder',
		'updated'
	];
}
