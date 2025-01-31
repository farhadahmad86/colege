@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Fixed Asset Voucher</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('fixed_asset_voucher_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->
                    <form id="f1" action="{{ route('submit_fixed_asset_voucher') }}" method="post" onsubmit="return checkForm()">
                        @csrf
                        <div class="invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="invoice_cntnt"><!-- invoice content start -->
                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="invoice_col form-group col-lg-4 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->

                                                Fixed Asset Account
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->

                                                </div><!-- invoice column short end -->
                                                <select tabindex="1" autofocus name="account" class="inputs_up form-control" id="account" data-rule-required="true"
                                                        data-msg-required="Please Enter Cash Account">
                                                    <option value="">Select Fixed Asset Account</option>
                                                    @foreach($fixedAssetAccountList as $fix_asset_account)
                                                        <option value="{{$fix_asset_account['code']}}" data-balance="{{$fix_asset_account['balance']}}">{{$fix_asset_account['code']}} -
                                                            {{$fix_asset_account['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <!-- use remarks-component
                                        make remarks text field  -->
                                    <div class="invoice_col form-group col-lg-4 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <x-remarks-component tabindex="2" name="remarks" id="remarks" title="Voucher Remarks"/>
                                    </div>

                                    <div class="invoice_col form-group col-lg-4 col-md-4 col-sm-12 hidden">
                                        <!-- invoice column start -->
                                        <input class="form-check-input" type="radio" name="status" value="post" id="post"
                                            checked>
                                        {{--<x-voucher-status-component value="" />--}}
                                    </div>


                                    <input type="hidden" name="balance" id="balance">

                                    <div class="project_box project_show invoice_col form-group col-lg-4 col-md-4 col-sm-12">
                                        <!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                Total Balance
                                            </label><!-- invoice column title end -->
                                            <div class="invoice_col_txt"><!-- invoice column input start -->
                                                <h5 class="grandTotalFont" id="balanceView">
                                                    0
                                                </h5>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                    <div class="project_box project_show invoice_col form-group col-lg-4 col-md-4 col-sm-12">
                                    <span id="bal_error" style="color: red"></span>
                                    </div>
                                </div><!-- invoice row end -->

                                <div class="invoice_row"><!-- invoice row start -->

                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12" hidden><!-- invoice column start -->

                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Account Code
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                </div><!-- invoice column short end -->
                                                <select tabindex="3" name="account_code" class="inputs_up form-control" id="account_code">
                                                    <option value="0">Account Code</option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{$account->account_uid}}">{{$account->account_uid}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->


                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->

                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Account Title
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->

                                                <div class="invoice_col_short"><!-- invoice column short start -->
{{--                                                    <a href="{{ route('account_registration') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover"--}}
{{--                                                        data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
{{--                                                        <i class="fa fa-plus"></i>--}}
{{--                                                    </a>--}}
{{--                                                    <a id="refresh_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"--}}
{{--                                                        data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
{{--                                                        <i class="fa fa-refresh"></i>--}}
{{--                                                    </a>--}}
                                                </div><!-- invoice column short end -->
                                                <select tabindex="4" name="account_name" class="inputs_up form-control" id="account_name">
                                                    <option value="0">Account Title</option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{$account->account_uid}}">{{$account->account_uid}} - {{$account->account_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <!-- use posting-reference-component
                                        make posting-reference dropdown  -->
                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <x-posting-reference tabindex="4"/>
                                    </div>

                                    <!-- use remarks-component
                                make remarks text field -->

                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <x-remarks-component tabindex="5" name="account_remarks" id="account_remarks" title="Transaction Remarks"/>
                                    </div>

                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.amount.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Amount
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <input tabindex="6" type="text" name="amount" class="inputs_up text-right form-control" id="amount" placeholder="Amount" min="1"
                                                        onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-2 col-md-4 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_txt with_cntr_jstfy">
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                    <button style="display: none;" id="cancel_button" class="invoice_frm_btn btn btn-sm btn-secondary" onclick="cancel_all()" type="button">
                                                        <i tabindex="-1" class="fa fa-times"></i> Cancel
                                                    </button>
                                                </div>
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
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
                                            <table tabindex="-1" class="table table-bordered table-sm" id="category_dynamic_table">
                                                <thead>
                                                <tr>
                                                    <th tabindex="-1" class="tbl_srl_9"> Code</th>
                                                    <th tabindex="-1" class="tbl_txt_20"> Title</th>
                                                    <th tabindex="-1" class="tbl_txt_20"> Posting Reference</th>
                                                    <th tabindex="-1" class="tbl_txt_38"> Transaction Remarks</th>
                                                    <th tabindex="-1" class="tbl_srl_12"> Amount</th>
                                                </tr>
                                                </thead>

                                                <tbody tabindex="-1" id="table_body">
                                                <tr>
                                                    <td colspan="10" align="center">
                                                        No Account Added
                                                    </td>
                                                </tr>
                                                </tbody>

                                                <tfoot>
                                                <tr>
                                                    <th tabindex="-1" colspan="3" class="text-right">
                                                        Total
                                                    </th>

                                                    <td tabindex="-1" class="tbl_srl_12">
                                                        <div class="invoice_col_txt"><!-- invoice column box start -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input tabindex="-1" type="text" name="total_amount" class="inputs_up text-right form-control" id="total_amount"
                                                                        placeholder="0.00" readonly data-rule-required="true" data-msg-required="Please Add"/>
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
                                                <button tabindex="8" type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                                    <i class="fa fa-floppy-o"></i> Save
                                                </button>
                                            </div>
                                        </div><!-- invoice column box end -->

                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->

                            </div><!-- invoice content end -->
                        </div><!-- invoice scroll box end -->
                        <input tabindex="-1" type="hidden" name="accountsval" id="accountsval">
                        <input tabindex="-1" type="hidden" name="account_name_text" id="account_name_text">
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
                    <h4 class="modal-title text-black">Cash Receipt Voucher Detail</h4>
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
                            <button tabindex="-1" type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
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
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let account = document.getElementById("account"),
                totalAmount = document.getElementById("total_amount"),
                balance = document.getElementById("balance");
            validateInputIdArray = [
                account.id,
                totalAmount.id,
            ];
            let checkValid = validateInventoryInputs(validateInputIdArray);

            if (checkValid == true) {
                if (parseFloat(totalAmount.value) >= parseFloat(balance.value)) {
                    return checkValid;
                } else {
                    document.getElementById("bal_error").innerHTML='Total Amount Greater or Equal To Balance';
                    // alertMessageShow(total_debit.id, );
                    return false;

                }
                return false;
            }
            return false;
        }
    </script>
    {{-- end of required input validation --}}

    @if (Session::get('fav_id'))
        <script>
            jQuery("#table_body").html("");
            var id = '{{ Session::get("fav_id") }}';
            $(".modal-body").load('{{ url('fixed_asset_items_view_details/view/') }}/' + id, function () {
                // jQuery(".pre-loader").fadeToggle("medium");
                $("#myModal").modal({show: true});
            });
        </script>
    @endif

    <script>
        jQuery("#account").change(function () {
            var balance = $('option:selected', this).attr('data-balance');
            $('#balance').val(balance);
            document.getElementById("balanceView").innerHTML = balance;

        });
    </script>

    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                $("#first_add_more").click();
                // event.preventDefault();
                return false;
            }
        });
        jQuery("#refresh_account").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_cash_receipt",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#account").html(" ");
                    jQuery("#account").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
        // refesh account code and name
        // jQuery("#refresh_account_code").click(function() {
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "refresh_accounts_code",
        //         data:{},
        //         type: "POST",
        //         cache:false,
        //         dataType: 'json',
        //         success:function(data){
        //
        //             jQuery("#account_code").html(" ");
        //             jQuery("#account_code").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
        //             alert(errorThrown);}
        //     });
        // });
        // jQuery("#refresh_account_code").click(function() {
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "refresh_accounts_name",
        //         data:{},
        //         type: "POST",
        //         cache:false,
        //         dataType: 'json',
        //         success:function(data){
        //
        //             jQuery("#account_name").html(" ");
        //             jQuery("#account_name").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
        //             alert(errorThrown);}
        //     });
        // });
        // jQuery("#refresh_account_name").click(function() {
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "refresh_accounts_code",
        //         data:{},
        //         type: "POST",
        //         cache:false,
        //         dataType: 'json',
        //         success:function(data){
        //
        //             jQuery("#account_code").html(" ");
        //             jQuery("#account_code").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
        //             alert(errorThrown);}
        //     });
        // });
        // jQuery("#refresh_account_name").click(function() {
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "refresh_accounts_name",
        //         data:{},
        //         type: "POST",
        //         cache:false,
        //         dataType: 'json',
        //         success:function(data){
        //
        //             jQuery("#account_name").html(" ");
        //             jQuery("#account_name").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
        //             alert(errorThrown);}
        //     });
        // });
    </script>
    <script>
        jQuery("#account").change(function () {
            var account_name_text = jQuery("option:selected", this).text();
            jQuery("#account_name_text").val(account_name_text);
        });
    </script>
    <script>
        jQuery("#account_code").change(function () {

            var account_code = jQuery('option:selected', this).val();

            jQuery("#account_name").select2("destroy");
            jQuery('#account_name option[value="' + account_code + '"]').prop('selected', true);
            jQuery("#account_name").select2();
        });
    </script>
    <script>
        jQuery("#account_name").change(function () {
            var account_name = jQuery('option:selected', this).val();
            jQuery("#account_code").select2("destroy");
            jQuery('#account_code option[value="' + account_name + '"]').prop('selected', true);
            jQuery("#account_code").select2();
        });
    </script>
    <script>
        // adding packs into table
        var numberofaccounts = 0;
        var counter = 0;
        var accounts = {};
        var global_id_to_edit = 0;
        var edit_account_value = '';

        function popvalidation() {
            var account = document.getElementById("account").value;
            var account_code = document.getElementById("account_code").value;
            var account_name = document.getElementById("account_name").value;
            var amount = document.getElementById("amount").value;
            var account_remarks = document.getElementById("account_remarks").value;
            var remarks = document.getElementById("remarks").value;
            var flag_submit = true;
            var focus_once = 0;
            if (account == "") {

                if (focus_once == 0) {
                    jQuery("#account").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }
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
                }
                document.getElementById("demo28").innerHTML = "Add Accounts";
                flag_submit = false;
            } else {
                document.getElementById("demo28").innerHTML = "";
            }
            return flag_submit;
        }

        function add_account() {

            var account_code = document.getElementById("account_code").value;
            var account_name = document.getElementById("account_name").value;
            var account_name_text = jQuery("#account_name option:selected").text();
            var amount = document.getElementById("amount").value;
            var account_remarks = document.getElementById("account_remarks").value;
            var posting_reference = document.getElementById("posting_reference").value;
            var posting_reference_text = jQuery("#posting_reference option:selected").text();


            var flag_submit1 = true;
            var focus_once1 = 0;

            if (account_code == "0") {

                if (focus_once1 == 0) {
                    jQuery("#account_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (account_name == "0") {

                if (focus_once1 == 0) {
                    jQuery("#account_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (posting_reference == "0") {

                if (focus_once1 == 0) {
                    jQuery("#posting_reference").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (amount == "" || amount == '0') {


                if (focus_once1 == 0) {
                    jQuery("#amount").focus();
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

                jQuery("#account_code").select2("destroy");
                jQuery("#account_name").select2("destroy");
                // jQuery("#posting_reference").select2("destroy");

                var checkedValue = [];


                if (remarks == '') {
                    remarks = account_name;
                }
                numberofaccounts = Object.keys(accounts).length;

                if (numberofaccounts == 0) {
                    jQuery("#table_body").html("");
                }

                accounts[counter] = {
                    'account_code': account_code,
                    'account_name': account_name_text,
                    'account_amount': amount,
                    'account_remarks': account_remarks,
                    'posting_reference': posting_reference,
                    'posting_reference_name': posting_reference_text,
                };

                // jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");
                // jQuery("#account_name option[value=" + account_code + "]").attr("disabled", "true");
                numberofaccounts = Object.keys(accounts).length;
                var remarks_var = '';
                if (account_remarks != '') {
                    var remarks_var = '' + account_remarks + '';
                }


                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="tbl_srl_9">' + account_code + '</td><td class="text-left tbl_txt_20">' + account_name_text + '</td><td ' +
                    'class="text-left tbl_txt_20">' + posting_reference_text + '</td><td ' +
                    'class="text-left tbl_txt_38">' + remarks_var + '</td><td class="text-right tbl_srl_12">' + amount + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_account(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
                // jQuery('#posting_reference option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#amount").val("");
                jQuery("#account_remarks").val("");

                jQuery("#accountsval").val(JSON.stringify(accounts));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#account_code").select2();
                jQuery("#account_name").select2();
                // jQuery("#posting_reference").select2();

                total_calculation();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }

        function total_calculation() {
            var total_amount = 0;

            jQuery.each(accounts, function (index, value) {
                total_amount = +total_amount + +value['account_amount'];
            });

            jQuery("#total_amount").val(total_amount);
        }

        function delete_account(current_item) {

            jQuery("#" + current_item).remove();
            var temp_accounts = accounts[current_item];
            // jQuery("#account_code option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);

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

            total_calculation();

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

            edit_account_value = temp_accounts['account_code'];

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");
            jQuery("#posting_reference").select2("destroy");


            // jQuery("#account_code option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);

            jQuery('#account_code option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);
            jQuery('#account_name option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);
            jQuery('#posting_reference option[value="' + temp_accounts['posting_reference'] + '"]').prop('selected', true);

            jQuery("#amount").val(temp_accounts['account_amount']);
            jQuery("#account_remarks").val(temp_accounts['account_remarks']);


            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#posting_reference").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important;color: #fff;");
        }

        function cancel_all() {

            // var newvaltohide = jQuery("#account_code").val();

            var newvaltohide = edit_account_value;

            // jQuery("#account_code option[value=" + newvaltohide + "]").attr("disabled", "true");
            // jQuery("#account_name option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#posting_reference option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");
            jQuery("#posting_reference").select2("destroy");

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

            edit_account_value = '';
        }
    </script>
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#account").select2();
            jQuery("#posting_reference").select2();
        });
    </script>

@endsection

