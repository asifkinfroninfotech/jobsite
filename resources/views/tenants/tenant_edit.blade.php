@php
$helper=\App\Helpers\AppHelper::instance();
@endphp

@extends('tenants.layouts.app_layout', ['layout' => 'left_side_menu_tenant'])

<link href="/colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="/colorpicker/dist/css/bootstrap-colorpicker-plus.css" rel="stylesheet">



@section('content')

<div class="content-w investor-profil">
  @include('tenants.shared._top_menu_tenant')
  <div class="content-i">
    <div class="content-box">
      @if((session('helpview')!=null))
      <div class="element-wrapper" id='helpform'>
        <div class="element-box">
          <h5 class="form-header">
            {!!trans('tenant_edit.help_title')!!}
          </h5>
          <div class="form-desc">
            {!!$helper->GetHelpModifiedText(trans('tenant_edit.help_content'))!!}
          </div>
          <div class="element-box-content example-content">
            <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
              {{trans('tenant_edit.help_btn_hide_caption')}}</button>
          </div>
        </div>
      </div>
      @endif
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-4">
          <div class="user-profile compact">

            @php
            $cover_image = asset('/storage/tenant/coverimage/'.$tenant->cover);

            @endphp
            <div class="up-head-w" style="background-image:url({{ $cover_image }})">
              {{-- <div class="up-social">
                <a href="#">
                  <i class="os-icon os-icon-twitter"></i>
                </a>
                <a href="#">
                  <i class="os-icon os-icon-facebook"></i>
                </a>
              </div> --}}
              <div class="up-main-info">
                <h2 class="up-header">
                  {{-- John Bloggs --}}
                  {{$tenant->company}}
                </h2>
                <!--                      <h6 class="up-sub-header">
                        {{trans('investor_company_profile_edit.general_role')}}
                      </h6>-->
              </div>
              <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219" preserveAspectRatio="xMaxYMax meet"
                version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                  <path class="decor-path" d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z"></path>
                </g>
              </svg>
            </div>
            <div class="up-controls">
              <div class="row">
                <div class="col-lg-12">
                  <div class="value-pair">
                    <div class="label">
                      {{trans('tenant_edit.country_label')}}:
                    </div>
                    <div class="value">
                      {{ isset($selectcountry->countryname)?$selectcountry->countryname:"" }}
                    </div>
                  </div>



                  <div class="rianta-img">
                    @if( isset($tenant->logo) && !empty($tenant->logo) &&
                    File::exists(public_path('/storage/tenant/logoimage/'.$tenant->logo)) )

                    <img src="{{ asset('/storage/tenant/logoimage/'.$tenant->logo) }}" class="img-responsive">

                    @else
                    <img src="{{ Avatar::create(ucfirst($tenant->company))->toBase64() }}" style="width:183px;height:61px;"
                      class="img-responsive">
                    @endif
                  </div>

                  {{-- <h5>Mini Logo</h5>

                  <div class="rianta-img">
                    @if( isset($tenant->minilogo) && !empty($tenant->minilogo) &&
                    File::exists(public_path('storage/tenant/minilogoimage/'.$tenant->minilogo)) )

                    <img src="{{ asset('storage/tenant/minilogoimage/'.$tenant->minilogo) }}" class="img-responsive">

                    @else
                    <span>Add a minilogo</span>
                    @endif
                  </div> --}}


                </div>

              </div>
            </div>
          </div>
          <div class="element-wrapper">
            <!--
          start - Logo Image
          -------------------->
            <div class="element-box">
              <h5 class="form-header">
                {{trans('tenant_edit.logo_image_label')}}
              </h5>
              <div class="form-desc">
                {{trans('tenant_edit.logo_content')}}
              </div>
              <form action="{{ url('/savelogoimage') }}" method="POST" enctype="multipart/form-data" class="dropzone"
                id="profile_image">
                {{ csrf_field() }}

                <div class="dz-message">
                  <div>
                    <h4>{{trans('tenant_edit.logo_drop_content')}}</h4>
                  </div>
                </div>
              </form>
            </div>



            <div class="element-box">
              <h5 class="form-header">
                Mini Logo
              </h5>
              <div class="form-desc">
                {{trans('tenant_edit.logo_content')}}
              </div>
              <form action="{{ url('/saveminilogoimage') }}" method="POST" enctype="multipart/form-data" class="dropzone"
                id="minilogoimage">
                {{ csrf_field() }}

                <div class="dz-message">
                  <div>
                    <h4>{{trans('tenant_edit.logo_drop_content')}}</h4>
                  </div>
                </div>
              </form>
            </div>




            <div class="element-box">
              <h5 class="form-header">
                {{trans('tenant_edit.cover_image_label')}}
              </h5>
              <div class="form-desc">
                {{trans('tenant_edit.cover_content')}}
              </div>
              <form action="{{ url('/savecoverimage') }}" method="POST" enctype="multipart/form-data" class="dropzone"
                id="cover_image">
                {{ csrf_field() }}

                <div class="dz-message">
                  <div>
                    <h4>{{trans('tenant_edit.cover_drop_content')}}</h4>
                  </div>
                </div>
              </form>


            </div>


            <div class="element-box">
              <h5 class="form-header">
                {{trans('tenant_edit.profile_image_label')}}
              </h5>
              <div class="form-desc">
                {{trans('tenant_edit.profile_content')}}
              </div>
              <form action="{{ url('/saveprofileimage') }}" method="POST" enctype="multipart/form-data" class="dropzone"
                id="tenantimage">
                {{ csrf_field() }}

                <div class="dz-message">
                  <div>
                    <h4>{{trans('tenant_edit.profile_drop_content')}}</h4>
                  </div>
                </div>
              </form>


            </div>



            <!--------------------
          END - Logo Image
          -------------------->
            <!--------------------
               start - right section video
              -------------------->





            <!--------------------
                  END - right section video
                  -------------------->
            <!--
                  START - Video Upload
                -->


          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-8">
          <div class="element-wrapper">



            <div class="steps-w">


              <h5 class="element-header">
                Tenant Details
              </h5>



              <div class="step-contents">
                <div class="element-box">
                  <form id="formValidate1" method="POST" action="{{url('/update_tenant')}}">
                    {{ csrf_field() }}


                    <!--                          <div class="step-content active" id="stepContent1">-->
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">

                          <label for="">
                            {{trans('tenant_edit.first_name_label')}}
                          </label>
                          <input class="form-control" placeholder="Enter First Name" data-error="Your Name is invalid"
                            required="required" type="text" name="firstname" value="{{old('', $tenant->firstname)}}">
                          <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">

                          <label for="">
                            {{trans('tenant_edit.last_name_label')}}
                          </label>
                          <input class="form-control" placeholder="Enter Last Name" data-error="Your Name is invalid"
                            required="required" type="text" name="lastname" value="{{old('', $tenant->lastname)}}">
                          <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                      </div>
                    </div>






                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="">
                            {{trans('tenant_edit.platform_label')}}
                          </label>
                          <input class="form-control" data-error="platform is required." placeholder="{{trans('tenant_edit.platform_placeholder')}}"
                            required="required" type="text" name="platform" value="{{old('', $tenant->platformname)}}">
                          <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="">
                            {{trans('tenant_edit.email_label')}}
                          </label>
                          <input class="form-control" data-error="Please input your Email" placeholder="Email" required="required"
                            type="email" name="email" value="{{old('', $tenant->email)}}">
                          <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="">
                            {{trans('tenant_edit.password_label')}}
                          </label>
                          <input class="form-control" placeholder="password" data-error="Your password is invalid"
                            required="required" type="password" name="password" value="{{old('',$tenant->password)}}">
                          <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="">
                            {{trans('tenant_edit.confirm_password_label')}}
                          </label>
                          <input class="form-control" placeholder="confirm password" data-error="Your password is invalid"
                            required="required" type="password" name="password" value="{{old('',$tenant->password)}}">
                          <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                      </div>


                    </div>

                    <!--Primary & Secondary color settings -->
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="">
                            {{trans('tenant_edit.primary_color_lbl')}}
                          </label>
                          <!--                                    <select class="form-control" id="primary_combo" name="primary_combo" >
                                     <option value="0">
                                        {{trans('tenant_edit.color_select_text')}}
                                     </option>
                                     @foreach($tenantcolors as $color)
                                      @if($color->type=='primary')  

                                     @if($color->value==$tenant->primarycolor)
                                       <option selected value="{{$color->value}}">
                                          {{$color->text}}
                                        </option>
                                       @else
                                      <option value="{{$color->value}}">
                                        {{$color->text}}
                                      </option>
                                       @endif

                                       @endif 
                                     @endforeach
                                    </select>-->
                          <input type='text' class="form-control" id='demo1' id="primary_combo" name='primary_combo'
                            value="<?php if(isset($tenant->primarycolor) ){echo $tenant->primarycolor;}?>">
                          <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="">
                            {{trans('tenant_edit.secondary_color_lbl')}}
                          </label>
                          <!--                                    <select class="form-control" id="secondary_combo" name="secondary_combo" >
                                      <option value="0">
                                         {{trans('tenant_edit.color_select_text')}}
                                      </option>
                                      @foreach($tenantcolors as $color)
                                       @if($color->type=='secondary')  
 
                                      @if($color->value==$tenant->secondarycolor)
                                        <option selected value="{{$color->value}}">
                                           {{$color->text}}
                                         </option>
                                        @else
                                       <option value="{{$color->value}}">
                                         {{$color->text}}
                                       </option>
                                        @endif
 
                                        @endif 
                                      @endforeach
                                     </select>-->
                          <input type='text' class="form-control" id='demo2' id="secondary_combo" name='secondary_combo'
                            value="<?php if(isset($tenant->secondarycolor)){echo $tenant->secondarycolor;}?>">
                          <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                      </div>
                    </div>
                    <!--Primary & Secondary color settings end here.-->







                    <div class="form-buttons-w text-right">
                      <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                      <!--                              <a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Previous</a>-->
                    </div>
                  </form>
                </div>



                <!--                            <div class="form-buttons-w text-right">
                              <input class="btn btn-primary" type="submit" name="user_info" value="Save"> 
                              <a class="btn btn-primary step-trigger-btn" href="#stepContent2">{{trans('tenant_edit.btn_next_lbl')}}</a>
                            </div>-->
                <!--                          </div>-->
                <!--                          <div class="step-content" id="stepContent2">-->


                <h5 class="element-header">
                  Company Details
                </h5>
                <div class="element-box">
                  <form id="formValidate2" method="POST" action="{{url('/update_tenant_company')}}">
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="">
                            {{trans('tenant_edit.company_label')}}
                          </label>
                          <input class="form-control" placeholder="Enter Company Name" type="text" name="companyname"
                            value="{{old('', $tenant->company)}}">
                        </div>
                      </div>
                      {{-- <div class="col-sm-6">
                        <div class="form-group">
                          <label for="">
                            {{trans('tenant_edit.email_label')}}
                          </label>
                          <input class="form-control" placeholder="Email" type="email" name="companyemail" value="{{old('', $tenant->companyemail)}}">
                        </div>
                      </div> --}}
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="">
                            {{trans('tenant_edit.telephone_label')}}
                          </label>
                          <input class="form-control" placeholder="Telephone" type="text" name="telephone" value="{{old('', $tenant->phone)}}">
                        </div>



                      </div>

                    </div>


                    <div class='row'>

                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="">
                            {{trans('tenant_edit.address_label')}}
                          </label>
                          <input class="form-control" placeholder="Address" type="text" name="address" value="{{old('', $tenant->address)}}">
                        </div>


                      </div>


                    </div>



                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for=""> {{trans('tenant_edit.country_label')}}</label>
                          <select class="form-control" onchange="selectstate(this.value);" name="companycountry">
                            <option>
                              Select
                            </option>

                            @foreach($country as $country)
                            @if($country->countryid==$tenant->country)
                            <option value="{{$country->countryid}}" selected>{{$country->name}}</option>
                            @else
                            <option value="{{$country->countryid}}">{{$country->name}}</option>
                            @endif



                            @endforeach
                            <!--                                                <option>
                                                  New York
                                                </option>
                                                <option>
                                                  California
                                                </option>
                                                <option>
                                                  Boston
                                                </option>
                                                <option>
                                                  Texas
                                                </option>
                                                <option>
                                                  Colorado
                                                </option>-->
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="">{{trans('tenant_edit.state_label')}} </label>
                          <!--                                            <input class="form-control" placeholder="State  / Region" type="text" name="companystate">-->

                          <select class="form-control" placeholder="State  / Region" name="companystate" id="companystate"
                            onchange="selectcity(this.value);">

                          </select>

                        </div>
                      </div>

                      <input type="hidden" id="companystatehidden" name="countrystatehidden" value="">
                      <input type="hidden" id="countrycityhidden" name="countrycityhidden" value="">
                    </div>


                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for=""> {{trans('tenant_edit.city_label')}}</label>
                          <!--                                          <input class="form-control" placeholder="City" type="text" name="companycity">-->

                          <input class="form-control" type="text" placeholder="City" name="companycity" id="companycity"
                            value="{{old('', $tenant->city)}}">






                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for=""> {{trans('tenant_edit.zip_label')}}</label>
                          <input class="form-control" placeholder="Postcode / Zip" type="text" name="companypostcode"
                            value="{{old('', $tenant->postcode)}}">
                        </div>
                      </div>
                    </div>
                    <div class="form-buttons-w text-right">
                      <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                      <!--                              <a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Previous</a>-->
                    </div>
                  </form>
                </div>


                <!--                            <div class="form-buttons-w text-right">
                              <a class="btn btn-primary step-trigger-btn" href="#stepContent3"> Next</a>
                              <a class="btn btn-primary step-trigger-btn" href="#stepContent1"> Previous</a>
                            </div>
                          </div>-->


                <!--                              <div class="step-content" id="stepContent3">-->
                <!--                                <h5 class="element-header">-->
                <!--                           Card Details
                          </h5>
<div class="element-box">
    <form id="formValidate3" method="POST" action="{{url('/update_tenant_card')}}" >
                             {{ csrf_field() }} 
                                                                    <div class="row payment-card-img">
                                      <div class="col-sm-12">
                                        <div class="form-group">
                                          <label for=""> {{trans('tenant_edit.accept_card_content')}}</label>
                                          <img src="img/payment-img.jpg" />
                                        </div>
                                      </div>                                   
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-12">
                                      <div class="form-group">
                                        <label for=""> {{trans('tenant_edit.card_name_lbl')}} </label>
                                        <input type="hidden" name="talenthiddenid3" id="talenthiddenid3" value="">
                                        <input class="form-control" data-error="Your Card Name is invalid"
                                          placeholder="Name on card" required="required" type="Name" name="cardname" value="{{old('', $tenant->cardname)}}">
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>                                   
                                  </div>
                                  <div class="row">
                                      <div class="col-sm-12">
                                      <div class="form-group">
                                        <label for=""> {{trans('tenant_edit.card_number_lbl')}}</label>
                                        <input class="form-control" data-error="Your Card Number is invalid"
                                          placeholder="... ... ... ..." required="required" type="Name" name="cardnumber" value="{{old('', $tenant->cardnumber)}}">
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>  
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('tenant_edit.expiry_lbl')}}</label>
                                        <input class="form-control" data-error="Your Expiry MM/YY is invalid" required="required"  
                                        placeholder="MM/YY" type="text" name="cardexpiry" value="{{old('', $tenant->expiry)}}"> 
                                        <p class="charst-sert">Minimum of 6 characters</p>                                  
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('tenant_edit.card_code_lbl')}}</label>
                                        <input class="form-control" data-error="Your Card Code is invalid" required="required"  
                                        placeholder="CVC" type="text" name="cardcode" value="{{old('', $tenant->cvv)}}"> 
                                       
                                      </div>
                                    </div>
                                  </div> 
                                  
                                    <div class="form-buttons-w text-right">
                              <input class="btn btn-primary" type="submit" name="user_info" value="Save"> 
                              <a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Previous</a>
                            </div>
                                  
                                  
                                  
                                  
                               </div>
                            
                            </form>
                           </div> -->

                <h5 class="element-header">
                  Email Settings
                </h5>
                <div class="element-box">
                  <form id="formValidate3" method="POST" action="{{url('/update_email_settings')}}">
                    {{ csrf_field() }}

                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for=""> {{trans('tenant_edit.from_name_lbl')}} </label>

                          <input class="form-control" data-error="From name must not be empty" placeholder="From Name"
                            required="required" type="text" name="from_name" value="{{old('', $tenant->from_name)}}">
                          <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for=""> {{trans('tenant_edit.from_email_lbl')}} </label>

                          <input class="form-control" data-error="From email must not be empty" placeholder="From Email"
                            required="required" type="text" name="from_email" value="{{old('', $tenant->from_email)}}">
                          <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for=""> {{trans('tenant_edit.privacy_policy_lbl')}} </label>

                          <input class="form-control" data-error="Privacy policy link must not be empty" placeholder="Privacy Policy Link"
                            required="required" type="text" name="privacy_policy_link" value="{{old('', $tenant->privacy_policy_link)}}">
                          <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="">{{trans('tenant_edit.contact_us_lbl')}}</label>
                          <input class="form-control" data-error="Contact Us link must not be empty" required="required"
                            placeholder="Contact Us Link" type="text" name="contact_us_link" value="{{old('', $tenant->contact_us_link)}}">

                        </div>
                      </div>
                    </div>

                    <div class="form-buttons-w text-right">
                      <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                      <!--                              <a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Previous</a>-->
                    </div>




                    <!--                               </div>-->

                  </form>
                </div>

                <h5 class="element-header">
                  {{trans('tenant_complete_profile.set_languages_heading')}}
                </h5>
                <div class="element-box">
                  <form id="formValidate4" method="POST" action="{{url('/update_languages')}}">
                    {{ csrf_field() }}

                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group ful-wdth-select {{ $errors->has('primarylogin') ? 'has-error' : '' }}">
                          <label for="">{{trans('tenant_complete_profile.primary_login_label')}}</label>

                          <select class="form-control select2" name="primarylogin[]" id="primary" onchange="secondaryunselect();">
                            @if(isset($primarylanguagetodisplay))
                            @foreach($primarylanguagetodisplay as $languagetodisplay)
                            <option value='{{ $languagetodisplay->locale }}' <?php
                              if(isset($primaryinput)){foreach($primaryinput as $primary){if($primary->language==$languagetodisplay->locale){echo
                              'selected';}}}?>
                              >
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
                              @foreach($secondarylanguagetodisplay as $secondary1)
                              <option value="{{$secondary1->locale}}" <?php
                                if(isset($secondaryinput)){foreach($secondaryinput as $secondary){if($secondary->language==$secondary1->locale){echo
                                'selected';}}}?>

                                >{{$secondary1->locale}}</option>
                              @endforeach
                              @endif
                            </select>
                          </div>
                          <!--                       <input type='text' class="form-control"  name='secondarylogin' value='{{ old('secondarylogin') }}<?php if(isset($data[0]->secondarylogin) ){echo $data[0]->secondarylogin;}?>'>-->
                        </div>
                        {{-- <span class="text-danger">{{ $errors->first('secondarycolor') }}</span> --}}
                      </div>
                    </div>


                    <div class="form-buttons-w text-right">
                      <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                      <!--                              <a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Previous</a>-->
                    </div>




                    <!--                               </div>-->

                  </form>
                </div>





              </div>
            </div>






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
      {{-- <div class="floated-chat-btn">
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
      </div> --}}
      <!--
              END - Chat Popup Box
              -->
    </div>

  </div>
</div>

<script>





</script>



@endsection

@section('scripts')



<script src="/colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="/colorpicker/dist/js/bootstrap-colorpicker-plus.js"></script>
<script type="text/javascript">
  $(document).ready(function () {

    var c1 = $('#demo1').val();
    if (c1 != '') {
      $('#demo1').val(c1).css('background-color', c1);
    }

    var c2 = $('#demo2').val();
    if (c2 != '') {
      $('#demo2').val(c2).css('background-color', c2);
    }

  });

  $(function () {
    var demo1 = $('#demo1');
    demo1.colorpickerplus();
    demo1.on('changeColor', function (e, color) {
      if (color == null)
        $(this).val('transparent').css('background-color', '#fff'); //tranparent
      else
        $(this).val(color).css('background-color', color);
    });


    var demo2 = $('#demo2');
    demo2.colorpickerplus();
    demo2.on('changeColor', function (e, color) {
      if (color == null)
        $(this).val('transparent').css('background-color', '#fff'); //tranparent
      else
        $(this).val(color).css('background-color', color);
    });




  });
</script>



<script type="text/javascript">
  var tenantstate = "{{$tenant->country}}";
  var tenantcity = "{{$tenant->state}}";

  if (tenantstate.length > 0) {
    debugger;
    selectstate(tenantstate);
  }



  function selectstate(state) {
    var url = '/getstate?countryid=' + state;
    ajaxLoad(url);

    //  setTimeout(function() {
    //  var city=$("#companystate option:selected").val();
    //   selectcity(city);
    //   }, 2000);

  }

  function ajaxLoad(filename) {

    $.ajax({
      type: "GET",
      url: filename,
      contentType: false,

      success: function (data) {




        if (data.states == 'getstate') {
          $('#companystate').html("");
          $('#companystate').html(data.view);
          $('#companystate').val(tenantcity);
        }


        //   if(data.states=='getcity')  
        //   {
        //  $('#companycity').html("");
        //  $('#companycity').html(data.view);
        //  $('#companystatehidden').val(data.stateid);
        //   }
        if (data.states == 'button') {
          if (data.button == 0) {
            $('#confirmpay').addClass("disabled");
          }
          if (data.button == 1) {
            $('#confirmpay').removeClass("disabled");
          }
        }
        // if(data.states=='payment')
        // {
        //     //alert(data.price);
        // }
      },
      error: function (xhr, status, error) {
        alert(xhr.responseText);
      }
    });
  }
</script>

<script>
  var primary = $('#primary').val();
  $.get('/getsecondaryvalues?multi=' + primary, function (data) {
    $('#secondary').html(data);
  });

  function secondaryunselect() {
    var multivalues = $('#primary').val();

    $.get('/getsecondaryvalues?multi=' + multivalues, function (data) {
      $('#secondary').html(data);
    });


  }
</script>



@endsection