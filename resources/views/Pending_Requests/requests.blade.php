@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')

<div class="content-w portfolio-custom-vk">
   <!--
     START - Secondary Top Menu
     -->
   @include('shared._top_menu')

   <div aria-labelledby="exampleModalLabel" class="modal fade" id="Accept_Confirmation_Modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">
                  Grant Access Request
              </h5>
              <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="row">
                    <div class="col-sm-12">
                    <div class="form-group">
                        This will allow access to the requested company. Do you want to continue?
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-dismiss="modal" type="button" id="previousreply_close">Cancel</button>
              <button class="btn btn-primary" type="button" onclick="fnAcceptRequest();" id="btnAllowAccess">Yes</button>
            </div>
          </div>
        </div>
      </div>


      <div aria-labelledby="exampleModalLabel" class="modal fade" id="remove_company_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                      Decline Access Request
                  </h5>
                  <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="form-group">
                            This action will decline the request to access. Do you want to continue?
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


          <div aria-labelledby="exampleModalLabel" class="modal fade" id="Accept_InvitationToJoinDD_Modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">
                          Accept Invitation
                      </h5>
                      <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="form-group">
                                This action will make you associate of the invited due diligence. Do you want to continue?
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary" data-dismiss="modal" type="button" id="btn_close">Cancel</button>
                      <button class="btn btn-primary" type="button" onclick="fnAcceptInvite();" id="btnAcceptInvite">Yes</button>
                    </div>
                  </div>
                </div>
              </div>


              <div aria-labelledby="exampleModalLabel" class="modal fade" id="Delete_FriendRequest_Modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">
                          Delete Friend Request
                      </h5>
                      <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="form-group">
                                This action will delete the friend request. Do you want to continue?
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary" data-dismiss="modal" type="button" id="btn_close">Cancel</button>
                      <button class="btn btn-primary" type="button" onclick="deleterequest();" id="btnDelFriendRequest">Yes</button>
                    </div>
                  </div>
                </div>
              </div>


              <div aria-labelledby="exampleModalLabel" class="modal fade" id="Reject_InvitationToJoinDD_Modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">
                          Reject Invitation
                      </h5>
                      <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="form-group">
                                This action will reject the due diligence invitation. Do you want to continue?
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary" data-dismiss="modal" type="button" id="btn_close_reject">Cancel</button>
                      <button class="btn btn-primary" type="button" onclick="fnRejectInvite();" id="btnRejectInvite">Yes</button>
                    </div>
                  </div>
                </div>
              </div>


              <div aria-labelledby="exampleModalLabel" class="modal fade" id="Delete_NewTeamMemberRequest_Modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">
                          Delete Team Member Request
                      </h5>
                      <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="form-group">
                                This action will delete the team member request. Do you want to continue?
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                      <button class="btn btn-primary" type="button" onclick="delete_team_member_request();">Yes</button>
                    </div>
                  </div>
                </div>
              </div>




   <div class="content-panel-toggler">
       <i class="os-icon os-icon-grid-squares-22"></i>
       <span>Sidebar</span>
   </div>

   <div class="content-i">
       <div class="content-box">

          @if((session('helpview')!=null))
          <div class="element-wrapper" id='helpform'>
    <div class="element-box">
                    <h5 class="form-header">
                           {!!trans('pending_requests.help_title')!!}   
                        </h5>
                        <div class="form-desc">
                           {!!trans('pending_requests.help_content')!!}
                        </div>
                        <div class="element-box-content example-content">
                                <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('pending_requests.help_btn_hide_caption')}}</button>
                        </div>
    </div>
</div>
@endif

           <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">
                        Friend Requests
                    </h6>

                    <div class="controls-above-table filter-row-top">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-inline justify-content-sm-end">
                                    <input class="form-control form-control-sm rounded bright" placeholder="Search" type="text" id="txtFriendSearch">
                                    <select class="form-control form-control-sm rounded bright" id="friend_sortbyfield" onchange="fngetFriendRequests();">
                                        <option selected="selected" value="">
                                            Sort By
                                        </option>
                                        <option value="firstname">
                                            Name
                                        </option>
                                        <option value="username">
                                            User Name
                                        </option>
                                        <option value="name">
                                            Company
                                        </option>
                                    </select>

                                </form>
                            </div>
                        </div>
                    </div>

                        <!--START - Friend Requests list-->
                        <div class="projects-list projects-list-vk" id="divFriendRequests">


                        </div>
                        <!--END - Friend Requests list-->

                </div>
            </div>
        </div>

        @if($Is_AdminUser=="Yes")
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">
                        Due Diligence Invites And Access Requests
                    </h6>

                    <div class="controls-above-table filter-row-top">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-inline justify-content-sm-end">
                                    <input class="form-control form-control-sm rounded bright" placeholder="Search" type="text" id="txtDDSearch">
                                    <select class="form-control form-control-sm rounded bright" id="DD_sortbyfield" onchange="fngetDueDiligenceRequestsAndInvites();" style="display:none;">
                                        <option selected="selected" value="">
                                            Sort By
                                        </option>
                                        <option value="name">
                                            Name
                                        </option>
                                        <option value="username">
                                            User Name
                                        </option>
                                    </select>

                                </form>
                            </div>
                        </div>
                    </div>

                        <!--START - Friend Requests list-->
                        <div class="projects-list projects-list-vk" id="divDueDiligenceInvitesAndRequests">


                        </div>
                        <!--END - Friend Requests list-->

                </div>
            </div>
        </div>
        @endif

        @if($Is_AdminUser=="Yes")
        <div class="row">
          <div class="col-sm-12">
              <div class="element-wrapper">
                  <h6 class="element-header">
                      New Team Member Requests
                  </h6>

                  <div class="controls-above-table filter-row-top">
                      <div class="row">
                          <div class="col-sm-12">
                              <form class="form-inline justify-content-sm-end">
                                  <input class="form-control form-control-sm rounded bright" placeholder="Search" type="text" id="txtTeamMember">
                                  <select class="form-control form-control-sm rounded bright" id="TeamMember_sortbyfield" onchange="fngetDueDiligenceRequestsAndInvites();" style="display:none;">
                                      <option selected="selected" value="">
                                          Sort By
                                      </option>
                                      <option value="name">
                                          Name
                                      </option>
                                      <option value="username">
                                          User Name
                                      </option>
                                  </select>

                              </form>
                          </div>
                      </div>
                  </div>

                      <!--START - New Team Member Requests list-->
                      <div class="projects-list projects-list-vk" id="divNewTeamMemberRequests">


                      </div>
                      <!--END - New Team Member Requests list-->

              </div>
          </div>
      </div>
      @endif



       </div>
        
       <!-- Start Side Bar From Here-->
   </div>
</div>

<input type="hidden" id="pipelinedealid" value=""/>
<input type="hidden" id="type" value=""/>
<input type="hidden" id="companyid" value=""/>
<input type="hidden" id="deleteme" value="">
<input type="hidden" id="is_admin" value="{{$Is_AdminUser}}">

      @endsection


    @section('scripts')

      <script type="text/javascript">
        $(document).ready(function(){ 
            fngetFriendRequests();
            var isadmin=$('#is_admin').val();
            if(isadmin=="Yes")
            {
            fngetDueDiligenceRequestsAndInvites();
            fngetNewTeamMemberRequests();
            }
        });

        function fngetFriendRequests()
        {
            ajaxLoad('/get-friend-requests','divFriendRequests','Friend');
        }

        function fngetDueDiligenceRequestsAndInvites()
        {
            ajaxLoad('/get-dd-requests-invites','divDueDiligenceInvitesAndRequests','DD');
        }

        function fngetNewTeamMemberRequests()
        {
          ajaxLoad('/get-team-member-requests','divNewTeamMemberRequests','TeamMember');
        }

        function ajaxLoad(route, divname,type) {
        debugger;
        var searchtext="";
        var sortby="";

        switch (type) {
          case 'Friend':
          searchtext=$('#txtFriendSearch').val();
          sortby=$("#friend_sortbyfield option:selected").val();
            break;
          case 'DD':
            searchtext=$('#txtDDSearch').val();
            sortby=$("#DD_sortbyfield option:selected").val();
            break;
            case 'TeamMember':
            searchtext=$('#txtTeamMember').val();
            sortby=$("#TeamMember_sortbyfield option:selected").val();
            break;
        }

      
        route=route+'?searchtext='+searchtext+'&sortby='+sortby;
  
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              debugger;
  
                $("#" + divname).html('');
                $("#" + divname).html(data);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

          var timer;
  $("#txtFriendSearch").keyup(function() {
    clearTimeout(timer);
    var ms = 2000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
      debugger;
        fngetFriendRequests();
      }, ms);
  });


  $("#txtDDSearch").keyup(function() {
    clearTimeout(timer);
    var ms = 2000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
      debugger;
      fngetDueDiligenceRequestsAndInvites();
    }, ms);
  });

    $("#txtTeamMember").keyup(function() {
    clearTimeout(timer);
    var ms = 2000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
      debugger;
      fngetNewTeamMemberRequests();
    }, ms);
  });


   function OpenPopUpAndSetIds(pipelinedealid,type,companyid)
   {
        $('#pipelinedealid').val(pipelinedealid);
        $('#type').val(type);
        $('#companyid').val(companyid);

        $('#Accept_Confirmation_Modal').modal('show');
   }

   function OpenDeclinePopup(pipelinedealid,type,companyid)
   {
        $('#pipelinedealid').val(pipelinedealid);
        $('#type').val(type);
        $('#companyid').val(companyid);

        $('#remove_company_modal').modal('show');
   }

   function OpenAcceptInvitePopup(pipelinedealid,type,companyid)
   {
        $('#pipelinedealid').val(pipelinedealid);
        $('#type').val(type);
        $('#companyid').val(companyid);

        $('#Accept_InvitationToJoinDD_Modal').modal('show');
   }
        //Process Related Functions.......
        function fnAcceptRequest()
        {
          debugger;
          var type=$('#type').val();
          var pipelinedealid= $('#pipelinedealid').val();
          var companyid=$('#companyid').val();

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
                  $('#Accept_Confirmation_Modal').modal('hide');
                  fngetDueDiligenceRequestsAndInvites();
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



        function fnRemoveCompany()
        {
          debugger;
          var type=$('#type').val();
          var pipelinedealid= $('#pipelinedealid').val();
          var companyid=$('#companyid').val();

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
                  fngetDueDiligenceRequestsAndInvites();
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


        function fnAcceptInvite()
        {
         debugger;
          var type=$('#type').val();
          var pipelinedealid= $('#pipelinedealid').val();
          var companyid=$('#companyid').val();

          if(typeof companyid=='undefined' || typeof type=='undefined' || typeof pipelinedealid=='undefined')
          {
            return;
          }
          var route="/accept-invitation-tojoin-dd?companyid="+companyid+"&pipelinedealid="+pipelinedealid+"&type="+type;
          $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              
                if(data.message=='Success')
                {
                  $('#Accept_InvitationToJoinDD_Modal').modal('hide');
                  fngetDueDiligenceRequestsAndInvites();
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


        function OpenRejectInvitation_Popup(pipelinedealid,type,companyid)
        {
          $('#pipelinedealid').val(pipelinedealid);
          $('#type').val(type);
          $('#companyid').val(companyid);

          $('#Reject_InvitationToJoinDD_Modal').modal('show');
        }
        
        function fnRejectInvite()
        {
         debugger;
          var type=$('#type').val();
          var pipelinedealid= $('#pipelinedealid').val();
          var companyid=$('#companyid').val();

          if(typeof companyid=='undefined' || typeof type=='undefined' || typeof pipelinedealid=='undefined')
          {
            return;
          }
          var route="/reject-invitation-tojoin-dd?companyid="+companyid+"&pipelinedealid="+pipelinedealid+"&type="+type;
          $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              
                if(data.message=='Success')
                {
                  $('#Reject_InvitationToJoinDD_Modal').modal('hide');
                  fngetDueDiligenceRequestsAndInvites();
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



        function acceptfriend(friendid)
        {
            
        // var csrf_token = $('meta[name="csrf-token"]').attr('content');
        // var v_token = encodeURIComponent(csrf_token); 
        $.ajaxSetup({

headers: {

  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});

        // var csrf_token = $('meta[name="csrf-token"]').attr('content');
        // var v_token = encodeURIComponent(csrf_token); 
        var v_token='{{csrf_token()}}';
         $.post('friendrequest',{'friendid':friendid,'_token':v_token},function(data){
            fngetFriendRequests();
            });
            
        }

        function appendtodel(friendid)
        {
           $("#deleteme").val(friendid);
           $('#Delete_FriendRequest_Modal').modal('show');
           
        }
        function deleterequest()
        {
            debugger;
            $.ajaxSetup({

headers: {

  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});

        // var csrf_token = $('meta[name="csrf-token"]').attr('content');
        // var v_token = encodeURIComponent(csrf_token); 
        var v_token='{{csrf_token()}}';
            
            if($("#deleteme").val()!=null)
            {
            delindex=$("#deleteme").val();    
            $.post('deleterequest',{'delid':delindex,'_token':v_token},function(data){
                $('#Delete_FriendRequest_Modal').modal('hide');
                fngetFriendRequests();
            });
            
            }
    
        }


        function acceptasteammember(userid)  
        {
          $.ajaxSetup({

headers: {

  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});
        var v_token='{{csrf_token()}}';
         $.post('accept-reject-team-member-request',{'userid':userid,'mode':'Accept','_token':v_token},function(data){
           if(data.success)
            {
              fngetNewTeamMemberRequests();
            }
          
            });
        } 

        function declineteammember(userid)
        {
          $("#deleteme").val(userid);
          $('#Delete_NewTeamMemberRequest_Modal').modal('show');
        }

        function delete_team_member_request()
        {
          debugger;
          $.ajaxSetup({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
          });

        var v_token='{{csrf_token()}}';
   
            if($("#deleteme").val()!=null)
            {
            delindex=$("#deleteme").val();    
            $.post('accept-reject-team-member-request',{'userid':delindex,'mode':'Decline','_token':v_token},function(data)
            {
              if(data.success){
                $('#Delete_NewTeamMemberRequest_Modal').modal('hide');
                fngetNewTeamMemberRequests();
              }

            });
            
            }
        }


      </script>

    @endsection