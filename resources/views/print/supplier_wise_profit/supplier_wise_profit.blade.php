
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
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_56">
                Supplier Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Total Sale
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Total Profit
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $dr_pg = $cr_pg = 0;
        @endphp
        @forelse($datas as $invoice)
            @php
                $dr_pg = +$invoice->sale + +$dr_pg;
                $cr_pg = +$invoice->profit + +$cr_pg;
            @endphp
            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->si_day_end_date)))}}
                </td>
                <td class="align_left text-left tbl_txt_56">
                    {{$invoice->account_name}}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{$invoice->sale}}
                </td>
                <td align="right" class="align_right text-right tbl_amnt_15">
                    {{$invoice->profit}}
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
            <th colspan="3" align="right" class="border-0 text-right align_right">
                Page Total:
            </th>
            <td class="text-right border-0" align="right">
                {{ number_format($dr_pg,2) }}
            </td>
            <td class="text-right border-0" align="right">
                {{ number_format($cr_pg,2) }}
            </td>
        </tr>

    </table>

@endsection

