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


      
        <!--Code for the modal box   -->        
                
                
                   <div aria-labelledby="exampleModalLabel" class="modal fade" id="new_tender_process" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">
                        New Tender Form
                        </h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                      </div>
                        <form id="newtender" method="post" action="/savenewtender" enctype="multipart/form-data">
                       {{csrf_field()}}
                            <div class="modal-body">
                        
                          <div class="row">
                              <div class="col-sm-12">
                              <div class="form-group ">
                                  <label for="">
                                  Tender Name*
                                  </label>
                                  <input class="form-control" placeholder="Enter Tender Name" data-error="Tender name is required." required="required" type="text" name="tender_name" id="tender_name">
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                          </div>
                            
                          <div class="row">
                              <div class="col-sm-6">
                              <div class="form-group">
                                  <label for="">
                                  Start Date*
                                  </label>
                                  <input class="form-control " placeholder="Start Date" data-error="Start Date is Required." required="required" type="date" name="start_date" id="start_date">
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                              
                            <div class="col-sm-6">
                              <div class="form-group">
                                  <label for="">
                                  End Date*
                                  </label>
                                  <input class="form-control" placeholder="End Date" data-error="End Date is required" required="required" type="date" name="end_date" id="end_date" onblur="checkend();">
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>  
                              
                          </div>  
                            <div class="row">
                                <div class="col-sm-12">
                            <div class="form-group">
                              <label> 
                                Description
                              </label>
                              <textarea name="description" id="description" class="form-control" name="outcomes" rows="3"></textarea>
                            </div>
                                    </div>
                                </div>
                            
                            <div class="row">
                             <div class="col-sm-6">   
                             <div class="form-group">
                               <label for="">
                                    Private/Public*
                               </label>
                                   <select name="pri_pub_compbo" id="pri_pub_compbo" class="form-control" placeholder="Private/Public" data-error="Private/Public is required." required="required">
                                    <option value="">Select</option>
                                    <option value="Private">Private</option>
                                    <option value="Public">Public</option>
                                                                                                                  
                                                                                                            </select>
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                              </div>  
                                
                        </div>
                          
                          
                          <div class="row">
                              <div class="col-sm-12">   
                             <div class="form-group">
                               <label for="">
                                    Select Deals
                               </label>
                                </div>
                               <div class="form-group">     
                               <select  multiple name="deallist[]" id="deallist" class="form-control select2" >
                               @foreach($deallist as $list) 
                               <option value="{{$list->dealid}}">{{$list->name."-".$list->projectname}}</option>
                               
                               @endforeach
                               </select>
                               </div>    
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                               
                              </div>  
                              
                          </div>
                          
                          
                   
                          <div class="row">
                               <div class='col-sm-6'>
                                   <div class='form-group'>
                              <label for="">
                                    Document 1
                               </label>
                                       </div>
                                    </div>
                               <div class='col-sm-6'>
                                   <div class='form-group'>
                              <label for="">
                                    Document 2
                               </label>
                                       </div>
                                    </div>
                          </div>        
                          
                          <div class='row'>  
                           <div class='col-sm-6'>
                        <div class='form-group'>
                             <input  type="file" id='import_file' name="import_file" />
                        </div>    
                    </div>
                              <div class='col-sm-6'>
                        <div class='form-group'>
                             <input  type="file" id='import_file1' name="import_file1" />
                        </div>    
                    </div>
                  
                </div> 
                          
                          
                          
                            
                            
                        
                   
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button" id="tenants_close" onclick="">Cancel</button>
                        <button class="btn btn-primary" type="submit" id="savetenats" >Save</button>
                      </div>
                      <div class="alert alert-danger" style="display:none;">Data Saved Successfully</div>
                       </form> 
                    </div>
                  </div>
                </div>      


        
        <!-- Assigning the third party -->
        
        <div aria-labelledby="myLargeModalLabel" id="assign_thirdparty_modal" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                    Assign Party
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
              </div>
  
              <div class="modal-body">
                <div class="form-group">
<!--                <label for="">{{trans('duediligenceprocess.modal_editquestion_labelfor_text')}}</label>-->
           
                
                <div class="element-box-tp">
                    <div class="table-responsive">
                      <table class="table table-padded" id="myTable">
                        <thead>
                          <tr>
                            <th>
                              Name
                            </th>
                            <th>
                              Assign
                            </th> 
                            </tr>
                        </thead>
                        <tbody id="ajaxassignthirdparty">
                            
                         </tbody>
                        
                        
                      </table>

                    </div>
                  </div>
                
                
                <input type='hidden' id='editquesid' value='' />
                
                </div>
                  

              </div>
  
              <div class="modal-footer">
                <button class="btn btn-primary" type="button" onclick="assignthirdparty();" id="btnassign" disabled> Assign</button>  
                <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                <!--<button class="btn btn-primary" type="button" onclick="fnassignuserssave();" id="btnassign" disabled=""> assign</button>-->
              </div>
              <div class="alert alert-danger form-group" role="alert" id="errorbox-add-q" style="display:none;margin-top:10px;">
                  {{trans('duediligenceprocess.modal_onblank_question_text_error')}}
              </div>

            </div>
          </div>
        </div>
        
        
        
        <!-- -->

        <!-- -->

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
                      <a aria-expanded="false" class="nav-link"  href="/open/tenders">{{trans('tenders.lebel_open_tenders')}}</a>
                    </li>
                    <li class="nav-item">
                      <a aria-expanded="false" class="nav-link active" href="/closed/tenders">{{trans('tenders.lebel_closed_tenders')}}</a>
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
                    {{trans('tenders.tender_menu')}}
                  </h6>
                    
                 
                
                <!--<div class="element-box">
               
                      
                      <div class="element-box-content example-content">
                             <button class="btn btn-primary" data-toggle="modal" data-target="#new_tender_process">Start Tender</button>
                      </div>
                </div>-->
          
                    
               
                <div class="projects-list projects-list-vk" id="tenderlist" style="display:block;">
                       @foreach($tenderlists as $tenderlist)
                    <div class="project-box marbtm" >
                     <div class="project-head">
                        <div class="project-title kinaracpital">
                          <h5>
                            
                           {{ $tenderlist->title}}
                          </h5>
                          <div class="label">
                              
                          </div>
                        </div>
                       <div class="project-users">
                             
                               @foreach($involved_companies as $f)
                               <div class="avatar">
                              @if( (isset($f->profileimage) && !empty($f->profileimage) ) && File::exists(public_path('storage/company/profileimage/'.$f->profileimage)))
                              
                              <img alt="" src="storage/company/profileimage/{{$f->profileimage}}" >
                              @else
                              <img alt="" src="{{ Avatar::create(strtoupper($f->companyname)) }}" > 
                             @endif
                             </div>
                               @endforeach
                            
                          </div>
                      </div>
                        
                     <div class="project-info">
                        <div class="row align-items-center">
                          <div class="col-sm-9">
                            <div class="row">
                              <div class="col-sm-3">
                                <div class="el-tablo highlight">
                                  <div class="label">
                                  Tender Amount
                                  </div>
                                  <div class="value" >
                                    £1000k
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-5">
                                <div class="el-tablo estimated-time profile-tile highlight">
                                  <div class="profile-tile-meta">
                                    <ul>
                                        @if(isset($tenderlist->dealid) && !empty($tenderlist->dealid))
                                        <li>
                                            <span> Project:</span>
                                            <a href="/deals/view-deal?dealid={{$tenderlist->dealid}}" target="_blank" ><strong>{{$tenderlist->projectname}}</strong></a>
                                          </li>
                                         @endif
                                         @if(isset($tenderlist->investmentstage) && !empty($tenderlist->investmentstage))
                                      <li>
                                        <span> STAGE:</span>
                                        <strong>{{$tenderlist->investmentstage}}</strong>
                                      </li>
                                        @endif
                                        
                                        
<!--                                      <li>
                                          
                                        <span>DATE CREATED:</span> 
                                        <strong></strong>
                                      </li>-->
                                      
<!--                                      <li>
                                      <span> COUNTRY:</span> 
                                        <strong>India </strong>
                                      </li>-->
                                     @if(isset($tenderlist->totalviews) && !empty($tenderlist->totalviews))
                                      <li>
                                      <span> TOTAL VIEWS:</span> 
                                        <strong>{{$tenderlist->totalviews}}</strong>
                                      </li>
                                      @endif
                                    </ul>
                                  </div>
                                </div>
                              </div>
                                
                                
                                
                              <div class="col-sm-4">
                                <div class="el-tablo estimated-time profile-tile highlight">
                                  <div class="profile-tile-meta">
                                    <ul>
                                      
                                                                            <li>
                                        <span>START:</span>
                                        <strong>{{date("M d, Y", strtotime($tenderlist->startdate))}} </strong>
                                      </li>
                                      
                                       <li>
                                        <span>END:</span>
                                        <strong>{{date("M d, Y", strtotime($tenderlist->enddate))}} </strong>
                                      </li>
                                      
                                                              <li> 
                                                               <span>User Type :</span>   
                                                                  
                                                       
                               <strong> {{$tenderlist->type}}</strong>
                               
                                                    </li>  
                                                                                                                </ul>
                                   
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                            
                            
<!--                                                    <div class="col-sm-3 offset-sm--1">
                            <div class="os-progress-bar primary">
                              <div class="bar-labels">
                                <div class="bar-label-left">
                                  <span>Due Diligence Progress</span>
                                  <span class="positive">+0</span>
                                </div>
                                <div class="bar-label-right">
                                  <span class="info">1/342</span>
                                </div>
                              </div>
                              <div class="bar-level-1" style="width: 100%">
                                <div class="bar-level-2" style="width: 0%">
                                  <div class="bar-level-3" style="width: 0%"></div>
                                </div>
                              </div>
                            </div>
                          </div>-->
                        </div>
                         
                         <div class="my-profile-foldr clearfix">
                            <div class="label">
                              Uploaded Documents
                         
                                <i class="os-icon os-icon-edit-1"></i>
                                <span></span>
                              
                              

                            </div>
                             
                             <br/>
                             <strong><a href="/storage/tender/new/{{$tenderlist->file1}}" >{{$tenderlist->file1}}</a></strong>,
                             <strong><a href="/storage/tender/new/{{$tenderlist->file2}}" >{{$tenderlist->file2}}</a></strong>
                             
                             
                           
                          </div>
                         
                        <div class="my-profile-foldr clearfix">
                         
                          <div class="project-users">
                         <button class="btn btn-primary" type="button" onclick="opentender('{{$tenderlist->tenderid}}','{{$tenderlist->dealid}}');" >View</button>
<!--                         <button class="btn btn-primary" type="button" onclick="closetender('{{$tenderlist->tenderid}}');" >Close</button>-->
                         
                          </div>
                        </div>
                        
                       
                      </div>   
                    
                    </div>
                       @endforeach

                  </div>
                
                
                
                
                   <div class="projects-list projects-list-vk"  id="tenderview" style="display:none;">
                       <div class="project-box marbtm">
                    
                        <div class="modal-header">
                        <h5 class="modal-title">
                        Edit/View Tender Form
                        </h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                      </div>
                     <form id="edittenderform" method="post" action="/edittender" enctype="multipart/form-data">
                         {{csrf_field()}}
                         <div class="modal-body" id="tenderedit">  
                           
                         </div>    
                      <div class="modal-footer">
                        <button class="btn btn-secondary"  type="button" id="tenants_close" onclick="cancel();">Cancel</button>
                        <button class="btn btn-primary" type="button" onclick="tenderedit();" id="edittenderbtn"  style="display:block;">Edit</button>
                        <button class="btn btn-primary" type="submit" id="saveedittenderbtn" style="display:none;">Save</button>
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#assign_thirdparty_modal" id="thirdpartyselect" onclick="thirdpartylisting();"  style="display:none;">Invite</button>
                        
                        
                      </div>
                      <div class="alert alert-danger" style="display:none;">Data Saved Successfully</div>
                      <input type="hidden" id="hiddentenderid" name="tenderidhidden" value=""/>
                       </form>   
                           
                       </div>
                  </div>
                
                
                <div class="element-box" id="proposallist" style="display: none;">

                  
                </div>
                
                
                
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

         







          <!--
            END - Sidebar
            -->
        </div>
      </div>

      
      <input type="hidden", id="selectedcompanyid" value=''/>
      <input type="hidden", id="selectedtype" value=''/>
      <input type="hidden" id="hiddentenderid1"  value="">
      <input type="hidden" id="hiddendealid"  value="">
      

        @endsection


        @section('scripts')
        <script type="text/javascript">
        


    
    function checkend()
         {
            var startdate=$('#start_date').val();
            var enddate=$('#end_date').val();
            
            if(new Date(enddate) <= new Date(startdate))
            {
                $('#end_date').val('');
                alert('start date must be less than end date');
            }
         }
 
  //for new tender saving
//  $("#newtender").submit(function(event){
//
//         $.ajaxSetup({
//         headers: {
//        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//         });
//        var tendername=$('#tender_name').val();
//        var start_date=$('#start_date').val();
//        var end_date=$('#end_date').val();
//        var description=$('#description').val();
//        var combo=$('#pri_pub_compbo').val();
//        
////        var deallist=$('#deallist').val();
//        var deallist=$('input[name="deallist[]"]').get()
//        var importFiles = $('#import_file').prop('files')[0];
//         
//         
//         var formData = new FormData();
//         formData.append("_token",'{{csrf_token()}}'); 
//         formData.append("tendername",tendername);
//         formData.append("start_date",start_date);
//         formData.append("end_date",end_date);
//         formData.append("description",description);
//         formData.append("combo",combo);
//        
//         formData.append('deallist',deallist);
//         formData.append('files',importFiles);
//         
//         
//         $('#savetenats').prop( "disabled", true );
//         
//          $.ajax({ 
//            url: '/savenewtender',
//            type: "POST",
//            contentType: false,
//            processData: false,
//            data: formData,
//            cache: false,
//            timeout: 100000,
//           success: function (data) {
////              if(data==1)
////              {
////            $('.alert-danger').css('display','block');
////            $('#savetenats').prop( "disabled", false); 
////            $('#tender_name').val('');
////            $('#start_date').val('');
////            $('#end_date').val('');
////            $('#description').val('');
////            $('#pri_pub_compbo').val('');
////            setTimeout(function() {
////            $('.alert-danger').fadeOut('fast');
////            }, 3000);
////            location.reload();
////          }
//             alert(data);
//           
//            },
//            error: function (message) {
//            $('#savetenats').prop( "disabled", false); 
//            $('#tender_name').val('');
//            $('#start_date').val('');
//            $('#end_date').val('');
//            $('#description').val('');
//            $('#pri_pub_compbo').val('');
//            },
//        
//        });
//        
//        
//          event.preventDefault();
//    
//          });
   //      
     
     
  //for edit tender   
     
//    $("#edittenderform").submit(function(event){
//
//         $.ajaxSetup({
//         headers: {
//        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//         });
//        var tendereditid=$('#hiddentenderid').val(); 
//        var tendername=$('#tender_name_edit').val();
//        var start_date=$('#start_date_edit').val();
//        var end_date=$('#end_date_edit').val();
//        var description=$('#description_edit').val();
//        var combo=$('#pri_pub_compbo_edit').val();
////        var pipelinedealid=$('#pipelinedealid').val();
////        var deals=$('#')
//         
//         
//         var formData = new FormData();
//         formData.append("_token",'{{csrf_token()}}');
//         
//         formData.append("tendername",tendername);
//         formData.append("start_date",start_date);
//         formData.append("end_date",end_date);
//         formData.append("description",description);
//         formData.append("combo",combo);
//         formData.append("pipelinedealid",pipelinedealid);
//         formData.append("hiddentenderid",tendereditid);
//         
//         
//         
//         
//          $.ajax({ 
//            url: '/edittender',
//            type: "POST",
//            contentType: false,
//            processData: false,
//            data: formData,
//            cache: false,
//            timeout: 100000,
//           success: function (data) {
//           $('.alert-danger').css('display','block');
//            $("#tender_name_edit").prop("disabled",true);
//           $("#start_date_edit").prop("disabled",true);
//           $("#end_date_edit").prop("disabled",true);
//           $("#description_edit").prop("disabled",true);
//           $("#pri_pub_compbo_edit").prop("disabled",true);
//            $("#edittenderbtn").show();
//            $("#saveedittenderbtn").hide();
//           
//            setTimeout(function() {
//        $('.alert-danger').fadeOut('fast');
//        }, 3000);
//          
//             
//           
//            },
//            error: function (message) {
//            
//            },
//        
//        });
//        
//        
//          event.preventDefault();
//    
//          }); 
  //
       function opentender(tender,dealid)
       {
          $("#hiddentenderid").val(tender);
          $("#hiddentenderid1").val(tender);
          $("#hiddendealid").val(dealid);
           $.get('/gettenderview?tenderid='+tender,function(data){
              
              
              
              
              $('#tenderlist').hide();
              $('#tenderview').show();
              $('#proposallist').show();
              $('#tenderedit').html(data.view1);
              $('#proposallist').html(data.view2);
              
              var tendertype=$('#tendertype').val();
              if(tendertype=="Private")
              {
                  $('#thirdpartyselect').show();
              }
              else
              {
                  $('#thirdpartyselect').hide(); 
              }
              
              
           });
       }
       
       function closetender(tender)
       {
           alert(tender);
          $.get('/closetender?tender='+tender,function(data){
             location.reload();
          }); 
       }
       
       function tenderedit()
       {
           $("#tender_name_edit").prop("disabled",false);
           $("#start_date_edit").prop("disabled",false);
           $("#end_date_edit").prop("disabled",false);
           $("#description_edit").prop("disabled",false);
           $("#pri_pub_compbo_edit").prop("disabled",false);
           $("#deallistview").prop("disabled",false);
           $("#deallistview").select2();
           $("#edittenderbtn").hide();
           $("#saveedittenderbtn").show();
       }
       
     function cancel()
     {
          $("#tender_name_edit").prop("disabled",true);
           $("#start_date_edit").prop("disabled",true);
           $("#end_date_edit").prop("disabled",true);
           $("#description_edit").prop("disabled",true);
           $("#pri_pub_compbo_edit").prop("disabled",true);
           
           $("#edittenderbtn").show();
           $("#saveedittenderbtn").hide();
           
           location.reload();
     }
       
       function thirdpartylisting()
       {
        $('#btnassign').prop('disabled', false);   
       // var pipelinedealid=$('#pipelinedealid').val();   
        $.get('/fetchthirdpartyusers',function(data){
            $('#ajaxassignthirdparty').html('');
            $('#ajaxassignthirdparty').html(data);
        })
           
           
           
       }
       
       var putcheckboxid;
       
       function assigncount()
       {
       putcheckboxid = [];    
       $.each($(".selectuser:checked"), function() {
                    putcheckboxid.push($(this).val());
                });
      if(putcheckboxid.length > 0)
      {
       $('#btnassign').prop('disabled', false);
      }
      else
      {
       $('#btnassign').prop('disabled', true);   
      }
      alert(putcheckboxid);
      }
      
      function assignthirdparty()
      {
          putcheckboxid = []; 
          unchecked=[];
          $.each($(".selectuser:checked"), function() {
          putcheckboxid.push($(this).val());
          });
           $.each($(".selectuser:not(:checked)"), function() {
          unchecked.push($(this).val());
          });
         
          if(putcheckboxid.length > 0)
          {
//              var pipelinedealid=$('#pipelinedealid').val();  
              var tenderid=$('#hiddentenderid').val();
              var dealid=$('#hiddendealid').val();
              var putcheckboxid=JSON.stringify(putcheckboxid);
              var unchecked=JSON.stringify(unchecked);
              $('#btnassign').prop('disabled', true);
              $.get('/sendthirdparty?checkboxarr='+putcheckboxid+'&uncheckedarr='+unchecked+'&tenderid='+tenderid+'&dealid='+dealid,function(data){
                 //alert(data); 
                 $('#assign_thirdparty_modal').modal('toggle');
                 $('#proposallist').html(data);
              });
              
          }
      }
      
      
      function uploadproposaldocs(proposalid)
      {
         // alert(proposalid);
         debugger;
          alert('saveproposaldocs'+proposalid);
        //var importFiles = $('#import_file').prop('files')[0];  
          
        $("#saveproposaldocs"+proposalid).submit(function(event){

         $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
         });

         var importFiles = $('#import_proposal'+proposalid).prop('files')[0];
         var tenderid=$("#hiddentenderid1").val();
         var formData = new FormData();
         formData.append("_token",'{{csrf_token()}}'); 
         formData.append("proposalid",proposalid);
         formData.append("tenderid",tenderid);
         
          formData.append('uploadFiles', importFiles);
         $.ajax({ 
            url: '/saveproposaldocs',
            type: "POST",
            contentType: false,
            processData: false,
            data: formData,
            cache: false,
            timeout: 100000,
           success: function (data) {

             $('#proposallist').html(data);
           
            },
            error: function (message) {
           
            },
        
        });
        
        
          event.preventDefault();
    
          });
      }
      
      
      
      setTimeout(function(){ $('.select2-search__field').css('width','25.75em')}, 1000);
      
      
      
       
        
        </script>

        @endsection