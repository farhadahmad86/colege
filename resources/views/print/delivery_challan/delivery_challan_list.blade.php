
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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Sale Inv No.
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_21">
                Party Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_30">
                Detail Remarks
            </th>
            {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">--}}
            {{--                Total Price--}}
            {{--            </th>--}}

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
                    {{ $invoice->dc_day_end_date }}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    DC-{{$invoice->dc_id}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{$invoice->dc_sale_invoice_id}}
                </td>
                <td class="align_left text-left tbl_txt_21">
                    {{$invoice->dc_party_name}}
                </td>
                <td class="align_left text-left tbl_txt_30">
                    @if( $type !== 'download_excel')
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->dc_detail_remarks) !!}
                    @else
                        {{ $invoice->dc_detail_remarks }}
                    @endif
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

    </table>

@endsection

