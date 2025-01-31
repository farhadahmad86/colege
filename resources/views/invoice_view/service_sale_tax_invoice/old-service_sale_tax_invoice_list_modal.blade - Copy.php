@extends('invoice_view.print_index')

@section('print_cntnt')

@php
    $company_info = Session::get('company_info');
@endphp

    <div id="" class="table-responsive" style="z-index: 9;">


        <table class="table table-sm m-0">

            @if($type === 'grid')
                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])
            @endif

            <tr class="bg-transparent" >
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
                    <p class="invoice_para m-0 pt-0">
                        <b> Remarks: </b>
                        {{ $sim->sesi_remarks }}
                    </p>
                </td>

                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Billed From
                    </h3>
                    <p class="invoice_para m-0 pt-0">
                        <b> Name: </b>
                        {{ (isset($sim->sesi_party_name) && !empty($sim->sesi_party_name)) ? $sim->sesi_party_name : 'N/A' }}
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

                <tr class="headings vi_tbl_hdng">
                    <th scope="col" align="center" class="tbl_srl_4 text-center align_center">
                        Sr.
                    </th>
                    <th scope="col" align="center" class="align_left text-left tbl_txt_20">
                        Product Name
                    </th>
                    <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                        QTY
                    </th>
                    <th class="align_center text-center tbl_amnt_8">
                        Rate
                    </th>
                    <th scope="col" align="center" class="text-center align_center tbl_amnt_12">
                        Excluded Discount
                    </th>
                    <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                        Dis.%
                    </th>
                    <th scope="col" align="center" class="text-center align_center tbl_amnt_12">
                        Included Dis.
                    </th>
                    <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                        Sale Tax%
                    </th>
                    <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                        Total Sales Tax Payable
                    </th>
                    <th scope="col" align="center" class="text-center align_center tbl_amnt_12">
                        Total Amount
                    </th>
                </tr>

            </thead>

            <tbody>
            @php $i = 01; $rate = $ttlRate = $ttlSaleTax = $dis = $ttlDis = $amnt = $ttlAmnt = $ttlNetRate = $excluSaleTaxRate = $ttlExcluSaleTaxRate = $ttl_pro = $ttl_pro1 = $ttlDeductDis1 = $deductDis1 = $deductDis = 0; @endphp
            @foreach( $siims as $siim )
                @php
                    $dis = $siim->discount;
                    $ttlDis = +$dis + +$ttlDis;

                    $amnt = $siim->amount;
                    $ttlAmnt = +$amnt + +$ttlAmnt;
                @endphp

                <tr class="even pointer">

                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>

                    <td class="align_left text-left tbl_txt_20">
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->name) !!}
                        @if(!empty($siim->remarks) && isset($siim->remarks))
                            <blockquote>
                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->remarks) !!}
                            </blockquote>
                        @endif
                    </td>
                    <td class="align_center text-center tbl_amnt_6">
                        {!! $siim->qty !!}
                    </td>

                    @php
                        $rate = $siim->rate;
                        $excluSaleTaxRate = $rate * $siim->qty;
                        $ttlExcluSaleTaxRate = +$excluSaleTaxRate + +$ttlExcluSaleTaxRate;
                        $ttlRate = +$rate + +$ttlRate;
                    @endphp
                    <td class="align_center text-center tbl_amnt_8">
                        {{ number_format($siim->rate,2) }}
                    </td>
                    <td class="align_right text-right tbl_amnt_12">
                        {{ number_format($excluSaleTaxRate,2) }}
                    </td>
                    <td class="align_center text-center tbl_amnt_8">
                        {!! $siim->discount !!}
                    </td>

                    @php
                        $ttl_pro = $siim->rate * $siim->qty;
                        $deductDis = (+$ttl_pro - +(($ttl_pro * +$siim->discount) / 100));
                        $ttlDeductDis1 = +$deductDis + +$ttlDeductDis1;
                        $percent = (($deductDis * $siim->sale_tax) / 100);
                        $ttlSaleTax = +$percent + +$ttlSaleTax;
                    @endphp

                    <td class="align_right text-right tbl_amnt_12">
                        {{ number_format($deductDis,2) }}
                    </td>
                    <td class="align_center text-center tbl_amnt_8">
                        {!! $siim->sale_tax !!}
                    </td>
                    <td class="align_right text-right tbl_amnt_10">
                        {!! number_format($percent,2) !!}
                    </td>
                    <td class="align_right text-right tbl_amnt_12">
                        {!! number_format($siim->amount,2) !!}
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
{{--                    {{ number_format($ttlDis,2) }}--}}
                </td>
                <td class="text-right align_right">
                    {{ number_format($ttlDeductDis1,2) }}
                </td>
                <td class="text-right align_right">
                </td>
                <td class="text-right align_right">
                    {{ number_format($ttlSaleTax,2) }}
                </td>
                <td class="text-right align_right">
                    {{ number_format($ttlAmnt,2) }}
                </td>
            </tr>


            </tbody>
            <tfoot>
                <tr class="border-0">
                    <td colspan="10" align="right" class="p-0 border-0">
                        <table class="table m-0 p-0 chk_dmnd">
                            <tr>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="m-0 p-0 table">
                                        <tr>
                                            <th class="vi_tbl_hdng fontS-12 text-right">
                                                <label class="total-items-label text-right">Expense:-</label>
                                            </th>
                                            <td class="text-right fontS-12">
                                                {{ number_format($sim->sesi_expense,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="m-0 p-0 table">
                                        <tr>
                                            <th class="vi_tbl_hdng fontS-12 text-right">
                                                <label class="total-items-label text-right">Trade Discount:</label>
                                            </th>
                                            <td class="text-right fontS-12">
                                                {{ number_format($sim->sesi_trade_disc,2) }}
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
                                                {{ number_format($sim->sesi_total_discount,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="m-0 p-0 table">
                                        <tr>
                                            <th class="vi_tbl_hdng fontS-12 text-right">
                                                <label class="total-items-label text-right">Grand Total:-</label>
                                            </th>
                                            <td class="text-right fontS-12">
                                                {{ number_format($sim->sesi_grand_total,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="m-0 p-0 table">
                                        <tr>
                                            <th class="vi_tbl_hdng fontS-12 text-right">
                                                <label class="total-items-label text-right">Cash Paid:-</label>
                                            </th>
                                            <td class="text-right fontS-12">
                                                {{ number_format($sim->cash_received,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
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

@if( $type === 'grid')
    <div class="itm_vchr_rmrks">

        <a href="{{ route('services_tax_items_view_details_pdf_SH',['id'=>$sim->sesi_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Download/Get PDF/Print
        </a>
    </div>

    <div class="clearfix"></div>
    <div class="input_bx_ftr"></div>
@endif

@endsection
