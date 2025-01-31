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
                        <h4 class="text-white get-heading-text file_name">Section Exam Report</h4>
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
                                <input tabindex="1" autofocus type="search" list="browsers"
                                    class="inputs_up form-control" name="search" id="search"
                                    placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                    autocomplete="off">
                                <datalist id="browsers">
                                    @foreach ($exams as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <!-- left column ends here -->
                        <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 text-right form_controls">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('create_exam') }}" />

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_exam') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    <input name="exam_type" id="exam_type" type="hidden">
                    <input name="branch_id" id="branch_id" type="hidden">
                    <input name="end_date" id="end_date" type="hidden">
                    <input name="start_date" id="start_date" type="hidden">
                    <input name="exam_id" id="exam_id" type="hidden">
                    <input name="class_id" id="class_id" type="hidden">
                </form>
                <form name="view_list" id="view_list" action="{{ route('exam_class_list') }}" method="post">
                    @csrf
                    <input name="exam_name" id="exam_name" type="hidden">
                    <input name="type" id="type" type="hidden">
                    <input name="exam_branch_id" id="exam_branch_id" type="hidden">
                    <input name="exam_start_date" id="exam_start_date" type="hidden">
                    <input name="exam_end_date" id="exam_end_date" type="hidden">
                    <input name="id" id="id" type="hidden">
                    <input name="exam_class_id" id="exam_class_id" type="hidden">
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
                            <th scope="col" class="tbl_srl_2">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Registration No
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Roll No
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Name
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Father Name
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Total Mark
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Obtained Marks
                            </th>
                            <th scope="col" class="hide_column tbl_srl_12">
                                Per %
                            </th>
                            <th scope="col" class="hide_column tbl_srl_12">
                                GRADE
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                            $array = ['blue', 'red', 'green', 'red'];
                            if (!empty($subject_marks)) {
                                $array_std = json_decode($subject_marks->me_students);
                                $array_marks = json_decode($subject_marks->me_obtain_marks);
                                $array_per = json_decode($subject_marks->me_precentage);
                                $array_grade = json_decode($subject_marks->me_grade);
                            }
                        @endphp
                        @forelse($students as $student)
                            <tr>
                                <th scope="row">
                                    {{ $sr }}
                                </th>
                                <td class="edit ">
                                    {{ $student->registration_no }}
                                </td>
                                <td class="edit ">
                                    {{ $student->roll_no }}
                                </td>
                                <td class="edit ">
                                    {{ $student->full_name }}
                                </td>
                                <td class="edit ">
                                    {{ $student->father_name }}
                                </td>
                                <td class="edit ">
                                    {{-- <input type="hidden" name="per[]" id="per{{ $student->id }}"> --}}
                                    <span
                                        class="total_marks">{{ !empty($subject_marks) ? $subject_marks->me_total_marks : '' }}</span>
                                </td>
                                @if (!empty($subject_marks))
                                    @foreach ($array_std as $key => $value)
                                        @if ($value == $student->id)
                                            <td class="edit ">
                                                <input type="text" name="obtain_marks[]"
                                                    id="obtain_marks{{ $student->id }}"
                                                    value="{{ $array_marks[$key] }}"
                                                    onkeyup="calculation({{ $student->id }})">
                                            </td>
                                            <td>
                                                <input type="hidden" name="per[]" id="per{{ $student->id }}"
                                                    value="{{ $array_per[$key] }}">
                                                <span
                                                    id="per_display{{ $student->id }}">{{ $array_per[$key] }}</span>
                                                <input type="hidden" value="{{ $student->id }}"
                                                    name="student_id[]">
                                            </td>
                                            <td>
                                                <input type="hidden" name="grade[]" id="grade{{ $student->id }}"
                                                    value="{{ $array_grade[$key] }}">
                                                <span
                                                    id="grade_display{{ $student->id }}">{{ $array_grade[$key] }}</span>
                                            </td>
                                        @endif
                                    @endforeach
                                @else
                                    <td class="edit ">
                                        <input type="text" name="obtain_marks[]"
                                            id="obtain_marks{{ $student->id }}"
                                            onkeyup="calculation({{ $student->id }})">
                                    </td>
                                    <td>
                                        <input type="hidden" name="per[]" id="per{{ $student->id }}">
                                        <span id="per_display{{ $student->id }}"></span>
                                        <input type="hidden" value="{{ $student->id }}" name="student_id[]">
                                    </td>
                                    <td>
                                        <input type="hidden" name="grade[]" id="grade{{ $student->id }}">
                                        <span id="grade_display{{ $student->id }}"></span>
                                    </td>
                                @endif


                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center>
                                        <h3 style="color:#554F4F">No Exam</h3>
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
        var base = '{{ route('exam_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function() {
            // $('.enable_disable').change(function() {
            //     let status = $(this).prop('checked') === true ? 1 : 0;
            //     let exam_id = $(this).data('id');
            //     $.ajax({
            //         type: "GET",
            //         dataType: "json",
            //         url: '{{ route('enable_disable_class') }}',
            //         data: {
            //             'status': status,
            //             'exam_id': exam_id
            //         },
            //         success: function(data) {
            //             console.log(data.message);
            //         }
            //     });
            // });
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
            var exam_id = jQuery(this).parent('tr').attr("data-exam_id");
            var class_id = jQuery(this).parent('tr').attr("data-class_id");
            var exam_type = jQuery(this).parent('tr').attr("data-exam_type");
            var branch_id = jQuery(this).parent('tr').attr("data-branch_id");
            var start_date = jQuery(this).parent('tr').attr("data-start_date");
            var end_date = jQuery(this).parent('tr').attr("data-end_date");
            jQuery("#title").val(title);
            jQuery("#exam_id").val(exam_id);
            jQuery("#class_id").val(class_id);
            jQuery("#branch_id").val(branch_id);
            jQuery("#exam_type").val(exam_type);
            jQuery("#start_date").val(start_date);
            jQuery("#end_date").val(end_date);
            jQuery("#edit").submit();
        });
        jQuery(".view_list").click(function() {

            var exam_name = jQuery(this).attr("data-exam_name");
            var id = jQuery(this).attr("data-id");
            var exam_start_date = jQuery(this).attr("data-exam_start_date");
            var exam_branch_id = jQuery(this).attr("data-exam_branch_id");
            var exam_end_date = jQuery(this).attr("data-exam_end_date");
            var exam_class_id = jQuery(this).attr("data-exam_class_id");
            var type = jQuery(this).attr("data-type");
            jQuery("#exam_name").val(exam_name);
            jQuery("#id").val(id);
            jQuery("#exam_start_date").val(exam_start_date);
            jQuery("#exam_branch_id").val(exam_branch_id);
            jQuery("#exam_end_date").val(exam_end_date);
            jQuery("#exam_class_id").val(exam_class_id);
            jQuery("#type").val(type);
            jQuery("#view_list").submit();
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
