@extends('invoice_view.print_index')

@section('print_cntnt')
    @php
        $company_info = Session::get('company_info');
    @endphp
    <div id="" class="table-responsive" style="z-index: 9;">
        <table class="table table-bordered table-sm">
            @if($type === 'grid')
                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])
            @endif

            <tr class="bg-transparent">
                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0">
                        Billed To
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
                    <p class="invoice_para m-0 pt-0 ">
                        <b> Remarks: </b>
                        {{ $pim->pri_remarks }}
                    </p>
                    <p class="invoice_para m-0 pt-0 ">
                        <b>
                            Posting Refference:
                        </b>
                        {{ $pim->pr_name }}
                    </p>
                </td>

                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Billed From
                    </h3>
                    <p class="invoice_para m-0 pt-0 ">
                        <b> Name: </b>
                        {{ (isset($pim->pri_party_name) && !empty($pim->pri_party_name)) ? $pim->pri_party_name : 'N/A' }}
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

        </table>


        <table class="table table-bordered table-sm">
            <thead>
            @php
                $serial_no='Sr.';
                $product_name='Product Name';
                $qty='QTY';
                $rate='Rate';
                $ex_discount='Excluded Discount';
                $dis_pec='Dis.%';
                $dis_amount='Dis. Amount';
                $total_amount='Total Amount';

                $product_discount='Product Discount:';
                $round_off_discount='Round off Discount:';
                $cash_discount='Cash Discount:';
                $total_discount='Total Discount:';
                $grand_total='Grand Total:';
                $cash_paid='Cash Paid:';

                if($urdu_eng->rc_invoice==1){
                    $serial_no='سیریل نمبر';
                    $product_name='اشیاء کا نام';
                $qty='مقدار';
                $rate='قیمت';
                $ex_discount='رعایت کےبغیر';
                $dis_pec='رعایت ٪';
                $dis_amount='رعایتی رقم';
                $total_amount='کل رقم';

                $product_discount='اشیاءمیں کل رعایت';
                $round_off_discount='راوٗنڈآف ڈسکاوٰٗنٹ';
                $cash_discount='رقم میں رعایت';
                $total_discount='کل رعایت';
                $grand_total='مکمل کل رقم';
                $cash_paid='اداشدہ رقم';
                }
            @endphp
            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="tbl_srl_6 text-center align_center">
                    {{$serial_no}}
                </th>
                <th scope="col" align="center" class="align_left text-left tbl_txt_43">
                    {{$product_name}}
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    {{$qty}}
                </th>
                <th class="align_center text-center tbl_amnt_10">
                    {{$rate}}
                </th>
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_15 ">--}}
{{--                    {{$ex_discount}}--}}
{{--                </th>--}}
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    {{$dis_pec}}
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    {{$dis_amount}}
                </th>

                <th scope="col" align="center" class="text-center align_center tbl_amnt_15 ">
                    {{$total_amount}}
                </th>
            </tr>

            </thead>

            <tbody>
            @php $i = 01; $excluDis = $ttlExcluDis = $ttlIncluDis = $ttlSaleTax = $ttlAmnt = 0;
            $trade_offerTtl=0;
            $discountAmountTtl=0;
            @endphp
            @foreach( $piims as $piim )
                @php
                    $db_qty=$piim->qty;
                       $db_rate=$piim->rate;

                       $gross_amount=$db_rate * $db_qty;
                       $excluDis = $piim->qty * $piim->rate;
                       $ttlExcluDis = +$excluDis + +$ttlExcluDis;
                       $ttlIncluDis = +$piim->after_discount + +$ttlIncluDis;
                       $ttlSaleTax = +$ttlSaleTax + +$piim->sale_tax_amount;
                       $ttlAmnt = +$ttlAmnt + +$piim->amount;

                    $discountAmountTtl = +$discountAmountTtl + +$piim->discount_amount ;
                @endphp

                <tr class="even pointer">

                    <th>
                        {{ $i }}
                    </th>

                    <td>
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $piim->name) !!}
                        @if(!empty($piim->remarks) && isset($piim->remarks))
                            <blockquote class="">
                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $piim->remarks) !!}
                            </blockquote>
                        @endif
                    </td>
                    <td>
                        {!! $piim->qty !!}
                    </td>
                    <td>
                        {{ number_format($piim->rate,2) }}
                    </td>

{{--                    <td class="align_right text-right tbl_amnt_15">--}}
{{--                        {{ number_format($excluDis,2) }}--}}
{{--                    </td>--}}

                    <td>
                        {!! $piim->discount !!}
                    </td>
                    <td>
                        {!! $piim->discount_amount !!}
                    </td>
                    <td class="align_right text-right">
                        {!! number_format($piim->amount,2) !!}
                    </td>

                </tr>
                @php $i++; @endphp
            @endforeach
            <tr>
                <th colspan="2" class="text-right align_right">
                    Total:-
                </th>
                <td class="text-center align_right">
                    {{ number_format($pim->pri_total_items,3) }}
                </td>

                <td class="text-center align_center">
                </td>
{{--                <td class="text-right align_right">--}}
{{--                    {{ number_format($ttlExcluDis,2) }}--}}
{{--                </td>--}}

                <td class="text-center align_center">
                    {{--                    {{ number_format($ttlDis,2) }}--}}
                </td>
                <td class="text-center align_center">
                                        {{ number_format($discountAmountTtl,2) }}
                </td>
                <td class="text-right align_right">
                    {{ number_format($ttlAmnt,2) }}
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
                                            <label class="vi_tbl_hdng total-items-label text-right ">
                                                {{$product_discount}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{ number_format($pim->pri_product_disc,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right ">
                                                {{$round_off_discount}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{ number_format($pim->pri_round_off_disc,2) }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right ">
                                                {{$cash_discount}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{ number_format($pim->pri_cash_disc_amount,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right ">
                                                {{$total_discount}}
                                            </label>
                                        </th>
{{--                                        @php $discountTtl = $trade_offerTtl + $pim->pri_total_discount @endphp--}}
                                        <td class="text-right">
                                            {{ number_format($pim->pri_total_discount,2) }}
{{--                                            {{ number_format($pim->pri_total_discount,2) }}--}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right ">
                                                {{$grand_total}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{ number_format($pim->pri_grand_total,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right ">
                                                {{$cash_paid}}
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{ number_format($pim->pri_cash_paid,2) }}
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
                <td colspan="5" class="border-0 p-0 chck_pdng">

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

            <a href="{{ route('purchase_return_items_view_details_pdf_SH',['id'=>$pim->pri_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download
            </a>

            <iframe style="display: none" id="printf" name="printf" src="{{ route('purchase_return_items_view_details_pdf_SH',['id'=>$pim->pri_id]) }}" title="W3Schools Free Online Web Tutorials">
                Iframe
            </iframe>


            <a href="#" id="printi" onclick="PrintFrame()" class="ml-2 align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Print
            </a>

        </div>

        {{--    <div class="itm_vchr_rmrks">--}}

        {{--        <a href="{{ route('purchase_return_items_view_details_pdf_SH',['id'=>$pim->pri_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">--}}
        {{--            Download/Get PDF/Print--}}
        {{--        </a>--}}
        {{--    </div>--}}

        <div class="clearfix"></div>
        <div class="input_bx_ftr"></div>
    @endif
    <script>

        function PrintFrame() {
            window.frames["printf"].focus();
            window.frames["printf"].print();
        }

    </script>
@endsection
