@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp


    <div id="" class="table-responsive">

        <table class="table border-0 table-sm p-0 m-0">
            @if($type === 'grid')
                @include('voucher_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title, $invoice_remarks])
            @endif
        </table>


        <table class="table table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    Account No.
                </th>
                <th scope="col" align="center" class="text-left align_left tbl_txt_25">
                    Account Name
                </th>
                <th scope="col" align="center" class="text-left align_left tbl_txt_31">
                    Detail Remarks
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    Percentage
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    Amount
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 1; $grand_total =0; $ttl_paid = 0; $vchr_id = ''; @endphp
            @foreach( $items as $item )

{{--                $vchr_id = $item->ebi_eb_id;--}}

                {{--                    $DR_val = ($vchr_id === $item->ebi_eb_id) ? $item->ebi_limit_amount : "";--}}
                {{--                    $DR = (!empty($DR_val)) ? $DR_val : "0";--}}
                {{--                    $grand_total = +(+$grand_total + +$DR);--}}

                {{--                    if( $item->cri_deduct_amount > 0 ):--}}
                {{--                        $adv_amnt = $item->cri_deduct_amount;--}}
                {{--                    endif;--}}
                @php

                    $grand_total = $grand_total + $item->ebi_limit_amount;



                @endphp
{{--if($loop->first){--}}
{{--                        $vchr_id++;--}}
{{--                    }--}}

                <tr class="even pointer">
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_10">
                        {{ $item->ebi_expense_uid }}
                    </td>
                    <td class="align_left text-left tbl_txt_25">
                        {!! $item->ebi_expense_name !!}
                    </td>
                    <td class="align_left text-left tbl_txt_31">
                        {!! $item->ebi_remarks !!}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                        {!! $item->ebi_limit_per.'%' !!}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                        {{ (!empty($item->ebi_limit_amount)) ? number_format($item->ebi_limit_amount,2) : ""  }}
                    </td>
                </tr>


                @php
                    $i++;
                @endphp

            @endforeach
            <tr class="border-0">
                <th colspan="5" align="right" class="border-0 pt-0 text-right align_right">
                    Grand Total:
                </th>
{{--                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">--}}
{{--                    {{ number_format($grand_total,2) }}--}}
{{--                </td>--}}
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($grand_total,2) }}
                </td>
            </tr>


            </tbody>
            <tfoot>
            <tr>
                <td colspan="6" class="border-0 p-0">
                    <div class="wrds_con">
                        <div class="wrds_bx">
                        <span class="wrds_hdng">
                            In Words
                        </span>
                            {{ $nbrOfWrds }} only
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
                <td colspan="6" class="border-0 p-0">
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
            </tfoot>

        </table>

        <div class="clearfix"></div>
        @if( $type === 'grid')
            <div class="itm_vchr_rmrks">

                <a href="{{ route('expense_budget_items_view_details_pdf_SH',['id'=>$csh_rcpt->eb_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
