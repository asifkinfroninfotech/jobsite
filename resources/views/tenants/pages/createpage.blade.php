@php
$helper=\App\Helpers\AppHelper::instance();


@endphp

@extends('tenants.layouts.app_layout', ['layout' => 'left_side_menu_tenant'])





@section('content')

<div class="content-w investor-profil">
    @include('tenants.shared._top_menu_tenant')
    <div class="content-i">
        <div class="content-box">
            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('tenant_page.help_create_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!$helper->GetHelpModifiedText(trans('tenant_page.help_create_content'))!!}
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
                        //$cover_image = asset('/storage/tenant/coverimage/'.$tenant->cover);
                        if(isset($getpage->banner) && !empty($getpage->banner)){
                        $cover_image = asset('/storage/tenant/banner/'.$getpage->banner);
                        }
                        else
                        {
                        $cover_image = asset('/storage/tenant/banner/');
                        }

                        @endphp
                        <div class="up-head-w" style="background-image:url({{ $cover_image }})">

                            <div class="up-main-info">
                                <!-- <h2 class="up-header">
                                   
                                   
                                </h2> -->
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
                                {{trans('tenant_page.banner_image_label')}}
                            </h5>
                            <div class="form-desc">
                                {{trans('tenant_page.banner_content')}}
                            </div>
                            <form action="{{ url('/save_page_banner_image') }}" method="POST" enctype="multipart/form-data"
                                class="dropzone" id="profile_image">
                                {{ csrf_field() }}
                                <input type="hidden" name="bannerpageid" id="bannerpageid" value="{{isset($getpage->pageid) && !empty($getpage->pageid)?$getpage->pageid:old('pageid')}} ">
                                <div class="dz-message">
                                    <div>
                                        <h4>{{trans('tenant_page.banner_drop_content')}}</h4>
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

                                {{isset($page) && !empty($page)?'Edit Page':'Create Page'}}
                            </h5>



                            <div class="step-contents">
                                <div class="element-box">
                                    <form id="formValidate1" method="POST" action="{{url('/create_update_page')}}">
                                        {{ csrf_field() }}


                                        <!--                          <div class="step-content active" id="stepContent1">-->
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">

                                                    <label for="">
                                                        {{trans('tenant_page.name_label')}}
                                                    </label>
                                                    <input class="form-control" placeholder="Enter Page Name"
                                                        data-error="Page Name must not be empty" required="required"
                                                        type="text" name="pagename" id="pagename" value="{{isset($getpage->name) && !empty($getpage->name)?$getpage->name:old('pagename')}} ">
                                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">

                                                    <label for="">
                                                        {{trans('tenant_page.title_label')}}
                                                    </label>
                                                    <input class="form-control" placeholder="Enter Title" data-error="Title must not be empty."
                                                        required="required" type="text" name="title" id="title" value="{{isset($getpage->title) && !empty($getpage->title)?$getpage->title:old('title')}} "
                                                        onblur="createslugfromtitle();">
                                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                                </div>
                                            </div>
                                        </div>






                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">
                                                        {{trans('tenant_page.mete_title_label')}}
                                                    </label>
                                                    <input class="form-control" placeholder="Enter Meta Title" required="required"
                                                        type="text" name="metatitle" value="{{isset($getpage->meta_title) && !empty($getpage->meta_title)?$getpage->meta_title:old('metatitle')}} ">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">
                                                        {{trans('tenant_page.meta_description_label')}}
                                                    </label>
                                                    <input class="form-control" placeholder="Meta Description" required="required"
                                                        type="text" name="metadescription" value="{{isset($getpage->meta_description) && !empty($getpage->meta_description)?$getpage->meta_description:old('metadescription')}}   ">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="">
                                                        {{trans('tenant_page.description_label')}}
                                                    </label>
                                                    <input class="form-control" placeholder="Enter Description" type="text"
                                                        name="description" value="{{isset($getpage->description) && !empty($getpage->description)?$getpage->description:old('description')}} ">

                                                </div>
                                            </div>




                                        </div>


                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="">
                                                        {{trans('tenant_page.slug')}}
                                                    </label>
                                                    <input class="form-control" type="text" name="slug" id="slug" value="{{isset($getpage->slug) && !empty($getpage->slug)?$getpage->slug:old('slug')}} ">

                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="">
                                                        {{trans('tenant_page.content_label')}}
                                                    </label>



                                                    <textarea class="form-control" rows="3" name="ckeditor1" id="ckeditorEmail">{{isset($getpage->content) && !empty($getpage->content)?$getpage->content:old('ckeditor1')}} </textarea>

                                                    <div class="help-block form-text with-errors form-control-feedback"></div>
                                                </div>
                                            </div>


                                        </div>







                                        <div class="form-buttons-w text-right">
                                            <input type="hidden" name="pageid" id="pageid" value="{{isset($getpage->pageid) && !empty($getpage->pageid)?$getpage->pageid:old('pageid')}} ">
                                            <input class="btn btn-primary" type="submit" name="user_info" value="Save">

                                        </div>
                                        <br /><br />
                                        @if (\Session::has('slugerror'))
                                        <div class="alert alert-danger">

                                            {!! \Session::get('slugerror') !!}

                                        </div>
                                        @endif
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

<script>
    function convertToSlug(Text) {
        return Text
            .toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
    }


    function createslugfromtitle() {
        debugger;
        var slug = $('#title').val();
        var slugcheck = convertToSlug(slug);
        $('#slug').val(slugcheck);

    }


    //removing any spaces from input during first load
    if ($.type($('#pageid').val()) === "undefined" || $('#pageid').val() == " ") {
        $('#pagename').val('');
        $('#title').val('');
    }
</script>
@endsection