<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Test
 * 
 * @property string $filename
 *
 * @package App\Models
 */
class Test extends Eloquent
{
	protected $table = 'test';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'filename'
	];
}
