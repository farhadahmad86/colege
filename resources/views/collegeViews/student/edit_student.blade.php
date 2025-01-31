@extends('extend_index')
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Edit Student</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('student_dashboard') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('update_student') }}" method="post"
                  onsubmit="return checkForm()" enctype="multipart/form-data">
                @csrf
                <input class="form-control" id="id" name="id" type="hidden" value="{{ $student->id }}"
                       readonly/>
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Registration No
                            </label>
                            <input class="form-control" id="reg_no" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Registration No" autocomplete="off" name="reg_no"
                                   type="text" placeholder="Enter your Registration No"
                                   value="{{ $student->registration_no }}" readonly/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Full Name
                            </label>
                            <input class="form-control" tabindex="1" id="full_name" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Full Name" autocomplete="off" name="full_name"
                                   type="text" placeholder="Enter your Full Name" value="{{ $student->full_name }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Father Name
                            </label>
                            <input class="form-control" tabindex="2" id="father_name" data-rule-required="true"
                                   data-msg-required="Please Enter Father Name" autocomplete="off" name="father_name"
                                   type="text" placeholder="Enter your Father Name"
                                   value="{{ $student->father_name }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Father Contact
                            </label>
                            <input class="form-control @error('parentContact') is-invalid @enderror" tabindex="3"
                                   id="parentContact"
                                   name="parentContact" type="text" placeholder="Father Contact"
                                   value="{{ $student->parent_contact }}" data-rule-required="true"
                                   data-msg-required="Please Enter Father Contact"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="contact" class="required">Student Contact</label>
                            <input class="form-control" tabindex="4" id="contact" name="contact" type="text"
                                   data-rule-required="true" data-msg-required="Please Enter Contact"
                                   placeholder="03*********"
                                   value="{{ $student->contact }}"/>
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
                            <input tabindex="5" type="text" name="dob" id="dob"
                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                   placeholder="Date of Birth"
                                   data-rule-required="true" data-msg-required="Please Enter Date Of Birth"
                                   value="{{ $student->dob }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>

                    <!-- start input box -->
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="gender" class="required">Gender</label>
                            <select id="gender" tabindex="6" type="text" class="form-control" name="gender"
                                    data-rule-required="true" data-msg-required="Please Enter Gender">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ 'Male' == $student->gender ? 'selected' : '' }}>Male
                                </option>
                                <option value="Female" {{ 'Female' == $student->gender ? 'selected' : '' }}>Female
                                </option>
                                <option value="Other" {{ 'Other' == $student->gender ? 'selected' : '' }}>Other</option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Admission Date
                            </label>
                            <input tabindex="7" type="text" name="admission_date" id="admission_date"
                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                   data-rule-required="true"
                                   data-msg-required="Please Enter Admission Date" placeholder="Admission Date"
                                   value="{{ $student->admission_date }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    {{-- <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" disabled>
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class</label>
                            <select tabindex="8" name="class" class="inputs_up form-control"
                                data-rule-required="true" data-msg-required="Please Enter Class" id="class" disabled>
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->class_id }}" data-demand="{{ $class->class_demand }}"
                                        {{ $class->class_id == $student->class_id ? 'selected' : '' }}>
                                        {{ $class->class_name }}</option>
                                @endforeach
                            </select>
                            <span id="role_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12" >
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Group

                            </label>
                            <select tabindex="9" autofocus name="group" class="form-control required" id="group"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Group">
                            </select disabled>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12" disabled>
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Section
                            </label>
                            <select tabindex="10" autofocus name="section" class="form-control required" id="section"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Group" disabled>
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div> --}}
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="email" class="required">Email</label>
                            <input class="form-control" tabindex="11" id="email" name="email" type="email"
                                   data-rule-required="true" data-msg-required="Please Enter Email"
                                   placeholder="name@example.com" value="{{ $student->email }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="cnic">CNIC<span class="required">*</span></label>
                            <input id="cnic" tabindex="12" type="text" class="form-control" data-rule-required="true"
                                   data-msg-required="Please Enter CNIC" name="cnic" value="{{ $student->cnic }}"
                                   placeholder="03***-********-1">
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
                            <input id="father_cnic" tabindex="13" type="text" class="form-control" name="father_cnic"
                                   data-rule-required="true" data-msg-required="Please Enter Father CNIC"
                                   value="{{ $student->father_cnic }}" placeholder="03***-********-1">
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                City
                            </label>
                            <input class="form-control" tabindex="14" id="city" name="city" type="text"
                                   placeholder="Enter your City" value="{{ $student->city }}" data-rule-required="true"
                                   data-msg-required="Please Enter City"/>
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
                            <input class="form-control" tabindex="15" id="metric_marks" name="metric_marks"
                                   type="number"
                                   placeholder="Enter your Metric Marks" data-rule-required="true"
                                   data-msg-required="Please Enter 10th Marks" value="{{ $student->metric_marks }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                School</label>
                            <select tabindex="16" name="school" class="inputs_up form-control"
                                    data-rule-required="true" data-msg-required="Please Enter School" id="school">
                                <option value="">Select School</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->sch_id }}"
                                        {{ $school->sch_id == $student->school_id ? 'selected' : '' }}>
                                        {{ $school->sch_name }}</option>
                                @endforeach
                            </select>
                            <span id="role_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Reference
                            </label>
                            <input class="form-control" tabindex="17" id="reference" name="reference" type="text"
                                   placeholder="Enter your Reference" value="{{ $student->reference }}"
                                   data-rule-required="true" data-msg-required="Please Enter Reference"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="fullName">Hostel</label>
                            <select id="hostel" tabindex="18" type="text" class="form-control" name="hostel">
                                <option value="No" {{ $student->hostel == 'No' ? 'selected' : '' }}>No Used</option>
                                <option value="Yes" {{ $student->hostel == 'Yes' ? 'selected' : '' }}>Used</option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="fullName">Special Student</label>
                            <select id="zakat" tabindex="18" type="text" class="form-control" name="zakat">
                                <option value="No" {{ $student->hostel == 'No' ? 'selected' : '' }}>No Used</option>
                                <option value="Yes" {{ $student->hostel == 'Yes' ? 'selected' : '' }}>Zakat</option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="transport">Use Transport</label>
                            <select id="transport" tabindex="19" type="text" class="form-control" name="transport">
                                <option value="">Select Transport</option>
                                <option value="Yes" {{ $student->transport == 'Yes' ? 'selected' : '' }}>Used</option>
                                <option value="No" {{ $student->transport == 'No' ? 'selected' : '' }}>Not Used</option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" id="b_route">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="transport">Bus Route</label>
                            <select id="route_id" tabindex="20" type="text" class="form-control" name="route_id">
                                <option value="" {{ $student->route_id == ' ' ? 'selected' : '' }}>Select Bus Route
                                </option>
                                @foreach($routes as $route)
                                    <option
                                        value="{{$route->tr_id}}"{{ $student->route_id == $route->tr_id ? 'selected' : '' }} >{{$route->tr_title}}</option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" id="r_type">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="transport">Bus Route Type</label>
                            <select id="route_type" tabindex="20" type="text" class="form-control" name="route_type">
                                <option value="" {{ $student->route_type == ' ' ? 'selected' : '' }}>Select Bus Route
                                    Type
                                </option>
                                <option value="1" {{ $student->route_type == '1' ? 'selected' : '' }}>Single Route
                                    Amount
                                </option>
                                <option value="2" {{ $student->route_type == '2' ? 'selected' : '' }}>Double Route
                                    Amount
                                </option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Upload Form PDF</label>

                            <!-- Show existing file (if available) -->
                            @if($student->form_pdf)
                                <div>Current File: <a href="{{
    ($student->form_pdf) }}" target="_blank">View PDF</a></div>
                            @endif

                            <input tabindex="23" type="file" name="file" id="file"
                                   data-rule-required="true" data-msg-required="Please upload a PDF file"
                                   class="inputs_up form-control" placeholder="Demand"
                            >
                            <div id="message" style="display: none;">Attach Only PDF file</div>
                        </div><!-- end input box -->
                    </div>
{{--                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">--}}
{{--                        <div class="input_bx">--}}
{{--                            <!-- start input box -->--}}
{{--                            <label class="required">Uplaod Form PDF</label>--}}
{{--                            <input tabindex="23" type="file" name="file" id="file"--}}
{{--                                   data-rule-required="true" data-msg-required="Please Enter Pdf File"--}}
{{--                                   value="{{ $student->form_pdf }}" class="inputs_up form-control" placeholder="Demand"--}}
{{--                            >--}}
{{--                            <div id="message"  style="display: none;" >Attached Only Pdf file</div>--}}
{{--                        </div><!-- end input box -->--}}
{{--                    </div>--}}
                    {{-- <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" disabled>
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Demand</label>
                            <input tabindex="20" type="text" name="demand" id="demand"
                                data-rule-required="true" data-msg-required="Please Enter Demand"
                                value="{{ $student->demand }}" class="inputs_up form-control" placeholder="Demand"
                                onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"
                                readonly>
                            <span id="commission_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" disabled>
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">College Announced Package</label>
                            <input tabindex="21" type="text" name="package" id="package"
                                data-rule-required="true" data-msg-required="Please Enter Package"
                                value="{{ $student->package }}" class="inputs_up form-control" placeholder="Package"
                                onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);">
                            <span id="commission_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12" disabled>
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Discount</label>
                            <input tabindex="22" type="text" name="discount" id="discount"
                                data-rule-required="true" data-msg-required="Please Enter Discount"
                                value="{{ $student->discount }}" class="inputs_up form-control" placeholder="Demand"
                                onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"
                                readonly >
                            <span id="commission_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div> --}}
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Address
                            </label>
                            <textarea tabindex="23" name="address" id="address" class="remarks inputs_up form-control"
                                      placeholder="Address"
                                      data-rule-required="true" data-msg-required="Please Enter Address"
                                      style="height: 107px;">{{ $student->address }}</textarea>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-6 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                   data-placement="bottom" data-html="true"
                                   data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.configurations.company_info.profile_image.description') }}</p>">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                Profile Image</label>
                            <input type="file" name="pimage" id="pimage" class="inputs_up form-control"
                                   data-rule-required="true" data-msg-required="Please Choose Image"
                                   accept=".png,.jpg,.jpeg"
                                   style="width: 100px !important; background-color: #eee; border:none; box-shadow: none !important; display: none;"
                                   value="{{ $student->profile_pic }}">
                            <span id="demo8" class="validate_sign"> </span>


                            <div style="float: left;">

                                <div style="float: right">
                                    <label id="image1"
                                           style="display: none; cursor:pointer; color:blue; text-decoration:underline;">
                                        <i style=" color:#04C1F3" class="fa fa-window-close"></i>
                                    </label>
                                </div>
                                <div>
                                    <img id="imagePreview1"
                                         style="border-radius:50%; position:relative; cursor:pointer;  width: 100px; height: 100px;"
                                         src="{{ $student->profile_pic }}"/>
                                </div>
                            </div>
                        </div><!-- end input box -->
                    </div>
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
        </div>
    </div>
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {

            let full_name = document.getElementById("full_name"),
                contact = document.getElementById("contact"),
                dob = document.getElementById("dob"),
                father_name = document.getElementById("father_name"),
                admission_date = document.getElementById("admission_date"),
                class_id = document.getElementById("class"),
                packages = document.getElementById("package"),
                validateInputIdArray = [
                    full_name.id,
                    gender.id,
                    father_name.id,
                    admission_date.id,
                    class_id.id,
                    packages.id,
                ];
            var check = validateInventoryInputs(validateInputIdArray);
            if(check == true)
            {
                var fileInput = document.getElementById('file');
                var filePath = fileInput.value;

                // Check if any file is selected.
                if (fileInput.files.length > 0) {
                    var file = fileInput.files[0];

                    // Check the file type
                    if (file.type !== "application/pdf") {
                        document.getElementById('message').style = 'display';
                        document.getElementById('message').style.color = 'red';
                        return false;

                        // Stop the form from submitting
                    }else if(file.size > 0.5 * 1024)
                    {
                        document.getElementById('message').style = 'display';
                        document.getElementById('message').textContent = 'File Must be less than or equal to 512kb';
                        document.getElementById('message').style.color = 'red';
                        return false;
                    }
                }
            }else{
                return validateInventoryInputs(validateInputIdArray);
            }
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
        jQuery('#branch').select2();
    </script>
    {{--    add code by shahzaib end --}}
    <script></script>

    <script>

        function route_fields(transport) {
            if ( transport == 'Yes') {
                $('#r_type').show();
                $('#b_route').show();
            }else{
                $('#r_type').hide();
                $('#b_route').hide();
            }
        }

        $(document).ready(function () {
            route_fields('{{ $student->transport }}');

            $('#transport').change(function () {
                var transport = $(this).val();
                route_fields(transport);
            });
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

        $('#class').change(function () {
            var class_id = $(this).val();
            var cs_id = '';
            var ng_id = '';
            get_group_or_section(class_id, cs_id, ng_id);
        });
        function get_group_or_section(class_id, cs_id, ng_id) {

            $.ajax({
                url: '/get_groups',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function (data) {
                    console.log(data);
                    var groups = '<option selected disabled hidden>Choose Groups</option>';
                    var sections = '<option selected disabled hidden>Choose Section</option>';

                    $.each(data.groups, function (index, items) {
                        // var selected='';
                        //     if(items.ng_id == {!! $student->group_id !!}){
                        //         selected="selected";
                        //     }
                        groups +=
                            // `<option value="${items.ng_id}" ${selected} > ${items.ng_name} </option>`;
                            `<option value="${items.ng_id}"  ${items.ng_id == ng_id ? 'selected' : 'Choose Groups'}> ${items.ng_name} </option>`;


                    });
                    $.each(data.section, function (index, items) {
                        // var selected='';
                        // if(items.cs_id == {!! $student->section_id !!}){
                        //     selected="selected";
                        // }
                        sections +=
                            `<option value="${items.cs_id}"  ${items.cs_id == cs_id ? 'selected' : 'Choose Section'}> ${items.cs_name} </option>`;
                        // `<option value="${items.cs_id}" ${selected}> ${items.cs_name} </option>`;


                    });
                    $('#group').html(groups);
                    $('#section').html(sections);
                }
            })
        }
    </script>

    <script>
        jQuery("#imagePreview1").click(function () {
            jQuery("#pimage").click();
        });
        var image1RemoveBtn = document.querySelector("#image1");
        var imagePreview1 = document.querySelector("#imagePreview1");


        $(document).ready(function () {
            $('#pimage').change(function () {
                var file = this.files[0],
                    val = $(this).val().trim().toLowerCase();
                if (!file || $(this).val() === "") {
                    return;
                }

                var fileSize = file.size / 1024 / 1024,
                    regex = new RegExp("(.*?)\.(jpeg|png|jpg)$"),
                    errors = 0;

                if (fileSize > 2) {
                    errors = 1;

                    document.getElementById("demo8").innerHTML = "Only png.jpg,jpeg files & max size:2 mb";
                }
                if (!(regex.test(val))) {
                    errors = 1;

                    document.getElementById("demo8").innerHTML = "Only png.jpg,jpegs files & max size:2 mb";
                }

                var fileInput = document.getElementById('pimage');
                var reader = new FileReader();

                if (errors == 1) {
                    $(this).val('');

                    image1RemoveBtn.style.display = "none";
                    document.getElementById("imagePreview1").src = 'public/src/upload_btn.jpg';

                } else {

                    image1RemoveBtn.style.display = "block";
                    imagePreview1.style.display = "block";

                    reader.onload = function (e) {
                        document.getElementById("imagePreview1").src = e.target.result;
                    };
                    reader.readAsDataURL(fileInput.files[0]);

                    document.getElementById("demo8").innerHTML = "";
                }
            });
        });


        image1RemoveBtn.onclick = function () {

            var pimage = document.querySelector("#pimage");
            pimage.value = null;
            var pimagea = document.querySelector("#imagePreview1");
            pimagea.value = null;
            image1RemoveBtn.style.display = "none";
            //imagePreview1.style.display = "none";
            document.getElementById("imagePreview1").src = "public/src/upload_btn.jpg";

        }
    </script>
@endsection
