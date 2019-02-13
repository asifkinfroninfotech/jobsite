<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class State
 * 
 * @property int $ID
 * @property string $name
 * @property int $country_id
 * @property string $stateid
 * @property string $countryid
 *
 * @package App\Models
 */
class State extends Eloquent
{
	protected $table = 'state';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'country_id' => 'int'
	];

	protected $fillable = [
		'name',
		'country_id',
		'stateid',
		'countryid'
	];
}
