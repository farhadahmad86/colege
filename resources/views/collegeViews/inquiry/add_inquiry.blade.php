@extends('extend_index')
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Inquiry</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('inquiry_list') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('store_inquiry') }}" method="post"
                  onsubmit="return checkForm()" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Full Name
                            </label>
                            <input class="form-control" id="full_name" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Full Name" autocomplete="off" name="full_name"
                                   type="text" placeholder="Enter your Full Name" value="{{ old('full_name') }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="contact" class="required">
                                Student Contact</label>
                            <input class="form-control" id="contact" name="contact" type="text"
                                   data-rule-required="true" data-msg-required="Please Enter Student Contact"
                                   placeholder="03*********"
                                   value="{{ old('contact') }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <!-- start input box -->
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="gender" class="required">Gender</label>
                            <select id="gender" type="text" class="form-control" name="gender"
                                    data-rule-required="true" data-msg-required="Please Enter Gender">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ 'Male' == old('gender') ? 'selected' : '' }}>Male
                                </option>
                                <option value="Female" {{ 'Female' == old('gender') ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ 'Other' == old('gender') ? 'selected' : '' }}>Other</option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                DOB
                            </label>
                            <input tabindex="6" type="text" name="dob" id="dob"
                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                   placeholder="Date of Birth"
                                   data-rule-required="true" data-msg-required="Please Enter Date Of Birth"
                                   value="{{ old('dob') }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="father_name" class="required">
                                Father Name
                            </label>
                            <input class="form-control" id="father_name" name="father_name" type="text"
                                   placeholder="Father Name" value="{{ old('father_name') }}" data-rule-required="true"
                                   data-msg-required="Please Enter Father Name"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Father Contact
                            </label>
                            <input class="form-control @error('parentContact') is-invalid @enderror" id="parentContact"
                                   name="parentContact" type="text" placeholder="Father Contact"
                                   value="{{ old('parentContact') }}" data-rule-required="true"
                                   data-msg-required="Please Enter Father Contact"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Inquiry Date
                            </label>
                            <input tabindex="6" type="text" name="inquiry_date" id="inquiry_date"
                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                   placeholder="Enter Inquiry Date" data-rule-required="true"
                                   data-msg-required="Please Enter  Inquiry Date" value="{{ old('inquiry_date') }}"/>
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
                            <input id="reference" type="text" class="form-control" name="reference"
                                   data-rule-required="true" data-msg-required="Please Enter Reference"
                                   value="{{ old('reference') }}" placeholder="Please Enter Reference">
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Metric Marks
                            </label>
                            <input class="form-control" id="metric_marks" name="metric_marks" type="number"
                                   placeholder="Enter your Metric Marks" data-rule-required="true"
                                   data-msg-required="Please Enter 10th Marks" value="{{ old('metric_marks') }}"/>
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
                            <input class="form-control" id="first_year_marks" name="first_year_marks" type="number"
                                   placeholder="Enter your First Year Marks" value="{{ old('first_year_marks') }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                School</label>
                            <select tabindex="5" name="school" class="inputs_up form-control"
                                    data-rule-required="true" data-msg-required="Please Enter School" id="school">
                                <option value="">Select School</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->sch_id }}"
                                        {{ $school->sch_id == old('school') ? 'selected' : '' }}>
                                        {{ $school->sch_name }}</option>
                                @endforeach
                            </select>
                            <span id="role_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    {{--                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">--}}
                    {{--                        <div class="input_bx">--}}
                    {{--                            <!-- start input box -->--}}
                    {{--                            <label class="required">--}}
                    {{--                                Branch</label>--}}
                    {{--                            <select tabindex="5" name="branch" class="inputs_up form-control"--}}
                    {{--                                data-rule-required="true" data-msg-required="Please Enter Branch" id="branch">--}}
                    {{--                                <option value="">Select Branch</option>--}}
                    {{--                                @foreach ($branches as $branch)--}}
                    {{--                                    <option value="{{ $branch->branch_id }}"--}}
                    {{--                                        {{ $branch->branch_id == old('branch') ? 'selected' : '' }}>--}}
                    {{--                                        {{ $branch->branch_name }}</option>--}}
                    {{--                                @endforeach--}}
                    {{--                            </select>--}}
                    {{--                            <span id="role_error_msg" class="validate_sign"> </span>--}}
                    {{--                        </div><!-- end input box -->--}}
                    {{--                    </div>--}}
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Programs</label>
                            <select tabindex="5" name="program" class="inputs_up form-control"
                                    data-rule-required="true" data-msg-required="Please Enter Program" id="program">
                                <option value="">Select Program</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->program_id }}" data-demand="{{ $program->program_name }}"
                                        {{ $program->program_id == old('program') ? 'selected' : '' }}>
                                        {{ $program->program_name }}</option>
                                @endforeach
                            </select>
                            <span id="role_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Student Type
                            </label>
                            <select tabindex="1" autofocus name="student_type[]" class="form-control required"
                                    id="student_type"
                                    autofocus data-rule-required="true" data-msg-required="Please Enter Student Type"
                                    multiple>
                                <option value="" disabled>Select Student Type</option>
                                <option value="inquiry">Inquiry</option>
                                <option value="summercamp">SummerCamp</option>
                                <option value="prospectus">Prospectus</option>
                                <option value="confirm_admission">Confirm Admission</option>
                                <span id="demo1" class="validate_sign"> </span>
                            </select>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Address
                            </label>
                            <textarea tabindex="24" name="address" id="address" class="remarks inputs_up form-control"
                                      placeholder="Address"
                                      data-rule-required="true" data-msg-required="Please Enter Address"
                                      style="height: 107px;">{{ old('address') }}</textarea>
                        </div>
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
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let full_name = document.getElementById("full_name"),
                contact = document.getElementById("contact"),
                gender = document.getElementById("gender"),
                dob = document.getElementById("dob"),
                father_name = document.getElementById("father_name"),
                student_type = document.getElementById("student_type"),
                parentContact = document.getElementById("parentContact"),
                inquiry_date = document.getElementById("inquiry_date"),
                metric_marks = document.getElementById("metric_marks"),
                program = document.getElementById('program');
            validateInputIdArray = [
                full_name.id,
                contact.id,
                gender.id,
                dob.id,
                father_name.id,
                parentContact.id,
                inquiry_date.id,
                metric_marks.id,
                program.id,
                student_type.id,
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
    <script type="text/javascript">
        jQuery('#school').select2();
        jQuery('#class').select2();
        jQuery('#program').select2();
        jQuery('#branch').select2();
    </script>
    {{--    add code by shahzaib end --}}
    <script></script>
    <script>
        $(document).ready(function () {

            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let regId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_region') }}',
                    data: {
                        'status': status,
                        'branch_id': regId
                    },
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
            $('#student_type').select2();
        });
    </script>
    <script>
        jQuery("#class").change(function () {
            var demand = $("#class option:selected").attr('data-demand');
            $('#demand').val(demand);
            $('#package').val('');
            $('#discount').val('');
        });
        jQuery("#package").keyup(function () {
            var package = $(this).val();
            var demand = $("#class option:selected").attr('data-demand');
            $('#discount').val(demand - package);
            console.log(demand - package);
        });
        jQuery("#cancel").click(function () {
            // $("#region").select2().val(null).trigger("change");
            // $("#region > option").removeAttr('selected');
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(".edit").click(function () {
            var title = jQuery(this).parent('tr').attr("data-title");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var region_id = jQuery(this).parent('tr').attr("data-region_id");
            jQuery("#title").val(title);
            jQuery("#branch_id").val(session_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {
            var region_id = jQuery(this).attr("data-region_id");
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function (result) {
                if (result.value) {
                    jQuery("#branch_id").val(branch_id);
                    jQuery("#delete").submit();
                } else {
                }
            });
        });
    </script>
@endsection
