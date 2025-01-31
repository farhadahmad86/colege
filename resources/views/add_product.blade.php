@extends('extend_index')

@section('styles_get')
    {{-- nabeel added css blue --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">
@stop

@section('content')

    <style>
        .inputs_up,
        .select2 {
            font-size: 20px;
            color: black;
        }

        .form-control:focus {
            color: black;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: black;
        }

        ::-webkit-input-placeholder {
            /* Edge */
            color: black !important;
        }

        :-ms-input-placeholder {
            /* Internet Explorer 10-11 */
            color: black !important;
        }

        ::placeholder {
            color: black !important;
            font-size: 16px;
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

        .add_btn,
        .refresh_btn,
        .form_header .list_btn .add_btn {
            background-color: #ffffff;
            color: #000000;
            font-weight: bold;
            border-style: solid;
        }


        .add_btn,
        .refresh_btn,
        .form_header .list_btn .add_btn {
            background-color: #4A4B5C;
            color: #fff;
        }

        .excel_con .excel_box:after {
            background-color: transparent;
        }


        .border {
            border: 2px solid white !important;urdu
        }

        .inputs_up:focus {
            box-shadow: 0 0 3pt 2pt #fc7307;
        }

        hr {
            position: inherit;
            bottom: 11px;
            border-top: 3px solid rgba(0, 0, 0, 0.1);
        }
    </style>

    <style>
        #urdu_product_name {
            direction: rtl;
        }

        .ur {
            font-family: 'Jameel Noori Nastaleeq', 'Noto Naskh Arabic', sans serif;;
        }
    </style>

    <div class="row">
        <div id="main_bg" class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Product</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <a tabindex="-1" class="add_btn list_link add_more_button"
                           href="{{ route('online_product_list') }}" role="button">
                            <i class="fa fa-list"></i> Online list
                        </a>
                        <a tabindex="-1" class="add_btn list_link add_more_button"
                           href="{{ route('product_price_update') }}" role="button">
                            <i class="fa fa-list"></i> Update Price List
                        </a>

                        <a tabindex="-1" class="add_btn list_link add_more_button" href="{{ route('product_list') }}"
                           role="button">
                            <i class="fa fa-list"></i> view list
                        </a>

                    </div><!-- list btn -->

                </div>
            </div><!-- form header close -->
            <div class="excel_con gnrl-mrgn-pdng gnrl-blk">
                <div class="excel_box gnrl-mrgn-pdng gnrl-blk">
                    <div class="excel_box_hdng gnrl-mrgn-pdng gnrl-blk">
                        <h2 class="gnrl-blk gnrl-mrgn-pdng gnrl-font-bold">
                            Upload Excel File
                        </h2>
                    </div>
                    <div class="excel_box_content gnrl-mrgn-pdng gnrl-blk">
                        <form action="{{ route('submit_product_excel') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- ahfdakjhf ahsdklf dh afjk d --}}
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            Select Excel File
                                        </label>
                                        <input tabindex="100" type="file" name="add_create_product_excel"
                                               id="add_create_product_pattern_excel"
                                               class="inputs_up form-control-file form-control height-auto"
                                               accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div><!-- end input box -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <a href="{{ url('public/sample/pos_add_product/add_create_product_pattern.xlsx') }}"
                                       tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
                                        Download Sample Pattern
                                    </a>
                                    <button tabindex="101" type="submit" name="save" id="save2"
                                            class="save_button btn btn-sm btn-success">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <form action="{{ route('submit_product') }}" name="f1" class="f1" id="f1"
                  onsubmit="return checkForm()" enctype="multipart/form-data" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h6>Product Information</h6>
                        <hr>
                        <div class="row">
                            <div class="input_bx form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_title.description') }}</p>
                                                        <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_title.benefits') }}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Product Title</label>
                                {{-- hamad set tab index --}}
                                <input tabindex="1" autofocus type="text" name="product_name" id="product_name"
                                       data-rule-required="true" data-msg-required="Please Enter Product Title"
                                       class="inputs_up form-control" placeholder="Product Title"
                                       value="{{ old('product_name') }}">
                                <span id="demo6" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <!-- start input box -->
                                <label class="">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_title.description') }}</p>
                                                        <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_title.benefits') }}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Urdu Product Title</label>
                                {{-- Hamad set tab index --}}
                                <input tabindex="2" type="text" name="urdu_product_name" id="urdu_product_name"
                                       data-rule-required="true" data-msg-required="Please Enter Product Title In Urdu"
                                       class="inputs_up form-control ur" placeholder="Product Title"
                                       value="{{ old('product_name') }}">
                                <span id="demo6" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <!-- start input box -->
                                <label class="required">Product Code</label>
                                {{-- Hamad set tab index --}}
                                <input tabindex="3" type="text" name="product_code" id="product_code"
                                       class="inputs_up form-control" data-rule-required="true"
                                       data-msg-required="Please Ender Product Code" placeholder="Product Code"
                                       value="00{{ $pro_code }}" readonly>
                                <span id="pro_code_error_message" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_barcode.description') }}</p>
                                                        <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_barcode.benefits') }}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Product BarCode</label>
                                <a onclick="generate_barcode();" class="add_btn" data-container="body"
                                   data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                   data-content="{{ config('fields_info.about_form_fields.barcode.description') }}">
                                    <i class="fa fa-barcode"></i>
                                </a>
                                {{-- Hamad set tab index --}}
                                <input tabindex="4" type="text" name="product_barcode" id="product_barcode"
                                       data-rule-required="true" data-msg-required="Please Enter Product BarCode"
                                       class="inputs_up form-control" placeholder="Product BarCode"
                                       value="{{ old('product_barcode') }}">
                                <span id="demo5" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <!-- start input box -->
                                <label class="">Alternative Code</label>
                                {{-- Hamad set tab index --}}
                                <input tabindex="5" type="text" name="alternative_code" id="alternative_code"
                                       class="inputs_up form-control" placeholder="Alternative Code"
                                       value="{{ old('alternative_code') }}">
                                <span id="alternative_code_error_message" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.main_unit.description') }}</p>
                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.main_unit.benefits') }}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Main Unit
                                    <a href="{{ route('add_main_unit') }}" class="add_btn" target="_blank">
                                        <i class="fa fa-plus"></i>
                                        {{-- Add --}}
                                    </a>
                                    <a id="refresh_main_unit" class="add_btn" {{--                                               style="margin-right: 50px;width:65px" --}}>
                                        <l class="fa fa-refresh"></l>
                                        {{-- Refresh --}}
                                    </a>
                                </label>
                                {{-- Hamad set tab index --}}
                                <select tabindex="6" name="main_unit" class="form-control" id="main_unit"
                                        data-rule-required="true" data-msg-required="Please Enter Product Main Unit">
                                    <option value="">Select Main Unit</option>
                                    @foreach ($main_units as $main_unit)
                                        <option value="{{ $main_unit->mu_id }}"
                                        @isset($last_product) {{ $main_unit->mu_id == $last_product->pro_main_unit_id ? 'selected="selected"' : '' }} @endisset>
                                            {{ $main_unit->mu_title }}</option>
                                    @endforeach
                                </select>
                                <span id="demo3" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.unit.description') }}</p>
                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.unit.benefits') }}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Unit
                                    <a href="{{ route('add_unit') }}" class="add_btn" target="_blank"
                                       data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <a id="refresh_unit" class="add_btn" data-container="body" data-toggle="popover"
                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                       data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                        <l class="fa fa-refresh"></l>
                                    </a>
                                </label>
                                {{-- Hamad set tab index --}}
                                <select tabindex="7" name="unit_name" class="form-control" id="unit_name"
                                        data-rule-required="true" data-msg-required="Please Enter Product Unit">
                                    <option value="">Select Unit</option>
                                </select>
                                <span id="demo4" class="validate_sign"> </span>
                                <input type="hidden" id="unit_allow_decimal" name="unit_allow_decimal" hidden>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.new.Product_Reporting_Group.Product_Handling_Group_Title.description') }}</p>
                                            <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.new.Product_Reporting_Group.Product_Handling_Group_Title.benefits') }}</p>
                                            <h6>Example</h6><p>{{ config('fields_info.about_form_fields.new.Product_Reporting_Group.Product_Handling_Group_Title.example') }}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Product Handling Group
                                    <a href="{{ route('product_group') }}" class="add_btn" target="_blank"
                                       data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <a id="refresh_product_group" class="add_btn" data-container="body"
                                       data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                       data-html="true"
                                       data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                        <l class="fa fa-refresh"></l>
                                    </a>
                                </label>
                                {{-- Hamad set tab index --}}
                                <select tabindex="8" name="product_group" class="inputs_up form-control"
                                        id="product_group" data-rule-required="true"
                                        data-msg-required="Please Enter Product Handling Group">
                                    <option value="">Select Product Handling Group</option>

                                    @foreach ($product_groups as $product_group)
                                        <option value="{{ $product_group->pg_id }}"
                                        @isset($last_product) {{ $product_group->pg_id == $last_product->pro_reporting_group_id ? 'selected="selected"' : '' }} @endisset>
                                            {{ $product_group->pg_title }}</option>
                                    @endforeach
                                </select>
                                <span id="product_group_msg" class="validate_sign"> </span>
                            </div><!-- end input box -->
                        </div> <!--  main row ends here -->
                        <h6>Product Type</h6>
                        <hr>
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="required">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.group_title.description') }}</p>
                                                <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.group_title.benefits') }}</p>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Product Type
                                    </label>
                                    {{-- Hamad set tab index --}}
                                    <select tabindex="9" name="product_type" class="inputs_up form-control"
                                            id="product_type" data-rule-required="true"
                                            data-msg-required="Please Enter Product Type">
                                        <option value="">Select Product Type</option>

                                        @foreach ($product_types as $product_type)
                                            <option value="{{ $product_type->pt_id }}"
                                            @isset($last_product) {{ $product_type->pt_id == $last_product->pro_product_type_id ? 'selected="selected"' : '' }} @endisset>
                                                {{ $product_type->pt_title }}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="required">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.group_title.description') }}</p>
                                                <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.group_title.benefits') }}</p>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Product Group Title
                                        <a href="{{ route('add_group') }}" class="add_btn" target="_blank">
                                            <i class="fa fa-plus"></i>
                                            {{-- Add --}}
                                        </a>
                                        <a id="refresh_group_name" class="add_btn">
                                            <l class="fa fa-refresh"></l>
                                            {{-- Refresh --}}
                                        </a>
                                    </label>

                                    {{-- Hamad set tab index --}}
                                    <select tabindex="10" name="group_name" class="inputs_up form-control"
                                            id="group_name" data-rule-required="true"
                                            data-msg-required="Please Enter Product Group Title">
                                        <option value="">Select Product Group Title</option>

                                        @foreach ($groups as $group)
                                            <option value="{{ $group->grp_id }}"
                                            @isset($last_product) {{ $group->grp_id == $last_product->pro_group_id ? 'selected="selected"' : '' }} @endisset>
                                                {{ $group->grp_title }}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="required">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.category_title.description') }}</p>
                                                <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.category_title.benefits') }}</p>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Product Category Title
                                        <a href="{{ route('add_category') }}" class="add_btn" target="_blank"
                                           data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a id="refresh_category_name" class="add_btn" data-container="body"
                                           data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                           data-html="true"
                                           data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                            <l class="fa fa-refresh"></l>
                                        </a>
                                    </label>
                                    {{-- Hamad set tab index --}}
                                    <select tabindex="11" name="category_name" class="inputs_up form-control"
                                            id="category_name" data-rule-required="true"
                                            data-msg-required="Please Enter Product Category Title">
                                        <option value="">Select Product Category Title</option>

                                    </select>
                                    <span id="demo2" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">

                                        Brand
                                        <a href="{{ route('add_brand') }}" class="add_btn" target="_blank"
                                           data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a id="refresh_brand" class="add_btn" data-container="body"
                                           data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                           data-html="true"
                                           data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                            <l class="fa fa-refresh"></l>
                                        </a>
                                    </label>
                                    {{-- Hamad set tab index --}}
                                    <select tabindex="12" name="brand" class="form-control" id="brand">
                                        <option value="">Select brand</option>
                                        @foreach ($brands as $brands)
                                            <option value="{{ $brands->br_id }}"
                                                {{ $brands->br_id == old('brand') ? 'selected="selected"' : '' }}>
                                                {{ $brands->br_title }}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo4" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                        </div> <!--  main row ends here -->

                        <h6>Product Price Information</h6>
                        <hr>
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.purchase_price.description') }}</p>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Purchase Price</label>
                                    {{-- Hamad set tab index --}}
                                    <input tabindex="13" type="text" name="purchase_price" id="purchase_price"
                                           class="inputs_up form-control" placeholder="Purchase Price"
                                           value="{{ old('purchase_price') }}"
                                           onkeypress="return allow_only_number_and_decimals(this,event);">
                                    <span id="demo7" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.bottom_price.description') }}</p>
                                                         <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.bottom_price.benefits') }}</p>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Bottom Price</label>
                                    {{-- Hamad set tab index --}}
                                    <input tabindex="14" type="text" name="bottom_price" id="bottom_price"
                                           class="inputs_up form-control" placeholder="Bottom Price"
                                           value="{{ old('bottom_price') }}"
                                           onkeypress="return allow_only_number_and_decimals(this,event);">
                                    <span id="demo8" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.sale_price.description') }}</p>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Sale Price</label>
                                    {{-- Hamad set tab index --}}
                                    <input tabindex="15" type="text" name="sale_price" id="sale_price"
                                           class="inputs_up form-control" placeholder="Sale Price"
                                           value="{{ old('sale_price') }}"
                                           onkeypress="return allow_only_number_and_decimals(this,event);">
                                    <span id="demo9" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.expiry.description') }}</p>
                                                         <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.expiry.benefits') }}</p>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Expiry</label>
                                    {{-- Hamad set tab index --}}
                                    <input tabindex="16" type="text" name="expiry" id="expiry"
                                           class="inputs_up form-control date-picker" placeholder="Expiry"
                                           value="{{ old('expiry') }}">
                                    <span id="demo10" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>
                        </div> <!--  main row ends here -->

                        <h6>Product Discount Information</h6>
                        <hr>
                        <div class="row">

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.retailer_discount_%.description') }}</p>
                                                         <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.retailer_discount_%.benefits') }}</p>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Retailer Discount %</label>
                                    {{-- Hamad set tab index --}}
                                    <input tabindex="17" type="text" name="retailer" id="retailer"
                                           class="inputs_up form-control" placeholder="Retailer Discount %"
                                           value="{{ old('retailer') }}"
                                           onkeypress="return allow_only_number_and_decimals(this,event);">
                                    {{-- <span id="demo5" class="validate_sign"> </span> --}}
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.whole_seller_discount_%.description') }}</p>
                                                         <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.whole_seller_discount_%.benefits') }}</p>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Whole Saler Discount %</label>
                                    {{-- Hamad set tab index --}}
                                    <input tabindex="18" type="text" name="wholesaler" id="wholesaler"
                                           class="inputs_up form-control" placeholder="Whole Saler %"
                                           value="{{ old('wholesaler') }}"
                                           onkeypress="return allow_only_number_and_decimals(this,event);">
                                    {{-- <span id="demo6" class="validate_sign"> </span> --}}
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.loyalty_card_%.description') }}</p>
                                                         <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.loyalty_card_%.benefits') }}</p>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Loyalty Card %</label>
                                    {{-- Hamad set tab index --}}
                                    <input tabindex="19" type="text" name="loyalty_card" id="loyalty_card"
                                           class="inputs_up form-control" placeholder="Loyalty Card %"
                                           value="{{ old('loyalty_card') }}"
                                           onkeypress="return allow_only_number_and_decimals(this,event);">
                                    {{-- <span id="demo7" class="validate_sign"> </span> --}}
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->

                                    <div class="row">

                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="custom-checkbox">
                                                <input tabindex="-1" type="checkbox" name="check_group"
                                                       id="check_group" value="1"
                                                       class="custom-control-input company_info_check_box">
                                                <label class="custom-control-label chck_pdng" for="check_group">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.use_category_tax_discount.description') }}</p>
                                                             <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.use_category_tax_discount.benefits') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Use
                                                    Category Tax/Discount</label>
                                            </div>
                                            <span id="demo3" class="validate_sign"> </span>
                                        </div>

                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                            <label class="">
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.Tax_%.description') }}</p>
                                                         <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.Tax_%.benefits') }}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Tax %</label>
                                            {{-- Hamad set tab index --}}
                                            <input tabindex="20" type="text" name="tax" id="tax"
                                                   class="inputs_up form-control" placeholder="Tax %"
                                                   value="{{ old('tax') }}"
                                                   onkeypress="return allow_only_number_and_decimals(this,event);">
                                            <span id="demo11" class="validate_sign"> </span>
                                        </div>
                                    </div>


                                </div><!-- end input box -->
                            </div>

                        </div> <!--  main row ends here -->

                        <h6>Other Information</h6>
                        <hr>
                        <div class="row">

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <div class="row">
                                        <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                            <label class="">
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.minimum_qty.description') }}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Minimum Qty</label>
                                            {{-- Hamad set tab index --}}
                                            <input tabindex="21" type="text" name="min_qty" id="min_qty"
                                                   class="inputs_up form-control" value="{{ old('min_qty') }}"
                                                   placeholder="Minimum Qty"
                                                   onkeypress="return allow_only_number_and_decimals(this,event);">
                                            <span id="demo11" class="validate_sign"> </span>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                            <div class="custom-checkbox">
                                                <input tabindex="-1" type="checkbox" name="alert" id="alert"
                                                       value="12" class="custom-control-input company_info_check_box">
                                                <label class="custom-control-label chck_pdng" for="alert">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.alert.description') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Alert</label>
                                            </div>
                                            <span id="demo12" class="validate_sign"> </span>
                                        </div>
                                    </div>
                                </div><!-- end input box -->
                            </div>
                            {{-- </div> --}}

                            {{-- </div> --}}
                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <div class="row">
                                        <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 credentials_div">
                                            <label>

                                                Hold Quantity % for Online
                                            </label>
                                            {{-- Hamad set tab index --}}
                                            <input tabindex="22" type="text" name="hold_per_online"
                                                   id="hold_per_online" data-rule-required="true"
                                                   data-msg-required="Please Enter Hold Quantity % for Online"
                                                   class="inputs_up form-control" value="{{ old('hold_per_online') }}"
                                                   placeholder="Hold Quantity % for Online"
                                                   onkeypress="return isNumber(event)" onkeyup="checkPer()">
                                            <span id="demo13" class="validate_sign"> </span>
                                        </div>
                                        <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12 stock_div">
                                            <div class="custom-checkbox">
                                                <input tabindex="-1" type="checkbox" name="stock_status"
                                                       id="stock_status" value="1"
                                                       class="custom-control-input company_info_check_box">
                                                <label class="custom-control-label chck_pdng" for="stock_status">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.alert.description') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Unlimited</label>
                                            </div>

                                            <span id="demo12" class="validate_sign"> </span>
                                        </div>


                                    </div><!-- end input box -->
                                </div>
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                            <div class="custom-checkbox">
                                                <input tabindex="-1" type="checkbox" name="online_status"
                                                       id="online_status" value="1"
                                                       class="custom-control-input company_info_check_box">
                                                <label class="custom-control-label chck_pdng" for="online_status">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.alert.description') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Onlion</label>
                                            </div>

                                            <span id="demo12" class="validate_sign"> </span>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                            <label class="">ISBN #</label>
                                            {{-- Hamad set tab index --}}
                                            <input tabindex="23" type="text" name="isbn_number" id="isbn_number"
                                                   class="inputs_up form-control" placeholder="ISBN #"
                                                   value="{{ old('isbn_number') }}">
                                            <span id="isbn_number_error_message" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                            <div class="custom-checkbox">
                                                <input tabindex="-1" type="checkbox" name="edit_status"
                                                       id="edit_status" value="1"
                                                       class="custom-control-input company_info_check_box">
                                                <label class="custom-control-label chck_pdng" for="edit_status">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.alert.description') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Edit</label>
                                            </div>

                                            <span id="demo12" class="validate_sign"> </span>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                            <label class="">Net Weight</label>
                                            <input tabindex="23" type="text" name="net_weight" id="net_weight"
                                                   class="inputs_up form-control" placeholder="Net Weight"
                                                   value="{{ old('net_weight') }}"
                                                   onkeypress="return allow_only_number_and_decimals(this,event);">
                                            <span id="net_weight_error_message" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label class="">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.minimum_qty.description') }}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Gross Weight</label>
                                <input tabindex="21" type="text" name="gross_weight" id="gross_weight"
                                       class="inputs_up form-control" value="{{ old('gross_weight') }}"
                                       placeholder="Gross Weight"
                                       onkeypress="return allow_only_number_and_decimals(this,event);">
                                <span id="gross_weight" class="validate_sign"> </span>
                            </div>


                            <div class="form-group col-lg-3 col-md-12 col-sm-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">
                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                           data-placement="bottom" data-html="true"
                                           data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.description') }}</p>
                                               <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits') }}</p>
                                               <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.example') }}</p>
                                               <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        Remarks</label>
                                    {{-- Hamad set tab index --}}
                                    <textarea tabindex="24" name="remarks" id="remarks" class="remarks inputs_up form-control" placeholder="Remarks"
                                              style="height: 70px;"> {{ old('remarks') }}</textarea>
                                    <span id="demo13" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            {{-- img --}}
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">Product Image</label>
                                    <input tabindex="25" type="file" name="pimage" id="pimage"
                                           class="inputs_up form-control" accept=".png,.jpg,.jpeg"
                                           style="width: 100px !important; background-color: #eee; border:none; box-shadow: none !important; display: none;">
                                    <span id="pimage_error_msg" style="font-size: 18px;" class="validate_sign">
                                    </span>

                                    <div class="db">

                                        <div class="db">
                                            <label id="image1"
                                                   style="display: none; cursor:pointer; color:blue; text-decoration:underline;">
                                                <i style=" color:#04C1F3" class="fa fa-window-close"></i>
                                            </label>
                                        </div>
                                        <div>
                                            <img id="imagePreview1"
                                                 style="border-radius:0%; position:relative; cursor:pointer;  width: 100px; height: 100px;"
                                                 src="{{ asset('public/src/upload_btn.jpg') }}"/>
                                        </div>
                                    </div>
                                </div><!-- end input box -->
                            </div>
                        </div> <!--  main row ends here -->
                        {{-- border rounded --}}

                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="25" type="reset" name="cancel" id="cancel"
                                class="cancel_button btn-btn-sm btn-secondary">
                            <i class="fa fa-eraser"></i> Cancel
                        </button>
                        <button tabindex="26" type="submit" name="save" id="save"
                                class="save_button btn-btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div> <!-- left column ends here -->
            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection
@section('scripts')
    <script src="{{ asset('public/urdu_text/yauk.min.js') }}"></script>

    {{--    required input validation --}}

    <script type="text/javascript">
        function checkForm() {
            let product_name = document.getElementById("product_name"),
                product_code = document.getElementById("product_code"),
                product_barcode = document.getElementById("product_barcode"),
                main_unit = document.getElementById("main_unit"),
                unit_name = document.getElementById("unit_name"),
                product_type = document.getElementById("product_type"),
                group_name = document.getElementById("group_name"),
                category_name = document.getElementById("category_name"),
                product_group = document.getElementById("product_group"),

                validateInputIdArray = [
                    product_name.id,
                    product_code.id,
                    product_barcode.id,
                    main_unit.id,
                    unit_name.id,
                    product_type.id,
                    group_name.id,
                    category_name.id,
                    product_group.id,

                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check) {
                let online_status = document.getElementById('online_status');
                if (online_status.checked == true) {
                    let stock_status = document.getElementById("stock_status");
                    //    let stock_status = document.getElementById("stock_status");
                    if (stock_status.checked == false) {
                        hold_per_online = document.getElementById("hold_per_online"),

                            validateInputIdArray = [
                                hold_per_online.id,

                            ];
                        return validateInventoryInputs(validateInputIdArray);
                    }
                }


            }
            return validateInventoryInputs(validateInputIdArray);

        }

        function checkPer() {
            var per = $("#hold_per_online").val();
            if (per > 100) {
                $("#hold_per_online").val(' ');
                // $("#hold_per_online").html('You enter '+ per +' % ');
            } else {
                $("#hold_per_online").html('');
            }

        }
    </script>
    <script>
        // $("#save").click(function () {
        //     // checkForm();
        // });
    </script>
    {{-- end of required input validation --}}
    <script>
        function generate_barcode() {
            var random = randomNumbers();
            var upc = generateUPCWithCheckDigit(random);
            $('#product_barcode').val(upc);
        }

        function randomNumbers(length) {
            var alphabet = "0123456789";
            var max = 9;
            var min = 0;
            var pass = Array();
            var alphaLength = alphabet.length - 1;

            for (let i = 0; i < 11; i++) {
                var n = Math.floor(Math.random() * (max - min + 1)) + min;
                pass.push(alphabet[n]);
            }
            return pass.join('');
        }

        function generateUPCWithCheckDigit(randomNumber) {
            let oddTotal = 0;
            let evenTotal = 0;

            randomNumber = randomNumber + '';

            for (let i = 0; i < randomNumber.length; i++) {
                if (((i + 1) % 2) === 0) {
                    evenTotal += parseInt(randomNumber[i]);
                } else {
                    oddTotal += parseInt(randomNumber[i]);
                }
            }

            let sum = (3 * oddTotal) + evenTotal;
            let checkDigit = sum % 10;
            let cd = (checkDigit > 0) ? 10 - checkDigit : checkDigit;
            return randomNumber + cd;
        }
    </script>
    {{--    <script> --}}
    {{--        function Generator() { --}}
    {{--        }; --}}

    {{--        $('#product_barcode').val(''); --}}

    {{--        Generator.prototype.rand = Math.floor(Math.random() * 26) + Date.now(); --}}

    {{--        Generator.prototype.getId = function () { --}}
    {{--            return this.rand++; --}}
    {{--        }; --}}
    {{--        var idGen = new Generator(); --}}

    {{--    </script> --}}

    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });


        jQuery("#refresh_group_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_GroupInfo_group",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#group_name").html(" ");
                    jQuery("#group_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                    s
                }
            });
        });

        jQuery("#refresh_category_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            var group_id = $('#group_name option:selected').val();

            jQuery.ajax({
                url: "refresh_categorys_group",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                data: {
                    group_id: group_id,
                },
                success: function (data) {

                    jQuery("#category_name").html(" ");
                    jQuery("#category_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_product_group").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_product_group",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#product_group").html(" ");
                    jQuery("#product_group").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_main_unit").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_mainUnit",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    jQuery("#main_unit").html(" ");
                    jQuery("#main_unit").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_unit").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            var main_unit_id = $('#main_unit option:selected').val();
            jQuery.ajax({
                url: "refresh_unit",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                data: {
                    main_unit_id: main_unit_id,
                },
                success: function (data) {

                    jQuery("#unit_name").html(" ");
                    jQuery("#unit_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_brand").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_brand",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    jQuery("#brand").html(" ");
                    jQuery("#brand").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

    <script>
        // **********************************************************only number enter **********************************************************
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        jQuery("#group_name").change(function () {

            var dropDown = document.getElementById('group_name');
            var grp_id = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_category",
                data: {
                    grp_id: grp_id
                },
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#category_name").html(" ");
                    jQuery("#category_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#main_unit").change(function () {

            var dropDown = document.getElementById('main_unit');
            var main_unit_id = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_unit",
                data: {
                    main_unit_id: main_unit_id
                },
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#unit_name").html("");
                    jQuery("#unit_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        function validatebcode(pas) {
            var pass = /^[0-9]*$/;
            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }
    </script>

    <script type="text/javascript">
        function validate_form() {
            var group_name = document.getElementById("group_name").value;
            var category_name = document.getElementById("category_name").value;
            var product_group = document.getElementById("product_group").value;
            var main_unit = document.getElementById("main_unit").value;
            var unit_name = document.getElementById("unit_name").value;
            var product_barcode = document.getElementById("product_barcode").value;
            var product_name = document.getElementById("product_name").value;
            var purchase_price = document.getElementById("purchase_price").value;
            var sale_price = document.getElementById("sale_price").value;
            var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;
            return flag_submit;
        }


        var tax = '';
        var retailer = '';
        var wholesaler = '';
        var loyalty_card = '';

        jQuery("#category_name").change(function () {

            tax = jQuery('option:selected', this).attr('data-tax');
            retailer = jQuery('option:selected', this).attr('data-retailer');
            wholesaler = jQuery('option:selected', this).attr('data-wholesaler');
            loyalty_card = jQuery('option:selected', this).attr('data-loyalty_card');
            $("#check_group").trigger("change");
        });


        $("#check_group").change(function () {
            if (this.checked) {

                $('#tax').attr('readonly', true);
                $('#retailer').attr('readonly', true);
                $('#wholesaler').attr('readonly', true);
                $('#loyalty_card').attr('readonly', true);

                jQuery("#tax").val(tax);
                jQuery("#retailer").val(retailer);
                jQuery("#wholesaler").val(wholesaler);
                jQuery("#loyalty_card").val(loyalty_card);
            } else {

                $('#tax').attr('readonly', false);
                $('#retailer').attr('readonly', false);
                $('#wholesaler').attr('readonly', false);
                $('#loyalty_card').attr('readonly', false);

                jQuery("#tax").val('');
                jQuery("#retailer").val('');
                jQuery("#wholesaler").val('');
                jQuery("#loyalty_card").val('');
            }
        });
    </script>
    <script>
        jQuery(document).ready(function () {

                @if ($last_product != null)
            var grp_id = '{{ $last_product->pro_group_id }}';
            var category_id = '{{ $last_product->pro_category_id }}';
            var main_unit_id = '{{ $last_product->pro_main_unit_id }}';
            var unit_id = '{{ $last_product->pro_unit_id }}';


            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_category",
                data: {
                    grp_id: grp_id,
                    cat_id: category_id
                },
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#category_name").html(" ");
                    jQuery("#category_name").append(data);
                    jQuery("#category_name").trigger("change");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });

            jQuery.ajax({
                url: "get_unit",
                data: {
                    main_unit_id: main_unit_id,
                    unit_id: unit_id
                },
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#unit_name").html("");
                    jQuery("#unit_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
            @endif
        });
    </script>
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product_type").select2();
            jQuery("#group_name").select2();
            jQuery("#category_name").select2();
            jQuery("#product_group").select2();
            jQuery("#main_unit").select2();
            jQuery("#unit_name").select2();
            jQuery("#brand").select2();
            jQuery("#parent_code").select2();
        });

        $('#unit_name').on('change', function () {
            var unit_allow_decimal = jQuery("#unit_name option:selected").attr('data-unit_allow_decimal');
            $('#unit_allow_decimal').val(unit_allow_decimal);
        });
    </script>
    <script>
        $(function () {
            $('#urdu_product_name').setUrduInput();
            $('#urdu_product_name').focus();
        });
        jQuery("#stock_status").change(function () {

            if ($(this).is(':checked')) {
                $(".credentials_div *").prop('disabled', true);
                $("#hold_per_online").val('');
            } else {
                $(".credentials_div *").prop('disabled', false);
            }
        });
    </script>

    <script>
        jQuery("#imagePreview1").click(function () {
            jQuery("#pimage").click();
        });
        var image1RemoveBtn = document.querySelector("#image1");
        var imagePreview1 = document.querySelector("#imagePreview1");


        $(document).ready(function () {
            $('#email_confirmation, #email').on("cut copy paste", function (e) {
                e.preventDefault();
            });


            $('#pimage').change(function () {
                var file = this.files[0],
                    val = $(this).val().trim().toLowerCase();
                if (!file || $(this).val() === "") {
                    return;
                }

                var fileSize = file.size / 130 / 130,
                    regex = new RegExp("(.*?)\.(jpeg|png|jpg)$"),
                    errors = 0;

                if (fileSize > 2) {
                    errors = 1;

                    document.getElementById("pimage_error_msg").innerHTML =
                        "Only png.jpg,jpeg files & max size:180 kb";
                }
                if (!(regex.test(val))) {
                    errors = 1;

                    document.getElementById("pimage_error_msg").innerHTML =
                        "Only png.jpg,jpegs files & max size:180 kb";
                }

                var fileInput = document.getElementById('pimage');
                var reader = new FileReader();

                if (errors == 1) {
                    $(this).val('');

                    image1RemoveBtn.style.display = "none";
                    document.getElementById("imagePreview1").src = 'public/src/upload_btn.jpg';

                } else {

                    image1RemoveBtn.style.display = "block";
                    imagePreview1.style.display = "block";

                    reader.onload = function (e) {
                        document.getElementById("imagePreview1").src = e.target.result;
                    };
                    reader.readAsDataURL(fileInput.files[0]);

                    document.getElementById("pimage_error_msg").innerHTML = "";
                }
                // document.getElementById("").innerHTML = "";
            });

            $("#make_salary_account").trigger("change");
            $("#make_credentials").trigger("change");
        });


        image1RemoveBtn.onclick = function () {

            var pimage = document.querySelector("#pimage");
            pimage.value = null;
            var pimagea = document.querySelector("#imagePreview1");
            pimagea.value = null;
            image1RemoveBtn.style.display = "none";
            //imagePreview1.style.display = "none";
            document.getElementById("imagePreview1").src = "public/src/upload_btn.jpg";

        }
    </script>

@endsection
