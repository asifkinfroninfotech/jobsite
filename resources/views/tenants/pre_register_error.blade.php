@extends('layouts.tenant_layout')
@section('content')

<div class="all-wrapper menu-side login-information">
    <div class="auth-box-w">
        <div class="logo-w">
            {{-- <a href="{{url('/')}}"><img alt="" src="{{asset('img/logo_desktop.png')}}"></a> --}}
        </div>
        <!-- START - login info content area -->
        <div class="col-sm-12 col-md-12">
            <div class="element-wrapper">
                <div class="login-info-hd text-center">
                    <h5 class="element-inner-header">
                        @if(isset($errormessage) && !empty($errormessage) )
                    <span>{{$errormessage}}</span>	
                        @else
                        <span>Error! Please contact administrator.</span>	
                        @endif					
                    </h5> 
                </div>
                                     
            </div>                      
        </div>
        <!-- END - login info content area -->
    </div>
    <p class="copy-right text-center">
        &copy; Copyright {{date('Y')}} Tenant. All rights reseved.
    </p>
</div>
@endsection


