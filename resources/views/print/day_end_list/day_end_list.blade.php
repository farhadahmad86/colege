
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">
        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>
            <th scope="col" align="center" class="text-center align_center tbl_srl_4">ID</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_18">Date</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_18">Time</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_20">Day Report</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_20">Month Report</th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_20">Created By</th>
        </tr>
        </thead>
        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $data)
            <tr>

                <td class="align_center text-center edit tbl_srl_4">{{$sr}}</td>
                <td class="align_center text-center edit tbl_srl_4">{{$data->de_id}}</td>

                <td class="align_left text-left edit tbl_txt_18">{{$data->de_datetime}}</td>
                <td class="align_left text-left edit tbl_txt_18">{{$data->de_current_datetime}}</td>

                <td class="align_left text-center edit tbl_txt_20"><a href="{{$data->de_report_url}}" target="_blank">View Report</a></td>

                <td class="align_left text-center edit tbl_txt_20">
                    @if(empty($data->de_month_end_report_url))
                        -
                    @else
                        <a href="{{$data->de_month_end_report_url}}" target="_blank">View Report</a>
                    @endif
                </td>

                <td class="align_left text-left usr_prfl tbl_txt_20" data-usr_prfl="{{ $data->user_id }}"  title="Click To See User Detail">
                    {{ $data->user_name }}
                </td>

            </tr>
{{--            <tr>--}}
{{--                --}}
{{--                <td class="align_left text-left edit tbl_txt_38">--}}
{{--                    {{$data->cur_title}}--}}
{{--                </td>--}}
{{--                <td class="align_left text-left edit tbl_txt_38">--}}
{{--                    {{$data->cur_remarks }}--}}
{{--                </td>--}}
{{--                <td class="align_left text-left usr_prfl tbl_amnt_10">--}}
{{--                    {{$data->user_name}}--}}
{{--                </td>--}}
{{--            </tr>--}}
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Day End</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

