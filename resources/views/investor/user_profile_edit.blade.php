@php
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
@endphp

@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')
<div class="content-w profile-custom-vk">
    @include('shared._top_menu')
    <div class="content-panel-toggler">
        <i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span>
    </div>
    <div class="content-i">

        <div class="content-box">
            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('user_profile_edit.help_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!trans('user_profile_edit.help_content')!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('user_profile_edit.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">

                <div class="col-sm-5">


                    <div class="user-profile compact">
                        @php
                        if(isset($data['user_info']->coverimage) && !empty($data['user_info']->coverimage) &&
                        File::exists(public_path('storage/user/coverimage/'.$data['user_info']->coverimage)))
                        {
                        $coverimage = asset('/storage/user/coverimage/'.$data['user_info']->coverimage);
                        }
                        else
                        {
                        $coverimage = asset('/storage/user/default/user_profile_default.jpg');
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
                                @if(isset($data['user_info']->profileimage) &&
                                !empty($data['user_info']->profileimage) &&
                                File::exists(public_path('storage/user/profileimage/'.$data['user_info']->profileimage)))
                                <div class="user-avatar" style="width: 60px;height: 60px;border-radius: 40px;border: 3px solid #fff;overflow: hidden;">
                                    <img alt="" src="/storage/user/profileimage/{{$data['user_info']->profileimage}}">
                                </div>
                                @else
                                <div class="user-avatar" style="width: 60px;height: 60px;border-radius: 40px;border: 3px solid #fff;overflow: hidden;">
                                    <img alt="" src="{{ Avatar::create($data['user_info']->firstname.' '.$data['user_info']->lastname)->toBase64()}}">
                                </div>
                                @endif
                                <h2 class="up-header">
                                    {{-- John Bloggs --}}
                                    {{$data['user_info']->firstname.' '.$data['user_info']->lastname}}
                                </h2>
                                <h6 class="up-sub-header">
                                    {{-- Director --}}
                                    {{$data['user_info']->userposition}}
                                </h6>
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
                                <div class="col-sm-6">
                                    <div class="value-pair">
                                        <div class="label">
                                            {{trans('user_profile_edit.label_status')}}
                                        </div>
                                        <div class="value badge badge-pill badge-success">
                                            {{trans('user_profile_edit.label_online')}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="up-controls up-controls-light">
                            <div class="my-profile-foldr clearfix">
                                <div class="label">
                                    {{-- Lorem ipsum dolor sit amet, consectetur --}}
                                    {{ $data['user_info']->statusmessage}}
                                </div>
                                <div class="project-users">
                                    <a href="javascript:void(0);" data-target=".bd-example-modal-sm" data-toggle="modal">
                                        <i class="os-icon os-icon-edit-1"></i>
                                        <span></span>
                                    </a>
                                    <div aria-hidden="true" aria-labelledby="mySmallModalLabel" id="popup-status-message"
                                        class="modal fade bd-example-modal-sm" role="dialog" tabindex="-1">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        {{trans('user_profile_edit.label_edit_status')}}
                                                    </h5>
                                                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                                            aria-hidden="true"> &times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label for=""> {{trans('user_profile_edit.label_status')}}</label><input
                                                                class="form-control" placeholder="{{trans('user_profile_edit.placeholder_status')}}"
                                                                type="name" id="txtStatusMessage">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="button" onclick="fnSaveUserStatus('{{$data['user_info']->userid}}');">{{trans('user_profile_edit.button_save')}}</button>
                                                </div>
                                                <div class="alert alert-danger" role="alert" id="status-message-box"
                                                    style="display:none;">
                                                    {{trans('user_profile_edit.status_message_update_leftblank')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="up-contents">
                            <div class="m-b">
                                <div class="row m-b">
                                    <div class="col-sm-6 b-r b-b">
                                        <div class="el-tablo centered padded-v">
                                            <div class="value">
                                                {{$data['user_info']->totalviews}}
                                            </div>
                                            <div class="label">
                                                {{trans('user_profile_edit.label_views')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 b-b">
                                        <div class="el-tablo centered padded-v">
                                            <div class="value">
                                                {{$friend_count->fcount}}

                                            </div>
                                            <div class="label">
                                                {{trans('user_profile_edit.label_connections')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="element-wrapper">
                        <!--------------------
                         start - Profile Image
                         -------------------->
                        <div class="element-box">
                            <h5 class="form-header">
                                {{trans('user_profile_edit.label_profile_image')}}
                            </h5>
                            <div class="form-desc">
                                {{trans('user_profile_edit.dropbox_profile_caption')}}
                            </div>
                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
                                class="dropzone" id="profile_image">
                                {{csrf_field()}}
                                <input type="hidden" name="profile_image" value="profile_image">
                                <div class="dz-message">
                                    <div>
                                        <h4>{{trans('user_profile_edit.dropbox_profiledragdrop_content')}}</h4>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="element-box">
                            <h5 class="form-header">
                                {{trans('user_profile_edit.label_cover_image')}}
                            </h5>
                            <div class="form-desc">
                                {{trans('user_profile_edit.dropbox_cover_caption')}}
                            </div>
                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
                                class="dropzone" id="cover_image">
                                {{csrf_field()}}
                                <input type="hidden" name="cover_image" value="cover_image">
                                <div class="dz-message">
                                    <div>
                                        <h4>{{trans('user_profile_edit.dropbox_coverdragdrop_content')}}</h4>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!--------------------
                        END - Profile Image
                        -------------------->
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="element-wrapper">
                        <div class="element-box">
                            <form id="formValidate" onsubmit="return checkpassword();" method="POST" action="{{ route('user.profile.update') }}"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="element-info">
                                    <div class="element-info-with-icon">
                                        <div class="element-info-icon">
                                            <div class="os-icon os-icon-wallet-loaded"></div>
                                        </div>
                                        <div class="element-info-text">
                                            <h5 class="element-inner-header">
                                                {{trans('user_profile_edit.label_profile_settings')}}
                                            </h5>
                                            <div class="element-inner-desc">
                                                {{trans('user_profile_edit.caption_profile_settings')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">{{trans('user_profile_edit.label_email')}}*</label>
                                    <input class="form-control" data-error="Email address is required." placeholder="{{trans('user_profile_edit.email_placeholder')}}"
                                        required="required" type="email" name="email" value="{{ old('',$data['user_info']->email)}}">
                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">{{trans('user_profile_edit.label_password')}}*</label>
                                            <input class="form-control" data-error="Password is required."
                                                data-minlength="6" placeholder="{{trans('user_profile_edit.password_placeholder')}}"
                                                required="required" type="password" name="password" id='password' value="{{ $data['user_info']->userpassword}}">
                                            {{trans('user_profile_edit.password_minimum')}}
                                            <div class="help-block form-text text-muted form-control-feedback">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">{{trans('user_profile_edit.label_confirm_password')}}*</label>
                                            <input class="form-control" data-error="Confirm Password is required."
                                                data-match-error="Passwords did not matched." placeholder="{{trans('user_profile_edit.placeholder_confirm_password')}}"
                                                required="required" type="password" name="cpassword" id='cpassword'
                                                value="{{ $data['user_info']->userpassword}}">
                                            <div id="helppass" class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <fieldset class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">{{trans('user_profile_edit.label_first_name')}}*</label>
                                                <input class="form-control" data-error="First Name is required."
                                                    placeholder="{{trans('user_profile_edit.placeholder_first_name')}}"
                                                    required="required" type="text" name="first_name" value="{{ old('',$data['user_info']->firstname)}}">
                                                <div class="help-block form-text with-errors form-control-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">{{trans('user_profile_edit.label_last_name')}}*</label>
                                                <input class="form-control" data-error="Please input your Last Name"
                                                    placeholder="{{trans('user_profile_edit.placeholder_last_name')}}"
                                                    required="required" type="text" name="last_name" value="{{ old('',$data['user_info']->lastname)}}">
                                                <div class="help-block form-text with-errors form-control-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{trans('user_profile_edit.label_position')}}</label>
                                        <input class="form-control" type="text" placeholder="{{trans('user_profile_edit.label_position_placeholder')}}"
                                            name="position" value="{{ old('',$data['user_info']->userposition)}}">
                                        {{-- <div class="help-block form-text with-errors form-control-feedback"></div>
                                        --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">{{trans('user_profile_edit.label_telephone')}}</label>
                                                <input class="form-control" placeholder="{{trans('user_profile_edit.telephone_placeholder')}}"
                                                    type="text" name="telephone" value="{{ old('',$data['user_info']->telephone)}}">
                                                {{-- <div class="help-block form-text with-errors form-control-feedback"></div>
                                                --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">{{trans('user_profile_edit.label_mobile')}}</label>
                                                <input class="form-control" placeholder="{{trans('user_profile_edit.placeholder_mobile')}}"
                                                    type="text" name="mobile" value="{{ old('',$data['user_info']->mobile)}}">
                                                {{-- <div class="help-block form-text with-errors form-control-feedback"></div>
                                                --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">{{trans('user_profile_edit.label_skype')}}</label>
                                                <input class="form-control" placeholder="{{trans('user_profile_edit.placeholder_skype')}}"
                                                    type="text" name="skype" value="{{ $data['user_info']->skype }}">
                                                {{-- <div class="help-block form-text with-errors form-control-feedback"></div>
                                                --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">{{trans('user_profile_edit.label_twitter_username')}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            @
                                                        </div>
                                                    </div>
                                                    <input class="form-control" placeholder="{{trans('user_profile_edit.placeholder_twitter')}}"
                                                        type="text" name="twitter" value="{{ old('',$data['user_info']->twitter)}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{trans('user_profile_edit.label_personal_background')}}</label><textarea
                                            class="form-control" name="personalbackground" rows="3">{{ old('',$data['user_info']->personalbackground) }}</textarea>
                                    </div>
                                </fieldset>
                                <div class="form-buttons-w">
                                    <input type="submit" class="btn btn-primary" name="user_info" id="submit" value="{{trans('user_profile_edit.btn_submit_label')}}">
                                </div>
                            </form>
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
                <span>Dark </span><span>Colors</span>
            </div>
            <!--------------------
            END - Color Scheme Toggler
            -------------------->
            <!--------------------
            START - Chat Popup Box
            -------------------->
            <div class="floated-chat-btn">
                <i class="os-icon os-icon-mail-07"></i><span>Demo Chat</span>
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
                                    <img alt="" src="/img/avatar1.jpg">
                                </div>
                            </div>
                            <div class="user-name">
                                <h6 class="user-title">
                                    {{-- John Bloggs --}}
                                    {{$data['user_info']->firstname.' '.$data['user_info']->lastname}}
                                </h6>
                                <div class="user-role">
                                    {{-- Director --}}
                                    {{$data['user_info']->userposition}}
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
                            <a href="#"><span class="extra-tooltip">Attach Document</span><i class="os-icon os-icon-documents-07"></i></a><a
                                href="#"><span class="extra-tooltip">Insert Photo</span><i class="os-icon os-icon-others-29"></i></a><a
                                href="#"><span class="extra-tooltip">Upload Video</span><i class="os-icon os-icon-ui-51"></i></a>
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

            {{-- @include('shared._right_friends_request') --}}



            <div class="element-wrapper">
                <h6 class="element-header">
                    {{trans('user_profile_edit.label_team_members')}}
                </h6>
                <div class="element-box-tp">
                    <div class="input-search-w">
                        <input class="form-control rounded bright" id="myInput" placeholder="{{trans('user_profile_edit.search_placeholder')}}"
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
                              <a href=""><div class="os-icon os-icon-email-forward"></div></a>
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
                              <a href=""> <div class="os-icon os-icon-link-3">&nbsp;</div></a>
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
                              <a href=""><div class="os-icon os-icon-email-forward"></div></a>
                          </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!--------------------
        END - Sidebar
        -------------------->
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    //          function myFunction() {
    //          var input, filter, members, span, a, i;
    //          input = document.getElementById("myInput");
    //          filter = input.value.toUpperCase();
    //          members = document.getElementById("members");
    //          span = members.getElementsByTagName("span");
    //          for (i = 0; i < span.length; i++) {
    //              a = span[i].getElementsByTagName("a")[0];
    //              if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
    //                  span[i].style.display = "";
    //              } else {
    //                  span[i].style.display = "none";
    //
    //              }
    //          }
    //      }

    function fnSaveUserStatus(userid) {
        var statusmessage = $('#txtStatusMessage').val();
        if ($.trim(statusmessage) == '') {
            var $messageDiv = $('#status-message-box');
            $messageDiv.show();
            setTimeout(function () {
                $messageDiv.hide();
            }, 3000);
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formdata = new FormData();

        formdata.append("statusmessage", statusmessage);
        formdata.append("_token", '{{csrf_token()}}');

        $.ajax({
            url: '/update-user-status',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {

                $('#popup-status-message').modal('hide');
                window.location.reload(true);


            },
            error: function (err, result) {
                debugger;
                alert("Error" + err.responseText);
            }
        });





    }

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



    function checkpassword() {
        debugger;
        if ($('#password').val() != $('#cpassword').val()) {

            $("#submit").addClass("disabled");
            $('#helppass').html("Password do not match");
            $(window).scrollTop(0);
            return false;

        } else {
            return true;
        }

    }


    //asifcode
    function friendsender(sender, friend) {
        debugger;
        $.get('/senderfriend?sender=' + sender + '&friend=' + friend, function (data) {
            location.reload();
        })

    }
</script>

// @include('shared._dashboard_friend_request')

@endsection