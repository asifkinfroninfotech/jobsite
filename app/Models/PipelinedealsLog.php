<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PipelinedealsLog
 * 
 * @property int $pipelinedealslogid
 * @property string $pipelinedealid
 * @property string $tenantid
 * @property string $pipelinedealstatus
 * @property \Carbon\Carbon $updated
 * @property string $userid
 *
 * @package App\Models
 */
class PipelinedealsLog extends Eloquent
{
	protected $table = 'pipelinedeals_log';
	protected $primaryKey = 'pipelinedealslogid';
	public $timestamps = false;

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'pipelinedealid',
		'tenantid',
		'pipelinedealstatus',
		'updated',
		'userid'
	];
}
