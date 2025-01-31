@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Stock Taking Industrial</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_main_unit) || !empty($search_unit) || !empty($search_group) || !empty($search_category) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                            <form class="prnt_lst_frm" action="{{ route('stock_taking_industrial') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1"
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
                                                        Warehouse
                                                    </label>
                                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="warehouse" id="warehouse">
                                                        <option value="">Select Warehouse</option>
                                                        @foreach($warehouses as $warehouse)
                                                            <option
                                                                value="{{$warehouse->wh_id}}" {{ $warehouse->wh_id == $search_warehouse ? 'selected="selected"' : ''
                                                                }}>{{$warehouse->wh_title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
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

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
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

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
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

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
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


                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
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
                                                <i class="fa fa-plus"></i> Stock Taking List
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

                <form name="f1" class="f1" id="f1" action="{{ route('submit_stock_taking_industrial') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12" hidden>
                        <div class="input_bx"><!-- start input box -->
                            <label>
                                Warehouse2
                            </label>
                            <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="warehouse" id="warehouse2">
                                <option value="">Select Warehouse2</option>
                                @foreach($warehouses as $warehouse)
                                    <option
                                        value="{{$warehouse->wh_id}}" {{ $warehouse->wh_id == $search_warehouse ? 'selected="selected"' : ''
                                                                }}>{{$warehouse->wh_title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
                                    Physical Stock
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                    Bonus
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

                                <tr data-product_id="{{$product->pro_id}}">

                                    <td class="align_center text-center edit tbl_srl_4">
                                        {{$sr}}

                                    </td>

                                    <td class="align_center text-center edit tbl_amnt_10">
                                        <input type="hidden" name="product_code[]" class="inputs_up form-control" id="product_code{{$product->pro_p_code}}"
                                               value="{{$product->pro_p_code}}" readonly/>
                                        {{$product->pro_p_code}}
                                    </td>

                                    <td class="align_left text-left edit tbl_txt_10">
                                        <input type="hidden" name="product_name[]" class="inputs_up form-control" id="product_name{{$product->pro_p_code}}"
                                               value="{{$product->pro_title}}" readonly/>
                                        {{$product->pro_title}}
                                    </td>

                                    <td class="align_center text-center edit tbl_amnt_4">
                                        <input type="text" name="physical[]" class="inputs_up form-control" id="physical{{$product->pro_p_code}}"
                                               placeholder="Physical"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                    </td>
                                    <td class="align_center text-center edit tbl_amnt_4">
                                        <input type="text" name="bonus[]" class="inputs_up form-control" id="bonus"
                                               placeholder="Bonus"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
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

                    <div class="col-lg-2 col-md-2">
                        <button type="submit" name="save" id="save" class="save_button form-control">
                            <i class="fa fa-floppy-o"></i> SAVE
                        </button>

                        <span id="validate_msg" class="validate_sign"></span>

                    </div>
                </form>

            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('stock_taking_industrial') }}',
            url;

        @include('include.print_script_sh')
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
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#warehouse").select2();
            jQuery("#warehouse2").select2();
            jQuery("#main_unit").select2();
            jQuery("#unit").select2();
            jQuery("#group").select2();
            jQuery("#category").select2();
            jQuery("#product_group").select2();
        });
    </script>
    <script>
        jQuery("#warehouse").change(function () {

            var warehouse = jQuery('option:selected', this).val();

            jQuery("#warehouse2").select2("destroy");

            // jQuery("#product > option").each(function () {
            jQuery('#warehouse2 option[value="' + warehouse + '"]').prop('selected', true);
            // });

            jQuery("#warehouse2").select2();

        });

    </script>
@endsection

