<?php
$helper=\App\Helpers\AppHelper::instance();





function setarray($userid,$currentstatus)
{
$array=array(
    'View'=>'<a href="#" class="dropdown-item"  onclick=view("'.$userid.'","'.$currentstatus.'");>View profile</a>',
//    'Invited'=>'<a href="#" class="dropdown-item"  onclick=invited("'.$userid.'","'.$currentstatus.'");>Make Invited</a>',
    'Active'=>'<a href="#" class="dropdown-item"  onclick=active("'.$userid.'","'.$currentstatus.'");>Make Active</a>',
    'Inactive'=>'<a href="#" class="dropdown-item"  onclick=inactive("'.$userid.'","'.$currentstatus.'");>Make Inactive</a>'
  
  );
return $array;
}


?>


<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .table-asif a{
        font-size:12px;
        margin-right: 18px; 
       
    }
   
    .table .user-with-avatar.company-name-img img {
    height: auto;
    margin: 0 10px 0 0;
    border-radius: 0;}


    
    
</style>
<style> 
/*    .user-with-avatar.with-status  {
    position: relative;
    }
   .user-with-avatar.with-status:before {
      content: "";
      width: 10px;
      height: 10px;
      position: absolute;
      top: 2px;
      left: 27px;
      border-radius: 10px;
      box-shadow: 0px 0px 0px 3px #fff; }
  .user-with-avatar.with-status.status-green:before {
    background-color: #8cb314; }*/
</style>


<?php

$array=array(
    'Invited'=>'<a class="dropdown-item" href="#" onclick=invited();>Make Invitede</a>',
    'Active'=>'<a class="dropdown-item" href="#" onclick=active();>Make Active</a>',
    'Inactive'=>'<a class="dropdown-item" href="#" onclick=inactive();>Make Inactive</a>'
  );



?>

@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')

<div class="content-w portfolio-custom-vk">
    <div aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm" id="invite_user_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm" style="max-width: 610px!important;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                {{trans('teams.team_text_modal_title')}}
              </h5>
              <button aria-label="Close" class="close" data-dismiss="modal" type="button" onclick="refresh()"><span aria-hidden="true" > X</span></button>
            </div>
            <div class="modal-body">
                    <div class="content-i control-panel">
                        <div class="content-box-tb">
                            <div class="os-tabs-w">
                                <div class="os-tabs-controls tab" >
                                    <ul class="nav nav-tabs upper">
                                        <li class="nav-item">
                                            <a aria-expanded="false" class="nav-link active" data-toggle="tab" href="#single" id="aba5f1">{{trans('teams.team_modal_single_tab_title')}} </a>
                                        </li>
                                        <li class="nav-item">
                                            <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#multiple" id="5eab3b">{{trans('teams.team_modal_multiple_tab_title')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-i">
                        <div class="content-box tab-content">
                            <div id="single" class="tab-pane active">
                                <form id="inviteform">
                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <label for="">  {{trans('teams.team_text_modal_email')}}</label><input id="email" class="form-control" placeholder="Enter Email" type="email" name="email">
                                            <input type="hidden" id="useremail" value="disable">
                                        </div>
                                        <!--                  <div class="form-group col-md-6">
                                                          <label for=""> {{trans('teams.team_text_modal_username')}}</label><input id="username" class="form-control" placeholder="Enter User Name" type="text" name="username">
                                                        </div>-->
                                        <div class="form-group col-md-12">
                                            <label for=""> {{trans('teams.team_text_modal_firstname')}}</label>
                                            <input id="firstname" class="form-control" placeholder="Enter First Name" name="firstname" >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for=""> {{trans('teams.team_text_modal_lastnamr')}}</label><input id="lastname" class="form-control" placeholder="Enter Last Name" name="lastname">
                                        </div>
                                    </div>
                                </form>
                                {{-- <label id="usermeg"></label> --}}
                                <div class="alert alert-danger" role="alert" id="error-email" style="display:none;">
                                    {{trans('teams.team_error_email')}}
                                </div>
                                <div class="alert alert-danger" role="alert" id="error-email-alreadyexist" style="display:none;">
                                    {{trans('teams.team_error_email_alreadyexist')}}
                                </div>
                                <div class="alert alert-danger" role="alert" id="error-common" style="display:none;">
                                    {{trans('teams.team_error_common')}}
                                </div>
                            </div>
                            <div id="multiple" class="tab-pane">
                                <form id="multipleinviteform" method="post" action="{{route('multi_invite')}}">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">  {{trans('teams.team_textarea_modal_user')}}</label>
                                            <textarea id="textarea_user" class="form-control" placeholder="" cols="100" rows="5" name="user_data"></textarea>
                                            <input type="hidden" name="_token" id="_token" value=""/>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="alert alert-info">
                                        {{trans('teams.team_modal_multiple_notice_text1')}}
                                        <br/>
                                        {{trans('teams.team_modal_multiple_notice_text2')}}
                                        <br/>
                                        {{trans('teams.team_modal_multiple_notice_text3')}}
                                        </div>
                                            </div>
                                    </div>
                                </form>
                                <div class="alert alert-danger" role="alert" id="error-multiple" style="display:none;">
                                    {{trans('teams.team_error_multiple')}}
                                </div>
                                <div class="alert alert-danger" role="alert" id="error-multiple-blank" style="display:none;">
                                    {{trans('teams.team_error_multiple_blank')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-placement="top" data-toggle="tooltip"  data-original-title="{{$helper->GetHelpModifiedText(trans('teams.help_content_popup_reject'))}}" type="button" data-dismiss="modal" type="button"> {{trans('teams.team_button_modal_cancel')}}</button><button class="btn btn-primary" data-placement="top" data-toggle="tooltip"  data-original-title="{{$helper->GetHelpModifiedText(trans('teams.help_content_popup'))}}" type="button" onclick="inviteuser();"> {{trans('teams.team_button_modal_invite')}}</button>
            </div>
          </div>
        </div>
      </div>
    
    
    
    <div aria-labelledby="exampleModalLabel" class="modal fade show" id="invitedeletemodal" role="dialog" tabindex="-1" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
              Delete Confirmation
          </h5>
          <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <form class="ng-pristine ng-valid">
            <div class="row">
                <div class="col-sm-12">
                <div class="form-group">
                <h6>
                  This will delete the invited users. Do you want to continue?
                  </h6>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="alert alert-success" role="alert" id="del-message-box" style="display:none;">
          Selected documents deleted succussfully.
        </div>
        <div class="modal-footer">
          <input type="hidden" id="deleteinvitedid" value=""> 
            
          <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mdel_close">No</button>
          <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedinvited();" id="btn_del_yes">Yes</button>
        </div>
        
      </div>
    </div>
  </div>
    
    
    
    
    
    @include('shared._top_menu')
        <!--
          START - Secondary Top Menu
         -->

       
       
        <div class="content-i">
          <div class="content-box">
                @if((session('helpview')!=null))
              <div class="element-wrapper" id='helpform'>
                            <div class="element-box">
                                            <h5 class="form-header">
                                                   {!!trans('teams.help_title')!!}   
                                                </h5>
                                                <div class="form-desc">
                                                   {!!trans('teams.help_content')!!}
                                                </div>
                                                <div class="element-box-content example-content">
                                                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('teams.help_btn_hide_caption')}}</button>
                                                </div>
                            </div>
                        </div>
                @endif
              
              
            <div class="row">
              <div class="col-sm-12">
                <div class="element-wrapper">
                  <div class="teams-hd clearfix">
                  <h6 class="element-header">
                    {{trans('teams.team_text_pagetitle')}}
                  </h6>
                  <button id="inviteadduser" class="mr-2 mb-2 btn btn-primary btn-sm btn-pluse" data-target=".bd-example-modal-sm" data-toggle="modal" data-placement="top" title="{{$helper->GetHelpModifiedText(trans('teams.adduser'))}}"   type="button">
                      <i class="plus-icn"><img src="img/plus-icon.png" /> </i>
                    {{trans('teams.team_invitbutton_caption')}}</button>
                  </div>
                  <div class="controls-above-table filter-row-top">
                    <div class="row">
                      <div class="col-sm-12">
                        <form class="form-inline justify-content-sm-end">
                            <input class="form-control form-control-sm rounded bright" placeholder="{{trans('teams.team_search_label')}}" type="text" onkeyup="searchme();" id="myinput">
                            <select id="selectfilter" class="form-control form-control-sm rounded bright" onchange="selectme(this.value);">
                            <option selected="selected" value="">
                              {{trans('teams.team_sort_label')}}
                            </option>
                            <option value="username">
                              {{trans('teams.team_text_name')}}
                            </option>
                            <option value="Active">
                              {{trans('teams.team_status_label')}}
                            </option>
                          </select>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!--START - Teams table -->
                  
                 

                  
                  
                  <div class="element-box-tp">
                    <div class="table-responsive">
                      <table class="table table-padded" id="myTable">
                        <thead>
                          <tr>
                            <th>
                               {{trans('teams.team_text_name')}}
                            </th>
                            <th>
                              {{trans('teams.team_text_company')}}
                            </th> 
                            <th>
                              {{trans('teams.team_text_position')}}
                            </th>
                            <th>
                              {{trans('teams.team_text_user_type')}}
                            </th> 
                            <th class="text-center">
                              {{trans('teams.team_text_status')}}
                            </th>                           
                            <th class="text-right">
                              {{trans('teams.team_text_action')}}
                            </th>                            
                          </tr>
                        </thead>
                        <tbody id='ajaxsearch'>
                            
                                                                                                 
                          
                        </tbody>
                        
                        
                      </table>
<!--                        <label onclick="selectinvited();">Select Invited</label>-->
<!--                        <button onclick="selectinvited();" class="btn btn-secondary" type="button"> Select Invited</button>
                        
                        <button onclick="deleteinvited();" class="btn btn-primary" type="button"> Delete Invited</button>-->
<!--                        <label onclick="deleteinvited();">Delete Invited</label>-->
                    </div>
                  </div>
                   <!--START - next pagers-->
                   <div class="controls-below-table controls-pagination-cnt row">
                        
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="table-records-info">
<!--                        Showing records 1 - 5-->
                      </div>
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="table-records-pages align-rit">
                      <ul id="asifappend">
                          
                          
                           
                          
                          
<!--                        <li>
                          <a href="#">Previous</a>
                        </li>
                        <li>
                          <a class="current" href="#">1</a>
                        </li>
                        <li>
                          <a href="#">2</a>
                        </li>
                        <li>
                          <a href="#">3</a>
                        </li>
                        <li>
                          <a href="#">4</a>
                        </li>
                        <li>
                          <a href="#">Next</a>
                        </li>-->
                      </ul>
                    </div>
                    </div>
                  
                  </div>
                  <!--END - next pagers-->
                  <!--END - Teams table -->
                </div>
              </div>
            </div>
              
              
              
              
            <!--------------------
              END - Teams
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
      
        </div>
      </div>
    

<input type="hidden", id="isemailnew" value=''/>
@endsection


@section('scripts')
<script src="{{asset('js/jquery-paginate.js')}}"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<script type="text/javascript">

 function tool_tip() {
     $('[data-toggle="tooltip"]').tooltip()
}



  function commanpagetablereload()
  {
     
      tool_tip();
       setTimeout(function() {
           
           var paginatelimit=20;
               $('.page-navigation').css('display','none');
      $('#myTable').paginate({ limit: paginatelimit,previous: true, 
            previousText: 'Previous',next: true,
            nextText: 'Next',first:false,last:false,
            onSelect: function(obj) { var totalrow=$('tr').length-1;var numOfVisibleRows = $('tr:visible').length - 1; if(numOfVisibleRows>=paginatelimit){$('.table-records-info').html('Showing records '+numOfVisibleRows+' - '+totalrow);} },   
            onCreate: function(obj) {var totalrow=$('tr').length-1;var numOfVisibleRows = $('tr:visible').length - 1; if(numOfVisibleRows>=paginatelimit){$('.table-records-info').html('Showing records '+numOfVisibleRows+' - '+totalrow); } }
          });
        $(".page-navigation").addClass( "table-asif" );
        $(".table-asif").appendTo("#asifappend");
       
    }, 1000);
    
  }
  
  
  
  $(document).ready(function(){
    setTimeout(function() {
        debugger;     
        searchme();
             
        
    }, 1000); 
  });
  
  
  
  
  function searchme()
  {
    
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var input=$('#myinput').val();
    var v_token = encodeURIComponent(csrf_token);
    
    var selectfilter1=$('select#selectfilter option:selected').val();
    
    
    
    if(selectfilter1=="")
    {
      $.post('teams/search',{input:input,_token:v_token},function(data){
         
       
          
          $('#ajaxsearch').html(data.view); 
         
          
          commanpagetablereload();
          
       
      });
      
          }
          
      if(selectfilter1=="username" || selectfilter1=="Active")
    {
     $.post('teams/search',{input:input,_token:v_token,select:selectfilter1},function(data){
         
          
          //alert(data.view);
          
          //alert(data);
          
          $('#ajaxsearch').html(data.view); 
         
          
          //alert(data);
          
          commanpagetablereload();
          
       
      });
    }    
          
          
      
      
  }
  function selectme(name)
  {
      
       var csrf_token = $('meta[name="csrf-token"]').attr('content');
    
    var v_token = encodeURIComponent(csrf_token);
      
      var search=$('#myinput').val();
      
     if(search.length==0)
     {
     if(sessionStorage){
          
     if(name!=null)
     {
      sessionStorage.setItem("name", name);
   
      
      }
      if(name==null)
      {
          sessionStorage.removeItem("name")
      }
      if(sessionStorage.getItem("name"))
      {
      
      $.post('teams/filter',{input:sessionStorage.getItem("name"),_token:v_token},function(data){
         
        $('#ajaxsearch').html(data.view); 
         commanpagetablereload();
       
         //alert(data);
      });
      
     
      
      }
      
  }
  }
  
      if(search.length>0)
     {
     if(sessionStorage){
          
     if(name!=null)
     {
      sessionStorage.setItem("name", name);
   
      
      }
      if(name==null)
      {
          sessionStorage.removeItem("name")
      }
      if(sessionStorage.getItem("name"))
      {
      
      $.post('teams/search',{input:search,_token:v_token,select:sessionStorage.getItem("name")},function(data){
         $('#ajaxsearch').html(data.view); 
          commanpagetablereload();
         //alert(data);
      });
      
      
      
      }
      
  }
  }
  
  
  
  
  }
  
  
  
  // function pending($userid,$currentstats)
  // {
  //      var csrf_token = $('meta[name="csrf-token"]').attr('content');
  //      var v_token = encodeURIComponent(csrf_token);
  //      postvalue($userid,v_token,'yellow','Pending',$currentstats);
       
      
  // }
  function invited($userid,$currentstats)
  {
       var csrf_token = $('meta[name="csrf-token"]').attr('content');
       var v_token = encodeURIComponent(csrf_token);
       postvalue($userid,v_token,'blue','Invited',$currentstats);
      
  }
  function active($userid,$currentstats)
  {
       var csrf_token = $('meta[name="csrf-token"]').attr('content');
       var v_token = encodeURIComponent(csrf_token);
       postvalue($userid,v_token,'green','Active',$currentstats);
       window.location.reload();
  }
  function inactive($userid,$currentstats)
  {
       var csrf_token = $('meta[name="csrf-token"]').attr('content');
       var v_token = encodeURIComponent(csrf_token);
       postvalue($userid,v_token,'Brown','Inactive',$currentstats);
       window.location.reload();
      
  }
  
  function deleteinvitedpop($userid,$currentstats)
  {
        $('#deleteinvitedid').val($userid);
        $('#invitedeletemodal').modal('toggle');
     
  }
  
  // function deleted($userid,$currentstats)
  // {
  //      var csrf_token = $('meta[name="csrf-token"]').attr('content');
  //      var v_token = encodeURIComponent(csrf_token);
  //      postvalue($userid,v_token,'Red','Deleted',$currentstats);
      
  // }
  
  
  function postvalue($userid,v_token,colour,title,$currentstatus)
  {
      //alert($currentstatus);
      $.post('teams/status',{input:$userid,_token:v_token,title:title,currentstatus:$currentstatus},function(data){
       $('#status'+$userid).html('<div class="status-pill '+colour+'" data-title="'+title+'" data-toggle="tooltip" data-original-title="" title=""></div>'); 
         //alert(data);
         tool_tip();
      });
  }
  
  //function to chek the email
  function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
     }
  
  function inviteuser()
  {
      
      debugger;
       var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var v_token = encodeURIComponent(csrf_token); 
      emailflag=textareaflag =true;
      var tabId = $("#invite_user_modal .tab-pane.active form").attr('id');
      if((tabId) === 'inviteform'){
    if($('#email').val().length==0)
     {
      var $messageDiv = $('#error-email'); 
      $messageDiv.show(); 
      setTimeout(function () { $messageDiv.hide(); }, 3000); 
       return;
         
         emailflag=false
     }
     if($('#email').val().length>0)
     {
     if(!(validateEmail($('#email').val())))
     {
      var $messageDiv = $('#error-email'); 
      $messageDiv.show(); 
      setTimeout(function () { $messageDiv.hide(); }, 3000); 
  
      return;
         
         emailflag=false
     }
     }
     if($('#email').val().length > 0 &&  validateEmail($('#email').val()) )
     {
        emailflag=true;
        email=$('#email').val(); 
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var v_token = encodeURIComponent(csrf_token); 
         
        $.ajax({
            type: "POST",
            url: 'teams/checkemail',
            data: {"input":email,"_token":v_token},
            func:"emailvalidate",
            success: function (data) {
              if(data.gotemail!="none" && (data.gotemail != null))
              {
               $('#isemailnew').val('duplicate');
               return;
          
               }
               else{
                $('#isemailnew').val('yes');
                }
            },
            failure: function (response) {
                alert(response.responseText);
            },
            error: function (response) {
                alert(response.responseText);
            }
        }); 
     }
      }else if((tabId) === 'multipleinviteform'){
          if($('#textarea_user').val() != ''){
            var lines = $('#textarea_user').val().split(/\n/);
            var output = [];
            var outputValidate = [];
            var row = [];
            for (var i = 0; i < lines.length; i++) {
              if (/\S/.test(lines[i])) {
                output.push($.trim(lines[i]));
                var rslt = validateTextareaRow($.trim(lines[i]),v_token);
                outputValidate[i] = rslt;
             }
            }
                        textareaflag = true;
            for (var i = 0; i < outputValidate.length; i++) {
                    if(outputValidate[i] != 1){
                        textareaflag = false;
                    }
              }
            if(!textareaflag){
                var $messageDiv = $('#error-multiple'); 
                var html ="";
                    for (var i = 0; i < outputValidate.length; i++) {
                            var r = i+1;
                        if(outputValidate[i] === 2){
                            html+="Line- "+r+": {{trans('teams.team_multiple_error_missing_value')}}<br/>";
                        }else if(outputValidate[i] === 3){
                            html+="Line- "+r+": {{trans('teams.team_multiple_error_enter_blank_value')}}<br/>";
                        }else if(outputValidate[i] === 4){
                            html+="Line- "+r+": {{trans('teams.team_multiple_error_invalid_email')}}<br/>";
                        }else if(outputValidate[i] === 5){
                            html+="Line- "+r+": {{trans('teams.team_multiple_error_email_exists')}}<br/>";
                        }
                  }
                  $messageDiv.html('');
                  $messageDiv.html(html);
                     $messageDiv.show(); 
                     setTimeout(function () { $messageDiv.hide(); }, 3000); 
            }else{
                var v_token = encodeURIComponent(csrf_token);
                $("#_token").val(v_token);
                $('#multipleinviteform').submit();
            }
        }else{
            textareaflag = false;
             var $messageDiv = $('#error-multiple-blank'); 
                     $messageDiv.show(); 
                     setTimeout(function () { $messageDiv.hide(); }, 3000); 
        }
                 
      }
      //   $.post('teams/checkemail',func="emailvalidate",{input:email,_token:v_token},function(data){
      //   debugger;
      //  if(data.gotemail!="none" && (data.gotemail != null))
      //  {
      //    $('#isemailnew').val('duplicate');
      //   // var $messageDiv = $('#error-email-alreadyexist'); 
      //   // $messageDiv.show(); 
      //   // setTimeout(function () { $messageDiv.hide(); }, 3000); 
      //   return;
          
      //  }
      //  else{
      //   $('#isemailnew').val('yes');
      //  }
      //   });
        
     
     
  //     var username=$('#username').val();
  //     var firstname=$('#firstname').val();
  //     var lastname=$('#lastname').val();
      
  //    if(username.length == 0 || firstname.length == 0 || lastname.length == 0 || emailflag==false)
  //    {
  //     var $messageDiv = $('#error-common'); 
  //     $messageDiv.show(); 
  //     setTimeout(function () { $messageDiv.hide(); }, 3000); 
  //     return;
  //    }
     
    
     
     
  //     if(username.length > 0 && firstname.length > 0 && lastname.length > 0 && emailflag==true)
  //     {
  //       $.post('teams/usersaveupdate',{_token:v_token,username:username,firstname:firstname,lastname:lastname,email:email},function(data){
  //          $('#username').val('');
  //          $('#firstname').val('');
  //          $('#lastname').val('');
  //          $('#email').val('');
  //      var explode = function(){
  //   $('#usermeg').text('Done....'); 
  // };
  // setTimeout(explode, 2000);
       
  //       });
          
  // //        $('#usermeg').text('All data must be non empty and valid'); 
     
  //     }
      
      
  }
  
   function checkUserEmailExists(email,v_token){
      debugger;
      $emailExistFlag = false;
      $.ajax({
            type: "POST",
            url: 'teams/checkemail',
            data: {"input":email,"_token":v_token},
            async:false,
            success: function (data) {
              if(data.gotemail!="none" && (data.gotemail != null))
              {
                $emailExistFlag = true;
               }else{
                   $emailExistFlag = false;
               }
            },
            failure: function (response) {
                
            },
            error: function (response) {
            },
            complete: function(data){
//                alert('in complete'+$emailExistFlag);
            }
        });
            return $emailExistFlag;
  }
  
  
  function validateTextareaRow(rowOutput,v_token){
      var flag = 1;
                    var row = [];
                    row  = $.trim(rowOutput).split(",");
                     if(checkUserEmailExists($.trim(row[2]),v_token))
                        {
                            return 5; // 4 for existing email 
                        }else{
                            if(row.length != 3){
                                return 2; // 2 for missing value
                            }else if(!(validateEmail($.trim(row[2])))){
                                 return 4; // 4 for invalid email 
                            }else{
                               for (var k = 0; k < row.length; k++) {
                                   if($.trim(row[k]) == ''){
                                       return 3; // 3 for blank value
                                   }
                               }
                            }
                        return flag;
                        }
  }

  $( document ).ajaxComplete(function( event, xhr, settings ) {

  if ( settings.func === "emailvalidate" ) {
   debugger;
    var result=$('#isemailnew').val();

    if(result=='duplicate')//i.e. already exists....
    {
        var $messageDiv = $('#error-email-alreadyexist'); 
        $messageDiv.show(); 
        setTimeout(function () { $messageDiv.hide(); }, 3000); 
        return;
    }

       var csrf_token = $('meta[name="csrf-token"]').attr('content');
      var v_token = encodeURIComponent(csrf_token); 

      //var username=$('#username').val();
      var firstname=$('#firstname').val();
      var lastname=$('#lastname').val();
      
     if(firstname.length == 0 || lastname.length == 0 || emailflag==false)
     {
      var $messageDiv = $('#error-common'); 
      $messageDiv.show(); 
      setTimeout(function () { $messageDiv.hide(); }, 3000); 
      return;
     }
     
    
     
     
      if( firstname.length > 0 && lastname.length > 0 && emailflag==true)
      {
        $.post('teams/usersaveupdate',{_token:v_token,firstname:firstname,lastname:lastname,email:email},function(data){
           
           $('#firstname').val('');
           $('#lastname').val('');
           $('#email').val('');
  //      var explode = function(){
  //   $('#usermeg').text('Done....'); 
  // };
  // setTimeout(explode, 2000);

       $('#invite_user_modal').modal('hide');
       searchme();
       
        });
          
  //        $('#usermeg').text('All data must be non empty and valid'); 
     
      }
       
  }
});
  
  function refresh()
  {
      $('#usermeg').text('');
  }

  function selectinvited()
  {
      
      $('.invited').prop('checked', true);
  }
//  function deleteinvited()
//  {
//      if($('.invited').filter(":checked").length > 0)
//      {
//      $('#invitedeletemodal').modal('toggle');
//      }
//  }
  function fnDeleteSelectedinvited()
  {
      
//   var deleteselected=[];   
//   var ids = $('.invited:checked').map(function(index) {
//       
//   deleteselected.push(this.id); 
//   });
   
   debugger;
    var deleteselected=$('#deleteinvitedid').val();
   
   if(deleteselected.length > 0)
   {
     
   $.get('teams/deleteinvited?deleteinvited='+deleteselected,function(data){

          
          //$('#ajaxsearch').html(data.view); 
      //alert(data);
       //console.log(data);
       $('#invitedeletemodal').modal('hide');

       window.location.reload();
          
       
      });
   
    }
   
   
  }
  
function accept(userid)
{
   var status="newstatus";
   active(userid,status);
   
}
function decline(userid)
{
    var status="New Status";
}
  
$('#inviteadduser').tooltip();  
  
  
  
  </script>
@endsection




