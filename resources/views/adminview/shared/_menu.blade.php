@php
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$helper=\App\Helpers\AppHelper::instance();
$helper->headerlogics();
$url=$helper->url;
if($url=="login")
{
$profileimage=$helper->profileimage;
$firstname=$helper->firstname;
$lastname=$helper->lastname;
if(isset($helper->messagescount) && !empty($helper->messagescount))
{
   $messagecount=$helper->messagescount;
}
else 
  {
    $messagecount=0;
  }

$getmessagesusers=$helper->getmessagesusers;
}
if($url=="logout")
{
$profileimage=$helper->profileimage;
$firstname=$helper->firstname;
$lastname=$helper->lastname;
echo "<script>window.location.href='/login';</script>";      
}
@endphp








<!--------------------
        START - Mobile Menu
        -------------------->
        <div class="menu-mobile menu-activated-on-click color-scheme-dark">
          <div class="mm-logo-buttons-w">
            <a class="mm-logo" href="index.html"><img src="img/logo.png"><span>Clean Admin</span></a>
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
            <div class="logged-user-w">
              <div class="avatar-w">
                 @if( (isset($profileimage) && !empty($profileimage) ) && File::exists(public_path($UserProfileImagePath.$profileimage)))     

                                                              {{-- <img alt="" src="img/avatar1.jpg"> --}}
                                                              <img alt="" src="{{$UserProfileImagePath . $profileimage}}">
                                                              
                                                       @else
                                                              <img alt="" src="{{ Avatar::create(ucfirst($firstname) .' ' . ucfirst($lastname))->toBase64() }}">  
                                                        @endif
              </div>
              <div class="logged-user-info-w">
                <div class="logged-user-name">
                  {{$firstname.' '.$lastname}}
                </div>
                <div class="logged-user-role">
                  Administrator
                </div>
              </div>
            </div>
            <!--------------------
            START - Mobile Menu List
            -------------------->
            <ul class="main-menu">
<!--              <li class="">
                <a href="/admindashboard">
                  <div class="icon-w">
                    <div class="os-icon os-icon-window-content"></div>
                  </div>
                  <span>Dashboard</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="index.html">Dashboard 1</a>
                  </li>
                  <li>
                    <a href="apps_support_dashboard.html">Dashboard 2 <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="apps_projects.html">Dashboard 3</a>
                  </li>
                  <li>
                    <a href="apps_bank.html">Dashboard 4 <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="layouts_menu_top_image.html">Dashboard 5</a>
                  </li>
                </ul>
              </li>-->
<li class="">
  <a href="/translations">
    <div class="icon-w">
        <div class="os-icon os-icon-pencil-12"></div>
      </div>
      <span>{{trans('adminview.Language_Translator_Menu_Caption')}}</span></a>
  </a>
</li>

              <li class="">
                <a href="/admincompany">
                  <div class="icon-w">
                    <div class="os-icon os-icon-hierarchy-structure-2"></div>
                  </div>
                  <span>{{trans('adminview.company_menu')}}</span></a>
<!--                <ul class="sub-menu">
                  <li>
                    <a href="layouts_menu_side.html">Side Menu Light</a>
                  </li>
                  <li>
                    <a href="layouts_menu_side_dark.html">Side Menu Dark</a>
                  </li>
                  <li>
                    <a href="apps_bank.html">Side Menu V2 <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="apps_pipeline.html">Side &amp; Top Dark</a>
                  </li>
                  <li>
                    <a href="apps_projects.html">Side &amp; Top <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="layouts_menu_side_compact.html">Compact Side Menu</a>
                  </li>
                  <li>
                    <a href="layouts_menu_side_compact_dark.html">Compact Menu Dark</a>
                  </li>
                  <li>
                    <a href="layouts_menu_top.html">Top Menu Light</a>
                  </li>
                  <li>
                    <a href="layouts_menu_top_dark.html">Top Menu Dark</a>
                  </li>
                  <li>
                    <a href="layouts_menu_top_image.html">Top Menu Image</a>
                  </li>
                </ul>-->
              </li>
              <li class="">
                <a href="/adminuser">
                  <div class="icon-w">
                    <div class="os-icon os-icon-user-male-circle2"></div>
                  </div>
                  <span>{{trans('adminview.users_menu')}}</span></a>
<!--                <ul class="sub-menu">
                  <li>
                    <a href="apps_email.html">Email Application</a>
                  </li>
                  <li>
                    <a href="apps_support_dashboard.html">Support Dashboard <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="apps_support_index.html">Tickets Index <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="apps_projects.html">Projects List</a>
                  </li>
                  <li>
                    <a href="apps_bank.html">Banking <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="apps_full_chat.html">Chat Application</a>
                  </li>
                  <li>
                    <a href="apps_todo.html">To Do Application <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="misc_chat.html">Popup Chat</a>
                  </li>
                  <li>
                    <a href="apps_pipeline.html">CRM Pipeline</a>
                  </li>
                  <li>
                    <a href="rentals_index_grid.html">Property Listing <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="misc_calendar.html">Calendar</a>
                  </li>
                </ul>-->
              </li>
              <li class="">
                <a href="/admindeal">
                  <div class="icon-w">
                    <div class="os-icon os-icon-newspaper"></div>
                  </div>
                  <span>{{trans('adminview.deals_menu')}}</span></a>
<!--                <ul class="sub-menu">
                  <li>
                    <a href="misc_invoice.html">Invoice</a>
                  </li>
                  <li>
                    <a href="rentals_index_grid.html">Property Listing <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="misc_charts.html">Charts</a>
                  </li>
                  <li>
                    <a href="auth_login.html">Login</a>
                  </li>
                  <li>
                    <a href="auth_register.html">Register</a>
                  </li>
                  <li>
                    <a href="auth_lock.html">Lock Screen</a>
                  </li>
                  <li>
                    <a href="misc_pricing_plans.html">Pricing Plans</a>
                  </li>
                  <li>
                    <a href="misc_error_404.html">Error 404</a>
                  </li>
                  <li>
                    <a href="misc_error_500.html">Error 500</a>
                  </li>
                </ul>-->
              </li>
              <li class="">
                <a href="/adminduediligence">
                  <div class="icon-w">
                    <div class="os-icon os-icon-pencil-12"></div>
                  </div>
                  <span>{{trans('adminview.due_deligence_menu')}}</span></a>
<!--                <ul class="sub-menu">
                  <li>
                    <a href="uikit_modals.html">Modals <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="uikit_alerts.html">Alerts</a>
                  </li>
                  <li>
                    <a href="uikit_grid.html">Grid</a>
                  </li>
                  <li>
                    <a href="uikit_progress.html">Progress</a>
                  </li>
                  <li>
                    <a href="uikit_popovers.html">Popover</a>
                  </li>
                  <li>
                    <a href="uikit_tooltips.html">Tooltips</a>
                  </li>
                  <li>
                    <a href="uikit_buttons.html">Buttons</a>
                  </li>
                  <li>
                    <a href="uikit_dropdowns.html">Dropdowns</a>
                  </li>
                  <li>
                    <a href="uikit_typography.html">Typography</a>
                  </li>
                </ul>-->
              </li>
<!--              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-email-2-at2"></div>
                  </div>
                  <span>Emails</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="emails_welcome.html">Welcome Email</a>
                  </li>
                  <li>
                    <a href="emails_order.html">Order Confirmation</a>
                  </li>
                  <li>
                    <a href="emails_payment_due.html">Payment Due</a>
                  </li>
                  <li>
                    <a href="emails_forgot.html">Forgot Password</a>
                  </li>
                  <li>
                    <a href="emails_activate.html">Activate Account</a>
                  </li>
                </ul>
              </li>
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-user-male-circle"></div>
                  </div>
                  <span>Users</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="users_profile_big.html">Big Profile</a>
                  </li>
                  <li>
                    <a href="users_profile_small.html">Compact Profile</a>
                  </li>
                </ul>
              </li>
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-tasks-checked"></div>
                  </div>
                  <span>Forms</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="forms_regular.html">Regular Forms</a>
                  </li>
                  <li>
                    <a href="forms_validation.html">Form Validation</a>
                  </li>
                  <li>
                    <a href="forms_wizard.html">Form Wizard</a>
                  </li>
                  <li>
                    <a href="forms_uploads.html">File Uploads</a>
                  </li>
                  <li>
                    <a href="forms_wisiwig.html">Wisiwig Editor</a>
                  </li>
                </ul>
              </li>
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-grid-squares"></div>
                  </div>
                  <span>Tables</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="tables_regular.html">Regular Tables</a>
                  </li>
                  <li>
                    <a href="tables_datatables.html">Data Tables</a>
                  </li>
                  <li>
                    <a href="tables_editable.html">Editable Tables</a>
                  </li>
                </ul>
              </li>
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-robot-1"></div>
                  </div>
                  <span>Icons</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="icon_fonts_simple_line_icons.html">Simple Line Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_feather.html">Feather Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_themefy.html">Themefy Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_picons_thin.html">Picons Thin</a>
                  </li>
                  <li>
                    <a href="icon_fonts_dripicons.html">Dripicons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_eightyshades.html">Eightyshades</a>
                  </li>
                  <li>
                    <a href="icon_fonts_entypo.html">Entypo</a>
                  </li>
                  <li>
                    <a href="icon_fonts_font_awesome.html">Font Awesome</a>
                  </li>
                  <li>
                    <a href="icon_fonts_foundation_icon_font.html">Foundation Icon Font</a>
                  </li>
                  <li>
                    <a href="icon_fonts_metrize_icons.html">Metrize Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_picons_social.html">Picons Social</a>
                  </li>
                  <li>
                    <a href="icon_fonts_batch_icons.html">Batch Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_dashicons.html">Dashicons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_typicons.html">Typicons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_weather_icons.html">Weather Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_light_admin.html">Light Admin</a>
                  </li>
                </ul>
              </li>-->
            </ul>
            <!--------------------
            END - Mobile Menu List
            -------------------->
<!--            <div class="mobile-menu-magic">
              <h4>
                Light Admin
              </h4>
              <p>
                Clean Bootstrap 4 Template
              </p>
              <div class="btn-w">
                <a class="btn btn-white btn-rounded" href="https://themeforest.net/item/light-admin-clean-bootstrap-dashboard-html-template/19760124?ref=Osetin" target="_blank">Purchase Now</a>
              </div>
            </div>-->
          </div>
        </div>
        <!--------------------
        END - Mobile Menu
        -------------------->
        <div class="desktop-menu menu-side-w menu-activated-on-click">
          <div class="logo-w">
            <a class="logo" href="index.html">
              <div class="logo-element"></div>
              <div class="logo-label">
                Clean Admin
              </div>
            </a>
          </div>
          <div class="menu-and-user">
            <div class="logged-user-w">
              <div class="logged-user-i">
                <div class="avatar-w">
                     @if( (isset($profileimage) && !empty($profileimage) ) && File::exists(public_path($UserProfileImagePath.$profileimage)))     

                                                              {{-- <img alt="" src="img/avatar1.jpg"> --}}
                                                              <img alt="" src="{{$UserProfileImagePath . $profileimage}}">
                                                              
                                                       @else
                                                              <img alt="" src="{{ Avatar::create(ucfirst($firstname) .' ' . ucfirst($lastname))->toBase64() }}">  
                                                        @endif
                </div>
                <div class="logged-user-info-w">
                  <div class="logged-user-name">
                    {{$firstname.' '.$lastname}}
                  </div>
                  <div class="logged-user-role">
                    Administrator
                  </div>
                </div>
                <div class="logged-user-menu">
                  <div class="logged-user-avatar-info">
                    <div class="avatar-w">
                     @if( (isset($profileimage) && !empty($profileimage) ) && File::exists(public_path($UserProfileImagePath.$profileimage)))     

                                                              {{-- <img alt="" src="img/avatar1.jpg"> --}}
                                                              <img alt="" src="{{$UserProfileImagePath . $profileimage}}">
                                                              
                                                       @else
                                                              <img alt="" src="{{ Avatar::create(ucfirst($firstname) .' ' . ucfirst($lastname))->toBase64() }}">  
                                                        @endif
                    </div>
                    <div class="logged-user-info-w">
                      <div class="logged-user-name">
                        {{$firstname.' '.$lastname}}
                      </div>
                      <div class="logged-user-role">
                        Administrator
                      </div>
                    </div>
                  </div>
                  <div class="bg-icon">
                    <i class="os-icon os-icon-wallet-loaded"></i>
                  </div>
                  <ul>
<!--                    <li>
                      <a href="apps_email.html"><i class="os-icon os-icon-mail-01"></i><span>Incoming Mail</span></a>
                    </li>-->
                    <li>
                      <a href="users_profile_big.html"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a>
                    </li>
<!--                    <li>
                      <a href="users_profile_small.html"><i class="os-icon os-icon-coins-4"></i><span>Billing Details</span></a>
                    </li>
                    <li>
                      <a href="#"><i class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
                    </li>-->
                    <li>
                      <a href="/logout"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <ul class="main-menu">
<!--              <li class="">
                <a href="/admindashboard">
                  <div class="icon-w">
                    <div class="os-icon os-icon-window-content"></div>
                  </div>
                  <span>Dashboard</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="index.html">Dashboard 1</a>
                  </li>
                  <li>
                    <a href="apps_support_dashboard.html">Dashboard 2 <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="apps_projects.html">Dashboard 3</a>
                  </li>
                  <li>
                    <a href="apps_bank.html">Dashboard 4 <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="layouts_menu_top_image.html">Dashboard 5</a>
                  </li>
                </ul>
              </li>-->
              <li class="">
                  <a href="/translations">
                    <div class="icon-w">
                        <div class="os-icon os-icon-pencil-12"></div>
                      </div>
                      <span>{{trans('adminview.Language_Translator_Menu_Caption')}}</span></a>
                  </a>
                </li>
              <li class="">
                <a href="/admincompany">
                  <div class="icon-w">
                    <div class="os-icon os-icon-hierarchy-structure-2"></div>
                  </div>
                  <span>{{trans('adminview.company_menu')}}</span></a>
<!--                <ul class="sub-menu">
                  <li>
                    <a href="layouts_menu_side.html">Side Menu Light</a>
                  </li>
                  <li>
                    <a href="layouts_menu_side_dark.html">Side Menu Dark</a>
                  </li>
                  <li>
                    <a href="apps_bank.html">Side Menu V2 <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="apps_pipeline.html">Side &amp; Top Dark</a>
                  </li>
                  <li>
                    <a href="apps_projects.html">Side &amp; Top <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="layouts_menu_side_compact.html">Compact Side Menu</a>
                  </li>
                  <li>
                    <a href="layouts_menu_side_compact_dark.html">Compact Menu Dark</a>
                  </li>
                  <li>
                    <a href="layouts_menu_top.html">Top Menu Light</a>
                  </li>
                  <li>
                    <a href="layouts_menu_top_dark.html">Top Menu Dark</a>
                  </li>
                  <li>
                    <a href="layouts_menu_top_image.html">Top Menu Image</a>
                  </li>
                </ul>-->
              </li>
              <li class="">
                <a href="/adminuser">
                  <div class="icon-w">
                    <div class="os-icon os-icon-user-male-circle2"></div>
                  </div>
                  <span>{{trans('adminview.users_menu')}}</span></a>
<!--                <ul class="sub-menu">
                  <li>
                    <a href="apps_email.html">Email Application</a>
                  </li>
                  <li>
                    <a href="apps_support_dashboard.html">Support Dashboard <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="apps_support_index.html">Tickets Index <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="apps_projects.html">Projects List</a>
                  </li>
                  <li>
                    <a href="apps_bank.html">Banking <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="apps_full_chat.html">Chat Application</a>
                  </li>
                  <li>
                    <a href="apps_todo.html">To Do Application <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="misc_chat.html">Popup Chat</a>
                  </li>
                  <li>
                    <a href="apps_pipeline.html">CRM Pipeline</a>
                  </li>
                  <li>
                    <a href="rentals_index_grid.html">Property Listing <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="misc_calendar.html">Calendar</a>
                  </li>
                </ul>-->
              </li>
              <li class="">
                <a href="/admindeal">
                  <div class="icon-w">
                    <div class="os-icon os-icon-newspaper"></div>
                  </div>
                  <span>{{trans('adminview.deals_menu')}}</span></a>
<!--                <ul class="sub-menu">
                  <li>
                    <a href="misc_invoice.html">Invoice</a>
                  </li>
                  <li>
                    <a href="rentals_index_grid.html">Property Listing <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="misc_charts.html">Charts</a>
                  </li>
                  <li>
                    <a href="auth_login.html">Login</a>
                  </li>
                  <li>
                    <a href="auth_register.html">Register</a>
                  </li>
                  <li>
                    <a href="auth_lock.html">Lock Screen</a>
                  </li>
                  <li>
                    <a href="misc_pricing_plans.html">Pricing Plans</a>
                  </li>
                  <li>
                    <a href="misc_error_404.html">Error 404</a>
                  </li>
                  <li>
                    <a href="misc_error_500.html">Error 500</a>
                  </li>
                </ul>-->
              </li>
              <li class="">
                <a href="/adminduediligence">
                  <div class="icon-w">
                    <div class="os-icon os-icon-pencil-12"></div>
                  </div>
                  <span>{{trans('adminview.due_deligence_menu')}}</span></a>
<!--                <ul class="sub-menu">
                  <li>
                    <a href="uikit_modals.html">Modals <strong class="badge badge-danger">New</strong></a>
                  </li>
                  <li>
                    <a href="uikit_alerts.html">Alerts</a>
                  </li>
                  <li>
                    <a href="uikit_grid.html">Grid</a>
                  </li>
                  <li>
                    <a href="uikit_progress.html">Progress</a>
                  </li>
                  <li>
                    <a href="uikit_popovers.html">Popover</a>
                  </li>
                  <li>
                    <a href="uikit_tooltips.html">Tooltips</a>
                  </li>
                  <li>
                    <a href="uikit_buttons.html">Buttons</a>
                  </li>
                  <li>
                    <a href="uikit_dropdowns.html">Dropdowns</a>
                  </li>
                  <li>
                    <a href="uikit_typography.html">Typography</a>
                  </li>
                </ul>-->
              </li>
<!--              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-email-2-at2"></div>
                  </div>
                  <span>Emails</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="emails_welcome.html">Welcome Email</a>
                  </li>
                  <li>
                    <a href="emails_order.html">Order Confirmation</a>
                  </li>
                  <li>
                    <a href="emails_payment_due.html">Payment Due</a>
                  </li>
                  <li>
                    <a href="emails_forgot.html">Forgot Password</a>
                  </li>
                  <li>
                    <a href="emails_activate.html">Activate Account</a>
                  </li>
                </ul>
              </li>
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-user-male-circle"></div>
                  </div>
                  <span>Users</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="users_profile_big.html">Big Profile</a>
                  </li>
                  <li>
                    <a href="users_profile_small.html">Compact Profile</a>
                  </li>
                </ul>
              </li>
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-tasks-checked"></div>
                  </div>
                  <span>Forms</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="forms_regular.html">Regular Forms</a>
                  </li>
                  <li>
                    <a href="forms_validation.html">Form Validation</a>
                  </li>
                  <li>
                    <a href="forms_wizard.html">Form Wizard</a>
                  </li>
                  <li>
                    <a href="forms_uploads.html">File Uploads</a>
                  </li>
                  <li>
                    <a href="forms_wisiwig.html">Wisiwig Editor</a>
                  </li>
                </ul>
              </li>
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-grid-squares"></div>
                  </div>
                  <span>Tables</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="tables_regular.html">Regular Tables</a>
                  </li>
                  <li>
                    <a href="tables_datatables.html">Data Tables</a>
                  </li>
                  <li>
                    <a href="tables_editable.html">Editable Tables</a>
                  </li>
                </ul>
              </li>
              <li class="has-sub-menu">
                <a href="#">
                  <div class="icon-w">
                    <div class="os-icon os-icon-robot-1"></div>
                  </div>
                  <span>Icons</span></a>
                <ul class="sub-menu">
                  <li>
                    <a href="icon_fonts_simple_line_icons.html">Simple Line Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_feather.html">Feather Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_themefy.html">Themefy Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_picons_thin.html">Picons Thin</a>
                  </li>
                  <li>
                    <a href="icon_fonts_dripicons.html">Dripicons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_eightyshades.html">Eightyshades</a>
                  </li>
                  <li>
                    <a href="icon_fonts_entypo.html">Entypo</a>
                  </li>
                  <li>
                    <a href="icon_fonts_font_awesome.html">Font Awesome</a>
                  </li>
                  <li>
                    <a href="icon_fonts_foundation_icon_font.html">Foundation Icon Font</a>
                  </li>
                  <li>
                    <a href="icon_fonts_metrize_icons.html">Metrize Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_picons_social.html">Picons Social</a>
                  </li>
                  <li>
                    <a href="icon_fonts_batch_icons.html">Batch Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_dashicons.html">Dashicons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_typicons.html">Typicons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_weather_icons.html">Weather Icons</a>
                  </li>
                  <li>
                    <a href="icon_fonts_light_admin.html">Light Admin</a>
                  </li>
                </ul>
              </li>-->
            </ul>
<!--            <div class="side-menu-magic">
              <h4>
                Light Admin
              </h4>
              <p>
                Clean Bootstrap 4 Template
              </p>
              <div class="btn-w">
                <a class="btn btn-white btn-rounded" href="https://themeforest.net/item/light-admin-clean-bootstrap-dashboard-html-template/19760124?ref=Osetin" target="_blank">Purchase Now</a>
              </div>
            </div>-->
          </div>
        </div>