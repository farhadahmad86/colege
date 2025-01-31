
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
                <th scope="col" align="center" class="align_center text-center tbl_amnt_25">Account ID</th>
                <th scope="col" align="center" class="align_center text-center tbl_txt_71">Account Title</th>
            </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @foreach($datas as $account)

            <tr>

                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center edit text-center tbl_amnt_25">
                    {{$account->account_uid}}
                </td>
                <td class="align_left edit text-left tbl_txt_71">
                    {{$account->account_name}}
                </td>

            </tr>

            @php
                $sr++;
            @endphp
        @endforeach
        </tbody>

    </table>

@endsection

