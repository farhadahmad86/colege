
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
            <th scope="col" align="center" class="text-center align_center tbl_txt_11">
                Emp Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_11">
                Nozzle
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Previous Date/Time
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Previous Nozzle Reading
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Date/Time
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Nozzle Reading
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Difference
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $nozzle_reading)

            <tr>
                <td class="text-center align_center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_left text-left edit tbl_txt_11">
                    {{$nozzle_reading->employee_name}}
                </td>
                <td class="align_left text-left edit tbl_txt_11">
                    {{$nozzle_reading->noz_name}}
                </td>
                <td class="align_left text-left edit tbl_txt_12">
                    {{$nozzle_reading->nr_pre_reading_datetime}}
                </td>
                <td class="align_right text-right edit tbl_txt_12">
                    {{$nozzle_reading->nr_pre_reading}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$nozzle_reading->nr_reading_datetime}}
                </td>
                <td class="align_right text-right edit tbl_txt_10">
                    {{$nozzle_reading->nr_reading}}
                </td>
                <td class="align_right text-right edit tbl_txt_10">
                    {{$nozzle_reading->nr_difference}}
                </td>
                <td class="align_right text-right edit tbl_txt_10">
                    {{$nozzle_reading->nr_remarks}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_10">{{ $nozzle_reading->user_name }}</td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Nozzle Reading</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

