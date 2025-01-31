
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_25">Board Type</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_15">Width From</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_15">Width To</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_15">Pipe Center Support</th>
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

                <td class="align_left text-left edit tbl_txt_25">{{$area->bt_title}}</td>

                <td class="align_left text-left edit tbl_txt_15">{{$area->pwc_width_from}}</td>

                <td class="align_left text-left edit tbl_txt_15">{{$area->pwc_width_to}}</td>

                <td class="align_left text-left edit tbl_txt_15">{{$area->pwc_pipe_center_support }}</td>

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
                    <center><h3 style="color:#554F4F">No Pipe width Calibration </h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

