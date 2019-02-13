@php
$helper=\App\Helpers\AppHelper::instance();
$helper->headerlogics();
$url=$helper->url;
if($url=="login")
{
$profileimage=$helper->profileimage;
$firstname=$helper->firstname;
$lastname=$helper->lastname;
if(isset($helper->messagescount) && !empty($helper->messagescount))
{
   $messagecount=$helper->messagescount;
}
else 
  {
    $messagecount=0;
  }

$getmessagesusers=$helper->getmessagesusers;
}
if($url=="logout")
{
$profileimage=$helper->profileimage;
$firstname=$helper->firstname;
$lastname=$helper->lastname;
echo "<script>window.location.href='/login';</script>";      
}
@endphp


<!--------------------
          START - Secondary Top Menu
          -------------------->
          <div class="top-menu-secondary">              
              <!--------------------
              START - Top Menu Controls
              -------------------->
              <div class="top-menu-controls">
                {{-- <div class="element-search d-none d-xl-block">
                  <input placeholder="Start typing to search..." type="text">
                </div>
                <div class="top-icon top-search os-dropdown-trigger d-xl-none">
                  <i class="os-icon os-icon-ui-37"></i>
                  <div class="os-dropdown light mobile-search">
                    <input placeholder="Start typing to search..." type="text">
                  </div>
                </div> --}}
                <!--
                START - Messages Link in secondary top menu
                -->
                <div class="messages-notifications os-dropdown-trigger os-dropdown-center">
                  <i class="os-icon os-icon-mail-14"></i>
                  <div class="new-messages-count">
                      @if(isset($messagecount) || !empty($messagecount))
                    {{$messagecount}}
                    @endif
                  </div>
                  <div class="os-dropdown light message-list" >
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
<!--                      <li>
                        <a href="#">
                          <div class="user-avatar-w">
                            <img alt="" src="/img/avatar2.jpg">
                          </div>
                          <div class="message-content">
                            <h6 class="message-from">
                              Phil Jones
                            </h6>
                            <h6 class="message-title">
                              Secutiry Updates
                            </h6>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="user-avatar-w">
                            <img alt="" src="/img/avatar3.jpg">
                          </div>
                          <div class="message-content">
                            <h6 class="message-from">
                              Bekky Simpson
                            </h6>
                            <h6 class="message-title">
                              Vacation Rentals
                            </h6>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="user-avatar-w">
                            <img alt="" src="/img/avatar4.jpg">
                          </div>
                          <div class="message-content">
                            <h6 class="message-from">
                              Alice Priskon
                            </h6>
                            <h6 class="message-title">
                              Payment Confirmation
                            </h6>
                          </div>
                        </a>
                      </li>-->
                    </ul>
                  </div>
                </div>
                <!--------------------
                END - Messages Link in secondary top menu
                --------------------><!--------------------
                START - Settings Link in secondary top menu
                -------------------->
                {{-- <div class="top-icon top-settings os-dropdown-trigger os-dropdown-center">
                  <i class="os-icon os-icon-ui-46"></i>
                  <div class="os-dropdown">
                    <div class="icon-w">
                      <i class="os-icon os-icon-ui-46"></i>
                    </div>
                    <ul>
                      <li>
                        <a href="/user/profile/edit"><i class="os-icon os-icon-ui-49"></i><span>Profile Settings</span></a>
                      </li>
                      <li>
                        <a href="#"><i class="os-icon os-icon-grid-10"></i><span>Billing Info</span></a>
                      </li>
                      <li>
                        <a href="#"><i class="os-icon os-icon-ui-44"></i><span>My Invoices</span></a>
                      </li>
                      <li>
                        <a href="#"><i class="os-icon os-icon-ui-15"></i><span>Deactivate Account</span></a>
                      </li>
                    </ul>
                  </div>
                </div> --}}
                <!--------------------
                END - Settings Link in secondary top menu
                --------------------><!--------------------
                START - User avatar and menu in secondary top menu
                -------------------->
                <div class="logged-user-w">
                  <div class="logged-user-i">
                    <div class="avatar-w">
                      @if(!isset($profileimage) || empty($profileimage) || $profileimage=="")
                            <img alt="" src="{{ Avatar::create($firstname.' '.$lastname)->toBase64()}}">
                            
                            @else
                            
                            <img alt="" src="{{'/storage/user/profileimage/'.$profileimage}}">
                            @endif
                    </div>
                    <div class="logged-user-menu admin-login-row">
                      <div class="logged-user-avatar-info">
                        <div class="avatar-w">
                         @if(!isset($profileimage) || empty($profileimage) || $profileimage=="")
                            <img alt="" src="{{ Avatar::create($firstname.' '.$lastname)->toBase64()}}">
                            
                            @else
                            
                            <img alt="" src="{{'/storage/user/profileimage/'.$profileimage}}">
                            @endif
                        </div>
                        <div class="logged-user-info-w">
                          <div class="logged-user-name">
                            {{$firstname.' '.$lastname}}
                          </div>
                          <div class="logged-user-role">
                            Super Administrator
                          </div>
                        </div>
                      </div>
                      <div class="bg-icon">
                        <i class="os-icon os-icon-wallet-loaded"></i>
                      </div>
                      <ul>
<!--                        <li>
                          <a href="#"><i class="os-icon os-icon-mail-01"></i><span>Incoming Mail</span></a>
                        </li>-->
                        {{-- <li>
                          <a href="/user/profile/view"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a>
                        </li> --}}
<!--                        <li>
                          <a href="#"><i class="os-icon os-icon-coins-4"></i><span>Billing Details</span></a>
                        </li>-->
<!--                        <li>
                          <a href="#"><i class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
                        </li>-->
                        <li>
                    <!--       <a href="#"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a> -->
                                       <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="os-icon os-icon-signs-11"></i>
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>

                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!--------------------
                END - User avatar and menu in secondary top menu
                -------------------->
              </div>
              <!--------------------
              END - Top Menu Controls
              -------------------->
            </div>
            <!--------------------
            END - Secondary Top Menu
            -------------------->