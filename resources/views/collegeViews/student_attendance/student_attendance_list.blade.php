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
                        <h4 class="text-white get-heading-text file_name">Student Attendance List</h4>
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
                      action="{{ route('student_attendance_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>
                                    Class
                                </label>
                                <select tabindex="1" autofocus name="search" class="inputs_up form-control required"
                                        id="search" autofocus data-rule-required="true"
                                        data-msg-required="Please Enter Class">
                                    <option value="">Select Class</option>

                                    @foreach ($class_title as $class)
                                        <option value="{{ $class->class_id }}"
                                            {{ $class->class_id == $search ? 'selected' : '' }}>
                                            {{ $class->class_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>
                                    Date
                                </label>
                                <!-- start input box -->
                                <input tabindex="2" type="text" name="date" id="date"
                                       class="inputs_up form-control datepicker1" autocomplete="off"
                                       <?php if (isset($search_by_date)){ ?>
                                       value="{{ $search_by_date }}" <?php } ?> placeholder="Date ......"/>
                                <span id="demo1" class="validate_sign" style="float: right !important">
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-12">
                            <div class="input_bx">
                                <label>
                                    Section
                                </label>
                                <!-- start input box -->
                                <select tabindex="2" autofocus name="section_id" class="form-control required"
                                        id="section_id" autofocus data-rule-required="true"
                                        data-msg-required="Please Enter Section">
                                    <option value="" selected>Choose Section</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->cs_id }}"
                                            {{ $section->cs_id == $search_by_section ? 'selected' : '' }}>
                                            {{ $section->cs_name }}</option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div>
                        </div>
                        <!-- left column ends here -->
                        <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-4 col-md-9 col-sm-12 col-xs-12 text-right form_controls mt-3">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('mark_student_attendance') }}"/>

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_student_attendance') }}" method="post">
                    @csrf
                    <input name="std_att_id" id="std_att_id" type="hidden">
                    <input name="att_date" id="att_date" type="hidden">
                    <input name="att_section_id" id="att_section_id" type="hidden">
                    <input name="leave_remarks" id="leave_remarks" type="hidden">
                    <input name="class_id" id="class_id" type="hidden">
                    <input name="std_attendance" id="std_attendance" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_classes') }}" method="post">
                    @csrf
                    <input name="class_id" id="class_id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_4">
                            Sr#
                        </th>
                        <th scope="col" class="tbl_srl_4">
                            Roll No
                        </th>
                        <th scope="col" class="tbl_txt_40">
                            Student Name
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Present
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Absent
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Leave
                        </th>
                        <th scope="col" class="tbl_txt_26">
                            Leave Remarks
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            Created By
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
                    @forelse($datas as $data)
                        @php
                            // Get all student IDs from the attendance data
                            $studentIds = collect(json_decode($data->std_attendance, true))->pluck('student_id');
                            $leave_remarks = json_decode($data->std_att_leave_remarks);
                            // Fetch all students using the student IDs
                            $students = App\Models\College\Student::whereIn('id', $studentIds)->where('section_id', $search_by_section)->get();
                            // Create a lookup array to easily access student details inside the loop
                            $studentLookup = [];
                            foreach ($students as $student) {
                                $studentLookup[$student->id] = $student;
                            }
                            $std = 1;
                        @endphp
                        {{-- <td> --}}
                        @foreach (json_decode($data->std_attendance, true) as $attendance)
                            @php
                                $student = $studentLookup[$attendance['student_id']] ?? null;

                            @endphp
                            @if ($student)
                                <tr data-std_attendance='{{ $data->std_attendance }}'
                                    data-class_id="{{ $data->std_att_class_id }}"
                                    data-leave_remarks="{{ $data->std_att_leave_remarks }}"
                                    data-att_section_id="{{ $data->std_att_section_id }}"
                                    data-att_date="{{ $data->std_att_date }}"
                                    data-std_att_id="{{ $data->std_att_id }}">
                                    <th scope="row">
                                        {{ $std++ }}
                                    </th>
                                    <th scope="row">
                                        {{ $student->roll_no }}
                                    </th>
                                    <td class="edit">
                                        {{ $student->full_name }}
                                    </td>
                                    <td class="edit">
                                        {{ $attendance['is_present'] == 'P' ? 'Present' : ' ' }}
                                    </td>
                                    <td class="edit">
                                        {{ $attendance['is_present'] == 'A' ? 'Absent' : ' ' }}
                                    </td>
                                    <td class="edit">
                                        {{ $attendance['is_present'] == 'L' ? 'Leave' : ' ' }}
                                    </td>
                                    @if (!empty($student))
                                        @foreach ($studentIds as $key => $value)
                                            @if ($value == $student->id)
                                                <td class="tbl_srl_40">
                                                    {{ $leave_remarks[$key] }}</td>
                                            @endif
                                        @endforeach
                                    @endif
                                    <td class="edit">
                                        {{ $data->user_name }}
                                    </td>
                                    @else
                                        {{--                                        No Attendance--}}
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
                                                <h3 style="color:#554F4F">No Attendance</h3>
                                            </center>
                                        </td>
                                    </tr>
                                @endforelse
                    </tbody>
                </table>
            </div>
            {{-- <div class="row">
                <div class="col-md-3">
                    <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search])->links() }}</span>
                </div>
            </div> --}}
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Student Attedance List</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>
                    <div id="hello"></div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('student_attendance_list') }}',
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
        jQuery("#search").select2();
        jQuery("#section_id").select2();
    </script>
    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
            $("#date").val('');
            $("#section_id").val('');
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var std_att_id = jQuery(this).parent('tr').attr("data-std_att_id");
            var std_attendance = jQuery(this).parent('tr').attr("data-std_attendance");
            var class_id = jQuery(this).parent('tr').attr("data-class_id");
            var att_section_id = jQuery(this).parent('tr').attr("data-att_section_id");
            var leave_remarks = jQuery(this).parent('tr').attr("data-leave_remarks");
            var date = jQuery(this).parent('tr').attr("data-att_date");
            jQuery("#std_att_id").val(std_att_id);
            jQuery("#std_attendance").val(std_attendance);
            jQuery("#class_id").val(class_id);
            jQuery("#att_section_id").val(att_section_id);
            jQuery("#leave_remarks").val(leave_remarks);
            jQuery("#att_date").val(date);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var class_id = jQuery(this).attr("data-class_id");

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
                    jQuery("#class_id").val(class_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>
    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            // jQuery(".pre-loader").fadeToggle("medium");
            jQuery("#table_body").html("");

            var class_id = jQuery(this).attr("data-class_id");
            var cs_id = jQuery(this).attr("data-cs_id");
            var date = jQuery(this).attr("data-std_att_created_at")
            $(".modal-body").load('{{ url('class_attendance_view_detail/view/') }}/' + class_id + '/' +
                cs_id + '/' + date,
                function () {
                    // jQuery(".pre-loader").fadeToggle("medium");
                    $("#myModal").modal({
                        show: true
                    });
                });
        });
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

@endsection
