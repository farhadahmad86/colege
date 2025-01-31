@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
    <table class="table border-0 table-sm" style="padding-left: 15px; padding-right: 15px; margin-top:25px">

        <thead style="border: px solid">
            <tr>
                <th scope="col" align="center" class="text-center align_center tbl_srl_4" style="border: 1px solid">Sr</th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_8" style="border: 1px solid">Branch Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_16" style="border: 1px solid">
                    Branch#</th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_10" style="border: 1px solid">
                    Contact
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_10" style="border: 1px solid">
                    Contact2
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_10" style="border: 1px solid">
                    Address
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_10" style="border: 1px solid">
                    Status
                </th>
            </tr>
        </thead>

        <tbody>
            @php
                $sr = 1;
            @endphp
            @forelse($datas as $item)
                <tr style="font-size: 12px;">

                    <td class="align_center text-center" style="border: 1px solid">{{ $sr }}</td>
                    <td class="align_center text-center" style="border: 1px solid">{{ $item->branch_name }}</td>
                    <td style="border: 1px solid">{{ $item->branch_no }}</td>
                    <td style="border: 1px solid">{{ $item->branch_contact }}</td>
                    <td style="border: 1px solid">{{ $item->branch_contact2 }}</td>
                    <td style="border: 1px solid">{{ $item->branch_address }}</td>
                    <td style="border: 1px solid">{{ $item->branch_type }}</td>
                </tr>
                @php
                    $sr++;
                @endphp
            @empty
                <tr>
                    <td colspan="11">
                        <center>
                            <h3 style="color:#554F4F">No Branch</h3>
                        </center>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
