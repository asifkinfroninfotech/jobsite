<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DdAnswersLog
 * 
 * @property int $ddanswerlogid
 * @property string $answerid
 * @property string $questionid
 * @property string $userid
 * @property string $answertext
 * @property string $tenantid
 * @property string $answerstatus
 * @property int $displayorder
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class DdAnswersLog extends Eloquent
{
	protected $table = 'dd_answers_log';
	protected $primaryKey = 'ddanswerlogid';
	public $timestamps = false;

	protected $casts = [
		'displayorder' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'answerid',
		'questionid',
		'userid',
		'answertext',
		'tenantid',
		'answerstatus',
		'displayorder',
		'updated'
	];
}
