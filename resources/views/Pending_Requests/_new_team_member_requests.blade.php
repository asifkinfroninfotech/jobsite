


@php
$helper=\App\Helpers\AppHelper::instance();
$loggedinuserid=Session('userid');
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
@endphp

<div class="element-box-tp">
    <div class="table-responsive">
      <table class="table table-padded" id="myTable">
        <thead>
          <tr>
            <th>
               Name
            </th>
            <th>
              Company
            </th> 
            <th>
              Position
            </th>
            <th>
                Email (UserName)
            </th>
                       
            <th class="text-right">
              Action
            </th>                            
          </tr>
        </thead>
        <tbody>
            
           
@foreach($team_member_requests as $f)

<tr>
    <td>
               
               <div class="user-with-avatar">
                     @if(isset($f->profileimage) && !empty($f->profileimage) && File::exists($UserProfileImagePath.$f->profileimage))
                     <img alt="" src="{{$UserProfileImagePath.$f->profileimage}}">
                     @else
                    
                    <img alt="" src="{{Avatar::create(strtoupper($f->firstname)." ".strtoupper($f->lastname))->toBase64()}}">
                     @endif
                     <span class="d-none d-xl-inline-block">{{$f->firstname." ".$f->lastname}}</span>
                </div>
               </td>


               <td>
                <div class="user-with-avatar">
                    <a href="/company/profile/view?{{'company='.$f->companyid .'&companytype='.$f->companytype}}">
                      @if(isset($f->company_profileimage) && !empty($f->company_profileimage) && File::exists($CompanyProfileImagePath.$f->company_profileimage))
                      <img alt="" src="{{$CompanyProfileImagePath.$f->company_profileimage}}">
                      @else
                      <img alt="" src="{{Avatar::create(strtoupper($f->company))->toBase64()}}">
                     
                      @endif
                    <span class="d-none d-xl-inline-block">{{$f->company}}</span>
                     </a>
                 </div>
               </td>
               <td>
                 {{$f->userposition}}
               </td>
               <td>
                 {{$f->email}}
               </td>
             
               <td class="text-right">
                <div class="btn-group mr-1 mb-1">
                    <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>
                    <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="#" onclick="acceptasteammember('{{ $f->userid }}');">Accept</a>
                        <a class="dropdown-item" href="#"  onclick="declineteammember('{{ $f->userid }}');">Decline</a>
                    </div>
                </div>
               </td>                           
             </tr> 

@endforeach                                                                      
          
        </tbody>
        
        
      </table>

    </div>
  </div>




