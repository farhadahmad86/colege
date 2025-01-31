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
                <th scope="col" class="text-center tbl_amnt_10">
                    Account No.
                </th>
                <th scope="col" class="text-center tbl_txt_20">
                    Account Name
                </th>
                <th scope="col" class="text-center tbl_txt_16">
                    Month
                </th>
                <th scope="col" class="text-center tbl_txt_20">
                    Remarks
                </th>
                <th scope="col" class="text-center tbl_amnt_15">
                    Dr.
                </th>
                <th scope="col" class="text-center tbl_amnt_15">
                    Cr.
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 1; $grand_total = $ttl_dr = $ttl_cr = $adv_amnt = $adv_amnt_deduct = $ttl_paid = 0; $vchr_id = ''; @endphp
            @foreach( $items as $item )

                @php
                    $vchr_id = $item->spi_sp_id;

                    $DR_val = ($vchr_id === $item->spi_sp_id) ? $item->spi_paid_amount : "";
                    $DR = (!empty($DR_val)) ? $DR_val : "0";
                    $grand_total = +(+$grand_total + +$DR);

                    if( $item->spi_deduct_amount > 0 ):
                        $adv_amnt = $item->spi_deduct_amount;
                    endif;

                    $adv_amnt_cal = +$DR - +$adv_amnt;
                    $adv_amnt_deduct = +$adv_amnt_cal + +$adv_amnt_deduct;
                    $ttl_paid = +$ttl_paid + +$adv_amnt_cal + +$adv_amnt;

                    if($loop->last){
                        $vchr_id++;
                    }

                @endphp

                <tr class="even pointer">
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_10">
                        {{ $item->spi_account_id }}
                    </td>
                    <td class="align_left text-left tbl_txt_20">
                        {!! $item->spi_account_name !!}
                    </td>
                    <td class="align_left text-left tbl_txt_16">
                        {!! $item->spi_month_year !!}
                    </td>
                    <td class="align_left text-left tbl_txt_20">
                        {!! $item->spi_remarks !!}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                        {{ (!empty($DR_val)) ? number_format($DR_val,2) : ""  }}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                    </td>
                </tr>

                @php if( $item->spi_deduct_amount > 0 ): @endphp
                <tr class="even pointer">
                    @php  $i++; @endphp

                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_10">
                        {{ $item->spi_advance_account_id }}
                    </td>
                    <td class="align_left text-left tbl_txt_20">
                        {!! $item->spi_advance_account_name !!}
                    </td>
                    <td class="align_left text-left tbl_txt_16">
                        {!! $item->spi_month_year !!}
                    </td>
                    <td class="align_left text-left tbl_txt_16">
                        Deduct Amount
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                        {{ (!empty($adv_amnt)) ? number_format($adv_amnt,2) : "" }}
                    </td>
                </tr>
                @php endif;
            if( $vchr_id !== $item->spi_sp_id):
                @endphp

                <tr class="even pointer">
                    @php $i++;  @endphp
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_10">
                        {{ $sp_acnt_nme->account_uid }}
                    </td>
                    <td class="align_left text-left tbl_txt_20">
                        {!! $sp_acnt_nme->account_name !!}
                    </td>
                    <td class="align_left text-left tbl_txt_16">
                        {!! $slry_pmnt->sp_month !!}
                    </td>
                    <td class="align_left text-left tbl_txt_20">
                        {!! $item->spi_remarks !!}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                        {{ (!empty($adv_amnt_deduct)) ? number_format($adv_amnt_deduct,2) : "" }}
                    </td>
                </tr>
                @php
                    endif;
                     $i++;
                @endphp

            @endforeach
            <tr class="border-0">
                <th colspan="5" align="right" class="border-0 pt-0 text-right align_right">
                    Grand Total:
                </th>
                <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($grand_total,2) }}
                </td>
                <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($ttl_paid,2) }}
                </td>
            </tr>


            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="border-0 p-0">
                    <div class="wrds_con">
                        <div class="wrds_bx">
                        <span class="wrds_hdng">
                            In Words
                        </span>
                            {{ $nbrOfWrds }} only
                        </div>
                        <div class="wrds_bx wrds_bx_two">
                        <span class="wrds_hdng">
                            Recipient Sign.
                        </span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="7" class="border-0 p-0">
                    <div class="sign_con">

                        <div class="sign_bx">
                            <span style="font-size: 10px">
                             {{ $slry_pmnt->user->user_name }}
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

                    </div>
                </td>
            </tr>
            </tfoot>

        </table>

        <div class="clearfix"></div>
        @if( $type === 'grid')
            <div class="itm_vchr_rmrks">

                <a href="{{ route('new_salary_payment_items_view_details_pdf_SH',['id'=>$slry_pmnt->sp_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top:
                7px;">
                    Download/Get PDF/Print
                </a>
                {{--                <a href="{{ route('new_salary_payment_items_view_details_single_pdf_SH',['id'=>$slry_pmnt->sp_id]) }}" class="align_right text-center btn btn-sm btn-success" style="float: left;--}}
                {{--                margin-top: 7px;margin-left: 5px;">--}}
                {{--                    View Detail--}}
                {{--                </a>--}}
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
