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
            <th scope="col" align="center" class="align_center text-center tbl_txt_30">
                Department
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                Gross Salary
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                Advance Salary
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                Loan
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                Net Salary
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                Advance Salary %
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                # Of Employee
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $per_page_ttl_amnt = 0;
            $ttl_employees = 0;
                            $ttl_gross_salary = 0;
                            $ttl_net_salary = 0;
                            $ttl_advance_salary = 0;
                            $ttl_loan = 0;
        @endphp
        @forelse($datas as $voucher)
            @php $ttl_employees = +$voucher->employee + +$ttl_employees;
                                $ttl_gross_salary = +$voucher->gross + +$ttl_gross_salary;
                                $ttl_net_salary = +$voucher->net + +$ttl_net_salary;
                              $ttl_advance_salary = +$voucher->advance + +$ttl_advance_salary;
                              $ttl_loan = +$voucher->loan + +$ttl_loan;
                                if($voucher->gross !=null){
                                $advance_pec=($voucher->advance/$voucher->gross)*100;
                                }
            @endphp
            <tr>
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_left text-left tbl_txt_30">
                    {!! $voucher->dep_title !!}
                </td>


                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->gross !=0 ? number_format($voucher->gross,2):''}}

                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->advance !=0 ? number_format($voucher->advance,2):''}}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->loan !=0 ? number_format($voucher->loan,2):''}}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->net - $voucher->advance - $voucher->loan}}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{number_format($advance_pec,0).'%'}}
                </td>
                <td class="align_right text-right tbl_amnt_10">
                    {{$voucher->employee}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No List Found</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

        <tr class="border-0">
            <th colspan="2" align="right" class="border-0 text-right align_right pt-0">
                Page Total:
            </th>
            <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                {{ number_format($ttl_gross_salary,2) }}
            </td>
            <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                {{ number_format($ttl_advance_salary,2) }}
            </td>
            <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                {{ number_format($ttl_loan,2) }}
            </td>
            <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                {{ number_format($ttl_net_salary - $ttl_advance_salary - $ttl_loan,2) }}
            </td>
            <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                @php $ttl_percent=0; if($ttl_advance_salary!=null){
                                $ttl_percent=($ttl_advance_salary/$ttl_gross_salary)*100;
                                }
                @endphp
                {{number_format($ttl_percent,0) .'%'}}
            </td>
            <td class="text-right border-left-0" align="right" style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                {{ $ttl_employees }}
            </td>
        </tr>


    </table>

@endsection

