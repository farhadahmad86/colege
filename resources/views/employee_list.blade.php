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
                            <h4 class="text-white get-heading-text">Employee List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <!-- <div class="search_form {{ !empty($search) || !empty($search_salary_account) || !empty($search_group) || !empty($search_role) || !empty($search_modular_group) || !empty($search_user_type) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm"
                          action="{{ route('employee_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
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

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Account Legder Access Group
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="group"
                                            id="group">
                                        <option value="">Select Account Ledger Access Group</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->ag_id }}"
                                                {{ $group->ag_id == $search_group ? 'selected="selected"' : '' }}>
                                                {{ $group->ag_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Modular Group
                                    </label>
                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch"
                                            name="modular_group"
                                            id="modular_group">
                                        <option value="">Select Modular Group</option>
                                        @foreach ($modular_groups as $modular_group)
                                            <option value="{{ $modular_group->mg_id }}"
                                                {{ $modular_group->mg_id == $search_modular_group ? 'selected="selected"' : '' }}>
                                                {{ $modular_group->mg_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        User Type
                                    </label>
                                    <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="user_type"
                                            id="user_type">
                                        <option value="">Select User Type</option>
                                        <option value="30" {{ 30 == $search_user_type ? 'selected="selected"' : '' }}>
                                            Admin
                                        </option>
                                        <option value="20" {{ 20 == $search_user_type ? 'selected="selected"' : '' }}>
                                            Manager
                                        </option>
                                        <option value="10" {{ 10 == $search_user_type ? 'selected="selected"' : '' }}>
                                            Operator
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Role
                                    </label>
                                    <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="role"
                                            id="role">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->user_role_id }}"
                                                {{ $role->user_role_id == $search_role ? 'selected="selected"' : '' }}>
                                                {{ $role->user_role_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Product Handlig Group
                                    </label>
                                    <select tabindex="6" class="inputs_up form-control cstm_clm_srch"
                                            name="product_group"
                                            id="product_group">
                                        <option value="">Select Product Handling Group</option>
                                        @foreach ($product_groups as $product_group)
                                            <option
                                                value="{{ $product_group->pg_id }}"{{ $product_group->pg_id == $search_product_group ? 'selected' : '' }}>
                                                {{ $product_group->pg_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 text-right form_controls">
                                @include('include.clear_search_button')
                                <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('add_employee') }}"/>

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
                                Sr#
                            </th>
                            <th scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            {{-- <th scope="col"  class="tbl_amnt_9"> --}}
                            {{--    Salary Account --}}
                            {{-- </th> --}}
                            <th scope="col" class="tbl_txt_18">
                                Name
                            </th>
                            <th scope="col" class="tbl_txt_17">
                                Email
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Mobile
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Designation
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Department
                            </th>
                            <th scope="col" class="hide_column tbl_amnt_6">
                                Make User/Not
                            </th>
                            <th scope="col" class="hide_column tbl_amnt_6">
                                Enable
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Account Ledger Access Group
                            </th>
                            <th scope="col" class="hide_column tbl_amnt_4">
                                Allow Biometric Module
                            </th>
                            <th scope="col" class="hide_column tbl_srl_4">
                                Action
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
                                <th scope="row" class="edit ">
                                    {{ $sr }}
                                </th>
                                <td class="edit ">
                                    {{ $employee->user_id }}
                                </td>

                                <td class="edit ">
                                    {{ $employee->user_name }}
                                </td>
                                <td class="edit ">
                                    {{ $employee->user_email }}
                                </td>
                                <td class="edit ">
                                    {{ $employee->user_mobile }}
                                </td>
                                <td class="edit ">
                                    {{ $employee->user_designation != 0 ? $employee->desig_name : 'System Generated' }}
                                </td>
                                <td class="edit ">
                                    {{ $employee->dep_title }}
                                </td>
                                <td class="text-center hide_column ">
                                    @if ($employee->user_email != null)
                                        <label class="switch">
                                            <input type="checkbox" <?php if ($employee->user_login_status == 'ENABLE') {
                                                echo 'checked="true"' . ' ' . 'value=' . $employee->user_login_status;
                                            } else {
                                                echo 'value=DISABLE';
                                            } ?> class="enable_disable"
                                                   data-emp_id="{{ $employee->user_id }}"
                                                   data-username="{{ $employee->user_username }}"
                                                   data-email="{{ $employee->user_email }}"
                                                   data-group_id="{{ $employee->user_account_reporting_group_ids }}"
                                                   data-user_type="{{ $employee->user_level }}"
                                                   id="flag{{ $sr }}">
                                            <span class="slider round"></span>
                                        </label>
                                    @endif
                                </td>

                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($employee->user_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $employee->user_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?> class="enable_disable_employee"
                                               data-id="{{ $employee->user_id }}"
                                            {{ $employee->user_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                @php
                                    $ip_browser_info = '' . $employee->user_ip_adrs . ',' . str_replace(' ', '-', $employee->user_brwsr_info) . '';
                                @endphp

                                <td class="usr_prfl " data-usr_prfl="{{ $employee->user_id }}"
                                    data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $employee->usr_crtd }}
                                </td>
                                <td class="edit ">
                                    {{ $employee->ag_title }}
                                </td>
                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($employee->user_finger_status == 1) {
                                            echo 'checked="true"' . ' ' . 'value=' . $employee->user_finger_status;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?> class="enable_disable_finger"
                                               data-id="{{ $employee->user_id }}"
                                            {{ $employee->user_finger_status == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-center hide_column  action_td" style="overflow: auto">


                                    @if ($employee->user_have_credentials == 1)
                                        <a data-employee_id="{{ $employee->user_id }}" class="resend_mail">
                                            <i class="fa fa-envelope"></i>
                                        </a>
                                    @endif
                                    <a data-employee_id="{{ $employee->user_id }}" class="delete">
                                        <i
                                            class="fa fa-{{ $employee->user_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                    </a>

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
                                        <h3 style="color:#554F4F">No Employee</h3>
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
                            class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'salary_account' => $search_salary_account, 'group' => $search_group, 'role' => $search_role, 'modular_group' => $search_modular_group, 'user_type' => $search_user_type])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('employee_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}
    <script>
        // $(document).ready(function() {
        $('.enable_disable_employee').change(function () {
            let status = $(this).prop('checked') === true ? 0 : 1;
            let empId = $(this).data('id');
            console.log(empId);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('enable_disable_employee') }}',
                data: {
                    'status': status,
                    'emp_id': empId
                },
                success: function (data) {
                    console.log(data);
                    // console.log(data.message);
                }
            });
        });
        // });
        $('.enable_disable_finger').change(function () {
            let status = $(this).prop('checked') === true ? 1 : 0;
            let empId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('enable_disable_finger') }}',
                data: {
                    'status': status,
                    'emp_id': empId
                },
                success: function (data) {
                    console.log(data.message);
                }
            });
        });
        // });
    </script>


    <script>
        jQuery(".edit").click(function () {
            var employee_id = jQuery(this).parent('tr').attr("data-employee_id");

            jQuery("#employee_id").val(employee_id);
            jQuery("#edit").submit();
        });

        $('.resend_mail').on('click', function (event) {

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
            }).then(function (result) {

                if (result.value) {
                    jQuery("#resend_mail_employee_id").val(employee_id);
                    jQuery("#resend_password_email_form").submit();
                } else {

                }
            });
        });
        $('.delete').on('click', function (event) {

            var employee_id = jQuery(this).attr("data-employee_id");

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
                    jQuery("#del_employee_id").val(employee_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });


        jQuery(".enable_disable").change(function () {

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
                success: function (data) {
                    console.log(data);

                    if (data.trim() == 'no') {

                        jQuery(flag_id).prop('checked', false);
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

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
        jQuery(document).ready(function () {
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

        input:checked + .slider {
            background-color: #2a88ad;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
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
