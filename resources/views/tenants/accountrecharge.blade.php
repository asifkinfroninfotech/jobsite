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
                      <a aria-expanded="false" class="nav-link active" href="/tenant/account/subscription">Subscription</a>
                    </li>
                    <li class="nav-item">
                      <a aria-expanded="false" class="nav-link" href="/tenant/account/paymentmethod">Payment Method</a>
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
    <form>
     
       
        
         
         
                <div class="element-wrapper">
       
                
                    
                    
                    
                     <div class="element-box">
                    <h6 class="element-header">
                  Are you sure?
                    </h6>
                   <div class="form-desc">
                  Are you sure you want to recharge? Once you confirm, Recharge action will proceed.
                  To proceed, click the Account Recharge button below. Our team will process your request.
                    </div>
                    
                    <input class="btn btn-primary" id="editbtn" type="button" name="user_info" value="Recharge Account" onclick="rechargeaccount();"> 
                              
                    
                    </div>
                    <div class="alert alert-danger" style="display:none"<p id="messageresponse"></p></div>
                    
              </div>
           
         
        
    
    </form>
  </div>
</div>
               </div>
          </div>
          
       </div>
</div>
 @endsection

 @section('scripts')
 <script>
 

    
 function rechargeaccount()
 {
     $.get('/rechargeaccount',function(data){
        $('#messageresponse').text(data);
        $('.alert-danger').css('display','block');  
        setTimeout(function() {
            
            
          $('.alert-danger').fadeOut('fast');
        }, 3000); // <-- time in milliseconds
    
     });
     
     
     
 }
 
 </script>
 
 <script>
  
  
  
  </script>
 
 @endsection