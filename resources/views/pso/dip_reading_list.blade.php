@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Dip Reading List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i tabindex="-1" class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

{{--                <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_employee) || !empty($search_tank) ) ? '' : 'search_form_hidden' }}"> -->--}}
{{--                --}}
                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                            <form class="prnt_lst_frm" action="{{ route('dip_reading_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($dip_reading_title as $value)
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
                                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="employee" id="employee">
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
                                                        Select Tank
                                                    </label>
                                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="tank" id="tank" style="width: 90%">
                                                        <option value="">Select Tank</option>
                                                        @foreach($tanks as $tank)
                                                            <option value="{{$tank->t_id}}" {{ $tank->t_id == $search_tank ? 'selected="selected"' : '' }}>{{$tank->t_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>


                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="4" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="5" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="6" class="save_button form-control" href="{{ route('add_dip_reading') }}" role="button">
                                                        <l class="fa fa-plus"></l>
                                                        Dip Reading
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
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_2">
                                Sr#
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_2">
                                ID
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Emp Name
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Tank
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_6">
                                Previous Date/Time
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Previous Dip Reading (mm)
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Previous Dip Reading (L)
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Date/Time
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Dip Reading (mm)
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Dip Reading (L)
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Difference in mm
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Difference in Litre
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_10">
                                Remarks
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_6">
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
                        @forelse($datas as $dip_reading)

                            <tr>

                                <td class="text-center align_center edit tbl_srl_2">
                                    {{$sr}}
                                </td>
                                <td class="text-center align_center edit tbl_srl_2">
                                    {{$dip_reading->employee_id}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_8">
                                    {{$dip_reading->employee_name}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_8">
                                    {{$dip_reading->t_name}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_6">
                                    {{$dip_reading->dip_pre_reading_datetime}}
                                </td>
                                <td class="align_right text-right edit tbl_txt_8">
                                    {{$dip_reading->dip_pre_reading}}
                                </td>
                                <td class="align_right text-right edit tbl_txt_8">
                                    {{$dip_reading->dip_pre_in_litre}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_8">
                                    {{$dip_reading->dip_reading_datetime}}
                                </td>
                                <td class="align_right text-right edit tbl_txt_8">
                                    {{$dip_reading->dip_reading}}
                                </td>
                                <td class="align_right text-right edit tbl_txt_8">
                                    {{$dip_reading->dip_in_litre}}
                                </td>
                                <td class="align_right text-right edit tbl_txt_8">
                                    {{$dip_reading->dip_difference_in_mm}}
                                </td>
                                <td class="align_right text-right edit tbl_txt_8">
                                    {{$dip_reading->dip_difference_in_litre}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_10">
                                    {{$dip_reading->dip_remarks}}
                                </td>
                                @php
                                    $ip_browser_info= ''.$dip_reading->dip_ip_adrs.','.str_replace(' ','-',$dip_reading->dip_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_6" data-usr_prfl="{{ $dip_reading->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User
                                        Detail">
                                    {{ $dip_reading->user_name }}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="15">
                                    <center><h3 style="color:#554F4F">No Dip-Reading</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
                <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'employee'=>$search_employee, 'tank'=>$search_tank ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('dip_reading_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        jQuery("#cancel").click(function () {

            $("#employee").select2().val(null).trigger("change");
            $("#employee > option").removeAttr('selected');

            $("#tank").select2().val(null).trigger("change");
            $("#tank > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#employee").select2();
            jQuery("#tank").select2();
        });
    </script>

@endsection

