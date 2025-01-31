<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('include.head')

</head>

<body>

    @include('include/header')
    @include('include.sidebar')

    <div class="main-container">
        <div class="pd-ltr-20 customscroll-10-p xs-pd-20-10">
            @include('inc._messages')


            <div id="app">
                @yield('content')
            </div>


            @include('include/footer')
        </div>
    </div>

    @include('include/script')

</body>

</html>
