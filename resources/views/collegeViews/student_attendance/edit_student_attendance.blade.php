@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Edit Attendance</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('student_attendance_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <!-- invoice box start -->
            <form name="f1" class="f1" id="f1" action="{{ route('update_student_attendance') }}"
                method="post" onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12" >
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class
                            </label>
                            <select tabindex="4" autofocus name="class_id" class="inputs_up form-control" id="class_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Class" readonly>
                                <option value="">Select Class</option>

                                @foreach ($classes as $class)
                                    <option
                                        value="{{ $class->class_id }}"{{ $class->class_id == $request->class_id ? 'selected' : '' }} readonly>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach

                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12" >
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Section
                            </label>
                            <select tabindex="5" autofocus name="section_id" class="form-control required" id="section_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Section">
                            </select readonly>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Attendace Date
                            </label>
                            <input tabindex="6" type="text" name="attendance_date" id="attendance_date"
                                class="inputs_up form-control datepicker1" autocomplete="off" data-rule-required="true"
                                data-msg-required="Please Enter Admission Date" placeholder="Admission Date"
                                value="{{ $request->att_date }}" readonly>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">


                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm" id="category_dynamic_table">
                            <!-- product table box start -->
                            <thead>
                                <tr>
                                    <th class="text-center tbl_txt_5">Sr#</th>
                                    <th class="text-center tbl_txt_5">Roll No</th>
                                    <th class="text-center tbl_txt_20">Students</th>
                                    <th class="text-center tbl_txt_15">Father Name</th>
                                    <th class="text-center tbl_txt_5">P</th>
                                    <th class="text-center tbl_txt_5">A</th>
                                    <th class="text-center tbl_txt_5">L</th>
                                    <th class="text-center tbl_txt_40">Leave Detail</th>
                                </tr>
                            </thead>
                            <tbody id="table_body">
                                @php
                                    // Get all student IDs from the attendance data
                                    $studentIds = collect(json_decode($request->std_attendance, true))->pluck('student_id');
                                    
                                    // Fetch all students using the student IDs
                                    $students = App\Models\College\Student::whereIn('id', $studentIds)->get();
                                    $leave_remarks = json_decode($request->leave_remarks);
                                    $std = 1;
                                    // Create a lookup array to easily access student details inside the loop
                                    $studentLookup = [];
                                    foreach ($students as $student) {
                                        $studentLookup[$student->id] = $student;
                                    }
                                    
                                @endphp
                                @foreach (json_decode($request->std_attendance, true) as $attendance)
                                    @php
                                        $student = $studentLookup[$attendance['student_id']] ?? null;
                                        
                                    @endphp
                                    @if ($student)
                                        <tr>
                                            <th scope="row">
                                                {{ $std++ }}
                                            </th>
                                            <th scope="row">
                                                {{ $student->roll_no }}
                                            </th>
                                            <td class="edit">
                                                {{ $student->full_name }}
                                            </td>
                                            <td class="edit">
                                                {{ $student->father_name }}
                                            </td>
                                            <td class="tbl_srl_5">
                                                <input type="radio" name="attendance[{{ $student->id }}]" id="P"
                                                    value="P"{{ $attendance['is_present'] == 'P' ? 'checked' : ' ' }}>
                                            </td>
                                            <td class="tbl_srl_5">
                                                <input type="radio" name="attendance[{{ $student->id }}]" id="A"
                                                    value="A"{{ $attendance['is_present'] == 'A' ? 'checked' : ' ' }}>
                                            </td>
                                            <td class="tbl_srl_5">
                                                <input type="radio" name="attendance[{{ $student->id }}]" id="L"
                                                    value="L"{{ $attendance['is_present'] == 'L' ? 'checked' : ' ' }}>
                                            </td>
                                            @if (!empty($student))
                                                @foreach ($studentIds as $key => $value)
                                                    @if ($value == $student->id)
                                                        <td class="tbl_srl_40"><input type="text" name="leave_remarks[]"
                                                                id="leave_remarks" value="{{ $leave_remarks[$key] }}"
                                                                style="width:100%"></td>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @else
                                            Student ID: {{ $attendance['student_id'] }} - Student not found - Attendance:
                                            {{ $attendance['is_present'] }}
                                    @endif

                                    </tr>
                                @endforeach>
                        </table>
                        <input type="hidden" value="{{$request->std_att_id}}" name="std_att_id">
                    </div><!-- product table box end -->
                </div>
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
    <script type="text/javascript">
        var base = '{{ route('mark_student_attendance') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    required input validation --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                if ($(this).is(':checked')) {
                    $('input[type="checkbox"]').not(this).prop('checked', false);
                }
            });
            get_section({!! $request->class_id !!});

        });

        function checkForm() {
            let attendance_date = document.getElementById("attendance_date"),
                validateInputIdArray = [
                    attendance_date.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }

        function get_section(class_id) {
            var section_id = {!! $request->att_section_id !!}

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
                            `<option value="${items.cs_id}" ${items.cs_id == section_id ? 'selected' : ''  } disabled> ${items.cs_name} </option>`;

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
    {{-- end of required input validation --}}
    <script type="text/javascript">
        jQuery("#class_id").select2();
        jQuery("#class").select2();
        jQuery("#section_id").select2();
        jQuery("#section").select2();
    </script>
    <script>
        jQuery("#cancel").click(function() {
            $("#class").val('');
            $("#section").val('');
            $("#month").val('');
        });
    </script>
@endsection
