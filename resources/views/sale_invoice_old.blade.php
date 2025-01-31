@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Sale Invoice</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <a class="add_btn list_link add_more_button" href="{{ route('sale_invoice_list') }}" role="button">
                                <i class="fa fa-list"></i> Sale Invoice
                            </a>

                            <a class="add_btn list_link add_more_button" href="{{ route('sale_tax_sale_invoice_list') }}" role="button">
                                <i class="fa fa-list"></i> Sale Sale Tax Invoice
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->



                <form name="f1" class="f1" id="f1" action="{{ route('submit_sale_invoice') }}" onsubmit="return popvalidation()" method="post" autocomplete="off">
                @csrf
                <!-- lower row starts here -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12"> <!-- left column starts here  -->
                            <!-- ******************** upper row added here ****************-->

                            <div class=""><!-- search_form  -->
                                <div class="row">  <!--  new row starts here -->

                                    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12 hidden">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">Code</label>
                                            <select name="account_code" class="inputs_up form-control" id="account_code">
                                                <option value="0">Code</option>
                                                @foreach($accounts as $account)
                                                    <option value="{{$account->account_uid}}">
                                                        {{$account->account_uid}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12 hidden">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                Code
                                                <a href="{{ route('add_product') }}" class="add_btn" target="_blank">
                                                    <i class="fa fa-plus"></i> Add
                                                </a>
                                            </label>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12 hidden">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                Product Name
                                                <a href="{{ route('add_product') }}" class="add_btn" target="_blank">
                                                    <i class="fa fa-plus"></i> Add
                                                </a>
                                            </label>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">Transaction Type</label>
                                            <select name="transaction_type" class="inputs_up form-control js-example-basic-multiple" id="transaction_type">
                                                <option value="1">Party or Cash</option>
                                                <option value="2">Credit Card</option>
                                            </select>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12" id="machine_card" style="display: none;">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">Credit Card Machine
                                                <a href="{{ url('add_credit_card_machine') }}" class="add_btn" target="_blank">
                                                    <l class="fa fa-plus"></l>
                                                    Add
                                                </a>
                                                <a id="refresh_machine" class="add_btn" style="margin-right:50px;width:65px">
                                                    <l class="fa fa-refresh"></l>
                                                    Refresh
                                                </a>
                                            </label>
                                            <select name="machine" class="inputs_up form-control js-example-basic-multiple" id="machine">
                                                <option value="">Select Machine</option>
                                                @foreach($machines as $machine)
                                                    <option value="{{$machine->ccm_id}}"
                                                            data-bank="{{$machine->ccm_bank_code}}" data-percentage="{{$machine->ccm_percentage}}"
                                                            data-service_account="{{$machine->ccm_service_account_code}}">{{$machine->ccm_title}}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12" id="account_div">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">Account Name
                                                <a href="{{ url('account_registration') }}" class="add_btn" target="_blank">
                                                    <l class="fa fa-plus"></l>
                                                    Add
                                                </a>
                                                <a id="refresh_account_name" class="add_btn" style="margin-right:50px;width:65px">
                                                    <l class="fa fa-refresh"></l>
                                                    Refresh
                                                </a>
                                            </label>
                                            <select name="account_name" class="inputs_up form-control js-example-basic-multiple" id="account_name">
                                                <option value="0">Party Name</option>
                                                @foreach($accounts as $account)
                                                    <option value="{{$account->account_uid}}">{{$account->account_name}}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="">Packages

                                                <a href="{{ url('product_packages') }}" class="add_btn" target="_blank">
                                                    <l class="fa fa-plus"></l> Add
                                                </a>
                                                <a id="refresh_package" class="add_btn" style="margin-right:50px;width:65px">
                                                    <l class="fa fa-refresh"></l>
                                                    Refresh
                                                </a>

                                            </label>
                                            <select name="package" class="inputs_up form-control js-example-basic-multiple" id="package">
                                                <option value="0">Select Package</option>
                                                @foreach($packages as $package)
                                                    <option value="{{$package->pp_id}}">{{$package->pp_name}}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Remarks</label>
                                            <input type="text" name="remarks" class="inputs_up form-control" id="remarks" placeholder="Remarks">
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Party Reference</label>
                                            <input type="text" name="customer_name" class="inputs_up form-control" id="customer_name" placeholder="Party Reference">
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Customer Email</label>
                                            <input type="text" name="customer_email" class="inputs_up form-control" id="customer_email" placeholder="Customer Email">
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Customer Phone Number</label>
                                            <input type="text" name="customer_phone_number" class="inputs_up form-control" id="customer_phone_number" placeholder="Customer Phone Number">
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Credit Card Number</label>
                                            <input type="text" name="credit_card_number" class="inputs_up form-control" id="credit_card_number" placeholder="Credit Card Number" onkeypress="return allowOnlyNumber(event);">
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Invoice Type</label>
                                            <input type="radio" name="invoice_type" style="display: inline !important; width: 50px !important;" class="inputs_up form-control invoice_type" id="invoice_type1" value="1" checked> None
                                            <input type="radio" name="invoice_type" style="display: inline !important; width: 50px !important;" class="inputs_up form-control invoice_type" id="invoice_type2" value="2">Sale Tax
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-5 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Discount Type</label>
                                            <input type="radio" name="discount_type" style="display: inline !important; width: 50px !important;" class="inputs_up form-control discount_type"
                                                   id="discount_type1" value="1" checked>None
                                            <input type="radio" name="discount_type" style="display: inline !important; width: 50px !important;" class="inputs_up form-control discount_type"
                                                   id="discount_type2" value="2">Retailer
                                            <input type="radio" name="discount_type" style="display: inline !important; width: 50px !important;" class="inputs_up form-control discount_type"
                                                   id="discount_type3" value="3">Wholesaler
                                            <input type="radio" name="discount_type" style="display: inline !important; width: 50px !important;" class="inputs_up form-control discount_type"
                                                   id="discount_type4" value="4">Loyalty Card
                                        </div><!-- end input box -->
                                    </div>

                                </div> <!-- new row ends here -->
                            </div><!-- search form end -->

                            <div class="tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active text-blue" data-toggle="tab" href="#home" role="tab" aria-selected="true">Products</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-blue" data-toggle="tab" href="#profile" role="tab" aria-selected="false">Services</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                                        <div class="pd-20">
                                            <div class="custom-checkbox mb-5">
                                                <input type="checkbox" class="custom-control-input company_info_check_box" id="add_auto" name="add_auto" value="1" checked>
                                                <label class="custom-control-label chck_pdng" for="add_auto"> Auto Add </label>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="row m-0" style="">
                                                <!-- table code starts here -->
                                                <div class="table_div table-responsive table-max-height-500px">
                                                    <table class="table table-bordered table-sm table-striped" id="category_dynamic_table">
                                                        <thead class="lower-section-thead">
                                                        <tr>
                                                            <th scope="col" class=" wdth_5">Code</th>
                                                            <th scope="col" class=" wdth_2">Product Name
                                                            <th scope="col" class=" text-right wdth_5">Qty</th>
                                                            <th scope="col" class=" text-right wdth_5">Bonus</th>
                                                            <th scope="col" class=" text-right wdth_5">Rate</th>
                                                            <th scope="col" class=" text-right wdth_5">Discount %</th>
                                                            <th scope="col" class=" text-right wdth_5 hide_sale_tax">Sale Tax %</th>
                                                            <th scope="col" class=" text-right wdth_5 hide_sale_tax">Inclusive</th>
                                                            <th scope="col" class="text-right wdth_5">Amount</th>
                                                            <th scope="col" class="w-5p text-right wdth_5">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="table_body">

                                                        <tr>
                                                            <td colspan="10" align="center"> No Product Added</td>
                                                        </tr>
                                                        </tbody>

                                                        <tfoot class="side-section">

                                                        <tr>
                                                            <td class=" wdth_5">
                                                                <a href="{{ route('add_product') }}" target="_blank" class="refresh_btn">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </a>
                                                                <a id="refresh_product_code" class="refresh_btn" style="margin-right: 5px;">
                                                                    <l class="fa fa-refresh"></l>
                                                                    Refresh
                                                                </a>
                                                                <select name="product_code" class="inputs_up form-control" id="product_code">
                                                                    <option value="0">Code</option>
                                                                </select>
                                                            </td>

                                                            <td class=" wdth_2">
                                                                <a href="{{ route('add_product') }}" target="_blank" class="refresh_btn">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </a>
                                                                <a id="refresh_product_name" class="refresh_btn" style="margin-right: 5px;">
                                                                    <l class="fa fa-refresh"></l>
                                                                    Refresh
                                                                </a>

                                                                <select name="product_name" class="inputs_up form-control" id="product_name">
                                                                    <option value="0">
                                                                        Product
                                                                    </option>
                                                                </select>

                                                                <input type="text" name="product_remarks" class="inputs_up form-control" id="product_remarks" placeholder="Remarks" style="margin-top: 5px;">
                                                            </td>

                                                            <td class=" wdth_5">
                                                                <input type="text" name="quantity" class="inputs_up text-right form-control" id="quantity" placeholder="Qty" onfocus="this.select();"
                                                                       onkeyup="product_amount_calculation();" onkeypress="return allowOnlyNumber(event);">
                                                            </td>

                                                            <td class=" wdth_5">
                                                                <input type="text" name="bonus_qty" class="inputs_up text-right form-control" id="bonus_qty" placeholder="Bonus Qty"
                                                                       onfocus="this.select();"
                                                                       onkeypress="return allowOnlyNumber(event);">
                                                            </td>

                                                            <td class=" wdth_5">
                                                                <input type="text" name="rate" class="inputs_up text-right form-control" id="rate" placeholder="Rate" onfocus="this.select();"
                                                                       onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="product_amount_calculation();">

                                                                <input type="hidden" name="product_inclusive_rate" class="inputs_up text-right form-control" id="product_inclusive_rate">
                                                            </td>

                                                            <td class=" wdth_5">
                                                                <input type="text" name="product_discount" class="inputs_up text-right form-control percentage_textbox" id="product_discount"
                                                                       placeholder="Discount %"
                                                                       onfocus="this.select();" onkeyup="product_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">

                                                                <input type="hidden" name="product_discount_amount" id="product_discount_amount" class="inputs_up text-right form-control">
                                                            </td>

                                                            <td class=" wdth_5 hide_sale_tax" style="width: 76px !important;min-width: 76px;max-width: 76px;">
                                                                <input type="text" name="product_sales_tax" class="inputs_up text-right form-control percentage_textbox" id="product_sales_tax"
                                                                       placeholder="Sale Tax %"
                                                                       onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="product_amount_calculation();">

                                                                <input type="hidden" name="product_sale_tax_amount" class="inputs_up text-right form-control" id="product_sale_tax_amount">
                                                            </td>

                                                            <td class=" wdth_5 hide_sale_tax" style="width: 76px !important;min-width: 76px;max-width: 76px;">
                                                                <input type="checkbox" name="inclusive_exclusive" class="inputs_up text-right form-control" id="inclusive_exclusive"
                                                                       onclick="product_amount_calculation();">
                                                            </td>

                                                            <td class="text-right wdth_5">
                                                                <input type="text" name="amount" class="inputs_up text-right form-control" id="amount" placeholder="Amount" min="1" readonly>
                                                            </td>

                                                            <td class="w-5p text-right wdth_5">

                                                                <button id="first_add_more" class="btn btn-success btn-sm" onclick="add_sale()" type="button">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </button>

                                                                <button style="display: none; background-color: red !important" id="cancel_button" class="btn btn-danger btn-sm" onclick="cancel_all()"
                                                                        type="button">
                                                                    <i class="fa fa-times"></i> Cancel
                                                                </button>

                                                            </td>
                                                        </tr>

                                                        <tr class="border-0">
                                                            <td colspan="12" align="right" class="border-0 p-0">
                                                                <table class="table table-bordered table-sm chk_dmnd">
                                                                    <tfoot>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label" for="round_off">Round Off</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="checkbox" name="round_off" class="inputs_up text-right form-control" id="round_off" value="1"
                                                                                   onchange="grand_total_calculation();">
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Items</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="total_items" class="text-right p-0 form-control total-items-field" id="total_items" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Price</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="total_price" class="text-right p-0 form-control" id="total_price" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Product Disc.</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="total_product_discount" class="text-right p-0 form-control" id="total_product_discount" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Round off Disc.</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="round_off_discount" class="text-right p-0 form-control" id="round_off_discount" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Cash Disc.</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="disc_percentage" class="text-right p-0 form-control percentage_textbox" id="disc_percentage"
                                                                                   placeholder="In percentage" style="padding: 1px;" onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                                   onkeyup="grand_total_calculation();" onfocus="this.select();">

                                                                            <input type="text" name="disc_amount" class="text-right p-0 form-control" id="disc_amount"
                                                                                   onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="grand_total_calculation_with_disc_amount();"
                                                                                   onfocus="this.select();">
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Disc.</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="total_discount" class="text-right p-0 form-control" id="total_discount" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr class="hide_sale_tax">
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Inc. Tax</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="total_inclusive_tax" class="text-right p-0 form-control" id="total_inclusive_tax" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr class="hide_sale_tax">
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Exc. Tax</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="total_exclusive_tax" class="text-right p-0 form-control" id="total_exclusive_tax" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr class="hide_sale_tax">
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Tax</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="total_tax" class="text-right p-0 form-control" id="total_tax" readonly>
                                                                        </td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td class="border-right-0">
                                                                            <label class="grand-total-label">Grand Total</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0">
                                                                            <input type="text" name="grand_total" class="text-right p-0 form-control grand-total-field" id="grand_total"
                                                                                   placeholder="0.00"
                                                                                   readonly>
                                                                        </td>
                                                                    </tr>


                                                                    </tfoot>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        </tfoot>
                                                    </table>
                                                    <!-- table code ends here -->
                                                </div> <!-- responsive table div ends here -->

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="profile" role="tabpanel">
                                        <div class="pd-20">

                                            <div class="clearfix"></div>

                                            <div class="row m-0" style="">
                                                <!-- table code starts here -->
                                                <div class="table_div table-responsive table-max-height-500px">
                                                    <table class="table table-bordered table-sm table-striped" id="category_dynamic_table">
                                                        <thead class="lower-section-thead">
                                                        <tr>
                                                            <th scope="col" class=" wdth_5" hidden>Code</th>
                                                            <th scope="col" class=" wdth_2">Services Name</th>
                                                            <th scope="col" class="text-right wdth_5">Qty</th>
                                                            <th scope="col" class="text-right wdth_5">Rate</th>
                                                            <th scope="col" class="text-right wdth_5">Discount %</th>
                                                            <th scope="col" class="text-right wdth_5 hide_sale_tax">Sale Tax %</th>
                                                            <th scope="col" class=" text-right wdth_5 hide_sale_tax">Inclusive</th>
                                                            <th scope="col" class="text-right wdth_5">Amount</th>
                                                            <th scope="col" class="w-5p text-right wdth_5">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="service_table_body">

                                                        <tr>
                                                            <td colspan="10" align="center"> No Service Added</td>
                                                        </tr>
                                                        </tbody>

                                                        <tfoot class="side-section">

                                                        <tr>
                                                            <td class=" wdth_5" hidden>
                                                                <select name="service_code" class="inputs_up form-control hidden" id="service_code">
                                                                    <option value="0">Code</option>
                                                                </select>

                                                            </td>
                                                            <td class=" wdth_2">

                                                                <select name="service_name" class="inputs_up form-control" id="service_name">
                                                                    <option value="0">Select</option>
                                                                </select>

                                                                <input type="text" name="service_remarks" class="inputs_up form-control" id="service_remarks" placeholder="Remarks"
                                                                       style="margin-top: 5px;">


                                                            </td>
                                                            <td class=" wdth_5" hidden>
                                                            </td>

                                                            <td class=" wdth_5">
                                                                <input type="text" name="service_quantity" class="inputs_up inputs_up_invoice  text-right form-control" id="service_quantity"
                                                                       placeholder="Qty"
                                                                       onfocus="this.select();" onkeyup="service_amount_calculation();" onkeypress="return allowOnlyNumber(event);">

                                                            </td>

                                                            <td class=" wdth_5">
                                                                <input type="text" name="service_rate" class="inputs_up inputs_up_invoice  text-right form-control" id="service_rate" placeholder="Rate"
                                                                       onfocus="this.select();" onkeyup="service_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">

                                                                <input type="hidden" name="service_inclusive_rate" class="inputs_up text-right form-control" id="service_inclusive_rate">

                                                            </td>

                                                            <td class=" wdth_5">
                                                                <input type="text" name="service_discount" class="inputs_up text-right form-control percentage_textbox" id="service_discount"
                                                                       placeholder="Discount %"
                                                                       onfocus="this.select();" onkeyup="service_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">

                                                                <input type="hidden" name="service_discount_amount" id="service_discount_amount" class="inputs_up text-right form-control">
                                                            </td>

                                                            <td class=" wdth_5 hide_sale_tax">
                                                                <input type="text" name="service_sales_tax" class="inputs_up text-right form-control percentage_textbox" id="service_sales_tax"
                                                                       placeholder="Sales Tax %"
                                                                       onfocus="this.select();" onkeyup="service_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">

                                                                <input type="hidden" name="service_sale_tax_amount" class="inputs_up text-right form-control" id="service_sale_tax_amount">
                                                            </td>

                                                            <td class=" wdth_5 hide_sale_tax" style="width: 76px !important;min-width: 76px;max-width: 76px;">
                                                                <input type="checkbox" name="service_inclusive_exclusive" class="inputs_up text-right form-control" id="service_inclusive_exclusive"
                                                                       onclick="service_amount_calculation();">
                                                            </td>

                                                            <td class="text-right wdth_5">
                                                                <input type="text" name="service_amount" class="inputs_up inputs_up_invoice text-right form-control" id="service_amount"
                                                                       placeholder="Amount"
                                                                       readonly>

                                                            </td>
                                                            <td class="w-5p text-right wdth_5">

                                                                <button id="service_first_add_more" class="btn btn-success btn-sm" onclick="add_service()" type="button">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </button>

                                                                <button style="display: none; background-color: red !important" id="service_cancel_button" class="btn btn-danger btn-sm"
                                                                        onclick="service_cancel_all()"
                                                                        type="button">
                                                                    <i class="fa fa-times"></i> Cancel
                                                                </button>

                                                            </td>
                                                        </tr>

                                                        <tr class="border-0">
                                                            <td colspan="12" align="right" class="border-0 p-0">
                                                                <table class="table table-bordered table-sm chk_dmnd">
                                                                    <tfoot>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label" for="round_off">Round Off</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="checkbox" name="service_round_off" class="inputs_up text-right form-control" id="service_round_off" value="1"
                                                                                   onchange="service_grand_total_calculation();">
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Items</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="service_total_items" class="text-right p-0 form-control total-items-field" id="service_total_items"
                                                                                   readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Price</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="service_total_price" class="text-right p-0 form-control" id="service_total_price" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Service Disc.</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="total_service_discount" class="text-right p-0 form-control" id="total_service_discount" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Round off Disc.</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="service_round_off_discount" class="text-right p-0 form-control" id="service_round_off_discount"
                                                                                   readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Cash Disc.</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="service_disc_percentage" class="text-right p-0 form-control percentage_textbox"
                                                                                   id="service_disc_percentage"
                                                                                   placeholder="In percentage" style="padding: 1px;" onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                                   onkeyup="service_grand_total_calculation();" onfocus="this.select();">

                                                                            <input type="text" name="service_disc_amount" class="text-right p-0 form-control" id="service_disc_amount"
                                                                                   onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                                   onkeyup="service_grand_total_calculation_with_disc_amount();"
                                                                                   onfocus="this.select();">
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Disc.</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="service_total_discount" class="text-right p-0 form-control" id="service_total_discount" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr class="hide_sale_tax">
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Inc. Tax</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="service_total_inclusive_tax" class="text-right p-0 form-control" id="service_total_inclusive_tax"
                                                                                   readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr class="hide_sale_tax">
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Exc. Tax</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="service_total_exclusive_tax" class="text-right p-0 form-control" id="service_total_exclusive_tax"
                                                                                   readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <tr class="hide_sale_tax">
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Tax</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="text" name="service_total_tax" class="text-right p-0 form-control" id="service_total_tax" readonly>
                                                                        </td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td class="border-right-0">
                                                                            <label class="grand-total-label">Grand Total</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0">
                                                                            <input type="text" name="service_grand_total" class="text-right p-0 form-control grand-total-field" id="service_grand_total"
                                                                                   placeholder="0.00"
                                                                                   readonly>
                                                                        </td>
                                                                    </tr>


                                                                    </tfoot>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        </tfoot>
                                                    </table>
                                                    <!-- table code ends here -->
                                                </div> <!-- responsive table div ends here -->

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div> <!-- left column ends here -->
                        </div>
                    </div>

                    <div class="row"> <!-- lower -->

                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="">Total Product Discount</label>
                                    <input type="text" name="inv_total_pro_disc" class="inputs_up form-control" id="inv_total_pro_disc" placeholder="Total Product Discount" readonly>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="">Total Service Discount</label>
                                    <input type="text" name="inv_total_ser_disc" class="inputs_up form-control" id="inv_total_ser_disc" placeholder="Total Service Discount" readonly>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="">Total Invoice Discount</label>
                                    <input type="text" name="inv_total_disc" class="inputs_up form-control" id="inv_total_disc" placeholder="Total Invoice Discount" readonly>
                                </div><!-- end input box -->
                            </div>
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="">Total Product Tax</label>
                                    <input type="text" name="inv_total_product_tax" class="inputs_up form-control" id="inv_total_product_tax" placeholder="Total Product Tax" readonly>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="">Total Service Tax</label>
                                    <input type="text" name="inv_total_service_tax" class="inputs_up form-control" id="inv_total_service_tax" placeholder="Total Service Tax" readonly>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="">Total Invoice Tax</label>
                                    <input type="text" name="inv_total_tax" class="inputs_up form-control" id="inv_total_tax" placeholder="Total Invoice Tax" readonly>
                                </div><!-- end input box -->
                            </div>
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="">Invoice Grand Total</label>
                                    <input type="text" name="inv_grand_total" class="inputs_up form-control" id="inv_grand_total" placeholder="Invoice Grand Total" readonly>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="">Invoice Cash Received</label>
                                    <input type="text" name="cash_paid" class="inputs_up form-control" id="cash_paid" placeholder="Invoice Cash Received" onkeyup="grand_total_calculation();"
                                           onkeypress="return allow_only_number_and_decimals(this,event);"
                                           onfocus="this.select();">
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="">Invoice Cash Return</label>
                                    <input type="text" name="cash_return" class="inputs_up form-control" id="cash_return" placeholder="Invoice Cash Return" readonly>
                                </div><!-- end input box -->
                            </div>
                        </div>

                    </div>

                    <div class="row"> <!-- lower -->
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <div class="form_controls">

                                <button type="submit" name="save" id="save" class="save_button form-control" onclick="return popvalidation()">
                                    <i class="fa fa-floppy-o"></i> Save
                                </button>
                                <span id="check_product_count" class="validate_sign"></span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="sales_array" id="sales_array">
                    <input type="hidden" name="services_array" id="services_array">
                    <input type="hidden" name="account_name_text" id="account_name_text">
                    <input type="hidden" name="percentage" id="percentage">
                    <input type="hidden" name="machine_name" id="machine_name">
                    <input type="hidden" name="bank_account_code" id="bank_account_code">
                    <input type="hidden" name="service_account" id="service_account">
                </form>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->
    <div class="invoice_overlay"></div>
@endsection

@section('scripts')

    <script>
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

                    console.log(data);

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

                    console.log(data);

                    jQuery("#machine").html(" ");
                    jQuery("#machine").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_account_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_sale_account_name",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    console.log(data);

                    jQuery("#account_code").html(" ");
                    jQuery("#account_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_account_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_sale_account_name",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    console.log(data);

                    jQuery("#account_name").html(" ");
                    jQuery("#account_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });


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

        jQuery("#refresh_product_name").click(function () {

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

        jQuery("#refresh_product_name").click(function () {

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
    </script>

    <script>

        function invoice_total() {
            var product_total_discount = jQuery("#total_discount").val();
            var service_total_discount = jQuery("#service_total_discount").val();

            var inv_total_discount = +product_total_discount + +service_total_discount;

            jQuery("#inv_total_pro_disc").val(product_total_discount);
            jQuery("#inv_total_ser_disc").val(service_total_discount);
            jQuery("#inv_total_disc").val(inv_total_discount.toFixed(2));

            var product_total_tax = jQuery("#total_tax").val();
            var service_total_tax = jQuery("#service_total_tax").val();

            var inv_total_total_tax = +product_total_tax + +service_total_tax;

            jQuery("#inv_total_product_tax").val(product_total_tax);
            jQuery("#inv_total_service_tax").val(service_total_tax);
            jQuery("#inv_total_tax").val(inv_total_total_tax.toFixed(2));

            var product_grand_total = jQuery("#grand_total").val();
            var service_grand_total = jQuery("#service_grand_total").val();

            var inv_grand_total = +product_grand_total + +service_grand_total;

            jQuery("#inv_grand_total").val(inv_grand_total.toFixed(2));
        }


        jQuery("#transaction_type").change(function () {

            var transaction_type = jQuery('option:selected', this).val();

            jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
            $("#account_name").trigger("change");

            jQuery("#bank_account_code").val('');
            jQuery("#percentage").val('');
            jQuery("#machine_name").val('');
            jQuery("#service_account").val('');

            if (transaction_type == 2) {

                jQuery('#account_div').hide();
                jQuery('#machine_card').show();

            } else {

                jQuery('#account_div').show();
                jQuery('#machine_card').hide();
            }
        });

    </script>

    <script>
        jQuery("#machine").change(function () {

            var account = jQuery('option:selected', this).attr('data-bank');
            var machine_name = jQuery("#machine option:selected").text();
            var percentage = jQuery('option:selected', this).attr('data-percentage');
            var service_account = jQuery('option:selected', this).attr('data-service_account');

            jQuery("#bank_account_code").val(account);
            jQuery("#percentage").val(percentage);
            jQuery("#machine_name").val(machine_name);
            jQuery("#service_account").val(service_account);
        });
    </script>

    {{--//////////////////////////////////////////////////////////////////// Start Sale Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}
    <script>
        // adding sales into table
        var numberofsales = 0;
        var counter = 0;
        var sales_array = {};
        var global_id_to_edit = 0;
        var total_discount = 0;

        function product_amount_calculation() {
            var quantity = jQuery("#quantity").val();
            var rate = jQuery("#rate").val();
            var product_discount = jQuery("#product_discount").val();
            var product_sales_tax = jQuery("#product_sales_tax").val();

            var product_sale_tax_amount;
            var product_rate_after_discount;
            var product_inclusive_rate;
            var product_discount_amount;


            if ($('#inclusive_exclusive').prop("checked") == true) {

                product_discount_amount = (((rate / (+product_sales_tax + +100) * 100)) * product_discount / 100) * quantity;

                product_rate_after_discount = rate - (product_discount_amount / quantity);

                product_inclusive_rate = ((rate / (+product_sales_tax + +100)) * 100) - ((rate / (+product_sales_tax + +100)) * 100) * product_discount / 100;

                product_sale_tax_amount = (rate - ((rate / (+product_sales_tax + +100)) * 100)) * quantity;

            } else {

                product_discount_amount = (rate * product_discount / 100) * quantity;

                product_rate_after_discount = rate - (product_discount_amount / quantity);

                product_inclusive_rate = product_rate_after_discount;

                product_sale_tax_amount = (product_rate_after_discount * product_sales_tax / 100) * quantity;
            }

            var amount = (quantity * product_inclusive_rate) + product_sale_tax_amount;

            jQuery("#amount").val(amount.toFixed(2));
            jQuery("#product_sale_tax_amount").val(product_sale_tax_amount.toFixed(2));
            jQuery("#product_inclusive_rate").val(product_inclusive_rate.toFixed(2));
            jQuery("#product_discount_amount").val(product_discount_amount.toFixed(2));
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

            jQuery.each(sales_array, function (index, value) {

                total_price = +total_price + +(value['product_rate'] * value['product_qty']);
                total_product_discount = +total_product_discount + +value['product_discount_amount'];

                if (value['inclusive_exclusive_status'] == 1) {

                    total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +value['product_sale_tax_amount'];

                } else {
                    total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +value['product_sale_tax_amount'];
                }

                total_sale_tax_amount = +total_sale_tax_amount + +value['product_sale_tax_amount'];

                grand_total = +grand_total + +value['product_amount'];

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

            cash_return_calculation();
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

            jQuery.each(sales_array, function (index, value) {

                total_price = +total_price + +(value['product_rate'] * value['product_qty']);
                total_product_discount = +total_product_discount + +value['product_discount_amount'];

                if (value['inclusive_exclusive_status'] == 1) {

                    total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +value['product_sale_tax_amount'];

                } else {
                    total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +value['product_sale_tax_amount'];
                }

                total_sale_tax_amount = +total_sale_tax_amount + +value['product_sale_tax_amount'];

                grand_total = +grand_total + +value['product_amount'];

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

            cash_return_calculation();
        }

        // jQuery("#account_code").change(function () {
        //
        //     jQuery("#account_name").select2("destroy");
        //
        //     var pname = jQuery('option:selected', this).val();
        //     jQuery("#account_name").children("option[value^=" + pname + "]");
        //
        //     jQuery('#account_name option[value="' + pname + '"]').prop('selected', true);
        //
        //     var account_name = jQuery("#account_name option:selected").text();
        //     if (pname > 0) {
        //         jQuery("#account_name_text").val(account_name);
        //     } else {
        //         jQuery("#account_name_text").val('');
        //     }
        //     jQuery("#account_name").select2();
        //
        // });

        jQuery("#account_name").change(function () {

            jQuery("#account_code").select2("destroy");
            var pcode = jQuery('option:selected', this).val();

            jQuery("#account_code").children("option[value^=" + pcode + "]");

            jQuery('#account_code option[value="' + pcode + '"]').prop('selected', true);

            var account_name = jQuery("#account_name option:selected").text();

            if (pcode > 0) {
                jQuery("#account_name_text").val(account_name);
            } else {
                jQuery("#account_name_text").val('');
            }
            jQuery("#account_code").select2();
        });

        jQuery("#product_code").change(function () {

            var sale_price = jQuery('option:selected', this).attr('data-sale_price');
            var pname = jQuery('option:selected', this).val();

            var tax = jQuery('#product_code option:selected').attr('data-tax');
            var discount;

            if ($(".invoice_type").is(':checked')) {
                if ($(".invoice_type:checked").val() == 1) {
                    tax = 0;
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

            jQuery("#product_discount").val(discount);
            jQuery("#product_sales_tax").val(tax);


            jQuery("#quantity").val('1');

            jQuery("#product_name").select2("destroy");
            jQuery("#product_name").children("option[value^=" + pname + "]");

            jQuery('#product_name option[value="' + pname + '"]').prop('selected', true);

            jQuery("#rate").val(sale_price);

            product_amount_calculation();

            jQuery("#product_name").select2();

            if ($("#add_auto").is(':checked')) {
                $("#first_add_more").click();  // checked
                // jQuery("#product_code").focus();
                // setTimeout(function () {
                // jQuery("#product_code").focus();
                // $('#product_code').select2('open');
                // }, 100);
            }

        });

        jQuery("#product_name").change(function () {

            var sale_price = jQuery('option:selected', this).attr('data-sale_price');
            var pcode = jQuery('option:selected', this).val();

            var tax = jQuery('#product_name option:selected').attr('data-tax');
            var discount;

            if ($(".invoice_type").is(':checked')) {
                if ($(".invoice_type:checked").val() == 1) {
                    tax = 0;
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

            jQuery("#product_discount").val(discount);
            jQuery("#product_sales_tax").val(tax);

            jQuery("#quantity").val('1');

            jQuery("#product_code").select2("destroy");

            jQuery("#product_code").children("option[value^=" + pcode + "]");

            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);

            jQuery("#rate").val(sale_price);

            product_amount_calculation();

            jQuery("#product_code").select2();

            if ($("#add_auto").is(':checked')) {
                $("#first_add_more").click();  // checked
                // jQuery("#product_code").focus();
                // setTimeout(function () {
                // jQuery("#product_code").focus();
                //
                // $('#product_code').select2('open');

                // }, 100);
            }
        });

        jQuery('.discount_type').change(function () {

            if ($(this).is(':checked')) {

                $.each(sales_array, function (index, value) {

                        if (index != 0) {
                            jQuery("#" + index).remove();

                            delete sales_array[index];
                        }
                        counter++;

                        var selected_code_value = value['product_code'];
                        var product_name = value['product_name'];
                        var qty = value['product_qty'];
                        var bonus_qty = value['product_bonus_qty'];
                        var selected_rate = value['product_rate'];
                        var product_inclusive_rate = 0;
                        var product_discount = value['product_discount'];
                        var product_discount_amount = 0;
                        var product_sales_tax = value['product_sale_tax'];
                        var product_sale_tax_amount = value['product_sale_tax_amount'];
                        var selected_remarks = value['product_remarks'];
                        var product_rate_after_discount;

                        var selected_amount = 0;

                        jQuery('#product_code option[value="' + selected_code_value + '"]').prop('selected', true);

                        if ($(".discount_type:checked").val() == 1) {
                            product_discount = 0;
                        } else if ($(".discount_type:checked").val() == 2) {
                            product_discount = jQuery('#product_code option:selected').attr('data-retailer_dis');
                        } else if ($(".discount_type:checked").val() == 3) {
                            product_discount = jQuery('#product_code option:selected').attr('data-whole_saler_dis');
                        } else if ($(".discount_type:checked").val() == 4) {
                            product_discount = jQuery('#product_code option:selected').attr('data-loyalty_dis');
                        }


                        if ($('#inclusive_exclusive').prop("checked") == true) {

                            product_discount_amount = (((selected_rate / (+product_sales_tax + +100) * 100)) * product_discount / 100) * qty;

                            product_rate_after_discount = selected_rate - (product_discount_amount / qty);

                            product_inclusive_rate = ((selected_rate / (+product_sales_tax + +100)) * 100) - ((selected_rate / (+product_sales_tax + +100)) * 100) * product_discount / 100;

                            product_sale_tax_amount = (selected_rate - ((selected_rate / (+product_sales_tax + +100)) * 100)) * qty;
                        } else {

                            product_discount_amount = (selected_rate * product_discount / 100) * qty;

                            product_rate_after_discount = selected_rate - (product_discount_amount / qty);

                            product_inclusive_rate = product_rate_after_discount;

                            product_sale_tax_amount = (product_rate_after_discount * product_sales_tax / 100) * qty;
                        }

                        selected_amount = (qty * product_inclusive_rate) + product_sale_tax_amount;


                        var inclusive_exclusive = '';
                        var inclusive_exclusive_status = 0;

                        if (value['inclusive_exclusive_status'] == 1) {

                            inclusive_exclusive = 'Inclusive';
                            inclusive_exclusive_status = value['inclusive_exclusive_status'];

                        } else {
                            inclusive_exclusive = 'Exclusive';
                        }


                        numberofsales = Object.keys(sales_array).length;

                        if (numberofsales == 0) {
                            jQuery("#table_body").html("");
                        }

                        sales_array[counter] = {
                            'product_code': selected_code_value,
                            'product_name': product_name,
                            'product_qty': qty,
                            'product_bonus_qty': bonus_qty,
                            'product_rate': selected_rate,
                            'product_inclusive_rate': product_inclusive_rate,
                            'product_amount': selected_amount,
                            'product_discount': product_discount,
                            'product_discount_amount': product_discount_amount,
                            'product_sale_tax': product_sales_tax,
                            'product_sale_tax_amount': product_sale_tax_amount,
                            'inclusive_exclusive_status': inclusive_exclusive_status,
                            'product_remarks': selected_remarks
                        };

                        numberofsales = Object.keys(sales_array).length;
                        var remarks_var = '';
                        if (selected_remarks != '') {
                            var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_remarks + ' </blockquote> </div>';
                        }

                        jQuery("#table_body").append('<tr id=' + counter + '><td class="wdth_1">' + selected_code_value + '</td><td > <div class="max_txt">' + product_name + '</div> <div ' +
                            'class="max_txt">' + remarks_var + '</div></td><td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + bonus_qty + '</td><td class="wdth_8 text-right">' + selected_rate + '</td><td ' +
                            'class="wdth_8 text-right">' + product_discount + '</td><td class="wdth_8 text-right hide_sale_tax">' + product_sales_tax + '</td><td class="wdth_8 text-right ' +
                            'hide_sale_tax">' + inclusive_exclusive + '</td><td class="wdth_8 ' + 'text-right">' + selected_amount + '</td><td align="right" class="wdth_4"><a ' +
                            'class="edit_link btn btn-sm btn-success" href="#" onclick=edit_sale(' + counter + ')>' + '<i class="fa fa-edit"></i></a><a href="#" ' +
                            'class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');

                        jQuery("#sales_array").val(JSON.stringify(sales_array));

                        jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);

                    }
                );
                grand_total_calculation();
                check_invoice_type();
            }
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
                        var selected_code_value = value['ppi_product_code'];

                        var qty = value['ppi_qty'];
                        var bonus_qty = 0;
                        var selected_rate = value['ppi_rate'];
                        var product_inclusive_rate;
                        var product_discount = 0;
                        var product_discount_amount;
                        var product_sales_tax = 0;
                        var product_sale_tax_amount;
                        var selected_remarks = value['ppi_remarks'];
                        var selected_amount = 0;
                        var product_rate_after_discount;

                        $.each(sales_array, function (index, entry) {

                            if (entry['product_code'].trim() == selected_code_value) {

                                if (index != 0) {
                                    jQuery("#" + index).remove();

                                    delete sales_array[index];
                                }
                                counter++;

                                qty = +entry['product_qty'] + +qty;
                            }
                        });


                        jQuery('#product_name option[value="' + selected_code_value + '"]').prop('selected', true);

                        var product_name = jQuery("#product_name option:selected").text();

                        product_sales_tax = jQuery('#product_name option:selected').attr('data-tax');

                        if ($(".invoice_type").is(':checked')) {
                            if ($(".invoice_type:checked").val() == 1) {
                                product_sales_tax = 0;
                            }
                        }

                        if ($(".discount_type:checked").val() == 1) {
                            product_discount = 0;
                        } else if ($(".discount_type:checked").val() == 2) {
                            product_discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
                        } else if ($(".discount_type:checked").val() == 3) {
                            product_discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
                        } else if ($(".discount_type:checked").val() == 4) {
                            product_discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
                        }


                        if ($('#inclusive_exclusive').prop("checked") == true) {

                            product_discount_amount = (((selected_rate / (+product_sales_tax + +100) * 100)) * product_discount / 100) * qty;

                            product_rate_after_discount = selected_rate - (product_discount_amount / qty);

                            product_inclusive_rate = ((selected_rate / (+product_sales_tax + +100)) * 100) - ((selected_rate / (+product_sales_tax + +100)) * 100) * product_discount / 100;

                            product_sale_tax_amount = (selected_rate - ((selected_rate / (+product_sales_tax + +100)) * 100)) * qty;
                        } else {

                            product_discount_amount = (selected_rate * product_discount / 100) * qty;

                            product_rate_after_discount = selected_rate - (product_discount_amount / qty);

                            product_inclusive_rate = product_rate_after_discount;

                            product_sale_tax_amount = (product_rate_after_discount * product_sales_tax / 100) * qty;
                        }
                        selected_amount = (qty * product_inclusive_rate) + product_sale_tax_amount;


                        var inclusive_exclusive = '';
                        var inclusive_exclusive_status = 0;

                        if (value['inclusive_exclusive_status'] == 1) {

                            inclusive_exclusive = 'Inclusive';
                            inclusive_exclusive_status = value['inclusive_exclusive_status'];

                        } else {
                            inclusive_exclusive = 'Exclusive';
                        }


                        numberofsales = Object.keys(sales_array).length;

                        if (numberofsales == 0) {
                            jQuery("#table_body").html("");
                        }

                        sales_array[counter] = {
                            'product_code': selected_code_value,
                            'product_name': product_name,
                            'product_qty': qty,
                            'product_bonus_qty': bonus_qty,
                            'product_rate': selected_rate,
                            'product_inclusive_rate': product_inclusive_rate,
                            'product_amount': selected_amount,
                            'product_discount': product_discount,
                            'product_discount_amount': product_discount_amount,
                            'product_sale_tax': product_sales_tax,
                            'product_sale_tax_amount': product_sale_tax_amount,
                            'inclusive_exclusive_status': inclusive_exclusive_status,
                            'product_remarks': selected_remarks
                        };

                        numberofsales = Object.keys(sales_array).length;
                        var remarks_var = '';
                        if (selected_remarks != '') {
                            var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_remarks + ' </blockquote> </div>';
                        }

                        jQuery("#table_body").append('<tr id=' + counter + '><td class="wdth_1">' + selected_code_value + '</td><td > <div class="max_txt">' + product_name + '</div> <div ' +
                            'class="max_txt">' + remarks_var + '</div></td><td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + bonus_qty + '</td><td class="wdth_8 text-right">' + selected_rate + '</td><td ' +
                            'class="wdth_8 text-right">' + product_discount + '</td><td class="wdth_8 text-right hide_sale_tax">' + product_sales_tax + '</td><td class="wdth_8 text-right ' +
                            'hide_sale_tax">' + inclusive_exclusive + '</td><td class="wdth_8 ' + 'text-right">' + selected_amount + '</td><td align="right" class="wdth_4"><a ' +
                            'class="edit_link btn btn-sm btn-success" href="#" onclick=edit_sale(' + counter + ')>' + '<i class="fa fa-edit"></i></a><a href="#" ' +
                            'class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');

                        jQuery("#sales_array").val(JSON.stringify(sales_array));
                        jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

                    });

                    jQuery("#total_items").val(numberofsales);
                    check_invoice_type();

                    grand_total_calculation();

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

        function popvalidation() {
            isDirty = true;

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var product_remarks = document.getElementById("product_remarks").value;
            var quantity = document.getElementById("quantity").value;
            var rate = document.getElementById("rate").value;
            var amount = document.getElementById("amount").value;
            var account_code = document.getElementById("account_code").value;
            var account_name = document.getElementById("account_name").value;
            var transaction_type = document.getElementById("transaction_type").value;
            var machine = document.getElementById("machine").value;
            var customer_email = document.getElementById("customer_email").value;


            var flag_submit = true;
            var focus_once = 0;

            if (transaction_type == 1) {
                if (account_code.trim() == "0") {
                    var isDirty = false;
                    if (focus_once == 0) {
                        jQuery("#account_code").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {

                }

                if (account_name.trim() == "0") {
                    var isDirty = false;

                    if (focus_once == 0) {
                        jQuery("#account_name").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            } else {
                if (machine.trim() == "0") {
                    var isDirty = false;

                    if (focus_once == 0) {
                        jQuery("#machine").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            }


            if (numberofsales == 0 && numberofservices == 0) {
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

                if (quantity == "" || quantity == 0) {
                    if (focus_once == 0) {
                        jQuery("#quantity").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (rate == "" || rate == 0) {

                    if (focus_once == 0) {
                        jQuery("#rate").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (amount == "") {

                    if (focus_once == 0) {
                        jQuery("#amount").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                document.getElementById("check_product_count").innerHTML = "Add Items";
                flag_submit = false;
            } else {
                document.getElementById("check_product_count").innerHTML = "";
            }

            return flag_submit;
        }

        function add_sale() {

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var product_remarks = document.getElementById("product_remarks").value;
            var quantity = document.getElementById("quantity").value;
            var rate = document.getElementById("rate").value;
            var amount = document.getElementById("amount").value;


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

            if (quantity == "" || quantity == 0) {

                if (focus_once1 == 0) {
                    jQuery("#quantity").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (rate == "" || rate == 0) {

                if (focus_once1 == 0) {
                    jQuery("#rate").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (amount == "") {

                if (focus_once1 == 0) {
                    jQuery("#amount").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete sales_array[global_id_to_edit];
                }

                counter++;

                jQuery("#product_code").select2("destroy");
                jQuery("#product_name").select2("destroy");

                var selected_code_value = jQuery("#product_code option:selected").attr('data-parent');
                var product_name = jQuery("#product_name option:selected").text();
                var qty = jQuery("#quantity").val();
                var bonus_qty = jQuery("#bonus_qty").val();
                var selected_rate = jQuery("#rate").val();
                var product_inclusive_rate = jQuery("#product_inclusive_rate").val();
                var product_discount = jQuery("#product_discount").val();
                var product_discount_amount = jQuery("#product_discount_amount").val();
                var product_sales_tax = jQuery("#product_sales_tax").val();
                var product_sale_tax_amount = jQuery("#product_sale_tax_amount").val();
                var selected_amount = jQuery("#amount").val();
                var selected_remarks = jQuery("#product_remarks").val();
                var product_rate_after_discount;
                var inclusive_exclusive = '';
                var inclusive_exclusive_status = 0;

                if (product_sales_tax == '') {
                    product_sales_tax = 0;
                }
                if (product_discount == '') {
                    product_discount = 0;
                }

                if (bonus_qty == '') {
                    bonus_qty = 0;
                }


                if ($('#inclusive_exclusive').prop("checked") == true) {

                    inclusive_exclusive = 'Inclusive';
                    inclusive_exclusive_status = 1;

                } else {
                    inclusive_exclusive = 'Exclusive';
                }

                $.each(sales_array, function (index, entry) {

                    if (entry['product_code'].trim() == selected_code_value) {

                        if (index != 0) {
                            jQuery("#" + index).remove();

                            delete sales_array[index];
                        }
                        counter++;

                        qty = +entry['product_qty'] + +1;

                        if ($('#inclusive_exclusive').prop("checked") == true) {

                            product_discount_amount = (((selected_rate / (+product_sales_tax + +100) * 100)) * product_discount / 100) * qty;

                            product_rate_after_discount = selected_rate - (product_discount_amount / qty);

                            product_inclusive_rate = ((selected_rate / (+product_sales_tax + +100)) * 100) - ((selected_rate / (+product_sales_tax + +100)) * 100) * product_discount / 100;

                            product_sale_tax_amount = (selected_rate - ((selected_rate / (+product_sales_tax + +100)) * 100)) * qty;
                        } else {

                            product_discount_amount = (selected_rate * product_discount / 100) * qty;

                            product_rate_after_discount = selected_rate - (product_discount_amount / qty);

                            product_inclusive_rate = product_rate_after_discount;

                            product_sale_tax_amount = (product_rate_after_discount * product_sales_tax / 100) * qty;
                        }

                        selected_amount = (qty * product_inclusive_rate) + product_sale_tax_amount;
                    }
                });


                numberofsales = Object.keys(sales_array).length;

                if (numberofsales == 0) {
                    jQuery("#table_body").html("");
                }


                sales_array[counter] = {
                    'product_code': selected_code_value,
                    'product_name': product_name,
                    'product_qty': qty,
                    'product_bonus_qty': bonus_qty,
                    'product_rate': selected_rate,
                    'product_inclusive_rate': product_inclusive_rate,
                    'product_amount': selected_amount,
                    'product_discount': product_discount,
                    'product_discount_amount': product_discount_amount,
                    'product_sale_tax': product_sales_tax,
                    'product_sale_tax_amount': product_sale_tax_amount,
                    'inclusive_exclusive_status': inclusive_exclusive_status,
                    'product_remarks': selected_remarks
                };

                numberofsales = Object.keys(sales_array).length;
                var remarks_var = '';
                if (selected_remarks != '') {
                    var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_remarks + ' </blockquote> </div>';
                }

                jQuery("#table_body").append('<tr id=' + counter + '><td class="wdth_1">' + selected_code_value + '</td><td > <div class="max_txt">' + product_name + '</div> <div class="max_txt">' +
                    remarks_var + '</div></td><td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + bonus_qty + '</td><td class="wdth_8 text-right">' + selected_rate + '</td><td class="wdth_8 text-right">' +
                    product_discount + '</td><td class="wdth_8 text-right hide_sale_tax">' + product_sales_tax + '</td><td class="wdth_8 text-right hide_sale_tax">' + inclusive_exclusive +
                    '</td><td class="wdth_8 ' + 'text-right">' + selected_amount + '</td><td align="right" class="wdth_4"><a ' + 'class="edit_link btn btn-sm btn-success" href="#" ' +
                    'onclick=edit_sale(' + counter + ')>' + '<i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');

                jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#quantity").val("");
                jQuery("#bonus_qty").val("");
                jQuery("#product_remarks").val("");
                jQuery("#rate").val("");
                jQuery("#product_inclusive_rate").val("");
                jQuery("#amount").val("");
                jQuery("#product_discount").val("");
                jQuery("#product_discount_amount").val("");
                jQuery("#product_sales_tax").val("");
                jQuery("#product_sale_tax_amount").val("");
                jQuery('#inclusive_exclusive').prop('checked', false);

                jQuery("#sales_array").val(JSON.stringify(sales_array));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#total_items").val(numberofsales);

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();

                jQuery("#product_code").select2();
                jQuery("#product_name").select2();

                check_invoice_type();

                grand_total_calculation();
            }
        }

        function delete_sale(current_item) {

            jQuery("#" + current_item).remove();

            delete sales_array[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#sales_array").val(JSON.stringify(sales_array));

            if (isEmpty(sales_array)) {
                numberofsales = 0;
            }

            var number_of_sales = Object.keys(sales_array).length;
            jQuery("#total_items").val(number_of_sales);

            check_invoice_type();

            grand_total_calculation();

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
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

            var temp_sales_array = sales_array[current_item];

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");


            // jQuery("#product_code").children("option[value^=" + temp_sales_array[0] + "]").show(); //showing hid unit

            jQuery('#product_code option[value="' + temp_sales_array['product_code'] + '"]').prop('selected', true);


            jQuery("#product_name").val(temp_sales_array['product_code']);
            jQuery("#quantity").val(temp_sales_array['product_qty']);
            jQuery("#bonus_qty").val(temp_sales_array['product_bonus_qty']);
            jQuery("#rate").val(temp_sales_array['product_rate']);
            jQuery("#product_inclusive_rate").val(temp_sales_array['product_inclusive_rate']);
            jQuery("#amount").val(temp_sales_array['product_amount']);
            jQuery("#product_discount").val(temp_sales_array['product_discount']);
            jQuery("#product_discount_amount").val(temp_sales_array['product_discount_amount']);
            jQuery("#product_sales_tax").val(temp_sales_array['product_sale_tax']);
            jQuery("#product_sale_tax_amount").val(temp_sales_array['product_sale_tax_amount']);
            jQuery("#product_remarks").val(temp_sales_array['product_remarks']);

            var inclusive_exclusive_status = temp_sales_array['inclusive_exclusive_status'];

            if (inclusive_exclusive_status == 1) {
                jQuery('#inclusive_exclusive').prop('checked', true);
            }

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();


            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");

            check_invoice_type();
        }

        function cancel_all() {

            var newvaltohide = jQuery("#product_code").val();

            jQuery("#quantity").val("");

            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);


            jQuery("#product_code").select2("destroy");


            jQuery("#quantity").val("");
            jQuery("#bonus_qty").val("");
            jQuery("#product_remarks").val("");
            jQuery("#rate").val("");
            jQuery("#product_inclusive_rate").val("");
            jQuery("#amount").val("");
            jQuery("#product_discount").val("");
            jQuery("#product_discount_amount").val("");
            jQuery("#product_sales_tax").val("");
            jQuery("#product_sale_tax_amount").val("");
            jQuery('#inclusive_exclusive').prop('checked', false);

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

            check_invoice_type();
        }

        jQuery("#cash_paid").keyup(function () {

            cash_return_calculation();
        });

        function cash_return_calculation() {
            var cash_paid = jQuery("#cash_paid").val();
            var grand_total = jQuery("#grand_total").val();
            var service_grand_total = jQuery("#service_grand_total").val();

            var cash_return = (+grand_total + +service_grand_total) - cash_paid;

            jQuery("#cash_return").val(cash_return.toFixed(2));

            invoice_total();
        }
    </script>
    {{--//////////////////////////////////////////////////////////////////// End Sale Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}

    {{--//////////////////////////////////////////////////////////////////// Start Service Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}

    <script>

        // adding services into table
        var numberofservices = 0;
        var service_counter = 0;
        var services_array = {};
        var service_global_id_to_edit = 0;
        var service_total_discount = 0;
        var edit_service_value = '';

        function service_amount_calculation() {
            var quantity = jQuery("#service_quantity").val();
            var rate = jQuery("#service_rate").val();
            var service_discount = jQuery("#service_discount").val();
            var service_sales_tax = jQuery("#service_sales_tax").val();

            var service_sale_tax_amount;
            var service_rate_after_discount;
            var service_inclusive_rate;
            var service_discount_amount;


            if ($('#service_inclusive_exclusive').prop("checked") == true) {

                service_discount_amount = (((rate / (+service_sales_tax + +100) * 100)) * service_discount / 100) * quantity;

                service_rate_after_discount = rate - (service_discount_amount / quantity);

                service_inclusive_rate = ((rate / (+service_sales_tax + +100)) * 100) - ((rate / (+service_sales_tax + +100)) * 100) * service_discount / 100;

                service_sale_tax_amount = (rate - ((rate / (+service_sales_tax + +100)) * 100)) * quantity;

            } else {

                service_discount_amount = (rate * service_discount / 100) * quantity;

                service_rate_after_discount = rate - (service_discount_amount / quantity);

                service_inclusive_rate = service_rate_after_discount;

                service_sale_tax_amount = (service_rate_after_discount * service_sales_tax / 100) * quantity;
            }

            var amount = (quantity * service_inclusive_rate) + service_sale_tax_amount;

            jQuery("#service_amount").val(amount.toFixed(2));
            jQuery("#service_sale_tax_amount").val(service_sale_tax_amount.toFixed(2));
            jQuery("#service_inclusive_rate").val(service_inclusive_rate.toFixed(2));
            jQuery("#service_discount_amount").val(service_discount_amount.toFixed(2));
        }

        function service_grand_total_calculation() {

            var service_disc_percentage = jQuery("#service_disc_percentage").val();

            var service_total_price = 0;
            var total_service_discount = 0;
            var service_total_inclusive_sale_tax_amount = 0;
            var service_total_exclusive_sale_tax_amount = 0;
            var service_total_sale_tax_amount = 0;
            var service_grand_total = 0;
            var service_round_off_discount = 0;
            var service_disc_percentage_amount;

            jQuery.each(services_array, function (index, value) {

                service_total_price = +service_total_price + +(value['service_rate'] * value['service_qty']);
                total_service_discount = +total_service_discount + +value['service_discount_amount'];

                if (value['service_inclusive_exclusive_status'] == 1) {

                    service_total_inclusive_sale_tax_amount = +service_total_inclusive_sale_tax_amount + +value['service_sale_tax_amount'];

                } else {
                    service_total_exclusive_sale_tax_amount = +service_total_exclusive_sale_tax_amount + +value['service_sale_tax_amount'];
                }

                service_total_sale_tax_amount = +service_total_sale_tax_amount + +value['service_sale_tax_amount'];

                service_grand_total = +service_grand_total + +value['service_amount'];

            });


            service_disc_percentage_amount = (service_total_price * service_disc_percentage) / 100;

            service_total_discount = +total_service_discount + +service_disc_percentage_amount;

            service_grand_total = +(service_total_price - service_total_discount) + +service_total_exclusive_sale_tax_amount;

            var radioValue = $("input[name='service_round_off']:checked").val();

            if (radioValue == 1) {
                service_round_off_discount = service_grand_total - Math.round(service_grand_total);
            }

            service_total_discount = +service_total_discount + +service_round_off_discount;

            service_grand_total = service_grand_total - service_round_off_discount;

            jQuery("#service_total_price").val(service_total_price.toFixed(2));
            jQuery("#total_service_discount").val(total_service_discount.toFixed(2));
            jQuery("#service_round_off_discount").val(service_round_off_discount.toFixed(2));
            jQuery("#service_disc_amount").val(service_disc_percentage_amount.toFixed(2));
            jQuery("#service_total_discount").val(service_total_discount.toFixed(2));
            jQuery("#service_total_inclusive_tax").val(service_total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#service_total_exclusive_tax").val(service_total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#service_total_tax").val(service_total_sale_tax_amount.toFixed(2));
            jQuery("#service_grand_total").val(service_grand_total.toFixed(2));

            cash_return_calculation();
        }

        function service_grand_total_calculation_with_disc_amount() {

            var service_disc_percentage;
            var service_disc_amount = jQuery("#service_disc_amount").val();

            var service_total_price = 0;
            var total_service_discount = 0;
            var service_total_inclusive_sale_tax_amount = 0;
            var service_total_exclusive_sale_tax_amount = 0;
            var service_total_sale_tax_amount = 0;
            var service_grand_total = 0;
            var service_round_off_discount = 0;
            var service_disc_percentage_amount = service_disc_amount;

            jQuery.each(services_array, function (index, value) {

                service_total_price = +service_total_price + +(value['service_rate'] * value['service_qty']);
                total_service_discount = +total_service_discount + +value['service_discount_amount'];

                if (value['service_inclusive_exclusive_status'] == 1) {

                    service_total_inclusive_sale_tax_amount = +service_total_inclusive_sale_tax_amount + +value['service_sale_tax_amount'];

                } else {
                    service_total_exclusive_sale_tax_amount = +service_total_exclusive_sale_tax_amount + +value['service_sale_tax_amount'];
                }

                service_total_sale_tax_amount = +service_total_sale_tax_amount + +value['service_sale_tax_amount'];

                service_grand_total = +service_grand_total + +value['service_amount'];

            });

            service_disc_percentage = (service_disc_amount * 100) / service_total_price;

            service_total_discount = +total_service_discount + +service_disc_percentage_amount;

            service_grand_total = +(service_total_price - service_total_discount) + +service_total_exclusive_sale_tax_amount;

            var radioValue = $("input[name='service_round_off']:checked").val();

            if (radioValue == 1) {
                service_round_off_discount = service_grand_total - Math.round(service_grand_total);
            }

            service_total_discount = +service_total_discount + +service_round_off_discount;

            service_grand_total = service_grand_total - service_round_off_discount;

            jQuery("#service_total_price").val(service_total_price.toFixed(2));
            jQuery("#service_total_service_discount").val(total_service_discount.toFixed(2));
            jQuery("#service_round_off_discount").val(service_round_off_discount.toFixed(2));
            jQuery("#service_disc_percentage").val(service_disc_percentage.toFixed(2));
            jQuery("#service_total_discount").val(service_total_discount.toFixed(2));
            jQuery("#service_total_inclusive_tax").val(service_total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#service_total_exclusive_tax").val(service_total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#service_total_tax").val(service_total_sale_tax_amount.toFixed(2));
            jQuery("#service_grand_total").val(service_grand_total.toFixed(2));

            cash_return_calculation();
        }

        jQuery("#service_code").change(function () {
            var pname = jQuery('option:selected', this).val();

            jQuery("#service_quantity").val('1');

            jQuery("#service_name").select2("destroy");
            jQuery('#service_name option[value="' + pname + '"]').prop('selected', true);
            service_amount_calculation();

            jQuery("#service_name").select2();

            jQuery("#service_rate").focus();
        });

        jQuery("#service_name").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#service_quantity").val('1');

            jQuery("#service_code").select2("destroy");
            jQuery('#service_code option[value="' + pcode + '"]').prop('selected', true);
            service_amount_calculation();

            jQuery("#service_code").select2();

            jQuery("#service_rate").focus();
        });

        function add_service() {
            var service_code = document.getElementById("service_code").value;
            var service_name = document.getElementById("service_name").value;
            var service_remarks = document.getElementById("service_remarks").value;
            var service_quantity = document.getElementById("service_quantity").value;
            var service_rate = document.getElementById("service_rate").value;
            var service_amount = document.getElementById("service_amount").value;

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (service_code == "0") {
                if (focus_once1 == 0) {
                    jQuery("#service_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (service_name == "0") {
                if (focus_once1 == 0) {
                    jQuery("#service_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (service_quantity == "" || service_quantity == 0) {
                if (focus_once1 == 0) {
                    jQuery("#service_quantity").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (service_rate == "" || service_rate == 0) {

                if (focus_once1 == 0) {
                    jQuery("#service_rate").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (service_amount == "") {


                if (focus_once1 == 0) {
                    jQuery("#service_amount").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (service_global_id_to_edit != 0) {
                    jQuery("#service" + service_global_id_to_edit).remove();

                    delete services_array[service_global_id_to_edit];
                }

                service_counter++;

                jQuery("#service_code").select2("destroy");
                jQuery("#service_name").select2("destroy");

                var service_name = jQuery("#service_name option:selected").text();
                var selected_code_value = jQuery("#service_code option:selected").val();
                var qty = jQuery("#service_quantity").val();
                var selected_remarks = jQuery("#service_remarks").val();
                var selected_rate = jQuery("#service_rate").val();
                var selected_amount = jQuery("#service_amount").val();
                var service_inclusive_rate = jQuery("#service_inclusive_rate").val();
                var service_discount = jQuery("#service_discount").val();
                var service_discount_amount = jQuery("#service_discount_amount").val();
                var service_sales_tax = jQuery("#service_sales_tax").val();
                var service_sale_tax_amount = jQuery("#service_sale_tax_amount").val();
                var service_rate_after_discount;
                var inclusive_exclusive = '';
                var inclusive_exclusive_status = 0;

                if (service_sales_tax == '') {
                    service_sales_tax = 0;
                }
                if (service_discount == '') {
                    service_discount = 0;
                }

                if ($('#service_inclusive_exclusive').prop("checked") == true) {

                    inclusive_exclusive = 'Inclusive';
                    inclusive_exclusive_status = 1;

                } else {
                    inclusive_exclusive = 'Exclusive';
                }

                numberofservices = Object.keys(services_array).length;

                if (numberofservices == 0) {
                    jQuery("#service_table_body").html("");
                }

                services_array[service_counter] = {
                    'service_code': selected_code_value,
                    'service_name': service_name,
                    'service_qty': qty,
                    'service_rate': selected_rate,
                    'service_inclusive_rate': service_inclusive_rate,
                    'service_amount': selected_amount,
                    'service_discount': service_discount,
                    'service_discount_amount': service_discount_amount,
                    'service_sale_tax': service_sales_tax,
                    'service_sale_tax_amount': service_sale_tax_amount,
                    'service_inclusive_exclusive_status': inclusive_exclusive_status,
                    'service_remarks': selected_remarks
                };

                jQuery("#service_code option[value=" + selected_code_value + "]").attr("disabled", "true");
                jQuery("#service_name option[value=" + selected_code_value + "]").attr("disabled", "true");
                numberofservices = Object.keys(services_array).length;
                var remarks_var = '';
                if (selected_remarks != '') {
                    var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_remarks + ' </blockquote> </div>';
                }


                jQuery("#service_table_body").append('<tr id=service' + service_counter + '><td class="wdth_1" hidden>' + selected_code_value + '</td><td > <div class="max_txt">' + service_name +
                    '</div>  <div ' +
                    'class="max_txt">' + remarks_var + '</div>  </td><td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + selected_rate + '</td><td class="wdth_8 text-right">' + service_discount + '</td><td class="wdth_8 ' + 'text-right hide_sale_tax">' + service_sales_tax + '</td><td class="wdth_8 text-right hide_sale_tax">' + inclusive_exclusive +
                    '</td><td class="wdth_8 text-right">' + selected_amount + '</td><td align="right" ' +
                    'class="wdth_4"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_service(' + service_counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_service(' + service_counter + ')><i class="fa fa-trash"></i></a></td></tr>');


                jQuery('#service_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#service_name option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#service_quantity").val("");
                jQuery("#service_remarks").val("");
                jQuery("#service_rate").val("");
                jQuery("#service_inclusive_rate").val("");
                jQuery("#service_amount").val("");
                jQuery("#service_discount").val("");
                jQuery("#service_discount_amount").val("");
                jQuery("#service_sales_tax").val("");
                jQuery("#service_sale_tax_amount").val("");
                jQuery('#service_inclusive_exclusive').prop('checked', false);

                jQuery("#services_array").val(JSON.stringify(services_array));
                jQuery("#service_cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#service_first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#service_total_items").val(numberofservices);

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();

                jQuery("#service_code").select2();
                jQuery("#service_name").select2();

                service_grand_total_calculation();
            }
        }

        function delete_service(current_item) {

            jQuery("#service" + current_item).remove();
            var temp_services_array = services_array[current_item];
            jQuery("#service_code option[value=" + temp_services_array['service_code'] + "]").attr("disabled", false);
            jQuery("#service_name option[value=" + temp_services_array['service_code'] + "]").attr("disabled", false);

            delete services_array[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#services_array").val(JSON.stringify(services_array));

            if (isEmpty(services_array)) {
                numberofservices = 0;
            }

            var number_of_services = Object.keys(services_array).length;
            jQuery("#service_total_items").val(number_of_services);

            service_grand_total_calculation();

            jQuery("#service_name").select2("destroy");
            jQuery("#service_name").select2();
            jQuery("#service_code").select2("destroy");
            jQuery("#service_code").select2();
        }

        function edit_service(current_item) {

            // jQuery(".table-responsive").attr("style", "display:none");

            jQuery("#service" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#service_first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#service_cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            service_global_id_to_edit = current_item;

            var temp_services_array = services_array[current_item];

            edit_service_value = temp_services_array['service_code'];

            jQuery("#service_code").select2("destroy");
            jQuery("#service_name").select2("destroy");

            jQuery("#service_code").children("option[value^=" + temp_services_array['service_code'] + "]").show(); //showing hid unit
            jQuery("#service_code option[value=" + temp_services_array['service_code'] + "]").attr("disabled", false);
            jQuery("#service_name option[value=" + temp_services_array['service_code'] + "]").attr("disabled", false);


            // jQuery("#service_code > option").each(function () {
            jQuery('#service_code option[value="' + temp_services_array['service_code'] + '"]').prop('selected', true);
            // });

            jQuery("#service_name").val(temp_services_array['service_code']);
            jQuery("#service_quantity").val(temp_services_array['service_qty']);
            jQuery("#service_rate").val(temp_services_array['service_rate']);
            jQuery("#service_inclusive_rate").val(temp_services_array['service_inclusive_rate']);
            jQuery("#service_amount").val(temp_services_array['service_amount']);
            jQuery("#service_discount").val(temp_services_array['service_discount']);
            jQuery("#service_discount_amount").val(temp_services_array['service_discount_amount']);
            jQuery("#service_sales_tax").val(temp_services_array['service_sale_tax']);
            jQuery("#service_sale_tax_amount").val(temp_services_array['service_sale_tax_amount']);
            jQuery("#service_remarks").val(temp_services_array['service_remarks']);

            var service_inclusive_exclusive_status = temp_services_array['service_inclusive_exclusive_status'];

            if (service_inclusive_exclusive_status == 1) {
                jQuery('#service_inclusive_exclusive').prop('checked', true);
            }

            jQuery("#service_code").select2();
            jQuery("#service_name").select2();

            jQuery("#service_cancel_button").attr("style", "display:inline");
            jQuery("#service_cancel_button").attr("style", "background-color:red !important");
        }

        function service_cancel_all() {

            // var newvaltohide = jQuery("#service_code").val();

            var newvaltohide = edit_service_value;

            jQuery("#service_code option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery("#service_name option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery('#service_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#service_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#service_code").select2("destroy");
            jQuery("#service_name").select2("destroy");

            jQuery("#service_quantity").val("");
            jQuery("#service_remarks").val("");
            jQuery("#service_rate").val("");
            jQuery("#service_inclusive_rate").val("");
            jQuery("#service_amount").val("");
            jQuery("#service_discount").val("");
            jQuery("#service_discount_amount").val("");
            jQuery("#service_sales_tax").val("");
            jQuery("#service_sale_tax_amount").val("");
            jQuery('#service_inclusive_exclusive').prop('checked', false);

            jQuery("#service_code").select2();
            jQuery("#service_name").select2();

            jQuery("#service_cancel_button").hide();

            // jQuery(".table-responsive").show();
            jQuery("#service" + service_global_id_to_edit).show();

            jQuery("#save").show();

            jQuery("#service_first_add_more").html('<i class="fa fa-plus"></i> Add');
            service_global_id_to_edit = 0;

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            edit_service_value = '';

        }
    </script>
    {{--//////////////////////////////////////////////////////////////////// End Service Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product_code").append("{!! $pro_code !!}");
            jQuery("#product_name").append("{!! $pro_name !!}");

            jQuery("#service_code").append("{!! $service_code !!}");
            jQuery("#service_name").append("{!! $service_name !!}");

            jQuery("#service_code").select2();
            jQuery("#service_name").select2();

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#machine").select2();
            jQuery("#package").select2();
        });

        window.addEventListener('keydown', function (e) {
            if (e.which == 113) {
                // $('#product_code').select2('open');
            }

            if (e.keyCode == 65 && e.altKey) {
                $("#first_add_more").click();
            }
        });

        // $(document).keydown(function(e) {
        //     if (e.keyCode == 65 && e.altKey) {
        //         $("#first_add_more").click();
        //     }
        // });

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });


        $('#view_detail').click(function () {

            var btn_name = jQuery("#view_detail").html();

            if (btn_name.trim() == 'View Detail') {

                jQuery("#view_detail").html('Hide Detail');
            } else {
                jQuery("#view_detail").html('View Detail');
            }
        });


        function check_invoice_type() {
            if (numberofsales == 0) {
                $('.invoice_type:not(:checked)').attr('disabled', false);
            } else {
                $('.invoice_type:not(:checked)').attr('disabled', true);
            }
        }
    </script>






    <script type="text/javascript">
        $("#invoice_btn").click(function(){
            $("#invoice_con").toggle();
            $(".invoice_overlay").toggle();
            setTimeout(function() {
                $("#invoice_bx").toggleClass("show_scale");
            }, 200);
            setTimeout(function() {
                $("#invoice_bx").toggleClass("show_rotate");
            }, 350);
        });
        $("#invoice_cls_btn").click(function(){
            setTimeout(function() {
                $("#invoice_bx").toggleClass("show_rotate");
            }, 50);
            setTimeout(function() {
                $("#invoice_bx").toggleClass("show_scale");
            }, 200);
            setTimeout(function() {
                $("#invoice_con").toggle();
                $(".invoice_overlay").toggle();
            }, 650);
        });
    </script>

@endsection

