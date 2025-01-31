
@extends('extend_index')

@section('styles_get')

    <link rel="stylesheet" type="text/css" href="{{ asset('public/src/plugins/jquery-steps/build/jquery.steps.css') }}">

@stop
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text"> Product Recipe </h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('product_recipe_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->



            <div class="wizard-content">
                <form class="tab-wizard wizard-circle wizard" id="f1" action="{{ route('submit_product_recipe') }}" method="post"
                {{--                          onsubmit="return checkForm()"--}} onsubmit="return checkFormOnSave()"
                >
                    @csrf
                    <h5>Raw Goods</h5>
                    <section>
                        <div class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                            <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.cash_account.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Recipe Name
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input tabindex=1 type="text" name="recipe_name" class="inputs_up form-control required" id="recipe_name" placeholder="Recipe Name"
                                                                data-rule-required="true" data-msg-required="Please Enter Recipe Name">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Recipe Remarks
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input tabindex="1" type="text" name="recipe_remarks" class="inputs_up form-control" id="recipe_remarks" placeholder="Recipe Remarks">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
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
                                                        <!-- call add or refresh button component -->
                                                        <x-add-refresh-button href="{{ route('add_product') }}" id="refresh_product_code"/>
                                                        <select tabindex="1" class="inputs_up form-control" id="pro_code" onchange="codeTitleChangeMethod(this, 'pro_title', 'pro_uom_raw')">
                                                            <option value="" disabled selected> ---Select Code--- </option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
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
                                                        <!-- call add or refresh button component -->
                                                        <x-add-refresh-button href="{{ route('add_product') }}" id="refresh_product_name"/>

                                                        <select tabindex="1" class="inputs_up form-control" id="pro_title" onchange="codeTitleChangeMethod(this, 'pro_code', 'pro_uom_raw')">
                                                            <option value="" disabled selected> ---Select Product--- </option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
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
                                                        <input tabindex="1" type="text" class="inputs_up form-control" id="pro_remarks" placeholder="Product Remarks">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
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
                                                        <input tabindex="1" type="text" class="inputs_up text-right form-control" id="quantity" placeholder="Product Quantity" min="1" onkeypress="return allow_only_number_and_decimals(this,event);" />
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
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
                                                        <input tabindex="1" type="text" class="inputs_up form-control" id="pro_uom_raw" placeholder="Product UOM" readonly />
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                                    <div class="invoice_col_txt with_cntr_jstfy">
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button tabindex="1" id="cancelInventoryForProductRecipe" class="invoice_frm_btn btn btn-sm btn-info hide" data-method="cancel" onclick="addToCartForProductRecipe(this)" type="button">
                                                                <i class="fa fa-times"></i> Cancel
                                                            </button>
                                                        </div>
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button tabindex="1" id="addInventoryForProductRecipe" class="invoice_frm_btn btn btn-sm btn-info" data-method="create" onclick="addToCartForProductRecipe(this)" type="button">
                                                                <i class="fa fa-plus"></i> Add
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->
                                            <div class="pro_tbl_con for_voucher_tbl col-lg-12"><!-- product table container start -->
                                                <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                                    <table class="table table-bordered table-sm" id="category_dynamic_table">
                                                        <thead>
                                                        <tr>
                                                            <th tabindex="-1" class="tbl_srl_4"> Sr.</th>
                                                            <th tabindex="-1" class="tbl_srl_9"> Code</th>
                                                            <th tabindex="-1" class="tbl_txt_20"> Title</th>
                                                            <th tabindex="-1" class="tbl_txt_42"> Product Remarks</th>
                                                            <th tabindex="-1" class="tbl_srl_12"> Quantity </th>
                                                            <th tabindex="-1" class="tbl_srl_12"> UOM </th>

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
                                                                        <input tabindex="1" tabindex="-1" type="text" name="ttlQuantityForProductRecipe" class="inputs_up text-right form-control" id="ttlQuantityForProductRecipe" placeholder="0.00"
                                                                                data-rule-required="true" data-msg-required="Please Create Minimum One Inventory" readonly />
                                                                    </div><!-- invoice column input end -->
                                                                </div><!-- invoice column box end -->
                                                            </td>
                                                        </tr>
                                                        </tfoot>

                                                    </table>
                                                </div><!-- product table box end -->
                                            </div><!-- product table container end -->
                                        </div><!-- invoice row end -->

                                    </div><!-- invoice content end -->
                                </div><!-- invoice scroll box end -->


                            </div><!-- invoice box end -->
                        </div><!-- invoice container end -->
                    </section>
                    <!-- Step 2 -->
            {{--<h5>Expense</h5>--}}
            {{--<section>--}}
            {{--    <div class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->--}}
            {{--        <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->--}}

            {{--            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->--}}
            {{--                <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->--}}

            {{--                    <div class="invoice_row"><!-- invoice row start -->--}}

            {{--<div class="invoice_col basis_col_12"><!-- invoice column start -->--}}
            {{--    <div class="invoice_col_bx"><!-- invoice column box start -->--}}
            {{--        <div class="required invoice_col_ttl"><!-- invoice column title start -->--}}
            {{--            <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"--}}
            {{--               data-placement="bottom" data-html="true"--}}
            {{--               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">--}}
            {{--                <i class="fa fa-info-circle"></i>--}}
            {{--            </a>--}}
            {{--            Account Code--}}
            {{--        </div><!-- invoice column title end -->--}}
            {{--        <div class="invoice_col_input"><!-- invoice column input start -->--}}
            {{--            <div class="invoice_col_short"><!-- invoice column short start -->--}}
            {{--                                        <a tabindex="-1" href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
            {{--                                            <i class="fa fa-plus"></i>--}}
            {{--                                        </a>--}}
            {{--                                        <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
            {{--                                            <i class="fa fa-refresh"></i>--}}
            {{--                                        </a>--}}
            {{--                                    </div><!-- invoice column short end -->--}}
            {{--                                    <select tabindex="1" id="exp_code" class="inputs_up form-control" onchange="codeTitleChangeMethod(this, 'exp_title')">--}}
            {{--                                        <option value="" disabled selected>---Select Expense Account Code---</option>--}}
            {{--                                        @foreach($expense_accounts as $expense_account)--}}
            {{--                                            <option tabindex="1" value="{{$expense_account->account_uid}}">--}}
            {{--                                                {{$expense_account->account_uid}}--}}
            {{--                                            </option>--}}
            {{--                                        @endforeach--}}
            {{--                                    </select>--}}
            {{--                                </div><!-- invoice column input end -->--}}
            {{--                            </div><!-- invoice column box end -->--}}
            {{--                        </div><!-- invoice column end -->--}}

            {{--                        <div class="invoice_col basis_col_22"><!-- invoice column start -->--}}
            {{--                            <div class="invoice_col_bx"><!-- invoice column box start -->--}}
            {{--                                <div class="required invoice_col_ttl"><!-- invoice column title start -->--}}
            {{--                                    <a tabindex="1" data-container="body" data-toggle="popover" data-trigger="hover"--}}
            {{--                                       data-placement="bottom" data-html="true"--}}
            {{--                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">--}}
            {{--                                        <i class="fa fa-info-circle"></i>--}}
            {{--                                    </a>--}}
            {{--                                    Account Title--}}
            {{--                                </div><!-- invoice column title end -->--}}
            {{--                                <div class="invoice_col_input"><!-- invoice column input start -->--}}

            {{--                                    <div class="invoice_col_short"><!-- invoice column short start -->--}}
            {{--                                        <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
            {{--                                            <i class="fa fa-plus"></i>--}}
            {{--                                        </a>--}}
            {{--                                        <a id="refresh_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
            {{--                                            <i class="fa fa-refresh"></i>--}}
            {{--                                        </a>--}}
            {{--                                    </div><!-- invoice column short end -->--}}
            {{--                                    <select tabindex="-1" id="exp_title" class="inputs_up form-control" onchange="codeTitleChangeMethod(this, 'exp_code')">--}}
            {{--                                        <option value="" disabled selected>---Select Expense Account Title---</option>--}}
            {{--                                        @foreach($expense_accounts as $expense_account)--}}
            {{--                                            <option value="{{$expense_account->account_uid}}">--}}
            {{--                                                {{$expense_account->account_name}}--}}
            {{--                                            </option>--}}
            {{--                                        @endforeach--}}
            {{--                                    </select>--}}
            {{--                                </div><!-- invoice column input end -->--}}
            {{--                            </div><!-- invoice column box end -->--}}
            {{--                        </div><!-- invoice column end -->--}}

            {{--                        <div class="invoice_col basis_col_22"><!-- invoice column start -->--}}
            {{--                            <div class="invoice_col_bx"><!-- invoice column box start -->--}}
            {{--                                <div class=" invoice_col_ttl"><!-- invoice column title start -->--}}
            {{--                                    <a tabindex="1" data-container="body" data-toggle="popover" data-trigger="hover"--}}
            {{--                                       data-placement="bottom" data-html="true"--}}
            {{--                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>--}}
            {{--                                <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>--}}
            {{--                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>--}}
            {{--                                <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">--}}
            {{--                                        <i class="fa fa-info-circle"></i>--}}
            {{--                                    </a>--}}
            {{--                                    Transaction Remarks--}}
            {{--                                </div><!-- invoice column title end -->--}}
            {{--                                <div class="invoice_col_input"><!-- invoice column input start -->--}}
            {{--                                    <input tabindex="1" type="text" id="exp_remarks" class="inputs_up form-control" placeholder="Remarks">--}}
            {{--                                </div><!-- invoice column input end -->--}}
            {{--                            </div><!-- invoice column box end -->--}}
            {{--                        </div><!-- invoice column end -->--}}

            {{--                        <div class="invoice_col basis_col_11"><!-- invoice column start -->--}}
            {{--                            <div class="invoice_col_bx"><!-- invoice column box start -->--}}
            {{--                                <div class="required invoice_col_ttl"><!-- invoice column title start -->--}}
            {{--                                    <a tabindex="1" data-container="body" data-toggle="popover" data-trigger="hover"--}}
            {{--                                       data-placement="bottom" data-html="true"--}}
            {{--                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">--}}
            {{--                                        <i class="fa fa-info-circle"></i>--}}
            {{--                                    </a>--}}
            {{--                                    Amount--}}
            {{--                                </div><!-- invoice column title end -->--}}
            {{--                                <div class="invoice_col_input"><!-- invoice column input start -->--}}
            {{--                                    <input tabindex="1" type="text" id="exp_amount" class="inputs_up text-right form-control" placeholder="Amount" min="1" onkeypress="return allow_only_number_and_decimals(this,event);" />--}}
            {{--                                </div><!-- invoice column input end -->--}}
            {{--                            </div><!-- invoice column box end -->--}}
            {{--                        </div><!-- invoice column end -->--}}

            {{--                        <div class="invoice_col basis_col_22"><!-- invoice column start -->--}}
            {{--                            <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->--}}
            {{--                                <div class="invoice_col_txt with_cntr_jstfy">--}}
            {{--                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">--}}
            {{--                                        <button tabindex="1" name="addInventoryForExpense" id="addInventoryForExpense" class="invoice_frm_btn" type="button" data-method="create" onclick="addToCartForExpense(this)">--}}
            {{--                                            <i class="fa fa-plus"></i> Add--}}
            {{--                                        </button>--}}
            {{--                                    </div>--}}
            {{--                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">--}}
            {{--                                        <button tabindex="1" name="cancelInventoryForExpense" id="cancelInventoryForExpense" class="invoice_frm_btn hide" type="button" data-method="cancel" onclick="addToCartForExpense(this)">--}}
            {{--                                            <i class="fa fa-times"></i> Cancel--}}
            {{--                                        </button>--}}
            {{--                                    </div>--}}
            {{--                                </div>--}}
            {{--                            </div><!-- invoice column box end -->--}}
            {{--                        </div><!-- invoice column end -->--}}

            {{--                    </div><!-- invoice row end -->--}}

            {{--                    <div class="invoice_row"><!-- invoice row start -->--}}

            {{--                        <div class="invoice_col basis_col_100"><!-- invoice column start -->--}}
            {{--                            <div class="invoice_row"><!-- invoice row start -->--}}

            {{--                                <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->--}}
            {{--                                    <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->--}}
            {{--                                        <div class="pro_tbl_bx"><!-- product table box start -->--}}
            {{--                                            <table class="table gnrl-mrgn-pdng" id="category_dynamic_table">--}}
            {{--                                                <thead>--}}
            {{--                                                <tr>--}}
            {{--                                                    <th class="tbl_srl_4"> Sr. </th>--}}
            {{--                                                    <th class="tbl_srl_9"> Code </th>--}}
            {{--                                                    <th class="tbl_txt_20"> Title </th>--}}
            {{--                                                    <th class="tbl_txt_54"> Transaction Remarks </th>--}}
            {{--                                                    <th class="tbl_srl_12"> Amount </th>--}}
            {{--                                                </tr>--}}
            {{--                                                </thead>--}}

            {{--                                                <tbody id="listForExpense">--}}
            {{--                                                <tr>--}}
            {{--                                                    <td tabindex="-1" colspan="10" align="center">--}}
            {{--                                                        No Account Added--}}
            {{--                                                    </td>--}}
            {{--                                                </tr>--}}
            {{--                                                </tbody>--}}

            {{--                                                <tfoot>--}}
            {{--                                                <tr>--}}
            {{--                                                    <th tabi ndex="-1"colspan="3" class="text-right">--}}
            {{--                                                        Total Amount--}}
            {{--                                                    </th>--}}
            {{--                                                    <td class="tbl_srl_12">--}}
            {{--                                                        <div class="invoice_col_txt"><!-- invoice column box start -->--}}
            {{--                                                            <div class="invoice_col_input"><!-- invoice column input start -->--}}
            {{--                                                                <input type="text" name="ttlAmountForExpense" id="ttlAmountForExpense" class="inputs_up text-right form-control required" placeholder="0.00" readonly data-rule-required="true" data-msg-required="Please Create Minimum One Inventory" />--}}
            {{--                                                            </div><!-- invoice column input end -->--}}
            {{--                                                        </div><!-- invoice column box end -->--}}
            {{--                                                    </td>--}}
            {{--                                                </tr>--}}
            {{--                                                </tfoot>--}}

            {{--                                            </table>--}}
            {{--                                        </div><!-- product table box end -->--}}
            {{--                                    </div><!-- product table container end -->--}}
            {{--                                </div><!-- invoice column end -->--}}


            {{--                            </div><!-- invoice row end -->--}}
            {{--                        </div><!-- invoice column end -->--}}

            {{--                    </div><!-- invoice row end -->--}}


            {{--                </div><!-- invoice content end -->--}}
            {{--            </div><!-- invoice scroll box end -->--}}

            {{--        </div><!-- invoice box end -->--}}
            {{--    </div><!-- invoice container end -->--}}
            {{--</section>--}}
                    <!-- Step 3 -->
                    <h5>Finished Goods</h5>
                    <section>
                        <div class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                        <h5 class="mb-2"> Primary Finished Goods </h5>

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.cash_account.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Code
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <!-- call add or refresh button component -->
                                                        <x-add-refresh-button href="{{ route('add_product') }}" id="refresh_product_code"/>
                                                        <select name="primary_limited_product_code" class="inputs_up form-control required" id="primary_limited_product_code"
                        {{-- data-rule-required="true" data-msg-required="Please Enter Product Code" --}}
                                                                onchange="codeTitleChangeMethod(this, 'primary_limited_product_title', 'pro_uom_primary')" data-rule-required="true"
                                                                data-msg-required="Please Enter product Code">
                                                            <option value="" disabled selected>---Select Product Code--- Code</option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_23"><!-- invoice column start -->
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

                                                        <!-- call add or refresh button component -->
                                                        <x-add-refresh-button href="{{ route('add_product') }}" id="refresh_product_name"/>
                                                        <select name="primary_limited_product_title" class="inputs_up form-control required" id="primary_limited_product_title"
                                                                data-rule-required="true" data-msg-required="Please Enter Product Name"
                                                                onchange="codeTitleChangeMethod(this, 'primary_limited_product_code', 'pro_uom_primary')">
                                                            <option value="" disabled selected>---Select Product Title---</option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_11"><!-- invoice column start -->
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
                                                        <input type="text" name="primary_limited_product_quantity" class="inputs_up text-right form-control required"
                                                                id="primary_limited_product_quantity" placeholder="Product Quantity" min="1" onkeypress="return allow_only_number_and_decimals
                                                                (this,event);" data-rule-required="true" data-msg-required="Please Enter Product QTY" />
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
                                                        <input type="text" class="inputs_up form-control" id="pro_uom_primary" name="pro_uom_primary" placeholder="Product UOM" readonly />
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <h5 class="mb-2 mt-2"> Secondary Finished Goods </h5>

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
                                                        <!-- call add or refresh button component -->
                                                        <x-add-refresh-button href="{{ route('add_product') }}" id="refresh_product_code"/>
                                                        <select id="goods_code" class="inputs_up form-control" onchange="codeTitleChangeMethod(this, 'goods_title', 'pro_uom_secondary')">
                                                            <option value="" disabled selected>---Select Product Code---</option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Title
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <!-- call add or refresh button component -->
                                                        <x-add-refresh-button href="{{ route('add_product') }}" id="refresh_product_name"/>

                                                        <select id="goods_title" class="inputs_up form-control" onchange="codeTitleChangeMethod(this, 'goods_code', 'pro_uom_secondary')">
                                                            <option value="" disabled selected>---Select Product Title---</option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_20"><!-- invoice column start -->
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

                                            <div class="invoice_col basis_col_11"><!-- invoice column start -->
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
                                                        <input type="text" id="goods_quantity" class="inputs_up text-right form-control" placeholder="Product Quantity" min="1" onkeypress="return allow_only_number_and_decimals(this,event);" />
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
                                                        <input type="text" class="inputs_up form-control" id="pro_uom_secondary" placeholder="Product UOM" readonly />
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                                    <div class="invoice_col_txt with_cntr_jstfy">
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button id="addInventoryForFinishedGoods" class="invoice_frm_btn" type="button" data-method="create" onclick="addToCartForFinishedGoods(this);">
                                                                <i class="fa fa-plus"></i> Add
                                                            </button>
                                                        </div>
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button id="cancelInventoryForFinishedGoods" class="invoice_frm_btn hide" type="button" data-method="cancel" onclick="addToCartForFinishedGoods(this);">
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
                                                                        <th class="tbl_srl_9"> Code</th>
                                                                        <th class="tbl_txt_20"> Title</th>
                                                                        <th class="tbl_txt_42"> Product Remarks</th>
                                                                        <th class="tbl_srl_12"> Quantity </th>
                                                                        <th class="tbl_srl_12"> UOM </th>
                                                                                            {{--                                                                            <th class="tbl_srl_6"> Actions </th>--}}
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
                                                                                    <input type="text" name="ttlQuantityForFinishedGoods" id="ttlQuantityForFinishedGoods" class="inputs_up text-right form-control required" placeholder="0.00" readonly
                                                                                            data-rule-required="true" data-msg-required="Please Create Minimum One Inventory"
                                                                                            data-rule-required="true" data-msg-required="Add"
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

                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
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

                    <input type="hidden" name="cartDataForProductRecipe" id="cartDataForProductRecipe" />
                                            {{--                        <input type="hidden" name="cartDataForExpense" id="cartDataForExpense" />--}}
                    <input type="hidden" name="cartDataForFinishedGoods" id="cartDataForFinishedGoods" />


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
            let recipe_name = document.getElementById("recipe_name"),
                ttlQuantityForProductRecipe = document.getElementById("ttlQuantityForProductRecipe"),
                primary_limited_product_code = document.getElementById("primary_limited_product_code"),
                primary_limited_product_title = document.getElementById("primary_limited_product_title"),
                ttlQuantityForFinishedGoods = document.getElementById("ttlQuantityForFinishedGoods"),
                validateInputIdArray = [
                    recipe_name.id,
                    ttlQuantityForProductRecipe.id,
                    primary_limited_product_code.id,
                    primary_limited_product_title.id,
                    ttlQuantityForFinishedGoods.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
        function checkFormONSave() {
            let recipe_name = document.getElementById("recipe_name"),
                ttlQuantityForProductRecipe = document.getElementById("ttlQuantityForProductRecipe"),
                primary_limited_product_code = document.getElementById("primary_limited_product_code"),
                primary_limited_product_title = document.getElementById("primary_limited_product_title"),
                ttlQuantityForFinishedGoods = document.getElementById("ttlQuantityForFinishedGoods"),
                validateInputIdArray = [
                    recipe_name.id,
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
                remarks = document.getElementById("pro_remarks"),
                quantity = document.getElementById("quantity"),
                uom = document.getElementById("pro_uom_raw"),
                tblListId = 'listForProductRecipe',
                cartDataArrayId = 'cartDataForProductRecipe',
                ttlQuantity = 'ttlQuantityForProductRecipe',
                addBtnId = 'addInventoryForProductRecipe',
                cancelBtnId = 'cancelInventoryForProductRecipe',
                btnCallMethodName = 'addToCartForProductRecipe';

            idForShowAndGetData = {
                tblListId: tblListId,
                cartDataArrayId: cartDataArrayId,
                ttlQuantity: ttlQuantity,
                addBtnId: addBtnId,
                cancelBtnId: cancelBtnId,
                btnCallMethodName: btnCallMethodName,
                codeId: code.id,
                titleId: title.id,
                remarksId: remarks.id,
                quantityId: quantity.id,
                uom: uom.id,
            };
            validateInputIdArray = [
                code.id,
                title.id,
                quantity.id,
                uom.id,
            ];
            inputValuesArray = {
                code: code.value,
                title: title.options[title.selectedIndex].text,
                remarks: remarks.value,
                quantity: quantity.value,
                uom: uom.value,
            };
            tableColumnsClasseArray = {
                srClass: 'tbl_srl_4',
                codeClass: 'tbl_srl_9',
                titleClass: 'text-left tbl_txt_20',
                remarksClass: 'text-left tbl_txt_42',
                quantityClass: 'text-right tbl_srl_12',
                uomClass: 'tbl_srl_12',
                actionClass: 'tbl_srl_6',
            };
            // alert();
            let displayText = new displayValuesInTable(inputValuesArray, idForShowAndGetData);
            displayText.onlyQuantity(e, tableColumnsClasseArray, validateInputIdArray);
            inputValuesArray = [];

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
                remarks = document.getElementById("goods_remarks"),
                quantity = document.getElementById("goods_quantity"),
                uom = document.getElementById("pro_uom_secondary"),
                tblListId = 'listForFinishedGoods',
                cartDataArrayId = 'cartDataForFinishedGoods',
                ttlQuantity = 'ttlQuantityForFinishedGoods',
                addBtnId = 'addInventoryForFinishedGoods',
                cancelBtnId = 'cancelInventoryForFinishedGoods',
                btnCallMethodName = 'addToCartForFinishedGoods';

            idForShowAndGetData = {
                tblListId: tblListId,
                cartDataArrayId: cartDataArrayId,
                ttlQuantity: ttlQuantity,
                addBtnId: addBtnId,
                cancelBtnId: cancelBtnId,
                btnCallMethodName: btnCallMethodName,
                codeId: code.id,
                titleId: title.id,
                remarksId: remarks.id,
                quantityId: quantity.id,
                uom: uom.id,
            };
            validateInputIdArray = [
                code.id,
                title.id,
                quantity.id,
                uom.id,
            ];
            inputValuesArray = {
                code: code.value,
                title: title.options[title.selectedIndex].text,
                remarks: remarks.value,
                quantity: quantity.value,
                uom: uom.value,
            };
            tableColumnsClasseArray = {
                srClass: 'tbl_srl_4',
                codeClass: 'tbl_srl_9',
                titleClass: 'text-left tbl_txt_20',
                remarksClass: 'text-left tbl_txt_42',
                quantityClass: 'text-right tbl_srl_12',
                uomClass: 'tbl_srl_12',
                actionClass: 'tbl_srl_6',

            };

            let displayText = new displayValuesInTable(inputValuesArray, idForShowAndGetData);
            displayText.onlyQuantity(e, tableColumnsClasseArray, validateInputIdArray);
            inputValuesArray = [];

        }

        $(document).on('keyup keypress', 'form input', function(e) {
            if(e.which == 13) {
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
                if (currentIndex > newIndex)
                {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex)
                {
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
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                alert("Submitted!");
            }
        });

        function check_page_one(){

            var abc = $("#recipe_name").val();

            // var xyz = $("#ttlQuantityForProductRecipe").text();
            var xyz = $("#ttlQuantityForProductRecipe").val();


            if (abc == ""){
                // alert(abc);
                $("#recipe_name").css("background-color", "red");
                $("#recipe_name").css("color", "white");
                $("#recipe_name").focus();
                return false;
            } else if (xyz == "" || xyz == "0"){
                // alert(xyz);
                $("#recipe_name").css("background-color", "white");
                $("#recipe_name").css("color", "black");
                $("#ttlQuantityForProductRecipe").css("background-color", "red");
                $("#ttlQuantityForProductRecipe").css("color", "white");
                $("#ttlQuantityForProductRecipe").focus();
                return false;
            } else {
                $("#ttlQuantityForProductRecipe").css("background-color", "white");
                $("#ttlQuantityForProductRecipe").css("color", "black");
                $("#recipe_name").css("background-color", "white");
                $("#recipe_name").css("color", "black");
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
            $("#exp_code").select2();
            $("#exp_title").select2();
            $("#primary_limited_product_code").select2();
            $("#primary_limited_product_title").select2();




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



        });


        function codeTitleChangeMethod(e, id, uomId){
            // let code = e.value,
            let code = e.options[e.selectedIndex].getAttribute('data-code'),
                proUOM = e.options[e.selectedIndex].getAttribute('data-uom');

            $("#"+uomId).val(proUOM);
            $("#"+id).select2("destroy");
            $("#"+id+ " option[data-code='" + code + "']").prop('selected', true);
            $("#"+id).select2();
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


@endsection
