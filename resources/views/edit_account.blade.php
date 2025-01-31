@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Edit Entry Account</h4>
                            </div>
                        </div>
                    </div><!-- form header close -->

                    <form name="f1" class="f1" id="f1" action="{{ route('update_account') }}"
                          onsubmit="return checkForm()"
                          method="post">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="row">

                                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.control_account.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.control_account.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.control_account.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.control_account.validations') }}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Control Account
                                                    </label>
                                                    <input type="text" name="first_head" id="first_head"
                                                           data-rule-required="true" data-msg-required="Please Enter Control Account"
                                                           class="form-control inputs_up" autocomplete="off" value="{{$first_head->coa_head_name}}"
                                                           readonly>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                    <input value="{{$account->account_id}}" name="account_id" type="hidden">
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.parent_account.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.parent_account.benefits')}}</p>
<h6>Example</h6><p>{{config('fields_info.about_form_fields.parent_account.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Parent Account
                                                    </label>
                                                    <input type="text" name="second_head" id="second_head" class="form-control inputs_up"
                                                           data-rule-required="true" data-msg-required="Please Enter Parent Account"
                                                           autocomplete="off" value="{{$second_head->coa_head_name}}"
                                                           readonly>
                                                    <span id="demo2" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.child_account.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.child_account.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.child_account.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Child Account
                                                    </label>
                                                    <input type="text" name="third_head" id="third_head"
                                                           data-rule-required="true" data-msg-required="Please Enter Child Account"
                                                           class="form-control inputs_up" autocomplete="off" value="{{$third_head->coa_head_name}}"
                                                           readonly>
                                                    <input value="{{$third_head->coa_code}}" name="head_code" type="hidden">
                                                    <span id="demo3" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                                                        Account Ledger Access Group
                                                    </label>
                                                    <select name="group" id="group" class="inputs_up form-control"
                                                            data-rule-required="true"
                                                            data-msg-required="Please Enter Account Ledger Access Group">
                                                        <option value="">Select Group</option>
                                                        @foreach($groups as $group)
                                                            <option value="{{$group->ag_id}}" {{ $group->ag_id == $account->account_group_id ? 'selected="selected"' : '' }}>{{$group->ag_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo7" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.account_registration.bank_account.account_ledger.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.account_registration.bank_account.account_ledger.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.account_registration.bank_account.account_ledger.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.account_registration.bank_account.account_ledger.validations') }}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Account Ledger
                                                    </label>
                                                    <input type="text" name="account_name" id="account_name"
                                                           data-rule-required="true" data-msg-required="Please Enter Account Ledger"
                                                           class="form-control inputs_up" placeholder="Account Ledger" autocomplete="off"
                                                           value="{{$account->account_name}}">
                                                    <span id="demo4" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12" hidden>
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>Balance</label>
                                                    <input type="number" name="opening_balance" id="opening_balance" class="cnic inputs_up form-control" placeholder="Balance" step="any"
                                                           autocomplete="off" value="{{$account->account_balance}}" readonly>
                                                    <span id="demo5" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        <a
                                                            data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Remarks</label>
                                                    <textarea name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks">{{$account->account_remarks}}</textarea>
                                                    <span id="demo6" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                        <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                            <i class="fa fa-eraser"></i> Cancel
                                        </button>
                                        <button type="submit" name="save" id="save" class="save_button form-control">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                    </div>
                                </div>

                            </div> <!-- left column ends here -->

                        </div> <!--  main row ends here -->
                    </form>
                </div>


            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let first_head = document.getElementById("first_head"),
                second_head = document.getElementById("second_head"),
                third_head = document.getElementById("third_head"),
                group = document.getElementById("group"),
                account_name = document.getElementById("account_name"),
                validateInputIdArray = [
                    first_head.id,
                    second_head.id,
                    third_head.id,
                    group.id,
                    account_name.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
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

    <script type="text/javascript">

        function validate_form() {

            var account_name = document.getElementById("account_name").value;
            var opening_balance = document.getElementById("opening_balance").value;
            var group = document.getElementById("group").value;


            var flag_submit = true;
            var focus_once = 0;


            if (group.trim() == "") {
                document.getElementById("demo7").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#group").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo7").innerHTML = "";
            }

            if (account_name.trim() == "") {
                document.getElementById("demo4").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#account_name").focus();
                    focus_once = 1;
                }

                flag_submit = false;
            } else {

                // if(check_name() == 'false'){
                //
                //     // if (focus_once == 0) { jQuery("#account_name").focus(); focus_once = 1;  }
                //     flag_submit = false;
                // }else{
                document.getElementById("demo4").innerHTML = "";
                // }
                // document.getElementById("demo5").innerHTML = "";
            }

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
        function validatebcode(pas) {
            var pass = /^-?[0-9]\d*(\.\d+)?$/;
            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }
    </script>

    <script>
        jQuery(document).ready(function () {
            jQuery("#group").select2();
        });
    </script>
    <!-- additionl scripting ednds here-->

@endsection

