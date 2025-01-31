
@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            {{--                <div class="page-header">--}}
            {{--                        <div class="row">--}}
            {{--                            <div class="col-md-6 col-sm-12">--}}
            {{--                                <nav aria-label="breadcrumb" role="navigation">--}}
            {{--                                    <ol class="breadcrumb">--}}
            {{--                                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>--}}
            {{--                                        <li class="breadcrumb-item active" aria-current="page">Create Advance Salary</li>--}}
            {{--                                    </ol>--}}
            {{--                                </nav>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Create Advance Salary</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('advance_salary_list') }}" role="button" target="_blank">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{ route('submit_advance_salary') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.advanced_salary.advance_paid_account.description')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Advance Payment Account
                                    <a href="{{ route('salary_account_registration') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                        <l class="fa fa-plus"></l>
                                    </a>
                                    <a id="refresh_issue_by" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                        <l class="fa fa-refresh"></l>
                                    </a>
                                </label>
                                <select tabindex="1" autofocus name="from" class="inputs_up form-control" id="from" data-rule-required="true" data-msg-required="Please Enter Advanced Payment Account">
                                    <option value="">Select Advance Payment Account</option>
                                    <option value="1">1</option>
                                    {{--                                                    @foreach($pay_accounts as $pay_account)--}}
{{--                                                        <option value="{{$pay_account->account_uid}}">{{$pay_account->account_name}}</option>--}}
{{--                                                    @endforeach--}}
                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div><!-- end input box -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.advanced_salary.advance_employee_account.description')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Advance Employee Account
                                    <a href="{{ route('add_employee') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                        <l class="fa fa-plus"></l>
                                    </a>

                                    <a id="refresh_issue_to" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}" >
                                        <l class="fa fa-refresh"></l>
                                    </a>
                                </label>
                                <select tabindex="2" name="to" class="inputs_up form-control" id="to" data-rule-required="true" data-msg-required="Please Enter Advance Employee Account">
                                    <option value="">Select Advance Employee Account</option>
                                    <option value="1">1</option>
                                    {{--                                                    @foreach($advance_salary_accounts as $advance_salary_account)--}}
                                    {{--                                                        <option value="{{$advance_salary_account->account_uid}}">{{$advance_salary_account->account_name}}</option>--}}
                                    {{--                                                    @endforeach--}}

                                </select>
                                <span id="demo2" class="validate_sign"> </span>
                            </div><!-- end input box -->
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
                                <textarea tabindex="4" name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks" style="height: 32px;" > </textarea>
                                <span id="demo5" class="validate_sign"> </span>
                            </div><!-- end input box -->
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                       data-placement="bottom" data-html="true"
                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.salary_voucher.advanced_salary.amount.description')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Amount</label>
                                <input tabindex="3" type="text" name="amount" id="amount" class="inputs_up form-control"  data-rule-required="true" data-msg-required="Please Enter Amount" placeholder="Amount" onkeypress="return isNumberKey(event)"/>
                                <span id="demo3" class="validate_sign"> </span>
                            </div><!-- end input box -->
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="invoice_col basis_col_23"><!-- invoice column start -->
                                <div class="invoice_col_txt for_voucher_col_bx"><!-- invoice column box start -->
                                    <div class="invoice_col_txt with_cntr_jstfy">
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button tabindex="7" id="first_add_more" class="invoice_frm_btn" onclick="add_account()" type="button" style="margin-top: 24px">
                                                <i class="fa fa-plus"></i> Add
                                            </button>
                                        </div>
                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                            <button style="display: none;" id="cancel_button" class="invoice_frm_btn" onclick="cancel_all()" type="button">
                                                <i tabindex="-1" class="fa fa-times"></i> Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div><!-- invoice column box end -->
                            </div><!-- invoice column end -->
                        </div>
                    </div>
                    <div class="invoice_row"><!-- invoice row start -->

                        <div class="invoice_col basis_col_100"><!-- invoice column start -->
                            <div class="invoice_row"><!-- invoice row start -->

                                <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                    <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                        <div class="pro_tbl_bx"><!-- product table box start -->
                                            <table tabindex="-1" class="table gnrl-mrgn-pdng" id="category_dynamic_table">
                                                <thead>
                                                <tr>
                                                    <th tabindex="-1" class="text-center tbl_srl_9"> Advance Employee Account</th>
                                                    <th tabindex="-1" class="text-center tbl_txt_20"> Remarks</th>
                                                    <th tabindex="-1" class="text-center tbl_srl_12"> Amount</th>
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
                                                    <td tabindex="-1" class="text-center tbl_srl_12">
                                                        <div class="invoice_col_txt"><!-- invoice column box start -->
                                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                                <input tabindex="-1" type="text" name="total_amount" class="inputs_up text-right form-control" id="total_amount" placeholder="0.00" readonly data-rule-required="true" data-msg-required="Please Add"/>
                                                            </div><!-- invoice column input end -->
                                                        </div><!-- invoice column box end -->
                                                    </td>
                                                </tr>
                                                </tfoot>

                                            </table>
                                        </div><!-- product table box end -->
                                    </div><!-- product table container end -->
                                </div><!-- invoice column end -->


                            </div><!-- invoice row end -->
                        </div><!-- invoice column end -->

                    </div><!-- invoice row end -->
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                            <button tabindex="5" type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                <i class="fa fa-eraser"></i> Cancel
                            </button>
                            <button tabindex="6" type="submit" name="save" id="save" class="save_button form-control"
                            >
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let from = document.getElementById("from"),
                to = document.getElementById("to"),
                amount = document.getElementById("amount");
            validateInputIdArray = [
                from.id,
                to.id,
                amount.id,
            ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}

{{--    Hamza Multi Rows Insert--}}
    @if (Session::get('cr_id'))
        <script>
            jQuery("#table_body").html("");
            var id = '{{ Session::get("cr_id") }}';
            $(".modal-body").load('{{ url('cash_receipt_items_view_details/view/') }}/'+id, function () {
                // jQuery(".pre-loader").fadeToggle("medium");
                $("#myModal").modal({show:true});
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
{{--    <script>--}}
{{--        jQuery("#account").change(function () {--}}
{{--            var account_name_text = jQuery("option:selected", this).text();--}}
{{--            jQuery("#account_name_text").val(account_name_text);--}}
{{--        });--}}
{{--    </script>--}}
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
        // function popvalidation() {
        //     var account = document.getElementById("account").value;
        //     var account_code = document.getElementById("account_code").value;
        //     var account_name = document.getElementById("account_name").value;
        //     var amount = document.getElementById("amount").value;
        //     var account_remarks = document.getElementById("account_remarks").value;
        //     var remarks = document.getElementById("remarks").value;
        //     var flag_submit = true;
        //     var focus_once = 0;
        //     if (account == "") {
        //
        //         if (focus_once == 0) {
        //             jQuery("#account").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     }
        //     if (numberofaccounts == 0) {
        //         if (account_code == "0") {
        //
        //             if (focus_once == 0) {
        //                 jQuery("#account_code").focus();
        //                 focus_once = 1;
        //             }
        //             flag_submit = false;
        //         }
        //         if (account_name == "0") {
        //
        //             if (focus_once == 0) {
        //                 jQuery("#account_name").focus();
        //                 focus_once = 1;
        //             }
        //             flag_submit = false;
        //         }
        //         if (amount == "" || amount == '0') {
        //
        //             if (focus_once == 0) {
        //                 jQuery("#amount").focus();
        //                 focus_once = 1;
        //             }
        //             flag_submit = false;
        //         }
        //         document.getElementById("demo28").innerHTML = "Add Accounts";
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("demo28").innerHTML = "";
        //     }
        //     return flag_submit;
        // }
        function add_account() {

            var to = document.getElementById("to").value;
            // var account_name = document.getElementById("amount").value;
            // var account_name_text = jQuery("#account_name option:selected").text();
            var amount = document.getElementById("amount").value;
            var remarks = document.getElementById("remarks").value;
            var flag_submit1 = true;
            var focus_once1 = 0;

            if (to == "") {
                if (focus_once1 == 0) {
                    jQuery("#to").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            // if (account_name == "0") {
            //
            //     if (focus_once1 == 0) {
            //         jQuery("#account_name").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // }


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

                jQuery("#to").select2("destroy");
                // jQuery("#account_name").select2("destroy");

                var checkedValue = [];


                // if (remarks == '') {
                //     remarks = account_name;
                // }
                numberofaccounts = Object.keys(accounts).length;

                if (numberofaccounts == 0) {
                    jQuery("#table_body").html("");
                }

                accounts[counter] = {
                    'to': to,
                    // 'account_name': account_name_text,
                    'account_amount': amount,
                    'remarks': remarks,
                };

                // jQuery("#to option[value=" + to + "]").attr("disabled", "true");
                // jQuery("#account_name option[value=" + to + "]").attr("disabled", "true");
                numberofaccounts = Object.keys(accounts).length;
                var remarks_var = '';
                if (remarks != '') {
                    var remarks_var = '' + remarks + '';
                }


                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + to + '</td><td class="text-left tbl_txt_58">' + remarks_var + '</td><td class="text-right tbl_srl_12">' + amount + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_account(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#to option[value="' + 0 + '"]').prop('selected', true);
                // jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#amount").val("");
                jQuery("#remarks").val("");

                jQuery("#accountsval").val(JSON.stringify(accounts));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#to").select2();
                // jQuery("#account_name").select2();

                total_calculation();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }
        function total_calculation(){
            var total_amount = 0;

            jQuery.each(accounts, function (index, value) {
                total_amount = +total_amount + +value['account_amount'];
            });

            jQuery("#total_amount").val(total_amount);
        }
        function delete_account(current_item) {

            jQuery("#" + current_item).remove();
            var temp_accounts = accounts[current_item];
            // jQuery("#to option[value=" + temp_accounts['to'] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts['to'] + "]").attr("disabled", false);

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

            jQuery("#to").select2("destroy");
            // jQuery("#account_name").select2("destroy");

            jQuery("#to").select2();
            // jQuery("#account_name").select2();

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

            edit_account_value = temp_accounts['to'];

            jQuery("#to").select2("destroy");
            // jQuery("#account_name").select2("destroy");


            // jQuery("#to option[value=" + temp_accounts['to'] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts['to'] + "]").attr("disabled", false);

            jQuery('#to option[value="' + temp_accounts['to'] + '"]').prop('selected', true);
            // jQuery('#account_name option[value="' + temp_accounts['to'] + '"]').prop('selected', true);

            jQuery("#amount").val(temp_accounts['account_amount']);
            jQuery("#remarks").val(temp_accounts['remarks']);


            jQuery("#to").select2();
            // jQuery("#account_name").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important;color: #fff;");
        }
        function cancel_all() {

            // var newvaltohide = jQuery("#to").val();

            var newvaltohide = edit_account_value;

            // jQuery("#to option[value=" + newvaltohide + "]").attr("disabled", "true");
            // jQuery("#account_name option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery('#to option[value="' + 0 + '"]').prop('selected', true);
            // jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#to").select2("destroy");
            // jQuery("#account_name").select2("destroy");

            jQuery("#remarks").val("");
            jQuery("#amount").val("");

            jQuery("#to").select2();
            // jQuery("#account_name").select2();

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
{{--    End of Hamza Multi Rows Insert--}}

    <script>
        jQuery("#refresh_issue_by").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_advance_payment",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#from").html(" ");
                    jQuery("#from").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });
        jQuery("#refresh_issue_to").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_advance_salary_issue_to",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){
                    console.log(data)

                    jQuery("#to").html(" ");
                    jQuery("#to").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });
    </script>
    <script type="text/javascript">
        function form_validation()
        {
            var from  = document.getElementById("from").value;
            var to  = document.getElementById("to").value;
            var amount  = document.getElementById("amount").value;

            var remarks  = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            // if(from.trim() == "")
            // {
            //     document.getElementById("demo1").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#from").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo1").innerHTML = "";
            // }
            //
            // if(to.trim() == "")
            // {
            //     document.getElementById("demo2").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#to").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo2").innerHTML = "";
            // }
            //
            // if(amount.trim() == "")
            // {
            //     document.getElementById("demo3").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#amount").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     if (!validaterate(amount)) {
            //         document.getElementById("demo3").innerHTML = "Wrong Entry";
            //         if (focus_once == 0) {
            //             jQuery("#amount").focus();
            //             focus_once = 1;
            //         }
            //         flag_submit = false;
            //     }
            //     else {
            //         document.getElementById("demo3").innerHTML = "";
            //     }
            //
            // }



            // if(remarks.trim() == "")
            // {
            //     document.getElementById("demo2").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo2").innerHTML = "";
            // }
            return flag_submit;
        }
    </script>
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#to").select2();
            jQuery("#from").select2();

        });
        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
        function validaterate(pas) {
            var pass = /^\d*\.?\d*$/;

            if (pass.test(pas)) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection


