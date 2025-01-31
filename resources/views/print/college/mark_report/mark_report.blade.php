@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif
@section('print_cntnt')
    @php use Carbon\Carbon;@endphp
    <div class="text-center">
        <h4>{{ $class }},{{ $section }},{{ $group }}</h4>
    </div>
    <div style="margin-bottom: 15px; margin-top: 15px; padding-left: 15px">
        <div class="signature">
            <p>Test Name:</p>
            <p>-------------------</p>
        </div>

        <div class="signature">
            <p>Total Marks</p>
            <p>-------------------</p>
        </div>

        <div class="signature">
            <p>Subject:</p>
            <p>---------------</p>
        </div>
        <div class="signature">
            <p>Test Date</p>
            <p>-------------------</p>
        </div>
    </div>
    <table class="table border-0 table-sm" style="padding-left: 15px; padding-right: 15px;">

        <thead style="border: 1px solid">

            <th scope="col" align="center" class="text-center align_center tbl_srl_4">Sr</th>
            <th scope="col" align="center" class="text-center align_center tbl_srl_8">Roll No</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_16">Student Name</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">Father Name</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">Marks Obt</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">Sign</th>
            </tr>
        </thead>

        <tbody style="border: 1px solid">
            @php
                $sr = 1; 
            @endphp
            @forelse($students as $item)
                <tr style="font-size: 12px">

                    <td class="align_center text-center" style="border: 1px solid">{{ $sr }}</td>
                    <td class="align_center text-center" style="border: 1px solid">{{ $item->roll_no }}</td>

                    <td style="border: 1px solid">{{ $item->full_name }}</td>
                    <td style="border: 1px solid"> {{ $item->father_name }}</td>
                    <td style="border: 1px solid"></td>
                    <td style="border: 1px solid"></td>


                    {{-- @for ($i = 1; $i <= $numDays; $i++)
                        <td></td>
                    @endfor --}}
                </tr>
                @php
                    $count = $sr++;
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
    <footer style="margin-top: 25px; padding-left: 15px">
        <div class="signature">
            <p>Total Student:{{  $sr++ }}</p>
        </div>

        <div class="signature">
            <p>Appeared</p>
            <p>-------------------</p>
        </div>

        <div class="signature">
            <p>Absent/Sick</p>
            <p>-------------------</p>
        </div>
        <div class="signature">
            <p>Fail</p>
            <p>-------------------</p>
        </div>
        <div class="signature">
            <p>Pass</p>
            <p>-------------------</p>
        </div>
        <div style="padding-top: 15px;">
            <div class="signature" >
                <p>Checked By</p>
                <p>-------------------</p>
            </div>

            <div class="signature">
                <p>Rechecked By</p>
                <p>-------------------</p>
            </div>
            <div class="signature">
                <p>Principal</p>
                <p>-------------------</p>
            </div>
        </div>

    </footer>

@endsection
