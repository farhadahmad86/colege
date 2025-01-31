{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}

{{--    @include('include/head')--}}

{{--</head>--}}
{{--<body>--}}

{{--@include('include/header')--}}
{{--@include('include.sidebar_shahzaib')--}}

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
                                <h4 class="text-white get-heading-text">
                                    Product Wise Ledger
                                    <span class="pro_name"></span>
                                </h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="srch_box_opn_icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->
{{--                    <div class="search_form {{ ( !empty($search) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}">--}}
                    <div class="search_form m-0 p-0">
                                <form class="highlight prnt_lst_frm" action="{{ route('product_wise_ledger') }}" name="form1" id="form1" method="post" autocomplete="off">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>
                                                    All Column Search
                                                </label>
                                                <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                                       value="{{ isset($search) ? $search : '' }}" >
                                                <datalist id="browsers">
                                                    @foreach($product as $value)
                                                        <option value="{{$value}}">
                                                    @endforeach
                                                </datalist>
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            </div>
                                        </div> <!-- left column ends here -->
                                        <input name="product" id="product" type="hidden" value="{{$search_product}}">
                                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>
                                                    Product Code
                                                </label>
                                                <select tabindex="2" name="product_code" class="inputs_up form-control" id="product_code">
                                                    <option value="">Select Product Code</option>
                                                    {{--                                                            @foreach($products as $product)--}}
                                                    {{--                                                                <option value="{{$product->pro_code}}" {{$product->pro_code == $pro_code ? 'selected="selected"':''}}>{{$product->pro_code}}</option>--}}
                                                    {{--                                                            @endforeach--}}

                                                    @foreach($products as $product)
                                                        <option value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_p_code}}</option>
                                                    @endforeach

                                                    {{--                                                            @foreach ($products as $product)--}}
                                                    {{--                                                                <option value="{{$product->pro_code}}" data-parent="{{$product->pro_p_code}}" {{$product->pro_code == $search_product ? 'selected' : ''}}>--}}
                                                    {{--                                                                    {{ $product->pro_code }}--}}
                                                    {{--                                                                </option>--}}
                                                    {{--                                                            @endforeach--}}
                                                </select>
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>
                                                    Product
                                                </label>
                                                <select tabindex="3" name="product_name" class="inputs_up form-control" id="product_name">
                                                    <option value="">Select Product</option>
                                                    {{--                                                            @foreach($products as $product)--}}
                                                    {{--                                                                <option value="{{$product->pro_code}}" {{$product->pro_code == $pro_code ? 'selected="selected"':''}}>{{$product->pro_title}}</option>--}}
                                                    {{--                                                            @endforeach--}}
                                                    @foreach($products as $product)
                                                        <option value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_title}}</option>
                                                    @endforeach
                                                    {{--                                                            @foreach ($products as $product)--}}
                                                    {{--                                                                <option value="{{$product->pro_code}}" data-parent="{{$product->pro_p_code}}" {{$product->pro_code == $search_product ? 'selected' : ''}}>--}}
                                                    {{--                                                                    {{ $product->pro_title }}--}}
                                                    {{--                                                                </option>--}}
                                                    {{--                                                            @endforeach--}}
                                                </select>
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>
                                                    Start Date
                                                </label>
                                                <input tabindex="4" type="text" name="from" id="from" class="inputs_up form-control datepicker1" value="{{isset($search_from) ? $search_from:""}}"
                                                        placeholder="Start Date"/>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>
                                                    End Date
                                                </label>
                                                <input tabindex="5" type="text" name="to" id="to" class="inputs_up form-control datepicker1" value="{{isset($search_to) ? $search_to:""}}"
                                                        placeholder="End Date"/>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12 form_controls text-right mt-4">
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
                                    ID#
                                </th>
                                <th scope="col" class="tbl_amnt_16">
                                    Product BarCode
                                </th>
                                <th scope="col" class="tbl_txt_20">
                                    Product Name
                                </th>
                                <th scope="col" class="tbl_txt_20">
                                    Product Category
                                </th>
                                <th scope="col" class="tbl_amnt_20">
                                    Product Group
                                </th>
                                <th scope="col" class="tbl_amnt_20">
                                    Product Brand
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            {{--@php--}}
                            {{--    $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';--}}
                            {{--    $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';--}}
                            {{--    $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;--}}
                            {{--    $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;--}}
                            {{--    $stck_in_pg = $stck_out_pg = $bal = 0;--}}
                            {{--    $balance=0;--}}
                            {{--    $in_out='';--}}
                            {{--@endphp--}}
                            {{--{{ count($products_details) }}--}}

                            @if ($products_details != null)
                                {{--                                @php--}}
                                {{--                                    $stck_in_pg = +$result->sm_pur_total + +$stck_in_pg;--}}
                                {{--                                    $stck_out_pg = +$result->sm_sale_total + +$stck_out_pg;--}}
                                {{--                                    $bal = +$result->sm_bal_total + +$bal;--}}
                                {{--                                @endphp--}}
                                {{--                        <tr>--}}
                                {{--                            <td class="align_center">{{$result->system_date}}</td>--}}
                                {{--                            <td class="align_center"><a class="view" data-transcation_id="{{$result->voucher_code}}" data-toggle="modal" data-target="#myModal" style="cursor:pointer;">{{$result->voucher_code}}</a></td>--}}
                                {{--                            <td class="align_left">{{$result->party_name}}</td>--}}
                                {{--                            <td class="align_left">{{$result->remarks}}</td>--}}
                                {{--                            <td class="align_right">{{$result->stock_in}}</td>--}}
                                {{--                            <td class="align_right">{{$result->stock_out}}</td>--}}
                                {{--                            @php--}}
                                {{--                            if($result->stock_out==0){--}}
                                {{--                                $balance += $result->stock_in;--}}
                                {{--                            }else{--}}
                                {{--                                $balance -= $result->stock_out;--}}
                                {{--                            }--}}

                                {{--                            if($balance<0){--}}
                                {{--                            $in_out = 'Out';--}}
                                {{--                            } else{--}}
                                {{--                            $in_out = '';--}}
                                {{--                            }--}}

                                {{--                            @endphp--}}

                                {{--                            <td class="align_right">{{abs($balance). ' ' .$in_out}}</td>--}}

                                {{--                        </tr>--}}

                                <tr>
                                    <th scope="row" class="tbl_srl_4">
                                        {{isset($products_details->pro_id)? $products_details->pro_id :''}}
                                    </th>
                                    <td class="tbl_amnt_16">
                                        {{isset($products_details->pro_p_code) ? $products_details->pro_p_code:''}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_20">
                                        {{isset($products_details->pro_title) ? $products_details->pro_title : ''}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_20">
                                        {{isset($products_details->cat_title) ? $products_details->cat_title : ''}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_20">
                                        {{isset($products_details->grp_title) ? $products_details->grp_title : ''}}
                                    </td>
                                    <td class="align_left text-left tbl_txt_20">
                                        {{isset($products_details->br_title) ? $products_details->br_title : ''}}
                                    </td>


                                </tr>
                                {{--                                @php--}}
                                {{--                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;--}}
                                {{--                                @endphp--}}
                            @else
                                <tr>
                                    <td colspan="11">
                                        <center><h3 style="color:#554F4F">No Record</h3></center>
                                    </td>
                                </tr>
                            @endif
                            </tbody>



                        </table>

                    </div>

                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th scope="col" class="tbl_srl_4">
                                    Sr#
                                </th>
                                <th scope="col" class="tbl_amnt_8">
                                    Date
                                </th>
                                <th scope="col" class="tbl_amnt_12">
                                    Invoice Type
                                </th>
                                <th scope="col" class="tbl_amnt_10">
                                    Voucher No.
                                </th>
                                <th scope="col" class="tbl_txt_27">
                                    Product Name
                                </th>
                                <th scope="col" class="tbl_amnt_13">
                                    Stock In
                                </th>
                                <th scope="col" class="tbl_amnt_13">
                                    Stock Out
                                </th>
                                <th scope="col" class="tbl_amnt_13">
                                    Balance
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                                $stck_in_pg = $stck_out_pg = $bal = 0;
                            @endphp
                            @forelse($datas as $result)
                                @php
                                    $stck_in_pg = +$result->sm_in_qty + +$stck_in_pg;
                                    $stck_out_pg = +$result->sm_out_qty + +$stck_out_pg;
                                    $bal = +$result->sm_bal_total_qty + +$bal;
                                @endphp
                                <tr>
                                    <th scope="row" class="tbl_srl_4">
                                        {{$sr}}
                                    </th>
                                    <td class="tbl_amnt_8">
                                        {{date('d-M-y', strtotime(str_replace('/', '-', $result->sm_day_end_date)))}}
                                    </td>
                                    <td class="align_left text-left tbl_amnt_12">
                                        {{ $result->sm_type }}
                                    </td>
                                    <td class="tbl_amnt_10">
                                        <a class="view" data-transcation_id="{{$result->sm_voucher_code}}" data-toggle="modal" data-target="#myModal" style="cursor:pointer; color: #0099ff;">
                                            {{$result->sm_voucher_code}}
                                        </a>
                                    </td>
                                    <td class="align_left text-left tbl_txt_27">
                                        {{$result->sm_product_name}}
                                    </td>
                                    <td align="right" class="align_right text-right tbl_amnt_13">
                                    {{ number_format($result->sm_in_qty, 2) }}
                                    <!--{{ number_format($result->sm_pur_qty, 2) }}-->
                                    </td>
                                    <td align="right" class="align_right text-right tbl_amnt_13">
                                    {{ number_format($result->sm_out_qty, 2) }}
                                    <!--{{ number_format($result->sm_sale_qty, 2) }}-->
                                    </td>
                                    <td align="right" class="align_right text-right tbl_amnt_13">
                                    {{ number_format($result->sm_bal_total_qty, 2) }}
                                    <!--{{ number_format($result->sm_bal_qty, 2) }}-->
                                    </td>

                                </tr>
                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
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
                                <th colspan="5" align="right" class="border-0 text-right align_right">
                                    Page Total:
                                </th>
                                <td class="text-right border-0" align="right">
                                    {{ number_format($stck_in_pg, 2) }}
                                </td>
                                <td class="text-right border-0" align="right">
                                    {{ number_format($stck_out_pg, 2) }}
                                </td>
                                <td class="text-right border-0" align="right">
                                    {{ number_format($bal,2) }}
                                </td>
                            </tr>
                            </tfoot>

                        </table>

                    </div>
                    <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
                    <!--'product_code'=>$pro_code-->
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

{{--        @include('include/footer')--}}
{{--    </div>--}}
{{--</div>--}}
@endsection

@section('scripts')
{{--    add code by shahzaib start --}}
<script type="text/javascript">
    var base = '{{ route('product_ledger_stock_wise') }}',
        url;

    @include('include.print_script_sh')
</script>
{{--    add code by shahzaib end --}}

<script>
    jQuery(".view").click(function () {

        var transcation_id = jQuery(this).attr("data-transcation_id");

        jQuery(".table-header").html("");
        jQuery(".table-values").html("");

        $(".modal-body").load('{{ url('/transaction_view_details_SH/') }}/'+transcation_id, function () {
            $('#myModal').modal({show:true});
        });

    });

</script>
{{--@include('include/script')--}}


<script>

    jQuery("#cancel").click(function () {

        $("#product_code").select2().val(null).trigger("change");
        $("#product_code > option").removeAttr('selected');


        $("#product_name").select2().val(null).trigger("change");
        $("#product_name > option").removeAttr('selected');

        $("#product_code").select2();
        $("#product_name").select2();

        $("#search").val('');
        $("#to").val('');
        $("#from").val('');
    });


    jQuery(document).ready(function () {
        // Initialize select2
        jQuery("#product_code").select2();
        jQuery("#product_name").select2();


        setTimeout(function () {

            var product_name = jQuery("#product_name option:selected").text();

            jQuery(".pro_name").html("");

            jQuery(".pro_name").append('Product: ' + product_name);

        }, 500);

    });
</script>
<script>
    jQuery("#product_name").change(function () {
        var pcode = jQuery('option:selected', this).val();

        jQuery("#product_code").select2("destroy");

        // jQuery("#product > option").each(function () {
        //     jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
        // });

        jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);
        jQuery("#product_code").select2();
        assign_product_parent_value();
    });


    jQuery("#product_code").change(function () {
        var pcode = jQuery('option:selected', this).val();

        jQuery("#product_name").select2("destroy");

        // jQuery("#product_name > option").each(function () {
        jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);
        // });

        jQuery("#product_name").select2();
        assign_product_parent_value();
    });


</script>
@endsection
{{--</body>--}}
{{--</html>--}}
