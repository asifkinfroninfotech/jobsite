@php
// $extends="";
// $view="";
// $layout="";
// if(isset($calledfrom) && !empty($calledfrom))
// {

// if($calledfrom=="admin")
// {
// $view='adminview.layouts.app_layout';
// $layout='left_side_menu';

// }
// else if($calledfrom=="tenant")
// {
// $view= 'tenants.layouts.app_layout';
// $layout='left_side_menu_tenant';

// }
// }
// else
// {
// $view= 'layouts.app_layout';
// $layout='left_side_menu_compact';
// }
$symbol='';
if(isset($tender_proposals->symbol) && !empty($tender_proposals->symbol) )
{
$symbol=$tender_proposals->symbol;
}
else {
$symbol=\App\Helpers\AppGlobal::$Default_Currency_Symbol;
}
@endphp

{{-- @extends($view, ['layout' => $layout]) --}}
@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])

@section('content')

<?php 
$helper=\App\Helpers\AppHelper::instance();
$loggedinuserid=Session('userid');
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
?>

<div class="content-w portfolio-custom-vk">

    <!--  START - Secondary Top Menu  -->
    @if(isset($calledfrom) && !empty($calledfrom))
    @if($calledfrom=="admin")
    @include('adminview.shared._top_menu')

    @elseif($calledfrom=="tenant")
    @include('tenants.shared._top_menu_tenant')
    @endif
    @else
    @include('shared._top_menu')
    @endif
    <!--   END - Secondary Top Menu   -->



    <!-- -->

    <div class="content-panel-toggler">
        <i class="os-icon os-icon-grid-squares-22"></i>
        <span>Sidebar</span>
    </div>
    <!--START - Control panel above projects-->
    <div class="content-i control-panel">
        <div class="content-box-tb">
            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('view_tender.help_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!$helper->GetHelpModifiedText(trans('view_tender.help_content'))!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('view_tender.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
    <!--END - Control panel above projects-->

    <div class="content-i">
        <div class="content-box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">
{{trans('view_tender.bidding_page_title')}}
                            {{-- Bidding --}}
                        </h6>
                        <div class="element-box" id="frmbid_edit">
                            <form id="formValidate" method="post" action="/biddinginfosave" enctype="multipart/form-data">
                                {{csrf_field()}}


                                <div class="form-group">
<label for="">{{trans('view_tender.bidding_proposal_heading_caption')}}</label><input class="form-control" data-error="Proposal heading required."
placeholder="{{trans('view_tender.bidding_proposal_heading_caption')}}" required="required" type="text"
name="proposalheading"
                                        value="{{(isset($tender_proposals->proposal_heading)&&!empty($tender_proposals->proposal_heading))?$tender_proposals->proposal_heading:''}}">
                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>

                                {{-- <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> Desired Time Frame</label><input class="form-control"
                                                placeholder="Desired Time Frame" required="required" type="text" name="desiredtimeframe"
                                                value="{{(isset($tender_proposals->desired_time_frame)&&!empty($tender_proposals->desired_time_frame))?$tender_proposals->desired_time_frame:''}}">
                                            <div class="help-block form-text with-errors form-control-feedback">

                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Resource Requirements</label><input class="form-control"
                                                placeholder="Resource Requirements" required="required" type="text"
                                                name="resourcerequirement" value="{{(isset($tender_proposals->resource_requirements)&&!empty($tender_proposals->resource_requirements))?$tender_proposals->resource_requirements:''}}">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                </div> --}}





                                <div class="row">
                                    {{-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> Approximate Budget</label><input class="form-control"
                                                placeholder="approximate budget" required="required" type="number" name="approximatebudget"
                                                value="{{(isset($tender_proposals->approximate_budget)&&!empty($tender_proposals->approximate_budget))?$tender_proposals->approximate_budget:''}}">
                                            <div class="help-block form-text with-errors form-control-feedback">

                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="col-sm-6">
                                        {{-- <div class="form-group">
                                            <label for="">Quoted Amount</label><input class="form-control" placeholder="quoted amount"
                                                required="required" type="number" name="quoteamount" value="{{(isset($tender_proposals->quoteamount)&&!empty($tender_proposals->quoteamount))?$tender_proposals->quoteamount:''}}">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div> --}}

                                        <div class="form-group">
<label for="">{{trans('view_tender.bidding_info_view_quote_amount')}}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text currency-symb">
                                                        {{$symbol}}
                                                    </div>
                                                </div>

<input class="form-control" type="text" placeholder="{{trans('view_tender.bidding_info_view_quote_amount')}}"
                                                    type="number" name="quoteamount" value="{{(isset($tender_proposals->quoteamount)&&!empty($tender_proposals->quoteamount))?$tender_proposals->quoteamount:''}}">
                                            </div>


                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
<label for=""> {{trans('view_tender.bidding_info_people_involved')}}</label><input class="form-control"
placeholder="{{trans('view_tender.bidding_info_people_involved')}}" type="text" name="peopleinvolved"
value="{{(isset($tender_proposals->people_involved)&&!empty($tender_proposals->people_involved))?$tender_proposals->people_involved:''}}">
                                        </div>
                                    </div>

                                    {{-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Services Requested</label><input class="form-control"
                                                placeholder="Services Requested" required="required" type="text" name="servicerequested"
                                                value="{{(isset($tender_proposals->services_requested)&&!empty($tender_proposals->services_requested))?$tender_proposals->services_requested:''}}">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div> --}}
                                </div>


                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
<label for="">{{trans('view_tender.duration_to_complete')}}</label><input class="form-control"
placeholder="{{trans('view_tender.duration_to_complete')}}" type="text" name="durationtocomplete"
                                                value="{{(isset($tender_proposals->duration_to_complete)&&!empty($tender_proposals->duration_to_complete))?$tender_proposals->duration_to_complete:''}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        @if((isset($tender_proposals->file1)&&!empty($tender_proposals->file1)))
                                        <div class='form-group'>
                                            <label for="" style="margin-top: 30px;">
{{trans('view_tender.uploaded_file')}} : <a href="/storage/tender/proposal/{{$tender_proposals->file1}}"
                                                    target="_blank">{{(isset($tender_proposals->file1)&&!empty($tender_proposals->file1))?$tender_proposals->file1:''}}</a>
                                            </label>
                                        </div>
                                        @endif
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class='form-group'>
                                            <label for="">
{{trans('view_tender.upload_a_file')}}
                                            </label>
                                            <br />
                                            <input type="file" id='import_file' name="import_file">
                                        </div>
                                    </div>
                                </div>


                                <fieldset class="form-group">
<legend><span>{{trans('view_tender.bidding_additional_info')}}</span></legend>


                                    <div class="form-group">
<label>{{trans('view_tender.bidding_why_consider_you')}}</label><textarea class="form-control" rows="3" name="whyconsideryou">{{(isset($tender_proposals->why_consider_you)&&!empty($tender_proposals->why_consider_you))?$tender_proposals->why_consider_you:''}}</textarea>
                                    </div>

                                    <div class="form-group">
<label>{{trans('view_tender.bidding_info_short_description')}}</label><textarea class="form-control" rows="3" name="shortdescription">{{(isset($tender_proposals->short_description)&&!empty($tender_proposals->short_description))?$tender_proposals->short_description:''}}</textarea>
                                    </div>


                                    <div class="form-group">
<label>{{trans('view_tender.bidding_additional_info')}}</label><textarea class="form-control" rows="3"
                                            name="additionalinfo">{{(isset($tender_proposals->additional_info)&&!empty($tender_proposals->additional_info))?$tender_proposals->additional_info:''}}</textarea>
                                    </div>


                                </fieldset>

                                <div class="alert alert-danger" role="alert" id="f_submit_error" style="display:none;">

{{trans('view_tender.bidding_info_all_fields_required_error_message')}}
                                </div>

                                <div class="alert alert-danger" role="alert" id="submit_error" style="display:none;">
{{trans('view_tender.bidding_info_error_message')}}
  
                                </div>

                                <div class="form-buttons-w text-right my-portfolio-btm">
<button class="btn btn-primary" type="button" onclick="fnFinalSubmit('{{$tender_proposals->proposalid}}');">{{trans('view_tender.bidding_info_btnfinal_submit_caption')}}</button>
<button class="btn btn-primary" type="submit">{{trans('view_tender.bidding_info_btnsave_caption')}}</button>
                                </div>

                                <input type="hidden" name="proposalid" value="{{$tender_proposals->proposalid}}">
                                <input type="hidden" name="companyid" value="{{$tender_proposals->companyid}}">
                                <input type="hidden" name="is_applicable" value="">

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------
              START - Color Scheme Toggler
              -------------------->
            <!--------------------
              END - Color Scheme Toggler
              -------------------->
            <!--------------------
              START - Chat Popup Box
              -------------------->
            <!--------------------
              END - Chat Popup Box
              -------------------->
        </div>
        <!--------------------
            START - Sidebar
            -------------------->

        <!--------------------
            END - Sidebar
            -------------------->
    </div>
</div>





@endsection


@section('scripts')
<script type="text/javascript">
    function fnFinalSubmit(pid) {
        debugger;
        if (typeof pid == 'undefined' || $.trim(pid) == "") {
            return;
        }

        var result = '';
        var route = '/check-bid-appropriate-for-submission?pid=' + pid;
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
                debugger;
                result = data.message;
            },
            complete: function () {
                if (result == 'No') {
                    $('#f_submit_error').show();
                } else {
                    $('#f_submit_error').hide();
                    fnActualSubmitBid(pid);
                }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });

        debugger;

    }

    function fnActualSubmitBid(pid)
    {
      var route = '/submit-bid?pid=' + pid;
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
                debugger;
                result = data.message;
                if (result == 'No') {
                    $('#submit_error').show();
                } else {
                    $('#submit_error').hide();
                    window.location='/view-other-tenders?tc=bs';
                }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

</script>

@endsection
