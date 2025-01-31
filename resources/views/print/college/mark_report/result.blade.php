@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif
@section('print_cntnt')
    <style>
        @page {
            size: landscape;
        }
    </style>
    @php use Carbon\Carbon;@endphp
    <div class="text-center">
        <h4>{{ $class }},{{ $section }},{{ $group }},{{ $search_exm_name }}</h4>
    </div>

    <table class="table table-bordered table-sm" id="fixTable">

        <thead>
        <tr>
            <th scope="col" class="tbl_srl_2">
                ID
            </th>
            <th scope="col" class="tbl_txt_8">
                Roll No
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
                {{-- <i class="fa fa-sort-up" aria-hidden="true" id="percentageSort"></i>
                <i class="fa fa-sort-desc" aria-hidden="true" id="nameSort"></i> --}}
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
                            @foreach ($subjects as $subject)
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
                    {{--                    <script>--}}
                    {{--                        var percentage = {!! $formated !!}--}}
                    {{--                        percentageSort.push(percentage);--}}
                    {{--                    </script>--}}
                    <td>
                                            <span
                                                class="badge rounded-pill {{ $formated == 0 ? 'bg-danger' : $color_name }} text-white">{{  $formated == 0 ? 'red' : $color }}</span>
                    </td>
                </tr>
            @endif
            @php
                //  $percentage[$sr] = $formated;
                //     print_r($percentage);
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
        <tr>
            <th colspan="2">Subject Name</th>

            <th colspan="2">Total Passed</th>

            <th>Total Failed</th>

            <th class="bg-success text-white">Green 86% to 100%</th>

            <th class="bg-warning text-white">Yellow 76% to 85%</th>

            <th class="bg-primary text-white">Blue 66% to 75%</th>

            <th class="bg-purple text-white">Purple 40% to 65%</th>

            <th class="bg-danger text-white">Red Less than 40%</th>
        </tr>
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

@endsection
