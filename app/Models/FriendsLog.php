<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FriendsLog
 * 
 * @property string $tenantid
 * @property string $userid
 * @property string $friendid
 * @property string $recordtype
 *
 * @package App\Models
 */
class FriendsLog extends Eloquent
{
	protected $table = 'friends_log';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'tenantid',
		'userid',
		'friendid',
		'recordtype'
	];
}
