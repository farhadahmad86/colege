
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Edit Unit</h4>
                            </div>
                        </div>
                    </div><!-- form header close -->

                    <form name="f1" class="f1" id="f1" action="{{ route('update_unit') }}" onsubmit="return checkForm()" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.main_unit.title.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.main_unit.title.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Main Unit</label>
                                                    <select name="main_unit" class="inputs_up form-control" id="main_unit"
                                                            data-rule-required="true" data-msg-required="Please Enter Main Unit"
                                                    >
                                                        <option value="">Select Main Unit</option>
                                                        @foreach($main_units as $main_unit)
                                                            <option value="{{$main_unit->mu_id}}" {{ $main_unit->mu_id == $request->main_unit_id ? 'selected="selected"' : '' }}>{{$main_unit->mu_title}}</option>
                                                        @endforeach

                                                    </select>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->

                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.unit.unit_title.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.unit.unit_title.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Unit Title
                                                    </label>
                                                    <input type="text" name="unit_name" id="unit_name" class="inputs_up form-control"
                                                           data-rule-required="true" data-msg-required="Please Enter Unit"
                                                           placeholder="Unit Name" value="{{$request->unit_title}}" autocomplete="off">
                                                    <span id="demo3" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx">
                                                    <div class="custom-control custom-checkbox mb-10 mt-1" style="float: left">
                                                        <input type="checkbox" name="allowDecimal" class="custom-control-input allowDecimal" id="allowDecimal" value="1" {{ $request->unit_allow_decimal == 1 ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="allowDecimal">Allow Decimal</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">Symbol</label>
                                                    <input type="text" name="symbol" id="symbol" class="inputs_up form-control" data-msg-required="Please Enter Symbol" value="{{$request->unit_symbol}}" placeholder="Symbol" autocomplete="off">
                                                    <span id="demo4" class="validate_sign"> </span>
                                                </div> <!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.unit.scale_size.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.unit.scale_size.benefits')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Packing Size
                                                    </label>
                                                    <input type="text" name="scale_size" id="scale_size" class="inputs_up form-control"
                                                           data-rule-required="true" data-msg-required="Please Enter Size"
                                                           placeholder="Scale Size" value="{{$request->size}}"
                                                           autocomplete="off" onkeypress="return allow_only_number_and_decimals(this,event);">
                                                    <span id="demo4" class="validate_sign"> </span>
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
                                                    <textarea name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks">{{$request->remarks}}</textarea>
                                                    <span id="demo5" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                             <input value="{{$request->unit_id}}" name="unit_id" type="hidden">
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
            let main_unit = document.getElementById("main_unit"),
                unit_name = document.getElementById("unit_name"),
                scale_size = document.getElementById("scale_size"),
                validateInputIdArray = [
                    main_unit.id,
                    unit_name.id,
                    scale_size.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">

        function validate_form()
        {
            var main_unit  = document.getElementById("main_unit").value;
            var unit_name  = document.getElementById("unit_name").value;
            var scale_size = document.getElementById("scale_size").value;
            var remarks  = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if(main_unit.trim() == "")
            {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#main_unit").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo1").innerHTML = "";
            }



            if(unit_name.trim() == "")
            {
                document.getElementById("demo3").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#unit_name").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo3").innerHTML = "";
            }

            // if(remarks.trim() == "")
            // {
            //     document.getElementById("demo5").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo5").innerHTML = "";
            // }


             if(scale_size.trim() == "")
            {
                document.getElementById("demo4").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#scale_size").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo4").innerHTML = "";
            }

            return flag_submit;
        }

    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#main_unit").select2();
            // jQuery("#category_name").select2();

        });
    </script>

@endsection

