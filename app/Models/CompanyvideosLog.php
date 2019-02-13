<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CompanyvideosLog
 * 
 * @property string $companyid
 * @property string $videotitle
 * @property string $videopath
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class CompanyvideosLog extends Eloquent
{
	protected $table = 'companyvideos_log';
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
}
