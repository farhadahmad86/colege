
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_25">Region Name</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_25">Area Name</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_31">Remarks</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Created By</th>
        </tr>
        </thead>

        <tbody>
            @php
                $sr=1;
            @endphp
            @forelse($datas as $area)

                <tr>

                    <td class="align_center text-center edit tbl_srl_4">{{$sr}}</td>

                    <td class="align_left text-left edit tbl_txt_25">{{$area->reg_title}}</td>

                    <td class="align_left text-left edit tbl_txt_25">{{$area->area_title}}</td>
                    <td class="align_left text-left edit tbl_txt_31">{{$area->area_remarks }}</td>

                    <td class="align_left text-left usr_prfl tbl_txt_8">
                        {{ $area->user_name }}
                    </td>

                </tr>
                @php
                    $sr++;
                @endphp
            @empty
                <tr>
                    <td colspan="11">
                        <center><h3 style="color:#554F4F">No Area</h3></center>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection

