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

            <tr class="bg-transparent">
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
                        {{ $pim->pi_remarks }}
                    </p>
                </td>

                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Billed To
                    </h3>
                    <p class="invoice_para m-0 pt-0">
                        <b> Name: </b>
                        {{ (isset($pim->pm_account_name) && !empty($pim->pm_account_name)) ? $pim->pm_account_name : 'N/A' }}
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

        <h3 class="invoice_sub_hdng mb-0">
            Manufacture Product
        </h3>
        <table class="table table-bordered table-sm">
            <thead>

            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" align="center" class="align_center text-center tbl_amnt_20">
                    Product Code
                </th>
                <th scope="col" align="center" class="align_center text-center tbl_txt_44">
                    Product Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    QTY
                </th>
                <th class="align_center text-center tbl_amnt_11">
                    Total Items
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    Status
                </th>
            </tr>

            </thead>

            <tbody>
                <tr class="even pointer">
                    @php $i = 01; @endphp
                    <th>
                        {{ $i }}
                    </th>
                    <td>
                        {!! $pim->pm_pro_code !!}
                    </td>
                    <td>
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $pim->pm_pro_name) !!}
                        @if(!empty($pim->pm_remarks) && isset($pim->pm_remarks))
                            <blockquote>
                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $pim->pm_remarks) !!}
                            </blockquote>
                        @endif
                    </td>
                    <td>
                        {!! $pim->pm_qty !!}
                    </td>
                    <td align="right" class="align_center text-center">
                        {{ number_format($pim->pm_total_items,2) }}
                    </td>
                    <td align="center" class="align_center text-center">
                        {!! $pim->pm_status !!}
                    </td>

                </tr>
            </tbody>

        </table>


        <h3 class="invoice_sub_hdng mb-0">
            Items/Products & Expense Use In Manufacture Products
        </h3>
        <table class="table table-bordered table-sm ">
            <thead>

                <tr class="headings vi_tbl_hdng">
                    <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                        Sr.
                    </th>
                    <th scope="col" align="center" class="align_center text-center tbl_amnt_23">
                        Product Code
                    </th>
                    <th scope="col" align="center" class="align_center text-center tbl_txt_44">
                        Product Name
                    </th>
                    <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                        QTY
                    </th>
                    <th class="align_center text-center tbl_amnt_8">
                        Rate
                    </th>
                    <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                        Total Amount
                    </th>
                </tr>

            </thead>

            <tbody>
            @php $i = 01; $rate = $ttlRate = $ttlSaleTax = $dis = $ttlDis = $amnt = $ttlAmnt = $ttlNetRate = $excluSaleTaxRate = $ttlExcluSaleTaxRate = $ttl_pro = $ttl_pro1 = $ttlDeductDis1 = $deductDis1 = $deductDis = 0; @endphp
            @foreach( $piims as $piim )
                @php
                    $amnt = $piim->amount;
                    $ttlAmnt = +$amnt + +$ttlAmnt;
                @endphp

                <tr class="even pointer">

                    <th>
                        {{ $i }}
                    </th>
                    <td>
                        {!! $piim->code !!}
                    </td>
                    <td>
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $piim->name) !!}
                        @if(!empty($piim->remarks) && isset($piim->remarks))
                            <blockquote>
                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $piim->remarks) !!}
                            </blockquote>
                        @endif
                    </td>
                    @if($piim->type === 'items')
                        <td>
                            {!! $piim->qty !!}
                        </td>
                        @php
                            $rate = $piim->rate;
                            $excluSaleTaxRate = $rate * $piim->qty;
                            $ttlExcluSaleTaxRate = +$excluSaleTaxRate + +$ttlExcluSaleTaxRate;
                            $ttlRate = +$rate + +$ttlRate;
                        @endphp
                        <td align="right" class="align_center text-center">
                            {{ number_format($piim->rate,2) }}
                        </td>
                    @endif
                    @if($piim->type === 'expense')
                        <td>
                            {{ ucwords($piim->type) }}
                        </td>
                    @endif
                    <td align="right" class="align_right text-right">
                        {!! number_format($piim->amount,2) !!}
                    </td>

                </tr>
                @php $i++; @endphp
            @endforeach
            <tr>
                <th colspan="3" class="text-right align_right">
                    Total:-
                </th>
                <td class="text-right align_right">
                </td>
                <td class="text-center align_center">
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
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="vi_tbl_hdng total-items-label text-right">Total Amount:</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($pim->pm_total_pro_amount,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="m-0 p-0 table">
                                        <tr>
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="vi_tbl_hdng total-items-label text-right">Total Expense:</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($pim->pm_total_expense_amount,2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="pl-0 pb-0 pr-0 border-0 pts-10">
                                    <table  class="m-0 p-0 table">
                                        <tr>
                                            <th class="vi_tbl_hdng text-right">
                                                <label class="vi_tbl_hdng total-items-label text-right">Grand Total:-</label>
                                            </th>
                                            <td class="text-right">
                                                {{ number_format($pim->pm_grand_total,2) }}
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

        <a href="{{ route('purchase_items_view_details_pdf_sh',['id'=>$pim->pi_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Download/Get PDF/Print
        </a>
    </div>

    <div class="clearfix"></div>
    <div class="input_bx_ftr"></div>
@endif

@endsection
