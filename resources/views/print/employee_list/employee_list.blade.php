
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
{{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_9">--}}
{{--                Salary Account--}}
{{--            </th>--}}
            <th scope="col" align="center" class="align_center text-center tbl_txt_20">
                Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_19">
                Email
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_14">
                Mobile
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                Designation
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Created By
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_14">
                Account View Group
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $employee)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
{{--                <td class="align_center text-center edit tbl_amnt_9">--}}
{{--                    {{$employee->user_account_uid}}--}}
{{--                </td>--}}
                <td class="align_left text-left edit tbl_txt_20">
                    {{$employee->user_name}}
                </td>
                <td class="align_left text-left edit tbl_txt_19">
                    {{$employee->user_email}}
                </td>
                <td class="align_center text-center edit tbl_amnt_14">
                    {{$employee->user_mobile}}
                </td>
                <td class="align_center text-center edit tbl_txt_10">
                    {{$employee->user_designation}}
                </td>
                <td class="align_left edit text-left tbl_txt_10">
                    {{ $employee->usr_crtd }}
                </td>
                <td class="text-center align_center edit tbl_txt_14">
                    {{$employee->ag_title}}
                </td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Employee</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

