@extends('extend_index')

@section('styles_get')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/custom-search/custom-search.css') }}">
    {{--    nabeel css blue--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">

@stop

@section('content')

    <!-- mana sara comments delete kr dia ha  previous sale invoice ka-->
    {{--                to get blue color cut invoice_bx from class--}}

    <div class="row">
        {{--            edit it--}}
        <div id="main_bg" class="container-fluid search-filter form-group form_manage">
            {{--                form header --}}
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Trade Product Packages</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <a class="add_btn list_link add_more_button" href="{{ route('trade_product_packages_list') }}"
                            role="button">
                            <i class="fa fa-list"></i> View List
                        </a>

                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            {{--                invoice container--}}
            <div id="invoice_con"><!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx"><!-- invoice box start -->
                    {{--form start--}}
                    <form name="f1" class="f1" id="f1" action="{{ route('submit_trade_product_packages') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                        @csrf
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->
                                {{--                                    above table--}}
                                <div class="invoice_row"><!-- invoice row start -->
                                    <!-- add start -->
                                    <div class="invoice_col form-group col-lg-10 col-md-9 col-sm-12 upper">
                                        {{--above table row1--}}
                                        <div class="invoice_row"> <!--row1 start -->
                                            <!-- add end -->
                                            <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.description')}}</p>
                                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Products
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->
                                                            <a href="{{ route('add_product') }}" target="_blank"
                                                                class="col_short_btn" data-container="body"
                                                                data-toggle="popover" data-trigger="hover"
                                                                data-placement="bottom" data-html="true"
                                                                data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_product_name" class="col_short_btn"
                                                                data-container="body" data-toggle="popover"
                                                                data-trigger="hover" data-placement="bottom"
                                                                data-html="true"
                                                                data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <div class="ps__search">

                                                            <input tabindex="1" autofocus type="text" name="product"
                                                                    id="product"
                                                                    class="inputs_up form-control ps__search__input"
                                                                    placeholder="Enter Product"
                                                                    onfocus="this.select();"
                                                                    {{--                                                                       onfocus=""--}}
                                                                    onkeydown="return not_plus_minus(event)"
                                                                    onfocusout="hideproducts();"
                                                            />
                                                        </div>

                                                        <span id="check_product_count" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div>

                                            <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a
                                                            data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                                            config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                                            config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Package Name
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <input tabindex="2" type="text" name="package_name" data-rule-required="true" data-msg-required="Please Enter Package Name"
                                                                class="inputs_up form-control" id="package_name"
                                                                value="{{old('package_name')}}" placeholder="Package Name">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a
                                                            data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Voucher Remarks
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <input tabindex="3" type="text" name="remarks"
                                                                class="inputs_up form-control"
                                                                id="remarks" placeholder="Remarks"
                                                                onkeydown="return not_plus_minus(event)">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                        </div><!-- invoice row1 end -->

                                    </div><!-- invoice row end -->

                                    <!-- add col-12 Filters start -->
                                    <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12" id="filters">
                                        <!-- invoice column start -->

                                        <div class="invoice_row"><!-- invoice row start -->


                                            <div class="invoice_col col-lg-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                            data-trigger="hover" data-placement="left"
                                                            data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.description')}}</p>
                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.benefits')}}</p>
                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Filters
                                                    </div><!-- invoice column title end -->

                                                                    {{--auto add--}}
                                                    <div class="custom-checkbox float-left pb-1">
                                                        <input type="checkbox"
                                                                class="custom-control-input company_info_check_box"
                                                                id="add_auto_material"
                                                                name="add_auto_material"
                                                                value="1" onclick="storecheckbox()">
                                                        <label
                                                            class="custom-control-label chck_pdng"
                                                            for="add_auto_material"> Auto
                                                            Add </label>
                                                    </div>
                                                    <!-- Auto add end -->

                                                </div><!-- invoice column box end -->

                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                    </div>
                                    <!-- add col-12 Filters end -->

                                </div><!-- invoice row end -->

                                {{--Table start--}}
                                <div class="invoice_col col-lg-12">
                                    <!-- invoice column start -->
                                    <div class="pro_tbl_con"><!-- product table container start -->
                                        <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                            <table class="table table-bordered table-sm"  id="category_dynamic_table">
                                                <thead>
                                                <tr>
                                                    <th class="tbl_srl_9"> Code</th>
                                                    <th class="tbl_txt_13"> Item Name</th>
                                                    <th class="tbl_txt_9"> Remarks</th>


                                                    {{--                                                        new empty--}}
                                                    <th class="tbl_srl_4"> Pack Detail</th>

                                                    <th class="tbl_txt_6"> Pack Size</th>


                                                    <th class="tbl_srl_4">
                                                        DB Qty
                                                    </th>

                                                    <th class="tbl_srl_4">
                                                        Pack Qty
                                                    </th>

                                                    <th class="tbl_srl_4">
                                                        Pack Rate
                                                    </th>

                                                    {{--                                                        empty ha--}}
                                                    <th class="tbl_srl_4">
                                                        Loose Qty
                                                    </th>


                                                    <th class="tbl_srl_6">
                                                        Loose Rate
                                                    </th>

                                                    <th class="tbl_srl_9">
                                                        Gross Amount
                                                    </th>
                                                    {{--                                                        <th class="tbl_srl_5">--}}
                                                    {{--                                                            Bonus--}}
                                                    {{--                                                        </th>--}}

                                                    <th class="tbl_srl_4">
                                                        UOM
                                                    </th>


                                                    <!-- grid changed End-->

                                                    <th class="tbl_srl_9">
                                                        Net Amount
                                                    </th>
                                                    <th class="tbl_srl_4">
                                                        Actions
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="table_body">


                                                </tbody>
                                            </table>
                                        </div><!-- product table box end -->
                                    </div><!-- product table container end -->
                                </div><!-- invoice column end -->
                                {{--Table end--}}


                            </div><!-- invoice row end -->
                        </div><!-- invoice column end -->

                        {{--Lower section start--}}
                        <div class="invoice_row mt-1 justify-content-end"><!-- invoice row start -->
                            {{--Lower section col 3 --}}
                            <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
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
                                                Total Pack Items
                                            </label>
                                            <div class="invoice_col_input">
                                                <input type="text" name="total_items"
                                                        data-rule-required="true" data-msg-required="Add Item"
                                                        class="inputs_up form-control text-right total-items-field lower_inputs lower_style"
                                                        id="total_items" readonly>
                                            </div>
                                        </div><!-- invoice inline input text end -->

                                        <div class="invoice_inline_input_txt">
                                            <!-- invoice inline input text start -->
                                            <label class="inline_input_txt_lbl" for="total_price">
                                                Sub Total
                                            </label>
                                            <div class="invoice_col_input">
                                                <input type="text" name="total_price"
                                                        data-rule-required="true" data-msg-required="Add Sub Total"
                                                        class="inputs_up form-control text-right lower_inputs lower_style"
                                                        id="total_price" readonly>
                                            </div>
                                        </div><!-- invoice inline input text end -->


                                    </div><!-- invoice column input end -->
                                </div><!-- invoice column box end -->
                            </div><!-- invoice column end -->


                            {{--Lower section col 5 --}}
                            <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->

                                <div class="invoice_row justify-content-end mr-2"><!-- invoice row start -->

                                    <div class="invoice_col col-lg-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <label class=" invoice_col_ttl">
                                                <!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover"
                                                    data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.grand_total.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Grand Total
                                            </label><!-- invoice column title end -->
                                            <div class="invoice_col_txt ghiki mt-3 mb-2">
                                                <!-- invoice column input start -->
                                                <h5 id="grand_total_text" class="grand_font" data-rule-required="true"
                                                    data-msg-required="Please Add">
                                                    000,000
                                                </h5>
                                                <input type="hidden" name="grand_total" id="grand_total"
                                                        data-rule-required="true" data-msg-required="Please Add"/>


                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->


                                </div><!-- invoice row end -->
                            </div><!-- invoice column end -->

                        </div><!-- invoice row end -->


                        {{--                            shortcut buttons--}}
                        <div class="invoice_row"><!-- invoice row start -->

                            <div class="invoice_col basis_col_100 mt-0"><!-- invoice column start -->
                                <div class="invoice_col_txt with_cntr_jstfy">
                                    <!-- invoice column box start -->


                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                        <button id="all_clear_form" type="button" class="invoice_frm_btn"
                                                tabindex="12"
                                                onFocus="document.querySelector('.autofocus2').focus()">
                                            Clear (Ctrl+X)
                                        </button>
                                    </div>


                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                        <button tabindex="11" type="submit" class="invoice_frm_btn" name="save"
                                                id="save"
                                        >
                                            Save (Ctrl+S)
                                        </button>

                                    </div>

                                    <!-- invoice column box start -->
                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                        <button id="product_btn" type="button" class="invoice_frm_btn">
                                            Product (Ctrl+M)
                                        </button>
                                    </div>

                                </div><!-- invoice column box end -->
                            </div><!-- invoice column end -->


                        </div><!-- invoice row end -->

                    </form>
                    {{--form end--}}


                </div><!-- invoice box end -->
            </div><!-- invoice container end -->

        </div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript">
        function checkForm() {
            let package_name = document.getElementById("package_name"),
                total_items = document.getElementById("total_items"),
                total_price = document.getElementById("total_price"),
                grand_total = document.getElementById("grand_total"),
                grand_total_text = document.getElementById("grand_total_text"),
                validateInputIdArray = [
                    package_name.id,
                    total_items.id,
                    total_price.id,
                    grand_total.id,
                    grand_total_text.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"
            integrity="sha512-JZSo0h5TONFYmyLMqp8k4oPhuo6yNk9mHM+FY50aBjpypfofqtEWsAgRDQm94ImLCzSaHeqNvYuD9382CEn2zw=="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@6.4.1"></script>

    <script>
        var PRODUCTS_COLUMNS_NAMES = [
            'pro_p_code',
            'pro_title',
            'pro_code',
            'pro_clubbing_codes',
        ];
        var GET_PRODUCTS_ROUTE = '{{ route('ajax_get_json_products') }}';

    </script>

    <script src="{{ asset('public/plugins/custom-search/custom-search_2.js') }}"></script>

    {{--    refresh scripts--}}

    <script>
        //       changed by nabeel
        jQuery("#refresh_product_name").click(function () {

            var GET_PRODUCTS_ROUTE = '{{ route('ajax_get_json_products') }}';
            sirf_reload(GET_PRODUCTS_ROUTE);

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

        function focus_stay_on_product(evt) {
            if (evt.keyCode == 9) {  //means
                // alert("Tab pressed");
                if ($("#product")[0] == $(document.activeElement)[0]) {
                    evt.preventDefault();
                }
            }
        }

        function tab_within_table(evt, counter) {
            // alert("function called");
            if (evt.keyCode == 107) {   //means plus +

                if ($("#display_quantity" + counter)[0] == $(document.activeElement)[0]) {
                    $("#rate_per_pack" + counter).focus();
                } else if ($("#rate_per_pack" + counter)[0] == $(document.activeElement)[0]) {
                    $("#unit_qty" + counter).focus();
                } else if ($("#rate" + counter)[0] == $(document.activeElement)[0]) {
                    $("#bonus" + counter).focus();
                } else if ($("#unit_qty" + counter)[0] == $(document.activeElement)[0]) {
                    $("#rate" + counter).focus();
                } else if ($("#rate" + counter)[0] == $(document.activeElement)[0]) {
                    $("#bonus" + counter).focus();
                } else if ($("#bonus" + counter)[0] == $(document.activeElement)[0]) {
                    $("#trade_offer" + counter).focus();
                } else if ($("#trade_offer" + counter)[0] == $(document.activeElement)[0]) {
                    $("#product_discount" + counter).focus();
                } else if ($("#product_discount" + counter)[0] == $(document.activeElement)[0]) {
                    $("#product").focus();
                }
            }
            if (event.keyCode === 109) {   //means minus(-)

                // within table tab functionality
                if ($("#rate_per_pack" + counter)[0] == $(document.activeElement)[0]) {
                    $("#display_quantity" + counter).focus();
                } else if ($("#rate" + counter)[0] == $(document.activeElement)[0]) {
                    $("#unit_qty" + counter).focus();
                } else if ($("#unit_qty" + counter)[0] == $(document.activeElement)[0]) {
                    $("#rate_per_pack" + counter).focus();
                } else if ($("#display_quantity" + counter)[0] == $(document.activeElement)[0]) {
                    // $("#product").focus();
                } else if ($("#bonus" + counter)[0] == $(document.activeElement)[0]) {
                    $("#rate" + counter).focus();
                } else if ($("#trade_offer" + counter)[0] == $(document.activeElement)[0]) {
                    $("#bonus" + counter).focus();
                } else if ($("#product_discount" + counter)[0] == $(document.activeElement)[0]) {
                    $("#trade_offer" + counter).focus();
                } else if ($("#product_discount_amount" + counter)[0] == $(document.activeElement)[0]) {
                    $("#product_discount" + counter).focus();
                }

            }
        }

        // stop inputs to write + and -
        function not_plus_minus(evt) {
            if (evt.keyCode == 107 || evt.keyCode == 109) {
                evt.preventDefault();
            }
        }


        // when focus out from product table do not show its search table
        function hideproducts() {
            setTimeout(function () {
                $('.ps__search__results').css({
                    'display': 'none'
                });
            }, 500);
        }

        // to store data on browser start
        function store_print_checkbox() {

            if ($('#quick_print').is(":checked")) {
                var check_quick_print = 1;
            } else {
                var check_quick_print = 0;
            }

            if (typeof (Storage) !== "undefined") {
                // Store
                localStorage.setItem("quick_print_check", check_quick_print);
            }

        }

        function retrive_print_checkbox_data() {
            // Check browser support
            if (typeof (Storage) !== "undefined") {

                if (localStorage.getItem("quick_print_check") === "1") {
                    // Check
                    $("#quick_print").prop("checked", true);
                }

            } else {
                // document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
            }
        }


        function storecheckbox() {

            if ($('#add_auto_material').is(":checked")) {
                var check_auto_add = 1;
            } else {
                var check_auto_add = 0;
            }

            if (typeof (Storage) !== "undefined") {
                // Store
                localStorage.setItem("Auto_add_check", check_auto_add);
            }

        }

        function retrive_checkbox_data() {
            // Check browser support
            if (typeof (Storage) !== "undefined") {

                if (localStorage.getItem("Auto_add_check") === "1") {
                    // Check
                    $("#add_auto_material").prop("checked", true);
                }

            } else {
                // document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
            }
        }


        function popvalidation() {
            isDirty = true;

            var account_name = $("#account_name").val();
            var machine = $("#machine").val();
            var customer_email = $("#customer_email").val();
            var total_items = $("#total_items").val();
            var cash_paid = $("#cash_paid").val();
            var grand_total = $("#grand_total").val();

            var credit_card_number = $("#credit_card_number").val();
            var credit_card_amount = $("#credit_card_amount").val();


            var flag_submit = true;
            var focus_once = 0;

            var temp_grand_total = +cash_paid + +credit_card_amount;

            if (account_name.trim() == "0") {
                var isDirty = false;

                if (focus_once == 0) {
                    jQuery("#account_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }


            if (machine.trim() != "0") {

                if (credit_card_number.trim() == "") {
                    if (focus_once == 0) {
                        $("#credit_card_btn").click();
                        jQuery("#credit_card_number").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (credit_card_amount.trim() == "") {
                    if (focus_once == 0) {
                        $("#credit_card_btn").click();
                        jQuery("#credit_card_amount").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

            }


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
            var rate;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                quantity = +jQuery("#display_quantity" + pro_field_id).val();
                rate = jQuery("#rate" + pro_field_id).val();

                if (quantity <= 0 || quantity == "") { /* Changed by Abdullah: old ->  if (quantity < 1 || quantity == "")   */
                    if (focus_once == 0) {
                        jQuery("#display_quantity" + pro_field_id).focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (rate == "0" || rate == "") {
                    if (focus_once == 0) {
                        jQuery("#rate" + pro_field_id).focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            });

            if (grand_total < 0) {
                if (focus_once == 0) {
                    document.getElementById("check_product_count").innerHTML = "Grand Total Cannot Be Less Than Zero";
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("check_product_count").innerHTML = "";
            }
            return flag_submit;
        }


    </script>

    <script>
        // adding sales into table
        var counter = 0;
        var total_discount = 0;

        function unit_rate_changed_live(id) {
            var unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + id).val();
            var unit_rate_piece = (jQuery("#rate_per_pack" + id).val() !== 0 || jQuery("#rate_per_pack" + id).val() !== "NaN" || jQuery("#rate_per_pack" + id).val() !== "") ? jQuery("#rate_per_pack" + id).val() : 1;
            var rate = parseFloat(unit_rate_piece / unit_measurement_scale_size);

            if (rate > 0) {
                jQuery("#rate" + id).val(rate);
            }
            var newRate = (rate === "" || rate === 0) ? 1 : rate;

            product_amount_calculation(id, newRate);
        }


        function product_amount_calculation_with_dis_amount(id, newRate = 0) {

            var display_quantity = jQuery("#display_quantity" + id).val();
            var unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + id).val();
            var rate = (newRate === 0 || newRate === "") ? jQuery("#rate" + id).val() : newRate;
            // var product_discount = jQuery("#product_discount" + id).val();
            var product_discount_amount = jQuery("#product_discount_amount" + id).val();  //nabeel
            var gross_amount = jQuery("#gross_amount" + id).val();  //nabeel

            var product_sales_tax = jQuery("#product_sales_tax" + id).val();
            var rate_per_pack = 0;
            // var trade_off = 0;
            var unit_qty = jQuery("#unit_qty" + id).val();//mustafa

            if (unit_qty >= parseFloat(unit_measurement_scale_size)) {
                unit_qty = 0;
                jQuery("#unit_qty" + id).val('');
            }

            // nabbel
            display_quantity = Math.round(display_quantity);
            jQuery("#display_quantity" + id).val(display_quantity);


            var trade_offer = jQuery("#trade_offer" + id).val();//mustafa

            //nabeel
            // if (newRate === 0 || newRate === "") {
            rate_per_pack = rate * unit_measurement_scale_size;
            // }
            // var gross_amount = quantity * rate;
            var gross_amount = +((unit_measurement_scale_size * display_quantity) + +unit_qty) * rate;  //mustafa

            var quantity = +unit_qty + +(display_quantity * unit_measurement_scale_size);
            if (quantity == "") {
                quantity = 0;
            }


            // round_off_discount = grand_total - Math.round(grand_total);

            var product_sale_tax_amount;
            var product_rate_after_discount;
            var product_inclusive_rate;
            // var product_discount_amount;
            var discount_percentage;

            // var amount = (quantity * product_inclusive_rate) + product_sale_tax_amount;
            var amount = gross_amount - trade_offer - product_discount_amount; //mustafa

            jQuery("#amount" + id).val(amount.toFixed(2));
            jQuery("#product_sale_tax_amount" + id).val(product_sale_tax_amount.toFixed(2));
            jQuery("#product_inclusive_rate" + id).val(product_inclusive_rate.toFixed(2));
            // jQuery("#product_discount_amount" + id).val(product_discount_amount.toFixed(2));
            jQuery("#product_discount" + id).val(discount_percentage.toFixed(2));


            if (newRate === 0 || newRate === "") {
                jQuery("#rate_per_pack" + id).val(rate_per_pack);
            }
            jQuery("#gross_amount" + id).val(gross_amount.toFixed(2));
            jQuery("#quantity" + id).val(quantity.toFixed(3));

            grand_total_calculation_with_disc_amount();
        }


        function product_amount_calculation(id, newRate = 0) {

            // alert("called");

            var display_quantity = jQuery("#display_quantity" + id).val();
            var unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + id).val();
            var rate = (newRate === 0 || newRate === "") ? jQuery("#rate" + id).val() : newRate;
            var product_discount = jQuery("#product_discount" + id).val();
            // var get_product_discount_amount = jQuery("#product_discount_amount" + id).val();  //nabeel
            var gross_amount = jQuery("#gross_amount" + id).val();  //nabeel

            var product_sales_tax = jQuery("#product_sales_tax" + id).val();
            var rate_per_pack = 0;
            // var trade_off = 0;
            var unit_qty = jQuery("#unit_qty" + id).val();//mustafa

            if (unit_qty >= parseFloat(unit_measurement_scale_size)) {
                unit_qty = 0;
                jQuery("#unit_qty" + id).val('');
            }

            // nabeel
            display_quantity = Math.round(display_quantity);
            jQuery("#display_quantity" + id).val(display_quantity);


            var trade_offer = jQuery("#trade_offer" + id).val();//mustafa

            // alert(rate_per_pack);

            //nabeel
            // if (newRate === 0 || newRate === "") {

            if (unit_measurement_scale_size == "") {   //if service is entered
                // alert("service code");
                var quantity = display_quantity;
                gross_amount = display_quantity * rate;
                // alert("service");

                jQuery("#unit_qty" + id).prop("disabled", true);
                jQuery("#rate_per_pack" + id).prop("disabled", true);

            } else {
                rate_per_pack = rate * unit_measurement_scale_size;

                var gross_amount = +((unit_measurement_scale_size * display_quantity) + +unit_qty) * rate;  //mustafa


                var quantity = +unit_qty + +(display_quantity * unit_measurement_scale_size)

            }


            // var amount = (quantity * product_inclusive_rate) + product_sale_tax_amount;
            var amount = gross_amount; //mustafa

            jQuery("#amount" + id).val(amount.toFixed(2));


            if (newRate === 0 || newRate === "") {
                jQuery("#rate_per_pack" + id).val(rate_per_pack);
            }
            jQuery("#gross_amount" + id).val(gross_amount.toFixed(2));
            jQuery("#quantity" + id).val(quantity.toFixed(3));

            grand_total_calculation_with_disc_amount();
        }


        function grand_total_calculation() {

            var disc_percentage = jQuery("#disc_percentage").val();

            var total_price = 0;
            var total_product_discount = 0;
            var total_service_discount = 0;
            var total_inclusive_sale_tax_amount = 0;
            var total_exclusive_sale_tax_amount = 0;
            var service_total_inclusive_sale_tax_amount = 0;
            var service_total_exclusive_sale_tax_amount = 0;
            var total_sale_tax_amount = 0;
            var grand_total = 0;
            var round_off_discount = 0;
            var disc_percentage_amount = 0;


            var product_quantity;
            var product_rate;
            var product_discount_amount = 0;
            var product_sale_tax_amount = 0;
            var product_amount = 0;
            var product_or_service_status;
            //nabeel
            var trade_offer = 0;
            var total_trade_offer = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#display_quantity" + pro_field_id).val();
                product_unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + pro_field_id).val();
                product_rate = jQuery("#rate" + pro_field_id).val();
                product_discount_amount = jQuery("#product_discount_amount" + pro_field_id).val();

                product_sale_tax_amount = jQuery("#product_sale_tax_amount" + pro_field_id).val();
                product_amount = jQuery("#amount" + pro_field_id).val();
                gross_amount = jQuery("#gross_amount" + pro_field_id).val();
                product_or_service_status = jQuery("#product_or_service_status" + pro_field_id).val();
                //nabeel
                trade_offer = jQuery("#trade_offer" + pro_field_id).val();

                // total_price = +total_price + +(parseFloat(product_rate) * parseFloat(product_quantity));
                total_price = +total_price + +gross_amount; //nabeel

                total_trade_offer = +total_trade_offer + +trade_offer;

                if (product_or_service_status == 0) {
                    total_product_discount = +total_product_discount + +product_discount_amount;

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                        total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                    } else {
                        total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                    }
                } else {

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                        service_total_inclusive_sale_tax_amount = +service_total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                    } else {
                        service_total_exclusive_sale_tax_amount = +service_total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                    }

                    total_service_discount = +total_service_discount + +product_discount_amount;
                }


                // if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                //
                //     total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;
                //
                // } else {
                //     total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                // }

                total_sale_tax_amount = +total_sale_tax_amount + +product_sale_tax_amount;

                grand_total = +grand_total + +product_amount;
            });

            disc_percentage_amount = (total_price * disc_percentage) / 100;

            total_discount = +total_product_discount + +total_service_discount + +disc_percentage_amount;

            grand_total = +(total_price - total_discount - total_trade_offer) + +total_exclusive_sale_tax_amount;

            var radioValue = $("input[name='round_off']:checked").val();

            if (radioValue == 1) {
                round_off_discount = grand_total - Math.round(grand_total);
            }

            total_discount = +total_discount + +round_off_discount;

            grand_total = grand_total - round_off_discount;

            jQuery("#total_price").val(total_price.toFixed(2));
            jQuery("#total_product_discount").val(total_product_discount.toFixed(2));
            jQuery("#total_service_discount").val(total_service_discount.toFixed(2));
            jQuery("#round_off_discount").val(round_off_discount.toFixed(2));
            jQuery("#disc_amount").val(disc_percentage_amount.toFixed(2));
            jQuery("#total_discount").val(total_discount.toFixed(2));
            jQuery("#total_inclusive_tax").val(total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_exclusive_tax").val(total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#service_total_inclusive_tax").val(service_total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#service_total_exclusive_tax").val(service_total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_tax").val(total_sale_tax_amount.toFixed(2));
            jQuery("#grand_total").val(grand_total.toFixed(2));

            // var total_items = $('input[name="pro_code[]"]').length;
            var total_items = 0;


            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                //nabeel change
                var proQuantity = jQuery("#quantity" + pro_field_id).val();
                total_items = total_items + parseFloat(proQuantity);
                console.log(total_items);
            });

            jQuery("#total_items").val(total_items);
            $("#grand_total_text").text(Number(grand_total.toFixed(2)).toLocaleString('en'));

            cash_return_calculation();
        }

        function grand_total_calculation_with_disc_amount() {
            var total_price = 0;

            var grand_total = 0;


            var product_quantity;
            var product_unit_measurement_scale_size;
            var product_rate;
            var product_amount = 0;


            //nabeel

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#display_quantity" + pro_field_id).val();
                product_unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + pro_field_id).val();
                product_rate = jQuery("#rate" + pro_field_id).val();

                product_amount = jQuery("#amount" + pro_field_id).val();

                //nabeel

                gross_amount = jQuery("#gross_amount" + pro_field_id).val();

                // total_price = +total_price + +(product_rate * product_quantity);
                total_price = +total_price + +gross_amount; //nabeel


                grand_total = +grand_total + +product_amount;
            });


            grand_total = total_price;
            // alert(total_discount);


            grand_total = grand_total;

            jQuery("#total_price").val(total_price.toFixed(2));
            jQuery("#grand_total").val(grand_total.toFixed(2));

            // var total_items = $('input[name="pro_code[]"]').length;

            // may be cause problem
            // jQuery("#total_items").val(total_items);


            var total_items = 0;

            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                //nabeel change
                var proQuantity = jQuery("#quantity" + pro_field_id).val();
                total_items = total_items + parseFloat(proQuantity);
                console.log(total_items);
            });

            jQuery("#total_items").val(total_items);

            $("#grand_total_text").text(Number(grand_total.toFixed(2)).toLocaleString('en'));

            // cash_return_calculation();
        }


        function productChanged(product) {
            counter++;
            add_first_item();
            var code = product.pro_p_code;
            var parent_code = product.pro_p_code;
            var name = product.pro_title;
            var unit_measurement_scale_size = product.unit_scale_size;

            var quantity = unit_measurement_scale_size * 1;
            var pack_qty = Math.floor(quantity / unit_measurement_scale_size);//mustafa
            var unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);
            // var pack_qty=1;
            // var unit_qty=0;
            var unit_measurement = product.unit_title;
            var main_unit_measurement = product.mu_title;
            var bonus_qty = '';
            var rate = product.pro_sale_price;
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

            var rate_per_pack = rate * unit_measurement_scale_size;
            var gross_amount = quantity * rate;

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
                            pack_qty = Math.floor(quantity / unit_measurement_scale_size);//mustafa
                            unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);

                            bonus_qty = jQuery("#bonus" + pro_field_id).val();
                            rate = jQuery("#rate" + pro_field_id).val();
                            discount = jQuery("#product_discount" + pro_field_id).val();
                            sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                            if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                                inclusive_exclusive = 1;
                            }

                            delete_sale(pro_field_id);
                        }
                    });
                }
            }


            /**
             * Chaning according to Ahmad Hassan Sahab End
             * One Product Multi time enter with separate index
             */


            if ($(".invoice_type").is(':checked')) {
                if ($(".invoice_type:checked").val() == 1) {
                    sales_tax = 0;
                }
            }

            // if ($(".discount_type").is(':checked')) {
            //     if ($(".discount_type:checked").val() == 1) {
            //         discount = 0;
            //     } else if ($(".discount_type:checked").val() == 2) {
            //         discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
            //     } else if ($(".discount_type:checked").val() == 3) {
            //         discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
            //     } else if ($(".discount_type:checked").val() == 4) {
            //         discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
            //     }
            // }

            add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 0, unit_measurement, main_unit_measurement, unit_measurement_scale_size, rate_per_pack, gross_amount, pack_qty, unit_qty);

            product_amount_calculation(counter);

        }

        jQuery("#all_clear_form").click(function () {
            jQuery("#table_body").html("");
            grand_total_calculation_with_disc_amount();

            jQuery("#remarks").val("");

        });


        jQuery("#product_btn").click(function () {
            $("#product").focus();
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
                        // var name = $("#product_name option:selected").text();
                        var name = value['ppi_product_name'];
                        var quantity = value['ppi_qty'];
                        var unit_measurement = value['ppi_uom'];
                        // var unit_measurement = $("#product_name option:selected").attr('data-unit');

                        // var unit_measurement_scale_size = $('option:selected', this).attr('data-unit_scale_size');
                        var unit_measurement_scale_size = value['ppi_scale_size'];
                        var main_unit_measurement = value['mu_title'];
                        var pack_qty = Math.floor(quantity / unit_measurement_scale_size);//mustafa
                        var unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);

                        var bonus_qty = '';
                        var rate = value['ppi_rate'];
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

                        var rate_per_pack = rate * unit_measurement_scale_size;
                        var gross_amount = quantity * rate;

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

                                    pack_qty = Math.floor(quantity / unit_measurement_scale_size);//mustafa
                                    unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);

                                    bonus_qty = jQuery("#bonus" + pro_field_id).val();
                                    rate = jQuery("#rate" + pro_field_id).val();
                                    discount = jQuery("#product_discount" + pro_field_id).val();
                                    sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                                        inclusive_exclusive = 1;
                                    }

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

                        add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount,
                            inclusive_exclusive, counter, 0, unit_measurement, main_unit_measurement, unit_measurement_scale_size, rate_per_pack, gross_amount, pack_qty, unit_qty);

                        // product_amount_calculation(counter);
                        product_amount_calculation_with_dis_amount(counter);

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

        function add_sale(code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                          counter, product_or_service_status, unit_measurement, main_unit_measurement, unit_measurement_scale_size, rate_per_pack, gross_amount, pack_qty, unit_qty) {


            var inclusive_exclusive_status = '';
            var bonus_qty_status = '';
            if (inclusive_exclusive == 1) {
                inclusive_exclusive_status = 'checked';
            }

            if (product_or_service_status == 1) {
                bonus_qty_status = 'readonly';
            }


            jQuery("#table_body").append('<tr class="edit_update" id="table_row' + counter + '">' +
                // '<td class="tbl_srl_4">02</td> ' +
                '<td class="tbl_srl_9">' +
                '<input type="hidden" name="product_or_service_status[]" id="product_or_service_status' + counter + '" placeholder="Status" ' + 'class="inputs_up_tbl" value="' +
                product_or_service_status + '" readonly/>' +
                '<input type="hidden" name="pro_code[]" id="pro_code' + counter + '" placeholder="Code" ' + 'class="inputs_up_tbl" value="' + code + '" readonly/>' +
                code + '</td> ' +
                '<td class="tbl_txt_13">' +
                '<input type="hidden" name="pro_name[]" id="pro_name' + counter + '" placeholder="Name" ' + 'class="inputs_up_tbl text-right" value="' + name + '" readonly/>' +
                name + '</td> ' +
                '<td class="text-left tbl_txt_9">' +
                '<input type="text" tabindex="-1" name="product_remarks[]" id="product_remarks' + counter + '" placeholder="Remarks" ' + 'class="inputs_up_tbl" value="' + remarks + '"/>' +
                '</td>' +
                // '<td class="text-left tbl_txt_10" id="warehouse_div_col' + counter + '">' +
                // '</td>' +


                {{--                                                        new empty--}}
                    '<td class="text-left tbl_srl_4">' +
                '<input type="hidden" name="main_unit_measurement[]" id="main_unit_measurement' + counter + '" placeholder="Main Unit" ' + 'class="inputs_up_tbl" value="' + main_unit_measurement + '"/>' + main_unit_measurement +
                '</td>' +


                '<td class="tbl_srl_6">' +
                '<input type="hidden" name="unit_measurement_scale_size_combined[]" class="inputs_up_tbl" id="pack_size' + counter + '" placeholder="Scale Size" value="' +
                unit_measurement_scale_size +
                " "
                + unit_measurement + '" readonly/>' + unit_measurement_scale_size + " " + unit_measurement +
                // '<input type="text" name="unit_measurement[]" id="unit_measurement' + counter + '" class="inputs_up_tbl" placeholder="UOM" value="' + unit_measurement + '" readonly/>' +

                '</td>' +

                '<td class="tbl_srl_4">' +
                '<input type="text" name="quantity[]" id="quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')"  onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +   /* Changed By Abdullah: old -> return
                  allowOnlyNumber(event); */
                '</td>' +

                '<td class="tbl_srl_4">' +
                '<input type="text" name="display_quantity[]" id="display_quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')" value="' +
                pack_qty + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +   /* Changed By Abdullah: old -> return
                  allowOnlyNumber(event); */
                '</td>' +

                '<td class="tbl_srl_4">' +
                '<input type="text" onfocus="this.select();" name="rate_per_pack[]" onkeyup="unit_rate_changed_live(' + counter + '),tab_within_table(event,' + counter + ')" class="inputs_up_tbl" id="rate_per_pack' + counter + '" placeholder="Rate Per Price" value="' + rate_per_pack + '" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                '</td>' +


                // new empty
                '<td class="tbl_srl_4">' +
                '<input type="hidden" hidden name="unit_measurement_scale_size[]" class="inputs_up_tbl" id="unit_measurement_scale_size' + counter + '" placeholder="Scale Size" value="' + unit_measurement_scale_size + '" readonly/>' +
                '<input type="text"  name="unit_qty[]" id="unit_qty' + counter + '" ' + ' placeholder="0" class="inputs_up_tbl percentage_textbox" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')"' +
                '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" value="' + unit_qty + '"/> ' +
                '</td>' +

                '<td class="text-right tbl_srl_6"> ' +
                '<input type="text" name="rate[]" id="rate' + counter + '" ' + 'placeholder="Rate" class="inputs_up_tbl text-right" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')" value="' +
                rate + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                '<input type="hidden" name="product_inclusive_rate[]" class="inputs_up ' + 'text-right form-control" id="product_inclusive_rate' + counter + '"  value="' + inclusive_rate + '"> ' +
                '</td> ' +


                '<td class="tbl_srl_9">' +
                '<input type="text" tabindex="-1" name="gross_amount[]" class="lower_inputs inputs_up_tbl text-right" id="gross_amount' + counter + '" placeholder="Gross Amount" value="' + gross_amount + '" readonly/>' +
                '</td>' +

                // '<td class="tbl_srl_5"> ' +
                // '<input type="text" name="bonus[]" id="bonus' + counter + '" placeholder="Bonus" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')" value="' +
                // bonus_qty + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" ' + bonus_qty_status + '/> ' +
                // '</td> ' +

                '<td class="tbl_srl_4">' +
                '<input type="hidden" name="unit_measurement[]" id="unit_measurement' + counter + '" class="inputs_up_tbl" placeholder="UOM" value="' + unit_measurement + '" readonly/>' + unit_measurement +
                '</td>' +

                {{--                                                        new empty--}}
                //     '<td class="tbl_srl_4"> ' +
                // '<input type="text" id="trade_offer' + counter + '" name="trade_offer[]" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')" placeholder=""' +
                // ' ' +
                // 'class="inputs_up_tbl"' +
                // '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' + '</td>' +


                // '<td class="tbl_srl_4"> ' +
                // '<input type="text" name="product_discount[]" id="product_discount' + counter + '" placeholder="Dis%" class="inputs_up_tbl percentage_textbox" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')" ' +
                // 'value="' + discount + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                // '</td> <td class="text-right tbl_srl_7"> ' +
                // '<input type="text" name="product_discount_amount[]" id="product_discount_amount' + counter + '" placeholder="Dis Amount" value="' + discount_amount + '"onfocus="this.select();" readonly  class="lower_inputs inputs_up_tbl text-right" ' +
                // '/> ' +

                // grid change start

                // '</td> <td class="tbl_srl_4" hidden> ' +
                // '<input type="text" name="product_sales_tax[]" id="product_sales_tax' + counter + '" placeholder="Tax%" class="inputs_up_tbl percentage_textbox" value="' + sales_tax + '" ' +
                // 'onkeyup="product_amount_calculation(' + counter + ')" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                // '</td> ' +
                // '<td class="text-right tbl_srl_7" hidden> ' +
                // '<input type="text" name="product_sale_tax_amount[]" id="product_sale_tax_amount' + counter + '" placeholder="Tax Amount" value="' + sale_tax_amount + '" class="inputs_up_tbl text-right" readonly/> ' +
                // '</td> ' +
                // '<td class="tbl_srl_4" hidden> <input type="checkbox" name="inclusive_exclusive[]" id="inclusive_exclusive' + counter + '" onclick="product_amount_calculation(' + counter + ');' +
                // '"' + inclusive_exclusive_status + ' value="1"/> ' +
                // '<input type="hidden" name="inclusive_exclusive_status_value[]" id="inclusive_exclusive_status_value' + counter + '"' + 'value="' + inclusive_exclusive + '"/> ' +


                // 1 ko cut kia ha
                '</td> ' +
                '<td class="text-right tbl_srl_9"> ' +
                '<input type="text" name="amount[]" tabindex="-1" id="amount' + counter + '" placeholder="Amount" class="lower_inputs inputs_up_tbl text-right" value="' + amount + '" readonly/> ' +
                '</td> ' +


                '<td class="text-right tbl_srl_4"> ' +
                '<div class="edit_update_bx"> <div class="inc_dec_con">' +
                '<div class="inc_dec_bx for_inc"><i class="fa fa-plus" onclick=increase_quantity(' + counter + ')></i></div>' +
                // '<div class="inc_dec_bx for_val">1</div>' +
                '<div class="inc_dec_bx for_dec"><i class="fa fa-minus" onclick=decrease_quantity(' + counter + ')></i></div>' +
                '</div> ' +
                '<a href="#" class="delete_link btn btn-sm btn-danger" tabindex="-1" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i> </a> ' +
                '</div> ' +
                '</td> ' +

                '</tr>');


            $("#display_quantity" + counter).focus();


            // on product insertion we set product value as spaces(   ) then we call keypress event to call event and empty the search
            if ($("#add_auto_material").is(':checked')) {
                $("#product").val("         ");
                $("#product").focus();
                $("#product").keypress();
                $("#product").keydown();
                $("#product").keyup();
            } else {
                $("#product").val("         ");
                $("#product").keypress();
                $("#product").keydown();
                $("#product").keyup();
                hideproducts();
            }

            var messageBody = document.querySelector('#table_body');
            messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;


            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);


            grand_total_calculation_with_disc_amount();
            check_invoice_type();
        }


        function delete_sale(current_item) {

            jQuery("#table_row" + current_item).remove();

            grand_total_calculation_with_disc_amount();
            check_invoice_type();
        }


        function increase_quantity(current_item) {

            var previous_qty = jQuery("#display_quantity" + current_item).val();
            var new_quantity = 1;
            if (previous_qty >= 0) {
                new_quantity = +previous_qty + +1;
            }

            jQuery("#display_quantity" + current_item).val(new_quantity);

            product_amount_calculation(current_item);
        }

        function decrease_quantity(current_item) {

            var previous_qty = jQuery("#display_quantity" + current_item).val();
            var new_quantity = 1;
            if (previous_qty >= 0) {
                new_quantity = previous_qty - 1;
            }

            jQuery("#display_quantity" + current_item).val(new_quantity);

            product_amount_calculation(current_item);
        }

        jQuery("#cash_paid").keyup(function () {

            cash_return_calculation();
        });

        function cash_return_calculation() {
            var cash_paid = jQuery("#cash_paid").val();
            var grand_total = jQuery("#grand_total").val();
            var credit_card_amount = jQuery("#credit_card_amount").val();
            // var service_grand_total = jQuery("#service_grand_total").val();
            var service_grand_total = 0;

            var cash_return = (+grand_total + +service_grand_total) - cash_paid - credit_card_amount;

            jQuery("#cash_return").val(cash_return.toFixed(2));
            jQuery("#invoice_cash_received").val(cash_paid);
        }

        function cash_return_calculation_invoice() {
            var cash_paid = jQuery("#cash_paid").val();
            var cash_received_from_customer = jQuery("#cash_received_from_customer").val();

            var cash_return = cash_received_from_customer - cash_paid;

            jQuery("#invoice_cash_return").val(cash_return.toFixed(2));
        }

        function add_first_item() {
            var total_items = $('input[name="pro_code[]"]').length;

            if (total_items <= 0 || total_items == '') {
                jQuery("#table_body").html("");
            }
        }


    </script>

    <script>


        jQuery(document).ready(function () {
            // Initialize select2


            jQuery("#service_code").select2();
            jQuery("#service_name").select2();

            // jQuery("#product_code").select2();
            // jQuery("#product_name").select2();

            jQuery("#account_name").select2();

            jQuery("#machine").select2();

            jQuery("#package").select2();

            jQuery("#warehouse").select2();

            jQuery("#sale_person").select2();

            // $("#invoice_btn").click();

            // to set first focus on account_name when document get ready

            $("#product").focus();


            retrive_checkbox_data();
            retrive_print_checkbox_data();

        });

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
        // change kro

        // change kro end
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
                $("#machine").focus();
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f2', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $("#cstmr_info_mdl").toggle();
                $("#customer_name").focus();

            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'f3', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $("#cash_return_mdl").toggle();
                $("#cash_received_from_customer").focus();
            }
        });
        $.Shortcuts.add({
            type: 'hold', mask: 'esc', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $('.cancel_button').click();
                $('#product').focus();
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

    //  ##########   nabeel ahmed scripts    ############


    document.addEventListener('keyup', function (event) {

        // when focus is on product_discount within table then move to product (we have done this to maintain same functionality of tab as by plus(=))
        if (event.keyCode === 9) {  // means tab
            if ($("#product_discount_amount" + counter)[0] == $(document.activeElement)[0]) {
                $("#product").focus();
            }
            event.preventDefault();
        }

        // cash paid must be 0 if value is ""
        if ($("#cash_paid").val() == "") {
            $("#cash_paid").val(0);
        }


        // to close dropdown search
        if (event.keyCode === 106) {     // means staric(*)
            if ($(".select2-container--open")[0].previousElementSibling == $("#account_name")[0]) {

                $('#account_name').select2({
                    selectOnClose: true
                });
                $('#account_name').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#sale_person")[0]) {

                $('#sale_person').select2({
                    selectOnClose: true
                });
                $('#sale_person').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#warehouse")[0]) {

                $('#warehouse').select2({
                    selectOnClose: true
                });
                $('#warehouse').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#service_name")[0]) {

                $('#service_name').select2({
                    selectOnClose: true
                });
                $('#service_name').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#package")[0]) {

                $('#package').select2({
                    selectOnClose: true
                });
                $('#package').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#machine")[0]) {

                $('#machine').select2({
                    selectOnClose: true
                });
                $('#machine').focus();
            }
        }


        if (event.keyCode === 107) {     // means plus(+)

            // for upper inputs tab functionality
            if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#account_name")[0]) {
                $("#remarks").focus();
            } else if ($("#remarks")[0] == $(document.activeElement)[0]) {
                $("#sale_person").focus();
            } else if ($("#sale_person")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
                $("#product").focus();
            }
            // else if ($("#product")[0] == $(document.activeElement)[0]) {
            //     // var value = document.getElementById("product").value;
            //     // document.getElementById("product").value = value.substr(0, value.length - 1);
            //     $("#warehouse").focus();
            // } else if ($("#warehouse")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#service_name").focus();
            // } else if ($("#service_name")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#package").focus();
            // } else if ($("#package")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#disc_amount").focus();
            // } else if ($("#disc_amount")[0] == $(document.activeElement)[0]) {
            //     $("#disc_percentage").focus();
            // } else if ($("#disc_percentage")[0] == $(document.activeElement)[0]) {
            //     $("#cash_paid").focus();
            // } else if ($("#cash_paid")[0] == $(document.activeElement)[0]) {
            //     $("#account_name").focus();
            // }


            // within table tab functionality
            // else if ($("#product_remarks" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#display_quantity" + counter).focus();
            // } else if ($("#display_quantity" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#rate" + counter).focus();
            // } else if ($("#rate" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#unit_qty" + counter).focus();
            // } else if ($("#unit_qty" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#rate_per_pack" + counter).focus();
            // } else if ($("#rate_per_pack" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#bonus" + counter).focus();
            // } else if ($("#bonus" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#trade_offer" + counter).focus();
            // } else if ($("#trade_offer" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#product_discount" + counter).focus();
            // } else if ($("#product_discount" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#product_discount_amount" + counter).focus();
            // } else if ($("#product_discount_amount" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#product").focus();
            // }


            // for f1 inputs tab functionality
            if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#machine")[0]) {
                $("#credit_card_number").focus();
            } else if ($("#credit_card_number")[0] == $(document.activeElement)[0]) {
                $("#credit_card_amount").focus();
            } else if ($("#credit_card_amount")[0] == $(document.activeElement)[0]) {
                $("#card_info_save").click();
                $("#cash_paid").focus();
            } else if ($("#card_info_save")[0] == $(document.activeElement)[0]) {
                $("#card_info_save").click();
                $("#cash_paid").focus();
            } else if ($("#credit_info_cancel_btn")[0] == $(document.activeElement)[0]) {
                $("#credit_info_cancel_btn").click();
                $("#cash_paid").focus();
            }

            // for f2 inputs tab functionality
            if ($("#customer_name")[0] == $(document.activeElement)[0]) {
                $("#customer_email").focus();
            } else if ($("#customer_email")[0] == $(document.activeElement)[0]) {
                $("#customer_phone_number").focus();
            } else if ($("#customer_phone_number")[0] == $(document.activeElement)[0]) {
                $("#customer_info_save_btn").click();
            } else if ($("#customer_info_save_btn")[0] == $(document.activeElement)[0]) {
                $("#customer_info_save_btn").click();
            } else if ($("#customer_info_cancel_btn")[0] == $(document.activeElement)[0]) {
                $("#customer_info_cancel_btn").click();
            }

            // for f3 inputs tab functionality
            if ($("#cash_received_from_customer")[0] == $(document.activeElement)[0]) {
                $("#cash_return_save_btn").click();
            } else if ($("#cash_return_save_btn")[0] == $(document.activeElement)[0]) {
                $("#cash_return_save_btn").click();
            } else if ($("#cash_return_cancel_btn")[0] == $(document.activeElement)[0]) {
                $("#cash_return_cancel_btn").click();
            }


            event.preventDefault();
        }


        if (event.keyCode === 109) {   //means minus(-)


            // within table tab functionality
            // if ($("#display_quantity" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#product").focus();
            // } else if ($("#rate" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#display_quantity" + counter).focus();
            // } else if ($("#unit_qty" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#rate" + counter).focus();
            // } else if ($("#rate_per_pack" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#unit_qty" + counter).focus();
            // } else if ($("#bonus" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#rate_per_pack" + counter).focus();
            // } else if ($("#trade_offer" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#bonus" + counter).focus();
            // } else if ($("#product_discount" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#trade_offer" + counter).focus();
            // } else if ($("#product_discount_amount" + counter)[0] == $(document.activeElement)[0]) {
            //     $("#product_discount" + counter).focus();
            // }

            // // for upper inputs tab functionality
            // if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#account_name")[0]) {
            //     $("#cash_paid").focus();
            // } else
            if ($("#remarks")[0] == $(document.activeElement)[0]) {
                $("#account_name").focus();
            } else if ($("#sale_person")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
                $("#remarks").focus();
            } else if ($("#product")[0] == $(document.activeElement)[0]) {
                // var value = document.getElementById("product").value;
                // document.getElementById("product").value = value.substr(0, value.length - 1);
                $("#sale_person").focus();
            }
            // else if ($("#warehouse")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#product").focus();
            // } else if ($("#service_name")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#warehouse").focus();
            // } else if ($("#package")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
            //     $("#service_name").focus();
            // } else if ($("#disc_amount")[0] == $(document.activeElement)[0]) {
            //     $("#package").focus();
            // } else if ($("#disc_percentage")[0] == $(document.activeElement)[0]) {
            //     $("#disc_amount").focus();
            // } else if ($("#cash_paid")[0] == $(document.activeElement)[0]) {
            //     $("#disc_percentage").focus();
            //     // alert("save btn focus ho gaya");
            // }


            // for f1 inputs tab functionality
            if ($("#credit_card_number")[0] == $(document.activeElement)[0]) {
                $("#machine").focus();
            } else if ($("#credit_card_amount")[0] == $(document.activeElement)[0]) {
                $("#credit_card_number").focus();
            }

            // for f2 inputs tab functionality
            if ($("#customer_name")[0] == $(document.activeElement)[0]) {
                $("#customer_email").focus();
            } else if ($("#customer_email")[0] == $(document.activeElement)[0]) {
                $("#customer_name").focus();
            } else if ($("#customer_phone_number")[0] == $(document.activeElement)[0]) {
                $("#customer_email").focus();
            }

        }

    });


    document.addEventListener('keyup', function (event) {


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
    document.addEventListener('keydown', function (e) {

        if (e.ctrlKey && e.key === "m") {     // when you press (ctrl + m) cursor moves to products input
            $("#product").focus();
            e.preventDefault();
        } else if (e.ctrlKey && e.key === "l") {   // when you press (ctrl + l) cursor moves to disc_amount input
            $("#cash_paid").focus();
            // alert("focus");
            e.preventDefault();
        } else if (e.ctrlKey && e.key === "s") {   // when you press (ctrl + s) save the invoice
            $("#save").click();
            e.preventDefault();
        }



    });


</script>

