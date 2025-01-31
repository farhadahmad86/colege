
<!DOCTYPE HTML>
<html>
<head>

    <link rel="stylesheet" href='{{asset("public/vendors/styles/print.css")}}' media="screen, print">

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
