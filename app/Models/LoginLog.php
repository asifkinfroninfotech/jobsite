<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LoginLog
 * 
 * @property int $loginlogid
 * @property string $tenantid
 * @property string $userid
 * @property string $username
 * @property \Carbon\Carbon $loggedindate
 * @property \Carbon\Carbon $loggedoutdate
 *
 * @package App\Models
 */
class LoginLog extends Eloquent
{
	protected $table = 'login_log';
	protected $primaryKey = 'loginlogid';
	public $timestamps = false;

	protected $dates = [
		'loggedindate',
		'loggedoutdate'
	];

	protected $fillable = [
		'tenantid',
		'userid',
		'username',
		'loggedindate',
		'loggedoutdate'
	];
}
