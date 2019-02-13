<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.tenant_layout')
<link href="{{asset('js/bower_components/jquery-autocomplete/autocomplete.css')}}" rel="stylesheet">
@section('content')

<div class="all-wrapper menu-side login-information">
    <div class="auth-box-w">
            @if(isset($tenant) && !empty($tenant))
            @if(isset($tenant->logo) && !empty($tenant->logo) && File::exists(public_path('/storage/tenant/logoimage/'.$tenant->logo)))
            <div class="logo-w">
               <img alt="" src="{{'/storage/tenant/logoimage/'.$tenant->logo}}">
            </div>
            @else
            <div class="logo-w">
                    
            </div>
            @endif
            @else
            <div class="logo-w">
                    
                </div>
            @endif

        {{-- <div class="logo-w">
            @if( (isset($tenant->logo) && !empty($tenant->logo) ) && File::exists(public_path('storage/tenant/logoimage/'.$tenant->logo)))
               <img alt="" src="/storage/tenant/logoimage/{{$tenant->logo}}" />
           @else
              <img alt="" src="{{ Avatar::create(strtoupper($tenant->firstname.' '.$tenant->lastname))->toBase64() }}" />    
            @endif

        </div> --}}

        <style>
                #dvCurrentData.data-format .pre-reg-img img, .ui-autocomplete li a .data-format.pre-reg-img img{height: auto; padding: 4px}
         </style>
        <!-- START - login info content area -->
        <div class="col-sm-12 col-md-12">
            <div class="element-wrapper">
                <div class="login-info-hd text-center">
                    <h5 class="element-inner-header">
                        <span>{{trans('preregister.pre_register_form_heading')}}</span>						
                    </h5> 
                </div>
                <form id="formValidate" action="{{ url('save-pre-register') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="steps-w">
                        <div class="step-triggers">
                            <a class="step-trigger active" href="#stepContent1">{{trans('preregister.pre_register_company_information_heading')}}</a>
                            <a class="step-trigger hidden login-info-step" href="#stepContent2">{{trans('preregister.pre_register_login_information_heading')}}</a>
                            <a class="step-trigger hidden company-info-step" href="#stepContent3">{{trans('preregister.pre_register_company_profile_heading')}}</a>
                            <a class="step-trigger hidden terms-step" href="#stepContent4">{{trans('preregister.pre_register_terms_of_service_heading')}}</a>
                        </div>
                        <div class="step-contents">                          
                            <div class="step-content active" id="stepContent1">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="company_name">{{trans('preregister.pre_register_company_name_label')}}</label>
                                            <input class="form-control" data-error="{{trans('preregister.pre_register_company_name_error')}}" name="companyname"
                                                   placeholder="{{trans('preregister.pre_register_company_name_label')}}" required="required" type="company_name" id="company_id">
                                            <input type="hidden" id="companyid" value="" name="companyid">
                                            
                                            <div id="dvCurrentData" class="data-format hidden">
                                                <div class="pre-reg-img">
                                                <img src="" alt="">
                                                </div>
                                                <div class="data">
                                                    <h1></h1>
                                                    <p></p>
                                                </div>
                                            </div>
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.pre_register_company_type_label')}}</label>
                                            <select class="form-control" name="companytype" id="companytype" required="required" data-error="{{trans('preregister.pre_register_company_type_error')}}">
                                                <option value="">Select</option>
                                                @foreach($company_type_list as $type)
                                                <option value="{{ $type->companytypeid }}">{{ $type->companytype }}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-buttons-w text-right">                                    
                                    <a class="btn btn-primary step-trigger-btn hidden" href="#stepContent2">{{trans('preregister.pre_register_next_button_label')}}</a>
                                </div>



                                @if($errors->any())
                                <div class="alert alert-danger" role="alert" id="error-email">
                                    {{$errors->first()}}
                                </div>
                                @endif


                            </div>                                  
                            <div class="step-content" id="stepContent2">                                   
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.pre_register_first_name_label')}}*</label>
                                            <input name="firstname" id="firstname" class="form-control" data-error="{{trans('preregister.pre_register_first_name_error')}}" value="{{ old('firstname') }}"
                                                   placeholder="{{trans('preregister.pre_register_first_name_placeholder')}}" required="required" type="Name">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.pre_register_last_name_label')}}</label>
                                            <input name="lastname" id="lastname" class="form-control"
                                                   placeholder="{{trans('preregister.pre_register_last_name_placeholder')}}" value="{{ old('lastname') }}"
                                                   type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.pre_register_email_label')}}*</label>
                                            <input name="email" id='emailcheck' class="form-control" data-error="{{trans('preregister.pre_register_email_error')}}" 
                                                   placeholder="{{trans('preregister.pre_register_email_placeholder')}}" value="{{ old('email') }}"
                                                   required="required" type="text">
                                            <p class="email"></p>
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.pre_register_password_label')}}*</label>
                                            <input name="password" id="inputPassword" class="form-control" data-error="{{trans('preregister.pre_register_password_error')}}" required="required"  
                                                   data-minlength="6" placeholder="{{trans('preregister.pre_register_password_placeholder')}}" type="password"> 
                                            <p class="charst-sert">{{trans('preregister.pre_register_password_instructions')}}</p> 
                                            <div class="help-block form-text with-errors form-control-feedback"></div>                                 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.pre_register_confirm_password_label')}}*</label>
                                            <input class="form-control" data-match="#inputPassword" data-error="{{trans('preregister.pre_register_confirm_password_error')}}" data-match-error="{{trans('preregister.pre_register_confirm_password_not_matched_error')}}" required="required"  
                                                   placeholder="{{trans('preregister.pre_register_confirm_password_placeholder')}}" type="password" name="confirm_password" id='confirmpassword'> 
                                                   <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.pre_register_user_telephone_label')}}</label>
                                            <input class="form-control" data-error="{{trans('preregister.pre_register_user_telephone_error')}}" placeholder="Telephone"
                                                     type="text" name="telephone" id="telephone" value="{{old('telephone')}}" 
                                                   placeholder="{{trans('preregister.pre_register_user_telephone_label')}}" >
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.pre_register_user_job_title_label')}}*</label>
                                            <input class="form-control" data-error="{{trans('preregister.pre_register_user_job_title_error')}}" required="required"  
                                                   placeholder="{{trans('preregister.pre_register_user_job_title_label')}}" type="text" name="userposition" id="jobtitle"> 
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="alert alert-danger" id="emailnotification" style="display:none;">

                                </div>
                                <div class="form-buttons-w text-right">                                    
                                    <a class="btn btn-primary step-trigger-btn prev-btn" href="#stepContent1">{{trans('preregister.pre_register_previous_button_label')}}</a>
                                    <a id='nextconfir' class="btn btn-primary step-trigger-btn next-btn" href="#stepContent3" onclick='checkforemailandpassword();'>{{trans('preregister.pre_register_next_button_label')}}</a>
                                </div>


                            </div>
                            <div class="step-content financial-section-tab" id="stepContent3">                                    
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{trans('preregister.pre_register_email_label')}}
                                            </label>
                                            <input class="form-control" 
                                                   placeholder="{{trans('preregister.pre_register_email_label')}}" type="email" name="company_email" value="{{old('company_email')}}">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{trans('preregister.general_telephone')}}
                                            </label>
                                            <input class="form-control"  placeholder="{{trans('preregister.general_telephone')}}"
                                                   data-minlength="12" type="text" name="company_telephone" value="{{old('company_telephone')}}">
                                            {{-- <div class="help-block form-text with-errors form-control-feedback">

                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{trans('preregister.investment_tax_id')}}
                                            </label>
                                            <input class="form-control" name="taxidnumber" placeholder="{{trans('preregister.investment_tax_id')}}" type="text" value="{{ old('taxidnumber') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">  
                                        <div class="form-group">
                                            <label for="">
                                                {{trans('preregister.general_address')}}
                                            </label>
                                            <input class="form-control"  placeholder="{{trans('preregister.general_address')}}" type="text" name="address" value="{{old('address')}}">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{trans('preregister.general_city')}}
                                            </label>
                                            {{-- data-error="{{trans('preregister.general_city_error')}}" --}}
                                            <input class="form-control"  placeholder="{{trans('preregister.general_city')}}" type="text" name="city" value="{{old('city')}}">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{trans('preregister.general_postcode')}}*
                                            </label>
                                            <input class="form-control require" data-error="Postcode is required" placeholder="{{trans('preregister.general_postcode')}}" type="text" name="zip" id="zip" value="{{old('zip')}}">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.general_country')}}*</label>
                                            <select class="form-control require" name="country" id="country" data-error="{{trans('preregister.general_country_error')}}"
                                                    placeholder="{{trans('preregister.general_country')}}">
                                                <option value=""> Select</option>
                                                @foreach($countries as $country)
                                                <option value="{{$country->countryid}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.general_state')}}*</label>
                                            <select name="state" id="state" class="form-control require" data-error="{{trans('preregister.general_state_error')}}"
                                                    placeholder="{{trans('preregister.general_state')}}" >
                                                <option value="">Select</option>
                                            </select>
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-sm-12">  
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.pre_register_company_business_summary_label')}}*</label>
                                            <input class="form-control require" type="text" name="businesssummary" id="businesssummary"
                                                   data-error="{{trans('preregister.pre_register_company_business_summary_error')}}" value="{{old('businesssummary')}}" placeholder="{{trans('preregister.pre_register_company_business_summary_label')}}">
                                            <p class="charst-sert">{{trans('preregister.pre_register_company_business_summary_help_text')}}</p> 
                                            <div class="help-block form-text with-errors form-control-feedback"></div>                               
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">  
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.pre_register_company_referredby_label')}}</label>
                                            <select class="form-control" name="referredbyid" id="referredbyid">
                                                <option value="">Select</option>
                                                @foreach($users_list as $referrer)
                                                <option value="{{ $referrer->userid }}">{{ $referrer->firstname }} {{ $referrer->lastname }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                    </div>
                                    <div class="col-sm-6">  
                                        <div class="form-group">
                                            <label for="">{{trans('preregister.pre_register_company_one_line_pitch_label')}}</label>
                                            <input class="form-control " type="text" 
                                                   name="onelinepitch" id="onelinepitch" value="{{old('onelinepitch')}}" placeholder="{{trans('preregister.pre_register_company_one_line_pitch_label')}}">
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{trans('preregister.general_website')}}
                                            </label>
                                            <input class="form-control" placeholder="{{trans('preregister.general_website')}}"
                                                   type="text" name="website" value="{{old('website')}}">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{trans('preregister.investment_sector_of_specialization')}}
                                            </label>
                                            <select class="form-control select2" name="specializedsectors[]" multiple="true" style="width: 100%">
                                                @foreach($company_sectors as $sector)
                                                <option value="{{ $sector->sectorid }}" >{{ $sector->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-danger" id="step_3_error" style="display:none;">

                                    </div>
                                <div class="form-buttons-w text-right">                                    
                                    <a class="btn btn-primary step-trigger-btn" href="#stepContent2">{{trans('preregister.pre_register_previous_button_label')}}</a>
                                    <a class="btn btn-primary step-trigger-btn" id="btnnext_step3" href="#stepContent4" onclick='validatestep3();' >{{trans('preregister.pre_register_next_button_label')}}</a>
                                </div>
                            </div>
                            <div class="step-content" id="stepContent4">   
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="termsWrapper">
                                            <div class="cmcContent">
                                                <h2 class="hel_22_red_bold str">{{trans('preregister.pre_register_terms_and_condition_heading')}}</h2>
                                                <p align="justify">The Artha Platform (hereinafter referred to as <strong>"Artha"</strong> or<strong>"Artha Platform"</strong> or <strong>"the Website"</strong>) is an independent initiative supported by Rianta Capital Zurich based in Zurich, Switzerland. It is designed to enable more efficient due diligence or assessment (<strong>"Due Diligence"</strong>) of high impact social businesses (<strong>"Social Enterprises"</strong> or <strong>"Enterprises"</strong> or <strong>"Projects"</strong>) serving communities at the base of the pyramid (<strong>"BoP"</strong>).</p>
                                                <p align="justify">These Terms and Conditions (<strong>"Terms"</strong>) apply to your use of and contributions to the Artha Platform, a website owned and operated by RCZ (<strong>"Rianta Capital Zurich"</strong> or <strong>"RCZ "</strong>). By accessing, using, subscribing or contributing data to Artha, and any pages therein or related thereto (the <strong>"Artha Services"</strong>), and/or by checking the "I ACCEPT AND UNDERSTAND THESE TERMS OF USE" box upon completion of your user profile registration, you acknowledge that you have read, understood and agreed to be bound by these Terms. If you do not agree to these Terms, you may not use Artha or the Services. These Terms constitute a contract between you (<strong>"You"</strong>) and RCZ and govern all interactions between you and RCZ, as well as your use of the websites www.arthaplatform.com or www.arthaplatform.org and all related services.</p>
                                                <p align="justify">If you have any questions or need additional information, you may reach RCZ at <a href="mailto:info@arthaplatform.com">info@arthaplatform.com</a>.</p>
                                                <h2>User Account(s)</h2>
                                                <ol>
                                                    <li>Investors (<strong>"Investors"</strong>), Entrepreneur Support Organizations (<strong>"Entrepreneur Support Organizations"</strong>) and Third Parties (<strong>"3rd Parties"</strong>) of the Artha Platform, as well as contributors of project/enterprise information to Artha (<strong>"Promoters"</strong>)(together&nbsp;<strong>"Users"</strong>), must register their information upon invitation for an account. All User types are 'by invite only'; only Promoters may complete a pre-registration questionnaire available on the website and be considered for inclusion in the listing of high impact enterprises on what is called the Artha pipeline (<strong>"Artha Pipeline"</strong>). Each User account will differ slightly in format and function.</li>
                                                    <li>As part of the registration process as a User, you will create a username and password. You will also give RCZ certain registration information, all of which must be accurate and kept current (<strong>"Registration Data"</strong>). You shall be responsible for maintaining the confidentiality of your username and password.</li>
                                                    <li>You shall notify RCZ in a timely manner of any known or suspected unauthorized use of your account, or any known or suspected breach of security, including loss, theft, or unauthorized use or disclosure of your password.</li>
                                                    <li>You are responsible for all usage or activity on your account, including use of the account by any third party authorized by you to use your username and password.</li>
                                                    <li>RCZ has the right to terminate your account at any time, or to modify or discontinue the Artha Platform or the Services, each in RCZ's sole discretion.</li>
                                                    <li>RCZ determines that all United States-based investors are not currently given access to this platform or its pipeline contents.</li>
                                                </ol>
                                                <h2>Content</h2>
                                                <h2>Artha-generated content</h2>
                                                <ol>
                                                    <li>The Artha Platform is intended to provide general information regarding social investment opportunities undertaken by entrepreneurs who have chosen to position themselves in the social space. Sources of these opportunities may come from Investors themselves, incubators at academic institutes of management or technology, community-based organisations (which may or may not be registered as affiliates of non-profit organisations in different countries, mostly India), or Entrepreneur Support Organisations.</li>
                                                    <li>RP may undertake but is not obliged to make reasonable efforts to moderate and screen content on the Artha Platform (at random inspection), however, RCZ shall not be responsible for the content of any due diligence report executed on any project listed on Artha or similar material.</li>
                                                    <li>All other content under the News and Resource Center of the Artha Platform will be generated by Artha staff and is gathered primarily from secondary and other online news sources, with appropriate attributions. The Artha blog will be generated by the Artha team. RP Ltd. does not take responsibility for the content of any commentary/posts/links, etc. generated by Users on any portion of the site, whether open or closed domain (protected by password).</li>
                                                    <li>Some cursory information uploaded to specific social business profiles on the main Artha Pipeline will be visible to the entire 10/7/2011 11:33:36 AMcommunity of selected investors on the Website. However, access to the full profile of any entrepreneur on the Website is limited, and only those signing the automated Non-Disclosure Agreement (NDA) can access this more detailed information.</li>
                                                    <li>All Users of Artha are bound to protect the privacy and confidentiality of all information (including information relating to social businesses and projects featured on the Website) posted on the Website in accordance with the confidentiality provisions set out in these Terms. <u>Breaches of these confidentiality provisions may result in expulsion from the Artha Platform.</u></li>
                                                </ol>
                                                <h2>Content Disclaimers</h2>
                                                <p align="justify">RCZ is not responsible, and shall have no liability, for any incorrect or inaccurate content posted on the Website by any User or for any liability, cost or expense Users may incur in connection with the Artha Platform caused by any User or other Person.</p>
                                                <ol>
                                                    <li>RCZ is not responsible for the conduct, whether online or offline, of any User of the Website or any other person. With respect to the Website, RCZ assumes no responsibility for any error, omission, interruption, deletion, defect, delay in &nbsp;operation or transmission, communications line failure, theft or destruction or unauthorized access to, or alteration of, any &nbsp;communications.</li>
                                                    <li>Under no circumstances will RCZ be responsible for any loss or damage, including personal injury or death, resulting from any use of the Website, any content posted on the Website or transmitted to, or any interactions between, any Users of the Website, whether online or offline. RCZ neither represents, warrants, covenants guarantees, nor promises any specific results from use of the Website.</li>
                                                </ol>
                                                <h2>User generated content</h2>
                                                <ol>
                                                    <li>All electronic data file, content, material or any other information submitted and uploaded by Users (directly or indirectly) are considered contributions of data (<strong>"Data Contributions"</strong> or <strong>"Content"</strong>).</li>
                                                    <li>Data Contributions uploaded to the Artha Platform are at user discretion and may comprise the following file formats (not exhaustive): .doc, .pdf, .txt, .xls., .ppt, .jpg, .bmp, .wmv, .mp3. See Section 15 of these Terms regarding Data Contributions for more on rules, limitations, controls, and disclaimers where User uploaded and shared content is concerned.</li>
                                                </ol>
                                                <h2>Country Risk</h2>
                                                <ol>
                                                    <li>Engaging with small social businesses in India focused on the BoP entails an implicit understanding of the fact that there are multiple levels of associated risk; these include country risk, entrepreneur/promoter risk, as well as 3rd party risk. <strong>The Artha Platform does not claim to mitigate risk on any of these levels.</strong></li>
                                                    <li>All Users are aware that there are extensive limitations placed on foreign investors by Indian regulation; completion of due diligence on the Artha Platform may in no way be interpreted as a green light for the completion of an investment, or for advice on the appropriate and legal structures required to execute a transaction. All Investors are responsible for educating themselves and understanding the types of instruments at their disposal, relevant sectoral caps and constraints, buyback rules, capital injection rules, and all relevant applicable conditions pertaining to their work. RCZ does not accept responsibility for any risk, barrier, problem or damage arising as a result of an Investor desire to allocate capital to a social enterprise in India.</li>
                                                    <li>RCZ currently prohibits access to United States-based impact investors, funder or donors due to country risk parameters related to United States regulations.</li>
                                                </ol>
                                                <h2>Code of Conduct &amp; Acceptable Use</h2>
                                                <p align="justify">All Users of the Website will be expected to conform to a code of conduct guided by the principles of transparency, trust and integrity (<strong>"Honor Code"</strong>).</p>
                                                <ol>
                                                    <li>Users may not transmit any chain letters or junk email to any other User (Investor, Entrepreneur Support Organization, Third Party, or Promoter) or any other person. Illegal and/or unauthorized uses of the Website, including collecting the name, email address or any other personal or confidential information of any User or any other person by electronic or other means for any reason, including, without limitation, the purpose of sending unsolicited email and unauthorized framing of or linking to the Website, will be investigated and appropriate legal action may be taken, including, without limitation, civil, criminal and injunctive redress.</li>
                                                    <li>Although RCZ assumes no obligation to monitor the conduct of any User on or off the Website, it is a violation of these Terms to use the Website or any information obtained from the Website in order to: (i) harass, abuse, or harm another person (including, but not limited to, using profanity in messages or joining collaborator teams in bad faith), (ii) contact, advertise to, solicit, or sell to any User or other person without their prior explicit consent. In order to protect such persons from such advertising, solicitation or harassment, RCZ reserves the right to remove content from the Website that violates acceptable use in RCZ's sole discretion and restrict the number of emails or messages that a User may send to others through the Website in any 24-hour or other period to a number that RCZ deems appropriate, in RCZ's sole and absolute discretion.</li>
                                                    <li>Users shall not use the Artha Platform or its content to upload, post or submit content (including but not limited to, written materials or images) at any time for any purpose that in RCZ's opinion is unlawful, prohibited, threatening, abusive, defamatory, libelous, invasive of privacy or publicity rights, hateful or offensive on racial, ethnic, sexual or any other grounds, vulgar, obscene, profane or otherwise objectionable, which encourages conduct that would constitute a criminal offense, gives rise to civil liability or otherwise violates any law, and you shall comply with any applicable local, state, national or international statutes, rules, regulations, ordinances, decrees, laws, codes, orders, regulations or treaties when using Artha.</li>
                                                    <li>Other than as specifically set forth in these Terms, Users may not reproduce, republish, upload, post, modify, copy, alter, distribute, sell, resell, transmit, transfer, decompile, license, assign, publish or exploit, in any way, any content on the Arth Website. Except as otherwise expressly permitted under these Terms or copyright law, no copying, redistribution, retransmission, publication or commercial exploitation of downloaded material will be permitted without the express written permission of RCZ and the copyright owner. In the event of any permitted copying, redistribution or publication of copyrighted material, no changes in or deletion of author attribution, trademark legend or copyright notice shall be made and no ownership rights shall be transferred.</li>
                                                    <li>Inform RCZ Of the status of the due diligence process and the completion of a due diligence report.</li>
                                                </ol>
                                                <p align="justify"><strong>The Website includes features and functionality whereby a User may post and transmit information, images and other materials. All such information, images and materials, whether publicly posted or publicly or privately transmitted, are the sole responsibility of the User who originates such content. RCZ assumes no obligation to monitor or control such posted or transmitted content and cannot take responsibility for such content posted or transmitted by a User. However, RCZ reserves the right at all times (but will not have an obligation) to remove or refuse to post or distribute any content, and to restrict, suspend or terminate the participation of any User from the Website and from all Artha Services at any time, with or without prior notice.</strong></p>
                                                <h2>Registration and Cancellation</h2>
                                                <p align="justify">Certain areas of the Artha Platform will not be freely accessible and any information related to active social businesses in India will be in protected areas of the Website, requiring passwords for access. Likewise, full investor profiles and activity information will be protected and secure, visible only to account owners and to their chosen contacts on the Artha Platform. You may be asked to complete a form of registration in order to access certain areas of the Website ("Restricted Areas"). No charge will be requested to obtain access to the Restricted Areas. (Please see the Fees and Expenses section for a breakdown of the costs of using the Website, specifically around the closure of due diligence contracts arising from information posted on the Website.)</p>
                                                <p align="justify">RCZ reserves the right to terminate your registration to the Restricted Areas and to restrict your access to the Website without notice, at any time.</p>
                                                <p align="justify">You may cancel your registration with the Website at any time by sending an email to info@arthaplatform.com.</p>
                                                <p align="justify">Any termination or restriction shall be without prejudice to any rights accrued to RCZ up to the date of termination or restriction.</p>
                                                <h2>Operation of the Website</h2>
                                                <p align="justify">RCZ reserves the right to suspend or terminate the operation of the Website at any time for the purposes of support and maintenance or to update the information contained on the Website. RCZ is not obliged to give any notice of such termination or suspension.</p>
                                                <p align="justify">See Due Diligence process (Section 8a) below for further detail on how the site operates.</p>
                                                <h2>Eligible Users</h2>
                                                <p align="justify">RCZ will accept requests to partake on the Website contingent upon further discussions, and reserves the right to control the growth and profile of the Users at its discretion. The Artha community is formed on the basis of relationships, and it will be a general rule that new users to the Artha Platform should have had some prior contact with an existing User in order to receive an invitation to join, unless they are an entrepreneur/Promoter. The Artha Platform administrator controls access to all user requests for membership. For the purposes of the beta launch of the Website, Investors who want to access the Artha Platform must be qualified investors within the meaning of article 10 (3) of the Swiss Collective Investment Schemes Act ("CISA"). The following are deemed to be qualified investors; Supervised financial intermediaries such as banks, securities dealers and fund management companies; supervised insurance companies; public entities and retirement benefits institutions with a professional treasury; companies with a professional treasury; independent financial advisors that are subject to anti money laundering regulations and the code of conduct of an industry organization recognized by the Swiss Financial Market Supervisory Authority ("FINMA"); high net worth individuals holding directly or indirectly financial assets in excess of Swiss francs 2 million.)</p>
                                                <p align="justify"><strong> Artha Platform User types are defined as follows: </strong></p>
                                                <ol>
                                                    <li><strong>Investors:</strong> In function, these are 'by invite only' and comprise entities and organizations that qualify as professional investors and who have expressed an open interest in impact investment opportunities located in India. These may include: qualified individuals, private foundations, financial institutions, corporations, social venture capital/private equity funds, donor-advised funds, trusts, estates, etc. They can connect to one another and to all User types as long as they initiate contact; they are protected from all other User types on the Artha Platform.</li>
                                                    <li><strong> Entrepreneur support organizations:</strong> In function, these are 'by invite only' and represent organizations based in India whose primary task is the identification, selection and support of socially motivated entrepreneurs who are keen to use enterprise as a tool for combating the country's major development challenges. They may serve as a gateway for social entrepreneurs who they see fit to extend an invitation link into the Artha Pipeline (pending administrative approvals), and view the Artha Pipeline at a top level, with the exception of those enterprises that they have supported or identified themselves. These organizations may be connected to by Investors, but may not initiate contact with them. They can connect to one another and to Third Parties.</li>
                                                    <li><strong>3rd Parties:</strong> In function, these are 'by invite only' and represent a range of different sized entities based in India whose primary offerings are comprised of business services including due diligence, business development, and capacity building in various forms. These organizations may be connected to by Investors, but may not initiate contact with them. They can connect to one another and to Entrepreneur Support Organizations.</li>
                                                    <li><strong>Promoters:</strong> These entrepreneurs are 'by invite only' and may 'register' on the Artha Website through a pre-registration process; if their business model qualifies as 'socially motivated' or socially conscious, and if broad objectives fulfill the stated mission of the Artha Platform, they will be approved and listed on the Artha Pipeline. These organizations may be connected to by Investors, but otherwise do not have access to the investor network directly; an entrepreneur may initiate contact with an entrepreneur support organization or third party from within the network, and may also connect with one another.</li>
                                                </ol>
                                                <p align="justify">The selection and invitation of users is at the sole discretion of RCZ. &nbsp;RCZ does not have any direct ownership interest, shareholding/stakeholding, or any other monetary, investment or other financial connection to any of the independent entities invited into the Artha Platform.</p>
                                                <h3>Due Diligence</h3>
                                                <p align="justify">All Investors engaged in the community on the Website must register their details, and agree that any contracts relating to due diligence and arising as a result of connections formed on the Website will be invoiced offline and between all parties involved in said due diligence transaction.</p>
                                                <p align="justify">No payments for due diligence contracts are executed through the Website; all payments between parties for due diligence contracts must be handled offline, but made transparently so as to benefit all parties involved in a given due diligence 'share'.</p>
                                                <h2>a. Due Diligence Process</h2>
                                                <p align="justify">The Website presents a collaborative online environment whereby Users may work together in concert to complete a due diligence report on any given social business listed in the Artha Pipeline. There are 15 standardized Due Diligence "modules" at the disposal of Users of the Website, all of which are optional and that reflect the aggregation of the due diligence methodologies of several practitioners in the sector. These modules are inclusive of a series of questions that fulfill each of the areas of due diligence query as follows: BUSINESS OPPORTUNITY, COMPANY ANALYSIS, COMPANY GOVERNANCE/MANAGEMENT, CUSTOMER BASE, FINANCIAL ANALYSIS, FINANCIAL MANAGEMENT, FUNDING STRATEGY, INDUSTRY/MARKET ANALYSIS, INVESMTENT PROPOSITION, LEGAL, RISK ASSESSMENT, SOCIAL IMPACT, TECHNOLOGY, TARGET POPULATION, and REQUIRED DOCUMENTATION CHECKLIST. Each one of these modules reflects a series of standard queries and 'information capture' fields under each of the fifteen topic headings.</p>
                                                <p align="justify">The first Investor to "signal interest" in any opportunity will be considered a 'lead Investor', and will thereon determine (for a defined period of 30 days) which other Investors in the community may (or may not) join in to share in the process of Due Diligence. The Due Diligence process is split into 5 active stages, where upon an Investor signals interest, initiates Due Diligence, signals that Due Diligence is underway, signals that Due Diligence has been completed, and finally signals that an investment has been completed. The last and final stage of confirmation is comprised of signaling only, and it is important to note that funds are not uploaded, transferred or transacted in any way through the Website at anytime. Furthermore, structuring any transaction must happen offline and outside the parameters of the Website.</p>
                                                <p align="justify">Three options are presented to a given Investor once initial interest is signaled in an opportunity: 1) Due Diligence may be conducted by themselves, 2) Due Diligence may be opened to a bidding/tender process involving a selected network of 3rd Parties in-country who are Users of the Website, or 3) Due Diligence may be conducted by a 3rd Party who is directly appointed. The process thereon is self-explanatory, and the system is designed to maximize communication and encourage information sharing as it pertains to impacting the transaction costs of seeing investors achieve comfort with the social businesses the Website aims to support.</p>
                                                <p align="justify">In the event that a User selects the option to either invite 3rd Parties to bid or appoint a 3rd Party entity capable of supporting the exercise of Due Diligence in a particular enterprise, the bid process and the entities party to it function independently of RCZ and RCZ does not take responsibility in any form for the outcome of such activities.</p>
                                                <p align="justify">3rd Parties receiving information about an opportunity to conduct Due Diligence on behalf of an Investor on a social enterprise in India are responsible for their own bid in terms of content, pricing and structure. They may or may not receive acknowledgement or a response from Investors in this process. It is the responsibility of 3rd Parties to negotiate their own agreements for service rendered to the Investors and to close their own contracts (including effectuation of invoicing and payment) as they see fit. RCZ does not have any role, direct or indirect, in setting the pricing or terms for such work.</p>
                                                <h2>b. Disclaimers around Due Diligence</h2>
                                                <p align="justify">All Investors acknowledge that the conclusions drawn by all Due Diligence reports and analysis (in any form, including documents, .pdfs, Powerpoints, Excel documents, or media of any kind) posted by Users or established by a 3rd Party <u>do not reflect recommendations of RCZ Accordingly, RCZ </u>shall not under any circumstance be liable to any User for any loss incurred as a result of reliance on such material.</p>
                                                <p align="justify">These reports and analysis are purely informational, and shared by peers on the Website in the spirit of collaboration and efficiency.</p>
                                                <p align="justify">RCZ is not responsible and cannot be held liable for any misuse of any confidential material provided by the Promoters or any other person to the Investor in a due diligence process or posted by any User on the Website.</p>
                                                <h2>No investment actions</h2>
                                                <p align="justify">The Artha Platform is not a transactional platform. The Website is not involved in investment actions of any kind and the Users may not use the Website for actual investment transactions of any kind.</p>
                                                <p align="justify">Information posted on the Artha Platform by Users does not constitute investment advice or an offer to invest and is not intended for trading purposes. Users need to consult with their own investment, accounting, legal and tax advisers to evaluate independently the risks, consequences and suitability of any action to complete investment made as a result of learning through the Artha Platform.</p>
                                                <p align="justify">ARTHA IS INTENDED ONLY FOR INFORMATIONAL PURPOSES, AND IS NOT AN OFFER OF SECURITIES OF ANY KIND BY ANYONE, NOR DOES IT CONSTITUTE AN OFFER BY RP LTD. OF OTHER SERVICES (SUCH AS ADVISORY SERVICES) OR PRODUCTS. RIANTA CAPITAL ZURICH DOES NOT PARTICIPATE IN THE NEGOTIATION OR EXECUTION OF INVESTMENT TRANSACTIONS OR HANDLE SECURITIES.</p>
                                                <h2>Cautionary Language Regarding Forward Looking Statements</h2>
                                                <p align="justify">Information posted on the Artha Platform may contain estimates, projections or other statements that are forward looking in nature (<strong>"Forward looking statements"</strong>). Any such forward looking statements are inherently speculative and subject to numerous risks and uncertainties. Actual results and performance may be significantly different from historical experience and present expectations or projections. RCZ undertakes no obligation to publicly update or revise any forward looking statements.</p>
                                                <h2>Fees</h2>
                                                <p align="justify">RCZ incurs financial, administrative and other expenses associated with the operation of the Website and network convener. Invited users of the system do not however have to pay any fees at the current time.</p>
                                                <p align="justify">It is the duty of all Users party to the Website to report on the status of a Due Diligence negotiation and to disclose whether a contract has been completed to this end; this is part of our knowledge sharing mandate, and is based on the <strong>Honor Code</strong> implicit within the functioning of this online community.</p>
                                                <p align="justify">We simply ask you to inform the Artha community whether you plan to make an investment based on the due diligence agreement sourced through the Artha Platform and to indicate the amount of such planned investment.</p>
                                                <p align="justify">RCZ reserves the right to adjust any fees and percentages at any time on written notice in the future.</p>
                                                <h2>Expiry of Enterprises on the Platform</h2>
                                                <p align="justify">In the event that an Enterprise is listed for longer than twelve months without receiving any signal of interest in conducting due diligence, the Project may then be "deleted", in which case all parties responsible for originally posting the opportunity will be notified.</p>
                                                <h2>Confidentiality</h2>
                                                <ol>
                                                    <li>Each User agrees that he/she will not use, divulge or communicate to any person, except to its professional representatives or advisers or as may be required by law or any legal or regulatory authority, any confidential information concerning the business or affairs of any other User of the Website or of any member of the group of companies to which such User belongs or any investee entity which may have or may in future come to its knowledge and each User shall use its best endeavors to prevent the publication or disclosure of any confidential information concerning such matters.</li>
                                                    <li><u>Data Security:</u> To prevent unauthorized access, maintain data accuracy and ensure the correct use of your registration data and Data Contribution, RCZ has put in place what RCZ believes to be reasonable physical, electronic and managerial procedures to safeguard and secure your Registration Data and Data Contribution. However, no assurances can be given that these security measures will prevent any unauthorized interception of or access to your registration data and Data Contribution and you hereby agree not to hold RCZ liable for use of your registration data and Data Contribution obtained in any unauthorized manner.</li>
                                                    <li>Promoters are advised to use caution when completing their profile(s) on the Artha Platform and using the system as a repository for sensitive information, the existing automated NDA notwithstanding. Enforcement of said non-disclosure agreements in differing jurisdictions may not be possible, and you are encouraged to consider sharing some of the more sensitive information about your business in bilateral communications offline and outside the Artha Platform. Promoters are also advised to ensure that they have all necessary permissions from all parties involved in their enterprise including previous investors before mention of such details on the Artha Platform. Promoters are responsible for their own posts on Artha, and &nbsp;&nbsp;&nbsp;for the communication of their own information; RCZ is not responsible under any circumstance for breaches of confidentiality that may arise over tim</li>
                                                </ol>
                                                <h2>Taxes</h2>
                                                <p align="justify">It is the responsibility of each User to determine what tax rules and policies may apply to them; RCZ does not accept any responsibility in any way for issues regarding taxation.</p>
                                                <h2>Warranties</h2>
                                                <p align="justify">Users are granted limited, revocable, nonexclusive, nontransferable access to Artha Content conditioned on the Users' continued compliance with these Terms. Users may view, download and print Artha Platform content for their personal and internal business use, provided that all hard copies contain all copyright notices and trademark legends, and all other applicable intellectual property and proprietary marks and notices.</p>
                                                <p align="justify"><strong> Each User represents and warrants that: </strong></p>
                                                <ol>
                                                    <li>all abovementioned Data provided by Users for registration is accurate, non-misleading and complete;</li>
                                                    <li>only Data Contributions relevant to the Due Diligence process or to the purpose of presenting the Social Enterprise on the Artha Pipeline will be posted on the Website;</li>
                                                    <li>the User does not use pseudonyms or pen names.</li>
                                                </ol>
                                                <p><strong>Except expressly provided in these Terms, User(s) shall not: </strong></p>
                                                <ol>
                                                    <li>download, store, reproduce, transmit, display, distribute or take screen shots of any part of the Website or use the content of the Website for a database of any kind;</li>
                                                    <li>make available or permit access to the Website to any third party; users may not sell, loan, lease or rent access to, or use of, the Artha Platform;</li>
                                                    <li>use or attempt to use any deep-link, scraper, robot, spider, data mining, computer code or any other device, tool or program to access, acquire or monitor any part of the Website;</li>
                                                    <li>violate the security of the Website or attempt to gain unauthorized access to the Website;</li>
                                                    <li>upload any material to the Website that infringes intellectual property rights of RCZ or a third party or any obligations of onfidentiality according to these Terms;</li>
                                                    <li>provide on the Website any information or use the Website or parts thereof in any manner that infringes or violates the rights of RP Ltd. or any third party, the applicable laws or regulations;</li>
                                                    <li>to refrain from performing any action which may impair the operability of the Website; or</li>
                                                    <li>use the Website in any manner that is unlawful or harms RCZ or the Users of the Website.</li>
                                                </ol>
                                                <p align="justify">The User warrants that he shall act in a polite, courteous and law-abiding manner when using the Website.</p>
                                                <p align="justify">You may not use the Artha Platform or its Content to construct a database of any kind. You may not store Content from the Artha Platform, in its entirety or in any part, in databases for access by you or any 3rd Party or distribute any database services containing all or part of the Services. You may not use Artha in any way to modify or improve the quality of any data sold by you to any 3rd Party. You will not use Artha or its Content in unsolicited mailing or spam material.</p>
                                                <p align="justify">EACH USER REPRESENTS AND WARRANTS THAT (i) IT HAS ALL NECESSARY POWER AND AUTHORIZATION TO ACCEPT THESE TERMS AND CONDITIONS; (II) THESE TERMS AND CONDITIONS ARE LEGAL, VALID, BINDING AND ENFORCEABLE AGAINST THE USER; (III) THE USER'S ACCEPTANCE OF THESE TERMS AND CONDITIONS WILL NOT VIOLATE ANY LAW, RULE, REGULATION, OR ANY AGREEMENT BINDING THE USER; (IV) AND THE USER WILL OBSERVE ALL APPLICABLE LAWS AND THE PROVISIONS OF THESE TERMS AND CONDITIONS.</p>
                                                <h2>Limitation of Liability, Warranty and Indemnification</h2>
                                                <p align="justify">THE LIABILITY OF RP LTD. UNDER OR IN CONNECTION WITH THESE TERMS AND CONDITIONS AND/OR THE WEBSITE SHALL BE LIMITED TO THE EXTENT POSSIBLE BY THE GOVERNING LAW.</p>
                                                <p align="justify">RP LTD. DOES NOT REPRESENT OR ENDORSE THE ACCURACY OR RELIABILITY OF ARTHA OR ITS CONTENT. YOU ACKNOWLEDGE THAT ANY RELIANCE UPON RP LTD. AND THE ARTHA PLATFORM SHALL BE AT YOUR SOLE RISK.</p>
                                                <p align="justify">THE WEBSITE INCLUDING BUT NOT LIMITED TO THE SERVICES CONNECTED THEREWITH ARE PROVIDED ON AN "AS IS", "WITH ALL FAULTS", AND "AS AVAILABLE" BASIS AND THE ENTIRE RISK AS TO SATISFACTORY QUALITY, PERFORMANCE, ACCURACY AND EFFORTS IS WITH THE USER. ARTHA DOES NOT MAKE ANY REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED, UNDER THESE TERMS AND CONDITIONS. ANY AND ALL REPRESENTATIONS AND WARRANTIES OF RP LTD. UNDER OR IN CONNECTION WITH THE TERMS AND CONDITIONS ARE EXCLUDED TO THE EXTENT LEGALLY POSSIBLE, INCLUDING BUT NOT LIMITED TO REPRESENTATIONS AND WARRANTIES</p>
                                                <ol>
                                                    <li>OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, WORKMANLIKE EFFORT, ERROR-FREE ACCESS TO THE WEBSITE;</li>
                                                    <li>REGARDING ANY DATA AND/OR INFORMATION PROVIDED OR MADE AVAILABLE BY ANY USER OR ON ANY EXTERNAL WEBSITES LINKED TO THE WEBSITE INCLUDING BUT NOT LIMITED TO INFORMATION BEING OF SATISFACTORY QUALITY, ADEQUACY, ACCURACY, TIMELINESS AND COMPLETENESS; AND</li>
                                                    <li>OF UNINTERRUPTED OR ERROR-FREE ACCESS OR USE OF THE WEBSITE.</li>
                                                </ol>
                                                <p align="justify"><strong>THIS DISCLAIMER OF LIABILITY APPLIES TO ANY DAMAGES OR INJURY CAUSED BY ANY FAILURE OF PERFORMANCE, ERROR, OMISSION, INACCURACY, INTERRUPTION, DELETION, DEFECT, DELAY IN OPERATION OR TRANSMISSION, COMPUTER VIRUS, COMMUNICATION LINE FAILURE, THEFT OR DESTRUCTION OR UNAUTHORIZED ACCESS TO, ALTERATION OF, OR USE OF THE SERVICES OR ARTHA , WHETHER FOR BREACH OF CONTRACT, TORTIOUS BEHAVIOR (INCLUDING, WITHOUT LIMITATION, STRICT LIABILITY), NEGLIGENCE, OR UNDER ANY OTHER CAUSE OF ACTION, TO THE FULLEST EXTENT PERMISSIBLE BY LAW. </strong></p>
                                                <p align="justify">AS THERE MAY BE ERRORS AND DEFICIENCIES IN THE INFORMATION POSTED ON THE WEBSITE RP LTD. STRONGLY SUGGESTS THAT THE USER SEEK LEGAL ADVICE PRIOR TO ANY POTENTIAL TRANSACTION. THE WEBSITE DOES NOT, AND IN NO WAY CONSTITUTES OR IMPLIES THE ENDORSEMENT, RECOMMENDATION, OR APPROPRIATENESS OF A DEAL OR INVESTMENT OPPORTUNITY.</p>
                                                <p align="justify">RP LTD. PROVIDES THE INFORMATION ON THE WEBSITE INCLUDING BUT NOT LIMITED TO ITS INFORMATION AS A RESOURCE FOR USERS BUT DOES NOT GIVE BUSINESS ADVICE, INVESTMENT ADVICE, TAX ADVICE OR LEGAL ADVICE TO THE USER OR ANYONE ELSE. RP LTD. DOES NOT CLAIM TO BE AND IS NOT A BROKER, DEALER OR INVESTMENT ADVISOR AND NOTHING HEREIN SHALL CONSTITUTE A SALE OR OFFER TO BUY OR SELL OR RECOMMEND ANYTHING. THE USER MAKES ITS OWN INVESTMENT DECISIONS BASED UPON ITS PERSONAL DUE DILIGENCE INVESTIGATION AND OTHER PERSONAL INVESTMENT CRITERIA. THE USER AGREES THAT IT USES THE WEBSITE AT ITS OWN RISK.</p>
                                                <p align="justify">THE USER SHALL INDEMNIFY, DEFEND AND HOLD HARMLESS, TO THE FULLEST EXTENT PERMITTED BY LAW, AGAINST ANY CAUSE OF ACTION, ALL LIABILITIES, LOSSES, COSTS OR EXPENSES WITH RESPECT TO ANY CLAIM BY THIRD PARTIES ARISING OUT OF THE USER'S FAILURE TO PERFORM ITS OBLIGATIONS UNDER THESE TERMS AND CONDITIONS.</p>
                                                <p align="justify">USERS WILL NOT HOLD RP LTD. AND ITS AFFILIATES, NOR THEIR RESPECTIVE OFFICERS, DIRECTORS, AGENTS, OR EMPLOYEES ACCOUNTABLE FOR ANY LOSS, DAMAGE, COST OR EXPENSE RELATING TO THE ADEQUACY, ACCURACY OR COMPLETENESS OF THE PROJECT/ENTERPRISE INFORMATION ACCESSIBLE THROUGH ARTHA OR THE USE OF THAT INFORMATION. YOU SPECIFICALLY ACKNOWLEDGE THAT ARTHA IS NOT LIABLE FOR THE DEFAMATORY, OFFENSIVE OR ILLEGAL CONDUCT OF OTHER USERS, CONTRIBUTORS OR THIRD PARTIES OVER WHICH IT HAS NO CONTROL.</p>
                                                <p align="justify">Nothing in these Terms shall exclude or in any way limit RCZ's liability for fraud, or for death and personal injury caused by its negligence, or any other liability to the extent that it cannot be excluded or limited as a matter of applicable law.</p>
                                                <h2>Intellectual Property Rights</h2>
                                                <p align="justify">The works of authorship contained on the Website, including but not limited to all copyright, designs, trademarks, logos, data, text and images, whether registered or unregistered, are the intellectual property rights of RCZ, its affiliates or third parties who have supplied information to RCZ and are protected by the applicable laws, including but not limited to international intellectual property laws, treaties and conventions.</p>
                                                <p align="justify">RCZ reserves the right to take legal action in respect of any infringement of these works of authorship or information contained on the Website, including any legal action in respect of any reproduction, copying (other than in accordance with the Terms), distribution, framing, uploading to a third party, publication, adaptation, broadcasting, public performance or other communication to the public of the works of authorship or information contained on the Website without the prior written consent of RCZ</p>
                                                <h2>Viruses</h2>
                                                <p align="justify">RCZ assumes no responsibility, and shall not be liable for, any damages to, or viruses that may infect, your computer equipment or other property on account of your access to, use of, or browsing Artha or your downloading of any materials, data, text, images, video, or audio from the Website.</p>
                                                <h2>Links</h2>
                                                <p align="justify">You may include a link on your website to the Artha home page, currently located at [http://arthaplatform.org] ("Home Page"). You may not link to an internal or subsidiary page of Artha that is located one or several levels down from the Homepage and in the internal domain portion of the site, or bring up or present Artha Platform Content within another website without prior written approval from RCZ</p>
                                                <p align="justify">The Artha Website may contain links to other websites. These websites are not under the control of RCZ and RCZ is not responsible for the contents thereof.</p>
                                                <h2>Survival</h2>
                                                <p align="justify">These Terms shall survive any termination of your use of or contribution to the Artha Platform.</p>
                                                <h2>Severability</h2>
                                                <p align="justify">If any provision of these Terms shall be deemed unlawful, void or for any reason unenforceable, then that provision shall be deemed severable from these Terms and shall not affect the validity and enforceability of any remaining provisions. In the place of an invalid provision, a valid provision is presumed to be agreed upon by the parties, which comes economically closest to the one actually agreed upon.</p>
                                                <h2>Modification of Terms</h2>
                                                <p align="justify">These Terms may be modified by RCZ in its sole discretion from time to time and such modifications shall automatically become part of these Terms and shall be effective once posted by RCZ on the Website. Your participation in the use of the Website will be subject to any such modifications. All users should review the Website and these Terms from time to time for any modifications. Neither the course of conduct between parties nor trade practice shall act to modify any provision of these Terms.</p>
                                                <h2>Privacy</h2>
                                                <ol>
                                                    <li>In the course of your use of Artha, you will be asked to provide certain information to us, and we may collect certain information about you. Our use of information you provide or otherwise collected by us through Artha is governed by our Privacy Policy. We urge you to read our Privacy Policy.</li>
                                                    <li>RCZ reserves the right at all times to disclose any information as RCZ deems necessary to satisfy any applicable law, legal process or other governmental request, to operate the Artha Platform properly, or to protect ourselves and/or the Users.</li>
                                                </ol>
                                                <h2>Comments and Feedback</h2>
                                                <p align="justify">If you have any questions or comments about the Website and would like to contact the team at RCZ, please email <a href="mailto:info@arthaplatform.com">info@arthaplatform.com</a>.</p>
                                                <h2>General</h2>
                                                <p align="justify">The parties hereto are and remain independent parties. It is not the parties' intent to create (and these Terms do not create) the formation of a partnership, joint venture or similar relationship between the parties.</p>
                                                <p align="justify">Headings are for reference purposes only and in no way define, limit, construe or describe the scope or extent of such section.</p>
                                                <p align="justify">Failure or neglect by RCZ to enforce any of the provisions of these Terms shall not be construed or deemed to be a waiver of RCZ's rights nor shall this affect the validity of the whole or any part of these Terms, nor prejudice RCZ's rights to take subsequent action.</p>
                                                <p align="justify">All rights not expressly granted herein are hereby reserved.</p>
                                                <h2>Applicable law and jurisdiction</h2>
                                                <p align="justify">All disputes arising out of or in connection with these Terms shall be finally settled under the Rules of Arbitration of the International Chamber of Commerce by three arbitrators appointed in accordance with the said Rules. The place of arbitration shall be Zurich, Switzerland. The language of the arbitral proceedings shall be the English language. Notwithstanding the foregoing, RCZ may seek recourse in any jurisdiction worldwide in order to restrain the unlawful use of any of the material contained in the Website.</p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:25px;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="terms_agree" required="required" data-error="{{trans('preregister.pre_register_terms_agree_error')}}">{{trans('preregister.pre_register_terms_agree_label')}}</label>
                                            </div>
                                            <p class="charst-sert">{{trans('preregister.pre_register_terms_agree_help_text')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-buttons-w text-right">
                                    <button class="btn btn-primary" type="submit">{{trans('preregister.pre_register_save_button_label')}}</button>
                                </div>
                            </div> 
                        </div>
                    </div>

                    <input type="hidden" id="tenantid"  name="tenantid" value="{{$tenant->tenantid}}"/>

                </form>                        
            </div>                      
        </div>
        <!-- END - login info content area -->
        <div aria-labelledby="exampleModalLabel" class="modal fade show" id="companyokmodal" role="dialog" tabindex="-1" style="display: none; padding-right: 17px;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">X</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="ng-pristine ng-valid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <h6>
                                            {{trans('preregister.pre_register_company_confirmation_message')}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mdel_close">{{trans('preregister.pre_register_company_confirmation_cancel_btn')}}</button>
                        <button class="btn btn-primary" type="button" id="btn_ok">{{trans('preregister.pre_register_company_confirmation_ok_btn')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="copy-right text-center">
        &copy; Copyright {{date('Y')}} {{$tenant->company}}. All rights reseved.
    </p>
</div>


@endsection

@section('scripts')
<script src="{{asset('js/bower_components/jquery-autocomplete/jquery.autocomplete.js')}}"></script>

<script type="text/javascript">
    var stepcontentnextglobal="#stepContent3";
    $("#btn_ok").click(function() {
        stepcontentnextglobal="#stepContent4";
        $("#companyokmodal").modal('hide');
        $("#dvCurrentData").removeClass('hidden');
        $("#stepContent2 .step-trigger-btn.next-btn").prop('href', '#stepContent4');
    });
    $("#mdel_close").click(function() {
        $("#company_id").val('');
        $("#project-id").val('');
        $("#dvCurrentData").addClass('hidden');
        $("#stepContent1 .step-trigger-btn").removeClass('hidden');
    });

    //My new condition to check
    if($("#company_id").val().length > 0)
    {
        if ($("#companyid").val() == '') {
            $(".login-info-step,.terms-step,.company-info-step").removeClass('hidden');
            $("#stepContent1 .step-trigger-btn").removeClass('hidden');
            $("#stepContent3 .require").prop('required', 'required');
        } else {
            $(".company-info-step").addClass('hidden');
            $(".login-info-step,.terms-step").removeClass('hidden');
            $("#stepContent1 .step-trigger-btn").removeClass('hidden');
            $(".step-trigger.company-info-step").addClass('complete');
        }
    }
    //

    $("#company_id").on('blur', function(e) {
        if ($("#companyid").val() == '') {
            $(".login-info-step,.terms-step,.company-info-step").removeClass('hidden');
            $("#stepContent1 .step-trigger-btn").removeClass('hidden');
            $("#stepContent3 .require").prop('required', 'required');
        } else {
            $(".company-info-step").addClass('hidden');
            $(".login-info-step,.terms-step").removeClass('hidden');
            $("#stepContent1 .step-trigger-btn").removeClass('hidden');
            $(".step-trigger.company-info-step").addClass('complete');
        }

    });
    $("#stepContent1 .step-trigger-btn,.step-trigger").click(function(event) {
        if (($.trim($("#company_id").val()) == '') || ($.trim($("#companytype").val()) == '')) {
            event.preventDefault();
            event.stopImmediatePropagation();
            event.stopPropagation();
//            $("#stepContent1 .step-trigger-btn,.step-trigger").removeAttr('href');
            $("#stepContent1 .step-trigger-btn,.step-trigger").prop('disabled', 'disabled');
            $("#stepContent1 .step-trigger-btn,.step-trigger").attr('disabled', 'disabled');
            if (($.trim($("#companytype").val()) == '')) {
                $("#companytype").parents('.form-group').addClass('has-error has-danger');
            }
            if (($.trim($("#company_id").val()) == '')) {
                $("#company_id").parents('.form-group').addClass('has-error has-danger');
            }

        }
    });
    $(document).ready(function() {

           var p_color='{{session('tenant_primary_color')}}';
           var s_color='{{session('tenant_secondary_color')}}';

         if(typeof p_color !='undefined' && p_color!='')
         {
            colorReplace("#3399ff", p_color);//"#f48220"
         }
                
         if(typeof s_color !='undefined' && s_color!='')
         {
            colorReplace("#b11f37", s_color);//"#000"
         }

         $.ajaxSetup({
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
         });

       
      $('#company_id').keyup(function() {
       $('#companytype').removeAttr('disabled');
       $('#dvCurrentData').css('display','none');
      });



        $("#company_id").autocomplete({
            minLength: 1,
            autofocus: true,
            source: function (request, response) {
                
                
        var formdata = new FormData();
        searchtext=$("#company_id").val();
        
       
        formdata.append("searchtext",searchtext);
        formdata.append("tenantid",$('#tenantid').val())
        formdata.append("_token",'{{csrf_token()}}');  

            $.ajax({ 
            url: '/projectscompanydata',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
              success: function (data) {
                var parsed = JSON.parse(data);
               

                response(parsed);
            },
            error: function (message) {
                response([]);
            }
        });
             
             },
            focus: function(event, ui) {
                event.preventDefault();
                $('#company_id').val(ui.item.label);
            },
            create: function(event, ui) {

                 debugger;
                
                $(this).data('ui-autocomplete')._renderItem = function(ul, item) {
                    
                    
                    ul.addClass('company-autocomplete-ui');
                    //return $('<li class="data-listing">').append("<a><div class='data-format'> <img src=" + item.img + " alt='' /><div class='data'> <h1>" + item.name + "</h1><p>" + item.statusmessage + "</p> </div></div>" + '</a>').appendTo(ul);
                   
                      
                     
                        var img_soruce="";
                   if(item.img.length>0){
                     img_soruce='<img src='+ item.img +' alt="" />';
                   }
                   else{
                    // @php
                    // $c_name ="VIcky Shah";
                    // @endphp
                    // img_soruce='<img src="{!! Avatar::create('item.name')->toBase64() !!}" alt="" />';
                   }
                   return $('<li class="data-listing">').append("<a><div class='data-format pre-reg-img'> "+img_soruce+" <div class='data'> <h1>" + item.name + "</h1><p>" + item.statusmessage + "</p> </div></div>" + '</a>').appendTo(ul);
                
                };
              
            },
            select: function(event, ui) {
                $("#company_id").val(ui.item.name);
                $("#companyid").val(ui.item.companyid);
                $("#companytype").val(ui.item.companytypeid);
                $("#companytype").attr('disabled', 'disabled');
                $('#dvCurrentData').css('display','block');
                $("#dvCurrentData img").attr('src', ui.item.img);
                $("#dvCurrentData .data h1").text(ui.item.name);
                $("#dvCurrentData .data p").text(ui.item.statusmessage);
                $("#companyokmodal").modal('show');
                return false;
            },
        });
    });

    function validatestep3()
    {
         
         var businesssummary=$('#businesssummary').val();
         var zip=$('#zip').val();
         var country=$('#country').val();
         var state=$('#state').val();
         if( businesssummary.length==0 || zip.length==0||country.length==0||state.length==0)
         {
              $('#step_3_error').html('{{trans('tenant_login_info.login_information_all_data')}}');
              $('#step_3_error').show();
              $("#btnnext_step3").attr("href", '#stepContent3');
         }
         else{
            $('#step_3_error').hide();
              $("#btnnext_step3").attr("href", '#stepContent4');
         }
    }

    function checkforemailandpassword()
    {
        
        var flag = false;
        
        var firstname=$('#firstname').val();
        var lastname=$('#lastname').val();
        //var telephone=$('#telephone').val();
        var jobtitle=$('#jobtitle').val();
        var password = $('#inputPassword').val();
        var password1 = $('#confirmpassword').val();
        var email = $('#emailcheck').val();
        var href=$('.step-trigger.login-info-step.active').attr('href');
        var nexthref=stepcontentnextglobal;
        
        if(firstname.length==0 || jobtitle.length==0||password.length==0||password1.length==0)
        {
              $('#emailnotification').html('{{trans('tenant_login_info.login_information_all_data')}}');
              $('#emailnotification').show();
              $(".btn.btn-primary.step-trigger-btn.next-btn").attr("href", href);
        }
        else if(firstname.length>0  && jobtitle.length>0 && password.length>0 && password1.length>0 && password!=password1)
        {
              $('#emailnotification').html('{{trans('tenant_login_info.login_information_password_match')}}');
              $('#emailnotification').show();
              $(".btn.btn-primary.step-trigger-btn.next-btn").attr("href", href);
        }
       
        else if(firstname.length>0 && jobtitle.length>0 && password.length>0 && password1.length>0 && password==password1)
        {
             var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!(regex.test(email)))
            {
             $('#emailnotification').html('{{trans('tenant_login_info.login_informtion_not_valid_email')}}');
              $('#emailnotification').show();
              
              $(".btn.btn-primary.step-trigger-btn.next-btn").attr("href", href);
            }
            else
            {
                var formData = new FormData();
                formData.append("email", email);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/checkemailpreregister',
            type: "POST",
            data: {email: $('#emailcheck').val(),tenantid:$('#tenantid').val()},
            cache: false,
            timeout: 100000,
            async: false,
            success: function(data) {

                if(data>0)
                {
              $('#emailnotification').html('{{trans('tenant_login_info.login_information_email_exist')}}');
              $('#emailnotification').show();
              
              $(".btn.btn-primary.step-trigger-btn.next-btn").attr("href", href); 
                }
                else if(data==0)            
                {
                    $('#emailnotification').hide();
                    $(".btn.btn-primary.step-trigger-btn.next-btn").attr("href", nexthref); 
                }
                


            },
            error: function(err, result) {
                debugger;
                alert("Error" + err.responseText);
            }
        });
                
                
                
            }
            
        }
        

    }


 



                function colorReplace(findHexColor, replaceWith) {
                  // Convert rgb color strings to hex
                  function rgb2hex(rgb) {
                    if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;
                    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
                    function hex(x) {
                      return ("0" + parseInt(x).toString(16)).slice(-2);
                    }
                    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
                  }
      
                  // Select and run a map function on every tag
                  $('*').map(function(i, el) {
                    // Get the computed styles of each tag
                    var styles = window.getComputedStyle(el);
      
                    // Go through each computed style and search for "color"
                    Object.keys(styles).reduce(function(acc, k) {
                      var name = styles[k];
                      var value = styles.getPropertyValue(name);
                      if (typeof name === 'undefined' || name === null) {
                      } else {
                         if (name.indexOf("color") >= 0) {
                          // Convert the rgb color to hex and compare with the target color
                          if (value.indexOf("rgb(") >= 0 && rgb2hex(value) === findHexColor) {
                            // Replace the color on this found color attribute
                            $(el).css(name, replaceWith);
                          }
                        }
                      }
                    });
                  });
                }
                // Call like this for each color attribute you want to replace


       $('.step-trigger').css('pointer-events','none');
  


</script>
@stop
