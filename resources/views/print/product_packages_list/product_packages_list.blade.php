
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
            <th scope="col" align="center" class="align_center text-center tbl_txt_25">
                Package Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_36">
                Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_8">
                Total Items
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Total Price
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $package)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_left text-left edit tbl_txt_25">
                    {{$package->pp_name}}
                </td>
                <td class="align_left text-left edit tbl_txt_36">
                    {{$package->pp_remarks}}
                </td>
                <td align="center" class="align_center text-center edit tbl_amnt_8">
                    {{$package->pp_total_items}}
                </td>
                <td align="right" class="align_right text-right edit tbl_amnt_15">
                    {{number_format($package->pp_total_price,2)}}
                </td>
                <td class="align_left edit text-left tbl_txt_12">
                    {{ $package->user_name }}
                </td>


            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Entry</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

