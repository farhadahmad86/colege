
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
                            <h4 class="text-white get-heading-text"> Edit Batch Work Order </h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{ route('work_order.index') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->





                <form class="tab-wizard wizard-circle wizard" id="f1" action="{{ route('work_order.store') }}" method="post">
                    @csrf

                    <div class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                        <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                    <div class="invoice_row"><!-- invoice row start -->

                                        <div class="invoice_col basis_col_17"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Product Recipe
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <div class="invoice_col_short"><!-- invoice column short start -->
                                                        <a href="{{ route('product_recipe') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                        <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                            <i class="fa fa-refresh"></i>
                                                        </a>
                                                    </div><!-- invoice column short end -->
                                                    <select class="inputs_up form-control" name="pro_recipe" id="pro_recipe" data-method="loadContent" onchange="getRecipe(this);" data-rule-required="true" data-msg-required="Please Select Product Recipe">
                                                        <option value="" disabled selected> ---Select Product Recipe--- </option>
                                                        @foreach($get_recipies as $get_recipie)
                                                            <option value="{{$get_recipie->recipe_id}}">
                                                                {{$get_recipie->recipe_name}}
                                                            </option>
                                                        @endforeach
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
                                                    Order Quantity
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="text" class="inputs_up text-right form-control" name="order_quantity" id="order_quantity" placeholder="Product Quantity" min="1" onkeypress="return allow_only_number_and_decimals(this,event);" data-method="orderQuantityChange" onkeyup="orderQuantityChange(this);"  data-rule-required="true" data-msg-required="Please Enter Order Quantity" />
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
                                                    <input type="text" class="inputs_up text-center form-control" name="show_uom_main" id="show_uom_main" placeholder="UOM" readonly  data-rule-required="true" data-msg-required="Product UOM must require" />
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_15"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Estimate Start Time
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="text" name="estimated_start_time" class="inputs_up form-control datetimepicker" id="estimate_start_time" placeholder="Estimate Start Time"  data-rule-required="true" data-msg-required="Please Select Estimated Start Time">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_15"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Estimated End Time
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="text" name="estimated_end_time" class="inputs_up form-control datetimepicker" id="estimated_end_time" placeholder="Estimated End Time"  data-rule-required="true" data-msg-required="Please Select Estimated End Time">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                    Over Head Total
                                                </label><!-- invoice column title end -->
                                                <div class="invoice_col_txt"><!-- invoice column input start -->
                                                    <h5 class="grandTotalFont" id="overHeadGrandView">
                                                        0
                                                    </h5>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                    Stock Costing Total
                                                </label><!-- invoice column title end -->
                                                <div class="invoice_col_txt"><!-- invoice column input start -->
                                                    <h5 class="grandTotalFont" id="stockCostingGrandView">
                                                        0
                                                    </h5>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                    Total Amount
                                                </label><!-- invoice column title end -->
                                                <div class="invoice_col_txt"><!-- invoice column input start -->
                                                    <h5 class="grandTotalFont" id="overHeadPlusStockCosting">
                                                        0
                                                    </h5>
                                                    <input type="text" name="overHeadPlusStockCostingTotal" id="overHeadPlusStockCostingTotal" class="inputs_up form-control hidden" />
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->


                                    </div><!-- invoice row end -->

                                    <div class="tab">
                                        <ul class="nav nav-tabs customtab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#raw_product_stock_tab" role="tab" aria-selected="false">Budgeted Raw Stock</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#raw_stock_costing_tab" role="tab" aria-selected="false">Raw Stock Costing</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " data-toggle="tab" href="#primary_finished_goods_tab" role="tab" aria-selected="true">Primary Finished Goods</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#secondary_finished_goods_tab" role="tab" aria-selected="false">Secondary Finished Goods</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#product_over_head_tab" role="tab" aria-selected="false">Production Over Head</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content mt-4">

                                            <div class="tab-pane fade" id="primary_finished_goods_tab" role="tabpanel">
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
                                                                                <th class="text-center tbl_srl_9"> Code</th>
                                                                                <th class="text-center tbl_txt_20"> Title</th>
                                                                                <th class="text-center tbl_txt_30"> Product Remarks</th>
                                                                                <th class="text-center tbl_srl_6"> UOM </th>
                                                                                <th class="text-center tbl_srl_10"> Recipe Production Qty </th>
                                                                                <th class="text-center tbl_srl_10"> Stock Before Production </th>
                                                                                <th class="text-center tbl_srl_10"> Stock After Production </th>
                                                                            </tr>
                                                                            </thead>

                                                                            <tbody id="primaryFinishedGoods">
                                                                            <tr>
                                                                                <td colspan="10" align="center">
                                                                                    No Account Added
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>

                                                                        </table>
                                                                    </div><!-- product table box end -->
                                                                </div><!-- product table container end -->
                                                            </div><!-- invoice column end -->


                                                        </div><!-- invoice row end -->
                                                    </div><!-- invoice column end -->

                                                </div><!-- invoice row end -->
                                            </div>

                                            <div class="tab-pane fade" id="secondary_finished_goods_tab" role="tabpanel">
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
                                                                                <th class="text-center tbl_srl_9"> Code</th>
                                                                                <th class="text-center tbl_txt_20"> Title</th>
                                                                                <th class="text-center tbl_txt_20"> Product Remarks</th>
                                                                                <th class="text-center tbl_srl_6"> UOM </th>
                                                                                <th class="text-center tbl_srl_8"> Recipe Production Qty </th>
                                                                                <th class="text-center tbl_srl_8"> % </th>
                                                                                <th class="text-center tbl_srl_8"> Reqd. Production Qty </th>
                                                                                <th class="text-center tbl_srl_8"> Stock Before Production </th>
                                                                                <th class="text-center tbl_srl_8"> Stock After Production </th>
                                                                            </tr>
                                                                            </thead>

                                                                            <tbody id="secondaryFinishedGoods">
                                                                            <tr>
                                                                                <td colspan="10" align="center">
                                                                                    No Account Added
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>

                                                                        </table>
                                                                    </div><!-- product table box end -->
                                                                </div><!-- product table container end -->
                                                            </div><!-- invoice column end -->


                                                        </div><!-- invoice row end -->
                                                    </div><!-- invoice column end -->

                                                </div><!-- invoice row end -->
                                            </div>

                                            <div class="tab-pane fade show active" id="raw_product_stock_tab" role="tabpanel">
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
                                                                                <th class="text-center tbl_srl_9"> Code</th>
                                                                                <th class="text-center tbl_txt_20"> Title</th>
                                                                                <th class="text-center tbl_txt_22"> Product Remarks</th>
                                                                                <th class="text-center tbl_srl_6"> UOM </th>
                                                                                <th class="text-center tbl_srl_10"> Recipe Consumption </th>
                                                                                <th class="text-center tbl_srl_8"> % </th>
                                                                                <th class="text-center tbl_srl_10"> Reqd. Production Qty </th>
                                                                                <th class="text-center tbl_srl_10"> In Hand Stock </th>
                                                                            </tr>
                                                                            </thead>

                                                                            <tbody id="budgetRawStock">
                                                                            <tr>
                                                                                <td colspan="10" align="center">
                                                                                    No Account Added
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>

                                                                        </table>
                                                                    </div><!-- product table box end -->
                                                                </div><!-- product table container end -->
                                                            </div><!-- invoice column end -->


                                                        </div><!-- invoice row end -->
                                                    </div><!-- invoice column end -->

                                                </div><!-- invoice row end -->
                                            </div>


                                            <div class="tab-pane fade" id="product_over_head_tab" role="tabpanel">

                                                <div class="invoice_row"><!-- invoice row start -->

                                                    <div class="invoice_col basis_col_20"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover"
                                                                   data-trigger="hover"
                                                                   data-placement="bottom" data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.description')}}</p>
                                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.benefits')}}</p>
                                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Select Warehouse
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_txt inline_radio"><!-- invoice column input start -->
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="warehouse_select" class="invoice_type" id="department_warehouse" value="departments_show" checked>
                                                                        Departments
                                                                    </label>
                                                                </div>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="warehouse_select" class="invoice_type" id="vendor_warehouse" value="parties_clients_show">
                                                                        Vendors
                                                                    </label>
                                                                </div>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div id="departments_show" class="warehouse_box invoice_col basis_col_23"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Department
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                    <a href="{{ route('product_recipe') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                        <i class="fa fa-refresh"></i>
                                                                    </a>
                                                                </div><!-- invoice column short end -->
                                                                <select name="department_list" id="department_list" class="inputs_up form-control">
                                                                    <option value="" disabled selected> ---Select Department--- </option>
                                                                    @foreach($departments as $department)
                                                                        <option value="{{$department->department_id}}">
                                                                            {{$department->department_name}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div id="parties_clients_show" class="warehouse_box hide invoice_col basis_col_23"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Party/Client
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                    <a href="{{ route('product_recipe') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                        <i class="fa fa-refresh"></i>
                                                                    </a>
                                                                </div><!-- invoice column short end -->
                                                                <select name="party_client_list" id="party_client_list" class="inputs_up form-control">
                                                                    <option value="0">---Party/Client---</option>
                                                                    @foreach($accounts as $account)
                                                                        <option value="{{$account->account_uid}}">
                                                                            {{$account->account_name}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Supervisor
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                    <a href="{{ route('product_recipe') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                        <i class="fa fa-refresh"></i>
                                                                    </a>
                                                                </div><!-- invoice column short end -->
                                                                <select class="inputs_up form-control" id="employee_list" name="employee_list">
                                                                    <option value="" disabled selected> ---Select Supervisor--- </option>
                                                                    @foreach($employees as $employee)
                                                                        <option value="{{$employee->user_id}}">
                                                                            {{$employee->user_name}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                </div><!-- invoice row end -->


                                                <h5 class="mb-2"> Add Services </h5>

                                                <div class="invoice_row"><!-- invoice row start -->

                                                    <div class="invoice_col basis_col_13"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                   data-placement="bottom" data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Service Code
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                    <a href="{{ route('account_registration') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                        <i class="fa fa-refresh"></i>
                                                                    </a>
                                                                </div><!-- invoice column short end -->
                                                                <select class="inputs_up form-control" id="ser_code" onchange="codeTitleChangeMethod(this, 'ser_title')">
                                                                    <option value="" disabled selected> ---Select Code--- </option>
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
                                                                Service Title
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->

                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                    <a href="{{ route('account_registration') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a id="refresh_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                        <i class="fa fa-refresh"></i>
                                                                    </a>
                                                                </div><!-- invoice column short end -->
                                                                <select class="inputs_up form-control" id="ser_title" onchange="codeTitleChangeMethod(this, 'ser_code')">
                                                                    <option value="" disabled selected> ---Select Service--- </option>
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
                                                                Expense Account
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->

                                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                                    <a href="{{ route('account_registration') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a id="refresh_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                        <i class="fa fa-refresh"></i>
                                                                    </a>
                                                                </div><!-- invoice column short end -->
                                                                <select class="inputs_up form-control" id="expense_account">
                                                                    <option value="" disabled selected> ---Select Expense---</option>
                                                                    @foreach($expense_accounts as $expense_account)
                                                                        <option value="{{$expense_account->account_uid}}">
                                                                            {{$expense_account->account_name}}
                                                                        </option>
                                                                    @endforeach
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
                                                                Service Remarks
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="text" class="inputs_up form-control" id="ser_remarks" placeholder="Service Remarks">
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Service Rate
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="text" class="inputs_up text-right form-control" id="ser_rate" placeholder="Service Rate" min="1" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="quantityRateMultiply('ser_rate', 'ser_qty', 'ser_amount')" />
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_9"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Service Qty
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="text" class="inputs_up text-right form-control" id="ser_qty" placeholder="Service Qty" min="1" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="quantityRateMultiply('ser_rate', 'ser_qty', 'ser_amount')" />
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
                                                                <select class="inputs_up form-control" id="ser_uom">
                                                                    <option value="" disabled selected> ---Select UOM--- </option>
                                                                    @foreach($units as $unit)
                                                                        <option value="{{$unit->unit_id}}">
                                                                            {{ $unit->unit_title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_15"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Total Amount
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="text" class="inputs_up text-right form-control" id="ser_amount" placeholder="Total Amount" min="1" onkeypress="return allow_only_number_and_decimals(this,event);" readonly />
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_17"><!-- invoice column start -->
                                                        <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                                            <div class="invoice_col_txt with_cntr_jstfy">
                                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                    <button id="addInventory" class="invoice_frm_btn" data-method="create" onclick="addToCart(this)" type="button">
                                                                        <i class="fa fa-plus"></i> Add
                                                                    </button>
                                                                </div>
                                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                    <button id="cancelInventory" class="invoice_frm_btn hide" data-method="cancel" onclick="addToCart(this)" type="button">
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
                                                                        <th class="text-center tbl_srl_4"> Sr.</th>
                                                                        <th class="text-center tbl_srl_9"> Code</th>
                                                                        <th class="text-center tbl_txt_15"> Service Title</th>
                                                                        <th class="text-center tbl_txt_15"> Expense Title</th>
                                                                        <th class="text-center tbl_txt_29"> Service Remarks</th>
                                                                        <th class="text-center tbl_srl_6"> Rate </th>
                                                                        <th class="text-center tbl_srl_6"> Quantity </th>
                                                                        <th class="text-center tbl_srl_6"> UOM </th>
                                                                        <th class="text-center tbl_srl_10"> Amount </th>
                                                                    </tr>
                                                                    </thead>

                                                                    <tbody id="servicesProductionOverHead">
                                                                    <tr>
                                                                        <td colspan="10" align="center">
                                                                            No Account Added
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>

                                                                                                                                                                            <tfoot>
                                                                                                                                                                                <tr>
                                                                                                                                                                                    <th colspan="8" class="text-right">
                                                                                                                                                                                        Grand Total
                                                                                                                                                                                    </th>
                                                                                                                                                                                    <td class="text-center tbl_srl_10">
                                                                                                                                                                                        <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                                                                                                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                                                                                                                                <input type="text" name="ttlAmountForOverHead" id="ttlAmountForOverHead" class="inputs_up text-right form-control required" placeholder="0.00" readonly />
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

                                            </div>


                                            <div class="tab-pane fade" id="raw_stock_costing_tab" role="tabpanel">

                                                <div class="invoice_row"><!-- invoice row start -->


                                                    <div class="invoice_col basis_col_20"><!-- invoice column start -->
                                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                                            <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                   data-placement="bottom" data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.description')}}</p>
                                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.benefits')}}</p>
                                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Select Product Rate
                                                            </div><!-- invoice column title end -->
                                                            <div class="invoice_col_txt inline_radio"><!-- invoice column input start -->
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="product_rate_type" class="invoice_type" id="last_purchase_rate" value="last_purchase_rate_show" checked  onclick="rateChange(this);" data-method="orderQuantityChange">
                                                                        Last Purchase Rate
                                                                    </label>
                                                                </div>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" name="product_rate_type" class="invoice_type" id="average_rate" value="average_rate_show" onclick="rateChange(this);" data-method="orderQuantityChange">
                                                                        Average Rate
                                                                    </label>
                                                                </div>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->

                                                    <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                        <div class="invoice_row"><!-- invoice row start -->

                                                            <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                                                <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                                                    <div class="pro_tbl_bx"><!-- product table box start -->
                                                                        <table class="table gnrl-mrgn-pdng">
                                                                            <thead>
                                                                            <tr>
                                                                                <th class="text-center tbl_srl_4"> Sr.</th>
                                                                                <th class="text-center tbl_srl_9"> Code</th>
                                                                                <th class="text-center tbl_txt_20"> Title</th>
                                                                                <th class="text-center tbl_txt_30"> Product Remarks</th>
                                                                                <th class="text-center tbl_srl_6"> UOM </th>
                                                                                <th class="text-center tbl_srl_10"> Quantity </th>
                                                                                <th class="text-center tbl_srl_10"> Rate </th>
                                                                                <th class="text-center tbl_srl_10"> Total </th>
                                                                            </tr>
                                                                            </thead>

                                                                            <tbody id="listForRawStockCosting">
                                                                            <tr>
                                                                                <td colspan="10" align="center">
                                                                                    No Account Added
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>

                                                                            <tfoot>
                                                                            <tr>
                                                                                <th colspan="7" class="text-right">
                                                                                    Grand Total
                                                                                </th>
                                                                                <td class="text-center tbl_srl_10">
                                                                                    <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                            <input type="text" name="rate_type_grand_total" id="rate_type_grand_total" class="inputs_up text-right form-control required" placeholder="0.00" readonly  data-rule-required="true" data-msg-required="Please Create Minimum One Inventory"/>
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

                                            </div>


                                        </div>
                                    </div><!-- tabs end here -->


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

                                </div><!-- invoice content end -->
                            </div><!-- invoice scroll box end -->


                        </div><!-- invoice box end -->
                    </div><!-- invoice container end -->

                    <input type="hidden" name="cartDataForServicesProductionOverHead" id="cartDataForServicesProductionOverHead" />



                    <input type="hidden" name="cartDataForBudgetRawStock" id="cartDataForBudgetRawStock" />
                    <input type="hidden" name="cartDataForRawStockCosting" id="cartDataForRawStockCosting" />
                    <input type="hidden" name="cartDataForPrimaryGoods" id="cartDataForPrimaryGoods" />
                    <input type="hidden" name="cartDataForSecondaryGoods" id="cartDataForSecondaryGoods" />


                </form>


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

    function addToCart(e) {

        let code = document.getElementById("ser_code"),
            title = document.getElementById("ser_title"),
            expenseAccount = document.getElementById("expense_account"),
            remarks = document.getElementById("ser_remarks"),
            rate = document.getElementById("ser_rate"),
            quantity = document.getElementById("ser_qty"),
            uom = document.getElementById("ser_uom"),
            amount = document.getElementById("ser_amount"),
            tblListId = 'servicesProductionOverHead',
            cartDataArrayId = 'cartDataForServicesProductionOverHead',
            ttlAmountId = 'ttlAmountForOverHead',
            addBtnId = 'addInventory',
            cancelBtnId = 'cancelInventory',
            btnCallMethodName = 'addToCart';

        idForShowAndGetData = {
            tblListId: tblListId,
            cartDataArrayId: cartDataArrayId,
            ttlAmountId: ttlAmountId,
            addBtnId: addBtnId,
            cancelBtnId: cancelBtnId,
            btnCallMethodName: btnCallMethodName,
            codeId: code.id,
            titleId: title.id,
            expenseAccountId: expenseAccount.id,
            remarksId: remarks.id,
            rateId: rate.id,
            quantityId: quantity.id,
            uomId: uom.id,
            amountId: amount.id,
        };
        validateInputIdArray = [
            code.id,
            title.id,
            expenseAccount.id,
            rate.id,
            quantity.id,
            uom.id,
            amount.id,
        ];
        inputValuesArray = {
            code: code.value,
            title: title.options[title.selectedIndex].text,
            expenseAccount: expenseAccount.value,
            expenseAccountText: expenseAccount.options[expenseAccount.selectedIndex].text,
            remarks: remarks.value,
            rate: rate.value,
            quantity: quantity.value,
            uom: uom.value,
            uomText: uom.options[uom.selectedIndex].text,
            amount: amount.value,
        };
        tableColumnsClasseArray = {
            srClass: 'text-center tbl_srl_4',
            codeClass: 'text-center tbl_srl_9',
            titleClass: 'text-left tbl_txt_15',
            expenseAccountClass: 'text-left tbl_txt_15',
            remarksClass: 'text-left tbl_txt_29',
            rateClass: 'text-right tbl_txt_6',
            quantityClass: 'text-right tbl_srl_6',
            uomClass: 'text-center tbl_srl_6',
            amountClass: 'text-right tbl_srl_10',
        };

        let displayText = new displayValuesInTable(inputValuesArray, idForShowAndGetData);
        displayText.onlyForUOMRateAmount(e, tableColumnsClasseArray, validateInputIdArray);
        inputValuesArray = [];
        showOverHeadPlusStockCostingTotal();
    }


    $(document).on('keyup keypress', 'form input', function(e) {
        if(e.which == 13) {
            e.preventDefault();
            return false;
        }
    });

    function codeTitleChangeMethod(e, id){
        let code = e.value;

        $("#"+id).select2("destroy");
        $("#"+id+ " option[value='" + code + "']").prop('selected', true);
        $("#"+id).select2();
    }

</script>


<script>


    $(document).ready(function () {

        $("#ser_code").append("{!! $service_code !!}");
        $("#ser_title").append("{!! $service_name !!}");

        // Initialize select2
        $("#pro_recipe").select2();
        $("#department_list").select2();
        $("#party_client_list").select2();
        $("#employee_list").select2();
        $("#ser_uom").select2();
        $("#ser_code").select2();
        $("#ser_title").select2();
        $("#expense_account").select2();

        $("input[name='warehouse_select']").change(function () {
            let get_warehouse = $(this).val();
            $(".warehouse_box").addClass('hide');
            $("#"+get_warehouse).toggleClass('hide');
        });

        $("input[name='uom_type']").change(function () {
            let get_uom = $(this).val();
            $(".uom_box").addClass('hide');
            if( get_uom !== '' && get_uom === 'uom_other_show') {
                $("#" + get_uom).toggleClass('hide');
            }
        });

    });

    function getRecipe(e) {

        jQuery(".pre-loader").fadeToggle("medium");
        let recipe_id = e.value;

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "{{ route("get_recipe") }}",
            data:{id: recipe_id},
            type: "POST",
            cache:false,
            dataType: 'json',
            success:function(data){
                let order_quantity_val = parseFloat( $("#order_quantity").val() ),
                    order_quantity = ( !order_quantity_val || order_quantity_val === 0 || order_quantity_val == '' || order_quantity_val == 'NaN' ) ? 1 : order_quantity_val;


                let grandTtl = 0,
                    primaryFinishedGoodsQty = 0;


                /*
                 *** Add Primary Goods Array
                 */
                $("#cartDataForPrimaryGoods").val("");
                $("#primaryFinishedGoods").html(" ");
                $.each( data.get_primary, function( key, value ) {
                    let orderQuantity = ( order_quantity === 0 || order_quantity <= value.quantity ) ? value.quantity : order_quantity,
                        ttl_quantity = parseFloat( orderQuantity ) + parseFloat( value.pro_available_quantity );


                    document.getElementById("show_uom_main").value = value.pro_uom;

                    let inputValuesArrayPrimary = {
                        code: value.pro_code,
                        title: value.pro_name,
                        remarks: value.pro_remarks,
                        uom: value.pro_uom,
                        quantity: value.quantity,
                        stockBeforeProduction: value.pro_available_quantity,
                        stockAfterProduction: ttl_quantity.toFixed(3),
                        orderQuantity: order_quantity,
                    };
                    addToCartPrimaryGoods(e, inputValuesArrayPrimary);
                    primaryFinishedGoodsQty = value.quantity;
                });
                /*
                 *** Add Primary Goods Array
                 */


                /*
                 *** Add Budgeted Raw Stock Array
                 *** Add Raw Stock Costing Array
                 */
                $("#cartDataForBudgetRawStock").val("");
                $("#cartDataForRawStockCosting").val("");
                $("#budgetRawStock").html(" ");
                $("#listForRawStockCosting").html(" ");
                $.each( data.get_raw, function( key, value ) {
                    let qty = parseFloat( value.quantity ),
                        qty_percentage = qty / parseFloat(primaryFinishedGoodsQty ) * 100,
                        ttl_quantity = ( order_quantity * qty_percentage ) / 100,
                        ttl_amount = ttl_quantity * parseFloat(value.pro_last_purchase_rate);
                    grandTtl = ttl_amount + parseFloat(grandTtl);

                    let inputValuesArrayBudgetedRaw = {
                        code: value.pro_code,
                        title: value.pro_name,
                        remarks: value.pro_remarks,
                        uom: value.pro_uom,
                        quantity: qty.toFixed(3),
                        qtyPercentage: qty_percentage.toFixed(0),
                        ttlQuantity: ttl_quantity.toFixed(3),
                        availableQuantity: value.pro_available_quantity,
                        primaryFinishedGoodsQty: primaryFinishedGoodsQty,
                        orderQuantity: order_quantity,
                    };
                    addToCartBudgetedRaw(e, inputValuesArrayBudgetedRaw);


                    let inputValuesArrayRawStockCosting = {
                        code: value.pro_code,
                        title: value.pro_name,
                        remarks: value.pro_remarks,
                        uom: value.pro_uom,
                        quantity: qty.toFixed(3),
                        ttlQuantity: ttl_quantity.toFixed(3),
                        rate: value.pro_last_purchase_rate,
                        amount: ttl_amount.toFixed(3),
                        lastPurchaseRate: value.pro_last_purchase_rate,
                        averageRate: value.pro_average_rate,
                        primaryFinishedGoodsQty: primaryFinishedGoodsQty,
                        orderQuantity: order_quantity,
                    };
                    addToCartRawStockCosting(e, inputValuesArrayRawStockCosting);


                });
                // $("#rate_type_grand_total").val(grandTtl.toFixed(3));
                $("#stockCostingGrandView").text(grandTtl.toFixed(3));
                showOverHeadPlusStockCostingTotal();
                /*
                 *** Add Budgeted Raw Stock Array
                 *** Add Raw Stock Costing Array
                 */




                /*
                 *** Add Secondary Goods Array
                 */
                $("#cartDataForSecondaryGoods").val("");
                $("#secondaryFinishedGoods").html("");
                $.each( data.get_secondary, function( key, value ) {
                    let qty = parseFloat( value.quantity ),
                        qty_percentage = qty / parseFloat( primaryFinishedGoodsQty ) * 100,
                        ttl_quantity = ( parseFloat( order_quantity ) * qty_percentage ) / 100,
                        stockWillBe = parseFloat( value.pro_available_quantity ) + ttl_quantity;

                    let inputValuesArraySecondary = {
                        code: value.pro_code,
                        title: value.pro_name,
                        remarks: value.pro_remarks,
                        uom: value.pro_uom,
                        quantity: qty.toFixed(3),
                        qtyPercentage: qty_percentage.toFixed(0),
                        ttlQuantity: ttl_quantity.toFixed(3),
                        stockAfterProduction: stockWillBe.toFixed(3),
                        availableQuantity: value.pro_available_quantity,
                        primaryFinishedGoodsQty: primaryFinishedGoodsQty,
                        orderQuantity: order_quantity,
                    };
                    addToCartSecondaryGoods(e, inputValuesArraySecondary);
                });

                /*
                 *** Add Secondary Goods Array
                 */



                jQuery(".pre-loader").fadeToggle("medium");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                jQuery(".pre-loader").fadeToggle("medium");
                alert(jqXHR.responseText);
                alert(errorThrown);}
        });

        /*
         *** Calculate Total Amount (Sum Of Over Head Total & Stock Costing Total)
         */
        showOverHeadPlusStockCostingTotal();
    }

    function orderQuantityChange(e) {

        let order_quantity_val = parseFloat( e.value ),
            order_quantity = ( !order_quantity_val || order_quantity_val === 0 || order_quantity_val == '' || order_quantity_val == 'NaN' ) ? 1 : order_quantity_val;


        /*
         *** Update Primary Goods Array
         */
        let getPrimaryId = document.getElementById("cartDataForPrimaryGoods"),
            getPrimary = ( getPrimaryId.value !== '' ) ? JSON.parse(getPrimaryId.value) : [];

        getPrimary.forEach(function (item, index) {
            let orderQuantity = ( order_quantity === 0 || order_quantity <= getPrimary[index]['quantity'] ) ? getPrimary[index]['quantity'] : order_quantity,
                ttl_quantity = parseFloat( orderQuantity ) + parseFloat( getPrimary[index]['stockBeforeProduction'] );

            getPrimaryId.setAttribute('data-editUpdateRowIndex', index);

            let inputValuesArrayPrimary = {
                code: getPrimary[index]['code'],
                title: getPrimary[index]['title'],
                remarks: getPrimary[index]['remarks'],
                uom: getPrimary[index]['uom'],
                quantity: getPrimary[index]['quantity'],
                stockBeforeProduction: getPrimary[index]['stockBeforeProduction'],
                stockAfterProduction: ttl_quantity.toFixed(3),
                orderQuantity: orderQuantity,
            };
            addToCartPrimaryGoods(e, inputValuesArrayPrimary);
        });
        /*
         *** Update Primary Goods Array End
         */


        /*
         *** Update Secondary Goods Array
         */
        let getSecondaryId = document.getElementById("cartDataForSecondaryGoods"),
            getSecondary = ( getSecondaryId.value !== '' ) ? JSON.parse(getSecondaryId.value) : [];

        getSecondary.forEach(function (item, index) {
            let qty = parseFloat( getSecondary[index]['quantity'] ),
                qty_percentage = qty / parseFloat( getSecondary[index]['primaryFinishedGoodsQty'] ) * 100,
                ttl_quantity = ( order_quantity * qty_percentage ) / 100,
                stockWillBe = ttl_quantity + parseFloat( getSecondary[index]['availableQuantity'] );

            getSecondaryId.setAttribute('data-editUpdateRowIndex', index);

            let inputValuesArraySecondary = {
                code: getSecondary[index]['code'],
                title: getSecondary[index]['title'],
                remarks: getSecondary[index]['remarks'],
                uom: getSecondary[index]['uom'],
                quantity: qty.toFixed(3),
                qtyPercentage: qty_percentage.toFixed(0),
                ttlQuantity: ttl_quantity.toFixed(3),
                stockAfterProduction: stockWillBe.toFixed(3),
                availableQuantity: getSecondary[index]['availableQuantity'],
                primaryFinishedGoodsQty: getSecondary[index]['primaryFinishedGoodsQty'],
                orderQuantity: order_quantity,
            };
            addToCartSecondaryGoods(e, inputValuesArraySecondary);
        });
        /*
         *** Update Secondary Goods Array End
         */


        /*
         *** Update Budgeted Raw Array
         */
        let getBudgetedRawId = document.getElementById("cartDataForBudgetRawStock"),
            getBudgetedRaw = ( getBudgetedRawId.value !== '' ) ? JSON.parse(getBudgetedRawId.value) : [];

        getBudgetedRaw.forEach(function (item, index) {
            let qty = parseFloat( getBudgetedRaw[index]['quantity'] ),
                qty_percentage = qty / parseFloat( getBudgetedRaw[index]['primaryFinishedGoodsQty'] ) * 100,
                ttl_quantity = ( order_quantity * qty_percentage ) / 100,
                stockWillBe = ttl_quantity + parseFloat( getBudgetedRaw[index]['availableQuantity'] );

            getBudgetedRawId.setAttribute('data-editUpdateRowIndex', index);

            let inputValuesArrayBudgetedRaw = {
                code: getBudgetedRaw[index]['code'],
                title: getBudgetedRaw[index]['title'],
                remarks: getBudgetedRaw[index]['remarks'],
                uom: getBudgetedRaw[index]['uom'],
                quantity: qty.toFixed(3),
                qtyPercentage: qty_percentage.toFixed(0),
                ttlQuantity: ttl_quantity.toFixed(3),
                availableQuantity: getBudgetedRaw[index]['availableQuantity'],
                primaryFinishedGoodsQty: getBudgetedRaw[index]['primaryFinishedGoodsQty'],
                orderQuantity: order_quantity,
            };

            addToCartBudgetedRaw(e, inputValuesArrayBudgetedRaw);
        });
        /*
         *** Update Budgeted Raw Array End
         */


        /*
         *** Update Stock Costing Array
         */
        let getStockCostingId = document.getElementById("cartDataForRawStockCosting"),
            getStockCosting = ( getStockCostingId.value !== '' ) ? JSON.parse(getStockCostingId.value) : [],
            rateTypeStockCosting = document.querySelector("input[name='product_rate_type']:checked").value;

        getStockCosting.forEach(function (item, index) {
            let qty = parseFloat( getStockCosting[index]['quantity'] ),
                qty_percentage = qty / parseFloat( getStockCosting[index]['primaryFinishedGoodsQty'] ) * 100,
                ttl_quantity = ( order_quantity * qty_percentage ) / 100,
                setRateTypeVal = ( rateTypeStockCosting === "last_purchase_rate_show") ? parseFloat( getStockCosting[index]['lastPurchaseRate'] ) : parseFloat( getStockCosting[index]['averageRate'] ),
                ttl_amount = ttl_quantity * setRateTypeVal;

            getStockCostingId.setAttribute('data-editUpdateRowIndex', index);

            let inputValuesArrayRawStockCosting = {
                code: getStockCosting[index]['code'],
                title: getStockCosting[index]['title'],
                remarks: getStockCosting[index]['remarks'],
                uom: getStockCosting[index]['uom'],
                quantity: qty.toFixed(3),
                ttlQuantity: ttl_quantity.toFixed(3),
                rate: setRateTypeVal.toFixed(3),
                amount: ttl_amount.toFixed(3),
                lastPurchaseRate: getStockCosting[index]['lastPurchaseRate'],
                averageRate: getStockCosting[index]['averageRate'],
                primaryFinishedGoodsQty: getStockCosting[index]['primaryFinishedGoodsQty'],
                orderQuantity: order_quantity,
            };

            addToCartRawStockCosting(e, inputValuesArrayRawStockCosting);
        });
        /*
         *** Update Stock Costing Array End
         */

        showOverHeadPlusStockCostingTotal();
    }

    function rateChange(e) {
        /*
         *** Update Stock Costing Array
         */
        let rateType = e.value,
            getStockCostingId = document.getElementById("cartDataForRawStockCosting"),
            getStockCosting = ( getStockCostingId.value !== '' ) ? JSON.parse(getStockCostingId.value) : [],
            order_quantity_val = document.getElementById("order_quantity").value,
            order_quantity = ( !order_quantity_val || order_quantity_val === 0 || order_quantity_val == '' || order_quantity_val == 'NaN' ) ? 1 : order_quantity_val;

        getStockCosting.forEach(function (item, index) {
            let qty = parseFloat( getStockCosting[index]['quantity'] ),
                qty_percentage = qty / parseFloat( getStockCosting[index]['primaryFinishedGoodsQty'] ) * 100,
                ttl_quantity = ( order_quantity * qty_percentage ) / 100,
                setRateTypeVal = ( rateType === "last_purchase_rate_show") ? parseFloat( getStockCosting[index]['lastPurchaseRate'] ) : parseFloat( getStockCosting[index]['averageRate'] ),
                ttl_amount = ttl_quantity * setRateTypeVal;

            getStockCostingId.setAttribute('data-editUpdateRowIndex', index);

            let inputValuesArrayRawStockCosting = {
                code: getStockCosting[index]['code'],
                title: getStockCosting[index]['title'],
                remarks: getStockCosting[index]['remarks'],
                uom: getStockCosting[index]['uom'],
                quantity: qty.toFixed(3),
                ttlQuantity: ttl_quantity.toFixed(3),
                rate: setRateTypeVal.toFixed(3),
                amount: ttl_amount.toFixed(3),
                lastPurchaseRate: getStockCosting[index]['lastPurchaseRate'],
                averageRate: getStockCosting[index]['averageRate'],
                primaryFinishedGoodsQty: getStockCosting[index]['primaryFinishedGoodsQty'],
                orderQuantity: order_quantity,
            };

            addToCartRawStockCosting(e, inputValuesArrayRawStockCosting);
        });
        /*
         *** Update Stock Costing Array End
         */

        showOverHeadPlusStockCostingTotal();
    }

    function showOverHeadPlusStockCostingTotal(){
        let getStockCostingGrandId = $("#rate_type_grand_total"),
            getStockCostingGrandVal = ( getStockCostingGrandId.val() !== "" || getStockCostingGrandId.val() === 0 ) ? parseFloat( getStockCostingGrandId.val() ) : 0,
            getOverHeadGrandId = $("#ttlAmountForOverHead"),
            getOverHeadGrandVal = ( getOverHeadGrandId.val() !== "" || getOverHeadGrandId.val() === 0 ) ? parseFloat( getOverHeadGrandId.val() ) : 0,
            totalOf = getStockCostingGrandVal + getOverHeadGrandVal;

        $("#overHeadPlusStockCosting").text( totalOf.toFixed(3) );
        $("#overHeadPlusStockCostingTotal").val( totalOf.toFixed(3) );

    }







    let inputValuesArrayPrimary = [],
        inputValuesArrayAssignPrimary = [],
        idForShowAndGetDataPrimary = {},
        tableColumnsClasseArrayPrimary = {},
        validateInputIdArrayPrimary = {};

    function addToCartPrimaryGoods(e, inputValuesArrayParam) {

        let tblListId = 'primaryFinishedGoods',
            cartDataArrayId = 'cartDataForPrimaryGoods',
            addBtnId = 'pro_recipe',
            btnCallMethodName = 'addToCartPrimaryGoods';

        idForShowAndGetDataPrimary = {
            tblListId: tblListId,
            cartDataArrayId: cartDataArrayId,
            addBtnId: addBtnId,
            btnCallMethodName: btnCallMethodName,
        };
        tableColumnsClasseArrayPrimary = {
            srClass: 'text-center tbl_srl_4',
            codeClass: 'text-center tbl_srl_9',
            titleClass: 'text-left tbl_txt_20',
            remarksClass: 'text-left tbl_txt_30',
            uomClass: 'text-center tbl_srl_6',
            productionQtyClass: 'text-right tbl_srl_10',
            stockBeforeProductionClass: 'text-right tbl_srl_10',
            stockAfterProductionClass: 'text-right tbl_srl_10',
        };
        inputValuesArrayPrimary = inputValuesArrayParam;
        validateInputIdArrayPrimary = [
            e.id,
        ];

        let displayText = new displayValuesInTable(inputValuesArrayPrimary, idForShowAndGetDataPrimary);
        displayText.onlyForPrimaryGoods(e, tableColumnsClasseArrayPrimary, validateInputIdArrayPrimary);
        inputValuesArray = [];
    }


    let inputValuesArraySecondary = [],
        inputValuesArrayAssignSecondary = [],
        idForShowAndGetDataSecondary = {},
        tableColumnsClasseArraySecondary = {},
        validateInputIdArraySecondary = {};

    function addToCartSecondaryGoods(e, inputValuesArrayParam) {

        let tblListId = 'secondaryFinishedGoods',
            cartDataArrayId = 'cartDataForSecondaryGoods',
            addBtnId = 'pro_recipe',
            btnCallMethodName = 'addToCartSecondaryGoods';

        idForShowAndGetDataSecondary = {
            tblListId: tblListId,
            cartDataArrayId: cartDataArrayId,
            addBtnId: addBtnId,
            btnCallMethodName: btnCallMethodName,
        };
        tableColumnsClasseArraySecondary = {
            srClass: 'text-center tbl_srl_4',
            codeClass: 'text-center tbl_srl_9',
            titleClass: 'text-left tbl_txt_20',
            remarksClass: 'text-left tbl_txt_20',
            uomClass: 'text-center tbl_srl_6',
            productionQtyClass: 'text-right tbl_srl_8',
            percentageClass: 'text-right tbl_srl_8',
            ttlQtyClass: 'text-right tbl_srl_8',
            stockBeforeProductionClass: 'text-right tbl_srl_8',
            stockAfterProductionClass: 'text-right tbl_srl_8',
        };
        inputValuesArraySecondary = inputValuesArrayParam;
        validateInputIdArraySecondary = [
            e.id,
        ];

        let displayText = new displayValuesInTable(inputValuesArraySecondary, idForShowAndGetDataSecondary);
        displayText.onlyForSecondaryGoods(e, tableColumnsClasseArraySecondary, validateInputIdArraySecondary);
        inputValuesArray = [];
    }


    let inputValuesArrayBudgetedRaw = [],
        inputValuesArrayAssignBudgetedRaw = [],
        idForShowAndGetDataBudgetedRaw = {},
        tableColumnsClasseArrayBudgetedRaw = {},
        validateInputIdArrayBudgetedRaw = {};

    function addToCartBudgetedRaw(e, inputValuesArrayParam) {

        let tblListId = 'budgetRawStock',
            cartDataArrayId = 'cartDataForBudgetRawStock',
            addBtnId = 'pro_recipe',
            btnCallMethodName = 'addToCartBudgetedRaw';

        idForShowAndGetDataBudgetedRaw = {
            tblListId: tblListId,
            cartDataArrayId: cartDataArrayId,
            addBtnId: addBtnId,
            btnCallMethodName: btnCallMethodName,
        };
        tableColumnsClasseArrayBudgetedRaw = {
            srClass: 'text-center tbl_srl_4',
            codeClass: 'text-center tbl_srl_9',
            titleClass: 'text-left tbl_txt_20',
            remarksClass: 'text-left tbl_txt_22',
            uomClass: 'text-center tbl_srl_6',
            productionQtyClass: 'text-right tbl_srl_10',
            percentageClass: 'text-right tbl_srl_8',
            ttlQtyClass: 'text-right tbl_srl_10',
            inHandClass: 'text-right tbl_srl_10',
        };
        inputValuesArrayBudgetedRaw = inputValuesArrayParam;
        validateInputIdArrayBudgetedRaw = [
            e.id,
        ];

        let displayText = new displayValuesInTable(inputValuesArrayBudgetedRaw, idForShowAndGetDataBudgetedRaw);
        displayText.onlyForBudgetedRaw(e, tableColumnsClasseArrayBudgetedRaw, validateInputIdArrayBudgetedRaw);
        inputValuesArray = [];
    }


    let inputValuesArrayRawStockCosting = [],
        inputValuesArrayAssignRawStockCosting = [],
        idForShowAndGetDataRawStockCosting = {},
        tableColumnsClasseArrayRawStockCosting = {},
        validateInputIdArrayRawStockCosting = {};

    function addToCartRawStockCosting(e, inputValuesArrayParam) {

        let tblListId = 'listForRawStockCosting',
            cartDataArrayId = 'cartDataForRawStockCosting',
            addBtnId = 'pro_recipe',
            ttlAmountId = 'rate_type_grand_total',
            btnCallMethodName = 'addToCartRawStockCosting';

        idForShowAndGetDataRawStockCosting = {
            tblListId: tblListId,
            cartDataArrayId: cartDataArrayId,
            addBtnId: addBtnId,
            ttlAmountId: ttlAmountId,
            btnCallMethodName: btnCallMethodName,
        };
        tableColumnsClasseArrayRawStockCosting = {
            srClass: 'text-center tbl_srl_4',
            codeClass: 'text-center tbl_srl_9',
            titleClass: 'text-left tbl_txt_20',
            remarksClass: 'text-left tbl_txt_30',
            uomClass: 'text-center tbl_srl_6',
            qtyClass: 'text-right tbl_srl_10',
            rateClass: 'text-right tbl_srl_10',
            totalClass: 'text-right tbl_srl_10',
        };
        inputValuesArrayRawStockCosting = inputValuesArrayParam;
        validateInputIdArrayRawStockCosting = [
            e.id,
        ];

        let displayText = new displayValuesInTable(inputValuesArrayRawStockCosting, idForShowAndGetDataRawStockCosting);
        displayText.onlyForRawStockCosting(e, tableColumnsClasseArrayRawStockCosting, validateInputIdArrayRawStockCosting);
        inputValuesArray = [];
    }





</script>



@endsection
