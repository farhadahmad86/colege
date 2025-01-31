{{-- @extends('layouts.app')

@section('content') --}}
<style>
    .table-header {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin-top: 2px;
    }

    .table-th {
        border: 2px solid #000;
        text-align: left;
        padding: 8px;
        text-align: center;
        font-size: 8px;
    }

    .table-td {
        border: 2px solid #000;
        text-align: left;
        padding: 8px;
        text-align: center;
        font-size: 8px;
    }

    .college-header {
        width: 100%;
        display: block;
        /* margin-bottom: 15px; */
        /* line-height: 0.8; */
    }

    .college-header .college-logo {
        width: 10%;
        float: left;
    }

    .college-header .college-logo img {
        display: block;
        width: 50%;
        height: 50%;
        margin-left: 10px;
    }

    .college-header .header-content {
        line-height: 1.7;
        width: 80%;
        float: left;
        text-align: center;
        font-family: 'Times New Roman', Times, serif;
    }

    .college-header .header-content h2 {
        font-size: 20px;
        text-transform: uppercase;
    }

    .college-header .header-content h2 span {
        background-color: black;
        color: #fff;
        padding: 4px;
    }

    .college-header .header-content h4 {
        font-size: 16px;
    }

    .college-header .header-content h4 span {
        background-color: black;
        color: #fff;
        padding: 4px;
    }

    .college-header .header-content p {
        margin-bottom: 0 !important;
    }

    .college-header .header-content p span {
        background-color: black;
        color: #fff;
        padding: 4px;
    }

    .college-header .uni-logo {
        width: 10%;
        float: right;
    }

    .college-header .uni-logo img {
        width: 100%;
        display: block;
        margin-right: 10px;
    }
</style>
<div class="container">
    <div class="college-header">
        @php
            $company_info = Session::get('company_info');
            $branch_name = Session::get('branch_name');
        @endphp
        @foreach ($time_table as $timetable)
            <div class="college-logo">
                <img src="{{ $company_info->ci_logo }}" alt="logo">
            </div>
            <div class="header-content">
                <h2><span>{{ $company_info->ci_name }}</span></h2>
                <p><span>{{ $branch_name }}</span></p>
                <h2><span>Time Table</span></h2>
                <h4><span>{{ $timetable->class_name }} {{ $timetable->semester_name }} Section-
                        {{ $timetable->cs_name }} w.e.f.,{{ $timetable->tm_wef }} </span></h4>
            </div>
        @endforeach
    </div>

    <table class="table-header">
        <thead>
            <th class="table-th">Day</th>
            {{-- @foreach ($formattedData[0]['subject_name'] as $subjectName)
                <th class="table-th">{{ $subjectName }}</th>
            @endforeach --}}
            <th colspan="{{$countSubject}}" style="text-align: center">Time Table</th>
        </thead>
        @foreach ($formattedData as $dayRow)
            <tr>
                <td class="table-td">{{ $dayRow['day'] }}</td>
                @foreach ($dayRow['subject_name'] as $subjectIndex => $subjectName)
                    <td class="table-td">
                        @if (isset($dayRow['teacher_name'][$subjectIndex]) &&
                                isset($dayRow['start_time'][$subjectIndex]) &&
                                isset($dayRow['end_time'][$subjectIndex]))
                            <span>{{ $subjectName }}</span><br>
                            {{ $dayRow['teacher_name'][$subjectIndex] }}<br>
                            <span style="white-space: nowrap;">{{ $dayRow['start_time'][$subjectIndex] }} -
                                {{ $dayRow['end_time'][$subjectIndex] }}</span>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

    <p style="margin-top:8px;"><span style="background-color: black;color: #fff;padding: 4px;">Note: <b>Break</b> Start
            Time <b>{{ $timetable->tm_break_start_time }}</b> and End Time
            <b>{{ $timetable->tm_break_end_time }}</b></span>
    </p>
    <iframe style="display: none" id="printf" name="printf"
        src="{{ route('timetable_view_details_pdf_SH', ['id' => $timetable->tm_id]) }}"
        title="W3Schools Free Online Web Tutorials">Iframe
    </iframe>
    <a href="#" id="printi" onclick="PrintFrame()" class="btn btn-sm btn-info v_print"
        style="float: left;margin-top: 7px;">
        Print
    </a>
</div>
<script>
    function PrintFrame() {
        // window.frames["printf"].focus();
        window.frames["printf"].print();
    }
</script>
{{-- @endsection --}}
