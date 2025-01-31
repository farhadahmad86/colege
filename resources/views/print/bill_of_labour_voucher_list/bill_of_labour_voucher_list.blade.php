
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="tbl_srl_4">
                Sr#
            </th>

            <th scope="col" align="center" class="tbl_amnt_10">
                Date
            </th>
            <th scope="col" align="center" class="tbl_amnt_6">
                Voucher#
            </th>
            <th tabindex="-1" scope="col" align="center" class="tbl_txt_19">
                Remarks
            </th>
            <th scope="col" align="center" class="tbl_txt_41">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="tbl_amnt_10">
                Total Amount
            </th>
            <th scope="col" align="center" class="tbl_txt_10">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $per_page_ttl_amnt = 0;
        @endphp
        @forelse($datas as $voucher)
            @php $per_page_ttl_amnt = +$voucher->bl_total_amount + +$per_page_ttl_amnt; @endphp

            <tr>
            <th scope="row" class="edit tbl_srl_4">
                    {{$sr}}
                </th>
{{--                <td class="edit tbl_srl_4">--}}
{{--                    {{$voucher->bl_id}}--}}
{{--                </td>--}}
                <td class="tbl_amnt_10">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->bl_day_end_date)))}}
                </td>
                <td class="view tbl_amnt_6" data-id="{{$voucher->bl_id}}">
                    BLV-{{$voucher->bl_id}}
                </td>
                <td class="align_left text-left tbl_txt_15">
                    {{$voucher->bl_remarks}}
                </td>
                <td class="align_left text-left tbl_txt_41">
                    {{--                                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $voucher->bl_detail_remarks) !!}--}}
                    {!! str_replace("&oS;",'<br />', $voucher->bl_detail_remarks) !!}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->bl_total_amount !=0 ? number_format($voucher->bl_total_amount,2):''}}
                </td>

                @php
                    $ip_browser_info= ''.$voucher->bl_ip_adrs.','.str_replace(' ','-',$voucher->bl_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$voucher->user_name}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Vouchar</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

        <tfoot>
        <tr class="border-0">
            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                Per Page Total:
            </th>
            <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                {{ number_format($per_page_ttl_amnt,2) }}
            </td>
        </tr>
{{--        <tr class="border-0">--}}
{{--            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">--}}
{{--                Grand Total:--}}
{{--            </th>--}}
{{--            <td class="text-right border-left-0" align="right" style="border-bottom: 2px solid #000;border-bottom: 3px double #000;border-right: 0 solid transparent;">--}}
{{--                {{ number_format($ttl_amnt,2) }}--}}
{{--            </td>--}}
{{--        </tr>--}}
        </tfoot>

    </table>

@endsection

