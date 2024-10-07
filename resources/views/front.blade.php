<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }}</title>

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/themes/front/css/bootstrap.css') }}" >
    <link rel="stylesheet" href="{{ asset('/themes/front/css/plugin/font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/front/css/plugin/font-awesome/fontawesome.css') }}" >
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('themes/front/fonts/stylesheet.css') }}" >
    <link rel="stylesheet" href="{{ asset('themes/front/css/plugin/slick/slick.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css">
    <link rel="stylesheet" href="{{ mix('themes/front/css/main.css') }}">
</head>
<body>
<!-- PRELOADER -->
<div id="preloader">
    <div id="preloader_inner"></div>
</div>

<div id="app">
    <app></app>
</div>

<script src="{{ route('locale') }}" defer></script>
<script src="{{ asset('themes/front/js/vendor/jquery-3.5.1.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous" defer></script>
<script src="{{ asset('themes/front/js/vendor/bootstrap.js') }}" defer></script>
<script src="{{ asset('themes/front/js/plugin/jquery-ui/jquery-ui.js') }}" defer></script>
<script src="{{ asset('themes/front/js/plugin/slick/slick.js') }}" defer></script>
<script src="https://cdn.jwplayer.com/libraries/10IA4ClV.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js" defer></script>
<script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" defer></script>
<script src="{{ mix('js/front.js') }}" defer></script>
<script src="{{ asset('themes/front/js/main.js') }}" defer></script>

</body>
</html>
