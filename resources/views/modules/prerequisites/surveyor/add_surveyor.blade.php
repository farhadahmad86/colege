@extends('extend_index')

@section('content')
    <div class="row">


        <div
            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Create Surveyor</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{route('surveyor.index')}}" role="button">
                                <l class="fa fa-list"></l>
                                view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{route('surveyor.store')}}" method="post"
                      onsubmit="return checkForm()" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a
                                               data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.region.name.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.region.name.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                           User Name

                                        </label>
                                        <input tabindex="1" autofocus type="text" name="username" id="surveyor_name" class="inputs_up form-control" placeholder="Surveyor Title" autofocus
                                               data-rule-required="true"
                                               data-msg-required="Please Enter Surveyor Title" autocomplete="off" value="{{ old('username') }}"/>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>
                                <div class="form-group col-md-4 ">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a
                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Password</label>
                                        <input tabindex="2" type="password" name="password" id="surveyor_password" class="inputs_up form-control" placeholder="Surveyor Password" autofocus
                                               data-rule-required="true" data-msg-required="Please Enter Surveyor Password" autocomplete="off" value="{{ old('password') }}"/>
                                        <span toggle="#old_password-field"
                                              class="fa-eye-slash fa fa-fw field-icon toggle-password"></span>
                                        <span id="demo2" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>
                                <div class="form-group  col-md-4 ">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a
                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Confirm Password</label>
                                        <input tabindex="3" type="password" name="password_confirmation" id="surveyor_c_password" class="inputs_up form-control" placeholder="Confirm Password"
                                               autofocus   data-rule-required="true" data-msg-required="Please Enter Password Again" autocomplete="off" value="{{ old('password_confirmation') }}"/>
                                        <span toggle="#old_password-field"
                                              class="fa-eye-slash fa fa-fw field-icon toggle-confirm_password"></span>
                                        <span id="demo2" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button tabindex="4" type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button tabindex="5" type="submit" name="save" id="save" class="save_button form-control"
{{--                                            onclick="return form_validation()"--}}
                                    >
                                        <i class="fa fa-floppy-o"></i> Save
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


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let surveyor_name = document.getElementById("surveyor_name"),
                surveyor_password = document.getElementById("surveyor_password"),
                surveyor_c_password = document.getElementById("surveyor_c_password"),
                validateInputIdArray = [
                    surveyor_name.id,
                    surveyor_password.id,
                    surveyor_c_password.id,
                ];
            let checkVald = validateInventoryInputs(validateInputIdArray);
            if(surveyor_password.value.length >= 8){
                if (surveyor_password.value == surveyor_c_password.value) {
                    return checkVald;
                } else {
                    alertMessageShow(confirm_password.id, 'Password Not Match ');
                    return false;
                }
            }else {
                alertMessageShow(new_password.id, 'The password must be at least 8 characters!');
                return false;
            }
            //return validateInventoryInputs(validateInputIdArray);
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


        jQuery(".toggle-password").click(function () {
            jQuery(this).toggleClass("fa-eye-slash fa-eye");
            var xx = document.getElementById("surveyor_password");
            if (xx.type === "password") {
                xx.type = "text";
            } else {
                xx.type = "password";
            }

        });
        jQuery(".toggle-confirm_password").click(function () {
            jQuery(this).toggleClass("fa-eye-slash fa-eye");
            var xx = document.getElementById("surveyor_c_password");
            if (xx.type === "password") {
                xx.type = "text";
            } else {
                xx.type = "password";
            }

        });

    </script>
<script>
    $(document).ready(function() {
        setTimeout(function(){
            $('[autocomplete=off]').val('');
        }, 150);
    });

</script>
@endsection


