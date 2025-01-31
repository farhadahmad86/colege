@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp

    <div id="" class="table-responsive" style="z-index: 9;">


        <table class="table table-bordered m-0">

            @if($type === 'grid')
                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])
            @endif


            {{--            <tr>--}}
            {{--                <td colspan="{{ ($sim->si_invoice_type === 2 || $sim->si_invoice_type === 3) ? '8' : '6' }}"  class="p-0 border-0">--}}
            {{--                    <table class="table p-0 m-0 bg-transparent" >--}}

            <tr class="bg-transparent" >
                <td class="wdth_50_prcnt p-0 border-0">
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
                        {{ $sim->grn_remarks }}
                    </p>
                </td>

                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Billed To
                    </h3>
                    <p class="invoice_para m-0 pt-0">
                        <b> Name: </b>
                        {{ (isset($sim->grn_party_name) && !empty($sim->grn_party_name)) ? $sim->grn_party_name : 'N/A' }}
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
                <th scope="col"  class="tbl_srl_4">
                    Sr.
                </th>
                <th scope="col"  class="align_left text-left tbl_txt_50">
                    Product Name
                </th>

                <th scope="col"  class=" tbl_amnt_13">
                    QTY
                </th>
                <th class=" tbl_amnt_13">
                    Due QTY
                </th>
{{--                <th scope="col"  class=" tbl_amnt_8">--}}
{{--                    Bonus--}}
{{--                </th>--}}
                <th scope="col"  class=" tbl_amnt_20">
                    Purchase Invoice
                </th>

            </tr>

            </thead>

            <tbody>
            @php
                $i = 01; $excluProDis = $ttlExcluProDis = $ttlIncluProDis = $ttlSaleProTax = $ttlProAmnt = 0;
            @endphp

            @foreach( $siims as $siim )
                @php
                    /* $excluProDis = $siim->qty * $siim->rate;
                     $ttlExcluProDis = +$excluProDis + +$ttlExcluProDis;
                     $ttlIncluProDis = +$siim->after_discount + +$ttlIncluProDis;
                     //$ttlSaleProTax = +$ttlSaleProTax + +$siim->sale_tax_amount;
                     $ttlProAmnt = +$ttlProAmnt + +$siim->amount;*/
                @endphp

                <tr class="even pointer">

                    <th>
                        {{ $i }}
                    </th>
                    <td>
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->name) !!}
                        @if(!empty($siim->remarks) && isset($siim->remarks))
                            <blockquote>
                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->remarks) !!}
                            </blockquote>
                        @endif
                    </td>
                    {{--                    <td class="tbl_amnt_15 ">--}}
                    {{--                        {!! $siim->remarks !!}--}}
                    {{--                    </td>--}}
                    <td>
                        {!! $siim->qty !!}
                    </td>
                    <td>
                        {{ $siim->due_qty }}
                    </td>
{{--                    <td class="tbl_amnt_8 align_right text-right">--}}
{{--                        {{ $siim->bonus }}--}}
{{--                    </td>--}}
                    <td>
                        {!! $siim->status !!}
                    </td>


                </tr>
                @php $i++; @endphp
            @endforeach
            <tr>
                <th colspan="2" class="text-right align_right">
                    Total:-
                </th>
                <td class="">
                    {{ number_format($sim->grn_total_items,3) }}
                </td>
                <td class="">
                </td>
                <td class="text-right align_right">

                </td>

            </tr>


            </tbody>
            <tfoot>
            {{--            <tr class="border-0">--}}
            {{--                <td colspan="10" align="right" class="p-0 border-0">--}}
            {{--                    <table class="table m-0 p-0 chk_dmnd">--}}
            {{--                        <tr>--}}
            {{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
            {{--                                <table  class="m-0 p-0 table">--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Product Discount:--}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            --}}{{--                                                {{ number_format($sim->ssi_product_disc,2) }}--}}
            {{--                                            {{ number_format($mainTtlProDis,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Inclusive Sales Tax:--}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            --}}{{--                                                {{ number_format($sim->ssi_inclusive_sales_tax,2) }}--}}
            {{--                                            {{ number_format($si_inclusive_sales_tax,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Services Inclusive Sales Tax:--}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            --}}{{--                                                {{ number_format($seim->sesi_inclusive_sales_tax,2) }}--}}
            {{--                                            {{ number_format($sei_inclusive_sales_tax,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}

            {{--                                </table>--}}
            {{--                            </td>--}}
            {{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
            {{--                                <table  class="m-0 p-0 table">--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Round off Discount:--}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            --}}{{--                                                {{ number_format($sim->ssi_round_off_disc,2) }}--}}
            {{--                                            {{ number_format($mainTtlRoundDis,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Exclusive Sales Tax:--}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            {{ number_format($si_exclusive_sales_tax,2) }}--}}
            {{--                                            --}}{{--                                                {{ number_format($sim->ssi_exclusive_sales_tax,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Services Exclusive Sales Tax:--}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            {{ number_format($sei_exclusive_sales_tax,2) }}--}}
            {{--                                            --}}{{--                                                {{ number_format($seim->sesi_exclusive_sales_tax,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                </table>--}}
            {{--                            </td>--}}
            {{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
            {{--                                <table  class="m-0 p-0 table">--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Cash Discount:--}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            --}}{{--                                                {{ number_format($sim->ssi_cash_disc_amount,2) }}--}}
            {{--                                            {{ number_format($mainTtlCashDis,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Total Sales Tax:--}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            {{ number_format($si_total_sales_tax,2) }}--}}
            {{--                                            --}}{{--                                                {{ number_format($sim->ssi_total_sales_tax,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Services Total Sales Tax:--}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            --}}{{--                                                {{ number_format($seim->sesi_total_sales_tax,2) }}--}}
            {{--                                            {{ number_format($sei_total_sales_tax,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                </table>--}}
            {{--                            </td>--}}
            {{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
            {{--                                <table  class="m-0 p-0 table">--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Total Discount:--}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            --}}{{--                                                {{ number_format($sim->ssi_total_discount,2) }}--}}
            {{--                                            {{ number_format($mainTtlDis,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Grand Total:---}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            --}}{{--                                                {{ number_format($sim->ssi_grand_total,2) }}--}}
            {{--                                            {{ number_format($mainGrndTtl,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                    <tr>--}}
            {{--                                        <th class="vi_tbl_hdng text-right">--}}
            {{--                                            <label class="total-items-label text-right">--}}
            {{--                                                Cash Paid:---}}
            {{--                                            </label>--}}
            {{--                                        </th>--}}
            {{--                                        <td class="text-right">--}}
            {{--                                            {{ number_format($sim->si_cash_paid,2) }}--}}
            {{--                                        </td>--}}
            {{--                                    </tr>--}}
            {{--                                </table>--}}
            {{--                            </td>--}}
            {{--                        </tr>--}}
            {{--                    </table>--}}
            {{--                </td>--}}
            {{--            </tr>--}}
            {{--            <tr>--}}
            {{--                <td colspan="10" class="border-0 p-0">--}}
            {{--                    <div class="wrds_con">--}}
            {{--                        <div class="wrds_bx">--}}
            {{--                    <span class="wrds_hdng">--}}
            {{--                        In Words--}}
            {{--                    </span>--}}
            {{--                            {{ $nbrOfWrds }} ONLY--}}
            {{--                        </div>--}}
            {{--                        <div class="wrds_bx wrds_bx_two">--}}
            {{--                    <span class="wrds_hdng">--}}
            {{--                        Receipient Sign.--}}
            {{--                    </span>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </td>--}}
            {{--            </tr>--}}

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

            <a href="{{ route('goods_receipt_note_items_view_details_pdf_SH',['id'=>$sim->grn_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download
            </a>

            <iframe style="display: none" id="printf" name="printf" src="{{ route('goods_receipt_note_items_view_details_pdf_SH',['id'=>$sim->grn_id]) }}" title="W3Schools Free Online Web Tutorials">Iframe
            </iframe>


            <a href="#" id="printi" onclick="PrintFrame()" class="ml-2 align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Print
            </a>

        </div>

{{--        <div class="itm_vchr_rmrks">--}}

{{--            <a href="{{ route('goods_receipt_note_items_view_details_pdf_SH',['id'=>$sim->grn_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">--}}
{{--                Download/Get PDF/Print--}}
{{--            </a>--}}
{{--        </div>--}}

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
