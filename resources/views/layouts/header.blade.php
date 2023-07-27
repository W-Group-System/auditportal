<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @laravelPWA
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="shortcut icon" href="{{ asset('images/icons/icon-144x144.png') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }} ">
    

    @yield('css')
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
    <style>
      .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('images/loader.gif') }}") 50% 50% no-repeat white;
        opacity: .8;
        background-size: 50px 50px;
      }
    </style>
</head>
<body>
  <div id="loader" style="display:none;" class="loader">
	</div>
    <div class="container-scroller">
       
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
            <a class="navbar-brand brand-logo  text-center" href="{{url('/')}}"><img src="{{ asset('company_images/wgroup.png') }}" class="me-2" alt="logo"/></a>
            <a class="navbar-brand brand-logo-mini" href="{{url('/')}}"><img src="{{ asset('images/icon.png') }}" alt="logo"/></a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
                
              <li class="nav-item nav-profile dropdown">
                Welcome to {{ config('app.name', 'Laravel') }} &nbsp;
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                  <img src="{{ asset('images/no_image.png') }}" alt="profile"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <a class="dropdown-item">
                    <i class="ti-settings text-primary"></i>
                    Settings
                  </a>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="logout(); show();">
                    <i class="ti-power-off text-primary"></i>
                    Logout
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                </div>
              </li>
            
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="icon-menu"></span>
            </button>
          </div>
        </nav> 
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
          <!-- partial:partials/_sidebar.html -->
          <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                  <hr>
                    <h5 class='text-center'>Audit Team</h5>
                    <hr>
                </li>
              <li class="nav-item {{ Route::current()->getName() == "home" || "" ? "active" : "" }}"  >
                <a class="nav-link"  href="{{url('/')}}" onclick='show()'>
                  <i class="icon-grid menu-icon"></i>
                  <span class="menu-title">Dashboard </span>
                </a>
              </li>
              <li class="nav-item {{ Route::current()->getName() == "Audit" || "" ? "active" : "" }}"  >
                <a class="nav-link"  href="{{url('/calendar')}}" onclick='show()'>
                  <i class="icon-ribbon menu-icon"></i>
                  <span class="menu-title">Audit Calendar </span>
                </a>
              </li>
              <li class="nav-item {{ Route::current()->getName() == "findings" || "" ? "active" : "" }}">
                <a class="nav-link" data-toggle="collapse" href="#findings" aria-expanded="{{ Route::current()->getName() == "findings" || "" ? "true" : "" }}" aria-controls="ui-basic">
                    <i class="icon-contract  menu-icon"></i>
                    <span class="menu-title">Findings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse {{ Route::current()->getName() == "findings" || "" ? "show" : "" }}" id='findings'>
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/engagements') }}">Engagements</a></li>
                        
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/findings') }}">Findings</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/closed') }}">Closed</a></li>
                    </ul>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#masterfiles" aria-expanded="false" aria-controls="ui-basic">
                    <i class="icon-clipboard menu-icon"></i>
                    <span class="menu-title">Action Plans</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="masterfiles">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/action-plans') }}" onclick='show();'>Action Plans</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/closed-action-plans') }}" onclick='show();'>Closed</a>
                        </li>
                    </ul>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#payroll" aria-expanded="false" aria-controls="ui-basic">
                    <i class="icon-book menu-icon"></i>
                    <span class="menu-title">Reports</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="payroll">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/payrolls') }}" onclick='show();'>Payrolls</a>
                        </li>
                    </ul>
                </div>
              </li>
              <li class="nav-item {{ Route::current()->getName() == "Settings" || "" ? "active" : "" }}">
                <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="{{ Route::current()->getName() == "settings" || "" ? "true" : "" }}" aria-controls="ui-basic">
                    <i class="icon-cog  menu-icon"></i>
                    <span class="menu-title">Settings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse {{ Route::current()->getName() == "settings" || "" ? "show" : "" }}" id='settings'>
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/matrices') }}">Matrices</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/companies') }}">Companies</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/departments') }}">Departments</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/users') }}">Users</a></li>
                    </ul>
                </div>
              </li>

              <li class="nav-item">
                    
                <hr>
                <h5 class='text-center'>Business Process</h5>
                <hr>
            </li>

            </ul>
          </nav>
          <!-- partial -->
          @yield('content')
          <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
      </div>
     
      @include('sweetalert::alert')    
    <script>
        function logout() {
			event.preventDefault();
			document.getElementById('logout-form').submit();
		}    
    function show() {
			document.getElementById("loader").style.display = "block";
		}
    </script>
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>
    <!-- endinject -->
    @yield('js')
</body>
</html>
