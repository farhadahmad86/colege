@extends('print.print_index')
@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif
@section('print_cntnt')
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th tabindex="-1" scope="col" class="tbl_srl_4">
                Sr#
            </th>
            <th tabindex="-1" scope="col" class="tbl_srl_4">
                ID
            </th>
            <th tabindex="-1" scope="col" class="tbl_amnt_9">
                Date
            </th>
            <th tabindex="-1" scope="col" class="tbl_amnt_6">
                Invoice No.
            </th>
            <th scope="col" class="tbl_txt_21">
                Party Name
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_11">
                Remarks
            </th>
            <th scope="col" class="tbl_txt_29">
                Detail Remarks
            </th>

            <th scope="col" class="tbl_txt_8">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $invoice)
        <tr>
                <td class="edit ">
                    {{$sr}}
                </td>
                <td class="edit ">
                    {{$invoice->do_id}}
                </td>
                <td nowrap class="">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->do_day_end_date)))}}
                </td>
                <td class="view " data-id="{{$invoice->do_id}}">
                    DO-{{$invoice->do_id}}
                </td>
                <td >
                    {{$invoice->do_party_name}}
                </td>
                <td >
                    {{$invoice->do_remarks}}
                </td>
                <td>
                    {!! str_replace("&oS;",'<br />', $invoice->do_detail_remarks) !!}
                </td>

                @php
                    $ip_browser_info= ''.$invoice->do_ip_adrs.','.str_replace(' ','-',$invoice->do_brwsr_info).'';
                @endphp

                <td class="usr_prfl " data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
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

