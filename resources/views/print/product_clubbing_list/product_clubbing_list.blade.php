
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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_12">
                P.Code
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_6p">
                Group
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_6p">
                Category
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                Product Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_17">
                Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Stock
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Purchase Price
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Sale Price
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Average Price
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $prchsPrc = $slePrc = $avrgPrc = 0;
        @endphp
        @forelse($datas as $product)

            <tr>

                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center edit tbl_amnt_12">
                    {{$product->pro_p_code}}
                </td>
                <td class="align_left text-left edit tbl_amnt_6p">
                    {{$product->grp_title}}
                </td>
                <td class="align_left text-left edit tbl_amnt_6p">
                    {{$product->cat_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$product->pro_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_17">
                    {{$product->pro_remarks}}
                </td>
                <td class="align_center text-center edit tbl_amnt_6">
                    {{$product->invt_available_stock}}
                </td>
                @php
                    $prchsPrc = +($product->pro_purchase_price) + +$prchsPrc;
                @endphp
                <td align="right" class="align_right text-right edit tbl_amnt_10">
                    {{number_format($product->pro_purchase_price,2)}}
                </td>
                @php
                    $slePrc = +($product->pro_sale_price) + +$slePrc;
                @endphp
                <td align="right" class="align_right text-right edit tbl_amnt_10">
                    {{number_format($product->pro_sale_price,2)}}
                </td>
                @php
                    $avrgPrc = +($product->pro_average_rate) + +$avrgPrc;
                @endphp
                <td align="right" class="align_right text-right edit tbl_amnt_10">
                    {{number_format($product->pro_average_rate,2)}}
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

        <tr>
            <th align="right" colspan="7" class="align_right text-right border-0">
                Page Total:-
            </th>
            <td align="right" class="align_right text-right border-0">
                {{ number_format($prchsPrc,2) }}
            </td>
            <td align="right" class="align_right text-right border-0">
                {{ number_format($slePrc,2) }}
            </td>
            <td align="right" class="align_right text-right border-0">
                {{ number_format($avrgPrc,2) }}
            </td>
        </tr>

    </table>

@endsection

