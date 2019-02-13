@php 
$helper=\App\Helpers\AppHelper::instance();
$newdealcontent=$helper->GetHelpModifiedText(trans('my_deal.create_deal'));
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
    <!--START - Control panel above projects-->
        <div class="content-i control-panel">
          <div class="content-box-tb">
              
                  @if((session('helpview')!=null))
                      <div class="element-wrapper" id='helpform'>
                            <div class="element-box">
                                            <h5 class="form-header">
                                                   {!!trans('my_deal.help_title')!!}   
                                                </h5>
                                                <div class="form-desc">
                                                   {!!trans('my_deal.help_content')!!}
                                                </div>
                                                <div class="element-box-content example-content">
                                                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('my_deal.help_btn_hide_caption')}}</button>
                                                </div>
                            </div>
                        </div>
                  @endif
              
              
              
              
              
            <div class="os-tabs-w">
              <div class="os-tabs-controls">
                <ul class="nav nav-tabs upper" id="dealactive">
                  <li class="nav-item" >
                    <a aria-expanded="false" id="active" class="nav-link active" data-toggle="tab" href="#tab_overview" onclick="fngetDeals(1);"> Active</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" id="inactive" class="nav-link" data-toggle="tab" href="#tab_sales" onclick="fngetDeals(1);" > Inactive</a>
                  </li>
                  <li class="nav-item">
                      <a aria-expanded="false" id="archieved" class="nav-link" data-toggle="tab" href="#tab_sales" onclick="fngetDeals(1);" > Archive</a>
                  </li>
                </ul>
                  <input type="hidden" id="deallink">
                {{-- <ul class="nav nav-pills smaller d-none d-lg-flex">
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#"> Today</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#"> 7 Days</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#"> 14 Days</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#"> Last Month</a>
                  </li>
                </ul> --}}
              </div>
            </div>
          </div>
        </div>
        <!--END - Control panel above projects-->

    <div class="content-i">
        <div class="content-box">
            <!--
              start - Enterprise Pipeline
              -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                        {{trans('my_deal.title')}}
                        </h6>

                        <div class="controls-above-table filter-row-top">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form-inline justify-content-sm-end">
                                        <input class="form-control form-control-sm rounded bright" placeholder="{{trans('my_deal.search_title')}}" type="text" id="txtSearch">
                                        <select class="form-control form-control-sm rounded bright" id="sortbyfield" onchange="fngetDeals(1);">
                                            <option selected="selected" value="">
                                                {{trans('my_deal.sort_option_title')}}
                                            </option>
                                            <option value="projectname">
                                                {{trans('my_deal.sort_option_project')}}
                                            </option>
                                            <option value="totalinvestment">
                                                {{trans('my_deal.sort_option_investment')}}
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
            <!--
              END - Enterprise Pipeline
              -->
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
        <!--
          START - Sidebar
         -->
        <div class="content-panel my-portfolio-rit">
            <div class="content-panel-close">
                <i class="os-icon os-icon-close"></i>
            </div>
            <div class="element-wrapper">
                <h6 class="element-header">
                    {{trans('my_deal.search_title')}}
                </h6>
                <div class="element-box-tp">
                    <div class="element-box">
<!--                        <div class="form-group">
                            <label for="">Sector</label>
                            <select class="form-control select2" multiple="true" id="ms_sectors">
                                @foreach($collection_data['sectors'] as $dstatus)
                                 <option value="{{$dstatus->id}}">
                                      {{$dstatus->name}}
                                  </option>
                                @endforeach
                              </select>
                        </div>-->
<!--                        <div class="form-group">
                            <label for="">Country</label>
                            <select class="form-control select2" multiple="true" id="ms_country">
                                @foreach($collection_data['country'] as $dstatus)
                                 <option value="{{$dstatus->id}}">
                                      {{$dstatus->name}}
                                  </option>
                                @endforeach
                              </select>
                        </div>-->
                        
                        <div class="form-group">
                            <label for="">{{trans('my_deal.select_investment_size_label')}}</label>
                            <select class="form-control select2" multiple="true" id="i_sizes">
                                @foreach($collection_data['investmentsizes'] as $dstatus)
                                 <option value="{{$dstatus->id}}">
                                      {{$dstatus->name}}
                                  </option>
                                @endforeach
                              </select>
                        </div>
                       
                         {{-- <div class="form-group">
                            <label for="">Total View Count</label>
                            <select class="form-control select2" multiple="true" id="ms_tvc">
                                @if(isset($collection_data['totalviewcount']) && !empty($collection_data['totalviewcount']))
                                @foreach($collection_data['totalviewcount'] as $dstatus)
                                 @if(isset($dstatus->totalview) && !empty($dstatus->totalview))
                                 <option value="{{$dstatus->totalview}}">
                                      {{$dstatus->totalview}}
                                  </option>
                                  @endif
                                @endforeach
                                @endif
                              </select>
                        </div> --}}

                         {{-- <div class="form-group">
                            <label for="">Project Name</label>
                            <select class="form-control select2" multiple="true" id="ms_projectname">
                                    @if(isset($collection_data['projectname']) && !empty($collection_data['projectname']))
                                @foreach($collection_data['projectname'] as $dstatus)
                                @if(isset($dstatus->projectname) && !empty($dstatus->projectname))
                                 <option value="{{$dstatus->projectname}}">
                                      {{$dstatus->projectname}}
                                  </option>
                                @endif
                                @endforeach
                                @endif
                               
                              </select>
                        </div> --}}

                         <div class="form-group">
                            <label for="">{{trans('my_deal.select_project_stage_label')}}</label>
                            <select class="form-control select2" multiple="true" id="ms_projectstage">
                                
                                @foreach($collection_data['projectstage'] as $dstatus)
                                @if(isset($dstatus->projectstage) && !empty($dstatus->projectstage))
                                 <option value="{{$dstatus->projectstage}}">
                                      {{$dstatus->projectstage}}
                                  </option>
                                @endif
                                @endforeach
                               
                              </select>
                        </div>
                     
                         <div class="form-group">
                            <label for="">{{trans('my_deal.select_investment_structure_label')}}</label>
                            <select class="form-control select2" multiple="true" id="ms_projectstructure">
                                
                                @foreach($collection_data['projectstructure'] as $dstatus)
                                @if(isset($dstatus->projectstructure) && !empty($dstatus->projectstructure))
                                 <option value="{{$dstatus->projectstructure}}">
                                      {{$dstatus->projectstructure}}
                                  </option>
                                @endif
                                @endforeach
                               
                              </select>
                        </div>


                      <div class="form-group">
                            <label for="">{{trans('my_deal.select_requested_investment_label')}}</label>
                            <select class="form-control select2" multiple="true" id="ms_projectinvestmentpurpose">
                                
                                @foreach($collection_data['investmentpurpose'] as $dstatus)
                                @if(isset($dstatus->investmentpurpose) && !empty($dstatus->investmentpurpose))
                                 <option value="{{$dstatus->investmentpurpose}}">
                                      {{$dstatus->investmentpurpose}}
                                  </option>
                                @endif
                                @endforeach
                               
                              </select>
                        </div>


<!--                         <div class="form-group">
                            <label for="">Proposed Uses Of Funds</label>
                            <select class="form-control select2" multiple="true" id="ms_proposedfunds">
                                
                                @foreach($collection_data['proposedfunds'] as $dstatus)
                                @if(isset($dstatus->proposedusesoffunds) && !empty($dstatus->proposedusesoffunds))
                                 <option value="{{$dstatus->proposedusesoffunds}}">
                                      {{$dstatus->proposedusesoffunds}}
                                  </option>
                                @endif
                                @endforeach
                               
                              </select>
                        </div>     -->

<!--                         <div class="form-group">
                            <label for="">Investment Type</label>
                            <input class="form-control form-control-sm" type="text">
                        </div> -->
                       
<!--                         <div class="form-group">
                            <label for="">Audited Financials</label>
                            <input class="form-control form-control-sm" type="text">
                        </div> -->
                     



                       
                        {{-- <a class="btn btn-primary step-trigger-btn" href="#stepContent2">Submit</a> --}}
                        <button class="btn btn-primary step-trigger-btn" onclick='fngetDeals(1);'>{{trans('my_deal.submit_btn_title')}}</button>
                    </div>
                </div>
            </div>

            <div class="element-wrapper">
                <h6 class="element-header">
                  {{trans('my_deal.other_options_title')}}
                </h6>
  
                <!--START - To Do SIDEBAR-->
                <div class="todo-app-w">
                  <div class="todo-sidebar">
                    <div class="todo-sidebar-section">
                      <div class="todo-sidebar-section-contents">
                        <ul class="projects-list">
                          <li class="add-new-project">
                            <a href="/deals/new-deal" data-placement="top" data-toggle="tooltip" data-original-title="{{$newdealcontent}}" >{{trans('my_deal.create_deal_title')}}</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!--END - To Do SIDEBAR-->
  
              </div>

        </div>
        <!--
          END - Sidebar
         -->
    </div>
</div>



       @endsection


       @section('scripts')


<script type="text/javascript">





$(document).on('click','.pagination a',function(e){
    debugger;
e.preventDefault();
var page=$(this).attr('href').split('page=')[1];
fngetDeals(page);
});


/*var $ = jQuery;
jQuery(document).ready(function($){*/
  $(document).ready(function(){ 
    fngetDeals(1);
  });

  function fngetDeals(page)
  {
      if(page==null || page=="")
      {
          page=1;
      }
      
      
      setTimeout(function(){ ajaxLoad('/ajax-getmydeals','divDeals',page); }, 1000);
      
      
  }



    function ajaxLoad(route, divname,pageno) {
        debugger;
        var searchtext=$('#txtSearch').val();
        var sortby=$("#sortbyfield option:selected").val();
        var countryids='';
var $el=$("#ms_country");
$el.find('option:selected').each(function(){
    if(countryids=='')
    {
        countryids=$.trim($(this).val());
    }
    else{
        countryids=countryids+','+$.trim($(this).val());
    }
   });

//    if(countryids!=""){
//     countryids=countryids.split(',');
//    }
  

       var sectorids='';
var $e2=$("#ms_sectors");
$e2.find('option:selected').each(function(){
    if(sectorids=='')
    {
        sectorids=$.trim($(this).val());
    }
    else{
        sectorids=sectorids+','+$.trim($(this).val());
    }
   });




   var investmentsizes='';
var $e4=$("#i_sizes");
$e4.find('option:selected').each(function(){
    if(investmentsizes=='')
    {
        investmentsizes=$.trim($(this).text());
    }
    else{
        investmentsizes=investmentsizes+','+$.trim($(this).text());
    }
   });


var totalviewcount='';
// var $e5=$("#ms_tvc");
// $e5.find('option:selected').each(function(){
//     if(totalviewcount=='')
//     {
//         totalviewcount=$.trim($(this).text());
//     }
//     else{
//         totalviewcount=totalviewcount+','+$.trim($(this).text());
//     }
//    });


  var projectname='';
//   var $e6=$("#ms_projectname");
//   $e6.find('option:selected').each(function(){
//     if(projectname=='')
//     {
//         projectname=$.trim($(this).text());
//     }
//     else{
//         projectname=projectname+','+$.trim($(this).text());
//     }
//    });

  var projectstage='';
  var $e7=$("#ms_projectstage");
  $e7.find('option:selected').each(function(){
    if(projectstage=='')
    {
        projectstage=$.trim($(this).text());
    }
    else{
        projectstage=projectstage+','+$.trim($(this).text());
    }
   });
   
   
    var projectstructure='';
  var $e8=$("#ms_projectstructure");
  $e8.find('option:selected').each(function(){
    if(projectstructure=='')
    {
        projectstructure=$.trim($(this).text());
    }
    else{
        projectstructure=projectstructure+','+$.trim($(this).text());
    }
   }); 
   
   var investmentpurpose='';
  var $e9=$("#ms_projectinvestmentpurpose");
  $e9.find('option:selected').each(function(){
    if(investmentpurpose=='')
    {
        investmentpurpose=$.trim($(this).text());
    }
    else{
        investmentpurpose=investmentpurpose+','+$.trim($(this).text());
    }
   }); 
   
      var proposedfunds='';
//  var $e10=$("#ms_proposedfunds");
//  $e10.find('option:selected').each(function(){
//    if(proposedfunds=='')
//    {
//        proposedfunds=$.trim($(this).text());
//    }
//    else{
//        proposedfunds=proposedfunds+','+$.trim($(this).text());
//    }
//   });

   var active = 'active';
   var text = $(".nav-link.active").text().toLowerCase();
   var active=text;
   



   route=route+'?sectorids='+sectorids+'&countryids='+countryids+'&investmentsizes='+investmentsizes+'&totalviewcount='+totalviewcount+'&projectname='+projectname+'&projectstage='+projectstage+'&projectstructure='+projectstructure+'&investmentpurpose='+investmentpurpose+'&proposedfunds='+proposedfunds+'&page='+pageno+'&searchtext='+searchtext+'&sortby='+sortby+'&active='+active;
  
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              debugger;
                $("#" + divname).html('');
                $("#" + divname).html(data);
              
              var projectboxcount=$('.project-box').length;
              $('#numberofbox').html(projectboxcount);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

      


      var timer;
  $("#txtSearch").keyup(function() {
    clearTimeout(timer);
    var ms = 3000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
      debugger;
      fngetDeals(1);
    }, ms);
  });

 function fnShowFileUploadModal()
 {

 }

  function fnShowInterestModal(dealid)
  {
      debugger;
      var route="ajax-getdeal-folders?dealid="+dealid;
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

  function fnAttachDeal(dealid)
  {
      debugger;
      var folderid=$("#userpipeline_folders option:selected").val(); 
      if(parseInt(folderid)<=0) 
      {
          //error-folder-select
        // alert('Please select a folder where you like to connect this deal.');

         var $messageDiv = $('#error-folder-select'); // get the reference of the div
        $messageDiv.show(); // show and set the message.html(data.Message)
        setTimeout(function () { $messageDiv.hide(); }, 3000); // 3 seconds later, hide
          return;
      }
      if (!$("#chkTermsConditions").is(":checked")) {
        // do something if the checkbox is NOT checked
        // alert('Please select the terms & condition check boxes.');
        var $messageDiv = $('#error-termscondition-select'); // get the reference of the div
        $messageDiv.show(); // show and set the message.html(data.Message)
        setTimeout(function () { $messageDiv.hide(); }, 3000); // 3 seconds later, hide
        return;
       }
       $('#btn-on-popup').prop("disabled",true);
    $.ajaxSetup({
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
       });

        var formdata = new FormData();
        formdata.append("dealid",dealid);
        formdata.append("folderid",folderid);
        formdata.append("_token",'{{csrf_token()}}');

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
       if(data.status=='Success')
       {
        //trigger second button
         $("#btnpopupclose").click();
         $("div.modal-backdrop").remove();
        // $('#common-pop-up').modal('hide');
           //Referesh the deal content areas....
        fngetDeals(1);
       }
       else
       {
        alert('Some Error happened during processing...'); 
        $('#btn-on-popup').prop("disabled",false);
       }
      
            },
            error: function (err, result) {
              debugger;
                alert("Error" + err.responseText);
                $('#btn-on-popup').prop("disabled",false);
                //trigger second button
                $("#btnpopupclose").click();
                $("div.modal-backdrop").remove();
            }
        });
  }


  //alert($('.nav-link active').id);

            
            
       
    



        </script>

          @endsection