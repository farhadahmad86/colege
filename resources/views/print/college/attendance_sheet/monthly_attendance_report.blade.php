@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
    @php use Carbon\Carbon;@endphp
    <div class="text-center">
        <h4>{{ $class_name }}, {{ $section }} </h4>
        <h5>{{ $month }}-{{ $year }}</h5>
    </div>
    <table class="table table-bordered table-sm" id="fixTable">
        <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                Sr#
            </th>
            <th scope="col" class="tbl_srl_4">
                Roll No
            </th>
            <th scope="col" class="tbl_txt_35">
                Student Name
            </th>
            @for ($i = 1; $i <= $numDays; $i++)
                @php
                    $date = $year . '-' . $month . '-' . $i;
                    $dayName = Carbon::parse($date)->format('l');
                @endphp
                <th scope="col" align="center" class="text-center align_center tbl_txt_2" style="border: 1px solid">
                    {{ $dayName[0] }} {{ $i > 9 ? $i : '0' . $i }}
                </th>
            @endfor
            <th scope="col" class="tbl_txt_12">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
            $user_name='';
        @endphp
        @forelse($students as $student_data)

            <tr>
                <th scope="row">
                    {{ $sr }}
                </th>
                <th scope="row">
                    {{ $student_data->roll_no }}
                </th>
                <td class="edit">
                    {{ $student_data->full_name }}
                </td>
                @php $days=0; $atten =''; @endphp
                @for ($i = 1; $i <= $numDays; $i++)

                    @foreach ($datas as $item)
                        @php

                            $day = date('d', strtotime($item->std_att_date));
                            $data = json_decode($item->std_attendance, true);
                            $studentIds = array_column($data, 'student_id');
                            $targetStudentId = $student_data->id;
                            $index = array_search($targetStudentId, $studentIds);
                            $user_name =  $item->user_name;
                            if ($index !== false) {
                            if($day ==$i){
                             $atten= $data[$index]['is_present'];
                             $days=$day;
                            }
                            }
                        @endphp
                    @endforeach
                    @if($days == $i)
                        <td scope="col" class="text-center tbl_txt_2">
                            {{ $atten }}
                        </td>
                    @else
                        <td scope="col" class="text-center tbl_txt_2">

                        </td>
                    @endif
                @endfor
                <td class="edit">
                    {{ $user_name }}
                </td>
            </tr>
            @php
                $sr++;
                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center>
                        <h3 style="color:#554F4F">No Report</h3>
                    </center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <footer style="margin-top: 35px; padding-left: 15px;">
        <div class="signature">
            <p>Incharge Signature</p>
            <p>-------------------</p>
        </div>

        <div class="signature">
            <p>Co-ordinator Signature</p>
            <p>-------------------</p>
        </div>

        <div class="signature">
            <p>Principal Signature</p>
            <p>-------------------</p>
        </div>

    </footer>

@endsection

