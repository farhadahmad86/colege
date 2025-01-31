@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Sale Order</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('adv_sale_order_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                        <form name="f1" class="f1" id="f1" action="{{ route('submit_adv_sale_order') }}"
                              onsubmit="return checkForm()" method="post" autocomplete="off">

                            {{--                        <form name="f1" class="f1" id="f1" action="{{ route('submit_purchase_order') }}" method="post" onsubmit="return checkForm()">--}}
                            @csrf

                            <div class="pd-20">

                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                    <!-- invoice scroll box start -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                        <!-- invoice content start -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_24">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Sale Order
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="1" autofocus type="text" name="sale_order"
                                                               class="inputs_up form-control"
                                                               data-rule-required="true" data-msg-required="Please Enter Sale Order"
                                                               id="sale_order"
                                                               placeholder="Sale Orde">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_24">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Party
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <select tabindex="2" name="account_name"
                                                                class="inputs_up form-control js-example-basic-multiple user-select"
                                                                data-rule-required="true" data-msg-required="Please Enter Party"
                                                                id="account_name">
                                                            <option value="0">Select Party</option>
                                                            @foreach($companies as $account)
                                                                <option
                                                                    value="{{$account->account_uid}}"
                                                                    {{--                                                                                    data-limit_status="{{$account->account_credit_limit_status}}"--}}
                                                                    {{--                                                                                    data-limit="{{$account->account_credit_limit}}"--}}
                                                                    {{--                                                                                    data-disc_type="{{$account->account_discount_type}}"--}}
                                                                >
                                                                    {{$account->account_name}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_24">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.party_reference.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.party_reference.benefits')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Party Reference
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="3" type="text" name="customer_name"
                                                               class="inputs_up form-control"
                                                               id="customer_name"
                                                               placeholder="Party Reference">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_25">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a
                                                            data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Remarks
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="4" type="text" name="remarks"
                                                               class="inputs_up form-control"
                                                               id="remarks" placeholder="Remarks">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_24">
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
                                                        <input tabindex="5" type="text" name="start_date" id="start_date" class="inputs_up form-control datepicker1" autocomplete="off" value=""
                                                               data-rule-required="true" data-msg-required="Please Enter Start Date"
                                                               placeholder="Start Date......">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_24">
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
                                                        <input tabindex="6" type="text" name="end_date" id="end_date" class="inputs_up form-control datepicker1" autocomplete="off" value=""
                                                               data-rule-required="true" data-msg-required="Please Enter End Date" placeholder="End Date......">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div>
                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_11 ">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_barcode.description')}}</p>
                                                                         <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_barcode.benefits')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Bar Code
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->
                                                            <a href="{{ route('add_product') }}"
                                                               target="_blank" class="col_short_btn"
                                                               data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_product_code"
                                                               class="col_short_btn"
                                                               data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom"
                                                               data-html="true"
                                                               data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="7" name="product_code"
                                                                class="inputs_up form-control"
                                                                id="product_code">
                                                            <option value="0">Code</option>
                                                            @foreach ($products as $product)
                                                                <option
                                                                    value={{$product->pro_p_code}} data-parent={{$product->pro_p_code}} data-sale_price={{$product->pro_sale_price}} data-tax={{$product->pro_tax}} data-retailer_dis={{$product->pro_retailer_discount}} data-whole_saler_dis={{$product->pro_whole_seller_discount}} data-loyalty_dis={{$product->pro_loyalty_card_discount}} data-unit={{$product->unit_title}}>{{$product->pro_code}}</option>
                                                            @endforeach
                                                            {{--                                                        <option value="0">568741759</option>--}}
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_25_5">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.description')}}</p>
                                                         <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.benefits')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Products
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->
                                                            <a href="{{ route('add_product') }}"
                                                               target="_blank" class="col_short_btn"
                                                               data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_product_name"
                                                               class="col_short_btn"
                                                               data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom"
                                                               data-html="true"
                                                               data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="8" name="product_name"
                                                                class="inputs_up form-control"
                                                                id="product_name">
                                                            <option value="0">Product</option>

                                                            @foreach ($products as $product)
                                                                <option
                                                                    value={{$product->pro_p_code}} data-parent={{$product->pro_p_code}} data-sale_price={{$product->pro_sale_price}} data-tax={{$product->pro_tax}} data-retailer_dis={{$product->pro_retailer_discount}} data-whole_saler_dis={{$product->pro_whole_seller_discount}} data-loyalty_dis={{$product->pro_loyalty_card_discount}} data-unit={{$product->unit_title}}>{{$product->pro_title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            {{--                                                            <div class="invoice_col"><!-- invoice column start -->--}}
                                            {{--                                                                <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                                            {{--                                                                    <div class=" invoice_col_ttl"><!-- invoice column title start -->--}}
                                            {{--                                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"--}}
                                            {{--                                                                           data-placement="bottom" data-html="true"--}}
                                            {{--                                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.description')}}</p>--}}
                                            {{--                                                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.benefits')}}</p>--}}
                                            {{--                                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.example')}}</p>">--}}
                                            {{--                                                                            <l class="fa fa-info-circle"></l>--}}
                                            {{--                                                                        </a>--}}
                                            {{--                                                                        Packages--}}
                                            {{--                                                                    </div><!-- invoice column title end -->--}}
                                            {{--                                                                    <div class="invoice_col_input"><!-- invoice column input start -->--}}

                                            {{--                                                                        <div class="invoice_col_short"><!-- invoice column short start -->--}}
                                            {{--                                                                            <a href="{{ url('product_packages') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover"--}}
                                            {{--                                                                               data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
                                            {{--                                                                                <l class="fa fa-plus"></l>--}}
                                            {{--                                                                            </a>--}}
                                            {{--                                                                            <a id="refresh_package" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"--}}
                                            {{--                                                                               data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                                            {{--                                                                                <l class="fa fa-refresh"></l>--}}
                                            {{--                                                                            </a>--}}
                                            {{--                                                                        </div><!-- invoice column short end -->--}}
                                            {{--                                                                        <select tabindex="9" name="package" class="inputs_up form-control js-example-basic-multiple" id="package">--}}
                                            {{--                                                                            <option value="0">Select Package</option>--}}
                                            {{--                                                                            @foreach($packages as $package)--}}
                                            {{--                                                                                <option value="{{$package->pp_id}}">--}}
                                            {{--                                                                                    {{$package->pp_name}}--}}
                                            {{--                                                                                </option>--}}
                                            {{--                                                                            @endforeach--}}
                                            {{--                                                                        </select>--}}
                                            {{--                                                                    </div><!-- invoice column input end -->--}}
                                            {{--                                                                </div><!-- invoice column box end -->--}}
                                            {{--                                                            </div><!-- invoice column end -->--}}

                                            {{--                                                            <div class="invoice_col"><!-- invoice column start -->--}}
                                            {{--                                                                <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                                            {{--                                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->--}}
                                            {{--                                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"--}}
                                            {{--                                                                           data-placement="bottom" data-html="true"--}}
                                            {{--                                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.description')}}</p>--}}
                                            {{--                                                                             <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.benefits')}}</p>--}}
                                            {{--                                                                                 <h6>Example</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.example')}}</p>">--}}
                                            {{--                                                                            <l class="fa fa-info-circle"></l>--}}
                                            {{--                                                                        </a>--}}
                                            {{--                                                                        Warehouse--}}
                                            {{--                                                                    </div><!-- invoice column title end -->--}}
                                            {{--                                                                    <div class="invoice_col_input"><!-- invoice column input start -->--}}

                                            {{--                                                                        <div class="invoice_col_short"><!-- invoice column short start -->--}}
                                            {{--                                                                            <a href="{{ url('add_warehouse') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover"--}}
                                            {{--                                                                               data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
                                            {{--                                                                                <l class="fa fa-plus"></l>--}}
                                            {{--                                                                            </a>--}}
                                            {{--                                                                            <a id="refresh_package" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"--}}
                                            {{--                                                                               data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                                            {{--                                                                                <l class="fa fa-refresh"></l>--}}
                                            {{--                                                                            </a>--}}
                                            {{--                                                                        </div><!-- invoice column short end -->--}}
                                            {{--                                                                        <select tabindex="10" name="warehouse" class="inputs_up form-control js-example-basic-multiple" id="warehouse">--}}
                                            {{--                                                                            <option value="0">Select Warehouse</option>--}}
                                            {{--                                                                            @foreach($warehouses as $warehouse)--}}
                                            {{--                                                                                <option value="{{$warehouse->wh_id}}" {{$warehouse->wh_id == 1 ? 'selected':''}}>{{$warehouse->wh_title}}</option>--}}
                                            {{--                                                                            @endforeach--}}
                                            {{--                                                                        </select>--}}
                                            {{--                                                                    </div><!-- invoice column input end -->--}}
                                            {{--                                                                </div><!-- invoice column box end -->--}}
                                            {{--                                                            </div><!-- invoice column end -->--}}

                                            <div class="invoice_col basis_col_21">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.service.service_title.description')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Services
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->
                                                            <a href="{{ url('product_packages') }}"
                                                               class="col_short_btn" target="_blank"
                                                               data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <l class="fa fa-plus"></l>
                                                            </a>
                                                            <a id="refresh_package"
                                                               class="col_short_btn"
                                                               data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom"
                                                               data-html="true"
                                                               data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </div><!-- invoice column short end -->

                                                        <select tabindex="11" name="service_name"
                                                                class="inputs_up form-control"
                                                                id="service_name">
                                                            <option value="0">Select Service</option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->
                                            <div class="invoice_col basis_col_100 gnrl-mrgn-pdng">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx for_tabs">
                                                    <!-- invoice column box start -->
                                                    {{--  <div class="custom-checkbox">
                                                        <input tabindex="12" type="checkbox" class="custom-control-input company_info_check_box" id="add_auto" name="add_auto" value="1" checked>
                                                        <label class="custom-control-label chck_pdng" for="add_auto"> Auto Add </label>
                                                    </div>  --}}

                                                    <div class="invoice_col_txt for_invoice_nbr">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->

                                                            <div class="invoice_col_txt for_inline_input_checkbox multi_pro">
                                                                <!-- invoice column input start -->
                                                                <div class="custom-checkbox float-left">
                                                                    <input tabindex="13" type="checkbox" value="1"
                                                                           name="check_multi_time"
                                                                           class="custom-control-input company_info_check_box"
                                                                           id="check_multi_time">
                                                                    <label class="custom-control-label chck_pdng"
                                                                           for="check_multi_time"> One Product Add Multi Times </label>
                                                                </div>
                                                            </div><!-- invoice column input end -->

                                                            {{--                                                            <div class="invoice_col_txt for_inline_input_checkbox">--}}
                                                            {{--                                                                <!-- invoice column input start -->--}}
                                                            {{--                                                                <div class="custom-checkbox float-left">--}}
                                                            {{--                                                                    <input tabindex="14" type="checkbox" value="1"--}}
                                                            {{--                                                                           name="check_multi_warehouse"--}}
                                                            {{--                                                                           class="custom-control-input company_info_check_box"--}}
                                                            {{--                                                                           id="check_multi_warehouse">--}}
                                                            {{--                                                                    <label class="custom-control-label chck_pdng"--}}
                                                            {{--                                                                           for="check_multi_warehouse"> Multi--}}
                                                            {{--                                                                        Warehouse </label>--}}
                                                            {{--                                                                </div>--}}
                                                            {{--                                                            </div><!-- invoice column input end -->--}}

                                                            {{--                                                            <div class="invoice_col_input">--}}
                                                            {{--                                                                <input tabindex="15" type="text" name="invoice_nbr_chk"--}}
                                                            {{--                                                                       class="inputs_up form-control"--}}
                                                            {{--                                                                       id="invoice_nbr_chk"--}}
                                                            {{--                                                                       placeholder="Check Invoice Number">--}}
                                                            {{--                                                            </div>--}}
                                                            {{--                                                            <div class="inline_input_txt_lbl"--}}
                                                            {{--                                                                 for="service_total_inclusive_tax">--}}
                                                            {{--                                                                <input tabindex="16" type="button" class="invoice_chk_btn"--}}
                                                            {{--                                                                       value="check"/>--}}
                                                            {{--                                                            </div>--}}
                                                        </div><!-- invoice inline input text end -->
                                                    </div><!-- invoice column input end -->

                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                            <div class="invoice_col basis_col_100">
                                                <!-- invoice column start -->
                                                <div class="invoice_row"><!-- invoice row start -->


                                                    <div
                                                        class="invoice_col basis_col_100 gnrl-mrgn-pdng">
                                                        <!-- invoice column start -->
                                                        <div class="pro_tbl_con">
                                                            <!-- product table container start -->
                                                            <div class="pro_tbl_bx">
                                                                <!-- product table box start -->
                                                                <table class="table gnrl-mrgn-pdng"
                                                                       id="category_dynamic_table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th tabindex="-1" class="text-center tbl_srl_4">
                                                                            Sr.
                                                                        </th>
                                                                        {{--                                                                                        <th class="text-center tbl_srl_9">--}}
                                                                        {{--                                                                                            Code--}}
                                                                        {{--                                                                                        </th>--}}
                                                                        <th tabindex="-1" class="text-center tbl_txt_17">
                                                                            Title
                                                                        </th>
                                                                        <th class="text-center tbl_txt_13">
                                                                            Remarks
                                                                        </th>
                                                                        {{--                                                                                        <th class="text-center tbl_txt_13"> Warehouse</th>--}}
                                                                        <th tabindex="-1" class="text-center tbl_srl_4">
                                                                            Qty
                                                                        </th>
                                                                        <th tabindex="-1" class="text-center tbl_srl_4">
                                                                            UOM
                                                                        </th>
                                                                        {{--                                                                                        <th class="text-center tbl_srl_5">Bonus</th>--}}
                                                                        <th tabindex="-1" class="text-center tbl_srl_6">
                                                                            Rate
                                                                        </th>
                                                                        <th tabindex="-1" class="text-center tbl_srl_4">
                                                                            Dis%
                                                                        </th>
                                                                        <th tabindex="-1" class="text-center tbl_srl_7">
                                                                            Dis Amount
                                                                        </th>
                                                                        <th tabindex="-1" class="text-center tbl_srl_4">
                                                                            Tax%
                                                                        </th>
                                                                        <th tabindex="-1" class="text-center tbl_srl_10">
                                                                            Tax Amount
                                                                        </th>
                                                                        <th tabindex="-1" class="text-center tbl_srl_4">
                                                                            Inclu
                                                                        </th>
                                                                        <th tabindex="-1" class="text-center tbl_srl_12">
                                                                            Amount
                                                                        </th>
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

                                            <div class="invoice_col basis_col_18 hidden" hidden>
                                                <!-- invoice column start -->

                                                <div class="invoice_row"><!-- invoice row start -->

                                                    <div class="invoice_col basis_col_100 hidden"
                                                         hidden>
                                                        <!-- invoice column start -->
                                                        <div class="invoice_col_bx">
                                                            <!-- invoice column box start -->
                                                            <div class=" invoice_col_ttl">
                                                                <!-- invoice column title start -->
                                                                <a data-container="body"
                                                                   data-toggle="popover"
                                                                   data-trigger="hover"
                                                                   data-placement="bottom"
                                                                   data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.description')}}</p>
                                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.benefits')}}</p>
                                                                                      <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.example')}}</p>">
                                                                    <l class="fa fa-info-circle"></l>
                                                                </a>
                                                                Invoice Type
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_txt">
                                                                <!-- invoice column input start -->
                                                                <div class="radio">
                                                                    <label>

                                                                        <input type="radio"
                                                                               name="invoice_type"
                                                                               class="invoice_type"
                                                                               id="invoice_type1"
                                                                               value="1" checked>
                                                                        Non Tax Invoice
                                                                    </label>
                                                                </div>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio"
                                                                               name="invoice_type"
                                                                               class="invoice_type"
                                                                               id="invoice_type2"
                                                                               value="2">
                                                                        Tax Invoice
                                                                    </label>
                                                                </div>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_100 hidden"
                                                         hidden>
                                                        <!-- invoice column start -->
                                                        <div class="invoice_col_bx">
                                                            <!-- invoice column box start -->
                                                            <div class="invoice_col_ttl">
                                                                <!-- invoice column title start -->
                                                                <a data-container="body"
                                                                   data-toggle="popover"
                                                                   data-trigger="hover"
                                                                   data-placement="left"
                                                                   data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.description')}}</p>
                                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.benefits')}}</p>
                                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.example')}}</p>">
                                                                    <l class="fa fa-info-circle"></l>
                                                                </a>
                                                                Round OFF Discount
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_txt">
                                                                <!-- invoice column input start -->
                                                                <div class="custom-checkbox float-left">
                                                                    <input type="checkbox"
                                                                           name="round_off"
                                                                           class="custom-control-input company_info_check_box"
                                                                           id="round_off" value="1"
                                                                           onchange="grand_total_calculation();">
                                                                    <label
                                                                        class="custom-control-label chck_pdng"
                                                                        for="round_off"> Auto Round
                                                                        OFF </label>
                                                                    <input type="hidden"
                                                                           name="round_off_discount"
                                                                           id="round_off_discount"/>
                                                                </div>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->


                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_100 hidden"
                                                         hidden>
                                                        <!-- invoice column start -->
                                                        <div class="invoice_col_bx">
                                                            <!-- invoice column box start -->
                                                            <div class="invoice_col_ttl">
                                                                <!-- invoice column title start -->
                                                                <a data-container="body"
                                                                   data-toggle="popover"
                                                                   data-trigger="hover"
                                                                   data-placement="bottom"
                                                                   data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).description')}}</p>
                                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).benefits')}}</p>
                                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).example')}}</p>">
                                                                    <l class="fa fa-info-circle"></l>
                                                                </a>
                                                                Items Discount
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_txt">
                                                                <!-- invoice column input start -->
                                                                <div class="invoice_inline_input_txt">
                                                                    <!-- invoice inline input text start -->
                                                                    <label class="inline_input_txt_lbl"
                                                                           for="total_product_discount">
                                                                        Product Dis
                                                                    </label>
                                                                    <div class="invoice_col_input">
                                                                        <input type="text"
                                                                               name="total_product_discount"
                                                                               class="inputs_up form-control text-right"
                                                                               id="total_product_discount"
                                                                               readonly>
                                                                    </div>
                                                                </div>
                                                                <!-- invoice inline input text end -->

                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->


                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_100 hidden"
                                                         hidden>
                                                        <!-- invoice column start -->
                                                        <div class="invoice_col_bx">
                                                            <!-- invoice column box start -->
                                                            <div class="invoice_col_ttl">
                                                                <!-- invoice column title start -->
                                                                <a data-container="body"
                                                                   data-toggle="popover"
                                                                   data-trigger="hover"
                                                                   data-placement="left"
                                                                   data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.description')}}</p>
                                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.benefits')}}</p>
                                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.example')}}</p>">
                                                                    <l class="fa fa-info-circle"></l>
                                                                </a>
                                                                Product Tax
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_txt">
                                                                <!-- invoice column input start -->
                                                                <div class="invoice_inline_input_txt">
                                                                    <!-- invoice inline input text start -->
                                                                    <label class="inline_input_txt_lbl"
                                                                           for="total_inclusive_tax">
                                                                        Inclusive Tax
                                                                    </label>
                                                                    <div class="invoice_col_input">
                                                                        <input type="text"
                                                                               name="total_inclusive_tax"
                                                                               class="inputs_up form-control text-right"
                                                                               id="total_inclusive_tax"
                                                                               readonly>
                                                                    </div>
                                                                </div>
                                                                <!-- invoice inline input text end -->
                                                                <div class="invoice_inline_input_txt">
                                                                    <!-- invoice inline input text start -->
                                                                    <label class="inline_input_txt_lbl"
                                                                           for="total_exclusive_tax">
                                                                        Exclusive Tax
                                                                    </label>
                                                                    <div class="invoice_col_input">
                                                                        <input type="text"
                                                                               name="total_exclusive_tax"
                                                                               class="inputs_up form-control text-right"
                                                                               id="total_exclusive_tax"
                                                                               readonly>
                                                                    </div>
                                                                </div>
                                                                <!-- invoice inline input text end -->

                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->


                                                    </div><!-- invoice column end -->

                                                </div><!-- invoice row end -->

                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_23 hidden" hidden>
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Cash_Discount.description')}}</p>
                                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.Cash_Discount.benefits')}}</p>
                                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.Cash_Discount.example')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Cash Discount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_txt">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="disc_percentage">
                                                                Discount %
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text"
                                                                       name="disc_percentage"
                                                                       class="inputs_up form-control text-right percentage_textbox"
                                                                       id="disc_percentage"
                                                                       placeholder="In percentage"
                                                                       onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                       onkeyup="grand_total_calculation();"
                                                                       onfocus="this.select();">
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="disc_amount">
                                                                Discount (Rs.)
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text" name="disc_amount"
                                                                       class="inputs_up form-control text-right"
                                                                       id="disc_amount"
                                                                       onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                       onkeyup="grand_total_calculation_with_disc_amount();"
                                                                       onfocus="this.select();">
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="service_total_exclusive_tax">
                                                                Total Discount
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text" name="total_discount"
                                                                       class="inputs_up form-control text-right"
                                                                       id="total_discount" readonly>
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_23">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Total(Total_Item/Sub_Total/Total_Taxes).description')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Total
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_txt">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="total_items">
                                                                Total Items
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text" name="total_items"
                                                                       class="inputs_up form-control text-right total-items-field"
                                                                       data-rule-required="true" data-msg-required="Please Enter Total Items"
                                                                       id="total_items" readonly>
                                                                {{--                                                        <input type="text" name="service_total_items" class="inputs_up form-control text-right total-items-field" id="service_total_items" readonly>--}}
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="total_price">
                                                                Sub Total
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text" name="total_price"
                                                                       class="inputs_up form-control text-right" data-rule-required="true" data-msg-required="Please Enter Sub Total"
                                                                       id="total_price" readonly>
                                                                {{--                                                        <input type="text" name="service_total_price" class="inputs_up form-control text-right" id="service_total_price" readonly>--}}
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="total_tax">
                                                                Total Taxes
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text" name="total_tax"
                                                                       class="inputs_up form-control text-right"
                                                                       id="total_tax" readonly>
                                                                {{--                                                        <input type="text" name="service_total_tax" class="inputs_up form-control text-right " id="service_total_tax" readonly>--}}
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                            <div class="invoice_col basis_col_20">
                                                <!-- invoice column start -->
                                                <div class="invoice_row"><!-- invoice row start -->

                                                    <div class="invoice_col basis_col_100" >
                                                        <!-- invoice column start -->
                                                        <div class="invoice_col_bx">
                                                            <!-- invoice column box start -->
                                                            <label class=" invoice_col_ttl">
                                                                <!-- invoice column title start -->

                                                                Grand Total %
                                                            </label><!-- invoice column title end -->
                                                            <div class="invoice_col_txt ghiki">
                                                                <!-- invoice column input start -->
                                                                <h5 id="grand_total_text_pec">

                                                                    100
                                                                </h5>

                                                                <input type="hidden" name="grand_total_pec"
                                                                       id="grand_total_pec" value="100"/>


                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- grand total invoice column end -->


                                                    <div class="invoice_col basis_col_100">
                                                        <!-- invoice column start -->
                                                        <div class="invoice_col_bx">
                                                            <!-- invoice column box start -->
                                                            <label class=" invoice_col_ttl">
                                                                <!-- invoice column title start -->

                                                                Expense Budget %
                                                            </label><!-- invoice column title end -->
                                                            <div class="invoice_col_txt ghiki">
                                                                <!-- invoice column input start -->

                                                                <input type="text" name="material_pec" class="invoice_col_input form-control text-right"
                                                                       id="material_pec" data-rule-required="true" data-msg-required="Please Enter Material %"/>
                                                                <input type="hidden" name="material_amount"
                                                                       id="material_amount"/>

                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->


                                                </div><!-- invoice row end -->
                                            </div><!--grand total % invoice column end -->

                                            <div class="invoice_col basis_col_20">
                                                <!-- invoice column start -->
                                                <div class="invoice_row"><!-- invoice row start -->

                                                    <div class="invoice_col basis_col_100">
                                                        <!-- invoice column start -->
                                                        <div class="invoice_col_bx">
                                                            <!-- invoice column box start -->
                                                            <label class=" invoice_col_ttl">
                                                                <!-- invoice column title start -->

                                                                Reserve %
                                                            </label><!-- invoice column title end -->
                                                            <div class="invoice_col_txt ghiki">
                                                                <!-- invoice column input start -->
                                                                <h5 id="reserve_text_pec">

                                                                    100
                                                                </h5>

                                                                <input type="hidden" name="reserve_pec"
                                                                       id="reserve_pec"/>
                                                                <input type="hidden" name="reserve_amount"
                                                                       id="reserve_amount" placeholder="amount"/>

                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    {{--                                                    <div class="invoice_col basis_col_100">--}}
                                                    {{--                                                        <!-- invoice column start -->--}}
                                                    {{--                                                        <div class="invoice_col_bx">--}}
                                                    {{--                                                            <!-- invoice column box start -->--}}
                                                    {{--                                                            <label class=" invoice_col_ttl">--}}
                                                    {{--                                                                <!-- invoice column title start -->--}}

                                                    {{--                                                                Expense Budget %--}}
                                                    {{--                                                            </label><!-- invoice column title end -->--}}
                                                    {{--                                                            <div class="invoice_col_txt ghiki">--}}
                                                    {{--                                                                <!-- invoice column input start -->--}}

                                                    {{--                                                                <input type="text" name="expense_pec"--}}
                                                    {{--                                                                       id="expense_pec" class="invoice_col_input form-control text-right" data-rule-required="true" data-msg-required="Please Enter Expense %" />--}}
                                                    {{--                                                                <input type="hidden" name="expense_amount"--}}
                                                    {{--                                                                       id="expense_amount" placeholder="amount"/>--}}

                                                    {{--                                                            </div><!-- invoice column input end -->--}}
                                                    {{--                                                        </div><!-- invoice column box end -->--}}
                                                    {{--                                                    </div><!-- invoice column end -->--}}

                                                </div><!-- invoice row end -->
                                            </div><!--reserve % invoice column end -->

                                            <div class="invoice_col basis_col_27" style="margin-top:-7px">
                                                <!-- invoice column start -->
                                                <div class="invoice_row"><!-- invoice row start -->


                                                    <div class="invoice_col basis_col_100">
                                                        <!-- invoice column start -->
                                                        <div class="invoice_col_bx hidden" hidden>
                                                            <!-- invoice column box start -->
                                                            <div class=" invoice_col_ttl">
                                                                <!-- invoice column title start -->
                                                                <a data-container="body"
                                                                   data-toggle="popover"
                                                                   data-trigger="hover"
                                                                   data-placement="bottom"
                                                                   data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Discount_Type.description')}}</p>
                                                                                     <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.Discount_Type.benefits')}}</p>">
                                                                    <l class="fa fa-info-circle"></l>
                                                                </a>
                                                                Discount Type
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_txt">
                                                                <!-- invoice column input start -->
                                                                <div
                                                                    class="invoice_inline_input_txt with_wrap">

                                                                    <div class="radio">
                                                                        <label for="discount_type1">
                                                                            <input type="radio"
                                                                                   name="discount_type"
                                                                                   class="discount_type"
                                                                                   id="discount_type1"
                                                                                   value="1" checked>
                                                                            Non
                                                                        </label>
                                                                    </div>

                                                                    <div class="radio">
                                                                        <label for="discount_type2">
                                                                            <input type="radio"
                                                                                   name="discount_type"
                                                                                   class="discount_type"
                                                                                   id="discount_type2"
                                                                                   value="2">
                                                                            Retailer
                                                                        </label>
                                                                    </div>

                                                                    <div class="radio">
                                                                        <label for="discount_type3">
                                                                            <input type="radio"
                                                                                   name="discount_type"
                                                                                   class="discount_type"
                                                                                   id="discount_type3"
                                                                                   value="3">
                                                                            Wholesaler
                                                                        </label>
                                                                    </div>

                                                                    <div class="radio">
                                                                        <label for="discount_type4">
                                                                            <input type="radio"
                                                                                   name="discount_type"
                                                                                   class="discount_type"
                                                                                   id="discount_type4"
                                                                                   value="4">
                                                                            Loyalty Card
                                                                        </label>
                                                                    </div>


                                                                </div>

                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_100">
                                                        <!-- invoice column start -->
                                                        <div class="invoice_col_bx">
                                                            <!-- invoice column box start -->
                                                            <label class=" invoice_col_ttl">
                                                                <!-- invoice column title start -->
                                                                <a data-container="body"
                                                                   data-toggle="popover"
                                                                   data-trigger="hover"
                                                                   data-placement="bottom"
                                                                   data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.grand_total.description')}}</p>">
                                                                    <l class="fa fa-info-circle"></l>
                                                                </a>
                                                                Grand Total
                                                            </label><!-- invoice column title end -->
                                                            <div class="invoice_col_txt ghiki">
                                                                <!-- invoice column input start -->
                                                                <h5 id="grand_total_text">
                                                                    {{--                                                                1,450,304,074.17--}}
                                                                    000,000
                                                                </h5>

                                                                <input type="hidden" name="grand_total"
                                                                       id="grand_total"/>

                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- Grand Total invoice column end -->


                                                </div><!-- invoice row end -->
                                            </div><!-- grand total + discount invoice column end -->



                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_txt with_cntr_jstfy">
                                                    <!-- invoice column box start -->
                                                    <div
                                                        class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button id="clear_discount_btn" type="button"
                                                                class="invoice_frm_btn">
                                                            Clear Discount
                                                        </button>
                                                    </div>
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button type="submit" class="invoice_frm_btn"
                                                        >
                                                            Save (Ctrl+S)
                                                        </button>
                                                        <span id="check_product_count" class="validate_sign"></span>
                                                    </div>
                                                    <div
                                                        class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button id="all_clear_form" type="button"
                                                                class="invoice_frm_btn">
                                                            Clear (Ctrl+X)
                                                        </button>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                        </div><!-- invoice row end -->

                                    </div><!-- invoice content end -->
                                </div><!-- invoice scroll box end -->
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

                    <div id="table_body">

                    </div>
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
            let sale_order = document.getElementById("sale_order"),
                account_name = document.getElementById("account_name"),
                start_date = document.getElementById("start_date"),
                end_date = document.getElementById("end_date"),
                total_items = document.getElementById("total_items"),
                total_price = document.getElementById("total_price"),
                material_pec = document.getElementById("material_pec"),
                // expense_pec = document.getElementById("expense_pec"),
                validateInputIdArray = [
                    sale_order.id,
                    account_name.id,
                    start_date.id,
                    end_date.id,
                    total_items.id,
                    total_price.id,
                    material_pec.id,
                    // expense_pec.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
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
    <script type="text/javascript">

        // Initialize select2
        jQuery("#company").select2();
        jQuery("#party").select2();
    </script>
    {{--///////////////////////// Start Sale Javascript ////////////////////////////////////--}}
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

            jQuery("#material_pec").val('');
            jQuery("#material_amount").val('');
            // jQuery("#expense_pec").val('');
            // jQuery("#expense_amount").val('');
            jQuery("#reserve_pec").val(100);

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
            // calculate();
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

            if (!$("#check_multi_time").is(':checked')) {
                // if (!$("#check_multi_warehouse").is(':checked')) {
                $('input[name="pro_code[]"]').each(function (pro_index) {
                    pro_code = $(this).val();
                    pro_field_id_title = $(this).attr('id');
                    pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                    if (pro_code == parent_code) {
                        quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                        // bonus_qty = '';
                        rate = jQuery("#rate" + pro_field_id).val();
                        discount = jQuery("#product_discount" + pro_field_id).val();
                        sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                        if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                            inclusive_exclusive = 1;
                        }
                        delete_sale(pro_field_id);
                    }
                });
                // }
            }
            // bonus_qty,
            add_sale(parent_code, name, quantity, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
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
            // var bonus_qty = '';
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

            if (!$("#check_multi_time").is(':checked')) {
                // if (!$("#check_multi_warehouse").is(':checked')) {
                $('input[name="pro_code[]"]').each(function (pro_index) {
                    pro_code = $(this).val();
                    pro_field_id_title = $(this).attr('id');
                    pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                    if (pro_code == parent_code) {
                        quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                        // bonus_qty = jQuery("#bonus" + pro_field_id).val();
                        rate = jQuery("#rate" + pro_field_id).val();
                        discount = jQuery("#product_discount" + pro_field_id).val();
                        sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                        if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                            inclusive_exclusive = 1;
                        }

                        delete_sale(pro_field_id);
                    }
                });
                // }
            }

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
            // bonus_qty,
            add_sale(parent_code, name, quantity, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 0, unit_measurement);

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
            // var bonus_qty = '';
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

            if (!$("#check_multi_time").is(':checked')) {
                // if (!$("#check_multi_warehouse").is(':checked')) {
                $('input[name="pro_code[]"]').each(function (pro_index) {

                    pro_code = $(this).val();
                    pro_field_id_title = $(this).attr('id');
                    pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                    if (pro_code == parent_code) {
                        quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                        // bonus_qty = jQuery("#bonus" + pro_field_id).val();
                        rate = jQuery("#rate" + pro_field_id).val();
                        discount = jQuery("#product_discount" + pro_field_id).val();
                        sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                        if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                            inclusive_exclusive = 1;
                        }

                        delete_sale(pro_field_id);
                    }
                });
                // }
            }

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
            // bonus_qty,
            add_sale(parent_code, name, quantity, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 0, unit_measurement);

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
            // calculate();
            jQuery("#sale_person").val("0").trigger('change');
            jQuery("#account_name").val("0").trigger('change');
            jQuery("#remarks").val("");

            jQuery("#project_name").val("");
            jQuery("#work_space").val("");
            jQuery("#start_date").val("");
            jQuery("#end_date").val("");

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
                        // var bonus_qty = '';
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
                                // bonus_qty = jQuery("#bonus" + pro_field_id).val();
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
                        // bonus_qty,
                        add_sale(parent_code, name, quantity, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount,
                            inclusive_exclusive, counter, 0, unit_measurement);

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

        // bonus_qty,
        function add_sale(code, name, quantity, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                          counter, product_or_service_status, unit_measurement) {

            var inclusive_exclusive_status = '';
            // var bonus_qty_status = '';
            if (inclusive_exclusive == 1) {
                inclusive_exclusive_status = 'checked';
            }

            if (product_or_service_status == 1) {
                // bonus_qty_status = 'readonly';
            }


            jQuery("#table_body").append('<tr class="edit_update" id="table_row' + counter + '">' +
                '<td class="text-center tbl_srl_4">' + counter + '</td> ' +
                '<td class="text-center tbl_srl_9" hidden>' +
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
                // '<td class="text-left tbl_txt_13" id="warehouse_div_col' + counter + '">' +
                // '</td>' +
                '<td class="text-center tbl_srl_4">' +
                '<input type="text" name="quantity[]" id="quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                quantity + '" onfocus="this.select();" onkeypress="return allowOnlyNumber(event);"/>' +
                '</td>' +
                '<td class="text-center tbl_srl_4">' +
                '<input type="text" name="unit_measurement[]" id="unit_measurement' + counter + '" placeholder="UOM" value="' + unit_measurement + '" readonly/>' +
                '</td>' +
                // '<td class="text-center tbl_srl_5"> ' +
                // '<input type="text" name="bonus[]" id="bonus' + counter + '" placeholder="Bonus" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                // bonus_qty + '" onfocus="this.select();" onkeypress="return allowOnlyNumber(event);" ' + bonus_qty_status + '/> ' +
                // '</td> ' +
                '<td class="text-right tbl_srl_6"> ' +
                '<input type="text" name="rate[]" id="rate' + counter + '" ' + 'placeholder="Rate" class="inputs_up_tbl text-right" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                rate + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                '<input type="hidden" name="product_inclusive_rate[]" class="inputs_up ' + 'text-right form-control" id="product_inclusive_rate' + counter + '"  value="' + inclusive_rate + '"> ' +
                '</td> ' +
                '<td class="text-center tbl_srl_4"> ' +
                '<input type="text" name="product_discount[]" id="product_discount' + counter + '" placeholder="Dis%" class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" ' +
                'value="' + discount + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                '</td> <td class="text-right tbl_srl_7"> ' +
                '<input type="text" name="product_discount_amount[]" id="product_discount_amount' + counter + '" placeholder="Dis Amount" value="' + discount_amount + '" class="inputs_up_tbl text-right" ' +
                'readonly/> ' +
                '</td> <td class="text-center tbl_srl_4"> ' +
                '<input type="text" name="product_sales_tax[]" id="product_sales_tax' + counter + '" placeholder="Tax%" class="inputs_up_tbl" value="' + sales_tax + '" ' +
                'onkeyup="product_amount_calculation(' + counter + ')" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                '</td> ' +
                '<td class="text-right tbl_srl_10"> ' +
                '<input type="text" name="product_sale_tax_amount[]" id="product_sale_tax_amount' + counter + '" placeholder="Tax Amount" value="' + sale_tax_amount + '" class="inputs_up_tbl text-right" readonly/> ' +
                '</td> ' +
                '<td class="text-center tbl_srl_4"> <input type="checkbox" name="inclusive_exclusive[]" id="inclusive_exclusive' + counter + '" onclick="product_amount_calculation(' + counter + ');' +
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
            // calculate();
            check_invoice_type();
        }

        function delete_sale(current_item) {

            jQuery("#table_row" + current_item).remove();

            grand_total_calculation();
            // calculate();
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
            // calculate();
        }

        function decrease_quantity(current_item) {

            var previous_qty = jQuery("#quantity" + current_item).val();
            var new_quantity = 1;
            if (previous_qty >= 0) {
                new_quantity = previous_qty - 1;
            }

            jQuery("#quantity" + current_item).val(new_quantity);

            product_amount_calculation(current_item);
            // calculate();
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
    {{--//////////////////////// End Sale Javascript //////////////////////////////////////--}}
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            {{--jQuery("#product_code").append("{!! $pro_code !!}");--}}
            {{--jQuery("#product_name").append("{!! $pro_name !!}");--}}

            {{--jQuery("#material_product_code").append("{!! $pro_code !!}");--}}
            {{--jQuery("#material_product_name").append("{!! $pro_name !!}");--}}

            jQuery("#service_name").append("{!! $service_name !!}");

            jQuery("#service_name").select2();

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#material_product_code").select2();
            jQuery("#material_product_name").select2();

            jQuery("#account_name").select2();

            jQuery("#package").select2();

            $("#invoice_btn").click();
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

    <script>
        $("#material_pec").keyup(function () {

            var grand_total = $('#grand_total').val();
            var grand_total_pec = $('#grand_total_pec').val();
            var material_pec = $(this).val();
            // var expense_pec = $('#expense_pec').val();

            // if (expense_pec != '') {
            //     var due_pec = grand_total_pec - expense_pec;
            //     if (material_pec <= grand_total_pec) {
            //         var reserv = due_pec - material_pec;
            //        var material_amount = grand_total / 100 * material_pec;
            //         var reserve_amount = grand_total / 100 * reserv;
            //         $('#reserve_amount').val(reserve_amount.toFixed(2));
            //         $('#reserve_pec').val(reserv);
            //         $('#material_amount').val(material_amount.toFixed(2));
            //         document.getElementById("reserve_text_pec").innerHTML = reserv;
            //
            //     } else {
            //         $('#material_pec').val('');
            //         $('#material_amount').val('');
            //         var due_amount = grand_total / 100 * due_pec;
            //         $('#reserve_pec').val(due_pec);
            //         $('#reserve_amount').val(due_amount.toFixed(2));
            //         document.getElementById("reserve_text_pec").innerHTML = due_pec;
            //     }
            // } else {
            if(material_pec <= 100){
                var reserv = grand_total_pec - material_pec;
                var reserv_amount = grand_total / 100 * reserv;
                var material_amount = grand_total / 100 * material_pec;

                $('#material_amount').val(material_amount.toFixed(2));
                $('#reserve_amount').val(reserv_amount.toFixed(2));
                $('#reserve_pec').val(reserv);
                document.getElementById("reserve_text_pec").innerHTML = reserv;
            }else{
                $('#material_amount').val('');
                $('#material_pec').val('');
                $('#reserve_amount').val('');
                $('#reserve_pec').val(100);
                document.getElementById("reserve_text_pec").innerHTML = 100;
            }
            // }

        });

        // $("#expense_pec").keyup(function () {
        //     var grand_total = $('#grand_total').val();
        //     var grand_total_pec = $('#grand_total_pec').val();
        //     var material_pec = $('#material_pec').val();
        //     var expense_pec = $(this).val();
        //
        //     if (material_pec != '') {
        //         var due_pec = grand_total_pec - material_pec;
        //
        //         if (expense_pec <= due_pec) {
        //             var reserv = due_pec - expense_pec;
        //
        //             var expense_amount = grand_total / 100 * expense_pec;
        //             var reserve_amount = grand_total / 100 * reserv;
        //             $('#reserve_amount').val(reserve_amount.toFixed(2));
        //             $('#reserve_pec').val(reserv);
        //             $('#expense_amount').val(expense_amount.toFixed(2));
        //             document.getElementById("reserve_text_pec").innerHTML = reserv;
        //         } else {
        //             $('#expense_pec').val('');
        //             $('#expense_amount').val('');
        //             var due_amount = grand_total / 100 * due_pec;
        //             $('#reserve_pec').val(due_pec);
        //             $('#reserve_amount').val(due_amount.toFixed(2));
        //             document.getElementById("reserve_text_pec").innerHTML = due_pec;
        //         }
        //     } else {
        //         if(expense_pec <= 100){
        //         var reserve = grand_total_pec - expense_pec;
        //         var reserve_amount = grand_total / 100 * reserve;
        //         var expense_amount = grand_total / 100 * expense_pec;
        //         $('#expense_amount').val(expense_amount.toFixed(2));
        //         $('#reserve_amount').val(reserve_amount.toFixed(2));
        //         $('#reserve_pec').val(reserve);
        //         document.getElementById("reserve_text_pec").innerHTML = reserve;
        //         }else{
        //             $('#expense_amount').val('');
        //             $('#expense_pec').val('');
        //             $('#reserve_amount').val('');
        //             $('#reserve_pec').val(100);
        //             document.getElementById("reserve_text_pec").innerHTML = 100;
        //         }
        //     }
        // });

    </script>


@endsection

