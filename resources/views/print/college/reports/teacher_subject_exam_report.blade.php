@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
    <div class="text-center">
        <h4>{{ $class_name }},{{ $section_name }}</h4>
    </div>
    <div class="form-group row" style="margin-top: 25px;">
        <div class="table-responsive" id="printTable">
            @foreach($exams_names as $name)

                <table class="table table-bordered table-sm" id="category_dynamic_table">
                    <!-- product table box start -->
                    <thead>
                    <tr>
                        <th colspan="11" class="text-center">
                            {{ $name->exam_name }}
                        </th>
                    </tr>
                    <tr>
                        <th>Sr</th>

                        <th>Subject Name</th>

                        <th>Teacher Name</th>

                        <th>Total Student</th>

                        <th>Total Passed</th>

                        <th>Total Failed</th>

                        <th style="background-color: rgb(28, 146, 44) !important; color: white">Green 86% to
                            100%
                        </th>

                        <th style="background-color: rgb(246, 136, 31) !important; color: white">Yellow 76% to
                            85%
                        </th>

                        <th style="background-color: rgb(37, 43, 102) !important; color: white">Blue 66% to
                            75%
                        </th>

                        <th style="background-color: rgb(153, 62, 240) !important; color: white">Purple 40% to
                            65%
                        </th>

                        <th style="background-color: rgb(220, 53, 69) !important; color: white">Red Less than
                            40%
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @php
                        $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                   $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                   $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                   $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                    @endphp

                    @if (is_array($c_marks2) && count($c_marks2) > 0)
                        <!-- Check if the array exists and is not empty -->
                        @foreach ($c_marks2 as $key => $value)
                            @if($value['exam_id'] == $name->exam_id)
                                @foreach($teachers as $teacher)
                                    @if($value['s_id'] == $teacher->subject_id)
                                        <tr id="table_body">
                                            {{--                                            <td>{{$value++}}</td>--}}
                                            <td>{{$sr++}}</td>
                                            <td>{{$value['group_name']}}</td>
                                            <td> {{ $teacher->subject_name }}</td>
                                            <td>{{ $teacher->user_name }}</td>
                                            <td>
                                                {{ $value['total_students'] }}
                                            </td>
                                            <td>
                                                {{ $value['total_passed'] }}
                                            </td>
                                            <td>
                                                {{ $value['total_failed'] }}
                                            </td>
                                            <td>
                                                {{ $value['green'] }}
                                            </td>
                                            <td>
                                                {{ $value['yellow'] }}
                                            </td>
                                            <td>
                                                {{ $value['blue'] }}
                                            </td>
                                            <td>
                                                {{ $value['purple'] }}
                                            </td>
                                            <td>
                                                {{ $value['red'] }}
                                            </td>
                                        <tr/>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td>No Marks</td>
                        </tr>
                    @endif
                    @if (is_array($c_marks1) && count($c_marks1))
                        @foreach ($c_marks1 as $key => $value)
                            @if($value['exam_id'] == $name->exam_id)
                                @foreach($teachers as $teacher)
                                    @if($value['s_id'] == $teacher->subject_id)
                                        <tr>
                                            <td>{{$sr++}}</td>
                                            <td>{{$value['group_name']}}</td>
                                            <td> {{ $teacher->subject_name }}</td>
                                            <td>{{ $teacher->user_name }}</td>
                                            <td>
                                                {{ $value['total_students'] }}
                                            </td>
                                            <td>
                                                {{ $value['total_passed'] }}
                                            </td>
                                            <td>
                                                {{ $value['total_failed'] }}
                                            </td>
                                            <td>
                                                {{ $value['green'] }}
                                            </td>
                                            <td>
                                                {{ $value['yellow'] }}
                                            </td>
                                            <td>
                                                {{ $value['blue'] }}
                                            </td>
                                            <td>
                                                {{ $value['purple'] }}
                                            </td>
                                            <td>
                                                {{ $value['red'] }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td>No Marks</td>
                        </tr>
                    @endif
                    @if (is_array($c_marks1) && count($c_marks1))
                        @foreach ($c_marks0 as $key => $value)
                            @if($value['exam_id'] == $name->exam_id)
                                @foreach($teachers as $teacher)
                                    @if($value['s_id'] == $teacher->subject_id)
                                        <tr>
                                            <td>{{$sr++}}</td>
                                            <td>{{$value['group_name']}}</td>
                                            <td> {{ $teacher->subject_name }}</td>
                                            <td>{{ $teacher->user_name }}</td>
                                            <td>
                                                {{ $value['total_students'] }}
                                            </td>
                                            <td>
                                                {{ $value['total_passed'] }}
                                            </td>
                                            <td>
                                                {{ $value['total_failed'] }}
                                            </td>
                                            <td>
                                                {{ $value['green'] }}
                                            </td>
                                            <td>
                                                {{ $value['yellow'] }}
                                            </td>
                                            <td>
                                                {{ $value['blue'] }}
                                            </td>
                                            <td>
                                                {{ $value['purple'] }}
                                            </td>
                                            <td>
                                                {{ $value['red'] }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td>No Marks</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            @endforeach
        </div><!-- product table box end -->
    </div>

@endsection

