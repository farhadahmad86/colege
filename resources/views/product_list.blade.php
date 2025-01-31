@extends('extend_index')

@section('content')
    <style>
        .table thead th {
            background-color: rgb(222 222 222);
            color: #000;
        }

        .radion {
            padding: 6px;
            font-size: small;
        }
    </style>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Product List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                {{--                <!-- <div class="search_form {{ ( !empty($search) || !empty($search_main_unit) || !empty($search_unit) || !empty($search_group) || !empty($search_category) ) ? '' : 'search_form_hidden' }}"> --> --}}

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('product_list') . (isset($restore_list) && $restore_list == 1 ? '?restore_list=1' : '') }}"
                          name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers"
                                           class="inputs_up form-control all_clm_srch" name="search" id="search"
                                           placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                           autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach ($product as $value)
                                            <option value="{{ $value }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div> <!-- left column ends here -->
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Main Unit
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch"
                                            name="main_unit" id="main_unit">
                                        <option value="">Select Main Unit</option>
                                        @foreach ($main_units as $main_unit)
                                            <option value="{{ $main_unit->mu_id }}"
                                                {{ $main_unit->mu_id == $search_main_unit ? 'selected="selected"' : '' }}>
                                                {{ $main_unit->mu_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Unit
                                    </label>
                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch"
                                            name="unit" id="unit">
                                        <option value="">Select Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->unit_id }}"
                                                {{ $unit->unit_id == $search_unit ? 'selected="selected"' : '' }}>
                                                {{ $unit->unit_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Group
                                    </label>
                                    <select tabindex="4" class="inputs_up form-control cstm_clm_srch"
                                            name="group" id="group">
                                        <option value="">Select Group</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->grp_id }}"
                                                {{ $group->grp_id == $search_group ? 'selected="selected"' : '' }}>
                                                {{ $group->grp_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Category
                                    </label>
                                    <select tabindex="5" class="inputs_up form-control cstm_clm_srch"
                                            name="category" id="category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->cat_id }}"
                                                {{ $category->cat_id == $search_category ? 'selected="selected"' : '' }}>
                                                {{ $category->cat_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Product Group
                                    </label>
                                    <select tabindex="6" class="inputs_up form-control cstm_clm_srch"
                                            name="product_group" id="product_group">
                                        <option value="">Select Product Group</option>
                                        @foreach ($product_groups as $product_group)
                                            <option value="{{ $product_group->pg_id }}"
                                                {{ $product_group->pg_id == $search_product_group ? 'selected="selected"' : '' }}>
                                                {{ $product_group->pg_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form_controls text-right">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-info radion {{ $option == 'ASC' ? 'active' : '' }}">
                                        <input type="radio" name="options" value="ASC" id="ASC"
                                               autocomplete="off"> ASC
                                    </label>
                                    <label class="btn btn-info radion {{ $option == 'ASC' ? '' : 'active' }}">
                                        <input type="radio" value="DESC" name="options" id="DESC"
                                               autocomplete="off"> DESC
                                    </label>
                                </div>
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('add_product') }}"/>
                                @include('include/print_button')
                                <span id="demo1" class="validate_sign" style="float: right !important">
                                        </span>
                            </div>
                        </div>
                    </form>


                    <form name="edit" id="edit" action="{{ route('edit_product') }}" method="post">
                        @csrf
                        <input name="product_id" id="product_id" type="hidden">
                    </form>

                    <form name="delete" id="delete" action="{{ route('delete_product') }}" method="post">
                        @csrf
                        <input name="product_id" id="del_product_id" type="hidden">
                        <input name="product_code" id="del_product_code" type="hidden">
                    </form>

                    <form name="status_change" id="status_change" action="{{ route('change_status_product') }}"
                          method="post">
                        @csrf
                        <input name="product_status" id="product_status" type="hidden">
                        <input name="product_parent_code" id="product_parent_code" type="hidden">
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Product Barcode
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Product Code
                            </th>
                            <th scope="col" class="tbl_txt_6p">
                                Product Group Title
                            </th>
                            <th scope="col" class="tbl_txt_6p">
                                Product Category Title
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Product Title
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Stock
                            </th>
                            <th scope="col" class="tbl_amnt_4" hidden>
                                UOM ID
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Last Purchase Price
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Sale Price
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Average Price
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Online
                            </th>
                            <th scope="col" class="hide_column tbl_srl_4">
                                Enable
                            </th>
                            <th scope="col" class="hide_column tbl_srl_4">
                                Delete
                            </th>
                            <th scope="col" class="hide_column tbl_srl_4">
                                Status
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                            $prchsPrc = $slePrc = $avrgPrc = 0;
                        @endphp
                        @forelse($datas as $product)
                            <tr data-product_id="{{ $product->pro_id }}">
                                <th scope="row" class="edit tbl_srl_4">
                                    {{ $product->pro_id }}
                                </th>
                                <td class="edit tbl_amnt_10">
                                    {{ $product->pro_p_code }}
                                </td>
                                <td class="edit tbl_amnt_10">
                                    {{ $product->pro_code }}
                                </td>
                                <td class="edit tbl_amnt_6p">
                                    {{ $product->grp_title }}
                                </td>
                                <td class="edit tbl_amnt_6p">
                                    {{ $product->cat_title }}
                                </td>
                                <td class="edit tbl_txt_10">
                                    {{ $product->pro_title }}
                                </td>
                                <td class="edit tbl_txt_6">
                                    {{ $product->pro_remarks }}
                                </td>
                                <td class="edit tbl_amnt_6">
                                    {{ $product->pro_quantity }}
                                </td>
                                <td class="edit tbl_amnt_4" hidden>
                                    {{ $product->unit_id }}
                                </td>
                                @php
                                    $prchsPrc = +$product->pro_purchase_price + +$prchsPrc;
                                @endphp
                                <td class="align_right text-right edit tbl_amnt_10">
                                    {{ number_format($product->pro_last_purchase_rate, 2) }}
                                </td>
                                @php
                                    $slePrc = +$product->pro_sale_price + +$slePrc;
                                @endphp
                                <td class="align_right text-right edit tbl_amnt_10">
                                    {{ number_format($product->pro_sale_price, 2) }}
                                </td>
                                @php
                                    $avrgPrc = +$product->pro_average_rate + +$avrgPrc;
                                @endphp
                                <td class="align_right text-right edit tbl_amnt_10">
                                    {{ number_format($product->pro_average_rate, 2) }}
                                </td>
                                @php
                                    $ip_browser_info = '' . $product->pro_ip_adrs . ',' . str_replace(' ', '-', $product->pro_brwsr_info) . '';
                                    //$ip_browser_info= '';
                                @endphp
                                <td class="align_left usr_prfl tbl_txt_8" data-usr_prfl="{{ $product->user_id }}"
                                    data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $product->user_name }}
                                </td>
                                <td class="text-center usr_prfl tbl_txt_8 align-middle">
                                    <sapn class="btn btn-sm {{ $product->pro_online_status == 1 ? 'btn-success' : 'btn-danger' }} ">{{ $product->pro_online_status == 1 ? 'Online' : 'Offline' }}
                                        <sapn>
                                </td>
                                {{--    add code by mustafa start --}}
                                <td class="text-center hide_column tbl_amnt_6 align-middle">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($product->pro_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $product->pro_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?> class="enable_disable"
                                               data-id="{{ $product->pro_id }}"
                                            {{ $product->pro_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                {{--    add code by mustafa end --}}
                                <td class="text-center hide_column tbl_srl_4 align-middle">
                                    <a data-product_id="{{ $product->pro_id }}"
                                       data-product_code="{{ $product->pro_code }}" class="delete"
                                       data-toggle="tooltip" data-placement="left" title=""
                                       data-original-title="Are you sure?">
                                        <i class="fa fa-{{ $product->pro_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                    </a>
                                </td>
                                <td class="hide_column tbl_srl_4">
                                    @if ($product->pro_status == config('global_variables.product_active_status'))
                                        <a href="#" data-product_parent_code="{{ $product->pro_p_code }}"
                                           data-product_status="1" class="change_status">Discontinue</a>
                                        <a href="#" data-product_parent_code="{{ $product->pro_p_code }}"
                                           data-product_status="2" class="change_status">Lock</a>
                                    @elseif($product->pro_status == config('global_variables.product_discontinue_status'))
                                        <a href="#" data-product_parent_code="{{ $product->pro_p_code }}"
                                           data-product_status="3" class="change_status">Continue</a>
                                    @elseif($product->pro_status == config('global_variables.product_lock_status'))
                                        <a href="#" data-product_parent_code="{{ $product->pro_p_code }}"
                                           data-product_status="3" class="change_status">UnLock</a>
                                    @endif
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
                        <tr>
                            <th align="right" colspan="8" class="align_right text-right border-0">
                                Page Total:-
                            </th>
                            <td align="right" class="align_right text-right border-0">
                                {{ number_format($prchsPrc, 2) }}
                            </td>
                            <td align="right" class="align_right text-right border-0">
                                {{ number_format($slePrc, 2) }}
                            </td>
                            <td align="right" class="align_right text-right border-0">
                                {{ number_format($avrgPrc, 2) }}
                            </td>
                        </tr>
                        </tfoot>

                    </table>

                </div>

                {{--                nabeel panga --}}
                <div class="row">
                    <div class="col-lg-12 text-center">
                        @if ($has_pages == 0)
                        <a href="{{ url('/product_list?page=1') }}" class="btn btn-default">Paginate</a>
                        @endif
                        <a href="{{ url('/product_list') }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9">

                <span
                    class="hide_column float-right">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'main_unit' => $search_main_unit, 'unit' => $search_unit, 'group' =>
                    $search_group, 'category' => $search_category])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->
@endsection

@section('scripts')
    <script src="{{ asset('public/plugins/nabeel_blue/jquery.floatThead.js') }}"></script>

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('product_list') }}',
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


            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let proId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_product') }}',
                    data: {
                        'status': status,
                        'pro_id': proId
                    },
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>
    {{--    add code by mustafa end --}}


    <script>
        jQuery(".edit").click(function () {
            var product_id = jQuery(this).parent('tr').attr("data-product_id");

            jQuery("#product_id").val(product_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var product_id = jQuery(this).attr("data-product_id");
            var product_code = jQuery(this).attr("data-product_code");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function (result) {

                if (result.value) {
                    jQuery("#del_product_id").val(product_id);
                    jQuery("#del_product_code").val(product_code);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });


        jQuery(".change_status").click(function () {

            var product_parent_code = jQuery(this).attr("data-product_parent_code");
            var product_status = jQuery(this).attr("data-product_status");

            jQuery("#product_status").val(product_status);
            jQuery("#product_parent_code").val(product_parent_code);
            jQuery("#status_change").submit();
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
