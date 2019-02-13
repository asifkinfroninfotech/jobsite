<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PipelinefolderPermission
 * 
 * @property int $pipelinefolderpermissionid
 * @property string $folderid
 * @property string $userid
 * @property string $tenantid
 * @property string $permission
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\Pipelinefolder $pipelinefolder
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class PipelinefolderPermission extends Eloquent
{
	protected $primaryKey = 'pipelinefolderpermissionid';
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

	public function pipelinefolder()
	{
		return $this->belongsTo(\App\Models\Pipelinefolder::class, 'folderid');
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}
}
