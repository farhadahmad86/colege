
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
            <th scope="col" class="tbl_amnt_6">
                Date
            </th>
            <th scope="col" class="tbl_amnt_6">
                JV#
            </th>

            <th scope="col" class="tbl_txt_40">
                Detail Remarks
            </th>
            <th scope="col" class="tbl_amnt_13">
                Total Debit
            </th>
            <th scope="col" class="tbl_amnt_13">
                Total Credit
            </th>
            <th scope="col" class="tbl_txt_8">
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
                $dr_pg = +$voucher->ajv_total_dr + +$dr_pg;
                $cr_pg = +$voucher->ajv_total_cr + +$cr_pg;
            @endphp

            <tr>
                <td>
                    {{$sr}}
                </td>
                <td>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->ajv_created_datetime)))}}
                </td>
                <td>
                    AJV-{{$voucher->ajv_id}}
                </td>
               <td>
                   {!! str_replace("&oS;",'<br />', $voucher->ajv_detail_remarks) !!}
                </td>
                <td class="text-right">
                    {{$voucher->ajv_total_dr !=0 ? number_format($voucher->ajv_total_dr,2):''}}
                </td>
                <td class="text-right">
                    {{$voucher->ajv_total_cr !=0 ? number_format($voucher->ajv_total_cr,2):''}}
                </td>
                <td class="usr_prfl">
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
            <th colspan="4" align="right" class="text-right pt-0">
                Page Total:
            </th>
            <td class="text-right" align="right">
                {{ number_format($dr_pg,2) }}
            </td>
            <td class="text-right" align="right">
                {{ number_format($cr_pg,2) }}
            </td>
        </tr>

    </table>

@endsection

