
@php
    $company_info = Session::get('company_info');
@endphp

<style>
    .table tbody tr:nth-child(even) {
        /*background-color: rgba(0,0,0,.05);*/
    }
    *{
        font-family: Arial, sans-serif;
    }
    td{
        font-size: 12px;
    }
    th{
        font-size: 14px;
    }

    .table th, .table td {
        padding: .1rem .2rem;
        line-height: 17px;
        vertical-align: middle;
        font-size: 12px;
        cursor: pointer;
        border: 1px solid rgba(0,0,0,.3);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        /*background-color: #f2f2f2;*/
    }

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

    <table class="table table-sm m-0">

        @if($type === 'grid')
            @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])
        @endif

        <tr class="bg-transparent">
            <td class="wdth_50_prcnt p-0 border-0">
                <h3 class="invoice_sub_hdng mb-0">
                    Company Information
                </h3>
                <p class="invoice_para m-0 pt-0">
                    <b> Name: </b>
                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_name : 'N/A'}}
                </p>
                <p class="invoice_para adrs m-0 pt-0">
                    <b> Adrs: </b>
                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_address : 'N/A'}}
                </p>
                <p class="invoice_para m-0 pt-0">
                    <b> Mob #: </b>
                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_mobile_numer : 'N/A'}}
                </p>

            </td>

            <td class="wdth_50_prcnt p-0 border-0">
                <h3 class="invoice_sub_hdng mb-0 mt-0">
                    Created By
                </h3>
                <p class="invoice_para m-0 pt-0 fonti">
                    <b> Name: </b>
                    {{ (isset($pim->user_name) && !empty($pim->user_name)) ? $pim->user_name : 'N/A' }}
                </p>
                <p class="invoice_para m-0 pt-0 fonti">
                    <b> Remarks: </b>
                    {{ $pim->fpr_remarks }}
                </p>
                                    <p class="invoice_para adrs m-0 pt-0">

                                    </p>
                {{--                    <p class="invoice_para m-0 pt-0">--}}
                {{--                        <b> Mob #: </b>--}}
                {{--                        {{ (isset($accnts->account_mobile_no) && !empty($accnts->account_mobile_no) ? $accnts->account_mobile_no : 'N/A') }}--}}
                {{--                    </p>--}}
                {{--                    <p class="invoice_para m-0 pt-0 mb-10">--}}
                {{--                        <b> NTN #: </b>--}}
                {{--                        {{ (isset($accnts->account_ntn) && !empty($accnts->account_ntn) ? $accnts->account_ntn : 'N/A') }}--}}
                {{--                    </p>--}}
            </td>
        </tr>

    </table>


    <table class="table table-bordered table-sm">
        <thead>
        <tr class="headings vi_tbl_hdng">
            <th scope="col" align="center" class="tbl_srl_6 text-center align_center fonti">
                Sr.
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_25 fonti">
                Product Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_6 fonti">
                Qunatity
            </th>
            <th class="align_center text-center tbl_amnt_8 fonti">
                Que Qty
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_6 fonti">
                UOM
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_6 fonti">
                Scale Size
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_13 fonti">
                Remarks
            </th>
            {{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_6 fonti">--}}
            {{--                    Warehouse--}}
            {{--                </th>--}}

        </tr>

        </thead>

        <tbody>
        @foreach( $piims as $piim )

            <tr class="even pointer">

                <td class="align_center text-center tbl_srl_6">
                    {{ $piim->fpri_id }}
                </td>

                <td class="align_center text-center tbl_amnt_6">
                    {{ $piim->fpri_product_name }}
                </td>
                <td class="align_center text-center tbl_amnt_8">
                    {{ $piim->fpri_qty }}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{ $piim->fpri_due_qty }}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{ $piim->fpri_uom }}
                </td>
                <td class="align_right text-right tbl_amnt_13">
                    {{ $piim->fpri_scale_size	}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{ $piim->fpri_remarks	 }}
                </td>
                {{--                    <td class="align_center text-center tbl_amnt_8">--}}
                {{--                        {{ $piim->fpri_warehouse_id	 }}--}}
                {{--                    </td>--}}


            </tr>
        @endforeach
        {{--            <tr>--}}
        {{--                <th colspan="2" class="text-right align_right">--}}
        {{--                    Total:---}}
        {{--                </th>--}}
        {{--                <td class="text-center align_right">--}}
        {{--                    {{ number_format($pim->pri_total_items,3) }}--}}
        {{--                </td>--}}
        {{--                <td class="text-center align_center">--}}
        {{--                </td>--}}
        {{--                <td class="text-center align_center">--}}
        {{--                </td>--}}
        {{--                <td class="text-center align_center">--}}
        {{--                </td>--}}
        {{--                <td class="text-right align_right">--}}
        {{--                    {{ number_format($ttlExcluDis,2) }}--}}
        {{--                </td>--}}
        {{--                <td class="text-right align_right">--}}
        {{--                    {{ number_format($trade_offerTtl,2) }}--}}
        {{--                </td>--}}
        {{--                <td class="text-center align_center">--}}
        {{--                    --}}{{--                    {{ number_format($ttlDis,2) }}--}}
        {{--                </td>--}}
        {{--                <td class="text-center align_center">--}}
        {{--                    {{ number_format($discountAmountTtl,2) }}--}}
        {{--                </td>--}}
        {{--                <td class="text-right align_right">--}}
        {{--                    {{ number_format($ttlAmnt,2) }}--}}
        {{--                </td>--}}
        {{--            </tr>--}}


        </tbody>
        <tfoot>

        <tr>
            <td colspan="13" class="border-0 p-0">
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
        </tr>
        </tfoot>

    </table>

    <div class="clearfix"></div>

</div>
<div class="input_bx_ftr"></div>
