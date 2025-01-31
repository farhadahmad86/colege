@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table table-bordered table-sm">

        <thead>
        <tr>
            <th scope="col" class="text-center  tbl_srl_4">
                Sr#
            </th>
            <th scope="col" class="text-center  tbl_txt_16">
                Project Name
            </th>
            <th scope="col" class="text-center  tbl_txt_10">
                Parent Account
            </th>
            <th scope="col" class="text-center  tbl_txt_16">
                Account Ledger
            </th>

            <th scope="col" class="text-center  tbl_amnt_9">
                Opening Balance
            </th>
            <th scope="col" class="text-center  tbl_amnt_9">
                DR
            </th>
            <th scope="col" class="text-center  tbl_amnt_9">
                CR
            </th>

            <th scope="col" class="text-center  tbl_amnt_9">
                Balance
            </th>

        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
$bal = 0;
                            $deb_bal = 0;
                            $cre_bal = 0;
        @endphp
        @forelse($datas as $index=> $account)
            <tr>

                <th>
                    {{$sr}}
                </th>
                <td>
                    {{$account->pr_name}}
                </td>
                <td>
                    {{$account->parent_name}}
                </td>

                <td>
                    {{$account->account_name}}
                    </a>
                </td>


                @php
                    $bal = +($balance[$index]) + +$bal;
                    $opening_balance = ($balance[$index]);
                    $deb_bal = +$deb_bal + +$account->dr;
                    $cre_bal = +$cre_bal + +$account->cr;
                    $bal = +$opening_balance - +$account->cr + +$account->dr;
                @endphp


                <td class="align_right text-right">
                    {{number_format($opening_balance,2)}}
                </td>
                <td class="align_right text-right">
                    {{number_format($account->dr,2)}}
                </td>

                <td class="align_right text-right">
                    {{number_format($account->cr,2)}}
                </td>

                <td class="align_right text-right">
                    {{number_format($bal,2)}}
                </td>


            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="8">
                    <center><h3 style="color:#554F4F">No Account</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4" class="align_right text-right border-0">
                Per Page Total:-
            </th>
            <td class="align_right text-right border-0">
                {{ number_format($bal,2) }}
            </td>
            <td class="align_right text-right border-0">
                {{ number_format($deb_bal,2) }}
            </td>
            <td class="align_right text-right border-0">
                {{ number_format($cre_bal,2) }}
            </td>
            <td class="align_right text-right border-0">
                {{ number_format($bal + $deb_bal - $cre_bal,2) }}
            </td>
        </tr>
        </tfoot>
    </table>

@endsection

