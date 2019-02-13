<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Mar 2018 06:54:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Bugreport
 * 
 * @property int $id
 * @property string $tenantid
 * @property string $bugreportid
 * @property string $youremail
 * @property string $pageurl
 * @property string $yourname
 * @property string $countryid
 * @property string $description
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class Bugreport extends Eloquent
{
	public $timestamps = false;

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'tenantid',
		'bugreportid',
		'youremail',
		'pageurl',
		'yourname',
		'countryid',
		'description',
		'updated'
	];
}
