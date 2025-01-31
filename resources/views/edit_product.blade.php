@extends('extend_index')

@section('styles_get')
    {{-- nabeel added css blue --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">
@stop


@section('content')

    <style>
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
            border: 2px solid white !important;
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
            font-family: 'Jameel Noori Nastaleeq', 'Noto Naskh Arabic', sans serif;
            ;
        }
    </style>


    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div id="main_bg" class="pd-20 border-radius-4 box-shadow mb-30 form_manage" style="background: #C4D3F5">


                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Edit Product</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{ route('update_product') }}"
                    onsubmit="return checkForm()" method="post" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <h6>Product Information</h6>
                            <hr>
                            <div class="row">

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_title.description') }}</p>
                                                         <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_title.benefits') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Product Title
                                        </label>
                                        <input type="text" name="product_name" id="product_name" autofocus
                                            data-rule-required="true" data-msg-required="Please Enter Product Title"
                                            class="inputs_up form-control" value="{{ $product->pro_title }}">
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_title.description') }}</p>
                                                         <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_title.benefits') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Urdu Product Title</label>
                                        <input autofocus tabindex="1" type="text" name="urdu_product_name"
                                            id="urdu_product_name" data-rule-required="true"
                                            data-msg-required="Please Enter Product Title In Urdu"
                                            class="inputs_up form-control ur" placeholder="Product Title"
                                            value="{{ $product->pro_urdu_title }}">
                                        <span id="demo6" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="">Product Code</label>
                                        <input type="text" name="product_code" id="product_code"
                                            class="inputs_up form-control" placeholder="Product Code"
                                            value="{{ $product->pro_code }}" readonly>
                                        <span id="pro_code_error_message" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_barcode.description') }}</p>
                                                         <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.product_barcode.benefits') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Product BarCode</label>
                                        <input type="text" name="product_barcode" id="product_barcode"
                                            class="inputs_up form-control" placeholder="Product BarCode"
                                            data-rule-required="true" data-msg-required="Please Enter Product BarCode"
                                            value="{{ $product->pro_p_code }}" readonly>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="">Alternative Code</label>
                                        <input type="text" name="alternative_code" id="alternative_code"
                                            class="inputs_up form-control" placeholder="Alternative Code"
                                            value="{{ $product->pro_alternative_code }}">
                                        <span id="alternative_code_error_message" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.main_unit.description') }}</p>
                                                <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.main_unit.benefits') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Main Unit</label>
                                        <select name="main_unit" class="inputs_up form-control" id="main_unit"
                                            data-rule-required="true" data-msg-required="Please Enter Product Main Unit">
                                            <option value="">Select Main Unit</option>
                                            @foreach ($main_units as $main_unit)
                                                <option value="{{ $main_unit->mu_id }}"
                                                    {{ $main_unit->mu_id == $product->pro_main_unit_id ? 'selected="selected"' : '' }}>
                                                    {{ $main_unit->mu_title }}</option>
                                            @endforeach
                                        </select>
                                        <span id="demo3" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.unit.description') }}</p>
                                                <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.unit.benefits') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Unit</label>
                                        <select name="unit_name" class="inputs_up form-control" id="unit_name"
                                            data-rule-required="true" data-msg-required="Please Enter Product Unit">
                                            <option value="">Select Unit</option>
                                        </select>
                                        <span id="demo3" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            Product Handling Group
                                            <a href="{{ route('product_group') }}" class="add_btn" target="_blank">
                                                <i class="fa fa-plus"></i> Add
                                            </a>
                                        </label>
                                        <select name="product_group" class="inputs_up form-control" id="product_group"
                                            data-rule-required="true"
                                            data-msg-required="Please Enter Product Handling Group">
                                            <option value="">Select Product Handling Group</option>

                                            @foreach ($product_groups as $product_group)
                                                <option value="{{ $product_group->pg_id }}"
                                                    {{ $product_group->pg_id == $product->pro_reporting_group_id ? 'selected="selected"' : '' }}>
                                                    {{ $product_group->pg_title }}</option>
                                            @endforeach
                                        </select>
                                        <span id="product_group_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>

                            <h6>Product Type</h6>
                            <hr>
                            <div class="row">

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">

                                            Product Type {{ $product->pro_product_type_id }}
                                        </label>
                                        <select name="product_type" class="inputs_up form-control" id="product_type"
                                            data-rule-required="true" data-msg-required="Please Enter Product Type">>
                                            <option value="">Select Product Type</option>

                                            @foreach ($product_types as $product_type)
                                                <option value="{{ $product_type->pt_id }}"
                                                    {{ $product_type->pt_id == $product->pro_product_type_id ? 'selected="selected"' : '' }}>
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
                                        </label>
                                        <select name="group_name" class="inputs_up form-control" id="group_name"
                                            data-rule-required="true"
                                            data-msg-required="Please Enter Product Group Title">>
                                            <option value="">Select Product Group Title</option>

                                            @foreach ($groups as $group)
                                                <option value="{{ $group->grp_id }}"
                                                    {{ $group->grp_id == $product->pro_group_id ? 'selected="selected"' : '' }}>
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
                                        </label>
                                        <select name="category_name" class="inputs_up form-control" id="category_name"
                                            data-rule-required="true"
                                            data-msg-required="Please Enter Product Category Title">>
                                            <option value="">Product Category Title</option>
                                        </select>
                                        <span id="demo2" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="">
                                            Brand</label>
                                        <select name="brand" class="inputs_up form-control" id="brand">
                                            <option value="">Select Brand</option>
                                            @foreach ($brands as $brands)
                                                <option value="{{ $brands->br_id }}"
                                                    {{ $brands->br_id == $product->pro_brand_id ? 'selected="selected"' : '' }}>
                                                    {{ $brands->br_title }}</option>
                                            @endforeach
                                        </select>
                                        <span id="demo3" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>

                            <h6>Product Price Information</h6>
                            <hr>
                            <div class="row">

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.purchase_price.description') }}</p>
                                                        ">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Purchase Price</label>
                                        <input type="text" name="purchase_price" id="purchase_price"
                                            class="inputs_up form-control" value="{{ $product->pro_purchase_price }}"
                                            onkeypress="return allow_only_number_and_decimals(this,event);">
                                        <span id="demo5" class="validate_sign"> </span>
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
                                        <input type="text" name="bottom_price" id="bottom_price"
                                            class="inputs_up form-control" placeholder="Bottom Price"
                                            onkeypress="return allow_only_number_and_decimals(this,event);"
                                            value="{{ $product->pro_bottom_price }}">
                                        <span id="demo6" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.sale_price.description') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Sale Price</label>
                                        <input type="text" name="sale_price" id="sale_price"
                                            class="inputs_up form-control" value="{{ $product->pro_sale_price }}"
                                            onkeypress="return allow_only_number_and_decimals(this,event);">
                                        <span id="demo7" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12 col-xs-12">
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
                                        <input type="text" name="expiry" id="expiry"
                                            class="inputs_up form-control date-picker" placeholder="Expiry"
                                            value=" {{ $product->pro_expiry_date != '' ? date('d-M-Y', strtotime($product->pro_expiry_date)) : '' }}">
                                        <span id="demo8" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>
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
                                        <input type="text" name="retailer" id="retailer"
                                            class="inputs_up form-control" placeholder="Retailer Discount %"
                                            onkeypress="return allow_only_number_and_decimals(this,event);"
                                            value="{{ $product->pro_retailer_discount }}">
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
                                        <input type="text" name="wholesaler" id="wholesaler"
                                            class="inputs_up form-control" placeholder="Whole Saler %"
                                            onkeypress="return allow_only_number_and_decimals(this,event);"
                                            value="{{ $product->pro_whole_seller_discount }}">
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
                                        <input type="text" name="loyalty_card" id="loyalty_card"
                                            class="inputs_up form-control" placeholder="Loyalty Card %"
                                            onkeypress="return allow_only_number_and_decimals(this,event);"
                                            value="{{ $product->pro_loyalty_card_discount }}">
                                        {{-- <span id="demo7" class="validate_sign"> </span> --}}
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->

                                        <div class="row">

                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="check_group" id="check_group"
                                                        value="1" class="custom-control-input company_info_check_box"
                                                        {{ $product->pro_use_cat_fields == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label chck_pdng" for="check_group">
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover" data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.use_category_tax_discount.description') }}</p>
                                                             <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.use_category_tax_discount.benefits') }}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Use Category Tax/Discount{{ $product->pro_use_cat_fields }}
                                                    </label>
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
                                                <input type="text" name="tax" id="tax"
                                                    class="inputs_up form-control" placeholder="Tax %"
                                                    onkeypress="return allow_only_number_and_decimals(this,event);"
                                                    value="{{ $product->pro_tax }}">
                                                <span id="demo11" class="validate_sign"> </span>
                                            </div>
                                        </div>


                                    </div><!-- end input box -->
                                </div>

                            </div>

                            <h6>Other Information</h6>
                            <hr>
                            <div class="row">

                                <div class="form-group col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <div class="row">
                                            <div class="col-lg-10 col-md-10 col-sm-10">
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                        data-placement="bottom" data-html="true"
                                                        data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.minimum_qty.description') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Minimum Qty</label>
                                                <input type="text" name="min_qty" id="min_qty"
                                                    class="inputs_up form-control" placeholder="Minimum Qty"
                                                    onkeypress="return isNumber
                                                            (event)"
                                                    value="{{ $product->pro_min_quantity }}">
                                                <span id="demo9" class="validate_sign"> </span>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2">
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="alert" id="alert" value="1"
                                                        class="custom-control-input company_info_check_box"
                                                        {{ $product->pro_min_quantity_alert == '1' ? 'checked' : '' }}>
                                                    <label class="custom-control-label chck_pdng" for="alert">
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover" data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.alert.description') }}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Alert</label>
                                                    <span id="demo10" class="validate_sign"> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end input box -->
                                </div>


                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <div class="row">
                                            <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12 credentials_div">
                                                <div class="input_bx">
                                                    <!-- start input box -->
                                                    <label>

                                                        Hold Quantity % for Online

                                                    </label>
                                                    <input type="text" name="hold_per_online" id="hold_per_online"
                                                        class="inputs_up form-control"
                                                        value="{{ $product->pro_hold_qty_per }}"
                                                        placeholder="Hold Quantity % for Online" data-rule-required="true"
                                                        data-msg-required="Please Enter Hold Quantity % for Online"
                                                        onkeypress="return isNumber(event)">
                                                    <span id="demo13" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12">
                                                <div class="custom-checkbox">
                                                    <input tabindex="-1" type="checkbox" name="stock_status"
                                                        id="stock_status" value="1"
                                                        {{ $product->pro_stock_status == 1 ? 'checked' : '' }}
                                                        class="custom-control-input company_info_check_box">
                                                    <label class="custom-control-label chck_pdng" for="stock_status">
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover" data-placement="bottom" data-html="true"
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
                                                        {{ $product->pro_online_status == 1 ? 'checked' : '' }}
                                                        class="custom-control-input company_info_check_box">
                                                    <label class="custom-control-label chck_pdng" for="online_status">
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover" data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.alert.description') }}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Onlion</label>
                                                </div>
                                                <span id="demo12" class="validate_sign"> </span>
                                            </div>

                                            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <div class="input_bx">
                                                    <!-- start input box -->
                                                    <label class="">ISBN #</label>
                                                    <input type="text" name="isbn_number" id="isbn_number"
                                                        class="inputs_up form-control" placeholder="ISBN #"
                                                        value="{{ $product->pro_ISBN }}">
                                                    <span id="isbn_number_error_message" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

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
                                                        {{ $product->pro_edit == 1 ? 'checked' : '' }}
                                                        class="custom-control-input company_info_check_box">
                                                    <label class="custom-control-label chck_pdng" for="edit_status">
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover" data-placement="bottom" data-html="true"
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
                                                    value="{{ $product->pro_net_weight }}"
                                                    onkeypress="return allow_only_number_and_decimals(this,event);">
                                                <span id="net_weight_error_message" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.product_registration.product.minimum_qty.description') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Gross Weight</label>
                                        <input tabindex="21" type="text" name="gross_weight" id="gross_weight"
                                            class="inputs_up form-control" value="{{ $product->pro_gross_weight }}"
                                            placeholder="Gross Weight"
                                            onkeypress="return allow_only_number_and_decimals(this,event);">
                                        <span id="gross_weight" class="validate_sign"> </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
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
                                        <textarea name="remarks" id="remarks" class="remarks inputs_up form-control" style="height: 70px;"
                                            placeholder="Remarks">{{ $product->pro_remarks }}</textarea>
                                        <span id="demo11" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>


                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">Product Image</label>
                                    <input type="file" name="pimage" id="pimage" class="inputs_up form-control"
                                        accept=".png,.jpg,.jpeg"
                                        style="width: 100px !important; background-color: #eee; border:none; box-shadow: none !important; display: none;">
                                    <span id="pimage_error_msg" class="validate_sign"> </span>

                                    <div class="db">

                                        <div class="db">
                                            <label id="image1"
                                                style="display: none; cursor:pointer; color:blue; text-decoration:underline;">
                                                <i style=" color:#04C1F3" class="fa fa-window-close"></i>
                                            </label>
                                        </div>
                                        <div>
                                            <img id="imagePreview1"
                                                style="border-radius:50%; position:relative; cursor:pointer;  width: 100px; height: 100px;"
                                                src="{{ isset($product->pro_image) && !empty($product->pro_image) ? $product->pro_image : asset('public/src/upload_btn.jpg') }}" />
                                        </div>
                                    </div>


                                </div><!-- end input box -->
                            </div>
                            <input value="{{ $product->pro_unit_id }}" name="unit_id" type="hidden">
                            <input value="{{ $product->pro_id }}" name="product_id" type="hidden">

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="button" name="cancel" id="cancel"
                                        class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save"
                                        class="save_button form-control">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>

                        </div> <!-- left column ends here -->

                    </div> <!--  main row ends here -->


                </form>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')
    <script src="{{ asset('public/urdu_text/yauk.min.js') }}"></script>

    {{-- required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let product_type = document.getElementById("product_type"),
                group_name = document.getElementById("group_name"),
                category_name = document.getElementById("category_name"),
                product_group = document.getElementById("product_group"),
                main_unit = document.getElementById("main_unit"),
                unit_name = document.getElementById("unit_name"),
                product_barcode = document.getElementById("product_barcode"),
                product_name = document.getElementById("product_name"),
                validateInputIdArray = [
                    product_type.id,
                    group_name.id,
                    category_name.id,
                    product_group.id,
                    main_unit.id,
                    unit_name.id,
                    product_barcode.id,
                    product_name.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check) {
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
            return validateInventoryInputs(validateInputIdArray);
        }
        function checkPer(){
  var per =   $("#hold_per_online").val();
  if(per>100){
    $("#hold_per_online").val(' ');
    // $("#hold_per_online").html('You enter '+ per +' % ');
  }else{
    $("#hold_per_online").html('');
  }

}
    </script>
    {{-- end of required input validation --}}


    <script type="text/javascript">
        jQuery("#account").change(function() {

            var name = jQuery('option:selected', this).attr('data-name');
            var cnic = jQuery('option:selected', this).attr('data-cnic');
            var email = jQuery('option:selected', this).attr('data-email');
            var mobile = jQuery('option:selected', this).attr('data-mobile');
            var address = jQuery('option:selected', this).attr('data-address');

            jQuery("#name").val(name);
            jQuery("#cnic").val(cnic);
            jQuery("#email").val(email);
            jQuery("#mobile").val(mobile);
            jQuery("#address").val(address);
        });


        function isNumberWithHyphen(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 32 || charCode == 45 || charCode == 43) {
                return true
            } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }


        jQuery("#imagePreview1").click(function() {
            jQuery("#pimage").click();
        });
        var image1RemoveBtn = document.querySelector("#image1");
        var imagePreview1 = document.querySelector("#imagePreview1");


        $(document).ready(function() {


            $('input[type=file]').change(function() {
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
                        "Only png.jpg,jpeg files & max size:130 kb";
                }
                if (!(regex.test(val))) {
                    errors = 1;

                    document.getElementById("pimage_error_msg").innerHTML =
                        "Only png.jpg,jpegs files & max size:130 kb";
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

                    reader.onload = function(e) {
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


        image1RemoveBtn.onclick = function() {

            var pimage = document.querySelector("#pimage");
            pimage.value = null;
            var pimagea = document.querySelector("#imagePreview1");
            pimagea.value = null;

            image1RemoveBtn.style.display = "none";
            //imagePreview1.style.display = "none";
            document.getElementById("imagePreview1").src = "public/src/upload_btn.jpg";

        }
    </script>


    <script>
        jQuery(document).ready(function() {

            var grp_id = '{{ $product->pro_group_id }}';
            var category_id = '{{ $product->pro_category_id }}';
            var main_unit_id = '{{ $product->pro_main_unit_id }}';
            var unit_id = '{{ $product->pro_unit_id }}';

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
                success: function(data) {

                    jQuery("#category_name").html(" ");
                    jQuery("#category_name").append(data);
                    jQuery("#category_name").trigger("change");
                },
                error: function(jqXHR, textStatus, errorThrown) {
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
                success: function(data) {

                    jQuery("#unit_name").html("");
                    jQuery("#unit_name").append(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
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

        jQuery("#group_name").change(function() {

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
                success: function(data) {

                    jQuery("#category_name").html(" ");
                    jQuery("#category_name").append(data);

                    jQuery("#category_name").trigger("change");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

        // jQuery("#category_name").change(function () {
        //
        //     var dropDown = document.getElementById('category_name');
        //     var cat_id = dropDown.options[dropDown.selectedIndex].value;
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "get_unit",
        //         data: {cat_id: cat_id},
        //         type: "POST",
        //         cache: false,
        //         dataType: 'json',
        //         success: function (data) {
        //
        //             jQuery("#unit_name").html(" ");
        //             jQuery("#unit_name").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {
        //             alert(jqXHR.responseText);
        //             alert(errorThrown);
        //         }
        //     });
        // });

        jQuery("#main_unit").change(function() {

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
                success: function(data) {

                    jQuery("#unit_name").html("");
                    jQuery("#unit_name").append(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
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
            var product_name = document.getElementById("product_name").value;
            var purchase_price = document.getElementById("purchase_price").value;
            var sale_price = document.getElementById("sale_price").value;
            var remarks = document.getElementById("remarks").value;
            var product_code = document.getElementById("product_code").value;

            var flag_submit = true;
            var focus_once = 0;

            if (group_name.trim() == "") {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#group_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo1").innerHTML = "";
            }

            if (category_name.trim() == "") {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#category_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo2").innerHTML = "";
            }

            if (product_group.trim() == "") {
                document.getElementById("product_group_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#product_group").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("product_group_msg").innerHTML = "";
            }


            // if (main_unit.trim() == "") {
            //     document.getElementById("demo3").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#main_unit").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo3").innerHTML = "";
            // }
            //
            // if (unit_name.trim() == "") {
            //     document.getElementById("demo4").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#unit_name").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo4").innerHTML = "";
            // }

            // if (product_code.trim() == "") {
            //     document.getElementById("demo51").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#product_code").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo51").innerHTML = "";
            // }

            if (product_name.trim() == "") {
                document.getElementById("demo4").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#product_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo4").innerHTML = "";
            }

            // if (purchase_price.trim() == "") {
            //     document.getElementById("demo5").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#purchase_price").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // }
            //
            // if (sale_price.trim() == "") {
            //     document.getElementById("demo7").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#sale_price").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // }

            // if(remarks.trim() == "")
            // {
            //     document.getElementById("demo11").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo11").innerHTML = "";
            // }

            return flag_submit;
        }


        var original_value_tax = '{{ $product->pro_tax }}';
        var original_value_retailer = '{{ $product->pro_retailer_discount }}';
        var original_value_wholesaler = '{{ $product->pro_whole_seller_discount }}';
        var original_value_loyalty_card = '{{ $product->pro_loyalty_card_discount }}';


        var tax = '{{ $product->pro_tax }}';
        var retailer = '{{ $product->pro_retailer_discount }}';
        var wholesaler = '{{ $product->pro_whole_seller_discount }}';
        var loyalty_card = '{{ $product->pro_loyalty_card_discount }}';

        jQuery("#category_name").change(function() {

            tax = jQuery('option:selected', this).attr('data-tax');
            retailer = jQuery('option:selected', this).attr('data-retailer');
            wholesaler = jQuery('option:selected', this).attr('data-wholesaler');
            loyalty_card = jQuery('option:selected', this).attr('data-loyalty_card');

            $("#check_group").trigger("change");

        });


        $("#check_group").change(function() {
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

                jQuery("#tax").val(original_value_tax);
                jQuery("#retailer").val(original_value_retailer);
                jQuery("#wholesaler").val(original_value_wholesaler);
                jQuery("#loyalty_card").val(original_value_loyalty_card);
            }
        });
    </script>

    <script>
        jQuery(document).ready(function() {
            // Initialize select2
            jQuery("#product_type").select2();
            jQuery("#group_name").select2();
            jQuery("#category_name").select2();
            jQuery("#product_group").select2();
            jQuery("#main_unit").select2();
            jQuery("#unit_name").select2();
            jQuery("#brand").select2();
            if ("{!! $product->pro_stock_status !!}" == 1) {
                $(".credentials_div *").prop('disabled', true);
            }
        });
    </script>
    <script>
        $(function() {
            $('#urdu_product_name').setUrduInput();
            $('#urdu_product_name').focus();
        });

        jQuery("#stock_status").change(function() {

            if ($(this).is(':checked')) {
                $(".credentials_div *").prop('disabled', true);
                $("#hold_per_online").val('');
            } else {
                $(".credentials_div *").prop('disabled', false);
            }
        });
    </script>
@endsection
