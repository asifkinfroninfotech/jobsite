<div class="element-box">


  <div class="table-responsive">
    <table id="dataTable1" width="100%" class="table table-rm-style table-striped table-lightfont">
      <thead>
        <tr>
          <!-- <th style="display:none;"></th>-->
          <th class="sorting-tbl-1">Tenant</th>
          <th class="sorting-tbl-2">{{trans('adminview.user_table_name')}}</th>
          <th class="sorting-tbl-3">{{trans('adminview.user_table_company')}}</th>
          <th>{{trans('adminview.user_table_position')}}</th>
          <th>{{trans('adminview.user_table_usertype')}}</th>
          <th>Status</th>
          <th>{{trans('adminview.user_table_companytype')}}</th>
          <th>{{trans('adminview.user_table_action')}}</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <!-- <th style="display:none;"></th>-->
          <th>Tenant</th>
          <th>{{trans('adminview.user_table_name')}}</th>
          <th>{{trans('adminview.user_table_company')}}</th>
          <th>{{trans('adminview.user_table_position')}}</th>
          <th>{{trans('adminview.user_table_usertype')}}</th>
          <th>Status</th>
          <th>{{trans('adminview.user_table_companytype')}}</th>
          <th>{{trans('adminview.user_table_action')}}</th>
        </tr>
      </tfoot>
      <tbody>
        @foreach($users as $user)
        @if(!empty($user->name))
        <tr>
          <!-- <td style="display:none;">{{$user->name}}</td>-->

          <td>
            <div class="user-with-avatar">
              <a href="/tenant/profile/view?tenid={{$user->tenantid.'&calledfrom=admin'}}" target="_blank">
                @if( (isset($user->tenantminilogo) && !empty($user->tenantminilogo) ) &&
                File::exists(public_path('/storage/tenant/minilogoimage/'.$user->tenantminilogo)))
                <img alt="" src="/storage/tenant/minilogoimage/{{$user->tenantminilogo}}" />
                @else
                <img alt="" src="{{ Avatar::create(ucfirst($user->tenantcompany))->toBase64() }}" />
                @endif
              </a>
              <span>{{$user->tenantcompany}}</span>
            </div>

          </td>

          <td>
            <div class="user-with-avatar">
              <a href="/user/profile/view?user={{$user->userid}}&calledfrom=admin&companyid={{$user->companyid}}"
                target="_blank">
                @if( (isset($user->userprofileimage) && !empty($user->userprofileimage) ) &&
                File::exists(public_path('/storage/user/profileimage/'.$user->userprofileimage)))
                <img alt="" src="/storage/user/profileimage/{{$user->userprofileimage}}" />


                @else
                <img alt="" src="{{ Avatar::create(ucfirst($user->firstname).' '.ucfirst($user->lastname))->toBase64() }}" />
                @endif
              </a>
              <span>{{$user->firstname.' '.$user->lastname}}</span>
            </div>

          </td>


          <td>
            <div class="user-with-avatar">
              <a href="/company/profile/view?{{'company='.$user->companyid .'&companytype='.$user->companytype.'&calledfrom=admin'}}"
                target="_blank">
                @if( (isset($user->profileimage) && !empty($user->profileimage) ) &&
                File::exists(public_path('/storage/company/profileimage/'.$user->profileimage)))
                <img alt="" src="/storage/company/profileimage/{{$user->profileimage}}" />
                @else
                <img alt="" src="{{ Avatar::create($user->name)->toBase64() }}" />
                @endif
              </a>
              <span>{{$user->name}}</span>
            </div>

          </td>


          <td><span>{{$user->userposition}}</span></td>

          <td>
            @if($user->userrole==0)
            <span>ADMIN</span>
            @else
            <span>NORMAL</span>
            @endif
          </td>

          <td>{{$user->Status}}</td>

          <td><span>{{$user->companytype}}</span></td>



          <td>




            <div class="btn-group mr-1 mb-1 show">

              <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                id="dropdownMenuButton1" type="button">{{trans('adminview.user_action_btn_label')}}</button>
              <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a class="dropdown-item" href="/user/profile/view?user={{$user->userid}}&calledfrom=admin&companyid={{$user->companyid}}">{{trans('adminview.user_view_btn_label')}}</a>
                <a class="dropdown-item" href="/gotouser?userid={{$user->userid}}">{{trans('adminview.user_transfer_btn_label')}}</a>
                @if($user->Status=="Active")
                <a class="dropdown-item" onclick="inactive('{{$user->userid}}','{{$user->Status}}');" href="#">Make
                  Inactive</a>
                @elseif($user->Status=="Inactive")
                <a class="dropdown-item" onclick="active('{{$user->userid}}','{{$user->Status}}');" href="#">Make
                  Active</a>
                @elseif($user->Status=="Invited")
                <a class="dropdown-item" onclick="active('{{$user->userid}}','{{$user->Status}}');" href="#">Accept
                  Invitation</a>
                <a class="dropdown-item" onclick="deleteinvitedpop('{{$user->userid}}');" href="#">Delete</a>
                @endif


              </div>
            </div>



          </td>


        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{ $users->links('adminview.usertabledata.user_pagination') }}