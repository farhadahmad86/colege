@extends('extend_index')
@section('styles_get')
    {{--    nabeel css blue--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">
@stop
@section('content')
    <div class="row">
        <div id="main_bg" class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Trade Delivery Challan</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <a class="add_btn list_link add_more_button" href="{{ route('trade_delivery_challan_list') }}" role="button">
                            <i class="fa fa-list"></i> Delivery Challan List
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div id="invoice_con" class="gnrl-mrgn-pdng"><!-- invoice container start -->
                <div id="invoice_bx" class="invoice_bx"><!-- invoice box start -->
                    <form name="f1" class="f1" id="f1" action="{{ route('submit_trade_delivery_challan') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                        @csrf
                        <div class="invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="invoice_cntnt"><!-- invoice content start -->
                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <x-party-name-component tabindex="1" name="account_name" id="account_name" class="sale"/>
{{--                                        <div class="invoice_col_bx"><!-- invoice column box start -->--}}
{{--                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->--}}
{{--                                                Party--}}
{{--                                            </div><!-- invoice column title end -->--}}
{{--                                            <div class="invoice_col_input"><!-- invoice column input start -->--}}
{{--                                                <div class="invoice_col_short">--}}
{{--                                                    <!-- invoice column short start -->--}}
{{--                                                    <a href="{{ url('receivables_account_registration') }}"--}}
{{--                                                        class="col_short_btn" target="_blank">--}}
{{--                                                        <l class="fa fa-plus"></l>--}}
{{--                                                    </a>--}}
{{--                                                    <a id="refresh_account_name" class="col_short_btn">--}}
{{--                                                        <l class="fa fa-refresh"></l>--}}
{{--                                                    </a>--}}
{{--                                                </div><!-- invoice column short end -->--}}
{{--                                                <select tabindex="1" name="account_name" class="inputs_up form-control js-example-basic-multiple"--}}
{{--                                                        data-rule-required="true" data-msg-required="Please Enter Party"--}}
{{--                                                        id="account_name" onchange="myFunction();">--}}
{{--                                                    <option value="0">Select Party</option>--}}
{{--                                                    @foreach($accounts as $account)--}}
{{--                                                        <option value="{{$account->account_uid}}">{{$account->account_name}}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div><!-- invoice column input end -->--}}
{{--                                        </div><!-- invoice column box end -->--}}
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <x-party-reference-component tabindex="2" name="customer_name" id="customer_name"/>
                                    </div>
                                    <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <x-posting-reference tabindex="3"/>
                                    </div>
                                    <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <x-remarks-component tabindex="4" name="remarks" id="remarks" title="Remarks"/>
                                    </div>
                                    <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
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


                                                {{--Hamad set tab index--}}
                                                <input type="text" tabindex="5"
                                                        onkeydown="return not_plus_minus(event)"
                                                        name="invoice_nbr_chk" class="inputs_up form-control" id="invoice_nbr_chk" placeholder="Check Invoice Number">


                                                <!-- changed added start (search btn) -->
                                                <div class="invoice_col_short">
                                                    <!-- invoice column short start -->

                                                    <a id="check_return_invoice" class="col_short_btn"
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

                                    <div class="invoice_col form-group col-lg-2 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.description')}}</p>
                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.benefits')}}</p>
                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Invoice Type
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_txt"><!-- invoice column input start -->
                                                <div class="invoice_row"><!-- invoice row start -->
                                                    <div class="radio ml-3">
                                                    <label>
                                                        <input type="radio" name="invoice_type" class="invoice_type" id="invoice_type1" value="1" checked>
                                                        Non Tax Invoice
                                                    </label>
                                                </div>
                                                <div class="radio ml-3">
                                                    <label>
                                                        <input type="radio" name="invoice_type" class="invoice_type" id="invoice_type2" value="2">
                                                        Tax Invoice
                                                    </label>
                                                </div>
                                                <div class="radio ml-3">
                                                    <label>
                                                        <input type="radio" name="invoice_type" class="invoice_type" id="invoice_type3" value="3">
                                                        Delivery Order
                                                    </label>
                                                </div>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                </div><!-- invoice row end -->
                                <div class="invoice_row" hidden><!-- invoice row start -->
                                    <div class="invoice_col basis_col_14"><!-- invoice column start -->
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
                                                    <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover"
                                                        data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_product_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                        data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </div><!-- invoice column short end -->
                                                <select tabindex="4" name="product_code" class="inputs_up form-control" id="product_code">
                                                    <option value="0">Code</option>
                                                    {{--                                                        <option value="0">568741759</option>--}}
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col basis_col_33"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
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
                                                    <a href="{{ route('add_product') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover"
                                                        data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_product_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                        data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </div><!-- invoice column short end -->
                                                <select tabindex="5" name="product_name" class="inputs_up form-control" id="product_name">
                                                    <option value="0">Product</option>
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col basis_col_25_2"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.description')}}</p>
                                                    <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.benefits')}}</p>
                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Packages
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                    <a href="{{ url('product_packages') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover"
                                                        data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a id="refresh_package" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                        data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </div><!-- invoice column short end -->
                                                <select tabindex="6" name="package" class="inputs_up form-control js-example-basic-multiple" id="package">
                                                    <option value="0">Select Package</option>
                                                    @foreach($packages as $package)
                                                        <option value="{{$package->pp_id}}">
                                                            {{$package->pp_name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                    <div class="invoice_col basis_col_25_5"><!-- invoice column start -->
                                        <x-warehouse-component tabindex="7" name="warehouse" id="warehouse" class="refresh_warehouse" title="Warehouse"/>
                                    </div>
                                </div><!-- invoice row end -->
                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                        <div class="invoice_row"><!-- invoice row start -->
                                        {{--search--}}
                                            <div hidden class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                                <div class="invoice_col_bx for_tabs"><!-- invoice column box start -->
                                                    <div class="invoice_col_txt for_invoice_nbr"><!-- invoice column input start -->
                                                        <div class="invoice_inline_input_txt"><!-- invoice inline input text start -->
                                                            <div class="invoice_col_txt for_inline_input_checkbox"><!-- invoice column input start -->
                                                                <div class="custom-checkbox float-left">
                                                                    <input type="checkbox" value="1" name="desktop_invoice_id" class="custom-control-input company_info_check_box"
                                                                            id="desktop_invoice_id">
                                                                    <label class="custom-control-label chck_pdng" for="desktop_invoice_id"> For Desktop </label>
                                                                </div>
                                                            </div><!-- invoice column input end -->
                                                            <div class="invoice_col_input">
                                                                <input type="text" name="invoice_nbr_chk" class="inputs_up form-control" id="invoice_nbr_chk" placeholder="Check Invoice Number">
                                                            </div>
                                                            <div class="inline_input_txt_lbl" for="service_total_inclusive_tax">
                                                                <input type="button" class="invoice_chk_btn" value="check" id="check_return_invoice"/>
                                                            </div>
                                                        </div><!-- invoice inline input text end -->
                                                    </div><!-- invoice column input end -->

                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                            <div class="pro_tbl_con basis_col_100"><!-- product table container start -->
                                                <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                                    <table class="table table-bordered table-sm" id="category_dynamic_table">
                                                        <thead>
                                                        <tr>
                                                            {{--  <th class="tbl_srl_4"> Sr.</th>  --}}
                                                            <th class="tbl_srl_9"> Code</th>
                                                            <th class="tbl_txt_13"> Title</th>
                                                            <th class="tbl_txt_9"> Remarks</th>
                                                            <th class="tbl_txt_10"> Warehouse</th>
                                                            <th class="tbl_srl_4">UOM</th>
                                                            <th class="tbl_srl_4">Pack Detail</th>
                                                            <th class="tbl_srl_4">Pack Size</th>
                                                            <th class="tbl_srl_4" hidden>DB Qty</th>
                                                            <th class="tbl_srl_4">Pack Qty</th>
                                                            <th class="tbl_srl_4">Loose Qty</th>
                                                            <th class="tbl_srl_5">Bonus</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="table_body">
                                                        </tbody>
                                                    </table>
                                                </div><!-- product table box end -->
                                            </div><!-- product table container end -->
                                        </div><!-- invoice row end -->
                                    </div><!-- invoice column end -->
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

                                                <div class="invoice_inline_input_txt mb-0"><!-- invoice inline input text start -->
                                                    <label class="inline_input_txt_lbl" for="total_items">
                                                        Total Items
                                                    </label>
                                                    <div class="invoice_col_input">
                                                        <input type="text" name="total_items" class="inputs_up form-control text-right total-items-field lower_inputs lower_style"
                                                                data-rule-required="true" data-msg-required="Add Item"
                                                                id="total_items" readonly>

                                                    </div>
                                                </div><!-- invoice inline input text end -->

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                </div><!-- invoice row end -->
                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                        <div class="invoice_col_txt with_cntr_jstfy"><!-- invoice column box start -->
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button id="clear_discount_btn" type="button" class="invoice_frm_btn">
                                                    Clear Discount
                                                </button>
                                            </div>
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button tabindex="8" type="submit" class="invoice_frm_btn" name="save" id="save">
                                                    Save (Ctrl+S)
                                                </button>
                                                <span id="check_product_count" class="validate_sign"></span>
                                            </div>
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button tabindex="9" id="all_clear_form" type="button" class="invoice_frm_btn">
                                                    Clear (Ctrl+X)
                                                </button>
                                            </div>
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                </div><!-- invoice row end -->
                            </div><!-- invoice content end -->
                        </div><!-- invoice scroll box end -->
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
                    <h4 class="modal-title text-black">Delivery Challan Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="table_body"></div>
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
    {{--    <script type="text/javascript">--}}
    {{--        function checkForm() {--}}
    {{--            let account_name = document.getElementById("account_name"),--}}
    {{--                total_items = document.getElementById("total_items"),--}}
    {{--                total_price = document.getElementById("total_price"),--}}
    {{--                validateInputIdArray = [--}}
    {{--                    account_name.id,--}}
    {{--                    total_items.id,--}}
    {{--                    total_price.id,--}}
    {{--                ];--}}
    {{--            return validateInventoryInputs(validateInputIdArray);--}}
    {{--        }--}}
    {{--    </script>--}}
    {{-- end of required input validation --}}
    <script>
        // Get the input field
        var input = document.getElementById("invoice_nbr_chk");

        // Execute a function when the user releases a key on the keyboard
        input.addEventListener("keyup", function (event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                document.getElementById("check_return_invoice").click();
            }
        });
    </script>
    {{--show print invoice after save invoice start--}}

    @if (Session::get('dci_id'))
        <script>


            jQuery("#table_body").html("");

            var id = '{{ Session::get("dci_id") }}';

            $('.modal-body').load('{{url("delivery_challan_items_view_details/view/")}}' + '/' + id, function () {
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
                    }, 100);
                }


            })
            ;
        </script>
    @endif

    {{--show print invoice after save invoice end--}}
    <script>
        function myFunction() {
            var str = document.getElementById("account_name").value;
            var n = str.includes("11016");
            if (n == true) {
                $(".payment_div").css('display', 'block');
            } else {
                $("#cash_paid").val('');
                $("#cash_return").val('');
                $(".payment_div").css('display', 'none');
            }
        }
    </script>

    <script>




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

        jQuery("#refresh_machine").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_credit_card_machine",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#machine").html(" ");
                    jQuery("#machine").append(data);
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
        function popvalidation() {
            isDirty = true;

            var account_name = $("#account_name").val();
            var total_items = $("#total_items").val();

            var grand_total = $("#grand_total").val();

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

                quantity = +jQuery("#quantity" + pro_field_id).val();
                rate = jQuery("#rate" + pro_field_id).val();

                if (quantity <= 0 || quantity == "") {
                    if (focus_once == 0) {
                        jQuery("#quantity" + pro_field_id).focus();
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

    {{--//////////////////////////////////////////////////////////////////// Start Sale Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}
    <script>
        // adding sales into table
        var counter = 0;
        var total_discount = 0;

        function unit_rate_changed_live(id) {
            var unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + id).val();
            var unit_rate_piece = (jQuery("#rate_per_piece" + id).val() !== 0 || jQuery("#rate_per_piece" + id).val() !== "NaN" || jQuery("#rate_per_piece" + id).val() !== "") ? jQuery("#rate_per_piece" + id).val() : 1;
            var rate = parseFloat(unit_measurement_scale_size) * unit_rate_piece;

            if (rate > 0) {
                jQuery("#rate" + id).val(rate.toFixed(2));
            }
            var newRate = (rate === "" || rate === 0) ? 1 : rate;

            product_amount_calculation(id, newRate);

        }

        function product_amount_calculation(id, newRate = 0) {

            var quantity = jQuery("#quantity" + id).val();
            var unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + id).val();
            // var rate = (newRate === 0 || newRate === "") ? jQuery("#rate" + id).val() : newRate;
            // var product_discount = jQuery("#product_discount" + id).val();
            // var product_sales_tax = jQuery("#product_sales_tax" + id).val();
            // var rate_per_piece = 0;

            // if (newRate === 0 || newRate === "") {
            //     rate_per_piece = rate / unit_measurement_scale_size;
            // }
            // var gross_amount = quantity * rate;


            if (quantity == "") {
                quantity = 0;
            }

            // var product_sale_tax_amount;
            // var product_rate_after_discount;
            // var product_inclusive_rate;
            // var product_discount_amount;

            // if ($("#inclusive_exclusive" + id).prop("checked") == true) {
            //     jQuery("#inclusive_exclusive_status_value" + id).val(1);
            //
            //     product_discount_amount = (((rate / (+product_sales_tax + +100) * 100)) * product_discount / 100) * quantity;
            //
            //     product_rate_after_discount = rate - (product_discount_amount / quantity);
            //
            //     product_inclusive_rate = ((rate / (+product_sales_tax + +100)) * 100) - ((rate / (+product_sales_tax + +100)) * 100) * product_discount / 100;
            //
            //     product_sale_tax_amount = (rate - ((rate / (+product_sales_tax + +100)) * 100)) * quantity;
            //
            // } else {
            //     jQuery("#inclusive_exclusive_status_value" + id).val(0);
            //
            //     product_discount_amount = (rate * product_discount / 100) * quantity;
            //
            //     // product_rate_after_discount = rate - (product_discount_amount / quantity);
            //
            //     if (quantity == '' || quantity == 0) {
            //         product_rate_after_discount = 0;
            //     } else {
            //         product_rate_after_discount = rate - (product_discount_amount / quantity);
            //     }
            //
            //     product_inclusive_rate = product_rate_after_discount;
            //
            //     product_sale_tax_amount = (product_rate_after_discount * product_sales_tax / 100) * quantity;
            // }

            // var amount = (quantity * product_inclusive_rate) + product_sale_tax_amount;

            // jQuery("#amount" + id).val(amount.toFixed(2));
            // jQuery("#product_sale_tax_amount" + id).val(product_sale_tax_amount.toFixed(2));
            // jQuery("#product_inclusive_rate" + id).val(product_inclusive_rate.toFixed(2));
            // jQuery("#product_discount_amount" + id).val(product_discount_amount.toFixed(2));

            // if (newRate === 0 || newRate === "") {
            //     jQuery("#rate_per_piece" + id).val(rate_per_piece.toFixed(2));
            // }
            // jQuery("#gross_amount" + id).val(gross_amount.toFixed(2));

            // grand_total_calculation();

        }

        function checkQty(id) {
            var quantity = jQuery("#quantity" + id).val();
            var scale_size = jQuery("#unit_measurement_scale_size" + id).val();;
            if (quantity < 1) {
                if(scale_size > 1){
                    jQuery("#unit_qty" + id).val(1);
                }else{
                    jQuery("#display_quantity" + id).val(1);
                }

                product_amount_calculation(id);
            }

        }

        function grand_total_calculation() {

            var disc_percentage = jQuery("#disc_percentage").val();

            var total_price = 0;
            var total_product_discount = 0;
            var total_inclusive_sale_tax_amount = 0;
            var total_exclusive_sale_tax_amount = 0;
            var total_sale_tax_amount = 0;
            var grand_total = 0;
            var round_off_discount = 0;
            var disc_percentage_amount = 0;


            var product_quantity;
            var product_rate;
            var product_discount_amount = 0;
            var product_sale_tax_amount = 0;
            var product_amount = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#quantity" + pro_field_id).val();
                product_unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + pro_field_id).val();
                product_rate = jQuery("#rate" + pro_field_id).val();
                product_discount_amount = jQuery("#product_discount_amount" + pro_field_id).val();
                product_sale_tax_amount = jQuery("#product_sale_tax_amount" + pro_field_id).val();
                product_amount = jQuery("#amount" + pro_field_id).val();

                total_price = +total_price + +(parseFloat(product_rate) * parseFloat(product_quantity));
                total_product_discount = +total_product_discount + +product_discount_amount;

                if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                    total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                } else {
                    total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                }

                total_sale_tax_amount = +total_sale_tax_amount + +product_sale_tax_amount;

                grand_total = +grand_total + +product_amount;
            });

            disc_percentage_amount = (total_price * disc_percentage) / 100;

            total_discount = +total_product_discount + +disc_percentage_amount;

            grand_total = +(total_price - total_discount) + +total_exclusive_sale_tax_amount;

            var radioValue = $("input[name='round_off']:checked").val();

            if (radioValue == 1) {
                round_off_discount = grand_total - Math.round(grand_total);
            }

            total_discount = +total_discount + +round_off_discount;

            grand_total = grand_total - round_off_discount;

            jQuery("#total_price").val(total_price.toFixed(2));
            jQuery("#total_product_discount").val(total_product_discount.toFixed(2));
            jQuery("#round_off_discount").val(round_off_discount.toFixed(2));
            jQuery("#disc_amount").val(disc_percentage_amount.toFixed(2));
            jQuery("#total_discount").val(total_discount.toFixed(2));
            jQuery("#total_inclusive_tax").val(total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_exclusive_tax").val(total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_tax").val(total_sale_tax_amount.toFixed(2));
            jQuery("#grand_total").val(grand_total.toFixed(2));

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
            $("#grand_total_text").text(Number(grand_total.toFixed(2)).toLocaleString('en'));

            cash_return_calculation();
        }

        function grand_total_calculation_with_disc_amount() {

            var disc_percentage = 0;
            var disc_amount = jQuery("#disc_amount").val();

            var total_price = 0;
            var total_product_discount = 0;
            var total_inclusive_sale_tax_amount = 0;
            var total_exclusive_sale_tax_amount = 0;
            var total_sale_tax_amount = 0;
            var grand_total = 0;
            var round_off_discount = 0;
            var disc_percentage_amount = disc_amount;


            var product_quantity;
            var product_rate;
            var product_discount_amount = 0;
            var product_sale_tax_amount = 0;
            var product_amount = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#quantity" + pro_field_id).val();
                product_unit_measurement_scale_size = jQuery("#unit_measurement_scale_size" + pro_field_id).val();
                product_rate = jQuery("#rate" + pro_field_id).val();
                product_discount_amount = jQuery("#product_discount_amount" + pro_field_id).val();
                product_sale_tax_amount = jQuery("#product_sale_tax_amount" + pro_field_id).val();
                product_amount = jQuery("#amount" + pro_field_id).val();

                total_price = +total_price + +(product_rate * parseFloat(product_quantity));
                total_product_discount = +total_product_discount + +product_discount_amount;

                if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                    total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                } else {
                    total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                }

                total_sale_tax_amount = +total_sale_tax_amount + +product_sale_tax_amount;

                grand_total = +grand_total + +product_amount;
            });


            if (total_price != 0) {
                disc_percentage = (disc_amount * 100) / total_price;
            } else {
                disc_percentage = 0;
            }

            // disc_percentage = (disc_amount * 100) / total_price;

            total_discount = +total_product_discount + +disc_percentage_amount;

            grand_total = +(total_price - total_discount) + +total_exclusive_sale_tax_amount;

            var radioValue = $("input[name='round_off']:checked").val();

            if (radioValue == 1) {
                round_off_discount = grand_total - Math.round(grand_total);
            }

            total_discount = +total_discount + +round_off_discount;

            grand_total = grand_total - round_off_discount;

            jQuery("#total_price").val(total_price.toFixed(2));
            jQuery("#total_product_discount").val(total_product_discount.toFixed(2));
            jQuery("#round_off_discount").val(round_off_discount.toFixed(2));
            jQuery("#disc_percentage").val(disc_percentage.toFixed(2));
            jQuery("#total_discount").val(total_discount.toFixed(2));
            jQuery("#total_inclusive_tax").val(total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_exclusive_tax").val(total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_tax").val(total_sale_tax_amount.toFixed(2));
            jQuery("#grand_total").val(grand_total.toFixed(2));

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
            $("#grand_total_text").text(Number(grand_total.toFixed(2)).toLocaleString('en'));

            cash_return_calculation();
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
            var unit_measurement_scale_size = $('option:selected', this).attr('data-unit_scale_size');
            var bonus_qty = '';
            var rate = $('option:selected', this).attr('data-sale_price');
            var inclusive_rate = 0;
            var discount = 0;
            var discount_amount = 0;
            var sales_tax = $('option:selected', this).attr('data-tax');
            var sale_tax_amount = 0;
            var amount = 0;
            var remarks = '';
            var rate_after_discount = 0;
            var inclusive_exclusive = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            var rate_per_piece = rate / unit_measurement_scale_size;
            var gross_amount = quantity * rate;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                if (pro_code == parent_code) {
                    quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
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

            add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 0, 0, unit_measurement, unit_measurement_scale_size, rate_per_piece, gross_amount);

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
            var unit_measurement_scale_size = $('option:selected', this).attr('data-unit_scale_size');
            var bonus_qty = '';
            var rate = $('option:selected', this).attr('data-sale_price');
            var inclusive_rate = 0;
            var discount = 0;
            var discount_amount = 0;
            var sales_tax = $('option:selected', this).attr('data-tax');
            var sale_tax_amount = 0;
            var amount = 0;
            var remarks = '';
            var rate_after_discount = 0;
            var inclusive_exclusive = 0;

            var rate_per_piece = rate / unit_measurement_scale_size;
            var gross_amount = quantity * rate;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;
            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                if (pro_code == parent_code) {
                    quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
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

            add_sale(parent_code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 0, 0, unit_measurement, unit_measurement_scale_size, rate_per_piece, gross_amount);

            product_amount_calculation(counter);
        });

        jQuery('.discount_type').change(function () {

            if ($(this).is(':checked')) {
                add_first_item();

                var discount = 0;

                var pro_code;
                var pro_field_id_title;
                var pro_field_id;

                $('input[name="pro_code[]"]').each(function (pro_index) {

                    pro_code = $(this).val();
                    pro_field_id_title = $(this).attr('id');
                    pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                    jQuery('#product_code option[value="' + pro_code + '"]').prop('selected', true);

                    if ($(".discount_type").is(':checked')) {
                        if ($(".discount_type:checked").val() == 1) {
                            discount = 0;
                        } else if ($(".discount_type:checked").val() == 2) {
                            discount = jQuery('#product_code option:selected').attr('data-retailer_dis');
                        } else if ($(".discount_type:checked").val() == 3) {
                            discount = jQuery('#product_code option:selected').attr('data-whole_saler_dis');
                        } else if ($(".discount_type:checked").val() == 4) {
                            discount = jQuery('#product_code option:selected').attr('data-loyalty_dis');
                        }
                    }

                    jQuery("#product_discount" + pro_field_id).val(discount);
                    product_amount_calculation(pro_field_id);
                });
                jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            }
        });

        jQuery("#clear_discount_btn").click(function () {
            var discount = 0;
            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                jQuery('#product_code option[value="' + pro_code + '"]').prop('selected', true);

                jQuery("#product_discount" + pro_field_id).val(discount);
                product_amount_calculation(pro_field_id);
            });
            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
        });

        jQuery("#all_clear_form").click(function () {
            jQuery("#table_body").html("");
            grand_total_calculation();
        });

        function add_first_item() {
            var total_items = $('input[name="pro_code[]"]').length;

            if (total_items <= 0 || total_items == '') {
                jQuery("#table_body").html("");
            }
        }

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

                        add_first_item();

                        var parent_code = value['ppi_product_code'];
                        jQuery('#product_name option[value="' + parent_code + '"]').prop('selected', true);
                        var name = $("#product_name option:selected").text();
                        var quantity = value['ppi_qty'];
                        var unit_measurement = $("#product_name option:selected").attr('data-unit');
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

                        $('input[name="pro_code[]"]').each(function (pro_index) {
                            pro_code = $(this).val();
                            pro_field_id_title = $(this).attr('id');
                            pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                            if (pro_code == parent_code) {
                                quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
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
                            inclusive_exclusive, counter, 0, 0, unit_measurement);

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

        // code, name, quantity, bonus_qty, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
        //     counter, product_or_service_status, select_return_warehouse, unit_measurement, unit_measurement_scale_size, rate_per_piece, gross_amount
        function add_sale(code, name, quantity, bonus_qty, remarks, counter, product_or_service_status, select_return_warehouse, unit_measurement, unit_measurement_scale_size, pack_qty, unit_qty, main_unit_measurement) {

            // var inclusive_exclusive_status = '';
            var bonus_qty_status = '';
            // if (inclusive_exclusive == 1) {
            //     inclusive_exclusive_status = 'checked';
            // }

            if (product_or_service_status == 1) {
                bonus_qty_status = 'readonly';
            }
            console.log(code, name);
            jQuery("#table_body").append('<tr class="edit_update" id="table_row' + counter + '">' +
                // '<td class="tbl_srl_4">02</td> ' +
                '<td class="tbl_srl_9">' +
                '<input type="hidden" name="product_or_service_status[]" id="product_or_service_status' + counter + '" placeholder="Status" ' + 'class="inputs_up_tbl" value="' +
                product_or_service_status + '" readonly/>' +
                '<input type="text" name="pro_code[]" id="pro_code' + counter + '" placeholder="Code" ' + 'class="inputs_up_tbl" value="' + code + '" readonly/>' +
                '</td> ' +

                '<td class="text-left tbl_txt_13">' +
                '<input type="text" name="pro_name[]" id="pro_name' + counter + '" placeholder="Name" ' + 'class="inputs_up_tbl" value="' + name + '" readonly/>' +
                '</td> ' +

                '<td class="text-left tbl_txt_9">' +
                '<input type="text" name="product_remarks[]" id="product_remarks' + counter + '" placeholder="Remarks" ' + 'class="inputs_up_tbl" value="' + remarks + '"/>' +
                '</td>' +

                '<td class="text-left tbl_txt_10" readonly id="warehouse_div_col' + counter + '">' +
                '</td>' +

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
                quantity + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" readonly/>' +
                '</td>' +

                // prob satart
                '<td class="tbl_srl_4">' +
                '<input type="text" name="display_quantity[]" id="display_quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                pack_qty + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" onfocusout="checkQty(' + counter + ')" readonly/>' +   /* Changed By Abdullah: old -> return
                  allowOnlyNumber(event); */
                '</td>' +

                '<td class="tbl_srl_4">' +
                '<input type="hidden" hidden name="unit_measurement_scale_size[]" class="inputs_up_tbl" id="unit_measurement_scale_size' + counter + '" placeholder="Scale Size" value="' + unit_measurement_scale_size + '" readonly/>' +
                '<input type="text"  name="unit_qty[]" id="unit_qty' + counter + '" ' + ' placeholder="0" class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')"'+
                '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" value="' +
                unit_qty + '" onfocusout="checkQty(' + counter + ')" readonly/> ' +
                '</td>' +
                // prob end

                // '<td class="text-right tbl_srl_6"> ' +
                // '<input type="text" name="rate[]" id="rate' + counter + '" ' + 'placeholder="Rate" class="inputs_up_tbl text-right" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                // rate + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                // '<input type="hidden" name="product_inclusive_rate[]" class="inputs_up ' + 'text-right form-control" id="product_inclusive_rate' + counter + '"  value="' + inclusive_rate + '"> ' +
                // '</td> ' +

                // '<td class="tbl_srl_4">' +
                // '<input type="text" name="unit_measurement_scale_size[]" class="inputs_up_tbl" id="unit_measurement_scale_size' + counter + '" placeholder="Scale Size" value="' + unit_measurement_scale_size + '" readonly/>' +
                // '</td>' +



                // '<td class="tbl_srl_4">' +
                // '<input type="text" name="rate_per_piece[]" onkeyup="unit_rate_changed_live(' + counter + ')" class="inputs_up_tbl" id="rate_per_piece' + counter + '" placeholder="Rate Per Price" value="' + rate_per_piece + '" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                // '</td>' +
                // '<td class="tbl_srl_9">' +
                // '<input type="text" name="gross_amount[]" class="inputs_up_tbl text-right" id="gross_amount' + counter + '" placeholder="Scale Size" value="' + gross_amount + '" readonly/>' +
                // '</td>' +


                '<td class="tbl_srl_5"> ' +
                '<input type="text" name="bonus[]" id="bonus' + counter + '" placeholder="Bonus" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                bonus_qty + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" ' + bonus_qty_status + ' readonly/> ' +

                // '</td> ' +
                // '<td class="tbl_srl_4"> ' +
                // '<input type="text" name="product_discount[]" id="product_discount' + counter + '" placeholder="Dis%" class="inputs_up_tbl percentage_textbox" onkeyup="product_amount_calculation(' + counter + ')" ' +
                // 'value="' + discount + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                // '</td> <td class="text-right tbl_srl_7"> ' +
                // '<input type="text" name="product_discount_amount[]" id="product_discount_amount' + counter + '" placeholder="Dis Amount" value="' + discount_amount + '" class="inputs_up_tbl text-right" ' +
                // 'readonly/> ' +
                // '</td> <td class="tbl_srl_4"> ' +
                // '<input type="text" name="product_sales_tax[]" id="product_sales_tax' + counter + '" placeholder="Tax%" class="inputs_up_tbl percentage_textbox" value="' + sales_tax + '" ' +
                // 'onkeyup="product_amount_calculation(' + counter + ')" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                // '</td> ' +
                // '<td class="text-right tbl_srl_7"> ' +
                // '<input type="text" name="product_sale_tax_amount[]" id="product_sale_tax_amount' + counter + '" placeholder="Tax Amount" value="' + sale_tax_amount + '" class="inputs_up_tbl text-right" readonly/> ' +
                // '</td> ' +
                // '<td class="tbl_srl_4"> ' +
                // '<input type="checkbox" name="inclusive_exclusive[]" id="inclusive_exclusive' + counter + '" onclick="product_amount_calculation(' + counter + ');' + '"' + inclusive_exclusive_status + ' value="1"/> ' +
                // '<input type="hidden" name="inclusive_exclusive_status_value[]" id="inclusive_exclusive_status_value' + counter + '" onclick="product_amount_calculation(' + counter + ');" ' +
                // 'value="' + inclusive_exclusive + '"/> ' +
                // '</td> ' +
                // '<td class="text-right tbl_srl_9"> ' +
                // '<input type="text" name="amount[]" id="amount' + counter + '" placeholder="Amount" class="inputs_up_tbl text-right" value="' + amount + '" readonly/> ' +
                // '<div class="edit_update_bx"> <div class="inc_dec_con">' +
                // '<div class="inc_dec_bx for_inc"><i class="fa fa-plus" onclick=increase_quantity(' + counter + ')></i></div>' +
                // '<div class="inc_dec_bx for_val">1</div>' +
                // '<div class="inc_dec_bx for_dec"><i class="fa fa-minus" onclick=decrease_quantity(' + counter + ')></i></div>' +
                // '</div> ' +
                // '<a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i> </a> ' +
                // '</div> ' +
                '</td> ' +
                '</tr>');


            if (product_or_service_status != 1) {
                jQuery('#warehouse option[value="' + select_return_warehouse + '"]').prop('selected', true);
                duplicate_warehouse_dropdown(counter);
            }
            var messageBody = document.querySelector('#table_body');
            messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;

            jQuery("#invoice_nbr_chk").focus();
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

        jQuery("#cash_paid").keyup(function () {

            cash_return_calculation();
        });

        function cash_return_calculation() {
            var cash_paid = jQuery("#cash_paid").val();
            var grand_total = jQuery("#grand_total").val();
            // var service_grand_total = jQuery("#service_grand_total").val();
            var service_grand_total = 0;

            var cash_return = (+grand_total + +service_grand_total) - cash_paid;

            // nabeel
            // var product_sales_tax = jQuery("#product_sales_tax" + id).val();

            jQuery("#cash_return").val(cash_return.toFixed(2));
        }
    </script>
    {{--//////////////////////////////////////////////////////////////////// End Sale Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product_code").append("{!! $pro_code !!}");
            jQuery("#product_name").append("{!! $pro_name !!}");

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#account_name").select2();

            jQuery("#package").select2();

            jQuery("#warehouse").select2();

            jQuery("#sale_person").select2();
            jQuery("#posting_reference").select2();

            $("#account_name").focus();
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

        $("#credit_card_btn").click(function () {
            $("#crdt_crd_mdl").toggle();
        });

        $("#customer_info_btn").click(function () {
            $("#cstmr_info_mdl").toggle();
        });

        $(".sm_mdl_cls").click(function () {
            $(this).closest('.invoice_sm_mdl').css('display', 'none');
        });

    </script>

    {{--    check invoice number code start --}}
    <script>
        jQuery("#check_return_invoice").click(function () {

            var invoice_no = jQuery('#invoice_nbr_chk').val();

            var invoice_type = $("input[name='invoice_type']:checked").val();
            var prefix = '';
            var item_prefix = '';
            var desktop_invoice_id = 0;

            jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#table_body").html("");

            if ($("#desktop_invoice_id").is(':checked')) {
                desktop_invoice_id = 1;
            }

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_sale_items_for_delivery_challan",
                data: {invoice_no: invoice_no, invoice_type: invoice_type, desktop_invoice_id: desktop_invoice_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    jQuery("#table_body").html("");

                    if (invoice_type == 1) {

                        prefix = 'si';
                        item_prefix = 'sii';
                    } else if (invoice_type == 2) {

                        prefix = 'ssi';
                        item_prefix = 'ssii';
                    } else if (invoice_type == 3) {

                        prefix = 'do';
                        item_prefix = 'doi';
                    }
                    if (data.do != null) {
                        swal.fire({
                            type: 'error',
                            title: 'Already Exist...',
                            text: 'Already ' + invoice_no + ' make Delivery Challan',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-success',
                            timer: 4000
                        });
                    }
                    // else {
                    else if (data[0] == null) {

                        swal.fire({
                            type: 'error',
                            title: data[2] ,
                            text:  'Id '+ invoice_no + ' not exist',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-success',
                            timer: 4000
                        });

                    } else {
                        jQuery(".pre-loader").fadeToggle("medium");
                        if (data.length !== 0) {

                            jQuery("#account_name").select2("destroy");
                            jQuery('#account_name option[value="' + data[0][prefix + '_party_code'] + '"]').prop('selected', true);
                            jQuery("#account_name").select2();

                            jQuery("#posting_reference").select2("destroy");
                            jQuery('#posting_reference option[value="' + data[0][prefix + '_pr_id'] + '"]').prop('selected', true);
                            jQuery("#posting_reference").select2();

                            jQuery("#customer_name").val(data[0][prefix + '_customer_name']);
                            jQuery("#disc_percentage").val(data[0][prefix + '_cash_disc_per']);

                            $(".discount_type").prop("checked", false);
                            $("#discount_type" + data[0][prefix + '_discount_type']).prop("checked", true);

                            $.each(data[1], function (index, value) {

                                counter++;

                                var parent_code = value[item_prefix + '_product_code'];
                                jQuery('#product_name option[value="' + parent_code + '"]').prop('selected', true);
                                var name = $("#product_name option:selected").text();
                                var quantity = value[item_prefix + '_qty'];
                                var unit_measurement = $("#product_name option:selected").attr('data-unit');
                                var unit_measurement_scale_size = $("#product_name option:selected").attr('data-unit_scale_size');
                                var main_unit_measurement = $("#product_name option:selected").attr('data-main_unit');
                                var pack_qty = Math.floor(quantity / unit_measurement_scale_size);
                                var unit_qty = (quantity % unit_measurement_scale_size).toFixed(3);
                                var bonus_qty = value[item_prefix + '_bonus_qty'];
                                var warehouse_id = value[item_prefix + '_warehouse_id'];
                                // var rate = value[item_prefix + '_rate'];
                                // var inclusive_rate = 0;
                                // var discount = value[item_prefix + '_discount_per'];
                                // var discount_amount = 0;
                                // var sales_tax = value[item_prefix + '_saletax_per'];
                                // var sale_tax_amount = 0;
                                // var amount = 0;
                                var remarks = value[item_prefix + '_remarks'];
                                // var rate_after_discount = 0;
                                // var inclusive_exclusive = value[item_prefix + '_saletax_inclusive'];


                                // var rate_per_piece = rate / unit_measurement_scale_size;
                                // var gross_amount = quantity * rate;

                                // rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount,
                                //     inclusive_exclusive, counter, 0, warehouse_id, unit_measurement, unit_measurement_scale_size, rate_per_piece, gross_amount
                                add_sale(parent_code, name, quantity, bonus_qty, remarks,
                                    counter, 0, warehouse_id, unit_measurement, unit_measurement_scale_size, pack_qty, unit_qty, main_unit_measurement);

                                // console.log(add_sale, parent_code, name, quantity, bonus_qty, remarks,
                                //     counter, 0, warehouse_id, unit_measurement, unit_measurement_scale_size);
                                // product_amount_calculation(counter);

                            });
                        }
                        jQuery(".pre-loader").fadeToggle("medium");
                    }
                    // }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
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
            type: 'hold', mask: 'f2', handler: function () {
                $('.invoice_sm_mdl').css('display', 'none');
                $("#cstmr_info_mdl").toggle();
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
        }






        //  ##########   nabeel ahmed scripts    ############


        // stop inputs to write + and -
        function not_plus_minus(evt) {
            if (evt.keyCode == 107 || evt.keyCode == 109) {
                evt.preventDefault();
            }
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


        // when focus out from product table do not show its search table
        function hideproducts() {
            setTimeout(function () {
                $('.ps__search__results').css({
                    'display': 'none'
                });
            }, 500);
        }


        document.addEventListener('keyup', function (event) {

            // when focus is on product_discount within table then move to product (we have done this to maintain same functionality of tab as by plus(=))
            if (event.keyCode === 9) {  // means tab
                if ($("#product_discount_amount" + counter)[0] == $(document.activeElement)[0]) {
                    $("#account_name").focus();
                } else if ($("#save")[0] == $(document.activeElement)[0]){
                    $("#account_name").focus();
                }
                event.preventDefault();
            }



            // to close dropdown search
            if (event.keyCode === 106) {     // means staric(*)
                if ($(".select2-container--open")[0].previousElementSibling == $("#account_name")[0]) {

                    $('#account_name').select2({
                        selectOnClose: true
                    });
                    $('#account_name').focus();

                }
            }


            if (event.keyCode === 107) {     // means plus(+)

                // for upper inputs tab functionality
                if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#account_name")[0]) {
                    $("#customer_name").focus();
                } else if ($("#remarks")[0] == $(document.activeElement)[0]) {
                    $("#invoice_nbr_chk").focus();
                } else if ($("#customer_name")[0] == $(document.activeElement)[0]) {
                    $("#remarks").focus();
                } else if ($("#invoice_nbr_chk")[0] == $(document.activeElement)[0]) {
                    $("#account_name").focus();
                }

                event.preventDefault();
            }


            if (event.keyCode === 109) {   //means minus(-)


                // for upper inputs tab functionality
                if ($(document.activeElement)[0].parentElement.parentElement.previousElementSibling == $("#account_name")[0]) {
                    $("#invoice_nbr_chk").focus();
                } else if ($("#remarks")[0] == $(document.activeElement)[0]) {
                    $("#customer_name").focus();
                } else if ($("#customer_name")[0] == $(document.activeElement)[0]) {
                    $("#account_name").focus();
                } else if ($("#invoice_nbr_chk")[0] == $(document.activeElement)[0]) {
                    $("#remarks").focus();
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
            } else if (e.ctrlKey && e.key === "s") {   // when you press (ctrl + s) save the invoice
                $("#save").click();
                e.preventDefault();
            }
        });







    </script>

@endsection

