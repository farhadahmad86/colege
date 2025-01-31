
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
            <th scope="col" class="tbl_txt_6">Roll #</th>
            <th scope="col" class="tbl_txt_6">Reg #</th>
            <th scope="col" class="tbl_txt_15">Name</th>
            <th scope="col" class="tbl_txt_10">Tuition Fee</th>
            <th scope="col" class="tbl_txt_10">Paper Fund</th>
            <th scope="col" class="tbl_txt_10">Annual Fund</th>
            <th scope="col" class="tbl_txt_10">Zakat</th>
            <th scope="col" class="tbl_txt_10">Total</th>
            <th scope="col" class="tbl_txt_10">FID</th>
            <th scope="col" class="tbl_txt_8">Month</th>
            <th scope="col" class="tbl_txt_4">Paid</th>
            <th scope="col" class="tbl_txt_8">Paid Date</th>
            {{--                            <th scope="col" class="tbl_txt_12">Amount</th>--}}
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
            $total_t_fee =  0;
            $total_p_fund =  0;
            $total_a_fund =  0;
            $total_z_fund =  0;
            $total_amount =  0;
            $total_receivable = 0;
            $total_package = 0;
            $grand_tuition_fee=0;
            $grand_paper_fund=0;
            $grand_annual_fund=0;
            $grand_zakat_fund=0;
            use App\Models\College\StudentsPackageModel;
        @endphp
        @foreach ($fee_students as $std_id)
            @php
                $total = 0;
                $balance = 0;
                $received = 0;
                $count = StudentsPackageModel::where('sp_class_id', '=', $search_class)
                        ->where('sp_package_type', '=', $search_type)
                        ->where('sp_sid', '=', $std_id->id)
                        ->selectRaw('SUM(sp_T_package_amount) as tution_fee,
                         SUM(sp_P_package_amount) as paper_fund,
                         SUM(sp_A_package_amount) as annual_fund,
                         SUM(sp_Z_package_amount) as zakat_fund,
                         SUM(sp_package_amount) as total_amount')
                    ->first();

            $total_package +=$count->total_amount;
            $total_p_fund +=$count->paper_fund;
            $total_a_fund +=$count->annual_fund;
            $total_z_fund +=$count->zakat_fund;
            $total_amount +=$count->total_amount;
            $total +=$count->total_amount;
            $balance =$count->total_amount;
            $grand_tuition_fee=$grand_tuition_fee+$count->tution_fee;
            $grand_paper_fee=$grand_paper_fund+$count->paper_fund;
            $grand_annual_fund=$grand_annual_fund+$count->annual_fund;
            $grand_zakat_fund=$grand_zakat_fund+$count->zakat_fund;
            @endphp
            <tr class="bg-success text-white">

                <th scope="row">
                    {{ $sr }}
                </th>
                <td>{{ $std_id->roll_no }}</td>
                <td>{{ $std_id->registration_no }}</td>
                <td>{{ $std_id->full_name }}</td>
                <td class="text-right">{{ number_format($count->tution_fee) }}</td>
                <td class="text-right">{{ number_format($count->paper_fund) }}</td>
                <td class="text-right">{{ number_format($count->annual_fund) }}</td>
                <td class="text-right">{{ number_format($count->zakat_fund) }}</td>
                {{--                                <td class="text-right">{{ number_format($count->total_amount) }}</td>--}}

                <td class="text-center" colspan="5"> Booked Package</td>

                <th class="text-right" colspan="2">{{number_format($count->total_amount)}}</th>
            </tr>

            @foreach ($datas as $data)
                @if ($std_id->id == $data->fv_std_id)
                    @php
                        $total_t_fee += $data->fv_t_fee;
                        //$total_p_fund += $data->fv_p_fund;
                        //$total_a_fund += $data->fv_a_fund;
                        //$total_z_fund += $data->fv_z_fund;
                        //$total += $data->fv_total_amount;
                        //$total_amount += $data->fv_total_amount;
                    if($data->fv_status_update ==  1){
                        $received += $data->fv_total_amount;
                        $total_receivable += $data->fv_total_amount;
                        $balance -= $data->fv_total_amount;

                    }
                    @endphp
                    <tr>

                        <th scope="row">

                        </th>
                        <td class="text-right" colspan="2">
                            {{$data->fv_package_type == 1 ? 'Regular':'Arrears'}}
                        </td>
                        <td class="text-right">{{ number_format($data->fv_t_fee) }}</td>
                        <td class="text-right">{{ number_format($data->fv_p_fund) }}</td>
                        <td class="text-right">{{ number_format($data->fv_a_fund) }}</td>
                        <td class="text-right">{{ number_format($data->fv_z_fund) }}</td>
                        <td class="text-right">{{number_format($data->fv_total_amount)}}</td>
                        <td>{{ $data->fv_v_no }}</td>
                        <td>{{ $data->fv_month }}</td>
                        <td>{{ $data->fv_status_update ==  1 ? 'Yes' : 'No'}}</td>
                        <td> {{ $data->fv_paid_date != null ? date('d-M-y', strtotime(str_replace('/', '-', $data->fv_paid_date))) : ''}}</td>
                        <td>{{ $data->fv_status_update ==  1 ? number_format($data->fv_total_amount) : ''}}</td>
                        <td class="text-right">{{number_format($balance)}}</td>

                    </tr>
                @endif
            @endforeach
            @php
                $sr++;
            @endphp
            <tr class="bg-info text-white">
                <th class="text-right" colspan="3">Total:-</th>
                <th class="text-right">{{ number_format($grand_tuition_fee) }}</th>
                <th class="text-right">{{ number_format($grand_paper_fee) }}</th>
                <th class="text-right">{{ number_format($grand_annual_fund) }}</th>
                <th class="text-right">{{ number_format($grand_zakat_fund) }}</th>
                <th class="text-right" colspan="4"></th>

                <th class="text-right">{{ number_format($total) }}</th>
                <th class="text-right">{{ number_format($received) }}</th>
                <th class="text-right">{{ number_format(($total - $received)) }}</th>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

