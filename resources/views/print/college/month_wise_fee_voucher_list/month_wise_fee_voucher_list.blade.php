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
            <th tabindex="-1" scope="col" class="tbl_txt_15">
                Month
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_15">
                Class
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_15">
                Section
            </th>
            <th scope="col" class="tbl_txt_10">
                Issue Date
            </th>
            <th scope="col" class="tbl_txt_10">
                Due Date
            </th>
            <th scope="col" class="tbl_txt_8">
                Total Students
            </th>
            <th scope="col" class="tbl_amnt_10">
                Total Amount
            </th>


        </tr>
        </thead>

        <tbody>
        @php
            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
            $per_page_ttl_amnt = 0;
        @endphp
        @forelse($datas as $voucher)
            @php $per_page_ttl_amnt = +$voucher->total_amount + +$per_page_ttl_amnt; @endphp

            <tr data-toggle="tooltip" data-placement="top" title=""
                data-original-title="View Journal Voucher">
                <th scope="row">
                    {{ $sr }}
                </th>
                <td>
                    {{ $voucher->fv_month }}
                </td>
                <td>
                    {{ $voucher->class_name }}
                </td>
                <td class="view" data-class_id="{{ $voucher->fv_class_id }}" data-id="{{ $voucher->fv_section_id }}" data-month="{{ $voucher->fv_month }}" data-issue_date="{{
                                    $voucher->fv_issue_date }}">
                    {{ $voucher->cs_name }}
                </td>

                <td>
                    {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->fv_issue_date))) }}
                </td>
                <td>
                    {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->fv_due_date))) }}
                </td>
                <td>
                    {{ $voucher->total_students }}
                </td>
                <td class="align_right text-right">
                    {{ $voucher->total_amount != 0 ? number_format($voucher->total_amount, 2) : '' }}
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
            <th colspan="7" align="right" class="border-0 text-right align_right pt-0">
                Per Page Total:
            </th>
            <td class="text-right border-left-0" align="right"
                style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                {{ number_format($per_page_ttl_amnt, 2) }}
            </td>
        </tr>
        <tr class="border-0">
            <th colspan="7" align="right" class="border-0 text-right align_right pt-0">
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

