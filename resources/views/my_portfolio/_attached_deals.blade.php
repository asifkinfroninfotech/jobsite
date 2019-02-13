@php
$helper=\App\Helpers\AppHelper::instance();
@endphp




@php
$questions_col;
$parent_pipelinedeal_col;
if(isset($parent_pipelinedeal_data) && !empty($parent_pipelinedeal_data))
{
$parent_pipelinedeal_col=collect(json_decode($parent_pipelinedeal_data, true));
}

if(isset($modulequestionstatus) && !empty($modulequestionstatus))
{
$questions_col=collect(json_decode($modulequestionstatus, true));
}
// $deal_user_col = collect(json_decode($deal_company_users, true));

// $company_user_count=count($loggedin_company_users);
$cnt=1;
$remaining=0;
// $UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
@endphp

@foreach($data as $d)

@php
$parent_pipelinedeal_obj="";
if(isset($d->parentpipelinedealid) && !empty($d->parentpipelinedealid))
{
$parent_pipelinedeal_obj=$parent_pipelinedeal_col->where('pipelinedealid',$d->parentpipelinedealid)->first();
}
@endphp

<div class="project-box mar-one-rem">
  <div class="project-head">
    <div class="project-title kinaracpital">
      <h5>
        {{$d->company}}
      </h5>
      <div class="label">
        {{$d->statusmessage}}
      </div>
    </div>
    <div class="project-users">
      @php
      $company_col = collect(json_decode($All_Associated_company, true));
      $pipelinecompany;
      if(isset($d->parentpipelinedealid) && !empty($d->parentpipelinedealid))
      {
      $pipelinecompany= $company_col->where('parentpipelinedealid', $d->parentpipelinedealid);
      }
      else {
      $pipelinecompany= $company_col->where('parentpipelinedealid', $d->pipelinedealid);
      }

      $UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
      $CompanyLogoImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
      $remaining=0;
      $cnt=1;
      $count_dealusers=count($pipelinecompany);
      if($count_dealusers>4)
      {
      $remaining=$count_dealusers-4;
      }
      else
      {
      $remaining=0;
      }
      @endphp
      @foreach($pipelinecompany as $du)
      @if($cnt>=4)
      @break
      @endif

      <div class="avatar">

        <a href="/company/profile/view?{{'company='.$du['companyid'] .'&companytype='.$du['companytype']}}">
          @if(isset($du['profileimage']) && !empty($du['profileimage']) )
          <img alt="" src="{{$CompanyLogoImagePath . $du['profileimage']}}">
          @else
          <img alt="" src="{{ Avatar::create(strtoupper($du['company']))->toBase64() }}">
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
                {{trans('my_portfolio.lbl_investment_reqd')}}
              </div>
              <div class="value">
                {{$d->symbol.$helper->nice_number($d->totalinvestmentrequired)}}
              </div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="el-tablo estimated-time profile-tile highlight">
              <div class="profile-tile-meta">
                <ul>
                  <li>
                    <span>{{trans('my_portfolio.lbl_project')}}:</span>
                    <a href="/deals/view-deal?dealid={{$d->dealid}}" target="_blank"><strong>{{$d->projectname}}</strong></a>

                  </li>
                  <li>
                    <span>{{trans('my_portfolio.lbl_stage')}}:</span>
                    <strong>{{$d->investmentstage}}</strong>
                  </li>
                  <li>
                    <span>{{trans('my_portfolio.lbl_date_created')}}:</span>
                    <strong>{{date('M d,Y',strtotime($d->updated)) }}</strong>
                  </li>
                  <li>
                    <span>{{trans('my_portfolio.lbl_country')}}:</span>
                    <strong>{{$d->country}}</strong>
                  </li>
                  <li>
                    <span>{{trans('my_portfolio.lbl_tot_views')}}:</span>
                    <strong>{{$d->totalviews}}</strong>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="el-tablo estimated-time profile-tile highlight">
              <div class="profile-tile-meta">
                <ul>
                  @if(isset($parent_pipelinedeal_obj) && !empty($parent_pipelinedeal_obj))

                  @if(isset($parent_pipelinedeal_obj['startdate']) && !empty($parent_pipelinedeal_obj['startdate']))
                  <li>
                    <span>Start:</span>
                    <strong>{{date('M d,Y',strtotime($parent_pipelinedeal_obj['startdate'])) }} </strong>
                  </li>
                  @endif

                  @if(isset($parent_pipelinedeal_obj['completeddate']) &&
                  !empty($parent_pipelinedeal_obj['completeddate']))
                  <li>
                    <span>Completed:</span>
                    <strong>{{date('M d,Y',strtotime($$parent_pipelinedeal_obj['completeddate'])) }}</strong>
                  </li>
                  @endif

                  @else

                  @if(isset($d->startdate) && !empty($d->startdate))
                  <li>
                    <span>Start:</span>
                    <strong>{{date('M d,Y',strtotime($d->startdate)) }} </strong>
                  </li>
                  @endif

                  @if(isset($d->completeddate) && !empty($d->completeddate))
                  <li>
                    <span>Completed:</span>
                    <strong>{{date('M d,Y',strtotime($d->completeddate)) }}</strong>
                  </li>
                  @endif

                  @endif

                </ul>
                <div class="pt-btn">
                  <a class="btn btn-success btn-sm" href="#">
                    @if(isset($parent_pipelinedeal_obj) && !empty($parent_pipelinedeal_obj))
                    {{$parent_pipelinedeal_obj['pipelinedealstatus']}}
                    @else
                    {{$d->pipelinedealstatus}}
                    @endif
                  </a>
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

      $progress_percent=0;
      $completed_percent=0;

      if(isset($questions_col))
      {
      $questionstatus_row= $questions_col->where('pipelinedealid', $d->pipelinedealid)->first();

      if(isset($questionstatus_row))
      {
      $progress=$questionstatus_row['progress'];
      $completed_q=$questionstatus_row['completedquestions'];
      $total_q=$questionstatus_row['tquestions'];


      if($total_q>0)
      {
      $progress_percent=intval(($progress/$total_q)*100);
      $completed_percent=intval(($completed_q/$total_q)*100);
      }
      }
      }

      @endphp
      <div class="col-sm-3 offset-sm--1">
        <div class="os-progress-bar primary">
          <div class="bar-labels">
            <div class="bar-label-left">
              <span>{{trans('my_portfolio.lbl_progress')}}</span>
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
      <div class="label">
        {{trans('my_portfolio.lbl_folder')}}
        <a href="#" onclick="fnOpenModifyFolderPopup('{{$d->pipelinedealid}}');">
          <i class="os-icon os-icon-edit-1"></i>
          <span></span>
        </a>
        <div aria-labelledby="myLargeModalLabel" id="change_folder_modal" class="modal fade bd-example-modal-lg" role="dialog"
          tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                  {{trans('my_portfolio.popup_lbl_chg_pipeline_folder')}}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button" id="btn_changefolder_close"><span
                    aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="">{{trans('my_portfolio.popup_input_select_folder')}}</label>
                  <select class="form-control form-control-sm rounded bright" id="userpipeline_folders">
                    <option selected="selected" value="0">
                      {{trans('my_portfolio.popup_input_select_folder')}}
                    </option>
                    @foreach($pipelinefolders as $f)
                    <option value="{{$f->folderid}}">
                      {{$f->foldername}}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button" id="changefolder_close">{{trans('my_portfolio.btn_cancel_lbl')}}</button>
                <button class="btn btn-primary" type="button" onclick="fnUpdateFolder();" id="btnChangeFolder">{{trans('my_portfolio.btn_change_lbl')}}</button>
              </div>
              <div class="modal-footer">
                <div class="alert alert-danger form-group" role="alert" id="error-modify-folder" style="display:none;">
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="project-users">
        {{trans('my_portfolio.lbl_sdgs')}}
      </div>
    </div>
    <div class="sds-cost-folder">
      <div class="row">
        <div class="col-md-6">
          <ul>
            <li>
              <strong>{{$d->foldername}}</strong>
            </li>
          </ul>
        </div>
        <div class="col-md-6 text-right">
          <?php 
                                         $sdg_available=0;
                                         ?>
          @if(isset($deals_sdgs))

          @foreach($deals_sdgs as $sdg)
          @if($sdg->dealid==$d->dealid)
          <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button">{{$sdg->sdg}}</button>
          @php
          $sdg_available=1;
          @endphp
          @endif
          @endforeach

          @endif
          @if($sdg_available==0)
          No SDG (S) found.
          @endif
        </div>
      </div>
    </div>

    <div class="form-buttons-w text-right my-portfolio-btm">
      {{-- data-target="#confirmation_modal" data-toggle="modal" --}}
      <div aria-labelledby="exampleModalLabel" class="modal fade" id="confirmation_modal" role="dialog" tabindex="-1"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                {{trans('my_portfolio.lbl_startduediligence')}}
              </h5>
              <button aria-label="Close" class="close" data-dismiss="modal" type="button" id="btn_changefolder_close"><span
                  aria-hidden="true">×</span></button>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <h6 style="text-align:left;">{{trans('my_portfolio.startduediligence_content')}}</h6>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-dismiss="modal" type="button" id="confirmation_close">{{trans('my_portfolio.btn_cancel')}}</button>
              <button class="btn btn-primary" type="button" onclick="fnUpdatePipelineDealStatus('{{isset($d->parentpipelinedealid)==true?$d->parentpipelinedealid:$d->pipelinedealid}}');"
                id="btnStart">{{trans('my_portfolio.btn_yes')}}</button>
            </div>
            <div class="modal-footer">
              <div class="alert alert-danger form-group" role="alert" id="error-start-duediligence" style="display:none;">
              </div>
            </div>
          </div>
        </div>
      </div>
      @if(isset($parent_pipelinedeal_obj) && !empty($parent_pipelinedeal_obj))
      @if($parent_pipelinedeal_obj['pipelinedealstatus']=="Due Diligence New")
      <a class="btn btn-primary " href="#" data-target="#confirmation_modal" data-toggle="modal" onclick="fnStartDD('{{(isset($d->parentpipelinedealid) && !empty($d->parentpipelinedealid) )?$d->parentpipelinedealid:$d->pipelinedealid}}');">
        {{trans('my_portfolio.lbl_startduediligence')}}</a>
      @else
      <a class="btn btn-yellow-custom step-trigger-btn" href="/due-diligence-dashboard?pd={{(isset($d->parentpipelinedealid) && !empty($d->parentpipelinedealid) )?$d->parentpipelinedealid:$d->pipelinedealid}}">
        {{trans('my_portfolio.lbl_viewduediligence')}}</a>
      @endif

      @else
      @if($d->pipelinedealstatus=="Due Diligence New")
      <a class="btn btn-primary step-trigger-btn" data-target="#confirmation_modal" data-toggle="modal" href="#"
        onclick="fnStartDD('{{(isset($d->parentpipelinedealid) && !empty($d->parentpipelinedealid) )?$d->parentpipelinedealid:$d->pipelinedealid}}');">
        {{trans('my_portfolio.lbl_startduediligence')}}</a>
      @else
      <a class="btn btn-yellow-custom step-trigger-btn" href="/due-diligence-dashboard?pd={{(isset($d->parentpipelinedealid) && !empty($d->parentpipelinedealid) )?$d->parentpipelinedealid:$d->pipelinedealid}}">
        {{trans('my_portfolio.lbl_viewduediligence')}}</a>
      @endif
      @endif


      <div class="btn-group mr-1 mb-1" style="float:left;">
        <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
          id="dropdownMenuButton1" type="button">Action</button>
        <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
          @if($d->deal_active=="active")
          <a class="dropdown-item" href="#" onclick="inactive('{{$d->dealid}}');">Inactive</a>
          <a class="dropdown-item" href="#" onclick="archive('{{$d->dealid}}');">Archive</a>
          @endif
          @if($d->deal_active=="inactive")
          <a class="dropdown-item" href="#" onclick="active('{{$d->dealid}}');">Active</a>
          <a class="dropdown-item" href="#" onclick="archive('{{$d->dealid}}');">Archive</a>
          @endif
          @if($d->deal_active=="archive")
          <a class="dropdown-item" href="#" onclick="active('{{$d->dealid}}');">Active</a>
          <a class="dropdown-item" href="#" onclick="inactive('{{$d->dealid}}');">Inactive</a>
          @endif
        </div>
      </div>





    </div>

  </div>
</div>
@endforeach



<!--START - next pagers-->
{{ $data->links('pagination') }}
<!--END - next pagers-->