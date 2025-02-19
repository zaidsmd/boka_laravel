<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{asset('images/logo.png')}}" sizes="32x32">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name')}} | @yield('document-title')</title>
    <link rel="stylesheet" href="{{asset('libs/notyf/notyf.min.css')}}">
    @vite(['resources/css/app.scss'])
    @stack('styles')

    <script src="{{asset('js/jquery/jquery-3.7.1.min.js')}}"></script>
    {!! RecaptchaV3::initJs() !!}
</head>
<body class="bg-body-tertiary min-vh-100 d-flex flex-column">
@include('layouts.nav-bar')
<div class="container py-4">
    @yield('page')
</div>
<a href="https://wa.me/+212665252245" class="whatsapp-button" target="_blank">
    <img src="{{asset('images/WhatsApp_icon.png')}}" alt="WhatsApp" />
</a>
<div class="bg-white position-fixed top-0 bottom-0 start-0 end-0 w-100 h-100 search-container " style="z-index: 999;display: none">
    <div class=" position-absolute top-50 start-0 fa-3x text-primary cursor-pointer search-close z-3" style="margin-left: 1rem; transform: translateY(-50%)"><i class="fa fa-times"></i></div>
    <div class="d-flex align-items-center justify-content-center h-100" style=" transform: translateY(-1rem)">
        <form action="" id="global-search-form" >
            <input  placeholder="ابحث عن المنتجات ..." class="border-0 " style="font-size: 3rem;outline: none" type="search" value="">
        </form>
    </div>
</div>
@include('layouts.footer')
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/fontawesome.js')}}"></script>
<script src="{{asset('libs/notyf/notyf.min.js')}}"></script>
<script>
    const notyf = new Notyf();
    @if(session()->has('success'))
        notyf.success("{{session()->get('success')}}")
    @endif
    @if(session()->has('danger'))
    notyf.error("{{session()->get('danger')}}")
    @endif
    @if(session()->has('warning'))
    notyf.error("{{session()->get('warning')}}")
    @endif
</script>
@vite(['resources/js/app.js'])
@stack('scripts')
</body>
</html>
