
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_2">Sr#</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">product Code</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">product Name</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Publisher Title</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Topic Title</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Class Title</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Currency Title</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Language Title</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">ImPrint Title</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Illustrated Title</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Author Title</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Genre Title</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_4">Remarks</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_4">Created By</th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $product_detail)

            <tr>
                <td class="text-center align_center edit tbl_srl_2">
                    {{$sr}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$product_detail->pro_p_code}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$product_detail->pro_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$product_detail->pub_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$product_detail->top_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$product_detail->cla_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$product_detail->cur_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$product_detail->lan_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$product_detail->imp_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$product_detail->ill_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$product_detail->aut_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$product_detail->gen_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_4">
                    {{$product_detail->pd_remarks}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{ $product_detail->user_name }}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Product Details</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

