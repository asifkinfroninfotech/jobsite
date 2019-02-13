<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Document
 * 
 * @property string $documentid
 * @property string $userid
 * @property string $documentname
 * @property string $documenttitle
 * @property string $documentdescription
 * @property string $extention
 * @property \Carbon\Carbon $updated
 * @property \Carbon\Carbon $loggedoutdate
 * @property string $documentstatus
 * @property string $companyid
 * 
 * @property \App\Models\Company $company
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Document extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'updated',
		'loggedoutdate'
	];

	protected $fillable = [
		'documentid',
		'userid',
		'documentname',
		'documenttitle',
		'documentdescription',
		'extention',
		'updated',
		'loggedoutdate',
		'documentstatus',
		'companyid'
	];

	public function company()
	{
		return $this->belongsTo(\App\Models\Company::class, 'companyid');
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}
}
