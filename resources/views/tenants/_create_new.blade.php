@if($data=="block_header")
<form id="formValidate" onsubmit="return testblock();" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_title_input')}}
        </label>
        <textarea class="form-control" data-error="Please input your title" placeholder="{{trans('tenant_new.popup_title_input')}}"
          required="required" data-minlength="12" type="text" name="title" rows="4" cols="50"></textarea>
        <div class="help-block form-text with-errors form-control-feedback"></div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_description_input')}}
        </label>
        <div class="input-group">

          <textarea class="form-control" placeholder="{{trans('tenant_new.popup_description_input')}}" type="text" name="description"
            value="" rows="4" cols="50"></textarea>
        </div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_link_input')}}
        </label>
        <div class="input-group">

          <input class="form-control" placeholder="{{trans('tenant_new.popup_link_input')}}" type="text" name="link"
            value="">
        </div>
      </div>
    </div>




    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_uploadimage_input')}}
        </label>
        <div class="dropzone ng-pristine ng-valid dz-clickable" id="popup_profile_image" onclick="imageuploading();">
          <div class="dz-message">
            <div class="row">
              <div class="col-sm-6">
                <div>
                  <h4>Drop files here or click to upload.</h4>
                </div>
              </div>
              <div class="col-sm-6">
                <div><img src="" id="preview" style="width:32%;"></div>
              </div>
            </div>
          </div>
        </div>
        <input type="file" name="fileToUpload" id="fileToUpload" onchange="readURL(this);" style="display:none;" />
        <div class="help-block form-text with-errors form-control-feedback"></div>
      </div>
    </div>


    <input type="hidden" id="formtype" value="blockform">




  </div>
</form>
@endif

@if($data=="faq")
<form id="formValidate">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_question_input')}}
        </label>
        <textarea class="form-control" data-error="Please input your question" placeholder="{{trans('tenant_new.popup_question_input')}}"
          required="required" data-minlength="12" type="text" name="question" rows="4" cols="50"></textarea>
        <div class="help-block form-text with-errors form-control-feedback"></div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_answer_input')}}
        </label>
        <div class="input-group">

          <textarea class="form-control" placeholder="{{trans('tenant_new.popup_answer_input')}}" type="text" name="answer"
            value="" rows="4" cols="50"></textarea>
        </div>
      </div>
    </div>
    <input type="hidden" id="formtype" value="faqform">





  </div>
</form>
@endif

@if($data=="slide")
<form id="formValidate" method="post" enctype="multipart/form-data" action="/saveslide">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_title_input')}}
        </label><span>*</span>
        <textarea class="form-control" data-error="Please input your question" placeholder="{{trans('tenant_new.popup_title_input')}}"
          required="required" data-minlength="12" type="text" name="title" rows="4" cols="50"></textarea>
        <div class="help-block form-text with-errors form-control-feedback"></div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_description_input')}}
        </label>
        <div class="input-group">

          <textarea class="form-control" placeholder="{{trans('tenant_new.popup_description_input')}}" type="text" name="description"
            value="" rows="4" cols="50"></textarea>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_buttontext_input')}}
        </label>
        <input class="form-control" data-error="Please input your question" placeholder="{{trans('tenant_new.popup_buttontext_input')}}"
          type="text" name="buttontext">
        <div class="help-block form-text with-errors form-control-feedback"></div>
      </div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_buttonlink_input')}}
        </label>
        <input class="form-control" data-error="Please input your question" placeholder="{{trans('tenant_new.popup_buttonlink_input')}}"
          type="text" name="buttonlink">
        <div class="help-block form-text with-errors form-control-feedback"></div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_uploadimage_input')}}
        </label><span>*</span>
        <div class="dropzone ng-pristine ng-valid dz-clickable" id="popup_profile_image" onclick="imageuploading();">
          <div class="dz-message">
            <div class="row">
              <div class="col-sm-6">
                <div>
                  <h4>Drop files here or click to upload.</h4>
                </div>
              </div>
              <div class="col-sm-6">
                <div><img src="" id="preview" style="width:32%;"></div>
                <div class="help-block form-text with-errors form-control-feedback" id="filesize-error"></div>
              </div>
            </div>
          </div>
        </div>
        <input type="file" name="fileToUpload" id="fileToUpload" required="required" onchange="readURL(this);" style="display:none;" />

      </div>
    </div>


  </div>

  <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close" style="float: right;
    margin-top: 23px;">Cancel</button>
  <input class="btn btn-primary" type="submit" value="Save" style="float: right;
    margin-right: 10px;
    margin-top: 23px;">

</form>

@endif

@if($data=="testimonial")
<form id="formValidate" method="post" enctype="multipart/form-data" action="/testimonial">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_name_input')}}
        </label>
        <input class="form-control" data-error="Please input your question" placeholder="{{trans('tenant_new.popup_name_input')}}"
          required="required" data-minlength="12" type="text" name="name"></textarea>
        <div class="help-block form-text with-errors form-control-feedback"></div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_description_input')}}
        </label>
        <div class="input-group">

          <textarea class="form-control" placeholder="{{trans('tenant_new.popup_description_input')}}" type="text" name="description"
            value="" rows="4" cols="50"></textarea>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_companyrank_input')}}
        </label>
        <input class="form-control" data-error="Please input your question" placeholder="{{trans('tenant_new.popup_companyrank_input')}}"
          required="required" data-minlength="12" type="text" name="companyrank">
        <div class="help-block form-text with-errors form-control-feedback"></div>
      </div>
    </div>


  </div>

  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        <label for="">
          {{trans('tenant_new.popup_uploadimage_input')}}
        </label>
        <div class="dropzone ng-pristine ng-valid dz-clickable" id="popup_profile_image" onclick="imageuploadingtest();">
          <div class="dz-message">
            <div class="row">
              <div class="col-sm-6">
                <div>
                  <h4>Drop files here or click to upload.</h4>
                </div>
              </div>
              <div class="col-sm-6">
                <div><img src="" id="preview1" style="width:32%;"></div>
              </div>
            </div>
          </div>
        </div>
        <input type="file" name="fileToUpload1" id="fileToUpload1" onchange="readURL1(this);" style="display:none;" />
        <div class="help-block form-text with-errors form-control-feedback"></div>
      </div>
    </div>


  </div>

  <!--<input class="btn btn-primary" type="submit" value="Save">-->
  <div id="tohidenew">
    <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mupdate_close" style="float: right;
    margin-top: 23px;">Cancel</button>
    <input class="btn btn-primary" type="submit" value="Save" style="float: right;
    margin-right: 10px;
    margin-top: 23px;">

  </div>

</form>

@endif