<?php 
  $user_loggedin=Session('userid');
 ?>


<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')
      


      <div class="content-w portfolio-custom-vk due-dili-process">
          
          
          <!--modal content-->
          
          
         
          
          
          
          
          
          
          
        <!--
          START - Secondary Top Menu
          -->

     @include('shared._top_menu')
     
     
     
  
        <div aria-labelledby="myLargeModalLabel" id="selectuserbox" class="modal fade bd-example-modal-sm" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                      Select User
                  </h5>
                  <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                </div>
                <div class="modal-body">
                  <form>
                      
                   
                      
                                 
                               
                      
                   
                                
                                
                                <div class="element-content">
                                        <div class="row">
                                            @foreach($recentfriends as $f)
                                 
                                @if(!($f->lastmessagetime))
                                            <div class="col-sm-4" id="divcol{{$f->friendid}}">
                                                 <a class="element-box el-tablo" href="#">
                                                <div class="activity-box" id="box{{$f->friendid}}" onclick="selectbox('{{$f->friendid}}')">
                                            <div class="activity-avatar">
                                               @if( (isset($f->profileimage) && !empty($f->profileimage) ) && File::exists(public_path('storage/user/profileimage/'.$f->profileimage)))
                                              
                                               <img alt="" src="storage/user/profileimage/{{$f->profileimage}}" style="
    width: 79px;border-radius: 50%;
    /* border: black; */
    
">
                                               
                                               
                                                
                                                
                                      
                                       
                                @else
                                
                                
                                <img alt="" src="{{ Avatar::create(strtoupper($f->firstname) .' ' . strtoupper($f->lastname))->toBase64() }}" style="
    width: 79px;border-radius: 50%;
    /* border: black; */
   
"> 
                                
                                
                                      

                                 @endif
                                            </div>
                                            <div class="activity-info">
                                                <div class="activity-role">
                                                    {{ $f->firstname .' ' . $f->lastname }}
                                                    
                                                </div>
                                                <input class="form-control checkclass" type="checkbox" id="flat{{$f->friendid}}" value="{{$f->friendid}}">
                                                <strong class="activity-title" id="select{{$f->friendid}}">Please Select</strong>
                                            </div>
                                        </div>
                                                
                                                
                                                
                                                
                                                
                                               
                                                    
                                                    
                                                    
                                                </a>
                                            </div>
                                @endif
                                 
                                @endforeach
                                            
                                            
                                        </div>
                                    </div>
                                
                                
                                
                                
                                
                      
                      
                      
                      
                      
                      
                                
                    
                  </form>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close" >{{trans('dd_messaging.delete_confirmation_Cancel')}}</button>
                  <button class="btn btn-primary" type="button"  id="selectuser" onclick="selecteduser();">Select User</button>
                </div>
              </div>
            </div>
          </div>
     
     
     
     
     
     
     
     
     
     
     
     
     
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
     
     
     

          <!--
            END - Secondary Top Menu
            -->
@if(isset($totalfriendcount) && !empty($totalfriendcount) && $totalfriendcount > 0)
        <div class="content-i">
          <div class="content-box">
            <!--
              start - Due Diligence Process
              -->
            <div class="row">
              <div class="col-sm-12">
                <div class="element-wrapper">
                  <div class="element-header">
                    <h6>
                      Messaging
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
                                <div class="element-search search-multiple">
                                  <input placeholder="Search by name or company..." type="text" id="txtcompanysearch">
                                  <a href="#" data-target="#selectuserbox" data-toggle="modal" onclick="setselect();" ><img src="img/user-plus-24.png"/></a> 
                                  <div class="clear"></div>
                                </div>
                              </div>
                              <div class="user-list" id="company_users">


                                @foreach($recentfriends as $f)
                                
                                @if($f->lastmessagetime)
        <div class="user-w" id='{{$f->friendid}}' onclick="selecteddiv('{{$f->friendid}}');">
                          <div class="avatar with-status status-green">
                                @if( (isset($f->profileimage) && !empty($f->profileimage) ) && File::exists(public_path('storage/user/profileimage/'.$f->profileimage)))     
                                 <img alt="" src="storage/user/profileimage/{{$f->profileimage}}">
                                        
                                       
                                @else
                                       <img alt="" src="{{ Avatar::create(strtoupper($f->firstname) .' ' . strtoupper($f->lastname))->toBase64() }}">  

                                 @endif

                                  </div>
                                  
                                  <div class="user-info">
                                   <!--    @if($f->lastmessagetime != null) -->
                                    <div class="user-date" id='{{$f->lastmessagetime}}'>
                                      <!-- 2 hours -->
                                      @if($f->lastmessagetime != null)
                                      {{$f->lastmessagetime}}
                                      @endif
                                    </div>
                                     <!--  @endif -->
                                    <div class="user-name" id='username{{$f->friendid}}'>
                                       {{ $f->firstname .' ' . $f->lastname }}
                                    </div>
                                    <input type="hidden" id='groupid{{$f->friendid}}' value='{{$f->groupid}}'>
                                    
                                    <input type="hidden" id="asifhidden" name="asifhidden" value="">
                                    
                                    <div id= value='{{$f->groupid}}' class="last-message">
                                     {{$f->company}}
                                    </div>
                                  </div>
                                </div> 
                                @endif
                                @endforeach

                             </div>
                            </div>
                            <div class="full-chat-middle">
                              <div class="chat-head">
                                <div class="user-info">
                              <span>To:</span><a id="chattitle" href="#">Select a friend</a>
                                </div>
<!--                                <div class="user-actions">
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
                                </div>-->
                              </div>
                              <div class="chat-content-w">
                                <div class="chat-content" id="chatasif">
                                  
<!--                                   
                                  <div class="chat-message">
                                    <div class="chat-message-content-w">
                                      <div class="chat-message-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                      </div>
                                    </div>
                                    <div class="chat-message-avatar">
                                      <img alt="" src="img/avatar3.jpg">
                                    </div>
                                    <div class="chat-message-date">
                                      9:12am 
                                    </div>
                                    <div class="edit-dlt">
                                      <i class="os-icon os-icon-edit-1"></i>
                                      <i class="os-icon os-icon-ui-15"></i>
                                    </div>
                                  </div>
                                  <div class="chat-date-separator">
                                    <span>Yesterday</span>
                                  </div>


                                  <div class="chat-message self">
                                    <div class="chat-message-content-w">
                                      <div class="chat-message-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                      </div>
                                    </div>
                                    <div class="edit-dlt">
                                      <i class="os-icon os-icon-edit-1"></i>
                                      <i class="os-icon os-icon-ui-15"></i>
                                    </div>
                                    <div class="chat-message-date">
                                      1:23pm
                                    </div>                                    
                                    <div class="chat-message-avatar">
                                      <img alt="" src="img/avatar1.jpg">
                                    </div>
                                  </div>

                                  <div class="chat-message">
                                    <div class="chat-message-content-w">
                                      <div class="chat-message-content">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                      </div>
                                    </div>
                                    <div class="chat-message-avatar">
                                      <img alt="" src="img/avatar3.jpg">
                                    </div>
                                    <div class="chat-message-date">
                                      3:45am
                                    </div>
                                    <div class="edit-dlt">
                                      <i class="os-icon os-icon-edit-1"></i>
                                      <i class="os-icon os-icon-ui-15"></i>
                                    </div>
                                  </div> -->

                                </div>
                              </div>
                              <div class="chat-controls">
                                <div class="chat-input">
                                  <input id="txtmessage" placeholder="Type your message here..." type="text">
                                </div>
                                <div class="chat-input-extra">
                                  <div class="chat-extra-actions">
                                    &nbsp;
                                  </div>
                                  <div class="chat-btn">
                                    <!-- <a class="btn btn-primary btn-sm" href="#">Send</a> -->
                                    <button class="btn btn-primary btn-sm" onclick='fnsendmessage();'>Send</button>
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
                              <input class="message-input" placeholder="Type your message here..." type="text">
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
@else
            
        <div class="content-i">
          <div class="content-box">
            <!--
              start - Due Diligence Process
              -->
            <div class="row">
             <div class="element-box element-wrapper-marging-btm col-md-12">
                             <h5 class="form-header">
                                 No Friend Exist   
                             </h5>
                             <div class="form-desc">
                                You cant send message to anyone as no friend exists of yours. 
                             </div>
 
                          
                         </div>
                </div> 
              </div> 
            </div> 
            
            
            
            
            @endif
      </div>



      @endsection

<input type='hidden' id='selectedmessagebody' value="">
<input type='hidden' id='selectedmessageid' value="">
<input type='hidden' id='selecteduserid' value="">

<input type='hidden' id='groupid' value="">


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

      
             if(data.receiverid=='{{$user_loggedin}}' || data.senderid=='{{$user_loggedin}}')
             {

      $('#groupid'+data.senderid).val(data.message);
      var curtime=getCurrentDateTime();
      $('#'+data.senderid+' .user-date').html(moment(curtime).fromNow());
  
     //Check whether the receiver message box is selected....
        var selectedReceiverID= $('#selecteduserid').val();
        if(selectedReceiverID==data.senderid)
        {
          RefereshChaat(data.message);
        }
       else if(data.senderid=='{{$user_loggedin}}')
        {
          RefereshChaat(data.message);
        }

        }
           
                
                
		
	});
        

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
                $('#chatasif').html('');
                $('#chatasif').html(data);
              
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
        
   
  function selecteddiv(count)
  {
    
      var userid=count;/*$('#idlabel'+count).val();*/
      $('#selecteduserid').val(userid);
      
      
      var groupid=$('#groupid'+count).val();
      
      //Asif code to count the read messages
    
     $.get('/setreadcount?readuserid='+count,function(data){
         
         $('.new-messages-count').html(data.count);
        $('.os-dropdown.light.message-list').html(data.view);
         //alert(data)
     });
     
      
     //
     
     $('#groupid').val(groupid);
     
       $(".user-w").removeClass("mail-active");
      
       $('#chattitle').text($('#username'+count).html());
      $('#'+count).addClass("mail-active");
      var csrf_token = $('meta[name="csrf-token"]').attr('content');
      var v_token = encodeURIComponent(csrf_token);
      
      if(userid!=null)
      {

/*        $.post('getmessage',{'recipientid':groupid,'_token':v_token},function(data){
          debugger;
          $('#chatasif').html('');
           $('#chatasif').html(data);
        });*/
        ajaxLoad('/getmessage?groupid='+groupid);


      }
     

  }
  
  
  function fnsendmessage()
  {
         var message= $('#txtmessage').val();
         message=$.trim(message);
         if(message=="")
         {
             return;
         }
      var userid=$('#selecteduserid').val();
   
      var groupid=$('#groupid').val();
      var csrf_token = $('meta[name="csrf-token"]').attr('content');
      var v_token = encodeURIComponent(csrf_token);
      $.post('postchatmessage',{'userid':userid,'message':message,'groupid':groupid,'_token':v_token},function(data){
      
       if(data.groupid=='error')
       {
          alert('Some Error happened during processing...'); 
       }
       else
       {
          /*$('input[name=asifhidden]').val(data.groupid);*/
       
          $('#groupid'+userid).val(data.groupid);
           var curtime=getCurrentDateTime();
           $('#'+userid+' .user-date').html(moment(curtime).fromNow());
       }
        
      });
      
  }
  
document.getElementById("txtmessage").onkeypress = function(event){
if (event.keyCode == 13 || event.which == 13){
fnsendmessage();
}
};

function RefereshChaat(groupid)
{
  ajaxLoad('/getmessage?groupid='+groupid);
  $('#txtmessage').val('');
}

//for refreshing the left page
function refresleftchaat(groupid)
{
    
    ajaxLoad('/getfriend?groupid='+groupid);
    //$('#txtmessage').val('');
    
}
//





//Used to Handle Load More Functionalities.........
      function fnLoadMoreMessage1()
      {
    
           var ttlMessages=$('#totalmessagecount').val();
           var mdisplayonce=$('#messagedisplaycount').val();
           var groupid=$('#groupid').val();
           
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
           
           
           
           var url1='/loadmore-messages?alreadyloaded='+alreadyloaded_cnt+'&totalmessagecount='+ttlMessages+'&firstrecentdate='+firstrecentdate+'&groupid='+groupid ;
          
        $.ajax({
            type: "GET",
            url:url1,
            contentType: false,
            success: function (data) {
                
               
               

             
              $("#loadmore").remove();

              var newdata = data;
              var olddata = $('#chatasif').html();
            
           
            
            
            $('#chatasif').html(newdata + olddata);
              
              //$('#div_chatmessages').html(newdata);
              
              
              
            //  $('#div_chatmessages').html(newdata + olddata);

 /*               $('#div_chatmessages').html('');
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



  function fnSearchCompanyUsers(searchval)
      {
        var searchtext=searchval;
        //var pipelinedealid=$('#pipelinedealid').val();
      
        $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
         });

        var formdata = new FormData();
    
        formdata.append("searchtext",searchtext);
        //formdata.append("pipelinedealid",pipelinedealid);
        formdata.append("_token",'{{csrf_token()}}');

       $.ajax({
            url: '/companymessaging-user-search',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
              //  alert(data);
              //  console.log(data);
              
                $("#company_users").html('');
                $("#company_users").html(data);
                 
            },
            error: function (err, result) {
            
                alert("Error" + err.responseText);
            }
        });
    }



   function fnSetIDToDelete(selectedID)
  {
    $('#selectedmessageid').val(selectedID);
  }

 function fnDeleteSelectedMessage()
  {
     
      //$('#btn_del_yes').removeAttr("disabled");
    var messageid=$('#selectedmessageid').val();
    var userid=$('#selecteduserid').val();
         
      var groupid=$('#groupid'+userid).val();
//      $('#btn_del_yes').prop("disabled",true);
        $.ajaxSetup({
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
       });

        var formdata = new FormData();
        formdata.append("messageid",messageid);
        formdata.append("_token",'{{csrf_token()}}');

       $.ajax({
            url: '/deletecompanymessage',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
 
       if(data.message=='Failed')
       {
          alert('Some Error happened during processing...'); 

       }
       else
       {
         $("#mdel_close").click();
         $("div.modal-backdrop").remove();
           RefereshChaat(groupid);

       }
              
            },
            error: function (err, result) {
              $('#btn_del_yes').prop("disabled",true);
                alert("Error" + err.responseText);
            }
        });

  }


 function fnSetIDandMessage(id,message)
  {
    $('#selectedmessageid').val(id);
    $("#selectedmessagebody").val(message);
    $("#current_message").val(message);
    $('#errorMessage').text('');
  }
  
  
  function fnUpdateSelectedMessage()
  {
  
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
            url: '/updatecompanymessage',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
   
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
        $('#message_update_modal').modal('hide');
        $('#current_message').text('');
         RefereshChaat(groupid);

       }
              
            },
            error: function (err, result) {
              $('#mupdate_close').prop("disabled",false);
                alert("Error" + err.responseText);
            }
        });
  }
 


var timer;
  $("#txtcompanysearch").keyup(function() {
    clearTimeout(timer);
    var ms = 3000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
      fnSearchCompanyUsers(val);
    }, ms);
  });



function showalluser()
{
   $('#mySmallModalLabel').modal('show');
}

function selectbox(selected)
{
   
    if($('#flat'+selected).is(":checked")==false)
  {
    $('#flat'+selected).prop('checked', true);
    $('#select'+selected).text('Selected');
  $('#flat'+selected).addClass("checked");
   }
   
   else
  {
    $('#flat'+selected).prop('checked', false);
    $('#select'+selected).text('Please Select');
    $('#flat'+selected).removeClass("checked");
   }
   
   
   
}
function closeme()
{
    
    //$('.checkclass').prop('checked', false);
}

function selecteduser()
{
    yourArray=[];
     $(".checkclass:checked").each(function(){
    yourArray.push($(this).val());
     });
     
  
      
//     var searchtext=searchval;
        //var pipelinedealid=$('#pipelinedealid').val();
      
        $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
         });

        var formdata = new FormData();
    
        formdata.append("myarray",yourArray);
        //formdata.append("pipelinedealid",pipelinedealid);
        formdata.append("_token",'{{csrf_token()}}');

       $.ajax({
            url: '/companymessaging-user-check',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
//               alert(data);
//                console.log(data);
//              debugger;
                $("#company_users").html('');
                
                
                $("#company_users").html(data);
                
                
             
       
                 
            },
            error: function (err, result) {
           
                alert("Error" + err.responseText);
            }
        });
     
     
     
     
     
     $('.checkclass').prop('checked', false);
     $('#selectuserbox').modal('toggle');
    
}

function setselect()
{
    
    $('.form-control.checkclass.checked').prop('checked', true);
    
}


var getselectedid='<?php if(isset($_GET['userid']) && !empty($_GET['userid'])){echo $_GET['userid'];}?>';
if(getselectedid.length > 0)
{
    debugger;
    selecteddiv(getselectedid);
    $('.chat-content-w').animate({scrollTop:$('.chat-content-w').height()}, 'slow');
}





</script>

@endsection

