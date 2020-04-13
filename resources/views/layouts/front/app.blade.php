<!doctype html>
<html lang="{{ app()->getLocale() }}" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ (!empty(config('app.name')) ? config('app.name') : 'DarkCrown Dashboard').(!empty($second_title) ? ' - '.$second_title : '') }}</title>
    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/front/favicon.ico')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/front/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/front/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/front/fontawesome-all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/front/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/front/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/front/style.css')}}">
    
    
    @yield('plugins_css')

    @yield('inline_css')

</head>
<body>
@include('layouts.front.navbar')
<main>
@yield('content_body')
</main>

<script src="{{ asset('js/front/vendor/modernizr-3.5.0.min.js') }}"></script>
<script src="{{ asset('js/front/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('js/front/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/front/jquery.slicknav.min.js') }}"></script>
<script src="{{ asset('js/front/slick.min.js') }}"></script>
<script src="{{ asset('js/front/gijgo.min.js') }}"></script>
<script src="{{ asset('js/front/jquery.scrollUp.min.js') }}"></script>
<script src="{{ asset('js/front/jquery.sticky.js') }}"></script>
<script src="{{ asset('js/front/main.js') }}"></script>

@yield('plugins_js')
@yield('inline_js')
</body>
</html>
