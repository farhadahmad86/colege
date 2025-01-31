@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
    @php use Carbon\Carbon;@endphp
    <div class="text-center">
        <h4>{{ $class }}, {{ $section }} </h4>
        <h5>{{ $search_month }}</h5>
    </div>
    <table class="table border-0 table-sm" style="padding-left: 15px; padding-right: 15px;">

        <thead>
            <tr>
                <th scope="col" class="text-center tbl_srl_4" style="border: 1px solid">Sr</th>
                <th scope="col" class="text-center tbl_srl_8" style="border: 1px solid">Roll No
                </th>
                <th scope="col" class="text-center tbl_txt_16" style="border: 1px solid">
                    Student
                    Name</th>
                {{-- <th scope="col" class="text-center tbl_txt_10">Parent Name</th> --}}
                <th scope="col" class="text-center tbl_txt_10" style="border: 1px solid">
                    Contact
                </th>
                @for ($i = 1; $i <= $numDays; $i++)
                    @php
                        $date = $year . '-' . $month . '-' . $i;
                        $dayName = Carbon::parse($date)->format('l');
                    @endphp ?>
                    <th scope="col" class="text-center tbl_txt_2" style="border: 1px solid">
                        {{ $dayName[0] }} {{ $i > 9 ? $i : '0' . $i }}
                    </th>
                @endfor
            </tr>
        </thead>

        <tbody>
            @php
                $sr = 1;
            @endphp
            @forelse($datas as $item)
                <tr style="font-size: 12px;">

                    <td class="align_center text-center" style="border: 1px solid">{{ $sr }}</td>
                    <td class="align_center text-center" style="border: 1px solid">{{ $item->roll_no }}</td>

                    <td style="border: 1px solid">{{ $item->full_name }}</td>
                    {{-- <td class="align_left text-left">{{ $item->father_name }}</td> --}}
                    <td style="border: 1px solid">{{ $item->parent_contact }}</td>


                    @for ($i = 1; $i <= $numDays; $i++)
                        <td style="border: 1px solid"></td>
                    @endfor
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
