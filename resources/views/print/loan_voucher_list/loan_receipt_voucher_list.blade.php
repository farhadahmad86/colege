
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                Sr#
            </th>
            <th scope="col" class="tbl_amnt_10">
                Date
            </th>
            <th scope="col" class="tbl_amnt_6">
                Voucher#
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_15">
                Remarks
            </th>
            <th scope="col" class="tbl_txt_41">
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
            $sr = 1;
            $per_page_ttl_amnt = 0;
        @endphp
        @forelse($datas as $voucher)
            @php $per_page_ttl_amnt = +$voucher->lrv_total_amount + +$per_page_ttl_amnt; @endphp

            <tr>
                <th scope="row">
                    {{$sr}}
                </th>

                <td>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->lrv_day_end_date)))}}
                </td>
                <td class="view" data-id="{{$voucher->lrv_id}}">
                    LV-{{$voucher->lrv_id}}
                </td>
                <td>
                    {{$voucher->lrv_remarks}}
                </td>
                <td>
                    {!! str_replace("&oS;",'<br />', $voucher->lrv_detail_remarks) !!}
                </td>
                <td class="align_right text-right">
                    {{$voucher->lrv_total_amount !=0 ? number_format($voucher->lrv_total_amount,2):''}}
                </td>

                <td>
                    {{$voucher->user_name}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Invoice</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
        <tr class="border-0">
            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                Total:
            </th>
            <td class="text-right border-left-0" align="right" style="border-bottom: 3px double #000;border-left: 0 solid transparent;border-right: 0 solid transparent;">
                {{ number_format($per_page_ttl_amnt,2) }}
            </td>
        </tr>

    </table>

@endsection

