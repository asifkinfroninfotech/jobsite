<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Mar 2018 06:54:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Companytype
 * 
 * @property string $companytypeid
 * @property string $companytype
 * 
 * @property \Illuminate\Database\Eloquent\Collection $companies
 *
 * @package App\Models
 */
class Companytype extends Eloquent
{
	protected $primaryKey = 'companytypeid';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'companytype'
	];

	public function companies()
	{
		return $this->hasMany(\App\Models\Company::class, 'companytypeid');
	}
}
