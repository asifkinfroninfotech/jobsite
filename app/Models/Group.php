<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Group
 * 
 * @property string $groupid
 * @property string $tenantid
 * @property string $groupname
 * @property \Carbon\Carbon $created
 * @property bool $activestatus
 * 
 * @property \Illuminate\Database\Eloquent\Collection $message_recipients
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class Group extends Eloquent
{
	protected $primaryKey = 'groupid';
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
		'groupname',
		'created',
		'activestatus'
	];

	public function message_recipients()
	{
		return $this->hasMany(\App\Models\MessageRecipient::class, 'groupid');
	}

	public function users()
	{
		return $this->belongsToMany(\App\Models\User::class, 'usergroups', 'groupid', 'userid')
					->withPivot('usergroupid', 'tenantid', 'created', 'activestatus');
	}
}
