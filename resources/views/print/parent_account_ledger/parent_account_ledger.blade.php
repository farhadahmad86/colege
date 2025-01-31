
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                Sr.
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                Date
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                Voucher No.
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                Group Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                Parent Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                Account Name
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                Remarks
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                Debit
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                Credit
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr=1;
            $DR = $ttlDr = $CR = $ttlCr = $bal = $ttlBal = 0;
        @endphp
        @forelse($datas as $ledger)

            @php
                $DR = $ledger->bal_dr;
                $CR = $ledger->bal_cr;
                $bal = $ledger->bal_cr;
                $ttlDr = +$DR + +$ttlDr;
                $ttlCr = +$CR + +$ttlCr;
                $ttlBal = +$bal + +$ttlBal;

                $account=substr($ledger->bal_account_id,0,5);
                $type=substr($ledger->bal_voucher_number,0,2);
            @endphp

            <tr>
                <td class="text-center align_center tbl_srl_4">
                    {{ $sr }}
                </td>
                <td align="center" class="text-center align_center tbl_amnt_7">
                    {{date('d-M-y', strtotime(str_replace('/', '-', $ledger->bal_day_end_date)))}}
                </td>
                <td align="center" class="text-center align_center tbl_amnt_7">
                    <a class="view" data-transcation_id="{{$ledger->bal_voucher_number}}" data-toggle="modal" data-target="#myModal">
                        {{$ledger->bal_voucher_number}}
                    </a>
                </td>
                <td class="text-left align_left tbl_txt_13">
                    {{$ledger->grp_acnt_name}}
                </td>
                <td class="text-left align_left tbl_txt_13">
                    {{$ledger->parnt_acnt_name}}
                </td>
                <td class="text-left align_left tbl_txt_13">
                    {{$ledger->account_name}}
                </td>
                <td class="align_left text-left tbl_txt_13">
                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br /> <hr />', $ledger->bal_remarks) !!}
                </td>
                <td align="right" class="text-right align_right text-right tbl_amnt_15">
                    {{$ledger->bal_dr !=0 ? number_format($ledger->bal_dr,2):''}}
                </td>
                <td align="right" class="text-right align_right text-right tbl_amnt_15">
                    {{$ledger->bal_cr !=0 ? number_format($ledger->bal_cr,2):''}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Ledger</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

        <tr class="border-0">

            <th colspan="7" align="right" class="border-0 text-right align_right pt-0">
                Total:
            </th>
            <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                {{ number_format($ttlDr,2) }}
            </td>
            <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                {{ number_format($ttlCr,2) }}
            </td>
        </tr>

    </table>

@endsection

