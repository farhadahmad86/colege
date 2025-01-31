@extends('extend_index')
@section('styles_get')
    {{-- nabeel added css blue --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/nabeel_blue/last.css') }}">
@stop

@section('content')
    <style>
        /* #urdu_product_name {
                        direction: rtl;
                    } */

        .ur {
            font-family: 'Jameel Noori Nastaleeq', 'Noto Naskh Arabic', sans serif;;
        }
    </style>
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Subject Outline</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button"
                           href="{{ route('course_outline_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher">
                <!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate">
                    <!-- invoice box start -->
                    <form id="f1" action="{{ route('submit_course_outline') }}" method="post"
                          onsubmit="return checkForm()">
                        @csrf
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                            <!-- invoice scroll box start -->
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                <!-- invoice content start -->
                                <div class="invoice_row my-3">
                                    <!-- invoice row start -->
                                    <div class="invoice_col from_group col-lg-3 col-md-4 col-sm-12">
                                        <!-- invoice column -->
                                        <div class="invoice_col_ttl required">
                                            Subject
                                        </div><!-- invoice column title end -->
                                        <select tabindex="1" name="subject_id"
                                                class="inputs_up form-control cash_voucher"
                                                id="subject_id" data-rule-required="true"
                                                data-msg-required="Please Enter Subject">
                                            <option value="0" readonly>Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->subject_id }}">{{ $subject->subject_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="invoice_col from_group col-lg-3 col-md-4 col-sm-12">
                                        <!-- invoice column -->
                                        <div class="invoice_col_ttl required">
                                            Group
                                        </div><!-- invoice column title end -->
                                        <select name="subject_group" class="inputs_up form-control cash_voucher"
                                                id="subject_group" data-rule-required="true"
                                                data-msg-required="Please Enter Group">
                                            <option readonly disabled selected>Select Group</option>
                                            <option value="1">First Year</option>
                                            <option value="2">Second Year</option>
                                        </select>
                                    </div>
                                    <div class="invoice_col from_group col-lg-3 col-md-4 col-sm-12">
                                        <!-- invoice column -->
                                        <div class="invoice_col_ttl required">
                                            Chapter No#
                                        </div><!-- invoice column title end -->
                                        <input name="ch_no" type="text" class="inputs_up  cash_voucher" id="ch_no"
                                               data-rule-required="true" data-msg-required="Please Enter Chapter No"/>

                                    </div>
                                    <div class="invoice_col from_group col-lg-3 col-md-4 col-sm-12">
                                        <!-- invoice column -->
                                        <div class="invoice_col_ttl required">
                                            Chapter Name
                                        </div><!-- invoice column title end -->
                                        <input name="ch_name" type="text" class="inputs_up  cash_voucher" id="ch_name"
                                               data-rule-required="true" data-msg-required="Please Enter Chapter Name"/>

                                    </div>
                                </div><!-- invoice row end -->
                                <div class="invoice_row">
                                    <div class="input_bx form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <!-- start input box -->
                                        <label class="">
                                            Outline</label>
                                        <input tabindex="2" type="text" id="urdu_product_name"
                                               data-rule-required="true" data-msg-required="Please Enter Outline"
                                               class="inputs_up form-control ur" placeholder="Enter Outline" value="">
                                        <span id="demo6" class="validate_sign"> </span>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mt-4">
                                        <div class="custom-checkbox">
                                            <input tabindex="-1" type="checkbox" name="urdu_type" id="urdu_type"
                                                   value="1" class="custom-control-input company_info_check_box">
                                            <label class="custom-control-label chck_pdng" for="urdu_type">
                                                Urdu</label>
                                        </div>
                                        <span id="demo12" class="validate_sign"> </span>
                                    </div>
                                    <div class="invoice_col from_group col-lg-2 col-md-4 col-sm-12">
                                        <!-- invoice column start -->
                                        <div class="invoice_col_txt for_voucher_col_bx">
                                            <!-- invoice column box start -->
                                            <div class="invoice_col_txt with_cntr_jstfy">
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">

                                                    <button tabindex="7" id="first_add_more"
                                                            class="invoice_frm_btn btn btn-sm btn-info"
                                                            onclick="add_account()"
                                                            type="button">
                                                        <i class="fa fa-plus"></i> Add
                                                    </button>
                                                </div>
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                    <button style="display: none;" id="cancel_button"
                                                            class="invoice_frm_btn" onclick="cancel_all()"
                                                            type="button">
                                                        <i tabindex="-1" class="fa fa-times"></i> Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                </div>
                                <div class="invoice_row">
                                    <!-- invoice column start -->
                                    <div class="pro_tbl_con for_voucher_tbl col-lg-12">
                                        <!-- product table container start -->
                                        <div class="table-responsive  pro_tbl_bx">
                                            <!-- product table box start -->
                                            <table tabindex="-1" class="table table-bordered table-sm"
                                                   id="category_dynamic_table">
                                                <thead>
                                                <tr>
                                                    <th class="tbl_txt_80">
                                                        Outline
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody tabindex="-1" id="table_body">
                                                <tr>
                                                    <td colspan="10" align="center">
                                                        No Outline
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div><!-- product table box end -->
                                    </div><!-- product table container end -->
                                </div><!-- invoice row end -->

                                <div class="invoice_row">
                                    <!-- invoice row start -->

                                    <div class="invoice_col col-lg-12">
                                        <!-- invoice column start -->
                                        <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns">
                                            <!-- invoice column box start -->
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button tabindex="8" type="submit" name="save" id="save"
                                                        class="invoice_frm_btn btn btn-sm btn-success">
                                                    <i class="fa fa-floppy-o"></i> Save
                                                </button>
                                            </div>
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->

                            </div><!-- invoice content end -->
                        </div><!-- invoice scroll box end -->
                        <input tabindex="-1" type="hidden" name="outlines" id="outlines">
                        {{--                        <input tabindex="-1" type="hidden" name="subject_text" id="subject_text">--}}
                    </form>
                </div><!-- invoice box end -->
            </div><!-- invoice container end -->
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Subject Outline</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>
                    <div id="hello"></div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button tabindex="-1" type="button" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">
                                <i tabindex="-1" class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('public/urdu_text/yauk.min.js') }}"></script>
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let subject_id = document.getElementById("subject_id"),
                subject_group = document.getElementById("subject_group"),
                ch_no = document.getElementById("ch_no"),
                ch_name = document.getElementById("ch_name");
            validateInputIdArray = [
                subject_id.id,
                subject_group.id,
                ch_no.id,
                ch_name.id,
            ];
            return validateInventoryInputs(validateInputIdArray);
        }

        $(function () {

            $("#urdu_type").change(function () {
                var urduInput = $('#urdu_product_name');
                var ch_no = $('#ch_no');
                var ch_name = $('#ch_name');

                if ($(this).is(':checked')) {
                    // Set input to Urdu
                    urduInput.attr('lang', 'ur');
                    urduInput.attr('placeholder', 'Type in Urdu...');
                    ch_no.attr('lang', 'ur');
                    ch_no.attr('placeholder', 'Type in Urdu...');
                    ch_name.attr('lang', 'ur');
                    ch_name.attr('placeholder', 'Type in Urdu...');
                    $('#urdu_product_name').setUrduInput();
                    $('#ch_no').setUrduInput();
                    $('#ch_name').setUrduInput();
                    $('#urdu_product_name').focus();
                } else {
                    location.reload();
                }
            });
        });
    </script>
    {{-- end of required input validation --}}

    @if (Session::get('cr_id'))
        <script>
            jQuery("#table_body").html("");
            var id = '{{ Session::get('cr_id') }}';
            $(".modal-body").load('{{ url('cash_receipt_items_view_details/view/') }}/' + id, function () {
                $("#myModal").modal({
                    show: true
                });
            });
        </script>
    @endif

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
        var numberofaccounts = 0;
        var counter = 0;
        var accounts = {};
        var global_id_to_edit = 0;
        var edit_account_value = '';

        function add_account() {
            var subject_id = document.getElementById("subject_id").value;
            var subject_text = jQuery("#subject option:selected").text();
            var outline = document.getElementById("urdu_product_name").value;


            var flag_submit1 = true;
            var focus_once1 = 0;

            if (subject_id == "0") {

                if (focus_once1 == 0) {
                    jQuery("#subject").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (outline == "" || outline == '0') {


                if (focus_once1 == 0) {
                    jQuery("#urdu_product_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete accounts[global_id_to_edit];
                }

                counter++;
                jQuery("#subject").select2("destroy");


                var checkedValue = [];

                numberofaccounts = Object.keys(accounts).length;

                if (numberofaccounts == 0) {
                    jQuery("#table_body").html("");
                }


                accounts[counter] = {
                    // 'subject': subject_text,
                    'outline': outline,
                };
                numberofaccounts = Object.keys(accounts).length;
                jQuery("#table_body").append(
                    `   <tr id="${counter}" class="edit_update">
                                <td class="text-center tbl_srl_80">${outline}</td>
                                <td class="text-right tbl_srl_20">
                                    <a class="edit_link btn btn-sm btn-success" href="#" onclick="edit_account(${counter})" style="font-size: 0px;padding: 2px;">
                                        <i class="fa fa-edit" style="font-size: 10px;"></i>
                                    </a>
                                    <a href="#" class="delete_link btn btn-sm btn-danger" onclick="delete_account(${counter})" style="font-size: 0px;padding: 2px;">
                                        <i class="fa fa-trash" style="font-size: 10px;"></i>
                                    </a>
                                </td>
                            </tr>`
                )
                ;
                jQuery("#urdu_product_name").val("");

                jQuery("#outlines").val(JSON.stringify(accounts));
                console.log(JSON.stringify(accounts));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');
                jQuery("#subject").select2();
                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }

        }

        function delete_account(current_item) {

            jQuery("#" + current_item).remove();
            var temp_accounts = accounts[current_item];
            delete accounts[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#outlines").val(JSON.stringify(accounts));

            if (isEmpty(accounts)) {
                numberofaccounts = 0;
            }
            jQuery("#account_code").select2("destroy");
            jQuery("#subject").select2("destroy");
            jQuery("#account_code").select2();
            jQuery("#subject").select2();

        }

        function edit_account(current_item) {
            jQuery("#" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_accounts = accounts[current_item];

            edit_account_value = temp_accounts['account_code'];

            jQuery("#account_code").select2("destroy");
            jQuery("#subject").select2("destroy");
            // jQuery("#posting_reference").select2("destroy");
            jQuery('#account_code option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);
            jQuery('#subject option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);
            // jQuery('#posting_reference option[value="' + temp_accounts['posting_reference'] + '"]').prop('selected', true);
            jQuery("#urdu_product_name").val(temp_accounts['outline']);
            // jQuery("#account_remarks").val(temp_accounts['account_remarks']);
            jQuery("#account_code").select2();
            jQuery("#subject").select2();
            // jQuery("#posting_reference").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important;color: #fff;");
        }

        // function cancel_all() {
        //     var newvaltohide = edit_account_value;
        //     jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
        //     jQuery('#subject option[value="' + 0 + '"]').prop('selected', true);
        //     // jQuery('#posting_reference option[value="' + 0 + '"]').prop('selected', true);

        //     jQuery("#account_code").select2("destroy");
        //     jQuery("#subject").select2("destroy");
        //     // jQuery("#posting_reference").select2("destroy");

        //     // jQuery("#account_remarks").val("");
        //     jQuery("#amount").val("");

        //     jQuery("#account_code").select2();
        //     jQuery("#subject").select2();
        //     // jQuery("#posting_reference").select2();

        //     jQuery("#cancel_button").hide();

        //     jQuery("#" + global_id_to_edit).show();

        //     jQuery("#save").show();

        //     jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');
        //     global_id_to_edit = 0;

        //     jQuery(".edit_link").show();
        //     jQuery(".delete_link").show();

        //     edit_account_value = '';
        // }
    </script>
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account_code").select2();
            jQuery("#subject_id").select2();
            jQuery("#subject_group").select2();
            // jQuery("#posting_reference").select2();
        });
    </script>
    {{-- //checkbox validation --}}
    <script type="text/javascript">
        function radioValidation() {


        }
    </script>
@endsection
