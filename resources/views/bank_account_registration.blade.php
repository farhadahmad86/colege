@extends('extend_index')
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Bank Account Registration</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('bank_account_list') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="excel_con gnrl-mrgn-pdng gnrl-blk">
                <div class="excel_box gnrl-mrgn-pdng gnrl-blk">
                    <div class="excel_box_hdng gnrl-mrgn-pdng gnrl-blk">
                        <h2 class="gnrl-blk gnrl-mrgn-pdng gnrl-font-bold">
                            Upload Excel File
                        </h2>
                    </div>
                    <div class="excel_box_content gnrl-mrgn-pdng gnrl-blk">
                        <form action="{{ route('submit_bank_account_registration_excel') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Select Excel File
                                        </label>
                                        <input tabindex="100" type="file" name="add_other_account_excel" id="add_other_account_excel" class="inputs_up form-control-file form-control height-auto"
                                               accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div><!-- end input box -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <a href="{{ url('public/sample/bank_account/add_bank_account_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
                                        Download Sample Pattern
                                    </a>
                                    <button tabindex="101" type="submit" name="save" id="save2" class="save_button btn btn-sm btn-success">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>


            <form name="f1" class="f1" id="f1" action="{{ route('submit_bank_account_registration') }}"
                  onsubmit="return checkForm()" method="post">
                @csrf

                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mx-auto">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.child_account.description')}}</p>
                                                <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.child_account.benefits')}}</p>
                                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.child_account.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Child Account <span></span>
                                            </label>
                                            <select tabindex=1 autofocus name="head_code" id="head_code" class="inputs_up form-control"
                                                    onchange="check_name()">
                                                <option value="{{$bank_account}}">Bank</option>
                                            </select>
                                            <span id="demo3" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                <a
                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.description')}}</p><h6>Benefit</h6><p>{{
                                                    config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.benefits')}}</p><h6>Example</h6><p>{{
                                                    config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Account Ledger Access Group<span></span>
                                                <a href="{{ route('add_account_group') }}" class="add_btn"
                                                   target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                   data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                    <l class="fa fa-plus"></l>
                                                </a>
                                                <a id="refresh_group" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                   data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                    <l class="fa fa-refresh"></l>
                                                </a>
                                            </label>
                                            <select tabindex="2" name="group" id="group" class="inputs_up form-control" data-rule-required="true"
                                                    data-msg-required="Please Enter Account Ledger Access Group">
                                                <option value="">Select Account Ledger Access Group</option>
                                                @foreach($groups as $group)
                                                    <option
                                                        value="{{$group->ag_id}}" {{ $group->ag_id == old('group') ? 'selected="selected"' : '' }}>{{$group->ag_title}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo7" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>
{{--                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- invoice column start -->--}}
{{--                                        <x-branch-component />--}}
{{--                                    </div>--}}
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.account_registration.bank_account.account_ledger.description')}}</p>
                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.account_registration.bank_account.account_ledger.benefits')}}</p>
                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.account_registration.bank_account.account_ledger.example')}}</p>
                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.account_registration.bank_account.account_ledger.validations') }}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Account Ledger</label>
                                            <input tabindex="3" type="text" name="account_name" id="account_name"
                                                   class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Account Ledger"
                                                   placeholder="Account Ledger" autocomplete="off"
                                                   value="{{ old('account_name') }}">
                                            <span id="demo4" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden>
                                        <div class="input_bx"><!-- start input box -->
                                            <label>Balance</label>
                                            <input tabindex="-1" type="number" name="opening_balance" id="opening_balance"
                                                   class="cnic inputs_up form-control"
                                                   placeholder="Balance" step="any" autocomplete="off">
                                            <span id="demo5" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a
                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Remarks</label>
                                        <textarea tabindex="4" name="remarks" id="remarks" class="inputs_up remarks form-control"
                                                  placeholder="Remarks" style="height: 167px">{{ old('remarks') }}</textarea>
                                        <span id="demo6" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                <button tabindex="5" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                                    <i class="fa fa-eraser"></i> Cancel
                                </button>
                                <button tabindex="6" type="button" name="save" id="save" class="save_button btn btn-sm btn-success"
                                >
                                    <i class="fa fa-floppy-o"></i> Save
                                </button>
                            </div>
                        </div>

                    </div> <!-- left column ends here -->
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                    </div> <!-- right columns ends here -->

                </div> <!--  main row ends here -->
            </form>
        </div>
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let group = document.getElementById("group"),
                account_name = document.getElementById("account_name"),
                validateInputIdArray = [
                    group.id,
                    account_name.id,
                ];
            // return validateInventoryInputs(validateInputIdArray);
            var check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                let head_code = document.getElementById("head_code").value,
                    remarks = document.getElementById("remarks").value;

                jQuery(".pre-loader").fadeToggle("medium");

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('submit_bank_account_registration')}}",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'head_code': head_code,
                        'group': group.value,
                        'account_name': account_name.value,
                        'remarks': remarks,
                    },

                    success: function (data) {
                        console.log(data);
                        console.log(data.message);
                        if (data.already_exist != null) {
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Already Exist Account Name Please Try Another Name',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });

                        } else {
                            $('#account_name').val('');
                            $('#remarks').val('');

                            swal.fire({
                                title: 'Successfully Saved' + '  ' + data.name,
                                text: false,
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });
                        }

                        jQuery(".pre-loader").fadeToggle("medium");
                    },
                    error: function error(xhr, textStatus, errorThrown, jqXHR) {
                        console.log(xhr.responseText, textStatus, errorThrown, jqXHR);
                        console.log('ajax company error');
                    },
                    // error: function () {
                    //     alert('error handling here');
                    // }
                });
            } else {
                return false;
            }
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        $("#save").click(function () {
            checkForm();
        });
    </script>
    <!-- validating on form -->
    <style>
        /* Hide HTML5 Up and Down arrows. */
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

    <script>

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        jQuery("#refresh_head").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_head",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#head_code").html(" ");
                    jQuery("#head_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_group").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_reporting_group",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#group").html(" ");
                    jQuery("#group").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

    <script>

        $('.number').on('keypress keyup blur keydown', function () {
            var currentInput = $(this).val();
            var fixedInput = currentInput.replace(/[A-Za-z!@#$%^&*()]/g, '');
            $(this).val(fixedInput);
        });

    </script>

    <script>
        var check = "true";

        function check_name() {

            var account_name = document.getElementById("account_name").value;
            var head_code = document.getElementById("head_code").value;

            if (account_name != '' && head_code != '') {
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.ajax({

                    url: "check_name",
                    data: {
                        account_name: account_name,
                        head_code: head_code
                    },
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        // alert(data);

                        if (data.trim() == "yes") {
                            check = "false";

                            document.getElementById("demo4").innerHTML = "Choose Another Name";
                            jQuery("#account_name").focus();

                        } else {
                            document.getElementById("demo4").innerHTML = "";
                            check = "true";
                            // return check;
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        check = "false";
                        // return check;
                    }
                });
                return check;
            } else {
                return check;
            }


        }

    </script>

    <script type="text/javascript">

        function validate_form() {

            var head_code = document.getElementById("head_code").value;
            var group = document.getElementById("group").value;
            var account_name = document.getElementById("account_name").value;
            var opening_balance = document.getElementById("opening_balance").value;

            var flag_submit = true;
            var focus_once = 0;


            if (head_code.trim() == "") {
                document.getElementById("demo3").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#head_code").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo3").innerHTML = "";
            }

            // if (group.trim() == "") {
            //     document.getElementById("demo7").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#group").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo7").innerHTML = "";
            // }
            //
            // if (account_name.trim() == "") {
            //     document.getElementById("demo4").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#account_name").focus();
            //         focus_once = 1;
            //     }
            //
            //     flag_submit = false;
            // } else {
            //
            //     if (check_name() == 'false') {
            //
            //         // if (focus_once == 0) { jQuery("#account_name").focus(); focus_once = 1;  }
            //         flag_submit = false;
            //     } else {
            //         document.getElementById("demo4").innerHTML = "";
            //     }
            //     // document.getElementById("demo5").innerHTML = "";
            // }

            if (opening_balance.trim() != "") {
                if (!validatebcode(opening_balance)) {

                    document.getElementById("demo5").innerHTML = "Only Digits";
                    if (focus_once == 0) {
                        jQuery("#opening_balance").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            } else {
                document.getElementById("demo5").innerHTML = "";
            }

            return flag_submit;
        }

    </script>

    <script>
        function validate_ntn(val_ntn) {
            var val_n = /^\d{7}-?\d$/;
            if (val_n.test(val_ntn)) {
                return true;
            } else {
                return false;
            }
        }

        function validate_gst(val_gst) {
            var val_n = /^([0-9]{1}[0-9]{1})-?([0-9]{1}[0-9]{1})-?([0-9]{4}-?[0-9]{3}-?[0-9]{2})+$|^([0-9]{1}[0-9]{1}) ?([0-9]{1}[0-9]{1}) ?([0-9]{4} ?[0-9]{3} ?[0-9]{2})+$/;
            if (val_n.test(val_gst)) {
                return true;
            } else {
                return false;
            }
        }

        function validatebcode(pas) {
            var pass = /^-?[0-9]\d*(\.\d+)?$/;
            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }

        // validate phone number
        function validatephone(phone_num) {
            var ph = /^\d{3}-?\d{3}-?\d{4}$|^\d{3} ?\d{3} ?\d{4}$/;
            if (ph.test(phone_num)) {
                return true;
            } else {
                return false;
            }
        }

        // validate mobile number
        function validatemobile(phone_num) {
            var ph = /^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/;
            if (ph.test(phone_num)) {
                return true;
            } else {
                return false;
            }
        }

        // email checking

        function checkemail(email_address) {
            if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email_address)) {
                return true;
            } else {
                return false;
            }
        }

        // validating ID card
        function validatecnic(cnic_num) {


            myRegExp = new RegExp(/^\d{5}-\d{7}-\d$|^\d{13}$/);

            if (myRegExp.test(cnic_num)) {
                //if true
                return true;
            } else {
                //if false
                return false;
            }
        }


    </script>
    <!-- validating on form ended-->

    <!--additional scripting starts here  -->
    <script type="text/javascript">


        // **********************************************************only number enter **********************************************************
        // function isNumber(evt) {
        //     evt = (evt) ? evt : window.event;
        //     var charCode = (evt.which) ? evt.which : evt.keyCode;
        //     if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //         return false;
        //     }
        //     return true;
        // }
        // **********************************************************Number with plus and hyphen only**********************************************************
        function isNumberWithHyphen(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 32 || charCode == 45 || charCode == 43) {
                return true
            } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        //***********************************************************************copy_number *******************************************************
        //copying whatsapp  mobile number to whatsapp number
        function copy_number(a) {
            var phone = jQuery("#mobile").val();
            var whatsapp = jQuery("#whatsapp").val();
            if (whatsapp == "") {
                jQuery("#whatsapp").val(phone);
            }
        }

    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#head_code").select2();
            jQuery("#group").select2();
        });
    </script>
    <!-- additionl scripting ednds here-->

@endsection

