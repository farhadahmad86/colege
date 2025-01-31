@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage" id="">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Product Clubbing List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

        <!-- <div class="search_form {{ ( !empty($search) || !empty($search_main_unit) || !empty($search_unit) || !empty($search_group) || !empty($search_category) ) ? '' : 'search_form_hidden' }}"> -->
            <div class="search_formm-0 p-0 ">
                <form class="highlight prnt_lst_frm" action="{{ route('product_clubbing_list') . (isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '' }}" name="form1" id="form1"
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
                                    @foreach($product as $value)
                                        <option value="{{$value}}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
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
                                        <option value="{{$main_unit->mu_id}}" {{ $main_unit->mu_id == $search_main_unit ? 'selected="selected"' : '' }}>{{$main_unit->mu_title}}</option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
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
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
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
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
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
                                        <option value="{{$category->cat_id}}" {{ $category->cat_id == $search_category ? 'selected="selected"' : '' }}>{{$category->cat_title}}</option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 mt-4 text-right form_controls">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_product') }}"/>
                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>


                    </div>
                </form>


                <form name="edit" id="edit" action="{{ route('product_clubbing') }}" method="post">
                    @csrf
                    <input name="product_code" id="product_code" type="hidden">
                </form>

                {{--                                <form name="delete" id="delete" action="{{ route('delete_product') }}" method="post">--}}
                {{--                                    @csrf--}}
                {{--                                    <input name="product_id" id="del_product_id" type="hidden">--}}
                {{--                                    <input name="product_code" id="del_product_code" type="hidden">--}}
                {{--                                </form>--}}
            </div><!-- search form end -->
            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_4">
                            Sr#
                        </th>
                        <th scope="col" class="tbl_srl_4">
                            ID
                        </th>
                        <th scope="col" class="tbl_amnt_11">
                            P.Code
                        </th>
                        <th scope="col" class="tbl_txt_6p">
                            Group
                        </th>
                        <th scope="col" class="tbl_txt_6p">
                            Category
                        </th>
                        <th scope="col" class="tbl_txt_9">
                            Product Name
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Remarks
                        </th>
                        <th scope="col" class="tbl_amnt_6">
                            Stock
                        </th>
                        <th scope="col" class="tbl_amnt_9">
                            Purchase Price
                        </th>
                        <th scope="col" class="tbl_amnt_8">
                            Sale Price
                        </th>
                        <th scope="col" class="tbl_amnt_8">
                            Average Price
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            Created By
                        </th>
                        <th scope="col" class="hide_column tbl_srl_4">
                            Enable
                        </th>
                        <th scope="col" class="hide_column tbl_srl_4">
                            Delete
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

                        <tr data-product_code="{{$product->pro_p_code}}">

                            <td class="edit tbl_srl_4">
                                {{$sr}}
                            </td>
                            <td class="edit tbl_srl_4">
                                {{$product->pro_id}}
                            </td>
                            <td class="edit tbl_amnt_11">
                                {{$product->pro_p_code}}
                            </td>
                            <td class="align_left text-left edit tbl_amnt_6p">
                                {{$product->grp_title}}
                            </td>
                            <td class="align_left text-left edit tbl_amnt_6p">
                                {{$product->cat_title}}
                            </td>
                            <td class="align_left text-left edit tbl_txt_9">
                                {{$product->pro_title}}
                            </td>
                            <td class="align_left text-left edit tbl_txt_8">
                                {{$product->pro_remarks}}
                            </td>
                            <td class="edit tbl_amnt_6">
                                {{$product->pro_quantity}}
                            </td>
                            @php
                                $prchsPrc = +($product->pro_purchase_price) + +$prchsPrc;
                            @endphp
                            <td class="text-right edit tbl_amnt_9">
                                {{number_format($product->pro_purchase_price,2)}}
                            </td>
                            @php
                                $slePrc = +($product->pro_sale_price) + +$slePrc;
                            @endphp
                            <td class="text-right edit tbl_amnt_8">
                                {{number_format($product->pro_sale_price,2)}}
                            </td>
                            @php
                                $avrgPrc = +($product->pro_average_rate) + +$avrgPrc;
                            @endphp
                            <td class="text-right edit tbl_amnt_10">
                                {{number_format($product->pro_average_rate,2)}}
                            </td>

                            @php
                                // $ip_browser_info= ''.$product->invt_ip_adrs.','.str_replace(' ','-',$product->invt_brwsr_info).'';
                                    $ip_browser_info= '';
                            @endphp

                            <td class="align_left usr_prfl text-left tbl_txt_8" data-usr_prfl="{{ $product->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{ $product->user_name }}
                            </td>

                            {{--    add code by mustafa start --}}
                            <td class="text-right hide_column tbl_amnt_6">
                                <label class="switch">
                                    <input type="checkbox" <?php if ($product->pro_disabled == 0) {
                                        echo 'checked="true"' . ' ' . 'value=' . $product->pro_disabled;
                                    } else {
                                        echo 'value=DISABLE';
                                    } ?>  class="enable_disable" data-id="{{$product->pro_id}}"
                                        {{ $product->pro_disabled == 0 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            {{--    add code by mustafa end --}}

                            <td class="text-right hide_column tbl_srl_4">
                                <a data-product_id="{{$product->pro_id}}" data-product_code="{{$product->pro_p_code}}" class="delete" data-toggle="tooltip" data-placement="left" title=""
                                   data-original-title="Are you sure?">
                                    <i class="fa fa-{{$product->pro_delete_status == 1 ? 'undo':'trash'}}"></i>
                                </a>
                            </td>


                        </tr>
                        @php
                            $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="14">
                                <center><h3 style="color:#554F4F">No Product</h3></center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                    <tfoot>
                    <tr>
                        <th colspan="8" class="text-right border-0">
                            Per Page Total:-
                        </th>
                        <td class="text-right border-0">
                            {{ number_format($prchsPrc,2) }}
                        </td>
                        <td class="text-right border-0">
                            {{ number_format($slePrc,2) }}
                        </td>
                        <td class="text-right border-0">
                            {{ number_format($avrgPrc,2) }}
                        </td>
                    </tr>
                    </tfoot>

                </table>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                </div>
                <div class="col-md-9 text-right">
            <span
                class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'main_unit'=>$search_main_unit, 'unit'=>$search_unit, 'group'=>$search_group, 'category'=>$search_category ])->links() }}</span>
                </div>
            </div> <!-- white column form ends here -->
        </div><!-- row end -->

        @endsection

        @section('scripts')

            {{--    add code by shahzaib start --}}
            <script type="text/javascript">
                var base = '{{ route('product_clubbing_list') }}',
                    url;

                @include('include.print_script_sh')
            </script>
            {{--    add code by shahzaib end --}}


            {{--    add code by mustafa start --}}
            <script>

                $(document).ready(function () {
                    $('.enable_disable').change(function () {
                        let status = $(this).prop('checked') === true ? 0 : 1;
                        let proId = $(this).data('id');
                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: '{{ route('enable_disable_product') }}',
                            data: {'status': status, 'pro_id': proId},
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
                    var product_code = jQuery(this).parent('tr').attr("data-product_code");

                    jQuery("#product_code").val(product_code);
                    jQuery("#edit").submit();
                });

                // jQuery(".delete").click(function () {
                //
                //     var product_id = jQuery(this).attr("data-product_id");
                //     var product_code = jQuery(this).attr("data-product_code");
                //
                //     jQuery("#del_product_id").val(product_id);
                //     jQuery("#del_product_code").val(product_code);
                //     jQuery("#delete").submit();
                // });

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
                });
            </script>

@endsection

