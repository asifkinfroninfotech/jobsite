<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UsersLog
 * 
 * @property string $tenantid
 * @property string $userid
 * @property string $username
 * @property string $userpassword
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string $userposition
 * @property string $address
 * @property string $city
 * @property string $zip
 * @property string $countryid
 * @property string $stateid
 * @property string $telephone
 * @property string $mobile
 * @property string $skype
 * @property string $twitter
 * @property string $statusmessage
 * @property string $profileimage
 * @property string $coverimage
 * @property string $personalbackground
 * @property bool $activestatus
 * @property \Carbon\Carbon $updated
 * @property string $name
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $userslogid
 *
 * @package App\Models
 */
class UsersLog extends Eloquent
{
	protected $table = 'users_log';
	protected $primaryKey = 'userslogid';

	protected $casts = [
		'activestatus' => 'bool'
	];

	protected $dates = [
		'updated'
	];

	protected $hidden = [
		'userpassword',
		'password',
		'remember_token'
	];

	protected $fillable = [
		'tenantid',
		'userid',
		'username',
		'userpassword',
		'email',
		'firstname',
		'lastname',
		'userposition',
		'address',
		'city',
		'zip',
		'countryid',
		'stateid',
		'telephone',
		'mobile',
		'skype',
		'twitter',
		'statusmessage',
		'profileimage',
		'coverimage',
		'personalbackground',
		'activestatus',
		'updated',
		'name',
		'password',
		'remember_token'
	];
}
