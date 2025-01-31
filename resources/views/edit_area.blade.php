
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Edit Area</h4>
                            </div>
                        </div>
                    </div><!-- form header close -->

                    <form name="f1" class="f1" id="f1" action="update_area" onsubmit="return checkForm()" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.region.name.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.region.name.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Region Title
                                                    </label>
                                                    <select name="region_name" class="inputs_up form-control" id="region_name" autofocus data-rule-required="true" data-msg-required="Please Enter Region Title" autofocus style="width: 100%">
                                                        <option value="">Select Region</option>
                                                        @foreach($regions as $region)
                                                            <option value="{{$region->reg_id}}" {{ $region->reg_id == $request->region_id ? 'selected="selected"' : '' }}>{{$region->reg_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.area.area_title.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.area.area_title.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.validations') }}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Area Title
                                                    </label>
                                                    <input type="text" name="area_name" id="area_name" class="inputs_up form-control"
                                                           data-rule-required="true" data-msg-required="Please Enter Area Title"
                                                           placeholder="Area Title" value="{{$request->area_title}}" autocomplete="off">
                                                    <span id="demo2" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
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
                                                    <textarea name="remarks" id="remarks" class="inputs_up remarks form-control">{{$request->remarks}}</textarea>
                                                    <span id="demo3" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>
                                            <input value="{{$request->area_id}}" type="hidden" name="area_id">
                                        </div>
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
            let region_name = document.getElementById("region_name"),
                area_name = document.getElementById("area_name"),
                validateInputIdArray = [
                    region_name.id,
                    area_name.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">

        function validate_form()
        {
            var region_name  = document.getElementById("region_name").value;
            var area_name  = document.getElementById("area_name").value;
            var remarks  = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if(region_name.trim() == "")
            {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#region_name").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo1").innerHTML = "";
            }

            if(area_name.trim() == "")
            {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#area_name").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo2").innerHTML = "";
            }

            return flag_submit;
        }
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#region_name").select2();

        });
    </script>

@endsection

