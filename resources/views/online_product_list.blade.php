@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Product Online List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div
                    class="search_form {{ !empty($search) || !empty($search_group) || !empty($search_category) || !empty($search_product_reporting_group) || !empty($search_main_unit) || !empty($search_unit) ? '' : 'search_form_hidden' }}">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('online_product_list') }}" name="form1"
                                id="form1" method="post" autocomplete="off">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input type="search" list="browsers" class="inputs_up form-control"
                                                name="search" id="search" placeholder="Search ..."
                                                value="{{ isset($search) ? $search : '' }}">
                                            <datalist id="browsers">
                                                @foreach ($product_names as $value)
                                                    <option value="{{ $value }}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important">
                                            </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Group
                                            </label>
                                            <select class="inputs_up form-control" name="group" id="group">
                                                <option value="">Select Group</option>
                                                @foreach ($groups as $group)
                                                    <option value="{{ $group->grp_id }}"
                                                        {{ $group->grp_id == $search_group ? 'selected="selected"' : '' }}>
                                                        {{ $group->grp_title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Category
                                            </label>
                                            <select class="inputs_up form-control" name="category" id="category">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->cat_id }}"
                                                        {{ $category->cat_id == $search_category ? 'selected="selected"' : '' }}>
                                                        {{ $category->cat_title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Product Reporting Group
                                            </label>
                                            <select class="inputs_up form-control" name="product_reporting_group"
                                                id="product_reporting_group">
                                                <option value="">Select Product Reporting Group</option>
                                                @foreach ($product_reporting_groups as $product_reporting_group)
                                                    <option value="{{ $product_reporting_group->pg_id }}"
                                                        {{ $product_reporting_group->pg_id == $search_product_reporting_group ? 'selected="selected"' : '' }}>
                                                        {{ $product_reporting_group->pg_title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Main Unit
                                            </label>
                                            <select class="inputs_up form-control" name="main_unit" id="main_unit">
                                                <option value="">Select Main Unit</option>
                                                @foreach ($main_units as $main_unit)
                                                    <option value="{{ $main_unit->mu_id }}"
                                                        {{ $main_unit->mu_id == $search_main_unit ? 'selected="selected"' : '' }}>
                                                        {{ $main_unit->mu_title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <!-- start input box -->
                                            <label>
                                                Unit
                                            </label>
                                            <select class="inputs_up form-control" name="unit" id="unit">
                                                <option value="">Select Unit</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->unit_id }}"
                                                        {{ $unit->unit_id == $search_unit ? 'selected="selected"' : '' }}>
                                                        {{ $unit->unit_title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                        <div class="form_controls text-center text-lg-left">

                                            <button type="reset" type="button" name="cancel" id="cancel"
                                                class="cancel_button form-control">
                                                <i class="fa fa-trash"></i> Clear
                                            </button>
                                            <button type="submit" name="filter_search" id="filter_search"
                                                class="save_button form-control" value="">
                                                <i class="fa fa-search"></i> Search
                                            </button>

                                            @include('include/print_button')

                                            <span id="demo1" class="validate_sign" style="float: right !important">
                                            </span>

                                        </div>
                                    </div>

                                </div>
                            </form>


                        </div>
                    </div>
                </div><!-- search form end -->

                <form name="f1" class="f1" id="f1" action="{{ route('update_online_product_list') }}"
                    onsubmit="return form_validation()" method="post" autocomplete="off">
                    @csrf

                    <div class="table-responsive" id="parent">
                        <table class="table table-bordered" id="fixTable">

                            <thead>
                                <tr>
                                    <th nowrap="" scope="col" class=" tbl_srl_4">
                                        Sr.
                                    </th>
                                    <th scope="col" class=" tbl_amnt_8">
                                        Group
                                    </th>
                                    <th scope="col" class=" tbl_amnt_8">
                                        Category
                                    </th>
                                    <th nowrap="" scope="col" class=" tbl_amnt_10">
                                        Product Code
                                    </th>
                                    <th nowrap="" scope="col" class=" tbl_txt_15">
                                        Product Title
                                    </th>

                                    <th nowrap="" scope="col" class=" tbl_amnt_8">
                                        Online
                                    </th>
                                    <th nowrap="" scope="col" class=" tbl_amnt_8">
                                        Un/Limited
                                    </th>
                                    <th nowrap="" scope="col" class=" tbl_amnt_8">
                                        Hold Quantity % for Online
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                                    $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                                    $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                    $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                                @endphp

                                @forelse($datas as $index=> $product)
                                    <tr>
                                        <td class=" tbl_srl_4">
                                            {{ $sr }}
                                        </td>
                                        <td class=" tbl_amnt_8">
                                            {{ $product->grp_title }}
                                        </td>
                                        <td class=" tbl_amnt_8">
                                            {{ $product->cat_title }}
                                        </td>
                                        <td nowrap="" class=" tbl_amnt_10">
                                            {{ $product->pro_p_code }}
                                        </td>
                                        <td class="align_left text-left tbl_txt_15">
                                            {{ $product->pro_title }}
                                        </td>

                                        <td nowrap="" class="align_right text-right tbl_amnt_8">

                                            <select name="online[]" class="form-control">
                                                <option value="0"
                                                    {{ $product->pro_online_status == 0 ? 'selected' : '' }}>Offline
                                                </option>
                                                <option value="1"
                                                    {{ $product->pro_online_status == 1 ? 'selected' : '' }}>Online
                                                </option>
                                            </select>

                                            <input type="hidden" name="id[]" class="form-control"
                                                value="{{ $product->pro_p_code }}" />
                                        </td>
                                        <td nowrap="" class="align_right text-right tbl_amnt_8">

                                            <select name="limited[]" id="limit{{ $index }}" class="form-control"
                                                onchange="enable_disable({{ $index }})">
                                                <option value="0"
                                                    {{ $product->pro_stock_status == 0 ? 'selected' : '' }}>Limited
                                                </option>
                                                <option value="1"
                                                    {{ $product->pro_stock_status == 1 ? 'selected' : '' }}>Unlimited
                                                </option>
                                            </select>
                                        </td>
                                        <td nowrap="" class="align_right text-right tbl_amnt_8">
                                            <span id="s{{ $index }}" class="validate_sign"
                                                style="font-size: 15px;"> </span>
                                            <input type="text"
                                                class="form-control w-100 border-radius-0 border-0 text-right"
                                                value="{{ old('s_per.' . $index, $product->pro_hold_qty_per) }}"
                                                name="s_per[]" id="s_per{{ $index }}"
                                                data-id="{{ $index }}"
                                                onkeypress="return allow_only_number_and_decimals(this,event);"
                                                onkeyup="checkPer({{ $index }})" onfocus="this.select();"
                                                {{ $product->pro_stock_status == 1 ? 'readonly' : '' }}>
                                        </td>

                                    </tr>
                                    @php
                                        $sr++;
                                        !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="11">
                                            <center>
                                                <h3 style="color:#554F4F">No Product</h3>
                                            </center>
                                        </td>
                                    </tr>
                                @endforelse


                            </tbody>
                            <tfoot>
                            </tfoot>

                        </table>
                    </div>

                    <span
                        style="float: right">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'group' => $search_group, 'category' => $search_category, 'product_reporting_group' => $search_product_reporting_group, 'main_unit' => $search_main_unit, 'unit' => $search_unit])->links() }}</span>


                    <div class="form-group row">
                        <div class="col-lg-2 col-md-2">
                            <button type="submit" name="save" id="save" class="save_button form-control"
                                onclick="return form_validation()">
                                Update

                            </button>

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
        {{--    add code by shahzaib end --}}

        jQuery("#group").select2();
        jQuery("#category").select2();
        jQuery("#product_group").select2();
        jQuery("#main_unit").select2();
        jQuery("#unit").select2();
        jQuery("#product_reporting_group").select2();
    </script>

    <script>
        $('.save_button').click(function() {
            jQuery(".pre-loader").fadeToggle("medium");
        });
    </script>
    <script>
        function checkPer(index) {
            var per = $("#s_per" + index).val();
            if (per > 100) {
                $("#s_per" + index).val(0);
                $("#s" + index).html('You enter ' + per + ' % ');
            } else {
                $("#s" + index).html('');
            }

        }

        function enable_disable(index) {
            if ($('#limit' + index).val() == 1) {
                $("#s_per" + index).prop('readonly', true);
                $("#s_per" + index).val(0);
                $("#s" + index).html('');
            } else {
                $("#s_per" + index).prop('readonly', false);
            }
        }

        document.addEventListener('keydown', function(e) {

            if (e.keyCode == 13) {

                e.cancelBubble = true;
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;

            }

        });
    </script>
@endsection
