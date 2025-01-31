
@extends('extend_index')

@section('content')

<div class="row">
    <div class="container-fluid search-filter form-group form_manage">
        <div class="form_header"><!-- form header start -->
            <div class="clearfix">
                <div class="pull-left">
                    <h4 tabindex="-1" class="text-white get-heading-text">Product Clubbing</h4>
                </div>
                <div class="list_btn">
                    {{--                                <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('product_clubbing') }}" role="button">--}}
                    {{--                                    <i class="fa fa-list"></i> view list--}}
                    {{--                                </a>--}}
                </div><!-- list btn -->
            </div>
        </div><!-- form header close -->
        {{--<div class="excel_con gnrl-mrgn-pdng gnrl-blk">--}}
        {{--    <div class="excel_box gnrl-mrgn-pdng gnrl-blk">--}}
        {{--        <div class="excel_box_hdng gnrl-mrgn-pdng gnrl-blk">--}}
        {{--            <h2 class="gnrl-blk gnrl-mrgn-pdng gnrl-font-bold">--}}
        {{--                Upload Excel File--}}
        {{--            </h2>--}}
        {{--        </div>--}}
        {{--        <div class="excel_box_content gnrl-mrgn-pdng gnrl-blk">--}}

        {{--            <form action="{{ route('submit_product_clubbing_excel') }}" method="post" enctype="multipart/form-data">--}}
        {{--                @csrf--}}

        {{--                <div class="row">--}}
        {{--                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
        {{--                        <div class="input_bx"><!-- start input box -->--}}
        {{--                            <label class="required">--}}
        {{--                                Select Excel File--}}
        {{--                            </label>--}}
        {{--                            <input tabindex="100" type="file" name="add_product_clubbing_excel" id="add_product_clubbing_pattern_excel" class="inputs_up form-control-file form-control height-auto"--}}
        {{--                                   accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">--}}
        {{--                        </div><!-- end input box -->--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="form-group row">--}}
        {{--                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">--}}
        {{--                        <a href="{{ url('public/sample/product_clubbing/add_product_clubbing_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button form-control">--}}
        {{--                            Download Sample Pattern--}}
        {{--                        </a>--}}
        {{--                        <button tabindex="101" type="submit" name="save" id="save2" class="save_button form-control">--}}
        {{--                            <i class="fa fa-floppy-o"></i> Save--}}
        {{--                        </button>--}}
        {{--                    </div>--}}
        {{--                </div>--}}

        {{--            </form>--}}
        {{--        </div>--}}
        {{--    </div>--}}
        {{--</div>--}}
        <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
            <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->
                <form name="f1" class="f1" id="f1" action="{{ route('submit_product_clubbing') }}" method="post" onsubmit="return popvalidation()" autocomplete="off">
                    @csrf
                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->
                            <div class="invoice_row"><!-- invoice row start -->
                                <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.parent_code.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Parent Code
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                            <div class="invoice_col_short"><!-- invoice column short start -->
                                                <a href="{{ route('add_product') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a id="refresh_product_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                    <i class="fa fa-refresh"></i>
                                                </a>
                                            </div><!-- invoice column short end -->
                                            <select tabindex=1 autofocus name="product_parent_code" class="inputs_up form-control" id="product_parent_code" {{$status == 1 ? 'readonly':''}}>
                                                <option value="0">Select Code</option>
                                            </select>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.parent_name.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.parent_name.benefits')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Parent Name
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                            <div class="invoice_col_short"><!-- invoice column short start -->
                                                <a href="{{ route('add_product') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a id="refresh_product_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                    <i class="fa fa-refresh"></i>
                                                </a>
                                            </div><!-- invoice column short end -->
                                            <select tabindex="2" name="product_parent_name" class="inputs_up form-control" id="product_parent_name" {{$status == 1 ? 'readonly':''}}>
                                                <option value="0">Select Product</option>
                                            </select>
                                            <span id="demo2" class="validate_sign"> </span>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.product_code.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.product_code.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.product_code.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Product Code
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input"><!-- invoice column input start -->
                                            <input tabindex="3" type="text" name="product_code" class="inputs_up text-center form-control" id="product_code" placeholder="Product Code">
                                            <span id="demo3" class="validate_sign"></span>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                    <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                        <div class="invoice_col_txt with_cntr_jstfy">
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button tabindex="-1" style="display: none;" id="cancel_button" class="invoice_frm_btn btn-btn-sm btn-secondary" onclick="cancel_all()" type="button">
                                                    <i class="fa fa-times"></i> Cancel
                                                </button>
                                                <span id="demo201" class="validate_sign"> </span>
                                            </div>    
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button tabindex="4" id="first_add_more" class="invoice_frm_btn btn btn-sm btn-primary" onclick="add_product()" type="button">
                                                    <i class="fa fa-plus"></i> Add
                                                </button>
                                            </div>
                                            
                                        </div>
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                            </div><!-- invoice row end -->

                            <div class="invoice_row"><!-- invoice row start -->
                                <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                    <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                        <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                            <table class="table table-bordered table-sm" id="category_dynamic_table">
                                                <thead>
                                                <tr>
                                                    <th class="text-center tbl_srl_100"> Product Code</th>
                                                </tr>
                                                </thead>
                                                <tbody id="table_body">
                                                <tr>
                                                    <td colspan="10" align="center">
                                                        No Entry
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div><!-- product table box end -->
                                    </div><!-- product table container end -->
                                </div><!-- invoice column end -->

                            </div><!-- invoice row end -->
                            <div class="invoice_row"><!-- invoice row start -->
                                <div class="invoice_col col-lg-12"><!-- invoice column start -->
                                    <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button tabindex="5" type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                                <i class="fa fa-floppy-o"></i> Save
                                            </button>
                                            <span id="demo4" class="validate_sign"></span>
                                        </div>
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->
                            </div><!-- invoice row end -->
                        </div><!-- invoice content end -->
                    </div><!-- invoice scroll box end -->
                    <input type="hidden" name="productsval" id="productsval">
                    <input type="hidden" name="delete_products" id="delete_products">
                    <input type="hidden" name="status" id="status" value="{{$status}}">
                </form>
            </div><!-- invoice box end -->
        </div><!-- invoice container end -->
    </div> <!-- white column form ends here -->
</div><!-- row end -->

@endsection

@section('scripts')

    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                $("#first_add_more").click();
                // event.preventDefault();
                return false;
            }
        });

        jQuery("#refresh_product_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_product_club_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#product_parent_code").html(" ");
                    jQuery("#product_parent_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_product_code").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_product_club_name",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#product_parent_name").html(" ");
                    jQuery("#product_parent_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_product_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_product_club_code",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#product_parent_code").html(" ");
                    jQuery("#product_parent_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_product_name").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_product_club_name",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#product_parent_name").html(" ");
                    jQuery("#product_parent_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });
    </script>

    <script>
        jQuery("#product_parent_code").change(function () {

            var product_code = jQuery('option:selected', this).val();
            jQuery("#product_parent_name").select2("destroy");

            jQuery("#product_parent_name").children("option[value^=" + product_code + "]");
            jQuery('#product_parent_name option[value="' + product_code + '"]').prop('selected', true);

            jQuery("#product_parent_name").select2();
        });

    </script>

    <script>
        jQuery("#product_parent_name").change(function () {

            var product_name = jQuery('option:selected', this).val();
            jQuery("#product_parent_code").select2("destroy");

            jQuery("#product_parent_code").children("option[value^=" + product_name + "]");

            jQuery('#product_parent_code option[value="' + product_name + '"]').prop('selected', true);

            jQuery("#product_parent_code").select2();
        });

    </script>

    <script>
        // adding packs into table
        var numberofproducts = 0;
        var counter = 0;
        var delete_counter = 0;
        var products = {};
        var delete_products = {};
        var global_id_to_edit = 0;

        function popvalidation() {
            var product_code = document.getElementById("product_code").value;
            var product_parent_code = document.getElementById("product_parent_code").value;

            var flag_submit = true;
            var focus_once = 0;

            if (product_parent_code == "0") {

                if (focus_once == 0) {
                    jQuery("#product_parent_code").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            if (numberofproducts == 0) {

                if (product_code == "") {

                    if (focus_once == 0) {
                        jQuery("#product_code").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                document.getElementById("demo4").innerHTML = "Add products";
                flag_submit = false;
            } else {
                document.getElementById("demo4").innerHTML = "";
            }

            return flag_submit;
        }


        function add_product() {

            var product_code = document.getElementById("product_code").value;

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (product_code == "") {

                if (focus_once1 == 0) {
                    jQuery("#product_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete products[global_id_to_edit];
                }

                counter++;

                numberofproducts = Object.keys(products).length;

                if (numberofproducts == 0) {
                    jQuery("#table_body").html("");
                }

                products[counter] = [product_code];

                numberofproducts = Object.keys(products).length;

                jQuery("#table_body").append('<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_100">' + product_code + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_product(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_product(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery("#productsval").val(JSON.stringify(products));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');
                jQuery("#product_code").val("");

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();

                jQuery("#product_code").focus();
            }
        }


        function delete_product(current_item) {

            jQuery("#" + current_item).remove();

            delete_products[delete_counter] = products[current_item];

            delete_counter++;

            jQuery("#delete_products").val(JSON.stringify(delete_products));

            delete products[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#productsval").val(JSON.stringify(products));

            if (isEmpty(products)) {
                numberofproducts = 0;
            }
        }


        function edit_product(current_item) {

            // jQuery(".table-responsive").attr("style", "display:none");
            jQuery("#" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_products = products[current_item];

            jQuery("#product_code").val(temp_products[0]);


            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            jQuery("#product_code").val("");

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

    {{--@if(isset($edit_products) && !empty($edit_products))--}}
        <script>

            var edit_products = {};
            edit_products = @json($edit_products);

            $.each(edit_products, function (index, value) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete products[global_id_to_edit];
                }

                counter++;

                numberofproducts = Object.keys(products).length;

                if (numberofproducts == 0) {
                    jQuery("#table_body").html("");
                }

                products[counter] = [value];

                numberofproducts = Object.keys(products).length;

                jQuery("#table_body").append('<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_100">' + value + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_product(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_product(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery("#productsval").val(JSON.stringify(products));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');
                jQuery("#product_code").val("");

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();

                jQuery("#product_code").focus();
            });

        </script>
    {{--@endif--}}

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product_parent_code").select2();
            jQuery("#product_parent_name").select2();

            jQuery("#product_parent_code").append("{!! $product_code !!}");
            jQuery("#product_parent_name").append("{!! $product_name !!}");
        });
    </script>

@endsection


