
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                Sr#
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Date
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                Last Voucher #
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_4">
                Days
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_76">
                Product Name
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $result)

            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_amnt_6">
                    {{date('d-M-y', strtotime(str_replace('/', '-', ($result->si_day_end_date !=0) ? $result->si_day_end_date : 'No Date')))}}
                </td>
                <td class="align_center text-center tbl_amnt_10">
                    <a class="view" data-transcation_id="{{'SV-'.$result->si_id}}" data-toggle="modal" data-target="#myModal" style="cursor:pointer; color: #0099ff;">
                        {{$result->si_id !=0 ? 'SV-'.$result->si_id:''}}
                    </a>
                </td>
                <td class="align_center text-center tbl_amnt_4">
                    {{$result->si_day_end_date !=0 ?  ((strtotime($balance) - strtotime($result->si_day_end_date)) / 86400):''}}
                </td>
                <td class="align_left text-left tbl_txt_76">
                    {{$result->pro_title}}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Record</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

