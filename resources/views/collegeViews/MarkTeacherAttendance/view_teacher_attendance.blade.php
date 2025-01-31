<!DOCTYPE html>
<html lang="ur">

<head>
    <style>
        .table-td,
        td {
            border: 2px solid #000;
            text-align: center;
        }
        .table-th,
        th {
            border: 2px solid #000;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <table>
            <thead class="table-th">
                <tr>
                    <th scope="col" class="tbl_srl_4">
                        Sr#
                    </th>
                    <th scope="col" class="tbl_txt_8">
                        Department
                    </th>
                    <th scope="col" class="tbl_txt_4">
                        Class
                    </th>
                    <th scope="col" class="tbl_txt_4">
                        Section
                    </th>
                    <th scope="col" class="tbl_txt_4">
                        Semester
                    </th>
                    <th scope="col" class="tbl_txt_12">
                        Teacher Name
                    </th>
                    <th scope="col" class="tbl_txt_4">
                        Subject
                    </th>
                    <th scope="col" class="tbl_txt_4">
                        Attendance
                    </th>
                    <th scope="col" class="tbl_txt_4">
                        Leave Remarks
                    </th>
                    {{-- <th scope="col" class="hide_column tbl_srl_16">
                        Lecture Time
                    </th> --}}
                    <th scope="col" class="hide_column tbl_srl_16">
                        Created At
                    </th>
                    <th scope="col" class="tbl_txt_12">
                        Branch Name
                    </th>
                    <th scope="col" class="tbl_txt_12">
                        Created By
                    </th>
                </tr>
            </thead>
            <tbody class="table-td">
                @php
                    $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                    $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                    $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                    $countSeg = !empty($segmentSr) ? $segmentSr : 0;

                @endphp
                @foreach ($attendance as $data)
                    <tr>
                        <th scope="row">
                            {{ $sr }}
                        </th>
                        <td class="">
                            {{ $data->dep_title }}
                        </td>
                        <td>
                            {{ $data->class_name }}
                        </td>
                        <td>
                            {{ $data->cs_name }}
                        </td>
                        <td>
                            {{ $data->semester_name }}
                        </td>
                        <td>
                            {{ $data->employee }}
                        </td>
                        <td>
                            {{ $data->subject_name }}
                        </td>
                        <td>
                            {{ $data->lai_attendance }}
                        </td>
                        <td>
                            {{ $data->lai_leave_remarks }}
                        </td>
                        {{-- <td>
                            {{ $data->lai_start_time }}
                        </td> --}}
                        <td class="text-center">
                            {{ $data->lai_created_datetime }}
                        </td>
                        <td class="text-center">
                            {{ $data->branch_name }}
                        </td>

                        @php
                            $ip_browser_info = '' . $data->la_ip_adrs . ',' . str_replace(' ', '-', $data->la_brwsr_info) . '';
                        @endphp

                        <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}"
                            data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                            {{ $data->user_name }}
                        </td>
                    </tr>
                    @php
                        $sr++;
                        !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                    @endphp
                @endforeach
            </tbody>

        </table>
    </div>
</body>
{{-- @endsection --}}
