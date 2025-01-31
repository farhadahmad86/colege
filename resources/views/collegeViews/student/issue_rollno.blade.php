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
                        <h4 class="text-white get-heading-text file_name">Issue Roll No</h4>
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
                      action="{{ route('issue_rollno') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
{{--                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">--}}
{{--                            <div class="input_bx">--}}
{{--                                <input tabindex="1" autofocus type="search" list="browsers"--}}
{{--                                       class="inputs_up form-control" name="search" id="search"--}}
{{--                                       placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"--}}
{{--                                       autocomplete="off">--}}
{{--                                <datalist id="browsers">--}}
{{--                                    @foreach ($student_title as $value)--}}
{{--                                        <option value="{{ $value }}">--}}
{{--                                    @endforeach--}}
{{--                                </datalist>--}}
{{--                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                            </div>--}}
{{--                        </div> <!-- left column ends here -->--}}
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <select class="inputs_up form-control" name="class" id="class">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{$class->class_id}}" {{$search_class == $class->class_id ? 'selected':''}}>{{$class->class_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <select class="inputs_up form-control" name="section" id="section">
                                    <option value="">Select Section</option>
                                    @foreach($sections as $section)
                                        <option value="{{$section->cs_id}}" {{$search_section == $section->cs_id ? 'selected':''}}>{{$section->cs_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <select class="inputs_up form-control" name="status" id="status">
                                    <option value="">Select Status</option>
                                    <option value="1" {{$search_status == 1 ? 'selected':''}}>Active</option>
                                    <option value="0" {{$search_status == 0 ? 'selected':''}}>De Active</option>

                                </select>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 text-right form_controls">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_student') }}"/>

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
            </div>
            <form name="delete" id="delete" action="{{ route('submit_rollno') }}" method="post">
                @csrf
                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_2">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_txt_15">
                                Name
                            </th>
                            <th scope="col" class="tbl_txt_5">
                                Reg #
                            </th>
                            <th scope="col" class="tbl_txt_30">
                                Class
                            </th>
                            <th scope="col" class="tbl_txt_5">
                                Roll No
                            </th>
                            <th scope="col" class="tbl_txt_5">
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
                                    <input type="hidden" name="student_id[]" value="{{$data->id}}">
                                </th>
                                <td>
                                    {{ $data->full_name }}
                                </td>
                                <td>
                                    {{ $data->registration_no }}
                                </td>
                                <td> {{$data->class_name}}</td>
                                <td><input type="text" class="inputs_up form-control" name="rollno[]" value="{{$data->roll_no}}"></td>

                                <td>{{$data->student_disable_enable == 1 ?'Active': 'De Active'}}</td>
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
                <div class="form-group row">
                    <div class="col-lg-2 col-md-2">
                        <button type="submit" name="save" id="save" class="save_button form-control">
                            Save
                        </button>
                    </div>
                </div>
            </form>
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
        var base = '{{ route('issue_rollno') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}
    <script>
        $(document).ready(function () {
            $('#class').select2();
            $('#section').select2();
        });
        $('#class').change(function () {
            var class_id = $(this).children('option:selected').val();
            $.ajax({
                url: '/get_groups',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function (data) {
                    console.log(data);
                    $('#section').html("");
                    var sections = '<option selected disabled hidden>Choose Section</option>';
                    $.each(data.section, function (index, items) {
                        sections +=
                            `<option value="${items.cs_id}"> ${items.cs_name} </option>`;
                    });

                    $('#section').html(sections);
                }
            })
        });
    </script>


    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
        });
    </script>



@endsection
