<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('include/head')

</head>

<body>

@include('include/header')
@include('include.sidebar_shahzaib')

<div class="main-container">
    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">
        @include('inc._messages')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">


                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">PSO Sale Invoice</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white">PSO Sale Invoice</h4>
                            </div>
                            <div class="list_btn">
                                <a class="btn list_link add_more_button" href="{{ route('sale_invoice_list') }}" role="button">
                                    <i class="fa fa-list"></i> view list
                                </a>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->


                    <form name="f1" class="f1" id="f1" action="{{ route('submit_pso_sale_invoice') }}" onsubmit="return popvalidation()" method="post">
                    @csrf
                    <!-- main row ends here --> <!-- first row ends here -->

                        <!-- lower row starts here -->
                        <div class="row">

                            <div class="col-lg-12 col-md-12"> <!-- left column starts here  -->
                                <!-- ************** upper row added here *********-->


                                <!-- ************** upper row ended here  *************** -->

                                <div class="search_form">
                                    <div class="row">  <!--  new row starts here -->

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Code
                                                    <a href="{{ route('add_product') }}" class="add_btn" target="_blank">
                                                        <i class="fa fa-plus"></i> Add
                                                    </a>
                                                </label>
                                                <select name="product_code" class="inputs_up form-control" id="product_code">
                                                    <option value="0">Code</option>
                                                    @foreach($products as $product)
                                                        <option value="{{$product->pro_code}}"
                                                                data-sale_price="{{$product->pro_sale_price}}">{{$product->pro_code}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Product Name
                                                    <a href="{{ route('add_product') }}" class="add_btn" target="_blank">
                                                        <i class="fa fa-plus"></i> Add
                                                    </a>
                                                </label>
                                                <select name="product_name" class="inputs_up form-control" id="product_name">
                                                    <option value="0">Product</option>
                                                    @foreach($products as $product)
                                                        <option value="{{$product->pro_code}}"
                                                                data-sale_price="{{$product->pro_sale_price}}">{{$product->pro_title}}</option>
                                                    @endforeach
                                                </select>

                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Quantity</label>
                                                <input type="text" name="quantity" class="inputs_up form-control" id="quantity" placeholder="Qty" onfocus="this.select();"
                                                       onkeyup="product_calculation()" onkeypress="return numeric_decimal_only(event);">

                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Rate</label>
                                                <input type="text" name="rate" class="inputs_up form-control" id="rate" placeholder="Rate" onkeyup="product_calculation()"
                                                       onkeypress="return numeric_decimal_only(event);" readonly>

                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Amount</label>
                                                <input type="text" name="amount" class="inputs_up form-control" id="amount" placeholder="Amount" readonly>

                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Nozzle</label>
                                                <select name="nozzle" class="inputs_up form-control" id="nozzle">
                                                    <option value="0">Select Nozzle</option>
                                                    @foreach($nozzles as $nozzle)
                                                        <option value="{{$nozzle->noz_id}}" data-tank="{{$nozzle->noz_tank_id}}">{{$nozzle->noz_name}}</option>
                                                    @endforeach
                                                </select>

                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-8 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">Remarks</label>
                                                <input type="text" name="product_remarks" class="inputs_up form-control" id="product_remarks" placeholder="Remarks">

                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Sale Person</label>
                                                <select name="sale_person" class="inputs_up form-control" id="sale_person">
                                                    <option value="0">Sale Person</option>
                                                    @foreach($sale_persons as $sale_person)
                                                        <option value="{{$sale_person->user_id}}">
                                                            @if($sale_person->user_role_id=='1')
                                                                NU -
                                                            @elseif($sale_person->user_role_id=='2')
                                                                CA -
                                                            @elseif($sale_person->user_role_id=='3')
                                                                TE -
                                                            @elseif($sale_person->user_role_id=='4')
                                                                SP -
                                                            @endif
                                                            {{$sale_person->user_name}}</option>
                                                    @endforeach
                                                </select>

                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="form_controls">
                                                <button id="first_add_more" class="save_button form-control" onclick="add_sale()" type="button">
                                                    <i class="fa fa-plus"></i> Add
                                                </button>
                                                <button style="display: none; background-color: red !important" id="cancel_button" class="cancel_button form-control" onclick="cancel_all()"
                                                        type="button">
                                                    <i class="fa fa-times"></i> Cancel
                                                </button>
                                            </div>
                                        </div>

                                    </div> <!-- new row ends here -->
                                </div><!-- search form end -->


                                <div class="row m-0" style="">
                                    <!-- table code starts here -->
                                    <div class="table_div table-responsive table-max-height-500px">
                                        <table class="table table-striped table-bordered m-0" id="category_dynamic_table">
                                            <thead class="lower-section-thead">
                                            <tr>
                                                <th scope="col" class=" wdth_5">Code</th>
                                                <th scope="col" class=" wdth_2">Product Name</th>
                                                <th scope="col" class=" wdth_5">Remarks</th>
                                                <th scope="col" class=" wdth_5">Qty</th>
                                                <th scope="col" class=" wdth_5">Rate</th>
                                                <th scope="col" class=" wdth_5">Amount</th>
                                                <th scope="col" class="text-right wdth_5">Nozzle</th>
                                                <th scope="col" class="w-5p text-right wdth_5">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="table_body">

                                            <tr>
                                                <td colspan="10" align="center"> No Product Added</td>
                                            </tr>
                                            </tbody>

                                            <tfoot class="side-section">
                                            <tr class="border-0">
                                                <td colspan="7" align="right" class="border-0">
                                                    <table class="m-0 p-0">
                                                        <tfoot>
                                                        <tr>
                                                            <td>
                                                                <label class="total-items-label">Total Items</label>
                                                            </td>

                                                            <td class="p-0">
                                                                <input type="text" name="total_items" class="text-right p-0 form-control total-items-field" id="total_items" placeholder="0.00"
                                                                       readonly>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label class="grand-total-label">Grand Total</label>
                                                            </td>

                                                            <td class="p-0">
                                                                <input type="text" name="grand_total" class="text-right p-0 form-control grand-total-field" id="grand_total" placeholder="0.00"
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
                                    <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="save_button form-control" onclick="return popvalidation()">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                    <span id="error_demo" class="validate_sign"></span>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" name="salesval" id="salesval">
                    </form>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->
        </div><!-- row end -->


        @include('include/footer')
    </div>
</div>

@include('include/script')


<script>

    function numeric_decimal_only(e) {

        return e.charCode === 0 || ((e.charCode >= 48 && e.charCode <= 57) || (e.charCode == 46 && document.getElementById(e.target.id).value.indexOf('.') < 0));
    }

    function product_calculation() {
        var qty = jQuery('#quantity').val();
        var rate = jQuery('#rate').val();

        var total_amount = qty * rate;

        jQuery('#amount').val(total_amount);
    }

    function overall_calculation() {
        var amount = 0;

        jQuery.each(sales, function (index, value) {
            amount = +amount + +value[5];
        });

        var grand_total = +amount;

        jQuery("#grand_total").val(grand_total);
    }
</script>

<script>
    jQuery("#product_code").change(function () {

        var sale_price = jQuery('option:selected', this).attr('data-sale_price');

        var pname = jQuery('option:selected', this).val();

        jQuery("#product_name").select2("destroy");
        jQuery("#product_name").children("option[value^=" + pname + "]");

        jQuery("#product_name > option").each(function () {
            jQuery('#product_name option[value="' + pname + '"]').prop('selected', true);
        });

        jQuery("#rate").val(sale_price);

        jQuery("#product_name").select2();

    });

</script>

<script>
    jQuery("#product_name").change(function () {

        var sale_price = jQuery('option:selected', this).attr('data-sale_price');
        var pcode = jQuery('option:selected', this).val();


        jQuery("#product_code").select2("destroy");
        jQuery("#product_code").children("option[value^=" + pcode + "]");

        jQuery("#product_code > option").each(function () {
            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);
        });
        jQuery("#rate").val(sale_price);
        // jQuery("#product_code").select2();

        jQuery("#product_code").select2();
    });

</script>

<script>
    // adding packs into table
    var numberofsales = 0;
    var counter = 0;
    var sales = {};
    var global_id_to_edit = 0;

    function popvalidation() {
        isDirty = true;

        var product_code = document.getElementById("product_code").value;
        var product_name = document.getElementById("product_name").value;
        var quantity = document.getElementById("quantity").value;
        var rate = document.getElementById("rate").value;
        var amount = document.getElementById("amount").value;
        var sale_person = document.getElementById("sale_person").value;
        var nozzle = document.getElementById("nozzle").value;

        var flag_submit = true;
        var focus_once = 0;

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

            if (nozzle == "0") {
                if (focus_once == 0) {
                    jQuery("#nozzle").focus();
                    focus_once = 1;
                }
                flag_submit1 = false;
            }

            document.getElementById("error_demo").innerHTML = "Add Atleast One Product";
            flag_submit = false;
        } else {

            if (sale_person == "0") {
                if (focus_once == 0) {
                    document.getElementById("error_demo").innerHTML = "Select Sale Person";
                    jQuery("#sale_person").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("error_demo").innerHTML = "";
            }

        }

        return flag_submit;
    }


    function add_sale() {

        var product_code = document.getElementById("product_code").value;
        var product_name = document.getElementById("product_name").value;
        var quantity = document.getElementById("quantity").value;
        var rate = document.getElementById("rate").value;
        var amount = document.getElementById("amount").value;
        var nozzle = document.getElementById("nozzle").value;


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

        if (nozzle == "0") {
            if (focus_once1 == 0) {
                jQuery("#nozzle").focus();
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
            jQuery("#nozzle").select2("destroy");

            var checkedValue = [];

            var product_name = jQuery("#product_name option:selected").text();
            var selected_code_value = jQuery("#product_code option:selected").val();
            var qty = jQuery("#quantity").val();
            var selected_remarks = jQuery("#product_remarks").val();
            var selected_rate = jQuery("#rate").val();
            var selected_amount = jQuery("#amount").val();
            var tank = jQuery('option:selected', '#nozzle').attr('data-tank');
            var nozzle_name = jQuery("#nozzle option:selected").text();

            numberofsales = Object.keys(sales).length;

            if (numberofsales == 0) {
                jQuery("#table_body").html("");
            }

            sales[counter] = [selected_code_value, product_name, selected_remarks, qty, selected_rate, selected_amount, nozzle , tank];

            jQuery("#product_code option[value=" + selected_code_value + "]").attr("disabled", "true");
            jQuery("#product_name option[value=" + selected_code_value + "]").attr("disabled", "true");
            jQuery("#nozzle option[value=" + nozzle + "]").attr("disabled", "true");

            numberofsales = Object.keys(sales).length;

            jQuery("#table_body").prepend('<tr id=' + counter + '><td >' + selected_code_value + '</td><td > <div class="max_txt">' + product_name + '</div></td><td>' + selected_remarks + '</td><td' +
                ' >' + qty + '</td><td >' + selected_rate + '</td><td class="text-right">' + selected_amount + '</td><td class="text-right">' + nozzle_name + '</td><td align="right"><a class="edit_link ' +
                'btn btn-sm btn-success" href="#" ' +
                'onclick=edit_sale(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa ' +
                'fa-trash"></i></a></td></tr>');

            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#nozzle option[value="' + 0 + '"]').prop('selected', true);

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

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#nozzle").select2();

            overall_calculation();
        }
    }


    function delete_sale(current_item) {

        jQuery("#" + current_item).remove();
        var temp_sales = sales[current_item];
        jQuery("#product_code option[value=" + temp_sales[0] + "]").attr("disabled", false);
        jQuery("#product_name option[value=" + temp_sales[0] + "]").attr("disabled", false);
        jQuery("#nozzle option[value=" + temp_sales[6] + "]").attr("disabled", false);

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


        jQuery("#product_name").select2("destroy");
        jQuery("#product_name").select2();
        jQuery("#product_code").select2("destroy");
        jQuery("#product_code").select2();
        jQuery("#nozzle").select2("destroy");
        jQuery("#nozzle").select2();

        overall_calculation();
    }


    function edit_sale(current_item) {

        jQuery(".table-responsive").attr("style", "display:none");
        jQuery("#save").attr("style", "display:none");
        jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
        jQuery("#cancel_button").show();

        global_id_to_edit = current_item;

        var temp_sales = sales[current_item];

        jQuery("#product_code").select2("destroy");
        jQuery("#product_name").select2("destroy");
        jQuery("#nozzle").select2("destroy");

        jQuery("#product_code").children("option[value^=" + temp_sales[0] + "]").show(); //showing hid unit
        jQuery("#product_code option[value=" + temp_sales[0] + "]").attr("disabled", false);
        jQuery("#product_name option[value=" + temp_sales[0] + "]").attr("disabled", false);
        jQuery("#nozzle option[value=" + temp_sales[6] + "]").attr("disabled", false);
        jQuery("#product_code > option").each(function () {
            jQuery('#product_code option[value="' + temp_sales[0] + '"]').prop('selected', true);
        });

        jQuery("#product_name").val(temp_sales[0]);
        jQuery("#product_remarks").val(temp_sales[2]);
        jQuery("#quantity").val(temp_sales[3]);
        jQuery("#rate").val(temp_sales[4]);
        jQuery("#amount").val(temp_sales[5]);
        jQuery("#nozzle").val(temp_sales[6]);

        jQuery("#product_code").select2();
        jQuery("#product_name").select2();
        jQuery("#nozzle").select2();

        jQuery("#cancel_button").attr("style", "display:inline");
        jQuery("#cancel_button").attr("style", "background-color:red !important");

        overall_calculation();
    }

    function cancel_all() {

        var newvaltohide = jQuery("#product_code").val();
        var newvaltohide_nozzle = jQuery("#nozzle").val();

        jQuery("#quantity").val("");

        jQuery("#product_code option[value=" + newvaltohide + "]").attr("disabled", "true");
        jQuery("#product_name option[value=" + newvaltohide + "]").attr("disabled", "true");
        jQuery("#nozzle option[value=" + newvaltohide_nozzle + "]").attr("disabled", "true");
        jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
        jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
        jQuery('#nozzle option[value="' + 0 + '"]').prop('selected', true);

        jQuery("#product_code").select2("destroy");
        jQuery("#product_name").select2("destroy");
        jQuery("#nozzle").select2("destroy");

        jQuery("#product_remarks").val("");
        jQuery("#rate").val("");
        jQuery("#amount").val("");

        jQuery("#product_code").select2();
        jQuery("#product_name").select2();
        jQuery("#nozzle").select2();

        jQuery("#cancel_button").hide();

        jQuery(".table-responsive").show();

        jQuery("#save").show();

        jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');
        global_id_to_edit = 0;

        overall_calculation();

    }
</script>

<style type="text/css">

    /* Hide HTML5 Up and Down arrows. */

    .border_dashed {
        border-bottom: 2px dashed grey;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    .lower_dashed {
        border-left: 2px dashed grey;
        /*padding-top: 20px;
        margin-top: 20px;   */
    }

    .shadowed {
        margin-top: 20px;
        margin-bottom: 20px;
        min-height: 300px !important;
        max-height: 320px !important;
        overflow-y: scroll;
        box-shadow: 3px 3px 3px 3px grey;
    }
</style>
<script>
    jQuery(document).ready(function () {
        // Initialize select2
        jQuery("#product_code").select2();
        jQuery("#product_name").select2();
        jQuery("#sale_person").select2();
        jQuery("#nozzle").select2();
    });

</script>
<script>
    function allowOnlyNumber(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
</body>
</html>
