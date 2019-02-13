<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PipelinedealMessageAttachment
 * 
 * @property string $attachmentid
 * @property string $tenantid
 * @property string $messageid
 * @property string $filename
 * @property string $location
 * @property string $filetype
 * 
 * @property \App\Models\PipelinedealMessage $pipelinedeal_message
 *
 * @package App\Models
 */
class PipelinedealMessageAttachment extends Eloquent
{
	protected $primaryKey = 'attachmentid';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'tenantid',
		'messageid',
		'filename',
		'location',
		'filetype'
	];

	public function pipelinedeal_message()
	{
		return $this->belongsTo(\App\Models\PipelinedealMessage::class, 'messageid', 'messageid');
	}
}
