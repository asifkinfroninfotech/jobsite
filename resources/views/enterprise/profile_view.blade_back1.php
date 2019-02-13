@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')

      <div class="content-w investor-profile-view">
       @include('shared._top_menu')

        <div class="content-i enterprise-company-profile">
          <div class="content-box">
            <div class="element-wrapper">
              <div class="user-profile">
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
                    <h1 class="up-header">
                     Kinara Capital 
                    </h1>
                    <h5 class="up-sub-header">
                      Enterprise
                    </h5>
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
                      <div class="value-pair float-left">
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
                      <div class="rianta-img float-right text-right">
                        <img src="{{ $profile_image }}" class="img-responsive" />
                      </div>
                    </div>
                    
                  </div>
                </div>
                <div class="up-contents">
                  <h5 class="element-header">
                      {{trans('frontend/investor/company/view.general.company_caption')}}
                  </h5>
                  <div class="row invst-pfl">
                    <div class="col-sm-5">
                      <div class="label">
                        {{trans('frontend/investor/company/view.general.company_name')}}
                      </div>
                      <h5>{{$data['company_information']->name}}</h5>
                    </div>
                    <div class="col-sm-7">
                        <div class="label">
                          {{trans('frontend/investor/company/view.general.telephone')}}
                        </div>
                        <h5>{{$data['company_information']->telephone}}</h5>
                      </div>
                  </div>
                  <div class="row invst-pfl">
                    <div class="col-sm-5">
                      <div class="label">
                        {{trans('frontend/investor/company/view.general.website')}}
                      </div>
                      <h5>{{$data['company_information']->website}}</h5>
                    </div>
                    <div class="col-sm-7">
                      <div class="label">
                        {{trans('frontend/investor/company/view.general.email')}}
                      </div>
                      <h5>{{$data['company_information']->email}}</h5>
                    </div>
                  </div>
                  <div class="row invst-pfl">
                    <div class="col-sm-5">
                      <div class="label">
                        {{trans('frontend/investor/company/view.general.skype')}}
                      </div>
                      <h5>{{$data['company_information']->skype}}</h5>
                    </div>
                    <div class="col-sm-7">
                      <div class="label">
                        {{trans('frontend/investor/company/view.general.twitter')}}
                      </div>
                      <h5>{{$data['company_information']->twitter}}</h5>
                    </div>
                  </div>
                  <div class="row invst-pfl">
                      <div class="col-sm-12 col-lg-6">
                        <div class="label">
                          {{trans('frontend/investor/company/view.general.address')}}
                        </div>
                        <h5>United House,North Road
                          <br>{{ $data['company_information']->address }}</h5>
                      </div>
                    </div>
                </div>
                <div class="up-contents investment-pdtop">
                    <h5 class="element-header">
                       Business Profile 
                    </h5>
                    <div class="row invst-pfl">
                      <div class="col-sm-5">
                        <div class="label">Years Founded</div>
                        <h5>{{ $data['company_information']->foundedyear }}</h5>
                      </div>
                      <div class="col-sm-7">
                          <div class="label">Preferred currency</div>
                          <br>{{ $data['currency']->currencyname.  " ( "  .$data['currency']->code.  " ) "   }}</h5>
                        </div>
                    </div>
                    <div class="row invst-pfl">
                      <div class="col-sm-5">
                        <div class="label">Type of Entity</div>
                        <br>{{ $data['entity_type']->companytype }}</h5>
                      </div>
                      <div class="col-sm-7">
                        <div class="label">Sector</div>
                        <h5>{{ $data['sector']->name }}</h5>
                      </div>
                    </div>
                    <div class="row invst-pfl">
                      <div class="col-sm-5">
                        <div class="label">Number of Employees</div>
                        <br>{{ count($data['team_member']) }}</h5>
                      </div>
                      <div class="col-sm-7">
                        <div class="label">Tax ID</div>
                        <br>{{ $data['company_information']->taxidnumber }}</h5>
                      </div>
                    </div>
                    <div class="row invst-pfl">
                        <div class="col-sm-5">
                          <div class="label">Preferred By</div>
                          <br>{{ $data['prefered_by']->name }}</h5>
                        </div>                       
                      </div>
                </div>

                <div class="up-contents brdtop">
                  <div class="mission-row">
                    <h5 class="element-inner-header">
                        Business Summary
                    </h5>
                    <div class="element-inner-desc">
                      {{ $data['company_information']->businesssummary }}
                    </div>
                  </div>
                  <div class="mission-row">
                    <h5 class="element-inner-header">
                      One Line Pitch
                    </h5>
                    <div class="element-inner-desc">
                      {{ $data['company_information']->onelinepitch }}
                    </div>
                  </div>
                  <div class="mission-row">
                      <h5 class="element-inner-header">
                       Sales / Marketing Strategy
                      </h5>
                      <div class="element-inner-desc">
                        {{ $data['company_information']->salesstrategy }}
                      </div>
                  </div>
                  <div class="mission-row">
                        <h5 class="element-inner-header">
                         Competitive Advantage
                        </h5>
                        <div class="element-inner-desc">
                          {{ $data['company_information']->competativeadvantage }}
                        </div>
                  </div>
                  <div class="mission-row">
                        <h5 class="element-inner-header">
                            Existing Patents or Patents Pending
                        </h5>
                        <div class="element-inner-desc">
                          {{ $data['company_information']->existingpatents }}
                        </div>
                  </div>
                       
                <div class="mission-row">
                    <h5 class="element-inner-header">
                        Have the enterprise won any business competitions, recognition?
                    </h5>
                    <div class="element-inner-desc">
                      {{ $data['company_information']->recognition }}
                    </div>
                </div>
                </div>
              </div>
            </div>

              <!--------------------
                START - Financial Information
              -------------------->

              <div class="element-wrapper margin-top">                 
                  <h5 class="element-header">
                      Financial Information
                  </h5>
                  <div class="user-profile">
                  <div class="up-contents financial-hd-fist">
                      <h5 class="form-header">
                          Past Financials
                      </h5>

                       @if($data['historical_data']->isNotEmpty())
                          @php $count = 1; @endphp
                          @foreach($data['historical_data'] as $historical_data )

                        <div class="enterprise-sub-hd">
                          <strong>Historical 1 </strong>    
                        </div>
                        <div class="row invst-pfl">
                          <div class="col-sm-5">
                            <div class="label">Years</div>
                            <h5>{{ $historical_data->historical_year }}</h5>
                          </div>
                          <div class="col-sm-7">
                              <div class="label">Annual Operating Cost</div>
                              <h5>{{ $historical_data->annualoperatingcosts }}</h5>
                            </div>
                        </div>
                        <div class="row invst-pfl">
                            <div class="col-sm-5">
                              <div class="label">Average Annual  Revenues</div>
                              <h5>{{ $historical_data->averageannualrevenue }}</h5>
                            </div>
                            <div class="col-sm-7">
                                <div class="label">Average Net Income</div>
                                <h5>{{ $historical_data->averagenetincome }}</h5>
                            </div>
                        </div>
                            @php $count = $count + 1; @endphp
                            @endforeach
                          @endif

                         <!--  END Historical  -->
                            
                  </div>

                  <div class="up-contents brdtop">
                      <h5 class="form-header">
                          Current Financials
                      </h5>
                      <div class="row invst-pfl">
                          <div class="col-sm-5">
                            <div class="label">Information as of (year) </div>
                            <h5>{{ $data['company_information']->financialinfo_informationdate }}</h5>
                          </div>
                          <div class="col-sm-7">
                              <div class="label">Current Assest</div>
                              <h5>{{ $data['company_information']->financialinfo_currentassets }}</h5>
                            </div>
                        </div>
                        <div class="row invst-pfl">
                            <div class="col-sm-5">
                              <div class="label">Total Assest </div>
                              <h5>{{ $data['company_information']->financialinfo_totalassets }}</h5>
                            </div>
                            <div class="col-sm-7">
                                <div class="label">Current Liabilities</div>
                                <h5>{{ $data['company_information']->financialinfo_currentliabilities }}</h5>
                              </div>
                          </div>
                          <div class="row invst-pfl">
                              <div class="col-sm-5">
                                <div class="label">Total Liabilities </div>
                                <h5>{{ $data['company_information']->financialinfo_totalliabilities }}</h5>
                              </div>
                              <div class="col-sm-7">
                                  <div class="label">Current Equity</div>
                                  <h5>{{ $data['company_information']->financialinfo_totalequity }}</h5>
                                </div>
                            </div>
                            <div class="row invst-pfl">
                                <div class="col-sm-5">
                                  <div class="label">Net Cash</div>
                                  <h5>{{ $data['company_information']->financialinfo_netcash }}</h5>
                                </div>
                                <div class="col-sm-7">
                                    <div class="label">Ebitda</div>
                                    <h5>{{ $data['company_information']->financialinfo_ebitda }}</h5>
                                  </div>
                              </div>
                              <div class="row invst-pfl">
                                  <div class="col-sm-5">
                                    <div class="label">Do you have audited financial statements?</div>
                                    <h5>{{ $data['company_information']->financialinfo_auditedfinancialstatement }}</h5>
                                  </div>
                                  
                                </div>
                    </div>

                    

                  </div>
              </div> 
              
              <div class="element-wrapper margin-top">                 
                  <h5 class="element-header">
                      Impact Information
                  </h5>
                  <div class="user-profile">
                  <div class="up-contents">
                      <div class="mission-row">
                          <h5 class="element-inner-header">
                              Problem being solved
                          </h5>
                          <div class="element-inner-desc">
                           {{ $data['company_information']->impactinfo_info }}
                          </div>
                        </div>
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                Social impact benefit created
                            </h5>
                            <div class="element-inner-desc">
                              {{ $data['company_information']->impactinfo_socialbenefitimpact }}
                            </div>
                          </div>
                          <div class="mission-row">
                              <h5 class="element-inner-header">
                                  Environmental impact benefit created
                              </h5>
                              <div class="element-inner-desc">
                                {{ $data['company_information']->impactinfo_environmentbenefitimpact }}
                              </div>
                            </div>
                            <div class="mission-row">
                                <h5 class="element-inner-header">
                                    Specific impact beneficiaries
                                </h5>
                                <div class="element-inner-desc">
                                  {{ $data['company_information']->impactinfo_specificbeneficiaries }}
                                </div>
                              </div>
                          
                    </div>
                  </div>
                  
               </div>      
              <!--------------------
              END - Financial Information
              -------------------->


            <div class="element-wrapper margin-top">
              <!--------------------
              START - documents table 
              -------------------->
              <h5 class="element-header">
                Documents
              </h5>
              <div class="element-box">
                <h5 class="form-header">
                  {{trans('frontend/investor/company/view.documents.public.caption')}}
                </h5>
                <div class="form-desc">
                  {{ ''}} 
                </div>
                <div class="controls-above-table">
                  <div class="row">
                    <div class="col-sm-12">
                      <form class="form-inline justify-content-sm-end">
                        <input class="form-control form-control-sm rounded bright" placeholder="Search" type="text">
                        <select class="form-control form-control-sm rounded bright">
                          <option selected="selected" value="">
                            {{trans('frontend/investor/company/view.documents.public.sort')}}
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
                            {{trans('frontend/investor/company/view.documents.public.select_filter_type')}}
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
                          {{trans('frontend/investor/company/view.documents.public.table.name')}}
                        </th>
                        <th class="type">
                          {{trans('frontend/investor/company/view.documents.public.table.type')}}
                        </th>
                        <th class="format">
                          {{trans('frontend/investor/company/view.documents.public.table.format')}}
                        </th>
                        <th class="date">
                          {{trans('frontend/investor/company/view.documents.public.table.date')}}
                        </th>
                        <th class="action">
                          {{trans('frontend/investor/company/view.documents.public.table.action')}}
                        </th>
                      </tr>
                    </thead>
                    <tbody id="public_document_table">
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
              <div class="element-box">
                <h5 class="form-header">
                  {{trans('frontend/investor/company/view.documents.private.caption')}}
                </h5>
                <div class="form-desc">
                  {{ ' '}} </div>
                <div class="controls-above-table">
                  <div class="row">
                    <div class="col-sm-12">
                      <form class="form-inline justify-content-sm-end">
                        <input class="form-control form-control-sm rounded bright" placeholder="Search" type="text">
                        <select class="form-control form-control-sm rounded bright">
                          <option selected="selected" value="">
                            {{trans('frontend/investor/company/view.documents.private.sort')}}
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
                            {{trans('frontend/investor/company/view.documents.private.select_filter_type')}}
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
                          {{trans('frontend/investor/company/view.documents.private.table.name')}}
                        </th>
                        <th class="type">
                          {{trans('frontend/investor/company/view.documents.private.table.type')}}
                        </th>
                        <th class="format">
                          {{trans('frontend/investor/company/view.documents.private.table.format')}}
                        </th>
                        <th class="date">
                          {{trans('frontend/investor/company/view.documents.private.table.date')}}
                        </th>
                        <th class="action">
                          {{trans('frontend/investor/company/view.documents.private.table.action')}}
                        </th>
                      </tr>
                    </thead>
                    <tbody  id="myTable">
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
                      {{ $data['company_information']->referredbyid }}
                    </div>
                  </div>
                  <div class="message self">
                    <div class="message-content">
                      {{ $data['company_information']->referredbyid }}
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
          <!--------------------
            START - Sidebar
            -------------------->
          <div class="content-panel">
            <div class="content-panel-close">
              <i class="os-icon os-icon-close"></i>
            </div>
            <div class="element-wrapper">
              <h6 class="element-header">
                {{trans('frontend/investor/company/view.general.team_member')}}
              </h6>
              <div class="element-box-tp">
                <div class="input-search-w">
                  <input class="form-control rounded bright" id="myInput" onkeyup="memberSearch()"  placeholder="{{trans('frontend/investor/company/view.general.search_team_member')}}" type="search">
                </div>
                <div class="users-list-w">
                  <div id="members">
                  @foreach($data['team_member'] as $members)
                  <span>
                  <div class="user-w with-status status-green" >
                    <div class="user-avatar-w">
                      <div class="user-avatar">
                        <img alt="" src="img/avatar1.jpg">
                      </div>
                    </div>
                    <div class="user-name">
                      <h6 class="user-title">
                        <a> {{$members[0]->username}} </a>
                      </h6>
                      <div class="user-role">
                        Account Manager
                      </div>
                    </div>
                    <div class="user-action">
                      <a href="">
                        <div class="os-icon os-icon-link-3">&nbsp;</div>
                      </a>
                    </div>
                  </div>
                 </span>
                  @endforeach
                  </div>
                </div>
              </div>
            </div>
            <!--------------------
               start - right section video
              -------------------->
            <div class="video-rit">
              <div class="element-wrapper">
                <h6 class="element-header">
                  {{trans('frontend/investor/company/view.general.video')}}
                </h6>
                <div class="element-box">
                  <div class="el-chart-w">
                    <a class="video-play" data-target="#onboardingWideFeaturesModal" data-toggle="modal">
                      <img src="{{ asset('img/video-test.jpg') }}" alt="Play Video" class="img-responsive" />
                    </a>
                    <div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingWideFeaturesModal" role="dialog" tabindex="-1">
                      <div class="modal-dialog modal-lg modal-centered" role="document">
                        <div class="modal-content text-center">
                          <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span class="close-label">Skip Intro</span>
                            <span class="os-icon os-icon-close"></span>
                          </button>
                           @php
                             $video_path = false;
                             if($data['videofile'] != null) {
                              $video_path = asset('storage/company/videos/'.$data['videofile']->videopath);
                             }
                            @endphp
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

          </div>
          <!--------------------
            END - Sidebar
            -------------------->
        </div>
      </div>

      <script>
          function memberSearch() {
          var input, filter, members, span, a, i;
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          members = document.getElementById("members");
          span = members.getElementsByTagName("span");
          for (i = 0; i < span.length; i++) {
              a = span[i].getElementsByTagName("a")[0];
              if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                  span[i].style.display = "";
              } else {
                  span[i].style.display = "none";

              }
          }
      }
      </script>

     <script>
      function documents() {
        // Declare variables 
        var input, filter, table, tr, td, i;
        input = document.getElementById("document");
        table = document.getElementById("myTable");
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
