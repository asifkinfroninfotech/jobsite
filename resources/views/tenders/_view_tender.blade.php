

                      
                        
                          <div class="row">
                              <div class="col-sm-12">
                              <div class="form-group ">
                                  <label for="">
                                 {{trans('my_tender.popup_edit_tender_name_title')}}
                                  </label>
                                  <input class="form-control" placeholder="Enter Tender Name" data-error="Tender name is required." required="required" type="text" name="tender_name_edit" id="tender_name_edit" value="{{$tenderview->title}}" disabled>
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                          </div>
                            
                          <div class="row">
                              <div class="col-sm-6">
                              <div class="form-group">
                                  <label for="">
                                  {{trans('my_tender.popup_edit_start_date_title')}}
                                  </label>
<!--                                  <input class="form-control "  placeholder="Start Date" data-error="Start Date is Required." required="required" type="date" name="start_date_edit" id="start_date_edit" value="{{ date( 'Y-m-d', strtotime($tenderview->startdate) )}}" >-->
                                  
                                   <input class="form-control "  placeholder="Start Date" data-error="Start Date is Required." required="required"  name="start_date_edit" id="start_date_edit"  value="{{ date( 'd-M-Y', strtotime($tenderview->startdate) )}}">
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>
                              
                            <div class="col-sm-6">
                              <div class="form-group">
                                  <label for="">
                                  {{trans('my_tender.popup_edit_end_date_title')}}
                                  </label>
<!--                                  <input class="form-control" placeholder="End Date" data-error="End Date is required" required="required" type="date" name="end_date_edit" id="end_date_edit" onblur="checkend();" value="{{ date( 'Y-m-d', strtotime($tenderview->enddate) )}}" >-->
                                  <input class="form-control" placeholder="End Date" data-error="End Date is required" required="required"  name="end_date_edit" id="end_date_edit" onblur="checkend();"  value="{{ date( 'd-M-Y', strtotime($tenderview->enddate) )}}">
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                            </div>  
                              
                          </div>  
                            <div class="row">
                                <div class="col-sm-12">
                            <div class="form-group">
                              <label> 
                                {{trans('my_tender.popup_edit_description_title')}}
                              </label>
                              <textarea name="description_edit" id="description_edit" class="form-control" rows="3" disabled>{{$tenderview->description}}</textarea>
                            </div>
                                    </div>
                                </div>
                            
                            <div class="row">
                             <div class="col-sm-6">   
                             <div class="form-group">
                               <label for="">
                                    {{trans('my_tender.popup_edit_type_title')}}
                               </label>
                                   <select name="pri_pub_compbo_edit" id="pri_pub_compbo_edit" class="form-control" placeholder="Private/Public" data-error="Private/Public is required." required="required" disabled>
                                    <option value="">{{trans('my_tender.popup_edit_private_public_select')}}</option>
                                    <option value="Private" <?php if(isset($tenderview->type) && !empty($tenderview->type) && ($tenderview->type=="Private")){echo 'selected';}?>>{{trans('my_tender.popup_edit_select_private')}}</option>
                                    <option value="Public" <?php if(isset($tenderview->type) && !empty($tenderview->type) && ($tenderview->type=="Public")){echo 'selected';}?>>{{trans('my_tender.popup_edit_select_public')}}</option>
                                                                                                                  
                                   </select>
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                                </div>
                              </div>  
                            </div>




                    <div class="row">
                              <div class="col-sm-12">   
                             <div class="form-group">
                               <label for="">
                                    {{trans('my_tender.popup_edit_select_deal_title')}}
                               </label>
                                 <br/>
                                <label>{{trans('my_tender.popup_edit_selected_deal_lbl')}} : {{$tenderview->projectname}}</label> 
                                </div>
                               <div class="form-group">     
                               <select  multiple name="deallistview[]" id="deallistview" class="form-control select2" disabled>
                               
                               </select>
                               </div>    
                                  <div class="help-block form-text with-errors form-control-feedback"></div>
                               
                              </div>  
                              
                          </div>
                          
                          
                   
                          <div class="row">
                               <div class='col-sm-6'>
                                   <div class='form-group'>
                              <label for="">
                                    {{trans('my_tender.popup_edit_file1_lbl')}}
                               </label>
                                       <br/>
                                       @if(isset($tenderview->file1) && !empty($tenderview->file1))
                                       {{$tenderview->file1}}
                                       <br/>
                                       @endif
                                        <input  type="file" id='import_file' name="import_file_edit" />
                                       </div>
                                    </div>
                               <div class='col-sm-6'>
                                   <div class='form-group'>
                              <label for="">
                                    {{trans('my_tender.popup_edit_file2_lbl')}}
                               </label>
                                       <br/>
                                        @if(isset($tenderview->file2) && !empty($tenderview->file2))
                                       {{$tenderview->file2}}
                                       <br/>
                                       @endif
                                        <input  type="file" id='import_file1' name="import_file1_edit" />
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
                    rows="3"  required="required" data-error="{{trans('my_tender.service_requested_error')}}">{{(isset($tenderview->services_requested)&&!empty($tenderview->services_requested))?$tenderview->services_requested:''}}</textarea>
                
                 <div class="help-block form-text with-errors form-control-feedback"></div>
            </div>
        </div>
       
       <div class="col-sm-12">
            <div class="form-group">
                <label>
                    {{trans('my_tender.desired_time_frame_label')}}
                </label>
                <input type="text" name="desired_time_frame" id="desired_time_frame" class="form-control" required="required"  data-error="{{trans('my_tender.desired_time_frame_error')}}"
                    value="{{(isset($tenderview->desired_time_frame)&&!empty($tenderview->desired_time_frame))?$tenderview->desired_time_frame:''}}">
                 <div class="help-block form-text with-errors form-control-feedback"></div>
            </div>
        </div>
       
       <div class="col-sm-12">
            <div class="form-group">
                <label>
                    {{trans('my_tender.resource_requirements_label')}}
                </label>
                <textarea name="resource_requirements" id="resource_requirements" class="form-control" required="required" data-error="{{trans('my_tender.resource_requirement_error')}}"
                    rows="3">{{(isset($tenderview->resource_requirements)&&!empty($tenderview->resource_requirements))?$tenderview->resource_requirements:''}}</textarea>
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
                    type="number" name="approx_budget" id="approx_budget" value="{{(isset($tenderview->approximate_budget)&&!empty($tenderview->approximate_budget))?$tenderview->approximate_budget:''}}">
                   </div>
            </div>
        </div>
</div>


 
                          
<!--                          <div class='row'>  
                           <div class='col-sm-6'>
                        <div class='form-group'>
                             <input  type="file" id='import_file' name="import_file_edit" />
                        </div>    
                    </div>
                              <div class='col-sm-6'>
                        <div class='form-group'>
                             <input  type="file" id='import_file1' name="import_file1_edit" />
                        </div>    
                    </div>
                  
                </div> -->

                             





                            
                           <input type="hidden" name="tendertype" id="tendertype" value="{{$tenderview->type}}">
                            
                        
                   
                    

                    
                  