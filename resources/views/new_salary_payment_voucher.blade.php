@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">New Salary Payment Voucher</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('salary_payment_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->
                            <form id="f1" action="{{ route('submit_salary_payment') }}" method="post" onsubmit="return checkForm()">
                                @csrf
                                <div class="invoice_row"><!-- invoice row start -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.cash_account.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Pay Account
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->

                                                </div><!-- invoice column short end -->
                                                <select tabindex="1" autofocus name="account" class="inputs_up form-control" id="account" data-rule-required="true"
                                                        data-msg-required="Please
                                                    Enter
                                                    Cash Account">
                                                    <option value="">Select Pay Account</option>
                                                    @foreach($pay_accounts as $pay_account)
                                                        <option value="{{$pay_account->account_uid}}">{{$pay_account->account_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Voucher Remarks
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <input tabindex="2" type="text" name="remarks" class="inputs_up form-control" id="remarks" placeholder="Remarks">
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="invoice_col_ttl"><!-- invoice column title start -->
                                                <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Month
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <input tabindex="2" type="text" name="month" id="month" class="inputs_up form-control month-picker" autocomplete="off" value=""
                                                       data-rule-required="true"
                                                       data-msg-required="Please Enter Month"
                                                       placeholder="Start Month ......">
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->


                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.code.description')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Department
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->

                                                </div><!-- invoice column short end -->
                                                <select tabindex="3" name="department" class="inputs_up form-control" id="department" data-rule-required="true"
                                                        data-msg-required="Please Select Department">
                                                    <option value="0">Department</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{$department->dep_id}}">{{$department->dep_title}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                    <input tabindex="-1" type="hidden" name="accountsval" id="accountsval">
                                </div><!-- invoice row end -->
                                <div class="invoice_row row"><!-- invoice row start -->
                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Total Payable Amount
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                <div class="invoice_col_short"><!-- invoice column short start -->
                                                </div><!-- invoice column short end -->
                                                <input tabindex="-1" type="text" name="total_payable_amount" class="inputs_up text-right form-control" id="total_payable_amount"
                                                       placeholder="0.00" readonly data-rule-required="true" data-msg-required="Please Add"/>
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                    <div class="col-lg-9 text-right"><!-- invoice column start -->
                                        <button tabindex="8" type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->
                            </form>
                            <div class="invoice_row"><!-- invoice row start -->
                                <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                    <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                        <div class="table-responsive" id="printTable"><!-- product table box start -->
                                            <table tabindex="-1" class="table table-bordered table-sm" id="fixTable">
                                                <thead>
                                                <tr>
                                                    <th tabindex="-1" class="tbl_srl_4"> Sr.</th>
                                                    <th tabindex="-1" class="tbl_srl_14"> Department</th>
                                                    <th tabindex="-1" class="tbl_srl_9"> Code</th>
                                                    <th tabindex="-1" class="tbl_txt_20"> Title</th>
                                                    <th tabindex="-1" class="tbl_txt_15"> Net Salary</th>
                                                    <th tabindex="-1" class="tbl_txt_15"> Advance Received Against Salary</th>
                                                    <th tabindex="-1" class="tbl_txt_15"> Payment</th>
                                                    <th tabindex="-1" class="tbl_srl_12"> Balance</th>
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
                                                    <th tabindex="-1" colspan="7" class="text-right">
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
                                </div><!-- invoice column end -->
                            </div><!-- invoice row end -->
                        </div><!-- invoice content end -->
                    </div><!-- invoice scroll box end -->

                    <input tabindex="-1" type="hidden" name="account_name_text" id="account_name_text">

                </div><!-- invoice box end -->
            </div><!-- invoice container end -->
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Advance Salary Voucher Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

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
    <script src="{{ asset('public/plugins/nabeel_blue/jquery.floatThead.js') }}"></script>
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            jQuery("#accountsval").val('');
            const jsonData = {};
            $('input[name="employee_id[]"]').each(function (pro_index) {
                var employee_id = $(this).val();
                var department_id = $('#department_id' + employee_id).val();
                var department_name = $('#department_name' + employee_id).val();
                var account_code = $('#account_code' + employee_id).val();
                var account_name = $('#account_name' + employee_id).val();
                var net_salary = $('#net_salary' + employee_id).val();
                var adv_salary_led_bal = $('#adv_salary_led_bal' + employee_id).val();
                var payment_amount = $('#payment_amount' + employee_id).val();
                if (payment_amount != 0) {
                    jsonData[pro_index] = {
                        'employee_id': employee_id,
                        'department': department_id,
                        'department_name': department_name,
                        'account_code': account_code,
                        'account_name': account_name,
                        'net_salary': net_salary,
                        'adv_salary_led_bal': adv_salary_led_bal,
                        'payment_amount': payment_amount,
                    };
                }
            });
            jQuery("#accountsval").val(JSON.stringify(jsonData));
            let account = document.getElementById("account"),
                month = document.getElementById("month"),
                department = document.getElementById("department"),
                totalAmount = document.getElementById("total_amount"),
                totalPayableAmount = document.getElementById("total_payable_amount"),
                validateInputIdArray = [
                    account.id,
                    month.id,
                    department.id,
                    totalAmount.id,
                    totalPayableAmount.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}

    @if (Session::get('cr_id'))
        <script>
            jQuery("#table_body").html("");
            var id = '{{ Session::get("cr_id") }}';
            $(".modal-body").load('{{ url('cash_receipt_items_view_details/view/') }}/' + id, function () {
                // jQuery(".pre-loader").fadeToggle("medium");
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
        jQuery("#refresh_account_code").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_accounts_code",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#account_code").html(" ");
                    jQuery("#account_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
        jQuery("#refresh_account_code").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_accounts_name",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#account_name").html(" ");
                    jQuery("#account_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
        jQuery("#refresh_account_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_accounts_code",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#account_code").html(" ");
                    jQuery("#account_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
        jQuery("#refresh_account_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_accounts_name",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#account_name").html(" ");
                    jQuery("#account_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
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
        jQuery(document).ready(function () {
            $('table').floatThead({
                position: 'absolute'
            });
            // Initialize select2
            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#account").select2();
            jQuery("#department").select2();
        });
    </script>
    <script>
        $('#department').change(function () {
            var department_id = $(this).val();
            var department_text = jQuery("#department option:selected").text();
            get_employee(department_id, department_text);
        });

        function get_employee(department_id, department_text = null, account_id = null) {

            var month = $('#month').val();
            jQuery(".pre-loader").fadeToggle("medium");
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_salary_payment_accounts",
                data: {department_id: department_id, month: month},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    jQuery("#table_body").html('');
                    var tabindex = 4;
                    $.each(data.pay_accounts, function (index, value) {
                        index++
                        var str = value.bal_total;
                        if (value.bal_total < 0) {
                            var payment_amount = str.replace("-", "");
                        } else {
                            payment_amount = 0;
                        }

                        jQuery("#table_body").append(
                            `<tr id='counter' class="edit_update">
                            <th class="tbl_srl_4">${index}</th>
                            <td class="tbl_srl_9" hidden> <input type="hidden"
                            name="department_id[]" id="department_id${value.user_id}" tabindex="-1" value="${department_id}" class="inputs_up_tbl form-control" readonly>
                            </td>

                            <td class="tbl_srl_14"> <input type="text" name="department_name[]" id="department_name${value.user_id}" tabindex="-1" value="${department_text}" class="inputs_up_tbl
                            form-control
                            text-left" readonly>
                             </td>

                            <td class="tbl_srl_9"> <input type="text"  name="account_code[]" id="account_code${value.user_id}" tabindex="-1" value="${value.bal_account_id}" class="inputs_up_tbl form-control "
                            readonly></td>

                            <td class="text-left tbl_txt_20"> <input type="text" name="account_name[]" id="account_name${value.user_id}" tabindex="-1" value="${value.user_name}" class="inputs_up_tbl form-control text-left" readonly></td>

                            <td class="text-left tbl_txt_20" hidden> <input type="text" name="employee_id[]" tabindex="-1" value="${value.user_id}" class="inputs_up_tbl form-control text-left" readonly></td>

                            <td class="text-left tbl_txt_15"> <input type="text" name="net_salary[]" id="net_salary${value.user_id}" tabindex="-1" value="${value.gssi_net_salary}"
                            class="inputs_up_tbl form-control text-left" readonly></td>

                            <td class="text-left tbl_txt_15"> <input type="text" name="adv_salary_led_bal[]" tabindex="-1" value="${value.bal_total}" id="adv_salary_led_bal${value.user_id}" class="inputs_up_tbl form-control text-left" readonly></td>

                            <td class="text-left tbl_txt_15"> <input type="text" name="payment_amount[]" tabindex="-1" value="${payment_amount}" id="payment_amount${value.user_id}" class="inputs_up_tbl form-control text-left employee_salary_amount" onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="balance_amount(${value.user_id});" ></td>

                            <td class="text-right tbl_srl_12"> <input type="text" tabindex="${tabindex++}" name="balance_amount[]" placeholder="Enter Amount" id="balance_amount${value.user_id}" class="inputs_up_tbl form-control text-right" onkeyup="calculate_amount();"
                            onkeypress="return allow_only_number_and_decimals(this,event);" readonly></td></tr>`);
                        balance_amount(value.user_id);

                    });
                    jQuery(".pre-loader").fadeToggle("medium");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        }

        function calculate_amount() {
            var x = document.getElementsByClassName("employee_salary_amount");
            var total_salary = 0;
            var i;
            for (i = 0; i < x.length; i++) {
                total_salary = +x[i].value + +total_salary;
            }
            document.getElementById("total_amount").value = total_salary.toFixed(2);
            document.getElementById("total_payable_amount").value = total_salary.toFixed(2);
        }


        function balance_amount(id) {

            var payment_amount = jQuery("#payment_amount" + id).val();
            var adv_salary_led_bal = jQuery("#adv_salary_led_bal" + id).val();
            var res = adv_salary_led_bal.replace("-", "");
            var ress = parseFloat(res);
            console.log(ress);
            if (adv_salary_led_bal < 0) {
                if (payment_amount > ress) {
                    jQuery("#payment_amount" + id).val(0);
                    payment_amount = 0;
                }
                var balance_amount = +adv_salary_led_bal + +payment_amount

                $('#balance_amount' + id).val(balance_amount.toFixed(2));
            } else {
                jQuery("#payment_amount" + id).val(0);
            }
            calculate_amount();
        }

    </script>
@endsection

