
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
            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                Group Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                Parent Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_15">
                Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_6">
                Nature
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                Initial Capital
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                System Calculated
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                Fixed Profit Ratio
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                Fixed Loss Ratio
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $index=> $account)


            <tr>

                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="text-left align_left edit tbl_txt_13">
                    {{ $account->grp_acnt_name }}
                </td>
                <td class="align_left text-left edit tbl_txt_13">
                    {{$account->prnt_acnt_name}}
                </td>
                <td class="text-left align_left edit tbl_txt_15">
                    {{$account->cr_username}}
                </td>
                <td class="text-left align_left edit tbl_txt_6">
                    {{ ($account->cr_partner_nature === 1) ? 'Acting' : 'Sleeping' }}
                </td>
                <td class="align_right edit text-right tbl_amnt_15">
                    {{ number_format($account->cr_initial_capital,2) }}
                </td>
                <td class="align_center edit text-center tbl_amnt_8">
                    {{ number_format($account->cr_system_ratio,2) }}%
                </td>
                <td class="align_center edit text-center tbl_amnt_8">
                    {{ number_format($account->cr_fixed_profit_per,2) }}%
                </td>
                <td class="align_center edit text-center tbl_amnt_8">
                    {{ number_format($account->cr_fixed_loss_per,2) }}%
                </td>
                <td class="align_left usr_prfl text-left tbl_amnt_10">
                    {{ $account->user_name }}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Account</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

