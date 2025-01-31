
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
    @php
        use App\Models\AccountRegisterationModel;
    use App\Models\ReportConfigModel;
    use App\Models\SaleInvoiceModel;
    use App\Models\ServicesInvoiceModel;
       use Illuminate\Support\Facades\DB;
    @endphp
    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                Sr#
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_9">
                Product Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                QTY
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_21">
                Rate
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_24">
                Exclusive Discount
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Discount %
            </th>

            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Discount Amount
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Inclusive Discount
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Total Amount
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
            $ttlPrc = $cashPaid = 0;
            $siims='';
        @endphp
        @php
            $excluProDis = $ttlExcluProDis = $ttlIncluProDis = $ttlSaleProTax = $ttlProAmnt = 0;
        $extra_discount= $extra_tax = $extra_qty = $extra_sale_tax = $total_invoice= $extra_gross_amount = $extra_grand_total =0;
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
        @forelse($datas as $invoice)

            @php

                $urdu_eng = \App\Models\ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice', 'rc_invoice_party')->first();
                        if ($urdu_eng->rc_invoice_party == 0) {
                            $sim = SaleInvoiceModel::where('si_id', $invoice->si_id)->first();
                        } else {
                            $sim = DB::table('financials_sale_invoice')
                                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_invoice.si_party_code')
                                ->where('si_id', $invoice->si_id)
                                ->select('financials_accounts.account_urdu_name as si_party_name', 'si_id', 'si_party_code', 'si_customer_name', 'si_remarks', 'si_total_items', 'si_total_price',
                                    'si_product_disc', 'si_round_off_disc',
                                    'si_cash_disc_per', 'si_cash_disc_amount', 'si_total_discount', 'si_inclusive_sales_tax', 'si_exclusive_sales_tax', 'si_total_sales_tax', 'si_grand_total',
                                    'si_cash_received', 'si_day_end_id', 'si_day_end_date', 'si_createdby', 'si_sale_person', 'si_service_invoice_id', 'si_local_invoice_id', 'si_local_service_invoice_id', 'si_cash_received_from_customer', 'si_return_amount')->first();
                        }
                        $seim = ServicesInvoiceModel::where('sei_sale_invoice_id', $invoice->si_id)->first();

                        $accnts = AccountRegisterationModel::where('account_uid', $sim->si_party_code)->first();

                        if ($urdu_eng->rc_invoice == 0) {
                            $services = DB::table('financials_service_invoice_items')
                                ->where('seii_invoice_id', $sim->si_service_invoice_id)
                                ->orderby('seii_service_name', 'ASC')
                //            ->select('sseii_service_name as name', 'sseii_remarks as remarks', 'sseii_qty as qty', 'sseii_rate as rate', 'sseii_discount as discount', 'sseii_saletax as sale_tax', 'sseii_amount as amount')
                                ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_discount_amount as discount_amount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_scale_size as scale_size', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount');
                            $siims = DB::table('financials_sale_invoice_items')
                                ->where('sii_invoice_id', $invoice->si_id)
                                ->orderby('sii_product_name', 'ASC')
                //            ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount as discount', 'sii_saletax as sale_tax', 'sii_amount as amount')
                                ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount_per as discount', 'sii_discount_amount as discount_amount', 'sii_after_dis_rate as after_discount', 'sii_saletax_per as sale_tax', 'sii_scale_size as scale_size', 'sii_saletax_amount as sale_tax_amount', 'sii_saletax_inclusive as inclu_exclu', 'sii_amount as amount')
                                ->union($services)
                                ->get();
                        } else {
                            $services = DB::table('financials_service_invoice_items')
                                ->where('seii_invoice_id', $sim->si_service_invoice_id)
                                ->orderby('seii_service_name', 'ASC')
                //            ->select('sseii_service_name as name', 'sseii_remarks as remarks', 'sseii_qty as qty', 'sseii_rate as rate', 'sseii_discount as discount', 'sseii_saletax as sale_tax', 'sseii_amount as amount')
                                ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_discount_amount as discount_amount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_scale_size as scale_size', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount');
                            $siims = DB::table('financials_sale_invoice_items')
                                ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_invoice_items.sii_product_code')
                                ->where('sii_invoice_id', $invoice->si_id)
                                ->orderby('sii_product_name', 'ASC')
                                ->select('financials_products.pro_urdu_title as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount_per as discount', 'sii_discount_amount as discount_amount', 'sii_after_dis_rate as after_discount', 'sii_saletax_per as sale_tax', 'sii_scale_size as scale_size', 'sii_saletax_amount as sale_tax_amount', 'sii_saletax_inclusive as inclu_exclu', 'sii_amount as amount')
                                ->union($services)
                                ->get();
                        }


                        $si_grand_total = (isset($sim->si_grand_total) && !empty($sim->si_grand_total)) ? $sim->si_grand_total : 0;
                        $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;
                        $mainGrndTtl = +$si_grand_total + +$sei_grand_total;
                        //$nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
                        $invoice_nbr = $sim->si_id;
                        $invoice_date = $sim->si_day_end_date;

                        $si_cash_received = (isset($sim->si_cash_received) && !empty($sim->si_cash_received)) ? $sim->si_cash_received : 0;
                        $sei_cash_received = (isset($seim->sei_cash_received) && !empty($seim->sei_cash_received)) ? $seim->sei_cash_received : 0;

                        $cash_received = $si_cash_received + $sei_cash_received;
                        $total_invoice+=1;
                        $i = 0;
            @endphp
            <tr>
                <td class="align_center text-center edit tbl_srl_4" colspan="2" style="border-left:1px solid black; border-right:none; border-bottom:none;border-top:none;">
                    <b>Invoice#:</b> {{$invoice->si_id}}
                </td>
                <td nowrap class="align_center text-center tbl_amnt_9 border-0" colspan="2">
                    <b>Sale Date: </b>{{date('d-M-y', strtotime(str_replace('/', '-', $invoice->si_day_end_date)))}}
                </td>

                <td class="atext-center text-center tbl_txt_21 border-0" colspan="2">
                    <b>Customer: </b>{{$invoice->si_party_name}}
                </td>
                <td class="atext-center text-center tbl_txt_34" colspan="3" style="border-left:none; border-right:1px solid black; border-bottom:none;border-top:none;">
                    <b>Sale Man: </b>{!! $invoice->user_name !!}
                </td>

            </tr>
            @foreach($siims as $siim)
                @php
                    $db_qty=$siim->qty;
                $extra_qty = $extra_qty + $db_qty;
    $db_rate=$siim->rate;
    $gross_amount=$db_rate * $db_qty;
                                            //$excluProDis = $siim->qty * $siim->rate;
                                            $excluProDis = $gross_amount;
                                            $ttlExcluProDis = +$excluProDis + +$ttlExcluProDis;
                                            $ttlIncluProDis = +$siim->after_discount + +$ttlIncluProDis;
                                            //$ttlSaleProTax = +$ttlSaleProTax + +$siim->sale_tax_amount;
                                            $ttlProAmnt = +$ttlProAmnt + +$siim->amount;

                    $qtyTtl = +$qtyTtl + +$db_qty ;
                    $i+=1;
                @endphp

                <tr class="even pointer">

                    <td class="tbl_srl_4 align_center text-center">
                        {{ $i }}
                    </td>
                    <td class="align_left text-left tbl_txt_20 fonti">
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->name) !!}
                        @if(!empty($siim->remarks) && isset($siim->remarks))
                            <blockquote class="fonti">
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

                    <td class="tbl_amnt_5 align_center text-center">
                        {!! $siim->discount !!}
                    </td>
                    <td class="tbl_amnt_5 align_center text-center">
                        {!! $siim->discount_amount !!}
                    </td>
                    <td class="align_right text-right tbl_amnt_8">
                        {{ number_format($siim->after_discount,2) }}
                    </td>
                    {{--                    <td class="align_center text-center tbl_amnt_8">--}}
                    {{--                        {!! $siim->sale_tax !!}--}}
                    {{--                    </td>--}}
                    {{--                    <td class="align_right text-right tbl_amnt_8">--}}
                    {{--                        {{ ($siim->inclu_exclu === 1) ? "(In)=" : "(Ex)=" }}{!! number_format($siim->sale_tax_amount,2) !!}--}}
                    {{--                    </td>--}}
                    <td class="tbl_amnt_12 align_right text-right">
                        {!! number_format($siim->amount,2) !!}
                    </td>

                </tr>
            @endforeach
            <tr>
                @php
                    $extra_discount= $extra_discount + $invoice->si_total_discount;
                    $extra_tax= $extra_tax + $invoice->si_total_sales_tax;
                    $extra_gross_amount= $extra_gross_amount + $invoice->si_total_price;
                    $extra_grand_total= $extra_grand_total + $invoice->si_grand_total;
                @endphp
                <td class="text-center" colspan="2" style="border-left:1px solid black; border-right:none; border-bottom:none;"><b>Sale Tax:</b> {{$invoice->si_total_sales_tax}}</td>
                <td class="border-0 text-center" colspan="2"><b>Discount: </b> {{$invoice->si_total_discount}}</td>
                <td class="border-0 text-center" colspan="2"><b>Grand Total:</b> {{$invoice->si_grand_total}}</td>
                <td class="text-center" colspan="3" style="border-left:none; border-right:1px solid black; border-bottom:none;border-top:none;"><b>Cash Received:</b>
                    {{$invoice->si_cash_received}}</td>
            </tr>
            <tr>
                <td class="text-center" colspan="9" style="border-bottom:3px solid black;border-top:none;">
                </td>
            </tr>
            @php
                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No List Found</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
        <tfoot>
        <tr>
            <td class="align_center text-center border-0" colspan="2">
                <b>No of Inv: </b>{{ $total_invoice }}
            </td>
            <td class="align_center text-center border-0" colspan="2">
                <b>Quantity: </b>{{ $extra_qty }}
            </td>
            <td class="align_center text-center border-0">
                <b>Value: </b>{{ $extra_gross_amount }}
            </td>
            <td class="align_left text-left border-0">
                <b>Sale Tax: </b>{{ $extra_tax }}
            </td>
            <td class="align_center text-center border-0">
                <b>Discount: </b>{{ $extra_discount }}
            </td>
            <td class="align_center text-center border-0" colspan="2">
                <b>Net Value: </b>{{ number_format($extra_grand_total,2) }}
            </td>
        </tr>

        </tfoot>
    </table>

@endsection

