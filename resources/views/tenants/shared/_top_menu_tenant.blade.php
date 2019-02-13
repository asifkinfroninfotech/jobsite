@php
$helper=\App\Helpers\AppHelper::instance();
$tenant= $helper->gettenant_header();
@endphp

<!--
          START - Secondary Top Menu
          -->
<div class="top-menu-secondary">
  <!--
            START - Top Menu Controls
            -->
  <div class="top-menu-controls">
    {{-- <div class="messages-notifications os-dropdown-trigger os-dropdown-center">
      <a href='#' onclick='showhelp();'><i class="os-icon os-icon-grid-circles"></i></a>
    </div> --}}
    <!--
              END - Settings Link in secondary top menu
             -->
    <!--
              START - User avatar and menu in secondary top menu
              -->
    <div class="logged-user-w">
      <div class="logged-user-i">
        <div class="avatar-w avatar-circle">
          {{-- <img alt="" src="img/avatar1.jpg"> --}}
          @if(isset($tenant))
          @if( (isset($tenant->profileimage) && !empty($tenant->profileimage) ) &&
          File::exists(public_path('storage/tenant/profileimage/'.$tenant->profileimage)))
          <img alt="" src="/storage/tenant/profileimage/{{$tenant->profileimage}}" />
          @else
          <img alt="" src="{{ Avatar::create(strtoupper($tenant->company))->toBase64() }}" />
          @endif
          @endif

        </div>
        <div class="logged-user-menu">
          <div class="logged-user-avatar-info">
            <div class="avatar-w avatar-circle">
              {{-- <img alt="" src="img/avatar1.jpg"> --}}
              @if(isset($tenant))
              @if( (isset($tenant->profileimage) && !empty($tenant->profileimage) ) &&
              File::exists(public_path('storage/tenant/profileimage/'.$tenant->profileimage)))
              <img alt="" src="/storage/tenant/profileimage/{{$tenant->profileimage}}" />
              @else
              <img alt="" src="{{ Avatar::create(strtoupper($tenant->company))->toBase64() }}" />
              @endif
              @endif
            </div>
            <div class="logged-user-info-w">
              <div class="logged-user-name">
                @if(isset($tenant))
                {{$tenant->company}}
                @endif
              </div>
              <div class="logged-user-role">
                Tenant
              </div>
            </div>
          </div>
          <div class="bg-icon">
            <i class="os-icon os-icon-wallet-loaded"></i>
          </div>
          <ul>
            <li>
              <a href="/tenant/profile/view"><i class="os-icon os-icon-user-male-circle2"></i><span>My Profile</span></a>
            </li>
            <li>
              <a href="/tenant/profile/edit"><i class="os-icon os-icon-coins-4"></i><span>Edit</span></a>
            </li>

            <li>
              <a href='#' onclick='showhelp();'><i class="icon-support"></i><span>Show Help</span></a>
            </li>
            <!--                        <li>
                        <a href="#"><i class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
                      </li>-->
            <li>
              <!--       <a href="#"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a> -->
              <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                <i class="os-icon os-icon-signs-11"></i>
                Logout
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>

            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--------------------
              END - User avatar and menu in secondary top menu
              -------------------->
  </div>
  <!--------------------
            END - Top Menu Controls
            -------------------->
</div>
<!--------------------
          END - Secondary Top Menu
          -------------------->