
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" class="text-center align_center tbl_srl_7" align="center">
                Account Code
            </th>
            <th scope="col" class="text-center align_center tbl_srl_9" align="center">
                Account Title
            </th>
            <th scope="col" class="text-center align_center tbl_srl_7" align="center">
                Opening Balance
            </th>
            <th scope="col" class="text-center align_center tbl_srl_9" align="center">
                Total Inwards
            </th>
            <th scope="col" class="text-center align_center tbl_srl_9" align="center">
                Total Outwards
            </th>
            <th scope="col" class="text-center align_center tbl_srl_9" align="center">
                Ledger Balance Of Customer
            </th>
            <th scope="col" class="text-center align_center tbl_srl_7" align="center">
                Last Inward Transaction Date
            </th>
            <th scope="col" class="text-center align_center tbl_srl_5" align="center">
                Inward Not Received Since Last Days
            </th>
            <th scope="col" class="text-center align_center tbl_srl_7" align="center">
                Last Inward Transaction Type
            </th>
            <th scope="col" class="text-center align_center tbl_srl_9" align="center">
                Last Inward Transaction Amount
            </th>
            <th scope="col" class="text-center align_center tbl_srl_7" align="center">
                Last Outward Transaction Date
            </th>
            <th scope="col" class="text-center align_center tbl_srl_5" align="center">
                Outward Not Execute Since Last Days
            </th>
            <th scope="col" class="text-center align_center tbl_srl_7" align="center">
                Last Outward Transaction Type
            </th>
            <th scope="col" class="text-center align_center tbl_srl_9" align="center">
                Last Outward Transaction Amount
            </th>
        </tr>
        </thead>

        <tbody>
        @forelse($datas as $ledger)

            <tr>
                <td align="center" class="text-center align_center tbl_srl_7">
                    {{$ledger->account_uid}}
                </td>
                <td align="left" class="align_left text-left tbl_srl_9">
                    {{$ledger->account_name}}
                </td>
                <td align="right" class="align_right text-right tbl_srl_9">
                    {{$ledger->opening_balance !=0 ? number_format($ledger->opening_balance,2):''}}
                </td>
                <td align="right" class="align_right text-right tbl_srl_9">
                    {{$ledger->total_inwards !=0 ? number_format($ledger->total_inwards,2):''}}
                </td>
                <td align="right" class="align_right text-right tbl_srl_9">
                    {{$ledger->total_outwards !=0 ? number_format($ledger->total_outwards,2):''}}
                </td>
                <td align="right" class="align_right text-right tbl_srl_9">
                    {{$ledger->ledger_balance_of_customer !=0 ? number_format($ledger->ledger_balance_of_customer,2):''}}
                </td>
                <td align="center" class="align_center text-center tbl_srl_7">
                    {{ (isset($ledger->last_inward_transaction_date) && !empty($ledger->last_inward_transaction_date) ) ? date('d-M-y', strtotime(str_replace('/', '-', $ledger->last_inward_transaction_date))) : "" }}
                </td>
                <td align="center" class="align_center text-center tbl_srl_5">
                    {{ $ledger->inward_not_received_last_days }}
                </td>
                <td align="left" class="align_left text-left tbl_srl_7">
                    {{ str_replace("_", " ", $ledger->last_inward_transaction_type) }}
                </td>
                <td align="right" class="align_right text-right tbl_srl_9">
                    {{$ledger->last_inward_transaction_amount !=0 ? number_format($ledger->last_inward_transaction_amount,2):''}}
                </td>
                <td align="center" class="align_center text-center tbl_srl_7">
                    {{(isset($ledger->last_outward_transaction_date) && !empty($ledger->last_outward_transaction_date) ) ? date('d-M-y', strtotime(str_replace('/', '-', $ledger->last_outward_transaction_date))) : "" }}
                </td>
                <td align="center" class="align_center text-center tbl_srl_5">
                    {{ $ledger->outward_not_received_last_days }}
                </td>
                <td align="left" class="align_left text-left tbl_srl_7">
                    {{ str_replace("_", " ", $ledger->last_outward_transaction_type) }}
                </td>
                <td align="right" class="align_right text-right tbl_srl_9">
                    {{$ledger->last_outward_transaction_amount !=0 ? number_format($ledger->last_outward_transaction_amount,2):''}}
                </td>

            </tr>

        @empty
            <tr>
                <td colspan="17">
                    <h3 style="color:#554F4F">No Ledger</h3>
                </td>
            </tr>
        @endforelse
        </tbody>


    </table>

@endsection

