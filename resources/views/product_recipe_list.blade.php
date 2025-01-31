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

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('product_recipe_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1"
                          method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($product_recipe_name as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">

                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right mt-4">
                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('product_recipe') }}"/>

                                    @include('include/print_button')

                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                        </div>
                    </form>


                    <form name="edit" id="edit" action="{{ route('edit_product_recipe') }}" method="post">
                        @csrf
                        <input name="recipe_id" id="recipe_id" type="hidden">
                    </form>

                    <form name="delete" id="delete" action="{{ route('delete_product_recipe') }}" method="post">
                        @csrf
                        <input name="del_recipe_id" id="del_recipe_id" type="hidden">
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_20">
                                Recipe Name
                            </th>
                            <th scope="col" class="tbl_txt_21">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_txt_20">
                                Finished Good
                            </th>
                            <th scope="col" class="tbl_amnt_8">
                                Qty
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                UOM
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="hide_column tbl_srl_8">
                                Enable
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
                        @forelse($datas as $product_recipe)

                            <tr data-recipe_id="{{$product_recipe->pr_id}}">
                                <th scope="row" class="edit tbl_srl_4">
                                    {{$sr}}
                                </th>
                                <td class="edit">
                                    {{$product_recipe->pr_id}}
                                </td>
                                <td class="edit">
                                    {{$product_recipe->pr_name}}
                                </td>
                                <td class="edit">
                                    {{$product_recipe->pr_remarks}}
                                </td>
                                <td class="edit">
                                    {{$product_recipe->pri_product_name}}
                                </td>
                                <td class="text-right edit">
                                    {{$product_recipe->pri_qty}}
                                </td>
                                <td class="edit">
                                    KG
                                </td>
                                @php
                                    $ip_browser_info= ''.$product_recipe->pr_ip_adrs.','.str_replace(' ','-',$product_recipe->pr_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl" data-usr_prfl="{{ $product_recipe->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $product_recipe->user_name }}
                                </td>

                                <td class="hide_column">

                                    <label class="switch">
                                        <input type="checkbox" @php
                                            if ($product_recipe->pr_disabled == 0) {
                                        echo 'checked="true"' . ' ' . 'value=' . $product_recipe->pr_disabled;
                                    }
                                    else {
                                        echo 'value=DISABLE';
                                    } @endphp
                                        class="enable_disable" data-id="{{$product_recipe->pr_id}}"
                                            {{ $product_recipe->pr_disabled == 0 ? 'checked' : '' }}>
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
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('product_recipe_list') }}',
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
            }).then(function (result) {

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

