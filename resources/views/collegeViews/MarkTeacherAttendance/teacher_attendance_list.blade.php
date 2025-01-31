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
                        <h4 class="text-white get-heading-text file_name">Teacher Attendance List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            {{-- <!-- <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}">
        --> --}}
            {{-- --}}
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('lecturer_attendance_list') }}" name="form1"
                    id="form1" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            Select Department
                                        </label>
                                        <select tabindex="3" class="inputs_up form-control" name="department"
                                            id="department">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->dep_id }}"
                                                    {{ $department->dep_id == $search_department ? 'selected="selected"' : '' }}>
                                                    {{ $department->dep_title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            Select Staff
                                        </label>
                                        <select tabindex="3" class="inputs_up form-control" name="employee"
                                            id="employee">
                                            <option value="">Select Staff</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->user_id }}"
                                                    {{ $employee->user_id == $search_employee ? 'selected="selected"' : '' }}>
                                                    {{ $employee->user_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            Start Date
                                        </label>
                                        <input tabindex="5" type="text" name="to" id="to"
                                            class="inputs_up form-control datepicker1" autocomplete="off"
                                            <?php if(isset($search_to)){?> value="{{ $search_to }}" <?php } ?>
                                            placeholder="Start Date ......" />
                                    </div>
                                </div>

                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            End Date
                                        </label>
                                        <input tabindex="6" type="text" name="from" id="from"
                                            class="inputs_up form-control datepicker1" autocomplete="off"
                                            <?php if(isset($search_from)){?> value="{{ $search_from }}" <?php } ?>
                                            placeholder="End Date ......" />
                                    </div>
                                </div>
                                <x-year-end-component search="{{$search_year}}"/>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('add_lecturer_attendance') }}" />
                                    @include('include/print_button')
                                    <span id="demo1" class="validate_sign" style="float: right !important">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form name="edit" id="edit" action="{{ route('edit_account') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    {{-- <input name="remarks" id="remarks" type="hidden"> --}}
                    {{-- <input name="dep_id" id="dep_id" type="text">
                    <input name="section_id" id="section_id" type="text">
                    <input name="teacher_id" id="teacher_id" type="text">
                    <input name="subject_id" id="subject_id" type="text">
                    <input name="attendance" id="attendance" type="text">
                    <input name="lecture_time" id="lecture_time" type="text">
                    <input name="type" id="type" type="text">
                    <input name="la_id" id="la_id" type="text"> --}}
                </form>
                <form name="delete" id="delete" action="{{ route('delete_subject') }}" method="post">
                    @csrf
                    <input name="subject_id" id="subject_id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_2">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Department
                            </th>
                            <th scope="col" class="tbl_txt_4">
                                Class
                            </th>
                            <th scope="col" class="tbl_txt_4">
                                Section
                            </th>
                            <th scope="col" class="tbl_txt_4">
                                Semester
                            </th>
                            <th scope="col" class="tbl_txt_16">
                                Teacher Name
                            </th>
                            <th scope="col" class="tbl_txt_4">
                                Subject
                            </th>
                            <th scope="col" class="tbl_txt_4">
                                Attendance
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Load
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Status
                            </th>
                             <th scope="col" class="hide_column tbl_srl_4">
                                Attendance Date
                            </th>
                            <th scope="col" class="hide_column tbl_srl_10">
                                Created At
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Branch Name
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $segmentSr = !empty(app('request')->input('segmentSr'))
                                ? app('request')->input('segmentSr')
                                : '';
                            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                            use App\Models\College\Subject;
                        @endphp
                        @forelse($datas as $data)
                            <tr data-la_id="{{ $data->la_id }}" data-dep_id="{{ $data->la_department_id }}"
                                data-section_id="{{ $data->la_section_id }}" data-teacher_id="{{ $data->la_emp_id }}"
                                data-subject_id="{{ $data->la_subject_id }}"
                                data-attendance="{{ $data->la_attendance }}"
                                data-lecture_time="{{ $data->la_start_time }}" data-type="{{ $data->la_type }}">
                                <th scope="row">
                                    {{ $sr }}
                                </th>

                                <td>
                                    {{ $data->dep_title }}
                                </td>
                                <td>
                                    @if ($data->la_type == 2)
                                        {{ $data->class_name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($data->la_type == 2)
                                        {{ $data->cs_name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($data->la_type == 2)
                                        {{ $data->semester_name }}
                                    @endif
                                </td>
                                <td>
                                    {{ $data->employee }}
                                </td>
                                <td>
                                    @if ($data->la_type == 2)
                                        {{ $data->subject_name }}
                                    @endif
                                </td>
                                <td>
                                    {{ $data->la_attendance }}
                                </td>
                                <td>
                                    {{ $data->tl_attendance_load }}
                                </td>
                                <td>
                                    @if ($data->la_type == 1)
                                        {{ 'Regular' }}
                                    @elseif($data->la_type == 2)
                                        {{ 'Extra' }}
                                    @elseif($data->la_type == 3)
                                        {{ 'Absent' }}
                                    @elseif($data->la_type == 4)
                                        {{ 'Leave' }}
                                    @elseif($data->la_type == 5)
                                        {{ 'Merge' }}
                                    @endif

                                </td>
{{--                                 <td>--}}
{{--                                    @if ($data->la_type == 2)--}}
{{--                                        {{ $data->la_start_time }}--}}
{{--                                    @endif--}}
{{--                                </td> --}}

                                <td class="text-center">
                                    {{ $data->la_date }}
                                </td>
                                <td class="text-center">
                                    {{ $data->la_created_datetime }}
                                </td>
                                <td class="text-center">
                                    {{ $data->branch_name }}
                                </td>

                                @php
                                    $ip_browser_info =
                                        '' . $data->la_ip_adrs . ',' . str_replace(' ', '-', $data->la_brwsr_info) . '';
                                @endphp

                                <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}"
                                    data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $data->user_name }}
                                </td>
                                @if ($data->la_type != 2 && $data->la_type != 5)
                                    <td >
                                        <span class="view" data-id="{{ $data->la_id }}">
                                            <i class="fa fa-eye"></i> |
                                        </span>
                                        {{-- @elseif ($voucher->br_status == 'park') --}}
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('edit_lecturer_attendance', $data->la_id) }}">
                                            <i class="fa fa-edit"></i></a>
                                    </td>
                                @endif
                                @if ($data->la_type == 2)
                                    <td data-id="{{ $data->la_id }}">
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('edit_extra_lecturer_attendance', $data->la_id) }}"><i
                                                class="fa fa-edit"></i></a>
                                    </td>
                                @endif
                                @if ($data->la_type == 5)
                                    <td data-id="{{ $data->la_id }}">
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('edit_extra_lecturer_attendance', $data->la_id) }}"><i
                                                class="fa fa-edit"></i></a>
                                    </td>
                                @endif

                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="8">
                                    <center>
                                        <h3 style="color:#554F4F">No Attendance</h3>
                                    </center>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'department' => $search_department, 'employee' => $search_employee, 'to' => $search_to, 'from' => $search_from])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg" style="max-width: 1350px; width: 100%;">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Teacher Attendance</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body padding: 1.5rem;">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" align="center" class="wdth_5">Account No.</th>
                                        <th scope="col" align="center" class="wdth_2">Account Name</th>
                                        <th scope="col" align="center" class="wdth_5 text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
                    </div>

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


    {{-- add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('lecturer_attendance_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{-- add code by shahzaib end --}}
    <script>
        jQuery(".view").click(function() {

            jQuery("#table_body").html("");
            var id = jQuery(this).attr("data-id");
            $(".modal-body").load('{{ url('lecturer_attendance_view_details/view/') }}/' + id, function() {
                $("#myModal").modal({
                    show: true
                });
            });
        });
    </script>

    <script>
        jQuery(".edit").click(function() {

            // var title = jQuery(this).parent('tr').attr("data-title");
            // // var remarks = jQuery(this).parent('tr').attr("data-remarks");
            // var dep_id = jQuery(this).parent('tr').attr("data-dep_id");
            // var section_id = jQuery(this).parent('tr').attr("data-section_id");
            // var teacher_id = jQuery(this).parent('tr').attr("data-teacher_id");
            // var subject_id = jQuery(this).parent('tr').attr("data-subject_id");
            // var attendance = jQuery(this).parent('tr').attr("data-attendance");
            // var lecture_time = jQuery(this).parent('tr').attr("data-lecture_time");
            // var type = jQuery(this).parent('tr').attr("data-type");
            // var la_id = jQuery(this).parent('tr').attr("data-la_id");

            // jQuery("#title").val(title);
            // // jQuery("#remarks").val(remarks);
            // jQuery("#dep_id").val(dep_id);
            // jQuery("#section_id").val(section_id);
            // jQuery("#teacher_id").val(teacher_id);
            // jQuery("#subject_id").val(subject_id);
            // jQuery("#attendance").val(attendance);
            // jQuery("#lecture_time").val(lecture_time);
            // jQuery("#type").val(type);
            // jQuery("#la_id").val(la_id);
            // jQuery("#edit").submit();
        });

        $('.delete').on('click', function(event) {

            var subject_id = jQuery(this).attr("data-subject_id");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function(result) {

                if (result.value) {
                    jQuery("#regId").val(subject_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>
    <script>
        jQuery("#cancel").click(function() {

            $("#department").select2().val(null).trigger("change");
            $("#department > option").removeAttr('selected');

            $("#employee").select2().val(null).trigger("change");
            $("#employee > option").removeAttr('selected');

            $("#to").val('');
            $("#from").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function() {
            // Initialize select2
            jQuery("#department").select2();
            jQuery("#employee").select2();
        });
    </script>

@endsection
