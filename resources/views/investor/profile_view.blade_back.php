@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')
 <div class="content-w investor-profil" ng-app="myApp">
        @include('shared._top_menu')

        <div class="content-i">
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
                      Arta Venture
                    </h1>
                    <h5 class="up-sub-header">
                      Investor
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
                          {{ $data['country']->name }}
                        </div>
                      </div>
                      @php
                        $profile_image = asset('storage/company/profileimage/'.$data['company_information']->profileimage);
                      @endphp
                      <div class="rianta-img float-right text-right">
                        <img src="{{ $profile_image }}" style="width:170px;height:135px" class="img-responsive" />
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
                          <h5>{{$data['company_information']->address}}</h5>
                      </div>
                    </div>
                </div>
                <div class="up-contents investment-pdtop">
                    <h5 class="element-header">
                        {{trans('frontend/investor/company/view.investment.caption')}}
                    </h5>
                    <div class="row invst-pfl">
                      <div class="col-sm-5">
                        <div class="label">
                          {{trans('frontend/investor/company/view.investment.years_in_impact_investing')}}
                        </div>
                        <h5>{{$data['company_information']->yearsinvolved }}</h5>
                      </div>
                      <div class="col-sm-7">
                          <div class="label">
                            {{trans('frontend/investor/company/view.investment.number_of_investments_to_date')}}
                          </div>
                          <h5>{{$data['company_information']->numbertodate}}</h5>
                        </div>
                    </div>
                    <div class="row invst-pfl">
                      <div class="col-sm-5">
                        <div class="label">
                          {{trans('frontend/investor/company/view.investment.preferred_avg_investment_size')}}
                        </div>
                        <h5>{{$data['company_information']->preferedinvestmentaveragesize}}</h5>
                      </div>
                      <div class="col-sm-7">
                        <div class="label">
                          {{trans('frontend/investor/company/view.investment.funds_under_management')}}
                        </div>
                        <h5>{{$data['company_information']->fundsundermanagement}}</h5>
                      </div>
                    </div>
                    <div class="row invst-pfl">
                      <div class="col-sm-5">
                        <div class="label">
                          {{trans('frontend/investor/company/view.investment.invest_on_behalf_of_institution')}}
                        </div>
                        <h5>{{ ( $data['company_information']->isonbehalfofinstitution )? "Yes" : "No" }}</h5>
                      </div>
                      <div class="col-sm-7">
                        <div class="label">
                        {{trans('frontend/investor/company/view.investment.sector_of_specialization')}}
                      </div>
                        <h5>Energy and Power, Agriculture Products, Other</h5>
                      </div>
                    </div>
                    <div class="row invst-pfl">
                        <div class="col-sm-5">
                          <div class="label">
                            {{trans('frontend/investor/company/view.investment.typical_level_of_involvement')}}
                          </div> 
                          <h5>{{$data['company_information']->levelofinvolvement}}</h5>
                        </div>
                        <div class="col-sm-7">
                          <div class="label">
                          {{trans('frontend/investor/company/view.investment.number_of_employees')}}
                          </div>
                          <h5>{{$data['company_information']->numberofemployees}}</h5>
                        </div>
                      </div>
                    
                  </div>

                <div class="up-contents brdtop">
                  <div class="mission-row">
                    <h5 class="element-inner-header">
                      Our Mission
                    </h5>
                    <div class="element-inner-desc">{{ $data['company_information']->mission }}</div>
                  </div>
                  <div class="mission-row">
                    <h5 class="element-inner-header">
                      {{trans('frontend/investor/company/view.investment.intended_investment_outcomes')}}
                    </h5>
                    <div class="element-inner-desc">{{ $data['company_information']->outcomes }}</div>
                  </div>
                </div>
              </div>
            </div>
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
                <div class="form-desc">This virtual filing cabinet is a space for you to upload any materials (including brochures, summaries) that
                  support the communication of your core activity </div>
                <div class="controls-above-table">
                  <div class="row">
                    <div class="col-sm-12">
                      <form class="form-inline justify-content-sm-end">
                        <!--<input class="form-control form-control-sm rounded bright" id="public_document" onkeyup="publicDocuments()" placeholder="{{trans('frontend/investor/company/view.documents.public.search')}}" type="text">-->
<input ng-model='public_search.documentname' class="form-control form-control-sm rounded bright" placeholder="{{trans('frontend/investor/company/view.documents.public.search')}}" type="text">
                        <select ng-model='sortByPublic' class="form-control form-control-sm rounded bright">
                                <option selected="selected" value="">
                                  {{trans('frontend/investor/company/edit.documents.public.sort')}}
                                </option>
                              <option value="documentname">File Name </option>
                              <option value="extention">Type</option>
                              <option value="updated" >Date</option>
                             </select>
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
                  <table class="table table-lightborder" ng-controller="document">
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

                         <!-- @if($data['documents']->isNotEmpty())
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
                            @endif -->

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="element-box">
                <h5 class="form-header">
                   {{trans('frontend/investor/company/view.documents.private.caption')}}
                </h5>
                <div class="form-desc">This virtual filing cabinet is a space for you to upload any materials (including brochures, summaries) that
                  support the communication of your core activity </div>
                <div class="controls-above-table">
                  <div class="row">
                    <div class="col-sm-12">
                      <form class="form-inline justify-content-sm-end">
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
                  <table class="table table-lightborder"  ng-controller="document">
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
                     <!--
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
                        -->
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
                      <img src="{{ asset('img/video-test.jpg')}}" alt="Play Video" class="img-responsive" />
                    </a>
                    <div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingWideFeaturesModal" role="dialog" tabindex="-1">
                      <div class="modal-dialog modal-lg modal-centered" role="document">
                        <div class="modal-content text-center">
                          <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span class="close-label">Skip Intro</span>
                            <span class="os-icon os-icon-close"></span>
                          </button>
                          <div class="onboarding-side-by-side">
                             @php
                             $video_path = false;
                             if($data['videofile'] != null) {
                              $video_path = asset('storage/company/videos/'.$data['videofile']->videopath);
                             }
                            @endphp
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

 <!--    <script>
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
-->
<script>
function sortTable(n) {
  var n = document.getElementById("mySelect").value;
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable2");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++; 
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>

 @endsection     
