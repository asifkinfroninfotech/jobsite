         @php
         $helper=\App\Helpers\AppHelper::instance();
         @endphp
              
              <div class="row">
                  <div class="col-sm-12">
                         <div class="element-wrapper portfolio-custom-vk">
                                    <h6 class="element-header">
                                        {{trans('investor_dashboard.text_my_active_portfolio')}} 
                                    </h6>
                                    <!--START - Projects list-->
                    <div class="projects-list projects-list-vk" id="div_user_project_list">
                            @if(count($data['pipelinedeals'])>0)

                         @php
                  $parent_pipelinedeal_col;
                  if(isset($data['parent_pipelinedeal_data']) && !empty($data['parent_pipelinedeal_data']))
                  {
                    $parent_pipelinedeal_col=collect(json_decode($data['parent_pipelinedeal_data'], true));
                  }
                         @endphp

                           @foreach ($data['pipelinedeals'] as $pipelinedeal)

                           @php 
                           $parent_pipelinedeal_obj="";
                            if(isset($pipelinedeal->parentpipelinedealid) && !empty($pipelinedeal->parentpipelinedealid))
                             {
                                if(isset($parent_pipelinedeal_col) && !empty($parent_pipelinedeal_col))
                                {
                                    $parent_pipelinedeal_obj=$parent_pipelinedeal_col->where('pipelinedealid',$pipelinedeal->parentpipelinedealid)->first();
                                }
                              
                             }
                           @endphp
                                        <div class="project-box">
                                            <div class="project-head">
                                                <div class="project-title kinaracpital">
                                                    <h5>
                                                        <!-- Kinara Capital -->
                                                    {{ $pipelinedeal->deal->company->name }}
                                                        
                                                    </h5>
                                                    <div class="label">
                                                        <!-- Financial Services -->
                                                        {{ $pipelinedeal->deal->company->statusmessage }}
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                                <!--asif-code-->
                    <div class="project-users">
                     @php
                     $company_col = collect(json_decode($data['All_Associated_company'], true));
                     $pipelinecompany;
                     if(isset($pipelinedeal->parentpipelinedealid) && !empty($pipelinedeal->parentpipelinedealid))
                     {
                        $pipelinecompany= $company_col->where('parentpipelinedealid', $pipelinedeal->parentpipelinedealid);
                     }
                     else {
                        $pipelinecompany= $company_col->where('parentpipelinedealid', $pipelinedeal->pipelinedealid);
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
                                                    <div class="col-sm-7">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="el-tablo highlight">
                                                                    <div class="label">
                                                                        Investment Required
                                                                    </div>
                                            <div class="value">
                                                <?php $symbol = DB::select( DB::raw("SELECT currency.symbol from deals left join currency on deals.currencyid=currency.currencyid WHERE deals.dealid = '".$pipelinedeal->deal->dealid."'") );
                                               
                                                ?>                         
                                            {{$symbol[0]->symbol.$helper->nice_number($pipelinedeal->deal->totalinvestmentrequired)}}
                                            </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="el-tablo estimated-time profile-tile highlight">
                                                                    <div class="profile-tile-meta">
                                                                        <ul>
                                                                            
                                                                             <li>
                                          <span>{{trans('my_portfolio.lbl_project')}}:</span>
                                           <a href="/deals/view-deal?dealid={{$pipelinedeal->deal->dealid}}" target="_blank"><strong>{{$pipelinedeal->deal->projectname}}</strong></a>
                                          </li>
                                                                            
                                                                            <li>
                                                <span>Stage:</span>
                                                <strong>{{$pipelinedeal->deal->investmentstage}}</strong>
                                                                            </li>
                                                                            <li>
                                          <span>{{trans('my_portfolio.lbl_date_created')}}:</span>
                                          <strong>{{date('M d,Y',strtotime($pipelinedeal->deal->updated)) }}</strong>
                                        </li>
                                        @if(isset($data['country']) || !empty($data['country']))
                                        @foreach($data['country'] as $country)
                                        @if($country->dealid==$pipelinedeal->deal->dealid)
                                             <li>
                                                <span>Country:</span>
                                                <strong>{{$country->name}}</strong>
                                                                            </li>
                                        @endif
                                        @endforeach
                                        @endif
                                        
                                         <li>
                                          <span>Total Views:</span>
                                          <strong>{{$pipelinedeal->deal->totalviews}}</strong>
                                        </li>

                                        @if(isset($parent_pipelinedeal_obj) && !empty($parent_pipelinedeal_obj))

                                        @if(isset($parent_pipelinedeal_obj['startdate']) && !empty($parent_pipelinedeal_obj['startdate']))
                                        <li>
                                        <span>Start:</span>
                                          <strong>{{date('M d,Y',strtotime($parent_pipelinedeal_obj['startdate'])) }} </strong>
                                        </li>
                                        @endif

                                        @if(isset($parent_pipelinedeal_obj['completeddate']) && !empty($parent_pipelinedeal_obj['completeddate']))
                                        <li>
                                        <span>Completed:</span>
                                          <strong>{{date('M d,Y',strtotime($parent_pipelinedeal_obj['completeddate'])) }}</strong>
                                        </li>
                                        @endif

                                         @else
                                        
                                         @if(isset($pipelinedeal->startdate) && !empty($pipelinedeal->startdate))
                                        <li>
                                        <span>Start:</span>
                                          <strong>{{date('M d,Y',strtotime($pipelinedeal->startdate)) }} </strong>
                                        </li>
                                        @endif

                                        @if(isset($pipelinedeal->completeddate) && !empty($pipelinedeal->completeddate))
                                        <li>
                                        <span>Completed:</span>
                                          <strong>{{date('M d,Y',strtotime($pipelinedeal->completeddate)) }}</strong>
                                        </li>
                                        @endif
                                        
                                        @endif
                                        </ul>
                                                <div class="pt-btn">
                                                <a class="btn btn-success btn-sm" href="#">
                                                        @if(isset($parent_pipelinedeal_obj) && !empty($parent_pipelinedeal_obj))
                                                        {{$parent_pipelinedeal_obj['pipelinedealstatus']}}
                                                        @else
                                                        {{$pipelinedeal->pipelinedealstatus}}
                                                        @endif
                                                </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                    $questions_col;
                                                    if(isset($data['modulequestionstatus']) && !empty($data['modulequestionstatus']))
                                                     {
                                                     $questions_col=collect(json_decode($data['modulequestionstatus'], true));
                                                     }
                                                        $progress=0;
                            $completed_q=0;
                            $total_q=0;
                            $progress_percent=0;
                            $completed_percent=0;
                            if(isset($questions_col))
                            {
                              $questionstatus_row= $questions_col->where('pipelinedealid', $pipelinedeal->pipelinedealid)->first();

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
                                                    <div class="col-sm-5 offset-sm--1">
                                                        <div class="os-progress-bar primary">
                                                            <div class="bar-labels">
                                                                <div class="bar-label-left">
                                                                    <span>Progress</span><span class="positive">+{{$progress}}</span>
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
                             
                            
                              

                            </div>
                            <div class="project-users">
                             SDG(S)
                            </div>
                          </div>
                                                
                        <div class="sds-cost-folder">
                            <div class="row">
                              <div class="col-md-6">
                                <ul>
                                  <li>
                                  
                                  </li>
                                </ul>
                              </div>
                              <div class="col-md-6 text-right">
                                @if(isset($data['deals_sdgs']))

                                  @foreach($data['deals_sdgs'] as $sdg)
                                  @if($sdg->dealid==$pipelinedeal->deal->dealid)
                            <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button">{{$sdg->sdg}}</button>
                                  @endif
                                 @endforeach 
                                   @endif                                                                                                                              
                                                                                                                                                                                                                                                                            
                               </div>
                            </div>
                          </div>

                                               
                    <div class="form-buttons-w text-right my-portfolio-btm">
                            <div aria-labelledby="exampleModalLabel" class="modal fade" id="confirmation_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">
                                            {{trans('my_portfolio.lbl_startduediligence')}}
                                        </h5>
                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button" id="btn_changefolder_close"><span aria-hidden="true">×</span></button>
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
                                        <button class="btn btn-primary" type="button" onclick="fnUpdatePipelineDealStatus('{{isset($pipelinedeal->parentpipelinedealid)==true?$pipelinedeal->parentpipelinedealid:$pipelinedeal->pipelinedealid}}');" id="btnStart">{{trans('my_portfolio.btn_yes')}}</button>
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
                            <a class="btn btn-primary" href="#" data-target="#confirmation_modal" data-toggle="modal"> {{trans('my_portfolio.lbl_startduediligence')}}</a>
                            @else
                            <a class="btn btn-yellow-custom" href="/due-diligence-dashboard?pd={{isset($pipelinedeal->parentpipelinedealid)==true?$pipelinedeal->parentpipelinedealid:$pipelinedeal->pipelinedealid}}"> {{trans('my_portfolio.lbl_viewduediligence')}}</a>
                            @endif

                            @else
                            @if($pipelinedeal->pipelinedealstatus=="Due Diligence New")
                            <a class="btn btn-primary" href="#" data-target="#confirmation_modal" data-toggle="modal"> {{trans('my_portfolio.lbl_startduediligence')}}</a>
                            @else
                            <a class="btn btn-yellow-custom" href="/due-diligence-dashboard?pd={{isset($pipelinedeal->parentpipelinedealid)==true?$pipelinedeal->parentpipelinedealid:$pipelinedeal->pipelinedealid}}"> {{trans('my_portfolio.lbl_viewduediligence')}}</a>
                            @endif
                            @endif


                            
                            
                    </div>
                                                
                                                
                                            </div>
                                        </div>        
 
                                   @endforeach
                                   
                                   @else
                                   <div class="element-box video-play-row">
                                        No Active Portfolio found.
                                    </div>

                                   @endif

                                    </div>
                                    <!--END - Projects list-->
                                </div>
                            </div>
                        </div>