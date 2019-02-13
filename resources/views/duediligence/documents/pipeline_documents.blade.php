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
  $user_loggedin=Session('userid');
  $UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
  $CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
 ?>

<div class="content-w portfolio-custom-vk due-dili-process">
    <!--
      START - Secondary Top Menu
      -->
     @if(isset($calledfrom) && !empty($calledfrom))
@if($calledfrom=="admin")
 @include('adminview.shared._top_menu')
 
@elseif($calledfrom=="tenant")
@include('tenants.shared._top_menu_tenant')
@endif
@else
 @include('shared._top_menu')
@endif

    <div class="content-i">
        <div class="content-box">
             @if((session('helpview')!=null))
              <div class="element-wrapper" id='helpform'>
                            <div class="element-box">
                                            <h5 class="form-header">
                                                   {!!trans('dd_documents.help_title')!!}   
                                                </h5>
                                                <div class="form-desc">
                                              {!!$helper->GetHelpModifiedText(trans('dd_documents.help_content'))!!}
                                                </div>
                                                <div class="element-box-content example-content">
                                                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('dd_documents.help_btn_hide_caption')}}</button>
                                                </div>
                            </div>
                        </div>
              @endif
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="content-i control-panel">
                        <div class="content-box-tb">
                            <div class="os-tabs-w">
                                <div class="os-tabs-controls">
                                    <ul class="nav nav-tabs upper">
                                        <li class="nav-item">
                                            <a aria-expanded="false" class="nav-link" href="/due-diligence-dashboard?pd={{$pipelinedealid}}">{{trans('duediligenceprocess.lebel_duediligencedashboard')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a aria-expanded="false" class="nav-link" href="/due-diligence-process?pd={{$pipelinedealid}}">{{trans('duediligenceprocess.lebel_duediligenceprocess')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a aria-expanded="false" class="nav-link" href="/messaging?pd={{$pipelinedealid}}"> {{trans('duediligenceprocess.lebel_messaging')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a aria-expanded="false" class="nav-link active" href="/pipelinedeal-docs?pd={{$pipelinedealid}}"> {{trans('duediligenceprocess.lebel_documents')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--END - Control panel above projects-->


                    <div class="element-wrapper">
                        <div class="element-header">
                            <h6>
                                 {{trans('duediligenceprocess.lebel_documents')}}
                            </h6>
                        </div>

                        <div class="content-w messaage-row" ng-app="myApp">
                            <div class="content-i">
                                <div class="content-box-inner">
                                    <div class="element-wrapper margin-top">
                                        <div class="element-box table-rit-section">
                                            <h5 class="form-header">
                                                {{trans('duediligenceprocess.documents_public_caption')}}
                                            </h5>
                                            <div class="form-desc">
                                                {{trans('duediligenceprocess.documents_public_text')}}
                                            </div>
                                            <div class="controls-above-table">
                                                <div class="row">
                                                    <div class="col-sm-12 col-lg-4">
                                                            @if($is_parent[0]->Is_Parent=='Yes')
                                                
                                                                <button class="btn btn-sm btn-primary" data-target="#exampleModal1" data-toggle="modal" type="button">{{trans('duediligenceprocess.public_upload_btn_label')}}</button>
                                                            @endif
                                                        
                                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal1" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            {{trans('duediligenceprocess.public_modal_title')}}
                                                                        </h5>
                                                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('pipelinedeal.document.store')}}" method="POST" enctype="multipart/form-data" class="dropzone" id="upload-files-public">
                                                                            {{ csrf_field() }}
                                                                            <input type="hidden" name="public_documents" value="public_documents" />
                                                                            <input type="hidden" name="pipelinedealid" value="{{$pipelinedealid}}" />
                                                                            <div class="dz-message">
                                                                                <div>
                                                                                    <h4>{{trans('duediligenceprocess.public_modal_drop_text')}}</h4>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-sm btn-danger" data-dismiss="modal" type="button"> Close</button><button class="btn btn-sm btn-danger" type="button">{{trans('duediligenceprocess.public_modal_upload_btn_label')}}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($is_parent[0]->Is_Parent=='Yes')
                                                        <button class="btn btn-sm btn-danger" type="button" onclick="fnDeleteDocuments('public');">{{trans('duediligenceprocess.public_delete_btn_label')}}</button>
                                                        @endif
                                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="public_document_delete_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">
                                                                            {{trans('duediligenceprocess.modal_delete_confirmation')}}
                                                                        </h5>
                                                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form>
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <h6>
                                                                                            {{trans('duediligenceprocess.modal_delete_text')}}
                                                                                        </h6>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="alert alert-success" role="alert" id="del-message-box" style="display:none;">
                                                                        {{trans('duediligenceprocess.modal_delete_success')}}
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mdel_close">{{trans('duediligenceprocess.btn_del_no')}}</button>
                                                                        <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedDocuments('public');" id="btn_del_yes">{{trans('duediligenceprocess.btn_del_yes')}}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-8 filter-moble">
                                                        <form class="form-inline justify-content-sm-end">
                                                            <input ng-model='public_search.documentname' class="form-control form-control-sm rounded bright" placeholder="{{trans('duediligenceprocess.input_search_placeholder')}}" type="text">
                                                            <select ng-model='sortByPublic' class="form-control form-control-sm rounded bright">
                                                                <option selected="selected" value="">
                                                                    {{trans('duediligenceprocess.select_sort_by')}}
                                                                </option>
                                                                <option value="documentname">{{trans('duediligenceprocess.select_file_name')}} </option>
                                                                <option value="extention">{{trans('duediligenceprocess.select_type')}}</option>
                                                                <option value="updated">{{trans('duediligenceprocess.select_date')}}</option>
                                                            </select>
                                                            <select ng-model='filterByExt' class="form-control form-control-sm rounded bright">
                                                                <option selected="selected" value="">
                                                                    {{trans('duediligenceprocess.select_filter')}}
                                                                </option>
                                                                <option value="txt">
                                                                    {{trans('duediligenceprocess.select_txt')}}
                                                                </option>
                                                                <option value="jpg">
                                                                    {{trans('duediligenceprocess.select_jpg')}}
                                                                </option>
                                                                <option value="png">
                                                                    {{trans('duediligenceprocess.select_png')}}
                                                                </option>
                                                                <option value="xls">
                                                                    {{trans('duediligenceprocess.select_xls')}}
                                                                </option>
                                                                <option value="xlsx">
                                                                    {{trans('duediligenceprocess.select_xlsx')}}
                                                                </option>
                                                                <option value="pdf">
                                                                    {{trans('duediligenceprocess.select_pdf')}}
                                                                </option>
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive table-responsive-heading-spce">
                                                <form action="" method="POST">
                                                    {{CSRF_FIELD()}}

                                                    <table class="table table-lightborder" ng-controller="pipelinedeal_document">
                                                        <input ng-model="pipelinedealid" type="hidden" value="{{$pipelinedealid}}">
                                                        <thead>
                                                            <tr>
                                                                <th class="name">
                                                                    {{trans('duediligenceprocess.table_filename')}}
                                                                </th>
                                                                <th class="type">
                                                                    {{trans('duediligenceprocess.table_filetype')}}
                                                                </th>
                                                                <th class="format">
                                                                    {{trans('duediligenceprocess.table_fileformat')}}
                                                                </th>
                                                                <th class="date">
                                                                    {{trans('duediligenceprocess.table_filedate')}}
                                                                </th>
                                                                <th class="action">
                                                                    {{trans('duediligenceprocess.table_fileaction')}}
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="public_document_table">
                                                            <tr ng-hide="!publicdoc.length" ng-repeat="pub in publicdoc | filter:public_search | filter:filterByExt | orderBy: sortByPublic">
                                                                @verbatim
                                                                <td><input class="form-control" type="checkbox" value="{{ pub.documentid }}">{{ pub.documentname }}</td>
                                                               
                                                                <td>{{ ::pub.type }}</td>
                                                                <td>{{ ::pub.extention }}</td>
                                                                <td>{{ ::pub.updated }}</td>
                                                                @endverbatim
                                                                <td>
                                                                    <a href="/storage/pipelinedeal/documents/public/@{{ pub.documenttitle }}" target="_blank">
                                                                        <i class="os-icon os-icon-signs-11"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr ng-hide="publicdoc.length > 0">
                                                                <td colspan="5">{{trans('eso_company_profile_view.documents_public_not_found')}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="element-box table-rit-section">
                                            <h5 class="form-header">
                                                {{trans('duediligenceprocess.documents_private_caption')}}
                                            </h5>
                                            <div class="form-desc">
                                                {{trans('duediligenceprocess.documents_public_text')}}
                                            </div>
                                            <div class="controls-above-table">
                                                <div class="row">
                                                    <div class="col-sm-12 col-lg-4">
                                                            @if($is_parent[0]->Is_Parent=='Yes')
                                                                <button class="btn btn-sm btn-primary" data-target="#exampleModal2" data-toggle="modal" type="button">Upload</button>
                                                            @endif
                                                        
                                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal2" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            {{trans('duediligenceprocess.private_modal_title')}}
                                                                        </h5>
                                                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('pipelinedeal.document.store')}}" method="POST" enctype="multipart/form-data" class="dropzone" id="upload-files-private">
                                                                            {{ csrf_field() }}
                                                                            <input type="hidden" name="private_documents" value="private_documents" />
                                                                            <input type="hidden" name="pipelinedealid" value="{{$pipelinedealid}}" />
                                                                            <div class="dz-message">
                                                                                <div>
                                                                                    <h4>{{trans('duediligenceprocess.public_modal_drop_text')}}</h4>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-sm btn-danger" data-dismiss="modal" type="button"> Close</button><button class="btn btn-sm btn-danger" type="button">{{trans('duediligenceprocess.public_modal_upload_btn_label')}}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($is_parent[0]->Is_Parent=='Yes')
                                                        <button class="btn btn-sm btn-danger" type="button" onclick="fnDeleteDocuments('private');">{{trans('duediligenceprocess.public_delete_btn_label')}}</button>
                                                        @endif
                                                        <div aria-labelledby="exampleModalLabel" class="modal fade" id="private_document_delete_modal" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">
                                                                            {{trans('duediligenceprocess.modal_delete_confirmation')}}
                                                                        </h5>
                                                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form>
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <h6>
                                                                                            {{trans('duediligenceprocess.modal_delete_text')}}
                                                                                        </h6>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="alert alert-success" role="alert" id="del-message-box-private" style="display:none;">
                                                                        {{trans('duediligenceprocess.modal_delete_success')}}
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mdel_close_private">{{trans('duediligenceprocess.btn_del_no')}}</button>
                                                                        <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedDocuments('private');" id="btn_del_yes_private">{{trans('duediligenceprocess.btn_del_yes')}}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-8 filter-moble">
                                                        <form class="form-inline justify-content-sm-end">
                                                            <input ng-model='private_search.documentname' class="form-control form-control-sm rounded bright" placeholder="Search" type="text">
                                                            <select ng-model='sortByPrivate' class="form-control form-control-sm rounded bright">
                                                                <option selected="selected" value="">
                                                                    {{trans('duediligenceprocess.select_sort_by')}}
                                                                </option>
                                                                <option value="documentname">{{trans('duediligenceprocess.select_file_name')}} </option>
                                                                <option value="extention">{{trans('duediligenceprocess.select_type')}}</option>
                                                                <option value="updated">{{trans('duediligenceprocess.select_date')}}</option>
                                                            </select>
                                                            <select ng-model='privateFilterByExt' class="form-control form-control-sm rounded bright">
                                                                <option selected="selected" value="">
                                                                    {{trans('duediligenceprocess.select_filter')}}
                                                                </option>
                                                                <option value="txt">
                                                                    {{trans('duediligenceprocess.select_txt')}}
                                                                </option>
                                                                <option value="jpg">
                                                                    {{trans('duediligenceprocess.select_jpg')}}
                                                                </option>
                                                                <option value="png">
                                                                    {{trans('duediligenceprocess.select_png')}}
                                                                </option>
                                                                <option value="xls">
                                                                    {{trans('duediligenceprocess.select_xls')}}
                                                                </option>
                                                                <option value="xlsx">
                                                                    {{trans('duediligenceprocess.select_xlsx')}}
                                                                </option>
                                                                <option value="pdf">
                                                                    {{trans('duediligenceprocess.select_pdf')}}
                                                                </option>
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive table-responsive-heading-spce">

                                                <table class="table table-lightborder" ng-controller="pipelinedeal_document">
                                                    <input ng-model="pipelinedealid" type="hidden" value="{{$pipelinedealid}}">
                                                    <thead>
                                                        <tr>
                                                            <th class="name">
                                                                {{trans('duediligenceprocess.table_filename')}}
                                                            </th>
                                                            <th class="type">
                                                                {{trans('duediligenceprocess.table_filetype')}}
                                                            </th>
                                                            <th class="format">
                                                                {{trans('duediligenceprocess.table_fileformat')}}
                                                            </th>
                                                            <th class="date">
                                                                {{trans('duediligenceprocess.table_filedate')}}
                                                            </th>
                                                            <th class="action">
                                                                {{trans('duediligenceprocess.table_fileaction')}}
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="private_document_table">
                                                        <tr ng-hide="!privatedoc.length" ng-repeat="priv in privatedoc | filter:private_search | filter:privateFilterByExt | orderBy: sortByPrivate">
                                                            <td><input class="form-control" type="checkbox" value="@{{ priv.documentid }}">@{{ priv.documentname }}</td>
                                                            <td>@{{ priv.type }}</td>
                                                            <td>@{{ priv.extention }}</td>
                                                            <td>@{{ priv.updated }}</td>
                                                            <td>
                                                                <a href="/storage/pipelinedeal/documents/private/@{{ priv.documenttitle }}" target="_blank">
                                                                    <i class="os-icon os-icon-signs-11"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr ng-hide="privatedoc.length > 0">
                                                            <td colspan="5">{{trans('eso_company_profile_view.documents_private_not_found')}}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--------------------
              END - Due Diligence Process
              -------------------->

        </div>

    </div>
</div>




      @endsection

<input type="hidden" id='pipelinedealid' value='{{$pipelinedealid}}'>
<input type='hidden' id='loggedinuserid' value="{{$user_loggedin}}">

   @section('scripts')

<script src="https://js.pusher.com/4.0/pusher.min.js"></script>
<script type="text/javascript">

            function fnDeleteDocuments(mode)
        {
          debugger;
          var cnt=0;
          if(mode=='public')
          {
         $('#public_document_table input:checkbox:checked').each(function() {
            debugger;
            var id = $(this).attr('value');
            cnt=cnt+1;
         });
          }
          else{//private case
           $('#private_document_table input:checkbox:checked').each(function() {
            debugger;
            var id = $(this).attr('value');
            cnt=cnt+1;
         });
 
          }
 
         if(cnt<=0)
         {
           return;
         }
 
          if(cnt>0)
          {
           if(mode=='public')
           {
             $('#public_document_delete_modal').modal('show');
           }
           else//Private Case....
           {
             $('#private_document_delete_modal').modal('show');
           }
          }
        }
 
        function fnDeleteSelectedDocuments(mode)
        {
          debugger;
         var documentlist = [];
         var cnt=0;
         if(mode=='public')
         {
           $('#public_document_table input:checkbox:checked').each(function() {
            var id = $(this).attr('value');
            documentlist.push({ documentid: id });
            cnt=cnt+1;
         });
         }
         else
         {//private case
           $('#private_document_table input:checkbox:checked').each(function()
           {
            var id = $(this).attr('value');
            documentlist.push({ documentid: id });
            cnt=cnt+1;
         });
         }
 
 
         if(cnt<=0)
         {
           return;
         }
 
          if(cnt>0)
          {
           $.ajaxSetup({
         headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
         });
 
            var formdata = new FormData();
 
         formdata.append("documentlist",JSON.stringify(documentlist));
         formdata.append("type",mode);
         formdata.append("_token",'{{csrf_token()}}');
 
        $.ajax({
             url: '/pipelinedeal-delete-documents',
             type: "POST",
             contentType: false,
             processData: false,
             data: formdata,
             cache: false,
             timeout: 100000,
             success: function (data) {
                     if(mode=='public')
                     {
                       var $messageDiv = $('#del-message-box');
                         $messageDiv.show();
                         setTimeout(function () { $messageDiv.hide();$('#public_document_delete_modal').modal('hide'); window.location.reload(true); }, 3000);
                     }
                     else{//case of private...
                       var $messageDiv = $('#del-message-box-private');
                         $messageDiv.show();
                         setTimeout(function () { $messageDiv.hide();$('#private_document_delete_modal').modal('hide'); window.location.reload(true); }, 3000);
                     }
 
 
             },
             error: function (err, result) {
               debugger;
                 alert("Error" + err.responseText);
             }
         });
 
          }
        }


</script>


       @endsection