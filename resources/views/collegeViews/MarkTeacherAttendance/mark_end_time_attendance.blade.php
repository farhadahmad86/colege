@extends('extend_index')


@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet">

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
            <!-- <div class="search_form {{ !empty($search_department) || !empty($search_employee) || !empty($search_to) || !empty($search_from) ? '' : 'search_form_hidden' }}"> -->

            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('mark_end_time_attendance_list') }}" name="form1"
                    id="form1" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
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

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
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


                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
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

                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
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

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('add_lecturer_attendance') }}" />
                                    @include('include/print_button')

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- search form end -->

            <form method="post" action="{{ route('mark_end_attendance') }}" name="f1" class="f1" id="f1"
                onsubmit="return checkForm()">
                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                    <div class="input_bx">
                        <!-- start input box -->
                        <label class="required">
                            End Time
                        </label>
                        <input type="text" name="end_time" id="end_time" tabindex="1"
                            class="inputs_up form-control required" autofocus data-rule-required="true"
                            data-msg-required="Please Enter End Time">
                        <span id="demo1" class="validate_sign"> </span>
                    </div>
                </div>


                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                            <tr>
                                <th tabindex="-1" scope="col" class="text-center align_center tbl_srl_4">
                                    <input type="checkbox" name="select-all" id="select-all" />
                                </th>
                                <th scope="col" class="tbl_srl_4">
                                    Sr#
                                </th>
                                <th scope="col" class="tbl_txt_22">
                                    Department
                                </th>
                                <th scope="col" class="tbl_txt_22">
                                    Teacher
                                </th>
                                <th scope="col" class="tbl_txt_10">
                                    Start Time
                                </th>
                                <th scope="col" class="tbl_txt_10">
                                    End Time
                                </th>
                                <th scope="col" class="hide_column tbl_srl_5">
                                    P/A/L
                                </th>
                                <th scope="col" class="hide_column tbl_srl_5">
                                    G/S/AP
                                </th>
                                <th scope="col" class="hide_column tbl_srl_10">
                                    Created At
                                </th>
                                <th scope="col" class="tbl_txt_10">
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
                                $ttlPrc = $cashPaid = 0;
                            @endphp

                            @csrf
                            @forelse($datas as $data)
                                <tr>
                                    <th class="align_center text-center">
                                        <input type="checkbox" name="checkbox[]" value="{{ $data->la_id }}"
                                            id="{{ $data->la_id }}" />
                                    </th>
                                    <th scope="row">
                                        {{ $sr }}
                                    </th>

                                    <td>
                                        {{ $data->dep_title }}
                                    </td>
                                    <td>
                                        {{ $data->teacher }}
                                    </td>
                                    <td>
                                        {{ $data->la_start_time }}
                                    </td>
                                    <td>
                                        {{ $data->la_end_time }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data->la_p_a_l }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data->la_g_s_a }}
                                    </td>
                                    <td class="text-center">
                                        {{ $data->la_created_datetime }}
                                    </td>

                                    @php
                                        $ip_browser_info = '' . $data->la_ip_adrs . ',' . str_replace(' ', '-', $data->la_brwsr_info) . '';
                                    @endphp

                                    <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}"
                                        data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                        {{ $data->user_name }}
                                    </td>
                                </tr>
                                @php
                                    $sr++;
                                    !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="15">
                                        <center>
                                            <h3 style="color:#554F4F">No List Found</h3>
                                        </center>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
                <button tabindex="7" type="submit" class="save_button form-control" name="save" id="save">
                    Save
                </button>
            </form>
            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'department' => $search_department, 'employee' => $search_employee, 'to' => $search_to, 'from' => $search_from])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here  'search'=>$search,-->

    </div><!-- col end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let end_time = document.getElementById("end_time"),

                validateInputIdArray = [
                    end_time.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('mark_end_time_attendance_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        jQuery("#cancel").click(function() {

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');

            $("#product").select2().val(null).trigger("change");
            $("#product > option").removeAttr('selected');


            $("#to").val('');
            $("#from").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function() {
            // Initialize select2
            jQuery("#account").select2();
            jQuery("#product").select2();
            jQuery("#product_name").select2();
            jQuery("#order_list").select2();
            jQuery("#survey_name").select2();
            jQuery("#designer_name").select2();
            jQuery("#franchise").select2();
        });
    </script>


    <script>
        $('#select-all').click(function(event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
    </script>
    <script>
        $('#end_time').datetimepicker({
            format: 'hh:mm a'
        });
    </script>
@endsection
