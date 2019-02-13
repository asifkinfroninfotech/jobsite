<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DdAnswersDocument
 * 
 * @property string $documentid
 * @property string $answerid
 * @property string $documentname
 * @property string $document_application_name
 * @property string $documenttype
 * @property string $userid
 * @property string $tenantid
 * @property string $documentstatus
 * @property int $displayorder
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\DdAnswer $dd_answer
 *
 * @package App\Models
 */
class DdAnswersDocument extends Eloquent
{
	protected $primaryKey = 'documentid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'displayorder' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'answerid',
		'documentname',
		'document_application_name',
		'documenttype',
		'userid',
		'tenantid',
		'documentstatus',
		'displayorder',
		'updated'
	];

	public function dd_answer()
	{
		return $this->belongsTo(\App\Models\DdAnswer::class, 'answerid');
	}
}
