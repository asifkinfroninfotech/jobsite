@php
$helper=\App\Helpers\AppHelper::instance();

@endphp
@section('content')
@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
      <div class="content-w portfolio-custom-vk">
        <!--------------------
          START - Secondary Top Menu
          -------------------->
        @include('shared._top_menu')
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
              <div id='companytab'>
                  @if((session('helpview')!=null))
                <div class="element-wrapper" id='helpform'>
                            <div class="element-box">
                                            <h5 class="form-header">
                                                   {!!trans('network.help_title')!!}   
                                                </h5>
                                                <div class="form-desc">
                                                   
                                                   @if(session('usertype')=="Investors") 
                                                   {!!$helper->GetHelpModifiedText(trans('network.help_content'))!!} 
                                                   @endif
                                                   @if(session('usertype')=="Enterprises") 
                                                   {!!$helper->GetHelpModifiedText(trans('network.enterprise_help_content'))!!} 
                                                   @endif
                                                   @if(session('usertype')=="ESOs") 
                                                   {!!$helper->GetHelpModifiedText(trans('network.eso_help_content'))!!} 
                                                   @endif
                                                    @if(session('usertype')=="Service Providers") 
                                                   {!!$helper->GetHelpModifiedText(trans('network.sp_help_content'))!!} 
                                                   @endif
                                                </div>
                                                <div class="element-box-content example-content">
                                                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('network.help_btn_hide_caption')}}</button>
                                                </div>
                            </div>
                        </div>
              @endif
              </div>
              
                            <div id='usertab' style='display:none'>
                  @if((session('helpview')!=null))
                <div class="element-wrapper" id='helpform'>
                            <div class="element-box">
                                            <h5 class="form-header">
                                                   {!!trans('network.user_help_title')!!}   
                                                </h5>
                                                <div class="form-desc">
                                                  @if(session('usertype')=="Investors")   
                                                  {!!$helper->GetHelpModifiedText(trans('network.user_help_content'))!!} 
                                                  @endif
                                                  @if(session('usertype')=="Enterprises")   
                                                  {!!$helper->GetHelpModifiedText(trans('network.enterprise_user_help_content'))!!} 
                                                  @endif
                                                  @if(session('usertype')=="ESOs")   
                                                  {!!$helper->GetHelpModifiedText(trans('network.eso_user_help_content'))!!} 
                                                  @endif
                                                  @if(session('usertype')=="Service Providers")   
                                                  {!!$helper->GetHelpModifiedText(trans('network.sp_user_help_content'))!!} 
                                                  @endif
                                                </div>
                                                <div class="element-box-content example-content">
                                                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('network.user_help_btn_hide_caption')}}</button>
                                                </div>
                            </div>
                        </div>
              @endif
              </div>
              
              
            <div class="os-tabs-w">
              <div class="os-tabs-controls tab" >
                <ul class="nav nav-tabs upper">
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link active" data-toggle="tab" href="#" id="aba5f1" onclick="fnGetNetworks('aba5f1');"> Investors </a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#" id="5eab3b" onclick="fnGetNetworks('5eab3b');"> Enterprises </a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#" id="b5aa1d" onclick="fnGetNetworks('b5aa1d');"> Service Providers</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#" id="6c2b42" onclick="fnGetNetworks('6c2b42');" >  Eso's</a>
                  </li>
                  <li class="nav-item">
                    <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#" id="contact" onclick="fnGetNetworks('contact');" >  Contacts</a>
                  </li>
                  {{-- <li class="nav-item">
                    <a aria-expanded="false" class="nav-link " data-toggle="tab" href="#other-contacts" onclick="othercontact();"> Other Contacts</a>
                  </li> --}}
                 
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
                  <h6 class="element-header" id='title'>
                   {{trans('network.network_title')}}
                    
                    <ul class="nav nav-pills smaller d-none d-md-flex ns_type" style="float:right;">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id='company' data-toggle="tab" href="#" onclick="selectusercompany('company');"> {{trans('network.network_company_tab')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id='users' data-toggle="tab" href="#" onclick="selectusercompany('users');">{{trans('network.network_users_tab')}}</a>
                                                    </li>
                                                    
                                                </ul>
                    
                  </h6>
                  <div class="controls-above-table filter-row-top">
                    <div class="row">
                      <div class="col-sm-12">
                        <form class="form-inline justify-content-sm-end">
                          <input class="form-control form-control-sm rounded bright" placeholder="Search" id="search" type="text" >
                          <select class="form-control form-control-sm rounded bright" id="sort" onchange="sortme1(this.value);">
                            <option selected="selected" value="">
                            {{trans('network.network_sort_by')}}
                            </option>
                            <option value="name">
                            {{trans('network.network_sort_company_name')}}
                            </option>
                            <option value="sector">
                            {{trans('network.network_sort_sector')}}
                            </option>
                          </select>
                        </form>
                      </div>
                    </div>
                  </div>
                  
                    <div id="networktable">
                    
                        
                    </div>
                    <input type='hidden' id='categoryid' value=""/>
               
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
               {{trans('network.search_title')}}
              </h6>
              <form action="{{ route('network.search') }}" method="POST" >
              {{ csrf_field() }}
              <div class="element-box-tp">
                <div class="element-box">
                  <div class="form-group">
                    <label for="">{{trans('network.country_search_label')}}</label>
                    <select class="form-control select2" name="country[]" multiple="true" id="country">
                      @foreach($countries as $country)
                      <option value="{{ $country->countryid }}" >
                        {{ $country->name }}
                      </option>
                      @endforeach
                    </select>
                  </div> 
                  <div class="form-group">
                    <label for="">{{trans('network.sector_search_label')}}</label>
                    <select class="form-control select2" name="sector[]" multiple="true" id="sector">
                      @foreach($company_sectors as $sector)
                      <option value="{{ $sector->sectorid }}" >
                        {{ $sector->name }}
                      </option>
                      @endforeach
                    </select>
                  </div> 
                  <div class="form-group">
                    <label for="">{{trans('network.status_search_label')}}</label>
                    <input class="form-control form-control-sm" type="text">
                  </div>      
<!--                  {{-- <input type="submit" class="btn btn-primary " name="network_search" value="Submit"> --}}-->
                  <a class="btn btn-primary step-trigger-btn" href="#" onclick="fnSearchClick();">{{trans('network.submit_btn_text')}}</a>
                  <!-- <a class="btn btn-primary step-trigger-btn" href="#stepContent2">Submit</a> -->
                </div>
              </div>
            </div>
            </form>
            </div>
            
          </div>
          <!--
            END - Sidebar
            -->
        </div>
        <input type="hidden" id="tabselectedtype" value="company"/>
      </div>
      
  <script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
  var $rows = $('#table tr');
$('#search').keyup(function() {
    
    var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
        reg = RegExp(val, 'i'),
        text;
    
    $rows.show().filter(function() {
        text = $(this).text().replace(/\s+/g, ' ');
        return !reg.test(text);
    }).hide();
});
</script>
<script>

//Common function to get network data....
var usercompany="company";






//function selectusercompany(usercomp)
//{
//    if(usercomp == 'users')
//    {
//        $('#userslist').show();
//        $('#companylist').hide();
//         
//    }
//    if(usercomp == 'company')
//    {
//        $('#userslist').hide();
//        $('#companylist').show();
//        usercompany="users";
//         
//    }
//    common(companytypeid,sortme,search,selected,sector,1,usercomp);
//}






function fnGetNetworks(companytypeid)
{
   
  debugger; 
  if(companytypeid=="contact") 
  {
    var id= $('.ns_type>.nav-item>.nav-link.active').attr('id');
     $('#tabselectedtype').val(id);

     $('#categoryid').val(companytypeid);
     $('#company').css('visibility','hidden'); 
     $('#user').css('visibility','hidden'); 
     usercompany="users";
 
  }
  else
  {
    
     $('#categoryid').val(companytypeid); 
     $('#company').css('visibility','visible'); 
     $('#user').css('visibility','visible');

     //usercompany=$('#ul_companyuser.nav-link.active').attr('id');
     usercompany=$('#tabselectedtype').val();
     if(typeof usercompany=='undefined')
     {
      usercompany="Company";
     }
    
   }
   
  common(companytypeid,sortme,search,selected,sector,1,usercompany);
}

//functionality to select controls
var companycategory="";
function fnSearchClick(page)
{
  debugger;
  if(page==null || page=="")
      {
          page=1;
      }
    companycategory= $('.nav-link.active').attr('id')
    
   
    
    
    // companycategory="aba5f1";
    
     var countries=$('#country').val();    

if (countries.indexOf(',') > 0)
{
selected=countries.split(',');
  
}
else
{
 selected[0]=countries;
     
}

var countries=$('#sector').val();    

if (countries.indexOf(',') > 0)
{
sector=countries.split(',');
  
}
else
{
 sector[0]=countries;
   
}    
    
    common(companycategory,sortme,search,selected,sector,page,usercompany);    
        
        
//   common(companycategory,sortme,search,selected,sector,page);
   
}

var sortme="";
function sortme1(value)
 {
        if(value != null)
        {
          sortme = value;
        
          common($('.nav-link.active').attr('id'),sortme,search,selected,sector,1,usercompany);
      }
 }
var search="";
$('#search').keyup(function()
{
    count=0;
        setTimeout(function(){
       if(count==0)
       {
   search=$('#search').val();
      common($('.nav-link.active').attr('id'),sortme,search,selected,sector,1,usercompany);
    count++;
       }
}, 2000);
    
   
});

var selected=[];
function getcountry()
{
var countries=$('#country').val();    

if (countries.indexOf(',') > 0)
{
selected=countries.split(',');
  common($('.nav-link.active').attr('id'),sortme,search,selected,sector,1,usercompany);
}
else
{
 selected[0]=countries;
     common($('.nav-link.active').attr('id'),sortme,search,selected,sector,1,usercompany);
}
 
}
var sector=[];
function getsector()
{
var countries=$('#sector').val();    

if (countries.indexOf(',') > 0)
{
sector=countries.split(',');
  common($('.nav-link.active').attr('id'),sortme,search,selected,sector,1,usercompany); 
}
else
{
 sector[0]=countries;
   common($('.nav-link.active').attr('id'),sortme,search,selected,sector,1,usercompany);
}
 
}


function selectusercompany(usercomp)
{
  $('#tabselectedtype').val(usercomp);
 if(usercomp=="users")
 {
     $('#companytab').css('display','none');
     $('#usertab').css('display','block');
     usercompany="users";
     
     var companytypeid1="aba5f1";
     debugger;
     companytypeid=$('#categoryid').val();
     if(companytypeid.length==0)
     {
         companytypeid=companytypeid1;
     }
     
     
     common(companytypeid,sortme,search,selected,sector,1,usercompany);
 }
 if(usercomp=="company")
 {
      $('#companytab').css('display','block');
     $('#usertab').css('display','none');
     usercompany="company";
     var companytypeid1="aba5f1";
     debugger;
     companytypeid=$('#categoryid').val();
     if(companytypeid.length==0)
     {
         companytypeid=companytypeid1;
     }
     common(companytypeid,sortme,search,selected,sector,1,usercompany);
 }
    
}

function common(companycategory,sortme,search,selected,sector,pageno,usercompany)
{
    
    //alert(companycategory+sortme+search+selected+sector);
    
    
    
    
    url="/getfilterdata?companycategory="+companycategory+"&sortme="+sortme+"&search="+search+"&selected="+selected+"&sector="+sector+"&page="+pageno+"&usercompany="+usercompany;
    $.get(url,function(data){
  //    alert(data);
      $('#networktable').html('');
      $('#networktable').html(data);

      var cntrows=$('.network-rows tr').length-1;
      $('#numberofbox').text(cntrows);
      $('a').tooltip();
    })
    
    
}

//

$( document ).ready(function() {
    
//       url="/getfilterdata?sector=aba5f1";
//       getdata(url);
    
    // searchinvestor();
    fnSearchClick(1);
    
});

// function getdata(url)
// {
//     $.get(url,function(data){
//       //alert(data);
//       $('#networktable').html('');
//       $('#networktable').html(data);
//     })
// }


$(document).on('click','.pagination a',function(e){
    debugger;
e.preventDefault();
var page=$(this).attr('href').split('page=')[1];
fnSearchClick(page);
});


function friendsender(sender,friend)
{
    debugger;
    $.get('/senderfriend?sender='+sender+'&friend='+friend,function(data){
        $('#friend'+data).text('Request Sent');
    })
   
}


</script>


    @endsection