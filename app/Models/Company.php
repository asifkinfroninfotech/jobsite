<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Mar 2018 06:54:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Company
 * 
 * @property string $tenantid
 * @property string $companyid
 * @property string $name
 * @property string $statusmessage
 * @property string $telephone
 * @property string $email
 * @property string $website
 * @property string $skype
 * @property string $twitter
 * @property string $address
 * @property string $city
 * @property string $zip
 * @property string $countryid
 * @property string $stateid
 * @property string $profileimage
 * @property string $coverimage
 * @property int $yearsinvolved
 * @property int $numbertodate
 * @property string $preferedinvestmentaveragesize
 * @property string $fundsundermanagement
 * @property string $taxidnumber
 * @property int $numberofemployees
 * @property string $levelofinvolvement
 * @property bool $isonbehalfofinstitution
 * @property string $mission
 * @property string $outcomes
 * @property \Carbon\Carbon $updated
 * @property string $specializedsectors
 * @property string $teamsizeid
 * @property int $noofenterprisesupported
 * @property string $aboutus
 * @property string $affiliations
 * @property string $foundedyear
 * @property string $corecompetenciesids
 * @property string $previousclients
 * @property string $pastclients
 * @property string $accountingcompanytype
 * @property string $preferedcurrencyid
 * @property string $referredbyid
 * @property string $businesssummary
 * @property string $onelinepitch
 * @property string $salesstrategy
 * @property string $competativeadvantage
 * @property string $existingpatents
 * @property string $recognition
 * @property string $hearaboutartha
 * @property string $companytypeid
 * @property \Carbon\Carbon $financialinfo_informationdate
 * @property float $financialinfo_currentassets
 * @property float $financialinfo_totalassets
 * @property float $financialinfo_currentliabilities
 * @property float $financialinfo_totalliabilities
 * @property float $financialinfo_totalequity
 * @property float $financialinfo_netcash
 * @property float $financialinfo_ebitda
 * @property bool $financialinfo_auditedfinancialstatement
 * @property string $impactinfo_info
 * @property string $impactinfo_socialbenefitimpact
 * @property string $impactinfo_environmentbenefitimpact
 * @property string $impactinfo_specificbeneficiaries
 * @property string $position
 * 
 * @property \App\Models\Companytype $companytype
 * @property \Illuminate\Database\Eloquent\Collection $company_financialinfo_pasts
 * @property \Illuminate\Database\Eloquent\Collection $companysectors
 * @property \Illuminate\Database\Eloquent\Collection $companyvideos
 * @property \Illuminate\Database\Eloquent\Collection $companyvisitors
 * @property \Illuminate\Database\Eloquent\Collection $deals
 * @property \App\Models\Document $document
 * @property \Illuminate\Database\Eloquent\Collection $pipelinedeals
 * @property \Illuminate\Database\Eloquent\Collection $pipelinefolders
 * @property \App\Models\Usercompany $usercompany
 *
 * @package App\Models
 */
class Company extends Eloquent
{
	protected $table = 'company';
	protected $primaryKey = 'companyid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'yearsinvolved' => 'int',
		'numbertodate' => 'int',
		'numberofemployees' => 'int',
		'isonbehalfofinstitution' => 'bool',
		'noofenterprisesupported' => 'int',
		'financialinfo_currentassets' => 'float',
		'financialinfo_totalassets' => 'float',
		'financialinfo_currentliabilities' => 'float',
		'financialinfo_totalliabilities' => 'float',
		'financialinfo_totalequity' => 'float',
		'financialinfo_netcash' => 'float',
		'financialinfo_ebitda' => 'float',
		'financialinfo_auditedfinancialstatement' => 'bool'
	];

	protected $dates = [
		'updated',
		'financialinfo_informationdate'
	];

	protected $fillable = [
		'tenantid',
		'name',
		'statusmessage',
		'telephone',
		'email',
		'website',
		'skype',
		'twitter',
		'address',
		'city',
		'zip',
		'countryid',
		'stateid',
		'profileimage',
		'coverimage',
		'yearsinvolved',
		'numbertodate',
		'preferedinvestmentaveragesize',
		'fundsundermanagement',
		'taxidnumber',
		'numberofemployees',
		'levelofinvolvement',
		'isonbehalfofinstitution',
		'mission',
		'outcomes',
		'updated',
		'specializedsectors',
		'teamsizeid',
		'noofenterprisesupported',
		'aboutus',
		'affiliations',
		'foundedyear',
		'corecompetenciesids',
		'previousclients',
		'pastclients',
		'accountingcompanytype',
		'preferedcurrencyid',
		'referredbyid',
		'businesssummary',
		'onelinepitch',
		'salesstrategy',
		'competativeadvantage',
		'existingpatents',
		'recognition',
		'hearaboutartha',
		'companytypeid',
		'financialinfo_informationdate',
		'financialinfo_currentassets',
		'financialinfo_totalassets',
		'financialinfo_currentliabilities',
		'financialinfo_totalliabilities',
		'financialinfo_totalequity',
		'financialinfo_netcash',
		'financialinfo_ebitda',
		'financialinfo_auditedfinancialstatement',
		'impactinfo_info',
		'impactinfo_socialbenefitimpact',
		'impactinfo_environmentbenefitimpact',
		'impactinfo_specificbeneficiaries',
		'position'
	];

	public function companytype()
	{
		return $this->belongsTo(\App\Models\Companytype::class, 'companytypeid');
	}

	public function company_financialinfo_pasts()
	{
		return $this->hasMany(\App\Models\CompanyFinancialinfoPast::class, 'companyid');
	}

	public function companysectors()
	{
		return $this->hasMany(\App\Models\Companysector::class, 'companyid');
	}

	public function companyvideos()
	{
		return $this->hasMany(\App\Models\Companyvideo::class, 'companyid');
	}

	public function companyvisitors()
	{
		return $this->hasMany(\App\Models\Companyvisitor::class, 'companyid');
	}

	public function deals()
	{
		return $this->hasMany(\App\Models\Deal::class, 'companyid');
	}

	public function document()
	{
		return $this->hasOne(\App\Models\Document::class, 'companyid');
	}

	public function pipelinedeals()
	{
		return $this->hasMany(\App\Models\Pipelinedeal::class, 'companyid');
	}

	public function pipelinefolders()
	{
		return $this->hasMany(\App\Models\Pipelinefolder::class, 'companyid');
	}

	public function usercompany()
	{
		return $this->hasOne(\App\Models\Usercompany::class, 'companyid');
	}
}
