@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Budget Planning List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search) || !empty($search_order_list) |!empty($search_zone) |!empty($search_region) || !empty($search_product) || !empty($search_to) || !empty
            ($search_from) ) ? '' : 'search_form_hidden' }}">
-->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('budget_planning_list') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($budget_plans as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                        </div>
                                    </div> <!-- left column ends here -->


                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Order List
                                                    </label>
                                                    <select tabindex="2" class="inputs_up  form-control" name="order_list" id="order_list">
                                                        <option value="">Select Order List</option>
                                                        @foreach($order_lists as $order_list)
                                                            <option
                                                                value="{{$order_list->ol_id}}" {{ $order_list->ol_id == $search_order_list ? 'selected="selected"' : ''
                                                                }}>{{$order_list->ol_order_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Zone
                                                    </label>
                                                    <select tabindex="2" class="inputs_up  form-control" name="zone" id="zone">
                                                        <option value="">Select Zone</option>
                                                        @foreach($zones as $zone)
                                                            <option
                                                                value="{{$zone->id}}" {{ $zone->id == $search_zone ? 'selected="selected"' : ''
                                                                }}>{{$zone->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Region
                                                    </label>
                                                    <select tabindex="2" class="inputs_up  form-control" name="zone" id="zone">
                                                        <option value="">Select Region</option>
                                                        @foreach($regions as $region)
                                                            <option
                                                                value="{{$region->id}}" {{ $region->id == $search_region ? 'selected="selected"' : ''
                                                                }}>{{$region->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Code
                                                    </label>
                                                    <select tabindex="3" class="inputs_up form-control" name="product" id="product">
                                                        <option value="">Select Code</option>
                                                        @foreach($products as $product)
                                                            <option
                                                                value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : '' }}>{{$product->pro_p_code}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Product
                                                    </label>
                                                    <select tabindex="4" class="inputs_up  form-control" name="product_name" id="product_name">
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{$product->pro_p_code}}" {{ $product->pro_p_code == $search_product ? 'selected="selected"' : ''
                                                                }}>{{$product->pro_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Start Date
                                                    </label>
                                                    <input tabindex="5" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        End Date
                                                    </label>
                                                    <input tabindex="6" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="7" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="8" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="9" class="save_button form-control" href="{{ route('budget_planning') }}" role="button">
                                                        <i class="fa fa-plus"></i> Budget Planning
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </form>


                            <form name="edit" id="edit" action="{{ route('edit_account') }}" method="post">
                                @csrf
                                <input tabindex="10" name="account_id" id="account_id" type="hidden">
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
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_10">
                                Budget Name
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                Order List Name
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                Zone
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_8">
                                Region
                            </th>

                            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                                Product Name
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_8">
                                QTY
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_8">
                                Rate
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_8">
                                Material Rate
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_8">
                                Expense Rate
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_8">
                                Total Amount
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_8">
                                Material Amount
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_8">
                                Expense Amount
                            </th>
                            {{--                                    <th scope="col" align="center">Expense</th>--}}
                            {{--                                    <th scope="col" align="center">Trade Disc%</th>--}}
                            {{--                                    <th scope="col" align="center">Trade Disc</th>--}}
                            {{--                                    <th scope="col" align="center">Value of Supply</th>--}}
                            {{--                                    <th scope="col" align="center">Sale tax</th>--}}
                            {{--                                    <th scope="col" align="center">Special Disc%</th>--}}
                            {{--                                    <th scope="col" align="center">Special Disc</th>--}}
                            {{--                                    <th scope="col" align="center">Grand Total</th>--}}

                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created By
                            </th>
                            {{--                                    <th scope="col" align="center">Remarks</th>--}}
                            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Date/Time</th>--}}
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $ttlPrc = $cashPaid = 0;
                        @endphp
                        @forelse($datas as $invoice)

                            <tr>
                                <td class="align_center text-center tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td class="align_center text-center tbl_srl_10">
                                    {{$invoice->fbp_budget_name}}
                                </td>
                                <td class="align_center text-center tbl_srl_10">
                                    {{$invoice->order_title}}
                                </td>
                                <td nowrap class="align_center text-center tbl_amnt_10">
                                    {{$invoice->zone}}
                                </td>

                                <td class="align_left text-left tbl_txt_10">
                                    {{$invoice->region}}
                                </td>

                                <td class="align_left text-left tbl_txt_10">
                                    {{$invoice->fbp_product_name}}
                                </td>
                                <td class="align_left text-left tbl_txt_8">
                                    {!!  $invoice->fbp_qty !!}
                                </td>
                                @php
                                    $ttlPrc = +($invoice->fbp_amount) + +$ttlPrc;
                                @endphp
                                <td class="align_right text-right tbl_amnt_8">
                                    {{$invoice->fbp_rate !=0 ? number_format($invoice->fbp_rate,2):''}}
                                </td>
                                <td class="align_right text-right tbl_amnt_8">
                                    {{$invoice->fbp_material_rate !=0 ? number_format($invoice->fbp_material_rate,2):''}}
                                </td>
                                <td class="align_right text-right tbl_amnt_8">
                                    {{$invoice->fbp_expense_rate !=0 ? number_format($invoice->fbp_expense_rate,2):''}}
                                </td>
                                <td class="align_right text-right tbl_amnt_8">
                                    {{$invoice->fbp_amount !=0 ? number_format($invoice->fbp_amount,2):''}}
                                </td>
                                <td class="align_right text-right tbl_amnt_8">
                                    {{$invoice->fbp_material_amount !=0 ? number_format($invoice->fbp_material_amount,2):''}}
                                </td>
                                <td class="align_right text-right tbl_amnt_8">
                                    {{$invoice->fbp_expense_amount !=0 ? number_format($invoice->fbp_expense_amount,2):''}}
                                </td>
                                {{--                                    <td class="align_right">{{$invoice->si_expense !=0 ? number_format($invoice->si_expense,2):''}}</td>--}}
                                {{--                                    <td class="align_right">{{$invoice->si_trade_disc_percentage !=0 ? number_format($invoice->si_trade_disc_percentage,2):''}}</td>--}}
                                {{--                                    <td class="align_right">{{$invoice->si_trade_disc !=0 ? number_format($invoice->si_trade_disc,2):''}}</td>--}}
                                {{--                                    <td class="align_right">{{$invoice->si_value_of_supply !=0 ? number_format($invoice->si_value_of_supply,2):''}}</td>--}}
                                {{--                                    <td class="align_right">{{$invoice->si_sales_tax !=0 ? number_format($invoice->si_sales_tax,2):''}}</td>--}}
                                {{--                                    <td class="align_right">{{$invoice->si_special_disc_percentage !=0 ? number_format($invoice->si_special_disc_percentage,2):''}}</td>--}}
                                {{--                                    <td class="align_right">{{$invoice->si_special_disc !=0 ? number_format($invoice->si_special_disc,2):''}}</td>--}}
                                {{--                                    <td class="align_right">{{$invoice->si_grand_total !=0 ? number_format($invoice->si_grand_total,2):''}}</td>--}}
                                {{--                                    @php--}}
                                {{--                                        $cashPaid = +($invoice->si_cash_received) + +$cashPaid;--}}
                                {{--                                    @endphp--}}
                                {{--                                <td class="align_right text-right tbl_amnt_5">--}}
                                {{--                                    {{$invoice->si_cash_received !=0 ? number_format($invoice->si_cash_received,2):''}}--}}
                                {{--                                </td>--}}

                                @php
                                    $ip_browser_info= ''.$invoice->fbp_ip_adrs.','.str_replace(' ','-',$invoice->fbp_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$invoice->user_name}}
                                </td>

                                {{--                                    <td class="align_left">{{$invoice->si_remarks}}</td>--}}
                                {{--{{$invoice->si_remarks == '' ? 'N/A' : $invoice->si_remarks}}--}}
                                {{--<td align="center">{{$invoice->si_datetime}}</td>--}}

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="15">
                                    <center><h3 style="color:#554F4F">No Budget</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr>
                            <th colspan="8" class="align_right text-right border-0">
                                Per Page Total:-
                            </th>
                            <td class="align_right text-right border-0">
                                {{ number_format($ttlPrc,2) }}
                            </td>
                            {{--                            <td class="align_right text-right border-0">--}}
                            {{--                                {{ number_format($cashPaid,2) }}--}}
                            {{--                            </td>--}}
                        </tr>
                        </tfoot>


                    </table>
                </div>
                <span
                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'order_list'=>$search_order_list,'zone'=>$search_zone,'region'=>$search_region, 'product_code'=>$search_product, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Order Items Invoice Detail</h4>
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
        var base = '{{ route('budget_planning_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    {{--    <script>--}}
    {{--        // jQuery("#invoice_no").blur(function () {--}}
    {{--        jQuery(".view").click(function () {--}}

    {{--            jQuery("#table_body").html("");--}}

    {{--            var id = jQuery(this).attr("data-id");--}}

    {{--            $('.modal-body').load('{{url("order_items_items_view_details/view/") }}' + '/' + id, function () {--}}
    {{--                $('#myModal').modal({show: true});--}}
    {{--            });--}}

    {{--        });--}}
    {{--    </script>--}}

    <script>
        jQuery(".edit").click(function () {

            var account_id = jQuery(this).attr("data-id");

            jQuery("#account_id").val(account_id);
            jQuery("#edit").submit();
        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#account").select2().val(null).trigger("change");
            $("#account > option").removeAttr('selected');

            $("#project").select2().val(null).trigger("change");
            $("#project > option").removeAttr('selected');

            $("#product").select2().val(null).trigger("change");
            $("#product > option").removeAttr('selected');

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

            jQuery("#product").select2("destroy");

            // jQuery("#product > option").each(function () {
            //     jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery('#product option[value="' + pcode + '"]').prop('selected', true);
            jQuery("#product").select2();

        });


        jQuery("#product").change(function () {
            var pcode = jQuery('option:selected', this).val();

            jQuery("#product_name").select2("destroy");

            // jQuery("#product_name > option").each(function () {
            jQuery('#product_name option[value="' + pcode + '"]').prop('selected', true);
            // });

            jQuery("#product_name").select2();

        });


    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account").select2();
            jQuery("#project").select2();
            jQuery("#product").select2();
            jQuery("#product_name").select2();
        });
    </script>

@endsection

