
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
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Code
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_25">
                Product
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Quantity
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Convert Quantity
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Convert Unit
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created By
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created At
            </th>
        </tr>
        </thead>
        <tbody>
        @forelse($convert_quantities as $index => $convert_quantity)
            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$index + 1}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$convert_quantity->cq_pro_code}}
                </td>
                <td class="align_left text-left edit tbl_txt_25">
                    {{$convert_quantity->cq_pro_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$convert_quantity->cq_quantity}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$convert_quantity->convertQuantity}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$convert_quantity->convertUnit}}
                </td>
                <td class="align_left text-left edit tbl_txt_12">
                    {{$convert_quantity->cq_remarks}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$convert_quantity->createdBy}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$convert_quantity->cq_day_end_date}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">
                    <center><h3 style="color:#554F4F">No Quantity is converted</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

