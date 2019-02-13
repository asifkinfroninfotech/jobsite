<div class="icon-w">
                      <i class="os-icon os-icon-mail-14"></i>
                    </div>
                    <ul>
                      @foreach($getmessagesusers as $getmessagesusers)  
                      <li>
                        <a href="/companymessaging?userid={{$getmessagesusers->userid}}">
                           
                          
                          <div class="user-avatar-w ">
                              @if( (isset($getmessagesusers->profileimage) && !empty($getmessagesusers->profileimage) ) && File::exists(public_path('storage/user/profileimage/'.$getmessagesusers->profileimage)))
                              
                            <img alt="" src="{{'/storage/user/profileimage/'.$getmessagesusers->profileimage}}">  
                              
                            
                            
                            @else
                            
                            <img alt="" src="{{ Avatar::create($getmessagesusers->firstname.' '.$getmessagesusers->lastname)->toBase64()}}">
                            @endif
                          </div>
                             
                          <div class="message-content">
                            <h6 class="message-from">
                              {{$getmessagesusers->firstname.' '.$getmessagesusers->lastname}}
                            </h6>
                            <h6 class="message-title">
                              Account Update
                            </h6>
                          </div>
                           
                            
                        </a>
                      </li>
                      @endforeach

                    </ul>