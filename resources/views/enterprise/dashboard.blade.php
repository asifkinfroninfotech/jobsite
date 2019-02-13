<meta name="csrf-token" content="{{ csrf_token() }}">

<?php 
      

 
    function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 2).'t';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).'b';
        elseif ($n > 1000000) return round(($n/1000000), 2).'m';
        elseif ($n > 1000) return round(($n/1000), 2).'k';

        return number_format($n);
    }

/*echo nice_number('14120000'); //14.12 million*/

?>
@section('content')
@extends('layouts.app_layout', ['layout' => 'left_side_menu'])
<div class="content-w">

    @include('shared._top_menu')
    <div class="content-panel-toggler">
        <i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span>
    </div>


    <!--modal-->
    <div aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm" id="invite_user_modal" role="dialog"
        tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm" style="max-width: 610px!important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{trans('tenant_dashboard.modal_invite_company')}}
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button" onclick="refresh()"><span
                            aria-hidden="true"> X</span></button>
                </div>
                <div class="modal-body">

                    <div class="content-i">
                        <div class="element-wrapper" id='helpform_1'>
                            <div class="element-box">
                                <h5 class="form-header">
                                    {!!trans('tenant_dashboard.title_ic_popup')!!}
                                </h5>
                                <div class="form-desc">
                                    {!!trans('tenant_dashboard.content_ic_popup')!!}
                                </div>
                            </div>
                        </div>

                        <div id="multiple" class="tab-pane">
                            <form id="multipleinviteform" method="post" action="/savemultiplecompany">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">{{trans('tenant_dashboard.modal_label_input_company')}}</label>
                                        <textarea id="textarea_company" class="form-control" placeholder="" cols="100"
                                            rows="5" name="company_data"></textarea>
                                        <input type="hidden" name="_token" id="_token" value="" />
                                    </div>
                                    {{-- <div class="form-group col-md-12">
                                        <div class="alert alert-info">
                                            {!!trans('tenant_dashboard.validation_data_format')!!}


                                        </div>
                                    </div> --}}
                                </div>
                            </form>
                            <div class="alert alert-danger" role="alert" id="error-multiple" style="display:none;">

                            </div>
                            <div class="alert alert-danger" role="alert" id="error-multiple-blank" style="display:none;">

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="ic_cancel" data-placement="top" data-toggle="tooltip"
                        data-original-title="" type="button" data-dismiss="modal" type="button">
                        {{trans('tenant_dashboard.cancel_btn_caption')}}</button>
                    <button class="btn btn-primary" id="ic_invite" data-placement="top" data-toggle="tooltip"
                        data-original-title="" type="button" onclick="invitecompany();">
                        {{trans('tenant_dashboard.invite_btn_caption')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!---->
    <div class="content-i dashboard-row">
        <div class="content-box">

            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('investor_dashboard.help_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!trans('investor_dashboard.help_content')!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('investor_dashboard.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif



            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            {{trans('investor_dashboard.text_dashboard')}}
                        </h6>
                        <div class="element-content">
                            <div class="row">
                                <div class="col-sm-4" style="display:none;">
                                    <a class="element-box el-tablo" href="#">
                                        <div class="label">
                                            {{trans('investor_dashboard.text_new_deals')}}
                                        </div>
                                        <div class="value">
                                            {{ $data['total_deals']}}
                                        </div>
                                        <div class="trending trending-up-basic">
                                            <span>12%</span><i class="os-icon os-icon-arrow-up2"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-4" style="display: none;">
                                    <a class="element-box el-tablo" href="#">
                                        <div class="label">
                                            {{trans('investor_dashboard.text_investment_value')}}
                                        </div>
                                        <div class="value">
                                            ${{nice_number($data['deal_investment_count']) }}
                                        </div>
                                        {{-- <div class="trending trending-down-basic">
                                            <span>12%</span><i class="os-icon os-icon-arrow-down"></i>
                                        </div> --}}
                                    </a>
                                </div>
                                <div class="col-sm-4" style="display:none;">
                                    <a class="element-box el-tablo" href="#">
                                        <div class="label">
                                            {{trans('investor_dashboard.text_lives_impacted')}}
                                        </div>
                                        <div class="value">
                                            125
                                        </div>
                                        <div class="trending trending-down-basic">
                                            <span>9%</span><i class="os-icon os-icon-arrow-down"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------
                        start - progress bar
                        -------------------->
            @if($data['usertype'][0]->usertype==0)
            @php
            $profile_complete_percent=$data['completepercentage'];
            @endphp
            @if($profile_complete_percent<100) <div class="element-box element-wrapper-marging-btm">
                <h5 class="form-header">
                    {{trans('investor_dashboard.text_your_profile')}}
                </h5>
                <div class="form-desc">
                    {{trans('investor_dashboard.text_profiledescription')}}
                </div>

                <div class="element-box-content example-content">
                    <div class="progress">
                        <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" class="progress-bar" role="progressbar"
                            style="width: {{ $data['completepercentage'] }}%;">
                            <!--                                        {{ $data['profile_completeness'] }}%-->
                            {{ $data['completepercentage'] }}%
                        </div>
                    </div>
                </div>
        </div>
        @endif
        @endif
        <!--
                        END - progress bar
                        -->
        <!--
                        start - My active portfolio
                        -->
        @include('shared._active_portfolio',compact('data'))
        <!--
                        END - Due Diligence Assignments
                        -->

        <div class="row">
            <div class="col-sm-8 home-processbar">
                <div class="element-wrapper">
                    <h6 class="element-header">
                        {{trans('investor_dashboard.text_duediligenceassignment')}}
                    </h6>
                    <div class="element-box">
                        @if(!isset($data['duediligence_assignments']) || empty($data['duediligence_assignments']))
                        No Question Assigned.
                        @else
                        @foreach($data['duediligence_assignments'] as $da)
                        @php
                        $pendingpercent=0;
                        $completedpercent=0;

                        $pendingpercent=intval(($da->PendingQuestion/$da->TotalQuestion)*100);
                        $completedpercent=intval((($da->TotalQuestion-$da->PendingQuestion)/$da->TotalQuestion)*100);

                        @endphp
                        <a href="/due-diligence-dashboard?pd={{$da->pipelinedealid}}">
                            <div class="os-progress-bar primary">
                                <div class="bar-labels">
                                    <div class="bar-label-left">
                                        <span class="bigger">{{$da->projectname}}</span>
                                    </div>
                                    <div class="bar-label-right">
                                        <span class="info">{{$da->TotalQuestion}} Questions / {{$da->PendingQuestion}}
                                            Pending</span>
                                    </div>
                                </div>
                                <div class="bar-level-1" style="width: 100%">
                                    <div class="bar-level-2" style="width: {{$pendingpercent}}%">
                                        <div class="bar-level-3" style="width: {{$completedpercent}}%"></div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        @endforeach
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-sm-4">

                <div class="element-wrapper">
                    <h6 class="element-header">
                        {{trans('investor_dashboard.text_live_pitch')}}
                    </h6>

                    @if(empty($data['recommendedvideo'][0][0]) || !isset($data['recommendedvideo'][0][0]))
                    <div class="element-box video-play-row">
                        {{trans('notfoundlang.live_pitch')}}
                    </div>
                    @else
                    <div class="element-box video-play-row">
                        <div class="el-chart-w">
                            <a class="video-play" data-target="#onboardingWideFeaturesModal" data-toggle="modal"
                                onclick="makeiframesingle();">
                                <img src="img/portfolio15.jpg" alt="Play Video" class="img-responsive" />
                            </a>
                            <div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingWideFeaturesModal"
                                role="dialog" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-centered" role="document">
                                    <div class="modal-content text-center">
                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"
                                            onclick="closesingle();"><span class="close-label">Skip Intro</span><span
                                                class="os-icon os-icon-close" style="z-index:99999;color:white;"></span></button>
                                        <div class="onboarding-side-by-side">
                                            <div class="onboarding-content with-full" style="padding: 0px;">
                                                <input type="hidden" id="makeiframesingle" value="/storage/deal/video/{{$data['recommendedvideo'][0][0]->video}}">
                                                <div id="makeiframedvsingle">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="live-pitch-data">
                            <strong>{{$data['recommendedvideo'][0][0]->name}}</strong>
                            <label class="live-pith-desct">{{$data['recommendedvideo'][0][0]->projectname}}</label>
                            <label class="live-pith-date">Today</label>
                            <div class="pt-btn">
                                <a class="btn btn-success btn-sm" href="/deals/view-deal?dealid={{$data['recommendedvideo'][0][0]->dealid}}">View
                                    Profile</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">
                        {{trans('investor_dashboard.text_unique_visitors_graph')}}
                    </h6>
                    <div class="element-box">
                        <div class="os-tabs-w">
                            <div class="os-tabs-controls">
                                <ul class="nav nav-tabs smaller">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tab_overview">{{trans('investor_dashboard.text_overview')}}</a>
                                    </li>
                                </ul>
                                <ul class="nav nav-pills smaller d-none d-md-flex">
                                    <li class="nav-item">
                                        <a class="nav-link " data-toggle="tab" href="#" onclick="selectdays('today');">{{trans('investor_dashboard.text_today')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#" onclick="selectdays(7);">7
                                            {{trans('investor_dashboard.text_days')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#" onclick="selectdays(14);">14
                                            {{trans('investor_dashboard.text_days')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#" onclick="selectdays('lastmonth');">{{trans('investor_dashboard.text_lastmonth')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_overview">
                                    <div class="el-tablo bigger">
                                        <div class="label">
                                            {{trans('investor_dashboard.text_unique_visitors')}}
                                        </div>
                                        <div class="value" id="valuetotalcount">
                                            <!-- {{ session('companyid')}} -->
                                            {{
                                            ($data['visitor_count_today']) ? $data['visitor_count_today']->visitorcount
                                            : 0
                                            }}

                                        </div>
                                    </div>
                                    <div class="el-chart-w">
                                        <canvas height="150px" id="lineChart1" width="600px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            <span>Dark </span><span>Colors</span>
        </div>
        <!--------------------
                        END - Color Scheme Toggler
                        -------------------->
        <!--------------------
                        START - Chat Popup Box
                        -------------------->
        <div class="floated-chat-btn">
            <i class="os-icon os-icon-mail-07"></i><span>Demo Chat</span>
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
                        <a href="#"><span class="extra-tooltip">Attach Document</span><i class="os-icon os-icon-documents-07"></i></a><a
                            href="#"><span class="extra-tooltip">Insert Photo</span><i class="os-icon os-icon-others-29"></i></a><a
                            href="#"><span class="extra-tooltip">Upload Video</span><i class="os-icon os-icon-ui-51"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!--------------------
                        END - Chat Popup Box
                        -------------------->
    </div>
    <!--------------------
                    START - Sidebar
                    -------------------->
    <div class="content-panel">
        <div class="content-panel-close">
            <i class="os-icon os-icon-close"></i>
        </div>
        <div class="element-wrapper">
            <h6 class="element-header">
                {{trans('investor_dashboard.text_quick_links')}}
            </h6>
            <div class="element-box-tp">
                <div class="el-buttons-list full-width">
                    <a class="btn btn-white btn-sm" href="/dealpipeline"><i class="os-icon os-icon-ui-37"></i><span>{{trans('investor_dashboard.text_find_enterprises')}}</span></a>
                    <a class="btn btn-white btn-sm" href="/my-portfolio"><i class="os-icon os-icon-mail-18"></i><span>{{trans('investor_dashboard.text_invite_enterprises')}}</span></a>

                    <a class="btn btn-white btn-sm" onclick="fnOpenInviteCompanyPopup();" data-target=".bd-example-modal-sm"
                        data-toggle="modal"><i class="os-icon os-icon-mail-18"></i><span>{{trans('investor_dashboard.text_invite_companies')}}</span></a>


                    <a class="btn btn-white btn-sm" href="/user/profile/edit"><i class="os-icon os-icon-edit-1"></i><span>{{trans('investor_dashboard.text_manage_my_profile')}}</span></a>
                    <a class="btn btn-white btn-sm" href="/pending-requests"><i class="os-icon os-icon-agenda-1"></i><span>{{trans('investor_dashboard.link_pending_requests')}}</span></a>
                    <a class="btn btn-white btn-sm" href="/dd-templates"><i class="os-icon os-icon-edit-1"></i><span>{{trans('investor_dashboard.link_manage_templates')}}</span></a>
                </div>
            </div>
        </div>
        <!--------------------
                        START - User Profiles
                        -------------------->

        {{-- @include('shared._right_friends_request') --}}


        <!--------------------
                        END - User Profiles
                        -------------------->
        <!--------------------
                        START - Recent Activity
                        -------------------->
        {{-- <div class="element-wrapper">
            <h6 class="element-header">
                {{trans('investor_dashboard.text_recent_activity')}}
            </h6>
            <div class="element-box-tp">
                <div class="activity-boxes-w">
                    <div class="activity-box-w">
                        <div class="activity-time">
                            10 Min
                        </div>
                        <div class="activity-box">
                            <div class="activity-avatar">
                                <img alt="" src="img/avatar1.jpg">
                            </div>
                            <div class="activity-info">
                                <div class="activity-role">
                                    John Mayers
                                </div>
                                <strong class="activity-title">Opened New Account</strong>
                            </div>
                        </div>
                    </div>
                    <div class="activity-box-w">
                        <div class="activity-time">
                            2 Hours
                        </div>
                        <div class="activity-box">
                            <div class="activity-avatar">
                                <img alt="" src="img/avatar2.jpg">
                            </div>
                            <div class="activity-info">
                                <div class="activity-role">
                                    Ben Gossman
                                </div>
                                <strong class="activity-title">Posted Comment</strong>
                            </div>
                        </div>
                    </div>
                    <div class="activity-box-w">
                        <div class="activity-time">
                            5 Hours
                        </div>
                        <div class="activity-box">
                            <div class="activity-avatar">
                                <img alt="" src="img/avatar3.jpg">
                            </div>
                            <div class="activity-info">
                                <div class="activity-role">
                                    Phil Nokorin
                                </div>
                                <strong class="activity-title">Opened New Account</strong>
                            </div>
                        </div>
                    </div>
                    <div class="activity-box-w">
                        <div class="activity-time">
                            2 Days
                        </div>
                        <div class="activity-box">
                            <div class="activity-avatar">
                                <img alt="" src="img/avatar4.jpg">
                            </div>
                            <div class="activity-info">
                                <div class="activity-role">
                                    Jenny Miksa
                                </div>
                                <strong class="activity-title">Uploaded Image</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--------------------
                        END - Recent Activity
                        -------------------->
        <!--------------------
                        START - Recommended Businesses
                        -------------------->



        <div class="element-wrapper bullet-status-active">
            <h6 class="element-header">
                {{trans('investor_dashboard.text_recommended_businesses')}}
            </h6>


            @if(empty($data['recommendedbusiness'][0][0]) || !isset($data['recommendedbusiness'][0][0]))
            <div class="element-box-tp">
                <div class="users-list-w">
                    {{trans('notfoundlang.recommended_business')}}
                </div>
            </div>
            @else
            @foreach($data['recommendedbusiness'][0] as $recommendedbusiness)
            <div class="element-box-tp">
                <div class="users-list-w">
                    <div class="user-w with-status status-green">
                        <div class="user-avatar-w">
                            <div class="user-avatar">
                                @if(isset($recommendedbusiness->profileimage) &&
                                !empty($recommendedbusiness->profileimage))
                                <img alt="" src="/storage/company/profileimage/{{$recommendedbusiness->profileimage}}">
                                @else

                                <img alt="" src="{{ Avatar::create($recommendedbusiness->name)->toBase64()}}">
                                @endif
                            </div>
                        </div>
                        <div class="user-name">
                            <h6 class="user-title">
                                {{$recommendedbusiness->name}}
                            </h6>
                            <div class="user-role">
                                {{$recommendedbusiness->statusmessage}}
                            </div>
                        </div>
                        <a class="user-action" href="/company/profile/view?{{'company='.$recommendedbusiness->companyid .'&companytype='.$recommendedbusiness->companytype}}">
                            <div class="os-icon os-icon-mail-19"></div>
                        </a>
                    </div>

                </div>
            </div>
            @endforeach
            @endif

        </div>

        <!--------------------
                        END - Team Members
                        -------------------->
    </div>
    <!--------------------
                    END - Sidebar
                    -------------------->
</div>
</div>

@section('scripts')
<script>
    $(document).ready(function () {
        selectdays('7');
    });



    // init line chart if element exists
    if ($("#lineChart1").length) {
        var lineChart = $("#lineChart1");

        // line chart data
        var lineData = {
            labels: [0, 0, 0, 0],
            datasets: [{
                label: "Visitors Graph",
                fill: false,
                lineTension: 0.3,
                backgroundColor: "#fff",
                borderColor: "#047bf8",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "#fff",
                pointBackgroundColor: "#141E41",
                pointBorderWidth: 3,
                pointHoverRadius: 10,
                pointHoverBackgroundColor: "#FC2055",
                pointHoverBorderColor: "#fff",
                pointHoverBorderWidth: 3,
                pointRadius: 5,
                pointHitRadius: 10,
                data: [0, 0, 0, 0],
                spanGaps: false
            }]
        };

        // line chart init
        var myLineChart = new Chart(lineChart, {
            type: 'line',
            data: lineData,
            options: {
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            fontSize: '11',
                            fontColor: '#969da5'
                        },
                        gridLines: {
                            color: 'rgba(0,0,0,0.05)',
                            zeroLineColor: 'rgba(0,0,0,0.05)'
                        }
                    }],
                    yAxes: [{
                        display: false,
                        ticks: {
                            beginAtZero: true,
                            max: 65
                        }
                    }]
                }
            }
        });
    }






    function selectdays(days) {
        debugger;
        $('#valuetotalcount').text('0');
        $.get('/visitorcount?days=' + days, function (data) {
            data = JSON.parse(data);
            $('#valuetotalcount').text(data['totalcount']);
            myLineChart.data.labels = data['label'];
            myLineChart.data.datasets[0].data = data['values'];
            myLineChart.update();
        });
    }

    function fnUpdatePipelineDealStatus(id) {
        var pipelinedealid = id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formdata = new FormData();
        formdata.append("pipelinedealid", pipelinedealid);
        formdata.append("_token", '{{csrf_token()}}');
        $('#btnStart').prop("disabled", true);
        $.ajax({
            url: '/start-pipelinedeal',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {

                if (data.status == 'Success') {
                    $('#btnStart').prop("disabled", false);
                    $(".modal-backdrop").remove();
                    $("#confirmation_close").click();
                    location.reload();
                } else {
                    $('#btnStart').prop("disabled", false);
                    $('#error-start-duediligence').html('Some error found.');
                    var $messageDiv = $('#error-start-duediligence'); // get the reference of the div
                    $messageDiv.show(); // show and set the message.html(data.Message)
                    setTimeout(function () {
                        $messageDiv.hide();
                    }, 3000); // 3 seconds later, hide
                    return;
                }

            },
            error: function (err, result) {
                $('#btnStart').prop("disabled", false);
                $(".modal-backdrop").remove();
                $("#confirmation_close").click();

            }
        });

    }


    function makeiframesingle(modal) {
        var src1 = $('#makeiframesingle').val();
        $('#makeiframedvsingle').html('<iframe width="100%" height="400" src="' + src1 +
            '" frameborder="0"></iframe>');

    }


    function closesingle() {
        $('#makeiframedvsingle').html('<iframe width="100%" height="400" src="" frameborder="0"></iframe>');
    }


    //company invite script

    function fnOpenInviteCompanyPopup() {



        $('#textarea_company').val('');
        $('#error-multiple').html('');
        $('#error-multiple-blank').html('');
        $('#error-multiple').hide();
        $('#error-multiple-blank').hide();

    }

    function invitecompany() {
        debugger;

        $('#error-multiple-blank').hide();
        var multiarr = [];
        var str = "";

        if ($('#textarea_company').val() != '') {
            var lines = $('#textarea_company').val().split(/\n/);
            for (var i = 0; i < lines.length; i++) {
                if (lines[i].length > 0) //&& lines[i].length != 4
                {

                    var getdata = $.trim(lines[i]);
                    getdata = getdata.replace(/\s/g, '');

                    var words = getdata.split(",");
                    if (words.length != 4) {
                        $('#error-multiple').show();
                        str = str + "Must be four comma separated values on line : " + i + "<br/>";
                        $('#error-multiple').html(str);
                    }
                    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if (!(regex.test(words[3])) && words.length == 4) {
                        $('#error-multiple').show();
                        str = str + "Email is not valid on line : " + i + "<br/>";
                        $('#error-multiple').html(str);
                    }
                    if (words.length == 4 && regex.test(words[3])) {
                        var firstname = words[0];
                        var lastname = words[1];
                        var companyname = words[2];
                        var companyemail = words[3];
                        multiarr.push([firstname, lastname, companyname, companyemail]);

                    }
                }
            }
        } else {
            $('#error-multiple').html('Please enter company data to invite.');
            $('#error-multiple').show();
        }
        if (multiarr.length > 0) {
            $('#ic_invite').prop('disabled', true);
            $('#ic_cancel').prop('disabled', true);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post("/savemultiplecompanyinvite", {
                multiarray: multiarr,
                token: '{{csrf_token()}}'
            }, function (data) {
                $('#ic_invite').prop('disabled', false);
                $('#ic_cancel').prop('disabled', false);
                $('#error-multiple-blank').html('');
                $('#error-multiple-blank').html(data);
                $('#error-multiple-blank').show();
            });
            str = "";
        }

    }




    //
</script>
@endsection
{{-- @include('shared._dashboard_friend_request') --}}

@endsection







<!-- 
                <script type="text/javascript">
                    $(document).ready(function () {
                        
                    })
                </script> -->