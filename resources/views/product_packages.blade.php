@extends('extend_index')
@section('content')
<div class="row">
    <div class="container-fluid search-filter form-group form_manage">
        <div class="form_header"><!-- form header start -->
            <div class="clearfix">
                <div class="pull-left">
                    <h4 tabindex="-1" class="text-white get-heading-text">Product Packages</h4>
                </div>
                <div class="list_btn">
                    <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('product_packages_list') }}"
                        role="button">
                        <i class="fa fa-list"></i> view list
                    </a>
                </div><!-- list btn -->
            </div>
        </div><!-- form header close -->
        <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
            <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate">
                <!-- invoice box start -->
                <form name="f1" class="f1" id="f1" action="{{ route('submit_product_packages') }}"
                        onsubmit="return checkForm()"
                        method="post" autocomplete="off">
                    @csrf
                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                            <div class="invoice_row"><!-- invoice row start -->
                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Package Name
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                            <input tabindex="1" autofocus type="text" name="package_name" data-rule-required="true" data-msg-required="Please Enter Package Name"
                                                    class="inputs_up form-control" id="package_name"
                                                    value="{{old('package_name')}}" placeholder="Package Name">
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class=" invoice_col_ttl">
                                            <!-- invoice column title start -->
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Voucher Remarks
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                            <input tabindex="2" type="text" name="remarks" class="inputs_up form-control"
                                                    id="remarks" value="{{old('remarks')}}"
                                                    placeholder="Remarks"/>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                            </div><!-- invoice row end -->

                            <div class="invoice_row"><!-- invoice row start -->

                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->
                                            <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.Code.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Bar Code
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                            <div class="invoice_col_short"><!-- invoice column short start -->
                                                <a href="{{ route('add_product') }}" target="_blank"
                                                    class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                    data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a id="refresh_product_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                    data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                    <i class="fa fa-refresh"></i>
                                                </a>
                                            </div><!-- invoice column short end -->

                                            <select tabindex="-1" name="product_code" class="inputs_up form-control"
                                                    id="product_code">
                                                <option value="0">Code</option>

                                            </select>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.product_name.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Product Name
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->

                                            <div class="invoice_col_short"><!-- invoice column short start -->
                                                <a href="{{ route('add_product') }}" target="_blank"
                                                    class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                    data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a id="refresh_product_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                    data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                    <i class="fa fa-refresh"></i>
                                                </a>
                                            </div><!-- invoice column short end -->
                                            <select tabindex="4" name="product_name" class="inputs_up form-control"
                                                    id="product_name">
                                                <option value="0">Product</option>
                                            </select>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class=" invoice_col_ttl">
                                            <!-- invoice column title start -->
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
                                            <input tabindex="5" type="text" name="product_remarks"
                                                    class="inputs_up form-control" id="product_remarks"
                                                    placeholder="Remarks"/>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.qty.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Quantity
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                            <input tabindex="6" type="text" name="quantity"
                                                    class="inputs_up text-right form-control" id="quantity"
                                                    placeholder="Qty" onfocus="this.select();"
                                                    onkeyup="product_amount_calculation();"
                                                    onkeypress="return allowOnlyNumber(event);"/>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->
                                            Scale Size
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->

                                            <input tabindex="7" type="text" name="scale_size"
                                                    class="inputs_up text-right form-control" id="scale_size"
                                                    placeholder="Scale Size" onfocus="this.select();"
                                                    onkeyup="product_amount_calculation();"
                                                    onkeypress="return allowOnlyNumber(event);" readonly/>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->
                                            UOM
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->

                                            <input tabindex="8" type="text" name="uom"
                                                    class="inputs_up text-right form-control" id="uom"
                                                    placeholder="UOM" onfocus="this.select();"
                                                    readonly/>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->


                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.rate.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Rate
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->

                                            <input tabindex="9" type="text" name="rate"
                                                    class="inputs_up text-right form-control" id="rate"
                                                    placeholder="Rate"
                                                    onkeypress="return allow_only_number_and_decimals(this,event);"
                                                    onkeyup="product_amount_calculation();"/>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.amount.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Amount
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->

                                            <input tabindex="10" type="text" name="amount"
                                                    class="inputs_up text-right form-control" id="amount"
                                                    placeholder="Amount" readonly>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12 hidden" hidden>
                                    <!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->
                                            Product Sale Tax
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                            <input tabindex="-1" type="text" name="product_sales_tax"
                                                    class="inputs_up form-control"
                                                    id="product_sales_tax" placeholder="Sale Tax %"
                                                    onkeyup="product_amount_calculation();"
                                                    onkeypress="return allow_only_number_and_decimals(this,event);">
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12 hidden" hidden>
                                    <!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->
                                            Product Discount
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                            <input tabindex="-1" type="text" name="product_discount"
                                                    class="inputs_up text-right form-control"
                                                    id="product_discount" placeholder="Discount"
                                                    onkeyup="product_amount_calculation();"
                                                    onkeypress="return allow_only_number_and_decimals(this,event);">
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_txt for_voucher_col_bx">
                                        <!-- invoice column box start -->
                                        <div class="invoice_col_txt with_cntr_jstfy">
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button tabindex="-1" style="display: none;" id="cancel_button" class="invoice_frm_btn btn btn-sm btn-secondary" onclick="cancel_all()" type="button">
                                                    <i class="fa fa-times"></i> Cancel
                                                </button>
                                            </div>    
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button tabindex="11" id="first_add_more" class="invoice_frm_btn btn btn-sm btn-info" onclick="add_sale()" type="button">
                                                    <i class="fa fa-plus"></i> Add
                                                </button>
                                            </div>
                                            
                                        </div>
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                            </div><!-- invoice row end -->

                            <div class="invoice_row"><!-- invoice row start -->
                            <div class="invoice_col col-lg-12">
                                            <!-- invoice column start -->
                                            <div class="invoice_col_bx for_tabs">
                                                <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.auto_add.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                <!-- invoice column box start -->
                                                <div class="custom-checkbox">
                                                    <input tabindex="-1" type="checkbox"
                                                            class="custom-control-input company_info_check_box"
                                                            id="add_auto" name="add_auto" value="1" checked>
                                                    <label class="custom-control-label chck_pdng"
                                                            for="add_auto"> Auto Add </label>
                                                </div>
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->


                                        <div class="invoice_col col-lg-12">
                                            <!-- invoice column start -->
                                            <div class="pro_tbl_con for_voucher_tbl">
                                                <!-- product table container start -->
                                                <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                                    <table class="table table-bordered table-sm" id="category_dynamic_table">
                                                        <thead>
                                                        <tr>
                                                            <th tabindex="-1" class="tbl_srl_9"> Code</th>
                                                            <th tabindex="-1" class="tbl_txt_22"> Title</th>
                                                            <th tabindex="-1" class="tbl_txt_50"> Transaction
                                                                Remarks
                                                            </th>
                                                            <th tabindex="-1" class="tbl_txt_6"> Qty</th>
                                                            <th tabindex="-1" class="tbl_txt_6"> Scale Size</th>
                                                            <th tabindex="-1" class="tbl_txt_6"> UOM</th>
                                                            <th tabindex="-1" class="tbl_txt_6"> Rate</th>
                                                            <th tabindex="-1" class="tbl_srl_12"> Amount</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody id="table_body">
                                                        <tr>
                                                            <td tabindex="-1" colspan="10" align="center">
                                                                No Account Added
                                                            </td>
                                                        </tr>
                                                        </tbody>

                                                        <tfoot>
                                                        <tr>
                                                            <th tabindex="-1" colspan="3" class="text-right">
                                                                Total Items
                                                            </th>
                                                            <td class="tbl_srl_12">
                                                                <div class="invoice_col_txt">
                                                                    <!-- invoice column box start -->
                                                                    <div class="invoice_col_input">
                                                                        <!-- invoice column input start -->
                                                                        <input type="text" name="total_items" class="inputs_up text-right form-control total-items-field" id="total_items"
                                                                                placeholder="0.00" minlength="1" readonly data-rule-required="true" data-msg-required="Please Add"/>
                                                                    </div><!-- invoice column input end -->
                                                                </div><!-- invoice column box end -->
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="3" class="text-right">
                                                                Total Price
                                                            </th>
                                                            <td class="tbl_srl_12">
                                                                <div class="invoice_col_txt">
                                                                    <!-- invoice column box start -->
                                                                    <div class="invoice_col_input">
                                                                        <!-- invoice column input start -->
                                                                        <input tabindex="-1" type="text" name="total_price" class="inputs_up text-right form-control" id="total_price"
                                                                                placeholder="0.00" minlength="2" readonly data-rule-required="true" data-msg-required="Please Add">
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
                            <div class="invoice_row"><!-- invoice row start -->
                                <div class="invoice_col col-lg-12"><!-- invoice column start -->
                                    <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns">
                                        <!-- invoice column box start -->
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button tabindex="12" type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                                <i class="fa fa-floppy-o"></i> Save
                                            </button>
                                            <span id="demo21" class="validate_sign"></span>
                                        </div>
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->


                            </div><!-- invoice row end -->

                        </div><!-- invoice content end -->
                    </div><!-- invoice scroll box end -->


                    <input tabindex="-1" type="hidden" name="salesval" id="salesval">

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
            let package_name = document.getElementById("package_name"),
                total_price = document.getElementById("total_price"),
                validateInputIdArray = [
                    package_name.id,
                    total_price.id,
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

        /// product code and name refresh ajax
        jQuery("#refresh_product_code").click(function () {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_sale_product_code",
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
                url: "refresh_sale_product_name",
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
                url: "refresh_sale_product_code",
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
                url: "refresh_sale_product_name",
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

        function product_amount_calculation() {
            var quantity = jQuery("#quantity").val();
            var rate = jQuery("#rate").val();

            var amount = rate * quantity;

            jQuery("#amount").val(amount);
        }

        function grand_total_calculation() {
            var total_price = 0;

            total_discount = 0;

            jQuery.each(sales, function (index, value) {
                total_price = +total_price + +value[7];
            });

            jQuery("#total_price").val(total_price);
        }
    </script>

    <script>
        var check_add = 0;
        jQuery("#product_code").change(function () {

            var sale_price = jQuery('option:selected', this).attr('data-sale_price');
            var scale_size = jQuery('option:selected', this).attr('data-scale_size');
            var uom = jQuery('option:selected', this).attr('data-unit');

            jQuery("#rate").val(sale_price);
            jQuery("#scale_size").val(scale_size);
            jQuery("#uom").val(uom);
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
            var sale_price = jQuery('option:selected', this).attr('data-sale_price');
            var scale_size = jQuery('option:selected', this).attr('data-scale_size');
            var uom = jQuery('option:selected', this).attr('data-unit');
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

            jQuery("#rate").val(sale_price);
            jQuery("#scale_size").val(scale_size);
            jQuery("#uom").val(uom);

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
        //
        // function popvalidation() {
        //     isDirty = true;
        //
        //     var package_name = document.getElementById("package_name").value;
        //     var product_code = document.getElementById("product_code").value;
        //     var product_name = document.getElementById("product_name").value;
        //     var product_remarks = document.getElementById("product_remarks").value;
        //     var quantity = document.getElementById("quantity").value;
        //     var rate = document.getElementById("rate").value;
        //     var amount = document.getElementById("amount").value;
        //
        //     var flag_submit = true;
        //     var focus_once = 0;
        //
        //
        //     if (package_name.trim() == "") {
        //         if (focus_once == 0) {
        //             jQuery("#package_name").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //     }
        //
        //
        //     if (numberofsales == 0) {
        //         var isDirty = false;
        //         if (product_code == "0") {
        //
        //             if (focus_once == 0) {
        //                 jQuery("#product_code").focus();
        //                 focus_once = 1;
        //             }
        //             flag_submit = false;
        //         }
        //
        //
        //         if (product_name == "0") {
        //
        //             if (focus_once == 0) {
        //                 jQuery("#product_name").focus();
        //                 focus_once = 1;
        //             }
        //             flag_submit = false;
        //         }
        //
        //         if (quantity == "" || quantity == 0) {
        //
        //             if (focus_once == 0) {
        //                 jQuery("#quantity").focus();
        //                 focus_once = 1;
        //             }
        //             flag_submit = false;
        //         }
        //
        //
        //         if (rate == "") {
        //             if (focus_once == 0) {
        //                 jQuery("#rate").focus();
        //                 focus_once = 1;
        //             }
        //             flag_submit = false;
        //         }
        //
        //
        //         if (amount == "") {
        //
        //             if (focus_once == 0) {
        //                 jQuery("#amount").focus();
        //                 focus_once = 1;
        //             }
        //             flag_submit = false;
        //         }
        //
        //         document.getElementById("demo21").innerHTML = "Add Products";
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("demo21").innerHTML = "";
        //     }
        //
        //     return flag_submit;
        // }


        function add_sale() {

            var product_code = document.getElementById("product_code").value;
            var product_name = document.getElementById("product_name").value;
            var product_remarks = document.getElementById("product_remarks").value;
            var quantity = document.getElementById("quantity").value;
            var scale_size = document.getElementById("scale_size").value;
            var uom = document.getElementById("uom").value;
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


            if (quantity == "" || quantity == 0) {

                if (focus_once1 == 0) {
                    jQuery("#quantity").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (scale_size == "") {

                if (focus_once1 == 0) {
                    jQuery("#scale_size").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (uom == "") {

                if (focus_once1 == 0) {
                    jQuery("#uom").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (rate == "") {

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


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete sales[global_id_to_edit];
                }

                counter++;

                jQuery("#product_code").select2("destroy");
                jQuery("#product_name").select2("destroy");

                var product_name = jQuery("#product_name option:selected").text();
                var selected_code_value = jQuery("#product_code option:selected").attr('data-parent');
                var qty = jQuery("#quantity").val();
                var selected_product_name = jQuery("#product_name").val();
                var selected_remarks = jQuery("#product_remarks").val();
                var selected_rate = jQuery("#rate").val();
                var selected_scale_size = jQuery("#scale_size").val();
                var selected_uom = jQuery("#uom").val();
                var selected_amount = jQuery("#amount").val();

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


                sales[counter] = [selected_code_value, product_name, selected_remarks, qty, selected_scale_size, selected_uom, selected_rate, selected_amount];

                // jQuery("#product_code option[value=" + selected_code_value + "]").attr("disabled", "true");
                // jQuery("#product_name option[value=" + selected_code_value + "]").attr("disabled", "true");
                numberofsales = Object.keys(sales).length;
                var remarks_var = '';
                if (selected_remarks != '') {
                    var remarks_var = '' + selected_remarks + '';
                }

                jQuery("#table_body").prepend('<tr id=' + counter + ' class="edit_update"><td class="tbl_srl_9">' + selected_code_value + '</td><td class="text-left tbl_txt_22">' + product_name + '</td><td class="text-left tbl_txt_50">' + remarks_var + '</td><td class="text-right tbl_txt_6">' + qty + '</td><td class="text-right tbl_txt_6">' + selected_scale_size + '</td><td class="text-right tbl_txt_6">' + selected_uom + '</td><td class="text-right tbl_txt_6">' + selected_rate + '</td><td class="text-right tbl_srl_12">' + selected_amount + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_sale(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#quantity").val("");
                jQuery("#scale_size").val("");
                jQuery("#uom").val("");
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
            jQuery("#scale_size").val(temp_sales[4]);
            jQuery("#uom").val(temp_sales[5]);
            jQuery("#rate").val(temp_sales[6]);
            jQuery("#amount").val(temp_sales[7]);

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


            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            setTimeout(function () {
                // jQuery("#product_code").focus();
                $('#product_code').select2('open');
            }, 100);

            $('#package_name').focus();

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

