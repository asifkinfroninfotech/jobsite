@php
$helper= \App\Helpers\AppHelper::instance();
$SummaryData=$helper->GetSummaryData_Dashboard('');
$symbol=\App\Helpers\AppGlobal::$Default_Currency_Symbol;
@endphp
@section('content')
@extends('adminview.layouts.app_layout', ['layout' => 'left_side_menu'])

<div class="content-w">

    @include('adminview.shared._top_menu')
    <div class="content-panel-toggler">
        <i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span>
    </div>
    <div class="content-i dashboard-row">
        <div class="content-box">

            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('admin_dashboard.help_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!trans('admin_dashboard.help_content')!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('admin_dashboard.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif
            <!--modal-->
            <div aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm" id="invite_user_modal" role="dialog"
                tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-sm" style="max-width: 610px!important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{trans('admin_dashboard.modal_invite_company')}}
                            </h5>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button" onclick="refresh()"><span
                                    aria-hidden="true"> X</span></button>
                        </div>
                        <div class="modal-body">

                            <div class="content-i">
                                <div class="element-wrapper" id='helpform_1'>
                                    <div class="element-box">
                                        <h5 class="form-header">
                                            {!!trans('admin_dashboard.title_ic_popup')!!}
                                        </h5>
                                        <div class="form-desc">
                                            {!!trans('admin_dashboard.content_ic_popup')!!}
                                        </div>
                                    </div>
                                </div>

                                <div id="multiple" class="tab-pane">
                                    <form id="multipleinviteform" method="post" action="/savemultiplecompany">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="">{{trans('admin_dashboard.modal_label_input_company')}}</label>
                                                <textarea id="textarea_company" class="form-control" placeholder=""
                                                    cols="100" rows="5" name="company_data"></textarea>
                                                <input type="hidden" name="_token" id="_token" value="" />
                                            </div>
                                            {{-- <div class="form-group col-md-12">
                                                <div class="alert alert-info">
                                                    {!!trans('admin_dashboard.validation_data_format')!!}


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
                                {{trans('admin_dashboard.cancel_btn_caption')}}</button>
                            <button class="btn btn-primary" id="ic_invite" data-placement="top" data-toggle="tooltip"
                                data-original-title="" type="button" onclick="invitecompany();">
                                {{trans('admin_dashboard.invite_btn_caption')}}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            {{trans('admin_dashboard.admin_dashboard_heading')}}
                        </h6>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="element-box el-tablo">
                                <div class="label">
                                    {{trans('admin_dashboard.interest_shownby_investor_graph_caption')}}
                                </div>
                                <div class="value">
                                    {{$SummaryData->InterestShown}}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="element-box el-tablo">
                                <div class="label">
                                    {{trans('admin_dashboard.investor_assets_UM_caption')}}
                                </div>
                                <div class="value">
                                    {{$symbol.$helper->nice_number($SummaryData->InvestorAssetsUnderManagement)}}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="element-box el-tablo">
                                <div class="label">
                                    {{trans('admin_dashboard.new_pre_registrations_caption')}}
                                </div>
                                <div class="value">
                                    {{$SummaryData->New_PreRegistrations}}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="element-box el-tablo">
                                <div class="label">
                                    {{trans('admin_dashboard.views_on_pipeline_caption')}}
                                </div>
                                <div class="value">
                                    {{$SummaryData->Noof_Views_Pipeline}}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="element-box el-tablo">
                                <div class="label">
                                    {{trans('admin_dashboard.views_on_enterprises_caption')}}
                                </div>
                                <div class="value">
                                    {{$SummaryData->Noof_Views_NewEnterprises}}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="element-box el-tablo">
                                <div class="label">
                                    {{trans('admin_dashboard.incomplete_profiles_caption')}}
                                </div>
                                <div class="value">
                                    {{$SummaryData->Incomplete_Profiles}}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="element-box el-tablo">
                                <div class="label">
                                    {{trans('admin_dashboard.new_entity_connections_caption')}}
                                </div>
                                <div class="value">
                                    {{$SummaryData->New_Entity_Connections}}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row">

                    </div> --}}

                    <div class="element-wrapper" style="margin-top:15px;">
                        <h6 class="element-header">
                            {{trans('admin_dashboard.sector_charts_heading_caption')}}
                        </h6>
                        <div class="element-box">
                            <div class="os-tabs-w">
                                <div class="os-tabs-controls">
                                    <ul class="nav nav-tabs smaller">
                                        <li class="nav-item" onclick="draw_enterprise_sector_chart();">
                                            <a class="nav-link active" data-toggle="tab" href="#tab_noof_enterprises">{{trans('admin_dashboard.noof_enterprises_caption')}}</a>
                                        </li>
                                        <li class="nav-item" onclick="draw_sector_chart('Investor');">
                                            <a class="nav-link" data-toggle="tab" href="#tab_noof_investors">{{trans('admin_dashboard.noof_investors_caption')}}</a>
                                        </li>
                                        <li class="nav-item" onclick="draw_sector_chart('ServiceProvider');">
                                            <a class="nav-link" data-toggle="tab" href="#tab_noof_serviceproviders">{{trans('admin_dashboard.noof_service_providers_caption')}}</a>
                                        </li>
                                        <li class="nav-item" onclick="draw_sector_chart('Enterprise_Viewed');">
                                            <a class="nav-link" data-toggle="tab" href="#tab_noof_enterprises_viewed">{{trans('admin_dashboard.enterprises_viewed_caption')}}</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tab_average_amount">Average
                                                Amount</a>
                                        </li> --}}

                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_noof_enterprises">
                                        <div class="el-chart-w">
                                            <div class="element-box">
                                                <div class="el-chart-w">
                                                    <canvas height="145" id="mychart_enterprise" width="300"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_noof_investors">
                                        <div class="el-chart-w">
                                            <div class="element-box">
                                                <div class="el-chart-w">
                                                    <canvas height="145" id="mychart_investor" width="300"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_noof_serviceproviders">
                                        <div class="el-chart-w">
                                            <div class="element-box">
                                                <div class="el-chart-w">
                                                    <canvas height="145" id="mychart_serviceprovider" width="300"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_noof_enterprises_viewed">
                                        <div class="el-chart-w">
                                            <div class="element-box">
                                                <div class="el-chart-w">
                                                    <canvas height="145" id="mychart_enterprises_viewed" width="300"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="tab-pane" id="tab_average_amount">

                                    </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>





                </div>
            </div>
            <!--Tenant Dashboard-->




        </div>
        <!--
            START - Sidebar
            -->
        <div class="content-panel">
            <div class="content-panel-close">
                <i class="os-icon os-icon-close"></i>
            </div>
            {{-- <div class="element-wrapper">
                <h6 class="element-header">
                    {{trans('admin_dashboard.text_quick_links')}}
                </h6>
                <div class="element-box-tp">
                    <div class="el-buttons-list full-width">
                        <a class="btn btn-white btn-sm" href="/edit-landing-page"><i class="os-icon os-icon-edit-1"></i><span>Edit
                                Landing Page</span></a>
                        <a class="btn btn-white btn-sm" href="/landing?tid={{$tenant1->tenantid}}" target="_blank"><i
                                class="os-icon os-icon-edit-1"></i><span>View Landing Page</span></a>
                        <a class="btn btn-white btn-sm" href="/dd-templates?tid={{$tenant1->tenantid}}" target="_blank"><i
                                class="os-icon os-icon-edit-1"></i><span>Manage Template</span></a>
                        <a class="btn btn-white btn-sm" id="inviteaddcompany" onclick="fnOpenInviteCompanyPopup();"
                            data-target=".bd-example-modal-sm" data-toggle="modal"><i class="os-icon os-icon-mail-18"></i><span>{{trans('admin_dashboard.link_invite_company')}}</span></a>
                    </div>
                </div>
            </div> --}}

            <div class="element-wrapper">
                <div class="element-box">
                    <h5 class="form-header">
                        Due Diligence Status
                    </h5>
                    <div class="form-desc">
                        This chart is showing the number of due diligence in the system by their current status.
                    </div>
                    <div class="el-chart-w">
                        <canvas height="200" id="mydonutChart" width="200"></canvas>
                        <div class="inside-donut-chart-label">
                            <strong id="ttl_dd">0</strong><span>Total Due Diligence</span>
                        </div>
                    </div>
                    {{-- <div class="el-legend">
                        <div class="legend-value-w">
                            <div class="legend-pin" style="background-color: #6896f9;"></div>
                            <div class="legend-value">
                                Processed
                            </div>
                        </div>
                        <div class="legend-value-w">
                            <div class="legend-pin" style="background-color: #85c751;"></div>
                            <div class="legend-value">
                                Cancelled
                            </div>
                        </div>
                        <div class="legend-value-w">
                            <div class="legend-pin" style="background-color: #d97b70;"></div>
                            <div class="legend-value">
                                Pending
                            </div>
                        </div>
                    </div> --}}
                </div>

            </div>

            <div class="element-wrapper">
                <div class="element-box">
                    <h5 class="form-header">
                        Finance Requested
                    </h5>
                    <div class="form-desc">
                        Displaying lists of deals in the system group by investment structures with sum of total
                        investment required.
                    </div>
                    <div class="el-chart-w">
                        <canvas height="150px" id="mypieChart1" width="150px"></canvas>
                    </div>
                </div>
            </div>

            <input type="hidden" id="tenantid" value="" />
        </div>
        <!--
        END - Sidebar
        -->
    </div>


</div>


@endsection


@section('scripts')

<script>
    $(document).ready(function () {
        draw_enterprise_sector_chart();
        draw_doughnut_chart();
        draw_pie_chart();
    });



    function fnOpenInviteCompanyPopup() {
        $('#textarea_company').val('');
        $('#error-multiple').html('');
        $('#error-multiple-blank').html('');
        $('#error-multiple').hide();
        $('#error-multiple-blank').hide();

    }
    //for invite company
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




    function draw_enterprise_sector_chart() {
        debugger;
        var tid = $('#tenantid').val();
        var url = "{{url('enterprise-sector/chart')}}";
        url = url + "?tenantid=" + tid;
        var Sectors = new Array();
        var e_counts = new Array();


        $.get(url, function (response) {

            response.forEach(function (data) {
                Sectors.push(data.sector);
                e_counts.push(data.ecount);
            });
            var ctx = document.getElementById("mychart_enterprise").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Sectors,
                    datasets: [{
                        label: 'Number of Enterprises',
                        data: e_counts,
                        backgroundColor: [
                            '#e65252',
                            '#fd7e14',
                            '#fbe4a0',
                            '#5eb314',
                            '#20c997',
                            '#047bf8',
                            '#047bf8',
                            '#6f42c1',
                        ],
                        borderColor: [
                            '#e65252',
                            '#fd7e14',
                            '#fbe4a0',
                            '#5eb314',
                            '#20c997',
                            '#047bf8',
                            '#047bf8',
                            '#6f42c1',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    }


    function draw_sector_chart(type) {
        debugger;
        var tid = $('#tenantid').val();
        var url = "{{url('sector/chart')}}";
        url = url + "?tenantid=" + tid;
        url = url + "&type=" + type;
        var Sectors = new Array();
        var e_counts = new Array();

        var chartid = "";
        var labeltodisplay = "";
        if (type == "Investor") {
            chartid = "mychart_investor";
            labeltodisplay = "No. of Investors";
        } else if (type == "ServiceProvider") {
            chartid = "mychart_serviceprovider";
            labeltodisplay = "No. of Service Providers";
        } else if (type == "Enterprise_Viewed") {
            chartid = "mychart_enterprises_viewed";
            labeltodisplay = "No. of Enterprises";
        }


        $.get(url, function (response) {

            response.forEach(function (data) {
                Sectors.push(data.sector);
                e_counts.push(data.ecount);
            });
            var ctx = document.getElementById(chartid).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Sectors,
                    datasets: [{
                        label: labeltodisplay,
                        data: e_counts,
                        backgroundColor: [
                            '#e65252',
                            '#fd7e14',
                            '#fbe4a0',
                            '#5eb314',
                            '#20c997',
                            '#047bf8',
                            '#047bf8',
                            '#6f42c1',
                        ],
                        borderColor: [
                            '#e65252',
                            '#fd7e14',
                            '#fbe4a0',
                            '#5eb314',
                            '#20c997',
                            '#047bf8',
                            '#047bf8',
                            '#6f42c1',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                autoSkip: false
                            }
                        }]
                    }
                }
            });
        });
    }




    function draw_pie_chart() {
        debugger;
        // var symbol='{{$symbol}}';
        var tid = $('#tenantid').val();
        var url = "{{url('deal/piechart')}}";
        url = url + "?tenantid=" + tid;

        var Sectors = new Array();
        var e_counts = new Array();

        $.get(url, function (response) {

            response.forEach(function (data) {
                Sectors.push(data.investmentstructure);
                e_counts.push(data.tvalue);
            });
            var ctx1 = $("#mypieChart1");

            //pie chart data
            var data1 = {
                labels: Sectors,
                datasets: [{
                    label: "Investment Structure",
                    data: e_counts,
                    backgroundColor: [
                        '#e65252',
                        '#fd7e14',
                        '#fbe4a0',
                        '#5eb314',
                        '#20c997',
                        '#047bf8',
                        '#047bf8',
                        '#6f42c1',
                    ],
                    borderColor: [
                        '#e65252',
                        '#fd7e14',
                        '#fbe4a0',
                        '#5eb314',
                        '#20c997',
                        '#047bf8',
                        '#047bf8',
                        '#6f42c1',
                    ],
                    borderWidth: [1, 1, 1, 1, 1]
                }]
            };

            //options
            var options = {
                responsive: true,
                // title: {
                //     display: true,
                //     position: "top",
                //     text: "Investment Structure",
                //     fontSize: 18,
                //     fontColor: "#111"
                // },
                legend: {
                    display: true,
                    position: "bottom",
                    labels: {
                        fontColor: "#333",
                        fontSize: 9
                    }
                }
            };

            //create Chart class object
            var chart1 = new Chart(ctx1, {
                type: "pie",
                data: data1,
                options: options
            });


        });
    }




    function draw_doughnut_chart() {

        var tid = $('#tenantid').val();
        var url = "{{url('dd/doughnutchart')}}";
        url = url + "?tenantid=" + tid;

        var Types = new Array();
        var Scores = new Array();
        var total_dd = 0;

        $.get(url, function (response) {

            response.forEach(function (data) {
                Types.push(data.type);
                Scores.push(data.score);
                total_dd = total_dd + parseInt(data.score);
            });

            var donutChart = $("#mydonutChart");
            // donut chart data
            var data = {
                labels: Types, //["Red", "Blue", "Yellow", "Green", "Purple"],
                datasets: [{
                    data: Scores, //[300, 50, 100, 30, 70],
                    backgroundColor: ["#5797fc", "#7e6fff", "#4ecc48", "#ffcc29", "#f37070"],
                    hoverBackgroundColor: ["#5797fc", "#7e6fff", "#4ecc48", "#ffcc29", "#f37070"],
                    borderWidth: 0
                }]
            };

            // -----------------
            // init donut chart
            // -----------------
            new Chart(donutChart, {
                type: 'doughnut',
                data: data,
                options: {
                    response: true,
                    legend: {
                        display: true,
                        position: "bottom",
                        labels: {
                            fontColor: "#333",
                            fontSize: 9
                        }
                    },
                    animation: {
                        animateScale: true
                    },
                    cutoutPercentage: 80
                }
            });

            $('#ttl_dd').html(total_dd);


        });
    }

</script>
@endsection
