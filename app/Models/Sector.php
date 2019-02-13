<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Sector
 * 
 * @property string $sectorid
 * @property string $name
 * @property string $tenantid
 *
 * @package App\Models
 */
class Sector extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'sectorid',
		'name',
		'tenantid'
	];
}
