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
                        <h4 class="text-white get-heading-text file_name">Subject List</h4>
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
                    action="{{ route('subject_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
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
                                    @foreach ($subject_title as $value)
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
                            <x-add-button tabindex="9" href="{{ route('add_subject') }}" />

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_subject') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    {{-- <input name="remarks" id="remarks" type="hidden"> --}}
                    <input name="subject_id" id="subject_id" type="hidden">
                    <input name="teachers_id" id="teachers_id" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_subject') }}" method="post">
                    @csrf
                    <input name="subject_id" id="subject_id" type="hidden">
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
                            <th scope="col" class="tbl_txt_18">
                                Subject
                            </th>
                            <th scope="col" class="tbl_txt_46">
                                Teachers
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Branch
                            </th>
                            <th scope="col" class="tbl_txt_12">
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
                            use App\User;
                        @endphp
                        @forelse($datas as $data)
                            <tr data-title="{{ $data->subject_name }}" data-subject_id="{{ $data->subject_id }}"
                                data-teacher_id="{{ $data->subject_teacher_id }}">
                                <th scope="row">
                                    {{ $sr }}
                                </th>
                                {{-- <th scope="row" class="edit ">
                                    {{ $data->subject_id }}
                                </th> --}}
                                <td class="edit ">
                                    {{ $data->subject_name }}
                                </td>

                                @php

                                    $ip_browser_info = '' . $data->subject_ip_adrs . ',' . str_replace(' ', '-', $data->subject_brwsr_info) . '';
                                    $teachers = User::whereIn('user_id', explode(',', $data->subject_teacher_id))->get();
                                @endphp
                                <td class="edit ">
                                    @foreach ($teachers as $teacher)
                                        {{ $teacher->user_name }},
                                    @endforeach
                                </td>
                                <td class="usr_prfl " data-usr_prfl="{{ $data->users->user_id }}"
                                    data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $data->branch_name }}
                                </td>
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
                                        <input type="checkbox" <?php if ($data->subject_disable_enable == 1) {
                                            echo 'checked="true"' . ' ' . 'value=' . $data->subject_disable_enable;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?> class="enable_disable"
                                            data-id="{{ $data->subject_id }}"
                                            {{ $data->subject_disable_enable == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                {{-- <td class="text-center hide_column ">
                                    <a data-subject_id="{{ $data->subject_id }}" class="delete" data-toggle="tooltip"
                                        data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{ $data->subject_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                    </a>
                                </td> --}}


                                {{--                                        <td><input type="checkbox" data-id="{{ $data->subject_id }}" name="status" class="js-switch" {{ $data->subject_disabled == 0 ? 'checked' : '' }}></td> --}}
                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center>
                                        <h3 style="color:#554F4F">No Subjects</h3>
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
        var base = '{{ route('subject_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function() {
            $('.enable_disable').change(function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let subject_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_subject') }}',
                    data: {
                        'status': status,
                        'subject_id': subject_id
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
            // var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var subject_id = jQuery(this).parent('tr').attr("data-subject_id");
            var teacher_id = jQuery(this).parent('tr').attr("data-teacher_id");

            jQuery("#title").val(title);
            // jQuery("#remarks").val(remarks);
            jQuery("#subject_id").val(subject_id);
            jQuery("#teachers_id").val(teacher_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function(event) {

            var subject_id = jQuery(this).attr("data-subject_id");

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
                    jQuery("#regId").val(subject_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
