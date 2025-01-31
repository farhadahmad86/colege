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
                <th scope="col" class="text-center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" class="text-left tbl_txt_30">Account Name
                </th>
                <th scope="col" class="text-left tbl_txt_18">Posting Reference
                </th>
                <th scope="col" class="text-left tbl_txt_26">
                    Remarks
                </th>
                <th scope="col" class="text-center tbl_amnt_12">
                    Dr.
                </th>
                <th scope="col" class="text-center tbl_amnt_12">
                    Cr.
                </th>
            </tr>
            </thead>

            <tbody>

            @php $i = 1; $grand_total = $ttl_dr = $ttl_cr = $adv_amnt = 0; $vchr_id = ''; @endphp
            @foreach( $items as $item )

                @php
                    $vchr_id = $item->lvi_voucher_id;

                    $CR_val = ($vchr_id === $item->lvi_voucher_id) ? $item->lvi_amount : "";
                    $DR = (!empty($DR_val)) ? $DR_val : "0";
                    $grand_total = +(+$grand_total + +$DR);

                    $ttl_cr = +$ttl_cr + +$CR_val;

                    if($loop->first){
                        $vchr_id++;
                    }

                @endphp

                <tr class="even pointer">
                    <th>{{ $i }}</th>
                    <td>
                        {!! $item->lvi_account_name !!}
                    </td>
                    <td>
                        {!! $item->pr_name !!}
                    </td>
                    <td>
                        {!! $item->lvi_remarks !!}
                    </td>
                    <td align="right" class="align_right text-right">
                    </td>
                    <td align="right" class="align_right text-right">
                        {{ (!empty($item->lvi_amount)) ? number_format($item->lvi_amount,2) : ""  }}
                    </td>
                </tr>


                @php
                    $i++;
                @endphp

            @endforeach
            <tr class="even pointer">
                <th>{{ $i }}</th>
                <td>{{ $cr_acnt_nme->account_uid }} - {!! $cr_acnt_nme->account_name !!}</td>
                <td>

                </td>

                <td>{!! $loan_rcpt->lv_remarks !!}</td>
                <td align="right" class="align_right text-right">
                    {{ (!empty($loan_rcpt->lv_total_amount)) ? number_format($loan_rcpt->lv_total_amount,2) : "" }}
                </td>
                <td align="right" class="align_right text-right">
                </td>
            </tr>

            <tr class="border-0">
                <th colspan="4" align="right" class="border-0 pt-0 text-right align_right">
                    Grand Total:
                </th>
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($loan_rcpt->lv_total_amount,2) }}
                </td>
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($ttl_cr,2) }}
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
        <table class="table table-bordered table-sm invc_vchr_fnt" style="padding-right:100px">
            <tbody>
            <tr>
                <td class="border-0 p-0">

                    <div class="sign_bx">
                        <span style="font-size: 10px">
                             {{ $loan_rcpt->user->user_name }}
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

                <a href="{{ route('loan_items_view_details_pdf_SH',['id'=>$loan_rcpt->lv_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
