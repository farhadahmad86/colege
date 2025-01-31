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
                        <h4 class="text-white get-heading-text file_name">Attendance Report</h4>
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
                      action="{{ route('branch_wise_report') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <!-- start input box -->
                                <input tabindex="2" type="text" name="date" id="date"
                                       class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_date)){?>
                                       value="{{ $search_date }}" <?php } ?> placeholder="Date ......"/>
                                <span id="demo1" class="validate_sign" style="float: right !important">
                                </span>
                            </div>
                        </div>
                        <!-- left column ends here -->
                        <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 text-right form_controls">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('branch_wise_report') }}"/>

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
                        <th scope="col" class="tbl_srl_4">
                            Sr#
                        </th>
                        <th scope="col" class="tbl_txt_30">
                            Campus Name
                        </th>
                        <th scope="col" class="tbl_txt_15">
                            Total Students
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Present
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Present%
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Absent
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Leave
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Attendance Not Mark
                        </th>
                        <th scope="col" class="tbl_txt_18">
                            Date
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

                    @foreach($branches as $branch)
                        <tr>
                            <th>
                                {{ $sr }}
                            </th>
                            <td>
                                {{ $branch->branch_name }}
                            </td>
                            @php $total_students =0;
                                $presentCount = 0;
                                $absentCount = 0;
                                $leaveCount = 0; @endphp
                            @foreach($students as $std)
                                @if($std->branch_id == $branch->branch_id)
                                    @php $total_students = $std->total; @endphp
                                    <td>
                                        {{ $std->total }}
                                    </td>
                                @endif
                            @endforeach
                            @foreach($datas as $data)
                                @if($data->std_att_branch_id ==$branch->branch_id)
                                    @php
                                        $attendances = json_decode($data->std_attendance, true);
                                        $attendanceCount = count($attendances);
                                    @endphp

                                    {{-- <td>
                                        {{ $attendanceCount }}
                                        <br/>
                                        Section: {{ $data->std_att_section_id }}
                                    </td> --}}

                                    @foreach($attendances as $attendance)
                                        @php
                                            if ($attendance['is_present'] == 'P') {
                                                $presentCount++;
                                            } elseif ($attendance['is_present'] == 'A') {
                                                $absentCount++;
                                            } elseif ($attendance['is_present'] == 'L') {
                                                $leaveCount++;
                                            }
                                        @endphp
                                    @endforeach
                                @endif
                            @endforeach

                            <td>
                                {{$presentCount}}
                            </td>
                            <td>
                                {{$total_students > 0 ? number_format($presentCount/$total_students *100,2) : 0}}
                            </td>
                            <td>
                                {{$absentCount}}
                            </td>
                            <td>
                                {{$leaveCount}}
                            </td>
                            <td>
                                {{$total_students - $presentCount - $absentCount - $leaveCount}}
                            </td>
                            <td>
                                {{$search_date}}
                            </td>
                        </tr>
                        @php $sr++; @endphp
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
        var base = '{{ route('branch_wise_report') }}',
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
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


@endsection
