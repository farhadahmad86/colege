@extends('voucher_view.print_index')

@section('print_cntnt')

    <div id="" class="table-responsive" style="z-index: 9;">
        <table class="table table-bordered table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" class="tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" class="tbl_amnt_15">
                    Employee
                </th>
                <th scope="col" class="tbl_txt_20">
                    Account Name
                </th>
                <th scope="col" class="tbl_txt_20">
                    Remarks
                </th>
                <th scope="col" class="tbl_amnt_15">
                    Type
                </th>
                <th scope="col" class="tbl_txt_5">
                    Amount
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 1; $dr = $cr = $ttl_dr = $ttl_cr = 0; @endphp
            @foreach( $items as $item )
                @php
                    $dr = $item->ad_allowance_amount;
                    $cr = $item->ad_deduction_amount;
                    $ttl_dr = +$dr + +$ttl_dr;
                    $ttl_cr = +$cr + +$ttl_cr;
                @endphp
                <tr class="even pointer">
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td class="align_center text-center tbl_amnt_15">
                        {{ $item->user_name }}
                    </td>
                    <td class="align_center text-center tbl_amnt_10">
                        {{ $item->ad_account_name }}
                    </td>
                    <td class="align_left text-left tbl_txt_5">
                        {!! $item->ad_remarks !!}
                    </td>
                    <td class="align_left text-left tbl_txt_20">
                        {!! $item->ad_allowance_deduction ==1 ? 'Allowance' : 'Deduction' !!}
                    </td>


                    <td class="align_right text-right tbl_txt_5">
                        {!! $item->ad_allowance_deduction == 1 ? $item->ad_allowance_amount : $item->ad_deduction_amount !!}
                    </td>
                </tr>
                @php $i++; @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr class="border-0">
                <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                    Total Allowance:
                </th>
                <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                    {{ number_format($ttl_dr,2) }}
                </td>
            </tr>
            <tr class="border-0">
                <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                    Total Deduction:
                </th>
                <td class="text-right border-left-0" align="right" style="border-bottom: 2px solid #000;border-bottom: 3px double #000;border-right: 0 solid transparent;">
                    {{ number_format($ttl_cr,2) }}
                </td>
            </tr>
            </tfoot>

        </table>
@endsection
