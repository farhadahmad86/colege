
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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Invoice #
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_4">
                Days
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_25">
                Party Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_28">
                Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Grand Total
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $ttlPrc = 0;
        @endphp
        @forelse($datas as $invoice)

            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td nowrap class="align_center text-center tbl_amnt_6">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->si_day_end_date)))}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{'SV-'.$invoice->si_id }}
                </td>
                <td class="align_center text-center tbl_amnt_4">
                    {{(strtotime($balance) - strtotime($invoice->si_day_end_date)) / 86400}}
                </td>
                <td class="align_left text-left tbl_txt_25">
                    {{$invoice->si_party_name}}
                </td>
                <td class="align_left text-left edit tbl_txt_28">
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->si_detail_remarks) !!}
                </td>
                @php
                    $ttlPrc = +($invoice->si_grand_total) + +$ttlPrc;
                @endphp
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{$invoice->si_grand_total !=0 ? number_format($invoice->si_grand_total,2):''}}
                </td>
                @php
                    $ip_browser_info= ''.$invoice->si_ip_adrs.','.str_replace(' ','-',$invoice->si_brwsr_info).'';
                @endphp
                <td class="align_left text-left usr_prfl tbl_txt_8">
                    {{ $invoice->user_name }}
                </td>

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

        <tr>
            <th colspan="6" class="align_right text-right border-0">
                Page Total:-
            </th>
            <td align="right" class="align_right text-right border-0">
                {{ number_format($ttlPrc,2) }}
            </td>
        </tr>

    </table>

@endsection

