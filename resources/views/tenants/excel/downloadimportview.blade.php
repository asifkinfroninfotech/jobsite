@php
$helper=\App\Helpers\AppHelper::instance();
@endphp
@extends('tenants.layouts.app_layout', ['layout' => 'left_side_menu_tenant'])
@section('content')
<div class="content-w portfolio-custom-vk">
        <!--
          START - Secondary Top Menu
          -->
          @include('tenants.shared._top_menu_tenant')
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
                             {!!trans('tenant_dashboard.download_import_data_help_title')!!}   
                          </h5>
                          <div class="form-desc">
                             {!!trans('tenant_dashboard.help_content')!!}
                          </div>
                          <div class="element-box-content example-content">
                                  <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('tenant_dashboard.help_btn_hide_caption')}}</button>
                          </div>
             </div>
          </div>
          @endif
             <style>
              .inv-vh{height: 58vh;}
              </style>
           
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
<!--                  <h6 class="element-header">
                   Import Data
                  </h6>-->

                  <!--START - Projects list-->
                 
                  <!--END - Projects list-->
                </div>
              </div>
            </div>
            <!--
              END - My Portfolio 
              -->
           
            <div class="element-box element-wrapper-marging-btm">
                            <h5 class="form-header">
                               Download/Import Data Form  
                            </h5>

                <div class="element-box-content example-content">
                <form id='downloadimportexcel' style="margin-top: 15px;padding: 10px;" action='/downloadandimport' class="form-horizontal" method="post" enctype="multipart/form-data">
                             {{ csrf_field() }}    
                <div class='row'>
                <div class='col-sm-6'>    
                    <div class='form-group'>
                       <a class="btn btn-primary" href='/exceltemplate/template.xls'>Download Template File</a>  
                    </div>    
                </div>
                <div class='col-sm-12'>    
                    <div class='form-group'>
                       <label for="">
                         Select Company Type *
                       </label>
                        <div class="input-group">
                                  
                                        <select id='company_type' class="form-control" placeholder="Select Company Type"
                                    data-error="Company type must not be empty" required="required" type="text" name="company_type">
                                   <option value=''>Please Select</option>
                                   @foreach($companytypes as $companytype)
                                   <option value='{{$companytype->companytypeid}}'>{{$companytype->companytype}}</option>
                                   @endforeach
                                  </select>    
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
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
                        <div class='form-group' style="float:right;">
                             <button class="btn btn-primary" id='importfile'>Import File</button>
                        </div>    
                    </div>
                </div>    
                </form>             
                            </div>

              <div class="element-box" id='importedtable' style="margin-top:15px;">
                  
                </div>



                </div>
      
                     
                                                        @if ($errors->any())
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">X</a>
                        <ul>

                            @foreach ($errors->all() as $error)
                                <p>File must be valid.</p>
                            @endforeach
                        </ul>
                    </div>
                @endif
 
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">X</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                @endif
                
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
          
          <!--
            END - Sidebar
            -->
        </div>
      </div>
      
      @endsection


      @section('scripts')
      
       
      @if($errors->any())
       <script>         
         $('html, body').animate({
         scrollTop: $("#importexcel").offset().top
         }, 2000);
              </script>
       @endif
      
      <script type="text/javascript">
       $('#downloadimportexcel').submit(function(e){
          e.preventDefault();
          
           $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
         });
         
          if($('#company_type').val().length > 0)
          {
          var formData = new FormData();
          var importFiles = $('#import_file').prop('files')[0];
          formData.append('uploadFiles', importFiles);
          formData.append('companytype', $('#company_type').val());
          formData.append("_token",'{{csrf_token()}}'); 
          $('#importfile').prop('disabled', true);
          $.ajax({ 
            url: '/downloadimportpost',
            type: "POST",
            contentType: false,
            processData: false,
            data: formData,
            cache: false,
            timeout: 100000,
           success: function (data) {
            //  alert(data);
            //    debugger;
               $('#importedtable').html(data);
              //  $('#importedtable').show();
               $('#dataTable1').DataTable();
            },
            error: function (message) {
                
            },
        //     xhr:function(){
        //     var xhr = new window.XMLHttpRequest();
        // //Download progress
        //     xhr.addEventListener("progress", function (evt) {
        //     console.log(evt.lengthComputable);
        //     if (evt.lengthComputable) {
        //         var percentComplete = evt.loaded / evt.total;
        //         progressElem.html(Math.round(percentComplete * 100) + "%");
        //     }
        // }, false);
        // return xhr;
        //     }
        });
          
         }
          
       });
  
  
  
  
  
  

      </script>

      
      
      

      @endsection