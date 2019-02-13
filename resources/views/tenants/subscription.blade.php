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

                  <div class="table-responsive">
                    <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                        <thead>
                            <tr>
                                <th>Tenant Name</th>
                                 <th>Email</th>
                                 <th>Plan Name</th>
                                 <th>Plan Period</th>
                                 <th>End Date</th>
                                 <th>Renew Date</th>
                               
                                
                               
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                 <th>Tenant Name</th>
                                 <th>Email</th>
                                 <th>Plan Name</th>
                                 <th>Plan Period</th>
                                 <th>End Date</th>
                                 <th>Renew Date</th>
                               
                               
                            </tr>
                        </tfoot>
                        <tbody>
                        @if(isset($subscriptions) && !empty($subscriptions) && count($subscriptions)>0)
                        @foreach($subscriptions as $subscription)
                        
                        <tr>
                             <td>
                                <div class="user-with-avatar  ">
                                <a href="/tenant/profile/view?tenid={{$subscription->tenantid.'&calledfrom=tenant'}}" target="_blank"> 
                            @if( (isset($subscription->minilogoimage) && !empty($subscription->minilogoimage) ) && File::exists(public_path('/storage/tenant/minilogoimage/'.$subscription->minilogoimage)))
                            <img alt="" src="/storage/tenant/minilogoimage/{{$subscription->minilogoimage}}"/>
                               @else
                                <img alt="" src="{{ Avatar::create(ucfirst($subscription->firstname).' '.ucfirst($subscription->lastname))->toBase64() }}" />    
                              @endif
                                </a>
                              <span>{{$subscription->firstname.' '.$subscription->lastname}}</span>
                              </div>
                                
                            </td>
                            <td>
                               <span>{{ $subscription->email }}</span>
                                
                            </td>
                            <td>
                               <span>{{ $subscription->planname }}</span>
                                
                            </td>
                            
                            <td>
                               <span>{{ $subscription->planperiod }}</span>
                                
                            </td>
                            
                            
                            <td>
                               <span>{{ $subscription->trial_ends_at}}</span>
                                
                            </td>
                           
                            <td>
                               <span>{{ date('d-m-Y', strtotime($subscription->renews_at))}}</span>
                                
                            </td>
                             
                            
                           
                        </tr>
                       
                        @endforeach
                        @endif
                        </tbody></table>
                  </div>
                </div>
                    
                    
                    
                     <div class="element-box">
                    <h6 class="element-header">
                  Begin Account Cancellation
                    </h6>
                   <div class="form-desc">
                   If you no longer need to use Artha Platform, you can cancel your account. cancelling will permanently delete your account and all associated data. These action cannot be reverted.              
                    </div>
                    
                    <input class="btn btn-primary" id="editbtn" type="button" name="user_info" value="Begin Cancellation" onclick="window.location.href='/tenant/account/cancellation'"> 
                              
                    
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