
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
                                    data-company-id="{{ $company->account_uid }}" {{ $company->account_uid === $zone->company_id ? 'selected' : old('company') === $company->account_uid ? 'selected' : ''}}>

                                {{$company->account_name}}</option>
                        @endforeach
{{--                        @foreach ($companies as $company)--}}
{{--                            <option value="{{ $company->slug }}"--}}
{{--                                    data-company-id="{{ $company->id }}" {{ $company->id === $zone->company_id ? 'selected' : old('company') === $company->slug ? 'selected' : ''}}>{{ $company->name }}</option>--}}
{{--                        @endforeach--}}
                    </select>

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
                        Zone Title
                        <a href="{{ route('regions.create') }}" class="add_btn" target="_blank" data-container="body"
                           data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.add.description')}}">
                            <l class="fa fa-plus"></l>
                        </a>
                        <a class="add_btn" data-container="body" data-toggle="popover" onclick="$('select#company').trigger('change');"
                           data-trigger="hover" data-placement="bottom" data-html="true"
                           data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                            <l class="fa fa-refresh"></l>
                        </a>
                    </label>
                    <select tabindex="2" name="region" id="region" class="inputs_up form-control"
                            data-rule-required="true" data-msg-required="Please Choose Region"
                    >
                        <option value="" selected disabled>Select Company First</option>
                    </select>
                    {{--                <select name="area_name" class="inputs_up form-control" id="area_name"   data-rule-required="true" data-msg-required="Please Enter Area Title">--}}
                    {{--                    <option value="">Select Area</option>--}}
                    {{--                </select>--}}
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
                        Region Title</label>
                    <input tabindex="3" type="text" class="inputs_up form-control @error('name') is-invalid @enderror" id="name"
                           name="name" value="{{ $zone->name ?? old('name') }}" placeholder="Enter Zone Name"
                           data-rule-required="true" data-msg-required="Please Enter Zone"
                    >

                    {{--                <input type="text" name="sector_name" id="sector_name" class="inputs_up form-control" placeholder="Sector Title" autocomplete="off"   data-rule-required="true" data-msg-required="Please Enter Sector Title" value="{{ old('sector_name') }}">--}}
                    <span id="demo3" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12">
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
                        Regional Name</label>
                    <input tabindex="4" type="text" class="inputs_up form-control @error('name') is-invalid @enderror" id="zonal_name"
                           name="zonal_name" value="{{ $zone->zonal_name ?? old('zonal_name') }}" placeholder="Enter Zone Name"
                           data-rule-required="true" data-msg-required="Please Enter Zonal Name"
                    >

                    {{--                <input type="text" name="sector_name" id="sector_name" class="inputs_up form-control" placeholder="Sector Title" autocomplete="off"   data-rule-required="true" data-msg-required="Please Enter Sector Title" value="{{ old('sector_name') }}">--}}
                    <span id="demo3" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

            <div class="form-group col-lg-6 col-md-6 col-sm-12">
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
                        Regional Contact</label>
                    <input tabindex="5" type="text" class="inputs_up form-control @error('name') is-invalid @enderror" id="zonal_contact"
                           name="zonal_contact" value="{{ $zone->zonal_contact ?? old('zonal_contact') }}" placeholder="Enter Zone Name"
                           data-rule-required="true" data-msg-required="Please Enter Zone"
                    >

                    {{--                <input type="text" name="sector_name" id="sector_name" class="inputs_up form-control" placeholder="Sector Title" autocomplete="off"   data-rule-required="true" data-msg-required="Please Enter Sector Title" value="{{ old('sector_name') }}">--}}
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
                    <textarea tabindex="6" name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks"
                              style="height: 168px !important;">{{ $zone->remarks ?? old('remarks') }}</textarea>
                    <span id="demo4" class="validate_sign"> </span>
                </div><!-- end input box -->
            </div>

        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12">
            <div class="input_bx"><!-- start input box -->
                <div class="custom-control custom-checkbox" style="float: left">
                    <input type="checkbox" class="custom-control-input" id="status" name="status"
                           value="{{ $zone->getStatus('active') }}" {{ isset($zone->status) ? '' : 'checked' }} {{ $zone->status === $zone->getStatus('active') ? 'checked' : old('status') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="status">Active</label>
                </div>

            </div><!-- end input box -->
        </div>
    </div>


    <input type="hidden" id="data" data-company-id="{{ $zone->company_id }}" data-region-id="{{ $zone->region_id }}"
           data-region-action="{{ route('api.regions.options') }}">
</div>
@csrf
@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let company = document.getElementById("company"),
                region = document.getElementById("region"),
                name = document.getElementById("name"),
                validateInputIdArray = [
                    company.id,
                    region.id,
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

        });
    </script>
    <script type="text/javascript">
        // $('#save').click(function () {
        function saveFunction() {
            var company = jQuery("#company").val();
            var region = jQuery("#region").val();
            var name = jQuery("#name").val();
            var zonal_name = jQuery("#zonal_name").val();
            var zonal_contact = jQuery("#zonal_contact").val();
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
                    url: "{{route('zones.store')}}",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'company': company,
                        'region': region,

                        'name': name,
                        'zonal_name': zonal_name,
                        'zonal_contact': zonal_contact,

                        'status': status,
                        'remarks': remarks
                    },

                    success: function (data) {
                        console.log(data.message);
                        if(data.already_exist != null){
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Already Exist Zone Title Try Another Name',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });

                        }else{
                            $('#name').val('');
                            $('#zonal_name').val('');
                            $('#moContact').val('');

                            swal.fire({
                                title: 'Successfully Saved'+'  '+data.zone_name,
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
