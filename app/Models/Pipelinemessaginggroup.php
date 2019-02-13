<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Pipelinemessaginggroup
 * 
 * @property string $pipelinemessaginggroupid
 * @property string $pipelinedealid
 * @property string $groupname
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\Pipelinedeal $pipelinedeal
 *
 * @package App\Models
 */
class Pipelinemessaginggroup extends Eloquent
{
	protected $primaryKey = 'pipelinemessaginggroupid';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'pipelinedealid',
		'groupname',
		'updated'
	];

	public function pipelinedeal()
	{
		return $this->belongsTo(\App\Models\Pipelinedeal::class, 'pipelinedealid');
	}
}
