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

{{--<div class="main-container">--}}
{{--    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">--}}
{{--        @include('inc._messages')--}}
@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Product Wise Aging</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="search_form m-0 p-0 {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : '' }}">

                    <form class="highlight prnt_lst_frm" action="{{ route('aging_report_product_wise') }}" name="form1" id="form1" method="post" autocomplete="off">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                           autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($products as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_to)){?> value="{{$search_to}}"
                                           <?php } ?> placeholder="Start Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        End Date
                                    </label>
                                    <input type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_from)){?> value="{{$search_from}}"
                                           <?php } ?> placeholder="End Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
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
                            <th scope="col" class="tbl_amnt_6">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Last Voucher #
                            </th>
                            <th scope="col" class="tbl_amnt_4">
                                Days
                            </th>
                            <th scope="col" class="tbl_txt_76">
                                Product Name
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $sr=1;
                        @endphp
                        @forelse($datas as $result)

                            <tr>
                                <th scope="row">
                                    {{$sr}}
                                </th>
                                <td>
                                    {{date('d-M-y', strtotime(str_replace('/', '-', ($result->si_day_end_date !=0) ? $result->si_day_end_date : 'No Date')))}}
                                </td>
                                <td>
                                    <a class="view" data-transcation_id="{{'SV-'.$result->si_id}}" data-toggle="modal" data-target="#myModal" style="cursor:pointer; color: #0099ff;">
                                        {{$result->si_id !=0 ? 'SV-'.$result->si_id:''}}
                                    </a>
                                </td>
                                <td>
                                    {{$result->si_day_end_date !=0 ?  ((strtotime($current_date) - strtotime($result->si_day_end_date)) / 86400):''}}
                                </td>
                                <td class="align_left text-left tbl_txt_76">
                                    {{$result->pro_title}}
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

                    </table>

                </div>

            </div> <!-- white column form ends here -->

        </div><!-- col end -->


    </div><!-- row end -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: 1250px; margin-left: -220px;">
                <div class="modal-header">
                    <h4 class="modal-title text-blue table-header">Items Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-values">
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('aging_report_product_wise') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".view").click(function () {

            var transcation_id = jQuery(this).attr("data-transcation_id");

            jQuery(".table-header").html("");
            jQuery(".table-values").html("");

            $(".modal-body").load('{{ url('/transaction_view_details_SH/') }}/' + transcation_id, function () {
                $('#myModal').modal({show: true});
            });

        });

    </script>
    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');
        });
    </script>
@stop

