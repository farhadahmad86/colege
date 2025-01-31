@extends('extend_index')

@section('styles_get')

    <link rel="stylesheet" type="text/css" href="{{ asset('public/src/plugins/jquery-steps/build/jquery.steps.css') }}">

@stop
@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text"> Production </h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{ route('product_recipe_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div class="wizard-content">
                    <form class="tab-wizard wizard-circle wizard" id="f1" action="{{ route('production.store') }}" method="post">
                        @csrf


                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                <div class="tab">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#add_raw_product" role="tab" aria-selected="false">
                                                Add Raw Products
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" data-toggle="tab" href="#get_finished_good" role="tab" aria-selected="false" onclick="controleTabsCus(this, 'ttlAmountId')">
                                                Get Finished Good
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-4">


                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                        Raw Total
                                                    </label><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <h5 class="grandTotalFont" id="rawTotalAmountView">
                                                            0
                                                        </h5>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                            =

                                            <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                        Primary Total
                                                    </label><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <h5 class="grandTotalFont" id="primaryTotalAmountView">
                                                            0
                                                        </h5>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                        </div><!-- invoice row end -->


                                        <div class="tab-pane fade show active" id="add_raw_product" role="tabpanel">
                                            <section>
                                                <div class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                                                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->


                                                                <div class="invoice_row"><!-- invoice row start -->

                                                                    <div class="invoice_col basis_col_12"><!-- invoice column start -->
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
                                                                                    <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body"
                                                                                       data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                                        <i class="fa fa-plus"></i>
                                                                                    </a>
                                                                                    <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                       data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                                        <i class="fa fa-refresh"></i>
                                                                                    </a>
                                                                                </div><!-- invoice column short end -->
                                                                                <select class="inputs_up form-control" id="pro_code"
                                                                                        onchange="codeTitleChangeMethod(this, 'pro_title'), multiplicationQuantityToRateMethod(this, 'pro_uom_raw', 'pack_size', 'pro_rate', 'amount', 'quantity')">
                                                                                    <option value="" disabled selected> ---Select Code---</option>
                                                                                </select>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_15"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                   data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Product Title
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->

                                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                                    <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body"
                                                                                       data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                                        <i class="fa fa-plus"></i>
                                                                                    </a>
                                                                                    <a id="refresh_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                       data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                                        <i class="fa fa-refresh"></i>
                                                                                    </a>
                                                                                </div><!-- invoice column short end -->
                                                                                <select class="inputs_up form-control" id="pro_title"
                                                                                        onchange="codeTitleChangeMethod(this, 'pro_code'), multiplicationQuantityToRateMethod(this, 'pro_uom_raw', 'pack_size', 'pro_rate', 'amount', 'quantity')">
                                                                                    <option value="" disabled selected> ---Select Product---</option>
                                                                                </select>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_15"><!-- invoice column start -->
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
                                                                                <input type="text" class="inputs_up form-control" id="pro_remarks" placeholder="Product Remarks">
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                   data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Quantity
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" class="inputs_up text-right form-control" id="quantity" placeholder="Product Quantity" min="1"
                                                                                       onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                                       onkeyup="quantityRateMultiply(  'quantity', 'pro_rate', 'amount', '')"/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
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
                                                                                <input type="text" class="inputs_up text-center form-control" id="pro_uom_raw" placeholder="Product UOM" readonly/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                   data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Pack Size
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" class="inputs_up text-center form-control" id="pack_size" placeholder="Pack Size" readonly/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->


                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                   data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Rate
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" class="inputs_up text-right form-control" id="pro_rate" placeholder="Product Rate" readonly/>
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
                                                                                Total Amount
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" class="inputs_up text-right form-control" id="amount" placeholder="Total Amount" readonly/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->


                                                                    <div class="invoice_col basis_col_17"><!-- invoice column start -->
                                                                        <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                                                            <div class="invoice_col_txt with_cntr_jstfy">
                                                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                                    <button id="addInventoryForProductRecipe" class="invoice_frm_btn" data-method="create"
                                                                                            onclick="addToCartForRawProducts(this)" type="button">
                                                                                        <i class="fa fa-plus"></i> Add
                                                                                    </button>
                                                                                </div>
                                                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                                    <button id="cancelInventoryForProductRecipe" class="invoice_frm_btn hide" data-method="cancel"
                                                                                            onclick="addToCartForRawProducts(this)" type="button">
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
                                                                                                <th class="text-center tbl_srl_4"> Sr.</th>
                                                                                                <th class="text-center tbl_srl_13"> Code</th>
                                                                                                <th class="text-center tbl_txt_20"> Title</th>
                                                                                                <th class="text-center tbl_txt_29"> Product Remarks</th>
                                                                                                <th class="text-center tbl_txt_6"> Quantity</th>
                                                                                                <th class="text-center tbl_srl_6"> UOM</th>
                                                                                                <th class="text-center tbl_srl_6"> Pack Size</th>
                                                                                                <th class="text-center tbl_srl_6"> Rate</th>
                                                                                                <th class="text-center tbl_srl_10"> Amount</th>

                                                                                            </tr>
                                                                                            </thead>

                                                                                            <tbody id="listForProductRecipe">
                                                                                            <tr>
                                                                                                <td colspan="10" align="center">
                                                                                                    No Account Added
                                                                                                </td>
                                                                                            </tr>
                                                                                            </tbody>

                                                                                            <tfoot>
                                                                                            <tr>
                                                                                                <th colspan="4" class="text-right">
                                                                                                    Total Amount
                                                                                                </th>
                                                                                                <td class="text-center tbl_srl_12">
                                                                                                    <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                                            <input type="text" name="ttlAmountId" class="inputs_up text-right form-control"
                                                                                                                   id="ttlAmountId" placeholder="0.00" data-rule-required="true"
                                                                                                                   data-msg-required="Please Create Minimum One Inventory" value="" readonly/>
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
                                            </section>
                                        </div>

                                        <div class="tab-pane fade" id="get_finished_good" role="tabpanel">
                                            <section>
                                                <div class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                                                <div class="invoice_row"><!-- invoice row start -->

                                                                    <div class="invoice_col basis_col_15"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.cash_account.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Product Code
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                                    <a href="{{ url('add_product') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover"
                                                                                       data-trigger="hover" data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                                        <i class="fa fa-plus"></i>
                                                                                    </a>
                                                                                    <a id="refresh_account" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                       data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                                        <i class="fa fa-refresh"></i>
                                                                                    </a>
                                                                                </div><!-- invoice column short end -->
                                                                                <select name="primary_limited_product_code" class="inputs_up form-control required" id="primary_limited_product_code"
                                                                                        data-rule-required="true" data-msg-required="Please Enter Product Code"
                                                                                        onchange="codeTitleChangeMethodForPrimary(this, 'primary_limited_product_title', 'pro_uom_primary', 'pack_size_primary' ), multiplicationQuantityToRateMethodForPrimary( 'ttlAmountId', 'primary_limited_product_quantity', 'pro_rate_primary', 'amount_primary' )">
                                                                                    <option value="" disabled selected>---Select Product Code--- Code</option>
                                                                                </select>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_15"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                   data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Product Title
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->

                                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                                    <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body"
                                                                                       data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                                        <i class="fa fa-plus"></i>
                                                                                    </a>
                                                                                    <a id="refresh_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                       data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                                        <i class="fa fa-refresh"></i>
                                                                                    </a>
                                                                                </div><!-- invoice column short end -->
                                                                                <select name="primary_limited_product_title" class="inputs_up form-control required" id="primary_limited_product_title"
                                                                                        data-rule-required="true" data-msg-required="Please Enter Product Title"
                                                                                        onchange="codeTitleChangeMethodForPrimary(this, 'primary_limited_product_code', 'pro_uom_primary', 'pack_size_primary' ), multiplicationQuantityToRateMethodForPrimary( 'ttlAmountId', 'primary_limited_product_quantity', 'pro_rate_primary', 'amount_primary' )">
                                                                                    <option value="" disabled selected>---Select Product Title---</option>
                                                                                </select>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                   data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Quantity
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" name="primary_limited_product_quantity" class="inputs_up text-right form-control required"
                                                                                       id="primary_limited_product_quantity" placeholder="Product Quantity" min="1"
                                                                                       onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                                       onkeyup="multiplicationQuantityToRateMethodForPrimary( 'ttlAmountId', 'primary_limited_product_quantity', 'pro_rate_primary', 'amount_primary' )"/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
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
                                                                                <input type="text" class="inputs_up text-center form-control" id="pro_uom_primary" name="pro_uom_primary"
                                                                                       placeholder="Product UOM" readonly/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                   data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Pack Size
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" class="inputs_up text-center form-control" id="pack_size_primary" name="pack_size_primary"
                                                                                       placeholder="Pack Size" readonly/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->


                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                   data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Rate
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" class="inputs_up text-right form-control" id="pro_rate_primary" name="pro_rate_primary"
                                                                                       placeholder="Product Rate" readonly/>
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
                                                                                Total Amount
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" class="inputs_up text-right form-control" id="amount_primary" name="amount_primary"
                                                                                       placeholder="Total Amount" readonly/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->


                                                                </div><!-- invoice row end -->

                                                                <div class="invoice_row"><!-- invoice row start -->

                                                                    <div class="invoice_col basis_col_12"><!-- invoice column start -->
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
                                                                                    <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body"
                                                                                       data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                                        <i class="fa fa-plus"></i>
                                                                                    </a>
                                                                                    <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                       data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                                        <i class="fa fa-refresh"></i>
                                                                                    </a>
                                                                                </div><!-- invoice column short end -->
                                                                                <select id="goods_code" class="inputs_up form-control"
                                                                                        onchange="codeTitleChangeMethod(this, 'goods_title'), multiplicationQuantityToRateMethod(this, 'pro_uom_secondary', 'pack_size_secondary', 'pro_rate_secondary', 'amount_secondary', 'goods_quantity')">
                                                                                    <option value="" disabled selected>---Select Product Code---</option>
                                                                                </select>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_15"><!-- invoice column start -->
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
                                                                                    <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body"
                                                                                       data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                                        <i class="fa fa-plus"></i>
                                                                                    </a>
                                                                                    <a id="refresh_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                       data-placement="bottom" data-html="true"
                                                                                       data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                                        <i class="fa fa-refresh"></i>
                                                                                    </a>
                                                                                </div><!-- invoice column short end -->
                                                                                <select id="goods_title" class="inputs_up form-control"
                                                                                        onchange="codeTitleChangeMethod(this, 'goods_code'), multiplicationQuantityToRateMethod(this, 'pro_uom_secondary', 'pack_size_secondary', 'pro_rate_secondary', 'amount_secondary', 'goods_quantity')">
                                                                                    <option value="" disabled selected>---Select Product Title---</option>
                                                                                </select>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_15"><!-- invoice column start -->
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

                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                   data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Quantity
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" id="goods_quantity" class="inputs_up text-right form-control" placeholder="Product Quantity" min="1"
                                                                                       onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                                       onkeyup="quantityRateMultiply(  'goods_quantity', 'pro_rate_secondary', 'amount_secondary', '')"/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
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
                                                                                <input type="text" class="inputs_up text-center form-control" id="pro_uom_secondary" placeholder="Product UOM"
                                                                                       readonly/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                   data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Pack Size
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" class="inputs_up text-center form-control" id="pack_size_secondary" placeholder="Pack Size"
                                                                                       readonly/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->


                                                                    <div class="invoice_col basis_col_6"><!-- invoice column start -->
                                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                                   data-placement="bottom" data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </a>
                                                                                Rate
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" class="inputs_up text-right form-control" id="pro_rate_secondary" placeholder="Product Rate"
                                                                                       onkeyup="quantityRateMultiply(  'goods_quantity', 'pro_rate_secondary', 'amount_secondary', '')"/>
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
                                                                                Total Amount
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                <input type="text" class="inputs_up text-right form-control" id="amount_secondary" placeholder="Total Amount" readonly/>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->


                                                                    <div class="invoice_col basis_col_17"><!-- invoice column start -->
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
                                                                                                <th class="text-center tbl_srl_4"> Sr.</th>
                                                                                                <th class="text-center tbl_srl_13"> Code</th>
                                                                                                <th class="text-center tbl_txt_20"> Title</th>
                                                                                                <th class="text-center tbl_txt_29"> Product Remarks</th>
                                                                                                <th class="text-center tbl_txt_6"> Quantity</th>
                                                                                                <th class="text-center tbl_srl_6"> UOM</th>
                                                                                                <th class="text-center tbl_srl_6"> Pack Size</th>
                                                                                                <th class="text-center tbl_srl_6"> Rate</th>
                                                                                                <th class="text-center tbl_srl_10"> Amount</th>
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
                                                                                                    Total Amount
                                                                                                </th>
                                                                                                <td class="text-center tbl_srl_12">
                                                                                                    <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                                            <input type="text" name="ttlAmountId_secondary" id="ttlAmountId_secondary"
                                                                                                                   class="inputs_up text-right form-control required" placeholder="0.00" readonly
                                                                                                                   data-rule-required="true" data-msg-required="Please Create Minimum One Inventory"/>
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

                                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                                                <div class="invoice_row"><!-- invoice row start -->

                                                                    <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                                        <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                                <button type="submit" name="save" id="save" class="invoice_frm_btn">
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
                                        </div>


                                    </div>
                                </div><!-- tabs end here -->

                            </div><!-- invoice box end -->
                        </div><!-- invoice container end -->


                        <input type="hidden" name="cartDataForProductRecipe" id="cartDataForProductRecipe"/>
                        <input type="hidden" name="cartDataForFinishedGoods" id="cartDataForFinishedGoods"/>


                    </form>
                </div>


            </div> <!-- white column form ends here -->

        </div><!-- col end -->


    </div><!-- row end -->


@endsection


@section('scripts')

    <script src="{{ asset('public/vendors/scripts/inventory_add_scripts.js') }}"></script>

    <script type="text/javascript">

        let inputValuesArray = [],
            idForShowAndGetData = {},
            tableColumnsClasseArray = {},
            validateInputIdArray = [];


        function addToCartForRawProducts(e) {

            let code = document.getElementById("pro_code"),
                title = document.getElementById("pro_title"),
                remarks = document.getElementById("pro_remarks"),
                quantity = document.getElementById("quantity"),
                uom = document.getElementById("pro_uom_raw"),
                rate = document.getElementById("pro_rate"),
                packSize = document.getElementById("pack_size"),
                amount = document.getElementById("amount"),
                tblListId = 'listForProductRecipe',
                cartDataArrayId = 'cartDataForProductRecipe',
                ttlAmountId = 'ttlAmountId',
                ttlAmountViewId = 'rawTotalAmountView',
                addBtnId = 'addInventoryForProductRecipe',
                cancelBtnId = 'cancelInventoryForProductRecipe',
                btnCallMethodName = 'addToCartForRawProducts';

            idForShowAndGetData = {
                tblListId: tblListId,
                cartDataArrayId: cartDataArrayId,
                ttlAmountId: ttlAmountId,
                ttlAmountViewId: ttlAmountViewId,
                addBtnId: addBtnId,
                cancelBtnId: cancelBtnId,
                btnCallMethodName: btnCallMethodName,
                codeId: code.id,
                titleId: title.id,
                remarksId: remarks.id,
                quantityId: quantity.id,
                uomId: uom.id,
                packSizeId: packSize.id,
                rateId: rate.id,
                amountId: amount.id,
            };
            validateInputIdArray = [
                code.id,
                title.id,
                quantity.id,
                uom.id,
                packSize.id,
                rate.id,
                amount.id,
            ];
            inputValuesArray = {
                code: code.value,
                title: title.options[title.selectedIndex].text,
                remarks: remarks.value,
                quantity: quantity.value,
                uom: uom.value,
                packSize: packSize.value,
                rate: rate.value,
                amount: amount.value,
            };
            tableColumnsClasseArray = {
                srClass: 'text-center tbl_srl_4',
                codeClass: 'text-center tbl_srl_13',
                titleClass: 'text-left tbl_txt_20',
                remarksClass: 'text-left tbl_txt_29',
                rateClass: 'text-right tbl_txt_6',
                quantityClass: 'text-center tbl_srl_6',
                uomClass: 'text-center tbl_srl_6',
                packSizeClass: 'text-center tbl_srl_6',
                amountClass: 'text-right tbl_srl_10',
            };

            let displayText = new displayValuesInTable(inputValuesArray, idForShowAndGetData);
            displayText.onlyForUOMRateAmountWithPackSizeForInputs(e, tableColumnsClasseArray, validateInputIdArray);
            inputValuesArray = [];

        }


        function addToCartForFinishedGoods(e) {

            let code = document.getElementById("goods_code"),
                title = document.getElementById("goods_title"),
                remarks = document.getElementById("goods_remarks"),
                quantity = document.getElementById("goods_quantity"),
                uom = document.getElementById("pro_uom_secondary"),
                rate = document.getElementById("pro_rate_secondary"),
                packSize = document.getElementById("pack_size_secondary"),
                amount = document.getElementById("amount_secondary"),
                tblListId = 'listForFinishedGoods',
                cartDataArrayId = 'cartDataForFinishedGoods',
                ttlAmountId = 'ttlAmountId_secondary',
                ttlAmountViewId = 'primaryTotalAmountView',
                addBtnId = 'addInventoryForFinishedGoods',
                cancelBtnId = 'cancelInventoryForFinishedGoods',
                btnCallMethodName = 'addToCartForFinishedGoods';

            idForShowAndGetData = {
                tblListId: tblListId,
                cartDataArrayId: cartDataArrayId,
                ttlAmountId: ttlAmountId,
                ttlAmountViewId: ttlAmountViewId,
                addBtnId: addBtnId,
                cancelBtnId: cancelBtnId,
                btnCallMethodName: btnCallMethodName,
                codeId: code.id,
                titleId: title.id,
                remarksId: remarks.id,
                quantityId: quantity.id,
                uomId: uom.id,
                packSizeId: packSize.id,
                rateId: rate.id,
                amountId: amount.id,
            };
            validateInputIdArray = [
                code.id,
                title.id,
                quantity.id,
                uom.id,
                packSize.id,
                rate.id,
                amount.id,
            ];
            inputValuesArray = {
                code: code.value,
                title: title.options[title.selectedIndex].text,
                remarks: remarks.value,
                quantity: quantity.value,
                uom: uom.value,
                packSize: packSize.value,
                rate: rate.value,
                amount: amount.value,
            };
            tableColumnsClasseArray = {
                srClass: 'text-center tbl_srl_4',
                codeClass: 'text-center tbl_srl_13',
                titleClass: 'text-left tbl_txt_20',
                remarksClass: 'text-left tbl_txt_29',
                rateClass: 'text-right tbl_txt_6',
                quantityClass: 'text-center tbl_srl_6',
                uomClass: 'text-center tbl_srl_6',
                packSizeClass: 'text-center tbl_srl_6',
                amountClass: 'text-right tbl_srl_10',
            };

            let displayText = new displayValuesInTable(inputValuesArray, idForShowAndGetData);
            displayText.onlyForUOMRateAmountWithPackSizeForInputs(e, tableColumnsClasseArray, validateInputIdArray);
            inputValuesArray = [];

        }


        $(document).on('keyup keypress', 'form input', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                return false;
            }
        });

    </script>


    <script>


        $(document).ready(function () {


            // Initialize select2
            $("#pro_code").append("{!! $pro_code !!}");
            $("#pro_title").append("{!! $pro_name !!}");
            $("#goods_code").append("{!! $pro_code !!}");
            $("#goods_title").append("{!! $pro_name !!}");
            $("#primary_limited_product_code").append("{!! $pro_code !!}");
            $("#primary_limited_product_title").append("{!! $pro_name !!}");

            $("#pro_code").select2();
            $("#pro_title").select2();
            $("#goods_code").select2();
            $("#goods_title").select2();
            $("#primary_limited_product_code").select2();
            $("#primary_limited_product_title").select2();


        });


        function codeTitleChangeMethod(e, id) {
            // let code = e.value,
            let code = e.options[e.selectedIndex].getAttribute('data-code');


            $("#" + id).select2("destroy");
            $("#" + id + " option[data-code='" + code + "']").prop('selected', true);
            $("#" + id).select2();
        }


        function codeTitleChangeMethodForPrimary(e, id, uomId, packSizeId) {

            let code = e.options[e.selectedIndex].getAttribute('data-code'),
                uom = e.options[e.selectedIndex].getAttribute('data-uom'),
                packSize = e.options[e.selectedIndex].getAttribute('data-pack_size');

            $("#" + uomId).val(uom);
            $("#" + packSizeId).val(packSize);
            $("#" + id).select2("destroy");
            $("#" + id + " option[data-code='" + code + "']").prop('selected', true);
            $("#" + id).select2();
        }


        function multiplicationQuantityToRateMethod(e, uomId, packSizeId, rateId, amountId, quantityId) {
            // let code = e.value,
            let proUOM = e.options[e.selectedIndex].getAttribute('data-uom'),
                packSize = e.options[e.selectedIndex].getAttribute('data-pack_size'),
                rate = e.options[e.selectedIndex].getAttribute('data-average_price'),
                amount = "";


            quantityRateMultiply(quantityId, rateId, amountId, rate);

            $("#" + uomId).val(proUOM);
            $("#" + packSizeId).val(packSize);
            $("#" + rateId).val(rate);
        }


        function multiplicationQuantityToRateMethodForPrimary(rawTtlAmountId, quantityId, rateId, primaryTtlAmountId) {

            let setQuantityInput = document.getElementById(quantityId),
                quantity = (setQuantityInput.value === "" || setQuantityInput.value === 0) ? 1 : setQuantityInput.value,
                setTtlAmountInput = document.getElementById(rawTtlAmountId),
                ttlAmount = (setTtlAmountInput.value === 0 || setTtlAmountInput.value === "") ? 0 : setTtlAmountInput.value,
                getProRate = ttlAmount / quantity;

            $("#" + rateId).val(getProRate.toFixed(2));
            $("#" + primaryTtlAmountId).val(ttlAmount);

        }


        function quantityRateMultiply(quantityId, rateId, amountId, rateVal) {

            let selectQuantityInput = document.getElementById(quantityId),
                quantity = (selectQuantityInput.value !== "" || selectQuantityInput.value > 0) ? selectQuantityInput.value : 1,
                selectRateInput = document.getElementById(rateId),
                rate = "",
                amount = "";

            if (rateVal === 0 || rateVal === "" || rateVal === null) {
                rate = selectRateInput.value;
            } else {
                rate = rateVal;
            }

            amount = parseFloat(rate) * parseFloat(quantity);

            document.getElementById(amountId).value = amount.toFixed(2);

        }


        function controleTabsCus(e, ttlAmountId) {
            const setTtlAmountInput = document.getElementById(ttlAmountId);

            if (setTtlAmountInput.value > 0 && (setTtlAmountInput.value !== "" || setTtlAmountInput.value !== 0 || setTtlAmountInput.value !== "0")) {
                if (e.classList.contains('disabled')) {
                    e.classList.remove('disabled');
                }
            } else {
                e.classList.add('disabled');
            }
        }

    </script>


@endsection
