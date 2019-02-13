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
                    <a href="/company/profile/view?{{'company='.$company1->companyid .'&companytype='.$company1->companytype}}"> 
                  @if($company1->profileimage==null)
                <img alt="" src="{{ Avatar::create($company1->companyname)->toBase64() }}" style="width: 50px;"/> 
                   @else
                   <img alt="" src="storage\company\profileimage\{{$company1->profileimage}}" style="width: 50px;"/>   
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
                <a class="btn btn-success btn-sm" onclick="fnInviteCompany('{{$company1->companyid}}')" href="#">Invite</a>
                </td>                           
              </tr>  
              @endforeach
             
            </tbody>
          </table>
        </div>
      </div>