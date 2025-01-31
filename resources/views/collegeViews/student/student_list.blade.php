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
                        <h4 class="text-white get-heading-text file_name">Student List</h4>
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
                      action="{{ route('student_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>Search</label>
                                <input tabindex="1" autofocus type="search" list="browsers"
                                       class="inputs_up form-control" name="search" id="search"
                                       placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                       autocomplete="off">
                                <datalist id="browsers">
                                    @foreach ($student_title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <x-class-component tabindex="9" search="{{ $search_class }}" id="class" name="class"/>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-1 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>Section</label>
                                <select class="inputs_up form-control" name="section" id="section">
                                    <option value="">Select Section</option>
                                    @foreach($sections as $section)
                                        <option value="{{$section->cs_id}}" {{$search_section == $section->cs_id ? 'selected':''}}>{{$section->cs_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-1 col-md-2 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>Status</label>
                                <select class="inputs_up form-control" name="status" id="status">
                                    <option value="">Select Status</option>
                                    <option value="1" {{$search_status == 1 ? 'selected':''}}>Active</option>
                                    <option value="0" {{$search_status == 0 ? 'selected':''}}>De Active</option>

                                </select>
                            </div>
                        </div> <!-- left column ends here -->
                        <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12 text-right form_controls mt-3">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_student') }}"/>

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                {{-- <form name="left" id="left" action="{{ route('left_student') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    <input name="remarks" id="remarks" type="hidden">
                    <input name="student_id" id="student_id" type="hidden">
                </form> --}}
                <form name="delete" id="delete" action="{{ route('delete_student') }}" method="post">
                    @csrf
                    <input name="id" id="id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_2">
                            Sr#
                        </th>
                        <th scope="col" class="tbl_txt_12">
                            Name
                        </th>
                        <th scope="col" class="tbl_txt_5">
                            Reg #
                        </th>
                        <th scope="col" class="tbl_txt_12">
                            Class
                        </th>
                        <th scope="col" class="tbl_txt_5">
                            Contact
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            DOB
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Father Name
                        </th>
                        <th scope="col" class="tbl_txt_5">
                            Father Contact
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Admission Date
                        </th>
                        <th scope="col" class="tbl_txt_4">
                            City
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Branch
                        </th>

                        <th scope="col" class="tbl_txt_6">
                            Created By
                        </th>
                        <th scope="col" class="hide_column tbl_srl_5">
                            Enable
                        </th>
                        <th scope="col" class="hide_column tbl_srl_5">
                            Status
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
                        <tr data-title="{{ $data->full_name }}" data-student_id="{{ $data->id }}">
                            <th>
                                {{$sr}}
                            </th>
                            <td>
                                <img src="{{$data->profile_pic}}" width="40px" class="rounded-circle" alt="..."> {{ $data->full_name }}
                            </td>
                            <td>
                                {{ $data->registration_no }}
                            </td>
                            <td> {{$data->class_name}}</td>
                            <td>{{$data->contact}}</td>
                            <td>{{$data->dob}}</td>
                            <td>{{$data->father_name}}</td>
                            <td>{{$data->parent_contact}}</td>
                            <td>{{$data->admission_date}}</td>

                            <td>{{$data->city}}</td>
                            <td>{{$data->branch_name}}</td>

                            @php
                                $ip_browser_info = '' . $data->ip_adrs . ',' . str_replace(' ', '-', $data->brwsr_info) . '';
                            @endphp

                            <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}"
                                data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{ $data->user_name }}
                            </td>
                            <td class="text-center hide_column ">
                                <label class="switch">
                                    <input type="checkbox" <?php if ($data->student_disable_enable == 1) {
                                        echo 'checked="true"' . ' ' . 'value=' . $data->student_disable_enable;
                                    } else {
                                        echo 'value=DISABLE';
                                    } ?> class="enable_disable"
                                           data-id="{{ $data->id }}" {{ $data->student_disable_enable == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-center">
                                {{$data->status == 1 ? 'Active': ($data->status == 3 ? 'Stuck Off': ($data->status == 2 ? 'Graduate':'warning'))}}
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
                                    <h3 style="color:#554F4F">No Student</h3>
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
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'class'=>$search_class, 'section'=>$search_section, 'status'=>$search_status, 'year'=>$search_year])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('student_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function () {
            $('#status').select2();
            $('#section').select2();
            $('.enable_disable').change(function () {

                let status = $(this).prop('checked') === true ? 1 : 0;
                let stdId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_student') }}',
                    data: {
                        'status': status,
                        'id': stdId
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
            $("#class").select2().val(null).trigger("change");
            $("#class > option").removeAttr('selected');
            $("#section").select2().val(null).trigger("change");
            $("#section > option").removeAttr('selected');
        });
    </script>

    <script>
        $('.delete').on('click', function (event) {

            var student_id = jQuery(this).attr("data-student_id");

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
                    jQuery("#id").val(student_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
