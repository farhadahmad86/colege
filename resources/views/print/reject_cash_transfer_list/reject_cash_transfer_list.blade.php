
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
                Date/Time
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                Send From
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                Send To
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                Status
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_36">
                Reason
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Amount
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $ttlPrc = 0;
        @endphp
        @forelse($datas as $cash_transfer)

            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{date('d-m-y h:i:sA', strtotime(str_replace('/', '-', $cash_transfer->ct_send_datetime)))}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_15">
                    {{$cash_transfer->SndByUsrName}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_15">
                    {{$cash_transfer->RcdByUsrName}}
                </td>
                <td class="align_center text-center tbl_txt_10">
                    {{$cash_transfer->ct_status}}
                </td>
                <td class="align_left text-left tbl_txt_36">
                    {{$cash_transfer->ct_reason}}
                </td>
                @php
                    $ttlPrc = +($cash_transfer->ct_amount) + +$ttlPrc;
                @endphp
                <td class="align_right text-right tbl_amnt_10">
                    {{ number_format($cash_transfer->ct_amount,2) }}
                </td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Cash Transfer</h3></center>
                </td>
            </tr>
        @endforelse
        <tr>
            <th colspan="6" class="align_right text-right border-0">
                Total:-
            </th>
            <td class="align_right text-right border-0">
                {{ number_format($ttlPrc,2) }}
            </td>
        </tr>
        </tbody>

    </table>

@endsection

