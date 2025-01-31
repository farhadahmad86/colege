@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
    <table class="table border-0 table-sm" style="padding-left: 15px; padding-right: 15px; margin-top:25px">

        <thead style="border: px solid">
            <tr>
                <th scope="col" align="center" class="text-center align_center tbl_srl_2" style="border: 1px solid">Sr</th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_10" style="border: 1px solid">Subject
                    Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_10" style="border: 1px solid">
                    Teacher Name
                </th>
            </tr>
        </thead>

        <tbody>
            @php
                $sr = 1;
                use App\User;
            @endphp
            @forelse($datas as $item)
                <tr style="font-size: 12px;">

                    <td class="align_center text-center" style="border: 1px solid">{{ $sr }}</td>
                    <td class="align_center text-center" style="border: 1px solid">{{ $item->subject_name }}</td>
                    @php
                        
                        $teachers = User::whereIn('user_id', explode(',', $item->subject_teacher_id))->get();
                    @endphp
                    <td class="edit ">
                        @foreach ($teachers as $teacher)
                            {{ $teacher->user_name }},
                        @endforeach
                    </td>
                </tr>
                @php
                    $sr++;
                @endphp
            @empty
                <tr>
                    <td colspan="11">
                        <center>
                            <h3 style="color:#554F4F">No Program</h3>
                        </center>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
