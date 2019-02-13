@php
$helper=\App\Helpers\AppHelper::instance();
@endphp
@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')

<div class="content-w investor-profil" ng-app="myApp">
    @include('shared._top_menu')

    <div class="content-i">
        <div class="content-box enterprise-company">

            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('enterprises_company_profile_edit.help_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!$helper->GetHelpModifiedText(trans('enterprises_company_profile_edit.help_content'))!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('enterprises_company_profile_edit.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif



            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-4">
                    <div class="user-profile compact">
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
                                <h2 class="up-header">
                                    {{-- Kinara Capital --}}
                                    {{$data['company_information']->name}}
                                </h2>
                                <h6 class="up-sub-header">
                                    {{-- Enterprise --}}
                                    {{trans('enterprise_company.entity_type')}}
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
                                            {{-- Country(S): --}}
                                            {{trans('enterprises_company_profile_edit.general_country_caption')}}:
                                        </div>
                                        <div class="value">
                                            {{ $data['countries']['current_country']->name }}
                                        </div>
                                    </div>
                                    {{-- @php
                                    $profile_image =
                                    asset('storage/company/profileimage/'.$data['company_information']->profileimage);
                                    @endphp
                                    <div class="rianta-img">
                                        <img src="{{ $profile_image  }}" class="img-responsive">
                                    </div> --}}
                                    <div class="rianta-img">
                                        @if( (isset($data['company_information']->profileimage) &&
                                        !empty($data['company_information']->profileimage) ) &&
                                        File::exists(public_path('storage/company/profileimage/'.$data['company_information']->profileimage)))
                                        <img src="{{ asset('imagecache/company_logo/'.$data['company_information']->profileimage) }}"
                                            class="img-responsive">
                                        @else
                                        <img alt="{{$data['company_information']->name}}" src="{{ Avatar::create($data['company_information']->name)->toBase64() }}"
                                            style="height:61px;" class="img-responsive">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="element-wrapper">
                        <!--------------------
                        start - Logo Image
                        -------------------->
                        <div class="element-box">
                            <h5 class="form-header">
                                {{trans('enterprises_company_profile_edit.general_logo_title')}}
                            </h5>
                            <div class="form-desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit
                            </div>
                            <form action="{{ route('company.cover.logo.image.store') }}" method="POST" enctype="multipart/form-data"
                                class="dropzone" id="profile_image">
                                {{ csrf_field() }}
                                <input type="hidden" name="profile_image" value="profile_image">
                                <div class="dz-message">
                                    <div>
                                        <h4>{{trans('enterprises_company_profile_edit.general_drag_and_drop')}}</h4>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="element-box">
                            <h5 class="form-header">
                                {{trans('enterprises_company_profile_edit.general_cover_image_title')}}
                            </h5>
                            <div class="form-desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit
                            </div>
                            <form action="{{ route('company.cover.logo.image.store') }}" method="POST" enctype="multipart/form-data"
                                class="dropzone" id="cover_image">
                                {{ csrf_field() }}
                                <input type="hidden" name="cover_image" value="cover_image">
                                <div class="dz-message">
                                    <div>
                                        <h4>{{trans('enterprises_company_profile_edit.general_drag_and_drop')}}</h4>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--
                        END - Logo Image
                        -------------------->
                        <!--------------------
                         start - right section video
                        -------------------->


                        @php
                        $video_path = false;
                        if($data['videofile'] != null) {
                        $video_path = asset('storage/company/videos/'.$data['videofile']->videopath);
                        }
                        @endphp
                        @if($video_path!=false && $data['videofile'] != null &&
                        File::exists(public_path('storage/company/videos/'.$data['videofile']->videopath)))
                        <div class="video-rit">
                            <div class="element-wrapper">
                                <h6 class="element-header">
                                    <h4>{{trans('enterprises_company_profile_edit.general_video')}}</h4>
                                </h6>
                                <div class="element-box">
                                    <div class="el-chart-w">
                                        <a class="video-play" data-target="#onboardingWideFeaturesModal" data-toggle="modal"
                                            onclick="makeiframesingle();">

                                            <img src="{{ asset('img/video-test.jpg') }}" alt="Play Video" class="img-responsive" />
                                        </a>
                                        <div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingWideFeaturesModal"
                                            role="dialog" tabindex="-1">
                                            <div class="modal-dialog modal-lg modal-centered" role="document">
                                                <div class="modal-content text-center">
                                                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"
                                                        onclick="closesingle();">
                                                        <span class="close-label">Skip Intro</span>
                                                        <span class="os-icon os-icon-close" style="z-index:99999;color:white;"></span>
                                                    </button>
                                                    <div class="onboarding-side-by-side">
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
                            </div>
                        </div>

                        @endif


                        <!--------------------
                        END - right section video
                        -------------------->
                        <!--
                          START - Video Upload
                        -->
                        <div class="element-box">
                            <h5 class="form-header">
                                <h4>{{trans('enterprises_company_profile_edit.general_video_upload_caption')}}</h4>
                            </h5>
                            <div class="form-desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit
                            </div>
                            <form action="{{ route('company.video.store') }}" method="POST" enctype="multipart/form-data"
                                class="dropzone" id="myawesomedropzone">
                                {{ csrf_field() }}
                                <div class="dz-message">
                                    <div>
                                        <h4>{{trans('enterprises_company_profile_edit.general_drag_and_drop')}}</h4>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--
                         END - Video Upload
                         -->
                    </div>
                </div>
                <!--
                 START - right section content area
                 -->
                <div class="col-sm-12 col-md-12 col-lg-8">
                    <div class="element-wrapper">
                        <div class="element-box">
                            <form id="formValidate" method="POST" action="{{ route('company.profile.update') }}">
                                {{ csrf_field() }}
                                <div class="steps-w">
                                    <div class="step-triggers">
                                        <a class="step-trigger active" href="#stepContent1">Company Information</a>
                                        <a class="step-trigger" href="#stepContent2">Financial Information</a>
                                        <a class="step-trigger" href="#stepContent3">Impact Information</a>
                                    </div>
                                    <div class="step-contents">
                                        <div class="step-content active" id="stepContent1">
                                            <h5 class="form-header"> Company Profile </h5>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('enterprises_company_profile_edit.general_company_name')}}*
                                                        </label>
                                                        <input class="form-control" placeholder="Enter Name" data-error="Organization/Company Name is required."
                                                            required="required" type="text" name="company_name" value="{{old('', $data['company_information']->name)}}">
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('enterprises_company_profile_edit.general_email')}}
                                                        </label>
                                                        <input class="form-control" placeholder="Enter email" type="email"
                                                            name="email" value="{{old('', $data['company_information']->email)}}">
                                                        {{-- <div class="help-block form-text with-errors form-control-feedback"></div>
                                                        --}}
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('enterprises_company_profile_edit.general_telephone')}}
                                                        </label>
                                                        <input class="form-control" placeholder="Telephone" type="text"
                                                            name="telephone" value="{{old('', $data['company_information']->telephone)}}">
                                                        {{-- <div class="help-block form-text with-errors form-control-feedback"></div>
                                                        --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">
                                                    {{trans('enterprises_company_profile_edit.general_website')}}
                                                </label>
                                                <input class="form-control" placeholder="Website URL" type="text" name="website"
                                                    value="{{old('',$data['company_information']->website)}}">
                                                {{-- <div class="help-block form-text with-errors form-control-feedback"></div>
                                                --}}
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('enterprises_company_profile_edit.general_skype')}}
                                                        </label>
                                                        <input class="form-control" placeholder="Skype ID" type="text"
                                                            name="skype" value="{{ old('', $data['company_information']->skype) }}">
                                                        {{-- <div class="help-block form-text with-errors form-control-feedback"></div>
                                                        --}}
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('enterprises_company_profile_edit.general_twitter')}}
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    @
                                                                </div>
                                                            </div>
                                                            <input class="form-control" placeholder="Twitter Username"
                                                                type="text" name="twitter" value="{{old('', $data['company_information']->twitter)}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">
                                                    {{trans('enterprises_company_profile_edit.general_address')}}
                                                </label>
                                                <input class="form-control" type="text" name="address" value="{{old('', $data['company_information']->address)}}">
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('enterprises_company_profile_edit.general_city')}}
                                                        </label>
                                                        <input class="form-control" placeholder="City" type="text" name="city"
                                                            value="{{old('', $data['company_information']->city)}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('enterprises_company_profile_edit.general_postcode')}}*
                                                        </label>
                                                        <input class="form-control" data-error="Postcode / Zip Name is required."
                                                            required="required" placeholder="Postcode / Zip" type="text"
                                                            name="zip" value="{{old('', $data['company_information']->zip)}}">
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('enterprises_company_profile_edit.general_country')}}*
                                                        </label>
                                                        <select class="form-control" name="country" id="country"
                                                            placeholder="Country" data-error="Country is required."
                                                            required="required">
                                                            @if(isset($data['countries']['total_countries']))
                                                            @foreach($data['countries']['total_countries'] as $country)
                                                            <option value="{{ $country->countryid }}" @isset(
                                                                $data['countries']['selected_country']->
                                                                countryid )
                                                                {{
                                                                ( $country->countryid ==
                                                                $data['countries']['selected_country']->countryid ) ?
                                                                "selected='selected'" : ''
                                                                }}
                                                                @endisset
                                                                >{{ $country->name }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('enterprises_company_profile_edit.general_state')}}*
                                                        </label>
                                                        <select name="state" id="state" class="form-control"
                                                            placeholder="State  / Region" data-error="State  / Region is required."
                                                            required="required">
                                                            @if(isset($data['states']['total_states']))
                                                            @foreach($data['states']['total_states'] as $state)
                                                            <option value="{{ $state->stateid }}" @isset(
                                                                $data['states']['selected_state']->
                                                                stateid )
                                                                {{
                                                                ( $state->stateid ==
                                                                $data['states']['selected_state']->stateid ) ?
                                                                "selected='selected'" : ''
                                                                }}
                                                                @endisset
                                                                >{{ $state->name }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5 class="form-header">{{trans('enterprises_company_profile_edit.general_label_business_profile')}}
                                            </h5>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('enterprises_company_profile_edit.general_label_year_founded')}}</label>
                                                        <input class="form-control" data-error="Entered data is invalid."
                                                            type="number" pattern="[0-9]" name="year_founded" value="{{old('', $data['company_information']->foundedyear)}}">
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">{{trans('enterprises_company_profile_edit.general_label_preferred_currency')}}
                                                        </label>
                                                        <select class="form-control" name="currency">
                                                            @if(isset($data['currency']['all_currency']))
                                                            @foreach($data['currency']['all_currency'] as $currency)
                                                            <option value="{{ $currency->currencyid }}" @isset(
                                                                $data['currency']['selected_currency']->
                                                                preferedcurrencyid )
                                                                {{
                                                                (
                                                                $data['currency']['selected_currency']->preferedcurrencyid
                                                                == $currency->currencyid ) ? "selected =='selected'" :
                                                                ''
                                                                }}
                                                                @endisset
                                                                >{{ $currency->currencyname }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        <!-- <input class="form-control" type="text" name="prefered_currency" value="{{old('', $data['company_information']->preferedcurrencyid)}}"> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">{{trans('enterprises_company_profile_edit.general_label_type_of_entity')}}
                                                        </label>
                                                        <select class="form-control" name="entity_type">
                                                            @if(isset($data['entity_type']['entity']))
                                                            @foreach($data['entity_type']['entity'] as $entity)
                                                            <option value="{{ $entity->accountingcompanytypeid }}"
                                                                @isset( $data['entity_type']['selected_entity']->
                                                                accountingcompanytype )
                                                                {{
                                                                (
                                                                $data['entity_type']['selected_entity']->accountingcompanytype
                                                                == $entity->accountingcompanytypeid ) ? "selected
                                                                =='selected'" : ''
                                                                }}
                                                                @endisset
                                                                >{{ $entity->companytype }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('enterprises_company_profile_edit.investment_sector_of_specialization')}}
                                                        </label>
                                                        <select class="form-control select2" name="specializedsectors[]">
                                                            @if(isset($data['sectors']))
                                                            @foreach($data['sectors']['total_sectors'] as $sectors)
                                                            <option value="{{ $sectors->sectorid }}"
                                                                @if(isset($data['sectors']['selected_sector']))
                                                                @foreach($data['sectors']['selected_sector'] as
                                                                $selsector) @if($selsector->
                                                                sectorid==$sectors->sectorid)
                                                                selected="true"
                                                                @endif
                                                                @endforeach
                                                                @endif

                                                                >{{ $sectors->name }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">{{trans('enterprises_company_profile_edit.general_label_referred_by')}}</label>
                                                        <select class="form-control">
                                                            @if(isset($data['referred_by']))
                                                            @foreach($data['referred_by']['total_users'] as $users)
                                                            <option value="{{ $users->userid }}" @isset(
                                                                $data['referred_by']['selected_user']->
                                                                referredbyid )
                                                                {{
                                                                ( $data['referred_by']['selected_user']->referredbyid
                                                                == $users->userid ) ? "selected =='selected' " : ''
                                                                }}
                                                                @endisset
                                                                >{{ $users->firstname.' '.$users->lastname }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group paragraph">
                                                        <label for="">{{trans('enterprises_company_profile_edit.general_label_business_summary')}}</label>
                                                        <p>
                                                            {{trans('enterprises_company_profile_edit.general_business_summary_details')}}
                                                        </p>
                                                        <textarea class="form-control" name='business_summary' rows="3">{{ old('',$data['company_information']->businesssummary) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">{{trans('enterprises_company_profile_edit.general_business_label_one_line_pitch')}}</label>
                                                        <textarea class="form-control" name='oneline_pitch' rows="3">{{ old('',$data['company_information']->onelinepitch) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group paragraph">
                                                        <label for="">{{trans('enterprises_company_profile_edit.general_business_label_sales_marketing_strategy')}}</label>
                                                        <p>{{trans('enterprises_company_profile_edit.general_business_sales_marketing_text')}}</p>
                                                        <textarea class="form-control" name='sales_strategy' rows="3">{{ old('',$data['company_information']->salesstrategy) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group paragraph">
                                                        <label for="">{{trans('enterprises_company_profile_edit.general_business_label_competitive_advantege')}}</label>
                                                        <p>
                                                            {{trans('enterprises_company_profile_edit.general_business_competitive_advantege_text')}}
                                                        </p>
                                                        <textarea class="form-control" name="competative_advantage"
                                                            rows="3">{{ old('',$data['company_information']->competativeadvantage) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">{{trans('enterprises_company_profile_edit.general_business_label_pending_existing_patents')}}</label>
                                                        <textarea class="form-control" name="existing_patents" rows="3">{{ old('',$data['company_information']->existingpatents) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">{{trans('enterprises_company_profile_edit.general_business_label_competitions_recognition')}}</label>
                                                        <textarea class="form-control" name="recognition" rows="3">{{ old('',$data['company_information']->recognition) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">{{trans('enterprises_company_profile_edit.general_business_label_hear_about_artha')}}</label>
                                                        <textarea class="form-control" name="hear_about_artha" rows="3">{{ old('',$data['company_information']->hearaboutartha) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                                                <a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Next</a>
                                            </div>

                                        </div>
                                        <div class="step-content financial-section-tab" id="stepContent2">
                                            @if($data['historical_data']->isNotEmpty())
                                            <h5 class="form-header">Past Financials <span class="tasks-sub-header">(Optional)</span>
                                            </h5>
                                            <!--  STRAT Historical  -->

                                            @php $count = 1; @endphp
                                            @foreach($data['historical_data'] as $historical_data )

                                            <div class="enterprise-sub-hd">
                                                <strong>Historical {{ $count }} </strong>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for=""> Year </label>
                                                        <select class="form-control">

                                                            @for ($i = 2000 ; $i <= date('Y'); $i++) <option value="{{ $i }}"
                                                                @isset($historical_data->
                                                                historical_year)
                                                                {{
                                                                ($historical_data->historical_year == $i) ? "selected
                                                                =='selected' " : ''
                                                                }}
                                                                @endisset
                                                                >{{$i}}
                                                                </option>
                                                                @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Annual Operating Costs </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['companycurrency']->symbol}}
                                                                </div>
                                                            </div>

                                                            <input class="form-control" type="text" value="{{old('', $historical_data->annualoperatingcosts )}}">
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Average Annual Revenues </label>
                                                        <input class="form-control" type="text" value="{{old('', $historical_data->averageannualrevenue )}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for=""> Average Next Income </label>
                                                        <input class="form-control" type="text" value="{{old('', $historical_data->averagenetincome )}}">
                                                    </div>
                                                </div>
                                            </div>
                                            @php $count = $count + 1; @endphp
                                            @endforeach
                                            <!--  END Historical  -->
                                            @endif



                                            <h5 class="form-header">Current Financials</h5>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">Information as of (Year)</label>
                                                        <div class="date-input">
                                                            <input class="form-control" name="current_financials"
                                                                placeholder="Information as of (Year)" type="date"
                                                                format="d-M-Y" value="{{old('', $data['company_information']->financialinfo_informationdate)}}">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Current Assets</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['companycurrency']->symbol}}
                                                                </div>
                                                            </div>

                                                            <input class="form-control" name="current_assets"
                                                                data-error="Entered data is invalid." type="number"
                                                                step=".01" value="{{ old('',number_format($data['company_information']->financialinfo_currentassets, 2, '.', '')) }}">
                                                        </div>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Total Assets</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['companycurrency']->symbol}}
                                                                </div>
                                                            </div>

                                                            <input class="form-control" name="total_assets" data-error="Entered data is invalid."
                                                                type="number" step=".01" value="{{ old('',number_format($data['company_information']->financialinfo_totalassets, 2, '.', '')) }}">
                                                        </div>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Current Liabilities</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['companycurrency']->symbol}}
                                                                </div>
                                                            </div>

                                                            <input class="form-control" name="current_liabilities"
                                                                data-error="Entered data is invalid." type="number"
                                                                step=".01" value="{{ old('',number_format($data['company_information']->financialinfo_currentliabilities, 2, '.', '')) }}">
                                                        </div>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Total Liabilities</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['companycurrency']->symbol}}
                                                                </div>
                                                            </div>

                                                            <input class="form-control" name="total_liabilities"
                                                                data-error="Entered data is invalid." type="number"
                                                                step=".01" value="{{ old('',number_format($data['company_information']->financialinfo_totalliabilities, 2, '.', '')) }}">
                                                        </div>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Total Equity</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['companycurrency']->symbol}}
                                                                </div>
                                                            </div>

                                                            <input class="form-control" name="total_equity" data-error="Entered data is invalid."
                                                                type="number" step=".01" value="{{ old('',number_format($data['company_information']->financialinfo_totalequity, 2, '.', '')) }}">
                                                        </div>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Net Cash</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['companycurrency']->symbol}}
                                                                </div>
                                                            </div>

                                                            <input class="form-control" name="net_cash" data-error="Entered data is invalid."
                                                                type="number" step=".01" value="{{ old('',number_format($data['company_information']->financialinfo_netcash, 2, '.', '')) }}">
                                                        </div>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">EBITDA </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">
                                                                    {{$data['companycurrency']->symbol}}
                                                                </div>
                                                            </div>

                                                            <input class="form-control" name="ebitda" data-error="Entered data is invalid."
                                                                type="number" step=".01" value="{{ old('',number_format($data['company_information']->financialinfo_ebitda, 2, '.', '')) }}">
                                                        </div>
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for=""> Do you have audited financial statements?</label>
                                                        <select name="audited_financial_statements" class="form-control">
                                                            <option value=1
                                                                {{ ($data['company_information']->financialinfo_auditedfinancialstatement  == 1) ? "selected='selected' " : '' }}>
                                                                Yes
                                                            </option>
                                                            <option value=0
                                                                {{ ($data['company_information']->financialinfo_auditedfinancialstatement  == 0) ? "selected='selected' " : '' }}>
                                                                No
                                                            </option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                                                <a class="btn btn-primary step-trigger-btn" href="#stepContent1">
                                                    Previous</a>
                                                <a class="btn btn-primary step-trigger-btn" href="#stepContent3"> Next</a>
                                            </div>
                                        </div>
                                        <div class="step-content" id="stepContent3">
                                            <h5 class="form-header">Impact Information</h5>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">problem being solved</label>
                                                        <textarea class="form-control" name="impactinfo_info" rows="3">{{ old('',$data['company_information']->impactinfo_info) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group paragraph">
                                                        <label for="">Social impact benefit created </label>
                                                        <p>Please describe any social benefit or impact your firm
                                                            creates through its operation.</p>
                                                        <textarea class="form-control" name="social_impact" rows="3">{{ old('',$data['company_information']->impactinfo_socialbenefitimpact) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group paragraph">
                                                        <label for="">Environmental impact benefit created </label>
                                                        <p>Please describe any social benefit or impact your firm
                                                            creates through its operation.</p> <textarea class="form-control"
                                                            name="environmental_impact" rows="3">{{ old('',$data['company_information']->impactinfo_environmentbenefitimpact) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group paragraph">
                                                        <label for="">Specific impact beneficiaries</label>
                                                        <p>
                                                            (Please indicate any particular groups that stand to
                                                            benefit from your business activity, i.e
                                                            Youth, Women, Rural communities etc.)
                                                        </p>
                                                        <textarea class="form-control" name="specific_impact" rows="3">{{ old('',$data['company_information']->impactinfo_specificbeneficiaries) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                                                <a class="btn btn-primary step-trigger-btn" href="#stepContent2">
                                                    Previous</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="element-wrapper margin-top">
                        <!--------------------
        START - documents table
        -------------------->
                        <h5 class="element-header">
                            Documents
                        </h5>
                        <div class="element-box table-rit-section">
                            <h5 class="form-header">
                                {{trans('enterprises_company_profile_edit.documents_public_caption')}}
                            </h5>
                            <div class="form-desc">
                                This virtual filing cabinet is a space for you to upload any materials (including
                                brochures, summaries) that
                                support the communication of your core activity
                            </div>
                            <div class="controls-above-table">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">

                                        <button class="btn btn-sm btn-primary" data-target="#exampleModal1" data-toggle="modal"
                                            type="button">Upload</button>
                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal1"
                                            role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Upload Public Document
                                                        </h5>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true"> ×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('company.document.store')}}" method="POST"
                                                            enctype="multipart/form-data" class="dropzone" id="upload-files-public">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="public_documents" value="public_documents" />
                                                            <div class="dz-message">
                                                                <div>
                                                                    <h4>{{trans('enterprises_company_profile_edit.general_drag_and_drop')}}</h4>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-sm btn-danger" data-dismiss="modal" type="button">
                                                            Close</button><button class="btn btn-sm btn-danger" type="button">Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <a class="btn btn-sm btn-danger" href="#" onclick="fnDeletePublicDocuments();">Delete</a>
                                        --}}
                                        <button class="btn btn-sm btn-danger" type="button" onclick="fnDeleteDocuments('public');">Delete</button>
                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="public_document_delete_modal"
                                            role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            {{trans('enterprises_company_profile_edit.general_modal_title_delete')}}
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
                                                                            {{trans('enterprises_company_profile_edit.general_modal_delete_confirmation')}}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="alert alert-success" role="alert" id="del-message-box"
                                                        style="display:none;">
                                                        {{trans('enterprises_company_profile_edit.general_modal_document_deleted_message')}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-dismiss="modal" type="button"
                                                            id="mdel_close">{{trans('enterprises_company_profile_edit.general_modal_button_cancel_caption')}}</button>
                                                        <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedDocuments('public');"
                                                            id="btn_del_yes">{{trans('enterprises_company_profile_edit.general_modal_button_proceed_caption')}}</button>
                                                    </div>
                                                    {{-- --}}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 col-lg-8 filter-moble">
                                        <form class="form-inline justify-content-sm-end">
                                            <!-- <input id="public_document" onkeyup="publicDocuments()" class="form-control form-control-sm rounded bright" placeholder="Search" type="text"> -->
                                            <input ng-model='public_search.documentname' class="form-control form-control-sm rounded bright"
                                                placeholder="Search" type="text">
                                            <select ng-model='sortByPublic' class="form-control form-control-sm rounded bright">
                                                <option selected="selected" value="">
                                                    {{trans('enterprises_company_profile_edit.documents_public_sort')}}
                                                </option>
                                                <option value="documentname">File Name </option>
                                                <option value="extention">Type</option>
                                                <option value="updated">Date</option>
                                            </select>
                                            <!-- <select class="form-control form-control-sm rounded bright">
                              <option selected="selected" value="">
                                {{--trans('enterprises_company_profile_edit.documents_public_sort')--}}
                              </option>
                              <option value="Pending">
                                Name
                              </option>
                              <option value="Active">
                                Type
                              </option>
                              <option value="Cancelled">
                                Date
                              </option>
                            </select> -->
                                            <select ng-model='filterByExt' class="form-control form-control-sm rounded bright">
                                                <option selected="selected" value="">
                                                    {{trans('enterprises_company_profile_edit.documents_public_select_filter_type')}}
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
                                <form action="" method="POST">
                                    {{CSRF_FIELD()}}
                                    <table class="table table-lightborder" ng-controller="document">
                                        <thead>
                                            <tr>
                                                <th class="name">
                                                    {{trans('enterprises_company_profile_edit.documents_public_table_name')}}
                                                </th>
                                                <th class="type">
                                                    {{trans('enterprises_company_profile_edit.documents_public_table_type')}}
                                                </th>
                                                <th class="format">
                                                    {{trans('enterprises_company_profile_edit.documents_public_table_format')}}
                                                </th>
                                                <th class="date">
                                                    {{trans('enterprises_company_profile_edit.documents_public_table_date')}}
                                                </th>
                                                <th class="action">
                                                    {{trans('enterprises_company_profile_edit.documents_public_table_action')}}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="public_document_table">
                                            <tr ng-hide="!publicdoc.length" ng-repeat="public in publicdoc | filter:public_search | filter:filterByExt | orderBy: sortByPublic">
                                                @verbatim
                                                <td><input class="form-control" type="checkbox" id="flat" value="{{ public.documentid }}">{{
                                                    ::public.documentname }}</td>
                                                <td>{{ ::public.type }}</td>
                                                <td>{{ ::public.extention }}</td>
                                                <td>{{ ::public.updated }}</td>
                                                @endverbatim
                                                <td>
                                                    <a href="/storage/company/documents/public/@{{ public.documenttitle }}"
                                                        target="_blank">
                                                        <i class="os-icon os-icon-signs-11"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr ng-hide="publicdoc.length > 0">
                                                <td colspan="5">{{trans('enterprises_company_profile_edit.documents_public_not_found')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="element-box table-rit-section">
                            <h5 class="form-header">
                                {{trans('enterprises_company_profile_edit.documents_private_caption')}}
                            </h5>
                            <div class="form-desc">
                                This virtual filing cabinet is a space for you to upload any materials (including
                                brochures, summaries) that
                                support the communication of your core activity
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
                                                            Upload Private Document
                                                        </h5>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true"> ×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('company.document.store')}}" method="POST"
                                                            enctype="multipart/form-data" class="dropzone" id="upload-files-private">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="private_documents" value="private_documents" />
                                                            <div class="dz-message">
                                                                <div>
                                                                    <h4>{{trans('enterprises_company_profile_edit.general_drag_and_drop')}}</h4>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-sm btn-danger" data-dismiss="modal" type="button">
                                                            Close</button><button class="btn btn-sm btn-danger" type="button">Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <a class="btn btn-sm btn-primary" href="#">Upload</a> -->
                                        {{-- <a class="btn btn-sm btn-danger" href="#">Delete</a> --}}
                                        <button class="btn btn-sm btn-danger" type="button" onclick="fnDeleteDocuments('private');">Delete</button>
                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="private_document_delete_modal"
                                            role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            {{trans('enterprises_company_profile_edit.general_modal_title_delete')}}
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
                                                                            {{trans('enterprises_company_profile_edit.general_modal_delete_confirmation')}}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="alert alert-success" role="alert" id="del-message-box-private"
                                                        style="display:none;">
                                                        {{trans('enterprises_company_profile_edit.general_modal_document_deleted_message')}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-dismiss="modal" type="button"
                                                            id="mdel_close_private">{{trans('enterprises_company_profile_edit.general_modal_button_cancel_caption')}}</button>
                                                        <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedDocuments('private');"
                                                            id="btn_del_yes_private">{{trans('enterprises_company_profile_edit.general_modal_button_proceed_caption')}}</button>
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
                                                    {{trans('enterprises_company_profile_edit.documents_private_sort')}}
                                                </option>
                                                <option value="documentname">File Name </option>
                                                <option value="extention">Type</option>
                                                <option value="updated">Date</option>
                                            </select>
                                            <select ng-model='privateFilterByExt' class="form-control form-control-sm rounded bright">
                                                <option selected="selected" value="">
                                                    {{trans('enterprises_company_profile_edit.documents_public_select_filter_type')}}
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
                                                {{trans('enterprises_company_profile_edit.documents_private_table_name')}}
                                            </th>
                                            <th class="type">
                                                {{trans('enterprises_company_profile_edit.documents_private_table_type')}}
                                            </th>
                                            <th class="format">
                                                {{trans('enterprises_company_profile_edit.documents_private_table_format')}}
                                            </th>
                                            <th class="date">
                                                {{trans('enterprises_company_profile_edit.documents_private_table_date')}}
                                            </th>
                                            <th class="action">
                                                {{trans('enterprises_company_profile_edit.documents_private_table_action')}}
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
                                                <a href="/storage/company/documents/private/@{{ private.documenttitle }}"
                                                    target="_blank">
                                                    <i class="os-icon os-icon-signs-11"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr ng-hide="privatedoc.length > 0">
                                            <td colspan="5">{{trans('enterprises_company_profile_edit.documents_private_not_found')}}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>





                    <div class="element-wrapper margin-top">
                        <!--------------------
        START - documents table
        -------------------->
                        <h5 class="element-header">
                            {{trans('enterprises_company_profile_edit.gallery_heading')}}
                        </h5>
                        <div class="element-box table-rit-section">
                            <h5 class="form-header">
                                {{trans('enterprises_company_profile_edit.company_profile_gallery_images_lbl')}}
                            </h5>
                            <div class="form-desc">
                                {{trans('enterprises_company_profile_edit.company_profile_gallery_images_content')}}
                            </div>
                            <div class="controls-above-table">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">

                                        <button class="btn btn-sm btn-primary" data-target="#uploadgalleryimagemdl"
                                            data-toggle="modal" type="button">{{trans('enterprises_company_profile_edit.gallery_upload_btn_caption')}}</button>
                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="uploadgalleryimagemdl"
                                            role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{trans('enterprises_company_profile_edit.mdl_gallery_images_title')}}
                                                        </h5>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true"> ×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('company.gallery_images.store')}}"
                                                            method="POST" enctype="multipart/form-data" class="dropzone"
                                                            id="uploadgalleryimages">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="gallery" value="galleryimages" />
                                                            <div class="dz-message">
                                                                <div>
                                                                    <h4>{{trans('enterprises_company_profile_edit.general_drag_and_drop')}}</h4>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-sm btn-danger" data-dismiss="modal" type="button">

                                                            {{trans('enterprises_company_profile_edit.close_btn')}}</button>

                                                        <button class="btn btn-sm btn-danger" type="button">
                                                            {{trans('enterprises_company_profile_edit.upload_btn')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <a class="btn btn-sm btn-danger" href="#" onclick="fnDeletePublicDocuments();">Delete
                                        </a>
                                        --}}
                                        <button class="btn btn-sm btn-danger" type="button" onclick="fnDeleteGallery('galleryimages');">
                                            {{trans('enterprises_company_profile_edit.mdl_del_btn')}}</button>
                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="galleryimages_delete_modal"
                                            role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            {{trans('enterprises_company_profile_edit.gallery_modal_title_delete')}}
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
                                                                            {{trans('enterprises_company_profile_edit.gallery_modal_delete_confirmation')}}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="alert alert-success" role="alert" id="del-gallery-message-box"
                                                        style="display:none;">
                                                        {{trans('enterprises_company_profile_edit.gallery_modal_deleted_message')}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-dismiss="modal" type="button"
                                                            id="mdel_close">{{trans('enterprises_company_profile_edit.general_modal_button_cancel_caption')}}</button>
                                                        <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedgallery('galleryimages');"
                                                            id="btn_del_yes">{{trans('enterprises_company_profile_edit.general_modal_button_proceed_caption')}}</button>
                                                    </div>
                                                    {{-- --}}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 col-lg-8 filter-moble">
                                        <form class="form-inline justify-content-sm-end">
                                            <!-- <input id="public_document" onkeyup="publicDocuments()" class="form-control form-control-sm rounded bright" placeholder="Search" type="text"> -->
                                            <input ng-model='galleryimage_search.galleryname' class="form-control form-control-sm rounded bright"
                                                placeholder="Search" type="text">
                                            <select ng-model='sortByGalleryImages' class="form-control form-control-sm rounded bright">
                                                <option selected="selected" value="">
                                                    {{trans('enterprises_company_profile_edit.documents_public_sort')}}
                                                </option>
                                                <option value="galleryname">File Name </option>
                                                <option value="extension">Type</option>
                                                <option value="updated">Date</option>
                                            </select>
                                            <!-- <select class="form-control form-control-sm rounded bright">
                              <option selected="selected" value="">
                                {{--trans('enterprises_company_profile_edit.documents_public_sort')--}}
                              </option>
                              <option value="Pending">
                                Name
                              </option>
                              <option value="Active">
                                Type
                              </option>
                              <option value="Cancelled">
                                Date
                              </option>
                            </select> -->
                                            <!-- <select ng-model='filterByExt' class="form-control form-control-sm rounded bright">
                                                <option selected="selected" value="">
                                                    {{trans('enterprises_company_profile_edit.documents_public_select_filter_type')}}
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
                                            </select> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive table-responsive-heading-spce">
                                <form action="" method="POST">
                                    {{CSRF_FIELD()}}
                                    <table class="table table-lightborder" ng-controller="gallery">
                                        <thead>
                                            <tr>
                                                <th class="name">
                                                    {{trans('enterprises_company_profile_edit.documents_public_table_name')}}
                                                </th>
                                                <th class="type">
                                                    {{trans('enterprises_company_profile_edit.documents_public_table_type')}}
                                                </th>
                                                <th class="format">
                                                    {{trans('enterprises_company_profile_edit.documents_public_table_format')}}
                                                </th>
                                                <th class="date">
                                                    {{trans('enterprises_company_profile_edit.documents_public_table_date')}}
                                                </th>
                                                <th class="action">
                                                    {{trans('enterprises_company_profile_edit.documents_public_table_action')}}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="galleryimages_table">
                                            <tr ng-hide="!galleryimages.length" ng-repeat="gallery in galleryimages | filter:galleryimage_search | filter:filterByExt | orderBy: sortByGalleryImages">
                                                @verbatim
                                                <td><input class="form-control" type="checkbox" id="flat" value="{{ gallery.galleryid }}">{{
                                                    ::gallery.galleryname }}</td>
                                                <td>{{ ::gallery.type }}</td>
                                                <td>{{ ::gallery.extension }}</td>
                                                <td>{{ ::gallery.updated }}</td>
                                                @endverbatim
                                                <td>
                                                    <a href="/storage/company/gallery/images/@{{ gallery.gallerytitle }}"
                                                        target="_blank">
                                                        <i class="os-icon os-icon-signs-11"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr ng-hide="galleryimages.length > 0">
                                                <td colspan="5">{{trans('enterprises_company_profile_edit.gallery_images_not_found')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="element-box table-rit-section">
                            <h5 class="form-header">
                                {{trans('enterprises_company_profile_edit.company_profile_gallery_videos_lbl')}}
                            </h5>
                            <div class="form-desc">
                                {{trans('enterprises_company_profile_edit.company_profile_gallery_videos_content')}}
                            </div>
                            <div class="controls-above-table">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">

                                        <button class="btn btn-sm btn-primary" data-target="#galleryvideomdl"
                                            data-toggle="modal" type="button">{{trans('enterprises_company_profile_edit.upload_btn')}}</button>
                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="galleryvideomdl"
                                            role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{trans('enterprises_company_profile_edit.mdl_gallery_videos_title')}}
                                                        </h5>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true"> ×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('company.gallery_images.store')}}"
                                                            method="POST" enctype="multipart/form-data" class="dropzone"
                                                            id="uploadgalleryvideos">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="gallery" value="galleryvideos" />
                                                            <div class="dz-message">
                                                                <div>
                                                                    <h4>{{trans('enterprises_company_profile_edit.general_drag_and_drop')}}</h4>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-sm btn-danger" data-dismiss="modal" type="button">
                                                            {{trans('enterprises_company_profile_edit.close_btn')}}</button>
                                                        <button class="btn btn-sm btn-danger" type="button">Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--gallerythumbnail-->

                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="galleryvideothumbnail"
                                            role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">

                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{trans('enterprises_company_profile_edit.mdl_gallery_thumbnail_title')}}
                                                        </h5>
                                                        <button aria-label="Close" class="close" data-dismiss="modal"
                                                            type="button"><span aria-hidden="true"> ×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('company.gallery_thumbnail.store')}}"
                                                            method="POST" enctype="multipart/form-data" class="dropzone"
                                                            id="uploadgallerythumbnail">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="gallerythumbnail" value="gallerythumbnail" />
                                                            <input type="hidden" id="hiddengalleryvideo" name="hiddengalleryid"
                                                                value="" />
                                                            <div class="dz-message">
                                                                <div>
                                                                    <h4>{{trans('enterprises_company_profile_edit.general_drag_and_drop')}}</h4>
                                                                </div>
                                                            </div>

                                                        </form>

                                                    </div>
                                                    <label id="errolbl" style="margin-left:20px;"></label>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-sm btn-danger" data-dismiss="modal" type="button">

                                                            {{trans('enterprises_company_profile_edit.close_btn')}}</button>

                                                        <button class="btn btn-sm btn-danger" type="button">
                                                            {{trans('enterprises_company_profile_edit.upload_btn')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <!---->
                                        <!-- <a class="btn btn-sm btn-primary" href="#">Upload</a> -->
                                        {{-- <a class="btn btn-sm btn-danger" href="#">Delete</a> --}}
                                        <button class="btn btn-sm btn-danger" type="button" onclick="fnDeleteSelectedgallery('galleryvideos');">{{trans('enterprises_company_profile_edit.mdl_del_btn')}}</button>
                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="galleryvideos_delete_modal"
                                            role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            {{trans('enterprises_company_profile_edit.gallery_modal_title_delete')}}
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
                                                                            {{trans('enterprises_company_profile_edit.gallery_modal_video_delete_confirmation')}}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="alert alert-success" role="alert" id="del-message-box-private"
                                                        style="display:none;">
                                                        {{trans('enterprises_company_profile_edit.gallery_modal_video_deleted_message')}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-dismiss="modal" type="button"
                                                            id="mdel_close_private">{{trans('enterprises_company_profile_edit.general_modal_button_cancel_caption')}}</button>
                                                        <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedgallery('galleryvideos');"
                                                            id="btn_del_yes_private">{{trans('enterprises_company_profile_edit.general_modal_button_proceed_caption')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-8 filter-moble">
                                        <form class="form-inline justify-content-sm-end">
                                            <input ng-model='galleryvideo_search.galleryname' class="form-control form-control-sm rounded bright"
                                                placeholder="Search" type="text">
                                            <select ng-model='sortBygalleryvideo' class="form-control form-control-sm rounded bright">
                                                <option selected="selected" value="">
                                                    {{trans('enterprises_company_profile_edit.documents_private_sort')}}
                                                </option>
                                                <option value="galleryname">File Name </option>
                                                <option value="extension">Type</option>
                                                <option value="updated">Date</option>
                                            </select>
                                            <!-- <select ng-model='privateFilterByExt' class="form-control form-control-sm rounded bright">
                                                <option selected="selected" value="">
                                                    {{trans('enterprises_company_profile_edit.documents_public_select_filter_type')}}
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
                                            </select> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive table-responsive-heading-spce">
                                <table class="table table-lightborder" ng-controller="gallery">
                                    <thead>
                                        <tr>
                                            <th class="name">
                                                {{trans('enterprises_company_profile_edit.documents_private_table_name')}}
                                            </th>
                                            <th class="type">
                                                {{trans('enterprises_company_profile_edit.documents_private_table_type')}}
                                            </th>
                                            <th class="format">
                                                {{trans('enterprises_company_profile_edit.documents_private_table_format')}}
                                            </th>
                                            <th class="date">
                                                {{trans('enterprises_company_profile_edit.documents_private_table_date')}}
                                            </th>
                                            <th class="action">
                                                {{trans('enterprises_company_profile_edit.documents_private_table_action')}}
                                            </th>
                                            <th class="action">
                                                {{trans('enterprises_company_profile_edit.update_thumbnail')}}
                                            </th>
                                            <th class="action">
                                                Preview
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="galleryvideos_table">
                                        <tr ng-hide="!galleryvideos.length" ng-repeat="gallery in galleryvideos | filter:galleryvideo_search | filter:privateFilterByExt | orderBy: sortBygalleryvideo">
                                            <td><input class="form-control" type="checkbox" value="@{{ gallery.galleryid }}">@{{
                                                gallery.galleryname }}</td>
                                            <td>@{{ gallery.type }}</td>
                                            <td>@{{ gallery.extension }}</td>
                                            <td>@{{ gallery.updated }}</td>
                                            <td>
                                                <a href="/storage/company/gallery/videos/@{{ gallery.gallerytitle }}"
                                                    target="_blank">
                                                    <i class="os-icon os-icon-signs-11"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="javascript:void(0)" ng-click='updatethumbnailimage(gallery.galleryid);'>Update</a>
                                            </td>
                                            <td ng-hide="gallery.thumbnail.length =0">
                                                <img src="/storage/company/gallery/thumbnail/@{{ gallery.thumbnail }}"
                                                    style="max-width: 43%;">
                                            </td>
                                        </tr>
                                        <tr ng-hide="galleryvideos.length > 0">
                                            <td colspan="5">{{trans('enterprises_company_profile_edit.gallery_videos_not_found')}}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!--
                        END - documents table
                        -->
                </div>
                <!--
                END - right section content area
                -->
            </div>
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
            <!--
              END - Chat Popup Box
              -->
        </div>
    </div>
</div>

<!-- <script>
  var app = angular.module('myApp', []);
  app.controller('orderCtrl', function($scope) {
      $scope.customers = @{{ json_encode($data['documents']) }}
  });
</script> -->
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



    function fnDeleteGallery(mode) {
        debugger;
        var cnt = 0;
        if (mode == 'galleryimages') {
            $('#galleryimages_table input:checkbox:checked').each(function () {
                debugger;
                var id = $(this).attr('value');
                cnt = cnt + 1;
            });
        } else { //private case
            $('#galleryvideos_table input:checkbox:checked').each(function () {
                debugger;
                var id = $(this).attr('value');
                cnt = cnt + 1;
            });

        }

        if (cnt <= 0) {
            return;
        }

        if (cnt > 0) {
            if (mode == 'galleryimages') {
                $('#galleryimages_delete_modal').modal('show');
            } else //Private Case....
            {
                $('#galleryvideos_delete_modal').modal('show');
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
                url: '/delete-documents',
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



    function fnDeleteSelectedgallery(mode) {
        debugger;
        var documentlist = [];
        var cnt = 0;
        if (mode == 'galleryimages') {
            $('#galleryimages_table input:checkbox:checked').each(function () {
                var id = $(this).attr('value');
                documentlist.push({
                    documentid: id
                });
                cnt = cnt + 1;
            });
        } else { //private case
            $('#galleryvideos_table input:checkbox:checked').each(function () {
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

            formdata.append("gallerylist", JSON.stringify(documentlist));
            formdata.append("type", mode);
            formdata.append("_token", '{{csrf_token()}}');
            debugger;
            $.ajax({
                url: '/delete-gallery',
                type: "POST",
                contentType: false,
                processData: false,
                data: formdata,
                cache: false,
                timeout: 100000,
                success: function (data) {
                    if (mode == 'galleryimages') {
                        var $messageDiv = $('#del-gallery-message-box');
                        $messageDiv.show();
                        setTimeout(function () {
                            $messageDiv.hide();
                            $('#galleryimages_delete_modal').modal('hide');
                            window.location.reload(true);
                        }, 3000);
                    } else { //case of private...
                        var $messageDiv = $('#del-message-box-private');
                        $messageDiv.show();
                        setTimeout(function () {
                            $messageDiv.hide();
                            $('#pgalleryvideos_delete_modal').modal('hide');
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



    function fnDeleteGallery(mode) {
        debugger;
        var cnt = 0;
        if (mode == 'galleryimages') {
            $('#galleryimages_table input:checkbox:checked').each(function () {
                debugger;
                var id = $(this).attr('value');
                cnt = cnt + 1;
            });
        } else { //private case
            $('#galleryvideos_table input:checkbox:checked').each(function () {
                debugger;
                var id = $(this).attr('value');
                cnt = cnt + 1;
            });

        }

        if (cnt <= 0) {
            return;
        }

        if (cnt > 0) {
            if (mode == 'galleryimages') {
                $('#galleryimages_delete_modal').modal('show');
            } else //Private Case....
            {
                $('#galleryvideos_delete_modal').modal('show');
            }
        }
    }


    function fnDeleteSelectedgallery(mode) {
        debugger;
        var documentlist = [];
        var cnt = 0;
        if (mode == 'galleryimages') {
            $('#galleryimages_table input:checkbox:checked').each(function () {
                var id = $(this).attr('value');
                documentlist.push({
                    documentid: id
                });
                cnt = cnt + 1;
            });
        } else { //private case
            $('#galleryvideos_table input:checkbox:checked').each(function () {
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

            formdata.append("gallerylist", JSON.stringify(documentlist));
            formdata.append("type", mode);
            formdata.append("_token", '{{csrf_token()}}');
            debugger;
            $.ajax({
                url: '/delete-gallery',
                type: "POST",
                contentType: false,
                processData: false,
                data: formdata,
                cache: false,
                timeout: 100000,
                success: function (data) {
                    if (mode == 'galleryimages') {
                        var $messageDiv = $('#del-gallery-message-box');
                        $messageDiv.show();
                        setTimeout(function () {
                            $messageDiv.hide();
                            $('#galleryimages_delete_modal').modal('hide');
                            window.location.reload(true);
                        }, 3000);
                    } else { //case of private...
                        var $messageDiv = $('#del-message-box-private');
                        $messageDiv.show();
                        setTimeout(function () {
                            $messageDiv.hide();
                            $('#pgalleryvideos_delete_modal').modal('hide');
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


    $(".step-trigger-btn").on("click", function () {
        $(window).scrollTop($(".steps-w").offset().top);
    });

    function makeiframesingle(modal) {
        var src1 = $('#makeiframesingle').val();
        $('#makeiframedvsingle').html('<iframe width="100%" height="400" src="' + src1 +
            '" frameborder="0"></iframe>');

    }


    function closesingle() {
        $('#makeiframedvsingle').html('<iframe width="100%" height="400" src="" frameborder="0"></iframe>');
    }
</script>
@endsection