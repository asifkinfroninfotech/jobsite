

                          <?php 
                          $helper=\App\Helpers\AppHelper::instance();
                            $loggedinuserid=Session('userid');
       $messagedeletehour= \App\Helpers\AppGlobal::fnGet_MessageDeleteHour(); 
       $messageedithour= \App\Helpers\AppGlobal::fnGet_MessageEditHour();

                           ?>        
                                  @foreach($data as $message)

                                     <?php 
$diffhour=$helper->GetDifferenceBetweenTwoDate(\Carbon\Carbon::now(),$message->created,'hours');
                                      ?>
                                   @if($message->userid==$loggedinuserid)

                                <div class="chat-message self">
                                    <div class="chat-message-content-w">
                                      <div class="chat-message-content">
                                         {{$message->messagebody}}
                                      </div>
                                    </div>
                                    <div class="edit-dlt">

                                      @if($diffhour<$messageedithour)
                                        <i class="os-icon os-icon-edit-1"></i>
                                       @endif

                                      @if($diffhour<$messagedeletehour)
                                        <i class="os-icon os-icon-ui-15"></i>
                                       @endif
                                      
                                    </div>
                                    <div class="chat-message-date" id='{{$message->created}}'>
                                      <!-- 1:23pm -->
                                       {{$message->created}}
                                    </div>                                    
                                    <div class="chat-message-avatar">

                                @if($message->profileimage==null)
                                       <img alt="" src="img/avatar1.jpg">  
                                @else
                                       <img alt="" src="img/{{$message->profileimage}}">
                                 @endif

                                    </div>
                                  </div>
                                    
                                   @else

                                  <div class="chat-message">
                                    <div class="chat-message-content-w">
                                      <div class="chat-message-content">
                                       {{$message->messagebody}}
                                      </div>
                                    </div>
                                    <div class="chat-message-avatar">
                                @if($message->profileimage==null)
                                       <img alt="" src="img/avatar1.jpg">  
                                @else
                                       <img alt="" src="img/{{$message->profileimage}}">
                                 @endif
                                    </div>
                                    <div class="chat-message-date" id='{{$message->created}}'>
                                         {{$message->created}}
                                    </div>
                                    <div class="edit-dlt">
                                      @if($diffhour<$messageedithour)
                                        <i class="os-icon os-icon-edit-1"></i>
                                       @endif

                                      @if($diffhour<$messagedeletehour)
                                        <i class="os-icon os-icon-ui-15"></i>
                                       @endif
                                    </div>
                                  </div>
                                   @endif

<!--                                   <div class="chat-date-separator">
                                    <span>Yesterday</span>
                                  </div> -->

                                  

                                  @endforeach






