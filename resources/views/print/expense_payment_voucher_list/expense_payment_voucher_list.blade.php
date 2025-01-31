
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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                JV#
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_63">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Total Amount
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
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

            @php $per_page_ttl_amnt = +$voucher->ep_total_amount + +$per_page_ttl_amnt; @endphp
            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->ep_day_end_date)))}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    EPV-{{$voucher->ep_id}}
                </td>
                <td class="align_left text-left tbl_txt_63">
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $voucher->ep_detail_remarks) !!}
                </td>
                <td class="align_right text-right tbl_amnt_13">
                    {{$voucher->ep_total_amount !=0 ? number_format($voucher->ep_total_amount,2):''}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_8">
                    {{$voucher->user_name}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Vocuher</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

        <tr>
            <th colspan="4" align="right" class="text-right align_right border-0">
                Page Total:
            </th>
            <td class="text-right align_right border-0" align="right">
                {{ number_format($per_page_ttl_amnt,2) }}
            </td>
        </tr>

    </table>

@endsection

