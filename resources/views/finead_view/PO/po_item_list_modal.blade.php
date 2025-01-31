
@php
    $company_info = Session::get('company_info');
@endphp
<div id="" class="table-responsive" style="z-index: 9;">


    <table class="table table-bordered table-sm" style="background-image: url({{ asset('public/vendors/images/invoice_background.png') }}); background-repeat: no-repeat;background-position: left top;-webkit-background-size: 100% auto;background-size: 100% auto;">

        <tr class="bg-transparent">
            <td colspan="2" class="p-0 border-0" >
                <img src="{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_logo : 'No Company Record'}}" alt="Company Logo" width="170" />
            </td>
            <td colspan="4" class="p-0 border-0 text-right" >
                <h2 class="invoice_hdng">
                    Purchase Order Invoice
                </h2>
                <p class="invoice_para m-0">
                    <b> Invoice #: </b>
                    {{ $pim->po_id }}
                </p>
                <p class="invoice_para m-0 pt-5">
                    <b> Date: </b>
{{--                    {{date('d-M-y', strtotime(str_replace('/', '-', $pim->po_day_end_date)))}}--}}
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="6"  class="p-0 border-0">
                <table class="table p-0 m-0 bg-transparent" >
                    <tr class="bg-transparent" >
                        <td colspan="3"  class="p-0 border-0">
                            <h3 class="invoice_sub_hdng mb-0">
                                Billed {{ $pim->po_status }}
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
                                {{ $pim->po_remarks }}
                            </p>
                        </td>
{{--                        <td colspan="1"  class="p-0 border-0">--}}
{{--                            <p class="invoice_para m-0 pt-5 max_txt"></p>--}}
{{--                        </td>--}}
                        <td colspan="3"  class="p-0 border-0">
                            <h3 class="invoice_sub_hdng mb-0 mt-0">
                                Billed
                                {{ $pim->po_status == 'RETURN' ? 'To' : 'From' }}
                            </h3>
                            <p class="invoice_para m-0 pt-5">
                                <b> Name: </b>
                                {{ (isset($pim->po_party_name) && !empty($pim->po_party_name)) ? $pim->po_party_name : 'N/A' }}
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
            <th scope="col" align="center" class="pur_in_wdth_1 text-center align_center">
                Sr.
            </th>
            <th scope="col" align="center" class="align_left text-left pur_in_wdth_2">
                Product Name
            </th>
            <th scope="col" align="center" class="pur_in_wdth_4 text-center align_center">
                QTY
            </th>

                <th class="pur_in_wdth_4 align_center text-center">
                    Rate
                </th>
            <th scope="col" align="center" class="pur_in_wdth_5 text-center align_center">
                Gross Amount
            </th>
            <th scope="col" align="center" class="pur_in_wdth_4 text-center align_center">
                Dis. %
            </th>
            <th scope="col" align="center" class="pur_in_wdth_4 text-center align_center">
                Dis. Amount
            </th>
{{--            @if($pim->pi_invoice_type === 2)--}}
{{--                <th scope="col" align="center" class="pur_in_wdth_8 text-center align_center">--}}
{{--                    Included Dis.--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="pur_in_wdth_6 text-center align_center">--}}
{{--                    Sale Tax%--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="pur_in_wdth_7 text-center align_center">--}}
{{--                    Total Sales Tax Payable--}}
{{--                </th>--}}
{{--            @endif--}}
            <th scope="col" align="center" class="pur_in_wdth_5 text-center align_center">
                Total Amount
            </th>
        </tr>
        </thead>

        <tbody>
        @php $i = 01; $tgross = $tqty = $rate = $ttlRate = $ttlSaleTax = $dis = $ttlDis = $amnt = $ttlAmnt = $ttlNetRate = $excluSaleTaxRate = $ttlExcluSaleTaxRate = $ttl_pro = $ttl_pro1 = $ttlDeductDis1 = $deductDis1 = $deductDis = 0; @endphp
        @foreach( $piims as $piim )
            @php
                $dis = $piim->poi_discount_amount;
                $ttlDis = +$dis + +$ttlDis;

                $amnt = $piim->poi_amount;
                $ttlAmnt = +$amnt + +$ttlAmnt;
            @endphp
            <tr class="even pointer">

                <td class="pur_in_wdth_1 align_center text-center">
                    {{ $i }}
                </td>


                <td class="pur_in_wdth_4 align_center text-center">
                    {!! $piim->poi_product_name !!}
                </td>

                <td class="pur_in_wdth_4 align_center text-center">
                    {!! $piim->poi_qty !!}
                </td>


                    @php
                        $tqty = +$tqty + +$piim->poi_qty;
                        $tgross = +$tgross + +$piim->poi_gross_amount;
                        $rate = $piim->poi_rate;
                        $excluSaleTaxRate = $rate * $piim->poi_qty;
                        $ttlExcluSaleTaxRate = +$excluSaleTaxRate + +$ttlExcluSaleTaxRate;
                        $ttlRate = +$rate + +$ttlRate;
                    @endphp
                    <td class="pur_in_wdth_4 align_center text-center">
                        {{ number_format($piim->poi_rate,2) }}
                    </td>

                <td class="pur_in_wdth_5 align_right text-right">
                    {!! number_format($piim->poi_gross_amount,2) !!}
                </td>
                <td class="pur_in_wdth_8 align_right text-right">
                    {{ $piim->poi_discount_per }}
                </td>

                <td class="pur_in_wdth_4 align_center text-center">
                    {!! $piim->poi_discount_amount	 !!}
                </td>

                    @php
                        $ttl_pro = $piim->poi_rate * $piim->poi_qty;
                        $deductDis = +$ttl_pro - +$piim->poi_discount_amount;
                        $ttlDeductDis1 = +$deductDis + +$ttlDeductDis1;

                    @endphp

                {{--                        $percent = (($deductDis * $piim->poi_saletax) / 100);--}}
                {{--                        $ttlSaleTax = +$percent + +$ttlSaleTax;--}}

{{--                    <td class="pur_in_wdth_8 align_right text-right">--}}
{{--                        {{ number_format($deductDis,2) }}--}}
{{--                    </td>--}}

{{--                    <td class="pur_in_wdth_6 align_center text-center">--}}
{{--                        {!! $piim->pii_saletax !!}--}}
{{--                    </td>--}}

{{--                    <td class="pur_in_wdth_7 align_center text-center">--}}
{{--                        {!! number_format($percent,2) !!}--}}
{{--                    </td>--}}
                <td class="pur_in_wdth_5 align_right text-right">
                    {!! number_format($piim->poi_amount,2) !!}
                </td>

            </tr>
            @php $i++; @endphp
        @endforeach
        <tr>
            <th colspan="2" class="text-right align_right">
                Total:-
            </th>
            <td class="text-right align_right">
                {{$tqty}}
            </td>


            <td class="text-right align_right">
{{--                {{ number_format($ttlExcluSaleTaxRate,2) }}--}}
            </td>

            <td class="text-right align_right">
                {{$tgross}}
            </td>

            <td class="text-right align_right">
                {{--                {{ number_format($ttlExcluSaleTaxRate,2) }}--}}
            </td>

                <td class="text-right align_right">
{{--                    {{ number_format($ttlDeductDis1,2) }}--}}
                    {{ number_format($ttlDis,2) }}

                </td>
{{--                <td class="text-right align_right">--}}

{{--                </td>--}}
{{--                <td class="text-center align_center">--}}
{{--                    {{ number_format($ttlSaleTax,2) }}--}}
{{--                </td>--}}
            <td class="text-right align_right">
                {{ number_format($ttlAmnt,2) }}
            </td>
        </tr>


        </tbody>
        <tfoot>
        <tr class="border-0">
            <td colspan="8" valign="top" class="p-0 border-0" >
                <table class="table m-0 p-0 chk_dmnd">
                    <tr>
{{--                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
{{--                            <table  class="m-0 p-0 table">--}}
{{--                                <tr>--}}
{{--                                    <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                        <label class="total-items-label text-right">Expense:-</label>--}}
{{--                                    </th>--}}
{{--                                    <td class="text-right fontS-12">--}}
{{--                                        {{ number_format($pim->pi_expense,2) }}--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                --}}{{----}}{{--                                    @if($pim->pi_invoice_type === 2)--}}
{{--                                --}}{{----}}{{--                                        <tr>--}}
{{--                                --}}{{----}}{{--                                            <td class="vi_tbl_hdng">--}}
{{--                                --}}{{----}}{{--                                                <label class="total-items-label text-right">Sale Tax:-</label>--}}
{{--                                --}}{{----}}{{--                                            </td>--}}
{{--                                --}}{{----}}{{--                                            <td class="text-right">--}}
{{--                                --}}{{----}}{{--                                                {{ number_format($pim->pi_sales_tax,2) }}--}}
{{--                                --}}{{----}}{{--                                            </td>--}}
{{--                                --}}{{----}}{{--                                        </tr>--}}
{{--                                --}}{{----}}{{--                                    @endif--}}
{{--                            </table>--}}
{{--                        </td>--}}
                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                            <table  class="m-0 p-0 table">
                                <tr>
                                    {{--                                        <th class="vi_tbl_hdng fontS-12">--}}
                                    {{--                                            <label class="total-items-label text-right">Balance Amount:-</label>--}}
                                    {{--                                        </th>--}}
                                    {{--                                        <td class="text-right fontS-12">--}}
                                    {{--                                            {{ +$pim->pi_grand_total - $pim->pi_cash_paid }}--}}
                                    {{--                                        </td>--}}
                                    <th class="vi_tbl_hdng fontS-12 text-right">
                                        <label class="total-items-label text-right">Discount (Rs):</label>
                                    </th>
                                    <td class="text-right fontS-12">
                                        {{ number_format($pim->po_product_discount,2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                            <table  class="m-0 p-0 table">
                                <tr>
                                    <th class="vi_tbl_hdng fontS-12 text-right">
                                        <label class="total-items-label text-right">Total Discount:</label>
                                    </th>
                                    <td class="text-right fontS-12">
                                        {{ number_format($pim->po_total_disc,2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                            <table  class="m-0 p-0 table">
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
                                        {{ number_format($pim->po_grand_total,2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>

{{--                        <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
{{--                            <table  class="m-0 p-0 table">--}}
{{--                                <tr>--}}
{{--                                    <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                        <label class="total-items-label text-right">Cash Paid:-</label>--}}
{{--                                    </th>--}}
{{--                                    <td class="text-right fontS-12">--}}
{{--                                        {{ number_format($pim->po_cash_paid,2) }}--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            </table>--}}
{{--                        </td>--}}
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="10" class="border-0 p-0">
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
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="10" class="border-0 p-0">
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
</div>

<div class="itm_vchr_rmrks">

    <a href="{{ route('po_items_view_details_pdf_SH',['id'=>$pim->po_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
        Download/Get PDF/Print
    </a>
</div>

<div class="clearfix"></div>
<div class="input_bx_ftr"></div>
