<?php
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();

?>
@foreach($all_users as $user)

<tr>
                              <td>

                                  <div class="user-with-avatar  ">
                                      <a href="user/profile/view?user={{$user->userid}}">
                                                 @if($user->profileimage==null)
                                       <img alt="" src="{{ Avatar::create(ucfirst($user->firstname) .' ' . ucfirst($user->lastname))->toBase64() }}">   
                                @else
                                       <img alt="" src="{{$UserProfileImagePath . $user->profileimage}}">
                                 @endif                     
                                          
                                   <span class="d-none d-xl-inline-block">{{$user->firstname.''.$user->lastname}}</span>
                                 </a>
                                
                              </div>
                            </td>
                            <td>
                             <div class="user-with-avatar">
<!--                                  <input type="checkbox" class='selectuser' value="{{$user->userid}}" onclick='assigncount();' />-->
                                  <button class="btn btn-primary" type="button" onclick="fnassignuserssave('{{$user->userid}}');" id="btnassign"> {{trans('duediligenceprocess.modal_table_assign_btn')}}</button>
                             </div>
                            </td>
                          
                            
                                                    
                          </tr> 
                          
      @endforeach                    
                          
       
      @foreach($extrausers as $user)

<tr>
                              <td>

                                  <div class="user-with-avatar  ">
                                      <a href="user/profile/view?user={{$user->userid}}">
                                                 @if($user->profileimage==null)
                                       <img alt="" src="{{ Avatar::create(ucfirst($user->firstname) .' ' . ucfirst($user->lastname))->toBase64() }}">   
                                @else
                                       <img alt="" src="{{$UserProfileImagePath . $user->profileimage}}">
                                 @endif                     
                                          
                                   <span class="d-none d-xl-inline-block">{{$user->firstname.''.$user->lastname}}</span>
                                 </a>
                                
                              </div>
                            </td>
                            <td>
                             <div class="user-with-avatar">
                                   <button class="btn btn-primary" type="button" onclick="fnassignuserssave('{{$user->userid}}');" id="btnassign"> assign</button>
                             </div>
                            </td>
                          
                            
                                                    
                          </tr> 
                          
      @endforeach   
      
      
      
      
                            