<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DdAnswer
 * 
 * @property string $answerid
 * @property string $questionid
 * @property string $userid
 * @property string $answertext
 * @property string $tenantid
 * @property string $answerstatus
 * @property int $displayorder
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\DdQuestion $dd_question
 * @property \Illuminate\Database\Eloquent\Collection $dd_answers_documents
 *
 * @package App\Models
 */
class DdAnswer extends Eloquent
{
	protected $primaryKey = 'answerid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'displayorder' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'questionid',
		'userid',
		'answertext',
		'tenantid',
		'answerstatus',
		'displayorder',
		'updated'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}

	public function dd_question()
	{
		return $this->belongsTo(\App\Models\DdQuestion::class, 'questionid', 'questionid');
	}

	public function dd_answers_documents()
	{
		return $this->hasMany(\App\Models\DdAnswersDocument::class, 'answerid');
	}
}
