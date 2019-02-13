<!--------------------
        START - Menu side compact 
        -------------------->
      <div class="desktop-menu menu-side-compact-w menu-activated-on-hover">
        <div class="logo-w">
          <a class="logo" href="/">
            <img src="{{ asset('/img/logo.png') }}">
          </a>
        </div>
        <div class="menu-and-user">
            <ul class="main-menu">
                {{-- <li class="">
                    <a href="/translations">
                        <div class="icon-w">
                            <div class="os-icon os-icon-pencil-12"></div>
                        </div>
                        <span>{{trans('adminview.Language_Translator_Menu_Caption')}}</span>
                    </a>
         
                </li>
                <li class="">
                    <a href="/admincompany">
                        <div class="icon-w">
                            <div class="os-icon os-icon-hierarchy-structure-2"></div>
                        </div>
                        <span>{{trans('adminview.company_menu')}}</span>
                    </a>
                   
                </li>
                <li class="">
 
                      <a href="/adminuser">
                        <div class="icon-w">
                            <div class="os-icon os-icon-user-male-circle2"></div>
                        </div>
                        <span>{{trans('adminview.users_menu')}}</span>
                    </a>
                   
                </li>
                <li class="">
                        <a href="/admindeal">
                        <div class="icon-w">
                            <div class="os-icon os-icon-newspaper"></div>
                        </div>
                        <span>{{trans('adminview.deals_menu')}}</span>
                    </a>
                    
                </li>
                <li class="">
                      <a href="/adminduediligence">
                        <div class="icon-w">
                            <div class="os-icon os-icon-pencil-12"></div>
                        </div>
                        <span>{{trans('adminview.due_deligence_menu')}}</span>
                    </a>
                  
                </li>
                
                 <li class="">
                      <a href="/admintenant">
                          <div class="icon-w">
                              <div class="os-icon os-icon-user-male-circle2"></div>
                          </div>
                          <span>{{trans('adminview.tenants_menu')}}</span>
                      </a>
                      </li>
                 --}}

<li class="{{$helper->checktenanturl('dashboard')}}">
    <a href="/tenant/dashboard">
        <div class="icon-w">
            <div class="os-icon os-icon-window-content"></div>
        </div>
        <span>{{trans('tenant_dashboard.tenant_dashboard_heading')}}</span>
    </a>
</li>
<li class="{{$helper->checktenanturl('company')}}">
    <a href="/tenant/company">
        <div class="icon-w">
            <div class="os-icon os-icon-hierarchy-structure-2"></div>
        </div>
        <span>{{trans('adminview.company_menu')}}</span>
    </a>

</li>
<li class="{{$helper->checktenanturl('user')}}">
    <a href="/tenant/user">
        <div class="icon-w">
            <div class="os-icon os-icon-user-male-circle2"></div>
        </div>
        <span>{{trans('adminview.users_menu')}}</span>
    </a>

</li>
<li class="{{$helper->checktenanturl('deals')}}">
    <a href="/tenant/deal">
        <div class="icon-w">
            <div class="os-icon os-icon-newspaper"></div>
        </div>
        <span>{{trans('adminview.deals_menu')}}</span>
    </a>

</li>
<li class="{{$helper->checktenanturl('duediligence')}}">
    <a href="/tenant/duediligence">
        <div class="icon-w">
            <div class="os-icon os-icon-pencil-12"></div>
        </div>
        <span>{{trans('adminview.due_deligence_menu')}}</span>
    </a>

</li>

<li class="{{$helper->checktenanturl('requests')}}">
    <a href="/tenant/requests">
        <div class="icon-w">
            <div class="os-icon os-icon-others-43"></div>
        </div>
        <span>{{trans('adminview.new_company_request_menu')}}</span>
    </a>

</li>

<li class="{{$helper->checktenanturl('subscription')}}">
    <a href="/tenant/account/subscription">
        <div class="icon-w">
            <div class="os-icon os-icon-ui-55"></div>
        </div>
        <span>{{trans('adminview.account_menu')}}</span>
    </a>

</li>

<li class="{{$helper->checktenanturl('emails')}}">
    <a href="/tenant/emails">
        <div class="icon-w">
            <div class="os-icon os-icon-email-2-at2"></div>
        </div>
        <span>{{trans('adminview.email_menu')}}</span>
    </a>
</li>
                
              
            </ul>

        </div>
      </div>
      <!--------------------
        END - Menu side compact 
