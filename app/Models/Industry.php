<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Industry
 * 
 * @property string $industryid
 * @property string $tenantid
 * @property string $industryname
 *
 * @package App\Models
 */
class Industry extends Eloquent
{
	protected $table = 'industry';
	protected $primaryKey = 'industryid';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'tenantid',
		'industryname'
	];
}
