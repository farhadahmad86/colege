
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Edit Warehouse</h4>
                            </div>
                        </div>
                    </div><!-- form header close -->

                    <form name="f1" class="f1" id="f1" action="{{ route('update_warehouse') }}" onsubmit="return checkForm()" method="post">
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
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Warehouse Location
                                                    </label>
                                                    <input type="text" name="warehouse_name" id="warehouse_name" class="inputs_up form-control"
                                                           data-rule-required="true" data-msg-required="Please Enter Warehouse Location" placeholder="Warehouse Location" autofocus autocomplete="off" value="{{$request->title}}"/>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a
                                                            data-container="body" data-toggle="popover" data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.validations') }}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Address</label>
                                                    <input type="text" name="address" id="address" class="inputs_up form-control" placeholder="Address"
                                                           data-rule-required="true" data-msg-required="Please Enter Address"
                                                           autocomplete="off" value="{{$request->address}}"/>
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
                                                    <textarea name="remarks" id="remarks" class="remarks form-control" placeholder="Remarks">{{$request->remarks}}</textarea>
                                                    <span id="demo3" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>
                                        </div>

                                        <input type="hidden" name="warehouse_id" id="warehouse_id" value="{{$request->warehouse_id}}">

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
            let warehouse_name = document.getElementById("warehouse_name"),
                address = document.getElementById("address"),
                validateInputIdArray = [
                    warehouse_name.id,
                    address.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">


        function form_validation()
        {
            var warehouse  = document.getElementById("warehouse_name").value;
            var address  = document.getElementById("address").value;

            var flag_submit = true;
            var focus_once = 0;

            if(warehouse.trim() == "")
            {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#warehouse").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo1").innerHTML = "";
            }

            if(address.trim() == "")
            {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#address").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo2").innerHTML = "";
            }
            return flag_submit;
        }
    </script>

@endsection

