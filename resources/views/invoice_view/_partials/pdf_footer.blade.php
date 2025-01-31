<!DOCTYPE HTML>
<html>
<head>

    <link rel="stylesheet" href="{{asset('public/vendors/styles/print.css')}}" media="screen, print">
    <style>
        * {
            font-family: 'Exo', sans-serif;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 12px;
        }

        .table thead {
            background-color: #33A6D4 !important;
            color: #fff;
        }

        .table th {
            font-weight: 600;
        }

        .table td, .table th {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        h3 {
            padding: 5px;
            font-size: 14px;
            line-height: 14px;
            font-weight: bolder;
            background: #33A6D4;
            color: #fff;
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
