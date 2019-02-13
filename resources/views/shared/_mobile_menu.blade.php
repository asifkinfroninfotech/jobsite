        <!--------------------
        START - Mobile Menu
        -------------------->
        <div class="menu-mobile menu-activated-on-click color-scheme-dark">
          <div class="mm-logo-buttons-w">
            <a class="mm-logo" href="/"><img src="/img/logo.png"></a>
            <div class="mm-buttons">
              <div class="content-panel-open">
                <div class="os-icon os-icon-grid-circles"></div>
              </div>
              <div class="mobile-menu-trigger">
                <div class="os-icon os-icon-hamburger-menu-1"></div>
              </div>
            </div>
          </div>
          <div class="menu-and-user">            
            <!--------------------
            START - Mobile Menu List
            -------------------->
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
                    <a href="#">{{trans('menu.caption_My_Deals')}}</a>
                  </li>                  
                </ul>
              </li>
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
                    <a href="#">link 3</a>
                  </li> --}}
                </ul>
              </li>
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
                      <a href="#">link 3</a>
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
                    <a href="#">link 2<strong class="badge badge-danger">1</strong></a>
                  </li>
                  <li>
                    <a href="#">link 3</a>
                  </li>  --}}
                </ul>
              </li> 
               
            </ul>   
            <!--------------------
            END - Mobile Menu List
            -------------------->
          </div>
        </div>
        <!--------------------
        END - Mobile Menu
        -------------------->