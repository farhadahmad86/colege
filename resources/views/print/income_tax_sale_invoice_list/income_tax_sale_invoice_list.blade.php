
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

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
            <th scope="col" align="center" class="align_center text-center tbl_txt_30">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Total Price
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Cash Rec
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $invoice)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td nowrap class="align_center text-center tbl_amnt_9">
                    {{ $invoice->si_day_end_date }}
                </td>
                <td class="align_center view text-center tbl_amnt_6">
                    IN-{{$invoice->si_id}}
                </td>
                <td class="align_left text-left tbl_txt_21">
                    {{$invoice->si_party_name}}
                </td>
                <td class="align_left text-left tbl_txt_30">
                    @if( $type !== 'download_excel')
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->si_detail_remarks) !!}
                    @else
                    {!! $invoice->si_detail_remarks !!}
                    @endif
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$invoice->si_total_price !=0 ? number_format($invoice->si_total_price,2):''}}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$invoice->si_cash_paid !=0 ? number_format($invoice->si_cash_paid,2):''}}
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
                <td colspan="16">
                    <center><h3 style="color:#554F4F">No Invoice</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

