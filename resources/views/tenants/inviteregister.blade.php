@extends('layouts.tenant_layout')
 @section('content')
 
    <div class="all-wrapper menu-side login-information">
      <div class="auth-box-w">
        <div class="logo-w">
          <a href="{{url('/')}}"><img alt="" src="{{asset('img/logo_desktop.png')}}"></a>
        </div>
         <!-- START - login info content area -->
                     <div class="col-sm-12 col-md-12">
                      <div class="element-wrapper">
                        <div class="login-info-hd text-center">
                            <h5 class="element-inner-header">
                               <span>{{$companydata->name}}:</span>
                              </h5> 
                              <p>
                                  {{trans('inviteregister.invite_form_description')}}
                               </p>                        
                        </div>
                          <form id="formValidate" action="{{ url('save-invite-register') }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" name="userid" value="{{$userdata->userid}}"/>
                              <input type="hidden" name="companyid" value="{{$companydata->companyid}}"/>
                            <div class="steps-w">
                              <div class="step-triggers">
                                <!--<a class="step-trigger active" href="#stepContent1">Login Information</a>-->
<!--                                <a class="step-trigger" href="#stepContent2">Company Profile</a>
                                <a class="step-trigger" href="#stepContent3">Payment</a>-->
                              </div>
                              <div class="step-contents">                          
                                <div class="step-content active" id="stepContent1">                                   
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('inviteregister.invite_user_first_name_label')}}</label>
                                        <input name="firstname" class="form-control" data-error="{{trans('inviteregister.invite_user_first_name_error')}}" value="{{$userdata->firstname}}"
                                          placeholder="{{trans('inviteregister.invite_user_first_name_placeholder')}}" required="required" type="Name">
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('inviteregister.invite_user_last_name_label')}}</label>
                                        <input name="lastname" class="form-control" data-error="{{trans('inviteregister.invite_user_last_name_error')}}"
                                           placeholder="{{trans('inviteregister.invite_user_last_name_placeholder')}}" value="{{$userdata->lastname}}"
                                          required="required" type="text">
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('inviteregister.invite_user_username_label')}}</label>
                                        <input name="username" class="form-control" data-error="{{trans('inviteregister.invite_user_username_error')}}"
                                          placeholder="{{trans('inviteregister.invite_user_username_placeholder')}}" required="required" type="Username">
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('inviteregister.invite_user_email_label')}}</label>
                                        <input name="email" class="form-control" data-error="{{trans('inviteregister.invite_user_email_error')}}" readonly="readonly"
                                               placeholder="{{trans('inviteregister.invite_user_email_placeholder')}}" value="{{$userdata->email}}"
                                          required="required" type="text">
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('inviteregister.invite_user_password_label')}}</label>
                                        <input name="password" class="form-control" data-error="{{trans('inviteregister.invite_user_password_error')}}" required="required"  
                                        data-minlength="6" placeholder="{{trans('inviteregister.invite_user_password_placeholder')}}" type="password"> 
                                        <p class="charst-sert">{{trans('inviteregister.invite_user_password_instructions')}}</p>                                  
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('inviteregister.invite_user_confirm_password_label')}}</label>
                                        <input class="form-control" data-error="{{trans('inviteregister.invite_user_confirm_password_error')}}" required="required"  
                                        data-minlength="6" placeholder="{{trans('inviteregister.invite_user_confirm_password_placeholder')}}" type="password"> 
                                      </div>
                                    </div>
                                  </div>                                
                                  <div class="form-buttons-w text-right">                                    
                                    <button class="btn btn-primary" type="submit">{{trans('inviteregister.invite_user_save_button_label')}}</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>                        
                      </div>                      
                    </div>
                          <!-- END - login info content area -->
        
      </div>
      <p class="copy-right text-center">
          &copy; Copyright 2018 Artha Platform. All rights reseved.
        </p>
    </div>
    @endsection
