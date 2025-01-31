@php
    $company_info = Session::get('company_info');
@endphp
    <div id="printingSection" class="table-responsive" style="z-index: 9;">
        <table class="table table-bordered table-sm">
            @php
                $invoice_nbr = $sim->si_id;
                $invoice_date = $sim->si_day_end_date;
            @endphp
            @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])


{{--            <tr>--}}
{{--                <td colspan="{{ ($sim->si_invoice_type === 2 || $sim->si_invoice_type === 3) ? '8' : '6' }}"  class="p-0 border-0">--}}
{{--                    <table class="table table-bordered table-sm" >--}}

                <tr class="bg-transparent" >
                    <td class="wdth_40_prcnt p-0 border-0">
                        <h3 class="invoice_sub_hdng mb-0">
                            Billed From
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
                        <p class="invoice_para m-0 pt-0">
                            <b> Remarks: </b>
                            {{ $sim->si_remarks }}
                        </p>
                    </td>

                    <td class="wdth_40_prcnt p-0 border-0">
                        <h3 class="invoice_sub_hdng mb-0 mt-0">
                            Billed
                            {{ $sim->si_status == 'RETURN' ? 'From' : 'To' }}
                        </h3>
                        <p class="invoice_para m-0 pt-0">
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


        <table class="table table-bordered table-sm">
            <thead>

                <tr class="headings vi_tbl_hdng">
                    <th scope="col"  class="tbl_srl_4 text-center ">
                        Sr.
                    </th>
                    <th scope="col"  class="align_left text-left {{ ($sim->si_invoice_type === 2) ? 'pur_in_wdth_2' : 'pur_in_wdth_3' }}">
                        Product Name
                    </th>
                    <th scope="col"  class="pur_in_wdth_4 text-center ">
                        QTY
                    </th>

                    @if($sim->si_invoice_type === 1)
                        <th scope="col"  class="pur_in_wdth_4 text-center ">
                            Net Rate
                        </th>
                    @endif

                    @if($sim->si_invoice_type !== 1)
                        <th class="pur_in_wdth_4  text-center">
                            Rate
                        </th>
                    @endif

                    <th scope="col"  class="pur_in_wdth_8 text-center ">
                        Excluded {{ ($sim->si_invoice_type === 2) ? 'Sale Tax' : 'Discount' }}
                    </th>

                    <th scope="col"  class="pur_in_wdth_4 text-center ">
                        Dis.
                    </th>

                    @if($sim->si_invoice_type === 2 || $sim->si_invoice_type === 3)
                        <th scope="col"  class="pur_in_wdth_8 text-center ">
                            Included Dis.
                        </th>

                        <th scope="col"  class="pur_in_wdth_6 text-center ">
                            Sale Tax%
                        </th>

                        <th scope="col"  class="pur_in_wdth_7 text-center ">
                            Total Sales Tax Payable
                        </th>
                    @endif
                    <th scope="col"  class="pur_in_wdth_5 text-center ">
                        Total Amount
                    </th>
                </tr>

            </thead>

            <tbody>
            @php $i = 01; $rate = $ttlRate = $ttlSaleTax = $dis = $ttlDis = $amnt = $ttlAmnt = $ttlNetRate = $excluSaleTaxRate = $ttlExcluSaleTaxRate = $ttl_pro = $ttl_pro1 = $ttlDeductDis1 = $deductDis1 = $deductDis = 0; @endphp
            @foreach( $siims as $siim )
                @php
                    $dis = $siim->sii_discount;
                    $ttlDis = +$dis + +$ttlDis;

                    $amnt = $siim->sii_amount;
                    $ttlAmnt = +$amnt + +$ttlAmnt;
                @endphp

                <tr class="even pointer">

                    <td class="pur_in_wdth_1  text-center">
                        {{ $i }}
                    </td>

                    <td class="align_left text-left {{ ($sim->si_invoice_type === 2) ? 'pur_in_wdth_2' : 'pur_in_wdth_3' }}">
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->sii_product_name) !!}
                        @if(!empty($siim->sii_remarks) && isset($siim->sii_remarks))
                            <blockquote>
                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->sii_remarks) !!}
                            </blockquote>
                        @endif
                    </td>

                    <td class="pur_in_wdth_4  text-center">
                        {!! $siim->sii_qty !!}
                    </td>

                    @if($sim->si_invoice_type === 1)
                        @php
                            $percent = (($siim->sii_rate * $siim->sii_saletax) / 100);
                            $net_rate = +$siim->sii_rate + +$percent;
                            $excluSaleTaxRate = $net_rate * $siim->sii_qty;
                            $ttlExcluSaleTaxRate = +$excluSaleTaxRate + +$ttlExcluSaleTaxRate;
                            $ttlNetRate = +$net_rate + +$ttlNetRate;
                        @endphp
                        <td class="pur_in_wdth_4  text-center">
                            {{ $net_rate }}
                        </td>
                    @endif

                    @if($sim->si_invoice_type !== 1)
                        @php
                            $rate = $siim->sii_rate;
                            $excluSaleTaxRate = $rate * $siim->sii_qty;
                            $ttlExcluSaleTaxRate = +$excluSaleTaxRate + +$ttlExcluSaleTaxRate;
                            $ttlRate = +$rate + +$ttlRate;
                        @endphp
                        <td class="pur_in_wdth_4  text-center">
                            {{ number_format($siim->sii_rate,2) }}
                        </td>
                    @endif

                    <td class="pur_in_wdth_8 align_right text-right">
                        {{ number_format($excluSaleTaxRate,2) }}
                    </td>

                    <td class="pur_in_wdth_4  text-center">
                        {!! $siim->sii_discount !!}
                    </td>

                    @if($sim->si_invoice_type === 2 || $sim->si_invoice_type === 3)
                        @php
                            $ttl_pro = $siim->sii_rate * $siim->sii_qty;
                            $deductDis = +$ttl_pro - +$siim->sii_discount;
                            $ttlDeductDis1 = +$deductDis + +$ttlDeductDis1;
                            $percent = (($deductDis * $siim->sii_saletax) / 100);
                            $ttlSaleTax = +$percent + +$ttlSaleTax;
                        @endphp

                        <td class="pur_in_wdth_8 align_right text-right">
                            {{ number_format($deductDis,2) }}
                        </td>
                        <td class="pur_in_wdth_6  text-center">
                            {!! $siim->sii_saletax !!}
                        </td>
                        <td class="pur_in_wdth_7  text-center">
                            {!! number_format($percent,2) !!}
                        </td>
                    @endif

                    <td class="pur_in_wdth_5 align_right text-right">
                        {!! number_format($siim->sii_amount,2) !!}
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
                @if($sim->si_invoice_type === 1)
                    <td class="text-center ">
                    </td>
                @endif
                @if($sim->si_invoice_type !== 1)
                    <td class="text-center ">
                    </td>
                @endif

                <td class="text-right align_right">
                    {{ number_format($ttlExcluSaleTaxRate,2) }}
                </td>

                <td class="text-center ">
                    {{ number_format($ttlDis,2) }}
                </td>

                @if($sim->si_invoice_type === 2)

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
                    <td colspan="{{ ($sim->si_invoice_type === 2 || $sim->si_invoice_type === 3) ? '10' : '7' }}" align="right" class="p-0 border-0">
                        <table class="table table-bordered table-sm chk_dmnd">
                            <tr>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="table table-bordered table-sm">
                                        <tr>
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="total-items-label text-right">Expense:-</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($sim->si_expense,2) }}
                                            </td>
                                        </tr>
                                        {{--                                    @if($sim->si_invoice_type === 2)--}}
                                        {{--                                        <tr>--}}
                                        {{--                                            <td class="vi_tbl_hdng">--}}
                                        {{--                                                <label class="total-items-label text-right">Sale Tax:-</label>--}}
                                        {{--                                            </td>--}}
                                        {{--                                            <td class="text-right">--}}
                                        {{--                                                {{ number_format($sim->si_sales_tax,2) }}--}}
                                        {{--                                            </td>--}}
                                        {{--                                        </tr>--}}
                                        {{--                                    @endif--}}
                                    </table>
                                </td>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="table table-bordered table-sm">
                                        <tr>
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="total-items-label text-right">Trade Discount:</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($sim->si_trade_disc,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="table table-bordered table-sm">
                                        <tr>
                                            {{--                                        <th class="vi_tbl_hdng">--}}
                                            {{--                                            <label class="total-items-label text-right">Balance Amount:-</label>--}}
                                            {{--                                        </th>--}}
                                            {{--                                        <td class="text-right">--}}
                                            {{--                                            {{ +$sim->si_grand_total - $sim->si_cash_paid }}--}}
                                            {{--                                        </td>--}}
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="total-items-label text-right">Total Discount:</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($sim->si_total_discount,2) }}
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
                                        {{--                                            {{$sim->si_total_price !=0 ? number_format($sim->si_total_price,2):'0'}}--}}
                                        {{--                                        </td>--}}
                                        {{--                                    </tr>--}}
                                        <tr>
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="total-items-label text-right">Grand Total:-</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($sim->si_grand_total,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="table table-bordered table-sm">
                                        <tr>
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="total-items-label text-right">Cash Paid:-</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($sim->si_cash_paid,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="{{ ($sim->si_invoice_type === 2) ? '10' : '7' }}" class="border-0 p-0">
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
                    <td colspan="{{ ($sim->si_invoice_type === 2) ? '10' : '7' }}" class="border-0 p-0">
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

        <a href="{{ route('sale_items_view_details_pdf_sh',['id'=>$sim->si_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Download/Get PDF/Print
        </a>


    </div>

    <div class="clearfix"></div>
    <div class="input_bx_ftr"></div>

