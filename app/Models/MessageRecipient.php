<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MessageRecipient
 * 
 * @property string $recipientid
 * @property string $tenantid
 * @property string $userid
 * @property string $messageid
 * @property int $messagestatus
 * @property string $groupid
 * 
 * @property \App\Models\Group $group
 * @property \App\Models\Message $message
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class MessageRecipient extends Eloquent
{
	protected $primaryKey = 'recipientid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'messagestatus' => 'int'
	];

	protected $fillable = [
		'tenantid',
		'userid',
		'messageid',
		'messagestatus',
		'groupid'
	];

	public function group()
	{
		return $this->belongsTo(\App\Models\Group::class, 'groupid');
	}

	public function message()
	{
		return $this->belongsTo(\App\Models\Message::class, 'messageid');
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}
}
