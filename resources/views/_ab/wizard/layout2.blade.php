<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Financtics</title>
    @yield('title')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <!-- Icon Font Styles -->
    <link href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">
    @yield('fonts')

    <!-- Styles -->
    <link href="{{ asset('public/vali css/main.css') }}" rel="stylesheet">
    @include('include/head')
    @yield('style')
</head>
<body class="app sidebar-mini rtl">

    <div id="app">
        <header class="app-header"></header>
        <main class="py-4 app-content">
            @include('inc._messages')
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>
    <script src="{{ asset('public/vali js/popper.min.js') }}"></script>
    <script src="{{ asset('public/vali js/bootstrap.min.js') }}"></script>

    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('public/vali js/pace.min.js') }}"></script>

    {{--@include('include/script')--}}
    @yield('script')

</body>
</html>
