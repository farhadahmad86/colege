@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Transport Voucher</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('transport_voucher_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->
                            <form id="f1" action="{{ route('submit_transport_voucher') }}" method="post" onsubmit="return checkForm()">
                                @csrf
                                <div class="invoice_row"><!-- invoice row start -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Dr Account
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->

                                                </div><!-- invoice column short end -->
                                                <select tabindex="1" autofocus name="dr_account" class="inputs_up form-control" id="dr_account" data-rule-required="true"
                                                        data-msg-required="Please
                                                    Enter
                                                    Dr Account">
                                                    <option value="">Select Dr Account</option>
                                                    @foreach($dr_accounts as $dr_account)
                                                        <option value="{{$dr_account->account_uid}}">{{$dr_account->account_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Cr Account
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->

                                                </div><!-- invoice column short end -->
                                                <select tabindex="1" autofocus name="cr_account" class="inputs_up form-control" id="cr_account" data-rule-required="true"
                                                        data-msg-required="Please
                                                    Enter
                                                    Cr Account">
                                                    <option value="">Select Cr Account</option>
                                                    @foreach($cr_accounts as $cr_account)
                                                        <option value="{{$cr_account->account_uid}}">{{$cr_account->account_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Voucher Remarks
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <input tabindex="2" type="text" name="remarks" class="inputs_up form-control" id="remarks" placeholder="Remarks">
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                Month
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <input tabindex="2" type="text" name="month" id="month" class="inputs_up form-control month-picker" autocomplete="off" value=""
                                                       data-rule-required="true"
                                                       data-msg-required="Please Enter Month"
                                                       placeholder="Start Month ......">
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->


                                    <input tabindex="-1" type="hidden" name="accountsval" id="accountsval">
                                </div><!-- invoice row end -->
                                <div class="invoice_row row"><!-- invoice row start -->
                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Issue Date
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                </div><!-- invoice column short end -->
                                                <input tabindex="5" type="text" name="issue_date" id="issue_date"
                                                       class="inputs_up form-control datepicker1" data-rule-required="true" data-msg-required="Please Issue Date" autocomplete="off"
                                                       value=""
                                                       placeholder="Issue Date ......"/>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Due Date
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                </div><!-- invoice column short end -->
                                                <input tabindex="5" type="text" name="due_date" id="due_date"
                                                       class="inputs_up form-control datepicker1" autocomplete="off"
                                                       value="" data-rule-required="true" data-msg-required="Please Enter Due Date"
                                                       placeholder="Due Date ......"/>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Total Payable Amount
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                </div><!-- invoice column short end -->
                                                <input tabindex="-1" type="text" name="total_payable_amount" class="inputs_up text-right form-control" id="total_payable_amount"
                                                       placeholder="0.00" readonly data-rule-required="true" data-msg-required="Please Add"/>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="col-lg-3 text-right mt-4"><!-- invoice column start -->
                                        <button tabindex="8" type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->
                            </form>
                            <div class="invoice_row"><!-- invoice row start -->
                                <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                    <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                        <div class="table-responsive" id="printTable"><!-- product table box start -->
                                            <table tabindex="-1" class="table table-bordered table-sm" id="fixTable">
                                                <thead>
                                                <tr>
                                                    <th tabindex="-1" class="tbl_srl_4"> Sr.</th>
                                                    <th tabindex="-1" class="tbl_srl_12"> Route</th>
                                                    <th tabindex="-1" class="tbl_srl_14"> Route Name</th>
                                                    <th tabindex="-1" class="tbl_srl_5"> Reg#</th>
                                                    <th tabindex="-1" class="tbl_txt_15"> Student Name</th>
                                                    <th tabindex="-1" class="tbl_txt_14">Father Name</th>
                                                    <th tabindex="-1" class="tbl_txt_14">Class Name</th>
                                                    <th tabindex="-1" class="tbl_txt_4"> Section</th>
                                                    <th tabindex="-1" class="tbl_txt_10">Route Type</th>
                                                    <th tabindex="-1" class="tbl_txt_8"> Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody tabindex="-1" id="table_body">
                                                @php
                                                    $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                                                    $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                                                    $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                                    $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                                                    $ttlAmount = 0;
                                                @endphp
                                                @forelse($students as $key=>$student)
                                                    <tr>
                                                        <th scope="row" >
                                                            {{ $sr }}
                                                        </th>

                                                        <td >
                                                            {{ $student->tr_title }}
                                                            <input type="hidden" name="route_id[]" id="route_id{{$student->id}}" value="{{$student->tr_id}}">
                                                        </td>
                                                        <td>
                                                            {{ $student->tr_name }}
                                                        </td>
                                                        <td>
                                                            {{ $student->registration_no }}
                                                            <input type="hidden" name="registration_no[]" id="registration_no{{$student->id}}" value="{{$student->registration_no}}">
                                                        </td>
                                                        <td nowrap >
                                                            {{$student->full_name}}
                                                            <input type="hidden" name="std_id[]" id="std_id{{$student->id}}" value="{{$student->id}}">
                                                        </td>
                                                        <td nowrap >
                                                            {{$student->father_name}}
                                                        </td>
                                                        <td nowrap >
                                                            {{$student->class_name}}
                                                        </td>
                                                        <td nowrap >
                                                            {{$student->cs_name}}
                                                        </td>
                                                        <td >
                                                            {{ $student->route_type ==1 ? 'Single Route': 'Double Route'}}
                                                        </td>

                                                        @php

                                                            if ($student->route_type == 1) {
                                                                $ttlAmount = +$student->tr_single_route_amount + +$ttlAmount;
                                                            }else{
                                                                $ttlAmount = +$student->tr_double_route_amount + +$ttlAmount;
                                                            }
                                                        @endphp
                                                        @if($student->route_type == 1)
                                                            <input type="hidden" name="amount[]" id="amount{{$student->id}}" value="{{$student->tr_single_route_amount}}">
                                                        @else
                                                            <input type="hidden" name="amount[]" id="amount{{$student->id}}" value="{{$student->tr_double_route_amount}}">
                                                        @endif

                                                        <td class="text-right">
                                                            {{  $student->route_type == 1 ? number_format($student->tr_single_route_amount) : number_format($student->tr_double_route_amount)}}

                                                        </td>
                                                    </tr>
                                                    @php
                                                        $sr++;
                                                        !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                                    @endphp
                                                @empty
                                                    <tr>
                                                        <td colspan="15">
                                                            <center>
                                                                <h3 style="color:#554F4F">No Student</h3>
                                                            </center>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th tabindex="-1" colspan="6" class="text-right">
                                                        Total
                                                    </th>
                                                    <td tabindex="-1" class="tbl_srl_12">
                                                        <div class="invoice_col_txt"><!-- invoice column box start -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input tabindex="-1" type="text" name="total_amount" class="inputs_up text-right form-control" id="total_amount"
                                                                       placeholder="0.00" readonly data-rule-required="true" data-msg-required="Please Add" value="{{$ttlAmount}}"/>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </td>
                                                </tr>
                                                </tfoot>
                                                <script>
                                                    $('#total_payable_amount').val('{{ $ttlAmount }}');
                                                </script>
                                            </table>
                                        </div><!-- product table box end -->
                                    </div><!-- product table container end -->
                                </div><!-- invoice column end -->
                            </div><!-- invoice row end -->
                        </div><!-- invoice content end -->
                    </div><!-- invoice scroll box end -->

                    <span id="voucher_existing" style="font-size: 20px; color: red"></span>

                </div><!-- invoice box end -->
            </div><!-- invoice container end -->
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    <script src="{{ asset('public/plugins/nabeel_blue/jquery.floatThead.js') }}"></script>
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            jQuery("#accountsval").val('');
            const jsonData = {};
            $('input[name="std_id[]"]').each(function (pro_index) {
                var std_id = $(this).val();
                var student_name = $('#student_name' + std_id).val();
                var route_id = $('#route_id' + std_id).val();
                var registration_no = $('#registration_no' + std_id).val();
                var amount = $('#amount' + std_id).val();
                if (amount != 0) {
                    jsonData[pro_index] = {
                        'std_id': std_id,
                        'student_name': student_name,
                        'route_id': route_id,
                        'registration_no': registration_no,
                        'amount': amount,
                    };
                }
            });
            jQuery("#accountsval").val(JSON.stringify(jsonData));
            let dr_account = document.getElementById("dr_account"),
                cr_account = document.getElementById("cr_account"),
                month = document.getElementById("month"),
                issue_date = document.getElementById("issue_date"),
                due_date = document.getElementById("due_date"),
                totalAmount = document.getElementById("total_amount"),
                totalPayableAmount = document.getElementById("total_payable_amount"),
                validateInputIdArray = [
                    dr_account.id,
                    cr_account.id,
                    month.id,
                    issue_date.id,
                    due_date.id,
                    totalAmount.id,
                    totalPayableAmount.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}

    @if (Session::get('exist'))
        <script>
            jQuery("#table_body").html("");

            var exist = '{{ Session::get('exist') }}';
            var month = '{{ Session::get('month') }}';
            if(exist != ''){
                $('#voucher_existing').html(`${month} voucher already created against ${exist} registration number `)
            }
        </script>
    @endif
    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                $("#first_add_more").click();
                // event.preventDefault();
                return false;
            }
        });

    </script>

    <script>
        jQuery(document).ready(function () {
            $('table').floatThead({
                position: 'absolute'
            });
            // Initialize select2
            jQuery("#cr_account").select2();
            jQuery("#dr_account").select2();
        });
    </script>
@endsection

