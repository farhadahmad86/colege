@extends('extend_index')

@section('content')
    <style>
        .table thead th {
            background-color: rgb(222 222 222);
            color: #000;
        }
    </style>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Stock Activity Report</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                {{--                <!-- <div class="search_form {{ ( !empty($search) || !empty($search_main_unit) || !empty($search_unit) || !empty($search_group) || !empty($search_category) ) ? '' : 'search_form_hidden' }}"> -->--}}

                <div class="search_form m-0 p-0 ">
                    <form class="highlight prnt_lst_frm" action="{{ route('stock_activity_report') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1"
                          method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($products as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div> <!-- left column ends here -->
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Main Unit
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="main_unit" id="main_unit">
                                        <option value="">Select Main Unit</option>
                                        @foreach($main_units as $main_unit)
                                            <option
                                                value="{{$main_unit->mu_id}}" {{ $main_unit->mu_id == $search_main_unit ? 'selected="selected"' : '' }}>{{$main_unit->mu_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Unit
                                    </label>
                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="unit" id="unit">
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{$unit->unit_id}}" {{ $unit->unit_id == $search_unit ? 'selected="selected"' : '' }}>{{$unit->unit_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Group
                                    </label>
                                    <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="group" id="group">
                                        <option value="">Select Group</option>
                                        @foreach($groups as $group)
                                            <option value="{{$group->grp_id}}" {{ $group->grp_id == $search_group ? 'selected="selected"' : '' }}>{{$group->grp_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Category
                                    </label>
                                    <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="category" id="category">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option
                                                value="{{$category->cat_id}}" {{ $category->cat_id == $search_category ? 'selected="selected"' : '' }}>{{$category->cat_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Product Group
                                    </label>
                                    <select tabindex="6" class="inputs_up form-control cstm_clm_srch" name="product_group" id="product_group">
                                        <option value="">Select Product Group</option>
                                        @foreach($product_groups as $product_group)
                                            <option
                                                value="{{$product_group->pg_id}}" {{ $product_group->pg_id == $search_product_group ? 'selected="selected"' : '' }}>{{$product_group->pg_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input tabindex="5" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        End Date
                                    </label>
                                    <input tabindex="6" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
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
                                SR #
                            </th>

                            <th scope="col" class="tbl_txt_10">
                                Product Title
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Opening Stock
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                QTY In
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Bonus In
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Total In Stock
                            </th>

                            <th scope="col" class="tbl_amnt_6">
                                QTY Out
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Bonus Out
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Total Out Stock
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Closing Stock
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Last Purchase Rate
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Current Average Rate
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Value Last Purchase Rate
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Value Average Rate
                            </th>

                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $prchsPrc = $avrgPrc = $ttlOpStock = $ttlQtyIn = $ttlQtyBonIn = $ttlStockIn = $ttlQtyOut = $ttlQtyBonOut = $ttlStockOut =$ttlClosingStock = $ttlValPurchase = $ttlValAvg
                            = 0;
                        @endphp
                        @forelse($datas as $product)
                            @php
                                $total_in_stock=0;
                                        $total_in_stock=$product->in_qty + $product->in_bonus_qty;

                                    $total_out_stock=0;
                                            $total_out_stock=$product->out_qty + $product->out_bonus_qty;
                                            $closing_stock=($total_in_stock + $product->opening_stock)-$total_out_stock;

                                        $value_last_purchase_rate=0;
                                            $value_average_rate =0;
                                            $value_last_purchase=$closing_stock * $product->pro_last_purchase_rate;
                                            $value_average_rate=$closing_stock * $product->pro_average_rate;

                            $ttlOpStock += $product->opening_stock; $ttlQtyIn += $product->in_qty; $ttlQtyBonIn += $product->in_bonus_qty; $ttlStockIn += $total_in_stock; $ttlQtyOut += $product->out_qty;
                            $ttlQtyBonOut += $product->out_bonus_qty; $ttlStockOut
                            += $total_out_stock; $ttlClosingStock += $closing_stock; $ttlValPurchase += $value_last_purchase; $ttlValAvg += $value_average_rate;
                            @endphp
                            <tr>

                                <th scope="row">
                                    {{$sr}}
                                </th>
                                {{--                                <td class=0">--}}
                                {{--                                    {{$product->pro_p_code}}--}}
                                {{--                                </td>--}}
                                <td>
                                    {{$product->pro_title}}
                                </td>
                                <td>
                                    {{number_format($product->opening_stock,2)}}
                                </td>
                                <td>
                                    {{$product->in_qty}}
                                </td>
                                <td>
                                    {{$product->in_bonus_qty}}
                                </td>

                                <td>
                                    {{number_format($total_in_stock,2)}}
                                </td>
                                <td>
                                    {{$product->out_qty}}
                                </td>
                                <td>
                                    {{$product->out_bonus_qty}}
                                </td>
                                <td>
                                    {{number_format($total_out_stock,2)}}
                                </td>
                                <td>
                                    {{number_format($closing_stock,2)}}
                                </td>
                                <td class="align_right text-right">
                                    {{number_format($product->pro_last_purchase_rate,2)}}
                                </td>

                                <td class="align_right text-right">
                                    {{number_format($product->pro_average_rate,2)}}
                                </td>

                                <td class="align_right text-right">
                                    {{number_format($value_last_purchase,2)}}
                                </td>
                                <td class="align_right text-right">
                                    {{number_format($value_average_rate,2)}}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Product</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr>
                            <th align="right" colspan="2" class="align_right text-right border-0">
                                Page Total:-
                            </th>
                            <td align="center" class="border-0">
                                {{ number_format($ttlOpStock,2) }}
                            </td>
                            <td align="center" class="border-0">
                                {{ number_format($ttlQtyIn,2) }}
                            </td>
                            <td align="center" class="border-0">
                                {{ number_format($ttlQtyBonIn,2) }}
                            </td>
                            <td align="center" class="border-0">
                                {{ number_format($ttlStockIn,2) }}
                            </td>
                            <td align="center" class="border-0">
                                {{ number_format($ttlQtyOut,2) }}
                            </td>
                            <td align="center" class="border-0">
                                {{ number_format($ttlQtyBonOut,2) }}
                            </td>
                            <td align="center" class="border-0">
                                {{ number_format($ttlStockOut,2) }}
                            </td>
                            <td align="center" class="border-0">
                                {{ number_format($ttlClosingStock,2) }}
                            </td>
                            <td align="right" class="align_right text-right border-0">
                                {{--                                {{ number_format($ttlQtyOut,2) }}--}}
                            </td>
                            <td align="right" class="align_right text-right border-0">
                                {{--                                {{ number_format($ttlValPurchase,2) }}--}}
                            </td>
                            <td align="right" class="align_right text-right border-0">
                                {{ number_format($ttlValPurchase,2) }}
                            </td>
                            <td align="right" class="align_right text-right border-0">
                                {{ number_format($ttlValAvg,2) }}
                            </td>
                        </tr>
                        </tfoot>

                    </table>

                </div>

                {{--                nabeel panga--}}
                {{--                <div class="row mb-4 mr-4">--}}

                {{--                    <div class="col-md-1" style="margin-top: 17px">--}}
                {{--                        <div class="float-right">--}}
                {{--                            <a href="{{url('/stock_activity_report')}}" class="btn btn-primary">View All</a>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}


                {{--                <span--}}
                {{--                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'main_unit'=>$search_main_unit, 'unit'=>$search_unit, 'group'=>$search_group, 'category'=>$search_category ])->links() }}</span>--}}
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    <script src="{{ asset('public/plugins/nabeel_blue/jquery.floatThead.js') }}"></script>

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('stock_activity_report') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    {{--    add code by mustafa start --}}
    <script>

        $(document).ready(function () {

            $('table').floatThead({
                position: 'absolute'
            });
        });
    </script>
    <script>
        jQuery("#cancel").click(function () {

            $("#main_unit").select2().val(null).trigger("change");
            $("#main_unit > option").removeAttr('selected');

            $("#unit").select2().val(null).trigger("change");
            $("#unit > option").removeAttr('selected');

            $("#group").select2().val(null).trigger("change");
            $("#group > option").removeAttr('selected');

            $("#category").select2().val(null).trigger("change");
            $("#category > option").removeAttr('selected');

            $("#product_group").select2().val(null).trigger("change");
            $("#product_group > option").removeAttr('selected');

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#main_unit").select2();
            jQuery("#unit").select2();
            jQuery("#group").select2();
            jQuery("#category").select2();
            jQuery("#product_group").select2();
        });
    </script>

@endsection

