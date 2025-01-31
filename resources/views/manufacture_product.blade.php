
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Manufacture Product</h4>
                            </div>
                            <div class="list_btn">
                                <a class="btn list_link add_more_button" href="{{ route('manufacture_product_list') }}" role="button">
                                    <i class="fa fa-list"></i> view list
                                </a>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->

                    <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                        <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                            <form name="f1" class="f1" id="f1" action="{{ route('submit_manufacture_product') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                                @csrf
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_24"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        Recipe
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <div class="invoice_col_short"><!-- invoice column short start -->
                                                            <a href="{{ route('product_recipe') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_recipe" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select name="recipe" class="inputs_up form-control" id="recipe"
                                                                data-rule-required="true" data-msg-required="Please Enter Recipe"
                                                        >
                                                            <option value="0">Select Recipe</option>
                                                            @foreach($recipe_lists as $recipe_list)
                                                                <option value="{{$recipe_list->pr_id}}" {{$recipe_list->pr_id == old('recipe') ? 'selected' : ''}} data-pro_code="{{$recipe_list->pr_pro_code}}" data-qty="{{$recipe_list->pr_qty}}">
                                                                    {{$recipe_list->pr_name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_24"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        Account Code
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <div class="invoice_col_short"><!-- invoice column short start -->
                                                            <a href="{{ route('account_registration') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_manufacture_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select name="manufacture_account_code" class="inputs_up form-control" id="manufacture_account_code"
                                                                data-rule-required="true" data-msg-required="Please Enter Account Code"
                                                        >
                                                            <option value="0">Code</option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_24"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a
                                                            data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.supplier_registration.account_title.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.supplier_registration.account_title.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.supplier_registration.account_title.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.supplier_registration.account_title.validations') }}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Account Title
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <div class="invoice_col_short"><!-- invoice column short start -->
                                                            <a href="{{ route('account_registration') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_manufacture_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select name="manufacture_account_name" class="inputs_up form-control" id="manufacture_account_name"
                                                                data-rule-required="true" data-msg-required="Please Enter Account Title"
                                                        >
                                                            <option value="0">Account</option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_24"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                        <a
                                                            data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Remarks
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="remarks" class="inputs_up form-control" id="remarks" value="{{old('remarks')}}" placeholder="Remarks">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_24"><!-- invoice column start -->
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
                                                            <a href="{{ route('add_product') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_manufacture_product_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select name="manufacture_product_code" class="inputs_up form-control" id="manufacture_product_code"
                                                                data-rule-required="true" data-msg-required="Please Enter Bar Code"
                                                        >
                                                            <option value="0">Code</option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_24"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.description')}}</p>
                                                         <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Title
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <div class="invoice_col_short"><!-- invoice column short start -->
                                                            <a href="{{ route('add_product') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_manufacture_product_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select name="manufacture_product_name" class="inputs_up form-control" id="manufacture_product_name"
                                                                data-rule-required="true" data-msg-required="Please Enter Product Title"
                                                        >
                                                            <option value="0">Product</option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_24"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.qty.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Qty
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="manufacture_qty" class="inputs_up form-control" id="manufacture_qty"
                                                               data-rule-required="true" data-msg-required="Please Enter Qty"
                                                               value="{{old('manufacture_qty')}}" placeholder="Qty" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" />
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_24"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        Complete Date
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="complete_date" value="{{old('complete_date')}}" class="inputs_up form-control date-picker"
                                                               data-rule-required="true" data-msg-required="Please Enter Date"
                                                               id="complete_date" placeholder="Complete Date">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->
                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <h5>Add Products</h5>
                                            </div><!-- invoice column end -->
                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->

                                                <div class="invoice_row"><!-- invoice row start -->

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
                                                                    <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a id="refresh_product_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                        <i class="fa fa-refresh"></i>
                                                                    </a>
                                                                </div><!-- invoice column short end -->
                                                                <select name="product_code" class="inputs_up inputs_up_invoice form-control" id="product_code"
                                                                >
                                                                    <option value="0">Code</option>
                                                                </select>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                   data-placement="bottom" data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.description')}}</p>
                                                         <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.benefits')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Product Title
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->

                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                    <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a id="refresh_product_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                        <i class="fa fa-refresh"></i>
                                                                    </a>
                                                                </div><!-- invoice column short end -->
                                                                <select name="product_name" class="inputs_up inputs_up_invoice form-control" id="product_name"
                                                                >
                                                                    <option value="0">Product Title</option>
                                                                </select>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_23"><!-- invoice column start -->
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
                                                                Transaction Remarks
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="text" name="product_remarks" class="inputs_up form-control" id="product_remarks" placeholder="Remarks" />
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                   data-placement="bottom" data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.qty.description')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Qty
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="text" name="quantity" class="inputs_up text-right form-control" id="quantity"
                                                                       placeholder="Qty" onfocus="this.select();" onkeyup="product_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);" />
                                                                <span id="demo8" class="validate_sign"></span>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_11 hidden" hidden><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                Rate
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="text" name="rate" class="inputs_up text-right form-control" id="rate" placeholder="Rate" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="product_amount_calculation();" />
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_11 hidden" hidden><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                Amount
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="text" name="amount" class="inputs_up text-right form-control" id="amount" placeholder="Amount" readonly>
                                                                <span id="demo10" class="validate_sign"></span>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                        <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                                            <div class="invoice_col_txt with_cntr_jstfy">
                                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                    <button id="first_add_more" class="invoice_frm_btn" onclick="add_sale()" type="button">
                                                                        <i class="fa fa-plus"></i> Add
                                                                    </button>
                                                                </div>
                                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                    <button style="display: none;" id="cancel_button" class="invoice_frm_btn" onclick="cancel_all()" type="button">
                                                                        <i class="fa fa-times"></i> Cancel
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->


                                                </div><!-- invoice row end -->

                                                <div class="invoice_row"><!-- invoice row start -->

                                                    <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                                        <div class="invoice_col_bx for_tabs"><!-- invoice column box start -->
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input company_info_check_box" id="add_auto" name="add_auto" value="1" checked>
                                                                <label class="custom-control-label chck_pdng" for="add_auto"> Auto Add </label>
                                                            </div>

                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                                        <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                                            <div class="pro_tbl_bx"><!-- product table box start -->
                                                                <table class="table gnrl-mrgn-pdng" id="category_dynamic_table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-center tbl_srl_9">
                                                                            Code
                                                                        </th>
                                                                        <th class="text-center tbl_txt_20">
                                                                            Title
                                                                        </th>
                                                                        <th class="text-center tbl_txt_58">
                                                                            Transaction Remarks
                                                                        </th>
                                                                        <th class="text-center tbl_srl_12">
                                                                            Qty
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="table_body">

                                                                    </tbody>

                                                                    <tfoot>
                                                                    <tr>
                                                                        <th colspan="3" class="text-right">
                                                                            Total Items
                                                                        </th>
                                                                        <td class="text-center tbl_srl_12">
                                                                            <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                    <input type="text" name="total_items" class="inputs_up text-right form-control total-items-field"
                                                                                           data-rule-required="true" data-msg-required="Please Add Total Item"
                                                                                           id="total_items" placeholder="0.00" readonly />
                                                                                </div><!-- invoice column input end -->
                                                                            </div><!-- invoice column box end -->
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="hidden" hidden>
                                                                        <th colspan="3" class="text-right">
                                                                            Total Price
                                                                        </th>
                                                                        <td class="text-center tbl_srl_12">
                                                                            <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                    <input type="text" name="total_price" class="inputs_up text-right form-control" id="total_price" placeholder="0.00" readonly />
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

                                        <div class="invoice_row"><!-- invoice row start -->
                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <h5>Add Expenses</h5>
                                            </div><!-- invoice column end -->
                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->

                                                {{--expense account struct start--}}

                                                <div class="invoice_row"><!-- invoice row start -->

                                                    <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                Account Code
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                    <a href="{{ route('expense_account_registration') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                        <i class="fa fa-refresh"></i>
                                                                    </a>
                                                                </div><!-- invoice column short end -->
                                                                <select name="account_code" class="inputs_up form-control" id="account_code"
                                                                >
                                                                    <option value="0">Code</option>
                                                                </select>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.supplier_registration.account_title.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.supplier_registration.account_title.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.supplier_registration.account_title.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.supplier_registration.account_title.validations') }}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Account Title
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->

                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                    <a href="{{ route('expense_account_registration') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a id="refresh_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                        <i class="fa fa-refresh"></i>
                                                                    </a>
                                                                </div><!-- invoice column short end -->
                                                                <select name="account_name" class="inputs_up form-control" id="account_name"
                                                                >
                                                                    <option value="0">Select Account</option>
                                                                </select>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                   data-placement="bottom" data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Transaction Remarks
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="text" name="account_remarks" class="inputs_up form-control"
                                                                       id="account_remarks" placeholder="Remarks" />
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                   data-placement="bottom" data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.amount.description')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Amount
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="text" name="account_amount" class="inputs_up text-right form-control" id="account_amount"
                                                                       placeholder="Amount" onkeypress="return allow_only_number_and_decimals(this,event);" />
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                        <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                                            <div class="invoice_col_txt with_cntr_jstfy">
                                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                    <button id="first_add_more_account" class="invoice_frm_btn" onclick="add_account()" type="button">
                                                                        <i class="fa fa-plus"></i> Add
                                                                    </button>
                                                                </div>
                                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                    <button style="display: none;" id="cancel_button_account" class="invoice_frm_btn" onclick="cancel_all_account()" type="button">
                                                                        <i class="fa fa-times"></i> Cancel
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->


                                                </div><!-- invoice row end -->

                                                <div class="invoice_row"><!-- invoice row start -->

                                                    <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                                        <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                                            <div class="pro_tbl_bx"><!-- product table box start -->
                                                                <table class="table gnrl-mrgn-pdng" id="category_dynamic_table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-center tbl_srl_9">
                                                                            Account Code
                                                                        </th>
                                                                        <th class="text-center tbl_txt_20">
                                                                            Account Title
                                                                        </th>
                                                                        <th class="text-center tbl_txt_58">
                                                                            Transaction Remarks
                                                                        </th>
                                                                        <th class="text-center tbl_srl_12">
                                                                            Amount
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="account_table_body">

                                                                    </tbody>
                                                                </table>
                                                            </div><!-- product table box end -->
                                                        </div><!-- product table container end -->
                                                    </div><!-- invoice column end -->

                                                </div><!-- invoice row end -->

                                                {{--expense account struct end--}}

                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        Total Accounts
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="total_accounts" class="text-right inputs_up form-control total-items-field"
                                                               data-rule-required="true" data-msg-required="Please Add"
                                                               id="total_accounts" placeholder="0.00" readonly />
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        Total Amount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="total_account_amount" class="text-right inputs_up form-control" id="total_account_amount"
                                                               data-rule-required="true" data-msg-required="Please Add"
                                                               placeholder="0.00" readonly />
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.grand_total.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Grand Total
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="grand_total" class="text-right inputs_up form-control" id="grand_total"
                                                               data-rule-required="true" data-msg-required="Please Add"
                                                               placeholder="0.00" readonly />
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button type="submit" name="save" id="save" class="invoice_frm_btn"
                                                        >
                                                            <i class="fa fa-floppy-o"></i> Save
                                                        </button>
                                                        <span id="demo13" class="validate_sign"></span>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                        </div><!-- invoice row end -->

                                    </div><!-- invoice content end -->
                                </div><!-- invoice scroll box end -->


                                <input type="hidden" name="salesval" id="salesval">
                                <input type="hidden" name="account_values" id="account_values">
                                <input type="hidden" name="manufacture_account_name_text" id="manufacture_account_name_text">
                                <input type="hidden" name="manufacture_product_name_text" id="manufacture_product_name_text">


                            </form>

                        </div><!-- invoice box end -->
                    </div><!-- invoice container end -->




                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let recipe = document.getElementById("recipe"),
                manufacture_account_code = document.getElementById("manufacture_account_code"),
                manufacture_account_name = document.getElementById("manufacture_account_name"),
                manufacture_product_code = document.getElementById("manufacture_product_code"),
                manufacture_product_name = document.getElementById("manufacture_product_name"),
                manufacture_qty = document.getElementById("manufacture_qty"),
                complete_date = document.getElementById("complete_date"),
                total_items = document.getElementById("total_items"),
                total_accounts = document.getElementById("total_accounts"),
                total_account_amount = document.getElementById("total_account_amount"),
                grand_total = document.getElementById("grand_total"),
                validateInputIdArray = [
                    recipe.id,
                    manufacture_account_code.id,
                    manufacture_account_name.id,
                    manufacture_product_code.id,
                    manufacture_product_name.id,
                    manufacture_qty.id,
                    complete_date.id,
                    total_items.id,
                    total_accounts.id,
                    total_account_amount.id,
                    grand_total.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                $("#first_add_more").click();
                // event.preventDefault();
                return false;
            }
        });

        // recipe ajax
        jQuery("#refresh_manufacture_account_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_manufacture_account_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#manufacture_account_code").html(" ");
                    jQuery("#manufacture_account_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_manufacture_account_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_manufacture_account_name",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#manufacture_account_name").html(" ");
                    jQuery("#manufacture_account_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_manufacture_account_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_manufacture_account_name",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#manufacture_account_name").html(" ");
                    jQuery("#manufacture_account_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_manufacture_account_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_manufacture_account_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#manufacture_account_code").html(" ");
                    jQuery("#manufacture_account_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

 // recipe ajax
        jQuery("#refresh_recipe").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_recipe",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#recipe").html(" ");
                    jQuery("#recipe").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        // product code and name ajax
        jQuery("#refresh_manufacture_product_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_product_club_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#manufacture_product_code").html(" ");
                    jQuery("#manufacture_product_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_manufacture_product_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_product_club_name",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#manufacture_product_name").html(" ");
                    jQuery("#manufacture_product_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_manufacture_product_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_product_club_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#manufacture_product_code").html(" ");
                    jQuery("#manufacture_product_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_manufacture_product_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_product_club_name",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#manufacture_product_name").html(" ");
                    jQuery("#manufacture_product_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        // product code and name ajax
        jQuery("#refresh_product_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_manufacture_product_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#product_code").html(" ");
                    jQuery("#product_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_product_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_manufacture_product_name ",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#product_name").html(" ");
                    jQuery("#product_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_product_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_manufacture_product_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#product_code").html(" ");
                    jQuery("#product_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_product_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_manufacture_product_name ",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#product_name").html(" ");
                    jQuery("#product_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        // account code and name ajax
        jQuery("#refresh_account_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_expense_accounts_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#account_code").html(" ");
                    jQuery("#account_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_account_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_expense_accounts_name",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#account_name").html(" ");
                    jQuery("#account_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_account_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_expense_accounts_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#account_code").html(" ");
                    jQuery("#account_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_account_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_expense_accounts_name",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#account_name").html(" ");
                    jQuery("#account_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });
    </script>

    <script>

        function product_amount_calculation() {
            // var quantity = jQuery("#quantity").val();
            // var rate = jQuery("#rate").val();
            //
            // var amount = rate * quantity;
            //
            // jQuery("#amount").val(amount);
        }

        function grand_total_calculation() {

            var total_price = 0;
            var total_account_amount = 0;
            var grand_total;

            // total_discount = 0;

            // jQuery.each(sales, function (index, value) {
            //     total_price = +total_price + +value[4];
            // });

            jQuery.each(accounts, function (index, value) {
                total_account_amount = +total_account_amount + +value[2];
            });

            grand_total = +total_price + +total_account_amount;

            jQuery("#total_price").val(total_price);
            jQuery("#total_account_amount").val(total_account_amount);
            jQuery("#grand_total").val(grand_total);
        }
    </script>

    <script>
        jQuery("#recipe").change(function () {

            var recipe_id = jQuery('option:selected', this).val();
            var pro_code = jQuery('option:selected', this).attr('data-pro_code');
            var qty = jQuery('option:selected', this).attr('data-qty');

            if (recipe_id == 0) {
                jQuery("#table_body").html("");

                numberofsales = 0;
                sales = {};

                pro_code = 0;

                $("#salesval").val('');
                jQuery("#total_items").val(numberofsales);
                grand_total_calculation();
            }

            jQuery("#manufacture_qty").val(qty);

            jQuery("#manufacture_product_code").select2("destroy");
            jQuery("#manufacture_product_name").select2("destroy");

            jQuery("#manufacture_product_code").children("option[value^=" + pro_code + "]");
            jQuery('#manufacture_product_code option[value="' + pro_code + '"]').prop('selected', true);

            jQuery("#manufacture_product_name").children("option[value^=" + pro_code + "]");
            jQuery('#manufacture_product_name option[value="' + pro_code + '"]').prop('selected', true);



            var manufacture_product_name_text = $("#manufacture_product_name option:selected").text();
            jQuery("#manufacture_product_name_text").val(manufacture_product_name_text);


            jQuery("#table_body").html("");

            numberofsales == 0;
            sales = {};

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery("#manufacture_product_code").select2();
            jQuery("#manufacture_product_name").select2();
            jQuery.ajax({
                url: "{{ route('get_product_recipe_details') }}",
                data: {id: recipe_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    jQuery("#table_body").html("");
                    $.each(data, function (index, value) {

                        if (global_id_to_edit != 0) {
                            jQuery("#" + global_id_to_edit).remove();

                            delete sales[global_id_to_edit];
                        }
                        counter++;

                        var selected_code_value = value['pri_product_code'];
                        var product_name = value['pri_product_name'];
                        var qty = value['pri_qty'];
                        var selected_remarks = '';
                        // var selected_rate = value['pri_rate'];
                        // var selected_amount = value['pri_amount'];
                        var selected_rate = 0;
                        var selected_amount = 0;

                        numberofsales = Object.keys(sales).length;

                        if (numberofsales == 0) {
                            jQuery("#table_body").html("");
                        }

                        sales[counter] = {
                            'product_code': selected_code_value,
                            'product_name': product_name,
                            'product_qty': qty,
                            // 'product_rate': selected_rate,
                            // 'product_amount': selected_amount,
                            'product_remarks': selected_remarks
                        };

                        numberofsales = Object.keys(sales).length;
                        var remarks_var = '';
                        if (selected_remarks != '') {
                            var remarks_var = '' + selected_remarks + '';
                        }

                        jQuery("#table_body").append('<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + selected_code_value + '</td><td class="text-left tbl_txt_20">' + product_name + '</td><td class="text-left tbl_txt_58">' + remarks_var + '</td><td class="text-right tbl_srl_12">' + qty + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_sale(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></div></td><td class="text-right tbl_srl_12" hidden>' + selected_rate + '</td><td class="text-right tbl_srl_12" hidden>' + selected_amount + '</td></tr>');
                        jQuery("#salesval").val(JSON.stringify(sales));

                        jQuery("#total_items").val(numberofsales);

                        grand_total_calculation();
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

    </script>

    <script>
        jQuery("#manufacture_product_code").change(function () {

            var pname = jQuery('option:selected', this).val();
            jQuery("#manufacture_product_name").select2("destroy");
            jQuery("#manufacture_product_name").children("option[value^=" + pname + "]");

            jQuery('#manufacture_product_name option[value="' + pname + '"]').prop('selected', true);
            jQuery("#manufacture_product_name").select2();

            var manufacture_product_name_text = $("#manufacture_product_name option:selected").text();

            jQuery("#manufacture_product_name_text").val(manufacture_product_name_text);
        });

    </script>

    <script>
        jQuery("#manufacture_product_name").change(function () {

            var pcode = jQuery('option:selected', this).val();
            jQuery("#manufacture_product_code").select2("destroy");
            jQuery("#manufacture_product_code").children("option[value^=" + pcode + "]");
            jQuery('#manufacture_product_code option[value="' + pcode + '"]').prop('selected', true);
            jQuery("#manufacture_product_code").select2();

            var manufacture_product_name_text = jQuery('option:selected', this).text();
            jQuery("#manufacture_product_name_text").val(manufacture_product_name_text);
        });

    </script>

    <script>
        var check_add = 0;
        jQuery("#product_code").change(function () {

            // var sale_price = jQuery('option:selected', this).attr('data-sale_price');

            // jQuery("#rate").val(sale_price);

            var pname = jQuery('option:selected', this).val();

            jQuery("#quantity").val('1');

            jQuery("#product_name").select2("destroy");
            jQuery("#product_name").children("option[value^=" + pname + "]");

            jQuery('#product_name option[value="' + pname + '"]').prop('selected', true);

            product_amount_calculation();

            jQuery("#product_name").select2();
            // jQuery("#quantity").focus();

            if ($("#add_auto").is(':checked')) {
                $("#first_add_more").click();  // checked
                check_add = 1;
                setTimeout(function () {
                    $('#product_code').select2('open');
                }, 100);
            }
        });

    </script>

    <script>
        jQuery("#product_name").change(function () {
            // var sale_price = jQuery('option:selected', this).attr('data-sale_price');

            var pcode = jQuery('option:selected', this).val();

            jQuery("#quantity").val('1');

            jQuery("#product_code").select2("destroy");
            jQuery("#product_code").children("option[value^=" + pcode + "]");

            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);

            // jQuery("#rate").val(sale_price);

            product_amount_calculation();

            jQuery("#product_code").select2();
            // jQuery("#quantity").focus();

            if ($("#add_auto").is(':checked')) {
                $("#first_add_more").click();  // checked

                check_add = 1;
                setTimeout(function () {
                    $('#product_code').select2('open');

                }, 100);
            }
        });

    </script>

    <script>
        // adding packs into table
        var numberofsales = 0;
        var counter = 0;
        var sales = {};
        var global_id_to_edit = 0;
        var total_discount = 0;

        function popvalidation() {
            isDirty = true;

            // var recipe_name = document.getElementById("recipe_name").value;

            var manufacture_account_code = document.getElementById("manufacture_account_code").value;
            var manufacture_account_name = document.getElementById("manufacture_account_name").value;
            var manufacture_product_code = document.getElementById("manufacture_product_code").value;
            var manufacture_product_name = document.getElementById("manufacture_product_name").value;
            var manufacture_qty = document.getElementById("manufacture_qty").value;
            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var product_remarks = document.getElementById("product_remarks").value;
            var quantity = document.getElementById("quantity").value;
            // var rate = document.getElementById("rate").value;
            // var amount = document.getElementById("amount").value;

            var flag_submit = true;
            var focus_once = 0;


            // if (recipe_name.trim() == "") {
            //     if (focus_once == 0) {
            //         jQuery("#recipe_name").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            // }

            if (manufacture_account_code.trim() == "0") {
                if (focus_once == 0) {
                    jQuery("#manufacture_account_code").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
            }

            if (manufacture_account_name.trim() == "0") {
                if (focus_once == 0) {
                    jQuery("#manufacture_account_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
            }


            if (manufacture_product_code.trim() == "0") {
                if (focus_once == 0) {
                    jQuery("#manufacture_product_code").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
            }

            if (manufacture_product_name.trim() == "0") {
                if (focus_once == 0) {
                    jQuery("#manufacture_product_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
            }

            if (manufacture_qty.trim() == "") {
                if (focus_once == 0) {
                    jQuery("#manufacture_qty").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
            }


            if (numberofsales == 0) {
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


                if (quantity == "" || quantity <= 0) {

                    if (focus_once == 0) {
                        jQuery("#quantity").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                //
                // if (rate == "") {
                //     if (focus_once == 0) {
                //         jQuery("#rate").focus();
                //         focus_once = 1;
                //     }
                //     flag_submit = false;
                // }


                // if (amount == "") {
                //     if (focus_once == 0) {
                //         jQuery("#amount").focus();
                //         focus_once = 1;
                //     }
                //     flag_submit = false;
                // }

                document.getElementById("demo13").innerHTML = "Add Products";
                flag_submit = false;
            } else {
                document.getElementById("demo13").innerHTML = "";
            }

            return flag_submit;
        }


        function add_sale() {

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var product_remarks = document.getElementById("product_remarks").value;
            var quantity = document.getElementById("quantity").value;
            // var rate = document.getElementById("rate").value;
            // var amount = document.getElementById("amount").value;

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (product_code == "0") {

                if (focus_once1 == 0) {
                    jQuery("#product_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (product_name == "0") {
                if (focus_once1 == 0) {
                    jQuery("#product_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (quantity == "" || quantity <= 0) {
                if (focus_once1 == 0) {
                    jQuery("#quantity").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            // if (rate == "") {
            //     if (focus_once1 == 0) {
            //         jQuery("#rate").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // }


            // if (amount == "") {
            //
            //     if (focus_once1 == 0) {
            //         jQuery("#amount").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete sales[global_id_to_edit];
                }

                counter++;

                jQuery("#product_code").select2("destroy");
                jQuery("#product_name").select2("destroy");

                var product_name = jQuery("#product_name option:selected").text();
                var selected_code_value = jQuery("#product_code option:selected").attr('data-parent');
                var qty = jQuery("#quantity").val();
                var selected_product_name = jQuery("#product_name").val();
                var selected_remarks = jQuery("#product_remarks").val();
                var selected_rate = jQuery("#rate").val();
                var selected_amount = jQuery("#amount").val();

                $.each(sales, function (index, entry) {

                    if (entry['product_code'].trim() == selected_code_value.trim()) {

                        // jQuery(".select2-search__field").val('');

                        if (index != 0) {
                            jQuery("#" + index).remove();

                            delete sales[index];
                        }
                        counter++;

                        // qty = entry['product_qty'];

                        qty = +entry['product_qty'] + +1;

                        selected_amount = selected_rate * qty;
                    }
                });


                numberofsales = Object.keys(sales).length;

                if (numberofsales == 0) {
                    jQuery("#table_body").html("");
                }

                sales[counter] = {
                    'product_code': selected_code_value,
                    'product_name': product_name,
                    'product_qty': qty,
                    // 'product_rate': selected_rate,
                    // 'product_amount': selected_amount,
                    'product_remarks': selected_remarks
                };

                // jQuery("#product_code option[value=" + selected_code_value + "]").attr("disabled", "true");
                // jQuery("#product_name option[value=" + selected_code_value + "]").attr("disabled", "true");
                numberofsales = Object.keys(sales).length;
                var remarks_var = '';
                if (selected_remarks != '') {
                    var remarks_var = '' + selected_remarks + '';
                }

                jQuery("#table_body").append('<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + selected_code_value + '</td><td class="text-left tbl_txt_20">' + product_name + '</td><td class="text-left tbl_txt_58">' + remarks_var + '</td><td class="text-right tbl_srl_12">' + qty + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_sale(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></div></td><td class="text-right tbl_srl_12" hidden>' + selected_rate + '</td><td class="text-right tbl_srl_12" hidden>' + selected_amount + '</td></tr>');

                jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#quantity").val("");
                jQuery("#product_remarks").val("");
                jQuery("#rate").val("");
                jQuery("#amount").val("");

                jQuery("#salesval").val(JSON.stringify(sales));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#total_items").val(numberofsales);

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();

                grand_total_calculation();

                jQuery("#product_code").select2();
                jQuery("#product_name").select2();
            }
        }


        function delete_sale(current_item) {

            jQuery("#" + current_item).remove();

            delete sales[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#salesval").val(JSON.stringify(sales));

            if (isEmpty(sales)) {
                numberofsales = 0;
            }

            var number_of_sales = Object.keys(sales).length;
            jQuery("#total_items").val(number_of_sales);

            grand_total_calculation();

            jQuery("#product_name").select2("destroy");
            jQuery("#product_name").select2();
            jQuery("#product_code").select2("destroy");
            jQuery("#product_code").select2();
        }


        function edit_sale(current_item) {

            // jQuery(".table-responsive").attr("style", "display:none");
            jQuery("#" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_sales = sales[current_item];

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");

            jQuery("#product_code").children("option[value^=" + temp_sales['product_code'] + "]").show(); //showing hid unit

            jQuery('#product_code option[value="' + temp_sales['product_code'] + '"]').prop('selected', true);

            jQuery("#product_name").val(temp_sales['product_code']);
            jQuery("#quantity").val(temp_sales['product_qty']);
            // jQuery("#rate").val(temp_sales['product_rate']);
            // jQuery("#amount").val(temp_sales['product_amount']);
            jQuery("#product_remarks").val(temp_sales['product_remarks']);

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            jQuery("#quantity").val("");

            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");

            jQuery("#product_remarks").val("");
            jQuery("#rate").val("");
            jQuery("#amount").val("");

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#cancel_button").hide();

            // jQuery(".table-responsive").show();
            jQuery("#" + global_id_to_edit).show();

            jQuery("#save").show();

            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');
            global_id_to_edit = 0;

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

        }
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product_code").append("{!! $pro_code !!}");
            jQuery("#product_name").append("{!! $pro_name !!}");

            jQuery("#manufacture_product_code").append("{!! $manufacture_pro_code !!}");
            jQuery("#manufacture_product_name").append("{!! $manufacture_pro_name !!}");

            jQuery("#account_code").append("{!! $expense_account_code !!}");
            jQuery("#account_name").append("{!! $expense_account_name !!}");

            jQuery("#manufacture_account_code").append("{!! $account_code !!}");
            jQuery("#manufacture_account_name").append("{!! $account_name !!}");

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#recipe").select2();
            jQuery("#manufacture_product_name").select2();
            jQuery("#manufacture_product_code").select2();

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();

            jQuery("#manufacture_account_code").select2();
            jQuery("#manufacture_account_name").select2();

            setTimeout(function () {
                // jQuery("#product_code").focus();
                $('#product_code').select2('open');
            }, 100);


            $(window).keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

        });

        window.addEventListener('keydown', function (e) {
            if (e.which == 113) {
                $('#product_code').select2('open');
            }
            if (e.keyCode == 65 && e.altKey) {
                $("#first_add_more").click();
            }
        });
    </script>

    <script>
        $('#view_detail').click(function () {

            var btn_name = jQuery("#view_detail").html();

            if (btn_name.trim() == 'View Detail') {

                jQuery("#view_detail").html('Hide Detail');
            } else {
                jQuery("#view_detail").html('View Detail');
            }
        });

    </script>

    <script>
        jQuery("#manufacture_account_code").change(function () {

            var account_code = jQuery('option:selected', this).val();

            jQuery("#manufacture_account_name").select2("destroy");
            jQuery("#manufacture_account_name").children("option[value^=" + account_code + "]");

            jQuery('#manufacture_account_name option[value="' + account_code + '"]').prop('selected', true);
            jQuery("#manufacture_account_name").select2();

            var manufacture_account_name_text = $("#manufacture_account_name option:selected").text();
            jQuery("#manufacture_account_name_text").val(manufacture_account_name_text);
        });
    </script>

    <script>
        jQuery("#manufacture_account_name").change(function () {

            var account_name = jQuery('option:selected', this).val();

            jQuery("#manufacture_account_code").select2("destroy");
            jQuery("#manufacture_account_code").children("option[value^=" + account_name + "]");
            jQuery('#manufacture_account_code option[value="' + account_name + '"]').prop('selected', true);
            jQuery("#manufacture_account_code").select2();

            var manufacture_account_name_text = $("#manufacture_account_name option:selected").text();
            jQuery("#manufacture_account_name_text").val(manufacture_account_name_text);
        });
    </script>

    <script>
        jQuery("#account_code").change(function () {

            var account_code = jQuery('option:selected', this).val();

            jQuery("#account_name").select2("destroy");
            jQuery("#account_name").children("option[value^=" + account_code + "]");
            jQuery('#account_name option[value="' + account_code + '"]').prop('selected', true);
            jQuery("#account_name").select2();
        });
    </script>

    <script>
        jQuery("#account_name").change(function () {

            var account_name = jQuery('option:selected', this).val();

            jQuery("#account_code").select2("destroy");
            jQuery("#account_code").children("option[value^=" + account_name + "]");
            jQuery('#account_code option[value="' + account_name + '"]').prop('selected', true);
            jQuery("#account_code").select2();
        });
    </script>

    <script>
        // adding packs into table
        var numberofaccounts = 0;
        var accounts_counter = 0;
        var accounts = {};
        var account_global_id_to_edit = 0;

        function add_account() {

            var account_code = document.getElementById("account_code").value;
            var account_name = document.getElementById("account_name").value;
            var account_remarks = document.getElementById("account_remarks").value;
            var account_amount = document.getElementById("account_amount").value;

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (account_code == "0") {
                if (focus_once1 == 0) {
                    jQuery("#account_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {
            }


            if (account_name == "0") {
                if (focus_once1 == 0) {
                    jQuery("#account_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {
            }

            if (account_amount == "") {
                if (focus_once1 == 0) {
                    jQuery("#account_amount").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {
            }

            if (flag_submit1) {

                if (account_global_id_to_edit != 0) {
                    jQuery("#account" + account_global_id_to_edit).remove();

                    delete accounts[account_global_id_to_edit];
                }

                accounts_counter++;

                jQuery("#account_code").select2("destroy");
                jQuery("#account_name").select2("destroy");

                var account_name = jQuery("#account_name option:selected").text();
                var selected_account_code_value = jQuery("#account_code option:selected").val();
                var selected_account_remarks = jQuery("#account_remarks").val();
                var selected_account_amount = jQuery("#account_amount").val();

                numberofaccounts = Object.keys(accounts).length;

                if (numberofaccounts == 0) {
                    jQuery("#account_table_body").html("");
                }

                accounts[accounts_counter] = [selected_account_code_value, account_name, selected_account_amount, selected_account_remarks];

                jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");
                jQuery("#account_name option[value=" + account_code + "]").attr("disabled", "true");

                numberofaccounts = Object.keys(accounts).length;
                var remarks_var = '';
                if (selected_account_remarks != '') {
                    var remarks_var = '' + selected_account_remarks + '';
                }

                jQuery("#account_table_body").prepend('<tr id=account' + accounts_counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + selected_account_code_value + '</td><td class="text-left tbl_txt_20">' + account_name + '</td><td class="text-left tbl_txt_58">' + remarks_var + '</td><td class="text-right tbl_srl_12">' + selected_account_amount + '<div class="edit_update_bx"><a class="account_edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' + accounts_counter + ')><i class="fa fa-edit"></i></a><a href="#" class="account_delete_link btn btn-sm btn-danger" onclick=delete_account(' + accounts_counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#account_amount").val("");

                jQuery("#account_values").val(JSON.stringify(accounts));
                jQuery("#cancel_button_account").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more_account").html('<i class="fa fa-plus"></i> Add');

                jQuery("#total_accounts").val(numberofaccounts);

                jQuery(".account_edit_link").show();
                jQuery(".account_delete_link").show();

                grand_total_calculation();

                jQuery("#account_code").select2();
                jQuery("#account_name").select2();
            }
        }


        function delete_account(current_item) {

            jQuery("#account" + current_item).remove();

            var temp_accounts = accounts[current_item];

            jQuery("#account_code option[value=" + temp_accounts[0] + "]").attr("disabled", false);
            jQuery("#account_name option[value=" + temp_accounts[0] + "]").attr("disabled", false);

            delete accounts[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#account_values").val(JSON.stringify(accounts));

            if (isEmpty(accounts)) {
                numberofaccounts = 0;
            }

            var number_of_accounts = Object.keys(accounts).length;
            jQuery("#total_accounts").val(number_of_accounts);

            grand_total_calculation();

            jQuery("#account_name").select2("destroy");
            jQuery("#account_name").select2();
            jQuery("#account_code").select2("destroy");
            jQuery("#account_code").select2();
        }


        function edit_account(current_item) {

            // jQuery(".table-responsive").attr("style", "display:none");
            jQuery("#account" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more_account").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button_account").show();

            jQuery(".account_edit_link").hide();
            jQuery(".account_delete_link").hide();

            account_global_id_to_edit = current_item;

            var temp_accounts = accounts[current_item];

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");

            jQuery("#account_code").children("option[value^=" + temp_accounts[0] + "]").show(); //showing hid unit

            jQuery("#account_code option[value=" + temp_accounts[0] + "]").attr("disabled", false);
            jQuery("#account_name option[value=" + temp_accounts[0] + "]").attr("disabled", false);

            jQuery('#account_code option[value="' + temp_accounts[0] + '"]').prop('selected', true);

            jQuery("#account_name").val(temp_accounts[0]);
            jQuery("#account_amount").val(temp_accounts[2]);
            jQuery("#account_remarks").val(temp_accounts[3]);

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();

            jQuery("#cancel_button_account").attr("style", "display:inline");
            jQuery("#cancel_button_account").attr("style", "background-color:red !important");
        }

        function cancel_all_account() {

            jQuery("#quantity").val("");

            jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");

            jQuery("#account_remarks").val("");
            jQuery("#account_amount").val("");

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();

            jQuery("#cancel_button_account").hide();

            // jQuery(".table-responsive").show();
            jQuery("#account" + account_global_id_to_edit).show();

            jQuery("#save").show();

            jQuery("#first_add_more_account").html('<i class="fa fa-plus"></i> Add');
            account_global_id_to_edit = 0;

            jQuery(".account_edit_link").show();
            jQuery(".account_delete_link").show();
        }
    </script>

@endsection

