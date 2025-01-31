@extends('voucher_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp

    <div id="" class="table-responsive">

        <table class="table table-bordered table-sm">
{{--            @if($type === 'grid')--}}
                @include('voucher_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title, $invoice_remarks])
{{--            @endif--}}
        </table>

        <table class="table table-bordered table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" class="text-center tbl_srl_4">Sr.</th>
{{--                <th scope="col" class="text-center tbl_amnt_10">Account No.</th>--}}
                <th scope="col" class="text-left tbl_txt_25">Account Name</th>
                <th scope="col" class="text-left tbl_txt_10">Posting Ref</th>
                <th scope="col" class="text-left tbl_txt_20">Remarks</th>
                <th scope="col" class="text-left tbl_txt_5">UOM</th>
                <th scope="col" class="text-left tbl_txt_6">Qty</th>
                <th scope="col" class="text-left tbl_txt_10">Rate</th>
{{--                <th scope="col" class="text-left tbl_txt_9">Amount</th>--}}
                <th scope="col" class="text-center tbl_amnt_10">Dr. </th>
                <th scope="col" class="text-center align_center tbl_amnt_10">Cr.</th>
            </tr>
            </thead>

            <tbody>
            @php $i = 1; $grand_total = $ttl_dr = $ttl_cr = $adv_amnt = $adv_amnt_deduct = $ttl_paid = 0; $vchr_id = ''; @endphp
            @foreach( $items as $item )

                @php
                    $vchr_id = $item->bli_salary_payment_voucher_id;

                    $DR_val = ($vchr_id === $item->bli_salary_payment_voucher_id) ? $item->bli_amount : "";
                    $DR = (!empty($DR_val)) ? $DR_val : "0";
                    $grand_total = +(+$grand_total + +$DR);

                    if( $item->bli_deduct_amount > 0 ):
                        $adv_amnt = $item->bli_deduct_amount;
                    endif;

                    $ttl_paid = +$ttl_paid + +$DR;

                    if($loop->last){
                        $vchr_id++;
                    }

                @endphp

                <tr class="even pointer">
                    <th>
                        {{ $i }}
                    </th>
{{--                    <td>--}}
{{--                        {{ $item->bli_account_id }}--}}
{{--                    </td>--}}
                    <td>
                        {!! $item->bli_account_name !!}
                    </td>
                    <td>
                        {!! $item->pr_name !!}
                    </td>
                    <td>{!! $item->bli_remarks !!}</td>
                    <td>{!! $item->bli_uom !!}</td>
                    <td>{!! $item->bli_qty !!}</td>
                    <td>{!! $item->bli_rate !!}</td>
{{--                    <td>{!! $item->bli_amount !!}</td>--}}
                    <td align="right" class="align_right text-right">
                        {{ (!empty($DR_val)) ? number_format($DR_val,2) : ""  }}
                    </td>
                    <td align="right" class="align_right text-right">
                    </td>
                </tr>
                @php
                    $i++;
                @endphp

                @if( $vchr_id !== $item->bli_salary_payment_voucher_id)
                    <tr class="even pointer">
                        <th>
                            {{ $i }}
                        </th>
                        <td>
                            {{ $bl_acnt_nme->account_uid }} - {!! $bl_acnt_nme->account_name !!}
                        </td>
{{--                        <td>--}}
{{--                            {!! $bl_acnt_nme->account_name !!}--}}
{{--                        </td>--}}
                        <td>

                        </td>
                        <td>
                            {!! $csh_pymnt->bl_remarks !!}
                        </td>
{{--                        <td colspan="5" align="right" class="align_right text-right">--}}
{{--                        </td>--}}
                        <td colspan="5"  align="right" class="align_right text-right">
                            {{ (!empty($ttl_paid)) ? number_format($ttl_paid,2) : "" }}
                        </td>
                    </tr>


                @endif



                @php
                    $i++;
                @endphp

            @endforeach


            </tbody>
            <tfoot>
            <tr class="border-0">
                <th colspan="7" align="right" class="border-0 pt-0 text-right align_right">
                    Grand Total:
                </th>
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($grand_total,2) }}
                </td>
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($ttl_paid,2) }}
                </td>
            </tr>
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
                <td colspan="5" class="border-0 p-0 chck_pdng">

                    <fieldset style="margin-top: 14px">
                        <legend>In Words</legend>
                        <span>{{ $nbrOfWrds }} ONLY</span>
                    </fieldset>
                </td>
                <td class="border-0 p-0 chck_pdng" colspan="4">

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
                             {{ $csh_pymnt->user->user_name }}
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

                <a href="{{ route('bill_of_labour_items_view_details_pdf_SH',['id'=>$csh_pymnt->bl_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
