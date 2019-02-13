<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Friend
 * 
 * @property string $tenantid
 * @property string $userid
 * @property string $friendid
 * @property string $recordtype
 * @property int $id
 * 
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Friend extends Eloquent
{
	public $timestamps = false;

	protected $fillable = [
		'tenantid',
		'userid',
		'friendid',
		'recordtype'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}
}
