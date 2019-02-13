<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Content
 * 
 * @property int $id
 * @property string $tenantid
 * @property string $contentid
 * @property string $title
 * @property string $slug
 * @property string $contenthtml
 * @property int $displayorder
 * @property string $contentstatus
 * @property \Carbon\Carbon $updated
 *
 * @package App\Models
 */
class Content extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'displayorder' => 'int'
	];

	protected $dates = [
		'updated'
	];

	protected $fillable = [
		'tenantid',
		'contentid',
		'title',
		'slug',
		'contenthtml',
		'displayorder',
		'contentstatus',
		'updated'
	];
}
