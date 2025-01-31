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
                        <h4 class="text-white get-heading-text file_name">Monthly Student Attendance Report</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('transfer_student_attendace_record') }}"
                    name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        {{-- <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- invoice column title start -->
                                <label>Class</label>
                                <select tabindex="1" autofocus name="search" class="inputs_up form-control required"
                                        id="search" autofocus data-rule-required="true" data-msg-required="Please Enter Class">
                                    <option value="">Select Class</option>
                                    @foreach ($class_title as $class)
                                        <option value="{{ $class->class_id }}"
                                            {{ $class->class_id == $search ? 'selected' : '' }}>
                                            {{ $class->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div><!-- invoice column title end -->
                        </div> --}}
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- invoice column title start -->
                                <label>Student</label>
                                <select autofocus name="student_id" class="inputs_up form-control required" id="student_id"
                                    autofocus data-rule-required="true" data-msg-required="Please Enter Student">
                                    <option value="" selected>Select Student</option>

                                    @foreach ($students as $std)
                                        <option value="{{ $std->id }}"
                                            {{ $std->id == $search_student ? 'selected' : '' }}>
                                            {{ $std->full_name }}

                                        </option>
                                    @endforeach
                                </select>
                            </div><!-- invoice column title end -->
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12">
                            <div class="input_bx">
                                <label> Section </label><!-- invoice column title end -->
                                <!-- start input box -->
                                <select tabindex="2" autofocus name="section_id" class="form-control required"
                                    id="section_id" autofocus data-rule-required="true"
                                    data-msg-required="Please Enter Section">
                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label> Start Date </label>
                                <!-- start input box -->
                                <input tabindex="2" type="text" name="start_date" id="start_date"
                                    class="inputs_up form-control datepicker1" <?php if(isset($start)){?>
                                    value="{{ $start }}" <?php } ?> autocomplete="off"
                                    placeholder="Date ......" />
                                <span id="demo1" class="validate_sign" style="float: right !important">
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label> End Date </label>
                                <!-- start input box -->
                                <input tabindex="2" type="text" name="end_date" id="end_date"
                                    class="inputs_up form-control datepicker1" <?php if(isset($end)){?>
                                    value="{{ $end }}" <?php } ?> autocomplete="off"
                                    placeholder="Date ......" />
                                <span id="demo1" class="validate_sign" style="float: right !important">
                                </span>
                            </div>
                        </div>

                        <!-- left column ends here -->
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right form_controls mt-3">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('mark_student_attendance') }}" />

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="delete" id="delete" action="{{ route('delete_classes') }}" method="post">
                    @csrf
                    <input name="class_id" id="class_id" type="hidden">
                </form>
            </div>
            {{-- @php
                use Carbon\Carbon;

            @endphp --}}
            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">
                    <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_txt_35">
                                Present/Absent/Leave
                            </th>
                            <th scope="col" class="tbl_txt_5">
                                Date
                            </th>
                            {{-- @for ($i = 1; $i <= $numDays; $i++)
                            @php
                                $date = $year . '-' . $month . '-' . $i;
                                $dayName = Carbon::parse($date)->format('l');
                            @endphp
                            <th scope="col" align="center" class="text-center align_center tbl_txt_2" style="border: 1px solid">
                                {{ $dayName[0] }} {{ $i > 9 ? $i : '0' . $i }}
                            </th>
                        @endfor --}}
                            {{-- <th scope="col" class="tbl_txt_12">
                                Created By
                            </th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                            $user_name = '';
                        @endphp
                        @forelse($attendaces as $attendace)
                            @php
                                $std_id = json_decode($attendace->std_attendance, true);
                            @endphp
                            @foreach ($std_id as $Ids)
                                <tr>
                                    @if ($Ids['student_id'] == $search_student)
                                        <td>{{ $sr }}</td>
                                        <td>{{ $Ids['is_present'] == 'P' ? 'Present' : ($Ids['is_present'] == 'L' ? 'Leave' : ($Ids['is_present'] == 'A' ? 'Absent' : '')) }}
                                        </td>
                                        <td>{{ $attendace->std_att_date }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center>
                                        <h3 style="color:#554F4F">No Report</h3>
                                    </center>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

    <!-- Modal -->

@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('transfer_student_attendace_record') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function() {
            //Load City by State

            var student = {!! $search_student !!}
            let cs_id = {!! $search_section !!}
            get_section(student, cs_id);

        });
    </script>
    <script>
        $('#student_id').change(function() {
            //Load City by State
            var student = $(this).val();

            get_section(student);

        });

        function get_section(student, cs_id = null) {
            // let status = $(this).prop('checked') === true ? 0 : 1;
            let std_id = student;
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('get_student_data') }}',
                data: {
                    'std_id': std_id,
                    // 'regId': regId
                },
                success: function(data) {
                    console.log(data);
                    var sections = '';
                    var groups = '';
                    sections = `<option selected disabled>Select Section</option>`;
                    data.forEach(function(item) {
                        sections +=
                            `<option value="${item.cs_id}" ${item.cs_id == cs_id ? 'selected' : ''}  data-date="${item.st_datetime}">${item.cs_name}</option>`;
                    });
                    $('#section_id').html(sections);
                }
            });
        }

        $('#section_id').change(function() {

            // let status = $(this).prop('checked') === true ? 0 : 1;
            let section_id = $(this).val();
            let std_id = $('#student_id').val();
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('get_date') }}',
                data: {
                    'std_id': std_id,
                    'section_id': section_id
                },
                success: function(data) {
                    console.log(data);

                    $('#start_date').val(data.start_date);
                    $('#end_date').val(data.end_date);

                }
            });

        });
        jQuery("#cancel").click(function() {
            $("#search").val('');
            $("#student_id").val('');
            $("#section_id").val('');
            $("#month").val('');
        });
        jQuery("#search").select2();
        jQuery("#section_id").select2();
        jQuery("#student_id").select2();
        jQuery("#group_id").select2();
    </script>

@endsection
