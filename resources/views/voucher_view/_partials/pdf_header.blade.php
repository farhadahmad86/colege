@if($type !== 'grid')
<!DOCTYPE HTML>
<html>
<head>

    <link rel="stylesheet" href='{{asset("public/vendors/styles/print_main_style.css")}}' media="screen, print">

</head>
<body>

    <table class="table border-0 table-sm p-0">
@endif

        @php
            $company_info = \Illuminate\Support\Facades\Session::get('company_info');
        @endphp
        <tr class="bg-transparent">
            <td class="wdth_50_prcnt p-0 border-0">
                <img src="{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_logo : 'N/A'}}" alt="Company Logo" width="55" class="m-0 p-0" />
                <p class="invoice_para m-0 pt-0">
                    <b> {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_name : 'N/A'}} </b>
                </p>
                <p class="invoice_para adrs m-0">
                    <b> Adrs: </b>
                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_address : 'No Company Record'}}
                </p>
                <p class="invoice_para pt-0 mt-0 mb-0">
                    <b> Remarks: </b>
                    {{ $invoice_remarks }}
                </p>
            </td>
            <td class="wdth_50_prcnt p-0 border-0 text-right align_right">
                <h4 class="invoice_hdng p-0 mb-0">
                    {{ (isset($pge_title) && !empty($pge_title)) ? $pge_title : 'N/A' }}
                </h4>
                <p class="invoice_para m-0 pt-0">
                    <b> Voucher #: </b>
                    {{ $invoice_nbr }}
                </p>
                <p class="invoice_para m-0 pt-0">
                    <b> Date: </b>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice_date)))}}
                </p>
                <p class="invoice_para m-0 pt-0">
                    <b> Email: </b>
                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_email : 'N/A'}}
                </p>
                @if(isset($slry_slp) && !empty($slry_slp))
                    <p class="invoice_para m-0 pt-0">
                        <b> For the Month of: </b>
                        {{(isset($slry_slp) || !empty($slry_slp)) ? $slry_slp->gss_month : 'No Month Found'}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b> Attendance {{ (isset($slry_slp->ss_calculate_attended) && !empty($slry_slp->ss_calculate_attended) && $slry_slp->ss_calculate_attended === 1 ) ? 'Days' : 'Hours' }}: </b>
                        {{ (isset($slry_slp->ss_calculate_attended) && !empty($slry_slp->ss_calculate_attended) && $slry_slp->ss_calculate_attended === 1 ) ? $slry_slp->ss_attended_days : $slry_slp->ss_attended_hours }}
                    </p>
                @else
                    <p class="invoice_para m-0 pt-0">
                        <b> Mob #: </b>
                        {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_mobile_numer : 'No Company Record'}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b> WhatsApp #: </b>
                        {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_whatsapp_number : 'N/A'}}
                    </p>
                @endif
            </td>
        </tr>

@if($type !== 'grid')
    </table>


</body>
</html>
@endif
