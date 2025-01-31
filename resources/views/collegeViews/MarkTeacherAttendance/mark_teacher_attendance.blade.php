@extends('extend_index')

@section('content')
    <div class="row">
        {{--            edit it --}}
        <div id="main_bg" class="container-fluid search-filter form-group form_manage">
            {{--                form header --}}
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Teacher Attendance</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <a class="add_btn list_link add_more_button" href="{{ route('lecturer_attendance_list') }}"
                            role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            {{--                invoice container --}}
            <button onclick="openForm('form1')" class="btn btn-sm btn-success">Class Wise</button>
            <button onclick="openForm('form2')" class="btn btn-sm btn-success">Time Wise</button>
            <div id="invoice_con">
                <!-- invoice container start -->
                <div id="form1Container" style="display: none;">
                    <form name="f1" class="f1" id="f1" action="{{ route('submit_lecturer_attendance') }}"
                        method="post">
                        @csrf
                        <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx">

                            <div class="row">
                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx">
                                        <label class="required">
                                            Date
                                        </label>
                                        <input tabindex="1" type="text" name="la_date" id="la_date"
                                            class="inputs_up form-control datepicker1" placeholder="Please Date"
                                            data-rule-required="true" data-msg-required="Please Date" autocomplete="off"
                                            value="{{ old('la_date') }}" />
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            Class
                                        </label>
                                        <select tabindex="1" autofocus name="class_id"
                                            class="inputs_up form-control required" id="class_id" autofocus
                                            data-rule-required="true" data-msg-required="Please Enter Class">
                                            <option value="" selected disabled>Select Class</option>
                                            @foreach ($allclasses as $allclass)
                                                @php
                                                    // $sections = explode(',', $data->class_id);
                                                @endphp
                                                <option value="{{ $allclass->class_id }}">
                                                    {{ $allclass->class_name }}
                                                </option>
                                            @endforeach
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
                                        <select tabindex="1" autofocus name="section_id"
                                            class="inputs_up form-control required" id="section_id" autofocus
                                            data-rule-required="true" data-msg-required="Please Enter Section">
                                            {{-- <option value=""selected>Select Section</option> --}}
                                            {{-- @foreach ($allsections as $allsection)
                                        @php
                                        // $sections = explode(',', $data->section_id);
                                    @endphp
                                            <option value="{{ $allsection->cs_id }}">
                                                {{ $allsection->cs_name }}
                                            </option>
                                        @endforeach --}}
                                        </select>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            Semester
                                        </label>
                                        <select tabindex="1" autofocus name="semester_id"
                                            class="inputs_up form-control required" id="semester_id" autofocus
                                            data-rule-required="true" data-msg-required="Please Enter semester">
                                            {{-- <option value=""selected>Select Section</option> --}}
                                            {{-- @foreach ($allsections as $allsection)
                                        @php
                                        // $sections = explode(',', $data->section_id);
                                    @endphp
                                            <option value="{{ $allsection->cs_id }}">
                                                {{ $allsection->cs_name }}
                                            </option>
                                        @endforeach --}}
                                        </select>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            Teacher
                                        </label>
                                        <select tabindex="1" autofocus name="teacher_id"
                                            class="inputs_up form-control required" id="teacher_id" autofocus
                                            data-rule-required="true" data-msg-required="Please Enter Teacher">
                                            {{-- <option value="">Select Section</option>
                                        @foreach ($allsections as $allsection)
                                            <option value="{{ $allsection->cs_id }}">
                                                {{ $allsection->cs_name }}
                                            </option>
                                        @endforeach --}}
                                        </select>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            Subject
                                        </label>
                                        <select tabindex="1" autofocus name="subject_id"
                                            class="inputs_up form-control required" id="subject_id" autofocus
                                            data-rule-required="true" data-msg-required="Please Enter Subject">
                                            {{-- <option value="">Select Section</option>
                                        @foreach ($allsections as $allsection)
                                            <option value="{{ $allsection->cs_id }}">
                                                {{ $allsection->cs_name }}
                                            </option>
                                        @endforeach --}}

                                        </select>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3 col-md-3 col-sm-12 d-none">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            Start Time
                                        </label>
                                        <input tabindex="1" type="text" name="start_time" id="start_time"
                                            class="inputs_up form-control" placeholder="Please Enter Start Time" autofocus
                                            data-rule-required="true" data-msg-required="Please Enter Start Time"
                                            autocomplete="off" value="{{ old('start_time') }}" readonly />
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            Attendance
                                        </label>
                                        <div class="custom-control custom-radio mb-10 mt-1">
                                            <input tabindex="12" type="radio" name="lec_attendance"
                                                class="custom-control-input lec_attendance" id="present" value="P"
                                                {{ old('lec_attendance') == 'P' ? 'checked' : '' }} checked>
                                            <label class="custom-control-label" for="present">
                                                Present
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-10 mt-1">
                                            <input tabindex="13" type="radio" name="lec_attendance"
                                                class="custom-control-input lec_attendance" id="absent"
                                                value="A"{{ old('lec_attendance') == 'A' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="absent">
                                                Absent
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-10 mt-1">
                                            <input tabindex="14" type="radio" name="lec_attendance"
                                                class="custom-control-input lec_attendance" id="leave"
                                                value="L"{{ old('lec_attendance') == 'L' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="leave">
                                                Leave
                                            </label>
                                        </div>
                                        @if ($branch_id == 6)
                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                <input tabindex="14" type="radio" name="lec_attendance"
                                                    class="custom-control-input lec_attendance" id="shor_leave"
                                                    value="S.L"{{ old('lec_attendance') == 'S.L' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="shor_leave">
                                                    Short Leave
                                                </label>
                                            </div>
                                        @endif
                                        <span id="lec_attendance_error_msg" class="validate_sign"> </span>

                                    </div><!-- end input box -->

                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx" id="leaveRemarksDiv" style="display: none;">
                                        <!-- start input box -->
                                        <label class="required">
                                            Leave Remarks
                                        </label>
                                        <input tabindex="1" type="text" name="leave_remarks" id="leave_remarks"
                                            class="inputs_up form-control" placeholder="Leave Remarks" autofocus
                                            data-rule-required="true" data-msg-required="Please Enter Leave Remarks"
                                            autocomplete="off" value="{{ old('leave_remarks') }}" />
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <button tabindex="1" type="submit" name="save" id="save"
                            class="save_button btn btn-sm btn-success"> Save
                        </button>
                    </form>
                </div>
                <div id="form2Container" style="display: none;">
                    <form name="f2" class="f1" id="f2"
                        action="{{ route('submit_lecturer_attendance_time') }}" method="post">
                        @csrf
                        <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx">

                            <div class="row">
                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx">
                                        <label class="required">
                                            Date
                                        </label>
                                        <input tabindex="1" type="text" name="lat_date" id="lat_date"
                                            class="inputs_up form-control datepicker1" placeholder="Please Date"
                                            data-rule-required="true" data-msg-required="Please Date" autocomplete="off"
                                            value="{{ old('lat_date') }}" />
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div>
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            Teacher
                                        </label>
                                        <select tabindex="1" autofocus name="t_teachers_id"
                                            class="inputs_up form-control required" id="t_teachers_id" autofocus
                                            data-rule-required="true" data-msg-required="Please Enter Teacher">
                                            {{-- <option value="">Select Section</option>
                                        @foreach ($allsections as $allsection)
                                            <option value="{{ $allsection->cs_id }}">
                                                {{ $allsection->cs_name }}
                                            </option>
                                        @endforeach --}}
                                        </select>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Table start -->
                            <div class="pro_tbl_con">
                                <div class="table-responsive" id="printTable">
                                    <table class="table table-bordered table-sm mt-3" id="category_dynamic_table">
                                        <!-- product table box start -->

                                        <thead>
                                            <tr>
                                                <th class="text-center tbl_txt_2">Sr#</th>
                                                <th class="text-center tbl_txt_10">Class Name</th>
                                                <th class="text-center tbl_txt_4">Section Name</th>
                                                <th class="text-center tbl_txt_8">Semester Nmae</th>
                                                <th class="text-center tbl_txt_15">Teacher Name</th>
                                                <th class="text-center tbl_txt_10">Subject Name</th>
                                                <th class="text-center tbl_txt_25">Lectures Time</th>
                                                <th class="text-center tbl_txt_2">P</th>
                                                <th class="text-center tbl_txt_2">A</th>
                                                <th class="text-center tbl_txt_2">L</th>
                                                <th class="text-center tbl_txt_2">M</th>
                                                <th class="text-center tbl_txt_2">S.L</th>
                                                <th class="text-center tbl_txt_16">Leave Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <button tabindex="1" type="submit" name="save1" id="save1"
                            class="save_button btn btn-sm btn-success"> Save
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function openForm(formId) {
            // Hide all forms initially
            document.querySelectorAll('[id^="form"]').forEach(function(form) {
                form.style.display = 'none';
            });

            // Show the selected form
            document.getElementById(formId + 'Container').style.display = 'block';
        }

        function checkForm(formId) {
            console.log(formId);
            let form = document.getElementById(formId);
            let inputs = form.querySelectorAll('input, select');
            let la_date = document.getElementById(formId).querySelector("#la_date");
            let class_id = document.getElementById(formId).querySelector("#class_id");
            let section_id = document.getElementById(formId).querySelector("#section_id");
            let semester_id = document.getElementById(formId).querySelector("#semester_id");
            let teacher_id = document.getElementById(formId).querySelector("#teacher_id");
            let subject_id = document.getElementById(formId).querySelector("#subject_id");
            let start_time = document.getElementById(formId).querySelector("#start_time");
            let lec_attendance = document.getElementById(formId).querySelectorAll("[name='lec_attendance']");
            let leaveRemarksInput = document.getElementById(formId).querySelector("#leave_remarks");

            let validateInputIdArray = [
                la_date.id,
                class_id.id,
                section_id.id,
                semester_id.id,
                teacher_id.id,
                subject_id.id,
                start_time.id,
            ];

            // Loop through the lec_attendance radio buttons to check if "Leave" is selected
            for (let i = 0; i < lec_attendance.length; i++) {
                if (lec_attendance[i].checked && lec_attendance[i].value === "L") {
                    // Checkbox is checked, so we validate the leave_remarks
                    validateInputIdArray.push(leaveRemarksInput.id);
                    break; // Exit the loop since we found "Leave" selected
                }
            }

            let check = validateInventoryInputs(validateInputIdArray);

            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }

            return check;
        }

        function checkFormt(formId) {
            console.log(formId);
            let form = document.getElementById(formId);
            let inputs = form.querySelectorAll('input, select');
            let lat_date = document.getElementById(formId).querySelector("#lat_date");
            let t_teacher_id = document.getElementById(formId).querySelector("#t_teachers_id");

            let validateInputIdArray = [
                lat_date.id,
                t_teacher_id.id,
            ];

            // // Loop through the lec_attendance radio buttons to check if "Leave" is selected
            // for (let i = 0; i < lec_attendance.length; i++) {
            //     if (lec_attendance[i].checked && lec_attendance[i].value === "L") {
            //         // Checkbox is checked, so we validate the leave_remarks
            //         validateInputIdArray.push(leaveRemarksInput.id);
            //         break; // Exit the loop since we found "Leave" selected
            //     }
            // }

            let check = validateInventoryInputs(validateInputIdArray);

            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }

            return check;
        }

        // Add event listener for form submissions
        document.getElementById('f1').addEventListener('submit', function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Get the ID of the form being submitted
            let formId = this.getAttribute('id');

            // Validate the form
            let isValid = checkForm(formId);

            // If form is valid, submit it
            if (isValid) {
                this.submit();
            } else {
                // Form is not valid, handle accordingly (show error messages, etc.)
            }
        });

        // Add event listener for form submissions
        document.getElementById('f2').addEventListener('submit', function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Get the ID of the form being submitted
            let formId = this.getAttribute('id');
            console.log(formId);
            // Validate the form
            let isValid = checkFormt(formId);

            // If form is valid, submit it
            if (isValid) {
                this.submit();
            } else {
                // Form is not valid, handle accordingly (show error messages, etc.)
            }
        });
    </script>


    {{-- end of required input validation --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.4/dayjs.min.js"
        integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>

    <script src="{{ asset('public/js/timepicker-bs4.js') }}" defer="defer"></script>

    <script type="text/javascript">
        var selectedClassId;
        var selectedSectionId;
        var selectedTeacherId;
        var dates;
        let initialDateValue = $('#lat_date').val();
        let debounceTimer;

        $('#lat_date').focusout(function() {
            var selectedDate = $(this).val();

            // Check if the value has changed from the initial value
            if (selectedDate !== initialDateValue) {
                console.log("Selected date:", selectedDate);
                initialDateValue = selectedDate; // Update the initial value

                // Clear the previous debounce timer
                clearTimeout(debounceTimer);

                // Set a new debounce timer
                debounceTimer = setTimeout(function() {
                    // Add your AJAX request here
                    jQuery(".pre-loader").fadeToggle("medium");
                    $.ajax({
                        // to get all the teacher in the current day
                        url: '/get_current_teacher',
                        type: 'get',
                        datatype: 'text',
                        data: {
                            'selectedDate': selectedDate
                        },
                        success: function(data) {
                            console.log(data);
                            var teachers =
                                '<option value="" selected disabled>Choose Teacher</option>';
                            $.each(data, function(index, items) {
                                teachers +=
                                    `<option value="${items.teacher_id}"> ${items.teacher_name} </option>`;
                            });
                            $('#t_teachers_id').html(teachers);

                            // Store the selected dates in a variable
                            dates = selectedDate;
                        }
                    });
                jQuery(".pre-loader").fadeToggle("medium");
                }, 300); // Adjust the delay as needed
            }
        });
        $('#t_teachers_id').change(function() {
            var teachers_id = $(this).val();
            var date = dates;
            console.log(teachers_id, date);


            jQuery(".pre-loader").fadeToggle("medium");
            $.ajax({
                // get all time from timetable for each teacher
                url: '/get_teachers_all_time',
                type: 'get',
                datatype: 'json', // Change datatype to 'json'
                data: {
                    'teachers_id': teachers_id,
                    'date': date,
                },
                success: function(data) {

                    console.log(data)
                    // if (data.attendance == 0) {
                        var sr = 1;
                        var selectBoxHTML = '';
                        $.each(data, function(index, item) {
                            selectBoxHTML += `<tr>
                        <td>${ sr++ } </td>
                        <td><input type="hidden"
                        name="class_id[]" id="class_id" value="${item.class_id}">${ item.class_name }
                        </td>
                        <td><input type="hidden"
                        name="section_id[]" id="section_id" value="${item.section_id}">${ item.section_name }
                        </td>
                        <td><input type="hidden"
                        name="semester_id[]" id="semester_id" value="${item.semester_id}">${ item.semester_name }
                        </td>
                        <td><input type="hidden"
                        name="teacher_id[]" id="teacher_id" value="${item.teacher_id}">${ item.teacher_name }
                        </td>
                        <td><input type="hidden"
                        name="subject_id[]" id="subject_id" value="${item.subject_id}">${ item.subject_name }
                        </td>
                        <td><input type="hidden"
                        name="time[]" id="time" value="${item.start_time}">"Start Time" ${ item.start_time } ---"End Time" ${ item.end_time }
                        </td>
                        <td><input type="radio" name="attendance[${index}]" id="P" value="P"
                        checked> </td>
                        <td><input type="radio"
                        name="attendance[${index}]" id="A" value="A">
                        </td>
                        <td><input type="radio"
                        name="attendance[${index}]" id="L" value="L">
                        </td>
                        <td><input type="radio"
                        name="attendance[${index}]" id="M" value="M">
                        </td>
                        <td><input type="radio"
                        name="attendance[${index}]" id="S.L" value="S.L">
                        </td>
                        <td><input type="text" name="leave_remarks[]"
                        style="width:100%"></td>
                    </tr>`;
                        });
                        $('#table_body').html(selectBoxHTML);
                    // } else {
                    //     Swal.fire({
                    //         icon: 'error',
                    //         title: 'Attendance of this Department  for this date  is already Marked!',
                    //         // text: 'Attendance of this Department  for this date  is already Marked!',
                    //         timer: 5000
                    //     })

                    // }
                }
            });
            jQuery(".pre-loader").fadeToggle("medium");
        });


        // });
        $('#class_id').change(function() {
            var class_id = $(this).children('option:selected').val();
            // console.log(class_id);
            $.ajax({
                url: '/get_coordinator_section',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function(data) {
                    console.log(data);
                    var sections = '<option value="" selected disabled>Choose Section</option>';
                    $.each(data, function(index, items) {
                        sections +=
                            `<option value="${items.cs_id}"> ${items.cs_name} </option>`;
                    });
                    $('#section_id').html(sections);

                    // Store the selected class_id in a variable
                    selectedClassId = class_id;

                    // Trigger the teacher_id change event to fetch subjects
                    $('#section_id').val('').change(); // Clear and trigger change
                }
            });
        });
        $('#section_id').change(function() {
            var section_id = $(this).children('option:selected').val();
            console.log(section_id);
            var class_id = selectedClassId;
            console.log(class_id);
            $.ajax({
                url: '/get_semester',
                type: 'get',
                datatype: 'text',
                data: {
                    'section_id': section_id,
                    'class_id': class_id
                },
                success: function(data) {
                    console.log(data);
                    var semester = '<option value="" selected disabled>Choose Semester</option>';
                    $.each(data, function(index, items) {
                        semester +=
                            `<option value="${items.semester_id}"> ${items.semester_name} </option>`;
                    });
                    $('#semester_id').html(semester);

                    // Store the selected section_id in a variable
                    selectedSectionId = section_id;

                    // Trigger the semester_id change event to fetch subjects
                    $('#semester_id').val('').change(); // Clear and trigger change
                }
            });
        });
        $('#semester_id').change(function() {
            var semester_id = $(this).children('option:selected').val();
            var date = $('#la_date').val();
            var section_id = selectedSectionId;
            console.log(section_id, date);
            var class_id = selectedClassId;
            console.log(class_id);
            $.ajax({
                url: '/get_teacher',
                type: 'get',
                datatype: 'text',
                data: {
                    'semester_id': semester_id,
                    'date': date,
                    'section_id': section_id,
                    'class_id': class_id
                },
                success: function(data) {
                    console.log(data);
                    var teachers = '<option value="" selected disabled>Choose teachers</option>';
                    $.each(data, function(index, items) {
                        teachers +=
                            `<option value="${items.teacher_id}"> ${items.teacher_name} </option>`;
                    });
                    $('#teacher_id').html(teachers);

                    // Store the selected semester_id in a variable
                    selectedSemester_idId = semester_id;

                    // Trigger the teacher_id change event to fetch subjects
                    $('#teacher_id').val('').change(); // Clear and trigger change
                }
            });
        });

        $('#teacher_id').change(function() {
            var teacher_id = $(this).children('option:selected').val();
            var date = $('#la_date').val();
            console.log(teacher_id, date);

            // Get the selected section_id from the previously stored variable
            var section_id = selectedSectionId;
            var semester_id = selectedSemester_idId;

            $.ajax({
                url: '/get_teacher_subject',
                type: 'get',
                datatype: 'text',
                data: {
                    'semester_id': semester_id,
                    'date': date,
                    'teacher_id': teacher_id,
                    'section_id': section_id // Include section_id in the data
                },
                success: function(data) {
                    console.log(data);
                    var subject = '<option value="" selected disabled>Choose Subjects</option>';
                    $.each(data.subjects, function(index, items) {
                        subject +=
                            `<option value="${items.subject_id}"> ${items.subject_name} </option>`;
                    });
                    $('#subject_id').html(subject);

                    // Store the selected teacher_id in a variable
                    selectedTeacherId = teacher_id;

                    // Trigger the teacher_id change event to fetch subjects
                    $('#subject_id').val('').change(); // Clear and trigger change
                }
            });
        });
        $('#subject_id').change(function() {
            var subject_id = $(this).children('option:selected').val();
            var date = $('#la_date').val();
            console.log(subject_id, date);

            // Get the selected teacher_id from the previously stored variable
            var section_id = selectedSectionId;
            var teacher_id = selectedTeacherId;
            var semester_id = selectedSemester_idId;

            $.ajax({
                url: '/get_subject_time',
                type: 'get',
                datatype: 'text',
                data: {
                    'semester_id': semester_id,
                    'subject_id': subject_id,
                    'date': date,
                    'teacher_id': teacher_id,
                    'section_id': section_id // Include section_id in the data
                },
                success: function(data) {
                    console.log(data);
                    // console.log(data.start_time[0].start_time);
                    var startTime = data.start_time[0].start_time;

                    // Set the value of the start_time input field
                    $('#start_time').val(startTime);
                    // }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                // Function to toggle the "Leave Remarks" div based on the "Leave" radio button state
                function toggleLeaveRemarks() {
                    var leaveRemarksDiv = $('#leaveRemarksDiv');
                    var leaveRadio = $('#leave');

                    if (leaveRadio.prop('checked')) {
                        // "Leave" radio button is checked, show the "Leave Remarks" div
                        leaveRemarksDiv.css('display', 'block');
                    } else {
                        // Any other radio button is checked, hide the "Leave Remarks" div
                        leaveRemarksDiv.css('display', 'none');
                    }
                }

                toggleLeaveRemarks(); // Call the function when the document is ready

                // Attach the function to the change event of all radio buttons in the same group
                $('.lec_attendance').change(toggleLeaveRemarks);
            });
        });
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#class_id').select2();
            $('#section_id').select2();
            $('#teacher_id').select2();
            $('#subject_id').select2();
            $('#semester_id').select2();
            $('#t_teachers_id').select2();
            // start time picker script
            $('.timepicker-input').timepicker();
            // end time picker script
        });
    </script>
@endsection
