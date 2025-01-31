@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Class</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('class_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('store_class') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class
                            </label>
                            <input tabindex="1" type="text" name="name" id="name" class="form-control"
                                placeholder="Class Name" autofocus data-rule-required="true"
                                data-msg-required="Please Enter Class Name" autocomplete="off" value="{{ old('name') }}"
                                readonly />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Degree
                            </label>
                            <select tabindex="1" autofocus name="degree" class="form-control required" id="degree"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Degree"
                                onchange="creatClass()">
                                <option value="" selected disabled>Select Degree</option>
                                @foreach ($degree as $degrees)
                                    <option value="{{ $degrees->degree_id }}"
                                        {{ $degrees->degree_id == old('degree') ? 'selected' : '' }}>
                                        {{ $degrees->degree_name }}
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
                                Program
                            </label>
                            <select tabindex="1" autofocus name="program" class="form-control required" id="program"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Class Incharge"
                                onchange="creatClass()">
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Session
                            </label>
                            <select tabindex="1" autofocus name="session" class="form-control required" id="session"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Session"
                                onchange="creatClass()">
                                <option value="" selected disabled>Select Session</option>
                                @foreach ($sessions as $session)
                                    <option value="{{ $session->session_id }}"
                                        {{ $session->session_id == old('session') ? 'selected' : '' }}>
                                        {{ $session->session_name }}
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
                                Demand
                            </label>
                            <input tabindex="1" type="text" name="demand" id="demand" class="form-control"
                                placeholder="demand" autofocus data-rule-required="true"
                                data-msg-required="Please Enter demand" autocomplete="off" value="{{ old('demand') }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="invoice_col_bx">
                            <div class=" invoice_col_ttl">
                                <label class="form-check-label" for="post">
                                    Attendance
                                </label>
                            </div>
                            <div class="custom-control custom-radio ml-2">
                                <input class="form-check-input" type="radio" name="attendance" value="Daily"
                                    id="daily" {{ old('Daily') == 'Daily' ? 'checked' : '' }}>
                                <label class="form-check-label" for="Daily">
                                    Daily
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="form-check-input " type="radio" name="attendance" value="Lecture"
                                    id="lecture" {{ old('Lecture') == 'Lecture' ? 'checked' : '' }}>
                                <label class="form-check-label" for="Lecture">
                                    Lecture
                                </label>
                            </div>
                        </div>
                        <span class="text-danger" id="error_attendance"
                            style="font-size: 12px;font-weight: bold;"></span>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="invoice_col_bx">
                            <div class=" invoice_col_ttl">
                                <label class="form-check-label" for="post">
                                    Class Type
                                </label>
                            </div>
                            <div class="custom-control custom-radio ml-2">
                                <input class="form-check-input" type="radio" name="class_type" value="Annual"
                                    id="annual" {{ old('Annual') == 'Annual' ? 'checked' : '' }}>
                                <label class="form-check-label" for="Annual">
                                    Annual
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="form-check-input " type="radio" name="class_type" value="SemesterWise"
                                    id="semesterwise" {{ old('SemesterWise') == 'SemesterWise' ? 'checked' : '' }}>
                                <label class="form-check-label" for="SemesterWise">
                                    Semester Wise
                                </label>
                            </div>
                        </div>
                        <span class="text-danger" id="error_attendance"
                            style="font-size: 12px;font-weight: bold;"></span>
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
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let name = document.getElementById("name"),
                degree = document.getElementById("degree"),
                program = document.getElementById("program"),
                session = document.getElementById("session"),
                demand = document.getElementById("demand"),
                validateInputIdArray = [
                    name.id,
                    degree.id,
                    program.id,
                    session.id,
                    demand.id,
                    // class_incharge_id.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
        //// Burhan /////
        function creatClass() {
            let degree = document.getElementById('degree');
            let selecteddegree = degree.options[degree.selectedIndex].text;
            selecteddegree = ((degree.value == 0) ? "" : selecteddegree);
            let program = document.getElementById('program');
            let selectedprogram = program.options[program.selectedIndex].text;
            selectedprogram = ((program.value == 0) ? "" : selectedprogram);
            let session = document.getElementById('session');
            let selectedsession = session.options[session.selectedIndex].text;
            selectedsession = ((session.value == 0) ? "" : selectedsession);
            document.getElementById('name').value = selecteddegree + '-' + selectedprogram + '-' + selectedsession;
        }
        $('#degree').change(function() {
            var deg_id = $(this).children('option:selected').val();
            $.ajax({
                url: '/get_program',
                type: 'get',
                datatype: 'text',
                data: {
                    'deg_id': deg_id
                },
                success: function(data) {
                    console.log(data);
                    var program = '<option selected disabled hidden>Choose Program</option>';

                    data.forEach(element => {

                        program +=
                            `<option value="${element.program_id}"> ${element.program_name} </option>`;

                    });
                    $('#program').html(program);
                }
            })
        });
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        $(document).ready(function() {
            $('#degree').select2();
            $('#program').select2();
            $('#session').select2();
        });
    </script>
@endsection
