@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Attendance List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from)|| !empty($search_month) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('attendance_list') }}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers"
                                           class="inputs_up form-control" name="search" id="search"
                                           placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                           autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach ($employees as $value)
                                            <option value="{{ $value }}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->


                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Month
                                            </label>
                                            <input tabindex="2" type="text" name="month" id="month" class="inputs_up form-control month-picker" autocomplete="off" <?php if(isset
                                            ($search_month)){?> value="{{$search_month}}" <?php } ?>
                                                   placeholder="Start Month ......">

                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Start Date
                                            </label>

                                            <input tabindex="2" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                End Date
                                            </label>
                                            <input tabindex="3" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Department
                                            </label>
                                            <select tabindex="4" name="department" class="inputs_up form-control" id="department">
                                                <option value="">Select Department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{$department->dep_id}}" {{ $department->dep_id == $search_department ? 'selected="selected"' :
                                                                ''}}>{{$department->dep_title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <x-year-end-component search="{{$search_year}}"/>
                                    <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12 text-right mt-4">

                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('add_attendance') }}"/>

                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>
                    <form name="edit" id="edit" action="{{ route('edit_attendance') }}" method="post">
                        @csrf
                        <input name="attendance_id" id="attendance_id" type="hidden">
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" class="text-center align_center tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="align_center text-center tbl_amnt_6">
                                Month
                            </th>
                            <th scope="col" class="align_center text-center tbl_amnt_6">
                                Date
                            </th>
                            <th tabindex="-1" scope="col" class="align_center text-center tbl_txt_20">
                                Department
                            </th>
                            <th tabindex="-1" scope="col" class="align_center text-center tbl_txt_45">
                                Employee
                            </th>
                            <th scope="col" class="align_center text-center tbl_txt_5">
                                Month Days
                            </th>
                            <th scope="col" class="align_center text-center tbl_amnt_5">
                                Attend Days
                            </th>
                            <th scope="col" class="text-center align_center tbl_txt_10">
                                Created By
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $per_page_ttl_amnt = 0;
                        @endphp
                        @forelse($datas as $attendance)

                            <tr data-atten_id="{{$attendance->atten_id}}">
                                <th>
                                    {{$sr}}
                                </th>
                                <td class="edit">
                                    {{$attendance->atten_month}}
                                </td>
                                <td class="edit">
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $attendance->atten_day_end_date)))}}
                                </td>
                                <td class="edit">
                                    {{$attendance->department}}
                                </td>
                                <td class="edit">
                                    {{$attendance->employee}}
                                </td>
                                <td class="text-center edit">
                                    {{$attendance->atten_month_days}}
                                </td>
                                <td class="text-center edit">
                                    {{ $attendance->atten_attend_days }}
                                </td>

                                @php
                                    $ip_browser_info= ''.$attendance->atten_ip_adrs.','.str_replace(' ','-',$attendance->atten_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl" data-usr_prfl="{{ $attendance->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$attendance->created_by}}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Attendance</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from, 'month'=>$search_month ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('attendance_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
            $("#month").val('');
            $("#to").val('');
            $("#from").val('');

            $("#department").select2().val(null).trigger("change");
            $("#department > option").removeAttr('selected');
        });

        jQuery("#department").select2();
    </script>
    <script>

        jQuery(".edit").click(function () {


            var attendance_id = jQuery(this).parent('tr').attr("data-atten_id");

            jQuery("#attendance_id").val(attendance_id);
            jQuery("#edit").submit();
        });

    </script>
@endsection

