 @extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')

<?php 
  $user_loggedin=Session('userid');
  // echo date('l jS \of F Y h : I : s A');
  $UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
  $CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
 ?>

       <div class="content-w portfolio-custom-vk due-dili-process">
        <!--
          START - Secondary Top Menu
          -->
       @include('shared._top_menu')

       <div aria-labelledby="exampleModalLabel" class="modal fade" id="message_deleteModel" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{trans('dd_messaging.delete_confirmation_title')}}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="row">
                      <div class="col-sm-12">
                      <div class="form-group">
                      <h6>
                          {{trans('dd_messaging.delete_confirmation_message')}}
                        </h6>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mdel_close">{{trans('dd_messaging.delete_confirmation_Cancel')}}</button>
                <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedMessage();" id="btn_del_yes">{{trans('dd_messaging.delete_confirmation_Yes')}}</button>
              </div>
            </div>
          </div>
        </div>

        <div aria-labelledby="myLargeModalLabel" id="message_update_modal" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                      {{trans('dd_messaging.update_modal_title')}}
                  </h5>
                  <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <label for="">{{trans('dd_messaging.update_modal_message_label')}}</label>
                      <textarea class="form-control" name="current_message" id="current_message" rows="5"></textarea>
                      
                    </div>
                    <div class="form-group">
                        <label id="errorMessage"></label>
                      </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">{{trans('dd_messaging.delete_confirmation_Cancel')}}</button>
                  <button class="btn btn-primary" type="button" onclick="fnUpdateSelectedMessage();" id="btnMessageSave"> {{trans('dd_messaging.update_modal_btnsave_caption')}}</button>
                </div>
              </div>
            </div>
          </div>

          <div class="content-i">
          <div class="content-box">
              @if((session('helpview')!=null))
              <div class="element-wrapper" id='helpform'>
        <div class="element-box">
                        <h5 class="form-header">
                               {!!trans('dd_messaging.help_title')!!}   
                            </h5>
                            <div class="form-desc">
                               {!!trans('dd_messaging.help_content')!!}
                            </div>
                            <div class="element-box-content example-content">
                                    <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('dd_messaging.help_btn_hide_caption')}}</button>
                            </div>
        </div>
    </div>
@endif
            <div class="row">
              <div class="col-sm-12">
        <div class="content-i control-panel">
          <div class="content-box-tb">
            <div class="os-tabs-w">
              <div class="os-tabs-controls">
                <ul class="nav nav-tabs upper">
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link"  href="/due-diligence-dashboard?pd={{$pipelinedealid}}">{{trans('duediligenceprocess.lebel_duediligencedashboard')}}</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" href="/due-diligence-process?pd={{$pipelinedealid}}">{{trans('duediligenceprocess.lebel_duediligenceprocess')}}</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link active"  href="/messaging?pd={{$pipelinedealid}}"> {{trans('duediligenceprocess.lebel_messaging')}}</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" href="/pipelinedeal-docs?pd={{$pipelinedealid}}"> {{trans('duediligenceprocess.lebel_documents')}}</a>
                </li>
                </ul>
                <h5 class="process-top-rit">
                  <!-- Kinara Capital -->
                  {{$companydata->name}}
                </h5>
              </div>
            </div>
          </div>
        </div>        
        <!--END - Control panel above projects-->

                
                <div class="element-wrapper">
                  <div class="element-header">
                    <h6>
                      {{-- Messaging --}}
                      {{trans('duediligenceprocess.lebel_messaging')}}
                    </h6>                    
                  </div>  

                  <!-- START - Emails sender Name -->
                  <div class="content-w messaage-row">
                    <div class="content-i">
                      <div class="content-box-inner">
                        <div class="full-chat-w">
                          <div class="full-chat-i">
                            <div class="full-chat-left">                              
                              <div class="chat-search">
                                <div class="element-search">
                                  <input placeholder="{{trans('dd_messaging.placeholer_search_user')}}" type="text" id="txtSearch">
                                <div class="clear"></div>
                                </div>
                              </div>

                              <div class="user-list" id="pipelinedeal_users">

                                  @if($generalgroupdetail[0]!=null)
                                  <div class="user-w" id='{{$generalgroupdetail[0]->groupid}}' onclick="fnSelectedUserChanged('{{$generalgroupdetail[0]->groupid}}');">
                                                         <div class="avatar with-status status-green">
                                                        @if( (isset($generalgroupdetail[0]->profileimage) && !empty($generalgroupdetail[0]->profileimage) ) && File::exists(public_path('storage/company/profileimage/'.$generalgroupdetail[0]->profileimage)))     
                                                     <img alt="" src="{{$CompanyProfileImagePath . $generalgroupdetail[0]->profileimage}}">
                                                     
                                                       @else
                                                          <img alt="" src="{{ Avatar::create(ucfirst($generalgroupdetail[0]->groupname))->toBase64() }}">    
                                                        @endif
                                                           
                                                         </div>
                                                         <div class="user-info">
                                                             
                                                           @if($generalgroupdetail[0]->lastmessagetime!=null)  
                                                           <div class="user-date" id='{{$generalgroupdetail[0]->lastmessagetime}}'>
                                                             {{$generalgroupdetail[0]->lastmessagetime}}
                                                           </div>
                                                           @endif
                                                           <div class="user-name" id='username{{$generalgroupdetail[0]->groupid}}'>
                                                             
                                                             {{$generalgroupdetail[0]->groupname}}
                                                           </div>
                               <input type="hidden" id='groupid{{$generalgroupdetail[0]->groupid}}' value='{{$generalgroupdetail[0]->groupid}}'>
                                                           <div class="last-message">
                                                             {{$generalgroupdetail[0]->company}}
                                                           </div>
                                                         </div>
                                                       </div>
                                                       @endif
                               
                               
                                                       @foreach($involvedusers as $user)
                                                      
                               <div class="user-w " id='{{$user->userid}}' onclick="fnSelectedUserChanged('{{$user->userid}}');">
                                                         <div class="avatar with-status status-green">
                                                       @if( (isset($user->profileimage) && !empty($user->profileimage) ) && File::exists(public_path($UserProfileImagePath.$user->profileimage)))     

                                                              {{-- <img alt="" src="img/avatar1.jpg"> --}}
                                                              <img alt="" src="{{$UserProfileImagePath . $user->profileimage}}">
                                                              
                                                       @else
                                                              <img alt="" src="{{ Avatar::create(ucfirst($user->firstname) .' ' . ucfirst($user->lastname))->toBase64() }}">  
                                                        @endif
                                                         </div>
                                                         <div class="user-info">
                                                           <div class="user-date" id='{{$user->lastmessagetime}}'>
                                                             {{$user->lastmessagetime}}
                                                           </div>
                                                           <div class="user-name" id='username{{$user->userid}}'>
                                                              {{ $user->firstname .' ' . $user->lastname }}
                                                           </div>
                                         <input type="hidden" id='groupid{{$user->userid}}' value='{{$user->groupid}}'>
                                                           <div class="last-message">
                                                             {{$user->company}}
                                                           </div>
                                                         </div>
                                                       </div>
                                                            
                                                       @endforeach

                              </div>
                            </div>
                            <div class="full-chat-middle">
                              <div class="chat-head">
                                <div class="user-info">

                          <span>{{trans('dd_messaging.To_caption')}}:</span><a id="chatboxtitle" href="#"></a>
                                </div>
                                {{-- <div class="user-actions">
                                  <div class="pipeline-settings os-dropdown-trigger">
                                    <i class="os-icon os-icon-ui-46"></i>
                                    <div class="os-dropdown">
                                      <div class="icon-w">
                                        <i class="os-icon os-icon-ui-46"></i>
                                      </div>
                                      <ul>
                                        <li>
                                          <a href="#">
                                            <i class="os-icon os-icon-ui-49"></i>
                                            <span>Edit Record</span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <i class="os-icon os-icon-grid-10"></i>
                                            <span>Duplicate Item</span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <i class="os-icon os-icon-ui-15"></i>
                                            <span>Remove Item</span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <i class="os-icon os-icon-ui-44"></i>
                                            <span>Archive Project</span>
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>
                                </div> --}}
                              </div>
                              <div class="chat-content-w">
                                <div class="chat-content" id="div_chatmessages">
                                  


                                </div>
                              </div>
                              <div class="chat-controls">
                                <div class="chat-input">
                                  {{-- <input id="txtmessage" placeholder="{{trans('dd_messaging.placeholer_message_text')}}" type="text"> --}}
                                  <textarea name="txtmessage" id="txtmessage" placeholder="{{trans('dd_messaging.placeholer_message_text')}}" style="width: -webkit-fill-available;border: none; margin-top: 0px;margin-bottom: 0px;padding-top: 20px;" rows="7"></textarea>
                       
                                </div>
                                <div class="chat-input-extra">
                                  <div class="chat-extra-actions">
                                    &nbsp;
                                  </div>
                                  <div class="chat-btn">
                                    <!-- <a class="btn btn-primary btn-sm" href="#">Send</a> -->
                                     <button style="margin-top:10px;" class="btn btn-primary btn-sm" onclick='fnsendmessage();'>{{trans('dd_messaging.button_send_caption')}}</button>
                                  </div>
                                </div>
                              </div>
                            </div>                           
                          </div>
                        </div><!--------------------
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
                        --------------------><!--------------------
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
                              <input class="message-input" placeholder="{{trans('dd_messaging.placeholer_message_text')}}" type="text">
                              <div class="chat-extra">
                                <a href="#"><span class="extra-tooltip">Attach Document</span><i class="os-icon os-icon-documents-07"></i></a><a href="#"><span class="extra-tooltip">Insert Photo</span><i class="os-icon os-icon-others-29"></i></a><a href="#"><span class="extra-tooltip">Upload Video</span><i class="os-icon os-icon-ui-51"></i></a>
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
                 <!-- END - Emails sender Name -->
                </div>
              </div>
            </div>
            <!--------------------
              END - Due Diligence Process
              -------------------->

          </div>

        </div>
      </div>




      @endsection

<input type='hidden' id='selectedmessagebody' value="">
<input type='hidden' id='selectedmessageid' value="">
<input type='hidden' id='selecteduserid' value="">
<input type='hidden' id='groupid' value="">
<input type="hidden" id='pipelinedealid' value='{{$pipelinedealid}}'>

<input type='hidden' id='loggedinuserid' value="{{$user_loggedin}}">

   @section('scripts')
   
   <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
   <script type="text/javascript">
         
         
     Pusher.logToConsole = true;
     var pusher_key = '{{ env('PUSHER_APP_KEY') }}';
     var cluster_key = '{{ env('PUSHER_APP_CLUSTER') }}'; 
      
        
	var pusher = new Pusher(pusher_key , {
	  cluster: cluster_key,
	  encrypted: true
	});

	var channel = pusher.subscribe('my-channel');
	channel.bind('my-event', function(data) {
	    debugger;
   if(data.receiverid=='{{$user_loggedin}}' || data.senderid=='{{$user_loggedin}}')
   {
     if(data.grouptype!='General')
     {

      $('#groupid'+data.senderid).val(data.message);
      var curtime=getCurrentDateTime();
      $('#'+data.senderid+' .user-date').html(moment(curtime).fromNow());
     }   
     //Check whether the receiver message box is selected....
     if(data.grouptype!='General'){

        var selectedReceiverID= $('#selecteduserid').val();
        if(selectedReceiverID==data.senderid)
        {
          ReLoadChatMessages(data.message);
        }
       else if(data.senderid=='{{$user_loggedin}}')
        {
          ReLoadChatMessages(data.message);
        }
     }
    }

     if(data.grouptype=='General')//In Case of General
     {
         var selectedGroupID=$('#groupid').val();
         if(selectedGroupID==data.message)
         {
          ReLoadChatMessages(data.message);
           var curtime=getCurrentDateTime();
      $('#'+data.message+' .user-date').html(moment(curtime).fromNow());
         }
     }



 	});    

  function getCurrentDateTime()
  {
    var today = new Date();
    var dd = today.getDate();

    var mm = today.getMonth()+1; 
    var yyyy = today.getFullYear();

    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    if(dd<10) 
    {
    dd='0'+dd;
    } 

    if(mm<10) 
    {
    mm='0'+mm;
    } 
    today = yyyy+'-'+mm+'-'+dd+' '+time;
    return today;
  }
         
         
         
    $(document).ready(function(){ 
      $('.user-date').each(function (index, value) {
          $(this).html(moment($(this).attr('id')).fromNow());
       });
     });


      function ajaxLoad(filename) {
        $.ajax({
            type: "GET",
            url: filename,
            contentType: false,
            success: function (data) {

                $('#div_chatmessages').html('');
                $('#div_chatmessages').html(data);
              
              $('.chat-message-date').each(function (index, value) {
                 var dat=$(this).attr('id');
                 $(this).html(moment($(this).attr('id')).fromNow());
              });
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
      }



        function fnSelectedUserChanged(userid)
        {
          debugger;


      $('#selecteduserid').val(userid);
     
     var groupid=$('#groupid'+userid).val();
     var pipelinedealid=$('#pipelinedealid').val();
      $('#groupid').val(groupid);

       $(".user-w").removeClass("mail-active");
      
       $('#chatboxtitle').text($('#username'+userid).html());

      $('#'+userid).addClass("mail-active");


      
      if(userid!=null)
      {
        ajaxLoad('/getpipelinedealmessages?pipelinedealid='+pipelinedealid+'&groupid='+groupid);
      }
     

      }

      //Used to Handle Load More Functionalities.........
      function fnLoadMoreMessage()
      {
        debugger;
           var ttlMessages=$('#totalmessagecount').val();
           var mdisplayonce=$('#messagedisplaycount').val();
           var groupid=$('#groupid').val();
           var pipelinedealid=$('#pipelinedealid').val();
           var alreadyloaded_cnt=$('.chat-message').length;
           var firstrecentdate=$('.firstrecentdate').eq(0).attr('id'); 

/*           $('.firstrecentdate').each(function (index, value) {
                 firstrecentdate=$(this).attr('id');
                 break;
            });*/

           if(alreadyloaded_cnt>=ttlMessages)
           {
              $('#loadmore').hide();
              return;
           }
           var url='/loadmore-pipelinedealmessages?alreadyloaded='+alreadyloaded_cnt+'&totalmessagecount='+ttlMessages+'&firstrecentdate='+firstrecentdate+'&pipelinedealid='+pipelinedealid+'&groupid='+groupid ;
          $.ajax({
            type: "GET",
            url:url,
            contentType: false,
            success: function (data) {

              debugger;
              $("#loadmore").remove();

              var newdata = data;
              var olddata = $('#div_chatmessages').html();

              $('#div_chatmessages').html(newdata + olddata);

              /*$('#div_chatmessages').html('');
                $('#div_chatmessages').html(data);*/

              $('.chat-message-date').each(function (index, value) {
                 var dat=$(this).attr('id');
                 $(this).html(moment($(this).attr('id')).fromNow());
              });

            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });

      }


        function fnsendmessage()
        {
        debugger;
        var userid=$('#selecteduserid').val();
         var pipelinedealid=$('#pipelinedealid').val();
         var message= $('#txtmessage').val();
         message=$.trim(message);
         if(message=="" || userid=="")
         {
             return;
         }
  
      var groupid=$('#groupid'+userid).val();//$('#groupid').val();


        $.ajaxSetup({
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
       });

        var formdata = new FormData();
        formdata.append("userid",userid);
        formdata.append("pipelinedealid",pipelinedealid);
        formdata.append("groupid",groupid);
        formdata.append("message",message);
        formdata.append("_token",'{{csrf_token()}}');

       $.ajax({
            url: '/postdealnewmessage',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {

       if(data.groupid=='error')
       {
          alert('Some Error happened during processing...'); 
       }
       else
       {
           //ReLoadChatMessages(data.groupid);
/*           if($('#groupid'+userid).val()==null || $('#groupid'+userid).val()=="")
           {*/
           $('#groupid'+userid).val(data.groupid);
           var curtime=getCurrentDateTime();
           $('#'+userid+' .user-date').html(moment(curtime).fromNow());
          /* }*/
       }
              
            },
            error: function (err, result) {
              debugger;
                alert("Error" + err.responseText);
            }
        });

/*
      var csrf_token = $('meta[name="csrf-token"]').attr('content');
      var v_token = encodeURIComponent(csrf_token);
      $.post('postdealnewmessage',{'userid':userid,'message':message,'pipelinedealid':pipelinedealid,'groupid':groupid,'_token':v_token},function(data){
       debugger;
       if(data.groupid=='error')
       {
          alert('Some Error happened during processing...'); 
       }
       else
       {
           ReLoadChatMessages(data.groupid);
       }
        
      });*/
      
       }


    function ReLoadChatMessages(groupid)
    {
      var pipelinedealid=$('#pipelinedealid').val();
      ajaxLoad('/getpipelinedealmessages?pipelinedealid='+pipelinedealid+'&groupid='+groupid);
      $('#txtmessage').val('');
    }

// document.getElementById("txtmessage").onkeypress = function(event){
// if (event.keyCode == 13 || event.which == 13){
// fnsendmessage();
// }
// };


  function fnSetIDToDelete(selectedID)
  {
    $('#selectedmessageid').val(selectedID);
  }

  function fnSetIDandMessage(id,message)
  {
    $('#selectedmessageid').val(id);
    $("#selectedmessagebody").val(message);
    $("#current_message").val(message);
    $('#errorMessage').text('');

  }

  function fnDeleteSelectedMessage()
  {
    var messageid=$('#selectedmessageid').val();
    var userid=$('#selecteduserid').val();
         
      var groupid=$('#groupid'+userid).val();
      $('#btn_del_yes').prop("disabled",true);
        $.ajaxSetup({
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
       });

        var formdata = new FormData();
        formdata.append("messageid",messageid);
        formdata.append("_token",'{{csrf_token()}}');

       $.ajax({
            url: '/deletepipelinedealmessage',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
       debugger;
       if(data.message=='Failed')
       {
          alert('Some Error happened during processing...'); 

       }
       else
       {
         $("#mdel_close").click();
         $("div.modal-backdrop").remove();
           ReLoadChatMessages(groupid);

       }
              
            },
            error: function (err, result) {
              $('#btn_del_yes').prop("disabled",true);
                alert("Error" + err.responseText);
            }
        });

  }

  function fnUpdateSelectedMessage()
  {
    debugger;
    var message=$('#current_message').val();

    if($.trim(message)=="")
    {
      $('#errorMessage').text('Message can not be blank.');
      return;
    }
    else
    {
      $('#errorMessage').val('');
    }


    var messageid=$('#selectedmessageid').val();
    var userid=$('#selecteduserid').val();
         
      var groupid=$('#groupid'+userid).val();
      $('#btnMessageSave').prop("disabled",true);
      $('#mupdate_close').prop("disabled",true);
        $.ajaxSetup({
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
       });

        var formdata = new FormData();
        formdata.append("messageid",messageid);
        formdata.append("message",message);
        formdata.append("_token",'{{csrf_token()}}');

       $.ajax({
            url: '/updatepipelinedealmessage',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
       debugger;
       if(data.message=='Failed')
       {
          alert('Some Error happened during processing...'); 

       }
       else
       {
        $('#btnMessageSave').prop("disabled",false);
        $('#mupdate_close').prop("disabled",false);
         $("#mupdate_close").click();
         $("div.modal-backdrop").remove();
        
        ReLoadChatMessages(groupid);

       }
              
            },
            error: function (err, result) {
              $('#mupdate_close').prop("disabled",false);
                alert("Error" + err.responseText);
            }
        });
  }



      function fnSearchPipelineDealUsers(searchval)
      {
        var searchtext=searchval;
        var pipelinedealid=$('#pipelinedealid').val();
      
        $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
         });

        var formdata = new FormData();
    
        formdata.append("searchtext",searchtext);
        formdata.append("pipelinedealid",pipelinedealid);
        formdata.append("_token",'{{csrf_token()}}');

       $.ajax({
            url: '/pipelinedeal-user-search',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
              debugger;
                $("#pipelinedeal_users").html('');
                $("#pipelinedeal_users").html(data);
                 
            },
            error: function (err, result) {
              debugger;
                alert("Error" + err.responseText);
            }
        });
    }

    var timer;
  $("#txtSearch").keyup(function() {
    clearTimeout(timer);
    var ms = 3000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
      fnSearchPipelineDealUsers(val);
    }, ms);
  });

     </script>


       @endsection