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
                        <h4 tabindex="-1" class="text-white get-heading-text">Teacher Analysis Report</h4>
                    </div>
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
                <form class="highlight prnt_lst_frm" action="{{ route('teacher_subject_exam_report') }}" name="form1"
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
                        <!-- left column ends here -->
                        <div class="col-lg-6 col-md-9 col-sm-12 col-xs-12 text-right form_controls mt-3">
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

            <div class="form-group row" style="margin-top: 25px;">
                <div class="table-responsive" id="printTable">
                    @foreach($exams_names as $name)
                        <h2 class="text-center mb-5">
                            {{ $name->exam_name  }}
                        </h2>
                        <table class="table table-bordered table-sm" id="category_dynamic_table">
                            <!-- product table box start -->
                            <thead>
                            <tr>
                                <th>Sr</th>

                                <th>Group Name</th>

                                <th>Subject Name</th>

                                <th>Teacher Name</th>

                                <th>Total Student</th>

                                <th>Total Passed</th>

                                <th>Total Failed</th>

                                <th style="background-color: rgb(28, 146, 44) !important; color: white">Green 86% to
                                    100%
                                </th>

                                <th style="background-color: rgb(246, 136, 31) !important; color: white">Yellow 76% to
                                    85%
                                </th>

                                <th style="background-color: rgb(37, 43, 102) !important; color: white">Blue 66% to
                                    75%
                                </th>

                                <th style="background-color: rgb(153, 62, 240) !important; color: white">Purple 40% to
                                    65%
                                </th>

                                <th style="background-color: rgb(220, 53, 69) !important; color: white">Red Less than
                                    40%
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                           $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                           $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                           $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            @endphp


                            @if (is_array($c_marks2) && count($c_marks2) > 0)
                                <!-- Check if the array exists and is not empty -->
                                @foreach ($c_marks2 as $key => $value)
                                    @if($value['exam_id'] == $name->exam_id)
                                        @foreach($teachers as $teacher)
                                            @if($value['s_id'] == $teacher->subject_id)
                                                <tr id="table_body">
                                                    <td>{{$sr++}}</td>
                                                    <td>{{$value['group_name']}}</td>
                                                    <td> {{ $teacher->subject_name }}</td>
                                                    <td>{{ $teacher->user_name }}</td>
                                                    <td>
                                                        {{ $value['total_students'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['total_passed'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['total_failed'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['green'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['yellow'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['blue'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['purple'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['red'] }}
                                                    </td>
                                                <tr/>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td>No Marks</td>
                                </tr>
                            @endif
                            @if (is_array($c_marks1) && count($c_marks1))
                                @foreach ($c_marks1 as $key => $value)
                                    @if($value['exam_id'] == $name->exam_id)
                                        @foreach($teachers as $teacher)
                                            @if($value['s_id'] == $teacher->subject_id)
                                                <tr>
                                                    <td>{{$sr++}}</td>
                                                    <td>{{$value['group_name']}}</td>
                                                    <td> {{ $teacher->subject_name }}</td>
                                                    <td>{{ $teacher->user_name }}</td>
                                                    <td>
                                                        {{ $value['total_students'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['total_passed'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['total_failed'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['green'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['yellow'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['blue'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['purple'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['red'] }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td>No Marks</td>
                                </tr>
                            @endif
                            @if (is_array($c_marks1) && count($c_marks1))
                                @foreach ($c_marks0 as $key => $value)
                                    @if($value['exam_id'] == $name->exam_id)
                                        @foreach($teachers as $teacher)
                                            @if($value['s_id'] == $teacher->subject_id)
                                                <tr>
                                                    <td>{{$sr++}}</td>
                                                    <td>{{$value['group_name']}}</td>
                                                    <td> {{ $teacher->subject_name }}</td>
                                                    <td>{{ $teacher->user_name }}</td>
                                                    <td>
                                                        {{ $value['total_students'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['total_passed'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['total_failed'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['green'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['yellow'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['blue'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['purple'] }}
                                                    </td>
                                                    <td>
                                                        {{ $value['red'] }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td>No Marks</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    @endforeach
                </div><!-- product table box end -->
            </div>
            {{--            <div class="col-md-9 text-right">--}}
            {{--                        <span--}}
            {{--                                class="hide_column"> {{ $c_marks1->appends(['segmentSr' => $countSeg,'class_id'=>$class_id, 'section'=>$section_id])->links() }}</span>--}}
            {{--            </div>--}}
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            jQuery("#class_id").select2();
            jQuery("#section").select2();
            let class_id = {!! isset($class_id) && !empty($class_id) ? $class_id : 0 !!};
            let section_id = {!! $section_id && !empty($section_id) ? $section_id : 0 !!};
            get_section(class_id, section_id);

        });
    </script>
    <script type="text/javascript">
        var base = '{{ route('teacher_subject_exam_report') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    required input validation --}}
    <script type="text/javascript">
        $('.class_id').change(function () {
            var class_id = $(this).children('option:selected').val();
            let section_id = 0;
            get_section(class_id, section_id);
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
    </script>
    {{-- end of required input validation --}}

    <script>
        jQuery("#cancel").click(function () {
            $("#class_id").val('');
            $("#section").val('');
        });
    </script>
@endsection
