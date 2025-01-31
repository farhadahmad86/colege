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
                        {{ $sim->si_remarks }}
                    </p>
                </td>

                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Billed To
                    </h3>
                    <p class="invoice_para m-0 pt-0">
                        <b> Name: </b>
                        {{ (isset($accnts->account_name) && !empty($accnts->account_name)) ? $accnts->account_name : 'N/A' }}
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


        <table class="table invc_vchr_fnt">
            <thead>

            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="tbl_srl_4 text-center align_center">
                    Sr.
                </th>
                <th scope="col" align="center" class="align_left text-left tbl_txt_20">
                    Product Name
                </th>
                {{--                    <th scope="col" align="center" class="text-center align_center tbl_amnt_15">--}}
                {{--                        Remarks--}}
                {{--                    </th>--}}
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    QTY
                </th>
                <th class="align_center text-center tbl_amnt_5">
                    Rate
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Gross Amount
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Dis.%
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Included Dis.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Sale Tax%
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Total Sales Tax Payable
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_12">
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

            $si_product_disc = (isset($sim->si_product_disc) && !empty($sim->si_product_disc)) ? $sim->si_product_disc : 0;
            $si_round_off_disc = (isset($sim->si_round_off_disc) && !empty($sim->si_round_off_disc)) ? $sim->si_round_off_disc : 0;
            $si_cash_disc_amount = (isset($sim->si_cash_disc_amount) && !empty($sim->si_cash_disc_amount)) ? $sim->si_cash_disc_amount : 0;
            $si_total_discount = (isset($sim->si_total_discount) && !empty($sim->si_total_discount)) ? $sim->si_total_discount : 0;

            $sei_product_disc = (isset($seim->sei_product_disc) && !empty($seim->sei_product_disc)) ? $seim->sei_product_disc : 0;
            $sei_round_off_disc = (isset($seim->sei_round_off_disc) && !empty($seim->sei_round_off_disc)) ? $seim->sei_round_off_disc : 0;
            $sei_cash_disc_amount = (isset($seim->sei_cash_disc_amount) && !empty($seim->sei_cash_disc_amount)) ? $seim->sei_cash_disc_amount : 0;
            $sei_total_discount = (isset($seim->sei_total_discount) && !empty($seim->sei_total_discount)) ? $seim->sei_total_discount : 0;

            //$mainTtlProDis = +$si_product_disc + +$sei_product_disc;
            $mainTtlRoundDis = +$si_round_off_disc + +$sei_round_off_disc;
            $mainTtlCashDis = +$si_cash_disc_amount + +$sei_cash_disc_amount;
            $mainTtlDis = +$sei_total_discount + +$si_total_discount;

            //=========== discount section end ==============

            //=========== Sale Tax section start ==============

            $si_inclusive_sales_tax = (isset($sim->si_inclusive_sales_tax) && !empty($sim->si_inclusive_sales_tax)) ? $sim->si_inclusive_sales_tax : 0;
            //$si_exclusive_sales_tax = (isset($sim->si_exclusive_sales_tax) && !empty($sim->si_exclusive_sales_tax)) ? $sim->si_exclusive_sales_tax : 0;
            $si_exclusive_sales_tax = 0;
            $si_total_sales_tax = (isset($sim->si_total_sales_tax) && !empty($sim->si_total_sales_tax)) ? $sim->si_total_sales_tax : 0;

            //=========== Sale Tax section end ==============

            //=========== Services Sale Tax section start ==============

            $sei_inclusive_sales_tax = (isset($seim->sei_inclusive_sales_tax) && !empty($seim->sei_inclusive_sales_tax)) ? $seim->sei_inclusive_sales_tax : 0;
            //$sei_exclusive_sales_tax = (isset($seim->sei_exclusive_sales_tax) && !empty($seim->sei_exclusive_sales_tax)) ? $seim->sei_exclusive_sales_tax : 0;
            $sei_exclusive_sales_tax = 0;
            $sei_total_sales_tax = (isset($seim->sei_total_sales_tax) && !empty($seim->sei_total_sales_tax)) ? $seim->sei_total_sales_tax : 0;

            //=========== Services Sale Tax section end ==============


            $po_grand_total = (isset($sim->po_grand_total) && !empty($sim->po_grand_total)) ? $sim->po_grand_total : 0;
            $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;

            $mainGrndTtl = +$po_grand_total + +$sei_grand_total;

$total_quantity=0;
$mainTtlProdDis=0;
$mainTtlSerDis=0;
 foreach($products as $product){
                $si_exclusive_sales_tax=$product->poi_pro_tax_amount + $si_exclusive_sales_tax;
                $mainTtlProdDis=$product->poi_pro_dis_amount + $mainTtlProdDis;
 }
 foreach($service as $ser){
                $sei_exclusive_sales_tax=$ser->seii_saletax_amount + $sei_exclusive_sales_tax;
                $mainTtlSerDis=$ser->seii_discount_amount + $mainTtlSerDis;
 }
$mainTtlProDis=$mainTtlProdDis + $mainTtlSerDis;
            @endphp


            @foreach( $siims as $siim )
                @php
                    $excluProDis = $siim->qty * $siim->rate;
                    $ttlExcluProDis = +$excluProDis + +$ttlExcluProDis;
                    $ttlIncluProDis = +$siim->discount_amount + +$ttlIncluProDis;
                    //$ttlIncluProDis = +$siim->after_discount + +$ttlIncluProDis;
                    $ttlSaleProTax = +$ttlSaleProTax + +$siim->sale_tax_amount;
                    $ttlProAmnt = +$ttlProAmnt + +$siim->amount;

//$excluProDis=$excluProDis-
                $total_quantity=$siim->qty +$total_quantity;
                @endphp

                <tr class="even pointer">

                    <td class="tbl_srl_4 align_center text-center">
                        {{ $i }}
                    </td>
                    <td class="align_left text-left tbl_txt_29">
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->name) !!}
                        @if(!empty($siim->remarks) && isset($siim->remarks))
                            <blockquote>
                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->remarks) !!}
                            </blockquote>
                        @endif
                    </td>
                    {{--                    <td class="tbl_amnt_15 align_center text-center">--}}
                    {{--                        {!! $siim->remarks !!}--}}
                    {{--                    </td>--}}
                    <td class="tbl_amnt_6 align_center text-center">
                        {!! $siim->qty !!}
                    </td>
                    <td class="tbl_amnt_5 align_center text-center">
                        {{ number_format($siim->rate,2) }}
                    </td>
                    <td class="tbl_amnt_8 align_right text-right">
                        {{ number_format($excluProDis,2) }}
                    </td>
                    <td class="tbl_amnt_8 align_center text-center">
                        {!! $siim->discount !!}
                    </td>
                    <td class="align_right text-right tbl_amnt_8">
                        {{ number_format($siim->discount_amount,2) }}
{{--                        {{ number_format($siim->after_discount,2) }}--}}
                    </td>
                    <td class="align_center text-center tbl_amnt_8">
                        {!! $siim->sale_tax !!}
                    </td>
                    <td class="align_right text-right tbl_amnt_8">
{{--                        {{ ($siim->inclu_exclu === 1) ? "(In)=" : "(Ex)=" }}{!! number_format($siim->sale_tax_amount,2) !!}--}}
                        {!! number_format($siim->sale_tax_amount,2) !!}
                    </td>
                    <td class="tbl_amnt_15 align_right text-right">
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
{{--                    {{ number_format($sim->po_total_items,3) }}--}}
                    {{ number_format($total_quantity,3) }}
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
                    {{ number_format($ttlIncluProDis,2) }}
                </td>
                <td class="text-right align_right">
                </td>
                <td class="text-right align_right">
{{--                    @php--}}
{{--                        $ttlSaleProTax = +$si_total_sales_tax + +$sei_total_sales_tax;--}}
{{--                    @endphp--}}
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
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Total Discount:
                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">
                                            {{--                                                {{ number_format($sim->ssi_product_disc,2) }}--}}
                                            {{ number_format($mainTtlProDis,2) }}
                                        </td>
                                    </tr>

                                </table>
                            </td>
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table  class="m-0 p-0 table">

                                    <tr>
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Total Sales Tax:
                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">
                                            {{ number_format($ttlSaleProTax,2) }}
                                            {{--                                                {{ number_format($sim->ssi_exclusive_sales_tax,2) }}--}}
                                        </td>
                                    </tr>

                                </table>
                            </td>
{{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
{{--                                <table  class="m-0 p-0 table">--}}

{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Total Sales Tax:--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            {{ number_format($si_total_sales_tax,2) }}--}}
{{--                                            --}}{{--                                                {{ number_format($sim->ssi_total_sales_tax,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}

{{--                                </table>--}}
{{--                            </td>--}}
                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                <table  class="m-0 p-0 table">

                                    <tr>
                                        <th class="vi_tbl_hdng fontS-12 text-right">
                                            <label class="total-items-label text-right">
                                                Grand Total:-
                                            </label>
                                        </th>
                                        <td class="text-right fontS-12">
                                            {{--                                                {{ number_format($sim->ssi_grand_total,2) }}--}}
                                            {{ number_format($mainGrndTtl,2) }}
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>


{{--            <tr class="border-0">--}}
{{--                <td colspan="10" align="right" class="p-0 border-0">--}}
{{--                    <table class="table m-0 p-0 chk_dmnd">--}}
{{--                        <tr>--}}
{{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
{{--                                <table  class="m-0 p-0 table">--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Product Discount:--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            --}}{{--                                                {{ number_format($sim->ssi_product_disc,2) }}--}}{{--                                           --}}
{{--                                            {{ number_format($mainTtlProDis,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Inclusive Sales Tax:--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            --}}{{--                                                {{ number_format($sim->ssi_inclusive_sales_tax,2) }}--}}
{{--                                            {{ number_format($si_inclusive_sales_tax,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Services Inclusive Sales Tax:--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            --}}{{----}}{{--                                                {{ number_format($seim->sesi_inclusive_sales_tax,2) }}--}}
{{--                                            {{ number_format($sei_inclusive_sales_tax,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}

{{--                                </table>--}}
{{--                            </td>--}}
{{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
{{--                                <table  class="m-0 p-0 table">--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Round off Discount:--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            --}}{{--                                                {{ number_format($sim->ssi_round_off_disc,2) }}--}}
{{--                                            {{ number_format($mainTtlRoundDis,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Exclusive Sales Tax:--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            {{ number_format($si_exclusive_sales_tax,2) }}--}}
{{--                                            --}}{{--                                                {{ number_format($sim->ssi_exclusive_sales_tax,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Services Exclusive Sales Tax:--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            {{ number_format($sei_exclusive_sales_tax,2) }}--}}
{{--                                            --}}{{----}}{{--                                                {{ number_format($seim->sesi_exclusive_sales_tax,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </td>--}}
{{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
{{--                                <table  class="m-0 p-0 table">--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Cash Discount:--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            --}}{{--                                                {{ number_format($sim->ssi_cash_disc_amount,2) }}--}}
{{--                                            {{ number_format($mainTtlCashDis,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Total Sales Tax:--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            {{ number_format($si_total_sales_tax,2) }}--}}
{{--                                            --}}{{--                                                {{ number_format($sim->ssi_total_sales_tax,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Services Total Sales Tax:--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            --}}{{----}}{{--                                                {{ number_format($seim->sesi_total_sales_tax,2) }}--}}
{{--                                            {{ number_format($sei_total_sales_tax,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </td>--}}
{{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
{{--                                <table  class="m-0 p-0 table">--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Total Discount:--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            --}}{{--                                                {{ number_format($sim->ssi_total_discount,2) }}--}}
{{--                                            {{ number_format($mainTtlDis,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Grand Total:---}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            --}}{{--                                                {{ number_format($sim->ssi_grand_total,2) }}--}}
{{--                                            {{ number_format($mainGrndTtl,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right">--}}
{{--                                                Cash Paid:---}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            {{ number_format($sim->si_cash_paid,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    </table>--}}
{{--                </td>--}}
{{--            </tr>--}}
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

            <a href="{{ route('purchase_order_items_view_details_pdf_SH',['id'=>$sim->po_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download/Get PDF/Print
            </a>
        </div>

        <div class="clearfix"></div>
        <div class="input_bx_ftr"></div>
    @endif

@endsection
