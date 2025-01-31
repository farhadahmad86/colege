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
                            <h4 class="text-white get-heading-text file_name">Warehouse Stock Report</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('warehouse_stock') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1"
                          method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($warehousess as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div> <!-- left column ends here -->
                            <div class="form-group col-lg-2 col-md-3 col-sm-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Warehouse
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="warehouse" id="warehouse" autofocus>
                                        <option value="">Select Warehouse</option>
                                        @foreach($warehouses as $warehouse)

                                            <option value="{{$warehouse->wh_id}}" {{$warehouse->wh_id == $search_warehouse ?
                                                                                                            'selected="selected"':''}}>{{$warehouse->wh_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Products
                                    </label>
                                    <select name="pro_name" tabindex="3" class="inputs_up form-control cstm_clm_srch" id="pro_name" autofocus>--}}
                                        <option value="">All Product</option>
                                        @foreach($products as $product)
                                            <option
                                                value="{{$product->pro_p_code}}" {{$product->pro_p_code == $search_pro_code ?
                                                        'selected="selected"':''}}>{{$product->pro_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12 mt-4 text-right">
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
                            <th scope="col" class="tbl_txt_25">
                                Product Title
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Warehouse
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Stock
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Average Rate
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Stock Value
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
                            = $total_stock_value
                            = 0;
                        @endphp
                        @forelse($datas as $result)
                            <tr>

                                <th scope="row">
                                    {{$sr}}
                                </th>
                                <td>
                                    {{$result->pro_title}}
                                </td>
                                <td>
                                    {{$result->wh_title}}
                                </td>
                                <td>
                                    {{$result->whs_stock}}
                                </td>
                                <td>
                                    {{$result->pro_average_rate}}
                                </td>
                                <td class="text-right">
                                    @php
                                        $total_stock_value = $total_stock_value + ($result->whs_stock * $result->pro_average_rate)
                                    @endphp
                                    {{number_format($result->whs_stock * $result->pro_average_rate,2)}}
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
                        <th colspan="5" class="text-right">Total Stock Value:</th>
                        <th class="text-right">{{number_format($total_stock_value,2)}}</th>
                        </tfoot>
                    </table>
                </div>

                {{--                nabeel panga--}}
                {{--                <div class="row mb-4 mr-4">--}}

                {{--                    <div class="col-md-1" style="margin-top: 17px">--}}
                {{--                        <div class="float-right">--}}
                {{--                            <a href="{{url('/warehouse_stock')}}" class="btn btn-primary">View All</a>--}}
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
        var base = '{{ route('warehouse_stock') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    {{--    add code by mustafa start --}}
    <script>

        $(document).ready(function () {

            $('table.table').floatThead()

            $('.table').floatThead({
                position: 'absolute'
            });
        });
    </script>
    <script>
        jQuery("#cancel").click(function () {

            $("#pro_name").select2().val(null).trigger("change");
            $("#pro_name > option").removeAttr('selected');

            $("#pro_code").select2().val(null).trigger("change");
            $("#pro_code > option").removeAttr('selected');

            $("#warehouse").select2().val(null).trigger("change");
            $("#warehouse > option").removeAttr('selected');

            $("#search").val('');

        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#warehouse").select2();

            jQuery("#pro_code").select2();
            jQuery("#pro_name").select2();
        });
    </script>

@endsection



