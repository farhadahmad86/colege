@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Tank List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i tabindex="-1" class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
{{--                <div class="search_form  {{ ( !empty($search)) ? '' : 'search_form_hidden' }}">--}}

                <div class="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('tank_list') }}" name="form1" id="form1" method="post">
                                <div class="row">
                                    @csrf

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($tank_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="2" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="3" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div><!-- end row -->
                            </form>

                            <form name="edit" id="edit" action="edit_tank" method="post">
                                @csrf
                                <input tabindex="4" name="tank_id" id="tank_id" type="hidden">
                            </form>

                        </div>
                    </div>
                </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>
                           <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">ID</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_23">Name</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_23">Capacity</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_25">Stock</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">Created By</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $tank)

                            <tr data-tank_id="{{$tank->t_id}}">

                                <td class="align_center text-center edit tbl_srl_4">{{$sr}}</td>
                                <td class="align_center text-center edit tbl_srl_4">{{$tank->t_id}}</td>
                                <td class="align_left text-left edit tbl_txt_23">{{$tank->t_name}}</td>
                                <td class="align_left text-left edit tbl_txt_23">{{$tank->t_capacity}}</td>
                                <td class="align_left text-left edit tbl_txt_25">{{$tank->t_liters }}</td>

                                @php
                                    $ip_browser_info= ''.$tank->t_ip_adrs.','.str_replace(' ','-',$tank->t_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $tank->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $tank->user_name }}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Tank</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>

                <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('tank_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        jQuery(".edit").click(function () {
        var tank_id = jQuery(this).parent('tr').attr("data-tank_id");

        jQuery("#tank_id").val(tank_id);
        jQuery("#edit").submit();
        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
        });
    </script>

{{--    <script>--}}
{{--        jQuery(document).ready(function () {--}}
{{--            // Initialize select2--}}
{{--            jQuery("#region").select2();--}}
{{--        });--}}
{{--    </script>--}}

    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>

@endsection

