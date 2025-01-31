@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Product Recover</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('product_recover_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                    <form name="f1" class="f1" id="f1" action="{{ route('submit_product_recover') }}"
                          onsubmit="return checkForm()"
                          method="post">
                        @csrf
                        <div class="invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="invoice_cntnt"><!-- invoice content start -->
                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="invoice_col form-group col-lg-2 col-md-6 col-md-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a
                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Voucher Remarks
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <input tabindex="1" autofocus type="text" name="remarks" class="inputs_up form-control" data-rule-required="true"
                                                       data-msg-required="Please Enter Voucher Remarks" id="remarks" placeholder="Remarks" value="{{old('remarks')}}">
                                                <span id="demo7" class="validate_sign"></span>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-2 col-md-6 col-md-12"><!-- invoice column start -->
                                        <x-posting-reference tabindex="2"/>
                                    </div>

                                </div><!-- invoice row end -->

                                <div class="invoice_row"><!-- invoice row start -->

                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_barcode.description')}}</p>
                                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_barcode.benefits')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Bar Code
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <!-- call add or refresh button component -->
                                                <x-add-refresh-button href="{{ route('add_product') }}" id="refresh_product_code"/>

                                                <select tabindex="3" name="product_code" class="inputs_up form-control" id="product_code">
                                                    <option value="0">Code</option>

                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.description')}}</p>
                                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.benefits')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Product Name
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <!-- call add or refresh button component -->
                                                <x-add-refresh-button href="{{ route('add_product') }}" id="refresh_product_name"/>

                                                <select tabindex="4" name="product_name" class="inputs_up form-control" id="product_name">
                                                    <option value="0">Product</option>

                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <!-- use warehouse-component
                                make warehouse dropdown -->
                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <x-warehouse-component tabindex="5" name="warehouse" id="warehouse" class="refresh_warehouse" title="Warehouse"/>
                                    </div>

                                    <!-- use remarks-component
                                    make remarks dropdown -->
                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <x-remarks-component tabindex="6" name="product_remarks" id="product_remarks" title="Transaction Remarks"/>
                                    </div>

                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.qty.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Quantity
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                {{--                                                    Hamad set tab index--}}
                                                <input tabindex="7" type="text" name="quantity" class="inputs_up form-control" id="quantity" value="{{old('quantity')}}"
                                                       placeholder="Qty" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);">
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12 hidden" hidden><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Rate
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <input type="text" name="rate" class="inputs_up text-right form-control" id="rate" placeholder="Rate" value="{{old('rate')}}" onfocus="this.select();"
                                                       onkeypress="return allow_only_number_and_decimals(this,event);" readonly>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12 hidden" hidden><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Amount
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <input type="text" name="amount" class="inputs_up text-right form-control" id="amount" value="{{old('amount')}}" placeholder="Amount" readonly/>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_txt with_cntr_jstfy">
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                    <button tabindex="-1" style="display: none;" id="cancel_button" class="invoice_frm_btn btn btn-sm btn-secondary" onclick="cancel_all()"
                                                            type="button">
                                                        <i class="fa fa-times"></i> Cancel
                                                    </button>
                                                </div>
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                    {{--                                                        Hamad set tab index--}}
                                                    <button tabindex="8" id="first_add_more" class="invoice_frm_btn btn btn-sm btn-info" onclick="add_product()" type="button">
                                                        <i class="fa fa-plus"></i> Add
                                                    </button>
                                                </div>

                                                <span id="demo201" class="validate_sign"> </span>
                                            </div>
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->

                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="pro_tbl_con for_voucher_tbl col-lg-12"><!-- product table container start -->
                                        <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                            <table class="table table-bordered table-sm" id="category_dynamic_table">
                                                <thead>
                                                <tr>
                                                    <th class="tbl_srl_9">
                                                        Code
                                                    </th>
                                                    <th class="tbl_txt_20">
                                                        Product Name
                                                    </th>
                                                    <th class="tbl_srl_20">
                                                        Warehouse
                                                    </th>
                                                    <th class="tbl_txt_44">
                                                        Transaction Remarks
                                                    </th>
                                                    <th class="tbl_srl_6">
                                                        Qty
                                                    </th>
                                                    <th class="tbl_srl_12" hidden>
                                                        Rate
                                                    </th>
                                                    <th class="tbl_srl_12" hidden>
                                                        Amount
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody id="table_body">
                                                <tr>
                                                    <td colspan="10" align="center">
                                                        No Account Added
                                                    </td>
                                                </tr>
                                                </tbody>

                                                <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-right">
                                                        Total Items
                                                    </th>
                                                    <td class="tbl_srl_12">
                                                        <div class="invoice_col_txt"><!-- invoice column box start -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="number" name="total_items" class="inputs_up text-right form-control total-items-field" id="total_items" placeholder="0.00"
                                                                       readonly data-rule-required="true" data-msg-required="Please Add">
                                                                <span id="demo16" class="validate_sign"></span>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </td>
                                                </tr>
                                                <tr hidden>
                                                    <th colspan="3" class="text-right">
                                                        Total Price
                                                    </th>
                                                    <td class="tbl_srl_12">
                                                        <div class="invoice_col_txt"><!-- invoice column box start -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input type="text" name="total_price" class="inputs_up text-right form-control grand-total-field" id="total_price" placeholder="0.00"
                                                                       readonly/>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </td>
                                                </tr>
                                                </tfoot>

                                            </table>
                                        </div><!-- product table box end -->
                                    </div><!-- product table container end -->
                                </div><!-- invoice row end -->

                                <div class="invoice_row"><!-- invoice row start -->

                                    <div class="invoice_col col-lg-12"><!-- invoice column start -->
                                        <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                {{-- Hamad set tab index--}}
                                                <button tabindex="9" type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                                    <i class="fa fa-floppy-o"></i> Save
                                                </button>
                                                <span id="demo28" class="validate_sign"></span>
                                            </div>
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->


                                </div><!-- invoice row end -->

                            </div><!-- invoice content end -->
                        </div><!-- invoice scroll box end -->


                        <input type="hidden" name="products_array" id="products_array">

                    </form>

                </div><!-- invoice box end -->
            </div><!-- invoice container end -->


        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let remarks = document.getElementById("remarks"),
                posting_reference = document.getElementById("posting_reference"),
                total_items = document.getElementById("total_items"),
                validateInputIdArray = [
                    remarks.id,
                    posting_reference.id,
                    total_items.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                $("#first_add_more").click();
                // event.preventDefault();
                return false;
            }
        });

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
        function product_calculation() {
            var quantity = jQuery("#quantity").val();
            var rate = jQuery("#rate").val();
            var amount;

            amount = (rate * quantity);

            jQuery("#amount").val(amount);
        }

        function grand_total_calculation() {
            var amount = 0;

            jQuery.each(products, function (index, value) {
                amount = +amount + +value['product_amount'];
            });

            jQuery("#total_price").val(amount);
        }
    </script>

    <script>
        jQuery("#product_code").change(function () {

            var purchase_price = jQuery('option:selected', this).attr('data-purchase_price');

            var pname = jQuery('option:selected', this).val();
            jQuery("#product_name").select2("destroy");

            jQuery('#product_name option[value="' + pname + '"]').prop('selected', true);

            jQuery("#product_name").select2();

            jQuery("#rate").val(purchase_price);

            product_calculation();
        });

    </script>

    <script>
        jQuery("#product_name").change(function () {

            var purchase_price = jQuery('option:selected', this).attr('data-purchase_price');
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_code").select2("destroy");
            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);

            jQuery("#product_code").select2();

            jQuery("#rate").val(purchase_price);

            product_calculation();
        });
    </script>

    <script>

        jQuery("#quantity").keyup(function () {

            product_calculation();
        });

        jQuery("#rate").keyup(function () {
            product_calculation();
        });
    </script>

    <script>

        // adding packs into table
        var numberofproducts = 0;
        var counter = 0;
        var products = {};
        var global_id_to_edit = 0;
        var edit_product_value = '';

        function popvalidation() {
            isDirty = true;

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var product_remarks = document.getElementById("product_remarks").value;
            var quantity = document.getElementById("quantity").value;
            var rate = document.getElementById("rate").value;
            var amount = document.getElementById("amount").value;
            var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if (remarks.trim() == "") {
                var isDirty = false;
                if (focus_once == 0) {
                    jQuery("#remarks").focus();
                    focus_once = 1;
                }
                flag_submit = false;

            }


            if (numberofproducts == 0) {
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


                if (quantity == "" || quantity <= 0) {

                    if (focus_once == 0) {
                        jQuery("#quantity").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                // if (rate == "" || rate == 0) {
                //
                //     if (focus_once == 0) {
                //         jQuery("#rate").focus();
                //         focus_once = 1;
                //     }
                //     flag_submit = false;
                // }
                //
                //
                // if (amount == "") {
                //
                //
                //     if (focus_once == 0) {
                //         jQuery("#amount").focus();
                //         focus_once = 1;
                //     }
                //     flag_submit = false;
                // }

                document.getElementById("demo28").innerHTML = "Add Items";
                flag_submit = false;
            } else {
                document.getElementById("demo28").innerHTML = "";
            }
            return flag_submit;
        }


        function add_product() {

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
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


            if (quantity == "" || quantity <= 0) {

                if (focus_once1 == 0) {
                    jQuery("#quantity").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            // if (rate == "" || rate == 0) {
            //
            //     if (focus_once1 == 0) {
            //         jQuery("#rate").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // }
            //
            //
            // if (amount == "") {
            //
            //     if (focus_once1 == 0) {
            //         jQuery("#amount").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete products[global_id_to_edit];
                }

                counter++;

                jQuery("#product_code").select2("destroy");
                jQuery("#product_name").select2("destroy");
                jQuery("#warehouse").select2("destroy");

                var warehouse = jQuery("#warehouse").val();
                var warehouse_name = jQuery("#warehouse option:selected").text();
                var selected_code_value = jQuery("#product_code option:selected").attr('data-parent');
                var product_name = jQuery("#product_name option:selected").text();
                var qty = jQuery("#quantity").val();
                var selected_rate = 0;//jQuery("#rate").val();
                var selected_amount = 0;//= jQuery("#amount").val();
                var selected_remarks = jQuery("#product_remarks").val();

                numberofproducts = Object.keys(products).length;

                if (numberofproducts == 0) {
                    jQuery("#table_body").html("");
                }

                products[counter] = {
                    'warehouse': warehouse,
                    'warehouse_name': warehouse_name,
                    'product_code': selected_code_value,
                    'product_name': product_name,
                    'product_qty': qty,
                    // 'product_bonus_qty': 0,
                    'product_rate': selected_rate,
                    // 'product_inclusive_rate': selected_rate,
                    'product_amount': selected_amount,
                    'product_remarks': selected_remarks
                };

                jQuery("#product_code option[value=" + selected_code_value + "]").attr("disabled", "true");
                jQuery("#product_name option[value=" + selected_code_value + "]").attr("disabled", "true");
                numberofproducts = Object.keys(products).length;

                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="tbl_srl_9">' + selected_code_value + '</td><td class="text-left tbl_txt_20">' + product_name + '</td><td class="text-left tbl_srl_20">' + warehouse_name + '</td><td class="text-left tbl_txt_44">' + selected_remarks + '</td><td hidden>' + selected_rate + '</td><td class="text-right" hidden>' + selected_amount + '</td><td class="text-right tbl_srl_6">' + qty + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_product(' + counter + ')><i class="fa fa-edit"></i></a> <a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_product(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

                jQuery("#quantity").val("");
                jQuery("#product_remarks").val("");
                jQuery("#rate").val("");
                jQuery("#amount").val("");

                jQuery("#products_array").val(JSON.stringify(products));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i>  Add');

                jQuery("#total_items").val(numberofproducts);

                jQuery("#product_code").select2();
                jQuery("#product_name").select2();
                jQuery("#warehouse").select2();

                grand_total_calculation();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }


        function delete_product(current_item) {

            jQuery("#" + current_item).remove();
            var temp_products = products[current_item];
            jQuery("#product_code option[value=" + temp_products['product_code'] + "]").attr("disabled", false);
            jQuery("#product_name option[value=" + temp_products['product_code'] + "]").attr("disabled", false);

            delete products[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#products_array").val(JSON.stringify(products));


            if (isEmpty(products)) {
                numberofproducts = 0;
            }
            jQuery("#total_items").val(numberofproducts);

            grand_total_calculation();
        }


        function edit_product(current_item) {

            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();


            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_products = products[current_item];

            edit_product_value = temp_products['product_code'];

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            jQuery("#warehouse").select2("destroy");

            jQuery("#product_code option[value=" + temp_products['product_code'] + "]").attr("disabled", false);
            jQuery("#product_name option[value=" + temp_products['product_code'] + "]").attr("disabled", false);

            jQuery('#product_code option[value="' + temp_products['product_code'] + '"]').prop('selected', true);
            jQuery('#warehouse option[value="' + temp_products['warehouse'] + '"]').prop('selected', true);


            jQuery("#product_name").val(temp_products['product_code']);
            jQuery("#quantity").val(temp_products['product_qty']);
            jQuery("#rate").val(temp_products['product_rate']);
            jQuery("#amount").val(temp_products['product_amount']);
            jQuery("#product_remarks").val(temp_products['product_remarks']);

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#warehouse").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            // var newvaltohide = jQuery("#product_code").val();

            var newvaltohide = edit_product_value;

            jQuery("#product_code option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery("#product_name option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            jQuery("#warehouse").select2("destroy");

            jQuery("#product_remarks").val("");
            jQuery("#quantity").val("");
            jQuery("#rate").val("");
            jQuery("#amount").val("");

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#warehouse").select2();

            jQuery("#cancel_button").hide();
            jQuery(".table-responsive").show();
            jQuery("#save").show();
            jQuery("#first_add_more").html('Add');

            global_id_to_edit = 0;

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            edit_product_value = '';
        }
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2

            jQuery("#product_code").append("{!! $pro_code !!}");
            jQuery("#product_name").append("{!! $pro_name !!}");

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#warehouse").select2();
            jQuery("#posting_reference").select2();
        });
    </script>

@endsection

