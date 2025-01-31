<!DOCTYPE html>
<html lang="ur">

<head>
    <style>
        .table-header {
            margin-top: 130px;
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            float: left;
        }

        table th,
        table td {
            border: 1px solid #000;
            text-align: left;
            padding: 2px;
            text-align: center;
            font-size: 8px;
        }

        .college-header {
            width: 100%;
            display: block;
            float: left;
        }

        @page {
            size: landscape;
        }

        .college-logo {
            width: 10%;
            float: left;
        }

        .college-logo img {
            display: block;
            margin-left: 10px;
        }

        .header-content {
            line-height: 0.7;
            width: 80%;
            float: left;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            margin-left: 120px
        }

        .header-content h2 {
            font-size: 20px;
            text-transform: uppercase;
        }

        .header-content h2 span {
            background-color: black;
            color: #fff;
            padding: 4px;
        }

        .header-content h4 {
            font-size: 16px;
        }

        .header-content h4 span {
            background-color: black;
            color: #fff;
            padding: 4px;
        }

        .header-content p {
            margin-bottom: 0 !important;
        }

        .header-content p span {
            background-color: black;
            color: #fff;
            padding: 4px;
        }


        .uni-logo {
            width: 10%;
            float: right;
        }

        .uni-logo img {
            width: 100%;
            display: block;
            margin-right: 10px;
        }

        @media print {

            /* Landscape orientation */
            @page {
                orientation: landscape;
            }

            /* Full-width content */
            body {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="college-header">
            @php
                $company_info = Session::get('company_info');
                $branch_name = Session::get('branch_name');
            @endphp
            @foreach ($time_table as $timetable)
                <div class="college-logo">
                    <img src="{{ $company_info->ci_logo }}" alt="logo" style="width: 55%;height: 15%;">
                </div>
                <div class="header-content">
                    <h2><span>{{ $company_info->ci_name }}</span></h2>
                    <p><span>{{ $branch_name }}</span></p>
                    <h2><span>Time Table</span></h2>
                    <h4><span>{{ $timetable->class_name }} {{ $timetable->semester_name }} Section-
                            {{ $timetable->cs_name }} w.e.f.,{{ $timetable->tm_wef }} </span></h4>
                </div>
            @endforeach
          <table class="table-header">
        <thead>
            <th class="table-th">Day</th>
            @foreach ($formattedData[0]['subject_name'] as $subjectName)
                <th class="table-th">{{ $subjectName }}</th>
            @endforeach
        </thead>
        @foreach ($formattedData as $dayRow)
            <tr>
                <td class="table-td">{{ $dayRow['day'] }}</td>
                @foreach ($dayRow['subject_name'] as $subjectIndex => $subjectName)
                    <td class="table-td">
                        @if (
                            isset($dayRow['teacher_name'][$subjectIndex]) &&
                            isset($dayRow['start_time'][$subjectIndex]) &&
                            isset($dayRow['end_time'][$subjectIndex])
                        )
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
        </div>
        <p style="margin-top:8px;"><span style="background-color: black;color: #fff;padding: 4px; margin-top:8px;">Note: <b>Break</b> Start Time <b>{{ $time_table[0]->tm_break_start_time }}</b> and End Time
            <b>{{ $time_table[0]->tm_break_end_time }}</b></span> </p>
        <div>
            <span>
                Coordinator Signature: ----------------------
            </span>
            <span style="margin-left: 475px">
                Principal Signature: ----------------------
            </span>

        </div>
    </div>

</body>

</html>
