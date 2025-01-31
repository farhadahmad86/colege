@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Assign Username List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
            <!-- <div class="search_form  {{ ( !empty($search_username) || !empty($search_employee)|| !empty($search_supplier) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form">
                    <div class="row">


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            {{--                            ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '')--}}
                            <form class="prnt_lst_frm" action="{{ route('assign_username_list')  }}" name="form1" id="form1" method="post">
                                <div class="row">
                                    @csrf

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Select Username
                                            </label>
                                            <select tabindex="1" autofocus class="inputs_up form-control cstm_clm_srch" name="username" id="username" style="width: 90%">
                                                <option value="">Select Username</option>
                                                @foreach($usernames as $username)
                                                    <option value="{{$username->srv_id}}" {{ $username->srv_id == $search_username ? 'selected="selected"' : ''
                                                            }}>{{$username->srv_name}}</option>
                                                @endforeach
                                            </select>

                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        Select Employee
                                                    </label>
                                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="employee" id="employee" style="width: 90%">
                                                        <option value="">Select Employee</option>
                                                        @foreach($employees as $employee)
                                                            <option value="{{$employee->user_id}}" {{ $employee->user_id == $search_employee ? 'selected="selected"' : ''
                                                            }}>{{$employee->user_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Supplier
                                                    </label>
                                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="supplier" id="supplier">
                                                        <option value="">Select Supplier</option>
                                                        @foreach($surveyors as $supplier)
                                                            <option value="{{$supplier->account_uid}}" {{ $supplier->account_uid == $search_supplier ? 'selected="selected"' : ''
                                                            }}>{{$supplier->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="4" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="5" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="6" class="save_button form-control" href="assign_username" role="button">
                                                        <l class="fa fa-plus"></l>
                                                        Assign Username
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div><!-- end row -->
                            </form>

{{--                            <form name="edit" id="edit" action="{{ route('edit_area') }}" method="post">--}}
{{--                                @csrf--}}
{{--                                <input name="region_title" id="region_title" type="hidden">--}}
{{--                                <input name="area_title" id="area_title" type="hidden">--}}
{{--                                <input name="remarks" id="remarks" type="hidden">--}}
{{--                                <input name="area_id" id="area_id" type="hidden">--}}
{{--                                <input name="region_id" id="region_id" type="hidden">--}}

{{--                            </form>--}}

{{--                            <form name="delete" id="delete" action="{{ route('delete_area') }}" method="post">--}}
{{--                                @csrf--}}
{{--                                <input name="area_id" id="del_area_id" type="hidden">--}}
{{--                            </form>--}}


                        </div>
                    </div>
                </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">ID</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_23">Username </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_23">Password </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_25">Surveyor Type</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_25">Surveyor Name</th>
{{--                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Created By</th>--}}
                            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Date/Time</th>--}}
{{--                            <th scope="col" class="text-center align_center hide_column tbl_srl_6">Enable</th>--}}
{{--                            <th scope="col" class="text-center align_center hide_column tbl_srl_6">Action</th>--}}
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $area)

                            <tr
                                {{--                                data-region_title="{{$area->reg_title}}" data-area_title="{{$area->area_title}}" data-remarks="{{$area->reg_remarks}}" data-area_id="{{$area->area_id}}" data-region_id="{{$area->area_reg_id}}"--}}
                            >@php $surveyor_name=''; @endphp

                                <td class="align_center text-center edit tbl_srl_4">{{$sr}}</td>
                                <td class="align_center text-center edit tbl_srl_4">{{$area->srv_id}}</td>

                                <td class="align_left text-left edit tbl_txt_23">{{$area->srv_name}}</td>
{{--                                <td class="view align_center text-center tbl_amnt_6" data-id="{{$voucher->cr_id}}">--}}
{{--                                    CRV-{{$voucher->cr_id}}--}}
{{--                                </td>--}}
                                <td class="align_left text-left edit tbl_txt_23 view" data-toggle="modal" data-target="#myModal" data-id="{{$area->srv_id}}"
                                    data-password="{{$area->srv_password_orignal}}">{{$area->srv_password_orignal}}</td>

                                <td class="align_left text-left edit tbl_txt_25">{{$area->au_surveyor_type}}</td>
                                @php if($area->account_name != null){$surveyor_name=$area->account_name;}else{$surveyor_name=$area->user_name;}@endphp
                                <td class="align_left text-left edit tbl_txt_25">{{$surveyor_name }}</td>


                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Assign Username</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>

                <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'username'=>$search_username, 'employee'=>$search_employee,'supplier'=>$search_supplier ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->


    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Change Password</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="f1" method="post" action="{{route('surveyor_change_password')}}" onsubmit="return checkForm()">
                    @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="id" id="id" class="form-control">

                            <label>Current Password</label>
                            <input type="text" name="current_password" id="current_password" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" data-rule-required="true" data-msg-required="Please Enter New Password">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" data-rule-required="true" data-msg-required="Please Enter Confirm Password">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button tabindex="21" type="submit" name="save" id="save" class="btn btn-default form-control save_button">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>



@endsection

@section('scripts')

    <script type="text/javascript">
        function checkForm() {
            let new_password = document.getElementById("new_password"),
                confirm_password = document.getElementById("confirm_password"),

                validateInputIdArray = [
                    new_password.id,
                    confirm_password.id
                ];
            let checkVald = validateInventoryInputs(validateInputIdArray);
            if(new_password.value.length >= 8){
                if (new_password.value == confirm_password.value) {
                    return checkVald;
                } else {
                    alertMessageShow(confirm_password.id, 'Password Not Match ');
                    return false;
                }
            }else {
                alertMessageShow(new_password.id, 'The password must be at least 8 characters!');
                return false;
            }
            //return validateInventoryInputs(validateInputIdArray);
        }
    </script>

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('assign_username_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let areaId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_area') }}',
                    data: {'status': status, 'area_id': areaId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");
            var current_password = jQuery(this).attr("data-password");

            $('#id').val(id);
            $('#current_password').val(current_password);


        });
        // jQuery(".edit").click(function () {
        //
        //     var region_title = jQuery(this).parent('tr').attr("data-region_title");
        //     var area_title = jQuery(this).parent('tr').attr("data-area_title");
        //     var remarks = jQuery(this).parent('tr').attr("data-remarks");
        //     var area_id = jQuery(this).parent('tr').attr("data-area_id");
        //     var region_id = jQuery(this).parent('tr').attr("data-region_id");
        //
        //     jQuery("#region_title").val(region_title);
        //     jQuery("#area_title").val(area_title);
        //     jQuery("#remarks").val(remarks);
        //     jQuery("#area_id").val(area_id);
        //     jQuery("#region_id").val(region_id);
        //     jQuery("#edit").submit();
        // });
        //
        // $('.delete').on('click', function (event) {
        //
        //     var area_id = jQuery(this).attr("data-area_id");
        //
        //     event.preventDefault();
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         icon: 'warning',
        //         showCancelButton: true,
        //         cancelButtonColor: '#d33',
        //         confirmButtonColor: '#3085d6',
        //         confirmButtonText: 'Yes',
        //     }).then(function (result) {
        //
        //         if (result.value) {
        //             jQuery("#del_area_id").val(area_id);
        //             jQuery("#delete").submit();
        //         } else {
        //
        //         }
        //     });
        // });




        {{--$(function() {--}}
        {{--var availableTutorials  =  JSON.parse('{!! json_encode($area_title) !!}');--}}
        {{--$( "#search" ).autocomplete({--}}
        {{--source: availableTutorials,--}}
        {{--});--}}
        {{--});--}}

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#username").select2().val(null).trigger("change");
            $("#username > option").removeAttr('selected');
            $("#employee").select2().val(null).trigger("change");
            $("#employee > option").removeAttr('selected');
            $("#supplier").select2().val(null).trigger("change");
            $("#supplier > option").removeAttr('selected');

            // $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#username").select2();
            jQuery("#employee").select2();
            jQuery("#supplier").select2();
        });
    </script>

    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>

@endsection

