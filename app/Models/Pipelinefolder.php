<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Pipelinefolder
 * 
 * @property string $folderid
 * @property string $companyid
 * @property string $tenantid
 * @property string $foldername
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\Company $company
 * @property \Illuminate\Database\Eloquent\Collection $pipelinedeals
 * @property \Illuminate\Database\Eloquent\Collection $pipelinefolder_permissions
 *
 * @package App\Models
 */
class Pipelinefolder extends Eloquent
{
	protected $primaryKey = 'folderid';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'companyid',
		'tenantid',
		'foldername',
		'updated'
	];

	public function company()
	{
		return $this->belongsTo(\App\Models\Company::class, 'companyid');
	}

	public function pipelinedeals()
	{
		return $this->belongsToMany(\App\Models\Pipelinedeal::class, 'pipelinedeal_pipelinefolders', 'folderid', 'pipelinedealid')
					->withPivot('tenantid', 'pipelinedealfolderid');
	}

	public function pipelinefolder_permissions()
	{
		return $this->hasMany(\App\Models\PipelinefolderPermission::class, 'folderid');
	}
}
