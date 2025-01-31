@extends('extend_index')

@section('styles_get')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/custom-search/custom-search.css') }}">
@stop

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Goods Receipt Note</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <a class="add_btn list_link add_more_button" href="{{ route('goods_receipt_note_list') }}"
                            role="button">
                            <i class="fa fa-list"></i> Goods Receipt Note List
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con"><!-- invoice container start -->
                <div id="invoice_bx" class="invoice_bx"><!-- invoice box start -->

                    <form name="f1" class="f1" id="f1" action="{{ route('submit_goods_receipt_note') }}"
                            onsubmit="return checkForm()" method="post" autocomplete="off">
                        @csrf
                        <div class="invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="invoice_cntnt"><!-- invoice content start -->

                                <div class="invoice_row"><!-- invoice row start -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column -->
                                        <x-party-name-component tabindex="2" name="account_name" id="account_name" class="purchase"/>
                                    </div>

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <x-party-reference-component tabindex="2" name="customer_name" id="customer_name"/>
                                    </div>

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <x-posting-reference tabindex="3"/>
                                    </div>

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                Purchase Order
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                {{--                                                    Hamad set tab index--}}
                                                <select tabindex="4" name="po" class="inputs_up form-control js-example-basic-multiple"
                                                        id="po">
                                                    <option value="0">Select Purchase Order</option>
                                                    @foreach($po as $poi)
                                                        <option value="{{$poi->po_id}}">{{$poi->po_title}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->

                                <div class="invoice_row"><!-- invoice row start -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"> <!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl">
                                                <!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.description')}}</p>
                                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.benefits')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Products
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->

                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                    <a href="{{ route('add_product') }}" target="_blank"
                                                        class="col_short_btn btn btn-sm btn-info" data-container="body"
                                                        data-toggle="popover" data-trigger="hover"
                                                        data-placement="bottom" data-html="true"
                                                        data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_product_name" class="col_short_btn btn btn-sm btn-info"
                                                        data-container="body" data-toggle="popover"
                                                        data-trigger="hover" data-placement="bottom"
                                                        data-html="true"
                                                        data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </div><!-- invoice column short end -->
                                                <div class="ps__search">
                                                    {{--                                                        Hamad set tab index--}}
                                                    <input tabindex="5" type="text" name="product" id="product" class="inputs_up form-control ps__search__input" placeholder="Enter Product"/>
                                                </div>

                                                <span id="check_product_count" class="validate_sign"></span>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div>

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <x-warehouse-component tabindex="5" name="warehouse" id="warehouse" class="refresh_warehouse" title="Warehouse"/>
                                    </div>

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <x-remarks-component tabindex="7" name="remarks" id="remarks" title="Remarks"/>
                                    </div>
                                </div><!-- invoice row end -->

                                <div class="invoice_row"><!-- invoice row start -->

                                <div class="invoice_col form-group col-lg-12 col-md-12 col-sm-12">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx for_tabs col-lg-5">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_col_txt for_invoice_nbr">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->

                                                            <div class="invoice_col_txt for_inline_input_checkbox multi_pro">
                                                                <!-- invoice column input start -->
                                                                <div class="custom-checkbox float-left">
                                                                    <input type="checkbox" value="1"
                                                                            name="check_multi_time"
                                                                            class="custom-control-input company_info_check_box"
                                                                            id="check_multi_time">
                                                                    <label class="custom-control-label chck_pdng"
                                                                            for="check_multi_time"> One Product Add Multi Times </label>
                                                                </div>
                                                            </div><!-- invoice column input end -->

                                                            <div class="invoice_col_txt for_inline_input_checkbox">
                                                                <!-- invoice column input start -->
                                                                <div class="custom-checkbox float-left">
                                                                    <input type="checkbox" value="1"
                                                                            name="check_multi_warehouse"
                                                                            class="custom-control-input company_info_check_box"
                                                                            id="check_multi_warehouse">
                                                                    <label class="custom-control-label chck_pdng"
                                                                            for="check_multi_warehouse"> Multi
                                                                        Warehouse </label>
                                                                </div>
                                                            </div><!-- invoice column input end -->

                                                            <div class="invoice_col_input">
                                                                <input type="text" name="invoice_nbr_chk" class="inputs_up form-control" id="invoice_nbr_chk" placeholder="Check Invoice Number">
                                                            </div>
                                                            <div class="inline_input_txt_lbl" for="service_total_inclusive_tax">
                                                                <input type="button" class="invoice_chk_btn" value="check"

                                                                />
                                                            </div>
                                                        </div><!-- invoice inline input text end -->
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                            <div class="pro_tbl_con col-lg-12 col-md-12 col-sm-12"><!-- product table container start -->
                                                <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                                    <table class="table table-bordered table-sm" id="category_dynamic_table">
                                                        <thead>
                                                        <tr>
                                                            {{--  <th class="tbl_srl_4"> Sr.</th>  --}}
                                                            <th class="tbl_srl_9"> Code</th>
                                                            <th class="tbl_txt_13"> Title</th>
                                                            <th class="tbl_txt_13"> Remarks</th>
                                                            <th class="tbl_txt_13"> Warehouse</th>
                                                            <th class="tbl_srl_4">
                                                                Qty
                                                            </th>
                                                            <th class="tbl_srl_4">
                                                                UOM
                                                            </th>
                                                            <th class="tbl_srl_5" hidden>
                                                                Bonus
                                                            </th>
                                                            <th class="tbl_srl_4">
                                                                Piece Per Pack
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="table_body"></tbody>
                                                    </table>
                                                </div><!-- product table box end -->
                                            </div><!-- product table container end -->
                                </div><!-- invoice row end -->
                                <div class="invoice_row justify-content-center"><!-- invoice row start -->
                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Total(Total_Item/Sub_Total/Total_Taxes).description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Total
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_txt"><!-- invoice column input start -->

                                                <div class="invoice_inline_input_txt">
                                                    <!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl" for="total_items">
                                                        Total Items
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text" name="total_items"
                                                                class="inputs_up form-control text-right total-items-field" data-rule-required="true" data-msg-required="Please Select Party"
                                                                id="total_items" readonly>
                                                    </div>
                                                </div><!-- invoice inline input text end -->

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->



                                </div><!-- invoice row end -->

                                <div class="invoice_row"><!-- invoice row start -->

                                    <div class="invoice_col form-group col-lg-12 col-md-12 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_txt with_cntr_jstfy">
                                            <!-- invoice column box start -->

                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button type="submit" class="invoice_frm_btn" name="save" id="save">
                                                    Save (Ctrl+S)
                                                </button>

                                            </div>
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button id="all_clear_form" type="button" class="invoice_frm_btn">
                                                    Clear (Ctrl+X)
                                                </button>
                                            </div>
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->


                                </div><!-- invoice row end -->

                            </div><!-- invoice content end -->
                        </div><!-- invoice scroll box end -->

                        <div id="cstmr_info_mdl" class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl">
                            <!-- invoice small modal start -->
                            <div class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl_bx">
                                <!-- invoice small modal box start -->
                                <div class="gnrl-blk gnrl-mrgn-pdng invoice_sm_mdl_scrl">
                                    <!-- invoice small modal scroll start -->

                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_sm_hdng">
                                        <!-- invoice small modal heading start -->
                                        <h5 class="gnrl-mrgn-pdng">
                                            Customer Information
                                        </h5>
                                    </div><!-- invoice small modal content end -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_sm_cntnt">
                                        <!-- invoice small modal heading start -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                        </div><!-- invoice row end -->

                                    </div><!-- invoice small modal content end -->

                                </div><!-- invoice small modal scroll end -->
                            </div><!-- invoice small modal box end -->
                        </div><!-- invoice small modal end -->

                    </form>

                </div><!-- invoice box end -->
            </div><!-- invoice container end -->


        </div> <!-- white column form ends here -->
   </div><!-- row end -->
    <div class="invoice_overlay"></div>
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let account_name = document.getElementById("account_name"),
                total_items = document.getElementById("total_items"),
                validateInputIdArray = [
                    account_name.id,
                    total_items.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js" integrity="sha512-JZSo0h5TONFYmyLMqp8k4oPhuo6yNk9mHM+FY50aBjpypfofqtEWsAgRDQm94ImLCzSaHeqNvYuD9382CEn2zw==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@6.4.1"></script>
    <script>
        var PRODUCTS_COLUMNS_NAMES = [
            'pro_p_code',
            'pro_title',
            'pro_code',
            'pro_alternative_code',
        ];
        var GET_PRODUCTS_ROUTE = '{{ route('ajax_get_json_products') }}';
    </script>
    <script src="{{ asset('public/plugins/custom-search/custom-search_2.js') }}"></script>

    <script>
        jQuery("#refresh_sale_person").click(function () {
// alert('warehouse');
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_sale_person",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#sale_person").html(" ");
                    jQuery("#sale_person").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);s
                }
            });
        });

        jQuery("#refresh_warehouse").click(function () {
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
                success: function (data) {

                    jQuery("#warehouse").html(" ");
                    jQuery("#warehouse").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);s
                }
            });
        });

        jQuery("#refresh_package").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_packages",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#package").html(" ");
                    jQuery("#package").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });



        jQuery("#refresh_account_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_sale_account_name",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#account_code").html(" ");
                    jQuery("#account_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_account_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_sale_account_name",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#account_name").html(" ");
                    jQuery("#account_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
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

        //       changed by nabeel
        jQuery("#refresh_product_name").click(function () {

            var GET_PRODUCTS_ROUTE = '{{ route('ajax_get_json_products') }}';
            sirf_reload(GET_PRODUCTS_ROUTE);

        });
    </script>

    <script>

        jQuery("#customer_info_cancel_btn").click(function () {
            jQuery('#customer_name').val('');
            jQuery('#customer_email').val('');
            jQuery('#customer_phone_number').val('');
        });





        function popvalidation() {
            isDirty = true;

            var account_name = $("#account_name").val();

            var customer_email = $("#customer_email").val();







            var flag_submit = true;
            var focus_once = 0;



            if (account_name.trim() == "0") {
                var isDirty = false;

                if (focus_once == 0) {
                    jQuery("#account_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            // if (machine.trim() == "0") {
            //     var isDirty = false;
            //
            //     if (focus_once == 0) {
            //         jQuery("#machine").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // }





            if (total_items == 0) {
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

                document.getElementById("check_product_count").innerHTML = "Add Items";
                flag_submit = false;
            } else {
                document.getElementById("check_product_count").innerHTML = "";
            }

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;
            var quantity;


            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                quantity = +jQuery("#quantity" + pro_field_id).val();


                if (quantity <= 0 || quantity == "") { /* Changed by Abdullah: old ->  if (quantity < 1 || quantity == "")   */
                    if (focus_once == 0) {
                        jQuery("#quantity" + pro_field_id).focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


            });

            return flag_submit;
        }


    </script>

    {{--//////////////////////////////////////////////////////////////////// Start Sale Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}
    <script>
        // adding sales into table
        var counter = 0;
        var total_discount = 0;

        function product_amount_calculation(id) {

            var quantity = jQuery("#quantity" + id).val();
            var rate = jQuery("#rate" + id).val();
            var unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + id).val();

            if (quantity == "") {
                quantity = 0;
            }
            var gross_amount = quantity * rate;
            jQuery("#amount" + id).val(gross_amount);
            grand_total_calculation();
        }

        function grand_total_calculation() {


            var product_quantity;

            var product_or_service_status;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#quantity" + pro_field_id).val();
                product_unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + pro_field_id).val();

                product_or_service_status = jQuery("#product_or_service_status" + pro_field_id).val();
            });


            // var total_items = $('input[name="pro_code[]"]').length;
            var total_items = 0;



            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                var proQuantity = jQuery("#quantity" + pro_field_id).val();
                total_items = total_items + parseFloat(proQuantity);

            });

            jQuery("#total_items").val(total_items);



        }

        function grand_total_calculation_with_disc_amount() {


            var product_quantity;
            var product_unit_measurement_scale_size;

            var product_or_service_status;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#quantity" + pro_field_id).val();
                product_unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + pro_field_id).val();

            });

            var total_items = $('input[name="pro_code[]"]').length;

            jQuery("#total_items").val(total_items);



        }



        function productChanged(product)
        {
            counter++;
            add_first_item();
            var code = product.pro_p_code;


            var parent_code = product.pro_p_code;
            var name = product.pro_title;
            var quantity = 1;
            var unit_measurement_scale_size = product.unit_scale_size;
            var unit_measurement = product.unit_title;
            var bonus_qty = '';
            // var rate = product.pro_average_rate;
            var inclusive_rate = 0;
            var discount = 0;
            var discount_amount = 0;
            var sales_tax = product.pro_tax;
            var sale_tax_amount = 0;
            var amount = 0;
            var remarks = '';
            var rate_after_discount = 0;
            var inclusive_exclusive = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;
            // var gross_amount = quantity * rate;
            /**
             * Chaning according to Ahmad Hassan Sahab
             * One Product Multi time enter with separate index
             */
            if (!$("#check_multi_time").is(':checked')) {
                if (!$("#check_multi_warehouse").is(':checked')) {
                    $('input[name="pro_code[]"]').each(function (pro_index) {
                        pro_code = $(this).val();
                        pro_field_id_title = $(this).attr('id');
                        pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                        if (pro_code == parent_code) {
                            quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                            bonus_qty = jQuery("#bonus" + pro_field_id).val();

                            delete_sale(pro_field_id);
                        }
                    });
                }
            }

            /**
             * Chaning according to Ahmad Hassan Sahab End
             * One Product Multi time enter with separate index
             */


            // rate, gross_amount,
                add_sale(parent_code, name, quantity, bonus_qty, remarks, counter, 0, unit_measurement, unit_measurement_scale_size);

            product_amount_calculation(counter);
        }

        jQuery("#product_code").change(function () {

            counter++;
            add_first_item();
            var code = $(this).val();

            // $("#product_name").select2("destroy");
            $('#product_name option[value="' + code + '"]').prop('selected', true);
            // $("#product_name").select2();

            var parent_code = jQuery("#product_code option:selected").attr('data-parent');
            var name = $("#product_name option:selected").text();
            var quantity = 1;
            var unit_measurement = $('option:selected', this).attr('data-unit');
            var bonus_qty = '';


            var remarks = '';

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            if (!$("#check_multi_time").is(':checked')) {
                if (!$("#check_multi_warehouse").is(':checked')) {
                    $('input[name="pro_code[]"]').each(function (pro_index) {
                        pro_code = $(this).val();
                        pro_field_id_title = $(this).attr('id');
                        pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                        if (pro_code == parent_code) {
                            quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                            bonus_qty = jQuery("#bonus" + pro_field_id).val();


                            delete_sale(pro_field_id);
                        }
                    });
                }
            }

            // rate, gross_amount,
            add_sale(parent_code, name, quantity, bonus_qty, remarks, counter, 0, unit_measurement, unit_measurement_scale_size);

            product_amount_calculation(counter);
        });

        jQuery("#product_name").change(function () {
            counter++;
            add_first_item();
            var code = $(this).val();

            // $("#product_code").select2("destroy");
            $('#product_code option[value="' + code + '"]').prop('selected', true);
            // $("#product_code").select2();

            var parent_code = jQuery("#product_name option:selected").attr('data-parent');
            var name = $("#product_name option:selected").text();
            var quantity = 1;
            var unit_measurement = $('option:selected', this).attr('data-unit');
            var bonus_qty = '';


            var remarks = '';


            var pro_code;
            var pro_field_id_title;
            var pro_field_id;


            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                if (!$("#check_multi_time").is(':checked')) {
                    if (pro_code == parent_code) {
                        quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                        bonus_qty = jQuery("#bonus" + pro_field_id).val();


                        delete_sale(pro_field_id);
                    }
                }
            });

            if (!$("#check_multi_time").is(':checked')) {
                if (!$("#check_multi_warehouse").is(':checked')) {
                    $('input[name="pro_code[]"]').each(function (pro_index) {

                        pro_code = $(this).val();
                        pro_field_id_title = $(this).attr('id');
                        pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                        if (pro_code == parent_code) {
                            quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                            bonus_qty = jQuery("#bonus" + pro_field_id).val();



                            delete_sale(pro_field_id);
                        }
                    });
                }
            }

            // rate, gross_amount,
            add_sale(parent_code, name, quantity, bonus_qty, remarks, counter, 0, unit_measurement, unit_measurement_scale_size);

            product_amount_calculation(counter);
        });


        jQuery("#all_clear_form").click(function () {
            jQuery("#table_body").html("");
            grand_total_calculation();

            jQuery("#sale_person").val("0").trigger('change');
            jQuery("#account_name").val("0").trigger('change');
            jQuery("#remarks").val("");


            jQuery("#customer_name").val("");
            jQuery("#customer_email").val("");
            jQuery("#customer_phone_number").val("");


        });

        jQuery("#package").change(function () {

            var id = jQuery('option:selected', this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "{{ route('get_product_packages_details') }}",
                data: {id: id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    $.each(data, function (index, value) {
                        counter++;

                        var parent_code = value['ppi_product_code'];
                        jQuery('#product_name option[value="' + parent_code + '"]').prop('selected', true);
                        var name = $("#product_name option:selected").text();
                        var quantity = value['ppi_qty'];
                        var unit_measurement = $("#product_name option:selected").attr('data-unit');
                        var bonus_qty = '';

                        var inclusive_rate = 0;
                        var discount = 0;
                        var discount_amount = 0;
                        var sales_tax = 0;
                        var sale_tax_amount = 0;
                        var amount = 0;
                        var remarks = value['ppi_remarks'];
                        var rate_after_discount = 0;
                        var inclusive_exclusive = 0;

                        var pro_code;
                        var pro_field_id_title;
                        var pro_field_id;

                        /**
                         * Chaning according to Ahmad Hassan Sahab
                         * One Product Multi time enter with separate index
                         */


                        $('input[name="pro_code[]"]').each(function (pro_index) {
                            pro_code = $(this).val();
                            pro_field_id_title = $(this).attr('id');
                            pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                            if (!$("#check_multi_time").is(':checked')) {
                                if (pro_code == parent_code) {
                                    quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                                    bonus_qty = jQuery("#bonus" + pro_field_id).val();


                                    delete_sale(pro_field_id);
                                }
                            }
                        });


                        /**
                         * Chaning according to Ahmad Hassan Sahab End
                         * One Product Multi time enter with separate index
                         */

                        if ($(".invoice_type").is(':checked')) {
                            if ($(".invoice_type:checked").val() == 1) {
                                sales_tax = 0;
                            }
                        }

                        if ($(".discount_type").is(':checked')) {
                            if ($(".discount_type:checked").val() == 1) {
                                discount = 0;
                            } else if ($(".discount_type:checked").val() == 2) {
                                discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
                            } else if ($(".discount_type:checked").val() == 3) {
                                discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
                            } else if ($(".discount_type:checked").val() == 4) {
                                discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
                            }
                        }

                        add_sale(parent_code, name, quantity, bonus_qty, rate, gross_amount, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks,
                            rate_after_discount,
                            inclusive_exclusive, counter, 0, unit_measurement);

                        product_amount_calculation(counter);

                    });

                    jQuery("#package").select2("destroy");
                    jQuery('#package option[value="' + 0 + '"]').prop('selected', true);
                    jQuery("#package").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });
        // rate, gross_amount,
            function add_sale(code, name, quantity, bonus_qty, remarks, counter,
                          product_or_service_status, unit_measurement, unit_measurement_scale_size) {

            // var inclusive_exclusive_status = '';
            var bonus_qty_status = '';
            // if (inclusive_exclusive == 1) {
            //     inclusive_exclusive_status = 'checked';
            // }

            if (product_or_service_status == 1) {
                bonus_qty_status = 'readonly';
            }


            jQuery("#table_body").append('<tr class="edit_update" id="table_row' + counter + '">' +
                // '<td class="tbl_srl_4">02</td> ' +
                '<td class="tbl_srl_9">' +
                '<input type="hidden" name="product_or_service_status[]" id="product_or_service_status' + counter + '" placeholder="Status" ' + 'class="inputs_up_tbl" value="' +
                product_or_service_status + '" readonly/>' +
                '<input type="hidden" name="pro_code[]" id="pro_code' + counter + '" placeholder="Code" ' + 'class="inputs_up_tbl" value="' + code + '" readonly/>' +code+
                '</td> ' +
                '<td class="text-left tbl_txt_13">' +
                '<input type="hidden" name="pro_name[]" id="pro_name' + counter + '" placeholder="Name" ' + 'class="inputs_up_tbl" value="' + name + '" readonly/>' +name+
                '</td> ' +
                '<td class="text-left tbl_txt_13">' +
                '<input type="text" name="product_remarks[]" id="product_remarks' + counter + '" placeholder="Remarks" ' + 'class="inputs_up_tbl" value="' + remarks + '"/>' +
                '</td>' +
                '<td class="text-left tbl_txt_13" id="warehouse_div_col' + counter + '">' +
                '</td>' +
                '<td class="tbl_srl_4">' +
                '<input type="text" name="quantity[]" id="quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                quantity + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +   /* Changed By Abdullah: old -> return
                allowOnlyNumber(event); */
                '</td>' +

                // '<td class="text-right tbl_srl_6"> ' +
                // '<input type="text" name="rate[]" id="rate' + counter + '" ' + 'placeholder="Rate" class="inputs_up_tbl text-right" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                // rate + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                // '</td> ' +

                '<td class="tbl_srl_4">' +
                '<input type="hidden" name="unit_measurement[]" id="unit_measurement' + counter + '" class="inputs_up_tbl" placeholder="UOM" value="' + unit_measurement + '" readonly/>'
                +unit_measurement+
                '</td>' +

                '<td class="tbl_srl_5" hidden> ' +
                '<input type="hidden" name="bonus[]" id="bonus' + counter + '" placeholder="Bonus" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                bonus_qty + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" ' + bonus_qty_status + '/> ' +
                '</td> ' +

                '<td class="tbl_srl_4">' +
                '<input type="hidden" name="unit_measurement_scale_size[]" class="inputs_up_tbl" id="unit_measurement_scale_size' + counter + '" placeholder="Scale Size" value="' +
                unit_measurement_scale_size + '" readonly/>' +unit_measurement_scale_size+




                // '</td> ' +
                // '<td class="text-right tbl_srl_8"> ' +
                // '<input type="text" name="amount[]" id="amount' + counter + '" placeholder="Amount" class="inputs_up_tbl text-right" value="' + gross_amount + '" readonly/> ' +
                '<div class="edit_update_bx"> <div class="inc_dec_con">' +
                '<div class="inc_dec_bx for_inc"><i class="fa fa-plus" onclick=increase_quantity(' + counter + ')></i></div>' +
                '<div class="inc_dec_bx for_val">1</div>' +
                '<div class="inc_dec_bx for_dec"><i class="fa fa-minus" onclick=decrease_quantity(' + counter + ')></i></div>' +
                '</div> ' +
                '<a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i> </a> ' +
                '</div> ' +
                '</td> ' +
                '</tr>');

            if (product_or_service_status != 1) {
                duplicate_warehouse_dropdown(counter);
            }

            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);


            grand_total_calculation();
            check_invoice_type();
        }


        function delete_sale(current_item) {

            jQuery("#table_row" + current_item).remove();

            grand_total_calculation();
            check_invoice_type();
        }

        function increase_quantity(current_item) {

            var previous_qty = jQuery("#quantity" + current_item).val();
            var new_quantity = 1;
            if (previous_qty >= 0) {
                new_quantity = +previous_qty + +1;
            }

            jQuery("#quantity" + current_item).val(new_quantity);

            product_amount_calculation(current_item);
        }

        function decrease_quantity(current_item) {

            var previous_qty = jQuery("#quantity" + current_item).val();
            var new_quantity = 1;
            if (previous_qty >= 0) {
                new_quantity = previous_qty - 1;
            }

            jQuery("#quantity" + current_item).val(new_quantity);

            product_amount_calculation(current_item);
        }

        // jQuery("#cash_paid").keyup(function () {
        //     //
        //     // cash_return_calculation();
        // });



        function add_first_item() {
            var total_items = $('input[name="pro_code[]"]').length;

            if (total_items <= 0 || total_items == '') {
                jQuery("#table_body").html("");
            }
        }
    </script>
    {{--//////////////////////////////////////////////////////////////////// End Sale Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            {{--jQuery("#product_code").append("{!! $pro_code !!}");--}}
            {{--jQuery("#product_name").append("{!! $pro_name !!}");--}}



            // jQuery("#product_code").select2();
            // jQuery("#product_name").select2();

            jQuery("#account_name").select2();

            jQuery("#machine").select2();

            jQuery("#package").select2();

            jQuery("#warehouse").select2();

            jQuery("#sale_person").select2();
            jQuery("#posting_reference").select2();

            // $("#invoice_btn").click();
        });

        window.addEventListener('keydown', function (e) {
            if (e.which == 113) {
                // $('#product_code').select2('open');
            }

            if (e.keyCode == 65 && e.altKey) {
                $("#first_add_more").click();
            }
        });

        // $(document).keydown(function(e) {
        //     if (e.keyCode == 65 && e.altKey) {
        //         $("#first_add_more").click();
        //     }
        // });

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });


        // $('#view_detail').click(function () {
        //
        //     var btn_name = jQuery("#view_detail").html();
        //
        //     if (btn_name.trim() == 'View Detail') {
        //
        //         jQuery("#view_detail").html('Hide Detail');
        //     } else {
        //         jQuery("#view_detail").html('View Detail');
        //     }
        // });


        function check_invoice_type() {
            var total_items = $("#total_items").val();

            if (total_items == 0 || total_items == "") {
                $('.invoice_type:not(:checked)').attr('disabled', false);
            } else {
                $('.invoice_type:not(:checked)').attr('disabled', true);
            }
        }
    </script>


    <script type="text/javascript">
        $("#invoice_btn").click(function () {
            $("#invoice_con").toggle();
            $(".invoice_overlay").toggle();
            setTimeout(function () {
                $("#invoice_bx").toggleClass("show_scale");
            }, 200);
            setTimeout(function () {
                $("#invoice_bx").toggleClass("show_rotate");
            }, 350);
        });

        $("#invoice_cls_btn").click(function () {
            setTimeout(function () {
                $("#invoice_bx").toggleClass("show_rotate");
            }, 50);
            setTimeout(function () {
                $("#invoice_bx").toggleClass("show_scale");
            }, 200);
            setTimeout(function () {
                $("#invoice_con").toggle();
                $(".invoice_overlay").toggle();
            }, 650);
        });

        $("#credit_card_btn").click(function () {
            $("#crdt_crd_mdl").toggle();
        });

        $("#customer_info_btn").click(function () {
            $("#cstmr_info_mdl").toggle();
        });

        $("#cash_return_btn").click(function () {
            $("#cash_return_mdl").toggle();
        });

        $(".sm_mdl_cls").click(function () {
            $(this).closest('.invoice_sm_mdl').css('display', 'none');
        });

    </script>




@endsection

@section('shortcut_script')

    <script type="text/javascript">
        var $ = $.noConflict();
        $.Shortcuts.add({
            type: 'hold', mask: 'i+o', handler: function () {
                $("#invoice_con").toggle();
                $(".invoice_overlay").toggle();
                setTimeout(function () {
                    $("#invoice_bx").toggleClass("show_scale");
                }, 200);
                setTimeout(function () {
                    $("#invoice_bx").toggleClass("show_rotate");
                }, 350);
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f1', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $("#crdt_crd_mdl").toggle();
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f2', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $("#cstmr_info_mdl").toggle();
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f3', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $("#cash_return_mdl").toggle();
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'esc', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f7', handler: function () {
                jQuery("#product_code").focus();
                setTimeout(function () {
                    jQuery("#product_code").focus();
                    $('#product_code').select2('open');
                }, 50);
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f8', handler: function () {
                jQuery("#product_name").focus();
                setTimeout(function () {
                    jQuery("#product_name").focus();
                    $('#product_name').select2('open');
                }, 50);
            }
        });
        $.Shortcuts.start();

    </script>

@endsection

<script>
    function duplicate_warehouse_dropdown(counter) {

        //Clone the DropDownList
        var ddl = $("#warehouse").clone();

        //Set the ID and Name
        ddl.attr("id", "warehouse" + counter);
        ddl.attr("name", "warehouse[]");

        //[OPTIONAL] Copy the selected value
        var selectedValue = $("#warehouse option:selected").val();
        ddl.find("option[value = '" + selectedValue + "']").attr("selected", "selected");

        //Append to the DIV.
        $("#warehouse_div_col" + counter).append(ddl);

        $("#warehouse" + counter).removeClass("js-example-basic-multiple select2-hidden-accessible");
        $("#warehouse" + counter).removeAttr("href");

        // setTimeout(function() {
        //     jQuery("#warehouse" + counter).select2();
        // }, 1000);
    }
</script>
