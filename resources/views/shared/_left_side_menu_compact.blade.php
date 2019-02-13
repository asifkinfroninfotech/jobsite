

             @php
             $helper=\App\Helpers\AppHelper::instance();
       $tenant=$helper->getSessionTenantDetails();
       $TenantMiniLogoImagePath=\App\Helpers\AppGlobal::$TenantMiniLogoPath;
     
           @endphp
       <!--
        START - Menu side compact 
        -->
      <div class="desktop-menu menu-side-compact-w menu-activated-on-hover">
        <div class="logo-w">
          <a class="logo" href="/">
            {{-- <img src="{{ asset('/img/logo.png') }}"> --}}
            @if(isset($tenant)&& !empty($tenant))
            @if(isset($tenant->minilogo) && !empty($tenant->minilogo) && File::exists(public_path($TenantMiniLogoImagePath.$tenant->minilogo)))
            <img alt="" src="{{$TenantMiniLogoImagePath.$tenant->minilogo}}">
            @else
            <img alt="" src="{{Avatar::create(strtoupper($tenant->company))->toBase64()}}">
            @endif
          </a>
            @else    
            <img src="{{ asset('/img/logo.png') }}">
             @endif
          </a>
        </div>
        <div class="menu-and-user">

          <ul class="main-menu">
            <li>
              <a href="/">
                <div class="icon-w">
                  <i class="os-icon os-icon-window-content"></i>
                </div>
              </a>
            </li>
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-bar-chart-stats-up"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                  {{trans('menu.caption_Portfolio')}}
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-bar-chart-stats-up"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                        <li>
                          <a href="/my-portfolio">{{trans('menu.caption_My_Portfolio')}}</a>
                        </li>
                        <li>
                          <a href="/my-deals">{{trans('menu.caption_My_Deals')}}</a>
                        </li> 

                    {{-- <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2
                        <strong class="badge badge-danger">New</strong>
                      </a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li> --}}
                  </ul>
                  {{-- <ul class="sub-menu">
                    <li>
                      <a href="#">Link 5</a>
                    </li>
                    <li>
                      <a href="#">Link 6</a>
                    </li>
                    <li>
                      <a href="#">Link 7</a>
                    </li>
                    <li>
                      <a href="#">Link 8</a>
                    </li>
                  </ul> --}}
                </div>
              </div>
            </li>
             @if(session('usertype')!="Enterprises")
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-pie-chart-1"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                    {{trans('menu.caption_Enterprise_Pipeline')}}
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-pie-chart-1"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                      <li>
                          <a href="/dealpipeline">{{trans('menu.caption_Deals_Pipeline')}}</a>
                      </li>
                    {{-- <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2</a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li> --}}
                  </ul>
                  {{-- <ul class="sub-menu">
                    <li>
                      <a href="#">Link 5</a>
                    </li>
                    <li>
                      <a href="#">Link 6</a>
                    </li>
                    <li>
                      <a href="#">Link 7</a>
                    </li>
                    <li>
                      <a href="#">Link 8</a>
                    </li>
                  </ul> --}}
                </div>
              </div>
            </li>
            @endif
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-hierarchy-structure-2"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                    {{trans('menu.caption_Network')}}
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-hierarchy-structure-2"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                      <li>
                          <a href="/network">{{trans('menu.caption_View_Network')}}</a>
                      </li>
                    {{-- <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2</a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li> --}}
                  </ul>
                </div>
              </div>
            </li>
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-documents-07"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                    {{trans('menu.caption_Company_Profile')}}
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-documents-07"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                      <li>
                          <a href="{{ route('company.profile.view') }}">{{trans('menu.caption_View')}}</a>
                        </li>
                        <li>
                          <a href="{{ route('company.profile.edit') }}">{{trans('menu.caption_Edit')}}</a>
                        </li> 
                    {{-- <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2</a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li> --}}
                  </ul>
                  {{-- <ul class="sub-menu">
                    <li>
                      <a href="#">Link 5</a>
                    </li>
                    <li>
                      <a href="#">Link 6</a>
                    </li>
                    <li>
                      <a href="#">Link 7</a>
                    </li>
                    <li>
                      <a href="#">Link 8</a>
                    </li>
                  </ul> --}}
                </div>
              </div>
            </li>
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-user-male-circle"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                    {{trans('menu.caption_My_Profile')}}
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-user-male-circle"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                      <li>
                          <a href="{{ route('user.profile.view') }}">{{trans('menu.caption_View')}}</a>
                      </li>
                      <li>
                        <a href="{{ route('user.profile.edit') }}">{{trans('menu.caption_Edit')}}</a>
                      </li>  
                    {{-- <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2</a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li> --}}
                  </ul>
                </div>
              </div>
            </li>
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-cv-2"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                    {{trans('menu.caption_Teams')}}
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-cv-2"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                    <li>
                        <a href="/teams">{{trans('menu.caption_View_Team')}}</a>
                    </li>
                    {{-- <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2</a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li> --}}
                  </ul>
                </div>
              </div>
            </li>

            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-cv-2"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                    {{trans('menu.caption_Tender')}}
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-cv-2"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                    <li>
                         <a href="/mytender">{{trans('menu.caption_my_tender')}}</a>
                    </li>
                    <li>
                        <a href="/view-other-tenders">{{trans('menu.caption_view_tender')}}</a>
                      </li>
                  </ul>
                </div>
              </div>
            </li>



          </ul>
        </div>
      </div>

     


        
