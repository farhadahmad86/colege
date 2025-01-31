@extends('extend_index')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Update Session</h4>
                        </div>
                    </div>
                </div><!-- form header close -->
                <form name="f1" class="f1" id="f1" action="{{ route('update_session') }}"
                    onsubmit="return checkForm()" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
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
                                            Session Name</label>
                                        <input type="text" name="session_name" id="session_name"
                                            class="inputs_up form-control" data-rule-required="true"
                                            data-msg-required="Please Enter Session" placeholder="Session Title" autofocus
                                            value="{{ $request->title }}" autocomplete="off" />
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>
                            </div>
                        </div> <!-- left column ends here -->
                    </div> <!--  main row ends here -->
                    <input value="{{ $request->session_id }}" type="hidden" name="session_id">
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                            <button type="submit" name="save" id="save" class="save_button form-control">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                    </div>

                </form>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let session_name = document.getElementById("session_name"),
                // start_date = document.getElementById("start_date"),
                // end_date = document.getElementById("end_date"),
                validateInputIdArray = [
                    session_name.id,
                    // start_date.id,
                    // end_date.id,

                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
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
                document.getElementById("demo1".inn) erHTML = "Required";
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
