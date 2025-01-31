
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
                Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                Account From
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                Account To
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_33">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Amount
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
        @forelse($datas as $salary)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $salary->as_datetime)))}}
                </td>
                <td class="align_left text-left tbl_txt_15">
                    {{$salary->from}}
                </td>
                <td class="align_left text-left tbl_txt_15">
{{--                    {{$salary->to}}--}}
                    {{ $salary->as_remarks }}
                </td>
                <td class="align_left text-left tbl_txt_33">
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $salary->as_remarks) !!}
                </td>
                @php $per_page_ttl_amnt = +$salary->as_amount + +$per_page_ttl_amnt; @endphp

                <td class="align_right text-right tbl_amnt_15">
                    {{$salary->as_amount}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_8">
                    {{$salary->user_name}}
                </td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Entry</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

        <tfoot>
        <tr class="border-0">
            <th colspan="4" align="right" class="border-0 text-right align_right pt-0">
                Page Total:
            </th>
            <td class="text-right border-0" align="right">
                {{ number_format($per_page_ttl_amnt,2) }}
            </td>
        </tr>
        </tfoot>


    </table>



@endsection

