<!DOCTYPE html>
<html>
<head>
    @include('include/head')
</head>
<body>
@include('include/header')
@include('include.sidebar_shahzaib')




<div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
        @include('inc._messages')

        <a href="close_day_end"><button>Run Day End</button></a>

        @include('include/footer')

    </div>
</div>
@include('include/script')


</body>
</html>
