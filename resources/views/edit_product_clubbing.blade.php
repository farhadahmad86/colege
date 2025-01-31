
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Product Clubbing</h4>
                            </div>
                            <div class="list_btn">
                                {{--                                <a class="btn list_link add_more_button" href="{{ route('product_clubbing') }}" role="button">--}}
                                {{--                                    <i class="fa fa-list"></i> view list--}}
                                {{--                                </a>--}}
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->

                    <form name="f1" class="f1" id="f1" action="{{ route('submit_product_clubbing') }}" method="post"
                          autocomplete="off">
                    @csrf
                    <!-- main row ends here --> <!-- first row ends here -->

                        <!-- lower row starts here -->
                        <div class="row">

                            <div class="col-lg-12 col-md-12"> <!-- left column starts here  -->

                                <div class="search_form">
                                    <div class="row">  <!--  new row starts here -->

                                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.parent_code.description')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Parent Code</label>
                                                <select name="product_parent_code" class="inputs_up form-control" id="product_parent_code">
                                                    <option value="0">Select Code</option>
                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.parent_name.description')}}</p>
                                                       <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.parent_name.benefits')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Parent Name</label>
                                                <select name="product_parent_name" class="inputs_up form-control" id="product_parent_name"
                                                        tabindex="2">
                                                    <option value="0">Select Product</option>
                                                </select>
                                                <span id="demo2" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                    </div> <!-- new row ends here -->
                                </div><!-- search form end -->


                                <div class="row m-0" style="">
                                    <!-- table code starts here -->
                                    <div class="table_div table-responsive table-max-height-500px">
                                        <table class="table table-striped table-bordered m-0"
                                               id="category_dynamic_table">
                                            <thead class="lower-section-thead">
                                            <tr>
                                                <th scope="col" class=" wdth_5">Code</th>
                                                <th scope="col" class="w-5p text-right wdth_5">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="table_body">

                                            <tr>
                                                <td colspan="10" align="center"> No product Added</td>
                                            </tr>
                                            </tbody>

                                            <tfoot class="side-section">

                                            <tr>

                                                <td class=" wdth_5">
                                                    <input type="text" name="product_code" class="inputs_up text-right form-control" id="product_code" placeholder="Product Code">
                                                    <span id="demo3" class="validate_sign"></span>
                                                </td>

                                                <td class="w-5p text-right wdth_5">

                                                    <button id="first_add_more" class="btn btn-success btn-sm" onclick="add_product()" type="button">
                                                        <i class="fa fa-plus"></i> Add
                                                    </button>

                                                    <button style="display: none; background-color: red !important" id="cancel_button" class="btn btn-danger btn-sm" onclick="cancel_all()"
                                                            type="button">
                                                        <i class="fa fa-times"></i> Cancel
                                                    </button>

                                                    <span id="demo201" class="validate_sign"> </span>

                                                </td>
                                            </tr>

                                            </tfoot>
                                        </table>
                                        <!-- table code ends here -->
                                    </div> <!-- responsive table div ends here -->

                                </div>
                            </div> <!-- left column ends here -->
                        </div>

                        <div class="row"> <!-- lower -->
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="form_controls">
                                    <button type="submit" name="save" id="save" class="save_button form-control">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                    <span id="demo4" class="validate_sign"></span>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" name="productsval" id="productsval">

                    </form>
                </div> <!-- white column form ends here -->

            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')

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
        var products = {};
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

                if (product_code == "0") {

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

            if (product_code == "0") {

                if (focus_once1 == 0) {
                    jQuery("#product_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {

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

                jQuery("#table_body").append(
                    '<tr id=' + counter + '><td class="wdth_1">' + product_code + '</td><td align="right" class="wdth_4"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_product(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_product(' + counter + ')><i class="fa fa-trash"></i></a></td></tr>');

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

