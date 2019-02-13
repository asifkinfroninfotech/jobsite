@php
$helper=\App\Helpers\AppHelper::instance();
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


@endphp
@extends($view, ['layout' => $layout])
@section('content')
@php
$pf_collection = collect(json_decode($data['projectedfinancials'], true));
@endphp
<div class="content-w investor-profil" ng-app="myApp">
    @if(isset($calledfrom) && !empty($calledfrom))
    @if($calledfrom=="admin")
    @include('adminview.shared._top_menu')

    @elseif($calledfrom=="tenant")
    @include('tenants.shared._top_menu_tenant')
    @endif
    @else
    @include('shared._top_menu')
    @endif
    <div class="content-i">



        <div class="content-box">
            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('my_deal.edit_help_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!$helper->GetHelpModifiedText(trans('my_deal.edit_help_content'))!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('my_deal.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-4">
                    <div class="user-profile compact">

                        @php
                        $cover_image='';
                        if(isset($data['deal_info']->coverimage) && !empty($data['deal_info']->coverimage))
                        {
                        $cover_image = asset('storage/deal/coverimage/'.$data['deal_info']->coverimage);
                        }
                        else {
                        $cover_image = asset('storage/company/coverimage/'.$data['deal_info']->c_coverimage);
                        }
                        @endphp
                        <div class="up-head-w" style="background-image:url({{ $cover_image }})">
                            {{-- <div class="up-social">
                                <a href="#">
                                    <i class="os-icon os-icon-twitter"></i>
                                </a>
                                <a href="#">
                                    <i class="os-icon os-icon-facebook"></i>
                                </a>
                            </div> --}}
                            <div class="up-main-info">
                                <h2 class="up-header">
                                    {{-- John Bloggs --}}
                                    {{$data['deal_info']->projectname}}
                                </h2>
                                <h6 class="up-sub-header">
                                    Deal
                                </h6>
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
                                    <div class="value-pair">
                                        <div class="label">
                                            {{trans('my_deal.country_label')}}:
                                        </div>
                                        <div class="value">
                                            {{ $data['countries']['current_country']->name }}
                                        </div>
                                    </div>

                                    <div class="rianta-img">
                                        @if( (isset($data['deal_info']->profileimage) &&
                                        !empty($data['deal_info']->profileimage) ) &&
                                        File::exists(public_path('storage/deal/profileimage/'.$data['deal_info']->profileimage)))
                                        <img src="{{ asset('imagecache/company_logo/'.$data['deal_info']->profileimage) }}"
                                            class="img-responsive">
                                        @else
                                        <img src="{{ Avatar::create($data['deal_info']->projectname)->toBase64() }}"
                                            style="width:183px;height:61px;" class="img-responsive">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="element-wrapper">
                        <!--
                        start - Logo Image
                        -->
                        <div class="element-box">
                            <h5 class="form-header">
                                {{trans('eso_company_profile_edit.general_logo_title')}}
                            </h5>
                            <div class="form-desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit
                            </div>
                            <form action="{{ route('deal.cover.logo.image.store') }}" method="POST" enctype="multipart/form-data"
                                class="dropzone" id="profile_image">
                                {{ csrf_field() }}
                                <input type="hidden" name="profile_image" value="profile_image">
                                <input type="hidden" name="dealid" value="{{$data['deal_info']->dealid}}" />
                                <div class="dz-message">
                                    <div>
                                        <h4>{{trans('eso_company_profile_edit.general_drag_and_drop')}}</h4>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="element-box">
                            <h5 class="form-header">
                                {{trans('eso_company_profile_edit.general_cover_image_title')}}
                            </h5>
                            <div class="form-desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit
                            </div>
                            <form action="{{ route('deal.cover.logo.image.store') }}" method="POST" enctype="multipart/form-data"
                                class="dropzone" id="cover_image">
                                {{ csrf_field() }}
                                <input type="hidden" name="cover_image" value="cover_image">
                                <input type="hidden" name="dealid" value="{{$data['deal_info']->dealid}}" />
                                <div class="dz-message">
                                    <div>
                                        <h4>{{trans('eso_company_profile_edit.general_drag_and_drop')}}</h4>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--
                        END - Logo Image
                        -->
                        <!--
                         start - right section video
                        -->
                        <div class="video-rit">
                            <div class="element-wrapper">
                                <h6 class="element-header">
                                    <h4>{{trans('eso_company_profile_edit.general_video')}}</h4>
                                </h6>
                                <div class="element-box">
                                    <div class="el-chart-w">
                                        <a class="video-play" data-target="#onboardingWideFeaturesModal" data-toggle="modal">
                                            @php
                                            $video_path = false;
                                            if($data['deal_info']->video != null) {
                                            $video_path = asset('storage/deal/video/'.$data['deal_info']->video);
                                            }
                                            @endphp
                                            <img src="{{asset('img/video-test.jpg')}}" alt="Play Video" class="img-responsive" />
                                        </a>
                                        <div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingWideFeaturesModal"
                                            role="dialog" tabindex="-1">
                                            <div class="modal-dialog modal-lg modal-centered" role="document">
                                                <div class="modal-content text-center">
                                                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                                        <span class="close-label">Skip Intro</span>
                                                        <span class="os-icon os-icon-close"></span>
                                                    </button>
                                                    <div class="onboarding-side-by-side">
                                                        <div class="onboarding-content with-full">
                                                            @if($video_path)
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
                            </div>
                        </div>
                        <!--
                        END - right section video
                        -->
                        <!--
                          START - Video Upload
                        -->
                        <div class="element-box">
                            <h5 class="form-header">
                                <h4>{{trans('eso_company_profile_edit.general_video_upload_caption')}}</h4>
                            </h5>
                            <div class="form-desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit
                            </div>
                            <form action="{{ route('deal.video.store') }}" method="POST" enctype="multipart/form-data"
                                class="dropzone" id="my-video">
                                {{ csrf_field() }}
                                <input type="hidden" name="dealid" value="{{$data['deal_info']->dealid}}" />
                                <div class="dz-message">
                                    <div>
                                        <h4>{{trans('eso_company_profile_edit.general_drag_and_drop')}}</h4>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--
                           END - Video Upload
                           -->
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-8">
                    <div class="element-wrapper">
                        <div class="element-box">
                            <form id="formValidate" method="POST" action="/updatedeal">
                                {{ csrf_field() }}
                                <input type="hidden" name="dealid" value="{{$data['deal_info']->dealid}}" />
                                <div class="steps-w">
                                    <div class="step-triggers">
                                        <a class="step-trigger active" href="#stepContent1">
                                            {{-- {{trans('eso_company_profile_edit.general_company_caption')}} --}}
                                            {{trans('my_deal.edit_deal_title')}}
                                        </a>

                                    </div>
                                    <div class="step-contents">
                                        <div class="step-content active" id="stepContent1">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('my_deal.project_name_label')}}
                                                        </label>
                                                        <input class="form-control" placeholder="Enter Name" data-error="Project Name is invalid"
                                                            required="required" type="text" name="project_name" value="{{old('', $data['deal_info']->projectname)}}">
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            Select Currency
                                                        </label>
                                                        <select class="form-control" name="currency" onchange="currencychange(this.value);">

                                                            @foreach($data['currency'] as $currency)

                                                            <option value="{{$currency->currencyid}}" <?php
                                                                if($currency->currencyid==$data['deal_info']->currencyid){echo
                                                                "selected";}?>>{{$currency->currencyname}}</option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>
                                                            {{trans('my_deal.proposed_use_funds_label')}}
                                                        </label>
                                                        <textarea class="form-control" name="proposed_uses_of_funds"
                                                            rows="3">{{ old('',$data['deal_info']->proposedusesoffunds) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('my_deal.investment_stage_label')}}
                                                        </label>
                                                        <select class="form-control" name="investmentstage">
                                                            <option value="" disabled selected>Select</option>
                                                            @if(isset($data['investmentstages']))
                                                            @foreach($data['investmentstages'] as $istage)
                                                            <option value="{{ $istage->stagename }}"
                                                                @isset($data['deal_info']->investmentstage)
                                                                {{
                                                                ($data['deal_info']->investmentstage ==
                                                                $istage->stagename) ? "selected =='selected' " : ''
                                                                }}
                                                                @endisset
                                                                >{{ $istage->stagename }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('my_deal.monthly_operating_label')}}
                                                        </label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['deal_info']->symbol}}
                                                                </div>
                                                            </div>
                                                            <input class="form-control" data-error="Please enter monthly operating costs."
                                                                placeholder="Monthly Operating Costs" step=".01"
                                                                required="required" data-minlength="1" type="number"
                                                                name="monthly_operating_costs" value="{{ old('',number_format($data['deal_info']->monthlyoperatingcost, 2, '.', '')) }}">
                                                        </div>



                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('my_deal.total_investment_label')}}
                                                        </label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['deal_info']->symbol}}
                                                                </div>
                                                            </div>
                                                            <input class="form-control" data-error="Total investment required is invalid"
                                                                step=".01" placeholder="Total Investment Required"
                                                                required="required" type="number" name="total_investment_required"
                                                                value="{!! old('',number_format($data['deal_info']->totalinvestmentrequired, 2, '.', '')) !!}">
                                                        </div>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('my_deal.pre_money_label')}}
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['deal_info']->symbol}}
                                                                </div>
                                                            </div>
                                                            <input class="form-control" data-error="Pre money valuation is invalid"
                                                                step=".01" placeholder="Pre Money Valuation" required="required"
                                                                type="number" name="pre_money_valuation" value="{{ old('',number_format($data['deal_info']->premoneyvaluation, 2, '.', '')) }}">
                                                        </div>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('my_deal.projected_irr_label')}}
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['deal_info']->symbol}}
                                                                </div>
                                                            </div>
                                                            <input class="form-control" data-error="Your email address is invalid"
                                                                step=".01" placeholder="Projected IRR(%)" type="number"
                                                                name="projected_irr" value="{{ old('',number_format($data['deal_info']->projectedirr, 2, '.', ',')) }}">
                                                        </div>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('my_deal.purpose_requested_investment_label')}}
                                                        </label>
                                                        <select class="form-control" name="purpose_of_requested_investment">
                                                            <option value="" disabled selected>Select</option>
                                                            @if(isset($data['purposeofrequestedinvestment']))
                                                            @foreach($data['purposeofrequestedinvestment'] as $pori)
                                                            <option value="{{ $pori->fund }}"
                                                                @isset($data['deal_info']->purposeofinvestment)
                                                                {{
                                                                ($data['deal_info']->purposeofinvestment ==
                                                                $pori->fund) ? "selected =='selected' " : ''
                                                                }}
                                                                @endisset

                                                                >{{ $pori->fund }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('my_deal.investment_structure_label')}}
                                                        </label>
                                                        <select class="form-control" name="investment_structure">
                                                            <option value="" disabled selected>Select</option>
                                                            @if(isset($data['investmentstructures']))
                                                            @foreach($data['investmentstructures'] as $istruct)
                                                            <option value="{{ $istruct->name }}"
                                                                @isset($data['deal_info']->investmentstructure)
                                                                {{
                                                                ($data['deal_info']->investmentstructure ==
                                                                $istruct->name) ? "selected =='selected' " : ''
                                                                }}
                                                                @endisset
                                                                >{{ $istruct->name }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            SDG
                                                        </label>
                                                        <select class="form-control select2" name="sdg[]" multiple="true">
                                                            @foreach($data['sdg_master'] as $sdgmaster)
                                                            <?php $selected1="";?>
                                                            @foreach($data['sdg_selected'] as $selected)
                                                            @if($selected->sdgid == $sdgmaster->sdgid)
                                                            <?php $selected1 = "selected";?>
                                                            @break
                                                            @endif

                                                            @endforeach
                                                            <option value="{{$sdgmaster->sdgid}}" <?php echo
                                                                $selected1;?>>{{$sdgmaster->sdg}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                            </div>

                                            <h7 class="form-header">
                                                {{trans('my_deal.loan_term_label')}}
                                            </h7>
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('my_deal.loan_term_years_label')}}
                                                        </label>
                                                        <input class="form-control" data-error="Invalid data entered."
                                                            placeholder="{{trans('my_deal.loan_term_years_label')}}"
                                                            type="number" name="loan_term_year" value="{{ old('',$data['deal_info']->loanterm_year) }}">
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('my_deal.loan_term_months_label')}}
                                                        </label>
                                                        <input class="form-control" data-error="Invalid data entered."
                                                            placeholder="{{trans('my_deal.loan_term_months_label')}}"
                                                            type="number" name="loan_term_month" value="{{ old('',$data['deal_info']->loanterm_month) }}">
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>

                                            </div>

                                            <h5 class="form-header">
                                                {{trans('my_deal.other_financial_label')}}
                                            </h5>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>
                                                            {{trans('my_deal.existing_investor_label')}}
                                                        </label>
                                                        <textarea class="form-control" name="previous_investores" rows="3">{{ old('',$data['deal_info']->existinginvestors) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>
                                                            {{trans('my_deal.additional_detail_label')}}
                                                        </label>
                                                        <textarea class="form-control" name="additional_info" rows="3">{{ old('',$data['deal_info']->additionaldetails) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <h5 class="form-header">
                                                {{trans('my_deal.projected_financials_label')}}
                                            </h5>

                                            @for ($i = 2; $i < 6; $i++) @php $pf_row=$pf_collection->where('year_number',
                                                $i)->first();

                                                @endphp
                                                <div class="enterprise-sub-hd">
                                                    <strong>{{trans('my_deal.year_title')}} {{ $i }}</strong>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">
                                                                {{trans('my_deal.year_label')}} {{ $i }}
                                                            </label>
                                                            <input class="form-control" data-error="Invalid data entered."
                                                                placeholder="Years 2" type="number" name="Year_{{ $i }}"
                                                                value="{{$pf_row['projected_year']}}">
                                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">
                                                                {{trans('my_deal.year_common_totalrevenues_label')}}
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text currency-symb">
                                                                        {{$data['deal_info']->symbol}}
                                                                    </div>
                                                                </div>
                                                                <input class="form-control" data-error="Invalid data entered."
                                                                    placeholder="Total Revenues/Turnover" type="number"
                                                                    name="Year_{{ $i }}_tr" value="{{number_format($pf_row['totalrevenue'], 2, '.', '')}}">
                                                            </div>
                                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">
                                                                {{trans('my_deal.year_common_totalannual_label')}}
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text currency-symb">
                                                                        {{$data['deal_info']->symbol}}
                                                                    </div>
                                                                </div>
                                                                <input class="form-control" data-error="Invalid data entered."
                                                                    placeholder="Total Annual Operating Costs" type="number"
                                                                    name="Year_{{ $i }}_taoc" value="{{number_format($pf_row['totalannualoperatingcost'], 2, '.', '')}}">
                                                            </div>
                                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">
                                                                {{trans('my_deal.year_common_ebitda_label')}}
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text currency-symb">
                                                                        {{$data['deal_info']->symbol}}
                                                                    </div>
                                                                </div>
                                                                <input class="form-control" data-error="Invalid data entered."
                                                                    placeholder="EBITDA" type="number" name="Year_{{ $i }}_ebtda"
                                                                    value="{{number_format($pf_row['ebitda'], 2, '.', '')}}">
                                                            </div>
                                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">
                                                                {{trans('my_deal.year_common_netcash_label')}}
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text currency-symb">
                                                                        {{$data['deal_info']->symbol}}
                                                                    </div>
                                                                </div>
                                                                <input class="form-control" data-error="Invalid data entered."
                                                                    placeholder="Net Cash" type="number" name="Year_{{ $i }}_netcash"
                                                                    value="{{number_format($pf_row['netcash'], 2, '.', '')}}">
                                                            </div>
                                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endfor

                                                <div class="form-buttons-w text-right">
                                                    <input class="btn btn-primary" type="submit" name="user_info" value="{{trans('my_deal.btn_save_title')}}">
                                                </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="element-wrapper margin-top">
                        <!--
                        START - documents table
                        -->
                        <h5 class="element-header">
                            {{trans('my_deal.documents_title')}}
                        </h5>
                        <div class="element-box table-rit-section">
                            <h5 class="form-header">
                                {{trans('my_deal.documents_public_caption')}}
                            </h5>
                            <div class="form-desc">
                                {{trans('my_deal.documents_public_text')}}
                            </div>
                            <div class="controls-above-table">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">
                                        <button class="btn btn-sm btn-primary" data-target="#exampleModal1" data-toggle="modal"
                                            type="button">{{trans('my_deal.public_upload_btn_label')}}</button>
                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal1"
                                            role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{trans('my_deal.public_modal_title')}}
                                                        </h5>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true"> ×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('deal.document.store')}}" method="POST"
                                                            enctype="multipart/form-data" class="dropzone" id="upload-files-public">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="public_documents" value="public_documents" />
                                                            <input type="hidden" name="dealid" value="{{$data['deal_info']->dealid}}" />
                                                            <div class="dz-message">
                                                                <div>
                                                                    <h4>{{trans('my_deal.public_modal_drop_text')}}</h4>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-sm btn-danger" data-dismiss="modal" type="button">
                                                            Close</button><button class="btn btn-sm btn-danger" type="button">{{trans('my_deal.public_modal_upload_btn_label')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-sm btn-danger" type="button" onclick="fnDeleteDocuments('public');">{{trans('my_deal.public_delete_btn_label')}}</button>
                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="public_document_delete_modal"
                                            role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            {{trans('my_deal.modal_delete_confirmation')}}
                                                        </h5>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true"> ×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <h6>
                                                                            {{trans('my_deal.modal_delete_text')}}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="alert alert-success" role="alert" id="del-message-box"
                                                        style="display:none;">
                                                        {{trans('my_deal.modal_delete_success')}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-dismiss="modal" type="button"
                                                            id="mdel_close">{{trans('my_deal.btn_del_no')}}</button>
                                                        <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedDocuments('public');"
                                                            id="btn_del_yes">{{trans('my_deal.btn_del_yes')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-8 filter-moble">
                                        <form class="form-inline justify-content-sm-end">
                                            <!-- <input id="public_document" onkeyup="publicDocuments()" class="form-control form-control-sm rounded bright" placeholder="Search" type="text"> -->
                                            <input ng-model='public_search.documentname' class="form-control form-control-sm rounded bright"
                                                placeholder="{{trans('my_deal.input_search_placeholder')}}" type="text">
                                            <select ng-model='sortByPublic' class="form-control form-control-sm rounded bright">
                                                <option selected="selected" value="">
                                                    {{trans('my_deal.select_sort_by')}}
                                                </option>
                                                <option value="documentname">{{trans('my_deal.select_file_name')}}
                                                </option>
                                                <option value="extention">{{trans('my_deal.select_type')}}</option>
                                                <option value="updated">{{trans('my_deal.select_date')}}</option>
                                            </select>
                                            <select ng-model='filterByExt' class="form-control form-control-sm rounded bright">
                                                <option selected="selected" value="">
                                                    {{trans('my_deal.select_filter')}}
                                                </option>
                                                <option value="txt">
                                                    {{trans('my_deal.select_txt')}}
                                                </option>
                                                <option value="jpg">
                                                    {{trans('my_deal.select_jpg')}}
                                                </option>
                                                <option value="png">
                                                    {{trans('my_deal.select_png')}}
                                                </option>
                                                <option value="xls">
                                                    {{trans('my_deal.select_xls')}}
                                                </option>
                                                <option value="xlsx">
                                                    {{trans('my_deal.select_xlsx')}}
                                                </option>
                                                <option value="pdf">
                                                    {{trans('my_deal.select_pdf')}}
                                                </option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive table-responsive-heading-spce">
                                <form action="" method="POST">
                                    {{CSRF_FIELD()}}

                                    <table class="table table-lightborder" ng-controller="deal_document">
                                        <input ng-model="dealid" type="hidden" value="{{$data['deal_info']->dealid}}">
                                        <thead>
                                            <tr>
                                                <th class="name">
                                                    {{trans('my_deal.table_filename')}}
                                                </th>
                                                <th class="type">
                                                    {{trans('my_deal.table_filetype')}}
                                                </th>
                                                <th class="format">
                                                    {{trans('my_deal.table_fileformat')}}
                                                </th>
                                                <th class="date">
                                                    {{trans('my_deal.table_filedate')}}
                                                </th>
                                                <th class="action">
                                                    {{trans('my_deal.table_fileaction')}}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="public_document_table">
                                            <tr ng-hide="!publicdoc.length" ng-repeat="public in publicdoc | filter:public_search | filter:filterByExt | orderBy: sortByPublic">
                                                @verbatim
                                                <td><input class="form-control" type="checkbox" value="{{ public.documentid }}">{{
                                                    public.documentname }}</td>
                                                <td>{{ ::public.type }}</td>
                                                <td>{{ ::public.extention }}</td>
                                                <td>{{ ::public.updated }}</td>
                                                @endverbatim
                                                <td>
                                                    <a href="/storage/deal/documents/public/@{{ public.documenttitle }}"
                                                        target="_blank">
                                                        <i class="os-icon os-icon-signs-11"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr ng-hide="publicdoc.length > 0">
                                                <td colspan="5">{{trans('eso_company_profile_view.documents_public_not_found')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="element-box table-rit-section">
                            <h5 class="form-header">
                                {{trans('my_deal.documents_private_caption')}}
                            </h5>
                            <div class="form-desc">
                                {{trans('my_deal.documents_public_text')}}
                            </div>
                            <div class="controls-above-table">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">
                                        <button class="btn btn-sm btn-primary" data-target="#exampleModal2" data-toggle="modal"
                                            type="button">Upload</button>
                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal2"
                                            role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{trans('my_deal.private_modal_title')}}
                                                        </h5>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true"> ×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('deal.document.store')}}" method="POST"
                                                            enctype="multipart/form-data" class="dropzone" id="upload-files-private">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="private_documents" value="private_documents" />
                                                            <input type="hidden" name="dealid" value="{{$data['deal_info']->dealid}}" />
                                                            <div class="dz-message">
                                                                <div>
                                                                    <h4>{{trans('my_deal.public_modal_drop_text')}}</h4>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-sm btn-danger" data-dismiss="modal" type="button">
                                                            Close</button><button class="btn btn-sm btn-danger" type="button">{{trans('my_deal.public_modal_upload_btn_label')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <a class="btn btn-sm btn-primary" href="#">Upload</a> -->
                                        {{-- <a class="btn btn-sm btn-danger" href="#">Delete</a> --}}
                                        <button class="btn btn-sm btn-danger" type="button" onclick="fnDeleteDocuments('private');">{{trans('my_deal.public_delete_btn_label')}}</button>
                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="private_document_delete_modal"
                                            role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            {{trans('my_deal.modal_delete_confirmation')}}
                                                        </h5>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true"> ×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <h6>
                                                                            {{trans('my_deal.modal_delete_text')}}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="alert alert-success" role="alert" id="del-message-box-private"
                                                        style="display:none;">
                                                        {{trans('my_deal.modal_delete_success')}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-dismiss="modal" type="button"
                                                            id="mdel_close_private">{{trans('my_deal.btn_del_no')}}</button>
                                                        <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedDocuments('private');"
                                                            id="btn_del_yes_private">{{trans('my_deal.btn_del_yes')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-8 filter-moble">
                                        <form class="form-inline justify-content-sm-end">
                                            <input ng-model='private_search.documentname' class="form-control form-control-sm rounded bright"
                                                placeholder="Search" type="text">
                                            <select ng-model='sortByPrivate' class="form-control form-control-sm rounded bright">
                                                <option selected="selected" value="">
                                                    {{trans('my_deal.select_sort_by')}}
                                                </option>
                                                <option value="documentname">{{trans('my_deal.select_file_name')}}
                                                </option>
                                                <option value="extention">{{trans('my_deal.select_type')}}</option>
                                                <option value="updated">{{trans('my_deal.select_date')}}</option>
                                            </select>
                                            <select ng-model='privateFilterByExt' class="form-control form-control-sm rounded bright">
                                                <option selected="selected" value="">
                                                    {{trans('my_deal.select_filter')}}
                                                </option>
                                                <option value="txt">
                                                    {{trans('my_deal.select_txt')}}
                                                </option>
                                                <option value="jpg">
                                                    {{trans('my_deal.select_jpg')}}
                                                </option>
                                                <option value="png">
                                                    {{trans('my_deal.select_png')}}
                                                </option>
                                                <option value="xls">
                                                    {{trans('my_deal.select_xls')}}
                                                </option>
                                                <option value="xlsx">
                                                    {{trans('my_deal.select_xlsx')}}
                                                </option>
                                                <option value="pdf">
                                                    {{trans('my_deal.select_pdf')}}
                                                </option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive table-responsive-heading-spce">

                                <table class="table table-lightborder" ng-controller="deal_document">
                                    <input ng-model="dealid" type="hidden" value="{{$data['deal_info']->dealid}}">
                                    <thead>
                                        <tr>
                                            <th class="name">
                                                {{trans('my_deal.table_filename')}}
                                            </th>
                                            <th class="type">
                                                {{trans('my_deal.table_filetype')}}
                                            </th>
                                            <th class="format">
                                                {{trans('my_deal.table_fileformat')}}
                                            </th>
                                            <th class="date">
                                                {{trans('my_deal.table_filedate')}}
                                            </th>
                                            <th class="action">
                                                {{trans('my_deal.table_fileaction')}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="private_document_table">
                                        <tr ng-hide="!privatedoc.length" ng-repeat="private in privatedoc | filter:private_search | filter:privateFilterByExt | orderBy: sortByPrivate">
                                            <td><input class="form-control" type="checkbox" value="@{{ private.documentid }}">@{{
                                                private.documentname }}</td>
                                            <td>@{{ private.type }}</td>
                                            <td>@{{ private.extention }}</td>
                                            <td>@{{ private.updated }}</td>
                                            <td>
                                                <a href="/storage/deal/documents/private/@{{ private.documenttitle }}"
                                                    target="_blank">
                                                    <i class="os-icon os-icon-signs-11"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr ng-hide="privatedoc.length > 0">
                                            <td colspan="5">{{trans('eso_company_profile_view.documents_private_not_found')}}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!--------------------
                        END - documents table
                        -------------------->
                </div>
            </div>
            <!--------------------
              START - Color Scheme Toggler
              -------------------->
            <div class="floated-colors-btn second-floated-btn">
                <div class="os-toggler-w">
                    <div class="os-toggler-i">
                        <div class="os-toggler-pill"></div>
                    </div>
                </div>
                <span>Dark </span>
                <span>Colors</span>
            </div>
            <!--------------------
              END - Color Scheme Toggler
              -------------------->
            <!--------------------
              START - Chat Popup Box
              -------------------->
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
                                    John Bloggs
                                </h6>
                                <div class="user-role">
                                    Director
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
                                Hi, my name is Mike, I will be happy to assist you
                            </div>
                        </div>
                        <div class="message self">
                            <div class="message-content">
                                Hi, I tried ordering this product and it keeps showing me error code.
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
            <!--------------------
              END - Chat Popup Box
              -------------------->
        </div>
    </div>
</div>
<script>
    function privateDocuments() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("private_document");
        table = document.getElementById("private_document_table");
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
</script>


@endsection


@section('scripts')
<script type="text/javascript">
    function fnDeleteDocuments(mode) {
        debugger;
        var cnt = 0;
        if (mode == 'public') {
            $('#public_document_table input:checkbox:checked').each(function () {
                debugger;
                var id = $(this).attr('value');
                cnt = cnt + 1;
            });
        } else { //private case
            $('#private_document_table input:checkbox:checked').each(function () {
                debugger;
                var id = $(this).attr('value');
                cnt = cnt + 1;
            });

        }

        if (cnt <= 0) {
            return;
        }

        if (cnt > 0) {
            if (mode == 'public') {
                $('#public_document_delete_modal').modal('show');
            } else //Private Case....
            {
                $('#private_document_delete_modal').modal('show');
            }
        }
    }

    function fnDeleteSelectedDocuments(mode) {
        debugger;
        var documentlist = [];
        var cnt = 0;
        if (mode == 'public') {
            $('#public_document_table input:checkbox:checked').each(function () {
                var id = $(this).attr('value');
                documentlist.push({
                    documentid: id
                });
                cnt = cnt + 1;
            });
        } else { //private case
            $('#private_document_table input:checkbox:checked').each(function () {
                var id = $(this).attr('value');
                documentlist.push({
                    documentid: id
                });
                cnt = cnt + 1;
            });
        }


        if (cnt <= 0) {
            return;
        }

        if (cnt > 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData();

            formdata.append("documentlist", JSON.stringify(documentlist));
            formdata.append("type", mode);
            formdata.append("_token", '{{csrf_token()}}');

            $.ajax({
                url: '/deal-delete-documents',
                type: "POST",
                contentType: false,
                processData: false,
                data: formdata,
                cache: false,
                timeout: 100000,
                success: function (data) {
                    if (mode == 'public') {
                        var $messageDiv = $('#del-message-box');
                        $messageDiv.show();
                        setTimeout(function () {
                            $messageDiv.hide();
                            $('#public_document_delete_modal').modal('hide');
                            window.location.reload(true);
                        }, 3000);
                    } else { //case of private...
                        var $messageDiv = $('#del-message-box-private');
                        $messageDiv.show();
                        setTimeout(function () {
                            $messageDiv.hide();
                            $('#private_document_delete_modal').modal('hide');
                            window.location.reload(true);
                        }, 3000);
                    }


                },
                error: function (err, result) {
                    debugger;
                    alert("Error" + err.responseText);
                }
            });

        }
    }


    function currencychange(currency) {
        //alert(currency);
        $.get('/getsymbol?currency=' + currency, function (data) {
            $('.currency-symb').html(data);
        });
    }

    $(document).ready(function () {
        var currency = $('[name="currency"]').val();
        $.get('/getsymbol?currency=' + currency, function (data) {
            $('.currency-symb').html(data);
        });
    });
</script>
@endsection