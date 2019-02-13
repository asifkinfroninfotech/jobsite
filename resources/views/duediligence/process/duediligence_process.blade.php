
{{-- @extends('layouts.app_layout', ['layout' => 'left_side_menu_compact']) --}}
@php
$helper=\App\Helpers\AppHelper::instance();
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
  $UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
  $CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
 ?>


     <div class="content-w portfolio-custom-vk due-dili-process">

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

      <div aria-labelledby="myLargeModalLabel" id="module_edit_modal" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                  {{trans('duediligenceprocess.modulelist_modal_title')}}
              </h5>
              <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
            </div>

            <div class="modal-body" id="lstmodule">
            
            </div>

            <div class="modal-footer">
              <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
              <button class="btn btn-primary" type="button" onclick="fnSaveAllModules();" id="btnMessageSave"> {{trans('duediligenceprocess.modulelist_modal_btnsave_caption')}}</button>
            </div>
            <div class="alert alert-success" role="alert" id="messagebox" style="display:none;">
              <strong>Well done! </strong>Modeles are successfully updated.
            </div>
          </div>
        </div>
      </div>


      <div aria-labelledby="myLargeModalLabel" id="add_question_modal" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                    {{trans('duediligenceprocess.modal_addquestion_title')}}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
              </div>
  
              <div class="modal-body">
                <div class="form-group">
                <label for="">{{trans('duediligenceprocess.modal_addquestion_labelfor_text')}}</label>
              <textarea id="question-new" rows="3" class="form-control"></textarea>
                </div>

              </div>
  
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                <button class="btn btn-primary" type="button" onclick="fncreateQuestion();" id="btnMessageSave"> {{trans('duediligenceprocess.modulelist_modal_btnsave_caption')}}</button>

              </div>
              <div class="alert alert-danger form-group" role="alert" id="errorbox-add-q" style="display:none;margin-top:10px;">
                  {{trans('duediligenceprocess.modal_onblank_question_text_error')}}
              </div>

            </div>
          </div>
        </div>
      
      
      
      <div aria-labelledby="myLargeModalLabel" id="edit_question_modal" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                    {{trans('duediligenceprocess.modal_editquestion_title')}}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
              </div>
  
              <div class="modal-body">
                <div class="form-group">
                <label for="">{{trans('duediligenceprocess.modal_editquestion_labelfor_text')}}</label>
              <textarea id="question-edit" rows="3" class="form-control"></textarea>
                </div>
                  <input type="hidden" id="editid" value="" />

              </div>
  
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                <button class="btn btn-primary" type="button" onclick="fneditQuestionsave();" id="btnMessageedit"> {{trans('duediligenceprocess.modulelist_modal_btnsave_caption')}}</button>

              </div>
              <div class="alert alert-danger form-group" role="alert" id="errorbox-add-q" style="display:none;margin-top:10px;">
                  {{trans('duediligenceprocess.modal_onblank_question_text_error')}}
              </div>

            </div>
          </div>
        </div>
      
      
      
      
      <div aria-labelledby="myLargeModalLabel" id="assign_users_modal" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                    {{trans('duediligenceprocess.modal_assign_title')}}
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
                               {{trans('duediligenceprocess.modal_table_name_title')}}
                            </th>
                            <th>
                              {{trans('duediligenceprocess.modal_table_assign_title')}}
                            </th> 
                            </tr>
                        </thead>
                        <tbody id="ajaxassignusers">
                            
                         </tbody>
                        
                        
                      </table>

                    </div>
                  </div>
                
                
                <input type='hidden' id='editquesid' value='' />
                
                </div>
                  

              </div>
  
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                <!--<button class="btn btn-primary" type="button" onclick="fnassignuserssave();" id="btnassign" disabled=""> assign</button>-->
              </div>
              <div class="alert alert-danger form-group" role="alert" id="errorbox-add-q" style="display:none;margin-top:10px;">
                  {{trans('duediligenceprocess.modal_onblank_question_text_error')}}
              </div>

            </div>
          </div>
        </div>
      
      
      
      
      
      

        <div aria-labelledby="myLargeModalLabel" id="edit-previous-reply-modal" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">
                      {{trans('duediligenceprocess.modal_editreply_title')}}
                  </h5>
                  <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                </div>
    
                <div class="modal-body">
                  <div class="form-group">

                  <label for="">{{trans('duediligenceprocess.modal_editreply_modifyreply_labeltext')}}</label>
                  <textarea id="previous-reply-opentoedit" rows="5" class="form-control"></textarea>
                  {{-- <div class="ae-content">
                        <div class="aec-reply">
                          <textarea cols="80" id="ckeditorEmail" name="ckeditor1" rows="5"></textarea>
                        </div>
                      </div> --}}


                  </div>
  
                </div>
    
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-dismiss="modal" type="button" id="preply_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                  <button class="btn btn-primary" type="button" id="btnPreviousReplySave" onclick="fnSavePreviousReply();"> {{trans('duediligenceprocess.modulelist_modal_btnsave_caption')}}</button>
  
                </div>
                <div class="alert alert-danger form-group" role="alert" id="errorbox-previous-reply" style="display:none;margin-top:10px;">
                    {{trans('duediligenceprocess.modal_editreply_blank_error')}}
                </div>
  
              </div>
            </div>
          </div>


          <div aria-labelledby="exampleModalLabel" class="modal fade" id="previous_reply_delete_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                      {{trans('duediligenceprocess.delete_confirmation_modal_title')}}
                  </h5>
                  <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="form-group">
                        <h6>
                            {{trans('duediligenceprocess.delete_confirmation_answer_text')}}
                          </h6>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-dismiss="modal" type="button" id="previousreply_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                  <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedPreviousReply();" id="btnprevious_del_yes">{{trans('duediligenceprocess.btn_caption_yes')}}</button>
                </div>
              </div>
            </div>
          </div>
      
      
      
      
           <div aria-labelledby="exampleModalLabel" class="modal fade" id="question_delete_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                      {{trans('duediligenceprocess.delete_confirmation_modal_title')}}
                  </h5>
                  <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="form-group">
                        <h6>
                            {{trans('duediligenceprocess.delete_confirmation_question_text')}}
                          </h6>
                        </div>
                      </div>
                    </div>
                      <input type="hidden" id="deleteid" value="" />
                  </form>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-dismiss="modal" type="button" id="previousreply_close">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                  <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedQuestion();" id="btnprevious_del_yes">{{trans('duediligenceprocess.btn_caption_yes')}}</button>
                </div>
              </div>
            </div>
          </div>

        <div class="content-i">
          <div class="content-box">
            <!--
              start - Due Diligence Process
              -->
            <div class="row">
              <div class="col-sm-12">
                <!--START - Control panel above projects-->
        <div class="content-i control-panel">
          <div class="content-box-tb">
              @if((session('helpview')!=null))
              <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                     <h5 class="form-header">
                            {!!trans('duediligenceprocess.help_title')!!}   
                         </h5>
                         <div class="form-desc">
                            {!!$helper->GetHelpModifiedText(trans('duediligenceprocess.help_content'))!!} 
                         </div>
                         <div class="element-box-content example-content">
                                 <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('duediligenceprocess.help_btn_hide_caption')}}</button>
                         </div>
                </div>
              </div>
             @endif
            <div class="os-tabs-w">
              <div class="os-tabs-controls">
                <ul class="nav nav-tabs upper">
                  <li class="nav-item">
                  <a aria-expanded="false" class="nav-link"  href="/due-diligence-dashboard?pd={{$pipelinedealid}}"> {{trans('duediligenceprocess.lebel_duediligencedashboard')}}</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link active"  href="/due-diligence-process?pd={{$pipelinedealid}}">{{trans('duediligenceprocess.lebel_duediligenceprocess')}}</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link"  href="/messaging?pd={{$pipelinedealid}}"> {{trans('duediligenceprocess.lebel_messaging')}}</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" href="/pipelinedeal-docs?pd={{$pipelinedealid}}"> {{trans('duediligenceprocess.lebel_documents')}}</a>
                </li>
                </ul>
                <h5 class="process-top-rit">
                  <!-- Kinara Capital -->
                  @if($companydata!=null)
                     {{$companydata->name}}
                  @endif
                </h5>
              </div>
            </div>
          </div>
        </div>        
        <!--END - Control panel above projects-->

                
                <div class="element-wrapper">
                  <div class="element-header process-hdcuts">
                    <h6>
                      {{trans('duediligenceprocess.lebel_duediligenceprocess')}}
                    </h6>
                    <div class="text-right">
                        {{-- <a class="btn btn-sm btn-link btn-upper mr-4 d-none d-lg-inline-block" href="#">
                          <i class="os-icon os-icon-ui-44"></i>
                          <span>{{trans('duediligenceprocess.link_text_download')}} CSV</span>
                        </a> --}}
                        <a class="btn btn-sm btn-primary btn-upper" href="/printpdf?pd={{$_GET['pd']}}">
                          <span>{{trans('duediligenceprocess.btn_caption_printall')}}</span>
                        </a>
                      </div>
                  </div>  

                  <!--START - Projects list-->
                  <div class="content-w">
                    <div class="content-i">
                      <div class="content-box-pad-reduse">
                        <div class="support-index due-process-left">
                          <div class="support-tickets">
                            <div class="support-tickets-header">
                              <div class="tickets-control">

                                <div class="element-search">
                    <input placeholder='{{trans('duediligenceprocess.textbox_placeholder_search')}}' type="text" id="txtSearch">
                                </div>
                              </div>
                              
                              <div class="tickets-filter">
                                <div class="form-group mr-3">
                                  <label class="d-none d-md-inline-block mr-2">{{trans('duediligenceprocess.lebel_modules')}}</label>
                                  <select class="form-control-sm" id="module_combo" onchange="getQuestions()" style="width:60%;">

                                   
                                   @foreach($modules as $value)
                                    <option value="{{$value->moduleid}}">
                                      {{$value->modulename}}
                                    </option>
                                   @endforeach

                                  </select>
                                   <i class="os-icon os-icon-edit-1" id="btnModuleEdit" style="cursor:pointer;float: left;padding: 7px;"></i>
                                </div>
                                <div class="form-check stick-right due-add-qust">
                                  @if($is_parent[0]->Is_Parent=='Yes')                            
                                <button class="btn btn-link" type="button" data-target="#add_question_modal" data-toggle="modal">{{trans('duediligenceprocess.modal_btnaddquestion_caption')}}</button>
                              
                                @endif
                                </div>
                              </div>
                            </div>

                           
                            <div id="questions">
                              
                            </div>


                          </div>
                          <div class="ae-content">
                           
                          <div class="support-ticket-content-w marbtm">
                            <div class="support-ticket-content">
                               
                               <div id="previous-reply">
                             
                              </div>

                              </div>
                          </div>


                            <div class="aec-reply" id="current_reply_area">
                              <div class="reply-header">
                                <h5>
                                  <span>{{trans('duediligenceprocess.lebel_yourreply')}}</span>
                                </h5>
                              </div>
                              <textarea cols="80" id="ckeditorEmail" name="ckeditor1" rows="5"></textarea>
                              <div class="buttons-w">
                                <div class="actions-left">
  <!--                                 <a class="btn btn-link" href="#">
                                    <i class="os-icon os-icon-ui-51"></i>
                                    <span>Add Attachment</span>
                                  </a> -->
                                 <i class="os-icon os-icon-ui-51 btn btn-link"></i>
                            <input class="btn btn-link" type="file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" name="file" id="file" data-multiple-caption="{count} files selected" multiple="multiple" value="Add Attachment"/>
                                    
     


                                </div>
                                <div class="actions-right">
<!--                                   <a class="btn btn-success" href="#">
                                    <span>Submit</span>
                                  </a> -->

                                  <button type="button" id="replysendbtn" onclick="fncSendMessage()" class="btn btn-success">{{trans('duediligenceprocess.button_caption_submit')}}</button>

                                </div>

                              </div>
                            </div>
                            <div class="alert alert-success" role="alert" id="div_donotreplymessage" style="display:none;">
                                The question has been already completed.
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
                          <span>Dark </span>
                          <span>Colors</span>
                        </div>
                        <!--------------------
                        END - Color Scheme Toggler
                        -------------------->
                        <!--------------------
                        START - Chat Popup Box
                        -------------------->
                        <div class="floated-chat-btn">
                          <i class="os-icon os-icon-mail-07"></i>
                          <span>Demo Chat</span>
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
                                <a href="#">
                                  <span class="extra-tooltip">Attach Document</span>
                                  <i class="os-icon os-icon-documents-07"></i>
                                </a>
                                <a href="#">
                                  <span class="extra-tooltip">Insert Photo</span>
                                  <i class="os-icon os-icon-others-29"></i>
                                </a>
                                <a href="#">
                                  <span class="extra-tooltip">Upload Video</span>
                                  <i class="os-icon os-icon-ui-51"></i>
                                </a>
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
                  <!--END - Projects list-->
                </div>
              </div>
            </div>
            <!--------------------
              END - Due Diligence Process
              -------------------->

          </div>
        </div>
      </div>
    <input type="hidden" id="pipelinedealid" value='{{$pipelinedealid}}'/>
        @endsection

@section('scripts')

<input type="hidden" id="tokenvalue" value='{{ csrf_field() }}'/>
<input type="hidden" id="questionid" value=""/>
<input type="hidden" id="hiddenanswerid" value=''/>
<input type="hidden" id="hiddenansweridtodelete" value=''/>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->


<script type="text/javascript">

/*var $ = jQuery;
jQuery(document).ready(function($){*/
  $(document).ready(function(){ 
    // jQuery(document).find("td:not([data-editable='false'])").on('click keypress dblclick', showEditor);
       var selectedModule = $("#module_combo option:selected").val();
       if(selectedModule= typeof selectedModule !='undefined')
       {
         getQuestions();
       }

        $("#btnModuleEdit").click(function()
        {
            var pipelinedealid=$('#pipelinedealid').val();
            var route='/getmodulestoedit'+'?pipelinedealid='+pipelinedealid+'&page=1';
          $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
                $("#lstmodule").html('');
                $("#lstmodule").html(data);

                $('#module_edit_modal').modal('show');
                $('#editableTable').editableTableWidget();
                $('#tbl_new').editableTableWidget();
               
                // $('#editableTable td.uneditable').on('click keypress dblclick', function(evt, newValue) {
                //   var ele = $(this).find('input');
                //   if (ele.prop('checked')==true){ 
                //     ele.prop('checked', true); // Checks it
                //   }
                //   else
                //   {
                //     ele.prop('checked', false); // Checks it
                //   }
                //   return true;
                // });

        $('#chk_select_all').click(function(e)
         {
   
    var v=this.checked;
    $('#editableTable tr').each(function() {
       
        var id=$(this).attr('id');
        $('#chk_'+id).prop('checked',v);
     });
        }
        );
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });

         
        });

});

$(document).on('click','.pagination a',function(e){
e.preventDefault();
var page=$(this).attr('href').split('page=')[1];
fnGotoPageModules(page);
});


function fnGotoPageModules(page)
{
  var pipelinedealid=$('#pipelinedealid').val();

var route='/getmodulestoedit'+'?pipelinedealid='+pipelinedealid+'&page='+page;

          $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
                $("#lstmodule").html('');
                $("#lstmodule").html(data);
                $('#editableTable').editableTableWidget();
                $('#tbl_new').editableTableWidget();
                // $('#editableTable td.uneditable').on('click keypress dblclick', function(evt, newValue) {
	              //   var ele = $(this).find('input');
                //   if (ele.prop('checked')==true){ 
                //     ele.prop('checked', true); // Checks it
                //   }
                //   else
                //   {
                //     ele.prop('checked', false); // Checks it
                //   }
                //   return false;
                // });

        $('#chk_select_all').click(function(e)
         {
          var v=this.checked;
          $('#editableTable tr').each(function() {
       
         var id=$(this).attr('id');
         $('#chk_'+id).prop('checked',v);
        });
        }
        );
                
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
}

          function getQuestions()
          {
            var selectedModule = $("#module_combo option:selected").val();
            var pipelinedealid=$('#pipelinedealid').val();
            ajaxLoad('/ajax-getquestions?moduleid='+selectedModule+'&pipelinedealid='+pipelinedealid,'questions');
          }



    function ajaxLoad(filename, content) {
        content = typeof content !== 'undefined' ? content : 'questions';
        $.ajax({
            type: "GET",
            url: filename,
            contentType: false,
            success: function (data) {
              debugger;
                $("#" + content).html('');
                $("#" + content).html(data);

            if(content=='questions')
            {
                $('#previous-reply').html('');
              
              $('.support-ticket').each(function(i,elem) 
              {
               $(elem).addClass('active');
               var id=$(elem).attr('id');
               fnQuestionClicked(id);
                return false;
              });

            }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    function fnQuestionClicked(id)
    {
      var pipelinedealid=$('#pipelinedealid').val();
      $('.support-ticket').removeClass('active');
      $('#'+id).addClass('active');
      $('#questionid').val(id);
      ajaxLoad('/ajax-getanswers?questionid='+id+'&pipelinedealid='+pipelinedealid,'previous-reply'); 
      $.get('/ajax-getsubmitreply?questionid='+id,function(data){
      //  if(data=="enable")
      //  {
      //      $('#current_reply_area').show();
      //      $('#div_donotreplymessage').hide();
      //  }
      //  if(data=="disable")
      //  {
      //   $('#current_reply_area').hide();
      //   $('#div_donotreplymessage').show();
      //  }
if(data=="Pending")
{
$('#current_reply_area').show();
$('#div_donotreplymessage').hide();
}
if(data=="Completed")
{
$('#current_reply_area').hide();
$('#div_donotreplymessage').show();
}
      });
    }

    function fncSendMessage()
    {
      debugger;
      for(var instanceName in CKEDITOR.instances){
           CKEDITOR.instances[instanceName].updateElement();
        }
     var message=$('#ckeditorEmail').val();
     var questionid=$('#questionid').val();
     var pipelinedealid=$('#pipelinedealid').val();
        message=$.trim(message);

        if( message =='')
        {
            
            return;
        }
       /* var CSRF_TOKEN=$('#tokenvalue').val();*/
        var formdata = new FormData();
    
        formdata.append("message",message);
        formdata.append("questionid",questionid);
        formdata.append("pipelinedealid",pipelinedealid);

        var totalfiles = document.getElementById("file").files;

        for (var x = 0; x < totalfiles.length; x++) {
            formdata.append("file" + x, totalfiles[x]);
        }

        var myurl = '/ajax-new-answer';
        $.ajaxSetup({

  headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

  }

});

            formdata.append("_token",'{{csrf_token()}}');

        $.ajax({
            url: myurl,
            type: "POST",
            //contentType: 'application/json; charset=utf-8',
            contentType: false,
            processData: false,
            data: formdata,
/*            data: {
                    message: message,
                    questionid: questionid,
                    files: formdata,
           _token: '{{csrf_token()}}'
                },*/
            cache: false,
            timeout: 100000,//15000, // adjust the limit. currently its 15 seconds
            success: function (data) {
              debugger;
                if (data.Success) {

                     fnQuestionClicked(questionid);
  for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement();
    }
    CKEDITOR.instances[instance].setData('');

                // $('#qstatus_'+questionid).removeClass("badge badge-danger-inverted");
                // $('#qstatus_'+questionid).addClass("badge badge-success-inverted");
                // $('#qstatus_'+questionid).html($('#completed_language_text').val());

                }
                else {
                    
                    //location.reload();
                }
            },
            error: function (err, result) {
              debugger;
                alert("Error" + err.responseText);
            }
        });
    }


      function fnSearchQuestions(searchval)
      {
      var searchtext=searchval;//$('#txtSearch').val();
      var moduleid=$("#module_combo option:selected").val();
        $.ajaxSetup({

  headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

  }

});
      var formdata = new FormData();
    
        formdata.append("searchtext",searchtext);
        formdata.append("moduleid",moduleid);
        formdata.append("_token",'{{csrf_token()}}');

       $.ajax({
            url: '/question-search',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
                $("#questions").html('');
                $("#questions").html(data);


              //Making all reply blank & then loading.....
              $('#previous-reply').html('');
              $('.support-ticket').each(function(i,elem) {
               $(elem).addClass('active');
               var id=$(elem).attr('id');
               fnQuestionClicked(id);
                return false;
             });
              
            },
            error: function (err, result) {
              debugger;
                alert("Error" + err.responseText);
            }
        });




    }

  var timer;
  $("#txtSearch").keyup(function() {
    clearTimeout(timer);
    var ms = 3000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
      debugger;
      fnSearchQuestions(val);
    }, ms);
  });


  function fnSaveAllModules()
  {
    var modulelist = [];
    var id;
    var mname;
    var mstatus;
    var disorder;
    $('#editableTable tr').each(function() {
       debugger;
      
       id=$(this).attr('id');
       if (typeof id != "undefined") 
       {
         mname=$('#mname_'+id).html();
         mstatus=$('#mstatus_'+id+' option:selected').val();
         disorder=$('#mdisplayorder_'+id).html();
        modulelist.push({ moduleid: id, name: mname, modulestatus: mstatus, displayorder: disorder });
       }
    
    });

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var formdata = new FormData();
    
    formdata.append("modulelist",JSON.stringify(modulelist));
    formdata.append("_token",'{{csrf_token()}}');

   $.ajax({
        url: '/update-modules',
        type: "POST",
        contentType: false,
        processData: false,
        data: formdata,
        cache: false,
        timeout: 100000,
        success: function (data) {
          
                    var $messageDiv = $('#messagebox'); // get the reference of the div
                    $messageDiv.show(); // show and set the message.html(data.Message)
                    setTimeout(function () { $messageDiv.hide(); }, 3000); // 3 seconds later, hide
                    fnGotoPageModules(1);
        },
        error: function (err, result) {
          debugger;
            alert("Error" + err.responseText);
        }
    });




  }

  function fnAddNewModule()
  {
    var pipelinedealid=$('#pipelinedealid').val();
    var id=0;
    var mname=$('#new-m').html();
    var mstatus=$('#mstatus_0 option:selected').val();;
    var disorder=$('#new-displayorder').html();

    if($.trim(mname)=='')
    {
      var $messageDiv = $('#errorbox-new-module'); // get the reference of the div
      $messageDiv.show(); // show and set the message.html(data.Message)
      setTimeout(function () { $messageDiv.hide(); }, 3000); // 3 seconds later, hide
      return;
    }

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var formdata = new FormData();
    formdata.append("pipelinedealid",pipelinedealid);
    formdata.append("name",mname);
    formdata.append("status",mstatus);
    formdata.append("displayorder",disorder);
    formdata.append("_token",'{{csrf_token()}}');

   $.ajax({
        url: '/create-new-module',
        type: "POST",
        contentType: false,
        processData: false,
        data: formdata,
        cache: false,
        timeout: 100000,
        success: function (data) {
         
                    // var $messageDiv = $('#messagebox'); 
                    // $messageDiv.show().html('Module created successfully.'); 
                    // setTimeout(function () { $messageDiv.hide(); }, 3000); 
                    fnGotoPageModules(1);
        },
        error: function (err, result) {
          debugger;
            alert("Error" + err.responseText);
        }
    });
  }

  function fnDeleteSelectedModules()
  {
    var id;
    var ids='';
 
    $('#editableTable tr').each(function() 
    {
       id=$(this).attr('id');
       if (typeof id != "undefined") 
       {
        if($('#chk_'+id).is(':checked')==true)
        {
          if(ids=='')
          {
            ids=$.trim(id);
          }
          else{
            ids=ids+','+$.trim(id);
          }

        }

        
       }
    
    });

    if(ids.length<=0)
    {
      
      var $messageDiv = $('#errorbox-delete'); // get the reference of the div
      $messageDiv.show(); // show and set the message.html(data.Message)
      setTimeout(function () { $messageDiv.hide(); }, 3000); // 3 seconds later, hide
      return;
    } 

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var formdata = new FormData();
    formdata.append("ids",ids);
    formdata.append("_token",'{{csrf_token()}}');

   $.ajax({
        url: '/delete-modules',
        type: "POST",
        contentType: false,
        processData: false,
        data: formdata,
        cache: false,
        timeout: 100000,
        success: function (data) {
          
          // var $messageDiv = $('#messagebox'); // get the reference of the div
          // $messageDiv.show().html('Selected modules deleted successfully.'); // show and set the message.html(data.Message)
          // setTimeout(function () { $messageDiv.hide(); }, 10000); // 3 seconds later, hide
          fnGotoPageModules(1);
        },
        error: function (err, result) {
          debugger;
            alert("Error" + err.responseText);
        }
    });

  }

 //Add a new question to the selected Module......
  function fncreateQuestion()
  {
      var pipelinedealid=$('#pipelinedealid').val();
      var questionText=$('#question-new').val();
      if($.trim(questionText)=='')
      {
        var $messageDiv = $('#errorbox-add-q'); // get the reference of the div
        $messageDiv.show(); // show and set the message.html(data.Message)
        setTimeout(function () { $messageDiv.hide(); }, 3000); // 3 seconds later, hide
        return;
      }

      var selectedModule = $("#module_combo option:selected").val();
      $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var formdata = new FormData();
    formdata.append("pipelinedealid",pipelinedealid);
    formdata.append("moduleid",selectedModule);
    formdata.append("questiontext",questionText);
    formdata.append("_token",'{{csrf_token()}}');

   $.ajax({
        url: '/add-new-question',
        type: "POST",
        contentType: false,
        processData: false,
        data: formdata,
        cache: false,
        timeout: 100000,
        success: function (data) {
          
          $('#add_question_modal').modal('hide');
          $('#question-new').val('');
          getQuestions();
        },
        error: function (err, result) {
          debugger;
            alert("Error" + err.responseText);
        }
    });


  }

   function fnShowModalToEditPreviousReply(answerid)
   {
    debugger;
    var replytext=$('#ticket-reply-content_'+answerid).html();
    replytext=$.trim(replytext);
    $('#previous-reply-opentoedit').val(replytext);
    $('#hiddenanswerid').val(answerid);
    $('#edit-previous-reply-modal').modal('show');

   }

   function fnSavePreviousReply()
   {
     var editedreplytext=$('#previous-reply-opentoedit').val();
     editedreplytext='<p>'+editedreplytext+'</p>';
     if($.trim(editedreplytext)=='')
     {
       var $messageDiv = $('#errorbox-previous-reply'); // get the reference of the div
        $messageDiv.show(); // show and set the message.html(data.Message)
        setTimeout(function () { $messageDiv.hide(); }, 3000); // 3 seconds later, hide
        return;
     }
     var answerid=$('#hiddenanswerid').val();

     $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var formdata = new FormData();
    formdata.append("editedreplytext",editedreplytext);
    formdata.append("answerid",answerid);
    formdata.append("_token",'{{csrf_token()}}');

   $.ajax({
        url: '/update-previous-reply',
        type: "POST",
        contentType: false,
        processData: false,
        data: formdata,
        cache: false,
        timeout: 100000,
        success: function (data) {
          $('#edit-previous-reply-modal').modal('hide');
          $('#previous-reply-opentoedit').val('');
          var selectedquestionid= $('#questionid').val();
          fnQuestionClicked(selectedquestionid);
        },
        error: function (err, result) {
          debugger;
            alert("Error" + err.responseText);
        }
    });



   }

    //THis function will set the anserid asked to delete.
    function fnSetAnswerIdToDelete(answerid)
    {
      $('#hiddenansweridtodelete').val(answerid);
      $('#previous_reply_delete_modal').modal('show');
    }

    function fnDeleteSelectedPreviousReply()
    {
      var answeridtodel=$('#hiddenansweridtodelete').val();

       $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var formdata = new FormData();
    formdata.append("answerid",answeridtodel);
    formdata.append("_token",'{{csrf_token()}}');

   $.ajax({
        url: '/delete-previous-reply',
        type: "POST",
        contentType: false,
        processData: false,
        data: formdata,
        cache: false,
        timeout: 100000,
        success: function (data) {
          $('#previous_reply_delete_modal').modal('hide');
          var selectedquestionid= $('#questionid').val();
          fnQuestionClicked(selectedquestionid);
        },
        error: function (err, result) {
          debugger;
            alert("Error" + err.responseText);
        }
    });

    }

     //asif-code
     //for capturing the edit id
     function seteditid(id)
     {
         $('#editid').val(id);
         
         $.get('/editquestion?id='+id,function(data){
            $('#question-edit').val(data.question);
         });
     }
     function deletequestionid(deleteid)
     {
         $('#deleteid').val(deleteid);
     }
     
    function fneditQuestionsave()
    {
         
        var editedquestion=$('#question-edit').val();
        var editid=$('#editid').val();
          $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var formdata = new FormData();
    formdata.append("editedquestion",editedquestion);
    formdata.append("editid",editid);
    formdata.append("_token",'{{csrf_token()}}');

   $.ajax({
        url: '/saveeditedquestion',
        type: "POST",
        contentType: false,
        processData: false,
        data: formdata,
        cache: false,
        timeout: 100000,
        success: function (data) {
            //alert(data);
         $('#edit_question_modal').modal('hide');
         getQuestions();
        
        },
        error: function (err, result) {
          debugger;
            alert("Error" + err.responseText);
        }
    });
        
    }
    
    function fnDeleteSelectedQuestion()
     {
         var deleteid=$('#deleteid').val();
         if(deleteid!=null)
         {
             $.get('/deleteselectedquestion?delid='+deleteid,function(data){
             $('#question_delete_modal').modal('hide');
             getQuestions();
             });
         }
     }

    function setassignuser(quesid)
    {
        $('#editquesid').val(quesid);
        var pd=$('#pipelinedealid').val();
        $.get('/assignedusers?pd='+pd,function(data){
           $('#ajaxassignusers').html(data); 
        });
    }


//var a = [];
//function assigncount()
//{
//    
//   $(".selectuser:checked").each(function() {
//        a.push(this.value);
//    });
//    //alert(a.length);
//    
//    if(a.length > 0)
//    {
//     $('#btnassign').prop("disabled", false);    
//    }
//     if(a.length == 0)
//    {
//     $('#btnassign').prop("disabled", true);    
//    }
//  
//    
//}

function fnassignuserssave(userid)
{
    var a1=userid;
    var questionid=$('#editquesid').val();
     $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var pd=$('#pipelinedealid').val();
    var formdata = new FormData();
    formdata.append("users",a1);
    formdata.append("questionid",questionid);
    formdata.append("pipelinedealid",pd);
    formdata.append("_token",'{{csrf_token()}}');

   $.ajax({
        url: '/saveassignusers',
        type: "POST",
        contentType: false,
        processData: false,
        data: formdata,
        cache: false,
        timeout: 100000,
        success: function (data) {
            //alert(data);
         $('#assign_users_modal').modal('hide');
         getQuestions();
        
        },
        error: function (err, result) {
          debugger;
            alert("Error" + err.responseText);
        }
    });
    
    
}


function makependingcompleted(id,status)
{
$.get('/ajax-update-questionstatus?questionid='+id+'&qstatus='+status,function(data){

   if(data=="Success")
   {
      getQuestions();
   }

});
}








        </script>

          @endsection