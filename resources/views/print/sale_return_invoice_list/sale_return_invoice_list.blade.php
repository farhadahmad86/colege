
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table table-bordered table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                Sr#
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_9">
                Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Invoice No.
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_21">
                Party Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_21">
                Posting Reference
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_30">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Total Price
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Cash Paid
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
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
            $ttlPrc = $cashPaid = 0;
        @endphp
        @forelse($datas as $invoice)

            <tr>
                <th>
                    {{$sr}}
                </th>
                <td nowrap>
                    {{ $invoice->sri_day_end_date }}
                </td>
                <td>
                    SRI-{{$invoice->sri_id}}
                </td>
                <td>
                    {{$invoice->sri_party_name}}
                </td>
                <td>
                    {{$invoice->pr_name}}
                </td>
                <td>
                    @if( $type !== 'download_excel')
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->sri_detail_remarks) !!}
                    @else
{{--                    {!! $invoice->sri_detail_remarks !!}--}}
                    @endif
                </td>
                @php
                    $ttlPrc = +$invoice->sri_grand_total + +$ttlPrc;
                    $cashPaid = +$invoice->sri_cash_received + +$cashPaid;
                @endphp
                <td class="align_right text-right">
                    {{$invoice->sri_grand_total !=0 ? number_format($invoice->sri_grand_total,2):''}}
                </td>
                <td class="align_right text-right">
                    {{$invoice->sri_cash_received !=0 ? number_format($invoice->sri_cash_received,2):''}}
                </td>
                <td>
                    {{$invoice->user_name}}
                </td>
            </tr>
            @php
                $sr++;
                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="17">
                    <center><h3 style="color:#554F4F">No Invoice</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
        <tfoot>
        <tr>
            <th colspan="6" class="align_right text-right border-0">
                Per Page Total:-
            </th>
            <td class="align_right text-right border-0">
                {{ number_format($ttlPrc, 2) }}
            </td>
            <td class="align_right text-right border-0">
                {{ number_format($cashPaid, 2) }}
            </td>
        </tr>
        </tfoot>
    </table>

@endsection

