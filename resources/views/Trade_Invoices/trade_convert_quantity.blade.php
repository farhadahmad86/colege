@extends('extend_index')

@section('styles_get')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/custom-search/custom-search.css') }}">

    {{--        nabeel added css blue--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">
@stop

@section('content')
    <link rel="stylesheet" href="{{ asset('public/css/simple_form.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/add_refresh_btn.css') }}">

    <style>

        #add_transfer_product_stock_pattern_excel {
            padding: 10px 10px 10px 10px;
        }

         .inputs_up{
            height: auto;
        }

        .add_btn, .refresh_btn, .form_header .list_btn .add_btn {
            background-color: #ffffff;
            color: #000000;
            font-weight: bold;
            border-style: solid;
        }


        .add_btn, .refresh_btn, .form_header .list_btn .add_btn {
            background-color: #4A4B5C;
            color: #fff;
        }

        .excel_con .excel_box:after {
            background-color: transparent;
        }


        .border {
            border: 2px solid white!important;
        }

        .inputs_up:focus  {
            box-shadow: 0 0 3pt 2pt #fc7307;
        }


    </style>



    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div id="main_bg" class="container-fluid search-filter form-group form_manage">
                <div class="form_header">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Trade Convert Quantity</h4>
                        </div>
                        <div class="list_btn">
                            <a class="add_btn list_link add_more_button" href="{{route('trade_convert_quantity_list')}}" role="button">
                                <l class="fa fa-list"></l>
                                view list
                            </a>
                        </div>
                    </div>
                </div>
                <form name="f1" class="highlight f1" id="f1" action="{{route('submit_trade_convert_quantity')}}" method="post" onsubmit="return checkForm()">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="form-group col-lg-10 col-md-9 col-sm-12">
                                    {{-- trad_convert-form --}}
                                    <div class="row">
                                        <div class="form-group col-lg-2 col-md-3  col-sm-12 simple_form" style="background:none !important"><!-- invoice column start -->
                                            <x-warehouse-component tabindex="1" name="warehouse" id="warehouse" class="refresh_warehouse" title="Warehouse"/>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3  col-sm-12">
                                            <div class="input_bx">
                                                <label class="required">Product Barcode</label>
                                                <select name="product_code" class="inputs_up form-control required" id="product_code" autofocus data-rule-required="true"
                                                        data-msg-required="Please Select Product Code">
                                                    <option value="0">Select Product Code</option>
                                                    @foreach ($products as $product)
                                                        <option value='{{ $product->pro_p_code }}' data-scale_size="{{ $product->unit_scale_size }}" data-unit_title="{{ $product->unit_title}}">{{ $product->pro_p_code }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3  col-sm-12">
                                            <div class="input_bx">
                                                <label class="required">Product Title</label>
                                                <select name="product_title" class="inputs_up form-control required" id="product_title" autofocus
                                                        data-rule-required="true" data-msg-required="Please Select Product Title">
                                                    <option value="0">Select Product Title</option>
                                                    @foreach ($products as $product)
                                                        <option value='{{ $product->pro_title }}' data-product-code="{{ $product->pro_p_code }}" data-scale_size="{{ $product->unit_scale_size }}" data-unit_title="{{ $product->unit_title}}"
                                                        >{{$product->pro_title }}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                                <input type="hidden" id="product_title" name="product_title" hidden>--}}
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3  col-sm-12">
                                            <div class="input_bx">
                                                <label class="required">Remarks</label>


                                                <textarea name="remarks" id="remarks" class="inputs_up remarks form-control required" placeholder="Remarks" style="height: 35px;"
                                                          data-rule-required="true" onkeydown="return not_plus_minus(event)" data-msg-required="Please Enter Remarks">{{ old('remarks')
                                                 }}</textarea>
                                                <span id="demo3" class="validate_sign"> </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3  col-sm-12" hidden>
                                            <div class="input_bx">
                                                <label class="required">Scale Size</label>
                                                <input type="number" name="scale_size" id="scale_size" class="inputs_up form-control" placeholder="Scale Size" autocomplete="off" value="{{ old
                                                ('scale_size')
                                                }}"
                                                       data-rule-required="true" data-msg-required="Please Scale Size" readonly>
                                                <span id="demo2" class="validate_sign"> </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3  col-sm-12">
                                            <div class="input_bx">
                                                <label class="required">Pack Quantity</label>
                                                <input type="number" onkeydown="return not_plus_minus(event)" name="pack_quantity" id="pack_quantity" class="inputs_up form-control" placeholder="Pack Quantity" autocomplete="off" value="{{ old
                                                ('pack_quantity') }}" data-rule-required="true" data-msg-required="Please Enter Pack Quantity">
                                                <span id="demo2" class="validate_sign"> </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3  col-sm-12">
                                            <div class="input_bx">
                                                <label class="required">Loose Quantity</label>
                                                <input type="number" onkeydown="return not_plus_minus(event)" name="loose_quantity" id="loose_quantity" class="inputs_up form-control" placeholder="Loose Quantity" autocomplete="off"
                                                       value="{{ old
                                                ('loose_quantity') }}" data-rule-required="true" data-msg-required="Please Enter Loose Quantity">
                                                <span id="demo2" class="validate_sign"> </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3  col-sm-12">
                                            <div class="input_bx">
                                                <label class="required">Pack Size</label>
                                                <input type="text" name="pack_size" id="pack_size" class="inputs_up form-control" placeholder="Pack Size" autocomplete="off" value="{{
                                                 old
                                                ('pack_size')
                                                }}"
                                                       data-rule-required="true" data-msg-required="Please Scale Size" readonly>
                                                <span id="demo2" class="validate_sign"> </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3  col-sm-12">
                                            <div class="input_bx">
                                                <label class="required">Total Quantity</label>
                                                <input type="number" name="quantity" id="quantity" class="inputs_up form-control" placeholder="Quantity" autocomplete="off" value="{{ old('quantity')
                                                 }}" data-rule-required="true" data-msg-required="Please Enter Quantity" readonly>
                                                <span id="demo2" class="validate_sign"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-md-3  col-sm-12">
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 border rounded">
                                            <div class="input_bx">
                                                {{--<label class="">Convert To/From Quantity</label>--}}
                                                <div class="custom-control custom-radio mb-10 mt-1" style="display: block;float: unset;">
                                                    <input type="radio" name="convert_qty" class="custom-control-input convert_qty" id="convert_qty1" value="1" required>
                                                    <label class="custom-control-label" for="convert_qty1">Convert Quantity for Sale</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-10 mt-1" style="display: block;float: unset;">
                                                    <input type="radio" name="convert_qty" class="custom-control-input convert_qty" id="convert_qty2" value="2">
                                                    <label class="custom-control-label" for="convert_qty2">Convert Quantity Not for Sale</label>
                                                </div>
                                                <span id="convert_qty_error_msg" class="validate_sign"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 border rounded convert_unit_div">
                                            <div class="input_bx">
                                                <label class="convert_unit_label">Convert To/From</label>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input type="radio" name="convert_unit" class="custom-control-input convert_unit" id="convert_unit1" value="1" required>
                                                    <label class="custom-control-label" for="convert_unit1">Hold</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input type="radio" name="convert_unit" class="custom-control-input convert_unit" id="convert_unit2" value="2">
                                                    <label class="custom-control-label" for="convert_unit2">Bonus</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input type="radio" name="convert_unit" class="custom-control-input convert_unit" id="convert_unit3" value="3">
                                                    <label class="custom-control-label" for="convert_unit3">Claim</label>
                                                </div>
                                                <span id="convert_unit_error_msg" class="validate_sign"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk form_controls">
                                    <button type="reset" name="cancel" id="cancel" class="invoice_frm_btn btn btn-sm btn-secondary">
                                        {{--<i class="fa fa-eraser"></i>--}}
                                        Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>


                </form>

            </div>


        </div>

    </div>

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let warehouse = document.getElementById("warehouse"),
                product_code = document.getElementById("product_code"),
                product_title = document.getElementById("product_title");
            quantity = document.getElementById("quantity");
            remarks = document.getElementById("remarks");
            validateInputIdArray = [
                warehouse.id,
                product_code.id,
                product_title.id,
                quantity.id,
                remarks.id,
            ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">
        jQuery(document).ready(function () {
             // refresh or add botton css
             $('.col_short_btn').addClass("add_btn");
            jQuery("#warehouse").select2();
            jQuery("#product_code").select2();
            jQuery("#product_title").select2();


            // alert(123);
            $("#warehouse").focus();

            jQuery("#product_code").change(function () {
                var product_code = jQuery('option:selected', this).val();
                $('#scale_size').val('');
                jQuery("#product_title").select2("destroy");
                jQuery('#product_title option[data-product-code="' + product_code + '"]').prop('selected', true);
                var scale_size = $("#product_code option:selected").attr('data-scale_size');
                var unit_title = $("#product_title option:selected").attr('data-unit_title');
                $('#pack_size').val(scale_size +' '+unit_title);
                $('#scale_size').val(scale_size);
                jQuery("#product_title").select2();

                var pack_quantity = $("#pack_quantity").val();
                var loose_quantity = $("#loose_quantity").val();
                var total_quantity = +(scale_size * pack_quantity) + +loose_quantity;
                $("#quantity").val(total_quantity);



            });

            jQuery("#product_title").change(function () {
                var product_code = $(this).select2().find(":selected").data("product-code"); /* backup code: $('option:selected', this).attr('data-product-code') */
                $('#scale_size').val('');
                jQuery("#product_code").select2("destroy");
                jQuery('#product_code option[value="' + product_code + '"]').prop('selected', true);
                var scale_size = $("#product_title option:selected").attr('data-scale_size');
                var unit_title = $("#product_title option:selected").attr('data-unit_title');

                $('#pack_size').val(scale_size +' '+unit_title);
                $('#scale_size').val(scale_size);
                jQuery("#product_code").select2();

                var pack_quantity = $("#pack_quantity").val();
                var loose_quantity = $("#loose_quantity").val();
                var total_quantity = +(scale_size * pack_quantity) + +loose_quantity;
                $("#quantity").val(total_quantity);
            });


            $('.convert_qty').on('change', function (e) {
                console.log($(this).val());

                if ( $(this).is(":checked") && $(this).val() == 1 )
                {
                    $('.convert_unit_div').show();
                    $('.convert_unit_label').text('').text('Convert Quantity From');
                } else if ( $(this).is(":checked") && $(this).val() == 2 ) {
                    $('.convert_unit_div').show();
                    $('.convert_unit_label').text('').text('Convert Quantity To');
                }
            });
            $('.convert_qty').trigger('change');

        });
    </script>
    <script>
        $("#pack_quantity").keyup(function(){

            var scale_size = $("#scale_size").val();
            var pack_quantity = $("#pack_quantity").val();

            var loose_quantity = $("#loose_quantity").val();
            var total_quantity = +(scale_size * pack_quantity) + +loose_quantity;
            $("#quantity").val(total_quantity);
        });
        $("#loose_quantity").keyup(function () {
            var scale_size = $("#scale_size").val();
            var pack_quantity = $("#pack_quantity").val();
            var loose_quantity = $("#loose_quantity").val();
            var total_quantity = +(scale_size * pack_quantity) + +loose_quantity;
            $("#quantity").val(total_quantity);
        });









        //  ##########   nabeel ahmed scripts    ############


        // nabeel added simple scripts start

        document.addEventListener('keydown', function (event) {
            if (event.keyCode === 9) {     // means tab


                // // for upper inputs tab functionality
                if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#warehouse")[0]) {
                    $("#product_code").focus();
                } else if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#product_code")[0]) {
                    $("#product_title").focus();
                } else if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#product_title")[0]) {
                    $("#remarks").focus();
                } else if ($(document.activeElement)[0] == $("#remarks")[0]) {
                    $("#pack_quantity").focus();
                } else if ($("#pack_quantity")[0] == $(document.activeElement)[0]) {
                    $("#loose_quantity").focus();
                } else if ($("#loose_quantity")[0] == $(document.activeElement)[0]) {
                    // $("#remarks").focus();
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

        document.addEventListener('keyup', function (event) {


            // to close dropdown search
            // if (event.keyCode === 106) {     // means staric(*)
            //     if ($(".select2-container--open")[0].previousElementSibling == $("#account_name")[0]) {
            //
            //         $('#account_name').select2({
            //             selectOnClose: true
            //         });
            //         $('#account_name').focus();
            //
            //     } else if ($(".select2-container--open")[0].previousElementSibling == $("#sale_person")[0]) {
            //
            //         $('#sale_person').select2({
            //             selectOnClose: true
            //         });
            //         $('#sale_person').focus();
            //
            //     } else if ($(".select2-container--open")[0].previousElementSibling == $("#warehouse")[0]) {
            //
            //         $('#warehouse').select2({
            //             selectOnClose: true
            //         });
            //         $('#warehouse').focus();
            //
            //     } else if ($(".select2-container--open")[0].previousElementSibling == $("#service_name")[0]) {
            //
            //         $('#service_name').select2({
            //             selectOnClose: true
            //         });
            //         $('#service_name').focus();
            //
            //     } else if ($(".select2-container--open")[0].previousElementSibling == $("#package")[0]) {
            //
            //         $('#package').select2({
            //             selectOnClose: true
            //         });
            //         $('#package').focus();
            //
            //     }else if ($(".select2-container--open")[0].previousElementSibling == $("#machine")[0]) {
            //
            //         $('#machine').select2({
            //             selectOnClose: true
            //         });
            //         $('#machine').focus();
            //     }
            // }


            if (event.keyCode === 107) {     // means plus(+)

                // // for upper inputs tab functionality
                if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#warehouse")[0]) {
                    $("#product_code").focus();
                } else if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#product_code")[0]) {
                    $("#product_title").focus();
                } else if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#product_title")[0]) {
                    $("#remarks").focus();
                } else if ($(document.activeElement)[0] == $("#remarks")[0]) {
                    $("#pack_quantity").focus();
                } else if ($("#pack_quantity")[0] == $(document.activeElement)[0]) {
                    $("#loose_quantity").focus();
                } else if ($("#loose_quantity")[0] == $(document.activeElement)[0]) {
                    // $("#remarks").focus();
                }

                // if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#warehouse_from")[0]) {
                //     $("#product").focus();
                // }

                event.preventDefault();
            }


            if (event.keyCode === 109) {   //means minus(-)
                // for upper inputs tab functionality
                if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#warehouse")[0]) {
                    // $("#product").focus();
                } if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#product_code")[0]) {
                    $("#warehouse").focus();
                } if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#product_title")[0]) {
                    $("#product_code").focus();
                }if ($(document.activeElement)[0] == $("#remarks")[0]) {
                    $("#product_title").focus();
                } else if ($("#pack_quantity")[0] == $(document.activeElement)[0]) {
                    $("#remarks").focus();
                } else if ($("#loose_quantity")[0] == $(document.activeElement)[0]) {
                    $("#pack_quantity").focus();
                }else if ($("#remarks")[0] == $(document.activeElement)[0]) {
                    $("#product_title").focus();
                }
            }

        });

        document.addEventListener('keyup', function (event) {


            if (event.keyCode === 107 || event.keyCode === 109) {

                if($(".select2-search__field")[0] == $(document.activeElement)[0]) {

                    // to stop user on writing plus(+) and minus(-) on dropdown inputs
                    var value = document.querySelector(".select2-search__field").value;
                    document.querySelector(".select2-search__field").value = value.substr(0, value.length - 1);

                }
                event.preventDefault();
            }
        });

        // when we type f1,f2 and f3 on some input default function of browser is called. To stop it we made this script
        document.addEventListener('keydown', function (e) {

            if (e.ctrlKey && e.key === "s") {   // when you press (ctrl + s) save the invoice
                $("#save").click();
                e.preventDefault();
            }

        });

        // nabeel added focus scripts end



    </script>
@endsection


