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
                            <h4 class="text-white get-heading-text file_name">Fee Register</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('fee_register') }}" name="form1" id="form1"
                          method="post">
                        <div class="row">
                            @csrf
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers"
                                           class="inputs_up form-control all_clm_srch" name="search" id="search"
                                           placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($students as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Select Class
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="class"
                                            id="class" style="width: 90%">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option
                                                value="{{$class->class_id}}" {{ $class->class_id == $search_class ? 'selected="selected"' : '' }}>{{$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo2" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Select Section
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="section"
                                            id="section" style="width: 90%">
                                        <option value="">Select Section</option>
                                        @foreach($sections as $section)
                                            <option
                                                value="{{$section->cs_id}}" {{ $section->cs_id == $search_section ? 'selected="selected"' : '' }}>{{$section->cs_name}}</option>
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
                                        Select Status
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control" name="status" id="status">
                                        <option value="3" {{ 3 == $search_status ? 'selected="selected"' : '' }}>All
                                        </option>

                                        <option value="0" {{ 0 == $search_status ? 'selected="selected"' : '' }}>Pending
                                        </option>
                                        <option value="1" {{ 1 == $search_status ? 'selected="selected"' : '' }}>Paid
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
                            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 mt-4 text-right form_controls">
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
                            <th scope="col" class="tbl_txt_6">Roll #</th>
                            <th scope="col" class="tbl_txt_6">Reg #</th>
                            <th scope="col" class="tbl_txt_12">Name</th>
                            <th scope="col" class="tbl_txt_8">Tuition Fee</th>
                            <th scope="col" class="tbl_txt_8">Paper Fund</th>
                            <th scope="col" class="tbl_txt_8">Annual Fund</th>
                            <th scope="col" class="tbl_txt_6">Zakat</th>
                            <th scope="col" class="tbl_txt_8">Total</th>
                            <th scope="col" class="tbl_txt_6">FID</th>
                            <th scope="col" class="tbl_txt_6">Month</th>
                            <th scope="col" class="tbl_txt_4">Paid</th>
                            <th scope="col" class="tbl_txt_6">Paid Date</th>
                            {{--                            <th scope="col" class="tbl_txt_12">Amount</th>--}}
                            <th scope="col" class="tbl_txt_8">Received</th>
                            <th scope="col" class="tbl_txt_10">Balance</th>
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
                                ->where('sp_semester', '=', $search_semester)
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
                            $grand_paper_fund=$grand_paper_fund+$count->paper_fund;
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
                                        <td class="text-right" colspan="3">
                                            {{$data->semester_name }}
{{--                                            {{$data->fv_package_type == 1 ? 'Regular':'Arrears'}}--}}
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
                                <th class="text-right" colspan="4">Total:-</th>
                                <th class="text-right">{{ number_format($grand_tuition_fee) }}</th>
                                <th class="text-right">{{ number_format($grand_paper_fund) }}</th>
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

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$fee_students->firstItem()}} - {{$fee_students->lastItem()}} of {{$fee_students->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span
                            class="hide_column"> {{ $fee_students->appends(['segmentSr' => $countSeg, 'search'=>$search, 'class'=>$search_class, 'section'=>$search_section, 'type'=>$search_type , 'status'=>$search_status , 'semester'=>$search_semester ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('fee_register') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        $(document).ready(function () {

        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#class").select2().val(null).trigger("change");
            $("#class > option").removeAttr('selected');

            $("#section").select2().val(null).trigger("change");
            $("#section > option").removeAttr('selected');

            $("#semester").select2().val(null).trigger("change");
            $("#semester > option").removeAttr('selected');
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#class").select2();
            jQuery("#section").select2();
            jQuery("#semester").select2()
        });

        $('#class').change(function () {
            var class_id = $(this).children('option:selected').val();
            $.ajax({
                url: '/get_groups',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function (data) {
                    console.log(data);
                    $('#section').html("");
                    var sections = '<option selected disabled hidden>Choose Section</option>';
                    $.each(data.section, function (index, items) {
                        sections +=
                            `<option value="${items.cs_id}"> ${items.cs_name} </option>`;
                    });

                    $('#section').html(sections);
                }
            })
        });
    </script>
@endsection

