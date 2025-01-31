
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_txt_5">
                Sr#
            </th>

            <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                Batch Name
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_5">
                Order List
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_5">
                Product Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_5">
                Length Feet
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_5">
                Length Inch
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_5">
                Total Length
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                Height Feet
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                Height Inch
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_5">
                Total Height
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                Width Feet
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                Width Inch
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_5">
                Total Width
            </th>

            <th scope="col" align="center" class="text-center align_center tbl_txt_5">
                Total Depth
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_5">
                Tapa Gauge
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_5">
                Back Sheet Gauge
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_5">
                Created By
            </th>

        </tr>
        </thead>

        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $data)

            <tr>
                <td class="align_center text-center tbl_txt_5">
                    {{$sr}}
                </td>

                <td class="view align_center text-center tbl_txt_5" data-id="{{$data->bat_id}}">
                    {{$data->bat_name}}
                </td>
                <td class="align_left text-left tbl_txt_5">
                    {{$data->ol_order_title}}
                </td>
                <td class="align_left text-left tbl_txt_5">
                    {{$data->pro_title}}
                </td>

                <td class="align_left text-left tbl_txt_5">
                    {{$data->bat_length_feet}}
                </td>

                <td class="align_left text-left usr_prfl tbl_txt_5">
                    {{$data->bat_length_inch}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_5">
                    {{$data->bat_total_length}}
                </td>
                <td class="align_left text-left tbl_txt_5">
                    {{$data->bat_height_feet}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_5">
                    {{$data->bat_height_inch}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_5">
                    {{$data->bat_total_height}}
                </td>
                <td class="align_left text-left tbl_txt_5">
                    {{$data->bat_width_feet}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_5">
                    {{$data->bat_width_inch}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_5">
                    {{$data->bat_total_width}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_5">
                    {{$data->bat_total_depth}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_5">
                    {{$data->bat_tapa_gauge}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_5">
                    {{$data->bat_back_sheet_gauge}}
                </td>

                @php
                    $ip_browser_info= ''.$data->bat_ip_adrs.','.str_replace(' ','-',$data->bat_brwsr_info).'';
                @endphp

                <td class="align_left text-left usr_prfl tbl_txt_5" data-usr_prfl="{{ $data->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{$data->user_name}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Batch</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

