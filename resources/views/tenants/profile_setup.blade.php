 @extends('layouts.tenant_layout')
 <link href="/colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
 <link href="/colorpicker/dist/css/bootstrap-colorpicker-plus.css" rel="stylesheet">
@section('content')
               
                
  <div class="all-wrapper menu-side login-information">
    <div class="auth-box-w">
      
      @if(isset($tenantdetails) && !empty($tenantdetails))
      @if(isset($tenantdetails->logo) && !empty($tenantdetails->logo) && File::exists(public_path('/storage/tenant/logoimage/'.$tenantdetails->logo)))
      <div class="logo-w">

        <img alt="" src="{{'/storage/tenant/logoimage/'.$tenantdetails->logo}}">

      </div>
      @else    
      <div class="logo-w">
      <a href="/"><img alt="" src="/img/logo_desktop.png"></a>
    </div>
      @endif
      @else
      <div class="logo-w">
        <a href="/"><img alt="" src="/img/logo_desktop.png"></a>
      </div>
      @endif

      <!-- START - profile setup content area -->
      <div class="col-sm-12 col-md-12">
        <div class="element-wrapper">
          <div class="login-info-hd text-center">
            <h5 class="element-inner-header">
              Welcome back {{$tenantdetails->company}}
            </h5>

          </div>
          

             @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
            
          <div class="steps-w">
            <div class="drup-box-outer">
            <div class="row">
              <div class="col-sm-6">
                <h5 class="form-header">
                  {{trans('tenant_complete_profile.logo_image_label')}}
                </h5>
                <div class="form-desc">
                   {{trans('tenant_complete_profile.logo_image_description')}}
                </div>
               <form action="{{ url('/savelogoimage') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="profile_image" >
                  {{ csrf_field() }}
                    <div class="dz-message">
                    <div>
                       
                      <?php if(!empty($tenantdetails->logo)){?>    
                      
                        <img src="/storage/tenant/logoimage/{{$tenantdetails->logo}}">
                      <?php } if(empty($tenantdetails->logo)) {?> 
                          
                      <h4>{{trans('tenant_complete_profile.logo_image_drop_content')}}</h4>
                      <?php }?> 
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-sm-6">
                <h5 class="form-header">
                  {{trans('tenant_complete_profile.cover_image_label')}}
                </h5>
                <div class="form-desc">
                  {{trans('tenant_complete_profile.cover_image_description')}}
                </div>
                 <form action="{{ url('/savecoverimage') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="cover_image">
                  {{ csrf_field() }}
                    <div class="dz-message">
                    <div>
                      <?php if(!empty($tenantdetails->cover)){?>    
                      
                        <img src="/storage/tenant/coverimage/{{$tenantdetails->cover}}">
                      <?php } else {?> 
                          
                      <h4>{{trans('tenant_complete_profile.cover_image_drop_content')}}</h4>
                      <?php }?> 
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
            <form id="formValidate" method="post" action="/savetenantinfo">
                {{ csrf_field() }}
              <div class="step-contents">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('primarycolor') ? 'has-error' : '' }}">
                      <label for="">{{trans('tenant_complete_profile.primary_color_label')}}</label>

                      
                      <input type='text' class="form-control" id='demo1' name='primarycolor' value='{{ old('primarycolor') }}<?php if(isset($data[0]->primarycolor) ){echo $data[0]->primarycolor;}?>'>

                    </div>
                      {{-- <span class="text-danger">{{ $errors->first('primarycolor') }}</span> --}}
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('secondarycolor') ? 'has-error' : '' }}">
                      <label for="">{{trans('tenant_complete_profile.secondary_color_label')}}</label>

                       <input type='text' class="form-control" id='demo2' name='secondarycolor' value='{{ old('secondarycolor') }}<?php if(isset($data[0]->secondarycolor) ){echo $data[0]->secondarycolor;}?>'>
                    </div>
                      {{-- <span class="text-danger">{{ $errors->first('secondarycolor') }}</span> --}}
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group {{ $errors->has('about') ? 'has-error' : '' }}">
                      <label>{{trans('tenant_complete_profile.about_label')}}*</label>
                      <textarea class="form-control" rows="3" name="about">{{ old('about') }}   <?php if(isset($data[0]->about)){echo $data[0]->about;}?></textarea>
                   
                      <span class="text-danger">{{ $errors->first('about') }}</span>
                      
                      
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group {{ $errors->has('terms') ? 'has-error' : '' }}">
                      <label>{{trans('tenant_complete_profile.terms_label')}}*</label>
                      <textarea class="form-control" rows="3" name="terms">{{ old('terms') }}<?php if(isset($data[0]->term)){echo $data[0]->term;}?></textarea>
                     <span class="text-danger">{{ $errors->first('terms') }}</span>
                      
                      
                      
                    </div>
                  </div>
                </div>
                  
                  <div class="row">
                      <div class="col-sm-6">
                          <h5 class="form-header">
                 {{trans('tenant_complete_profile.email_settings_heading')}}
                  </h5>
                      </div>
                  </div>
                  
                  <div class="row">
                  <div class="col-sm-6">
                  
                  <div class="form-group {{ $errors->has('from_name') ? 'has-error' : '' }}">
                      <label for="">{{trans('tenant_complete_profile.from_name_label')}}*</label>
                  <input type="text" class="form-control"  name="from_name" value="{{old('from_name')}}<?php if(isset($data[0]->from_name)){echo $data[0]->from_name;}?>" /> 
                        <span class="text-danger">{{ $errors->first('from_name') }}</span>    
                    </div>
                     
                  </div>
                   <div class="col-sm-6">
                
                  <div class="form-group {{ $errors->has('from_email') ? 'has-error' : '' }}">
                      <label for="">{{trans('tenant_complete_profile.from_email_label')}}*</label>
                       <input type="text" class="form-control"  name="from_email" value="{{old('from_email')}}<?php if(isset($data[0]->from_email)){echo $data[0]->from_email;}?>" />
                       <span class="text-danger">{{ $errors->first('from_email') }}</span> 
                    </div>
                         
                  </div>    
                      
                      
                      
                  </div>
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group {{ $errors->has('contact_us_link') ? 'has-error' : '' }}">
                      <label for="">{{trans('tenant_complete_profile.contact_us_link_label')}}*</label>
                       <input type="text" class="form-control"  name="contact_us_link" value="{{old('contact_us_link')}}<?php if(isset($data[0]->contact_us_link)){echo $data[0]->contact_us_link;}?>" /> 
                        <span class="text-danger">{{ $errors->first('contact_us_link') }}</span>  
                    </div>
                           
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group {{ $errors->has('privacy_policy_link') ? 'has-error' : '' }}">
                      <label for="">{{trans('tenant_complete_profile.privacy_policy_link_label')}}*</label>
                       <input type="text" class="form-control"  name="privacy_policy_link" value="{{old('privacy_policy_link')}}<?php if(isset($data[0]->privacy_policy_link)){echo $data[0]->privacy_policy_link;}?>" /> 
                        <span class="text-danger">{{ $errors->first('privacy_policy_link') }}</span>  
                    </div>
                           
                      </div>
                  </div>
                  
                  
                  <div class="row">
                  <div class="col-sm-6">
                  <h5 class="form-header">
                 {{trans('tenant_complete_profile.set_languages_heading')}}
                  </h5>
                  </div>
                  </div>
                  
                  
                   <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group ful-wdth-select {{ $errors->has('primarylogin') ? 'has-error' : '' }}">
                      <label for="">{{trans('tenant_complete_profile.primary_login_label')}}</label>
                     
                      <select class="form-control select2" name="primarylogin[]" id="primary" onchange="secondaryunselect();" >
                                                            @if(isset($primarylanguagetodisplay))
                                                            @foreach($primarylanguagetodisplay as $languagetodisplay)
                                                            <option value= '{{ $languagetodisplay->locale }}' <?php if(old("primarylogin")[0]==$languagetodisplay->locale){echo 'selected';}?> >
                                                                {{ $languagetodisplay->locale }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                    </div>
                     
                     
                      
                      {{-- <span class="text-danger">{{ $errors->first('primarycolor') }}</span> --}}
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('secondarylogin') ? 'has-error' : '' }}">
                      <label for="">{{trans('tenant_complete_profile.secondary_login_label')}}</label>
                      <div class="form-group ful-wdth-select">
                      <select class="form-control select2" name="secondarylogin[]" id='secondary'>
                                                      @if(isset($secondarylanguagetodisplay))
                                                      @foreach($secondarylanguagetodisplay as $secondary) 
                                                      <option value="{{$secondary->locale}}"  <?php if(old("secondarylogin")[0]==$secondary->locale){echo 'selected';}?>>{{$secondary->locale}}</option>
                                                      @endforeach
                                                      @endif
                                                        </select>
                         </div>

                    </div>
                      {{-- <span class="text-danger">{{ $errors->first('secondarycolor') }}</span> --}}
                  </div>
                </div>
                  
                @if(count($errors))
          
                <div class="alert alert-danger">
                   
                   {{trans('tenant_complete_profile.required_error')}}
                 
                </div>
            @endif
                  
                  
                <div class="form-buttons-w text-right">
<!--                  <a class="btn btn-primary step-trigger-btn" href="#"> Submit</a>-->
<!--                   <a class="btn btn-primary step-trigger-btn" href="#"> Submit</a>-->
<!--                   <button type="submit" class="btn btn-primary step-trigger-btn">Submit</button>-->
                   <input type="submit" class="btn btn-primary" value="Submit">
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- END - profile setup content area -->

    </div>
    <p class="copy-right text-center">
      &copy; Copyright {{date('Y')}} {{\App\Helpers\AppGlobal::$Artha_Company_Name}}. All rights reseved.
    </p>
  </div>
                
                @endsection


                @section('scripts')

    <script src="/colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="/colorpicker/dist/js/bootstrap-colorpicker-plus.js"></script>
    <script type="text/javascript">

          $( document ).ready(function(){

          var c1 = $('#demo1').val();
          if(c1!='')
          {
          $('#demo1').val(c1).css('background-color', c1);
          }

          var c2 = $('#demo2').val();
          if(c2!='')
          {
          $('#demo2').val(c2).css('background-color', c2);
          }

         });

    $(function(){
        var demo1 = $('#demo1');
        demo1.colorpickerplus();
        demo1.on('changeColor', function(e,color){
			if(color==null)
			$(this).val('transparent').css('background-color', '#fff');//tranparent
			else
        	$(this).val(color).css('background-color', color);
        });

      
      var demo2 = $('#demo2');
        demo2.colorpickerplus();
        demo2.on('changeColor', function(e,color){
			if(color==null)
			$(this).val('transparent').css('background-color', '#fff');//tranparent
			else
        	$(this).val(color).css('background-color', color);
        });
        
		
		
		
    });
    </script>
                
                
                
                
                
                
                <script>

Dropzone.options.myAwesomeDropzone = {
  maxFiles: 1,
  acceptedFiles: ".jpeg,.jpg,.png,.gif",
  accept: function(file, done) {
    console.log("uploaded");
    done();
  },
  init: function() {
    this.on("maxfilesexceeded", function(file){
        //alert("No moar files please!");
        this.removeAllFiles(file);
        this.addFile(file);
    });
    }
    }
   
 Dropzone.options.myAwesomeDropzone1 = {
  maxFiles: 1,
  acceptedFiles: ".jpeg,.jpg,.png,.gif",
  accept: function(file, done) {
    console.log("uploaded");
    done();
  },
  init: function() {
    this.on("maxfilesexceeded", function(file){
        //alert("No moar files please!");
        this.removeAllFiles(file);
        this.addFile(file);
    });
    }
    }  
   
    
 
    
                </script>
               
            <script>
                     var primary=$('#primary').val();
            $.get('/getsecondaryvalues?multi='+primary,function(data){
                      $('#secondary').html(data);
                    });
            function secondaryunselect()
            {
                var multivalues=$('#primary').val();
              
                    $.get('/getsecondaryvalues?multi='+multivalues,function(data){
                      $('#secondary').html(data);
                    });
                
               
            }
            </script>   
                
                @endsection
                
                
                
                


