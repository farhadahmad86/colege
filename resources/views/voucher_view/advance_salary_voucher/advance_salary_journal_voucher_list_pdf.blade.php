
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



<div id="" class="table-responsive" style="z-index: 9;">

    <table class="table table-bordered table-sm">
        <tr>
            <td colspan="3">
                <img src="{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_logo : 'N/A'}}" alt="Company Logo" width="140" />
                <p class="invoice_para adrs m-0">
                    <b> Adrs:- </b>
                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_address : 'N/A'}}
                </p>
                <p class="invoice_para m-0 pt-5">
                    <b> Mob #:- </b>
                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_mobile_numer : 'N/A'}}
                </p>
            </td>
            <td colspan="3" class="text-right">
                <h2 class="invoice_hdng">
                    Advance Salary JV
                </h2>
                <p class="invoice_para m-0">
                    <b> ASV #: </b>
                    {{ $adv_sal->as_id }}
                </p>
                <p class="invoice_para m-0 pt-5">
                    <b> Date: </b>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $adv_sal->as_day_end_date)))}}
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <p class="invoice_para pt-5 mt-0 mb-10">
                    <b> Remarks: </b>
                    {{ $adv_sal->as_remarks }}
                </p>
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-sm" id="">
        <thead>
        <tr class="headings vi_tbl_hdng">
            <th scope="col" class="v_wdth_1 text-center ">Sr.</th>
            <th scope="col" class="v_wdth_2 text-center ">Account No.</th>
            <th scope="col" class="v_wdth_3 text-left">Account Name</th>
            <th scope="col" class="v_wdth_4 text-left">Detail Remarks</th>
            <th scope="col" class="v_wdth_5 text-center">Dr.</th>
            <th scope="col" class="v_wdth_5 text-center">Cr.</th>
        </tr>
        </thead>

        <tbody>
        @php
            $i = $dr_val = $cr_cal = 0;
            $dr_val = $adv_sal->as_amount;
            $cr_val = $adv_sal->as_amount;
        @endphp
        @php $i = 1; $grand_total = $ttl_dr = $ttl_cr = $adv_amnt = $adv_amnt_deduct = $ttl_paid = 0; $vchr_id = ''; @endphp
        @foreach( $items as $item )
            @php $vchr_id = $item->asi_as_id; @endphp
            <tr class="even pointer">
                <td class="v_wdth_1 align_center text-center">
                    {{ $i }}
                </td>

                <td class="v_wdth_2 align_center text-center">
                    {{ $item->asi_emp_advance_salary_account }}
                </td>

                <td class="v_wdth_3 align_left text-left">
                    {{ $item->asi_emp_advance_salary_account_name }}
                    {{--                    {{ $usr_rcvd }}--}}
                </td>

                <td class="v_wdth_4 align_left text-left">
                    {!! $item->asi_remarks !!}
                </td>

                {{--                <td class="v_wdth_5 align_right text-right">--}}
                {{--                    {{ (!empty($dr_val)) ? number_format($dr_val,2) : ""  }}--}}
                {{--                </td>--}}

                <td class="text-right tbl_amnt_15">
                    @php
                        $DR_val = ($vchr_id === $item->asi_as_id) ? $item->asi_amount : "";
                        $DR = (!empty($DR_val)) ? $DR_val : "0";
                        $grand_total = +(+$grand_total + +$DR);
                    @endphp
                    {{ (!empty($grand_total)) ? number_format($DR_val,2) : ""  }}
                </td>

                <td class="v_wdth_5 align_right text-right">

                </td>
            </tr>

            @php $i++; @endphp
        @endforeach
        <tr class="even pointer">
            <td class="v_wdth_1 align_center text-center">
                {{ $i }}
            </td>
            <td class="v_wdth_2 align_center text-center">
                {{ $adv_sal->as_from_pay_account }}
            </td>
            <td class="v_wdth_3 align_left text-left">
                {{ $usr_snd }}
            </td>
            <td class="v_wdth_4 align_left text-left">
                {!! $adv_sal->as_remarks !!}
            </td>
            <td class="v_wdth_5 align_right text-right">

            </td>
            <td class="v_wdth_5 align_right text-right">
                {{ (!empty($cr_val)) ? number_format($cr_val,2) : "" }}
            </td>
        </tr>


        </tbody>
        <tfoot>
        <tr class="border-0">
            <th colspan="4" align="right" class="border-0 pt-0 text-right align_right">
                Grand Total:
            </th>
            <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($grand_total,2) }}
            </td>
            <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($cr_val,2) }}
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
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="border-0 p-0">
                <div class="sign_con">

                    <div class="sign_bx">
                        <span class="sign_itm">
                            Prepared By
                        </span>
                    </div>

                    <div class="sign_bx">
                        <span class="sign_itm">
                            Checked By
                        </span>
                    </div>

                    <div class="sign_bx">
                        <span class="sign_itm">
                            Accounts Manager
                        </span>
                    </div>

                    <div class="sign_bx">
                        <span class="sign_itm">
                            Chief Executive
                        </span>
                    </div>

                </div>
            </td>
        </tfoot>

    </table>
    {{--    <table class="table table-bordered table-sm">--}}
    {{--        <thead>--}}
    {{--            <tr class="headings vi_tbl_hdng">--}}
    {{--                <th scope="col"class="v_wdth_1 text-center">Sr.</th>--}}
    {{--                <th scope="col"class="v_wdth_2 text-center">Acc No.</th>--}}
    {{--                <th scope="col"class="v_wdth_3 text-left">Account Name</th>--}}
    {{--                <th scope="col"class="v_wdth_4 text-left">Detail Remarks</th>--}}
    {{--                <th scope="col"class="v_wdth_5 text-center">Dr.</th>--}}
    {{--                <th scope="col"class="v_wdth_5 text-center">Cr.</th>--}}
    {{--            </tr>--}}
    {{--        </thead>--}}

    {{--        <tbody>--}}
    {{--            @php--}}
    {{--                $i = $dr_val = $cr_cal = 0;--}}
    {{--                $dr_val = $adv_sal->as_amount;--}}
    {{--                $cr_val = $adv_sal->as_amount;--}}
    {{--            @endphp--}}

    {{--            <tr class="even pointer">--}}
    {{--                <td class="v_wdth_1 align_center text-center">--}}
    {{--                    {{ $i }}--}}
    {{--                </td>--}}

    {{--                <td class="v_wdth_2 align_center text-center">--}}
    {{--                    {{ $adv_sal->as_emp_advance_salary_account }}--}}
    {{--                </td>--}}

    {{--                <td class="v_wdth_3 align_left text-left">--}}
    {{--                    {{ $usr_rcvd }}--}}
    {{--                </td>--}}

    {{--                <td class="v_wdth_4 align_left text-left">--}}
    {{--                    {!! $adv_sal->as_remarks !!}--}}
    {{--                </td>--}}

    {{--                <td class="v_wdth_5 align_right text-right">--}}
    {{--                    {{ (!empty($dr_val)) ? number_format($dr_val,2) : ""  }}--}}
    {{--                </td>--}}

    {{--                <td class="v_wdth_5 align_right text-right">--}}

    {{--                </td>--}}
    {{--            </tr>--}}

    {{--            @php $i++; @endphp--}}

    {{--            <tr class="even pointer">--}}
    {{--                <td class="v_wdth_1 align_center text-center">--}}
    {{--                    {{ $i }}--}}
    {{--                </td>--}}
    {{--                <td class="v_wdth_2 align_center text-center">--}}
    {{--                    {{ $adv_sal->as_from_pay_account }}--}}
    {{--                </td>--}}
    {{--                <td class="v_wdth_3 align_left text-left">--}}
    {{--                    {{ $usr_snd }}--}}
    {{--                </td>--}}
    {{--                <td class="v_wdth_4 align_left text-left">--}}
    {{--                    {!! $adv_sal->as_remarks !!}--}}
    {{--                </td>--}}
    {{--                <td class="v_wdth_5 align_right text-right">--}}

    {{--                </td>--}}
    {{--                <td class="v_wdth_5 align_right text-right">--}}
    {{--                    {{ (!empty($cr_val)) ? number_format($cr_val,2) : "" }}--}}
    {{--                </td>--}}
    {{--            </tr>--}}


    {{--        </tbody>--}}

    {{--        <tfoot>--}}
    {{--        <tr class="border-0">--}}
    {{--            <th colspan="4" align="right" class="border-0 text-right align_right">--}}
    {{--                Grand Total:--}}
    {{--            </th>--}}
    {{--            <td class="text-right border-bottom-3 border-top-2 border-left-0" align="right">--}}
    {{--                {{ number_format($dr_val,2) }}--}}
    {{--            </td>--}}
    {{--            <td class="text-right border-bottom-3 border-top-2 border-left-0" align="right">--}}
    {{--                {{ number_format($cr_val,2) }}--}}
    {{--            </td>--}}
    {{--        </tr>--}}
    {{--        <tr>--}}
    {{--            <td colspan="6" class="border-0 p-0">--}}
    {{--                <div class="wrds_con">--}}
    {{--                    <div class="wrds_bx">--}}
    {{--                        <span class="wrds_hdng">--}}
    {{--                            In Words--}}
    {{--                        </span>--}}
    {{--                        {{ $nbrOfWrds }} only--}}
    {{--                    </div>--}}
    {{--                    <div class="wrds_bx wrds_bx_two">--}}
    {{--                        <span class="wrds_hdng">--}}
    {{--                            Receipient Sign.--}}
    {{--                        </span>--}}
    {{--                        &nbsp;--}}
    {{--                    </div>--}}
    {{--                    <div class="clearfix"></div>--}}
    {{--                </div>--}}
    {{--                <div class="clearfix"></div>--}}
    {{--            </td>--}}
    {{--        </tr>--}}
    {{--        <tr>--}}
    {{--            <td colspan="6" class="border-0 p-0">--}}
    {{--                <div class="sign_con">--}}

    {{--                    <div class="sign_bx">--}}
    {{--                        <span class="sign_itm">--}}
    {{--                            Prepared By--}}
    {{--                        </span>--}}
    {{--                        <div class="clearfix"></div>--}}
    {{--                    </div>--}}

    {{--                    <div class="sign_bx">--}}
    {{--                        <span class="sign_itm">--}}
    {{--Checked By--}}
    {{--                        </span>--}}
    {{--                        <div class="clearfix"></div>--}}
    {{--                    </div>--}}

    {{--                    <div class="sign_bx">--}}
    {{--                        <span class="sign_itm">Accounts Manager</span>--}}
    {{--                        <div class="clearfix"></div>--}}
    {{--                    </div>--}}

    {{--                    <div class="sign_bx">--}}
    {{--                        <span class="sign_itm">Chief Executive</span>--}}
    {{--                        <div class="clearfix"></div>--}}
    {{--                    </div>--}}
    {{--                    <div class="clearfix"></div>--}}

    {{--                </div>--}}
    {{--                <div class="clearfix"></div>--}}
    {{--            </td>--}}
    {{--        </tr>--}}


    {{--        </tfoot>--}}

    {{--    </table>--}}

    <div class="clearfix"></div>

</div>
<div class="input_bx_ftr"></div>
