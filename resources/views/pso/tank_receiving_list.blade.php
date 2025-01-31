{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}

{{--    @include('include/head')--}}

{{--</head>--}}
{{--<body>--}}

{{--@include('include/header')--}}

{{--@include('include/sidebar')--}}

{{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}


{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">--}}
{{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">--}}

{{--<script type="text/javascript">--}}

{{--    function validate_form()--}}
{{--    {--}}
{{--        var search  = document.getElementById("search").value;--}}

{{--        var flag_submit = true;--}}

{{--        if(search.trim() == "")--}}
{{--        {--}}
{{--            document.getElementById("demo1").innerHTML = "Required";--}}
{{--            jQuery("#search").focus();--}}
{{--            flag_submit = false;--}}
{{--        }else{--}}
{{--            document.getElementById("demo1").innerHTML = "";--}}
{{--        }--}}

{{--        return flag_submit;--}}
{{--    }--}}
{{--</script>--}}



{{--<div class="main-container">--}}
{{--    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">--}}
{{--        @include('inc._messages')--}}

{{--        <div class="row">--}}
{{--            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">--}}

{{--                <div class="page-header">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6 col-sm-12">--}}
{{--                            <!-- <div class="title">--}}
{{--                                <h4>Account Registration</h4>--}}
{{--                            </div> -->--}}
{{--                            <nav aria-label="breadcrumb" role="navigation">--}}
{{--                                <ol class="breadcrumb">--}}
{{--                                    <li class="breadcrumb-item"><a href="index">Home</a></li>--}}
{{--                                    <li class="breadcrumb-item active" aria-current="page">Tank List</li>--}}
{{--                                </ol>--}}
{{--                            </nav>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}

{{--                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">--}}

{{--                    <div class="form_header"><!-- form header start -->--}}
{{--                        <div class="clearfix">--}}
{{--                            <div class="pull-left">--}}
{{--                                <h4 class="text-white file_name">Tank List</h4>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div><!-- form header close -->--}}

{{--                    <div class="search_form">--}}
{{--                        <div class="row">--}}

{{--                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">--}}

{{--                                <div class="form-group">--}}
{{--                                    <div class="input_bx"><!-- start input box -->--}}
{{--                                        <label class="required">--}}
{{--                                            Search--}}
{{--                                        </label>--}}
{{--                                        <select class="inputs_up form-control" id="srch_slct">--}}
{{--                                            <option value="all_data">All Data</option>--}}
{{--                                            <option value="full_search" selected>Full Search</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}


{{--                            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">--}}


{{--                                <div id="full_search" class="frm_hide show_active">--}}
{{--                                    <form action="tank_list" name="form1" id="form1" method="post" onsubmit="return validate_form()">--}}
{{--                                        <div class="row">--}}
{{--                                            @csrf--}}

{{--                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <div class="row">--}}
{{--                                                        <div class="form-group col-lg-9 col-md-9 col-sm-12">--}}
{{--                                                            <div class="input-group">--}}
{{--                                                                <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off" required>--}}

{{--                                                                <datalist id="browsers">--}}
{{--                                                                    @foreach($tank_title as $value)--}}
{{--                                                                        <option value="{{$value}}">--}}
{{--                                                                    @endforeach--}}
{{--                                                                </datalist>--}}
{{--                                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-lg-3 col-md-3 col-sm-12">--}}
{{--                                                                <button class="save_button form-control" name="go" id="go">Go!</button>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div> <!-- left column ends here -->--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                                </div>--}}

{{--                                <div id="all_data" class="frm_hide">--}}
{{--                                    <form action="tank_list" name="form" id="form" method="post">--}}
{{--                                        @csrf--}}

{{--                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">--}}
{{--                                            <div class="input_bx"><!-- start input box -->--}}
{{--                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                <button type="submit" name="save" id="save" class="save_button form-control m-0" style=" width: 120px !important;">--}}
{{--                                                    <i class="fa fa-search"></i> All--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                        </div> <!-- right columns ends here -->--}}
{{--                                    </form>--}}
{{--                                </div>--}}


{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}

{{--                    @include('include/print_button')--}}

{{--                    <div class="table-responsive" id="printTable">--}}
{{--                        <table class="table table-bordered table-sm" id="fixTable">--}}
{{--                            <thead>--}}
{{--                                <tr>--}}
{{--                                    <th scope="col" align="center">Sr#</th>--}}
{{--                                    <th scope="col" align="center">Date</th>--}}
{{--                                    <th scope="col" align="center">Amount</th>--}}
{{--                                </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                                @php--}}
{{--                                    $sr=1;--}}
{{--                                @endphp--}}
{{--                                @forelse($tanks as $tank)--}}

{{--                                    <tr>--}}
{{--                                        <td class="align_left edit">{{$sr}}</td>--}}
{{--                                        <td class="align_left edit">{{$tank->tr_day_end_date}}</td>--}}
{{--                                        <td class="align_left edit">{{$tank->tr_total_invoice }}</td>--}}
{{--                                    </tr>--}}
{{--                                    @php--}}
{{--                                        $sr++;--}}
{{--                                    @endphp--}}
{{--                                @empty--}}
{{--                                    <tr>--}}
{{--                                        <td colspan="11">--}}
{{--                                            <center><h3 style="color:#554F4F">No Entry</h3></center>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforelse--}}
{{--                            </tbody>--}}
{{--                        </table>--}}

{{--                    </div>--}}
{{--                    <span class="hide_column">{{ $tanks ->links() }}</span>--}}
{{--                </div> <!-- white column form ends here -->--}}


{{--            </div><!-- col end -->--}}
{{--        </div><!-- row end -->--}}


{{--        @include('include/footer')--}}


{{--    </div>--}}
{{--</div>--}}
{{--@include('include/script')--}}
{{--</body>--}}
{{--</html>--}}


@extends('extend_index')

@section('content')

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Tank Receiving List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

{{--                <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}">--}}
                <div class="search_form">
                    <div class="row">


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('tank_receiving_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1" method="post">
                                <div class="row">
                                    @csrf

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($tank_receiving_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">


                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Start Date
                                                    </label>
                                                    <input tabindex="2" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......" />
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        End Date
                                                    </label>
                                                    <input tabindex="3" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......" />
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="3" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="4" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="5" class="save_button form-control" href="{{ route('add_tank_receiving') }}" role="button">
                                                        <i class="fa fa-plus"></i> Add Tank Receiving
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                </div><!-- end row -->
                            </form>

                        </div>
                    </div>
                </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">Sr#</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">ID</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_25">Date</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_25">Amount</th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_10">Created By</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $tank_receiving)

                            <tr>
                                <td class="align_center text-center edit tbl_srl_6">{{$sr}}</td>
                               <td class="align_center text-center edit tbl_srl_6">{{$tank_receiving->tr_id}}</td>
                                <td class="align_left text-left edit tbl_txt_25">{{$tank_receiving->tr_day_end_date}}</td>
                                <td class="align_left text-left edit tbl_txt_25">{{$tank_receiving->tr_total_invoice}}</td>

                                @php
                                    $ip_browser_info= ''.$tank_receiving->tr_ip_adrs.','.str_replace(' ','-',$tank_receiving->tr_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_10" data-usr_prfl="{{ $tank_receiving->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $tank_receiving->user_name }}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Tank Receiving</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>

                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('tank_receiving_list') }}',
            url;

        @include('include.print_script_sh')
    </script>


    <script>
        jQuery("#cancel").click(function () {

            $("#to").val('');
            $("#from").val('');
            $("#search").val('');
        });
    </script>

    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>

@endsection

