@section('content')
@extends('tenants.layouts.app_layout', ['layout' => 'left_side_menu_tenant'])
 <div class="layout-w">
      <div class="content-w portfolio-custom-vk">
          @include('tenants.shared._top_menu_tenant')
          
       
          <div class="content-i control-panel">
          <div class="content-box">
              
          <div class="os-tabs-w">
              <div class="os-tabs-controls">
                <ul class="nav nav-tabs upper">
                                       <li class="nav-item">
                      <a aria-expanded="false" class="nav-link" href="/tenant/account/subscription">Subscription</a>
                    </li>
                    <li class="nav-item">
                      <a aria-expanded="false" class="nav-link active" href="/tenant/account/paymentmethod">Payment Method</a>
                    </li>
                    <li class="nav-item">
                      <a aria-expanded="false" class="nav-link" href="/tenant/account/invoice"> Invoice</a>
                    </li>
                    

                                    </ul>
              </div>
            </div>
          </div>
        </div>
         
          
          
          
          
          
          <div class="content-i">
              <div class="content-box">
                  
                  
                  <div class="element-wrapper">
  <div class="element-box">
    
     
       
        
         
         
                <div class="element-wrapper">
       
                

               <div class="element-box">
    <form id="formValidate3" method="POST" action="{{url('/update_tenant_card')}}" >
                             {{ csrf_field() }} 
                                                                    <div class="row payment-card-img">
                                      <div class="col-sm-12">
                                        <div class="form-group">
                                          <label for=""> {{trans('tenant_edit.accept_card_content')}}</label>
                                          <img src="/img/payment-img.jpg" />
                                        </div>
                                      </div>                                   
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-12">
                                      <div class="form-group">
                                        <label for=""> {{trans('tenant_edit.card_name_lbl')}}* </label>
                                        <input type="hidden" name="talenthiddenid3" id="talenthiddenid3" value="">
                                        <input class="form-control" data-error="Your Card Name is invalid"
                                          placeholder="Name on card" required="required" type="Name" name="cardname" id="cardname" value="{{old('', $tenant->cardname)}}" disabled>
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>                                   
                                  </div>
                                  <div class="row">
                                      <div class="col-sm-12">
                                      <div class="form-group">
                                        <label for=""> {{trans('tenant_edit.card_number_lbl')}}*</label>
                                        <input class="form-control" data-error="Your Card Number is invalid" type="text" ondrop="return false;" onpaste="return false;" pattern="\d{16}" maxlength="16"
                                          placeholder=".... .... .... ...." required="required" type="Name" name="cardnumber" id="cardnumber" value="*{{old('', $tenant->card_last_four)}}" disabled>
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>  
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('tenant_edit.expiry_lbl')}}*</label>
                                        <input class="form-control" data-error="Your Expiry MM/YY is invalid" required="required"  
                                        placeholder="MM/YY" type="text" name="cardexpiry" id="cardexpiry" value="{{old('', $tenant->expiry)}}" disabled> 
<!--                                        <p class="charst-sert">Minimum of 6 characters</p>                                  -->
                                      </div>
                                    </div>
                                    <div class="col-sm-6" id="divCode" style="display:none;">
                                      <div class="form-group">
                                        <label for="">{{trans('tenant_edit.card_code_lbl')}}*</label>
                                        <input class="form-control" data-error="Your Card Code is invalid" required="required" ondrop="return false;" onpaste="return false;" pattern="\d{3}" maxlength="3"  
                                        placeholder="CVC" type="text" name="cardcode" id="cardcode" value="{{old('', $tenant->cvv)}}" disabled> 
                                       
                                      </div>
                                    </div>
                                  </div> 
                                  @if (Session::has('status'))
                                 <div class="alert alert-danger">{{ Session::get('status') }}</div>
                                 @endif
                              
                                 <div class="form-buttons-w text-right" id="divEdit">
                              
                                  <input class="btn btn-primary" id="editbtn" type="button" name="user_info" value="Edit" onclick="enanblesave();"> 
                              {{-- <input class="btn btn-primary" id="savebtn" type="submit" name="user_info" value="Save" style="visibility:hidden;"> --}}

                            </div>

                            <div class="form-buttons-w text-right" id="divSave" style="display:none;">
                              <input class="btn btn-primary" id="savebtn" type="submit" name="user_info" value="Save">
                            </div>
                            {{-- <div class="text-right">
                              <input class="btn btn-primary" id="savebtn" type="submit" name="user_info" value="Save" style="visibility:hidden;">
                            </div> --}}
                                  
                                  
                                  
                                  
<!--                               </div>-->
                            
                            </form>
                           </div> 
               
              </div>
           
         
        
    
   
  </div>
</div>
               </div>
          </div>
          
       </div>
</div>
 @endsection

 @section('scripts')
 <script>
     
     
 function enanblesave()
 {
     
     $('#divEdit').hide();
     $('#divSave').show();

     $('#divCode').show();

     $('#cardname').val('');
     $('#cardnumber').val('');
     $('#cardexpiry').val('');
     $('#cardcode').val('');

     //$("input").prop('disabled', true);
    $("#formValidate3 :input").prop("disabled", false);
     
 }
     
   
 
 </script>
 
 
 <script>
   $(document).ready(function(){

    //  $('#divCode').hide();
        setTimeout(function() {
          $('.alert-danger').fadeOut('fast');
        }, 3000); // <-- time in milliseconds
    });
  
  
  </script>
 
 @endsection