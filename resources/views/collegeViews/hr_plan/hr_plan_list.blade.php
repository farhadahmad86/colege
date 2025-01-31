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
                        <h4 class="text-white get-heading-text file_name">Hr Plan List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div>
            <!-- form header close -->
            {{--                    <!-- <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> --> --}}
            {{--                    --}}
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm"
                    action="{{ route('hr_plan_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
                    name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>
                                    All Data Search
                                </label>
                                <input tabindex="1" autofocus type="search" list="browsers"
                                    class="inputs_up form-control" name="search" id="search"
                                    placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                    autocomplete="off">
                                <datalist id="browsers">
                                    @foreach ($hr_plan_title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                            <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 text-right form_controls mt-2">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_hr_plan') }}" />

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_hr_plan') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    <input name="extra_leave" id="extra_leave" type="hidden">
                    <input name="causual_leave" id="causual_leave" type="hidden">
                    <input name="short_leave" id="short_leave" type="hidden">
                    <input name="half_leave" id="half_leave" type="hidden">
                    <input name="description" id="description" type="hidden">
                    <input name="hr_plan_id" id="hr_plan_id" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_hr_plan') }}" method="post">
                    @csrf
                    <input name="hr_plan_id" id="hr_plan_id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                Name
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                Extra Leave
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                Causual Leave
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                Short Leave
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                Half Leave
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                Description
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                Branch
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="hide_column tbl_srl_6">
                                Enable
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
                        @endphp
                        @forelse($datas as $data)
                            <tr data-title="{{ $data->hr_plan_name }}" data-extra_leave="{{ $data->hr_plan_extra_leave }}"
                                data-causual_leave="{{ $data->hr_plan_causual_leave }}"
                                data-short_leave="{{ $data->hr_plan_short_leave }}"
                                data-half_leave="{{ $data->hr_plan_half_leave }}"
                                data-description="{{ $data->hr_plan_description }}"
                                data-hr_plan_id="{{ $data->hr_plan_id }}">
                                <th scope="row">
                                    {{ $sr }}
                                </th>
                                <td class="edit">
                                    {{ $data->hr_plan_name }}
                                </td>
                                <td class="edit">
                                    {{ $data->hr_plan_extra_leave }}
                                </td>
                                <td class="edit">
                                    {{ $data->hr_plan_causual_leave }}
                                </td>
                                <td class="edit">
                                    {{ $data->hr_plan_short_leave }}
                                </td>
                                <td class="edit">
                                    {{ $data->hr_plan_half_leave }}
                                </td>
                                <td class="edit">
                                    {{ $data->hr_plan_description }}
                                </td>
                                <td class="edit">
                                    {{ $data->branch_name }}
                                </td>
                                @php
                                    $ip_browser_info = '' . $data->hr_plan_ip_adrs . ',' . str_replace(' ', '-', $data->hr_plan_brwsr_info) . '';
                                @endphp

                                <td class="usr_prfl " data-usr_prfl="{{ $data->users->user_id }}"
                                    data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $data->users->user_name }}
                                </td>
                                {{--                                        <td class="hide_column"> --}}
                                {{--                                            <a class="edit" style="cursor:pointer;"> --}}
                                {{--                                                <i class="fa fa-edit"></i> --}}
                                {{--                                            </a> --}}
                                {{--                                        </td> --}}

                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($data->hr_plan_disable_enable == 1) {
                                            echo 'checked="true"' . ' ' . 'value=' . $data->hr_plan_disable_enable;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?> class="enable_disable"
                                            data-id="{{ $data->hr_plan_id }}"
                                            {{ $data->hr_plan_disable_enable == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                {{-- <td class="text-center hide_column ">
                                    <a data-hr_plan_id="{{ $data->hr_plan_id }}" class="delete" data-toggle="tooltip"
                                        data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{ $data->hr_plan_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                    </a>
                                </td> --}}


                                {{--                                        <td><input type="checkbox" data-id="{{ $data->hr_plan_id }}" name="status" class="js-switch" {{ $data->hr_plan_disabled == 0 ? 'checked' : '' }}></td> --}}
                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center>
                                        <h3 style="color:#554F4F">No Hr Plans</h3>
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
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('hr_plan_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function() {
            $('.enable_disable').change(function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let hr_plan_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_hr_plan') }}',
                    data: {
                        'status': status,
                        'hr_plan_id': hr_plan_id
                    },
                    success: function(data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function() {
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(".edit").click(function() {

            var title = jQuery(this).parent('tr').attr("data-title");
            var extra_leave = jQuery(this).parent('tr').attr("data-extra_leave");
            var causual_leave = jQuery(this).parent('tr').attr("data-causual_leave");
            var short_leave = jQuery(this).parent('tr').attr("data-short_leave");
            var half_leave = jQuery(this).parent('tr').attr("data-half_leave");
            var description = jQuery(this).parent('tr').attr("data-description");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var hr_plan_id = jQuery(this).parent('tr').attr("data-hr_plan_id");

            jQuery("#title").val(title);
            jQuery("#extra_leave").val(extra_leave);
            jQuery("#causual_leave").val(causual_leave);
            jQuery("#short_leave").val(short_leave);
            jQuery("#half_leave").val(half_leave);
            jQuery("#description").val(description);
            // jQuery("#remarks").val(remarks);
            jQuery("#hr_plan_id").val(hr_plan_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function(event) {

            var hr_plan_id = jQuery(this).attr("data-hr_plan_id");

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
                    jQuery("#hr_plan_id").val(hr_plan_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
