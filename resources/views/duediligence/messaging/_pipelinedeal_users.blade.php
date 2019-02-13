<?php 
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
?>
   
   
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
                       
<div class="user-w" id='{{$user->userid}}' onclick="fnSelectedUserChanged('{{$user->userid}}');">
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