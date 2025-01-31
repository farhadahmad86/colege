<div class="row">

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

        <div class="row">
            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required">
{{--                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"--}}
{{--                           data-html="true"--}}
{{--                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.description')}}</p><h6>Benefit</h6><p>{{--}}
{{--                                                config('fields_info.about_form_fields.party_registration.region.name.benefits')}}</p><h6>Example</h6><p>{{--}}
{{--                                                config('fields_info.about_form_fields.party_registration.region.name.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">--}}
{{--                            <i class="fa fa-info-circle"></i>--}}
{{--                        </a>--}}
                        Company Title

                        <a href="{{ route('receivables_account_registration') }}" role="button" class="add_btn" TARGET="_blank"
                           data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                           data-html="true" data-content="Add Client Button">
                            <i class="fa fa-plus"></i>
                        </a>
                        <a href="{{ route('payables_account_registration') }}" role="button" class="add_btn" TARGET="_blank"
                           data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                           data-html="true" data-content="Add Supplier Button">
                            <i class="fa fa-plus"></i>
                        </a>
{{--                        <a class="add_btn" id="refresh_region" data-container="body" data-toggle="popover" onclick="fetchCompanies($('select#company'));"--}}
{{--                           data-trigger="hover" data-placement="bottom" data-html="true"--}}
{{--                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
{{--                            <i class="fa fa-refresh"></i>--}}
{{--                        </a>--}}

                    </label>
                    <select name="company" id="company" class="inputs_up form-control required" data-fetch-url="{{ route('api.companies.options') }}" autofocus
                            data-rule-required="true" data-msg-required="Please Choose Company"
                    >
                        {{--                    <select name="region_name" class="inputs_up form-control required" id="region_name" autofocus--}}
                        {{--                            data-rule-required="true" data-msg-required="Please Enter Region Title">--}}
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{$company->account_uid}}" {{ $company->account_uid === $region->company_id ? 'selected' : old('company') === $company->account_uid ? 'selected' : ''}}>
                                {{$company->account_name}}</option>
                        @endforeach

{{--                        @foreach($companies as $company)--}}
{{--                            <option--}}
{{--                                value="{{ $company->account_id }}" {{ $company->account_id === $region->company_id ? 'selected' : old('company') === $company->account_id ? 'selected' : ''}}>{{ $company->account_name }}</option>--}}

{{--                        @endforeach--}}

                    </select>
                    <span id="demo1" class="validate_sign"> </span>
                </div><!-- end input box -->

            </div>

            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required">
{{--                        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"--}}
{{--                           data-html="true"--}}
{{--                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.description')}}</p><h6>Benefit</h6><p>{{--}}
{{--                                                        config('fields_info.about_form_fields.party_registration.area.area_title.benefits')}}</p><h6>Example</h6><p>{{--}}
{{--                                                        config('fields_info.about_form_fields.party_registration.area.area_title.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.validations') }}</p>">--}}
{{--                            <l class="fa fa-info-circle"></l>--}}
{{--                        </a>--}}
                        Zone Title</label>
                    <input type="text" class="inputs_up form-control @error('name') is-invalid @enderror" id="name"
                           name="name" value="{{ $region->name }}" placeholder="Enter Region Name"
                           data-rule-required="true" data-msg-required="Please Enter Region"
                    >

                    {{--                    <input type="text" name="area_name" id="area_name" class="inputs_up form-control"--}}
                    {{--                           placeholder="Area Title" autocomplete="off" value="{{ old('area_name') }}"--}}
                    {{--                           data-rule-required="true" data-msg-required="Please Enter Area Title">--}}
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
                            data-placement="bottom" data-html="true"
                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                                            config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                                                config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                            <l class="fa fa-info-circle"></l>
                        </a>
                        Remarks</label>
                    <textarea class="inputs_up remarks form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks"
                              placeholder="Enter Remarks" style="height: 100px;">{{ $region->remarks }}</textarea>
                    <span id="demo3" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12">
            <div class="input_bx"><!-- start input box -->
                <div class="custom-control custom-checkbox" style="float: left">
                    <input type="checkbox" class="custom-control-input" id="status" name="status" value="{{ $region->getStatus('active') }}" {{ isset($region->status) ? '' : 'checked' }} {{ $region->status === $region->getStatus('active') ? 'checked' : old('status') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="status">Active</label>
                </div>

            </div><!-- end input box -->
        </div>
    </div>
</div>
@csrf

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let company = document.getElementById("company"),
                name = document.getElementById("name"),
                validateInputIdArray = [
                    company.id,
                    name.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#company").select2();

        });
    </script>

@endsection


