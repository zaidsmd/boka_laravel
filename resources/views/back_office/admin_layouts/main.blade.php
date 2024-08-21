<!doctype html>
<html lang="ar" dir="rtl">
<meta name="csrf-token" content="{{ csrf_token() }}">

<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app-rtl.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/metrojs/release/MetroJs.Full/MetroJs.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('libs/daterangepicker/css/daterangepicker.min.css')}}" rel="stylesheet">

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
            <div class="d-flex justify-content-between w-100 ">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="{{url('/')}}" class="logo ">
                    <span class="logo-sm">
                        <img src="{{asset('images/logo.png')}}" alt="" height="35">
                    </span>
                            <span class="logo-lg">
                        <img src="{{asset('images/logo.png')}}" alt="" height="35">
                    </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>

                <div class="d-flex" >
                    <!-- User -->
                    <div class="dropdown d-inline-block" >

                        <button  type="button" class="btn header-item waves-effect user-step" id="page-header-user-dropdown"
                                 data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
{{--                            <img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/user-1.jpg')}}"--}}
{{--                                 alt="Header Avatar">--}}
                            <span class="d-none d-xl-inline-block ms-1">
                                {{Auth::user()->first_name}}
                                {{Auth::user()->last_name}}
                            </span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-start" style="background-color: #fff; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">

                            <form action="{{ route('auth.logout') }}" method="POST" style="padding: 10px;">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">{{__('lang.logout')}}</button>
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


                    <li>
                        <a href="{{ route('tableau_de_bord.liste') }}" class="waves-effect">
                            <i class="mdi mdi-monitor-dashboard"></i>
                            <span>لوحة القيادة</span>
                        </a>
                    </li>                    <li>
                        <a href="{{ route('commandes.liste') }}" class="waves-effect">
                            <i class="mdi mdi-shopping"></i>
                            <span>الطلبات</span>
                        </a>
                    </li>
                        <li>
                            <a href="{{ route('articles.liste') }}" class="waves-effect">
                                <i class="mdi mdi-barcode"></i>
                                <span>المنتجات</span>
                            </a>
                        </li>
                    <li>
                            <a href="{{ route('categories.liste') }}" class="waves-effect">
                                <i class="mdi mdi-wallet"></i>
                                <span>الفئات</span>
                            </a>
                        </li>
                    <li>
                        <a href="{{ route('tags.liste') }}" class="waves-effect">
                            <i class="mdi mdi-cloud-tags"></i>
                            <span>الوسوم</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('utilisateurs.liste') }}" class="waves-effect">
                            <i class="mdi mdi-account-group"></i>
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
        <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
        <script src="{{asset('libs/moment/min/moment-with-locales.min.js')}}"></script>
        <script src="{{asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('libs/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js')}}"></script>
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

        <script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>
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
