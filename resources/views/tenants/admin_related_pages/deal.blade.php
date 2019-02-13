@php
$helper=\App\Helpers\AppHelper::instance();
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();

@endphp

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
                                 {!!trans('tenant_deals.help_title')!!}   
                              </h5>
                              <div class="form-desc">
                                 {!!trans('tenant_deals.help_content')!!}
                              </div>
                              <div class="element-box-content example-content">
                                      <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('tenant_deals.help_btn_hide_caption')}}</button>
                              </div>
                 </div>
              </div>
              @endif
              <div class="element-wrapper">
                <h6 class="element-header">
                   {{trans('adminview.deal_title')}}
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
                                <th>{{trans('adminview.deal_table_company')}}</th>
                                
                                <th>{{trans('adminview.deal_table_stage')}}</th>
                                <th>{{trans('adminview.deal_table_country')}}</th>
                                <th>{{trans('adminview.deal_table_investmentstructure')}}</th>
                                <th>{{trans('adminview.deal_table_totalinvestmentreqd')}}</th>
                                <th>{{trans('adminview.deal_table_purposeofinvestment')}}</th>
                                <th>{{trans('adminview.deal_table_projectname')}}</th>
                                <th>{{trans('adminview.deal_table_action')}}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>{{trans('adminview.deal_table_company')}}</th>
                                
                                <th>{{trans('adminview.deal_table_stage')}}</th>
                                <th>{{trans('adminview.deal_table_country')}}</th>
                                <th>{{trans('adminview.deal_table_investmentstructure')}}</th>
                                <th>{{trans('adminview.deal_table_totalinvestmentreqd')}}</th>
                                <th>{{trans('adminview.deal_table_purposeofinvestment')}}</th>
                                <th>{{trans('adminview.deal_table_projectname')}}</th>
                                <th>{{trans('adminview.deal_table_action')}}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($data as $data)
                       
                        <tr>
                            
                            <td><span>{{$data->company}}</span></td>
                           
                            <td><span>{{$data->investmentstage}}</span></td>
                            <td><span>{{$data->country}}</span></td>
                            <td><span>{{$data->investmentstructure}}</span></td>
                            <td><span>{{$data->symbol.$helper->nice_number($data->totalinvestmentrequired)}}</span></td>
                            <td><span>{{$data->purposeofinvestment}}</span></td>
                            <td><span>{{$data->projectname}}</span></td>
                           
                            
                            
                           
                       <td>
                           

                       
                       
                       <div class="btn-group mr-1 mb-1 show">
                                  
                                  <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">{{trans('adminview.deal_action_btn_label')}}</button>
                                <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                  <a class="dropdown-item" href="/deals/view-deal?dealid={{$data->dealid}}&calledfrom=tenant"  >{{trans('adminview.deal_view_btn_label')}}</a></div>                                
                              </div>
                       
                       
                       
                       </td>
                        </tr>
                       
                        @endforeach
                        </tbody></table>
                  </div>
                </div>
              </div><!--------------------
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
              --------------------><!--------------------
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
                      <a href="#"><span class="extra-tooltip">Attach Document</span><i class="os-icon os-icon-documents-07"></i></a><a href="#"><span class="extra-tooltip">Insert Photo</span><i class="os-icon os-icon-others-29"></i></a><a href="#"><span class="extra-tooltip">Upload Video</span><i class="os-icon os-icon-ui-51"></i></a>
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

//$(document).ready(function (){
//   $('#dataTable1').dataTable({
//       destroy: true,
//       "aLengthMenu": [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
//       "iDisplayLength" : 4,        
//    });
//});


</script>
 @endsection
 
