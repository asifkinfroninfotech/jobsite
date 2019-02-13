@php
 $CompanyLogoImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
@endphp
<div class="element-wrapper">
           <h6 class="element-header">
              Deal Owner
          </h6>
          <div class="element-box-tp">
              <div class="profile-tile">
                  <a class="profile-tile-box" href="/company/profile/view?{{'company='.$data['deal_info']->companyid .'&companytype='.$data['deal_info']->companytype}}">
                      <div class="pt-avatar-w">
                            @if( (isset($data['deal_info']->c_profileimage) && !empty($data['deal_info']->c_profileimage) ) && File::exists(public_path('storage/user/profileimage/'.$data['deal_info']->c_profileimage)))
                          <img alt="" src="{{$CompanyLogoImagePath . $data['deal_info']->c_profileimage}}">
                          
                          @else
                           
                            <img alt="" src="{{ Avatar::create(strtoupper($data['deal_info']->company))->toBase64() }}" >
                          @endif
                          
                      </div>
                      {{-- <div class="pt-user-name">
                          {{ $frequest->user_firstname .' ' . $frequest->user_lastname }}
                      </div> --}}
                  </a>
                  <div class="profile-tile-meta">
                      <ul>
                          <li>
                              <span>Company:</span>
                              <strong>{{ $data['deal_info']->company }}</strong>
                          </li>
                          <li>
                                <span>Status Message:</span>
                                <strong>{{ $data['deal_info']->statusmessage }}</strong>
                         </li>
                          <li>
                              <span>Type:</span>
                              <strong>{{ $data['deal_info']->companytype }}</strong>
                          </li>
                      </ul>
                      <div class="pt-btn">
                          <a class="btn btn-success btn-sm" href="/company/profile/view?{{'company='.$data['deal_info']->companyid .'&companytype='.$data['deal_info']->companytype}}">View Profile</a>
                          {{-- <button type="button" class="btn btn-success btn-sm" onclick="acceptfriend('{{ $frequest->friendid }}');">View Profile</button> --}}
                      </div>
                  </div>
              </div>

          </div>
      </div>