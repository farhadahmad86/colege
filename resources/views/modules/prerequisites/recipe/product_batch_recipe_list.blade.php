
@extends('extend_index')

@section('content')

    <div class="row">


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">



                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text file_name">Product Recipe List</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="srch_box_opn_icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->

                    <!-- <div class="search_form {{ ( !empty($search) ) ? '' : 'search_form_hidden' }}"> -->

                    <div class="search_form">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                                    <form class="prnt_lst_frm" action="{{ route('product_batch_recipe_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1"
                                          id="form1" method="post">
                                        @csrf
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        All Column Search
                                                    </label>
                                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                                    <datalist id="browsers">
                                                        @foreach($product_recipe_name as $value)
                                                            <option value="{{$value}}">
                                                        @endforeach
                                                    </datalist>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div> <!-- left column ends here -->

                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                                <div class="row">


{{--                                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                        <div class="input_bx"><!-- start input box -->--}}
{{--                                                            <label>--}}
{{--                                                                Main Unit--}}
{{--                                                            </label>--}}
{{--                                                            <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="main_unit" id="main_unit">--}}
{{--                                                                <option value="">Select Main Unit</option>--}}
{{--                                                                @foreach($main_units as $main_unit)--}}
{{--                                                                    <option value="{{$main_unit->mu_id}}" {{ $main_unit->mu_id == $search_main_unit ? 'selected="selected"' : '' }}>{{$main_unit->mu_title}}</option>--}}
{{--                                                                @endforeach--}}
{{--                                                            </select>--}}
{{--                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                        <div class="input_bx"><!-- start input box -->--}}
{{--                                                            <label>--}}
{{--                                                                Unit--}}
{{--                                                            </label>--}}
{{--                                                            <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="unit" id="unit">--}}
{{--                                                                <option value="">Select Unit</option>--}}
{{--                                                                @foreach($units as $unit)--}}
{{--                                                                    <option value="{{$unit->unit_id}}" {{ $unit->unit_id == $search_unit ? 'selected="selected"' : '' }}>{{$unit->unit_title}}</option>--}}
{{--                                                                @endforeach--}}
{{--                                                            </select>--}}
{{--                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                        <div class="input_bx"><!-- start input box -->--}}
{{--                                                            <label>--}}
{{--                                                                Group--}}
{{--                                                            </label>--}}
{{--                                                            <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="group" id="group">--}}
{{--                                                                <option value="">Select Group</option>--}}
{{--                                                                @foreach($groups as $group)--}}
{{--                                                                    <option value="{{$group->grp_id}}" {{ $group->grp_id == $search_group ? 'selected="selected"' : '' }}>{{$group->grp_title}}</option>--}}
{{--                                                                @endforeach--}}
{{--                                                            </select>--}}
{{--                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                                        <div class="input_bx"><!-- start input box -->--}}
{{--                                                            <label>--}}
{{--                                                                Category--}}
{{--                                                            </label>--}}
{{--                                                            <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="category" id="category">--}}
{{--                                                                <option value="">Select Category</option>--}}
{{--                                                                @foreach($categories as $category)--}}
{{--                                                                    <option value="{{$category->cat_id}}" {{ $category->cat_id == $search_category ? 'selected="selected"' : '' }}>{{$category->cat_title}}</option>--}}
{{--                                                                @endforeach--}}
{{--                                                            </select>--}}
{{--                                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form_controls text-center">

                                                    <button tabindex="6" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="7" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="8" class="save_button form-control" href="{{ route('product_batch_recipe') }}" role="button">
                                                        <i class="fa fa-plus"></i> Product Batch Recipe
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div>
                                    </form>


                                <form name="edit" id="edit" action="{{ route('edit_product_batch_recipe') }}" method="post">
                                    @csrf
                                    <input name="recipe_id" id="recipe_id" type="hidden">
                                </form>

                                <form name="delete" id="delete" action="{{ route('delete_product_batch_recipe') }}" method="post">
                                    @csrf
                                    <input name="del_recipe_id" id="del_recipe_id" type="hidden">
                                </form>

                            </div>

                        </div>
                    </div><!-- search form end -->



                    <div class="table-responsive" id="printTable">
                        <table class="table table-sm" id="fixTable">

                            <thead>
                                <tr>
                                    <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                                        Sr#
                                    </th>
                                    <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                                        ID
                                    </th>
                                    <th scope="col" align="center" class="align_center text-center tbl_txt_20">
                                        Recipe Name
                                    </th>
                                    <th scope="col" align="center" class="align_center text-center tbl_txt_21">
                                        Remarks
                                    </th>
                                    <th scope="col" align="center" class="align_center text-center tbl_txt_20">
                                        Finished Good
                                    </th>
                                    <th scope="col" align="center" class="align_center text-center tbl_amnt_8">
                                        Qty
                                    </th>
                                    <th scope="col" align="center" class="align_center text-center tbl_txt_6">
                                        UOM
                                    </th>
                                    <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                        Created By
                                    </th>
                                    <th scope="col" align="center" class="align_center text-center hide_column tbl_srl_8">
                                        Enable
                                    </th>
{{--                                    <th scope="col" align="center" class="align_center text-center hide_column tbl_srl_4">--}}
{{--                                        Delete--}}
{{--                                    </th>--}}
                                </tr>
                            </thead>

                            <tbody>
                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            @endphp
                            @forelse($datas as $product_recipe)

                                <tr data-recipe_id="{{$product_recipe->pbr_id}}">
                                    <td class="align_center text-center edit tbl_srl_4">
                                        {{$sr}}
                                    </td>
                                    <td class="align_center text-center edit tbl_srl_4">
                                        {{$product_recipe->pbr_id}}
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_20">
                                        {{$product_recipe->pbr_name}}
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_21">
                                        {{$product_recipe->pbr_remarks}}
                                    </td>
                                    <td class="align_left text-left edit tbl_txt_20">
                                        {{$product_recipe->pbri_product_name}}
                                    </td>
                                    <td class="align_right text-right edit tbl_amnt_8">
                                        {{$product_recipe->pbri_qty}}
                                    </td>
                                    <td class="align_center text-center edit tbl_txt_6">
                                        KG
                                    </td>
                                    @php
                                        $ip_browser_info= ''.$product_recipe->pbr_ip_adrs.','.str_replace(' ','-',$product_recipe->pbr_brwsr_info).'';
                                    @endphp

                                    <td class="align_left usr_prfl text-left tbl_txt_8" data-usr_prfl="{{ $product_recipe->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                        {{ $product_recipe->user_name }}
                                    </td>

                                    <td class="align_center text-center hide_column tbl_srl_8">
{{--                                        <a data-recipe_id="{{$product_recipe->pbr_id}}" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure?">--}}
{{--                                            <i class="fa fa-{{$product_recipe->pbr_delete_status == 1 ? 'undo':'trash'}}"></i>--}}
{{--                                        </a>--}}

                                        <label class="switch">
                                            <input type="checkbox" @php
                                                    if ($product_recipe->pbr_disabled == 0) {
                                                echo 'checked="true"' . ' ' . 'value=' . $product_recipe->pbr_disabled;
                                            }
                                            else {
                                                echo 'value=DISABLE';
                                            } @endphp
                                            class="enable_disable" data-id="{{$product_recipe->pbr_id}}"
                                                {{ $product_recipe->pbr_disabled == 0 ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>


                                </tr>
                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <center><h3 style="color:#554F4F">No Entry</h3></center>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>

                        </table>

                    </div>
{{--                    <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'product_code'=>$search_product, ])->links() }}</span>--}}
                    <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>
                </div> <!-- white column form ends here -->


{{--                                                    <td class="align_right text-right hide_column tbl_amnt_6">--}}
{{--                                                        <label class="switch">--}}
{{--                                                            <input type="checkbox" --}}
{{--                                                                    if ($product_recipe->pbr_disabled == 0) {--}}
{{--                                                                echo 'checked="true"' . ' ' . 'value=' . $product_recipe->pr_disabled;--}}
{{--                                                            } --}}
{{--                                                            else {--}}
{{--                                                                echo 'value=DISABLE';--}}
{{--                                                            }  --}}
{{--                                                            class="enable_disable" data-id="{{$product_recipe->pr_id}}"--}}
{{--                                                                {{ $product_recipe->pr_disabled == 0 ? 'checked' : '' }}>--}}
{{--                                                            <span class="slider round"></span>--}}
{{--                                                        </label>--}}
{{--                                                    </td>--}}

            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('product_batch_recipe_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    {{--    add code by mustafa start --}}
    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let prId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_product_recipe') }}',
                    data: {'status': status, 'pr_id': prId},
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
            var recipe_id = jQuery(this).parent('tr').attr("data-recipe_id");

            jQuery("#recipe_id").val(recipe_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var recipe_id = jQuery(this).attr("data-recipe_id");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function(result) {

                if (result.value) {
                    jQuery("#del_recipe_id").val(recipe_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });


    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#to").val('');
            $("#from").val('');

            $("#product_code").select2().val(null).trigger("change");
            $("#product_code > option").removeAttr('selected');

            $("#product_name").select2().val(null).trigger("change");
            $("#product_name > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery("#product_code").change(function () {

            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_name").select2("destroy");

            jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);

            jQuery("#product_name").select2();

            assign_product_parent_value();
        });

        jQuery("#product_name").change(function () {

            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_code").select2("destroy");

            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);

            jQuery("#product_code").select2();

            assign_product_parent_value(); //this function define in script.php file
        });



    </script>


@endsection

