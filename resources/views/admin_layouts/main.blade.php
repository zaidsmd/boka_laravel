<!doctype html>
<html lang="ar" dir="rtl">
<meta name="csrf-token" content="{{ csrf_token() }}">

<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    <!-- Bootstrap Css -->
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app-rtl.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/metrojs/release/MetroJs.Full/MetroJs.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/libs/dropzone/min/dropzone.min.css')}}"  type="text/css" />


    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <style>
        .required::after {
            content: " *";
            color: red;
        }
    </style>
    @stack('css')

</head>

<body data-topbar="dark">

<!-- Begin page -->
<div id="layout-wrapper">


    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex justify-content-between " style="width: 100%">
                <div class="">
                    <button type="button" class="btn btn-sm  font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>

                <div class="d-flex" >
                    <!-- User -->
                    <div class="dropdown d-inline-block">
                        <button  type="button" class="btn header-item waves-effect user-step" id="page-header-user-dropdown"
                                 data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/user-1.jpg')}}"
                                 alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1">
{{--                                {{Auth::user()->name}}--}}
                            </span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-start" style="background-color: #fff; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">

                            <!-- Divider -->

                            <!-- Logout Form -->
                            <form action="{{ route('auth.logout') }}" method="POST" style="padding: 10px;">
                                @csrf
                                <button type="submit" class="btn btn-danger">{{__('lang.logout')}}</button>
                            </form>

                        </div>

                    </div>



                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                             aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                               aria-label="Recipient's username">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    <!-- full-screen -->
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="mdi mdi-fullscreen"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">


{{--                    @if(Auth::user()->role === '1')--}}

                        <li>
                            <a href="{{ route('articles.liste') }}" class="waves-effect">
                                <i class="mdi mdi-view-dashboard-variant"></i>
                                <span>المنتجات</span>
                            </a>
                        </li>
                    <li>
                            <a href="{{ route('categories.liste') }}" class="waves-effect">
                                <i class="mdi mdi-view-dashboard-variant"></i>
                                <span>الفئات</span>
                            </a>
                        </li>

                    <li>
                        <a href="{{ route('utilisateurs.liste') }}" class="waves-effect">
                            <i class="mdi mdi-view-dashboard-variant"></i>
                            <span>المستخدمين</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                    @yield('section')
            </div>


        </div>
        <div class="rightbar-overlay"></div>


        <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>

        <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>


{{--        <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>--}}

        <script src="{{ asset('libs/morris.js/morris.min.js') }}"></script>
        <script src="{{ asset('libs/raphael/raphael.min.js') }}"></script>
        <script src="{{ asset('libs/jquery-knob/jquery.knob.min.js') }}"></script>
        <script src="{{ asset('libs/metrojs/release/MetroJs.Full/MetroJs.min.js') }}"></script>

        <script src="{{asset('assets/libs/dropzone/min/dropzone.min.js')}}"></script>
        <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>

        <script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/sweet-alerts.init.js') }}"></script>

        <script src="{{ asset('libs/tippy.js/tippy.all.min.js') }}"></script>

        <script src="{{ asset('assets/js/pages/tooltipster.init.js') }}"></script>
        <script src="{{ asset('assets/js/pages/materialdesign.init.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>

        <script>
            const __csrf_token = '{{csrf_token()}}'
        </script>

@yield('scripts')
@yield('javascript')
@stack('scripts')

@vite(['resources/js/admin.js'])

</body>
</html>
