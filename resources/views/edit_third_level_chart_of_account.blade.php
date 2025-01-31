
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Edit Child Account</h4>
                            </div>
                        </div>
                    </div><!-- form header close -->


                    <form name="f1" class="f1" id="f1" action="{{ route('update_chart_of_account') }}" onsubmit="return checkForm()" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required"><a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                               data-placement="bottom" data-html="true"
                                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.control_account.description')}}</p>
                                                             <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.control_account.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.control_account.example')}}
                                                                                   <h6>Validation</h6><p>{{config('fields_info.about_form_fields.control_account.validations')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Control Account</label>
                                                    <select name="first_head_code" id="first_head_code" class="inputs_up form-control"
                                                            data-rule-required="true" data-msg-required="Please Enter Control Account"
                                                            disabled>
                                                        <option value="">Select Head</option>
                                                        @foreach($first_level_accounts as $first_level_account)

                                                            <?php
                                                            $parent='';
                                                            if(substr($account->coa_code,0,1)==1){
                                                                $parent=1;
                                                            }elseif (substr($account->coa_code,0,1)==2){
                                                                $parent=2;
                                                            }elseif (substr($account->coa_code,0,1)==3){
                                                                $parent=3;
                                                            }elseif (substr($account->coa_code,0,1)==4){
                                                                $parent=4;
                                                            }else{
                                                                $parent=5;
                                                            } ?>

                                                            <option value="{{$first_level_account->coa_code}}" {{ $first_level_account->coa_code == $parent ? 'selected="selected"' : '' }}>{{$first_level_account->coa_head_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required"><a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                               data-placement="bottom" data-html="true"
                                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.parent_account.description')}}</p>
                                                                 <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.parent_account.benefits')}}</p>
                                                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.parent_account.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Parent Account</label>
                                                    <select name="parent_head_code" id="parent_head_code" class="inputs_up form-control"
                                                            data-rule-required="true" data-msg-required="Please Enter Parent Account"
                                                            style="width: 100%" disabled>
                                                        <option value="">Select Parent Account</option>

                                                    </select>
                                                    <span id="demo2" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>


                                            <input type="hidden" name="head_code" id="head_code" value="{{$account->coa_parent}}">
                                            <input type="hidden" name="account_id" id="account_id" value="{{$account->coa_id}}">

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.child_account.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.child_account.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.child_account.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Child Account
                                                    </label>
                                                    <input type="text" name="account_name" id="account_name" class="inputs_up form-control"
                                                           data-rule-required="true" placeholder="Child Account" data-msg-required="Please Enter Child Account" autocomplete="off" value="{{$account->coa_head_name}}">
                                                    <span id="demo4" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
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
                                                <textarea name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks">{{$account->coa_remarks}}</textarea>
                                                <span id="demo6" class="validate_sign"> </span>
                                            </div><!-- end input box -->
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
                </div>


            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let first_head_code = document.getElementById("first_head_code"),
                parent_head_code = document.getElementById("parent_head_code"),
                account_name = document.getElementById("account_name"),
                validateInputIdArray = [
                    first_head_code.id,
                    parent_head_code.id,
                    account_name.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>

        jQuery(document).ready(function() {

            var second_parent='{{$account->coa_parent}}';

            var dropDown = document.getElementById('first_head_code');
            var first_head_code = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_head",
                data: {first_head_code: first_head_code, second_parent:second_parent},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#parent_head_code").html("");
                    jQuery("#parent_head_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });


        // jQuery("#first_head_code").change(function () {
        //
        //     var dropDown = document.getElementById('first_head_code');
        //     var first_head_code = dropDown.options[dropDown.selectedIndex].value;
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "get_head",
        //         data: {first_head_code: first_head_code},
        //         type: "POST",
        //         cache: false,
        //         dataType: 'json',
        //         success: function (data) {
        //
        //             jQuery("#head_code").html("");
        //             jQuery("#head_code").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {
        //             // alert(jqXHR.responseText);
        //             // alert(errorThrown);
        //         }
        //     });
        // });

    </script>

    <script type="text/javascript">

        function validate_form() {


            var first_head_code = document.getElementById("first_head_code").value;
            var head_code = document.getElementById("head_code").value;
            var account_name = document.getElementById("account_name").value;

            var flag_submit = true;
            var focus_once = 0;


            if (first_head_code.trim() == "") {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#first_head_code").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo1").innerHTML = "";
            }

            if (head_code.trim() == "") {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#head_code").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo2").innerHTML = "";
            }

            if (account_name.trim() == "") {
                document.getElementById("demo4").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#account_name").focus();
                    focus_once = 1;
                }

                flag_submit = false;
            } else {
                    document.getElementById("demo4").innerHTML = "";
            }

            return flag_submit;
        }

    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#first_head_code").select2();
            jQuery("#parent_head_code").select2();
        });
    </script>
    <!-- additionl scripting ednds here-->

@endsection

