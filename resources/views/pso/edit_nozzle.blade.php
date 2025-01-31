@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Edit Nozzle</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" onsubmit="return validateForm(this)" action="{{ route('update_nozzle') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Tank Title
                                                </label>
                                                <select name="tank" class="inputs_up form-control required" id="tank" autofocus data-rule-required="true" data-msg-required="Please Enter Tank Title">
                                                    <option value="">Select Tank</option>

                                                    @foreach($tanks as $tank)
                                                        <option value="{{$tank->t_id}}" {{ $tank->t_id == $request->tank_id ? 'selected="selected"' : '' }}>{{$tank->t_name}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->

                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Nozzle Title
                                                </label>
                                                <input type="text" name="nozzle_name" id="nozzle_name" value="{{$request->nozzle_name}}" class="inputs_up form-control" placeholder="Nozzle Title" data-rule-required="true" data-msg-required="Please Enter Nozzle Title">
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
                                                <textarea name="remarks" id="remarks" class="inputs_up remarks form-control"  placeholder="Remarks" style="height: 100px;">{{$request->remarks}}</textarea>
                                                <span id="demo3" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                            <input type="hidden" name="nozzle_id" value="{{$request->nozzle_id}}">
                                            <input type="hidden" name="tank_id" value="{{$request->tank_id}}">

                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="save_button form-control">
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

    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $(function () {
            $('[data-toggle="popover"]').popover()
        });

        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#tank").select2();
        });
    </script>


@endsection



