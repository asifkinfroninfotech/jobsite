<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Mar 2018 06:54:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Companyvideo
 * 
 * @property string $companyvideosid
 * @property string $companyid
 * @property string $videotitle
 * @property string $videopath
 * @property \Carbon\Carbon $updated
 * 
 * @property \App\Models\Company $company
 *
 * @package App\Models
 */
class Companyvideo extends Eloquent
{
	protected $primaryKey = 'companyvideosid';
	public $incrementing = false;
	public $timestamps = false;

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'companyid',
		'videotitle',
		'videopath',
		'updated'
	];

	public function company()
	{
		return $this->belongsTo(\App\Models\Company::class, 'companyid');
	}
}
