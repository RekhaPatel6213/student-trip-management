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

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicons/favicon-16x16.png') }}">
    <!-- <link rel="shortcut icon" href="{{asset('assets/media/logos/myicon.png')}}" /> -->
    <link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">

    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('assets/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('assets/css/user.min.css') }}" rel="stylesheet" id="user-style-default">   
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" /> 
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" id="user-style-default">
    @stack('styles')

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

    @php
      $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
    @endphp

    @if($routeName === 'schedule.meal.registration')
      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

      <script type="text/javascript" src="{{ asset('assets/js/signature/jquery.signature.js') }}"></script>
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.signature.css') }}">
    @endif
  </head>

<body>     
    <main class="main" id="top">
        <div class='loading'></div>
        <div class="px-6 mt-3">
          @include('components.flash-message')
        </div>
        @yield('content')
    </main>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->

    <script type="text/javascript">
      var datePickerFormate = "{{ config('constants.DATE_FORMATE') }}";
    </script>

    @if($routeName !== 'schedule.meal.registration')
      <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    @endif
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-input-mask-phone-number.min.js') }}"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
    @stack('scripts')
</body>
</html>
