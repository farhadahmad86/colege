@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')


    <table class="table table-bordered table-sm" id="fixTable">

        <thead>
        <tr>
            <th tabindex="-1" scope="col" class="tbl_srl_4">
                Sr#
            </th>
            <th scope="col" class="tbl_amnt_6">
                Voucher#
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_10">
                Registration
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_15">
                Student Name
            </th>
            <th tabindex="-1" scope="col" class="tbl_txt_15">
                Class
            </th>
            <th scope="col" class="tbl_amnt_10">
                Total Amount
            </th>
            <th scope="col" class="tbl_amnt_10">
                Amount
            </th>
            <th scope="col" class="tbl_txt_10">
                Bank
            </th>
            <th scope="col" class="tbl_txt_10">
                Paid Date
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
            $per_page_ttl_amnt = 0;
        @endphp
        @forelse($datas as $voucher)
            @php $per_page_ttl_amnt = +$voucher->total_amount + +$per_page_ttl_amnt; @endphp

            <tr data-toggle="tooltip" data-placement="top" title=""
                data-original-title="View Journal Voucher">
                <th scope="row">
                    {{ $sr }}
                </th>
                <td>
                    {{$search_status == 'fee_voucher' ? 'FV-':'CV-'}}{{ $voucher->v_no }}
                </td>
                <td>
                    {{ $voucher->registration_no }}
                </td>
                <td>
                    {{ $voucher->full_name }}
                </td>
                <td>
                    {{ $voucher->class_name }}
                </td>

                <td class="align_right text-right">
                    {{ $voucher->total_amount != 0 ? number_format($voucher->total_amount, 2) : '' }}
                </td>

                <form action="{{route('paid_single_fee_voucher',$voucher->id)}}" method="post">
                    @csrf
                    <td>
                        <input type="text" name="amount" class="inputs_up form-control" value="{{$voucher->total_amount}}" onkeypress="return allow_only_number_and_decimals(this,event);">
                    </td>
                    <td>
                        <input type="hidden" name="student_id" value="{{$voucher->student_id}}">
                        <input type="hidden" name="std_id" value="{{$voucher->registration_no}}">
                        <input type="hidden" name="voucher_no" value="{{$voucher->v_no}}">


                        <select tabindex="1" name="account" class="inputs_up form-control bank_voucher" id="account" data-rule-required="true" data-msg-required="Please Enter
Bank">
                            <option value="">Select Bank</option>
                            @foreach($accounts as $account)
                                <option value="{{$account->account_uid}}">{{$account->account_uid}} - {{$account->account_name}}</option>
                            @endforeach
                        </select>

                    </td>
                    <td>
                        <!-- start input box -->
                        <div class="d-flex">
                            <input tabindex="2" type="text" name="date"
                                   class="inputs_up form-control datepicker1" data-rule-required="true"
                                   data-msg-required="Please Enter Paid Date" autocomplete="off"
                                   placeholder="Paid Date ......"/>
                            <button tabindex="8" type="submit" name="save" id="paid_save" class="invoice_frm_btn btn btn-sm btn-success">
                                <i class="fa fa-floppy-o"></i> Pay
                            </button>
                        </div>

                    </td>
                </form>

            </tr>
            @php
                $sr++;
                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center>
                        <h3 style="color:#554F4F">No voucher</h3>
                    </center>
                </td>
            </tr>
        @endforelse
        </tbody>

        <tfoot>
        <tr class="border-0">
            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                Per Page Total:
            </th>
            <td class="text-right border-left-0" align="right"
                style="border-bottom: 1px solid #000;border-right: 0 solid transparent;">
                {{ number_format($per_page_ttl_amnt, 2) }}
            </td>
        </tr>
        <tr class="border-0">
            <th colspan="5" align="right" class="border-0 text-right align_right pt-0">
                Grand Total:
            </th>
            <td class="text-right border-left-0" align="right"
                style="border-bottom: 2px solid #000;border-bottom: 3px double #000;border-right: 0 solid transparent;">
                {{ number_format($ttl_amnt, 2) }}
            </td>
        </tr>
        </tfoot>

    </table>

@endsection

