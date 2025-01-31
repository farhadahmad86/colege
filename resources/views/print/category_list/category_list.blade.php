
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
            <th scope="col" align="center" class="align_center text-center tbl_txt_25">
                Group Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_25">
                Category Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_32">
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
        @forelse($datas as $category)

            <tr>

                <td class="align_center text-center edit tbl_srl_4">
                    {{$category->cat_id}}
                </td>
                <td class="align_left text-left edit tbl_txt_25">
                    {{$category->grp_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_25">
                    {{$category->cat_title}}
                </td>
                <td class="align_left text-left edit tbl_txt_32">
                    {{$category->cat_remarks}}
                </td>
                <td class="align_left usr_prfl text-left tbl_txt_14">
                    {{ $category->user_name }}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Group</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

