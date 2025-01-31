
@extends('extend_index')

@section('content')

    <div class="row">


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Service Invoice</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <a class="add_btn list_link add_more_button" href="{{ route('services_invoice_list') }}" role="button">
                                    <i class="fa fa-list"></i> Service Invoice
                                </a>
                                <a class="add_btn list_link add_more_button" href="{{ route('service_tax_invoice_list') }}" role="button">
                                    <i class="fa fa-list"></i> Service Sale Tax Invoice
                                </a>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->


                    <form name="f1" class="f1" id="f1" action="{{ route('submit_services_invoice') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                    @csrf
                    <!-- main row ends here --> <!-- first row ends here -->

                        <!-- lower row starts here -->
                        <div class="row">

                            <div class="col-lg-12 col-md-12"> <!-- left column starts here  -->
                                <!-- *************** upper row added here *********-->

                                <div class="search_form">
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

                                        <div class="form-group col-lg-12 col-md-6 col-sm-12 col-xs-12 hidden">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">Remarks</label>
                                                <input type="text" name="remarks" class="inputs_up form-control" id="remarks"
                                                       placeholder="Remarks">

                                            </div><!-- end input box -->
                                        </div>


                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Party Name
                                                    <a href="#" class="add_btn" target="_blank">
                                                        <l class="fa fa-plus"></l> Add
                                                    </a>
                                                    <a href="#" class="add_btn"style="margin-right:50px;width:65px">
                                                        <l class="fa fa-refresh"></l> Refresh
                                                    </a>
                                                </label>
                                                <select name="account_name" class="inputs_up form-control" id="account_name"
                                                        data-rule-required="true" data-msg-required="Please Choose Party"
                                                >
                                                    <option value="0">Party Name</option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{$account->account_uid}}">{{$account->account_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>Customer Name</label>
                                                <input type="text" name="customer_name" class="inputs_up form-control" id="customer_name"
                                                       placeholder="Customer Name">

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
                                                <th scope="col" class="text-right wdth_5">Discount</th>
                                                <th scope="col" class="text-right wdth_5 hide_sale_tax">Sale Tax</th>
                                                <th scope="col" class="text-right wdth_5">Amount</th>
                                                <th scope="col" class="w-5p text-right wdth_5">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="table_body">
                                            <tr>
                                                <td colspan="10" align="center"> No Service Added</td>
                                            </tr>
                                            </tbody>

                                            <tfoot class="side-section">

                                            <tr>
                                                <td class=" wdth_5" hidden>
                                                    <select name="service_code" class="inputs_up form-control hidden" id="service_code" style="display: none !important;">
                                                        <option value="0">Code</option>
                                                        {{--                                                        @foreach($services as $service)--}}
                                                        {{--                                                            <option value="{{$service->ser_id}}">{{$service->ser_id}}</option>--}}
                                                        {{--                                                        @endforeach--}}
                                                    </select>

                                                </td>
                                                <td class=" wdth_2">

                                                    <select name="service_name" class="inputs_up form-control" id="service_name">
                                                        <option value="0">Select</option>
                                                        {{--                                                        @foreach($services as $service)--}}
                                                        {{--                                                            <option value="{{$service->ser_id}}">{{$service->ser_title}}</option>--}}
                                                        {{--                                                        @endforeach--}}
                                                    </select>

                                                    <input type="text" name="service_remarks" class="inputs_up form-control" id="service_remarks" placeholder="Remarks" style="margin-top: 5px;">


                                                </td>
                                                <td class=" wdth_5" hidden>
                                                </td>
                                                <td class=" wdth_5">
                                                    <input type="text" name="quantity" class="inputs_up inputs_up_invoice  text-right form-control" id="quantity" placeholder="Qty"
                                                           onfocus="this.select();" onkeyup="service_amount_calculation();" onkeypress="return allowOnlyNumber(event);">

                                                </td>
                                                <td class=" wdth_5">
                                                    <input type="text" name="rate" class="inputs_up inputs_up_invoice  text-right form-control" id="rate" placeholder="Rate"
                                                           onkeyup="service_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">

                                                </td>
                                                <td class=" wdth_5">
                                                    <input type="text" name="service_discount" class="inputs_up text-right form-control" id="service_discount" placeholder="Discount"
                                                           onkeyup="service_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">
                                                </td>

                                                <td class=" wdth_5 hide_sale_tax">
                                                    <input type="text" name="service_sales_tax" class="inputs_up text-right form-control" id="service_sales_tax" placeholder="Sales Tax"
                                                           onkeyup="service_amount_calculation();" onkeypress="return allow_only_number_and_decimals(this,event);">

                                                </td>

                                                <td class="text-right wdth_5">
                                                    <input type="text" name="amount" class="inputs_up inputs_up_invoice text-right form-control" id="amount" placeholder="Amount" readonly>

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

                                            <tr class="border-0 p-0">
                                                <td colspan="6" align="right" class="border-0 p-0">
                                                    <table class="m-0 p-0 chk_dmnd">
                                                        <tfoot>
                                                        <tr>
                                                            <td class="border-right-0  border-top-0">
                                                                <label class="total-items-label">Total Items</label>
                                                            </td>

                                                            <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                <input type="text" name="total_items" class="text-right p-0 form-control total-items-field"
                                                                       data-rule-required="true" data-msg-required="Please Add Item"
                                                                       id="total_items" placeholder="0.00"
                                                                       readonly>

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
                                                                                <input type="number" name="sales_tax_amount" class="text-right p-0 form-control" id="sales_tax_amount" placeholder=""
                                                                                       readonly>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td class="border-right-0">
                                                                                <label>Total Discount</label>
                                                                            </td>

                                                                            <td class="pt-0 pl-0 pb-0 border-left-0">
                                                                                <input type="text" name="total_discount" class="text-right p-0 form-control" id="total_discount" placeholder=""
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
                                    <button type="submit" name="save" id="save" class="save_button form-control"
                                    >
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                    <span id="demo28" class="validate_sign"></span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="servicesval" id="servicesval">
                        <input type="hidden" name="account_name_text" id="account_name_text">
                    </form>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let account_name = document.getElementById("account_name"),
                total_items = document.getElementById("total_items"),
                validateInputIdArray = [
                    account_name.id,
                    total_items.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
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

                    $.each(services, function (index, value) {

                            if (index != 0) {
                                jQuery("#" + index).remove();

                                delete services[index];
                            }
                            counter++;

                            var selected_code_value = value[0];
                            var service_name = value[1];
                            var qty = value[2];
                            var selected_rate = value[3];
                            var selected_amount = 0;
                            var service_discount = value[5];
                            var service_sales_tax = 0;
                            var selected_remarks = value[8];

                            selected_amount = (selected_rate * qty) - service_discount;
                            var service_sale_tax_percentage = (selected_amount / 100) * service_sales_tax;
                            selected_amount = +selected_amount + +service_sale_tax_percentage;

                            numberofservices = Object.keys(services).length;

                            if (numberofservices == 0) {
                                jQuery("#table_body").html("");
                            }
                            var sale_tax = 0;

                            sale_tax = ((((selected_rate * qty) - service_discount) / 100) * service_sales_tax);

                            services[counter] = [selected_code_value, service_name, qty, selected_rate, selected_amount, service_discount, service_sales_tax, sale_tax, selected_remarks];

                            numberofservices = Object.keys(services).length;
                            var remarks_var = '';
                            if (selected_remarks != '') {
                                var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_remarks + ' </blockquote> </div>';
                            }

                            jQuery("#table_body").append('<tr id=' + counter + '><td class="wdth_1" hidden>' + selected_code_value + '</td><td > <div class="max_txt">' + service_name + '</div> <div ' +
                                'class="max_txt">' + remarks_var + '</div></td> <td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + selected_rate + '</td><td class="wdth_8 ' +
                                'text-right">' + service_discount + '</td><td class="wdth_8 text-right hide_sale_tax">' + service_sales_tax + '</td><td class="wdth_8 text-right">' + selected_amount +
                                '</td><td align="right" class="wdth_4"><a ' + 'class="edit_link btn btn-sm btn-success" href="#" onclick=edit_service(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_service(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');

                            jQuery("#servicesval").val(JSON.stringify(services));

                        }
                    );
                    grand_total_calculation();

                    $(".hide_sale_tax").hide();
                } else {
                    $(".hide_sale_tax").show();
                }
            }

        });

    </script>

    <script>

        jQuery("#account_code").change(function () {

            jQuery("#party_name").select2("destroy");

            var pname = jQuery('option:selected', this).val();

            // jQuery("#party_name").children("option[value^=" + pname + "]");

            jQuery('#party_name option[value="' + pname + '"]').prop('selected', true);


            var party_name = jQuery("#party_name option:selected").text();

            if (pname > 0) {
                jQuery("#account_name_text").val(party_name);
            } else {
                jQuery("#account_name_text").val('');
            }
            jQuery("#party_name").select2();

        });


    </script>

    <script>
        jQuery("#account_name").change(function () {

            jQuery("#account_code").select2("destroy");
            var pcode = jQuery('option:selected', this).val();

            // jQuery("#customer_code").children("option[value^=" + pcode + "]");

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

        function service_amount_calculation() {
            var quantity = jQuery("#quantity").val();
            var rate = jQuery("#rate").val();
            var service_discount = jQuery("#service_discount").val();
            var service_sales_tax = jQuery("#service_sales_tax").val();


            var amount = (rate * quantity) - service_discount;
            var sale_tax = (amount / 100) * service_sales_tax;
            amount = +amount + +sale_tax;

            jQuery("#amount").val(amount);
            jQuery("#total_sale_tax_payable").val(sale_tax);
        }

        function grand_total_calculation() {
            var expense = jQuery("#expense").val();
            var disc_percentage = jQuery("#disc_percentage").val();

            var rate = 0;
            var total_price = 0;
            var remaining_total_amount = 0; //(qty * rate)- discount
            var sale_tax_amount = 0;
            total_discount = 0;

            jQuery.each(services, function (index, value) {
                total_price = +total_price + +value[4];
                rate = (value[3] * value[2]) - value[5];
                remaining_total_amount = +remaining_total_amount + (value[3] * value[2]) - value[5];
                sale_tax_amount = +sale_tax_amount + +((rate / 100) * value[6]);
                total_discount = +total_discount + +value[5];
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

            var cash_paid = jQuery("#cash_paid").val();
            var cash_return = cash_paid - grand_total;
            jQuery("#cash_return").val(cash_return);
        }
    </script>

    <script>
        jQuery("#service_code").change(function () {

            var pname = jQuery('option:selected', this).val();

            jQuery("#service_name").select2("destroy");
            // jQuery("#service_name").children("option[value^=" + pname + "]");

            jQuery('#service_name option[value="' + pname + '"]').prop('selected', true);
            service_amount_calculation();
            jQuery("#service_name").select2();
        });

    </script>

    <script>
        jQuery("#service_name").change(function () {

            var pcode = jQuery('option:selected', this).val();

            jQuery("#service_code").select2("destroy");
            // jQuery("#service_code").children("option[value^=" + pcode + "]");

            jQuery('#service_code option[value="' + pcode + '"]').prop('selected', true);

            service_amount_calculation();

            jQuery("#service_code").select2();
        });

    </script>

    <script>
        // adding packs into table
        var numberofservices = 0;
        var counter = 0;
        var services = {};
        var global_id_to_edit = 0;
        var total_discount = 0;

        function popvalidation() {
            isDirty = true;

            var service_code = document.getElementById("service_code").value;
            var service_name = document.getElementById("service_name").value;
            var service_remarks = document.getElementById("service_remarks").value;
            var quantity = document.getElementById("quantity").value;
            var rate = document.getElementById("rate").value;
            var amount = document.getElementById("amount").value;
            var account_code = document.getElementById("account_code").value;
            var account_name = document.getElementById("account_name").value;
            var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if (account_code.trim() == "0") {
                var isDirty = false;

                if (focus_once == 0) {
                    jQuery("#account_code").focus();
                    focus_once = 1;
                }
                flag_submit = false;
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
            //
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //
            // }


            if (numberofservices == 0) {
                var isDirty = false;
                if (service_code == "0") {

                    if (focus_once == 0) {
                        jQuery("#service_code").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                if (service_name == "0") {
                    if (focus_once == 0) {
                        jQuery("#service_name").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                // if (service_remarks == "") {
                //
                //     if (focus_once == 0) {
                //         jQuery("#service_remarks").focus();
                //         focus_once = 1;
                //     }
                //     flag_submit = false;
                // } else {
                //
                // }


                if (quantity == "" || quantity == 0) {

                    if (focus_once == 0) {
                        jQuery("#quantity").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                // var inventory = jQuery("#demo9").text();
                // inventory = parseInt(inventory.substr(1).slice(0, -1));
                //
                // if (parseInt(quantity) > inventory) {
                //
                //     if (focus_once == 0) {
                //         jQuery("#quantity").focus();
                //         focus_once = 1;
                //     }
                //     flag_submit = false;
                // }


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

                document.getElementById("demo28").innerHTML = "Add Service";
                flag_submit = false;
            } else {
                document.getElementById("demo28").innerHTML = "";
            }
            return flag_submit;
        }


        function add_sale() {
            var service_code = document.getElementById("service_code").value;
            var service_name = document.getElementById("service_name").value;
            var service_remarks = document.getElementById("service_remarks").value;
            var quantity = document.getElementById("quantity").value;
            var rate = document.getElementById("rate").value;
            var amount = document.getElementById("amount").value;

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


            if (quantity == "" || quantity == 0) {
                if (focus_once1 == 0) {
                    jQuery("#quantity").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            // var inventory = jQuery("#demo9").text();
            // inventory = parseInt(inventory.substr(1).slice(0, -1));
            //
            // if (parseInt(quantity) > inventory) {
            //     // alert('Qty not greater than stock.May be its going to be negative');
            // }


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

                    delete services[global_id_to_edit];
                }

                counter++;

                jQuery("#service_code").select2("destroy");
                jQuery("#service_name").select2("destroy");

                var service_name = jQuery("#service_name option:selected").text();
                var selected_code_value = jQuery("#service_code option:selected").val();
                var qty = jQuery("#quantity").val();
                var selected_service_name = jQuery("#service_name").val();
                var selected_remarks = jQuery("#service_remarks").val();
                var selected_rate = jQuery("#rate").val();
                var selected_amount = jQuery("#amount").val();
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
                    jQuery("#table_body").html("");
                }
                var sale_tax = 0;
                //  rate=value[4]- value[6];
                // sale_tax=+sale_tax + +value[7];

                sale_tax = ((((selected_rate * qty) - service_discount) / 100) * service_sales_tax);

                services[counter] = [selected_code_value, service_name, qty, selected_rate, selected_amount, service_discount, service_sales_tax, sale_tax, selected_remarks];

                jQuery("#service_code option[value=" + selected_code_value + "]").attr("disabled", "true");
                jQuery("#service_name option[value=" + selected_code_value + "]").attr("disabled", "true");
                numberofservices = Object.keys(services).length;
                var remarks_var = '';
                if (selected_remarks != '') {
                    var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_remarks + ' </blockquote> </div>';
                }


                jQuery("#table_body").append('<tr id=' + counter + '><td class="wdth_1" hidden>' + selected_code_value + '</td><td > <div class="max_txt">' + service_name + '</div>  <div ' +
                    'class="max_txt">' + remarks_var + '</div>  </td><td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + selected_rate + '</td><td class="wdth_8 text-right">' + service_discount + '</td><td class="wdth_8 ' + 'text-right hide_sale_tax">' + service_sales_tax + '</td><td class="wdth_8 text-right">' + selected_amount + '</td><td align="right" ' +
                    'class="wdth_4"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_service(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_service(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');

                $(".invoice_type").trigger("change");

                jQuery('#service_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#service_name option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#quantity").val("");
                jQuery("#service_remarks").val("");
                jQuery("#rate").val("");
                jQuery("#amount").val("");
                jQuery("#service_discount").val("");
                jQuery("#service_sales_tax").val("");

                jQuery("#servicesval").val(JSON.stringify(services));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#total_items").val(numberofservices);

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();

                grand_total_calculation();

                jQuery("#service_code").select2();
                jQuery("#service_name").select2();
            }
        }


        function delete_service(current_item) {

            jQuery("#" + current_item).remove();
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
            jQuery("#total_items").val(number_of_services);

            grand_total_calculation();

            jQuery("#service_name").select2("destroy");
            jQuery("#service_name").select2();
            jQuery("#service_code").select2("destroy");
            jQuery("#service_code").select2();
        }


        function edit_service(current_item) {

            // jQuery(".table-responsive").attr("style", "display:none");
            jQuery("#" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

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
            jQuery("#quantity").val(temp_services[2]);
            jQuery("#rate").val(temp_services[3]);
            jQuery("#amount").val(temp_services[4]);
            jQuery("#service_discount").val(temp_services[5]);
            jQuery("#service_sales_tax").val(temp_services[6]);
            jQuery("#service_remarks").val(temp_services[8]);

            jQuery("#service_code").select2();
            jQuery("#service_name").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            var newvaltohide = jQuery("#service_code").val();

            jQuery("#quantity").val("");

            jQuery("#service_code option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery("#service_name option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery('#service_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#service_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#service_code").select2("destroy");
            jQuery("#service_name").select2("destroy");

            jQuery("#service_remarks").val("");
            jQuery("#rate").val("");
            jQuery("#amount").val("");
            jQuery("#service_discount").val("");
            jQuery("#service_sales_tax").val("");

            jQuery("#service_code").select2();
            jQuery("#service_name").select2();

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
            jQuery("#service_code").select2();
            jQuery("#service_name").select2();
            jQuery("#account_name").select2();
            jQuery("#account_code").select2();

            jQuery("#service_code").append("{!! $service_code !!}");
            jQuery("#service_name").append("{!! $service_name !!}");

            $(".hide_sale_tax").hide();
        });

        // window.addEventListener('keydown', function (e) {
        //     if (e.which == 113) {
        //         $('#service_code').select2('open');
        //     }
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

@endsection

