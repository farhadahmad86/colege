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
                        {{ $seim->sesi_remarks }}
                    </p>
                </td>

                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Billed From
                    </h3>
                    <p class="invoice_para m-0 pt-0">
                        <b> Name: </b>
                        {{ (isset($seim->sesi_party_name) && !empty($seim->sesi_party_name)) ? $seim->sesi_party_name : 'N/A' }}
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
                <th scope="col"  class="tbl_srl_4 text-center ">
                    Sr.
                </th>
                <th scope="col"  class="align_left text-left tbl_txt_20">
                    Product Name
                </th>
                <th scope="col"  class="text-center  tbl_amnt_6">
                    QTY
                </th>
                <th class=" text-center tbl_amnt_8">
                    Rate
                </th>
                <th scope="col"  class="text-center  tbl_amnt_12">
                    Excluded Discount
                </th>
                <th scope="col"  class="text-center  tbl_amnt_8">
                    Dis.%
                </th>
                <th scope="col"  class="text-center  tbl_amnt_12">
                    Included Dis.
                </th>
                <th scope="col"  class="text-center  tbl_amnt_8">
                    Sale Tax%
                </th>
                <th scope="col"  class="text-center  tbl_amnt_10">
                    Total Sales Tax Payable
                </th>
                <th scope="col"  class="text-center  tbl_amnt_12">
                    Total Amount
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

            $ssi_product_disc = (isset($sim->ssi_product_disc) && !empty($sim->ssi_product_disc)) ? $sim->ssi_product_disc : 0;
            $ssi_round_off_disc = (isset($sim->ssi_round_off_disc) && !empty($sim->ssi_round_off_disc)) ? $sim->ssi_round_off_disc : 0;
            $ssi_cash_disc_amount = (isset($sim->ssi_cash_disc_amount) && !empty($sim->ssi_cash_disc_amount)) ? $sim->ssi_cash_disc_amount : 0;
            $ssi_total_discount = (isset($sim->ssi_total_discount) && !empty($sim->ssi_total_discount)) ? $sim->ssi_total_discount : 0;

            $sesi_product_disc = (isset($seim->sesi_product_disc) && !empty($seim->sesi_product_disc)) ? $seim->sesi_product_disc : 0;
            $sesi_round_off_disc = (isset($seim->sesi_round_off_disc) && !empty($seim->sesi_round_off_disc)) ? $seim->sesi_round_off_disc : 0;
            $sesi_cash_disc_amount = (isset($seim->sesi_cash_disc_amount) && !empty($seim->sesi_cash_disc_amount)) ? $seim->sesi_cash_disc_amount : 0;
            $sesi_total_discount = (isset($seim->sesi_total_discount) && !empty($seim->sesi_total_discount)) ? $seim->sesi_total_discount : 0;

            $mainTtlProDis = +$ssi_product_disc + +$sesi_product_disc;
            $mainTtlRoundDis = +$ssi_round_off_disc + +$sesi_round_off_disc;
            $mainTtlCashDis = +$ssi_cash_disc_amount + +$sesi_cash_disc_amount;
            $mainTtlDis = +$sesi_total_discount + +$ssi_total_discount;

            //=========== discount section end ==============

            //=========== Sale Tax section start ==============

            $ssi_inclusive_sales_tax = (isset($sim->ssi_inclusive_sales_tax) && !empty($sim->ssi_inclusive_sales_tax)) ? $sim->ssi_inclusive_sales_tax : 0;
            $ssi_exclusive_sales_tax = (isset($sim->ssi_exclusive_sales_tax) && !empty($sim->ssi_exclusive_sales_tax)) ? $sim->ssi_exclusive_sales_tax : 0;
            $ssi_total_sales_tax = (isset($sim->ssi_total_sales_tax) && !empty($sim->ssi_total_sales_tax)) ? $sim->ssi_total_sales_tax : 0;

            //=========== Sale Tax section end ==============

            //=========== Services Sale Tax section start ==============

            $sesi_inclusive_sales_tax = (isset($seim->sesi_inclusive_sales_tax) && !empty($seim->sesi_inclusive_sales_tax)) ? $seim->sesi_inclusive_sales_tax : 0;
            $sesi_exclusive_sales_tax = (isset($seim->sesi_exclusive_sales_tax) && !empty($seim->sesi_exclusive_sales_tax)) ? $seim->sesi_exclusive_sales_tax : 0;
            $sesi_total_sales_tax = (isset($seim->sesi_total_sales_tax) && !empty($seim->sesi_total_sales_tax)) ? $seim->sesi_total_sales_tax : 0;

            //=========== Services Sale Tax section end ==============


            $ssi_grand_total = (isset($sim->ssi_grand_total) && !empty($sim->ssi_grand_total)) ? $sim->ssi_grand_total : 0;
            $sesi_grand_total = (isset($seim->sesi_grand_total) && !empty($seim->sesi_grand_total)) ? $seim->sesi_grand_total : 0;

            $mainGrndTtl = +$ssi_grand_total + +$sesi_grand_total;



            @endphp

            @foreach( $siims as $siim )
                @php
                    $excluProDis = $siim->qty * $siim->rate;
                    $ttlExcluProDis = +$excluProDis + +$ttlExcluProDis;
                    $ttlIncluProDis = +$siim->after_discount + +$ttlIncluProDis;
                    //if($siim->inclu_exclu !== 1){
                        //$ttlSaleProTax = +$ttlSaleProTax + +$siim->sale_tax_amount;
                    //}

                    $ttlProAmnt = +$ttlProAmnt + +$siim->amount;
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
                    <td>
                        {!! $siim->qty !!}
                    </td>
                    <td>
                        {{ number_format($siim->rate,2) }}
                    </td>
                    <td class="align_right text-right">
                        {{ number_format($excluProDis,2) }}
                    </td>
                    <td class=" text-center tbl_amnt_8">
                        {!! $siim->discount !!}
                    </td>
                    <td class="align_right text-right tbl_amnt_12">
                        {{ number_format($siim->after_discount,2) }}
                    </td>
                    <td>
                        {!! $siim->sale_tax !!}
                    </td>
                    <td class="align_right text-right">
                        {{ ($siim->inclu_exclu === 1) ? "(In)=" : "(Ex)=" }}{!! number_format($siim->sale_tax_amount,2) !!}
                    </td>
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
                <td class="text-right align_right">
                </td>
                <td class="text-center ">
                </td>
                <td class="text-right align_right">
                    {{ number_format($ttlExcluProDis,2) }}
                </td>
                <td class="text-center ">
                    {{--                    {{ number_format($ttlDis,2) }}--}}
                </td>
                <td class="text-right align_right">
                    {{ number_format($ttlIncluProDis,2) }}
                </td>
                <td class="text-right align_right">
                </td>
                <td class="text-right align_right">
                    @php
                        $ttlSaleProTax = +$ssi_total_sales_tax + +$sesi_total_sales_tax;
                    @endphp
                    {{ number_format($ttlSaleProTax,2) }}
                </td>
                <td class="text-right align_right">
                    {{ number_format($ttlProAmnt,2) }}
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
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Product Discount:
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                                {{ number_format($sim->ssi_product_disc,2) }}--}}
                                            {{ number_format($mainTtlProDis,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Inclusive Sales Tax:
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                                {{ number_format($sim->ssi_inclusive_sales_tax,2) }}--}}
                                            {{ number_format($ssi_inclusive_sales_tax,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Services Inclusive Sales Tax:
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                                {{ number_format($seim->sesi_inclusive_sales_tax,2) }}--}}
                                            {{ number_format($sesi_inclusive_sales_tax,2) }}
                                        </td>
                                    </tr>

                                </table>
                            </td>
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table  class="m-0 p-0 table">
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Round off Discount:
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                                {{ number_format($sim->ssi_round_off_disc,2) }}--}}
                                            {{ number_format($mainTtlRoundDis,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Exclusive Sales Tax:
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{ number_format($ssi_exclusive_sales_tax,2) }}
                                            {{--                                                {{ number_format($sim->ssi_exclusive_sales_tax,2) }}--}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Services Exclusive Sales Tax:
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{ number_format($sesi_exclusive_sales_tax,2) }}
                                            {{--                                                {{ number_format($seim->sesi_exclusive_sales_tax,2) }}--}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table  class="m-0 p-0 table">
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Cash Discount:
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                                {{ number_format($sim->ssi_cash_disc_amount,2) }}--}}
                                            {{ number_format($mainTtlCashDis,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Total Sales Tax:
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{ number_format($ssi_total_sales_tax,2) }}
                                            {{--                                                {{ number_format($sim->ssi_total_sales_tax,2) }}--}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Services Total Sales Tax:
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                                {{ number_format($seim->sesi_total_sales_tax,2) }}--}}
                                            {{ number_format($sesi_total_sales_tax,2) }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table  class="m-0 p-0 table">
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Total Discount:
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                                {{ number_format($sim->ssi_total_discount,2) }}--}}
                                            {{ number_format($mainTtlDis,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Grand Total:-
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{--                                                {{ number_format($sim->ssi_grand_total,2) }}--}}
                                            {{ number_format($mainGrndTtl,2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="vi_tbl_hdng text-right">
                                            <label class="vi_tbl_hdng total-items-label text-right">
                                                Cash Paid:-
                                            </label>
                                        </th>
                                        <td class="text-right">
                                            {{ number_format($seim->ssei_cash_paid,2) }}
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

            <a href="{{ route('services_tax_items_view_details_pdf_SH',['id'=>$seim->sesi_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download/Get PDF/Print
            </a>
        </div>

        <div class="clearfix"></div>
        <div class="input_bx_ftr"></div>
    @endif

@endsection
