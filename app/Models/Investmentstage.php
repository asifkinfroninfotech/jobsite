<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Investmentstage
 * 
 * @property string $investmentstageid
 * @property string $tenantid
 * @property string $stagename
 *
 * @package App\Models
 */
class Investmentstage extends Eloquent
{
	protected $primaryKey = 'investmentstageid';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'tenantid',
		'stagename'
	];
}
