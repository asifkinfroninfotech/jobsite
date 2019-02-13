<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])

@section('content')

<div class="content-w portfolio-custom-vk due-dili-process">
        <!--------------------
          START - Secondary Top Menu
          -------------------->
        
          
          
          
          
          @include('shared._top_menu')
          
          
          
          
        <!--------------------
            END - Secondary Top Menu
            -------------------->

        <div class="content-i">
          <div class="content-box">
            <!--------------------
              start - Due Diligence Process
              -------------------->
            <div class="row">
              <div class="col-sm-12">
                <!--START - Control panel above projects-->
        <div class="content-i control-panel">
          <div class="content-box-tb">
            <div class="os-tabs-w">
              <div class="os-tabs-controls">
                <ul class="nav nav-tabs upper">
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#tab_overview"> Due Diligence Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#tab_sales">Due Diligence Process</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link active" data-toggle="tab" href="#tab_sales"> Messaging</a>
                  </li>
                </ul>
                <h5 class="process-top-rit">
                  Kinara Capital
                </h5>
              </div>
            </div>
          </div>
        </div>        
        <!--END - Control panel above projects-->

                
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
                                <div class="element-search">
                                  <input placeholder="Search by name or company..." type="text">
                                <div class="clear"></div>
                                </div>
                              </div>
                              <div class="user-list">
<!--                                <div class="user-w">
                                  <div class="avatar with-status status-green">
                                    <img alt="" src="img/kr.png">
                                  </div>
                                  <div class="user-info">
                                    <div class="user-date">
                                      12 min
                                    </div>
                                    <div class="user-name">
                                      General 
                                    </div>
                                    <div class="last-message">
                                      Kinara Capital
                                    </div>
                                  </div>
                                </div>-->

                                @foreach($recentfriends as $f)
                                 
      <div class="user-w" id='{{$f->friendid}}' onclick="selecteddiv('{{$f->friendid}}');">
                          <div class="avatar with-status status-green">

                            
                              
                              
                              @if($f->profileimage==null)
                                      <img alt="" src="{{ Avatar::create($f->firstname .' ' . $f->lastname)->toBase64() }}">  
                                       
                                @else
                                       <img alt="" src="storage/public/user/profileimage{{$f->profileimage}}">

                                 @endif

                                  </div>
                                    <div class="user-date">
                                  <div class="user-info">
                                     {{$f->lastmessagetime}}
                                    </div>
                                    <div class="user-name" id='username{{$f->friendid}}'>
                                       {{ $f->firstname .' ' . $f->lastname }}
                                    </div>
                                    <input type="hidden" id='groupid{{$f->friendid}}' value='{{$f->groupid}}'>
                                    <div id= value='{{$f->groupid}}' class="last-message">
                                     {{$f->company}}
                                    </div>
                                  </div>
                                </div>
                                @endforeach
       
                 
<!--                                <div class="user-w">
                                  <div class="avatar with-status status-green">
                                    <img alt="" src="img/avatar3.jpg">
                                  </div>
                                  <div class="user-info">
                                    <div class="user-date">
                                      24 min
                                    </div>
                                    <div class="user-name">
                                      Simon Backs
                                    </div>
                                    <div class="last-message">
                                      Artha Venture Capital
                                    </div>
                                  </div>
                                </div>-->
<!--                                <div class="user-w">
                                  <div class="avatar with-status status-green">
                                    <img alt="" src="img/avatar1.jpg">
                                  </div>
                                  <div class="user-info">
                                    <div class="user-date">
                                      7 min
                                    </div>
                                    <div class="user-name">
                                      Kelley Brooks
                                    </div>
                                    <div class="last-message">
                                      Artha Venture Capital
                                    </div>
                                  </div>
                                </div>-->
<!--                                <div class="user-w mail-active">
                                  <div class="avatar with-status status-green">
                                    <img alt="" src="img/avatar7.jpg">
                                  </div>
                                  <div class="user-info">
                                    <div class="user-date">
                                      4 hours
                                    </div>
                                    <div class="user-name">
                                      Vinie Jones
                                    </div>
                                    <div class="last-message">
                                      Artha Venture Capital
                                    </div>
                                  </div>
                                </div>-->
<!--                                <div class="user-w">
                                  <div class="avatar with-status status-green">
                                    <img alt="" src="img/avatar1.jpg">
                                  </div>
                                  <div class="user-info">
                                    <div class="user-date">
                                      2 days
                                    </div>
                                    <div class="user-name">
                                      Brad Pitt
                                    </div>
                                    <div class="last-message">
                                      Artha Venture Capital
                                    </div>
                                  </div>
                                </div>-->
                              </div>
                            </div>
                            <div class="full-chat-middle">
                              <div class="chat-head">
                                <div class="user-info">
                              <span>To:</span><a id="chattitle" href="#">Please Select</a>
                                </div>
                                <div class="user-actions">
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
                                </div>
                              </div>
                              <div class="chat-content-w">
                                <div class="chat-content" id="chatasif">
                                  
                                    
                                    
                                    
<!--                                  <div class="chat-date-separator">
                                    <span>Yesterday</span>
                                  </div>-->
                                    
                                    
                                    
                                    
                                    
<!--                                  <div class="chat-message self">
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
                                  </div>-->
<!--                                  <div class="chat-message">
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
                                  </div>-->
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
<!--                                    <a class="btn btn-primary btn-sm" href="#">Send</a>-->
                                    
                                    <button class="btn btn-primary btn-sm" onclick='fnsendmessage();'>Send</button>
                                    
                                    <button class="btn btn-primary btn-sm" onclick='fn1sendmessage();'>pusherSend</button>
                                    
                                    
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
                              <input class="message-input"  placeholder="Type your message here..." type="text">
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
    

<input type='hidden' id='selecteduserid' value="">
<input type='hidden' id='groupid' value="">
@endsection
@section('scripts')



//my pusher code
<script src="https://js.pusher.com/4.0/pusher.min.js"></script>


<script type="text/javascript">
        
   
   Pusher.logToConsole = true;

	var pusher = new Pusher('3febfe38a2f74f031eb9', {
	  cluster: 'ap2',
	  encrypted: true
	});

	var channel = pusher.subscribe('my-channel');
	channel.bind('my-event', function(data) {
		console.log(data.message);
		
	});

   
   
  //my pusher code 
   
   
   
   
  function selecteddiv(count)
  {
    debugger;
      var userid=count;/*$('#idlabel'+count).val();*/
      $('#selecteduserid').val(userid);
     
     var groupid=$('#groupid'+count).val();
$('#groupid').val(groupid);
       $(".user-w").removeClass("mail-active");
      
       $('#chattitle').text($('#username'+count).html());
      $('#'+count).addClass("mail-active");
      var csrf_token = $('meta[name="csrf-token"]').attr('content');
      var v_token = encodeURIComponent(csrf_token);
      
      if(userid!=null)
      {

        $.post('getmessage',{'recipientid':groupid,'_token':v_token},function(data){
           $('#chatasif').html(data);
        });

      }
     

  }
  
  
  function fnsendmessage()
  {
      debugger;
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
       debugger;
       if(data.groupid=='error')
       {
          alert('Some Error happened during processing...'); 
       }
       else
       {
           RefereshChaat(data.groupid);
       }
        
      });
      
  }
  
  
  
  function fn1sendmessage()
  {
      debugger;
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
      $.post('postchatmessage1',{'userid':userid,'message':message,'groupid':groupid,'_token':v_token},function(data){
       debugger;
       if(data.groupid=='error')
       {
          alert('Some Error happened during processing...'); 
       }
       else
       {
           RefereshChaat(data.groupid);
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
       var csrf_token = $('meta[name="csrf-token"]').attr('content');
       var v_token = encodeURIComponent(csrf_token);
        $.post('getmessage',{'recipientid':groupid,'_token':v_token},function(data){
           $('#chatasif').html(data);
        });
}
</script>

@endsection