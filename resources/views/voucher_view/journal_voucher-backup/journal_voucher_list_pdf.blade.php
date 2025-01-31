@php
    $company_info = Session::get('company_info');
@endphp

<style>
    blockquote {
        background: transparent;
        border-left: 2px solid rgba(204,204,204,.5);
        margin: 0em 0px;
        padding: .2em 4px;
        quotes: "\201C""\201D""\2018""\2019";
        position: relative;
    }


    .v_wdth_1{
        min-width: 5%;
        width: 5%;
        text-align: center;
    }

    .v_wdth_2{
        min-width: 16%;
        width: 16%;
        text-align: center;
    }

    .v_wdth_3{
        min-width: 30%;
        width: 30%;
        text-align: left;
    }

    .v_wdth_4{
        min-width: 25%;
        width: 25%;
        text-align: left;
    }

    .v_wdth_5{
        min-width: 12%;
        width: 12%;
        text-align: right;
    }

    .vi_tbl_hdng {
        background: #a5a5a5;
        color: #000;
    }

    .text-center{
        text-align: center;
    }
    .pts-10{
        padding-top: 10px !important;
    }

    .fontS-12{
        font-size: 12px !important;
    }

    .fontS-12 label{
        font-size: 10px !important;
    }

    .invoice_hdng{
        font-weight: bolder;
        font-size: 25px;
        margin: 0 !important;
        padding: 0 !important;
    }

    .invoice_para{
        padding: 0px 5px 0;
    }

    .invoice_sub_hdng{
        padding: 5px;
        font-size: 14px;
        font-weight: bolder;
        background: #a5a5a5;
        color: #000;
    }

    .vi_tbl_hdng {
        background: #a5a5a5;
        color: #000;
    }

    .text-center{
        text-align: center;
    }

    .border-0{
        border: 0px solid transparent !important;
    }

    .text-right{
        text-align: right !important;
    }

    .bg-transparent{
        background-color: transparent;
    }

    .m-0{
        margin: 0 !important;
    }

    .p-0{
        padding: 0 !important;
    }

    .pl-0{
        padding-left: 0px !important;
    }

    .pb-0{
        padding-bottom: 0px !important;
    }

    .pr-0{
        padding-right: 0px !important;
    }

    .pts-10 {
        padding-top: 10px !important;
    }

    .mt-0{
        margin-top: 0 !important;
    }

    .mt-10{
        margin-top: 10px !important;
    }

    .mb-10 {
        margin-bottom: 10px !important;
    }

    .mt-5{
        margin-top: 5px !important;
    }

    .valign-top{
        vertical-align: top;
    }

    .text-center{
        text-align: center;
    }

    .text-left{
        text-align: left;
    }

    .text-right{
        text-align: right;
    }

    .wrds_con {
        position: relative;
        border: 1px solid rgba(0,0,0,.3);
        margin: 30px 0;
        width: 100%;
        display: block;
        float: left;
        min-height: 45px;
        height: auto;
    }

    .wrds_bx {
        position: relative;
        padding: 10px 15px;
        width: 70%;
        display: block;
        float: left;
        border-right: 1px solid rgba(0,0,0,.3);
        text-transform: uppercase;
    }

    .wrds_bx.wrds_bx_two {
        width: 30%;
        float: right
    }

    .wrds_hdng {
        position: absolute;
        top: -10px;
        background-color: #fff;
        padding: 0 10px;
        left: 5px;
        font-weight: bold;
        text-transform: capitalize;
    }

    .wrds_bx.wrds_bx_two .wrds_hdng {
        left: 30%;
        margin: 0 auto;
    }

    .sign_con {
        position: relative;
        margin: 0px 0;
        width: 100%;
        float: left;
        text-align: center;
        display: block;
        min-height: 70px;
        height: auto;
    }

    .sign_bx {
        position: relative;
        padding: 30px 15px 0;
        width: 20%;
        display: inline-block;
        text-transform: uppercase;
        text-align: center;
    }

    .sign_itm {
        position: relative;
        padding: 0 10px;
        font-weight: bold;
        text-transform: capitalize;
        border-top: 2px solid;
        width: 90%;
        display: block;
        font-size: 12px;
    }

    .border-left-0{
        border-left: 0px solid transparent;
    }

    .border-top-0{
        border-top: 0px solid transparent;
    }

    .border-right-0{
        border-right: 0px solid transparent;
    }

    .max_txt {
        min-width: 250px;
        max-width: 250px;
        width: 100%;
        overflow: hidden;
        -ms-word-break: break-all;
        word-break: break-all;
    }

    .fontS-12 {
        font-size: 9px !important;
    }

    .fontS-12 label {
        font-size: 8px !important;
    }

    .clearfix{
        clear: both;
    }

    .border-bottom-3{
        border-bottom: 3px double #000 !important;
    }

    .border-top-2{
        border-top: 2px solid #000 !important;
    }


</style>


<div id="" class="table-responsive">

    <table class="table table-bordered table-sm">
        <tr>
            <td colspan="3" class="p-0 border-0">
                <img src="{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_logo : 'No Company Record'}}" alt="Company Logo" width="140" />
                <p class="invoice_para adrs m-0">
                    <b> Adrs:- </b>
                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_address : 'No Company Record'}} 
                </p>
                <p class="invoice_para m-0 pt-5">
                    <b> Mob #:- </b>
                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_mobile_numer : 'No Company Record'}} 
                </p>
            </td>
            <td colspan="3" class="p-0 border-0 text-right">
                <h2 class="invoice_hdng">
                    Journal Voucher 
                </h2>
                <p class="invoice_para m-0">
                    <b> JV #: </b>
                    {{ $jrnl->jv_id }} 
                </p>
                <p class="invoice_para m-0 pt-5">
                    <b> Date: </b>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $jrnl->jv_created_datetime)))}} 
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="p-0 border-0">
                <p class="invoice_para pt-5 mt-0 mb-10">
                    <b> Remarks: </b> 
                    {{ $jrnl->jv_remarks }} 
                </p>
            </td>
        </tr>
    </table>

<table class="table table-bordered table-sm">
    <thead>
    <tr class="headings">
        <th scope="col" class="v_wdth_1 text-center" >Sr.</th>
        <th scope="col" class="v_wdth_2 text-center" >Account No.</th>
        <th scope="col" class="v_wdth_3 text-left">Account Name</th>
        <th scope="col" class="v_wdth_4 text-left">Detail Remarks</th>
        <th scope="col" class="v_wdth_5 text-center">Dr.</th>
        <th scope="col" class="v_wdth_5 text-center">Cr.</th>
    </tr>
    </thead>

    <tbody>
    @php $i = 01; $grand_total = $ttl_dr = $ttl_cr = $adv_amnt = $adv_amnt_deduct = $ttl_paid = 0; @endphp
    @foreach( $items as $item )
        <tr class="even pointer">

            <td class="v_wdth_1 align_center text-center">
                {{ $i }}
            </td>

            <td class="v_wdth_2 align_center text-center">
                {{ $item->jvi_account_id }}
            </td>

            <td class="v_wdth_3 align_left text-left">
                {!! $item->jvi_account_name !!}
            </td>

            <td class="v_wdth_4 align_left text-left">
                {!! $item->jvi_remarks !!}
            </td>

            <td class="v_wdth_5 align_right text-right">
                @php
                    $DR_val = ($item->jvi_type === "Dr") ? $item->jvi_amount : "";
                    $DR = ($item->jvi_type === "Dr") ? $DR_val : "0";
                    $ttl_dr = +$ttl_dr + +$DR;
                @endphp
                {{ (!empty($DR_val)) ? number_format($DR_val,2) : '' }}
            </td>

            <td class="v_wdth_5 align_right text-right">
                @php
                    $CR_val = ($item->jvi_type === "Cr") ? $item->jvi_amount : "";
                    $CR = ($item->jvi_type === "Cr") ? $CR_val : "0";
                    $ttl_cr = +$ttl_cr + +$CR;
                @endphp
                {{ (!empty($CR_val)) ? number_format($CR_val,2) : '' }}
            </td>
        </tr>
        @php $i++; @endphp
    @endforeach


    </tbody>
    <tfoot>
    <tr class="border-0">
        <th colspan="4" align="right" class="border-0 text-right align_right">
            Grand Total:
        </th>
        <td class="text-right border-bottom-3 border-top-2 border-left-0" align="right">
            {{ number_format($ttl_dr,2) }}
        </td>
        <td class="text-right border-bottom-3 border-top-2 border-left-0" align="right">
            {{ number_format($ttl_cr,2) }}
        </td>
    </tr>
    <tr>
        <td colspan="6" class="border-0 p-0">
            <div class="wrds_con">
                <div class="wrds_bx">
                        <span class="wrds_hdng">
                            In Words
                        </span>
                    {{ $nbrOfWrds }} only
                </div>
                <div class="wrds_bx wrds_bx_two">
                        <span class="wrds_hdng">
                            Receipient Sign.
                        </span>
                    &nbsp;
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </td>
    </tr>
    <tr>
        <td colspan="6" class="border-0 p-0">
            <div class="sign_con">

                <div class="sign_bx">
                        <span class="sign_itm">
                            Prepared By
                        </span>
                    <div class="clearfix"></div>
                </div>

                <div class="sign_bx">
                        <span class="sign_itm">
Checked By
                        </span>
                    <div class="clearfix"></div>
                </div>

                <div class="sign_bx">
                    <span class="sign_itm">Accounts Manager</span>
                    <div class="clearfix"></div>
                </div>

                <div class="sign_bx">
                    <span class="sign_itm">Chief Executive</span>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>

            </div>
            <div class="clearfix"></div>
        </td>
    </tr>

    </tfoot>

</table>

<div class="clearfix"></div>

</div>
<div class="input_bx_ftr"></div>
