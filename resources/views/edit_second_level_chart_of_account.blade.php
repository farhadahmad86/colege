
@extends('extend_index')

@section('content')

    <div class="row">


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Edit Parent Accounts</h4>
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

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.control_account.description')}}</p>
                                                             <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.control_account.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.control_account.example')}}
                                                               <h6>Validation</h6><p>{{config('fields_info.about_form_fields.control_account.validations')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Control Account
                                                    </label>
                                                    <select name="parent_code" class="inputs_up form-control" id="parent_code" autofocus disabled data-rule-required="true" data-msg-required="Please Enter Control Account">
                                                        <option value="">Select Control Account</option>
                                                        @foreach($first_level_accounts as $first_level_account)
                                                            <option value="{{$first_level_account->coa_code}}" {{ $first_level_account->coa_code == $account->coa_parent ? 'selected="selected"' : '' }}>{{$first_level_account->coa_head_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                                                    <input type="text" name="account_name" id="account_name" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Parent Account"
                                                           placeholder="Parent Account" autocomplete="off" value="{{$account->coa_head_name}}">
                                                    <span id="demo2" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <input type="hidden" name="account_id" id="account_id" value="{{$account->coa_id}}">
                                            <input type="hidden" name="head_code" id="head_code" value="{{$account->coa_parent}}">
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
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
                                                <span id="demo3" class="validate_sign"> </span>
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
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let account_name = document.getElementById("account_name"),
                parent_code = document.getElementById("parent_code"),
                validateInputIdArray = [
                    account_name.id,
                    parent_code.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">

    //    jQuery("#head_code").change(function() {
    //
    //        var parent_code = jQuery('option:selected', this).attr('data-parent_code');
    //
    //        jQuery("#parent_code").val(parent_code);
    //    });

        function validate_form()
        {
            // var head_code  = document.getElementById("head_code").value;
            var account_name  = document.getElementById("account_name").value;
            var remarks  = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            // if(head_code.trim() == "")
            // {
            //     document.getElementById("demo1").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#head_code").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo1").innerHTML = "";
            // }

            if(account_name.trim() == "")
            {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#account_name").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo2").innerHTML = "";
            }
            return flag_submit;
        }

    </script>

@endsection

