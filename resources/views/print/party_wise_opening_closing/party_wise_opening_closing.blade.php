
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
            <th scope="col" align="center" class="align_center text-center tbl_txt_28">
                Account Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_17">
                Opening Balance
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_17">
                Total Dr
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_17">
                Total Cr
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_17">
                Total Closing
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr=1;
            $dr_pg = $cr_pg = 0;
            $opng_pg = $clsng_pg = 0;
        @endphp
        @forelse($datas as $result)
            @php
                $dr_pg = +$result->dr + +$dr_pg;
                $cr_pg = +$result->cr + +$cr_pg;
                $opng_pg = +$result->opening + +$opng_pg;
                $clsng_pg = +$result->closing + +$clsng_pg;
            @endphp

            <tr>
                <td align="center" class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td align="left" class="align_left text-left tbl_txt_28">
                    {{$result->account_name}}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_17">
                    {{$result->opening}}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_17">
                    {{$result->dr}}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_17">
                    {{$result->cr}}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_17">
                    {{$result->closing}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Record</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>


        <tr class="border-0">
            <th colspan="2" align="right" class="border-0 text-right align_right">
                Page Total:
            </th>
            <td class="text-right border-0" align="right">
                {{ number_format($opng_pg,2) }}
            </td>
            <td class="text-right border-0" align="right">
                {{ number_format($dr_pg,2) }}
            </td>
            <td class="text-right border-0" align="right">
                {{ number_format($cr_pg,2) }}
            </td>
            <td class="text-right border-0" align="right">
                {{ number_format($clsng_pg,2) }}
            </td>
        </tr>

    </table>

@endsection

