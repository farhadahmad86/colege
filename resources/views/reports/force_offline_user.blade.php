@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">



                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left file_name">
                            <h4 class="text-white get-heading-text">Online Users In Desktop</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div class="search_form {{ ( !empty($search) || !empty($search_salary_account) || !empty($search_group) || !empty($search_role) || !empty($search_modular_group) || !empty($search_user_type) ) ? '' : 'search_form_hidden' }}">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                            <form class="prnt_lst_frm" action="{{ route('force_offline_user') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($employee as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Account View Group
                                                    </label>
                                                    <select class="inputs_up form-control cstm_clm_srch" name="group" id="group">
                                                        <option value="">Select Group</option>
                                                        @foreach($groups as $group)
                                                            <option value="{{$group->ag_id}}" {{ $group->ag_id == $search_group ? 'selected="selected"' : '' }}>{{$group->ag_title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Modular Group
                                                    </label>
                                                    <select class="inputs_up form-control cstm_clm_srch" name="modular_group" id="modular_group">
                                                        <option value="">Select Modular Group</option>
                                                        @foreach($modular_groups as $modular_group)
                                                            <option value="{{$modular_group->id}}" {{ $modular_group->id == $search_modular_group ? 'selected="selected"' : ''
                                                            }}>{{$modular_group->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        User Type
                                                    </label>
                                                    <select class="inputs_up form-control cstm_clm_srch" name="user_type" id="user_type">
                                                        <option value="">Select User Type</option>
                                                        <option value="30" {{ 30 == $search_user_type ? 'selected="selected"' : '' }}>Admin</option>
                                                        <option value="20" {{ 20 == $search_user_type ? 'selected="selected"' : '' }}>Manager</option>
                                                        <option value="10" {{ 10 == $search_user_type ? 'selected="selected"' : '' }}>Operator</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Role
                                                    </label>
                                                    <select class="inputs_up form-control cstm_clm_srch" name="role" id="role">
                                                        <option value="">Select Role</option>
                                                        @foreach($roles as $role)
                                                            <option value="{{$role->user_role_id}}" {{ $role->user_role_id == $search_role ? 'selected="selected"' : '' }}>{{$role->user_role_title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a class="save_button form-control" href="{{ route('add_employee') }}" role="button">
                                                        <i class="fa fa-plus"></i> Employee
                                                    </a>

                                                    {{--                                                    @include('include/print_button')--}}

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form name="online" id="online" action="{{ route('update_force_offline_user') }}" method="post">
                                @csrf
                                <input name="employee_id" id="employee_id" type="hidden">
                            </form>


                        </div>

                    </div>
                </div>


                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_20">
                                Name
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_19">
                                Email
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                Mobile
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                Designation
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" align="center" class="hide_column align_center text-center tbl_amnt_6">
                                Action
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $employee)

                            <tr data-employee_id="{{$employee->user_id}}">
                                <td class="align_center text-center edit tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_20">
                                    {{$employee->user_name}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_19">
                                    {{$employee->user_email}}
                                </td>
                                <td class="align_center text-center edit tbl_amnt_10">
                                    {{$employee->user_mobile}}
                                </td>
                                <td class="align_center text-center edit tbl_txt_10">
                                    {{$employee->user_designation}}
                                </td>
                                @php
                                    $ip_browser_info= ''.$employee->user_ip_adrs.','.str_replace(' ','-',$employee->user_brwsr_info).'';
                                @endphp

                                <td class="align_left usr_prfl text-left tbl_txt_8" data-usr_prfl="{{ $employee->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $employee->usr_crtd }}
                                </td>

                                <td class="align_center text-right hide_column tbl_srl_4">
                                    <a data-employee_id="{{$employee->user_id}}" class="online" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure?">
                                        offline
                                    </a>
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No User</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>

                <form action="{{ route('update_all_force_offline_user') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-3 col-md-3 col-sm-12 form_controls">
                            <button type="submit" name="save" id="save" class="save_button form-control">
                                <i class="fa fa-floppy-o"></i> Force Offline All
                            </button>
                        </div>
                    </div>
                </form>

                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'salary_account'=>'', 'group'=>$search_group, 'role'=>$search_role, 'modular_group'=>$search_modular_group, 'user_type'=>$search_user_type ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('force_offline_user') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".online").click(function () {
            var employee_id = jQuery(this).attr("data-employee_id");

            jQuery("#employee_id").val(employee_id);
            jQuery("#online").submit();
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#group").select2().val(null).trigger("change");
            $("#group > option").removeAttr('selected');

            $("#role").select2().val(null).trigger("change");
            $("#role > option").removeAttr('selected');

            $("#modular_group").select2().val(null).trigger("change");
            $("#modular_group > option").removeAttr('selected');

            $("#user_type").select2().val(null).trigger("change");
            $("#user_type > option").removeAttr('selected');

            $("#search").val('');
        });

    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#group").select2();
            jQuery("#role").select2();
            jQuery("#modular_group").select2();
            jQuery("#user_type").select2();
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

