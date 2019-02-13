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
        <!--
            END - Secondary Top Menu
            -->

            <div aria-labelledby="exampleModalLabel" class="modal fade" id="tender_accept_confirmation_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">
{{trans('view_tender.tender_accept_confirmation_modal_title')}}
                      </h5>
                      <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="form-group">
{{trans('view_tender.tender_accept_confirmation_modal_message')}}
                                                         
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
<button class="btn btn-secondary" data-dismiss="modal" type="button" id="temder_accept_close">{{trans('view_tender.tender_accept_confirmation_modal_btncancel_caption')}}</button>
<button class="btn btn-primary" type="button" onclick="fnAcceptTender();" id="temder_accept_yes">{{trans('view_tender.tender_accept_confirmation_modal_btnyes_caption')}}</button>
                    </div>
                  </div>
                </div>
              </div>



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
                                                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('view_tender.help_btn_hide_caption')}}</button>
                                                </div>
                            </div>
                        </div>
              @endif
              
              
            <div class="os-tabs-w">
              <div class="os-tabs-controls">
                <ul class="nav nav-tabs upper">
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link ot active" data-toggle="tab" onclick="LoadTenders(1);" href="#tab_overview"> {{trans('view_tender.tab_label_open_tenders')}}</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link at" data-toggle="tab" onclick="LoadTenders(1);" href="#tab_sales">{{trans('view_tender.tab_label_accepted_tenders')}}</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link bs" data-toggle="tab" onclick="LoadTenders(1);" href="#tab_sales">{{trans('view_tender.tab_label_bid_submitted')}}</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link ba" data-toggle="tab" onclick="LoadTenders(1);" href="#tab_sales">{{trans('view_tender.tab_label_bid_accepted')}}</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link br" data-toggle="tab" onclick="LoadTenders(1);" href="#tab_sales">{{trans('view_tender.tab_label_bid_rejected')}}</a>
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
              start - View Tender
             -->
            <div class="row">
              <div class="col-sm-12">
                <div class="element-wrapper">
                  <h6 class="element-header">
                   {{-- {{trans('view_tender.title_view_tenders')}} --}}
                   Tenders
                  </h6>
                  <div class="controls-above-table filter-row-top">
                    <div class="row">
                      <div class="col-sm-12">
                        <form class="form-inline justify-content-sm-end">
                          <input class="form-control form-control-sm rounded bright" placeholder="{{trans('view_tender.input_search_placeholder')}}" type="text" id="txtSearch">
                          <select class="form-control form-control-sm rounded bright" id="sortbyfield" onchange="LoadTenders(1);">
                            <option selected="selected" value="">
                              {{trans('view_tender.input_sortby')}}
                            </option>
                            <option value="Name">
                             {{trans('view_tender.input_name')}}
                            </option>
                            <option value="StartDate">
{{trans('view_tender.start_date_option')}}
                            </option>
                            <option value="EndDate">
{{trans('view_tender.end_date_option')}}
                            </option>

                          </select>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!--START - Projects list-->
                  <div class="projects-list projects-list-vk" id="attached_deals">

                     {{-- @include('my_portfolio._attached_deals') --}}

                  </div>
                  <!--END - Projects list-->
                </div>
              </div>
            </div>
            <!--
              END - My Portfolio 
              -->

          </div>
          <!--
            START - Sidebar
            -->
          <div class="content-panel my-portfolio-rit">
            <div class="content-panel-close">
              <i class="os-icon os-icon-close"></i>
            </div>
            <div class="element-wrapper">
              <h6 class="element-header">
                {{trans('my_portfolio.title_search')}}
              </h6>
              <div class="element-box-tp">
                <div class="element-box">
                <div class="form-group">
<label for="">{{trans('view_tender.start_date')}}</label>
                  <input class="form-control" id="t_startdate" placeholder="Start date" type="text" value="">
              </div>
              <div class="form-group">
<label for="">{{trans('view_tender.end_date')}}</label>
                  <input class="form-control" id="t_enddate" placeholder="End date" type="text" value="">
              </div>
              <div class="alert alert-danger form-group" role="alert" id="errorbox" style="display:none;">
              </div>

                  <a class="btn btn-primary step-trigger-btn" href="#" onclick='LoadTenders(1);'>Search</a>
                </div>
              </div>
            </div>

          </div>
          <!--
            END - Sidebar
            -->
        </div>
      </div>
      <input type='hidden' id='tenderid' value="">
    <input type='hidden' id='tc' value="{{$tc}}">
      @endsection


      @section('scripts')
      
      <script type="text/javascript">

       $(document).on('click','.pagination a',function(e){

          e.preventDefault();
         var page=$(this).attr('href').split('page=')[1];
         LoadTenders(page);
        });

      $(document).ready(function(){ 
        $('input[id="t_startdate"]').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            autoApply: true,
onSelect: function(selectedDate) {
  debugger;
var option = this.id == "t_startdate" ? "minDate" : "maxDate",
instance = $(this).data("daterangepicker"),
date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate,
instance.settings);
dates.not(this).datepicker("option", option, date);
}

        });

        $('input[id="t_startdate"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY')); //+ ' - ' + picker.endDate.format('MM/DD/YYYY')
var sdate=$(this).val(picker.startDate.format('DD-MMM-YYYY'))


        });


        $('input[id="t_enddate"]').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
autoApply: true,
onSelect: function(selectedDate) {
  debugger;
var option = this.id = "maxDate",
instance = $(this).data("daterangepicker"),
date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate,
instance.settings);
dates.not(this).datepicker("option", option, date);
}

        });

        $('input[id="t_enddate"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY')); //+ ' - ' + picker.endDate.format('MM/DD/YYYY')
        });
        
        var tc=$('#tc').val();
        if(typeof tc!='undefined' && $.trim(tc)!="" )
        {
          debugger;
          $('.nav-link').removeClass('active');
          $('.'+tc).addClass('active');
        }
    


        LoadTenders(1);
       });

$("#t_enddate").change(function () {
var startDate = document.getElementById("t_startdate").value;
var endDate = document.getElementById("t_enddate").value;

if (startDate !='' && endDate!='') {
if ((Date.parse(startDate) > Date.parse(endDate))) {
 document.getElementById("t_startdate").value = "";
}
}

});

$("#t_startdate").change(function () {
var startDate = document.getElementById("t_startdate").value;
var endDate = document.getElementById("t_enddate").value;

if (startDate !='' && endDate!='') {
if ((Date.parse(startDate) > Date.parse(endDate))) {
  document.getElementById("t_enddate").value = "";
}
}

});

     function LoadTenders(page) {
        debugger;
         if(page==null || page=="")
        {
          page=1;
        }


    
        setTimeout(function(){
    var route='/ajax-get-other-tenders';
    var searchtext=$('#txtSearch').val();
    var sortby=$("#sortbyfield option:selected").val();

        var fromdate = '';
        var todate = '';

            fromdate = $("#t_startdate").val().replace(pattern, "/");
            todate = $("#t_enddate").val().replace(pattern, "/");

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

   var active = 'active';
   var text = $(".nav-link.active").text().toLowerCase();
   var active=text;


  //  route=route+'?sectorids='+sectorids+'&countryids='+countryids+'&investmentstages='+investmentstages+'&investmentsizes='+investmentsizes+'&ddstatus='+ddstatus+'&sdgs='+sdgs+'&page='+pageno+'&searchtext='+searchtext+'&sortby='+sortby;
  route=route+'?page='+page+'&searchtext='+searchtext+'&sortby='+sortby+'&fromdate='+fromdate+'&todate='+todate+'&activetab='+active;
  
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              debugger;
                $("#attached_deals").html('');
                $("#attached_deals").html(data);

              var projectboxcount=$('.project-box').length;
              $('#numberofbox').html(projectboxcount);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            },
            complete: function(){
              Call_ColorChange();
            }
        });
        
        
    }, 1000);
        
        
        
    }


   var timer;
  $("#txtSearch").keyup(function() {
    clearTimeout(timer);
    var ms = 3000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
      LoadTenders(1);
    }, ms);
  });

  function fnOpenConfirmationToAcceptTender(tenderid)
  {
     $('#tenderid').val(tenderid);
  }

  function fnAcceptTender()
  {
    var tid=$('#tenderid').val();
    if(typeof tid=='undefined' || $.trim(tid)=="")
    {
      return;
    }

    var route='/accept-public-tender?tid='+tid;

           $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
                 if(data.message=='Y')
                 {
                  $('#tender_accept_confirmation_modal').modal('hide'); 
                  LoadTenders(1);
                 }
                 else{

                 }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });

  }

      </script>


      @endsection