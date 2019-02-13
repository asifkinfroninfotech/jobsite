@extends('layouts.tenant_layout')

@section('content')
               
                
              <div class="all-wrapper menu-side login-information">
      <div class="auth-box-w">
        @if(isset($tenantdetails) && !empty($tenantdetails))
        @if(isset($tenantdetails->logo) && !empty($tenantdetails->logo) && File::exists(public_path('/storage/tenant/logoimage/'.$tenantdetails->logo)))
        <div class="logo-w">
  
          <img alt="" src="{{'/storage/tenant/logoimage/'.$tenantdetails->logo}}">
  
        </div>
        @else    
        <div class="logo-w">
        <a href="/"><img alt="" src="/img/logo_desktop.png"></a>
      </div>
        @endif
        @else
        <div class="logo-w">
          <a href="/"><img alt="" src="/img/logo_desktop.png"></a>
        </div>
        @endif


         <!-- START - login info content area profile-setup-confim-->
                     <div class="col-sm-12 col-md-12">
                      <div class="element-wrapper">

                        <div class="login-info-hd text-center">
                            <h5 class="element-inner-header">
                              Welcome back {{$tenantdetails->company}}                                                             
                            </h5> 
                              {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,  sed do eiusmod tempor <br/> incididunt ut labore et dolore magna aliqua.
                               </p>                         --}}
                        </div>
                        <div class="steps-w">                             
                            <div class="step-contents payment-faild payment-success">                          
                                <a href="#"><i class="icon-check"></i></a>
                                <div class="text-center payment-faild-message">
                                  <h5 class="element-inner-header"> Setup Completed</h5> 
                                  {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,  sed do eiusmod tempor <br> incididunt ut labore et dolore magna aliqua.
                                  </p> --}}
                                </div>
                                <div class="text-center">
                                    <a class="btn btn-primary" href="/">Go To My Dashboard</a>
                                </div>    
                            </div>
                          </div>                      
                      </div>                      
                    </div>
                          <!-- END - login info content area -->
        
      </div>
      <p class="copy-right text-center">
          &copy; Copyright {{date('Y')}} {{\App\Helpers\AppGlobal::$Artha_Company_Name}}. All rights reseved.
        </p>
    </div>
                
                @endsection


                @section('scripts')
                @endsection
                
                
                
                


