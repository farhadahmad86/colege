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
            <th scope="col" align="center" class="text-center align_center tbl_txt_20">
                Department Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_20">
                Account Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Loan Amount
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Number Of Instalment
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Instalment Amount
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Last Payment Month
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $loan)

            <tr>

                <td class="text-center align_center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_left text-left edit tbl_txt_20">
                    {{$loan->dep_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_20">
                    {{$loan->account_name}}
                </td>
                <td class="align_right text-right edit tbl_txt_12">
                    {{$loan->loan_total_amount}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$loan->loan_total_instalment}}
                </td>
                <td class="align_right text-right edit tbl_txt_12">
                    {{$loan->loan_instalment_amount}}
                </td>
                <td class="align_left text-left edit tbl_txt_12">
                    {{$loan->loan_last_payment_month}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_12">
                    {{ $loan->user_name }}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Loan</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

