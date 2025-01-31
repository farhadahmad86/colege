@extends('extend_index')

@section('content')

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Nozzle Reading List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_employee) || !empty($search_nozzle) ) ? '' : 'search_form_hidden' }}"> -->
               

                <div class="">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                            <form class="prnt_lst_frm" action="{{ route('nozzle_reading_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($nozzle_reading_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Employee
                                                    </label>
                                                    <select class="inputs_up form-control cstm_clm_srch" name="employee" id="employee">
                                                        <option value="">Select Employee</option>
                                                        @foreach($employees as $employee)
                                                            <option value="{{$employee->user_id}}" {{ $employee->user_id == $search_employee ? 'selected="selected"' : '' }}>{{$employee->user_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">
                                                        Select Nozzle
                                                    </label>
                                                    <select class="inputs_up form-control cstm_clm_srch" name="nozzle" id="nozzle" style="width: 90%">
                                                        <option value="">Select Nozzle</option>
                                                        @foreach($nozzles as $nozzle)
                                                            <option value="{{$nozzle->noz_id}}" {{ $nozzle->noz_id == $search_nozzle ? 'selected="selected"' : '' }}>{{$nozzle->noz_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>


                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a class="save_button form-control" href="{{ route('add_nozzle_reading') }}" role="button">
                                                        <l class="fa fa-plus"></l>
                                                        Nozzle Reading
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div><!-- end row -->
                                    </div>
                                </div><!-- end row -->
                            </form>

                        </div>
                    </div>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_11">
                                Emp Name
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_11">
                                Nozzle
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                                Previous Date/Time
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_12">
                                Previous Nozzle Reading
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                                Date/Time
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                                Nozzle Reading
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                                Difference
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                                Remarks
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
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
                        @endphp
                        @forelse($datas as $nozzle_reading)

                            <tr>

                                <td class="text-center align_center edit tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_11">
                                    {{$nozzle_reading->employee_name}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_11">
                                    {{$nozzle_reading->noz_name}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_12">
                                    {{$nozzle_reading->nr_pre_reading_datetime}}
                                </td>
                                <td class="align_right text-right edit tbl_txt_12">
                                    {{$nozzle_reading->nr_pre_reading}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_10">
                                    {{$nozzle_reading->nr_reading_datetime}}
                                </td>
                                <td class="align_right text-right edit tbl_txt_10">
                                    {{$nozzle_reading->nr_reading}}
                                </td>
                                <td class="align_right text-right edit tbl_txt_10">
                                    {{$nozzle_reading->nr_difference}}
                                </td>
                                <td class="align_right text-right edit tbl_txt_10">
                                    {{$nozzle_reading->nr_remarks}}
                                </td>
                                @php
                                    $ip_browser_info= ''.$nozzle_reading->nr_ip_adrs.','.str_replace(' ','-',$nozzle_reading->nr_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_10" data-usr_prfl="{{ $nozzle_reading->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User
                                        Detail">
                                    {{ $nozzle_reading->user_name }}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="15">
                                    <center><h3 style="color:#554F4F">No Nozzle Reading</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
                <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'employee'=>$search_employee, 'nozzle'=>$search_nozzle ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('nozzle_reading_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        jQuery("#cancel").click(function () {

            $("#employee").select2().val(null).trigger("change");
            $("#employee > option").removeAttr('selected');

            $("#nozzle").select2().val(null).trigger("change");
            $("#nozzle > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#employee").select2();
            jQuery("#nozzle").select2();
        });
    </script>

@endsection

