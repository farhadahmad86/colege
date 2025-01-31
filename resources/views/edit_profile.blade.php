
@extends('extend_index')

@section('content')

    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-blue get-heading-text">Change Profile</h4>
                </div>
            </div>

            <form name="f1" class="f1" id="f1" action="{{route("submit_update_profile")}}" onsubmit="return checkForm()" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label class="required">Name</label>
                                <span id="demo1" class="validate_sign"> </span>
                                <input type="text" name="name" id="name" class="form-control"
                                       data-rule-required="true" data-msg-required="Please Enter Name"
                                       placeholder="Name" value="{{$user->user_name}}" autocomplete="off"/>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-1 col-md-1"></div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                    Cancel
                                </button>
                            </div>
                            <div class="col-lg-6 col-md-6"></div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <button type="submit" name="save" id="save" class="save_button form-control"
                                >Save
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
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let name = document.getElementById("name"),
                validateInputIdArray = [
                    name.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">


        function form_validation()
        {
            var name = document.getElementById("name").value;


            var flag_submit = true;
            var focus_once = 0;

            if (name == "") {

                document.getElementById("demo1").innerHTML = "Required";
                //  alert_message("First Name Is Required");
                if (focus_once == 0) {
                    jQuery("#name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                if (!onlyAlphabets(name)) {
                    document.getElementById("demo1").innerHTML = "Only Characters & Hyphen(-)";
                    if (focus_once == 0) {
                        jQuery("#name").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
                else {
                    document.getElementById("demo1").innerHTML = "";
                }

            }


            return flag_submit;
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
    </script>

@endsection

