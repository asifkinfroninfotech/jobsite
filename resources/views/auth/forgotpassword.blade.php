<!DOCTYPE html>
<html>
  <head>
    <title>Artha</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="Artha language" name="keywords">
    <meta content="Artha" name="author">
    <meta content="Artha dashboard" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="{{asset('img/favicon.png')}}" rel="shortcut icon">
    <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="{{asset('js/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('js/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <link href="{{asset('js/bower_components/dropzone/dist/dropzone.css')}}" rel="stylesheet">
    <link href="{{asset('js/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('js/bower_components/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">
    <link href="{{asset('js/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css')}}" rel="stylesheet">
    <link href="{{asset('js/bower_components/slick-carousel/slick/slick.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css?version=4.2.0')}}" rel="stylesheet">
  </head>
  @php
  $helper=\App\Helpers\AppHelper::instance();
  $tenant=$helper->getTenantDetails();
  $TenantLogoImagePath=\App\Helpers\AppGlobal::$TenantLogoPath;
  @endphp
  <body class="auth-wrapper">
    <div class="all-wrapper menu-side">
      <div class="auth-box-w">
        <div class="logo-w">
            @if(isset($tenant)&& !empty($tenant))

            @if(isset($tenant->logo) && !empty($tenant->logo) && File::exists(public_path('storage/tenant/logoimage/'.$tenant->logo)))
            <img alt="" src="{{$TenantLogoImagePath.$tenant->logo}}">
            @else
            <img alt="" src="{{Avatar::create(strtoupper($tenant->company))->toBase64()}}">
            @endif

            @else    
             <a href="/"><img alt="" src="img/logo_desktop.png"></a>
             @endif
        </div>
        <h4 class="auth-header">
          <!-- Login Form -->
          {{trans('login.forgotpassword_text_pagetitle')}}
        </h4>
      
                  <form class="form-horizontal" method="POST" action="/postforgetpassword">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">
                                {{trans('login.login_label_username')}}
                            </label>
                            <!-- <div class="col-md-6"> -->
                                <input id="email" type="email" class="form-control" name="email" 
                                placeholder="{{trans('login.login_placeholder_username')}}" value="{{ old('email') }}" required autofocus>

                              
                            <!-- </div> -->
                            @if(isset($tenant)&& !empty($tenant))
                            <input type="hidden" id="tenantid" name="tenantid" value="{{$tenant->tenantid}}"/>
                            @else
                            <input type="hidden" id="tenantid" name="tenantid" value=""/>
                            @endif
                            <div class="pre-icon os-icon os-icon-user-male-circle"></div>
                        </div>

                       
                        
        <div class="buttons-w">
            <button type="submit" class="btn btn-primary" >
            {{trans('login.update_button_caption')}}
           </button>
            <div class="form-check-inline">
              <label class="form-check-label"><a href="/login">Back to Login</a></label>
              
            </div>
            
       
          </div>
<br>

      
      
       @if ($errors->has('email'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
      
      
      @if (Session::has('emailstatus'))
   <div class="alert alert-danger">{{ Session::get('emailstatus') }}</div>
@endif

                    </form>
                   
                  
                    
      </div>
    </div>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
   $(document).ready(function(){
        setTimeout(function() {
          $('.alert-danger').fadeOut('fast');
        }, 3000); // <-- time in milliseconds
    });
  
  
  </script>
</html>
