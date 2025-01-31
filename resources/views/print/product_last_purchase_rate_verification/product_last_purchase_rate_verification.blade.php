
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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Voucher No.
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_16">
                Party Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_23">
                Product Name
            </th>
            <th class="align_left text-left tbl_txt_8">
                Invoice Type
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Qty
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Rate
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Amount
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $qty_pg = $rate_pg = $bal = 0;
            $qty_pg = +$datas->qty + +$qty_pg;
            $rate_pg = +$datas->rate + +$rate_pg;
            $bal = +$datas->amount + +$bal;
        @endphp
            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_amnt_8">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $datas->day_end_date)))}}
                </td>
                @php
                    $set_invoice_id = '';
                    if($datas->type === "Sale Tax"){
                        $set_invoice_id = 'STPI';
                    }
                    else{
                        $set_invoice_id = 'PI';
                    }
                @endphp
                <td class="align_center text-center tbl_amnt_6">
                    {{ $set_invoice_id.'-'.$datas->id}}
                </td>
                <td class="align_left text-left tbl_txt_16">
                    {{$datas->party_name}}
                </td>
                <td class="align_left text-left tbl_txt_23">
                    {{$datas->product_name}}
                </td>
                <td class="align_left text-left tbl_txt_8">
                    {{ $datas->type }}
                </td>
                <td align="right" class="align_center text-center tbl_amnt_10">
                    {{$datas->qty}}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_10">
                    {{$datas->rate}}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_10">
                    {{$datas->amount}}
                </td>
            </tr>
            @php
                $sr++;
            @endphp
        </tbody>

    </table>

@endsection

