@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name"> Work Order List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <!-- <div class="search_form search_form_hidden"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="" name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value=""
                                           autocomplete="off">
                                    <datalist id="browsers">
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->


                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Product
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control" name="product_code" id="product_code">
                                        <option value="">Select Code</option>
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-1">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Product
                                    </label>
                                    <select tabindex="3" class="inputs_up form-control" name="product_name" id="product_name">
                                        <option value="">Select Product</option>
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-1">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input tabindex="4" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off" value="" placeholder="Start Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-1">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        End Date
                                    </label>
                                    <input tabindex="5" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off" value="" placeholder="End Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-1 mt-lg-4 text-right">
                                @include('include.clear_search_button')
                                <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('work_order.create') }}"/>

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
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
                            <th tabindex="-1" scope="col" class="tbl_srl_5">
                                Order No.
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_srl_5">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Recipe Name
                            </th>
                            <th scope="col" class="tbl_txt_11">
                                Finished Good
                            </th>
                            <th scope="col" class="tbl_amnt_5">
                                Order Quantity
                            </th>
                            <th scope="col" class="tbl_srl_5">
                                UOM
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Department/Vendor
                            </th>
                            <th scope="col" class="tbl_txt_12">
                                Supervisor
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Estimated Start Time
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Estimated End Time
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Status
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
                        @forelse($workOrder as $product_recipe)

                            <tr data-work_odr_id="{{$product_recipe->work_odr_id}}">
                                <th scope="row" class="view">
                                    {{$product_recipe->work_odr_id}}
                                </th>
                                <td class="view">
                                    {{$product_recipe->work_odr_id}}
                                </td>
                                <td class="edit">
                                    {{$product_recipe->recipe_name}}
                                </td>
                                <td class="edit">
                                    {{$product_recipe->finished_good}}
                                </td>
                                <td class="edit">
                                    {{$product_recipe->quantity}}
                                </td>
                                <td class="edit">
                                    {{$product_recipe->uom}}
                                </td>
                                <td class="edit">
                                    {{$product_recipe->department}}
                                </td>
                                <td class="edit">
                                    {{$product_recipe->supervisor}}
                                </td>
                                <td class="edit">
                                    {{ date('Y-m-d H:i:s am', strtotime( $product_recipe->start_time )) }}
                                </td>
                                <td class="edit">
                                    {{$product_recipe->end_time}}
                                </td>
                                @php
                                    $ip_browser_info= ''.$product_recipe->odr_ip_adrs.','.str_replace(' ','-',$product_recipe->odr_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl">
                                    {{$product_recipe->created_by}}
                                </td>

                                <td class="usr_prfl">
                                    Status
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

        jQuery(".view").click(function () {
            $("#myModal").modal({show: true});
            {{--jQuery(".pre-loader").fadeToggle("medium");--}}
            {{--jQuery("#table_body").html("");--}}

            {{--var id = jQuery(this).attr("data-id");--}}
            {{--$(".modal-body").load('{{ url('cash_receipt_items_view_details/view/') }}/'+id, function () {--}}
            {{--    jQuery(".pre-loader").fadeToggle("medium");--}}
            {{--    $("#myModal").modal({show:true});--}}
            {{--});--}}
        });
    </script>


    <script>
        jQuery(".edit").click(function () {
            var work_odr_id = jQuery(this).parent('tr').attr("data-work_odr_id");


            {{--                url = '{{ route("work_order.edit"+ ["id"=>":id"]) }}';--}}
                {{--                url = '{{ route("work_order.edit",work_odr_id) }}';--}}
                url = "work_order/" + work_odr_id + "/edit";

            {{--    --}}{{--url = url.replace(':id', work_odr_id);--}}
                {{--    --}}{{--cosole.log(url);--}}
                window.location = url;
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


@endsection

