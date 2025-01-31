
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" lass="align_center text-center tbl_amnt_4">
                Inward #
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Inward Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Inward Type
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Party Name
            </th>
            <th scope="col" align="center" lass="align_center text-center tbl_amnt_8">
                PO #
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                QTY
            </th>
            <th hidden scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Receiving Date/Time
            </th>

            <th scope="col" align="center" class="align_center text-center tbl_txt_27">
                Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $delivery_option)

            <tr>
                <td class="align_center text-center tbl_amnt_4">
                    {{--                                    {{$delivery_option->sr_invoice_no}}--}}
                    {{$delivery_option->si_id}}
                </td>
                <td class="align_right text-left tbl_amnt_10">
                    {{date('d-M-y g:i a', strtotime(str_replace('/', '-', $delivery_option->si_datetime)))}}
                </td>
                <td class="view align_left text-left tbl_amnt_10" data-id="{{$delivery_option->si_id}}" data-do-type="{{$delivery_option->si_type}}">
                    {{$delivery_option->si_type}}
                </td>
                <td class="align_left text-left tbl_amnt_15">
                    {{$delivery_option->si_party_name}}
                </td>
                <td class="align_center text-center tbl_amnt_8">
                    {{$delivery_option->si_purchase_order_id}}

                </td>
                <td class="align_left edit text-left tbl_amnt_10">
                    {{$delivery_option->si_builty_qty}}
                </td>
                <td hidden class="align_left text-left tbl_amnt_10">
                    {{date("d-M-y g:i a", strtotime($delivery_option->si_receiving_datetime))}}
                </td>

                {{--                                    <td class="align_left">{{$delivery_option->jv_remarks}}</td>--}}

                <td class="align_left edit text-left tbl_txt_27">
                    {{$delivery_option->si_remarks}}
                </td>

                @php
                    $ip_browser_info= ''.$delivery_option->si_ip_adrs.','.str_replace(' ','-',$delivery_option->si_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_10" data-usr_prfl="{{ $delivery_option->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                    title="Click To See User Detail">
                    {{$delivery_option->user_name}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Data Found</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

