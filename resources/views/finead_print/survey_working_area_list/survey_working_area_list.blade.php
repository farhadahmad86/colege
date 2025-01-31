@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_2">
                Sr#
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_15">
                Company
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_15">
                Project
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_45">
                Remarks
            </th>

        </tr>
        </thead>

        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $surveor_working)
            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                {{--                <td class="align_center text-center tbl_amnt_10">--}}
                {{--                    {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->swa_day_end_date)))}}--}}
                {{--                </td>--}}
                {{--                <td class="view align_center text-center tbl_amnt_6" data-id="{{$voucher->swa_id}}">--}}
                {{--                    SWA-{{$voucher->swa_id}}--}}
                {{--                </td>--}}
                <td class="align_left text-left tbl_txt_15">
                    {{$surveor_working->account_name}}
                </td>
                <td class="align_left text-left tbl_txt_15">
                    {{$surveor_working->proj_project_name}}
                </td>
                <td class="align_right text-right tbl_amnt_45">
                    {{$surveor_working->swa_remarks}}
                </td>
            </tr>
            {{--            <tr>--}}
            {{--                <td class="text-center align_center edit tbl_srl_2">--}}
            {{--                    {{$sr}}--}}
            {{--                </td>--}}
            {{--                <td class="align_left text-left edit tbl_txt_10">--}}
            {{--                    {{$surveor_working->srv_name}}--}}
            {{--                </td>--}}
            {{--                <td class="align_left text-left edit tbl_txt_10">--}}
            {{--                    {{$surveor_working->srv_password_orignal}}--}}
            {{--                </td>--}}

            {{--            </tr>--}}
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Surveyor Working Area</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

