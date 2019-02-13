<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DocumentsLog
 * 
 * @property string $documentid
 * @property string $documentfolderid
 * @property string $userid
 * @property string $documentname
 * @property string $documenttitle
 * @property string $documentdescription
 * @property string $extention
 * @property int $documentstatus
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class DocumentsLog extends Eloquent
{
	protected $table = 'documents_log';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'documentstatus' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'documentid',
		'documentfolderid',
		'userid',
		'documentname',
		'documenttitle',
		'documentdescription',
		'extention',
		'documentstatus',
		'updated'
	];
}
