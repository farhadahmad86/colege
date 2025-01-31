@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Generate Salary Slip Voucher</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('generate_salary_slip_voucher_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->
                    <form id="f1" action="{{ route('submit_generate_salary_slip_voucher') }}" method="post" onsubmit="return checkForm()">
                        @csrf
                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->
                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->
                                        <div class="invoice_col_bx"><!-- invoice column box start -->
                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->
                                                Month
                                            </div><!-- invoice column title end -->
                                            <div class="invoice_col_input"><!-- invoice column input start -->
                                                {{--                                                    Hamad set tab index--}}
                                                <input tabindex="1" type="text" name="month" id="month" class="inputs_up form-control month-picker" autocomplete="off" value=""
                                                       data-rule-required="true"
                                                       data-msg-required="Please Enter Month"
                                                       placeholder="Start Month ......">
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->
                                    {{--                                    <div class="invoice_col form-group col-lg-3 col-md-3 col-sm-12"><!-- invoice column start -->--}}
                                    {{--                                        <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                                    {{--                                            <div class="required invoice_col_ttl"><!-- invoice column title start -->--}}
                                    {{--                                                Days--}}
                                    {{--                                            </div><!-- invoice column title end -->--}}
                                    {{--                                            <div class="invoice_col_input"><!-- invoice column input start -->--}}
                                    {{--                                                <input tabindex="2" type="text" name="days" id="days" class="inputs_up form-control" autocomplete="off"--}}
                                    {{--                                                        onkeypress="return allow_only_number_and_decimals(this,event)" ;--}}
                                    {{--                                                        data-rule-required="true"--}}
                                    {{--                                                        data-msg-required="Please Enter Days"--}}
                                    {{--                                                        placeholder="Enter Days ......">--}}
                                    {{--                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}

                                    {{--                                            </div><!-- invoice column input end -->--}}
                                    {{--                                        </div><!-- invoice column box end -->--}}
                                    {{--                                    </div><!-- invoice column end -->--}}


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
                                                <select tabindex="3" name="department" class="inputs_up form-control" id="department">
                                                    <option value="0" selected disabled>Select Department</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{$department->dep_id}}">{{$department->dep_title}}</option>
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
                                                {{--                                                    Hamad set tab index--}}
                                                <input tabindex="4" type="text" name="remarks" class="inputs_up form-control" id="remarks" placeholder="Remarks">
                                            </div><!-- invoice column input end -->
                                        </div><!-- invoice column box end -->
                                    </div><!-- invoice column end -->

                                </div><!-- invoice row end -->

                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                        <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                            <div class="table-responsive"><!-- product table box start -->
                                                {{--                                            <div class="table-responsive pro_tbl_bx"><!-- product table box start -->--}}
                                                <table tabindex="-1" class="table table-bordered table-sm" id="category_dynamic_table">
                                                    <thead>
                                                    <tr>
                                                        <th class=""> Sr</th>
                                                        <th class="tbl_srl_8"> Department</th>
                                                        <th class="tbl_srl_9" hidden> Code</th>
                                                        <th class="tbl_txt_8"> Title</th>
                                                        <th class="tbl_txt_5"> Month Days</th>
                                                        <th tabindex="-1" class="tbl_txt_5"> Attend Days</th>
                                                        {{--                                                        <th class="tbl_txt_5"> Salary Period</th>--}}
                                                        <th tabindex="-1" class="tbl_txt_7"> Basic Salary</th>
                                                        <th tabindex="-1" class="tbl_txt_2"> Gross Salary</th>
                                                        <th class="tbl_txt_6"> Allowances</th>
                                                        <th class="tbl_txt_6"> Deductions</th>
                                                        <th tabindex="-1" class="tbl_txt_6"> Over Times Days</th>
                                                        <th tabindex="-1" class="tbl_txt_6"> Over Time Amount</th>
                                                        <th tabindex="-1" class="tbl_srl_8"> Net Salary</th>
                                                        <th tabindex="-1" class="tbl_srl_8" hidden> Loan Amount</th>
                                                        <th tabindex="-1" class="tbl_srl_8"> Advance Amount</th>
                                                        <th tabindex="-1" class="tbl_srl_8"> Instalment Amount</th>
                                                        <th tabindex="-1" class="tbl_srl_8"> Payable Amount</th>
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
                                                        <th tabindex="-1" colspan="14" class="text-right">
                                                            Total
                                                        </th>

                                                        <td tabindex="-1" class="">
                                                            <div class="invoice_col_txt"><!-- invoice column box start -->
                                                                <div class="invoice_col_input"><!-- invoice column input start -->
                                                                    <input tabindex="-1" type="text" name="total_amount" class="inputs_up text-right form-control" id="total_amount"
                                                                        {{--                                                                            placeholder="0.00" readonly data-rule-required="true" data-msg-required="Please Add"--}}
                                                                    />
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

                                <div class="invoice_row"><!-- invoice row start -->
                                    <div class="invoice_col col-lg-12 text-right"><!-- invoice column start -->
                                        <button tabindex="5" type="submit" name="save" id="save" class="invoice_frm_btn btn btn-sm btn-success">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
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
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let //account = document.getElementById("account"),
                month = document.getElementById("month"),
                department = document.getElementById("department"),
                // totalAmount = document.getElementById("total_amount");
                validateInputIdArray = [
                    //account.id,
                    month.id,
                    department.id,
                    // totalAmount.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
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
            var month = $('#month').val();
            // var days = $('#days').val();
            // if (month != '' && days != '') {
            get_employee(department_id, department_text);
            // } else {
            //     $('#department').select2('destroy');
            //     jQuery('#department option[value="' + 0 + '"]').prop('selected', true);
            //     $('#department').select2();
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Please Select Month And Days First...',
            //         text: 'Please Select Month First And Enter Days And Then Select Department!',
            //         timer: 5000
            //     })
            // }
        });

        function get_employee(department_id, department_text = null, account_id = null) {

            var month = $('#month').val();
            var days = $('#days').val();

            const words = month.split(' ');
            var year = words[1];

            var months = {January: 1, February: 2, March: 3, April: 4, May: 5, June: 6, July: 7, August: 8, September: 9, October: 10, November: 11, December: 12};
            var get_month = months[words[0]];

            var month_year = '';
            if (get_month < 10) {
                month_year = year + '-0' + get_month + '-01';
            } else {
                month_year = year + '-' + get_month + '-01';
            }

            var total_days = new Date(year, get_month, 0).getDate();


            jQuery(".pre-loader").fadeToggle("medium");
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "get_salary_accounts",
                data: {department_id: department_id, month: month,
                    month_year: month_year,
                    get_month: get_month,
                    year: year,
                },
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    //
                    // console.log(data.pay_accounts);
                    jQuery("#table_body").html('');
                    if (data.check_attendance != 0) {
                        if (data.generated == 0) {

                            var tabindex = 4;

                            $.each(data.pay_accounts, function (index, value) {
                                index++;
                                var period = '';
                                var loan_amount = '';
                                var instalment_amount = '';
                                var allowance = 0;
                                var deduction = 0;

                                if (value.si_basic_salary_period == 1) {
                                    period = 'Per Hour'
                                } else if (value.si_basic_salary_period == 2) {
                                    period = 'Daily'
                                } else {
                                    period = 'Monthly'
                                }
                                if (value.total_loan_amount == null || value.total_loan_amount == 0) {
                                    loan_amount = 0;
                                    instalment_amount = 0;
                                }
                                if (value.loan_instalment_amount == null) {
                                    loan_amount = value.total_loan_amount;
                                    instalment_amount = 0;
                                } else {
                                    loan_amount = value.total_loan_amount;
                                    instalment_amount = value.loan_instalment_amount;
                                }
                                if (value.allowance > 0) {

                                    allowance = value.allowance;
                                }
                                if (value.deduction > 0) {
                                    deduction = value.deduction;
                                }


                                var total_advance_salary = 0;
                                if (value.advance_salary == null) {
                                    total_advance_salary = 0;
                                } else {
                                    total_advance_salary = value.advance_salary;
                                }

                                // $.ajax({
                                //     type: "GET",
                                //     url: '/getAllowanceDeduction/' + value.si_user_id, // Use the Laravel route
                                //     dataType: 'json',
                                //     success: function (result) {
                                //         console.log(result);
                                        // Process the result here


                                        total_payable = -instalment_amount;

                                        jQuery("#table_body").append(
                                         '<tr id=' + 'counter' + ' class="edit_update">' +
                                            '<th>' + index + '</th>' +
                                            '<td class="tbl_srl_9" hidden>' + '<input type="text" ' +
                                            'name="employee_id[]" tabindex="-1" value="' + value.si_user_id + '" class="inputs_up_tbl form-control " readonly>'
                                            + '</td>' +
                                            '<td class="tbl_srl_9" hidden>' + '<input type="hidden" ' +
                                            'name="department_id[]" tabindex="-1" value="' + department_id + '" class="inputs_up_tbl form-control " readonly>'
                                            + '</td>' +
                                            '<td class="tbl_srl_8">' + '<input type="hidden" ' +
                                            'name="department_name[]" tabindex="-1" value="' + department_text + '" class="inputs_up_tbl form-control text-left" readonly>' + department_text + '</td>' +
                                            '<td class="tbl_srl_9" hidden>' + '<input ' +
                                            'type="text" ' +
                                            'name="account_code[]" tabindex="-1" value="' + value.account_uid + '" class="inputs_up_tbl form-control " readonly>' + '</td>' +
                                            '<td class="text-left tbl_txt_8">' + '<input type="hidden"' +
                                            ' ' +
                                            'name="account_name[]" tabindex="-1" value="' + value.account_name + '" class="inputs_up_tbl form-control text-left" readonly>' + value.account_name + '</td>' +
                                            '<td class="text-left tbl_txt_5">' +
                                            '<input ' +
                                            'type="text" ' +
                                            'name="month_days[]" id="month_days' + value.si_user_id + '" class="inputs_up_tbl form-control text-left" tabindex="' + tabindex++ + '" placeholder="Enter Month Days" ' +
                                            'value="' + value.atten_month_days + '"' +
                                            ' onkeyup="gross_salary(' + value.si_user_id + ')" ' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" readonly>' + '</td>' +
                                            '<td class="text-left tbl_txt_5">' +
                                            '<input ' +
                                            'type="text" ' +
                                            'name="attend_days[]" id="attend_days' + value.si_user_id + '" class="inputs_up_tbl form-control text-left" tabindex="' + tabindex++ + '" placeholder="Enter Attend Days"' +
                                            ' value="' + value.atten_attend_days + '" onkeyup="gross_salary(' + value.si_user_id + ')" ' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" >' + '</td>' +
                                            '<td class="text-left tbl_txt_5" hidden>' +
                                            '<input ' +
                                            'type="hidden" ' +
                                            'name="salary_period[]" id="salary_period" value="' + value.si_basic_salary_period + '" class="inputs_up_tbl form-control text-left" tabindex="' + tabindex++ + '" ' +
                                            'placeholder="Enter Hour Day ' +
                                            'Month" readonly>' + period + '</td>' +
                                            '<td class="text-left tbl_txt_7">' +
                                            '<input ' +
                                            'type="text" ' +
                                            'name="basic_salary[]" id="basic_salary' + value.si_user_id + '" value="' + value.si_basic_salary + '" class="inputs_up_tbl form-control text-left" tabindex="' + tabindex++ + '" ' +
                                            'placeholder="BasicPackage Salary" onkeyup="gross_salary(' + value.si_user_id + ')" onkeypress="return allow_only_number_and_decimals(this,event);" >' + '</td>' +
                                            '<td class="text-left tbl_txt_2">' +
                                            '<input ' +
                                            'type="text" ' +
                                            'name="gross_salary[]" id="gross_salary' + value.si_user_id + '" class="inputs_up_tbl form-control text-left total_gross_salary" tabindex="' + tabindex++ + '" ' +
                                            'placeholder="Gross Salary" ' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" readonly>' + '</td>' +
                                            '<td class="text-left tbl_txt_6">' +
                                            '<input ' +
                                            'type="text" ' +
                                            'name="allowances[]" id="allowances' + value.si_user_id + '" class="inputs_up_tbl form-control text-left" tabindex="' + tabindex++ + '" placeholder="Allowance" value="' + allowance + '"' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="gross_salary(' + value.si_user_id + ')" readonly>' + '</td>' +
                                            '<td class="text-left tbl_txt_6">'+

                                       '<input ' +
                                            'type="text" ' +
                                            'name="deductions[]" id="deductions' + value.si_user_id + '" class="inputs_up_tbl form-control text-left" tabindex="' + tabindex++ + '" placeholder="Deduction" value="' + deduction + '"' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="gross_salary(' + value.si_user_id + ')" readonly>'+

                                                        '</td>' +
                                            '<td class="text-left tbl_txt_6">' +
                                            '<input ' +
                                            'type="text" ' +
                                            'name="over_time_days[]" id="over_time_days' + value.si_user_id + '" onkeyup="gross_salary(' + value.si_user_id + ')" class="inputs_up_tbl form-control text-left" tabindex="' + tabindex++ + '" placeholder="days"' +
                                            ' ' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" readonly>' + '</td>' +

                                            '<td class="text-left tbl_txt_6">' +
                                            '<input ' +
                                            'type="text" ' +
                                            'name="over_time_amount[]" id="over_time_amount' + value.si_user_id + '" class="inputs_up_tbl form-control text-left" tabindex="' + tabindex++ + '" placeholder="Amount" ' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" readonly>' + '</td>' +


                                            '<td class="text-right tbl_srl_8">' + '<input type="text" ' +
                                            'tabindex="' + tabindex++ + '"' +
                                            ' name="net_salary[]" id="net_salary' + value.si_user_id + '" placeholder="Enter Amount" class="inputs_up_tbl form-control text-right net_salary_amount" ' +
                                            'onkeyup="calculate_amount();" ' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" readonly></td>' +

                                            '<td class="text-right tbl_srl_8">' + '<input type="text" ' +
                                            'tabindex="' + tabindex++ + '"' +
                                            ' name="advance_salary[]" id="advance_salary' + value.si_user_id + '" placeholder="Enter Amount" value="' + total_advance_salary + '" class="inputs_up_tbl form-control sum_advance_salary' +
                                            'text-right " ' +
                                            'onkeyup="calculate_amount();" ' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" readonly></td>' +

                                            '<td class="text-right tbl_srl_8" hidden>' + '<input type="text" ' +
                                            'tabindex="' + tabindex++ + '"' +
                                            ' name="total_loan_amount[]" id="total_loan_amount' + value.si_user_id + '" placeholder="Enter Amount" class="inputs_up_tbl form-control text-right " value="' + loan_amount + '" ' +
                                            'onkeyup="calculate_amount();" ' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" readonly></td>' +


                                            '<td class="text-right tbl_srl_8">' + '<input type="text" ' +
                                            'tabindex="' + tabindex++ + '"' +
                                            ' name="loan_instalment_amount[]" id="loan_instalment_amount' + value.si_user_id + '" placeholder="Enter Amount" value="' + instalment_amount + '" ' +
                                            'class="inputs_up_tbl form-control text-right " ' +
                                            'onkeyup="calculate_amount();" ' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" readonly></td>' +

                                            '<td class="text-right tbl_srl_10" hidden>' + '<input type="text" ' +
                                            'tabindex="' + tabindex++ + '"' +
                                            ' name="loan_acount[]" id="loan_acount' + value.si_user_id + '" placeholder="Enter Amount" value="' + value.si_loan_account_uid + '" ' +
                                            'class="inputs_up_tbl ' +
                                            'form-control text-right " ' +
                                            'onkeyup="calculate_amount();" ' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" readonly></td>' +

                                            '<td class="text-right tbl_srl_10" hidden>' + '<input type="text" ' +
                                            'tabindex="' + tabindex++ + '"' +
                                            ' name="advance_account[]" id="advance_account' + value.si_user_id + '" placeholder="Enter Amount" value="' + value.si_advance_salary_account_uid + '" ' +
                                            'class="inputs_up_tbl ' +
                                            'form-control text-right " readonly></td>' +

                                            '<td class="text-right tbl_srl_8" >' + '<input type="text" ' +
                                            'tabindex="' + tabindex++ + '"' +
                                            ' name="payable_amount[]" id="payable_amount' + value.si_user_id + '" placeholder="Enter Amount" ' +
                                            'class="inputs_up_tbl form-control text-right employee_salary_amount" onkeyup="calculate_amount();"' +
                                            'onkeypress="return allow_only_number_and_decimals(this,event);" readonly></td>' +


                                            '</tr>');
                                        // jQuery("#table_body").append(tabl_data);
                                        //     );
                                        gross_salary(value.si_user_id);
                                    // },
                                    // error: function (error) {
                                    //     console.error(error);
                                    // }
                                // });
                            });

                            jQuery(".pre-loader").fadeToggle("medium");
                        } else {
                            Swal.fire({
                                icon: 'error',
                                // title: 'Salary Slip of "'+department_text+' Deparment" for month "'+month+'" is already Generated!',
                                text: 'Salary Slip of "' + department_text + ' Department" for month "' + month + '" is already Generated!',
                                timer: 5000
                            })
                            jQuery(".pre-loader").fadeToggle("medium");
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            // title: 'Salary Slip of "'+department_text+' Deparment" for month "'+month+'" is already Generated!',
                            text: 'Please Mark Attendance"' + department_text + ' Department" for Month "' + month + '"',
                            timer: 5000
                        })
                        jQuery(".pre-loader").fadeToggle("medium");
                    }
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
        }


    </script>
    <script>
        function gross_salary(id) {

            var month_days = jQuery("#month_days" + id).val();
            var attend_days = jQuery("#attend_days" + id).val();
            var basic_salary = jQuery("#basic_salary" + id).val();
            var over_time_days = jQuery("#over_time_days" + id).val();
            var allowances = jQuery("#allowances" + id).val();
            var deductions = jQuery("#deductions" + id).val();
            var over_time_amount = jQuery("#over_time_amount" + id).val();
            var loan_instalment_amount = jQuery("#loan_instalment_amount" + id).val();
            var advance_salary = jQuery("#advance_salary" + id).val();


            var cal_over_time_amount = basic_salary / month_days * over_time_days;

            var cal_gross_salary = basic_salary / month_days * attend_days;
            var net_salary = (+cal_gross_salary + +allowances + +over_time_amount) - +deductions;
            var round_net_salary = Math.round(net_salary);
            var payable_amount = +round_net_salary - +loan_instalment_amount + +advance_salary;
            console.log(payable_amount, round_net_salary, loan_instalment_amount, advance_salary);
            $('#gross_salary' + id).val(cal_gross_salary.toFixed(2));
            $('#over_time_amount' + id).val(cal_over_time_amount.toFixed(2));
            $('#net_salary' + id).val(round_net_salary.toFixed(2));
            $('#payable_amount' + id).val(payable_amount.toFixed(2));
            calculate_amount();
        }

    </script>
    <script>

        $('#month').click(function () {

            jQuery("#department").select2("destroy");
            $('#department option[value="' + 0 + '"]').prop('selected', true);
            jQuery("#department").select2();
            jQuery("#table_body").html('');
            jQuery("#total_amount").val('');
        });


    </script>

@endsection

