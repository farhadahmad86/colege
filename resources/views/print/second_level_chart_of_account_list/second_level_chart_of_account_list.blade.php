
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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_9">
                Code
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                Control Account
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_36">
                Group Account
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_41">
                Remarks
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $account)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center edit tbl_amnt_9">
                    {{$account->coa_code}}
                </td>
                <td class="align_center text-center edit tbl_txt_10">
                    {{$account->first_level_name}}
                </td>
                <td class="align_left text-left edit tbl_txt_36">
                    {{$account->second_level_name }}
                </td>
                <td class="align_left text-left edit tbl_txt_41">
                    {{$account->coa_remarks }}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Account</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

