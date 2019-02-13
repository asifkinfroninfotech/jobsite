<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PipelinedealMessage
 * 
 * @property int $pipelinedealmessageid
 * @property string $pipelinedealid
 * @property string $messageid
 * @property string $tenantid
 * @property string $userid
 * @property string $subject
 * @property string $messagebody
 * @property string $parentmessageid
 * @property bool $activestatus
 * @property \Carbon\Carbon $created
 * 
 * @property \App\Models\Pipelinedeal $pipelinedeal
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $pipelinedeal_message_attachments
 * @property \Illuminate\Database\Eloquent\Collection $pipelinedeal_message_recipients
 *
 * @package App\Models
 */
class PipelinedealMessage extends Eloquent
{
	protected $primaryKey = 'pipelinedealmessageid';
	public $timestamps = false;

	protected $casts = [
		'activestatus' => 'bool'
	];

	protected $dates = [
		'created'
	];

	protected $fillable = [
		'pipelinedealid',
		'messageid',
		'tenantid',
		'userid',
		'subject',
		'messagebody',
		'parentmessageid',
		'activestatus',
		'created'
	];

	public function pipelinedeal()
	{
		return $this->belongsTo(\App\Models\Pipelinedeal::class, 'pipelinedealid');
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}

	public function pipelinedeal_message_attachments()
	{
		return $this->hasMany(\App\Models\PipelinedealMessageAttachment::class, 'messageid', 'messageid');
	}

	public function pipelinedeal_message_recipients()
	{
		return $this->hasMany(\App\Models\PipelinedealMessageRecipient::class, 'messageid', 'messageid');
	}
}
