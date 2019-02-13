<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MessageAttachment
 * 
 * @property string $attachmentid
 * @property string $messageid
 * @property string $tenantid
 * @property string $filename
 * @property string $location
 * @property string $filetype
 * 
 * @property \App\Models\Message $message
 *
 * @package App\Models
 */
class MessageAttachment extends Eloquent
{
	protected $primaryKey = 'attachmentid';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'messageid',
		'tenantid',
		'filename',
		'location',
		'filetype'
	];

	public function message()
	{
		return $this->belongsTo(\App\Models\Message::class, 'messageid');
	}
}
