
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
                Head
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_9">
                Id
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                Region
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                Area
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                Sector
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_15">
                Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_11">
                Balance
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created By
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Account View Group
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $ttlPrc = 0;
        @endphp
        @forelse($datas as $index=> $account)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_left text-left tbl_txt_6">
                    <?php if(substr($account->account_uid,0,1)==1){ echo 'Asset'; }elseif (substr($account->account_uid,0,1)==2){ echo 'Liability'; }elseif (substr($account->account_uid,0,1)==3){ echo 'Revenue'; }elseif (substr($account->account_uid,0,1)==4){ echo 'Expense'; }else{ echo 'Equity'; } ?>
                </td>
                <td class="align_center text-center tbl_amnt_9">
                    {{$account->account_uid}}
                </td>
                <td class="align_left text-left tbl_txt_13">
                    {{$account->reg_title}}
                </td>
                <td class="align_left text-left tbl_txt_13">
                    {{$account->area_title}}
                </td>
                <td class="align_left text-left tbl_txt_13">
                    {{$account->sec_title}}
                </td>
                <td class="align_left text-left tbl_txt_15">
                    <a data-id="{{$account->account_uid}}" data-name="{{$account->account_name}}" class="ledger">
                        {{$account->account_name}}
                    </a>
                </td>
                @php
                    $ttlPrc = +($balance[$index]) + +$ttlPrc;
                @endphp
                <td align="right" class="align_right text-right tbl_amnt_11">
                    {{$balance[$index]!=0 ? number_format($balance[$index],2):''}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_8">
                    {{ $account->user_name }}
                </td>
                <td class="text-center align_center edit tbl_txt_10">
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


        <tr>
            <th colspan="7" class="align_right text-right border-0">
                Page Total:-
            </th>
            <td align="right" class="align_right text-right border-0">
                {{ number_format($ttlPrc,2) }}
            </td>
        </tr>

    </table>

@endsection

