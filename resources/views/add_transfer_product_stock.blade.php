@extends('extend_index')
@section('content')
<link rel="stylesheet" href="{{ asset('public/css/simple_form.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/add_refresh_btn.css') }}">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Transfer Product Stock</h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{ route('transfer_product_stock_list') }}"
                                role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form class="highlight" name="f1" class="f1" id="f1" action="{{ route('submit_transfer_product_stock') }}"
                    onsubmit="return checkForm()" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="row">

                                <div class="form-group simple_form col-lg-2 col-md-3 col-sm-12 col-xs-12 simpleForm">
                                    <x-warehouse-component tabindex="1" name="warehouse_from" id="warehouse_from" class="refresh_warehouse" title="Transfer From"/>
                                </div>


                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">Product Code</label>
                                        <select tabindex="2" name="product" class="inputs_up form-control" id="product"
                                            data-rule-required="true" data-msg-required="Please Select Product Code">
                                            <option value="">Select Product</option>
                                        </select>
                                        <span id="demo2" class="validate_sign"> </span>
                                        <span id="stock" class="validate_sign">(Stock)</span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">Product</label>
                                        <select tabindex="3" name="product_name" class="inputs_up form-control"
                                            id="product_name" data-rule-required="true"
                                            data-msg-required="Please Select Product">
                                            <option value="">Select Product</option>
                                        </select>
                                    </div><!-- end input box -->
                                </div>
                                <div class="form-group simple_form col-lg-2 col-md-3 col-sm-12 col-xs-12 simpleForm">
                                    <x-warehouse-component tabindex="1" name="warehouse_to" id="warehouse_to" class="refresh_warehouse" title="Transfer To"/>
                                </div>

                                <input tabindex="5" type="hidden" name="scale_size" id="scale_size"
                                    data-rule-required="true" data-msg-required="Please Enter Quantity"
                                    class="inputs_up
                                        form-control lower_inputs"
                                    placeholder="Quantity" value="{{ old('scale_size') }}" autocomplete="off"
                                    onfocus="this.select();"
                                    onkeypress="return
                                        allow_only_number_and_decimals(this,event);"
                                    readonly>

                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">Quantity</label>
                                        <input tabindex="5" type="text" name="quantity" id="quantity"
                                            data-rule-required="true" data-msg-required="Please Enter Quantity"
                                            class="inputs_up form-control" placeholder="Quantity"
                                            value="{{ old('quantity') }}" autocomplete="off" onfocus="this.select();"
                                            onkeypress="return allow_only_number_and_decimals(this,event);">
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="">Remarks</label>
                                        <input tabindex="6" type="text" name="remarks" id="remarks"
                                            class="remarks inputs_up form-control" value="{{ old('remarks') }}"
                                            placeholder="Remarks" />
                                        <span id="demo5" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button tabindex="7" type="reset" name="cancel" id="cancel"
                                        class="cancel_button btn btn-sm btn-secondary">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button tabindex="8" type="submit" name="save" id="save"
                                        class="save_button btn btn-sm btn-success">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                    <input type="hidden" name="stock_qty" id="stock_qty">
                                </div>
                            </div>
                        </div> <!-- left column ends here -->
                    </div> <!--  main row ends here -->
                </form>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->
    </div><!-- row end -->
@endsection

@section('scripts')
    <style>
        /* Hide HTML5 Up and Down arrows. */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
    {{-- required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let warehouse_from = document.getElementById("warehouse_from"),
                product = document.getElementById("product"),
                product_name = document.getElementById("product_name"),
                warehouse_to = document.getElementById("warehouse_to"),
                quantity = document.getElementById("quantity"),
                validateInputIdArray = [
                    warehouse_from.id,
                    product.id,
                    product_name.id,
                    warehouse_to.id,
                    quantity.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

    </script>

    <script type="text/javascript">
        jQuery(function() {
            jQuery('.datepicker1').datepicker({
                language: 'en',
                dateFormat: 'dd-M-yyyy'
            });
        });
    </script>

    <script>
        // **********************************************************only number enter **********************************************************
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }


        function validatebcode(pas) {
            var pass = /^[0-9]*$/;
            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }
    </script>

    <script>
        jQuery("#warehouse_from").change(function() {

            var warehouse_id = jQuery('option:selected', this).val();

            jQuery("#warehouse_to").select2("destroy");

            jQuery("#warehouse_to option:disabled").attr("disabled", false);
            jQuery("#warehouse_to option[value=" + warehouse_id + "]").attr("disabled", "true");

            jQuery('#warehouse_to option[value="' + 0 + '"]').prop('selected', true);

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_product_stock_warehouse_wise",
                data: {
                    warehouse_id: warehouse_id
                },
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function(data) {

                    jQuery("#product").html("");
                    jQuery("#product").append(data[0]);

                    jQuery("#product_name").html("");
                    jQuery("#product_name").append(data[1]);

                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });

            jQuery("#warehouse_to").select2();
        });
    </script>

    <script>
        jQuery("#product").change(function() {

            var stock = jQuery('option:selected', this).attr('data-stock');
            var scale_size = jQuery('option:selected', this).attr('data-scale_size');

            jQuery("#scale_size").val('');
            jQuery("#scale_size").val(scale_size);
            jQuery("#stock_qty").val(stock);

            jQuery("#stock").html("");
            jQuery("#stock").append('(' + stock + ')');


            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_name").select2("destroy");

            // jQuery("#product_name > option").each(function () {
            jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery("#product_name").select2();

        });
    </script>

    <script>
        jQuery("#product_name").change(function() {


            var stock = jQuery('option:selected', this).attr('data-stock');
            var scale_size = jQuery('option:selected', this).attr('data-scale_size');

            jQuery("#scale_size").val('');
            jQuery("#scale_size").val(scale_size);
            jQuery("#stock_qty").val(stock);

            jQuery("#stock").html("");
            jQuery("#stock").append('(' + stock + ')');

            var pcode = jQuery('option:selected', this).val();

            jQuery("#product").select2("destroy");

            // jQuery("#product > option").each(function () {
            jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery("#product").select2();

        });
    </script>

    <script type="text/javascript">
        jQuery(function() {
            jQuery(document).on('keypress', function(e) {
                var that = document.activeElement;
                if (e.which == 13) {
                    e.preventDefault();
                    jQuery('[tabIndex=' + (+that.tabIndex + 1) + ']')[0].focus();
                }
            });
        });

        function validate_form() {
            var product = document.getElementById("product").value;
            var warehouse_to = document.getElementById("warehouse_to").value;
            var warehouse_from = document.getElementById("warehouse_from").value;
            var qty = document.getElementById("quantity").value;

            var flag_submit = true;
            var focus_once = 0;
            //
            //
            // if (warehouse_from.trim() == "0") {
            //     document.getElementById("demo1").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#warehouse_from").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo1").innerHTML = "";
            // }
            //
            // if (product.trim() == "") {
            //     document.getElementById("demo2").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#product").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo2").innerHTML = "";
            // }
            //
            // if (warehouse_to.trim() == "0") {
            //     document.getElementById("demo3").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#warehouse_to").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo3").innerHTML = "";
            // }
            //
            //
            // if (qty.trim() == "" || qty <= 0) {
            //
            //     document.getElementById("demo4").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#quantity").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //         document.getElementById("demo4").innerHTML = "";
            // }

            var stock = jQuery("#stock").text();
            stock = parseInt(stock.substr(1).slice(0, -1));

            if (parseInt(qty) > stock) {
                // alert('Qty not greater than stock');
                document.getElementById("demo4").innerHTML = "Qty not greater than stock";
                if (focus_once == 0) {
                    jQuery("#qty").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            return flag_submit;
        }
    </script>

    <script>
        jQuery(document).ready(function() {
             // refresh or add botton css
             $('.col_short_btn').addClass("add_btn");
            // Initialize select2
            jQuery("#product").select2();
            jQuery("#product_name").select2();
            jQuery("#warehouse_to").select2();
            jQuery("#warehouse_from").select2();

        });
    </script>
@endsection
