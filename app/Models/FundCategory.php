<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FundCategory
 * 
 * @property int $fundcategoryid
 * @property string $fundid
 * @property string $tenantid
 * @property string $fund
 *
 * @package App\Models
 */
class FundCategory extends Eloquent
{
	protected $table = 'fund_category';
	protected $primaryKey = 'fundcategoryid';
	public $timestamps = false;

	protected $fillable = [
		'fundid',
		'tenantid',
		'fund'
	];
}
