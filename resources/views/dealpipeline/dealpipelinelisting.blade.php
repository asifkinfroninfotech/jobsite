@php
$helper=\App\Helpers\AppHelper::instance();
@endphp
@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')

<div class="content-w portfolio-custom-vk">
    <!--
      START - Secondary Top Menu
      -->
    @include('shared._top_menu')

    <div class="content-panel-toggler">
        <i class="os-icon os-icon-grid-squares-22"></i>
        <span>Sidebar</span>
    </div>

    <div class="content-i">
        <div class="content-box">
            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('dealpipeline.help_title')!!}
                    </h5>
                    <div class="form-desc">
                        @if(session('usertype')=="Investors")
                        {!!$helper->GetHelpModifiedText(trans('dealpipeline.help_content'))!!}
                        @endif
                        @if(session('usertype')=="ESOs")
                        {!!$helper->GetHelpModifiedText(trans('dealpipeline.eso_help_content'))!!}
                        @endif
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('dealpipeline.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif

            <!--
              start - Enterprise Pipeline
              -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            Deals Pipeline
                        </h6>

                        <div class="controls-above-table filter-row-top">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form-inline justify-content-sm-end">
                                        <input class="form-control form-control-sm rounded bright" placeholder="Search"
                                            type="text" id="txtSearch">
                                        <select class="form-control form-control-sm rounded bright" id="sortbyfield"
                                            onchange="fngetDeals(1);">
                                            <option selected="selected" value="">
                                                Sort By
                                            </option>
                                            <option value="company">
                                                Company
                                            </option>
                                            <option value="totalinvestment">
                                                Investment
                                            </option>
                                        </select>

                                    </form>
                                </div>
                            </div>

                        </div>
                        <!--START - Projects list-->
                        <div class="projects-list projects-list-vk" id="divDeals">


                        </div>
                        <!--END - Projects list-->
                    </div>
                </div>
            </div>
            <!--------------------
              END - Enterprise Pipeline
              -------------------->
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
        <!--------------------
          START - Sidebar
          -------------------->
        <div class="content-panel my-portfolio-rit">
            <div class="content-panel-close">
                <i class="os-icon os-icon-close"></i>
            </div>
            <div class="element-wrapper">
                <h6 class="element-header">
                    Search
                </h6>
                <div class="element-box-tp">
                    <div class="element-box">
                        <div class="form-group">
                            <label for="">Sector</label>
                            <select class="form-control select2" multiple="true" id="ms_sectors">
                                @foreach($collection_data['sectors'] as $dstatus)
                                <option value="{{$dstatus->id}}">
                                    {{$dstatus->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Country</label>
                            <select class="form-control select2" multiple="true" id="ms_country">
                                @foreach($collection_data['country'] as $dstatus)
                                <option value="{{$dstatus->id}}">
                                    {{$dstatus->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Investment Stage</label>
                            <select class="form-control select2" multiple="true" id="i_stages">
                                @foreach($collection_data['investmentstages'] as $dstatus)
                                <option value="{{$dstatus->id}}">
                                    {{$dstatus->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Investment Size</label>
                            <select class="form-control select2" multiple="true" id="i_sizes">
                                @foreach($collection_data['investmentsizes'] as $dstatus)
                                <option value="{{$dstatus->id}}">
                                    {{$dstatus->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <!--                         <div class="form-group">
                            <label for="">Investment Type</label>
                            <input class="form-control form-control-sm" type="text">
                        </div> -->
                        <div class="form-group">
                            <label for="">Due Diligence Status</label>
                            <select class="form-control select2" multiple="true" id="dd_status">
                                @foreach($collection_data['dd_status'] as $dstatus)
                                <option value="{{$dstatus->id}}">
                                    {{$dstatus->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <!--                         <div class="form-group">
                            <label for="">Audited Financials</label>
                            <input class="form-control form-control-sm" type="text">
                        </div> -->
                        <div class="form-group">
                            <label for="">SDG</label>
                            <select class="form-control select2" multiple="true" id="sdg">
                                @foreach($collection_data['sdgs'] as $dstatus)
                                <option value="{{$dstatus->id}}">
                                    {{$dstatus->name}}
                                </option>
                                @endforeach
                            </select>
                            {{-- <select class="form-control select2" multiple="true">
                                <option selected="true">
                                    Title
                                </option>
                                <option selected="true">
                                    Title
                                </option>
                                <option>
                                    Boston
                                </option>
                                <option>
                                    Texas
                                </option>
                                <option>
                                    Colorado
                                </option>
                            </select> --}}
                        </div>
                        {{-- <a class="btn btn-primary step-trigger-btn" href="#stepContent2">Submit</a> --}}
                        <button class="btn btn-primary step-trigger-btn" onclick='fngetDeals(1);'>Submit</button>
                    </div>
                </div>
            </div>

        </div>
        <!--------------------
          END - Sidebar
          -------------------->
    </div>
</div>



@endsection


@section('scripts')


<script type="text/javascript">
    $(document).on('click', '.pagination a', function (e) {
        debugger;
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fngetDeals(page);
    });


    /*var $ = jQuery;
    jQuery(document).ready(function($){*/
    $(document).ready(function () {
        fngetDeals(1);
    });

    function fngetDeals(page) {
        if (page == null || page == "") {
            page = 1;
        }
        ajaxLoad('/ajax-getdeals', 'divDeals', page);
    }



    function ajaxLoad(route, divname, pageno) {
        debugger;
        var searchtext = $('#txtSearch').val();
        var sortby = $("#sortbyfield option:selected").val();
        var countryids = '';
        var $el = $("#ms_country");
        $el.find('option:selected').each(function () {
            if (countryids == '') {
                countryids = $.trim($(this).val());
            } else {
                countryids = countryids + ',' + $.trim($(this).val());
            }
        });



        var sectorids = '';
        var $e2 = $("#ms_sectors");
        $e2.find('option:selected').each(function () {
            if (sectorids == '') {
                sectorids = $.trim($(this).val());
            } else {
                sectorids = sectorids + ',' + $.trim($(this).val());
            }
        });


        var investmentstages = '';
        var $e3 = $("#i_stages");
        $e3.find('option:selected').each(function () {
            if (investmentstages == '') {
                investmentstages = $.trim($(this).text());
            } else {
                investmentstages = investmentstages + ',' + $.trim($(this).text());
            }
        });

        var investmentsizes = '';
        var $e4 = $("#i_sizes");
        $e4.find('option:selected').each(function () {
            if (investmentsizes == '') {
                investmentsizes = $.trim($(this).text());
            } else {
                investmentsizes = investmentsizes + ',' + $.trim($(this).text());
            }
        });

        var ddstatus = '';
        var $e5 = $("#dd_status");
        $e5.find('option:selected').each(function () {
            if (ddstatus == '') {
                ddstatus = $.trim($(this).text());
            } else {
                ddstatus = ddstatus + ',' + $.trim($(this).text());
            }
        });

        var sdgs = '';
        var $e6 = $("#sdg");
        $e6.find('option:selected').each(function () {
            if (sdgs == '') {
                sdgs = $.trim($(this).val());
            } else {
                sdgs = sdgs + ',' + $.trim($(this).val());
            }
        });

        route = route + '?sectorids=' + sectorids + '&countryids=' + countryids + '&investmentstages=' +
            investmentstages + '&investmentsizes=' + investmentsizes + '&ddstatus=' + ddstatus + '&sdgs=' + sdgs +
            '&page=' + pageno + '&searchtext=' + searchtext + '&sortby=' + sortby;

        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
                debugger;
                $("#" + divname).html('');
                $("#" + divname).html(data);

                var projectboxcount = $('.project-box').length;
                $('#numberofbox').html(projectboxcount);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }




    var timer;
    $("#txtSearch").keyup(function () {
        clearTimeout(timer);
        var ms = 3000; // milliseconds
        var val = this.value;
        timer = setTimeout(function () {
            debugger;
            fngetDeals(1);
        }, ms);
    });

    function fnShowFileUploadModal() {

    }

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

</script>

@endsection
