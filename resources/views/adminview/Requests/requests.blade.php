@extends('adminview.layouts.app_layout', ['layout' => 'left_side_menu'])
@section('content')

<div class="content-w portfolio-custom-vk">
    <!--
     START - Secondary Top Menu
     -->
    @include('adminview.shared._top_menu')

    <div aria-labelledby="exampleModalLabel" class="modal fade" id="Accept_Confirmation_Modal" role="dialog" tabindex="-1"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Verify Tenant
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">
                            ×</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    This will allow the tenant to login and manage its own companies and users. Do you
                                    want to continue?
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button" id="previousreply_close">Cancel</button>
                    <button class="btn btn-primary" type="button" onclick="fnverifytenant();" id="btnAllowAccess">Yes</button>
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
                        Decline Tenant Request
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">
                            ×</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    This action will delete the requested tenant. Do you want to continue?
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button" id="previousreply_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                    <button class="btn btn-primary" type="button" onclick="fndeclinetenant();" id="btncompany_del_yes">{{trans('duediligenceprocess.btn_caption_yes')}}</button>
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
            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            New Tenant Requests
                        </h6>

                        <div class="controls-above-table filter-row-top">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form-inline justify-content-sm-end">
                                        <input class="form-control form-control-sm rounded bright" placeholder="Search"
                                            type="text" id="txtTenantSearch">
                                        <select class="form-control form-control-sm rounded bright" id="tenant_sortbyfield"
                                            onchange="fngetTenantRequests();">
                                            <option selected="selected" value="">
                                                Sort By
                                            </option>
                                            <option value="name">
                                                Tenant
                                            </option>
                                        </select>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--START - Friend Requests list-->
                        <div class="projects-list projects-list-vk" id="divTenantRequests">


                        </div>
                        <!--END - Friend Requests list-->

                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            Tenant Request History
                        </h6>

                        <div class="controls-above-table filter-row-top">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form-inline justify-content-sm-end">
                                        <input class="form-control form-control-sm rounded bright" placeholder="Search"
                                            type="text" id="txtTenantSearch_history">
                                        <select class="form-control form-control-sm rounded bright" id="tenant_sortbyfield_history"
                                            onchange="fngetTenantRequests_history();">
                                            <option selected="selected" value="">
                                                Sort By
                                            </option>
                                            <option value="name">
                                                Tenant
                                            </option>
                                        </select>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--START - Friend Request History-->
                        <div class="projects-list projects-list-vk" id="divTenantRequests_history">


                        </div>
                        <!--END - Friend Requests History-->

                    </div>
                </div>
            </div>




        </div>

        <!-- Start Side Bar From Here-->
    </div>
</div>

<input type="hidden" id="type" value="" />
<input type="hidden" id="tenantid" value="" />

@endsection


@section('scripts')

<script type="text/javascript">
    $(document).ready(function () {
        fngetTenantRequests();
        fngetTenantRequests_history();
    });

    function fngetTenantRequests() {
        ajaxLoad('/get-tenant-requests', 'divTenantRequests', 'Tenant');
    }

    function fngetTenantRequests_history() {
        ajaxLoad('/tenant-request-history', 'divTenantRequests_history', 'Tenant_history');
    }



    function ajaxLoad(route, divname, type) {

        var searchtext = "";
        var sortby = "";

        switch (type) {
            case 'Tenant':
                searchtext = $('#txtTenantSearch').val();
                sortby = $("#tenant_sortbyfield option:selected").val();
                break;
            case 'Tenant_history':
                searchtext = $('#txtTenantSearch_history').val();
                sortby = $("#tenant_sortbyfield_history option:selected").val();
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
    $("#txtTenantSearch").keyup(function () {
        clearTimeout(timer);
        var ms = 2000; // milliseconds
        var val = this.value;
        timer = setTimeout(function () {

            fngetTenantRequests();
        }, ms);
    });

    $("#txtTenantSearch_history").keyup(function () {
        clearTimeout(timer);
        var ms = 2000; // milliseconds
        var val = this.value;
        timer = setTimeout(function () {

            fngetTenantRequests_history();
        }, ms);
    });


    function OpenAcceptPopup(type, tenantid) {
        $('#type').val(type);
        $('#tenantid').val(tenantid);

        $('#Accept_Confirmation_Modal').modal('show');
    }

    function OpenDeclinePopup(type, tenantid) {
        $('#type').val(type);
        $('#tenantid').val(tenantid);

        $('#remove_company_modal').modal('show');
    }

    //Process Related Functions.......
    function fnverifytenant() {

        var type = $('#type').val();
        var tenantid = $('#tenantid').val();

        if (typeof tenantid == 'undefined' || typeof type == 'undefined') {
            return;
        }
        var route = "/accept-decline-new-tenant-request?tenantid=" + tenantid + "&type=" + type;
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {

                if (data.message == 'Success') {
                    $('#Accept_Confirmation_Modal').modal('hide');
                    fngetTenantRequests();
                    fngetTenantRequests_history();
                } else {}
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }



    function fndeclinetenant() {

        var type = $('#type').val();
        var tenantid = $('#tenantid').val();

        if (typeof tenantid == 'undefined' || typeof type == 'undefined') {
            return;
        }
        var route = "/accept-decline-new-tenant-request?tenantid=" + tenantid + "&type=" + type;
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {

                if (data.message == 'Success') {
                    $('#remove_company_modal').modal('hide');
                    fngetTenantRequests();
                    fngetTenantRequests_history();
                } else {}
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

</script>

@endsection
