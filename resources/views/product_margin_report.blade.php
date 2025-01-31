<!DOCTYPE html>
<html>
<head>

    @include('include/head')

</head>
<body>

@include('include/header')
@include('include.sidebar_shahzaib')

<div class="main-container">
    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">
        @include('inc._messages')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">
                                    Product Margin Report
                                    {{--                                    <span class="pro_name"></span>--}}
                                </h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="srch_box_opn_icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->

                    {{--                                        <div class="search_form {{ ( !empty($search) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}">--}}
                    <div class="search_form m-0 p-0">
                            <form class="highlight prnt_lst_frm" action="{{ route('product_margin_report') }}" name="form1" id="form1" method="post" autocomplete="off">
                                @csrf
                                <div class="row">

                                    {{--                                                <input tabindex="2" name="product" id="product" type="hidden" value="{{$search_product}}">--}}

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Financial Date
                                            </label>
                                            <input tabindex="5" type="text" name="from" id="from" class="inputs_up form-control datepicker1"
                                                   value="{{isset($search_from) ? $search_from:""}}"
                                                   placeholder="Date"/>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Product Code
                                            </label>
                                            <select tabindex="3" name="product_code" class="inputs_up form-control" id="product_code">
                                                <option value="">Select Product Code</option>
                                                @foreach($products as $product)
                                                    <option
                                                        value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_p_code}}</option>
                                                @endforeach

                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Product
                                            </label>
                                            <select tabindex="4" name="product_name" class="inputs_up form-control" id="product_name">
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option
                                                        value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_title}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                    @include('include.clear_search_button')
                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                    </div>

                                        {{--                                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">--}}
                                        {{--                                                    <div class="input_bx"><!-- start input box -->--}}
                                        {{--                                                        <label>--}}
                                        {{--                                                            End Date--}}
                                        {{--                                                        </label>--}}
                                        {{--                                                        <input tabindex="6" type="text" name="to" id="to" class="inputs_up form-control datepicker1" value="{{isset($search_to) ? $search_to:""}}"--}}
                                        {{--                                                               placeholder="End Date"/>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </div>--}}


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
                                    <th scope="col" class="tbl_amnt_8">
                                        Date
                                    </th>
                                    <th scope="col" class="tbl_amnt_12">
                                        Product Code
                                    </th>
                                    <th scope="col" class="tbl_txt_15">
                                        Product Name
                                    </th>
                                    <th scope="col" class="tbl_amnt_9">
                                        Sale QTY
                                    </th>
                                    <th scope="col" class="tbl_amnt_13">
                                        Sale Amount
                                    </th>
                                    <th scope="col" class="tbl_amnt_9">
                                        Average Unit Rate
                                    </th>
                                    <th scope="col" class="tbl_amnt_13">
                                        Average Cost
                                    </th>
                                    <th scope="col" class="tbl_amnt_10">
                                        Average Margin
                                    </th>
                                    <th scope="col" class="tbl_amnt_10">
                                        Average Margin Per Unit
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @php
                                    $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                    $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                    $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                    $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                                    $ttl_sale_qty = $ttl_sale_amount = $ttl_avg_rate = $ttl_avg_cost = $ttl_avg_margin = $ttl_margin_unit = 0;
                                @endphp
                                @forelse($datas as $index=>$result)
                                    @php
                                        $avg_cost= $sale_qty[$index] * $result->sm_bal_rate;
                                        $avg_margin= $sale_amount[$index] - $avg_cost;
                                        $avg_mar_per_unit= $avg_margin / $sale_qty[$index];

                                    $ttl_sale_qty= $ttl_sale_qty + $sale_qty[$index];
                                    $ttl_sale_amount= $ttl_sale_amount + $sale_amount[$index];
                                    $ttl_avg_rate= $ttl_avg_rate + $result->sm_bal_rate;
                                    $ttl_avg_cost= $ttl_avg_cost + $avg_cost;
                                    $ttl_avg_margin= $ttl_avg_margin + $avg_margin;
                                    $ttl_margin_unit= $ttl_margin_unit + $avg_mar_per_unit;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            {{$sr}}
                                        </th>

                                        <td>
                                            {{date('d-M-y', strtotime(str_replace('/', '-', $result->sm_day_end_date)))}}
                                        </td>
                                        <td>
                                            {{ $result->sm_product_code }}
                                        </td>

                                        <td>
                                            {{$result->sm_product_name}}
                                        </td>
                                        <td class="align_right text-right">
                                            {{$sale_qty[$index]!=0 ? number_format($sale_qty[$index],2):''}}
                                        </td>
                                        <td class="align_right text-right">
                                            {{$sale_amount[$index]!=0 ? number_format($sale_amount[$index],2):''}}
                                        </td>
                                        <td class="align_right text-right">
                                            {{ number_format($result->sm_bal_rate,2)}}
                                        </td>

                                        <td align="right" class="align_right text-right">
                                            {{ number_format($avg_cost, 2) }}
                                        </td>
                                        <td align="right" class="align_right text-right">
                                            {{ number_format($avg_margin, 2) }}

                                        </td>
                                        <td align="right" class="align_right text-right">
                                            {{ number_format($avg_mar_per_unit, 2) }}

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
                                    <th colspan="4" align="right" class="border-0 text-right align_right">
                                        Page Total:
                                    </th>
                                    <td class="text-right border-0" align="right">
                                        {{ number_format($ttl_sale_qty, 2) }}
                                    </td>
                                    <td class="text-right border-0" align="right">
                                        {{ number_format($ttl_sale_amount, 2) }}
                                    </td>
                                    <td class="text-right border-0" align="right">
                                        {{ number_format($ttl_avg_rate,2) }}
                                    </td>
                                    <td class="text-right border-0" align="right">
                                        {{ number_format($ttl_avg_cost,2) }}
                                    </td>
                                    <td class="text-right border-0" align="right">
                                        {{ number_format($ttl_avg_margin,2) }}
                                    </td>
                                    <td class="text-right border-0" align="right">
                                        {{ number_format($ttl_margin_unit,2) }}
                                    </td>
                                </tr>
                                </tfoot>

                            </table>

                        </div>
                        <span
                            class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'from'=>$search_from, 'product_code'=>$search_product])->links()
                        }}</span>
                    {{--                    , 'product_name'=>$search_product_name,--}}
                    {{--                    'to'=>$search_to,--}}
                    {{--                    'search'=>$search,--}}
                    <!--'product_code'=>$pro_code-->
                    </div> <!-- white column form ends here -->


                </div><!-- col end -->


            </div><!-- row end -->


            @include('include/footer')
        </div>
    </div>

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('product_margin_report') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


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

    @include('include/script')


    <script>

        // jQuery("#pro_code").change(function () {
        //
        //     jQuery("#form1").submit();
        // });

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

{{--<script>--}}
{{--    jQuery("#product_name").change(function () {--}}
{{--        var pcode = jQuery('option:selected', this).val();--}}

{{--        jQuery("#product_code").select2("destroy");--}}
{{--        jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);--}}
{{--        jQuery("#product_code").select2();--}}

{{--        assign_product_parent_value();--}}
{{--    });--}}

{{--    jQuery("#product_code").change(function () {--}}
{{--        var pcode = jQuery('option:selected', this).val();--}}

{{--        jQuery("#product_name").select2("destroy");--}}
{{--        jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);--}}
{{--        jQuery("#product_name").select2();--}}

{{--        assign_product_parent_value();--}}
{{--    });--}}


{{--</script>--}}

</body>
</html>
