
@extends('print.college_print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <style>
        .table-bordered td, .table-bordered th {
            border: 1px solid #000 !important;
        }
    </style>

    <table class="table table-bordered table-sm" id="fixTable">
        <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">Sr #</th>
            <th scope="col" class="tbl_txt_8">Roll #</th>
            <th scope="col" class="tbl_txt_8">Type</th>
            <th scope="col" class="tbl_txt_20">Name</th>
            <th scope="col" class="tbl_txt_20">Section</th>
            <th scope="col" class="tbl_txt_10">Component</th>
            <th scope="col" class="tbl_txt_10">Paid</th>
            <th scope="col" class="tbl_txt_8">Paid Date</th>
            <th scope="col" class="tbl_txt_10">Total</th>
            <th scope="col" class="tbl_txt_10">Received</th>
            <th scope="col" class="tbl_txt_12">Balance</th>
        </tr>
        </thead>
        <tbody>
        @php
            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
            $total_paid =  0;
            $total_amount =  0;
            $total_receivable = 0;
            $total_package = 0;

        @endphp
        @foreach ($fee_students as $data)
            @php
                $total = 0;
                 $balance = 0;
                 $received = $data->paid;

             $total_package +=$data->total_amount;
             $total_amount +=$data->total_amount;
             $total +=$data->total_amount;
             $balance =$data->total_amount;
            @endphp
            <tr class="bg-success text-white">

                <th scope="row">{{ $sr }}</th>
                <td>{{ $data->roll_no }}</td>
                <td>{{ $search_type == 1 ? 'Regular':'Arrears' }}</td>
                <td>{{ $data->full_name }}</td>
                <td>{{ $data->cs_name }}</td>
                <td class="text-center" colspan="3"> Custom Fee</td>
                <td class="text-right">{{ number_format($data->total_amount) }}</td>
                <td class="text-right">{{ number_format($data->paid) }}</td>
                <th class="text-right" >{{number_format($data->total_amount - $data->paid)}}</th>
            </tr>

            @foreach ($datas as $data2)
                @if ($data->id == $data2->cv_std_id)
                    <tr>
                        <th scope="row"></th>
                        <td class="text-right" colspan="2">CV-{{$data2->cv_v_no}}</td>
                        <td class="text-right" colspan="3">{{$data2->cvi_component_name}}</td>
                        <td class="text-center">{{ $data2->cv_status ==  'Paid' ? 'Yes' : 'No'}}</td>
                        <td> {{ $data2->cv_paid_date != null ? date('d-M-y', strtotime(str_replace('/', '-', $data2->cv_paid_date))) : ''}}</td>
                        <td class="text-right" >{{ number_format($data2->cvi_amount) }}</td>
                        <td class="text-right" >{{ $data2->cv_status ==  'Paid' ? number_format($data2->cvi_amount):'' }}</td>
                        <td class="text-right" ></td>
                    </tr>
                @endif
            @endforeach
            @php
                $sr++;
            @endphp
            <tr class="bg-info text-white">
                <th class="text-right" colspan="8">Total:-</th>
                <th class="text-right">{{ number_format($total) }}</th>
                <th class="text-right">{{ number_format($received) }}</th>
                <th class="text-right">{{ number_format(($total - $received)) }}</th>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

