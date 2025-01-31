
@php
    $company_info = Session::get('company_info');
@endphp
    <div id="" class="table-responsive" style="z-index: 9;">



        <table class="table table-bordered table-sm" style="background-image: url({{ asset('public/vendors/images/invoice_background.png') }}); background-repeat: no-repeat;background-position: left top;-webkit-background-size: 100% auto;background-size: 100% auto;">

            <tr class="bg-transparent">
                <td colspan="2" class="p-0 border-0" >
                    <img src="{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_logo : 'No Company Record'}}" alt="Company Logo" width="140" />
                </td>
                <td colspan="{{ ($sim->sei_invoice_type === 1) ? '6' : '4' }}" class="p-0 border-0 text-right" >
                    <h2 class="invoice_hdng">
                        Services Invoice
                    </h2>
                    <p class="invoice_para m-0">
                        <b> Invoice #: </b>
                        {{ $sim->sei_id }}
                    </p>
                    <p class="invoice_para m-0 pt-5">
                        <b> Date: </b>
                        {{date('d-M-y', strtotime(str_replace('/', '-', $sim->sei_day_end_date)))}}
                    </p>
                </td>
            </tr>

            <tr>
                <td colspan="{{ ($sim->sei_invoice_type === 1) ? '6' : '4' }}"  class="p-0 border-0">
                    <table class="table p-0 m-0 bg-transparent" >
                        <tr class="bg-transparent" >
                            <td colspan="3"  class="p-0 border-0">
                                <h3 class="invoice_sub_hdng mb-0 mt-10">
                                    Billed {{ $sim->sei_status == 'SALE' ? 'From' : 'To' }}
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
                                    {{ $sim->sei_remarks }}
                                </p>
                            </td>
                            <td colspan="1"  class="p-0 border-0">
                                <p class="invoice_para m-0 pt-5 max_txt"></p>
                            </td>
                            <td colspan="3"  class="p-0 border-0">
                                <h3 class="invoice_sub_hdng mb-0 mt-0">
                                    Billed
                                    {{ $sim->sei_status == 'RETURN' ? 'From' : 'To' }}
                                </h3>
                                <p class="invoice_para m-0 pt-5">
                                    <b> Name: </b>
                                    {{ (isset($sim->{'sei_party_name'}) && !empty($sim->{'sei_party_name'})) ? $sim->{'sei_party_name'} : 'N/A' }}
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

{{--                    <th scope="col" align="left" class="align_left text-left {{ ($sim->sei_invoice_type === 1) ? 'pur_in_wdth_2' : 'pur_in_wdth_3' }}">--}}
                    <th scope="col" align="left" class="align_left text-left pur_in_wdth_3">
                        Service Name
                    </th>

                    <th scope="col" align="center" class="pur_in_wdth_4 text-center align_center">
                        QTY
                    </th>

                    <th scope="col" align="center" class="pur_in_wdth_4 align_center text-center">
                        Rate
                    </th>

                    <th scope="col" align="center" class="pur_in_wdth_8 text-center align_center">
{{--                        Excluded {{ ($sim->sei_invoice_type === 1) ? 'Service Tax' : 'Discount' }}--}}
                    </th>

                    <th scope="col" align="center" class="pur_in_wdth_4 text-center align_center">
                        Dis.
                    </th>

{{--                    @if($sim->sei_invoice_type === 1)--}}
{{--                        <th scope="col" align="center" class="pur_in_wdth_8 text-center align_center">--}}
{{--                            Included Dis.--}}
{{--                        </th>--}}

{{--                        <th scope="col" align="center" class="pur_in_wdth_6 text-center align_center">--}}
{{--                            Service Tax%--}}
{{--                        </th>--}}

{{--                        <th scope="col" align="center" class="pur_in_wdth_7 text-center align_center">--}}
{{--                            Total Ser. Tax Payable--}}
{{--                        </th>--}}
{{--                    @endif--}}

                    <th scope="col" align="center" class="pur_in_wdth_5 text-center align_center">
                        Total Amount
                    </th>
                </tr>
            </thead>

            <tbody>
            @php $i = 01; $rate = $ttlRate = $ttlSaleTax = $dis = $ttlDis = $amnt = $ttlAmnt = $ttlNetRate = $excluSaleTaxRate = $ttlExcluSaleTaxRate = $ttl_pro = $ttl_pro1 = $ttlDeductDis1 = $deductDis1 = $deductDis = 0; @endphp
            @foreach( $siims as $siim )
                @php
                    $dis = $siim->seii_discount;
                    $ttlDis = +$dis + +$ttlDis;

                    $amnt = $siim->seii_amount;
                    $ttlAmnt = +$amnt + +$ttlAmnt;
                @endphp

                <tr class="even pointer">

                    <td class="pur_in_wdth_1 align_center text-center">
                        {{ $i }}
                    </td>

                    <td class="align_left text-left {{ ($sim->sei_invoice_type === 1) ? 'pur_in_wdth_2' : 'pur_in_wdth_3' }}">
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->seii_service_name) !!}
                        @if(!empty($siim->seii_remarks) && isset($siim->seii_remarks))
                            <blockquote>
                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->seii_remarks) !!}

                            </blockquote>
                        @endif
                    </td>

                    <td class="pur_in_wdth_4 align_center text-center">
                        {!! $siim->seii_qty !!}
                    </td>


                    @php
                        $rate = $siim->seii_rate;
                        $excluSaleTaxRate = $rate * $siim->seii_qty;
                        $ttlExcluSaleTaxRate = +$excluSaleTaxRate + +$ttlExcluSaleTaxRate;
                        $ttlRate = +$rate + +$ttlRate;
                    @endphp
                    <td class="pur_in_wdth_4 align_center text-center">
                        {{ number_format($siim->seii_rate,2) }}
                    </td>

                    <td class="pur_in_wdth_8 align_right text-right">
                        {{ number_format($excluSaleTaxRate,2) }}
                    </td>

                    <td class="pur_in_wdth_4 align_center text-center">
                        {!! $siim->seii_discount !!}
                    </td>

                    @if($sim->sei_invoice_type === 1)
                        @php
                            $ttl_pro = $siim->seii_rate * $siim->seii_qty;
                            $deductDis = +$ttl_pro - +$siim->seii_discount;
                            $ttlDeductDis1 = +$deductDis + +$ttlDeductDis1;
                            $percent = (($deductDis * $siim->seii_saletax) / 100);
                            $ttlSaleTax = +$percent + +$ttlSaleTax;
                        @endphp
                        <td class="pur_in_wdth_8 align_right text-right">
                            {{ number_format($deductDis,2) }}
                        </td>
                        <td class="pur_in_wdth_6 align_center text-center">
                            {!! $siim->seii_saletax !!}
                        </td>
                        <td class="pur_in_wdth_7 align_center text-center">
                            {!! number_format($percent,2) !!}
                        </td>
                    @endif

                    <td class="pur_in_wdth_5 align_right text-right">
                        {!! number_format($siim->seii_amount,2) !!}
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
                <td class="text-center align_center">

                </td>

                <td class="text-right align_right">
                    {{ number_format($ttlExcluSaleTaxRate,2) }}
                </td>

                <td class="text-center align_center">
                    {{ number_format($ttlDis,2) }}
                </td>

                @if($sim->sei_invoice_type === 1)

                    <td class="text-right align_right">
                        {{ number_format($ttlDeductDis1,2) }}
                    </td>
                    <td class="text-right align_right">

                    </td>
                    <td class="text-center align_center">
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
                    <td colspan="{{ ($sim->sei_invoice_type === 1) ? '10' : '7' }}" align="right" class="p-0 border-0">
                        <table class="table m-0 p-0 chk_dmnd">
                            <tr>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="m-0 p-0 table">
                                        <tr>
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="vi_tbl_hdng total-items-label text-right">Expense:-</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($sim->sei_expense,2) }}
                                            </td>
                                        </tr>
                                        {{--                                    @if($sim->sei_invoice_type === 1)--}}
                                        {{--                                        <tr>--}}
                                        {{--                                            <td class="vi_tbl_hdng">--}}
                                        {{--                                                <label class="total-items-label text-right">Sale Tax:-</label>--}}
                                        {{--                                            </td>--}}
                                        {{--                                            <td class="text-right">--}}
                                        {{--                                                {{ number_format($sim->sei_sales_tax,2) }}--}}
                                        {{--                                            </td>--}}
                                        {{--                                        </tr>--}}
                                        {{--                                    @endif--}}
                                    </table>
                                </td>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="m-0 p-0 table">
                                        <tr>
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="vi_tbl_hdng total-items-label text-right">Trade Discount:</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($sim->sei_trade_disc,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="m-0 p-0 table">
                                        <tr>
                                            {{--                                        <th class="vi_tbl_hdng">--}}
                                            {{--                                            <label class="total-items-label text-right">Balance Amount:-</label>--}}
                                            {{--                                        </th>--}}
                                            {{--                                        <td class="text-right">--}}
                                            {{--                                            {{ +$sim->sei_grand_total - $sim->sei_cash_paid }}--}}
                                            {{--                                        </td>--}}
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="vi_tbl_hdng total-items-label text-right">Total Discount:</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($sim->sei_total_discount,2) }}
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
                                        {{--                                            {{$sim->sei_total_price !=0 ? number_format($sim->sei_total_price,2):'0'}}--}}
                                        {{--                                        </td>--}}
                                        {{--                                    </tr>--}}
                                        <tr>
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="vi_tbl_hdng total-items-label text-right">Grand Total:-</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($sim->sei_grand_total,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="m-0 p-0 table">
                                        <tr>
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="vi_tbl_hdng total-items-label text-right">Cash Paid:-</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($sim->sei_cash_paid,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="{{ ($sim->sei_invoice_type === 1) ? '10' : '7' }}" class="border-0 p-0">
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
                    <td colspan="{{ ($sim->sei_invoice_type === 1) ? '10' : '7' }}" class="border-0 p-0">
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

        <a href="{{ route('services_items_view_details_pdf_SH',['id'=>$sim->sei_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Download/Get PDF/Print
        </a>
    </div>

    <div class="clearfix"></div>
    <div class="input_bx_ftr"></div>
