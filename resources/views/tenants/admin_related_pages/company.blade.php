@section('content')
@extends('tenants.layouts.app_layout', ['layout' => 'left_side_menu_tenant'])
<div class="layout-w">

  <div class="content-w">

    @include('tenants.shared._top_menu_tenant')

    <div class="content-i">
      <div class="content-box">

        @if((session('helpview')!=null))
        <div class="element-wrapper" id='helpform'>
          <div class="element-box">
            <h5 class="form-header">
              {!!trans('tenant_company.help_title')!!}
            </h5>
            <div class="form-desc">
              {!!trans('tenant_company.help_content')!!}
            </div>
            <div class="element-box-content example-content">
              <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                {{trans('tenant_company.help_btn_hide_caption')}}</button>
            </div>
          </div>
        </div>
        @endif

        @if (Session::has('adminmsg'))
        <div id='alertadmin' class="alert alert-danger">{{ Session::get('adminmsg') }}</div>
        @endif
        <div class="os-tabs-w">
          <div class="os-tabs-controls tab">
            <ul class="nav nav-tabs upper">
              <li class="nav-item">
                <a aria-expanded="false" class="nav-link active" data-toggle="tab" onclick="searchtypes('')" href="#">
                  {{trans('adminview.company_all_select')}} </a>
              </li>

              <li class="nav-item">
                <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('investor')" href="#">
                  {{trans('adminview.company_investors_select')}} </a>
              </li>
              <li class="nav-item">
                <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('enterprise')" href="#">
                  {{trans('adminview.company_enterprise_select')}} </a>
              </li>
              <li class="nav-item">
                <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('service providers')"
                  href="#">{{trans('adminview.company_serviceproviders_select')}}</a>
              </li>
              <li class="nav-item">
                <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('eso')" href="#">
                  {{trans('adminview.company_eso_select')}}</a>
              </li>


            </ul>
          </div>
        </div>

        <div class="element-wrapper">
          <h6 class="element-header">
            {{trans('adminview.company_title')}}
          </h6>



          <div class="element-box">
            <div class="table-responsive">
              <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                <thead>
                  <tr>
                    <th>{{trans('adminview.company_table_tenant_id')}}</th>
                    <th>{{trans('adminview.company_table_company_name')}}</th>
                    <th>{{trans('adminview.company_table_company_type')}}</th>
                    <th>{{trans('adminview.company_table_sector')}}</th>
                    <th>Status</th>
                    <th>{{trans('adminview.company_table_action')}}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{trans('adminview.company_table_tenant_id')}}</th>
                    <th>{{trans('adminview.company_table_company_name')}}</th>
                    <th>{{trans('adminview.company_table_company_type')}}</th>
                    <th>{{trans('adminview.company_table_sector')}}</th>
                    <th>Status</th>
                    <th>{{trans('adminview.company_table_action')}}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach($company as $company1)
                  <tr>
                    <!--                           <td><span>{{$company1->tenantid}}</span></td>-->

                    <td>
                      <div class="user-with-avatar  ">
                        <a href="#">
                          @if( (isset($company1->profileimage) && !empty($company1->profileimage) ) &&
                          File::exists(public_path('storage/tenant/logoimage/'.$company1->profileimage)))
                          <img alt="" src="storage\tenant\logoimage\{{$company1->profileimage}}" />


                          @else
                          <img alt="" src="{{ Avatar::create(ucfirst($company1->tenantcompany))->toBase64() }}" />
                          @endif
                        </a>
                        </span><span>{{$company1->tenantcompany}}</span>
                      </div>

                    </td>







                    <td>
                      <div class="user-with-avatar  ">
                        <a href="/company/profile/view?{{'company='.$company1->companyid .'&companytype='.$company1->companytype}}&calledfrom=tenant">
                          @if((isset($company1->profileimage) && !empty($company1->profileimage) ) &&
                          File::exists(public_path('storage/company/profileimage/'.$company1->profileimage)))
                          <img alt="" src="/storage/company/profileimage/{{$company1->profileimage}}" />


                          @else
                          <img alt="" src="{{ Avatar::create($company1->companyname)->toBase64() }}" />
                          @endif
                        </a>
                        </span><span>{{$company1->companyname}}</span>
                      </div>

                    </td>
                    <td><span>{{$company1->companytype}}</span></td>
                    <td>
                      <span>{{$company1->sectors}}
                        @if($company1->scount>1)
                        <span class="smaller lighter">more</span>
                        @endif
                      </span>
                    </td>
                    <td>{{$company1->activestatus}}</td>
                    <td>



                      <div class="btn-group mr-1 mb-1 show">

                        <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle"
                          data-toggle="dropdown" id="dropdownMenuButton1" type="button">{{trans('adminview.company_action_btn_label')}}</button>
                        <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start"
                          style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                          <a class="dropdown-item" href="/company/profile/view?{{'company='.$company1->companyid .'&companytype='.$company1->companytype}}&calledfrom=tenant">{{trans('adminview.company_view_btn_label')}}</a>

                          @if($company1->activestatus=="Active")
                          <a class="dropdown-item" onclick="companyinactive('{{$company1->companyid}}');" href="#">Make
                            Inactive</a>
                          @elseif($company1->activestatus=="In-Active")
                          <a class="dropdown-item" onclick="companyactive('{{$company1->companyid}}');" href="#">Make
                            Active</a>
                          @endif


                          <!--                                <a class="dropdown-item" href="/gotoadmin?companyid={{$company1->companyid}}"  >{{trans('adminview.company_transfer_btn_label')}}</a>-->

                        </div>
                      </div>



                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!--------------------
              START - Color Scheme Toggler
              -------------------->
        <div class="floated-colors-btn second-floated-btn">
          <div class="os-toggler-w">
            <div class="os-toggler-i">
              <div class="os-toggler-pill"></div>
            </div>
          </div>
          <span>Dark </span><span>Colors</span>
        </div>
        <!--------------------
              END - Color Scheme Toggler
              -------------------->
        <!--------------------
              START - Chat Popup Box
              -------------------->
        <div class="floated-chat-btn">
          <i class="os-icon os-icon-mail-07"></i><span>Demo Chat</span>
        </div>
        <div class="floated-chat-w">
          <div class="floated-chat-i">
            <div class="chat-close">
              <i class="os-icon os-icon-close"></i>
            </div>
            <div class="chat-head">
              <div class="user-w with-status status-green">
                <div class="user-avatar-w">
                  <div class="user-avatar">
                    <img alt="" src="img/avatar1.jpg">
                  </div>
                </div>
                <div class="user-name">
                  <h6 class="user-title">
                    John Mayers
                  </h6>
                  <div class="user-role">
                    Account Manager
                  </div>
                </div>
              </div>
            </div>
            <div class="chat-messages">
              <div class="message">
                <div class="message-content">
                  Hi, how can I help you?
                </div>
              </div>
              <div class="date-break">
                Mon 10:20am
              </div>
              <div class="message">
                <div class="message-content">
                  Hi, my name is Mike, I will be happy to assist you
                </div>
              </div>
              <div class="message self">
                <div class="message-content">
                  Hi, I tried ordering this product and it keeps showing me error code.
                </div>
              </div>
            </div>
            <div class="chat-controls">
              <input class="message-input" placeholder="Type your message here..." type="text">
              <div class="chat-extra">
                <a href="#"><span class="extra-tooltip">Attach Document</span><i class="os-icon os-icon-documents-07"></i></a><a
                  href="#"><span class="extra-tooltip">Insert Photo</span><i class="os-icon os-icon-others-29"></i></a><a
                  href="#"><span class="extra-tooltip">Upload Video</span><i class="os-icon os-icon-ui-51"></i></a>
              </div>
            </div>
          </div>
        </div>
        <!--------------------
              END - Chat Popup Box
              -------------------->
      </div>
    </div>
  </div>
</div>





@endsection


@section('scripts')

<script>
  $("#alertadmin").fadeTo(2000, 500).slideUp(500, function () {
    $("#success-alert").slideUp(500);
  });

  function searchtypes(searchfactor) {
    //$('div.dataTables_filter input').val(searchfactor);
    $('#dataTable1').DataTable().search(searchfactor).draw();


  }
  //created company view



  function companyactive(companyid) {
    $.get('/makecompanyactive?companyid=' + companyid, function (data) {
      location.reload();
    });


  }

  function companyinactive(companyid) {
    $.get('/makecompanyinactive?companyid=' + companyid, function (data) {
      location.reload();
    });

  }
</script>
@endsection