@extends('extend_index')

@section('styles_get')

    <link rel="stylesheet" type="text/css" href="{{ asset('public/src/plugins/jquery-steps/build/jquery.steps.css') }}">

    {{--        nabeel added css blue--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">

@stop
@section('content')

    <style>


        .invoice_row .invoice_col_input .inputs_up, .invoice_row .invoice_col_input .select2-container .select2-selection--single, .invoice_row .invoice_col_input .select2-container--default .select2-selection--single, .invoice_row .invoice_col_input .select2-container .select2-selection--multiple {
            min-height: 20px;
            height: 23px;
            line-height: 20px;
        }

    </style>
    <div class="row">
        <div id="main_bg" class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text"> Production Stock Adjustment </h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('production_stock_adjustment_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="wizard-content">
                <form class="tab-wizard wizard-circle wizard" id="f1" action="{{ route('submit_production_stock_adjustment') }}" method="post" onsubmit="return check_page_two()">
                    @csrf
                    <h5>Stock Consumed</h5>
                    <section>
                        <div class="gnrl-mrgn-pdng for_voucher"><!-- invoice container start -->
                            <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->
                                        <div class="invoice_row"><!-- invoice row start -->
                                            <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <x-posting-reference tabindex="1"/>
                                            </div>
                                            <div class="invoice_col  form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Voucher Remarks
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input tabindex="1" type="text" name="voucher_remarks" class="inputs_up form-control" id="voucher_remarks" placeholder="Recipe Remarks">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                            <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Code
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->
                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="1" class="inputs_up form-control"
                                                                id="pro_code"
                                                                onchange="codeTitleChangeMethod(this, 'pro_title', 'pro_uom_raw', 'pro_scale_size','rate')">
                                                            <option value="" disabled selected> ---Select Code---
                                                            </option>
                                                            @foreach($products as $product)
                                                                <option value="{{$product->pro_p_code}}" data-parent='{{$product->pro_p_code}}' data-rate='{{$product->pro_average_rate}}'
                                                                        data-uom='{{$product->unit_title}}' data-code='{{$product->pro_p_code}}' data-scale_size='{{$product->unit_scale_size}}'>
                                                                    {{$product->pro_p_code}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Title
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="1" class="inputs_up form-control"
                                                                id="pro_title"
                                                                onchange="codeTitleChangeMethod(this, 'pro_code', 'pro_uom_raw', 'pro_scale_size','rate')">
                                                            <option value="" disabled selected> ---Select
                                                                Product---
                                                            </option>
                                                            @foreach($products as $product)
                                                                <option value="{{$product->pro_title}}" data-parent='{{$product->pro_p_code}}' data-rate='{{$product->pro_average_rate}}'
                                                                        data-uom='{{$product->unit_title}}' data-code='{{$product->pro_p_code}}' data-scale_size='{{$product->unit_scale_size}}'>
                                                                    {{$product->pro_title}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Warehouse Title
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="1" class="inputs_up form-control"
                                                                id="warehouse">
                                                            <option value="" disabled selected> ---Select
                                                                Warehouse---
                                                            </option>
                                                            @foreach($warehouses as $warehouse)
                                                                <option value="{{$warehouse->wh_id}}" {{ $warehouse->wh_id == 1 ? "selected=selected":'' }}>
                                                                    {{$warehouse->wh_title}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Remarks
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="1" type="text"
                                                                class="inputs_up form-control" id="pro_remarks"
                                                                placeholder="Product Remarks">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div hidden class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Quantity
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="1" type="text"
                                                                class="inputs_up text-right form-control"
                                                                id="quantity" placeholder="Product Quantity" min="1"
                                                                onkeypress="return allow_only_number_and_decimals(this,event);" readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div hidden class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Rate
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="1" type="text"
                                                                class="inputs_up text-right form-control"
                                                                id="rate" placeholder="Product Rate"
                                                                onkeypress="return allow_only_number_and_decimals(this,event);" readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Pack Qty
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="1" type="text"
                                                                class="inputs_up text-right form-control"
                                                                id="pack_quantity" placeholder="Pack Quantity" min="1"
                                                                onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Loose Qty
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="1" type="text"
                                                                class="inputs_up text-right form-control"
                                                                id="loose_quantity" placeholder="Loose Quantity" min="1"
                                                                onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Scale Size
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="1" type="text"
                                                                class="inputs_up text-right form-control"
                                                                id="pro_scale_size" placeholder="Product Scale Size" onkeypress="return allow_only_number_and_decimals(this,event);" readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        UOM
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="1" type="text"
                                                                class="inputs_up form-control"
                                                                id="pro_uom_raw" placeholder="Product UOM" readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div hidden class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Total Amount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <input tabindex="1" type="text"
                                                                class="inputs_up form-control"
                                                                id="total_amount_raw" placeholder="Product Amount" readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_txt for_voucher_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_col_txt with_cntr_jstfy">
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button tabindex="1" id="cancelInventoryForProductRecipe" class="invoice_frm_btn hide btn btn-sm tbn-info" data-method="cancel" onclick="addToCartForProductRecipe(this)" type="button">
                                                                <i class="fa fa-times"></i> Cancel
                                                            </button>
                                                        </div>
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button tabindex="1" id="addInventoryForProductRecipe" class="invoice_frm_btn btn btn-sm tbn-info" data-method="create" onclick="addToCartForProductRecipe(this)"type="button">
                                                                <i class="fa fa-plus"></i> Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->


                                        <div class="invoice_row"><!-- invoice row start -->
                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                                    <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                                        <table class="table table-bordered table-sm" id="category_dynamic_table">
                                                            <thead>
                                                            <tr>
                                                                <th tabindex="-1" class="tbl_srl_4"> Sr.</th>
                                                                <th tabindex="-1" class="tbl_srl_10"> Code</th>
                                                                <th tabindex="-1" class="tbl_txt_15"> Title</th>
                                                                <th tabindex="-1" class="tbl_txt_12"> Warehouse</th>
                                                                <th tabindex="-1" class="tbl_txt_12"> Product Remarks</th>
                                                                <th tabindex="-1" class="tbl_srl_8"> Quantity</th>
                                                                <th tabindex="-1" class="tbl_srl_8">Pack Quantity</th>
                                                                <th tabindex="-1" class="tbl_srl_8">Loose Quantity</th>
                                                                <th tabindex="-1" class="tbl_srl_8"> UOM</th>
                                                                <th tabindex="-1" class="tbl_srl_8"> Scale Size</th>
                                                                <th tabindex="-1" class="tbl_srl_6"> Action</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody id="listForProductRecipe">
                                                            <tr>
                                                                <td tabindex="-1" colspan="10" align="center">
                                                                    No Account Added
                                                                </td>
                                                            </tr>
                                                            </tbody>

                                                            <tfoot>
                                                            <tr>
                                                                <th tabindex="-1" colspan="4" class="text-right">
                                                                    Total Quantity
                                                                </th>
                                                                <td class="tbl_srl_12">
                                                                    <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                                                            <input tabindex="1" tabindex="-1" type="text" name="ttlQuantityForProductRecipe"
                                                                                    class="inputs_up text-right form-control" id="ttlQuantityForProductRecipe" placeholder="0.00"
                                                                                    data-rule-required="true" data-msg-required="Please Create Minimum One Inventory" readonly/>
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </td>
                                                            </tr>
                                                            </tfoot>

                                                        </table>
                                                    </div><!-- product table box end -->
                                                </div><!-- product table container end -->
                                            </div><!-- invoice column end -->
                                        </div><!-- invoice row end -->
                                    </div><!-- invoice content end -->
                                </div><!-- invoice scroll box end -->
                            </div><!-- invoice box end -->
                        </div><!-- invoice container end -->
                    </section>
                    <!-- Step 2 -->

                    {{--</section>--}}
                <!-- Step 3 -->
                    <h5>Stock Produced</h5>
                    <section>
                        <div class="gnrl-mrgn-pdng for_voucher"><!-- invoice container start -->
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                                <div class="gnrl-mrgn-pdng gnrl-blk"><!-- invoice scroll box start -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                        {{--                                            </div><!-- invoice row end -->--}}

                                        <h5 class="mb-2 mt-2"> Stock Produced </h5>

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Code
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <div class="invoice_col_short"><!-- invoice column short start -->
                                                            <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn btn btn-sm btn-info" data-container="body" data-toggle="popover"
                                                                data-trigger="hover" data-placement="bottom" data-html="true"
                                                                data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_account_code" class="col_short_btn btn btn-sm btn-info" data-container="body" data-toggle="popover" data-trigger="hover"
                                                                data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select id="goods_code" class="inputs_up form-control"
                                                                onchange="codeTitleChangeMethod(this, 'goods_title', 'pro_uom_secondary', 'pro_scale_size_secondary','finish_rate')">
                                                            <option value="" disabled selected>---Select Product Code---</option>
                                                            @foreach($finish_products as $product)
                                                                <option value="{{$product->pro_p_code}}" data-parent='{{$product->pro_p_code}}'
                                                                        data-rate='{{$product->pro_last_purchase_rate}}'
                                                                        data-uom='{{$product->unit_title}}' data-code='{{$product->pro_p_code}}' data-scale_size='{{$product->unit_scale_size}}'>
                                                                    {{$product->pro_p_code}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Title
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->

                                                        <div class="invoice_col_short"><!-- invoice column short start -->
                                                            <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn btn btn-sm btn-info" data-container="body" data-toggle="popover"
                                                                data-trigger="hover" data-placement="bottom" data-html="true"
                                                                data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_account_name" class="col_short_btn btn btn-sm btn-info" data-container="body" data-toggle="popover" data-trigger="hover"
                                                                data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select id="goods_title" class="inputs_up form-control"
                                                                onchange="codeTitleChangeMethod(this, 'goods_code', 'pro_uom_secondary', 'pro_scale_size_secondary','finish_rate')">
                                                            <option value="" disabled selected>---Select Product Title---</option>
                                                            @foreach($finish_products as $product)
                                                                <option value="{{$product->pro_title}}" data-parent='{{$product->pro_p_code}}'
                                                                        data-rate='{{$product->pro_last_purchase_rate}}'
                                                                        data-uom='{{$product->unit_title}}' data-code='{{$product->pro_p_code}}' data-scale_size='{{$product->unit_scale_size}}'>
                                                                    {{$product->pro_title}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Warehouse Title
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->

                                                        <div class="invoice_col_short"><!-- invoice column short start -->
                                                        </div><!-- invoice column short end -->
                                                        <select id="warehouse2" name="warehouse2" class="inputs_up form-control">
                                                            <option value="" disabled selected>---Select Warehouse Title---</option>
                                                            @foreach($warehouses as $warehouse)
                                                                <option value="{{$warehouse->wh_id}}" {{$warehouse->wh_id == 1 ? 'selected="selected"' : ''}}>
                                                                    {{$warehouse->wh_title}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Remarks
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" id="goods_remarks" class="inputs_up form-control" placeholder="Product Remarks">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div hidden class="invoice_col basis_col_11"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Quantity
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" id="goods_quantity" class="inputs_up text-right form-control" placeholder="Product Quantity" min="1"
                                                                onkeypress="return allow_only_number_and_decimals(this,event);" readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_8 ml-0"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Pack Qty
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="1" type="text"
                                                                class="inputs_up text-right form-control"
                                                                id="goods_pack_quantity" placeholder="Pack Quantity" min="1"
                                                                onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_8 ml-0"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Loose Qty
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="1" type="text"
                                                                class="inputs_up text-right form-control"
                                                                id="goods_loose_quantity" placeholder="Loose Quantity" min="1"
                                                                onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div hidden class="invoice_col basis_col_8"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->

                                                        Rate
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" id="finish_rate" class="inputs_up text-right form-control" placeholder="Product Rate" min="1"
                                                                onkeypress="return allow_only_number_and_decimals(this,event);" readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_8"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        UOM
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" class="inputs_up form-control" id="pro_uom_secondary" placeholder="Product UOM" readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_8"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Scale Size
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text"
                                                                class="inputs_up form-control"
                                                                id="pro_scale_size_secondary" placeholder="Scale Size"
                                                                readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div hidden class="invoice_col basis_col_8"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->

                                                        Total Amount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text"
                                                                class="inputs_up form-control"
                                                                id="produce_total_amount" placeholder="Total Amount"
                                                                readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_16"><!-- invoice column start -->
                                                <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                                    <div class="invoice_col_txt with_cntr_jstfy">
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button id="addInventoryForFinishedGoods" class="invoice_frm_btn" type="button" data-method="create"
                                                                    onclick="addToCartForFinishedGoods(this);">
                                                                <i class="fa fa-plus"></i> Add
                                                            </button>
                                                        </div>
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button id="cancelInventoryForFinishedGoods" class="invoice_frm_btn hide" type="button" data-method="cancel"
                                                                    onclick="addToCartForFinishedGoods(this);">
                                                                <i class="fa fa-times"></i> Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_row"><!-- invoice row start -->

                                                    <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                                        <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                                            <div class="pro_tbl_bx"><!-- product table box start -->
                                                                <table class="table gnrl-mrgn-pdng" id="category_dynamic_table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="tbl_srl_4"> Sr.</th>
                                                                        <th class="tbl_srl_10"> Code</th>
                                                                        <th class="tbl_txt_15"> Title</th>
                                                                        <th class="tbl_txt_12"> Warehouse</th>
                                                                        <th class="tbl_txt_12"> Product Remarks</th>
                                                                        <th class="tbl_srl_8"> Quantity</th>
                                                                        <th class="tbl_srl_8"> Pack Quantity</th>
                                                                        <th class="tbl_srl_8"> Loose Quantity</th>
                                                                        <th class="tbl_srl_8"> UOM</th>
                                                                        <th class="tbl_srl_8"> Scale Size</th>
                                                                        <th class="tbl_srl_6"> Acions</th>
                                                                    </tr>
                                                                    </thead>

                                                                    <tbody id="listForFinishedGoods">
                                                                    <tr>
                                                                        <td colspan="10" align="center">
                                                                            No Account Added
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>

                                                                    <tfoot>
                                                                    <tr>
                                                                        <th colspan="3" class="text-right">
                                                                            Total
                                                                        </th>
                                                                        <td class="tbl_srl_12">
                                                                            <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                    <input type="text" name="ttlQuantityForFinishedGoods" id="ttlQuantityForFinishedGoods"
                                                                                            class="inputs_up text-right form-control required" placeholder="0.00"
                                                                                            data-rule-required="true" data-msg-required="Please Create Minimum One Inventory"
                                                                                            readonly
                                                                                    />
                                                                                </div><!-- invoice column input end -->
                                                                            </div><!-- invoice column box end -->
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

                                    </div><!-- invoice content end -->
                                </div><!-- invoice scroll box end -->


                            </div><!-- invoice box end -->
                        </div><!-- invoice container end -->

                        <div class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                            <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                                <div class="gnrl-mrgn-pdng gnrl-blk"><!-- invoice scroll box start -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col col-lg-12"><!-- invoice column start -->
                                                <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                                            <i class="fa fa-floppy-o"></i> Save
                                                        </button>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                        </div><!-- invoice row end -->

                                    </div><!-- invoice content end -->
                                </div><!-- invoice scroll box end -->

                            </div><!-- invoice box end -->
                        </div><!-- invoice container end -->
                    </section>
                    <input type="hidden" name="cartDataForProductRecipe" id="cartDataForProductRecipe"/>
                    {{--                        <input type="hidden" name="cartDataForExpense" id="cartDataForExpense" />--}}
                    <input type="hidden" name="cartDataForFinishedGoods" id="cartDataForFinishedGoods"/>
                    <input hidden type="text" name="ttlAmountForConsumed" id="ttlAmountForConsumed"/>
                    <input hidden type="text" name="ttlAmountForProduced" id="ttlAmountForProduced"/>
                </form>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection


@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        // nabeel
        function checkForm() {
            let posting_reference = document.getElementById("posting_reference"),
                ttlQuantityForProductRecipe = document.getElementById("ttlQuantityForProductRecipe"),
                primary_limited_product_code = document.getElementById("primary_limited_product_code"),
                primary_limited_product_title = document.getElementById("primary_limited_product_title"),
                ttlQuantityForFinishedGoods = document.getElementById("ttlQuantityForFinishedGoods"),
                validateInputIdArray = [
                    posting_reference.id,
                    ttlQuantityForProductRecipe.id,
                    primary_limited_product_code.id,
                    primary_limited_product_title.id,
                    ttlQuantityForFinishedGoods.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script src="{{ asset('public/vendors/scripts/inventory_add_scripts.js') }}"></script>

    <script type="text/javascript">

        let inputValuesArray = [],
            idForShowAndGetData = {},
            tableColumnsClasseArray = {},
            validateInputIdArray = [];

        function addToCartForProductRecipe(e) {

            let code = document.getElementById("pro_code"),
                title = document.getElementById("pro_title"),
                warehouse = document.getElementById("warehouse"),
                remarks = document.getElementById("pro_remarks"),
                quantity = document.getElementById("quantity"),
                pack_quantity = document.getElementById("pack_quantity"),
                loose_quantity = document.getElementById("loose_quantity"),
                uom = document.getElementById("pro_uom_raw"),
                packSize = document.getElementById("pro_scale_size"),
                rate = document.getElementById("rate"),
                amount = document.getElementById("total_amount_raw"),
                tblListId = 'listForProductRecipe',
                cartDataArrayId = 'cartDataForProductRecipe',
                ttlQuantity = 'ttlQuantityForProductRecipe',
                ttlAmountId = 'ttlAmountForConsumed',
                addBtnId = 'addInventoryForProductRecipe',
                cancelBtnId = 'cancelInventoryForProductRecipe',
                btnCallMethodName = 'addToCartForProductRecipe';

            idForShowAndGetData = {
                tblListId: tblListId,
                cartDataArrayId: cartDataArrayId,
                ttlQuantity: ttlQuantity,
                ttlAmountId: ttlAmountId,
                addBtnId: addBtnId,
                cancelBtnId: cancelBtnId,
                btnCallMethodName: btnCallMethodName,
                codeId: code.id,
                titleId: title.id,
                warehouseIdd: warehouse.id,
                remarksId: remarks.id,
                quantityId: quantity.id,
                quantityPackId: pack_quantity.id,
                quantityLooseId: loose_quantity.id,
                uom: uom.id,
                packSize: packSize.id,
                rateId: rate.id,
                amountId: amount.id,
            };
            validateInputIdArray = [
                code.id,
                title.id,
                warehouse.id,
                quantity.id,
                // pack_quantity.id,
                // loose_quantity.id,
                uom.id,
                packSize.id,
            ];
            inputValuesArray = {
                code: code.value,
                title: title.options[title.selectedIndex].text,
                warehouse_title: warehouse.options[warehouse.selectedIndex].text,
                warehouse_id: warehouse.value,
                remarks: remarks.value,
                quantity: quantity.value,
                pack_quantity: pack_quantity.value,
                loose_quantity: loose_quantity.value,
                uom: uom.value,
                packSize: packSize.value,
                rate: rate.value,
                amount: amount.value,
            };
            tableColumnsClasseArray = {
                srClass: 'tbl_srl_4',
                codeClass: 'tbl_srl_10',
                titleClass: 'text-left tbl_txt_15',
                warehouseTitleClass: 'text-left tbl_txt_12',
                remarksClass: 'text-left tbl_txt_12',
                quantityClass: 'text-right tbl_srl_8',
                packQuantityClass: 'text-right tbl_srl_8',
                looseQuantityClass: 'text-right tbl_srl_8',
                uomClass: 'tbl_srl_8',
                packSizeClass: 'tbl_srl_8',
                actionClass: 'tbl_srl_6',
            };
            // alert();
            let displayText = new displayValuesInTable(inputValuesArray, idForShowAndGetData);
            console.log(displayText);
            displayText.onlyForWarehousePackLooseUOMRateAmountWithPackSize(e, tableColumnsClasseArray, validateInputIdArray);
            inputValuesArray = [];


            // alert(inputValuesArray['code']);
            //
            // // var product_name_value = $("#pro_title").val();
            // var product_name_value = $$('#pro_title :selected').text();
            // alert(product_name_value);


        }

        // function addToCartForExpense(e) {
        //
        //     let code = document.getElementById("exp_code"),
        //         title = document.getElementById("exp_title"),
        //         remarks = document.getElementById("exp_remarks"),
        //         amount = document.getElementById("exp_amount"),
        //         tblListId = 'listForExpense',
        //         cartDataArrayId = 'cartDataForExpense',
        //         ttlAmount = 'ttlAmountForExpense',
        //         addBtnId = 'addInventoryForExpense',
        //         cancelBtnId = 'cancelInventoryForExpense',
        //         btnCallMethodName = 'addToCartForExpense';
        //
        //     idForShowAndGetData = {
        //         tblListId: tblListId,
        //         cartDataArrayId: cartDataArrayId,
        //         ttlAmount: ttlAmount,
        //         addBtnId: addBtnId,
        //         cancelBtnId: cancelBtnId,
        //         btnCallMethodName: btnCallMethodName,
        //         codeId: code.id,
        //         titleId: title.id,
        //         remarksId: remarks.id,
        //         amountId: amount.id,
        //     };
        //     validateInputIdArray = [
        //         code.id,
        //         title.id,
        //         amount.id,
        //     ];
        //     inputValuesArray = {
        //         code: code.value,
        //         title: title.options[title.selectedIndex].text,
        //         remarks: remarks.value,
        //         amount: amount.value,
        //     };
        //     tableColumnsClasseArray = {
        //         srClass: 'tbl_srl_4',
        //         codeClass: 'tbl_srl_9',
        //         titleClass: 'text-left tbl_txt_20',
        //         remarksClass: 'text-left tbl_txt_54',
        //         amountClass: 'text-right tbl_srl_12',
        //     };
        //
        //     let displayText = new displayValuesInTable(inputValuesArray, idForShowAndGetData);
        //     displayText.onlyForAmount(e, tableColumnsClasseArray, validateInputIdArray);
        //     inputValuesArray = [];
        //
        // }

        function addToCartForFinishedGoods(e) {

            let code = document.getElementById("goods_code"),
                title = document.getElementById("goods_title"),
                warehouse = document.getElementById("warehouse2"),
                remarks = document.getElementById("goods_remarks"),
                quantity = document.getElementById("goods_quantity"),
                pack_quantity = document.getElementById("goods_pack_quantity"),
                loose_quantity = document.getElementById("goods_loose_quantity"),
                uom = document.getElementById("pro_uom_secondary"),
                packSize = document.getElementById("pro_scale_size_secondary"),
                rate = document.getElementById("finish_rate"),
                amount = document.getElementById("produce_total_amount"),
                tblListId = 'listForFinishedGoods',
                cartDataArrayId = 'cartDataForFinishedGoods',
                ttlQuantity = 'ttlQuantityForFinishedGoods',
                ttlAmountId ='ttlAmountForProduced',
                addBtnId = 'addInventoryForFinishedGoods',
                cancelBtnId = 'cancelInventoryForFinishedGoods',
                btnCallMethodName = 'addToCartForFinishedGoods';

            idForShowAndGetData = {
                tblListId: tblListId,
                cartDataArrayId: cartDataArrayId,
                ttlQuantity: ttlQuantity,
                ttlAmountId: ttlAmountId,
                addBtnId: addBtnId,
                cancelBtnId: cancelBtnId,
                btnCallMethodName: btnCallMethodName,
                codeId: code.id,
                titleId: title.id,
                warehouseIdd: title.id,
                remarksId: remarks.id,
                quantityId: quantity.id,
                quantityPackId: pack_quantity.id,
                quantityLooseId: loose_quantity.id,
                uom: uom.id,
                packSize: packSize.id,
                rateId: rate.id,
                amountId: amount.id,
            };
            validateInputIdArray = [
                code.id,
                title.id,
                quantity.id,
                uom.id,
                packSize.id,
            ];
            inputValuesArray = {
               code: code.value,
                title: title.options[title.selectedIndex].text,
                warehouse_title: warehouse.options[warehouse.selectedIndex].text,
                warehouse_id: warehouse.value,
                remarks: remarks.value,
                quantity: quantity.value,
                pack_quantity: pack_quantity.value,
                loose_quantity: loose_quantity.value,
                uom: uom.value,
                packSize: packSize.value,
                rate: rate.value,
                amount: amount.value,
            };
            tableColumnsClasseArray = {
                srClass: 'tbl_srl_4',
                codeClass: 'tbl_srl_10',
                titleClass: 'text-left tbl_txt_15',
                warehouseTitleClass: 'text-left tbl_txt_12',
                remarksClass: 'text-left tbl_txt_12',
                quantityClass: 'text-right tbl_srl_8',
                packQuantityClass: 'text-right tbl_srl_8',
                looseQuantityClass: 'text-right tbl_srl_8',
                uomClass: 'tbl_srl_8',
                packSizeClass: 'tbl_srl_8',
                actionClass: 'tbl_srl_6',

                // srClass: 'tbl_srl_4',
                // codeClass: 'tbl_srl_9',
                // titleClass: 'text-left tbl_txt_20',
                // warehouseTitleClass: 'text-left tbl_txt_10',
                // remarksClass: 'text-left tbl_txt_20',
                // quantityClass: 'text-right tbl_srl_10',
                // packQuantityClass: 'text-right tbl_srl_10',
                // looseQuantityClass: 'text-right tbl_srl_10',
                // uomClass: 'tbl_srl_10',
                // packSizeClass: 'tbl_srl_10',
                // actionClass: 'tbl_srl_6',
            };

            let displayText = new displayValuesInTable(inputValuesArray, idForShowAndGetData);
            console.log(displayText);
            displayText.onlyForWarehousePackLooseUOMRateAmountWithPackSize(e, tableColumnsClasseArray, validateInputIdArray);
            inputValuesArray = [];

        }

        $(document).on('keyup keypress', 'form input', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                return false;
            }
        });
    </script>


    <script src="{{ asset('public/src/plugins/jquery-steps/build/jquery.steps.js') }}"></script>

    <script>
        var form = $(".tab-wizard").show();

        $(".tab-wizard").steps({
            headerTag: "h5",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: "Stop"
            },
            onStepChanging: function (event, currentIndex, newIndex) {
                // Always allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex) {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }


                // console.log(form.validate().settings.ignore);
                // form.validate().settings.ignore = ":disabled,:hidden";
                // return form.valid();
                return check_page_one();
                // return false;
                // return true;
            },
            onStepChanged: function (event, currentIndex, newIndex) {
                $('.steps .current').prevAll().addClass('disabled');
            },
            onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                alert("Submitted!");
            }
        });

        function check_page_one() {

            var abc = $("#posting_reference").val();

            // var xyz = $("#ttlQuantityForProductRecipe").text();
            var xyz = $("#ttlQuantityForProductRecipe").val();


            if (abc == "" || abc == "0") {
                // alert(abc);
                $("#posting_reference").css("background-color", "red");
                $("#posting_reference").css("color", "white");
                $("#posting_reference").focus();
                return false;
            } else if (xyz == "" || xyz == "0") {
                // alert(xyz);
                $("#posting_reference").css("background-color", "white");
                $("#posting_reference").css("color", "black");
                $("#ttlQuantityForProductRecipe").css("background-color", "red");
                $("#ttlQuantityForProductRecipe").css("color", "white");
                $("#ttlQuantityForProductRecipe").focus();
                return false;
            } else {
                $("#ttlQuantityForProductRecipe").css("background-color", "white");
                $("#ttlQuantityForProductRecipe").css("color", "black");
                $("#posting_reference").css("background-color", "white");
                $("#posting_reference").css("color", "black");
                return true;
            }

        }

        function check_page_two() {

            var xyz = $("#ttlQuantityForFinishedGoods").val();


            if (xyz == "") {
                // alert(abc);
                $("#ttlQuantityForFinishedGoods").css("background-color", "red");
                $("#ttlQuantityForFinishedGoods").css("color", "white");
                $("#ttlQuantityForFinishedGoods").focus();
                return false;
            } else {
                return true;
            }
        }


        //
        // let form = $(".tab-wizard");
        // form.validate({
        //     errorPlacement: function errorPlacement(error, element) { element.before(error); },
        //     rules: {
        //         // confirm: {
        //         //     equalTo: "#password"
        //         // }
        //     }
        // });
        // form.children("section").steps({
        //     headerTag: "h5",
        //     bodyTag: "section",
        //     transitionEffect: "slideLeft",
        //     onStepChanging: function (event, currentIndex, newIndex)
        //     {
        //         form.validate().settings.ignore = ":disabled,:hidden";
        //         return form.valid();
        //     },
        //     onFinishing: function (event, currentIndex)
        //     {
        //         form.validate().settings.ignore = ":disabled";
        //         return form.valid();
        //     },
        //     onFinished: function (event, currentIndex)
        //     {
        //         alert("Submitted!");
        //     }
        // });


    </script>

    <script>


        $(document).ready(function () {


            // Initialize select2

            $("#pro_code").select2();
            $("#pro_title").select2();
            $("#goods_code").select2();
            $("#goods_title").select2();
            $("#exp_code").select2();
            $("#exp_title").select2();
            $("#warehouse").select2();
            $("#warehouse2").select2();
            $("#posting_reference").select2();

            jQuery("#batch_name").select2();


            {{--$("#pro_title, #pro_code").select2({--}}
            {{--    allowClear: true,--}}
            {{--    ajax: {--}}
            {{--        url: "{{ route('get_products') }}",--}}
            {{--        type: "post",--}}
            {{--        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},--}}
            {{--        dataType: 'json',--}}
            {{--        delay: 0,--}}
            {{--        data: function (params) {--}}
            {{--            return {--}}
            {{--                searchTerm: params.term // search term--}}
            {{--            };--}}
            {{--        },--}}
            {{--        processResults: function (response) {--}}
            {{--            return {--}}
            {{--                results: response.products--}}
            {{--            };--}}
            {{--        },--}}
            {{--        cache: true--}}
            {{--    }--}}
            {{--});--}}

            $(".steps ul").css("background-color", "#C4D3F5");

        });


        function codeTitleChangeMethod(e, id, uomId, proScaleSize, proRate) {
            // let code = e.value,

            let code = e.options[e.selectedIndex].getAttribute('data-code'),
                proUOM = e.options[e.selectedIndex].getAttribute('data-uom'),
                packSize = e.options[e.selectedIndex].getAttribute('data-scale_size'),
                rate = e.options[e.selectedIndex].getAttribute('data-rate');

            $("#" + uomId).val(proUOM);
            $("#" + proScaleSize).val(packSize);
            $("#" + proRate).val(rate);
            $("#" + id).select2("destroy");
            $("#" + id + " option[data-code='" + code + "']").prop('selected', true);
            $("#" + id).select2();

        }

        //
        // document.getElementById("pro_title").onchange = function () {
        //     alert("ok");
        //     document.getElementById("two").setAttribute("disabled", "disabled");
        //     if (this.value == 'car')
        //         document.getElementById("two").removeAttribute("disabled");
        // };
        //
    </script>


    <script>
        $('#pack_quantity').keyup(function () {
            let pack_qty = $(this).val();
            let loose_qty = $('#loose_quantity').val();
            let rate = $('#rate').val();
            let scale_size = $('#pro_scale_size').val();
            let qty = +(pack_qty * scale_size) + +loose_qty;
            $('#quantity').val(qty);
            let total_amount = rate * qty;
            $('#total_amount_raw').val(total_amount);

        });

        $('#loose_quantity').keyup(function () {
            let loose_qty = $(this).val();
            let pack_qty = $('#pack_quantity').val();
            let total_qty = $('#quantity').val();
            let rate = $('#rate').val();
            if (loose_qty == '') {
                loose_qty = 0;
            }
            if (pack_qty == '') {
                pack_qty = 0;
            }
            if (total_qty == '') {
                total_qty = 0;
            }
            let scale_size = $('#pro_scale_size').val();

            if (loose_qty >= scale_size && loose_qty > 0) {

                let total_qty = +(pack_qty * scale_size) + +loose_qty;

                pack_qty = Math.floor(total_qty / scale_size);//mustafa

                var unit_qty = (total_qty % scale_size).toFixed(3);

                $('#pack_quantity').val(pack_qty);
                $('#loose_quantity').val(unit_qty);
                $('#quantity').val(total_qty);
                let total_amount = rate * total_qty;
                $('#total_amount_raw').val(total_amount);
            } else {
                let total_qty = +loose_qty + +(pack_qty * scale_size);
                $('#quantity').val(total_qty);
                $('#loose_quantity').val(loose_qty);
                let total_amount = rate * total_qty;
                $('#total_amount_raw').val(total_amount);

            }

        });

        $('#goods_pack_quantity').keyup(function () {
            let pack_qty = $(this).val();
            let loose_qty = $('#goods_loose_quantity').val();
            let rate = $('#finish_rate').val();
            let scale_size = $('#pro_scale_size_secondary').val();
            let qty = +(pack_qty * scale_size) + +loose_qty;
            $('#goods_quantity').val(qty);
            let total_amount = rate * qty;
            $('#produce_total_amount').val(total_amount);

        });

        $('#goods_loose_quantity').keyup(function () {
            let loose_qty = $(this).val();
            let pack_qty = $('#goods_pack_quantity').val();
            let total_qty = $('#goods_quantity').val();
            let rate = $('#finish_rate').val();
            if (loose_qty == '') {
                loose_qty = 0;
            }
            if (pack_qty == '') {
                pack_qty = 0;
            }
            if (total_qty == '') {
                total_qty = 0;
            }
            let scale_size = $('#pro_scale_size_secondary').val();

            if (loose_qty >= scale_size && loose_qty > 0) {

                let total_qty = +(pack_qty * scale_size) + +loose_qty;

                pack_qty = Math.floor(total_qty / scale_size);//mustafa

                var unit_qty = (total_qty % scale_size).toFixed(3);

                $('#goods_pack_quantity').val(pack_qty);
                $('#goods_loose_quantity').val(unit_qty);
                $('#goods_quantity').val(total_qty);
                let total_amount = rate * total_qty;
                $('#produce_total_amount').val(total_amount);
            } else {
                let total_qty = +loose_qty + +(pack_qty * scale_size);
                $('#goods_quantity').val(total_qty);
                $('#goods_loose_quantity').val(loose_qty);
                let total_amount = rate * total_qty;
                $('#produce_total_amount').val(total_amount);

            }

        });

    </script>

@endsection
