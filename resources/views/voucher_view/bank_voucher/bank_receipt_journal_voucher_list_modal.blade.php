@extends('voucher_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp

    <div id="" class="table-responsive">

        <table class="table border-0 table-sm p-0 m-0">
{{--            @if($type === 'grid')--}}
                @include('voucher_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title, $invoice_remarks])
{{--            @endif--}}
        </table>


        <table class="table table-bordered table-sm" id="">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr.
                </th>
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">--}}
{{--                    Account No.--}}
{{--                </th>--}}
                <th scope="col" align="center" class="text-center align_center tbl_txt_30">
                    Account Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_15">
                    Posting Reference
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_31">
                    Detail Remarks
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    Dr.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    Cr.
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 1; $grand_total = $ttl_dr = $ttl_cr = $adv_amnt = $adv_amnt_deduct = $ttl_paid = 0; $vchr_id = '';
            $total_amount_dr = 0;
            $total_amount_cr = 0;
            @endphp
            @foreach( $items as $item )

                @php
                    $vchr_id = $item->bri_salary_payment_voucher_id;

                    $DR_val = ($vchr_id === $item->bri_salary_payment_voucher_id) ? $item->bri_amount : "";
                    $DR = (!empty($DR_val)) ? $DR_val : "0";
                    $grand_total = +(+$grand_total + +$DR);

                    if( $item->bri_deduct_amount > 0 ):
                        $adv_amnt = $item->bri_deduct_amount;
                    endif;

                    $ttl_paid = +$ttl_paid + +$DR;

                    if($loop->first){
                        $vchr_id++;
                    }

                @endphp

                @if( $vchr_id !== $item->bri_salary_payment_voucher_id)
                    <tr class="even pointer">
                        <th>
                            {{ $i }}
                        </th>
                        <td>
                            {{ $br_acnt_nme->account_uid }} -  {!! $br_acnt_nme->account_name !!}
                        </td>
{{--                        <td>--}}
{{--                            {!! $br_acnt_nme->account_name !!}--}}
{{--                        </td>--}}
                        <td>

                        </td>
                        <td>
                            {!! $bnk_rcpt->br_remarks !!}
                        </td>
                        <td align="right" class="align_right text-right">
                            {{ (!empty($bnk_rcpt->br_bank_amount)) ? number_format($bnk_rcpt->br_bank_amount,2) : "" }}
                        </td>
                        <td align="right" class="align_right text-right">
                        </td>
                    </tr>

                    @php
                        $total_amount_dr += $bnk_rcpt->br_bank_amount;
                            $i++;
                    @endphp
                @endif


                <tr class="even pointer">
                    <th>
                        {{ $i }}
                    </th>
{{--                    <td>--}}
{{--                        {{ $item->bri_account_id }}--}}
{{--                    </td>--}}
                    <td>
                        {!! $item->bri_account_name !!}
                    </td>
                    <td>
                        {!! $item->pr_name !!}
                    </td>
                    <td>
                        {!! $item->bri_remarks !!}
                    </td>
                    <td align="right" class="align_right text-right">
                        @if($item->bri_type==config('global_variables.brv_dr_type'))
                            {{ (!empty($DR_val)) ? number_format($DR_val,2) : ""  }}

                        @endif
                    </td>
                    <td align="right" class="align_right text-right">
                        @if($item->bri_type==config('global_variables.brv_cr_type'))
                            {{ (!empty($DR_val)) ? number_format($DR_val,2) : ""  }}

                        @endif
                    </td>
                </tr>

                @php
                    $i++;

                $total_amount_dr += $item->bri_type == config('global_variables.brv_dr_type') ? $DR_val : 0;
                $total_amount_cr +=$item->bri_type == config('global_variables.brv_cr_type') ? $DR_val : 0;
                @endphp

            @endforeach
            <tr class="border-0">
                <th colspan="4" align="right" class="border-0 pt-0 text-right align_right">
                    Grand Total:
                </th>
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($total_amount_dr,2) }}
                </td>
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($total_amount_cr,2) }}
                </td>
            </tr>


            </tbody>
            <tfoot>
            <style>
                .fieldset-box fieldset {
                    min-height: 47px;
                    border-color: black;
                }

                .fieldset-box fieldset legend {
                    font-weight: 600;
                }

                .fieldset-box fieldset span {
                    text-transform: uppercase;
                    line-height: 2;
                    margin-left: 10px;
                }
            </style>
            <tr class="fieldset-box">
                <td colspan="4" class="border-0 p-0 chck_pdng">

                    <fieldset style="margin-top: 14px">
                        <legend>In Words</legend>
                        <span>{{ $nbrOfWrds }} ONLY</span>
                    </fieldset>
                </td>
                <td class="border-0 p-0 chck_pdng" colspan="3">

                    <fieldset style="margin-top: 12px">
                        <legend>Recipient Sign.</legend>
                        <span>

                        </span>
                    </fieldset>
                </td>
            </tr>
            </tfoot>
        </table>
        <table class="table table-bordered table-sm" style="padding-right:100px">
            <tbody>
            <tr>
                <td class="border-0 p-0">

                    <div class="sign_bx">
                        <span style="font-size: 10px">
                             {{ $bnk_rcpt->user->user_name }}
                        </span>
                        <span class="sign_itm">
                            Prepared By
                        </span>
                    </div>

                    <div class="sign_bx">
                        &nbsp;
                        <span class="sign_itm">
                            Checked By
                        </span>
                    </div>

                    <div class="sign_bx">
                        &nbsp;
                        <span class="sign_itm">
                            Accounts Manager
                        </span>
                    </div>

                    <div class="sign_bx">
                        &nbsp;
                        <span class="sign_itm">
                            Chief Executive
                        </span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="clearfix"></div>
        @if( $type === 'grid')
            <div class="itm_vchr_rmrks">

                <a href="{{ route('bank_receipt_items_view_details_pdf_SH',['id'=>$bnk_rcpt->br_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
