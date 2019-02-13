<!DOCTYPE html>
<meta name="csrf-token" content="{{ csrf_token() }}">
<html>
<head>
    <title>Artha</title>
    <meta content="Artha language" name="keywords">
    <meta content="Artha dashboard" name="description">

    @include('tenants.shared._html_header')

</head>
<body class=" with-content-panel">
    <div class="all-wrapper menu-side with-side-panel">
        <div class="layout-w">
            @if(isset($layout))
            @include('tenants.shared._' . $layout)
            @endif


            {{-- @include('tenants.shared._mobile_menu') --}}
            @yield('content')
        </div>
        <div class="display-type"></div>
    </div>



    @include('tenants.shared._html_footer')

    @yield('scripts')

    @include('tenants.shared._footer')

</body>
</html>