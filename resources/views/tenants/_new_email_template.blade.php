<div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="">
                  {{trans('tenant_email.popup_send_email_companytype')}}
                </label>
               
                <select multiple class="form-control select2" name="companytype[]" id="companymultipletype" onchange="multicompanytypes();">
                   
                  @foreach($getcompanytypes as $companytype)
                  <option value="{{$companytype->companytypeid}}">{{$companytype->companytype}}</option>
                  
                  @endforeach
                </select>
            </div>
        </div>
                       
                       
            <div class="col-sm-6">
            <div class="form-group">
                <label for="">
                  {{trans('tenant_email.popup_send_email_searchcompany')}}
                </label>
               
                <input type="text" name="searchcompanies" id="searchcompanies" class="form-control" onkeyup="searchcomp();">
            </div>
        </div>                   
                       
                       
    </div>
                        
                        <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="">
     
                  
                  {{trans('tenant_email.popup_send_email_select_companis')}}
                </label>
               
                <select multiple class="form-control select2" name="companies[]" id="multicompanies" >
                 <option value="">Please select</option>  
              
                </select>
            </div>
        </div>
    </div>


            <div class="form-group row">
            <label class="col-sm-4 col-form-label">Select All-Users/Admin</label>
            <div class="col-sm-8">
              <div class="form-check">
                <label class="form-check-label"><input checked="" class="form-check-input" name="optionsRadios" type="radio" value="option1">Option number one</label>
              </div>
              <div class="form-check">
                <label class="form-check-label"><input class="form-check-input" name="optionsRadios" type="radio" value="option2">Here is another radio option</label>
              </div>
              <div class="form-check">
                <label class="form-check-label"><input class="form-check-input" name="optionsRadios" type="radio" value="option3">Option three is here</label>
              </div>
            </div>
          </div>




                        
                        
                                            <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <input type="radio" name="user" value="all_user" checked>{{trans('tenant_email.popup_send_email_radio_alluser')}}
                <input type="radio" name="user" value="admin_user">Admin {{trans('tenant_email.popup_send_email_radio_admin')}}
               <div id="emailmessagepop" class="alert alert-danger" style="display:none;">
                   
                  <p>{{trans('tenant_email.popup_send_email_error')}}</p>
                 
                </div>
            </div>
        </div>
    </div>