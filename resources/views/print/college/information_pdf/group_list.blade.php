@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
    <table class="table border-0 table-sm" style="padding-left: 15px; padding-right: 15px; margin-top:25px">

        <thead style="border: px solid">
            <tr>
                <th scope="col" align="center" class="text-center align_center tbl_srl_2" style="border: 1px solid">Sr</th>
                <th scope="col" align="center" class="text-center align_center tbl_srl_10" style="border: 1px solid">Group Name
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
                    <td class="align_center text-center" style="border: 1px solid">{{ $item->ng_name }}</td>
                </tr>
                @php
                    $sr++;
                @endphp
            @empty
                <tr>
                    <td colspan="11">
                        <center>
                            <h3 style="color:#554F4F">No Groups</h3>
                        </center>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
