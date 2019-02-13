
   





<i class="os-icon os-icon-mail-14"></i>
              <div class="new-messages-count">
                    {{$data['count']}}
                  </div>
                  <div class="os-dropdown light message-list">
                    <div class="icon-w">
                      <i class="os-icon os-icon-mail-14"></i>
                    </div>
                    <ul>
                     @foreach($data['totalmessageusers'] as $totalmessages)  
                        
                      <li>
                        <a href="#">
                           
                          
                          <div class="user-avatar-w ">
                              @if(empty($totalmessages->profileimage) || !isset($totalmessages->profileimage))
                               <img alt="" src="{{Avatar::create($totalmessages->firstname.' '.$totalmessages->lastname)->toBase64()}}">
                              @else
                               <img alt="" src="storage/user/profileimage/{{$totalmessages->profileimage}}">
                              @endif
                              
                                                      </div>
                             
                          <div class="message-content">
                            <h6 class="message-from">
                              {{$totalmessages->firstname}} {{$totalmessages->lastname}}
                            </h6>
                            <h6 class="message-title">
                              Account Update
                            </h6>
                          </div>
                           
                            
                        </a>
                      </li>
                        
                      @endforeach
                      
                    </ul>
                  </div>
               