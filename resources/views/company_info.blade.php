@extends('extend_index')

@section('content')

    <div class="row">
        <div
            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Company Profile</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{ route('update_company_info') }}"
                      onsubmit="return checkForm()"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="row">

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.company_info.name.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Name</label>
                                        <input type="text" name="name" id="name" class="inputs_up form-control"
                                               data-rule-required="true" data-msg-required="Please Enter Name"
                                               placeholder="Name" value="{{$company_information->ci_name}}">
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a
                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.email.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.email.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.email.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Email</label>
                                        <input type="email" name="email" id="email" class="inputs_up form-control"
                                               data-rule-required="true" data-msg-required="Please Enter Email"
                                               placeholder="Email" value="{{$company_information->ci_email}}">
                                        <span id="demo2" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.mobile.description')}}</p>
                                                 <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.mobile.benefits')}}</p>
                                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.mobile.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Mobile Number</label>
                                        <input type="text" name="mobile" id="mobile" class="inputs_up form-control"
                                               placeholder="Mobile Number" onkeypress="return isNumberWithHyphen(event)"
                                               value="{{$company_information->ci_mobile_numer}}">
                                        <span id="demo3" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a
                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.whatsApp.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.whatsApp.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.whatsApp.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Whatsapp</label>
                                        <input type="text" name="whatsapp" id="whatsapp" class="inputs_up form-control"
                                               placeholder="Whatsapp" onkeypress="return isNumberWithHyphen(event)"
                                               value="{{$company_information->ci_whatsapp_number}}">
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a
                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.phone.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.phone.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.phone.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Phone Number</label>
                                        <input type="text" name="phone" id="phone" class="inputs_up form-control"
                                               placeholder="Phone Number" onkeypress="return isNumberWithHyphen(event)"
                                               value="{{$company_information->ci_ptcl_number}}">
                                        <span id="demo5" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.company_info.fax_number.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Fax Number</label>
                                        <input type="text" name="fax" id="fax" class="inputs_up form-control"
                                               placeholder="Fax Number" onkeypress="return isNumberWithHyphen(event)"
                                               value="{{$company_information->ci_fax_number}}">
                                        <span id="demo6" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.company_info.facebook.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Facebook</label>
                                        <input type="text" name="facebook" id="facebook" class="inputs_up form-control"
                                               placeholder="Facebook Link"
                                               value="{{$company_information->ci_facebook}}">
                                        <span id="demo9" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.company_info.twitter.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Twitter</label>
                                        <input type="text" name="twitter" id="twitter" class="inputs_up form-control"
                                               placeholder="Twitter Link"
                                               value="{{$company_information->ci_twitter}}">
                                        <span id="demo10" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.company_info.youTube.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Youtube</label>
                                        <input type="text" name="youtube" id="youtube" class="inputs_up form-control"
                                               placeholder="Youtube Link"
                                               value="{{$company_information->ci_youtube}}">
                                        <span id="demo11" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.company_info.google.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Google</label>
                                        <input type="text" name="google" id="google" class="inputs_up form-control"
                                               placeholder="Google Link"
                                               value="{{$company_information->ci_google}}">
                                        <span id="demo12" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.company_info.instagram.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Instagram</label>
                                        <input type="text" name="instagram" id="instagram"
                                               class="inputs_up form-control" placeholder="Instagram Link"
                                               value="{{$company_information->ci_instagram}}">
                                        <span id="demo13" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.validations') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Address</label>
                                        <textarea name="address" id="address"
                                                  data-rule-required="true" data-msg-required="Please Enter Address"
                                                  class="inputs_up remarks form-control" style="height: 100px">{{$company_information->ci_address}}</textarea>
                                        <span id="demo7" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.configurations.company_info.profile_image.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Profile Image</label>
                                        <input type="file" name="pimage" id="pimage" class="inputs_up form-control"
                                               data-rule-required="true" data-msg-required="Please Choose Image"
                                               accept=".png,.jpg,.jpeg"
                                               style="width: 100px !important; background-color: #eee; border:none; box-shadow: none !important; display: none;"
                                               value="{{$company_information->ci_logo}}">
                                        <span id="demo8" class="validate_sign"> </span>


                                        <div style="float: left;">

                                            <div style="float: right">
                                                <label id="image1"
                                                       style="display: none; cursor:pointer; color:blue; text-decoration:underline;">
                                                    <i style=" color:#04C1F3" class="fa fa-window-close"></i>
                                                </label>
                                            </div>
                                            <div>
                                                <img id="imagePreview1"
                                                     style="border-radius:50%; position:relative; cursor:pointer;  width: 100px; height: 100px;"
                                                     src="{{$company_information->ci_logo}}"/>
                                            </div>
                                        </div>
                                    </div><!-- end input box -->
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="button" name="cancel" id="cancel" class="cancel_button form-control">
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


        </div><!-- col end -->


        {{-- , ['info_bx' => $info_bx, 'info_bx_childs' => $info_bx_childs ]--}}


    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let name = document.getElementById("name"),
                email = document.getElementById("email"),
                address = document.getElementById("address"),
                // pimage = document.getElementById("pimage"),
                validateInputIdArray = [
                    name.id,
                    email.id,
                    address.id,
                    // pimage.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if(check == true){
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });



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


        jQuery("#imagePreview1").click(function () {
            jQuery("#pimage").click();
        });
        var image1RemoveBtn = document.querySelector("#image1");
        var imagePreview1 = document.querySelector("#imagePreview1");


        $(document).ready(function () {
            $('input[type=file]').change(function () {
                var file = this.files[0],
                    val = $(this).val().trim().toLowerCase();
                if (!file || $(this).val() === "") {
                    return;
                }

                var fileSize = file.size / 1024 / 1024,
                    regex = new RegExp("(.*?)\.(jpeg|png|jpg)$"),
                    errors = 0;

                if (fileSize > 2) {
                    errors = 1;

                    document.getElementById("demo8").innerHTML = "Only png.jpg,jpeg files & max size:2 mb";
                }
                if (!(regex.test(val))) {
                    errors = 1;

                    document.getElementById("demo8").innerHTML = "Only png.jpg,jpegs files & max size:2 mb";
                }

                var fileInput = document.getElementById('pimage');
                var reader = new FileReader();

                if (errors == 1) {
                    $(this).val('');

                    image1RemoveBtn.style.display = "none";
                    document.getElementById("imagePreview1").src = 'public/src/upload_btn.jpg';

                } else {

                    image1RemoveBtn.style.display = "block";
                    imagePreview1.style.display = "block";

                    reader.onload = function (e) {
                        document.getElementById("imagePreview1").src = e.target.result;
                    };
                    reader.readAsDataURL(fileInput.files[0]);

                    document.getElementById("demo8").innerHTML = "";
                }
            });
        });


        image1RemoveBtn.onclick = function () {

            var pimage = document.querySelector("#pimage");
            pimage.value = null;
            var pimagea = document.querySelector("#imagePreview1");
            pimagea.value = null;
            image1RemoveBtn.style.display = "none";
            //imagePreview1.style.display = "none";
            document.getElementById("imagePreview1").src = "public/src/upload_btn.jpg";

        }

    </script>

    <script>

        // **********************************************************only number enter **********************************************************
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }


        function validatebcode(pas) {
            var pass = /^[0-9]*$/;
            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }
    </script>

    <script type="text/javascript">

        jQuery(function () {
            jQuery(document).on('keypress', function (e) {
                var that = document.activeElement;
                if (e.which == 13) {
                    e.preventDefault();
                    jQuery('[tabIndex=' + (+that.tabIndex + 1) + ']')[0].focus();
                }
            });
        });

        function validate_form() {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var mobile = document.getElementById("mobile").value;
            var whatsapp = document.getElementById("whatsapp").value;
            var phone = document.getElementById("phone").value;
            var fax = document.getElementById("fax").value;
            var address = document.getElementById("address").value;
            var pimage = document.getElementById("pimage").value;

            var flag_submit = true;
            var focus_once = 0;

            if (name == "") {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {

                document.getElementById("demo1").innerHTML = "";
            }

            if (email == "") {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#email").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {

                if (!checkemail(email)) {
                    document.getElementById("demo2").innerHTML = "(example@example.com)";
                    if (focus_once == 0) {
                        jQuery("#email").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {

                    document.getElementById("demo2").innerHTML = "";
                }
            }

            if (mobile == "") {
                // document.getElementById("demo3").innerHTML = "Required";
                // if (focus_once == 0) {
                //     jQuery("#mobile").focus();
                //     focus_once = 1;
                // }
                // flag_submit = false;
            } else {

                if (!validatephone(mobile)) {
                    document.getElementById("demo3").innerHTML = "(03123456789) or (+923123456789)";
                    if (focus_once == 0) {
                        jQuery("#mobile").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo3").innerHTML = "";

                }
            }

            if (whatsapp == "") {
                // document.getElementById("demo4").innerHTML = "Required";
                // if (focus_once == 0) {
                //     jQuery("#whatsapp").focus();
                //     focus_once = 1;
                // }
                // flag_submit = false;
            } else {

                if (!validatephone(whatsapp)) {
                    document.getElementById("demo4").innerHTML = "(03123456789) or (+923123456789)";
                    if (focus_once == 0) {
                        jQuery("#whatsapp").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo4").innerHTML = "";

                }
            }

            if (phone == "") {
                // document.getElementById("demo5").innerHTML = "Required";
                // if (focus_once == 0) {
                //     jQuery("#phone").focus();
                //     focus_once = 1;
                // }
                // flag_submit = false;
            } else {

                if (!validate_ptcl_number(phone)) {
                    document.getElementById("demo5").innerHTML = "(061-1234567) or (0611234567)";
                    if (focus_once == 0) {
                        jQuery("#phone").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo5").innerHTML = "";

                }
            }

            if (fax == "") {
                // document.getElementById("demo6").innerHTML = "Required";
                // if (focus_once == 0) {
                //     jQuery("#fax").focus();
                //     focus_once = 1;
                // }
                // flag_submit = false;
            } else {

                if (!validate_ptcl_number(fax)) {
                    document.getElementById("demo6").innerHTML = "(061-1234567) or (0611234567)";
                    if (focus_once == 0) {
                        jQuery("#fax").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo6").innerHTML = "";

                }
            }


            if (address.trim() == "") {
                document.getElementById("demo7").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#address").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo7").innerHTML = "";
            }


            //
            // if (pimage.trim() == "") {
            //
            //     document.getElementById("demo9").innerHTML = "Required";
            //     //  alert_message("Branch Address Is Required");
            //     if (focus_once == 0) {
            //         jQuery("#pimage").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo9").innerHTML = "";
            // }

            return flag_submit;
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


        function checkemail(email_address) {

            if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email_address)) {
                return true;
            } else {
                return false;
            }
        }


        // validate ptcl number
        function validate_ptcl_number(num) {
            var ph = /^0\d{2}-?\d{7}$/;
            if (ph.test(num)) {
                return true;
            } else {
                return false;
            }
        }


        // validate phone number
        function validatephone(phone_num) {
            var ph = /^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/;
            if (ph.test(phone_num)) {
                return true;
            } else {
                return false;
            }
        }


        //USER NAME
        function validateusername(username) {
            var uname = /^[a-zA-Z0-9]{6,40}$/;  //Alphanumeric without spaces
            if (uname.test(username)) {
                return true;
            } else {
                return false;
            }
        }


        // added for alphabets only check
        function onlyAlphabets(alphabets_value) {
            //  /^[a-zA-Z]+$/
            var regex = /^[^-\s][a-zA-Z\s-]+$/;
            if (regex.test(alphabets_value)) {

                return true;
            } else {
                return false;
            }
        }


        function validatenumbers(pas) {
            var pass = /^[0-9]*$/;
            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }

    </script>

@endsection

