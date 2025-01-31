
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                SR #
            </th>
            {{--                            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">--}}
            {{--                                Product Barcode--}}
            {{--                            </th>--}}
            {{--                            <th scope="col" align="center" class="align_center text-center tbl_txt_6p">--}}
            {{--                                Product Group Title--}}
            {{--                            </th>--}}
            {{--                            <th scope="col" align="center" class="align_center text-center tbl_txt_6p">--}}
            {{--                                Product Category Title--}}
            {{--                            </th>--}}
            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                Product Title
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Opening Stock
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                QTY In
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Bonus In
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Total In Stock
            </th>

            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                QTY Out
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Bonus Out
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Total Out Stock
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Closing Stock
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Last Purchase Rate
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Current Average Rate
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_6">
                Value Last Purchase Rate
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_6">
                Value Average Rate
            </th>

        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $prchsPrc = $avrgPrc = $ttlOpStock = $ttlQtyIn = $ttlQtyBonIn = $ttlStockIn = $ttlQtyOut = $ttlQtyBonOut = $ttlStockOut =$ttlClosingStock = $ttlValPurchase = $ttlValAvg = 0;
        @endphp
        @forelse($datas as $product)
            @php
                $total_in_stock=0;
                        $total_in_stock=$product->in_qty + $product->in_bonus_qty;

                    $total_out_stock=0;
                            $total_out_stock=$product->out_qty + $product->out_bonus_qty;
                            $closing_stock=($total_in_stock + $product->opening_stock)-$total_out_stock;

                        $value_last_purchase_rate=0;
                            $value_average_rate =0;
                            $value_last_purchase=$closing_stock * $product->pro_last_purchase_rate;
                            $value_average_rate=$closing_stock * $product->pro_average_rate;

            $ttlOpStock += $product->opening_stock; $ttlQtyIn += $product->in_qty; $ttlQtyBonIn += $product->in_bonus_qty; $ttlStockIn += $total_in_stock; $ttlQtyOut += $product->out_qty;
            $ttlQtyBonOut += $product->out_bonus_qty; $ttlStockOut
            += $total_out_stock; $ttlClosingStock += $closing_stock; $ttlValPurchase += $value_last_purchase; $ttlValAvg += $value_average_rate;
            @endphp
            <tr>

                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                {{--                                <td class="align_center text-center edit tbl_amnt_10">--}}
                {{--                                    {{$product->pro_p_code}}--}}
                {{--                                </td>--}}
                <td class="align_left text-left edit tbl_amnt_10">
                    {{$product->pro_title}}
                </td>
                <td class="align_center text-center edit tbl_amnt_6">
                    {{number_format($product->opening_stock,2)}}
                </td>
                <td class="align_center text-center edit tbl_amnt_6">
                    {{$product->in_qty}}
                </td>
                <td class="align_center text-center edit tbl_txt_6">
                    {{$product->in_bonus_qty}}
                </td>

                <td class="align_center text-center edit tbl_txt_6">
                    {{number_format($total_in_stock,2)}}
                </td>
                <td class="align_center text-center edit tbl_amnt_6">
                    {{$product->out_qty}}
                </td>
                <td class="align_center text-center edit tbl_amnt_6">
                    {{$product->out_bonus_qty}}
                </td>
                <td class="align_center text-center edit tbl_amnt_6">
                    {{number_format($total_out_stock,2)}}
                </td>
                <td class="align_center text-center edit tbl_amnt_6">
                    {{number_format($closing_stock,2)}}
                </td>
                <td class="align_right text-right edit tbl_amnt_6">
                    {{number_format($product->pro_last_purchase_rate,2)}}
                </td>

                <td class="align_right text-right edit tbl_amnt_6">
                    {{number_format($product->pro_average_rate,2)}}
                </td>

                <td class="align_right text-right edit tbl_amnt_6">
                    {{number_format($value_last_purchase,2)}}
                </td>
                <td class="align_right text-right edit tbl_amnt_6">
                    {{number_format($value_average_rate,2)}}
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
            <th align="right" colspan="2" class="align_right text-right border-0">
                Page Total:-
            </th>
            <td align="center" class="align_center text-center border-0">
                {{ number_format($ttlOpStock,2) }}
            </td>
            <td align="center" class="align_center text-center border-0">
                {{ number_format($ttlQtyIn,2) }}
            </td>
            <td align="center" class="align_center text-center border-0">
                {{ number_format($ttlQtyBonIn,2) }}
            </td>
            <td align="center" class="align_center text-center border-0">
                {{ number_format($ttlStockIn,2) }}
            </td>
            <td align="center" class="align_center text-center border-0">
                {{ number_format($ttlQtyOut,2) }}
            </td>
            <td align="center" class="align_center text-center border-0">
                {{ number_format($ttlQtyBonOut,2) }}
            </td>
            <td align="center" class="align_center text-center border-0">
                {{ number_format($ttlStockOut,2) }}
            </td>
            <td align="center" class="align_center text-center border-0">
                {{ number_format($ttlClosingStock,2) }}
            </td>
            <td align="right" class="align_right text-right border-0">
                {{--                                {{ number_format($ttlQtyOut,2) }}--}}
            </td>
            <td align="right" class="align_right text-right border-0">
                {{--                                {{ number_format($ttlValPurchase,2) }}--}}
            </td>
            <td align="right" class="align_right text-right border-0">
                {{ number_format($ttlValPurchase,2) }}
            </td>
            <td align="right" class="align_right text-right border-0">
                {{ number_format($ttlValAvg,2) }}
            </td>
        </tr>

    </table>

@endsection

