
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_2">
                Sr#
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Emp Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Tank
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_6">
                Previous Date/Time
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Previous Dip Reading (mm)
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Previous Dip Reading (L)
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Date/Time
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Dip Reading (mm)
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Dip Reading (L)
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Difference in mm
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Difference in Litre
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_6">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $dip_reading)

            <tr>
                <td class="text-center align_center edit tbl_srl_2">
                    {{$sr}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$dip_reading->employee_name}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$dip_reading->t_name}}
                </td>
                <td class="align_left text-left edit tbl_txt_6">
                    {{$dip_reading->dip_pre_reading_datetime}}
                </td>
                <td class="align_right text-right edit tbl_txt_8">
                    {{$dip_reading->dip_pre_reading}}
                </td>
                <td class="align_right text-right edit tbl_txt_8">
                    {{$dip_reading->dip_pre_in_litre}}
                </td>
                <td class="align_left text-left edit tbl_txt_8">
                    {{$dip_reading->dip_reading_datetime}}
                </td>
                <td class="align_right text-right edit tbl_txt_8">
                    {{$dip_reading->dip_reading}}
                </td>
                <td class="align_right text-right edit tbl_txt_8">
                    {{$dip_reading->dip_in_litre}}
                </td>
                <td class="align_right text-right edit tbl_txt_8">
                    {{$dip_reading->dip_difference_in_mm}}
                </td>
                <td class="align_right text-right edit tbl_txt_8">
                    {{$dip_reading->dip_difference_in_litre}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$dip_reading->dip_remarks}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_6">{{ $dip_reading->user_name }}</td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Dip Reading</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

