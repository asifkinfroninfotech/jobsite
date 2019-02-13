@php
$helper=\App\Helpers\AppHelper::instance();
$loggedinuserid=Session('userid');
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
@endphp

  <div class="element-box-tp">
        <div class="table-responsive">
          <table class="table table-padded network-rows">
            <thead>
              <tr>
                <th>
                  Company Name
                </th>
                <th>
                 Type
                </th>
                <th>
                 Sector (s)
                </th>                           
                <th class="text-right">
                  Action
                </th>                            
              </tr>
            </thead>
            <tbody>
                
                @foreach($company as $company1)
                
            <tr id='{{$company1->companyid}}'>
                <td>
                    <a href="/company/profile/view?{{'company='.$company1->companyid .'&companytype='.$company1->companytype.'&calledfrom=tenant'}}"> 
                @if((isset($company1->profileimage) && !empty($company1->profileimage) ) && File::exists(public_path('/storage/company/profileimage/'.$company1->profileimage)))
                <img alt="" src="/storage/company/profileimage/{{$company1->profileimage}}" style="width: 50px;"/>    
                
                   @else
                   <img alt="" src="{{ Avatar::create($company1->companyname)->toBase64() }}" style="width: 50px;"/> 
                  @endif
                    </a>
                  </span><span>{{$company1->companyname}}</span>
                </td>
                <td>
                    {{$company1->companytype}}
                </td>
                <td>
                  <span>{{$company1->sectors}} 
                    @if($company1->scount>1)
                  <span class="smaller lighter">more</span>
                    @endif
                  </span>
                </td>
                <td class="text-right">
                <div class="btn-group mr-1 mb-1">
                    <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>
                    <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="#" onclick="OpenAcceptPopup('Verify','{{ $company1->companyid }}');">Verify</a>
                        <a class="dropdown-item" href="#"  onclick="OpenDeclinePopup('Decline','{{ $company1->companyid }}');">Decline</a>
                    </div>
                </div>
               </td>                             
              </tr>  
              @endforeach
             
            </tbody>
          </table>
        </div>
      </div>




