@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
<table class="table table-bordered table-sm" id="fixTable">

    <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                Sr
            </th>
            <th scope="col" class="tbl_txt_25">
                Bank Name
            </th>
            <th scope="col" class="tbl_txt_25">
                Branch Code
            </th>
            <th scope="col" class="tbl_txt_25">
                Account Title
            </th>
            <th scope="col" class="tbl_txt_26">
                Account#
            </th>

            <th scope="col" class="tbl_txt_8">
                Created By
            </th>
           
        </tr>
    </thead>

    <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $data)
            <tr>
                <th scope="row">
                    {{ $sr }}
                </th>
                <td class="edit ">
                    {{ $data->bi_bank_name }}
                </td>
                <td class="edit ">
                    {{ $data->bi_branch_code }}
                </td>
                <td class="edit ">
                    {{ $data->bi_account_title }}
                </td>
                <td>
                    {{ $data->bi_account_no }}
                </td>

                <td class="usr_prfl">
                    {{ $user->user_name }}
                </td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center>
                        <h3 style="color:#554F4F">No Bank Info</h3>
                    </center>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
