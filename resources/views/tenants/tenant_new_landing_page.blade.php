@php
$helper=\App\Helpers\AppHelper::instance();
@endphp
@extends('tenants.layouts.app_layout', ['layout' => 'left_side_menu_tenant'])
@section('content')

<div class="content-w investor-profil" ng-app="myApp">

    @include('tenants.shared._top_menu_tenant')
    <!--Bootstrap popup code-->

    <div aria-labelledby="myLargeModalLabel" id="new_modal" class="modal fade bd-example-modal-lg" role="dialog"
        tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">


                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{trans('tenant_new.popup_title')}}
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">
                            ×</span></button>
                </div>

                <div class="modal-body" id="popupnewform">

                </div>

                <div class="modal-footer" style="visibility: visible;">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                    <button class="btn btn-primary" type="button" onclick="fnSaveAllpopupitems();" id="btnMessageSave">
                        {{trans('duediligenceprocess.modulelist_modal_btnsave_caption')}}</button>
                </div>
                <div class="alert alert-success" role="alert" id="messagebox" style="display:none;">
                    <strong>Well done! </strong>Modeles are successfully updated.
                </div>
            </div>
        </div>
    </div>





    <!---->

    <div class="content-i">
        <div class="content-box">
            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('tenant_new.help_title')!!}
                    </h5>
                    <div class="form-desc">

                        {!!$helper->GetHelpModifiedText(trans('tenant_new.help_content'))!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('tenant_new.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-4">

                    <div class="element-wrapper">



                        <!--
          start - Logo Image
          -------------------->

                        @if(isset($tenant_landing_logo->logo) && !empty($tenant_landing_logo->logo) &&
                        File::exists(public_path('storage/tenant/logoimage/'.$tenant_landing_logo->logo)))
                        <div class="element-box">
                            <div class="row">
                                <div class="col-lg-12">


                                    <div class="rianta-img">
                                        @if(isset($tenant_landing_logo->logo) && !empty($tenant_landing_logo->logo))
                                        <img src="/storage/tenant/logoimage/{{$tenant_landing_logo->logo}}" class="img-responsive">
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endif


                        <div class="element-box">
                            <h5 class="form-header">
                                {{trans('tenant_new.logo_title')}}
                            </h5>
                            <div class="form-desc">
                                {{trans('tenant_new.logo_description')}}
                            </div>
                            <form action="{{ route('tenant.logo.image.store') }}" method="POST" enctype="multipart/form-data"
                                class="dropzone" id="profile_image">
                                {{ csrf_field() }}
                                <input type="hidden" name="profile_image" value="profile_image">
                                <div class="dz-message">
                                    <div>
                                        <h4>{{trans('tenant_new.logo_drag_and_drop')}}</h4>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--------------------
          END - Logo Image
          -------------------->
                        <!--------------------
               start - right section video
              -------------------->





                        <!--------------------
                  END - right section video
                  -------------------->
                        <!--
                  START - Video Upload
                -->

                        <!--
                     END - Video Upload
                     -->

                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-8">
                    <div class="element-wrapper">

                        <h6 class="element-header">
                            {{trans('adminview.landing_page_title')}}
                        </h6>
                        <div class="element-box">

                            <form id="formValidate" method="POST" action="{{ route('tenant.profile.update') }}">
                                {{ csrf_field() }}
                                <div class="steps-w">
                                    <!--                        <div class="step-triggers">
                          <a class="step-trigger active" href="#stepContent1">
                          
                          </a>
                          <a class="step-trigger" href="#stepContent2">
                         
                          </a>
                        </div>-->
                                    <div class="step-contents">
                                        <div class="step-content active" id="stepContent1">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('tenant_new.telephone_title')}}
                                                        </label>
                                                        <input class="form-control" data-error="Please input your Telephone"
                                                            placeholder="Telephone" required="required" data-minlength="12"
                                                            type="text" name="telephone" value="<?php if(isset($tenant_landing_logo->telephone)&&!empty($tenant_landing_logo->telephone)){echo $tenant_landing_logo->telephone;}?>">
                                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('tenant_new.facebook_title')}}
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    @
                                                                </div>
                                                            </div>
                                                            <input class="form-control" placeholder="{{trans('tenant_new.facebook_placehold')}}"
                                                                type="text" name="facebook" value="<?php if(isset($tenant_landing_logo->facebook)&&!empty($tenant_landing_logo->facebook)){echo $tenant_landing_logo->facebook;}?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('tenant_new.linkedin_title')}}
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    @
                                                                </div>
                                                            </div>
                                                            <input class="form-control" placeholder="{{trans('tenant_new.linkedin_placehold')}}"
                                                                type="text" name="linkedin" value="{{(isset($tenant_landing_logo->linkedin)&&!empty($tenant_landing_logo->linkedin))?$tenant_landing_logo->linkedin:''}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('tenant_new.twitter_title')}}
                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    @
                                                                </div>
                                                            </div>
                                                            <input class="form-control" placeholder="{{trans('tenant_new.twitter_placehold')}}"
                                                                type="text" name="twitter" value="{{isset($tenant_landing_logo->twitter)&&!empty($tenant_landing_logo->twitter)?$tenant_landing_logo->twitter:''}}">
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>






                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">

                                                <!--<a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Next</a>-->
                                            </div>
                                        </div>
                                        <div class="step-content" id="stepContent2">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" placeholder="Years In Impact Investing"
                                                            type="text" name="yearsinvolved" value="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" placeholder="No of Investments to Date"
                                                            type="text" name="numbertodate" value="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="currency" onchange="currencychange(this.value);">





                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">

                                                                </div>
                                                            </div>
                                                            <select class="form-control" name="preferedinvestmentaveragesize">
                                                                <option value="" disabled selected>Select</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">

                                                                </div>
                                                            </div>
                                                            <select class="form-control" name="fundsundermanagement">
                                                                <option value="" disabled selected>Select</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="levelofinvolvement">
                                                            <option value="" disabled selected>Select</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" name="numberofemployees"
                                                            placeholder="No of Employees" type="text" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="isonbehalfofinstitution">
                                                            <option value="" disabled selected>Select</option>


                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" name="taxidnumber" placeholder="Tax Id Number"
                                                            type="text" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ful-wdth-select">
                                                <label for="">

                                                </label>
                                                <select class="form-control select2" name="specializedsectors[]"
                                                    multiple="true">

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>

                                                </label>
                                                <textarea class="form-control" name="mission" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>

                                                </label>
                                                <textarea class="form-control" name="outcomes" rows="3"></textarea>
                                            </div>
                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                                                <a class="btn btn-primary step-trigger-btn" href="#stepContent1">
                                                    Previous</a>
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
                            {{trans('tenant_new.slide_header')}}
                            <button class="btn btn-sm btn-primary" data-target="#new_modal" data-toggle="modal" onclick="fetchform('slide')"
                                type="button" style='float:right;'>{{trans('tenant_new.new_slides_btn')}}</button>
                        </h5>
                        <div class="element-box table-rit-section" id="slidetable">
                            {{-- <h5 class="form-header">
                                {{trans('tenant_new.landing_page_slide_header')}}
                            </h5>
                            <div class="form-desc"> </div> --}}
                            <div class="controls-above-table">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">



                                    </div>

                                    <div class="col-sm-12 col-lg-8 filter-moble">
                                        <form class="form-inline justify-content-sm-end ng-pristine ng-valid">


                                            <input class="form-control form-control-sm rounded bright ng-pristine ng-valid ng-empty ng-touched"
                                                placeholder="Search" type="text" id="searchslide">
                                            <select class="form-control form-control-sm rounded bright ng-pristine ng-untouched ng-valid ng-empty"
                                                onchange="filterslide(this.value);">
                                                <option value="" selected="selected">
                                                    Sort By
                                                </option>
                                                <option value="title">Title</option>
                                                <option value="description">Description</option>
                                                <option value="button_text">button Text</option>
                                            </select>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive table-responsive-heading-spce" style="height: 300px;overflow: auto;">
                                <table class="table table-padded">
                                    <thead>
                                        <tr>
                                            <th class="name">
                                                Title
                                            </th>
                                            <th class="name">
                                                Button Text
                                            </th>
                                            <th class="name">
                                                Button Link
                                            </th>
                                            <th class="image">
                                                Image
                                            </th>
                                            <th class="action text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id='slides_block'>





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
                            {{trans('tenant_new.landing_page_block_header')}}
                            <!--                      <button class="btn btn-sm btn-primary" data-target="#new_modal" data-toggle="modal" type="button" style='float:right;' onclick='fetchform("block_header");'>{{trans('tenant_new.new_landing_block_btn')}}</button>
                   -->
                        </h5>

                        <div class="element-box">

                            <form id="formValidate" method="POST" action="{{ route('tenant.blockheading.update') }}">
                                {{ csrf_field() }}
                                <div class="steps-w">
                                    <!--                        <div class="step-triggers">
                          <a class="step-trigger active" href="#stepContent1">
                          
                          </a>
                          <a class="step-trigger" href="#stepContent2">
                         
                          </a>
                        </div>-->
                                    <div class="step-contents">
                                        <div class="step-content active" id="stepContent1">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{trans('tenant_new.block_section_heading_title')}}
                                                        </label>
                                                        {{-- <textarea class="form-control" placeholder="{{trans('tenant_new.first_heading_placehold')}}"
                                                            type="text" name="heading1" rows="4" cols="50">{{isset($tenant_landing_logo->block_section_heading)&&!empty($tenant_landing_logo->block_section_heading)?$tenant_landing_logo->block_section_heading:''}}</textarea>
                                                        --}}
                                                        <input type='text' class="form-control" placeholder="{{trans('tenant_new.first_heading_placehold')}}"
                                                            type="text" name="block_section_heading" value="{{isset($tenant_landing_logo->block_section_heading)&&!empty($tenant_landing_logo->block_section_heading)?$tenant_landing_logo->block_section_heading:''}}">
                                                    </div>
                                                </div>
                                            </div>








                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">

                                                <!--<a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Next</a>-->
                                            </div>
                                        </div>
                                        <div class="step-content" id="stepContent2">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" placeholder="Years In Impact Investing"
                                                            type="text" name="yearsinvolved" value="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" placeholder="No of Investments to Date"
                                                            type="text" name="numbertodate" value="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="currency" onchange="currencychange(this.value);">





                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">

                                                                </div>
                                                            </div>
                                                            <select class="form-control" name="preferedinvestmentaveragesize">
                                                                <option value="" disabled selected>Select</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">

                                                                </div>
                                                            </div>
                                                            <select class="form-control" name="fundsundermanagement">
                                                                <option value="" disabled selected>Select</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="levelofinvolvement">
                                                            <option value="" disabled selected>Select</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" name="numberofemployees"
                                                            placeholder="No of Employees" type="text" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="isonbehalfofinstitution">
                                                            <option value="" disabled selected>Select</option>


                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" name="taxidnumber" placeholder="Tax Id Number"
                                                            type="text" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ful-wdth-select">
                                                <label for="">

                                                </label>
                                                <select class="form-control select2" name="specializedsectors[]"
                                                    multiple="true">

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>

                                                </label>
                                                <textarea class="form-control" name="mission" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>

                                                </label>
                                                <textarea class="form-control" name="outcomes" rows="3"></textarea>
                                            </div>
                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                                                <a class="btn btn-primary step-trigger-btn" href="#stepContent1">
                                                    Previous</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>






                        <div class="element-box table-rit-section">
                            <div class="controls-above-table">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">

                                        <button class="btn btn-sm btn-primary" data-target="#new_modal" data-toggle="modal"
                                            type="button" onclick='fetchform("block_header");'>{{trans('tenant_new.new_landing_block_btn')}}</button>

                                    </div>
                                    <div class="col-sm-12 col-lg-8 filter-moble">
                                        <form class="form-inline justify-content-sm-end ng-pristine ng-valid">


                                            <input class="form-control form-control-sm rounded bright ng-pristine ng-valid ng-empty ng-touched"
                                                placeholder="Search" type="text" id="searchblockheader">
                                            <select class="form-control form-control-sm rounded bright ng-pristine ng-untouched ng-valid ng-empty"
                                                id="sortblockheader" onchange="getsortheader(this.value);">
                                                <option value="" selected="selected">
                                                    Sort By
                                                </option>
                                                <option value="title">Title </option>
                                                <option value="description">Description</option>
                                                <option value="link">Link</option>
                                            </select>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive table-responsive-heading-spce" style="height: 300px;overflow: auto;">
                                <table class="table table-padded">
                                    <thead>
                                        <tr>
                                            <th class="name">
                                                Title
                                            </th>
                                            <th class="name">
                                                Link
                                            </th>
                                            <th class="name">
                                                Image
                                            </th>
                                            <th class="action text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id='landing-page_block'>

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
                            About Us

                        </h5>

                        <div class="element-box">

                            <form id="formValidate" method="POST" action="{{ route('tenant.aboutus.update') }}">
                                {{ csrf_field() }}
                                <div class="steps-w">
                                    <!--                        <div class="step-triggers">
                          <a class="step-trigger active" href="#stepContent1">
                          
                          </a>
                          <a class="step-trigger" href="#stepContent2">
                         
                          </a>
                        </div>-->
                                    <div class="step-contents">
                                        <div class="step-content active" id="stepContent1">



                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">
                                                            Section Heading
                                                        </label>
                                                        <input type='text' class="form-control" placeholder="Section Heading"
                                                            type="text" name="section_heading" value="{{isset($tenant_landing_logo->section_heading)&&!empty($tenant_landing_logo->section_heading)?$tenant_landing_logo->section_heading:''}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">
                                                            Section Text
                                                        </label>
                                                        <textarea class="form-control" placeholder="Section Text" type="text"
                                                            name="ckeditor1" rows="4" cols="50" id="ckeditorEmail">{{isset($tenant_landing_logo->section_text)&&!empty($tenant_landing_logo->section_text)?$tenant_landing_logo->section_text:''}}</textarea>
                                                        {{-- <input type='text' class="form-control" placeholder="{{trans('tenant_new.btn_text_1')}}"
                                                            type="text" name="btn_text_1" value="{{isset($tenant_landing_logo->text)&&!empty($tenant_landing_logo->text)?$tenant_landing_logo->text:''}}">
                                                        --}}
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            Section Button Text
                                                        </label>
                                                        <input type='text' class="form-control" placeholder="{{trans('tenant_new.btn_text_2')}}"
                                                            type="text" name="section_button_text" value="{{isset($tenant_landing_logo->section_button_text)&&!empty($tenant_landing_logo->section_button_text)?$tenant_landing_logo->section_button_text:''}}">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">
                                                            Section Button Link
                                                        </label>
                                                        <input type='text' class="form-control" placeholder="{{trans('tenant_new.first_heading_link_placehold')}}"
                                                            type="text" name="section_button_link" value="{{isset($tenant_landing_logo->section_button_link)&&!empty($tenant_landing_logo->section_button_link)?$tenant_landing_logo->section_button_link:''}}">
                                                    </div>
                                                </div>


                                            </div>








                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">

                                                <!--<a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Next</a>-->
                                            </div>
                                        </div>
                                        <div class="step-content" id="stepContent2">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" placeholder="Years In Impact Investing"
                                                            type="text" name="yearsinvolved" value="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" placeholder="No of Investments to Date"
                                                            type="text" name="numbertodate" value="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="currency" onchange="currencychange(this.value);">





                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">

                                                                </div>
                                                            </div>
                                                            <select class="form-control" name="preferedinvestmentaveragesize">
                                                                <option value="" disabled selected>Select</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">

                                                                </div>
                                                            </div>
                                                            <select class="form-control" name="fundsundermanagement">
                                                                <option value="" disabled selected>Select</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="levelofinvolvement">
                                                            <option value="" disabled selected>Select</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" name="numberofemployees"
                                                            placeholder="No of Employees" type="text" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="isonbehalfofinstitution">
                                                            <option value="" disabled selected>Select</option>


                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" name="taxidnumber" placeholder="Tax Id Number"
                                                            type="text" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ful-wdth-select">
                                                <label for="">

                                                </label>
                                                <select class="form-control select2" name="specializedsectors[]"
                                                    multiple="true">

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>

                                                </label>
                                                <textarea class="form-control" name="mission" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>

                                                </label>
                                                <textarea class="form-control" name="outcomes" rows="3"></textarea>
                                            </div>
                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                                                <a class="btn btn-primary step-trigger-btn" href="#stepContent1">
                                                    Previous</a>
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
                            {{trans('tenant_new.testimonial_header')}}
                            <!--                      <button class="btn btn-sm btn-primary" data-target="#new_modal" data-toggle="modal" type="button" onclick="fetchform('testimonial')" style='float:right;'>{{trans('tenant_new.testimonial_btn')}}</button>
                    -->
                        </h5>




                        <div class="element-box">

                            <form id="formValidate" method="POST" action="{{ route('tenant.testimonial.update') }}">
                                {{ csrf_field() }}
                                <div class="steps-w">
                                    <!--                        <div class="step-triggers">
                          <a class="step-trigger active" href="#stepContent1">
                          
                          </a>
                          <a class="step-trigger" href="#stepContent2">
                         
                          </a>
                        </div>-->
                                    <div class="step-contents">
                                        <div class="step-content active" id="stepContent1">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">
                                                            Testimonial Title
                                                        </label>
                                                        {{-- <textarea class="form-control" placeholder="{{trans('tenant_new.first_heading_placehold')}}"
                                                            type="text" name="heading1" rows="4" cols="50">{{isset($tenant_landing_logo->block_section_heading)&&!empty($tenant_landing_logo->block_section_heading)?$tenant_landing_logo->block_section_heading:''}}</textarea>
                                                        --}}
                                                        <input type='text' class="form-control" placeholder="testimonial"
                                                            type="text" name="testimonial" value="{{isset($tenant_landing_logo->testimonial)&&!empty($tenant_landing_logo->testimonial)?$tenant_landing_logo->testimonial:''}}">
                                                    </div>
                                                </div>
                                            </div>








                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">

                                                <!--<a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Next</a>-->
                                            </div>
                                        </div>
                                        <div class="step-content" id="stepContent2">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" placeholder="Years In Impact Investing"
                                                            type="text" name="yearsinvolved" value="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" placeholder="No of Investments to Date"
                                                            type="text" name="numbertodate" value="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="currency" onchange="currencychange(this.value);">





                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">

                                                                </div>
                                                            </div>
                                                            <select class="form-control" name="preferedinvestmentaveragesize">
                                                                <option value="" disabled selected>Select</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">

                                                                </div>
                                                            </div>
                                                            <select class="form-control" name="fundsundermanagement">
                                                                <option value="" disabled selected>Select</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="levelofinvolvement">
                                                            <option value="" disabled selected>Select</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" name="numberofemployees"
                                                            placeholder="No of Employees" type="text" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="isonbehalfofinstitution">
                                                            <option value="" disabled selected>Select</option>


                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" name="taxidnumber" placeholder="Tax Id Number"
                                                            type="text" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ful-wdth-select">
                                                <label for="">

                                                </label>
                                                <select class="form-control select2" name="specializedsectors[]"
                                                    multiple="true">

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>

                                                </label>
                                                <textarea class="form-control" name="mission" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>

                                                </label>
                                                <textarea class="form-control" name="outcomes" rows="3"></textarea>
                                            </div>
                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                                                <a class="btn btn-primary step-trigger-btn" href="#stepContent1">
                                                    Previous</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>




                        <div class="element-box table-rit-section">
                            {{-- <h5 class="form-header">
                                {{trans('tenant_new.testimonial_title')}}
                            </h5>
                            <div class="form-desc"> </div> --}}
                            <div class="controls-above-table">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">

                                        <button class="btn btn-sm btn-primary" data-target="#new_modal" data-toggle="modal"
                                            type="button" onclick="fetchform('testimonial')">{{trans('tenant_new.testimonial_btn')}}</button>

                                    </div>
                                    <div class="col-sm-12 col-lg-8 filter-moble">
                                        <form class="form-inline justify-content-sm-end ng-pristine ng-valid">


                                            <input class="form-control form-control-sm rounded bright ng-pristine ng-valid ng-empty ng-touched"
                                                placeholder="Search" type="text" id="testimonialsearch">
                                            <select class="form-control form-control-sm rounded bright ng-pristine ng-untouched ng-valid ng-empty"
                                                onchange="testimonialfilter(this.value);">
                                                <option value="" selected="selected">
                                                    Sort By
                                                </option>
                                                <option value="name">Name</option>
                                                <option value="companyandrank">Company & Rank</option>
                                                <option value="description_text">Description</option>
                                            </select>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive table-responsive-heading-spce" style="height: 300px;overflow: auto;">
                                <table class="table table-padded">
                                    <thead>
                                        <tr>
                                            <th class="name">
                                                Name
                                            </th>
                                            <th class="name">
                                                Company And Rank
                                            </th>
                                            <th class="image">
                                                Image
                                            </th>
                                            <th class="action text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id='testimonial_block'>





                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>



                    <div class="element-wrapper margin-top">
                        <!--
                    START - documents table 
                    -->
                        <h5 class="element-header">
                            {{trans('tenant_new.landing_page_faqs_header')}}
                            <!--                      <button class="btn btn-sm btn-primary" data-target="#new_modal" data-toggle="modal" type="button" style='float:right;' onclick='fetchform("faq");'>{{trans('tenant_new.new_faq_btn')}}</button>
                    -->
                        </h5>


                        <div class="element-box">

                            <form id="formValidate" method="POST" action="{{ route('tenant.faq.update') }}">
                                {{ csrf_field() }}
                                <div class="steps-w">
                                    <!--                        <div class="step-triggers">
                          <a class="step-trigger active" href="#stepContent1">
                          
                          </a>
                          <a class="step-trigger" href="#stepContent2">
                         
                          </a>
                        </div>-->
                                    <div class="step-contents">
                                        <div class="step-content active" id="stepContent1">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">
                                                            Faq Title
                                                        </label>
                                                        {{-- <textarea class="form-control" placeholder="Faq Title"
                                                            type="text" name="heading1" rows="4" cols="50">{{isset($tenant_landing_logo->block_section_heading)&&!empty($tenant_landing_logo->block_section_heading)?$tenant_landing_logo->block_section_heading:''}}</textarea>
                                                        --}}
                                                        <input type='text' class="form-control" placeholder="Faq Title"
                                                            type="text" name="faq" value="{{isset($tenant_landing_logo->faq)&&!empty($tenant_landing_logo->faq)?$tenant_landing_logo->faq:''}}">
                                                    </div>
                                                </div>
                                            </div>








                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">

                                                <!--<a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Next</a>-->
                                            </div>
                                        </div>
                                        <div class="step-content" id="stepContent2">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" placeholder="Years In Impact Investing"
                                                            type="text" name="yearsinvolved" value="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" placeholder="No of Investments to Date"
                                                            type="text" name="numbertodate" value="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="currency" onchange="currencychange(this.value);">





                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">

                                                                </div>
                                                            </div>
                                                            <select class="form-control" name="preferedinvestmentaveragesize">
                                                                <option value="" disabled selected>Select</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text currency-symb">

                                                                </div>
                                                            </div>
                                                            <select class="form-control" name="fundsundermanagement">
                                                                <option value="" disabled selected>Select</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="levelofinvolvement">
                                                            <option value="" disabled selected>Select</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" name="numberofemployees"
                                                            placeholder="No of Employees" type="text" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <select class="form-control" name="isonbehalfofinstitution">
                                                            <option value="" disabled selected>Select</option>


                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">

                                                        </label>
                                                        <input class="form-control" name="taxidnumber" placeholder="Tax Id Number"
                                                            type="text" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ful-wdth-select">
                                                <label for="">

                                                </label>
                                                <select class="form-control select2" name="specializedsectors[]"
                                                    multiple="true">

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>

                                                </label>
                                                <textarea class="form-control" name="mission" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>

                                                </label>
                                                <textarea class="form-control" name="outcomes" rows="3"></textarea>
                                            </div>
                                            <div class="form-buttons-w text-right">
                                                <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                                                <a class="btn btn-primary step-trigger-btn" href="#stepContent1">
                                                    Previous</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="element-box table-rit-section">
                            {{-- <h5 class="form-header">
                                {{trans('tenant_new.landing_page_faqs_title')}}
                            </h5> --}}
                            {{-- <div class="form-desc"> </div> --}}
                            <div class="controls-above-table">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">

                                        <button class="btn btn-sm btn-primary" data-target="#new_modal" data-toggle="modal"
                                            type="button" onclick='fetchform("faq");'>{{trans('tenant_new.new_faq_btn')}}</button>

                                    </div>
                                    <div class="col-sm-12 col-lg-8 filter-moble">
                                        <form class="form-inline justify-content-sm-end ng-pristine ng-valid">


                                            <input class="form-control form-control-sm rounded bright ng-pristine ng-valid ng-empty ng-touched"
                                                placeholder="Search" type="text" id="searchfaq">
                                            <select class="form-control form-control-sm rounded bright ng-pristine ng-untouched ng-valid ng-empty"
                                                onchange="filterfaq(this.value);">
                                                <option value="" selected="selected">
                                                    Sort By
                                                </option>
                                                <option value="question">Question </option>
                                                <option value="answer">Answer</option>

                                            </select>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive table-responsive-heading-spce" style="height: 300px;overflow: auto;">
                                <table class="table table-padded">
                                    <thead>
                                        <tr>
                                            <th class="name">
                                                Question
                                            </th>
                                            <th class="name">
                                                Answer
                                            </th>

                                            <th class="action text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id='faq_block'>

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







<input type='hidden' id='tenantidval' value="{{session('tenantid')}}">
<input type='hidden' id='landingpage' value="">
<input type='hidden' id='getview' value="">

@endsection

@section('scripts')
<script>
    $(document).ready(function () {

        var landingpageblock = '/landing_page_block_header?tenantid=';
        var getview = $('#landing-page_block');
        commonfunc(landingpageblock, getview);


        var landingpageblock = '/landing_page_faq?tenantid=';
        var getview = $('#faq_block');
        commonfunc(landingpageblock, getview);

        var landingpageblock = '/landing_page_slides?tenantid=';
        var getview = $('#slides_block');
        commonfunc(landingpageblock, getview);

        var landingpageblock = '/landing_page_testimonial?tenantid=';
        var getview = $('#testimonial_block');
        commonfunc(landingpageblock, getview);




    });

    var search = "";
    var count = 0;
    var getsortheadervar = "";


    function getsortheader(filter) {

        var searching = "blockheader";
        var search = $('#searchblockheader').val();
        var getsortheadervar = filter;
        var getview = $('#landing-page_block');

        getsearchfromdb(search, searching, getview, getsortheadervar);
    }

    $('#searchblockheader').keyup(function () {
        searching = "blockheader";
        search = $('#searchblockheader').val();

        var getview = $('#landing-page_block');

        setTimeout(function () {
            if (count == 0) {
                getsearchfromdb(search, searching, getview, getsortheadervar);
            }
            count++;
        }, 2000);
        count = 0;
    });



    function filterfaq(filter) {

        var searching = "faq";
        var search = $('#searchfaq').val();
        var getsortheadervar = filter;
        var getview = $('#faq_block');

        getsearchfromdb(search, searching, getview, getsortheadervar);
    }

    $('#searchfaq').keyup(function () {
        searching = "faq";
        search = $('#searchfaq').val();

        var getview = $('#faq_block');

        setTimeout(function () {
            if (count == 0) {
                getsearchfromdb(search, searching, getview, getsortheadervar);
            }
            count++;
        }, 2000);
        count = 0;
    });



    function filterslide(filter) {

        var searching = "slide";
        var search = $('#searchslide').val();
        var getsortheadervar = filter;
        var getview = $('#slides_block');

        getsearchfromdb(search, searching, getview, getsortheadervar);
    }

    $('#searchslide').keyup(function () {
        searching = "slide";
        search = $('#searchslide').val();

        var getview = $('#slides_block');

        setTimeout(function () {
            if (count == 0) {
                getsearchfromdb(search, searching, getview, getsortheadervar);
            }
            count++;
        }, 2000);
        count = 0;
    });


    function testimonialfilter(filter) {

        var searching = "testimonial";
        var search = $('#testimonialsearch').val();
        var getsortheadervar = filter;
        var getview = $('#testimonial_block');
        debugger;
        getsearchfromdb(search, searching, getview, getsortheadervar);
    }

    $('#testimonialsearch').keyup(function () {
        searching = "testimonial";
        search = $('#testimonialsearch').val();

        var getview = $('#testimonial_block');

        setTimeout(function () {
            if (count == 0) {
                getsearchfromdb(search, searching, getview, getsortheadervar);
            }
            count++;
        }, 2000);
        count = 0;
    });




    function getsearchfromdb(search, searching, getview, getsortheadervar) {
        debugger;
        var tenantid = $('#tenantidval').val();
        $.get('/tenantcommonsearch?tenantid=' + tenantid + '&search=' + search + '&searching=' + searching + '&sort=' +
            getsortheadervar,
            function (data) {
                getview.html(data.view);
            });
    }

    function fetchform(filter) {
        $('#exampleModalLabel').html('Add New');
        $('#btnMessageSave').text("Save");
        if (filter == "block_header") {

            var landingpageblock = '/landing_page_block_header?tenantid=';
            //var getview=$('#landing-page_block');

            $('#landingpage').val(landingpageblock);
            $('#getview').val('block');

            function explode() {

                $('.modal-footer').html(
                    '<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">Cancel</button><button class="btn btn-primary" type="button" onclick="fnSaveAllpopupitems();" id="btnMessageSave"> Save</button></div>'
                );
                if ($('.modal-footer').css("visibility") == "hidden") {

                    $('.modal-footer').html(
                        '<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">Cancel</button><button class="btn btn-primary" type="button" onclick="fnSaveAllpopupitems();" id="btnMessageSave"> Save</button></div>'
                    );
                    $('.modal-footer').css("visibility", "visible");
                }
            }
            setTimeout(explode, 1000);


        }
        if (filter == "faq") {
            var landingpageblock = '/landing_page_faq?tenantid=';
            //var landingpageblock='/faq_block?tenantid=';         
            $('#landingpage').val(landingpageblock);
            $('#getview').val('faq');

            function explode() {
                $('.modal-footer').html(
                    '<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">Cancel</button><button class="btn btn-primary" type="button" onclick="fnSaveAllpopupitems();" id="btnMessageSave"> Save</button></div>'
                );
                if ($('.modal-footer').css("visibility") == "hidden") {

                    //$('.modal-content').append('<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">Cancel</button><button class="btn btn-primary" type="button" onclick="fnSaveAllpopupitems();" id="btnMessageSave"> Save</button></div>');

                    $('.modal-footer').html(
                        '<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">Cancel</button><button class="btn btn-primary" type="button" onclick="fnSaveAllpopupitems();" id="btnMessageSave"> Save</button></div>'
                    );
                    $('.modal-footer').css("visibility", "visible");
                }
            }
            setTimeout(explode, 1000);

        }

        if (filter == "slide") {
            var landingpageblock = '/landing_page_slides?tenantid=';
            $('#landingpage').val(landingpageblock);
            $('#getview').val('slide');
            //$('#btnMessageSave').remove();
            $('.modal-footer').css('visibility', 'hidden');
            //$('.modal-footer').append('<button class="btn btn-primary" type="submit" onclick="fnsaveimagealso();" id="btnMessageSave1"> Save</button>');
        }

        if (filter == "testimonial") {
            var landingpageblock = '/landing_page_testimonial?tenantid=';
            //var getview=$('#testimonial_block');

            $('#landingpage').val(landingpageblock);
            $('#getview').val('testimonial');
            $('.modal-footer').css('visibility', 'hidden');
            //$('.modal-footer').append('<button class="btn btn-primary" type="submit" onclick="fnsaveimagealso();" id="btnMessageSave1"> Save</button>');
        }


        commonform(filter)
    }

    function commonform(filter) {

        $.get('/commonform?filter=' + filter, function (data) {
            $('#popupnewform').html();
            $('#popupnewform').html(data.view);
        });
    }



    function fnSaveAllpopupitems() {

        var landingpageblock = $('#landingpage').val();

        var getview = $('#getview').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //var serialize=$('#formValidate').serialize();

        var formdata = new FormData();

        var other_data = $('#formValidate').serializeArray();

        if ($('#formtype').val() == "blockform") {
            var importFiles = $('#fileToUpload').prop('files')[0];
        }

        $.each(other_data, function (key, input) {
            formdata.append(input.name, input.value);
        });
        formdata.append("_token", '{{csrf_token()}}');
        formdata.append('getview', getview);
        if ($('#formtype').val() == "blockform") {
            formdata.append('uploadFiles', importFiles);
        }

        $.ajax({
            url: '/savenewpopupform',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {

                // var $messageDiv = $('#messagebox'); // get the reference of the div
                // $messageDiv.show().html('Selected modules deleted successfully.'); // show and set the message.html(data.Message)
                // setTimeout(function () { $messageDiv.hide(); }, 10000); // 3 seconds later, hide
                //fnGotoPageModules(1);
                $('#new_modal').modal('hide');
                getview = $('#getview').val();
                if (getview == 'block') {
                    var getview1 = $('#landing-page_block');
                }

                if (getview == 'faq') {
                    getview1 = $('#faq_block');
                }
                commonfunc(landingpageblock, getview1);

            },
            error: function (err, result) {

                alert("Error" + err.responseText);
            }
        });
    }


    function deletelandingpageblock(delid) {
        $('#getview').val('block');
        var deletepage = '/deletetenantlayout?delid=' + delid + '&type=block';
        deletefunc(deletepage, delid);

    }

    function deleteslide(deleteid) {
        $('#getview').val('slide');
        deletepage = '/deletetenantlayout?delid=' + deleteid + '&type=slide';
        deletefunc(deletepage, deleteid);
    }

    function deletefaq(deleteid) {
        $('#getview').val('faq');
        deletepage = '/deletetenantlayout?delid=' + deleteid + '&type=faq';
        deletefunc(deletepage, deleteid);
    }

    function deletetestimonial(deleteid) {
        $('#getview').val('testimonial');
        deletepage = '/deletetenantlayout?delid=' + deleteid + '&type=testimonial';
        deletefunc(deletepage, deleteid);
    }


    function deletefunc(deletepage) {
        debugger;
        $.get(deletepage, function (data) {
            var getview = $('#getview').val();
            if (getview == "block") {
                var landingpageblock = '/landing_page_block_header?tenantid=';
                getview = $('#landing-page_block');
                commonfunc(landingpageblock, getview);
            }
            if (getview == "faq") {
                landingpageblock = '/landing_page_faq?tenantid=';
                getview = $('#faq_block');
                commonfunc(landingpageblock, getview);
            }

            if (getview == "slide") {
                landingpageblock = '/landing_page_slides?tenantid=';
                getview = $('#slides_block');
                commonfunc(landingpageblock, getview);
            }
            if (getview == "testimonial") {
                landingpageblock = '/landing_page_testimonial?tenantid=';
                getview = $('#testimonial_block');
                commonfunc(landingpageblock, getview);
            }

        });
    }


    function editlandingpageblock(editid) {

        if ($('.modal-footer').css("visibility") == "hidden") {
            $('.modal-footer').css('visibility', 'visible');
            $('.modal-footer').html(
                '<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">Cancel</button><button class="btn btn-primary" type="button" onclick="fnSaveAllpopupitems();" id="btnMessageSave"> Save</button></div>'
            );
        }
        $("#exampleModalLabel").text('Update');
        $("#btnMessageSave").val('Update');
        $("#btnMessageSave").text('Update');
        $("#btnMessageSave").attr("onclick", "updateblock('" + editid + "')");
        $('#new_modal').modal('show');

        fetchupdateform("block_header", editid);
    }

    function editfaq(editid) {
        if ($('.modal-footer').css("visibility") == "hidden") {
            $('.modal-footer').css('visibility', 'visible');
            $('.modal-footer').html(
                '<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">Cancel</button><button class="btn btn-primary" type="button" onclick="fnSaveAllpopupitems();" id="btnMessageSave"> Save</button></div>'
            );
        }
        $("#exampleModalLabel").text('Update');
        $("#btnMessageSave").val('Update');
        $("#btnMessageSave").text('Update');
        $("#btnMessageSave").attr("onclick", "updateblock('" + editid + "')");
        $('#new_modal').modal('show');
        fetchupdateform("faq", editid);
    }

    function editslide(editid) {
        $('.modal-footer').css('visibility', 'visible');
        $("#exampleModalLabel").text('Update');
        $("#btnMessageSave").val('Update');
        $("#btnMessageSave").text('Update');
        $("#btnMessageSave").attr("onclick", "updateblock('" + editid + "')");
        //$('#new_modal').modal('show');
        function explode() {


            //  $('#updatehide').css('visibility','hidden');
            $('.modal-footer').css('visibility', 'hidden');
            $('#new_modal').modal('show');
        }
        if ($('input.btn.btn-primary').length > 1) {
            setTimeout(explode, 1500);
        }

        fetchupdateform("slide", editid);

    }

    function edittestimonial(editid) {
        $('.modal-footer').css('visibility', 'visible');
        $("#exampleModalLabel").text('Update');
        $("#btnMessageSave").val('Update');
        $("#btnMessageSave").text('Update');
        $("#btnMessageSave").attr("onclick", "updateblock('" + editid + "')");
        //$('#new_modal').modal('show');

        function explode() {


            //$('#updatehide').css('visibility','hidden');
            $('.modal-footer').css('visibility', 'hidden');
            $('#new_modal').modal('show');


        }
        if ($('input.btn.btn-primary').length > 1) {

            setTimeout(explode, 1500);
        }


        fetchupdateform("testimonial", editid);
    }




    function fetchupdateform(filter, updateid) {

        if (filter == "block_header") {





            var landingpageblock = '/landing_page_block_header?tenantid=';
            //var getview=$('#landing-page_block');

            $('#landingpage').val(landingpageblock);
            $('#getview').val('block');
        }
        if (filter == "faq") {
            var landingpageblock = '/landing_page_faq?tenantid=';
            //var landingpageblock='/faq_block?tenantid=';         
            $('#landingpage').val(landingpageblock);
            $('#getview').val('faq');
        }






        commonupdateform(filter, updateid)
    }

    function commonupdateform(filter, updateid) {

        $.get('/commonupdateform?updateid=' + updateid + '&filter=' + filter, function (data) {

            $('#popupnewform').html();
            $('#popupnewform').html(data.view);
        });
    }



    function updateblock(updateid) {
        var landingpageblock = $('#landingpage').val();

        var getview = $('#getview').val();


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //var serialize=$('#formValidate').serialize();

        var formdata = new FormData();

        if ($('#formtype').val() == "blockform") {
            var importFiles = $('#fileToUpload').prop('files')[0];
        }




        var other_data = $('#formValidate').serializeArray();
        $.each(other_data, function (key, input) {
            formdata.append(input.name, input.value);
        });
        formdata.append("_token", '{{csrf_token()}}');
        formdata.append('getview', getview);
        formdata.append('update', updateid);
        if ($('#formtype').val() == "blockform") {
            formdata.append('uploadFiles', importFiles);
        }

        $.ajax({
            url: '/updatepopupform',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {

                // var $messageDiv = $('#messagebox'); // get the reference of the div
                // $messageDiv.show().html('Selected modules deleted successfully.'); // show and set the message.html(data.Message)
                // setTimeout(function () { $messageDiv.hide(); }, 10000); // 3 seconds later, hide
                //fnGotoPageModules(1);

                $('#new_modal').modal('hide');
                getview = $('#getview').val();
                if (getview == 'block') {
                    var getview1 = $('#landing-page_block');
                }

                if (getview == 'faq') {
                    getview1 = $('#faq_block');
                }
                commonfunc(landingpageblock, getview1);

            },

            error: function (err, result) {

                alert("Error" + err.responseText);
            }
        });
    }




    function commonfunc(landingpageblock, getview) {

        var tenantid = $('#tenantidval').val();

        $.get(landingpageblock + tenantid, function (data) {


                getview.html(data.view);
                // alert(data.view)
                Load_Tenant_Colors();
            }


        );


    }

    function imageuploading() {
        $('#fileToUpload').trigger('click');
    }

    function imageuploadingtest() {
        $('#fileToUpload1').trigger('click');
    }

    function readURL1(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                //alert(e.target.result);  
                $('#preview1').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }



    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var filesizeinmb = input.files[0].size;

            reader.onload = function (e) {
                //alert(e.target.result);  
                $('#preview').attr('src', e.target.result);

                if (filesizeinmb / (1024) / (1024) > 2) {
                    $('#filesize-error').html("File must be less than 2 mb.");
                    $('#preview').removeAttr('src');
                    $('#fileToUpload').val('');

                } else {
                    $('#filesize-error').html("");

                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php
                if(isset($_GET['goto']) && !empty($_GET['goto']) && $_GET['goto']=='slide')
                {
                echo "<script>setTimeout(function(){ $(window).scrollTop($('#slides_block').offset().top); }, 2000);    </script>";
                }
                if(isset($_GET['goto']) && !empty($_GET['goto']) && $_GET['goto']=='testimonial')
                {
                echo "<script>setTimeout(function(){ $(window).scrollTop($('#testimonial_block').offset().top); }, 2000);    </script>";
                }
                ?>
@endsection