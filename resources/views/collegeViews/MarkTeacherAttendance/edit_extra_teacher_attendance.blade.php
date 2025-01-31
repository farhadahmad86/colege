@extends('extend_index')

@section('content')
    <form name="f1" class="f1" id="f1" action="{{ route('update_extra_lecturer_attendance') }}" method="post"
        onsubmit="return checkForm()">
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
                <div id="invoice_con">
                    <!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="required">
                                        Section
                                    </label>
                                    <select tabindex="1" autofocus name="section_id"
                                        class="inputs_up form-control required" id="section_id" autofocus
                                        data-rule-required="true" data-msg-required="Please Enter Section">
                                        <option value="">Select Section</option>
                                        {{-- @foreach ($allsections as $allsections) --}}
                                        <option value="{{ $allsections->cs_id }}" selected>
                                            {{ $allsections->cs_name }}
                                        </option>
                                        {{-- @endforeach --}}

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
                                        <option value="">Select Teacher</option>
                                        {{-- @foreach ($allsections as $allteachers) --}}
                                        <option value="{{ $allteachers->user_id }}" selected>
                                            {{ $allteachers->user_name }}
                                        </option>
                                        {{-- @endforeach --}}
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
                                        <option value="">Select Subject</option>
                                        {{-- @foreach ($allsections as $allsubjects) --}}
                                        <option value="{{ $allsubjects->subject_id }}" selected>
                                            {{ $allsubjects->subject_name }}
                                        </option>
                                        {{-- @endforeach --}}

                                    </select>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="required">
                                        Start Time
                                    </label>
                                    <input tabindex="1" type="text" name="start_time" id="start_time"
                                        class="inputs_up form-control" placeholder="Please Enter Start Time" autofocus
                                        data-rule-required="true" data-msg-required="Please Enter Start Time"
                                        autocomplete="off" value="{{ $attendance->la_start_time }}" readonly />
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
                                            {{ $attendance->la_attendance == 'P' ? 'checked' : '' }} checked>
                                        <label class="custom-control-label" for="present">
                                            Present
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio mb-10 mt-1">
                                        <input tabindex="13" type="radio" name="lec_attendance"
                                            class="custom-control-input lec_attendance" id="absent"
                                            value="A"{{ $attendance->la_attendance == 'A' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="absent">
                                            Absent
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio mb-10 mt-1">
                                        <input tabindex="14" type="radio" name="lec_attendance"
                                            class="custom-control-input lec_attendance" id="leave"
                                            value="L"{{ $attendance->la_attendance == 'L' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="leave">
                                            Leave
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio mb-10 mt-1">
                                        <input tabindex="14" type="radio" name="lec_attendance"
                                            class="custom-control-input lec_attendance" id="leave"
                                            value="S.L"{{ $attendance->la_attendance == 'S.L' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="leave">
                                            Short Leave
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio mb-10 mt-1">
                                        <input tabindex="14" type="radio" name="lec_attendance"
                                            class="custom-control-input lec_attendance" id="leave"
                                            value="M"{{ $attendance->la_attendance == 'M' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="leave">
                                            Merge
                                        </label>
                                    </div>
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
                                        autocomplete="off" value="{{ $attendance->la_leave_remarks }}" />
                                    <span id="demo1" class="validate_sign"> </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" name="la_id" value="{{$attendance->la_id}}">
                <button tabindex="1" type="submit" name="save" id="save"
                    class="save_button btn btn-sm btn-success"> Save
                </button>
            </div>

        </div>
    </form><!-- row end -->
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.4/dayjs.min.js"
        integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>

    <script src="{{ asset('public/js/timepicker-bs4.js') }}" defer="defer"></script>
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let section_id = document.getElementById("section_id");
            let teacher_id = document.getElementById("teacher_id");
            let subject_id = document.getElementById("subject_id");
            let start_time = document.getElementById("start_time");
            let lec_attendance = document.getElementsByName("lec_attendance");
            let leaveRemarksInput = document.getElementById("leave_remarks");

            let validateInputIdArray = [
                section_id.id,
                teacher_id.id,
                subject_id.id,
                start_time.id,
            ];

            // Loop through the lec_attendance radio buttons to check if "Leave" is selected
            for (let i = 0; i < lec_attendance.length; i++) {
                if (lec_attendance[i].checked && lec_attendance[i].value === "L") {
                    // Checkbox is checked, so we validate the leave_remarks
                    validateInputIdArray.push(leave_remarks.id);
                    break; // Exit the loop since we found "Leave" selected
                }
            }


            let check = validateInventoryInputs(validateInputIdArray);

            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }

            return check;
        }
    </script>

    {{-- end of required input validation --}}
    {{-- <script type="text/javascript">
        var selectedSectionId;
        var selectedTeacherId;
        $('#section_id').change(function() {
            var section_id = $(this).children('option:selected').val();
            console.log(section_id);
            $.ajax({
                url: '/get_teacher',
                type: 'get',
                datatype: 'text',
                data: {
                    'section_id': section_id
                },
                success: function(data) {
                    console.log(data);
                    var teachers = '<option value="" selected disabled>Choose teachers</option>';
                    $.each(data, function(index, items) {
                        teachers +=
                            `<option value="${items.teacher_id}"> ${items.teacher_name} </option>`;
                    });
                    $('#teacher_id').html(teachers);

                    // Store the selected section_id in a variable
                    selectedSectionId = section_id;

                    // Trigger the teacher_id change event to fetch subjects
                    $('#teacher_id').val('').change(); // Clear and trigger change
                }
            });
        });

        $('#teacher_id').change(function() {
            var teacher_id = $(this).children('option:selected').val();
            console.log(teacher_id);

            // Get the selected section_id from the previously stored variable
            var section_id = selectedSectionId;

            $.ajax({
                url: '/get_teacher_subject',
                type: 'get',
                datatype: 'text',
                data: {
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
            console.log(subject_id);

            // Get the selected teacher_id from the previously stored variable
            var section_id = selectedSectionId;
            var teacher_id = selectedTeacherId;

            $.ajax({
                url: '/get_subject_time',
                type: 'get',
                datatype: 'text',
                data: {
                    'subject_id': subject_id,
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
    </script> --}}
    <script>
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
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#section_id').select2();
            $('#teacher_id').select2();
            $('#subject_id').select2();
            // start time picker script
            $('.timepicker-input').timepicker();
            // end time picker script
        });
    </script>
@endsection
