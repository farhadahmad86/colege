@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Update Product Price</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                {{--                <div--}}
                {{--                        class="search_form {{ ( !empty($search) || !empty($search_group) || !empty($search_category) || !empty($search_product_reporting_group) || !empty($search_main_unit) || !empty($search_unit) ) ? '' : 'search_form_hidden' }}">--}}

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('product_price_update') }}" name="form1" id="form1" method="post" autocomplete="off">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}">
                                    <datalist id="browsers">
                                        @foreach($product_names as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Group
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control" name="group" id="group">
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
                                    <select tabindex="3" class="inputs_up form-control" name="category" id="category">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->cat_id}}" {{ $category->cat_id == $search_category ? 'selected="selected"' : '' }}>{{$category->cat_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Product Reporting Group
                                    </label>
                                    <select tabindex="4" class="inputs_up form-control" name="product_reporting_group" id="product_reporting_group">
                                        <option value="">Select Product Reporting Group</option>
                                        @foreach($product_reporting_groups as $product_reporting_group)
                                            <option value="{{$product_reporting_group->pg_id}}"
                                                {{ $product_reporting_group->pg_id == $search_product_reporting_group ? 'selected="selected"' :''}}>
                                                {{$product_reporting_group->pg_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Main Unit
                                    </label>
                                    <select tabindex="5" class="inputs_up form-control" name="main_unit" id="main_unit">
                                        <option value="">Select Main Unit</option>
                                        @foreach($main_units as $main_unit)
                                            <option value="{{$main_unit->mu_id}}" {{ $main_unit->mu_id == $search_main_unit ? 'selected="selected"' : '' }}>{{$main_unit->mu_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Unit
                                    </label>
                                    <select tabindex="6" class="inputs_up form-control" name="unit" id="unit">
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{$unit->unit_id}}" {{ $unit->unit_id == $search_unit ? 'selected="selected"' : '' }}>{{$unit->unit_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 form_controls text-right">
                                @include('include.clear_search_button')
                                @include('include/print_button')
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>

                        </div>
                    </form>
                </div><!-- search form end -->


                <form name="f1" class="f1" id="f1" action="{{ route('update_product_price') }}" onsubmit="return form_validation()" method="post" autocomplete="off">
                    @csrf

                    <div class="table-responsive" id="parent">
                        <table class="table table-bordered table-sm" id="fixTable">

                            <thead>
                            <tr>
                                <th nowrap="" scope="col" class="tbl_srl_4">
                                    Sr#
                                </th>
                                <th nowrap="" scope="col" class="tbl_srl_4">
                                    ID
                                </th>
                                <th scope="col" class="tbl_amnt_13">
                                    Group
                                </th>
                                <th scope="col" class="tbl_amnt_13">
                                    Category
                                </th>
                                <th nowrap="" scope="col" class="tbl_amnt_13">
                                    Product Code
                                </th>
                                <th nowrap="" scope="col" class="tbl_txt_23">
                                    Product Title
                                </th>
                                <th nowrap="" scope="col" class="tbl_amnt_11">
                                    Purchase Price
                                </th>
                                <th nowrap="" scope="col" class="tbl_amnt_11">
                                    Bottom Price
                                </th>
                                <th nowrap="" scope="col" class="tbl_amnt_13">
                                    Sale Price
                                </th>
                                {{--<th nowrap="" scope="col" class="tbl_amnt_13">--}}
                                {{--    Qty--}}
                                {{--</th>--}}
                                <th scope="col" class="tbl_txt_8">
                                    Created By
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            @endphp

                            @forelse($datas as $index=> $product)

                                <tr>
                                    <th scope="row" class="tbl_srl_4">
                                        {{$sr}}
                                    </th>
                                    <td class="tbl_srl_4">
                                        {{$product->grp_id}}
                                    </td>
                                    <td class="tbl_amnt_13">
                                        {{$product->grp_title}}
                                    </td>
                                    <td class="tbl_amnt_11">
                                        {{$product->cat_title}}
                                    </td>
                                    <td nowrap="" class="tbl_amnt_11">
                                        {{$product->pro_p_code}}
                                    </td>
                                    <td nowrap="" class="tbl_txt_23">
                                        {{$product->pro_title}}
                                    </td>
                                    <td nowrap="" class="tbl_amnt_13">
                                        <span id="p{{$index}}" class="validate_sign"> </span>
                                        <input type="text" class="form-control w-100 border-radius-0 border-0 text-right" value="{{old('p_rate.'.$index, $product->pro_purchase_price)}}"
                                               name="p_rate[]"
                                               id="p_rate{{$index}}" data-id="{{$index}}" onkeypress="return allow_only_number_and_decimals(this,event);" onfocus="this.select();">

                                        <input type="hidden" name="id[]" class="form-control" value="{{$product->pro_p_code}}"/>
                                    </td>
                                    <td nowrap="" class="tbl_amnt_13">
                                        <span id="b{{$index}}" class="validate_sign"> </span>
                                        <input type="text" class="form-control w-100 border-radius-0 border-0 text-right" value="{{old('b_rate.'.$index, $product->pro_bottom_price)}}" name="b_rate[]"
                                               id="b_rate{{$index}}" data-id="{{$index}}" onkeypress="return allow_only_number_and_decimals(this,event);" onfocus="this.select();">
                                    </td>
                                    <td nowrap="" class="tbl_amnt_13">
                                        <span id="s{{$index}}" class="validate_sign"> </span>
                                        <input type="text" class="form-control w-100 border-radius-0 border-0 text-right" value="{{old('s_rate.'.$index, $product->pro_sale_price)}}" name="s_rate[]"
                                               id="s_rate{{$index}}" data-id="{{$index}}" onkeypress="return allow_only_number_and_decimals(this,event);" onfocus="this.select();">
                                    </td>

                                    {{--                                    <td nowrap="" class="tbl_amnt_13">--}}
                                    {{--                                        <span id="q{{$index}}" class="validate_sign"> </span>--}}
                                    {{--                                        <input type="text" class="form-control w-100 border-radius-0 border-0 text-right" value="{{old('quantity.'.$index, $product->pro_quantity)}}" name="quantity[]"--}}
                                    {{--                                               id="quantity{{$index}}" data-id="{{$index}}" onkeypress="return allow_only_number_and_decimals(this,event);" onfocus="this.select();">--}}
                                    {{--                                    </td>--}}

                                    @php
                                        $ip_browser_info= ''.$product->pro_ip_adrs.','.str_replace(' ','-',$product->pro_brwsr_info).'';
                                    @endphp

                                    <td class="usr_prfl tbl_txt_8" data-usr_prfl="{{ $product->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                        title="Click To See User Detail">
                                        {{ $product->user_name }}
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
                    <div class="row">
                        <div class="col-md-3">
                            <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                        </div>
                        <div class="col-md-9 text-right">

                    <span
                        style="float: right">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'group'=>$search_group, 'category'=>$search_category, 'product_reporting_group'=>$search_product_reporting_group, 'main_unit'=>$search_main_unit, 'unit'=>$search_unit ])->links() }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12 text-right">
                            <button type="submit" name="save" id="save" class="save_button btn btn-sm btn-info" onclick="return form_validation()">
                                Update Rates
                            </button>
                            {{--<a href="{{route('view_product_opening_stock')}}" class="save_button btn btn-sm btn-success">--}}
                            {{--    Continue To Process--}}
                            {{--</a>--}}
                            <span id="validate_msg" class="validate_sign"></span>
                        </div>
                    </div>


                </form>

            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('product_price_update') }}',
            url;

        @include('include.print_script_sh')

        {{--    add code by shahzaib end --}}

        jQuery("#group").select2();
        jQuery("#category").select2();
        jQuery("#product_group").select2();
        jQuery("#main_unit").select2();
        jQuery("#unit").select2();
        jQuery("#product_reporting_group").select2();
    </script>

@endsection

