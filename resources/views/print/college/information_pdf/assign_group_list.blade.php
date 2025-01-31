@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
    <table class="table border-0 table-sm" style="padding-left: 15px; padding-right: 15px; margin-top:25px">
        <thead style="border: px solid">
            <tr>
                <th scope="col" align="center" class="text-center align_center tbl_srl_2" style="border: 1px solid">Sr</th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_10" style="border: 1px solid">Class
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_10" style="border: 1px solid">
                    Section
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_10" style="border: 1px solid">
                    Groups
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_10" style="border: 1px solid">
                    Semester/Year
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_10" style="border: 1px solid">Type
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_10" style="border: 1px solid">
                    Subjects
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_10" style="border: 1px solid">
                    Strength
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_10" style="border: 1px solid">
                    Branch
                </th>
            </tr>
        </thead>

        <tbody>
            @php
                $sr = 1;
                use App\Models\College\Subject;
            @endphp
            @forelse($datas as $item)
                <tr style="font-size: 12px;">

                    <td class="align_center text-center" style="border: 1px solid">{{ $sr }}</td>
                    <td class="align_center text-center" style="border: 1px solid">{{ $item->class_name }}</td>
                    <td class="align_center text-center" style="border: 1px solid">{{ $item->cs_name }}</td>
                    <td class="align_center text-center" style="border: 1px solid">{{ $item->ng_name }}</td>
                    <td class="align_center text-center" style="border: 1px solid">{{ $item->semester_name }}</td>
                    <td class="align_center text-center" style="border: 1px solid">
                        @if ($item->group_discipline == 'S')
                            {{ 'Semester' }}
                        @else
                            {{ 'Annual' }}
                        @endif
                    </td>
                    @php
                        $subjects = Subject::whereIn('subject_id', explode(',', $item->group_subject_id))
                            ->select('subject_name')
                            ->get();
                    @endphp
                    <td class="align_center text-center" style="border: 1px solid">
                        @foreach ($subjects as $subject)
                            {{ $subject->subject_name }},
                        @endforeach
                    </td>
                    <td class="align_center text-center" style="border: 1px solid">
                        @inject('student', 'App\Models\College\Student')
                        <span class="text-center">{{ $student->where('class_id', $item->class_id)->where('group_id', $item->ng_id)->where('section_id', $item->cs_id)->where('branch_id', session('branch_id'))->count() }}</span>
                    </td>
                    <td class="align_center text-center" style="border: 1px solid">
                        {{ $item->branch_name }}
                    </td>
                </tr>
                @php
                    $sr++;
                @endphp
            @empty
                <tr>
                    <td colspan="11">
                        <center>
                            <h3 style="color:#554F4F">No Component</h3>
                        </center>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
