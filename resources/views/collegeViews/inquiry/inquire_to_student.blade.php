@extends('extend_index')
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Student</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('student_list') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('store_student') }}" method="post"
                  onsubmit="return checkForm()" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Registration No
                            </label>
                            <input class="form-control" id="reg_no" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Registration No" autocomplete="off" name="reg_no"
                                   type="text" placeholder="Enter your Registration No" value="{{ $reg_no }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Full Name
                            </label>
                            <input class="form-control" id="full_name" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Full Name" autocomplete="off" name="full_name"
                                   type="text" placeholder="Enter your Full Name"
                                   value="{{ $inquiry->inq_full_name }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="email" class="required">Email</label>
                            <input class="form-control" id="email" name="email" type="email"
                                   placeholder="name@example.com" value="{{ old('email') }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="contact" class="required">Phone No</label>
                            <input class="form-control" id="contact" name="contact" type="text"
                                   placeholder="03*********" value="{{ $inquiry->inq_contact }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <!-- start input box -->
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="gender" class="required">Gender</label>
                            <select id="gender" type="text" class="form-control @error('gender') is-invalid @enderror"
                                    name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ $inquiry->inq_gender == 'Male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="Female" {{ $inquiry->inq_gender == 'Female' ? 'selected' : '' }}>Female
                                </option>
                                <option value="Other" {{ $inquiry->inq_gender == 'Other' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="religion">Religion<span class="required">*</span></label>
                            <select id="religion" type="text"
                                    class="form-control @error('religion') is-invalid @enderror" name="religion">
                                <option value="">Select Religion</option>
                                <option value="Muslim"{{ $inquiry->inq_religion == 'Muslim' ? 'selected' : '' }}>Muslim
                                </option>
                                <option
                                    value="Non Muslim" {{ $inquiry->inq_religion == 'Non Muslim' ? 'selected' : '' }}>
                                    Non Muslim
                                </option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="cnic">CNIC<span class="required">*</span></label>
                            <input id="cnic" type="text" class="form-control @error('cnic') is-invalid @enderror"
                                   name="cnic" value="{{ $inquiry->inq_cnic }}" placeholder="03***-********-1">
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                DOB
                            </label>
                            <input tabindex="6" type="text" name="dob" id="dob"
                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                   placeholder="Date of Birth"
                                   value="{{ $inquiry->inq_dob }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Programs</label>
                            <select tabindex="5" name="program" class="inputs_up form-control" data-rule-required="true"
                                    data-msg-required="Please Enter Class" id="program" disabled>
                                <option value="" disabled selected>Select Program</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->program_id }}"
                                            data-demand="{{ $program->program_name }}" {{ $program->program_id == $inquiry->inq_program_id  ? 'selected' : '' }}>
                                        {{ $program->program_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="role_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="father_name" class="required">
                                Father Name
                            </label>
                            <input class="form-control" id="father_name" name="father_name" type="text"
                                   placeholder="Father Name" value="{{ $inquiry->inq_father_name }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Father Contact
                            </label>
                            <input class="form-control @error('parentContact') is-invalid @enderror" id="parentContact"
                                   name="parentContact" type="text" placeholder="Father Contact"
                                   value="{{ $inquiry->inq_parent_contact }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Father CNIC
                            </label>
                            <input id="father_cnic" type="text"
                                   class="form-control @error('father_cnic') is-invalid @enderror" name="father_cnic"
                                   value="{{ $inquiry->inq_father_cnic }}" placeholder="03***-********-1">
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Admission Date
                            </label>
                            <input tabindex="6" type="text" name="admission_date" id="admission_date"
                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                   placeholder="Admission Date" value="{{ old('admission_date') }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Reference
                            </label>
                            <input class="form-control @error('reference') is-invalid @enderror" id="reference"
                                   name="reference" type="text" placeholder="Enter your Reference"
                                   value="{{ $inquiry->inq_reference }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Code
                            </label>
                            <input class="form-control @error('code') is-invalid @enderror" id="code" name="code"
                                   type="text" placeholder="Enter your Code" value="{{ $inquiry->inq_code }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                City
                            </label>
                            <input class="form-control @error('city') is-invalid @enderror" id="city" name="city"
                                   type="text" placeholder="Enter your City" value="{{ $inquiry->inq_city }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Metric Marks
                            </label>
                            <input class="form-control @error('metric_marks') is-invalid @enderror" id="metric_marks"
                                   name="metric_marks" type="number" placeholder="Enter your Metric Marks"
                                   value="{{ $inquiry->inq_marks_10th }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                First Year Marks
                            </label>
                            <input class="form-control @error('first_year_marks') is-invalid @enderror"
                                   id="first_year_marks" name="first_year_marks" type="number"
                                   placeholder="Enter your First Year Marks" value="{{ $inquiry->inq_marks_11th }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                School
                            </label>
                            <select id="school" type="text"
                                    class="form-control @error('school') is-invalid @enderror" name="school">
                                <option value="">Select School</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->sch_id }}"
                                        {{ $school->sch_id == $inquiry->inq_school_id ? 'selected' : '' }}>
                                        {{ $school->sch_name }}</option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Reference Type
                            </label>
                            <input class="form-control @error('reference_type') is-invalid @enderror"
                                   id="reference_type"
                                   name="reference_type" type="text"
                                   placeholder="Enter your Reference
                                Type"
                                   value="{{ $inquiry->inq_reference_type }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="branch">Branch Name</label>
                            <select id="branch" type="text"
                                    class="form-control @error('branch') is-invalid @enderror" name="branch">
                                <option value="">Select Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->branch_id }}"
                                        {{ $branch->branch_id == $inquiry->inq_branch_id ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="fullName">Class</label>
                            <select id="class" type="text"
                                    class="form-control @error('branch') is-invalid @enderror" name="class">
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->class_id }}"
                                        {{ $class->class_id == old('branch') ? 'selected' : '' }}>
                                        {{ $class->class_name }}{{ $class->class_session_id }}</option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Group

                            </label>
                            <select tabindex="9" autofocus name="group" class="form-control required" id="group"
                                    autofocus data-rule-required="true" data-msg-required="Please Enter Group">
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
                            <select tabindex="10" autofocus name="section" class="form-control required" id="section"
                                    autofocus data-rule-required="true" data-msg-required="Please Enter Group">
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="fullName">Hostel</label>
                            <select id="hostel" type="text"
                                    class="form-control @error('hostel') is-invalid @enderror" name="hostel">
                                <option value="No">No Used</option>
                                <option value="Yes">Used</option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="fullName">Special Student</label>
                            <select id="zakat" type="text"
                                    class="form-control @error('zakat') is-invalid @enderror" name="zakat">
                                <option value="No">No Used</option>
                                <option value="Yes">Zakat</option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="transport">Use Transport</label>
                            <select id="transport" type="text"
                                    class="form-control @error('transport') is-invalid @enderror" name="transport">
                                <option value="">Select Transport</option>
                                <option value="Yes">Used</option>
                                <option value="No">Not Used</option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <x-upload-image title="Student Profile"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="reset" name="cancel" id="cancel"
                                class="cancel_button btn btn-sm btn-secondary">
                            <i class="fa fa-eraser"></i> Cancel
                        </button>
                        <button tabindex="1" type="submit" name="save" id="save"
                                class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
            $('#class').change(function () {
                var class_id = $(this).children('option:selected').val();
                $.ajax({
                    url: '/get_groups',
                    type: 'get',
                    datatype: 'text',
                    data: {
                        'class_id': class_id
                    },
                    success: function (data) {
                        console.log(data);
                        var groups = '<option selected disabled >Choose Groups</option>';
                        var sections = '<option selected disabled >Choose Section</option>';

                        $.each(data.groups, function (index, items) {

                            groups +=
                                `<option value="${items.ng_id}"> ${items.ng_name} </option>`;


                        });
                        $.each(data.section, function (index, items) {

                            sections +=
                                `<option value="${items.cs_id}"> ${items.cs_name} </option>`;


                        });
                        $('#group').html(groups);
                        $('#section').html(sections);
                    }
                })
            });
            jQuery('#class').select2();
            jQuery('#group').select2();
            jQuery('#section').select2();
    </script>

    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let full_name = document.getElementById("full_name"),
                email = document.getElementById("email"),
                contact = document.getElementById("contact"),
                gender = document.getElementById("gender"),
                cnic = document.getElementById("cnic"),
                admission_date = document.getElementById("admission_date"),
                dob = document.getElementById("dob"),
                class_id = document.getElementById("class"),
                group = document.getElementById("group"),
                section = document.getElementById("section"),
                validateInputIdArray = [
                    full_name.id,
                    email.id,
                    contact.id,
                    gender.id,
                    cnic.id,
                    admission_date.id,
                    dob.id,
                    class_id.id,
                    group.id,
                    section.id,
                    // branch.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    </script>
@endsection
@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('student_list') }}',
            url;
        @include('include.print_script_sh')
    </script>

@endsection

