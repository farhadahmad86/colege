@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="container-fluid search-filter form-group form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">
                                Product List Stock Wise
                                {{--                                    <span class="pro_name"></span>--}}
                            </h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                {{--<div class="search_form {{ ( !empty($search) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}">--}}
                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('product_ledger_stock_wise') }}" name="form1" id="form1" method="post" autocomplete="off">
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
                                        @foreach($product as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
                                <div class="row">
                                    <input tabindex="2" name="product" id="product" type="hidden" value="{{$search_product}}">
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Product Code
                                            </label>
                                            <select tabindex="3" name="product_code" class="inputs_up form-control" id="product_code">
                                                <option value="">Select Product Code</option>

                                                @foreach($products as $product)
                                                    <option
                                                        value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_p_code}}</option>
                                                @endforeach

                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Product
                                            </label>
                                            <select tabindex="4" name="product_name" class="inputs_up form-control" id="product_name">
                                                <option value="">Select Product</option>

                                                @foreach($products as $product)
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
                                            <input tabindex="5" type="text" name="from" id="from" class="inputs_up form-control datepicker1" value="{{isset($search_from) ? $search_from:""}}"
                                                   placeholder="Start Date"/>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                End Date
                                            </label>
                                            <input tabindex="6" type="text" name="to" id="to" class="inputs_up form-control datepicker1" value="{{isset($search_to) ? $search_to:""}}"
                                                   placeholder="End Date"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 text-right mt-4">
                                        @include('include.clear_search_button')
                                        @include('include/print_button')
                                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
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
                            <th scope="col" class="tbl_amnt_8">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_12">
                                Invoice Type
                            </th>
                            <th scope="col" class="tbl_amnt_12">
                                Party
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Voucher No.
                            </th>
                            <th scope="col" class="tbl_txt_23">
                                Product Name
                            </th>
                            <th scope="col" class="tbl_amnt_13">
                                Stock In
                            </th>
                            <th scope="col" class="tbl_amnt_13">
                                Stock Out
                            </th>
                            <th scope="col" class="tbl_amnt_13">
                                Balance
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $stck_in_pg = $stck_out_pg = $bal = 0;
                        @endphp
                        @forelse($datas as $result)
                            @php
                                $stck_in_pg = +$result->sm_in_qty + +$stck_in_pg;
                                $stck_out_pg = +$result->sm_out_qty + +$stck_out_pg;
                                $bal = +$result->sm_bal_total_qty + +$bal;
                            @endphp
                            <tr>
                                <th scope="row" class="tbl_srl_4">
                                    {{$sr}}
                                </th>
                                <td class="tbl_srl_4">
                                    {{$result->sm_id}}
                                </td>
                                <td class="tbl_amnt_8">
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $result->sm_day_end_date)))}}
                                </td>
                                <td class="tbl_amnt_12">
                                    {{ $result->sm_type }}
                                </td>
                                <td class="tbl_amnt_12">
                                    {{ $result->smc_party_name }}
                                </td>
                                <td class="tbl_amnt_10">
                                    <a class="view" data-transcation_id="{{$result->sm_voucher_code}}" data-toggle="modal" data-target="#myModal" style="cursor:pointer; color: #0099ff;">
                                        {{$result->sm_voucher_code}}
                                    </a>
                                </td>
                                <td class="tbl_txt_23">
                                    {{$result->sm_product_name}}
                                </td>
                                <td class="text-right tbl_amnt_13">
                                {{ number_format($result->sm_in_qty, 2) }}
                                <!--{{ number_format($result->sm_pur_qty, 2) }}-->
                                </td>
                                <td class="text-right tbl_amnt_13">
                                {{ number_format($result->sm_out_qty, 2) }}
                                <!--{{ number_format($result->sm_sale_qty, 2) }}-->
                                </td>
                                <td class="text-right tbl_amnt_13">
                                {{ number_format($result->sm_bal_total_qty, 2) }}
                                <!--{{ number_format($result->sm_bal_qty, 2) }}-->
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Record</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr class="border-0">
                            <th colspan="7" class="border-0 text-right">
                                Page Total:
                            </th>
                            <td class="text-right border-0">
                                {{ number_format($stck_in_pg, 2) }}
                            </td>
                            <td class="text-right border-0">
                                {{ number_format($stck_out_pg, 2) }}
                            </td>
                            {{--                                <td class="text-right border-0">--}}
                            {{--                                    {{ number_format($stck_in_pg - $stck_out_pg,2) }}--}}
                            {{--                                </td>--}}
                        </tr>
                        </tfoot>

                    </table>

                </div>
                <div class="row">
    <div class="col-md-3">
        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
    </div>
    <div class="col-md-9 text-right">
                <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from, 'product_code'=>$search_product ])->links() }}</span>
                <!--'product_code'=>$pro_code-->
                </div></div></div> <!-- white column form ends here -->
    </div><!-- row end -->
    {{--        @include('include/footer')--}}
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: 1250px; margin-left: -220px;">
                <div class="modal-header">
                    <h4 class="modal-title text-blue table-header">Items Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-values">
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('product_ledger_stock_wise') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".view").click(function () {

            var transcation_id = jQuery(this).attr("data-transcation_id");

            jQuery(".table-header").html("");
            jQuery(".table-values").html("");

            $(".modal-body").load('{{ url('/transaction_view_details_SH/') }}/' + transcation_id, function () {
                $('#myModal').modal({show: true});
            });
        });

    </script>
    {{--@include('include/script')--}}


    <script>

        // jQuery("#pro_code").change(function () {
        //
        //     jQuery("#form1").submit();
        // });

        jQuery("#cancel").click(function () {

            $("#product_code").select2().val(null).trigger("change");
            $("#product_code > option").removeAttr('selected');


            $("#product_name").select2().val(null).trigger("change");
            $("#product_name > option").removeAttr('selected');

            $("#product_code").select2();
            $("#product_name").select2();

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');
        });


        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();


            setTimeout(function () {

                var product_name = jQuery("#product_name option:selected").text();

                jQuery(".pro_name").html("");

                jQuery(".pro_name").append('Product: ' + product_name);

            }, 500);

        });
    </script>
    <script>
        jQuery("#product_name").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_code").select2("destroy");

            // jQuery("#product > option").each(function () {
            //     jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);
            jQuery("#product_code").select2();
            assign_product_parent_value();
        });


        jQuery("#product_code").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_name").select2("destroy");

            // jQuery("#product_name > option").each(function () {
            jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery("#product_name").select2();
            assign_product_parent_value();
        });


    </script>
@stop
