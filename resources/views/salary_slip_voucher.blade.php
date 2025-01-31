@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Salary Slip Voucher</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('salary_slip_voucher_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->



                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                        <form id="f1" action="{{ route('submit_salary_slip_voucher') }}"
                              onsubmit="return checkForm()"
                              method="post" autocomplete="off">
                            @csrf
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                    <div class="invoice_row"><!-- invoice row start -->

                                        <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.select_employee.description')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Employee
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <div class="invoice_col_short"><!-- invoice column short start -->
                                                        <a href="{{ route('add_employee') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                            <i class="fa fa-plus"></i>
                                                        </a>

                                                        <a id="refresh_employee" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                            <i class="fa fa-refresh"></i>
                                                        </a>
                                                    </div><!-- invoice column short end -->
                                                    <select tabindex=1 autofocus name="employee" class="inputs_up inputs_up_invoice form-control js-example-basic-multiple" id="employee" data-rule-required="true" data-msg-required="Please Select Employee">
                                                        <option value="0">Select Employee</option>
                                                        @foreach($employees as $employee)
                                                            <option value="{{$employee->user_id}}">
                                                                {{$employee->user_name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.basic_salary.description')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Basic Salary
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="2" type="text" name="basic_salary" data-rule-required="true" data-msg-required="Basic Salary" class="inputs_up form-control" id="basic_salary" placeholder="Basic Salary" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="total_calculation();">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Remarks
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="3" type="text" name="remarks" class="inputs_up form-control" id="remarks" placeholder="Remarks" />
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.salary_based_conditions.description')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Invoice Type
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_txt"><!-- invoice column input start -->
                                                    <div class="radio inline_radio">
                                                        <label>
                                                            <input tabindex="4"type="radio" name="salary_period" class="invoice_type salary_period" id="salary_period1" value="1" onchange="total_calculation();">
                                                            Hourly
                                                        </label>
                                                    </div>
                                                    <div class="radio inline_radio">
                                                        <label>
                                                            <input tabindex="5" type="radio" name="salary_period" class="invoice_type salary_period" id="salary_period2" value="2" onchange="total_calculation();">
                                                            Daily
                                                        </label>
                                                    </div>
                                                    <div class="radio inline_radio">
                                                        <label>
                                                            <input tabindex="6" type="radio" name="salary_period" class="invoice_type salary_period" id="salary_period3" value="3" onchange="total_calculation();" checked>
                                                            Monthly
                                                        </label>
                                                    </div>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.off_days.description')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Off Days
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <select tabindex="7" name="holidays[]" class="inputs_up inputs_up_invoice form-control" data-rule-required="true" data-msg-required="Please Select Off Days" id="holidays" multiple>
                                                        <option value="1">Monday</option>
                                                        <option value="2">Tuesday</option>
                                                        <option value="3">Wednesday</option>
                                                        <option value="4">Thursday</option>
                                                        <option value="5">Friday</option>
                                                        <option value="6">Saturday</option>
                                                        <option value="7">Sunday</option>
                                                    </select>
                                                    <span id="holidays_error_msg" class="validate_sign"> </span>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                    </div><!-- invoice row end -->

                                    <div class="invoice_row"><!-- invoice row start -->

                                        <div class="invoice_col basis_col_18"><!-- invoice column start -->

                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="invoice_col_ttl"><!-- invoice column title start -->

                                                            Working
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                                <label class="inline_input_txt_lbl required" for="total_product_discount">
                                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                       data-placement="bottom" data-html="true"
                                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.working_days_in_month.description')}}</p>">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a>
                                                                    Days in Month
                                                                </label>
                                                                <div class="invoice_col_input">
                                                                    <input tabindex="8" type="text" name="total_working_days_in_months" class="inputs_up form-control text-right"
                                                                           data-rule-required="true" data-msg-required="Please Add Days"
                                                                           id="total_working_days_in_months" placeholder="Working Days in Month" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="total_calculation();" />
                                                                </div>
                                                            </div><!-- invoice inline input text end -->
                                                            <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                                <label class="inline_input_txt_lbl required" for="total_service_discount">
                                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                       data-placement="bottom" data-html="true"
                                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.days_hours.description')}}</p>">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a>
                                                                    Hours/Day
                                                                </label>
                                                                <div class="invoice_col_input">
                                                                    <input tabindex="9" type="text" name="working_hours_per_day" class="inputs_up form-control text-right"
                                                                           data-rule-required="true" data-msg-required="Please Add Hours/Day"
                                                                           id="working_hours_per_day" placeholder="Working Hours/Day" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="total_calculation();">
                                                                </div>
                                                            </div><!-- invoice inline input text end -->

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->


                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.days_hours.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Days/Hours
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <div class="radio inline_radio">
                                                                <label>
                                                                    <input tabindex="10" type="radio" name="hours_or_days" class="invoice_type hours_or_days" id="hours_or_days1" value="1" onchange="total_calculation();" checked>
                                                                    Days
                                                                </label>
                                                            </div>
                                                            <div class="radio inline_radio">
                                                                <label>
                                                                    <input tabindex="11" type="radio" name="hours_or_days" class="invoice_type hours_or_days" id="hours_or_days2" value="2" onchange="total_calculation();">
                                                                    Hours
                                                                </label>
                                                            </div>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                            Attended
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                                <label class="inline_input_txt_lbl" for="total_inclusive_tax">
                                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                       data-placement="bottom" data-html="true"
                                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.attended_days.description')}}</p>">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a>
                                                                    Days
                                                                </label>
                                                                <div class="invoice_col_input">
                                                                    <input tabindex="12" type="text" name="attended_days" class="inputs_up form-control text-right" id="attended_days" placeholder="Attended Days" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="total_calculation();" />
                                                                </div>
                                                            </div><!-- invoice inline input text end -->
                                                            <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                                <label class="inline_input_txt_lbl" for="total_exclusive_tax">
                                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                       data-placement="bottom" data-html="true"
                                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.attended_hours.description')}}</p>">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a>
                                                                    Hours
                                                                </label>
                                                                <div class="invoice_col_input">
                                                                    <input tabindex="14" type="text" name="attended_hours" class="inputs_up form-control text-right" id="attended_hours" placeholder="Attended Hours" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="total_calculation();">
                                                                </div>
                                                            </div><!-- invoice inline input text end -->

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->


                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                            Salary Payment Method
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <div class="radio inline_radio">
                                                                <label>
                                                                    <input tabindex="15" type="radio" name="salary_payment_method" class="invoice_type salary_payment_method" id="salary_payment_method1" value="1">
                                                                    Daily
                                                                </label>
                                                            </div>
                                                            <div class="radio inline_radio">
                                                                <label>
                                                                    <input tabindex="16" type="radio" name="salary_payment_method" class="invoice_type salary_payment_method" id="salary_payment_method2" value="2">
                                                                    Weekly
                                                                </label>
                                                            </div>
                                                            <div class="radio inline_radio">
                                                                <label>
                                                                    <input tabindex="17" type="radio" name="salary_payment_method" class="invoice_type salary_payment_method" id="salary_payment_method3" value="3" checked />
                                                                    Monthly
                                                                </label>
                                                            </div>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                            Salary
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <div class="invoice_inline_input_txt date_from"><!-- invoice inline input text start -->
                                                                <label tabindex="18" class="inline_input_txt_lbl" for="service_total_inclusive_tax">
                                                                    Date From:
                                                                </label>
                                                                <div class="invoice_col_input">
                                                                    <input tabindex="19" type="text" name="date_from" class="inputs_up form-control date-picker" id="date_from" placeholder="Date From" onfocus="this.select();" />
                                                                </div>
                                                            </div><!-- invoice inline input text end -->
                                                            <div class="invoice_inline_input_txt date_to"><!-- invoice inline input text start -->
                                                                <label class="inline_input_txt_lbl" for="service_total_exclusive_tax">
                                                                    Date To
                                                                </label>
                                                                <div class="invoice_col_input">
                                                                    <input type="text" name="date_to" class="inputs_up form-control date-picker" id="date_to" placeholder="Date To" onfocus="this.select();">
                                                                </div>
                                                            </div><!-- invoice inline input text end -->
                                                            <div class="invoice_inline_input_txt salary_month"><!-- invoice inline input text start -->
                                                                <label class="inline_input_txt_lbl" for="service_total_exclusive_tax">
                                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                       data-placement="bottom" data-html="true"
                                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.salary_month.description')}}</p>">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a>
                                                                    Salary Month
                                                                </label>
                                                                <div class="invoice_col_input">
                                                                    <select tabindex="19" name="salary_month" class="inputs_up inputs_up_invoice form-control" id="salary_month">
                                                                        <option value=''>--Select Month--</option>
                                                                        <option value='1' {{$current_month==1 ? 'selected':''}}>January</option>
                                                                        <option value='2' {{$current_month==2 ? 'selected':''}}>February</option>
                                                                        <option value='3' {{$current_month==3 ? 'selected':''}}>March</option>
                                                                        <option value='4' {{$current_month==4 ? 'selected':''}}>April</option>
                                                                        <option value='5' {{$current_month==5 ? 'selected':''}}>May</option>
                                                                        <option value='6' {{$current_month==6 ? 'selected':''}}>June</option>
                                                                        <option value='7' {{$current_month==7 ? 'selected':''}}>July</option>
                                                                        <option value='8' {{$current_month==8 ? 'selected':''}}>August</option>
                                                                        <option value='9' {{$current_month==9 ? 'selected':''}}>September</option>
                                                                        <option value='10' {{$current_month==10 ? 'selected':''}}>October</option>
                                                                        <option value='11' {{$current_month==11 ? 'selected':''}}>November</option>
                                                                        <option value='12' {{$current_month==12 ? 'selected':''}}>December</option>
                                                                    </select>
                                                                </div>
                                                            </div><!-- invoice inline input text end -->

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->


                                                </div><!-- invoice column end -->


                                            </div><!-- invoice row end -->

                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_80"><!-- invoice column start -->

                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_12"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.code.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Account Code
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                                            <div class="invoice_col_short"><!-- invoice column short start -->
                                                                <a href="{{ route('expense_account_registration') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                                <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                    <i class="fa fa-refresh"></i>
                                                                </a>
                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="20" name="account_code" class="inputs_up form-control" id="account_code">
                                                                <option value="0">Account Code</option>
                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.account_title.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Account Title
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input"><!-- invoice column input start -->

                                                            <div class="invoice_col_short"><!-- invoice column short start -->
                                                                <a href="{{ route('expense_account_registration') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                                <a id="refresh_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                    <i class="fa fa-refresh"></i>
                                                                </a>
                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="21" name="account_name" class="inputs_up form-control" id="account_name">
                                                                <option value="0">Account Title</option>
                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Remarks
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                                            <input tabindex="22" type="text" name="account_remarks" class="inputs_up form-control" id="account_remarks" placeholder="Remarks">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.allowance_deduction.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Allow./Deduc.
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                                            <select tabindex="23" name="allowance_deduction" class="inputs_up form-control" id="allowance_deduction">
                                                                <option value="0">Select</option>
                                                                <option value="1">Allowance</option>
                                                                <option value="2">Deduction</option>
                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col hidden" hidden><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                            Taxable
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                                            <input type="checkbox" name="taxable" class="inputs_up text-right form-control" id="taxable" value="1" />
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col hidden" hidden><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                            Absent Deduction
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                                            <input type="checkbox" name="absent_deduction" class="inputs_up text-right form-control" id="absent_deduction" value="1">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.generate_salary_slip.amount.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Amount
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input"><!-- invoice column input start -->

                                                            <input tabindex="24" type="text" name="amount" class="inputs_up text-right form-control" id="amount" placeholder="Amount" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" />
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_21"><!-- invoice column start -->
                                                    <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                                        <div class="invoice_col_txt with_cntr_jstfy">
                                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                <button tabindex="30" id="first_add_more" class="invoice_frm_btn" onclick="add_account()" type="button">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </button>
                                                            </div>
                                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                <button tabindex="-1" style="display: none;" id="cancel_button" class="invoice_frm_btn" onclick="cancel_all()" type="button">
                                                                    <i class="fa fa-times"></i> Cancel
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->

                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                                    <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                                        <div class="pro_tbl_bx"><!-- product table box start -->
                                                            <table tabindex="-1" class="table table-bordered table-sm gnrl-mrgn-pdng" id="category_dynamic_table">
                                                                <thead>
                                                                <tr>
                                                                    <th tabindex="-1" class="text-center tbl_srl_9"> Code</th>
                                                                    <th tabindex="-1" class="text-center tbl_txt_20"> Title</th>
                                                                    <th tabindex="-1" class="text-center tbl_txt_48"> Transaction Remarks</th>
                                                                    <th tabindex="-1" class="text-center tbl_txt_10"> Allow./Deduc.</th>
                                                                    <th tabindex="-1" class="text-center tbl_srl_12"> Amount</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="table_body">

                                                                </tbody>
                                                            </table>
                                                        </div><!-- product table box end -->
                                                    </div><!-- product table container end -->
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->
                                        </div><!-- invoice column end -->

                                    </div><!-- invoice row end -->

                                    <div class="invoice_row"><!-- invoice row start -->

                                        <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                    Total Items
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="25" type="text" name="total_items" class="text-right inputs_up form-control total-items-field"
                                                           data-rule-required="true" data-msg-required="Enter One Item"
                                                           id="total_items" placeholder="0.00" readonly />
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                    Gross Salary
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="26" type="text" name="gross_salary" class="text-right  inputs_up form-control" id="gross_salary" placeholder="0.00" readonly />
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                    Total Allowances
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="27" type="text" name="total_allowances" class="text-right inputs_up form-control" id="total_allowances" placeholder="0.00" readonly />
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                    Total Deductions
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="28" type="text" name="total_deductions" class="text-right inputs_up form-control" id="total_deductions" placeholder="0.00" readonly />
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                    Net Salary
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="29" type="text" name="net_salary" class="text-right inputs_up form-control" id="net_salary" placeholder="0.00" readonly>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                    </div><!-- invoice row end -->

                                    <div class="invoice_row"><!-- invoice row start -->

                                        <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                            <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                    <button tabindex="31" type="submit" name="save" id="save" class="invoice_frm_btn"
                                                    >
                                                        <i class="fa fa-floppy-o"></i> Save
                                                    </button>
                                                    <span id="demo21" class="validate_sign"></span>
                                                </div>
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->


                                    </div><!-- invoice row end -->

                                </div><!-- invoice content end -->
                            </div><!-- invoice scroll box end -->


                            <input tabindex="-1" type="hidden" name="account_arrays" id="account_arrays">


                        </form>

                    </div><!-- invoice box end -->
                </div><!-- invoice container end -->




            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let employee = document.getElementById("employee"),
                basic_salary = document.getElementById("basic_salary"),
                holidays = document.getElementById("holidays"),
                total_working_days_in_months = document.getElementById("total_working_days_in_months"),
                working_hours_per_day = document.getElementById("working_hours_per_day"),
                total_items = document.getElementById("total_items"),
                validateInputIdArray = [
                    employee.id,
                    basic_salary.id,
                    holidays.id,
                    total_working_days_in_months.id,
                    working_hours_per_day.id,
                    total_items.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                $("#first_add_more").click();
                // event.preventDefault();
                return false;
            }
        });

        jQuery("#refresh_employee").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_employee",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#employee").html(" ");
                    jQuery("#employee").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        // refesh account code and name
        jQuery("#refresh_account_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_salary_slip_account_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#account_code").html(" ");
                    jQuery("#account_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_account_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_salary_slip_account_name",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#account_name").html(" ");
                    jQuery("#account_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_account_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_salary_slip_account_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#account_code").html(" ");
                    jQuery("#account_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_account_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_salary_slip_account_name",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#account_name").html(" ");
                    jQuery("#account_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });
        </script>

    <script>

        // $(".salary_month").hide();
        // $(".date_to").hide();
        // $(".date_from").hide();


        jQuery(".salary_payment_method").change(function () {

            if ($(this).is(':checked')) {

                if (this.value == 1) {
                    $(".date_to").hide();
                    $("#date_to").val('');

                    $(".date_from").show();
                    $("#date_from_label").text('Date');
                    $("#date_from").attr("placeholder", "Date");

                    $(".salary_month").hide();

                } else if (this.value == 2) {
                    $("#date_from_label").text('Date From:');
                    $("#date_from").attr("placeholder", "Date From");

                    $(".date_from").show();
                    $("#date_from").val('');

                    $(".date_to").show();
                    $("#date_to").val('');

                    $(".salary_month").hide();

                } else if (this.value == 3) {
                    $(".date_from").hide();
                    $("#date_from").val('');

                    $(".date_to").hide();
                    $("#date_to").val('');

                    $(".salary_month").show();

                    jQuery("#salary_month").select2("destroy");
                    jQuery('#salary_month option[value="' + {{$current_month}} +'"]').prop('selected', true);
                    jQuery("#salary_month").select2();
                }
            }

            total_calculation();
        });

        jQuery("#account_code").change(function () {

            var acc_name = jQuery('option:selected', this).val();

            jQuery("#account_name").select2("destroy");

            jQuery('#account_name option[value="' + acc_name + '"]').prop('selected', true);

            jQuery("#account_name").select2();
        });

        jQuery("#account_name").change(function () {
            var acc_code = jQuery('option:selected', this).val();

            jQuery("#account_code").select2("destroy");

            jQuery('#account_code option[value="' + acc_code + '"]').prop('selected', true);

            jQuery("#account_code").select2();
        });


        jQuery("#allowance_deduction").change(function () {

            var selected_value = jQuery('option:selected', this).val();

            if (selected_value == 2) {
                jQuery('#taxable').prop('checked', false);
                $("#taxable").attr("disabled", true);
            } else {
                // jQuery('#taxable').prop('checked', false);
                $("#taxable").attr("disabled", false);
            }
        });


        function total_calculation() {

            var basic_salary = $("#basic_salary").val();
            var total_working_days_in_months = $("#total_working_days_in_months").val();
            var attended_hours = $("#attended_hours").val();
            var attended_days = $("#attended_days").val();
            var working_hours_per_day = $("#working_hours_per_day").val();
            var allowance_total_amount = 0;
            var deduction_total_amount = 0;
            var gross_salary = 0;
            var net_salary;


            if (basic_salary == '') {
                basic_salary = 0;
            }

            if (total_working_days_in_months == '' || total_working_days_in_months == 0) {
                total_working_days_in_months = 1;
            }

            if (working_hours_per_day == '' || working_hours_per_day == 0) {
                working_hours_per_day = 1;
            }

            if (attended_hours == '') {
                attended_hours = 0;
            }

            var salary_payment_method = $("input[name='salary_payment_method']:checked").val();
            var salary_period = $("input[name='salary_period']:checked").val();
            var hours_or_days = $("input[name='hours_or_days']:checked").val();

            console.log(hours_or_days);

            // if (salary_payment_method == 1) {

            if (salary_period == 1) {
                gross_salary = basic_salary * attended_hours;
            } else if (salary_period == 2) {

                if (hours_or_days == 1) {
                    gross_salary = basic_salary * attended_days;
                } else {
                    gross_salary = (basic_salary / working_hours_per_day) * attended_hours;
                }
            } else {

                if (hours_or_days == 1) {
                    gross_salary = ((basic_salary / total_working_days_in_months)) * attended_days;
                } else {
                    gross_salary = ((basic_salary / total_working_days_in_months) / working_hours_per_day) * attended_hours;
                }
            }
            // }

            jQuery.each(accounts, function (index, value) {

                if (value['allowance_deduction'] == 1) {
                    allowance_total_amount = +allowance_total_amount + +value['account_amount'];
                } else if (value['allowance_deduction'] == 2) {
                    deduction_total_amount = +deduction_total_amount + +value['account_amount'];
                }
            });

            net_salary = +(allowance_total_amount - deduction_total_amount) + +gross_salary;


            jQuery("#gross_salary").val(gross_salary.toFixed(2));
            jQuery("#total_allowances").val(allowance_total_amount.toFixed(2));
            jQuery("#total_deductions").val(deduction_total_amount.toFixed(2));
            jQuery("#net_salary").val(net_salary.toFixed(2));

            // alert(basic_salary);
        }

    </script>
    <script>

        jQuery("#employee").change(function () {
            var employee_id = jQuery('option:selected', this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "{{ route('get_salary_details') }}",
                data: {id: employee_id},
                type: "post",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    jQuery("#table_body").html("");
                    numberofaccounts == 0;
                    accounts = {};

                    $("#account_code option").prop('disabled', false);
                    $("#account_name option").prop('disabled', false);

                    if (data.length > 0) {

                        if (Object.keys(data[0]).length > 0) {
                            $("#basic_salary").val(data[0]['si_basic_salary']);

                            $('input[name=salary_period][value=' + data[0]["si_basic_salary_period"] + ']').prop("checked", true);

                            // $('.salary_period:checked').val(data[0]['si_basic_salary_period']);
                        }

                        if (Object.keys(data[1]).length > 0) {

                            $.each(data[1], function (index, value) {

                                if (global_id_to_edit != 0) {
                                    jQuery("#" + global_id_to_edit).remove();

                                    delete accounts[global_id_to_edit];
                                }
                                counter++;

                                jQuery("#account_code").select2("destroy");
                                jQuery("#account_name").select2("destroy");

                                var account_code = value['sadi_account_uid'];
                                var allowance_deduction = value['sadi_allowance_deduction'];
                                var tax_status = value['sadi_taxable'];
                                var amount = value['sadi_amount'];
                                var absent_deduction_status = value['sadi_absent_deduction'];
                                var account_remarks = '';
                                var tax = '';
                                var absent_deduction = '';

                                jQuery('#account_name option[value="' + account_code + '"]').prop('selected', true);

                                jQuery('#allowance_deduction option[value="' + allowance_deduction + '"]').prop('selected', true);


                                var account_name_text = jQuery("#account_name option:selected").text();
                                var allowance_deduction_text = jQuery("#allowance_deduction option:selected").text();

                                numberofaccounts = Object.keys(accounts).length;

                                if (numberofaccounts == 0) {
                                    jQuery("#table_body").html("");
                                }


                                if (tax_status == 1) {
                                    tax = 'Taxable';
                                } else {
                                    tax = 'Non-Taxable';
                                }

                                if (absent_deduction_status == 1) {
                                    absent_deduction = 'Deduct';
                                } else {
                                    absent_deduction = 'Non-Deduct';
                                }

                                accounts[counter] = {
                                    'account_code': account_code,
                                    'account_name': account_name_text,
                                    'allowance_deduction': allowance_deduction,
                                    'tax_status': tax_status,
                                    'account_amount': amount,
                                    'absent_deduction_status': absent_deduction_status,
                                    'account_remarks': account_remarks,
                                };

                                jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");
                                jQuery("#account_name option[value=" + account_code + "]").attr("disabled", "true");

                                numberofaccounts = Object.keys(accounts).length;
                                var remarks_var = '';
                                if (account_remarks != '') {
                                    var remarks_var = '' + selected_remarks + '';
                                }

                                jQuery("#table_body").append('<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + account_code + '</td><td class="text-left tbl_txt_20">' + account_name_text + '</td><td class="text-left tbl_txt_48">' + remarks_var + '</td><td class="text-left tbl_txt_10">' + allowance_deduction_text + '</td><td class="text-left tbl_txt_20" hidden>' + tax + '</td><td class="text-left tbl_txt_20" hidden>' + absent_deduction + '</td><td class="text-right tbl_srl_12">' + amount + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_account(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');


                                jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
                                jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
                                jQuery('#allowance_deduction option[value="' + 0 + '"]').prop('selected', true);


                                total_calculation();

                                jQuery("#account_code").select2();
                                jQuery("#account_name").select2();

                                jQuery("#account_arrays").val(JSON.stringify(accounts));

                                jQuery("#total_items").val(numberofaccounts);

                            });
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>



    <script>
        // adding packs into table
        var numberofaccounts = 0;
        var counter = 0;
        var accounts = {};
        var global_id_to_edit = 0;
        var edit_account_value = '';


        function popvalidation() {
            var employee = $("#employee").val();
            var basic_salary = $("#basic_salary").val();
            var salary_period = $("input[name='salary_period']:checked").val();
            var total_working_days_in_months = $("#total_working_days_in_months").val();
            var working_hours_per_day = $("#working_hours_per_day").val();
            var hours_or_days = $("input[name='hours_or_days']:checked").val();
            var attended_days = $("#attended_days").val();
            var attended_hours = $("#attended_hours").val();
            var salary_payment_method = $("#salary_payment_method").val();
            var date_from = $("#date_from").val();
            var date_to = $("#date_to").val();
            var salary_month = $("#salary_month").val();


            var flag_submit = true;
            var focus_once = 0;

            if (employee.trim() == "0") {
                if (focus_once == 0) {
                    jQuery("#employee").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            if (basic_salary.trim() == "0" || basic_salary.trim() == "") {
                if (focus_once == 0) {
                    jQuery("#basic_salary").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            if (total_working_days_in_months.trim() == "0" || total_working_days_in_months.trim() == "") {
                if (focus_once == 0) {
                    jQuery("#total_working_days_in_months").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            if (working_hours_per_day.trim() == "0" || working_hours_per_day.trim() == "") {
                if (focus_once == 0) {
                    jQuery("#working_hours_per_day").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            if (hours_or_days == 1) {
                if (attended_days.trim() == "0" || attended_days.trim() == "") {
                    if (focus_once == 0) {
                        jQuery("#attended_days").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            } else {
                if (attended_hours.trim() == "0" || attended_hours.trim() == "") {
                    if (focus_once == 0) {
                        jQuery("#attended_hours").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            }

            if (salary_payment_method == 1) {
                if (date_from.trim() == "") {
                    if (focus_once == 0) {
                        jQuery("#date_from").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            } else if (salary_payment_method == 2) {
                if (date_from.trim() == "") {
                    if (focus_once == 0) {
                        jQuery("#date_from").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (date_to.trim() == "") {
                    if (focus_once == 0) {
                        jQuery("#date_to").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            } else {
                if (salary_month.trim() == "") {
                    if (focus_once == 0) {
                        jQuery("#salary_month").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            }
            return flag_submit;
        }

        function add_account() {

            var account_code = $("#account_code").val();
            var account_name = $("#account_name").val();
            var account_name_text = jQuery("#account_name option:selected").text();
            var allowance_deduction = $("#allowance_deduction").val();
            var allowance_deduction_text = jQuery("#allowance_deduction option:selected").text();
            var amount = $("#amount").val();
            var account_remarks = $("#account_remarks").val();
            var tax_status = 0;
            var tax = '';
            var absent_deduction_status = 0;
            var absent_deduction = '';

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (account_code == "0") {

                if (focus_once1 == 0) {
                    jQuery("#account_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (account_name == "0") {

                if (focus_once1 == 0) {
                    jQuery("#account_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (allowance_deduction == "0") {

                if (focus_once1 == 0) {
                    jQuery("#allowance_deduction").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (amount == "" || amount == '0') {

                if (focus_once1 == 0) {
                    jQuery("#amount").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete accounts[global_id_to_edit];
                }

                counter++;

                jQuery("#account_code").select2("destroy");
                jQuery("#account_name").select2("destroy");
                jQuery("#allowance_deduction").select2("destroy");

                numberofaccounts = Object.keys(accounts).length;

                if (numberofaccounts == 0) {
                    jQuery("#table_body").html("");
                }


                if ($('#taxable').prop("checked") == true) {
                    tax = 'Taxable';
                    tax_status = 1;

                } else {
                    tax = 'Non-Taxable';
                }


                if ($('#absent_deduction').prop("checked") == true) {
                    absent_deduction = 'Deduct';
                    absent_deduction_status = 1;

                } else {
                    absent_deduction = 'Non-Deduct';
                }

                accounts[counter] = {
                    'account_code': account_code,
                    'account_name': account_name_text,
                    'allowance_deduction': allowance_deduction,
                    'tax_status': tax_status,
                    'account_amount': amount,
                    'absent_deduction_status': absent_deduction_status,
                    'account_remarks': account_remarks,
                };

                jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");
                jQuery("#account_name option[value=" + account_code + "]").attr("disabled", "true");
                numberofaccounts = Object.keys(accounts).length;


                var remarks_var = '';
                if (account_remarks != '') {
                    var remarks_var = '' + account_remarks + '';
                }

                jQuery("#table_body").append('<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + account_code + '</td><td class="text-left tbl_txt_20">' + account_name_text + '</td><td class="text-left tbl_txt_48">' + remarks_var + '</td><td class="text-left tbl_txt_10">' + allowance_deduction_text + '</td><td class="text-left tbl_txt_20" hidden>' + tax + '</td><td class="text-left tbl_txt_20" hidden>' + absent_deduction + '</td><td class="text-right tbl_srl_12">' + amount + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_account(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#allowance_deduction option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#amount").val("");
                jQuery("#account_remarks").val("");
                jQuery('#taxable').prop('checked', false);
                jQuery('#absent_deduction').prop('checked', false);

                $("#taxable").attr("disabled", false);

                jQuery("#total_items").val(numberofaccounts);
                jQuery("#account_arrays").val(JSON.stringify(accounts));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');


                total_calculation();

                jQuery("#account_code").select2();
                jQuery("#account_name").select2();
                jQuery("#allowance_deduction").select2();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }

        function delete_account(current_item) {
            jQuery("#" + current_item).remove();
            var temp_accounts = accounts[current_item];
            jQuery("#account_code option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);
            jQuery("#account_name option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);

            delete accounts[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#account_arrays").val(JSON.stringify(accounts));

            if (isEmpty(accounts)) {
                numberofaccounts = 0;
            }


            total_calculation();

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
        }


        function edit_account(current_item) {
            // jQuery(".table-responsive").attr("style", "display:none");
            jQuery("#" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_accounts = accounts[current_item];

            edit_account_value = temp_accounts['account_code'];

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");
            jQuery("#allowance_deduction").select2("destroy");

            jQuery("#account_code option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);
            jQuery("#account_name option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);

            jQuery('#account_code option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);
            jQuery('#account_name option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);

            jQuery('#allowance_deduction option[value="' + temp_accounts['allowance_deduction'] + '"]').prop('selected', true);

            var tax_status = temp_accounts['tax_status'];

            if (tax_status == 1) {
                jQuery('#taxable').prop('checked', true);
            }

            var absent_deduction_status = temp_accounts['absent_deduction_status'];

            if (absent_deduction_status == 1) {
                jQuery('#absent_deduction').prop('checked', true);
            }

            jQuery("#amount").val(temp_accounts['account_amount']);
            jQuery("#account_remarks").val(temp_accounts['account_remarks']);


            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#allowance_deduction").select2();

            $("#allowance_deduction").trigger("change");

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {
            // var newvaltohide = jQuery("#account_code").val();
            var newvaltohide = edit_account_value;

            jQuery("#account_code option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery("#account_name option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#allowance_deduction option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");
            jQuery("#allowance_deduction").select2("destroy");

            jQuery('#taxable').prop('checked', false);
            $("#taxable").attr("disabled", false);
            jQuery('#absent_deduction').prop('checked', false);

            jQuery("#account_remarks").val("");
            jQuery("#amount").val("");

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#allowance_deduction").select2();

            jQuery("#cancel_button").hide();

            // jQuery(".table-responsive").show();
            jQuery("#" + global_id_to_edit).show();

            jQuery("#save").show();

            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');
            global_id_to_edit = 0;

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            edit_account_value = '';
        }
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account_code").append("{!! $account_code !!}");
            jQuery("#account_name").append("{!! $account_name !!}");

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#employee").select2();
            jQuery("#allowance_deduction").select2();
            jQuery("#salary_month").select2();
            jQuery("#salary_period").select2();
            jQuery("#holidays").select2();


            $(".salary_payment_method").trigger("change");
        });
    </script>

@endsection

