@extends('extend_index')

@section('content')

    <div class="row"><!-- main row -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><!-- main div -->
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage"><!-- white Column div -->
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Delivery Options</h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{route('delivery_option_list') }}" role="button">
                                <l class="fa fa-list"></l>
                                view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

{{--                <form name="f1" class="f1" id="f1" action="{{route('submit_delivery_option') }}" method="post" onsubmit="return checkForm()">--}}
                <form name="f1" class="f1" id="f1" action="{{route('submit_delivery_option') }}" method="post">
                @csrf

                <!--------------Main Fields Delivery Option----------------->

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">


                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <!-- invoice column start -->
                                    <div class="input_bx">
                                        <label class="">
                                            Select Invoice Type
                                        </label><!-- invoice column box start -->

                                        <div class="invoice_col_txt inline_radio"><!-- invoice column input start -->

                                            <div class="custom-control custom-radio mb-2 mt-2">
                                                <input type="radio" id="non_tax" name="invoice_select"
                                                       value="non_tax_inv" class="custom-control-input" checked>
                                                <label class="custom-control-label bold" for="non_tax">Non Tax</label>
                                            </div>
                                            <div class="custom-control custom-radio mb-2 mt-2">
                                                <input type="radio" id="tax" name="invoice_select"
                                                       value="tax_inv" class="custom-control-input">
                                                <label class="custom-control-label bold" for="tax">Tax
                                                    Invoice</label>
                                            </div>

                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div id="non_tax_inv"
                                     class="invoice_box form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <!-- invoice column start -->
                                    <div class="input_bx"><!-- invoice column box start -->
                                        <label class="required">
                                            Invoice No
                                        </label>

                                        <select name="non_tax_invoice" class="inputs_up form-control" data-rule-required="true"
                                                data-msg-required="Please Enter Non Tax Invoice No."
                                                id="non_tax_invoice">
                                            <option value="" disabled selected> Select Non Tax Invoice</option>
                                            @foreach($non_tax_invoices as $non_tax_invoice)
                                                <option value="{{$non_tax_invoice->si_id}}">
                                                    {{$non_tax_invoice->si_id}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- invoice column end -->

                                <div id="tax_inv"
                                     class="invoice_box hide form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <!-- invoice column start -->
                                    <div class="input_bx"><!-- invoice column box start -->
                                        <label class="required">
                                            Invoice No
                                        </label>
                                        <select name="tax_invoice" class="inputs_up form-control" id="tax_invoice" data-rule-required="true"
                                                data-msg-required="Please Enter Tax Invoice No">
                                            <option value="" disabled selected> Select Tax Invoice</option>
                                            @foreach($tax_invoices as $tax_invoice)
                                                <option value="{{$tax_invoice->ssi_id}}">
                                                    {{$tax_invoice->ssi_id}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- invoice column end -->

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" hidden>
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Selected Invoice
                                        </label>
                                        <input type="hidden" name="selected_invoice"
                                               id="selected_invoice" class="inputs_up form-control" placeholder=" Selected Invoice"/>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" hidden>
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Party Code
                                        </label>
                                        <input type="hidden" name="party_code" readonly

                                               id="party_code" class="inputs_up form-control" placeholder="Party Code"/>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Party Name
                                        </label>
                                        <input type="text" name="party_name" readonly

                                               id="party_name" class="inputs_up form-control" placeholder="Party Name"/>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                           Invoice Date
                                        </label>
                                        <input type="text" name="invoice_date"
                                               id="invoice_date" data-rule-required="true"
                                               data-msg-required="Please Enter Collection Date"
                                               class="inputs_up form-control datepicker2 delivery_date"
                                               placeholder="Invoice Date"/>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Order No
                                        </label>
                                        <input type="text" name="order_no"
                                               id="order_no" class="inputs_up form-control" placeholder="Order No"/>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            D.O No.
                                        </label>
                                        <input type="text" name="delivery_order_no"
                                               id="delivery_order_no" class="inputs_up form-control"
                                               placeholder="Delivery Order No."/>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Gate pass
                                        </label>
                                        <input type="text" name="gate_pass"
                                               id="gate_pass" class="inputs_up form-control"
                                               placeholder="Gate Pass No."/>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Collection Date/Time
                                        </label>
                                        <input type="text" name="collection_datetime"
                                               id="collection_datetime"
                                               class="inputs_up form-control datetimepicker"
                                               placeholder="Collection Date/Time" data-rule-required="true"
                                               data-msg-required="Please Enter Date/Time">
                                        <span id="demo2" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Remarks</label>
                                        <textarea name="remarks" id="remarks"
                                                  class="inputs_up remarks "
                                                  placeholder="Remarks">{{ old('remarks') }}</textarea>
                                        <span id="demo2" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>
                        </div>
                    </div>

                    <!---------------Main Fields Delivery Option----------------->


                    <!------------------------Radio Buttons--------------------->

                    <div class="row form-group col-lg-12 col-md-12 col-sm-12">
                        <div class="input_bx"><!-- start input box -->
                            <div class="custom-control custom-radio mb-2 mt-2">
                                <input type="radio" id="self_collection" name="delivery_option" value="self_collection"
                                       class="custom-control-input" checked>
                                <label class="custom-control-label bold" for="self_collection">Self Collection</label>
                            </div>
                            <div class="custom-control custom-radio mb-2 mt-2">
                                <input type="radio" id="company_delivery" name="delivery_option"
                                       value="company_delivery" class="custom-control-input">
                                <label class="custom-control-label bold" for="company_delivery">Company Delivery</label>
                            </div>
                            <div class="custom-control custom-radio mb-2 mt-2">
                                <input type="radio" id="courier_service" name="delivery_option" value="courier_service"
                                       class="custom-control-input">
                                <label class="custom-control-label bold" for="courier_service">Courier Service</label>
                            </div>
                            <div class="custom-control custom-radio mb-2 mt-2">
                                <input type="radio" id="third_party" name="delivery_option" value="third_party"
                                       class="custom-control-input">
                                <label class="custom-control-label bold" for="third_party">Third Party</label>
                            </div>
                        </div><!-- end input box -->
                    </div>

                    <!------------------------Radio Buttons--------------------->

                    <div class="tab-content">
                        <!------------------------Self Collection--------------------->

                        <div class="tab-pane show fade active" id="self_collections" style="display: none"
                             role="tabpanel">
                            <div class="pd-10">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">

                                            <div class="form-group col-lg-2 col-md-2 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        Name
                                                    </label>
                                                    <input type="text" name="name" id="name"
                                                           class="inputs_up form-control"
                                                           placeholder="Name" autofocus
                                                           data-rule-required="true"
                                                           data-msg-required="Please Enter Name"
                                                           autocomplete="off"
                                                           value="{{ old('name') }}"/>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-2 col-md-2 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        CNIC

                                                    </label>
                                                    <input type="text" name="cnic" id="cnic"
                                                           class="inputs_up form-control"
                                                           placeholder="CNIC" autofocus
                                                           data-rule-required="true"
                                                           data-msg-required="Please Enter CNIC No"
                                                           autocomplete="off"
                                                           value="{{ old('cnic') }}"/>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-2 col-md-2 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        Mobile No
                                                    </label>
                                                    <input type="text" name="mobile" id="mobile"
                                                           class="inputs_up form-control"
                                                           placeholder="Mobile No" autofocus
                                                           data-rule-required="true"
                                                           data-msg-required="Please Enter Mobile No"
                                                           autocomplete="off"
                                                           value="{{ old('mobile') }}"/>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        Remarks</label>
                                                    <textarea name="remarks" id="self_collection_remarks"
                                                              class="inputs_up self_collection_remarks "
                                                              placeholder="Remarks">{{ old('self_collection_remarks') }}</textarea>
                                                    <span id="demo2" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-----------x-------------Self Collection-----------x---------->

                        <!------------------------Company Delivery--------------------->

                        <div class="tab-pane fade show" id="company_deliveries" style="display: none" role="tabpanel">
                            <div class="pd-10">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">

                                            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        Employee
                                                    </label>
                                                    <select name="employee" class="inputs_up form-control"
                                                            id="employee">
                                                        <option value="" selected disabled>Select Employee</option>
                                                        @foreach($employees as $employee)
                                                            <option
                                                                value="{{$employee->user_id}}">{{$employee->user_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        Remarks</label>
                                                    <textarea name="company_delivery_remarks" id="company_delivery_remarks"
                                                              class="inputs_up remarks "
                                                              placeholder="Remarks">{{ old('company_delivery_remarks') }}</textarea>
                                                    <span id="demo2" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-----------x-------------Company Delivery-----------x---------->

                        <!------------------------Courier Service--------------------->

                        <div class="tab-pane show fade" id="courier_services" style="display: none" role="tabpanel">
                            <div class="pd-10">
                                <div class="row">

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            <a href="{{ route('add_courier') }}" class="add_btn"
                                                               target="_blank" data-container="body"
                                                               data-toggle="popover" data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <l class="fa fa-plus"></l>
                                                                Add
                                                            </a>
                                                            <a class="add_btn" id="refresh_courier"
                                                               data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                            Courier Name
                                                        </label>
                                                        <select name="courier" class="inputs_up form-control"
                                                                id="courier" data-rule-required="true"
                                                                data-msg-required="Please Select courier">
                                                            <option value="">Select courier</option>
                                                            @foreach($couriers as $courier)
                                                                <option
                                                                    value="{{$courier->cc_id}}" {{ $courier->cc_id == old('courier') ? 'selected="selected"' : '' }}>{{$courier->cc_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-2 col-md-2 col-sm-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            Courier Slip No
                                                        </label>
                                                        <input type="text" name="courier_slip_no"
                                                               id="courier_slip_no"
                                                               class="inputs_up form-control"
                                                               placeholder="Courier Slip No" autofocus
                                                               data-rule-required="true"
                                                               data-msg-required="Please Enter Courier Slip No"
                                                               autocomplete="off"
                                                               value="{{ old('courier_slip_no') }}"/>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            Courier Slip Date</label>
                                                        <input type="text" name="courier_slip_date"
                                                               id="courier_slip_date" data-rule-required="true"
                                                               data-msg-required="Please Enter Courier Slip Date"
                                                               class="inputs_up form-control datepicker2 delivery_date"
                                                               placeholder="Courier Slip Date"/>
                                                        <span id="demo4" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            Booking City
                                                        </label>
                                                        <select name="booking_city"
                                                                class="inputs_up form-control" id="booking_city"
                                                                data-rule-required="true"
                                                                data-msg-required="Please Select Booking city">
                                                            <option value="">Select Booking City</option>

                                                        </select>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            Destination City
                                                        </label>
                                                        <select name="destination_city"
                                                                class="inputs_up form-control"
                                                                id="destination_city" data-rule-required="true"
                                                                data-msg-required="Please Select Destination city">
                                                            <option value="">Select Destination City</option>

                                                        </select>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="">
                                                            Remarks</label>
                                                        <textarea name="courier_service_remarks" id="courier_service_remarks"
                                                                  class="inputs_up remarks "
                                                                  placeholder="Remarks">{{ old('courier_service_remarks') }}</textarea>
                                                        <span id="demo2" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-----------x-------------Courier Service-----------x---------->

                        <!------------------------Third Party--------------------->

                        <div class="tab-pane show fade" id="third_parties" style="display: none" role="tabpanel">
                            <div class="pd-10">
                                <div class="row">

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">

                                                <div class="form-group col-lg-2 col-md-2 col-sm-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            Vehical No

                                                        </label>
                                                        <input type="text" name="vehicle_no" id="vehicle_no"
                                                               class="inputs_up form-control"
                                                               placeholder="Vehicle No" autofocus
                                                               data-rule-required="true"
                                                               data-msg-required="Please Enter Vehicle No"
                                                               autocomplete="off"
                                                               value="{{ old('vehicle_no') }}"/>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-2 col-md-2 col-sm-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            Vehical Type

                                                        </label>
                                                        <input type="text" name="vehicle_type" id="vehicle_type"
                                                               class="inputs_up form-control"
                                                               placeholder="Vehicle Type" autofocus
                                                               data-rule-required="true"
                                                               data-msg-required="Please Enter Vehicle Type"
                                                               autocomplete="off"
                                                               value="{{ old('vehicle_type') }}"/>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-2 col-md-2 col-sm-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            Driver Name

                                                        </label>
                                                        <input type="text" name="driver_name" id="driver_name"
                                                               class="inputs_up form-control"
                                                               placeholder="Driver Name" autofocus
                                                               data-rule-required="true"
                                                               data-msg-required="Please Enter Driver Name"
                                                               autocomplete="off"
                                                               value="{{ old('driver_name') }}"/>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>

                                                <div class="form-group col-lg-2 col-md-2 col-sm-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            Mobile No

                                                        </label>
                                                        <input type="text" name="driver_mobile" id="driver_mobile"
                                                               class="inputs_up form-control"
                                                               placeholder="Driver Mobile No" autofocus
                                                               data-rule-required="true"
                                                               data-msg-required="Please Enter Mobile No"
                                                               autocomplete="off"
                                                               value="{{ old('dri_mobile') }}"/>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>


                                                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="">
                                                            <a
                                                                data-container="body" data-toggle="popover"
                                                                data-trigger="hover"
                                                                data-placement="bottom" data-html="true"
                                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Remarks</label>
                                                        <textarea name="third_party_remarks" id="third_party_remarks"
                                                                  class="inputs_up remarks "
                                                                  placeholder="Remarks">{{ old('third_party_remarks') }}</textarea>
                                                        <span id="demo2" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>


                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-----------x-------------Third Party-----------x---------->
                    </div>

                    <!-----------x-------------Save Button-----------x---------->

                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                            <button type="reset" name="cancel" id="cancel"
                                    class="cancel_button form-control">
                                <i class="fa fa-eraser"></i> Cancel
                            </button>
                            <button type="submit" name="save" id="save"
                                    class="save_button form-control"
                            >
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                    </div>

                    <!-----------x-------------Save Button-----------x---------->

                </form>

            </div><!--white Column div ends here -->
        </div><!-- main div ends here -->
    </div><!--  main row ends here -->



@endsection

@section('scripts')

    <script>
        ///////////////Refresh Courier/////////
        jQuery("#refresh_courier").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_courier",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#courier").html(" ");
                    jQuery("#courier").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        ///////////////Refresh Courier/////////
    </script>
    {{--    required input validation --}}
    <script type="text/javascript">
        // function checkForm() {
        //     let non_tax_invoice = document.getElementById("non_tax_invoice"),
        //         // tax_invoice = document.getElementById("tax_invoice"),
        //         invoice_date = document.getElementById("invoice_date"),
        //         collection_datetime = document.getElementById("collection_datetime"),
        //         name = document.getElementById("name"),
        //         cnic = document.getElementById("cnic"),
        //         mobile = document.getElementById("mobile"),
        //         // courier = document.getElementById("courier"),
        //         // courier_slip_no = document.getElementById("courier_slip_no"),
        //         // courier_slip_date = document.getElementById("courier_slip_date"),
        //         // booking_city = document.getElementById("booking_city"),
        //         // destination_city = document.getElementById("destination_city"),
        //         // vehicle_no = document.getElementById("vehicle_no"),
        //         // vehicle_type = document.getElementById("vehicle_type"),
        //         // driver_name = document.getElementById("driver_name"),
        //         // driver_mobile = document.getElementById("driver_mobile"),
        //         validateInputIdArray = [
        //             non_tax_invoice.id,
        //             // tax_invoice.id,
        //             invoice_date.id,
        //             collection_datetime.id,
        //             name.id,
        //             cnic.id,
        //             mobile.id,
        //             // courier.id,
        //             // courier_slip_no.id,
        //             // courier_slip_date.id,
        //             // booking_city.id,
        //             // destination_city.id,
        //             // vehicle_no.id,
        //             // vehicle_type.id,
        //             // driver_name.id,
        //             // driver_mobile.id,
        //         ];
        //     return validateInventoryInputs(validateInputIdArray);
        // }
    </script>
    {{-- end of required input validation --}}
    <script>
        jQuery("#courier").change(function () {

            var dropDown = document.getElementById('courier');
            var cc_id = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_courier_city",
                data: {cc_id: cc_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    jQuery("#booking_city").html(" ");
                    jQuery("#booking_city").append(data);
                    jQuery("#destination_city").html(" ");
                    jQuery("#destination_city").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>


    <script type="text/javascript">

        ///////////////Radio Button/////////

        $(document).ready(function () {
            $('#self_collections').css('display', 'block');
            $('#company_deliveries').css('display', 'none');
            $('#courier_services').css('display', 'none');
            $('#third_parties').css('display', 'none');

            $("input[name='invoice_select']").change(function () {
                let get_invoice = $(this).val();
                $(".invoice_box").addClass('hide');
                $("#" + get_invoice).toggleClass('hide');
                $('#party_code').val('');
                $('#party_name').val('');
                $('#selected_invoice').val('');
                // $('#non_tax_invoice').val('');

                jQuery('#non_tax_invoice option[value="' + '' + '"]').prop('selected', true);
                jQuery("#non_tax_invoice").select2("destroy");
                jQuery("#non_tax_invoice").select2();

                jQuery('#tax_invoice option[value="' + '' + '"]').prop('selected', true);
                jQuery("#tax_invoice").select2("destroy");
                jQuery("#tax_invoice").select2();
            });
        });

        $('#self_collection').click(function () {

            $('#self_collections').css('display', 'block');
            $('#company_deliveries').css('display', 'none');
            $('#courier_services').css('display', 'none');
            $('#third_parties').css('display', 'none');
        });

        $('#company_delivery').click(function () {
            $('#self_collections').css('display', 'none');
            $('#company_deliveries').css('display', 'block');
            $('#courier_services').css('display', 'none');
            $('#third_parties').css('display', 'none');
        });

        $('#courier_service').click(function () {
            $('#self_collections').css('display', 'none');
            $('#company_deliveries').css('display', 'none');
            $('#courier_services').css('display', 'block');
            $('#third_parties').css('display', 'none');
        });

        $('#third_party').click(function () {
            $('#self_collections').css('display', 'none');
            $('#company_deliveries').css('display', 'none');
            $('#courier_services').css('display', 'none');
            $('#third_parties').css('display', 'block');
        });

        ///////////////Radio Button/////////

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        //////////   Select2  ///////////////

        jQuery("#employee").select2();
        jQuery("#courier").select2();
        jQuery("#booking_city").select2();
        jQuery("#destination_city").select2();
        jQuery("#non_tax_invoice").select2();
        jQuery("#tax_invoice").select2();

        //////////////  Select2 ////////////

        //////////////  Date Format ////////////

        jQuery(document).ready(function () {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

            $('.delivery_date').datepicker({
                minDate: today,
                language: 'en', dateFormat: 'dd-M-yyyy'
            });
        });

        //////////////  Date Format ////////////

        // //////////////  Select PartyCode and Party Name  ////////////

        $("#non_tax_invoice").change(function () {
            var non_tax_invoice = $(this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('non_tax_invoice_party') }}',
                data: {
                    'non_tax_invoice': non_tax_invoice,

                },
                cache: false,
                dataType: 'json',
                success: function (data) {

                    $.each(data.non_tax_party, function (key, value) {
                    $('#party_code').val(value.si_party_code);
                    $('#party_name').val(value.si_party_name);

                    });

                }
            });
        });

        $("#tax_invoice").change(function () {
            var tax_invoice = $(this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('tax_invoice_party') }}',
                data: {
                    'tax_invoice': tax_invoice,

                },
                cache: false,
                dataType: 'json',
                success: function (data) {

                    $.each(data.tax_party, function (key, value) {
                    $('#party_code').val(value.ssi_party_code);
                    $('#party_name').val(value.ssi_party_name);

                    });

                }
            });
        });

        // //////////////  Select PartyCode and Party Name  ////////////

        // //////////////  Selected Invoice  ////////////

        $('#non_tax_invoice').change(function () {
            $('#selected_invoice').val('');
                var val = $(this).val();
            $('#selected_invoice').val(val);
        });

        $('#tax_invoice').change(function () {
            $('#selected_invoice').val('');
                var val = $(this).val();
            $('#selected_invoice').val(val);
        });

        // //////////////  Selected Invoice  ////////////

    </script>

@endsection


