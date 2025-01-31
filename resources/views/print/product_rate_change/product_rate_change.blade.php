
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
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Code
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_txt_28">
                Product Title
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Purchase Price
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Bottom Price
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Sale Price
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
                <td nowrap="" class="align_center text-center tbl_amnt_15">
                    {{$product->pro_code}}
                </td>
                <td nowrap="" class="align_left text-left tbl_txt_28">
                    {{$product->pro_title}}
                </td>
                <td align="right" nowrap="" class="align_right text-right tbl_amnt_15">
                    {{old('p_rate.'.$index) ?  old('p_rate.'.$index) : $product->pro_purchase_price}}
                </td>
                <td align="right" nowrap="" class="align_right text-right tbl_amnt_15">
                    {{old('b_rate.'.$index) ?  old('b_rate.'.$index) : $product->pro_bottom_price}}
                </td>
                <td align="right" nowrap="" class="align_right text-right tbl_amnt_15">
                    {{old('s_rate.'.$index) ?  old('s_rate.'.$index) : $product->pro_sale_price}}
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

