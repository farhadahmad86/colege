
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
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Surveyor Type
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_6">
                Surveyor Name
            </th>

        </tr>
        </thead>

        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $assign_user)

            <tr>
                <td class="text-center align_center edit tbl_srl_2">
                    {{$sr}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$assign_user->srv_name}}
                </td>
                <td class="align_left text-left edit tbl_txt_10">
                    {{$assign_user->srv_password_orignal}}
                </td>
                <td class="align_left text-left edit tbl_txt_6">
                    {{$assign_user->au_surveyor_type}}
                </td>
                @php $surveyor_name='';
if($assign_user->account_name != null){$surveyor_name=$assign_user->account_name;}else{$surveyor_name=$assign_user->user_name;}@endphp
                <td class="align_left text-align_left edit tbl_txt_8">
                    {{$surveyor_name}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Username Assign</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

