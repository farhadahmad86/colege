@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Edit Attendance</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('attendance_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->
                    <form id="f1" action="{{ route('update_attendance',$attendance->atten_id) }}" method="post" onsubmit="return checkForm()">
                        @csrf
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->
                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Month
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                {{--                                                    Hamad set tab index--}}
                                                <input tabindex="1" type="text" name="month" id="month" class="inputs_up form-control month-picker" autocomplete="off"
                                                       value="{{$attendance->atten_month}}"
                                                       data-rule-required="true"
                                                       data-msg-required="Please Enter Month"
                                                       placeholder="Start Month ......">
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Month Days
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <input tabindex="2" type="text" name="month_days" id="month_days" class="inputs_up form-control" autocomplete="off" value="{{$attendance->atten_month_days}}"
                                                       onkeypress="return allow_only_number_and_decimals(this,event)" ;
                                                       data-rule-required="true"
                                                       data-msg-required="Please Enter Days"
                                                       placeholder="Enter Days ......">
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Attend Days
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <input tabindex="2" type="text" name="attend_days" id="attend_days" class="inputs_up form-control" autocomplete="off"
                                                       value="{{$attendance->atten_attend_days}}"
                                                       onkeypress="return allow_only_number_and_decimals(this,event)" ;
                                                       data-rule-required="true"
                                                       data-msg-required="Please Enter Days"
                                                       placeholder="Enter Days ......">
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->


                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Department
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->

                                                </div><!-- invoice column short end -->
                                                <select tabindex="3" name="department" class="inputs_up form-control" id="department">
                                                    <option value="0" selected disabled>Select Department</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{$department->dep_id}}" {{$attendance->atten_department_id == $department->dep_id ?
                                                        'Selected':''}}>{{$department->dep_title}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Employee
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->

                                                </div><!-- invoice column short end -->
                                                <select tabindex="3" name="employee" class="inputs_up form-control" id="employee">
                                                    <option value="0" selected disabled>Select Employee</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{$employee->user_id}}" {{$attendance->atten_emp_id == $employee->user_id ?
                                                        'Selected':''}}>{{$employee->user_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->


                                </div><!-- invoice row end -->


                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="invoice_col col-lg-12 text-right"><!-- invoice column start -->
                                        <button tabindex="5" type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->

                            </div><!-- invoice content end -->
                        </div><!-- invoice scroll box end -->
                        <input tabindex="-1" type="hidden" name="accountsval" id="accountsval">
                        <input tabindex="-1" type="hidden" name="account_name_text" id="account_name_text">
                    </form>
                </div><!-- invoice box end -->
            </div><!-- invoice container end -->
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let //account = document.getElementById("account"),
                month = document.getElementById("month"),
                department = document.getElementById("department"),
                totalAmount = document.getElementById("total_amount");
            validateInputIdArray = [
                //account.id,
                month.id,
                department.id,
                totalAmount.id,
            ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}


    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#department").select2();
            jQuery("#employee").select2();
        });
    </script>

@endsection

