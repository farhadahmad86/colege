@extends('extend_index')

@section('content')
    <style>
        .pro_tbl_con .pro_tbl_bx .edit_update_bx {
            right: 0px !important;
        }
    </style>

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Student Details</h4>
                        </div>
                        {{--                        <div class="list_btn"> --}}
                        {{--                            <a class="btn list_link add_more_button" href="{{ route('employee_list') }}" role="button"> --}}
                        {{--                                <i class="fa fa-list"></i> view list --}}
                        {{--                            </a> --}}
                        {{--                        </div><!-- list btn --> --}}
                    </div>
                </div><!-- form header close -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="pd-20 bg-white border-radius-4 box-shadow">
                            <table>
                                <tr>
                                    <td class="tbl_txt_70" colspan="4">
                                        <table>
                                            <tr>
                                                <th class="tbl_txt_20"><img src="{{ $student->profile_pic }}"
                                                                            style="border-radius:50%; position:relative; cursor:pointer;  width: 100px; height: 100px;
                                                    ">
                                                </th>
                                                <th class="tbl_txt_80"><b style="color: orange">{{ $student->full_name }} |
                                                        {{ $student->registration_no }} | {{ $student->status }}</b>
                                                    <br/>
                                                    {{ $student->class_name }}
                                                    <br/>
                                                    @if ($student->hostel == 'Yes')
                                                        <span class="badge rounded-pill bg-success text-white">Hostel</span>
                                                    @endif
                                                    @if ($student->transport == 'Yes')
                                                        <span
                                                            class="badge rounded-pill bg-success text-white">Transport</span>
                                                    @endif
                                                    @if ($student->zakat == 'Yes')
                                                        <span class="badge rounded-pill bg-success text-white">Zakat</span>
                                                    @endif

                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="tbl_txt_30">
                                        <table>
                                            <tr>
                                                <th class="tbl_txt_50">Contact</th>
                                                <th class="tbl_txt_50 text-right">{{ $student->contact }}</th>
                                            <tr>
                                            <tr>
                                                <th class="tbl_txt_50">Parent</th>
                                                <th class="tbl_txt_50 text-right">{{ $student->father_name }}</th>
                                            <tr>
                                                <th class="tbl_txt_50">Religion</th>
                                                <th class="tbl_txt_50 text-right">{{ $student->religion }}</th>
                                            </tr>
                                            <tr>
                                                <th class="tbl_txt_50">Date Of Admission</th>
                                                <th class="tbl_txt_50 text-right">{{ $student->admission_date }}</th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <th>{{ $student->dob }}</th>
                                    <th>Registration</th>
                                    <th>{{ $student->registration_no }}</th>
                                    <th>City</th>
                                    <th>{{ $student->city }}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <hr/>
                {{--                <form action="{{ route('update_employee') }}" id="f1" onsubmit="return checkForm()" method="post" --}}
                {{--                      enctype="multipart/form-data" autocomplete="off"> --}}
                {{--                    @csrf --}}
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="pd-20 bg-white border-radius-4 box-shadow">
                            <div class="tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active text-blue" data-toggle="tab" href="#personal"
                                           role="tab" aria-selected="true">Installments</a>
                                    </li>
{{--                                    <li class="nav-item">--}}
{{--                                        <a class="nav-link text-blue" data-toggle="tab" href="#credentials" role="tab"--}}
{{--                                           aria-selected="false">Credentials</a>--}}
{{--                                    </li>--}}
                                </ul>

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h2>
                                            Receivable Amount: {{ number_format($student_packages->sp_receivable_amount) }}
                                        </h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        @foreach($installment_accounts as $account)
                                            <b>{{$account->account_name}}: </b>{{$account->balance}}
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                        <div class="pd-20">

                                            <div class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <h3 id="instalment">

                                                    </h3>
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <h3>
                                                        Installment Detail
                                                    </h3>
                                                </div>

                                                <ul id="installment_details">
                                                    @foreach ($student_instalments as $semester)
                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <li><a
                                                                    onclick="instalment_detail({{ $semester->si_id }})"><b
                                                                        style="color:orange">Semester
                                                                        {{ $semester->semester_name }} :</b>
                                                                    {{ $semester->si_total_amount }}</a></li>
                                                        </div>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="row">
                                                <div id="invoice_con" class="invoice_con for_voucher">
                                                    <!-- invoice container start -->
                                                    <div id="invoice_bx" class="invoice_bx show_scale show_rotate">
                                                        <!-- invoice box start -->
                                                        <form id="f1" action="{{ route('submit_student_installment') }}"
                                                              method="post" autocomplete="off">
                                                            @csrf
                                                            <input type="hidden" name="instalment_id"
                                                                   id="instalment_id">
                                                            <input type="hidden" name="student_id" id="student_id"
                                                                   value="{{ $student->id }}">
                                                            <input type="hidden" name="class_id"
                                                                   value="{{ $student->class_id }}">
                                                            <input type="hidden" id="total_accounts"
                                                                   value="{{ $total_accounts }}">
                                                            <input type="hidden" id="total_installment"
                                                                   name="total_installment" value="">
                                                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                                <!-- invoice scroll box start -->
                                                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                                    <!-- invoice content start -->
{{--                                                                    <div class="invoice_row">--}}
{{--                                                                        <!-- invoice row start -->--}}
{{--                                                                        <div--}}
{{--                                                                            class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">--}}
{{--                                                                            <div class="input_bx">--}}
{{--                                                                                <!-- start input box -->--}}
{{--                                                                                <label class="required">--}}
{{--                                                                                    Semester</label>--}}
{{--                                                                                <select tabindex="4"--}}
{{--                                                                                        name="instalment_semester"--}}
{{--                                                                                        class="inputs_up form-control"--}}
{{--                                                                                        data-rule-required="true"--}}
{{--                                                                                        data-msg-required="Please Enter Semester"--}}
{{--                                                                                        id="instalment_semester">--}}
{{--                                                                                    <option value="">Select Semester--}}
{{--                                                                                    </option>--}}
{{--                                                                                    @foreach ($semesters as $semester)--}}
{{--                                                                                        <option--}}
{{--                                                                                            value="{{ $semester->semester_id }}">--}}
{{--                                                                                            {{ $semester->semester_name }}--}}
{{--                                                                                        </option>--}}
{{--                                                                                    @endforeach--}}
{{--                                                                                </select>--}}
{{--                                                                                <span id="user_type_error_msg"--}}
{{--                                                                                      class="validate_sign"> </span>--}}
{{--                                                                            </div><!-- end input box -->--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
                                                                    <div class="invoice_row">
                                                                        <div class="pro_tbl_con for_voucher_tbl col-lg-12">
                                                                            <!-- product table container start -->
                                                                            <div class="table-responsive pro_tbl_bx">
                                                                                <!-- product table box start -->
                                                                                <table tabindex="-1"
                                                                                       class="table table-bordered table-sm"
                                                                                       id="category_dynamic_table">
                                                                                    <thead style="color:black">
                                                                                    <tr id="installment_head">
                                                                                        <th tabindex="-1"
                                                                                            class="tbl_srl_5">
                                                                                            Installment
                                                                                        </th>
                                                                                        <th tabindex="-1"
                                                                                            class="tbl_txt_12">
                                                                                            Month
                                                                                        </th>
                                                                                        @foreach ($installment_accounts as $account)
                                                                                            <th tabindex="-1"
                                                                                                class="tbl_txt_15">
                                                                                                <input type="hidden"
                                                                                                       name="account_name[]"
                                                                                                       value="{{ $account->account_name }}">
                                                                                                {{ $account->account_name }}

                                                                                            </th>
                                                                                            <td class="tbl_txt_15"
                                                                                                hidden>
                                                                                                <input type="hidden"
                                                                                                       name="account_uid[]"
                                                                                                       value="{{ $account->account_uid }}">
                                                                                                {{ $account->account_uid }}
                                                                                            </td>
                                                                                        @endforeach
                                                                                        <th tabindex=""
                                                                                            class="tbl_txt_8">
                                                                                            Amount
                                                                                        </th>
                                                                                    </tr>
                                                                                    </thead>

                                                                                    <tbody id="installment_body">
                                                                                    @for ( $i = 1; $i <= $total_months; $i++)
                                                                                        <tr>
                                                                                            <th class="tbl_srl_5"><input tabindex="2" type="hidden" name="ins_no[]" value=" {{$i}}"> {{$i}}  </th>

                                                                                            <td class="tbl_txt_12">
                                                                                                <input tabindex="2" type="text" name="month[]" id="month{{$i}}" class="inputs_up form-control"
                                                                                                       autocomplete="off" placeholder="Month......"></td>

                                                                                            @for ($ii = 0; $ii < $total_accounts; $ii++)
                                                                                                <td class="tbl_txt_15"><input type="text" class="form-control ins_amount{{$i}}  acc_amount{{$ii}}"
                                                                                                                              name="ins_amount{{$ii}}[]"
                                                                                                    id="ins_amount{{$i}}{{$ii}}" onkeyup="calculate_total_amount({{$i}}),account_total({{$ii}})"></td>
                                                                                            @endfor
                                                                                            <td class="tbl_txt_8" readonly=""><input type="text" class="form-control tr_amount{{$i}}" name="tr_amount[]" id="tr_amount{{$i}}"                  onkeyup="tr_total_amount({{$i}})" readonly></td>
                                                                                        </tr>
                                                                                        {{--                                                                                    @for ($i = 1; $i <= $student_packages[0]->sp_total_instalment; $i++) --}}
                                                                                        {{--                                                                                        <tr> --}}
                                                                                        {{--                                                                                            <th class="tbl_srl_5"> --}}
                                                                                        {{--                                                                                                {{$i}} --}}
                                                                                        {{--                                                                                            </th> --}}
                                                                                        {{--                                                                                            <td class="tbl_txt_12"> --}}
                                                                                        {{--                                                                                                <input tabindex="2" type="text" --}}
                                                                                        {{--                                                                                                       name="start_month" id="start_month" --}}
                                                                                        {{--                                                                                                       class="inputs_up form-control month-picker" --}}
                                                                                        {{--                                                                                                       autocomplete="off" value="" --}}
                                                                                        {{--                                                                                                       data-rule-required="true" --}}
                                                                                        {{--                                                                                                       data-msg-required="Please Enter Start Month" --}}
                                                                                        {{--                                                                                                       placeholder="Start Month ......"> --}}
                                                                                        {{--                                                                                            </td> --}}

                                                                                        {{--                                                                                            @for ($ii = 1; $ii <= $installment_accounts->count(); $ii++) --}}
                                                                                        {{--                                                                                                <td class="tbl_txt_15"><input type="text" class="form-control ins_amount{{$i}} acc_amount{{$ii}}" --}}
                                                                                        {{--                                                                                                                              name="ins_amount{{$ii}}[]" --}}
                                                                                        {{--                                                                                                                              id="ins_amount{{$i}}{{$ii}}" onkeyup="calculate_total_amount({{$i}}), --}}
                                                                                        {{--                                                                                                        account_total({{$ii}})"> --}}
                                                                                        {{--                                                                                                </td> --}}
                                                                                        {{--                                                                                            @endfor --}}

                                                                                        {{--                                                                                            <td class="tbl_txt_8"><input type="text" class="form-control tr_amount{{$i}}" name="tr_amount[]" --}}
                                                                                        {{--                                                                                                                         id="tr_amount{{$i}}" --}}
                                                                                        {{--                                                                                                                         onkeyup="tr_total_amount({{$i}})"> --}}
                                                                                        {{--                                                                                            </td> --}}
                                                                                        {{--                                                                                        </tr> --}}
                                                                                    @endfor
                                                                                    </tbody>

                                                                                    <tfoot>
                                                                                    <tr>
                                                                                        <th tabindex="-1"
                                                                                            colspan="1"
                                                                                            class="tbl_txt_15 text-right">
                                                                                            Total
                                                                                        </th>
                                                                                        @for ($ii = 0; $ii < $installment_accounts->count(); $ii++)
                                                                                            <td class="tbl_txt_15">
                                                                                                <div
                                                                                                    class="invoice_col_txt">
                                                                                                    <!-- invoice column box start -->
                                                                                                    <div
                                                                                                        class="invoice_col_input">
                                                                                                        <!-- invoice column input start -->
                                                                                                        <input
                                                                                                            type="number"
                                                                                                            name="account_total_amount{{ $ii }}"
                                                                                                            class="inputs_up text-right form-control grand-total-field"
                                                                                                            id="account_total_amount{{ $ii }}"
                                                                                                            placeholder="0.00"
                                                                                                            readonly
                                                                                                            data-rule-required="true"
                                                                                                            data-msg-required="Please Add"/>
                                                                                                    </div>
                                                                                                    <!-- invoice column input end -->
                                                                                                </div>
                                                                                                <!-- invoice column box end -->
                                                                                            </td>
                                                                                        @endfor
                                                                                        <td class="tbl_txt_15">
                                                                                            <div
                                                                                                class="invoice_col_txt">
                                                                                                <!-- invoice column box start -->
                                                                                                <div
                                                                                                    class="invoice_col_input">
                                                                                                    <!-- invoice column input start -->
                                                                                                    <input
                                                                                                        type="number"
                                                                                                        name="instalment_total_amount"
                                                                                                        class="inputs_up text-right form-control grand-total-field"
                                                                                                        id="instalment_total_amount"
                                                                                                        placeholder="0.00"
                                                                                                        readonly
                                                                                                        data-rule-required="true"
                                                                                                        data-msg-required="Please Add"/>
                                                                                                </div>
                                                                                                <!-- invoice column input end -->
                                                                                            </div>
                                                                                            <!-- invoice column box end -->
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tfoot>
                                                                                </table>
                                                                            </div><!-- product table box end -->
                                                                        </div><!-- product table container end -->

                                                                    </div><!-- invoice row end -->

                                                                    <div class="invoice_row">
                                                                        <!-- invoice row start -->

                                                                        <div class="invoice_col col-lg-12">
                                                                            <!-- invoice column start -->
                                                                            <div
                                                                                class="invoice_col_txt with_cntr_jstfy for_voucher_btns">
                                                                                <!-- invoice column box start -->
                                                                                <div
                                                                                    class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                                    <button tabindex="8" type="submit"
                                                                                            name="save" id="save"
                                                                                            class="invoice_frm_btn btn btn-sm btn-success">
                                                                                        <i class="fa fa-floppy-o"></i> Save
                                                                                    </button>
                                                                                    <span id="demo28"
                                                                                          class="validate_sign"></span>
                                                                                </div>
                                                                            </div><!-- invoice column box end -->
                                                                        </div><!-- invoice column end -->
                                                                    </div><!-- invoice row end -->
                                                                </div><!-- invoice content end -->
                                                            </div><!-- invoice scroll box end -->
                                                        </form>
                                                    </div><!-- invoice box end -->
                                                </div><!-- invoice container end -->
                                            </div>
                                        </div>
                                    </div>

{{--                                    <div class="tab-pane fade" id="credentials" role="tabpanel">--}}
{{--                                        <div class="pd-20">--}}


{{--                                            <div class="row">--}}
{{--                                                <div class="invoice_row w-100">--}}
{{--                                                    <div class="invoice_col basis_col_10">--}}
{{--                                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">--}}
{{--                                                            <div class="input_bx">--}}
{{--                                                                <div class="custom-control custom-checkbox mb-10 mt-1"--}}
{{--                                                                     style="float: left">--}}
{{--                                                                    <input type="checkbox" name="make_credentials"--}}
{{--                                                                           class="custom-control-input" id="make_credentials"--}}
{{--                                                                           value="1">--}}
{{--                                                                    <label class="custom-control-label"--}}
{{--                                                                           for="make_credentials">Make Credentials</label>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}


{{--                                            <div class="row credentials_div">--}}

{{--                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">--}}
{{--                                                    <div class="input_bx">--}}
{{--                                                        <!-- start input box -->--}}
{{--                                                        <label class="required">--}}

{{--                                                            User Name</label>--}}
{{--                                                        <input type="text" name="username" data-rule-required="true"--}}
{{--                                                               data-msg-required="Please Enter UserName" id="username"--}}
{{--                                                               class="inputs_up form-control" placeholder="User Name"--}}
{{--                                                               onBlur="check_username()" value="">--}}
{{--                                                        <span id="username_error_msg" class="validate_sign"> </span>--}}
{{--                                                    </div><!-- end input box -->--}}
{{--                                                </div>--}}

{{--                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">--}}
{{--                                                    <div class="input_bx">--}}
{{--                                                        <!-- start input box -->--}}
{{--                                                        <label class="required">--}}

{{--                                                            Email</label>--}}
{{--                                                        <input type="email" name="email" id="email"--}}
{{--                                                               data-rule-required="true"--}}
{{--                                                               data-msg-required="Please Enter Email"--}}
{{--                                                               class="inputs_up form-control" placeholder="Email"--}}
{{--                                                               onBlur="check_email()" value="">--}}
{{--                                                        <span id="email_error_msg" class="validate_sign"> </span>--}}
{{--                                                    </div><!-- end input box -->--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div> <!-- left column ends here -->
                </div>
                <!--  main row ends here -->
                {{--                </form> --}}
            </div> <!-- white column form ends here -->
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
          integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
            integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-ui-monthpicker@1.0.3/jquery.ui.monthpicker.min.js"></script>
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let user_department_id = document.getElementById("user_department_id"),
                user_type = document.getElementById("user_type"),
                branch = document.getElementById("branch"),
                role = document.getElementById("role"),
                designation = document.getElementById("designation"),
                name = document.getElementById("name"),
                fname = document.getElementById("fname"),
                mobile = document.getElementById("mobile"),
                parent_head = document.getElementById("parent_head"),
                basic_salary = document.getElementById("basic_salary"),
                hour_per_day = document.getElementById("hour_per_day"),
                group = document.getElementById("group"),
                product_reporting_group = document.getElementById("product_reporting_group"),
                modular_group = document.getElementById("modular_group"),
                username = document.getElementById("username"),
                email = document.getElementById("email"),
                email_confirmation = document.getElementById("email_confirmation"),
                validateInputIdArray = [
                    user_department_id.id,
                    user_type.id,
                    branch.id,
                    role.id,
                    designation.id,
                    name.id,
                    fname.id,
                    mobile.id,
                    parent_head.id,
                    basic_salary.id,
                    hour_per_day.id,
                    group.id,
                    product_reporting_group.id,
                    modular_group.id,
                    username.id,
                    email.id,
                    email_confirmation.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}


    <script type="text/javascript">
        // jQuery('#user_department_id').select2();
        jQuery("#semester").select2();

        jQuery("#account_code").select2();
        jQuery("#account_name").select2();


        jQuery("#dis_account_name").select2();
        $("#start_month").monthpicker();
        $("#end_month").monthpicker();
    </script>

    {{-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
    {{-- ////////////////////////////////////////////////// Package  /////////////////////////////////////////////////// --}}
    {{-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                $("#first_add_more").click();
                $("#dis_first_add_more").click();
                // event.preventDefault();
                return false;
            }
        });

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


            var flag_submit1 = true;
            var focus_once1 = 0;

            if (account_code == "0") {

                if (focus_once1 == 0) {
                    jQuery("#account_code").focus();
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


                var checkedValue = [];


                numberofaccounts = Object.keys(accounts).length;

                if (numberofaccounts == 0) {
                    jQuery("#table_body").html("");
                }

                accounts[counter] = {
                    'account_code': account_code,
                    'account_name': account_name_text,
                    'account_amount': amount,

                };

                // jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");
                // jQuery("#account_name option[value=" + account_code + "]").attr("disabled", "true");
                numberofaccounts = Object.keys(accounts).length;

                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="tbl_srl_9" hidden>' + account_code +
                    '</td><th class="tbl_srl_5">' + counter + '</th>' +
                    '<td class="text-left tbl_txt_50">' + account_name_text + '</td>' +

                    '<td class="text-right tbl_srl_12">' + amount + '</td>' +
                    '<td class="text-right tbl_srl_8 position-relative"><div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' +
                    counter +
                    ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_account(' +
                    counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);


                jQuery("#amount").val("");


                jQuery("#accountsval").val(JSON.stringify(accounts));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#account_code").select2();
                jQuery("#account_name").select2();

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
            calculate_voucher_amount();
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


            // jQuery("#account_code option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);

            jQuery('#account_code option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);
            jQuery('#account_name option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);


            jQuery("#amount").val(temp_accounts['account_amount']);


            jQuery("#account_code").select2();
            jQuery("#account_name").select2();


            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            // var newvaltohide = jQuery("#account_code").val();
            var newvaltohide = edit_account_value;

            // jQuery("#account_code option[value=" + newvaltohide + "]").attr("disabled", "true");
            // jQuery("#account_name option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);


            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");


            jQuery("#amount").val("");

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();


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

    {{--    // discount voucher code start--}}
    <script>
        // adding packs into table
        var disnumberofaccounts = 0;
        var dis_counter = 0;
        var dis_accounts = {};
        var global_id_to_edit_dis = 0;
        var edit_dis_account_value = '';

        function add_dis_account() {

            var account_name = document.getElementById("dis_account_name").value;
            var account_name_text = jQuery("#dis_account_name option:selected").text();
            var amount = document.getElementById("dis_amount").value;


            var flag_submit1 = true;
            var focus_once1 = 0;


            if (account_name == "0") {

                if (focus_once1 == 0) {
                    jQuery("#dis_account_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (amount == "" || amount == '0') {


                if (focus_once1 == 0) {
                    jQuery("#dis_amount").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (global_id_to_edit_dis != 0) {
                    jQuery("#" + global_id_to_edit_dis).remove();

                    delete accounts[global_id_to_edit_dis];
                }

                dis_counter++;

                jQuery("#dis_account_name").select2("destroy");


                var checkedValue = [];


                disnumberofaccounts = Object.keys(dis_accounts).length;

                if (disnumberofaccounts == 0) {
                    jQuery("#dis_table_body").html("");
                }

                dis_accounts[dis_counter] = {
                    'account_code': account_name,
                    'account_name': account_name_text,
                    'account_amount': amount,

                };

                // jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");
                // jQuery("#account_name option[value=" + account_code + "]").attr("disabled", "true");
                disnumberofaccounts = Object.keys(dis_accounts).length;

                jQuery("#dis_table_body").append(
                    '<tr id=' + dis_counter + ' class="edit_update"><td class="tbl_srl_9" hidden>' + account_code +
                    '</td><th class="tbl_srl_5">' + dis_counter + '</th>' +
                    '<td class="text-left tbl_txt_50">' + account_name_text + '</td>' +

                    '<td class="text-right tbl_srl_12">' + amount + '</td>' +
                    '<td class="text-right tbl_srl_8 position-relative"><div class="edit_update_bx"><a class="dis_edit_link btn btn-sm btn-success" href="#" onclick=edit_dis_account(' +
                    dis_counter +
                    ')><i class="fa fa-edit"></i></a><a href="#" class="dis_delete_link btn btn-sm btn-danger" onclick=delete_dis_account(' +
                    dis_counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#dis_account_name option[value="' + 0 + '"]').prop('selected', true);


                jQuery("#dis_amount").val("");


                jQuery("#dis_accountsval").val(JSON.stringify(dis_accounts));
                jQuery("#dis_cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#dis_first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#dis_account_name").select2();

                total_dis_calculation();


                jQuery(".dis_edit_link").show();
                jQuery(".dis_delete_link").show();
            }
        }

        function total_dis_calculation() {
            var total_amount = 0;

            jQuery.each(dis_accounts, function (index, value) {
                total_amount = +total_amount + +value['account_amount'];
            });

            jQuery("#dis_total_amount").val(total_amount);
            calculate_voucher_amount();
        }


        function delete_dis_account(current_item) {

            jQuery("#" + current_item).remove();
            var temp_accounts = dis_accounts[current_item];
            // jQuery("#account_code option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);

            delete dis_accounts[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#dis_accountsval").val(JSON.stringify(dis_accounts));

            if (isEmpty(dis_accounts)) {
                disnumberofaccounts = 0;
            }

            total_dis_calculation();

            jQuery("#dis_account_name").select2("destroy");

            jQuery("#dis_account_name").select2();
            jQuery("#dis_account_name").focus();
        }


        function edit_dis_account(current_item) {

            // jQuery(".table-responsive").attr("style", "display:none");
            jQuery("#" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#dis_first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#dis_cancel_button").show();

            jQuery(".dis_edit_link").hide();
            jQuery(".dis_delete_link").hide();

            global_id_to_edit_dis = current_item;

            var temp_accounts = dis_accounts[current_item];

            edit_dis_account_value = temp_accounts['account_code'];

            jQuery("#dis_account_name").select2("destroy");


            // jQuery("#account_code option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);

            jQuery('#dis_account_name option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);


            jQuery("#dis_amount").val(temp_accounts['account_amount']);

            jQuery("#dis_account_name").select2();
            jQuery("#dis_account_name").focus();

            jQuery("#dis_cancel_button").attr("style", "display:inline");
            jQuery("#dis_cancel_button").attr("style", "background-color:red !important");
        }

        function dis_cancel_all() {

            // var newvaltohide = jQuery("#account_code").val();
            var newvaltohide = edit_dis_account_value;

            // jQuery("#account_code option[value=" + newvaltohide + "]").attr("disabled", "true");
            // jQuery("#account_name option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery('#dis_account_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#dis_account_name").select2("destroy");


            jQuery("#dis_amount").val("");

            jQuery("#dis_account_name").select2();


            jQuery("#dis_cancel_button").hide();

            // jQuery(".table-responsive").show();
            jQuery("#" + global_id_to_edit_dis).show();

            jQuery("#save").show();

            jQuery("#dis_first_add_more").html('<i class="fa fa-plus"></i> Add');
            global_id_to_edit_dis = 0;

            jQuery(".dis_edit_link").show();
            jQuery(".dis_delete_link").show();

            edit_dis_account_value = '';
        }
    </script>
    {{--    // discount voucher code end--}}


    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#account").select2();

            @for ( $i = 1; $i <= $total_months; $i++)

           $("#month{{$i}}").monthpicker();

            @endfor

            jQuery("#month2").monthpicker();



            jQuery("#instalment_semester").change(function () {
                let semester_id = $(this).val();
                let student_id = $('#student_id').val();
                let total_accounts = $('#total_accounts').val();

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.ajax({
                    url: "get_semester_details",
                    data: {
                        semester_id: semester_id,
                        student_id: student_id
                    },
                    type: "GET",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {
                        jQuery(".pre-loader").fadeToggle("medium");
                        console.log(data);
                        $('#installment_body').html("");
                        let installment_body = '';
                        // for (let i = 1; i <= data.sp_total_instalment; i++) {
                        for (let i = 1; i <= 4; i++) {
                            // $('#table-body').append($(
                            installment_body += '<tr>' +
                                '<th class="tbl_srl_5"><input tabindex="2" type="hidden" name="ins_no[]" value="' +
                                i + '">' + i + '</th>' +
                                '<td class="tbl_txt_12">' +
                                '<input tabindex="2" type="text" name="month[]" id="month' +
                                i +
                                '" class="inputs_up form-control" autocomplete="off" placeholder="Month' +
                                ' ......"></td>'
                            for (let ii = 0; ii < total_accounts; ii++) {
                                installment_body +=
                                    ' <td class="tbl_txt_15"><input type="text" class="form-control ins_amount' +
                                    i + ' acc_amount' + ii + '" name="ins_amount' +
                                    ii +
                                    '[]"         ' +
                                    'id="ins_amount' + i + ii + '" ' +
                                    'onkeyup="calculate_total_amount(' + i +
                                    '),account_total(' + ii + ')"></td>'
                            }
                            installment_body +=
                                '<td class="tbl_txt_8" readonly=""><input type="text" class="form-control tr_amount' +
                                i + '" name="tr_amount[]" id="tr_amount' + i +
                                '"                  onkeyup="tr_total_amount(' + i +
                                ')" readonly></td>' +
                                '</tr>';
                            // ).monthpicker());


                        }
                        $('#total_installment').val('');
                        $('#total_installment').val(data.sp_total_instalment);
                        jQuery("#installment_body").append($(installment_body).monthpicker());
                        for (let i = 1; i <= data.sp_total_instalment; i++) {
                            $("#month" + i).monthpicker();
                        }
                        // $('#installment_body').html(installment_body);
                        $('#instalment').html(data.semester_name + ': ' + data.sp_total_amount +
                            '  ' + '  ' + data.sp_start_month + ' - ' + data.sp_end_month);
                        jQuery(".pre-loader").fadeToggle("medium");
                    }
                });
            });
        });
    </script>

    <script>
        function instalment_detail(instalment_id) {
            Swal.fire({
                title: 'Do you want to Edit this Semester Instalments?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    jQuery(".pre-loader").fadeToggle("medium");
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    jQuery.ajax({
                        url: "get_instalment_details",
                        data: {
                            instalment_id: instalment_id
                        },
                        type: "GET",
                        cache: false,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            // jQuery("#table_body").html("");

                            for (let i = 1; i <= 4; i++) {

                                installment_body += '<tr>' +


                                    $.each(data.$instalment_items, function (index, value) {
                                        if (value.sii_ins_no == i) {
                                            installment_body +=
                                                '<th class="tbl_srl_5"><input tabindex="2" type="hidden" name="ins_no[]" value="' +
                                                i + '">' + i + '</th>' +
                                                '<td class="tbl_txt_12">' +
                                                '<input tabindex="2" type="text" name="month[]" id="month' +
                                                i +
                                                '" class="inputs_up form-control" autocomplete="off" placeholder="Month' +
                                                ' ......"></td>'
                                        }
                                        //     console.log(value.spi_account_id);
                                        //     var account_code = value.spi_account_id;
                                        //     var account_name = value.spi_account_name;
                                        //     var account_name_text = value.spi_account_name;
                                        //     var amount = value.spi_amount;
                                        //
                                        //     if (global_id_to_edit != 0) {
                                        //         jQuery("#" + global_id_to_edit).remove();
                                        //
                                        //         delete accounts[global_id_to_edit];
                                        //     }
                                        //
                                        //     counter++;
                                        //
                                        //
                                        //     numberofaccounts = Object.keys(accounts).length;
                                        //
                                        //     if (numberofaccounts == 0) {
                                        //         jQuery("#table_body").html("");
                                        //     }
                                        //
                                        //     accounts[counter] = {
                                        //         'account_code': account_code,
                                        //         'account_name': account_name_text,
                                        //         'account_amount': amount,
                                        //
                                        //     };
                                        //     numberofaccounts = Object.keys(accounts).length;
                                        //
                                        //     jQuery("#table_body").append(
                                        //         '<tr id=' + counter +
                                        //         ' class="edit_update"><td class="tbl_srl_9" hidden>' +
                                        //         account_code +
                                        //         '</td><th class="tbl_srl_5">' + counter + '</th>' +
                                        //         '</td><td class="text-left tbl_txt_50">' +
                                        //         account_name_text + '</td>' +
                                        //
                                        //         '<td class="text-right tbl_srl_12">' + amount +
                                        //         '</td>' +
                                        //         '<td class="text-right tbl_srl_8 position-relative"><div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_account(' +
                                        //         counter +
                                        //         ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_account(' +
                                        //         counter +
                                        //         ')><i class="fa fa-trash"></i></a></div></td></tr>');
                                        //
                                        //     jQuery('#account_code option[value="' + 0 + '"]').prop(
                                        //         'selected', true);
                                        //     jQuery('#account_name option[value="' + 0 + '"]').prop(
                                        //         'selected', true);
                                        //
                                        //
                                        //     jQuery("#amount").val("");
                                        //
                                        //     jQuery("#accountsval").val(JSON.stringify(accounts));
                                        //     jQuery("#cancel_button").hide();
                                        //     jQuery(".table-responsive").show();
                                        //     jQuery("#save").show();
                                        //     jQuery("#first_add_more").html(
                                        //         '<i class="fa fa-plus"></i> Add');
                                        //
                                        //     jQuery("#account_code").select2();
                                        //     jQuery("#account_name").select2();
                                        //
                                        //     total_calculation();
                                        //
                                        //     jQuery(".edit_link").show();
                                        //     jQuery(".delete_link").show();
                                    });
                                '<tr>';
                            }
                            jQuery(".pre-loader").fadeToggle("medium");
                        }
                    });

                }
            })
        }
    </script>
    <script>
        function calculate_total_amount(id) {
            let total = 0;
            $('.ins_amount' + id).each(function (pro_index) {
                let amount = $('#ins_amount' + id + pro_index).val();
                total = +total + +amount;
            });
            $('#tr_amount' + id).val(total);
            grand_total();
        }

        function grand_total() {
            let total_amount = 0;
            $('input[name="tr_amount[]"]').each(function (pro_index) {
                let id = +pro_index + 1;
                total_amount = +total_amount + +$('#tr_amount' + id).val();
            });
            $('#instalment_total_amount').val(total_amount);
        }

        function account_total(id) {
            let total = 0;
            $('input[name="ins_amount' + id + '[]"]').each(function (pro_index) {
                var ab = (+pro_index + 1) + '' + id;
                // let abc = $('#ins_amount' + ab).val();
                total = +total + +$('#ins_amount' + ab).val();
                ;
            });
            $('#account_total_amount' + id).val(total);
        }
    </script>

    <script>
        function calculate_voucher_amount() {
            var paid_amount = $('#total_amount').val();
            var discount_amount = $('#dis_total_amount').val();

            $('#voucher_total_amount').val(+paid_amount + +discount_amount);
        }
    </script>
@endsection
