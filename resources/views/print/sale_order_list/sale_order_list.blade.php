
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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_9">
                Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Order No.
            </th>
            {{--                                    <th scope="col" align="center">Detail Remarks</th>--}}
            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Party Code</th>--}}
            <th scope="col" align="center" class="align_center text-center tbl_txt_21">
                Party Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_34">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Total Price
            </th>

            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Cash Rec
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $ttlPrc = $cashPaid = 0;
                $sr = 1;
        @endphp
        @forelse($datas as $order)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td nowrap class="align_center text-center tbl_amnt_9">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $order->so_day_end_date)))}}
                </td>
                <td class="align_center text-center view tbl_amnt_6" data-id="{{$order->so_id}}">
                    SO-{{$order->so_id}}
                </td>
                <td class="align_left text-left tbl_txt_21">
                    {{$order->so_party_name}}
                </td>
                <td class="align_left text-left tbl_txt_34">
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $order->so_detail_remarks) !!}
                </td>
                @php
                    $ttlPrc = +($order->so_grand_total) + +$ttlPrc;
                @endphp
                <td class="align_right text-right tbl_amnt_10">
                    {{$order->so_grand_total !=0 ? number_format($order->so_grand_total,2):''}}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{--                                        {{$order->so_cash_received !=0 ? number_format($order->so_cash_received,2):''}}--}}
                </td>

                @php
                    $ip_browser_info= ''.$order->so_ip_adrs.','.str_replace(' ','-',$order->so_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $order->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$order->user_name}}
                </td>

                {{--                                    <td class="align_left">{{$order->si_remarks}}</td>--}}
                {{--{{$order->si_remarks == '' ? 'N/A' : $order->si_remarks}}--}}
                {{--<td align="center">{{$order->si_datetime}}</td>--}}

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

