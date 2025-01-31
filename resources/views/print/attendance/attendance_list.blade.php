@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th tabindex="-1" scope="col" class="tbl_srl_4">Sr#</th>
            <th scope="col" class="tbl_amnt_10">Month</th>
            <th scope="col" class="tbl_amnt_10">Date</th>
            <th tabindex="-1" scope="col" class="tbl_txt_20">Department</th>
            <th tabindex="-1" scope="col" class="tbl_txt_35">Employee</th>
            <th scope="col" class="tbl_txt_5">Month Days</th>
            <th scope="col" class="tbl_amnt_5">Attend Days</th>
            <th scope="col" class="tbl_txt_10">Created By</th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $attendance)

            <tr>
                <th>{{$sr}}</th>
                <td>{{$attendance->atten_month}}</td>
                <td>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $attendance->atten_day_end_date)))}}
                </td>
                <td>{{$attendance->department}}</td>
                <td>{{$attendance->employee}}</td>
                <td class="text-center">{{$attendance->atten_month_days}}</td>
                <td class="text-center">{!! $attendance->atten_attend_days !!}</td>

                <td>{{$attendance->created_by}}</td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Attendance</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

