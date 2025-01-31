@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">{{$title}} Journal Voucher</h4>
                    </div>
                    <div class="list_btn">
                        <a class="btn list_link add_more_button" href="{{route('journal_voucher_reference_list')}}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                    <form action="{{ route('submit_journal_voucher_reference') }}" id="f1" method="post" onsubmit="return checkForm()">
                        @csrf
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->

                                <!-- ***** upper row added here *******-->
                                <div class="collapse upper-section border_dashed m-0" id="session_accordian">
                                    <div class="row" style="">

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">Session</label>
                                                <select name="session" class="inputs_up form-control" id="session">
                                                    <option value="">Select Session</option>
                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">Business Unit</label>
                                                <select name="business_name" class="inputs_up form-control" id="business_name">
                                                    <option value="">Select Business</option>
                                                </select>
                                                <span id="demo2" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                        data-placement="bottom" data-html="true"
                                                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                        <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Remarks</label>
                                                <input type="text" name="remarks" class="inputs_up form-control" id="remarks" placeholder="Remarks" autocomplete="off">
                                                <span id="demo4" class="validate_sign"></span>
                                            </div><!-- end input box -->
                                        </div>

                                    </div>
                                </div>
                                <!-- ** upper row ended here  ***** -->


                                <div class="invoice_row"><!-- invoice row start -->

                                    <!-- use account-name-component
                                    make cash account dropdown
                                    here use class joural_voucher or bank_voucher or payable_receivable for get backend query bank account, journal voucher and payable_receivable account
                                    body="0" at the journal voucher and payable_receivable and body="1" at the bank voucher use for the query and get the index 0  for journal accounts or
                                    payable_receivable accounts and
                                    index
                                        1 for bank accounts
                                        -->

                                    <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12" hidden>
                                        <x-account-name-component tabindex="1" name="account_code" class="{{$type}}" id="account_code" title="Account Code" href="receivables_account_registration"
                                                                    body="{{$array_index}}"/>
                                    </div>

                                <!-- use account-name-component
                                    make cash account dropdown
                                    here use class joural_voucher or bank_voucher or payable_receivable for get backend query bank account, journal voucher and payable_receivable account
                                    body="0" at the journal voucher and payable_receivable and body="1" at the bank voucher use for the query and get the index 0  for journal accounts or
                                    payable_receivable accounts and
                                    index
                                        1 for bank accounts
                                        -->


                                    <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12">
                                        <x-account-name-component tabindex="2" name="account_name" class="{{$type}}" id="account_name" title="Account Title" href="receivables_account_registration" body="{{$array_index}}"/>
                                    </div>

                                    <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                        <x-posting-reference tabindex="3"/>
                                    </div>

                                <!-- use remarks-component
                                        make remarks text field  -->
                                    <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                        <x-remarks-component tabindex="4" name="account_remarks" id="account_remarks" title="Transaction Remarks"/>
                                    </div>

                                    <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.bank_voucher.bank_journal_voucher.dr_cr.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Dr./Cr.
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                {{-- Hamad set tab index--}}
                                                <select tabindex="5" name="account_type" class="inputs_up form-control" id="account_type"

                                                >
                                                    <option value="0">Select</option>
                                                    <option value="Dr">Dr</option>
                                                    <option value="Cr">Cr</option>
                                                </select>
                                                <span id="demo8" class="validate_sign"></span>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.bank_voucher.bank_journal_voucher.amount.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Amount
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                            {{--Hamad set tab index--}}
                                                <input tabindex="6" type="text" name="amount" class="inputs_up text-right form-control" id="amount" placeholder="Amount" min="1"
                                                        {{--                                                           data-rule-required="true" data-msg-required="Please Enter Amount"--}}
                                                        autocomplete="off">
                                                <span id="demo7" class="validate_sign"></span>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-2 col-md-3  col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_txt with_cntr_jstfy">
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                    <button tabindex="-1" style="display: none;" id="cancel_button" class="invoice_frm_btn btn btn-sm btn-secondary" onclick="cancel_all()" type="button">
                                                        <i class="fa fa-times"></i> Cancel
                                                    </button>
                                                </div>
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                {{--Hamad set tab index--}}
                                                    <button tabindex="7" id="first_add_more" class="invoice_frm_btn btn btn-sm btn-info" onclick="add_account()" type="button">
                                                        <i class="fa fa-plus"></i> Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->

                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                        <div class="table-responsive pro_tbl_bx"><!-- product table box start -->
                                            <table tabindex="-1" class="table table-bordered table-sm mt-2" id="category_dynamic_table">
                                                <thead>
                                                <tr>
                                                    <th tabindex="-1" class="tbl_srl_9" hidden> Code</th>
                                                    <th tabindex="-1" class="tbl_txt_20"> Title</th>
                                                    <th tabindex="-1" class="tbl_txt_20"> Posting Reference</th>
                                                    <th tabindex="-1" class="tbl_txt_33"> Transaction Remarks</th>
                                                    <th tabindex="-1" class="tbl_srl_9"> Dr.</th>
                                                    <th tabindex="-1" class="tbl_srl_9"> Cr.</th>
                                                </tr>
                                                </thead>

                                                <tbody id="table_body">
                                                <tr>
                                                    <td tabindex="-1" colspan="10" align="center">
                                                        No Account Added
                                                    </td>
                                                </tr>
                                                </tbody>

                                                <tfoot>
                                                <tr>
                                                    <th tabindex="-1" colspan="4" class="text-right">
                                                        Total Debit
                                                    </th>
                                                    <td class="tbl_srl_12">
                                                        <div class="invoice_col_txt"><!-- invoice column box start -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input tabindex="-1" type="text" name="total_debit" class="inputs_up text-right form-control grand-total-field" id="total_debit"
                                                                        data-rule-required="true" data-msg-required="Please Add"
                                                                        placeholder="0.00" readonly/>
                                                                <span id="demo16" class="validate_sign"></span>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th tabindex="-1" colspan="4" class="text-right">
                                                        Total Credit
                                                    </th>
                                                    <td class="tbl_srl_12">
                                                        <div class="invoice_col_txt"><!-- invoice column box start -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input tabindex="-1" type="number" name="total_credit" class="inputs_up text-right form-control grand-total-field" id="total_credit"
                                                                        data-rule-required="true" data-msg-required="Please Add"
                                                                        placeholder="0.00" readonly/>
                                                                <span id="demo17" class="validate_sign"></span>
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

                                    <div class="invoice_col col-lg-12"><!-- invoice column start -->
                                        <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                            <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                <button tabindex="-1" class="btn btn-primary session-button" type="button" data-toggle="collapse" data-target="#session_accordian" aria-expanded="false"
                                                        aria-controls="session_accordian">
                                                    Session Detail
                                                </button>
                                                <button tabindex="7" type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                                    <i class="fa fa-floppy-o"></i> Save
                                                </button>
                                                <span id="demo28" class="validate_sign"></span>
                                            </div>
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->


                                </div><!-- invoice row end -->

                            </div><!-- invoice content end -->
                        </div><!-- invoice scroll box end -->


                        <input tabindex="-1" type="hidden" name="accountsval" id="accountsval">


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
                    <h4 class="modal-title text-black"> Journal Voucher Detail </h4>
                    <button tabindex="-1" type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>
                    <div id="hello"></div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button tabindex="-1" type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
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
            let total_debit = document.getElementById("total_debit"),
                total_credit = document.getElementById("total_credit"),
                validateInputIdArray = [
                    total_debit.id,
                    total_credit.id,
                ];
            let checkVald = validateInventoryInputs(validateInputIdArray);
            if( total_debit.value === total_credit.value ){
                return checkVald;
            }
            else{
                alertMessageShow(total_debit.id ,'Cr and Dr Not Equal');
                return false;
            }
        }
    </script>
    {{-- end of required input validation --}}
    @if (Session::get('jv_id'))
        <script>
            jQuery("#table_body").html("");
            var id = '{{ Session::get("jv_id") }}';
            $(".modal-body").load('{{ url("journal_voucher_items_view_details/view/") }}/' + id, function () {
                $("#myModal").modal({show: true});
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

        jQuery(function () {
            jQuery(document).on('keypress', function (e) {
                var that = document.activeElement;
                if (e.which == 13) {
                    e.preventDefault();
                    jQuery('[tabIndex=' + (+that.tabIndex + 1) + ']')[0].focus();
                }
            });
        });

    </script>

    <script>
        jQuery("#account_code").change(function () {

            var account_code = jQuery('option:selected', this).val();

            jQuery("#account_name").select2("destroy");
            jQuery("#account_name").children("option[value^=" + account_code + "]");

            jQuery("#account_name > option").each(function () {
                jQuery('#account_name option[value="' + account_code + '"]').prop('selected', true);
            });

            jQuery("#account_name").select2();

        });

    </script>

    <script>
        jQuery("#account_name").change(function () {

            var account_name = jQuery('option:selected', this).val();

            jQuery("#account_code").select2("destroy");
            jQuery("#account_code").children("option[value^=" + account_name + "]");

            jQuery("#account_code > option").each(function () {
                jQuery('#account_code option[value="' + account_name + '"]').prop('selected', true);
            });

            jQuery("#account_code").select2();

        });

    </script>

    <script>
        // adding packs into table
        var numberofaccounts = 0;
        var counter = 0;
        var accounts = {};
        var global_id_to_edit = 0;

        function popvalidation() {


            var account_code = document.getElementById("account_code").value;
            var account_name = document.getElementById("account_name").value;
            var amount = document.getElementById("amount").value;
            var account_type = document.getElementById("account_type").value;
            var account_remarks = document.getElementById("account_remarks").value;
            var total_debit = document.getElementById("total_debit").value;
            var total_credit = document.getElementById("total_credit").value;
            var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            // if(remarks.trim() == "")
            // {
            //     document.getElementById("demo4").innerHTML = "";
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo4").innerHTML = "";
            // }

            if (numberofaccounts == 0) {

                if (account_code == "0") {

                    if (focus_once == 0) {
                        jQuery("#account_code").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                if (account_name == "0") {

                    if (focus_once == 0) {
                        jQuery("#account_name").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                if (amount == "" || amount == '0') {

                    if (focus_once == 0) {
                        jQuery("#amount").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    if (!validaterate(amount)) {
                        //  document.getElementById("demo11").innerHTML = "";
                        if (focus_once == 0) {
                            jQuery("#amount").focus();
                            focus_once = 1;
                        }
                        flag_submit = false;
                    } else {
                        //  document.getElementById("demo11").innerHTML = "";
                    }
                }


                if (account_type == "0") {

                    if (focus_once == 0) {
                        jQuery("#account_type").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }


                // if (account_remarks == "") {
                //
                //     if (focus_once == 0) {
                //         jQuery("#account_remarks").focus();
                //         focus_once = 1;
                //     }
                //     flag_submit = false;
                // }


                document.getElementById("demo28").innerHTML = "Press Add Button to Add Accounts";
                flag_submit = false;
            } else {
                if (total_debit != total_credit) {
                    document.getElementById("demo28").innerHTML = "Debit & Cedit Not Same";
                    flag_submit = false;
                } else {
                    document.getElementById("demo28").innerHTML = "";
                }
            }

            return flag_submit;
        }


        function add_account() {

            var account_code = document.getElementById("account_code").value;
            var account_name = document.getElementById("account_name").value;
            var account_name_text = jQuery("#account_name option:selected").text();
            var amount = document.getElementById("amount").value;
            var account_type = document.getElementById("account_type").value;
            var account_remarks = document.getElementById("account_remarks").value;
            var dr_amount = '';
            var cr_amount = '';
            var posting_reference = document.getElementById("posting_reference").value;
            var posting_reference_text = jQuery("#posting_reference option:selected").text();

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (account_code == "0") {

                if (focus_once1 == 0) {
                    jQuery("#account_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {

            }


            if (account_name == "0") {

                if (focus_once1 == 0) {
                    jQuery("#account_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {

            }
            if (posting_reference == "0") {

                if (focus_once1 == 0) {
                    jQuery("#posting_reference").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {

            }


            if (amount == "" || amount == '0') {


                if (focus_once1 == 0) {
                    jQuery("#amount").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {
                if (!validaterate(amount)) {
                    //  document.getElementById("demo11").innerHTML = "";
                    if (focus_once1 == 0) {
                        jQuery("#amount").focus();
                        focus_once1 = 1;
                    }
                    flag_submit1 = false;
                } else {
                    //  document.getElementById("demo11").innerHTML = "";
                }

            }

            if (account_type == "0") {

                if (focus_once1 == 0) {
                    jQuery("#account_type").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else {

            }

            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete accounts[global_id_to_edit];
                }

                counter++;

                jQuery("#account_code").select2("destroy");
                jQuery("#account_name").select2("destroy");
                // jQuery("#posting_reference").select2("destroy");

                var checkedValue = [];


                numberofaccounts = Object.keys(accounts).length;

                if (numberofaccounts == 0) {
                    jQuery("#table_body").html("");
                }

                accounts[counter] = [account_code, account_name_text, amount, account_type, account_remarks, posting_reference];

                if (account_type == 'Dr') {
                    dr_amount = amount;
                } else {
                    cr_amount = amount;
                }

                // jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");
                // jQuery("#account_name option[value=" + account_code + "]").attr("disabled", "true");
                numberofaccounts = Object.keys(accounts).length;
                var remarks_var = '';
                if (account_remarks != '') {
                    var remarks_var = '' + account_remarks + '';
                }


                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="tbl_srl_9" hidden>' + account_code + '</td><td class="text-left tbl_txt_20">' + account_name_text + '</td><td class="text-left tbl_txt_20">' + posting_reference_text + '</td><td ' +
                    'class="text-left tbl_txt_33">' + remarks_var + '</td><td class="text-right tbl_srl_9">' + dr_amount + '</td><td class="text-right tbl_srl_9">' + cr_amount + '<div ' +
                    'class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_account(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#account_type option[value="' + 0 + '"]').prop('selected', true);
                // jQuery('#posting_reference option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#amount").val("");
                jQuery("#account_remarks").val("");

                jQuery("#accountsval").val(JSON.stringify(accounts));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                var total_dr = 0;
                var total_cr = 0;

                jQuery.each(accounts, function (index, value) {

                    if (value[3] == 'Dr') {
                        total_dr = +total_dr + +value[2];
                    } else {
                        total_cr = +total_cr + +value[2];
                    }
                });

                jQuery("#total_debit").val(total_dr);
                jQuery("#total_credit").val(total_cr);

                jQuery("#account_code").select2();
                jQuery("#account_name").select2();
                // jQuery("#posting_reference").select2();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }


        function delete_account(current_item) {

            jQuery("#" + current_item).remove();
            var temp_accounts = accounts[current_item];
            // jQuery("#account_code option[value=" + temp_accounts[0] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts[0] + "]").attr("disabled", false);

            delete accounts[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#accountsval").val(JSON.stringify(accounts));

            if (isEmpty(accounts)) {
                numberofaccounts = 0;
            }

            var total_dr = 0;
            var total_cr = 0;

            jQuery.each(accounts, function (index, value) {

                if (value[3] == 'Dr') {
                    total_dr = +total_dr + +value[2];

                } else {
                    total_cr = +total_cr + +value[2];

                }
            });

            jQuery("#total_debit").val(total_dr);
            jQuery("#total_credit").val(total_cr);

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();

        }


        function edit_account(current_item) {

            // jQuery(".table-responsive").attr("style", "display:none");
            jQuery("#" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_accounts = accounts[current_item];

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");
            jQuery("#posting_reference").select2("destroy");

            jQuery("#account_code").children("option[value^=" + temp_accounts[0] + "]").show(); //showing hid unit
            // jQuery("#account_code option[value=" + temp_accounts[0] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts[0] + "]").attr("disabled", false);
            jQuery("#account_code > option").each(function () {
                jQuery('#account_code option[value="' + temp_accounts[0] + '"]').prop('selected', true);
            });
            jQuery('#posting_reference option[value="' + temp_accounts[5] + '"]').prop('selected', true);

            jQuery("#account_name").val(temp_accounts[0]);
            jQuery("#amount").val(temp_accounts[2]);
            jQuery("#account_type").val(temp_accounts[3]);
            jQuery("#account_remarks").val(temp_accounts[4]);


            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#posting_reference").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            var newvaltohide = jQuery("#account_code").val();

            // jQuery("#account_code option[value=" + newvaltohide + "]").attr("disabled", "true");
            // jQuery("#account_name option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#posting_reference option[value="' + 0 + '"]').prop('selected', true);
            jQuery("#account_code").select2("destroy");

            jQuery("#account_name").select2("destroy");
            jQuery("#posting_reference").select2("destroy");

            jQuery("#account_type").val("");
            jQuery("#account_remarks").val("");
            jQuery("#amount").val("");

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#posting_reference").select2();

            jQuery("#cancel_button").hide();

            // jQuery(".table-responsive").show();
            jQuery("#" + global_id_to_edit).show();

            jQuery("#save").show();

            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');
            global_id_to_edit = 0;

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();
        }

        function validaterate(pas) {
            var pass = /^\d*\.?\d*$/;

            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }
    </script>

    <style type="text/css">

        /* Hide HTML5 Up and Down arrows. */
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        .border_dashed {
            border-bottom: 2px dashed grey;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .lower_dashed {
            border-left: 2px dashed grey;
            /*padding-top: 20px;
            margin-top: 20px;   */
        }

        .shadowed {
            margin-top: 20px;
            margin-bottom: 20px;
            min-height: 300px !important;
            max-height: 320px !important;
            overflow-y: scroll;
            box-shadow: 3px 3px 3px 3px grey;
        }
    </style>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#posting_reference").select2();

        });
    </script>

@endsection

