<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DealsDocument
 * 
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
 * @property \App\Models\Deal $deal
 *
 * @package App\Models
 */
class DealsDocument extends Eloquent
{
	protected $primaryKey = 'documentid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'documentstatus' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'dealid',
		'tenantid',
		'documentname',
		'documenttitle',
		'documentdescription',
		'extention',
		'documentstatus',
		'updated'
	];

	public function deal()
	{
		return $this->belongsTo(\App\Models\Deal::class, 'dealid');
	}
}
