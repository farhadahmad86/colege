@extends('extend_index')
@section('styles_get')
    <style>
        .action_td .dropdown .dropdown-toggle::after {
            content: unset !important;
        }

        .bg-purple {
            background-color: #993EF0 !important;
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
                        <h4 class="text-white get-heading-text file_name">Result</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('class_result') }}" name="form1" id="form1"
                      method="post">
                    <div class="row">
                        @csrf
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h6>Exam Title : {{ $request->exm_name }}</h6>
                            <h6>Class Name:{{ $class }}</h6>
                            <h6>Section:{{ $section }}</h6>
                            <h6>Group:{{ $group }}</h6>
                        </div>
                        <!-- left column ends here -->
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right form_controls">

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            {{-- <select name="sort" id="sort" onchange="">
                                <option value="position">Sort The Student</option>
                                <option value="position">Position</option>
                                <option value="name">Name</option>
                            </select> --}}
                        </div>
                        <input type="hidden" value="{{ $request->classs_id }}" name="classs_id">
                        <input type="hidden" value="{{ $request->group_id }}" name="group_id">
                        <input type="hidden" value="{{ $request->section_id }}" name="section_id">
                        <input type="hidden" value="{{ $request->exm_id }}" name="exm_id">
                        <input type="hidden" value="{{ $request->exm_name }}" name="exm_name">
                    </div><!-- end row -->
                </form>
                <form name="delete" id="delete" action="{{ route('delete_classes') }}" method="post">
                    @csrf
                    <input name="class_id" id="class_id" type="hidden">
                </form>
            </div>

            {{-- <input type="hidden" name="me_id" value="{{ !empty($subject_marks) ? $subject_marks->me_id : '' }}"> --}}
            <div class="table-responsive" style="overflow-x: hidden !important" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_2">
                            ID
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            Roll No
                            <i class="fa fa-sort-up" aria-hidden="true" id="rollNOSortASC"></i>
                            <i class="fa fa-sort-desc" aria-hidden="true" id="rollNOSortDesc"></i>
                        </
                        </th>
                        <th scope="col" class="tbl_txt_12" id="">
                            Name
                        </th>
                        <th scope="col" class="tbl_txt_12">
                            Father Name
                        </th>
                        @foreach ($class_marks as $class_mark)
                            <th scope="col" class="tbl_txt_5">
                                @foreach ($subjects as $subject)
                                    @if ($subject->subject_id == $class_mark->me_subject_id)
                                        {{ $subject->subject_name }}-{{ $class_mark->me_total_marks }}
                                        {{-- Display the obtain marks for the subject --}}
                                    @endif
                                @endforeach
                            </th>
                        @endforeach
                        <th scope="col" class="tbl_txt_4">
                            Obtained Marks
                        </th>
                        <th scope="col" class="tbl_txt_4">
                            Total Mark
                        </th>
                        <th scope="col" class="hide_column tbl_srl_8">
                            Per %
                            <i class="fa fa-sort-up" aria-hidden="true" id="percentageSortASC"></i>
                            <i class="fa fa-sort-desc" aria-hidden="true" id="percentageSortDesc"></i>
                        </th>
                        <th scope="col" class="hide_column tbl_srl_10">
                            Zone
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
                        $percentage = [];
                    @endphp
                    <script>
                        var percentageSort = [];
                        var rollNOSort = [];
                    </script>
                    @forelse($students as $student)
                        @if ($student)
                            <tr>
                                <th scope="row">
                                    {{ $sr }}
                                </th>
                                <td>
                                    {{ $student->roll_no }}
                                </td>
                                <td>
                                    {{ $student->full_name }}
                                </td>
                                <td>
                                    {{ $student->father_name }}
                                </td>
                                @php
                                    $obtained_marks = 0;
                                    $total_marks = 0;
                                @endphp
                                @foreach ($class_marks as $class_mark)
                                    @php
                                        $numericArray = json_decode($class_mark->me_obtain_marks, true);
                                        $studentsArray = json_decode($class_mark->me_students, true);
                                        if (is_array($numericArray)) {
                                            $numericArray = array_map('intval', $numericArray);
                                            $studentsArray = array_map('intval', $studentsArray);
                                            // Fetch student details based on student IDs
                                    //         foreach ($numericArray as $item) {
                                    //     $percentage = number_format($item / $class_mark->me_total_marks * 100, 2);
                                    //     if ($percentage < 50 || $percentage <= 0 || $percentage == null) {
                                    //         $red++;
                                    //     } elseif ($percentage >= 50 && $percentage <= 65) {
                                    //         $purple++;
                                    //     } elseif ($percentage >= 65 && $percentage <= 75) {
                                    //         $blue++;
                                    //     } elseif ($percentage >= 75 && $percentage <= 85) {
                                    //         $yellow++;
                                    //     } elseif ($percentage >= 85 && $percentage <= 100) {
                                    //         $green++;
                                    //     }
                                    // }
                                        }
                                    @endphp
                                    <td>
                                        @php
                                            $processedSubjectIds = []; // Initialize an array to store processed subject IDs
                                        @endphp

                                        @foreach ($subjects as $subject)
                                            @if (!in_array($subject->subject_id, $processedSubjectIds))
                                                {{-- Check if the subject ID has not been processed --}}
                                                @php
                                                    array_push($processedSubjectIds, $subject->subject_id); // Add the subject ID to the processed list
                                                @endphp

                                                @if ($subject->subject_id == $class_mark->me_subject_id)
                                                    @if ($numericArray)
                                                        @foreach ($studentsArray as $key => $value)
                                                            @if ($value == $student->id)
                                                                @php
                                                                    $obtained_marks = $obtained_marks + $numericArray[$key];
                                                                    $total_marks = $total_marks + $class_mark->me_total_marks;
                                                                @endphp
                                                                {{ $numericArray[$key] }}
                                                            @endif
                                                        @endforeach
                                                        {{-- Display the obtain marks for the subject --}}
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>

                                @endforeach
                                <td class="edit ">
                                    {{ $obtained_marks }}
                                </td>

                                <td class="edit ">
                                    {{ $total_marks }}
                                </td>
                                <td class="edit ">

                                    @php
                                        $formated = 0;
                                        $color = '';
                                        $color_name = '';
                                        $percentages = [];
                                        if ($obtained_marks > 0) {
                                            $percentage = ($obtained_marks * 100) / $total_marks;
                                            $color_name = '';
                                            $color = '';
                                            $formated = sprintf('%0.2f', $percentage);
                                            if ($percentage <= 40|| $percentage == null) {
                                                $color_name = 'bg-danger';
                                                $color = 'Red';
                                            } elseif ($percentage > 40 && $percentage <= 65) {
                                                $color_name = 'bg-purple';
                                                $color = 'Purple';
                                            } elseif ($percentage > 65 && $percentage <= 75) {
                                                $color_name = 'bg-primary';
                                                $color = 'Blue';
                                            } elseif ($percentage > 75 && $percentage <= 85) {
                                                $color_name = 'bg-warning';
                                                $color = 'Yellow';
                                            } elseif ($percentage > 85 && $percentage <= 100) {
                                                $color_name = 'bg-success';
                                                $color = 'Green';
                                            }
                                        } else {
                                            $formated = 0;
                                        }
                                    @endphp
                                    {{ $formated }}%
                                </td>
                                <script>
                                    var percentage = {!! $formated !!};
                                    var roll_no = {!! $student->roll_no !!}
                                    percentageSort.push(percentage);
                                    rollNOSort.push(roll_no);
                                </script>
                                <td>
                                            <span
                                                class="badge rounded-pill {{ $formated == 0 ? 'bg-danger' : $color_name }} text-white">{{  $formated == 0 ? 'Red' : $color }}</span>
                                </td>
                            </tr>
                        @endif
                        @php
                            $sr++;
                            !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center>
                                    <h3 style="color:#554F4F">No Result</h3>
                                </center>
                            </td>
                        </tr>

                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="table-responsive" style="overflow-x: hidden !important" id="printTable">
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th colspan="2">Subject Name</th>
                        <th colspan="2">Teacher Name</th>

                        <th colspan="2">Total Passed</th>

                        <th>Total Failed</th>

                        <th style="background-color: rgb(28, 146, 44) !important; color: white">Green 86% to 100%</th>

                        <th style="background-color: rgb(246, 136, 31) !important; color: white">Yellow 76% to 85%</th>

                        <th style="background-color: rgb(37, 43, 102) !important; color: white">Blue 66% to 75%</th>

                        <th style="background-color: rgb(153, 62, 240) !important; color: white">Purple 40% to 65%</th>

                        <th style="background-color: rgb(220, 53, 69) !important; color: white">Red Less than 40%</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($class_marks as $class_mark)
                        @php
                            $red = 0;
                            $purple = 0;
                            $blue = 0;
                            $yellow = 0;
                            $green = 0;
                            $numericArray = json_decode($class_mark->me_obtain_marks, true);
                            $studentsArray = json_decode($class_mark->me_students, true);
                            if (is_array($numericArray) && $class_mark->me_total_marks > 0) { // Ensure total marks are greater than zero
                                $numericArray = array_map('intval', $numericArray);
                                $studentsArray = array_map('intval', $studentsArray);
                                // Fetch student details based on student IDs
                                foreach ($numericArray as $item) {
                                    $percentage = $item > 0 ? number_format($item / $class_mark->me_total_marks * 100, 2) : 0;
                                    if ($percentage <= 0  || $percentage == null || $percentage == 0 || $percentage <= 39) {
                                        $red++;
                                    } elseif ($percentage >= 40 && $percentage <= 65) {
                                        $purple++;
                                    } elseif ($percentage > 65 && $percentage <= 75) {
                                        $blue++;
                                    } elseif ($percentage > 75 && $percentage <= 85) {
                                        $yellow++;
                                    } elseif ($percentage > 85 && $percentage <= 100) {
                                        $green++;
                                    }
                                }
                            }
                            $t_passed = $green + $yellow + $blue + $purple;
                        @endphp
                        <tr>

                            <td colspan="2"><b>{{$class_mark->subject_name}}</b></td>
                            <td colspan="2"><b>
                                    @foreach($teachers as $key => $teacher)
                                        @if($class_mark->me_subject_id == $teacher->tmi_subject_id)
                                            {{$teacher->user_name}}
                                        @endif
                                    @endforeach
                                </b></td>

                            <td colspan="2">{{$t_passed}}</td>
                            <td>{{$red}}</td>
                            <td>{{$green}}</td>
                            <td>{{$yellow}}</td>
                            <td>{{$blue}}</td>
                            <td>{{$purple}}</td>
                            <td>{{$red}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- row end -->
    </div>
@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('class_result') }}',
            url;
        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function () {


        });
    </script>

    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
        });
        $('#percentageSortASC').on('click', function () {
            var table = $('#fixTable');
            var rows = table.find('tbody > tr').get();
            rows.sort(function (a, b) {
                var x =  parseFloat($(a).children('td').eq($(a).children('td').length - 2).text());
                var y =  parseFloat($(b).children('td').eq($(b).children('td').length - 2).text());
                return $.isNumeric(x) && $.isNumeric(y) ? x - y : y.localeCompare(x);
            });
            $.each(rows, function (index, row) {
                table.children('tbody').append(row);
            });
        });

        $('#percentageSortDesc').on('click', function () {
            var table = $('#fixTable');
            var rows = table.find('tbody > tr').get();
            rows.sort(function (a, b) {
                var x =  parseFloat($(a).children('td').eq($(a).children('td').length - 2).text());
                var y =  parseFloat($(b).children('td').eq($(b).children('td').length - 2).text());
                return $.isNumeric(x) && $.isNumeric(y) ? y - x : x.localeCompare(y);
            });
            $.each(rows, function (index, row) {
                table.children('tbody').append(row);
            });
        });
        $('#rollNOSortASC').on('click', function () {
            var table = $('#fixTable');
            var rows = table.find('tbody > tr').get();
            rows.sort(function (a, b) {
                var x = $(a).children('td').eq(0).text().toUpperCase();
                var y = $(b).children('td').eq(0).text().toUpperCase();
                return $.isNumeric(x) && $.isNumeric(y) ? x - y : y.localeCompare(x);
            });

            $.each(rows, function (index, row) {
                table.children('tbody').append(row);
            });
        });


        $('#rollNOSortDesc').on('click', function () {

            var table = $('#fixTable');
            var rows = table.find('tbody > tr').get();
            rows.sort(function (a, b) {

                var x = $(a).children('td').eq(0).text().toUpperCase();
                var y = $(b).children('td').eq(0).text().toUpperCase();
                return $.isNumeric(x) && $.isNumeric(y) ? y - x : x.localeCompare(y);
            });

            $.each(rows, function (index, row) {
                table.children('tbody').append(row);
            });
        });

        function sortTable(columnIndex) {
            var table = $('#fixTable');
            var rows = table.find('tbody > tr').get();
            rows.sort(function (a, b) {
                var x = $(a).children('td').eq(columnIndex).text().toUpperCase();
                var y = $(b).children('td').eq(columnIndex).text().toUpperCase();
                return $.isNumeric(x) && $.isNumeric(y) ? x - y : y.localeCompare(x);
            });
            $.each(rows, function (index, row) {
                table.children('tbody').append(row);
            });
        }

        percentageSort.sort(function (a, b) {
            return b - a
        });
        // document.getElementById("marks").innerHTML = percentageSort;

    </script>

@endsection
