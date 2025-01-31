<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

        <div class="row">

            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required">
                        {{--                        <a--}}
                        {{--                            data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                            data-placement="bottom" data-html="true"--}}
                        {{--                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.description')}}</p><h6>Benefit</h6><p>{{--}}
                        {{--                                                            config('fields_info.about_form_fields.party_registration.region.name.benefits')}}</p><h6>Example</h6><p>{{--}}
                        {{--                                                            config('fields_info.about_form_fields.party_registration.region.name.example')}}</p>--}}
                        {{--                                                             <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">--}}
                        {{--                            <l class="fa fa-info-circle"></l>--}}
                        {{--                        </a>--}}
                        Company Title
                        <a href="{{ route('companies.create') }}" role="button" class="add_btn" TARGET="_blank"
                           data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                           data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                            <i class="fa fa-plus"></i>
                        </a>
                        <a class="add_btn" data-container="body" data-toggle="popover"
                           onclick="fetchCompanies($('select#company'));"
                           data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </label>
                    <select tabindex="1" autofocus name="company" id="company" data-fetch-url="{{ route('api.companies.options') }}"
                            data-rule-required="true" data-msg-required="Please Choose Company"
                            class="inputs_up form-control @error('company') is-invalid @enderror">
                        <option value="" selected disabled>Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{$company->account_uid}}"
                                    data-company-id="{{ $company->account_uid }}" {{ $company->account_uid === $circle->company_id ? 'selected' : old('company') === $company->account_uid ? 'selected' : ''}}>
                                {{$company->account_name}}</option>
                        @endforeach

{{--                        @foreach ($companies as $company)--}}
{{--                            <option value="{{ $company->slug }}"--}}
{{--                                    data-company-id="{{ $company->id }}" {{ $company->id === $circle->company_id ? 'selected' : old('company') === $company->slug ? 'selected' : ''}}>{{ $company->name }}</option>--}}
{{--                        @endforeach--}}
                    </select>
                    @error('company')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                    </span>
                    @enderror


                    <span id="demo1" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required">
                        {{--                        <a--}}
                        {{--                            data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                            data-placement="bottom" data-html="true"--}}
                        {{--                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.description')}}</p><h6>Benefit</h6><p>{{--}}
                        {{--                                                                                    config('fields_info.about_form_fields.party_registration.area.area_title.benefits')}}</p><h6>Example</h6><p>{{--}}
                        {{--                                                                config('fields_info.about_form_fields.party_registration.area.area_title.example')}}</p>--}}
                        {{--                                                               <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.validations') }}</p>">--}}
                        {{--                            <l class="fa fa-info-circle"></l>--}}
                        {{--                        </a>--}}
                        Region Title
                        <a href="{{ route('regions.create') }}" class="add_btn" target="_blank" data-container="body"
                           data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.add.description')}}">
                            <l class="fa fa-plus"></l>
                        </a>
                        <a class="add_btn" onclick="$('select#company').trigger('change');" data-container="body"
                           data-toggle="popover"
                           data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                            <l class="fa fa-refresh"></l>
                        </a>
                    </label>
                    <select tabindex="2" name="region" id="region"
                            class="inputs_up form-control @error('region') is-invalid @enderror"
                            data-rule-required="true" data-msg-required="Please Choose Region"
                    >
                        <option value="" selected disabled>Select Company First</option>
                    </select>
                    @error('region')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                    {{--                    <select name="region" id="region" class="inputs_up form-control" required>--}}
                    {{--                        <option value="" selected disabled>Select Company First</option>--}}
                    {{--                    </select>--}}
                    <span id="demo2" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required">
                        {{--                        <a--}}
                        {{--                            data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                            data-placement="bottom" data-html="true"--}}
                        {{--                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.description')}}</p><h6>Benefit</h6><p>{{--}}
                        {{--                                                            config('fields_info.about_form_fields.party_registration.sector.sector_title.benefits')}}</p>--}}
                        {{--                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.example')}}</p>--}}
                        {{--                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.validations') }}</p>">--}}
                        {{--                            <l class="fa fa-info-circle"></l>--}}
                        {{--                        </a>--}}
                        Zone Title
                        <a href="{{ route('zones.create') }}" class="add_btn" target="_blank" data-container="body"
                           data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.add.description')}}">
                            <l class="fa fa-plus"></l>
                        </a>
                        <a class="add_btn" data-container="body" data-toggle="popover"
                           onclick="$('select#region').trigger('change');"
                           data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                            <l class="fa fa-refresh"></l>
                        </a>
                    </label>
                    <select tabindex="3" name="zone" id="zone" class="inputs_up form-control @error('zone') is-invalid @enderror"
                            data-rule-required="true" data-msg-required="Please Choose Zone"
                            >
                        <option value="" selected disabled>Select Region First</option>
                    </select>
                    @error('zone')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                    <span id="demo3" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required">
                        {{--                        <a--}}
                        {{--                            data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                            data-placement="bottom" data-html="true"--}}
                        {{--                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.description')}}</p><h6>Benefit</h6><p>{{--}}
                        {{--                                                            config('fields_info.about_form_fields.party_registration.sector.sector_title.benefits')}}</p>--}}
                        {{--                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.example')}}</p>--}}
                        {{--                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.validations') }}</p>">--}}
                        {{--                            <l class="fa fa-info-circle"></l>--}}
                        {{--                        </a>--}}
                        City Title
                        <a href="{{ route('cities.create') }}" class="add_btn" target="_blank" data-container="body"
                           data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.add.description')}}">
                            <l class="fa fa-plus"></l>
                        </a>
                        <a class="add_btn" data-container="body" data-toggle="popover"
                           onclick="$('select#zone').trigger('change');"
                           data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                            <l class="fa fa-refresh"></l>
                        </a>
                    </label>
                    <select tabindex="4" name="city" id="city" class="inputs_up form-control @error('city') is-invalid @enderror"
                            data-rule-required="true" data-msg-required="Please Choose City"
                            >
                        <option value="" selected disabled>Select Zone First</option>
                    </select>
                    @error('city')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                    <span id="demo3" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required" for="grid">Grid
                        <a href="{{ route('grids.create') }}" class="add_btn" target="_blank" data-container="body"
                           data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.add.description')}}">
                            <l class="fa fa-plus"></l>
                        </a>
                        <a class="add_btn" data-container="body" data-toggle="popover" onclick="$('select#city').trigger('change');"
                           data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                            <l class="fa fa-refresh"></l>
                        </a>
                    </label>
                    <select tabindex="5" name="grid" id="grid" class="inputs_up form-control @error('grid') is-invalid @enderror"
                            data-rule-required="true" data-msg-required="Please Choose Grid"
                            >
                        <option value="" selected disabled>Select City First</option>
                    </select>
                    @error('grid')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                    <span id="demo3" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required" for="franchiseArea">Franchise / Area
                        <a href="{{ route('franchise-area.create') }}" class="add_btn" target="_blank" data-container="body"
                           data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.add.description')}}">
                            <l class="fa fa-plus"></l>
                        </a>
                        <a class="add_btn" data-container="body" data-toggle="popover" onclick="$('select#grid').trigger('change');"
                           data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                            <l class="fa fa-refresh"></l>
                        </a>
                    </label>
                    <select tabindex="6" name="franchiseArea" id="franchiseArea"
                            class="inputs_up form-control @error('franchiseArea') is-invalid @enderror"
                            data-rule-required="true" data-msg-required="Please Choose Area"
                    >
                        <option value="" selected disabled>Select Grid First</option>
                    </select>
                    @error('franchiseArea')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                    <span id="demo3" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required" for="name">Circle</label>
                    <input tabindex="7" type="text" class="inputs_up form-control @error('name') is-invalid @enderror" id="name"
                           data-rule-required="true" data-msg-required="Please Choose Circle"
                           name="name"
                           value="{{ $circle->name ?? old('name') }}" placeholder="Enter Grid Name">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                    <span id="demo3" class="validate_sign"> </span>
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
                    <textarea tabindex="8" name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks"
                              style="height: 230px !important;">{{ $circle->remarks ?? old('remarks') }}</textarea>
                    <span id="demo4" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12">
            <div class="input_bx"><!-- start input box -->
                <div class="custom-control custom-checkbox" style="float: left">
                    <input tabindex="9" type="checkbox" class="custom-control-input" id="status" name="status"
                           value="{{ $circle->getStatus('active') }}" {{ isset($circle->status) ? '' : 'checked' }} {{ $circle->status === $circle->getStatus('active') ? 'checked' : old('status') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="status">Active</label>
                </div>

            </div><!-- end input box -->
        </div>
    </div>


    <input type="hidden" id="data" data-company-id="{{ $circle->company_id }}"
           data-region-id="{{ $circle->region_id }}" data-region-action="{{ route('api.regions.options') }}"
           data-zone-id="{{ $circle->zone_id }}" data-zone-action="{{ route('api.zones.options') }}"
           data-city-id="{{ $circle->city_id }}" data-city-action="{{ route('api.cities.options') }}"
           data-grid-id="{{ $circle->grid_id }}" data-grid-action="{{ route('api.grids.options') }}"
           data-franchise-area-id="{{ $circle->franchise_area_id }}"
           data-franchise-area-action="{{ route('api.franchise-area.options') }}">
</div>

@csrf
{{--    required input validation --}}
<script type="text/javascript">
    function checkForm() {
        let company = document.getElementById("company"),
            region = document.getElementById("region"),
            zone = document.getElementById("zone"),
            city = document.getElementById("city"),
            grid = document.getElementById("grid"),
            franchiseArea = document.getElementById("franchiseArea"),
            name = document.getElementById("name"),
            validateInputIdArray = [
                company.id,
                region.id,
                zone.id,
                city.id,
                grid.id,
                franchiseArea.id,
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
        jQuery("#region").select2();
        jQuery("#zone").select2();
        jQuery("#city").select2();
        jQuery("#grid").select2();
        jQuery("#franchiseArea").select2();

    });
</script>
