@extends('extend_index')

@section('styles_get')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/custom-search/custom-search.css') }}">

    {{-- nabeel added css blue --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">
@stop


@section('content')
    <link rel="stylesheet" href="{{ asset('public/css/simple_form.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/add_refresh_btn.css') }}">

    <style>
        #add_transfer_product_stock_pattern_excel {
            padding: 10px 10px 10px 10px;
        }


        .input_bx {
            background: none;
        }

        .inputs_up {
            height: auto;
        }

        .add_btn,
        .refresh_btn,
        .form_header .list_btn .add_btn {
            background-color: #ffffff;
            color: #000000;
            font-weight: bold;
            border-style: solid;
        }


        /*.add_btn, .refresh_btn, .form_header .list_btn .add_btn {*/
        /*    background-color: #4A4B5C;*/
        /*    color: #fff;*/
        /*}*/

        .excel_con .excel_box:after {
            background-color: transparent;
        }


        .inputs_up:focus {
            box-shadow: 0 0 3pt 2pt #fc7307;
        }
    </style>
    <div class="row">
        <div id="main_bg" class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Trade Transfer Product Stock</h4>
                    </div>
                    <div class="list_btn">
                        <a class="add_btn list_link add_more_button"
                            href="{{ route('trade_transfer_product_stock_list') }}"
                            style="background-color: #4A4B5C; color: #fff;" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1 mt-2" id="f1"
                action="{{ route('submit_trade_transfer_product_stock') }}" onsubmit="return checkForm()"
                method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Transfer From
                                <a href="{{ route('add_warehouse') }}" class="add_btn btn btn-sm btn-info" target="_blank"
                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                    data-placement="bottom" data-html="true"
                                    data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                    <i class="fa fa-plus"></i>
                                </a>
                                <a id="refresh_warehouse_from" class="add_btn btn btn-sm btn-info" data-container="body"
                                    data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                    data-html="true"
                                    data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                    <l class="fa fa-refresh"></l>
                                </a>
                            </label>
                            <select tabindex="1" name="warehouse_from" class="inputs_up form-control"
                                id="warehouse_from" required data-rule-required="true"
                                data-msg-required="Please Select Warehouse">
                                <option value="0">Select Warehouse</option>

                                @foreach ($warehouses as $warehouse)
                                    <option
                                        value="{{ $warehouse->wh_id }}"{{ $warehouse->wh_id == old('warehouse_from') ? 'selected="selected"' : '' }}>
                                        {{ $warehouse->wh_title }}</option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Product Code <span id="stock"
                                    class="validate_sign">(Stock)</span>
                            </label>
                            <select tabindex="2" name="product" class="inputs_up form-control" id="product"
                                data-rule-required="true" data-msg-required="Please Select Product Code">
                                <option value="">Select Product</option>
                            </select>
                            <span id="demo2" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
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
                    <div class="simple_form form-group col-lg-2 col-md-3 col-sm-12"
                        style="background: none !important">
                        <x-warehouse-component tabindex="1" name="warehouse_to" id="warehouse_to"
                            class="refresh_warehouse" title="Transfer To" />
                    </div>
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Pack Quantity</label>
                            <input tabindex="5" type="text" name="pack_quantity" id="pack_quantity"
                                data-rule-required="true" data-msg-required="Please Enter Pack Quantity"
                                class="inputs_up
                            form-control"
                                placeholder="Quantity" value="{{ old('pack_quantity') }}" autocomplete="off"
                                onfocus="this.select();"
                                onkeypress="return
                            allow_only_number_and_decimals(this,event)"
                                onkeydown="return not_plus_minus(event)">

                            <span id="demo4" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Loose Quantity</label>
                            {{-- Hamad set tab index --}}
                            <input tabindex="6" type="text" name="loose_quantity" id="loose_quantity"
                                data-rule-required="true" data-msg-required="Please Enter Loose Quantity"
                                class="inputs_up
                            form-control"
                                placeholder="Quantity" value="{{ old('loose_quantity') }}"
                                autocomplete="off" onfocus="this.select();"
                                onkeypress="return
                            allow_only_number_and_decimals(this,event)"
                                onkeydown="return not_plus_minus(event)">
                            <span id="demo4" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="">Remarks</label>
                            {{-- Hamad set tab index --}}
                            <input tabindex="7" type="text" name="remarks" id="remarks"
                                onkeydown="return not_plus_minus(event)"
                                class="remarks inputs_up form-control" value="{{ old('remarks') }}"
                                placeholder="Remarks" />
                            <span id="demo5" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>


                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Pack Size</label>
                            <input type="text" name="pack_size" id="pack_size" data-rule-required="true"
                                data-msg-required="Please Enter Quantity"
                                class="inputs_up
                            form-control lower_inputs"
                                placeholder="Quantity" value="{{ old('pack_size') }}" autocomplete="off"
                                onfocus="this.select();" readonly>
                            <span id="demo4" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12" hidden>
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Scale Size</label>
                            <input tabindex="5" type="text" name="scale_size" id="scale_size"
                                data-rule-required="true" data-msg-required="Please Enter Quantity"
                                class="inputs_up
                            form-control lower_inputs"
                                placeholder="Quantity" value="{{ old('scale_size') }}" autocomplete="off"
                                onfocus="this.select();"
                                onkeypress="return
                            allow_only_number_and_decimals(this,event);"
                                readonly>
                            <span id="demo4" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Total Quantity</label>
                            <input type="text" name="quantity" id="quantity" data-rule-required="true"
                                data-msg-required="Please Enter Quantity"
                                class="inputs_up
                            form-control lower_inputs"
                                placeholder="Quantity" value="{{ old('quantity') }}" autocomplete="off"
                                onfocus="this.select();"
                                onkeypress="return allow_only_number_and_decimals(this,event);" readonly>
                            <span id="demo4" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 ml-auto mt-4 text-right">
                        {{-- Hamad set tab index --}}
                        <button tabindex="8" type="reset" name="cancel" id="cancel" class="btn btn-sm btn-secondary ">
                            {{-- <i class="fa fa-eraser"></i> --}}
                            Cancel
                        </button>
                        {{-- Hamad set tab index --}}
                        <button tabindex="9" type="submit" name="save" id="save" class="btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                        <input type="hidden" name="stock_qty" id="stock_qty">
                    </div>
                </div>
            </form>
        </div> <!-- white column form ends here -->
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


        jQuery("#refresh_warehouse_from").click(function() {
            // alert('warehouse');
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_warehouse",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function(data) {

                    jQuery("#warehouse_from").html(" ");
                    jQuery("#warehouse_from").append(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);s
                }
            });
        });

        jQuery("#refresh_warehouse_to").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_warehouse",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',

                success: function(data) {

                    jQuery("#warehouse_to").html(" ");
                    jQuery("#warehouse_to").append(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
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
            var unit_title = jQuery('option:selected', this).attr('data-unit_title');

            jQuery("#stock_qty").val(stock);

            jQuery("#stock").html("");
            jQuery("#stock").append('(' + stock + ')');

            jQuery("#scale_size").val('');
            jQuery("#scale_size").val(scale_size);
            jQuery("#pack_size").val('');
            jQuery("#pack_size").val(scale_size + ' ' + unit_title);

            var pack_quantity = $("#pack_quantity").val();
            var loose_quantity = $("#loose_quantity").val();
            var total_quantity = +(scale_size * pack_quantity) + +loose_quantity;
            $("#quantity").val(total_quantity);

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
            var unit_title = jQuery('option:selected', this).attr('data-unit_title');

            jQuery("#stock_qty").val(stock);

            jQuery("#stock").html("");
            jQuery("#stock").append('(' + stock + ')');

            jQuery("#scale_size").val('');
            jQuery("#scale_size").val(scale_size);
            jQuery("#pack_size").val('');
            jQuery("#pack_size").val(scale_size + ' ' + unit_title);

            var pack_quantity = $("#pack_quantity").val();
            var loose_quantity = $("#loose_quantity").val();
            var total_quantity = +(scale_size * pack_quantity) + +loose_quantity;
            $("#quantity").val(total_quantity);
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

            // setTimeout(function () {
            $("#warehouse_from").focus();
            // }, 1500);




            // alert();

        });
    </script>
    <script>
        $("#pack_quantity").keyup(function() {

            var scale_size = $("#scale_size").val();
            var pack_quantity = $("#pack_quantity").val();

            var loose_quantity = $("#loose_quantity").val();
            var total_quantity = +(scale_size * pack_quantity) + +loose_quantity;
            $("#quantity").val(total_quantity);
        });
        $("#loose_quantity").keyup(function() {
            var scale_size = $("#scale_size").val();
            var pack_quantity = $("#pack_quantity").val();
            var loose_quantity = $("#loose_quantity").val();
            var total_quantity = +(scale_size * pack_quantity) + +loose_quantity;
            $("#quantity").val(total_quantity);
        });

        // nabeel added simple scripts start

        document.addEventListener('keydown', function(event) {
            if (event.keyCode === 9) { // means tab


                // // for upper inputs tab functionality
                if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#warehouse_from")[0]) {
                    $("#product").focus();
                } else if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#product")[0]) {
                    $("#product_name").focus();
                } else if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#product_name")[0]) {
                    $("#warehouse_to").focus();
                } else if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#warehouse_to")[0]) {
                    $("#pack_quantity").focus();
                } else if ($("#pack_quantity")[0] == $(document.activeElement)[0]) {
                    $("#loose_quantity").focus();
                } else if ($("#loose_quantity")[0] == $(document.activeElement)[0]) {
                    $("#remarks").focus();
                }

                event.preventDefault();
            }

        });



        // stop inputs to write + and -
        function not_plus_minus(evt) {
            if (evt.keyCode == 107 || evt.keyCode == 109) {
                evt.preventDefault();
            }
        }



        // nabeel added focus scripts start

        document.addEventListener('keyup', function(event) {

            if (event.keyCode === 107) { // means plus(+)

                // // for upper inputs tab functionality
                if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#warehouse_from")[0]) {
                    $("#product").focus();
                } else if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#product")[0]) {
                    $("#product_name").focus();
                } else if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#product_name")[0]) {
                    $("#warehouse_to").focus();
                } else if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#warehouse_to")[0]) {
                    $("#pack_quantity").focus();
                } else if ($("#pack_quantity")[0] == $(document.activeElement)[0]) {
                    $("#loose_quantity").focus();
                } else if ($("#loose_quantity")[0] == $(document.activeElement)[0]) {
                    $("#remarks").focus();
                }

                event.preventDefault();
            }


            if (event.keyCode === 109) { //means minus(-)
                // for upper inputs tab functionality
                if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#warehouse_from")[0]) {
                    // $("#product").focus();
                }
                if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#product")[0]) {
                    $("#warehouse_from").focus();
                }
                if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#product_name")[0]) {
                    $("#product").focus();
                }
                if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $(
                        "#warehouse_to")[0]) {
                    $("#product_name").focus();
                } else if ($("#pack_quantity")[0] == $(document.activeElement)[0]) {
                    $("#warehouse_to").focus();
                } else if ($("#loose_quantity")[0] == $(document.activeElement)[0]) {
                    $("#pack_quantity").focus();
                } else if ($("#remarks")[0] == $(document.activeElement)[0]) {
                    $("#loose_quantity").focus();
                }
            }

        });

        document.addEventListener('keyup', function(event) {


            if (event.keyCode === 107 || event.keyCode === 109) {

                if ($(".select2-search__field")[0] == $(document.activeElement)[0]) {

                    // to stop user on writing plus(+) and minus(-) on dropdown inputs
                    var value = document.querySelector(".select2-search__field").value;
                    document.querySelector(".select2-search__field").value = value.substr(0, value.length - 1);

                }
                event.preventDefault();
            }
        });

        // when we type f1,f2 and f3 on some input default function of browser is called. To stop it we made this script
        document.addEventListener('keydown', function(e) {

            if (e.ctrlKey && e.key === "s") { // when you press (ctrl + s) save the invoice
                $("#save").click();
                e.preventDefault();
            }

        });

        // nabeel added focus scripts end
    </script>

@endsection
