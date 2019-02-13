<!DOCTYPE html>
<html>
  <head>
    <title>Artha</title>
    <meta content="Artha language" name="keywords">
    <meta content="Artha dashboard" name="description">
    
      @include('shared._html_header')

  </head>
  <body class="auth-wrapper">
    <div class="all-wrapper menu-side with-side-panel">     
      <div class="layout-w">
        @if(isset($layout))
          @include('shared._' . $layout)
        @endif
         
           
        @include('shared._mobile_menu')
        @yield('content')
      </div>
      <div class="display-type"></div>
    </div>
     
    

      @include('shared._html_footer')
      
       @yield('scripts')
      
       {{-- @include('shared._footer') --}}
    
  </body>
</html>