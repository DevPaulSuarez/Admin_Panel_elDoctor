<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>El Doctor | @yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    {{-- <script>
        if(localStorage.getItem('usuario') != null) {
            location.href = '/';
        }
    </script> --}}

    <link href="/assets/img/brand/favicon.png" rel="icon" type="image/x-icon">
    <link href="/assets/css/icons.css" rel="stylesheet">
    <link href="/assets/plugins/sidebar/sidebar.css" rel="stylesheet">
    <link href="/assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="/assets/css/closed-sidemenu.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/style-dark.css" rel="stylesheet">
    <link href="/assets/css/skin-modes.css" rel="stylesheet">
    <link href="/assets/css/animate.css" rel="stylesheet">

    @yield('extra-css')

</head>

<body class="main-body bg-light">

    <div id="global-loader">
        <img src="/assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>

    <div class="page">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugins/ionicons/ionicons.js"></script>
    <script src="/assets/plugins/moment/moment.js"></script>
    <script src="/assets/js/eva-icons.min.js"></script>
    <script src="/assets/js/custom.js"></script>

    @yield('extra-js')
</body>

</html>
