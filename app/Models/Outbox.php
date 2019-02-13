<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Outbox
 * 
 * @property string $outboxid
 * @property \Carbon\Carbon $created
 * @property \Carbon\Carbon $sentdate
 * @property string $fromemail
 * @property string $fromname
 * @property string $toemail
 * @property string $subject
 * @property string $body
 * @property string $emailstatus
 *
 * @package App\Models
 */
class Outbox extends Eloquent
{
	protected $table = 'outbox';
	protected $primaryKey = 'outboxid';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'created',
		'sentdate'
	];

	protected $fillable = [
		'created',
		'sentdate',
		'fromemail',
		'fromname',
		'toemail',
		'subject',
		'body',
		'emailstatus'
	];
}
