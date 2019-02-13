@php
$helper=\App\Helpers\AppHelper::instance();
@endphp
@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')
<div class="content-w portfolio-custom-vk">
  <!--
          START - Secondary Top Menu
          -->
  @include('shared._top_menu')
  <!--
            END - Secondary Top Menu
            -->






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
            {!!trans('my_portfolio.help_title')!!}
          </h5>
          <div class="form-desc">

            @if(session('usertype')=='Investors')
            {!!$helper->GetHelpModifiedText(trans('my_portfolio.help_content'))!!}
            @endif
            @if(session('usertype')=='ESOs')
            {!!$helper->GetHelpModifiedText(trans('my_portfolio.eso_help_content'))!!}
            @endif
            @if(session('usertype')=='enterprises')
            {!!$helper->GetHelpModifiedText(trans('my_portfolio.enterprise_help_content'))!!}
            @endif
            @if(session('usertype')=='Service Providers')
            {!!$helper->GetHelpModifiedText(trans('my_portfolio.sp_help_content'))!!}
            @endif
          </div>
          <div class="element-box-content example-content">
            <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
              {{trans('my_portfolio.help_btn_hide_caption')}}</button>
          </div>
        </div>
      </div>
      @endif


      <div class="os-tabs-w">
        <div class="os-tabs-controls">
          <ul class="nav nav-tabs upper">
            <li class="nav-item">
              <a aria-expanded="false" class="nav-link active" data-toggle="tab" onclick="LoadPipelineDeals(1);" href="#tab_overview">
                {{trans('my_portfolio.tab_label_active')}}</a>
            </li>
            <li class="nav-item">
              <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="LoadPipelineDeals(1);" href="#tab_sales">{{trans('my_portfolio.tab_label_inactive')}}</a>
            </li>
            <li class="nav-item">
              <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="LoadPipelineDeals(1);" href="#tab_sales">{{trans('my_portfolio.tab_label_archive')}}</a>
            </li>
          </ul>
          {{-- <ul class="nav nav-pills smaller d-none d-lg-flex">
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#"> Today</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#"> 7 Days</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#"> 14 Days</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#"> Last Month</a>
            </li>
          </ul> --}}
        </div>
      </div>
    </div>
  </div>
  <!--END - Control panel above projects-->

  <div class="content-i">
    <div class="content-box">
      <!--
              start - My Portfolio 
             -->
      <div class="row">
        <div class="col-sm-12">
          <div class="element-wrapper">
            <h6 class="element-header">
              {{trans('my_portfolio.title_myportfolio')}}
            </h6>
            <div class="controls-above-table filter-row-top">
              <div class="row">
                <div class="col-sm-12">
                  <form class="form-inline justify-content-sm-end">
                    <input class="form-control form-control-sm rounded bright" placeholder="{{trans('my_portfolio.input_search_placeholder')}}"
                      type="text" id="txtSearch">
                    <select class="form-control form-control-sm rounded bright" id="sortbyfield" onchange="LoadPipelineDeals(1);">
                      <option selected="selected" value="">
                        {{trans('my_portfolio.input_sortby')}}
                      </option>
                      <option value="Name">
                        {{trans('my_portfolio.input_name')}}
                      </option>
                      <option value="Investment">
                        {{trans('my_portfolio.input_investment')}}
                      </option>
                    </select>
                  </form>
                </div>
              </div>
            </div>
            <!--START - Projects list-->
            <div class="projects-list projects-list-vk" id="attached_deals">

              {{-- @include('my_portfolio._attached_deals') --}}

            </div>
            <!--END - Projects list-->
          </div>
        </div>
      </div>
      <!--
              END - My Portfolio 
              -->


      <!--
              START - Color Scheme Toggler
              -->
      <div class="floated-colors-btn second-floated-btn">
        <div class="os-toggler-w">
          <div class="os-toggler-i">
            <div class="os-toggler-pill"></div>
          </div>
        </div>
        <span>Dark </span>
        <span>Colors</span>
      </div>
      <!--
              END - Color Scheme Toggler
              -->
      <!--
              START - Chat Popup Box
             -->
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
                  John Bloggs
                </h6>
                <div class="user-role">
                  Director
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
      <!--
              END - Chat Popup Box
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
          {{trans('my_portfolio.title_search')}}
        </h6>
        <div class="element-box-tp">
          <div class="element-box">
            <div class="form-group">
              <label for="">{{trans('my_portfolio.input_country')}}</label>
              <select class="form-control select2" multiple="true" id="ms_country">
                @foreach($collection_data['country'] as $dstatus)
                <option value="{{$dstatus->id}}">
                  {{$dstatus->name}}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="">{{trans('my_portfolio.input_investment_stage')}}</label>
              <select class="form-control select2" multiple="true" id="i_stages">
                @foreach($collection_data['investmentstages'] as $dstatus)
                <option value="{{$dstatus->id}}">
                  {{$dstatus->name}}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="">{{trans('my_portfolio.input_duediligencestatus')}}</label>
              <select class="form-control select2" multiple="true" id="dd_status">
                @foreach($collection_data['dd_status'] as $dstatus)
                <option value="{{$dstatus->id}}">
                  {{$dstatus->name}}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="">{{trans('my_portfolio.input_sdg')}}</label>
              <select class="form-control select2" multiple="true" id="sdg">
                @foreach($collection_data['sdgs'] as $dstatus)
                <option value="{{$dstatus->id}}">
                  {{$dstatus->name}}
                </option>
                @endforeach
              </select>
            </div>
            <a class="btn btn-primary step-trigger-btn" href="#" onclick='LoadPipelineDeals(1);'>{{trans('my_portfolio.sbm_btn_lbl')}}</a>
          </div>
        </div>
      </div>
      <div class="element-wrapper">
        <h6 class="element-header">
          {{trans('my_portfolio.title_folder')}}
        </h6>

        <!--START - To Do SIDEBAR-->
        <div class="todo-app-w">
          <div class="todo-sidebar">
            <div class="todo-sidebar-section">
              <div class="todo-sidebar-section-contents">
                <ul class="projects-list folder-list">
                  {{-- <li>
                    <a href="#" class="active">Portfolio Folder</a>
                  </li>
                  <li>
                    <a href="#">Portfolio Folder</a>
                  </li>
                  <li>
                    <a href="#">Portfolio Folder</a>
                  </li> --}}
                  @foreach($pipelinefolders as $folder)
                  <li>
                    <a href="#" onclick="fnSetFolder('{{$folder->folderid}}');" id="{{$folder->folderid}}">{{$folder->foldername}}</a>
                  </li>
                  @endforeach
                  <li class="add-new-project">
                    <a href="javascript:void(0);" data-target=".bd-example-modal-sm" data-toggle="modal">{{trans('my_portfolio.label_addnewfolder')}}</a>
                    <div aria-hidden="true" aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm"
                      role="dialog" tabindex="-1" id="folder_modal">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                              {{trans('my_portfolio.popup_title_addnewfld')}}
                            </h5>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true"> &times;</span></button>
                          </div>
                          <div class="modal-body">
                            <form>
                              <div class="form-group">
                                <label for=""> {{trans('my_portfolio.input_label_foldername')}}</label><input class="form-control"
                                  placeholder="{{trans('my_portfolio.input_fldrname_placeholder')}}" type="name" id="txtFolderName">
                              </div>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-primary" type="button" onclick="fnCreateNewFolder();" id="btnFolderSave">{{trans('my_portfolio.btn_save')}}</button>
                          </div>
                          <div class="modal-footer">
                            <div class="alert alert-danger form-group" role="alert" id="error-folder" style="display:none;">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!--END - To Do SIDEBAR-->

      </div>
    </div>
    <!--
            END - Sidebar
            -->
  </div>
</div>
<input type='hidden' id='selected_folderid' value="">
<input type='hidden' id='current_pipelinedealid' value="">
<input type="hidden" id="setstatus" value="">
<input type="hidden" id="setid" value="">
<input type="hidden" id="start_pid" value="">
@endsection


@section('scripts')

<script type="text/javascript">
  $(document).on('click', '.pagination a', function (e) {

    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    LoadPipelineDeals(page);
  });

  $(document).ready(function () {
    debugger;
    $('.folder-list li:first a').addClass('active');
    var folderid = $('.folder-list li:first a').attr('id');
    $('#selected_folderid').val(folderid);
    LoadPipelineDeals(1);
  });

  function fnSetFolder(folderid) {
    $('.folder-list li a').removeClass('active');
    $('#' + folderid).addClass('active');
    $('#selected_folderid').val(folderid);
    LoadPipelineDeals(1);
  }

  function LoadPipelineDeals(page) {
    debugger;
    var folderid = $('#selected_folderid').val();
    if (page == null || page == "") {
      page = 1;
    }

    setTimeout(function () {
      var route = '/ajax-get-my-pipelinedeals';
      var searchtext = $('#txtSearch').val();
      var sortby = $("#sortbyfield option:selected").val();
      var countryids = '';
      var $el = $("#ms_country");
      $el.find('option:selected').each(function () {

        if (countryids == '') {
          countryids = $.trim($(this).val());
        } else {
          countryids = countryids + ',' + $.trim($(this).val());
        }

      });



      // var sectorids='';
      // var $e2=$("#ms_sectors");
      // $e2.find('option:selected').each(function(){
      //     if(sectorids=='')
      //     {
      //         sectorids=$.trim($(this).val());
      //     }
      //     else{
      //         sectorids=sectorids+','+$.trim($(this).val());
      //     }
      //    });


      var investmentstages = '';
      var $e3 = $("#i_stages");
      $e3.find('option:selected').each(function () {
        if (investmentstages == '') {
          investmentstages = $.trim($(this).text());
        } else {
          investmentstages = investmentstages + ',' + $.trim($(this).text());
        }
      });

      //    var investmentsizes='';
      // var $e4=$("#i_sizes");
      // $e4.find('option:selected').each(function(){
      //     if(investmentsizes=='')
      //     {
      //         investmentsizes=$.trim($(this).text());
      //     }
      //     else{
      //         investmentsizes=investmentsizes+','+$.trim($(this).text());
      //     }
      //    });

      var ddstatus = '';
      var $e5 = $("#dd_status");
      $e5.find('option:selected').each(function () {
        if (ddstatus == '') {
          ddstatus = $.trim($(this).text());
        } else {
          ddstatus = ddstatus + ',' + $.trim($(this).text());
        }
      });

      var sdgs = '';
      var $e6 = $("#sdg");
      $e6.find('option:selected').each(function () {
        if (sdgs == '') {
          sdgs = $.trim($(this).val());
        } else {
          sdgs = sdgs + ',' + $.trim($(this).val());
        }
      });


      var active = 'active';
      var text = $(".nav-link.active").text().toLowerCase();
      var active = $.trim(text);



      //  route=route+'?sectorids='+sectorids+'&countryids='+countryids+'&investmentstages='+investmentstages+'&investmentsizes='+investmentsizes+'&ddstatus='+ddstatus+'&sdgs='+sdgs+'&page='+pageno+'&searchtext='+searchtext+'&sortby='+sortby;
      route = route + '?countryids=' + countryids + '&investmentstages=' + investmentstages + '&ddstatus=' +
        ddstatus + '&sdgs=' + sdgs + '&page=' + page + '&searchtext=' + searchtext + '&sortby=' + sortby +
        '&folderid=' + folderid + '&active=' + active;

      $.ajax({
        type: "GET",
        url: route,
        contentType: false,
        success: function (data) {
          debugger;
          $("#attached_deals").html('');
          $("#attached_deals").html(data);

          var projectboxcount = $('.project-box').length;
          $('#numberofbox').html(projectboxcount);
        },
        error: function (xhr, status, error) {
          alert(xhr.responseText);
        }
      });


    }, 1000);



  }


  function fnCreateNewFolder() {
    var foldername = $('#txtFolderName').val();

    if ($.trim(foldername) == "") {
      $('#error-folder').html('Folder name can not be blank.');
      var $messageDiv = $('#error-folder'); // get the reference of the div
      $messageDiv.show(); // show and set the message.html(data.Message)
      setTimeout(function () {
        $messageDiv.hide();
      }, 3000); // 3 seconds later, hide
      return;
    } else {
      $('#error-folder').html('');
    }

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var formdata = new FormData();
    formdata.append("foldername", $.trim(foldername));
    formdata.append("_token", '{{csrf_token()}}');
    $('#btnFolderSave').prop("disabled", true);
    $.ajax({
      url: '/create-new-pipelinedeal-folder',
      type: "POST",
      contentType: false,
      processData: false,
      data: formdata,
      cache: false,
      timeout: 100000,
      success: function (data) {

        if (data.status == 'Duplicate') {
          $('#btnFolderSave').prop("disabled", false);
          $('#error-folder').html('Duplicate! Please enter unique folder name.');
          var $messageDiv = $('#error-folder'); // get the reference of the div
          $messageDiv.show(); // show and set the message.html(data.Message)
          setTimeout(function () {
            $messageDiv.hide();
          }, 3000); // 3 seconds later, hide
          return;
        } else {
          $('#txtFolderName').val('');
          $('#btnFolderSave').prop("disabled", false);
          $('#folder_modal').hide();
          window.location.reload(true);
        }

      },
      error: function (err, result) {
        $('#btnFolderSave').prop("disabled", false);
      }
    });
  }

  var timer;
  $("#txtSearch").keyup(function () {
    clearTimeout(timer);
    var ms = 3000; // milliseconds
    var val = this.value;
    timer = setTimeout(function () {
      LoadPipelineDeals(1);
    }, ms);
  });


  function fnOpenModifyFolderPopup(pipelinedealid) {
    $('#current_pipelinedealid').val(pipelinedealid);
    $('#change_folder_modal').modal('show');
  }

  function fnUpdateFolder() {
    var folderid = $("#userpipeline_folders option:selected").val();
    if (parseInt(folderid) <= 0) {
      $('#error-modify-folder').html('Please select a folder.');
      var $messageDiv = $('#error-modify-folder'); // get the reference of the div
      $messageDiv.show(); // show and set the message.html(data.Message)
      setTimeout(function () {
        $messageDiv.hide();
      }, 3000); // 3 seconds later, hide
      return;
    }

    var pipelinedealid = $('#current_pipelinedealid').val();


    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var formdata = new FormData();
    formdata.append("pipelinedealid", pipelinedealid);
    formdata.append("folderid", folderid);
    formdata.append("_token", '{{csrf_token()}}');
    $('#btnChangeFolder').prop("disabled", true);
    $.ajax({
      url: '/change-pipelinedeal-folder',
      type: "POST",
      contentType: false,
      processData: false,
      data: formdata,
      cache: false,
      timeout: 100000,
      success: function (data) {

        if (data.status == 'Success') {
          $('#btnChangeFolder').prop("disabled", false);
          $(".modal-backdrop").remove();
          $("#btn_changefolder_close").click();

          //  <div class="modal-backdrop fade show"></div>
          LoadPipelineDeals(1);
        } else {
          $('#btnChangeFolder').prop("disabled", false);
          $('#error-modify-folder').html('Some error found.');
          var $messageDiv = $('#error-modify-folder'); // get the reference of the div
          $messageDiv.show(); // show and set the message.html(data.Message)
          setTimeout(function () {
            $messageDiv.hide();
          }, 3000); // 3 seconds later, hide
          return;
        }

      },
      error: function (err, result) {
        $('#btnFolderSave').prop("disabled", false);
        $(".modal-backdrop").remove();
        $("#btn_changefolder_close").click();

      }
    });


  }

  function fnStartDD(id) {
    debugger;
    var pipelinedealid = id;
    $('#start_pid').val(pipelinedealid);

    // $('#cm_vk').show();
  }


  function fnUpdatePipelineDealStatus(id) {
    debugger;
    var pipelinedealid = $('#start_pid').val();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var formdata = new FormData();
    formdata.append("pipelinedealid", pipelinedealid);
    formdata.append("_token", '{{csrf_token()}}');
    $('#btnStart').prop("disabled", true);
    $.ajax({
      url: '/start-pipelinedeal',
      type: "POST",
      contentType: false,
      processData: false,
      data: formdata,
      cache: false,
      timeout: 100000,
      success: function (data) {

        if (data.status == 'Success') {
          $('#btnStart').prop("disabled", false);
          $(".modal-backdrop").remove();
          $("#confirmation_close").click();
          LoadPipelineDeals(1);
        } else {
          $('#btnStart').prop("disabled", false);
          $('#error-start-duediligence').html('Some error found.');
          var $messageDiv = $('#error-start-duediligence'); // get the reference of the div
          $messageDiv.show(); // show and set the message.html(data.Message)
          setTimeout(function () {
            $messageDiv.hide();
          }, 3000); // 3 seconds later, hide
          return;
        }

      },
      error: function (err, result) {
        $('#btnStart').prop("disabled", false);
        $(".modal-backdrop").remove();
        $("#confirmation_close").click();

      }
    });

  }


  function inactive(id) {
    $('#setstatus').val('inactive');
    $('#setid').val(id);
    var route = "myportfolio_inactive?userid=" + id;
    ajaxcall(route);
  }

  function archive(id) {
    $('#setstatus').val('archive');
    $('#setid').val(id);
    var route = "myportfolio_archive?userid=" + id;
    ajaxcall(route);
  }

  function active(id) {
    $('#setstatus').val('active');
    $('#setid').val(id);
    var route = "myportfolio_active?userid=" + id;
    ajaxcall(route);
  }

  function ajaxcall(route) {
    $.ajax({
      type: "GET",
      url: route,
      contentType: false,
      success: function (data) {
        if (data.message == "Success") {
          LoadPipelineDeals(1);
        }

      },
      error: function (xhr, status, error) {
        alert(xhr.responseText);
      }
    });
  }
</script>


@endsection