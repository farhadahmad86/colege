
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                Sr#
            </th>
            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                ID
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_amnt_9">
                PO NO
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Invoice No.
            </th>
            {{--                                    <th scope="col" align="center">Detail Remarks</th>--}}
            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Party Code</th>--}}
            <th scope="col" align="center" class="align_center text-center tbl_txt_11">
                Party Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                Project
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_6">
                Start Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_6">
                End Date
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_11">
                Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_29">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                Total Price
            </th>
            {{--                                    <th scope="col" align="center">Expense</th>--}}
            {{--                                    <th scope="col" align="center">Trade Disc%</th>--}}
            {{--                                    <th scope="col" align="center">Trade Disc</th>--}}
            {{--                                    <th scope="col" align="center">Value of Supply</th>--}}
            {{--                                    <th scope="col" align="center">Sale tax</th>--}}
            {{--                                    <th scope="col" align="center">Special Disc%</th>--}}
            {{--                                    <th scope="col" align="center">Special Disc</th>--}}
            {{--                                    <th scope="col" align="center">Grand Total</th>--}}

            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created By
            </th>
            {{--                                    <th scope="col" align="center">Remarks</th>--}}
            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Date/Time</th>--}}
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
$ttlPrc = $cashPaid = 0;
        @endphp
        @forelse($datas as $invoice)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$invoice->opo_id}}
                </td>
                <td nowrap class="align_center text-center tbl_amnt_9">
                    {{$invoice->opo_po_no}}
                </td>
                <td class="align_center text-center view tbl_amnt_6" data-id="{{$invoice->opo_id}}">
                    PO-{{$invoice->opo_id}}
                </td>
                {{--                                    <td class="align_center" style="white-space:pre-wrap;">{{$invoice->proj_detail_remarks}}</td>--}}
                {{--<td class="align_center">{{$invoice->proj_party_code}}</td>--}}
                <td class="align_left text-left tbl_txt_11">
                    {{$invoice->account_name}}
                </td>
                <td class="align_left text-left tbl_txt_10">
                    {{ implode(', ', $jobs[$invoice->opo_id]) }}
                </td>
                <td class="align_left text-center tbl_txt_6">
                    {{$invoice->opo_start_date}}
                </td>
                <td class="align_left text-center tbl_txt_6">
                    {{$invoice->opo_end_date}}
                </td>
                <td class="align_left text-left tbl_txt_11">
                    {{$invoice->opo_remarks}}
                </td>
                <td class="align_left text-left tbl_txt_29">
                    {!! str_replace("&oS;",'<br />', $invoice->opo_detail_remarks) !!}
                </td>
                @php
                    $ttlPrc = +($invoice->opo_grand_total) + +$ttlPrc;
                @endphp
                <td class="align_right text-right tbl_amnt_5">
                    {{$invoice->opo_grand_total !=0 ? number_format($invoice->opo_grand_total,2):''}}
                </td>
                {{--                                    <td class="align_right">{{$invoice->si_expense !=0 ? number_format($invoice->si_expense,2):''}}</td>--}}
                {{--                                    <td class="align_right">{{$invoice->si_trade_disc_percentage !=0 ? number_format($invoice->si_trade_disc_percentage,2):''}}</td>--}}
                {{--                                    <td class="align_right">{{$invoice->si_trade_disc !=0 ? number_format($invoice->si_trade_disc,2):''}}</td>--}}
                {{--                                    <td class="align_right">{{$invoice->si_value_of_supply !=0 ? number_format($invoice->si_value_of_supply,2):''}}</td>--}}
                {{--                                    <td class="align_right">{{$invoice->si_sales_tax !=0 ? number_format($invoice->si_sales_tax,2):''}}</td>--}}
                {{--                                    <td class="align_right">{{$invoice->si_special_disc_percentage !=0 ? number_format($invoice->si_special_disc_percentage,2):''}}</td>--}}
                {{--                                    <td class="align_right">{{$invoice->si_special_disc !=0 ? number_format($invoice->si_special_disc,2):''}}</td>--}}
                {{--                                    <td class="align_right">{{$invoice->si_grand_total !=0 ? number_format($invoice->si_grand_total,2):''}}</td>--}}
                {{--                                    @php--}}
                {{--                                        $cashPaid = +($invoice->si_cash_received) + +$cashPaid;--}}
                {{--                                    @endphp--}}
                {{--                                <td class="align_right text-right tbl_amnt_5">--}}
                {{--                                    {{$invoice->si_cash_received !=0 ? number_format($invoice->si_cash_received,2):''}}--}}
                {{--                                </td>--}}

                @php
                    $ip_browser_info= ''.$invoice->opo_ip_adrs.','.str_replace(' ','-',$invoice->opo_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$invoice->user_name}}
                </td>

                {{--                                    <td class="align_left">{{$invoice->si_remarks}}</td>--}}
                {{--{{$invoice->si_remarks == '' ? 'N/A' : $invoice->si_remarks}}--}}
                {{--<td align="center">{{$invoice->si_datetime}}</td>--}}

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Invoice</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

