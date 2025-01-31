@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                Sr#
            </th>
            <th scope="col" class="tbl_txt_20">
                Name
            </th>
            <th scope="col" class="tbl_txt_10">
                Date
            </th>
            <th scope="col" class="tbl_txt_10">
                Transaction Type
            </th>
            <th scope="col" class="tbl_txt_20">
                Remarks
            </th>
            <th scope="col" class="tbl_txt_12">
                Dr
            </th>
            <th scope="col" class="tbl_txt_12">
                Cr
            </th>
            <th scope="col" class="tbl_txt_12">
                Balance
            </th>

        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $data)
            <tr data-title="{{ $data->full_name }}" data-student_id="{{ $data->id }}">
                <th>{{$sr}}</th>
                <td>{{ $data->full_name }}</td>
                <td>{{ $data->sbal_datetime }}</td>
                <td> {{$data->sbal_transaction_type}}</td>
                <td>   {!! str_replace("&oS;",'<br />', $data->sbal_detail_remarks) !!}</td>
                <td> {{$data->sbal_dr}}</td>
                <td>{{$data->sbal_cr}}</td>
                <td>{{$data->sbal_total}}</td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Data Found</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

