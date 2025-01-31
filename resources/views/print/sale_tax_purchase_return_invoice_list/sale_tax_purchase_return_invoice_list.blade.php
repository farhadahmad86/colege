@extends('print.print_index')
@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif
@section('print_cntnt')
<div class="table-responsive">
<table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                Sr#
            </th>
            <th scope="col" class="tbl_amnt_9">
                Date
            </th>
            <th scope="col" class="tbl_amnt_9">
                Invoice No.
            </th>
            <th scope="col" class="tbl_txt_15">
                Party Name
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_10">
                Posting Reference
            </th>
            <th scope="col"  class="tbl_amnt_25">
                Detail Remarks
            </th>
            <th scope="col"  class="tbl_amnt_10">
                Total Price
            </th>
            <th scope="col"  class="tbl_amnt_10">
                Cash Paid
            </th>
            <th scope="col"  class="tbl_txt_8">
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
            <th scope="row">
                    {{$sr}}
                </th>
                <td nowrap>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->prsi_day_end_date)))}}
                </td>
                <td nowrap>
                    STPRI-{{$invoice->prsi_id}}
                </td>
                <td>
                    {{$invoice->prsi_party_name}}
                </td>
                <td>
                    {{$invoice->pr_name}}
                </td>
                <td>
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->prsi_detail_remarks) !!}
                </td>
                @php
                    $ttlPrc = +($invoice->prsi_total_price) + +$ttlPrc;
                @endphp
                <td class="text-right">
                    {{$invoice->prsi_total_price !=0 ? number_format($invoice->prsi_total_price,2):''}}
                </td>
                @php
                    $cashPaid = +($invoice->prsi_cash_paid) + +$cashPaid;
                @endphp
                <td  class="text-right">
                    {{$invoice->prsi_cash_paid !=0 ? number_format($invoice->prsi_cash_paid,2):''}}
                </td>
                <td>
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
        <tr>
            <th colspan="6" class="text-right border-0">
                Page Total:-
            </th>
            <td  class="text-right border-0">
                {{ number_format($ttlPrc,2) }}
            </td>
            <td  class="text-right border-0">
                {{ number_format($cashPaid,2) }}
            </td>
        </tr>

    </table>

    </div>
    @endsection

