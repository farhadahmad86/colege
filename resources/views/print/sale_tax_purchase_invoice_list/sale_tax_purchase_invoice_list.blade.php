
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')
<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th scope="col"  class="tbl_srl_4">
                Sr#
            </th>
            <th scope="col"  class="tbl_amnt_9">
                Date
            </th>
            <th scope="col"  class="tbl_amnt_6">
                Invoice No.
            </th>
            <th scope="col"  class="tbl_txt_21">
                Party Name
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_21">
                Posting Reference
            </th>
            <th scope="col"  class="tbl_txt_26">
                Detail Remarks
            </th>
            <th scope="col"  class="tbl_amnt_10">
                Total Price
            </th>
            <th scope="col"  class="tbl_amnt_10">
                Cash Paid
            </th>
            <th scope="col"  class="tbl_txt_12">
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
            $ttlPrc = $cashPaid = 0;
        @endphp
        @forelse($datas as $invoice)

            <tr>
                <th scope="row" class="edit tbl_srl_4">
                    {{$sr}}
                </th>
                <td nowrap class="tbl_amnt_9">
                    {{ $invoice->psi_day_end_date }}
                </td>
                <td class="tbl_amnt_6">
                    STPI-{{$invoice->psi_id}}
                </td>
                <td class="align_left text-left tbl_txt_21">
                    {{$invoice->psi_party_name}}
                </td>
                <td class="align_left text-left tbl_txt_21">
                    {{$invoice->pr_name}}
                </td>
                <td class="align_left text-left tbl_txt_26">
                    @if( $type !== 'download_excel')
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->psi_detail_remarks) !!}
                    @else
                    {{$invoice->psi_detail_remarks}}
                    @endif
                </td>
                @php
                    $ttlPrc = +($invoice->psi_grand_total) + +$ttlPrc;
                    $cashPaid = +($invoice->psi_cash_paid) + +$cashPaid;
                @endphp
                <td class="align_right text-right tbl_amnt_10">
                    {{$invoice->psi_total_price !=0 ? number_format($invoice->psi_total_price,2):''}}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$invoice->psi_cash_paid !=0 ? number_format($invoice->psi_cash_paid,2):''}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_12">
                    {{$invoice->user_name}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
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
                {{ number_format($cashPaid,2) }}
            </td>
        </tr>
        </tfoot>
    </table>
    </div>
@endsection

