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
                        <h4 class="text-white get-heading-text file_name">Subject Assign List</h4>
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
                    action="{{ route('subject_assign_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
                    name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <input tabindex="1" autofocus type="search" list="browsers"
                                    class="inputs_up form-control" name="search" id="search"
                                    placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                    autocomplete="off">
                                <datalist id="browsers">
                                    @foreach ($subject_assign as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <!-- left column ends here -->
                        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 text-right form_controls mt-2">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('subject_assign') }}" />

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('subject_assign_edit') }}" method="post">
                    @csrf
                    <input name="sa_id" id="sa_id" type="hidden">
                    <input name="class_id" id="class_id" type="hidden">
                    <input name="semester_id" id="semester_id" type="hidden">
                    <input name="subject_id" id="subject_id" type="hidden">
                    <input name="end_date" id="end_date" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_college_groups') }}" method="post">
                    @csrf
                    <input name="group_id" id="group_id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_25">
                                Class
                            </th>
                            <th scope="col" class="tbl_txt_20">
                                Semester
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                Subjects
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                Branch
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                Created At
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                End Date
                            </th>
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
                            <tr data-sa_id="{{ $data->sa_id }}" data-class_id="{{ $data->sa_class_id }}" data-semester_id="{{ $data->sa_semester_id }}" data-subject_id="{{ $data->sa_subject_id }}" data-end_date="{{$data->sa_semester_end_date}}">
                                <th scope="row">
                                    {{ $sr }}
                                </th>

                                <td class="edit">
                                    {{ $data->class_name }}
                                </td>
                                <td class="edit">
                                    {{ $data->semester_name }}
                                </td>
                                @php
                                    $ip_browser_info = '' . $data->sa_ip_address . ',' . str_replace(' ', '-', $data->sa_browser_info) . '';

                                    $subjects = Subject::whereIn('subject_id', explode(',', $data->sa_subject_id))
                                        ->select('subject_name')
                                        ->get();
                                @endphp
                                <td class="edit">
                                    @foreach ($subjects as $subject)
                                        {{ $subject->subject_name , }}
                                    @endforeach
                                </td>
                                <td class="edit ">
                                    {{ $data->branch_name }}
                                </td>
                                <td>
                                    {{ date('d-m-Y', strtotime($data->sa_created_at)) }}
                                </td>
                                <td>
                                    {{ date('d-m-Y', strtotime($data->sa_semester_end_date)) }}
                                </td>
                                {{-- <td class="usr_prfl " data-usr_prfl="{{ $data->users->user_id }}"
                                    data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $data->users->user_name }}
                                </td> --}}


                                {{-- <td class="text-center hide_column ">
                                    <a data-sa_id="{{ $data->sa_id }}" class="delete" data-toggle="tooltip"
                                        data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{ $data->sa_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                    </a>
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
                                        <h3 style="color:#554F4F">No Subject Assign</h3>
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


    {{-- add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('subject_assign_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{-- add code by shahzaib end --}}

    <script>
        $(document).ready(function() {
            $('.enable_disable').change(function() {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let regId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_region') }}',
                    data: {
                        'status': status,
                        'regId': regId
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
        jQuery(".edit").click(function() {

                var title = jQuery(this).parent('tr').attr("data-title");
                // var remarks = jQuery(this).parent('tr').attr("data-remarks");
                var sa_id = jQuery(this).parent('tr').attr("data-sa_id");
                var class_id = jQuery(this).parent('tr').attr("data-class_id");
                var subject_id = jQuery(this).parent('tr').attr("data-subject_id");
                var semester_id = jQuery(this).parent('tr').attr("data-semester_id");
                var end_date = jQuery(this).parent('tr').attr("data-end_date");


                jQuery("#sa_id").val(sa_id);
                jQuery("#class_id").val(class_id);
                jQuery("#subject_id").val(subject_id);
                jQuery("#semester_id").val(semester_id);
                jQuery("#end_date").val(end_date);
                jQuery("#edit").submit();
                });
    </script>

    <script>
        $('.delete').on('click', function(event) {

            var sa_id = jQuery(this).attr("data-sa_id");

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
                    jQuery("#sa_id").val(sa_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
