<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Country
 * 
 * @property int $ID
 * @property string $name
 * @property string $code
 * @property string $dial_code
 * @property string $currency_name
 * @property string $currency_symbol
 * @property string $currency_code
 * @property bool $activestatus
 * @property string $countryid
 *
 * @package App\Models
 */
class Country extends Eloquent
{
	protected $table = 'country';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'activestatus' => 'bool'
	];

	protected $fillable = [
		'name',
		'code',
		'dial_code',
		'currency_name',
		'currency_symbol',
		'currency_code',
		'activestatus',
		'countryid'
	];
}
