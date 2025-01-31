
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table table-bordered table-sm">

        <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                Sr#
            </th>
            <th scope="col" class="tbl_amnt_9">
                Date
            </th>
            <th scope="col" class="tbl_amnt_6">
                Invoice No.
            </th>
            <th scope="col" class="tbl_txt_21">
                Party Name
            </th>
            <th scope="col" class="tbl_txt_34">
                Detail Remarks
            </th>
            <th scope="col" class="tbl_amnt_10">
                Total Price
            </th>
            <th scope="col" class="tbl_amnt_10">
                Cash Rec
            </th>
            <th scope="col" class="tbl_txt_8">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $ttlPrc = $cashPaid = 0;
        @endphp
        @forelse($datas as $invoice)

            <tr>
                <<th scope="row" class="edit tbl_srl_4">
                    {{$sr}}
                </th>
                <td class="tbl_amnt_9">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->sesi_day_end_date)))}}
                </td>
                <td class="view tbl_amnt_6"  data-id="{{$invoice->sesi_id}}">
                    SESI-{{$invoice->sesi_id}}
                </td>
                <td align="left" class="align_left text-left tbl_txt_21">
                    {{$invoice->sesi_party_name}}
                </td>
                <td class="align_left text-left tbl_txt_34">
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->sesi_detail_remarks) !!}
                </td>
                @php
                    $ttlPrc = +($invoice->sesi_total_price) + +$ttlPrc;
                @endphp
                <td align="right" class="align_right text-right tbl_amnt_10">
                    {{$invoice->sesi_total_price !=0 ? number_format($invoice->sesi_total_price,2):''}}
                </td>
                @php
                    $cashPaid = +($invoice->sesi_cash_paid) + +$cashPaid;
                @endphp
                <td align="right" class="align_right text-right tbl_amnt_10">
                    {{$invoice->sesi_cash_paid !=0 ? number_format($invoice->sesi_cash_paid,2):''}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_8">
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
            <th colspan="5" class="align_right text-right border-0" align="right">
                Page Total:-
            </th>
            <td class="align_right text-right border-0" align="right">
                {{ number_format($ttlPrc,2) }}
            </td>
            <td class="align_right text-right border-0" align="right">
                {{ number_format($cashPaid,2) }}
            </td>
        </tr>

    </table>

@endsection

