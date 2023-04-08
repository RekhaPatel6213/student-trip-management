<!DOCTYPE html>
<html lang="en-US" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>@yield('title')</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicons/favicon-16x16.png') }}">
    <!-- <link rel="shortcut icon" href="{{asset('assets/media/logos/myicon.png')}}" /> -->
    <link rel="manifest" href="{{asset('assets/img/favicons/manifest.json')}}" >
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

    <script>
      var isRTL = JSON.parse(localStorage.getItem('isRTL'));
      if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
    <style>
        .navbar-vertical .toggle-icon-wrapper {
            margin-right: 0.25rem !important;
          }
            .dark .main_logo{
              content: url(assets/media/logos/ftf_white.png)
            }
          .dark a.radd_logo {
            color: #fff;
          }
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

    @php
      $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
    @endphp

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container-fluid" data-layout="container">
        <script>
          var isFluid = JSON.parse(localStorage.getItem('isFluid'));
          if (isFluid) {
            var container = document.querySelector('[data-layout]');
            container.classList.remove('container');
            container.classList.add('container-fluid');
          }
        </script>
        <nav class="navbar navbar-light navbar-vertical navbar-expand-xl navbar-vibrant">
          <script>
            var navbarStyle = localStorage.getItem("navbarStyle");
            if (navbarStyle && navbarStyle !== 'transparent') {
              document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
            }
          </script>
          <div class="d-flex align-items-center">
            <div class="toggle-icon-wrapper">

              <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
            </div>
            <a class="navbar-brand">
              <div class="d-flex align-items-center py-3"><span style="color:#276b64">SCICON</span>
              </div>
            </a>
            
          </div>
          <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
            <div class="navbar-vertical-content scrollbar bg-card-gradient">
              <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                <li class="nav-item">
                  <!-- parent pages-->
                  <a class="nav-link {{ $routeName === 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}" >
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><svg class="svg-inline--fa fa-chart-pie fa-w-17" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chart-pie" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 544 512" data-fa-i2svg=""><path fill="currentColor" d="M527.79 288H290.5l158.03 158.03c6.04 6.04 15.98 6.53 22.19.68 38.7-36.46 65.32-85.61 73.13-140.86 1.34-9.46-6.51-17.85-16.06-17.85zm-15.83-64.8C503.72 103.74 408.26 8.28 288.8.04 279.68-.59 272 7.1 272 16.24V240h223.77c9.14 0 16.82-7.68 16.19-16.8zM224 288V50.71c0-9.55-8.39-17.4-17.84-16.06C86.99 51.49-4.1 155.6.14 280.37 4.5 408.51 114.83 513.59 243.03 511.98c50.4-.63 96.97-16.87 135.26-44.03 7.9-5.6 8.42-17.23 1.57-24.08L224 288z"></path></svg><!-- <span class="fas fa-chart-pie"></span> Font Awesome fontawesome.com --></span><span class="nav-link-text ps-1">Home</span>
                    </div>
                  </a>
                  <!-- label-->
                  <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Modules
                    </div>
                    <div class="col ps-0">
                      <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                  </div>
                  <!-- parent pages-->
                  
                  @if(config('constants.LEFT_MENU'))
                    @foreach(config('constants.LEFT_MENU') as $menuName => $mainMenu)
                      @php
                        $subMenu = !empty($mainMenu['subMenu']) ? true : false;
                        if($menuName === 'Records'){
                          $currentRoute = explode('.',$routeName);
                          if(in_array($currentRoute[0], ['roles','users','districts','administrators','schools','emailTemplates','cabins'])){
                            $routeName = $currentRoute[0].'.index';
                            $mainMenu['routename'] = $routeName;
                          }
                        }

                        if($menuName === 'Admin'){
                          $currentRoute = explode('.',$routeName);
                          if(in_array($currentRoute[0], ['staffAssignments'])){
                            $routeName = $currentRoute[0].'.index';
                            $mainMenu['routename'] = $routeName;
                          }
                        }
                      @endphp

                      <a class="nav-link {{ $subMenu ? 'dropdown-indicator' : '' }} {{ isset($mainMenu['routename']) && $routeName === $mainMenu['routename'] ? 'active' : '' }}" href="{{ $subMenu ? '#'.$mainMenu['id'] : route($mainMenu['routename']) }}" {{ $subMenu ? 'role=button data-bs-toggle=collapse' : '' }}  aria-expanded="{{ str_contains($routeName, $mainMenu['id']) || str_contains($routeName, $mainMenu['routename']) ? 'true' : 'false' }}" aria-controls="{{ $mainMenu['id'] }}">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas {{ $mainMenu['icon'] }}"></span></span><span class="nav-link-text ps-1">{{ $menuName }}</span>
                        </div>
                      </a>
                      @if($subMenu)
                        <ul class="nav collapse {{ str_contains($routeName, $mainMenu['id']) || str_contains($routeName, $mainMenu['routename']) ? 'show' : '' }}" id="{{ $mainMenu['id'] }}">
                          @foreach($mainMenu['subMenu'] as $menu => $menuLink)
                            <li class="nav-item">
                              <a class="nav-link {{ $routeName === $menuLink ? 'active' : '' }}" href="{{ $menuLink != '' ? route($menuLink) : '' }}" data-bs-toggle="" aria-expanded="{{ $routeName === $menuLink ? 'true' : 'false' }}">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">{{ $menu }}</span>
                                </div>
                              </a>
                            </li>
                          @endforeach
                        </ul>
                      @endif
                    @endforeach
                  @endif
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <div class="content">
          <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

            <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
            <a class="navbar-brand me-1 me-sm-3" href="">
              <div class="d-flex align-items-center py-3"><img class="me-2  main_logo" src="assets/media/logos/ftf_blue.png" alt="" width="200" />
              </div>
            </a>
            <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
              <li class="nav-item">
                <div class="theme-control-toggle fa-icon-wait px-2">
                  <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="theme" value="dark"/>
                  <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to light theme"><span class="fas fa-sun fs-0"></span></label>
                  <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to dark theme"><span class="fas fa-moon fs-0"></span></label>
                </div>
              </li>                 

              <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2 show" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="avatar avatar-xl">
                    <img class="rounded-circle" src="{{ url('assets/img/team/avatar.png') }}" alt="" />
                  </div>
                </a>
                <div class="dropdown-menu dropdown-caret dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser" data-bs-popper="static">
                  <div class="bg-white dark__bg-1000 rounded-2 py-2">
                    <a class="dropdown-item fw-bold text-warning">
                      <span>{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}                               
                    </a>
                    <form id="logout-form" action="{{ route('signout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                  </div>
                </div>
              </li>
            </ul>
          </nav>
          <div class='loading'></div>
          @include('components.flash-message')
          @yield('content')
          <footer class="footer">
            <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
              <div class="col-12 col-sm-auto text-center">
                <p class="mb-0 text-600">Thank you <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> {{date('Y')}} &copy; </p>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <script type="text/javascript">
      var datePickerFormate = "{{ config('constants.DATE_FORMATE') }}";
      var deleteTitle = "{{__('actions.areYouSureWantDelete')}}";
      var deleteSubText = "{{__('actions.deleteSubwarning')}}";
      var deleteButton = "{{__('actions.deleteButton')}}";
      var deletedIcon = "{{__('actions.deleted')}}"
    </script>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ url('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ url('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ url('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ url('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ url('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ url('vendors/is/is.min.js') }}"></script>
    <!-- <script src="{{-- url('vendors/chart/chart.min.js') --}}"></script>
    <script src="{{-- url('vendors/countup/countUp.umd.js') --}}"></script> -->
    <script src="{{ url('vendors/lodash/lodash.min.js') }}"></script>
    <!-- <script src="{{-- url('vendors/echarts/echarts.min.js') --}}"></script> -->
    <script src="{{ url('vendors/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ url('vendors/fontawesome/all.min.js') }}"></script>
    <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script> -->
    <script src="{{ url('assets/js/theme.js') }}"></script>
    <script src="{{ url('vendors/prism/prism.js') }}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script> -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-input-mask-phone-number.min.js') }}"></script>
    
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @stack('scripts')
    <script>
      feather.replace()

      /*setTimeout(function() {
        $('.alert.alert-dismissible').fadeOut('fast');
      }, 10000);*/
    </script>
  </body>
</html>