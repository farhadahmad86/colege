@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
<table class="table table-bordered table-sm" id="fixTable">

    <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                ID
            </th>
            <th scope="col" class="tbl_txt_30">
                Class
            </th>
            <th scope="col" class="tbl_txt_10">
                Section
            </th>
            <th scope="col" class="tbl_txt_10">
                Time Table
            </th>
            <th scope="col" class="tbl_txt_10">
                Semester/Annual
            </th>
            <th scope="col" class="tbl_txt_8">
                W.E.F
            </th>
            <th scope="col" class="tbl_txt_6">
                Break Start Time
            </th>
            <th scope="col" class="tbl_txt_6">
                Break End Time
            </th>

            <th scope="col" class="tbl_txt_8">
                Branch
            </th>
        </tr>
    </thead>

    <tbody>
        @php
           $sr = 1;
            use App\Models\College\Subject;
        @endphp
        @forelse($datas as $data)
            <tr >
                <th scope="row">
                    {{ $sr }}
                </th>
                <td class="edit ">
                    {{ $data->class_name }}
                </td>
                <td class="edit ">
                    {{ $data->cs_name }}
                </td>
                <td class="view" data-id="{{ $data->tm_id }}">
                    View Time Table
                </td>
                <td>{{ $data->semester_name }}</td>
                <td>{{ $data->tm_wef }}</td>
                <td>{{ $data->tm_break_start_time }}</td>
                <td>{{ $data->tm_break_end_time }}</td>
                <td> {{ $data->branch_name }}</td>
                <td class="usr_prfl "title="Click To See User Detail">
                    {{ $data->users->user_name }}
                </td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center>
                        <h3 style="color:#554F4F">No Time Table</h3>
                    </center>
                </td>
            </tr>
        @endforelse
    </tbody>

</table>
@endsection
