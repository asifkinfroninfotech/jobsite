<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Usergroup
 * 
 * @property string $usergroupid
 * @property string $tenantid
 * @property string $groupid
 * @property string $userid
 * @property \Carbon\Carbon $created
 * @property bool $activestatus
 * 
 * @property \App\Models\Group $group
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Usergroup extends Eloquent
{
	protected $primaryKey = 'usergroupid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'activestatus' => 'bool'
	];

	protected $dates = [
		'created'
	];

	protected $fillable = [
		'tenantid',
		'groupid',
		'userid',
		'created',
		'activestatus'
	];

	public function group()
	{
		return $this->belongsTo(\App\Models\Group::class, 'groupid');
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}
}
