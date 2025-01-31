@extends('extend_index')
@section('styles_get')
    <style>
        .action_td .dropdown .dropdown-toggle::after {
            content: unset !important;
        }
    </style>
@stop
@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Teacher Analyze Report</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm"
                      action="{{ route('teacher_analyze_report') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                            <div class="input_bx">
                                <!-- start input box -->
                                <label class="required">
                                    Teacher
                                </label>
                                <select tabindex="1" autofocus name="teacher_id" class="inputs_up form-control class_id"
                                        id="teacher_id" autofocus data-rule-required="true"
                                        data-msg-required="Please Select Teacher">
                                    <option value="">Select Teacher</option>

                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->user_id }}"
                                            {{ $teacher->user_id == $search_teacher_id ? 'selected' : '' }}>
                                            {{ $teacher->user_name }}
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
                                    Exams
                                </label>
                                <select tabindex="1" autofocus name="exam_id" class="inputs_up form-control class_id"
                                        id="exam_id" autofocus data-rule-required="true"
                                        data-msg-required="Please Select Teacher">
                                    <option value="">Select Exam</option>

                                    @foreach ($exams as $exam)
                                        <option value="{{ $exam->exam_id }}"
                                            {{ $exam->exam_id == $search_exam_id ? 'selected' : '' }}>
                                            {{ $exam->exam_name }}
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
                                    Subject
                                </label>
                                <select tabindex="1" autofocus name="subject_id" class="inputs_up form-control class_id"
                                        id="subject_id" autofocus data-rule-required="true"
                                        data-msg-required="Please Select Teacher">
                                    <option value="">Select Subject</option>

                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->subject_id }}"
                                            {{ $subject->subject_id == $search_subject_id ? 'selected' : '' }}>
                                            {{ $subject->subject_name }}
                                        </option>
                                    @endforeach

                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div>
                        </div>
                        <!-- left column ends here -->
                        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 text-right form_controls mt-2">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('teacher_analyze_report') }}"/>

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_txt_30">
                            Sections
                        </th>
                        <th scope="col" class="tbl_txt_30">
                            Red
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Purple
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Blue
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Yellow
                        </th>
                        <th scope="col" class="tbl_txt_18">
                            Green
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @php
                        $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                        $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                        $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                        $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                    @endphp



                    @foreach ($section_marks as  $marks)
                        @foreach ($marks as $mark)
                            <tr>
                                <td>
                                    {{$mark->cs_name}}
                                </td>
                                @php
                                    $red = 0;
                        $purple = 0;
                        $blue = 0;
                        $yellow = 0;
                        $green = 0;
                                // Check if $value is an object and has 'me_obtain_marks' property
                                    $obtain_mark = json_decode($mark->me_obtain_marks, true);

                                    if (is_array($obtain_mark)) {
                                        foreach ($obtain_mark as $item) {
                                                $percentage = number_format($item / $mark->me_total_marks * 100, 2);
                                                if ($percentage < 50 || $percentage <= 0 || $percentage == null) {
                                                    $red++;
                                                } elseif ($percentage >= 50 && $percentage <= 65) {
                                                    $purple++;
                                                } elseif ($percentage >= 65 && $percentage <= 75) {
                                                    $blue++;
                                                } elseif ($percentage >= 75 && $percentage <= 85) {
                                                    $yellow++;
                                                } elseif ($percentage >= 85 && $percentage <= 100) {
                                                    $green++;
                                                }
                                            }
                                        }

                                @endphp
                                <td>{{ $red }}</td>
                                <td>{{ $purple }}</td>
                                <td>{{ $blue }}</td>
                                <td>{{ $yellow }}</td>
                                <td>{{ $green }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('teacher_analyze_report') }}',
            url;

        @include('include.print_script_sh')
    </script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
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
                        'regId': regId
                    },
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
        jQuery("#teacher_id").select2();
        jQuery("#exam_id").select2();
        jQuery("#subject_id").select2();
    </script>
    <script>
        jQuery("#cancel").click(function () {
            $("#exam_id").val('');
            $("#teacher_id").val('');
            $("#subject_id").val('');
        });
    </script>
    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

@endsection
