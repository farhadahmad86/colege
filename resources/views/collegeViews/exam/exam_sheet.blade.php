<!DOCTYPE html>
<html>
<head>
    <title>Student Result Card</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            border: 0.2px solid #ccc;
            width: 100%;
            margin-bottom: 1rem;
            background-color: white;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        table thead,
        table th {
            border-bottom: 0.2px solid #ccc;
            background: #bd1100;
            color: #fff;
        }

        table,
        th,
        td {
            border: 1px solid #dee2e6;
            border-collapse: collapse;
            padding: 0.4rem;
            vertical-align: top;
        }

        table tbody tr:nth-child(odd) {
            background: #fff;
        }

        table tbody tr:nth-child(even) {
            background: #f3f3f3;
        }

        table tfoot td.blank {
            border: 0 !important;
        }

        table tfoot td.blankSpace {
            padding: 0;
        }

        table .green,
        table .blue,
        table .yellow,
        table .purple,
        table .red {
            color: #fff;
            padding: 0.25rem;
            border-radius: 3px;
            text-transform: capitalize;
        }

        table .green {
            background-color: green;
        }

        table .blue {
            background-color: blue;
        }

        table .yellow {
            background-color: yellow;
            color: black;
        }

        table .purple {
            background-color: purple;
        }

        table .red {
            background-color: red;
        }

        table tbody tr.precent td::after {
            content: " %";
        }

        .graphTable {
            display: flex;
            justify-content: end;
        }

        .graphTable .graph1 {
            width: 60%;
        }

        .graphTable .tableAtndnc {
            width: 40%;
            justify-content: end;
        }

        .signatures {
            display: flex;
        }

        .signatures .col {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
            text-align: start;
        }

        .header {
            display: flex;
        }

        .header .col {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
        }

        .studentInfo {
            display: flex;
        }

        .studentInfo p {
            margin-top: 0;
            margin-bottom: 0.2rem;
        }

        .header {
            margin-bottom: ;
        }

        .header .col.collefeTitle {
            text-align: center;
        }

        .header .col.collefeTitle h1 {
            font-family: 'Times New Roman', Times, serif;
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .header .col.collefeTitle .campus {
            font-size: 1.5rem;
            margin: 0;
        }

        .header .col.collegeLogo {
            text-align: start;
        }

        .header .col.collegeLogo img {
            width: 20%;
        }

        .header .col.studentThumb {
            text-align: end;
            max-height: 100px;
            overflow-y: hidden;
            align-items: center;
        }

        .header .col.studentThumb img {
            width: 16%;

        }

        .studentInfo .col {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
        }

        .studentInfo .col.end {
            text-align: end;
        }
    </style>
    <script src="{{ asset('public/vendors/scripts/jquery.min.2.2.1.js') }}"></script>
    <script src="{{ asset('public/vendors/scripts/jquery.min3.3.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendors/scripts/jquery-1.3.2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendors/scripts/jquery.shortcuts.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
@php
    $company_info = \App\Models\CompanyInfoModel::first();
@endphp
@php
    $clg0 = json_decode($clg0_positions);
    $clg_0_position = [];
    $current_position = 0;
    $previous_percentage = null;
    if($clg0){
        foreach ($clg0 as $student) {
            $current_percentage = $student->per;
                if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
            $clg_0_position[$student->id] = $current_position;
            $previous_percentage = $current_percentage;
        }
    }
    $bra0 = json_decode($bra0_positions);
    $bra_0_position = [];
    $current_position = 0;
    $previous_percentage = null;
    foreach ($bra0 as $student) {
        $current_percentage = $student->per;
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
        $bra_0_position[$student->id] = $current_position;
        $previous_percentage = $current_percentage;
    }

    $sec0 = json_decode($sec0_positions);
    $sec_0_position = [];
    $current_position = 0;
    $previous_percentage = null;
    foreach ($sec0 as $student) {
        $current_percentage = $student->per;
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
        $sec_0_position[$student->id] = $current_position;
        $previous_percentage = $current_percentage;
    }

    if($clg1_positions != '""'){

    $clg1 = json_decode($clg1_positions);
    $clg_1_position = [];
    $current_position = 0;
    $previous_percentage = null;
    foreach ($clg1 as $student) {
        $current_percentage = $student->per;
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
        $clg_1_position[$student->id] = $current_position;
        $previous_percentage = $current_percentage;
    }
    $bra1 = json_decode($bra1_positions);
    $bra_1_position = [];
    $current_position = 0;
    $previous_percentage = null;
    foreach ($bra1 as $student) {
        $current_percentage = $student->per;
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
        $bra_1_position[$student->id] = $current_position;
        $previous_percentage = $current_percentage;
    }

    $sec1 = json_decode($sec1_positions);
    $sec_1_position = [];
    $current_position = 0;
    $previous_percentage = null;
    foreach ($sec1 as $student) {
        $current_percentage = $student->per;
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
        $sec_1_position[$student->id] = $current_position;
        $previous_percentage = $current_percentage;
        }
    }
if($clg2_positions != '""'){

    $clg2 = json_decode($clg2_positions);
    $clg_2_position = [];
    $current_position = 0;
    $previous_percentage = null;
    foreach ($clg2 as $student) {
        $current_percentage = $student->per;
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
        $clg_2_position[$student->id] = $current_position;
        $previous_percentage = $current_percentage;
    }

    $bra2 = json_decode($bra2_positions);
    $bra_2_position = [];
    $current_position = 0;
    $previous_percentage = null;
    foreach ($bra2 as $student) {
        $current_percentage = $student->per;
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
        $bra_2_position[$student->id] = $current_position;
        $previous_percentage = $current_percentage;
    }

    $sec2 = json_decode($sec2_positions);
    $sec_2_position = [];
    $current_position = 0;
    $previous_percentage = null;
    foreach ($sec2 as $student) {
        $current_percentage = $student->per;
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
        $sec_2_position[$student->id] = $current_position;
        $previous_percentage = $current_percentage;
    }
}
@endphp
@forelse ($students as $student)
    <div style="min-height: 100vh">
        <div class="header">
            <div class="col collegeLogo">
                <img src="{{ isset($company_info) || !empty($company_info) ? $company_info->ci_logo : 'N/A' }}"
                     alt="Company Logo" style="margin-right: auto"/>
            </div>
            <div class="col collefeTitle">
                <h1>{{$company_info->ci_name}}</h1>
                <p class="campus">{{$branch}}</p>
            </div>
            <div class="col studentThumb">
                <img src="{{ $student->profile_pic }}" class="std-avatar" alt="..."/>
            </div>
        </div>
        <div class="studentInfo">
            <div class="col">
                <p>Student Name: {{ $student->full_name }}</p>
                <p>Father Name: {{ $student->father_name }}</p>
            </div>
            <div class="col end">
                <p>Roll No: {{ $student->roll_no }}</p>
                <p>Section:{{ $section }}</p>
            </div>
        </div>
        <table>
            <thead>
            <tr>
                <th colspan="2">Subject Name</th>
                {{-- <th>Teacher</th> --}}
                @foreach ($exams_names as $index=>$name)
                    <th>{{$name->exam_name}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @php
                $obtained_marks0 = 0;
                $total_marks0 = 0;
                $obtained_marks1 = 0;
                $total_marks1 = 0;
                $obtained_marks2 = 0;
                $total_marks2 = 0;
                $color1_name = '';
                $color1 = '';
            @endphp
            @foreach ($subject_marks as $subject)
                <tr>
                    <td colspan="2" style="white-space: nowrap;">{{$subject->subject_name}}</td>
                    {{-- @php
                        $s_teachers = json_decode($teachers, true);
                    @endphp
                    @if (is_array($s_teachers) && count($s_teachers) > 0)
                        @foreach ($s_teachers[0] as $item)
                            @if (!empty($item['teacher_name']))
                                @foreach ($item['teacher_name'] as $index => $teacherName)
                                    @php
                                        $subjectName = $item['subject_name'][$index];
                                        $subjectIds = $item['subject_id'][$index];
                                    @endphp
                                    @if($subjectIds == $subject->subject_id)
                                        <td class="">
                                            {{$teacherName}}
                                        </td>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif --}}

                    @php
                        $i=0;
    $exam_marks0=0;
    $exam_marks1=0;
    $exam_marks2=0;

                    @endphp
                    @foreach ($class_marks as $class_mark)
                        @foreach ($exams_names as $index=>$exam)
                            @if($exam->exam_id == $class_mark->me_exam_id)
                                @php
                                    $numericArray = json_decode($class_mark->me_obtain_marks, true);
                                    $studentsArray = json_decode($class_mark->me_students, true);
                                    if (is_array($numericArray)) {
                                        $numericArray = array_map('intval', $numericArray);
                                        $studentsArray = array_map('intval', $studentsArray);
                                        // Fetch student details based on student IDs
                                    }
                                @endphp

                                @if ($subject->subject_id == $class_mark->me_subject_id)
                                    @if ($numericArray)
                                        @foreach ($studentsArray as $key => $value)
                                            @if ($value == $student->id)
                                                @php

                                                    ${'obtained_marks'.$index} = ${'obtained_marks'.$index} + $numericArray[$key];
                                                    ${'total_marks'.$index} = ${'total_marks'.$index} + $class_mark->me_total_marks;

                                                ${'exam_marks'.$index}=$numericArray[$key].'/'.$class_mark->me_total_marks;
                                                @endphp
                                                {{--                                        <td>{{ $numericArray[$key] }}/{{ $class_mark->me_total_marks }}</td>--}}
                                            @endif
                                        @endforeach
                                        {{-- Display the obtain marks for the subject --}}
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                    @if($clg0_positions != '""')
                        <td>{{$exam_marks0}}</td>
                    @endif
                    @if($clg1_positions != '""')
                        <td>{{$exam_marks1}}</td>
                    @endif
                    @if($clg2_positions != '""')
                        <td>{{$exam_marks2}}</td>
                    @endif
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" class="blankSpace"><br></td>
            </tr>
            <tr>
                <td class="blank"></td>
                <th>Obtained Marks</th>
                <td>{{$obtained_marks0}}</td>
                @if($obtained_marks1 > 0)
                    <td>{{$obtained_marks1}}</td>
                @endif
                @if($obtained_marks2 > 0)
                    <td>{{$obtained_marks2}}</td>
                @endif
            </tr>
            <tr>
                <td class="blank"></td>
                <th>Total Marks</th>
                <td>{{$total_marks0}}</td>
                @if($total_marks1 > 0)
                    <td>{{$total_marks1}}</td>
                @endif
                @if($total_marks2 > 0)
                    <td>{{$total_marks2}}</td>
                @endif
            </tr>
            <tr class="precent">
                <td class="blank"></td>
                <th>Percentage</th>

                @if($obtained_marks0 > 0 && $total_marks0>0)
                    @php $per = ($obtained_marks0/$total_marks0) * 100;

                if ($per <= 39) {
                    $color1_name = 'red';
                    $color1 = 'Red';
                } elseif ($per >= 40 && $per <= 65) {
                    $color1_name = 'purple';
                    $color1 = 'Purple';
                } elseif ($per > 65 && $per <= 75) {
                    $color1_name = 'blue';
                    $color1 = 'Blue';
                } elseif ($per > 75 && $per <= 85) {
                    $color1_name = 'yellow';
                    $color1 = 'Yellow';
                } elseif ($per > 85 && $per <= 100) {
                    $color1_name = 'green';
                    $color1 = 'Green';
                }
                    @endphp
                    <td>{{number_format($per,2)}}%</td>
                @else
                    <td></td>
                @endif
                @if($total_marks1 > 0)
                    @php $per = ($obtained_marks1/$total_marks1) * 100;
                $color2_name = '';
                $color2 = '';
                if ($per <= 39) {
                    $color2_name = 'red';
                    $color2 = 'Red';
                } elseif ($per >= 40 && $per <= 65) {
                    $color2_name = 'purple';
                    $color2 = 'Purple';
                } elseif ($per > 65 && $per <= 75) {
                    $color2_name = 'blue';
                    $color2 = 'Blue';
                } elseif ($per > 75 && $per <= 85) {
                    $color2_name = 'yellow';
                    $color2 = 'Yellow';
                } elseif ($per > 85 && $per <= 100) {
                    $color2_name = 'green';
                    $color2 = 'Green';
                }
                    @endphp
                    <td>{{number_format($per,2)}}%</td>
                @endif
                @if($total_marks2 > 0)
                    @php $per = ($obtained_marks2/$total_marks2) * 100;
                $color3_name = '';
                $color3 = '';
                if ($per <= 39) {
                    $color3_name = 'red';
                    $color3 = 'Red';
                } elseif ($per >= 40 && $per <= 65) {
                    $color3_name = 'purple';
                    $color3 = 'Purple';
                } elseif ($per > 65 && $per <= 75) {
                    $color3_name = 'blue';
                    $color3 = 'Blue';
                } elseif ($per > 75 && $per <= 85) {
                    $color3_name = 'yellow';
                    $color3 = 'Yellow';
                } elseif ($per > 85 && $per <= 100) {
                    $color3_name = 'green';
                    $color3 = 'Green';
                }
                    @endphp
                    <td>{{number_format($per,2)}}%</td>
                @endif
            </tr>

            <tr>
                <td class="blank"></td>
                <th>Zone</th>
                <td>
                    <span class="{{ $color1_name }}">{{ $color1 }}</span>
                </td>
                @if($total_marks1 > 0)
                    <td><span class="{{ $color2_name }}">{{ $color2 }}</span></td>
                @endif
                @if($total_marks2 > 0)
                    <td><span class="{{ $color3_name }}">{{ $color3 }}</span></td>
                @endif
            </tr>
            <tr>
                <td class="blank"></td>
                <th>R1 (Section Position)</th>
                @foreach ($sec_0_position as $key => $value)
                    @if ($key == $student->id)
                        <td>
                            <b>
                                {{ $value }}
                            </b>
                        </td>
                    @endif
                @endforeach
                @if($clg1_positions != '""')
                    @foreach ($sec_1_position as $key => $value)
                        @if ($key == $student->id)
                            <td>
                                <b>
                                    {{ $value }}
                                </b>
                            </td>
                        @endif
                    @endforeach
                @endif
                @if($clg2_positions != '""')
                    @foreach ($sec_2_position as $key => $value)
                        @if ($key == $student->id)
                            <td>
                                <b>
                                    {{ $value }}
                                </b>
                            </td>
                        @endif
                    @endforeach
                @endif
            </tr>
            <tr>
                <td class="blank"></td>
                <th>R2 (Campus Position)</th>
                @foreach ($bra_0_position as $key => $value)
                    @if ($key == $student->id)
                        <td>
                            <b>
                                {{ $value }}
                            </b>
                        </td>
                    @endif
                @endforeach
                @if($clg1_positions != '""')
                    @foreach ($bra_1_position as $key => $value)
                        @if ($key == $student->id)
                            <td>
                                <b>
                                    {{ $value }}
                                </b>
                            </td>
                        @endif
                    @endforeach
                @endif
                @if($clg2_positions != '""')
                    @foreach ($bra_2_position as $key => $value)
                        @if ($key == $student->id)
                            <td>
                                <b>
                                    {{ $value }}
                                </b>
                            </td>
                        @endif
                    @endforeach
                @endif
            </tr>
            <tr>
                <td class="blank"></td>
                <th>R3 (College Position)</th>

                @foreach ($clg_0_position as $key => $value)
                    @if ($key == $student->id)
                        <td>
                            <b>
                                {{ $value }}
                            </b>
                        </td>
                    @endif
                @endforeach
                @if($clg1_positions != '""')
                    @foreach ($clg_1_position as $key => $value)
                        @if ($key == $student->id)
                            <td>
                                <b>
                                    {{ $value }}
                                </b>
                            </td>
                        @endif
                    @endforeach
                @endif
                @if($clg2_positions != '""')
                    @foreach ($clg_2_position as $key => $value)
                        @if ($key == $student->id)
                            <td>
                                <b>
                                    {{ $value }}
                                </b>
                            </td>
                        @endif
                    @endforeach
                @endif

            </tr>
            </tfoot>
        </table>
        <div class="graphTable">
            <div class="graph1">
                <div style="display: block; box-sizing: border-box; height: 180px; width: 450px;">
                    <canvas id="canvas0{{ $student->id }}"></canvas>
                </div>
            </div>

            <script>


                (function () {
                    var exams = {!! $exams_names !!}
                    $.each(exams, function (ex_index, exam) {
                        let myChart; // Declare myChart variable with let for block scope
                        let subject_name = []
                        var studentId = {{ $student->id }};
                        var obtainedMarks = [];
                        var totalMarks = [];
                        // console.log(studentId);
                        let marks = {!! $class_marks !!}
                            let
                        subjects = {!! $subjects !!}

                        $.each(marks, function (index, mark) {
                            if (exam.exam_id == mark.me_exam_id) {
                                // console.log(mark.me_subject_id);
                                $.each(subjects, function (index, subject) {
                                    if (subject.subject_id == mark.me_subject_id) {
                                        subject_name.push(subject.subject_name)
                                    }
                                })
                            }
                        });
                        $.each(marks, function (index, mark) {
                            if (exam.exam_id == mark.me_exam_id) {
                                let obtain_marks = JSON.parse(mark.me_obtain_marks);
                                let student_id = JSON.parse(mark.me_students);
                                totalMarks.push(mark.me_total_marks)
                                // console.log(obtain_marks);
                                $.each(subjects, function (index, subject) {
                                    if (subject.subject_id == mark.me_subject_id)
                                        if (obtain_marks) {
                                            $.each(student_id, function (index, studnetIds) {
                                                // console.log(studnetIds);
                                                if (studnetIds == studentId) {
                                                    obtainedMarks.push(obtain_marks[index])
                                                }
                                            });
                                        }


                                });
                            }
                        });
                        console.log(obtainedMarks);
                        // Your code to fetch data or calculate chart values based on studentId
                        // For this example, we'll generate random data for demonstration purposes

                        // Generate random data for the chart (replace with your actual data retrieval)
                        var chartData = {
                            labels: subject_name,
                            datasets: [{
                                label: 'Obtained Marks',
                                data: obtainedMarks, // Pass the studentId to generate data
                                backgroundColor: 'rgba(229, 121, 29)',
                                borderColor: 'rgba(229, 121, 29)',
                                borderWidth: 1
                            }]
                        };
                        chartData.datasets.push({
                            label: 'Total Marks',
                            data: totalMarks,
                            backgroundColor: 'rgba(106, 83, 54)',
                            borderColor: 'rgba(106, 83, 54)',
                            borderWidth: 1
                        });


                        var ctx = document.getElementById(`canvas${ex_index}{{ $student->id }}`).getContext("2d");
                        {{--var ctx = document.getElementById('canvas{{ $student->id }}').getContext("2d");--}}

                            myChart = new Chart(ctx, {
                            type: 'bar', // Change the chart type as needed (e.g., 'line', 'pie', 'radar')
                            data: chartData,
                            options: {
                                // Chart options, such as title, legend, etc.
                            }
                        });
                    })
                })
                ();
            </script>
            <div class="tableAtndnc">
                <table>
                    <thead>
                    <tr>
                        <th>Month</th>
                        <th>Presents</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($attendances as $studentId => $monthCounts)
                        @If ($studentId == $student->id)
                            @foreach ($monthCounts as  $month => $count)
                                <tr>
                                    <td>
                                        {{$month}}
                                    </td>
                                    <td>
                                        {{$count}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="signatures">
            <div class="col">
                <p>Principal</p>
            </div>
            <div class="col">
                <p>Controller</p>
            </div>
            <div class="col">
                <p>Class Incharge</p>
            </div>
        </div>
    </div>
@empty
    <tr>
        <td colspan="11">
            <center>
                <h3 style="color:#554F4F">No Result Sheet</h3>
            </center>
        </td>
    </tr>
@endforelse
</body>
</html>
