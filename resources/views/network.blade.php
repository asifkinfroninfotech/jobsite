<!DOCTYPE html>
<html>
<head>
  <title>Artha</title>
  <meta charset="utf-8">
  <meta content="ie=edge" http-equiv="x-ua-compatible">
  <meta content="Artha language" name="keywords">
  <meta content="Artha" name="author">
  <meta content="Artha dashboard" name="description">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  @include('shared._html_header')
  <style type="text/css">
    /* Style the tab content */
/*.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}*/

/* Style the buttons inside the tab */
/*.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}*/

/* Change background color of buttons on hover */
/*.tab button:hover {
    background-color: #ddd;
}*/

/* Create an active/current tablink class */
/*.tab button.active {
    background-color: #ccc;
}*/

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
  </style>
</head>

<body class="with-content-panel">
  <div class="all-wrapper menu-side with-side-panel">
    <div class="layout-w">
      @include('shared._html_header')
      <!--------------------
        START - Menu side compact 
        -------------------->
      <div class="desktop-menu menu-side-compact-w menu-activated-on-hover">
        <div class="logo-w">
          <a class="logo" href="index.html">
            <img src="img/logo.png">
          </a>
        </div>
        <div class="menu-and-user">

          <ul class="main-menu">
            <li>
              <a href="index.html">
                <div class="icon-w">
                  <i class="os-icon os-icon-window-content"></i>
                </div>
              </a>
            </li>
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-bar-chart-stats-up"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                  Portfolio
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-bar-chart-stats-up"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                    <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2
                        <strong class="badge badge-danger">New</strong>
                      </a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li>
                  </ul>
                  <ul class="sub-menu">
                    <li>
                      <a href="#">Link 5</a>
                    </li>
                    <li>
                      <a href="#">Link 6</a>
                    </li>
                    <li>
                      <a href="#">Link 7</a>
                    </li>
                    <li>
                      <a href="#">Link 8</a>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-pie-chart-1"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                  Enterprise Pipeline
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-pie-chart-1"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                    <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2</a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li>
                  </ul>
                  <ul class="sub-menu">
                    <li>
                      <a href="#">Link 5</a>
                    </li>
                    <li>
                      <a href="#">Link 6</a>
                    </li>
                    <li>
                      <a href="#">Link 7</a>
                    </li>
                    <li>
                      <a href="#">Link 8</a>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-hierarchy-structure-2"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                  Network
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-hierarchy-structure-2"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                    <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2</a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-documents-07"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                  Company Profile
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-documents-07"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                    <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2</a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li>
                  </ul>
                  <ul class="sub-menu">
                    <li>
                      <a href="#">Link 5</a>
                    </li>
                    <li>
                      <a href="#">Link 6</a>
                    </li>
                    <li>
                      <a href="#">Link 7</a>
                    </li>
                    <li>
                      <a href="#">Link 8</a>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-user-male-circle"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                  My Profile
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-user-male-circle"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                    <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2</a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
            <li class="has-sub-menu">
              <a href="#">
                <div class="icon-w">
                  <i class="os-icon os-icon-cv-2"></i>
                </div>
              </a>
              <div class="sub-menu-w">
                <div class="sub-menu-title">
                  Teams
                </div>
                <div class="sub-menu-icon">
                  <i class="os-icon os-icon-cv-2"></i>
                </div>
                <div class="sub-menu-i">
                  <ul class="sub-menu">
                    <li>
                      <a href="#">Link 1</a>
                    </li>
                    <li>
                      <a href="#">Link 2</a>
                    </li>
                    <li>
                      <a href="#">Link 3</a>
                    </li>
                    <li>
                      <a href="#">Link 4</a>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <!--------------------
        END - Menu side compact 
        -------------------->

      <div class="content-w portfolio-custom-vk">
        <!--------------------
          START - Secondary Top Menu
          -------------------->
        <div class="top-menu-secondary">
          <!--------------------
              START - Top Menu Controls
              -------------------->
          <div class="top-menu-controls">
            <div class="element-search d-none d-xl-block">
              <input placeholder="Start typing to search..." type="text">
            </div>
            <div class="top-icon top-search os-dropdown-trigger d-xl-none">
              <i class="os-icon os-icon-ui-37"></i>
              <div class="os-dropdown light mobile-search">
                <input placeholder="Start typing to search..." type="text">
              </div>
            </div>
            <!--------------------
                START - Messages Link in secondary top menu
                -------------------->
            <div class="messages-notifications os-dropdown-trigger os-dropdown-center">
              <i class="os-icon os-icon-mail-14"></i>
              <div class="new-messages-count">
                12
              </div>
              <div class="os-dropdown light message-list">
                <div class="icon-w">
                  <i class="os-icon os-icon-mail-14"></i>
                </div>
                <ul>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="img/avatar1.jpg">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          John Bloggs
                        </h6>
                        <h6 class="message-title">
                          Director
                        </h6>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="img/avatar2.jpg">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          Phil Jones
                        </h6>
                        <h6 class="message-title">
                          Secutiry Updates
                        </h6>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="img/avatar3.jpg">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          Bekky Simpson
                        </h6>
                        <h6 class="message-title">
                          Vacation Rentals
                        </h6>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user-avatar-w">
                        <img alt="" src="img/avatar4.jpg">
                      </div>
                      <div class="message-content">
                        <h6 class="message-from">
                          Alice Priskon
                        </h6>
                        <h6 class="message-title">
                          Payment Confirmation
                        </h6>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <!--------------------
                END - Messages Link in secondary top menu
                -------------------->
            <!--------------------
                START - Settings Link in secondary top menu
                -------------------->
            <div class="top-icon top-settings os-dropdown-trigger os-dropdown-center">
              <i class="os-icon os-icon-ui-46"></i>
              <div class="os-dropdown">
                <div class="icon-w">
                  <i class="os-icon os-icon-ui-46"></i>
                </div>
                <ul>
                  <li>
                    <a href="#">
                      <i class="os-icon os-icon-ui-49"></i>
                      <span>Profile Settings</span>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="os-icon os-icon-grid-10"></i>
                      <span>Billing Info</span>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="os-icon os-icon-ui-44"></i>
                      <span>My Invoices</span>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="os-icon os-icon-ui-15"></i>
                      <span>Deactivate Account</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <!--------------------
                END - Settings Link in secondary top menu
                -------------------->
            <!--------------------
                START - User avatar and menu in secondary top menu
                -------------------->
            <div class="logged-user-w">
              <div class="logged-user-i">
                <div class="avatar-w">
                  <img alt="" src="img/avatar1.jpg">
                </div>
                <div class="logged-user-menu">
                  <div class="logged-user-avatar-info">
                    <div class="avatar-w">
                      <img alt="" src="img/avatar1.jpg">
                    </div>
                    <div class="logged-user-info-w">
                      <div class="logged-user-name">
                        Maria Gomez
                      </div>
                      <div class="logged-user-role">
                        Administrator
                      </div>
                    </div>
                  </div>
                  <div class="bg-icon">
                    <i class="os-icon os-icon-wallet-loaded"></i>
                  </div>
                  <ul>
                    <li>
                      <a href="#">
                        <i class="os-icon os-icon-mail-01"></i>
                        <span>Incoming Mail</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="os-icon os-icon-user-male-circle2"></i>
                        <span>Profile Details</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="os-icon os-icon-coins-4"></i>
                        <span>Billing Details</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="os-icon os-icon-others-43"></i>
                        <span>Notifications</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="os-icon os-icon-signs-11"></i>
                        <span>Logout</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <!--------------------
                END - User avatar and menu in secondary top menu
                -------------------->
          </div>
          <!--------------------
              END - Top Menu Controls
              -------------------->
        </div>
        <!--------------------
            END - Secondary Top Menu
            -------------------->

        <div class="content-panel-toggler">
          <i class="os-icon os-icon-grid-squares-22"></i>
          <span>Sidebar</span>
        </div>
        <!--START - Control panel above projects-->
        <div class="content-i control-panel">
          <div class="content-box-tb">
            <div class="os-tabs-w">
              <div class="os-tabs-controls tab">
                <ul class="nav nav-tabs upper">
                 
                  <!-- <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">London</button>
                  <button class="tablinks" onclick="openCity(event, 'Paris')">Paris</button>
                  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Tokyo</button>
</div> -->


                  <li class="nav-item">
                    <a  onclick="openCity(event, 'Investors')" aria-expanded="false" class="nav-link tablinks" data-toggle="tab" href="#Investors"> Investors </a>
                  </li>
                  <li class="nav-item">
                    <a  onclick="openCity(event, 'Enterprises')" id="defaultOpen" aria-expanded="false" class="nav-link active tablinks" data-toggle="tab" href="#Enterprises"> Enterprises </a>
                  </li>
                  <li class="nav-item">
                    <a  onclick="openCity(event, 'third-parties')" aria-expanded="false" class="nav-link tablinks" data-toggle="tab" href="#third-parties"> Third Parties</a>
                  </li>
                  <li class="nav-item">
                    <a onclick="openCity(event, 'esos')" aria-expanded="false" class="nav-link tablinks" data-toggle="tab" href="#esos">  Eso's</a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)" onclick="openCity(event, 'other-contacts');" aria-expanded="false" class="nav-link tablinks" data-toggle="tab" href="#other-contacts"> Other Contacts</a>
                  </li>
                 
                </ul>
                
              </div>
            </div>
          </div>
        </div>
        <!--END - Control panel above projects-->

        <div class="content-i">
          <div class="content-box">
            <!--------------------
              start - Network
              -------------------->
            <div class="row">
              <div class="col-sm-12">
                <div class="element-wrapper">
                  <h6 class="element-header">
                    Network
                  </h6>
                  <div class="controls-above-table filter-row-top">
                    <div class="row">
                      <div class="col-sm-12">
                        <form class="form-inline justify-content-sm-end">
                          <input class="form-control form-control-sm rounded bright" placeholder="Search" type="text">
                          <select class="form-control form-control-sm rounded bright">
                            <option selected="selected" value="">
                              Sort By
                            </option>
                            <option value="Pending">
                              Name
                            </option>
                            <option value="Active">
                              Age
                            </option>
                          </select>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!--START - Network table -->
                  <div class="element-box-tp">
                    <div class="table-responsive">
                      <table class="table table-padded">
                        <thead>
                          <tr>
                            <th>
                              Company Name
                            </th>
                            <th>
                             Sector (s)
                            </th>                           
                            <th class="text-right">
                              Action
                            </th>                            
                          </tr>
                        </thead>
                        <tbody>
                          
                           
                           <div id="Investors" class="tabcontent">
                              @if(isset($networks['Investors']))
                                  @foreach($networks['Investors'] as $name => $sector)
                                    {{$name}} <br>
                                    @foreach($sector as $sectors)
                                       @foreach($sectors as $companysector)
                                         @if(isset($companysector) && !empty($companysector))
                                           {{ $companysector->name }}<br>
                                         @else
                                           {{ "No Sector Found" }}<br>
                                         @endif

                                       @endforeach
                                    @endforeach

                                @endforeach
                              @endif
                           </div>
                          
                          <div id="Enterprises" class="tabcontent">
                            @if(isset($networks['Enterprises']))
                                  @foreach($networks['Enterprises'] as $name => $sector)
                                    {{$name}} 
                                    @foreach($sector as $sectors)
                                       @foreach($sectors as $companysector)
                                         @if(isset($companysector))
                                           {{ $companysector->name }}
                                         @endif
                                       @endforeach
                                    @endforeach   
                                @endforeach
                              @endif
                          </div>

                          
                                                                                    
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                   <!--START - next pagers-->
                   <div class="controls-below-table controls-pagination-cnt row">
                        
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="table-records-info">
                        <?php echo $companies->render(); ?>
                        Showing records 1 - 5 {{ $companies->render() }}
                      </div>
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="table-records-pages align-rit">
                      <ul>
                        <li>
                          <a href="#">Previous</a>
                        </li>
                        <li>
                          <a class="current" href="#">1</a>
                        </li>
                        <li>
                          <a href="#">2</a>
                        </li>
                        <li>
                          <a href="#">3</a>
                        </li>
                        <li>
                          <a href="#">4</a>
                        </li>
                        <li>
                          <a href="#">Next</a>
                        </li>
                      </ul>
                    </div>
                    </div>
                  
                  </div>
                  <!--END - next pagers-->
                  <!--END - Network table -->
                </div>
              </div>
            </div>
            <!--------------------
              END - Network
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
          <!--------------------
            START - Sidebar
            -------------------->
          <div class="content-panel my-portfolio-rit">
            <div class="content-panel-close">
              <i class="os-icon os-icon-close"></i>
            </div>
            <div class="element-wrapper">
              <h6 class="element-header">
                Search
              </h6>
              <form action="{{ route('network.search') }}" method="POST" >
              {{ csrf_field() }}
              <div class="element-box-tp">
                <div class="element-box">
                  <div class="form-group">
                    <label for="">Country</label>
                    <select class="form-control select2" name="country[]" multiple="true">
                      @foreach($countries as $country)
                      <option value="{{ $country->countryid }}" >
                        {{ $country->name }}
                      </option>
                      @endforeach
                    </select>
                  </div> 
                  <div class="form-group">
                    <label for="">Sector</label>
                    <select class="form-control select2" name="sector[]" multiple="true">
                      @foreach($company_sectors as $sector)
                      <option value="{{ $sector->sectorid }}" >
                        {{ $sector->name }}
                      </option>
                      @endforeach
                    </select>
                  </div> 
                  <div class="form-group">
                    <label for="">Status</label>
                    <input class="form-control form-control-sm" type="text">
                  </div>      
                  <input type="submit" class="btn btn-primary " name="network_search" value="Submit">
                  <!-- <a class="btn btn-primary step-trigger-btn" href="#stepContent2">Submit</a> -->
                </div>
              </div>
            </div>
            </form>
            
          </div>
          <!--------------------
            END - Sidebar
            -------------------->
        </div>
      </div>
    </div>
    <div class="display-type"></div>
  </div>
  @include('shared._html_footer'))
</body>
<script>
function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablink;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
</html>