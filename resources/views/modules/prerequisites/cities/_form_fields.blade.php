<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="row">

            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <label for="name" class="required">
                        {{--                        <a--}}
                        {{--                            data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                            data-placement="bottom" data-html="true"--}}
                        {{--                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.description')}}</p><h6>Benefit</h6><p>{{--}}
                        {{--                                                config('fields_info.about_form_fields.party_registration.region.name.benefits')}}</p><h6>Example</h6><p>{{--}}
                        {{--                                                config('fields_info.about_form_fields.party_registration.region.name.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">--}}
                        {{--                            <l class="fa fa-info-circle"></l>--}}
                        {{--                        </a>--}}
                        City Title

                    </label>
                    <input type="text" class="inputs_up form-control @error('name') is-invalid @enderror" id="name" name="name"
                           data-rule-required="true" data-msg-required="Please Enter City"
                           value="{{ $cityCrud->name }}" placeholder="Enter City Name">

                    <span id="demo1" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

        </div>


        <div class="row">
            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="">
                        <a
                            data-container="body" data-toggle="popover" data-trigger="hover"
                            data-placement="bottom" data-html="true"
                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                                    config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                            <l class="fa fa-info-circle"></l>
                        </a>
                        Remarks</label>
                    <textarea class="inputs_up remarks form-control @error('remarks') is-invalid @enderror"
                              id="remarks" name="remarks" placeholder="Enter Remarks">{{ $cityCrud->remarks }}</textarea>

                    {{--                    <textarea name="remarks" id="remarks" class="inputs_up remarks form-control"--}}
                    {{--                              placeholder="Remarks">{{ old('remarks') }}</textarea>--}}
                    <span id="demo2" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <div class="custom-control custom-checkbox" style="float: left">
                        <input type="checkbox" class="custom-control-input" id="status" name="status" value="{{ $cityCrud->getStatus('active') }}" {{ isset($cityCrud->status) ? '' : 'checked' }} {{ $cityCrud->status === $cityCrud->getStatus('active') ? 'checked' : old('status') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status">Active</label>
                    </div>

                </div><!-- end input box -->
            </div>
        </div>

    </div> <!-- left column ends here -->
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        {{--<div class="show_info_div">--}}

        {{--</div>--}}

    </div> <!-- right columns ends here -->

</div> <!--  main row ends here -->
@csrf
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
