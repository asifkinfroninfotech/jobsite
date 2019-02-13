<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PipelinefoldersLog
 * 
 * @property string $userid
 * @property string $tenantid
 * @property string $folderid
 * @property string $foldername
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class PipelinefoldersLog extends Eloquent
{
	protected $table = 'pipelinefolders_log';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'userid',
		'tenantid',
		'folderid',
		'foldername',
		'updated'
	];
}
