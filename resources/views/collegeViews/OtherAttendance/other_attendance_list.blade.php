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
                        <h4 class="text-white get-heading-text file_name">Other Attendance List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            {{--                    <!-- <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> --> --}}
            {{--                    --}}
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm"
                      action="{{ route('other_attendance_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <!-- start input box -->
                                <label>
                                    Staff
                                </label>
                                <select tabindex="4" name="teacher" class="inputs_up form-control" id="teacher">
                                    <option value="">Select Staff</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->user_id }}"
                                            {{ $employee->user_id == $search ? 'selected="selected"' : '' }}>
                                            {{ $employee->user_name }}</option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->


                        <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 srch_brdr_left">
                            <div class="row">


                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            Departments
                                        </label>
                                        <select tabindex="4" name="department" class="inputs_up form-control"
                                                id="department">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->dep_id }}"
                                                    {{ $department->dep_id == $search_department ? 'selected="selected"' : '' }}>
                                                    {{ $department->dep_title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            Attendance
                                        </label>
                                        <select tabindex="4" name="attendance" class="inputs_up form-control"
                                                id="attendance">
                                            <option value="">Select Attendance</option>
                                            <option
                                                value="P" {{ 'P' == $search_attendance ? 'selected="selected"' : '' }}>
                                                Present
                                            </option>
                                            <option
                                                value="A" {{ 'A' == $search_attendance ? 'selected="selected"' : '' }}>
                                                Absent
                                            </option>
                                            <option
                                                value="L" {{ 'L' == $search_attendance ? 'selected="selected"' : '' }}>
                                                Leave
                                            </option>
                                            <option
                                                value="S.L" {{ 'S.L' == $search_attendance ? 'selected="selected"' : '' }}>
                                                Short Leave
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            Start Date
                                        </label>
                                        <input tabindex="2" type="text" name="to" id="to"
                                               class="inputs_up form-control datepicker1" autocomplete="off"
                                               <?php if (isset($search_to)){ ?> value="{{ $search_to }}" <?php } ?>
                                               placeholder="Start Date ......"/>
                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                    </div>
                                </div>

                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label>
                                            End Date
                                        </label>
                                        <input tabindex="3" type="text" name="from" id="from"
                                               class="inputs_up form-control datepicker1" autocomplete="off"
                                               <?php if (isset($search_from)){ ?> value="{{ $search_from }}" <?php } ?>
                                               placeholder="End Date ......"/>
                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                    </div>
                                </div> <!-- left column ends here -->
                                <x-year-end-component search="{{$search_year}}"/>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('add_other_attendance') }}"/>

                                    @include('include/print_button')
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_other_attendance') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    <input name="emp_id" id="emp_id" type="hidden">
                    <input name="dep_id" id="dep_id" type="hidden">
                    <input name="la_date" id="la_date" type="hidden">
                    {{-- <input name="remarks" id="remarks" type="hidden"> --}}
                    <input name="la_attendance" id="la_attendance" type="hidden">
                    <input name="la_leave_remarks" id="la_leave_remarks" type="hidden">
                    <input name="la_id" id="la_id" type="hidden">
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
                        {{--                                    <th scope="col"class="tbl_srl_4"> --}}
                        {{--                                        Sr# --}}
                        {{--                                    </th> --}}
                        <th scope="col" class="tbl_srl_4">
                            Sr#
                        </th>
                        <th scope="col" class="tbl_txt_12">
                            Department
                        </th>
                        <th scope="col" class="tbl_txt_20">
                            Staff Name
                        </th>
                        <th scope="col" class="tbl_txt_4">
                            Attendance
                        </th>
                        <th scope="col" class="tbl_txt_18">
                            Leave Remarks
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            Date
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Created at
                        </th>
                        <th scope="col" class="tbl_txt_12">
                            Branch
                        </th>
                        <th scope="col" class="tbl_txt_12">
                            Created By
                        </th>
                        {{-- <th scope="col" class="hide_column tbl_srl_6">
                            Action
                        </th> --}}
                    </tr>
                    </thead>

                    <tbody>
                    @php
                        $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                        $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                        $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                        $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                        use App\User;
                    @endphp
                    @forelse($datas as $data)
                        <tr data-title="{{ $data->employee }}" data-emp_id="{{ $data->la_emp_id }}"
                            data-la_date="{{ $data->la_date }}" data-dep_id="{{ $data->la_department_id }}"
                            data-la_attendance="{{ $data->la_attendance }}"
                            data-la_leave_remarks="{{ $data->la_leave_remarks }}" data-la_id="{{ $data->la_id }}">
                            <th scope="row">
                                {{ $sr }}
                            </th>
                            {{-- <th scope="row" class="edit ">
                                {{ $data->subject_id }}
                            </th> --}}
                            <td class="edit ">
                                {{ $data->dep_title }}
                            </td>

                            @php
                                $ip_browser_info = '' . $data->subject_ip_adrs . ',' . str_replace(' ', '-', $data->subject_brwsr_info) . '';
                            @endphp
                            <td class="edit ">
                                {{ $data->employee }}
                            </td>
                            <td class="edit ">
                                {{ $data->la_attendance }}
                            </td>
                            <td class="edit ">
                                {{ $data->la_leave_remarks }}
                            </td>
                            <td class="edit ">
                                {{ $data->la_date }}
                            </td>
                            <td class="edit ">
                                {{ $data->la_created_datetime }}
                            </td>
                            <td>
                                {{ $data->branch_name }}
                            </td>
                            <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}"
                                data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{ $data->user_name }}
                            </td>
                            {{--                                        <td class="hide_column"> --}}
                            {{--                                            <a class="edit" style="cursor:pointer;"> --}}
                            {{--                                                <i class="fa fa-edit"></i> --}}
                            {{--                                            </a> --}}
                            {{--
                                                                  </td> --}}

                            {{-- <td class="text-center hide_column ">
                                <label class="switch">

                                    <input type="checkbox" <?php if ($data->subject_disable_enable == 1) {
                                        echo 'checked="true"' . ' ' . 'value=' . $data->subject_disable_enable;
                                    } else {
                                        echo 'value=DISABLE';
                                    } ?> class="enable_disable"
                                        data-id="{{ $data->subject_id }}"
                                        {{ $data->subject_disable_enable == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td> --}}

                            {{-- <td class="text-center hide_column ">
                                <a data-subject_id="{{ $data->subject_id }}" class="delete" data-toggle="tooltip"
                                    data-placement="left" title="" data-original-title="Are you sure?">
                                    <i class="fa fa-{{ $data->subject_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                </a>
                            </td> --}}


                            {{--                                        <td><input type="checkbox" data-id="{{ $data->subject_id }}" name="status" class="js-switch" {{ $data->subject_disabled == 0 ? 'checked' : '' }}></td> --}}
                        </tr>
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
            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span {{-- class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search])->links() }}</span> --}}
                    <span
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'teacher' => $search, 'to' => $search_to, 'from' => $search_from, 'department' => $search_department, 'attendance' => $search_attendance])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('subject_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let subject_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_subject') }}',
                    data: {
                        'status': status,
                        'subject_id': subject_id
                    },
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#to").val('');
            $("#from").val('');

            $("#department").select2().val(null).trigger("change");
            $("#department > option").removeAttr('selected');
            $("#teacher").select2().val(null).trigger("change");
            $("#teacher > option").removeAttr('selected');
            $("#attendance").select2().val(null).trigger("change");
            $("#attendance > option").removeAttr('selected');
        });
        $("#department").select2();
        $("#teacher").select2();
        $("#attendance").select2();
    </script>

    <script>
        jQuery(".edit").click(function () {

            var title = jQuery(this).parent('tr').attr("data-title");
            var emp_id = jQuery(this).parent('tr').attr("data-emp_id");
            var dep_id = jQuery(this).parent('tr').attr("data-dep_id");
            var la_date = jQuery(this).parent('tr').attr("data-la_date");
            // var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var tl_extra_load_amount = jQuery(this).parent('tr').attr("data-tl_extra_load_amount");
            var la_id = jQuery(this).parent('tr').attr("data-la_id");
            var la_attendance = jQuery(this).parent('tr').attr("data-la_attendance");
            var la_leave_remarks = jQuery(this).parent('tr').attr("data-la_leave_remarks");
            var attendance_load = jQuery(this).parent('tr').attr("data-attendance_load");
            var tl_id = jQuery(this).parent('tr').attr("data-tl_id");

            jQuery("#emp_id").val(emp_id);
            jQuery("#dep_id").val(dep_id);
            jQuery("#la_date").val(la_date);
            jQuery("#title").val(title);
            // jQuery("#remarks").val(remarks);
            jQuery("#tl_extra_load_amount").val(tl_extra_load_amount);
            jQuery("#la_id").val(la_id);
            jQuery("#la_attendance").val(la_attendance);
            jQuery("#la_leave_remarks").val(la_leave_remarks);
            jQuery("#attendance_load").val(attendance_load);
            jQuery("#tl_id").val(tl_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var subject_id = jQuery(this).attr("data-subject_id");

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
                    jQuery("#regId").val(subject_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>

@endsection
