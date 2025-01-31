@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Additional Order List Item</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('order_items_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->


                        <form id="f1" action="{{ route('submit_additional_order_list') }}" method="post" onsubmit="return checkForm()">
                            @csrf

                            <div class="pd-20">
                                {{--                                <input type="hidden" id="data" data-company-id=""--}}
                                {{--                                       data-region-id=""--}}
                                {{--                                       data-region-action="{{ route('api.regions.options') }}"--}}
                                {{--                                       data-zone-id=""--}}
                                {{--                                       data-zone-action="{{ route('api.zones.options') }}"--}}
                                {{--                                >--}}

                                <div class="row credentials_div">

                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">

                                        <!-- invoice scroll box start -->
                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                            <!-- invoice content start -->
                                            <div class="invoice_row">
                                                <div class="invoice_col basis_col_13"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                            Total Amount
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="projectTotalAmountView">
                                                                0
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->
                                                -

                                                <div class="invoice_col basis_col_13"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                            Used Amount
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="consumeTotalAmountView">
                                                                0
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->
                                                =
                                                <div class="invoice_col basis_col_13"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                            Due Amount
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="remainingTotalAmountView">
                                                                0
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                    <span style="color: red" id="cal_remain"></span>
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                            Due %
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="remaining_pec">
                                                                0
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                    <span style="color: red" id="cal_remain"></span>
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10" hidden>
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            PO Grand Total
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input type="text" name="grand_total"
                                                                   class="inputs_up form-control"
                                                                   id="grand_total" placeholder="0.00" readonly>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_13" hidden>
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Consume Amount
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input ">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="3" type="text" name="consume_amount"
                                                                   class="inputs_up form-control"
                                                                   id="consume_amount"
                                                                   placeholder="0.00"
                                                                   readonly>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_13" hidden>
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Remaining Amount
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input ">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input type="text" name="remaining_amount"
                                                                   class="inputs_up form-control"
                                                                   id="remaining_amount"
                                                                   placeholder="0.00"
                                                                   readonly>

                                                            <input tabindex="4" type="text" name="cal_remaining_amount"
                                                                   class="inputs_up form-control"
                                                                   id="cal_remaining_amount"
                                                                   placeholder="0.00"
                                                                   readonly>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->
                                                <!-- quantity manage -->

                                                <div class="invoice_col basis_col_13" style="margin-left: 50px;"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                            Total QTY
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="totalQtyView">
                                                                0
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->
                                                -

                                                <div class="invoice_col basis_col_13"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                            Used QTY
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="consumeTotalQtyView">
                                                                0
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->
                                                =
                                                <div class="invoice_col basis_col_13"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                            Due QTY
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="remainingTotalQtyView">
                                                                0
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                    <span style="color: red" id="cal_remain"></span>
                                                </div><!-- invoice column end -->


                                                <div class="invoice_col basis_col_9" hidden>
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Total QTY
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input tabindex="5" type="hidden" name="total_qty"
                                                                   class="inputs_up form-control"
                                                                   id="total_qty" placeholder="qty" readonly>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_9" hidden>
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Used QTY
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input tabindex="6" type="hidden" name="consume_qty"
                                                                   class="inputs_up form-control"
                                                                   id="consume_qty" placeholder="qty" readonly>
                                                            <input tabindex="6" type="hidden" name="used_qty"
                                                                   class="inputs_up form-control"
                                                                   id="used_qty" placeholder="qty" readonly>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_9" hidden>
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Due QTY
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input tabindex="7" type="hidden" name="remaining_qty"
                                                                   class="inputs_up form-control"
                                                                   id="remaining_qty" placeholder="qty" readonly>
                                                            <input tabindex="7" type="hidden" name="dues_qty"
                                                                   class="inputs_up form-control"
                                                                   id="dues_qty" placeholder="qty" readonly>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->
                                            </div>  <!-- row end -->

                                            <div class="invoice_row">

                                                <div class="invoice_col basis_col_20">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Order Title
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->

                                                            <input tabindex="0" type="text" name="order_title" class="inputs_up form-control" id="order_title" data-rule-required="true"
                                                                   data-msg-required="Please
                                                                    Enter Order Title" placeholder="Order Title">

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->


                                                <div class="invoice_col basis_col_20">
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


                                                                <a href="{{ route('receivables_account_registration') }}"
                                                                   class="col_short_btn"
                                                                   target="_blank"
                                                                   data-container="body"
                                                                   data-toggle="popover"
                                                                   data-trigger="hover"
                                                                   data-placement="bottom"
                                                                   data-html="true"
                                                                   data-content="Add Client Button">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                                <a href="{{ route('payables_account_registration') }}"
                                                                   class="col_short_btn"
                                                                   target="_blank"
                                                                   data-container="body"
                                                                   data-toggle="popover"
                                                                   data-trigger="hover"
                                                                   data-placement="bottom"
                                                                   data-html="true"
                                                                   data-content="Add Supplier Button">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                                {{--                                                                <a onclick="fetchCompanies($('select#company'));"--}}
                                                                {{--                                                                   class="col_short_btn">--}}
                                                                {{--                                                                    <l class="fa fa-refresh"></l>--}}
                                                                {{--                                                                </a>--}}
                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="10" name="company" id="company"
                                                                    {{--                                                                    data-fetch-url="{{ route('api.companies.options') }}"--}}
                                                                    class="inputs_up form-control auto-select company_dropdown" tabindex="0" data-rule-required="true" data-msg-required="Please
                                                                    Enter Company Name"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Company
                                                                </option>
                                                                @foreach ($companies as $company)
                                                                    <option
                                                                        value="{{ $company->account_uid }}"
                                                                        data-company-id="{{ $company->account_uid }}">{{ $company->account_name }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_20">
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
                                                                {{--                                                                @foreach($projects as $project)--}}
                                                                {{--                                                                    <option value="{{$project->proj_id}}" data-grand_total="{{ $project->proj_grand_total }}">{{$project->proj_project_name}}</option>--}}
                                                                {{--                                                                @endforeach--}}
                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->


                                                <div class="invoice_col basis_col_20">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            (Region) Zone
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->
                                                                <a href="{{ route('regions.create') }}"
                                                                   class="col_short_btn"
                                                                   target="_blank">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>

                                                                <a onclick="$('select#company').trigger('change');"
                                                                   class="col_short_btn">
                                                                    <l class="fa fa-refresh"></l>
                                                                </a>
                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="2" name="region" id="region"
                                                                    class="inputs_up form-control"
                                                                    tabindex="4">
                                                                <option value="" selected disabled>
                                                                    Select Company
                                                                    First
                                                                </option>
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->


                                                {{--                                                </div><!-- invoice row end -->--}}


                                            </div><!-- row start -->
                                            <hr>
                                            <div class="invoice_row">
                                                <div class="invoice_col basis_col_15"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl"><!-- invoice column title start -->

                                                            Select Product / Service
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_txt inline_radio"><!-- invoice column input start -->
                                                            <div class="radio">
                                                                <label>
                                                                    <input tabindex="8" type="radio" name="pro_ser" class="invoice_type" id="product_show" value="products" checked>
                                                                    Products
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label>
                                                                    <input tabindex="9" type="radio" name="pro_ser" class="invoice_type" id="services_show" value="services">
                                                                    Services
                                                                </label>
                                                            </div>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div>
                                            <hr>
                                            <div class="invoice_row"><!-- invoice row start -->


                                                <div class="invoice_col basis_col_10">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Region (Zone)
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->


                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                                <a href="{{ route('zones.create') }}" class="col_short_btn">
                                                                    <l class="fa fa-plus"></l>
                                                                </a>
                                                                <a class="col_short_btn" onclick="$('select#region').trigger('change');">
                                                                    <l class="fa fa-refresh"></l>
                                                                </a>
                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="3" name="zone" id="zone" class="custom-select"
                                                                    data-rule-required="true" data-msg-required="Please Choose Zone"
                                                            >
                                                                <option value="" selected disabled>Select Region First</option>
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->


                                                <div class="invoice_col basis_col_12 product_div" hidden>
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Product Code
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="3" name="product_code" id="product_code"
                                                                    class="inputs_up form-control @error('product_code') is-invalid @enderror"
                                                            >
                                                                <option value="0" selected disabled>Product Code</option>

                                                                {{--                                                                    @foreach ($products as $product)--}}
                                                                {{--                                                                        <option--}}
                                                                {{--                                                                            value={{$product->pro_p_code}} data-parent={{$product->pro_p_code}} data-sale_price={{$product->pro_sale_price}} data-tax={{$product->pro_tax}} data-retailer_dis={{$product->pro_retailer_discount}} data-whole_saler_dis={{$product->pro_whole_seller_discount}} data-loyalty_dis={{$product->pro_loyalty_card_discount}} data-unit={{$product->unit_title}}>{{$product->pro_title}}</option>--}}
                                                                {{--                                                                    @endforeach--}}
                                                            </select>


                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->


                                                <div class="invoice_col basis_col_12 product_div">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Product Name
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="3" name="product_name" id="product_name"
                                                                    class="inputs_up form-control @error('product_name') is-invalid @enderror"
                                                            >
                                                                <option value="0" selected disabled>Product</option>

                                                                {{--                                                                    @foreach ($products as $product)--}}
                                                                {{--                                                                        <option--}}
                                                                {{--                                                                            value={{$product->pro_p_code}} data-parent={{$product->pro_p_code}} data-sale_price={{$product->pro_sale_price}} data-tax={{$product->pro_tax}} data-retailer_dis={{$product->pro_retailer_discount}} data-whole_saler_dis={{$product->pro_whole_seller_discount}} data-loyalty_dis={{$product->pro_loyalty_card_discount}} data-unit={{$product->unit_title}}>{{$product->pro_title}}</option>--}}
                                                                {{--                                                                    @endforeach--}}
                                                            </select>


                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_12" id="service_div">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Services
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">

                                                            </div><!-- invoice column short end -->
                                                            <select name="services" id="services"
                                                                    class="inputs_up form-control"
                                                            >
                                                                <option value="0" selected disabled>Services</option>

                                                                {{--                                                                    @foreach ($products as $product)--}}
                                                                {{--                                                                        <option--}}
                                                                {{--                                                                            value={{$product->pro_p_code}} data-parent={{$product->pro_p_code}} data-sale_price={{$product->pro_sale_price}} data-tax={{$product->pro_tax}} data-retailer_dis={{$product->pro_retailer_discount}} data-whole_saler_dis={{$product->pro_whole_seller_discount}} data-loyalty_dis={{$product->pro_loyalty_card_discount}} data-unit={{$product->unit_title}}>{{$product->pro_title}}</option>--}}
                                                                {{--                                                                    @endforeach--}}
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

                                                            Remarks
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="4" type="text" name="order_remarks" class="inputs_up form-control" id="order_remarks" placeholder="Remarks" value=""
                                                                   tabindex="6">


                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_6">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            QTY
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="5" type="text" name="qty" id="qty" class="inputs_up text-right form-control" placeholder="Quantity" tabindex="7">

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_6">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Rate
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="6" type="text" name="rate" id="rate" class="inputs_up text-right form-control" placeholder="Rate">

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_5">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            UOM
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="16" type="text" name="uom" id="uom" class="inputs_up text-right form-control" placeholder="UOM" readonly>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_6">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Amount
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="17" type="text" name="amount" id="amount" class="inputs_up text-right form-control" placeholder="amount" readonly>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_8">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Start Date
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="7" type="text" name="start_date" id="start_date" class="inputs_up form-control datepicker1" autocomplete="off" value=""
                                                                   placeholder="Start Date......" tabindex="1">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_8">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            End Date
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="8" type="text" name="end_date" id="end_date" class="inputs_up form-control datepicker1" autocomplete="off" value=""
                                                                   placeholder="End Date......" tabindex="2">
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
                                                                            <th tabindex="-1" class="text-center tbl_srl_10" hidden>
                                                                                Company
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_10">
                                                                                (Region) Zone
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_10">
                                                                                Region (Zone)
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_10">
                                                                                Type
                                                                            </th>

                                                                            <th tabindex="-1" class="text-center tbl_txt_15">
                                                                                Product
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_srl_10">
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
            let order_title = document.getElementById("order_title"),
                company = document.getElementById("company"),
                project = document.getElementById("project"),
                total_items = document.getElementById("total_items"),
                remaining_amount = document.getElementById("cal_remaining_amount"),
                validateInputIdArray = [
                    order_title.id,
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
        // jQuery("#project").change(function () {
        //     var project = $(this).find(':selected').val();
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "get_company",
        //         data: {project: project},
        //         type: "GET",
        //         cache: false,
        //         dataType: 'json',
        //         success: function (data) {
        //
        //             jQuery("#company").html(" ");
        //             jQuery("#company").append(data.get_company);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {
        //             alert(jqXHR.responseText);
        //             alert(errorThrown);
        //         }
        //     });
        // });

        jQuery("#project").change(function () {
            var project = $(this).find(':selected').val();


            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "get_additional_company_products",
                data: {project: project},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    // console.log(data.products);
                    // console.log(data.calculations);
                    var options = "<option value='' disabled selected>Select Product Code</option>";
                    var option = "<option value='' disabled selected>Select Product Name</option>";

                    $.each(data.products, function (index, value) {
                        options += "<option value='" + value.pro_p_code + "' data-parent='" + value.pro_p_code + "'data-qty='" + value.pro_qty + "' data-sale_price='" + value.pro_sale_price + "' " +
                            "data-tax='" + value.pro_tax + "'data-retailer_dis='" + value.pro_retailer_discount + "' data-whole_saler_dis='" + value.pro_whole_seller_discount + "' data-loyalty_dis='" + value.pro_loyalty_card_discount + "' data-unit='" + value.unit_title + "'>" + value.pro_p_code + "</option>";
                    });

                    $.each(data.products, function (index, value) {
                        option += "<option value='" + value.pro_p_code + "' data-parent='" + value.pro_p_code + "'data-qty='" + value.pro_qty + "' data-sale_price='" + value.pro_sale_price + "' " +
                            "data-tax='" + value.pro_tax + "'data-retailer_dis='" + value.pro_retailer_discount + "' data-whole_saler_dis='" + value.pro_whole_seller_discount + "' data-loyalty_dis='" + value.pro_loyalty_card_discount + "' data-unit='" + value.unit_title + "'>" + value.pro_title + "</option>";
                    });

                    var additional_amount=0;

                    $.each(data.calculations, function (index, value) {
                        additional_amount = +additional_amount + +value.cal_additional_amount;
                    });

                    $('#grand_total').val(additional_amount);
                    document.getElementById("projectTotalAmountView").innerHTML = additional_amount;
                    jQuery("#product_code").html(" ");
                    jQuery("#product_code").append(options);
                    jQuery("#product_name").html(" ");
                    jQuery("#product_name").append(option);

                    var ser_option = "<option value='' disabled selected>Select Service</option>";
                    $.each(data.services, function (index, value) {
                        ser_option += "<option value='" + value.ser_id + "' data-qty='" + value.ser_qty + "' data-rate='" + value.ser_rate + "'>" + value.ser_title + "</option>";
                    });
                    jQuery("#services").html(" ");
                    jQuery("#services").append(ser_option);

                    var consume_amount = 0;
                    $.each(data.calculations, function (index, value) {
                        consume_amount = +value.cal_additional_consume + consume_amount;
                    });

                    jQuery("#remaining_amount").html(" ");
                    jQuery("#consume_amount").html(" ");
                    jQuery("#consume_amount").val(consume_amount);
                    var remaining_amount = additional_amount - consume_amount;
                    jQuery("#remaining_amount").val(remaining_amount);
                    jQuery("#cal_remaining_amount").val(remaining_amount);
                    document.getElementById("consumeTotalAmountView").innerHTML = consume_amount.toFixed(2);
                    document.getElementById("remainingTotalAmountView").innerHTML = remaining_amount.toFixed(2);
                    var remaining_pec = remaining_amount / additional_amount * 100;
                    document.getElementById("remaining_pec").innerHTML = remaining_pec.toFixed(2);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>


    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#project").select2();
            jQuery("#company").select2();
            jQuery("#region").select2();
            jQuery("#zone").select2();
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#services").select2();
            $('#product_div').show();
            $('#service_div').hide();
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

            //region dropdown treat as zone
            //zone dropdown treat as region

            var company_id = document.getElementById("company").value;

            var regions = document.getElementById("zone").value;

            var region_value = document.getElementById("zone").value;
            // var region_value = $('#zone').find(':selected').data('zone-id');


            var zones = document.getElementById("region").value;
            var zone_value = document.getElementById("region").value;
            // var zone_value = $('#region').find(':selected').data('region-id');

            console.log(regions, region_value, zones, zone_value);


            // var regions = document.getElementById("zone").value;
            //
            // var region_value = $('#zone').find(':selected').data('region-id');
            //
            // var zones = document.getElementById("region").value;
            //
            // var zone_value = $('#region').find(':selected').data('zone-id');

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

            var remaining_qty = $('#remaining_qty').val();

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
            if (zones == "0" || zones == "" || zones == "empty") {

                if (focus_once1 == 0) {
                    jQuery("#region").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (zones == "0" || zones == "" || zones == "empty") {

                if (focus_once1 == 0) {
                    jQuery("#region").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (regions == "0" || regions == "" || regions == "empty") {

                if (focus_once1 == 0) {
                    jQuery("#zone").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (regions == "0" || regions == "" || regions == "empty") {

                if (focus_once1 == 0) {
                    jQuery("#zone").focus();
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


            if (qty == 0 || qty == null) {

                if (focus_once1 == 0) {
                    jQuery("#qty").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (remaining_qty < 0) {

                if (focus_once1 == 0) {
                    jQuery("#qty").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (start_date == 0 || qty == null) {

                if (focus_once1 == 0) {
                    jQuery("#start_date").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (end_date == null) {

                if (focus_once1 == 0) {
                    jQuery("#end_date").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete orders[global_id_to_edit];
                }

                counter++;

                jQuery("#company").select2("destroy");
                jQuery("#region").select2("destroy");
                jQuery("#zone").select2("destroy");
                jQuery("#product_name").select2("destroy");
                jQuery("#services").select2("destroy");

                var company_name = jQuery("#company option:selected").text();
                var zone_name = jQuery("#region option:selected").text();
                var region_name = jQuery("#zone option:selected").text();
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
                    'zone_value': zone_value,
                    'zone_name': zone_name,
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
// console.log()
                console.log(orders);
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
                    '<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_10" hidden>' + company_name + '</td><td class="text-left tbl_txt_10">' + zone_name + '</td><td ' +
                    'class="text-left tbl_txt_10">' + region_name + '</td>' +
                    '<td class="text-left tbl_txt_10">' + pro_ser + '</td><td class="text-left ' +
                    'tbl_txt_15">' + pro_serve + '</td><td class="text-left' +
                    'tbl_txt_10">' + order_remarks + '</td><td class="text-left tbl_txt_7">' + qty + '</td><td class="text-left tbl_txt_7">' + rate + '</td><td class="text-left tbl_txt_7">' + uom
                    + '</td><td class="text-left tbl_txt_7">' + amount
                    + '</td><td class="text-left tbl_txt_7">' + start_date
                    + '</td><td class="text-right tbl_srl_7">' + end_date +
                    '<div class="edit_update_bx"><a ' +
                    'class="edit_link btn btn-sm btn-success" href="#" onclick=edit_order(' + counter + ')><i class="fa fa-edit"></i></a> <a href="#" class="delete_link btn btn-sm btn-danger" ' +
                    'onclick=delete_order(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');


                // jQuery('#company option[value="' + 0 + '"]').prop('selected', true);
                // $("#regions option:selected").prop("selected", false)


                jQuery('#services option[value="' + '' + '"]').prop('selected', true);

                if (product_name_value != '' || product_name_value != 0) {
                    jQuery("#product_name option[value=" + product_name_value + "]").attr("disabled", false);
                    jQuery('#product_name option[value="' + '' + '"]').prop('selected', true);
                }


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
                jQuery("#zone").select2();
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
            jQuery("#product_name").select2("destroy");

            jQuery("#company option[value=" + temp_orders['company_id'] + "]").attr("disabled", false);
            if (temp_orders['product_name_value'] != '') {
                jQuery("#product_name option[value=" + temp_orders['product_name_value'] + "]").attr("disabled", false);
            }
            jQuery("#company").select2();
            jQuery("#region").select2();
            jQuery("#zone").select2();
            jQuery("#product_name").select2();

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

            var temp_orders = orders[current_item];

            edit_order_value = temp_orders['company_id'];


            // jQuery("#company").select2("destroy");
            jQuery("#region").select2("destroy");
            jQuery("#zone").select2("destroy");
            jQuery("#product_name").select2("destroy");
            jQuery("#services").select2("destroy");
            // jQuery("#warehouse").select2("destroy");


            // jQuery("#company option[value=" + temp_orders['company_id'] + "]").attr("disabled", false);
            // jQuery("#regions option[value=" + temp_orders['regions'] + "]").attr("disabled", false);
            if (temp_orders['product_name_value'] != '') {
                jQuery("#product_name option[value=" + temp_orders['product_name_value'] + "]").attr("disabled", false);
            }
            // jQuery('#company option[value="' + temp_orders['company_id'] + '"]').prop('selected', true);

            jQuery('#region option[value="' + temp_orders['zone_value'] + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + temp_orders['product_name_value'] + '"]').prop('selected', true);

            jQuery('#services option[value="' + temp_orders['service_value'] + '"]').prop('selected', true);
            // var value = temp_orders['region'];

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
                $('.product_div').hide();
                $('#service_div').show();
            } else if (vala == 'products') {
                jQuery("#product_show").prop("checked", true);
                $('.product_div').show();
                $('#service_div').hide();
                // jQuery("#product_name").select2("destroy");
                // jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
                // jQuery("#product_name").select2();
            }


            // jQuery("#rate").val(temp_orders['product_rate']);
            // jQuery("#amount").val(temp_orders['product_amount']);
            jQuery("#order_remarks").val(temp_orders['order_remarks']);

            get_zone(temp_orders['zone_value']);

            jQuery('#zone option[value="' + temp_orders['region_value'] + '"]').prop('selected', true);



            // jQuery("#company").select2();
            jQuery("#region").select2();
            jQuery("#zone").select2();
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
            jQuery('#zone option[value="' + '' + '"]').prop('selected', true);
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
            // jQuery("#company").select2();
            jQuery("#region").select2();
            jQuery("#zone").select2();
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
        jQuery("#product_code").change(function () {

            var project = $("#project").val();
            var product = $("#product_code").val();
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
                    jQuery("#used_qty").val(data.total_consume_qty);
                    var remaining = data.total_qty - data.total_consume_qty;
                    jQuery("#remaining_qty").val(remaining);
                    jQuery("#dues_qty").val(remaining);
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
        jQuery("#rate").keyup(function () {
            var rate = $(this).val();
            var qty = $('#qty').val();
            var amount = rate * qty;
            $('#amount').val(amount);
        });

    </script>

    <script>
        jQuery("#product_name").change(function () {

            var project = $("#project").val();
            var product = $("#product_name").val();
            $('#product_name option[value="' + product + '"]').prop('selected', true);
            $('#product_code option[value="' + product + '"]').prop('selected', true);
            // $("#product_code").select2();

            var parent_code = jQuery("#product_name option:selected").attr('data-parent');
            var name = $("#product_name option:selected").text();
            // var quantity = 1;
            var unit_measurement = $('option:selected', this).attr('data-unit');
            jQuery("#uom").val(unit_measurement);
            // var bonus_qty = '';
            // var rate = $('option:selected', this).attr('data-sale_price');
            // jQuery("#rate").val(rate);

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
// console.log(data);$rate
                    jQuery("#consume_qty").html(" ");
                    jQuery("#total_qty").html(" ");
                    jQuery("#total_qty").val(data.total_qty);
                    document.getElementById("totalQtyView").innerHTML = data.total_qty;


                    jQuery("#consume_qty").val(data.total_consume_qty);
                    jQuery("#used_qty").val(data.total_consume_qty);
                    var remaining = data.total_qty - data.total_consume_qty;
                    jQuery("#remaining_qty").val(remaining);
                    jQuery("#dues_qty").val(remaining);
                    jQuery("#rate").val(data.rate);

                    document.getElementById("consumeTotalQtyView").innerHTML = data.total_consume_qty;
                    document.getElementById("remainingTotalQtyView").innerHTML = remaining;
                    calculate_used_qty();
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

        function calculate_used_qty() {

            var product = $('#product_name').val();
            var get_array = $('#order_array').val();
            var total_qty = 0;

            if (get_array != '') {
                var make_array = JSON.parse(get_array);

                console.log(Object.keys(make_array).length);

                $.each(make_array, function (index, value) {
                    console.log(index, value)
                    if (value['product_name_value'] == product) {
                        total_qty = +value['qty'] + +total_qty;
                    }
                });


                var total_quantity = jQuery("#total_qty").val();
                var consume_qty = jQuery("#consume_qty").val();
                var consume_qty = +consume_qty + +total_qty;
                var remaining = total_quantity - consume_qty;
                jQuery("#remaining_qty").val(remaining);
                jQuery("#dues_qty").val(remaining);
                jQuery("#used_qty").val(consume_qty);

                document.getElementById("consumeTotalQtyView").innerHTML = consume_qty;
                document.getElementById("remainingTotalQtyView").innerHTML = remaining;

            }
        }
    </script>

    <script>
        function grand_total_calculation() {
            var total_price = 0;

            total_discount = 0;

            jQuery.each(orders, function (index, value) {
                total_price = +total_price + +value['amount'];
            });

            jQuery("#total_price").val(total_price);
        }
    </script>
    {{--    end Order List script--}}
    <script>
        $('#product_show').click(function () {
            $('.product_div').show();
            $('#service_div').hide();
            jQuery("#services").select2("destroy");
            jQuery('#services option[value="' + 0 + '"]').prop('selected', true);
            jQuery("#services").select2();
        });
        $('#services_show').click(function () {
            $('.product_div').hide();
            $('#service_div').show();
            jQuery("#product_name").select2("destroy");
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery("#product_name").select2();
        });
    </script>

    <script>
        jQuery("#services").change(function () {

            var project = $("#project").val();
            var service = $("#services").val();

            $('#services option[value="' + service + '"]').prop('selected', true);
            // $("#product_code").select2();

            // var parent_code = jQuery("#services option:selected").attr('data-parent');
            var name = $("#services option:selected").text();
            // var quantity = 1;
            // var unit_measurement = $('option:selected', this).attr('data-unit');
            jQuery("#uom").val('');
            // var bonus_qty = '';
            var rate = $('option:selected', this).attr('data-rate');
            jQuery("#rate").val(rate);

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_ser_qty",
                data: {service: service, project: project},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#consume_qty").html(" ");
                    jQuery("#total_qty").html(" ");
                    jQuery("#total_qty").val(data.total_qty);

                    document.getElementById("totalQtyView").innerHTML = data.total_qty.toFixed(2);

                    jQuery("#consume_qty").val(data.total_consume_qty);
                    var remaining = data.total_qty - data.total_consume_qty;
                    jQuery("#remaining_qty").val(remaining);


                    document.getElementById("consumeTotalQtyView").innerHTML = data.total_consume_qty.toFixed(2);
                    document.getElementById("remainingTotalQtyView").innerHTML = remaining.toFixed(2);
                    $('#cal_remaining_amount').val(remaining_amount.toFixed(2));
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
            var company = $(this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_projects",
                data: {company: company},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    var option = "<option value='' disabled selected>Select Project</option>";
                    var option_reg = "<option value='' disabled selected>Select Zone</option>";

                    $.each(data.projects, function (index, value) {
                        option += "<option value='" + value.proj_id + "' data-grand_total='" + value.proj_grand_total + "' data-material_total='" + value.proj_material_amount + "'>" + value
                            .proj_project_name + "</option>";
                    });

                    $.each(data.regions, function (index, value) {
                        option_reg += "<option value='" + value.id + "'>" + value.name + "</option>";
                    });

                    jQuery("#project").html(" ");
                    jQuery("#project").append(option);
                    jQuery("#project").select2();

                    jQuery("#region").html(" ");
                    jQuery("#region").append(option_reg);
                    jQuery("#region").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>

    <script>
        $('#region').change(function () {
            var region = $(this).val();
            get_zone(region);
        });

        function get_zone(reg_id) {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_zones",
                data: {reg_id: reg_id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    var option_zone = "<option value='' disabled selected>Select Region</option>";

                    $.each(data.zones, function (index, value) {
                        option_zone += "<option value='" + value.id + "'>" + value.name + "</option>";
                    });

                    jQuery("#zone").html(" ");
                    jQuery("#zone").append(option_zone);
                    jQuery("#zone").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });

        }
    </script>
    <script>
        function calculate_remaining_amount() {
            var grand_total = $('#grand_total').val();
            var total_price = $('#total_price').val();
            var consume_amount = $('#consume_amount').val();
            var remaining_amount = $('#remaining_amount').val();

            consume_amount = +consume_amount + +total_price;
            remaining_amount = remaining_amount - total_price;

            var remaining_pec = remaining_amount / grand_total * 100;
            //alert(remaining_pec);alert(remaining_amount);alert(consume_amount);
            document.getElementById("remaining_pec").innerHTML = remaining_pec.toFixed(2);

            document.getElementById("consumeTotalAmountView").innerHTML = consume_amount.toFixed(2);
            document.getElementById("remainingTotalAmountView").innerHTML = remaining_amount.toFixed(2);
            $('#cal_remaining_amount').val(remaining_amount.toFixed(2));
        }
    </script>

    <script>
        $('#qty').keyup(function () {
            var qty = $(this).val();
            var due_qty = $('#dues_qty').val();
            var used_qty = $('#used_qty').val();
            var total_qty = $('#total_qty').val();
            var consume_qty = +used_qty + +qty;
            var remain_qty = due_qty - qty;
            $('#consume_qty').val(consume_qty);
            $('#remaining_qty').val(remain_qty);

            document.getElementById("consumeTotalQtyView").innerHTML = consume_qty.toFixed(2);
            document.getElementById("remainingTotalQtyView").innerHTML = remain_qty.toFixed(2);
        });
    </script>

@endsection

