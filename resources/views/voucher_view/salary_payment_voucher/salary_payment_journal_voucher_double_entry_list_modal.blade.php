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
                Acc No.
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_25">
                Account Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_31">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                Dr.
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                Cr.
            </th>
        </tr>
        </thead>

        <tbody>
        @php $i = 1; $grand_total = $ttl_dr = $ttl_cr = $adv_amnt = $adv_amnt_deduct = $ttl_paid = 0; $vchr_id = ''; @endphp
        @foreach( $items as $item )
            @php $vchr_id = $item->spi_salary_payment_voucher_id; @endphp

            <tr class="even pointer">

                <td class="align_center text-center tbl_srl_4">
                    {{ $i }}
                </td>
                <td align="center" class="align_center text-center tbl_amnt_10">
                    {{ $item->spi_account_id }}
                </td>
                <td class="align_left text-left tbl_txt_25">
                    {!! $item->spi_account_name !!}
                </td>
                <td class="align_left text-left tbl_txt_31">
                    {!! $item->spi_remarks !!}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    @php
                        $DR_val = ($vchr_id === $item->spi_salary_payment_voucher_id) ? $item->spi_amount : "";
                        $DR = (!empty($DR_val)) ? $DR_val : "0";
                        $grand_total = +(+$grand_total + +$DR);

                    @endphp
                    {{ (!empty($grand_total)) ? number_format($DR_val,2) : ""  }}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                </td>
            </tr>

            @php if( $item->spi_deduct_amount > 0 ): @endphp
            <tr class="even pointer">
                @php  $i++;
                    $adv_amnt = $item->spi_deduct_amount;
                @endphp
                <td class="align_center text-center tbl_srl_4">
                    {{ $i }}
                </td>
                <td align="center" class="align_center text-center tbl_amnt_10">
                    {{ $item->spi_advance_account_id }}
                </td>
                <td class="align_left text-left tbl_txt_25">
                    {!! $item->spi_advance_account_name !!}
                </td>
                <td class="align_left text-left tbl_txt_31">
                    Deduct Amount
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{ (!empty($adv_amnt)) ? number_format($adv_amnt,2) : "" }}
                </td>
            </tr>
            @php endif;
                    $adv_amnt_deduct = +$DR - +$adv_amnt;
                    $ttl_paid = +$ttl_paid + +$adv_amnt_deduct + +$adv_amnt;
            @endphp

            @php if( $vchr_id !== $item->spi_salary_payment_voucher_id || ($loop->last)): @endphp
            <tr class="even pointer">
                @php $i++;  @endphp
                <td class="align_center text-center tbl_srl_4">
                    {{ $i }}
                </td>
                <td align="center" class="align_center text-center tbl_amnt_10">
                    {{ $sp_acnt_nme->account_uid }}
                </td>
                <td class="align_left text-left tbl_txt_25">
                    {!! $sp_acnt_nme->account_name !!}
                </td>
                <td class="align_left text-left tbl_txt_31">
{{--                    {!! $item->spi_remarks !!}--}}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15"> </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{ (!empty($adv_amnt_deduct)) ? number_format($adv_amnt_deduct,2) : "" }}
                </td>
            </tr>
            @php endif; @endphp

            @php $i++; @endphp

        @endforeach
        <tr class="border-0">
            <th colspan="4" align="right" class="border-0 pt-0 text-right align_right">
                Grand Total:
            </th>
            <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($grand_total,2) }}
            </td>
            <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($ttl_paid,2) }}
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

            <a href="{{ route('salary_payment_items_view_details_pdf_SH',['id'=>$slry_pmnt->sp_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download/Get PDF/Print
            </a>
        </div>
    @endif

</div>
<div class="input_bx_ftr"></div>

@endsection