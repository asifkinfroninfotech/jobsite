<?php 
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
$extends="";
$view="";
$layout="";
if(isset($calledfrom) && !empty($calledfrom))
{
    
    if($calledfrom=="admin")
    {
      $view='adminview.layouts.app_layout';
      $layout='left_side_menu';
       
    }
    else if($calledfrom=="tenant")
    {
       $view= 'tenants.layouts.app_layout';
       $layout='left_side_menu_tenant';
      
    }
}
else
{
    $view= 'layouts.app_layout';
     $layout='left_side_menu_compact'; 
}

?>

@extends($view, ['layout' => $layout])

@section('content')
<div class="content-w investor-profile-view">

    @if(isset($calledfrom) && !empty($calledfrom))
    @if($calledfrom=="admin")
    @include('adminview.shared._top_menu')

    @elseif($calledfrom=="tenant")
    @include('tenants.shared._top_menu_tenant')
    @endif
    @else
    @include('shared._top_menu')
    @endif

    <div class="content-panel-toggler">
        <i class="os-icon os-icon-grid-squares-22"></i>
        <span>Sidebar</span>
    </div>

    <div class="content-i">
        <div class="content-box">
            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('user_profile_view.help_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!trans('user_profile_view.help_content')!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('user_profile_view.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif

            <div class="element-wrapper">
                <div class="user-profile">
                    @php
                    if(isset($data['user_info']->coverimage) && !empty($data['user_info']->coverimage) &&
                    File::exists(public_path('storage/user/coverimage/'.$data['user_info']->coverimage)))
                    {
                    $coverimage = asset('storage/user/coverimage/'.$data['user_info']->coverimage);
                    }
                    else
                    {
                    $coverimage = asset('/storage/user/default/user_profile_default.jpg');
                    }

                    if(isset($data['user_info']->profileimage) && !empty($data['user_info']->profileimage) &&
                    File::exists(public_path('storage/user/profileimage/'.$data['user_info']->profileimage)))
                    {
                    $profileimage = asset('storage/user/profileimage/'.$data['user_info']->profileimage);
                    }
                    else
                    {
                    $profileimage = Avatar::create($data['user_info']->firstname.'
                    '.$data['user_info']->lastname)->toBase64();
                    }




                    @endphp
                    <div class="up-head-w" style="background-image:url({{ $coverimage }})">
                        <div class="up-social">
                            @if(isset($data['user_info']->twitter) && !empty($data['user_info']->twitter))
                            <a href="https://twitter.com/{{$data['user_info']->twitter}}" target="_blank">
                                <i class="icon-social-twitter"></i>
                            </a>
                            @endif
                            @if(isset($data['user_info']->skype) && !empty($data['user_info']->skype))
                            <a href="skype:{{$data['user_info']->skype}}?userinfo" target="_blank">
                                <i class="icon-social-skype"></i>
                            </a>
                            @endif
                        </div>
                        <div class="up-main-info">
                            <div class="user-avatar-w">
                                <div class="user-avatar">
                                    <img alt="" src="{{$profileimage}}">
                                </div>
                            </div>

                            <h1 class="up-header">
                                {{ $data['user_info']->firstname.' '.$data['user_info']->lastname }}
                            </h1>
                            <h5 class="up-sub-header">
                                {{$data['user_info']->userposition}}
                            </h5>
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
                            <div class="col-lg-6 col-md-6">
                                <div class="value-pair person-profile-lbel">
                                    <div class="label">
                                        {{ trans('user_profile_view.status') }}
                                    </div>
                                    <div class="value badge badge-pill badge-success">
                                        Online
                                    </div>
                                </div>
                                <div class="value-pair">
                                    <div class="label">
                                        {{ trans('user_profile_view.member_since') }}
                                    </div>
                                    <div class="value">
                                        {{-- 2018 --}}
                                        {{ date('Y',strtotime($data['user_info']->created_at)) }}
                                    </div>
                                </div>
                            </div>

                            @if(!isset($calledfrom) || empty($calledfrom))
                            @if(isset($_GET['user']))
                            <div class="col-lg-6 col-md-6 text-right">
                                <a class="btn btn-secondary btn-sm" href="/companymessaging?userid={{$_GET['user']}}">
                                    <i class="os-icon os-icon-email-forward"></i>

                                    <span>{{ trans('user_profile_view.send_message') }}</span>

                                </a>
                            </div>
                            @endif
                            @endif

                        </div>
                    </div>
                    <div class="up-controls up-controls-light">
                        <div class="my-profile-foldr clearfix">
                            <div class="label">
                                {{-- Lorem ipsum dolor sit amet, consectetur --}}
                                {{ $data['user_info']->statusmessage}}

                            </div>

                        </div>
                    </div>
                    <div class="up-contents">
                        <h5 class="element-header">
                            {{ trans('user_profile_view.caption') }}
                        </h5>
                        <div class="row invst-pfl">
                            <div class="col-sm-5">
                                <div class="label">{{ trans('user_profile_view.name') }}</div>
                                <h5>{{ $data['user_info']->firstname.' '.$data['user_info']->lastname }}</h5>
                            </div>
                            <div class="col-sm-7">
                                <div class="label">{{ trans('user_profile_view.email') }}</div>
                                <h5>{{ $data['user_info']->email }}</h5>
                            </div>
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['user_info']->telephone) && !empty($data['user_info']->telephone))
                            <div class="col-sm-5">
                                <div class="label">{{ trans('user_profile_view.telephone') }}</div>
                                <h5>{{ $data['user_info']->telephone }}</h5>
                            </div>
                            @endif
                            @if(isset($data['user_info']->mobile) && !empty($data['user_info']->mobile) )
                            <div class="col-sm-7">
                                <div class="label">{{ trans('user_profile_view.mobile') }}</div>
                                <h5>{{ $data['user_info']->mobile }}</h5>
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['user_info']->skype) && !empty($data['user_info']->skype) )
                            <div class="col-sm-5">
                                <div class="label">{{ trans('user_profile_view.skype') }}</div>
                                <h5>{{ $data['user_info']->skype }}</h5>
                            </div>
                            @endif
                            @if(isset($data['user_info']->twitter) && !empty($data['user_info']->twitter) )
                            <div class="col-sm-7">
                                <div class="label">{{ trans('user_profile_view.twitter') }}</div>
                                <h5>{{ $data['user_info']->twitter }}</h5>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if(isset($data['user_info']->personalbackground) && !empty($data['user_info']->personalbackground)
                    )
                    <div class="up-contents brdtop">
                        <div class="mission-row">
                            <h5 class="element-inner-header">
                                {{ trans('user_profile_view.personal_background') }}
                            </h5>
                            <div class="element-inner-desc">{{ $data['user_info']->personalbackground }}</div>
                        </div>
                    </div>
                    @endif

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
        @if(!isset($calledfrom) || empty($calledfrom))
        <div class="content-panel">
            <div class="content-panel-close">
                <i class="os-icon os-icon-close"></i>
            </div>
            <div class="element-wrapper">
                <h6 class="element-header">
                    {{trans('user_profile_view.team_member')}}
                </h6>
                <div class="element-box-tp">
                    <div class="input-search-w">
                        <input class="form-control rounded bright" id="myInput" placeholder="{{trans('user_profile_view.search_team_member')}}"
                            type="text">
                    </div>
                    <div class="users-list-w">
                        <div id="members">
                            @foreach($data['team_member'] as $members)
                            <span>
                                {{-- with-status status-green --}}

                                <div class="user-w  {{($members[0]->is_online == 1)?'with-status status-green':'with-status status-red'}}">

                                    <div class="user-avatar-w">
                                        <div class="user-avatar">
                                            <a href="/user/profile/view?user={{$members[0]->userid}}">
                                                @if($members[0]->profileimage==null)
                                                <img alt="" src="{{ Avatar::create(strtoupper($members[0]->firstname).' '.strtoupper($members[0]->lastname))->toBase64() }}">
                                                @else
                                                <img alt="" src="{{$UserProfileImagePath . $members[0]->profileimage}}">
                                                @endif
                                            </a>
                                            {{-- <img alt="" src="img/avatar1.jpg"> --}}
                                        </div>
                                    </div>
                                    <div class="user-name">
                                        <h6 class="user-title">
                                            <a> {{$members[0]->firstname.' '.$members[0]->lastname}} </a>
                                        </h6>
                                        <div class="user-role">
                                            {{-- Account Manager --}}
                                            {{$members[0]->userposition}}
                                        </div>
                                    </div>

                                    @php
                                    $helper=\App\Helpers\AppHelper::instance();

                                    if(isset($_GET['company']) && !empty($_GET['company']))
                                    {
                                    $connect=$helper->companymessagingandconnect($_GET['company'],$members[0]->userid,$data['friends']);
                                    }
                                    else
                                    {
                                    $connect=$helper->companymessagingandconnect('',$members[0]->userid,$data['friends']);
                                    }

                                    @endphp

                                    @if($connect == "connect")
                                    <div class="user-action">
                                        @php
                                        $userid=session('userid');
                                        @endphp
                                        <a href="#" onclick="friendsender('{{$userid}}','{{$members[0]->userid}}')">
                                            <div class="os-icon os-icon-link-3">&nbsp;</div>

                                        </a>
                                    </div>
                                    @elseif($connect == "messaging")
                                    <div class="user-action">
                                        <a href="/companymessaging?userid={{$members[0]->userid}}">
                                            <div class="os-icon os-icon-email-forward"></div>
                                        </a>
                                    </div>


                                    @elseif($connect == "approval")
                                    <div class="user-action">

                                    </div>
                                    @endif
                                </div>
                            </span>
                            @endforeach
                        </div>
                        <!-- <div class="user-w with-status status-green">
                    <div class="user-avatar-w">
                      <div class="user-avatar">
                        <img alt="" src="img/avatar2.jpg">
                      </div>
                    </div>
                    <div class="user-name">
                      <h6 class="user-title">
                        Ben Gossman
                      </h6>
                      <div class="user-role">
                        Administrator
                      </div>
                    </div>
                    <div class="user-action">
                      <a href="">
                        <div class="os-icon os-icon-email-forward"></div>
                      </a>
                    </div>
                  </div>
                  <div class="user-w with-status status-red">
                    <div class="user-avatar-w">
                      <div class="user-avatar">
                        <img alt="" src="img/avatar3.jpg">
                      </div>
                    </div>
                    <div class="user-name">
                      <h6 class="user-title">
                        Phil Nokorin
                      </h6>
                      <div class="user-role">
                        HR Manger
                      </div>
                    </div>
                    <div class="user-action">
                      <a href="">
                          <div class="os-icon os-icon-link-3">&nbsp;</div>
                      </a>
                    </div>
                  </div>
                  <div class="user-w with-status status-green">
                    <div class="user-avatar-w">
                      <div class="user-avatar">
                        <img alt="" src="img/avatar4.jpg">
                      </div>
                    </div>
                    <div class="user-name">
                      <h6 class="user-title">
                        Jenny Miksa
                      </h6>
                      <div class="user-role">
                        Lead Developer
                      </div>
                    </div>
                    <div class="user-action">
                      <a href="">
                        <div class="os-icon os-icon-email-forward"></div>
                      </a>
                    </div>
                  </div> -->
                    </div>
                </div>
            </div>

        </div>
        @endif
        <!--------------------
            END - Sidebar
            -------------------->
    </div>
</div>
<script>
    //    function myFunction() {
    //    var input, filter, members, span, a, i;
    //    input = document.getElementById("myInput");
    //    filter = input.value.toUpperCase();
    //    members = document.getElementById("members");
    //    span = members.getElementsByTagName("span");
    //    for (i = 0; i < span.length; i++) {
    //        a = span[i].getElementsByTagName("a")[0];
    //        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
    //            span[i].style.display = "";
    //        } else {
    //            span[i].style.display = "none";
    //
    //        }
    //    }
    //}

</script>
@section('scripts')

<script>
    //asifcode
    var search = "";
    var count = 0;
    $('#myInput').keyup(function () {
        search = $('#myInput').val();
        setTimeout(function () {
            if (count == 0) {
                getsearchfromdb(search);
            }
            count++;
        }, 2000);
        count = 0;
    });



    function getsearchfromdb(search) {

        debugger;
        var getcompany = <?php echo json_encode((isset($_GET['company']))?$_GET['company']:''); ?>;
        var getuser = <?php echo json_encode((isset($_GET['user']))?$_GET['user']:''); ?>;
        $.get('/teammembersearch?searchstring=' + search + '&company=' + getcompany + '&user=' + getuser, function (
            data) {
            $('#members').html(data);
        });
    }


    //asifcode

    function friendsender(sender, friend) {
        debugger;
        $.get('/senderfriend?sender=' + sender + '&friend=' + friend, function (data) {
            location.reload();
        })

    }

</script>





@endsection
@endsection
