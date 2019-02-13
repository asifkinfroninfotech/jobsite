<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Pipelinedeal
 * 
 * @property string $pipelinedealid
 * @property string $parentpipelinedealid
 * @property string $tenantid
 * @property string $dealid
 * @property string $companyid
 * @property string $pipelinedealstatus
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\Company $company
 * @property \App\Models\Deal $deal
 * @property \Illuminate\Database\Eloquent\Collection $dd_modules
 * @property \App\Models\DdQuestion $dd_question
 * @property \Illuminate\Database\Eloquent\Collection $pipelinedeal_messages
 * @property \Illuminate\Database\Eloquent\Collection $pipelinefolders
 * @property \Illuminate\Database\Eloquent\Collection $pipelinemessaginggroups
 *
 * @package App\Models
 */
class Pipelinedeal extends Eloquent
{
	protected $primaryKey = 'pipelinedealid';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'parentpipelinedealid',
		'tenantid',
		'dealid',
		'companyid',
		'pipelinedealstatus',
		'updated'
	];

	public function company()
	{
		return $this->belongsTo(\App\Models\Company::class, 'companyid');
	}

	public function deal()
	{
		return $this->belongsTo(\App\Models\Deal::class, 'dealid');
	}

	public function dd_modules()
	{
		return $this->hasMany(\App\Models\DdModule::class, 'pipelinedealid');
	}

	public function dd_question()
	{
		return $this->hasOne(\App\Models\DdQuestion::class, 'pipelinedealid');
	}

	public function pipelinedeal_messages()
	{
		return $this->hasMany(\App\Models\PipelinedealMessage::class, 'pipelinedealid');
	}

	public function pipelinefolders()
	{
		return $this->belongsToMany(\App\Models\Pipelinefolder::class, 'pipelinedeal_pipelinefolders', 'pipelinedealid', 'folderid')
					->withPivot('tenantid', 'pipelinedealfolderid');
	}

	public function pipelinemessaginggroups()
	{
		return $this->hasMany(\App\Models\Pipelinemessaginggroup::class, 'pipelinedealid');
	}
}
