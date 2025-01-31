@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>

        <tr>
            <th scope="col" class="text-center align_center tbl_srl_4">
                Sr.
            </th>
            <th scope="col" class="text-center align_center tbl_amnt_8">
                Date
            </th>
            <th scope="col" class="text-center align_center tbl_amnt_9">
                Voucher No.
            </th>
            <th scope="col" class="text-left tbl_txt_17">
                Remarks
            </th>
            <th scope="col" class="text-left tbl_txt_23">
                Detail Remarks
            </th>
            <th scope="col" class="text-center align_center tbl_amnt_13">
                Debit
            </th>
            <th scope="col" class="text-center align_center tbl_amnt_13">
                Credit
            </th>
            <th scope="col" class="text-center align_center tbl_amnt_13">
                Total Balance
            </th>

        </tr>

        </thead>

        <tbody>
        @php
            $sr = 1;
            $DR = $ttlDr = $CR = $ttlCr = $bal = $ttlBal = 0;
        @endphp
        @foreach($datas as $ledger)
            {{--            @forelse($datas as $ledger)--}}

            @php
                $DR = $ledger->bal_dr;
                $CR = $ledger->bal_cr;
                $bal = $ledger->bal_total;
                $ttlDr = +$DR + +$ttlDr;
                $ttlCr = +$CR + +$ttlCr;
                $ttlBal = $bal;

                $account=substr($ledger->bal_account_id,0,5);
               // $type=substr($ledger->bal_voucher_number,0,2);
            @endphp

            <tr>
                <th>
                    {{ $sr }}
                </th>
                <td>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $ledger->bal_day_end_date)))}}
                </td>
                <td>
                    <a class="view" data-transcation_id="{{$ledger->bal_voucher_number}}" data-toggle="modal" data-target="#myModal" style="cursor:pointer; color: #0099ff;">
                        {{$ledger->bal_voucher_number}}
                    </a>
                </td>
                <td>
                    {!! $ledger->bal_remarks !!}
                </td>
                <td>

                    @if($account!=config('global_variables.receivable') && $account!=config('global_variables.payable'))
                        {{--                            <!-- {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br /> <hr />', $ledger->bal_detail_remarks) !!} -->--}}
                        {{ str_replace('&oS;', ' ', $ledger->bal_detail_remarks) }}
                    @elseif(substr($ledger->bal_voucher_number,0,2)=='JV' || substr($ledger->bal_voucher_number,0,2)=='CP' || substr($ledger->bal_voucher_number,0,2)=='CR' || substr($ledger->bal_voucher_number,0,2)=='BP' || substr($ledger->bal_voucher_number,0,2)=='BR')
                    @else
                        {{ str_replace('&oS;', ' ', $ledger->bal_detail_remarks) }}
                        {{--                            <!-- {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br /> <hr />', $ledger->bal_detail_remarks) !!} -->--}}
                    @endif
                </td>
                <td align="right" class="align_right text-right">
                    {{$ledger->bal_dr !=0 ? number_format($ledger->bal_dr,2):''}}
                </td>
                <td align="right" class="align_right text-right">
                    {{$ledger->bal_cr !=0 ? number_format($ledger->bal_cr,2):''}}
                </td>
                <td align="right" class="align_right text-right">
                    {{$ledger->bal_total !=0 ? number_format($ledger->bal_total,2):''}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
            {{--            @empty--}}
            {{--                <tr>--}}
            {{--                    <td colspan="11">--}}
            {{--                        <center><h3 style="color:#554F4F">No Ledger</h3></center>--}}
            {{--                    </td>--}}
            {{--                </tr>--}}
        @endforeach
        {{--            @endforelse--}}
        </tbody>

        <tfoot>
        <tr class="border-0">
            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                Total:
            </th>
            <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                {{ number_format($ttlDr,2) }}
            </td>
            <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
            {{ number_format($ttlCr,2) }}
        </tr>
        </tfoot>


    </table>

@endsection

