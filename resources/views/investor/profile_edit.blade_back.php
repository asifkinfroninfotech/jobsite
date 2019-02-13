@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')

 <div class="content-w investor-profil" ng-app="myApp">
        @include('shared._top_menu')
         <div class="content-i">
          <div class="content-box">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-4">
                <div class="user-profile compact">
                  
                @php
                  $cover_image = asset('storage/company/coverimage/'.$data['company_information']->coverimage);
                @endphp
                <div class="up-head-w" style="background-image:url({{ $cover_image }})">
                    <div class="up-social">
                      <a href="#">
                        <i class="os-icon os-icon-twitter"></i>
                      </a>
                      <a href="#">
                        <i class="os-icon os-icon-facebook"></i>
                      </a>
                    </div>
                    <div class="up-main-info">
                      <h2 class="up-header">
                        John Bloggs
                      </h2>
                      <h6 class="up-sub-header">
                        {{trans('frontend/investor/company/edit.general.role')}}
                      </h6>
                    </div>
                    <svg class="decor" width="842px" height="219px".editBox="0 0 842 219" preserveAspectRatio="xMaxYMax meet" version="1.1" xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink">
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
                            {{trans('frontend/investor/company/edit.general.country')}}
                          </div>
                          <div class="value">
                            Switzerland
                          </div>
                        </div>
                        @php
                        $profile_image = asset('storage/company/profileimage/'.$data['company_information']->profileimage);
                      @endphp
                        <div class="rianta-img">
                          <img src="{{ $profile_image  }}" style="height:200px;width:309px" class="img-responsive">
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="element-wrapper">
                  <!--------------------
          start - Logo Image
          -------------------->
                  <div class="element-box">
                    <h5 class="form-header">
                      {{trans('frontend/investor/company/edit.general.logo_title')}}
                    </h5>
                    <div class="form-desc">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit
                    </div>
                    <form action="{{ route('company.cover.logo.image.store') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="profile_image" >
                      {{ csrf_field() }}
                     <input type="hidden" name="profile_image" value="profile_image"> 
                      <div class="dz-message">
                        <div>
                          <h4>{{trans('frontend/investor/company/edit.general.drag_and_drop')}}</h4>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="element-box">
                    <h5 class="form-header">
                      {{trans('frontend/investor/company/edit.general.cover_image_title')}}
                    </h5>
                    <div class="form-desc">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit
                    </div>
                     <form action="{{ route('company.cover.logo.image.store') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="cover_image">
                      {{ csrf_field() }}
                      <input type="hidden" name="cover_image" value="cover_image">
                      <div class="dz-message">
                        <div>
                          <h4>{{trans('frontend/investor/company/edit.general.drag_and_drop')}}</h4>
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
                  <div class="video-rit">
                    <div class="element-wrapper">
                      <h6 class="element-header">
                        <h4>{{trans('frontend/investor/company/edit.general.video')}}</h4>
                      </h6>
                      <div class="element-box">
                        <div class="el-chart-w">
                          <a class="video-play" data-target="#onboardingWideFeaturesModal" data-toggle="modal">
                            @php
                             $video_path = false;
                             if($data['videofile'] != null) {
                              $video_path = asset('storage/company/videos/'.$data['videofile']->videopath);
                             }
                            @endphp
                            <img src="{{asset('img/video-test.jpg')}}" alt="Play Video" class="img-responsive" />
                          </a>
                          <div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingWideFeaturesModal" role="dialog" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-centered" role="document">
                              <div class="modal-content text-center">
                                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                  <span class="close-label">Skip Intro</span>
                                  <span class="os-icon os-icon-close"></span>
                                </button>
                                <div class="onboarding-side-by-side">
                                  <div class="onboarding-content with-full">
                                    @if($video_path)
                                      <iframe width="100%" height="400" src="{{asset($video_path)}}" frameborder="0"></iframe>
                                    @else
                                      {{ "No Video Found, Please Upload Video !!!" }}
                                    @endif
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
                  END - right section video
                  -------------------->
                  <!--
                  START - Video Upload
                -->
                  <div class="element-box">
                    <h5 class="form-header">
                      <h4>{{trans('frontend/investor/company/edit.general.video_upload_caption')}}</h4>
                    </h5>
                    <div class="form-desc">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit
                    </div>
                    <form action="{{ route('company.video.store') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="my-video">
                      {{ csrf_field() }}
                      <div class="dz-message">
                        <div>
                          <h4>{{trans('frontend/investor/company/edit.general.drag_and_drop')}}</h4>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!--
                     END - Video Upload
                     -->
               
              </div>
              </div>
              <div class="col-sm-12 col-md-12 col-lg-8">
                <div class="element-wrapper">
                  <div class="element-box">

                    <form id="formValidate" method="POST" action="{{ route('company.profile.update') }}" >
                      {{ csrf_field() }}
                      <div class="steps-w">
                        <div class="step-triggers">
                          <a class="step-trigger active" href="#stepContent1">
                          {{trans('frontend/investor/company/edit.general.company_caption')}}
                          </a>
                          <a class="step-trigger" href="#stepContent2">
                          {{trans('frontend/investor/company/edit.investment.caption')}}
                          </a>
                        </div>
                        <div class="step-contents">
                          <div class="step-content active" id="stepContent1">
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="form-group">

                                  <label for="">
                                  {{trans('frontend/investor/company/edit.general.company_name')}}
                                  </label>
                                  <input class="form-control" placeholder="Enter Name"
                                    data-error="Your Name is invalid" required="required" type="text" name="company_name" value="{{old('', $data['company_information']->name)}}">
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.general.email')}}
                                  </label>
                                  <input class="form-control" data-error="Your email address is invalid"
                                    placeholder="Enter email" required="required" type="email" name="email" value="{{old('', $data['company_information']->email)}}">
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.general.telephone')}}
                                  </label>
                                  <input class="form-control" data-error="Please input your Telephone" placeholder="Telephone"
                                    required="required" data-minlength="12" type="text" name="telephone" value="{{old('', $data['company_information']->telephone)}}">
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="">
                                {{trans('frontend/investor/company/edit.general.website')}}
                              </label>
                              <input class="form-control" placeholder="Website URL" data-error="Your Website URL is invalid"
                                required="required" type="text" name="website" 
                                value="{{old('',$data['company_information']->website)}}">
                              <div class="help-block form-text with-errors form-control-feedback"></div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.general.skype')}}
                                  </label>
                                  <input class="form-control" data-error="Please input your Skype ID" placeholder="Skype ID"
                                    type="text"  required="required" name="skype" 
                                    value="{{ old('', $data['company_information']->skype) }}">
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.general.twitter')}}
                                  </label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        @
                                      </div>
                                    </div>
                                    <input class="form-control" placeholder="Twitter Username" type="text" name="twitter" value="{{old('', $data['company_information']->twitter)}}">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="">
                                {{trans('frontend/investor/company/edit.general.address')}}
                              </label>
                              <input class="form-control" type="text" name="address" value="{{old('', $data['company_information']->address)}}">
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.general.city')}}
                                  </label>
                                  <input class="form-control" placeholder="City" type="text" name="city" value="{{old('', $data['company_information']->city)}}">
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.general.postcode')}}
                                  </label>
                                  <input class="form-control" placeholder="Postcode / Zip" type="text" name="zip" value="{{old('', $data['company_information']->zip)}}">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.general.country')}}
                                  </label>
                                  <select class="form-control" name="country" id="country" placeholder="Country">
                                    @if(isset($data['countries']['total_countries']))
                                      @foreach($data['countries']['total_countries'] as $country)
                                       <option value="{{ $country->countryid }}"
                                        @isset( $data['countries']['selected_country']->countryid )
                                         {{ 
                                           ( $country->countryid == $data['countries']['selected_country']->countryid ) ? 
                                            "selected='selected'" : ''
                                          }}
                                        @endisset
                                        >{{ $country->name }}</option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.general.state')}}
                                  </label>
                                   <select name="state" id="state" class="form-control" placeholder="State  / Region" >
                                     @if(isset($data['states']['total_states']))
                                      @foreach($data['states']['total_states'] as $state)
                                       <option value="{{ $state->stateid }}"
                                        @isset( $data['states']['selected_state']->stateid )
                                         {{
                                           ( $state->stateid == $data['states']['selected_state']->stateid ) ? 
                                            "selected='selected'" : ''
                                          }}
                                        @endisset
                                        >{{ $state->name }}
                                       </option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                              </div>
                            </div>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                            <script type="text/javascript">
                            $(document).ready(function() {
                              $('#country').change(function() {
                              var countryID = $(this).val();  
                              if(countryID) {
                                  $.ajax({
                                     headers: {
                                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                     },
                                     type:"GET",
                                     url: "/api/get-state-list", 
                                     data : {
                                          'country_id' : countryID
                                     },
                                     success:function(res) {               
                                      if(res){
                                          $("#state").empty();
                                          $("#state").append('<option>Select</option>');
                                          $.each(res,function(key,value){
                                              $("#state").append('<option value="'+ value.stateid +'">' + value.name + '</option>');
                                          });
                                     
                                      } else {
                                         $("#state").empty();
                                      }
                                     },
                                     error:function(res){
                                       console.log(res);
                                    },
                                  });
                              } else {
                                  $("#state").empty();
                                 
                                  }      
                               });
                            });  
                          </script>
                            <div class="form-buttons-w text-right">
                              <input class="btn btn-primary" type="submit" name="user_info" value="Save"> 
                              <a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Next</a>
                            </div>
                          </div>
                          <div class="step-content" id="stepContent2">
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                  {{trans('frontend/investor/company/edit.investment.years_in_impact_investing')}}
                                  </label>
                                  <input class="form-control" placeholder="Years In Impact Investing"
                                    type="text" name="yearsinvolved" value="{{old('', $data['company_information']->yearsinvolved)}}">
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.investment.number_of_investments_to_date')}}
                                  </label>
                                  <input class="form-control" placeholder="No of Investments to Date"
                                    type="text" name="numbertodate" value="{{old('', $data['company_information']->numbertodate)}}">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                     {{trans('frontend/investor/company/edit.investment.preferred_avg_investment_size')}}
                                  </label>
                                   <select class="form-control" name="preferedinvestmentaveragesize">
                                    <option value="" disabled selected>Select</option>
                                    @if(isset($data['averageinvestmentsizes']))
                                      @foreach($data['averageinvestmentsizes'] as $averageinvestmentsize)
                                       <option value="{{ $averageinvestmentsize->investmentsize }}"
                                        @isset($data['company_information']->preferedinvestmentaveragesize) 
                                        {{
                                           ($data['company_information']->preferedinvestmentaveragesize == $averageinvestmentsize->investmentsize) ? "selected =='selected' " : ''
                                        }}
                                        @endisset
                                        >{{ $averageinvestmentsize->investmentsize }}</option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.investment.funds_under_management')}}
                                  </label>
                                  <select class="form-control" name="fundsundermanagement">
                                    <option value="" disabled selected>Select</option>
                                    @if(isset($data['fundsundermanagement']))
                                      @foreach($data['fundsundermanagement'] as $fundsundermanagement)
                                       <option value="{{ $fundsundermanagement->fund }}"
                                        @isset($data['company_information']->fundsundermanagement) 
                                        {{
                                           ($data['company_information']->fundsundermanagement == $fundsundermanagement->fund) ? "selected =='selected' " : ''
                                        }}
                                        @endisset
                                        >{{ $fundsundermanagement->fund }}</option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.investment.typical_level_of_involvement')}}
                                  </label>
                                  <select class="form-control" name="levelofinvolvement">
                                    <option value="" disabled selected>Select</option>
                                    @if(isset($data['levelofinvolvement']))
                                      @foreach($data['levelofinvolvement'] as $levelofinvolvement)
                                       <option value="{{ $levelofinvolvement->involvementlevel }}"
                                         @isset($data['company_information']->levelofinvolvement) 
                                        {{
                                           ($data['company_information']->levelofinvolvement == $levelofinvolvement->involvementlevel) ? "selected =='selected' " : ''
                                        }}
                                        @endisset
                                        >{{ $levelofinvolvement->involvementlevel }}
                                      </option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.investment.number_of_employees')}}
                                  </label>
                                  <input class="form-control" name="numberofemployees" placeholder="No of Employees" type="text" value="{{old('', $data['company_information']->numberofemployees)}}">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.investment.invest_on_behalf_of_institution')}}
                                  </label>
                                  <select class="form-control" name="isonbehalfofinstitution">
                                    <option value="" disabled selected>Select</option>
                                    <option value=1 
                                    @isset($data['company_information']->isonbehalfofinstitution) 
                                        {{
                                           ($data['company_information']->isonbehalfofinstitution == 1) ? "selected =='selected' " : ''
                                        }}
                                    @endisset >
                                      Yes
                                    </option>
                                    <option value=0 
                                    @isset($data['company_information']->isonbehalfofinstitution) 
                                        {{
                                           ($data['company_information']->isonbehalfofinstitution == 0) ? "selected =='selected' " : ''
                                        }}
                                    @endisset >
                                      No
                                    </option>
                                    
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">
                                    {{trans('frontend/investor/company/edit.investment.tax_id')}}
                                  </label>
                                  <input class="form-control" name="taxidnumber" placeholder="Tax Id Number" type="text" value="{{ old('', $data['company_information']->taxidnumber) }}">
                                </div>
                              </div>
                            </div>
                            <div class="form-group ful-wdth-select">
                            <label for="">
                          {{trans('frontend/investor/company/edit.investment.sector_of_specialization')}}
                            </label>
                            <select class="form-control select2" name="specializedsectors">
                                
                                    @if(isset($data['sectors']))
                                      @foreach($data['sectors'] as $sectors)
                                       <option value="{{ $sectors->name }}"
                                         @isset($data['company_information']->specializedsectors) 
                                        {{
                                           ($data['company_information']->specializedsectors == $sectors->name) ? "selected =='selected' " : ''
                                        }}
                                        @endisset
                                        >{{ $sectors->name }}
                                      </option>
                                      @endforeach
                                    @endif
                              </select>
                            </div>
                            <div class="form-group">
                              <label>
                                {{trans('frontend/investor/company/edit.general.mission')}}
                              </label>
                              <textarea class="form-control" name="mission" rows="3">{{ old('',$data['company_information']->mission) }}</textarea>
                            </div>
                            <div class="form-group">
                              <label> 
                                {{trans('frontend/investor/company/edit.investment.intended_investment_outcomes')}}
                              </label>
                              <textarea class="form-control" name="outcomes" rows="3">{{ old('',$data['company_information']->outcomes) }}</textarea>
                            </div>
                            <div class="form-buttons-w text-right">
                              <input class="btn btn-primary" type="submit" name="user_info" value="Save"> 
                              <a class="btn btn-primary step-trigger-btn" href="#stepContent1"> Previous</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="element-wrapper margin-top">
                    <!--------------------
                    START - documents table 
                    -------------------->
                    <h5 class="element-header">
                      Documents
                    </h5>
                    <div class="element-box table-rit-section">
                      <h5 class="form-header">
                        {{trans('frontend/investor/company/edit.documents.public.caption')}}
                      </h5>
                      <div class="form-desc">This virtual filing cabinet is a space for you to upload any materials (including brochures, summaries) that
                        support the communication of your core activity </div>
                      <div class="controls-above-table">
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                              <form action="{{ route('company.document.store')}}" method="POST" enctype="multipart/form-data" class="dropzone" id="upload-files">
                               {{ csrf_field() }}
                               <input type="hidden" name="public_documents" value="public_documents" />
                               <div class="dz-message">
                             <div>
                                  <h4>{{trans('frontend/investor/company/edit.general.drag_and_drop')}}</h4>
                                </div>
                              </div>
                            </form>
                            
                             <!-- <a  class="btn btn-sm btn-primary" href="#">Upload</a> -->
                                <a class="btn btn-sm btn-danger" href="#">Delete</a>
                            </div>
                          <div class="col-sm-12 col-lg-8 filter-moble">
                            <form>
                               <!-- <input id="public_document" onkeyup="publicDocuments()" class="form-control form-control-sm rounded bright" placeholder="Search" type="text"> -->
                              <input ng-model='public_search.documentname' class="form-control form-control-sm rounded bright" placeholder="Search" type="text">
                              <select ng-model='sortByPublic' class="form-control form-control-sm rounded bright">
                                <option selected="selected" value="">
                                  {{trans('frontend/investor/company/edit.documents.public.sort')}}
                                </option>
                              <option value="documentname">File Name </option>
                              <option value="extention">Type</option>
                              <option value="updated" >Date</option>
                             </select>
                              <!-- <select class="form-control form-control-sm rounded bright">
                                <option selected="selected" value="">
                                  {{--trans('frontend/investor/company/edit.documents.public.sort')--}}
                                </option>
                                <option value="Pending">
                                  Name
                                </option>
                                <option value="Active">
                                  Type
                                </option>
                                <option value="Cancelled">
                                  Date
                                </option>
                              </select> -->
                              <select ng-model='filterByExt' class="form-control form-control-sm rounded bright">
                                <option selected="selected" value="">
                                  {{trans('frontend/investor/company/edit.documents.public.select_filter_type')}}
                                </option>
                                <option value="txt">
                                  txt
                                </option>
                                <option value="jpg">
                                  jpg
                                </option>
                                <option value="png">
                                  png 
                                </option>
                                <option value="xls">
                                  xls
                                </option>
                                 <option value="xlsx">
                                  xlsx
                                </option>
                                <option value="pdf">
                                  pdf
                                </option>
                              </select>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="table-responsive table-responsive-heading-spce">
                        <table class="table table-lightborder"  ng-controller="document">
                          <thead>
                            <tr>
                        <th class="name">
                          {{trans('frontend/investor/company/edit.documents.public.table.name')}}
                        </th>
                        <th class="type">
                          {{trans('frontend/investor/company/edit.documents.public.table.type')}}
                        </th>
                        <th class="format">
                          {{trans('frontend/investor/company/edit.documents.public.table.format')}}
                        </th>
                        <th class="date">
                          {{trans('frontend/investor/company/edit.documents.public.table.date')}}
                        </th>
                        <th class="action">
                          {{trans('frontend/investor/company/edit.documents.public.table.action')}}
                        </th>
                      </tr>
                          </thead>
                          <tbody  id="public_document_table"> 
                            
                            <tr ng-if="public.documentstatus == 'Public' " ng-repeat="public in names | filter:public_search | filter:filterByExt | orderBy: sortByPublic">              
                            @verbatim
                            <td><a href="#"><input class="form-control" type="checkbox"> {{ ::public.documentname }}</a></td>
                            <td><a href="#">{{ ::public.extention }}</a></td>
                            <td><a href="#">{{ ::public.extention }}</a></td>
                            <td><a href="#">{{ ::public.updated }}</a></td>
                             @endverbatim
                             <td>
                                  <a href="#">
                                   <i class="os-icon os-icon-signs-11"></i>
                                  </a>
                                </td> 
                             </tr>
                           <!--  @if($data['documents']->isNotEmpty())

                              @foreach($data['documents'] as $document)
                               @if($document->documentstatus == 'Public')
                              <tr>
                              <td>
                                  <input class="form-control" type="checkbox">
                                  <a href= {{-- '/deal_documents/' --}} />{{-- $document->documentname --}}
                              </td>
                                 
                                <td>
                                    <a href= {{-- '/deal_documents/'--}} />{{-- $document->extention --}}
                                </td>
                                <td>
                                    <a href= {{-- '/deal_documents/' --}} />{{-- $document->extention --}}
                                </td>  
                                <td>
                                    <a href= {{-- '/deal_documents/' --}} />{{-- $document->updated --}}
                                </td>  
                                <td>
                                  <a href="#">
                                   <i class="os-icon os-icon-signs-11"></i>
                                  </a>
                                </td> 
                                 </a></td>
                              </tr>
                              @endif
                              @endforeach 
                            @endif
 -->

                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="element-box table-rit-section">
                      <h5 class="form-header">
                        {{trans('frontend/investor/company/edit.documents.private.caption')}}
                      </h5>
                      <div class="form-desc">This virtual filing cabinet is a space for you to upload any materials (including brochures, summaries) that
                        support the communication of your core activity </div>
                      <div class="controls-above-table">
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                               <form action="{{ route('company.document.store')}}" method="POST" enctype="multipart/form-data" class="dropzone" id="upload-files">
                               {{ csrf_field() }}
                               <input type="hidden" name="private_documents" value="private_documents" />
                               <div class="dz-message">
                             <div>
                                  <h4>{{trans('frontend/investor/company/edit.general.drag_and_drop')}}</h4>
                                </div>
                              </div>
                            </form>
                                <!-- <a class="btn btn-sm btn-primary" href="#">Upload</a> -->
                                <a class="btn btn-sm btn-danger" href="#">Delete</a>
                              </div>
                          <div class="col-sm-12 col-lg-8 filter-moble">
                            <form class="form-inline justify-content-sm-end">
                              <!-- <input  id="private_document" onkeyup="privateDocuments()"class="form-control form-control-sm rounded bright" placeholder="Search" type="text">
                              <select class="form-control form-control-sm rounded bright">
                                <option selected="selected" value="">
                                  {{trans('frontend/investor/company/edit.documents.private.sort')}}
                                </option>
                                <option value="Pending">
                                  Name
                                </option>
                                <option value="Active">
                                  Type
                                </option>
                                <option value="Cancelled">
                                  Date
                                </option>
                              </select> -->
                              <input ng-model='private_search.documentname' class="form-control form-control-sm rounded bright" placeholder="Search" type="text">
                              <select ng-model='sortByPrivate' class="form-control form-control-sm rounded bright">
                                <option selected="selected" value="">
                                  {{trans('frontend/investor/company/edit.documents.private.sort')}}
                                </option>
                              <option value="documentname">File Name </option>
                              <option value="extention">Type</option>
                              <option value="updated" >Date</option>
                             </select>
                              <select ng-model='privateFilterByExt' class="form-control form-control-sm rounded bright">
                                <option selected="selected" value="">
                                  {{trans('frontend/investor/company/edit.documents.public.select_filter_type')}}
                                </option>
                                <option value="txt">
                                  txt
                                </option>
                                <option value="jpg">
                                  jpg
                                </option>
                                <option value="png">
                                  png 
                                </option>
                                <option value="xls">
                                  xls
                                </option>
                                 <option value="xlsx">
                                  xlsx
                                </option>
                                <option value="pdf">
                                  pdf
                                </option>
                              </select>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="table-responsive table-responsive-heading-spce">
                        <table class="table table-lightborder" ng-controller="document">
                          <thead>
                            <tr>
                        <th class="name">
                          {{trans('frontend/investor/company/edit.documents.private.table.name')}}
                        </th>
                        <th class="type">
                          {{trans('frontend/investor/company/edit.documents.private.table.type')}}
                        </th>
                        <th class="format">
                          {{trans('frontend/investor/company/edit.documents.private.table.format')}}
                        </th>
                        <th class="date">
                          {{trans('frontend/investor/company/edit.documents.private.table.date')}}
                        </th>
                        <th class="action">
                          {{trans('frontend/investor/company/edit.documents.private.table.action')}}
                        </th>
                      </tr>
                          </thead>
                          <tbody id="private_document_table">
                            <tr ng-if="private.documentstatus == 'Private' " ng-repeat="private in names | filter:private_search |
filter:privateFilterByExt | orderBy: sortByPrivate">
                             <td><input class="form-control" type="checkbox"><a href="#">@{{ private.documentname }}</a></td>
                             <td><a href="#">@{{ private.extention }}</a></td>
                             <td><a href="#">@{{ private.extention }}</a></td>
                             <td><a href="#">@{{ private.updated }}</a></td>
                             <td>
                                  <a href="#">
                                   <i class="os-icon os-icon-signs-11"></i>
                                  </a>
                                </td> 
                             </tr>
                            <!-- @if($data['documents']->isNotEmpty())
 
                              @foreach($data['documents'] as $document)
                              @if($document->documentstatus == 'Private')
                              <tr>  
                              <td>
                                  <input class="form-control" type="checkbox">
                                  <a href= {{ '/deal_documents/'}} />{{ $document->documentname }}
                              </td>
                                 
                                <td>
                                    <a href= {{ '/deal_documents/'}} />{{ $document->extention }}
                                </td>
                                <td>
                                    <a href= {{ '/deal_documents/'}} />{{ $document->extention }}
                                </td>  
                                <td>
                                    <a href= {{ '/deal_documents/'}} />{{ $document->updated }}
                                </td>  
                                <td>
                                  <a href="#">
                                   <i class="os-icon os-icon-signs-11"></i>
                                  </a>
                                </td> 
                                 </a></td>
                              </tr>
                              @endif
                              @endforeach 
                            @endif -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
      
      
                  <!--------------------
                      END - documents table 
                      -------------------->
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
            <!--------------------
              END - Chat Popup Box
              -------------------->
          </div>

        </div>
      </div>

     <script>
      function privateDocuments() {
        // Declare variables 
        var input, filter, table, tr, td, i;
        input = document.getElementById("private_document");
        table = document.getElementById("private_document_table");
        filter = input.value.toUpperCase();
        
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
          if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          } 
        }
      }

      function publicDocuments() {
        // Declare variables 
        var input, filter, table, tr, td, i;
        input = document.getElementById("public_document");
        table = document.getElementById("public_document_table");
        filter = input.value.toUpperCase();
        
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
          if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          } 
        }
      }
</script> 
                


 @endsection     
