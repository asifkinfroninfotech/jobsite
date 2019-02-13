<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DealsDocumentsLog
 * 
 * @property int $dealsdocumentlogid
 * @property string $documentid
 * @property string $dealid
 * @property string $tenantid
 * @property string $documentname
 * @property string $documenttitle
 * @property string $documentdescription
 * @property string $extention
 * @property int $documentstatus
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class DealsDocumentsLog extends Eloquent
{
	protected $table = 'deals_documents_log';
	protected $primaryKey = 'dealsdocumentlogid';
	public $timestamps = false;

	protected $casts = [
		'documentstatus' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'documentid',
		'dealid',
		'tenantid',
		'documentname',
		'documenttitle',
		'documentdescription',
		'extention',
		'documentstatus',
		'updated'
	];
}
