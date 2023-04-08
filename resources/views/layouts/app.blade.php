<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{ config('app.name', 'RADD') }}</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('assets/img/favicons/favicon-16x16.png') }}">
   <!--  <link rel="shortcut icon" href="{{asset('assets/media/logos/myicon.png')}}" /> -->
    <link rel="manifest" href="{{ url('assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ url('assets/img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ url('assets/js/config.js') }}"></script>
    <script src="{{ url('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>
    <link href="{{ url('vendors/choices/choices.min.css') }}" rel="stylesheet" />


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">

    <link href="{{ url('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ url('assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ url('assets/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ url('assets/css/user.min.css') }}" rel="stylesheet" id="user-style-default">    

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>    
    <script src="{{ url('vendors/fontawesome/all.min.js') }}"></script>
    <style type="text/css">
      :root, :root.light, :root .light{
        --falcon-primary: #276b64;
        --falcon-card-gradient: linear-gradient(-45deg, #276b64, #45b3a7);
      }
      .btn-primary, .navbar-vertical .btn-purchase, .tox .tox-menu__footer .tox-button:last-child, .tox .tox-dialog__footer .tox-button:last-child {
        --falcon-btn-color: #fff;
        --falcon-btn-bg: #276b64;
        --falcon-btn-border-color: #276b64;
        --falcon-btn-hover-color: #fff;
        --falcon-btn-hover-bg: #18544f;
        --falcon-btn-hover-border-color: #18544f;
        --falcon-btn-focus-shadow-rgb: 76, 143, 233;
        --falcon-btn-active-color: #fff;
        --falcon-btn-active-bg: #18544f;
        --falcon-btn-active-border-color: #18544f;
        --falcon-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --falcon-btn-disabled-color: #fff;
        --falcon-btn-disabled-bg: #276b64;
        --falcon-btn-disabled-border-color: #276b64;
      }
    </style>
  </head>

<body>     
    <main class="main" id="top">
        @yield('content')
    </main>
</body>
</html>
