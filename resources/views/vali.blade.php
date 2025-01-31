<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description">
        <!-- Twitter meta-->
{{--        <meta property="twitter:card" content="summary_large_image">--}}
{{--        <meta property="twitter:site" content="@pratikborsadiya">--}}
{{--        <meta property="twitter:creator" content="@pratikborsadiya">--}}
{{--        <!-- Open Graph Meta-->--}}
{{--        <meta property="og:type" content="website">--}}
{{--        <meta property="og:site_name" content="Vali Admin">--}}
{{--        <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">--}}
{{--        <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">--}}
{{--        <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">--}}
{{--        <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">--}}

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Financtics</title>
        @yield('title')

        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
        <!-- Icon Font Styles -->

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}"
              rel="stylesheet">
        @yield('fonts')

        <!-- Styles -->

        <link href="{{ asset('public/vali css/main.css') }}" rel="stylesheet">
        @yield('style')
        @include('include/head')
    </head>
    <body class="app sidebar-mini rtl">
        <div id="app">

            <header class="app-header">
                @include('include/header')

            </header>

{{--            @if ($systm_config->sc_welcome_wizard['wizard_completed'] == 1)--}}
                @include('include.sidebar')
{{--            @endif--}}

            <main class="py-4 app-content">

                @include('inc._messages')

                @yield('content')
            </main>
        </div>

        <!-- Scripts -->
        {{--<script src="{{ asset('publis/js/app.js') }}" defer></script>--}}
        <!-- Essential javascripts for application to work-->
        <script src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>
        <script src="{{ asset('public/vali js/popper.min.js') }}"></script>
{{--        <script src="{{ asset('public/vali js/bootstrap.min.js') }}"></script>--}}
        <script src="{{ asset('public/vali js/main.js') }}"></script>

        <!-- The javascript plugin to display page loading on top-->
        <script src="{{ asset('public/vali js/pace.min.js') }}"></script>

        @include('include/script')
        @yield('script')

    </body>
</html>
