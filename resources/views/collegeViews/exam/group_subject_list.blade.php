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
                        <h4 class="text-white get-heading-text file_name">Exam Title : {{ $exam_name }}/Class Name
                            :{{$class}}</h4>
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
                            <x-add-button tabindex="9" href="{{ route('create_exam') }}"/>
                            {{-- <button class="back_route"><i class="fa fa-arrow-left" aria-hidden="true"></i></button> --}}

                            {{-- @include('include/print_button') --}}
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                                <form name="mark_subject" id="mark_subject" action="{{ route('mark_subject') }}" method="post">
                                    @csrf
                                    <input name="class_id" id="class_id" type="hidden">
                                    <input name="cs_id" id="cs_id" type="hidden">
                                    <input name="ng_id" id="ng_id" type="hidden">
                                    <input name="exam_name" id="exam_name" type="hidden">
                                    <input name="subject_id" id="subject_id" type="hidden">
                                    <input name="exam_id" id="exam_id" type="hidden">
                                    <input name="date" id="date" type="hidden">
                                </form>
                <form name="subject_mark_report" id="subject_mark_report" action="{{ route('subject_mark_report') }}"
                      method="post">
                    @csrf
                    <input name="class_id" id="class_id" type="hidden">
                    <input name="cs_id" id="cs_id" type="hidden">
                    <input name="ng_id" id="ng_id" type="hidden">
                    <input name="exam_name" id="exam_name" type="hidden">
                    <input name="subject_id" id="subject_id" type="hidden">
                    <input name="exam_id" id="exam_id" type="hidden">
                </form>
                {{-- <form name="view_subject" id="view_subject" action="{{ route('exam_class_list') }}" method="post">
                    @csrf
                    <input name="class_id" id="class_id" type="hidden">
                    <input name="cs_id" id="cs_id" type="hidden">
                    <input name="ng_id" id="ng_id" type="hidden">
                    <input name="exam_name" id="exam_name" type="hidden">
                    <input name="exam_id" id="exam_id" type="hidden">
                </form> --}}
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
                            Subject
                        </th>
                        {{-- <th scope="col" class="hide_column tbl_srl_32">
                            Date
                        </th> --}}
                        <th scope="col" class="hide_column tbl_srl_32">
                            Action
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
                    @forelse($subjects as $subject)
                        <tr>
                            <th scope="row">
                                {{ $sr }}
                            </th>
                            <td class="edit ">
                                {{ $subject->subject_name }}
                            </td>
{{--                            <td>--}}
{{--                                <input tabindex="2" type="text" name="to" id="to"--}}
{{--                                       class="inputs_up form-control datepicker1" autocomplete="off" value=""--}}
{{--                                       placeholder="Start Date ......">--}}

{{--                            </td>--}}
                            <td class="mark_subject" data-class_id="{{ $class_id }}"
                                data-cs_id="{{ $cs_id }}" data-ng_id="{{ $ng_id }}"
                                data-subject_id="{{ $subject->subject_id }}" data-exam_name="{{ $exam_name }}"
                                data-exam_id="{{ $exam_id }}">
                                <button class="btn btn-primary class_list">Enter Marks</button>
                            </td>
                            {{--                            <td>--}}
                            {{--                                <a href="{{route('mark_subject',['exam_id' => $exam_id,'subject'=> $subject->subject_id,'cs_id'=>$cs_id,'class_id'=>$class_id,'ng_id'=>$ng_id,'exam_name'=>$exam_name])}}"></a>--}}
                            {{--                                <button class="btn btn-primary class_list">Enter Marks</button>--}}
                            {{--                            </td>--}}

                            {{-- <td class="subject_mark_report" data-class_id="{{ $request->class_id }}"
                                data-cs_id="{{ $request->cs_id }}" data-ng_id="{{ $request->ng_id }}"
                                data-subject_id="{{ $subject->subject_id }}" data-exam_name="{{ $request->exam_name }}" data-exam_id="{{ $request->exam_id }}">
                                <button class="btn btn-primary class_list">Report</button>
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
                                    <h3 style="color:#554F4F">No Subject</h3>
                                </center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {{-- <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span> --}}
                </div>
                <div class="col-md-9 text-right">
                    <span></span> {{-- class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search])->links() }}</span> --}}
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('group_subject_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function () {
            // disable browser back button
            history.pushState(null, null, location.href);
            window.onpopstate = function () {
                history.go(1);
            }
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(".mark_subject").click(function () {

            var class_id = jQuery(this).attr("data-class_id");
            var cs_id = jQuery(this).attr("data-cs_id");
            var ng_id = jQuery(this).attr("data-ng_id");
            var subject_id = jQuery(this).attr("data-subject_id");
            var exam_name = jQuery(this).attr("data-exam_name");
            var exam_id = jQuery(this).attr("data-exam_id");
            // var date = jQuery('#to').val();
            // alert(date);
            jQuery("#class_id").val(class_id);
            jQuery("#cs_id").val(cs_id);
            jQuery("#ng_id").val(ng_id);
            jQuery("#subject_id").val(subject_id);
            jQuery("#exam_name").val(exam_name);
            jQuery("#exam_id").val(exam_id);
            // jQuery("#date").val(date);
            jQuery("#mark_subject").submit();

        });
        // jQuery(".mark_subject").click(function() {

        //     var class_id = jQuery(this).attr("data-class_id");
        //     var cs_id = jQuery(this).attr("data-cs_id");
        //     var ng_id = jQuery(this).attr("data-ng_id");
        //     var exam_name = jQuery(this).attr("data-exam_name");
        //     var exam_id = jQuery(this).attr("data-exam_id");
        //     jQuery("#class_id").val(class_id);
        //     jQuery("#cs_id").val(cs_id);
        //     jQuery("#ng_id").val(ng_id);
        //     jQuery("#exam_name").val(exam_name);
        //     jQuery("#exam_id").val(exam_id);
        //     jQuery("#mark_subject").submit();

        // });
        $('.delete').on('click', function (event) {

            var exam_id = jQuery(this).attr("data-exam_id");

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
                    jQuery("#exam_id").val(exam_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>

@endsection
