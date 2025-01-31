
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table id="content" class="table border-0 table-sm">

        <thead>
            <tr>
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr#
                </th>
                <th scope="col" align="center" class="align_center text-center tbl_amnt_9">
                    Settlement Date
                </th>
                <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                    Time
                </th>
                <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                    Bank Name
                </th>
                <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                    Machine Name
                </th>
                <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                    Batch
                </th>
                <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                    Amount
                </th>
                <th scope="col" align="center" class="align_center text-center tbl_txt_25">
                    Remarks
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                    Created By
                </th>
            </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $invoice)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td nowrap class="align_center text-center tbl_amnt_9">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->ccms_date)))}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{ date("g:i a", strtotime($invoice->ccms_time))}}
                </td>
                <td class="align_left text-left tbl_txt_13">
                    {{$invoice->account_name}}
                </td>
                <td class="align_left text-left tbl_txt_15">
                    {{$invoice->ccm_title}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{$invoice->ccms_batch_number }}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$invoice->ccms_amount !=0 ? number_format($invoice->ccms_amount,2):''}}
                </td>
                <td class="align_right text-right tbl_amnt_25">
                    {{$invoice->ccms_remarks}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_8">
                    {{$invoice->user_name}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Credit Card Machine Settlement</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

