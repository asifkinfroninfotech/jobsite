@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')

      <div class="content-w investor-profil">
        @include('shared._top_menu')

        <div class="content-i">
          <div class="content-box enterprise-company">
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
                        Kinara Capital
                      </h2>
                      <h6 class="up-sub-header">
                        Enterprise
                      </h6>
                    </div>
                    <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219" preserveAspectRatio="xMaxYMax meet" version="1.1" xmlns="http://www.w3.org/2000/svg"
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
                            Country(S):
                          </div>
                          <div class="value">
                            Switzerland
                          </div>
                        </div>
                        @php
                        $profile_image = asset('storage/company/profileimage/'.$data['company_information']->profileimage);
                      @endphp
                        <div class="rianta-img">
                          <img src="{{ $profile_image  }}" class="img-responsive">
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
                    <form action="{{ route('company.cover.logo.image.store') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="my-awesome-dropzone">
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
                    <form action="{{ route('company.cover.logo.image.store') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="my-awesome-dropzone">
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
                            <img src="{{ asset('img/video-test.jpg') }}" alt="Play Video" class="img-responsive" />
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
                    <form action="{{ route('company.video.store') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="my-awesome-dropzone">
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
                    <!--
                     START - right section content area
                     -->

              <div class="col-sm-12 col-md-12 col-lg-8">
                <div class="element-wrapper">
                  <div class="element-box">
                    <form id="formValidate" method="POST" action="{{ route('company.profile.update') }}" >
                      {{ csrf_field() }}
                      <div class="steps-w">
                        <div class="step-triggers">
                          <a class="step-trigger active" href="#stepContent1">Company Information</a>
                          <a class="step-trigger" href="#stepContent2">Financial Information</a>
                          <a class="step-trigger" href="#stepContent3">Impact Information</a>
                        </div>
                        <div class="step-contents">                          
                          <div class="step-content active" id="stepContent1">
                              <h5 class="form-header"> Company Profile </h5>
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
                                  <select class="form-control" name="country" placeholder="Country">
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
                                  <select class="form-control" name="state" placeholder="State  / Region">
                                    @if(isset($data['states']['total_states']))
                                      @foreach($data['states']['total_states'] as $state)
                                       <option value="{{ $state->stateid }}"
                                        @isset( $data['states']['selected_states']->stateid )
                                         {{ 
                                           ( $state->stateid == $data['states']['selected_states']->stateid ) ? 
                                            "selected='selected'" : ''
                                          }}
                                        @endisset
                                        >{{ $state->name }}</option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                              </div>
                            </div>
                            <h5 class="form-header">Business Profile </h5>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for=""> Year Founded</label>
                                  <input class="form-control" type="text" name="year_founded" value="{{old('', $data['company_information']->foundedyear)}}">
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">Preferred Currency </label>
                                  <select class="form-control" name="currency">
                                   @if(isset($data['currency']['all_currency']))
                                      @foreach($data['currency']['all_currency'] as $currency)
                                       <option value="{{ $currency->currencyid }}"
                                         @isset( $data['currency']['selected_currency']->preferedcurrencyid ) 
                                        {{
                                          ( $data['currency']['selected_currency']->preferedcurrencyid == $currency->currencyid ) ? "selected =='selected'" : ''
                                        }}
                                        @endisset
                                        >{{ $currency->currencyname }}
                                      </option>
                                      @endforeach
                                    @endif
                              </select>
                                  <!-- <input class="form-control" type="text" name="prefered_currency" value="{{old('', $data['company_information']->preferedcurrencyid)}}"> -->
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">Type of Entity</label>
                                  <select class="form-control" name="entity_type">
                                    @if(isset($data['entity_type']['entity']))
                                      @foreach($data['entity_type']['entity'] as $entity)
                                       <option value="{{ $entity->accountingcompanytypeid }}"
                                         @isset( $data['entity_type']['selected_entity']->accountingcompanytype ) 
                                        {{
                                          ( $data['entity_type']['selected_entity']->accountingcompanytype == $entity->accountingcompanytypeid ) ? "selected =='selected'" : ''
                                        }}
                                        @endisset
                                        >{{ $entity->companytype }}
                                      </option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">Sector </label>
                                  <select class="form-control" name="sector">
                                
                                    @if(isset($data['sectors']))
                                      @foreach($data['sectors']['total_sectors'] as $sectors)
                                       <option value="{{ $sectors->sectorid }}"
                                         @isset($data['sectors']['selected_sector']->sectorid) 
                                        {{
                                          ( $data['sectors']['selected_sector']->sectorid == $sectors->sectorid ) ? "selected =='selected'" : ''
                                        }}
                                        @endisset
                                        >{{ $sectors->name }}
                                      </option>
                                      @endforeach
                                    @endif
                              </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label for="">Referred By</label>
                                  <select class="form-control">
                                    @if(isset($data['referred_by']))
                                      @foreach($data['referred_by']['total_users'] as $users)
                                       <option value="{{ $users->userid }}"
                                         @isset( $data['referred_by']['selected_user']->referredbyid ) 
                                        {{
                                           ( $data['referred_by']['selected_user']->referredbyid == $users->userid ) ? "selected =='selected' " : ''
                                        }}
                                        @endisset
                                        >{{ $users->username }}
                                      </option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                              </div>                              
                            </div>
                            <div class="row">
                              <div class="col-sm-12">
                                  <div class="form-group paragraph">
                                      <label for="">Business Summary</label>
                                      <p> (Please provide a brief description of your business model and investment needs, including core products/services,target
                                          market and revenue )</p>
                                          <textarea class="form-control" name='business_summary' rows="3">{{ old('',$data['company_information']->businesssummary) }}</textarea>
                                    </div>
                              </div>                              
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">One Line Pitch</label>                                     
                                            <textarea class="form-control" name='oneline_pitch' rows="3">{{ old('',$data['company_information']->onelinepitch) }}</textarea>
                                      </div>
                                </div>                              
                              </div>
                              <div class="row">
                                  <div class="col-sm-12">
                                      <div class="form-group paragraph">
                                          <label for=""> Sales / Marketing Strategy</label>                                     
                                              <p>(How are you planing to grow your business?)</p>
                                              <textarea class="form-control" name='sales_strategy' rows="3">{{ old('',$data['company_information']->salesstrategy) }}</textarea>
                                        </div>
                                  </div>                              
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group paragraph">
                                            <label for="">Competitive Advantage </label>   
                                            <p>(Who are the key competition in you la;ndscape, and what differentiates)
                                                you and serves as your competitive advantage? </p>                                  
                                                <textarea class="form-control" name="competative_advantage" rows="3">{{ old('',$data['company_information']->competativeadvantage) }}</textarea>
                                          </div>
                                    </div>                              
                                  </div>
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label for="">Existing Patents or  Patents Pending</label>
                                              <textarea class="form-control" name="existing_patents" rows="3">{{ old('',$data['company_information']->existingpatents) }}</textarea>
                                            </div>
                                      </div>                              
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="">Have the enterprise won any business competitions, recognition?</label>    <textarea class="form-control" name="recognition" rows="3">{{ old('',$data['company_information']->recognition) }}</textarea>
                                              </div>
                                        </div>                              
                                      </div>
                                      <div class="row">
                                          <div class="col-sm-12">
                                              <div class="form-group">
                                                  <label for="">How did they hear about artha Platform?</label>
                                                  <textarea class="form-control" name="hear_about_artha" rows="3">{{ old('',$data['company_information']->hearaboutartha) }}</textarea>
                                                </div>
                                          </div>                              
                                        </div>
                             

                            <div class="form-buttons-w text-right">
                              <input class="btn btn-primary" type="submit" name="user_info" value="Save"> 
                              <a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Next</a>
                            </div>


                          </div>
                          <div class="step-content financial-section-tab" id="stepContent2">
                              <h5 class="form-header">Past Financials <span class="tasks-sub-header">(Optional)</span> </h5>
                              <!--  STRAT Historical  -->
                              
                              @if($data['historical_data']->isNotEmpty())
                               @php $count = 1; @endphp
                              @foreach($data['historical_data'] as $historical_data )

                              <div class="enterprise-sub-hd">
                                <strong>Historical {{ $count }} </strong>    
                              </div>
                              <div class="row">
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for=""> Year </label>
                                      <select class="form-control">
                                        
                                        @for ($i = 2000 ; $i <= date('Y'); $i++)
                                           <option value="{{ $i }}"
                                           @isset($historical_data->historical_year) 
                                             {{ 
                                             ($historical_data->historical_year == $i) ? "selected =='selected' " : '' 
                                             }}
                                           @endisset
                                           >{{$i}}</option>
                                        @endfor
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="">Annual Operating Costs <span class="inr">INR</span> </label>
                                      <input class="form-control" type="text" value="{{old('', $historical_data->annualoperatingcosts )}}">
                                    </div>
                                  </div>
                                </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">Average Annual Revenues <span class="inr">INR</span> </label>
                                  <input class="form-control" type="text" value="{{old('', $historical_data->averageannualrevenue )}}">                                  
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for=""> Average Next Income <span class="inr">INR</span></label>
                                  <input class="form-control" type="text" value="{{old('', $historical_data->averagenetincome )}}">
                                </div>
                              </div>
                            </div>
                            @php $count = $count + 1; @endphp
                            @endforeach
                            <!--  END Historical  -->
                            @endif
                            
                              
                            
                            <h5 class="form-header">Current Financials </h5>
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label for="">Information as of (Year)</label>
                                  <div class="date-input">
                                    <input class="form-control" name="current_financials"  placeholder="Date of birth" type="text" value="{{old('', $data['company_information']->financialinfo_informationdate)}}">
                                    </div>
                                </div>
                              </div>
                              
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">Current Assets <span class="inr">INR</span> </label>
                                  <input class="form-control" name="current_assets"  type="text" value="{{old('', $data['company_information']->financialinfo_currentassets)}}">
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label for="">Total Assets <span class="inr">INR</span> </label>
                                  <input class="form-control" name="total_assets"  type="text" value="{{old('', $data['company_information']->financialinfo_totalassets)}}">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="">Current Liabilities  </label>
                                    <input class="form-control" name="current_liabilities"  type="text" value="{{old('', $data['company_information']->financialinfo_currentliabilities)}}">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="">Total Liabilities </label>
                                    <input class="form-control" name="total_liabilities"  type="text" value="{{old('', $data['company_information']->financialinfo_totalliabilities)}}">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="">Total Equity  </label>
                                      <input class="form-control" name="total_equity"  type="text" value="{{old('', $data['company_information']->financialinfo_totalequity)}}">
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label for="">Net Cash</label>
                                      <input class="form-control" name="net_cash"  type="text" value="{{old('', $data['company_information']->financialinfo_netcash)}}">
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for=""> EBITDA </label>
                                        <input class="form-control" name="ebitda"  type="text" value="{{old('', $data['company_information']->financialinfo_ebitda)}}">
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for=""> Do you have audited financial statements?</label>
                                        <select name="audited_financial_statements" class="form-control">
                                            <option value=1>
                                              Yes
                                            </option>
                                            <option value=0>
                                              NO
                                            </option>
                                            
                                          </select>
                                      </div>
                                    </div>
                                  </div>

                            <div class="form-buttons-w text-right">
                              <input class="btn btn-primary" type="submit" name="user_info" value="Save">
                              <a class="btn btn-primary step-trigger-btn" href="#stepContent1"> Previous</a>
                              <a class="btn btn-primary step-trigger-btn" href="#stepContent3"> Next</a>
                            </div>
                          </div> 
                          <div class="step-content" id="stepContent3">
                              <h5 class="form-header">Impact Information</h5>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">problem being solved</label>                                     
                                            <textarea class="form-control" name="impactinfo_info" rows="3">{{ old('',$data['company_information']->impactinfo_info) }}</textarea>
                                      </div>
                                </div>                              
                              </div>
                              <div class="row">
                                  <div class="col-sm-12">
                                      <div class="form-group paragraph">
                                          <label for="">Social impact benefit created </label>                                     
                                              <p>Please describe any social benefit or impact your firm creates through its operation.</p>
                                              <textarea class="form-control" name="social_impact" rows="3">{{ old('',$data['company_information']->impactinfo_socialbenefitimpact) }}</textarea>
                                        </div>
                                  </div>                              
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group paragraph">
                                            <label for="">Environmental impact benefit created </label>   
                                            <p>Please describe any social benefit or impact your firm creates through its operation.</p>    <textarea class="form-control" name="environmental_impact" rows="3">{{ old('',$data['company_information']->impactinfo_environmentbenefitimpact) }}</textarea>
                                          </div>
                                    </div>                              
                                  </div>
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="form-group paragraph">
                                              <label for="">Specific impact beneficiaries</label>  
                                              <p>(Please indicate any particular groups that stand to benefit from your business activity, i.e
                                                  Youth, Women, Rural communities etc.)</p>                                   
                                                  <textarea class="form-control" name="specific_impact" rows="3">{{ old('',$data['company_information']->impactinfo_specificbeneficiaries) }}</textarea>
                                            </div>
                                      </div>                              
                                    </div>

                            <div class="form-buttons-w text-right">
                              <input class="btn btn-primary" type="submit" name="user_info" value="Save"> 
                              <a class="btn btn-primary step-trigger-btn" href="#stepContent2">  Previous</a>
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
                        Company Profile Documents Public
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
                                <!-- <a class="btn btn-sm btn-primary" href="#">Upload</a> -->
                                <a class="btn btn-sm btn-danger" href="#">Delete</a>
                              </div>
                          <div class="col-sm-12 col-lg-8 filter-moble">
                            <form>
                              <input id="public_document" onkeyup="publicDocuments()" class="form-control form-control-sm rounded bright" placeholder="Search" type="text">
                              <select class="form-control form-control-sm rounded bright">
                                <option selected="selected" value="">
                                  {{trans('frontend/investor/company/edit.documents.public.sort')}}
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
                              </select>
                              <select class="form-control form-control-sm rounded bright">
                                <option selected="selected" value="">
                                  {{trans('frontend/investor/company/edit.documents.public.select_filter_type')}}
                                </option>
                                <option value="Pending">
                                  Filter Type 1
                                </option>
                                <option value="Active">
                                  Filter Type 2
                                </option>
                                <option value="Cancelled">
                                  Filter Type 3
                                </option>
                              </select>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="table-responsive table-responsive-heading-spce">
                        <table class="table table-lightborder">
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
                            
                            @if($data['documents']->isNotEmpty())

                              @foreach($data['documents'] as $document)
                               @if($document->documentstatus == 'Public')
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
                            @endif

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
                              <input  id="private_document" onkeyup="privateDocuments()"class="form-control form-control-sm rounded bright" placeholder="Search" type="text">
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
                              </select>
                              <select class="form-control form-control-sm rounded bright">
                                <option selected="selected" value="">
                                  {{trans('frontend/investor/company/edit.documents.private.select_filter_type')}}
                                </option>
                                <option value="Pending">
                                  Filter Type 1
                                </option>
                                <option value="Active">
                                  Filter Type 2
                                </option>
                                <option value="Cancelled">
                                  Filter Type 3
                                </option>
                              </select>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="table-responsive table-responsive-heading-spce"  >
                       <!--  <div ng-app="myApp" ng-controller="orderCtrl">
                          <ul>
                          <li ng-repeat="x in customers | orderBy : 'city'">
                              @{{x.documentname + ", " + x.documentdescription}}
                          </li>
                          </ul>
                        </div> -->
                        <table class="table table-lightborder">
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
                            @if($data['documents']->isNotEmpty())
 
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
                            @endif
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                    <!--------------------
                      END - documents table 
                      -------------------->
              </div>
                    <!--
                    END - right section content area
                    -->
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
      
     <!-- <script>
      var app = angular.module('myApp', []);
      app.controller('orderCtrl', function($scope) {
          $scope.customers = @{{ json_encode($data['documents']) }}
      });
    </script> -->

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