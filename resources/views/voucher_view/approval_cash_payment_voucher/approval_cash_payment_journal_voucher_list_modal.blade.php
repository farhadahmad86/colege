@extends('invoice_view.print_index')

@section('print_cntnt')

@php
    $company_info = Session::get('company_info');
@endphp

<div id="" class="table-responsive">

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
            <th scope="col" class="text-left tbl_txt_25">
                Account Name
            </th>
            <th scope="col" class="text-left tbl_txt_31">
                Detail Remarks
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
                $vchr_id = $item->acpi_salary_payment_voucher_id;

                $DR_val = ($vchr_id === $item->acpi_salary_payment_voucher_id) ? $item->acpi_amount : "";
                $DR = (!empty($DR_val)) ? $DR_val : "0";
                $grand_total = +(+$grand_total + +$DR);

                if( $item->acpi_deduct_amount > 0 ):
                    $adv_amnt = $item->acpi_deduct_amount;
                endif;

                $ttl_paid = +$ttl_paid + +$DR;

                if($loop->last){
                    $vchr_id++;
                }

            @endphp

            <tr class="even pointer">
                <td class="align_center text-center tbl_srl_4">
                    {{ $i }}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{ $item->acpi_account_id }}
                </td>
                <td class="align_left text-left tbl_txt_25">
                    {!! $item->acpi_account_name !!}
                </td>
                <td class="align_left text-left tbl_txt_31">
                    {!! $item->acpi_remarks !!}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{ (!empty($DR_val)) ? number_format($DR_val,2) : ""  }}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                </td>
            </tr>


            @if( $vchr_id !== $item->acpi_salary_payment_voucher_id)
                <tr class="even pointer">
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td class="align_center text-center tbl_amnt_10">
                        {{ $acp_acnt_nme->account_uid }}
                    </td>
                    <td class="align_left text-left tbl_txt_25">
                        {!! $acp_acnt_nme->account_name !!}
                    </td>
                    <td class="align_left text-left tbl_txt_31">
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                        {{ (!empty($ttl_paid)) ? number_format($ttl_paid,2) : "" }}
                    </td>
                </tr>

                @php
                    $i++;
                @endphp
            @endif



            @php
                $i++;
            @endphp

        @endforeach


        </tbody>
        <tfoot>
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
        </tr>
        </tfoot>

    </table>

    <div class="clearfix"></div>
    @if( $type === 'grid')
        <div class="itm_vchr_rmrks">

            <a href="{{ route('approval_cash_payment_items_view_details_pdf_SH',['id'=>$csh_pymnt->acp_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download/Get PDF/Print
            </a>
        </div>
    @endif

</div>
<div class="input_bx_ftr"></div>

@endsection
