@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table id="content" class="table border-0 table-sm">

        <thead>
        <tr>
            <th tabindex="-1" scope="col" class="tbl_srl_4">
                Sr#
            </th>

            <th scope="col" class="tbl_amnt_10">
                Date
            </th>
            <th scope="col" class="tbl_amnt_6">
                Voucher#
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_10">
                Registration
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_15">
                Student Name
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_15">
                Class
            </th>
            <th scope="col" class="tbl_amnt_10">
                Total Amount
            </th>
            <th scope="col" class="tbl_txt_8">
                Branch
            </th>
            <th scope="col" class="tbl_txt_8">
                Created By
            </th>

            <th scope="col" class="tbl_txt_8">
                Status
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $voucher)

            <tr>
                <th scope="row">
                    {{ $sr }}
                </th>
                <td>
                    {{ date('d-M-y', strtotime(str_replace('/', '-', $voucher->fv_day_end_date))) }}
                </td>
                <td class="view" data-id="{{ $voucher->fv_v_no }}" data-reg_no="{{ $voucher->fv_std_reg_no }}">
                    FV-{{ $voucher->fv_v_no }}
                </td>
                <td>
                    {{ $voucher->registration_no }}
                </td>
                <td>
                    {{ $voucher->full_name }}
                </td>
                <td>
                    {{ $voucher->class_name }}
                </td>

                <td class="align_right text-right">
                    {{ $voucher->fv_total_amount != 0 ? number_format($voucher->fv_total_amount, 2) : '' }}
                </td>
                <td>
                    {{ $voucher->branch_name }}
                </td>
                <td>
                    {{ $voucher->user_name }}
                </td>

                <td class="text-center">
                    {{$voucher->fv_status_update == 0 ? 'Pending': 'Paid'}}
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

