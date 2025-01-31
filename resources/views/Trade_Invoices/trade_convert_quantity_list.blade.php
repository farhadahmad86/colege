@extends('extend_index')
@section('styles_get')
    <style>
        .action_td .dropdown .dropdown-toggle::after {
            content: unset !important;
        }
    </style>
@stop
@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Trade Convert Quantity List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                {{--                {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}--}}
                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('trade_convert_quantity_list') }}" name="form1" id="form1" method="post">
                        <div class="row">
                            @csrf
                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="All Data Search"
                                           value="{{ $searchData['search'] ?? '' }}" autocomplete="off">
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <select name="product_code" class="inputs_up form-control" id="product_code">
                                                <option value="">Select Product Code</option>
                                                @foreach ($products as $product)
                                                    <option value='{{ $product->pro_p_code }}' {{ $search_product_code==$product->pro_p_code ? 'selected':'' }}>{{ $product->pro_p_code
                                                    }}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <select name="product_title" class="inputs_up form-control" id="product_title">
                                                <option value="">Select Product Title</option>
                                                @foreach ($products as $product)

                                                    <option value='{{ $product->pro_p_code }}' {{$search_product_title==$product->pro_p_code ? 'selected=selected':'' }}" >{{ $product->pro_title
                                                     }}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <select name="convert_quantity" class="inputs_up form-control" id="convert_quantity">
                                                <option value="0">Select Unit</option>
                                                <option value='1' {{ $searchData['convert_quantity'] ?? '' == 1 ? 'selected' : '' }}>Convert Quantity for Sale</option>
                                                <option value='2' {{ $searchData['convert_quantity'] ?? '' == 2 ? 'selected' : '' }}>Convert Quantity Not for Sale</option>
                                            </select>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx">
                                            <select name="convert_unit" class="inputs_up form-control" id="convert_unit">
                                                <option value="0">Select Convert Quantity</option>
                                                <option value='1' {{ $searchData['convert_unit'] ?? '' == 1 ? 'selected' : '' }}>Hold</option>
                                                <option value='2' {{ $searchData['convert_unit'] ?? '' == 2 ? 'selected' : '' }}>Bonus</option>
                                                <option value='3' {{ $searchData['convert_unit'] ?? '' == 3 ? 'selected' : '' }}>Claim</option>
                                            </select>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 text-right">
                                    @include('include.clear_search_button')
                                    <!-- Call add button component -->
                                        <x-add-button tabindex="9" href="{{ route('trade_convert_quantity') }}"/>

                                        @include('include/print_button')

                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end row -->
                    </form>


                    <form name="edit" id="edit" action="{{ route('edit_region') }}" method="post">
                        @csrf
                        <input name="title" id="title" type="hidden">
                        <input name="remarks" id="remarks" type="hidden">
                        <input name="region_id" id="region_id" type="hidden">

                    </form>

                    <form name="delete" id="delete" action="{{ route('delete_region') }}" method="post">
                        @csrf
                        <input name="reg_id" id="reg_id" type="hidden">
                    </form>
                </div>


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Code
                            </th>
                            <th scope="col" class="tbl_txt_25">
                                Product
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Quantity
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Pack Quantity
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Loose Quantity
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Convert Quantity
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Convert Unit
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created At
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
                        @forelse($convert_quantities as $index => $convert_quantity)
                            @php

                                $db_qty=$convert_quantity->cq_quantity;
                                 $scale_size=$convert_quantity->cq_scale_size;
                                                     $pack_qty = floor($db_qty/$scale_size);
                                                                     $loose_qty = fmod($db_qty, $scale_size);

                            @endphp
                            <tr>
                                <th scope="row" class="edit">
                                    {{$index + 1}}
                                </th>
                                <td class="edit">
                                    {{$convert_quantity->cq_pro_code}}
                                </td>
                                <td class="edit">
                                    {{$convert_quantity->cq_pro_title}}
                                </td>
                                <td class="edit">
                                    {{$convert_quantity->cq_quantity}}
                                </td>
                                <td class="edit">
                                    {{$pack_qty}}
                                </td>
                                <td class="edit">
                                    {{$loose_qty}}
                                </td>
                                <td class="edit">
                                    {{$convert_quantity->convertQuantity}}
                                </td>
                                <td class="edit">
                                    {{$convert_quantity->convertUnit}}
                                </td>
                                <td class="edit">
                                    {{$convert_quantity->cq_remarks}}
                                </td>
                                <td class="edit">
                                    {{$convert_quantity->createdBy}}
                                </td>
                                <td class="edit">
                                    {{$convert_quantity->cq_day_end_date}}
                                </td>
                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Quantity is converted</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$convert_quantities->firstItem()}} - {{$convert_quantities->lastItem()}} of {{$convert_quantities->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                <span
                    class="hide_column">{{ $convert_quantities->appends(['segmentSr' => $countSeg, 'search' => $searchData['search'] ?? '', 'product_code' => $searchData['product_code'] ?? '', 'product_title' => $searchData['product_title'] ?? '', 'convert_quantity' => $searchData['convert_quantity'] ?? '', 'convert_unit' => $searchData['convert_unit'] ?? '' ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    <script type="text/javascript">
        var base = '{{ route('trade_convert_quantity_list') }}',
            url;

        @include('include.print_script_sh')

        $(document).ready(function () {
            jQuery("#product_code").select2();
            jQuery("#product_title").select2();


            jQuery("#product_code").change(function () {
                var product_code = jQuery('option:selected', this).val();

                jQuery("#product_title").select2("destroy");
                jQuery('#product_title option[value="' + product_code + '"]').prop('selected', true);
                jQuery("#product_title").select2();
            });
            jQuery("#product_title").change(function () {
                var product_code = jQuery('option:selected', this).val();
                // var product_code = $(this).select2().find(":selected").data("product-code"); /* backup code: $('option:selected', this).attr('data-product-code') */

                jQuery("#product_code").select2("destroy");
                jQuery('#product_code option[value="' + product_code + '"]').prop('selected', true);
                jQuery("#product_code").select2();
            });
        });
    </script>
    <script>
        jQuery("#cancel").click(function () {

            $("#product_code").select2().val(null).trigger("change");
            $("#product_code > option").removeAttr('selected');

            $("#product_title").select2().val(null).trigger("change");
            $("#product_title > option").removeAttr('selected');

            $("#convert_quantity").val(0);

            // $("#convert_quantity > option").removeAttr('selected');

            $("#convert_unit").val(0);
            // $("#convert_unit > option").removeAttr('selected');


            $("#search").val('');

        });
    </script>

@endsection

