@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif
@section('print_cntnt')
    <div class="text-center">
        <h4>{{ $class_name }},{{ $section_name }}</h4>
    </div>
    <div class="form-group row">
        <div class="table-responsive" id="printTable">
            <table class="table table-bordered table-sm" id="category_dynamic_table">
                <!-- product table box start -->

                <thead>
                <tr>
                    <th colspan="4"></th>
                    @foreach($exams_names as $name)
                        <th colspan="4" class="text-center tbl_txt_15"> {{
                                           str_replace(['Round-', 'Test#'], ['R-', 'T#'], $name->exam_name)
                                           . ' ' . str_replace(' ', '', $name->exam_year)
                                       }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody id="table_body">
                <tr>
                    <th class="text-center tbl_txt_5">Sr#</th>
                    <th class="text-center tbl_txt_10">Roll No</th>
                    <th class="text-center tbl_txt_32">Students</th>
                    <th class="text-center tbl_txt_11">Matric Marks</th>
                    <th class="text-center tbl_txt_4" colspan="2">T-M</th>
                    <th class="text-center tbl_txt_4" colspan="2">O-M</th>
                    <th class="text-center tbl_txt_4" colspan="2">T-M</th>
                    <th class="text-center tbl_txt_4" colspan="2">O-M</th>
                    <th class="text-center tbl_txt_5" colspan="2">T-M</th>
                    <th class="text-center tbl_txt_4" colspan="2">O-M</th>
                </tr>
                @php
                    $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                  $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                  $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                  $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                @endphp
                @foreach ($students as $student)
                    <tr>
                        <td class="tbl_txt_5">{{ $sr++ }} </td>
                        <td class="tbl_txt_5">{{ $student->roll_no }} </td>
                        <td class="tbl_txt_20">{{ $student->full_name }} </td>
                        <td class="tbl_txt_20">{{ $student->marks_10th }} </td>
                        @php
                            $clg0 = json_decode($clg0_positions, true);
                            $clg1 = json_decode($clg1_positions, true);
                            $clg2 = json_decode($clg2_positions, true);
                        @endphp
                        @foreach ($clg2 as $key => $value)
                            @if ($value['id'] == $student->id)
                                <td colspan="2">
                                    {{ $value['total_marks'] }}
                                </td>
                                <td colspan="2">
                                    {{ $value['obtain'] }}
                                </td>
                            @endif
                        @endforeach
                        @foreach ($clg1 as $key => $value)
                            @if ($value['id'] == $student->id)
                                <td colspan="2">
                                    {{ $value['total_marks'] }}
                                </td>
                                <td colspan="2">
                                    {{ $value['obtain'] }}
                                </td>
                            @endif
                        @endforeach
                        @foreach ($clg0 as $key => $value)
                            @if ($value['id'] == $student->id)
                                <td colspan="2">
                                    {{ $value['total_marks'] }}
                                </td>
                                <td colspan="2">
                                    {{ $value['obtain'] }}
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- product table box end -->
    </div>
@endsection

