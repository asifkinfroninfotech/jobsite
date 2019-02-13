<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Mar 2018 06:54:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CompanyLog
 * 
 * @property int $companylogid
 * @property string $tenantid
 * @property string $companyid
 * @property string $name
 * @property string $statusmessage
 * @property string $telephone
 * @property string $email
 * @property string $website
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
 * @property string $preferedaveragesize
 * @property string $fundsundermanagement
 * @property string $taxidnumber
 * @property int $numberofemployees
 * @property string $levelofinvolvement
 * @property bool $isonbehalfofinstitution
 * @property string $mission
 * @property string $outcomes
 * @property \Carbon\Carbon $updated
 * @property string $specializedsectors
 * @property string $teamsize
 * @property int $noofenterprisesupported
 * @property string $aboutus
 * @property string $affiliations
 * @property string $foundedyear
 * @property string $corecompetenciesids
 * @property string $previousclients
 * @property string $pastclients
 * @property string $accountingcompanytype
 * @property string $preferedcurrencyid
 * @property string $sectorid
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
 *
 * @package App\Models
 */
class CompanyLog extends Eloquent
{
	protected $table = 'company_log';
	protected $primaryKey = 'companylogid';
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
		'companyid',
		'name',
		'statusmessage',
		'telephone',
		'email',
		'website',
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
		'preferedaveragesize',
		'fundsundermanagement',
		'taxidnumber',
		'numberofemployees',
		'levelofinvolvement',
		'isonbehalfofinstitution',
		'mission',
		'outcomes',
		'updated',
		'specializedsectors',
		'teamsize',
		'noofenterprisesupported',
		'aboutus',
		'affiliations',
		'foundedyear',
		'corecompetenciesids',
		'previousclients',
		'pastclients',
		'accountingcompanytype',
		'preferedcurrencyid',
		'sectorid',
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
		'impactinfo_specificbeneficiaries'
	];
}
