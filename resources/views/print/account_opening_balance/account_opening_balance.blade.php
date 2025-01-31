
@extends('print.print_index')
{{--@if( $type !== 'download_excel')--}}
{{--@section('print_title', $pge_title)--}}
{{--@endif--}}
@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                Sr#
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                Account ID
            </th>

            @if($balance !== 'Parties')

                <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                    Control Account
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                    Group Account
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                    Parent Account
                </th>

            @elseif($balance === 'Parties')

                <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                    Region
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                    Area
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                    Sector
                </th>

            @endif


            <th scope="col" align="center" class="text-center align_center tbl_txt_20">
                Account Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                Dr.
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                Cr.
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $ttlDebit = $ttlCredit = 0;
        @endphp

        @forelse($datas as $index=> $account)


            @php
                $ttlDebit = $account->tb_total_debit + $ttlDebit;
                $ttlCredit = $account->tb_total_credit + $ttlCredit;
            @endphp

            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{$account->account_uid}}
                </td>

                @if($balance !== 'Parties')

                    <td class="text-left align_left tbl_txt_10">
                            <?php
                            if(substr($account->account_uid,0,1)==1){
                                echo 'Asset';
                            }
                            elseif (substr($account->account_uid,0,1)==2)
                            { echo 'Liability'; }
                            elseif (substr($account->account_uid,0,1)==3)
                            { echo 'Revenue'; }
                            elseif (substr($account->account_uid,0,1)==4)
                            { echo 'Expense'; }else{ echo 'Equity'; }
                            ?>
                    </td>
                    <td class="text-left align_left tbl_txt_13">
                        {{$account->grp_acnt_name}}
                    </td>
                    <td class="text-left align_left tbl_txt_13">
                        {{$account->parnt_acnt_name}}
                    </td>

                @elseif($balance === 'Parties')

                    <td class="align_left text-left tbl_txt_10">
                        {{$account->reg_title}}
                    </td>
                    <td class="align_left text-left tbl_txt_13">
                        {{$account->area_title}}
                    </td>
                    <td class="align_left text-left tbl_txt_13">
                        {{$account->sec_title}}
                    </td>

                @endif

                <td class="align_left text-left tbl_txt_20">
                    {{$account->account_name}}
                </td>
                {{--                <td class="align_right text-right tbl_amnt_15">--}}
                {{--                    {{old('balances.'.$index) ?  old('balances.'.$index):$account->account_balance}}--}}
                {{--                </td>--}}
                {{--                <td class="align_right text-right edit tbl_amnt_15">--}}
                {{--                    {{old('balances.'.$index) ?  old('balances.'.$index):$account->account_balance}}--}}
                {{--                </td>--}}



                @if($account->account_uid == config('global_variables.stock_in_hand'))
                    <td class="align_right text-right tbl_amnt_15">
                        {{$total_stock}}
                    </td>
                    <td class="align_right text-right edit tbl_amnt_15">

                    </td>
                @else
                    <td class="align_right text-right tbl_amnt_15">
                        {{$account->tb_total_debit == 0 ?  '' : $account->tb_total_debit}}
                    </td>
                    <td class="align_right text-right edit tbl_amnt_15">
                        {{$account->tb_total_credit == 0 ?  '' : $account->tb_total_credit}}
                    </td>
                @endif


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
            <th colspan="6" class="align_right text-right border-0">
                Total:-
            </th>
            <td align="right" class="align_right text-right border-0">
                {{ number_format($ttlDebit,2) }}
            </td>
            <td align="right" class="align_right text-right border-0">
                {{ number_format($ttlCredit,2) }}
            </td>
        </tr>

    </table>

@endsection

