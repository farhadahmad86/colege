@if($type !== 'grid')
<!DOCTYPE HTML>
<html>
<head>

    <link rel="stylesheet" href="{{asset('public/vendors/styles/print_main_style.css')}}" media="screen, print" type="text/css">
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
<body style="margin-left: 20px">


@php
    $company_info = \Illuminate\Support\Facades\Session::get('company_info');
@endphp


    <table class="table border-0 table-sm p-0">
@endif


        <tr class="bg-transparent">
            <td class="wdth_50_prcnt p-0 border-0">
                <img src="{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_logo : 'N/A'}}" alt="Company Logo" width="55" class="m-0 p-0" />
{{--                <p class="invoice_para m-0 pt-0">--}}
{{--                    <b> {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_name : 'N/A'}} </b>--}}
{{--                </p>--}}
            </td>
            <td class="wdth_50_prcnt p-0 border-0 text-right align_right">
                <h4 class="invoice_hdng p-0 mb-0">
                    {{ (isset($pge_title) && !empty($pge_title)) ? $pge_title : 'N/A' }}
                </h4>
                <p class="invoice_para m-0 pt-0">
                    <b> Invoice #: </b>
                    {{ $invoice_nbr }}
                </p>
                <p class="invoice_para m-0 pt-0">
                    <b> Date: </b>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice_date)))}}
                </p>
            </td>
        </tr>

@if($type !== 'grid')
    </table>


</body>
</html>
@endif
