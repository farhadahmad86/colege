
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
    <table class="table table-bordered table-sm" id="fixTable">

        <thead>
        <tr>
            <th tabindex="-1" scope="col" class="tbl_srl_4">
                Sr#
            </th>

            <th scope="col" class="tbl_amnt_10">
                Date
            </th>
            <th scope="col" class="tbl_amnt_6">
                Voucher#
            </th>
            <th scope="col" class="tbl_amnt_15">
                Account
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_15">
                Paid Date
            </th>
            <th scope="col" class="tbl_txt_25">
                Detail Remarks
            </th>
            <th scope="col" class="tbl_amnt_10">
                Total Amount
            </th>
            <th scope="col" class="tbl_txt_8">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
            $per_page_ttl_amnt =0; $ttl_amnt = 0;
        @endphp
        @forelse($datas as $voucher)
            @php $per_page_ttl_amnt = +$voucher->fpv_total_amount + +$per_page_ttl_amnt;
                            $ttl_amnt=$ttl_amnt + $voucher->fpv_total_amount;
            @endphp

            <tr data-toggle="tooltip" data-placement="top" title=""
                data-original-title="View Journal Voucher">
                <th scope="row">
                    {{ $sr }}
                </th>
                <td>
                    {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->fpv_day_end_date))) }}
                </td>
                <td class="view" data-id="{{ $voucher->fpv_id }}">
                    FPV-{{ $voucher->fpv_id }}
                </td>
                <td>
                    {{ $voucher->account_name }}
                </td>
                <td>
                    {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->fpv_day_end_date))) }}
                </td>

                <td>
                    {!! str_replace('&oS;', '<br />', $voucher->fpv_detail_remarks) !!}
                </td>
                <td class="align_right text-right">
                    {{ $voucher->fpv_total_amount != 0 ? number_format($voucher->fpv_total_amount, 2) : '' }}
                </td>

                @php
                    $ip_browser_info = '' . $voucher->fpv_ip_adrs . ',' . str_replace(' ', '-', $voucher->fpv_brwsr_info) . '';
                @endphp

                <td class="usr_prfl"
                    data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                    title="Click To See User Detail">
                    {{ $voucher->user_name }}
                </td>
            </tr>
            @php
                $sr++;
                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center>
                        <h3 style="color:#554F4F">No voucher</h3>
                    </center>
                </td>
            </tr>
        @endforelse
        </tbody>

        <tfoot>
        <tr class="border-0">
            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                Per Page Total:
            </th>
            <td class="text-right border-left-0" align="right"
                style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                {{ number_format($per_page_ttl_amnt, 2) }}
            </td>
        </tr>
        <tr class="border-0">
            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                Grand Total:
            </th>
            <td class="text-right border-left-0" align="right"
                style="border-bottom: 2px solid #000;border-bottom: 3px double #000;border-right: 0 solid transparent;">
                {{ number_format($ttl_amnt, 2) }}
            </td>
        </tr>
        </tfoot>

    </table>
@endsection

