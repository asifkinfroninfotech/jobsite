<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PipelinedealPipelinefolder
 * 
 * @property string $pipelinedealid
 * @property string $folderid
 * @property string $tenantid
 * @property int $pipelinedealfolderid
 * 
 * @property \App\Models\Pipelinedeal $pipelinedeal
 * @property \App\Models\Pipelinefolder $pipelinefolder
 *
 * @package App\Models
 */
class PipelinedealPipelinefolder extends Eloquent
{
	protected $primaryKey = 'pipelinedealfolderid';
	public $timestamps = false;

	protected $fillable = [
		'pipelinedealid',
		'folderid',
		'tenantid'
	];

	public function pipelinedeal()
	{
		return $this->belongsTo(\App\Models\Pipelinedeal::class, 'pipelinedealid');
	}

	public function pipelinefolder()
	{
		return $this->belongsTo(\App\Models\Pipelinefolder::class, 'folderid');
	}
}
