<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @production
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endproduction

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('themes/admin/css/plugin/font/fonts.css') }}">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('themes/admin/fonts/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ mix('themes/admin/css/main.css') }}">
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>

<script src="{{ route('locale') }}"></script>
<script src="https://cdn.jwplayer.com/libraries/zyp9qU0T.js"></script>
<script src="{{ asset('themes/admin/js/vendor/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('themes/admin/js/plugin/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('themes/admin/js/leftnav.js') }}"></script>
<script src="{{ asset('themes/admin/js/main.js') }}"></script>
<script src="{{ mix('js/professor.js') }}"></script>
</body>
</html>
