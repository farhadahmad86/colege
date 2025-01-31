
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


                    <form name="f1" class="f1" id="f1" action="{{ route('update_manufacture_product') }}"
                          method="post" autocomplete="off">
                    @csrf
                    <!-- main row ends here --> <!-- first row ends here -->

                        <!-- lower row starts here -->
                        <div class="row">

                            <div class="col-lg-12 col-md-12"> <!-- left column starts here  -->

                                <div class="search_form">
                                    <div class="row">  <!--  new row starts here -->

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>Recipe</label>
                                                <input type="text" class="inputs_up form-control" value="Recipe" readonly
                                                       data-rule-required="true" data-msg-required="Please Enter Recipe"
                                                >
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Code</label>
                                                <input type="text" class="inputs_up form-control" value="{{$manufacture_product->pm_account_code}}" readonly>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Account</label>
                                                <input type="text" class="inputs_up form-control" value="{{$manufacture_product->pm_account_name}}" readonly>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Code</label>
                                                <input type="text" class="inputs_up form-control" value="{{$manufacture_product->pm_pro_code}}" readonly>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Product</label>
                                                <input type="text" class="inputs_up form-control" value="{{$manufacture_product->pm_pro_name}}" readonly>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Qty</label>
                                                <input type="text" name="manufacture_qty" class="inputs_up form-control" id="manufacture_qty" placeholder="Qty" onfocus="this.select();"
                                                       onkeypress="return allowOnlyNumber(event);" value="{{$manufacture_product->pm_qty}}" readonly>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">Complete Date</label>
                                                <input type="text" name="complete_date" class="inputs_up form-control date-picker" id="complete_date" placeholder="Complete Date" value="{{date('d F Y', strtotime($manufacture_product->pm_complete_datetime))}}">
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>Remarks</label>
                                                <input type="text" name="remarks" class="inputs_up form-control" id="remarks" placeholder="Remarks" value="{{$manufacture_product->pm_remarks}}">
                                            </div><!-- end input box -->
                                        </div>

                                    </div> <!-- new row ends here -->
                                </div><!-- search form end -->

                                <!-- ************** upper row added here *********-->
                                <div class="custom-checkbox mb-5" hidden>
                                    <input type="checkbox" class="custom-control-input company_info_check_box" id="add_auto" name="add_auto" value="1" checked>
                                    <label class="custom-control-label chck_pdng" for="add_auto"> Auto Add </label>
                                </div>
                                <div class="clearfix"></div>

                                <div class="row">
                                    <h5>Add Products</h5>
                                </div>

                                <div class="row m-0" style="">
                                    <!-- table code starts here -->
                                    <div class="table_div table-responsive table-max-height-500px">
                                        <table class="table table-striped table-bordered m-0" id="category_dynamic_table">
                                            <thead class="lower-section-thead">
                                            <tr>
                                                <th scope="col" class=" wdth_5">Code</th>
                                                <th scope="col" class=" wdth_2">Product Name

                                                </th>
                                                <th scope="col" class=" text-right wdth_5">Qty</th>
                                                <th scope="col" class=" text-right wdth_5" hidden>Rate</th>
                                                <th scope="col" class=" text-right wdth_5" hidden>Discount</th>
                                                <th scope="col" class=" text-right wdth_5" hidden>Sale Tax</th>
                                                <th scope="col" class="text-right wdth_5" hidden>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody id="table_body">
                                            <tr>
                                                <td colspan="10" align="center"> No Product Added</td>
                                            </tr>
                                            </tbody>

                                            <tfoot class="side-section">

                                            <tr hidden>
                                                <td class=" wdth_5">
                                                    <select name="product_code" class="inputs_up inputs_up_invoice form-control" id="product_code">
                                                        <option value="0">Code</option>
                                                    </select>
                                                </td>
                                                <td class=" wdth_2">
                                                    <select name="product_name" class="inputs_up inputs_up_invoice form-control" id="product_name">
                                                        <option value="0">Product</option>
                                                    </select>

                                                    {{--                                                    <label class="">Remarks</label>--}}
                                                    <input type="text" name="product_remarks" class="inputs_up inputs_up_invoice form-control" id="product_remarks" placeholder="Remarks"
                                                           style="margin-top: 5px;" hidden>
                                                </td>
                                                <td class=" wdth_5" hidden>
                                                </td>
                                                <td class=" wdth_5">
                                                    <input type="text" name="quantity" class="inputs_up inputs_up_invoice  text-right form-control" id="quantity"
                                                           placeholder="Qty" onfocus="this.select();" onkeyup="product_amount_calculation();" onkeypress="return allowOnlyNumber(event);" readonly>
                                                    <span id="demo8" class="validate_sign"></span>
                                                </td>
                                                <td class=" wdth_5" hidden>
                                                    <input type="text" name="rate" class="inputs_up inputs_up_invoice  text-right form-control" id="rate" placeholder="Rate"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);"
                                                           onkeyup="product_amount_calculation();" readonly>
                                                </td>
                                                <td class="text-right wdth_5" hidden>
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

                                            <tr class="border-0">
                                                <td colspan="6" align="right" class="border-0 p-0">
                                                    <table class="m-0 p-0 chk_dmnd">
                                                        <tfoot>
                                                        <tr>
                                                            <td class="border-right-0  border-top-0">
                                                                <label class="total-items-label">Total Items</label>
                                                            </td>

                                                            <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                <input type="text" name="total_items" class="text-right p-0 form-control total-items-field" id="total_items" placeholder="0.00"
                                                                       readonly>
                                                            </td>
                                                        </tr>

                                                        <tr hidden>
                                                            <td class="border-right-0  border-top-0">
                                                                <label class="total-items-label">Total Price</label>
                                                            </td>

                                                            <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                <input type="text" name="total_price" class="text-right p-0 form-control" id="total_price" placeholder="0.00"
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


                                <div class="row">
                                    <h5>Add Expenses</h5>
                                </div>


                                <div class="clearfix"></div>

                                <div class="row m-0" style="">
                                    <!-- table code starts here -->
                                    <div class="table_div table-responsive table-max-height-500px">
                                        <table class="table table-striped table-bordered m-0" id="category_dynamic_table">
                                            <thead class="lower-section-thead">
                                            <tr>
                                                <th scope="col" class=" wdth_5">Code</th>
                                                <th scope="col" class=" wdth_2">Account Name
                                                    {{--                                                    <span id="demo9" class="validate_sign">(Stock)</span>--}}
                                                </th>
                                                <th scope="col" class="text-right wdth_5">Amount</th>
                                                <th scope="col" class="w-5p text-right wdth_5">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="account_table_body">
                                            <tr>
                                                <td colspan="10" align="center"> No Account Added</td>
                                            </tr>
                                            </tbody>

                                            <tfoot class="side-section">

                                            <tr>
                                                <td class=" wdth_5">
                                                    <select name="account_code" class="inputs_up inputs_up_invoice form-control" id="account_code">
                                                        <option value="0">Code</option>
                                                    </select>
                                                </td>
                                                <td class=" wdth_2">
                                                    <select name="account_name" class="inputs_up inputs_up_invoice form-control" id="account_name">
                                                        <option value="0">Select Account</option>
                                                    </select>

                                                    {{--                                                    <label class="">Remarks</label>--}}
                                                    <input type="text" name="account_remarks" class="inputs_up inputs_up_invoice form-control" id="account_remarks" placeholder="Remarks"
                                                           style="margin-top: 5px;" hidden>
                                                </td>
                                                <td class=" wdth_5" hidden>
                                                </td>
                                                <td class=" wdth_5">
                                                    <input type="text" name="account_amount" class="inputs_up inputs_up_invoice  text-right form-control" id="account_amount" placeholder="Amount"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);">
                                                </td>
                                                <td class="w-5p text-right wdth_5">

                                                    <button id="first_add_more_account" class="btn btn-success btn-sm" onclick="add_account()" type="button">
                                                        <i class="fa fa-plus"></i> Add
                                                    </button>

                                                    <button style="display: none; background-color: red !important" id="cancel_button_account" class="btn btn-danger btn-sm"
                                                            onclick="cancel_all_account()"
                                                            type="button">
                                                        <i class="fa fa-times"></i> Cancel
                                                    </button>

                                                    {{--                                                    <span id="demo13" class="validate_sign"> </span>--}}

                                                </td>
                                            </tr>

                                            <tr class="border-0">
                                                <td colspan="6" align="right" class="border-0 p-0">
                                                    <table class="m-0 p-0 chk_dmnd">
                                                        <tfoot>
                                                        <tr>
                                                            <td class="border-right-0  border-top-0">
                                                                <label class="total-items-label">Total Accounts</label>
                                                            </td>

                                                            <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                <input type="text" name="total_accounts" class="text-right p-0 form-control total-items-field" id="total_accounts" placeholder="0.00"
                                                                       readonly>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="border-right-0  border-top-0">
                                                                <label class="total-items-label">Total Amount</label>
                                                            </td>

                                                            <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                <input type="text" name="total_account_amount" class="text-right p-0 form-control" id="total_account_amount" placeholder="0.00"
                                                                       readonly>
                                                            </td>
                                                        </tr>

                                                        <tr style="margin: 10px">
                                                            <td class="border-right-0  border-top-0">
                                                                <label class="total-items-label">Grand Total</label>
                                                            </td>

                                                            <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                <input type="text" name="grand_total" class="text-right p-0 form-control" id="grand_total" placeholder="0.00"
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
                                    <button type="submit" name="save" id="save" class="save_button form-control" >
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                    <span id="demo13" class="validate_sign"></span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="account_values" id="account_values">
                        <input type="hidden" name="manufacture_id" id="manufacture_id" value="{{$manufacture_product->pm_id}}">
                    </form>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')

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
            var grand_total = 0;

            // total_discount = 0;
            //
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
                    var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_account_remarks + ' </blockquote> </div>';
                }

                jQuery("#account_table_body").prepend('<tr id=account' + accounts_counter + '><td class="wdth_1">' + selected_account_code_value + '</td><td > <div class="max_txt">' + account_name +
                    '</div> ' +
                    '<div ' +
                    'class="max_txt">' +
                    remarks_var + '</div> </td><td class="text-right wdth_8">' +
                    selected_account_amount + '</td><td align="right" class="wdth_4"><a class="account_edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' + accounts_counter + ')><i ' +
                    'class="fa ' + 'fa-edit"></i></a><a href="#" class="account_delete_link btn btn-sm btn-danger" onclick=delete_account(' + accounts_counter + ')><i class="fa fa-trash"></i></a></td></tr>');

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

    <script>

        var numberofsales = 0;
        var counter = 0;
        var sales = {};
        var global_id_to_edit = 0;
        var total_discount = 0;

        jQuery(document).ready(function () {
            // Initialize select2

            jQuery("#account_code").append("{!! $expense_account_code !!}");
            jQuery("#account_name").append("{!! $expense_account_name !!}");

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();

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


        var manufacture_id = jQuery('#manufacture_id').val();

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "{{ route('get_manufacture_product_details') }}",
            data: {id: manufacture_id},
            type: "POST",
            cache: false,
            dataType: 'json',
            success: function (data) {

                $.each(data[0][0], function (index, value) {

                    if (global_id_to_edit != 0) {
                        jQuery("#" + global_id_to_edit).remove();

                        delete sales[global_id_to_edit];
                    }
                    counter++;

                    var selected_code_value = value['pmi_product_code'];
                    var product_name = value['pmi_product_name'];
                    var qty = value['pmi_qty'];
                    var selected_remarks = '';
                    var selected_rate = value['pmi_rate'];
                    var selected_amount = value['pmi_amount'];

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

                    // sales[counter] = [selected_code_value, product_name, qty, selected_rate, selected_amount, selected_remarks];

                    numberofsales = Object.keys(sales).length;
                    var remarks_var = '';
                    if (selected_remarks != '') {
                        var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_remarks + ' </blockquote> </div>';
                    }

                    jQuery("#table_body").prepend('<tr id=' + counter + '><td class="wdth_1">' + selected_code_value + '</td><td > <div class="max_txt">' + product_name + '</div> <div ' +
                        'class="max_txt">' +
                        remarks_var + '</div> </td><td class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right" hidden>' + selected_rate + '</td><td class="text-right wdth_8" hidden>' +
                        selected_amount + '</td></tr>');

                    jQuery("#total_items").val(numberofsales);

                    grand_total_calculation();
                });

                // if (($(data[1]).length > 1)){
                    $.each(data[1][0], function (index, value) {
                        if (account_global_id_to_edit != 0) {
                            jQuery("#" + account_global_id_to_edit).remove();

                            delete accounts[account_global_id_to_edit];
                        }

                        accounts_counter++;

                        jQuery("#account_code").select2("destroy");
                        jQuery("#account_name").select2("destroy");

                        var account_name = value['pme_account_name'];
                        var selected_account_code_value = value['pme_account_code'];
                        var selected_account_remarks = '';
                        var selected_account_amount = value['pme_amount'];

                        numberofaccounts = Object.keys(accounts).length;

                        if (numberofaccounts == 0) {
                            jQuery("#account_table_body").html("");
                        }

                        accounts[accounts_counter] = [selected_account_code_value, account_name, selected_account_amount, selected_account_remarks];

                        jQuery("#account_code option[value=" + selected_account_code_value + "]").attr("disabled", "true");
                        jQuery("#account_name option[value=" + selected_account_code_value + "]").attr("disabled", "true");

                        numberofaccounts = Object.keys(accounts).length;
                        var remarks_var = '';
                        if (selected_account_remarks != '') {
                            var remarks_var = '<div class="max_txt"> <blockquote> ' + selected_account_remarks + ' </blockquote> </div>';
                        }

                        jQuery("#account_table_body").prepend('<tr id=account' + accounts_counter + '><td class="wdth_1">' + selected_account_code_value + '</td><td > <div class="max_txt">' +
                            account_name + '</div> ' +
                            '<div ' +
                            'class="max_txt">' +
                            remarks_var + '</div> </td><td class="text-right wdth_8">' +
                            selected_account_amount + '</td><td align="right" class="wdth_4"><a class="account_edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' + accounts_counter + ')><i ' +
                            'class="fa ' + 'fa-edit"></i></a><a href="#" class="account_delete_link btn btn-sm btn-danger" onclick=delete_account(' + accounts_counter + ')><i class="fa fa-trash"></i></a></td></tr>');

                        jQuery("#account_values").val(JSON.stringify(accounts));

                        jQuery("#total_accounts").val(numberofaccounts);

                        grand_total_calculation();

                        jQuery("#account_code").select2();
                        jQuery("#account_name").select2();
                    });
                // }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // alert(jqXHR.responseText);
                // alert(errorThrown);
            }
        });
    </script>

@endsection

