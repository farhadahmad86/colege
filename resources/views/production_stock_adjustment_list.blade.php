@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Production Stock Adjustment List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('production_stock_adjustment_list') }}" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
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
                                        Select Product
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control" name="product" id="product">
                                        <option value="">Select Code</option>
                                        @foreach($search_products as $product)
                                            <option value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_p_code}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Product
                                    </label>
                                    <select tabindex="3" class="inputs_up form-control" name="product_name" id="product_name">
                                        <option value="">Select Product</option>
                                        @foreach($search_products as $product)
                                            <option value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_title}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input tabindex="4" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        End Date
                                    </label>
                                    <input tabindex="5" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                @include('include.clear_search_button')
                                <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('production_stock_adjustment') }}"/>
                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                            </div>
                        </div>
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
                            <th scope="col" class="tbl_txt_8">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_8">
                                Voucher No.
                            </th>
                            <th scope="col" class="tbl_txt_15">
                                Account
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_15">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_txt_36">
                                Detail Remarks
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Total Consumed Amount
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Total Produced Amount
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $ttlPrc = $ttlProduce = $cashPaid = 0;
                        @endphp
                        @forelse($datas as $product)

                            <tr>
                                <th scope="row">
                                    {{$sr}}
                                </th>
                                <th>
                                    {{$product->psa_id}}
                                </th>
                                <td nowrap>
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $product->psa_day_end_date)))}}
                                </td>
                                <td class="view" data-id="{{$product->psa_id}}">
                                    PSA-{{$product->psa_id}}
                                </td>
                                <td>
                                    {{$product->psa_account_name}}
                                </td>
                                <td>
                                    {{$product->psa_remarks}}
                                </td>
                                <td>
                                    {{--                                        {{$product->psa_detail_remarks}}--}}
                                    {!! str_replace("&oS;",'<br />', $product->psa_detail_remarks) !!}
                                </td>
                                @php
                                    $ttlPrc = +($product->psa_consumed_total_amount) + +$ttlPrc;
                                @endphp
                                <td align="right" class="align_right text-right">
                                    {{$product->psa_consumed_total_amount}}
                                </td>
                                @php
                                    $ttlProduce = +($product->psa_produced_total_amount) + +$ttlProduce;
                                @endphp
                                <td align="right" class="align_right text-right">
                                    {{$product->psa_produced_total_amount}}
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

                        <tfoot>
                        <tr>
                            <th align="right" colspan="7" class="align_right text-right border-0">
                                Page Total:-
                            </th>
                            <td align="right" class="align_right text-right border-0">
                                {{ number_format($ttlPrc,2) }}
                            </td>
                            <td align="right" class="align_right text-right border-0">
                                {{ number_format($ttlProduce,2) }}
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
                            class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'product'=>$search_product, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Item Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('production_stock_adjustment_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");

            $('.modal-body').load('{{url("production_stock_consumed_produced_items_view_details/view/")}}' + '/' + id, function () {
                // jQuery(".pre-loader").fadeToggle("medium");
                $('#myModal').modal({show: true});
            });


            // jQuery.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            //
            // jQuery.ajax({
            //     url: "product_loss_recover_items_view_details",
            //     data: {id: id},
            //     type: "POST",
            //     cache: false,
            //     dataType: 'json',
            //     success: function (data) {
            //         $.each(data, function (index, value) {
            //
            //             jQuery("#table_body").append('\n' +
            //                 '                <div class="itm_vchr form_manage m-0"><div class="form_header mb-0"><h4 class="text-white file_name"><span class="db sml_txt"> Product Name: </span>' + value['plri_pro_name'] + '</h4></div><div class="table-responsive"><table class="table table-bordered"><thead><tr><th scope="col" align="center">Qty</th><th scope="col" align="center">Rate</th><th scope="col" align="center">Total</th></tr></thead><tbody><tr><td class="align_left">' + value['plri_pro_qty'] + '</td><td class="align_left">' + value['plri_pro_purchase_price'] + '</td><td class="align_left">' + value['plri_pro_total_amount'] + '</td></tr></tbody></table></div><div class="itm_vchr_rmrks"><h5 class="title_cus bold"> Remarks: </h5><p class="m-0 p-0">' + value['plri_remarks'] + '</p></div></div>');
            //
            //         });
            //     },
            //     error: function (jqXHR, textStatus, errorThrown) {
            //         // alert(jqXHR.responseText);
            //         // alert(errorThrown);
            //     }
            // });
            //
            //

        });
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');

            $("#product").select2().val(null).trigger("change");
            $("#product > option").removeAttr('selected');

            $("#search").val('');

            $("#to").val('');
            $("#from").val('');
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
            jQuery("#account").select2();
            jQuery("#product").select2();
            jQuery("#product_name").select2();
        });
    </script>

@endsection

