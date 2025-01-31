@extends('extend_index')

@section('content')

    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

        <div class="clearfix">
            <div class="pull-left">
                <h4 class="text-blue get-heading-text">Change Password</h4>
            </div>
        </div>

        <form name="f1" class="f1" id="f1" action="{{route("submit_machine_password")}}"
              method="post">
            @csrf
            <div class="row">
                <input name="machine_id" id="machine_id" type="hidden" value="{{$request->title}}">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="required">Old Password</label>
                            <span id="demo1" class="validate_sign"> </span>
                            <input tabindex="1" autofocus type="password" name="old_password" id="old_password" class="form-control"
                                   placeholder="Old Password" autocomplete="off"/>
                            <span toggle="#old_password-field"
                                  class="fa-eye-slash fa fa-fw field-icon toggle-old_password"></span>
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="required">New Password</label>
                            <span id="demo2" class="validate_sign"> </span>
                            <input tabindex="2" type="password" name="password" id="password" class="form-control"
                                   placeholder="New Password" autocomplete="off"/>
                            <span toggle="#password-field"
                                  class="fa-eye-slash fa fa-fw field-icon toggle-password"></span>
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="required">Confirm Password</label>
                            <span id="demo3" class="validate_sign"> </span>
                            <input tabindex="3" type="password" name="password_confirmation" id="confirm_password" class="form-control"
                                   placeholder="Confirm Password" autocomplete="off"/>
                            <span toggle="#confirm_password-field"
                                  class="fa-eye-slash fa fa-fw field-icon toggle-confirm_password"></span>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-1 col-md-1"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <button tabindex="4" type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                Cancel
                            </button>
                        </div>
                        <div class="col-lg-6 col-md-6"></div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <button tabindex="5" type="submit" name="save" id="save" class="save_button form-control">Save
                            </button>
                        </div>
                    </div>

                </div> <!-- left column ends here -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    {{--<div class="show_info_div">--}}

                    {{--</div>--}}

                </div> <!-- right columns ends here -->

            </div> <!--  main row ends here -->


        </form>
    </div> <!-- white column form ends here -->

@endsection

@section('scripts')

    <script type="text/javascript">


        function form_validation() {
            var oldpassword = document.getElementById("old_password").value;
            var newpassword = document.getElementById("password").value;
            var confirmpass = document.getElementById("confirm_password").value;

            var flag_submit = true;
            var focus_once = 0;

            if (oldpassword == "") {

                document.getElementById("demo1").innerHTML = "Required";
                //  alert_message("First Name Is Required");
                if (focus_once == 0) {
                    jQuery("#old_password").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo1").innerHTML = "";
            }

            if (newpassword == "") {

                document.getElementById("demo2").innerHTML = "Required";

                if (focus_once == 0) {
                    jQuery("#password").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {

                if (!validatepass(newpassword)) {
                    document.getElementById("demo2").innerHTML = "Max.Length (8),One Digit,Uppercase,Lowercase & Special Character";
                    if (focus_once == 0) {
                        jQuery("#password").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {

                    document.getElementById("demo2").innerHTML = "";

                }

            }

            if (confirmpass == "") {
                document.getElementById("demo3").innerHTML = "Required";

                if (focus_once == 0) {
                    jQuery("#confirm_password").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {

                if (confirmpass != newpassword) {
                    document.getElementById("demo3").innerHTML = "Password Do Not Match";

                    if (focus_once == 0) {
                        jQuery("#confirm_password").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo3").innerHTML = "";

                }

            }

            return flag_submit;
        }

    </script>

    <script type="text/javascript">


        // added for password visiblity

        jQuery(".toggle-old_password").click(function () {
            jQuery(this).toggleClass("fa-eye-slash fa-eye");
            var xx = document.getElementById("old_password");
            if (xx.type === "password") {
                xx.type = "text";
            } else {
                xx.type = "password";
            }

        });


        jQuery(".toggle-password").click(function () {
            jQuery(this).toggleClass("fa-eye-slash fa-eye");
            var xx = document.getElementById("password");
            if (xx.type === "password") {
                xx.type = "text";
            } else {
                xx.type = "password";
            }

        });

        jQuery(".toggle-confirm_password").click(function () {
            jQuery(this).toggleClass("fa-eye-slash fa-eye");
            var x2 = document.getElementById("confirm_password");
            if (x2.type === "password") {
                x2.type = "text";
            } else {
                x2.type = "password";
            }

        });

        //Validate PASSWORD
        function validatepass(pas) {
            // With Space
            //^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$
            var pass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!~%_`#*()+=?&/^-])[A-Za-z\d$@$!~%_`#*()+=?&/^-]{8,}$/;
            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }

        jQuery(document).ready(function () {
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");

            if (msie > 0) // If Internet Explorer, return version number
            {
                jQuery(".toggle-password").attr("style", "display:none !important");
                jQuery(".toggle-confirm_password").attr("style", "display:none !important");
                jQuery(".toggle-old_password").attr("style", "display:none !important");

            } else {

            }

        });

    </script>

@endsection


