
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">
        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_6">
                Sr#
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_38">
                Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
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
                <td class="align_center text-center edit tbl_srl_6">
                    {{$sr}}
                </td>
                <td class="align_left text-left edit tbl_txt_38">
                    {{$data->srv_name}}
                </td>
                <td class="align_left text-left usr_prfl tbl_amnt_10">
                    {{$data->user_name}}
                </td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Surveyor</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

