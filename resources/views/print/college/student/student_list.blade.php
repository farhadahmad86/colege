@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
<div class="text-center">
    <h4>{{$branch}}</h4>
</div>
    <table class="table border-0 table-sm" style="margin-top: 25px;">

        <thead>

            <th scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_15">Registration No</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_20">Student Name</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_20">Father Name</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_14">Contact</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_25">Class Name</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_6">Section</th>
            </tr>
        </thead>

        <tbody>
            @php
                $sr = 1;
            @endphp
            @forelse($datas as $data)
                <tr>

                    <td class="align_center text-center edit tbl_srl_4">{{ $sr }}</td>

                    <td class="align_left text-left edit tbl_txt_10">{{ $data->registration_no }}</td>
                    
                    <td class="align_left text-left edit tbl_txt_20">{{ $data->full_name }}</td>
                    
                    <td class="align_left text-left edit tbl_txt_20">{{ $data->father_name }}</td>

                    <td class="align_left text-left edit tbl_txt_10">{{ $data->contact }}</td>

                    <td class="align_left text-left edit tbl_txt_20">{{ $data->class_name }}</td>

                    <td class="align_left text-left edit tbl_txt_20">{{ $data->cs_name }}</td>


                    {{-- <td class="align_left text-left usr_prfl tbl_txt_8">
                        {{ $data->user_name }}
                    </td> --}}

                </tr>
                @php
                    $sr++;
                @endphp
            @empty
                <tr>
                    <td colspan="11">
                        <center>
                            <h3 style="color:#554F4F">No Student</h3>
                        </center>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
