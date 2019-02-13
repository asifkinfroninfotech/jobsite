<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Fundsundermanagement
 * 
 * @property int $fundsundermanagementid
 * @property string $tenantid
 * @property string $fund
 * @property bool $activestatus
 *
 * @package App\Models
 */
class Fundsundermanagement extends Eloquent
{
	protected $table = 'fundsundermanagement';
	protected $primaryKey = 'fundsundermanagementid';
	public $timestamps = false;

	protected $casts = [
		'activestatus' => 'bool'
	];

	protected $fillable = [
		'tenantid',
		'fund',
		'activestatus'
	];
}
