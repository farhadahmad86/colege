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
                        <h4 class="text-white get-heading-text file_name">Class List</h4>
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
                      action="{{ route('class_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
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
                                    @foreach ($class_title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <x-year-end-component search="{{$search_year}}"/>
                        <!-- left column ends here -->
                        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 text-right form_controls mt-2">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_class') }}"/>

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_classes') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    <input name="class_degree_id" id="class_degree_id" type="hidden">
                    <input name="program_id" id="program_id" type="hidden">
                    <input name="class_id" id="class_id" type="hidden">
                    <input name="session_id" id="session_id" type="hidden">
                    <input name="class_demand" id="class_demand" type="hidden">
                    <input name="class_type" id="class_type" type="hidden">
                    <input name="class_attendance" id="class_attendance" type="hidden">
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
                        <th scope="col" class="tbl_srl_4">
                            ID
                        </th>
                        <th scope="col" class="tbl_txt_37">
                            Title
                        </th>
                        <th scope="col" class="tbl_txt_37">
                            Degree
                        </th>
                        <th scope="col" class="tbl_txt_37">
                            Program
                        </th>
                        <th scope="col" class="tbl_txt_37">
                            Session
                        </th>
                        <th scope="col" class="tbl_txt_37">
                            Demand
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            Branch
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            Class Type
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            Created By
                        </th>
                        <th scope="col" class="hide_column tbl_srl_6">
                            Enable
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
                        <tr data-title="{{ $data->class_name }}" data-class_id="{{ $data->class_id }}"
                            data-degree_id="{{ $data->class_degree_id }}"
                            data-session_id="{{ $data->class_session_id }}"
                            data-program_id="{{ $data->class_program_id }}" data-class_type="{{ $data->class_type }}"
                            data-class_attendance="{{ $data->class_attendance }}"
                            data-class_demand="{{ $data->class_demand }}">
                            <th scope="row">
                                {{ $sr }}
                            </th>
                            <td class="edit ">
                                {{ $data->class_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->degree_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->program_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->session_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->class_demand }}
                            </td>
                            <td class="edit ">
                                {{ $data->branch_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->class_type }}
                            </td>
                            <td class="edit" data-usr_prfl="{{ $user->user_id }}">
                                {{ $user->user_name }}
                            </td>
                            <td class="text-center hide_column ">
                                <label class="switch">
                                    <input type="checkbox" <?php if ($data->class_disable_enable == 1) {
                                        echo 'checked="true"' . ' ' . 'value=' . $data->class_disable_enable;
                                    } else {
                                        echo 'value=DISABLE';
                                    } ?> class="enable_disable"
                                           data-id="{{ $data->class_id }}"
                                        {{ $data->class_disable_enable == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            {{-- <td class="edit">
                                {{ $data->class_type }}
                            </td> --}}
                        </tr>
                        @php
                            $sr++;
                            !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center>
                                    <h3 style="color:#554F4F">No Class</h3>
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
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'search_year' => $search_year ])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('class_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let class_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_class') }}',
                    data: {
                        'status': status,
                        'class_id': class_id
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
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var title = jQuery(this).parent('tr').attr("data-title");
            var class_degree_id = jQuery(this).parent('tr').attr("data-degree_id");
            // var class_incharge_id = jQuery(this).parent('tr').attr("data-incharge_id");
            var class_id = jQuery(this).parent('tr').attr("data-class_id");
            var program_id = jQuery(this).parent('tr').attr("data-program_id");
            var session_id = jQuery(this).parent('tr').attr("data-session_id");
            var class_demand = jQuery(this).parent('tr').attr("data-class_demand");
            var class_attendance = jQuery(this).parent('tr').attr("data-class_attendance");
            var class_type = jQuery(this).parent('tr').attr("data-class_type");
            jQuery("#title").val(title);
            jQuery("#class_degree_id").val(class_degree_id);
            // jQuery("#class_incharge_id").val(class_incharge_id);
            jQuery("#class_id").val(class_id);
            jQuery("#program_id").val(program_id);
            jQuery("#session_id").val(session_id);
            jQuery("#class_demand").val(class_demand);
            jQuery("#class_attendance").val(class_attendance);
            jQuery("#class_type").val(class_type);
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

@endsection
