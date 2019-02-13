<div class="row">
        <div class="col-sm-12">
            <div class="form-group ">
                <label for="">
                    {{trans('my_tender.popup_tender_name_lbl')}}
                </label>
                <input class="form-control" placeholder="{{trans('my_tender.popup_tender_name_place')}}" data-error="{{trans('my_tender.popup_tender_name_error')}}"
                    required="required" type="text" name="tender_name" id="tender_name">
                <div class="help-block form-text with-errors form-control-feedback"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="">
                    {{trans('my_tender.popup_start_date_lbl')}}
                </label>
                <input class="form-control" placeholder="{{trans('my_tender.popup_start_date_placeholder')}}" data-error="{{trans('my_tender.popup_start_date_error')}}"
                    required="required" type="text" name="start_date" id="start_date">
                <div class="help-block form-text with-errors form-control-feedback"></div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="">
                    {{trans('my_tender.popup_end_date_lbl')}}
                </label>
                <input class="form-control" placeholder="{{trans('my_tender.popup_end_date_placeholder')}}" data-error="{{trans('my_tender.popup_end_date_error')}}"
                    required="required" type="text" name="end_date" id="end_date" onblur="checkend();">
                <div class="help-block form-text with-errors form-control-feedback"></div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>
                    {{trans('my_tender.popup_description_lbl')}}
                </label>
                <textarea name="description" id="description" class="form-control" 
                    rows="3"></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="">
                    {{trans('my_tender.popup_type_lbl')}}
                </label>
                <select name="pri_pub_compbo" id="pri_pub_compbo" class="form-control" placeholder="{{trans('my_tender.popup_type_place')}}"
                    data-error="{{trans('my_tender.popup_type_error')}}" required="required">
                    <option value="">{{trans('my_tender.popup_type_select_lbl')}}</option>
                    <option value="Private">{{trans('my_tender.popup_type_private_lbl')}}</option>
                    <option value="Public">{{trans('my_tender.popup_type_public_lbl')}}</option>

                </select>
                <div class="help-block form-text with-errors form-control-feedback"></div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="">
                    {{trans('my_tender.popup_select_deal_lbl')}}
                </label>
                <select multiple id="mydeals" name="mydeals[]" class="form-control select2">

                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class='col-sm-12'>
            <div class='form-group'>
                <label for="">
                    {{trans('my_tender.popup_file1_lbl')}}
                </label>
            <br/>
                <input type="file" id='import_file' name="import_file">
            </div>
        </div>

    </div>

    <div class="row">
            <div class='col-sm-12'>
                    <div class='form-group'>
                        <label for="">
                          {{trans('my_tender.popup_file2_lbl')}}
                        </label>
                        <br/>
                        <input type="file" id='import_file1' name="import_file1">
                    </div>
                </div>
    </div>



   <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>
                    {{trans('my_tender.services_requested_label')}}
                </label>
                <textarea name="services_requested" id="services_requested" class="form-control" 
                    rows="3"  required="required" data-error="{{trans('my_tender.service_requested_error')}}"></textarea>
                
                 <div class="help-block form-text with-errors form-control-feedback"></div>
            </div>
        </div>
       
       <div class="col-sm-12">
            <div class="form-group">
                <label>
                    {{trans('my_tender.desired_time_frame_label')}}
                </label>
                <input type="text" name="desired_time_frame" id="desired_time_frame" class="form-control" required="required"  data-error="{{trans('my_tender.desired_time_frame_error')}}"
                    >
                 <div class="help-block form-text with-errors form-control-feedback"></div>
            </div>
        </div>
       
       <div class="col-sm-12">
            <div class="form-group">
                <label>
                    {{trans('my_tender.resource_requirements_label')}}
                </label>
                <textarea name="resource_requirements" id="resource_requirements" class="form-control" required="required" data-error="{{trans('my_tender.resource_requirement_error')}}"
                    rows="3"></textarea>
                <div class="help-block form-text with-errors form-control-feedback"></div>
            </div>
        </div>
       
       
       <div class="col-sm-12">
            <div class="form-group">
                <label>
                    {{trans('my_tender.approximate_budget')}}
                </label>
                <div class="input-group">
                                    
              
                <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        {{$symbol}}
                                      </div>
                    </div>
               
                <input class="form-control" placeholder="{{trans('my_tender.approximate_budget')}}"
                    type="number" name="approx_budget" id="approx_budget" >
                   </div>
            </div>
        </div>
       
    </div>

