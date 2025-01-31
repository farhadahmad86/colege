
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

            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_amnt_9">
                Date
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_amnt_8">
                Invoice No.
            </th>

            <th scope="col" align="center" class="align_center text-center tbl_txt_21">
                Party Name
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_15">
                Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_35">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created By
            </th>

        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1; $ttlPrc = $cashPaid = 0;
        @endphp
        @forelse($datas as $invoice)

            <tr>
                <th>
                    {{$sr}}
                </th>
                <td nowrap>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->grnr_day_end_date)))}}
                </td>
                <td data-id="{{$invoice->grnr_id}}">
                    GRNR-{{$invoice->grnr_id}}
                </td>

                <td>
                    {{$invoice->grnr_party_name}}
                </td>
                <td>
                    {{$invoice->grnr_remarks}}
                </td>
                <td>
                    {!! str_replace("&oS;",'<br />', $invoice->grnr_detail_remarks) !!}
                </td>
                @php
                    //$ttlPrc = +($invoice->si_grand_total) + +$ttlPrc;
                @endphp

                @php
                    $ip_browser_info= ''.$invoice->grnr_ip_adrs.','.str_replace(' ','-',$invoice->grnr_brwsr_info).'';
                @endphp

                <td class="usr_prfl" data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$invoice->user_name}}
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

    </table>

@endsection

