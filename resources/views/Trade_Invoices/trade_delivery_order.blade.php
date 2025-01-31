@extends('extend_index')

@section('styles_get')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/custom-search/custom-search.css') }}">
    {{--    nabeel css blue--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">
@stop

@section('content')

    <style>

        .custom-checkbox {
            transform: scale(1.1);
            -webkit-transform: scale(1.1);
            margin-left: 10px;
            /*margin-top: 10px;*/
        }

    </style>


    <div class="row">
        <div id="main_bg" class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Trade Delivery Order</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <a class="add_btn list_link add_more_button" href="{{ route('trade_delivery_order_invoice_list') }}"
                           role="button">
                            <i class="fa fa-list"></i> Delivery Order List
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

            <div id="invoice_con" class="gnrl-mrgn-pdng"><!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx"><!-- invoice box start -->
                    <form name="f1" class="f1" id="f1" action="{{ route('submit_trade_delivery_order') }}"
                          onsubmit="return checkForm()" method="post" autocomplete="off">
                        @csrf
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                <div class="invoice_row"><!-- invoice row start -->
                                    <!-- add start -->
                                    <div class="invoice_col form-group col-lg-10 col-md-9 col-sm-12upper">
                                        <div class="invoice_row"><!-- invoice row start -->
                                            <div class="form-group col-xl-3 col-lg-3 col-md-4 col-sm-12"><!-- invoice column start -->
                                                <!-- Call saleman component -->
                                                <x-saleman-component />
                                            </div><!-- invoice column end -->

                                            <div class="form-group col-xl-3 col-lg-3 col-md-4 col-sm-12"><!-- invoice column -->
                                                <x-party-name-component tabindex="2" name="account_name" id="account_name" class="sale"/>
                                            </div>

                                            <div class="form-group col-xl-3 col-lg-3 col-md-4 col-sm-12"><!-- invoice column start -->
                                                <x-posting-reference tabindex="3"/>
                                            </div>

                                            <div class="form-group col-xl-3 col-lg-3 col-md-4 col-sm-12"><!-- invoice column start -->
                                                <x-remarks-component tabindex="4" name="remarks" id="remarks" title="Remarks"/>
                                            </div>
                                        </div>
                                        <div class="invoice_row mt-3">
                                            <div class="form-group col-xl-3 col-lg-3 col-md-4 col-sm-12"> <!-- invoice column start -->
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
                                                        <!-- call add or refresh button component -->
                                                        <x-add-refresh-button href="{{ route('add_product') }}" id="refresh_product_name"/>

                                                        <div class="ps__search">
                                                            <input tabindex="5" type="text" name="product" id="product"
                                                                   onkeydown="return not_plus_minus(event), focus_stay_on_product(event)"
                                                                   onfocusout="hideproducts();"
                                                                   onfocus="this.select();"
                                                                   class="inputs_up form-control ps__search__input" placeholder="Enter Product"/>
                                                        </div>

                                                        <span id="check_product_count" class="validate_sign"></span>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div>


                                            <div class="form-group col-xl-3 col-lg-3 col-md-4 col-sm-12"><!-- invoice column start -->
                                                <x-warehouse-component tabindex="6" name="warehouse" id="warehouse" class="refresh_warehouse" title="Warehouse"/>
                                            </div>

                                            <div class="form-group col-xl-3 col-lg-3 col-md-4 col-sm-12"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a
                                                            data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.sale_return_search.description')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Search Invoices
                                                    </div><!-- invoice column title end -->

                                                    <div class="invoice_col_input">
                                                        {{--                                                    Hamad set tab index--}}
                                                        <input tabindex="7" type="text" name="invoice_nbr_chk" class="inputs_up form-control" id="invoice_nbr_chk" placeholder="Check Invoice Number">


                                                        <!-- changed added start (search btn) -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                            <a id="search_product_name" class="col_short_btn"
                                                               data-container="body" data-toggle="popover"
                                                               data-trigger="hover" data-placement="bottom"
                                                               data-html="true"
                                                               data-content="{{config('fields_info.search_btn.description')}}">
                                                                <l class="fa fa-search"></l>
                                                            </a>
                                                        </div>
                                                        <!-- changed added end -->


                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                        </div><!-- invoice row end -->


                                    </div>

                                    <div class="col-lg-2 col-md-3 col-sm-12" id="filters">
                                        <!-- invoice column start -->
                                        <div class="invoice_row"><!-- invoice row start -->
                                            <div class="invoice_col form-group col-lg-12 col-md-12 col-sm-12"><!-- invoice column start -->
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
                                                    <!-- add start -->
                                                    <div class="custom-checkbox float-left mr-5 mt-3">
                                                        <input type="checkbox" value="1"
                                                               name="check_multi_warehouse"
                                                               class="custom-control-input company_info_check_box"
                                                               id="check_multi_warehouse">
                                                        <label class="custom-control-label chck_pdng"
                                                               for="check_multi_warehouse"> Multi
                                                            Warehouse </label>
                                                    </div>

                                                    {{--                                                        auto add--}}


                                                    {{--                                                        Quick print start--}}

                                                    <div class="custom-checkbox float-left pb-2 mt-2">
                                                        <input type="checkbox" value="1"
                                                               name="quick_print"
                                                               class="custom-control-input company_info_check_box"
                                                               id="quick_print"
                                                               onclick="store_print_checkbox()"
                                                        >
                                                        <label class="custom-control-label chck_pdng"
                                                               for="quick_print"> Quick Print
                                                        </label>
                                                    </div>


                                                </div><!-- invoice column box end -->

                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                    </div>

                                </div>

                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="pro_tbl_con"><!-- product table container start -->
                                        <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                            <table class="table table-bordered table-sm" id="category_dynamic_table">
                                                <thead>
                                                <tr>
                                                    {{--  <th class="tbl_srl_4"> Sr.</th>  --}}
                                                    <th class="tbl_srl_7"> Code</th>
                                                    <th class="tbl_txt_7"> Title</th>
                                                    <th class="tbl_txt_7"> Remarks</th>
                                                    <th class="tbl_txt_7"> Warehouse</th>

                                                    <th class="tbl_srl_6" hidden>
                                                        Rate
                                                    </th>
                                                    <th class="tbl_srl_4">
                                                        UOM
                                                    </th>
                                                    <th class="tbl_srl_4">
                                                        Pack Detail
                                                    </th>
                                                    <th class="tbl_srl_4">
                                                        Pack Size
                                                    </th>
                                                    <th class="tbl_srl_4" hidden>
                                                        DB Qty
                                                    </th>
                                                    <th class="tbl_srl_4">
                                                        Pack Qty
                                                    </th>
                                                    <th class="tbl_srl_4">
                                                        Loose Qty
                                                    </th>
                                                    <th class="tbl_srl_5">
                                                        Bonus
                                                    </th>
                                                    <th class="tbl_srl_8" hidden>
                                                        Amount
                                                    </th>
                                                    <th class="tbl_srl_3">
                                                        Actions
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="table_body">
                                                </tbody>
                                            </table>
                                        </div><!-- product table box end -->
                                    </div><!-- product table container end -->
                                </div><!-- invoice row end -->

                                <div class="invoice_row justify-content-center"><!-- invoice row start -->


                                    <div class="invoice_col form-group col-lg-3 col-md-4 col-sm-12"><!-- invoice column start -->
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

                                                <div class="invoice_inline_input_txt mb-0">
                                                    <!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl" for="total_items">
                                                        Total Items
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text" name="total_items"
                                                               class="inputs_up form-control text-right total-items-field lower_inputs lower_style" data-rule-required="true"
                                                               data-msg-required="Please Select Party"
                                                               id="total_items" readonly>


                                                    </div>
                                                </div><!-- invoice inline input text end -->

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->


                                </div><!-- invoice row end -->

                                <div class="invoice_row"><!-- invoice row start -->

                                    <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                        <div class="invoice_col_txt with_cntr_jstfy">
                                            <!-- invoice column box start -->

                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button id="customer_info_btn" type="button"
                                                        class="invoice_frm_btn">
                                                    Customer Info (F2)
                                                </button>
                                            </div>

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

                                            <!-- invoice column box start -->
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button id="product_btn" type="button" class="invoice_frm_btn">
                                                    Product (Ctrl+M)
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

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Party Reference
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="customer_name"
                                                               onkeydown="return not_plus_minus(event)"
                                                               class="inputs_up form-control" id="customer_name"
                                                               placeholder="Party Reference">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Email
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="customer_email"
                                                               onkeydown="return not_plus_minus(event)"
                                                               class="inputs_up form-control" id="customer_email"
                                                               placeholder="Email">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Phone Number
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="customer_phone_number"
                                                               onkeydown="return not_plus_minus(event)"
                                                               class="inputs_up form-control"
                                                               id="customer_phone_number"
                                                               placeholder="Phone Number">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_txt with_cntr_jstfy">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button id="customer_info_save_btn" type="button" class="invoice_frm_btn sm_mdl_cls">
                                                            Save
                                                        </button>
                                                    </div>
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button type="button" class="invoice_frm_btn sm_mdl_cls"
                                                                id="customer_info_cancel_btn">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

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

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Delivery Order Invoice Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
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
    {{--show print invoice after save invoice start--}}

    @if (Session::get('doi_id'))
        <script>


            jQuery("#table_body").html("");

            var id = '{{ Session::get("doi_id") }}';

            $('.modal-body').load('{{url("delivery_order_items_view_details/view/")}}' + '/' + id, function () {
                // jQuery(".pre-loader").fadeToggle("medium");
                $('#myModal').modal({show: true});


                // for print preview to not remain on screen
                if ($('#quick_print').is(":checked")) {

                    setTimeout(function () {
                        var abc = $("#printi");
                        abc.click();

                        $('.invoice_sm_mdl').css('display', 'none');
                        $('.cancel_button').click();
                        $('#product').focus();
                    }, 500);
                }


            })
            ;
        </script>
    @endif

    {{--show print invoice after save invoice end--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"
            integrity="sha512-JZSo0h5TONFYmyLMqp8k4oPhuo6yNk9mHM+FY50aBjpypfofqtEWsAgRDQm94ImLCzSaHeqNvYuD9382CEn2zw==" crossorigin="anonymous"></script>
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


        jQuery("#product_btn").click(function () {
            $("#product").focus();
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

            var display_quantity = jQuery("#display_quantity" + id).val();
            var quantity = jQuery("#quantity" + id).val();
            var unit_qty = jQuery("#unit_qty" + id).val();

            var rate = jQuery("#rate" + id).val();
            var unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + id).val();

            if (unit_qty >= parseFloat(unit_measurement_scale_size)) {
                unit_qty = 0;
                jQuery("#unit_qty" + id).val('');
            }

            // nabeel
            display_quantity = Math.round(display_quantity);
            jQuery("#display_quantity" + id).val(display_quantity);

            if (quantity == "") {
                quantity = 0;
            }

            var gross_amount = +((unit_measurement_scale_size * display_quantity) + +unit_qty) * rate;
            var quantity = +unit_qty + +(display_quantity * unit_measurement_scale_size)


            // jQuery("#amount" + id).val(gross_amount);
            jQuery("#gross_amount" + id).val(gross_amount.toFixed(2));
            jQuery("#quantity" + id).val(quantity.toFixed(3));

            grand_total_calculation();
        }

        function checkQty(id) {
            var quantity = jQuery("#quantity" + id).val();
            var scale_size = jQuery("#unit_measurement_scale_size" + id).val();
            ;
            if (quantity < 1) {
                if (scale_size > 1) {
                    jQuery("#unit_qty" + id).val(1);
                } else {
                    jQuery("#display_quantity" + id).val(1);
                }

                product_amount_calculation(id);
            }

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


                product_quantity = jQuery("#display_quantity" + pro_field_id).val();
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

        // not in use
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


        function productChanged(product) {
            counter++;
            add_first_item();
            var code = product.pro_p_code;


            var parent_code = product.pro_p_code;
            var name = product.pro_title;
            // var display_quantity = 1;
            // var quantity = 1;
            var unit_measurement_scale_size = product.unit_scale_size;
            var unit_measurement = product.unit_title;
            var main_unit = product.mu_title;
            var quantity = unit_measurement_scale_size * 1;
            var pack_qty = Math.floor(quantity / unit_measurement_scale_size);//mustafa
            var unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);
            // alert(main_unit);
            // alert(unit_measurement);
            // alert(unit_measurement_scale_size);
            var bonus_qty = '';
            var rate = product.pro_average_rate;
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

                            // quantity = +jQuery("#display_quantity" + pro_field_id).val() + +display_quantity;
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


            add_sale(parent_code, name, quantity, bonus_qty, rate, gross_amount, remarks, counter, 0, unit_measurement, unit_measurement_scale_size, rate_per_pack, main_unit, pack_qty, unit_qty);

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


            add_sale(parent_code, name, quantity, bonus_qty, rate, gross_amount, remarks, counter, 0, unit_measurement, unit_measurement_scale_size);

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


            add_sale(parent_code, name, quantity, bonus_qty, rate, gross_amount, remarks, counter, 0, unit_measurement, unit_measurement_scale_size);

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

        function add_sale(code, name, quantity, bonus_qty, rate, gross_amount, remarks, counter,
                          product_or_service_status, unit_measurement, unit_measurement_scale_size, rate_per_pack, main_unit_measurement, pack_qty, unit_qty) {

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
                '<td class="tbl_srl_7">' +
                '<input type="hidden" name="product_or_service_status[]" id="product_or_service_status' + counter + '" placeholder="Status" ' + 'class="inputs_up_tbl" value="' +
                product_or_service_status + '" readonly/>' +
                '<input type="text" name="pro_code[]" id="pro_code' + counter + '" placeholder="Code" ' + 'class="inputs_up_tbl" value="' + code + '" readonly/>' +
                '</td> ' +
                '<td class="text-left tbl_txt_7">' +
                '<input type="text" name="pro_name[]" id="pro_name' + counter + '" placeholder="Name" ' + 'class="inputs_up_tbl" value="' + name + '" readonly/>' +
                '</td> ' +
                '<td class="text-left tbl_txt_7">' +
                '<input type="text" name="product_remarks[]" id="product_remarks' + counter + '" placeholder="Remarks" ' + 'class="inputs_up_tbl" value="' + remarks + '"/>' +
                '</td>' +
                '<td class="text-left tbl_txt_7" id="warehouse_div_col' + counter + '">' +
                '</td>' +


                '<td class="text-right tbl_srl_6" hidden> ' +
                '<input type="text" name="rate[]" id="rate' + counter + '" ' + 'placeholder="Rate" class="inputs_up_tbl text-right" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                rate + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                '</td> ' +

                '<td class="tbl_srl_4">' +
                '<input type="text" name="unit_measurement[]" id="unit_measurement' + counter + '" class="inputs_up_tbl" placeholder="UOM" value="' + unit_measurement + '" readonly/>' +
                '</td>' +


                {{--                                                        new empty--}}
                    '<td class="text-left tbl_srl_4">' +
                '<input type="hidden" name="main_unit_measurement[]" id="main_unit_measurement' + counter + '" placeholder="Main Unit" ' + 'class="inputs_up_tbl" value="' + main_unit_measurement + '"/>' + main_unit_measurement +
                '</td>' +

                '<td class="tbl_srl_4">' +
                '<input type="hidden" name="unit_measurement_scale_size_combined[]" class="inputs_up_tbl" id="pack_size' + counter + '" placeholder="Scale Size" value="' +
                unit_measurement_scale_size +
                " "
                + unit_measurement + '" readonly/>' + unit_measurement_scale_size + " " + unit_measurement +
                // '<input type="text" name="unit_measurement[]" id="unit_measurement' + counter + '" class="inputs_up_tbl" placeholder="UOM" value="' + unit_measurement + '" readonly/>' +

                '</td>' +


                '<td class="tbl_srl_4" hidden>' +
                '<input type="text" name="quantity[]" id="quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                quantity + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +   /* Changed By Abdullah: old -> return
                allowOnlyNumber(event); */
                '</td>' +

                // // prob satart
                // '<td class="tbl_srl_4">' +
                // '<input type="text" name="display_quantity[]" id="display_quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')" value="' +
                // quantity + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +   /* Changed By Abdullah: old -> return
                //   allowOnlyNumber(event); */
                // '</td>' +
                //
                // '<td class="tbl_srl_4">' +
                // '<input type="hidden" hidden name="unit_measurement_scale_size[]" class="inputs_up_tbl" id="unit_measurement_scale_size' + counter + '" placeholder="Scale Size" value="' + unit_measurement_scale_size + '" readonly/>' +
                // '<input type="text"  name="unit_qty[]" id="unit_qty' + counter + '" ' + ' placeholder="0" class="inputs_up_tbl percentage_textbox" onkeyup="product_amount_calculation(' + counter + '),tab_within_table(event,' + counter + ')"'+
                // '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                // '</td>' +
                // // prob end
                //
                //
                // prob satart
                '<td class="tbl_srl_4">' +
                '<input type="text" name="display_quantity[]" id="display_quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                pack_qty + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" onfocusout="checkQty(' + counter + ')"/>' +   /* Changed By Abdullah: old -> return
                  allowOnlyNumber(event); */
                '</td>' +

                '<td class="tbl_srl_4">' +
                '<input type="hidden" hidden name="unit_measurement_scale_size[]" class="inputs_up_tbl" id="unit_measurement_scale_size' + counter + '" placeholder="Scale Size" value="' + unit_measurement_scale_size + '" readonly/>' +
                '<input type="text"  name="unit_qty[]" id="unit_qty' + counter + '" ' + ' placeholder="0" class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')"' +
                '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" value="' + unit_qty + '" onfocusout="checkQty(' + counter + ')"/> ' +
                '</td>' +
                // prob end


                '<td class="text-right tbl_srl_8" hidden> ' +
                '<input type="text" name="amount[]" id="amount' + counter + '" placeholder="Amount" class="inputs_up_tbl text-right" value="' + gross_amount + '" readonly/> ' +
                '</td>' +

                '<td class="tbl_srl_5"> ' +
                '<input type="text" name="bonus[]" id="bonus' + counter + '" placeholder="Bonus" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                bonus_qty + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" ' + bonus_qty_status + '/> ' +
                // '</td> ' +
                // '<td class="text-right tbl_srl_6"> ' +
                // '<input type="text" name="rate[]" id="rate' + counter + '" ' + 'placeholder="Rate" class="inputs_up_tbl text-right" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                // rate + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                // '<input type="hidden" name="product_inclusive_rate[]" class="inputs_up ' + 'text-right form-control" id="product_inclusive_rate' + counter + '"  value="' + inclusive_rate + '"> ' +
                // '</td> ' +


                // '<td class="text-right tbl_srl_8" hidden> ' +
                // '<input type="text" name="amount[]" id="amount' + counter + '" placeholder="Amount" class="inputs_up_tbl text-right" value="' + gross_amount + '" readonly/> ' +


                '<td class="text-right tbl_srl_3"> ' +
                '<div class="edit_update_bx"> <div class="inc_dec_con">' +
                '<div class="inc_dec_bx for_inc"><i class="fa fa-plus" onclick=increase_quantity(' + counter + ')></i></div>' +
                // '<div class="inc_dec_bx for_val">1</div>' +
                '<div class="inc_dec_bx for_dec"><i class="fa fa-minus" onclick=decrease_quantity(' + counter + ')></i></div>' +
                '</div> ' +
                '<a href="#" class="delete_link btn btn-sm btn-danger" tabindex="-1" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i> </a> ' +
                '</div> ' +
                '</td> ' +

                '</tr>');

            $("#product").val("");
            $("#product").focus();
            $("#product").keypress();
            $("#product").keydown();
            $("#product").keyup();


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

            $("#sale_person").focus();

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

        $("#customer_info_btn").click(function () {
            $("#cstmr_info_mdl").toggle();
            $("#customer_name").focus();
        });

        $("#credit_card_btn").click(function () {
            $("#crdt_crd_mdl").toggle();
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
                $("#customer_name").focus();
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


    function not_plus_minus(evt) {
        if (evt.keyCode == 107 || evt.keyCode == 109) {
            evt.preventDefault();
        }
    }

    function focus_stay_on_product(evt) {
        if (evt.keyCode == 9) {  //means
            // alert("Tab pressed");
            if ($("#product")[0] == $(document.activeElement)[0]) {
                evt.preventDefault();
            }
        }
    }


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


    document.addEventListener('keyup', function (event) {

        // to close dropdown search
        if (event.keyCode === 106) {     // means staric(*)
            if ($(".select2-container--open")[0].previousElementSibling == $("#sale_person")[0]) {

                $('#account_name').select2({
                    selectOnClose: true
                });
                $('#account_name').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#warehouse")[0]) {

                $('#warehouse').select2({
                    selectOnClose: true
                });
                $('#warehouse').focus();

            } else if ($(".select2-container--open")[0].previousElementSibling == $("#account_name")[0]) {

                $('#warehouse').select2({
                    selectOnClose: true
                });
                $('#warehouse').focus();

            }
        }


        if (event.keyCode === 107) {     // means plus(+)

            // for upper inputs tab functionality
            if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#sale_person")[0]) {
                $("#account_name").focus();
            } else if ($("#account_name")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
                $("#remarks").focus();
            } else if ($("#remarks")[0] == $(document.activeElement)[0]) {
                $("#product").focus();
            }


            // for f2 inputs tab functionality
            if ($("#customer_name")[0] == $(document.activeElement)[0]) {
                $("#customer_email").focus();
            } else if ($("#customer_email")[0] == $(document.activeElement)[0]) {
                $("#customer_phone_number").focus();
            } else if ($("#customer_phone_number")[0] == $(document.activeElement)[0]) {
                $("#customer_info_save_btn").click();
                $("#product").focus();
            }

            event.preventDefault();
        }


        if (event.keyCode === 109) {   //means minus(-)


            // for upper inputs tab functionality
            if ($("#account_name")[0] == $(document.activeElement)[0].parentElement.parentElement.previousElementSibling) {
                $("#sale_person").focus();
            } else if ($("#remarks")[0] == $(document.activeElement)[0]) {
                $("#account_name").focus();
            } else if ($("#product")[0] == $(document.activeElement)[0]) {
                $("#remarks").focus();
            }


            // for f2 inputs tab functionality
            if ($("#customer_email")[0] == $(document.activeElement)[0]) {
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

    document.addEventListener('keydown', function (e) {
        if (e.ctrlKey && e.key === "s") {   // when you press (ctrl + s) save the invoice
            $("#save").click();
            e.preventDefault();
        }
    });

    function hideproducts() {
        setTimeout(function () {
            $('.ps__search__results').css({
                'display': 'none'
            });
        }, 500);
    }


    // when we type f1,f2 and f3 on some input default function of browser is called. To stop it we made this script
    document.addEventListener('keydown', function (e) {

        if (e.ctrlKey && e.key === "m") {     // when you press (ctrl + m) cursor moves to products input
            $("#product").focus();
            e.preventDefault();
        } else if (e.ctrlKey && e.key === "s") {   // when you press (ctrl + s) save the invoice
            $("#save").click();
            e.preventDefault();
        }


        if (e.key === 'F2' || e.keyCode == 113) {

            e.cancelBubble = true;
            e.cancelable = true;
            e.stopPropagation();
            e.preventDefault();
            e.returnValue = false;

            $("#cstmr_info_mdl").toggle();
            $("#customer_name").focus();

        }

    });


</script>
