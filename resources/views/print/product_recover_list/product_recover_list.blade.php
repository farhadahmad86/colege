
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')
<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                Sr#
            </th>
            <th scope="col" class="tbl_txt_10">
                Date
            </th>
            <th scope="col" class="tbl_amnt_10">
                Voucher No.
            </th>
            <th scope="col" class="tbl_txt_25">
                Account
            </th>
            <th scope="col" class="tbl_txt_36">
                Detail Remarks
            </th>
            <th scope="col" class="tbl_amnt_15">
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

            <th scope="row">
                    {{$sr}}
                </th>
                <td nowrap>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $product->plr_day_end_date)))}}
                </td>
                <td class="view" data-id="{{$product->plr_id}}">
                    PRV-{{$product->plr_id}}
                </td>
                <td>
                    {{$product->plr_account_name}}
                </td>
                <td>
                    {{$product->plr_detail_remarks}}
                </td>
                @php
                    $ttlPrc = +($product->plr_pro_total_amount) + +$ttlPrc;
                @endphp
                <td class="text-right">
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
    </div>
@endsection

