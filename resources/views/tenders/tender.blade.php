@php
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


    <!--Close tender modal box -->

    <div aria-labelledby="exampleModalLabel" class="modal fade" id="close_tender" role="dialog" tabindex="-1" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Close Tender
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">
                            ×</span></button>
                </div>

                <div class="modal-body">

                    <div class="form-desc">
                        {!!trans('my_tender.popup_close_content')!!}
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="closetender" value="" />
                    <button class="btn btn-secondary" data-dismiss="modal" type="button" onclick="">Cancel</button>
                    <button class="btn btn-primary" type="button" id="close_tender_btn" onclick="closetenderbootstrap();">Close</button>
                </div>


            </div>
        </div>
    </div>


    <!--Code for the modal box   -->


    <div aria-labelledby="exampleModalLabel" class="modal fade" id="new_tender_process" role="dialog" tabindex="-1"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('my_tender.popoup_new_tender_title')}}
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">
                            ×</span></button>
                </div>
                <form id="newtender" method="post" action="/savenewtender" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body" id="div_new_tender">


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button" id="tenants_close" onclick="">{{trans('my_tender.popup_cancel_btn_lbl')}}</button>
                        <button class="btn btn-primary" type="submit" id="savetenats">{{trans('my_tender.popup_save_btn_lbl')}}</button>
                    </div>
                    <div class="alert alert-danger" style="display:none;">Data Saved Successfully</div>
                </form>
            </div>
        </div>
    </div>



    <!-- Assigning the third party -->

    <div aria-labelledby="myLargeModalLabel" id="assign_thirdparty_modal" class="modal fade bd-example-modal-lg" role="dialog"
        tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Invite
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">
                            ×</span></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">


                        <div class="element-box-tp" id="ajaxassignthirdparty">
                            <!--                    <div class="table-responsive">
                            <table class="table table-padded" id="myTable">
                              <thead>
                                <tr>
                                  <th>
                                    Name
                                  </th>
                                  <th>
                                    Assign
                                  </th> 
                                  </tr>
                              </thead>
                              <tbody id="ajaxassignthirdparty">
                                  
                               </tbody>
                              
                              
                            </table>
      
                          </div>-->

                            <!--New code for assign party 9172018 11:53-->
                        </div>


                        <input type='hidden' id='editquesid' value='' />

                    </div>


                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" onclick="assignthirdparty();" id="btnassign" disabled>
                        Invite To Bid</button>
                    <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                </div>
                <div class="alert alert-danger form-group" role="alert" id="errorbox-add-q" style="display:none;margin-top:10px;">
                    {{trans('duediligenceprocess.modal_onblank_question_text_error')}}
                </div>

            </div>
        </div>
    </div>



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
                        {!!trans('my_tender.dashboard_help_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!$helper->GetHelpModifiedText(trans('my_tender.dashboard_help_content'))!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('my_tender.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif

            <div class="os-tabs-w">
                <div class="os-tabs-controls">
                    <ul class="nav nav-tabs upper">
                        <li class="nav-item">
                            <a aria-expanded="false" class="nav-link active" data-toggle="tab" href="#" id="tab_open"
                                onclick="fnLoadTenders('Open','');">{{trans('my_tender.open_tender_menu_title')}}</a>
                        </li>
                        <li class="nav-item">
                            <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#" id="tab_closed"
                                onclick="fnLoadTenders('Closed','');">{{trans('my_tender.close_tender_menu_title')}}</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--END - Control panel above projects-->

    <div class="content-i">
        <div class="content-box">
            <!--
              start - Due Diligence Dashboard
              -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header" id="tm_1">
                            {{trans('my_tender.tender_title')}}
                            <button style="float: right;" class="mr-2 mb-2 btn btn-primary btn-sm btn-pluse"
                                data-toggle="modal" data-target="#new_tender_process" type="button" onclick="fnInitializeNewTender();"
                                id="make_new_tender">
                                {{trans('my_tender.start_tender_btn_caption')}}</button>

                        </h6>

                        <div class="controls-above-table filter-row-top" id="tm_2">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form-inline justify-content-sm-end">
                                        <input class="form-control form-control-sm rounded bright" placeholder="{{trans('my_tender.tender_search_placeholder')}}"
                                            type="text" id="txtSearch">
                                        <select class="form-control form-control-sm rounded bright" id="sortbyfield"
                                            onchange="fnLoadTenders('','');">
                                            <option selected="selected" value="">
                                                {{trans('my_tender.tender_filter_sort_by_label')}}
                                            </option>
                                            <option value="Name">
                                                {{trans('my_tender.tender_filter_name_lbl')}}
                                            </option>
                                            <option value="StartDate">
                                                {{trans('my_tender.tender_filter_start_date_lbl')}}
                                            </option>
                                            <option value="EndDate">
                                                {{trans('my_tender.tender_filter_end_date_lbl')}}
                                            </option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="projects-list projects-list-vk" id="div_tenderlist" style="display:block;">

                        </div>




                        <div class="projects-list projects-list-vk" id="tenderview" style="display:none;">
                            <div class="project-box marbtm">

                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        {{trans('my_tender.popup_edit_title')}}
                                    </h5>
                                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"></button>
                                </div>
                                <form id="edittenderform" method="post" action="/edittender" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="modal-body" id="tenderedit">

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" id="tenants_close" onclick="cancel();">{{trans('my_tender.popup_edit_cancel_btn_caption')}}</button>
                                        <button class="btn btn-primary" type="button" onclick="tenderedit();" id="edittenderbtn"
                                            style="display:block;">{{trans('my_tender.popup_edit_edit_btn_caption')}}</button>
                                        <button class="btn btn-primary" type="submit" id="saveedittenderbtn" style="display:none;"
                                            onclick='saveeditfunc();'>{{trans('my_tender.popup_edit_save_btn_caption')}}</button>

                                        {{-- <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#assign_thirdparty_modal" id="thirdpartyselect" onclick="thirdpartylisting();"
                                            style="display:none;">Invite</button> --}}


                                    </div>
                                    <div class="alert alert-danger" style="display:none;">Data Saved Successfully</div>
                                    <input type="hidden" id="hiddentenderid" name="tenderidhidden" value="" />
                                </form>

                            </div>
                        </div>


                        <div class="projects-list projects-list-vk investor-profile-view" id="tenderviewlist" style="display:none;">


                        </div>

                        <h6 class="element-header" id='bidsarea' style='display:none;'>
                            Bids
                            <span style='float:right;'><button class="btn btn-primary" type="button" data-toggle="modal"
                                    data-target="#assign_thirdparty_modal" id="thirdpartyselect" onclick="thirdpartylisting();"
                                    style="display:none;">Invite</button></span>
                        </h6>


                        <div class="element-box marbtm" id="proposallist" style="display: none;">


                        </div>

                        <div class="projects-list projects-list-vk investor-profile-view" id="singleproposalview" style="display:none;">



                        </div>



                    </div>

                </div>
            </div>
            <!--
              END - Due Diligence Dashboard
             -->
        </div>
        <!--
            START - Sidebar
           -->
        <div class="content-panel my-portfolio-rit" id="tm_3">
            <div class="content-panel-close">
                <i class="os-icon os-icon-close"></i>
            </div>
            <div class="element-wrapper">
                <h6 class="element-header">
                    {{trans('my_tender.search_caption')}}
                </h6>
                <div class="element-box-tp">
                    <div class="element-box">
                        <div class="form-group">
                            <label for="">{{trans('my_tender.search_area_tender_type_lbl')}}</label>
                            <select class="form-control select2" multiple="false" id="tendertype_combo">
                                <option value="Public">
                                    {{trans('my_tender.search_area_tender_public_type')}}
                                </option>
                                <option value="Private">
                                    {{trans('my_tender.search_area_tender_private_type')}}
                                </option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">{{trans('my_tender.search_area_start_date_lbl')}}</label>
                            <input class="form-control" id="t_startdate" placeholder=" {{trans('my_tender.search_area_start_date_lbl')}}"
                                type="text" value="">
                            {{-- <input class="form-control calendar-icon" id="t_startdate" placeholder=" " type="text"
                                value=""> --}}
                        </div>
                        <div class="form-group">
                            <label for="">{{trans('my_tender.search_area_end_date_lbl')}}</label>
                            <input class="form-control" id="t_enddate" placeholder="{{trans('my_tender.search_area_end_date_lbl')}}"
                                type="text" value="">
                            {{-- <input class="form-control calendar-icon" id="t_enddate" placeholder="End date" type="text"
                                value=""> --}}
                        </div>
                        <div class="alert alert-danger form-group" role="alert" id="errorbox" style="display:none;">
                        </div>
                        <a class="btn btn-primary step-trigger-btn" href="#" onclick="fnLoadTenders('','');">{{trans('my_tender.search_submit_btn_lbl')}}</a>
                    </div>
                </div>
            </div>

        </div>

        <!--
            END - Sidebar
            -->
    </div>
</div>


<input type="hidden" , id="selectedcompanyid" value='' />
<input type="hidden" , id="selectedtype" value='' />
<input type="hidden" id="hiddentenderid1" value="">
<input type="hidden" id="hiddendealid" value="">
<input type="hidden" id="openclosevalues" value="">


@endsection


@section('scripts')
<script type="text/javascript">
    function saveeditfunc() {
        $("#edittenderform").submit(function (e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var tendername = $('#tender_name_edit').val();
            var startdate = $('#start_date_edit').val();
            var enddate = $('#end_date_edit').val();
            var description = $('#description_edit').val();
            var privatepublic = $('#pri_pub_compbo_edit').val();
            var deallist = $('#deallistview').val();
            var file1 = $('#import_file').prop('files')[0]
            var file2 = $('#import_file1').prop('files')[0]
            var tenderid = $('#hiddentenderid').val();
            var services_requested = $('#services_requested').val();
            var desired_time_frame = $('#desired_time_frame').val();
            var resource_requirements = $('#resource_requirements').val();
            var approx_budget = $('#approx_budget').val();

            var formdata = new FormData();
            formdata.append("tendername", tendername);
            formdata.append("startdate", startdate);
            formdata.append("enddate", enddate);
            formdata.append("description", description);
            formdata.append("privatepublic", privatepublic);
            formdata.append("deallist", deallist);
            formdata.append("file1", file1);
            formdata.append("file2", file2);
            formdata.append("tenderid", tenderid);
            formdata.append("services_requested", services_requested);
            formdata.append("desired_time_frame", desired_time_frame);
            formdata.append("resource_requirements", resource_requirements);
            formdata.append("approx_budget", approx_budget);
            formdata.append("_token", '{{csrf_token()}}');

            $('#tenderview').hide();
            $.ajax({
                url: '/edittender',
                type: "POST",
                contentType: false,
                processData: false,
                data: formdata,
                cache: false,
                timeout: 100000,
                success: function (data) {
                    debugger;




                    if (data.status == 'Open') {
                        if (data.type == "Private") {
                            $('#thirdpartyselect').show();
                        } else {
                            $('#thirdpartyselect').hide();
                        }
                    } else {
                        $('#thirdpartyselect').hide();
                    }



                    $('#tenderviewlist').html(data.view);
                    $('#tenderviewlist').show();

                },
                error: function (err, result) {


                }
            });



        });
    }


    function fnInitializeNewTender() {
        $.get('/get-new-tender-form', function (data) {
            $('#div_new_tender').html(data);

            $('input[id="start_date"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                autoApply: true

            });

            $('input[id="start_date"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY')); //+ ' - ' + picker.endDate.format('MM/DD/YYYY')
            });


            $('input[id="end_date"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                autoApply: true

            });

            $('input[id="end_date"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.endDate.format('DD-MMM-YYYY')); //+ ' - ' + picker.endDate.format('MM/DD/YYYY')
            });

            // $('#mydeals').select2({
            //     ajax: {
            //         url: function (params) {
            //             var st = params.term;
            //             if (typeof st != 'undefined' && $.trim(st) != '') {
            //                 $.get('/fetchdealdata?filter=' + params.term, function (data) {
            //                     debugger;
            //                     $('#mydeals').empty();
            //                     $('#mydeals').select2({
            //                         data: $.parseJSON(data)
            //                     });
            //                 });
            //             } else {
            //                 var myst = '';
            //                 $.get('/fetchdealdata?filter=' + myst, function (data) {
            //                     debugger;
            //                     $('#mydeals').empty();
            //                     $('#mydeals').select2({
            //                         data: $.parseJSON(data)
            //                     });
            //                 });
            //             }


            //         }
            //     }
            // });


            $('#mydeals').select2({
                placeholder: "Type Deal Name ...",
                minimumInputLength: 0,
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: '/fetchdealdata',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });



        });



    }







    function Load_Deals_OnKeyUp() {

    }







    $(document).ready(function () {

        $('input[id="t_startdate"]').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            autoApply: true

        });

        $('input[id="t_startdate"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY')); //+ ' - ' + picker.endDate.format('MM/DD/YYYY')
        });


        $('input[id="t_enddate"]').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            autoApply: true

        });

        $('input[id="t_enddate"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY')); //+ ' - ' + picker.endDate.format('MM/DD/YYYY')
        });

        debugger;
        fnLoadTenders('', '1');
    });






    function fnLoadTenders(text, onload) {
        debugger;
        //Implementation of hide and show btn


        //

        if (text == "Open") {
            $('#openclosevalues').val("open");
        } else if (text == "Closed") {
            $('#openclosevalues').val("close");

        } else if (text == "") {
            var openclosenow = $('#openclosevalues').val();
            if (openclosenow.length == 0) {
                $('#openclosevalues').val("open");
            }

        }
        debugger;
        var getvalfromopenclose = $('#openclosevalues').val();
        if (getvalfromopenclose == "open") {
            $('#make_new_tender').show();
            $('.close-tender').show();
            //    $('.view-tender').show();
        } else if (getvalfromopenclose == "close") {


            function explode() {
                $('#make_new_tender').hide();
                $('.close-tender').hide();
                //    $('.view-tender').hide();
                //    $('.vt_onclose_tender').show();

            }
            setTimeout(explode, 3000);

        }

        if (text == '') {
            text = $(".nav-link.active").text().toLowerCase();
            if (text == 'open tenders') {
                text = 'Open';


            } else {
                text = 'Closed';



            }


        }




        var fromdate = '';
        var todate = '';

        if (onload == '1') {

        } else {
            fromdate = $("#t_startdate").val().replace(pattern, "/");
            todate = $("#t_enddate").val().replace(pattern, "/");
        }
        var pattern = /[-]+/g;

        if (fromdate != "" || todate != "") {
            date1 = new Date(fromdate);
            date2 = new Date(todate);
            if (date1 > date2) {
                var $messageDiv = $('#errorbox'); // get the reference of the div
                $messageDiv.show().html('Start date can not be bigger than to To Date. Please select valid dates.'); // show and set the message
                setTimeout(function () {
                    $messageDiv.hide().html('');
                }, 3000); // 3 seconds later, hide
                return;
            }
        }

        var tendertypes = '';
        var $el = $("#tendertype_combo");
        $el.find('option:selected').each(function () {

            if (tendertypes == '') {
                tendertypes = $.trim($(this).val());
            } else {
                tendertypes = tendertypes + ',' + $.trim($(this).val());
            }

        });




        var searchtext = $('#txtSearch').val();
        var sortby = $("#sortbyfield option:selected").val();
        var route = '/ajax-get-my-tenders';

        route = route + '?searchtext=' + searchtext + '&sortby=' + sortby + '&type=' + text + '&fdate=' + fromdate +
            '&tdate=' + todate + '&tendertypes=' + tendertypes;

        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
                debugger;
                $("#div_tenderlist").html('');
                $("#div_tenderlist").html(data);
                $("#div_tenderlist").show();
                $('#tm_1').show();
                $('#tm_2').show();
                $('#tm_3').show();

                $('#thirdpartyselect').hide();
                $('#tenderviewlist').hide();
                $('#bidsarea').hide();
                $('#proposallist').hide();
                $('#singleproposalview').hide();
                $('#tenderview').hide();






            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            },
            complete: function () {
                Call_ColorChange();
            }



        });

    }

    var timer;
    $("#txtSearch").keyup(function () {
        clearTimeout(timer);
        var ms = 3000; // milliseconds
        var val = this.value;
        timer = setTimeout(function () {
            fnLoadTenders('', '');
        }, ms);
    });




    function checkend() {
        var startdate = $('#start_date').val();
        var enddate = $('#end_date').val();

        if (new Date(enddate) <= new Date(startdate)) {
            $('#end_date').val('');
            alert('start date must be less than end date');
        }
    }


    function opentender(tender, dealid) {


        $('#tm_1').hide();
        $('#tm_2').hide();
        $('#tm_3').hide();
        $('#div_tenderlist').hide();


        $("#hiddentenderid").val(tender);
        $("#hiddentenderid1").val(tender);
        $("#hiddendealid").val(dealid);


        // New Chenges 9172018 12:24
        $.get('/genttenderviewfromtenderid?tenderid=' + tender, function (data) {
            var typeda = data.type;
            if (data.status == 'Open') {
                if (typeda == "Private") {
                    $('#thirdpartyselect').show();
                }
            }

            $('#tenderviewlist').html(data.view);
            $('#tenderviewlist').show();
            $('#bidsarea').show();


        });




        $.get('/gettenderview?tenderid=' + tender, function (data) {

            $('#tenderlist').hide();
            $('#proposallist').show();
            $('#tenderedit').html(data.view1);
            $('#proposallist').html(data.view2);

            var tendertype = $('#tendertype').val();
            // if (tendertype == "Private") {
            //     $('#thirdpartyselect').show();
            // } else {
            //     $('#thirdpartyselect').hide();
            // }


        });


    }

    function closetender(tender) {

        $('#close_tender').modal('toggle');
        $('#closetender').val(tender);
    }

    function closetenderbootstrap() {
        var tender = $('#closetender').val();
        $.get('/closetender?tender=' + tender, function (data) {
            //           location.reload();       
            fnLoadTenders('Closed', '');
            $('#tab_open').removeClass('active');
            $('#tab_closed').addClass('active');
            $('#close_tender').modal('toggle');
        });

    }


    function tenderedit() {
        $("#tender_name_edit").prop("disabled", false);
        $("#start_date_edit").prop("disabled", false);
        $("#end_date_edit").prop("disabled", false);
        $("#description_edit").prop("disabled", false);
        $("#pri_pub_compbo_edit").prop("disabled", false);
        $("#deallistview").prop("disabled", false);
        $("#deallistview").select2();
        $("#edittenderbtn").hide();
        $("#saveedittenderbtn").show();
    }

    function cancel() {
        $('#tenderviewlist').show();
        $("#tender_name_edit").prop("disabled", true);
        $("#start_date_edit").prop("disabled", true);
        $("#end_date_edit").prop("disabled", true);
        $("#description_edit").prop("disabled", true);
        $("#pri_pub_compbo_edit").prop("disabled", true);

        $("#edittenderbtn").show();
        $("#saveedittenderbtn").hide();
        $('#tenderview').hide();


    }

    function thirdpartylisting() {
        $('#btnassign').prop('disabled', false);
        var selectoptionoutside = "b5aa1d";
        var valout = "";
        $.get('/fetchthirdpartyusers', function (data) {
            $('#ajaxassignthirdparty').html('');
            $('#ajaxassignthirdparty').html(data);
            debugger;
            var selectoption = "b5aa1d";
            var searchval = "";
            fntxtfilter(searchval, selectoption);



            function fntxtfilter(searchval, selectoption) {
                debugger;
                var tenderid = $('#hiddentenderid1').val();
                $.get('/fetchcompanydata?filter=' + searchval + '&selectoption=' + selectoption + '&tenderid=' +
                    tenderid,
                    function (data) {
                        var data1 = $.parseJSON(data);
                        $('#myselect').select2({
                            data: data1
                        });
                    });
            }

        })



    }

    var putcheckboxid;

    function assigncount() {
        putcheckboxid = [];
        $.each($(".selectuser:checked"), function () {
            putcheckboxid.push($(this).val());
        });
        if (putcheckboxid.length > 0) {
            $('#btnassign').prop('disabled', false);
        } else {
            $('#btnassign').prop('disabled', true);
        }
        alert(putcheckboxid);
    }

    function assignthirdparty() {

        debugger;
        putcheckboxid = $('#myselect').select2('val'); //$('#myselect').val();
        var selections = (JSON.stringify(putcheckboxid));

        if (putcheckboxid.length > 0) {
            var tenderid = $('#hiddentenderid').val();
            var dealid = $('#hiddendealid').val();
            var putcheckboxid = JSON.stringify(putcheckboxid);
            $('#btnassign').prop('disabled', true);
            $.get('/sendthirdparty?checkboxarr=' + putcheckboxid + '&tenderid=' + tenderid + '&dealid=' + dealid,
                function (data) {

                    $('#assign_thirdparty_modal').modal('toggle');
                    $('#proposallist').html(data);
                });

        }
    }

    function uploadproposaldocs(proposalid) {

        debugger;

        $("#saveproposaldocs" + proposalid).submit(function (event) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var importFiles = $('#import_proposal' + proposalid).prop('files')[0];
            var tenderid = $("#hiddentenderid1").val();
            var formData = new FormData();
            formData.append("_token", '{{csrf_token()}}');
            formData.append("proposalid", proposalid);
            formData.append("tenderid", tenderid);

            formData.append('uploadFiles', importFiles);
            $.ajax({
                url: '/saveproposaldocs',
                type: "POST",
                contentType: false,
                processData: false,
                data: formData,
                cache: false,
                timeout: 100000,
                success: function (data) {

                    $('#proposallist').html(data);

                },
                error: function (message) {

                },

            });


            event.preventDefault();

        });
    }



    function viewproposal(proposalid, companyname) {

        $('#singleproposalview').show();
        $.get('/singleproposalview?proposalid=' + proposalid + '&companyname=' + companyname, function (data) {
            $('#singleproposalview').html(data);
        });
    }

    function edittender(tender) {
        $('#tenderviewlist').hide();

        $.get('/gettenderview?tenderid=' + tender, function (data) {




            $('#tenderedit').html(data.view1);
            $('#tenderview').show();





            tenderedit();

            $('input[id="start_date_edit"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                autoApply: true

            });

            $('input[id="start_date_edit"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY')); //+ ' - ' + picker.endDate.format('MM/DD/YYYY')
            });


            $('input[id="end_date_edit"]').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                autoApply: true

            });

            $('input[id="end_date_edit"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.endDate.format('DD-MMM-YYYY')); //+ ' - ' + picker.endDate.format('MM/DD/YYYY')
            });

            $('#deallistview').select2({
                ajax: {
                    url: function (params) {

                        var st = params.term;

                        if (typeof st != 'undefined' && $.trim(st) != '') {
                            $.get('/fetchdealdata?filter=' + params.term, function (data) {
                                debugger;
                                $('#deallistview').empty();
                                $('#deallistview').select2({
                                    data: $.parseJSON(data)
                                });
                                // var d=$.parseJSON(data); 
                                // return  d;
                            });
                        } else {

                            $('#deallistview').empty();
                        }


                    }
                }
            });


            // var tendertype = $('#tendertype').val();
            // if (tendertype == "Private") {
            //     $('#thirdpartyselect').show();
            // } else {
            //     $('#thirdpartyselect').hide();
            // }


        });

    }

    var companytype = "b5aa1d";
    var searchval = "";

    function selectoptioncomp(company) {
        companytype = company;
        fntxtfilterouter(searchval, companytype);
    }

    var timer;

    function runsearch() {
        clearTimeout(timer);
        var ms = 3000;
        var value = $("#txtSearch").val();
        timer = setTimeout(function () {
            searchval = value;

            fntxtfilterouter(searchval, companytype);
        }, ms);
    }







    function fntxtfilterouter(searchval, selectoption) {
        debugger;
        var tenderid = $('#hiddentenderid1').val();
        $.get('/fetchcompanydata?filter=' + searchval + '&selectoption=' + selectoption + '&tenderid=' + tenderid,
            function (data) {
                $('#myselect').empty();
                $('#myselect').select2({
                    data: $.parseJSON(data)
                });
            });
    }




    function acceptbid(proposalbid) {

        $.get('/acceptbid?proposalid=' + proposalbid, function (data) {


            opentender(data.tenderid, data.dealid);

        })

    }

    function rejectbid(proposalbid) {
        debugger;
        $.get('/rejectbid?proposalid=' + proposalbid, function (data) {

            opentender(data.tenderid, data.dealid);
        })
    }
</script>

@endsection