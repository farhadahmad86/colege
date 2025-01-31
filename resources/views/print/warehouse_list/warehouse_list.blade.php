
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
            <th scope="col" align="center" class="text-center align_center tbl_txt_28" data-sortable="true" data-field="name">
                Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_30">
                Address
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_30">
                Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $warehouse)

            <tr>
                <td class="text-center align_center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_left text-left edit tbl_txt_28">
                    {{$warehouse->wh_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_30">
                    {{$warehouse->wh_address }}
                </td>
                <td class="align_left text-left edit tbl_txt_30">
                    {{$warehouse->wh_remarks }}
                </td>
                <td class="align_left usr_prfl text-left tbl_txt_8">
                    {{ $warehouse->user_name }}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Warehouse</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

