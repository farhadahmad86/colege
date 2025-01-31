
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="align_center text-center tbl_srl_4">
                Sr#
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_41">
                Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_41">
                Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_14">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $main_unit)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_left text-left edit tbl_txt_41">
                    {{$main_unit->mu_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_41">
                    {{$main_unit->mu_remarks }}
                </td>
                <td class="align_left edit text-left tbl_txt_14">
                    {{ $main_unit->user_name }}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Unit</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

