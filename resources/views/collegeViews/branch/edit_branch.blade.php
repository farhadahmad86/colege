@extends('extend_index')
@section('content')
    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Update Branch</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{ route('update_branch') }}"
                    onsubmit="return checkForm()" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.description') }}</p><h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.benefits') }}</p><h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.example') }}</p><h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Branch Title</label>
                                        <input type="text" name="branch" id="branch" class="inputs_up form-control"
                                            data-rule-required="true" data-msg-required="Please Enter Branch"
                                            placeholder="Branch Title" autofocus value="{{ $request->title }}"
                                            autocomplete="off" />
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>
                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.description') }}</p><h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.benefits') }}</p><h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.example') }}</p><h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Contact</label>
                                        <input type="text" name="contact" id="contact" class="inputs_up form-control"
                                            data-rule-required="true" data-msg-required="Please Enter Contact"
                                            placeholder="Contact" autofocus value="{{ $request->contact }}"
                                            autocomplete="off" />
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>
                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.description') }}</p><h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.benefits') }}</p><h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.example') }}</p><h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Contact2</label>
                                        <input type="text" name="contact2" id="contact2" class="inputs_up form-control"
                                            data-rule-required="true" data-msg-required="Please EnterContact2"
                                            placeholder="Contact2" autofocus value="{{ $request->contact2 }}"
                                            autocomplete="off" />
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>
                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.description') }}</p><h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.benefits') }}</p><h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.example') }}</p><h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Address</label>
                                        <input type="text" name="address" id="address" class="inputs_up form-control"
                                            data-rule-required="true" data-msg-required="Please Enter Addess"
                                            placeholder="Addess" autofocus value="{{ $request->address }}"
                                            autocomplete="off" />
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>
                                <input value="{{ $request->branch_id }}" type="hidden" name="branch_id">
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="button" name="cancel" id="cancel"
                                        class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save"
                                        class="save_button form-control">
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
            let branch = document.getElementById("branch"),
                contact = document.getElementById("contact"),
                address = document.getElementById("address"),
                validateInputIdArray = [
                    branch.id,
                    contact.id,
                    address.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">
        function form_validation() {
            var region_name = document.getElementById("region_name").value;
            var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if (region_name.trim() == "") {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#region_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo1").innerHTML = "";
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
@endsection
