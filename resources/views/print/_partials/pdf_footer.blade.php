
<!DOCTYPE HTML>
<html>
<head>

{{--    <link rel="stylesheet" href='{{asset("public/vendors/styles/print.css")}}' media="screen, print">--}}
<style>


    .pwrd_cmpny,
    .clnt_cmpny,
    #content{
        display: block;
        position: relative;
        float: left;
        font-size: 12px;
    }

    .pwrd_cmpny,
    .clnt_cmpny{
        width: 50%;
    }

    .clnt_cmpny{
        text-align: left;
    }

    .pwrd_cmpny{
        text-align: right;
    }

    #content {
        display: table;
        /*width: 10%;*/
        text-align: center;
    }

    .invoice_para {
        padding: 0 0 0;
        font-size: 12px;
    }

    .pt-0,
    .py-0 {
        padding-top: 0 !important;
    }

    .m-0 {
        margin: 0 !important;
    }
</style>
</head>
<body>


@php
    $company_info = \Illuminate\Support\Facades\Session::get('company_info');
@endphp

<footer class="page-footer">
    <div class="clnt_cmpny">
        &copy; {{date('Y', strtotime(str_replace('/', '-', \Carbon\Carbon::now()->year )))}}
        {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_name : 'N/A'}} | All rights reserved.
    </div>
    <div id="content">
        <div id="pageFooter"></div>
    </div>
    <div class="pwrd_cmpny">
        Designed & Developed by softagics.com
        <p class="invoice_para m-0 pt-0">
            <b> Date: </b>
            {{date('d-M-y H:i:s A', strtotime(str_replace('/', '-', \Carbon\Carbon::now()->toDateTimeString() )))}}
        </p>
    </div>
</footer>

</body>
</html>
