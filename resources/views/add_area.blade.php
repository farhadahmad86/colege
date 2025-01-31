@extends('extend_index')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="container-fluid search-filter form-group form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Create Area</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('area_list') }}"
                                role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 mx-auto">
                        <div class="excel_con p-0">
                            <div class="excel_box">
                                <div class="excel_box_hdng">
                                    <h2>Upload Excel File</h2>
                                </div>
                                <div class="excel_box_content>
                                    <form action="{{ route('submit_area_excel') }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="input_bx">
                                                <!-- start input box -->
                                                <label class="required">
                                                    Select Excel File
                                                </label>
                                                <input tabindex="100" type="file" name="add_area_excel"
                                                    id="add_area_excel"
                                                    class="inputs_up form-control-file form-control height-auto"
                                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                            <a href="{{ url('public/sample/area/add_area_pattern.xlsx') }}" tabindex="-1"
                                                type="reset" class="cancel_button btn btn-sm btn-info">
                                                Download Sample Pattern
                                            </a>
                                            <button tabindex="101" type="submit" name="save" id="save2"
                                                class="save_button btn btn-sm btn-success">
                                                <i class="fa fa-floppy-o"></i> Save
                                            </button>
                                        </div>
                                    </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <form name="f1" class="f1" id="f1" onsubmit="return checkForm()"
                            action="{{ route('submit_area') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                                data-trigger="hover" data-placement="bottom"
                                                                data-html="true"
                                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.description') }}</p><h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.benefits') }}</p><h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.example') }}</p><h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Region Title
                                                            <a href="{{ route('add_region') }}" role="button"
                                                                class="add_btn" TARGET="_blank" data-container="body"
                                                                data-toggle="popover" data-trigger="hover"
                                                                data-placement="bottom" data-html="true"
                                                                data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a class="add_btn" id="refresh_region" data-container="body"
                                                                data-toggle="popover" data-trigger="hover"
                                                                data-placement="bottom" data-html="true"
                                                                data-content="{{ config('fields_info.about_form_fields.refresh.description') }}">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </label>
                                                        <select tabindex="1" autofocus name="region_name"
                                                            class="inputs_up form-control required" id="region_name"
                                                            autofocus data-rule-required="true"
                                                            data-msg-required="Please Enter Region Title">
                                                            <option value="">Select Region</option>
                                                            @foreach ($regions as $region)
                                                                <option value="{{ $region->reg_id }}"
                                                                    {{ old('region_name') == $region->reg_id ? 'selected="selected"' : '' }}>
                                                                    {{ $region->reg_title }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="demo1" class="validate_sign"> </span>
                                                    </div>
                                                    <!-- end input box -->
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            <a data-container="body" data-toggle="popover"
                                                                data-trigger="hover" data-placement="bottom"
                                                                data-html="true"
                                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.area.area_title.description') }}</p><h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.area.area_title.benefits') }}</p><h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.area.area_title.example') }}</p><h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.area.area_title.validations') }}</p>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Area Title</label>
                                                        <input tabindex="2" type="text" name="area_name"
                                                            id="area_name" class="inputs_up form-control"
                                                            placeholder="Area Title" autocomplete="off"
                                                            value="{{ old('area_name') }}" data-rule-required="true"
                                                            data-msg-required="Please Enter Area Title">
                                                        <span id="demo2" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="">
                                                            <a data-container="body" data-toggle="popover"
                                                                data-trigger="hover" data-placement="bottom"
                                                                data-html="true"
                                                                data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.description') }}</p><h6>Benefit</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits') }}</p><h6>Example</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.example') }}</p><h6>Validation</h6><p>{{ config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                <i class="fa fa-info-circle"></i>
                                                            </a>
                                                            Remarks</label>
                                                        <textarea tabindex="3" name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks"
                                                            style="height: 100px;">{{ old('remarks') }}</textarea>
                                                        <span id="demo3" class="validate_sign"> </span>
                                                    </div><!-- end input box -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                            <button tabindex="4" type="reset" name="cancel" id="cancel"
                                                class="cancel_button btn btn-sm btn-secondary">
                                                <i class="fa fa-eraser"></i> Cancel
                                            </button>
                                            <button tabindex="5" type="button" name="save" id="save"
                                                class="save_button btn btn-sm btn-success">
                                                <i class="fa fa-floppy-o"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </div> <!-- left column ends here -->
                            </div> <!--  main row ends here -->
                        </form>
                    </div>
                </div>
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
            var check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                let remarks = document.getElementById("remarks").value;

                jQuery(".pre-loader").fadeToggle("medium");

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('submit_area') }}",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'region_name': region_name.value,
                        'area_name': area_name.value,
                        'remarks': remarks,
                    },

                    success: function(data) {
                        console.log(data);
                        console.log(data.message);
                        if (data.already_exist != null) {
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Already Exist Area Name Try Another Name',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });

                        } else {
                            $('#area_name').val('');
                            $('#remarks').val('');

                            swal.fire({
                                title: 'Successfully Saved' + '  ' + data.name,
                                text: false,
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });
                        }

                        jQuery(".pre-loader").fadeToggle("medium");
                    },
                    error: function error(xhr, textStatus, errorThrown, jqXHR) {
                        console.log(xhr.responseText, textStatus, errorThrown, jqXHR);
                        console.log('ajax company error');
                    },
                    // error: function () {
                    //     alert('error handling here');
                    // }
                });
            } else {
                return false;
            }

        }
    </script>
    {{-- end of required input validation --}}
    <script>
        $("#save").click(function() {
            checkForm();
        });
    </script>
    <script>
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $(function() {
            $('[data-toggle="popover"]').popover()
        });
    </script>

    <script>
        $('#region_name').select2();
        jQuery("#refresh_region").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_region",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function(data) {

                    jQuery("#region_name").html(" ");
                    jQuery("#region_name").append(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>
@endsection
