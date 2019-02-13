@section('content')
@extends('adminview.layouts.app_layout', ['layout' => 'left_side_menu'])
<div class="layout-w">

  <div class="content-w">

    @include('adminview.shared._top_menu')



    <input type="hidden" id="hiddentenantactiveid" />
    <input type="hidden" id="hiddentenantinactiveid" />




    <div aria-labelledby="myLargeModalLabel" id="activepopup" class="modal fade bd-example-modal-lg" role="dialog"
      tabindex="-1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Tenant Active
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
          </div>

          <div class="modal-body" id="lstmodule">
            <p>This will make the current tenant active.</p>
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" data-dismiss="modal" type="button">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
            <button class="btn btn-primary" type="button" onclick="maketenantactive();" id="btnMessageSave">
              Proceed</button>
          </div>
          <!-- <div class="alert alert-success" role="alert" id="messagebox" style="display:none;">
                    <strong>Well done! </strong>Modeles are successfully updated.
                  </div> -->
        </div>
      </div>
    </div>



    <div aria-labelledby="myLargeModalLabel" id="inactivepopup" class="modal fade bd-example-modal-lg" role="dialog"
      tabindex="-1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Tenant Active
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
          </div>

          <div class="modal-body" id="lstmodule">
            <p>This will make the current tenant inactive.</p>
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" data-dismiss="modal" type="button">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
            <button class="btn btn-primary" type="button" onclick="maketenantinactive();" id="btnMessageSave">
              Proceed</button>
          </div>
          <!-- <div class="alert alert-success" role="alert" id="messagebox" style="display:none;">
                    <strong>Well done! </strong>Modeles are successfully updated.
                  </div> -->
        </div>
      </div>
    </div>











    <div class="content-i">
      <div class="content-box">
        <div class="element-wrapper">
          <h6 class="element-header">
            {{trans('adminview.tenant_title')}}
          </h6>
          <div class="element-box">
            <!--                  <h5 class="form-header">
                    Powerful Datatables
                  </h5>
                  <div class="form-desc">
                    DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table.. <a href="https://www.datatables.net/" target="_blank">Learn More about DataTables</a>
                  </div>-->
            <div class="table-responsive">
              <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                <thead>
                  <tr>
                    <th>{{trans('adminview.tenant_table_name')}}</th>
                    <th>{{trans('adminview.tenant_table_telephone')}}</th>
                    <th>{{trans('adminview.tenant_table_email')}}</th>
                    <th>{{trans('adminview.tenant_table_address')}}</th>
                    <th>{{trans('adminview.tenant_table_action')}}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{trans('adminview.tenant_table_name')}}</th>
                    <th>{{trans('adminview.tenant_table_telephone')}}</th>
                    <th>{{trans('adminview.tenant_table_email')}}</th>
                    <th>{{trans('adminview.tenant_table_address')}}</th>
                    <th>{{trans('adminview.tenant_table_action')}}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach($tenant as $tenant)

                  <tr>

                    <td>
                      <div class="user-with-avatar  ">
                        <a href="/tenant/profile/view?tenid={{$tenant->tenantid.'&calledfrom=admin'}}" target="_blank">
                          @if( (isset($tenant->minilogoimage) && !empty($tenant->minilogoimage) ) &&
                          File::exists(public_path('/storage/tenant/minilogoimage/'.$tenant->minilogoimage)))
                          <img alt="" src="/storage/tenant/minilogoimage/{{$tenant->minilogoimage}}" />
                          @else
                          <img alt="" src="{{ Avatar::create(ucfirst($tenant->tenantcompany))->toBase64() }}" />
                          @endif
                        </a>
                        <span>{{$tenant->tenantcompany}}</span>
                      </div>

                    </td>





                    <td><span>{{$tenant->telephone}}</span></td>

                    <td><span>{{$tenant->email}}</span></td>

                    <td>
                      <span>{{$tenant->address}}</span>
                    </td>





                    <td>




                      <div class="btn-group mr-1 mb-1 show">

                        <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle"
                          data-toggle="dropdown" id="dropdownMenuButton1" type="button">{{trans('adminview.tenants_action_btn_label')}}</button>
                        <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start"
                          style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                          <a class="dropdown-item" href="/tenant/profile/view?tenid={{$tenant->tenantid}}&calledfrom=admin">{{trans('adminview.tenants_view_btn_label')}}</a>
                          @if($tenant->tenantactive==0)


                          <a class="dropdown-item" href="#" data-target="#activepopup" data-toggle="modal" onclick="maketenantactiveassign('{{$tenant->tenantid}}');">{{trans('adminview.tenants_active_btn_label')}}</a>



                          <!-- <a class="dropdown-item" href="#" onclick="maketenantactive('{{$tenant->tenantid}}');">{{trans('adminview.tenants_active_btn_label')}}</a> -->
                          @else


                          <a class="dropdown-item" href="#" data-target="#inactivepopup" data-toggle="modal" onclick="maketenantinactiveassign('{{$tenant->tenantid}}');">{{trans('adminview.tenants_inactive_btn_label')}}</a>


                          <!-- <a class="dropdown-item" href="#" onclick="maketenantinactive('{{$tenant->tenantid}}');">{{trans('adminview.tenants_inactive_btn_label')}}</a> -->
                          @endif
                          <a class="dropdown-item" href="/gototenant?tenantid={{$tenant->tenantid}}">{{trans('adminview.tenant_transfer_btn_label')}}</a></div>
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
  function maketenantactiveassign(tenantid) {
    $('#hiddentenantactiveid').val(tenantid);
  }

  function maketenantinactiveassign(tenantid) {
    $('#hiddentenantinactiveid').val(tenantid);
  }

  function maketenantactive() {
    tenantid = $('#hiddentenantactiveid').val();
    $.get('/maketenantactive?tenantid=' + tenantid, function (data) {
      location.reload();
    });
  }

  function maketenantinactive() {
    debugger;
    tenantid = $('#hiddentenantinactiveid').val();
    $.get('/maketenantinactive?tenantid=' + tenantid, function (data) {
      location.reload();
    });
  }
</script>
@endsection