@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Product Last Purchase Rate Verification Party Wise</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div
                    class="search_form m-0 p-0  {{ ( !empty($search) || !empty($search_account) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : '' }}">

                    <form class="highlight prnt_lst_frm" action="{{ route('party_last_purchase_rate_verification') }}" name="form1" id="form1" method="post" autocomplete="off">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        {{--                                                    @foreach($product_title as $value)--}}
                                        {{--                                                        <option value="{{$value}}">--}}
                                        {{--                                                    @endforeach--}}
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <input name="product" id="product" type="hidden" value="{{$search_product}}">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Account
                                    </label>
                                    <select class=" inputs_up form-control" name="account" id="account">
                                        <option value="">Select Account</option>
                                        @foreach($accounts as $account)
                                            <option
                                                value="{{$account->account_uid}}" {{ $account->account_uid == $search_account ? 'selected="selected"' : '' }}>{{$account->account_name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Product Code
                                    </label>
                                    <select class=" inputs_up form-control" name="product_code" id="product_code">
                                        <option value="">Select Product Code</option>
                                        {{--                                                            @foreach($products as $product)--}}
                                        {{--                                                                <option value="{{$product->pro_code}}" {{ $product->pro_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_code}}</option>--}}
                                        {{--                                                            @endforeach--}}
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Product
                                    </label>
                                    <select class=" inputs_up form-control" name="product_name" id="product_name">
                                        <option value="">Select Product</option>
                                        {{--                                                            @foreach($products as $product)--}}
                                        {{--                                                                <option value="{{$product->pro_code}}" {{ $product->pro_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_title}}</option>--}}
                                        {{--                                                            @endforeach--}}
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        End Date
                                    </label>
                                    <input type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                            @include('include.clear_search_button')

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
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_amnt_8">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Voucher No.
                            </th>
                            <th scope="col" class="tbl_txt_16">
                                Party Name
                            </th>
                            <th scope="col" class="tbl_txt_23">
                                Product Name
                            </th>
                            <th>
                                Invoice Type
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Qty
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Rate
                            </th>
                            <th scope="col" class="tbl_amnt_15">
                                Amount
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $sr = 1;
                        @endphp

                        @foreach($datas as $data)
                            @php
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                                $qty_pg = $rate_pg = $bal = 0;
                                $qty_pg = +$data->qty + +$qty_pg;
                                $rate_pg = +$data->rate + +$rate_pg;
                                $bal = +$data->amount + +$bal;
                            @endphp
                            <tr>
                                <th scope="row">
                                    {{$sr}}
                                </th>
                                <td>
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $data->day_end_date)))}}
                                </td>
                                @php
                                    $set_invoice_id = '';
                                    if($data->type === "Sale Tax"){
                                        $set_invoice_id = 'STPI';
                                    }
                                    else{
                                        $set_invoice_id = 'PI';
                                    }
                                @endphp
                                <td>
                                    <a class="view" data-transcation_id="{{ $set_invoice_id.'-'.$data->id}}" data-toggle="modal" data-target="#myModal" style="cursor:pointer; color: #0099ff;">
                                        {{ $set_invoice_id.'-'.$data->id}}
                                    </a>
                                </td>
                                <td class="align_left text-left tbl_txt_16">
                                    {{$data->party_name}}
                                </td>
                                <td class="align_left text-left tbl_txt_23">
                                    {{$data->product_name}}
                                </td>
                                <td class="align_left text-left tbl_txt_8">
                                    {{ $data->type }}
                                </td>
                                <td>
                                    {{$data->qty}}
                                </td>
                                <td align="right" class="align_right text-right">
                                    {{$data->rate}}
                                </td>
                                <td align="right" class="align_right text-right">
                                    {{$data->amount}}
                                </td>
                            </tr>
                            @php
                                $sr++;
                            @endphp
                        @endforeach
                        </tbody>

                        {{--                            <tfoot>--}}
                        {{--                            <tr class="border-0">--}}
                        {{--                                <th colspan="6" align="right" class="border-0 text-right align_right">--}}
                        {{--                                    Page Total:--}}
                        {{--                                </th>--}}
                        {{--                                <td class="text-center border-0" align="center">--}}
                        {{--                                    {{ $qty_pg }}--}}
                        {{--                                </td>--}}
                        {{--                                <td class="text-right border-0" align="right">--}}
                        {{--                                    {{ number_format($rate_pg,2) }}--}}
                        {{--                                </td>--}}
                        {{--                                <td class="text-right border-0" align="right">--}}
                        {{--                                    {{ number_format($bal,2) }}--}}
                        {{--                                </td>--}}
                        {{--                            </tr>--}}
                        {{--                            </tfoot>--}}

                    </table>

                </div>
                {{--                    <span class="hide_column">{{ $data->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from, 'product_code'=>$search_product, 'account'=>$search_account ])->links() }}</span>--}}
            </div> <!-- white column form ends here -->

        </div><!-- col end -->


    </div><!-- row end -->


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
        var base = '{{ route('product_last_purchase_rate_verification') }}',
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

    <script>
        jQuery("#cancel").click(function () {

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');

            $("#product_code").select2().val(null).trigger("change");
            $("#product_code > option").removeAttr('selected');

            $("#product_name").select2().val(null).trigger("change");
            $("#product_name > option").removeAttr('selected');

            $("#search").val('');

            $("#to").val('');
            $("#from").val('');
        });
    </script>


    <script>
        jQuery("#product_name").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_code").select2("destroy");
            jQuery('#product_code option[value="' + pcode + '"]').prop('selected', true);
            jQuery("#product_code").select2();
            assign_product_parent_value();
        });

        jQuery("#product_code").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_name").select2("destroy");
            jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);
            jQuery("#product_name").select2();
            assign_product_parent_value();
        });


    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account").select2();
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#product_code").append("{!! $pro_code !!}");
            jQuery("#product_name").append("{!! $pro_name !!}");
        });
    </script>
@stop

