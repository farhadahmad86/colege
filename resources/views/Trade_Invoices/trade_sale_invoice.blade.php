@extends('extend_index')

@section('styles_get')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/custom-search/custom-search.css') }}">
    {{--    nabeel css blue--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">

@stop

@section('content')
    <div class="row">
        <div id="main_bg" class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Trade Sale Invoice</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <a class="add_btn list_link add_more_button" href="{{ route('trade_sale_invoice_list') }}"
                           role="button">
                            <i class="fa fa-list"></i> Sale Invoice
                        </a>

                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

            {{--                invoice container--}}
            <div id="invoice_con"><!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx"><!-- invoice box start -->

                    {{--form start--}}
                    <form name="f1" class="f1" id="f1" action="{{ route('submit_trade_sale_invoice') }}"
                          onsubmit="return checkForm()" method="post" autocomplete="off">
                        @csrf
                        <div class="invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="invoice_cntnt"><!-- invoice content start -->
                                {{--above table--}}
                                <div class="invoice_row row"><!-- invoice row start -->
                                    <!-- add start -->
                                    <div class="invoice_col form-group col-lg-10 col-md-9 col-sm-12 upper">
                                        {{--above table row1--}}
                                        <div class="invoice_row row"> <!--row1 start -->
                                            <!-- add end -->
                                            <div class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column -->
                                                <x-party-name-component tabindex="1" name="account_name" id="account_name" class="sale"/>
                                            </div>
                                            <!-- changed -->
                                            <div class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <x-remarks-component tabindex="2" name="remarks" title="Remarks" id="remarks"/>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <!-- Call saleman component -->
                                                <x-saleman-component/>

                                            </div><!-- invoice column end -->

                                            <div class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <x-posting-reference tabindex="2"/>
                                            </div>

                                            <!-- add start -->
                                            <div hidden class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a
                                                            data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.sale_return_search.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Search Invoices
                                                    </div><!-- invoice column title end -->

                                                    <div class="invoice_col_input">
                                                        <input type="text" name="invoice_nbr_chk"
                                                               class="inputs_up form-control"
                                                               id="invoice_nbr_chk"
                                                               placeholder="Check Invoice Number">


                                                        <!-- changed added start (search btn) -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                            <a id="search_product_name" class="col_short_btn"
                                                               data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="{{config('fields_info.search_btn.description')}}">
                                                                <l class="fa fa-search"></l>
                                                            </a>
                                                        </div>
                                                        <!-- changed added end -->


                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                            <!-- add end -->
                                            <!-- changed -->
                                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.description')}}</p>
                                                         <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Products
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <x-add-refresh-button href="{{ route('add_product') }}" id="refresh_product_name"/>

                                                        <div class="ps__search">
                                                            {{--Hamad set tab index--}}
                                                            <input tabindex="5" type="text" name="product"
                                                                   id="product"
                                                                   class="inputs_up form-control ps__search__input"
                                                                   placeholder="Enter Product"
                                                                   onfocus="this.select();"
                                                                   {{--                                                                       onfocus=""--}}
                                                                   onkeydown="return not_plus_minus(event), focus_stay_on_product(event)"
                                                                   onfocusout="hideproducts();"
                                                            />
                                                        </div>

                                                        <span id="check_product_count" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div>


                                            <div class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <x-warehouse-component tabindex="6" name="warehouse" id="warehouse" class="refresh_warehouse" title="Warehouse"/>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.service.service_title.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Services
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <x-add-refresh-button href="{{ route('add_services') }}" id="refresh_service"/>

                                                        <select tabindex="7" name="service_name"
                                                                class="inputs_up form-control"
                                                                id="service_name">
                                                            <option value="0">Select Service</option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <!-- changed -->
                                            <div class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.description')}}</p>
                                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.benefits')}}</p>
                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Packages
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <x-add-refresh-button href="{{ route('product_packages') }}" id="refresh_package"/>

                                                        <select tabindex="8" name="package"
                                                                class="inputs_up form-control js-example-basic-multiple"
                                                                id="package">
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
                                            <!-- changed -->
                                            <!-- add start -->
                                        </div><!-- invoice row2 + 85 end -->
                                    </div><!-- invoice row end -->
                                    <!-- add col-12 Filters start -->
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12" id="filters">
                                        <!-- invoice column start -->
                                        <div class="invoice_row row"><!-- invoice row start -->
                                            <div class="invoice_col col-lg-12 col-md-12 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover" data-placement="left"
                                                           data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.description')}}</p>
                                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.benefits')}}</p>
                                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Filters
                                                    </div><!-- invoice column title end -->
                                                    <!-- invoice column input start -->
                                                    <div class="custom-checkbox float-left">
                                                        <input tabindex="-1" type="checkbox" name="round_off"
                                                               class="custom-control-input company_info_check_box"
                                                               id="round_off" value="1"
                                                               onchange="grand_total_calculation_with_disc_amount();">
                                                        <label class="custom-control-label chck_pdng"
                                                               for="round_off"> Auto Round OFF </label>
                                                        <input tabindex="-1" type="hidden"
                                                               name="round_off_discount"
                                                               id="round_off_discount">
                                                    </div>
                                                    <div class="custom-checkbox float-left">
                                                        <input type="checkbox"
                                                               class="custom-control-input company_info_check_box"
                                                               id="add_auto_material"
                                                               name="add_auto_material"
                                                               value="1" onclick="storecheckbox()">
                                                        <label
                                                            class="custom-control-label chck_pdng"
                                                            for="add_auto_material"> Auto
                                                            Add </label>
                                                    </div>


                                                    <!-- add start -->
                                                    <div class="custom-checkbox float-left">
                                                        <input type="checkbox" value="1"
                                                               name="check_multi_warehouse"
                                                               class="custom-control-input company_info_check_box"
                                                               id="check_multi_warehouse">
                                                        <label class="custom-control-label chck_pdng"
                                                               for="check_multi_warehouse"> Multi
                                                            Warehouse </label>
                                                    </div>

                                                {{--auto add--}}


                                                <!-- Auto add end -->

                                                    {{--Quick print start--}}

                                                    <div class="custom-checkbox float-left mr-1">
                                                        <input type="checkbox" value="1"
                                                               name="quick_print"
                                                               class="custom-control-input company_info_check_box"
                                                               id="quick_print"
                                                               onclick="store_print_checkbox()">
                                                        <label class="custom-control-label chck_pdng"
                                                               for="quick_print"> Quick Print
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline float-left">
                                                        <input tabindex="17" type="radio" name="detail_remarks_type" class=" detail_remarks_type" id="detail_remarks_type0" value="0"
                                                            {{ $detail_remarks == 0  ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="inlineRadio1">English</label>
                                                    </div>
                                                    <div class="form-check form-check-inline float-left">
                                                        <input tabindex="18" type="radio" name="detail_remarks_type" class=" detail_remarks_type" id="detail_remarks_type1"
                                                               value="1"{{ $detail_remarks == 1  ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="inlineRadio2">Urdu</label>
                                                    </div>


                                                    <span id="language_error_msg" class="validate_sign"> </span>

                                                </div><!-- invoice column box end -->

                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                    </div>
                                    <!-- add col-12 Filters end -->

                                </div><!-- invoice row end -->
                                {{--Table start--}}
                                <div class="invoice_row row pro_tbl_con"><!-- product table container start -->
                                    <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                        <table class="table table-bordered table-sm" id="category_dynamic_table">
                                            <thead>
                                            <tr>
                                                <th class="text-center tbl_srl_9"> Code</th>
                                                <th class="text-center tbl_txt_13"> Item Name</th>
                                                <th class="text-center tbl_txt_9"> Remarks</th>
                                                <th class="text-center tbl_txt_10"> Warehouse</th>

                                                <th class="text-center tbl_srl_4"> Pack Detail</th>

                                                <th class="text-center tbl_txt_6"> Pack Size</th>

                                                <th class="text-center tbl_srl_4">
                                                    UOM
                                                </th>


                                                <th class="text-center tbl_srl_4" hidden>
                                                    DB Qty
                                                </th>


                                                <th class="text-center tbl_srl_4">
                                                    Pack Qty
                                                </th>

                                                <th class="text-center tbl_srl_4">
                                                    Pack Rate
                                                </th>

                                                {{--empty ha--}}
                                                <th class="text-center tbl_srl_4">
                                                    Loose Qty
                                                </th>


                                                <th class="text-center tbl_srl_6">
                                                    Loose Rate
                                                </th>
                                                <th class="text-center tbl_srl_9">Gross Amount</th>
                                                <th class="text-center tbl_srl_5">Bonus</th>

                                                <th class="text-center tbl_srl_4"> Trade Offer</th>

                                                <th class="text-center tbl_srl_4">Dis%</th>
                                                <th class="text-center tbl_srl_7"> Dis Amount</th>
                                                <!-- grid changed start-->
                                                <th class="text-center tbl_srl_4" hidden>Tax%</th>
                                                <th class="text-center tbl_srl_7" hidden>Tax Amount</th>
                                                <th class="text-center tbl_srl_4" hidden>Inc.</th>
                                                <!-- grid changed End-->

                                                <th class="text-center tbl_srl_9">Net Amount</th>
                                                <th class="text-center tbl_srl_7">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody id="table_body">
                                            </tbody>
                                        </table>
                                    </div><!-- product table box end -->
                                </div><!-- product table container end -->
                                {{--Table end--}}
                            </div><!-- invoice row end -->
                        </div><!-- invoice column end -->
                        <div class="invoice_cntnt"><!-- container-fluid search-filter start -->
                            {{--hidden start--}}
                            <div class="invoice_col" hidden><!-- invoice column start -->
                                <div class="invoice_row row"><!-- invoice row start -->
                                    <div class="invoice_col col-md-4 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class=" invoice_col_ttl">
                                                <!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover"
                                                   data-trigger="hover"
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

                                                        <input tabindex="-1" type="radio" name="invoice_type"
                                                               class="invoice_type" id="invoice_type1"
                                                               value="1" checked>
                                                        Non Tax Invoice
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input tabindex="-1" type="radio" name="invoice_type"
                                                               class="invoice_type" id="invoice_type2"
                                                               value="2">
                                                        Tax Invoice
                                                    </label>
                                                </div>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col col-md-4 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover"
                                                   data-trigger="hover"
                                                   data-placement="left" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.description')}}</p>
                                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.benefits')}}</p>
                                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Product Tax
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_txt"><!-- invoice column input start -->
                                                <div class="invoice_inline_input_txt">
                                                    <!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl"
                                                           for="total_inclusive_tax">
                                                        Inclusive Tax
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text" name="total_inclusive_tax"
                                                               class="inputs_up form-control text-right"
                                                               id="total_inclusive_tax" readonly>
                                                    </div>
                                                </div><!-- invoice inline input text end -->
                                                <div class="invoice_inline_input_txt">
                                                    <!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl"
                                                           for="total_exclusive_tax">
                                                        Exclusive Tax
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text" name="total_exclusive_tax"
                                                               class="inputs_up form-control text-right"
                                                               id="total_exclusive_tax" readonly>
                                                    </div>
                                                </div><!-- invoice inline input text end -->

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->


                                    </div><!-- invoice column end -->

                                    <div class="invoice_col col-md-4 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover"
                                                   data-trigger="hover"
                                                   data-placement="left" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.description')}}</p>
                                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.benefits')}}</p>
                                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Service Tax
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_txt"><!-- invoice column input start -->
                                                <div class="invoice_inline_input_txt">
                                                    <!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl"
                                                           for="service_total_inclusive_tax">
                                                        Inclusive Tax
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text"
                                                               name="service_total_inclusive_tax"
                                                               class="inputs_up form-control text-right"
                                                               id="service_total_inclusive_tax"
                                                               readonly>
                                                    </div>
                                                </div><!-- invoice inline input text end -->
                                                <div class="invoice_inline_input_txt">
                                                    <!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl"
                                                           for="service_total_exclusive_tax">
                                                        Exclusive Tax
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text"
                                                               name="service_total_exclusive_tax"
                                                               class="inputs_up form-control text-right"
                                                               id="service_total_exclusive_tax"
                                                               readonly>
                                                    </div>
                                                </div><!-- invoice inline input text end -->

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->


                                    </div><!-- invoice column end -->


                                </div><!-- invoice row end -->

                            </div><!-- invoice column end -->
                            {{--hidden end--}}

                            {{--Lower section start--}}
                            <div class="invoice_row row"><!-- invoice row start -->
                                {{--Lower section col 1 --}}
                                <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="invoice_col_ttl"><!-- invoice column title start -->
                                            <a data-container="body" data-toggle="popover"
                                               data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).description')}}</p>
                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).benefits')}}</p>
                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Items Discount
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                            <div class="invoice_inline_input_txt">
                                                <!-- invoice inline input text start -->
                                                <label class="inline_input_txt_lbl"
                                                       for="total_product_discount">
                                                    Product Dis
                                                </label>
                                                <div class="invoice_col_input">
                                                    <input type="text" name="total_product_discount"
                                                           class="inputs_up form-control text-right lower_inputs lower_style"
                                                           id="total_product_discount" readonly>
                                                </div>
                                            </div><!-- invoice inline input text end -->
                                            <div class="invoice_inline_input_txt">
                                                <!-- invoice inline input text start -->
                                                <label class="inline_input_txt_lbl"
                                                       for="total_service_discount">
                                                    Service Dis
                                                </label>
                                                <div class="invoice_col_input">
                                                    <input type="text" name="total_service_discount"
                                                           class="inputs_up form-control text-right lower_inputs lower_style"
                                                           id="total_service_discount" readonly>
                                                </div>
                                            </div><!-- invoice inline input text end -->

                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->


                                </div><!-- invoice column end -->

                                {{--Lower section col 2 --}}
                                <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
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


                                            <div class="invoice_inline_input_txt">
                                                <!-- invoice inline input text start -->
                                                <label class="inline_input_txt_lbl" for="disc_amount">
                                                    Discount (Rs.)
                                                </label>
                                                <div class="invoice_col_input">
                                                    <input type="text" name="disc_amount" tabindex="8"
                                                           class="inputs_up form-control text-right lower_style"
                                                           id="disc_amount"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);"
                                                           onkeyup="grand_total_calculation_with_disc_amount();"
                                                           onfocus="this.select();">
                                                </div>
                                            </div><!-- invoice inline input text end -->


                                            <div class="invoice_inline_input_txt">
                                                <!-- invoice inline input text start -->
                                                <label class="inline_input_txt_lbl" for="disc_percentage">
                                                    Discount %
                                                </label>
                                                <div class="invoice_col_input">
                                                    <input type="text" name="disc_percentage" tabindex="9" readonly
                                                           class="inputs_up form-control text-right percentage_textbox lower_style lower_inputs"
                                                           id="disc_percentage"
                                                           placeholder=""
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
                                                           class="inputs_up form-control text-right lower_inputs lower_style"
                                                           id="total_discount" readonly>
                                                </div>
                                            </div><!-- invoice inline input text end -->

                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                {{--Lower section col 3 --}}
                                <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
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

                                            <div class="invoice_inline_input_txt">
                                                <!-- invoice inline input text start -->
                                                <label class="inline_input_txt_lbl" for="total_items">
                                                    Total Pack Items
                                                </label>
                                                <div class="invoice_col_input">
                                                    <input type="text" name="total_items"
                                                           data-rule-required="true" data-msg-required="Add Item"
                                                           class="inputs_up form-control text-right total-items-field lower_inputs lower_style"
                                                           id="total_items" readonly>
                                                </div>
                                            </div><!-- invoice inline input text end -->

                                            <div class="invoice_inline_input_txt">
                                                <!-- invoice inline input text start -->
                                                <label class="inline_input_txt_lbl" for="total_price">
                                                    Sub Total
                                                </label>
                                                <div class="invoice_col_input">
                                                    <input type="text" name="total_price"
                                                           data-rule-required="true" data-msg-required="Add Sub Total"
                                                           class="inputs_up form-control text-right lower_inputs lower_style"
                                                           id="total_price" readonly>
                                                </div>
                                            </div><!-- invoice inline input text end -->

                                            <div class="invoice_inline_input_txt" hidden>
                                                <!-- invoice inline input text start -->
                                                <label class="inline_input_txt_lbl" for="total_tax">
                                                    Total Taxes
                                                </label>
                                                <div class="invoice_col_input">
                                                    <input type="text" name="total_tax"
                                                           class="inputs_up form-control text-right lower_inputs"
                                                           id="total_tax" readonly>
                                                </div>
                                            </div><!-- invoice inline input text end -->

                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                {{--Lower section col 4 --}}
                                <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="invoice_col_ttl"><!-- invoice column title start -->
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Payment(Cash_Received/Credit_Card/Cash_Return).description')}}</p>
                                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.Payment(Cash_Received/Credit_Card/Cash_Return).benefits')}}</p>
                                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.Payment(Cash_Received/Credit_Card/Cash_Return).example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Payments
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_txt"><!-- invoice column input start -->

                                            <div class="invoice_inline_input_txt">
                                                <!-- invoice inline input text start -->
                                                <label class="inline_input_txt_lbl" for="cash_paid">
                                                    Cash Received
                                                </label>
                                                <div class="invoice_col_input">
                                                    <input type="text" name="cash_paid" tabindex="10"
                                                           class="inputs_up form-control text-right lower_style"
                                                           id="cash_paid" placeholder=""
                                                           onkeyup="grand_total_calculation_with_disc_amount();"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);"
                                                           onfocus="this.select();">
                                                </div>
                                            </div><!-- invoice inline input text end -->

                                            <div class="invoice_inline_input_txt">
                                                <!-- invoice inline input text start -->
                                                <label class="inline_input_txt_lbl" for="credit_card_number">
                                                    Credit Card
                                                </label>
                                                <div class="invoice_col_input">
                                                    <input type="text" name="credit_card_amount_view"
                                                           class="inputs_up form-control text-right lower_inputs lower_style"
                                                           id="credit_card_amount_view"
                                                           placeholder=""
                                                           onkeypress="return allow_only_number_and_decimals(this,event);"
                                                           onfocus="this.select();" readonly>
                                                </div>
                                            </div><!-- invoice inline input text end -->

                                            <div class="invoice_inline_input_txt">
                                                <!-- invoice inline input text start -->
                                                <label class="inline_input_txt_lbl"
                                                       for="service_total_exclusive_tax">
                                                    Party Ledger
                                                </label>
                                                <div class="invoice_col_input">
                                                    <input type="text" name="cash_return"
                                                           class="inputs_up form-control text-right lower_inputs lower_style"
                                                           id="cash_return" placeholder=""
                                                           readonly>
                                                </div>
                                            </div><!-- invoice inline input text end -->


                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                {{--Lower section col 5 --}}
                                <div class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_row row"><!-- invoice row start -->
                                        <div class="invoice_col form-group col-lg-12" id="zero_marg">
                                            <!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class=" invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    <a data-container="body" data-toggle="popover"
                                                       data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Discount_Type.description')}}</p>
                                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.Discount_Type.benefits')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Discount Type
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_txt mt-1"><!-- invoice column input start -->
                                                    <div class="invoice_inline_input_txt with_wrap">
                                                        <div class="radio">
                                                            <label for="discount_type1">
                                                                <input type="radio" name="discount_type"
                                                                       class="discount_type" id="discount_type1"
                                                                       value="1" checked>
                                                                Non
                                                            </label>
                                                        </div>

                                                        <div class="radio">
                                                            <label for="discount_type2">
                                                                <input type="radio" name="discount_type"
                                                                       class="discount_type" id="discount_type2"
                                                                       value="2">
                                                                Retailer
                                                            </label>
                                                        </div>

                                                        <div class="radio">
                                                            <label for="discount_type3">
                                                                <input type="radio" name="discount_type"
                                                                       class="discount_type" id="discount_type3"
                                                                       value="3">
                                                                Wholesaler
                                                            </label>
                                                        </div>

                                                        <div class="radio">
                                                            <label for="discount_type4">
                                                                <input type="radio" name="discount_type"
                                                                       class="discount_type" id="discount_type4"
                                                                       value="4">
                                                                Loyalty Card
                                                            </label>
                                                        </div>


                                                    </div>

                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col form-group col-lg-12"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <label class=" invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    <a data-container="body" data-toggle="popover"
                                                       data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.grand_total.description')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Grand Total
                                                </label><!-- invoice column title end -->
                                                <div class="invoice_col_txt ghiki mt-1">
                                                    <!-- invoice column input start -->
                                                    <h5 id="grand_total_text" data-rule-required="true"
                                                        data-msg-required="Please Add">
                                                        000,000
                                                    </h5>
                                                    <input type="hidden" name="grand_total" id="grand_total"
                                                           data-rule-required="true" data-msg-required="Please Add"/>


                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->


                                    </div><!-- invoice row end -->
                                </div><!-- invoice column end -->

                            </div><!-- invoice row end -->


                            {{--                            shortcut buttons--}}
                            <div class="invoice_row row"><!-- invoice row start -->

                                <div class="invoice_col form-group col-lg-12"><!-- invoice column start -->
                                    <div class="invoice_col_txt with_cntr_jstfy">
                                        <!-- invoice column box start -->
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button id="credit_card_btn" type="button" class="invoice_frm_btn">
                                                Credit Card (F1)
                                            </button>
                                        </div>
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button id="customer_info_btn" type="button"
                                                    class="invoice_frm_btn">
                                                Customer Info (F2)
                                            </button>
                                        </div>
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button id="cash_return_btn" type="button" class="invoice_frm_btn">
                                                Cash Return (F3)
                                            </button>
                                        </div>
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button id="clear_discount_btn" type="button"
                                                    class="invoice_frm_btn">
                                                Clear Discount
                                            </button>
                                        </div>
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button tabindex="11" type="submit" class="invoice_frm_btn" name="save"
                                                    id="save"
                                            >
                                                Save (Ctrl+S)
                                            </button>

                                        </div>
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button id="all_clear_form" type="button" class="invoice_frm_btn"
                                                    tabindex="12"
                                                    onFocus="document.querySelector('.autofocus2').focus()">
                                                Clear (Ctrl+X)
                                            </button>
                                        </div>

                                        <!-- invoice column box start -->
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button id="product_btn" type="button" class="invoice_frm_btn">
                                                Product (Ctrl+M)
                                            </button>
                                        </div>


                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button id="cash_paid_btn" type="button" class="invoice_frm_btn">
                                                Cash (Ctrl+L)
                                            </button>
                                        </div>


                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->


                            </div><!-- invoice row end -->
                        </div><!-- container-fluid search-filter end -->

                        {{--                            crdit card--}}
                        <div id="crdt_crd_mdl" class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl">
                            <!-- invoice small modal start -->
                            <div class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl_bx">
                                <!-- invoice small modal box start -->
                                <div class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl_scrl">
                                    <!-- invoice small modal scroll start -->

                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_sm_hdng">
                                        <!-- invoice small modal heading start -->
                                        <h5 class="gnrl-mrgn-pdng">
                                            Credit Card Information
                                        </h5>
                                    </div><!-- invoice small modal content end -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_sm_cntnt">
                                        <!-- invoice small modal heading start -->

                                        <div class="invoice_row row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Select Machine
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->
                                                            <a href="{{ url('add_credit_card_machine') }}"
                                                               class="col_short_btn" target="_blank">
                                                                <l class="fa fa-plus"></l>
                                                            </a>
                                                            <a id="refresh_machine" class="col_short_btn">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select name="machine"
                                                                class="inputs_up form-control js-example-basic-multiple"
                                                                id="machine">
                                                            <option value="0">Select Machine</option>
                                                            @foreach($machines as $machine)
                                                                <option
                                                                    value="{{$machine->ccm_id}}">{{$machine->ccm_title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Credit Card Number
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="credit_card_number"
                                                               class="inputs_up form-control"
                                                               id="credit_card_number"
                                                               placeholder="Credit Card Number"
                                                               onkeypress="return allowOnlyNumber(event);">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Amount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="credit_card_amount"
                                                               class="inputs_up form-control"
                                                               id="credit_card_amount"
                                                               placeholder="Credit Card Amount"
                                                               onkeypress="return allowOnlyNumber(event);"
                                                               onkeyup="grand_total_calculation_with_disc_amount();">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_txt with_cntr_jstfy">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        {{--                                                            change kro--}}
                                                        <button type="button" class="invoice_frm_btn sm_mdl_cls"
                                                                onclick="return credit_card_validation(); gotoCashRecover();"
                                                                id="card_info_save"
                                                        >
                                                            Save
                                                        </button>
                                                    </div>
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button type="button" class="invoice_frm_btn sm_mdl_cls"
                                                                id="credit_info_cancel_btn"
                                                                onclick="gotoCashRecover()">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                    </div><!-- invoice small modal content end -->

                                </div><!-- invoice small modal scroll end -->
                            </div><!-- invoice small modal box end -->
                        </div><!-- invoice small modal end -->

                        {{--customer info--}}
                        <div id="cstmr_info_mdl" class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl">
                            <!-- invoice small modal start -->
                            <div class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl_bx">
                                <!-- invoice small modal box start -->
                                <div class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl_scrl">
                                    <!-- invoice small modal scroll start -->

                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_sm_hdng">
                                        <!-- invoice small modal heading start -->
                                        <h5 class="gnrl-mrgn-pdng">
                                            Customer Information
                                        </h5>
                                    </div><!-- invoice small modal content end -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_sm_cntnt">
                                        <!-- invoice small modal heading start -->

                                        <div class="invoice_row row"><!-- invoice row start -->


                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Party Name
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="customer_name"
                                                               class="inputs_up form-control" id="customer_name"
                                                               onkeydown="return not_plus_minus(event)"
                                                               placeholder="Party Name">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Email
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="customer_email"
                                                               class="inputs_up form-control" id="customer_email"
                                                               onkeydown="return not_plus_minus(event)"
                                                               placeholder="Email">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Phone Number
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="customer_phone_number"
                                                               class="inputs_up form-control"
                                                               id="customer_phone_number"
                                                               onkeypress="return allow_only_number_and_decimals(this,event);"
                                                               placeholder="Phone Number">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_txt with_cntr_jstfy">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button type="button" class="invoice_frm_btn sm_mdl_cls"
                                                                id="customer_info_save_btn"
                                                                onclick="gotoCashRecover()">
                                                            Save
                                                        </button>
                                                    </div>
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button type="button" class="invoice_frm_btn sm_mdl_cls"
                                                                id="customer_info_cancel_btn"
                                                                onclick="gotoCashRecover()">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                    </div><!-- invoice small modal content end -->

                                </div><!-- invoice small modal scroll end -->
                            </div><!-- invoice small modal box end -->
                        </div><!-- invoice small modal end -->

                        {{--Cash Return--}}
                        <div id="cash_return_mdl" class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl">
                            <!-- invoice small modal start -->
                            <div class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl_bx">
                                <!-- invoice small modal box start -->
                                <div class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl_scrl">
                                    <!-- invoice small modal scroll start -->

                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_sm_hdng">
                                        <!-- invoice small modal heading start -->
                                        <h5 class="gnrl-mrgn-pdng">
                                            Cash Return Information
                                        </h5>
                                    </div><!-- invoice small modal content end -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_sm_cntnt">
                                        <!-- invoice small modal heading start -->

                                        <div class="invoice_row row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Cash Received From Customer
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="cash_received_from_customer"
                                                               class="inputs_up form-control"
                                                               id="cash_received_from_customer"
                                                               placeholder="Cash Received From Customer"
                                                               onkeypress="return allowOnlyNumber(event);"
                                                               onkeyup="cash_return_calculation_invoice();">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Invoice Cash Received
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="invoice_cash_received"
                                                               class="inputs_up form-control lower_inputs"
                                                               id="invoice_cash_received" tabindex="-1"
                                                               placeholder="Invoice Cash Received" readonly>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Invoice Cash Return
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="invoice_cash_return"
                                                               class="inputs_up form-control lower_inputs"
                                                               id="invoice_cash_return" tabindex="-1"
                                                               placeholder="Invoice Cash Return"
                                                               readonly>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_txt with_cntr_jstfy">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button type="button" class="invoice_frm_btn sm_mdl_cls"
                                                                id="cash_return_save_btn"
                                                                onclick="return credit_card_validation(); gotoCashRecover();">
                                                            Save
                                                        </button>
                                                    </div>
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button type="button" class="invoice_frm_btn sm_mdl_cls"
                                                                id="cash_return_cancel_btn"
                                                                onclick="gotoCashRecover()">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                    </div><!-- invoice small modal content end -->

                                </div><!-- invoice small modal scroll end -->
                            </div><!-- invoice small modal box end -->
                        </div><!-- invoice small modal end -->

                    </form>
                    {{--form end--}}


                </div><!-- invoice box end -->
            </div><!-- invoice container end -->

        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Trade Sales Invoice Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="printbody">

                    <div id="table_body">

                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                    onclick="gotoParty()"
                                    data-dismiss="modal">
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
    <script type="text/javascript">
        function checkForm() {

            // var abcd = jQuery("#product_inclusive_rate" + 1).val();
            // alert(abcd);


            if (document.getElementById('detail_remarks_type1').checked || document.getElementById('detail_remarks_type0').checked) {

                let account_name = document.getElementById("account_name"),
                    posting_reference = document.getElementById("posting_reference"),
                    total_items = document.getElementById("total_items"),
                    total_price = document.getElementById("total_price"),
                    grand_total = document.getElementById("grand_total"),
                    grand_total_text = document.getElementById("grand_total_text"),
                    validateInputIdArray = [
                        account_name.id,
                        posting_reference.id,
                        total_items.id,
                        total_price.id,
                        grand_total.id,
                        grand_total_text.id,
                    ];
                return validateInventoryInputs(validateInputIdArray);

            } else {
                $('#language_error_msg').text("Please Select Language of Invoice");
                return false;
            }
        }
    </script>
    @if (Session::get('si_id'))
        <script>
            jQuery("#table_body").html("");

            var id = '{{ Session::get("si_id") }}';

            $('.modal-body').load('{{url("trade_sale_items_view_details/view/") }}' + '/' + id, function () {
                $("#myModal").modal({show: true});


                // for print preview to not remain on screen
                if ($('#quick_print').is(":checked")) {

                    setTimeout(function () {
                        var abc = $("#printi");
                        abc.click();


                        $('.invoice_sm_mdl').css('display', 'none');
                        $('.cancel_button').click();
                        $('#product').focus();
                    }, 100);
                }


            });
        </script>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"
            integrity="sha512-JZSo0h5TONFYmyLMqp8k4oPhuo6yNk9mHM+FY50aBjpypfofqtEWsAgRDQm94ImLCzSaHeqNvYuD9382CEn2zw=="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@6.4.1"></script>

    <script>
        var PRODUCTS_COLUMNS_NAMES = [
            'pro_p_code',
            'pro_title',
            'pro_code',
            'pro_alternative_code',
        ];
        var GET_PRODUCTS_ROUTE = '{{ route('ajax_get_json_products') }}';


    </script>

    <script src="{{ asset('public/plugins/custom-search/custom-search_2.js') }}"></script>

    {{--    refresh scripts--}}
    <script>
        $("#account_name").change(function () {
            var party = $(this).val();
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_sale_person",
                data: {party: party},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    var option = '<option value="' + data[0].user_id + '">' + data[0].user_name + '</option>';
                    jQuery("#sale_person").html(" ");
                    jQuery("#sale_person").append(option);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);s
                }
            });
        });

        jQuery("#refresh_sale_person").click(function () {
            // alert('warehouse');
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_sale_person",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#sale_person").html(" ");
                    jQuery("#sale_person").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);s
                }
            });
        });


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

        jQuery("#refresh_machine").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_credit_card_machine",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#machine").html(" ");
                    jQuery("#machine").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
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

        // jQuery("#refresh_account_name").click(function () {
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "refresh_sale_account_name",
        //         data: {},
        //         type: "POST",
        //         cache: false,
        //         dataType: 'json',
        //         success: function (data) {
        //
        //             jQuery("#account_code").html(" ");
        //             jQuery("#account_code").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {
        //             alert(jqXHR.responseText);
        //             alert(errorThrown);
        //         }
        //     });
        // });
        //
        // jQuery("#refresh_account_name").click(function () {
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "refresh_sale_account_name",
        //         data: {},
        //         type: "POST",
        //         cache: false,
        //         dataType: 'json',
        //         success: function (data) {
        //
        //             jQuery("#account_name").html(" ");
        //             jQuery("#account_name").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {
        //             alert(jqXHR.responseText);
        //             alert(errorThrown);
        //         }
        //     });
        // });


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

        //       changed by nabeel
        jQuery("#refresh_product_name").click(function () {

            var GET_PRODUCTS_ROUTE = '{{ route('ajax_get_json_products') }}';
            sirf_reload(GET_PRODUCTS_ROUTE);

        });
    </script>

    <script>

        jQuery("#customer_info_cancel_btn").click(function () {
            jQuery('#customer_name').val('');
            jQuery('#customer_email').val('');
            jQuery('#customer_phone_number').val('');
        });

        jQuery("#credit_info_cancel_btn").click(function () {
            // jQuery('#machine option[value="' + 0 + '"]').prop('selected', true);
            $("#machine").select2().val(0).trigger("change");
            $("#machine > option").removeAttr('selected');

            jQuery('#credit_card_number').val('');
            jQuery('#credit_card_amount').val('');
            jQuery('#credit_card_amount_view').val('');

            grand_total_calculation_with_disc_amount();
        });

        jQuery("#credit_card_amount").keyup(function () {

            var amount = jQuery(this).val();
            jQuery('#credit_card_amount_view').val(amount);
        });

        // nabeel scripts

        // simple functions to handle focus
        function gotoCashRecover() {
            $("#cash_paid").focus();
        }

        function gotoParty() {
            $("#account_name").focus();
        }


        function focus_stay_on_product(evt) {
            if (evt.keyCode == 9) {  //means
                // alert("Tab pressed");
                if ($("#product")[0] == $(document.activeElement)[0]) {
                    evt.preventDefault();
                }
            }
        }

        function tab_within_table(evt, counter) {
            // alert("function called");
            if (evt.keyCode == 107) {   //means plus +

                if ($("#display_quantity" + counter)[0] == $(document.activeElement)[0]) {
                    $("#rate_per_pack" + counter).focus();
                } else if ($("#rate_per_pack" + counter)[0] == $(document.activeElement)[0]) {
                    $("#unit_qty" + counter).focus();
                } else if ($("#rate" + counter)[0] == $(document.activeElement)[0]) {
                    $("#bonus" + counter).focus();
                } else if ($("#unit_qty" + counter)[0] == $(document.activeElement)[0]) {
                    $("#rate" + counter).focus();
                } else if ($("#rate" + counter)[0] == $(document.activeElement)[0]) {
                    $("#bonus" + counter).focus();
                } else if ($("#bonus" + counter)[0] == $(document.activeElement)[0]) {
                    $("#trade_offer" + counter).focus();
                } else if ($("#trade_offer" + counter)[0] == $(document.activeElement)[0]) {
                    $("#product_discount" + counter).focus();
                } else if ($("#product_discount" + counter)[0] == $(document.activeElement)[0]) {
                    $("#product").focus();
                }
            }
            if (event.keyCode === 109) {   //means minus(-)

                // within table tab functionality
                if ($("#rate_per_pack" + counter)[0] == $(document.activeElement)[0]) {
                    $("#display_quantity" + counter).focus();
                } else if ($("#rate" + counter)[0] == $(document.activeElement)[0]) {
                    $("#unit_qty" + counter).focus();
                } else if ($("#unit_qty" + counter)[0] == $(document.activeElement)[0]) {
                    $("#rate_per_pack" + counter).focus();
                } else if ($("#display_quantity" + counter)[0] == $(document.activeElement)[0]) {
                    // $("#product").focus();
                } else if ($("#bonus" + counter)[0] == $(document.activeElement)[0]) {
                    $("#rate" + counter).focus();
                } else if ($("#trade_offer" + counter)[0] == $(document.activeElement)[0]) {
                    $("#bonus" + counter).focus();
                } else if ($("#product_discount" + counter)[0] == $(document.activeElement)[0]) {
                    $("#trade_offer" + counter).focus();
                } else if ($("#product_discount_amount" + counter)[0] == $(document.activeElement)[0]) {
                    $("#product_discount" + counter).focus();
                }

            }
        }

        // stop inputs to write + and -
        function not_plus_minus(evt) {
            if (evt.keyCode == 107 || evt.keyCode == 109) {
                evt.preventDefault();
            }
        }


        // when focus out from product table do not show its search table
        function hideproducts() {
            setTimeout(function () {
                $('.ps__search__results').css({
                    'display': 'none'
                });
            }, 500);
        }

        // to store data on browser start
        function store_print_checkbox() {

            if ($('#quick_print').is(":checked")) {
                var check_quick_print = 1;
            } else {
                var check_quick_print = 0;
            }

            if (typeof (Storage) !== "undefined") {
                // Store
                localStorage.setItem("quick_print_check", check_quick_print);
            }

        }

        function retrive_print_checkbox_data() {
            // Check browser support
            if (typeof (Storage) !== "undefined") {

                if (localStorage.getItem("quick_print_check") === "1") {
                    // Check
                    $("#quick_print").prop("checked", true);
                }

            } else {
                // document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
            }
        }


        function storecheckbox() {

            if ($('#add_auto_material').is(":checked")) {
                var check_auto_add = 1;
            } else {
                var check_auto_add = 0;
            }

            if (typeof (Storage) !== "undefined") {
                // Store
                localStorage.setItem("Auto_add_check", check_auto_add);
            }

        }

        function retrive_checkbox_data() {
            // Check browser support
            if (typeof (Storage) !== "undefined") {

                if (localStorage.getItem("Auto_add_check") === "1") {
                    // Check
                    $("#add_auto_material").prop("checked", true);
                }

            } else {
                // document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
            }
        }

        // to store data on browser end


        function credit_card_validation(event) {
            var machine = $("#machine").val();
            var credit_card_number = $("#credit_card_number").val();
            var credit_card_amount = $("#credit_card_amount").val();

            var flag_submit = true;
            var focus_once = 0;

            if (machine.trim() == "0") {
                if (focus_once == 0) {
                    jQuery("#machine").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            if (credit_card_number.trim() == "") {
                if (focus_once == 0) {
                    jQuery("#credit_card_number").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            if (credit_card_amount.trim() == "") {
                if (focus_once == 0) {
                    jQuery("#credit_card_amount").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            $("#cash_paid").focus();
            return flag_submit;
        }

        function popvalidation() {
            isDirty = true;

            var account_name = $("#account_name").val();
            var machine = $("#machine").val();
            var customer_email = $("#customer_email").val();
            var total_items = $("#total_items").val();
            var cash_paid = $("#cash_paid").val();
            var grand_total = $("#grand_total").val();

            var credit_card_number = $("#credit_card_number").val();
            var credit_card_amount = $("#credit_card_amount").val();


            var flag_submit = true;
            var focus_once = 0;

            var temp_grand_total = +cash_paid + +credit_card_amount;

            if (account_name.trim() == "0") {
                var isDirty = false;

                if (focus_once == 0) {
                    jQuery("#account_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }


            if (machine.trim() != "0") {

                if (credit_card_number.trim() == "") {
                    if (focus_once == 0) {
                        $("#credit_card_btn").click();
                        jQuery("#credit_card_number").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (credit_card_amount.trim() == "") {
                    if (focus_once == 0) {
                        $("#credit_card_btn").click();
                        jQuery("#credit_card_amount").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

            }


            if (total_items == 0) {
                var isDirty = false;
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

                quantity = +jQuery("#display_quantity" + pro_field_id).val();
                rate = jQuery("#rate" + pro_field_id).val();

                if (quantity <= 0 || quantity == "") { /* Changed by Abdullah: old ->  if (quantity < 1 || quantity == "")   */
                    if (focus_once == 0) {
                        jQuery("#display_quantity" + pro_field_id).focus();
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

            if (grand_total < 0) {
                if (focus_once == 0) {
                    document.getElementById("check_product_count").innerHTML = "Grand Total Cannot Be Less Than Zero";
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("check_product_count").innerHTML = "";
            }
            return flag_submit;
        }


    </script>

    <script>
        // adding sales into table
        var counter = 0;
        var total_discount = 0;

        function unit_rate_changed_live(id) {
            var unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + id).val();
            var unit_rate_piece = (jQuery("#rate_per_pack" + id).val() !== 0 || jQuery("#rate_per_pack" + id).val() !== "NaN" || jQuery("#rate_per_pack" + id).val() !== "") ? jQuery("#rate_per_pack" + id).val() : 1;
            var rate = parseFloat(unit_rate_piece / unit_measurement_scale_size);

            if (rate > 0) {
                jQuery("#rate" + id).val(rate);
            }
            var newRate = (rate === "" || rate === 0) ? 1 : rate;

            product_amount_calculation(id, newRate);
        }


        // function calculate_dis_percentage(id) {
        //     // alert("amount");
        //     var gross_amount = jQuery("#gross_amount" + id).val();  //nabeel
        //     var get_product_discount_amount = jQuery("#product_discount_amount" + id).val();  //nabeel
        //     // var discount_percentage = (gross_amount * get_product_discount_amount) / 100;
        //     var discount_percentage = (100 * get_product_discount_amount) / gross_amount;
        //     jQuery("#product_discount" + id).val(discount_percentage);
        //
        //     setTimeout(function () {
        //         product_amount_calculation(id);
        //     }, 800);
        // }


        function product_amount_calculation_with_dis_amount(id, newRate = 0) {

            var display_quantity = jQuery("#display_quantity" + id).val();
            var unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + id).val();
            var rate = (newRate === 0 || newRate === "") ? jQuery("#rate" + id).val() : newRate;
            // var product_discount = jQuery("#product_discount" + id).val();
            var product_discount_amount = jQuery("#product_discount_amount" + id).val();  //nabeel
            var gross_amount = jQuery("#gross_amount" + id).val();  //nabeel

            var product_sales_tax = jQuery("#product_sales_tax" + id).val();
            var rate_per_pack = 0;
            // var trade_off = 0;
            var unit_qty = jQuery("#unit_qty" + id).val();//mustafa

            if (unit_qty >= parseFloat(unit_measurement_scale_size)) {
                unit_qty = 0;
                jQuery("#unit_qty" + id).val('');
            }

            // nabbel
            display_quantity = Math.round(display_quantity);
            jQuery("#display_quantity" + id).val(display_quantity);


            var trade_offer = jQuery("#trade_offer" + id).val();//mustafa

            //nabeel
            // if (newRate === 0 || newRate === "") {
            rate_per_pack = rate * unit_measurement_scale_size;
            // }
            // var gross_amount = quantity * rate;
            var gross_amount = +((unit_measurement_scale_size * display_quantity) + +unit_qty) * rate;  //mustafa

            var quantity = +unit_qty + +(display_quantity * unit_measurement_scale_size);
            if (quantity == "") {
                quantity = 0;
            }


            // round_off_discount = grand_total - Math.round(grand_total);

            var product_sale_tax_amount;
            var product_rate_after_discount;
            var product_inclusive_rate;
            // var product_discount_amount;
            var discount_percentage;

            if ($("#inclusive_exclusive" + id).prop("checked") == true) {

                jQuery("#inclusive_exclusive_status_value" + id).val(1);

                product_discount_amount = (((rate / (+product_sales_tax + +100) * 100)) * product_discount / 100) * quantity;

                product_rate_after_discount = +(rate - (product_discount_amount / (quantity)));

                // nabeel start
                // product_inclusive_rate = (((rate / (+product_sales_tax + +100)) * 100) - ((rate / (+product_sales_tax + +100)) * 100) * product_discount / 100) - (trade_offer / (quantity));

                product_inclusive_rate = 0;
                // nabeel end

                product_sale_tax_amount = (rate - ((rate / (+product_sales_tax + +100)) * 100)) * quantity;

            } else {
                jQuery("#inclusive_exclusive_status_value" + id).val(0);

                // product_discount_amount = (rate * product_discount / 100) * quantity;
                // if(parseFloat(product_discount) != null){


                // product_discount_amount = (rate * product_discount / 100) * quantity; // nabeel major cahnge
                var discount_percentage = (100 * product_discount_amount) / gross_amount;


                // jQuery("#product_discount_amount" + id).val('');  //nabeel
                // alert('%');

                // }else if(parseFloat(get_product_discount_amount) != 0){
                //     alert('amount');
                //     // disc_percentage_amount = (total_price * disc_percentage) / 100;
                //     discount_percentage = (gross_amount * get_product_discount_amount) / 100;
                //     jQuery("#product_discount" + id).val('');

                // }


                // get_product_discount_amount =    //nabeel


                if (quantity == '' || quantity == 0) {
                    product_rate_after_discount = 0;
                } else {
                    // product_rate_after_discount = rate - (product_discount_amount / (quantity));
                    product_rate_after_discount = rate - (product_discount_amount / (quantity));//mustafa
                }


                // nabeel start
                // product_inclusive_rate = +product_rate_after_discount - (trade_offer / (quantity));
                product_inclusive_rate = 0;
                // nabeel end

                // product_sale_tax_amount = (product_rate_after_discount * product_sales_tax / 100) * quantity;
                product_sale_tax_amount = (product_rate_after_discount * product_sales_tax / 100) * quantity; //mustafa
            }

            // var amount = (quantity * product_inclusive_rate) + product_sale_tax_amount;
            var amount = gross_amount - trade_offer - product_discount_amount; //mustafa

            jQuery("#amount" + id).val(amount.toFixed(2));
            jQuery("#product_sale_tax_amount" + id).val(product_sale_tax_amount.toFixed(2));
            jQuery("#product_inclusive_rate" + id).val(product_inclusive_rate.toFixed(2));
            // jQuery("#product_discount_amount" + id).val(product_discount_amount.toFixed(2));
            jQuery("#product_discount" + id).val(discount_percentage.toFixed(2));


            if (newRate === 0 || newRate === "") {
                jQuery("#rate_per_pack" + id).val(rate_per_pack);
            }
            jQuery("#gross_amount" + id).val(gross_amount.toFixed(2));
            jQuery("#quantity" + id).val(quantity.toFixed(3));

            grand_total_calculation_with_disc_amount();
        }


        function product_amount_calculation(id, newRate = 0) {

            var display_quantity = jQuery("#display_quantity" + id).val();
            var unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + id).val();
            var rate = (newRate === 0 || newRate === "") ? jQuery("#rate" + id).val() : newRate;
            var product_discount = jQuery("#product_discount" + id).val();
            // var get_product_discount_amount = jQuery("#product_discount_amount" + id).val();  //nabeel
            var gross_amount = jQuery("#gross_amount" + id).val();  //nabeel

            var product_sales_tax = jQuery("#product_sales_tax" + id).val();
            var rate_per_pack = 0;
            // var trade_off = 0;
            var unit_qty = jQuery("#unit_qty" + id).val();//mustafa

            if (unit_qty >= parseFloat(unit_measurement_scale_size)) {

                unit_qty = 0;
                jQuery("#unit_qty" + id).val('');
            }

            // nabeel
            display_quantity = Math.round(display_quantity);
            jQuery("#display_quantity" + id).val(display_quantity);


            var trade_offer = jQuery("#trade_offer" + id).val();//mustafa


            //nabeel
            // if (newRate === 0 || newRate === "") {

            if (unit_measurement_scale_size == "") {   //if service is entered

                var quantity = display_quantity;
                gross_amount = display_quantity * rate;


                jQuery("#unit_qty" + id).prop("disabled", true);
                jQuery("#rate_per_pack" + id).prop("disabled", true);

                jQuery("#trade_offer" + id).prop("readonly", true);
                // jQuery("#product_discount" + id).prop( "disabled", true );
                // jQuery("#product_discount_amount" + id).prop( "disabled", true );

            } else {
                rate_per_pack = rate * unit_measurement_scale_size;


                // if (isNaN(rate_per_pack)) {

                //     rate_per_pack = "";
                // }
                // }
                // var gross_amount = quantity * rate;
                var gross_amount = +((unit_measurement_scale_size * display_quantity) + +unit_qty) * rate;  //mustafa

                // if (isNaN(gross_amount)) {

                //     gross_amount = display_quantity * rate;
                // }


                //
                var quantity = +unit_qty + +(display_quantity * unit_measurement_scale_size)


                //
                // if (isNaN(quantity)) {

                //     quantity = 0;
                // }
            }


            // round_off_discount = grand_total - Math.round(grand_total);

            var product_sale_tax_amount;
            var product_rate_after_discount;
            var product_inclusive_rate;
            var product_discount_amount;
            // var discount_percentage;

            if ($("#inclusive_exclusive" + id).prop("checked") == true) {

                jQuery("#inclusive_exclusive_status_value" + id).val(1);

                product_discount_amount = (((rate / (+product_sales_tax + +100) * 100)) * product_discount / 100) * quantity;

                product_rate_after_discount = rate - (product_discount_amount / (quantity));

                // nabeel start
                // product_inclusive_rate = (((rate / (+product_sales_tax + +100)) * 100) - ((rate / (+product_sales_tax + +100)) * 100) * product_discount / 100) - (trade_offer / (quantity));
                product_inclusive_rate = 0;

                // nabeel end

                product_sale_tax_amount = (rate - ((rate / (+product_sales_tax + +100)) * 100)) * quantity;

            } else {
                jQuery("#inclusive_exclusive_status_value" + id).val(0);

                // product_discount_amount = (rate * product_discount / 100) * quantity;
                // if(parseFloat(product_discount) != null){
                product_discount_amount = (rate * product_discount / 100) * quantity; //mustafa

                product_discount_amount = product_discount_amount.toFixed(2);


                // jQuery("#product_discount_amount" + id).val('');  //nabeel


                // }else if(parseFloat(get_product_discount_amount) != 0){

                //     // disc_percentage_amount = (total_price * disc_percentage) / 100;
                //     discount_percentage = (gross_amount * get_product_discount_amount) / 100;
                //     jQuery("#product_discount" + id).val('');

                // }


                // get_product_discount_amount =    //nabeel


                if (quantity == '' || quantity == 0) {
                    product_rate_after_discount = 0;
                } else {
                    // product_rate_after_discount = rate - (product_discount_amount / (quantity));
                    product_rate_after_discount = rate - (product_discount_amount / (quantity));//mustafa
                }


                // nabeel start
                // product_inclusive_rate = product_rate_after_discount - (trade_offer / (quantity));
                product_inclusive_rate = 0;
                // nabeel end


                // product_sale_tax_amount = (product_rate_after_discount * product_sales_tax / 100) * quantity;
                product_sale_tax_amount = (product_rate_after_discount * product_sales_tax / 100) * quantity; //mustafa
            }

            // var amount = (quantity * product_inclusive_rate) + product_sale_tax_amount;
            var amount = gross_amount - trade_offer - product_discount_amount; //mustafa

            jQuery("#amount" + id).val(amount.toFixed(2));
            jQuery("#product_sale_tax_amount" + id).val(product_sale_tax_amount.toFixed(2));
            jQuery("#product_inclusive_rate" + id).val(product_inclusive_rate.toFixed(2));
            jQuery("#product_discount_amount" + id).val(product_discount_amount);
            // jQuery("#product_discount" + id).val(discount_percentage);


            if (newRate === 0 || newRate === "") {
                jQuery("#rate_per_pack" + id).val(rate_per_pack);
            }
            jQuery("#gross_amount" + id).val(gross_amount.toFixed(2));
            jQuery("#quantity" + id).val(quantity.toFixed(3));

            grand_total_calculation_with_disc_amount();
        }

        function checkQty(id) {
            var quantity = jQuery("#quantity" + id).val();
            var scale_size = jQuery("#unit_measurement_scale_size" + id).val();
            ;
            if (quantity < 1) {
                if (scale_size > 1) {
                    jQuery("#unit_qty" + id).val(1);
                } else {
                    jQuery("#display_quantity" + id).val(1);
                }

                product_amount_calculation(id);
            }

        }

        function grand_total_calculation() {

            var disc_percentage = jQuery("#disc_percentage").val();

            var total_price = 0;
            var total_product_discount = 0;
            var total_service_discount = 0;
            var total_inclusive_sale_tax_amount = 0;
            var total_exclusive_sale_tax_amount = 0;
            var service_total_inclusive_sale_tax_amount = 0;
            var service_total_exclusive_sale_tax_amount = 0;
            var total_sale_tax_amount = 0;
            var grand_total = 0;
            var round_off_discount = 0;
            var disc_percentage_amount = 0;


            var product_quantity;
            var product_rate;
            var product_discount_amount = 0;
            var product_sale_tax_amount = 0;
            var product_amount = 0;
            var product_or_service_status;
            //nabeel
            var trade_offer = 0;
            var total_trade_offer = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#display_quantity" + pro_field_id).val();
                product_unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + pro_field_id).val();
                product_rate = jQuery("#rate" + pro_field_id).val();
                product_discount_amount = jQuery("#product_discount_amount" + pro_field_id).val();

                product_sale_tax_amount = jQuery("#product_sale_tax_amount" + pro_field_id).val();
                product_amount = jQuery("#amount" + pro_field_id).val();
                gross_amount = jQuery("#gross_amount" + pro_field_id).val();
                product_or_service_status = jQuery("#product_or_service_status" + pro_field_id).val();
                //nabeel
                trade_offer = jQuery("#trade_offer" + pro_field_id).val();

                // total_price = +total_price + +(parseFloat(product_rate) * parseFloat(product_quantity));
                total_price = +total_price + +gross_amount; //nabeel

                total_trade_offer = +total_trade_offer + +trade_offer;

                if (product_or_service_status == 0) {
                    total_product_discount = +total_product_discount + +product_discount_amount;

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                        total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                    } else {
                        total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                    }
                } else {

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                        service_total_inclusive_sale_tax_amount = +service_total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                    } else {
                        service_total_exclusive_sale_tax_amount = +service_total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                    }

                    total_service_discount = +total_service_discount + +product_discount_amount;
                }


                // if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                //
                //     total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;
                //
                // } else {
                //     total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                // }

                total_sale_tax_amount = +total_sale_tax_amount + +product_sale_tax_amount;

                grand_total = +grand_total + +product_amount;
            });

            disc_percentage_amount = (total_price * disc_percentage) / 100;

            total_discount = +total_product_discount + +total_service_discount + +disc_percentage_amount;

            grand_total = +(total_price - total_discount - total_trade_offer) + +total_exclusive_sale_tax_amount;

            var radioValue = $("input[name='round_off']:checked").val();

            if (radioValue == 1) {
                round_off_discount = grand_total - Math.round(grand_total);
            }

            total_discount = +total_discount + +round_off_discount;

            grand_total = grand_total - round_off_discount;

            jQuery("#total_price").val(total_price.toFixed(2));
            jQuery("#total_product_discount").val(total_product_discount.toFixed(2));
            jQuery("#total_service_discount").val(total_service_discount.toFixed(2));
            jQuery("#round_off_discount").val(round_off_discount.toFixed(2));
            jQuery("#disc_amount").val(disc_percentage_amount.toFixed(2));
            jQuery("#total_discount").val(total_discount.toFixed(2));
            jQuery("#total_inclusive_tax").val(total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_exclusive_tax").val(total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#service_total_inclusive_tax").val(service_total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#service_total_exclusive_tax").val(service_total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_tax").val(total_sale_tax_amount.toFixed(2));
            jQuery("#grand_total").val(grand_total.toFixed(2));

            // var total_items = $('input[name="pro_code[]"]').length;
            var total_items = 0;


            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                //nabeel change
                var proQuantity = jQuery("#quantity" + pro_field_id).val();
                total_items = total_items + parseFloat(proQuantity);
                console.log(total_items);
            });

            jQuery("#total_items").val(total_items);
            $("#grand_total_text").text(Number(grand_total.toFixed(2)).toLocaleString('en'));

            cash_return_calculation();
        }

        function grand_total_calculation_with_disc_amount() {

            var disc_percentage = 0;
            var disc_amount = jQuery("#disc_amount").val();

            var total_price = 0;
            var total_product_discount = 0;
            var total_service_discount = 0;
            var total_inclusive_sale_tax_amount = 0;
            var total_exclusive_sale_tax_amount = 0;
            var service_total_inclusive_sale_tax_amount = 0;
            var service_total_exclusive_sale_tax_amount = 0;
            var total_sale_tax_amount = 0;
            var grand_total = 0;
            var round_off_discount = 0;
            var disc_percentage_amount = disc_amount;


            var product_quantity;
            var product_unit_measurement_scale_size;
            var product_rate;
            var product_discount_amount = 0;
            var product_sale_tax_amount = 0;
            var product_amount = 0;
            var product_or_service_status;

            //nabeel
            var trade_offer = 0;
            var total_trade_offer = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#display_quantity" + pro_field_id).val();
                product_unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + pro_field_id).val();
                product_rate = jQuery("#rate" + pro_field_id).val();
                product_discount_amount = jQuery("#product_discount_amount" + pro_field_id).val();
                product_sale_tax_amount = jQuery("#product_sale_tax_amount" + pro_field_id).val();
                product_amount = jQuery("#amount" + pro_field_id).val();
                product_or_service_status = jQuery("#product_or_service_status" + pro_field_id).val();
                //nabeel
                trade_offer = jQuery("#trade_offer" + pro_field_id).val();
                gross_amount = jQuery("#gross_amount" + pro_field_id).val();


                total_trade_offer = +total_trade_offer + +trade_offer;


                // total_price = +total_price + +(product_rate * product_quantity);
                total_price = +total_price + +gross_amount; //nabeel

                // total_product_discount = +total_product_discount + +product_discount_amount;
                //
                // if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                //
                //     total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;
                //
                // } else {
                //     total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                // }


                if (product_or_service_status == 0) {
                    total_product_discount = +total_product_discount + +product_discount_amount;

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                        total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                    } else {
                        total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                    }
                } else {

                    // alert("service");

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                        service_total_inclusive_sale_tax_amount = +service_total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                    } else {
                        service_total_exclusive_sale_tax_amount = +service_total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                    }

                    total_service_discount = +total_service_discount + +product_discount_amount;
                    // alert(total_service_discount);

                }

                total_sale_tax_amount = +total_sale_tax_amount + +product_sale_tax_amount;

                grand_total = +grand_total + +product_amount;
            });

            if (total_price != 0) {
                disc_percentage = (disc_amount * 100) / total_price;
            } else {
                disc_percentage = 0;
            }


            total_discount = +total_product_discount + +total_service_discount + +disc_percentage_amount;
            // alert(disc_percentage_amount);

            grand_total = +(total_price - total_discount - total_trade_offer) + +total_exclusive_sale_tax_amount;
            // alert(total_discount);


            var radioValue = $("input[name='round_off']:checked").val();

            if (radioValue == 1) {
                round_off_discount = grand_total - Math.round(grand_total);
            }

            total_discount = +total_discount + +round_off_discount + +total_trade_offer;

            grand_total = grand_total - round_off_discount;

            jQuery("#total_price").val(total_price.toFixed(2));
            jQuery("#total_product_discount").val(total_product_discount.toFixed(2));
            jQuery("#total_service_discount").val(total_service_discount.toFixed(2));
            jQuery("#round_off_discount").val(round_off_discount.toFixed(2));
            jQuery("#disc_percentage").val(disc_percentage.toFixed(2));
            jQuery("#total_discount").val(total_discount.toFixed(2));
            jQuery("#total_inclusive_tax").val(total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_exclusive_tax").val(total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#service_total_inclusive_tax").val(service_total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#service_total_exclusive_tax").val(service_total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_tax").val(total_sale_tax_amount.toFixed(2));
            jQuery("#grand_total").val(grand_total.toFixed(2));

            // var total_items = $('input[name="pro_code[]"]').length;

            // may be cause problem
            // jQuery("#total_items").val(total_items);


            var total_items = 0;

            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                //nabeel change
                var proQuantity = jQuery("#quantity" + pro_field_id).val();
                total_items = total_items + parseFloat(proQuantity);
                console.log(total_items);
            });

            jQuery("#total_items").val(total_items);


            $("#grand_total_text").text(Number(grand_total.toFixed(2)).toLocaleString('en'));

            cash_return_calculation();
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


            /**
             * Chaning according to Ahmad Hassan Sahab
             * One Product Multi time enter with separate index
             */

            if (!$("#check_multi_time").is(':checked')) {
                if (!$("#check_multi_warehouse").is(':checked')) {
                    $('input[name="pro_code[]"]').each(function (pro_index) {
                        pro_code = $(this).val();
                        pro_field_id_title = $(this).attr('id');
                        pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                        if (pro_code == parent_code) {
                            quantity = +jQuery("#display_quantity" + pro_field_id).val() + +quantity;
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
                }
            }

            /**
             * Chaning according to Ahmad Hassan Sahab End
             * One Product Multi time enter with separate index
             */

            add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 1, unit_measurement, "", "", "", "", 1, "", 0, 0);

            product_amount_calculation(counter);
        });


        function productChanged(product) {
            counter++;
            add_first_item();
            var code = product.pro_p_code;
            var parent_code = product.pro_p_code;
            var name = product.pro_title;
            var bottom = product.pro_bottom_price;
            var lastPR = product.pro_last_purchase_rate;
            var unit_measurement_scale_size = product.unit_scale_size;

            var quantity = unit_measurement_scale_size * 1;
            var pack_qty = Math.floor(quantity / unit_measurement_scale_size);//mustafa
            var unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);
            // var pack_qty=1;
            // var unit_qty=0;
            var unit_measurement = product.unit_title;
            var main_unit_measurement = product.mu_title;
            var bonus_qty = '';
            var rate = product.pro_sale_price;
            var inclusive_rate = 0;
            var discount = 0;
            var discount_amount = 0;
            var sales_tax = product.pro_tax;
            var sale_tax_amount = 0;
            var amount = 0;
            var remarks = '';
            var rate_after_discount = 0;
            var inclusive_exclusive = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            var rate_per_pack = rate * unit_measurement_scale_size;
            var gross_amount = quantity * rate;

            /**
             * Chaning according to Ahmad Hassan Sahab
             * One Product Multi time enter with separate index
             */
            if (!$("#check_multi_time").is(':checked')) {
                if (!$("#check_multi_warehouse").is(':checked')) {
                    $('input[name="pro_code[]"]').each(function (pro_index) {
                        pro_code = $(this).val();
                        pro_field_id_title = $(this).attr('id');
                        pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                        if (pro_code == parent_code) {

                            quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                            pack_qty = Math.floor(quantity / unit_measurement_scale_size);//mustafa
                            unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);

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
                }
            }


            /**
             * Chaning according to Ahmad Hassan Sahab End
             * One Product Multi time enter with separate index
             */


            if ($(".invoice_type").is(':checked')) {
                if ($(".invoice_type:checked").val() == 1) {
                    sales_tax = 0;
                }
            }

            // if ($(".discount_type").is(':checked')) {
            //     if ($(".discount_type:checked").val() == 1) {
            //         discount = 0;
            //     } else if ($(".discount_type:checked").val() == 2) {
            //         discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
            //     } else if ($(".discount_type:checked").val() == 3) {
            //         discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
            //     } else if ($(".discount_type:checked").val() == 4) {
            //         discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
            //     }
            // }


            if ($(".discount_type").is(':checked')) {
                if ($(".discount_type:checked").val() == 1) {
                    discount = 0;
                    console.log("check discount in simple discount type " + discount);
                } else if ($(".discount_type:checked").val() == 2) {
                    discount = product.pro_retailer_discount;
                    // discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
                    // discount = (jQuery('#product_name option:selected').attr('data-retailer_dis') > 0 && jQuery('#product_name option:selected').attr('data-retailer_dis') !== "undefined") ? jQuery('#product_name option:selected').attr('data-retailer_dis') : 0;

                } else if ($(".discount_type:checked").val() == 3) {

                    discount = product.pro_whole_seller_discount;
                    // discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
                    // discount = (jQuery('#product_name option:selected').attr('data-whole_saler_dis') > 0 && jQuery('#product_name option:selected').attr('data-whole_saler_dis') !== "undefined") ? jQuery('#product_name option:selected').attr('data-whole_saler_dis') : 0;

                } else if ($(".discount_type:checked").val() == 4) {
                    discount = product.pro_loyalty_card_discount;
                    // discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
                    // discount = (jQuery('#product_name option:selected').attr('data-loyalty_dis') > 0 && jQuery('#product_name option:selected').attr('data-loyalty_dis') !== "undefined") ? jQuery('#product_name option:selected').attr('data-loyalty_dis') : 0;

                }
            }

            add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 0, unit_measurement, main_unit_measurement, unit_measurement_scale_size, rate_per_pack, gross_amount, pack_qty, unit_qty, bottom, lastPR);

            product_amount_calculation(counter);

        }


        // jQuery("#product_code").change(function () {
        //
        //
        //     alert("product code changed");
        //
        //     counter++;
        //     add_first_item();
        //     var code = $(this).val();
        //
        //     // $("#product_name").select2("destroy");
        //     $('#product_name option[value="' + code + '"]').prop('selected', true);
        //     // $("#product_name").select2();
        //
        //     var parent_code = jQuery("#product_code option:selected").attr('data-parent');
        //     var name = $("#product_name option:selected").text();
        //     var quantity = 1;
        //     var unit_measurement = $('option:selected', this).attr('data-unit');
        //     var unit_measurement_scale_size = $('option:selected', this).attr('data-unit_scale_size');
        //     var bonus_qty = '';
        //     var rate = $('option:selected', this).attr('data-sale_price');
        //     var inclusive_rate = 0;
        //     var discount = 0;
        //     var discount_amount = 0;
        //     var sales_tax = $('option:selected', this).attr('data-tax');
        //     var sale_tax_amount = 0;
        //     var amount = 0;
        //     var remarks = '';
        //     var rate_after_discount = 0;
        //     var inclusive_exclusive = 0;
        //
        //     var pro_code;
        //     var pro_field_id_title;
        //     var pro_field_id;
        //
        //     var rate_per_pack = rate * unit_measurement_scale_size;
        //     var gross_amount = quantity * rate;
        //
        //     // var rate_per_pack = rate * unit_measurement_scale_size;
        //
        //     if (!$("#check_multi_time").is(':checked')) {
        //         if (!$("#check_multi_warehouse").is(':checked')) {
        //             $('input[name="pro_code[]"]').each(function (pro_index) {
        //                 pro_code = $(this).val();
        //                 pro_field_id_title = $(this).attr('id');
        //                 pro_field_id = pro_field_id_title.match(/\d+/); // 123456
        //
        //                 if (pro_code == parent_code) {
        //                     quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
        //                     bonus_qty = jQuery("#bonus" + pro_field_id).val();
        //                     rate = jQuery("#rate" + pro_field_id).val();
        //                     discount = jQuery("#product_discount" + pro_field_id).val();
        //                     sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();
        //
        //                     if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
        //                         inclusive_exclusive = 1;
        //                     }
        //
        //                     delete_sale(pro_field_id);
        //                 }
        //             });
        //         }
        //     }
        //
        //
        //     if ($(".invoice_type").is(':checked')) {
        //         if ($(".invoice_type:checked").val() == 1) {
        //             sales_tax = 0;
        //         }
        //     }
        //
        //     if ($(".discount_type").is(':checked')) {
        //         if ($(".discount_type:checked").val() == 1) {
        //             discount = 0;
        //         } else if ($(".discount_type:checked").val() == 2) {
        //             discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
        //         } else if ($(".discount_type:checked").val() == 3) {
        //             discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
        //         } else if ($(".discount_type:checked").val() == 4) {
        //             discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
        //         }
        //     }
        //
        //     add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
        //         counter, 0, unit_measurement, unit_measurement_scale_size, rate_per_pack, gross_amount);
        //
        //     product_amount_calculation(counter);
        // });
        //
        //
        // jQuery("#product_name").change(function () {
        //
        //     alert("product name changed");
        //
        //
        //     counter++;
        //     add_first_item();
        //     var code = $(this).val();
        //
        //     // $("#product_code").select2("destroy");
        //     $('#product_code option[value="' + code + '"]').prop('selected', true);
        //     // $("#product_code").select2();
        //
        //     var parent_code = jQuery("#product_name option:selected").attr('data-parent');
        //     var name = $("#product_name option:selected").text();
        //     var quantity = 1;
        //     var unit_measurement = $('option:selected', this).attr('data-unit');
        //     var unit_measurement_scale_size = $('option:selected', this).attr('data-unit_scale_size');
        //     var bonus_qty = '';
        //     var rate = $('option:selected', this).attr('data-sale_price');
        //     var inclusive_rate = 0;
        //     var discount = 0;
        //     var discount_amount = 0;
        //     var sales_tax = $('option:selected', this).attr('data-tax');
        //     var sale_tax_amount = 0;
        //     var amount = 0;
        //     var remarks = '';
        //     var rate_after_discount = 0;
        //     var inclusive_exclusive = 0;
        //
        //     var pro_code;
        //     var pro_field_id_title;
        //     var pro_field_id;
        //
        //     var rate_per_pack = rate * unit_measurement_scale_size;
        //     var gross_amount = quantity * rate;
        //     // var rate_per_pack = rate * unit_measurement_scale_size;
        //
        //
        //     $('input[name="pro_code[]"]').each(function (pro_index) {
        //
        //         pro_code = $(this).val();
        //         pro_field_id_title = $(this).attr('id');
        //         pro_field_id = pro_field_id_title.match(/\d+/); // 123456
        //
        //         if (!$("#check_multi_time").is(':checked')) {
        //             if (pro_code == parent_code) {
        //                 quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
        //                 bonus_qty = jQuery("#bonus" + pro_field_id).val();
        //                 rate = jQuery("#rate" + pro_field_id).val();
        //                 discount = jQuery("#product_discount" + pro_field_id).val();
        //                 sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();
        //
        //                 if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
        //                     inclusive_exclusive = 1;
        //                 }
        //
        //                 delete_sale(pro_field_id);
        //             }
        //         }
        //     });
        //
        //     if (!$("#check_multi_time").is(':checked')) {
        //         if (!$("#check_multi_warehouse").is(':checked')) {
        //             $('input[name="pro_code[]"]').each(function (pro_index) {
        //
        //                 pro_code = $(this).val();
        //                 pro_field_id_title = $(this).attr('id');
        //                 pro_field_id = pro_field_id_title.match(/\d+/); // 123456
        //
        //                 if (pro_code == parent_code) {
        //                     quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
        //                     bonus_qty = jQuery("#bonus" + pro_field_id).val();
        //                     rate = jQuery("#rate" + pro_field_id).val();
        //                     discount = jQuery("#product_discount" + pro_field_id).val();
        //                     sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();
        //
        //                     if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
        //                         inclusive_exclusive = 1;
        //                     }
        //
        //                     delete_sale(pro_field_id);
        //                 }
        //             });
        //         }
        //     }
        //
        //     if ($(".invoice_type").is(':checked')) {
        //         if ($(".invoice_type:checked").val() == 1) {
        //             sales_tax = 0;
        //         }
        //     }
        //
        //     if ($(".discount_type").is(':checked')) {
        //         if ($(".discount_type:checked").val() == 1) {
        //             discount = 0;
        //         } else if ($(".discount_type:checked").val() == 2) {
        //             discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
        //         } else if ($(".discount_type:checked").val() == 3) {
        //             discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
        //         } else if ($(".discount_type:checked").val() == 4) {
        //             discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
        //         }
        //     }
        //
        //     add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
        //         counter, 0, unit_measurement, unit_measurement_scale_size, rate_per_pack, gross_amount);
        //
        //     product_amount_calculation(counter);
        // });


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
            grand_total_calculation_with_disc_amount();

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


        jQuery("#product_btn").click(function () {
            $("#product").focus();
        });

        jQuery("#cash_paid_btn").click(function () {
            $("#cash_paid").focus();
        });
        // CUT IT
        //                         jQuery(document).ready(function($){
        // // standard on load code goes here with $ prefix
        // // note: the $ is setup inside the anonymous function of the ready command
        //
        //                             console.log("window loaded");
        //                             alert("window loaded");
        //                             $(document).pos();
        //                             $(document).bind('scan.pos.barcode', function(event){
        //                                 //access `event.code` - barcode data
        //                                 alert("called");
        //                             });
        //                             // }
        //                         });


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
                        // var name = $("#product_name option:selected").text();
                        var name = value['ppi_product_name'];
                        var quantity = value['ppi_qty'];
                        var unit_measurement = value['ppi_uom'];
                        // var unit_measurement = $("#product_name option:selected").attr('data-unit');

                        // var unit_measurement_scale_size = $('option:selected', this).attr('data-unit_scale_size');
                        var unit_measurement_scale_size = value['ppi_scale_size'];
                        var main_unit_measurement = value['mu_title'];
                        var pack_qty = Math.floor(quantity / unit_measurement_scale_size);//mustafa
                        var unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);

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

                        var rate_per_pack = rate * unit_measurement_scale_size;
                        var gross_amount = quantity * rate;

                        /**
                         * Chaning according to Ahmad Hassan Sahab
                         * One Product Multi time enter with separate index
                         */

                        $('input[name="pro_code[]"]').each(function (pro_index) {
                            pro_code = $(this).val();
                            pro_field_id_title = $(this).attr('id');
                            pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                            if (!$("#check_multi_time").is(':checked')) {
                                if (pro_code == parent_code) {
                                    quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;

                                    pack_qty = Math.floor(quantity / unit_measurement_scale_size);//mustafa
                                    unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);

                                    bonus_qty = jQuery("#bonus" + pro_field_id).val();
                                    rate = jQuery("#rate" + pro_field_id).val();
                                    discount = jQuery("#product_discount" + pro_field_id).val();
                                    sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                                        inclusive_exclusive = 1;
                                    }

                                    delete_sale(pro_field_id);
                                }
                            }
                        });


                        /**
                         * Chaning according to Ahmad Hassan Sahab End
                         * One Product Multi time enter with separate index
                         */

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
                            inclusive_exclusive, counter, 0, unit_measurement, main_unit_measurement, unit_measurement_scale_size, rate_per_pack, gross_amount, pack_qty, unit_qty, 0, 0);

                        // product_amount_calculation(counter);
                        product_amount_calculation_with_dis_amount(counter);

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

        function add_sale(code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                          counter, product_or_service_status, unit_measurement, main_unit_measurement, unit_measurement_scale_size, rate_per_pack, gross_amount, pack_qty, unit_qty, bottom, lastPR) {


            var inclusive_exclusive_status = '';
            var bonus_qty_status = '';
            if (inclusive_exclusive == 1) {
                inclusive_exclusive_status = 'checked';
            }

            if (product_or_service_status == 1) {
                bonus_qty_status = 'readonly';
            }


            jQuery("#table_body").append('<tr class="edit_update" id="table_row' + counter + '">' +
                // '<td class="text-center tbl_srl_4">02</td> ' +
                '<td class="text-center tbl_srl_9">' +
                '<input type="hidden" name="product_or_service_status[]" id="product_or_service_status' + counter + '" placeholder="Status" ' + 'class="inputs_up_tbl" value="' +
                product_or_service_status + '" readonly/>' +
                '<input type="hidden" name="pro_code[]" id="pro_code' + counter + '" placeholder="Code" ' + 'class="inputs_up_tbl" value="' + code + '" readonly/>' +
                code + '</td> ' +
                '<td class="text-center tbl_txt_13">' +
                '<input type="hidden" name="pro_name[]" id="pro_name' + counter + '" placeholder="Name" ' + 'class="inputs_up_tbl text-right" value="' + name + '" readonly/>' +
                name + '</td> ' +
                '<td class="text-left tbl_txt_9">' +
                '<input type="text" tabindex="-1" name="product_remarks[]" id="product_remarks' + counter + '" placeholder="Remarks" ' + 'class="inputs_up_tbl" value="' + remarks + '"/>' +
                '</td>' +
                '<td class="text-left tbl_txt_10" id="warehouse_div_col' + counter + '">' +
                '</td>' +


                {{--                                                        new empty--}}
                    '<td class="text-left tbl_srl_4">' +
                '<input type="hidden" name="main_unit_measurement[]" id="main_unit_measurement' + counter + '" placeholder="Main Unit" ' + 'class="inputs_up_tbl" value="' + main_unit_measurement + '"/>' + main_unit_measurement +
                '</td>' +


                '<td class="text-center tbl_srl_6">' +
                '<input type="hidden" name="unit_measurement_scale_size_combined[]" class="inputs_up_tbl" id="pack_size' + counter + '" placeholder="Scale Size" value="' +
                unit_measurement_scale_size +
                " "
                // + unit_measurement
                + '" readonly/>' +
                unit_measurement_scale_size + " " +
                // unit_measurement +
                // '<input type="text" name="unit_measurement[]" id="unit_measurement' + counter + '" class="inputs_up_tbl" placeholder="UOM" value="' + unit_measurement + '" readonly/>' +
                '</td>' +

                '<td class="text-center tbl_srl_4" hidden>' +
                '<input type="text" name="quantity[]"  id="quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')"  onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +   /* Changed By Abdullah: old -> return
                  allowOnlyNumber(event); */
                '</td>' +

                '<td class="text-center tbl_srl_4">' +
                '<input type="hidden" name="unit_measurement[]" id="unit_measurement' + counter + '" class="inputs_up_tbl" placeholder="UOM" value="' + unit_measurement + '" readonly/>' + unit_measurement +
                '</td>' +

                '<td class="text-center tbl_srl_4">' +
                '<input type="text" name="display_quantity[]" id="display_quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')" value="' +
                pack_qty + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" onfocusout="checkQty(' + counter + ')" />' +   /* Changed By Abdullah: old ->
                return
                  allowOnlyNumber(event); */
                '</td>' +

                '<td class="text-center tbl_srl_4">' +
                '<input type="text" onfocus="this.select();" name="rate_per_pack[]" onkeyup="unit_rate_changed_live(' + counter + '),tab_within_table(event,' + counter + ')" class="inputs_up_tbl" id="rate_per_pack' + counter + '" placeholder="Rate Per Price" value="' + rate_per_pack + '" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                '</td>' +


                // new empty
                '<td class="text-center tbl_srl_4">' +
                '<input type="hidden" hidden name="unit_measurement_scale_size[]" class="inputs_up_tbl" id="unit_measurement_scale_size' + counter + '" placeholder="Scale Size" value="' + unit_measurement_scale_size + '" readonly/>' +
                '<input type="text"  name="unit_qty[]" id="unit_qty' + counter + '" ' + ' placeholder="0" class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')"' +
                '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" value="' + unit_qty + '" onfocusout="checkQty(' + counter + ')"/> ' +
                '</td>' +

                '<td class="text-right tbl_srl_6"> ' +
                '<input type="text" name="rate[]" id="rate' + counter + '" ' + 'placeholder="Rate" class="inputs_up_tbl text-right" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')" value="' +
                rate + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                '<input type="hidden" name="product_inclusive_rate[]" class="inputs_up ' + 'text-right form-control" id="product_inclusive_rate' + counter + '"  value="' + inclusive_rate + '"> ' +
                '</td> ' +


                '<td class="text-center tbl_srl_9">' +
                '<input type="text" tabindex="-1" name="gross_amount[]" class="lower_inputs inputs_up_tbl text-right" id="gross_amount' + counter + '" placeholder="Gross Amount" value="' + gross_amount + '" readonly/>' +
                '</td>' +

                '<td class="text-center tbl_srl_5"> ' +
                '<input type="text" name="bonus[]" id="bonus' + counter + '" placeholder="Bonus" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')" value="' +
                bonus_qty + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" ' + bonus_qty_status + '/> ' +
                '</td> ' +


                {{--                                                        new empty--}}
                    '<td class="text-center tbl_srl_4"> ' +
                '<input type="text" id="trade_offer' + counter + '" name="trade_offer[]" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')" placeholder=""' +
                ' ' +
                'class="inputs_up_tbl"' +
                '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' + '</td>' +


                '<td class="text-center tbl_srl_4"> ' +
                '<input type="text" name="product_discount[]" id="product_discount' + counter + '" placeholder="Dis%" class="inputs_up_tbl percentage_textbox" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')" ' +
                'value="' + discount + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                '</td> <td class="text-right tbl_srl_7"> ' +
                '<input type="text" name="product_discount_amount[]" id="product_discount_amount' + counter + '" placeholder="Dis Amount" value="' + discount_amount + '"onfocus="this.select();" readonly  class="lower_inputs inputs_up_tbl text-right" ' +
                '/> ' +
                // onkeyup="product_amount_calculation_with_dis_amount(' + counter + '),tab_within_table(event,' + counter + ')"  onkeypress="return allow_only_number_and_decimals(this,event);"
                // grid change start

                '</td> <td class="text-center tbl_srl_4" hidden> ' +
                '<input type="text" name="product_sales_tax[]" id="product_sales_tax' + counter + '" placeholder="Tax%" class="inputs_up_tbl percentage_textbox" value="' + sales_tax + '" ' +
                'onkeyup="product_amount_calculation(' + counter + ')" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                '</td> ' +
                '<td class="text-right tbl_srl_7" hidden> ' +
                '<input type="text" name="product_sale_tax_amount[]" id="product_sale_tax_amount' + counter + '" placeholder="Tax Amount" value="' + sale_tax_amount + '" class="inputs_up_tbl text-right" readonly/> ' +
                '</td> ' +
                '<td class="text-center tbl_srl_4" hidden> <input type="checkbox" name="inclusive_exclusive[]" id="inclusive_exclusive' + counter + '" onclick="product_amount_calculation(' + counter + ');' +
                '"' + inclusive_exclusive_status + ' value="1"/> ' +
                '<input type="hidden" name="inclusive_exclusive_status_value[]" id="inclusive_exclusive_status_value' + counter + '"' + 'value="' + inclusive_exclusive + '"/> ' +


                // 1 ko cut kia ha
                '</td> ' +
                '<td class="text-right tbl_srl_9"> ' +
                '<input type="text" name="amount[]" tabindex="-1" id="amount' + counter + '" placeholder="Amount" class="lower_inputs inputs_up_tbl text-right" value="' + amount + '" readonly/> ' +
                '</td> ' +


                '<td class="text-right tbl_srl_7"> ' +
                '<div class="edit_update_bx"> <div class="inc_dec_con">' +
                '<div class="inc_dec_bx for_inc"><i class="fa fa-plus" onclick=increase_quantity(' + counter + ')></i></div>' +
                // '<div class="inc_dec_bx for_val">1</div>' +
                '<div class="inc_dec_bx for_dec"><i class="fa fa-minus" onclick=decrease_quantity(' + counter + ')></i></div>' +
                '</div> ' +
                '<a href="#" class="delete_link btn btn-sm btn-danger" tabindex="-1" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i> </a> ' +

                '<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Bottom Rate:  ' + bottom + '">' +
                '  <i class="fa fa-dollar"></i>' +
                '</button>' +

                '</div> ' +
                '</td> ' +

                '</tr>');


            $("#display_quantity" + counter).focus();


            // on product insertion we set product value as spaces(   ) then we call keypress event to call event and empty the search
            if ($("#add_auto_material").is(':checked')) {
                $("#product").val("");
                $("#remarks").focus();
                $("#product").focus();
                // $("#product").keypress();
                // $("#product").keydown();
                // $("#product").keyup();
                // $("#product").click();
            } else {
                $("#product").val("");
                // $("#product").keypress();
                // $("#product").keydown();
                // $("#product").keyup();
                // $("#product").click();
                hideproducts();
            }

            if (product_or_service_status != 1) {
                duplicate_warehouse_dropdown(counter);
            }
            var messageBody = document.querySelector('#table_body');
            messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;


            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#service_name option[value="' + 0 + '"]').prop('selected', true);


            grand_total_calculation_with_disc_amount();
            check_invoice_type();
        }


        // $("#product").change(function () {
        //
        // });

        /* Changed By Abdullah: Create " allow_only_number_and_decimals_upto_2_places " function */
        // function allow_only_number_and_decimals_upto_3_places(txt, evt) {
        //     var charCode = evt.keyCode;
        //     if (charCode == 46) {
        //         //Check if the text already contains the . character
        //         if (txt.value.indexOf('.') === -1) {
        //             return true;
        //         } else {
        //             return false;
        //         }
        //     } else {
        //         if (charCode > 31 &&
        //             (charCode < 48 || charCode > 57))
        //             return false;
        //     }
        //     var value = txt.value.split(".");
        //     if (!(typeof value[1] === 'undefined') && value[1].length > 2)
        //     {
        //         return false;
        //     }
        //     return true;
        // }

        function delete_sale(current_item) {

            jQuery("#table_row" + current_item).remove();

            grand_total_calculation_with_disc_amount();
            check_invoice_type();
        }


        function increase_quantity(current_item) {

            var previous_qty = jQuery("#display_quantity" + current_item).val();
            var new_quantity = 1;
            if (previous_qty >= 0) {
                new_quantity = +previous_qty + +1;
            }

            jQuery("#display_quantity" + current_item).val(new_quantity);

            product_amount_calculation(current_item);
        }

        function decrease_quantity(current_item) {

            var previous_qty = jQuery("#display_quantity" + current_item).val();
            var new_quantity = 1;
            if (previous_qty >= 0) {
                new_quantity = previous_qty - 1;
            }

            jQuery("#display_quantity" + current_item).val(new_quantity);

            product_amount_calculation(current_item);
        }

        jQuery("#cash_paid").keyup(function () {

            cash_return_calculation();
        });

        function cash_return_calculation() {
            var cash_paid = jQuery("#cash_paid").val();
            var grand_total = jQuery("#grand_total").val();
            var credit_card_amount = jQuery("#credit_card_amount").val();
            // var service_grand_total = jQuery("#service_grand_total").val();
            var service_grand_total = 0;

            var cash_return = (+grand_total + +service_grand_total) - cash_paid - credit_card_amount;

            jQuery("#cash_return").val(cash_return.toFixed(2));
            jQuery("#invoice_cash_received").val(cash_paid);
        }

        function cash_return_calculation_invoice() {
            var cash_paid = jQuery("#cash_paid").val();
            var cash_received_from_customer = jQuery("#cash_received_from_customer").val();

            var cash_return = cash_received_from_customer - cash_paid;

            jQuery("#invoice_cash_return").val(cash_return.toFixed(2));
        }

        function add_first_item() {
            var total_items = $('input[name="pro_code[]"]').length;

            if (total_items <= 0 || total_items == '') {
                jQuery("#table_body").html("");
            }
        }


    </script>

    <script>


        jQuery(document).ready(function () {
            // Initialize select2


            jQuery("#service_code").append("{!! $service_code !!}");
            jQuery("#service_name").append("{!! $service_name !!}");

            jQuery("#service_code").select2();
            jQuery("#service_name").select2();

            // jQuery("#product_code").select2();
            // jQuery("#product_name").select2();
            jQuery("#posting_reference").select2();

            jQuery("#account_name").select2();

            jQuery("#machine").select2();

            jQuery("#package").select2();

            jQuery("#warehouse").select2();

            jQuery("#sale_person").select2();

            // $("#invoice_btn").click();

            // to set first focus on account_name when document get ready

            $("#account_name").focus();


            retrive_checkbox_data();
            retrive_print_checkbox_data();

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


        function check_invoice_type() {
            var total_items = $("#total_items").val();

            if (total_items == 0 || total_items == "") {
                $('.invoice_type:not(:checked)').attr('disabled', false);
            } else {
                $('.invoice_type:not(:checked)').attr('disabled', true);
            }
        }
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
        // change kro
        $("#credit_card_btn").click(function () {
            $("#crdt_crd_mdl").toggle();
            $("#machine").focus();
        });

        $("#customer_info_btn").click(function () {
            $("#cstmr_info_mdl").toggle();
            $("#customer_name").focus();

        });

        $("#cash_return_btn").click(function () {
            $("#cash_return_mdl").toggle();
            $("#cash_received_from_customer").focus();
        });
        // change kro end
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
            type: 'hold', mask: 'f1', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $("#crdt_crd_mdl").toggle();
                $("#machine").focus();
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f2', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $("#cstmr_info_mdl").toggle();
                $("#customer_name").focus();

            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f3', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $("#cash_return_mdl").toggle();
                $("#cash_received_from_customer").focus();
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'esc', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $('.cancel_button').click();
                $('#product').focus();
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

<script>
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


    //  ##########   nabeel ahmed scripts    ############


    document.addEventListener('keyup', function (event) {

        // when focus is on product_discount within table then move to product (we have done this to maintain same functionality of tab as by plus(+))
        if (event.keyCode === 9) {  // means tab
            if ($("#product_discount_amount" + counter)[0] == $(document.activeElement)[0]) {
                $("#product").focus();
            }
            event.preventDefault();
        }

        // cash paid must be 0 if value is ""
        if ($("#cash_paid").val() == "") {
            $("#cash_paid").val(0);
        }


        // to close dropdown search
        if (event.keyCode === 106) {     // means staric(*)
            if ($(".select2-container--open")[0].previousElementSibling == $("#account_name")[0]) {

                $('#account_name').select2({
                    selectOnClose: true
                });
                $('#account_name').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#sale_person")[0]) {

                $('#sale_person').select2({
                    selectOnClose: true
                });
                $('#sale_person').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#warehouse")[0]) {

                $('#warehouse').select2({
                    selectOnClose: true
                });
                $('#warehouse').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#service_name")[0]) {

                $('#service_name').select2({
                    selectOnClose: true
                });
                $('#service_name').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#package")[0]) {

                $('#package').select2({
                    selectOnClose: true
                });
                $('#package').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#machine")[0]) {

                $('#machine').select2({
                    selectOnClose: true
                });
                $('#machine').focus();
            }
        }


        if (event.keyCode === 107) {     // means plus(+)

            // for upper inputs tab functionality
            if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#account_name")[0]) {
                $("#remarks").focus();
            } else if ($("#remarks")[0] == $(document.activeElement)[0]) {
                $("#sale_person").focus();
            } else if ($("#sale_person")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
                $("#product").focus();
            }
            // else if ($("#product")[0] == $(document.activeElement)[0]) {
            //     // var value = document.getElementById("product").value;
            //     // document.getElementById("product").value = value.substr(0, value.length - 1);
            //     $("#warehouse").focus();
            // } else if ($("#warehouse")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#service_name").focus();
            // } else if ($("#service_name")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#package").focus();
            // } else if ($("#package")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#disc_amount").focus();
            // } else if ($("#disc_amount")[0] == $(document.activeElement)[0]) {
            //     $("#disc_percentage").focus();
            // } else if ($("#disc_percentage")[0] == $(document.activeElement)[0]) {
            //     $("#cash_paid").focus();
            // } else if ($("#cash_paid")[0] == $(document.activeElement)[0]) {
            //     $("#account_name").focus();
            // }


            // within table tab functionality
            // else if ($("#product_remarks" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#display_quantity" + counter).focus();
            // } else if ($("#display_quantity" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#rate" + counter).focus();
            // } else if ($("#rate" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#unit_qty" + counter).focus();
            // } else if ($("#unit_qty" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#rate_per_pack" + counter).focus();
            // } else if ($("#rate_per_pack" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#bonus" + counter).focus();
            // } else if ($("#bonus" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#trade_offer" + counter).focus();
            // } else if ($("#trade_offer" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#product_discount" + counter).focus();
            // } else if ($("#product_discount" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#product_discount_amount" + counter).focus();
            // } else if ($("#product_discount_amount" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#product").focus();
            // }


            // for f1 inputs tab functionality
            if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#machine")[0]) {
                $("#credit_card_number").focus();
            } else if ($("#credit_card_number")[0] == $(document.activeElement)[0]) {
                $("#credit_card_amount").focus();
            } else if ($("#credit_card_amount")[0] == $(document.activeElement)[0]) {
                $("#card_info_save").click();
                $("#cash_paid").focus();
            } else if ($("#card_info_save")[0] == $(document.activeElement)[0]) {
                $("#card_info_save").click();
                $("#cash_paid").focus();
            } else if ($("#credit_info_cancel_btn")[0] == $(document.activeElement)[0]) {
                $("#credit_info_cancel_btn").click();
                $("#cash_paid").focus();
            }

            // for f2 inputs tab functionality
            if ($("#customer_name")[0] == $(document.activeElement)[0]) {
                $("#customer_email").focus();
            } else if ($("#customer_email")[0] == $(document.activeElement)[0]) {
                $("#customer_phone_number").focus();
            } else if ($("#customer_phone_number")[0] == $(document.activeElement)[0]) {
                $("#customer_info_save_btn").click();
            } else if ($("#customer_info_save_btn")[0] == $(document.activeElement)[0]) {
                $("#customer_info_save_btn").click();
            } else if ($("#customer_info_cancel_btn")[0] == $(document.activeElement)[0]) {
                $("#customer_info_cancel_btn").click();
            }

            // for f3 inputs tab functionality
            if ($("#cash_received_from_customer")[0] == $(document.activeElement)[0]) {
                $("#cash_return_save_btn").click();
            } else if ($("#cash_return_save_btn")[0] == $(document.activeElement)[0]) {
                $("#cash_return_save_btn").click();
            } else if ($("#cash_return_cancel_btn")[0] == $(document.activeElement)[0]) {
                $("#cash_return_cancel_btn").click();
            }


            event.preventDefault();
        }


        if (event.keyCode === 109) {   //means minus(-)


            // within table tab functionality
            // if ($("#display_quantity" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#product").focus();
            // } else if ($("#rate" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#display_quantity" + counter).focus();
            // } else if ($("#unit_qty" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#rate" + counter).focus();
            // } else if ($("#rate_per_pack" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#unit_qty" + counter).focus();
            // } else if ($("#bonus" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#rate_per_pack" + counter).focus();
            // } else if ($("#trade_offer" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#bonus" + counter).focus();
            // } else if ($("#product_discount" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#trade_offer" + counter).focus();
            // } else if ($("#product_discount_amount" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#product_discount" + counter).focus();
            // }

            // // for upper inputs tab functionality
            // if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#account_name")[0]) {
            //     $("#cash_paid").focus();
            // } else
            if ($("#remarks")[0] == $(document.activeElement)[0]) {
                $("#account_name").focus();
            } else if ($("#sale_person")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
                $("#remarks").focus();
            } else if ($("#product")[0] == $(document.activeElement)[0]) {
                // var value = document.getElementById("product").value;
                // document.getElementById("product").value = value.substr(0, value.length - 1);
                $("#sale_person").focus();
            }
            // else if ($("#warehouse")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#product").focus();
            // } else if ($("#service_name")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#warehouse").focus();
            // } else if ($("#package")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#service_name").focus();
            // } else if ($("#disc_amount")[0] == $(document.activeElement)[0]) {
            //     $("#package").focus();
            // } else if ($("#disc_percentage")[0] == $(document.activeElement)[0]) {
            //     $("#disc_amount").focus();
            // } else if ($("#cash_paid")[0] == $(document.activeElement)[0]) {
            //     $("#disc_percentage").focus();
            //     // alert("save btn focus ho gaya");
            // }


            // for f1 inputs tab functionality
            if ($("#credit_card_number")[0] == $(document.activeElement)[0]) {
                $("#machine").focus();
            } else if ($("#credit_card_amount")[0] == $(document.activeElement)[0]) {
                $("#credit_card_number").focus();
            }

            // for f2 inputs tab functionality
            if ($("#customer_name")[0] == $(document.activeElement)[0]) {
                $("#customer_email").focus();
            } else if ($("#customer_email")[0] == $(document.activeElement)[0]) {
                $("#customer_name").focus();
            } else if ($("#customer_phone_number")[0] == $(document.activeElement)[0]) {
                $("#customer_email").focus();
            }

        }

    });


    document.addEventListener('keyup', function (event) {


        if (event.keyCode === 107 || event.keyCode === 109) {

            if ($(".select2-search__field")[0] == $(document.activeElement)[0]) {

                // to stop user on writing plus(+) and minus(-) on dropdown inputs
                var value = document.querySelector(".select2-search__field").value;
                document.querySelector(".select2-search__field").value = value.substr(0, value.length - 1);

            }
            event.preventDefault();
        }
    });


    // when we type f1,f2 and f3 on some input default function of browser is called. To stop it we made this script
    document.addEventListener('keydown', function (e) {

        if (e.ctrlKey && e.key === "m") {     // when you press (ctrl + m) cursor moves to products input
            $("#product").focus();
            e.preventDefault();
        } else if (e.ctrlKey && e.key === "l") {   // when you press (ctrl + l) cursor moves to disc_amount input
            $("#cash_paid").focus();
            // alert("focus");
            e.preventDefault();
        } else if (e.ctrlKey && e.key === "s") {   // when you press (ctrl + s) save the invoice
            $("#save").click();
            e.preventDefault();
        }


        if (e.key === 'F1' || e.keyCode == 112) {

            e.cancelBubble = true;
            e.cancelable = true;
            e.stopPropagation();
            e.preventDefault();
            e.returnValue = false;

            $("#crdt_crd_mdl").toggle();
            $("#machine").focus();

        } else if (e.key === 'F2' || e.keyCode == 113) {

            e.cancelBubble = true;
            e.cancelable = true;
            e.stopPropagation();
            e.preventDefault();
            e.returnValue = false;

            $("#cstmr_info_mdl").toggle();
            $("#customer_name").focus();

        } else if (e.key === 'F3' || e.keyCode == 114) {

            e.cancelBubble = true;
            e.cancelable = true;
            e.stopPropagation();
            e.preventDefault();
            e.returnValue = false;

            $("#cash_return_mdl").toggle();
            $("#cash_received_from_customer").focus();

        } else if (e.key === 'esc' || e.keyCode == 27) {

            e.cancelBubble = true;
            e.cancelable = true;
            e.stopPropagation();
            e.preventDefault();
            e.returnValue = false;

            $('.invoice_sm_mdl').css('display', 'none');
            $('.cancel_button').click();
            $('#product').focus();
        }
        // else if (e.key === '+' || e.keyCode == 107) {
        //
        //     e.cancelBubble = true;
        //     e.cancelable = true;
        //     e.stopPropagation();
        //     e.preventDefault();
        //     e.returnValue = false;
        //
        //     $('.invoice_sm_mdl').css('display', 'none');
        //     $('.cancel_button').click();
        //     $('#product').focus();
        // }

    });


</script>

