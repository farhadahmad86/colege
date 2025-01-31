
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
            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Voucher No.
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_25">
                Account
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_36">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Total Amount
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $ttlPrc = $cashPaid = 0;
        @endphp
        @forelse($datas as $product)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td nowrap class="align_center text-center tbl_txt_10">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $product->plr_day_end_date)))}}
                </td>
                <td align="center" class="align_center text-center tbl_amnt_10 view" data-id="{{$product->plr_id}}">
                    PLV-{{$product->plr_id}}
                </td>
                <td class="align_left text-left tbl_txt_25">
                    {{$product->plr_account_name}}
                </td>
                <td class="align_left text-left tbl_txt_36">
                    {{$product->plr_detail_remarks}}
                </td>
                @php
                    $ttlPrc = +($product->plr_pro_total_amount) + +$ttlPrc;
                @endphp
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{$product->plr_pro_total_amount}}
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
            <th align="right" colspan="5" class="align_right text-right border-0">
                Page Total:-
            </th>
            <td align="right" class="align_right text-right border-0">
                {{ number_format($ttlPrc,2) }}
            </td>
        </tr>

    </table>

@endsection

