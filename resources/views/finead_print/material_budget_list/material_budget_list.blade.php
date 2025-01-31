
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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Company
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Project
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Region
            </th><th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_38">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
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
            @php $per_page_ttl_amnt = +$voucher->mb_grand_total + +$per_page_ttl_amnt; @endphp

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{$voucher->account_name}}
                </td>
                <td class="view align_center text-center tbl_amnt_10" >
                    {{$voucher->proj_project_name}}
                </td>
                <td class="view align_center text-center tbl_amnt_10" >
                    {{$voucher->name}}
                </td>
                <td class="view align_center text-center tbl_amnt_10" >
                    {{$voucher->mb_remarks}}
                </td>
                <td class="align_left text-left tbl_txt_38">
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $voucher->mb_detail_remarks) !!}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->mb_grand_total !=0 ? number_format($voucher->mb_grand_total,2):''}}
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
                    <center><h3 style="color:#554F4F">No Material Budget Found</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
        <tr class="border-0">
            <th colspan="6" align="right" class="border-0 text-right align_right pt-0">
                Total:
            </th>
            <td class="text-right border-left-0" align="right" style="border-bottom: 3px double #000;border-left: 0 solid transparent;border-right: 0 solid transparent;">
                {{ number_format($per_page_ttl_amnt,2) }}
            </td>
        </tr>

    </table>

@endsection

