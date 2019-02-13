@php
$helper=\App\Helpers\AppHelper::instance();
$tenant= $helper->gettenant_header();
@endphp

<!--------------------
  START - Menu side
  -------------------->
<div class="desktop-menu menu-side-w menu-activated-on-click">
    <div class="logo-w">
        <a class="logo" href="/tenant/dashboard">
            @if(isset($tenant))
            @if( (isset($tenant->logo) && !empty($tenant->logo) ) &&
            File::exists(public_path('storage/tenant/logoimage/'.$tenant->logo)))
            <img alt="" src="/storage/tenant/logoimage/{{$tenant->logo}}" />
            @else
            <img alt="" src="{{ Avatar::create(strtoupper($tenant->company))->toBase64() }}" />
            @endif
            @endif
        </a>
    </div>
    <div class="menu-and-user">
        <ul class="main-menu">
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



            <!-- <li class="{{$helper->checktenanturl('cms')}}">
                <a href="/tenant/cms">
                    <div class="icon-w">
                        <div class="os-icon os-icon-newspaper"></div>
                    </div>
                    <span>{{trans('adminview.cms')}}</span>
                </a>
            </li> -->


            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-newspaper"></div>
                    </div>
                    <span>{{trans('adminview.cms')}}</span>
                </a>

                <ul class="sub-menu">
                    <li>
                        @php
                        $tid="";
                        if(session('tenantid')!==null)
                        {$tid = session('tenantid');}

                        @endphp
                        <a href="/landing?tid={{$tid}}">{{trans('adminview.view_landing')}}</a>
                    </li>

                    <li>
                        <a href="/tenant/pages">{{trans('adminview.pages')}}</a>
                    </li>
                </ul>
            </li>




        </ul>
    </div>
</div>
<!--------------------
END - Menu side
-------------------->