@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Update Hr Plan</h4>
                    </div>
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('update_hr_plan') }}"
                onsubmit="return checkForm()" method="post">
                @csrf
                <div class="row">

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">

                                Hr Plan

                            </label>
                            <input tabindex="1" type="text" name="hr_plan_name" id="hr_plan_name"
                                class="inputs_up form-control" placeholder="Hr Plan Name" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Hr Plan Name" autocomplete="off"
                                value="{{ $request->title }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">

                                Hr Plan Extra Leave

                            </label>
                            <input tabindex="1" type="text" name="hr_plan_extra_leave" id="hr_plan_extra_leave"
                                class="inputs_up form-control" placeholder="Hr Plan Extra Leave" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Hr PlanExtra Leave"
                                autocomplete="off" value="{{ $request->extra_leave }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">

                                Hr Plan Causual Leave

                            </label>
                            <input tabindex="1" type="text" name="hr_plan_causual_leave" id="hr_plan_causual_leave"
                                class="inputs_up form-control" placeholder="Hr Plan Causual Leave" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Hr Plan Causual Leave"
                                autocomplete="off" value="{{ $request->causual_leave }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">

                                Hr Plan Short Leave

                            </label>
                            <input tabindex="1" type="text" name="hr_plan_short_leave" id="hr_plan_short_leave"
                                class="inputs_up form-control" placeholder="Hr Plan Short Leave" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Hr Plan Short Leave"
                                autocomplete="off" value="{{ $request->short_leave }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">

                                Hr Plan Half Leave

                            </label>
                            <input tabindex="1" type="text" name="hr_plan_half_leave" id="hr_plan_half_leave"
                                class="inputs_up form-control" placeholder="Hr Plan Short Leave" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Hr Plan Short Leave"
                                autocomplete="off" value="{{ $request->half_leave }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="">
                                <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                    data-html="true"
                                    data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.description') }}</p>
                                            <h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.benefits') }}</p>
                                            <h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.example') }}</p>
                                            <h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.client_registration.address.validations') }}</p>">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                Hr Plan Description </label>
                            <textarea tabindex="23" name="hr_plan_description" id="hr_plan_description" class="remarks inputs_up form-control"
                                placeholder="Description" style="height: 107px;">{{ $request->description }}</textarea>
                            <span id="hr_plan_description_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                        <input value="{{ $request->hr_plan_id }}" type="hidden" name="hr_plan_id">
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="submit" name="save" id="save"
                            class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let hr_plan_name = document.getElementById("hr_plan_name"),
                hr_plan_extra_leave = document.getElementById("hr_plan_extra_leave"),
                hr_plan_causual_leave = document.getElementById("hr_plan_causual_leave"),
                hr_plan_short_leave = document.getElementById("hr_plan_short_leave"),
                hr_plan_half_leave = document.getElementById("hr_plan_half_leave"),
                hr_plan_description = document.getElementById("hr_plan_description"),
                validateInputIdArray = [
                    hr_plan_name.id,
                    hr_plan_extra_leave.id,
                    hr_plan_causual_leave.id,
                    hr_plan_short_leave.id,
                    hr_plan_half_leave.id,
                    hr_plan_description.id,
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
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    </script>
@endsection
