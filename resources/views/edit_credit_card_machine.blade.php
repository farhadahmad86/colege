
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Edit Credit Card Machine</h4>
                            </div>
                        </div>
                    </div><!-- form header close -->

                    <form name="f1" class="f1" id="f1" action="{{ route('update_credit_card_machine') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                                <div class="row">

                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                   data-placement="bottom" data-html="true"
                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.machine_title.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.machine_title.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.machine_title.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Machine Title
                                            </label>
                                            <input type="text" name="name" id="name" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Machine Title" placeholder="Machine Title" autofocus value="{{$credit_card_machine->ccm_title}}"/>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">Bank</label>
                                            <select name="bank" class="inputs_up form-control" id="bank" data-rule-required="true" data-msg-required="Please Enter Bank Title" style="width: 100%">
                                                <option value="">Select Bank</option>
                                                @foreach($banks as $bank)
                                                    <option value="{{$bank->account_uid}}" {{ $bank->account_uid == $credit_card_machine->ccm_bank_code ? 'selected="selected"' : '' }}>{{$bank->account_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo2" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="row">

                                            <input type="hidden" id="machine_id" name="machine_id" value="{{$credit_card_machine->ccm_id}}">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.percentage.description')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.percentage.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Percentage</label>
                                                    <input type="text" name="percentage" id="percentage" data-rule-required="true" data-msg-required="Please Enter Percentage" class="inputs_up form-control" placeholder="Percentage" onkeypress="return isNumberKey(event)" value="{{$credit_card_machine->ccm_percentage}}"/>
                                                    <span id="demo3" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.merchant_code.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.merchant_code.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.merchant_code.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Merchant Code</label>
                                                    <input type="text" name="merchant_id" id="merchant_id" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Merchant Code" placeholder="Merchant Code" value="{{$credit_card_machine->ccm_merchant_id}}"/>
                                                    <span id="demo4" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                                                    <textarea name="remarks" id="remarks" class="inputs_up remarks form-control">{{$credit_card_machine->ccm_remarks}}</textarea>
                                                    <span id="demo5" class="validate_sign"> </span>
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
                                        <button type="submit" name="save" id="save" class="save_button form-control"
                                        >
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                    </div>
                                </div>

                            </div> <!-- left column ends here -->

                        </div> <!--  main row ends here -->


                    </form>
                </div> <!-- white column form ends here -->

            </div>


        </div>

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let name = document.getElementById("name"),
                bank = document.getElementById("bank"),
                percentage = document.getElementById("percentage"),
                merchant_id = document.getElementById("merchant_id");
            validateInputIdArray = [
                name.id,
                bank.id,
                percentage.id,
                merchant_id.id,
            ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">


        function form_validation()
        {
            var name  = document.getElementById("name").value;
            var bank  = document.getElementById("bank").value;
            var percentage  = document.getElementById("percentage").value;
            var merchant_id  = document.getElementById("merchant_id").value;
            var remarks  = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if(name.trim() == "")
            {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#name").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo1").innerHTML = "";
            }

            if(bank.trim() == "")
            {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#bank").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo2").innerHTML = "";
            }

            if(percentage.trim() == "")
            {
                document.getElementById("demo3").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#percentage").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                if (!validaterate(percentage)) {
                    document.getElementById("demo3").innerHTML = "Wrong Entry";
                    if (focus_once == 0) {
                        jQuery("#percentage").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
                else {
                    document.getElementById("demo3").innerHTML = "";
                }

            }

            if(merchant_id.trim() == "")
            {
                document.getElementById("demo4").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#merchant_id").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo4").innerHTML = "";
            }

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
            jQuery("#bank").select2();
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

@endsection


