@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Assign Semester Subject</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('subject_assign_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('submit_subject_assign') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class Name</label>
                            <select tabindex="5" name="class" class="inputs_up form-control" data-rule-required="true"
                                data-msg-required="Please Enter Class" id="class_id">
                                <option value="" disabled selected>Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->class_id }}" data-demand="{{ $class->class_demand }}"
                                        {{ $class->class_id == old('class') ? 'selected' : '' }}>
                                        {{ $class->class_name }}</option>
                                @endforeach
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
                            <select tabindex="1" autofocus name="section_id" class="form-control required" id="section_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Section">
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
                            <select tabindex="1" autofocus name="semester" class="form-control required" id="semester"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Department">
                                <option value="" disabled selected>Select Semester</option>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->semester_id }}"
                                        {{ $semester->semester_id == old('semester') ? 'selected' : '' }}>
                                        {{ $semester->semester_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
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
                                @foreach ($Subjects as $Subject)
                                    <option value="{{ $Subject->subject_id }}"
                                        {{ $Subject->subject_id == old('subject') ? 'selected' : '' }}>
                                        {{ $Subject->subject_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    {{-- <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Semester End Date
                            </label>
                            <input tabindex="6" type="text" name="semester_end_date" id="semester_end_date"
                                class="inputs_up form-control datepicker1" autocomplete="off" data-rule-required="true"
                                data-msg-required="Please Enter Semester End Date" placeholder=" Semester End Date"
                                value="{{ old('semester_end_date') }}" />
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div> --}}
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        {{-- <button tabindex="1" type="reset" name="cancel" id="cancel"
                            class="cancel_button btn btn-sm btn-secondary">
                            <i class="fa fa-eraser"></i> Cancel
                        </button> --}}
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
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let class_name = document.getElementById("class_name"),
                semester = document.getElementById("semester"),
                subject = document.getElementById("subject"),
                semester_end_date = document.getElementById("semester_end_date"),
                validateInputIdArray = [
                    class_name.id,
                    semester.id,
                    subject.id,
                    semester_end_date.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
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
        // (expiry check)
        jQuery("#semester_end_date").change(function() {
            let month = $(this).val();
            let class_id = $('#class_name').val();
            console.log(month, class_id);
            if (class_id != '' && month != '') {
                check_date(class_id, month)
            }
        });
        jQuery("#class_name").change(function() {
            let class_id = $(this).val();
            let month = $('#semester_end_date').val();
            if (class_id != '' && month != '') {
                check_date(class_id, month)
            }
        });

        function check_date(class_id, date) {
            $.ajax({
                url: '/get_expiry',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id,
                    'date': date
                },
                success: function(data) {
                    console.log(date);
                    // data.forEach(element => {

                    //     employees +=
                    //         `<option value="${element.user_id}"> ${element.user_name} </option>`;
                    // });
                    // $('#sa_employee_id').html(employees);
                }
            })
        };
        jQuery("#class_name").change(function() {
            let class_id = $(this).val();
            // let month = $('#semester_end_date').val();
            // if (class_id != '' && month != '') {
            //     check_date(class_id, month)
            // }
        });
        $('#class_id').change(function() {
            var class_id = $(this).children('option:selected').val();
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
                            `<option value="${items.cs_id}"> ${items.cs_name} </option>`;


                    });
                    $('#section_id').html(sections);
                }
            })
        });
        $(document).ready(function() {
            $('#class_id').select2();
            $('#section_id').select2();
            $('#semester').select2();
            $('#subject').select2();
        });
    </script>
@endsection
