{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}

{{--    @include('include/head')--}}

{{--</head>--}}
{{--<body>--}}

{{--@include('include/header')--}}
{{--@include('include.sidebar_shahzaib')--}}
{{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">--}}
{{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">--}}
{{--<script type="text/javascript">--}}
{{--    function validate_form() {--}}
{{--        var search = document.getElementById("search").value;--}}

{{--        var flag_submit = true;--}}

{{--        if (search.trim() == "") {--}}
{{--            document.getElementById("demo1").innerHTML = "Required";--}}
{{--            jQuery("#search").focus();--}}
{{--            flag_submit = false;--}}
{{--        } else {--}}
{{--            document.getElementById("demo1").innerHTML = "";--}}
{{--        }--}}

{{--        return flag_submit;--}}
{{--    }--}}
{{--</script>--}}
@extends('extend_index')
@section('content')
{{--<div class="main-container">--}}
{{--    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">--}}
{{--        @include('inc._messages')--}}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Party Wise Opening Closing</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="srch_box_opn_icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->


                    <div class="search_form m-0 p-0 {{ ( !empty($search) ) ? '' : '' }}">

                        <form class="highlight prnt_lst_frm" action="{{ route('party_wise_opening_closing') }}" name="form1" id="form1" method="post" onsubmit="return validate_form()">
                            @csrf
                            <div class="row">

                                <div class="form-group col-lg-2 col-md-3 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label>
                                            All Column Search
                                        </label>
                                        <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                               value="{{ isset($search) ? $search : '' }}" autocomplete="off" required>
                                        <datalist id="browsers">
                                            @foreach($party as $value)
                                                <option value="{{$value}}">
                                            @endforeach
                                        </datalist>
                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                    </div>
                                </div> <!-- left column ends here -->
                                <div class="form-group col-lg-10 col-md-9 col-sm-12 mt-4 text-right">
                                @include('include.clear_search_button')
                                    @include('include/print_button')
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                        </form>
                    </div><!-- search form end -->
                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm" id="fixTable">
                            <thead>
                            <tr>
                                <th scope="col" class="tbl_srl_4">
                                    Sr#
                                </th>
                                <th scope="col" class="tbl_txt_28">
                                    Account Name
                                </th>
                                <th scope="col" class="tbl_amnt_17">
                                    Opening Balance
                                </th>
                                <th scope="col" class="tbl_amnt_17">
                                    Total Dr
                                </th>
                                <th scope="col" class="tbl_amnt_17">
                                    Total Cr
                                </th>
                                <th scope="col" class="tbl_amnt_17">
                                    Total Closing
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $sr=1;
                                $dr_pg = $cr_pg = 0;
                                $opng_pg = $clsng_pg = 0;
                            @endphp
                            @forelse($datas as $result)
                                @php
                                    $dr_pg = +$result->dr + +$dr_pg;
                                    $cr_pg = +$result->cr + +$cr_pg;
                                    $opng_pg = +$result->opening + +$opng_pg;
                                    $clsng_pg = +$result->closing + +$clsng_pg;
                                @endphp

                                <tr>
                                    <th scope="row">
                                        {{$sr}}
                                    </th>
                                    <td>
                                        {{$result->account_name}}
                                    </td>
                                    <td align="right" class="align_right text-right">
                                        {{$result->opening}}
                                    </td>
                                    <td align="right" class="align_right text-right">
                                        {{$result->dr}}
                                    </td>
                                    <td align="right" class="align_right text-right">
                                        {{$result->cr}}
                                    </td>
                                    <td align="right" class="align_right text-right">
                                        {{$result->closing}}
                                    </td>

                                </tr>
                                @php
                                    $sr++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <center><h3 style="color:#554F4F">No Record</h3></center>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>

                            <tfoot>
                            <tr class="border-0">
                                <th colspan="2" align="right" class="border-0 text-right align_right pt-0">
                                    Page Total:
                                </th>
                                <td class="text-right border-left-0" align="right" style="border-right: 0px solid transparent;">
                                    {{ number_format($opng_pg,2) }}
                                </td>
                                <td class="text-right border-left-0" align="right" style="border-right: 0px solid transparent;">
                                    {{ number_format($dr_pg,2) }}
                                </td>
                                <td class="text-right border-left-0" align="right" style="border-right: 0px solid transparent;">
                                    {{ number_format($cr_pg,2) }}
                                </td>
                                <td class="text-right border-left-0" align="right" style="border-right: 0px solid transparent;">
                                    {{ number_format($clsng_pg,2) }}
                                </td>
                            </tr>
                            </tfoot>

                        </table>

                    </div>

                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->


{{--        @include('include/footer')--}}
{{--    </div>--}}
{{--</div>--}}

@endsection

@section('scripts')
{{--    add code by shahzaib start --}}
<script type="text/javascript">
    var base = '{{ route('party_wise_opening_closing') }}',
        url;

    @include('include.print_script_sh')
</script>
{{--    add code by shahzaib end --}}

<script>
    jQuery("#cancel").click(function () {

        $("#search").val('');
    });
</script>
@endsection
{{--@include('include/script')--}}

{{--</body>--}}
{{--</html>--}}
