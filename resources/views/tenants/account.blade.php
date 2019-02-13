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
                      <a aria-expanded="false" class="nav-link active" href="/due-diligence-dashboard?pd=T8X5iBWPxURJwssS">Subscription</a>
                    </li>
                    <li class="nav-item">
                      <a aria-expanded="false" class="nav-link" href="/due-diligence-process?pd=T8X5iBWPxURJwssS">Payment Method</a>
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
      <div class="steps-w">
        <div class="step-triggers">
          <a class="step-trigger complete active" href="#stepContent1">Settings</a><a class="step-trigger complete" href="#stepContent2">Invoices</a>
        </div>
        <div class="step-contents">
          <div class="step-content active" id="stepContent1">
              <div class="user-profile">
              <div class="up-contents">
                  <h5 class="element-header">
                      Details
                      <a class="btn btn-primary" href="/tenant/profile/edit" style="float:right;"> Edit</a>
                  </h5>
                  <div class="row invst-pfl">
                    <div class="col-sm-5">
                     <div class="label">
                       Account Name
                     </div>
                      <h5>{{$tenantdetails->username}}</h5>
                    </div>
                    <div class="col-sm-4">
                        <div class="label">
                          Billing Plan
                        </div>
                        <h5>{{$tenantdetails->planperiod}}</h5>
                      </div>
                      <div class="col-sm-3">
                          <div class="label">Update Plan</div>
             @if(isset($tenantdetails->planperiod) && ($tenantdetails->planperiod=="Trial"))
                          <div class="form-check">
                          <label class="form-check-label"><input checked="" class="form-check-input" name="optionsRadios" type="radio" value="Trial" <?php if(isset($tenantdetails->planperiod) && ($tenantdetails->planperiod=="Trial")){echo "checked";}?> onclick="update('trial');"><h5>Trial</h5></label>
                     </div>
             @endif
              <div class="form-check">
                <label class="form-check-label"><input class="form-check-input" name="optionsRadios" type="radio" value="Quarterly" <?php if(isset($tenantdetails->planperiod) && ($tenantdetails->planperiod=="Quarterly")){echo "checked";}?> onclick="update('Quarterly');"><h5>Quarterly</h5></label>
              </div>
              <div class="form-check">
                <label class="form-check-label"><input class="form-check-input" name="optionsRadios" type="radio" value="Yearly"<?php if(isset($tenantdetails->planperiod) && ($tenantdetails->planperiod=="Yearly")){echo "checked";}?> onclick="update('Yearly');"><h5>Yearly</h5></label>
              </div>
            
                      </div>
                      
                      
                      
                  </div>
                  @if(!empty($cardnumber))
                  <div class="row invst-pfl">
                    <div class="col-sm-5">
                      <div class="label"> 
                       Payment Method
                     </div>
                      <h5>Card ending with {{$cardnumber}} 

                          
                          
                      </h5>
                    </div>
               
                  </div>
                  @endif
               
                
                </div>
              
              
                <div class="up-contents investment-pdtop">
                  <h5 class="element-header">
                      About You
                  </h5>
                  <div class="row invst-pfl">
                    <div class="col-sm-5">
                     <div class="label">
                      Email
                     </div>
                      <h5>{{$tenantdetails->email}}</h5>
                    </div>
                    <div class="col-sm-7">
                        <div class="label">
                         Full Name
                        </div>
                        <h5>{{$tenantdetails->firstname." ".$tenantdetails->lastname}}</h5>
                      </div>
                  </div>
                  <div class="row invst-pfl">
                    
                      <div class="col-sm-7">
                      <div class="label"> 
                       Password
                     </div>
                          <h5>
                              @for($i=0;$i<$password;$i++)
                              *
                              @endfor
                          </h5>
                    </div>
               
                  </div>
               
                
                </div>
              
           
            <div class="form-buttons-w text-right">
              <a class="btn btn-primary step-trigger-btn" href="#stepContent2"> Next</a>
            </div>
          </div>
          
          </div>
            <div class="step-content" id="stepContent2">
                <div class="element-wrapper">
                <h6 class="element-header">
                Invoices
                </h6>
                <div class="element-box">

                  <div class="table-responsive">
                    <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                        <thead>
                            <tr>
                               <th>Invoice Number</th>
                                <th>Invoice Date</th>
                                <th>Amount</th>
                                
                               
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                 <th>Invoice Number</th>
                                  <th>Invoice Date</th>
                                <th>Amount</th>
                               
                            </tr>
                        </tfoot>
                        <tbody>
                        @if(isset($invoices) && !empty($invoices) && count($invoices)>0)
                        @foreach($invoices as $invoice)
                        
                        <tr>
                             <td>
                               <span><a href="/tenant/invoice/?invoiceid={{ $invoice->id }}">{{ $invoice->number }}</a></span>
                                
                            </td>
                            
                            <td>
                               <span>{{ $invoice->date()->toFormattedDateString() }}</span>
                                
                            </td>
                            <td>
                               <span>{{ $invoice->total() }}</span>
                                
                            </td>
                             
                            
                           
                        </tr>
                       
                        @endforeach
                        @endif
                        </tbody></table>
                  </div>
                </div>
              </div>
           
          </div>
        </div>
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
 var current=$('input[name=optionsRadios]:checked').val();
 function update(plan)
 {
     
     if(current!=plan)
     {
         debugger;
         $.get('/changeplan?plan='+plan,function(data){
             
             location. reload();
         });
         
     }
 }
 
 </script>
 
 @endsection