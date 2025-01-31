@extends('extend_index')

@section('styles_get')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/custom-search/custom-search.css') }}">

    {{--        nabeel added css blue--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">
@stop

@section('content')

    <div class="row">
            <div id="main_bg" class="container-fluid search-filter form-group form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Trade Product Loss</h4>
                        </div>
                        <div class="list_btn">
                            <a class="add_btn list_link add_more_button" href="{{ route('trade_product_loss_list') }}"
                               role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <div id="invoice_con" class="gnrl-mrgn-pdng for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->
                        <form name="f1" class="f1" id="f1" action="{{ route('submit_trade_product_loss') }}"
                              onsubmit="return checkForm()"
                              method="post">
                            @csrf
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->
                                    <div class="invoice_row"><!-- invoice row start -->
                                        <div class="invoice_col upper form-group col-lg-10 col-md-9 col-sm-12">
                                            <div class="invoice_row">
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
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
                                                        <div class="invoice_col_input" style="height: 23px">
                                                            <!-- call add or refresh button component -->
                                                            <x-add-refresh-button href="{{ route('add_product') }}" id="refresh_product_name"/>
                                                            <div class="ps__search">
                                                                <input type="text" name="product"
                                                                    id="product"
                                                                    tabindex="1"
                                                                    class="inputs_up form-control ps__search__input"
                                                                    placeholder="Enter Product"
                                                                    onfocus="this.select();"
                                                                    {{--                                                                       onfocus=""--}}
                                                                    onkeydown="return not_plus_minus(event)"
                                                                    onfocusout="hideproducts();"/>
                                                            </div>
                                                            <span id="check_product_count" class="validate_sign"></span>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div>
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                            <a
                                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                                data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                                                config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                                                config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Voucher Remarks
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input" style="height: 23px"><!-- invoice column input start -->
                                                            <input  tabindex="2" autofocus type="text" name="remarks" class="inputs_up form-control" id="remarks"
                                                                placeholder="Remarks" onkeydown="return not_plus_minus(event)" value="{{old('remarks')}}" data-rule-required="true" data-msg-required="Please Enter Voucher Remarks">
                                                            <span id="demo7" class="validate_sign"></span>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                                    <x-posting-reference tabindex="3"/>
                                                </div>

                                                <div class="form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                                    <x-warehouse-component tabindex="4" name="warehouse" id="warehouse" class="refresh_warehouse" title="Warehouse"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3 col-sm-12" id="filters">
                                            <div class="invoice_row"><!-- invoice row start -->
                                                <div class="invoice_col basis_col_100"><!-- invoice column start -->
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
                                                        <div class="invoice_col_txt mt-0" style="line-height: 1">
                                                            <!-- invoice column input start -->
                                                            <div class="custom-checkbox float-left pb-1 ml-3">
                                                                <input type="checkbox" value="1"
                                                                        name="quick_print"
                                                                        class="custom-control-input company_info_check_box"
                                                                        id="quick_print"
                                                                        onclick="store_print_checkbox()">
                                                                <label class="custom-control-label chck_pdng"
                                                                        style="padding-top: 5px"
                                                                        for="quick_print"> Quick Print
                                                                </label>
                                                            </div>
                                                        </div><!-- invoice column input end -->
                                                        {{--Quick print start--}}
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->
                                            </div><!-- invoice row end -->
                                        </div>
                                    </div><!-- invoice row end -->
                                    <div hidden class="invoice_row"><!-- invoice row start -->
                                        <div class="invoice_col basis_col_11"><!-- invoice column start -->
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
                                                    <div class="invoice_col_short"><!-- invoice column short start -->
                                                        <a href="{{ route('add_product') }}" class="col_short_btn" target="_blank">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                        <a id="refresh_product_code" class="col_short_btn">
                                                            <i class="fa fa-refresh"></i>
                                                        </a>
                                                    </div><!-- invoice column short end -->
                                                    <select tabindex="2" name="product_code" class="inputs_up form-control" id="product_code">
                                                        <option value="0">Code</option>

                                                    </select>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_22"><!-- invoice column start -->
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

                                                    <div class="invoice_col_short"><!-- invoice column short start -->
                                                        <a href="{{ route('add_product') }}" class="col_short_btn" target="_blank">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                        <a id="refresh_product_name" class="col_short_btn">
                                                            <i class="fa fa-refresh"></i>
                                                        </a>
                                                    </div><!-- invoice column short end -->
                                                    <select tabindex="3" name="product_name" class="inputs_up form-control" id="product_name">
                                                        <option value="0">Product</option>

                                                    </select>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <!-- use remarks-component
                                     make remarks text field -->
                                        <div class="invoice_col basis_col_20"><!-- invoice column start -->
                                            <x-remarks-component tabindex="5" name="product_remarks" id="product_remarks" title="Transaction Remarks"/>
                                        </div>

                                        <div class="invoice_col basis_col_7"><!-- invoice column start -->
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
                                                    <input tabindex="6" type="text" name="quantity" class="inputs_up form-control"
                                                    {{--                                                           value="{{old('quantity')}}" --}}
                                                           id="quantity" placeholder="Qty" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_11 hidden" hidden><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                    Rate
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="text" name="rate" class="inputs_up text-right form-control" id="rate"
                                        {{--                                                           value="{{old('rate')}}"--}}
                                                           placeholder="Rate" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" readonly>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_11 hidden" hidden><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                    Amount
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="text" name="amount" class="inputs_up text-right form-control" id="amount" placeholder="Amount"  readonly>
                                                            {{--                                                    value="{{old('amount')}}"--}}
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_18"><!-- invoice column start -->
                                            <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                                <div class="invoice_col_txt with_cntr_jstfy">
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button tabindex="7" id="first_add_more" class="invoice_frm_btn" onclick="add_product()" type="button">
                                                            <i class="fa fa-plus"></i> Add
                                                        </button>
                                                    </div>
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button style="display: none;" id="cancel_button" class="invoice_frm_btn" onclick="cancel_all()" type="button">
                                                            <i class="fa fa-times"></i> Cancel
                                                        </button>
                                                    </div>
                                                    <span id="demo201" class="validate_sign"> </span>
                                                </div>
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                    </div><!-- invoice row end -->

                                    <div class="invoice_row"><!-- invoice row start -->
                                        <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                            <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                                <table class="table table-bordered table-sm" id="category_dynamic_table">
                                                    <thead>
                                                    <tr>
                                                        {{--  <th class="tbl_srl_4"> Sr.</th>  --}}
                                                        <th class="tbl_srl_7"> Code</th>
                                                        <th class="tbl_txt_7"> Title</th>
                                                        <th class="tbl_txt_7"> Remarks</th>
                                                        <th class="tbl_txt_7"> Warehouse</th>

                                                        <th hidden class="tbl_srl_6">
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
                                                        <th class="tbl_srl_4">
                                                            DB Qty
                                                        </th>
                                                        <th class="tbl_srl_4">
                                                            Pack Qty
                                                        </th>
                                                        <th class="tbl_srl_4">
                                                            Loose Qty
                                                        </th>
                                                        <th hidden class="tbl_srl_8">
                                                            Amount
                                                        </th>
                                                        <th class="tbl_srl_3">
                                                            Actions
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
                                                        <th colspan="4" class="text-right">
                                                            Total Items
                                                        </th>
                                                        <td class="tbl_srl_12">
                                                            <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                                    <input type="text" name="total_items" class="inputs_up text-right form-control total-items-field" id="total_items" placeholder="0.00" readonly data-rule-required="true" data-msg-required="Please Add"/>
                                                                </div><!-- invoice column input end -->
                                                            </div><!-- invoice column box end -->
                                                        </td>
                                                    </tr>
                                                    <tr hidden>
                                                        <th colspan="4" class="text-right">
                                                            Total Price
                                                        </th>
                                                        <td class="tbl_srl_12">
                                                            <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                                    <input type="text" name="total_price" class="inputs_up text-right form-control grand-total-field" id="total_price" placeholder="0.00" readonly />
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
                                        <div class="invoice_col col-lg-12 mt-0"><!-- invoice column start -->
                                            <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                    {{--                                                    Hamad set tab index--}}
                                                    <button tabindex="5" type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
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
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth" >
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Item Detail</h4>
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
    @if (Session::get('pl_id'))
        <script>
            jQuery("#table_body").html("");

            var id = '{{ Session::get("pl_id") }}';

            $('.modal-body').load('{{url("trade_product_loss_recover_items_view_details/view/") }}' + '/' + id, function () {
                $("#myModal").modal({show: true});


                // for print preview to not remain on screen
                if ($('#quick_print').is(":checked")) {

                    setTimeout(function () {
                        var abc = $("#printi");
                        abc.click();


                        $('.invoice_sm_mdl').css('display', 'none');
                        $('.cancel_button').click();
                        $('#product').focus();
                    }, 100);
                }


            });
        </script>
    @endif

    {{--    nabeel added search start--}}
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

    {{--    nabeel added search end--}}




    <script>

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                $("#first_add_more").click();
                // event.preventDefault();
                return false;
            }
        });



        //// warehoue ajax

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
        // adding sales into table
        var counter = 0;
        var total_discount = 0;

        function product_amount_calculation(id) {

            var display_quantity = jQuery("#display_quantity" + id).val();
            var quantity = jQuery("#quantity" + id).val();
            var unit_qty = jQuery("#unit_qty" + id).val();

            var rate = jQuery("#rate" + id).val();
            var unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + id).val();

            if(unit_qty >= parseFloat(unit_measurement_scale_size)){
                unit_qty=0;
                jQuery("#unit_qty" + id).val('');
            }

            // nabeel
            display_quantity =  Math.round(display_quantity);
            jQuery("#display_quantity" + id).val(display_quantity);

            if (quantity == "") {
                quantity = 0;
            }

            var quantity = +unit_qty + +(display_quantity * unit_measurement_scale_size)
            var gross_amount = quantity * rate;


            // alert(gross_amount);


            // jQuery("#amount" + id).val(gross_amount);
            jQuery("#amount" + id).val(gross_amount.toFixed(2));
            jQuery("#quantity" + id).val(quantity.toFixed(3));

            grand_total_calculation();
        }

        function grand_total_calculation() {


            var product_quantity;

            // var product_or_service_status;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#display_quantity" + pro_field_id).val();
                product_unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + pro_field_id).val();

                // product_or_service_status = jQuery("#product_or_service_status" + pro_field_id).val();

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
    </script>

    <script>

        function productChanged(product) {

            counter++;
            add_first_item();

            var product_code = product.pro_p_code;
            // var product_code = product.pro_p_code;
            var product_name = product.pro_title;
            var product_remarks = ""
            var unit_measurement_scale_size = product.unit_scale_size;
            var quantity = unit_measurement_scale_size * 1;
            var pack_qty = Math.floor(quantity / unit_measurement_scale_size);//mustafa
            var unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);

            var unit_measurement = product.unit_title;
            var main_unit = product.mu_title;



            // var quantity = 1;
            var rate = product.pro_sale_price;
            var amount = 0;


            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            // var rate_per_pack = rate * unit_measurement_scale_size;



            // $('input[name="pro_code[]"]').each(function (pro_index) {
            //     pro_code = $(this).val();
            //
            //     pro_field_id_title = $(this).attr('id');
            //     pro_field_id = pro_field_id_title.match(/\d+/); // 123456
            //     // alert(pro_field_id);
            //
            //     if (pro_code == product_name) {
            //         quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
            //         // rate = jQuery("#rate" + pro_field_id).val();
            //         var abc = jQuery("#quantity" + pro_field_id).val();
            //
            //         delete_sale(pro_field_id);
            //     }
            // });
            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                if (pro_code == product_code) {
                    quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                    pack_qty = Math.floor(quantity / unit_measurement_scale_size);//mustafa
                    unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);

                    // quantity = +jQuery("#display_quantity" + pro_field_id).val() + +quantity;

                    delete_sale(pro_field_id);
                }
            });


            var amount = quantity * rate;


            // var code = product.pro_p_code;
            // var parent_code = product.pro_p_code;
            // var name = product.pro_title;

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




            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete products[global_id_to_edit];
                }


                // add_sale(product_code, product_name, rate, amount, counter, quantity);



                // alert(unit_measurement_scale_size);

                add_sale(product_code, product_name, quantity, rate, amount,"", counter, unit_measurement, unit_measurement_scale_size, main_unit, pack_qty, unit_qty);
                product_amount_calculation(counter);


            }
        }

        function add_sale(code, name, quantity, rate, gross_amount, remarks, counter,
                          unit_measurement, unit_measurement_scale_size, main_unit_measurement, pack_qty, unit_qty) {


            jQuery("#table_body").append('<tr class="edit_update" id="table_row' + counter + '">' +
                // '<td class="tbl_srl_4">02</td> ' +
                '<td class="tbl_srl_7">' +
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


                '<td hidden class="text-right tbl_srl_6"> ' +
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



                '<td class="tbl_srl_4">' +
                '<input type="text" name="quantity[]" id="quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                quantity + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +   /* Changed By Abdullah: old -> return
                allowOnlyNumber(event); */
                '</td>' +


                // prob satart
                '<td class="tbl_srl_4">' +
                '<input type="text" name="display_quantity[]" id="display_quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                pack_qty + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +   /* Changed By Abdullah: old -> return
                  allowOnlyNumber(event); */
                '</td>' +

                '<td class="tbl_srl_4">' +
                '<input type="hidden" hidden name="unit_measurement_scale_size[]" class="inputs_up_tbl" id="unit_measurement_scale_size' + counter + '" placeholder="Scale Size" value="' + unit_measurement_scale_size + '" readonly/>' +
                '<input type="text"  name="unit_qty[]" id="unit_qty' + counter + '" ' + ' placeholder="0" class="inputs_up_tbl percentage_textbox" onkeyup="product_amount_calculation(' + counter + ')"'+
                '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" value="'+ unit_qty+'"/> ' +
                '</td>' +
                // prob end


                '<td hidden class="text-right tbl_srl_8"> ' +
                '<input type="text" name="amount[]" id="amount' + counter + '" placeholder="Amount" class="inputs_up_tbl text-right" value="' + gross_amount + '" readonly/> ' +
                '</td>' +


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
            // $("#product").keypress();
            // $("#product").keydown();
            // $("#product").keyup();

            duplicate_warehouse_dropdown(counter);


            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);


            grand_total_calculation();
            // check_invoice_type();
        }



        // function add_sale(product_code, product_name, rate, amount, counter, quantity){
        //
        //
        //     var warehouse = jQuery("#warehouse").val();
        //     var warehouse_name = jQuery("#warehouse option:selected").text();
        //
        //     numberofproducts = Object.keys(products).length;
        //
        //     if (numberofproducts == 0) {
        //         jQuery("#table_body").html("");
        //     }
        //
        //
        //     products[counter] = {
        //         'warehouse': warehouse,
        //         'warehouse_name': warehouse_name,
        //         'product_code': product_code,
        //         'product_name': product_name,
        //         'product_qty': quantity,
        //         // 'product_bonus_qty': 0,
        //         'product_rate': rate,
        //         // 'product_inclusive_rate': selected_rate,
        //         'product_amount': amount,
        //         'product_remarks': ""
        //     };
        //
        //
        //     numberofproducts = Object.keys(products).length;
        //
        //
        //     jQuery("#table_body").append(
        //         '<tr id="table_row' + counter + '" class="edit_update"><td class="tbl_srl_9">' + product_code + '</td>' +
        //         '<input type="hidden" name="pro_code[]" id="pro_code' + counter + '" placeholder="Code" ' + 'class="inputs_up_tbl" value="' + product_name + '" readonly/>' +
        //         product_name + '</td> ' +
        //         '<td class="text-left tbl_txt_20">' + product_name + '</td>' +
        //         '<td class="text-left tbl_srl_20">' + warehouse_name + '</td>' +
        //         '<td class="text-left tbl_txt_44">' + "" + '</td>' +
        //         '<td>' + rate + '</td>' +
        //         '<td class="text-right">' + amount + '</td>' +
        //
        //         '</td> ' +
        //         '<td class="text-right tbl_srl_9"> ' +
        //         '<input type="text" name="quantity[]" tabindex="-1" id="quantity' + counter + '" placeholder="quantity" class="lower_inputs inputs_up_tbl text-right" value="' + quantity + '" readonly/> ' +
        //         '</td> ' +
        //
        //         '<td class="text-right tbl_srl_6">' + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_product(' + counter + ')><i class="fa fa-edit"></i></a> <a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_product(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');
        //
        //
        //
        //
        //     jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
        //     jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
        //     jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);
        //
        //     jQuery("#quantity").val("");
        //     jQuery("#product_remarks").val("");
        //     jQuery("#rate").val("");
        //     jQuery("#amount").val("");
        //
        //     jQuery("#products_array").val(JSON.stringify(products));
        //     jQuery("#cancel_button").hide();
        //     jQuery(".table-responsive").show();
        //     jQuery("#save").show();
        //     jQuery("#first_add_more").html('<i class="fa fa-plus"></i>  Add');
        //
        //     jQuery("#total_items").val(numberofproducts);
        //
        //     jQuery("#product_code").select2();
        //     jQuery("#product_name").select2();
        //     jQuery("#warehouse").select2();
        //
        //     grand_total_calculation();
        //
        //     jQuery(".edit_link").show();
        //     jQuery(".delete_link").show();
        //
        // }

        function add_first_item() {
            var total_items = $('input[name="pro_code[]"]').length;

            if (total_items <= 0 || total_items == '') {
                jQuery("#table_body").html("");
            }
        }

        // nabeel added use display_quantity start
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
        // nabeel added use display_quantity end

        function delete_sale(current_item) {

            jQuery("#table_row" + current_item).remove();

            grand_total_calculation();
            // check_invoice_type();
        }



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


            $("#product").focus();

        });
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



    //  ##########   nabeel ahmed scripts    ############


    // nabeel added simple scripts start

    // function focus_stay_on_product(evt){
    //     if (evt.keyCode == 9) {  //means
    //         // alert("Tab pressed");
    //         if ($("#product")[0] == $(document.activeElement)[0]) {
    //             evt.preventDefault();
    //         }
    //     }
    // }


    function gotoproduct(event){
        alert(event);
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


    // nabeel added simple scripts end


    // // nabeel added focus scripts start
    // function focus_stay_on_product(evt){
    //     alert("called");
    //     if (evt.keyCode == 9) {  //means
    //         // alert("Tab pressed");
    //         // for upper inputs tab functionality
    //
    //
    //
    //         // if ($("#product")[0] == $(document.activeElement)[0]) {
    //             evt.preventDefault();
    //         // }
    //     }
    // }


    document.addEventListener('keydown', function (event) {
        if (event.keyCode === 9) {     // means tab
            if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#warehouse")[0]) {
                $("#product").focus();
            } else if ($("#product")[0] == $(document.activeElement)[0]) {
                $("#remarks").focus();
            } else if ($("#remarks")[0] == $(document.activeElement)[0]) {
                $("#posting_reference").focus();
            }else if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#posting_reference")[0]) {
                $("#warehouse").focus();
            }
            event.preventDefault();
        }

    });

        document.addEventListener('keyup', function (event) {


        // to close dropdown search
        if (event.keyCode === 106) {     // means staric(*)
            if ($(".select2-container--open")[0].previousElementSibling == $("#warehouse")[0]) {

                $('#warehouse').select2({
                    selectOnClose: true
                });
                $('#warehouse').focus();

            }
        }

        // if (event.keyCode === 9) {     // means staric(*)
        //     if ($(".select2-container--open")[0].previousElementSibling == $("#warehouse")[0]) {
        //
        //         alert("ok");
        //         $("#product").focus();
        //
        //     }
        // }




        if (event.keyCode === 107) {     // means plus(+)

            // for upper inputs tab functionality
            if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#warehouse")[0]) {
                $("#product").focus();
            } else if ($("#product")[0] == $(document.activeElement)[0]) {
                $("#remarks").focus();
            } else if ($("#remarks")[0] == $(document.activeElement)[0]) {
                $("#warehouse").focus();
            }
            event.preventDefault();
        }




        if (event.keyCode === 109) {   //means minus(-)


            // for upper inputs tab functionality
            if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#warehouse")[0]) {
                $("#remarks").focus();
            } else if ($("#product")[0] == $(document.activeElement)[0]) {
                $("#warehouse").focus();
            } else if ($("#remarks")[0] == $(document.activeElement)[0]) {
                $("#product").focus();
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


