<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Mar 2018 06:54:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class City
 * 
 * @property int $ID
 * @property string $name
 * @property int $state_id
 * @property string $stateid
 *
 * @package App\Models
 */
class City extends Eloquent
{
	protected $table = 'city';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'state_id' => 'int'
	];

	protected $fillable = [
		'name',
		'state_id',
		'stateid'
	];
}
