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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_8">
                Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_12">
                Product Code
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                Product Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_9">
                Sale QTY
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Sale Amount
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_9">
                Average Unit Rate
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Average Cost
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Average Margin
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Average Margin Per Unit
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $ttl_sale_qty = $ttl_sale_amount = $ttl_avg_rate = $ttl_avg_cost = $ttl_avg_margin = $ttl_margin_unit = 0;
        @endphp
        @forelse($datas as $index=>$result)
            @php
                $avg_cost= $sale_qty[$index] * $result->pro_average_rate;
                $avg_margin= $sale_amount[$index] - $avg_cost;
                $avg_mar_per_unit= $avg_margin / $sale_qty[$index];

             $ttl_sale_qty= $ttl_sale_qty + $sale_qty[$index];
                                $ttl_sale_amount= $ttl_sale_amount + $sale_amount[$index];
                                $ttl_avg_rate= $ttl_avg_rate + $result->sm_bal_rate;
                                $ttl_avg_cost= $ttl_avg_cost + $avg_cost;
                                $ttl_avg_margin= $ttl_avg_margin + $avg_margin;
                                $ttl_margin_unit= $ttl_margin_unit + $avg_mar_per_unit;
            @endphp
            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>

                <td class="align_center text-center tbl_amnt_8">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $result->sm_day_end_date)))}}
                </td>
                <td class="align_left text-left tbl_amnt_12">
                    {{ $result->sm_product_code }}
                </td>

                <td class="align_left text-left tbl_txt_15">
                    {{$result->sm_product_name}}
                </td>
                <td class="align_right edit text-right tbl_amnt_9">
                    {{$sale_qty[$index]!=0 ? number_format($sale_qty[$index],2):''}}
                </td>
                <td class="align_right edit text-right tbl_amnt_13">
                    {{$sale_amount[$index]!=0 ? number_format($sale_amount[$index],2):''}}
                </td>
                <td class="align_right edit text-right tbl_amnt_9">
                    {{ number_format($result->pro_average_rate,2)}}
                </td>

                <td align="right" class="align_right text-right tbl_amnt_13">
                    {{ number_format($avg_cost, 2) }}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_10">
                    {{ number_format($avg_margin, 2) }}

                </td>
                <td align="right" class="align_right text-right tbl_amnt_10">
                    {{ number_format($avg_mar_per_unit, 2) }}

                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Record</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

                <tr class="border-0">
                    <th colspan="4" align="right" class="border-0 text-right align_right">
                        Page Total:
                    </th>
                    <td class="text-right border-0" align="right">
                        {{ number_format($ttl_sale_qty, 2) }}
                    </td>
                    <td class="text-right border-0" align="right">
                        {{ number_format($ttl_sale_amount, 2) }}
                    </td>
                    <td class="text-right border-0" align="right">
                        {{ number_format($ttl_avg_rate,2) }}
                    </td>
                    <td class="text-right border-0" align="right">
                        {{ number_format($ttl_avg_cost,2) }}
                    </td>
                    <td class="text-right border-0" align="right">
                        {{ number_format($ttl_avg_margin,2) }}
                    </td>
                    <td class="text-right border-0" align="right">
                        {{ number_format($ttl_margin_unit,2) }}
                    </td>
                </tr>

    </table>

@endsection

