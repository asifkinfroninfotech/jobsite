<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Message
 * 
 * @property string $messageid
 * @property string $tenantid
 * @property string $userid
 * @property string $subject
 * @property string $messagebody
 * @property string $parentmessageid
 * @property bool $activestatus
 * @property \Carbon\Carbon $created
 * 
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $message_attachments
 * @property \Illuminate\Database\Eloquent\Collection $message_recipients
 *
 * @package App\Models
 */
class Message extends Eloquent
{
	protected $primaryKey = 'messageid';
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
		'userid',
		'subject',
		'messagebody',
		'parentmessageid',
		'activestatus',
		'created'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}

	public function message_attachments()
	{
		return $this->hasMany(\App\Models\MessageAttachment::class, 'messageid');
	}

	public function message_recipients()
	{
		return $this->hasMany(\App\Models\MessageRecipient::class, 'messageid');
	}
}
