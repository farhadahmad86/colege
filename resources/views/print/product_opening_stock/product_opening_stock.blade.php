
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_srl_4">
                Sr.
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Product Code
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_txt_23">
                Product Title
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Purchase Price
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Bottom Price
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Sale Price
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Qty
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

        @forelse($datas as $index=> $product)

            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td nowrap="" class="align_center text-center tbl_amnt_13">
                    {{$product->pro_p_code}}
                </td>
                <td nowrap="" class="align_left text-left tbl_txt_23">
                    {{$product->pro_title}}
                </td>
                <td nowrap="" class="align_right text-right tbl_amnt_13">
                    {{$product->pro_purchase_price}}
                </td>
                <td nowrap="" class="align_right text-right tbl_amnt_13">
                    {{$product->pro_bottom_price}}
                </td>
                <td nowrap="" class="align_right text-right tbl_amnt_13">
                    {{$product->pro_sale_price}}
                </td>
                <td nowrap="" class="align_right text-right tbl_amnt_13">
                    {{$product->pro_quantity}}
                </td>
                <td class="align_left usr_prfl text-left tbl_txt_8">
                    {{ $product->user_name }}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Product</h3></center>
                </td>
            </tr>
        @endforelse


        </tbody>

    </table>

@endsection

