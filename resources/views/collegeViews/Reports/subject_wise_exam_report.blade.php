@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Subject Wise Student Analysis Report</h4>
                    </div>

                </div>
            </div><!-- form header close -->


            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('subject_wise_exam_report') }}" name="form1"
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
                                        id="class_id" autofocus data-rule-required="true"
                                        data-msg-required="Please Enter Class">
                                    <option value="">Select Class</option>

                                    @foreach ($classes as $class)
                                        <option value="{{ $class->class_id }}"
                                            {{$class_id == $class->class_id ? "selected" : ""  }}>
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
                                <select tabindex="2" autofocus name="section" class="form-control required"
                                        id="section" autofocus data-rule-required="true"
                                        data-msg-required="Please Enter Section">
                                    <option value="" selected>Choose Section</option>
                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                            <div class="input_bx">
                                <!-- start input box -->
                                <label class="required">
                                    Subjects
                                </label>
                                <select tabindex="2" autofocus name="subject_id" class="form-control required"
                                        id="subject_id" autofocus data-rule-required="true"
                                        data-msg-required="Please Enter Section">
                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div>
                        </div>
                        <!-- left column ends here -->
                        <div class="col-lg-3 col-md-9 col-sm-12 col-xs-12 text-right form_controls mt-3">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            {{--                            <x-add-button tabindex="9" href="{{ route('store_student_attendance') }}"/>--}}

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>

            </div>
            <!-- invoice box start -->
            <div class="form-group row">
                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="category_dynamic_table">
                        <!-- product table box start -->
                        <tr>
                            <th class="text-center tbl_txt_4">Sr#</th>
                            <th class="text-center tbl_txt_4">Roll No</th>
                            <th class="text-center tbl_txt_22">Students</th>
                            <th class="text-center tbl_txt_6">Matric Marks</th>
                            <th class="text-center tbl_txt_4" colspan="2">Total Marks</th>
                            <th class="text-center tbl_txt_4" colspan="2">Obtained Marks</th>
                            <th class="text-center tbl_txt_4" colspan="2">Total Marks</th>
                            <th class="text-center tbl_txt_4" colspan="2">Obtained Marks</th>
                            <th class="text-center tbl_txt_4" colspan="2">Total Marks</th>
                            <th class="text-center tbl_txt_4" colspan="2">Obtained Marks</th>
                            <th class="text-center tbl_txt_4" colspan="2">Total Marks</th>
                            <th class="text-center tbl_txt_4" colspan="2">Obtained Marks</th>
                            <th class="text-center tbl_txt_4" colspan="2">Total Marks</th>
                            <th class="text-center tbl_txt_4" colspan="2">Obtained Marks</th>
                        </tr>
                        <thead>
                        <tr>
                            <th colspan="4"></th>
                            @foreach($exams_names as $name)
                                <th colspan="4" class="text-center tbl_txt_15"> {{
                                           str_replace(['Round-', 'Test#'], ['R-', 'T#'], $name->exam_name)
                                           . ' ' . str_replace(' ', '', $name->exam_year)
                                       }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody id="table_body">
                        @php

                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                           $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                           $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                           $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @foreach ($students as $student)
                            <tr>
                                <td class="tbl_txt_5">{{ $sr++ }} </td>
                                <td class="tbl_txt_5">{{ $student->roll_no }} </td>
                                <td class="tbl_txt_20">{{ $student->full_name }} </td>
                                <td class="tbl_txt_20">{{ $student->marks_10th }} </td>
                                @php
                                    $clg0 = json_decode($clg0_positions, true);
                                    $clg1 = json_decode($clg1_positions, true);
                                    $clg2 = json_decode($clg2_positions, true);
                                    $clg3 = json_decode($clg3_positions, true);
                                    $clg4 = json_decode($clg4_positions, true);
                                @endphp
                                @foreach ($clg4 as $key => $value)
                                    @if ($value['id'] == $student->id)
                                        <td colspan="2">
                                            {{ $value['total_marks'] }}
                                        </td>
                                        <td colspan="2">
                                            {{ $value['obtain'] }}
                                        </td>
                                    @endif
                                @endforeach
                                @foreach ($clg3 as $key => $value)
                                    @if ($value['id'] == $student->id)
                                        <td colspan="2">
                                            {{ $value['total_marks'] }}
                                        </td>
                                        <td colspan="2">
                                            {{ $value['obtain'] }}
                                        </td>
                                    @endif
                                @endforeach
                                @foreach ($clg2 as $key => $value)
                                    @if ($value['id'] == $student->id)
                                        <td colspan="2">
                                            {{ $value['total_marks'] }}
                                        </td>
                                        <td colspan="2">
                                            {{ $value['obtain'] }}
                                        </td>
                                    @endif
                                @endforeach
                                @foreach ($clg1 as $key => $value)
                                    @if ($value['id'] == $student->id)
                                        <td colspan="2">
                                            {{ $value['total_marks'] }}
                                        </td>
                                        <td colspan="2">
                                            {{ $value['obtain'] }}
                                        </td>
                                    @endif
                                @endforeach
                                @foreach ($clg0 as $key => $value)
                                    @if ($value['id'] == $student->id)
                                        <td colspan="2">
                                            {{ $value['total_marks'] }}
                                        </td>
                                        <td colspan="2">
                                            {{ $value['obtain'] }}
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- product table box end -->
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            jQuery("#class_id").select2();
            jQuery("#section").select2();
            jQuery("#subject_id").select2();
            let class_id = {!! isset($class_id) && !empty($class_id) ? $class_id : 0 !!};
            let section_id = {!! $section_id && !empty($section_id) ? $section_id : 0 !!};
            let subject_id = {!! $subject_id && !empty($subject_id) ? $subject_id : 0 !!};
            get_section(class_id, section_id, subject_id);
            get_subjects(section_id, subject_id);

        });
    </script>
    <script type="text/javascript">
        var base = '{{ route('subject_wise_exam_report') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    required input validation --}}
    <script type="text/javascript">
        $('.class_id').change(function () {
            var class_id = $(this).children('option:selected').val();
            let section_id = {!! $section_id && !empty($section_id) ? $section_id : 0 !!};
            get_section(class_id, section_id.subject_id);
        });
        $('#section').change(function () {
            let section_id = $(this).val();
            let subject_id = {!! $subject_id && !empty($subject_id) ? $subject_id : 0 !!};
            get_subjects(section_id, subject_id);
        });

        function get_section(class_id, section_id) {
            $.ajax({
                url: '/get_groups',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function (data) {
                    console.log(data);
                    var sections = '<option selected disabled hidden>Choose Section</option>';
                    $.each(data.section, function (index, items) {
                        sections +=
                            `<option value="${items.cs_id}" ${section_id == items.cs_id ? "selected" : " "}> ${items.cs_name} </option>`;
                    });
                    $('#section').html(sections);
                }
            })
        }

        function get_subjects(section_id, subject_id) {
            $.ajax({
                url: '/get_section_subject',
                type: 'get',
                datatype: 'text',
                data: {
                    'section_id': section_id,
                },
                success: function (data) {
                    console.log(data);
                    var subjects = '<option selected disabled hidden>Choose Subject</option>';
                    $.each(data.subjects, function (index, items) {
                        subjects += `<option value="${items.subject_id}" ${items.subject_id == subject_id ? 'selected' : ''}> ${items.subject_name} </option>`;
                    });
                    $('#subject_id').html(subjects);
                }
            });
        }
    </script>
    {{-- end of required input validation --}}

    <script>
        jQuery("#cancel").click(function () {
            $("#class_id").val('');
            $("#section").val('');
        });
    </script>
@endsection
