@php
$extends="";
$view="";
$layout="";
if(isset($calledfrom) && !empty($calledfrom))
{
    
    if($calledfrom=="admin")
    {
      $view='adminview.layouts.app_layout';
      $layout='left_side_menu';
       
    }
    else if($calledfrom=="tenant")
    {
       $view= 'tenants.layouts.app_layout';
       $layout='left_side_menu_tenant';
      
    }
}
else
{
    $view= 'layouts.app_layout';
     $layout='left_side_menu_compact'; 
}

@endphp

@extends($view, ['layout' => $layout])

@section('content')

<?php 
$helper=\App\Helpers\AppHelper::instance();
$loggedinuserid=Session('userid');
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
?>  
      <div class="content-w portfolio-custom-vk">

        <!--  START - Secondary Top Menu  -->
        @if(isset($calledfrom) && !empty($calledfrom))
        @if($calledfrom=="admin")
         @include('adminview.shared._top_menu')
         
        @elseif($calledfrom=="tenant")
        @include('tenants.shared._top_menu_tenant')
        @endif
        @else
         @include('shared._top_menu')
        @endif
                <!--   END - Secondary Top Menu   -->


                <div aria-labelledby="exampleModalLabel" class="modal fade" id="change_ddstatus_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">
                            Update Due Diligence Status
                        </h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="row">
                              <div class="col-sm-12">
                              <div class="form-group">
                                  This action will update the due diligence status. Do you want to continue?
                              </div>
                            </div>
                          </div>
                        </form>
                      <input type="hidden" id="selected_ddstatus" value="{{$pipelinedealobj->pipelinedealstatus}}"/>
                      <input type="hidden" id="previous_ddstatus" value="{{$pipelinedealobj->pipelinedealstatus}}"/>
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button" id="template_close" onclick="fnCancelChangeDDStatus()">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                        <button class="btn btn-primary" type="button" onclick="fnActualChangeDDStatus();" id="changetemplate_yes">{{trans('duediligenceprocess.btn_caption_yes')}}</button>
                      </div>
                    </div>
                  </div>
                </div>        


        <div aria-labelledby="exampleModalLabel" class="modal fade" id="change_template_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                    Change Template
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="row">
                      <div class="col-sm-12">
                      <div class="form-group">
                          This action will delete all the existing modules and questions. Do you want to continue?
                      </div>
                    </div>
                  </div>
                </form>
              <input type="hidden" id="selected_templateid" value="{{$pipelinedealobj->templateid}}"/>
              <input type="hidden" id="previous_templateid" value="{{$pipelinedealobj->templateid}}"/>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button" id="template_close" onclick="fnCancelChangeTemplate()">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                <button class="btn btn-primary" type="button" onclick="fnActualChangeTemplate();" id="changetemplate_yes">{{trans('duediligenceprocess.btn_caption_yes')}}</button>
              </div>
            </div>
          </div>
        </div>

        <div aria-labelledby="exampleModalLabel" class="modal fade bd-example-modal-lg" id="company_list_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Company List
                        </h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="element-wrapper">
                            <div class="controls-above-table filter-row-top">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form class="form-inline justify-content-sm-end">
                                            <input class="form-control form-control-sm rounded bright" placeholder="Search" id="txtSearch" type="text">
                                            <select class="form-control form-control-sm rounded bright" id="sortbyfield" onchange="GetCompanies();">
                                                <option selected="selected" value="">
                                                    Sort By
                                                </option>
                                                <option value="name">
                                                    Comapany Name
                                                </option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-danger form-group" role="alert" id="errorbox-inviting" style="display:none;margin-top:10px;">
                                {{trans('duediligenceprocess.inviting_existing_company_errormessage')}}
                            </div>
        
                            <div id="divcompany-list">
                            
        
                            </div>
        
                        </div>
            
                    </div>
                    <div class="modal-footer">
                        {{-- <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button><button class="btn btn-primary" type="button"> Save changes</button> --}}

                    </div>
                </div>
            </div>
        </div>

        <div class="content-panel-toggler">
          <i class="os-icon os-icon-grid-squares-22"></i>
          <span>Sidebar</span>
        </div>
        <!--START - Control panel above projects-->
        <div class="content-i control-panel">
          <div class="content-box-tb">
              @if((session('helpview')!=null))
              <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                  <h5 class="form-header">
                         {!!trans('dd_dashboard.help_title')!!}   
                      </h5>
                      <div class="form-desc">
                        {!!$helper->GetHelpModifiedText(trans('dd_dashboard.help_content'))!!}
                      </div>
                      <div class="element-box-content example-content">
                              <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('dd_dashboard.help_btn_hide_caption')}}</button>
                      </div>
                </div>
    </div>
@endif

            <div class="os-tabs-w">
              <div class="os-tabs-controls">
                <ul class="nav nav-tabs upper">
                    @if(isset($calledfrom) && !empty($calledfrom) )
                      <li class="nav-item">
                        <a aria-expanded="false" class="nav-link active"  href="/due-diligence-dashboard?pd={{$pipelinedealid.'&calledfrom='.$calledfrom.'&companyid='.$cid.'&tenantid='.$tid}}">{{trans('duediligenceprocess.lebel_duediligencedashboard')}}</a>
                      </li>
                     
                   @else
                   <li class="nav-item">
                      <a aria-expanded="false" class="nav-link active"  href="/due-diligence-dashboard?pd={{$pipelinedealid}}">{{trans('duediligenceprocess.lebel_duediligencedashboard')}}</a>
                    </li>
                    <li class="nav-item">
                      <a aria-expanded="false" class="nav-link" href="/due-diligence-process?pd={{$pipelinedealid}}">{{trans('duediligenceprocess.lebel_duediligenceprocess')}}</a>
                    </li>
                    <li class="nav-item">
                      <a aria-expanded="false" class="nav-link"  href="/messaging?pd={{$pipelinedealid}}"> {{trans('duediligenceprocess.lebel_messaging')}}</a>
                    </li>
                    <li class="nav-item">
                      <a aria-expanded="false" class="nav-link" href="/pipelinedeal-docs?pd={{$pipelinedealid}}"> {{trans('duediligenceprocess.lebel_documents')}}</a>
                  </li>

                    @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!--END - Control panel above projects-->

        <div class="content-i">
          <div class="content-box">
            <!--
              start - Due Diligence Dashboard
              -->
            <div class="row">
              <div class="col-sm-12">
                <div class="element-wrapper">
                  <h6 class="element-header">
                    {{trans('dd_dashboard.dd_dash_menu')}}
                  </h6>
                 
                  <!--START - Projects list-->
                  <div class="projects-list projects-list-vk">

                    <div class="project-box marbtm">
                      <div class="project-head">
                        <div class="project-title kinaracpital">
                          <h5>
                            {{-- Kinara Capital --}}
                            {{$pipelinedeal_info[0]->dealcompany}}
                          </h5>
                          <div class="label">
                              {{$pipelinedeal_info[0]->statusmessage}}
                          </div>
                        </div>
                        @php
                          $all_user_count=count($All_Associated_company);
                          $cnt=1;
                          $remaining=0;
                          if($all_user_count>4)
                              {
                                   $remaining=$all_user_count-4;
                              }
                              else 
                              {
                                $remaining=0;
                              }
                          $UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
                          $CompanyLogoImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
                        @endphp
                        <div class="project-users">
                            @foreach($All_Associated_company as $du)
                       
                            @if($cnt>4)
                              @break
                            @endif
     
                              {{-- <div class="avatar">
                                <a href="/user/profile/view?user={{$du->userid}}">     
                                  @if(isset($du->profileimage) && !empty($du->profileimage) )
                                  <img alt="" src="{{$UserProfileImagePath . $du->profileimage}}">
                                  @else
                                  <img alt="" src="{{ Avatar::create(strtoupper($du->firstname .' '. $du->lastname))->toBase64() }}">    
                                   @endif
                                </a>
                              </div> --}}
                              <div class="avatar avatar-cm-img">
                                           
                                  <a href="/company/profile/view?{{'company='.$du->companyid .'&companytype='.$du->companytype.'&calledfrom='.$calledfrom}}">     
                                    @if(isset($du->profileimage) && !empty($du->profileimage) )
                                    <img alt="" src="{{$CompanyLogoImagePath . $du->profileimage}}">
                                    @else
                                    <img alt="" src="{{ Avatar::create(strtoupper($du->company))->toBase64() }}">    
                                     @endif
                                  </a>
                                 
                              </div>
     
                         <?php
                          $cnt++;
                           ?>
                         @endforeach
                         @if($remaining>0)
                         <div class="more">
                           + {{$remaining}} More
                         </div>
                         <?php
                         $remaining=0;
                          ?>
                         @endif
                        </div>
                      </div>
                      <div class="project-info">
                        <div class="row align-items-center">
                          <div class="col-sm-12 col-lg-9">
                            <div class="row">
                              <div class="col-sm-3">
                                <div class="el-tablo highlight">
                                  <div class="label">
                                  {{trans('dd_dashboard.dd_invest_reqd_label')}}
                                  </div>
                                  <div class="value">
                                    {{-- $12m --}}
                                    {{$pipelinedeal_info[0]->symbol.$helper->nice_number($pipelinedeal_info[0]->totalinvestmentrequired)}}
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-5">
                                <div class="el-tablo estimated-time profile-tile highlight">
                                  <div class="profile-tile-meta">
                                    <ul>
                                        <li>
                                            <span> Project:</span>
                                        <a href="/deals/view-deal?dealid={{$pipelinedeal_info[0]->dealid}}&calledfrom={{$calledfrom}}" target="_blank"><strong>{{$pipelinedeal_info[0]->projectname}}</strong></a>
                                          </li>
                                      <li>
                                        <span> {{trans('dd_dashboard.dd_stage_label')}}:</span>
                                        <strong>{{$pipelinedeal_info[0]->investmentstage}} </strong>
                                      </li>
                                      <li>
                                        <span>{{trans('dd_dashboard.dd_date_created_label')}}:</span> 
                                        <strong>{{date('M d, Y',strtotime($pipelinedeal_info[0]->created)) }}</strong>
                                      </li>
                                      {{-- <li class="text-wrap-row">
                                        <span>{{trans('dd_dashboard.dd_deal_source_label')}}:</span>
                                        <strong>Artha Venture Challenge Challenge dummy content for all Challenge  </strong>
                                      </li> --}}
                                      <li>
                                      <span> {{trans('dd_dashboard.dd_deal_country_label')}}:</span> 
                                        <strong>{{$pipelinedeal_info[0]->country}} </strong>
                                      </li>
                                      <li>
                                      <span> {{trans('dd_dashboard.dd_total_views_label')}}:</span> 
                                        <strong>{{$pipelinedeal_info[0]->totalviews}}</strong>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-4">
                                <div class="el-tablo estimated-time profile-tile highlight">
                                  <div class="profile-tile-meta">
                                    <ul>
                                      {{-- <li>
                                        <span> {{trans('dd_dashboard.dd_round_label')}}:</span>                                        
                                        <strong>One </strong>
                                      </li> --}}
                                      @if(isset($pipelinedeal_info[0]->startdate))
                                      <li>
                                        <span>{{trans('dd_dashboard.dd_start_label')}}:</span>
                                        <strong>{{date('M d, Y',strtotime($pipelinedeal_info[0]->startdate)) }} </strong>
                                      </li>
                                      @endif
                                      @if(isset($pipelinedeal_info[0]->completeddate))
                                      <li>
                                        <span>{{trans('dd_dashboard.dd_completed_label')}}:</span>
                                        <strong>{{date('M d, Y',strtotime($pipelinedeal_info[0]->completeddate)) }}</strong>
                                      </li>
                                      @endif
                                    </ul>
                                    <div class="pt-btn">
                                      <a class="btn btn-success btn-sm" href="#">{{$pipelinedeal_info[0]->pipelinedealstatus}}</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          @php
                          $progress=0;
                          $completed_q=0;
                          $total_q=0;
                          
                           if(isset($pd_progress))
                           {
                            $progress=$pd_progress[0]->progress;
                            $completed_q=$pd_progress[0]->completedquestions;
                            $total_q=$pd_progress[0]->tquestions;

                            $progress_percent=0;
                            $completed_percent=0;
                            if($total_q>0)
                            {
                              $progress_percent=intval(($progress/$total_q)*100);
                              $completed_percent=intval(($completed_q/$total_q)*100);
                            }
                          }
 

                          @endphp
                          <div class="col-sm-3 offset-sm--1">
                            <div class="os-progress-bar primary">
                              <div class="bar-labels">
                                <div class="bar-label-left">
                                  <span>{{trans('dd_dashboard.dd_progress_label')}}</span>
                                  <span class="positive">+{{$progress}}</span>
                                </div>
                                <div class="bar-label-right">
                                  <span class="info">{{$completed_q}}/{{$total_q}}</span>
                                </div>
                              </div>
                              <div class="bar-level-1" style="width: 100%">
                                <div class="bar-level-2" style="width: {{$progress_percent}}%">
                                  <div class="bar-level-3" style="width: {{$completed_percent}}%"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="my-profile-foldr clearfix">
                         
                          <div class="project-users">
                         {{trans('dd_dashboard.dd_SDG_label')}}
                          </div>
                        </div>
                        <div class="sds-cost-folder">
                          <div class="row">
                            <div class="col-md-6">
                             &nbsp;
                            </div>
                            <div class="col-md-6 text-right">
                                @if(isset($deals_sdgs))
                                @foreach($deals_sdgs as $sdg)
                          <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button">{{$sdg->sdg}}</button>
                               @endforeach
                               @endif
                            </div>
                          </div>
                        </div>
                       
                      </div>
                    </div>
                   <!-- STRAT - Dashboard -->                   
                   <div class="element-content threbx marbtm">
                    <div class="row">
                      <div class="col-sm-4">
                        <a class="element-box el-tablo" href="#">
                          <div class="label">
                          {{trans('dd_dashboard.dd_modules_label')}}
                          </div>
                          <div class="value">
                            {{$pdealposition[0]->Modules}}
                          </div>
                          
                        </a>
                      </div>
                      <div class="col-sm-4">
                        <a class="element-box el-tablo" href="#">
                          <div class="label">
                            {{trans('dd_dashboard.dd_pending_tasks_label')}}
                          </div>
                          <div class="value">
                              {{$pdealposition[0]->Pending}}
                          </div>                          
                        </a>
                      </div>
                      <div class="col-sm-4">
                        <a class="element-box el-tablo" href="#">
                          <div class="label">
                            {{trans('dd_dashboard.dd_completed_tasks_label')}}
                          </div>
                          <div class="value">
                              {{$pdealposition[0]->Completed}}
                          </div>                          
                        </a>
                      </div>
                    </div>
                  </div>
                   <!--END - Dashboard end-->
                     <!--   start - progress bar  -->
              <div class="element-box element-wrapper-marging-btm">
                <h5 class="form-header">
                 {{trans('dd_dashboard.dd_progress_label')}}
                </h5>
                <div class="form-desc">{{trans('dd_dashboard.dd_progress_content')}}
                </div>
                <div class="element-box-content example-content">
                  <div class="progress">
                    <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="{{$pdealposition[0]->completedpercentage}}" class="progress-bar" role="progressbar" style="width: {{$pdealposition[0]->completedpercentage}}%;">
                        {{$pdealposition[0]->completedpercentage}}%
                    </div>
                  </div>
                </div>
              </div>
              <!--
              END - progress bar
              -->
             <!--
              START - Due Diligence Assignments
              -->
             
              <div class="home-processbar-due-diligence">
                <div class="element-wrapper">
                  <h6 class="element-header">
                    {{trans('dd_dashboard.dd_assignments_label')}}
                  </h6>
                  <div class="element-box">
                    @foreach($assignments as $m)
                    <div class="os-progress-bar primary">
                      <div class="bar-labels">
                        <div class="bar-label-left">
                          <span class="bigger">{{$m->modulename}} </span>
                        </div>
                        <div class="bar-label-right">
                          <span class="info">{{$m->TotalTasks}} Questions / {{$m->PendingTasks}} Pending</span>
                        </div>
                      </div>
                      <div class="bar-level-1" style="width: 100%">
                      <div class="bar-level-2" style="width: {{$m->AssignedPercent}}%">
                          <div class="bar-level-3" style="width: {{$m->CompletedPercent}}%"></div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @if(!isset($calledfrom) || empty($calledfrom))
                    <div class=" text-right my-portfolio-btm">                     
                      <a class="mr-2 mb-2 btn btn-primary btn-sm" href="/due-diligence-process?pd={{$pipelinedealid}}">View All Questions</a>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
              <!--
              END - Due Diligence Assignments
            -->

              <div class="element-wrapper margin-top">
                <!--
                START - documents table 
               -->

               <h6 class="element-header">
                {{trans('dd_dashboard.dd_at_the_table_label')}}

                @if(!isset($calledfrom) || empty($calledfrom))
                @if($is_parent[0]->Is_Parent=='Yes')
                <button style="float: right;" class="mr-2 mb-2 btn btn-primary btn-sm btn-pluse" data-placement="top" data-toggle="tooltip" data-original-title="{{$helper->GetHelpModifiedText(trans('dd_dashboard.invite_company'))}}"  onclick="fnOpenCompanyModal()" type="button">
                   <i class="plus-icn"><img src="img/plus-icon.png" /> </i>
                 Invite Company</button>

                 @endif
                 @endif

               </h6>

                <div class="element-box">                 
                  <div class="controls-above-table">     
                                   
                  </div>
                  <div class="table-responsive table-responsive-heading-spce">
                    <table class="table table-lightborder">
                      <thead>
                        <tr>
                          <th class="name">
                         {{trans('dd_dashboard.dd_table_company')}}
                          </th>
                          <th class="format">
                            {{trans('dd_dashboard.dd_table_entity')}}
                          </th>
                          <th class="type">
                            {{trans('dd_dashboard.dd_table_type')}}
                          </th> 
                          @if(!isset($calledfrom) || empty($calledfrom))                      
                          <th class="action text-center">
                            {{trans('dd_dashboard.dd_table_action')}}
                          </th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($involved_companies_with_admin_users as $am)
                        
                        <tr>
                            <td>
                
                              <div class="user-with-avatar company-name-img">
                                
                                <a href="/company/profile/view?{{'company='.$am->companyid .'&companytype='.$am->companytype.'&calledfrom='.$calledfrom}}"> 
                                  @if($am->profileimage==null)
                                <img alt="" src="{{ Avatar::create($am->company)->toBase64() }}" style="width: 50px;"/> 
                                   @else
                                   <img alt="" src="storage\company\profileimage\{{$am->profileimage}}" style="width: 50px;"/>   
                                  @endif
                                    </a>
                                <span class="d-none d-xl-inline-block">{{$am->company}}</span>
                              </div>
                            </td>
                            <td>
                                {{$am->companytype}}
                            </td>
                            <td>
                              {{$am->type}}
                            </td> 
                            @if(!isset($calledfrom) || empty($calledfrom))                       
                            <td class="text-center">
                              {{-- <a href="#">
                                <i class="os-icon os-icon-link-3"></i>
                              </a> --}}
                              <div class="btn-group mr-1 mb-1">
                                  <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">{{trans('dd_dashboard.dd_btn_action')}}</button>
                                  <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                      <a class="dropdown-item" href="/company/profile/view?{{'company='.$am->companyid .'&companytype='.$am->companytype}}">{{trans('dd_dashboard.dd_view-profile')}}</a>
                                  
                                  @if($is_parent[0]->Is_Parent=='Yes')
                                  @if($am->type=='Associates' || $am->type=='Invited' || $am->type=='New Request')
                                  <a class="dropdown-item" href="#" onclick="fnOpenRemoveConfirmationModal('{{$am->type}}','{{$am->companyid}}')" >Remove</a>
                                    @endif
                                    @if($am->type=='New Request')
                                    <a class="dropdown-item" href="#" onclick="fnAcceptRequest('{{$am->type}}','{{$am->companyid}}')" >Accept Request</a>
                                    @endif

                                    @endif

                                  </div>
                              </div>

                              <div aria-labelledby="exampleModalLabel" class="modal fade" id="remove_company_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            {{trans('duediligenceprocess.remove_company_modal_title')}}
                                        </h5>
                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                                      </div>
                                      <div class="modal-body">
                                        <form>
                                          <div class="row">
                                              <div class="col-sm-12">
                                              <div class="form-group">
                                              <h6>
                                                  {{trans('duediligenceprocess.remove_company_modal_confirmation_text')}}
                                                </h6>
                                              </div>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                      <div class="modal-footer">
                                        <button class="btn btn-secondary" data-dismiss="modal" type="button" id="previousreply_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                                        <button class="btn btn-primary" type="button" onclick="fnRemoveCompany();" id="btncompany_del_yes">{{trans('duediligenceprocess.btn_caption_yes')}}</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>


                            </td>
                            @endif 
                          </tr> 

                        @endforeach
                           
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


              <!-- NEW CODE [Activities] -->
              {{-- <div class="element-wrapper margin-top user-profile" id="div_dd_activity">
              <div class="os-tabs-w">
                <div class="os-tabs-controls">
                  <ul class="nav nav-tabs bigger">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#tab_overview">Activity</a>
                    </li>
                  </ul>
                  <ul class="nav nav-pills smaller d-none d-md-flex">
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#" onclick="fnLoadActivities('Today')">Today</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#" onclick="fnLoadActivities('7 Days')">7 Days</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#" onclick="fnLoadActivities('14 Days')">14 Days</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#" onclick="fnLoadActivities('Last Month')">Last Month</a>
                    </li>
                  </ul>
                </div>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_overview">
                    <div class="timed-activities padded" id="div_dd_activity_contents">
                 

                    </div>
                  </div>
                </div>
              </div>

            </div> --}}
             

            <div class="element-wrapper margin-top">

               <h6 class="element-header">
                 Activity

                 <ul class="nav nav-pills smaller d-none d-md-flex" style="float:right;">
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#" onclick="fnLoadActivities('Today')">Today</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#" onclick="fnLoadActivities('7 Days')">7 Days</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#" onclick="fnLoadActivities('14 Days')">14 Days</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#" onclick="fnLoadActivities('Last Month')">Last Month</a>
                    </li>
                  </ul>

               </h6>

                <div class="element-box">                 
                    <div class="timed-activities padded" id="div_dd_activity_contents">
                 

                      </div>

                </div>
              </div>






              <!-- END OF NEW CODE [Activities] -->

                  </div>
                  <!--END - Projects list-->
                </div>
              </div>
            </div>
            <!--
              END - Due Diligence Dashboard
             -->
          </div>
          <!--
            START - Sidebar
           -->

          <div class="content-panel my-portfolio-rit">
            <div class="content-panel-close">
              <i class="os-icon os-icon-close"></i>
            </div>
               <div class="element-wrapper">
                  <h6 class="element-header">
                    {{trans('dd_dashboard.dd_select_template_label')}}
                  </h6>
                  <div class="element-box-tp">
                  <div class="form-group">
                   <select class="form-control" id="template_combo" >
                      {{-- onchange="ModifyTemplate()" --}}
                     <option value="0">
                        {{trans('dd_dashboard.dd_select_template_label')}}
                     </option>
                     @foreach($templates as $value)
                       @if($value->templateid==$pipelinedealobj->templateid)
                       <option selected value="{{$value->templateid}}">
                          {{$value->name}}
                        </option>
                       @else
                      <option value="{{$value->templateid}}">
                        {{$value->name}}
                      </option>
  
                       @endif
                     @endforeach
  
                    </select>
                  </div>
                  @if(!isset($calledfrom) || empty($calledfrom))
                  @if($is_parent[0]->Is_Parent=='Yes')
                  <button type="button" id="btnSelectTemplate" onclick="ModifyTemplate()" class="btn btn-success" style="float:right;">{{trans('dd_dashboard.dd_select_btn')}}</button>
                  <a href="/dd-templates"><button class="mr-2 mb-2 btn btn-link" style="float:right;" type="button">{{trans('dd_dashboard.dd_modify_template_link')}}</button></a>
                  @endif
                  @endif
                </div>
                    <div class="clearfix"></div>
                <div class="element-wrapper mt-3">
                <h6 class="element-header">
                  Due Diligence Status
                </h6>
                <div class="element-box-tp">
                <div class="form-group">
                 <select class="form-control" id="ddstatus_combo">
                   @foreach($dd_status as $value)
                     @if($value->ddstatus==$pipelinedeal_info[0]->pipelinedealstatus)
                     <option selected value="{{$value->ddstatus}}">
                        {{$value->ddstatus}}
                      </option>
                     @else
                    <option value="{{$value->ddstatus}}">
                      {{$value->ddstatus}}
                    </option>

                     @endif
                   @endforeach

                  </select>
                </div>
                @if(!isset($calledfrom) || empty($calledfrom))
                @if($is_parent[0]->Is_Parent=='Yes')
                <button type="button" id="btnUpdateStatus" onclick="ModifyDDStatus()" class="btn btn-success" style="float:right;">Update Status</button>
                @endif
                @endif
              </div>
            </div>
                </div>
        
                {{-- <div class="element-wrapper">

                </div> --}}

          </div>







          <!--
            END - Sidebar
            -->
        </div>
      </div>

      <input type="hidden", id="pipelinedealid" value='{{$pipelinedealid}}'/>
      <input type="hidden", id="selectedcompanyid" value=''/>
      <input type="hidden", id="selectedtype" value=''/>

        @endsection


        @section('scripts')
        <script type="text/javascript">

          $(document).ready(function(){ 
            fnLoadActivities("7 Days");
           });
        
        function fnOpenCompanyModal()
        {
          $("#divcompany-list").html('');
          GetCompanies();
          $('#company_list_modal').modal('show');
       
        }

        function fnOpenRemoveConfirmationModal(type,companyid)
        {
          
          $('#selectedcompanyid').val(companyid);
          $('#selectedtype').val(type);
          $('#remove_company_modal').modal('show');
        }



        function GetCompanies()
        {
          var searchtext=$('#txtSearch').val();
          var sortby=$("#sortbyfield option:selected").val();
    
        var route="/getcompanylist?searchtext="+searchtext+"&sortby="+sortby;


        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              
                $("#divcompany-list").html('');
                $("#divcompany-list").html(data);
               // var projectboxcount=$('.project-box').length;
              // $('#numberofbox').html(projectboxcount);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    
    
      }

            var timer;
  $("#txtSearch").keyup(function() {
    clearTimeout(timer);
    var ms = 1000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
      GetCompanies();
    }, ms);
  });
        
        function fnInviteCompany(companyid)
        {
          var pipelinedealid=$('#pipelinedealid').val();
          var route="/checkfor-already-invited-ormember?companyid="+companyid+"&pipelinedealid="+pipelinedealid;
          $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              
                if(data.message=='Success')
                {
                  $('#company_list_modal').modal('hide');
                  window.location.reload(true);
                }
                else
                {
                  var $messageDiv = $('#errorbox-inviting'); // get the reference of the div
                  $messageDiv.show(); // show and set the message.html(data.Message)
                  setTimeout(function () { $messageDiv.hide(); }, 7000); // 3 seconds later, hide
                }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
        }

        function fnRemoveCompany()
        {
         var companyid= $('#selectedcompanyid').val();
         var type= $('#selectedtype').val();
          var pipelinedealid=$('#pipelinedealid').val();
          if(typeof companyid=='undefined' || typeof type=='undefined' || typeof pipelinedealid=='undefined')
          {
            return;
          }
          var route="/remove-invited-requested-associated-company?companyid="+companyid+"&pipelinedealid="+pipelinedealid+"&type="+type;
          $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              
                if(data.message=='Success')
                {
                  $('#remove_company_modal').modal('hide'); 
                  window.location.reload(true);
                }
                else
                {
                }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
        }

        function fnAcceptRequest(type,companyid)
        {
          debugger;
          var pipelinedealid=$('#pipelinedealid').val();
          if(typeof companyid=='undefined' || typeof type=='undefined' || typeof pipelinedealid=='undefined')
          {
            return;
          }
          var route="/accept-new-company-request?companyid="+companyid+"&pipelinedealid="+pipelinedealid+"&type="+type;
          $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              
                if(data.message=='Success')
                {
                  // $('#remove_company_modal').modal('hide'); 
                  window.location.reload(true);
                }
                else
                {
                }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
        }


        function ModifyDDStatus()
        {
          debugger;
            var selectedddstatus = $("#ddstatus_combo option:selected").val();
            $('#selected_ddstatus').val(selectedddstatus);
            $('#change_ddstatus_modal').modal('show');
        }

          function fnActualChangeDDStatus()
          {
            debugger;
            var pipelinedealid=$('#pipelinedealid').val();
            var templateid=$('#selected_ddstatus').val();
            if(typeof pipelinedealid!='undefined')//templateid !="0" && 
            {
              var route='/change-dd-status'+'?pipelinedealid='+pipelinedealid+'&ddstatus='+templateid;
          $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              
              $('#change_ddstatus_modal').modal('hide');
              window.location.reload('true');
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
            }

          }

          function fnCancelChangeDDStatus()
          {
            var p_templateid=$('#previous_ddstatus').val();
            if(typeof p_templateid!='undefined')
             {
                if(p_templateid==null || p_templateid=="")
                {
                  $("#ddstatus_combo").val("0");
                }
                else{
                  $("#ddstatus_combo").val(p_templateid);
                }
              
             }

          }



          function ModifyTemplate()
          {
            debugger;
            var selectedTemplate = $("#template_combo option:selected").val();
            // if(selectedTemplate=="0")
            // {
            //   return;
            // }

            $('#selected_templateid').val(selectedTemplate);
            
            $('#change_template_modal').modal('show');

          }

          function fnActualChangeTemplate()
          {
            debugger;
            var pipelinedealid=$('#pipelinedealid').val();
            var templateid=$('#selected_templateid').val();
            if(typeof pipelinedealid!='undefined')//templateid !="0" && 
            {
              var route='/change-dd-template'+'?pipelinedealid='+pipelinedealid+'&templateid='+templateid;
          $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              
              $('#change_template_modal').modal('hide');
              //window.location.reload('true');
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
            }

          }


          function fnCancelChangeTemplate()
          {
            var p_templateid=$('#previous_templateid').val();
            if(typeof p_templateid!='undefined')
             {
                if(p_templateid==null || p_templateid=="")
                {
                  $("#template_combo").val("0");
                }
                else{
                  $("#template_combo").val(p_templateid);
                }
              
             }

          }


          function fnLoadActivities(duration)
          {

            debugger;
            var pipelinedealid=$('#pipelinedealid').val();
            
            if(typeof pipelinedealid!='undefined')
            {
              var route='/get-dd-activities'+'?pipelinedealid='+pipelinedealid+'&duration='+duration;
          $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              $('#div_dd_activity_contents').html('');
              $('#div_dd_activity_contents').html(data);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
            }
          }
        
        </script>

        @endsection