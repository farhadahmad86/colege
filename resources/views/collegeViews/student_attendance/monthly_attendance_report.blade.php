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
                <form class="highlight prnt_lst_frm"
                      action="{{ route('monthly_attendance_list')}}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
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
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12">
                            <div class="input_bx">
                                <label> Section </label><!-- invoice column title end -->
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
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- invoice column title start -->
                                <label>Student</label>
                                <select autofocus name="student_id" class="inputs_up form-control required"
                                        id="student_id" autofocus data-rule-required="true" data-msg-required="Please Enter Student">
                                    <option value="" selected>Select Student</option>

                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}"
                                            {{ $student->id == $search_student ? 'selected' : '' }}>
                                            {{ $student->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div><!-- invoice column title end -->
                        </div>
                        <div class="invoice_col form-group col-lg-2 col-md-2 col-sm-12"><!-- invoice column start -->
                            <div class="input_bx"><!-- invoice column box start -->
                                <label>Month</label>
                                <input tabindex="1" type="text" name="month" id="month" class="inputs_up form-control month-picker" autocomplete="off" value="{{$search_month}}"
                                       data-rule-required="true"
                                       data-msg-required="Please Enter Month"
                                       placeholder="Start Month ......">
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div><!-- invoice column box end -->
                        </div><!-- invoice column end -->

                        <!-- left column ends here -->
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-right form_controls mt-3">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('mark_student_attendance') }}"/>

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
            @php
                use Carbon\Carbon;

            @endphp
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
                        <th scope="col" class="tbl_txt_35">
                            Student Name
                        </th>
                        @for ($i = 1; $i <= $numDays; $i++)
                            @php
                                $date = $year . '-' . $month . '-' . $i;
                                $dayName = Carbon::parse($date)->format('l');
                            @endphp
                            <th scope="col" align="center" class="text-center align_center tbl_txt_2" style="border: 1px solid">
                                {{ $dayName[0] }} {{ $i > 9 ? $i : '0' . $i }}
                            </th>
                        @endfor
                        <th scope="col" class="tbl_txt_12">
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
                        $user_name='';
                    @endphp
                    @forelse($students as $student_data)

                        <tr>
                            <th scope="row">
                                {{ $sr }}
                            </th>
                            <th scope="row">
                                {{ $student_data->roll_no }}
                            </th>
                            <td class="edit">
                                {{ $student_data->full_name }}
                            </td>
                            @php $days=0; $atten =''; @endphp
                            @for ($i = 1; $i <= $numDays; $i++)

                                @foreach ($datas as $item)
                                    @php

                                        $day = date('d', strtotime($item->std_att_date));
                                        $data = json_decode($item->std_attendance, true);
                                        $studentIds = array_column($data, 'student_id');
                                        $targetStudentId = $student_data->id;
                                        $index = array_search($targetStudentId, $studentIds);
                                        $user_name =  $item->user_name;
                                        if ($index !== false) {
                                        if($day ==$i){
                                         $atten= $data[$index]['is_present'];
                                         $days=$day;
                                        }
                                        }
                                    @endphp
                                @endforeach
                                @if($days == $i)
                                    <td scope="col" class="text-center tbl_txt_2">
                                        {{ $atten }}
                                    </td>
                                @else
                                    <td scope="col" class="text-center tbl_txt_2">

                                    </td>
                                @endif
                            @endfor
                            <td class="edit">
                                {{ $user_name }}
                            </td>
                        </tr>
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
        var base = '{{ route('monthly_attendance_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery("#search").select2();
        jQuery("#section_id").select2();
        jQuery("#student_id").select2();
    </script>
    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
            $("#student_id").val('');
            $("#section_id").val('');
            $("#month").val('');
        });
    </script>

@endsection
