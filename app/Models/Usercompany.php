<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Usercompany
 * 
 * @property string $tenantid
 * @property string $userid
 * @property string $companyid
 * @property int $recordstatus
 * @property int $userrole
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\User $user
 * @property \App\Models\Company $company
 *
 * @package App\Models
 */
class Usercompany extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'recordstatus' => 'int',
		'userrole' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'tenantid',
		'userid',
		'companyid',
		'recordstatus',
		'userrole',
		'updated'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}

	public function company()
	{
		return $this->belongsTo(\App\Models\Company::class, 'companyid');
	}
}
