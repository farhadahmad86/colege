
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="align_center text-center tbl_srl_4">
                ID
            </th>
            <th scope="col"align="center" class="align_center text-center tbl_txt_25">
                Main Unit
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_25">
                Unit Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                Scale Size
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_30">
                Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @forelse($datas as $unit)

            <tr>

                <td class="align_center text-center edit tbl_srl_4">
                    {{$unit->unit_id}}
                </td>
                <td class="align_left text-left edit tbl_txt_25">
                    {{$unit->mu_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_25">
                    {{$unit->unit_title}}
                </td>
                <td class="align_center text-center edit tbl_amnt_5">
                    {{$unit->unit_scale_size}}
                </td>
                <td class="align_left text-left edit tbl_txt_30">
                    {{$unit->unit_remarks}}
                </td>
                <td class="align_left usr_prfl text-left tbl_txt_12">
                    {{ $unit->user_name }}
                </td>

            </tr>
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

