@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Survey</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('cash_receipt_voucher_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->


                        <form id="f1" action="{{ route('submit_order_list') }}" method="post" onsubmit="return checkForm()">
                            @csrf

                            <div class="pd-20">
                                <input type="hidden" id="data" data-company-id=""
                                       data-region-id=""
                                       data-region-action="{{ route('api.regions.options') }}"
                                >

                                <div class="row credentials_div">

                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">

                                        <!-- invoice scroll box start -->
                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                            <!-- invoice content start -->
                                            <div class="invoice_row">
                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Username
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="10" name="username" id="username"
                                                                    class="inputs_up form-control auto-select" tabindex="0" data-rule-required="true" data-msg-required="Please
                                                                    Enter Username"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Username
                                                                </option>
                                                                @foreach ($usernames as $username)
                                                                    <option
                                                                        value="{{ $username->srv_id }}"
                                                                    >{{ $username->srv_name }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Company
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="10" name="company" id="company"
                                                                    data-fetch-url="{{ route('api.companies.options') }}"
                                                                    class="inputs_up form-control auto-select company_dropdown" tabindex="0" data-rule-required="true" data-msg-required="Please
                                                                    Enter Company Name"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Company
                                                                </option>
                                                                {{--                                                                @foreach ($companies as $company)--}}
                                                                {{--                                                                    <option--}}
                                                                {{--                                                                        value="{{ $company->account_uid }}"--}}
                                                                {{--                                                                        data-company-id="{{ $company->account_uid }}">{{ $company->account_name }}</option>--}}
                                                                {{--                                                                @endforeach--}}
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Project
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input ">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="1" autofocus
                                                                    name="project"
                                                                    id="project"
                                                                    class="inputs_up form-control"
                                                                    data-rule-required="true" data-msg-required="Please Enter Project Name" tabindex="1" autofocus>
                                                                <option value="" selected disabled>
                                                                    Select Project
                                                                </option>

                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Franchise
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input ">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="1" autofocus
                                                                    name="franchise"
                                                                    id="franchise"
                                                                    class="inputs_up form-control"
                                                                    data-rule-required="true" data-msg-required="Please Enter Franchise Name" tabindex="1" autofocus>
                                                                <option value="" selected disabled>
                                                                    Select Franchise
                                                                </option>

                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Product
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input ">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="1" autofocus
                                                                    name="product"
                                                                    id="product"
                                                                    class="inputs_up form-control"
                                                                    data-rule-required="true" data-msg-required="Please Enter Product Name" tabindex="1" autofocus>
                                                                <option value="" selected disabled>
                                                                    Select Product
                                                                </option>

                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->


                                            </div>
                                            <hr>
                                            <div class="invoice_row">
                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Shop Name
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input ">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="4" type="text" name="shop_name" class="inputs_up form-control" id="shop_name" placeholder="Shop Name" value=""
                                                                   data-rule-required="true" data-msg-required="Please Enter Shop Name" tabindex="1"
                                                                   tabindex="6">

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Shop Code
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input ">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="4" type="text" name="shop_code" class="inputs_up form-control" id="shop_code" placeholder="Shop Code" value=""
                                                                   data-rule-required="true" data-msg-required="Please Enter Shop Code" tabindex="1"
                                                                   tabindex="6">

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Shop Keeper Name
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input ">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="4" type="text" name="shop_keeper_name" class="inputs_up form-control" id="shop_keeper_name" placeholder="Shop Keeper Name"
                                                                   value=""
                                                                   data-rule-required="true" data-msg-required="Please Enter Shop Keeper Name" tabindex="1"
                                                                   tabindex="6">

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Address
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input ">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <textarea tabindex="4" type="text" name="address" class="inputs_up form-control" id="address" placeholder="Shop Address" value=""
                                                                      data-rule-required="true" data-msg-required="Please Enter Shop Address" tabindex="1"
                                                                      tabindex="6"></textarea>
{{--                                                            <input tabindex="4" type="text" name="address" class="inputs_up form-control" id="address" placeholder="Shop Address" value=""--}}
{{--                                                                   data-rule-required="true" data-msg-required="Please Enter Shop Address" tabindex="1"--}}
{{--                                                                   tabindex="6">--}}

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Contact 1
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input ">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="4" type="text" name="contact1" class="inputs_up form-control" id="contact1" placeholder="Contact Number 1" value=""
                                                                   data-rule-required="true" data-msg-required="Please Enter Contact Number 1" tabindex="1"
                                                                   tabindex="6">

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Contact 2
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input ">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="4" type="text" name="contact2" class="inputs_up form-control" id="contact2" placeholder="Contact Number 2" value=""
                                                                   data-rule-required="true" data-msg-required="Please Enter Contact Number 2" tabindex="1"
                                                                   tabindex="6">

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div>
                                            <hr>
                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_15 type_1_3">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Length Feet
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="4" type="text" name="length_feet" class="inputs_up form-control" id="length_feet" placeholder="Remarks" value=""
                                                                   tabindex="6">

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_6 type_1_3">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Length Inch
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="5" type="text" name="length_inch" id="length_inch" class="inputs_up text-right form-control" placeholder="Quantity"
                                                                   tabindex="7">

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_6 type_1_3">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Width Feet
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="6" type="text" name="width_feet" id="width_feet" class="inputs_up text-right form-control" placeholder="Rate" >

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_6 type_1_3">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Width Inch
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="16" type="text" name="width_inch" id="width_inch" class="inputs_up text-right form-control" placeholder="UOM" >

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_6 type_1_3">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Depth
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="16" type="text" name="depth" id="depth" class="inputs_up text-right form-control" placeholder="Depth" readonly>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_6 type_1_3">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Tapa Gauge
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="16" type="text" name="tapa_gauge" id="tapa_gauge" class="inputs_up text-right form-control" placeholder="Tapa Gauge"
                                                                   readonly>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_8 type_1_3">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Back Sheet Gauge
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="16" type="text" name="back_sheet_gauge" id="back_sheet_gauge" class="inputs_up text-right form-control"
                                                                   placeholder="Back Sheet Gauge" readonly>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_6 type_2">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Quantity
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="17" type="text" name="quantity" id="quantity" class="inputs_up text-right form-control" placeholder="Quantity" >

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_15">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Image
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="17" type="file" name="image" id="image" class="inputs_up text-right form-control" placeholder="Quantity" >

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_txt for_voucher_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="invoice_col_txt with_cntr_jstfy">
                                                            <div
                                                                class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                <button tabindex="20" id="first_add_more"
                                                                        class="invoice_frm_btn"
                                                                        onclick="add_order()"
                                                                        type="button">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                <button style="display: none;"
                                                                        id="cancel_button"
                                                                        class="invoice_frm_btn"
                                                                        onclick="cancel_all()"
                                                                        type="button">
                                                                    <i class="fa fa-times"></i> Cancel
                                                                </button>
                                                            </div>
                                                            <span id="demo201"
                                                                  class="validate_sign"> </span>
                                                        </div>
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->

                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_100">

                                                    <!-- invoice column start -->
                                                    <div class="invoice_row"><!-- invoice row start -->

                                                        <div
                                                            class="invoice_col basis_col_100 gnrl-mrgn-pdng">
                                                            <!-- invoice column start -->
                                                            <div class="pro_tbl_con for_voucher_tbl">
                                                                <!-- product table container start -->
                                                                <div class="pro_tbl_bx">
                                                                    <!-- product table box start -->
                                                                    <table class="table gnrl-mrgn-pdng"
                                                                           id="category_dynamic_table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th tabindex="-1" class="text-center tbl_srl_15">
                                                                                Company
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_15">
                                                                                Region
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_10">
                                                                                Type
                                                                            </th>

                                                                            <th tabindex="-1" class="text-center tbl_txt_15">
                                                                                Product
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_srl_15">
                                                                                Remarks
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_srl_7">
                                                                                QTY
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_srl_7">
                                                                                Rate
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_srl_7">
                                                                                UOM
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_srl_7">
                                                                                Amount
                                                                            </th>
                                                                            <th class="text-center tbl_srl_7">
                                                                                Start Date
                                                                            </th>
                                                                            <th class="text-center tbl_srl_7">
                                                                                End Date
                                                                            </th>
                                                                        </tr>
                                                                        </thead>

                                                                        <tbody id="table_body">
                                                                        <tr>
                                                                            <td tabindex="-1" colspan="10"
                                                                                align="center">
                                                                                No Entry
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>

                                                                        <tfoot>
                                                                        <tr>
                                                                            <th colspan="4"
                                                                                class="text-right">
                                                                                Total Items
                                                                            </th>
                                                                            <td class="text-center tbl_srl_12">
                                                                                <div
                                                                                    class="invoice_col_txt">
                                                                                    <!-- invoice column box start -->
                                                                                    <div
                                                                                        class="invoice_col_input">
                                                                                        <!-- invoice column input start -->
                                                                                        <input type="text"
                                                                                               name="total_items"
                                                                                               class="inputs_up text-right form-control total-items-field"
                                                                                               id="total_items"
                                                                                               placeholder="0.00"
                                                                                               readonly
                                                                                               data-rule-required="true"
                                                                                               data-msg-required="Please Add"/>
                                                                                    </div>
                                                                                    <!-- invoice column input end -->
                                                                                </div>
                                                                                <!-- invoice column box end -->
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th colspan="4"
                                                                                class="text-right">
                                                                                Total Price
                                                                            </th>
                                                                            <td class="text-center tbl_srl_12">
                                                                                <div
                                                                                    class="invoice_col_txt">
                                                                                    <!-- invoice column box start -->
                                                                                    <div
                                                                                        class="invoice_col_input">
                                                                                        <!-- invoice column input start -->
                                                                                        <input type="text"
                                                                                               name="total_price"
                                                                                               class="inputs_up text-right form-control grand-total-field"
                                                                                               id="total_price"
                                                                                               placeholder="0.00"
                                                                                               readonly/>
                                                                                    </div>
                                                                                    <!-- invoice column input end -->
                                                                                </div>
                                                                                <!-- invoice column box end -->
                                                                            </td>
                                                                        </tr>
                                                                        </tfoot>

                                                                    </table>
                                                                </div><!-- product table box end -->
                                                            </div><!-- product table container end -->
                                                        </div><!-- invoice column end -->


                                                    </div><!-- invoice row end -->
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->
                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                    <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button tabindex="21" type="submit" name="save" id="save" class="invoice_frm_btn">
                                                                <i class="fa fa-floppy-o"></i> Save
                                                            </button>
                                                        </div>
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->
                                        </div><!-- invoice content end -->
                                    </div><!-- invoice scroll box end -->


                                    <input type="hidden" name="order_array"
                                           id="order_array">


                                </div>
                            </div>

                        </form>


                    </div><!-- invoice box end -->
                </div><!-- invoice container end -->

            </div> <!-- white column form ends here -->

        </div><!-- col end -->


    </div><!-- row end -->


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Cash Receipt Voucher Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    {{--                    <div id="table_body">--}}

                    {{--                    </div>--}}
                    <div id="hello"></div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let company = document.getElementById("company"),
                project = document.getElementById("project"),
                total_items = document.getElementById("total_items"),
                remaining_amount = document.getElementById("cal_remaining_amount"),
                validateInputIdArray = [
                    company.id,
                    project.id,
                    total_items.id,
                    remaining_amount.id,
                ];
            let checkVald = validateInventoryInputs(validateInputIdArray);
            if (remaining_amount.value >= 0) {
                return checkVald;
            } else {
                alertMessageShow(remaining_amount.id, 'Remaining amount not less 0 ');
                return false;
            }
            //return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    {{--    @if (Session::get('cr_id'))--}}
    {{--        <script>--}}
    {{--            jQuery("#table_body").html("");--}}

    {{--            var id = '{{ Session::get("cr_id") }}';--}}
    {{--            $(".modal-body").load('{{ url('cash_receipt_items_view_details/view/') }}/'+id, function () {--}}
    {{--                // jQuery(".pre-loader").fadeToggle("medium");--}}
    {{--                $("#myModal").modal({show:true});--}}
    {{--            });--}}
    {{--        </script>--}}
    {{--    @endif--}}
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
            // Initialize select2
            jQuery("#username").select2();
            jQuery("#project").select2();
            jQuery("#company").select2();
            jQuery("#franchise").select2();
            jQuery("#product").select2();
            $('.type_1_3').hide();
            $('.type_2').hide();

        });
    </script>
    {{--    Start Order List script--}}

    <script>

        // adding packs into table
        var numberoforders = 0;
        var counter = 0;
        var orders = {};

        var global_id_to_edit = 0;
        var edit_order_value = '';


        function add_order() {

            var company_id = document.getElementById("company").value;
            // var party = document.getElementById("party").value;

            var regions = document.getElementById("region").value;

            var region_value = $('#region').find(':selected').data('region-id');

            var product_name_value = document.getElementById("product_name").value;
            var service_value = document.getElementById("services").value;

            var order_remarks = document.getElementById("order_remarks").value;
            var qty = document.getElementById("qty").value;
            var uom = document.getElementById("uom").value;
            var rate = document.getElementById("rate").value;
            var amount = document.getElementById("amount").value;
            var start_date = document.getElementById("start_date").value;
            var end_date = document.getElementById("end_date").value;
            var pro_ser = $('input[name="pro_ser"]:checked').val();
            var remaining_amount = $('#cal_remaining_amount').val();

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (remaining_amount <= 0) {

                if (focus_once1 == 0) {
                    $("#cal_remain").text("Remaining amount not less than 0");
                    // jQuery("#total_price").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            // document.getElementById("cal_remain").innerHTML = '';
            if (regions == "0" || regions == "" || regions == "empty") {

                if (focus_once1 == 0) {
                    jQuery("#region").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (regions == "0" || regions == "" || regions == "empty") {

                if (focus_once1 == 0) {
                    jQuery("#region").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (pro_ser == 'products') {
                if (product_name_value == "") {

                    if (focus_once1 == 0) {
                        jQuery("#product_name").focus();
                        focus_once1 = 1;
                    }
                    flag_submit1 = false;
                }
            } else {
                if (service_value == "") {

                    if (focus_once1 == 0) {
                        jQuery("#services").focus();
                        focus_once1 = 1;
                    }
                    flag_submit1 = false;
                }
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete orders[global_id_to_edit];
                }

                counter++;

                jQuery("#company").select2("destroy");
                jQuery("#region").select2("destroy");
                jQuery("#product_name").select2("destroy");
                jQuery("#services").select2("destroy");

                var company_name = jQuery("#company option:selected").text();
                var region_name = jQuery("#region option:selected").text();
                var product_name = jQuery("#product_name option:selected").text();
                var service_name = jQuery("#services option:selected").text();


                if (numberoforders == 0) {
                    jQuery("#table_body").html("");
                }

                numberoforders = Object.keys(orders).length;

                // if (numberoforders == 0) {
                //     jQuery("#table_body").html("");
                // }


                orders[counter] = {
                    'company_id': company_id,
                    'company_name': company_name,
                    'region_value': region_value,
                    'region_name': region_name,
                    'service_value': service_value,
                    'service_name': service_name,
                    'order_remarks': order_remarks,
                    'product_name_value': product_name_value,
                    'product_name': product_name,
                    'qty': qty,
                    'uom': uom,
                    'rate': rate,
                    'amount': amount,
                    'start_date': start_date,
                    'end_date': end_date,
                    'pro_ser': pro_ser,

                };

                // console.log(orders);
                jQuery("#company_id option[value=" + company_id + "]").attr("disabled", "true");
                // jQuery("#regions option[value=" + regions + "]").attr("disabled", "true");
                numberoforders = Object.keys(orders).length;
                jQuery("#total_items").val(numberoforders);
                // <td class="text-left tbl_srl_20">' + warehouse_name + '</td>


                var pro_serve = '';
                if (pro_ser == 'products') {
                    pro_serve = product_name;
                } else {
                    pro_serve = service_name;
                }

                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_15">' + company_name + '</td><td class="text-left tbl_txt_15">' + region_name + '</td><td class="text-left ' +
                    'tbl_txt_10">' + pro_ser + '</td><td class="text-left ' +
                    'tbl_txt_15">' + pro_serve + '</td><td class="text-left' +
                    'tbl_txt_15">' + order_remarks + '</td><td class="text-left tbl_txt_7">' + qty + '</td><td class="text-left tbl_txt_7">' + rate + '</td><td class="text-left tbl_txt_7">' + uom
                    + '</td><td class="text-left tbl_txt_7">' + amount
                    + '</td><td class="text-left tbl_txt_7">' + start_date
                    + '</td><td class="text-right tbl_srl_7">' + end_date +
                    '<div class="edit_update_bx"><a ' +
                    'class="edit_link btn btn-sm btn-success" href="#" onclick=edit_order(' + counter + ')><i class="fa fa-edit"></i></a> <a href="#" class="delete_link btn btn-sm btn-danger" ' +
                    'onclick=delete_order(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');
                // jQuery('#company option[value="' + 0 + '"]').prop('selected', true);
                // $("#regions option:selected").prop("selected", false)

                // jQuery('#regions').select2('val', '0');
                jQuery('#services option[value="' + '' + '"]').prop('selected', true);
                jQuery('#product_name option[value="' + '' + '"]').prop('selected', true);

                jQuery("#qty").val("");
                jQuery("#uom").val("");
                jQuery("#amount").val("");
                jQuery("#rate").val("");

                jQuery("#order_remarks").val("");
                jQuery("#start_date").val("");
                jQuery("#end_date").val("");

                jQuery("#total_qty").val("");
                jQuery("#consume_qty").val("");
                jQuery("#remaining_qty").val("");

                jQuery("#order_array").val(JSON.stringify(orders));

                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i>  Add');

                jQuery("#total_items").val(numberoforders);

                jQuery("#company").select2();
                jQuery("#region").select2();
                jQuery("#product_name").select2();
                jQuery("#services").select2();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
                grand_total_calculation();
                calculate_remaining_amount();
            }
        }

        function delete_order(current_item) {

            jQuery("#" + current_item).remove();
            var temp_orders = orders[current_item];

            console.log(temp_orders, temp_orders['company_id']);
            jQuery("#company option[value=" + temp_orders['company_id'] + "]").attr("disabled", false);
            // jQuery("#regions option[value=" + temp_orders['regions'] + "]").attr("disabled", false);

            jQuery("#company").select2();
            jQuery("#region").select2();

            delete orders[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            numberoforders = Object.keys(orders).length;
            jQuery("#order_array").val(JSON.stringify(orders));
            jQuery("#total_items").val(numberoforders);

            if (isEmpty(orders)) {
                numberoforders = 0;
            }


            // jQuery("#total_items").val(numberoforders);
            grand_total_calculation();
            calculate_remaining_amount();
        }

        function edit_order(current_item) {

            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();


            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;
            console.log(current_item, global_id_to_edit);
            var temp_orders = orders[current_item];

            edit_order_value = temp_orders['company_id'];


            jQuery("#company").select2("destroy");
            jQuery("#region").select2("destroy");
            jQuery("#product_name").select2("destroy");
            jQuery("#services").select2("destroy");
            // jQuery("#warehouse").select2("destroy");


            // jQuery("#company option[value=" + temp_orders['company_id'] + "]").attr("disabled", false);
            // jQuery("#regions option[value=" + temp_orders['regions'] + "]").attr("disabled", false);

            jQuery('#company option[value="' + temp_orders['company_id'] + '"]').prop('selected', true);

            jQuery('#region option[value="' + temp_orders['region_value'] + '"]').prop('selected', true);

            jQuery('#product_name option[value="' + temp_orders['product_name_value'] + '"]').prop('selected', true);
            jQuery('#services option[value="' + temp_orders['service_value'] + '"]').prop('selected', true);

            var value = temp_orders['region'];

            // for (var i = 0; i < value.length; i++) {
            //     jQuery('#region option[value="' + value[i] + '"]').prop('selected', true);
            //     jQuery("#region").select2();
            // }

            // jQuery('#regions option[value="' + temp_orders['regions'] + '"]').prop('selected', true);

            //
            // jQuery("#product_name").val(temp_orders['product_code']);
            jQuery("#qty").val(temp_orders['qty']);

            jQuery("#uom").val(temp_orders['uom']);

            jQuery("#rate").val(temp_orders['rate']);

            jQuery("#amount").val(temp_orders['amount']);

            jQuery("#start_date").val(temp_orders['start_date']);

            jQuery("#end_date").val(temp_orders['end_date']);

            var vala = (temp_orders['pro_ser']);
            if (vala == 'services') {
                jQuery("#services_show").prop("checked", true);
                $('#product_div').hide();
                $('#service_div').show();

            } else if (vala == 'products') {
                jQuery("#product_show").prop("checked", true);
                $('#product_div').show();
                $('#service_div').hide();
                // jQuery("#product_name").select2("destroy");
                // jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
                // jQuery("#product_name").select2();
            }


            // jQuery("#rate").val(temp_orders['product_rate']);
            // jQuery("#amount").val(temp_orders['product_amount']);
            jQuery("#order_remarks").val(temp_orders['order_remarks']);

            jQuery("#company").select2();
            jQuery("#region").select2();
            jQuery("#product_name").select2();
            jQuery("#services").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            // var newvaltohide = jQuery("#product_code").val();

            var newvaltohide = edit_order_value;

            // jQuery("#product_code option[value=" + newvaltohide + "]").attr("disabled", "true");

            // jQuery("#product_name option[value=" + newvaltohide + "]").attr("disabled", "true");
            // jQuery('#product_code option[value="' + '' + '"]').prop('selected', true);
            jQuery('#services option[value="' + '' + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + '' + '"]').prop('selected', true);
            jQuery('#region option[value="' + '' + '"]').prop('selected', true);
            // jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

            // jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            jQuery("#services").select2("destroy");
            //jQuery("#warehouse").select2("destroy");

            jQuery("#order_remarks").val("");
            jQuery("#qty").val("");
            jQuery("#rate").val("");
            jQuery("#amount").val("");
            jQuery("#uom").val("");
            jQuery("#start_date").val("");
            jQuery("#end_date").val("");

            jQuery("#services").select2();
            jQuery("#product_name").select2();
            jQuery("#company").select2();
            jQuery("#region").select2();
            // jQuery("#warehouse").select2();

            jQuery("#cancel_button").hide();
            jQuery(".table-responsive").show();
            jQuery("#save").show();
            jQuery("#first_add_more").html('Add');

            global_id_to_edit = 0;


            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            edit_order_value = '';
        }
    </script>
    <script>
        jQuery("#product_name").change(function () {

            var project = $("#project").val();
            var product = $("#product_name").val();
            $('#product_name option[value="' + product + '"]').prop('selected', true);
            // $("#product_code").select2();

            var parent_code = jQuery("#product_name option:selected").attr('data-parent');
            var name = $("#product_name option:selected").text();
            // var quantity = 1;
            var unit_measurement = $('option:selected', this).attr('data-unit');
            jQuery("#uom").val(unit_measurement);
            // var bonus_qty = '';
            var rate = $('option:selected', this).attr('data-sale_price');
            jQuery("#rate").val(rate);

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_qty",
                data: {product: product, project: project},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
// console.log(data);
                    jQuery("#consume_qty").html(" ");
                    jQuery("#total_qty").html(" ");
                    jQuery("#total_qty").val(data.total_qty);
                    jQuery("#consume_qty").val(data.total_consume_qty);
                    var remaining = data.total_qty - data.total_consume_qty;
                    jQuery("#remaining_qty").val(remaining);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });

        });

        jQuery("#qty").keyup(function () {
            var qty = $(this).val();
            var rate = $('#rate').val();
            var amount = rate * qty;
            $('#amount').val(amount);
        });

    </script>

    {{--    end Order List script--}}
    <script>
        $('#product_show').click(function () {
            $('#product_div').show();
            $('#service_div').hide();
            jQuery("#services").select2("destroy");
            jQuery('#services option[value="' + 0 + '"]').prop('selected', true);
            jQuery("#services").select2();
        });
        $('#services_show').click(function () {
            $('#product_div').hide();
            $('#service_div').show();
            jQuery("#product_name").select2("destroy");
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery("#product_name").select2();
        });
    </script>

    <script>
        $('#username').change(function () {
            var user_id = $(this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_companies",
                data: {user_id: user_id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    var option = "<option value='' disabled selected>Select Company</option>";

                    $.each(data.companies, function (index, value) {
                        option += "<option value='" + value.account_uid + "' data-company-id='" + value.account_uid + "'>" + value.account_name + "</option>";
                    });

                    jQuery("#company").html(" ");
                    jQuery("#company").append(option);
                    jQuery("#company").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>

    <script>
        $('#company').change(function () {
            var company_id = $(this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "gets_project",
                data: {company_id: company_id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    var option = "<option value='' disabled selected>Select Project</option>";

                    $.each(data.projects, function (index, value) {
                        option += "<option value='" + value.proj_id + "' >" + value.proj_project_name + "</option>";
                    });

                    jQuery("#project").html(" ");
                    jQuery("#project").append(option);
                    jQuery("#project").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>

    <script>
        $('#project').change(function () {
            var user_id = $('#username').val();
            var project_id = $(this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_franchises",
                data: {user_id: user_id, project_id: project_id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    var option = "<option value='' disabled selected>Select Franchise</option>";

                    $.each(data.franchises, function (index, value) {
                        option += "<option value='" + value.id + "' >" + value.code + ' ' + value.name + "</option>";
                    });

                    jQuery("#franchise").html(" ");
                    jQuery("#franchise").append(option);
                    jQuery("#franchise").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>

    <script>
        $('#project').change(function () {
            var project_id = $(this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_products",
                data: {project_id: project_id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    var option = "<option value='' disabled selected>Select Product</option>";

                    $.each(data.products, function (index, value) {
                        option += "<option value='" + value.pmc_pro_code + "' data-before_value='" + value.before + "' data-after_value='" + value.after + "' data-output_value='" + value.output +
                            "' data-pmc_adv_type='" + value.pmc_adv_type + "' data-post_survey='" + value.pmc_post_survey + "' data-pre_survey='" + value.pmc_pre_survey + "' " +
                            "data-back_sheet_gauge='" + value.pmc_back_sheet_gauge + "' data-depth='"
                            + value.pmc_depth + "'data-tapa_gauge='" + value.pmc_tapa_gauge + "' " +
                            ">" + value.pro_title + "</option>";
                    });

                    jQuery("#product").html(" ");
                    jQuery("#product").append(option);
                    jQuery("#product").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>

    <script>
        $('#product').change(function () {
            var product_id = $(this).val();
            var project = $(this).find(':selected').val();
            var product_type = $('option:selected', this).attr('data-pmc_adv_type');
            var before_value = $('option:selected', this).attr('data-before_value');
            var after_value = $('option:selected', this).attr('data-after_value');
            var depth = $('option:selected', this).attr('data-depth');
            var tapa_gauge = $('option:selected', this).attr('data-tapa_gauge');
            var back_sheet_gauge = $('option:selected', this).attr('data-back_sheet_gauge');
            if(product_type == 1){
                    $('.type_1_3').show();
                    $('.type_2').hide();
                    $('#depth').val(depth);
                    $('#tapa_gauge').val(tapa_gauge);
                    $('#back_sheet_gauge').val(back_sheet_gauge);

            }else if(product_type == 2){
                $('.type_1_3').hide();
                $('.type_2').show();
                $('#depth').val('');
                $('#tapa_gauge').val('');
                $('#back_sheet_gauge').val('');
            }else if(product_type == 3){
                $('.type_1_3').show();
                $('.type_2').hide();
            }
        });

    </script>


@endsection

