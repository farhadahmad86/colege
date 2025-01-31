@extends('extend_index')

@section('content')



    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name"> Manufacturing Plan Stock Position List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <!-- <div class="search_form search_form_hidden"> -->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                            <form class="prnt_lst_frm" action="{{ route('stock_position_list') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
{{--                                                   value="{{ isset($search) ? $search : '' }}"--}}
                                                   autocomplete="off">
{{--                                            <datalist id="browsers">--}}
{{--                                                --}}{{--                                                    @foreach($party as $value)--}}
{{--                                                --}}{{--                                                        <option value="{{$value}}">--}}
{{--                                                --}}{{--                                                    @endforeach--}}
{{--                                            </datalist>--}}
{{--                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                                            <input type="checkbox" name="check_desktop" id="check_desktop" value="1" {{$check_desktop==1 ? 'checked':'' }}>--}}
{{--                                            <label class="d-inline" for="check_desktop">Desktop Invoice</label>--}}
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                ID Search
                                            </label>
                                            <input type="search" class="inputs_up form-control" name="mid" id="mid" placeholder="Search ..."
{{--                                                   value="{{ isset($mid) ? $mid : '' }}"--}}
                                                   autocomplete="off">

                                        </div>
                                    </div> <!-- left column ends here -->


                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        PO Title
                                                    </label>
                                                    <select class="inputs_up  form-control" name="po" id="po">
                                                        <option value="">Select PO Title</option>
                                                        @foreach($pos as $poi)
                                                            <option value="{{$poi->opo_po_no}}">{{$poi->opo_po_no}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>


                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Party
                                                    </label>
                                                    <select class="inputs_up  form-control" name="account" id="account">
                                                        <option value="">Select party</option>
                                                        @foreach($accounts as $account)
                                                            <option value="{{$account->account_uid}}">{{$account->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Finish Goods
                                                    </label>
                                                    <select class="inputs_up form-control" name="product" id="product">
                                                        <option value="">Select Code</option>
                                                        @foreach($products as $product)
                                                            <option value="{{$product->pro_code}}">{{$product->pro_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Start Date
                                                    </label>
                                                    <input type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
{{--                                                           <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?>--}}
                                                           placeholder="Start Date ......" />
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>


                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        End Date
                                                    </label>
                                                    <input type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
{{--                                                           <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?>--}}
                                                           placeholder="End Date ......" />
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
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

                                                    <a tabindex="8" class="save_button form-control" href="{{ route('batch_work_order.create') }}" role="button">
                                                        <i class="fa fa-plus"></i> Work Order
                                                    </a>

{{--                                                    @include('include/print_button')--}}

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{--                            <form name="edit" id="edit" action="{{ route('edit_product_recipe') }}" method="post">--}}
                            {{--                                @csrf--}}
                            {{--                                <input name="recipe_id" id="recipe_id" type="hidden">--}}
                            {{--                            </form>--}}

                            {{--                            <form name="delete" id="delete" action="{{ route('delete_product_recipe') }}" method="post">--}}
                            {{--                                @csrf--}}
                            {{--                                <input name="del_recipe_id" id="del_recipe_id" type="hidden">--}}
                            {{--                            </form>--}}

                        </div>

                    </div>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_3">
                                Sr
                            </th>
                            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_3">
                                ID
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                PO Title
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                Party
                            </th>

                            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                Finished Good
                            </th>


                            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                Product Name
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                                UOM
                            </th>
{{--                            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
{{--                                Comsumption--}}
{{--                            </th>--}}
                            <th scope="col" align="center" class="align_center text-center tbl_srl_3">
                                Required
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_srl_3">
                                Issue
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_srl_3">
                                Balance Req
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_srl_3">
                                InHand
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_srl_3">
                                Position
                            </th>






{{--                            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
{{--                                Order Quantity--}}
{{--                            </th>--}}
                            <th scope="col" align="center" class="text-center align_center tbl_txt_5">
                                Status
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                Estimated Start Time
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                                Estimated End Time
                            </th>


                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $ttlPrc=0;
                        @endphp
                        @forelse($datas as $index=>$product_recipe)

                            <tr data-work_odr_id="{{$product_recipe->odr_id}}">
                                <td class="align_center text-center tbl_srl_3">
                                    {{$sr}}
                                </td>
                                <td class="align_center text-center tbl_srl_3">
                                    {{$product_recipe->odr_id}}
                                </td>
                                <td class="align_center text-left tbl_srl_10">
                                    {{$product_recipe->opo_po_no}}
                                </td>
                                <td class="align_left text-left tbl_txt_10 edit">
                                    {{$product_recipe->account_name}}
                                </td>
                                <td class="align_left text-left tbl_txt_10 edit">
                                    {{$product_recipe->pfg_pro_name}}
                                </td>
                                <td class="align_left text-left tbl_txt_10 edit">
                                    {{$product_recipe->brs_pro_name}}
                                </td>

                                <td class="align_center text-left tbl_amnt_5 edit">
                                    {{$product_recipe->brs_uom}}
                                </td>
{{--                                <td class="align_center text-right tbl_srl_5 edit">--}}
{{--                                    {{$product_recipe->brs_recipe_consumption}}--}}
{{--                                </td>--}}


                                <td class="align_left text-right tbl_txt_3 edit">
                                    {{$product_recipe->brs_required_production_qty}}
                                </td>

                                @php
                                    $required = $product_recipe->brs_required_production_qty;
                                    $remaining = $product_recipe->brs_required_production_qty;
                                    $issue = $required - $remaining;
                                @endphp
                                <td class="align_left text-right tbl_txt_3 edit">
                                    {{$issue}}
                                </td>
                                <td class="align_left text-right tbl_txt_3 edit">
                                    {{$product_recipe->brs_required_remain_production_qty}}
                                </td>


                                @php
                                    $ttlPrc = +($qty[$index]) + +$ttlPrc;
                                @endphp

                                <td class="align_left text-right tbl_txt_3 edit">
{{--                                    {{$qty[$index]!=0 ? number_format($qty[$index],3):''}}--}}
                                    {{ number_format($qty[$index],3)}}
                                </td>




                                @php
                                    $inhand = number_format($qty[$index],3);
                                    $remaining = $product_recipe->brs_required_production_qty;
                                    $position = $inhand - $remaining;
                                @endphp
                                <td class="align_left text-right tbl_txt_3 edit">
                                    {{$position}}
                                </td>

                                <td class="align_left usr_prfl text-left tbl_txt_5">
                                    {{$product_recipe->odr_status}}
                                </td>
                                <td class="align_right text-center tbl_txt_10 edit">
                                    {{ date('d-m-Y H:i:s', strtotime( $product_recipe->odr_estimated_start_time )) }}
                                </td>
                                <td class="align_center text-center tbl_txt_10 edit">
                                    {{date('d-m-Y H:i:s', strtotime($product_recipe->odr_estimated_end_time))}}
                                </td>
{{--                                @php--}}
{{--                                    $ip_browser_info= ''.$product_recipe->odr_ip_adrs.','.str_replace(' ','-',$product_recipe->odr_brwsr_info).'';--}}
{{--                                @endphp--}}

                                {{--                                <td class="align_left usr_prfl text-left tbl_txt_8" data-usr_prfl="{{ $product_recipe->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">--}}
{{--                                <td class="align_left usr_prfl text-left tbl_txt_8">--}}
{{--                                    {{$product_recipe->created_by}}--}}
{{--                                </td>--}}

{{--                                <td class="align_left usr_prfl text-center tbl_txt_8">--}}
{{--                                    {{$product_recipe->recipe_type}}--}}
{{--                                </td>--}}



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

            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg mdl_wdth" role="document">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Stock Movement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                        <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl"><!-- invoice scroll box start -->
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt"><!-- invoice content start -->
                                    <div class="invoice_row"><!-- invoice row start -->

                                        <div class="invoice_col basis_col_100 gnrl-mrgn-pdng"><!-- invoice column start -->
                                            <div class="pro_tbl_con for_voucher_tbl"><!-- product table container start -->
                                                <div class="pro_tbl_bx"><!-- product table box start -->
                                                    <table class="table  gnrl-mrgn-pdng" id="">

                                                        <thead>
                                                        <tr>
                                                            <th class="text-center tbl_srl_4"> Sr.</th>
                                                            <th class="text-center tbl_srl_9"> Code</th>
                                                            <th class="text-center tbl_txt_18"> Title</th>
                                                            <th class="text-center tbl_txt_18"> Product Remarks</th>
                                                            <th class="text-center tbl_srl_6"> UOM</th>
                                                            <th class="text-center tbl_srl_10"> Recipe Consumption</th>
                                                            <th class="text-center tbl_srl_8"> Reqd. Production Qty</th>
                                                            <th class="text-center tbl_srl_10"> In Hand Stock</th>
                                                            <th class="text-center tbl_srl_8"> Quantity to Move</th>
                                                            <th class="text-center tbl_srl_10"> Single Product Move</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody id="budgetRawStock">
                                                        <tr>
                                                            <td class="text-center tbl_srl_4">1</td>
                                                            <td class="text-center tbl_srl_9">536035</td>
                                                            <td class="text-left tbl_txt_18">Pro 1</td>
                                                            <td class="text-left tbl_txt_18"></td>
                                                            <td class="text-center tbl_srl_6">KG</td>
                                                            <td class="text-right tbl_srl_10"><input type="text" class="inputs_up_tbl text-right recipe_qty" data-rawpercentval="44"
                                                                                                     data-ttlquantityid="536035" value="2.200" readonly=""></td>
                                                            <td class="text-right tbl_srl_8"><input type="text" class="inputs_up_tbl text-right" id="budget536035rawStock" value="0.440" readonly="">
                                                            </td>
                                                            <td class="text-right tbl_srl_10">3.000</td>
                                                            <td class="text-right tbl_srl_8">
                                                                <input type="text" class="inputs_up_tbl text-right" placeholder="Add Quantity" value="">
                                                            </td>
                                                            <td class="text-right tbl_srl_10">
                                                                <button class="btn btn-sm btn-success">
                                                                    <i class="fa fa-product-hunt"></i> Transfer
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center tbl_srl_4">2</td>
                                                            <td class="text-center tbl_srl_9">394723</td>
                                                            <td class="text-left tbl_txt_18">Pro 2</td>
                                                            <td class="text-left tbl_txt_18"></td>
                                                            <td class="text-center tbl_srl_6">KG</td>
                                                            <td class="text-right tbl_srl_10"><input type="text" class="inputs_up_tbl text-right recipe_qty" data-rawpercentval="60"
                                                                                                     data-ttlquantityid="394723" value="3.000" readonly=""></td>
                                                            <td class="text-right tbl_srl_8"><input type="text" class="inputs_up_tbl text-right" id="budget394723rawStock" value="0.600" readonly="">
                                                            </td>
                                                            <td class="text-right tbl_srl_10">6.000</td>
                                                            <td class="text-right tbl_srl_8">
                                                                <input type="text" class="inputs_up_tbl text-right" placeholder="Add Quantity" value="">
                                                            </td>
                                                            <td class="text-right tbl_srl_10">
                                                                <button class="btn btn-sm btn-success">
                                                                    <i class="fa fa-product-hunt"></i> Transfer
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center tbl_srl_4">3</td>
                                                            <td class="text-center tbl_srl_9">830309</td>
                                                            <td class="text-left tbl_txt_18">Pro 3</td>
                                                            <td class="text-left tbl_txt_18"></td>
                                                            <td class="text-center tbl_srl_6">KG</td>
                                                            <td class="text-right tbl_srl_10"><input type="text" class="inputs_up_tbl text-right recipe_qty" data-rawpercentval="40"
                                                                                                     data-ttlquantityid="830309" value="2.000" readonly=""></td>
                                                            <td class="text-right tbl_srl_8"><input type="text" class="inputs_up_tbl text-right" id="budget830309rawStock" value="0.400" readonly="">
                                                            </td>
                                                            <td class="text-right tbl_srl_10">8.000</td>
                                                            <td class="text-right tbl_srl_8">
                                                                <input type="text" class="inputs_up_tbl text-right" placeholder="Add Quantity" value="">
                                                            </td>
                                                            <td class="text-right tbl_srl_10">
                                                                <button class="btn btn-sm btn-success">
                                                                    <i class="fa fa-product-hunt"></i> Transfer
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center tbl_srl_4">4</td>
                                                            <td class="text-center tbl_srl_9">249399</td>
                                                            <td class="text-left tbl_txt_18">Pro 4</td>
                                                            <td class="text-left tbl_txt_18"></td>
                                                            <td class="text-center tbl_srl_6">KG</td>
                                                            <td class="text-right tbl_srl_10"><input type="text" class="inputs_up_tbl text-right recipe_qty" data-rawpercentval="34"
                                                                                                     data-ttlquantityid="249399" value="1.700" readonly=""></td>
                                                            <td class="text-right tbl_srl_8"><input type="text" class="inputs_up_tbl text-right" id="budget249399rawStock" value="0.340" readonly="">
                                                            </td>
                                                            <td class="text-right tbl_srl_10">8.000</td>
                                                            <td class="text-right tbl_srl_8">
                                                                <input type="text" class="inputs_up_tbl text-right" placeholder="Add Quantity" value="">
                                                            </td>
                                                            <td class="text-right tbl_srl_10">
                                                                <button class="btn btn-sm btn-success">
                                                                    <i class="fa fa-product-hunt"></i> Transfer
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center tbl_srl_4">5</td>
                                                            <td class="text-center tbl_srl_9">142345489079</td>
                                                            <td class="text-left tbl_txt_18">Product 7</td>
                                                            <td class="text-left tbl_txt_18"></td>
                                                            <td class="text-center tbl_srl_6">KG</td>
                                                            <td class="text-right tbl_srl_10"><input type="text" class="inputs_up_tbl text-right recipe_qty" data-rawpercentval="30"
                                                                                                     data-ttlquantityid="142345489079" value="1.500" readonly=""></td>
                                                            <td class="text-right tbl_srl_8"><input type="text" class="inputs_up_tbl text-right" id="budget142345489079rawStock" value="0.300"
                                                                                                    readonly=""></td>
                                                            <td class="text-right tbl_srl_10">0.000</td>
                                                            <td class="text-right tbl_srl_8">
                                                                <input type="text" class="inputs_up_tbl text-right" placeholder="Add Quantity" value="">
                                                            </td>
                                                            <td class="text-right tbl_srl_10">
                                                                <button class="btn btn-sm btn-success">
                                                                    <i class="fa fa-product-hunt"></i> Transfer
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        </tbody>

                                                    </table>

                                                </div><!-- product table box end -->
                                            </div><!-- product table container end -->
                                        </div><!-- invoice column end -->

                                    </div><!-- invoice row end -->

                                </div><!-- invoice content end -->
                            </div><!-- invoice scroll box end -->


                        </div><!-- invoice box end -->
                    </div><!-- invoice container end -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">All Stock Transfer</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

        // jQuery(".view").click(function () {
        //     $("#myModal").modal({show: true});
        {{--jQuery(".pre-loader").fadeToggle("medium");--}}
        {{--jQuery("#table_body").html("");--}}

        {{--var id = jQuery(this).attr("data-id");--}}
        {{--$(".modal-body").load('{{ url('cash_receipt_items_view_details/view/') }}/'+id, function () {--}}
        {{--    jQuery(".pre-loader").fadeToggle("medium");--}}
        {{--    $("#myModal").modal({show:true});--}}
        {{--});--}}
        // });
    </script>


    <script>
        {{--jQuery(".edit").click(function () {--}}
        {{--    var work_odr_id = jQuery(this).parent('tr').attr("data-work_odr_id"),--}}
        {{--        url = '{{ route("work_order.edit", ["id"=>":id"]) }}';--}}
        {{--    url = url.replace(':id', work_odr_id);--}}
        {{--    window.location = url;--}}

        {{--});--}}

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
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");
            alert(id);
            {{--$('.modal-body').load('{{url("get_budget_view_details/view/") }}' + '/' + id, function () {--}}

            // $('#myModal').modal({show: true});
            // });
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: '{{url("get_budget_view_details/view") }}',
                data: {id: id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    alert(2);
                    $('#myModal').modal({show: true})
                    // $.each(data, function (index, value) {

                    {{--            var qty;--}}
                    {{--            var rate;--}}
                    {{--            var discount;--}}
                    {{--            var saletax;--}}
                    {{--            var amount;--}}

                    {{--            if(value['sii_qty']==0){--}}
                    {{--                qty='';--}}
                    {{--            }else{--}}
                    {{--                qty=value['sii_qty'];--}}
                    {{--            }--}}
                    {{--            if(value['sii_rate']==0){--}}
                    {{--                rate='';--}}
                    {{--            }else{--}}
                    {{--                rate=value['sii_rate'];--}}
                    {{--            }--}}
                    {{--            if(value['sii_discount']==0){--}}
                    {{--                discount='';--}}
                    {{--            }else{--}}
                    {{--                discount=value['sii_discount'];--}}
                    {{--            }--}}
                    {{--            if(value['sii_saletax']==0){--}}
                    {{--                saletax='';--}}
                    {{--            }else{--}}
                    {{--                saletax=value['sii_saletax'];--}}
                    {{--            }--}}
                    {{--            if(value['sii_amount']==0){--}}
                    {{--                amount='';--}}
                    {{--            }else{--}}
                    {{--                amount=value['sii_amount'];--}}
                    {{--            }--}}

                    {{--            jQuery("#table_body").append(--}}
                    {{--            '<div class="itm_vchr form_manage">' +--}}
                    {{--            '<div class="form_header">' +--}}
                    {{--            '<h4 class="text-white file_name">' +--}}
                    {{--            '<span class="db sml_txt"> Product #: </span>' +--}}
                    {{--            '' + value['sii_product_code'] + '' +--}}
                    {{--            '</h4>' +--}}
                    {{--            '</div>' +--}}
                    {{--            '<div class="table-responsive">' +--}}
                    {{--            '<table class="table table-bordered">' +--}}
                    {{--            '<thead>' +--}}
                    {{--            '<tr>' +--}}
                    {{--            '<th scope="col" align="center" class="width_2">Product Name</th>' +--}}
                    {{--            '<th scope="col" align="center" class="width_5">Rate</th>' +--}}
                    {{--            '<th scope="col" align="center" class="width_5 text-right">Quantity</th>' +--}}
                    {{--            '</tr>' +--}}
                    {{--            '</thead>' +--}}
                    {{--            '<tbody>' +--}}
                    {{--            '<tr>' +--}}
                    {{--            '<td class="align_left"> <div class="max_txt"> ' + value['sii_product_name'] + '</div> </td>' +--}}
                    {{--            '<td class="align_left">' + rate + '</td>' +--}}
                    {{--            '<td class="align_left text-right">' + qty + '</td>' +'</td>' +--}}
                    {{--            '</tr>' +--}}
                    {{--            '</tbody>' +--}}
                    {{--            '<tfoot class="side-section">'+--}}
                    {{--            '<tr class="border-0">'+--}}
                    {{--            '<td colspan="7" align="right" class="p-0 border-0">'+--}}
                    {{--            '<table class="m-0 p-0 chk_dmnd">'+--}}
                    {{--            '<tfoot>'+--}}
                    {{--            '<tr>'+--}}
                    {{--            '<td class="border-top-0 border-right-0">'+--}}
                    {{--            '<label class="total-items-label text-right">Discounts</label>'+--}}
                    {{--            '</td>'+--}}
                    {{--            '<td class="text-right border-top-0 border-left-0">'+--}}
                    {{--            ((discount != null && discount != "") ? discount : '0.00') +--}}
                    {{--            '</td>'+--}}
                    {{--            '</tr>'+--}}
                    {{--            '<tr>'+--}}
                    {{--            '<td colspan="" align="right" class="border-right-0">'+--}}
                    {{--            '<label class="total-items-label text-right">Sale Tax</label>'+--}}
                    {{--            '</td>'+--}}
                    {{--            '<td class="text-right border-left-0" align="right">'+--}}
                    {{--            ((saletax != null && saletax != "") ? saletax : '0.00') +--}}
                    {{--            '</td>'+--}}
                    {{--            '</tr>'+--}}
                    {{--            '<tr>'+--}}
                    {{--            '<td colspan="" align="right" class="border-right-0">'+--}}
                    {{--            '<label class="total-items-label text-right">Total Amount</label>'+--}}
                    {{--            '</td>'+--}}
                    {{--            '<td class="text-right border-left-0" align="right">'+--}}
                    {{--            ((amount != null && amount != "") ? amount : '0.00') +--}}
                    {{--            '</td>'+--}}
                    {{--            '</tr>'+--}}
                    {{--            '</tfoot>'+--}}
                    {{--            '</table>'+--}}
                    {{--            '</td>'+--}}
                    {{--            '</tr>'+--}}
                    {{--            '</tfoot>'+--}}
                    {{--            '</table>' +--}}
                    {{--            '</div>' +--}}
                    {{--            '<div class="itm_vchr_rmrks '+((value['sii_remarks'] != null && value['sii_remarks'] != "") ? '' : 'search_form_hidden') +'">' +--}}
                    {{--            '<h5 class="title_cus bold"> Remarks: </h5>' +--}}
                    {{--            '<p class="m-0 p-0">' + value['sii_remarks'] + '</p>' +--}}
                    {{--            '</div>' +--}}
                    {{--            '<div class="input_bx_ftr"></div>' +--}}
                    {{--            '</div>');--}}

                    {{--        });--}}
                    {{--    },--}}
                    {{--    error: function (jqXHR, textStatus, errorThrown) {--}}
                    {{--        // alert(jqXHR.responseText);--}}
                    {{--        // alert(errorThrown);--}}
                }
            });
        });
    </script>

@endsection

