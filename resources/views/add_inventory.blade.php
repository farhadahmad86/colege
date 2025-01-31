
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Add Inventory</h4>
                            </div>
                            <div class="list_btn">
                                <a class="btn list_link add_more_button" href="{{ route('add_inventory_list') }}" role="button">
                                    <i class="fa fa-list"></i> view list
                                </a>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->


                    <form name="f1" class="f1" id="f1" action="{{ route('submit_add_inventory') }}" onsubmit="return checkForm()" method="post">
                        @csrf
                    <!-- main row ends here --> <!-- first row ends here -->

                        <!-- lower row starts here -->
                            <div class="row">

                                <div class="col-lg-12 col-md-12"> <!-- left column starts here  -->
                                    <!-- ************** upper row added here *********-->

                                    <div class="search_form">
                                        <div class="row">  <!--  new row starts here -->

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">Warehouse</label>
                                                    <select name="warehouse_id" class="inputs_up form-control" id="warehouse_id">
                                                        <option value="0">Select Warehouse</option>
                                                        @foreach($warehouses as $warehouse)
                                                            <option value="{{$warehouse->wh_id}}" data-warehouse_name="{{$warehouse->wh_title}}"
                                                                    {{$warehouse->wh_id == 2 ? 'selected':''}}>{{$warehouse->wh_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="warehouse_name" class="inputs_up inputs_up_invoice  text-right form-control" id="warehouse_name">

                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">Type</label>
                                                    <select name="insert_type" class="inputs_up form-control" id="insert_type">
                                                        <option value="1">New Purchase</option>
                                                        <option value="0">Old Items</option>

                                                    </select>

                                                    <span id="demo10" class="validate_sign"> </span>
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
                                                        <th scope="col" class=" text-right wdth_5">Qty</th>
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

                                                            <input type="text" name="product_code" class="inputs_up inputs_up_invoice  text-right form-control" id="product_code"
                                                                   placeholder="Code" min="1" tabindex="1" onfocus="this.select();">


                                                            <span id="demo2" class="validate_sign"> </span>
                                                        </td>
                                                        <td class=" wdth_5" hidden>
                                                        </td>
                                                        <td class=" wdth_5">
                                                            <input type="number" name="quantity" class="inputs_up inputs_up_invoice  text-right form-control" id="quantity"
                                                                   placeholder="Qty" min="1" tabindex="2" onfocus="this.select();">
                                                            <span id="demo11" class="validate_sign"></span>
                                                        </td>

                                                        <td class="w-5p text-right wdth_5">

                                                            <button id="first_add_more" class="btn btn-success btn-sm" onclick="add_sale()" type="button">
                                                                <i class="fa fa-plus"></i> Add
                                                            </button>

                                                            <button style="display: none; background-color: red !important" id="cancel_button" class="btn btn-danger btn-sm" onclick="cancel_all()" type="button">
                                                                <i class="fa fa-times"></i> Cancel
                                                            </button>

                                                            <span id="demo201" class="validate_sign"> </span>

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
                                                                            <input type="number" name="total_items" class="text-right p-0 form-control total-items-field" id="total_items" placeholder="0.00" readonly>
                                                                            <span id="demo16" class="validate_sign"></span>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="border-right-0  border-top-0">
                                                                            <label class="total-items-label">Total Qty</label>
                                                                        </td>

                                                                        <td class="pt-0 pl-0 pb-0 border-left-0  border-top-0">
                                                                            <input type="number" name="total_qty" class="text-right p-0 form-control total-items-field" id="total_qty" placeholder="0
                                                                            .00" readonly>
                                                                            <span id="demo16" class="validate_sign"></span>
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
                                    <button type="button" name="save" id="save" class="save_button form-control"
                                            onclick="jQuery('#f1').submit();"
                                    >
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                    <span id="demo28" class="validate_sign"></span>
                                </div>
                            </div>
                        </div>

                            <input type="hidden" name="products" id="products">

                    </form>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let account = document.getElementById("account"),
                totalAmount = document.getElementById("total_amount");
            validateInputIdArray = [
                account.id,
                totalAmount.id,
            ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>


        jQuery("#warehouse_id").change(function () {

            var warehouse_name = jQuery('option:selected', this).attr('data-warehouse_name');

            jQuery("#warehouse_name").val(warehouse_name);
        });

        function popvalidation() {
            isDirty = true;

            var product_code = document.getElementById("product_code").value;
            // var product_name = document.getElementById("product_name").value;
            var quantity = document.getElementById("quantity").value;
            var warehouse_id = document.getElementById("warehouse_id").value;


            var flag_submit = true;
            var focus_once = 0;

            if (warehouse_id == "0") {
                document.getElementById("demo1").innerHTML = "required";
                if (focus_once == 0) {
                    jQuery("#warehouse_id").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }else {
                document.getElementById("demo1").innerHTML = "";
            }



            if (numberofsales == 0) {
                var isDirty = false;
                if (product_code == "") {
                    document.getElementById("demo2").innerHTML = "";
                    if (focus_once == 0) {
                        jQuery("#product_code").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo2").innerHTML = "";
                }

                if (quantity == "" || quantity == 0) {
                    // document.getElementById("demo11").innerHTML = "";
                    if (focus_once == 0) {
                        jQuery("#quantity").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    if (!validatequantity(quantity)) {
                        //  document.getElementById("demo11").innerHTML = "";
                        if (focus_once == 0) {
                            jQuery("#quantity").focus();
                            focus_once = 1;
                        }
                        flag_submit = false;
                    }
                    else {
                        //  document.getElementById("demo11").innerHTML = "";
                    }
                }


                document.getElementById("demo28").innerHTML = "Press Add Button to Add Sale";
                flag_submit = false;
            } else {
                document.getElementById("demo28").innerHTML = "";
            }



           return flag_submit;

        }


        var check_add = 0;
        jQuery("#product_code").change(function () {

            jQuery("#quantity").val('1');
            // jQuery("#quantity").focus();

            if ($("#add_auto").is(':checked')) {
                $("#first_add_more").click();  // checked
                check_add = 1;

                jQuery("#product_code").focus();

            }
        });

    </script>

    <script>
        // $(document).on("keydown", ".select2-search__field", function () {
        $(document).on("keyup", "#product_code", function () {
            var pname = jQuery(this).val();

            var total_qty=0;

            if (check_add != 1) {
                if (pname != '') {
                    $.each(sales, function (index, entry) {
                        if (entry[0] == pname) {

                            jQuery(".select2-search__field").val('');

                            if (index != 0) {
                                jQuery("#" + index).remove();

                                delete sales[index];
                            }
                            counter++;


                            var selected_code_value = entry[0];
                            // var product_name = entry[1];
                            var qty = entry[1];

                            qty = +entry[1] + +1;

                            numberofsales = Object.keys(sales).length;


                            sales[counter] = [selected_code_value, qty];

                            numberofsales = Object.keys(sales).length;

                            jQuery("#table_body").prepend('<tr id=' + counter + '><td class="wdth_1">' + selected_code_value + '</td><td class="wdth_8 text-right">' + qty + '</td><td align="right" class="wdth_4"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_sale(' + counter + ')><i class="fa fa-edit"></i></a></td></tr>');


                            // jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
                            // jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

                            jQuery("#product_code").val("");
                            jQuery("#quantity").val("");


                            jQuery("#products").val(JSON.stringify(sales));
                            jQuery("#cancel_button").hide();
                            // jQuery("#"+current_item).show();
                            jQuery("#save").show();
                            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                            jQuery("#total_items").val(numberofsales);

                            jQuery("#product_code").focus();

                            // $('#product_code').select2('open');

                        }
                    });

                    cal_qty();
                }
            }
            check_add = 0;
        });


        function cal_qty(){
            var total_qty = 0;

            $.each(sales, function (index, entry) {
                total_qty +=+entry[1];

                jQuery("#total_qty").val(total_qty);
            });
        }


    </script>

    <script>
        // adding packs into table
        var numberofsales = 0;
        var counter = 0;
        var sales = {};
        var global_id_to_edit = 0;
        var total_discount = 0;


        function add_sale() {

            var product_code = document.getElementById("product_code").value;
            // var product_name = document.getElementById("product_name").value;
            var quantity = document.getElementById("quantity").value;


            var flag_submit1 = true;
            var focus_once1 = 0;

            if (product_code == "") {
                document.getElementById("demo2").innerHTML = "";
                if (focus_once1 == 0) {
                    jQuery("#product_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {
                document.getElementById("demo2").innerHTML = "";
            }

            if (quantity == "" || quantity == 0) {
                // document.getElementById("demo11").innerHTML = "";
                if (focus_once1 == 0) {
                    jQuery("#quantity").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {
                if (!validatequantity(quantity)) {
                    //   document.getElementById("demo11").innerHTML = "";
                    if (focus_once1 == 0) {
                        jQuery("#quantity").focus();
                        focus_once1 = 1;
                    }
                    flag_submit1 = false;
                }
                else {

                    //  document.getElementById("demo11").innerHTML = "";
                }
            }

            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete sales[global_id_to_edit];
                }
                counter++;



                var checkedValue = [];

                // var product_name = jQuery("#product_name option:selected").text();
                var selected_code_value = jQuery("#product_code").val();
                var qty = jQuery("#quantity").val();

                numberofsales = Object.keys(sales).length;

                if (numberofsales == 0) {
                    jQuery("#table_body").html("");
                }

                sales[counter] = [selected_code_value, qty];

                numberofsales = Object.keys(sales).length;

                jQuery("#table_body").prepend('<tr id=' + counter + '><td class="wdth_1">' + selected_code_value + '</td><td class="wdth_8 text-right">'
                    + qty + '</td><td align="right" class="wdth_4"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_sale(' + counter + ')><i class="fa fa-edit"></i></a></td></tr>');

                jQuery("#product_code").val("");
                jQuery("#quantity").val("");

                jQuery("#products").val(JSON.stringify(sales));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#total_items").val(numberofsales);

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();

                cal_qty();
            }
        }


        function delete_sale(current_item) {

            jQuery("#" + current_item).remove();
            var temp_sales = sales[current_item];

            delete sales[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#products").val(JSON.stringify(sales));

            if (isEmpty(sales)) {
                numberofsales = 0;
            }

            var number_of_sales = Object.keys(sales).length;
            jQuery("#total_items").val(number_of_sales);

            cal_qty();
        }


        function edit_sale(current_item) {

            jQuery("#"+current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_sales = sales[current_item];

            jQuery("#product_code").val(temp_sales[0]);
            jQuery("#quantity").val(temp_sales[1]);

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            var newvaltohide = jQuery("#product_code").val();

            jQuery("#quantity").val("");

            jQuery("#cancel_button").hide();

            // jQuery(".table-responsive").show();
            jQuery("#"+global_id_to_edit).show();

            jQuery("#save").show();

            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');
            global_id_to_edit = 0;

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

        }

        function validatequantity(pas) {
            var pass = /^[0-9]*$/;

            if (pass.test(pas)) {
                return true;
            }
            else {
                return false;
            }
        }

        function validaterate(pas) {
            var pass = /^\d*\.?\d*$/;

            if (pass.test(pas)) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>

    <style type="text/css">

        /* Hide HTML5 Up and Down arrows. */
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

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
            jQuery("#product_code").focus();
            jQuery("#warehouse_id").select2();

            $( "#warehouse_id" ).trigger( "change" );

        });

        window.addEventListener('keydown', function (e) {
            if (e.which == 113) {
                // $('#product_code').select2('open');
            }
            if (e.keyCode == 65 && e.altKey) {
                $("#first_add_more").click();
            }
        });
    </script>

    <script>
        $('#view_detail').click(function() {

            var btn_name = jQuery("#view_detail").html();

            if(btn_name=='View Detail'){

                jQuery("#view_detail").html('Hide Detail');
            }else{
                jQuery("#view_detail").html('View Detail');
            }
        });

        function allowOnlyNumber(evt)
        {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>

@endsection


