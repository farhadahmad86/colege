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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left file_name">
                            <h4 class="text-white get-heading-text">Mark As Teacher</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <!-- <div class="search_form {{ !empty($search) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm"
                        action="{{ route('mark_teacher') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
                        name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers"
                                        class="inputs_up form-control all_clm_srch" name="search" id="search"
                                        placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                        autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach ($employee as $value)
                                            <option value="{{ $value }}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="required">
                                        Department
                                    </label>
                                    <select tabindex="4" name="department_id" class="inputs_up form-control"
                                        data-rule-required="true" data-msg-required="Please Enter Department"
                                        id="department_id">
                                        <option value="">Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->dep_id }}">
                                                {{ $department->dep_title }}</option>
                                        @endforeach
                                    </select>
                                    <span id="modular_group_error_msg" class="validate_sign"> </span>
                                </div>
                            </div><!-- end input box -->
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label class="required">
                                        Teacher Or Non-Teacher
                                    </label>
                                    <select tabindex="4" name="teacher" class="inputs_up form-control"
                                        data-rule-required="true" data-msg-required="Please Enter Teacher" id="teacher">
                                        <option value="">Select Teacher</option>
                                        <option value="0">Non-Teacher</option>
                                        <option value="1">Teacher</option>
                                        {{-- @foreach ($departments as $department)
                                            <option
                                                value="{{ $department->dep_id }}"{{ $department->dep_id == $employee->user_department_id ? 'selected' : '' }}>
                                                {{ $department->dep_title }}</option>
                                        @endforeach --}}
                                    </select>
                                    <span id="modular_group_error_msg" class="validate_sign"> </span>
                                </div>
                            </div><!-- end input box -->
                                <x-year-end-component search="{{$search_year}}"/>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 text-right form_controls">
                                @include('include.clear_search_button')
                                <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('add_employee') }}" />

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                    </form>


                    <form name="edit" id="edit" action="{{ route('edit_employee') }}" method="post">
                        @csrf
                        <input tabindex="-1" name="employee_id" id="employee_id" type="hidden">
                    </form>

                    <form name="resend_password_email_form" id="resend_password_email_form"
                        action="{{ route('resend_employee_password_email') }}" method="post">
                        @csrf
                        <input name="employee_id" id="resend_mail_employee_id" type="hidden">
                    </form>

                    <form name="delete" id="delete" action="{{ route('delete_employee') }}" method="post">
                        @csrf
                        <input name="employee_id" id="del_employee_id" type="hidden">
                    </form>

                </div>


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                            <tr>
                                <th scope="col" class="tbl_srl_4">
                                    Id
                                </th>
                                <th scope="col" class="tbl_txt_18">
                                    Name
                                </th>
                                <th scope="col" class="tbl_txt_18">
                                    Faher Name

                                </th>
                                <th scope="col" class="tbl_txt_18">
                                    Mobile
                                </th>
                                <th scope="col" class="tbl_txt_18">
                                    CNIC
                                </th>
                                <th scope="col" class="tbl_txt_10">
                                    Department
                                </th>
                                <th scope="col" class="tbl_txt_10">
                                    Mark As Teacher
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
                            @forelse($datas as $employee)
                                <tr data-employee_id="{{ $employee->user_id }}">
                                    <th scope="row" class="">
                                        {{ $sr }}
                                    </th>
                                    <td class="">
                                        {{ $employee->user_name }}
                                    </td>
                                    <td class="">
                                        {{ $employee->user_father_name }}
                                    </td>
                                    <td class="">
                                        {{ $employee->user_mobile }}
                                    </td>
                                    <td class="">
                                        {{ $employee->user_cnic }}
                                    </td>
                                    <td class="">
                                        {{ $employee->dep_title }}
                                    </td>

                                    <td class="text-center hide_column ">
                                        <label class="switch">
                                            <input type="checkbox" <?php if ($employee->user_mark == 1) {
                                                echo 'checked="true"' . ' ' . 'value=' . $employee->user_mark;
                                            } else {
                                                echo 'value=DISABLE';
                                            } ?> class="mark_teacherOrNot"
                                                data-id="{{ $employee->user_id }}"
                                                {{ $employee->user_mark == 1 ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>

                                    @php
                                        $ip_browser_info = '' . $employee->user_ip_adrs . ',' . str_replace(' ', '-', $employee->user_brwsr_info) . '';
                                    @endphp
                                </tr>
                                @php
                                    $sr++;
                                    !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <center>
                                            <h3 style="color:#554F4F">No Teacher</h3>
                                        </center>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of
                            {{ $datas->total() }}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span
                            class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog" id="exampleModal">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Trade Purchase Invoice Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                {{-- <div class="modal-body">

                    <div id="table_body">

                    </div>
                    <div id="hello"></div>

                </div> --}}
                <div><input type="text" name="" id=""></div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                onclick="gotoParty()" data-dismiss="modal">
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
        var base = '{{ route('mark_teacher') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}
    <script>
        $(document).ready(function() {
            $('.mark_teacherOrNot').change(function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let teacher_id = $(this).data('id');
                console.log(teacher_id);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('mark_teacherOrNot') }}',
                    data: {
                        'status': status,
                        'teacher_id': teacher_id
                    },
                    success: function(data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>


    <script>
        jQuery(".edit").click(function() {
            var employee_id = jQuery(this).parent('tr').attr("data-employee_id");

            jQuery("#employee_id").val(employee_id);
            jQuery("#edit").submit();
        });

        $('.resend_mail').on('click', function(event) {

            var employee_id = jQuery(this).attr("data-employee_id");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to generate new password.',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function(result) {

                if (result.value) {
                    jQuery("#resend_mail_employee_id").val(employee_id);
                    jQuery("#resend_password_email_form").submit();
                } else {

                }
            });
        });
        $('.delete').on('click', function(event) {

            var employee_id = jQuery(this).attr("data-employee_id");

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
                    jQuery("#del_employee_id").val(employee_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });


        jQuery(".enable_disable").change(function() {

            var emp_id = jQuery(this).attr("data-emp_id");
            var username = jQuery(this).attr("data-username");
            var email = jQuery(this).attr("data-email");
            var group_id = jQuery(this).attr("data-group_id");
            var user_type = jQuery(this).attr("data-user_type");

            var status;
            var flag_id = "#" + this.id + "";

            if (jQuery(this).prop('checked') == true) {

                status = 'T';
            } else {
                status = 'F';
            }

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "enable_disable_user",
                data: {
                    emp_id: emp_id,
                    status: status,
                    username: username,
                    email: email,
                    group: group_id,
                    user_type: user_type
                },
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function(data) {


                    if (data.trim() == 'no') {

                        jQuery(flag_id).prop('checked', false);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function() {

            $("#salary_account").select2().val(null).trigger("change");
            $("#salary_account > option").removeAttr('selected');

            $("#group").select2().val(null).trigger("change");
            $("#group > option").removeAttr('selected');

            $("#role").select2().val(null).trigger("change");
            $("#role > option").removeAttr('selected');

            $("#modular_group").select2().val(null).trigger("change");
            $("#modular_group > option").removeAttr('selected');

            $("#user_type").select2().val(null).trigger("change");
            $("#user_type > option").removeAttr('selected');

            $("#product_group").select2().val(null).trigger("change");
            $("#product_group > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function() {
            // Initialize select2
            jQuery("#salary_account").select2();
            jQuery("#group").select2();
            jQuery("#role").select2();
            jQuery("#modular_group").select2();
            jQuery("#user_type").select2();
            jQuery("#product_group").select2();
        });
    </script>

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 49px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2a88ad;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

@endsection
