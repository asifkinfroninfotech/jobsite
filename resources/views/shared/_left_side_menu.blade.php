      @php
        $helper=\App\Helpers\AppHelper::instance();
  $tenant=$helper->getSessionTenantDetails();
  $TenantLogoImagePath=\App\Helpers\AppGlobal::$TenantLogoPath;

      @endphp
      <!--
        START - Menu side 
        -->
        <div class="desktop-menu menu-side-w menu-activated-on-click">
          <div class="logo-w">
            <a class="logo" href="/">
              @if(isset($tenant)&& !empty($tenant))
              @if(isset($tenant->logo) && !empty($tenant->logo) && File::exists(public_path($TenantLogoImagePath.$tenant->logo)))
              <img alt="" src="{{$TenantLogoImagePath.$tenant->logo}}">
              @else
              <img alt="" src="{{Avatar::create(strtoupper($tenant->company))->toBase64()}}">
              @endif
            </a>
              @else    
               <a class="logo" href="/"><img alt="" src="img/logo_desktop.png"></a>
               @endif
            {{-- <a class="logo" href="/"><img src="/img/logo_desktop.png"></a> --}}
          </div>
          <div class="menu-and-user">            
              <ul class="main-menu">
                  <li>
                    <a href="/">
                      <div class="icon-w">
                        <div class="os-icon os-icon-window-content"></div>
                      </div>
                      <span>{{trans('menu.caption_Dashboard')}}</span></a>
                  </li>
                  <li class="has-sub-menu">
                    <a href="#">
                      <div class="icon-w">
                          <div class="os-icon os-icon-bar-chart-stats-up"></div>
                      </div>
                      <span>{{trans('menu.caption_Portfolio')}}</span></a>
                    <ul class="sub-menu">
                      <li>
                        <a href="/my-portfolio">{{trans('menu.caption_My_Portfolio')}}</a>
                      </li>
                      <li>
                        <a href="/my-deals">{{trans('menu.caption_My_Deals')}}</a>
                      </li>                  
                    </ul>
                  </li>
                
                  @if(session('usertype')!="Enterprises")
                  <li class="has-sub-menu">
                      <a href="#">
                          <div class="icon-w">
                            <div class="os-icon os-icon-pie-chart-1"></div>
                          </div>
                          <span>{{trans('menu.caption_Enterprise_Pipeline')}}</span></a>
                    <ul class="sub-menu">
                      <li>
                        <a href="/dealpipeline">{{trans('menu.caption_Deals_Pipeline')}}</a>
                      </li>
                      {{-- <li>
                        <a href="#">link 2</a>
                      </li> --}}
                    </ul>
                  </li>
                  @endif
                  
                  <li class="has-sub-menu">
                      <a href="#">
                        <div class="icon-w">
                          <div class="os-icon os-icon-hierarchy-structure-2"></div>
                        </div>
                        <span>{{trans('menu.caption_Network')}}</span></a>
                      <ul class="sub-menu">
                        <li>
                          <a href="/network">{{trans('menu.caption_View_Network')}}</a>
                        </li>
                        {{-- <li>
                          <a href="#">link 2</a>
                        </li>  --}}
                      </ul>
                    </li>
                    <li class="has-sub-menu">
                        <a href="#">
                          <div class="icon-w">
                            <div class="os-icon os-icon-documents-07"></div>
                          </div>
                          <span>{{trans('menu.caption_Company_Profile')}}</span></a>
                        <ul class="sub-menu">
                          <li>
                            <a href="{{ route('company.profile.view') }}">{{trans('menu.caption_View')}}</a>
                          </li>
                          <li>
                            <a href="{{ route('company.profile.edit') }}">{{trans('menu.caption_Edit')}}</a>
                          </li> 
                        </ul>
                      </li>        
                  <li class="has-sub-menu">
                    <a href="#">
                      <div class="icon-w">
                        <div class="os-icon os-icon-user-male-circle"></div>
                      </div>
                      <span>{{trans('menu.caption_My_Profile')}}</span></a>
                    <ul class="sub-menu">
                      <li>
                        <a href="{{ route('user.profile.view') }}">{{trans('menu.caption_View')}}</a>
                      </li>
                      <li>
                        <a href="{{ route('user.profile.edit') }}">{{trans('menu.caption_Edit')}}</a>
                      </li>                 
                    </ul>
                  </li>
                  <li class="has-sub-menu">
                    <a href="#">
                      <div class="icon-w">
                        <div class="os-icon os-icon-cv-2"></div>
                      </div>
                      <span>{{trans('menu.caption_Teams')}}</span></a>
                    <ul class="sub-menu">
                      <li>
                        <a href="/teams">{{trans('menu.caption_View_Team')}}</a>
                      </li>
                      {{-- <li>
                        <a href="#">link 2 <strong class="badge badge-danger">1</strong></a>
                      </li>
                      <li>
                        <a href="#">link 3</a>
                      </li>  --}}
                    </ul>
                  </li> 

                  <li class="has-sub-menu">
                    <a href="#">
                      <div class="icon-w">
                        <div class="os-icon os-icon-cv-2"></div>
                      </div>
                      <span>{{trans('menu.caption_Tender')}}</span></a>
                    <ul class="sub-menu">
                      <li>
                        <a href="/mytender">{{trans('menu.caption_my_tender')}}</a>
                      </li>
                      <li>
                        <a href="/view-other-tenders">{{trans('menu.caption_view_tender')}}</a>
                      </li>

                    </ul>
                  </li> 
                   
                </ul>         
          </div>
        </div><!--------------------
        END - Menu side 
        -------------------->
