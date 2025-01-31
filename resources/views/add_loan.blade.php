@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Loan </h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('loan_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('submit_loan') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx"><!-- start input box -->
                            <label class="required">
                                Department Title
                                <a tabindex="-1" href="{{ url('departments/create') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover"
                                   data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                    <l class="fa fa-plus"></l>
                                </a>
                                <a tabindex="-1" class="add_btn" id="refresh_department" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                   data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                    <l class="fa fa-refresh"></l>
                                </a>

                            </label>
                            <select tabindex=1 autofocus name="department" class="inputs_up form-control" id="department" autofocus data-rule-required="true"
                                    data-msg-required="Please Enter Department Title">
                                <option value="" selected disabled>Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{$department->dep_id}}">{{$department->dep_title}}</option>
                                @endforeach

                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx"><!-- start input box -->
                            <label class="required">

                                Account Title

                            </label>
                            <select tabindex="2" name="account_name" class="inputs_up form-control" id="account_name" data-rule-required="true"
                                    data-msg-required="Please Enter Account Title">
                                <option value="" selected disabled>Select Department First</option>
                            </select>
                            <span id="demo2" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx"><!-- start input box -->
                            <label class="required">

                                First Payment Month</label>
                            <input tabindex="6" type="text" name="first_payment_month" id="first_payment_month" class="inputs_up form-control month-picker" autocomplete="off"
                                   value=""
                                   data-rule-required="true"
                                   data-msg-required="Please Enter Month"
                                   placeholder="Start Month ......">
                            <span id="demo4" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx"><!-- start input box -->
                            <label class="required">
                                Loan Amount

                            </label>
                            <input tabindex="3" type="text" name="loan_amount" id="loan_amount" class="inputs_up form-control" placeholder="Loan Amount" data-rule-required="true"
                                   data-msg-required="Please Enter Loan Amount" onkeypress="return allow_only_number_and_decimals(this,event);">
                            <span id="demo3" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx"><!-- start input box -->
                            <label class="required">

                                Total Instalment</label>
                            <input tabindex="4" type="text" name="total_instalment" id="total_instalment" class="inputs_up form-control" placeholder="Total Instalment"
                                   data-rule-required="true" data-msg-required="Please Enter Total Instalment" onkeypress="return allow_only_number_and_decimals(this,event);">
                            <span id="demo4" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx"><!-- start input box -->
                            <label class="required">

                                Instalment Amount</label>
                            {{--                                                Hamad set tab index--}}
                            <input tabindex="5" type="text" name="instalment_amount" id="instalment_amount" class="inputs_up form-control" placeholder="Instalment Amount"
                                   data-rule-required="true"
                                   data-msg-required="Please Enter Instalment Amount" onkeypress="return allow_only_number_and_decimals(this,event);" readonly>
                            <span id="demo4" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>



                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="input_bx"><!-- start input box -->
                            <label class="required">
                                Last Payment Month</label>
                            {{--                            month-picker--}}
                            <input tabindex="7" type="text" name="last_payment_month" id="last_payment_month" class="inputs_up form-control" autocomplete="off"
                                   value=""
                                   data-rule-required="true"
                                   data-msg-required="Please Enter Month"
                                   placeholder="Start Month ......" readonly>
                            <span id="demo4" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="7" type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>

            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let department = document.getElementById("department"),
                account_name = document.getElementById("account_name"),
                loan_amount = document.getElementById("loan_amount"),
                total_instalments = document.getElementById("total_instalment"),
                instalment_amount = document.getElementById("instalment_amount"),
                first_payment_month = document.getElementById("first_payment_month"),
                validateInputIdArray = [
                    department.id,
                    account_name.id,
                    loan_amount.id,
                    total_instalments.id,
                    instalment_amount.id,
                    first_payment_month.id,
                ];
            let expiry_date = last_month(total_instalments.value,first_payment_month.value);
            $('#last_payment_month').val(expiry_date);
            return  validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        jQuery("#refresh_department").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_department",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#department").html(" ");
                    jQuery("#department").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>

    <script>
        jQuery("#department").change(function () {

            var department_id = $(this).val();
            $('#first_payment_month').val('');
            $('#last_payment_month').val('');

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_loan_account",
                data: {department_id: department_id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data.loan_accounts);
                    var options = "<option value='' disabled selected>Select Account name</option>";
                    $.each(data.loan_accounts, function (index, value) {
                        options += "<option value='" + value.account_uid + "' >" + value.account_name + "</option>";
                    });
                    jQuery("#account_name").html(" ");
                    jQuery("#account_name").append(options);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

    </script>
    <script>
        $('#total_instalment').keyup(function () {
            var total_instalment = $(this).val();
            var loan_amount = $('#loan_amount').val();
            var instalment_amount = loan_amount / total_instalment;
            $('#instalment_amount').val(instalment_amount.toFixed(3));
            get_last_month();
        });

        $('#instalment_amount').keyup(function () {
            var instalment_amount = $(this).val();
            var loan_amount = $('#loan_amount').val();
            var total_instalment = loan_amount / instalment_amount;
            $('#total_instalment').val(total_instalment);
            get_last_month();
        });
    </script>
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#department").select2();
            jQuery("#account_name").select2();
        });
    </script>
    <script>
        function get_last_month(){
            let month = $('#first_payment_month').val();
            let department_id = $('#department').val();
            var department_text = jQuery("#department option:selected").text();
            if (department_id != null && month != null) {
                get_employee(department_id, department_text, month)
            }else{
                $('#total_instalment').val('');
                $('#instalment_amount').val('');
            }
        }

        function get_employee(department_id, department_text, month) {
            let total_instalment = $('#total_instalment').val();
            let expiry_date = last_month(total_instalment,month);

            jQuery(".pre-loader").fadeToggle("medium");
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "get_salary_generate_account",
                data: {department_id: department_id, month: month},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    jQuery("#table_body").html('');
                    var tabindex = 4;
                    if (data.generated == 0) {
                        $('#last_payment_month').val(expiry_date);
                        jQuery(".pre-loader").fadeToggle("medium");
                    } else {
                        $('#first_payment_month').val('');
                        $('#last_payment_month').val('');
                        $('#total_instalment').val('');
                        $('#instalment_amount').val('');
                        Swal.fire({
                            icon: 'error',
                            // title: 'Salary Slip of "'+department_text+' Deparment" for month "'+month+'" is already Generated!',
                            text: "Salary Slip of month '" + month + "' is Generated so you can't select this month!",
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

        function last_month(total_instalment,month){
            const words = month.split(' ');
            var year = words[1];

            var months = {January: 1, February: 2, March: 3, April: 4, May: 5, June: 6, July: 7, August: 8, September: 9, October: 10, November: 11, December: 12};
            var months_name = {0: 'January', 1: 'February', 2: 'March', 3: 'April', 4: 'May', 5: 'June', 6: 'July', 7: 'August', 8: 'September', 9: 'October', 10: 'November', 11: 'December'};
            var get_month = months[words[0]];

            var total_days = new Date(year, get_month, 0);

            let new_month = total_days.getMonth() + +total_instalment;
            let new_years = total_days.getFullYear();

            var new_month_year = new Date(new_years, new_month, 0);
            var expiry_date = months_name[new_month_year.getMonth()] + ' ' + new_month_year.getFullYear()

            return expiry_date;
        }
    </script>


@endsection


