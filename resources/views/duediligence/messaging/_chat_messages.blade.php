

                          
                          
                          <?php 
                          $helper=\App\Helpers\AppHelper::instance();
                            $loggedinuserid=Session('userid');
       $messagedeletehour= \App\Helpers\AppGlobal::fnGet_MessageDeleteHour(); 
       $messageedithour= \App\Helpers\AppGlobal::fnGet_MessageEditHour();
       $UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
                          $CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();

                           ?>      
                              @if($display_loadmore==1) 
                              <div class="chat-date-separator" id="loadmore">
                                    <span onclick="fnLoadMoreMessage();" style="cursor:pointer;">Load More...</span>
                              </div>
                               @endif

                                  @foreach($data as $message)

                                     <?php 
$diffhour=$helper->GetDifferenceBetweenTwoDate(\Carbon\Carbon::now(),$message->created,'hours');
                                      ?>
                                   @if($message->userid==$loggedinuserid)

                                <div class="chat-message self" id='{{$message->messageid}}'>
                                    <div class="chat-message-content-w">
                                      <div class="chat-message-content">
                                         {{$message->messagebody}}
                                      </div>
                                    </div>
                                    <div class="edit-dlt">

                                      @if($diffhour<$messageedithour)
                                        <i class="os-icon os-icon-edit-1" data-target="#message_update_modal" data-toggle="modal" onclick="fnSetIDandMessage('{{$message->messageid}}','{{$message->messagebody}}');" style="cursor:pointer;"></i>
                                       @endif

                                      @if($diffhour<$messagedeletehour)
                                        {{-- <i class="os-icon os-icon-ui-15"></i> --}}
                                        <i class="os-icon os-icon-ui-15" data-target="#message_deleteModel" data-toggle="modal" onclick="fnSetIDToDelete('{{$message->messageid}}');" style="cursor:pointer;" ></i>
                                       @endif
                                      
                                    </div>
                                    <div class="chat-message-date firstrecentdate" id='{{$message->created}}'>
                                      <!-- 1:23pm -->
                                       {{$message->created}}
                                    </div>                                    
                                    <div class="chat-message-avatar">
                                
                                        <a href="/user/profile/view?user={{$message->userid}}">     
                                @if($message->profileimage==null)
                                       <img alt="" src="{{ Avatar::create($message->firstname .' ' . $message->lastname)->toBase64() }}">   
                                @else
                                       <img alt="" src="{{$UserProfileImagePath . $message->profileimage}}">
                                 @endif
                                        </a>

                                    </div>
                                  </div>
                                    
                                   @else

                                  <div class="chat-message" id='{{$message->messageid}}'>
                                    <div class="chat-message-content-w">
                                      <div class="chat-message-content">
                                       {{$message->messagebody}}
                                      </div>
                                    </div>
                                    <div class="chat-message-avatar">
                                        <a href="/user/profile/view?user={{$message->userid}}">     
                                @if($message->profileimage==null)
                                       <img alt="" src="{{ Avatar::create($message->firstname .' '. $message->lastname)->toBase64() }}">   
                                @else
                                       <img alt="" src="{{$UserProfileImagePath . $message->profileimage}}">
                                 @endif
                                        </a>
                                    </div>
                                    <div class="chat-message-date firstrecentdate" id='{{$message->created}}'>
                                         {{$message->created}}
                                    </div>
                                    {{-- <div class="edit-dlt">
                                      @if($diffhour<$messageedithour)
                                      <i class="os-icon os-icon-edit-1" data-target="#message_update_modal" data-toggle="modal" onclick="fnSetIDandMessage('{{$message->messageid}}','{{$message->messagebody}}');" style="cursor:pointer;"></i>
                                       @endif

                                      @if($diffhour<$messagedeletehour)
                                        <i class="os-icon os-icon-ui-15" data-target="#message_deleteModel" data-toggle="modal" onclick="fnSetIDToDelete('{{$message->messageid}}');" style="cursor:pointer;"></i>
                                      @endif
                                    </div> --}}
                                  </div>
                                   @endif

<!--                                   <div class="chat-date-separator">
                                    <span>Yesterday</span>
                                  </div> -->

                                  

                                  @endforeach



<input type='hidden' id='totalmessagecount' value="{{$totalmessagecount}}">
<input type='hidden' id='messagedisplaycount' value="{{$messagedisplaycount}}">
<input type='hidden' id='pushedgroupid' value="{{$groupid}}">
