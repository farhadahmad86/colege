@extends('invoice_view.print_index')

@section('print_cntnt')
    @php
        $company_info = Session::get('company_info');
    @endphp

    <div id="printingSection" class="table-responsive" style="z-index: 9;">


        <table class="table table-bordered table-sm">

            {{--            @if($type === 'grid')--}}
            {{--                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])--}}
            {{--            @endif--}}


            {{--            <tr>--}}
            {{--                <td colspan="{{ ($sim->si_invoice_type === 2 || $sim->si_invoice_type === 3) ? '8' : '6' }}"  class="p-0 border-0">--}}
            {{--                    <table class="table table-bordered table-sm bg-transparent" >--}}

            <tr class="bg-transparent">
                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0">
                        Billed From
                    </h3>
                    <p class="invoice_para m-0 pt-0 ">
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
                    <p class="invoice_para m-0 pt-0 ">
                        <b> Remarks: </b>
                        {{ $sim->si_remarks }}
                    </p>
                    <p class="invoice_para m-0 pt-0 ">
                        <b>
                            Posting Reference:
                        </b>
                        {{ $sim->pr_name }}
                    </p>
                </td>

                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Billed To
                    </h3>
                    <p class="invoice_para m-0 pt-0 ">
                        <b> Name: </b>
                        {{ (isset($sim->si_party_name) && !empty($sim->si_party_name)) ? $sim->si_party_name : 'N/A' }}
                    </p>
                    <p class="invoice_para adrs m-0 pt-0">
                        <b> Adrs: </b>
                        {{ (isset($accnts->account_address) && !empty($accnts->account_address) ? $accnts->account_address : 'N/A') }}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b> Mob #: </b>
                        {{ (isset($accnts->account_mobile_no) && !empty($accnts->account_mobile_no) ? $accnts->account_mobile_no : 'N/A') }}
                    </p>
                    <p class="invoice_para m-0 pt-0 mb-10">
                        <b> NTN #: </b>
                        {{ (isset($accnts->account_ntn) && !empty($accnts->account_ntn) ? $accnts->account_ntn : 'N/A') }}
                    </p>
                </td>
            </tr>


            {{--                    </table>--}}
            {{--                </td>--}}
            {{--            </tr>--}}

        </table>


        <table class="table table-bordered table-sm ">
            <thead>
            @php
                $serial_no='Sr.';
                $product_name='Product Name';
                $qty='QTY';
                $rate='Rate';
                $ex_discount='Excluded Discount';
                $dis_pec='Dis.%';
                $dis_amount='Dis. Amount';
 $in_dis='Included Dis.';
                $total_amount='Total Amount';
                $product_discount='Product Discount:';
                $round_off_discount='Round off Discount:';
                $cash_discount='Cash Discount:';
                $total_discount='Total Discount:';
                $grand_total='Grand Total:';
                $cash_receivedd='Cash Received:';
$gross_amount_lan ='Gross Amount:';
$balance='Balance:';
                if($urdu_eng->rc_invoice==1){
                    $serial_no='سیریل نمبر';
                    $product_name='اشیاء کا نام';
                $qty='مقدار';
                $rate='قیمت';
                $ex_discount='رعایت کےبغیر';
                $dis_pec='رعایت ٪';
                $dis_amount='رعایتی رقم';
                $in_dis='رعایت کےساتھ';
                $total_amount='کل رقم';

                $product_discount='اشیاءمیں کل رعایت';
                $round_off_discount='راوٗنڈآف ڈسکاوٰٗنٹ';
                $cash_discount='رقم میں رعایت';
                $total_discount='کل رعایت';
                $grand_total='مکمل کل رقم';
                $cash_receivedd='وصول شدہ رقم';
                $gross_amount_lan='مجموعی رقم';
                $balance='بیلنس';
                }
            @endphp
            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="tbl_srl_4 text-center align_center ">
                    {{$serial_no}}
                </th>
                <th scope="col" align="center" class="align_left text-left tbl_txt_28 ">
                    {{$product_name}}
                </th>
                {{--                    <th scope="col" align="center" class="text-center align_center tbl_amnt_15 ">--}}
                {{--                        Remarks--}}
                {{--                    </th>--}}
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10 ">
                    {{$qty}}
                </th>
                <th class="align_center text-center tbl_amnt_10 ">
                    {{$rate}}
                </th>

                <th scope="col" align="center" class="text-center align_center tbl_amnt_8 ">
                    {{$ex_discount}}
                </th>

                <th scope="col" align="center" class="text-center align_center tbl_amnt_7 ">
                    {{$dis_pec}}
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_7 ">
                    {{$dis_amount}}
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10 ">
                    {{$in_dis}}
                </th>
                {{--                    <th scope="col" align="center" class="text-center align_center tbl_amnt_8 ">--}}
                {{--                        Sale Tax%--}}
                {{--                    </th>--}}
                {{--                    <th scope="col" align="center" class="text-center align_center tbl_amnt_8 ">--}}
                {{--                        Total Sales Tax Payable--}}
                {{--                    </th>--}}
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15 ">
                    {{$total_amount}}
                </th>
            </tr>

            </thead>

            <tbody>
            @php
                $i = 01; $excluProDis = $ttlExcluProDis = $ttlIncluProDis = $ttlSaleProTax = $ttlProAmnt = 0;
            @endphp
            @php
                $mainTtlProDis = $mainTtlRoundDis = $mainTtlCashDis = $mainTtlDis = $mainTtlIncluSlTx = $mainTtlExcluSlTx = $mainTtlSlTx = $mainGrndTtl = $mainTtlSrvsIncluSlTx = $mainTtlSrvsExcluSlTx = $mainTtlSrvsSlTx = $mainTtlCshPaid = 0;

            //=========== discount section start ==============

            $si_product_disc = (isset($sim->si_product_disc) && !empty($sim->si_product_disc)) ? $sim->si_product_disc : 0;
            $si_round_off_disc = (isset($sim->si_round_off_disc) && !empty($sim->si_round_off_disc)) ? $sim->si_round_off_disc : 0;
            $si_cash_disc_amount = (isset($sim->si_cash_disc_amount) && !empty($sim->si_cash_disc_amount)) ? $sim->si_cash_disc_amount : 0;
            $si_total_discount = (isset($sim->si_total_discount) && !empty($sim->si_total_discount)) ? $sim->si_total_discount : 0;

            $sei_product_disc = (isset($seim->sei_product_disc) && !empty($seim->sei_product_disc)) ? $seim->sei_product_disc : 0;
            $sei_round_off_disc = (isset($seim->sei_round_off_disc) && !empty($seim->sei_round_off_disc)) ? $seim->sei_round_off_disc : 0;
            $sei_cash_disc_amount = (isset($seim->sei_cash_disc_amount) && !empty($seim->sei_cash_disc_amount)) ? $seim->sei_cash_disc_amount : 0;
            $sei_total_discount = (isset($seim->sei_total_discount) && !empty($seim->sei_total_discount)) ? $seim->sei_total_discount : 0;

            $mainTtlProDis = +$si_product_disc + +$sei_product_disc;
            $mainTtlRoundDis = +$si_round_off_disc + +$sei_round_off_disc;
            $mainTtlCashDis = +$si_cash_disc_amount + +$sei_cash_disc_amount;
            $mainTtlDis = +$sei_total_discount + +$si_total_discount;

            //=========== discount section end ==============

            //=========== Sale Tax section start ==============

            $si_inclusive_sales_tax = (isset($sim->si_inclusive_sales_tax) && !empty($sim->si_inclusive_sales_tax)) ? $sim->si_inclusive_sales_tax : 0;
            $si_exclusive_sales_tax = (isset($sim->si_exclusive_sales_tax) && !empty($sim->si_exclusive_sales_tax)) ? $sim->si_exclusive_sales_tax : 0;
            $si_total_sales_tax = (isset($sim->si_total_sales_tax) && !empty($sim->si_total_sales_tax)) ? $sim->si_total_sales_tax : 0;

            //=========== Sale Tax section end ==============

            //=========== Services Sale Tax section start ==============

            $sei_inclusive_sales_tax = (isset($seim->sei_inclusive_sales_tax) && !empty($seim->sei_inclusive_sales_tax)) ? $seim->sei_inclusive_sales_tax : 0;
            $sei_exclusive_sales_tax = (isset($seim->sei_exclusive_sales_tax) && !empty($seim->sei_exclusive_sales_tax)) ? $seim->sei_exclusive_sales_tax : 0;
            $sei_total_sales_tax = (isset($seim->sei_total_sales_tax) && !empty($seim->sei_total_sales_tax)) ? $seim->sei_total_sales_tax : 0;

            //=========== Services Sale Tax section end ==============


            $si_grand_total = (isset($sim->si_grand_total) && !empty($sim->si_grand_total)) ? $sim->si_grand_total : 0;
            $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;

            $mainGrndTtl = +$si_grand_total + +$sei_grand_total;

$qtyTtl=0;


            @endphp


            @foreach( $siims as $siim )
                @php
                    $db_qty=$siim->qty;
    $db_rate=$siim->rate;
    $gross_amount=$db_rate * $db_qty;
                                            //$excluProDis = $siim->qty * $siim->rate;
                                            $excluProDis = $gross_amount;
                                            $ttlExcluProDis = +$excluProDis + +$ttlExcluProDis;
                                            $ttlIncluProDis = +$siim->after_discount + +$ttlIncluProDis;
                                            //$ttlSaleProTax = +$ttlSaleProTax + +$siim->sale_tax_amount;
                                            $ttlProAmnt = +$ttlProAmnt + +$siim->amount;

                    $qtyTtl = +$qtyTtl + +$db_qty ;
                @endphp

                <tr class="even pointer">

                    <th scope="row" class="">
                        {{ $i }}
                    </th>
                    <td>
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->name) !!}
                        @if(!empty($siim->remarks) && isset($siim->remarks))
                            <blockquote class="">
                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->remarks) !!}
                            </blockquote>
                        @endif
                    </td>
                    {{--                    <td class="tbl_amnt_15 align_center text-center">--}}
                    {{--                        {!! $siim->remarks !!}--}}
                    {{--                    </td>--}}
                    <td>
                        {!! $siim->qty !!}
                    </td>
                    <td>
                        {{ number_format($siim->rate,2) }}
                    </td>

                    <td class="align_right text-right">
                        {{ number_format($excluProDis,2) }}
                    </td>

                    <td>
                        {!! $siim->discount !!}
                    </td>
                    <td>
                        {!! $siim->discount_amount !!}
                    </td>
                    <td class="align_right text-right">
                        {{ number_format($siim->after_discount,2) }}
                    </td>
                    {{--                    <td class="align_center text-center tbl_amnt_8">--}}
                    {{--                        {!! $siim->sale_tax !!}--}}
                    {{--                    </td>--}}
                    {{--                    <td class="align_right text-right tbl_amnt_8">--}}
                    {{--                        {{ ($siim->inclu_exclu === 1) ? "(In)=" : "(Ex)=" }}{!! number_format($siim->sale_tax_amount,2) !!}--}}
                    {{--                    </td>--}}
                    <td class="align_right text-right">
                        {!! number_format($siim->amount,2) !!}
                    </td>

                </tr>
                @php $i++; @endphp
            @endforeach
            <tr>
                <th colspan="2" class="text-right align_right">
                    Total:-
                </th>
                <td class="text-center align_center">
                    {{--                    {{ number_format($sim->si_total_items,3) }}--}}
                    {{ number_format($qtyTtl,3) }}
                </td>
                <td class="text-center align_center">
                </td>

                <td class="text-right align_right">
                    {{ number_format($ttlExcluProDis,2) }}
                </td>

                <td class="text-center align_center">
                    {{--                    {{ number_format($ttlDis,2) }}--}}
                </td>
                <td class="text-right align_right">
                    {{ number_format($mainTtlProDis,2) }}
                </td>
                <td class="text-right align_right">
                    {{ number_format($ttlIncluProDis,2) }}
                </td>

                {{--                <td class="text-right align_right">--}}
                {{--                    @php--}}
                {{--                        $ttlSaleProTax = +$si_total_sales_tax + +$sei_total_sales_tax;--}}
                {{--                    @endphp--}}
                {{--                    {{ number_format($ttlSaleProTax,2) }}--}}
                {{--                </td>--}}
                <td class="text-right align_right">
                    {{ number_format($ttlProAmnt,2) }}
                </td>
            </tr>


            </tbody>
            <tfoot>
            <tr class="border-0">
                <td colspan="13" align="right" class="p-0 border-0">
                    <table class="table table-bordered table-sm chk_dmnd">
                        <tr>
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                {{$product_discount}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                                {{ number_format($sim->ssi_product_disc,2) }}--}}
                                            {{ number_format($mainTtlProDis,2) }}
                                        </td>
                                    </tr>
                                    {{--                                    <tr>--}}
                                    {{--                                        <th class="vi_tbl_hdng text-right">--}}
                                    {{--                                            <label class="total-items-label text-right">--}}
                                    {{--                                                Total Trade Offer:--}}
                                    {{--                                            </label>--}}
                                    {{--                                        </th>--}}
                                    {{--                                        <td class="text-right">--}}
                                    {{--                                            {{ number_format($trade_offerTtl,2) }}--}}
                                    {{--                                        </td>--}}
                                    {{--                                    </tr>--}}
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right ">
                                                {{$total_discount}}
                                            </label>
                                        </th>
                                        <td class="text-right">

                                            {{--                                            {{ number_format($sim->ssi_total_discount,2) }}--}}
                                            {{ number_format($mainTtlDis,2) }}
                                        </td>
                                    </tr>
                                    {{--<tr>--}}
                                    {{--    <th class="vi_tbl_hdng text-right">--}}
                                    {{--        <label class="total-items-label text-right">--}}
                                    {{--            Services Inclusive Sales Tax:--}}
                                    {{--        </label>--}}
                                    {{--    </th>--}}
                                    {{--    <td class="text-right">--}}
                                    {{--        --}}{{--                                                {{ number_format($seim->sesi_inclusive_sales_tax,2) }}--}}
                                    {{--        {{ number_format($sei_inclusive_sales_tax,2) }}--}}
                                    {{--    </td>--}}
                                    {{--</tr>--}}

                                </table>
                            </td>
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right ">
                                                {{$round_off_discount}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                                {{ number_format($sim->ssi_round_off_disc,2) }}--}}
                                            {{ number_format($mainTtlRoundDis,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right ">
                                                {{$cash_discount}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                                                                                                                {{ number_format($sim->ssi_cash_disc_amount,2) }}--}}
                                            {{ number_format($mainTtlCashDis,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="total-items-label text-right ">
                                                {{$gross_amount_lan}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                            {{ number_format($sim->ssi_inclusive_sales_tax,2) }}--}}
                                            {{ number_format($ttlExcluProDis,2) }}
                                        </td>
                                    </tr>
                                    {{--<tr>--}}
                                    {{--    <th class="vi_tbl_hdng text-right">--}}
                                    {{--        <label class="total-items-label text-right">--}}
                                    {{--            Exclusive Sales Tax:--}}
                                    {{--        </label>--}}
                                    {{--    </th>--}}
                                    {{--    <td class="text-right">--}}
                                    {{--        {{ number_format($si_exclusive_sales_tax,2) }}--}}
                                    {{--        --}}{{--                                                {{ number_format($sim->ssi_exclusive_sales_tax,2) }}--}}
                                    {{--    </td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                    {{--    <th class="vi_tbl_hdng text-right">--}}
                                    {{--        <label class="total-items-label text-right">--}}
                                    {{--            Services Exclusive Sales Tax:--}}
                                    {{--        </label>--}}
                                    {{--    </th>--}}
                                    {{--    <td class="text-right">--}}
                                    {{--        {{ number_format($sei_exclusive_sales_tax,2) }}--}}
                                    {{--        --}}{{--                                                {{ number_format($seim->sesi_exclusive_sales_tax,2) }}--}}
                                    {{--    </td>--}}
                                    {{--</tr>--}}
                                </table>
                            </td>
                            {{-- <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
                            {{--     <table  class="table table-bordered table-sm">--}}
                            {{--         <tr>--}}
                            {{--             <th class="vi_tbl_hdng text-right">--}}
                            {{--                 <label class="total-items-label text-right">--}}
                            {{--                     Cash Discount:--}}
                            {{--                 </label>--}}
                            {{--             </th>--}}
                            {{--             <td class="text-right">--}}
                            {{--                 --}}{{--                                                {{ number_format($sim->ssi_cash_disc_amount,2) }}--}}
                            {{--                 {{ number_format($mainTtlCashDis,2) }}--}}
                            {{--             </td>--}}
                            {{--         </tr>--}}
                            {{--         <tr>--}}
                            {{--             <th class="vi_tbl_hdng text-right">--}}
                            {{--                 <label class="total-items-label text-right">--}}
                            {{--                     Total Sales Tax:--}}
                            {{--                 </label>--}}
                            {{--             </th>--}}
                            {{--             <td class="text-right">--}}
                            {{--                 {{ number_format($si_total_sales_tax,2) }}--}}
                            {{--                 --}}{{----}}{{--                                                {{ number_format($sim->ssi_total_sales_tax,2) }}--}}
                            {{--             </td>--}}
                            {{--         </tr>--}}
                            {{--         <tr>--}}
                            {{--             <th class="vi_tbl_hdng text-right">--}}
                            {{--                 <label class="total-items-label text-right">--}}
                            {{--                     Services Total Sales Tax:--}}
                            {{--                 </label>--}}
                            {{--             </th>--}}
                            {{--             <td class="text-right">--}}
                            {{--                 --}}{{----}}{{--                                                {{ number_format($seim->sesi_total_sales_tax,2) }}--}}
                            {{--                 {{ number_format($sei_total_sales_tax,2) }}--}}
                            {{--             </td>--}}
                            {{--         </tr>--}}
                            {{--     </table>--}}
                            {{-- </td>--}}

                            <td class="teble-responsive pl-0 pb-0 pr-0 border-0 pts-10">
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                {{$grand_total}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                            {{ number_format($sim->ssi_grand_total,2) }}--}}
                                            {{ number_format($mainGrndTtl,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                {{$cash_receivedd}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                            {{ number_format($sim->si_cash_paid,2) }}--}}
                                            {{ number_format($cash_received,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="total-items-label text-right">
                                                {{$balance}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            @php

                                                $balance = $mainGrndTtl - $cash_received;
                                            @endphp
                                            {{--                                            {{ number_format($sim->ssi_total_discount,2) }}--}}
                                            {{ number_format($balance,2) }}
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <style>
                .fieldset-box fieldset {
                    min-height: 47px;
                    border-color: black;
                }

                .fieldset-box fieldset legend {
                    font-weight: 600;
                }

                .fieldset-box fieldset span {
                    text-transform: uppercase;
                    line-height: 2;
                    margin-left: 10px;
                }
            </style>
            <tr class="fieldset-box">
                <td colspan="7" class="border-0 p-0 chck_pdng">

                    <fieldset>
                        <legend>In Words</legend>
                        <span>{{ $nbrOfWrds }} ONLY</span>
                    </fieldset>
                </td>
                <td class="border-0 p-0 chck_pdng" colspan="3">

                    <fieldset>
                        <legend>Recipient Sign.</legend>
                        <span>

                        </span>
                    </fieldset>
                </td>
            </tr>
            </tfoot>

        </table>

        <table class="table table-bordered table-sm" style="padding-right:100px">
            <tbody>
            <tr>
                <td class="border-0 p-0">

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
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    @if( $type === 'grid')
        <div class="itm_vchr_rmrks">

            <a href="{{ route('sale_items_view_details_pdf_sh',['id'=>$sim->si_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download
            </a>

            <iframe style="display: none" id="printf" name="printf" src="{{ route('sale_items_view_details_pdf_sh',['id'=>$sim->si_id]) }}" title="W3Schools Free Online Web Tutorials">Iframe
            </iframe>

            {{--        <button type="button" id="printkro" class="btn btn-default form-control cancel_button"--}}
            {{--                --}}{{--                                    onclick="gotoParty()"--}}
            {{--                onclick="javascript:printDiv('printingSection')"--}}
            {{--                onclick="printDiv('printingSection')"--}}
            {{--                onclick="PrintFrame()"--}}
            {{--                data-dismiss="modal">--}}
            {{--            <i class="fa fa-times"></i> print kro real one--}}
            {{--        </button>--}}

            <a href="#" id="printi" onclick="PrintFrame()" class="ml-2 align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Print
            </a>

        </div>

        <div class="clearfix"></div>
        <div class="input_bx_ftr"></div>
    @endif

    <script>

        function PrintFrame() {
            window.frames["printf"].focus();
            window.frames["printf"].print();
        }

        // function PrintDiv() {
        //     alert("pakistan");
        //     var contents = document.getElementById("printingSection").innerHTML;
        //     var frame1 = document.createElement('iframe');
        //     frame1.name = "frame1";
        //     frame1.style.position = "absolute";
        //     frame1.style.top = "-1000000px";
        //     document.body.appendChild(frame1);
        //     var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
        //     frameDoc.document.open();
        //     frameDoc.document.write('<html><head><title>DIV Contents</title>');
        //     frameDoc.document.write('</head><body>');
        //     frameDoc.document.write(contents);
        //     frameDoc.document.write('</body></html>');
        //     frameDoc.document.close();
        //     setTimeout(function () {
        //         window.frames["frame1"].focus();
        //         window.frames["frame1"].print();
        //         document.body.removeChild(frame1);
        //     }, 500);
        //     return false;
        // }

        // function printDiv(divID)
        // {
        //     var divToPrint=document.getElementById('printingSection');
        //
        //         var divToPrint = document.getElementById(divID).innerHTML;
        //     //     alert(divElements);
        //     //
        //     //     //Get the HTML of whole page
        //     //     var oldPage = document.body.innerHTML;
        //     //
        //     //     //Reset the page's HTML with div's HTML only
        //     //     document.body.innerHTML =
        //     //         "<html><head><title></title></head><body>" +
        //     //         divElements + "</body>";
        //     //
        //     //     //Print Page
        //     //     window.print();
        //     //
        //     //     window.close();
        //     //     var toggleBody = $('body *:visible');
        //     //     toggleBody.hide();
        //
        //     var newWin=window.open('','Print-Window');
        //     newWin.document.open();
        //
        //         //Reset the page's HTML with div's HTML only
        //         // document.body.innerHTML =
        //         //     "<html><head><title></title></head><body>" +
        //         //     divToPrint + "</body>";
        //
        //     // newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        //     newWin.document.write("<html><head><title></title></head><body>" + divToPrint + "</body></html>'");
        //
        //     newWin.document.close();
        //     setTimeout(function(){newWin.close();},3000);
        // }


        // jQuery.fn.extend({
        //     printElem: function() {
        //         var cloned = this.clone();
        //         alert(cloned);
        //         var printSection = $('#printingSection');
        //         if (printSection.length == 0) {
        //             printSection = $('<div id="printingSection"></div>')
        //             $('body').append(printSection);
        //         }
        //         printSection.append(cloned);
        //         var toggleBody = $('body *:visible');
        //         toggleBody.hide();
        //         $('#printingSection, #printingSection *').show();
        //         window.print();
        //         printSection.remove();
        //         toggleBody.show();
        //     }
        // });
        //
        // function printDiv(divID) {
        //     alert("first function");
        //         // divID.printElem();
        //     $('.main_container').printElem();
        //
        // }


        // function printDiv(divID) {
        //     // Get the HTML of div
        //     alert("print kro called");
        //     alert(divID);
        //
        //     var divElements = document.getElementById(divID).innerHTML;
        //     alert(divElements);
        //
        //     //Get the HTML of whole page
        //     var oldPage = document.body.innerHTML;
        //
        //     //Reset the page's HTML with div's HTML only
        //     document.body.innerHTML =
        //         "<html><head><title></title></head><body>" +
        //         divElements + "</body>";
        //
        //     //Print Page
        //     window.print();
        //
        //     window.close();
        //     var toggleBody = $('body *:visible');
        //     toggleBody.hide();
        //
        //     //Restore orignal HTML
        //     // document.body.innerHTML = oldPage;
        // }

    </script>


@endsection
