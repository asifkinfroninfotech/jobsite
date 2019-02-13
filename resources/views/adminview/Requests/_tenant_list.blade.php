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
                  Tenant
                </th>
                <th>
                 Company
                </th>
                <th>
                 Email
                </th> 
                <th>
                  Phone
                 </th>
                 <th>
                  Address
                 </th>                            
                <th class="text-right">
                  Action
                </th>                            
              </tr>
            </thead>
            <tbody>
                
                @foreach($tenants as $tenant)
                
            <tr id='{{$tenant->tenantid}}'>
              <td>
                <div class="user-with-avatar  ">
                <a href="/tenant/profile/view?tenid={{$tenant->tenantid.'&calledfrom=admin'}}" target="_blank"> 
            @if( (isset($tenant->minilogoimage) && !empty($tenant->minilogoimage) ) && File::exists(public_path('/storage/tenant/minilogoimage/'.$tenant->minilogoimage))==true)
            <img alt="" src="/storage/tenant/minilogoimage/{{$tenant->minilogoimage}}"/>
               @else
                <img alt="" src="{{ Avatar::create(ucfirst($tenant->firstname).' '.ucfirst($tenant->lastname))->toBase64() }}" />    
              @endif
                </a>
              <span>{{$tenant->firstname.' '.$tenant->lastname}}</span>
              </div>
                
            </td>
                <td>
                    {{$tenant->company}}
                </td>
                <td>
                    {{$tenant->email}}
                </td>
                <td>
                  {{$tenant->phone}}
              </td>
              <td>
                {{$tenant->address}}
              </td>
                <td class="text-right">
                <div class="btn-group mr-1 mb-1">
                    <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>
                    <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="#" onclick="OpenAcceptPopup('Verify','{{ $tenant->tenantid }}');">Verify</a>
                        <a class="dropdown-item" href="#"  onclick="OpenDeclinePopup('Decline','{{ $tenant->tenantid }}');">Decline</a>
                    </div>
                </div>
               </td>                             
              </tr>  
              @endforeach
             
            </tbody>
          </table>
        </div>
      </div>




