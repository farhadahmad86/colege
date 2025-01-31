@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Edit Group</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('college_group_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('update_college_groups') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->

                            <div class="custom-control custom-radio mb-10 mt-1">
                                <input tabindex="12" type="radio" name="discipline" class="custom-control-input annual"
                                    id="annual" value="A"
                                    {{ $request->discipline_id == 'A' ? 'checked' : 'disabled' }}>
                                <label class="custom-control-label" for="annual">
                                    Annual
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-10 mt-1">
                                <input tabindex="13" type="radio" name="discipline" class="custom-control-input semester"
                                    id="semester" value="S"
                                    {{ $request->discipline_id == 'S' ? 'checked' : 'disabled' }}>
                                <label class="custom-control-label" for="semester">
                                    Semester
                                </label>
                            </div>
                            <span id="marital_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class
                            </label>
                            <select tabindex="1" autofocus name="class_id" class="form-control required" id="class_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Class">
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Section
                            </label>
                            <select tabindex="1" autofocus name="section_id" class="form-control" id="section_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Section">
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Group
                            </label>
                            <select name="group_names" id="group_names" class="inputs_up form-control"
                                data-rule-required="true" data-msg-required="Please Enter Group Name">
                                <option value="">Select Group</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->ng_id }}"
                                        {{ $group->ng_id == $request->title ? 'selected' : '' }}>{{ $group->ng_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Subject
                            </label>
                            <select tabindex=42 autofocus name="subject[]" class="form-control" data-rule-required="true"
                                data-msg-required="Please Enter Subject" id="subject" multiple
                                placeholder="Select Subjects">
                                <option value="" disabled>Select Subjects</option>
                                @foreach ($subjects as $subject)
                                    @php
                                        $subjects = explode(',', $request->subject_id);
                                    @endphp
                                    <option value="{{ $subject->subject_id }}"
                                        {{ in_array($subject->subject_id, $subjects) ? 'selected' : '' }}>
                                        {{ $subject->subject_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                </div>
                <div class="row semester-div" style="display: none;">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Semester
                            </label>
                            <select name="semester_id" id="semester_id" class="inputs_up form-control"
                                data-rule-required="true" data-msg-required="Please Enter...">
                                <option value="">Select Semester</option> --}}
                            </select>
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="{{ $request->group_id }}" name="group_id">
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="submit" name="save" id="save"
                            class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Function to update the Class dropdown options based on radio button selection
            function updateClassOptions() {
                var isSemester = $('#semester').prop('checked');
                var classDropdown = $('#class_id');
                // var class_id = {!! $request->class_id !!};
                var selectClassOptionAdded = false; // Flag to track if the "Select Class" option is added
                var termDropdown = $('#semester_id');
                var selectTermOptionAdded = false;
                // Clear existing options
                classDropdown.empty();
                termDropdown.empty();

                // Add options based on the selected radio button
                if (isSemester) {
                    $('#label').html('Semester');
                    @foreach ($classesSemester as $class)
                        // Add the "Select Class" option only if it has not been added yet
                        if (!selectClassOptionAdded) {
                            classDropdown.append('<option value="" selected>Select Class</option>');
                            selectClassOptionAdded = true; // Set the flag to true once the option is added
                        }
                        classDropdown.append(
                            `<option value="{{ $class->class_id }}" {{ $class->class_id == $request->class_id ? 'selected' : '' }}>{{ $class->class_name }}</option>`
                        );
                    @endforeach
                    @foreach ($semesters as $item)
                        // Add the "Select Semester" option only if it has not been added yet
                        if (!selectTermOptionAdded) {
                            termDropdown.append('<option value="" selected>Select Semester</option>');
                            selectTermOptionAdded = true; // Set the flag to true once the option is added
                        }
                        termDropdown.append(
                            `<option value="{{ $item->semester_id }}" {{ $item->semester_id == $request->semester_id ? 'selected' : '' }}>{{ $item->semester_name }}</option>`
                            );
                    @endforeach
                    $('.semester-div').show();
                } else {
                    @foreach ($classesAnnual as $class)
                        // Add the "Select Class" option only if it has not been added yet
                        if (!selectClassOptionAdded) {
                            classDropdown.append('<option value="" selected>Select Class</option>');
                            selectClassOptionAdded = true; // Set the flag to true once the option is added
                        }
                        classDropdown.append(
                            `<option value="{{ $class->class_id }}" {{ $class->class_id == $request->class_id ? 'selected' : '' }}>{{ $class->class_name }}</option>`
                        );
                    @endforeach
                    @foreach ($annuals as $item)
                        // Add the "Select Semester" option only if it has not been added yet
                        if (!selectTermOptionAdded) {
                            termDropdown.append('<option value="" selected>Select Annual</option>');
                            selectTermOptionAdded = true; // Set the flag to true once the option is added
                        }
                        termDropdown.append(
                            `<option value="{{ $item->semester_id }}"{{ $item->semester_id == $request->semester_id ? 'selected' : '' }}>{{ $item->semester_name }}</option>`
                            );
                    @endforeach
                    $('.semester-div').show();

                }
            }


            // Call the function on page load and whenever the radio buttons are changed
            $('input[type="radio"].annual, input[type="radio"].semester').on('change',
                updateClassOptions);
            updateClassOptions(); // Call on page load to initialize the Class dropdown options
        });
    </script>




    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let class_id = document.getElementById("class_id"),
                section_id = document.getElementById("section_id"),
                group_names = document.getElementById("group_names"),
                subject = document.getElementById("subject"),
                validateInputIdArray = [
                    class_id.id,
                    section_id.id,
                    group_names.id,
                    subject.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check) {
                let discipline = document.getElementById('semester');
                if (discipline.checked == true) {
                    // let stock_status = document.getElementById("stock_status");
                    // //    let stock_status = document.getElementById("stock_status");
                    // if (stock_status.checked == false) {
                    let semester_id = document.getElementById("semester_id"),

                        validateInputIdArray = [
                            semester_id.id,

                        ];
                    return validateInventoryInputs(validateInputIdArray);

                    // }
                }


            }
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        $(document).ready(function() {
            $('#class_id').select2();
            $('#subject').select2();
            $('#section_id').select2();
            $('#group_names').select2();
            $('#semester_id').select2();
            get_section({!! $request->class_id !!});
        });

        function get_section(class_id) {
            var section_id = {!! $request->section_id !!}

            $.ajax({
                url: '/get_groups',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function(data) {
                    console.log(data);
                    var sections = '<option selected disabled hidden>Choose Section</option>';
                    $.each(data.section, function(index, items) {

                        sections +=
                            `<option value="${items.cs_id}" ${items.cs_id == section_id ? 'selected' : ''  }> ${items.cs_name} </option>`;

                    });

                    $('#section_id').html(sections);
                }
            });
        }
        $('#class_id').change(function() {
            var class_id = $(this).val();
            get_section(class_id)
        });
    </script>
@endsection
