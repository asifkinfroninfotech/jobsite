<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DdQuestionsLog
 * 
 * @property int $ddquestionlogid
 * @property string $questionid
 * @property string $moduleid
 * @property string $pipelinedealid
 * @property string $tenantid
 * @property string $questiontext
 * @property string $userid
 * @property string $questionstatus
 * @property int $displayorder
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class DdQuestionsLog extends Eloquent
{
	protected $table = 'dd_questions_log';
	protected $primaryKey = 'ddquestionlogid';
	public $timestamps = false;

	protected $casts = [
		'displayorder' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'questionid',
		'moduleid',
		'pipelinedealid',
		'tenantid',
		'questiontext',
		'userid',
		'questionstatus',
		'displayorder',
		'updated'
	];
}
