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
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('student_dashboard') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('store_student') }}" method="post"
                  onsubmit="return checkForm() " enctype="multipart/form-data">
                @csrf
                <div class="row">
{{--                    <div class="form-group col-lg-3 col-md-3 col-sm-12">--}}
{{--                        <div class="input_bx">--}}
{{--                            <!-- start input box -->--}}
{{--                            <label class="required">--}}
{{--                                Registration No--}}
{{--                            </label>--}}
{{--                            <input class="form-control" id="reg_no" autofocus data-rule-required="true"--}}
{{--                                   data-msg-required="Please Enter Registration No" autocomplete="off" name="reg_no"--}}
{{--                                   type="text" placeholder="Enter your Registration No" value="{{ $reg_no }}"--}}
{{--                                   readonly/>--}}
{{--                            <span id="demo1" class="validate_sign"> </span>--}}
{{--                        </div><!-- end input box -->--}}
{{--                    </div>--}}
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Full Name
                            </label>
                            <input class="form-control" tabindex="1" id="full_name" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Full Name" autocomplete="off" name="full_name"
                                   type="text" placeholder="Enter your Full Name" value="{{ old('full_name') }}"/>
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
                                   type="text" placeholder="Enter your Father Name" value="{{ old('father_name') }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="">
                                Father Contact
                            </label>
                            <input class="form-control  @error('parentContact') is-invalid @enderror" tabindex="3"
                                   id="parentContact"
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
                            <label for="contact" class="required">Student Contact</label>
                            <input class="form-control" tabindex="4" id="contact" name="contact" type="text"
                                   data-rule-required="true" data-msg-required="Please Enter Contact"
                                   placeholder="03*********"
                                   value="{{ old('contact') }}"/>
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
                                   value="{{ old('dob') }}"/>
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
                                Admission Date
                            </label>
                            <input tabindex="7" type="text" name="admission_date" id="admission_date"
                                   class="inputs_up form-control datepicker1" autocomplete="off"
                                   data-rule-required="true"
                                   data-msg-required="Please Enter Admission Date" placeholder="Admission Date"
                                   value="{{ old('admission_date') }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class</label>
                            <select tabindex="8" name="class" class="inputs_up form-control"
                                    data-rule-required="true" data-msg-required="Please Enter Class" id="class">
                                <option value="">Select Class</option>
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
                            <label for="email" class="">Email</label>
                            <input class="form-control" tabindex="11" id="email" name="email" type="email"
                                   {{-- data-rule-required="true" data-msg-required="Please Enter Email" --}} placeholder="name@example.com"
                                   value="{{ old('email') }}"/>
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
                            <input id="father_cnic" tabindex="12" type="text" class="form-control" name="father_cnic"
                                   {{-- data-rule-required="true" data-msg-required="Please Enter Father CNIC" --}} value="{{ old('father_cnic') }}"
                                   placeholder="03***-********-1">
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="cnic">CNIC<span class="">*</span></label>
                            <input id="cnic" type="text" tabindex="13" class="form-control"
                                   {{-- data-rule-required="true" data-msg-required="Please Enter CNIC"  --}}
                                   name="cnic" value="{{ old('cnic') }}" placeholder="03***-********-1">
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="">
                                City
                            </label>
                            <input class="form-control" tabindex="14" id="city" name="city" type="text"
                                   placeholder="Enter your City"
                                   value="{{ old('city') }}" {{-- data-rule-required="true" --}}
                                {{-- data-msg-required="Please Enter City"  --}} />
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="">
                                Metric Marks
                            </label>
                            <input class="form-control" tabindex="15" id="metric_marks" name="metric_marks"
                                   type="number"
                                   placeholder="Enter your Metric Marks"
                                   {{-- data-rule-required="true" data-msg-required="Please Enter 10th Marks"  --}}
                                   value="{{ old('metric_marks') }}"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="">
                                School</label>
                            <select tabindex="16" name="school" class="inputs_up form-control"
                                    {{-- data-rule-required="true" data-msg-required="Please Enter School"  --}}
                                    id="school">
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
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="">
                                Reference
                            </label>
                            <input class="form-control" tabindex="17" id="reference" name="reference" type="text"
                                   placeholder="Enter your Reference" value="{{ old('reference') }}"
                                {{-- data-rule-required="true" data-msg-required="Please Enter Reference" --}} />
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label for="fullName">Hostel</label>
                            <select id="hostel" tabindex="18" type="text" class="form-control" name="hostel">
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
                            <select id="zakat" tabindex="19" type="text" class="form-control" name="zakat">
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
                            <select id="transport" tabindex="20" type="text" class="form-control" name="transport">
                                <option value=" " disabled>Select Transport</option>
                                <option value="Yes" selected>Used</option>
                                <option value="No">Not Used</option>
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
                                <option value="" disabled selected>Select Bus Route</option>
                                @foreach($routes as $route)
                                    <option value="{{$route->tr_id}}">{{$route->tr_title}}</option>
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
                                <option value="" disabled selected>Select Bus Route Type</option>
                                <option value="1">Single Route Amounts</option>
                                <option value="2" >Double Route Amounts</option>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">College Announced Package</label>
                            <input tabindex="21" type="text" name="demand" id="demand"
                                   data-rule-required="true" data-msg-required="Please Enter Demand"
                                   value="{{ old('demand') }}" class="inputs_up form-control" placeholder="Demand"
                                   onfocus="this.select();"
                                   onkeypress="return allow_only_number_and_decimals(this,event);"
                                   readonly>
                            <span id="commission_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Booked Package</label>
                            <input tabindex="22" type="text" name="package" id="package"
                                   data-rule-required="true" data-msg-required="Please Enter Package"
                                   value="{{ old('package') }}" class="inputs_up form-control" placeholder="Package"
                                   onfocus="this.select();"
                                   onkeypress="return allow_only_number_and_decimals(this,event);">
                            <span id="commission_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Discount</label>
                            <input tabindex="23" type="text" name="discount" id="discount"
                                   data-rule-required="true" data-msg-required="Please Enter Discount"
                                   value="{{ old('discount') }}" class="inputs_up form-control" placeholder="Demand"
                                   onfocus="this.select();"
                                   onkeypress="return allow_only_number_and_decimals(this,event);"
                                   readonly>
                            <span id="commission_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="">Uplaod Form PDF</label>
                            <input tabindex="23" type="file" name="file" id="file"
                                   data-rule-required="true" data-msg-required="Please Enter Pdf File"
                                   value="{{ old('file') }}" class="inputs_up form-control" placeholder="Demand"
                                   >
                            <div id="message"  style="display: none;" >Attached Only Pdf file</div>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Address
                            </label>
                            <textarea tabindex="24" name="address" id="address" class="remarks inputs_up form-control"
                                      placeholder="Address"
                                      data-rule-required="true" data-msg-required="Please Enter Address"
                                      style="height: 107px;">{{ old('address') }}</textarea>
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
                group_id = document.getElementById("group"),
                section_id = document.getElementById("section"),
                packages = document.getElementById("package"),
                validateInputIdArray = [
                    full_name.id,
                    gender.id,
                    father_name.id,
                    admission_date.id,
                    class_id.id,
                    group_id.id,
                    section_id.id,
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
            $('#transport').change(function(){
                    if($(this).val() == 'Yes')
                {
                        $('#r_type').show();
                        $('#b_route').show();
                }else{
                        $('#r_type').hide();
                        $('#b_route').hide();
                    }
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


        jQuery("#cancel").click(function () {
            $("#search").val('');
        });
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
