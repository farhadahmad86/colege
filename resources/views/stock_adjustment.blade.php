@extends('extend_index')

@section('content')

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Stock Adjustment</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_product) || !empty($search_from) || !empty($search_to) ) ? '' : 'search_form_hidden' }}">
-->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                            <form class="prnt_lst_frm" action="{{ route('stock_adjustment') }}" name="form1" id="form1"
                                  method="post">
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
                                                @foreach($product as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Code
                                                    </label>
                                                    <select tabindex="3" class="inputs_up form-control" name="product" id="product">
                                                        <option value="">Select Code</option>
                                                        @foreach($products as $product)
                                                            <option
                                                                value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_p_code}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Product
                                                    </label>
                                                    <select tabindex="4" class="inputs_up  form-control" name="product_name" id="product_name">
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : ''
                                                                }}>{{$product->pro_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Start Date
                                                    </label>
                                                    <input tabindex="5" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        End Date
                                                    </label>
                                                    <input tabindex="6" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form_controls text-center">

                                            <button tabindex="7" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                <i class="fa fa-trash"></i> Clear
                                            </button>
                                            <button tabindex="8" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                <i class="fa fa-search"></i> Search
                                            </button>

                                            <a tabindex="9" class="save_button form-control" href="{{ route('stock_taking_list') }}" role="button">
                                                <i class="fa fa-plus"></i> Stock Adjustment List
                                            </a>

                                            @include('include/print_button')

                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                        </div>
                                    </div>

                                </div>

                            </form>


                        </div>

                    </div>
                </div><!-- search form end -->

                <form name="f1" class="f1" id="f1" action="{{ route('submit_stock_adjustment') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="table-responsive" id="printTable">
                        <table class="table table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                    SR#
                                </th>
                                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                    Product Barcode
                                </th>

                                <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                    Product Title
                                </th>

                                <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                    Current Stock
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                    Physical Stock
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                    Difference
                                </th>

                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                                $prchsPrc = $slePrc = $avrgPrc = 0;
                            @endphp

                            @forelse($datas as $product)

                                <tr data-product_id="{{$product->st_id}}">

                                    <td class="align_center text-center edit tbl_srl_4">
                                        {{$sr}}

                                    </td>

                                    <td class="align_center text-center edit tbl_amnt_10">
                                        <input type="hidden" name="product_code[]" class="inputs_up form-control" id="product_code{{$product->st_product_code}}"
                                               value="{{$product->st_product_code}}" readonly/>
                                        {{$product->st_product_code}}
                                    </td>

                                    <td class="align_left text-left edit tbl_txt_10">
                                        <input type="hidden" name="product_name[]" class="inputs_up form-control" id="product_name{{$product->st_product_code}}"
                                               value="{{$product->st_product_name}}" readonly/>
                                        {{$product->st_product_name}}
                                    </td>
                                    <td class="align_center text-center edit tbl_amnt_4">
                                        <input type="hidden" name="current_stock[]" class="inputs_up form-control" id="current_stock" value="{{$product->st_current_stock}}"
                                               placeholder="Bonus"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                        {{$product->st_current_stock}}
                                    </td>
                                    <td class="align_center text-center edit tbl_amnt_4">
                                        <input type="hidden" name="physical[]" class="inputs_up form-control" id="physical"
                                               placeholder="Physical" value="{{$product->st_physical_qty}}"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                        {{$product->st_physical_qty}}
                                    </td>
                                    @php
                                        $difference = $product->st_current_stock - $product->st_physical_qty;
                                    @endphp
                                    <td class="align_center text-center edit tbl_amnt_4">
                                        <input type="hidden" name="difference[]" class="inputs_up form-control" id="difference" value="{{$difference}}"
                                               placeholder="Bonus"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                        {{$difference}}
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


                        </table>

                    </div>
                    {{--                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">--}}
                    <div class="col-lg-2 col-md-2">
                        <button type="submit" name="save" id="save" class="save_button form-control">
                            <i class="fa fa-floppy-o"></i> SAVE
                        </button>

                        <span id="validate_msg" class="validate_sign"></span>
                        {{--                                    <input type="hidden" name="title" id="title" value="{{$title}}">--}}
                    </div>
                </form>
                {{--                <span--}}
                {{--                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'product'=>$search_product, 'unit'=>$search_unit, 'group'=>$search_group,
                'category'=>$search_category ]) }}</span>--}}
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('stock_adjustment') }}',
            url;

        @include('include.print_script_sh')
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#product").select2().val(null).trigger("change");
            $("#product > option").removeAttr('selected');

            $("#product_name").select2().val(null).trigger("change");
            $("#product_name > option").removeAttr('selected');

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');
        });
    </script>

    <script>
        jQuery("#product_name").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product").select2("destroy");

            // jQuery("#product > option").each(function () {
            //     jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
            jQuery("#product").select2();

        });


        jQuery("#product").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_name").select2("destroy");

            // jQuery("#product_name > option").each(function () {
            jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery("#product_name").select2();

        });


    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product").select2();
            jQuery("#product_name").select2();
        });
    </script>

@endsection

