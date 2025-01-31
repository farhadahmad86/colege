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

    <form name="f1" class="f1" id="f1" action="{{ route('update_time_table') }}" method="post"
          onsubmit="return checkForm()">
        <div class="row">
            {{--            edit it --}}
            <div id="main_bg" class="container-fluid search-filter form-group form_manage">
                {{--                form header --}}
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Edit Time Table</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <a class="add_btn list_link add_more_button" href="{{ route('time_table_list') }}"
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
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="required">
                                        Class</label>
                                    <select class="form-control form-control-sm" name="class_id" id="class_id"
                                            data-rule-required="true" data-msg-required="Please Enter Class">
                                        {{-- onchange="showDetail(this)"> --}}
                                        {{--  --}}
                                        <option value="" selected>Select Class</option>
                                        {{-- @foreach ($classes as $class) --}}
                                        <option value="{{ $classes->class_id }}"
                                            {{ $classes->class_id == $request->class_id ? 'selected' : '' }}>
                                            {{ $classes->class_name }}
                                        </option>
                                        {{-- @endforeach --}}

                                    </select>
                                    <span id="role_error_msg" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="required">
                                        Section
                                    </label>
                                    <select tabindex="1" autofocus name="section_id" class="form-control required"
                                            id="section_id" autofocus data-rule-required="true"
                                            data-msg-required="Please Enter Section">
                                        {{-- @foreach ($sections as $section) --}}
                                        <option value="{{ $sections->cs_id }}"
                                            {{ $sections->cs_id == $request->section_id ? 'selected' : '' }}>
                                            {{ $sections->cs_name }}
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
                                        Annual/Semester
                                    </label>
                                    <select tabindex="1" autofocus name="semester_id" class="form-control required"
                                            id="semester_id" autofocus data-rule-required="true"
                                            data-msg-required="Please Enter..">
                                        {{-- @foreach ($semesters as $semester) --}}
                                        <option value="{{ $semesters->semester_id }}"
                                            {{ $semesters->semester_id == $request->semester_id ? 'selected' : '' }}>
                                            {{ $semesters->semester_name }}
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
                                        With Effected From
                                    </label>
                                    <input tabindex="1" type="text" name="wef" id="wef"
                                           class="inputs_up form-control datepicker1" placeholder="Please Enter w.e.f"
                                           autofocus data-rule-required="true" data-msg-required="Please Enter w.e.f"
                                           autocomplete="off" value="{{ old('wef') }}">
                                    <span id="demo1" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">
                                        Break Start Time
                                    </label>
                                    <input tabindex="1" type="text" name="break_start_time" id="break_start_time"
                                           class="inputs_up form-control timepicker-input"
                                           placeholder="Please Enter Break Start Time" autofocus
                                           data-rule-required="true"
                                           data-msg-required="Please Enter Break Start Time" autocomplete="off"
                                           value="{{ $request->break_start_time }}"/>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="">
                                        Break End Time
                                    </label>
                                    <input tabindex="1" type="text" name="break_end_time" id="break_end_time"
                                           class="inputs_up form-control timepicker-input"
                                           placeholder="Please Enter Break End Time" autofocus data-rule-required="true"
                                           data-msg-required="Please Enter Break End Time" autocomplete="off"
                                           value="{{ $request->break_end_time }}"/>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Table start --}}
                <div class="pro_tbl_con">
                    <!-- product table container start -->
                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm style_table" id="category_dynamic_table">
                            <thead>
                            {{-- <tr>
                        <th class="text-center tbl_srl_9"> Days</th>
                        <th class="text-center tbl_txt_13"> Item Name</th>
                        <th class="text-center tbl_txt_9"> Remarks</th>
                        <th class="text-center tbl_txt_10"> Warehouse</th>

                        <th class="text-center tbl_srl_4">
                            UOM
                        </th>
                        <th class="text-center tbl_srl_4">
                            Loose Qty
                        </th>
                        <th class="text-center tbl_srl_6">
                            Loose Rate
                        </th>
                        <th class="text-center tbl_srl_9">
                            Gross Amount
                        </th>

                    </tr> --}}
                            </thead>
                            <tbody id="table_body">
                            @php
                                use App\User;
                                use App\Models\College\Subject;
                                $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            @endphp

                            @foreach ($time_table as $timeTableItem)
                                @php
                                    $subjectCount = $subjects->count();
                                    $timetableData = json_decode($timeTableItem->tm_timetable, true);
                                    $totalItems = count($timetableData);
                                    $totalItems + 1;
                                @endphp

                                @foreach ($timetableData as $dayIndex => $dayRow)
                                    <tr>
                                        <td><input type="hidden" name="day[]" value="{{ $dayRow['day'] }}"
                                                   id="day${i}" readonly>{{ $dayRow['day'] }}</td>
                                        @php
                                            $subjectIndex = 0; // Initialize subject index for this day
                                         $startingDay = $dayRow['day'];
                                         $startIndex = array_search($startingDay, $daysOfWeek);
                                        // Reorder daysOfWeek to start from the selected starting day
                                        if ($startIndex !== false) {
                                            $daysOfWeek = array_merge(array_slice($daysOfWeek, $startIndex), array_slice($daysOfWeek, 0, $startIndex));
                                        }
                                        @endphp
                                        @foreach ($dayRow['items'] as $index => $timeItem)
                                            @php
                                                $index++;
                                            @endphp
                                            <td>
                                                <label class="required">Subject</label>
                                                <select tabindex="1"
                                                        name="subject_id[{{ $loop->parent->index }}][{{ $index }}]"
                                                        id="subject_id{{ $loop->parent->index }}{{ $index }}"
                                                        data-j="{{ $loop->parent->index }}" data-i="{{ $index }}"
                                                        class="form-control subjects">
                                                    <option value="" selected>Choose Subject</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->subject_id }}"
                                                            {{ $subject->subject_id == $timeItem['subject_id'] ? 'selected' : '' }}>
                                                            {{ $subject->subject_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @php
                                                    $teacher_ids = Subject::where('subject_id', $timeItem['subject_id'])
                                                        ->pluck('subject_teacher_id')
                                                        ->first();
                                                    $groupSubjectIds = explode(',', $teacher_ids);
                                                    $teachers = User::whereIn('user_id', $groupSubjectIds)
                                                        ->select('user_id', 'user_name')
                                                        ->get();
                                                @endphp
                                                <label class="required">Teacher</label>
                                                <select tabindex="1"
                                                        name="teacher_id[{{ $loop->parent->index }}][{{ $index }}]"
                                                        id="teacher_id{{ $loop->parent->index }}{{ $index }}"
                                                        class="form-control teachers">
                                                    <option value="" selected>Choose Teacher</option>
                                                    @foreach ($teachers as $teacher)
                                                        <option value="{{ $teacher->user_id }}"
                                                            {{ $teacher->user_id == $timeItem['teacher_id'] ? 'selected' : '' }}>
                                                            {{ $teacher->user_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <label class="required">Start Time</label>
                                                <input type="text" class="form-control inputs_up timepicker-input"
                                                       name="start_time[{{ $loop->parent->index }}][{{ $index }}]"
                                                       id="start_time{{ $loop->parent->index }}{{ $index }}"
                                                       value="{{ $timeItem['start_time'] }}" autocomplete="off"
                                                       placeholder="End Time"/>

                                                <label class="required">End Time</label>
                                                <input type="text" class="form-control inputs_up timepicker-input"
                                                       name="end_time[{{ $loop->parent->index }}][{{ $index }}]"
                                                       id="end_time{{ $loop->parent->index }}{{ $index }}"
                                                       value="{{ $timeItem['end_time'] }}" autocomplete="off"
                                                       placeholder="End Time"/>
                                            </td>
                                            @php
                                                $subjectIndex++; // Increment subject index for this day
                                            @endphp
                                        @endforeach
                                        @for ($i = $subjectIndex + 1; $i <= $subjectCount; $i++)
                                            <p>Loop iteration: {{ $i }}</p>
                                            <td>
                                                <label class="required">Subject</label>
                                                <select tabindex="1"
                                                        name="subject_id[{{ $dayIndex }}][{{ $i }}]"
                                                        id="subject_id{{ $dayIndex }}{{ $i }}"
                                                        data-j="{{ $dayIndex }}" data-i="{{ $i }}"
                                                        class="form-control subjects">
                                                    <option value="" selected>Choose Subject</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->subject_id }}">
                                                            {{ $subject->subject_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <label class="required">Teacher</label>
                                                <select tabindex="1"
                                                        name="teacher_id[{{ $dayIndex }}][{{ $i }}]"
                                                        id="teacher_id{{ $dayIndex }}{{ $i }}"
                                                        class="form-control teachers">

                                                </select>

                                                <label class="required">Start Time</label>
                                                <input type="text" class="form-control inputs_up timepicker-input"
                                                       name="start_time[{{ $dayIndex }}][{{ $i }}]"
                                                       id="start_time{{ $dayIndex }}{{ $i }}"
                                                       autocomplete="off" placeholder="End Time"/>
                                                <label class="required">End Time</label>
                                                <input type="text" class="form-control inputs_up timepicker-input"
                                                       name="end_time[{{ $dayIndex }}][{{ $i }}]"
                                                       id="end_time{{ $dayIndex }}{{ $i }}"
                                                       autocomplete="off" placeholder="End Time"/>
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach

                                @for ($j = $totalItems; $j < $totalItems; $j++)
                                    <tr>
                                        <td><input type="hidden" name="day[]" id="day${i}"
                                                   value="{{ $daysOfWeek[$j % 7] }}" readonly>{{ $daysOfWeek[$j % 7] }}
                                        </td>
                                        @for ($i = 1; $i <= $subjectCount; $i++)
                                            <td>
                                                <label class="required">Subject</label>
                                                <select tabindex="1"
                                                        name="subject_id[{{ $j }}][{{ $i }}]"
                                                        id="subject_id{{ $j }}{{ $i }}"
                                                        data-j="{{ $j }}" data-i="{{ $i }}"
                                                        class="form-control subjects">
                                                    <option value="" selected>Choose Subject</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->subject_id }}">
                                                            {{ $subject->subject_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <label class="required">Teacher</label>
                                                <select tabindex="1"
                                                        name="teacher_id[{{ $j }}][{{ $i }}]"
                                                        id="teacher_id{{ $j }}{{ $i }}"
                                                        class="form-control teachers">

                                                </select>

                                                <label class="required">Start Time</label>
                                                <input type="text" class="form-control inputs_up timepicker-input"
                                                       name="start_time[{{ $j }}][{{ $i }}]"
                                                       id="start_time{{ $j }}{{ $i }}"
                                                       autocomplete="off" placeholder="End Time"/>
                                                <label class="required">End Time</label>
                                                <input type="text" class="form-control inputs_up timepicker-input"
                                                       name="end_time[{{ $j }}][{{ $i }}]"
                                                       id="end_time{{ $j }}{{ $i }}"
                                                       autocomplete="off" placeholder="End Time"/>
                                            </td>
                                        @endfor
                                    </tr>
                                @endfor
                            @endforeach
                            </tbody>

                        </table>
                    </div><!-- product table box end -->
                </div>
                <button tabindex="1" type="submit" name="save" id="save"
                        class="save_button btn btn-sm btn-success"> Save
                </button>
            </div>

        </div>
        <input type="hidden" value="{{ $request->tm_id }}" name="tm_id">
    </form>
@endsection
@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let class_id = document.getElementById("class_id"),
                section_id = document.getElementById("section_id"),
                semester_id = document.getElementById("semester_id"),
                wef = document.getElementById("wef"),
                // break_start_time = document.getElementById("break_start_time"),
                // break_end_time = document.getElementById("break_end_time"),
                validateInputIdArray = [
                    class_id.id,
                    section_id.id,
                    semester_id.id,
                    wef.id,
                    // break_start_time.id,
                    // break_end_time.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);

            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
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

        $(document).on('change', '.subjects', function() {
            var subject_id = $(this).val();
            var i = $(this).data('i');
            console.log(i);
            var j = $(this).data('j');
            console.log(j);

            $.ajax({
                url: '/get_teachers',
                type: 'get',
                dataType: 'json',
                data: {
                    'subject_id': subject_id
                },
                success: function(data) {
                    console.log(data);
                    var teacherOptions = '<option selected>Choose Teacher</option>';
                    $.each(data, function(index, item) {
                        teacherOptions +=
                            `<option value="${item.user_id}">${item.user_name}</option>`;
                    });
                    // Use the correct ID selector format with square brackets
                    $('#teacher_id' + j + i).html("");
                    $('#teacher_id' + j + i).html(teacherOptions);
                }
            });
        });


        $(document).ready(function() {
            $('#class_id').select2();
            $('#section_id').select2();
            $('#semester_id').select2();
            $('.subjects').select2();
            $('.teachers').select2();
            // start time picker script
            $('.timepicker-input').timepicker();
            // end time picker script
        });
    </script>
@endsection
