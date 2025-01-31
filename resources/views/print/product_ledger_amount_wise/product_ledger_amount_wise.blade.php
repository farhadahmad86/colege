
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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                V.#
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_31">
                Product Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Stock In
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Stock Out
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Balance
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
            $stck_in_pg = $stck_out_pg = $bal = 0;
            $balance=0;
            $in_out='';
        @endphp
        @forelse($datas as $result)
            @php
                $stck_in_pg = +$result->sm_pur_total + +$stck_in_pg;
                $stck_out_pg = +$result->sm_sale_total + +$stck_out_pg;
                $bal = +$result->sm_bal_total + +$bal;
            @endphp
            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $result->sm_day_end_date)))}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{$result->sm_voucher_code}}
                </td>
                <td class="align_left text-left tbl_txt_31">
                    {{$result->sm_product_name}}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{ number_format($result->sm_pur_total, 2) }}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{ number_format($result->sm_sale_total, 2) }}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{ number_format($result->sm_bal_total, 2) }}
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
                {{ number_format($stck_in_pg,2) }}
            </td>
            <td class="text-right border-0" align="right">
                {{ number_format($stck_out_pg,2) }}
            </td>
            <td class="text-right border-0" align="right">
                {{ number_format($bal,2) }}
            </td>
        </tr>

    </table>

@endsection

