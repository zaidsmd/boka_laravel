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
</head>
<body class="bg-body-tertiary min-vh-100 d-flex flex-column">
@include('layouts.nav-bar')
<div class="container py-4">
    @yield('page')
</div>
<a href="https://wa.me/+212665252245" class="whatsapp-button" target="_blank">
    <img src="{{asset('images/WhatsApp_icon.png')}}" alt="WhatsApp" />
</a>
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
</script>
@vite(['resources/js/app.js'])
@stack('scripts')
</body>
</html>
