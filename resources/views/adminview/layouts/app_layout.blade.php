<!DOCTYPE html>
<html>
<head>
    <title>Artha</title>
    <meta content="Artha language" name="keywords">
    <meta content="Artha dashboard" name="description">

    @include('adminview.shared._html_header')

</head>
<body class=" with-content-panel">
    <div class="all-wrapper menu-side with-side-panel">
        <div class="layout-w">
            @if(isset($layout))
            @include('adminview.shared._' . $layout)
            @endif


            @include('adminview.shared._mobile_menu')
            @yield('content')
        </div>
        <div class="display-type"></div>
    </div>

    @include('adminview.shared._footer')

    @include('adminview.shared._html_footer')

    @yield('scripts')

</body>
</html>