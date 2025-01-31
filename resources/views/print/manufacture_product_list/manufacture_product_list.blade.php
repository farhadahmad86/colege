
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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Voucher No.
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_13">
                Account Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_13">
                Product Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_6">
                Status
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Complete At
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                {{$balance=='reject_manufacture_product_list' ? 'Reason':'Remarks'}}
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_4">
                Qty
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Grand Total
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $ttlPrc = 0;
        @endphp
        @forelse($datas as $manufacture_product)

            <tr>
                <td align="center" class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td align="center" class="align_center text-center edit tbl_amnt_6">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $manufacture_product->pm_datetime)))}}
                </td>
                <td align="center" class="align_center text-center edit tbl_amnt_6">
                    {{$manufacture_product->pm_id}}
                </td>
                <td class="align_left text-left edit tbl_txt_13">
                    {{$manufacture_product->pm_account_name.' ('.$manufacture_product->pm_account_code.')'}}
                </td>
                <td class="align_left text-left edit tbl_txt_13">
                    {{$manufacture_product->pm_pro_name.' ('.$manufacture_product->pm_pro_code.')'}}
                </td>
                <td class="align_left text-left edit tbl_txt_6">
                    {{$manufacture_product->pm_status}}
                </td>
                <td align="center" class="align_center text-center edit tbl_amnt_6">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $manufacture_product->pm_complete_datetime)))}}
                </td>
                <td class="align_left text-left edit tbl_txt_15">
                    {{$balance=='reject_manufacture_product_list' ? $manufacture_product->pm_reject_reason:$manufacture_product->pm_remarks}}
                </td>
                <td align="center" class="align_center text-center edit tbl_amnt_4">
                    {{$manufacture_product->pm_qty}}
                </td>
                @php
                    $ttlPrc = +($manufacture_product->pm_grand_total) + +$ttlPrc;
                @endphp
                <td align="right" class="align_center text-right edit tbl_amnt_15">
                    {{number_format($manufacture_product->pm_grand_total,2)}}
                </td>
                <td class="align_center edit text-center tbl_txt_12">
                    {{ $manufacture_product->user_name }}
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

        <tr>
            <th colspan="9" class="align_right text-right border-0" align="right">
                Page Total:-
            </th>
            <td class="align_right text-right border-0" align="right">
                {{ number_format($ttlPrc,2) }}
            </td>
        </tr>
    </table>

@endsection

