
<?php
$helper=\App\Helpers\AppHelper::instance();
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
  $CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
?>
<input type="hidden" id="completed_language_text" value="{{trans('duediligenceprocess.questionstatus_completed')}}"/>

          @foreach($data as $data)

   <div class="support-ticket" onclick="fnQuestionClicked('{{$data->questionid}}');" 
            id='{{$data->questionid}}'>
                              <div class="row profile-proces-top-sec">
                                <div class="col-lg-4 col-md-12">
                                  <div class="pipeline-settings os-dropdown-trigger qu-list">
                                    <i class="os-icon os-icon-hamburger-menu-1" style="visibility:hidden;"></i>
                                    {{-- <div class="os-dropdown">
                                      <div class="icon-w">
                                        <i class="os-icon os-icon-ui-46"></i>
                                      </div>
                                      <ul>
                                        <li>
                                          <a href="#">
                                            <i class="os-icon os-icon-ui-49"></i>
                                            <span>Edit</span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#">
                                            <i class="os-icon os-icon-grid-10"></i>
                                            <span>Assign</span>
                                          </a>
                                        </li>
                                        <li>
                                          <a class="danger" href="#">
                                            <i class="os-icon os-icon-ui-15"></i>
                                            <span>Delete</span>
                                          </a>
                                        </li>
                                      </ul>
                                    </div> --}}
                                  </div>
                                </div>
                                <div class="col-lg-7 col-md-12">
                                  <div class="st-meta">
                                    <?php   
                                        $statusclass='';
                                        $statustext='';
                                    switch ($data->questionstatus) {
                                      case 'Pending':
                                        $statusclass="badge badge-danger-inverted";
                                        $statustext=trans('duediligenceprocess.questionstatus_pending');
                                        break;
                                      case 'Completed':
                                        $statusclass="badge badge-success-inverted";
                                          $statustext=trans('duediligenceprocess.questionstatus_completed');
                                        break;
                                      case 'Active':
                                        $statusclass="badge badge-danger-inverted";
                                          $statustext=trans('duediligenceprocess.questionstatus_active');
                                        break;
                                    case 'In-Active':
                                        $statusclass="badge badge-danger-inverted";
                                          $statustext=trans('duediligenceprocess.questionstatus_inactive');
                                        break;
                                      default:
                                        $statusclass="badge badge-danger-inverted";
                                        break;
                                    } ?>
                                    <div class="{{$statusclass}}" id="qstatus_{{$data->questionid}}">
                                         {{$statustext}}
                                    </div>
                                    {{-- <i class="os-icon os-icon-ui-09"></i> --}}
                                    <div class="pipeline-settings os-dropdown-trigger qu-list">
                                      <i class="os-icon os-icon-ui-46"></i>
                                      @if($is_parent[0]->Is_Parent=='Yes')
                                      <div class="os-dropdown">
                                        <div class="icon-w">
                                          <i class="os-icon os-icon-ui-46"></i>
                                        </div>
                                          
                                        <ul>
                                            
                                            <li>
                                                <a href="#" data-target="#edit_question_modal" data-toggle="modal" onclick="seteditid('{{$data->questionid}}');">
                                                  <i class="os-icon os-icon-ui-49" ></i>
                                                  <span >Edit</span>

                                                </a>
                                              </li>
                                              <li>
                                                <a href="#" data-target="#assign_users_modal" data-toggle="modal" onclick="setassignuser('{{$data->questionid}}');">
                                                  <i class="os-icon os-icon-grid-10"></i>
                                                  <span>Assign</span>
                                                </a>
                                              </li>
                                              <li>
                                                <a class="danger" href="#" data-target="#question_delete_modal" data-toggle="modal" onclick="deletequestionid('{{$data->questionid}}');">
                                                  <i class="os-icon os-icon-ui-15"></i>
                                                  <span>Delete</span>
                                                </a>
                                              </li>
<li>
@if($data->questionstatus=="Pending")
    <a class="danger" href="#" onclick="makependingcompleted('{{$data->questionid}}','Completed');">
<i class="os-icon os-icon-grid-10"></i>
        <span>Mark Completed</span>
    </a>
    @endif
@if($data->questionstatus=="Completed")
<a class="danger" href="#" onclick="makependingcompleted('{{$data->questionid}}','Pending');">
<i class="os-icon os-icon-grid-10"></i>
    <span>Mark Pending</span>
</a>
@endif
</li>
                                              
                                        </ul>
                                          
                                      </div>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="st-body">

                                <div class="ticket-content">
                                  <h6 class="ticket-title">
                                   {{$data->questiontext}}
                                  </h6>

                                </div>
                              </div>
                              <div class="st-foot">
                                <span class="label"> {{trans('duediligenceprocess.lebel_agent')}}:</span>
                                @if(isset($data->user->userid))
                                <a class="value with-avatar" href="/user/profile/view?user={{$data->user->userid}}">
       
                                     @if($data->user->profileimage==null)
                                       {{-- <img alt="" src="img/avatar1.jpg"> --}}
                                       <img alt="" src="{{ Avatar::create($data->user->firstname .' ' . $data->user->lastname)->toBase64() }}">  
                                     @else
                                       <img alt="" src="{{$UserProfileImagePath . $data->user->profileimage}}">

                                     @endif
                                   <span>{{ $data->user->firstname .' ' . $data->user->lastname }}</span>
                          
                                
                                </a>
                                @else
                                <span class="value">Not assigned</span>
                                @endif
                                <span class="label">{{trans('duediligenceprocess.lebel_updated')}}:</span>
                                <span class="value">
                                  {{$helper->dateconv($data->updated)}}
                                </span>

                                          
                                        
                              </div>
                            </div>

          @endforeach         

                                        
 <!--  <div class="load-more-tickets" id="loadMore">
                               <a href="#">
                                <span>Load More Tasks...</span>
                              </a>
                              </div> -->



                          




                            
                               

                           

