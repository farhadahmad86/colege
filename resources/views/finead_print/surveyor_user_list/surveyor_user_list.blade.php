
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
                Username
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Password
            </th>

        </tr>
        </thead>

        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $surveor_user)

            <tr>
                <td class="text-center align_center edit tbl_srl_2">
                    {{$sr}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$surveor_user->srv_name}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$surveor_user->srv_password_orignal}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Surveyor Username</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

