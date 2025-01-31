@extends('extend_index')

@section('styles_get')
    {{--        nabeel added css blue--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">
@stop

@section('content')

    <style>


        .datepicker--cell.-current- {
            color: #fff;
            background: #6C79E0;
        }


        #add_transfer_product_stock_pattern_excel {
            padding: 10px 10px 10px 10px;
        }


        .input_bx {
            background: none;
        }

        .inputs_up {
            height: auto;
        }

        .add_btn, .refresh_btn, .form_header .list_btn .add_btn {
            background-color: #ffffff;
            color: #000000;
            font-weight: bold;
            border-style: solid;
        }


        .add_btn, .refresh_btn, .form_header .list_btn .add_btn {
            background-color: #4A4B5C;
            color: #fff;
        }

        .excel_con .excel_box:after {
            background-color: transparent;
        }


        .border {
            border: 2px solid white !important;
        }

        .inputs_up:focus {
            box-shadow: 0 0 3pt 2pt #fc7307;
        }


    </style>

    <div class="row"><!-- main row -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><!-- main div -->
            <div id="main_bg" class="pd-20 border-radius-4 box-shadow mb-30 form_manage" style="background: #C4D3F5">             <!-- white Column div -->
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Stock Outward</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <a class="mr-3 btn list_link add_more_button" href="{{route('stock_outward_list') }}"
                               role="button">
                                <l class="fa fa-list"></l>
                                view list
                            </a>

                            <a class="btn list_link add_more_button" href="{{route('stock_outward_detail_list') }}"
                               role="button">
                                <l class="fa fa-list"></l>
                                view detail list
                            </a>

                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{route('submit_stock_outward') }}" method="post"
                      onsubmit="return checkForm()" style="background: #C4D3F5">
                @csrf

                <!--------------Main Fields Delivery Option----------------->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <!-- invoice column start -->
                                    <div class="input_bx">
                                        <label class="ml-2">
                                            Select Invoice Type
                                        </label><!-- invoice column box start -->

                                        <div class="input_bx border rounded ml-2">

                                            <div class="invoice_col_txt inline_radio"><!-- invoice column input start -->

                                                <div class="custom-control custom-radio mb-0 mt-1">
                                                    <input type="radio" id="so" name="invoice_select"
                                                           value="so_inv" class="custom-control-input" checked>
                                                    <label class="custom-control-label bold" for="so">Sale Order</label>
                                                </div>

                                                <div class="custom-control custom-radio mb-0 mt-1">
                                                    <input type="radio" id="do" name="invoice_select"
                                                           value="do_inv" class="custom-control-input">
                                                    <label class="custom-control-label bold" for="do">Delivery Order</label>
                                                </div>

                                                <div class="custom-control custom-radio mb-0 mt-1">
                                                    <input type="radio" id="non_tax" name="invoice_select"
                                                           value="non_tax_inv" class="custom-control-input">
                                                    <label class="custom-control-label bold" for="non_tax">Sale Non Tax</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-0 mt-1">
                                                    <input type="radio" id="tax" name="invoice_select"
                                                           value="tax_inv" class="custom-control-input">
                                                    <label class="custom-control-label bold" for="tax">Sale Tax
                                                        Invoice</label>
                                                </div>


                                            </div>


                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->


                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Party Name
                                        </label>
                                        <select required tabindex="1" autofocus name="party_name"
                                                class="inputs_up form-control js-example-basic-multiple"
                                                data-rule-required="true" data-msg-required="Please Choose Party Name"
                                                id="party_name">
                                            <option value="0" selected disabled>Select Party</option>
                                            @foreach($accounts as $account)
                                                <option
                                                    value="{{$account->account_uid}}">{{$account->account_name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end inpGut box -->
                                </div>


                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Invoice No
                                        </label>
                                        <select tabindex="2" name="invoice_no"
                                                class="inputs_up form-control js-example-basic-multiple"
                                                id="invoice_no" data-rule-required="true" data-msg-required="Please Choose Invoice">
                                            <option value="0" selected disabled>Select Invoice</option>
                                        </select>

                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Total Qty on Builty
                                        </label>
{{--                                        Hamad set tab index--}}
                                        <input tabindex="4" type="text" name="builty_qty"
                                               id="builty_qty" class="inputs_up form-control"
                                               autocomplete="off"
                                               placeholder="Quantity"/>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div hidden class="form-group col-lg-2 col-md-2 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Sending Date & Time </label>
                                        <input type="text" name="sending_datetime"
                                               id="sending_datetime"
                                               autocomplete="off"
                                               class="inputs_up form-control datetimepicker"
                                               placeholder="Date/Time" data-rule-required="true"
                                               data-msg-required="Please Enter Date/Time" aria-autocomplete="false">
                                        <span id="demo2" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Remarks</label>
{{--                                        Hamad set tab index--}}
                                        <textarea tabindex="4" name="remarks" id="remarks" style="height: 35px;"
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
                        <div class="input_bx border rounded ml-2"><!-- start input box -->
                            <div class="custom-control custom-radio mb-2 mt-2">
                                <input type="radio" id="self_collection" name="delivery_option" value="self_collection"
                                       class="custom-control-input" checked>
                                <label class="custom-control-label bold" for="self_collection">Client Collection</label>
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
{{--                                                    Hamad set tab index--}}
                                                    <input type="text" tabindex="5" name="name" id="name"
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
                                                        Mobile No
                                                    </label>
{{--                                                    Hamad set tab index--}}
                                                    <input type="text" tabindex="6" name="mobile" id="mobile"
                                                           class="inputs_up form-control"
                                                           placeholder="03xx-xxxxxxx" autofocus
                                                           data-rule-required="true"
                                                           pattern="^((0))3\d{2}-?\d{7}$"
                                                           onkeypress="numberFormatter(event)"
                                                           data-msg-required="Please Enter Mobile No"
                                                           autocomplete="off"
                                                           value="{{ old('mobile') }}"/>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-2 col-md-2 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        CNIC

                                                    </label>
{{--                                                    Hamad set tab index--}}
                                                    <input type="text" tabindex="7" name="cnic" id="cnic"
                                                           class="inputs_up form-control"
                                                           placeholder="CNIC" autofocus
                                                           data-rule-required="true"
                                                           onkeypress="cnicFormatter(event)"
                                                           data-msg-required="Please Enter CNIC No"
                                                           autocomplete="off"
                                                           value="{{ old('cnic') }}"/>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-2 col-md-3 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        Remarks</label>
{{--                                                    Hamad set tab index--}}
                                                    <textarea tabindex="8" name="self_collection_remarks"
                                                              id="self_collection_remarks" style="height: 35px;"
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
                                                            id="employee" data-rule-required="true"
                                                            data-msg-required="Please Enter Employee">
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
                                                    <textarea name="company_delivery_remarks"
                                                              id="company_delivery_remarks"
                                                              class="inputs_up remarks " style="height: 35px;"
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

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">

                                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
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
                                                           autocomplete="off"
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
                                                              class="inputs_up remarks" style="height: 35px;"
                                                              placeholder="Remarks">{{ old('courier_service_remarks') }}</textarea>
                                                    <span id="demo2" class="validate_sign"> </span>
                                                </div><!-- end input box -->
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
                                                               placeholder="03xx-xxxxxxx" autofocus
                                                               data-rule-required="true"
                                                               pattern="^((0))3\d{2}-?\d{7}$"
                                                               onkeypress="numberFormatter(event)"
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
                                                                  class="inputs_up remarks " style="height: 35px;"
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
                        <div class="col-lg-12 col-md-12 col-sm-12 invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk form_controls">
{{--                            Hamad set tab index--}}
                            <button tabindex="9" type="reset" name="cancel" id="cancel" class="invoice_frm_btn btn btn-sm btn-secondary">
                                {{--                                        <i class="fa fa-eraser"></i>--}}
                                Cancel
                            </button>
{{--                            Hamad set tab index--}}
                            <button type="submit" tabindex="10" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
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
        function checkForm() {
            let party_name = document.getElementById("party_name"),
                invoice_no = document.getElementById("invoice_no"),
                // sending_datetime = document.getElementById("sending_datetime"),

                validateInputIdArray = [
                    party_name.id,
                    invoice_no.id,
                    // sending_datetime.id,

                ];

            var check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {

                var voucher_type = $("input[name='delivery_option']:checked").val();

                if (voucher_type == 'self_collection') {
                    let name = document.getElementById("name"),
                        // cnic = document.getElementById("cnic"),
                        mobile = document.getElementById("mobile"),

                        validateInputIdArray = [
                            name.id,
                            // cnic.id,
                            mobile.id,
                        ];

                    return validateInventoryInputs(validateInputIdArray);

                } else if (voucher_type == 'company_delivery') {


                    let employee = document.getElementById("employee"),

                        validateInputIdArray = [
                            employee.id,
                        ];
                    return validateInventoryInputs(validateInputIdArray);

                } else if (voucher_type == 'courier_service') {

                    var name = $("#courier").val();


                    if (name == "0") {

                        // alert("other");

                        let other_courier = document.getElementById("other_courier"),
                            courier_slip_no = document.getElementById("courier_slip_no"),
                            courier_slip_date = document.getElementById("courier_slip_date"),
                            booking_city = document.getElementById("booking_city"),

                            validateInputIdArray = [
                                other_courier.id,
                                courier_slip_no.id,
                                courier_slip_date.id,
                                booking_city.id,

                            ];

                        return validateInventoryInputs(validateInputIdArray);
                    } else {

                        let courier = document.getElementById("courier"),
                            courier_slip_no = document.getElementById("courier_slip_no"),
                            courier_slip_date = document.getElementById("courier_slip_date"),
                            booking_city = document.getElementById("booking_city"),
                            destination_city = document.getElementById("destination_city"),

                            validateInputIdArray = [
                                courier.id,
                                courier_slip_no.id,
                                courier_slip_date.id,
                                booking_city.id,
                                destination_city.id,

                            ];

                        return validateInventoryInputs(validateInputIdArray);


                    }


                } else if (voucher_type == 'third_party') {
                    let vehicle_no = document.getElementById("vehicle_no"),
                        vehicle_type = document.getElementById("vehicle_type"),
                        driver_name = document.getElementById("driver_name"),
                        driver_mobile = document.getElementById("driver_mobile"),

                        validateInputIdArray = [
                            vehicle_no.id,
                            vehicle_type.id,
                            driver_name.id,
                            driver_mobile.id,

                        ];

                    return validateInventoryInputs(validateInputIdArray);

                } else {
                    let party_name = document.getElementById("party_name"),
                        sending_datetime = document.getElementById("sending_datetime"),

                        validateInputIdArray = [
                            party_name.id,
                            sending_datetime.id,
                        ];

                    return validateInventoryInputs(validateInputIdArray);

                }
            }
            return false;
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        // jQuery("#courier").change(function () {
        //
        //     // var dropDown = document.getElementById('courier');
        //     // var cc_id = dropDown.options[dropDown.selectedIndex].value;
        //
        //     var name = $("#courier").val();
        //
        //
        //     if (name == "0") {
        //         $("#display_other_courier").css("display", "block");
        //     } else {
        //         $("#display_other_courier").val("");
        //         $("#display_other_courier").css("display", "none");
        //
        //     }

        // });
    </script>
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


        // function display_other(){


        // }


        $(document).ready(function () {
            $('#self_collections').css('display', 'block');
            $('#company_deliveries').css('display', 'none');
            $('#courier_services').css('display', 'none');
            $('#third_parties').css('display', 'none');

            jQuery("#party_name").select2();
            jQuery("#invoice_no").select2();

            // $("input[name='invoice_select']").change(function () {
            //     let get_invoice = $(this).val();
            //     $(".invoice_box").addClass('hide');
            //     $("#" + get_invoice).toggleClass('hide');
            //
            //     $('#selected_invoice').val('');
            //     // $('#non_tax_invoice').val('');
            //
            //     jQuery('#non_tax_invoice option[value="' + '' + '"]').prop('selected', true);
            //     jQuery("#non_tax_invoice").select2("destroy");
            //     jQuery("#non_tax_invoice").select2();
            //
            //     jQuery('#tax_invoice option[value="' + '' + '"]').prop('selected', true);
            //     jQuery("#tax_invoice").select2("destroy");
            //     jQuery("#tax_invoice").select2();
            //
            // });
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

        $('input[name="invoice_select"]').click(function () {
            var invoice_type = $(this).val();
            var party_code = $('#party_name').val();
            get_invoice(party_code, invoice_type)
        });

        $("#party_name").change(function () {
            var party_code = $(this).val();
            var invoice_type = $('input[name="invoice_select"]:checked').val();
            get_invoice(party_code, invoice_type)
        });

        function get_invoice(party_code, invoice_type) {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('get_party_invoice') }}',
                data: {
                    'party_code': party_code, 'invoice_type': invoice_type
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    var options = '<option value="0" selected disabled>Select Invoice</option>';

                    $.each(data.invoice, function (key, value) {
                        options += '<option>' + value.id + '</option>';
                    });
                    $('#invoice_no').html('');
                    $('#invoice_no').append(options);

                }
            });

        }

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


        function cnicFormatter(event) {
            var cnic = $("#cnic").val();
            var cnic_length = cnic.length;

            // alert(cnic);
            // alert(cnic_length);

            if (cnic_length == 5) {
                $("#cnic").val(cnic + "-");
            }

            if (cnic_length == 13) {
                $("#cnic").val(cnic + "-");
            }

            if (cnic_length > 14) {
                event.preventDefault();
            }

        }


        function numberFormatter(event) {
            var Number = $("#mobile").val();
            var Number_length = Number.length;

            if (Number_length == 4) {
                $("#mobile").val(Number + "-");
            }

            var Number2 = $("#driver_mobile").val();
            var Number_length2 = Number2.length;

            if (Number_length > 11) {
                event.preventDefault();
            }

            if (Number_length2 == 4) {
                $("#driver_mobile").val(Number2 + "-");
            }


            if (Number_length2 > 11) {
                event.preventDefault();
            }

        }


    </script>

@endsection


