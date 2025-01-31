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
                        <h4 class="text-white get-heading-text file_name">Upload Lecture List</h4>
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
                      action="{{ route('upload_lecture_list') }}"
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
                                    @foreach ($title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <select tabindex=42 autofocus name="class" class="form-control" data-rule-required="true"
                                        data-msg-required="Please Enter Cr Account" id="class">
                                    <option value="" disabled selected>Select Class</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->class_id }}"
                                            {{ $class->class_id == $search_class ? 'selected' : '' }}>
                                            {{ $class->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <select tabindex=42 autofocus name="group" class="form-control" data-rule-required="true"
                                        data-msg-required="Please Enter Dr Account" id="group">
                                    <option value="" disabled selected>Select group</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->ng_id }}"
                                            {{ $group->ng_id == $search_group ? 'selected' : '' }}>
                                            {{ $group->ng_name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <select tabindex=42 autofocus name="subject" class="form-control" data-rule-required="true"
                                        data-msg-required="Please Enter Dr Account" id="subject">
                                    <option value="" disabled selected>Select Subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->subject_id }}"
                                            {{ $subject->subject_id == $search_subject ? 'selected' : '' }}>
                                            {{ $subject->subject_name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div> <!-- left column ends here -->
                        <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-right form_controls">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('create_upload_lecture') }}"/>

                            @include('include/print_button')
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_upload_lecture') }}" method="post">
                    @csrf
                    <input name="lec_id" id="lec_id" type="hidden">
                    <input name="class_id" id="class_id" type="hidden">
                    <input name="group_id" id="group_id" type="hidden">
                    <input name="subject_id" id="subject_id" type="hidden">
                    <input name="title" id="title" type="hidden">
                    <input name="link" id="link" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_upload_lecture') }}" method="post">
                    @csrf
                    <input name="group_id" id="group_id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_4">
                            Sr
                        </th>
                        <th scope="col" class="tbl_txt_20">
                            Class Name
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Group
                        </th>
                        <th scope="col" class="tbl_txt_15">
                            Subject
                        </th>
                        <th scope="col" class="tbl_txt_25">
                            Title
                        </th>
                        <th scope="col" class="tbl_txt_18">
                            Link
                        </th>

                        <th scope="col" class="tbl_txt_8">
                            Created By
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
                        <tr data-class_id="{{ $data->lec_class_id }}" data-group_id="{{ $data->lec_group_id }}" data-lec_id="{{ $data->lec_id }}"
                            data-subject_id="{{ $data->lec_subject_id }}"
                            data-title="{{ $data->lec_title }}"
                            data-link="{{ $data->lec_link }}">
                            <th scope="row">
                                {{ $sr }}
                            </th>
                            <td class="edit ">
                                {{ $data->class_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->ng_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->subject_name }}
                            </td>
                            <td>
                                {{ $data->lec_title }}
                            </td>
                            <td>
                                <a href="{{ $data->lec_link }}" class="btn btn-sm btn-primary" target="_blank">Link</a>
                            </td>

                            <td class="usr_prfl">
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
                                    <h3 style="color:#554F4F">No Lecture Upload</h3>
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
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'class' => $search_class, 'group' => $search_group, 'subject' => $search_subject])
                        ->links()
                        }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('upload_lecture_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function () {
            $('#class').select2();
            $('#group').select2();
            $('#subject').select2();
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            // var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var lec_id = jQuery(this).parent('tr').attr("data-lec_id");
            var class_id = jQuery(this).parent('tr').attr("data-class_id");
            var group_id = jQuery(this).parent('tr').attr("data-group_id");
            var subject_id = jQuery(this).parent('tr').attr("data-subject_id");
            var title = jQuery(this).parent('tr').attr("data-title");
            var link = jQuery(this).parent('tr').attr("data-link");

            jQuery("#lec_id").val(lec_id);
            // jQuery("#remarks").val(remarks);
            jQuery("#group_id").val(group_id);
            jQuery("#class_id").val(class_id);
            jQuery("#subject_id").val(subject_id);
            jQuery("#title").val(title);
            jQuery("#link").val(link);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var lec_id = jQuery(this).attr("data-lec_id");

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
                    jQuery("#lec_id").val(lec_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
