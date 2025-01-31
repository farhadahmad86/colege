
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
                JVR#
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_50">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Total Debit
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Total Credit
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $dr_pg = $cr_pg = 0;
        @endphp
        @forelse($datas as $voucher)
            @php
                $dr_pg = +$voucher->jvr_total_dr + +$dr_pg;
                $cr_pg = +$voucher->jvr_total_cr + +$cr_pg;
            @endphp

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->jvr_day_end_date)))}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    JVR-{{$voucher->jvr_id}}
                </td>
                <td class="align_left text-left tbl_txt_50">
{{--                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $voucher->jvr_detail_remarks) !!}--}}
                    {!! str_replace("&oS;",'<br />', $voucher->jvr_detail_remarks) !!}
                </td>
                <td class="align_right text-right tbl_amnt_13">
                    {{$voucher->jvr_total_dr !=0 ? number_format($voucher->jvr_total_dr,2):''}}
                </td>
                <td class="align_right text-right tbl_amnt_13">
                    {{$voucher->jvr_total_cr !=0 ? number_format($voucher->jvr_total_cr,2):''}}
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
                    <center><h3 style="color:#554F4F">No Invoice</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

        <tr>
            <th colspan="4" align="right" class="align_right text-right align_right pt-0">
                Page Total:
            </th>
            <td class="align_right text-right" align="right">
                {{ number_format($dr_pg,2) }}
            </td>
            <td class="align_right text-right" align="right">
                {{ number_format($cr_pg,2) }}
            </td>
        </tr>

    </table>

@endsection

