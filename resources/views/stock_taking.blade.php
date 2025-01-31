@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Stock Taking</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <a class="add_btn list_link add_more_button" href="{{ route('stock_taking_list') }}" role="button">
                                <i class="fa fa-list"></i> Stock Taking List
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx"><!-- invoice box start -->

                        <form name="f1" class="f1" id="f1" onsubmit="return checkForm()" action="{{ route('submit_stock_taking') }}" method="post">

                        @csrf
                        <!-- main row ends here --> <!-- first row ends here -->

                            <!-- lower row starts here -->
                            <div class="row">

                                <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Warehouse
                                        </label>
                                        <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="warehouse" id="warehouse" required data-rule-required="true" data-msg-required="Please Select Warehouse">
                                            <option value="">Select Warehouse</option>
                                            @foreach($warehouses as $warehouse)
                                                <option
                                                    value="{{$warehouse->wh_id}}" >{{$warehouse->wh_title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- row end here -->

                            <!-- lower row starts here -->
                            <div class="row">

                                <div class="col-lg-12 col-md-12"> <!-- left column starts here  -->
                                    <!-- ************** upper row added here *********-->

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
                                                    <th scope="col" class=" wdth_2">Product Name</th>
                                                    <th scope="col" class=" text-right wdth_5">Qty</th>
                                                    <th scope="col" class=" text-right wdth_5">Bonus</th>
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
                                                        <select name="product_code" class="inputs_up inputs_up_invoice form-control" id="product_code" tabindex="8">
                                                            <option value="0">Code</option>
                                                        </select>
                                                        <span id="demo8" class="validate_sign"> </span>
                                                    </td>
                                                    <td class=" wdth_2">
                                                        <select name="product_name" class="inputs_up inputs_up_invoice form-control" id="product_name" tabindex="9">
                                                            <option value="0">Product</option>
                                                        </select>

                                                    </td>
                                                    <td class=" wdth_5" hidden>
                                                    </td>
                                                    <td class=" wdth_5">
                                                        <input type="number" name="quantity" class="inputs_up inputs_up_invoice  text-right form-control" id="quantity"
                                                               placeholder="Qty" min="1" tabindex="11" onfocus="this.select();">
                                                        <span id="demo11" class="validate_sign"></span>
                                                    </td>
                                                    <td class=" wdth_5">
                                                        <input type="number" name="bonus" class="inputs_up inputs_up_invoice  text-right form-control" id="bonus" placeholder="Bonus" tabindex="12">
                                                        <span id="demo12" class="validate_sign"></span>
                                                    </td>
                                                    <td class="w-5p text-right wdth_5">

                                                        <button id="first_add_more" class="btn btn-success btn-sm" onclick="add_sale()" type="button">
                                                            <i class="fa fa-plus"></i> Add
                                                        </button>

                                                        <button style="display: none; background-color: red !important" id="cancel_button" class="btn btn-danger btn-sm" onclick="cancel_all()"
                                                                type="button">
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
                                                                    <input type="number" name="total_items" class="text-right p-0 form-control total-items-field" id="total_items" placeholder="0.00"
                                                                           required data-rule-required="true" data-msg-required="Please Enter Product"
                                                                           readonly>
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
                                        <button type="submit" name="save" id="save" class="save_button form-control" onclick="return popvalidation()">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                        <span id="demo28" class="validate_sign"></span>
                                    </div>
                                </div>
                            </div>


                            <input type="hidden" name="stock_array" id="stock_array">

                        </form>
                    </div> <!-- white column form ends here -->
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript">
        function checkForm() {
            let warehouse = document.getElementById("warehouse"),
                total_items = document.getElementById("total_items"),
                validateInputIdArray = [
                    warehouse.id,
                    total_items.id,

                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2

            jQuery("#warehouse").select2();
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            setTimeout(function () {
                // jQuery("#product_code").focus();
                $('#product_code').select2('open');
            }, 500);

        });

        window.addEventListener('keydown', function (e) {
            if (e.which == 113) {
                $('#product_code').select2('open');
            }
            if (e.keyCode == 65 && e.altKey) {
                $("#first_add_more").click();
            }
        });
    </script>

    <script>

        // jQuery(function () {
        //     jQuery(document).on('keypress', function (e) {
        //         var that = document.activeElement;
        //         if (e.which == 13) {
        //             e.preventDefault();
        //             jQuery('[tabIndex=' + (+that.tabIndex + 1) + ']')[0].focus();
        //         }
        //     });
        // });
        window.addEventListener('keydown', function (e) {
            if (e.which == 113) {
                // $('#product_code').select2('open');
            }

            if (e.keyCode == 65 && e.altKey) {
                $("#first_add_more").click();
            }
        });

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        ////////////////////////////


    </script>

    <script>
        var check_add = 0;
        jQuery("#product_code").change(function () {

            var dropDown = document.getElementById('product_code');
            var pro_id = dropDown.options[dropDown.selectedIndex].value;

            var pname = jQuery('option:selected', this).val();

            if (pname == 'add_more') {
                window.open('add_product', '_blank');
            }

            jQuery("#quantity").val('1');

            jQuery("#product_name").select2("destroy");
            jQuery("#product_name").children("option[value^=" + pname + "]");

            jQuery("#product_name > option").each(function () {
                jQuery('#product_name option[value="' + pname + '"]').prop('selected', true);
            });

            jQuery("#bonus").val('');


            jQuery("#product_name").select2();
            jQuery("#quantity").focus();

            if ($("#add_auto").is(':checked')) {
                $("#first_add_more").click();  // checked
                check_add = 1;
                setTimeout(function () {
                    $('#product_code').select2('open');
                }, 100);
            }
        });

    </script>

    <script>
        jQuery("#product_name").change(function () {

            var dropDown = document.getElementById('product_name');
            var pro_id = dropDown.options[dropDown.selectedIndex].value;

            var pcode = jQuery('option:selected', this).val();

            if (pcode == 'add_more') {
                window.open('add_product', '_blank');
            }

            jQuery("#quantity").val('1');

            jQuery("#product_code").select2("destroy");
            jQuery("#product_code").children("option[value^=" + pcode + "]");

            jQuery("#product_code > option").each(function () {
                jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);
            });
            jQuery("#bonus").val('');
            // jQuery("#product_code").select2();

            jQuery("#product_code").select2();
            jQuery("#quantity").focus();

            if ($("#add_auto").is(':checked')) {
                $("#first_add_more").click();  // checked

                check_add = 1;
                setTimeout(function () {
                    $('#product_code').select2('open');

                }, 100);
            }
        });

    </script>

    <script>
        $(document).on("keydown", ".select2-search__field", function () {
            var pname = jQuery(this).val();

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

                            jQuery("#product_code").select2("destroy");
                            jQuery("#product_name").select2("destroy");

                            var checkedValue = [];

                            var selected_code_value = entry[0];
                            var product_name = entry[1];

                            var qty = entry[2];

                            qty = +entry[2] + +1;

                            var selected_bonus = entry[3];


                            numberofsales = Object.keys(sales).length;

                            if (numberofsales == 0) {
                                jQuery("#table_body").html("");
                            }

                            sales[counter] = [selected_code_value, product_name, qty, selected_bonus];

                            jQuery("#product_code option[value=" + selected_code_value + "]").attr("disabled", "true");
                            jQuery("#product_name option[value=" + selected_code_value + "]").attr("disabled", "true");
                            numberofsales = Object.keys(sales).length;

                            jQuery("#table_body").prepend('<tr id=' + counter + '><td class="wdth_1">' + selected_code_value + '</td><td > <div class="max_txt">' + product_name + '</div>  </td><td ' +
                                'class="wdth_8 text-right">' + qty + '</td><td class="wdth_8 text-right">' + selected_bonus + '</td><td align="right" class="wdth_4"><a class="edit_link btn btn-sm ' +
                                'btn-success" href="#" onclick=edit_sale(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');


                            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
                            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

                            jQuery("#quantity").val("");

                            jQuery("#bonus").val("");


                            jQuery("#stock_array").val(JSON.stringify(sales));
                            jQuery("#cancel_button").hide();
                            // jQuery(".table-responsive").show();
                            // jQuery("#"+current_item).show();
                            jQuery("#save").show();
                            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                            jQuery("#total_items").val(numberofsales);


                            jQuery(".edit_link").show();
                            jQuery(".delete_link").show();


                            jQuery("#product_code").select2();
                            jQuery("#product_name").select2();

                            $('#product_code').select2('open');

                        }

                    });
                }
            }
            check_add = 0;
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

            var quantity = document.getElementById("quantity").value;
            var bonus = document.getElementById("bonus").value;

            var flag_submit = true;
            var focus_once = 0;


            if (numberofsales == 0) {
                var isDirty = false;
                if (product_code == "0") {
                    document.getElementById("demo8").innerHTML = "";
                    if (focus_once == 0) {
                        jQuery("#product_code").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo8").innerHTML = "";
                }


                if (product_name == "0") {
                    //  document.getElementById("demo9").innerHTML = "";
                    if (focus_once == 0) {
                        jQuery("#product_name").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    //  document.getElementById("demo9").innerHTML = "";
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
                    } else {
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


        function add_sale() {

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;

            var quantity = document.getElementById("quantity").value;
            var bonus = document.getElementById("bonus").value;


            var flag_submit1 = true;
            var focus_once1 = 0;

            if (product_code == "0") {
                document.getElementById("demo8").innerHTML = "";
                if (focus_once1 == 0) {
                    jQuery("#product_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {
                document.getElementById("demo8").innerHTML = "";
            }


            if (product_name == "0") {
                // document.getElementById("demo9").innerHTML = "";
                if (focus_once1 == 0) {
                    jQuery("#product_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {
                // document.getElementById("demo9").innerHTML = "";
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
                } else {

                    //  document.getElementById("demo11").innerHTML = "";
                }
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete sales[global_id_to_edit];
                }
                document.getElementById("demo11").innerHTML = "";
                // document.getElementById("demo9").innerHTML = "";
                counter++;

                jQuery("#product_code").select2("destroy");
                jQuery("#product_name").select2("destroy");

                var checkedValue = [];

                var product_name = jQuery("#product_name option:selected").text();
                var selected_code_value = jQuery("#product_code option:selected").val();
                var qty = jQuery("#quantity").val();
                var selected_product_name = jQuery("#product_name").val();

                var selected_bonus = jQuery("#bonus").val();


                numberofsales = Object.keys(sales).length;

                if (numberofsales == 0) {
                    jQuery("#table_body").html("");
                }

                sales[counter] = [selected_code_value, product_name, qty, selected_bonus];

                jQuery("#product_code option[value=" + selected_code_value + "]").attr("disabled", "true");
                jQuery("#product_name option[value=" + selected_code_value + "]").attr("disabled", "true");
                numberofsales = Object.keys(sales).length;

                jQuery("#table_body").prepend('<tr id=' + counter + '><td class="wdth_1">' + selected_code_value + '</td><td > <div class="max_txt">' + product_name + '</div>  </td><td class="wdth_8 ' +
                    'text-right">' + qty + '</td><td class="wdth_8 text-right">' + selected_bonus + '</td><td align="right" class="wdth_4"><a class="edit_link btn btn-sm btn-success" href="#" ' +
                    'onclick=edit_sale(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');

                jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#quantity").val("");

                jQuery("#bonus").val("");


                jQuery("#product_sales_tax").val("");

                jQuery("#stock_array").val(JSON.stringify(sales));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#total_items").val(numberofsales);

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();


                jQuery("#product_code").select2();
                jQuery("#product_name").select2();


            }
        }


        function delete_sale(current_item) {

            jQuery("#" + current_item).remove();
            var temp_sales = sales[current_item];
            jQuery("#product_code option[value=" + temp_sales[0] + "]").attr("disabled", false);
            jQuery("#product_name option[value=" + temp_sales[0] + "]").attr("disabled", false);

            delete sales[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#stock_array").val(JSON.stringify(sales));

            if (isEmpty(sales)) {
                numberofsales = 0;
            }

            var number_of_sales = Object.keys(sales).length;
            jQuery("#total_items").val(number_of_sales);


            jQuery("#product_name").select2("destroy");
            jQuery("#product_name").select2();
            jQuery("#product_code").select2("destroy");
            jQuery("#product_code").select2();
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
            jQuery("#product_code option[value=" + temp_sales[0] + "]").attr("disabled", false);
            jQuery("#product_name option[value=" + temp_sales[0] + "]").attr("disabled", false);
            jQuery("#product_code > option").each(function () {
                jQuery('#product_code option[value="' + temp_sales[0] + '"]').prop('selected', true);
            });

            jQuery("#product_name").val(temp_sales[0]);

            jQuery("#quantity").val(temp_sales[2]);
            jQuery("#bonus").val(temp_sales[3]);

            var pro_id = temp_sales[0];

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            var newvaltohide = jQuery("#product_code").val();

            jQuery("#quantity").val("");

            jQuery("#product_code option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery("#product_name option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");


            jQuery("#bonus").val("");


            jQuery("#demo11").html("");
            // jQuery("#demo9").html("");

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

        function validatequantity(pas) {
            var pass = /^[0-9]*$/;

            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }

        function validaterate(pas) {
            var pass = /^\d*\.?\d*$/;

            if (pass.test(pas)) {
                return true;
            } else {
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
        $('#view_detail').click(function () {

            var btn_name = jQuery("#view_detail").html();

            if (btn_name == 'View Detail') {

                jQuery("#view_detail").html('Hide Detail');
            } else {
                jQuery("#view_detail").html('View Detail');
            }
        });

        function allowOnlyNumber(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        $('form').submit(function () {

            $(this).find(':submit').attr('disabled', 'disabled');
            // $(this).find(':submit').hide();
        });
    </script>
    <script>
        jQuery("#warehouse").change(function() {

            var warehouse_id = jQuery('option:selected', this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_product_stock_warehouse_wise",
                data:{warehouse_id: warehouse_id},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#product_code").html("");
                    jQuery("#product_code").append(data[0]);

                    jQuery("#product_name").html("");
                    jQuery("#product_name").append(data[1]);

                },
                error: function (jqXHR, textStatus, errorThrown) {}
            });


        });
    </script>
@endsection
