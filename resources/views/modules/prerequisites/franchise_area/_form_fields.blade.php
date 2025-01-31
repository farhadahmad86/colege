<div class="row">

    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">


        <div class="row">
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                        {{--                        <a class="add_btn" data-container="body" data-toggle="popover"--}}
                        {{--                           onclick="fetchCompanies($('select#company'));"--}}
                        {{--                           data-trigger="hover" data-placement="bottom" data-html="true"--}}
                        {{--                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                        {{--                            <i class="fa fa-refresh"></i>--}}
                        {{--                        </a>--}}
                    </label>

                    <select tabindex="1" name="company" id="company"
                            class="inputs_up form-control @error('company') is-invalid @enderror"
                            data-fetch-url="{{ route('api.companies.options') }}"
                            data-rule-required="true" data-msg-required="Please Choose Company"
                    >
                        <option value="" selected disabled>Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{$company->account_uid}}"
                                    data-company-id="{{ $company->account_uid }}" {{ $company->account_uid === $franchiseArea->company_id ? 'selected' : old('company') === $company->account_uid ? 'selected' : ''}}>
                                {{$company->account_name}}</option>
                        @endforeach

                        {{--                        @foreach ($companies as $company)--}}
                        {{--                            <option value="{{ $company->slug }}"--}}
                        {{--                                    data-company-id="{{ $company->id }}" {{ $company->id === $franchiseArea->company_id ? 'selected' : old('company') === $company->slug ? 'selected' : ''}}>{{ $company->name }}</option>--}}
                        {{--                        @endforeach--}}
                    </select>
                    @error('company')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                    {{--                    <span id="demo1" class="validate_sign"> </span>--}}
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required">
                        {{--                        <a--}}
                        {{--                            data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                            data-placement="bottom" data-html="true"--}}
                        {{--                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.description')}}</p><h6>Benefit</h6><p>}}--}}
                        {{--                                                                                                            config('fields_info.about_form_fields.party_registration.area.area_title.benefits')}}</p><h6>Example</h6><p>}}--}}
                        {{--                                                                                        config('fields_info.about_form_fields.party_registration.area.area_title.example')}}</p>--}}
                        {{--                                                                                       <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.validations') }}</p>">--}}
                        {{--                            <l class="fa fa-info-circle"></l>--}}
                        {{--                        </a>--}}
                        Zone Title
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
                    <span id="demo2" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required">
                        {{--                        <a--}}
                        {{--                            data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                            data-placement="bottom" data-html="true"--}}
                        {{--                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.description')}}</p><h6>Benefit</h6><p>}}--}}
                        {{--                                                                                    config('fields_info.about_form_fields.party_registration.sector.sector_title.benefits')}}</p>--}}
                        {{--                                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.example')}}</p>--}}
                        {{--                                                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.validations') }}</p>">--}}
                        {{--                            <l class="fa fa-info-circle"></l>--}}
                        {{--                        </a>--}}
                        Region Title
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


                    <span id="demo3" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required">
                        {{--                        <a--}}
                        {{--                            data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                            data-placement="bottom" data-html="true"--}}
                        {{--                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.description')}}</p><h6>Benefit</h6><p>}}--}}
                        {{--                                                                                    config('fields_info.about_form_fields.party_registration.sector.sector_title.benefits')}}</p>--}}
                        {{--                                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.example')}}</p>--}}
                        {{--                                                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.validations') }}</p>">--}}
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
                    <span id="demo4" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="required">
                        {{--                        <a--}}
                        {{--                            data-container="body" data-toggle="popover" data-trigger="hover"--}}
                        {{--                            data-placement="bottom" data-html="true"--}}
                        {{--                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.description')}}</p><h6>Benefit</h6><p>}}--}}
                        {{--                                                                                    config('fields_info.about_form_fields.party_registration.sector.sector_title.benefits')}}</p>--}}
                        {{--                                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.example')}}</p>--}}
                        {{--                                                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.validations') }}</p>">--}}
                        {{--                            <l class="fa fa-info-circle"></l>--}}
                        {{--                        </a>--}}
                        Grid Title
                        <a href="{{ route('grids.create') }}" class="add_btn" target="_blank" data-container="body"
                           data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.add.description')}}">
                            <l class="fa fa-plus"></l>
                        </a>
                        <a class="add_btn" data-container="body" data-toggle="popover"
                           onclick="$('select#city').trigger('change');"
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

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label for="code">Franchise Code</label>
                    <input tabindex="6" type="text" class="inputs_up form-control @error('code') is-invalid @enderror" id="code"
                           name="code" data-rule-required="true" data-msg-required="Please Enter Code"
                           value="{{ $franchiseArea->code ?? old('code') }}" placeholder="Enter Franchise Code">
                    @error('code')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                    <span id="demo4" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label for="name">Franchise Name</label>
                    <input tabindex="7" type="text" class="inputs_up form-control @error('name') is-invalid @enderror" id="name"
                           name="name" data-rule-required="true" data-msg-required="Please Enter Franchise Name"
                           value="{{ $franchiseArea->name ?? old('name') }}" placeholder="Enter Franchise Name">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                    <span id="demo4" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label for="bdoName">BDO Name</label>
                    <input tabindex="8" type="text" class="inputs_up form-control @error('bdoName') is-invalid @enderror"
                           id="bdoName" name="bdoName"
                           value="{{ $franchiseArea->bdoName ?? old('bdoName') }}" placeholder="Enter BDO Name">
                    @error('bdoName')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                    <span id="demo4" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label for="bdoContact">BDO Contact</label>
                    <input tabindex="9" type="text" class="inputs_up form-control @error('bdoContact') is-invalid @enderror"
                           id="bdoContact"
                           name="bdoContact" value="{{ $franchiseArea->bdoContact ?? old('bdoContact') }}"
                           data-rule-digits="true" data-msg-digits="Please enter only digits numbers"
                           placeholder="Enter BDO Contact">
                    @error('bdoContact')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                    <span id="demo4" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label for="moName">MO Name</label>
                    <input tabindex="10" type="text" class="inputs_up form-control @error('moName') is-invalid @enderror" id="moName"
                           name="moName"
                           value="{{ $franchiseArea->moName ?? old('moName') }}" placeholder="Enter MO Name">
                    @error('moName')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                    <span id="demo4" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label for="moContact">MO Contact</label>
                    <input tabindex="11" type="text" class="inputs_up form-control @error('moContact') is-invalid @enderror"
                           id="moContact" name="moContact"
                           value="{{ $franchiseArea->moContact ?? old('moContact') }}" placeholder="Enter MO Contact"
                           data-rule-digits="true" data-msg-digits="Please enter only digits numbers">
                    @error('moContact')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                    <span id="demo4" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <div class="input_bx"><!-- start input box -->
                            <div class="custom-control custom-checkbox" style="float: left">
                                <input tabindex="12" type="checkbox" class="custom-control-input" id="status" name="status"
                                       value="{{ $franchiseArea->getStatus('active') }}" {{ isset($franchiseArea->status) ? '' : 'checked' }} {{ $franchiseArea->status === $franchiseArea->getStatus('active') ? 'checked' : old('status') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Active</label>
                            </div>

                        </div><!-- end input box -->
                    </div>
                    <span id="demo4" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

        </div>

    </div>

    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

        <div class="row">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                    <textarea tabindex="13" name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks"
                              style="height: 310px;">{{ $franchiseArea->remarks ?? old('remarks') }}</textarea>


                    <span id="demo5" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>
        </div>

    </div>

    <input type="hidden" id="data" data-company-id="{{ $franchiseArea->company_id }}"
           data-region-id="{{ $franchiseArea->region_id }}" data-region-action="{{ route('api.regions.options') }}"
           data-zone-id="{{ $franchiseArea->zone_id }}" data-zone-action="{{ route('api.zones.options') }}"
           data-city-id="{{ $franchiseArea->city_id }}" data-city-action="{{ route('api.cities.options') }}"
           data-grid-id="{{ $franchiseArea->grid_id }}" data-grid-action="{{ route('api.grids.options') }}">

</div>
@csrf
@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let company = document.getElementById("company"),
                region = document.getElementById("region"),
                zone = document.getElementById("zone"),
                city = document.getElementById("city"),
                grid = document.getElementById("grid"),
                code = document.getElementById("code"),
                name = document.getElementById("name"),
                validateInputIdArray = [
                    company.id,
                    region.id,
                    zone.id,
                    city.id,
                    grid.id,
                    code.id,
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

        });
    </script>

    <script type="text/javascript">
        // $('#save').click(function () {
        function saveFunction() {
            var company = jQuery("#company").val();
            var region = jQuery("#region").val();
            var zone = jQuery("#zone").val();
            var city = jQuery("#city").val();
            var grid = jQuery("#grid").val();
            var code = jQuery("#code").val();
            var name = jQuery("#name").val();
            var bdoName = jQuery("#bdoName").val();
            var bdoContact = jQuery("#bdoContact").val();
            var moName = jQuery("#moName").val();
            var moContact = jQuery("#moContact").val();
            var status = $("input:checkbox[name=status]:checked").val();
            var remarks = jQuery("#remarks").val();
            var grid_id =  $("#grid option:selected").attr('data-grid-id');

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (company == 0 || company == null || company == 'empty') {

                if (focus_once1 == 0) {
                    jQuery("#company").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (region == 0 || region == null || region == 'empty') {

                if (focus_once1 == 0) {
                    jQuery("#region").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (zone == 0 || zone == null || zone == 'empty') {

                if (focus_once1 == 0) {
                    jQuery("#zone").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (city == 0 || city == null || city == 'empty') {

                if (focus_once1 == 0) {
                    jQuery("#city").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (grid == 0 || grid == null || grid == 'empty') {

                if (focus_once1 == 0) {
                    jQuery("#grid").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (code == 0 || code == null || code == 'empty') {

                if (focus_once1 == 0) {
                    jQuery("#code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (name == 0 || name == null || name == 'empty') {

                if (focus_once1 == 0) {
                    jQuery("#name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (flag_submit1) {

                jQuery(".pre-loader").fadeToggle("medium");

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('franchise-area.store')}}",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'company': company,
                        'region': region,
                        'zone': zone,
                        'city': city,
                        'grid': grid,
                        'code': code,
                        'name': name,
                        'bdoName': bdoName,
                        'bdoContact': bdoContact,
                        'moName': moName,
                        'moContact': moContact,
                        'status': status,
                        'remarks': remarks,
                        'grid_id': grid_id
                    },

                    success: function (data) {
                        console.log(data);
                        console.log(data.message);
                        if(data.already_exist != null){
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Already Exist Franchise Name Try Another Name',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });

                        }else{
                            $('#code').val('');
                            $('#name').val('');
                            $('#bdoName').val('');
                            $('#bdoContact').val('');
                            $('#moName').val('');
                            $('#moContact').val('');

                            swal.fire({
                                title: 'Successfully Saved'+'  '+data.franchise_name,
                                text: false,
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });
                        }

                        jQuery(".pre-loader").fadeToggle("medium");
                    },
                    error: function () {
                        alert('error handling here');
                    }
                });
            }
        }

    </script>

@endsection
