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

            <tr class="bg-transparent">
                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
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
                        {{ $pim->plr_remarks }}
                    </p>
                </td>
                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Billed To
                    </h3>
                    <p class="invoice_para m-0 pt-0">
                        <b> Name: </b>
                        {{ (isset($pim->plr_account_name) && !empty($pim->plr_account_name)) ? $pim->plr_account_name: 'N/A' }}
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
                <th scope="col" class=" text-center tbl_srl_4">Sr.</th>
                <th scope="col" class="text-left tbl_txt_20">Employee Name</th>
                <th scope="col" class="text-left tbl_txt_44">Product Name</th>
                <th scope="col" class=" text-center tbl_amnt_8"> QTY</th>
                <th scope="col" class="text-center tbl_amnt_9">Rate</th>
                <th scope="col" class="text-centertbl_amnt_8">Pack QTY</th>
                <th scope="col" class="text-centertbl_amnt_8">Loose QTY</th>
                <th scope="col" class="text-centertbl_amnt_15">Total Amount</th>
            </tr>
            </thead>

            <tbody>
            @php $i = 01; $rate = $ttlRate = $ttlAmnt = 0; @endphp
            @foreach( $piims as $piim )
                @php
                    $amnt = $piim->plri_pro_total_amount;
                    $ttlAmnt = +$amnt + +$ttlAmnt;

                    $db_qty = $piim->plri_pro_qty;
                    $scale_size = $piim->plri_scale_size;
                     $pack_qty = floor($db_qty/$scale_size);
                     $loose_qty = fmod($db_qty, $scale_size);



                @endphp
                <tr class="even pointer">

                    <td class="text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td class="align_left text-left tbl_txt_20">
                        {{ $user->user_username }}
                    </td>
                    <td class="align_left text-left tbl_txt_44">
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $piim->plri_pro_name) !!}
                        @if(!empty($piim->plri_remarks) && isset($piim->plri_remarks))
                            <blockquote>
                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $piim->plri_remarks) !!}
                            </blockquote>
                        @endif
                    </td>
                    <td align="center" class="text-center tbl_amnt_8">
                        {!! $piim->plri_pro_qty !!}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_9">
                        {{ number_format($piim->plri_pro_purchase_price,2) }}
                    </td>
                    <td align="center" class="text-center tbl_amnt_8">
                        {!! number_format($pack_qty,3) !!}
                    </td>
                    <td align="center" class="text-center tbl_amnt_8">
                        {!! number_format($loose_qty,3) !!}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                        {!! number_format($piim->plri_pro_total_amount,2) !!}
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
                <td class="text-right align_right">
                </td>
                <td class="text-right align_right">
                </td>
                <td align="right" class=" text-center">
                </td>
                <td align="right" class="text-right align_right">
                    {{ number_format($ttlAmnt,2) }}
                </td>
            </tr>

            </tbody>

            <tfoot>
            <tr>
                <td colspan="8" class="border-0 p-0">
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
                <td colspan="8" class="border-0 p-0">
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

            <a href="{{ route('product_loss_recover_items_view_details_pdf_SH',['id'=>$pim->plr_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download/Get PDF/Print
            </a>

        </div>

        <div class="clearfix"></div>
        <div class="input_bx_ftr"></div>
    @endif

@endsection
