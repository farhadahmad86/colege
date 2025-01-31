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
{{--@php--}}
{{--$company_info = Session::get('company_info');--}}
{{--@endphp--}}
{{--<div id="" class="table-responsive" style="z-index: 9;">--}}

{{--        <table class="table table-bordered table-sm">--}}
{{--            @if($type === 'grid')--}}
{{--                @include('voucher_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title, $invoice_remarks])--}}
{{--            @endif--}}
{{--        </table>--}}
{{--    <table class="table table-bordered table-sm" id="" style="background-image: url({{ asset('public/vendors/images/invoice_background.png') }}); background-repeat: no-repeat;background-position: left top;-webkit-background-size: 100% auto;background-size: 100% auto;">--}}

{{--        <tr class="bg-transparent">--}}
{{--            <td colspan="3" class="p-0 border-0">--}}
{{--                <img src="{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_logo : 'N/A'}}" alt="Company Logo" width="170" />--}}
{{--                <p class="invoice_para adrs m-0">--}}
{{--                    <b> Adrs: </b>--}}
{{--                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_address : 'N/A'}}--}}
{{--                </p>--}}
{{--                <p class="invoice_para m-0 pt-5">--}}
{{--                    <b> Mob #: </b>--}}
{{--                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_mobile_numer : 'N/A'}}--}}
{{--                </p>--}}
{{--            </td>--}}
{{--            <td colspan="3" class="p-0 border-0 text-right align_right">--}}
{{--                <h2 class="invoice_hdng">--}}
{{--                    Advance Salary JV--}}
{{--                </h2>--}}
{{--                <p class="invoice_para m-0">--}}
{{--                    <b> ASV #: </b>--}}
{{--                    {{ $adv_sal->as_id }}--}}
{{--                </p>--}}
{{--                <p class="invoice_para m-0 pt-5">--}}
{{--                    <b> Date: </b>--}}
{{--                    {{date('d-M-y', strtotime(str_replace('/', '-', $adv_sal->as_day_end_date))) }}--}}
{{--                    {{date('d-M-y', strtotime(str_replace('/', '-', $adv_sal->as_send_datetime))) }}--}}
{{--                </p>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        <tr class="bg-transparent">--}}
{{--            <td colspan="6" class="p-0 border-0">--}}
{{--                <p class="invoice_para pt-5 mt-0 mb-10">--}}
{{--                    <b> Remarks: </b>--}}
{{--                    {{ $adv_sal->as_remarks }}--}}
{{--                </p>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}
    <table class="table table-bordered table-sm" id="">
        <thead>
        <tr class="headings vi_tbl_hdng">
            <th scope="col" class="v_wdth_1 text-center">Sr.</th>
            <th scope="col" class="v_wdth_2 text-center">Account No.</th>
            <th scope="col" class="v_wdth_3 text-left">Account Name</th>
            <th scope="col" class="v_wdth_3 text-left">Month</th>
            <th scope="col" class="v_wdth_4 text-left">Remarks</th>
            <th scope="col" class="v_wdth_5 text-center">Dr.</th>
            <th scope="col" class="v_wdth_5 text-center">Cr.</th>
        </tr>
        </thead>

        <tbody>
            @php
                $i = $dr_val = $cr_cal = 0;
                $dr_val = $adv_sal->as_amount;
                $cr_val = $adv_sal->as_amount;
            @endphp
            @php $i = 1; $grand_total = $ttl_dr = $ttl_cr = $adv_amnt = $adv_amnt_deduct = $ttl_paid = 0; $vchr_id = ''; @endphp
            @foreach( $items as $item )
                @php $vchr_id = $item->asi_as_id; @endphp
            <tr class="even pointer">
                <td class="v_wdth_1 align_center text-center">
                    {{ $i }}
                </td>

                <td class="v_wdth_2 align_center text-center">
                    {{ $item->asi_emp_advance_salary_account }}
                </td>

                <td class="v_wdth_3 align_left text-left">
                    {{ $item->asi_emp_advance_salary_account_name }}
{{--                    {{ $usr_rcvd }}--}}
                </td>
                <td class="v_wdth_3 align_left text-left">
                    {{ $item->asi_month_year }}
{{--                    {{ $usr_rcvd }}--}}
                </td>

                <td class="v_wdth_4 align_left text-left">
                    {!! $item->asi_remarks !!}
                </td>

{{--                <td class="v_wdth_5 align_right text-right">--}}
{{--                    {{ (!empty($dr_val)) ? number_format($dr_val,2) : ""  }}--}}
{{--                </td>--}}

                <td align="right" class="align_right text-right tbl_amnt_15">
                    @php
                        $DR_val = ($vchr_id === $item->asi_as_id) ? $item->asi_amount : "";
                        $DR = (!empty($DR_val)) ? $DR_val : "0";
                        $grand_total = +(+$grand_total + +$DR);
                    @endphp
                    {{ (!empty($grand_total)) ? number_format($DR_val,2) : ""  }}
                </td>

                <td class="v_wdth_5 align_right text-right">

                </td>
            </tr>

            @php $i++; @endphp
@endforeach
            <tr class="even pointer">
                <td class="v_wdth_1 align_center text-center">
                    {{ $i }}
                </td>
                <td class="v_wdth_2 align_center text-center">
                    {{ $adv_sal->as_from_pay_account }}
                </td>
                <td class="v_wdth_3 align_left text-left">
                    {{ $usr_snd }}
                </td>
                <td class="v_wdth_3 align_left text-left">
                    {{ $adv_sal->as_month }}
                </td>
                <td class="v_wdth_4 align_left text-left">
                    {!! $adv_sal->as_remarks !!}
                </td>
                <td class="v_wdth_5 align_right text-right">

                </td>
                <td class="v_wdth_5 align_right text-right">
                    {{ (!empty($cr_val)) ? number_format($cr_val,2) : "" }}
                </td>
            </tr>


        </tbody>
        <tfoot>
        <tr class="border-0">
            <th colspan="5" align="right" class="border-0 pt-0 text-right align_right">
                Grand Total:
            </th>
            <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($grand_total,2) }}
            </td>
            <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($cr_val,2) }}
            </td>
        </tr>
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
                             {{ $adv_sal->user->user_name }}
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
        </tfoot>

    </table>

    <div class="clearfix"></div>
        @if( $type === 'grid')
    <div class="itm_vchr_rmrks">

        <a href="{{ route('advance_salary_view_details_pdf_SH',['id'=>$adv_sal->as_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Download/Get PDF/Print
        </a>
    </div>
        @endif
</div>
<div class="input_bx_ftr"></div>
@endsection


