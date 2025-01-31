
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">
        <thead>
        <tr>
            <th scope="col" class="text-center align_center tbl_srl_4">
                Sr#
            </th>
            <th scope="col" class="align_center text-center tbl_amnt_10">
                Date
            </th>
            <th scope="col" class="align_center text-center tbl_amnt_6">
                Voucher#
            </th>
            <th scope="col" class="align_center text-center tbl_amnt_6">
                Remarks
            </th>
            <th scope="col" class="align_center text-center tbl_txt_54">
                Detail Remarks
            </th>
            <th scope="col" class="text-center align_center tbl_amnt_10">
                Total Amount
            </th>
            <th scope="col" class="text-center align_center tbl_txt_10">
                Created By
            </th>
        </tr>
        </thead>
        <tbody>
        @php
            $per_page_ttl_amnt = 0;
        @endphp
        @forelse($partyClaims as $index => $partyClaim)
            @php $per_page_ttl_amnt = +$partyClaim->pc_total_amount + +$per_page_ttl_amnt; @endphp
            <tr>
                <th>
                    {{ $index + 1 }}
                </th>
                <td>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $partyClaim->pc_day_end_date)))}}
                </td>
                <td class="view" data-id="{{$partyClaim->pc_id}}">
                    PC-{{$partyClaim->pc_id}}
                </td>
                <td>
                    {{ $partyClaim->pc_remarks }}
                </td>
                <td>
                    {{ $partyClaim->pc_detail_remarks }}
                </td>
                <td class="align_right text-right">
                    {{$partyClaim->pc_total_amount !=0 ? number_format($partyClaim->pc_total_amount,2):''}}
                </td>

                @php
                    $ip_browser_info= ''.$partyClaim->pc_ip_adrs.','.str_replace(' ','-',$partyClaim->pc_brwsr_info).'';
                @endphp

                <td class="usr_prfl" data-usr_prfl="{{ $partyClaim->pc_user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$partyClaim->createdBy}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">
                    <center><h3 style="color:#554F4F">No Invoice</h3></center>
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
        <tr class="border-0">
            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                Grand Total:
            </th>
            <td class="text-right border-left-0" align="right" style="border-bottom: 2px solid #000;border-bottom: 3px double #000;border-right: 0 solid transparent;">
                {{ number_format( $ttl_amount,2) }}
            </td>
        </tr>
        </tfoot>
    </table>

@endsection

