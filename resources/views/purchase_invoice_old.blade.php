@extends('extend_index')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Purchase Invoice</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <a class="add_btn list_link add_more_button" href="{{ route('purchase_invoice_list') }}" role="button">
                                <i class="fa fa-list"></i> Purchase Invoice
                            </a>

                            <a class="add_btn list_link add_more_button" href="{{ route('sale_tax_purchase_invoice_list') }}" role="button">
                                <i class="fa fa-list"></i> Purchase Sale Tax Invoice
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <form name="f1" class="f1" id="f1" action="{{ route('submit_purchase_invoice') }}" onsubmit="return popvalidation()" method="post" autocomplete="off">
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
                                                    <option value="{{$account->account_uid}}">{{$account->account_uid}}</option>
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


                                    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">Account Title
                                                <a href="{{ url('receivables_account_registration') }}" class="add_btn" target="_blank">
                                                    <l class="fa fa-plus"></l>
                                                </a>
                                                <a id="refresh_account_name" class="add_btn" >
                                                    <l class="fa fa-refresh"></l>
                                                </a>
                                            </label>
                                            <select name="account_name" class="inputs_up form-control js-example-basic-multiple" id="account_name">
                                                <option value="0">Party Title</option>
                                                @foreach($accounts as $account)
                                                    <option value="{{$account->account_uid}}">{{$account->account_name}}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- end input box -->
                                    </div>


                                    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Remarks</label>
                                            <input type="text" name="remarks" class="inputs_up form-control" id="remarks" placeholder="Remarks">
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Party Reference</label>
                                            <input type="text" name="customer_name" class="inputs_up form-control" id="customer_name" placeholder="Party Reference">
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
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

                                </div> <!-- new row ends here -->
                            </div><!-- search form end -->


                            <div class="custom-checkbox mb-5" hidden>
                                <input type="checkbox" class="custom-control-input company_info_check_box" id="add_auto" name="add_auto" value="1">
                                <label class="custom-control-label chck_pdng" for="add_auto"> Auto Add </label>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row m-0" style="">
                                <!-- table code starts here -->
                                <div class="table_div table-responsive table-max-height-500px">
                                    <table class="table table-bordered table-sm table-striped" id="category_dynamic_table">
                                        <thead class="lower-section-thead">
                                        <tr>
                                            <th scope="col" class=" wdth_5">Code
                                            </th>
                                            <th scope="col" class=" wdth_2">Product Name
                                            <th scope="col" class=" text-right wdth_5">Warehouse</th>
                                            <th scope="col" class=" text-right wdth_5">Qty</th>
                                            <th scope="col" class=" text-right wdth_5">Bonus</th>
                                            <th scope="col" class=" text-right wdth_5">Rate</th>
                                            <th scope="col" class=" text-right wdth_5">Discount %</th>
                                            <th scope="col" class=" text-right wdth_5 hide_sale_tax">Sale Tax %</th>
                                            <th scope="col" class=" text-right wdth_5 hide_sale_tax">Inclusive/Exclusive</th>
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

                                        <tr style="height: 114px;">
                                            <td class=" wdth_5">
                                                <a href="{{ route('add_product') }}" target="_blank"class="add_btn" style="top: 20px">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a id="refresh_product_code" class="add_btn" style="margin-right: 26px;  top: 20px">
                                                    <l class="fa fa-refresh"></l>
                                                </a>
                                                <select name="product_code" class="inputs_up form-control" id="product_code">
                                                    <option value="0">BarCode</option>
                                                </select>
                                            </td>
                                            <td class=" wdth_2">
                                                <a href="{{ route('add_product') }}" target="_blank" class="add_btn" >
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a id="refresh_product_name" class="add_btn" style="margin-right: 26px;">
                                                    <l class="fa fa-refresh"></l>
                                                </a>
                                                <select name="product_name" class="inputs_up form-control" id="product_name">
                                                    <option value="0">Product Title</option>
                                                </select>

                                                <input type="text" name="product_remarks" class="inputs_up form-control" id="product_remarks" placeholder="Remarks" style="margin-top: 5px;">
                                            </td>
                                            <td class=" wdth_5">
                                                <a href="{{ route('add_warehouse') }}" target="_blank" class="add_btn"  style="top: 20px">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a id="refresh_warehouse" class="add_btn" style="margin-right: 26px;top: 20px">
                                                    <l class="fa fa-refresh"></l>
                                                </a>
                                                <select name="warehouse" class="inputs_up form-control" id="warehouse">
                                                    <option value="0">Warehouse</option>
                                                    @foreach($warehouses as $warehouse)
                                                        <option value="{{$warehouse->wh_id}}" {{$warehouse->wh_id == 1 ? 'selected':''}}>{{$warehouse->wh_title}}</option>
                                                    @endforeach
                                                </select>
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

                                                <input type="text" name="product_inclusive_rate" class="inputs_up text-right form-control" id="product_inclusive_rate">
                                            </td>
                                            <td class=" wdth_5">
                                                <input type="text" name="product_discount" class="inputs_up text-right form-control percentage_textbox" id="product_discount" placeholder="Discount %"
                                                       onfocus="this.select();" onkeyup="product_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">

                                                <input type="text" name="product_discount_amount" id="product_discount_amount" class="inputs_up text-right form-control">
                                            </td>
                                            <td class=" wdth_5 hide_sale_tax" style="width: 76px !important;min-width: 76px;max-width: 76px;">
                                                <input type="text" name="product_sales_tax" class="inputs_up text-right form-control percentage_textbox" id="product_sales_tax" placeholder="Sale Tax %"
                                                       onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="product_amount_calculation();">

                                                <input type="text" name="product_sale_tax_amount" class="inputs_up text-right form-control" id="product_sale_tax_amount">
                                            </td>
                                            <td class=" wdth_5 hide_sale_tax" style="width: 76px !important;min-width: 76px;max-width: 76px;">
                                                <input type="checkbox" name="inclusive_exclusive" class="inputs_up text-right form-control" id="inclusive_exclusive"
                                                       onclick="product_amount_calculation();">
                                            </td>
                                            <td class="text-right wdth_5">
                                                <input type="text" name="amount" class="inputs_up text-right form-control" id="amount" placeholder="Amount" min="1" readonly>
                                            </td>
                                            <td class="w-5p text-right wdth_5">

                                                <button id="first_add_more" class="btn btn-success btn-sm" onclick="add_purchase()" type="button">
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


                    <input type="hidden" name="purchasesval" id="purchasesval">
                    <input type="hidden" name="account_name_text" id="account_name_text">
                </form>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    <script>

        jQuery("#refresh_account_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_purchase_account_code",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

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
                url: "refresh_purchase_account_name",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#account_name").html(" ");
                    jQuery("#account_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_warehouse").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_store_warehouse",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#warehouse").html(" ");
                    jQuery("#warehouse").append(data);
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
                url: "refresh_products_code",
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
                url: "refresh_products_name",
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
                url: "refresh_products_code",
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
                url: "refresh_products_name",
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

            jQuery.each(purchases, function (index, value) {

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

            var cash_paid = jQuery("#cash_paid").val();

            var cash_return = cash_paid - grand_total;

            jQuery("#cash_return").val(cash_return.toFixed(2));
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

            jQuery.each(purchases, function (index, value) {

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

            var cash_paid = jQuery("#cash_paid").val();

            var cash_return = cash_paid - grand_total;

            jQuery("#cash_return").val(cash_return.toFixed(2));
        }

    </script>


    <script>

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

    </script>

    <script>
        jQuery("#product_code").change(function () {

            var purchase_price = jQuery('option:selected', this).attr('data-purchase_price');

            var pname = jQuery('option:selected', this).val();

            jQuery("#quantity").val('1');

            jQuery("#product_name").select2("destroy");
            jQuery("#product_name").children("option[value^=" + pname + "]");

            jQuery('#product_name option[value="' + pname + '"]').prop('selected', true);

            jQuery("#rate").val(purchase_price);

            product_amount_calculation();

            jQuery("#product_name").select2();

            jQuery("#quantity").focus();

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

            var purchase_price = jQuery('option:selected', this).attr('data-purchase_price');
            var pcode = jQuery('option:selected', this).val();

            jQuery("#quantity").val('1');

            jQuery("#product_code").select2("destroy");

            jQuery("#product_code").children("option[value^=" + pcode + "]");

            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);

            jQuery("#rate").val(purchase_price);

            product_amount_calculation();

            jQuery("#product_code").select2();

            jQuery("#quantity").focus();

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

        jQuery('.invoice_type').change(function () {

            if ($(this).is(':checked')) {
                if (this.value == 1) {

                    $.each(purchases, function (index, value) {

                            if (index != 0) {
                                jQuery("#" + index).remove();

                                delete purchases[index];
                            }
                            counter++;

                            var selected_code_value = value['product_code'];
                            var product_name = value['product_name'];
                            var warehouse = value['warehouse'];
                            var warehouse_name = value['warehouse_name'];
                            var qty = value['product_qty'];
                            var bonus_qty = value['product_bonus_qty'];
                            var selected_rate = value['product_rate'];
                            var product_discount = value['product_discount'];
                            var product_discount_amount = value['product_discount_amount'];
                            var product_sales_tax = 0;
                            var product_sale_tax_amount = 0;
                            var selected_remarks = value['product_remarks'];

                            var selected_amount = (selected_rate * qty) - product_discount;

                            var inclusive_exclusive = '';
                            var inclusive_exclusive_status = 0;

                            if (value['inclusive_exclusive_status'] == 1) {

                                inclusive_exclusive = 'Inclusive';
                                inclusive_exclusive_status = value['inclusive_exclusive_status'];

                            } else {
                                inclusive_exclusive = 'Exclusive';
                            }


                            numberofpurchases = Object.keys(purchases).length;

                            if (numberofpurchases == 0) {
                                jQuery("#table_body").html("");
                            }

                            purchases[counter] = {
                                'product_code': selected_code_value,
                                'product_name': product_name,
                                'warehouse': warehouse,
                                'warehouse_name': warehouse_name,
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

                            numberofpurchases = Object.keys(purchases).length;
                            var remarks_var = '';
                            if (selected_remarks != '') {
                                var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_remarks + ' </blockquote> </div>';
                            }

                            jQuery("#table_body").append('<tr id=' + counter + '><td class="wdth_1">' + selected_code_value + '</td><td > <div class="max_txt">' + product_name + '</div> <div ' +
                                'class="max_txt">' + remarks_var + '</div></td> <td class="wdth_8 text-right">' + warehouse_name + '</td><td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + bonus_qty + '</td><td class="wdth_8 text-right">' + selected_rate + '</td><td ' +
                                'class="wdth_8 text-right">' + product_discount + '</td><td class="wdth_8 text-right hide_sale_tax">' + product_sales_tax + '</td><td class="wdth_8 text-right ' +
                                'hide_sale_tax">' + inclusive_exclusive + '</td><td class="wdth_8 ' + 'text-right">' + selected_amount + '</td><td align="right" class="wdth_4"><a ' +
                                'class="edit_link btn btn-sm btn-success" href="#" onclick=edit_purchase(' + counter + ')>' + '<i class="fa fa-edit"></i></a><a href="#" ' +
                                'class="delete_link btn btn-sm btn-danger" onclick=delete_purchase(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');

                            jQuery("#purchasesval").val(JSON.stringify(purchases));
                        }
                    );
                    grand_total_calculation();

                    $(".hide_sale_tax").hide();
                } else {
                    $(".hide_sale_tax").show();
                }
            }
        });


        // adding packs into table
        var numberofpurchases = 0;
        var counter = 0;
        var purchases = {};
        var global_id_to_edit = 0;

        var total_discount = 0;

        function popvalidation() {
            isDirty = true;

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var product_remarks = document.getElementById("product_remarks").value;
            var quantity = document.getElementById("quantity").value;
            var bonus_qty = document.getElementById("bonus_qty").value;
            var rate = document.getElementById("rate").value;
            var amount = document.getElementById("amount").value;
            var account_code = document.getElementById("account_code").value;
            var account_name = document.getElementById("account_name").value;


            var flag_submit = true;
            var focus_once = 0;

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


            // if(remarks.trim() == "")
            // {
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }


            if (numberofpurchases == 0) {
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


        function add_purchase() {

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var warehouse = document.getElementById("warehouse").value;
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

            if (warehouse == "0") {

                if (focus_once1 == 0) {
                    jQuery("#warehouse").focus();
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

                    delete purchases[global_id_to_edit];
                }

                counter++;

                jQuery("#product_code").select2("destroy");
                jQuery("#product_name").select2("destroy");
                jQuery("#warehouse").select2("destroy");

                var selected_code_value = jQuery("#product_code option:selected").attr('data-parent');
                var product_name = jQuery("#product_name option:selected").text();
                var warehouse = jQuery("#warehouse").val();
                var warehouse_name = jQuery("#warehouse option:selected").text();
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

                // $.each(purchases, function (index, entry) {
                //
                //     if (entry['product_code'].trim() == selected_code_value) {
                //
                //         if (index != 0) {
                //             jQuery("#" + index).remove();
                //
                //             delete purchases[index];
                //         }
                //         counter++;
                //
                //         qty = +entry['product_qty'] + +1;
                //
                //         selected_amount = selected_rate * qty;
                //     }
                // });


                numberofpurchases = Object.keys(purchases).length;

                if (numberofpurchases == 0) {
                    jQuery("#table_body").html("");
                }


                purchases[counter] = {
                    'product_code': selected_code_value,
                    'product_name': product_name,
                    'warehouse': warehouse,
                    'warehouse_name': warehouse_name,
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

                numberofpurchases = Object.keys(purchases).length;
                var remarks_var = '';
                if (selected_remarks != '') {
                    var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_remarks + ' </blockquote> </div>';
                }

                jQuery("#table_body").append('<tr id=' + counter + '><td class="wdth_1">' + selected_code_value + '</td><td > <div class="max_txt">' + product_name + '</div> <div class="max_txt">' +
                    remarks_var + '</div></td> <td class="wdth_8 text-right">' + warehouse_name + '</td><td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + bonus_qty + '</td><td class="wdth_8 text-right">' + selected_rate + '</td><td class="wdth_8 text-right">' +
                    product_discount + '</td><td class="wdth_8 text-right hide_sale_tax">' + product_sales_tax + '</td><td class="wdth_8 text-right hide_sale_tax">' + inclusive_exclusive +
                    '</td><td class="wdth_8 ' + 'text-right">' + selected_amount + '</td><td align="right" class="wdth_4"><a ' + 'class="edit_link btn btn-sm btn-success" href="#" ' +
                    'onclick=edit_purchase(' + counter + ')>' + '<i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_purchase(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');

                // $(".invoice_type").trigger("change");

                var radioValue = $("input[name='invoice_type']:checked").val();

                if (radioValue == 1) {
                    $(".hide_sale_tax").hide();
                } else {
                    $(".hide_sale_tax").show();
                }


                jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

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

                jQuery("#purchasesval").val(JSON.stringify(purchases));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#total_items").val(numberofpurchases);

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();

                jQuery("#product_code").select2();
                jQuery("#product_name").select2();
                jQuery("#warehouse").select2();
                grand_total_calculation();
            }
        }


        function delete_purchase(current_item) {

            jQuery("#" + current_item).remove();

            delete purchases[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#purchasesval").val(JSON.stringify(purchases));

            if (isEmpty(purchases)) {
                numberofpurchases = 0;
            }

            var number_of_purchases = Object.keys(purchases).length;
            jQuery("#total_items").val(number_of_purchases);

            grand_total_calculation();

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
        }


        function edit_purchase(current_item) {

            // jQuery(".table-responsive").attr("style", "display:none");
            jQuery("#" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();


            global_id_to_edit = current_item;

            var temp_purchases = purchases[current_item];

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            jQuery("#warehouse").select2("destroy");

            // jQuery("#product_code").children("option[value^=" + temp_purchases[0] + "]").show(); //showing hid unit

            jQuery('#product_code option[value="' + temp_purchases['product_code'] + '"]').prop('selected', true);
            jQuery('#warehouse option[value="' + temp_purchases['warehouse'] + '"]').prop('selected', true);

            jQuery("#product_name").val(temp_purchases['product_code']);
            jQuery("#quantity").val(temp_purchases['product_qty']);
            jQuery("#bonus_qty").val(temp_purchases['product_bonus_qty']);
            jQuery("#rate").val(temp_purchases['product_rate']);
            jQuery("#product_inclusive_rate").val(temp_purchases['product_inclusive_rate']);
            jQuery("#amount").val(temp_purchases['product_amount']);
            jQuery("#product_discount").val(temp_purchases['product_discount']);
            jQuery("#product_discount_amount").val(temp_purchases['product_discount_amount']);
            jQuery("#product_sales_tax").val(temp_purchases['product_sale_tax']);
            jQuery("#product_sale_tax_amount").val(temp_purchases['product_sale_tax_amount']);
            jQuery("#product_remarks").val(temp_purchases['product_remarks']);

            var inclusive_exclusive_status = temp_purchases['inclusive_exclusive_status'];

            if (inclusive_exclusive_status == 1) {
                jQuery('#inclusive_exclusive').prop('checked', true);
            }

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#warehouse").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            var newvaltohide = jQuery("#product_code").val();

            jQuery("#quantity").val("");

            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            jQuery("#warehouse").select2("destroy");

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
            jQuery("#warehouse").select2();

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

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#warehouse").select2();

            var radioValue = $("input[name='invoice_type']:checked").val();

            if (radioValue == 1) {


                $(".hide_sale_tax").hide();
            } else {

                $(".hide_sale_tax").show();
            }

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

@endsection

