@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Sale Return Invoice</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <a class="add_btn list_link add_more_button" href="{{ route('sale_return_invoice_list') }}" role="button">
                                <i class="fa fa-list"></i> Sale Invoice
                            </a>

                            <a class="add_btn list_link add_more_button" href="{{ route('sale_tax_sale_return_invoice_list') }}" role="button">
                                <i class="fa fa-list"></i> Sale Sale Tax Invoice
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <form name="f1" class="f1" id="f1" action="{{ route('submit_sale_return_invoice') }}" onsubmit="return popvalidation()" method="post" autocomplete="off">
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
                                                    <option value="{{$account->account_uid}}" {{$account->account_uid == old('account_code') ? 'selected="selected"' : ''}}>{{$account->account_uid}}</option>
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


                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12" id="account_div">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">Account Name
                                                <a href="{{ route('receivables_account_registration') }}" class="add_btn" target="_blank">
                                                    <l class="fa fa-plus"></l> Add
                                                </a>
                                                <a id="refresh_account_name" class="add_btn" style="margin-right: 50px;width:65px">
                                                    <l class="fa fa-refresh"></l> Refresh
                                                </a>
                                            </label>
                                            <select name="account_name" class="inputs_up form-control js-example-basic-multiple" id="account_name">
                                                <option value="0">Party Name</option>
                                                @foreach($accounts as $account)
                                                    <option value="{{$account->account_uid}}"{{$account->account_uid == old('account_name') ? 'selected="selected"' : ''}}>{{$account->account_name}}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="">Packages
                                                <a href="{{ route('product_packages') }}" class="add_btn" target="_blank">
                                                    <l class="fa fa-plus"></l> Add
                                                </a>
                                                <a id="refresh_package" class="add_btn" style="margin-right: 50px;width:65px">
                                                    <l class="fa fa-refresh"></l> Refresh
                                                </a>
                                            </label>
                                            <select name="package" class="inputs_up form-control js-example-basic-multiple" id="package">
                                                <option value="0">Select Package</option>
                                                @foreach($packages as $package)
                                                    <option value="{{$package->pp_id}}"{{$package->pp_id == old('package') ? 'selected="selected"' : ''}}>{{$package->pp_name}}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- end input box -->
                                    </div>


                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Remarks</label>
                                            <input type="text" name="remarks" class="inputs_up form-control" id="remarks" placeholder="Remarks" value="{{old('remarks')}}">
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Party Reference</label>
                                            <input type="text" name="customer_name" class="inputs_up form-control" id="customer_name" value="{{old('customer_name')}}" placeholder="Party Reference">
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

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="">Invoice Number</label>
                                            <input type="text" name="invoice_no" class="inputs_up form-control" id="invoice_no" placeholder="Invoice number" onkeypress="return allowOnlyNumber(event);" value="{{old('invoice_no')}}">

                                            <input type="checkbox" value="1" name="desktop_invoice_id" id="desktop_invoice_id">For Desktop
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="col-lg-1 col-md-6">
                                        <div class="input-method m-2">
                                            <button id="check" class="btn btn-primary" type="button">
                                                Check
                                            </button>
                                        </div>
                                    </div>


                                </div> <!-- new row ends here -->
                            </div><!-- search form end -->


                            <div class="custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input company_info_check_box" id="add_auto" name="add_auto" value="1" checked>
                                <label class="custom-control-label chck_pdng" for="add_auto"> Auto Add </label>
                            </div>

                            <div class="row">
                                <h5>Add Products</h5>
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
                                                    <l class="fa fa-refresh"></l> Refresh
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
                                                    <l class="fa fa-refresh"></l> Refresh
                                                </a>
                                                <select name="product_name" class="inputs_up form-control" id="product_name">
                                                    <option value="0">Product</option>
                                                </select>

                                                <input type="text" name="product_remarks" class="inputs_up form-control" id="product_remarks" placeholder="Remarks" style="margin-top: 5px;">
                                            </td>

                                            <td class=" wdth_5">
                                                <input type="text" name="quantity" class="inputs_up text-right form-control" id="quantity" placeholder="Qty" onfocus="this.select();"
                                                       onkeyup="product_amount_calculation();" onkeypress="return allowOnlyNumber(event);">
                                            </td>

                                            <td class=" wdth_5">
                                                <input type="text" name="bonus_qty" class="inputs_up text-right form-control" id="bonus_qty" placeholder="Bonus Qty" onfocus="this.select();"
                                                       onkeypress="return allowOnlyNumber(event);">
                                            </td>

                                            <td class=" wdth_5">
                                                <input type="text" name="rate" class="inputs_up text-right form-control" id="rate" placeholder="Rate" onfocus="this.select();"
                                                       onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="product_amount_calculation();">

                                                <input type="hidden" name="product_inclusive_rate" class="inputs_up text-right form-control" id="product_inclusive_rate">
                                            </td>

                                            <td class=" wdth_5">
                                                <input type="text" name="product_discount" class="inputs_up text-right form-control percentage_textbox" id="product_discount" placeholder="Discount %"
                                                       onfocus="this.select();" onkeyup="product_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">

                                                <input type="hidden" name="product_discount_amount" id="product_discount_amount" class="inputs_up text-right form-control">
                                            </td>

                                            <td class=" wdth_5 hide_sale_tax" style="width: 76px !important;min-width: 76px;max-width: 76px;">
                                                <input type="text" name="product_sales_tax" class="inputs_up text-right form-control percentage_textbox" id="product_sales_tax" placeholder="Sale Tax %"
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
                                                <table class="m-0 p-0 chk_dmnd">
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
                                                            <label class="total-items-label">Round off Cash Disc.</label>
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
                                                            <input type="text" name="grand_total" class="text-right p-0 form-control grand-total-field" id="grand_total" placeholder="0.00"
                                                                   readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-right-0">
                                                            <label class="cash-received-label">Cash Paid</label>
                                                        </td>

                                                        <td class="pt-0 pl-0 pb-0 border-left-0">
                                                            <input type="text" name="cash_paid" class="text-right p-0 form-control cash-received-field" id="cash_paid" placeholder="0.00"
                                                                   onkeyup="grand_total_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);" onfocus="this.select();">
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

                                <button type="submit" name="save" id="save" class="save_button form-control" onclick="return popvalidation()">
                                    <i class="fa fa-floppy-o"></i> Save
                                </button>
                                <span id="check_product_count" class="validate_sign"></span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="sales_array" id="sales_array">
                    <input type="hidden" name="account_name_text" id="account_name_text">
                </form>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')
    <script>
        // account ajax
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
        // packages ajax
        jQuery("#refresh_package").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_packages",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#package").html(" ");
                    jQuery("#package").append(data);
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
                url: "refresh_sale_product_code",
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
                url: "refresh_sale_product_name",
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
                url: "refresh_sale_product_code",
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
                url: "refresh_sale_product_name",
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


            var flag_submit = true;
            var focus_once = 0;



                if (account_name.trim() == "0") {
                    var isDirty = false;

                    if (focus_once == 0) {
                        jQuery("#account_name").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
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

            var cash_return = grand_total - cash_paid;

            jQuery("#cash_return").val(cash_return.toFixed(2));
        }
    </script>
    {{--//////////////////////////////////////////////////////////////////// End Sale Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product_code").append("{!! $pro_code !!}");
            jQuery("#product_name").append("{!! $pro_name !!}");

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

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


    <script>
        jQuery("#check").click(function () {

            var invoice_no = jQuery('#invoice_no').val();
            var invoice_type = $("input[name='invoice_type']:checked").val();
            var prefix = '';
            var item_prefix = '';
            numberofsales = 0;
            sales_array = {};
            var desktop_invoice_id = 0;

            jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#table_body").html("");

            if ($("#desktop_invoice_id").is(':checked')) {
                desktop_invoice_id = 1;
            }

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_sale_items_for_return",
                data: {invoice_no: invoice_no, invoice_type: invoice_type, desktop_invoice_id: desktop_invoice_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    numberofsales = 0;
                    sales_array = {};

                    jQuery("#table_body").html("");

                    if (invoice_type == 1) {
                        prefix = 'si';
                        item_prefix = 'sii';
                    } else {
                        prefix = 'ssi';
                        item_prefix = 'ssii';
                    }

                    if (data.length !== 0) {

                        jQuery("#customer_name").val(data[0][prefix + '_customer_name']);

                        $(".discount_type").prop("checked", false);
                        $("#discount_type" + data[0][prefix + '_discount_type']).prop("checked", true);

                        console.log(data[1]);

                        $.each(data[1], function (index, value) {

                            counter++;

                            var selected_code_value = value[item_prefix + '_product_code'];
                            var product_name = value[item_prefix + '_product_name'];
                            var qty = value[item_prefix + '_qty'];
                            var bonus_qty = value[item_prefix + '_bonus_qty'];
                            var selected_rate = value[item_prefix + '_rate'];
                            var product_inclusive_rate = value[item_prefix + '_net_rate'];
                            var product_discount = value[item_prefix + '_discount_per'];
                            var product_discount_amount = value[item_prefix + '_discount_amount'];
                            var product_sales_tax = value[item_prefix + '_saletax_per'];
                            var product_sale_tax_amount = value[item_prefix + '_saletax_amount'];
                            var selected_amount = value[item_prefix + '_amount'];
                            var selected_remarks = value[item_prefix + '_remarks'];
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
                                'class="max_txt">' + remarks_var + '</div></td><td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + bonus_qty + '</td><td class="wdth_8 ' +
                                'text-right">' + selected_rate + '</td><td class="wdth_8 text-right">' + product_discount + '</td><td class="wdth_8 text-right hide_sale_tax">' + product_sales_tax +
                                '</td><td class="wdth_8 text-right hide_sale_tax">' + inclusive_exclusive + '</td><td class="wdth_8 ' + 'text-right">' + selected_amount + '</td><td align="right" ' +
                                'class="wdth_4"><a ' + 'class="edit_link btn btn-sm btn-success" href="#" ' + 'onclick=edit_sale(' + counter + ')>' + '<i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');

                            jQuery("#sales_array").val(JSON.stringify(sales_array));

                            jQuery("#total_items").val(numberofsales);
                        });

                        check_invoice_type();

                        grand_total_calculation();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });
    </script>

@endsection

