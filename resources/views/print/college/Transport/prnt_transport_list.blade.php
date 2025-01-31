@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif
@section('print_cntnt')
    @php use Carbon\Carbon;@endphp
    <table class="table table-bordered table-sm" id="fixTable">

        <thead>
        <tr>
            <th scope="col" class="tbl_srl_2">
                ID
            </th>
            <th scope="col" class="tbl_txt_14">
                Route Title
            </th>
            <th scope="col" class="tbl_txt_14">
                Route Name
            </th>
            <th scope="col" class="tbl_txt_8">
                Single Route Amounts
            </th>
            <th scope="col" class="tbl_txt_8">
                Double Route Amounts
            </th>
            <th scope="col" class="tbl_txt_14">
                Vendor Changes
            </th>
            <th scope="col" class="tbl_txt_20">
                Remarks
            </th>
            <th scope="col" class="tbl_txt_10">
                Remarks
            </th>
            {{-- <th scope="col" class="tbl_txt_14">
                B
            </th> --}}
            <th scope="col" class="tbl_txt_10">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
        @endphp
        @forelse($datas as $data)
            <tr data-title="{{ $data->tr_title }}" data-tr_name="{{ $data->tr_name }}"
                data-tr_id="{{ $data->tr_id }}"
                data-branch_id="{{ $data->tr_branch_id }}"
                data-single_route_amount="{{ $data->tr_single_route_amount }}"
                data-double_route_amount="{{ $data->tr_double_route_amount }}"
                data-vendor_charge="{{ $data->tr_vendor_charge }}"
                data-remarks="{{ $data->tr_remarks }}">
                <th scope="row">
                    {{ $sr }}
                </th>
                <td class="edit ">
                    {{ $data->tr_title }}
                </td>
                <td class="edit ">
                    {{ $data->tr_name }}
                </td>
                <td class="edit ">
                    {{ $data->tr_single_route_amount }}
                </td>
                <td class="edit ">
                    {{ $data->tr_double_route_amount }}
                </td>
                <td class="edit ">
                    {{ $data->tr_vendor_charge }}
                </td>
                <td class="edit ">
                    {{ $data->tr_remarks }}
                </td>
                <td class="edit ">
                    {{ $data->branch_name }}
                </td>
                <td class="edit" data-usr_prfl="">
                    {{ $data->user_name }}
                </td>
            </tr>
            @php
                $sr++;
                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center>
                        <h3 style="color:#554F4F">No Route</h3>
                    </center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection
