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
  if(isset($tenant) && !empty($tenant))
  {
    $helper->SetTenant_PrimaryLanguage($tenant->tenantid);
  }
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
          {{trans('login.login_text_pagetitle')}}
        </h4>
      
                  <form class="form-horizontal" method="POST" action="{{ route('login') }}">
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

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">
                            {{trans('login.login_label_password')}}
                           </label>

                           <!--  <div class="col-md-6"> -->
                                <input id="password" type="password" class="form-control" name="password" placeholder="{{trans('login.login_placeholder_password')}}" required>

                               
                           <!--  </div> -->
                           <div class="pre-icon os-icon os-icon-fingerprint"></div>
                        </div>

<!--                         <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div> -->
                        
        <div class="buttons-w">
            <button type="submit" class="btn btn-primary" >
            {{trans('login.login_loginbutton_caption')}}
           </button>
            <div class="form-check-inline">
              <label class="form-check-label"><input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>{{trans('login.login_text_rememberme')}}</label>
            </div>

            <div>
                @if(isset($tenant) && !empty($tenant))
            <label style="margin-top:15px;"><a href="/forgotpassword?tid={{$tenant->tenantid}}">Forgot Password</a></label>
                @else
                <label style="margin-top:15px;"><a href="/forgotpassword">Forgot Password</a></label>
                @endif
                
            </div>
          </div>
<br>

      
      
       @if ($errors->has('email'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
      
      @if ($errors->has('password'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
      @if (Session::has('activemessage'))
   <div class="alert alert-danger">{{ Session::get('activemessage') }}</div>
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
