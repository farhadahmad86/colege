@extends('extend_index')

@section('content')

    <div class="row">
        <div
            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Update Courier</h4>
                        </div>

                    </div>
                </div><!-- form header close -->


                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate">
                        <!-- invoice box start -->

                        <form name="f1" class="f1" id="f1" action="{{ route('update_courier') }}"
                              onsubmit="return checkForm()" method="post" autocomplete="off">
                            @csrf
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                    <div class="invoice_row"><!-- invoice row start -->

                                        <div class="invoice_col basis_col_23" hidden><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    Courier id
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="hidden" name="courier_id"
                                                           class="inputs_up form-control" id="courier_id"

                                                           value="{{$courier->cc_id}}">
                                                    <span id="demo7" class="validate_sign"></span>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    Courier Name
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="text" name="name"
                                                           class="inputs_up form-control" id="name"
                                                           placeholder="Courier Name" data-rule-required="true"
                                                           data-msg-required="Please Enter Courier Name"
                                                           value="{{$courier->cc_name}}">
                                                    <span id="demo7" class="validate_sign"></span>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
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
                                                    <input type="text" name="remarks" class="inputs_up form-control"
                                                           id="remarks" placeholder="Remarks"
                                                           value="{{$courier->cc_remarks}}">
                                                    <span id="demo7" class="validate_sign"></span>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                    </div><!-- invoice row end -->

                                    <div class="invoice_row"><!-- invoice row start -->

                                        <div class="invoice_col basis_col_12" hidden><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    Branch id
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="hidden" name="branch_id"
                                                           class="inputs_up form-control" id="branch_id"
                                                           placeholder="Branch Name">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_12"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    Branch Name
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="text" name="branch_name"
                                                           class="inputs_up form-control" id="branch_name"
                                                           placeholder="Branch Name">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    Type
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->

                                                    <select name="type" class="inputs_up form-control"
                                                            id="type">
                                                        <option value="0">Select Type</option>
                                                        <option value="1">Head Office</option>
                                                        <option value="2">Branch</option>

                                                    </select>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_12"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
                                                    City
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <select name="city" class="inputs_up form-control" id="city">
                                                        <option value="0" selected disabled>Select City</option>
                                                        @foreach($cities as $city)
                                                            <option
                                                                {{$city->city_id == 0 ? 'selected':''}}
                                                                value="{{$city->city_id}}">
                                                                {{$city->city_name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->


                                        <div class="invoice_col basis_col_20"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    Address
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="text" name="address"
                                                           class="inputs_up form-control" id="address"
                                                           placeholder="Address">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_12"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    Mobile/Phone 1
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="text" name="contact_1"
                                                           class="inputs_up form-control" id="contact_1"
                                                           placeholder="Mobile/Phone 1">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_12"><!-- invoice column start -->
                                            <div class="invoice_col_bx"><!-- invoice column box start -->
                                                <div class="invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    Mobile/Phone 2
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                    <input type="text" name="contact_2"
                                                           class="inputs_up form-control" id="contact_2"
                                                           placeholder="Mobile/Phone 2">
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_18"><!-- invoice column start -->
                                            <div class="invoice_col_txt for_voucher_col_bx">
                                                <!-- invoice column box start -->
                                                <div class="invoice_col_txt with_cntr_jstfy">
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button id="first_add_more" class="invoice_frm_btn"
                                                                onclick="add_courier()" type="button">
                                                            <i class="fa fa-plus"></i> Add
                                                        </button>
                                                    </div>
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button style="display: none;" id="cancel_button"
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
                                                                    <th class="text-center tbl_srl_12">Branch Name</th>
                                                                    <th class="text-center tbl_srl_12">Type</th>
                                                                    <th class="text-center tbl_txt_15">City</th>
                                                                    <th class="text-center tbl_txt_30">Address</th>
                                                                    <th class="text-center tbl_srl_16">Mobile/Phone 1
                                                                    </th>
                                                                    <th class="text-center tbl_srl_15">Mobile/Phone 2
                                                                    </th>
                                                                </tr>
                                                                </thead>

                                                                <tbody id="table_body">
                                                              <tr>
                                                                  <td colspan="10" align="center">
                                                                      No Courier Added
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
                                                    <button type="submit" name="save" id="save" class="invoice_frm_btn"
                                                    >
                                                        <i class="fa fa-floppy-o"></i> Save
                                                    </button>
                                                    <span id="demo21" class="validate_sign"></span>
                                                </div>
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->


                                    </div><!-- invoice row end -->

                                </div><!-- invoice content end -->
                            </div><!-- invoice scroll box end -->

                            <input type="hidden" name="products_array" id="products_array">
{{--                            <input type="hidden" name="cc_id" id="cc_id" value="{{$courier->cc_id}}">--}}

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
            let name = document.getElementById("name"),
                validateInputIdArray = [
                    name.id,
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

    </script>


    <script>
        // adding packs into table
        var numberofproducts = 0;
        var counter = 0;
        var products = {};
        var global_id_to_edit = 0;
        var edit_courier_value = '';

        function popvalidation() {
            isDirty = true;

            var branch_name = document.getElementById("branch_name").value;
            var type = document.getElementById("type").value;
            var city = document.getElementById("city").value;
            var address = document.getElementById("address").value;
            var contact_1 = document.getElementById("contact_1").value;
            var contact_2 = document.getElementById("contact_2").value;

            var flag_submit = true;
            var focus_once = 0;

            if (numberofproducts == 0) {
                var isDirty = false;
                if (branch_name == "") {
                    if (focus_once == 0) {
                        jQuery("#branch_name").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (type == "0") {
                    if (focus_once == 0) {
                        jQuery("#type").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                if (city == "0") {

                    if (focus_once == 0) {
                        jQuery("#city").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                if (address == "") {

                    if (focus_once == 0) {
                        jQuery("#address").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (contact_1 == "") {

                    if (focus_once == 0) {
                        jQuery("#contact_1").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                document.getElementById("demo28").innerHTML = "Add";
                flag_submit = false;
            } else {
                document.getElementById("demo28").innerHTML = "";
            }
            return flag_submit;
        }


        function add_courier() {

            var branch_id = document.getElementById("branch_id").value;
            var branch_name = document.getElementById("branch_name").value;
            var type = document.getElementById("type").value;
            var city = document.getElementById("city").value;
            var address = document.getElementById("address").value;
            var contact_1 = document.getElementById("contact_1").value;
            var contact_2 = document.getElementById("contact_2").value;

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (branch_name == "") {

                if (focus_once1 == 0) {
                    jQuery("#branch_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (type == "0") {

                if (focus_once1 == 0) {
                    jQuery("#type").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (city == "0") {

                if (focus_once1 == 0) {
                    jQuery("#city").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (address == "") {

                if (focus_once1 == 0) {
                    jQuery("#address").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (contact_1 == "") {

                if (focus_once1 == 0) {
                    jQuery("#contact_1").focus();
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

                jQuery("#type").select2("destroy");
                jQuery("#city").select2("destroy");

                var name = jQuery("#type option:selected").text();
                var city_name = jQuery("#city option:selected").text();
                // var address = jQuery("#address").val();
                // var contact_1 = jQuery("#contact_1").val();
                // var contact_2 = jQuery("#contact_2").val();

                numberofproducts = Object.keys(products).length;

                if (numberofproducts == 0) {
                    jQuery("#table_body").html("");
                }

                products[counter] = {

                    'branch_id': branch_id,
                    'branch_name': branch_name,
                    'type': type,
                    'name': name,
                    'city': city,
                    'city_name': city_name,
                    'address': address,
                    'contact_1': contact_1,
                    'contact_2': contact_2,

                };


                if (type == 1) {
                    jQuery("#type option[value=" + type + "]").attr("disabled", "true");
                }
                // jQuery("#city option[value=" + city + "]").attr("disabled", "true");

                numberofproducts = Object.keys(products).length;
                // <td class="text-left tbl_srl_20">' + warehouse_name + '</td>
                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="text-left tbl_srl_12">' + branch_name + '</td><td class="text-left tbl_srl_12">' + name + '</td><td class="text-left tbl_txt_15">' + city_name + '</td><td class="text-left tbl_txt_30">' + address + '</td><td class="text-left tbl_txt_16">' + contact_1 + '</td><td class="text-left tbl_srl_15">' + contact_2 + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_courier(' + counter + ')><i class="fa fa-edit"></i></a> <a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_courier(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#type option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#city option[value="' + 0 + '"]').prop('selected', true);
                // jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

                jQuery("#branch_id").val("");
                jQuery("#branch_name").val("");
                jQuery("#address").val("");
                jQuery("#contact_1").val("");
                jQuery("#contact_2").val("");

                jQuery("#products_array").val(JSON.stringify(products));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i>  Add');

                jQuery("#type").select2();
                jQuery("#city").select2();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }


        function delete_courier(current_item) {

            jQuery("#" + current_item).remove();
            var temp_products = products[current_item];
            jQuery("#type option[value=" + temp_products['type'] + "]").attr("disabled", false);
            jQuery("#city option[value=" + temp_products['city'] + "]").attr("disabled", false);

            delete products[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#products_array").val(JSON.stringify(products));

            // if (isEmpty(products)) {
            //     numberofproducts = 0;
            // }
            // jQuery("#total_items").val(numberofproducts);
            //
            // grand_total_calculation();
        }


        function edit_courier(current_item) {

            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();


            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_products = products[current_item];

            edit_courier_value = temp_products['type'];

            jQuery("#type").select2("destroy");
            jQuery("#city").select2("destroy");
            // jQuery("#warehouse").select2("destroy");


            // jQuery("#city option[value=" + temp_products['type'] + "]").attr("disabled", false);

            if (temp_products['type'] == 1) {
                jQuery("#type option[value=" + temp_products['type'] + "]").attr("disabled", false);
            }
            jQuery('#type option[value="' + temp_products['type'] + '"]').prop('selected', true);

            jQuery("#branch_id").val(temp_products['branch_id']);
            jQuery("#branch_name").val(temp_products['branch_name']);
            jQuery("#city").val(temp_products['city']);
            jQuery("#address").val(temp_products['address']);
            jQuery("#contact_1").val(temp_products['contact_1']);
            jQuery("#contact_2").val(temp_products['contact_2']);

            jQuery("#type").select2();
            jQuery("#city").select2();
            //jQuery("#warehouse").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            // var newvaltohide = jQuery("#product_code").val();

            var newvaltohide = edit_courier_value;

            jQuery("#type option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery("#city option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery('#type option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#city option[value="' + 0 + '"]').prop('selected', true);
            // jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

            jQuery("#type").select2("destroy");
            jQuery("#city").select2("destroy");

            jQuery("#branch_name").val("");
            jQuery("#address").val("");
            jQuery("#contact_1").val("");
            jQuery("#contact_2").val("");

            jQuery("#type").select2();
            jQuery("#city").select2();

            jQuery("#cancel_button").hide();
            jQuery(".table-responsive").show();
            jQuery("#save").show();
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

            global_id_to_edit = 0;


            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            edit_courier_value = '';
        }

        @forelse($courier_item as $index => $courier)

        var branch_id = '{{ $courier->ccb_id }}';
        var branch_name = '{{ $courier->ccb_branch_name }}';
        var type = '{{ $courier->ccb_type }}';
        var city = '{{ $courier->ccb_city_id }}';
        var address = '{{ $courier->ccb_address }}';
        var contact_1 = '{{ $courier->ccb_contact_num1 }}';
        var contact_2 = '{{ $courier->ccb_contact_num2 }}';
        if(type==1){
            var name = 'Head Office';
        }else{
            var name = 'Branch';
        }

        var city_name = '{{ $courier->city_name }}';
        if (global_id_to_edit != 0) {
            jQuery("#" + global_id_to_edit).remove();

            delete products[global_id_to_edit];
        }

        counter++;

        numberofproducts = Object.keys(products).length;
        if (numberofproducts == 0) {
            jQuery("#table_body").html("");
        }

        products[counter] = {

            'branch_id': branch_id,
            'branch_name': branch_name,
            'type': type,
            'name': name,
            'city': city,
            'city_name': city_name,
            'address': address,
            'contact_1': contact_1,
            'contact_2': contact_2,

        };

        numberofproducts = Object.keys(products).length;

        jQuery("#table_body").append(
            '<tr id=' + counter + ' class="edit_update"><td class="text-left tbl_srl_12">' + branch_name + '</td><td class="text-left tbl_srl_12">' + name + '</td><td class="text-left tbl_txt_15">' + city_name + '</td><td class="text-left tbl_txt_30">' + address + '</td><td class="text-left tbl_txt_16">' + contact_1 + '</td><td class="text-left tbl_srl_15">' + contact_2 + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_courier(' + counter + ')><i class="fa fa-edit"></i></a> <a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_courier(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

        if (type == 1) {
            jQuery("#type option[value=" + type + "]").attr("disabled", "true");
        }
        console.log(products)
        jQuery("#products_array").val(JSON.stringify(products));
        jQuery("#cancel_button").hide();
        jQuery(".table-responsive").show();
        jQuery("#save").show();
        jQuery("#first_add_more").html('<i class="fa fa-plus"></i>  Add');
        jQuery("#type").select2();
        jQuery("#city").select2();

        jQuery(".edit_link").show();
        jQuery(".delete_link").show();

        @empty

        @endforelse
    </script>



@endsection


