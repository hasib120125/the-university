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
        <link rel="stylesheet" href="{{ asset('themes/student/css/plugin/font/fonts.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/student/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/student/css/plugin/font-awesome/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/student/fonts/stylesheet.css') }}">
        <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('themes/student/css/main.css') }}">
    </head>

    <body>
        <div id="app">
            <router-view></router-view>
        </div>
        <script src="{{ route('locale') }}" defer></script>
        <script src="https://cdn.jwplayer.com/libraries/zyp9qU0T.js" defer></script>
        <script src="{{ asset('themes/student/js/vendor/jquery-3.5.1.js') }}" defer></script>
        <script src="{{ asset('themes/student/js/plugin/jquery-ui/jquery-ui.js') }}" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" defer></script>
        <script src="{{ asset('themes/student/js/vendor/bootstrap.js') }}" defer></script>
        <script src="{{ mix('js/student.js') }}" defer></script>
        <script src="{{ asset('themes/student/js/main.js') }}" defer></script>
    </body>
</html>
