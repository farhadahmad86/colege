
@extends('extend_index')

@section('content')

    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-blue get-heading-text">{{$title}} Account Registration</h4>
                </div>
                <a class="btn btn-primary add_more_button" href="account_receivable_payable_list" role="button"><li class="fa fa-list"></li></a>
            </div>
            <form name="f1" class="f1" id="f1" action="{{$title == 'Receivables' ? 'submit_receivables_account':'submit_payables_account'}}"  onsubmit="return checkForm()" method="post">
                @csrf
                <div class="form-group row">
                    <div class="col-lg-4 col-md-4">
                        <label class="required">Select Region</label>
                        <span id="demo1" class="validate_sign"> </span>
                        <select class=" form-control" name="region" id="region" style="width: 100%">
                            <option value="">Select Region</option>
                            @foreach($regions as $region)
                                <option value="{{$region->reg_id}}" {{ $region->reg_id == old('region') ? 'selected="selected"' : '' }}>{{$region->reg_title}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="required">Select Area</label>
                        <span id="demo2" class="validate_sign"> </span>
                        <select class=" form-control" name="area" id="area" style="width: 100%">
                            <option value="">Select Area</option>

                        </select>

                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="required">Select Sector</label>
                        <span id="demo3" class="validate_sign"> </span>
                        <select class=" form-control" name="sector" id="sector" style="width: 100%">
                            <option value="">Select Sector</option>

                        </select>

                    </div>

                </div>


                <div class="form-group row">

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="required">Group</label>
                        <span id="demo70" class="validate_sign"> </span>
                        <select name="group" id="group" class="form-control" style="width: 100%">
                            <option value="">Select Group</option>
                            @foreach($groups as $group)
                                <option value="{{$group->ag_id}}" {{ $group->ag_id == old('group') ? 'selected="selected"' : '' }}>{{$group->ag_title}}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 ">
                        <label class="required">Account Name</label>
                        <span id="demo5" class="validate_sign"> </span>
                        <input type="text" name="account_name" id="account_name" class="form-control"
                               placeholder="Account Name" value="{{old('account_name')}}" onblur="check_name()" autocomplete="off">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6 ">
                        <label class="">Remarks</label>
                        <span id="demo5" class="validate_sign"> </span>
                        <input type="text" name="remarks" id="remarks" class="form-control"
                               placeholder="Remarks" value="{{old('account_remarks')}}" autocomplete="off">
                    </div>

                </div> <!-- row ends here -->
                <!-- second row starts here -->
                <div class="form-group row">
                    <div class="col-lg-5 col-md-6">
                        <label class="">Print Name</label>
                        <input type="text" name="print_name" id="print_name" class="print_name form-control"
                               placeholder="Print Name" value="{{old('print_name')}}" autocomplete="off">
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label>CNIC</label>
                        <span id="demo6" class="validate_sign"> </span>
                        <input type="text" name="cnic" id="cnic" class="cnic form-control"
                               placeholder="11111-1111111-1" value="{{old('cnic')}}"
                               onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                    </div>
                    {{--<div class="col-lg-2 col-md-2 col-sm-2">--}}
                        {{--<label class="required">Account Type</label>--}}
                        {{--<span id="demo7" class="validate_sign"> </span>--}}
                        {{--<select name="account_nature" id="account_nature" class="head_code form-control">--}}
                            {{--<option value="">Type</option>--}}
                            {{--<option value="1" {{ '1' == old('account_nature') ? 'selected="selected"' : '' }}>Dr--}}
                            {{--</option>--}}
                            {{--<option value="2" {{ '2' == old('account_nature') ? 'selected="selected"' : '' }}>Cr--}}
                            {{--</option>--}}
                            {{--<option value="3" {{ '3' == old('account_nature') ? 'selected="selected"' : '' }}>Both--}}
                            {{--</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    <div class="col-lg-3 col-md-6">
                        <label>Balance</label>
                        <span id="demo8" class="validate_sign"> </span>
                        <input type="number" name="opening_balance" id="opening_balance" class="cnic form-control"
                               placeholder="Balance" value="{{old('opening_balance')}}" step="any" autocomplete="off">
                    </div>
                </div>
                <!-- second row ends here-->
                <!-- region row-->

                <!-- region ends -->
                <!-- Third Row starts here-->
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label class="">Address</label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Address"
                               value="{{old('address')}}" autocomplete="off">
                    </div>
                </div>
                <!-- Third Row ends here -->
                <!-- fourth row starts here -->
                <div class="form-group row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label>Proprietor</label>
                        <input type="text" name="proprietor" id="proprietor" class="form-control"
                               placeholder="Proprietor" value="{{old('proprietor')}}" autocomplete="off">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label>Co. Code</label>
                        <input type="text" name="co_code" id="co_code" class="form-control" placeholder="Co. Code"
                               value="{{old('co_code')}}" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <label>Mobile</label>
                        <span id="demo9" class="validate_sign"> </span>
                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No."
                               onblur="copy_number(this)" value="{{old('mobile')}}"
                               onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <label>WhatsApp</label>
                        <span id="demo10" class="validate_sign"> </span>
                        <input type="text" name="whatsapp" id="whatsapp" class="form-control" placeholder="WhatsApp"
                               value="{{old('whatsapp')}}" onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                        {{--onkeypress="return isNumber(event)"--}}
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <label>Phone</label>
                        <span id="demo11" class="validate_sign"> </span>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone"
                               value="{{old('phone')}}" onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                    </div>
                </div>
                <!-- fourth row ends here  -->
                <!-- fifth row starts here -->
                <div class="form-group row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <label>Email</label>
                        <span id="demo12" class="validate_sign"> </span>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                               value="{{old('email')}}" autocomplete="off">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <label>GST</label>
                        <span id="demo13" class="validate_sign"> </span>
                        <input type="text" name="gst" id="gst" class="form-control number" placeholder="GST"
                               value="{{old('gst')}}" onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <label>NTN</label>
                        <span id="demo14" class="validate_sign"> </span>
                        <input type="text" name="ntn" id="ntn" class="form-control number" placeholder="NTN"
                               value="{{old('ntn')}}" onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                    </div>


                </div>
                <!-- fifth row ends here  -->
                <!-- last row starts here -->
                <div class="form-group row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label>Credit Limit</label>
                        <span id="demo15" class="validate_sign"> </span>
                        <input type="text" name="credit_limit" id="credit_limit" class="form-control"
                               placeholder="Credit Limit" value="{{old('credit_limit')}}"
                               onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label>Page No.</label>
                        <input type="text" name="page_no" id="page_no" class="form-control" placeholder="Page No."
                               value="{{old('page_no')}}" autocomplete="off">
                    </div>
                </div>
                <!-- last row ends here -->
                <div class="form-group row">
                    <div class="col-lg-1 col-md-1"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">Cancel
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="submit" name="save" id="save" class="save_button form-control" >Save</button>
                    </div>
                </div>


            </form>
        </div>

@endsection

@section('scripts')

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
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let account = document.getElementById("account"),
                totalAmount = document.getElementById("total_amount");
            validateInputIdArray = [
                account.id,
                totalAmount.id,
            ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>

        $('.number').on('keypress keyup blur keydown', function () {
            var currentInput = $(this).val();
            var fixedInput = currentInput.replace(/[A-Za-z!@#$%^&*()]/g, '');
            $(this).val(fixedInput);
        });

        jQuery("#region").change(function () {

            var dropDown = document.getElementById('region');
            var reg_id = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_area",
                data: {reg_id: reg_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#area").html(" ");
                    jQuery("#area").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

        jQuery("#area").change(function () {

            var dropDown = document.getElementById('area');
            var area_id = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_sector",
                data: {area_id: area_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#sector").html(" ");
                    jQuery("#sector").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

    </script>

    <script>
        var check ="true";
        function check_name() {

            var account_name = document.getElementById("account_name").value;
            var head_code = '{{config('global_variables.receivable')}}';

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

                        document.getElementById("demo5").innerHTML = "Choose Another Name";
                        jQuery("#account_name").focus();

                    } else {
                        document.getElementById("demo5").innerHTML = "";
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
        }else{
                return check;
            }


        }

    </script>

    <script type="text/javascript">

        function validate_form() {

            var region = document.getElementById("region").value;
            var area = document.getElementById("area").value;
            var sector = document.getElementById("sector").value;
            var account_name = document.getElementById("account_name").value;

            var cnic = document.getElementById("cnic").value;
            // var account_nature = document.getElementById("account_nature").value;
            var opening_balance = document.getElementById("opening_balance").value;
            var mobile = document.getElementById("mobile").value;
            var whatsapp = document.getElementById("whatsapp").value;
            var phone = document.getElementById("phone").value;
            var email = document.getElementById("email").value;
            var ntn = document.getElementById("ntn").value;
            var gst = document.getElementById("gst").value;
            var credit_limit = document.getElementById("credit_limit").value;
            var group = document.getElementById("group").value;

            var flag_submit = true;
            var focus_once = 0;


            if (region.trim() == "") {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#region").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo1").innerHTML = "";
            }

            if (area.trim() == "") {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#area").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo2").innerHTML = "";
            }



            if (sector.trim() == "") {
                document.getElementById("demo3").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#sector").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo3").innerHTML = "";
            }

            if (group.trim() == "") {
                document.getElementById("demo70").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#group").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo70").innerHTML = "";
            }

            if (account_name.trim() == "") {
                document.getElementById("demo5").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#account_name").focus();
                    focus_once = 1;
                }

                flag_submit = false;
            } else {

                if(check_name() == 'false'){

                    // if (focus_once == 0) { jQuery("#account_name").focus(); focus_once = 1;  }
                    flag_submit = false;
                }else{
                    document.getElementById("demo5").innerHTML = "";
                }
               // document.getElementById("demo5").innerHTML = "";
            }

            if (cnic.trim() != "") {
                if (!validatecnic(cnic)) {
                    document.getElementById("demo6").innerHTML = "Invalid";
                    if (focus_once == 0) {
                        jQuery("#cnic").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo6").innerHTML = "";
                }
            } else {
                document.getElementById("demo6").innerHTML = "";
            }


            // if (account_nature.trim() == "") {
            //     document.getElementById("demo7").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#account_nature").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo7").innerHTML = "";
            // }


            if (opening_balance.trim() != "") {
                if (!validatebcode(opening_balance)) {

                    document.getElementById("demo8").innerHTML = "Only Digits";
                    if (focus_once == 0) {
                        jQuery("#opening_balance").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            } else {
                document.getElementById("demo8").innerHTML = "";
            }


            if (mobile.trim() != "") {
                if (!validatemobile(mobile)) {
                    document.getElementById("demo9").innerHTML = "Invalid";
                    if (focus_once == 0) {
                        jQuery("#mobile").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo9").innerHTML = "";
                }
            } else {
                document.getElementById("demo9").innerHTML = "";
            }


            if (whatsapp.trim() != "") {
                if (!validatemobile(whatsapp)) {
                    document.getElementById("demo10").innerHTML = "Invalid";
                    if (focus_once == 0) {
                        jQuery("#whatsapp").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo10").innerHTML = "";
                }
            } else {
                document.getElementById("demo10").innerHTML = "";
            }


            if (phone.trim() != "") {
                if (!validatephone(phone)) {
                    document.getElementById("demo11").innerHTML = "Invalid";
                    if (focus_once == 0) {
                        jQuery("#phone").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo11").innerHTML = "";
                }
            } else {
                document.getElementById("demo11").innerHTML = "";
            }


            if (email.trim() != "") {
                if (!checkemail(email)) {
                    document.getElementById("demo12").innerHTML = "Invalid";
                    if (focus_once == 0) {
                        jQuery("#email").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            } else {
                document.getElementById("demo12").innerHTML = "";
            }


            if (gst.trim() != "") {
                if (!validate_gst(gst)) {
                    document.getElementById("demo13").innerHTML = "Length 13 Digits";
                    if (focus_once == 0) {
                        jQuery("#gst").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo13").innerHTML = "";
                }
            } else {
                document.getElementById("demo13").innerHTML = "";
            }


            if (ntn.trim() != "") {
                if (!validate_ntn(ntn)) {
                    document.getElementById("demo14").innerHTML = "Length 8 Digits";
                    if (focus_once == 0) {
                        jQuery("#ntn").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo14").innerHTML = "";
                }
            } else {
                document.getElementById("demo14").innerHTML = "";
            }


            if (credit_limit.trim() != "") {
                if (!validatebcode(credit_limit)) {
                    document.getElementById("demo15").innerHTML = "Only Digits";
                    if (focus_once == 0) {
                        jQuery("#credit_limit").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo15").innerHTML = "";
                }
            } else {
                document.getElementById("demo15").innerHTML = "";
            }


            return flag_submit;
        }

    </script>

    <script>
        function validate_ntn(val_ntn) {
            var val_n = /^\d{7}-?\d$/;
            if (val_n.test(val_ntn)) {
                return true;
            }
            else {
                return false;
            }
        }

        function validate_gst(val_gst) {
            var val_n = /^([0-9]{1}[0-9]{1})-?([0-9]{1}[0-9]{1})-?([0-9]{4}-?[0-9]{3}-?[0-9]{2})+$|^([0-9]{1}[0-9]{1}) ?([0-9]{1}[0-9]{1}) ?([0-9]{4} ?[0-9]{3} ?[0-9]{2})+$/;
            if (val_n.test(val_gst)) {
                return true;
            }
            else {
                return false;
            }
        }

        function validatebcode(pas) {
            var pass = /^-?[0-9]\d*(\.\d+)?$/;
            if (pass.test(pas)) {
                return true;
            }
            else {
                return false;
            }
        }

        // validate phone number
        function validatephone(phone_num) {
            var ph = /^\d{3}-?\d{3}-?\d{4}$|^\d{3} ?\d{3} ?\d{4}$/;
            if (ph.test(phone_num)) {
                return true;
            }
            else {
                return false;
            }
        }

        // validate mobile number
        function validatemobile(phone_num) {
            var ph = /^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/;
            if (ph.test(phone_num)) {
                return true;
            }
            else {
                return false;
            }
        }

        // email checking

        function checkemail(email_address) {
            if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email_address)) {
                return true;
            }
            else {
                return false;
            }
        }

        // validating ID card
        function validatecnic(cnic_num) {


            myRegExp = new RegExp(/^\d{5}-\d{7}-\d$|^\d{13}$/);

            if (myRegExp.test(cnic_num)) {
                //if true
                return true;
            }
            else {
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
            jQuery("#region").select2();
            jQuery("#area").select2();
            jQuery("#sector").select2();
            jQuery("#group").select2();

        });
    </script>
    <!-- additionl scripting ednds here-->

@endsection

