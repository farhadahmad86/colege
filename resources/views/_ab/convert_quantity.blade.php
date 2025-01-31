@extends('extend_index')

@section('content')
    <link rel="stylesheet" href="{{ asset('public/css/simple_form.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/add_refresh_btn.css') }}">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Convert Quantity</h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{route('convert_quantity_list')}}" role="button">
                                <l class="fa fa-list"></l>
                                view list
                            </a>
                        </div>
                    </div>
                </div>
                <form name="f1" class="convert_quantity f1" id="f1" action="{{route('submit_convert_quantity')}}" method="post" onsubmit="return checkForm()">
                    @csrf
                    <div class="row">
                        <div class="form-group simple_form col-lg-3 col-md-4 col-sm-12 simpleForm">
                            <x-warehouse-component tabindex="1" name="warehouse" id="warehouse" class="refresh_warehouse" title="Warehouse"/>
                        </div>
                        {{--<div class="input_bx">--}}
                        {{--    <label class="required">Select Warehouse</label>--}}
                        {{--    <select name="warehouse" class="inputs_up form-control required" id="warehouse" autofocus data-rule-required="true" data-msg-required="Please Select--}}
                        {{--    Warehouse">--}}
                        {{--        <option value="0">Select Warehouse </option>--}}
                        {{--        @foreach ($warehouses as $warehouse)--}}
                        {{--            <option value='{{ $warehouse->wh_id }}'>{{ $warehouse->wh_title }}</option>--}}
                        {{--        @endforeach--}}
                        {{--    </select>--}}
                        {{--    <span id="demo1" class="validate_sign"> </span>--}}
                        {{--</div>--}}
                        {{-- </div> --}}
                        <div class="form-group col-lg-3 col-md-4 col-sm-12">
                            <div class="input_bx">
                                <label class="required">Product Barcode</label>
                                <select name="product_code" class="inputs_up form-control required" id="product_code" autofocus data-rule-required="true"
                                        data-msg-required="Please Select Product Code">
                                    <option value="0">Select Product Code</option>
                                    @foreach ($products as $product)
                                        <option value='{{ $product->pro_p_code }}' data-scale_size="{{ $product->unit_scale_size }}">{{ $product->pro_p_code }}</option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-4 col-sm-12">
                            <div class="input_bx">
                                <label class="required">Product Title</label>
                                <select name="product_title" class="inputs_up form-control required" id="product_title" autofocus
                                        data-rule-required="true" data-msg-required="Please Select Product Title">
                                    <option value="0">Select Product Title</option>
                                    @foreach ($products as $product)
                                        <option value='{{ $product->pro_title }}' data-scale_size="{{ $product->unit_scale_size }}"
                                                data-product-code="{{ $product->pro_p_code }}">{{ $product->pro_title }}</option>
                                    @endforeach
                                </select>
                                {{--                                                <input type="hidden" id="product_title" name="product_title" hidden>--}}
                                <span id="demo1" class="validate_sign"> </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-4 col-sm-12">
                            <div class="input_bx">
                                <label class="required">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="inputs_up form-control" placeholder="Quantity" autocomplete="off"
                                        value="{{ old('quantity') }}" data-rule-required="true" data-msg-required="Please Enter Quantity">
                                <span id="demo2" class="validate_sign"> </span>
                                <input type="hidden" name="scale_size" id="scale_size">
                            </div>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <div class="input_bx">
                                <label class="required">Remarks</label>
                                <textarea name="remarks" id="remarks" class="inputs_up remarks form-control required" placeholder="Remarks" style="height: 100px;"
                                            data-rule-required="true" data-msg-required="Please Enter Remarks">{{ old('remarks')
                                    }}</textarea>
                                <span id="demo3" class="validate_sign"> </span>
                            </div>
                        </div>
                        <!-- Convert To/From Quantity -->
                        
                        <div class="form-group col-lg-3 col-md-4 col-sm-12">
                            <div class="input_bx">
                            <label class="invisible">Convert To/From Quantity</label>    
                            <!-- {{--<label class="">Convert To/From Quantity</label>--}} -->
                                <div class="custom-control custom-radio mb-10 mt-1">
                                    <input type="radio" name="convert_qty" class="custom-control-input convert_qty" id="convert_qty1" value="1" required>
                                    <label class="custom-control-label" for="convert_qty1">Convert Quantity for Sale</label>
                                </div>
                                <div class="custom-control custom-radio mb-10 mt-1">
                                    <input type="radio" name="convert_qty" class="custom-control-input convert_qty" id="convert_qty2" value="2">
                                    <label class="custom-control-label" for="convert_qty2">Convert Quantity Not for Sale</label>
                                </div>
                                <span id="convert_qty_error_msg" class="validate_sign"> </span>
                            </div>
                        </div>
                        <!-- Convert To/From -->
                        <div class="form-group col-lg-3 col-md-4 col-sm-12 convert_unit_div">
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
                        <!-- Convert To/From -->
                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                            <button type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                                <i class="fa fa-eraser"></i> Cancel
                            </button>
                            <button type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                    </div><!-- row end -->
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

            jQuery("#product_code").change(function () {
                var product_code = jQuery('option:selected', this).val();

                jQuery("#product_title").select2("destroy");
                jQuery('#product_title option[data-product-code="' + product_code + '"]').prop('selected', true);
                var scale_size = $("#product_code option:selected").attr('data-scale_size');

                jQuery("#product_title").select2();
                $('#scale_size').val(scale_size);
            });
            jQuery("#product_title").change(function () {
                var product_code = $(this).select2().find(":selected").data("product-code"); /* backup code: $('option:selected', this).attr('data-product-code') */

                jQuery("#product_code").select2("destroy");
                jQuery('#product_code option[value="' + product_code + '"]').prop('selected', true);
                var scale_size = $("#product_title option:selected").attr('data-scale_size');

                jQuery("#product_code").select2();
                $('#scale_size').val(scale_size);
            });


            $('.convert_qty').on('change', function (e) {
                console.log($(this).val());

                if ($(this).is(":checked") && $(this).val() == 1) {
                    $('.convert_unit_div').show();
                    $('.convert_unit_label').text('').text('Convert Quantity From');
                } else if ($(this).is(":checked") && $(this).val() == 2) {
                    $('.convert_unit_div').show();
                    $('.convert_unit_label').text('').text('Convert Quantity To');
                }
            });
            $('.convert_qty').trigger('change');

        });
    </script>
@endsection


