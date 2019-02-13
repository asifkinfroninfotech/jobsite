@extends('layouts.tenant_layout')

@section('content')
               
                
                <div class="all-wrapper menu-side login-information">
      <div class="auth-box-w">
        <div class="logo-w">
          <a href="index.html"><img alt="" src="img/logo_desktop.png"></a>
        </div>
         <!-- START - login info content area -->
                     <div class="col-sm-12 col-md-12">
                      <div class="element-wrapper">
                        <div class="login-info-hd text-center">
                            <h5 class="element-inner-header">
                               <span>Package Name:</span>
                               $50 (Monthly)
                              </h5> 
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,  sed do eiusmod tempor <br/> incididunt ut labore et dolore magna aliqua.
                               </p>                        
                        </div>
                          <form id="formValidate">
                            <div class="steps-w">
                              <div class="step-triggers">
                                <a class="step-trigger active" href="#stepContent1">Login Information</a>
                                <a class="step-trigger active" href="#stepContent2">Company Profile</a>
                                <a class="step-trigger active" href="#stepContent3">Payment</a>
                              </div>
                              <div class="step-contents payment-faild payment-success">                          
                                  <a href="#"><i class="icon-check"></i></a>
                                  <div class="text-center payment-faild-message">
                                    <h5 class="element-inner-header"> Payment Successful </h5> 
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,  sed do eiusmod tempor <br> incididunt ut labore et dolore magna aliqua.
                                    </p>
                                  </div>
                              </div>
                            </div>
                          </form>                        
                      </div>                      
                    </div>
                          <!-- END - login info content area -->
        
      </div>
      <p class="copy-right text-center">
          &copy; Copyright 2018 Artha Platform. All rights reseved.
        </p>
    </div>
                
                @endsection


                @section('scripts')
                @endsection
                
                
                
                


