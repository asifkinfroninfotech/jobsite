<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DdAnswersDocumentsLog
 * 
 * @property int $answerdocumentlogid
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
 * @package App\Models
 */
class DdAnswersDocumentsLog extends Eloquent
{
	protected $table = 'dd_answers_documents_log';
	protected $primaryKey = 'answerdocumentlogid';
	public $timestamps = false;

	protected $casts = [
		'displayorder' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'documentid',
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
}
