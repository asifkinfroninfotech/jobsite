<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DdModule
 * 
 * @property string $moduleid
 * @property string $pipelinedealid
 * @property string $tenantid
 * @property string $modulename
 * @property string $modulestatus
 * @property int $displayorder
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\Pipelinedeal $pipelinedeal
 * @property \App\Models\DdQuestion $dd_question
 *
 * @package App\Models
 */
class DdModule extends Eloquent
{
	protected $primaryKey = 'moduleid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'displayorder' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'pipelinedealid',
		'tenantid',
		'modulename',
		'modulestatus',
		'displayorder',
		'updated'
	];

	public function pipelinedeal()
	{
		return $this->belongsTo(\App\Models\Pipelinedeal::class, 'pipelinedealid');
	}

	public function dd_question()
	{
		return $this->hasOne(\App\Models\DdQuestion::class, 'moduleid');
	}
}
