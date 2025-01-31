
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
            <th scope="col" align="center" class="text-center align_center tbl_txt_84">
                Date/Time
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $list)

            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_left text-left tbl_txt_84">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $list->dbb_created_at)))}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_12">
                    {{$list->user_name}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No List</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

