@extends('tenants.layouts.app_layout', ['layout' => 'left_side_menu_tenant'])
@section('content')

<div class="content-w portfolio-custom-vk">
    <!--
     START - Secondary Top Menu
     -->
    @include('tenants.shared._top_menu_tenant')

    <div aria-labelledby="exampleModalLabel" class="modal fade" id="Accept_Confirmation_Modal" role="dialog" tabindex="-1"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Verify Company
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">
                            ×</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    This will allow the company to login and view the resources. Do you want to
                                    continue?
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button" id="previousreply_close">Cancel</button>
                    <button class="btn btn-primary" type="button" onclick="fnverifycompany();" id="btnAllowAccess">Yes</button>
                </div>
            </div>
        </div>
    </div>


    <div aria-labelledby="exampleModalLabel" class="modal fade" id="remove_company_modal" role="dialog" tabindex="-1"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Decline Company Request
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">
                            ×</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    This action will delete the requested company. Do you want to continue?
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button" id="previousreply_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                    <button class="btn btn-primary" type="button" onclick="fndeclinecompany();" id="btncompany_del_yes">{{trans('duediligenceprocess.btn_caption_yes')}}</button>
                </div>
            </div>
        </div>
    </div>



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
                        {!!trans('pending_requests.help_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!trans('pending_requests.help_content')!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('pending_requests.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            New Company Requests
                        </h6>

                        <div class="controls-above-table filter-row-top">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form-inline justify-content-sm-end">
                                        <input class="form-control form-control-sm rounded bright" placeholder="Search"
                                            type="text" id="txtCompanySearch">
                                        <select class="form-control form-control-sm rounded bright" id="company_sortbyfield"
                                            onchange="fngetCompanyRequests();">
                                            <option selected="selected" value="">
                                                Sort By
                                            </option>
                                            <option value="name">
                                                Company
                                            </option>
                                            <option value="type">
                                                Company Type
                                            </option>
                                        </select>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--START - Friend Requests list-->
                        <div class="projects-list projects-list-vk" id="divCompanyRequests">


                        </div>
                        <!--END - Friend Requests list-->

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            Company Request History
                        </h6>

                        <div class="controls-above-table filter-row-top">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form-inline justify-content-sm-end">
                                        <input class="form-control form-control-sm rounded bright" placeholder="Search"
                                            type="text" id="txtCompanySearch_history">
                                        <select class="form-control form-control-sm rounded bright" id="company_sortbyfield_history"
                                            onchange="fngetCompanyRequests_history();">
                                            <option selected="selected" value="">
                                                Sort By
                                            </option>
                                            <option value="name">
                                                Company
                                            </option>
                                            <option value="type">
                                                Company Type
                                            </option>
                                        </select>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--START - Friend Requests History list-->
                        <div class="projects-list projects-list-vk" id="divCompanyRequests_history">


                        </div>
                        <!--END - Friend Requests History list-->

                    </div>
                </div>
            </div>




        </div>

        <!-- Start Side Bar From Here-->
    </div>
</div>

<input type="hidden" id="pipelinedealid" value="" />
<input type="hidden" id="type" value="" />
<input type="hidden" id="companyid" value="" />
<input type="hidden" id="deleteme" value="">
{{-- <input type="hidden" id="is_admin" value="{{$Is_AdminUser}}"> --}}

@endsection


@section('scripts')

<script type="text/javascript">
    $(document).ready(function () {
        fngetCompanyRequests();
        fngetCompanyRequests_history();
    });

    function fngetCompanyRequests() {
        ajaxLoad('/get-company-requests', 'divCompanyRequests', 'Company');
    }

    function fngetCompanyRequests_history() {
        ajaxLoad('/company-request-history', 'divCompanyRequests_history', 'Company_History');
    }



    function ajaxLoad(route, divname, type) {

        var searchtext = "";
        var sortby = "";

        switch (type) {
            case 'Company':
                searchtext = $('#txtCompanySearch').val();
                sortby = $("#company_sortbyfield option:selected").val();
                break;

            case 'Company_History':
                searchtext = $('#txtCompanySearch_history').val();
                sortby = $("#company_sortbyfield_history option:selected").val();
                break;
        }


        route = route + '?searchtext=' + searchtext + '&sortby=' + sortby;

        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {


                $("#" + divname).html('');
                $("#" + divname).html(data);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    var timer;
    $("#txtCompanySearch").keyup(function () {
        clearTimeout(timer);
        var ms = 2000; // milliseconds
        var val = this.value;
        timer = setTimeout(function () {

            fngetCompanyRequests();
        }, ms);
    });

    $("#txtCompanySearch_history").keyup(function () {
        clearTimeout(timer);
        var ms = 2000; // milliseconds
        var val = this.value;
        timer = setTimeout(function () {
            fngetCompanyRequests_history();
        }, ms);
    });

    function OpenAcceptPopup(type, companyid) {
        $('#type').val(type);
        $('#companyid').val(companyid);

        $('#Accept_Confirmation_Modal').modal('show');
    }

    function OpenDeclinePopup(type, companyid) {
        $('#type').val(type);
        $('#companyid').val(companyid);

        $('#remove_company_modal').modal('show');
    }

    //Process Related Functions.......
    function fnverifycompany() {

        var type = $('#type').val();
        var companyid = $('#companyid').val();

        if (typeof companyid == 'undefined' || typeof type == 'undefined') {
            return;
        }
        var route = "/accept-decline-new-company-request?companyid=" + companyid + "&type=" + type;
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {

                if (data.message == 'Success') {
                    $('#Accept_Confirmation_Modal').modal('hide');
                    fngetCompanyRequests();
                    fngetCompanyRequests_history();
                } else {}
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }



    function fndeclinecompany() {

        var type = $('#type').val();
        var companyid = $('#companyid').val();

        if (typeof companyid == 'undefined' || typeof type == 'undefined') {
            return;
        }
        var route = "/accept-decline-new-company-request?companyid=" + companyid + "&type=" + type;
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {

                if (data.message == 'Success') {
                    $('#remove_company_modal').modal('hide');
                    fngetCompanyRequests();
                    fngetCompanyRequests_history();
                } else {}
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

</script>

@endsection
