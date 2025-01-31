
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
            <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                Date
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                Voucher No.
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_25">
                Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_29">
                Description
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                Inward
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                Outward
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                Balance
            </th>
        </tr>
        </thead>

        <tbody>

        <tr>
            <td class="text-center align_center tbl_srl_4"></td>
            <td class="text-center align_center tbl_amnt_6"></td>
            <td class="text-center align_center tbl_amnt_6"></td>
            <td class="align_left text-left tbl_txt_25">OPENING BALANCE</td>
            <td class="align_left text-left tbl_txt_29"></td>
            <td class="align_right text-right tbl_amnt_10"></td>
            <td class="align_right text-right tbl_amnt_10"></td>
            <td class="align_right tbl_amnt_10 text-right">{{$opening_balance !=0 ? number_format($opening_balance,2):''}}</td>
        </tr>

        @php
            $sr = 1;
            $totalInwards = 0;
            $totalOutwards = 0;
        @endphp
        @forelse($datas as $result)
            @php
                $dateTime = new DateTime($result->date_time);
                $time = $dateTime->format('h:i:s A');
                $totalInwards += $result->debit;
                $totalOutwards += $result->credit;
            @endphp

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="text-center align_center tbl_amnt_6">
                    {{$time}}
                </td>
                <td class="text-center align_center tbl_amnt_6">
                    <a class="view" data-transcation_id="{{$result->voucher_code}}" data-toggle="modal" data-target="#myModal">
                        {{$result->voucher_code}}
                    </a>
                </td>
                <td class="align_left text-left tbl_txt_25">
                    {{$result->name}}
                </td>
                <td class="align_left text-left tbl_txt_29">
                    {{$result->remarks}}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$result->debit !=0 ? number_format($result->debit,2):'0'}}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$result->credit !=0 ? number_format($result->credit,2):'0'}}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$result->balance !=0 ? number_format($result->balance,2):'0'}}
                </td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Ledger</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

