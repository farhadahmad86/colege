@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif
@section('print_cntnt')
    @php
        // Assuming $students is an array of student objects with percentages
        
        // Sort the students by percentage in descending order
        
        // Calculate R1 positions
        $r1 = json_decode($r1_positions);
        
        $r1_position = [];
        $current_position = 0;
        $previous_percentage = null;
        
        foreach ($r1 as $student) {
            $current_percentage = $student->per;
        
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
        
            $r1_position[$student->id] = $current_position;
            $previous_percentage = $current_percentage;
        }
        
        // Calculate R2 positions (similar logic as R1)
        $r2 = json_decode($r2_positions);
        $r2_position = [];
        $current_position = 0;
        $previous_percentage = null;
        
        foreach ($r2 as $student) {
            $current_percentage = $student->per;
        
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
        
            $r2_position[$student->id] = $current_position;
            $previous_percentage = $current_percentage;
        }
        
        // Calculate R3 positions (similar logic as R1)
        $r3 = json_decode($r3_positions);
        $r3_position = [];
        $current_position = 0;
        $previous_percentage = null;
        foreach ($r3 as $student) {
            $current_percentage = $student->per;
        
            if ($current_percentage !== $previous_percentage) {
                $current_position++;
            }
        
            $r3_position[$student->id] = $current_position;
            $previous_percentage = $current_percentage;
        }
    @endphp
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
            @php
                $r1 = 1;
            @endphp
            @forelse ($students as $student)
                <div class="col-lg-12 col-md-12 col-sm-12 mt-3 mb-3">
                    @php
                        $company_info = \App\Models\CompanyInfoModel::first();
                    @endphp
                    <img src="{{ isset($company_info) || !empty($company_info) ? $company_info->ci_logo : 'N/A' }}"
                        alt="Company Logo" width="80" height="80" />
                        <div>Student Result Card</div>
                    <img src="{{ $student->profile_pic }}" width="80" class="rounded-circle" alt="..."
                        style="float:right">
                </div>
                <div class="table-responsive col-md-12" style="overflow-x: hidden !important" id="printTable">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table class="table table-bordered" style="width:100%">

                            <thead style="background-color: #17a2b8; color:white">
                                <th colspan="8">
                                    Student Bio Data Progress Report
                                </th>
                            </thead>

                            <body>
                                <tr>
                                    <td rowspan="1">Class</td>
                                    <td>{{ $class }}</td>
                                    <td>Adm #</td>
                                    <td>{{ $student->registration_no }}</td>
                                    <td>Roll #</td>
                                    <td>{{ $student->roll_no }}</td>
                                    <td>Enrollment</td>
                                    <td>{{ $student->admission_date }}</td>
                                </tr>
                                <tr>
                                    <td rowspan="1">Name</td>
                                    <td>{{ $student->full_name }}</td>
                                    <td>Parent</td>
                                    <td>{{ $student->father_name }}</td>
                                    <td>10th Class</td>
                                    <td>{{ $student->marks_10th }}</td>
                                    <td rowspan="1">Gender</td>
                                    <td>{{ $student->gender }}</td>
                                </tr>
                                <tr>
                                    <td rowspan="1">DOB</td>
                                    <td>{{ $student->dob }}</td>
                                    <td>Ph #</td>
                                    <td>{{ $student->parent_contact }}</td>
                                    <td rowspan="1">Address</td>
                                    <td>{{ $student->address }}</td>
                                </tr>
                            </body>
                        </table>
                        <table style="width:100%">
                            <thead style="background-color:#17a2b8; color:white">
                                <tr>
                                    <td rowspan="1">Examination</td>
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
                                    <td>Total Marks</td>
                                    <td>Percentage</td>
                                    <td>Zone</td>
                                    <td>R1</td>
                                    <td>R2</td>
                                    <td>R3</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>


                                    <td>{{ $request->ex_name }}</td>
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
                                        {{ $obtained_marks }}/{{ $total_marks }}
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
                                                if ($percentage <= 50) {
                                                    $color_name = 'bg-danger';
                                                    $color = 'Red';
                                                } elseif ($percentage > 50 && $percentage <= 65) {
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
                                    <td>
                                        <span
                                            class="badge rounded-pill {{ $color_name }} text-white">{{ $color }}</span>
                                    </td>
                                    @foreach ($r2_position as $key => $value)
                                        @if ($key == $student->id)
                                            <td>
                                                {{ $value }}
                                            </td>
                                        @endif
                                    @endforeach
                                    @foreach ($r2_position as $key => $value)
                                        @if ($key == $student->id)
                                            <td>
                                                {{ $value }}
                                            </td>
                                        @endif
                                    @endforeach
                                    @foreach ($r3_position as $key => $value)
                                        @if ($key == $student->id)
                                            <td>
                                                {{ $value }}
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="table-responsive">
                            @php
                                $s_teachers = json_decode($teachers);
                                $count = $s_teachers[1];
                            @endphp
                            <table class="table table-bordered mt-2">
                                <thead style="background-color: #17a2b8; color:white">
                                    <th colspan="2">
                                        Subject Teacher Data
                                    </th>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Teachers</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if (isset($s_teachers[0][0]->teacher_name) && isset($s_teachers[0][0]->subject_name))
                                        @foreach ($s_teachers[0][0]->teacher_name as $index => $teacherName)
                                            <tr>
                                                <td>{{ $s_teachers[0][0]->subject_name[$index] }}</td>
                                                <td>{{ $teacherName }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">
                                                <p>Teacher not Assign to Section</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="table-responsive">
                            <table class="table table-bordered mt-2">
                                <thead style="background-color: #17a2b8; color:white">
                                    <th colspan="3">
                                        Zone Classification
                                    </th>
                                    <tr>
                                        <th>Zone</th>
                                        <th>From</th>
                                        <th>To</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="bg-success">Green</td>
                                        <td>100%</td>
                                        <td>85%</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-warning">Yellow</td>
                                        <td>84%</td>
                                        <td>75%</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-primary">Blue</td>
                                        <td>74%</td>
                                        <td>65%</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-purple">Purple</td>
                                        <td>64%</td>
                                        <td>50%</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-danger">Red</td>
                                        <td>50%</td>
                                        <td>0</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            <b class="text-danger">Notes :</b> R1 - Section wise Position, R2 - Campus wise
                                            Position, R3 - Overall all Campus Position
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div>
                            <canvas id="canvas{{ $student->id }}" height="280" width="600"></canvas>
                        </div>
                        <script>
                            (function() {
                                let myChart; // Declare myChart variable with let for block scope
                                let subject_name = []
                                var studentId = {{ $student->id }};
                                var obtainedMarks = [];
                                var totalMarks = [];
                                // console.log(studentId);
                                let marks = {!! $class_marks !!}
                                let subjects = {!! $subjects !!}

                                $.each(marks, function(index, mark) {
                                    // console.log(mark.me_subject_id);
                                    $.each(subjects, function(index, subject) {
                                        if (subject.subject_id == mark.me_subject_id) {
                                            subject_name.push(subject.subject_name)
                                        }
                                    })
                                });
                                $.each(marks, function(index, mark) {
                                    let obtain_marks = JSON.parse(mark.me_obtain_marks);
                                    let student_id = JSON.parse(mark.me_students);
                                    totalMarks.push(mark.me_total_marks)
                                    // console.log(obtain_marks);
                                    $.each(subjects, function(index, subject) {
                                        if (subject.subject_id == mark.me_subject_id)
                                            if (obtain_marks) {
                                                $.each(student_id, function(index, studnetIds) {
                                                    // console.log(studnetIds);
                                                    if (studnetIds == studentId) {
                                                        obtainedMarks.push(obtain_marks[index])
                                                    }
                                                });
                                            }


                                    });
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


                                var ctx = document.getElementById('canvas{{ $student->id }}').getContext("2d");

                                myChart = new Chart(ctx, {
                                    type: 'bar', // Change the chart type as needed (e.g., 'line', 'pie', 'radar')
                                    data: chartData,
                                    options: {
                                        // Chart options, such as title, legend, etc.
                                    }
                                });
                            })
                            ();
                        </script>

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
        </div><!-- row end -->
    </div>
@endsection

