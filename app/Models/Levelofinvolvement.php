<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Levelofinvolvement
 * 
 * @property int $levelofinvolvementid
 * @property string $tenantid
 * @property string $involvementlevel
 * @property bool $activestatus
 *
 * @package App\Models
 */
class Levelofinvolvement extends Eloquent
{
	protected $table = 'levelofinvolvement';
	protected $primaryKey = 'levelofinvolvementid';
	public $timestamps = false;

	protected $casts = [
		'activestatus' => 'bool'
	];

	protected $fillable = [
		'tenantid',
		'involvementlevel',
		'activestatus'
	];
}
