
@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Edit City</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="update_city" onsubmit="return checkForm()" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">

                                                    Province
                                                </label>
                                                <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="province" id="province" style="width: 90%">
                                                    <option value="">Select Province</option>
                                                    <option value="Azad Kashmir" {{ "Azad Kashmir" == $request->province_id ? 'selected="selected"' : ''}} >Azad Kashmir</option>
                                                    <option value="Balochistan" {{ "Balochistan" == $request->province_id ? 'selected="selected"' : ''}}>Balochistan</option>
                                                    <option value="Federally Administered Tribal Areas" {{ "Federally Administered Tribal Areas" == $request->province_id ? 'selected="selected"' : ''}}>Federally Administered Tribal Areas</option>
                                                    <option value="Gilgit Baltistan" {{ "Gilgit Baltistan" == $request->province_id ? 'selected="selected"' : ''}}>Gilgit Baltistan</option>
                                                    <option value="Khyber Pakhtunkhwa" {{ "Khyber Pakhtunkhwa" == $request->province_id ? 'selected="selected"' : ''}}>Khyber Pakhtunkhwa</option>
                                                    <option value="Punjab" {{ "Punjab" == $request->province_id ? 'selected="selected"' : ''}}>Punjab</option>
                                                    <option value="Sindh" {{ "Sindh" == $request->province_id ? 'selected="selected"' : ''}}>Sindh</option>

                                                </select>

                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    City Name
                                                </label>
                                                <input type="text" name="city_name" id="city_name" class="inputs_up form-control"
                                                       data-rule-required="true" data-msg-required="Please Enter City Name"
                                                       placeholder="City Name" value="{{$request->city_name}}" autocomplete="off">
                                                <span id="demo2" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                    <input value="{{$request->city_id}}" type="hidden" name="city_id">
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


    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let province = document.getElementById("province"),
                city_name = document.getElementById("city_name"),
                validateInputIdArray = [
                    province.id,
                    city_name.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">

        function validate_form()
        {
            var province  = document.getElementById("province").value;
            var city_name  = document.getElementById("city_name").value;
            var remarks  = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if(province.trim() == "")
            {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#province").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo1").innerHTML = "";
            }

            if(city_name.trim() == "")
            {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#city_name").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo2").innerHTML = "";
            }

            // if(remarks.trim() == "")
            // {
            //     document.getElementById("demo3").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo3").innerHTML = "";
            // }


            return flag_submit;
        }
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#province").select2();

        });
    </script>

@endsection

