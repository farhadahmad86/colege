<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('include/head')

</head>

<body>

@include('include/header')
@include('include/teller_sidebar')

<div class="main-container">
    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">
        @include('inc._messages')

        <div class="row">


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Sale Invoice</h4>
                            </div>
                            <div class="list_btn">
                                <a class="btn list_link add_more_button" href="{{ route('teller/sale_invoice_list') }}" role="button">
                                    <i class="fa fa-list"></i> Sale Invoice
                                </a>

                                <a class="btn list_link add_more_button" href="{{ route('teller/sale_tax_sale_invoice_list') }}" role="button">
                                    <i class="fa fa-list"></i> Sale Sale Tax Invoice
                                </a>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->


                    <form name="f1" class="f1" id="f1" action="{{ route('teller/submit_sale_invoice') }}" onsubmit="return popvalidation()" method="post" autocomplete="off">
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
{{--                                                    <option value="0">Code</option>--}}
                                                    @foreach($accounts as $account)
                                                        <option value="{{$account->account_uid}}">{{$account->account_uid}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-8 col-md-6 col-sm-12 col-xs-12 hidden">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">Remarks</label>
                                                <input type="text" name="remarks" class="inputs_up form-control" id="remarks" placeholder="Remarks">
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
                                                    <option value="1">Cash</option>
                                                    <option value="2">Credit Card</option>
                                                </select>
                                            </div><!-- end input box -->
                                        </div>

                                        {{--                                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12" id="machine_card" style="display: none;">--}}
                                        {{--                                            <div class="input_bx input_bx_invoice"><!-- start input box -->--}}
                                        {{--                                                <label class="required">--}}
                                        {{--                                                    Credit Card Machine--}}
                                        {{--                                                    <a href="{{ route('add_credit_card_machine') }}" class="add_btn" target="_blank">--}}
                                        {{--                                                        <i class="fa fa-plus"></i> Add--}}
                                        {{--                                                    </a>--}}
                                        {{--                                                </label>--}}
                                        {{--                                                <select name="machine" class="inputs_up inputs_up_invoice form-control" id="machine">--}}
                                        {{--                                                    <option value="">Select Machine</option>--}}
                                        {{--                                                    @foreach($machines as $machine)--}}
                                        {{--                                                        <option value="{{$machine->ccm_id}}"--}}
                                        {{--                                                                data-bank="{{$machine->ccm_bank_code}}" data-percentage="{{$machine->ccm_percentage}}"--}}
                                        {{--                                                                data-service_account="{{$machine->ccm_service_account_code}}">{{$machine->ccm_title}}</option>--}}
                                        {{--                                                    @endforeach--}}
                                        {{--                                                </select>--}}
                                        {{--                                                <span id="demo2" class="validate_sign"> </span>--}}
                                        {{--                                            </div><!-- end input box -->--}}
                                        {{--                                        </div>--}}

                                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12" id="machine_card" style="display: none;">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Credit Card Machine</label>
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
                                                <label class="required">Account Name</label>
                                                <select name="account_name" class="inputs_up form-control js-example-basic-multiple" id="account_name">
{{--                                                    <option value="0">Account Name</option>--}}
                                                    @foreach($accounts as $account)
                                                        <option value="{{$account->account_uid}}">{{$account->account_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- end input box -->
                                        </div>


                                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Packages</label>
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
                                                <label>Customer Name</label>
                                                <input type="text" name="customer_name" class="inputs_up form-control" id="customer_name" placeholder="Customer Name">
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>Invoice Type</label>
                                                <input type="radio" name="invoice_type" style="display: inline !important; width: 50px !important;" class="inputs_up form-control invoice_type"
                                                       id="invoice_type1"
                                                       value="1" checked> None
                                                <input type="radio" name="invoice_type" style="display: inline !important; width: 50px !important;" class="inputs_up form-control invoice_type"
                                                       id="invoice_type2"
                                                       value="2">Sale Tax
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


                                <div class="custom-checkbox mb-5">
                                    <input type="checkbox" class="custom-control-input company_info_check_box" id="add_auto" name="add_auto" value="1" checked>
                                    <label class="custom-control-label chck_pdng" for="add_auto"> Auto Add </label>
                                </div>
                                <div class="clearfix"></div>

                                <div class="row m-0" style="">
                                    <!-- table code starts here -->
                                    <div class="table_div table-responsive table-max-height-500px">
                                        <table class="table table-striped table-bordered m-0" id="category_dynamic_table">
                                            <thead class="lower-section-thead">
                                            <tr>
                                                <th scope="col" class=" wdth_5">Code</th>
                                                <th scope="col" class=" wdth_2">Product Name
                                                <th scope="col" class=" text-right wdth_5">Qty</th>
                                                <th scope="col" class=" text-right wdth_5">Rate</th>
                                                <th scope="col" class=" text-right wdth_5">Discount %</th>
                                                <th scope="col" class=" text-right wdth_5 hide_sale_tax">Sale Tax %</th>
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
                                                    <select name="product_code" class="inputs_up form-control" id="product_code">
                                                        <option value="0">Code</option>
                                                    </select>
                                                </td>
                                                <td class=" wdth_2">
                                                    <select name="product_name" class="inputs_up form-control" id="product_name">
                                                        <option value="0">Product</option>
                                                    </select>

                                                    <input type="text" name="product_remarks" class="inputs_up form-control" id="product_remarks" placeholder="Remarks" style="margin-top: 5px;">
                                                </td>
                                                <td class=" wdth_5" hidden>
                                                </td>
                                                <td class=" wdth_5">
                                                    <input type="text" name="quantity" class="inputs_up text-right form-control" id="quantity" placeholder="Qty" onfocus="this.select();"
                                                           onkeyup="product_amount_calculation();" onkeypress="return allowOnlyNumber(event);">
                                                </td>
                                                <td class=" wdth_5">
                                                    <input type="text" name="rate" class="inputs_up text-right form-control" id="rate" placeholder="Rate" onfocus="this.select();"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="product_amount_calculation();">
                                                </td>
                                                <td class=" wdth_5">
                                                    <input type="text" name="product_discount" class="inputs_up text-right form-control" id="product_discount" placeholder="Discount %"
                                                           onfocus="this.select();"
                                                           onkeyup="product_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">
                                                </td>
                                                <td class=" wdth_5 hide_sale_tax" style="width: 76px !important;min-width: 76px;max-width: 76px;">
                                                    <input type="text" name="product_sales_tax" class="inputs_up text-right form-control" id="product_sales_tax" placeholder="Sale Tax %"
                                                           onfocus="this.select();"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="product_amount_calculation();">
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
                                            </tfoot>
                                        </table>
                                        <!-- table code ends here -->
                                    </div> <!-- responsive table div ends here -->

                                </div>

                                <div class="row" style="margin-top: 40px">
                                    <h5>Add Services</h5>
                                </div>

                                <div class="clearfix"></div>

                                <div class="row m-0" style="">
                                    <!-- table code starts here -->
                                    <div class="table_div table-responsive table-max-height-500px">
                                        <table class="table table-striped table-bordered m-0" id="category_dynamic_table">
                                            <thead class="lower-section-thead">
                                            <tr>
                                                <th scope="col" class=" wdth_5" hidden>Code</th>
                                                <th scope="col" class=" wdth_2">Services Name</th>
                                                <th scope="col" class="text-right wdth_5">Qty</th>
                                                <th scope="col" class="text-right wdth_5">Rate</th>
                                                <th scope="col" class="text-right wdth_5">Discount %</th>
                                                <th scope="col" class="text-right wdth_5 hide_sale_tax">Sale Tax %</th>
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
                                                    <select name="service_code" class="inputs_up form-control hidden" id="service_code" style="display: none !important;">
                                                        <option value="0">Code</option>
                                                    </select>

                                                </td>
                                                <td class=" wdth_2">

                                                    <select name="service_name" class="inputs_up form-control" id="service_name">
                                                        <option value="0">Select</option>
                                                    </select>

                                                    <input type="text" name="service_remarks" class="inputs_up form-control" id="service_remarks" placeholder="Remarks" style="margin-top: 5px;">


                                                </td>
                                                <td class=" wdth_5" hidden>
                                                </td>
                                                <td class=" wdth_5">
                                                    <input type="text" name="service_quantity" class="inputs_up inputs_up_invoice  text-right form-control" id="service_quantity" placeholder="Qty"
                                                           onfocus="this.select();" onkeyup="service_amount_calculation();" onkeypress="return allowOnlyNumber(event);">

                                                </td>
                                                <td class=" wdth_5">
                                                    <input type="text" name="service_rate" class="inputs_up inputs_up_invoice  text-right form-control" id="service_rate" placeholder="Rate"
                                                           onkeyup="service_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">

                                                </td>
                                                <td class=" wdth_5">
                                                    <input type="text" name="service_discount" class="inputs_up text-right form-control" id="service_discount" placeholder="Discount %"
                                                           onkeyup="service_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">
                                                </td>

                                                <td class=" wdth_5 hide_sale_tax">
                                                    <input type="text" name="service_sales_tax" class="inputs_up text-right form-control" id="service_sales_tax" placeholder="Sales Tax %"
                                                           onkeyup="service_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">

                                                </td>

                                                <td class="text-right wdth_5">
                                                    <input type="text" name="service_amount" class="inputs_up inputs_up_invoice text-right form-control" id="service_amount" placeholder="Amount"
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

                                            <tr class="border-0 p-0">
                                                <td colspan="7" align="right" class="border-0 p-0">
                                                    <table class="m-0 p-0 chk_dmnd">
                                                        <tfoot>
                                                        <tr>
                                                            <td class="border-right-0  border-top-0">
                                                                <label class="total-items-label">Total Items</label>
                                                            </td>

                                                            <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                <input type="text" name="total_items" class="text-right p-0 form-control total-items-field" id="total_items"
                                                                       placeholder="0.00"
                                                                       readonly>

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
                                                        <tr>
                                                            <td class="border-right-0">
                                                                <label class="cash-received-label">Cash Received</label>
                                                            </td>

                                                            <td class="pt-0 pl-0 pb-0 border-left-0">
                                                                <input type="text" name="cash_paid" class="text-right p-0 form-control cash-received-field" id="cash_paid" placeholder="0.00"
                                                                       onkeyup="grand_total_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border-right-0">
                                                                <label class="cash-return-label">Cash Return</label>
                                                            </td>

                                                            <td class="pt-0 pl-0 pb-0 border-left-0">
                                                                <input type="text" name="cash_return" class="text-right p-0 form-control cash-return-field" id="cash_return" placeholder="0.00"
                                                                       readonly>
                                                            </td>
                                                        </tr>
                                                        <tr class="border-0">
                                                            <td colspan="2" align="right" class="p-0 m-0 border-0">
                                                                <div class="collapse w-100" id="collapseExample">
                                                                    <table class="m-0 p-0">
                                                                        <tfoot>
                                                                        <tr>
                                                                            <td class="border-right-0  border-top-0">
                                                                                <label>Total Price</label>
                                                                            </td>

                                                                            <td class="pt-0 pl-0 pb-0 border-left-0">
                                                                                <input type="text" name="total_price" class="text-right p-0 form-control" id="total_price" placeholder="0.00"
                                                                                       readonly>

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td class="border-right-0">
                                                                                <label>Expense</label>
                                                                            </td>

                                                                            <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                                <input type="text" name="expense" class="text-right p-0 form-control" id="expense" placeholder="0.00"
                                                                                       onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="grand_total_calculation();">

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td class="border-right-0">
                                                                                <label>Scheme Disc. %</label>
                                                                            </td>

                                                                            <td class="pt-0 pl-0 pb-0 border-left-0">
                                                                                <input type="text" name="disc_percentage" class="text-right p-0 form-control" id="disc_percentage"
                                                                                       placeholder="In percentage" style="padding: 1px;" onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                                       onkeyup="grand_total_calculation();">


                                                                                <input type="text" name="disc_amount" class="text-right p-0 form-control" id="disc_amount" placeholder="In
                                                                                    Amount" readonly>
                                                                            </td>
                                                                        </tr>

                                                                        <tr class="hide_sale_tax">
                                                                            <td>
                                                                                <label>Total Sale Tax</label>
                                                                            </td>

                                                                            <td class="p-0">
                                                                                <input type="number" name="sales_tax_amount" class="text-right p-0 form-control" id="sales_tax_amount"
                                                                                       placeholder=""
                                                                                       readonly>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td class="border-right-0">
                                                                                <label>Total Discount</label>
                                                                            </td>

                                                                            <td class="pt-0 pl-0 pb-0 border-left-0">
                                                                                <input type="text" name="total_discount" class="text-right p-0 form-control" id="total_discount"
                                                                                       placeholder=""
                                                                                       readonly placeholder="0.00">

                                                                            </td>
                                                                        </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="text-center">
                                                                <a href="javascript: avoid(0);" class="modal-button view_invoice" data-toggle="collapse" data-target="#collapseExample"
                                                                   aria-expanded="false" aria-controls="collapseExample" id="view_detail">
                                                                    View Detail
                                                                </a>
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


                            </div> <!-- left column ends here -->
                        </div>

                        <div class="row"> <!-- lower -->
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="form_controls">
                                    {{--                                    <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">--}}
                                    {{--                                        <i class="fa fa-eraser"></i> Cancel--}}
                                    {{--                                    </button>--}}
                                    <button type="submit" name="save" id="save" class="save_button form-control" onclick="return popvalidation()">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                    <span id="check_product_count" class="validate_sign"></span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="salesval" id="salesval">
                        <input type="hidden" name="servicesval" id="servicesval">
                        <input type="hidden" name="account_name_text" id="account_name_text">
                        <input type="hidden" name="percentage" id="percentage">
                        <input type="hidden" name="machine_name" id="machine_name">
                        <input type="hidden" name="bank_account_code" id="bank_account_code">
                        <input type="hidden" name="service_account" id="service_account">
                    </form>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->


        @include('include/footer')
    </div>
</div>

@include('include/script')

<script>
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

<script>
    function product_amount_calculation() {
        var quantity = jQuery("#quantity").val();
        var rate = jQuery("#rate").val();
        var product_discount = jQuery("#product_discount").val();
        var product_sales_tax = jQuery("#product_sales_tax").val();

        product_discount = ((rate * quantity) / 100) * product_discount;

        var amount = (rate * quantity) - product_discount;
        var sale_tax = (amount / 100) * product_sales_tax;
        amount = +amount + +sale_tax;

        jQuery("#amount").val(amount);
        // jQuery("#total_sale_tax_payable").val(sale_tax);
    }

    function grand_total_calculation() {
        var expense = jQuery("#expense").val();
        var disc_percentage = jQuery("#disc_percentage").val();

        var rate = 0;
        var total_price = 0;
        var remaining_total_amount = 0; //(qty * rate)- discount
        var sale_tax_amount = 0;
        total_discount = 0;

        var product_discount = 0;
        var service_discount = 0;

        jQuery.each(sales, function (index, value) {
            total_price = +total_price + +value[4];

            product_discount = ((value[3] * value[2]) / 100) * value[5];

            rate = (value[3] * value[2]) - product_discount;
            remaining_total_amount = +remaining_total_amount + (value[3] * value[2]) - product_discount;
            sale_tax_amount = +sale_tax_amount + +((rate / 100) * value[6]);
            total_discount = +total_discount + +product_discount;
        });

        jQuery.each(services, function (index, value) {
            total_price = +total_price + +value[4];

            service_discount = ((value[3] * value[2]) / 100) * value[5];

            rate = (value[3] * value[2]) - service_discount;
            remaining_total_amount = +remaining_total_amount + (value[3] * value[2]) - service_discount;
            sale_tax_amount = +sale_tax_amount + +((rate / 100) * value[6]);
            total_discount = +total_discount + +service_discount;
        });

        var new_sale_tax_amount = sale_tax_amount - ((sale_tax_amount / 100) * disc_percentage);
        var disc_amount = (remaining_total_amount / 100) * disc_percentage;

        var total_discount_amount = +total_discount + +disc_amount;
        var grand_total = +total_price + +expense - disc_amount;

        grand_total = grand_total - ((sale_tax_amount / 100) * disc_percentage);

        jQuery("#total_price").val(total_price);
        jQuery("#grand_total").val(grand_total);
        jQuery("#total_discount").val(total_discount_amount);
        jQuery("#sales_tax_amount").val(new_sale_tax_amount);
        jQuery("#disc_amount").val(disc_amount);


        var services_length = Object.keys(services).length;
        var sales_length = Object.keys(sales).length;

        var total_length = +services_length + +sales_length;

        jQuery("#total_items").val(total_length);

        var cash_paid = jQuery("#cash_paid").val();

        var cash_return = cash_paid - grand_total;

        jQuery("#cash_return").val(cash_return);
    }
</script>

{{--//////////////////////////////////////////////////////////////////// Service Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}

<script>
    function service_amount_calculation() {
        var quantity = jQuery("#service_quantity").val();
        var rate = jQuery("#service_rate").val();
        var service_discount = jQuery("#service_discount").val();
        var service_sales_tax = jQuery("#service_sales_tax").val();

        var amount = (rate * quantity) - service_discount;
        var sale_tax = (amount / 100) * service_sales_tax;
        amount = +amount + +sale_tax;

        jQuery("#service_amount").val(amount);
        // jQuery("#service_total_sale_tax_payable").val(sale_tax);
    }
</script>


<script>
    jQuery("#service_code").change(function () {
        var pname = jQuery('option:selected', this).val();

        jQuery("#service_name").select2("destroy");
        jQuery('#service_name option[value="' + pname + '"]').prop('selected', true);
        service_amount_calculation();

        jQuery("#service_name").select2();
    });

</script>

<script>
    jQuery("#service_name").change(function () {
        var pcode = jQuery('option:selected', this).val();

        jQuery("#service_code").select2("destroy");
        jQuery('#service_code option[value="' + pcode + '"]').prop('selected', true);
        service_amount_calculation();

        jQuery("#service_code").select2();
    });

</script>


<script>
    // adding packs into table
    var numberofservices = 0;
    var service_counter = 0;
    var services = {};
    var service_global_id_to_edit = 0;
    var service_total_discount = 0;

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
                jQuery("#" + service_global_id_to_edit).remove();

                delete services[service_global_id_to_edit];
            }

            service_counter++;

            jQuery("#service_code").select2("destroy");
            jQuery("#service_name").select2("destroy");

            var service_name = jQuery("#service_name option:selected").text();
            var selected_code_value = jQuery("#service_code option:selected").val();
            var qty = jQuery("#service_quantity").val();
            var selected_service_name = jQuery("#service_name").val();
            var selected_remarks = jQuery("#service_remarks").val();
            var selected_rate = jQuery("#service_rate").val();
            var selected_amount = jQuery("#service_amount").val();
            var service_sales_tax = document.getElementById("service_sales_tax").value;
            var service_discount = document.getElementById("service_discount").value;

            if (service_sales_tax == '') {
                service_sales_tax = 0;
            }
            if (service_discount == '') {
                service_discount = 0;
            }

            numberofservices = Object.keys(services).length;

            if (numberofservices == 0) {
                jQuery("#service_table_body").html("");
            }
            var sale_tax = 0;
            //  rate=value[4]- value[6];
            // sale_tax=+sale_tax + +value[7];

            sale_tax = ((((selected_rate * qty) - service_discount) / 100) * service_sales_tax);

            services[service_counter] = [selected_code_value, service_name, qty, selected_rate, selected_amount, service_discount, service_sales_tax, sale_tax, selected_remarks];

            jQuery("#service_code option[value=" + selected_code_value + "]").attr("disabled", "true");
            jQuery("#service_name option[value=" + selected_code_value + "]").attr("disabled", "true");
            numberofservices = Object.keys(services).length;
            var remarks_var = '';
            if (selected_remarks != '') {
                var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_remarks + ' </blockquote> </div>';
            }


            jQuery("#service_table_body").append('<tr id=service' + service_counter + '><td class="wdth_1" hidden>' + selected_code_value + '</td><td > <div class="max_txt">' + service_name +
                '</div>  <div ' +
                'class="max_txt">' + remarks_var + '</div>  </td><td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + selected_rate + '</td><td class="wdth_8 text-right">' + service_discount + '</td><td class="wdth_8 ' + 'text-right hide_sale_tax">' + service_sales_tax + '</td><td class="wdth_8 text-right">' + selected_amount + '</td><td align="right" ' +
                'class="wdth_4"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_service(' + service_counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_service(' + service_counter + ')><i class="fa fa-trash"></i></a></td></tr>');


            jQuery('#service_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#service_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#service_quantity").val("");
            jQuery("#service_remarks").val("");
            jQuery("#service_rate").val("");
            jQuery("#service_amount").val("");
            jQuery("#service_discount").val("");
            jQuery("#service_sales_tax").val("");

            jQuery("#servicesval").val(JSON.stringify(services));
            jQuery("#service_cancel_button").hide();
            jQuery(".table-responsive").show();
            jQuery("#save").show();
            jQuery("#service_first_add_more").html('<i class="fa fa-plus"></i> Add');

            // jQuery("#service_total_items").val(numberofservices);

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            grand_total_calculation();

            jQuery("#service_code").select2();
            jQuery("#service_name").select2();
        }
    }


    function delete_service(current_item) {

        jQuery("#service" + current_item).remove();
        var temp_services = services[current_item];
        jQuery("#service_code option[value=" + temp_services[0] + "]").attr("disabled", false);
        jQuery("#service_name option[value=" + temp_services[0] + "]").attr("disabled", false);

        delete services[current_item];

        function isEmpty(obj) {

            for (var key in obj) {

                if (obj.hasOwnProperty(key))
                    return false;
            }
            return true;
        }

        jQuery("#servicesval").val(JSON.stringify(services));

        if (isEmpty(services)) {
            numberofservices = 0;
        }

        var number_of_services = Object.keys(services).length;
        // jQuery("#service_total_items").val(number_of_services);

        grand_total_calculation();

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

        var temp_services = services[current_item];

        jQuery("#service_code").select2("destroy");
        jQuery("#service_name").select2("destroy");

        jQuery("#service_code").children("option[value^=" + temp_services[0] + "]").show(); //showing hid unit
        jQuery("#service_code option[value=" + temp_services[0] + "]").attr("disabled", false);
        jQuery("#service_name option[value=" + temp_services[0] + "]").attr("disabled", false);


        // jQuery("#service_code > option").each(function () {
        jQuery('#service_code option[value="' + temp_services[0] + '"]').prop('selected', true);
        // });

        jQuery("#service_name").val(temp_services[0]);
        jQuery("#service_quantity").val(temp_services[2]);
        jQuery("#service_rate").val(temp_services[3]);
        jQuery("#service_amount").val(temp_services[4]);
        jQuery("#service_discount").val(temp_services[5]);
        jQuery("#service_sales_tax").val(temp_services[6]);
        jQuery("#service_remarks").val(temp_services[8]);

        jQuery("#service_code").select2();
        jQuery("#service_name").select2();

        jQuery("#service_cancel_button").attr("style", "display:inline");
        jQuery("#service_cancel_button").attr("style", "background-color:red !important");
    }

    function service_cancel_all() {

        var newvaltohide = jQuery("#service_code").val();

        jQuery("#service_quantity").val("");

        jQuery("#service_code option[value=" + newvaltohide + "]").attr("disabled", "true");
        jQuery("#service_name option[value=" + newvaltohide + "]").attr("disabled", "true");
        jQuery('#service_code option[value="' + 0 + '"]').prop('selected', true);
        jQuery('#service_name option[value="' + 0 + '"]').prop('selected', true);

        jQuery("#service_code").select2("destroy");
        jQuery("#service_name").select2("destroy");

        jQuery("#service_remarks").val("");
        jQuery("#service_rate").val("");
        jQuery("#service_amount").val("");
        jQuery("#service_discount").val("");
        jQuery("#service_sales_tax").val("");

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

    }
</script>

{{--//////////////////////////////////////////////////////////////////// Sale Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}
<script>
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

</script>


<script>
    jQuery("#product_code").change(function () {

        // var sale_price = jQuery('option:selected', this).attr('data-sale_price');
        // var pname = jQuery('option:selected', this).val();
        //
        // jQuery("#quantity").val('1');
        //
        // jQuery("#product_name").select2("destroy");
        // jQuery("#product_name").children("option[value^=" + pname + "]");
        //
        // jQuery('#product_name option[value="' + pname + '"]').prop('selected', true);
        //
        // jQuery("#rate").val(sale_price);
        //
        // product_amount_calculation();
        //
        // jQuery("#product_name").select2();
        //
        // jQuery("#quantity").focus();
        //
        // if ($("#add_auto").is(':checked')) {
        //     $("#first_add_more").click();  // checked
        //     // jQuery("#product_code").focus();
        //     // setTimeout(function () {
        //     //     // jQuery("#product_code").focus();
        //     //     // $('#product_code').select2('open');
        //     // }, 100);
        // }

        product_onchange();
    });

</script>

<script>
    jQuery("#product_name").change(function () {

        var sale_price = jQuery('option:selected', this).attr('data-sale_price');

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

        var pcode = jQuery('option:selected', this).val();

        jQuery("#quantity").val('1');

        jQuery("#product_code").select2("destroy");

        jQuery("#product_code").children("option[value^=" + pcode + "]");

        jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);

        jQuery("#rate").val(sale_price);

        product_amount_calculation();

        jQuery("#product_code").select2();

        jQuery("#quantity").focus();

        if ($("#add_auto").is(':checked')) {
            $("#first_add_more").click();  // checked
            // jQuery("#product_code").focus();
            setTimeout(function () {
                // jQuery("#product_code").focus();
                //
                // $('#product_code').select2('open');

            }, 100);
        }
    });

</script>

<script>
    jQuery("#cash_paid").keyup(function () {

        var cash_paid = jQuery("#cash_paid").val();
        var grand_total = jQuery("#grand_total").val();

        var cash_return = grand_total - cash_paid;

        jQuery("#cash_return").val(cash_return);
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

        var flag_submit = true;
        var focus_once = 0;

        if(transaction_type==1){
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
        }else{
            if (machine.trim() == "0") {
                var isDirty = false;

                if (focus_once == 0) {
                    jQuery("#machine").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }
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


            // if (product_remarks == "") {
            //     document.getElementById("demo10").innerHTML = "";
            //     if (focus_once == 0) {
            //         jQuery("#product_remarks").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo10").innerHTML = "";
            // }


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

            document.getElementById("check_product_count").innerHTML = "Add Products";
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

                delete sales[global_id_to_edit];
            }

            counter++;

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");

            // var selected_code_value = jQuery("#product_code option:selected").val().trim();
            var selected_code_value = jQuery("#product_code option:selected").attr('data-parent');
            var product_name = jQuery("#product_name option:selected").text();
            var qty = jQuery("#quantity").val();
            var selected_product_name = jQuery("#product_name").val();
            var selected_remarks = jQuery("#product_remarks").val();
            var selected_rate = jQuery("#rate").val();
            var selected_amount = jQuery("#amount").val();
            var product_sales_tax = document.getElementById("product_sales_tax").value;
            var product_discount = document.getElementById("product_discount").value;

            if (product_sales_tax == '') {
                product_sales_tax = 0;
            }
            if (product_discount == '') {
                product_discount = 0;
            }


            $.each(sales, function (index, entry) {

                if (entry[0].trim() == selected_code_value) {

                    if (index != 0) {
                        jQuery("#" + index).remove();

                        delete sales[index];
                    }
                    counter++;

                    if (no_qty == 0) {

                        qty = +entry[2] + +1;

                        selected_amount = selected_rate * qty;
                    }
                }
            });


            numberofsales = Object.keys(sales).length;

            if (numberofsales == 0) {
                jQuery("#table_body").html("");
            }
            var sale_tax = 0;

            sale_tax = ((((selected_rate * qty) - product_discount) / 100) * product_sales_tax);

            sales[counter] = [selected_code_value, product_name, qty, selected_rate, selected_amount, product_discount, product_sales_tax, sale_tax, selected_remarks];

            numberofsales = Object.keys(sales).length;
            var remarks_var = '';
            if (selected_remarks != '') {
                var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_remarks + ' </blockquote> </div>';
            }

            jQuery("#table_body").append('<tr id=' + counter + '><td class="wdth_1">' + selected_code_value + '</td><td > <div class="max_txt">' + product_name + '</div> <div class="max_txt">' +
                remarks_var + '</div></td> <td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + selected_rate + '</td><td class="wdth_8 text-right">' + product_discount +
                '</td><td class="wdth_8 text-right hide_sale_tax">' + product_sales_tax + '</td><td class="wdth_8 text-right">' + selected_amount + '</td><td align="right" class="wdth_4"><a ' +
                'class="edit_link btn btn-sm btn-success" href="#" onclick=edit_sale(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');



            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#quantity").val("");
            jQuery("#product_remarks").val("");
            jQuery("#rate").val("");
            jQuery("#amount").val("");
            jQuery("#product_discount").val("");
            jQuery("#product_sales_tax").val("");

            jQuery("#salesval").val(JSON.stringify(sales));
            jQuery("#cancel_button").hide();
            jQuery(".table-responsive").show();
            jQuery("#save").show();
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

            // jQuery("#total_items").val(numberofsales);

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            grand_total_calculation();
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
        // jQuery("#total_items").val(number_of_sales);

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

        var temp_sales = sales[current_item];

        jQuery("#product_code").select2("destroy");
        jQuery("#product_name").select2("destroy");

        jQuery("#product_code").children("option[value^=" + temp_sales[0] + "]").show(); //showing hid unit

        jQuery('#product_code option[value="' + temp_sales[0] + '"]').prop('selected', true);

        jQuery("#product_name").val(temp_sales[0]);
        jQuery("#quantity").val(temp_sales[2]);
        jQuery("#rate").val(temp_sales[3]);
        jQuery("#amount").val(temp_sales[4]);
        jQuery("#product_discount").val(temp_sales[5]);
        jQuery("#product_sales_tax").val(temp_sales[6]);
        jQuery("#product_remarks").val(temp_sales[8]);

        jQuery("#product_code").select2();
        jQuery("#product_name").select2();

        jQuery("#cancel_button").attr("style", "display:inline");
        jQuery("#cancel_button").attr("style", "background-color:red !important");
    }

    function cancel_all() {

        var newvaltohide = jQuery("#product_code").val();

        jQuery("#quantity").val("");

        jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
        jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

        jQuery("#product_code").select2("destroy");
        jQuery("#product_name").select2("destroy");

        jQuery("#product_remarks").val("");
        jQuery("#rate").val("");
        jQuery("#amount").val("");
        jQuery("#product_discount").val("");
        jQuery("#product_sales_tax").val("");

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

        jQuery("#service_code").append("{!! $service_code !!}");
        jQuery("#service_name").append("{!! $service_name !!}");

        jQuery("#service_code").select2();
        jQuery("#service_name").select2();

        jQuery("#account_code").select2();
        jQuery("#account_name").select2();
        jQuery("#product_code").select2();
        jQuery("#product_name").select2();
        jQuery("#package").select2();

        jQuery("#machine").select2();

        $("#account_name").trigger("change");

        setTimeout(function () {
            // jQuery("#product_code").focus();
            // $('#product_code').select2('open');

        }, 500);

        // $(".hide_sale_tax").hide();
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

</script>

<script>
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

                    var selected_code_value = value['ppi_product_code'];

                    // jQuery("#product_code").select2("destroy");
                    jQuery('#product_code option[value="' + selected_code_value + '"]').prop('selected', true);
                    // jQuery("#product_code").select2();

                    product_onchange();

                    if ($("#add_auto").is(':checked')) {
                        // checked
                    } else {
                        $("#first_add_more").click();
                    }
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

    function product_onchange() {
        var sale_price = jQuery('#product_code option:selected').attr('data-sale_price');
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
                discount = jQuery('#product_code option:selected').attr('data-retailer_dis');
            } else if ($(".discount_type:checked").val() == 3) {
                discount = jQuery('#product_code option:selected').attr('data-whole_saler_dis');
            } else if ($(".discount_type:checked").val() == 4) {
                discount = jQuery('#product_code option:selected').attr('data-loyalty_dis');
            }
        }

        jQuery("#product_discount").val(discount);
        jQuery("#product_sales_tax").val(tax);

        var pname = jQuery('#product_code option:selected').val();

        jQuery("#quantity").val('1');

        jQuery("#product_name").select2("destroy");
        jQuery('#product_name option[value="' + pname + '"]').prop('selected', true);

        jQuery("#rate").val(sale_price);

        product_amount_calculation();

        jQuery("#product_name").select2();

        jQuery("#quantity").focus();

        if ($("#add_auto").is(':checked')) {
            $("#first_add_more").click();  // checked
        }
    }

</script>

<script>

    var no_qty = 0;
    jQuery('.discount_type').change(function () {

        if ($(this).is(':checked')) {

            if (this.value == 1) {
                no_qty = 1;
                product_recalculate();
                no_qty = 0;
            } else if (this.value == 2) {
                no_qty = 1;
                product_recalculate();
                no_qty = 0;
            } else if (this.value == 3) {
                no_qty = 1;
                product_recalculate();
                no_qty = 0;
            } else if (this.value == 4) {
                no_qty = 1;
                product_recalculate();
                no_qty = 0;
            }
        }
    });

    function product_recalculate() {
        $.each(sales, function (index, value) {

            var selected_code_value = value[0];
            jQuery('#product_code option[value="' + selected_code_value + '"]').prop('selected', true);
            product_onchange();

            if ($("#add_auto").is(':checked')) {
                // checked
            } else {
                $("#first_add_more").click();
            }
        });
    }

    jQuery('.invoice_type').change(function () {

        if ($(this).is(':checked')) {

            if (this.value == 1) {
                no_qty = 1;
                product_recalculate();
                no_qty = 0;
            } else if (this.value == 2) {
                no_qty = 1;
                product_recalculate();
                no_qty = 0;
            }
        }
    });

</script>

</body>
</html>
