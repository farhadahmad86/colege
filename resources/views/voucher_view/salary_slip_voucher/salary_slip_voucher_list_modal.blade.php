@extends('invoice_view.print_index')

@section('print_cntnt')

@php
    $company_info = Session::get('company_info');
@endphp


<div id="" class="table-responsive" style="z-index: 9;">


    <table class="table border-0 table-sm p-0 m-0">
        @if($type === 'grid')
            @include('voucher_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title, $invoice_remarks, $slry_slp])
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
        @php $i = 1; $dr = $cr = $ttl_dr = $ttl_cr = 0; $vchr_id = ''; @endphp

        @if(isset($slry_slp->ss_gross_salary) && !empty($slry_slp->ss_gross_salary))
            @php
                $ttl_dr = $slry_slp->ss_gross_salary;
            @endphp
            <tr class="even pointer">
                <td class="align_center text-center tbl_srl_4">
                    {{ $i }}
                </td>
                <td align="center" class="align_center text-center tbl_amnt_10">
                    {{ $emply->user_employee_code }}
                </td>
                <td class="align_left text-left tbl_txt_25">
                    {!! $emply->user_name !!}
                </td>
                <td class="align_left text-left tbl_txt_31">
                    {!! $slry_slp->ss_remarks !!}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{ (!empty($slry_slp->ss_gross_salary)) ? number_format($slry_slp->ss_gross_salary,2) : ""  }}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                </td>
            </tr>
            @php $i++; @endphp
        @endif

        @foreach( $items as $item )
            @if($item->ssi_allow_deduc === '1')
                @php
                    $dr = $item->ssi_amount;
                    $ttl_dr = +$dr + +$ttl_dr;
                @endphp
                <tr class="even pointer">
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_10">
                        {{ $item->ssi_account_id }}
                    </td>
                    <td class="align_left text-left tbl_txt_25">
                        {!! $item->ssi_account_name !!}
                    </td>
                    <td class="align_left text-left tbl_txt_31">
                        {!! $item->ssi_remarks !!}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                        {{ (!empty($dr)) ? number_format($dr,2) : ""  }}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_15">
                    </td>
                </tr>
            @endif

            @if($item->ssi_allow_deduc === '2')
                @php
                    $cr = $item->ssi_amount;
                    $ttl_cr = +$cr + +$ttl_cr;
                @endphp
            <tr class="even pointer">
                <td class="align_center text-center tbl_srl_4">
                    {{ $i }}
                </td>
                <td align="center" class="align_center text-center tbl_amnt_10">
                    {{ $item->ssi_adv_account_id }}
                </td>
                <td class="align_left text-left tbl_txt_25">
                    {!! $item->ssi_adv_account_name !!}
                </td>
                <td class="align_left text-left tbl_txt_31">
                    {!! $item->ssi_remarks !!}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{ (!empty($cr)) ? number_format($cr,2) : ""  }}
                </td>
            </tr>
            @endif


            @php $i++; @endphp
        @endforeach

        @if(isset($slry_slp->ss_net_salary) && !empty($slry_slp->ss_net_salary))
            @php
                $ttl_cr = +$ttl_cr + +$slry_slp->ss_net_salary;
            @endphp
            <tr class="even pointer">
                <td class="align_center text-center tbl_srl_4">
                    {{ $i }}
                </td>
                <td align="center" class="align_center text-center tbl_amnt_10">
                    {{ $emply->user_employee_code }}
                </td>
                <td class="align_left text-left tbl_txt_25">
                    {!! $emply->user_name !!}
                </td>
                <td class="align_left text-left tbl_txt_31">
                    {!! $slry_slp->ss_remarks !!}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{ (!empty($slry_slp->ss_net_salary)) ? number_format($slry_slp->ss_net_salary,2) : ""  }}
                </td>
            </tr>
            @php $i++; @endphp
        @endif

        </tbody>

        <tr class="border-0">
            <th colspan="4" align="right" class="border-0 pt-0 text-right align_right">
                Grand Total:
            </th>
            <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($ttl_dr,2) }}
            </td>
            <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($ttl_cr,2) }}
            </td>
        </tr>

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
        </tr>
        </tfoot>

    </table>

    <div style="clear:both"></div>
    @if( $type === 'grid')
        <div class="itm_vchr_rmrks ">
            <a href="{{ route('salary_slip_items_view_details_pdf_SH',['id'=>$slry_slp->ss_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download/Get PDF/Print
            </a>
        </div>
    @endif

</div>
<div class="input_bx_ftr"></div>

@endsection