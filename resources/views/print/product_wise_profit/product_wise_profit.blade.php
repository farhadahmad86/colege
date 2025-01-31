
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table table-bordered table-sm">

        <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                Sr#
            </th>
            <th scope="col" class="tbl_txt_66">
                Product Name
            </th>
            <th scope="col" class="tbl_amnt_15">
                Total Sale
            </th>
            <th scope="col" class="tbl_amnt_15">
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
                <th scope="row">
                    {{$sr}}
                </th>
                <td>
                    {{$invoice->pro_title}}
                </td>
                <td align="right" class="align_right text-right">
                    {{$invoice->sale}}
                </td>
                <td align="right" class="align_right text-right">
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
            <th colspan="2" align="right" class="border-0 text-right align_right">
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

