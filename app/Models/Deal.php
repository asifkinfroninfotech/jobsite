<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 20 Mar 2018 11:02:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Deal
 * 
 * @property string $dealid
 * @property string $companyid
 * @property string $tenantid
 * @property string $proposedusesoffunds
 * @property string $investmentstage
 * @property float $monthlyoperatingcost
 * @property float $totalinvestmentrequired
 * @property float $premoneyvaluation
 * @property float $projectedirr
 * @property string $purposeofinvestment
 * @property string $investmentstructure
 * @property string $loanterm_year
 * @property string $loanterm_month
 * @property string $existinginvestors
 * @property string $additionaldetails
 * @property \Carbon\Carbon $updated
 * @property string $projectname
 * @property string $url
 * @property string $location
 * @property string $one_line_description
 * @property string $dealimage
 * @property int $deal_status
 * @property string $referred_by
 * @property int $nda_signed
 * @property float $amount_invested
 * @property \Carbon\Carbon $date_invested
 * @property int $drawdowns
 * @property int $co_investment_rights
 * @property string $notes
 * @property float $annual_revenue
 * @property string $directtype_teaser
 * @property string $directtype_tags
 * @property string $directtype_industry
 * @property float $directtype_deal_size
 * @property float $directtype_valuation
 * @property string $directtype_previously_funded
 * @property string $directtype_video_url
 * @property string $fundtype_fund_category
 * @property string $fundtype_industry_focus
 * @property float $fundtype_fund_size
 * @property string $fundtype_min_lp_commitment
 * @property float $fundtype_min_amount_per_investment
 * @property float $fundtype_max_amount_per_investment
 * @property string $fundtype_ticket_size_specification
 * @property string $fundtype_fund_fees
 * @property string $userid
 * 
 * @property \App\Models\Company $company
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $deals_documents
 * @property \Illuminate\Database\Eloquent\Collection $deals_projected_financials
 * @property \Illuminate\Database\Eloquent\Collection $pipelinedeals
 *
 * @package App\Models
 */
class Deal extends Eloquent
{
	protected $primaryKey = 'dealid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'monthlyoperatingcost' => 'float',
		'totalinvestmentrequired' => 'float',
		'premoneyvaluation' => 'float',
		'projectedirr' => 'float',
		'deal_status' => 'int',
		'nda_signed' => 'int',
		'amount_invested' => 'float',
		'drawdowns' => 'int',
		'co_investment_rights' => 'int',
		'annual_revenue' => 'float',
		'directtype_deal_size' => 'float',
		'directtype_valuation' => 'float',
		'fundtype_fund_size' => 'float',
		'fundtype_min_amount_per_investment' => 'float',
		'fundtype_max_amount_per_investment' => 'float'
	];

	protected $dates = [
		'updated',
		'date_invested'
	];

	protected $fillable = [
		'companyid',
		'tenantid',
		'proposedusesoffunds',
		'investmentstage',
		'monthlyoperatingcost',
		'totalinvestmentrequired',
		'premoneyvaluation',
		'projectedirr',
		'purposeofinvestment',
		'investmentstructure',
		'loanterm_year',
		'loanterm_month',
		'existinginvestors',
		'additionaldetails',
		'updated',
		'projectname',
		'url',
		'location',
		'one_line_description',
		'dealimage',
		'deal_status',
		'referred_by',
		'nda_signed',
		'amount_invested',
		'date_invested',
		'drawdowns',
		'co_investment_rights',
		'notes',
		'annual_revenue',
		'directtype_teaser',
		'directtype_tags',
		'directtype_industry',
		'directtype_deal_size',
		'directtype_valuation',
		'directtype_previously_funded',
		'directtype_video_url',
		'fundtype_fund_category',
		'fundtype_industry_focus',
		'fundtype_fund_size',
		'fundtype_min_lp_commitment',
		'fundtype_min_amount_per_investment',
		'fundtype_max_amount_per_investment',
		'fundtype_ticket_size_specification',
		'fundtype_fund_fees',
		'userid'
	];

	public function company()
	{
		return $this->belongsTo(\App\Models\Company::class, 'companyid');
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'userid');
	}

	public function deals_documents()
	{
		return $this->hasMany(\App\Models\DealsDocument::class, 'dealid');
	}

	public function deals_projected_financials()
	{
		return $this->hasMany(\App\Models\DealsProjectedFinancial::class, 'dealid');
	}

	public function pipelinedeals()
	{
		return $this->hasMany(\App\Models\Pipelinedeal::class, 'dealid');
	}
}
