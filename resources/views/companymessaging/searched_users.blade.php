<?php 
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
?>
   


                        @foreach($involvedusers as $user)
                       @if($user->lastmessagetime)
<div class="user-w" id='{{$user->userid}}' onclick=";selecteddiv('{{$user->userid}}');">
                          <div class="avatar with-status status-green">
                        @if($user->profileimage==null)
                               {{-- <img alt="" src="img/avatar1.jpg"> --}}
                               <img alt="" src="{{ Avatar::create($user->firstname .' ' . $user->lastname)->toBase64() }}">  
                        @else
                               <img alt="" src="{{$UserProfileImagePath . $user->profileimage}}">
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
                         @endif    
                        @endforeach