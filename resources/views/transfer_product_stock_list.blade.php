@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Transfer Product Stock List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_product) || !empty($search_warehouse)  ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('transfer_product_stock_list') }}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-4 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($product_title as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-10 col-md-8 col-sm-12 col-xs-12 srch_brdr_left">
                                <div class="row">

                                    <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Select Product
                                            </label>
                                            <select tabindex="2" class="inputs_up form-control" name="product" id="product">
                                                <option value="">Select Code</option>
                                                @foreach($products as $product)
                                                    <option
                                                        value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_p_code}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Select Product
                                            </label>
                                            <select tabindex="3" class="inputs_up form-control" name="product_name" id="product_name">
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_title}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Select Warehouse
                                            </label>
                                            <select tabindex="4" class="inputs_up form-control" name="warehouse" id="warehouse">
                                                <option value="0">Select Warehouse</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option value="{{$warehouse->wh_id}}" {{ $warehouse->wh_id == $search_product ? 'selected="selected"' : '' }}>{{$warehouse->wh_title}}</option>
                                                @endforeach
                                                {{--                                                            <option value="">Select Product</option>--}}
                                                {{--                                                            --}}
                                                {{--                                                            @foreach($warehouses as $warehouse)--}}
                                                {{--                                                                <option value="{{$warehouse->pro_p_code}}" {{ $warehouse->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$warehouse->pro_title}}</option>--}}
                                                {{--                                                            @endforeach--}}
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">

                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('add_transfer_product_stock') }}"/>

                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Product Code</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Transfer To</th>
                            <th scope="col">Transfer From</th>
                            <th scope="col">Remarks</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $ttlPrc = $cashPaid = 0;
                        @endphp
                        @forelse($datas as $product)

                            <tr>
                                <td>{{$product->pth_datetime}}</td>
                                <td>{{$product->pro_p_code}}</td>
                                <td>{{$product->pro_title}}</td>
                                <td class="align_right">{{$product->pth_stock}}</td>
                                <td>{{$product->to}}</td>
                                <td>{{$product->from}}</td>
                                <td>{{$product->pth_remarks}}</td>
                            </tr>
                            @php
                                $sr++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Product</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'product'=>$search_product, 'warehouse'=>$search_warehouse ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')
    <script type="text/javascript">
        var base = '{{ route('transfer_product_stock_list') }}',
            url;

        @include('include.print_script_sh')
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#product").select2().val(null).trigger("change");
            $("#product > option").removeAttr('selected');


            $("#warehouse").select2().val(null).trigger("change");
            $("#warehouse > option").removeAttr('selected');

            $("#search").val('');

        });
    </script>

    <script>

        jQuery("#product").change(function () {

            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_name").select2("destroy");

            // jQuery("#product_name > option").each(function () {
            jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery("#product_name").select2();
        });

        jQuery("#product_name").change(function () {

            var pcode = jQuery('option:selected', this).val();

            jQuery("#product").select2("destroy");

            // jQuery("#product > option").each(function () {
            jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery("#product").select2();
        });

    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product").select2();
            jQuery("#product_name").select2();
            jQuery("#warehouse").select2();
        });
    </script>


@endsection

