
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Edit Product Recipe</h4>
                            </div>
                            <div class="list_btn">
                                <a class="btn list_link add_more_button" href="{{ route('product_recipe_list') }}" role="button">
                                    <i class="fa fa-list"></i> view list
                                </a>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->


                    <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                        <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                            <form name="f1" class="f1" id="f1" action="{{ route('update_product_recipe') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                                @csrf
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        Recipe Name
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="recipe_name" class="inputs_up form-control" value="{{$product_recipe->pr_name}}"
                                                               data-rule-required="true" data-msg-required="Please Enter Recipe Name"
                                                               id="recipe_name" placeholder="Recipe Name">
                                                        <span id="demo1" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_recipe.code.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Bar Code
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <div class="invoice_col_short"><!-- invoice column short start -->
                                                            <a href="{{ route('add_product') }}" class="col_short_btn" target="_blank">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_manufacture_product_code" class="col_short_btn">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select name="manufacture_product_code" class="inputs_up form-control" id="manufacture_product_code">
                                                            <option value="0">Code</option>
                                                        </select>
                                                        <span id="demo2" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_19"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_recipe.product.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Title
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <div class="invoice_col_short"><!-- invoice column short start -->
                                                            <a href="{{ route('add_product') }}" class="col_short_btn" target="_blank">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_manufacture_product_name" class="col_short_btn">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select name="manufacture_product_name" class="inputs_up form-control" id="manufacture_product_name">
                                                            <option value="0">Product</option>
                                                        </select>
                                                        <span id="demo3" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_6"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_recipe.qty.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Qty
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="manufacture_qty" class="inputs_up form-control" id="manufacture_qty" value="{{$product_recipe->pr_qty}}" placeholder="Qty" onfocus="this.select();" onkeypress="return allowOnlyNumber(event);" />
                                                        <span id="demo4" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_32"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Remarks
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="remarks" class="inputs_up form-control" value="{{$product_recipe->pr_remarks}}" id="remarks" placeholder="Remarks" />
                                                        <span id="demo5" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_recipe.code.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Bar Code
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <div class="invoice_col_short"><!-- invoice column short start -->
                                                            <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_product_code" class="col_short_btn">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->

                                                        <select name="product_code" class="inputs_up form-control" id="product_code">
                                                            <option value="0">Code</option>
                                                        </select>
                                                        <span id="demo6" class="validate_sign"> </span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_recipe.product.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Product Title
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->

                                                        <div class="invoice_col_short"><!-- invoice column short start -->
                                                            <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_product_name" class="col_short_btn">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select name="product_name" class="inputs_up form-control" id="product_name">
                                                            <option value="0">Product</option>
                                                        </select>
                                                        <span id="demo7" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Transaction Remarks
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="product_remarks" class="inputs_up form-control" id="product_remarks" placeholder="Remarks" />
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_recipe.qty.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                       Qty
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="quantity" class="inputs_up text-right form-control" id="quantity" placeholder="Qty" onfocus="this.select();" onkeyup="product_amount_calculation();" onkeypress="return allowOnlyNumber(event);">
                                                        <span id="demo8" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_11 hidden" hidden><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_recipe.rate.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Rate
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="rate" class="inputs_up text-right form-control" id="rate" placeholder="Rate" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="product_amount_calculation();">
                                                        <span id="demo9" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_11 hidden" hidden><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_recipe.amount.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Amount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input"><!-- invoice column input start -->
                                                        <input type="text" name="amount" class="inputs_up text-right form-control" id="amount" placeholder="Amount" readonly>
                                                        <span id="demo10" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                                <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                                    <div class="invoice_col_txt with_cntr_jstfy">
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button id="first_add_more" class="invoice_frm_btn" onclick="add_sale()" type="button">
                                                                <i class="fa fa-plus"></i> Add
                                                            </button>
                                                        </div>
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button style="display: none;" id="cancel_button" class="invoice_frm_btn" onclick="cancel_all()" type="button">
                                                                <i class="fa fa-times"></i> Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_row"><!-- invoice row start -->

                                                    <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                                        <div class="invoice_col_bx for_tabs"><!-- invoice column box start -->
                                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.auto_add.description')}}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input company_info_check_box" id="add_auto" name="add_auto" value="1" checked>
                                                                <label class="custom-control-label chck_pdng" for="add_auto"> Auto Add </label>
                                                            </div>

                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->


                                                    <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                                        <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                                            <div class="pro_tbl_bx"><!-- product table box start -->
                                                                <table class="table gnrl-mrgn-pdng" id="category_dynamic_table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-center tbl_srl_9">
                                                                            Code
                                                                        </th>
                                                                        <th class="text-center tbl_txt_20">
                                                                            Title
                                                                        </th>
                                                                        <th class="text-center tbl_txt_58">
                                                                            Transaction Remarks
                                                                        </th>
                                                                        <th class="text-center tbl_srl_12">
                                                                            Qty
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
                                                                        <td class="text-center tbl_srl_12">
                                                                            <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                    <input type="text" name="total_items" class="inputs_up text-right form-control total-items-field" id="total_items" placeholder="0.00" readonly />
                                                                                    <span id="demo11" class="validate_sign"></span>
                                                                                </div><!-- invoice column input end -->
                                                                            </div><!-- invoice column box end -->
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="hidden" hidden>
                                                                        <th colspan="3" class="text-right">
                                                                            Total Price
                                                                        </th>
                                                                        <td class="text-center tbl_srl_12">
                                                                            <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                                                    <input type="text" name="total_price" class="inputs_up text-right form-control" id="total_price" placeholder="0.00" readonly />
                                                                                    <span id="demo12" class="validate_sign"></span>
                                                                                </div><!-- invoice column input end -->
                                                                            </div><!-- invoice column box end -->
                                                                        </td>
                                                                    </tr>
                                                                    </tfoot>

                                                                </table>
                                                            </div><!-- product table box end -->
                                                        </div><!-- product table container end -->
                                                    </div><!-- invoice column end -->


                                                </div><!-- invoice row end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button type="submit" name="save" id="save" class="invoice_frm_btn"
                                                        >
                                                            <i class="fa fa-floppy-o"></i> Save
                                                        </button>
                                                        <span id="demo13" class="validate_sign"></span>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                        </div><!-- invoice row end -->
                                    </div><!-- invoice content end -->
                                </div><!-- invoice scroll box end -->
                                <input type="hidden" name="salesval" id="salesval">
                                <input type="hidden" name="recipe_id" id="recipe_id" value="{{$product_recipe->pr_id}}">

                            </form>

                        </div><!-- invoice box end -->
                    </div><!-- invoice container end -->




                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let recipe_name = document.getElementById("recipe_name"),
                validateInputIdArray = [
                    recipe_name.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
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
            // var total_price = 0;
            //
            // total_discount = 0;
            //
            // jQuery.each(sales, function (index, value) {
            //     total_price = +total_price + +value[5];
            // });
            //
            // jQuery("#total_price").val(total_price);
        }
    </script>

    <script>
        var check_add = 0;
        jQuery("#manufacture_product_code").change(function () {

            var pname = jQuery('option:selected', this).val();
            jQuery("#manufacture_product_name").select2("destroy");
            jQuery("#manufacture_product_name").children("option[value^=" + pname + "]");

            jQuery('#manufacture_product_name option[value="' + pname + '"]').prop('selected', true);
            jQuery("#manufacture_product_name").select2();
        });

    </script>

    <script>
        jQuery("#manufacture_product_name").change(function () {

            var pcode = jQuery('option:selected', this).val();
            jQuery("#manufacture_product_code").select2("destroy");
            jQuery("#manufacture_product_code").children("option[value^=" + pcode + "]");
            jQuery('#manufacture_product_code option[value="' + pcode + '"]').prop('selected', true);
            jQuery("#manufacture_product_code").select2();
        });

    </script>

    <script>
        var check_add = 0;
        jQuery("#product_code").change(function () {

            // var sale_price = jQuery('option:selected', this).attr('data-sale_price');

            // jQuery("#rate").val(sale_price);

            var pname = jQuery('option:selected', this).val();

            jQuery("#quantity").val('1');

            jQuery("#product_name").select2("destroy");
            jQuery("#product_name").children("option[value^=" + pname + "]");

            jQuery('#product_name option[value="' + pname + '"]').prop('selected', true);

            product_amount_calculation();

            jQuery("#product_name").select2();
            // jQuery("#quantity").focus();

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
            // var sale_price = jQuery('option:selected', this).attr('data-sale_price');
            // var tax = jQuery('option:selected', this).attr('data-tax');
            // jQuery("#product_sales_tax").val(tax);
            var pcode = jQuery('option:selected', this).val();

            if (pcode == 'add_more') {
                window.open('add_product', '_blank');
            }

            jQuery("#quantity").val('1');

            jQuery("#product_code").select2("destroy");
            jQuery("#product_code").children("option[value^=" + pcode + "]");

            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);

            // jQuery("#rate").val(sale_price);

            product_amount_calculation();

            jQuery("#product_code").select2();
            // jQuery("#quantity").focus();

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
        // adding packs into table
        var numberofsales = 0;
        var counter = 0;
        var sales = {};
        var global_id_to_edit = 0;
        var total_discount = 0;

        function popvalidation() {
            isDirty = true;

            var recipe_name = document.getElementById("recipe_name").value;
            var manufacture_product_code = document.getElementById("manufacture_product_code").value;
            var manufacture_product_name = document.getElementById("manufacture_product_name").value;
            var manufacture_qty = document.getElementById("manufacture_qty").value;
            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var product_remarks = document.getElementById("product_remarks").value;
            var quantity = document.getElementById("quantity").value;
            var rate = document.getElementById("rate").value;
            var amount = document.getElementById("amount").value;

            var flag_submit = true;
            var focus_once = 0;


            if (recipe_name.trim() == "") {
                if (focus_once == 0) {
                    jQuery("#recipe_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
            }

            if (manufacture_product_code.trim() == "0") {
                if (focus_once == 0) {
                    jQuery("#manufacture_product_code").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
            }

            if (manufacture_product_name.trim() == "0") {
                if (focus_once == 0) {
                    jQuery("#manufacture_product_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
            }

            if (manufacture_qty.trim() == "") {
                if (focus_once == 0) {
                    jQuery("#manufacture_qty").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
            }


            if (numberofsales == 0) {
                var isDirty = false;
                if (product_code == "0") {
                    // document.getElementById("demo8").innerHTML = "";
                    if (focus_once == 0) {
                        jQuery("#product_code").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    // document.getElementById("demo8").innerHTML = "";
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

                    //  document.getElementById("demo11").innerHTML = "";
                }


                // if (rate == "") {
                //     // document.getElementById("demo12").innerHTML = "";
                //     if (focus_once == 0) {
                //         jQuery("#rate").focus();
                //         focus_once = 1;
                //     }
                //     flag_submit = false;
                // } else {
                //
                //     // document.getElementById("demo12").innerHTML = "";
                // }
                //
                //
                // if (amount == "") {
                //     // document.getElementById("demo15").innerHTML = "";
                //
                //     if (focus_once == 0) {
                //         jQuery("#amount").focus();
                //         focus_once = 1;
                //     }
                //     flag_submit = false;
                // } else {
                //
                //     // document.getElementById("demo15").innerHTML = "";
                // }

                document.getElementById("demo13").innerHTML = "Add Products";
                flag_submit = false;
            } else {
                document.getElementById("demo13").innerHTML = "";
            }

            return flag_submit;
        }


        function add_sale() {

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var product_remarks = document.getElementById("product_remarks").value;
            var quantity = document.getElementById("quantity").value;
            var rate = document.getElementById("rate").value;
            var amount = document.getElementById("amount").value;

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (product_code == "0") {
                // document.getElementById("demo8").innerHTML = "";
                if (focus_once1 == 0) {
                    jQuery("#product_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {
                // document.getElementById("demo8").innerHTML = "";
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
                //  document.getElementById("demo11").innerHTML = "";
            }


            // if (rate == "") {
            //     // document.getElementById("demo12").innerHTML = "";
            //     if (focus_once1 == 0) {
            //         jQuery("#rate").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // } else {
            //
            //     // document.getElementById("demo12").innerHTML = "";
            // }
            //
            //
            // if (amount == "") {
            //     // document.getElementById("demo15").innerHTML = "";
            //
            //     if (focus_once1 == 0) {
            //         jQuery("#amount").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // } else {
            //
            //     // document.getElementById("demo15").innerHTML = "";
            // }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete sales[global_id_to_edit];
                }

                document.getElementById("demo11").innerHTML = "";
                document.getElementById("demo9").innerHTML = "";
                counter++;

                jQuery("#product_code").select2("destroy");
                jQuery("#product_name").select2("destroy");

                var product_name = jQuery("#product_name option:selected").text();
                var selected_code_value = jQuery("#product_code option:selected").attr('data-parent');
                var qty = jQuery("#quantity").val();
                var selected_product_name = jQuery("#product_name").val();
                var selected_remarks = jQuery("#product_remarks").val();
                // var selected_rate = jQuery("#rate").val();
                // var selected_amount = jQuery("#amount").val();
                var selected_rate = 0;
                var selected_amount = 0;

                $.each(sales, function (index, entry) {

                    if (entry[0].trim() == selected_code_value.trim()) {

                        // jQuery(".select2-search__field").val('');

                        if (index != 0) {
                            jQuery("#" + index).remove();

                            delete sales[index];
                        }
                        counter++;

                        qty = entry[3];

                        qty = +entry[3] + +1;

                        selected_amount = selected_rate * qty;
                    }
                });


                numberofsales = Object.keys(sales).length;

                if (numberofsales == 0) {
                    jQuery("#table_body").html("");
                }


                sales[counter] = [selected_code_value, product_name, selected_remarks, qty, selected_rate, selected_amount];

                // jQuery("#product_code option[value=" + selected_code_value + "]").attr("disabled", "true");
                // jQuery("#product_name option[value=" + selected_code_value + "]").attr("disabled", "true");
                numberofsales = Object.keys(sales).length;
                var remarks_var = '';
                if (selected_remarks != '') {
                    var remarks_var = '' + selected_remarks + '';
                }

                jQuery("#table_body").prepend('<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + selected_code_value + '</td><td class="text-left tbl_txt_20">' + product_name + '</td><td class="text-left tbl_txt_58">' + remarks_var + '</td><td class="text-right tbl_srl_12">' + qty + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_sale(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></div></td><td class="text-right tbl_srl_12" hidden>' + selected_rate + '</td><td class="text-right tbl_srl_12" hidden>' + selected_amount + '</td></tr>');

                jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

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

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();

                grand_total_calculation();

                jQuery("#product_code").select2();
                jQuery("#product_name").select2();
            }
        }


        function delete_sale(current_item) {

            jQuery("#" + current_item).remove();

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


            grand_total_calculation();


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

            jQuery('#product_code option[value="' + temp_sales[0] + '"]').prop('selected', true);

            jQuery("#product_name").val(temp_sales[0]);
            jQuery("#product_remarks").val(temp_sales[2]);
            jQuery("#quantity").val(temp_sales[3]);
            jQuery("#rate").val(temp_sales[4]);
            jQuery("#amount").val(temp_sales[5]);

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            var newvaltohide = jQuery("#product_code").val();

            jQuery("#quantity").val("");

            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");

            jQuery("#product_remarks").val("");
            jQuery("#rate").val("");
            jQuery("#amount").val("");

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
    </script>

    <script>
        jQuery(document).ready(function () {

            // Initialize select2
            jQuery("#product_code").append("{!! $pro_code !!}");
            jQuery("#product_name").append("{!! $pro_name !!}");

            jQuery("#manufacture_product_code").append("{!! $manufacture_pro_code !!}");
            jQuery("#manufacture_product_name").append("{!! $manufacture_pro_name !!}");


            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            jQuery("#manufacture_product_name").select2();
            jQuery("#manufacture_product_code").select2();
            setTimeout(function () {
                // jQuery("#product_code").focus();
                $('#product_code').select2('open');
            }, 100);


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


        var id = jQuery('#recipe_id').val();

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "{{ route('get_product_recipe_details') }}",
            data: {id: id},
            type: "POST",
            cache: false,
            dataType: 'json',
            success: function (data) {

                $.each(data, function (index, value) {

                    if (global_id_to_edit != 0) {
                        jQuery("#" + global_id_to_edit).remove();

                        delete sales[global_id_to_edit];
                    }
                    counter++;

                    var selected_code_value = value['pri_product_code'];
                    var product_name = value['pri_product_name'];
                    var qty = value['pri_qty'];
                    var selected_remarks = '';
                    var selected_rate = value['pri_rate'];
                    var selected_amount = value['pri_amount'];

                    numberofsales = Object.keys(sales).length;

                    if (numberofsales == 0) {
                        jQuery("#table_body").html("");
                    }

                    sales[counter] = [selected_code_value, product_name, selected_remarks, qty, selected_rate, selected_amount];

                    numberofsales = Object.keys(sales).length;
                    var remarks_var = '';
                    if (selected_remarks != '') {
                        var remarks_var = '' + selected_remarks + '';
                    }

                    jQuery("#table_body").prepend('<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + selected_code_value + '</td><td class="text-left tbl_txt_20">' + product_name + '</td><td class="text-left tbl_txt_58">' + remarks_var + '</td><td class="text-right tbl_srl_12">' + qty + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_sale(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></div></td><td class="text-right tbl_srl_12" hidden>' + selected_rate + '</td><td class="text-right tbl_srl_12" hidden>' + selected_amount + '</td></tr>');
                    jQuery("#salesval").val(JSON.stringify(sales));

                    jQuery("#total_items").val(numberofsales);

                    grand_total_calculation();
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // alert(jqXHR.responseText);
                // alert(errorThrown);
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

