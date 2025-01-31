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
                        <h4 class="text-white get-heading-text file_name">Time Table List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            {{--                    <!-- <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> --> --}}
            {{--                    --}}
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm"
                      action="{{ route('time_table_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>
                                    All Data Search
                                </label>
                                <!-- start input box -->
                                {{-- <label> --}}
                                {{--    All Column Search --}}
                                {{-- </label> --}}
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
                        </div> <!-- left column ends here -->
                        <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 text-right form_controls mt-3">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_time_table') }}"/>

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_time_table') }}" method="post">
                    @csrf
                    <input name="tm_id" id="tm_id" type="hidden">
                    {{-- <input name="remarks" id="remarks" type="hidden"> --}}
                    <input name="class_id" id="class_id" type="hidden">
                    <input name="time_table" id="time_table" type="hidden">
                    <input name="section_id" id="section_id" type="hidden">
                    <input name="wef" id="wef" type="hidden">
                    <input name="break_start_time" id="break_start_time" type="hidden">
                    <input name="break_end_time" id="break_end_time" type="hidden">
                    <input name="semester_id" id="semester_id" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_time_table') }}" method="post">
                    @csrf
                    <input name="tm_id" id="tm_id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        {{--                                    <th scope="col"class="tbl_srl_4"> --}}
                        {{--                                        Sr# --}}
                        {{--                                    </th> --}}
                        <th scope="col" class="tbl_srl_4">
                            ID
                        </th>
                        <th scope="col" class="tbl_txt_30">
                            Class
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Section
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            Time Table
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Semester/Annual
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            W.E.F
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Break Start Time
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Break End Time
                        </th>

                        <th scope="col" class="tbl_txt_8">
                            Branch
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            Created By
                        </th>
                        <th scope="col" class="hide_column tbl_srl_6">
                            Semester Start Date
                        </th>
                        <th scope="col" class="hide_column tbl_srl_6">
                            Show In Attendance
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
                        use App\Models\College\Subject;
                    @endphp
                    @forelse($datas as $data)
                        <tr data-tm_id="{{ $data->tm_id }}" data-class_id="{{ $data->tm_class_id }}"
                            data-wef="{{ $data->tm_wef }}" data-time_table="{{ $data->tm_timetable }}"
                            data-section_id="{{ $data->tm_section_id }}"
                            data-semester_id="{{ $data->tm_semester_id }}"
                            data-break_start_time="{{ $data->tm_break_start_time }}"
                            data-break_end_time="{{ $data->tm_break_end_time }}">
                            <th scope="row">
                                {{ $sr }}
                            </th>
                            <td class="edit ">
                                {{ $data->class_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->cs_name }}
                            </td>

                            @php
                                $ip_browser_info = '' . $data->tm_ip_adrs . ',' . str_replace(' ', '-', $data->tm_brwsr_info) . '';
                            @endphp
                            <td class="view" data-id="{{ $data->tm_id }}">
                                View Time Table
                            </td>
                            <td>{{ $data->semester_name }}</td>
                            <td>{{ $data->tm_wef }}</td>
                            <td>{{ $data->tm_break_start_time }}</td>
                            <td>{{ $data->tm_break_end_time }}</td>
                            <td> {{ $data->branch_name }}</td>
                            <td class="usr_prfl " data-usr_prfl="{{ $data->users->user_id }}"
                                data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{ $data->users->user_name }}
                            </td>
                            <td>{{ $data->semester_start_date }}</td>
                            {{--                                        <td class="hide_column"> --}}
                            {{--                                            <a class="edit" style="cursor:pointer;"> --}}
                            {{--                                                <i class="fa fa-edit"></i> --}}
                            {{--                                            </a> --}}
                            {{--                                        </td> --}}
                            <td class="text-center hide_column ">
                                @if($data->checks == 1)
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($data->checks == 1) {
                                            echo 'checked="true"' . ' ' . 'value=' . $data->checks;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?> class="check"
                                               data-id="{{ $data->tm_id }}"
                                            {{ $data->checks == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                @else
                                    {{''}}
                                @endif
                            </td>
                            <td class="text-center hide_column ">
                                <label class="switch">
                                    <input type="checkbox" <?php if ($data->tm_disable_enable == 1) {
                                        echo 'checked="true"' . ' ' . 'value=' . $data->tm_disable_enable;
                                    } else {
                                        echo 'value=DISABLE';
                                    } ?> class="enable_disable"
                                           data-id="{{ $data->tm_id }}"
                                        {{ $data->tm_disable_enable == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>

                            {{-- <td class="text-center hide_column ">
                                <a data-group_id="{{ $data->group_id }}" class="delete" data-toggle="tooltip"
                                    data-placement="left" title="" data-original-title="Are you sure?">
                                    <i class="fa fa-{{ $data->group_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                </a>
                            </td> --}}
                        </tr>
                        @php
                            $sr++;
                            !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="13">
                                <center>
                                    <h3 style="color:#554F4F">No Time Table</h3>
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
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg" style="max-width: 1350px; width: 100%;">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Time Table</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body padding: 1.5rem;">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" align="center" class="wdth_5">Account No.</th>
                                    <th scope="col" align="center" class="wdth_2">Account Name</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Amount</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">
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

    <script>
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");
            var id = jQuery(this).attr("data-id");
            $(".modal-body").load('{{ url('timetable_view_details/view/') }}/' + id, function () {
                $("#myModal").modal({
                    show: true
                });
            });
        });
    </script>

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('time_table_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let tm_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_class_timetable') }}',
                    data: {
                        'status': status,
                        'tm_id': tm_id
                    },
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
            $('.check').change(function () {
                let status = $(this).prop('checked') === true ? 1 : 2;
                let tm_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('check_class_timetable') }}',
                    data: {
                        'status': status,
                        'tm_id': tm_id
                    },
                    success: function (data) {
                        console.log(data.message);
                        if (data.status === 'info') {
                            Swal.fire({
                                text: data.message,
                                icon: 'info' // Set the icon to 'info' for informational messages
                            }).then((data) => {
                                // Reload the window after successful request
                                window.location.reload();
                            });
                        } else if (data.status === 'success') {
                            // Reload the window after successful request
                            window.location.reload();
                        }
                    },
                });
            });
        })
        ;
    </script>

    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var tm_id = jQuery(this).parent('tr').attr("data-tm_id");
            var class_id = jQuery(this).parent('tr').attr("data-class_id");
            var time_table = jQuery(this).parent('tr').attr("data-time_table");
            var section_id = jQuery(this).parent('tr').attr("data-section_id");
            var semester_id = jQuery(this).parent('tr').attr("data-semester_id");
            var break_start_time = jQuery(this).parent('tr').attr("data-break_start_time");
            var break_end_time = jQuery(this).parent('tr').attr("data-break_end_time");
            var wef = jQuery(this).parent('tr').attr("data-wef");

            jQuery("#tm_id").val(tm_id);
            jQuery("#class_id").val(class_id);
            jQuery("#time_table").val(time_table);
            jQuery("#section_id").val(section_id);
            jQuery("#semester_id").val(semester_id);
            jQuery("#break_start_time").val(break_start_time);
            jQuery("#break_end_time").val(break_end_time);
            jQuery("#wef").val(wef);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var tm_id = jQuery(this).attr("data-tm_id");

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
                    jQuery("#tm_id").val(tm_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>

@endsection
