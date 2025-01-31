
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table id="content" class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="align_center text-center tbl_srl_4">
                R.Code
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_20">
                Machine Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Merchant Code
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                Bank
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Percentage
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_30">
                Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_14">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $credit_card_machine)

            <tr>

                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_left text-left edit tbl_txt_20">
                    {{$credit_card_machine->ccm_title}}
                </td>
                <td class="align_center text-center edit tbl_amnt_15">
                    {{$credit_card_machine->ccm_merchant_id}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$credit_card_machine->account_name}}
                </td>
                <td class="align_center text-center edit tbl_amnt_6">
                    {{$credit_card_machine->ccm_percentage}}
                </td>
                <td class="align_left text-left edit tbl_txt_30">
                    {{$credit_card_machine->ccm_remarks }}
                </td>

                <td class="align_left usr_prfl text-left tbl_txt_14">
                    {{ $credit_card_machine->user_name }}
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

    </table>

@endsection

