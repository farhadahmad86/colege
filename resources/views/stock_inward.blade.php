@extends('extend_index')

@section('styles_get')
    {{--        nabeel added css blue--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">
@stop







@section('content')


    <style>


        /*date_time*/

        .datepicker--cell.-current- {
            color: #fff;
            background: #6C79E0;
        }


        /*.datepicker--cell.-current- {*/
        /*    color: #fff;*/
        /*    background: #6C79E0;*/
        /*}*/


        #add_transfer_product_stock_pattern_excel {
            padding: 10px 10px 10px 10px;
        }


        .input_bx {
            background: none;
        }

        .inputs_up{
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
            border: 2px solid white!important;
        }

        .inputs_up:focus  {
            box-shadow: 0 0 3pt 2pt #fc7307;
        }


    </style>




    <div class="row"><!-- main row -->


        <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><!-- main div -->

            <div id="main_bg" class="pd-20 border-radius-4 box-shadow mb-30 form_manage" style="background: #C4D3F5"><!-- white Column div -->


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Stock Inward</h4>
                        </div>

                        <div class="list_btn list_mul">
                            <a class="mr-3 btn list_link add_more_button" href="{{route('stock_inward_list') }}" role="button">
                                <l class="fa fa-list"></l>
                                view list
                            </a>

                            <a class="btn list_link add_more_button" href="{{route('stock_inward_detail_list') }}" role="button">
                                <l class="fa fa-list"></l>
                                view detail list
                            </a>

                        </div><!-- list btn -->



                    </div>
                </div><!-- form header close -->

                {{--                <form name="f1" class="f1" id="f1" action="{{route('submit_stock_option') }}" method="post" onsubmit="return checkForm()">--}}
                <form name="f1" class="f1" id="f1" action="{{route('submit_stock_inward') }}" method="post" onsubmit="return checkForm()" style="background: #C4D3F5">
                @csrf

                <!--------------Main Fields Delivery Option----------------->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">


{{--                                <div hidden class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">--}}
{{--                                    <!-- invoice column start -->--}}
{{--                                    <div class="input_bx">--}}
{{--                                        <label class="">--}}
{{--                                            Select Invoice Type--}}
{{--                                        </label><!-- invoice column box start -->--}}

{{--                                        <div class="invoice_col_txt inline_radio"><!-- invoice column input start -->--}}

{{--                                            <div class="custom-control custom-radio mb-2 mt-2">--}}
{{--                                                <input type="radio" id="non_tax" name="invoice_select"--}}
{{--                                                       value="non_tax_inv" class="custom-control-input" checked>--}}
{{--                                                <label class="custom-control-label bold" for="non_tax">Non Tax</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-radio mb-2 mt-2">--}}
{{--                                                <input type="radio" id="tax" name="invoice_select"--}}
{{--                                                       value="tax_inv" class="custom-control-input">--}}
{{--                                                <label class="custom-control-label bold" for="tax">Tax--}}
{{--                                                    Invoice</label>--}}
{{--                                            </div>--}}

{{--                                        </div><!-- invoice column input end -->--}}
{{--                                    </div><!-- invoice column box end -->--}}
{{--                                </div><!-- invoice column end -->--}}

{{--                                <div hidden id="non_tax_inv"--}}
{{--                                     class="invoice_box form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">--}}
{{--                                    <!-- invoice column start -->--}}
{{--                                    <div class="input_bx"><!-- invoice column box start -->--}}
{{--                                        <label class="required">--}}
{{--                                            Invoice No--}}
{{--                                        </label>--}}

{{--                                        <select name="non_tax_invoice" class="inputs_up form-control" data-rule-required="true"--}}
{{--                                                data-msg-required="Please Enter Non Tax Invoice No."--}}
{{--                                                id="non_tax_invoice">--}}
{{--                                            <option value="" disabled selected> Select Non Tax Invoice</option>--}}
{{--                                            @foreach($non_tax_invoices as $non_tax_invoice)--}}
{{--                                                <option value="{{$non_tax_invoice->si_id}}">--}}
{{--                                                    {{$non_tax_invoice->si_id}}--}}
{{--                                                </option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div><!-- invoice column end -->--}}

{{--                                <div hidden id="tax_inv"--}}
{{--                                     class="invoice_box hide form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">--}}
{{--                                    <!-- invoice column start -->--}}
{{--                                    <div class="input_bx"><!-- invoice column box start -->--}}
{{--                                        <label class="required">--}}
{{--                                            Invoice No--}}
{{--                                        </label>--}}
{{--                                        <select name="tax_invoice" class="inputs_up form-control" id="tax_invoice" data-rule-required="true"--}}
{{--                                                data-msg-required="Please Enter Tax Invoice No">--}}
{{--                                            <option value="" disabled selected> Select Tax Invoice</option>--}}
{{--                                            @foreach($tax_invoices as $tax_invoice)--}}
{{--                                                <option value="{{$tax_invoice->ssi_id}}">--}}
{{--                                                    {{$tax_invoice->ssi_id}}--}}
{{--                                                </option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div><!-- invoice column end -->--}}

{{--                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" hidden>--}}
{{--                                    <div class="input_bx"><!-- start input box -->--}}
{{--                                        <label class="">--}}
{{--                                            Selected Invoice--}}
{{--                                        </label>--}}
{{--                                        --}}{{--                                        {{ $region->reg_id == $search_region ? 'selected="selected"' : '' }}--}}
{{--                                        <input type="hidden" name="selected_invoice"--}}
{{--                                               id="selected_invoice" class="inputs_up form-control" placeholder=" Selected Invoice"/>--}}
{{--                                        <span id="demo4" class="validate_sign"> </span>--}}
{{--                                    </div><!-- end input box -->--}}
{{--                                </div>--}}

{{--                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12" hidden>--}}
{{--                                    <div class="input_bx"><!-- start input box -->--}}
{{--                                        <label class="">--}}
{{--                                            Party Code--}}
{{--                                        </label>--}}
{{--                                        <input type="hidden" name="party_code" readonly--}}
{{--                                               --}}{{--                                           value="{{$non_tax_invoices->si_party_code}}"--}}
{{--                                               id="party_code" class="inputs_up form-control" placeholder="Party Code"/>--}}
{{--                                        <span id="demo4" class="validate_sign"> </span>--}}
{{--                                    </div><!-- end input box -->--}}
{{--                                </div>--}}

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Party Name
                                        </label>
                                        <select required tabindex="1" autofocus name="party_name" class="inputs_up form-control js-example-basic-multiple"
                                                data-rule-required="true" data-msg-required="Please Choose Party Name"
                                                id="party_name">
                                            <option value="0">Select Party</option>
                                            @foreach($accounts as $account)
                                                <option value="{{$account->account_uid}}">{{$account->account_name}}</option>
                                            @endforeach
                                        </select>

{{--                                        <input type="text" name="party_name" readonly--}}
{{--                                               --}}{{--                                           value="{{$non_tax_invoices->si_party_name}}"--}}
{{--                                               id="party_name" class="inputs_up form-control" placeholder="Party Name"/>--}}
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end inpGut box -->
                                </div>



                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Purchase Order
                                        </label>
                                        <select tabindex="2" required name="purchase_order" class="inputs_up form-control js-example-basic-multiple"
                                                data-rule-required="true" data-msg-required="Please Choose Purchase Order"
                                                id="purchase_order">
                                            <option value="0" selected disabled>Select Purchase Order</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
{{--                                            @foreach($accounts as $account)--}}
{{--                                                <option value="{{$account->account_uid}}">{{$account->account_name}}</option>--}}
{{--                                            @endforeach--}}
                                        </select>


{{--                                        <input type="text" name="order_no"--}}
{{--                                               id="order_no" class="inputs_up form-control" placeholder="Order No"/>--}}
{{--                                        --}}
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>




                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Total Qty on Builty
                                        </label>
{{--                                        Hamad set tab index--}}
                                        <input tabindex="3" type="text" name="builty_qty" autocomplete="off"
                                               id="builty_qty" class="inputs_up form-control"
                                               placeholder="Quantity"/>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div hidden class="form-group col-lg-2 col-md-2 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Receiving Date & Time                                         </label>
                                        <input type="text" name="receiving_datetime" autocomplete="off"
                                               id="receiving_datetime"
                                               class="inputs_up form-control datetimepicker"
                                               placeholder="Date/Time" data-rule-required="true"
                                               data-msg-required="Please Enter Date/Time" aria-autocomplete="false">
                                        <span id="demo2" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            Remarks</label>


{{--                                        Hamad set tab index--}}
                                        <textarea tabindex="4" name="remarks" id="remarks"
                                                  class="inputs_up remarks"
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
                                <input type="radio" id="self_collection" name="delivery_option" value="company_delivery" class="custom-control-input" checked>
                                <label class="custom-control-label bold" for="self_collection">Vendor Delivery</label>
                            </div>
                            <div class="custom-control custom-radio mb-2 mt-2">
                                <input type="radio" id="company_delivery" name="delivery_option" value="self_collection" class="custom-control-input">
                                <label class="custom-control-label bold" for="company_delivery">Self Collection</label>
                            </div>
                            <div class="custom-control custom-radio mb-2 mt-2">
                                <input type="radio" id="courier_service" name="delivery_option" value="courier_service"  class="custom-control-input">
                                <label class="custom-control-label bold" for="courier_service">Courier Service</label>
                            </div>
                            <div class="custom-control custom-radio mb-2 mt-2">
                                <input type="radio" id="third_party" name="delivery_option" value="third_party" class="custom-control-input">
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
                                                    <input tabindex="5" type="text" name="name" id="name"
                                                           autocomplete="off"
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
                                                    <input tabindex="6" type="text" name="mobile" id="mobile"
                                                           class="inputs_up form-control"
                                                           onkeypress="numberFormatter(event)"
                                                           placeholder="03xx-xxxxxxx" autofocus
                                                           data-rule-required="true"
                                                           pattern="^((0))3\d{2}-?\d{7}$"
                                                           data-msg-required="Please Enter Mobile No"
                                                           autocomplete="off"
                                                           value="{{ old('mobile') }}"/>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>


                                            <div class="form-group col-lg-2 col-md-2 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        CNIC

                                                    </label>
{{--                                                    Hamad set tab index--}}
                                                    <input tabindex="7" type="text" name="cnic" id="cnic"
                                                           class="inputs_up form-control"
                                                           autocomplete="off"
                                                           placeholder="CNIC" autofocus
                                                           data-rule-required="true"
                                                           data-msg-required="Please Enter CNIC No"
                                                           autocomplete="off"
                                                           onkeypress="cnicFormatter(event)"
                                                           value="{{ old('cnic') }}"/>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>


                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        Remarks</label>
{{--                                                    Hamad set tab index--}}
                                                    <textarea tabindex="8" name="self_collection_remarks" id="self_collection_remarks" style="height: 35px;"
                                                              class="inputs_up self_collection_remarks"
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
                                                            id="employee"  data-rule-required="true" data-msg-required="Please Enter Employee">
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

                                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
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
                                                            <option value="" Selected disabled>Select courier</option>
                                                            <option value="0">Other Courier</option>
                                                            @foreach($couriers as $courier)
                                                                <option
                                                                    value="{{$courier->cc_id}}" {{ $courier->cc_id == old('courier') ? 'selected="selected"' : '' }}>{{$courier->cc_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>


                                                <div id="display_other_courier" class="form-group col-lg-2 col-md-2 col-sm-12" style="display: none">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="required">
                                                            Other Courier
                                                        </label>

                                                        <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="other_courier" id="other_courier" placeholder="Search ..."
                                                        value="" autocomplete="off" data-rule-required="true" data-msg-required="Please Enter Courier">
                                                        <datalist id="browsers">
                                                            @foreach($courier_names as $value)
                                                                <option value="{{$value}}">
                                                            @endforeach
                                                        </datalist>

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
                                                               autocomplete="off"
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
                                                            @foreach($cities as $city)
                                                                <option
                                                                    {{--                                                            {{$city->city_id == 0 ? 'selected':''}}--}}
                                                                    value="{{$city->city_id}}">
                                                                    {{$city->city_name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>


                                                <div class="form-group col-lg-2 col-md-2 col-sm-12">
                                                    <div class="input_bx"><!-- start input box -->
                                                        <label class="">
                                                            Remarks</label>
                                                        <textarea name="courier_service_remarks" id="courier_service_remarks"
                                                                  class="inputs_up remarks " style="height: 35px;"
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
                                                               placeholder="Truck, bus...." autofocus
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
                                                               onkeypress="numberFormatter(event)"
                                                               placeholder="03xx-xxxxxxx" autofocus
                                                               data-rule-required="true"
                                                               pattern="^((0))3\d{2}-?\d{7}$"
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
                        <button tabindex="9" type="reset" name="cancel" id="cancel" class="invoice_frm_btn btn btn-sm btn-secondary">
                                {{--                                        <i class="fa fa-eraser"></i>--}}
                                Cancel
                            </button>    
                        <button type="submit" tabindex="10" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>    
                            
                            
                        </div>
                    </div>


{{--                    <div class="form-group row">--}}

{{--                        <div class="col-lg-2 col-md-2 col-sm-2 form_controls">--}}
{{--                            <button type="reset" name="cancel" id="cancel"--}}
{{--                                    class="invoice_frm_btn form-control">--}}
{{--                                <i class="fa fa-eraser"></i> Cancel--}}
{{--                            </button>--}}

{{--                        </div>--}}

{{--                        <div class="col-lg-2 col-md-2 col-sm-2 form_controls">--}}

{{--                            <button type="submit" name="save" id="save"--}}
{{--                                    class="invoice_frm_btn form-control"--}}
{{--                            >--}}
{{--                                <i class="fa fa-floppy-o"></i> Save--}}
{{--                            </button>--}}
{{--                        </div>--}}


{{--                    </div>--}}

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


                // var phoneNumber = document.getElementById('mobile').value;
                // var phoneNumber2 = document.getElementById('driver_mobile').value;
                // var phoneRGEX = /^((0))3\d{2}-?\d{7}$/;
                // var phoneResult = phoneRGEX.test(phoneNumber);
                // var phoneResult2 = phoneRGEX.test(phoneNumber);
                // alert("phone:"+phoneResult );
                // alert("phone:"+phoneResult2 );




            var voucher_type = $("input[name='delivery_option']:checked").val();

            if (voucher_type == 'company_delivery') {
                let party_name = document.getElementById("party_name"),
                    // receiving_datetime = document.getElementById("receiving_datetime"),
                    name = document.getElementById("name"),
                    // cnic = document.getElementById("cnic"),
                    mobile = document.getElementById("mobile"),

                    validateInputIdArray = [
                        party_name.id,
                        // receiving_datetime.id,
                        name.id,
                        // cnic.id,
                        mobile.id,

                    ];

                return validateInventoryInputs(validateInputIdArray);

            }else if (voucher_type == 'self_collection') {


                let party_name = document.getElementById("party_name"),
                    // receiving_datetime = document.getElementById("receiving_datetime"),
                    employee = document.getElementById("employee"),


                    validateInputIdArray = [
                        party_name.id,
                        // receiving_datetime.id,
                        employee.id,


                    ];
                return validateInventoryInputs(validateInputIdArray);

            }else if (voucher_type == 'courier_service') {

                var name = $("#courier").val();


                if (name == "0"){

                    // alert("other");

                    let party_name = document.getElementById("party_name"),
                        // receiving_datetime = document.getElementById("receiving_datetime"),
                        other_courier = document.getElementById("other_courier"),
                        courier_slip_no = document.getElementById("courier_slip_no"),
                        courier_slip_date = document.getElementById("courier_slip_date"),
                        booking_city = document.getElementById("booking_city"),

                        validateInputIdArray = [
                            party_name.id,
                            // receiving_datetime.id,
                            other_courier.id,
                            courier_slip_no.id,
                            courier_slip_date.id,
                            booking_city.id,

                        ];

                    return validateInventoryInputs(validateInputIdArray);
                }else{

                    let party_name = document.getElementById("party_name"),
                        // receiving_datetime = document.getElementById("receiving_datetime"),
                        courier = document.getElementById("courier"),
                        courier_slip_no = document.getElementById("courier_slip_no"),
                        courier_slip_date = document.getElementById("courier_slip_date"),
                        booking_city = document.getElementById("booking_city"),

                        validateInputIdArray = [
                            party_name.id,
                            // receiving_datetime.id,
                            courier.id,
                            courier_slip_no.id,
                            courier_slip_date.id,
                            booking_city.id,

                        ];

                    return validateInventoryInputs(validateInputIdArray);


                }




            }else if (voucher_type == 'third_party') {
                let party_name = document.getElementById("party_name"),
                    // receiving_datetime = document.getElementById("receiving_datetime"),
                    vehicle_no = document.getElementById("vehicle_no"),
                    vehicle_type = document.getElementById("vehicle_type"),
                    driver_name = document.getElementById("driver_name"),
                    driver_mobile = document.getElementById("driver_mobile"),

                    validateInputIdArray = [
                        party_name.id,
                        // receiving_datetime.id,
                        vehicle_no.id,
                        vehicle_type.id,
                        driver_name.id,
                        driver_mobile.id,

                    ];

                return validateInventoryInputs(validateInputIdArray);

            } else {
                let party_name = document.getElementById("party_name"),
                    // receiving_datetime = document.getElementById("receiving_datetime"),

                    validateInputIdArray = [
                        party_name.id,
                        // receiving_datetime.id,
                    ];

                return validateInventoryInputs(validateInputIdArray);

            }

        }



    </script>
    {{-- end of required input validation --}}
    <script>




        jQuery("#courier").change(function () {

            // var dropDown = document.getElementById('courier');
            // var cc_id = dropDown.options[dropDown.selectedIndex].value;

            var name = $("#courier").val();


            if (name == "0"){
                $("#display_other_courier").css("display", "block");
            }else{
                $("#display_other_courier").val("");
                $("#display_other_courier").css("display", "none");

            }

            // jQuery.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            //
            // jQuery.ajax({
            //     url: "get_courier_city",
            //     data: {cc_id: cc_id},
            //     type: "POST",
            //     cache: false,
            //     dataType: 'json',
            //     success: function (data) {
            //         jQuery("#booking_city").html(" ");
            //         jQuery("#booking_city").append(data);
            //         jQuery("#destination_city").html(" ");
            //         jQuery("#destination_city").append(data);
            //     },
            //     error: function (jqXHR, textStatus, errorThrown) {
            //         alert(jqXHR.responseText);
            //         alert(errorThrown);
            //     }
            // });
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
            jQuery("#purchase_order").select2();


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

        $("#party_name").change(function () {
            var party_code = $(this).val();

            // jQuery.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            {{--$.ajax({--}}
            {{--    type: "GET",--}}
            {{--    dataType: "json",--}}
            {{--    url: '{{ route('non_tax_invoice_party') }}',--}}
            {{--    data: {--}}
            {{--        'party_code': party_code,--}}
            {{--    },--}}
            {{--    cache: false,--}}
            {{--    dataType: 'json',--}}
            {{--    success: function (data) {--}}

            {{--        $.each(data.non_tax_party, function (key, value) {--}}
            {{--            $('#party_code').val(value.si_party_code);--}}
            {{--            $('#party_name').val(value.si_party_name);--}}

            {{--        });--}}

            {{--    }--}}
            {{--});--}}
        });

        $("#purchase_order").change(function () {
            var purchase_order = $(this).val();

            // jQuery.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            {{--$.ajax({--}}
            {{--    type: "GET",--}}
            {{--    dataType: "json",--}}
            {{--    url: '{{ route('tax_invoice_party') }}',--}}
            {{--    data: {--}}
            {{--        'purchase_order': purchase_order,--}}

            {{--    },--}}
            {{--    cache: false,--}}
            {{--    dataType: 'json',--}}
            {{--    success: function (data) {--}}

            {{--        $.each(data.tax_party, function (key, value) {--}}
            {{--            $('#invoice_date').val(value.po_day_end_date);                        --}}

            {{--        });--}}

            {{--    }--}}
            {{--});--}}
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


        function cnicFormatter(event){
            var cnic = $("#cnic").val();
            var cnic_length = cnic.length;

            // alert(cnic);
            // alert(cnic_length);

            if (cnic_length == 5){
                $("#cnic").val(cnic + "-");
            }

            if (cnic_length == 13){
                $("#cnic").val(cnic + "-");
            }

            if (cnic_length > 14) {
                event.preventDefault();
            }

            }


        function numberFormatter(event){
            var Number = $("#mobile").val();
            var Number_length = Number.length;

            if (Number_length == 4){
                $("#mobile").val(Number + "-");
            }

            var Number2 = $("#driver_mobile").val();
            var Number_length2 = Number2.length;

            if (Number_length > 11) {
                event.preventDefault();
            }

            if (Number_length2 == 4){
                $("#driver_mobile").val(Number2 + "-");
            }


            if (Number_length2 > 11) {
                event.preventDefault();
            }

        }





    </script>

@endsection


