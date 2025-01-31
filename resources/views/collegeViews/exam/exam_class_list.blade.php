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
                        <h4 class="text-white get-heading-text file_name">Exam Title : {{ $request->exam_name }}/ Exam Type :
                            {{ $request->type }}</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('exam_list') }}" name="form1" id="form1"
                    method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
{{--                                <label>--}}
{{--                                    All Data Search--}}
{{--                                </label>--}}
                                {{-- <input tabindex="1" autofocus type="search" list="browsers"
                                    class="inputs_up form-control" name="search" id="search"
                                    placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                    autocomplete="off"> --}}
                                <datalist id="browsers">
                                    {{-- @foreach ($exams as $value)
                                        <option value="{{ $value }}">
                                    @endforeach --}}
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <!-- left column ends here -->
                        <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 text-right form_controls">
                            {{-- @include('include.clear_search_button') --}}
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('create_exam') }}" />

                            {{-- @include('include/print_button') --}}
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="view_subject" id="view_subject" action="{{ route('group_subject_list') }}" method="post">
                    @csrf
                    <input name="class_id" id="class_id" type="hidden">
                    <input name="cs_id" id="cs_id" type="hidden">
                    <input name="ng_id" id="ng_id" type="hidden">
                    <input name="exam_name" id="exam_name" type="hidden">
                    <input name="exam_id" id="exam_id" type="hidden">
                </form>
                <form name="view_result" id="view_result" action="{{ route('class_result') }}" method="post">
                    @csrf
                    <input name="classs_id" id="classs_id" type="hidden">
                    <input name="section_id" id="section_id" type="hidden">
                    <input name="group_id" id="group_id" type="hidden">
                    <input name="exm_name" id="exm_name" type="hidden">
                    <input name="exm_id" id="exm_id" type="hidden">
                </form>
                <form name="view_sheet" id="view_sheet" action="{{ route('result_sheet') }}" method="post">
                    @csrf
                    <input name="clas_id" id="clas_id" type="hidden">
                    <input name="sect_id" id="sect_id" type="hidden">
                    <input name="gro_id" id="gro_id" type="hidden">
                    <input name="ex_name" id="ex_name" type="hidden">
                    <input name="ex_id" id="ex_id" type="hidden">
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
                                Sr#
                            </th>
                            <th scope="col" class="tbl_srl_16">
                                Class
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Section
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Group</th>
                            <th scope="col" class="tbl_txt_12">
                                Start Time</th>
                            <th scope="col" class="tbl_txt_12">
                                End Time</th>
                            {{-- <th scope="col" class="tbl_txt_8">
                                Branch
                            </th> --}}
                            <th scope="col" class="hide_column tbl_srl_32">
                                Action
                            </th>
                            <th scope="col" class="hide_column tbl_srl_32">
                                Result
                            </th>
                            <th scope="col" class="hide_column tbl_srl_32">
                                Result Sheet
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
                        @for ($i = 0; $i < count($classes); $i++)
                            <tr class="result text-center" data-class_id="{{ $classes[$i]['class_id'] }}"
                                data-cs_id="{{ $sections[$i]['cs_id'] }}" data-ng_id="{{ $ng_groups[$i]['ng_id'] }}"
                                data-exam_name="{{ $request->exam_name }}" data-exam_id="{{ $request->id }}">
                                <th scope="row">
                                    {{ $sr }}
                                </th>
                                <td class="edit">{{ $classes[$i]['class_name'] }}</td>
                                <td class="edit">{{ $sections[$i]['cs_name'] }}</td>
                                <td class="edit">{{ $ng_groups[$i]['ng_name'] }}</td>
                                <td class="edit">{{ $request->exam_start_date }}</td>
                                <td class="edit">{{ $request->exam_end_date }}</td>
                                {{-- <td class="edit">{{ $branch }} --}}
                                <td class="view_subject text-center">
                                    <button class="btn btn-primary ">Subject List</button>
                                </td>
                                <td class="view_result">
                                    <button class="btn btn-primary">Result</button>
                                </td>
                                <td class="view_sheet">
                                    <button class="btn btn-primary ">Result Sheet</button>
                                </td>
                                {{-- <td class="result text-center" data-classs_id="{{ $classes[$i]['class_id'] }}"
                                    data-section_id="{{ $sections[$i]['cs_id'] }}"
                                    data-group_id="{{ $ng_groups[$i]['ng_id'] }}"
                                    data-exm_name="{{ $request->exam_name }}" data-exm_id="{{ $request->id }}">
                                    <button class="btn btn-primary">Result</button>
                                </td> --}}

                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                            {{-- @empty
                        <tr>
                            <td colspan="11">
                                <center>
                                    <h3 style="color:#554F4F">No Exam</h3>
                                </center>
                            </td>
                        </tr>
                    @endempty --}}
                        @endfor

                    </tbody>
                </table>
            </div>
        </div><!-- row end -->

    @endsection

    @section('scripts')
        {{--    add code by shahzaib start --}}
        <script type="text/javascript">
            var base = '{{ route('exam_class_list') }}',
                url;

            @include('include.print_script_sh')
        </script>
        {{--    add code by shahzaib end --}}

        <script>
            $(document).ready(function() {

            });
        </script>

        <script>
            jQuery("#cancel").click(function() {
                $("#search").val('');
            });
        </script>

        <script>
            jQuery(".view_subject").click(function() {
                var class_id = jQuery(this).parent('tr').attr("data-class_id");
                var cs_id = jQuery(this).parent('tr').attr("data-cs_id");
                var ng_id = jQuery(this).parent('tr').attr("data-ng_id");
                var exam_name = jQuery(this).parent('tr').attr("data-exam_name");
                var exam_id = jQuery(this).parent('tr').attr("data-exam_id");
                jQuery("#class_id").val(class_id);
                jQuery("#cs_id").val(cs_id);
                jQuery("#ng_id").val(ng_id);
                jQuery("#exam_name").val(exam_name);
                jQuery("#exam_id").val(exam_id);
                jQuery("#view_subject").submit();
            });
            jQuery(".view_result").click(function() {
                var class_id = jQuery(this).parent('tr').attr("data-class_id");
                var cs_id = jQuery(this).parent('tr').attr("data-cs_id");
                var ng_id = jQuery(this).parent('tr').attr("data-ng_id");
                var exm_name = jQuery(this).parent('tr').attr("data-exam_name");
                var exm_id = jQuery(this).parent('tr').attr("data-exam_id");
                jQuery("#classs_id").val(class_id);
                jQuery("#section_id").val(cs_id);
                jQuery("#group_id").val(ng_id);
                jQuery("#exm_name").val(exm_name);
                jQuery("#exm_id").val(exm_id);
                jQuery("#view_result").submit();
            });
            jQuery(".view_sheet").click(function() {
                var class_id = jQuery(this).parent('tr').attr("data-class_id");
                var cs_id = jQuery(this).parent('tr').attr("data-cs_id");
                var ng_id = jQuery(this).parent('tr').attr("data-ng_id");
                var exm_name = jQuery(this).parent('tr').attr("data-exam_name");
                var exm_id = jQuery(this).parent('tr').attr("data-exam_id");
                jQuery("#clas_id").val(class_id);
                jQuery("#sect_id").val(cs_id);
                jQuery("#gro_id").val(ng_id);
                jQuery("#ex_name").val(exm_name);
                jQuery("#ex_id").val(exm_id);
                jQuery("#view_sheet").submit();
            });

            $('.delete').on('click', function(event) {

                var exam_id = jQuery(this).attr("data-exam_id");

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
                        jQuery("#exam_id").val(exam_id);
                        jQuery("#delete").submit();
                    } else {

                    }
                });
            });
        </script>


    @endsection
