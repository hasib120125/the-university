<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @production
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endproduction

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <title>{{ config('app.name') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('themes/admin/css/plugin/font/fonts.css') }}">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('themes/admin/fonts/stylesheet.css') }}" >
    <link rel="stylesheet" href="{{ mix('themes/admin/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/github.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>

<script src="{{ route('locale') }}" defer></script>
<script src="https://cdn.jwplayer.com/libraries/zyp9qU0T.js" defer></script>
<script src="{{ asset('themes/admin/js/vendor/jquery-3.5.1.js') }}" defer></script>
<script src="{{ asset('themes/admin/js/plugin/jquery-ui/jquery-ui.js') }}" defer></script>
<script src="{{ asset('themes/admin/js/leftnav.js') }}" defer></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js" defer></script>
<script charset="UTF-8" src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/languages/xml.min.js"></script>-->
<script src="{{ mix('js/admin.js') }}" defer></script>
<script src="{{ asset('themes/admin/js/main.js') }}" defer></script>
</body>
</html>
