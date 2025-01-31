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
                            <h4 class="text-white get-heading-text file_name">Custom Fee Register</h4>
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
                    <form class="highlight prnt_lst_frm" action="{{ route('custom_fee_register') }}" name="form1" id="form1"
                          method="post">
                        <div class="row">
                            @csrf
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
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
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="class" id="class" style="width: 90%">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{$class->class_id}}" {{ $class->class_id == $search_class ? 'selected="selected"' : '' }}>{{$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo2" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-1 col-md-2 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Select Section
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="section" id="section" style="width: 90%">
                                        <option value="">Select Section</option>
                                        @foreach($sections as $section)
                                            <option value="{{$section->cs_id}}" {{ $section->cs_id == $search_section ? 'selected="selected"' : '' }}>{{$section->cs_name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo2" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-1 col-md-2 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Select Type
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control" name="type" id="type">
                                        <option value="">Select Type</option>

                                        <option value="1" {{ 1 == $search_type ? 'selected="selected"' : '' }}>Regular</option>
                                        <option value="2" {{ 2 == $search_type ? 'selected="selected"' : '' }}>Arrears</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-1 col-md-2 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Status
                                    </label>
                                    <select tabindex="5" name="status" class="inputs_up form-control" id="status">
                                        <option value="">Select Status</option>
                                        <option value="Pending" {{ 'Pending' == $search_status ? 'selected="selected"' : '' }}>
                                            Pending
                                        </option>
                                        <option value="Paid" {{ 'Paid' == $search_status ? 'selected="selected"' : '' }}>
                                            Paid
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-4 text-right form_controls">
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
                            <th scope="col" class="tbl_txt_8">Roll #</th>
                            <th scope="col" class="tbl_txt_8">Type</th>
                            <th scope="col" class="tbl_txt_15">Name</th>
                            <th scope="col" class="tbl_txt_4">Section</th>
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

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$fee_students->firstItem()}} - {{$fee_students->lastItem()}} of {{$fee_students->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span class="hide_column"> {{ $fee_students->appends(['segmentSr' => $countSeg, 'search'=>$search, 'class'=>$search_class, 'section'=>$search_section, 'type'=>$search_type ])
                        ->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('custom_fee_register') }}',
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

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#class").select2();
            jQuery("#section").select2();
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

