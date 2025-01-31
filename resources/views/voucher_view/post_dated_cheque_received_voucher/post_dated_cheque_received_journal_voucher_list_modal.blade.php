@extends('invoice_view.print_index')

@section('print_cntnt')

@php
    $company_info = Session::get('company_info');
@endphp


<div id="" class="table-responsive" style="z-index: 9;">

    <table class="table table-bordered table-sm">
        @if($type === 'grid')
            @include('voucher_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title, $invoice_remarks])
        @endif
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
            <th scope="col" class="text-center tbl_txt_26">Account Name
            </th>
            <th scope="col" class="text-center tbl_amnt_10">
                Cheque Date
            </th>
            <th scope="col" class="text-center tbl_amnt_10">
                Type
            </th>
            <th scope="col" class="text-center tbl_amnt_10">
                Status
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
            @php
                $i = 1; $dr_val = $cr_cal = 0;
                $dr_val = $pdc->pdc_amount;
                $cr_val = $pdc->pdc_amount;
            @endphp

            <tr class="even pointer">
                <td class="align_center text-center tbl_srl_4">
                    {{ $i }}
                </td>
                <td align="center" class="align_center text-center tbl_amnt_10">
                    {{ $to->account_uid }}
                </td>
                <td class="align_left text-left tbl_txt_26">
                    {{ $to->account_name }}
                </td>
                <td align="center" class="fnt_less text-center align_center tbl_amnt_10">
                    {!! $pdc->pdc_cheque_date !!}
                </td>
                <td class="fnt_less text-left align_left tbl_amnt_10">
                    {!! $pdc->pdc_type !!}
                </td>
                <td class="fnt_less text-left align_left tbl_amnt_10">
                    {!! $pdc->pdc_status !!}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{ (!empty($dr_val)) ? number_format($dr_val,2) : ""  }}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                </td>
            </tr>

            @php $i++; @endphp


            <tr class="even pointer">
                <td class="align_center text-center tbl_srl_4">
                    {{ $i }}
                </td>
                <td align="center" class="align_center text-center tbl_amnt_10">
                    {{ $from->account_uid }}
                </td>
                <td class="align_left text-left tbl_txt_26">
                    {{ $from->account_name }}
                </td>
                <td align="center" class="fnt_less text-center align_center tbl_amnt_10">
                    {!! $pdc->pdc_cheque_date !!}
                </td>
                <td class="fnt_less text-left align_left tbl_amnt_10">
                    {!! $pdc->pdc_type !!}
                </td>
                <td class="fnt_less text-left align_left tbl_amnt_10">
                    {!! $pdc->pdc_status !!}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{ (!empty($dr_val)) ? number_format($dr_val,2) : ""  }}
                </td>
            </tr>


        </tbody>

        <tr class="border-0">
            <th colspan="6" align="right" class="border-0 pt-0 text-right align_right">
                Grand Total:
            </th>
            <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($dr_val,2) }}
            </td>
            <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($cr_val,2) }}
            </td>
        </tr>


        <tfoot>
        <tr>
            <td colspan="8" class="border-0 p-0">
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
        </tfoot>

    </table>

    <div class="clearfix"></div>
    @if( $type === 'grid')
        <div class="itm_vchr_rmrks">

            <a href="{{ route('post_dated_cheque_received_pdf_SH',['id'=>$pdc->pdc_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download/Get PDF/Print
            </a>
        </div>
    @endif

</div>
<div class="input_bx_ftr"></div>

@endsection