
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')
<div class="table-responsive">
    <table class="table table-bordered table-sm">

        <thead>
        <tr>
            <th scope="col"  class="text-center  tbl_srl_4">
                Sr#
            </th>
            <th scope="col"  class=" text-center tbl_amnt_9">
                Date
            </th>
            <th scope="col"  class=" text-center tbl_amnt_6">
                Invoice No.
            </th>
            <th scope="col"  class=" text-center tbl_txt_21">
                Party Name
            </th>
            <th tabindex="-1" scope="col"  class=" text-center tbl_txt_21">
                Posting Reference
            </th>
            <th scope="col"  class=" text-center tbl_txt_30">
                Detail Remarks
            </th>
            <th scope="col"  class=" text-center tbl_amnt_10">
                Total Price
            </th>
            <th scope="col"  class=" text-center tbl_amnt_10">
                Cash Rec
            </th>
            <th scope="col"  class="text-center  tbl_txt_12">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
            $ttlPrc = $cashReceived = 0;
        @endphp
        @forelse($datas as $invoice)

            <tr>
                <th>
                    {{$sr}}
                </th>
                <td nowrap>
                    {{ $invoice->ssi_day_end_date }}
                </td>
                <td>
                    STSI-{{$invoice->ssi_id}}
                </td>
                <td>
                    {{$invoice->ssi_party_name}}
                </td>
                <td>
                    {{$invoice->pr_name}}
                </td>
                <td>
                    @if( $type !== 'download_excel')
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->ssi_detail_remarks) !!}
                    @else
                    {!! $invoice->ssi_detail_remarks !!}
                    @endif
                </td>
                @php
                    $ttlPrc = +($invoice->ssi_grand_total) + +$ttlPrc;
                    $cashReceived = +($invoice->ssi_cash_received) + +$cashReceived;
                @endphp
                <td class="align_right text-right">
                    {{$invoice->ssi_grand_total !=0 ? number_format($invoice->ssi_grand_total,2):''}}
                </td>
                <td class="align_right text-right">
                    {{$invoice->ssi_cash_received !=0 ? number_format($invoice->ssi_cash_received,2):''}}
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
                <td colspan="16">
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
                {{ number_format($ttlPrc,2) }}
            </td>
            <td class="align_right text-right border-0">
                {{ number_format($cashReceived,2) }}
            </td>
        </tr>
        </tfoot>
    </table>
</div>
@endsection

