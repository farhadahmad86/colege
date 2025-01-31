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
            <th scope="col" class="tbl_txt_20">Class</th>
            <th scope="col" class="tbl_txt_4">Type</th>
            <th scope="col" class="tbl_txt_5">Section</th>
            <th scope="col" class="tbl_txt_9">Tuition Fee</th>
            <th scope="col" class="tbl_txt_9">Paper Fund</th>
            <th scope="col" class="tbl_txt_9">Annual Fund</th>
            <th scope="col" class="tbl_txt_9">Zakat Fund</th>
            <th scope="col" class="tbl_txt_10">Total Fee</th>
            <th scope="col" class="tbl_txt_10">Total Received</th>
            <th scope="col" class="tbl_txt_10">Remaining</th>
            <th scope="col" class="tbl_txt_8">No. of Students</th>
        </tr>
        </thead>
        <tbody>
        @php
            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
            $total_t_fee =0;
            $total_a_fund =0;
            $total_p_fund =0;
            $total_z_fund =0;
            $total_paid_fee =0;
            $total_student =0;
        @endphp
        @forelse($datas as $data)
            @php
                $total_fee = $data->tution_fee + $data->annual_fund + $data->paper_fund;
                $total_t_fee += $data->tution_fee;
                $total_a_fund += $data->annual_fund;
                $total_p_fund += $data->paper_fund;
                $total_z_fund += $data->zakat_fund;
                $total_paid_fee += $data->paid_fee;
                $total_student += $data->total_students;
            @endphp
            <tr>

                <th scope="row" class="bordered  tbl_srl_4">{{$sr}}</th>
                <td class="bordered ">{{$data->class_name}}</td>
                <td class="bordered ">{{$data->type == 1 ? 'Regular':'Arrears'}}</td>
                <td class="bordered ">{{$data->cs_name}}</td>
                <td class="bordered text-right">{{$data->tution_fee}}</td>

                <td class="bordered text-right">{{$data->annual_fund }}</td>
                <td class="bordered text-right">{{$data->paper_fund }}</td>
                <td class="bordered text-right">{{$data->zakat_fund }}</td>
                <td class="bordered text-right">{{$total_fee  }}</td>
                <td class="bordered text-right">{{$data->paid_fee}}</td>
                <td class="bordered text-right">{{$total_fee - $data->paid_fee}}</td>
                <td class="bordered text-right">{{$data->total_students}}</td>

            </tr>
            @php
                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="12">
                    <center><h3 style="color:#554F4F">No Entry</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
        <tfoot>
        <tr>
            <th class="text-right" colspan="4">Total:-</th>
            <th class="text-right">{{$total_t_fee}}</th>
            <th class="text-right">{{$total_a_fund}}</th>
            <th class="text-right">{{$total_p_fund}}</th>
            <th class="text-right">{{$total_z_fund}}</th>
            <th class="text-right">{{$total_t_fee + $total_a_fund + $total_p_fund + $total_z_fund}}</th>
            <th class="text-right">{{$total_paid_fee}}</th>
            <th class="text-right">{{($total_t_fee + $total_a_fund + $total_p_fund + $total_z_fund) - $total_paid_fee}}</th>
            <th class="text-right">{{$total_student}}</th>

        </tr>
        </tfoot>
    </table>

@endsection

