
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
            <th scope="col" align="center" class="text-center align_center tbl_txt_6">
                Parent Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_15">
                Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_5">
                Useful Life
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_7">
                Dep. Method
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_4">
                Dep. %
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_11">
                Residual Val
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_11">
                Basis
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_9">
                Posting
            </th>
{{--            <th scope="col" align="center" class="text-center align_center tbl_amnt_11">--}}
{{--                Balance--}}
{{--            </th>--}}
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created By
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_9">
                Account View Group
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
        @endphp
        @forelse($datas as $index=> $account)


            <tr>


                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="text-left align_left edit tbl_txt_6">
                    {{ $account->prnt_acnt_name }}
                </td>
                <td class="align_left text-left tbl_txt_15">
                    {{$account->fa_account_name}}
                </td>
                <td class="text-center align_center edit tbl_amnt_5">
                    {{$account->fa_useful_life_year}}
                </td>
                <td class="text-left align_left edit tbl_txt_7">
                    {{ ($account->fa_method === 1) ? 'Straight Balance' : 'Reducing Balance' }}
                </td>
                <td class="align_center edit text-center tbl_amnt_4">
                    {{ number_format($account->fa_dep_percentage_year,2) }}
                </td>
                <td class="align_right edit text-right tbl_amnt_11">
                    {{ $account->fa_residual_value }}
                </td>
                <td class="text-center align_center edit tbl_amnt_5">
                    @if($account->fa_dep_period==1)
                        Per Annum
                    @elseif($account->fa_dep_period==2)
                        Per Month
                    @else
                        Daily Basis
                    @endif
                </td>
                <td class="text-center align_center edit tbl_amnt_5">
                    {{ $account->fa_posting == 1 ?  'Auto': 'Manual'}}
                </td>

{{--                <td class="align_right edit text-right tbl_amnt_11">--}}
{{--                    {{ $account->fa_price }}--}}
{{--                </td>--}}
{{--                <td class="align_right edit text-right tbl_amnt_9">--}}
{{--                    {{ number_format(000,2) }}--}}
{{--                </td>--}}
{{--                <td class="align_right edit text-right tbl_amnt_11">--}}
{{--                    {{ number_format(2500,2) }}--}}
{{--                </td>--}}
                <td class="align_left usr_prfl text-left tbl_txt_8">
                    {{ $account->user_name }}
                </td>
                <td class="text-center align_center edit tbl_txt_9">
                    {{$account->ag_title}}
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

