@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Sale Order</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <a class="add_btn list_link add_more_button" href="{{ route('sale_order_list') }}" role="button">
                            <i class="fa fa-list"></i> Sale Order
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con"><!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx"><!-- invoice box start -->

                    <form action="{{ route('submit_sale_order') }}" onsubmit="return checkForm()" method="post" autocomplete="off" id="f1">
                        @csrf
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="invoice_cntnt"><!-- invoice content start -->

                                <div class="invoice_row row"><!-- invoice row start -->
                                    <div class="invoice_col basis_col_20"><!-- invoice column -->
                                        <x-party-name-component tabindex="1" name="account_name" id="account_name" class="sale"/>
                                    </div>

                                    <div class="invoice_col basis_col_20"><!-- invoice column start -->
                                        <x-posting-reference tabindex="2"/>
                                    </div>


                                    <div class="invoice_col basis_col_20"><!-- invoice column start -->
                                        <x-posting-reference tabindex="3"/>
                                    </div>

                                    <div class="invoice_col basis_col_23 ml-3"><!-- invoice column start -->
                                        <x-remarks-component tabindex="4" name="remarks" id="remarks" title="Remarks"/>
                                    </div>
                                </div><!-- invoice row end -->

                                <div class="invoice_row row"><!-- invoice row start -->

                                    <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_barcode.description')}}</p>
                                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_barcode.benefits')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Bar Code
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                    <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover"
                                                        data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_product_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                        data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </div><!-- invoice column short end -->
                                            {{--Hamad set tab index--}}
                                                <select tabindex="5" name="product_code" class="inputs_up form-control" id="product_code"
                                                        data-rule-required="true" data-msg-required="Please Enter Bar Code"
                                                >
                                                    <option value="0">Code</option>
                                                    {{--                                                        <option value="0">568741759</option>--}}
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col basis_col_25_5"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.description')}}</p>
                                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.benefits')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Products
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->

                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                    <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover"
                                                        data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_product_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                        data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </div><!-- invoice column short end -->
                                                {{--Hamad set tab index--}}
                                                <select tabindex="6" name="product_name" class="inputs_up form-control" id="product_name"
                                                        data-rule-required="true" data-msg-required="Please Enter Product"
                                                >
                                                    <option value="0">Product</option>
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.description')}}</p>
                                                    <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.benefits')}}</p>
                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Packages
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->

                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                    <a href="{{ url('product_packages') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover"
                                                        data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a id="refresh_package" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                        data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </div><!-- invoice column short end -->
                                                {{--Hamad set tab index--}}
                                                <select tabindex="7" name="package" class="inputs_up form-control js-example-basic-multiple" id="package">
                                                    <option value="0">Select Package</option>
                                                    @foreach($packages as $package)
                                                        <option value="{{$package->pp_id}}">
                                                            {{$package->pp_name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col "><!-- invoice column start -->
                                        <x-warehouse-component tabindex="8" name="warehouse" id="warehouse" class="refresh_warehouse" title="Warehouse"/>
                                    </div>

                                    <div class="invoice_col basis_col_21"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.service.service_title.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Services
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                    <a href="{{ url('add_services') }}" class="col_short_btn"
                                                        target="_blank" data-container="body" data-toggle="popover"
                                                        data-trigger="hover"
                                                        data-placement="bottom" data-html="true"
                                                        data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a id="refresh_service" class="col_short_btn"
                                                        data-container="body" data-toggle="popover"
                                                        data-trigger="hover" data-placement="bottom"
                                                        data-html="true"
                                                        data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </div><!-- invoice column short end -->

                                                {{--Hamad set tab index--}}
                                                <select tabindex="9" name="service_name" class="inputs_up form-control" id="service_name" data-rule-required="true" data-msg-required="Please Enter Service">
                                                    <option value="0">Select Service</option>
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->

                                <div class="invoice_row row"><!-- invoice row start -->
                                            <div class="invoice_col col-lg-12"><!-- invoice column start -->
                                                <div class="pro_tbl_con"><!-- product table container start -->
                                                    <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                                        <table class="table table-bordered table-sm gnrl-mrgn-pdng" id="category_dynamic_table">
                                                            <thead>
                                                            <tr>
                                                                {{--  <th class="tbl_srl_4"> Sr.</th>  --}}
                                                                <th class="tbl_srl_9">Code</th>
                                                                <th class="tbl_txt_17">Title</th>
                                                                <th class="tbl_txt_13">Remarks</th>
                                                                <th class="tbl_txt_13"> Warehouse</th>
                                                                <th class="tbl_srl_4">Qty</th>
                                                                <th class="tbl_srl_4">UOM</th>
                                                                <th class="tbl_srl_5">Bonus</th>
                                                                <th class="tbl_srl_6">Rate</th>
                                                                <th class="tbl_srl_4">Dis%</th>
                                                                <th class="tbl_srl_7">Dis Amount</th>
                                                                <th class="tbl_srl_4">Tax%</th>
                                                                <th class="tbl_srl_10">Tax Amount</th>
                                                                <th class="tbl_srl_4" hidden>Inclu</th>
                                                                <th class="tbl_srl_12">Amount</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="table_body">

                                                            </tbody>
                                                        </table>
                                                    </div><!-- product table box end -->
                                                </div><!-- product table container end -->
                                            </div><!-- invoice column end -->
 <div class="invoice_col basis_col_18"><!-- invoice column start -->

                                        <div class="invoice_row row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.description')}}</p>
                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.benefits')}}</p>
                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Invoice Type
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <div class="radio">
                                                            <label>

                                                                <input type="radio" name="invoice_type" class="invoice_type" id="invoice_type1" value="1" checked>
                                                                Non Tax Invoice
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="invoice_type" class="invoice_type" id="invoice_type2" value="2">
                                                                Tax Invoice
                                                            </label>
                                                        </div>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="left" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.description')}}</p>
                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.benefits')}}</p>
                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Round OFF Discount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <div class="custom-checkbox float-left">
                                                            <input type="checkbox" name="round_off" class="custom-control-input company_info_check_box" id="round_off" value="1"
                                                                    onchange="grand_total_calculation();">
                                                            <label class="custom-control-label chck_pdng" for="round_off"> Auto Round OFF </label>
                                                            <input type="hidden" name="round_off_discount" id="round_off_discount"/>
                                                        </div>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->


                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).description')}}</p>
                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).benefits')}}</p>
                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Items Discount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl" for="total_product_discount">
                                                                Product Dis
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text" name="total_product_discount" class="inputs_up form-control text-right" id="total_product_discount" readonly>
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->


                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="left" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.description')}}</p>
                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.benefits')}}</p>
                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Tax
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl" for="total_inclusive_tax">
                                                                Inclusive Tax
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text" name="total_inclusive_tax" class="inputs_up form-control text-right" id="total_inclusive_tax" readonly>
                                                            </div>
                                                        </div><!-- invoice inline input text end -->
                                                        <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl" for="total_exclusive_tax">
                                                                Exclusive Tax
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text" name="total_exclusive_tax" class="inputs_up form-control text-right" id="total_exclusive_tax" readonly>
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->


                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->

                                <div class="invoice_row row"><!-- invoice row start -->

                                    <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Cash_Discount.description')}}</p>
                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.Cash_Discount.benefits')}}</p>
                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.Cash_Discount.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Cash Discount
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_txt"><!-- invoice column input start -->

                                                <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl" for="disc_percentage">
                                                        Discount %
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text" name="disc_percentage" class="inputs_up form-control text-right percentage_textbox" id="disc_percentage"
                                                                placeholder="In percentage" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="grand_total_calculation();"
                                                                onfocus="this.select();">
                                                    </div>
                                                </div><!-- invoice inline input text end -->

                                                <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl" for="disc_amount">
                                                        Discount (Rs.)
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text" name="disc_amount" class="inputs_up form-control text-right" id="disc_amount"
                                                                onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="grand_total_calculation_with_disc_amount();"
                                                                onfocus="this.select();">
                                                    </div>
                                                </div><!-- invoice inline input text end -->

                                                <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl" for="service_total_exclusive_tax">
                                                        Total Discount
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text" name="total_discount" class="inputs_up form-control text-right" id="total_discount" readonly>
                                                    </div>
                                                </div><!-- invoice inline input text end -->

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Total(Total_Item/Sub_Total/Total_Taxes).description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Total
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_txt"><!-- invoice column input start -->

                                                <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl" for="total_items">
                                                        Total Items
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text" name="total_items" class="inputs_up form-control text-right total-items-field"
                                                                data-rule-required="true" data-msg-required="Add Item"
                                                                id="total_items" readonly>

                                                    </div>
                                                </div><!-- invoice inline input text end -->

                                                <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl" for="total_price">
                                                        Sub Total
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text" name="total_price" class="inputs_up form-control text-right"
                                                                data-rule-required="true" data-msg-required="Add Sub Total"
                                                                id="total_price" readonly>

                                                    </div>
                                                </div><!-- invoice inline input text end -->

                                                <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl" for="total_tax">
                                                        Total Taxes
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text" name="total_tax" class="inputs_up form-control text-right" id="total_tax" readonly>

                                                    </div>
                                                </div><!-- invoice inline input text end -->

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col basis_col_27"><!-- invoice column start -->
                                        <div class="invoice_row row"><!-- invoice row start -->


                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Discount_Type.description')}}</p>
                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.Discount_Type.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Discount Type
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <div class="invoice_inline_input_txt with_wrap">

                                                            <div class="radio">
                                                                <label for="discount_type1">
                                                                    <input type="radio" name="discount_type" class="discount_type" id="discount_type1" value="1" checked>
                                                                    Non
                                                                </label>
                                                            </div>

                                                            <div class="radio">
                                                                <label for="discount_type2">
                                                                    <input type="radio" name="discount_type" class="discount_type" id="discount_type2" value="2">
                                                                    Retailer
                                                                </label>
                                                            </div>

                                                            <div class="radio">
                                                                <label for="discount_type3">
                                                                    <input type="radio" name="discount_type" class="discount_type" id="discount_type3" value="3">
                                                                    Wholesaler
                                                                </label>
                                                            </div>

                                                            <div class="radio">
                                                                <label for="discount_type4">
                                                                    <input type="radio" name="discount_type" class="discount_type" id="discount_type4" value="4">
                                                                    Loyalty Card
                                                                </label>
                                                            </div>


                                                        </div>

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <label class=" invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.grand_total.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Grand Total
                                                    </label><!-- invoice column title end -->
                                                    <div class="invoice_col_txt ghiki"><!-- invoice column input start -->
                                                        <h5 id="grand_total_text">
                                                            {{--1,450,304,074.17--}}
                                                            000,000
                                                        </h5>

                                                        <input type="hidden" name="grand_total" id="grand_total"/>

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                        </div><!-- invoice row end -->
                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->

                                <div class="invoice_row row"><!-- invoice row start -->

                                    <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                        <div class="invoice_col_txt with_cntr_jstfy"><!-- invoice column box start -->
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button id="clear_discount_btn" type="button" class="invoice_frm_btn">
                                                    Clear Discount
                                                </button>
                                            </div>
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button type="submit" class="invoice_frm_btn" name="save" id="save"
                                                >
                                                    Save (Ctrl+S)
                                                </button>
                                                <span id="check_product_count" class="validate_sign"></span>
                                            </div>
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button id="all_clear_form" type="button" class="invoice_frm_btn">
                                                    Clear (Ctrl+X)
                                                </button>
                                            </div>
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->


                                </div><!-- invoice row end -->

                            </div><!-- invoice content end -->
                        </div><!-- invoice scroll box end -->
                    </form>

                </div><!-- invoice box end -->
            </div><!-- invoice container end -->


        </div> <!-- white column form ends here -->
    </div><!-- row end -->
    <div class="invoice_overlay"></div>
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let account_name = document.getElementById("account_name"),
                // product_code = document.getElementById("product_code"),
                // product_name = document.getElementById("product_name"),
                // warehouse = document.getElementById("warehouse"),
                // service_name = document.getElementById("service_name"),
                total_items = document.getElementById("total_items"),
                total_price = document.getElementById("total_price"),
                validateInputIdArray = [
                    account_name.id,
                    // product_code.id,
                    // product_name.id,
                    // warehouse.id,
                    // service_name.id,
                    total_items.id,
                    total_price.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        jQuery("#refresh_package").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_packages",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#package").html(" ");
                    jQuery("#package").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });


        /// product code and name refresh ajax
        jQuery("#refresh_product_code").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_sale_product_code",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#product_code").html(" ");
                    jQuery("#product_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_product_code").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_sale_product_name",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#product_name").html(" ");
                    jQuery("#product_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_product_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_sale_product_code",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#product_code").html(" ");
                    jQuery("#product_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_product_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_sale_product_name",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#product_name").html(" ");
                    jQuery("#product_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_warehouse").click(function () {
// alert('warehouse');
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_warehouse",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#warehouse").html(" ");
                    jQuery("#warehouse").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);s
                }
            });
        });

        jQuery("#refresh_service").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_service",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#service_name").html(" ");
                    jQuery("#service_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

    <script>
        function popvalidation() {

            var account_name = $("#account_name").val();
            var total_items = $("#total_items").val();

            var flag_submit = true;
            var focus_once = 0;

            if (account_name.trim() == "0") {


                if (focus_once == 0) {
                    jQuery("#account_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            if (total_items == 0) {

                if (product_code == "0") {

                    if (focus_once == 0) {
                        jQuery("#product_code").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (product_name == "0") {
                    if (focus_once == 0) {
                        jQuery("#product_name").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                document.getElementById("check_product_count").innerHTML = "Add Items";
                flag_submit = false;
            } else {
                document.getElementById("check_product_count").innerHTML = "";
            }

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;
            var quantity;
            var rate;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                quantity = +jQuery("#quantity" + pro_field_id).val();
                rate = jQuery("#rate" + pro_field_id).val();

                if (quantity < 1 || quantity == "") {
                    if (focus_once == 0) {
                        jQuery("#quantity" + pro_field_id).focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (rate == "0" || rate == "") {
                    if (focus_once == 0) {
                        jQuery("#rate" + pro_field_id).focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            });

            return flag_submit;
        }


    </script>

    {{--//////////////////////////////////////////////////////////////////// Start Sale Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}
    <script>
        // adding sales into table
        var counter = 0;
        var total_discount = 0;

        function product_amount_calculation(id) {

            var quantity = jQuery("#quantity" + id).val();
            var rate = jQuery("#rate" + id).val();
            var product_discount = jQuery("#product_discount" + id).val();
            var product_sales_tax = jQuery("#product_sales_tax" + id).val();

            if (quantity == "") {
                quantity = 0;
            }

            var product_sale_tax_amount;
            var product_rate_after_discount;
            var product_inclusive_rate;
            var product_discount_amount;

            if ($("#inclusive_exclusive" + id).prop("checked") == true) {
                jQuery("#inclusive_exclusive_status_value" + id).val(1);

                product_discount_amount = (((rate / (+product_sales_tax + +100) * 100)) * product_discount / 100) * quantity;

                product_rate_after_discount = rate - (product_discount_amount / quantity);

                product_inclusive_rate = ((rate / (+product_sales_tax + +100)) * 100) - ((rate / (+product_sales_tax + +100)) * 100) * product_discount / 100;

                product_sale_tax_amount = (rate - ((rate / (+product_sales_tax + +100)) * 100)) * quantity;

            } else {
                jQuery("#inclusive_exclusive_status_value" + id).val(0);

                product_discount_amount = (rate * product_discount / 100) * quantity;

                product_rate_after_discount = rate - (product_discount_amount / quantity);

                product_inclusive_rate = product_rate_after_discount;

                product_sale_tax_amount = (product_rate_after_discount * product_sales_tax / 100) * quantity;
            }

            var amount = (quantity * product_inclusive_rate) + product_sale_tax_amount;

            jQuery("#amount" + id).val(amount.toFixed(2));
            jQuery("#product_sale_tax_amount" + id).val(product_sale_tax_amount.toFixed(2));
            jQuery("#product_inclusive_rate" + id).val(product_inclusive_rate.toFixed(2));
            jQuery("#product_discount_amount" + id).val(product_discount_amount.toFixed(2));

            grand_total_calculation();
        }

        function grand_total_calculation() {

            var disc_percentage = jQuery("#disc_percentage").val();

            var total_price = 0;
            var total_product_discount = 0;
            var total_inclusive_sale_tax_amount = 0;
            var total_exclusive_sale_tax_amount = 0;
            var total_sale_tax_amount = 0;
            var grand_total = 0;
            var round_off_discount = 0;
            var disc_percentage_amount = 0;


            var product_quantity;
            var product_rate;
            var product_discount_amount = 0;
            var product_sale_tax_amount = 0;
            var product_amount = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#quantity" + pro_field_id).val();
                product_rate = jQuery("#rate" + pro_field_id).val();
                product_discount_amount = jQuery("#product_discount_amount" + pro_field_id).val();
                product_sale_tax_amount = jQuery("#product_sale_tax_amount" + pro_field_id).val();
                product_amount = jQuery("#amount" + pro_field_id).val();

                total_price = +total_price + +(product_rate * product_quantity);
                total_product_discount = +total_product_discount + +product_discount_amount;

                if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                    total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                } else {
                    total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                }

                total_sale_tax_amount = +total_sale_tax_amount + +product_sale_tax_amount;

                grand_total = +grand_total + +product_amount;
            });

            disc_percentage_amount = (total_price * disc_percentage) / 100;

            total_discount = +total_product_discount + +disc_percentage_amount;

            grand_total = +(total_price - total_discount) + +total_exclusive_sale_tax_amount;

            var radioValue = $("input[name='round_off']:checked").val();

            if (radioValue == 1) {
                round_off_discount = grand_total - Math.round(grand_total);
            }

            total_discount = +total_discount + +round_off_discount;

            grand_total = grand_total - round_off_discount;

            jQuery("#total_price").val(total_price.toFixed(2));
            jQuery("#total_product_discount").val(total_product_discount.toFixed(2));
            jQuery("#round_off_discount").val(round_off_discount.toFixed(2));
            jQuery("#disc_amount").val(disc_percentage_amount.toFixed(2));
            jQuery("#total_discount").val(total_discount.toFixed(2));
            jQuery("#total_inclusive_tax").val(total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_exclusive_tax").val(total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_tax").val(total_sale_tax_amount.toFixed(2));
            jQuery("#grand_total").val(grand_total.toFixed(2));

            var total_items = $('input[name="pro_code[]"]').length;

            jQuery("#total_items").val(total_items);
            $("#grand_total_text").text(grand_total.toFixed(2));
        }

        function grand_total_calculation_with_disc_amount() {

            var disc_percentage = 0;
            var disc_amount = jQuery("#disc_amount").val();

            var total_price = 0;
            var total_product_discount = 0;
            var total_inclusive_sale_tax_amount = 0;
            var total_exclusive_sale_tax_amount = 0;
            var total_sale_tax_amount = 0;
            var grand_total = 0;
            var round_off_discount = 0;
            var disc_percentage_amount = disc_amount;


            var product_quantity;
            var product_rate;
            var product_discount_amount = 0;
            var product_sale_tax_amount = 0;
            var product_amount = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#quantity" + pro_field_id).val();
                product_rate = jQuery("#rate" + pro_field_id).val();
                product_discount_amount = jQuery("#product_discount_amount" + pro_field_id).val();
                product_sale_tax_amount = jQuery("#product_sale_tax_amount" + pro_field_id).val();
                product_amount = jQuery("#amount" + pro_field_id).val();

                total_price = +total_price + +(product_rate * product_quantity);
                total_product_discount = +total_product_discount + +product_discount_amount;

                if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                    total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                } else {
                    total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                }

                total_sale_tax_amount = +total_sale_tax_amount + +product_sale_tax_amount;

                grand_total = +grand_total + +product_amount;
            });

            disc_percentage = (disc_amount * 100) / total_price;

            total_discount = +total_product_discount + +disc_percentage_amount;

            grand_total = +(total_price - total_discount) + +total_exclusive_sale_tax_amount;

            var radioValue = $("input[name='round_off']:checked").val();

            if (radioValue == 1) {
                round_off_discount = grand_total - Math.round(grand_total);
            }

            total_discount = +total_discount + +round_off_discount;

            grand_total = grand_total - round_off_discount;

            jQuery("#total_price").val(total_price.toFixed(2));
            jQuery("#total_product_discount").val(total_product_discount.toFixed(2));
            jQuery("#round_off_discount").val(round_off_discount.toFixed(2));
            jQuery("#disc_percentage").val(disc_percentage.toFixed(2));
            jQuery("#total_discount").val(total_discount.toFixed(2));
            jQuery("#total_inclusive_tax").val(total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_exclusive_tax").val(total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_tax").val(total_sale_tax_amount.toFixed(2));
            jQuery("#grand_total").val(grand_total.toFixed(2));

            var total_items = $('input[name="pro_code[]"]').length;

            jQuery("#total_items").val(total_items);
            $("#grand_total_text").text(grand_total.toFixed(2));
        }

        jQuery("#service_name").change(function () {

            counter++;
            add_first_item();
            var parent_code = $(this).val();
            var name = $("#service_name option:selected").text();
            var quantity = 1;
            var unit_measurement = '';
            var bonus_qty = '';
            var rate = 0;
            var inclusive_rate = 0;
            var discount = 0;
            var discount_amount = 0;
            var sales_tax = 0;
            var sale_tax_amount = 0;
            var amount = 0;
            var remarks = '';
            var rate_after_discount = 0;
            var inclusive_exclusive = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;


            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                if (pro_code == parent_code) {
                    quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                    bonus_qty = '';
                    rate = jQuery("#rate" + pro_field_id).val();
                    discount = jQuery("#product_discount" + pro_field_id).val();
                    sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                        inclusive_exclusive = 1;
                    }
                    delete_sale(pro_field_id);
                }
            });


            add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 1, unit_measurement);

            product_amount_calculation(counter);
        });

        jQuery("#product_code").change(function () {

            counter++;
            add_first_item();
            var code = $(this).val();

            // $("#product_name").select2("destroy");
            $('#product_name option[value="' + code + '"]').prop('selected', true);
            // $("#product_name").select2();

            var parent_code = jQuery("#product_code option:selected").attr('data-parent');
            var name = $("#product_name option:selected").text();
            var quantity = 1;
            var unit_measurement = $('option:selected', this).attr('data-unit');
            var scale_size = $('option:selected', this).attr('data-unit_scale_size');
            var bonus_qty = '';
            var rate = $('option:selected', this).attr('data-sale_price');
            var inclusive_rate = 0;
            var discount = 0;
            var discount_amount = 0;
            var sales_tax = $('option:selected', this).attr('data-tax');
            var sale_tax_amount = 0;
            var amount = 0;
            var remarks = '';
            var rate_after_discount = 0;
            var inclusive_exclusive = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;


            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                if (pro_code == parent_code) {
                    quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                    bonus_qty = jQuery("#bonus" + pro_field_id).val();
                    rate = jQuery("#rate" + pro_field_id).val();
                    discount = jQuery("#product_discount" + pro_field_id).val();
                    sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                        inclusive_exclusive = 1;
                    }

                    delete_sale(pro_field_id);
                }
            });


            if ($(".invoice_type").is(':checked')) {
                if ($(".invoice_type:checked").val() == 1) {
                    sales_tax = 0;
                }
            }

            if ($(".discount_type").is(':checked')) {
                if ($(".discount_type:checked").val() == 1) {
                    discount = 0;
                } else if ($(".discount_type:checked").val() == 2) {
                    discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
                } else if ($(".discount_type:checked").val() == 3) {
                    discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
                } else if ($(".discount_type:checked").val() == 4) {
                    discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
                }
            }

            add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 0, unit_measurement,scale_size);

            product_amount_calculation(counter);
        });

        jQuery("#product_name").change(function () {
            counter++;
            add_first_item();
            var code = $(this).val();

            // $("#product_code").select2("destroy");
            $('#product_code option[value="' + code + '"]').prop('selected', true);
            // $("#product_code").select2();

            var parent_code = jQuery("#product_name option:selected").attr('data-parent');
            var name = $("#product_name option:selected").text();
            var quantity = 1;
            var unit_measurement = $('option:selected', this).attr('data-unit');
            var scale_size = $('option:selected', this).attr('data-unit_scale_size');

            var bonus_qty = '';
            var rate = $('option:selected', this).attr('data-sale_price');
            var inclusive_rate = 0;
            var discount = 0;
            var discount_amount = 0;
            var sales_tax = $('option:selected', this).attr('data-tax');
            var sale_tax_amount = 0;
            var amount = 0;
            var remarks = '';
            var rate_after_discount = 0;
            var inclusive_exclusive = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;


            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                if (pro_code == parent_code) {
                    quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                    bonus_qty = jQuery("#bonus" + pro_field_id).val();
                    rate = jQuery("#rate" + pro_field_id).val();
                    discount = jQuery("#product_discount" + pro_field_id).val();
                    sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                        inclusive_exclusive = 1;
                    }

                    delete_sale(pro_field_id);
                }
            });


            if ($(".invoice_type").is(':checked')) {
                if ($(".invoice_type:checked").val() == 1) {
                    sales_tax = 0;
                }
            }

            if ($(".discount_type").is(':checked')) {
                if ($(".discount_type:checked").val() == 1) {
                    discount = 0;
                } else if ($(".discount_type:checked").val() == 2) {
                    discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
                } else if ($(".discount_type:checked").val() == 3) {
                    discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
                } else if ($(".discount_type:checked").val() == 4) {
                    discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
                }
            }

            add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 0, unit_measurement,scale_size);

            product_amount_calculation(counter);
        });

        jQuery('.discount_type').change(function () {

            if ($(this).is(':checked')) {
                add_first_item();

                var discount = 0;

                var pro_code;
                var pro_field_id_title;
                var pro_field_id;

                $('input[name="pro_code[]"]').each(function (pro_index) {

                    pro_code = $(this).val();
                    pro_field_id_title = $(this).attr('id');
                    pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                    jQuery('#product_code option[value="' + pro_code + '"]').prop('selected', true);

                    if ($(".discount_type").is(':checked')) {
                        if ($(".discount_type:checked").val() == 1) {
                            discount = 0;
                        } else if ($(".discount_type:checked").val() == 2) {
                            discount = jQuery('#product_code option:selected').attr('data-retailer_dis');
                        } else if ($(".discount_type:checked").val() == 3) {
                            discount = jQuery('#product_code option:selected').attr('data-whole_saler_dis');
                        } else if ($(".discount_type:checked").val() == 4) {
                            discount = jQuery('#product_code option:selected').attr('data-loyalty_dis');
                        }
                    }

                    jQuery("#product_discount" + pro_field_id).val(discount);
                    product_amount_calculation(pro_field_id);
                });
                jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            }
        });

        jQuery("#clear_discount_btn").click(function () {
            var discount = 0;
            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                jQuery('#product_code option[value="' + pro_code + '"]').prop('selected', true);

                jQuery("#product_discount" + pro_field_id).val(discount);
                product_amount_calculation(pro_field_id);
            });
            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
        });

        jQuery("#all_clear_form").click(function () {
            jQuery("#table_body").html("");
            grand_total_calculation();

            jQuery("#sale_person").val("0").trigger('change');
            jQuery("#account_name").val("0").trigger('change');
            jQuery("#remarks").val("");

            jQuery("#machine").val("0").trigger('change');
            jQuery("#credit_card_number").val("");
            jQuery("#credit_card_amount").val("");

            jQuery("#customer_name").val("");
            jQuery("#customer_email").val("");
            jQuery("#customer_phone_number").val("");

            jQuery("#cash_received_from_customer").val("");
            jQuery("#invoice_cash_received").val("");
            jQuery("#invoice_cash_return").val("");

            jQuery("#cash_paid").val("");
            jQuery("#credit_card_amount_view").val("");
            jQuery("#cash_return").val("");
        });

        jQuery("#package").change(function () {

            var id = jQuery('option:selected', this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "{{ route('get_product_packages_details') }}",
                data: {id: id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    $.each(data, function (index, value) {
                        counter++;

                        var parent_code = value['ppi_product_code'];
                        jQuery('#product_name option[value="' + parent_code + '"]').prop('selected', true);
                        var name = $("#product_name option:selected").text();
                        var quantity = value['ppi_qty'];
                        var unit_measurement = $("#product_name option:selected").attr('data-unit');
                        var scale_size = $("#product_name option:selected").attr('ppi_scale_size');
                        var bonus_qty = '';
                        var rate = value['ppi_rate'];
                        var inclusive_rate = 0;
                        var discount = 0;
                        var discount_amount = 0;
                        var sales_tax = 0;
                        var sale_tax_amount = 0;
                        var amount = 0;
                        var remarks = value['ppi_remarks'];
                        var rate_after_discount = 0;
                        var inclusive_exclusive = 0;

                        var pro_code;
                        var pro_field_id_title;
                        var pro_field_id;

                        $('input[name="pro_code[]"]').each(function (pro_index) {
                            pro_code = $(this).val();
                            pro_field_id_title = $(this).attr('id');
                            pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                            if (pro_code == parent_code) {
                                quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                                bonus_qty = jQuery("#bonus" + pro_field_id).val();
                                rate = jQuery("#rate" + pro_field_id).val();
                                discount = jQuery("#product_discount" + pro_field_id).val();
                                sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                                if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                                    inclusive_exclusive = 1;
                                }

                                delete_sale(pro_field_id);
                            }
                        });

                        if ($(".invoice_type").is(':checked')) {
                            if ($(".invoice_type:checked").val() == 1) {
                                sales_tax = 0;
                            }
                        }

                        if ($(".discount_type").is(':checked')) {
                            if ($(".discount_type:checked").val() == 1) {
                                discount = 0;
                            } else if ($(".discount_type:checked").val() == 2) {
                                discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
                            } else if ($(".discount_type:checked").val() == 3) {
                                discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
                            } else if ($(".discount_type:checked").val() == 4) {
                                discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
                            }
                        }

                        add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount,
                            inclusive_exclusive, counter, 0, unit_measurement,scale_size);

                        product_amount_calculation(counter);

                    });

                    jQuery("#package").select2("destroy");
                    jQuery('#package option[value="' + 0 + '"]').prop('selected', true);
                    jQuery("#package").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

        function duplicate_warehouse_dropdown(counter) {
            //Clone the DropDownList
            var ddl = $("#warehouse").clone();

            //Set the ID and Name
            ddl.attr("id", "warehouse" + counter);
            ddl.attr("name", "warehouse[]");

            //[OPTIONAL] Copy the selected value
            var selectedValue = $("#warehouse option:selected").val();
            ddl.find("option[value = '" + selectedValue + "']").attr("selected", "selected");

            //Append to the DIV.
            $("#warehouse_div_col" + counter).append(ddl);

            $("#warehouse" + counter).removeClass("js-example-basic-multiple select2-hidden-accessible");
            $("#warehouse" + counter).removeAttr("href");

            // setTimeout(function() {
            //     jQuery("#warehouse" + counter).select2();
            // }, 1000);
        }

        function add_sale(code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                          counter, product_or_service_status, unit_measurement,scale_size) {

            var inclusive_exclusive_status = '';
            var bonus_qty_status = '';
            if (inclusive_exclusive == 1) {
                inclusive_exclusive_status = 'checked';
            }

            if (product_or_service_status == 1) {
                bonus_qty_status = 'readonly';
            }


            jQuery("#table_body").append('<tr class="edit_update" id="table_row' + counter + '">' +
                // '<td class="tbl_srl_4">02</td> ' +
                '<td class="tbl_srl_9">' +
                '<input type="hidden" name="product_or_service_status[]" id="product_or_service_status' + counter + '" placeholder="Status" ' + 'class="inputs_up_tbl" value="' +
                product_or_service_status + '" readonly/>' +
                '<input type="text" name="pro_code[]" id="pro_code' + counter + '" placeholder="Code" ' + 'class="inputs_up_tbl" value="' + code + '" readonly/>' +
                '</td> ' +
                '<td class="text-left tbl_txt_17">' +
                '<input type="text" name="pro_name[]" id="pro_name' + counter + '" placeholder="Name" ' + 'class="inputs_up_tbl" value="' + name + '" readonly/>' +
                '</td> ' +
                '<td class="text-left tbl_txt_13">' +
                '<input type="text" name="product_remarks[]" id="product_remarks' + counter + '" placeholder="Remarks" ' + 'class="inputs_up_tbl" value="' + remarks + '"/>' +
                '</td>' +
                '<td class="text-left tbl_txt_13" id="warehouse_div_col' + counter + '">' +
                '</td>' +
                '<td class="tbl_srl_4">' +
                '<input type="text" name="quantity[]" id="quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                quantity + '" onfocus="this.select();" onkeypress="return allowOnlyNumber(event);"/>' +
                '</td>' +
                '<td class="tbl_srl_4">' +
                '<input type="text" name="unit_measurement[]" id="unit_measurement' + counter + '" placeholder="UOM" value="' + unit_measurement + '" readonly/>' +
                '</td>' +
                '<td class="tbl_srl_5"> ' +
                '<input type="text" name="bonus[]" id="bonus' + counter + '" placeholder="Bonus" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                bonus_qty + '" onfocus="this.select();" onkeypress="return allowOnlyNumber(event);" ' + bonus_qty_status + '/> ' +
                '</td> ' +
                '<td class="text-right tbl_srl_6"> ' +
                '<input type="text" name="rate[]" id="rate' + counter + '" ' + 'placeholder="Rate" class="inputs_up_tbl text-right" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                rate + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                '<input type="hidden" name="product_inclusive_rate[]" class="inputs_up ' + 'text-right form-control" id="product_inclusive_rate' + counter + '"  value="' + inclusive_rate + '"> ' +
                '</td> ' +

                '<td class="tbl_srl_4" hidden>' +
                '<input type="text" name="unit_measurement_scale_size[]" class="inputs_up_tbl" id="unit_measurement_scale_size' + counter + '" placeholder="Scale Size" value="' + scale_size + '" readonly/>' +
                '</td>' +

                '<td class="tbl_srl_4"> ' +
                '<input type="text" name="product_discount[]" id="product_discount' + counter + '" placeholder="Dis%" class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" ' +
                'value="' + discount + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                // '</td> <td class="text-right tbl_srl_7"> ' +
                // '<input type="text" name="product_discount_amount[]" id="product_discount_amount' + counter + '" placeholder="Dis Amount" value="' + discount_amount + '" class="inputs_up_tbl text-right" ' +
                // 'readonly/> ' +

                '</td> <td class="tbl_srl_4"> ' +
                '<input type="text" name="product_sales_tax[]" id="product_sales_tax' + counter + '" placeholder="Tax%" class="inputs_up_tbl" value="' + sales_tax + '" ' +
                'onkeyup="product_amount_calculation(' + counter + ')" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                '</td> ' +
                '<td class="text-right tbl_srl_10"> ' +
                '<input type="text" name="product_sale_tax_amount[]" id="product_sale_tax_amount' + counter + '" placeholder="Tax Amount" value="' + sale_tax_amount + '" class="inputs_up_tbl text-right" readonly/> ' +
                '</td> ' +
                '<td hidden  class="tbl_srl_4"> <input type="checkbox" name="inclusive_exclusive[]" id="inclusive_exclusive' + counter + '" onclick="product_amount_calculation(' + counter + ');' +
                '"' + inclusive_exclusive_status + ' value="1"/> ' +
                '<input type="hidden" name="inclusive_exclusive_status_value[]" id="inclusive_exclusive_status_value' + counter + '"' + 'value="' + inclusive_exclusive + '"/> ' +
                '</td> ' +
                '<td class="text-right tbl_srl_12"> ' +
                '<input type="text" name="amount[]" id="amount' + counter + '" placeholder="Amount" class="inputs_up_tbl text-right" value="' + amount + '" readonly/> ' +
                '<div class="edit_update_bx"> <div class="inc_dec_con">' +
                '<div class="inc_dec_bx for_inc"><i class="fa fa-plus" onclick=increase_quantity(' + counter + ')></i></div>' +
                '<div class="inc_dec_bx for_val">1</div>' +
                '<div class="inc_dec_bx for_dec"><i class="fa fa-minus" onclick=decrease_quantity(' + counter + ')></i></div>' +
                '</div> ' +
                '<a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i> </a> ' +
                '</div> ' +
                '</td> ' +
                '</tr>');


            if (product_or_service_status != 1) {
                duplicate_warehouse_dropdown(counter);
            }

            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#service_name option[value="' + 0 + '"]').prop('selected', true);

            grand_total_calculation();
            check_invoice_type();
        }

        function delete_sale(current_item) {

            jQuery("#table_row" + current_item).remove();

            grand_total_calculation();
            check_invoice_type();
        }

        function increase_quantity(current_item) {

            var previous_qty = jQuery("#quantity" + current_item).val();
            var new_quantity = 1;
            if (previous_qty >= 0) {
                new_quantity = +previous_qty + +1;
            }

            jQuery("#quantity" + current_item).val(new_quantity);

            product_amount_calculation(current_item);
        }

        function decrease_quantity(current_item) {

            var previous_qty = jQuery("#quantity" + current_item).val();
            var new_quantity = 1;
            if (previous_qty >= 0) {
                new_quantity = previous_qty - 1;
            }

            jQuery("#quantity" + current_item).val(new_quantity);

            product_amount_calculation(current_item);
        }

        function add_first_item() {
            var total_items = $('input[name="pro_code[]"]').length;

            if (total_items <= 0 || total_items == '') {
                jQuery("#table_body").html("");
            }
        }

        function check_invoice_type() {
            var total_items = $("#total_items").val();

            if (total_items == 0 || total_items == "") {
                $('.invoice_type:not(:checked)').attr('disabled', false);
            } else {
                $('.invoice_type:not(:checked)').attr('disabled', true);
            }
        }

        $('#account_name').on('change', function (event) {

            var disc_type = jQuery('option:selected', this).attr('data-disc_type');

            if (disc_type == 0) {
                disc_type = 1;
            }

            $(".discount_type").prop("checked", false);
            $("#discount_type" + disc_type).prop("checked", true);

            $(".discount_type").trigger("change");

            var limit_status = jQuery('option:selected', this).attr("data-limit_status");
            var limit = jQuery('option:selected', this).attr("data-limit");
            var current_credit = 0;
            var remaining_credit = 0,
                BASE_URL = '{{ url('/') }}';

            event.preventDefault();

            if (limit_status == 0) {

                var account_code = $(this).val();

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.ajax({
                    url: "{{ route('get_credit_limit') }}",
                    data: {account_code: account_code},
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {

                        current_credit = data;

                        remaining_credit = limit - current_credit;

                        Swal.fire({
                            html: '<table class="table table-bordered table-sm border-0">' +
                                '<tbody>' +
                                '<tr>' +
                                '<td scope="col" align="center" class="text-left align_left tbl_txt_70 border-0">Credit Limit</td>' +
                                '<td scope="col" align="center" class="text-right align_right tbl_txt_30 border-0">' + limit + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td scope="col" align="center" class="text-left align_left tbl_txt_70 border-0">Current Balance</td>' +
                                '<td scope="col" align="center" class="text-right align_right tbl_txt_30 border-0">' + current_credit + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td scope="col" align="center" class="text-left align_left tbl_txt_70 border-0">Available Remaining Limit</td>' +
                                '<td scope="col" align="center" class="text-right align_right tbl_txt_30 border-0">' + remaining_credit.toFixed(2) + '</td>' +
                                '</tr>' +
                                '</tbody>' +
                                '</table>',
                            title: '',
                            icon: 'info',
                            showCancelButton: false,
                            cancelButtonColor: '#d33',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Close',
                            customClass: {
                                container: 'sweet_containerImportant',
                                popup: 'my-popup-class',
                                title: 'sweet_titleImportant',
                                actions: 'sweet_actionsImportant',
                                confirmButton: 'sweet_confirmbuttonImportant',
                                cancelButton: 'sweet_cancelbuttonImportant',
                            },
                            width: 450,
                            padding: '1em 3em',
                            background: '#fff url(' + BASE_URL + '/public/vendors/images/credit_limit.png) no-repeat left top / auto 200px',
                            backdrop: 'rgba(0,0,123,0.4)'

                        }).then(function (result) {
                        });

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // alert(jqXHR.responseText);
                        // alert(errorThrown);
                    }
                });
            }

        });
    </script>
    {{--//////////////////////////////////////////////////////////////////// End Sale Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product_code").append("{!! $pro_code !!}");
            jQuery("#product_name").append("{!! $pro_name !!}");

            jQuery("#service_name").append("{!! $service_name !!}");

            jQuery("#service_name").select2();

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#account_name").select2();

            jQuery("#package").select2();

            jQuery("#warehouse").select2();
            jQuery("#posting_reference").select2();

            // $("#invoice_btn").click();
        });

        window.addEventListener('keydown', function (e) {
            if (e.which == 113) {
                // $('#product_code').select2('open');
            }

            if (e.keyCode == 65 && e.altKey) {
                $("#first_add_more").click();
            }
        });

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });


    </script>

    <script type="text/javascript">
        $("#invoice_btn").click(function () {
            $("#invoice_con").toggle();
            $(".invoice_overlay").toggle();
            setTimeout(function () {
                $("#invoice_bx").toggleClass("show_scale");
            }, 200);
            setTimeout(function () {
                $("#invoice_bx").toggleClass("show_rotate");
            }, 350);
        });

        $("#invoice_cls_btn").click(function () {
            setTimeout(function () {
                $("#invoice_bx").toggleClass("show_rotate");
            }, 50);
            setTimeout(function () {
                $("#invoice_bx").toggleClass("show_scale");
            }, 200);
            setTimeout(function () {
                $("#invoice_con").toggle();
                $(".invoice_overlay").toggle();
            }, 650);
        });

        $("#credit_card_btn").click(function () {
            $("#crdt_crd_mdl").toggle();
        });

        $("#customer_info_btn").click(function () {
            $("#cstmr_info_mdl").toggle();
        });

        $(".sm_mdl_cls").click(function () {
            $(this).closest('.invoice_sm_mdl').css('display', 'none');
        });

    </script>
@endsection

@section('shortcut_script')

    <script type="text/javascript">
        var $ = $.noConflict();
        $.Shortcuts.add({
            type: 'hold', mask: 'i+o', handler: function () {
                $("#invoice_con").toggle();
                $(".invoice_overlay").toggle();
                setTimeout(function () {
                    $("#invoice_bx").toggleClass("show_scale");
                }, 200);
                setTimeout(function () {
                    $("#invoice_bx").toggleClass("show_rotate");
                }, 350);
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f2', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $("#cstmr_info_mdl").toggle();
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'esc', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f7', handler: function () {
                jQuery("#product_code").focus();
                setTimeout(function () {
                    jQuery("#product_code").focus();
                    $('#product_code').select2('open');
                }, 50);
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f8', handler: function () {
                jQuery("#product_name").focus();
                setTimeout(function () {
                    jQuery("#product_name").focus();
                    $('#product_name').select2('open');
                }, 50);
            }
        });
        $.Shortcuts.start();

    </script>

@endsection
