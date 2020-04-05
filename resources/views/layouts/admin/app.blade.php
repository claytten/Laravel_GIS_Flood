<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- <link rel="icon" type="image/png" href="images/DB_16х16.png"> -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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


    <!-- Tile icon for Win8 (144x144 + tile color) -->
    {{-- <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF"> --}}

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
   
    -->

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,300,100,700,900' rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/lib/getmdl-select.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/lib/nv.d3.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/application.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/alert.css')}}">
    <!-- endinject -->
    @yield('plugins_css')

    @yield('inline_css')

</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header is-small-screen">
    @include('layouts.admin.navbar')
    @include('layouts.admin.sidebar')
    

    <main class="mdl-layout__content">

        <div class="mdl-grid mdl-grid--no-spacing dashboard">
            @if(Auth::guard('employee')->user()->email_verified_at == null)
            <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
                <div class="mdl-card mdl-shadow--2dp verification">
                    <div class="mdl-card__text ">
                        <h6 class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone">
                            Please check your email to verify, or 
                            <button onclick="resend_link()" 
                            class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-light-blue"
                            style="margin: 0 10px">
                                Click Here
                            </button>
                             to resend verification mail.
                        </h6>
                    </div>
                </div>
            </div>
            @endif
            
            @yield('content_alert')
            @yield('content_header')
            @yield('content_body')
        </div>

    </main>

</div>

<!-- inject:js -->
<script src="{{asset('js/d3.min.js')}}"></script>
<script src="{{asset('js/getmdl-select.min.js')}}"></script>
<script src="{{asset('js/material.min.js')}}"></script>
<script src="{{asset('js/layout/layout.min.js')}}"></script>
<script src="{{asset('js/scroll/scroll.min.js')}}"></script>
<script src="{{asset('js/widgets/charts/discreteBarChart.min.js')}}"></script>
<script src="{{asset('js/widgets/charts/stackedBarChart.min.js')}}"></script>
<script src="{{asset('js/widgets/employer-form/employer-form.min.js')}}"></script>
<script src="{{asset('js/widgets/map/maps.min.js')}}"></script>
<script src="{{asset('js/widgets/table/table.min.js')}}"></script>
<script src="{{asset('js/widgets/todo/todo.min.js')}}"></script>
<!-- endinject -->

{{-- third party js --}}
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
@yield('plugins_js')
@yield('inline_js')

<script>
    function removeAlert() {
        $('#alert-section').empty();
    }
    $.ajaxSetup({ 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    function resend_link(){
        //Resend email verify code via ajax
        $("#progress_alert").slideDown('slow', 'swing');
        $(".alert-result").slideUp(function(){
            $(this).remove();
        });

        $.ajax({
            method: "GET",
            url: "{{ url('/email/resend') }}",
            success: function(result){
                console.log(result);
                $("#progress_alert").slideUp('slow', 'swing');
                $('<div class="alert alert-result alert-'+result.status+' alert-dismissible fade show mb-0" role="alert"><span>'+result.message+'</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').appendTo($("#alert_section")).slideDown('slow', 'swing');
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                console.log(jqXHR);
                $("#progress_alert").slideUp('slow', 'swing');
                $('<div class="alert alert-result alert-danger alert-dismissible fade show mb-0" role="alert"><span>Something went wrong, please contact your network administration<br/>'+jqXHR.responseJSON['message']+'</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').appendTo($("#alert_section")).slideDown('slow', 'swing');
            }
        });
    }
</script>
</body>
</html>
