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
{{--                        <a class="add_btn" data-container="body" data-toggle="popover" onclick="fetchCompanies($('select#company'));"--}}
{{--                           data-trigger="hover" data-placement="bottom" data-html="true"--}}
{{--                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
{{--                            <i class="fa fa-refresh"></i>--}}
{{--                        </a>--}}
                    </label>
                    <select tabindex="1" autofocus name="company" id="company" class="inputs_up form-control" data-fetch-url="{{ route('api.companies.options') }}"
                            data-rule-required="true" data-msg-required="Please Choose Company"
                    >
                        <option value="" selected disabled>Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{$company->account_uid}}"
                                    data-company-id="{{ $company->account_uid }}" {{ $company->account_uid === $grid->company_id ? 'selected' : old('company') === $company->account_uid ? 'selected' : ''}}>

                                {{$company->account_name}}</option>
                        @endforeach

{{--                        @foreach ($companies as $company)--}}
{{--                            <option value="{{ $company->slug }}"--}}
{{--                                    data-company-id="{{ $company->id }}" {{ $company->id === $grid->company_id ? 'selected' : old('company') === $company->slug ? 'selected' : ''}}>{{ $company->name }}</option>--}}
{{--                        @endforeach--}}
                    </select>
{{--                    <span id="demo1" class="validate_sign"> </span>--}}
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                        Zone Title
                        <a href="{{ route('regions.create') }}" class="add_btn" target="_blank" data-container="body"
                           data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.add.description')}}">
                            <l class="fa fa-plus"></l>
                        </a>
                        <a class="add_btn" onclick="$('select#company').trigger('change');" data-container="body" data-toggle="popover"
                           data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                            <l class="fa fa-refresh"></l>
                        </a>
                    </label>
                    <select tabindex="2" name="region" id="region" class="custom-select"
                            data-rule-required="true" data-msg-required="Please Choose Region"
                    >
                        <option value="" selected disabled>Select Company First</option>
                    </select>
{{--                    <span id="demo2" class="validate_sign"> </span>--}}
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                        Region Title
                        <a href="{{ route('zones.create') }}" class="add_btn" target="_blank" data-container="body"
                           data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.add.description')}}">
                            <l class="fa fa-plus"></l>
                        </a>
                        <a class="add_btn" data-container="body" data-toggle="popover" onclick="$('select#region').trigger('change');"
                           data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                            <l class="fa fa-refresh"></l>
                        </a>
                    </label>
                    <select tabindex="3" name="zone" id="zone" class="custom-select"
                            data-rule-required="true" data-msg-required="Please Choose Zone"
                    >
                        <option value="" selected disabled>Select Region First</option>
                    </select>

{{--                    <span id="demo3" class="validate_sign"> </span>--}}
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                        <a class="add_btn" data-container="body" data-toggle="popover" onclick="$('select#zone').trigger('change');"
                           data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                            <l class="fa fa-refresh"></l>
                        </a>
                    </label>
                    <select tabindex="4" name="city" id="city" class="custom-select"
                            data-rule-required="true" data-msg-required="Please Choose City"
                    >
                        <option value="" selected disabled>Select Zone First</option>
                    </select>
                    @error('city')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
{{--                    <span id="demo4" class="validate_sign"> </span>--}}
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                        Grid Title</label>
                    <input tabindex="5" type="text" class="inputs_up form-control @error('name') is-invalid @enderror" id="name" name="name"
                           value="{{ $grid->name ?? old('name') }}" placeholder="Enter Grid Name"
                           data-rule-required="true" data-msg-required="Please Enter Name"
                    >
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror

{{--                    <span id="demo3" class="validate_sign"> </span>--}}
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="">
{{--                        <a--}}
{{--                            data-container="body" data-toggle="popover" data-trigger="hover"--}}
{{--                            data-placement="bottom" data-html="true"--}}
{{--                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.description')}}</p><h6>Benefit</h6><p>{{--}}
{{--                                                            config('fields_info.about_form_fields.party_registration.sector.sector_title.benefits')}}</p>--}}
{{--                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.example')}}</p>--}}
{{--                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.validations') }}</p>">--}}
{{--                            <l class="fa fa-info-circle"></l>--}}
{{--                        </a>--}}
                        Manager Name</label>
                    <input tabindex="6" type="text" class="inputs_up form-control @error('manager') is-invalid @enderror" id="manager"
                           name="manager" value="{{ $grid->manager ?? old('manager') }}"
                           placeholder="Enter Manager Name">
                    @error('manager')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
{{--                    <span id="demo4" class="validate_sign"> </span>--}}
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <label class="">
{{--                        <a--}}
{{--                            data-container="body" data-toggle="popover" data-trigger="hover"--}}
{{--                            data-placement="bottom" data-html="true"--}}
{{--                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.description')}}</p><h6>Benefit</h6><p>{{--}}
{{--                                                            config('fields_info.about_form_fields.party_registration.sector.sector_title.benefits')}}</p>--}}
{{--                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.example')}}</p>--}}
{{--                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.validations') }}</p>">--}}
{{--                            <l class="fa fa-info-circle"></l>--}}
{{--                        </a>--}}
                        Contact </label>
                    <input tabindex="7" type="text" class="inputs_up form-control @error('contact') is-invalid @enderror" id="contact" name="contact" data-rule-digits="true" data-msg-digits="Please enter contact number" value="{{ $grid->contact ?? old('contact') }}" placeholder="Enter contact">
                    @error('contact')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
{{--                    <span id="demo4" class="validate_sign"> </span>--}}
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input_bx"><!-- start input box -->
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <div class="input_bx"><!-- start input box -->
                            <div class="custom-control custom-checkbox" style="float: left">
                                <input tabindex="-1" type="checkbox" class="custom-control-input" id="status" name="status"
                                       value="{{ $grid->getStatus('active') }}" {{ isset($grid->status) ? '' : 'checked' }} {{ $grid->status === $grid->getStatus('active') ? 'checked' : old('status') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Active</label>
                            </div>

                        </div><!-- end input box -->
                    </div>
{{--                    <span id="demo4" class="validate_sign"> </span>--}}
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
                    <textarea tabindex="8" name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks"
                              style="height: 210px;" >{{ $grid->remarks ?? old('remarks') }}</textarea>


                    <span id="demo5" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>
        </div>


    </div>
    <input tabindex="9" type="hidden" id="data" data-company-id="{{ $grid->company_id }}"
           data-region-id="{{ $grid->region_id }}" data-region-action="{{ route('api.regions.options') }}"
           data-zone-id="{{ $grid->zone_id }}" data-zone-action="{{ route('api.zones.options') }}"
           data-city-id="{{ $grid->city_id }}" data-city-action="{{ route('api.cities.options') }}">
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
                name = document.getElementById("name"),
                validateInputIdArray = [
                    company.id,
                    region.id,
                    zone.id,
                    city.id,
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

        });
    </script>
    <script type="text/javascript">
        // $('#save').click(function () {
        function saveFunction() {
            var company = jQuery("#company").val();
            var region = jQuery("#region").val();
            var zone = jQuery("#zone").val();
            var zone__id = jQuery("#zone option:selected").attr('data-zone-id');
            var city = jQuery("#city").val();
            var name = jQuery("#name").val();
            var manager = jQuery("#manager").val();
            var contact = jQuery("#contact").val();
            var status = $("input:checkbox[name=status]:checked").val();
            var remarks = jQuery("#remarks").val();


            var flag_submit1 = true;
            var focus_once1 = 0;

            if (company == 0 || company == null || company=='empty') {

                if (focus_once1 == 0) {
                    jQuery("#company").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (region == 0 || region == null || region=='empty') {

                if (focus_once1 == 0) {
                    jQuery("#region").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (zone == 0 || zone == null || zone=='empty') {

                if (focus_once1 == 0) {
                    jQuery("#zone").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (city == 0 || city == null || city=='empty') {

                if (focus_once1 == 0) {
                    jQuery("#city").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (name == 0 || name == null || name=='empty') {

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
                    url: "{{route('grids.store')}}",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'company': company,
                        'region': region,
                        'zone': zone,
                        'zone__id': zone__id,
                        'city': city,
                        'name': name,
                        'manager': manager,
                        'contact': contact,
                        'status': status,
                        'remarks': remarks
                    },

                    success: function (data) {
                        console.log(data.message);
                        if(data.already_exist != null){
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Already Exist Grid Name Try Another Name',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });

                        }else{
                            $('#code').val('');
                            $('#name').val('');
                            $('#manager').val('');
                            $('#contact').val('');

                            swal.fire({
                                title: 'Successfully Saved'+'  '+data.grid_name,
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
