 @section('content')
 @extends('tenants.layouts.app_layout', ['layout' => 'left_side_menu_tenant'])
      <div class="layout-w">

        <div class="content-w">
            
                        <!--Asif popup -->
            
              <div aria-labelledby="exampleModalLabel" class="modal fade show" id="invitedeletemodal" role="dialog" tabindex="-1" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
              Delete Confirmation
          </h5>
          <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <form class="ng-pristine ng-valid">
            <div class="row">
                <div class="col-sm-12">
                <div class="form-group">
                <h6>
                  This will delete the invited users. Do you want to continue?
                  </h6>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="alert alert-success" role="alert" id="del-message-box" style="display:none;">
          Selected documents deleted succussfully.
        </div>
        <div class="modal-footer">
          <input type="hidden" id="deleteinvitedid" value=""> 
            
          <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mdel_close">No</button>
          <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedinvited();" id="btn_del_yes">Yes</button>
        </div>
        
      </div>
    </div>
  </div>
            
          <!-- popup end--> 

            @include('tenants.shared._top_menu_tenant')

          <div class="content-i">
            <div class="content-box">
                @if((session('helpview')!=null))
                <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                          <h5 class="form-header">
                                 {!!trans('tenant_user.help_title')!!}   
                              </h5>
                              <div class="form-desc">
                                 {!!trans('tenant_user.help_content')!!}
                              </div>
                              <div class="element-box-content example-content">
                                      <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('tenant_user.help_btn_hide_caption')}}</button>
                              </div>
                 </div>
              </div>
              @endif
              <div class="element-wrapper">
                <h6 class="element-header">
               {{trans('adminview.user_title')}}
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
                                <th style="display:none;"></th>
                                <th>{{trans('adminview.user_table_name')}}</th>
                                <th>{{trans('adminview.user_table_company')}}</th>
                                <th>{{trans('adminview.user_table_position')}}</th>
                                <th>{{trans('adminview.user_table_usertype')}}</th>
                                <th>Status</th>
                                <th>{{trans('adminview.user_table_companytype')}}</th>
                                <th>{{trans('adminview.user_table_action')}}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th style="display:none;"></th>
                                <th>{{trans('adminview.user_table_name')}}</th>
                                <th>{{trans('adminview.user_table_company')}}</th>
                                <th>{{trans('adminview.user_table_position')}}</th>
                                <th>{{trans('adminview.user_table_usertype')}}</th>
                                <th>Status</th>
                                <th>{{trans('adminview.user_table_companytype')}}</th>
                                <th>{{trans('adminview.user_table_action')}}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($users as $user)
                        @if(!empty($user->name))
                        <tr>
                            <td style="display:none;">{{$user->name}}</td>
                            <td>
                                <div class="user-with-avatar  ">
                                <a href="/user/profile/view?user={{$user->userid}}"> 
                            @if( (isset($user->userprofileimage) && !empty($user->userprofileimage) ) && File::exists(public_path('/storage/user/profileimage/'.$user->userprofileimage)))
                            <img alt="" src="/storage/user/profileimage/{{$user->userprofileimage}}" />
                            
                           
                               @else
                                <img alt="" src="{{ Avatar::create(ucfirst($user->firstname).' '.ucfirst($user->lastname))->toBase64() }}" />    
                              @endif
                                </a>
                              </span><span>{{$user->firstname.' '.$user->lastname}}</span>
                              </div>
                                
                            </td>
                            
                            
                            <td>
                                <div class="user-with-avatar  ">
                                <a href="/company/profile/view?{{'company='.$user->companyid .'&companytype='.$user->companytype}}"> 
                            @if( (isset($user->profileimage) && !empty($user->profileimage) ) && File::exists(public_path('/storage/company/profileimage/'.$user->profileimage)))
                            <img alt="" src="/storage/company/profileimage/{{$user->profileimage}}" />
                            
                           
                               @else
                                <img alt="" src="{{ Avatar::create($user->name)->toBase64() }}" />    
                              @endif
                                </a>
                              </span><span>{{$user->name}}</span>
                              </div>
                                
                            </td>
                            
                            
                            <td><span>{{$user->userposition}}</span></td>
                            
                            <td>
                                @if($user->userrole==0)
                                <span>ADMIN</span>
                                @else
                                <span>NORMAL</span>
                                @endif
                            </td>

                          <td>{{$user->Status}}</td>
                            
                            <td><span>{{$user->companytype}}</span></td>
                            
                            
                           
                       <td>
                           

                       
                       
                       <div class="btn-group mr-1 mb-1 show">
                                  
                                  <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">{{trans('adminview.user_action_btn_label')}}</button>
                                <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                  <a class="dropdown-item" href="/user/profile/view?user={{$user->userid}}&calledfrom=tenant"  >{{trans('adminview.user_view_btn_label')}}</a> 
                                   @if($user->Status=="Active")
                                <a class="dropdown-item" onclick="inactive('{{$user->userid}}','{{$user->Status}}');" href="#">Make Inactive</a>
                                @elseif($user->Status=="Inactive")
                                 <a class="dropdown-item" onclick="active('{{$user->userid}}','{{$user->Status}}');" href="#">Make Active</a>
                                @elseif($user->Status=="Invited") 
                                 <a class="dropdown-item" onclick="active('{{$user->userid}}','{{$user->Status}}');" href="#">Accept Invitation</a>
                                 <a class="dropdown-item" onclick="deleteinvitedpop('{{$user->userid}}');" href="#">Delete</a>
                                @endif
                                  
<!--                                  <a class="dropdown-item" href="/gotouser?userid={{$user->userid}}"  >{{trans('adminview.user_transfer_btn_label')}}</a>-->
                                
                                </div> 
                              </div>
                       
                       
                       
                       </td>
                        </tr>
                        @endif
                        @endforeach
                        </tbody></table>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
 
 
 
 
 
 @endsection 
 
 
  @section('scripts')
    
<script>
 $(document).ready(function(){ 
  table = $('#dataTable1');
  table.DataTable().destroy();
 
 table.DataTable( {
        "order": [[ 0, "asc" ]]
    } );
 });
 
 
    function inactive($userid,$currentstats)
    {
debugger;
       postvalue($userid,'Brown','Inactive',$currentstats);
       //window.location.reload();
      
    }
    function active($userid,$currentstats)
    {
      debugger;
      //  var csrf_token = $('meta[name="csrf-token"]').attr('content');
      //  var v_token = encodeURIComponent(csrf_token);
       postvalue($userid,'green','Active',$currentstats);
       //window.location.reload();
    }
  function postvalue($userid,colour,title,$currentstatus)
  {
    debugger;
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
      });
        var v_token='{{csrf_token()}}';
     
      $.post('/teams/status',{input:$userid,title:title,currentstatus:$currentstatus,_token:v_token},function(data){
        window.location.reload();
      });
  }


    function deleteinvitedpop($userid)
  {
        $('#deleteinvitedid').val($userid);
        $('#invitedeletemodal').modal('toggle');
     
  }
  function fnDeleteSelectedinvited()
  {
      

   debugger;
    var deleteselected=$('#deleteinvitedid').val();
   
   if(deleteselected.length > 0)
   {
     
   $.get('teams/deleteinvited?deleteinvited='+deleteselected,function(data){

          
          //$('#ajaxsearch').html(data.view); 
      //alert(data);
       //console.log(data);
       $('#invitedeletemodal').modal('hide');

       window.location.reload();
          
       
      });
   
    }
   
   
  }
 
 
 

</script>
 @endsection
 
