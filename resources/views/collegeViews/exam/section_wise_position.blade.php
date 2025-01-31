@extends('extend_index')
@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Position List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('section_result') }}" name="form1" id="form1"
                          method="post">
                        <div class="row">
                            @csrf

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Exam
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="exam" id="exam" style="width: 90%">
                                        <option value="">Select Exam</option>
                                        @foreach($exams as $exam)
                                            <option value="{{$exam->exam_id}}" {{ $exam->exam_id == $search_exam ? 'selected="selected"' : '' }}>{{$exam->exam_name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo2" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Section
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
                            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 mt-4 text-right form_controls">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->

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
                            <th scope="col" class="tbl_srl_2">Sr</th>
                            <th scope="col" class="tbl_txt_8">Roll No</th>
                            <th scope="col" class="tbl_txt_8">Registration No</th>
                            <th scope="col" class="tbl_txt_12">Name</th>
                            <th scope="col" class="tbl_txt_12">Father Name</th>
                            <th scope="col" class="tbl_txt_12">Obtain Marks</th>
                            <th scope="col" class="tbl_txt_12">Total Marks</th>
                            <th scope="col" class="tbl_txt_12">Percentage</th>
                            <th scope="col" class="tbl_txt_12">Position</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $position=0;
                            $old_value=0.00;
                        @endphp
                        @forelse($sortedPosition as $item)
                            @php
                            if($old_value != $item['per']){
                                $position = $position + 1;
                            }
                            @endphp
                            <tr>
                                <th scope="row" class="bordered tbl_srl_4">{{$sr}}</th>
                                <th scope="row" class="bordered tbl_srl_4">{{$item['roll_no']}}</th>
                                <th scope="row" class="bordered tbl_srl_4">{{$item['reg_no']}}</th>
                                <td class="bordered">{{$item['name']}}</td>
                                <td class="bordered">{{$item['father_name']}}</td>
                                <td class="bordered">{{$item['obtain_marks']}}</td>
                                <td class="bordered">{{$item['total_marks'] }}</td>
                                <td class="bordered">{{$item['per'] }}</td>
                                <td class="bordered">{{ $position }}</td>
                            </tr>

                            @php
                                $old_value = $item['per'] ;
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Position</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->

    </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('section_result') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let areaId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_area') }}',
                    data: {'status': status, 'area_id': areaId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>
    <script>
        jQuery("#cancel").click(function () {

            $("#section").select2().val(null).trigger("change");
            $("#section > option").removeAttr('selected');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#section").select2();
        });
    </script>

    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>

@endsection
