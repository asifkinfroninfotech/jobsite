<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PipelinefolderPermissionsLog
 * 
 * @property int $pipelinefolderpermissionlogid
 * @property string $folderid
 * @property string $userid
 * @property string $tenantid
 * @property string $permission
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class PipelinefolderPermissionsLog extends Eloquent
{
	protected $table = 'pipelinefolder_permissions_log';
	protected $primaryKey = 'pipelinefolderpermissionlogid';
	public $timestamps = false;

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'folderid',
		'userid',
		'tenantid',
		'permission',
		'updated'
	];
}
