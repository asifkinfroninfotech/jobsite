
@php
$helper=\App\Helpers\AppHelper::instance();
$loggedinuserid=Session('userid');
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
$DealProfileImagePath= \App\Helpers\AppGlobal::$DealProfileImagePath;

@endphp

<div class="element-box-tp">
    <div class="table-responsive">
      <table class="table table-padded" id="myTable">
        <thead>
          <tr>
            <th>
               Deal Name
            </th>
            <th>
              Company
            </th> 
            <th>
             Company Type
            </th>
            <th>
              Request Type
            </th>

            <th>
                Parent
            </th>
                      
            <th class="text-right">
              Action
            </th>                            
          </tr>
        </thead>
        <tbody>
            
           
@foreach($RequestsOnMyAndOthersDDs as $f)

<tr>
    <td>

            <div class="user-with-avatar">
                    <a href="/deals/view-deal?{{'dealid='.$f->dealid }}">
                      @if(isset($f->dealprofileimage) && !empty($f->dealprofileimage) && File::exists($DealProfileImagePath.$f->dealprofileimage))
                      <img alt="" src="{{$DealProfileImagePath.$f->dealprofileimage}}">
                      @else
                      <img alt="" src="{{Avatar::create(strtoupper($f->projectname))->toBase64()}}">
                     
                      @endif
                    <span class="d-none d-xl-inline-block">{{$f->projectname}}</span>
                     </a>
                 </div>
               

               </td>


               <td>
                    <div class="user-with-avatar">
                            <a href="/company/profile/view?{{'company='.$f->companyid .'&companytype='.$f->companytype}}">
                              @if(isset($f->profileimage) && !empty($f->profileimage) && File::exists($CompanyProfileImagePath.$f->profileimage))
                              <img alt="" src="{{$CompanyProfileImagePath.$f->profileimage}}">
                              @else
                              <img alt="" src="{{Avatar::create(strtoupper($f->company))->toBase64()}}">
                             
                              @endif
                            <span class="d-none d-xl-inline-block">{{$f->company}}</span>
                             </a>
                         </div>
               </td>
               <td>
                   {{$f->companytype}}
               </td>
               <td>
                   @if($f->RequestType=='New Request')
                   Request To Access
                   @elseif($f->RequestType=='Invited')
                   Invitation To Join
                   @endif
                 
               </td>
               <td>
                 {{-- {{$f->Parent}} --}}
                 @if($f->Parent=='Your Company')
                 Self
                 @elseif($f->Parent=='Other Company')
                 Other
                 @endif
               </td>
             
               <td class="text-right">
                <div class="btn-group mr-1 mb-1">
                    <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>
                    <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                        @if($f->Parent=='Your Company' && $f->RequestType=='New Request')
                       <a class="dropdown-item" href="#" onclick="OpenPopUpAndSetIds('{{$f->pipelinedealid}}','{{$f->RequestType}}','{{$f->companyid}}');">Grant Access</a>
                        <a class="dropdown-item" href="#" onclick="OpenDeclinePopup('{{$f->pipelinedealid}}','{{$f->RequestType}}','{{$f->companyid}}');">Decline</a>
                        @endif
                        {{-- @if($f->Parent=='Your Company' && $f->RequestType=='Invited')
                        <a class="dropdown-item" href="#">Remove Invite</a>
                        @endif
                        @if($f->Parent=='Other Company' && $f->RequestType=='New Request')
                        <a class="dropdown-item" href="#">Cancel Access Request</a>
                        @endif --}}
                        @if($f->Parent=='Other Company' && $f->RequestType=='Invited')
                        <a class="dropdown-item" href="#" onclick="OpenAcceptInvitePopup('{{$f->pipelinedealid}}','{{$f->RequestType}}','{{$f->companyid}}');">Accept Invite</a>
                        <a class="dropdown-item" href="#" onclick="OpenRejectInvitation_Popup('{{$f->pipelinedealid}}','{{$f->RequestType}}','{{$f->companyid}}');">Reject Invite</a>
                        @endif

                    </div>
                </div>
               </td>                           
             </tr> 



@endforeach                                                                      
          
        </tbody>
        
        
      </table>

    </div>
  </div>




