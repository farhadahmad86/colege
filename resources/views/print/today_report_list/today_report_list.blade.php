
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table table-bordered table-sm">

        <thead>
        <tr>
            <th scope="col" class="text-center align_center tbl_srl_4">
                Sr#
            </th>
            <th scope="col" class="text-center align_center tbl_srl_8">
                Transaction ID
            </th>
            <th scope="col" class="align_center text-center tbl_amnt_9">
                Date
            </th>
            <th scope="col" class="align_center text-center tbl_amnt_6">
                Voucher No.
            </th>
            <th scope="col" class="align_center text-center tbl_txt_43">
                Ledger/Account Name
            </th>

            <th scope="col" class="align_center text-center tbl_amnt_10">
                DR
            </th>
            <th scope="col" class="align_center text-center tbl_amnt_10">
                CR
            </th>
            <th scope="col" class="text-center align_center tbl_txt_10">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            //$p=1;
              $ttlPrc = 0;
        @endphp
        {{--        <tr>--}}
        {{--            <th colspan="8" class="align_left text-left border-0">--}}
        {{--                Purchase--}}
        {{--            </th>--}}
        {{--        </tr>--}}
        {{--        @forelse($allData['datas'] as $invoice)--}}

        {{--            <tr>--}}
        {{--                <td class="align_center text-center tbl_srl_4">--}}
        {{--                    {{$p}}--}}
        {{--                </td>--}}
        {{--                <td class="align_center text-center tbl_srl_4">--}}
        {{--                    {{$invoice->pi_id}}--}}
        {{--                </td>--}}
        {{--                <td nowrap class="align_center text-center tbl_amnt_9">--}}
        {{--                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->pi_day_end_date)))}}--}}
        {{--                </td>--}}
        {{--                <td class="align_center text-center tbl_amnt_6" data-id="{{$invoice->pi_id}}">--}}
        {{--                    PI-{{$invoice->pi_id}}--}}
        {{--                </td>--}}
        {{--                --}}{{--                                    <td  class="align_left" style="white-space:pre-wrap;">{{$invoice->pi_detail_remarks}}</td>--}}
        {{--                <td class="align_left text-left tbl_txt_21">--}}
        {{--                    {{$invoice->pi_party_name}}--}}
        {{--                </td>--}}

        {{--                @php--}}
        {{--                    $ttlPrc = +($invoice->pi_total_price) + +$ttlPrc;--}}
        {{--                @endphp--}}
        {{--                <td class="align_right text-right tbl_amnt_5">--}}
        {{--                    {{$invoice->pi_total_price !=0 ? number_format($invoice->pi_total_price,2):''}}--}}
        {{--                </td>--}}


        {{--                <td class="align_right text-right tbl_amnt_5">--}}

        {{--                </td>--}}

        {{--                @php--}}
        {{--                    $ip_browser_info= ''.$invoice->pi_ip_adrs.','.str_replace(' ','-',$invoice->pi_brwsr_info).'';--}}
        {{--                @endphp--}}

        {{--                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}"--}}
        {{--                    title="Click To See User Detail">--}}
        {{--                    {{$invoice->user_name}}--}}
        {{--                </td>--}}

        {{--            </tr>--}}
        {{--            @php--}}
        {{--                $p++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;--}}
        {{--            @endphp--}}
        {{--        @empty--}}
        {{--            <tr>--}}
        {{--                <td colspan="15">--}}
        {{--                    <center><h6 style="color:#554F4F">No Purchase Invoice</h6></center>--}}
        {{--                </td>--}}
        {{--            </tr>--}}
        {{--        @endforelse--}}

        {{--        <tr>--}}
        {{--            <th colspan="5" class="align_right text-right border-0">--}}
        {{--                Total:---}}
        {{--            </th>--}}
        {{--            <td class="align_right text-right border-0">--}}
        {{--                {{ number_format($ttlPrc,2) }}--}}
        {{--            </td>--}}
        {{--            <td class="align_right text-right border-0">--}}
        {{--                0.00--}}
        {{--            </td>--}}

        {{--        </tr>--}}


        {{--        <tr>--}}
        {{--            <th colspan="8" class="align_left text-left border-0">--}}
        {{--                Sale--}}
        {{--            </th>--}}
        {{--        </tr>--}}

        {{--        @php--}}
        {{--            $s = 1;--}}
        {{--            $ttlSale = 0;--}}
        {{--        @endphp--}}
        {{--        @forelse($allData['datas_sale'] as $invoice)--}}

        {{--            <tr>--}}
        {{--                <td class="align_center text-center tbl_srl_4">--}}
        {{--                    {{$s}}--}}
        {{--                </td>--}}
        {{--                <td class="align_center text-center tbl_srl_4">--}}
        {{--                    {{$invoice->si_id}}--}}
        {{--                </td>--}}
        {{--                <td nowrap class="align_center text-center tbl_amnt_9">--}}
        {{--                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->si_day_end_date)))}}--}}
        {{--                </td>--}}
        {{--                <td class="align_center text-center tbl_amnt_6" data-id="{{$invoice->si_id}}">--}}
        {{--                    SI-{{$invoice->si_id}}--}}
        {{--                </td>--}}
        {{--                --}}{{--                                    <td  class="align_left" style="white-space:pre-wrap;">{{$invoice->si_detail_remarks}}</td>--}}
        {{--                <td class="align_left text-left tbl_txt_21">--}}
        {{--                    {{$invoice->si_party_name}}--}}
        {{--                </td>--}}

        {{--                @php--}}
        {{--                    $ttlSale = +($invoice->si_total_price) + +$ttlSale;--}}
        {{--                @endphp--}}
        {{--                <td class="align_right text-right tbl_amnt_5">--}}

        {{--                </td>--}}

        {{--                <td class="align_right text-right tbl_amnt_5">--}}
        {{--                    {{$invoice->si_total_price !=0 ? number_format($invoice->si_total_price,2):''}}--}}
        {{--                </td>--}}

        {{--                @php--}}
        {{--                    $ip_browser_info= ''.$invoice->si_ip_adrs.','.str_replace(' ','-',$invoice->si_brwsr_info).'';--}}
        {{--                @endphp--}}

        {{--                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}"--}}
        {{--                    title="Click To See User Detail">--}}
        {{--                    {{$invoice->user_name}}--}}
        {{--                </td>--}}

        {{--            </tr>--}}
        {{--            @php--}}
        {{--                $s++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;--}}
        {{--            @endphp--}}
        {{--        @empty--}}
        {{--            <tr>--}}
        {{--                <td colspan="15">--}}
        {{--                    <center><h6 style="color:#554F4F">No Sale Invoice</h6></center>--}}
        {{--                </td>--}}
        {{--            </tr>--}}
        {{--        @endforelse--}}

        {{--        <tr>--}}
        {{--            <th colspan="5" class="align_right text-right border-0">--}}
        {{--                Total:---}}
        {{--            </th>--}}
        {{--            <td class="align_right text-right border-0">--}}
        {{--                0.00--}}
        {{--            </td>--}}
        {{--            <td class="align_right text-right border-0">--}}
        {{--                {{ number_format($ttlSale,2) }}--}}
        {{--            </td>--}}
        {{--        </tr>--}}


        <tr>
            <th colspan="8" class="align_left text-left border-0">
                Cash Receipt Voucher
            </th>

        </tr>
        @php
            $cr = 1;
            $ttl_amnt = 0;
        @endphp
        @forelse($allData['datas_crp'] as $voucher)

            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$cr}}
                </td>
                <td class="align_center text-center tbl_srl_4">
                    {{$voucher->cr_id}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->cr_day_end_date)))}}
                </td>
                <td class="align_center text-center tbl_amnt_6" data-id="{{$voucher->cr_id}}">
                    CRV-{{$voucher->cr_id}}
                </td>
                <td class="align_left text-left tbl_txt_21">
                    {{$voucher->account_name}}
                </td>
                {{--                                cr_total_amount--}}
                @php $ttl_amnt  = $ttl_amnt + $voucher->cri_amount; @endphp
                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->cri_amount !=0 ? number_format($voucher->cri_amount,2):''}}
                </td>
                <td class="align_right text-right tbl_amnt_10">

                </td>

                @php
                    $ip_browser_info= ''.$voucher->cr_ip_adrs.','.str_replace(' ','-',$voucher->cr_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$voucher->user_name}}
                </td>
            </tr>
            @php
                $cr++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h6 style="color:#554F4F">No Cash Receipt Voucher</h6></center>
                </td>
            </tr>
        @endforelse

        <tr>
            <th colspan="5" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                {{ number_format($ttl_amnt,2) }}
            </td>
            <td class="align_right text-right border-0">
                0.00
            </td>

        </tr>

        <th colspan="8" class="align_left text-left border-0">
            Cash Payment Voucher
        </th>

        @php
            $cp = 1;
            $cp_amnt = 0;
        @endphp
        @forelse($allData['datas_cp'] as $voucher)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$cp}}
                </td>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$voucher->cp_id}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->cp_day_end_date)))}}
                </td>
                <td class="align_center text-center tbl_amnt_6" data-id="{{$voucher->cp_id}}">
                    CPV-{{$voucher->cp_id}}
                </td>
                <td class="align_left text-left tbl_txt_21">
                    {{$voucher->account_name}}
                </td>

                <td class="align_right text-right tbl_amnt_10">

                </td>
                {{--                                cp_total_amount--}}
                @php $cp_amnt = $cp_amnt + $voucher->cpi_amount; @endphp
                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->cpi_amount !=0 ? number_format($voucher->cpi_amount,2):''}}
                </td>

                @php
                    $ip_browser_info= ''.$voucher->cp_ip_adrs.','.str_replace(' ','-',$voucher->cp_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$voucher->user_name}}
                </td>

            </tr>
            @php
                $cp++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h6 style="color:#554F4F">No Cash Payment Voucher</h6></center>
                </td>
            </tr>
        @endforelse

        <tr>
            <th colspan="5" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                0.00
            </td>
            <td class="align_right text-right border-0">
                {{ number_format($cp_amnt,2) }}
            </td>
        </tr>

        <th colspan="8" class="align_left text-left border-0">
            Bank Receipt Voucher
        </th>

        @php
            $br = 1;
            $brv_ttl_amnt = 0;
        @endphp
        @forelse($allData['datas_br'] as $voucher)

            <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                <td class="align_center text-center edit tbl_srl_4">
                    {{$br}}
                </td>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$voucher->br_id}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->br_created_datetime)))}}
                </td>
                <td class="align_center text-center tbl_amnt_6" data-id="{{$voucher->br_id}}">
                    BRV-{{$voucher->br_id}}
                </td>
                <td class="align_left text-left tbl_txt_21">
                    {{$voucher->account_name}}
                </td>
                {{--                                br_total_amount--}}
                @php $brv_ttl_amnt = $brv_ttl_amnt + $voucher->bri_amount;@endphp
                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->bri_amount !=0 ? number_format($voucher->bri_amount,2):''}}
                </td>
                <td class="align_right text-right tbl_amnt_10">

                </td>

                @php
                    $ip_browser_info= ''.$voucher->br_ip_adrs.','.str_replace(' ','-',$voucher->br_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$voucher->user_name}}
                </td>

            </tr>
            @php
                $br++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h6 style="color:#554F4F">No Bank Receipt Voucher</h6></center>
                </td>
            </tr>
        @endforelse


        <tr>
            <th colspan="5" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                {{ number_format($brv_ttl_amnt,2) }}
            </td>
            <td class="align_right text-right border-0">
                0.00
            </td>
        </tr>
        <th colspan="8" class="align_left text-left border-0">
            Bank Payment Voucher
        </th>

        @php
            $bp = 1;
            $bp_ttl_amnt = 0;
        @endphp
        @forelse($allData['datas_bp'] as $voucher)

            <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                <td class="align_center text-center tbl_srl_4">
                    {{$bp}}
                </td>
                <td class="align_center text-center tbl_srl_4">
                    {{$voucher->bp_id}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->bp_day_end_date)))}}
                </td>
                <td class="align_center text-center tbl_amnt_6" data-id="{{$voucher->bp_id}}">
                    BPV-{{$voucher->bp_id}}
                </td>
                <td class="align_left text-left tbl_txt_21">
                    {{$voucher->account_name}}
                </td>
                {{--                                bp_total_amount--}}
                @php $bp_ttl_amnt = $bp_ttl_amnt + $voucher->bpi_amount;@endphp
                <td class="align_right text-right tbl_amnt_10">

                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->bpi_amount !=0 ? number_format($voucher->bpi_amount,2):''}}
                </td>

                @php
                    $ip_browser_info= ''.$voucher->bp_ip_adrs.','.str_replace(' ','-',$voucher->bp_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$voucher->user_name}}
                </td>

            </tr>
            @php
                $bp++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h6 style="color:#554F4F">No Bank Payment Voucher</h6></center>
                </td>
            </tr>
        @endforelse
        <tr>
            <th colspan="5" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                0.00
            </td>
            <td class="align_right text-right border-0">
                {{ number_format($bp_ttl_amnt,2) }}
            </td>
        </tr>

        <th colspan="8" class="align_left text-left border-0">
            Expense Payment Voucher
        </th>

        @php
            $ep = 1;
            $ep_ttl_amnt = 0;
        @endphp
        @forelse($allData['datas_ep'] as $voucher)

            <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                <td class="align_center text-center edit tbl_srl_4">
                    {{$ep}}
                </td>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$voucher->ep_id}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->ep_day_end_date)))}}
                </td>
                <td data-id="{{$voucher->ep_id}}" class="align_center text-center tbl_amnt_6">
                    EPV-{{$voucher->ep_id}}
                </td>
                <td class="align_left text-left tbl_txt_21">
                    {{$voucher->account_name}}
                </td>

                <td class="align_right text-right tbl_amnt_10">

                </td>
                @php $ep_ttl_amnt = $ep_ttl_amnt + $voucher->ep_total_amount;  @endphp
                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->ep_total_amount !=0 ? number_format($voucher->ep_total_amount,2):''}}
                </td>

                @php
                    $ip_browser_info= ''.$voucher->ep_ip_adrs.','.str_replace(' ','-',$voucher->ep_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$voucher->user_name}}
                </td>

            </tr>
            @php
                $ep++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h6 style="color:#554F4F">No Expense Payment Voucher</h6></center>
                </td>
            </tr>
        @endforelse
        <tr>
            <th colspan="5" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                0.00
            </td>
            <td class="align_right text-right border-0">
                {{ number_format($ep_ttl_amnt,2) }}
            </td>
        </tr>

        <th colspan="8" class="align_left text-left border-0">
            Journal Voucher
        </th>

        @php
            $jv=1;
            $ttl_dr = $ttl_cr = 0;
        @endphp
        @forelse($allData['datas_jv'] as $voucher)

            <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                <td class="align_center text-center edit tbl_srl_4">
                    {{$jv}}
                </td>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$voucher->jv_id}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->jv_day_end_date)))}}
                </td>
                <td class="align_center text-center tbl_amnt_6" data-id="{{$voucher->jv_id}}">
                    JV-{{$voucher->jv_id}}
                </td>

                <td class="align_left text-left tbl_txt_21">
                    {!! $voucher->account_name !!}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    @php
                        $DR_val = ($voucher->jvi_type === "Dr") ? $voucher->jvi_amount : "";
                        $DR = ($voucher->jvi_type === "Dr") ? $DR_val : "0";
                        $ttl_dr = +$ttl_dr + +$DR;
                    @endphp
                    {{ (!empty($DR_val)) ? number_format($DR_val,2) : '' }}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    @php
                        $CR_val = ($voucher->jvi_type === "Cr") ? $voucher->jvi_amount : "";
                        $CR = ($voucher->jvi_type === "Cr") ? $CR_val : "0";
                        $ttl_cr = +$ttl_cr + +$CR;
                    @endphp
                    {{ (!empty($CR_val)) ? number_format($CR_val,2) : '' }}
                </td>

                @php
                    $ip_browser_info= ''.$voucher->jv_ip_adrs.','.str_replace(' ','-',$voucher->jv_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$voucher->user_name}}
                </td>
            </tr>
            @php
                $jv++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h6 style="color:#554F4F">No Journal Voucher</h6></center>
                </td>
            </tr>
        @endforelse
        <tr>
            <th colspan="5" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                {{ number_format($ttl_dr,2) }}
            </td>
            <td class="align_right text-right border-0">
                {{ number_format($ttl_cr,2) }}
            </td>
        </tr>


        <th colspan="8" class="align_left text-left border-0">
            Journal Voucher Reference
        </th>

        @php
            $jvr=1;
            $ttls_dr = $ttls_cr = 0;
        @endphp
        @forelse($allData['datas_jvr'] as $voucher)
            @php
                //$ttls_dr = +$voucher->jvr_total_dr + +$ttls_dr;
                //$ttls_cr = +$voucher->jvr_total_cr + +$ttls_cr;
            @endphp

            <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                <td class="align_center text-center edit tbl_srl_4">
                    {{$jvr}}
                </td>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$voucher->jvr_id}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->jvr_day_end_date)))}}
                </td>
                <td class="align_center text-center tbl_amnt_6" data-id="{{$voucher->jvr_id}}">
                    JVR-{{$voucher->jvr_id}}
                </td>

                <td class="align_left text-left tbl_txt_21">
                    {!! $voucher->account_name !!}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    @php
                        $DR_val = ($voucher->jvri_type === "Dr") ? $voucher->jvri_amount : "";
                        $DR = ($voucher->jvri_type === "Dr") ? $DR_val : "0";
                        $ttls_dr = +$ttls_dr + +$DR;
                    @endphp
                    {{ (!empty($DR_val)) ? number_format($DR_val,2) : '' }}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    @php
                        $CR_val = ($voucher->jvri_type === "Cr") ? $voucher->jvri_amount : "";
                        $CR = ($voucher->jvri_type === "Cr") ? $CR_val : "0";
                        $ttls_cr = +$ttls_cr + +$CR;
                    @endphp
                    {{ (!empty($CR_val)) ? number_format($CR_val,2) : '' }}
                </td>

                @php
                    $ip_browser_info= ''.$voucher->jvr_ip_adrs.','.str_replace(' ','-',$voucher->jvr_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$voucher->user_name}}
                </td>
            </tr>
            @php
                $jvr++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h6 style="color:#554F4F">No Journal Voucher Reference</h6></center>
                </td>
            </tr>
        @endforelse
        <tr>
            <th colspan="5" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                {{ number_format($ttls_dr,2) }}
            </td>
            <td class="align_right text-right border-0">
                {{ number_format($ttls_cr,2) }}
            </td>
        </tr>

        <th colspan="8" class="align_left text-left border-0">
            Advance Salary Voucher
        </th>


        @php
            $as=1;
            $ttl_salary_amnt = 0;
        @endphp
        @forelse($allData['datas_as'] as $salary)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$as}}
                </td>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$salary->as_id}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $salary->as_datetime)))}}
                </td>
                {{--                                    <td class="align_center text-center">{{$salary->as_id}}</td>--}}

                <td class="text-center align_center tbl_amnt_9">
                    {{'ASV-'.$salary->as_id}}
                </td>
                {{--                                    <td class="align_left text-left tbl_txt_15">--}}
                {{--                                        {{$salary->from}}--}}
                {{--                                    </td>--}}

                <td class="align_left text-left tbl_txt_21">
                    {{--                                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $salary->as_detail_remarks) !!}--}}
                    {!! $salary->employee_account !!}
                </td>
                @php $ttl_salary_amnt = +$salary->asi_amount + +$ttl_salary_amnt; @endphp

                <td class="align_right text-right tbl_amnt_15">
                    {{$salary->asi_amount}}
                </td>
                <td class="align_right text-right tbl_amnt_15">

                </td>

                @php
                    $ip_browser_info= ''.$salary->as_ip_adrs.','.str_replace(' ','-',$salary->as_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $salary->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                    title="Click To See User Detail">
                    {{$salary->user_name}}
                </td>
            </tr>
            @php
                $as++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h6 style="color:#554F4F">No Advance Salary Entry</h6></center>
                </td>
            </tr>
        @endforelse
        <tr>
            <th colspan="5" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                {{ number_format($ttl_salary_amnt,2) }}
            </td>
            <td class="align_right text-right border-0">
                0.00
            </td>
        </tr>

        <th colspan="8" class="align_left text-left border-0">
            Salary Payment Voucher
        </th>
        @php
            $sp=1;
                $ttl_pay_amnt = 0;
        @endphp
        @forelse($allData['datas_sp'] as $voucher)
            @php $ttl_pay_amnt = +$voucher->spi_paid_amount + +$ttl_pay_amnt; @endphp

            <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                <th scope="row">
                    {{$sp}}
                </th>
                <th scope="row">
                    {{$voucher->sp_id}}
                </th>
                <td>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->sp_day_end_date)))}}
                </td>
                <td>
                    SPV-{{$voucher->sp_id}}
                </td>

                <td>
                    <div class="">

                        {!! str_replace("&oS;",'<br />', $voucher->spi_account_name) !!}
                    </div>
                </td>
                <td align="right" class="align_right text-right">
                    {{$voucher->spi_paid_amount !=0 ? number_format($voucher->spi_paid_amount,2):''}}
                </td>
                <td align="right" class="align_right text-right">
                </td>

                @php
                    $ip_browser_info= ''.$voucher->sp_ip_adrs.','.str_replace(' ','-',$voucher->sp_brwsr_info).'';
                @endphp

                <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$voucher->user_name}}
                </td>
            </tr>
            @php
                $sp++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h6 style="color:#554F4F">No Salary Payment Voucher</h6></center>
                </td>
            </tr>
        @endforelse
        <tr>
            <th colspan="5" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                {{ number_format($ttl_pay_amnt,2) }}
            </td>
            <td class="align_right text-right border-0">
                0.00
            </td>
        </tr>

        <th colspan="8" class="align_left text-left border-0">
            Salary Slip Voucher
        </th>

        @php
            $ss=1;
            $ss_ttl_amnt = 0;
        @endphp
        @forelse($allData['datas_ss'] as $voucher)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$ss}}
                </td>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$voucher->ss_id}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->ss_day_end_date)))}}
                </td>
                <td class="align_center text-center tbl_amnt_9">
                    SSV-{{$voucher->ss_id}}
                </td>
                <td class="align_left text-left tbl_txt_21">
                    {{--                                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $voucher->ss_detail_remarks) !!}--}}
                    {!! $voucher->ssi_account_name !!}
                </td>
                @php $ss_ttl_amnt = +$voucher->ssi_amount + +$ss_ttl_amnt; @endphp

                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->ssi_amount !=0 ? number_format($voucher->ssi_amount,2):''}}
                </td>
                <td class="align_right text-right tbl_amnt_10">

                </td>

                @php
                    $ip_browser_info= ''.$voucher->ss_ip_adrs.','.str_replace(' ','-',$voucher->ss_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$voucher->user_name}}
                </td>

            </tr>
            @php
                $ss++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h6 style="color:#554F4F">No Salary Slip Voucher</h6></center>
                </td>
            </tr>
        @endforelse
        <tr>
            <th colspan="5" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                {{ number_format($ss_ttl_amnt,2) }}
            </td>
            <td class="align_right text-right border-0">
                0.00
            </td>
        </tr>


        </tbody>

        {{--        <tbody>--}}
        {{--        @php--}}
        {{--            $sr = 1;--}}
        {{--        @endphp--}}
        {{--        @forelse($allData['datas'] as $invoice)--}}

        {{--            <tr>--}}
        {{--                <td class="align_center text-center edit tbl_srl_4">--}}
        {{--                    {{$sr}}--}}
        {{--                </td>--}}
        {{--                <td nowrap class="align_center text-center tbl_amnt_9">--}}
        {{--                    {{ $invoice->pi_day_end_date }}--}}
        {{--                </td>--}}
        {{--                <td class="align_center text-center tbl_amnt_6">--}}
        {{--                    IN-{{$invoice->pi_id}}--}}
        {{--                </td>--}}
        {{--                <td class="align_left text-left tbl_txt_21">--}}
        {{--                    {{$invoice->pi_party_name}}--}}
        {{--                </td>--}}
        {{--                <td class="align_left text-left tbl_txt_30">--}}
        {{--                    @if( $type !== 'download_excel')--}}
        {{--                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->pi_detail_remarks) !!}--}}
        {{--                    @else--}}
        {{--                        {{$invoice->pi_detail_remarks}}--}}
        {{--                    @endif--}}
        {{--                </td>--}}
        {{--                <td class="align_right text-right tbl_amnt_10">--}}
        {{--                    {{$invoice->pi_total_price !=0 ? number_format($invoice->pi_total_price,2):''}}--}}
        {{--                </td>--}}
        {{--                <td class="align_right text-right tbl_amnt_10">--}}
        {{--                    {{$invoice->pi_cash_paid !=0 ? number_format($invoice->pi_cash_paid,2):''}}--}}
        {{--                </td>--}}
        {{--                <td class="align_left text-left usr_prfl tbl_txt_12">--}}
        {{--                    {{$invoice->user_name}}--}}
        {{--                </td>--}}

        {{--            </tr>--}}
        {{--            @php--}}
        {{--                $sr++;--}}
        {{--            @endphp--}}
        {{--        @empty--}}
        {{--            <tr>--}}
        {{--                <td colspan="15">--}}
        {{--                    <center><h3 style="color:#554F4F">No Invoice</h3></center>--}}
        {{--                </td>--}}
        {{--            </tr>--}}
        {{--        @endforelse--}}
        {{--        </tbody>--}}

    </table>

@endsection

