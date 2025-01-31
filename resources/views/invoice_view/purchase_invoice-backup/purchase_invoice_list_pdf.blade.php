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
    /*============= pur invoice width ===================*/

    .pur_in_wdth_1{
        width: 5%;
        font-size: 12px !important;
    }

    .pur_in_wdth_2{
        width: 18%;
        font-size: 12px !important;
    }

    .pur_in_wdth_3{
        width: 43%;
        font-size: 12px !important;
    }

    .pur_in_wdth_4{
        width: 8%;
        font-size: 12px !important;
    }

    .pur_in_wdth_5{
        width: 13%;
        font-size: 12px !important;
    }

    .pur_in_wdth_6{
        width: 7%;
        font-size: 12px !important;
    }

    .pur_in_wdth_7{
        width: 10%;
        font-size: 12px !important;
    }

    .pur_in_wdth_8{
        width: 12%;
        font-size: 12px !important;
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
        font-size: 10px !important;
    }

    .fontS-12 label {
        font-size: 9px !important;
    }

    .clearfix{
        clear: both;
    }


</style>


<div id="" class="table-responsive" style="z-index: 9;">


    <table class="table table-bordered table-sm">

        <tr class="bg-transparent">
            <td colspan="2" class="p-0 border-0" >
                <img src="{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_logo : 'No Company Record'}}" alt="Company Logo" width="140" />
            </td>
            <td colspan="{{ ($pim->pi_invoice_type === 2) ? '6' : '4' }}" class="p-0 border-0 text-right" >
                <h2 class="invoice_hdng">
                    Purchase {{ ($pim->pi_status !== 'RETURN') ? 'Order' : 'Return' }} Invoice
                </h2>
                <p class="invoice_para m-0">
                    <b> Invoice #: </b>
                    {{ $pim->pi_id }}
                </p>
                <p class="invoice_para m-0 pt-5">
                    <b> Date: </b>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $pim->pi_day_end_date)))}}
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="{{ ($pim->pi_invoice_type === 2) ? '8' : '6' }}"  class="p-0 border-0">
                <table class="table table-bordered table-sm" >
                    <tr class="bg-transparent" >
                        <td colspan="1"  class="p-0 border-0">
                            <h3 class="invoice_sub_hdng mb-0 mt-0">
                                Billed {{ $pim->pi_status == 'PURCHASE' ? 'To' : 'From' }}
                            </h3>
                            <p class="invoice_para m-0 pt-5">
                                <b> Name: </b>
                                {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_name : 'N/A'}}
                            </p>
                            <p class="invoice_para adrs m-0 pt-5">
                                    <b> Adrs: </b>
                                {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_address : 'N/A'}}
                            </p>
                            <p class="invoice_para m-0 pt-5">
                                <b> Mob #: </b>
                                {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_mobile_numer : 'N/A'}}
                            </p>
                            <p class="invoice_para m-0 pt-5">
                                <b> Remarks: </b>
                                {{ $pim->pi_remarks }}
                            </p>
                        </td>
                        <td colspan="3"  class="p-0 border-0">
                            <p class="invoice_para m-0 pt-5 max_txt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        </td>
                        <td colspan="1"  class="p-0 border-0">
                            <h3 class="invoice_sub_hdng mb-0 mt-10">
                                Billed
                                {{ $pim->pi_status == 'RETURN' ? 'To' : 'From' }}
                            </h3>
                            <p class="invoice_para m-0 pt-5">
                                <b> Name: </b>
                                {{ (isset($pim->pi_party_name) && !empty($pim->pi_party_name)) ? $pim->pi_party_name : 'N/A' }}
                            </p>
                            <p class="invoice_para adrs m-0 pt-5">
                                    <b> Adrs: </b>
                                {{ (isset($accnts->account_address) && !empty($accnts->account_address) ? $accnts->account_address : 'N/A') }}
                            </p>
                            <p class="invoice_para m-0 pt-5">
                                <b> Mob #: </b>
                                {{ (isset($accnts->account_mobile_no) && !empty($accnts->account_mobile_no) ? $accnts->account_mobile_no : 'N/A') }}
                            </p>
                            <p class="invoice_para m-0 pt-5 mb-10">
                                <b> NTN #: </b>
                                {{ (isset($accnts->account_ntn) && !empty($accnts->account_ntn) ? $accnts->account_ntn : 'N/A') }}
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

    <table class="table table-bordered table-sm">
        <thead>

        <tr class="headings vi_tbl_hdng">
            <th scope="col"  class="pur_in_wdth_1 text-center ">Sr.</th>
            <th scope="col"  class=" text-left {{ ($pim->pi_invoice_type === 2) ? 'pur_in_wdth_2' : 'pur_in_wdth_3' }}">Product Name</th>
            <th scope="col"  class="pur_in_wdth_4 text-center ">QTY</th>
            @if($pim->pi_invoice_type === 1)
                <th scope="col"  class="pur_in_wdth_4 text-center ">Net Rate</th>
            @endif
            @if($pim->pi_invoice_type !== 1)
                <th class="pur_in_wdth_4  text-center"> Rate </th>
            @endif
            <th scope="col"  class="pur_in_wdth_8 text-center ">Excluded {{ ($pim->pi_invoice_type === 2) ? 'Sale Tax' : 'Discount' }} </th>
            <th scope="col"  class="pur_in_wdth_4 text-center ">Dis.</th>
            @if($pim->pi_invoice_type === 2)
                <th scope="col"  class="pur_in_wdth_8 text-center ">Included Dis. </th>
                <th scope="col"  class="pur_in_wdth_6 text-center ">Sale Tax%</th>
                <th scope="col"  class="pur_in_wdth_7 text-center ">Total Sales Tax Payable</th>
            @endif
            <th scope="col"  class="pur_in_wdth_5 text-center ">Total Amount</th>
        </tr>
        </thead>

        <tbody>
        @php $i = 01; $rate = $ttlRate = $ttlSaleTax = $dis = $ttlDis = $amnt = $ttlAmnt = $ttlNetRate = $excluSaleTaxRate = $ttlExcluSaleTaxRate = $ttl_pro = $ttl_pro1 = $ttlDeductDis1 = $deductDis1 = $deductDis = 0; @endphp
        @foreach( $piims as $piim )
            @php
                $dis = $piim->pii_discount;
                $ttlDis = +$dis + +$ttlDis;

                $amnt = $piim->pii_amount;
                $ttlAmnt = +$amnt + +$ttlAmnt;
            @endphp
            <tr class="even pointer">

                <td class="pur_in_wdth_1  text-center"> {{ $i }} </td>
                <td class=" text-left {{ ($pim->pi_invoice_type === 2) ? 'pur_in_wdth_2' : 'pur_in_wdth_3' }}">
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $piim->pii_product_name) !!}
                    @if(!empty($piim->pii_remarks) && isset($piim->pii_remarks))
                        <blockquote>
                            {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $piim->pii_remarks) !!}
                        </blockquote>
                    @endif
                </td>

                <td class="pur_in_wdth_4  text-center">
                    {!! $piim->pii_qty !!}
                </td>

                @if($pim->pi_invoice_type === 1)
                    @php
                        $percent = (($piim->pii_rate * $piim->pii_saletax) / 100);
                        $net_rate = +$piim->pii_rate + +$percent;
                        $excluSaleTaxRate = $net_rate * $piim->pii_qty;
                        $ttlExcluSaleTaxRate = +$excluSaleTaxRate + +$ttlExcluSaleTaxRate;
                        $ttlNetRate = +$net_rate + +$ttlNetRate;
                    @endphp
                    <td class="pur_in_wdth_4  text-center">
                        {{ $net_rate }}
                    </td>
                @endif

                @if($pim->pi_invoice_type !== 1)
                    @php
                        $rate = $piim->pii_rate;
                        $excluSaleTaxRate = $rate * $piim->pii_qty;
                        $ttlExcluSaleTaxRate = +$excluSaleTaxRate + +$ttlExcluSaleTaxRate;
                        $ttlRate = +$rate + +$ttlRate;
                    @endphp
                    <td class="pur_in_wdth_4  text-center">
                        {{ number_format($piim->pii_rate,2) }}
                    </td>
                @endif

                <td class="pur_in_wdth_8 align_right text-right">
                    {{ number_format($excluSaleTaxRate,2) }}
                </td>

                <td class="pur_in_wdth_4  text-center">
                    {!! $piim->pii_discount !!}
                </td>

                @if($pim->pi_invoice_type === 2)
                    @php
                        $ttl_pro = $piim->pii_rate * $piim->pii_qty;
                        $deductDis = +$ttl_pro - +$piim->pii_discount;
                        $ttlDeductDis1 = +$deductDis + +$ttlDeductDis1;
                        $percent = (($deductDis * $piim->pii_saletax) / 100);
                        $ttlSaleTax = +$percent + +$ttlSaleTax;
                    @endphp

                    <td class="pur_in_wdth_8 align_right text-right">
                        {{ number_format($deductDis,2) }}
                    </td>

                    <td class="pur_in_wdth_6  text-center">
                        {!! $piim->pii_saletax !!}
                    </td>

                    <td class="pur_in_wdth_7  text-center">
                        {!! number_format($percent,2) !!}
                    </td>
                @endif
                <td class="pur_in_wdth_5 align_right text-right">
                    {!! number_format($piim->pii_amount,2) !!}
                </td>

            </tr>
            @php $i++; @endphp
        @endforeach
        <tr>
            <th colspan="2" class="text-right align_right">
                Total:-
            </th>
            <td class="text-right align_right">

            </td>
            @if($pim->pi_invoice_type === 1)
                <td class="text-center ">
                </td>
            @endif
            @if($pim->pi_invoice_type !== 1)
                <td class="text-center ">
                </td>
            @endif

            <td class="text-right align_right">
                {{ number_format($ttlExcluSaleTaxRate,2) }}
            </td>

            <td class="text-center ">
                {{ number_format($ttlDis,2) }}
            </td>

            @if($pim->pi_invoice_type === 2)

                <td class="text-right align_right">
                    {{ number_format($ttlDeductDis1,2) }}
                </td>
                <td class="text-right align_right">

                </td>
                <td class="text-center ">
                    {{ number_format($ttlSaleTax,2) }}
                </td>
            @endif
            <td class="text-right align_right">
                {{ number_format($ttlAmnt,2) }}
            </td>
        </tr>


        </tbody>
        <tfoot>
        <tr class="border-0">
            <td colspan="{{ ($pim->pi_invoice_type === 2) ? '10' : '7' }}" valign="top" class="p-0 border-0" >
                <table class="table table-bordered table-sm chk_dmnd">
                    <tr>
                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                            <table  class="table table-bordered table-sm">
                                <tr>
                                    <th class="vi_tbl_hdng fontS-12 text-right">
                                        <label class="total-items-label text-right">Expense:-</label>
                                    </th>
                                    <td class="text-right fontS-12">
                                        {{ number_format($pim->pi_expense,2) }}
                                    </td>
                                </tr>
                                {{--                                    @if($pim->pi_invoice_type === 2)--}}
                                {{--                                        <tr>--}}
                                {{--                                            <td class="vi_tbl_hdng">--}}
                                {{--                                                <label class="total-items-label text-right">Sale Tax:-</label>--}}
                                {{--                                            </td>--}}
                                {{--                                            <td class="text-right">--}}
                                {{--                                                {{ number_format($pim->pi_sales_tax,2) }}--}}
                                {{--                                            </td>--}}
                                {{--                                        </tr>--}}
                                {{--                                    @endif--}}
                            </table>
                        </td>
                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                            <table  class="table table-bordered table-sm">
                                <tr>
                                    <th class="vi_tbl_hdng fontS-12 text-right">
                                        <label class="total-items-label text-right">Trade Discount:</label>
                                    </th>
                                    <td class="text-right fontS-12">
                                        {{ number_format($pim->pi_trade_disc,2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                            <table  class="table table-bordered table-sm">
                                <tr>
                                    {{--                                        <th class="vi_tbl_hdng fontS-12">--}}
                                    {{--                                            <label class="total-items-label text-right">Balance Amount:-</label>--}}
                                    {{--                                        </th>--}}
                                    {{--                                        <td class="text-right fontS-12">--}}
                                    {{--                                            {{ +$pim->pi_grand_total - $pim->pi_cash_paid }}--}}
                                    {{--                                        </td>--}}
                                    <th class="vi_tbl_hdng fontS-12 text-right">
                                        <label class="total-items-label text-right">Total Discount:</label>
                                    </th>
                                    <td class="text-right fontS-12">
                                        {{ number_format($pim->pi_total_discount,2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                            <table  class="table table-bordered table-sm">
                                {{--                                    <tr>--}}
                                {{--                                        <th class="vi_tbl_hdng">--}}
                                {{--                                            <label class="total-items-label text-right">Gross Total:-</label>--}}
                                {{--                                        </th>--}}
                                {{--                                        <td class="text-right">--}}
                                {{--                                            {{$pim->pi_total_price !=0 ? number_format($pim->pi_total_price,2):'0'}}--}}
                                {{--                                        </td>--}}
                                {{--                                    </tr>--}}
                                <tr>
                                    <th class="vi_tbl_hdng fontS-12 text-right">
                                        <label class="total-items-label text-right">Grand Total:-</label>
                                    </th>
                                    <td class="text-right fontS-12">
                                        {{ number_format($pim->pi_grand_total,2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                            <table  class="table table-bordered table-sm">
                                <tr>
                                    <th class="vi_tbl_hdng fontS-12 text-right">
                                        <label class="total-items-label text-right">Cash Paid:-</label>
                                    </th>
                                    <td class="text-right fontS-12">
                                        {{ number_format($pim->pi_cash_paid,2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="{{ ($pim->pi_invoice_type === 2) ? '10' : '7' }}" class="border-0 p-0">
                <div class="wrds_con">
                    <div class="wrds_bx">
                        <span class="wrds_hdng">
                            In Words
                        </span>
                        {{ $nbrOfWrds }} ONLY
                    </div>
                    <div class="wrds_bx wrds_bx_two">
                        <span class="wrds_hdng">
                            Receipient Sign.
                        </span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </td>
        </tr>
        <tr>
            <td colspan="{{ ($pim->pi_invoice_type === 2) ? '10' : '7' }}" class="border-0 p-0">
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
                        <span class="sign_itm">
                            Accounts Manager
                        </span>
                        <div class="clearfix"></div>
                    </div>

                    <div class="sign_bx">
                        <span class="sign_itm">
                            Chief Executive
                        </span>
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

<div class="clearfix"></div>
<div class="input_bx_ftr"></div>
