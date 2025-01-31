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
                        <h4 class="text-white get-heading-text file_name">Promotion List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('promotion_list') }}" name="form1" id="form1"
                      method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <label for="search">Class</label>
                            <div class="input_bx">
                                <select tabindex=1 autofocus name="search" class="inputs_up form-control" id="search"
                                        data-rule-required="true" data-msg-required="Please Enter Class">
                                    <option value="">Class</option>
                                    @foreach($classes as $class)
                                        <option
                                            value="{{$class->class_id}}"{{ $class->class_id == $search_by_class ? 'selected' : ''}}>{{$class->class_name}}</option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <label for="search">Groups</label>
                            <div class="input_bx">
                                <select tabindex=1 autofocus name="group_id" class="inputs_up form-control"
                                        id="group_id"
                                        data-rule-required="true" data-msg-required="Please Enter Group">
                                    <option value="">Groups</option>
                                    @foreach($groups as $group)
                                        <option
                                            value="{{$group->ng_id}}"{{ $group->ng_id == $search_by_group ? 'selected' : ''}}>{{$group->ng_name}}</option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <!-- left column ends here -->
                        <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 text-right form_controls">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('class_promotion') }}"/>

{{--                            @include('include/print_button')--}}
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_route') }}" method="post">
                    @csrf
                    <input name="tr_id" id="tr_id" type="hidden">
                    <input name="route_title" id="route_title" type="hidden">
                    <input name="route_name" id="route_name" type="hidden">
                    <input name="single_route_amount" id="single_route_amount" type="hidden">
                    <input name="double_route_amount" id="double_route_amount" type="hidden">
                    <input name="vendor_charge" id="vendor_charge" type="hidden">
                    <input name="remarks" id="remarks" type="hidden">
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
                        <th scope="col" class="tbl_srl_2">
                            Sr
                        </th>
                        <th scope="col" class="tbl_txt_30">
                            Student
                        </th>
                        <th scope="col" class="tbl_txt_30">
                            Class
                        </th>
                        <th scope="col" class="tbl_txt_14">
                            Group
                        </th>
                        <th scope="col" class="tbl_txt_14">
                            Promotion Group
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
                    @endphp
                    @forelse($datas as $data)
                        <tr data-id="{{ $data->sp_id }}" data-class_id="{{ $data->sp_class_id }}"
                            data-group_id="{{ $data->sp_group_id }}"
                            data-branch_id="{{ $data->sp_branch_id }}"
                            data-promotion_group_id="{{ $data->sp_promotion_group_id }}">
                            <th scope="row">
                                {{ $sr }}
                            </th>
                            <td class="edit ">
                                {{ $data->full_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->class_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->ng_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->promotion_group_name }}
                            </td>
                            <td class="edit" data-usr_prfl="{{ $user->user_id }}">
                                {{ $data->user_name }}
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
                                    <h3 style="color:#554F4F">No Promotions</h3>
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
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search_by_class])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('route_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function () {
            jQuery("#search").select2();
            jQuery("#group_id").select2();
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
            $("#group_id").val('');
        });
    </script>

    <script>
        // jQuery(".edit").click(function () {
        //
        //     var title = jQuery(this).parent('tr').attr("data-title");
        //     var tr_id = jQuery(this).parent('tr').attr("data-tr_id");
        //     var tr_name = jQuery(this).parent('tr').attr("data-tr_name");
        //     var single_route_amount = jQuery(this).parent('tr').attr("data-single_route_amount");
        //     var double_route_amount = jQuery(this).parent('tr').attr("data-double_route_amount");
        //     var vendor_charge = jQuery(this).parent('tr').attr("data-vendor_charge");
        //     var remarks = jQuery(this).parent('tr').attr("data-remarks");
        //     jQuery("#route_title").val(title);
        //     jQuery("#tr_id").val(tr_id);
        //     jQuery("#route_name").val(tr_name);
        //     jQuery("#single_route_amount").val(single_route_amount);
        //     jQuery("#double_route_amount").val(double_route_amount);
        //     jQuery("#vendor_charge").val(vendor_charge);
        //     jQuery("#remarks").val(remarks);
        //     jQuery("#edit").submit();
        // });

        $('.delete').on('click', function (event) {

            var tr_id = jQuery(this).attr("data-tr_id");

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
                    jQuery("#exam_id").val(tr_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>

@endsection
