@php
$helper=\App\Helpers\AppHelper::instance();
$connectcontent=$helper->GetHelpModifiedText(trans('network.connect_content'));


@endphp
<div class="element-box-tp">
                    <div class="table-responsive">
                      <table class="table table-padded network-rows">

                        
                         <thead id="userslist" >
                          <tr>
                            <th>
                              {{trans('network.table_user_company_name')}}
                            </th>
                            <th>
                            {{trans('network.table_user_sector_title')}}
                            </th> 
                            <th>
                            {{trans('network.table_user_username_title')}}
                            </th> 
                            <th>
                            {{trans('network.table_user_position_title')}}
                            </th> 
                            
                            <th class="text-right">
                              {{trans('network.table_user_action_title')}}
                            </th>                            
                          </tr>
                        </thead>

                        
                        

                        
                        <tbody>
                            
                      @foreach($company as $company1)
                            
                        <tr id='{{$company1->companyid}}'>
                            <td>
                                <div class="user-with-avatar">
                                <a href="/company/profile/view?{{'company='.$company1->companyid .'&companytype='.$company1->companytype}}"> 
                              
                               @if( (isset($company1->profileimage) && !empty($company1->profileimage) ) && File::exists(public_path('storage/company/profileimage/'.$company1->profileimage)))
                               <img alt="" src="storage\company\profileimage\{{$company1->profileimage}}" />
                               
                               @else
                                <img alt="" src="{{ Avatar::create($company1->companyname)->toBase64() }}" />   
                              @endif
                                </a>
                              </span><span>{{$company1->companyname}}</span>
                              </div>
                            </td>
                            <td>
                              <span>{{$company1->sectors}} 
                                @if($company1->scount>1)
                              <span class="smaller lighter">more</span>
                                @endif
                              </span>
                            </td>
                            <td>
                              <span>
                               {{$company1->email}} 
                               
                              </span>
                            </td>
                            <td>
                              <span>
                               {{$company1->userposition}} 
                               
                              </span>
                            </td>
                            
                            
                            
                            <td class="text-right">
                             
                              
                              @if(isset($getfriend) && !empty($getfriend))
                              @foreach($getfriend as $friend)
                              @php
                              $friendflag=0;
                              @endphp
                              @if($friend->friendid==$company1->userid && $friend->recordtype=="friend")  
                              @php $friendflag=1;break; @endphp
                              @endif
                              @if($friend->friendid==$company1->userid && ($friend->recordtype=="sender") )  
                              @php $friendflag=2;break; @endphp
                              @endif
                              
                              @endforeach
                              @endif
                              @if(isset($friendflag))
                             @if($friendflag==1 || $getcompanyid==$company1->companyid)
                              <a class="btn btn-success btn-sm" href="/companymessaging?userid={{$company1->userid}}">Send Message</a>
                              
                              @else
                              @php
                              $userid=session('userid');
                              @endphp
                              @if($friendflag==2)
                              <a class="btn btn-success btn-sm" href="#">Request Sent</a>
                              @else
                              <a class="btn btn-success btn-sm" id="friend{{$company1->userid}}" data-placement="top" data-toggle="tooltip" data-original-title="{{$connectcontent}}"  onclick="friendsender('{{$userid}}','{{$company1->userid}}')" href="#">Connect</a>
                              @endif
                              @endif
                             @else
                               @if($getcompanyid!=$company1->companyid)
                               @php $userid=session('userid'); @endphp
                               <a class="btn btn-success btn-sm" id="friend{{$company1->userid}}" data-placement="top" data-toggle="tooltip" data-original-title="{{$connectcontent}}" onclick="friendsender('{{$userid}}','{{$company1->userid}}')" href="#">Connect</a>
                               @endif
                              @endif
                            </td>                           
                          </tr>  
                          @endforeach
                         
                        </tbody>
                       
                        
                        
                      </table>
                    </div>
                  </div>
                   <!--START - next pagers-->
                   
                  {{ $company->links('network.network_pagination') }}
                   
                   
                   
                  