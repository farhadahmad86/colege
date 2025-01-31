@extends('extend_index')

@section('content')

    <div class="row">


        <div
            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Create Tank</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('tank_list') }}"
                               role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate">
                        <!-- invoice box start -->

                        <form action="{{ route('submit_tank') }}" onsubmit="return popvalidation()" method="post" autocomplete="off">
                            @csrf

                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                    <div class="invoice_row"><!-- invoice row start -->

                                        <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                    Tank Name
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="1" autofocus type="text" name="tank_name"
                                                           class="inputs_up form-control" id="tank_name"
                                                           placeholder="Tank Name" data-rule-required="true"
                                                           data-msg-required="Please Enter Tank Name" value="{{old('tank_name')}}">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                    Capacity
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="2" type="text" name="capacity"
                                                           class="inputs_up form-control" id="capacity"
                                                           placeholder="Capacity" data-rule-required="true"
                                                           data-msg-required="Please Enter Capacity Name" value="{{old('capacity')}}" onkeypress="return allow_only_number_and_decimals(this,event);">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                    Product
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <select tabindex="3" name="product_code" class="inputs_up form-control" id="product_code">
                                                        <option value="">Select Product</option>

                                                    </select>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    <a
                                                        data-container="body" data-toggle="popover" data-trigger="hover"
                                                        data-placement="bottom" data-html="true"
                                                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Remarks

                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="4" type="text" name="remarks" class="inputs_up form-control"
                                                           id="remarks" placeholder="Remarks" value="{{old('remarks')}}">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                    </div><!-- invoice row end -->

                                    <div class="invoice_row"><!-- invoice row start -->

                                        <div class="invoice_col basis_col_20"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    Dip
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="5" type="text" name="dip"
                                                           class="inputs_up form-control"
                                                           value="{{old('dip')}}" id="dip" placeholder="Dip" onkeypress="return allow_only_number_and_decimals(this,event);">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_20"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    Volume
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input tabindex="6" type="text" name="volume"
                                                           class="inputs_up form-control"
                                                           value="{{old('volume')}}" id="volume" placeholder="Volume" onkeypress="return allow_only_number_and_decimals(this,event);">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_17"><!-- invoice column start -->
                                            <div class="invoice_col_txt for_voucher_col_bx">
                                                <!-- invoice column box start -->
                                                <div class="invoice_col_txt with_cntr_jstfy">
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button tabindex="7" id="first_add_more" class="invoice_frm_btn"
                                                                onclick="add_data()" type="button">
                                                            <i class="fa fa-plus"></i> Add
                                                        </button>
                                                    </div>
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button tabindex="8" style="display: none;" id="cancel_button"
                                                                class="invoice_frm_btn" onclick="cancel_all()"
                                                                type="button">
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

                                                <div class="invoice_col basis_col_100 gnrl-mrgn-pdng">
                                                    <!-- invoice column start -->
                                                    <div class="pro_tbl_con for_voucher_tbl">
                                                        <!-- product table container start -->
                                                        <div class="pro_tbl_bx"><!-- product table box start -->
                                                            <table class="table gnrl-mrgn-pdng"
                                                                   id="category_dynamic_table">
                                                                <thead>
                                                                <tr>

                                                                    <th tabindex="-1" class="text-center tbl_txt_30">
                                                                        Dip
                                                                    </th>
                                                                    <th tabindex="-1" class="text-center tbl_txt_30">
                                                                        Volume
                                                                    </th>
                                                                </tr>
                                                                </thead>

                                                                <tbody id="table_body">
                                                                <tr>
                                                                    <td tabindex="-1" colspan="10" align="center">
                                                                        No Entry
                                                                    </td>
                                                                </tr>
                                                                </tbody>

                                                            </table>
                                                        </div><!-- product table box end -->
                                                    </div><!-- product table container end -->
                                                </div><!-- invoice column end -->


                                            </div><!-- invoice row end -->
                                        </div><!-- invoice column end -->

                                    </div><!-- invoice row end -->

                                    <div class="invoice_row"><!-- invoice row start -->

                                        <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                            <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns">
                                                <!-- invoice column box start -->
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                    <button tabindex="8" type="submit" name="save" id="save" class="invoice_frm_btn" onclick="return popvalidation()">
                                                        <i class="fa fa-floppy-o"></i> Save
                                                    </button>
                                                    <span id="demo28" class="validate_sign"></span>
                                                </div>
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->


                                    </div><!-- invoice row end -->

                                </div><!-- invoice content end -->
                            </div><!-- invoice scroll box end -->


                            <input tabindex="-1" type="hidden" name="data_array" id="data_array">

                        </form>

                    </div><!-- invoice box end -->
                </div><!-- invoice container end -->


            </div> <!-- white column form ends here -->


        </div><!-- col end -->


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

    </script>


    <script>
        // adding packs into table
        var numberofrows = 0;
        var counter = 0;
        var data_array = {};
        var global_id_to_edit = 0;
        var edit_data_value = '';

        function popvalidation() {

            var tank_name = jQuery("#tank_name").val();
            var capacity = jQuery("#capacity").val();
            var product_code = jQuery("#product_code").val();

            var flag_submit = true;
            var focus_once = 0;

            if (numberofrows == 0) {

                if (tank_name == "") {
                    if (focus_once == 0) {
                        jQuery("#tank_name").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (capacity == "") {
                    if (focus_once == 0) {
                        jQuery("#capacity").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                if (product_code == "") {

                    if (focus_once == 0) {
                        jQuery("#product_code").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                document.getElementById("demo28").innerHTML = "Add Calibration";
                flag_submit = false;
            } else {
                document.getElementById("demo28").innerHTML = "";
            }
            return flag_submit;
        }


        function add_data() {

            var dip = jQuery("#dip").val();
            var volume = jQuery("#volume").val();

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (dip == "") {

                if (focus_once1 == 0) {
                    jQuery("#dip").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (volume == "") {

                if (focus_once1 == 0) {
                    jQuery("#volume").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete data_array[global_id_to_edit];
                }

                counter++;

                numberofrows = Object.keys(data_array).length;

                if (numberofrows == 0) {
                    jQuery("#table_body").html("");
                }

                data_array[counter] = {
                    'dip': dip,
                    'volume': volume,
                };

                numberofrows = Object.keys(data_array).length;

                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_txt_30">' + dip + '</td><td class="text-center tbl_txt_30">' + volume + '<div class="edit_update_bx"><a' + ' class="edit_link btn btn-sm btn-success" href="#" onclick=edit_data(' + counter + ')><i class="fa fa-edit"></i></a> <a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_data(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');


                jQuery("#dip").val("");
                jQuery("#volume").val("");

                jQuery("#data_array").val(JSON.stringify(data_array));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i>  Add');

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }


        function delete_data(current_item) {

            jQuery("#" + current_item).remove();

            delete data_array[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#data_array").val(JSON.stringify(data_array));
        }


        function edit_data(current_item) {

            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();


            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_data_array = data_array[current_item];

            edit_data_value = temp_data_array['type'];

            jQuery("#dip").val(temp_data_array['dip']);
            jQuery("#volume").val(temp_data_array['volume']);

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            var newvaltohide = edit_data_value;


            jQuery("#dip").val("");
            jQuery("#volume").val("");

            jQuery("#cancel_button").hide();
            jQuery(".table-responsive").show();
            jQuery("#save").show();
            jQuery("#first_add_more").html('Add');

            global_id_to_edit = 0;

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            edit_data_value = '';
        }
    </script>

    <script>
        jQuery(document).ready(function () {
            jQuery("#product_code").append("{!! $pro_name !!}");

            jQuery("#product_code").select2();
        });
    </script>

@endsection


