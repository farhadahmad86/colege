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


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div id="main_bg" class="pd-20 border-radius-4 box-shadow mb-30 form_manage" style="background: #C4D3F5">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text"> Product Batch Recipe </h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button"
                               href="{{ route('product_batch_recipe_list') }}" role="button">
                                <i class="fa fa-list"></i> Recipes
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div class="wizard-content">
                    <form class="tab-wizard wizard-circle wizard" id="f1" action="{{ route('submit_product_batch_recipe') }}"
                          method="post"
                        {{--                          onsubmit="return checkForm()"--}}
                    >
                        @csrf
                        <h5>Raw Goods</h5>
                        <section>
                            <div class="gnrl-mrgn-pdng for_voucher"><!-- invoice container start -->
                                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate">
                                    <!-- invoice box start -->

                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                        <!-- invoice scroll box start -->
                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                            <!-- invoice content start -->

                                            <div class="invoice_row"><!-- invoice row start -->
                                                <div class="invoice_col basis_col_24"><!-- invoice column start -->

                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Recipe Title
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="recipe_title_View" style="font-size: 12px">
                                                                '
                                                            </h5>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_24" hidden><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.cash_account.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Recipe
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input tabindex=0 type="text" name="recipe_title"
                                                                   class="inputs_up form-control required"
                                                                   id="recipe_title" placeholder="Recipe Title"
                                                                   data-rule-required="true"
                                                                   data-msg-required="Please Enter Recipe Title"
                                                                   readonly>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_24"><!-- invoice column start -->

                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Order List
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="order_title_View" style="font-size: 12px">
                                                                '
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_24" hidden>
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Order List
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->

                                                            <input tabindex="0" type="hidden" name="order_id"
                                                                   class="inputs_up form-control" id="order_id"
                                                                   data-rule-required="true"
                                                                   data-msg-required="Please
                                                                    Enter Order Title" placeholder="Order Title"
                                                                   readonly>
                                                            <input tabindex="0" type="text" name="order_title"
                                                                   class="inputs_up form-control" id="order_title"
                                                                   data-rule-required="true"
                                                                   data-msg-required="Please
                                                                    Enter Order Title" placeholder="Order Title"
                                                                   readonly>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_16"><!-- invoice column start -->
                                                    <input type="hidden" name="total_length" id="total_length">
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Total Length
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="totalQtyView">
                                                                0
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_16"><!-- invoice column start -->
                                                    <input type="hidden" name="total_height" id="total_height">
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Total Height
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="consumeTotalQtyView">
                                                                0
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_16"><!-- invoice column start -->
                                                    <input type="hidden" name="total_depth" id="total_depth">
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <label class="invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Total Depth
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="remainingTotalQtyView">
                                                                0
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                    <span style="color: red" id="cal_remain_qty"></span>
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->

                                            <div class="invoice_row"><!-- invoice row start -->
                                                <div class="invoice_col basis_col_32">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Select Batch
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <select tabindex="1" name="batch_name" id="batch_name"
                                                                    {{--                                                                    data-fetch-url="{{ route('api.companies.options') }}"--}}
                                                                    class="inputs_up form-control auto-select company_dropdown"
                                                                    tabindex="0" data-rule-required="true"
                                                                    data-msg-required="Please
                                                                    Enter Batch Name"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Batch
                                                                </option>
                                                                @foreach ($batches as $batch)
                                                                    <option
                                                                        value="{{ $batch->bat_id }}"
                                                                        data-batch-id="{{ $batch->bat_id }}">{{ $batch->bat_name }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_32"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.cash_account.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Recipe Name
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input tabindex=1 type="text" name="recipe_name"
                                                                   class="inputs_up form-control required"
                                                                   id="recipe_name" placeholder="Recipe Name"
                                                                   data-rule-required="true"
                                                                   data-msg-required="Please Enter Recipe Name">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_34 pr-1"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                        <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Recipe Remarks
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input tabindex="1" type="text" name="recipe_remarks"
                                                                   class="inputs_up form-control" id="recipe_remarks"
                                                                   placeholder="Recipe Remarks">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->

                                            <div class="invoice_row" hidden><!-- invoice row start -->

                                                <div class="invoice_col basis_col_16 ml-0"><!-- invoice column start -->
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
                                                                {{--                                                                <a href="{{ route('add_product') }}" target="_blank"--}}
                                                                {{--                                                                   class="col_short_btn" data-container="body"--}}
                                                                {{--                                                                   data-toggle="popover" data-trigger="hover"--}}
                                                                {{--                                                                   data-placement="bottom" data-html="true"--}}
                                                                {{--                                                                   data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
                                                                {{--                                                                    <i class="fa fa-plus"></i>--}}
                                                                {{--                                                                </a>--}}
                                                                {{--                                                                <a id="refresh_account_code" class="col_short_btn"--}}
                                                                {{--                                                                   data-container="body" data-toggle="popover"--}}
                                                                {{--                                                                   data-trigger="hover" data-placement="bottom"--}}
                                                                {{--                                                                   data-html="true"--}}
                                                                {{--                                                                   data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                                                                {{--                                                                    <i class="fa fa-refresh"></i>--}}
                                                                {{--                                                                </a>--}}
                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="1" class="inputs_up form-control"
                                                                    id="pro_code"
                                                                    onchange="codeTitleChangeMethod(this, 'pro_title', 'pro_uom_raw', 'pro_scale_size')">
                                                                <option value="" disabled selected> ---Select Code---
                                                                </option>
                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_16 ml-0"><!-- invoice column start -->
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
                                                                {{--                                                                <a href="{{ route('add_product') }}" target="_blank"--}}
                                                                {{--                                                                   class="col_short_btn" data-container="body"--}}
                                                                {{--                                                                   data-toggle="popover" data-trigger="hover"--}}
                                                                {{--                                                                   data-placement="bottom" data-html="true"--}}
                                                                {{--                                                                   data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
                                                                {{--                                                                    <i class="fa fa-plus"></i>--}}
                                                                {{--                                                                </a>--}}
                                                                {{--                                                                <a id="refresh_account_name" class="col_short_btn"--}}
                                                                {{--                                                                   data-container="body" data-toggle="popover"--}}
                                                                {{--                                                                   data-trigger="hover" data-placement="bottom"--}}
                                                                {{--                                                                   data-html="true"--}}
                                                                {{--                                                                   data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                                                                {{--                                                                    <i class="fa fa-refresh"></i>--}}
                                                                {{--                                                                </a>--}}
                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="1" class="inputs_up form-control"
                                                                    id="pro_title"
                                                                    onchange="codeTitleChangeMethod(this, 'pro_code', 'pro_uom_raw', 'pro_scale_size')">
                                                                <option value="" disabled selected> ---Select
                                                                    Product---
                                                                </option>
                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_16 ml-0"><!-- invoice column start -->
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

                                                <div class="invoice_col basis_col_16 ml-0"><!-- invoice column start -->
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
                                                                   onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_16 ml-0"><!-- invoice column start -->
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
                                                                   class="inputs_up text-center form-control"
                                                                   id="pro_uom_raw" placeholder="Product UOM" readonly/>
                                                            <input tabindex="1" type="hidden"
                                                                   class="inputs_up text-right form-control"
                                                                   id="pro_scale_size" placeholder="Product Scale Size" onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_16 ml-1"><!-- invoice column start -->
                                                    <div class="invoice_col_txt for_voucher_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="invoice_col_txt with_cntr_jstfy">
                                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                <button tabindex="1" id="addInventoryForProductRecipe"
                                                                        class="invoice_frm_btn" data-method="create"
                                                                        onclick="addToCartForProductRecipe(this)"
                                                                        type="button">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </button>
                                                            </div>
                                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                <button tabindex="1"
                                                                        id="cancelInventoryForProductRecipe"
                                                                        class="invoice_frm_btn hide"
                                                                        data-method="cancel"
                                                                        onclick="addToCartForProductRecipe(this)"
                                                                        type="button">
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

                                                        <div class="invoice_col basis_col_100 gnrl-mrgn-pdng">
                                                            <!-- invoice column start -->
                                                            <div class="pro_tbl_con for_voucher_tbl">
                                                                <!-- product table container start -->
                                                                <div class="pro_tbl_bx"><!-- product table box start -->
                                                                    <table class="table gnrl-mrgn-pdng"
                                                                           id="category_dynamic_table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th tabindex="-1"
                                                                                class="text-center tbl_srl_4"> Sr.
                                                                            </th>
                                                                            <th tabindex="-1"
                                                                                class="text-center tbl_srl_9"> Code
                                                                            </th>
                                                                            <th tabindex="-1"
                                                                                class="text-center tbl_txt_20"> Title
                                                                            </th>
                                                                            {{--                                                                            <th tabindex="-1"--}}
                                                                            {{--                                                                                class="text-center tbl_txt_42"> Product--}}
                                                                            {{--                                                                                Remarks--}}
                                                                            {{--                                                                            </th>--}}

                                                                            <th tabindex="-1"
                                                                                class="text-center tbl_srl_12"> Quantity
                                                                            </th>
                                                                            <th tabindex="-1"
                                                                                class="text-center tbl_srl_12"> UOM
                                                                            </th>
                                                                            {{--                                                                            <th tabindex="-1"--}}
                                                                            {{--                                                                                class="text-center tbl_srl_6"> Actions--}}
                                                                            {{--                                                                            </th>--}}
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody id="listForProductRecipe">
                                                                        <tr>
                                                                            <td tabindex="-1" colspan="10"
                                                                                align="center">
                                                                                No Account Added
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>

                                                                        <tfoot>
                                                                        <tr>
                                                                            <th tabindex="-1" colspan="4"
                                                                                class="text-right">
                                                                                Total Quantity
                                                                            </th>
                                                                            <td class="text-center tbl_srl_12">
                                                                                <div class="invoice_col_txt">
                                                                                    <!-- invoice column box start -->
                                                                                    <div class="invoice_col_input">
                                                                                        <!-- invoice column input start -->
                                                                                        <input tabindex="1"
                                                                                               tabindex="-1" type="text"
                                                                                               name="ttlQuantityForProductRecipe"
                                                                                               class="inputs_up text-right form-control"
                                                                                               id="ttlQuantityForProductRecipe"
                                                                                               placeholder="0.00"
                                                                                               data-rule-required="true"
                                                                                               data-msg-required="Please Create Minimum One Inventory"
                                                                                               readonly/>
                                                                                    </div>
                                                                                    <!-- invoice column input end -->
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
                        <!-- Step 2 -->
                        {{--                        <h5>Expense</h5>--}}
                        {{--                        <section>--}}
                        {{--                            <div class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->--}}
                        {{--                                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->--}}

                        {{--                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->--}}
                        {{--                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->--}}

                        {{--                                            <div class="invoice_row"><!-- invoice row start -->--}}

                        {{--                                                <div class="invoice_col basis_col_12"><!-- invoice column start -->--}}
                        {{--                                                    <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                        {{--                                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->--}}
                        {{--                                                            <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                                                               data-placement="bottom" data-html="true"--}}
                        {{--                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">--}}
                        {{--                                                                <i class="fa fa-info-circle"></i>--}}
                        {{--                                                            </a>--}}
                        {{--                                                            Account Code--}}
                        {{--                                                        </div><!-- invoice column title end -->--}}
                        {{--                                                        <div class="invoice_col_input"><!-- invoice column input start -->--}}
                        {{--                                                            <div class="invoice_col_short"><!-- invoice column short start -->--}}
                        {{--                                                                <a tabindex="-1" href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
                        {{--                                                                    <i class="fa fa-plus"></i>--}}
                        {{--                                                                </a>--}}
                        {{--                                                                <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                        {{--                                                                    <i class="fa fa-refresh"></i>--}}
                        {{--                                                                </a>--}}
                        {{--                                                            </div><!-- invoice column short end -->--}}
                        {{--                                                            <select tabindex="1" id="exp_code" class="inputs_up form-control" onchange="codeTitleChangeMethod(this, 'exp_title')">--}}
                        {{--                                                                <option value="" disabled selected>---Select Expense Account Code---</option>--}}
                        {{--                                                                @foreach($expense_accounts as $expense_account)--}}
                        {{--                                                                    <option tabindex="1" value="{{$expense_account->account_uid}}">--}}
                        {{--                                                                        {{$expense_account->account_uid}}--}}
                        {{--                                                                    </option>--}}
                        {{--                                                                @endforeach--}}
                        {{--                                                            </select>--}}
                        {{--                                                        </div><!-- invoice column input end -->--}}
                        {{--                                                    </div><!-- invoice column box end -->--}}
                        {{--                                                </div><!-- invoice column end -->--}}

                        {{--                                                <div class="invoice_col basis_col_22"><!-- invoice column start -->--}}
                        {{--                                                    <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                        {{--                                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->--}}
                        {{--                                                            <a tabindex="1" data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                                                               data-placement="bottom" data-html="true"--}}
                        {{--                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">--}}
                        {{--                                                                <i class="fa fa-info-circle"></i>--}}
                        {{--                                                            </a>--}}
                        {{--                                                            Account Title--}}
                        {{--                                                        </div><!-- invoice column title end -->--}}
                        {{--                                                        <div class="invoice_col_input"><!-- invoice column input start -->--}}

                        {{--                                                            <div class="invoice_col_short"><!-- invoice column short start -->--}}
                        {{--                                                                <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
                        {{--                                                                    <i class="fa fa-plus"></i>--}}
                        {{--                                                                </a>--}}
                        {{--                                                                <a id="refresh_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                        {{--                                                                    <i class="fa fa-refresh"></i>--}}
                        {{--                                                                </a>--}}
                        {{--                                                            </div><!-- invoice column short end -->--}}
                        {{--                                                            <select tabindex="-1" id="exp_title" class="inputs_up form-control" onchange="codeTitleChangeMethod(this, 'exp_code')">--}}
                        {{--                                                                <option value="" disabled selected>---Select Expense Account Title---</option>--}}
                        {{--                                                                @foreach($expense_accounts as $expense_account)--}}
                        {{--                                                                    <option value="{{$expense_account->account_uid}}">--}}
                        {{--                                                                        {{$expense_account->account_name}}--}}
                        {{--                                                                    </option>--}}
                        {{--                                                                @endforeach--}}
                        {{--                                                            </select>--}}
                        {{--                                                        </div><!-- invoice column input end -->--}}
                        {{--                                                    </div><!-- invoice column box end -->--}}
                        {{--                                                </div><!-- invoice column end -->--}}

                        {{--                                                <div class="invoice_col basis_col_22"><!-- invoice column start -->--}}
                        {{--                                                    <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                        {{--                                                        <div class=" invoice_col_ttl"><!-- invoice column title start -->--}}
                        {{--                                                            <a tabindex="1" data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                                                               data-placement="bottom" data-html="true"--}}
                        {{--                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>--}}
                        {{--                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>--}}
                        {{--                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>--}}
                        {{--                                                        <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">--}}
                        {{--                                                                <i class="fa fa-info-circle"></i>--}}
                        {{--                                                            </a>--}}
                        {{--                                                            Transaction Remarks--}}
                        {{--                                                        </div><!-- invoice column title end -->--}}
                        {{--                                                        <div class="invoice_col_input"><!-- invoice column input start -->--}}
                        {{--                                                            <input tabindex="1" type="text" id="exp_remarks" class="inputs_up form-control" placeholder="Remarks">--}}
                        {{--                                                        </div><!-- invoice column input end -->--}}
                        {{--                                                    </div><!-- invoice column box end -->--}}
                        {{--                                                </div><!-- invoice column end -->--}}

                        {{--                                                <div class="invoice_col basis_col_11"><!-- invoice column start -->--}}
                        {{--                                                    <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                        {{--                                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->--}}
                        {{--                                                            <a tabindex="1" data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                                                               data-placement="bottom" data-html="true"--}}
                        {{--                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">--}}
                        {{--                                                                <i class="fa fa-info-circle"></i>--}}
                        {{--                                                            </a>--}}
                        {{--                                                            Amount--}}
                        {{--                                                        </div><!-- invoice column title end -->--}}
                        {{--                                                        <div class="invoice_col_input"><!-- invoice column input start -->--}}
                        {{--                                                            <input tabindex="1" type="text" id="exp_amount" class="inputs_up text-right form-control" placeholder="Amount" min="1" onkeypress="return allow_only_number_and_decimals(this,event);" />--}}
                        {{--                                                        </div><!-- invoice column input end -->--}}
                        {{--                                                    </div><!-- invoice column box end -->--}}
                        {{--                                                </div><!-- invoice column end -->--}}

                        {{--                                                <div class="invoice_col basis_col_22"><!-- invoice column start -->--}}
                        {{--                                                    <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->--}}
                        {{--                                                        <div class="invoice_col_txt with_cntr_jstfy">--}}
                        {{--                                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">--}}
                        {{--                                                                <button tabindex="1" name="addInventoryForExpense" id="addInventoryForExpense" class="invoice_frm_btn" type="button" data-method="create" onclick="addToCartForExpense(this)">--}}
                        {{--                                                                    <i class="fa fa-plus"></i> Add--}}
                        {{--                                                                </button>--}}
                        {{--                                                            </div>--}}
                        {{--                                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">--}}
                        {{--                                                                <button tabindex="1" name="cancelInventoryForExpense" id="cancelInventoryForExpense" class="invoice_frm_btn hide" type="button" data-method="cancel" onclick="addToCartForExpense(this)">--}}
                        {{--                                                                    <i class="fa fa-times"></i> Cancel--}}
                        {{--                                                                </button>--}}
                        {{--                                                            </div>--}}
                        {{--                                                        </div>--}}
                        {{--                                                    </div><!-- invoice column box end -->--}}
                        {{--                                                </div><!-- invoice column end -->--}}

                        {{--                                            </div><!-- invoice row end -->--}}

                        {{--                                            <div class="invoice_row"><!-- invoice row start -->--}}

                        {{--                                                <div class="invoice_col basis_col_100"><!-- invoice column start -->--}}
                        {{--                                                    <div class="invoice_row"><!-- invoice row start -->--}}

                        {{--                                                        <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->--}}
                        {{--                                                            <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->--}}
                        {{--                                                                <div class="pro_tbl_bx"><!-- product table box start -->--}}
                        {{--                                                                    <table class="table gnrl-mrgn-pdng" id="category_dynamic_table">--}}
                        {{--                                                                        <thead>--}}
                        {{--                                                                        <tr>--}}
                        {{--                                                                            <th class="text-center tbl_srl_4"> Sr. </th>--}}
                        {{--                                                                            <th class="text-center tbl_srl_9"> Code </th>--}}
                        {{--                                                                            <th class="text-center tbl_txt_20"> Title </th>--}}
                        {{--                                                                            <th class="text-center tbl_txt_54"> Transaction Remarks </th>--}}
                        {{--                                                                            <th class="text-center tbl_srl_12"> Amount </th>--}}
                        {{--                                                                        </tr>--}}
                        {{--                                                                        </thead>--}}

                        {{--                                                                        <tbody id="listForExpense">--}}
                        {{--                                                                        <tr>--}}
                        {{--                                                                            <td tabindex="-1" colspan="10" align="center">--}}
                        {{--                                                                                No Account Added--}}
                        {{--                                                                            </td>--}}
                        {{--                                                                        </tr>--}}
                        {{--                                                                        </tbody>--}}

                        {{--                                                                        <tfoot>--}}
                        {{--                                                                        <tr>--}}
                        {{--                                                                            <th tabi ndex="-1"colspan="3" class="text-right">--}}
                        {{--                                                                                Total Amount--}}
                        {{--                                                                            </th>--}}
                        {{--                                                                            <td class="text-center tbl_srl_12">--}}
                        {{--                                                                                <div class="invoice_col_txt"><!-- invoice column box start -->--}}
                        {{--                                                                                    <div class="invoice_col_input"><!-- invoice column input start -->--}}
                        {{--                                                                                        <input type="text" name="ttlAmountForExpense" id="ttlAmountForExpense" class="inputs_up text-right form-control required" placeholder="0.00" readonly data-rule-required="true" data-msg-required="Please Create Minimum One Inventory" />--}}
                        {{--                                                                                    </div><!-- invoice column input end -->--}}
                        {{--                                                                                </div><!-- invoice column box end -->--}}
                        {{--                                                                            </td>--}}
                        {{--                                                                        </tr>--}}
                        {{--                                                                        </tfoot>--}}

                        {{--                                                                    </table>--}}
                        {{--                                                                </div><!-- product table box end -->--}}
                        {{--                                                            </div><!-- product table container end -->--}}
                        {{--                                                        </div><!-- invoice column end -->--}}


                        {{--                                                    </div><!-- invoice row end -->--}}
                        {{--                                                </div><!-- invoice column end -->--}}

                        {{--                                            </div><!-- invoice row end -->--}}


                        {{--                                        </div><!-- invoice content end -->--}}
                        {{--                                    </div><!-- invoice scroll box end -->--}}

                        {{--                                </div><!-- invoice box end -->--}}
                        {{--                            </div><!-- invoice container end -->--}}
                        {{--                        </section>--}}
                    <!-- Step 3 -->
                        <h5>Finished Goods</h5>
                        <section>
                            <div class="gnrl-mrgn-pdng for_voucher"><!-- invoice container start -->
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate">
                                    <!-- invoice box start -->

                                    <div class="gnrl-mrgn-pdng gnrl-blk">
                                        <!-- invoice scroll box start -->
                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                            <!-- invoice content start -->

                                            <h5 class="mb-2"> Primary Finished Goods </h5>

                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_24"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.cash_account.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Product Code
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="0" type="type" name="primary_limited_product_code"
                                                                   class="inputs_up form-control" id="primary_limited_product_code"
                                                                   data-rule-required="true"
                                                                   data-msg-required="Please
                                                                    Enter Finish Goods Code" placeholder="Finish Goods Code"
                                                                   readonly>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->


                                                <div class="invoice_col basis_col_24"><!-- invoice column start -->
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
                                                            <input tabindex="0" type="text" name="primary_limited_product_title"
                                                                   class="inputs_up form-control"
                                                                   id="primary_limited_product_title" data-rule-required="true"
                                                                   data-msg-required="Please
                                                                    Enter Finish Goods Title" placeholder="Finish Goods Title"
                                                                   readonly>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Qty
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input type="text" name="primary_limited_product_quantity"
                                                                   class="inputs_up text-right form-control required"
                                                                   id="primary_limited_product_quantity"
                                                                   placeholder="Product Quantity" min="1"
                                                                   onkeypress="return allow_only_number_and_decimals(this,event);" readonly/>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_6"><!-- invoice column start -->
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
                                                            <input type="text"
                                                                   class="inputs_up text-center form-control"
                                                                   id="pro_uom_primary" name="pro_uom_primary"
                                                                   placeholder="Product UOM" readonly/>
                                                            <input type="hidden" name="primary_limited_product_scale_size"
                                                                   class="inputs_up text-right form-control required"
                                                                   id="primary_limited_product_scale_size"
                                                                   placeholder="Scale Size"
                                                                   onkeypress="return allow_only_number_and_decimals(this,event);" readonly/>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->

                                            <h5 class="mb-2 mt-2"> Secondary Finished Goods </h5>

                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_16"><!-- invoice column start -->
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
                                                                {{--                                                                <a href="{{ route('add_product') }}" target="_blank"--}}
                                                                {{--                                                                   class="col_short_btn" data-container="body"--}}
                                                                {{--                                                                   data-toggle="popover" data-trigger="hover"--}}
                                                                {{--                                                                   data-placement="bottom" data-html="true"--}}
                                                                {{--                                                                   data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
                                                                {{--                                                                    <i class="fa fa-plus"></i>--}}
                                                                {{--                                                                </a>--}}
                                                                {{--                                                                <a id="refresh_account_code" class="col_short_btn"--}}
                                                                {{--                                                                   data-container="body" data-toggle="popover"--}}
                                                                {{--                                                                   data-trigger="hover" data-placement="bottom"--}}
                                                                {{--                                                                   data-html="true"--}}
                                                                {{--                                                                   data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                                                                {{--                                                                    <i class="fa fa-refresh"></i>--}}
                                                                {{--                                                                </a>--}}
                                                            </div><!-- invoice column short end -->
                                                            <select id="goods_code" class="inputs_up form-control"
                                                                    onchange="codeTitleChangeMethod(this, 'goods_title', 'pro_uom_secondary', 'pro_scale_size_secondary')">
                                                                <option value="" disabled selected>---Select Product
                                                                    Code---
                                                                </option>
                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_16"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Product Title
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->
                                                                {{--                                                                <a href="{{ route('add_product') }}" target="_blank"--}}
                                                                {{--                                                                   class="col_short_btn" data-container="body"--}}
                                                                {{--                                                                   data-toggle="popover" data-trigger="hover"--}}
                                                                {{--                                                                   data-placement="bottom" data-html="true"--}}
                                                                {{--                                                                   data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
                                                                {{--                                                                    <i class="fa fa-plus"></i>--}}
                                                                {{--                                                                </a>--}}
                                                                {{--                                                                <a id="refresh_account_name" class="col_short_btn"--}}
                                                                {{--                                                                   data-container="body" data-toggle="popover"--}}
                                                                {{--                                                                   data-trigger="hover" data-placement="bottom"--}}
                                                                {{--                                                                   data-html="true"--}}
                                                                {{--                                                                   data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                                                                {{--                                                                    <i class="fa fa-refresh"></i>--}}
                                                                {{--                                                                </a>--}}
                                                            </div><!-- invoice column short end -->
                                                            <select id="goods_title" class="inputs_up form-control"
                                                                    onchange="codeTitleChangeMethod(this, 'goods_code', 'pro_uom_secondary', 'pro_scale_size_secondary')">
                                                                <option value="" disabled selected>---Select Product
                                                                    Title---
                                                                </option>
                                                            </select>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_16"><!-- invoice column start -->
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
                                                            <input type="text" id="goods_remarks"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Product Remarks">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            <a data-container="body" data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Qty
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input type="text" id="goods_quantity"
                                                                   class="inputs_up text-right form-control"
                                                                   placeholder="Product Quantity" min="1"
                                                                   onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_6"><!-- invoice column start -->
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
                                                            <input type="text"
                                                                   class="inputs_up text-center form-control"
                                                                   id="pro_uom_secondary" placeholder="Product UOM"
                                                                   readonly/>
                                                            <input type="hidden"
                                                                   class="inputs_up text-center form-control"
                                                                   id="pro_scale_size_secondary" placeholder="Scale Size"
                                                                   readonly/>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                    <div class="invoice_col_txt for_voucher_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="invoice_col_txt with_cntr_jstfy">
                                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                <button id="addInventoryForFinishedGoods"
                                                                        class="invoice_frm_btn" type="button"
                                                                        data-method="create"
                                                                        onclick="addToCartForFinishedGoods(this);">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </button>
                                                            </div>
                                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                <button id="cancelInventoryForFinishedGoods"
                                                                        class="invoice_frm_btn hide" type="button"
                                                                        data-method="cancel"
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

                                                        <div class="invoice_col basis_col_100 gnrl-mrgn-pdng">
                                                            <!-- invoice column start -->
                                                            <div class="pro_tbl_con for_voucher_tbl">
                                                                <!-- product table container start -->
                                                                <div class="pro_tbl_bx"><!-- product table box start -->
                                                                    <table class="table gnrl-mrgn-pdng"
                                                                           id="category_dynamic_table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="text-center tbl_srl_4"> Sr.</th>
                                                                            <th class="text-center tbl_srl_9"> Code</th>
                                                                            <th class="text-center tbl_txt_20"> Title
                                                                            </th>
                                                                            <th class="text-center tbl_txt_42"> Product
                                                                                Remarks
                                                                            </th>
                                                                            <th class="text-center tbl_srl_12">
                                                                                Quantity
                                                                            </th>
                                                                            <th class="text-center tbl_srl_12"> UOM</th>
                                                                            <th tabindex="-1"
                                                                                class="text-center tbl_srl_6"> Actions
                                                                            </th>
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
                                                                            <td class="text-center tbl_srl_12">
                                                                                <div class="invoice_col_txt">
                                                                                    <!-- invoice column box start -->
                                                                                    <div class="invoice_col_input">
                                                                                        <!-- invoice column input start -->
                                                                                        <input type="text"
                                                                                               name="ttlQuantityForFinishedGoods"
                                                                                               id="ttlQuantityForFinishedGoods"
                                                                                               class="inputs_up text-right form-control required"
                                                                                               placeholder="0.00"
                                                                                               readonly
                                                                                               data-rule-required="true"
                                                                                               data-msg-required="Please Create Minimum One Inventory"
                                                                                        />
                                                                                    </div>
                                                                                    <!-- invoice column input end -->
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

                            <div class="gnrl-mrgn-pdng for_voucher"><!-- invoice container start -->
                                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate">
                                    <!-- invoice box start -->

                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                        <!-- invoice scroll box start -->
                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                            <!-- invoice content start -->

                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                    <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns">
                                                        <!-- invoice column box start -->
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button type="submit" name="save" id="save"
                                                                    class="invoice_frm_btn">
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


                    </form>
                </div>


            </div> <!-- white column form ends here -->

        </div><!-- col end -->


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
                packSize = document.getElementById("pro_scale_size"),
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
                packSize: packSize.id,
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
                remarks: remarks.value,
                quantity: quantity.value,
                uom: uom.value,
                packSize: packSize.value,
            };
            tableColumnsClasseArray = {
                srClass: 'text-center tbl_srl_4',
                codeClass: 'text-center tbl_srl_9',
                titleClass: 'text-left tbl_txt_20',
                remarksClass: 'text-left tbl_txt_42',
                quantityClass: 'text-right tbl_srl_12',
                uomClass: 'text-center tbl_srl_12',
                packSizeClass: 'text-center tbl_srl_12',
                actionClass: 'text-center tbl_srl_6',
            };
            // alert();
            let displayText = new displayValuesInTable(inputValuesArray, idForShowAndGetData);
            displayText.onlyQuantity(e, tableColumnsClasseArray, validateInputIdArray);
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
        //         srClass: 'text-center tbl_srl_4',
        //         codeClass: 'text-center tbl_srl_9',
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
                packSize = document.getElementById("pro_scale_size_secondary"),
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
                packSize: packSize.id,
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
                remarks: remarks.value,
                quantity: quantity.value,
                uom: uom.value,
                packSize: packSize.value,
            };
            tableColumnsClasseArray = {
                srClass: 'text-center tbl_srl_4',
                codeClass: 'text-center tbl_srl_9',
                titleClass: 'text-left tbl_txt_20',
                remarksClass: 'text-left tbl_txt_42',
                quantityClass: 'text-right tbl_srl_12',
                uomClass: 'text-center tbl_srl_12',
                actionClass: 'text-center tbl_srl_6',
            };

            let displayText = new displayValuesInTable(inputValuesArray, idForShowAndGetData);
            displayText.onlyQuantity(e, tableColumnsClasseArray, validateInputIdArray);
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

            var abc = $("#recipe_name").val();

            // var xyz = $("#ttlQuantityForProductRecipe").text();
            var xyz = $("#ttlQuantityForProductRecipe").val();


            if (abc == "") {
                // alert(abc);
                $("#recipe_name").css("background-color", "red");
                $("#recipe_name").css("color", "white");
                $("#recipe_name").focus();
                return false;
            } else if (xyz == "" || xyz == "0") {
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

            $("#pro_code").select2();
            $("#pro_title").select2();
            $("#goods_code").select2();
            $("#goods_title").select2();
            $("#exp_code").select2();
            $("#exp_title").select2();

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


        function codeTitleChangeMethod(e, id, uomId, proScaleSize) {
            // let code = e.value,

            let code = e.options[e.selectedIndex].getAttribute('data-code'),
                proUOM = e.options[e.selectedIndex].getAttribute('data-uom'),
                packSize = e.options[e.selectedIndex].getAttribute('data-scale_size');

            $("#" + uomId).val(proUOM);
            $("#" + proScaleSize).val(packSize);
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


        jQuery("#batch_name").change(function () {
            var batch_name = $(this).find(':selected').val();
            var recipe_name = $('#recipe_name').val();


            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_batch_details",
                data: {batch_name: batch_name},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    jQuery(".pre-loader").fadeToggle("medium");
                    console.log(data);
                    $('#order_id').val('');
                    $('#order_title').val('');
                    $('#order_id').val(data.po_products.bat_order_list_id);
                    $('#order_title').val(data.po_products.ol_order_title);
                    document.getElementById("order_title_View").innerHTML = data.po_products.ol_order_title;


                    jQuery("#primary_limited_product_quantity").val("");
                    jQuery("#primary_limited_product_quantity").val(data.po_products.bat_total_item);
                    jQuery("#pro_uom_primary").val("");
                    jQuery("#pro_uom_primary").val(data.po_products.unit_title);
                    jQuery("#primary_limited_product_scale_size").val("");
                    jQuery("#primary_limited_product_scale_size").val(data.po_products.unit_scale_size);
                    jQuery("#primary_limited_product_code").val("");
                    jQuery("#primary_limited_product_code").val(data.po_products.pro_p_code);
                    jQuery("#primary_limited_product_title").val("");
                    jQuery("#primary_limited_product_title").val(data.po_products.pro_title);

                    var options = "<option value='' disabled selected>Select Product Code</option>";
                    var option = "<option value='' disabled selected>Select Product Name</option>";
                    var array = {};
                    var counter = 0;
                    if (data.products != '') {

                        $.each(data.products, function (index, value) {
                            counter++;
                            if (value.pro_p_code == 101) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.pipe_center_support,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 102) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.back_sheet,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 103) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.tapa_sheet,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 104) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.ribot,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 105) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.angle_inch_soter,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 106) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.silver_angle,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 107) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.steel_nail,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 108) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.rawal_bolt,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 109) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.jist_wire,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 110) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.welding_rod,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 111) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.cutter_disk,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 112) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.paint,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 113) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.garasin_oil,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 114) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.media,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 115) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.printing,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 116) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.choke,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 117) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.tuberod,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 118) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.led_tuberod,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 119) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.module,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 120) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.grill_for_module,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 121) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.adaptor_supply,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 122) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.wire_1_29,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 123) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.wire_3_29,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size
                                }
                            } else if (value.pro_p_code == 124) {
                                array[counter] = {
                                    'title': value.pro_title,
                                    'code': value.pro_p_code,
                                    'remarks': '',
                                    'quantity': data.clump,
                                    'uom': value.unit_title,
                                    'packSize': value.unit_scale_size,
                                }
                            }

                            options += "<option value='" + value.pro_p_code + "' data-parent='" + value.pro_p_code + "'data-qty='" + value.pro_qty + "' data-purchase_price='" + value.pro_purchase_price
                                + "'" +
                                " " +
                                "data-tax='" + value.pro_tax + "'data-retailer_dis='" + value.pro_retailer_discount + "' data-whole_saler_dis='" + value.pro_whole_seller_discount + "' " +
                                "data-loyalty_dis='" + value.pro_loyalty_card_discount + "' data-uom='" + value.unit_title + "' data-scale_size='" + value.unit_scale_size + "' data-last_purchase='" +
                                value.pro_last_purchase_rate + "' data-average_rate='" + value.pro_average_rate + "' data-code='" + value.pro_p_code + "'>" + value.pro_p_code +
                                "</option>";
                        });

                        $.each(data.products, function (index, value) {
                            option += "<option value='" + value.pro_p_code + "' data-parent='" + value.pro_p_code + "'data-qty='" + value.pro_qty + "' data-purchase_price='" + value.pro_purchase_price +
                                "'" +
                                "data-tax='" + value.pro_tax + "'data-retailer_dis='" + value.pro_retailer_discount + "' data-whole_saler_dis='" + value.pro_whole_seller_discount + "' " +
                                "data-loyalty_dis='" + value.pro_loyalty_card_discount + "' data-uom='" + value.unit_title + "' data-scale_size='" + value.unit_scale_size + "' data-last_purchase='" +
                                value.pro_last_purchase_rate + "' data-average_rate='" + value.pro_average_rate + "' data-code='" + value.pro_p_code + "'>" + value.pro_title +
                                "</option>";
                        });

                        jQuery("#listForProductRecipe").html('');
                        var total_qty = 0;
                        var sr = 0;
                        $.each(array, function (index, value) {
                            sr++;
                            total_qty = +total_qty + +value.quantity;
                            jQuery("#listForProductRecipe").append(
                                '<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_10" hidden>' + value.code + '</td><td class="text-center tbl_srl_4">' + sr +
                                '</td>' +
                                '<td class="text-center tbl_srl_9">' + value.code + '</td>' +
                                // '<td class="text-center tbl_srl_9">' + value.title + '</td>' +
                                // '<td class="text-center tbl_srl_9">' + value.remarks + '</td>' +
                                '<td class="text-left tbl_txt_20">' + value.title + '</td>' +
                                '<td class="text-right tbl_srl_12">' + value.quantity + '</td>' +
                                '<td class="text-center tbl_srl_12">' + value.uom + '</td>' +
                                '</tr>');
                        });
                        console.log(array);
                        jQuery("#cartDataForProductRecipe").val(JSON.stringify(array));
                        $('#ttlQuantityForProductRecipe').val(total_qty.toFixed(2));
                        jQuery("#pro_code").html(" ");
                        jQuery("#pro_code").append(options);
                        jQuery("#pro_title").html(" ");
                        jQuery("#pro_title").append(option);


                        jQuery("#goods_code").html(" ");
                        jQuery("#goods_code").append(options);
                        jQuery("#goods_title").html(" ");
                        jQuery("#goods_title").append(option);
                    } else {
                        swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Products not Found Please Assign the Raw Material against the finished good',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-success',
                            timer: 4000
                        });

                    }
                    jQuery("#total_length").val(data.po_products.bat_total_length);
                    document.getElementById("totalQtyView").innerHTML = data.po_products.bat_total_length;


                    jQuery("#total_depth").val("");
                    jQuery("#total_height").val("");
                    jQuery("#total_height").val(data.po_products.bat_total_height);

                    jQuery("#total_depth").val(data.po_products.bat_total_depth);
                    var recipe_title = data.po_products.pro_title + ' (' + data.po_products.bat_total_length + ' X ' + data.po_products.bat_total_height + ' )';
                    jQuery("#recipe_title").val(recipe_title);
                    document.getElementById("recipe_title_View").innerHTML = recipe_title + ' ' + recipe_name;

                    // jQuery("#consumeTotalAmountView").text(data.po_products.bat_total_height);
                    // jQuery("#remainingTotalAmountView").text(data.po_products.bat_total_depth);

                    document.getElementById("consumeTotalQtyView").innerHTML = data.po_products.bat_total_height;
                    document.getElementById("remainingTotalQtyView").innerHTML = data.po_products.bat_total_depth;
                    jQuery(".pre-loader").fadeToggle("medium");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        $('#recipe_name').keyup(function () {
            var title = $('#recipe_title').val();
            var name = $(this).val();
            document.getElementById('recipe_title_View').innerHTML = title + ' ' + name;
        });

    </script>


@endsection
