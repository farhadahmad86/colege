@extends('extend_index')


@section('content')
    <!-- mana sara comments delete kr dia ha  previous sale invoice ka-->
    {{--                to get blue color cut invoice_bx from class --}}
    <div class="row">
        {{--            edit it --}}
        <div id="main_bg" class="container-fluid search-filter form-group form_manage">
            {{--                form header --}}
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text"> IMEI</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <a class="add_btn list_link add_more_button" href="{{ route('imei_list') }}" role="button">
                            <i class="fa fa-list"></i> IMEI List
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            {{--                invoice container --}}
            <div id="invoice_con">
                <!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx">
                    <!-- invoice box start -->
                    {{-- form start --}}
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <input tabindex="5" type="text" name="products" id="products" class="inputs_up form-control"
                            placeholder="Enter Product" onfocus="this.select();" onchange="productChangedd(this)">
                        <span id="alert"></span>
                    </div>
                    <form name="f1" class="f1" id="f1" action="{{ route('store_imei') }}" method="post"
                        autocomplete="off" onsubmit="return checkForm()" >
                        @csrf
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                            <!-- invoice scroll box start -->
                            <div class="invoice_cntnt">
                                <!-- invoice content start -->
                                {{--                                    above table --}}
                                <div class="invoice_row">
                                    <!-- invoice row start -->
                                    <!-- add start -->
                                    <!-- changed -->
                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12">
                                        <!-- invoice column start -->
                                        <div class="invoice_col_bx">
                                            <!-- invoice column box start -->
                                            <div class="required invoice_col_ttl">
                                                <!-- invoice column title start -->

                                                Products
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input">
                                                <!-- invoice column input start -->

                                                <div class="invoice_col_short">
                                                    <!-- invoice column short start -->
                                                    <a href="{{ route('add_product') }}" target="_blank"
                                                        class="col_short_btn" data-container="body" data-toggle="popover"
                                                        data-trigger="hover" data-placement="bottom" data-html="true"
                                                        data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_product_name" class="col_short_btn" data-container="body"
                                                        data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                        data-html="true"
                                                        data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </div><!-- invoice column short end -->
                                                <div class="ps__search">
                                                    <select name="product" id="product" class="inputs_up form-control"
                                                        data-rule-required="true" data-msg-required="Please Select Product">
                                                        <option selected disabled>Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->pro_p_code }}">
                                                                {{ $product->pro_title }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                <span id="check_product_count" class="validate_sign"></span>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div>

                                </div><!-- invoice row end -->
                                <!-- row2 start -->

                                {{-- Table start --}}
                                <div class="pro_tbl_con">
                                    <!-- product table container start -->
                                    <div class="table-responsive pro_tbl_bx">
                                        <!-- product table box start -->
                                        <table class="table table-bordered table-sm" id="category_dynamic_table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center tbl_srl_5"> Sr#</th>
                                                    <th class="text-center tbl_txt_90"> IMEI Number</th>
                                                    <th class="text-center tbl_srl_5">
                                                        Actions
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_body">


                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th tabindex="-1" colspan="3" class="text-right">
                                                        Total
                                                    </th>
                                                    <td tabindex="-1" class="tbl_srl_12">
                                                        <div class="invoice_col_txt">
                                                            <!-- invoice column box start -->
                                                            <div class="invoice_col_input">
                                                                <!-- invoice column input start -->
                                                                <input tabindex="-1" type="text" name="total_items"
                                                                    class="inputs_up text-right form-control"
                                                                    id="total_items" placeholder="0" readonly
                                                                    data-rule-required="true"
                                                                    data-msg-required="Please Add" />
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div><!-- product table box end -->
                                </div><!-- product table container end -->
                                {{-- Table end --}}

                                {{-- Lower section start --}}
                                {{--                            shortcut buttons --}}
                                <div class="invoice_row">
                                    <!-- invoice row start -->

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <!-- invoice column start -->
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button tabindex="11" type="submit" class="invoice_frm_btn btn btn-sm btn-success" name="save"
                                                id="save">
                                                Save (Ctrl+S)
                                            </button>
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                </div><!-- invoice row end -->
                            </div><!-- invoice row end -->
                        </div><!-- invoice column end -->
                    </form>
                    {{-- form end --}}


                </div><!-- invoice box end -->
            </div><!-- invoice container end -->

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Trade Sales Invoice Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="printbody">

                    <div id="table_body">

                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                onclick="gotoParty()" data-dismiss="modal">
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
    <script type="text/javascript">
        function checkForm() {
            let product = document.getElementById("product"),
                // let total_items = document.getElementById("total_items"),

                    validateInputIdArray = [
                        product.id,
                        // total_items.id,
                    ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>


    <script>
        // adding sales into table
        var counter = 0;
        var total_discount = 0;
        function productChangedd(product) {
            var rowCount = $("#table_body tr").length;
            // if (rowCount) {
            //     document.getElementById('alert').innerHTML = 'Only Six IMEI Enter';
            // } else {
                counter++;
                add_first_item();
                var code = product.pro_p_code;
                var parent_code = product.pro_p_code;
                var name = product.pro_title;
                var remarks = $('#products').val();
                var pro_code;
                var pro_field_id_title;
                var pro_field_id;
                document.getElementById('total_items').value = 1 + rowCount;
                add_sale(parent_code, name, remarks, counter);

            }

        jQuery("#all_clear_form").click(function() {
            jQuery("#table_body").html("");

        });


        function add_sale(code, name, remarks, counter) {
            jQuery("#table_body").append('<tr class="edit_update" id="table_row' + counter + '">' +
                // '<td class="text-center tbl_srl_4">02</td> ' +
                '<td class="text-center tbl_srl_5">' +

                '<input type="hidden" name="pro_code[]" id="pro_code' + counter + '" placeholder="Code" ' +
                'class="inputs_up_tbl" value="' + code + '" readonly/>' +
                counter + '</td> ' +

                '<td class="text-left tbl_txt_90">' +
                '<input type="text" tabindex="-1" name="product_remarks[]" id="product_remarks' + counter +
                '" placeholder="Remarks" ' + 'class="inputs_up_tbl" value="' + remarks + '"/>' +
                '</td>' +

                '<td class="text-right tbl_srl_5"> ' +
                '<div class="edit_update_bx"> <div class="inc_dec_con">' +
                '<a href="#" class="delete_link btn btn-sm btn-danger" tabindex="-1" onclick=delete_sale(' + counter +
                ')><i class="fa fa-trash"></i> </a> ' +
                '</div> ' +
                '</td> ' +
                '</tr>');


            var messageBody = document.querySelector('#table_body');
            messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;

            jQuery("#products").val('');
            jQuery("#products").focus();

        }


        function delete_sale(current_item) {

            jQuery("#table_row" + current_item).remove();

        }


        function add_first_item() {
            var total_items = $('input[name="pro_code[]"]').length;

            if (total_items <= 0 || total_items == '') {
                jQuery("#table_body").html("");
            }
        }
    </script>

    <script>
        jQuery(document).ready(function() {
            jQuery("#product").select2();
            jQuery("#products").focus();
        });


    </script>
@endsection
