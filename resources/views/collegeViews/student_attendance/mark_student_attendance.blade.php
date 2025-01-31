@extends('extend_index')

@section('content')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet"> --}}
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Attendance</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <a class="add_btn list_link add_more_button" href="{{ route('student_attendance_list') }}"
                           role="button">
                            <i class="fa fa-list"></i> view list
                        </a>

                        <a class="add_btn list_link add_more_button"
                           href="{{ route('monthly_attendance_list') }}" role="button">
                            <i class="fa fa-list"></i> Monthly Report List
                        </a>
                    </div><!-- list btn -->
                    {{-- <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('student_attendance_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            
                        </a>
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('monthly_attendance_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            
                        </a>
                    </div><!-- list btn --> --}}
                </div>
            </div><!-- form header close -->


            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('mark_student_attendance') }}" name="form1"
                    id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                            <div class="input_bx">
                                <!-- start input box -->
                                <label class="required">
                                    Class
                                </label>
                                <select tabindex="1" autofocus name="class_id" class="inputs_up form-control class_id"
                                    id="class" autofocus data-rule-required="true"
                                    data-msg-required="Please Enter Class">
                                    <option value="">Select Class</option>

                                    @foreach ($classes as $class)
                                        <option value="{{ $class->class_id }}"
                                            {{ $class->class_id == $search_class ? 'selected' : '' }}>
                                            {{ $class->class_name }}
                                        </option>
                                    @endforeach

                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-12">
                            <div class="input_bx">
                                <!-- start input box -->
                                <label class="required">
                                    Section
                                </label>
                                <select tabindex="2" autofocus name="section_id" class="form-control required"
                                    id="section" autofocus data-rule-required="true"
                                    data-msg-required="Please Enter Section">
                                    <option value="" selected>Choose Section</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->cs_id }}"
                                            {{ $section->cs_id == $search_section ? 'selected' : '' }}>
                                            {{ $section->cs_name }}</option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-1 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    Month
                                </label>
                                <input tabindex="3" type="text" name="month" id="month"
                                    class="inputs_up form-control month-picker" autocomplete="off" <?php if(isset($search_month)){?>
                                    value="{{ $search_month }}" <?php } ?> placeholder="Start Month ......">

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <!-- left column ends here -->
                        <div class="col-lg-6 col-md-9 col-sm-12 col-xs-12 text-right form_controls mt-3">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('mark_student_attendance') }}" />

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>

            </div>

            <!-- invoice box start -->
            <form name="f1" class="f1" id="f1" action="{{ route('store_student_attendance') }}"
                method="post" onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class
                            </label>
                            <select tabindex="4" autofocus name="class_id" class="inputs_up form-control" id="class_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Class">
                                <option value="">Select Class</option>

                                @foreach ($classes as $class)
                                    <option value="{{ $class->class_id }}"
                                        {{ $class->class_id == $search_class ? 'selected' : '' }}>
                                        {{ $class->class_name }}
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
                                Section
                            </label>
                            <select tabindex="5" autofocus name="section_id" class="form-control required" id="section_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Section">
                                <option value="" selected>Choose Section</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->cs_id }}"
                                        {{ $section->cs_id == $search_section ? 'selected' : '' }}>
                                        {{ $section->cs_name }}</option>
                                @endforeach
                            </select>
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
                                >
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
                                    $sr = 1;
                                @endphp

                                @foreach ($datas as $data)
                                    <tr>
                                        <td class="tbl_txt_5">{{ $sr++ }} </td>
                                        <td class="tbl_txt_5">{{ $data->roll_no }} </td>
                                        <td class="tbl_txt_20">{{ $data->full_name }} </td>
                                        <td class="tbl_txt_15">{{ $data->father_name }} </td>
                                        <td class="tbl_txt_5"><input type="radio"
                                                name="attendance[{{ $data->id }}]" id="P" value="P"
                                                checked> </td>
                                        <td class="tbl_txt_5"><input type="radio"
                                                name="attendance[{{ $data->id }}]" id="A" value="A">
                                        </td>
                                        <td class="tbl_txt_5"><input type="radio"
                                                name="attendance[{{ $data->id }}]" id="L" value="L">
                                        </td>
                                        <td class="tbl_txt_40"><input type="text" name="leave_details[]"
                                                style="width:100%"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
            // let class_id = {!! $search_class !!}
            // get_section(class_id);
        });


        function checkForm() {
            let attendance_date = document.getElementById("attendance_date"),
                validateInputIdArray = [
                    section_id.id,
                    class_id.id,
                    attendance_date.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
        // $('#class_id').change(function() {
        //     var class_id = $(this).children('option:selected').val();
        //     $.ajax({
        //         url: '/get_groups',
        //         type: 'get',
        //         datatype: 'text',
        //         data: {
        //             'class_id': class_id
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             var groups = '<option selected disabled hidden>Choose Groups</option>';
        //             var sections = '<option selected disabled hidden>Choose Section</option>';


        //             $.each(data.section, function(index, items) {

        //                 sections +=
        //                     `<option value="${items.cs_id}"> ${items.cs_name} </option>`;
        //             });
        //             $('#section_id').html(sections);
        //         }
        //     })
        // });
        $('.class_id').change(function() {

            var class_id = $(this).children('option:selected').val();
            get_section(class_id);
        });

        function get_section(class_id) {


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

                    $('#section').html(sections);
                }
            })

        }

        // $('#section_id').change(function() {
        //     var section_id = $(this).val();
        //     var class_id = $('#class_id').val();
        //     $.ajax({
        //         url: '/get_student',
        //         type: 'get',
        //         datatype: 'text',
        //         data: {
        //             'section_id': section_id,
        //             'class_id': class_id
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             $('#table_body').html("");
        //             var student = '';
        //             var std_sr = 1;
        //             data.forEach(element => {
        //                 student +=
        //                     `<tr>
        //                         <td class="tbl_srl_5" >${std_sr++}</td>
        //                         <td class="tbl_srl_5"  value="${element.id}">${element.roll_no} <input type="hidden" name="roll_no[]" id="roll_no" value="${element.id}"> </td>
        //                         <td class="tbl_srl_35"  value="${element.id}">${element.full_name} <input type="hidden" name="student_id[]" id="student_id" value="${element.id}"> </td>
        //                         <td class="tbl_srl_5"><input type="radio" name="attendance[${element.id}]" id="P" value="P" checked>
        //                             </td><td class="tbl_srl_5"><input type="radio" name="attendance[${element.id}]" id="A" value="A"></td>
        //                         <td class="tbl_srl_5"><input type="radio" name="attendance[${element.id}]" id="L" value="L"></td>
        //                         <td class="tbl_srl_40"><input type="text" name="leave_remarks[]" id="leave_remarks" style="width:100%"></td>
        //                     </tr>`;
        //             });
        //             $('#table_body').html(student);
        //         }
        //     })
        // });
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
