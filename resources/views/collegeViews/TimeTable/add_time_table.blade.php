@extends('extend_index')

@section('content')
    <style>
        .popover-body {
            background-color: white !important;
        }

        .style_table,
        td,
        th {
            border: 2px solid black !important;
        }

        .style_table {
            border-collapse: collapse !important;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"
            integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w=="
            crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    <form name="f1" class="f1" id="f1" action="{{ route('store_time_table') }}" method="post"
          onsubmit="return checkForm()">
        <div class="row">
            <div id="main_bg" class="container-fluid search-filter form-group form_manage">
                <div class="form_header">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Time Table</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <a class="add_btn list_link add_more_button" href="{{ route('time_table_list') }}"
                               role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div>
                    </div>
                </div>
                <div id="invoice_con">
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <label class="required">
                                        Starting Day
                                    </label>
                                    <select class="form-control form-control-sm" name="starting_days" id="starting_days"
                                            data-rule-required="true" data-msg-required="Please Enter Start Day">
                                        <option value="" selected>Select Start Day</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                        <option value="Sunday">Sunday</option>
                                    </select>
                                    <span id="role_error_msg" class="validate_sign"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <label class="required">
                                        Class</label>
                                    <select class="form-control form-control-sm" name="class_id" id="class_id"
                                            data-rule-required="true" data-msg-required="Please Enter Class">
                                        <option value="" selected>Select Class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->class_id }}">
                                                {{ $class->class_name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="role_error_msg" class="validate_sign"> </span>
                                    <span id="class_day_error_msg"
                                          style="color: red; display: none; margin-top: 5px;"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <label class="required">
                                        Section
                                    </label>
                                    <select tabindex="1" autofocus name="section_id" class="form-control required"
                                            id="section_id" autofocus data-rule-required="true"
                                            data-msg-required="Please Enter Section">
                                    </select>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <label class="required">
                                        Annual/Semester
                                    </label>
                                    <select tabindex="1" autofocus name="semester_id" class="form-control required"
                                            id="semester_id" autofocus data-rule-required="true"
                                            data-msg-required="Please Enter..">
                                    </select>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <label class="required">
                                        With Effected From
                                    </label>
                                    <input tabindex="1" type="text" name="wef" id="wef"
                                           class="inputs_up form-control datepicker1" placeholder="Please Enter w.e.f"
                                           autofocus data-rule-required="true" data-msg-required="Please Enter w.e.f"
                                           autocomplete="off" value="{{ old('wef') }}"/>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <label class="">
                                        Break Start Time
                                    </label>
                                    <input tabindex="1" type="text" name="break_start_time" id="break_start_time"
                                           class="inputs_up form-control timepicker-input"
                                           placeholder="Please Enter Break Start Time" autofocus
                                           data-rule-required="true"
                                           data-msg-required="Please Enter Break Start Time" autocomplete="off"
                                           value="{{ old('break_start_time') }}"/>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <label class="">
                                        Break End Time
                                    </label>
                                    <input tabindex="1" type="text" name="break_end_time" id="break_end_time"
                                           class="inputs_up form-control timepicker-input"
                                           placeholder="Please Enter Break End Time" autofocus data-rule-required="true"
                                           data-msg-required="Please Enter Break End Time" autocomplete="off"
                                           value="{{ old('break_end_time') }}"/>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <label class="required">
                                        Semester Start Date
                                    </label>
                                    <input tabindex="1" type="text" name="semester_start_date" id="semester_start_date"
                                           class="inputs_up form-control datepicker1" placeholder="Please Enter Semester Start Date"
                                           autofocus data-rule-required="true" data-msg-required="Please Enter Semester Start Date"
                                           autocomplete="off" value="{{ old('semester_start_date') }}"/>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <label class="required">
                                        Number of Days
                                    </label>
                                    <input tabindex="1" type="number" name="num_of_days" id="num_of_days"
                                           class="inputs_up form-control" placeholder="Enter Number of Days" min="1"
                                           data-rule-required="true" data-msg-required="Please Enter Number of Days"/>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table start -->
                <div class="pro_tbl_con">
                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm style_table" id="category_dynamic_table">
                            <tbody id="table_body">
                            </tbody>
                        </table>
                    </div>
                    <button tabindex="1" type="submit" name="save" id="save"
                            class="save_button btn btn-sm btn-success"> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.4/dayjs.min.js"
            integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>

    <script src="{{ asset('public/js/timepicker-bs4.js') }}" defer="defer"></script>

    <script>
        var i = 1;


        $('.select2').select2();
        var count = 0;


        function disable_pro(value) {
            $('#class_id option[value=' + value + ']').attr('disabled', 'disabled');
        }

        $(document).ready(function () {
            // Initially hide the class_day_error_msg span
            $('#class_day_error_msg').hide();

            // Starting Days dropdown change event
            $('#starting_days').change(function () {
                var startingDay = $(this).val();
                if (startingDay) {
                    $('#class_day_error_msg').hide(); // Hide error message if starting day is selected
                } else {
                    // Reset the class_id select box to its default option
                    $('#class_id').val(null).trigger('change'); // Reset Select2
                    $('#class_day_error_msg').show().text('Please select a starting day first.'); // Show error message if starting day is not selected
                }
            });
        });
        $('#class_id').change(function () {
            var startingDay = $('#starting_days').val();
            if (!startingDay) {
                $('#class_day_error_msg').show().text('Please select a starting day first.'); // Show error message
                jQuery("#class_id").select2("destroy");
                jQuery('#class_id option[value="' + "" + '"]').prop('selected', true);
                jQuery("#class_id").select2();
                return; // Exit if starting day is not selected
            }
            var class_id = $(this).children('option:selected').val();
            $.ajax({
                url: '/get_coordinator_section',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function (data) {
                    console.log(data);
                    var sections = '<option value="" selected>Choose Section</option>';
                    $.each(data.section, function (index, items) {

                        sections +=
                            `<option value="${items.cs_id}"> ${items.cs_name} </option>`;


                    });
                    var semesters = '<option value="" selected>Select</option>';
                    $.each(data.semesters, function (index, items) {

                        semesters +=
                            `<option value="${items.semester_id}"> ${items.semester_name} </option>`;


                    });
                    $('#section_id').html(sections);
                    $('#semester_id').html(semesters);
                }
            })
        });


        $('#semester_id').change(function () {
            var semester_id = $(this).children('option:selected').val();
            var class_id = $('#class_id').val();
            var section_id = $('#section_id').val();

            $.ajax({
                url: '/get_subjects',
                type: 'get',
                datatype: 'text',
                data: {
                    'semester_id': semester_id,
                    'class_id': class_id,
                    'section_id': section_id,
                },
                success: function (data) {
                    var selectBoxHTML = '';
                    var daysOfWeek = $('#starting_days').val();
                    var hidee = '';
                    for (var i = 0; i < 7; i++) {
                        if (i > 0) {
                            hidee = 'hidden';
                        }
                        selectBoxHTML += `<tr ${hidee}>`;
                        selectBoxHTML +=
                            `<td><input type="hidden" name="day[]" value="${daysOfWeek}" id="day${i}" readonly>${daysOfWeek}</td>`;
                        $.each(data, function (index, item) {
                            selectBoxHTML +=
                                `<td>
                            <label class="required">Subject</label>
                            <select tabindex="1" name="subject_id[${i}][${index}]" class="form-control subjects" id="subject_id${i}_${index}" data-index="${index}" data-i="${i}">
                                <option value="" selected>Choose Subject</option>
                                ${data.map(option => `<option value="${option.subject_id}">${option.subject_name}</option>`).join('')}
                            </select>

                            <label class="required">Teacher</label>
                            <select tabindex="1" name="teacher_id[${i}][${index}]" class="form-control teachers" id="teacher_id${i}_${index}">
                            </select>

                            <label class="required">Start Time</label>
                            <input type="text" id="start_time${i}_${index}" class="form-control inputs_up timepicker-input" name="start_time[${i}][${index}]" autocomplete="off" placeholder="Start Time"/>

                            <label class="required">End Time</label>
                            <input type="text" id="end_time${i}_${index}" class="form-control inputs_up timepicker-input" name="end_time[${i}][${index}]" autocomplete="off" placeholder="End Time"/>
                        </td>`;
                        });
                        selectBoxHTML += `</tr>`;
                    }

                    // Append the select box HTML to a target element
                    $('#table_body').html(selectBoxHTML);
                    $('.subjects').select2();
                    $('#table_body td').css('margin-top', '10px');


                    // start time picker script
                    jQuery('.timepicker-input').timepicker();
                    // end time picker script


                    $('.subjects').change(function () {
                        var subject_id = $(this).children('option:selected').val();
                        console.log(subject_id);
                        var index = $(this).data('index');
                        var i = $(this).data('i');
                        $.ajax({
                            url: '/get_teachers',
                            type: 'get',
                            dataType: 'json',
                            data: {
                                'subject_id': subject_id
                            },
                            success: function (data) {
                                console.log(data);
                                var teacherOptions =
                                    '<option value="" selected>Choose Teacher</option>';
                                $.each(data, function (index, item) {
                                    teacherOptions +=
                                        `<option value="${item.user_id}">${item.user_name}</option>`;
                                });
                                $(`#teacher_id${i}_${index}`).html(teacherOptions);
                            }
                        });
                    });
                    $('.teachers').select2();
                }
            });
        });
        $(document).ready(function () {
            $('#class_id').select2();
            $('#section_id').select2();
            $('#semester_id').select2();
            $('#starting_days').select2();
            // start time picker script
            $('.timepicker-input').timepicker();
            // end time picker script
        });
    </script>
    {{-- <script>
    $('#generate_fields_btn').click(function() {
        var numDays = parseInt($('#num_of_days').val());
        console.log(numDays)

        if (isNaN(numDays) || numDays < 1) {
            alert('Please enter a valid number of days.');
            return;
        }

        // Find the index of the Monday column
        var mondayIndex = $('#table_body td:contains("Monday")').index();

        // Loop through each day and replicate data from Monday
        for (var i = 1; i < numDays; i++) {
            var currentRow = $('#table_body tr').eq(i);

            // Copy data from Monday to the current day
            currentRow.find('td').each(function(index) {
                if (index > mondayIndex) {
                    var mondayData = $('#table_body tr').eq(0).find('td').eq(index); // Get the Monday cell
                    $(this).find('input, select').val(mondayData.find('input, select').val());
                }
            });
        }
    });
</script> --}}
    {{-- required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let starting_days = document.getElementById("starting_days"),
                class_id = document.getElementById("class_id"),
                section_id = document.getElementById("section_id"),
                semester_id = document.getElementById("semester_id"),
                wef = document.getElementById("wef"),
                // break_start_time = document.getElementById("break_start_time"),
                // break_end_time = document.getElementById("break_end_time"),
                semester_start_date = document.getElementById("semester_start_date"),
                num_of_days = document.getElementById("num_of_days"),
                validateInputIdArray = [
                    starting_days.id,
                    class_id.id,
                    section_id.id,
                    semester_id.id,
                    wef.id,
                    // break_start_time.id,
                    // break_end_time.id,
                    semester_start_date.id,
                    num_of_days.id
                ];
            let check = validateInventoryInputs(validateInputIdArray);

            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
@endsection
