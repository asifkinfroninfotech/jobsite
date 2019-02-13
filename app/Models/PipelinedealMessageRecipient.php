<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PipelinedealMessageRecipient
 * 
 * @property string $recipientid
 * @property string $tenantid
 * @property string $userid
 * @property string $messageid
 * @property string $pipelinemessaginggroupid
 * @property string $messagestatus
 * 
 * @property \App\Models\PipelinedealMessage $pipelinedeal_message
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class PipelinedealMessageRecipient extends Eloquent
{
	protected $primaryKey = 'recipientid';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'tenantid',
		'userid',
		'messageid',
		'pipelinemessaginggroupid',
		'messagestatus'
	];

	public function pipelinedeal_message()
	{
		return $this->belongsTo(\App\Models\PipelinedealMessage::class, 'messageid', 'messageid');
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}
}
