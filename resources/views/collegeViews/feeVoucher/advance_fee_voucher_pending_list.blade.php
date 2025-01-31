@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">
                                Advance Voucher Pending
                                List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ !empty($search) || !empty($search_to) || !empty($search_from) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('advance_fee_voucher_pending_list') }}" name="form1"
                          id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" class="inputs_up form-control"
                                           name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <span id="demo1" class="validate_sign" style="float: right !important">
                                            </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 srch_brdr_left">
                                <div class="row">

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Start Date
                                            </label>
                                            <input tabindex="2" type="text" name="to" id="to"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_to)){?> value="{{ $search_to }}" <?php } ?>
                                                   placeholder="Start Date ......"/>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                End Date
                                            </label>
                                            <input tabindex="3" type="text" name="from" id="from"
                                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_from)){?> value="{{ $search_from }}" <?php } ?>
                                                   placeholder="End Date ......"/>
                                            <span id="demo1" class="validate_sign"
                                                  style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Class
                                            </label>
                                            <select tabindex="4" name="class_id"
                                                    class="inputs_up form-control" id="class_id">
                                                <option value="">Select Class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->class_id }}"
                                                        {{ $class->class_id == $search_class ? 'selected="selected"' : '' }}>
                                                        {{ $class->class_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <x-year-end-component search="{{$search_year}}"/>

                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                    @include('include.clear_search_button')

                                    <!-- Call add button component -->
                                        {{--                                        @include('include/print_button')--}}

                                        <span id="demo1" class="validate_sign"
                                              style="float: right !important"> </span>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
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
                                Remarks
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
                                    AFV-{{ $voucher->v_no }}
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
                                    {{ $voucher->fund + $voucher->t_fee != 0 ? number_format($voucher->fund + $voucher->t_fee, 2) : '' }}
                                </td>

                                <form action="{{route('paid_single_advance_fee_voucher',$voucher->id)}}" method="post">
                                    @csrf
                                    <td>
                                        <input type="text" name="remarks" class="inputs_up form-control" value="" placeholder="Enter Remarks">
                                    </td>
                                    <td>
                                        <input type="text" name="amount" class="inputs_up form-control" value="{{$voucher->fund + $voucher->t_fee}}"
                                               onkeypress="return allow_only_number_and_decimals(this,event);">
                                    </td>
                                    <td>
                                        <input type="hidden" name="student_id" value="{{$voucher->student_id}}">
                                        <input type="hidden" name="std_id" value="{{$voucher->registration_no}}">
                                        <input type="hidden" name="voucher_no" value="{{$voucher->v_no}}">


                                        <select tabindex="1" name="account" class="inputs_up form-control bank_voucher" id="account" data-rule-required="true" data-msg-required="Please Enter Bank">
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
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'to' => $search_to, 'from' => $search_from])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('advance_fee_voucher_pending_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".edit").click(function () {

            var account_id = jQuery(this).attr("data-id");

            jQuery("#account_id").val(account_id);
            jQuery("#edit").submit();
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');

            $("#class_id").select2().val(null).trigger("change");
            $("#class_id > option").removeAttr('selected');

            $("#status").select2().val(null).trigger("change");
            $("#status > option").removeAttr('selected');
        });

        jQuery("#class_id").select2();
        jQuery("#status").select2();
    </script>
@endsection
