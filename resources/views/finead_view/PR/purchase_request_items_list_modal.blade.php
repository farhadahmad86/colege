@extends('invoice_view.print_index')

@section('print_cntnt')
    <style>
        @font-face{
            font-family: Jameel;
            src: url({{asset('public/urdu_font/Jameel.ttf')}});
        }

        /*.table th, .table td {*/
        /*    font-family: Jameel;*/
        /*}*/

        .fonti{
            font-family: Jameel;
        }

    </style>
    @php
        $company_info = Session::get('company_info');
    @endphp

    <div id="" class="table-responsive" style="z-index: 9;">


        <table class="table table-sm m-0">

            @if($type === 'grid')
                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])
            @endif

            <tr class="bg-transparent">
                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0">
                        Company Information
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

                </td>

                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Created By
                    </h3>
                    <p class="invoice_para m-0 pt-0 fonti">
                        <b> Name: </b>
                        {{ (isset($pim->user_name) && !empty($pim->user_name)) ? $pim->user_name : 'N/A' }}
                    </p>
                    <p class="invoice_para m-0 pt-0 fonti">
                        <b> Remarks: </b>
                        {{ $pim->fpr_remarks }}
                    </p>
{{--                    <p class="invoice_para adrs m-0 pt-0">--}}
{{--                        <b> Adrs: </b>--}}
{{--                        {{ (isset($accnts->account_address) && !empty($accnts->account_address) ? $accnts->account_address : 'N/A') }}--}}
{{--                    </p>--}}
{{--                    <p class="invoice_para m-0 pt-0">--}}
{{--                        <b> Mob #: </b>--}}
{{--                        {{ (isset($accnts->account_mobile_no) && !empty($accnts->account_mobile_no) ? $accnts->account_mobile_no : 'N/A') }}--}}
{{--                    </p>--}}
{{--                    <p class="invoice_para m-0 pt-0 mb-10">--}}
{{--                        <b> NTN #: </b>--}}
{{--                        {{ (isset($accnts->account_ntn) && !empty($accnts->account_ntn) ? $accnts->account_ntn : 'N/A') }}--}}
{{--                    </p>--}}
                </td>
            </tr>

        </table>


        <table class="table table-bordered table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="tbl_srl_6 text-center align_center fonti">
                    Sr.
                </th>
                <th scope="col" align="center" class="align_center text-center tbl_txt_25 fonti">
                    Product Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6 fonti">
                    Qunatity
                </th>
                <th class="align_center text-center tbl_amnt_8 fonti">
                    Que Qty
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6 fonti">
                    UOM
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6 fonti">
                    Scale Size
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_13 fonti">
                    Remarks
                </th>
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_6 fonti">--}}
{{--                    Warehouse--}}
{{--                </th>--}}

            </tr>

            </thead>

            <tbody>
            @foreach( $piims as $piim )

                <tr class="even pointer">

                    <td class="align_center text-center tbl_srl_6">
                        {{ $piim->fpri_id }}
                    </td>

                    <td class="align_center text-center tbl_amnt_6">
                        {{ $piim->fpri_product_name }}
                    </td>
                    <td class="align_center text-center tbl_amnt_8">
                        {{ $piim->fpri_qty }}
                    </td>
                    <td class="align_center text-center tbl_amnt_6">
                        {{ $piim->fpri_due_qty }}
                    </td>
                    <td class="align_center text-center tbl_amnt_6">
                        {{ $piim->fpri_uom }}
                    </td>
                    <td class="align_right text-right tbl_amnt_13">
                        {{ $piim->fpri_scale_size	}}
                    </td>
                    <td class="align_center text-center tbl_amnt_6">
                        {{ $piim->fpri_remarks	 }}
                    </td>
{{--                    <td class="align_center text-center tbl_amnt_8">--}}
{{--                        {{ $piim->fpri_warehouse_id	 }}--}}
{{--                    </td>--}}


                </tr>
            @endforeach
{{--            <tr>--}}
{{--                <th colspan="2" class="text-right align_right">--}}
{{--                    Total:---}}
{{--                </th>--}}
{{--                <td class="text-center align_right">--}}
{{--                    {{ number_format($pim->pri_total_items,3) }}--}}
{{--                </td>--}}
{{--                <td class="text-center align_center">--}}
{{--                </td>--}}
{{--                <td class="text-center align_center">--}}
{{--                </td>--}}
{{--                <td class="text-center align_center">--}}
{{--                </td>--}}
{{--                <td class="text-right align_right">--}}
{{--                    {{ number_format($ttlExcluDis,2) }}--}}
{{--                </td>--}}
{{--                <td class="text-right align_right">--}}
{{--                    {{ number_format($trade_offerTtl,2) }}--}}
{{--                </td>--}}
{{--                <td class="text-center align_center">--}}
{{--                    --}}{{--                    {{ number_format($ttlDis,2) }}--}}
{{--                </td>--}}
{{--                <td class="text-center align_center">--}}
{{--                    {{ number_format($discountAmountTtl,2) }}--}}
{{--                </td>--}}
{{--                <td class="text-right align_right">--}}
{{--                    {{ number_format($ttlAmnt,2) }}--}}
{{--                </td>--}}
{{--            </tr>--}}


            </tbody>
            <tfoot>
{{--            <tr class="border-0">--}}
{{--                <td colspan="13" align="right" class="p-0 border-0">--}}
{{--                    <table class="table m-0 p-0 chk_dmnd">--}}
{{--                        <tr>--}}
{{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
{{--                                <table class="m-0 p-0 table">--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right fonti">--}}
{{--                                                {{$product_discount}}--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            {{ number_format($pim->pri_product_disc,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right fonti">--}}
{{--                                                {{$round_off_discount}}--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            {{ number_format($pim->pri_round_off_disc,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </td>--}}
{{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
{{--                                <table class="m-0 p-0 table">--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right fonti">--}}
{{--                                                {{$cash_discount}}--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            {{ number_format($pim->pri_cash_disc_amount,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right fonti">--}}
{{--                                                {{$total_discount}}--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        @php $discountTtl = $trade_offerTtl + $pim->pri_total_discount @endphp--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            {{ number_format($discountTtl,2) }}--}}
{{--                                            --}}{{--                                            {{ number_format($pim->pri_total_discount,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </td>--}}
{{--                            <td class="pl-0 pb-0 pr-0 border-0 pts-10">--}}
{{--                                <table class="m-0 p-0 table">--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right fonti">--}}
{{--                                                {{$grand_total}}--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            {{ number_format($pim->pri_grand_total,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <th class="vi_tbl_hdng fontS-12 text-right">--}}
{{--                                            <label class="total-items-label text-right fonti">--}}
{{--                                                {{$cash_paid}}--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
{{--                                        <td class="text-right fontS-12">--}}
{{--                                            {{ number_format($pim->pri_cash_paid,2) }}--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    </table>--}}
{{--                </td>--}}
{{--            </tr>--}}
            <tr>
                <td colspan="13" class="border-0 p-0">
                    <div class="wrds_con">
                        <div class="wrds_bx">
                    <span class="wrds_hdng">
                        In Words
                    </span>
{{--                            {{ $nbrOfWrds }} ONLY--}}
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
                <td colspan="13" class="border-0 p-0">
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

            <a href="{{ route('Purchase_Requisition_items_view_details_pdf_SH',['id'=>$piims[0]->fpr_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download
            </a>

            <iframe style="display: none" id="printf" name="printf" src="{{ route('Purchase_Requisition_items_view_details_pdf_SH',['id'=>$piims[0]->fpr_id]) }}" title="W3Schools Free Online Web
            Tutorials">
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
