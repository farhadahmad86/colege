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
            <div class="form_header d-flex">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Exam Title : {{ $request->exam_name }}/Class Name
                            :{{ $class }}</h4>
                    </div>
                </div>
                <div class="d-flex ml-auto">
                    <div class="view_result ml-2">
                        <button class="btn btn-primary">Result</button>
                    </div>
                    <div class="view_sheet ml-2">
                        <button class="btn btn-primary">Result Sheet</button>
                    </div>
                </div>
            </div><!-- form header close -->
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
            <form class="highlight prnt_lst_frm" action="{{ route('mark_subject') }}" name="form1" id="edit"
                  method="post">
                <div class="row">
                    @csrf
                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <label for="">Subject</label>
                            <select tabindex="1" autofocus name="subject_id" class="form-control required" id="subject_id"
                                    autofocus data-rule-required="true" data-msg-required="Please Enter Subject">
                                <option value="" disabled>Select Subject</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->subject_id }}"
                                        {{ $subject->subject_id == $search_subject ? 'selected' : '' }}>
                                        {{ $subject->subject_name }}</option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                        <input type="hidden" value="{{ $request->exam_id }}" name="exam_id">
                        <input type="hidden" value="{{ $request->class_id }}" name="class_id">
                        <input type="hidden" value="{{ $request->ng_id }}" name="ng_id">
                        <input type="hidden" value="{{ $request->cs_id }}" name="cs_id">
                    </div>
                    <!-- left column ends here -->
                    <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 text-right form_controls">
                        {{-- @include('include.clear_search_button') --}}
                        @include('include/print_button')
                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                    </div>
                </div><!-- end row -->
            </form>
            <form action="{{ route('store_exam_marks') }}" method="POST">
                @csrf
                <input type="hidden" name="me_id" value="{{ !empty($subject_marks) ? $subject_marks->me_id : '' }}">
                <div class="table-responsive" style="overflow-x: hidden !important" id="printTable">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12" hidden>
                        <div class="input_bx">
                            <label for="">Subject</label>
                            <select tabindex="1" autofocus name="subject" class="form-control required" id="subject"
                                    autofocus data-rule-required="true" data-msg-required="Please Enter Subject">
                                <option value="" disabled>Select Subject</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->subject_id }}"
                                        {{ $subject->subject_id == $search_subject ? 'selected' : '' }}>
                                        {{ $subject->subject_name }}</option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div>
                    {{-- <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <input tabindex="2" type="text" name="date" id="date"
                                   class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_by_date)){?>
                                   value="{{ $search_by_date }}" <?php } ?> placeholder="Date ......"/>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
                    </div> --}}
                    <input type="hidden" value="{{ $request->exam_id }}" name="exam_id">
                    <input type="hidden" value="{{ $search_class }}" name="class_id">
                    <input type="hidden" value="{{ $request->ng_id }}" name="ng_id">
                    <input type="hidden" value="{{ $request->cs_id }}" name="cs_id">
                    <input type="hidden" id="passing_marks" value="" name="passing_marks">
                    <input type="hidden" id="total_marks" value="" name="total_marks">
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <label for="">Total Marks</label>
                            <input class="t_marks" id="t_marks" type="text"
                                   value="{{ !empty($subject_marks) ? $subject_marks->me_total_marks : '' }}">
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <label for="">Passing Marks</label>
                            <input class="p_marks" id="p_marks" type="text"
                                   value="{{ !empty($subject_marks) ? $subject_marks->me_passing_marks : '' }}">
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                        <!-- left column ends here -->
                        <div class="col-lg-2 col-md-9 col-sm-12 col-xs-12 mt-4">
                            <button class="btn btn-sm btn-primary" id="apply" type="button">Apply</button>
                        </div>
                    </div><!-- end row -->
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
                                Enter Marks
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
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                            <button tabindex="1" type="submit" name="save" id="save"
                                    class="save_button btn btn-sm btn-success">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div><!-- row end -->
    </div>
@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}

    {{--    add code by shahzaib end --}}
    <script type="text/javascript">
        var base = '{{ route('mark_subject') }}',
            url;

        @include('include.print_script_sh')
    </script>
    <script type="text/javascript">
        function checkForm() {
            let t_marks = document.getElementById("t_marks"),
                p_marks = document.getElementById("p_marks"),
                validateInputIdArray = [
                    t_marks.id,
                    p_marks.id,
                    // class_incharge_id.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }

    </script>

    <script>
        // $(document).ready(function () {
        //     // disable browser back button
        //     history.pushState(null, null, location.href);
        //     window.onpopstate = function () {
        //         history.go(1);
        //     }
        // });
    </script>

    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#subject').select2();
            $('#subject_id').select2();
            var t_marks = $('#t_marks').val();
            var pass_marks = $('#p_marks').val();
            document.getElementById('passing_marks').value = pass_marks;
            document.getElementById('total_marks').value = t_marks;
            // alert(t_marks);
            // alert(pass_marks);
        });

        $('#apply').on('click', function () {
            let t_marks = $('#t_marks').val();
            $('.total_marks').html(t_marks);
            var pass_marks = $('#p_marks').val();

            document.getElementById('total_marks').value = t_marks;
            document.getElementById('passing_marks').value = pass_marks;

        });
        jQuery(".view_result").click(function () {
            var class_id = {!! $request->class_id !!};
            var cs_id = {!! $request->cs_id !!};
            var ng_id = {!! $request->ng_id !!};
            var exm_name = (`{!! $request->exam_name !!}`);
            var exm_id = {!! $request->exam_id !!};
            jQuery("#classs_id").val(class_id);
            jQuery("#section_id").val(cs_id);
            jQuery("#group_id").val(ng_id);
            jQuery("#exm_name").val(exm_name);
            jQuery("#exm_id").val(exm_id);
            jQuery("#view_result").submit();
        });
        jQuery(".view_sheet").click(function () {
            var class_id = {!! $request->class_id !!};
            var cs_id = {!! $request->cs_id !!};
            var ng_id = {!! $request->ng_id !!};
            var exm_name = (`{!! $request->exam_name !!}`);
            var exm_id = {!! $request->exam_id !!};
            jQuery("#clas_id").val(class_id);
            jQuery("#sect_id").val(cs_id);
            jQuery("#gro_id").val(ng_id);
            jQuery("#ex_name").val(exm_name);
            jQuery("#ex_id").val(exm_id);
            jQuery("#view_sheet").submit();
        });

        function calculation(id) {
            var t_marks = $('#t_marks').val();
            var pass_marks = $('#p_marks').val();
            var obtain_marks = $('#obtain_marks' + id).val();
            var per = (obtain_marks * 100) / t_marks;
            document.getElementById('passing_marks').value = pass_marks;
            document.getElementById('total_marks').value = t_marks;
            $('#per' + id).val(per);
            $('#per_display' + id).html(per);
            if (!t_marks) {
                $('#t_marks').focus();
                $('#p_marks' + id).val('');
                $('#obtain_marks' + id).val('');
                $('#grade' + id).val('');
                $('#grade_display' + id).html('');
                $('#per' + id).val('');
                $('#per_display' + id).html('');
                alert('Enter the Total Marks First');

            } else if (!pass_marks) {
                $('#p_marks').focus();
                $('#obtain_marks' + id).val('');
                $('#grade' + id).val('');
                $('#grade_display' + id).html('');
                $('#per' + id).val('');
                $('#per_display' + id).html('');
                alert('Enter the Passing Marks First');

            } else if (parseFloat(pass_marks) > parseFloat(t_marks)) {
                $('#p_marks').focus();
                $('#p_marks').val('');
                $('#obtain_marks' + id).val('');
                $('#grade' + id).val('');
                $('#grade_display' + id).html('');
                $('#per' + id).val('');
                $('#per_display' + id).html('');
                alert('Passing Marks greate than Total Marks');
            } else if (parseFloat(obtain_marks) > parseFloat(t_marks)) {
                $('#obtain_marks' + id).val('');
                $('#grade' + id).val('');
                $('#grade_display' + id).html('');
                $('#per' + id).val('');
                $('#per_display' + id).html('');
                alert('The Obtained Marks is greater than the Total Marks');

                // $('#grade_display' + id).html('Pass');
            } else if (parseFloat(obtain_marks) >= parseFloat(pass_marks)) {
                $('#grade' + id).val('Pass');
                $('#grade_display' + id).html('Pass');

            } else {
                $('#grade' + id).val('Failed');
                $('#grade_display' + id).html('Failed');

            }
        }

        $('#subject_id').change(function () {
            jQuery("#edit").submit();
        })
    </script>
<script>
    $('#date').on('change', function() {
    alert('Date changed');
    // Rest of your code...
});
    // $(document).ready(function() {
        // Assuming you have an input with id "datePicker"
    //     $('#datePicker').on('click', function() {
    //         var selectedDate = $(this).val();
    //         var class_id = {!! $request->class_id !!};
    //         var section_id ={!! $request->cs_id !!};
    //         alert(12);
    //         // Send an AJAX request to your Laravel backend
    //         $.ajax({
    //             url: '/get_present_student',
    //             type: 'get',
    //             dataType: 'text',
    //             data: {
    //                 'class_id': class_id,
    //                 'date': selectedDate,
    //                 'section_id': section_id,
    //             },
    //             success: function(data) {
    //                 console.log(data);
    //                 // var sections = '<option selected disabled hidden>Choose Section</option>';
    //                 // $.each(data.section, function(index, items) {
    //                 //     sections +=
    //                 //         `<option value="${items.cs_id}"> ${items.cs_name} </option>`;


    //                 // });

    //                 // $('#section').html(sections);
    //             }
    //         });
    // });
</script>

@endsection
