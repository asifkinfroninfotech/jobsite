<?php 
$helper=\App\Helpers\AppHelper::instance();
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();

$extends="";
$view="";
$layout="";
if(isset($calledfrom) && !empty($calledfrom))
{
    
    if($calledfrom=="admin")
    {
      $view='adminview.layouts.app_layout';
      $layout='left_side_menu';
       
    }
    else if($calledfrom=="tenant")
    {
       $view= 'tenants.layouts.app_layout';
       $layout='left_side_menu_tenant';
      
    }
}
else
{
    $view= 'layouts.app_layout';
     $layout='left_side_menu_compact'; 
     
}



?>

@extends($view, ['layout' => $layout])
<link href="{{asset('css/swipebox/swipebox.css')}}" rel="stylesheet">
@section('content')



<div class="content-w investor-profile-view" ng-app="myApp">
    @if(isset($calledfrom) && !empty($calledfrom))
    @if($calledfrom=="admin")
    @include('adminview.shared._top_menu')

    @elseif($calledfrom=="tenant")
    @include('tenants.shared._top_menu_tenant')
    @endif
    @else
    @include('shared._top_menu')
    @endif


    <div aria-hidden="true" aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm show-pop-up" role="dialog"
        tabindex="-1" id="common-pop-up">
        <div class="modal-dialog">
            <div class="modal-content" id="si_content">

            </div>
        </div>
    </div>

    <div class="content-i enterprise-company-profile">
        <div class="content-box">

            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('enterprises_company_profile_view.help_title')!!}
                    </h5>
                    <div class="form-desc">

                        {!!$helper->GetHelpModifiedText(trans('enterprises_company_profile_view.help_content'))!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('enterprises_company_profile_view.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif


            <div class="element-wrapper">
                <div class="user-profile">
                    @php
                    $cover_image = "";
                    if(isset($data['company_information']->coverimage) &&
                    !empty($data['company_information']->coverimage) &&
                    File::exists(public_path('storage/company/coverimage/'.$data['company_information']->coverimage)))
                    {
                    $cover_image = asset('storage/company/coverimage/'.$data['company_information']->coverimage);
                    }
                    else
                    {
                    $cover_image = asset('/storage/user/default/user_profile_default.jpg');
                    }
                    @endphp
                    <div class="up-head-w" style="background-image:url({{ $cover_image }})">
                        <div class="up-social">
                            @if(isset($data['company_information']->twitter) &&
                            !empty($data['company_information']->twitter))
                            <a href="https://twitter.com/{{$data['company_information']->twitter}}" target="_blank">
                                <i class="icon-social-twitter"></i>
                            </a>
                            @endif
                            @if(isset($data['company_information']->skype) &&
                            !empty($data['company_information']->skype))
                            <a href="skype:{{$data['company_information']->skype}}?userinfo" target="_blank">
                                <i class="icon-social-skype"></i>
                            </a>
                            @endif
                        </div>
                        <div class="up-main-info">
                            <h1 class="up-header">
                                {{-- Kinara Capital --}}
                                {{$data['company_information']->name}}
                            </h1>
                            <h5 class="up-sub-header">
                                {{-- Enterprise --}}
                                {{trans('enterprises_company_profile_view.entity_type')}}
                            </h5>
                        </div>
                        <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219" preserveAspectRatio="xMaxYMax meet"
                            version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                                <path class="decor-path" d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z"></path>
                            </g>
                        </svg>
                    </div>
                    <div class="up-controls">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="value-pair float-left">
                                    <div class="label">
                                        {{-- Country(S): --}}
                                        {{trans('enterprises_company_profile_view.general_caption_country')}}:
                                    </div>
                                    <div class="value">
                                        {{ $data['country']->name }}
                                    </div>
                                </div>

                                <div class="rianta-img float-right text-right">
                                    @if( (isset($data['company_information']->profileimage) &&
                                    !empty($data['company_information']->profileimage) ) &&
                                    File::exists(public_path('/storage/company/profileimage/'.$data['company_information']->profileimage)))
                                    <img alt="{{$data['company_information']->name}}" src="{{ asset('imagecache/company_logo/'.$data['company_information']->profileimage) }}"
                                        class="img-responsive">
                                    @else
                                    <img alt="{{$data['company_information']->name}}" src="{{ Avatar::create($data['company_information']->name)->toBase64() }}"
                                        style="height:61px;" class="img-responsive">
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="up-contents">
                        <h5 class="element-header">
                            {{trans('enterprises_company_profile_view.general_company_caption')}}
                        </h5>

                        <div class="row invst-pfl">
                            @if(isset($data['company_information']->name) && !empty(
                            $data['company_information']->name) )
                            <div class="col-sm-5">
                                <div class="label">
                                    {{trans('enterprises_company_profile_view.general_company_name')}}
                                </div>
                                <h5>{{$data['company_information']->name}}</h5>
                            </div>
                            @endif
                            @if(isset($data['company_information']->telephone) && !empty(
                            $data['company_information']->telephone) )
                            <div class="col-sm-7">
                                <div class="label">
                                    {{trans('enterprises_company_profile_view.general_telephone')}}
                                </div>
                                <h5>{{$data['company_information']->telephone}}</h5>
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['company_information']->website) && !empty(
                            $data['company_information']->website) )
                            <div class="col-sm-5">
                                <div class="label">
                                    {{trans('enterprises_company_profile_view.general_website')}}
                                </div>
                                <h5>{{$data['company_information']->website}}</h5>
                            </div>
                            @endif
                            @if(isset($data['company_information']->email) && !empty(
                            $data['company_information']->email) )
                            <div class="col-sm-7">
                                <div class="label">
                                    {{trans('enterprises_company_profile_view.general_email')}}
                                </div>
                                <h5>{{$data['company_information']->email}}</h5>
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['company_information']->skype) && !empty(
                            $data['company_information']->skype) )
                            <div class="col-sm-5">
                                <div class="label">
                                    {{trans('enterprises_company_profile_view.general_skype')}}
                                </div>
                                <h5>{{$data['company_information']->skype}}</h5>
                            </div>
                            @endif
                            @if(isset($data['company_information']->twitter) && !empty(
                            $data['company_information']->twitter) )
                            <div class="col-sm-7">
                                <div class="label">
                                    {{trans('enterprises_company_profile_view.general_twitter')}}
                                </div>
                                <h5>{{$data['company_information']->twitter}}</h5>
                            </div>
                            @endif
                        </div>
                        @if(isset($data['company_information']->address) && !empty(
                        $data['company_information']->address) )
                        <div class="row invst-pfl">
                            <div class="col-sm-12 col-lg-6">
                                <div class="label">
                                    {{trans('enterprises_company_profile_view.general_address')}}
                                </div>
                                <h5>
                                    {{ $data['company_information']->address }}
                                </h5>
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="up-contents investment-pdtop">
                        <h5 class="element-header">
                            Business Profile
                        </h5>
                        <div class="row invst-pfl">
                            @if(isset($data['company_information']->foundedyear) && !empty(
                            $data['company_information']->foundedyear) )
                            <div class="col-sm-5">
                                <div class="label">Years Founded</div>
                                <h5>{{ $data['company_information']->foundedyear }}</h5>
                            </div>
                            @endif
                            @if(isset($data['currency']->currencyname) && !empty( $data['currency']->currencyname) )
                            <div class="col-sm-7">
                                <div class="label">Preferred currency</div>
                                @if($data['currency']!=null)
                                <h5>{{ $data['currency']->currencyname. " ( " .$data['currency']->code. " ) " }}</h5>
                                @endif
                            </div>
                            @endif

                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['entity_type']->companytype) && !empty( $data['entity_type']->companytype)
                            )
                            <div class="col-sm-5">
                                <div class="label">Type of Entity</div>
                                @if($data['entity_type']!=null)
                                <h5>{{ $data['entity_type']->companytype }}</h5>
                                @endif
                            </div>
                            @endif
                            @if( isset( $data['sectors'] ) && filled ( $data['sectors'] ))
                            <div class="col-sm-7">
                                <div class="label">
                                    {{trans('enterprises_company_profile_view.investment_sector_of_specialization')}}
                                </div>
                                @if( isset( $data['sectors'] ) && filled ( $data['sectors'] ))
                                @foreach($data['sectors'] as $sectors)
                                <h5> {{ $sectors->name }} </h5>
                                @endforeach
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['team_member']) && !empty( $data['team_member']) )
                            <div class="col-sm-5">
                                <div class="label">Number of Employees</div>
                                <h5>{{ count($data['team_member']) }}</h5>
                            </div>
                            @endif
                            @if(isset($data['company_information']->taxidnumber) && !empty(
                            $data['company_information']->taxidnumber) )
                            <div class="col-sm-7">
                                <div class="label">Tax ID</div>
                                <h5>{{ $data['company_information']->taxidnumber }}</h5>
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['prefered_by']->name) && !empty( $data['prefered_by']->name) )
                            <div class="col-sm-5">
                                <div class="label">Preferred By</div>
                                <h5>{{ $data['prefered_by']->name }}</h5>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="up-contents brdtop">
                        @if(isset($data['company_information']->businesssummary) && !empty(
                        $data['company_information']->businesssummary) )
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                Business Summary
                            </h5>
                            <div class="element-inner-desc">
                                {{ $data['company_information']->businesssummary }}
                            </div>
                        </div>
                        @endif
                        @if(isset($data['company_information']->onelinepitch) && !empty(
                        $data['company_information']->onelinepitch) )
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                One Line Pitch
                            </h5>
                            <div class="element-inner-desc">
                                {{ $data['company_information']->onelinepitch }}
                            </div>
                        </div>
                        @endif
                        @if(isset($data['company_information']->salesstrategy) && !empty(
                        $data['company_information']->salesstrategy) )
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                Sales / Marketing Strategy
                            </h5>
                            <div class="element-inner-desc">
                                {{ $data['company_information']->salesstrategy }}
                            </div>
                        </div>
                        @endif
                        @if(isset($data['company_information']->competativeadvantage) && !empty(
                        $data['company_information']->competativeadvantage) )
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                Competitive Advantage
                            </h5>
                            <div class="element-inner-desc">
                                {{ $data['company_information']->competativeadvantage }}
                            </div>
                        </div>
                        @endif
                        @if(isset($data['company_information']->existingpatents) && !empty(
                        $data['company_information']->existingpatents) )
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                Existing Patents or Patents Pending
                            </h5>
                            <div class="element-inner-desc">
                                {{ $data['company_information']->existingpatents }}
                            </div>
                        </div>
                        @endif
                        @if(isset($data['company_information']->recognition) && !empty(
                        $data['company_information']->recognition) )
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                Have the enterprise won any business competitions, recognition?
                            </h5>
                            <div class="element-inner-desc">
                                {{ $data['company_information']->recognition }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!--
              START - Financial Information
            -->
            @php
            $is_financial_all_blank='Yes';

            if($data['historical_data']->isNotEmpty())
            {
            $is_financial_all_blank='No';
            }
            if(!empty($data['company_information']->financialinfo_informationdate) ||
            !empty($data['company_information']->financialinfo_currentassets) ||
            !empty($data['company_information']->financialinfo_totalassets) ||
            !empty($data['company_information']->financialinfo_currentliabilities) ||
            !empty($data['company_information']->financialinfo_totalliabilities) ||
            !empty($data['company_information']->financialinfo_totalequity) ||
            !empty($data['company_information']->financialinfo_netcash) ||
            !empty($data['company_information']->financialinfo_ebitda) ||
            !empty($data['company_information']->financialinfo_auditedfinancialstatement) )
            {
            $is_financial_all_blank='No';
            }
            // echo $is_financial_all_blank;
            @endphp

            @if($is_financial_all_blank=='No')
            <div class="element-wrapper margin-top">
                <h5 class="element-header">
                    Financial Information
                </h5>
                <div class="user-profile">
                    @if($data['historical_data']->isNotEmpty())
                    <div class="up-contents financial-hd-fist">
                        <h5 class="form-header">
                            Past Financials
                        </h5>
                        @if($data['historical_data']->isNotEmpty())
                        @php $count = 1; @endphp
                        @foreach($data['historical_data'] as $historical_data )

                        <div class="enterprise-sub-hd">
                            <strong>Historical 1 </strong>
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($historical_data->historical_year) && !empty( $historical_data->historical_year)
                            )
                            <div class="col-sm-5">
                                <div class="label">Years</div>
                                <h5>{{ $historical_data->historical_year }}</h5>
                            </div>
                            @endif
                            @if(isset($historical_data->annualoperatingcosts) &&
                            !empty($historical_data->annualoperatingcosts) )
                            <div class="col-sm-7">
                                <div class="label">Annual Operating Cost</div>
                                <h5>{{ $historical_data->annualoperatingcosts }}</h5>
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($historical_data->averageannualrevenue) &&
                            !empty($historical_data->averageannualrevenue) )
                            <div class="col-sm-5">
                                <div class="label">Average Annual Revenues</div>
                                <h5>{{ $historical_data->averageannualrevenue }}</h5>
                            </div>
                            @endif
                            @if(isset($historical_data->averagenetincome) && !empty($historical_data->averagenetincome)
                            )
                            <div class="col-sm-7">
                                <div class="label">Average Net Income</div>
                                <h5>{{ $historical_data->averagenetincome }}</h5>
                            </div>
                            @endif
                        </div>
                        @php $count = $count + 1; @endphp
                        @endforeach
                        @endif

                        <!--  END Historical  -->

                    </div>
                    @endif

                    @if(!empty($data['company_information']->financialinfo_informationdate) ||
                    !empty($data['company_information']->financialinfo_currentassets) ||
                    !empty($data['company_information']->financialinfo_totalassets) ||
                    !empty($data['company_information']->financialinfo_currentliabilities) ||
                    !empty($data['company_information']->financialinfo_totalliabilities) ||
                    !empty($data['company_information']->financialinfo_totalequity) ||
                    !empty($data['company_information']->financialinfo_netcash) ||
                    !empty($data['company_information']->financialinfo_ebitda) ||
                    !empty($data['company_information']->financialinfo_auditedfinancialstatement) )
                    <div class="up-contents brdtop">
                        <h5 class="form-header">
                            Current Financials
                        </h5>
                        <div class="row invst-pfl">
                            @if(isset($data['company_information']->financialinfo_informationdate) &&
                            !empty($data['company_information']->financialinfo_informationdate) )
                            <div class="col-sm-5">
                                <div class="label">Information as of (year) </div>
                                <h5>{{ $data['company_information']->financialinfo_informationdate }}</h5>
                            </div>
                            @endif
                            @if(isset($data['company_information']->financialinfo_currentassets) &&
                            !empty($data['company_information']->financialinfo_currentassets) )
                            <div class="col-sm-7">
                                <div class="label">Current Assest</div>
                                <h5>{{$data['currency']->symbol.round($data['company_information']->financialinfo_currentassets,
                                    2)}}</h5>
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['company_information']->financialinfo_totalassets) &&
                            !empty($data['company_information']->financialinfo_totalassets) )
                            <div class="col-sm-5">
                                <div class="label">Total Assest </div>
                                <h5>{{$data['currency']->symbol.round($data['company_information']->financialinfo_totalassets,
                                    2)}} </h5>
                            </div>
                            @endif
                            @if(isset($data['company_information']->financialinfo_currentliabilities) &&
                            !empty($data['company_information']->financialinfo_currentliabilities) )
                            <div class="col-sm-7">
                                <div class="label">Current Liabilities</div>
                                <h5>{{$data['currency']->symbol.round($data['company_information']->financialinfo_currentliabilities,
                                    2)}}</h5>
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['company_information']->financialinfo_totalliabilities) &&
                            !empty($data['company_information']->financialinfo_totalliabilities) )
                            <div class="col-sm-5">
                                <div class="label">Total Liabilities </div>
                                <h5>{{$data['currency']->symbol.round($data['company_information']->financialinfo_totalliabilities,
                                    2)}} </h5>
                            </div>
                            @endif
                            @if(isset($data['company_information']->financialinfo_totalequity) &&
                            !empty($data['company_information']->financialinfo_totalequity) )
                            <div class="col-sm-7">
                                <div class="label">Current Equity</div>
                                <h5>{{$data['currency']->symbol.round($data['company_information']->financialinfo_totalequity,
                                    2)}}</h5>
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['company_information']->financialinfo_netcash) &&
                            !empty($data['company_information']->financialinfo_netcash) )
                            <div class="col-sm-5">
                                <div class="label">Net Cash</div>
                                <h5>{{$data['currency']->symbol.round($data['company_information']->financialinfo_netcash,
                                    2)}}</h5>
                            </div>
                            @endif
                            @if(isset($data['company_information']->financialinfo_ebitda) &&
                            !empty($data['company_information']->financialinfo_ebitda) )
                            <div class="col-sm-7">
                                <div class="label">Ebitda</div>
                                <h5>{{$data['currency']->symbol.round($data['company_information']->financialinfo_ebitda,
                                    2)}}</h5>
                            </div>
                            @endif
                        </div>
                        @if(isset($data['company_information']->financialinfo_auditedfinancialstatement) &&
                        !empty($data['company_information']->financialinfo_auditedfinancialstatement) )
                        <div class="row invst-pfl">
                            <div class="col-sm-5">
                                <div class="label">Do you have audited financial statements?</div>
                                <h5>{{ ($data['company_information']->financialinfo_auditedfinancialstatement) ? 'Yes'
                                    : 'No' }}</h5>
                            </div>

                        </div>
                        @endif
                    </div>

                    @endif

                </div>
            </div>

            @endif

            @if(!empty( $data['company_information']->impactinfo_info) || !empty(
            $data['company_information']->impactinfo_socialbenefitimpact) || !empty(
            $data['company_information']->impactinfo_environmentbenefitimpact) || !empty(
            $data['company_information']->impactinfo_specificbeneficiaries) )
            <div class="element-wrapper margin-top">
                <h5 class="element-header">
                    Impact Information
                </h5>
                <div class="user-profile">
                    <div class="up-contents">
                        @if(isset($data['company_information']->impactinfo_info) && !empty(
                        $data['company_information']->impactinfo_info) )
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                Problem being solved
                            </h5>
                            <div class="element-inner-desc">
                                {{ $data['company_information']->impactinfo_info }}
                            </div>
                        </div>
                        @endif
                        @if(isset($data['company_information']->impactinfo_socialbenefitimpact) && !empty(
                        $data['company_information']->impactinfo_socialbenefitimpact) )
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                Social impact benefit created
                            </h5>
                            <div class="element-inner-desc">
                                {{ $data['company_information']->impactinfo_socialbenefitimpact }}
                            </div>
                        </div>
                        @endif
                        @if(isset($data['company_information']->impactinfo_environmentbenefitimpact) && !empty(
                        $data['company_information']->impactinfo_environmentbenefitimpact) )
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                Environmental impact benefit created
                            </h5>
                            <div class="element-inner-desc">
                                {{ $data['company_information']->impactinfo_environmentbenefitimpact }}
                            </div>
                        </div>
                        @endif
                        @if(isset($data['company_information']->impactinfo_specificbeneficiaries) && !empty(
                        $data['company_information']->impactinfo_specificbeneficiaries) )
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                Specific impact beneficiaries
                            </h5>
                            <div class="element-inner-desc">
                                {{ $data['company_information']->impactinfo_specificbeneficiaries }}
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
            @endif




            <!--
            END - Financial Information
            -->
            @if(!isset($calledfrom) || empty($calledfrom))

            @if(($data['puplic_doc_count']>0 && $otherUserView=="Yes") || ($data['private_doc_count']>0 &&
            $otherUserView=="No"))
            <div class="element-wrapper margin-top">
                <!--
        START - documents table
       -->
                <h5 class="element-header">
                    Documents
                </h5>
                @if($data['puplic_doc_count']>0 )
                <div class="element-box">
                    <h5 class="form-header">
                        {{trans('enterprises_company_profile_view.documents_public_caption')}}
                    </h5>
                    <div class="form-desc">
                        This virtual filing cabinet is a space for you to upload any materials (including brochures,
                        summaries) that
                        support the communication of your core activity
                    </div>
                    <div class="controls-above-table">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-inline justify-content-sm-end">

                                    <input ng-model='public_search.documentname' class="form-control form-control-sm rounded bright"
                                        placeholder="{{trans('enterprises_company_profile_view.documents_public_search')}}"
                                        type="text">
                                    <select ng-model='sortByPublic' class="form-control form-control-sm rounded bright">
                                        <option selected="selected" value="">
                                            {{trans('enterprises_company_profile_view.documents_public_sort')}}
                                        </option>
                                        <option value="documentname">File Name </option>
                                        <option value="extention">Type</option>
                                        <option value="updated">Date</option>
                                    </select>
                                    <select ng-model='filterByExt' class="form-control form-control-sm rounded bright">
                                        <option selected="selected" value="">
                                            {{trans('enterprises_company_profile_view.documents_public_select_filter_type')}}
                                        </option>
                                        <option value="txt">
                                            txt
                                        </option>
                                        <option value="jpg">
                                            jpg
                                        </option>
                                        <option value="png">
                                            png
                                        </option>
                                        <option value="xls">
                                            xls
                                        </option>
                                        <option value="xlsx">
                                            xlsx
                                        </option>
                                        <option value="pdf">
                                            pdf
                                        </option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-heading-spce">
                        <table class="table table-lightborder" ng-controller="document">
                            <thead>
                                <tr>
                                    <th class="name">
                                        {{trans('enterprises_company_profile_view.documents_public_table_name')}}
                                    </th>
                                    <th class="type">
                                        {{trans('enterprises_company_profile_view.documents_public_table_type')}}
                                    </th>
                                    <th class="format">
                                        {{trans('enterprises_company_profile_view.documents_public_table_format')}}
                                    </th>
                                    <th class="date">
                                        {{trans('enterprises_company_profile_view.documents_public_table_date')}}
                                    </th>
                                    <th class="action">
                                        {{trans('enterprises_company_profile_view.documents_public_table_action')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="public_document_table">
                                <tr ng-hide="!publicdoc.length" ng-repeat="public in publicdoc | filter:public_search | filter:filterByExt | orderBy: sortByPublic">
                                    @verbatim
                                    <td>{{ ::public.documentname }}</td>
                                    <td>{{ ::public.type }}</td>
                                    <td>{{ ::public.extention }}</td>
                                    <td>{{ ::public.updated }}</td>
                                    @endverbatim
                                    <td>
                                        <a href="/storage/company/documents/public/@{{ public.documenttitle }}" target="_blank">
                                            <i class="os-icon os-icon-signs-11"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr ng-hide="publicdoc.length > 0">
                                    <td colspan="5">{{trans('enterprises_company_profile_view.documents_public_not_found')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @endif

                @if($otherUserView=="No" && $data['private_doc_count']>0)

                <div class="element-box">
                    <h5 class="form-header">
                        {{trans('enterprises_company_profile_view.documents_private_caption')}}
                    </h5>
                    <div class="form-desc">
                        This virtual filing cabinet is a space for you to upload any materials (including brochures,
                        summaries) that
                        support the communication of your core activity
                    </div>
                    <div class="controls-above-table">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-inline justify-content-sm-end">
                                    <input ng-model='private_search.documentname' class="form-control form-control-sm rounded bright"
                                        placeholder="Search" type="text">
                                    <select ng-model='sortByPrivate' class="form-control form-control-sm rounded bright">
                                        <option selected="selected" value="">
                                            {{trans('enterprises_company_profile_view.documents_private_sort')}}
                                        </option>
                                        <option value="documentname">File Name </option>
                                        <option value="extention">Type</option>
                                        <option value="updated">Date</option>
                                    </select>
                                    <select ng-model='privateFilterByExt' class="form-control form-control-sm rounded bright">
                                        <option selected="selected" value="">
                                            {{trans('enterprises_company_profile_view.documents_public_select_filter_type')}}
                                        </option>
                                        <option value="txt">
                                            txt
                                        </option>
                                        <option value="jpg">
                                            jpg
                                        </option>
                                        <option value="png">
                                            png
                                        </option>
                                        <option value="xls">
                                            xls
                                        </option>
                                        <option value="xlsx">
                                            xlsx
                                        </option>
                                        <option value="pdf">
                                            pdf
                                        </option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-heading-spce">
                        <table class="table table-lightborder" ng-controller="document">
                            <thead>
                                <tr>
                                    <th class="name">
                                        {{trans('enterprises_company_profile_view.documents_private_table_name')}}
                                    </th>
                                    <th class="type">
                                        {{trans('enterprises_company_profile_view.documents_private_table_type')}}
                                    </th>
                                    <th class="format">
                                        {{trans('enterprises_company_profile_view.documents_private_table_format')}}
                                    </th>
                                    <th class="date">
                                        {{trans('enterprises_company_profile_view.documents_private_table_date')}}
                                    </th>
                                    <th class="action">
                                        {{trans('enterprises_company_profile_view.documents_private_table_action')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="private_document_table">
                                <tr ng-hide="!privatedoc.length" ng-repeat="private in privatedoc | filter:private_search | filter:privateFilterByExt | orderBy: sortByPrivate">
                                    <td>@{{ private.documentname }}</td>
                                    <td>@{{ private.type }}</td>
                                    <td>@{{ private.extention }}</td>
                                    <td>@{{ private.updated }}</td>
                                    <td>
                                        <a href="/storage/company/documents/private/@{{ private.documenttitle }}"
                                            target="_blank">
                                            <i class="os-icon os-icon-signs-11"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr ng-hide="privatedoc.length > 0">
                                    <td colspan="5">{{trans('enterprises_company_profile_view.documents_private_not_found')}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            @endif


            @endif
            <!--
                END - documents table
                -->


            {{-- Start of Deals --}}
            @if(count($deals)>0)
            @php
            $parent_collection=collect(json_decode($deals_dd_parents, true));
            @endphp
            <div class="element-wrapper margin-top">
                <h6 class="element-header">
                    Deals
                </h6>

                <!--START - Projects list-->
                <div class="projects-list projects-list-vk" id="divDeals">
                    @foreach($deals as $d)
                    @php
                    $parent_avl_count=$parent_collection->where('dealid',$d->dealid)->count();
                    @endphp
                    <div class="project-box mar-one-rem">
                        <div class="project-head">
                            <div class="project-title kinaracpital">
                                <h5>
                                    {{$d->company}}
                                </h5>
                                <div class="label">
                                    {{$d->statusmessage}}
                                </div>
                            </div>
                            <div class="btn-group mr-1 mb-1">
                                <span><button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button">{{strtoupper($d->deal_active)}}</button>
                                </span>
                            </div>
                        </div>
                        <div class="project-info">
                            <div class="row align-items-center">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="el-tablo highlight">
                                                <div class="label">
                                                    Investment Required
                                                </div>
                                                <div class="value">
                                                    ${{$helper->nice_number($d->totalinvestmentrequired)}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="el-tablo estimated-time profile-tile highlight">
                                                <div class="profile-tile-meta">
                                                    <ul>
                                                        <li>
                                                            <span>Project:</span>
                                                            <strong>{{$d->projectname}} </strong>
                                                        </li>
                                                        @if(isset($d->investmentstage) && !empty($d->investmentstage))
                                                        <li>
                                                            <span>Stage:</span>
                                                            <strong>{{$d->investmentstage}} </strong>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <span>Date of Created:</span>
                                                            <strong>{{date('M d,Y',strtotime($d->updated)) }} </strong>
                                                        </li>
                                                        <li>
                                                            <span>Country:</span>
                                                            <strong>{{$d->country}} </strong>
                                                        </li>
                                                        <li>
                                                            <span>Total Views:</span>
                                                            <strong>{{$d->totalviews}}</strong>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 mr-rit-auto">
                                    <?php 
                                 $sdg_available=0;
                                 ?>
                                    <div class="text-right">

                                        <div class="project-users sdg">
                                            SDG (S)
                                        </div>

                                        @if(filled($deals_sdgs))
                                        @foreach($deals_sdgs as $sdg)
                                        @if($sdg->dealid==$d->dealid)
                                        <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button">{{$sdg->sdg}}</button>
                                        @php
                                        $sdg_available=1;
                                        @endphp
                                        @endif
                                        @endforeach

                                        @endif
                                        @if($sdg_available==0)
                                        No SDG (S) found.
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row form-buttons-w interbtn">

                                <div class="col-lg-6">
                                    <div class="project-users project-usersvk">
                                        @if($parent_avl_count>0)
                                        <p>DD In Progress: <a href="/deals/view-deal?dealid={{$d->dealid}}">{{$parent_avl_count}}
                                            </a></p>

                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="text-right my-portfolio-btm">
                                        <a class="btn btn-yellow-custom" href="/deals/view-deal?dealid={{$d->dealid}}"
                                            data-placement="top" data-toggle="tooltip" data-original-title="{{$helper->GetHelpModifiedText(trans('dealpipeline.view_deal'))}}"
                                            target="_blank">View Deal</a>
                                        @if($d->companyid!=session('companyid') && $d->deal_active=='active')
                                        <a class="btn btn-primary" href="javascript:void(0);" onclick="fnShowInterestModal('{{$d->dealid}}');"
                                            data-target=".show-pop-up" data-toggle="modal">Add To My Portfolio</a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach



                </div>
                <!--END - Projects list-->
            </div>

            @endif
            {{-- End of Deals --}}





            <!--
              START - Color Scheme Toggler
             -->
            <div class="floated-colors-btn second-floated-btn">
                <div class="os-toggler-w">
                    <div class="os-toggler-i">
                        <div class="os-toggler-pill"></div>
                    </div>
                </div>
                <span>Dark </span>
                <span>Colors</span>
            </div>
            <!--
              END - Color Scheme Toggler
            -->
            <!--
              START - Chat Popup Box
            -->
            <div class="floated-chat-btn">
                <i class="os-icon os-icon-mail-07"></i>
                <span>Demo Chat</span>
            </div>
            <div class="floated-chat-w">
                <div class="floated-chat-i">
                    <div class="chat-close">
                        <i class="os-icon os-icon-close"></i>
                    </div>
                    <div class="chat-head">
                        <div class="user-w with-status status-green">
                            <div class="user-avatar-w">
                                <div class="user-avatar">
                                    <img alt="" src="img/avatar1.jpg">
                                </div>
                            </div>
                            <div class="user-name">
                                <h6 class="user-title">
                                    John Mayers
                                </h6>
                                <div class="user-role">
                                    Account Manager
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-messages">
                        <div class="message">
                            <div class="message-content">
                                Hi, how can I help you?
                            </div>
                        </div>
                        <div class="date-break">
                            Mon 10:20am
                        </div>
                        <div class="message">
                            <div class="message-content">
                                {{ $data['company_information']->referredbyid }}
                            </div>
                        </div>
                        <div class="message self">
                            <div class="message-content">
                                {{ $data['company_information']->referredbyid }}
                            </div>
                        </div>
                    </div>
                    <div class="chat-controls">
                        <input class="message-input" placeholder="Type your message here..." type="text">
                        <div class="chat-extra">
                            <a href="#">
                                <span class="extra-tooltip">Attach Document</span>
                                <i class="os-icon os-icon-documents-07"></i>
                            </a>
                            <a href="#">
                                <span class="extra-tooltip">Insert Photo</span>
                                <i class="os-icon os-icon-others-29"></i>
                            </a>
                            <a href="#">
                                <span class="extra-tooltip">Upload Video</span>
                                <i class="os-icon os-icon-ui-51"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--
              END - Chat Popup Box
              -->
        </div>
        <!--
          START - Sidebar
          -->
        @if(!isset($calledfrom) || empty($calledfrom))
        <div class="content-panel">
            <div class="content-panel-close">
                <i class="os-icon os-icon-close"></i>
            </div>
            <div class="element-wrapper">
                <h6 class="element-header">
                    {{trans('enterprises_company_profile_view.general_team_member')}}
                </h6>
                <div class="element-box-tp">
                    <div class="input-search-w">
                        <input class="form-control rounded bright" id="myInput" placeholder="{{trans('enterprises_company_profile_view.general_search_team_member')}}"
                            type="search">
                    </div>
                    <div class="users-list-w">
                        <div id="members">
                            @foreach($data['team_member'] as $members)
                            <span>

                                <div class="user-w  {{($members[0]->is_online == 1)?'with-status status-green':'with-status status-red'}}">

                                    <div class="user-avatar-w">
                                        <div class="user-avatar">
                                            <a href="/user/profile/view?user={{$members[0]->userid}}">
                                                @if($members[0]->profileimage==null)
                                                <img alt="" src="{{ Avatar::create(strtoupper($members[0]->firstname).' '.strtoupper($members[0]->lastname))->toBase64() }}">
                                                @else
                                                <img alt="" src="{{$UserProfileImagePath . $members[0]->profileimage}}">
                                                @endif
                                            </a>
                                            {{-- <img alt="" src="img/avatar1.jpg"> --}}
                                        </div>
                                    </div>
                                    <div class="user-name">
                                        <h6 class="user-title">
                                            <a> {{$members[0]->firstname.' '.$members[0]->lastname}} </a>
                                        </h6>
                                        <div class="user-role">
                                            {{-- Account Manager --}}
                                            {{$members[0]->userposition}}
                                        </div>
                                    </div>
                                    @php
                                    $helper=\App\Helpers\AppHelper::instance();

                                    $connect='';
                                    if(isset($_GET['company']) && !empty($_GET['company']))
                                    {
                                    $connect=$helper->companymessagingandconnect($_GET['company'],$members[0]->userid,$data['friends']);
                                    }
                                    @endphp

                                    @if($connect == "connect")
                                    <div class="user-action">
                                        @php
                                        $userid=session('userid');
                                        @endphp
                                        <a href="#" onclick="friendsender('{{$userid}}','{{$members[0]->userid}}')">
                                            <div class="os-icon os-icon-link-3">&nbsp;</div>

                                        </a>
                                    </div>
                                    @elseif($connect == "messaging")
                                    <div class="user-action">
                                        <a href="/companymessaging?userid={{$members[0]->userid}}">
                                            <div class="os-icon os-icon-email-forward"></div>
                                        </a>
                                    </div>


                                    @elseif($connect == "approval")
                                    <div class="user-action">

                                    </div>
                                    @endif
                                </div>
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="video-rit">
                    @if(isset($gallery_images) && !empty($gallery_images) && count($gallery_images) > 0)
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            Image Gallery
                        </h6>

                        <div class="element-box">


                            @php
                            $gallery_images_row_count=0;
                            $gallery_last_count=0;

                            $gallery_images_actual=0;
                            if(isset($gallery_images) && !empty($gallery_images) && count($gallery_images) > 0)
                            {


                            $gallery_images_row_count=intval(count($gallery_images)/2);
                            if(count($gallery_images) > (2 * $gallery_images_row_count))
                            {
                            if(count($gallery_images) > 1)
                            {
                            $gallery_last_count=count($gallery_images) - 1;
                            }
                            else if(count($gallery_images) == 1)
                            {
                            $gallery_last_count=1;
                            }
                            }

                            }


                            @endphp


                            @for($i=0;$i<$gallery_images_row_count;$i++) <div class="row">
                                <div class="col-sm-6">
                                    <a rel="g-1" class="element-box el-tablo centered trend-in-corner padded swipebox"
                                        href="/storage/company/gallery/images/{{$gallery_images[$gallery_images_actual]->gallerytitle}}"
                                        title="{{$gallery_images[$gallery_images_actual]->galleryname}}">
                                        <img src="/imagecache/company_image_gallery/{{$gallery_images[$gallery_images_actual]->gallerytitle}}"
                                            alt="image" />
                                    </a>
                                </div>
                                @php
                                $gallery_images_actual=$gallery_images_actual+1;
                                @endphp
                                <div class="col-sm-6">
                                    <a rel="g-1" class="element-box el-tablo centered trend-in-corner padded swipebox"
                                        href="/storage/company/gallery/images/{{$gallery_images[$gallery_images_actual]->gallerytitle}}"
                                        title="{{$gallery_images[$gallery_images_actual]->galleryname}}">
                                        <img src="/imagecache/company_image_gallery/{{$gallery_images[$gallery_images_actual]->gallerytitle}}"
                                            alt="image" />
                                    </a>
                                </div>
                        </div>
                        @php
                        $gallery_images_actual=$gallery_images_actual+1;
                        @endphp
                        @endfor
                        @if($gallery_last_count > 0)
                        <div class="row">
                            <div class="col-sm-6">
                                <a rel="g-1" class="element-box el-tablo centered trend-in-corner padded swipebox" href="/storage/company/gallery/images/{{$gallery_images[$gallery_images_actual]->gallerytitle}}"
                                    title="{{$gallery_images[$gallery_images_actual]->galleryname}}">
                                    <img src="/imagecache/company_image_gallery/{{$gallery_images[$gallery_images_actual]->gallerytitle}}"
                                        alt="image" />
                                </a>
                            </div>
                        </div>
                        @endif

                    </div>
                    @endif

                </div>


                @if(isset($gallery_videos) && !empty($gallery_videos) && count($gallery_videos) > 0 ||
                ($data['videofile']
                !=
                null ))
                <div class="video-rit">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            Video Gallery
                        </h6>
                        <div class="element-box">
                            <div class="users-list-w">


                                @if($data['videofile'] != null)

                                <div class="user-w ">
                                    <div class="user-name">
                                        <h6 class="user-title">
                                            {{$data['videofile']->videotitle}}
                                        </h6>

                                    </div>

                                    <div class="user-action">
                                        <a href="#" data-target="#onboardingvideogallerycompany" data-toggle="modal"
                                            onclick="makeiframesingle();">
                                            <div class="os-icon os-icon-link-3">&nbsp;</div>
                                        </a>
                                        <div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingvideogallerycompany"
                                            role="dialog" tabindex="-1">
                                            <div class="modal-dialog modal-lg modal-centered" role="document">
                                                <div class="modal-content text-center">
                                                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"
                                                        onclick="closesingle();">
                                                        <!-- <span class="close-label">Skip Intro</span> -->
                                                        <span class="os-icon os-icon-close" style="z-index:99999;color:white;"></span>
                                                    </button>
                                                    <div class="onboarding-side-by-side">
                                                        @php
                                                        $video_path =
                                                        asset('storage/company/videos/'.$data['videofile']->videopath);

                                                        @endphp
                                                        <div class="onboarding-content with-full" style="padding: 0px;">
                                                            @if($video_path)
                                                            <input type="hidden" id="makeiframesingle" value="{{$video_path}}">
                                                            <div id="makeiframedvsingle">

                                                            </div>
                                                            @else
                                                            {{ "No Video Found, Please Upload Video !!!" }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                @endif
                                @php
                                $modal=0;

                                @endphp
                                @foreach($gallery_videos as $videos)
                                <div class="user-w ">
                                    <div class="user-name">
                                        <h6 class="user-title">
                                            {{$videos->galleryname}}
                                        </h6>
                                        <div class="user-role">
                                            {{$videos->extension}}
                                        </div>
                                    </div>
                                    <div class="user-action">
                                        <a href="#" data-target="#onboardingvideogallery{{$modal}}" data-toggle="modal"
                                            onclick="makeiframe('{{$modal}}');">
                                            <div class="os-icon os-icon-link-3">&nbsp;</div>
                                        </a>
                                        <div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingvideogallery{{$modal}}"
                                            role="dialog" tabindex="-1">
                                            <div class="modal-dialog modal-lg modal-centered" role="document">
                                                <div class="modal-content text-center">
                                                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"
                                                        onclick="closevid('{{$modal}}');">
                                                        <!-- <span class="close-label">Skip Intro</span> -->
                                                        <span class="os-icon os-icon-close" style="z-index:99999;color:white;"></span>
                                                    </button>
                                                    <div class="onboarding-side-by-side">
                                                        @php
                                                        $video_path =
                                                        asset('/storage/company/gallery/videos/'.$videos->gallerytitle);

                                                        @endphp
                                                        <div class="onboarding-content with-full" style="padding: 0px;">
                                                            @if($video_path)

                                                            <input type="hidden" id="makeiframe{{$modal}}" value="{{$video_path}}">
                                                            <div id="makeiframedv{{$modal}}">

                                                            </div>

                                                            <iframe width="100%" height="400" src="{{asset($video_path)}}"
                                                                frameborder="0"></iframe>
                                                            @else
                                                            {{ "No Video Found, Please Upload Video !!!" }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @php
                                $modal++;
                                @endphp
                                @endforeach





                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>





        </div>

    </div>
    @endif
    <!--
          END - Sidebar
          -->
</div>
</div>
<script>
    //          function memberSearch() {
    //          var input, filter, members, span, a, i;
    //          input = document.getElementById("myInput");
    //          filter = input.value.toUpperCase();
    //          members = document.getElementById("members");
    //          span = members.getElementsByTagName("span");
    //          for (i = 0; i < span.length; i++) {
    //              a = span[i].getElementsByTagName("a")[0];
    //              if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
    //                  span[i].style.display = "";
    //              } else {
    //                  span[i].style.display = "none";
    //
    //              }
    //          }
    //      }
</script>

@section('scripts')
<script src="{{asset('js/swipebox/jquery.swipebox.js')}}"></script>
<script>
    $(document).swipebox({
        selector: '.swipebox'
    });
    //asifcode
    var search = "";
    var count = 0;
    $('#myInput').keyup(function () {
        search = $('#myInput').val();
        setTimeout(function () {
            if (count == 0) {
                getsearchfromdb(search);
            }
            count++;
        }, 2000);
        count = 0;
    });



    function getsearchfromdb(search) {

        debugger;
        var getcompany = <?php echo json_encode((isset($_GET['company']))?$_GET['company']:''); ?>;
        var getuser = <?php echo json_encode((isset($_GET['user']))?$_GET['user']:''); ?>;
        $.get('/teammembersearch?searchstring=' + search + '&company=' + getcompany + '&user=' + getuser, function (
            data) {
            $('#members').html(data);
        });
    }


    function makeiframe(modal) {
        var src1 = $('#makeiframe' + modal).val();
        $('#makeiframedv' + modal).html('<iframe width="100%" height="400" src="' + src1 +
            '" frameborder="0"></iframe>');

    }



    function makeiframesingle(modal) {
        var src1 = $('#makeiframesingle').val();
        $('#makeiframedvsingle').html('<iframe width="100%" height="400" src="' + src1 +
            '" frameborder="0"></iframe>');

    }

    function closesingle() {
        $('#makeiframedvsingle').html('<iframe width="100%" height="400" src="" frameborder="0"></iframe>');
    }

    function closevid(modal) {
        $('#makeiframedv' + modal).html('<iframe width="100%" height="400" src="" frameborder="0"></iframe>');
    }

    //asifcode
</script>





@endsection

<script>
    function fnShowInterestModal(dealid) {
        debugger;
        var route = "/ajax-getdeal-folders?dealid=" + dealid;
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
                debugger;
                $("#si_content").html('');
                $("#si_content").html(data);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    function fnAttachDeal(dealid) {
        debugger;
        var folderid = $("#userpipeline_folders option:selected").val();
        if (parseInt(folderid) <= 0) {
            //error-folder-select
            // alert('Please select a folder where you like to connect this deal.');

            var $messageDiv = $('#error-folder-select'); // get the reference of the div
            $messageDiv.show(); // show and set the message.html(data.Message)
            setTimeout(function () {
                $messageDiv.hide();
            }, 3000); // 3 seconds later, hide
            return;
        }
        if (!$("#chkTermsConditions").is(":checked")) {
            // do something if the checkbox is NOT checked
            // alert('Please select the terms & condition check boxes.');
            var $messageDiv = $('#error-termscondition-select'); // get the reference of the div
            $messageDiv.show(); // show and set the message.html(data.Message)
            setTimeout(function () {
                $messageDiv.hide();
            }, 3000); // 3 seconds later, hide
            return;
        }
        $('#btn-on-popup').prop("disabled", true);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formdata = new FormData();
        formdata.append("dealid", dealid);
        formdata.append("folderid", folderid);
        formdata.append("_token", '{{csrf_token()}}');

        $.ajax({
            url: '/ajax-attach-deal',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
                debugger;
                if (data.status == 'Success') {
                    //trigger second button
                    $("#btnpopupclose").click();
                    $("div.modal-backdrop").remove();
                    $('.show-pop-up').modal('hide');
                    //Referesh the deal content areas....
                    //fngetDeals(1);
                    window.location.href = "/my-portfolio";
                } else {
                    alert('Some Error happened during processing...');
                    $('#btn-on-popup').prop("disabled", false);
                }

            },
            error: function (err, result) {
                debugger;
                alert("Error" + err.responseText);
                $('#btn-on-popup').prop("disabled", false);
                //trigger second button
                $("#btnpopupclose").click();
                $("div.modal-backdrop").remove();
            }
        });
    }

    function documents() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("document");
        table = document.getElementById("myTable");
        filter = input.value.toUpperCase();

        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function publicDocuments() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("public_document");
        table = document.getElementById("public_document_table");
        filter = input.value.toUpperCase();

        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }


    function friendsender(sender, friend) {
        debugger;
        $.get('/senderfriend?sender=' + sender + '&friend=' + friend, function (data) {
            location.reload();
        })

    }
</script>
@endsection