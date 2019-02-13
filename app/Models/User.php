<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class User
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
 * @property bool $isadmin
 * 
 * @property \App\Models\DdQuestion $dd_question
 * @property \Illuminate\Database\Eloquent\Collection $deals
 * @property \App\Models\Document $document
 * @property \Illuminate\Database\Eloquent\Collection $friends
 * @property \Illuminate\Database\Eloquent\Collection $message_recipients
 * @property \Illuminate\Database\Eloquent\Collection $messages
 * @property \Illuminate\Database\Eloquent\Collection $pipelinedeal_message_recipients
 * @property \Illuminate\Database\Eloquent\Collection $pipelinedeal_messages
 * @property \Illuminate\Database\Eloquent\Collection $pipelinefolder_permissions
 * @property \App\Models\Usercompany $usercompany
 * @property \Illuminate\Database\Eloquent\Collection $groups
 *
 * @package App\Models
 */
class User extends Eloquent
{
	protected $primaryKey = 'userid';
	public $incrementing = false;

	protected $casts = [
		'activestatus' => 'bool',
		'isadmin' => 'bool'
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
		'remember_token',
		'isadmin'
	];

	public function dd_question()
	{
		return $this->hasOne(\App\Models\DdQuestion::class, 'userid');
	}

	public function deals()
	{
		return $this->hasMany(\App\Models\Deal::class, 'userid');
	}

	public function document()
	{
		return $this->hasOne(\App\Models\Document::class, 'userid');
	}

	public function friends()
	{
		return $this->hasMany(\App\Models\Friend::class, 'userid');
	}

	public function message_recipients()
	{
		return $this->hasMany(\App\Models\MessageRecipient::class, 'userid');
	}

	public function messages()
	{
		return $this->hasMany(\App\Models\Message::class, 'userid');
	}

	public function pipelinedeal_message_recipients()
	{
		return $this->hasMany(\App\Models\PipelinedealMessageRecipient::class, 'userid');
	}

	public function pipelinedeal_messages()
	{
		return $this->hasMany(\App\Models\PipelinedealMessage::class, 'userid');
	}

	public function pipelinefolder_permissions()
	{
		return $this->hasMany(\App\Models\PipelinefolderPermission::class, 'userid');
	}

	public function usercompany()
	{
		return $this->hasOne(\App\Models\Usercompany::class, 'userid');
	}

	public function groups()
	{
		return $this->belongsToMany(\App\Models\Group::class, 'usergroups', 'userid', 'groupid')
					->withPivot('usergroupid', 'tenantid', 'created', 'activestatus');
	}
}
