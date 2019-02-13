<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DdQuestion
 * 
 * @property string $questionid
 * @property string $moduleid
 * @property string $pipelinedealid
 * @property string $tenantid
 * @property string $questiontext
 * @property string $userid
 * @property string $questionstatus
 * @property int $displayorder
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\Pipelinedeal $pipelinedeal
 * @property \App\Models\DdModule $dd_module
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $dd_answers
 *
 * @package App\Models
 */
class DdQuestion extends Eloquent
{

	protected $primaryKey = 'questionid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'displayorder' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'questionid',
		'moduleid',
		'pipelinedealid',
		'tenantid',
		'questiontext',
		'userid',
		'questionstatus',
		'displayorder',
		'updated'
	];

	public function pipelinedeal()
	{
		return $this->belongsTo(\App\Models\Pipelinedeal::class, 'pipelinedealid');
	}

	public function dd_module()
	{
		return $this->belongsTo(\App\Models\DdModule::class, 'moduleid');
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}

	public function dd_answers()
	{
		return $this->hasMany(\App\Models\DdAnswer::class, 'questionid', 'questionid');
	}
}
