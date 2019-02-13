<?php 
$helper=\App\Helpers\AppHelper::instance();
$loggedinuserid=Session('userid');
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();

//  $collectionsdg = collect(json_decode($deals_sdgs, true));
 ?>  
     <div aria-hidden="true" aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm show-pop-up" role="dialog" tabindex="-1" id="common-pop-up">
        <div class="modal-dialog">
            <div class="modal-content" id="si_content">

            </div>
          </div>
      </div>


                            @foreach($data as $d)
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
                          <div class="avatar" style="float:right;">
                              
                               @if($d->profileimage==null && !isset($d->profileimage) && empty($d->profileimage))
                                        <img alt="" src="{{ Avatar::create($d->firstname .' '. $d->lastname)->toBase64() }}">   
                                @else
                                      <img alt="" src="{{$UserProfileImagePath . $d->profileimage}}">
                                 @endif
                              
                              
                             
                          </div>
                          <div class="more" style="top: 6px;vertical-align: bottom;">
                           Created By :
                          </div>
                        </div>
                                </div>
                                
                                <div class="project-info">
                                    <div class="row align-items-center">
                                        <div class="col-sm-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="el-tablo highlight">
                                                        <div class="label">
                                                            Investment Required
                                                        </div>
                                                        <div class="value">
<!--                                                ${{$helper->nice_number($d->totalinvestmentrequired)}}-->
                                                {{$d->symbol.$helper->nice_number($d->totalinvestmentrequired)}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="el-tablo estimated-time profile-tile highlight">
                                                        <div class="profile-tile-meta">
                                                            <ul>
                                                                {{-- <li>
                                                                    <span> Round:</span>
                                                                    <strong>One </strong>
                                                                </li> --}}
                                                                @if(!empty($d->investmentstage) && isset($d->investmentstage))
                                                                <li>
                                                                    <span>Stage:</span>
                                                                    <strong>{{$d->investmentstage}} </strong>
                                                                </li>
                                                                @endif
                                                                 @if(!empty($d->investmentstructure) && isset($d->investmentstructure))
                                                                <li>
                                                                    <span>Structure:</span>
                                                                    <strong>{{$d->investmentstructure}} </strong>
                                                                </li>
                                                                @endif
                                                                @if(!empty($d->purposeofinvestment) && isset($d->purposeofinvestment))
                                                                 <li>
                                                                    <span>Purpose of Requested Investment:</span>
                                                                    <strong>{{$d->purposeofinvestment}} </strong>
                                                                </li>
                                                                @endif
                                                                @if(!empty($d->projectname) && isset($d->projectname))
                                                                 <li>
                                                                    <span>Project Name:</span>
                                                                    <strong>{{$d->projectname}} </strong>
                                                                </li>
                                                                @endif
                                                                @if(!empty($d->updated) && isset($d->updated))
                                                                <li>
                                                                    <span>Date of Created:</span>
                                                                    <strong>{{date('M d,Y',strtotime($d->updated)) }} </strong>
                                                                </li>
                                                                @endif
<!--                                                                <li>
                                                                    <span>Country:</span>
                                                                    <strong>{{$d->country}} </strong>
                                                                </li>-->
                                                                @if(!empty($d->totalviews) && isset($d->totalviews)) 
                                                                <li>
                                                                    <span>Total Views:</span>
                                                                    <strong>{{$d->totalviews}}</strong>
                                                                </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="my-profile-foldr clearfix">
                            
                            <div class="project-users">
                              SDG (S)
                            </div>
                          </div>
                                    
                                    
                                    <div class="sds-cost-folder">
                            <div class="row">
                              <div class="col-md-6">
                                <ul>
                                  <li>
                                  <a class="btn btn-yellow-custom step-trigger-btn" href="/deals/edit-deal?dealid={{$d->dealid}}"  target="_blank">Edit Deal</a> 
                                  <a class="btn btn-yellow-custom step-trigger-btn" href="/deals/view-deal?dealid={{$d->dealid}}"  target="_blank">View Deal</a>        
                                  </li>
                                  <li >
                                 
                                               
                                  </li>
                                </ul>
                              </div>
                              <div class="col-md-6 text-right">
                              
                                <?php $results = DB::select( DB::raw("SELECT sdg_master.sdg FROM deal_sdgs left join sdg_master on deal_sdgs.sdgid=sdg_master.sdgid WHERE dealid = '$d->dealid'") );
$sdg_cnt=0;
$sdg_cnt=count($results);
                                
                                ?>  
                                  @foreach($results as $dsdg)
                                  
                                <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button">{{$dsdg->sdg}}</button>
                               @endforeach

@if($sdg_cnt==0)
No SDG (S) found.
@endif
                                                               </div>
                            </div>
                          </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                </div>
                            </div>
                            @endforeach
                            {{-- <div class="project-box">
                                <div class="project-head">
                                    <div class="project-title kinaracpital">
                                        <h5>
                                            Kinara Capital
                                        </h5>
                                        <div class="label">
                                            Financial Services
                                        </div>
                                    </div>
                                </div>
                                <div class="project-info">
                                    <div class="row align-items-center">
                                        <div class="col-sm-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="el-tablo highlight">
                                                        <div class="label">
                                                            Investment Required
                                                        </div>
                                                        <div class="value">
                                                            $12m
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="el-tablo estimated-time profile-tile highlight">
                                                        <div class="profile-tile-meta">
                                                            <ul>
                                                                <li>
                                                                    <span> Round:</span>
                                                                    <strong>One </strong>
                                                                </li>
                                                                <li>
                                                                    <span>Start:</span>
                                                                    <strong>Early Growth </strong>
                                                                </li>
                                                                <li>
                                                                    <span>Date of Created:</span>
                                                                    <strong>July 30, 2012 </strong>
                                                                </li>
                                                                <li>
                                                                    <span>Country:</span>
                                                                    <strong>United Kindom </strong>
                                                                </li>
                                                                <li>
                                                                    <span>Total Views:</span>
                                                                    <strong>115</strong>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-6 mr-rit-auto">
                                            <div class="text-right">
                                                <div class="project-users sdg">
                                                    SDG (S)
                                                </div>
                                                <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Peace, Justice & Strong Institutions</button>
                                                <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Affordable & Clean Energy</button>
                                                <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Climate Action</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row interbtn">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-buttons-w text-left my-portfolio-btm">
                                                <a class="btn step-trigger-btn gray-btn" href="#"> Due Diligence Underway</a>
                                                <a class="btn step-trigger-btn gray-btn" href="#"> Due Diligence History</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-buttons-w text-right my-portfolio-btm">
                                                <a class="btn btn-primary step-trigger-btn" href="#"> Connect</a>
                                                <a class="btn btn-yellow-custom step-trigger-btn" href="#"> Show Interest </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="project-box mar-one-rem">
                                <div class="project-head">
                                    <div class="project-title kinaracpital">
                                        <h5>
                                            Kinara Capital
                                        </h5>
                                        <div class="label">
                                            Financial Services
                                        </div>
                                    </div>
                                </div>
                                <div class="project-info">
                                    <div class="row align-items-center">
                                        <div class="col-sm-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="el-tablo highlight">
                                                        <div class="label">
                                                            Investment Required
                                                        </div>
                                                        <div class="value">
                                                            $12m
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="el-tablo estimated-time profile-tile highlight">
                                                        <div class="profile-tile-meta">
                                                            <ul>
                                                                <li>
                                                                    <span> Round:</span>
                                                                    <strong>One </strong>
                                                                </li>
                                                                <li>
                                                                    <span>Start:</span>
                                                                    <strong>Early Growth </strong>
                                                                </li>
                                                                <li>
                                                                    <span>Date of Created:</span>
                                                                    <strong>July 30, 2012 </strong>
                                                                </li>
                                                                <li>
                                                                    <span>Country:</span>
                                                                    <strong>United Kindom </strong>
                                                                </li>
                                                                <li>
                                                                    <span>Total Views:</span>
                                                                    <strong>115</strong>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-6 mr-rit-auto">
                                            <div class="text-right">
                                                <div class="project-users sdg">
                                                    SDG (S)
                                                </div>
                                                <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Peace, Justice & Strong Institutions</button>
                                                <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Affordable & Clean Energy</button>
                                                <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Climate Action</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row interbtn">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-buttons-w text-left my-portfolio-btm">
                                                <a class="btn step-trigger-btn gray-btn" href="#"> Due Diligence Underway</a>
                                                <a class="btn step-trigger-btn gray-btn" href="#"> Due Diligence History</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-buttons-w text-right my-portfolio-btm">
                                                <a class="btn btn-primary step-trigger-btn" href="#"> Connect</a>
                                                <a class="btn btn-yellow-custom step-trigger-btn" href="#"> Show Interest </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}



                            <!--START - next pagers-->
                            {{ $data->links('pagination') }}
                            {{-- 
                                <div class="controls-below-table controls-pagination-cnt row">

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="table-records-info">
                                        Showing records 1 - 5
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="table-records-pages align-rit">
                                        <ul>
                                            <li>
                                                <a href="#">Previous</a>
                                            </li>
                                            <li>
                                                <a class="current" href="#">1</a>
                                            </li>
                                            <li>
                                                <a href="#">2</a>
                                            </li>
                                            <li>
                                                <a href="#">3</a>
                                            </li>
                                            <li>
                                                <a href="#">4</a>
                                            </li>
                                            <li>
                                                <a href="#">Next</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> 
                            --}}
                            <!--END - next pagers-->