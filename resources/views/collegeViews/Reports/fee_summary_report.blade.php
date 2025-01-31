@extends('extend_index')

@section('content')
    <style>
        .table-bordered td, .table-bordered th {
            border: 1px solid #000 !important;
        }
    </style>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Fee Summary Report</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('fee_summary_report') }}" name="form1"
                          id="form1"
                          method="post">
                        <div class="row">
                            @csrf

                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Select Class
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="class[]"
                                            id="class" style="width: 90%" multiple>
                                        @foreach ($classes as $class)
                                            @php
                                                $class_id = explode(',', $class_ids);
                                            @endphp

                                            <option value="{{$class->class_id}}"
                                                {{ in_array($class->class_id, $class_id) ? 'selected' : '' }}>
                                                {{ $class->class_name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo2" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Select Type
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control" name="type" id="type">
                                        <option value="">Select Type</option>

                                        <option value="1" {{ 1 == $search_type ? 'selected="selected"' : '' }}>Regular
                                        </option>
                                        <option value="2" {{ 2 == $search_type ? 'selected="selected"' : '' }}>Arrears
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Select Semester
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control" name="semester" id="semester">
                                        <option value="">Select Semester</option>
                                        @foreach($semesters as $sem)
                                            <option
                                                value="{{$sem->semester_id}}" {{ $sem->semester_id == $search_semester ? 'selected="selected"' : '' }}>
                                                {{$sem->semester_name}}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 mt-4 text-right form_controls">
                                @include('include.clear_search_button')

                                @include('include/print_button')
                                <span id="demo3" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div><!-- end row -->
                    </form>
                </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">
                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">Sr #</th>
                            <th scope="col" class="tbl_txt_18">Class</th>
                            <th scope="col" class="tbl_txt_8">Term</th>
                            <th scope="col" class="tbl_txt_5">Section</th>
                            <th scope="col" class="tbl_txt_9">Tuition Fee</th>
                            <th scope="col" class="tbl_txt_9">Paper Fund</th>
                            <th scope="col" class="tbl_txt_9">Annual Fund</th>
                            <th scope="col" class="tbl_txt_7">Zakat Fund</th>
                            <th scope="col" class="tbl_txt_10">Total Fee</th>
                            <th scope="col" class="tbl_txt_10">Total Received</th>
                            <th scope="col" class="tbl_txt_10">Remaining</th>
                            <th scope="col" class="tbl_txt_4" data-toggle="tooltip" data-placement="top"
                                title="Total Students">T/STD
                            </th>
                            <th scope="col" class="tbl_txt_8">%</th>
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
{{--                                <td class="bordered ">{{$data->type == 1 ? 'Regular':'Arrears'}}</td>--}}
                                <td class="bordered ">{{$data->semester_name}}</td>
                                <td class="bordered ">{{$data->cs_name}}</td>
                                <td class="bordered text-right">{{$data->tution_fee}}</td>

                                <td class="bordered text-right">{{$data->annual_fund }}</td>
                                <td class="bordered text-right">{{$data->paper_fund }}</td>
                                <td class="bordered text-right">{{$data->zakat_fund }}</td>
                                <td class="bordered text-right">{{$total_fee  }}</td>
                                <td class="bordered text-right">{{$data->paid_fee}}</td>
                                <td class="bordered text-right">{{$total_fee - $data->paid_fee}}</td>
                                <td class="bordered text-right">{{$data->total_students}}</td>
                                <td class="bordered text-right">{{$data->total_students > 0 ? round($data->tution_fee / $data->total_students) : $data->total_students}}</td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="13">
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
                            <th class="text-right"></th>
                            {{--                            <th class="text-right">{{round($total_t_fee / $total_student)}}</th>--}}

                        </tr>
                        </tfoot>
                    </table>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span
                            class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'class'=>$search_class, 'type'=>$search_type, 'semester'=>$search_semester])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('fee_summary_report') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

{{--    <script>--}}
{{--        $(document).ready(function () {--}}

{{--        });--}}
{{--    </script>--}}

    <script>
        jQuery("#cancel").click(function () {

            $("#class").select2().val(null).trigger("change");
            $("#class > option").removeAttr('selected');

            $("#type").select2().val(null).trigger("change");
            $("#type > option").removeAttr('selected');

            $("#semester").select2().val(null).trigger("change");
            $("#semester > option").removeAttr('selected');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#class").select2();
            jQuery("#semester").select2();
        });
    </script>
@endsection

