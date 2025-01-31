
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
            <th scope="col" align="center" class="text-center align_center tbl_amnt_9">
                ID
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Control Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_11">
                Group Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_11">
                Parent Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_15">
                Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_13">
                Lib - Salary
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_9">
                Advance
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
        @endphp
        @forelse($datas as $index=> $account)

                <tr>

                    <td class="align_center text-center edit tbl_srl_4">
                        {{$sr}}
                    </td>
                    <td class="text-center align_center edit tbl_amnt_9">
                        {{$account->account_uid}}
                    </td>
                    <td class="text-left align_left edit tbl_txt_10">
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
                    <td class="text-left align_left edit tbl_txt_11">
                        {{$account->grp_acnt_name}}
                    </td>
                    <td class="text-left align_left edit tbl_txt_11">
                        {{$account->parnt_acnt_name}}
                    </td>
                    <td class="align_left text-left tbl_txt_15">
                        {{$account->account_name}}
                    </td>
                    <td class="align_right text-right edit tbl_amnt_13">
                        {{$balance[$index]!=0 ? number_format($balance[$index],2):''}}
                    </td>
                    <td class="align_right text-right edit tbl_amnt_9">
                        {{ $account->as_amount }}
                    </td>

                    <td class="align_left usr_prfl text-left tbl_txt_8">
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

    </table>

@endsection

