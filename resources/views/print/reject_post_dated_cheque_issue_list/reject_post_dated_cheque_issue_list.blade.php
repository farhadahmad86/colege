
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th class="text-center align_center tbl_srl_4">
                Sr#
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Cheque Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                Account From
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                Account To
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_38">
                Reason
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
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
            $ttlPrc = 0;
        @endphp
        @forelse($datas as $cheque)

            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{$cheque->pdc_cheque_date}}
                </td>
                <td class="align_left text-left tbl_txt_15">
                    {{$cheque->from}}
                </td>
                <td class="align_left text-left tbl_txt_15">
                    {{$cheque->to}}
                </td>
                <td class="align_left text-left tbl_txt_38">
                    {{$cheque->pdc_reason}}
                </td>
                @php
                    $ttlPrc = +($cheque->pdc_amount) + +$ttlPrc;
                @endphp
                <td class="align_right text-right tbl_amnt_10">
                    {{ number_format($cheque->pdc_amount,2) }}
                </td>
                <td class="align_left usr_prfl text-left tbl_txt_8">
                    {{ $cheque->user_name }}
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

        <tr>
            <th colspan="5" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                {{ number_format($ttlPrc,2) }}
            </td>
        </tr>

    </table>

@endsection

