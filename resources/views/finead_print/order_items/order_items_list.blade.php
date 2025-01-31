
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
                Company
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Invoice No.
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                Project
            </th>

            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_15">
                Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_26">
                Detail Remarks
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                Total Price
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $invoice)

            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td nowrap class="align_center text-center tbl_amnt_10">
                    {{$invoice->account_name}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    PO-{{$invoice->ol_id}}
                </td>
                <td class="align_left text-left tbl_txt_10">
                    {{ $invoice->proj_project_name }}
                </td>

                <td class="align_left text-left tbl_txt_15">

                    {!!  $invoice->ol_remarks !!}

                </td>
                <td class="align_right text-right tbl_amnt_26">
                    @if( $type !== 'download_excel')
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->ol_detail_remarks) !!}
                    @else
                        {{ $invoice->ol_detail_remarks }}
                    @endif
                </td>
                <td class="align_right text-right tbl_amnt_5">
                    {{$invoice->ol_grand_total !=0 ? number_format($invoice->ol_grand_total,2):''}}
                </td>
                <td class="align_left text-left usr_prfl tbl_txt_10">
                    {{$invoice->user_name}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Invoice</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

